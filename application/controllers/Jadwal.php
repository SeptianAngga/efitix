<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('username')) {
            redirect('auth/login');
        }
        $this->load->model('Jadwal_model');
        $this->load->model('Pekerja_model');
        $this->load->model('Notifikasi_model');
        $this->load->model('Prediksi_model');
    }

    public function index($offset = 0) {
        $from = $this->input->get('from');
        if (empty($from) || !strtotime($from)) {
            $from = date('Y-m-d');
        }

        $tanggal = date('Y-m-d', strtotime("$from +$offset day"));

        $data['title'] = 'Jadwal Pekerja';
        $data['tanggal'] = $tanggal;
        $data['jadwal'] = $this->Jadwal_model->get_by_date($tanggal);
        $data['username'] = $this->session->userdata('username');
        $data['user_id'] = $this->session->userdata('user_id');
        $data['level'] = $this->session->userdata('level');
        $data['keterangan_sisa'] = [];
        $data['notif_terpenuhi'] = false;

        $prediksi = $this->Prediksi_model->get_by_tanggal($tanggal);

        if ($prediksi) {
            $tipe_shift = [
                ['jabatan' => 'Tiket', 'shift' => 'Pagi', 'target' => ceil($prediksi->tiket / 2)],
                ['jabatan' => 'Tiket', 'shift' => 'Malam', 'target' => ceil($prediksi->tiket / 2)],
                ['jabatan' => 'Validasi', 'shift' => 'Pagi', 'target' => ceil($prediksi->validasi / 2)],
                ['jabatan' => 'Validasi', 'shift' => 'Malam', 'target' => ceil($prediksi->validasi / 2)],
                ['jabatan' => 'Kebersihan', 'shift' => 'Pagi', 'target' => ceil($prediksi->kebersihan / 2)],
                ['jabatan' => 'Kebersihan', 'shift' => 'Sore', 'target' => ceil($prediksi->kebersihan / 2)],
            ];

            foreach ($tipe_shift as $ts) {
                $terisi = $this->Prediksi_model->count_jadwal_by_shift($tanggal, $ts['jabatan'], $ts['shift']);
                $sisa = $ts['target'] - $terisi;
                if ($sisa > 0) {
                    $data['keterangan_sisa'][] = "{$ts['jabatan']} {$ts['shift']}: {$sisa}";
                }
            }

            if (empty($data['keterangan_sisa']) && !empty($data['jadwal'])) {
                $data['notif_terpenuhi'] = true;
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('admin/jadwal', $data);
        $this->load->view('templates/footer');
    }

    public function tambah() {
        $data['title'] = 'Tambah Jadwal';
        $data['username'] = $this->session->userdata('username');
        $tanggal = $this->input->get('from') ?? date('Y-m-d');

        $pekerja_sudah_dijadwalkan = $this->Jadwal_model->get_pekerja_ids_by_tanggal($tanggal);
        $data['tanggal'] = $tanggal;

        $prediksi = $this->Prediksi_model->get_by_tanggal($tanggal);
        $urutan = [];

        if ($prediksi) {
            $urutan = [
                ['jabatan' => 'Tiket', 'shift' => 'Pagi'],
                ['jabatan' => 'Tiket', 'shift' => 'Malam'],
                ['jabatan' => 'Validasi', 'shift' => 'Pagi'],
                ['jabatan' => 'Validasi', 'shift' => 'Malam'],
                ['jabatan' => 'Kebersihan', 'shift' => 'Pagi'],
                ['jabatan' => 'Kebersihan', 'shift' => 'Sore'],
            ];
        }

        $pekerja = $this->Pekerja_model->get_pekerja_only();
        $tersaring = [];

        foreach ($urutan as $ur) {
            foreach ($pekerja as $p) {
                if (
                    $p->jabatan == $ur['jabatan'] &&
                    $p->shift == $ur['shift'] &&
                    !in_array($p->id, $pekerja_sudah_dijadwalkan) &&
                    !in_array($p, $tersaring)
                ) {
                    $tersaring[] = $p;
                }
            }
        }

        foreach ($pekerja as $p) {
            if (!in_array($p->id, $pekerja_sudah_dijadwalkan) && !in_array($p, $tersaring)) {
                $tersaring[] = $p;
            }
        }

        $data['pekerja'] = $tersaring;

        $this->load->view('templates/header', $data);
        $this->load->view('admin/jadwal_form', $data);
        $this->load->view('templates/footer');
    }

    public function simpan() {
        $tanggal = $this->input->post('tanggal');
        $pekerja_id = $this->input->post('pekerja_id');

        $pekerja = $this->db->get_where('pekerja', ['id' => $pekerja_id])->row();
        if (!$pekerja) {
            $this->session->set_flashdata('error', 'Data pekerja tidak ditemukan.');
            redirect('jadwal/tambah?from=' . $tanggal);
        }

        $shift = $pekerja->shift;

        $ada = $this->db->get_where('jadwal', [
            'pekerja_id' => $pekerja_id,
            'tanggal' => $tanggal
        ])->row();

        if ($ada) {
            $this->session->set_flashdata('error', 'Jadwal sudah ada untuk pekerja ini di tanggal tersebut.');
            redirect('jadwal/tambah?from=' . $tanggal);
        }

        $data = [
            'tanggal' => $tanggal,
            'pekerja_id' => $pekerja_id,
            'shift' => $shift,
            'status_kehadiran' => 'Belum',
            'konfirmasi' => 0
        ];
        $this->Jadwal_model->insert($data);

        $pesan = "Segera konfirmasi kehadiran Anda untuk tanggal " . date('d-m-Y', strtotime($tanggal)) . " (Shift: $shift)";
        $this->db->insert('notifikasi', [
            'pekerja_id' => $pekerja_id,
            'pesan' => $pesan,
            'tipe' => 'warning',
            'waktu' => date('H:i:s'),
            'status' => 'belum_dibaca'
        ]);

        redirect('jadwal?from=' . $tanggal);
    }

    public function hapus($id) {
        $this->Jadwal_model->delete($id);
        redirect('jadwal');
    }

    public function update_status() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');

        $this->db->where('id', $id);
        $updated = $this->db->update('jadwal', ['status_kehadiran' => $status]);

        echo json_encode(['success' => $updated]);
    }

    public function get_shift_by_pekerja() {
        $pekerja_id = $this->input->post('pekerja_id');
        $this->db->select('shift');
        $this->db->from('pekerja');
        $this->db->where('id', $pekerja_id);
        $result = $this->db->get()->row();

        echo json_encode(['shift' => $result ? $result->shift : '']);
    }
}