<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model {

    public function total_pengunjung($mulai, $sampai) {
        $this->db->select_sum('jumlah_pengunjung');
        $this->db->where('tanggal >=', $mulai);
        $this->db->where('tanggal <=', $sampai);
        $query = $this->db->get('prediksi')->row();
        return $query ? $query->jumlah_pengunjung : 0;
    }

    public function total_tiket($mulai, $sampai) {
        $this->db->select_sum('jumlah_terjual');
        $this->db->where('tanggal >=', $mulai);
        $this->db->where('tanggal <=', $sampai);
        $query = $this->db->get('penjualan_tiket')->row();
        return $query ? $query->jumlah_terjual : 0;
    }

    public function total_shift($mulai, $sampai) {
        $this->db->where('tanggal >=', $mulai);
        $this->db->where('tanggal <=', $sampai);
        return $this->db->count_all_results('jadwal');
    }

    public function grafik_pengunjung($mulai, $sampai) {
        return $this->db->query("
            SELECT DATE_FORMAT(tanggal, '%b') AS bulan,
                   SUM(jumlah_pengunjung) AS total
            FROM prediksi
            WHERE tanggal BETWEEN '$mulai' AND '$sampai'
            GROUP BY DATE_FORMAT(tanggal, '%Y-%m')
            ORDER BY tanggal ASC
        ")->result();
    }

    public function grafik_pekerja($mulai, $sampai) {
        return $this->db->query("
            SELECT
                DATE_FORMAT(tanggal, '%b') AS bulan,
                COUNT(*) AS shift,
                ROUND(COUNT(*) / COUNT(DISTINCT tanggal)) AS rata_pekerja
            FROM jadwal
            WHERE tanggal BETWEEN ? AND ?
            GROUP BY bulan
            ORDER BY MIN(tanggal)
        ", [$mulai, $sampai])->result();
    }
}