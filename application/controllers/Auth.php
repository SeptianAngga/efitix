<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library(['form_validation', 'session']);
    }

    public function index() {
        redirect('auth/login');
    }

    public function login() {
        // Jika sudah login, redirect sesuai level
        if ($this->session->userdata('username')) {
            $level = $this->session->userdata('level');
            if ($level === 'admin') {
                redirect('dashboard');
            } elseif ($level === 'pekerja') {
                redirect('dashboard_pekerja');
            } else {
                $this->session->sess_destroy(); // level tidak dikenal
                redirect('auth/login');
            }
        }

        // Validasi input
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() === false) {
            $this->load->view('auth/login');
        } else {
            $this->_login_process();
        }
    }

    private function _login_process() {
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);

        $user = $this->User_model->get_by_username($username);

        if ($user) {
            if (password_verify($password, $user->password)) {
                // Simpan session login
                $this->session->set_userdata([
                    'user_id'  => $user->id,
                    'username' => $user->username,
                    'level'    => $user->level
                ]);

                // Redirect berdasarkan level
                if ($user->level === 'admin') {
                    redirect('dashboard');
                } elseif ($user->level === 'pekerja') {
                    redirect('dashboard_pekerja');
                } else {
                    $this->session->sess_destroy(); // Level tidak dikenal
                    $this->session->set_flashdata('error', 'Level pengguna tidak valid.');
                    redirect('auth/login');
                }

            } else {
                $this->session->set_flashdata('error', 'Password salah.');
                redirect('auth/login');
            }
        } else {
            $this->session->set_flashdata('error', 'Username tidak ditemukan.');
            redirect('auth/login');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}