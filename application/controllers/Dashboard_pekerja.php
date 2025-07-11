<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_pekerja extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('level') != 'pekerja') {
            redirect('auth/login');
        }

        $this->load->model('Pekerja_dashboard_model');
        $this->load->model('Notifikasi_model');
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) redirect('auth/login');

        $pekerja = $this->Pekerja_dashboard_model->get_by_user_id($user_id);
        if (!$pekerja) show_error('Data pekerja tidak ditemukan.');

        $tanggal = date('Y-m-d');
        $jadwal = $this->Pekerja_dashboard_model->get_jadwal_hari_ini($pekerja->id, $tanggal);

        // Cuaca dummy
        $cuaca = [
            'icon' => 'fa-cloud',
            'description' => 'Berawan'
        ];

        $notifikasi = $this->Notifikasi_model->get_notifikasi_pekerja($pekerja->id);

        $data = [
            'pekerja'     => $pekerja,
            'jadwal'      => $jadwal,
            'cuaca'       => $cuaca,
            'notifikasi'  => $notifikasi
        ];

        $this->load->view('templates/header_pekerja', $data);
        $this->load->view('templates/sidebar_pekerja', $data);
        $this->load->view('pekerja/dashboard', $data);
        $this->load->view('templates/footer_pekerja');
    }

    public function konfirmasi_kehadiran()
    {
        $status = $this->input->post('status');
        $jadwal_id = $this->input->post('jadwal_id');

        // Validasi
        if (!in_array($status, ['Hadir', 'Tidak Hadir']) || !$jadwal_id) {
            show_404();
        }

        // Update ke tabel jadwal
        $this->db->where('id', $jadwal_id);
        $this->db->update('jadwal', [
            'status_kehadiran' => $status,
            'konfirmasi' => 1
        ]);

        // Tambahkan notifikasi ke pekerja
        $pekerja_id = $this->get_pekerja_id_by_jadwal($jadwal_id);
        $this->db->insert('notifikasi', [
            'pekerja_id' => $pekerja_id,
            'pesan' => 'Anda telah mengonfirmasi kehadiran sebagai "' . $status . '"',
            'tipe' => 'info',
            'waktu' => date('H:i:s'),
            'status' => 'belum_dibaca'
        ]);

        $this->session->set_flashdata('success', 'Kehadiran berhasil dikonfirmasi sebagai "' . $status . '"');
        redirect('dashboard_pekerja');
    }

    private function get_pekerja_id_by_jadwal($jadwal_id)
    {
        $jadwal = $this->db->get_where('jadwal', ['id' => $jadwal_id])->row();
        return $jadwal ? $jadwal->pekerja_id : null;
    }
}