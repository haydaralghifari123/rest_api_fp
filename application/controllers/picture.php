<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Picture extends REST_Controller {

    // declare constructor
    function __construct(){
        parent::__construct();
        $this->load->model('Picture_model'); // Load model untuk gambar
    }

    // function get/show data gambar
    function index_get(){
        // nilai parameter untuk 'image_id'
        $image_id = $this->get('image_id');
        
        // panggil function getImage dari model
        $data = $this->Picture_model->getImage($image_id);

        // jika data ditemukan
        if (!empty($data)) {
            $result = array(
                'success' => true,
                'message' => 'data found',
                'data' => $data
            );
        } else {
            $result = array(
                'success' => false,
                'message' => 'data not found',
                'data' => null
            );
        }

        // tampilkan response
        $this->response($result, REST_Controller::HTTP_OK);
    }    

    // function insert (POST) gambar
    function index_post(){
        // validasi jika inputan kosong/format tidak sesuai
        $validasi_message = [];

        // jika username kosong
        if($this->post('username') == ''){
            array_push($validasi_message,'Username can not be empty');
        }

        // jika title kosong
        if($this->post('title') == ''){
            array_push($validasi_message,'Title can not be blank');
        }

        //upload image
        $part = "./foto/";
        $filename = "img".rand(9,9999).".jpg";

        if($filename == '' ){
            array_push($validasi_message,'Image can not be empty');
        }

        // tampilkan pesan jika validasi gagal
        if(count($validasi_message) > 0){
            $output = array(
                'success' => false,
                'message' => 'insert data failed, data not valid',
                'data' => $validasi_message
            );
            $this->response($output, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }

        // data yang akan dimasukkan
        $data = array(
            'username' => $this->post('username'),
            'title' => $this->post('title'),
            'description' => $this->post('description'),
            'image_url' => $this->post('image_url')
        );

        // panggil function insertImage dari model
        $result = $this->Picture_model->insertImage($data);

        // response
        if(empty($result)){
            $output = array(
                'success' => false,
                'message' => 'data already exists',
                'data' => null
            );
        } else {
            $output = array(
                'success' => true,
                'message' => 'insert data success',
                'data' => array('image' => $result)
            );
        }

        $this->response($output, REST_Controller::HTTP_OK);
    }

    // function for update (PUT) data gambar
    function index_put(){
        // get image_id
        $image_id = $this->put('image_id');

        // validasi jika inputan kosong/format tidak sesuai
        $validasi_message = [];

        // jika image_id kosong
        if($image_id == ''){
            array_push($validasi_message,'Image ID can not be empty');
        }

        // jika title kosong
        if($this->put('title') == ''){
            array_push($validasi_message,'Title can not be empty');
        }

        // jika image_url kosong
        if($this->put('image_url') == ''){
            array_push($validasi_message,'Image URL can not be empty');
        }

        // tampilkan pesan jika validasi gagal
        if(count($validasi_message) > 0){
            $output = array(
                'success' => false,
                'message' => 'update data failed, data not valid',
                'data' => $validasi_message
            );
            $this->response($output, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }

        // data yang akan diupdate
        $data = array(
            'title' => $this->put('title'),
            'description' => $this->put('description'),
            'image_url' => $this->put('image_url')
        );

        // panggil function updateImage dari model
        $result = $this->Picture_model->updateImage($data, $image_id);

        //response
        $output = array(
            'success' => true,
            'message' => 'update data success',
            'data' => array(
                'image' => $result
            )
        );

        $this->response($output, REST_Controller::HTTP_OK);
    }

    // function delete (DELETE) data gambar
    function index_delete(){
        // get image_id
        $image_id = $this->delete('image_id');

        // validasi jika image_id kosong
        $validasi_message = [];

        if($image_id == ''){
            array_push($validasi_message,'Image ID can not be empty');
        }

        // tampilkan pesan jika validasi gagal
        if(count($validasi_message) > 0){
            $output = array(
                'success' => false,
                'message' => 'delete data failed, ID is invalid',
                'data' => $validasi_message
            );
            $this->response($output, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }

        // panggil function deleteImage dari model
        $result = $this->Picture_model->deleteImage($image_id);

        //cek result
        if(empty($result)){
            $output = array(
                'success' => false,
                'message' => 'id not found',
                'data' => null
            );
        }else{
            $output = array(
                'success' => true,
                'message' => 'delete data success',
                'data' => array(
                    'images' => $result
                )
            );
        }

        $this->response($output, REST_Controller::HTTP_OK);
    }
}
