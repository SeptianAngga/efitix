<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prediksi_model extends CI_Model {

    public function get_by_tanggal($tanggal) {
        return $this->db->get_where('prediksi', ['tanggal' => $tanggal])->row();
    }

    public function count_jadwal_by_shift($tanggal, $jabatan, $shift_waktu) {
        $this->db->from('jadwal');
        $this->db->join('pekerja', 'pekerja.id = jadwal.pekerja_id');
        $this->db->where('jadwal.tanggal', $tanggal);
        $this->db->where('pekerja.jabatan', $jabatan);
        $this->db->where('jadwal.shift', $shift_waktu);
        return $this->db->count_all_results();
    }

    public function check_sisa_kebutuhan($tanggal) {
        $hasil = [];
        $prediksi = $this->get_by_tanggal($tanggal);
        if (!$prediksi) return $hasil;

        $jabatan_shifts = [
            'Tiket'      => ['Pagi', 'Malam'],
            'Validasi'   => ['Pagi', 'Malam'],
            'Kebersihan' => ['Pagi', 'Sore']
        ];

        foreach ($jabatan_shifts as $jabatan => $shifts) {
            $total = isset($prediksi->{$jabatan}) ? $prediksi->{$jabatan} : 0;
            $per_shift_kuota = ceil($total / 2);

            foreach ($shifts as $shift) {
                $terisi = $this->count_jadwal_by_shift($tanggal, $jabatan, $shift);
                $sisa = $per_shift_kuota - $terisi;
                if ($sisa > 0) {
                    $hasil[] = "$jabatan $shift: $sisa lagi";
                }
            }
        }

        return $hasil;
    }
}