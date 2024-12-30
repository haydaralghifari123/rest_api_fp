<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class User extends REST_Controller{

    //declare constructor
    function __construct(){
        parent::__construct();
        $this->load->model('User_model');
    }

    //function get/show data pengguna
    function index_get(){

        //value paramater username
        $nama = $this->get('username');
        //call function getPengguna from model
        $data = $this->User_model->getUser($username);

        //response / result
        $result = array(
            'success' => true,
            'message' => 'data found',
            'data' => array('pengguna' => $data)
        );
        $result = $data;

        //show response
        $this->response($result, REST_Controller::HTTP_OK);
    }

    //function insert (POST) pengguna
    function index_post(){

        //validasi jika inputan kosong/format tidak sesuai
        $validasi_message = [];

        //jika username kosong
        if($this->post('email') == ''){
            array_push($validasi_message,'Email  can not be empty');
        }

        //jika format email tidak sesuai
        if($this->post('email') != '' && !filter_var($this->post('email'), FILTER_VALIDATE_EMAIL)){
            array_push($validasi_message,'Email is invalid');
        }

        //jika nama kosong
        if($this->post('username') == '' ){
            array_push($validasi_message,'Userame can not be blank');
        }

        //jika password kosong
        if($this->post('password') == '' ){
            array_push($validasi_message,'Password can not be empty');
        }

        //show message
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

        $data = array(
            'username' => $this->post('username'),
            'email' => $this->post('email'),
            'password' => $this->post('password')
        );

        //call function insertPengguna from model
        $result = $this->User_model->insertUser($data);

        //response
        if(empty($result)){
            $output = array(
                'success' => false,
                'message' => 'data already exists',
                'data' => null
            );
        }else{
            $output = array(
                'success' => true,
                'message' => 'insert data success',
                'data' => array(
                    'pengguna' => $result
                )
            );
        }
        $this->response($output, REST_Controller::HTTP_OK);
    }
}