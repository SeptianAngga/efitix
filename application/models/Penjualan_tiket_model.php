<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan_tiket_model extends CI_Model {

    public function get_by_tanggal($tanggal)
    {
        return $this->db->get_where('penjualan_tiket', ['tanggal' => $tanggal])->row();
    }

    public function insert($data)
    {
        return $this->db->insert('penjualan_tiket', $data);
    }

    public function get_all()
    {
        return $this->db->order_by('tanggal', 'DESC')->get('penjualan_tiket')->result();
    }

    public function get_mingguan()
    {
        $this->db->where('tanggal >=', date('Y-m-d', strtotime('-6 days')));
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get('penjualan_tiket')->result();
    }
}