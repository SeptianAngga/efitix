<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal_model extends CI_Model {

    public function get_by_date($tanggal) {
        $this->db->select('jadwal.*, pekerja.nama_lengkap, pekerja.jabatan, pekerja.shift, pekerja.user_id');
        $this->db->from('jadwal');
        $this->db->join('pekerja', 'pekerja.id = jadwal.pekerja_id');
        $this->db->where('tanggal', $tanggal);
        return $this->db->get()->result();
    }

    public function get_pekerja_ids_by_tanggal($tanggal) {
        $this->db->select('pekerja_id');
        $this->db->from('jadwal');
        $this->db->where('tanggal', $tanggal);
        $query = $this->db->get();

        $ids = [];
        foreach ($query->result() as $row) {
            $ids[] = $row->pekerja_id;
        }
        return $ids;
    }

    public function insert($data) {
        return $this->db->insert('jadwal', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('jadwal');
    }
}