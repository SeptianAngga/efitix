<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tiket extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('username') || $this->session->userdata('level') != 'admin') {
            redirect('auth/login');
        }
        $this->load->model('Tiket_model');
        $this->load->helper(['form', 'url']);
        $this->load->library('form_validation');
    }

    public function index() {
        $data = [
            'title'    => 'Input Tiket Terjual',
            'list'     => $this->Tiket_model->get_all(),
            'username' => $this->session->userdata('username')
        ];
        $this->load->view('templates/header', $data);
        $this->load->view('admin/tiket_list', $data);
        $this->load->view('templates/footer');
    }

    public function tambah() {
        $tanggal = date('Y-m-d');

        if ($this->Tiket_model->cek_tiket_harian($tanggal)) {
            $this->session->set_flashdata('error', 'Data tiket untuk hari ini sudah ada.');
            redirect('tiket');
        }

        $this->form_validation->set_rules('jumlah_terjual', 'Jumlah Terjual', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $data = ['title' => 'Tambah Tiket', 'username' => $this->session->userdata('username')];
            $this->load->view('templates/header', $data);
            $this->load->view('admin/tiket_form');
            $this->load->view('templates/footer');
        } else {
            $data = [
                'tanggal'        => $tanggal,
                'jumlah_terjual' => $this->input->post('jumlah_terjual')
            ];
            if ($this->Tiket_model->insert($data)) {
                $this->session->set_flashdata('success', 'Data tiket berhasil ditambahkan.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data tiket.');
            }
            redirect('tiket');
        }
    }
}