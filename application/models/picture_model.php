<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Picture_model extends CI_Model {

    // Declare constructor
    function __construct(){
        parent::__construct();
        // akses database
        $this->load->database();
    }

    // Function untuk show data gambar (GET) & search by username
    public function getPicture($username){
        if($username == ''){
            // show all data
            $data = $this->db->get('images');
        } else {
            // using LIKE to search by username
            $this->db->like('user_id', $username);
            $data = $this->db->get('images');
        }

        return $data->result_array();
    }

    // Function untuk insert data gambar
    public function insertPicture($data){
        // cek apakah gambar dengan username dan title yang sama sudah ada
        $this->db->where('title', $data['title']);
        $check_data = $this->db->get('images');
        $result = $check_data->result_array();

        if(empty($result)){
            //jika judul gambar belum ada, maka data ditambahkan ke tabel makanan
            $this->db->insert('images', $data);
        }else{
            $data = array();
        }

        return $data;
    }

    // Function untuk update data gambar
    public function updatePicture($data, $image_id){
        // update data dimana image_id memenuhi syarat
        $this->db->where('image_id', $image_id);
        $this->db->update('images', $data);

        $result = $this->db->get_where('images', array('image_id' => $image_id));

        return $result->row_array(); // Mengembalikan data yang telah diupdate
    }

    // Function untuk delete data gambar
    public function deletePicture($image_id){
        // Ambil data gambar sebelum dihapus
        $result = $this->db->get_where('images', array('image_id' => $image_id));

        // Hapus data gambar
        $this->db->where('image_id', $image_id);
        $this->db->delete('images');

        return $result->row_array(); // Mengembalikan data yang dihapus
    }
}
