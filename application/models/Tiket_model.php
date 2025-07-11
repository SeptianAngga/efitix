<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tiket_model extends CI_Model {

    public function get_all() {
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get('penjualan_tiket')->result();
    }

    public function insert($data) {
        return $this->db->insert('penjualan_tiket', $data); // ✅ Data array langsung
    }

    public function cek_tiket_harian($tanggal) {
        return $this->db->get_where('penjualan_tiket', ['tanggal' => $tanggal])->row();
    }
}