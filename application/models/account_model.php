<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_model extends CI_Model {

    // declare constructor
    function __construct()
    {
        parent::__construct();
        // akses database
        $this->load->database();
    }

    // function login => email, password
    public function login($email, $password) {
        // cek data
        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $data = $this->db->get('user');

        return $data->row_array();
    }

    // function register => email, password, name
    public function register($data) {
        // cek apakah email yang diinputkan sudah ada/blm
        $this->db->where('email', $data['email']);
        $check_data = $this->db->get('user');
        $result = $check_data->result_array();

        if (empty($result)) {
            // jika email belum ada, maka data ditambahkan ke tabel user
            $this->db->insert('user', $data);
            return true; // return true jika registrasi berhasil
        } else {
            return false; // return false jika email sudah terdaftar
        }
    }
}