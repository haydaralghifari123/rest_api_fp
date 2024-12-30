<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Register extends REST_Controller
{
    // declare constructor
    function __construct()
    {
        parent::__construct();
        $this->load->model('account_model');
    }

    function index_post()
    {
        // validasi input
        $validasi_message = [];
        $email = $this->post('email');
        $password = $this->post('password');
        $username = $this->post('username');

        if (empty($email)) {
            array_push($validasi_message, 'Email can not be empty');
        }
        if (empty($password)) {
            array_push($validasi_message, 'Password can not be empty');
        }
        if (empty($username)) {
            array_push($validasi_message, 'Userame can not be empty');
        }
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($validasi_message, 'Email is invalid');
        }

        // show message jika validasi gagal
        if (count($validasi_message) > 0) {
            $output = array(
                'success' => false,
                'message' => 'Registration failed, data not valid',
                'data' => $validasi_message
            );
            $this->response($output, REST_Controller::HTTP_OK);
            return;
        }

        // data untuk registrasi
        $data = array(
            'email' => $email,
            'password' => $password,
            'username' => $username
        );

        // panggil fungsi register dari model
        $result = $this->account_model->register($data);

        // response
        /*if ($result) {
            $output = array(
                'success' => true,
                'message' => 'Registration successful!',
                'data' => $data
            );
        } else {
            $output = array(
                'success' => false,
                'message' => 'Registration failed! Email already exists.',
                'data' => null
            );
        }*/

        if ($result) {
            $output = array(
                'email' => $email,
            'password' => $password,
            'username' => $username
            );
        } else {
            $output = null;
        }
        $this->response($output, REST_Controller::HTTP_OK);
    }
}
