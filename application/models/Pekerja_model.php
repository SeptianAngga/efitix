<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pekerja_model extends CI_Model {

    private $table = 'pekerja';

    // Ambil semua data pekerja (untuk manajemen pekerja/admin)
    public function get_all() {
        $this->db->select('pekerja.*, users.username, users.level');
        $this->db->from('pekerja');
        $this->db->join('users', 'users.id = pekerja.user_id', 'left');
        $this->db->order_by('pekerja.jabatan', 'ASC');
        return $this->db->get()->result();
    }

    // Ambil satu pekerja berdasarkan ID
    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    // Simpan data baru
    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    // Update data pekerja berdasarkan ID
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    // Hapus data pekerja sekaligus user yang terkait
    public function delete($id) {
        $pekerja = $this->db->get_where($this->table, ['id' => $id])->row();
        if ($pekerja) {
            if ($pekerja->user_id) {
                $this->db->delete('users', ['id' => $pekerja->user_id]);
            }
            return $this->db->delete($this->table, ['id' => $id]);
        }
        return false;
    }

    // Ambil data pekerja beserta user login-nya (jika dibutuhkan)
    public function get_with_user() {
        return $this->db
            ->select('pekerja.*, users.username, users.level')
            ->from($this->table)
            ->join('users', 'users.id = pekerja.user_id', 'left')
            ->get()
            ->result();
    }

    // Ambil hanya pekerja (bukan admin), untuk dropdown penjadwalan
    public function get_pekerja_only() {
        return $this->db
            ->select('pekerja.id, nama_lengkap, jabatan, shift, tipe AS tipe_pekerja, hari_operasional')
            ->from('pekerja')
            ->join('users', 'users.id = pekerja.user_id')
            ->where('users.level', 'pekerja')
            ->order_by('jabatan', 'ASC')
            ->get()
            ->result();
    }
}