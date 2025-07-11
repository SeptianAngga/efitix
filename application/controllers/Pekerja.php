<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pekerja extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('username') || $this->session->userdata('level') != 'admin') {
            redirect('auth/login');
        }
        $this->load->model('Pekerja_model');
        $this->load->database();
        $this->load->library('form_validation');
    }

    public function index() {
        $data['title'] = 'Manajemen Pekerja';
        $data['username'] = $this->session->userdata('username');
        $data['pekerja'] = $this->Pekerja_model->get_all();

        $this->load->view('templates/header', $data);
        $this->load->view('admin/pekerja_list', $data);
        $this->load->view('templates/footer');
    }

    public function tambah() {
        $data['title'] = 'Tambah Pekerja';
        $data['username'] = $this->session->userdata('username');
        $data['action'] = 'tambah';

        $this->load->view('templates/header', $data);
        $this->load->view('admin/pekerja_form', $data);
        $this->load->view('templates/footer');
    }

    public function simpan() {
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]');
        $this->form_validation->set_rules('password2', 'Konfirmasi Password', 'required|matches[password]');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
        $this->form_validation->set_rules('tipe', 'Tipe', 'required');
        $this->form_validation->set_rules('shift', 'Shift', 'required');
        $this->form_validation->set_rules('hari_operasional', 'Hari Operasional', 'required');
        $this->form_validation->set_rules('level', 'Level Login', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->tambah();
        } else {
            // Simpan ke tabel users
            $user_data = [
                'username' => $this->input->post('username'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'level'    => $this->input->post('level')
            ];
            $this->db->insert('users', $user_data);
            $user_id = $this->db->insert_id();

            // Simpan ke tabel pekerja
            $pekerja_data = [
                'user_id'         => $user_id,
                'nama_lengkap'    => $this->input->post('nama_lengkap'),
                'email'           => $this->input->post('email'),
                'tanggal_mulai'   => $this->input->post('tanggal_mulai'), // Sudah sesuai!
                'jabatan'         => $this->input->post('jabatan'),
                'tipe'            => $this->input->post('tipe'),
                'hari_operasional'=> $this->input->post('hari_operasional'),
                'shift'           => $this->input->post('shift')
            ];
            $this->Pekerja_model->insert($pekerja_data);
            redirect('pekerja');
        }
    }

    public function edit($id) {
        $data['title'] = 'Edit Pekerja';
        $data['username'] = $this->session->userdata('username');
        $data['pekerja'] = $this->Pekerja_model->get_by_id($id);
        $data['action'] = 'edit';

        if (!$data['pekerja']) {
            show_404();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('admin/pekerja_form', $data);
        $this->load->view('templates/footer');
    }

    public function update($id) {
        $data_pekerja = [
            'nama_lengkap'    => $this->input->post('nama_lengkap'),
            'email'           => $this->input->post('email'),
            'jabatan'         => $this->input->post('jabatan'),
            'tipe'            => $this->input->post('tipe'),
            'shift'           => $this->input->post('shift'),
            'hari_operasional'=> $this->input->post('hari_operasional'),
            'tanggal_mulai'   => $this->input->post('tanggal_mulai')
        ];

        $data_user = null;
        if (!empty($this->input->post('password'))) {
            $data_user = [
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
            ];
        }

        $this->Pekerja_model->update($id, $data_pekerja, $data_user);
        redirect('pekerja');
    }

    public function hapus($id) {
        $this->Pekerja_model->delete($id);
        redirect('pekerja');
    }
}