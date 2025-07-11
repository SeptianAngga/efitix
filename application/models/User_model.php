<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function get_by_username($username)
    {
        return $this->db
            ->where('username', $username)
            ->limit(1)
            ->get('users')
            ->row();
    }

    public function insert($data)
    {
        return $this->db->insert('users', $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update('users', $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete('users');
    }
}