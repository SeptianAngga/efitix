<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi_model extends CI_Model {

    // Ambil notifikasi untuk POV pekerja (berdasarkan pekerja_id)
    public function get_notifikasi_pekerja($pekerja_id, $limit = 5)
    {
        return $this->db
            ->where('pekerja_id', $pekerja_id)
            ->order_by('waktu', 'DESC')
            ->limit($limit)
            ->get('notifikasi')
            ->result();
    }

    // Ambil notifikasi untuk admin (pekerja_id = 0)
    public function get_notifikasi_admin($limit = 5)
    {
        return $this->db
            ->where('pekerja_id', 0)
            ->order_by('waktu', 'DESC')
            ->limit($limit)
            ->get('notifikasi')
            ->result();
    }

    // Ambil semua notifikasi admin tanpa limit
    public function get_all_notifikasi_admin()
    {
        return $this->db
            ->where('pekerja_id', 0)
            ->order_by('waktu', 'DESC')
            ->get('notifikasi')
            ->result();
    }

    // Hitung jumlah notifikasi belum dibaca untuk admin
    public function count_unread_admin()
    {
        return $this->db
            ->where(['pekerja_id' => 0, 'status' => 'belum_dibaca'])
            ->count_all_results('notifikasi');
    }

    // Hitung jumlah belum dibaca untuk pekerja tertentu
    public function count_unread_pekerja($pekerja_id)
    {
        return $this->db
            ->where(['pekerja_id' => $pekerja_id, 'status' => 'belum_dibaca'])
            ->count_all_results('notifikasi');
    }

    // Tandai semua notifikasi admin sebagai dibaca
    public function mark_all_as_read_admin()
    {
        return $this->db
            ->where('pekerja_id', 0)
            ->update('notifikasi', ['status' => 'dibaca']);
    }

    // Tandai semua notifikasi pekerja sebagai dibaca
    public function mark_all_as_read_pekerja($pekerja_id)
    {
        return $this->db
            ->where('pekerja_id', $pekerja_id)
            ->update('notifikasi', ['status' => 'dibaca']);
    }

    // Insert notifikasi baru (untuk admin atau pekerja)
    public function insert($data)
    {
        $data['waktu']  = date('Y-m-d H:i:s');
        $data['status'] = 'belum_dibaca';
        return $this->db->insert('notifikasi', $data);
    }
}
