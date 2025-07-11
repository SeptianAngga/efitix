<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tiket_pekerja extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('level') != 'pekerja') {
            redirect('auth/login');
        }

        $this->load->model('Pekerja_dashboard_model');
        $this->load->model('Penjualan_tiket_model');
        $this->load->model('Notifikasi_model'); // ✅ Tambahkan model notifikasi
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $pekerja = $this->Pekerja_dashboard_model->get_by_user_id($user_id);

        // Hanya pekerja bertipe "Tiket" yang boleh akses
        if (!$pekerja || strtolower($pekerja->jabatan) != 'tiket') {
            show_error('Anda tidak memiliki akses ke halaman ini.');
        }

        $tanggal = date('Y-m-d');
        $sudah_input = $this->Penjualan_tiket_model->get_by_tanggal($tanggal);

        // ✅ Ambil notifikasi untuk lonceng
        $notifikasi = $this->Notifikasi_model->get_notifikasi_pekerja($pekerja->id);

        $data = [
            'title'       => 'Input Penjualan Tiket Hari Ini',
            'username'    => $this->session->userdata('username'),
            'sudah_input' => $sudah_input,
            'pekerja'     => $pekerja,
            'notifikasi'  => $notifikasi // ✅ kirim ke header_pekerja
        ];

        $this->load->view('templates/header_pekerja', $data);
        $this->load->view('templates/sidebar_pekerja', $data);
        $this->load->view('pekerja/input_tiket', $data);
        $this->load->view('templates/footer_pekerja');
    }

    public function simpan()
    {
        $tanggal = date('Y-m-d');
        $jumlah = $this->input->post('jumlah_terjual');

        $cek = $this->Penjualan_tiket_model->get_by_tanggal($tanggal);
        if ($cek) {
            $this->session->set_flashdata('error', 'Data untuk hari ini sudah diinput.');
            redirect('tiket_pekerja');
        }

        $this->Penjualan_tiket_model->insert([
            'tanggal'        => $tanggal,
            'jumlah_terjual' => $jumlah
        ]);

        $this->session->set_flashdata('success', 'Penjualan tiket berhasil disimpan.');
        redirect('tiket_pekerja');
    }
}