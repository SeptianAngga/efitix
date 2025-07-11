<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Laporan_model');
        $this->load->library('session');
    }

    public function index() {
        // Ambil input tanggal dari parameter GET
        $awal  = $this->input->get('awal');
        $akhir = $this->input->get('akhir');

        // Jika kosong, default ke 30 hari terakhir
        if (!$awal || !$akhir) {
            $akhir = date('Y-m-d');
            $awal  = date('Y-m-d', strtotime('-30 days'));
        }

        // Ambil data ringkasan
        $pengunjung = $this->Laporan_model->total_pengunjung($awal, $akhir);
        $tiket      = $this->Laporan_model->total_tiket($awal, $akhir);
        $shift      = $this->Laporan_model->total_shift($awal, $akhir);

        // Ambil data grafik
        $bulanan      = $this->Laporan_model->grafik_pengunjung($awal, $akhir);
        $rata_pekerja = $this->Laporan_model->grafik_pekerja($awal, $akhir);

        // Kirim ke view
        $data = [
            'title'         => 'Laporan',
            'awal'          => $awal,
            'akhir'         => $akhir,
            'pengunjung'    => $pengunjung,
            'tiket'         => $tiket,
            'shift'         => $shift,
            'bulanan'       => $bulanan,
            'rata_pekerja'  => $rata_pekerja,
            'username'      => $this->session->userdata('username')
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('admin/laporan', $data);
        $this->load->view('templates/footer');
    }
}