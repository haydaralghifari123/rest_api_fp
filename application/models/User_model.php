<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model{

    //declare constructor
    function __construct(){
        parent::__construct();
        //akses database
        $this->load->database();
    }

    //function utk show data pengguna (GET) & search by nama/username
    public function getUser($username){
        if($username==''){
            //show all data
            $data = $this->db->get('username');
        }else{
            //using like
            $this->db->like('username', $username);
            $this->db->or_like('email', $emai);
            $data = $this->db->get('username');
        }

        return $data->result_array();
    }

    //function insert data pengguna 
    public function insertUser($data){
        //cek apakah username yang diinputkan sudah ada/blm
        $this->db->where('email', $data['email']);
        $check_data = $this->db->get('username');
        $result = $check_data->result_array();

        if(empty($result)){
            //jika username belum ada, maka data ditambahkan ke tabel pengguna
            $this->db->insert('user', $data);
        }else{
            $data = array();
        }

        return $data;
    }

    //function login
    public function login($username, $password){
        //cek data
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $data = $this->db->get('username');

        return $data->row_array();
    }
}