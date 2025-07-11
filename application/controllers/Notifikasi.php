<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('username')) {
            redirect('auth/login');
        }
        $this->load->model('Notifikasi_model');
    }

    public function index() {
        $data['notifikasi'] = $this->Notifikasi_model->get_notifikasi_admin();
        $data['title'] = 'Semua Notifikasi';
        $data['username'] = $this->session->userdata('username');

        // tandai semua sebagai dibaca saat halaman dibuka
        $this->Notifikasi_model->mark_all_as_read_admin();

        $this->load->view('templates/header', $data);
        $this->load->view('admin/notifikasi', $data);
        $this->load->view('templates/footer');
    }
}