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
}