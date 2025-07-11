<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('username') || $this->session->userdata('level') != 'admin') {
            redirect('auth/login');
        }
        $this->load->database();
        $this->load->model('Notifikasi_model');
        $this->load->helper(['url', 'date']);
    }

    public function index() {
        $today = date('Y-m-d');
        $tanggal_lengkap = date('l, d F Y');

        // Ambil data tiket terjual
        $tiket_today = $this->db->get_where('penjualan_tiket', ['tanggal' => $today])->row();
        $tiket_terjual = $tiket_today ? (int)$tiket_today->jumlah_terjual : 0;

        // Ambil prediksi hari ini
        $prediksi_today = $this->db->get_where('prediksi', ['tanggal' => $today])->row();

        // Data prediksi
        $pengunjung = $prediksi_today->jumlah_pengunjung ?? 0;
        $cuaca      = $prediksi_today->cuaca ?? $this->_ambilCuacaBMKG();
        $tiket      = $prediksi_today->tiket ?? ceil($pengunjung / 25);
        $validasi   = $prediksi_today->validasi ?? ceil($pengunjung / 30);
        $kebersihan = $prediksi_today->kebersihan ?? ceil($pengunjung / 50);
        $rekomendasi = $tiket + $validasi + $kebersihan;

        // Notifikasi admin otomatis (sekali sehari)
        $existing = $this->db->where('pekerja_id', 0)
                             ->where('DATE(waktu)', $today)
                             ->count_all_results('notifikasi');

        if ($existing == 0) {
            if (strtolower($cuaca) == 'hujan') {
                $this->Notifikasi_model->insert([
                    'pekerja_id' => 0,
                    'pesan' => '🌧 Cuaca hari ini diprediksi hujan. Pastikan semua petugas siap bertugas!',
                    'tipe' => 'warning'
                ]);
            }

            if ($pengunjung >= 500) {
                $this->Notifikasi_model->insert([
                    'pekerja_id' => 0,
                    'pesan' => "📈 Prediksi pengunjung hari ini tinggi ({$pengunjung} orang). Tambahkan pekerja jika diperlukan.",
                    'tipe' => 'info'
                ]);
            }
        }

        // Ambil notifikasi admin (untuk lonceng)
        $notifikasi = $this->Notifikasi_model->get_notifikasi_admin(5);
        $jumlah_notif = $this->Notifikasi_model->count_unread_admin();

        // Hitung jumlah pekerja
        $tetap = $this->db->where('tipe', 'Tetap')->count_all_results('pekerja');
        $freelance = $this->db->where('tipe', 'Freelance')->count_all_results('pekerja');

        // Pekerja bertugas hari ini
        $this->db->select('pekerja.nama_lengkap, pekerja.jabatan, jadwal.shift');
        $this->db->from('jadwal');
        $this->db->join('pekerja', 'jadwal.pekerja_id = pekerja.id');
        $this->db->where('jadwal.tanggal', $today);
        $bertugas = $this->db->get()->result();

        // Grafik mingguan
        $grafik = $this->db->query("
            SELECT tanggal, ROUND(AVG(jumlah_pengunjung)) AS jumlah_pengunjung
            FROM prediksi
            WHERE tanggal >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
            GROUP BY tanggal
            ORDER BY tanggal ASC
        ")->result();

        $labels = [];
        $data_chart = [];
        foreach ($grafik as $row) {
            $labels[] = date('D', strtotime($row->tanggal));
            $data_chart[] = (int)$row->jumlah_pengunjung;
        }

        if (empty($labels)) {
            $labels = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
            $data_chart = [0, 0, 0, 0, 0, 0, 0];
        }

        $data = [
            'title' => 'Dashboard Admin',
            'jumlah_pengunjung' => $pengunjung,
            'tiket_terjual' => $tiket_terjual,
            'rekomendasi' => $rekomendasi,
            'tetap' => $tetap,
            'freelance' => $freelance,
            'bertugas' => $bertugas,
            'grafik_label' => json_encode($labels),
            'grafik_data' => json_encode($data_chart),
            'cuaca' => $cuaca,
            'tanggal_lengkap' => $tanggal_lengkap,
            'username' => $this->session->userdata('username'),
            'notifikasi' => $notifikasi,
            'jumlah_notif' => $jumlah_notif
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('templates/footer');
    }

    private function _ambilCuacaBMKG() {
        $url = 'https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4=3307070';
        $cuaca = 'Cerah';

        $response = @file_get_contents($url);
        if ($response) {
            $data = json_decode($response, true);
            if (isset($data['data'][0]['cuaca'])) {
                $cuaca_str = strtolower($data['data'][0]['cuaca']);
                if (strpos($cuaca_str, 'hujan') !== false) {
                    $cuaca = 'Hujan';
                } elseif (strpos($cuaca_str, 'berawan') !== false) {
                    $cuaca = 'Berawan';
                }
            }
        }
        return $cuaca;
    }
}
