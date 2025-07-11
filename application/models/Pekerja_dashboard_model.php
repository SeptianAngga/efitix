<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pekerja_dashboard_model extends CI_Model {

    // Ambil data pekerja berdasarkan user_id login
    public function get_by_user_id($user_id)
    {
        return $this->db->get_where('pekerja', ['user_id' => $user_id])->row();
    }

    // Ambil jadwal hari ini untuk pekerja
    public function get_jadwal_hari_ini($pekerja_id, $tanggal)
    {
        return $this->db->get_where('jadwal', [
            'pekerja_id' => $pekerja_id,
            'tanggal'    => $tanggal
        ])->row();
    }

    // Ambil notifikasi untuk pekerja (dari tabel notifikasi yang punya kolom pekerja_id)
    public function get_notifikasi_pekerja($pekerja_id)
    {
        return $this->db
            ->order_by('waktu', 'DESC')
            ->get_where('notifikasi', ['pekerja_id' => $pekerja_id])
            ->result();
    }
}