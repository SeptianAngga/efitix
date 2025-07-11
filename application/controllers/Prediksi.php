<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prediksi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(['form', 'url']);
        $this->load->library('session');
        $this->load->database();
    }

    public function index() {
        $data['username']     = $this->session->userdata('username');
        $data['tanggal']      = date('Y-m-d');
        $data['tipe_hari']    = 'Awal Pekan';
        $data['cuaca']        = $this->_ambil_cuaca_bmkg();
        $data['pengunjung']   = 0;
        $data['tiket']        = 0;
        $data['validasi']     = 0;
        $data['kebersihan']   = 0;
        $data['title']        = "Prediksi Kebutuhan Pekerja";

        $this->load->view('templates/header', $data);
        $this->load->view('admin/prediksi', $data);
        $this->load->view('templates/footer');
    }

    public function prediksi_submit() {
        $tanggal    = $this->input->post('tanggal');
        $tipe_hari  = $this->input->post('tipe_hari');
        $cuaca      = $this->input->post('cuaca');

        // Jalankan script ML Python
        $command = "python ml/predict.py " . escapeshellarg($tanggal) . " " . escapeshellarg($tipe_hari) . " " . escapeshellarg($cuaca);
        $output = shell_exec($command);
        $pengunjung = is_numeric(trim($output)) ? (int) $output : 0;

        // Hitung rekomendasi pekerja
        $tiket      = ceil($pengunjung / 25);
        $validasi   = ceil($pengunjung / 30);
        $kebersihan = ceil($pengunjung / 50);

        // Hapus data lama jika tanggal sama
        $this->db->where('tanggal', $tanggal)->delete('prediksi');

        // Simpan hasil prediksi ke database
        $this->db->insert('prediksi', [
            'tanggal'           => $tanggal,
            'cuaca'             => $cuaca,
            'jumlah_pengunjung' => $pengunjung,
            'tiket'             => $tiket,
            'validasi'          => $validasi,
            'kebersihan'        => $kebersihan
        ]);

        // Kirim ke tampilan
        $data = [
            'username'   => $this->session->userdata('username'),
            'title'      => "Prediksi Kebutuhan Pekerja",
            'tanggal'    => $tanggal,
            'tipe_hari'  => $tipe_hari,
            'cuaca'      => $cuaca,
            'pengunjung' => $pengunjung,
            'tiket'      => $tiket,
            'validasi'   => $validasi,
            'kebersihan' => $kebersihan
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('admin/prediksi', $data);
        $this->load->view('templates/footer');
    }

    // POST otomatis ke Jadwal/add_otomatis setelah prediksi berhasil
    public function tambah_jadwal_otomatis() {
        $tanggal = $this->input->post('tanggal');
        $tiket = (int) $this->input->post('tiket');
        $validasi = (int) $this->input->post('validasi');
        $kebersihan = (int) $this->input->post('kebersihan');

        // Redirect ke controller Jadwal + kirim via POST
        $postData = http_build_query([
            'tanggal' => $tanggal,
            'tiket' => $tiket,
            'validasi' => $validasi,
            'kebersihan' => $kebersihan
        ]);

        // Simulasi POST internal (tanpa CURL)
        $_POST = array_merge($_POST, [
            'tanggal' => $tanggal,
            'tiket' => $tiket,
            'validasi' => $validasi,
            'kebersihan' => $kebersihan
        ]);
        redirect('jadwal/add_otomatis');
    }

    // Ambil cuaca Magelang dari BMKG
    private function _ambil_cuaca_bmkg() {
        $url = 'https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4=3307070';
        $cuaca = 'Cerah';

        $response = @file_get_contents($url);
        if ($response) {
            $data = json_decode($response, true);
            if (isset($data['data'][0]['cuaca'])) {
                $cuaca_bmkg = strtolower($data['data'][0]['cuaca']);
                if (strpos($cuaca_bmkg, 'hujan') !== false) {
                    $cuaca = 'Hujan';
                } elseif (strpos($cuaca_bmkg, 'berawan') !== false) {
                    $cuaca = 'Berawan';
                }
            }
        }

        return $cuaca;
    }
}