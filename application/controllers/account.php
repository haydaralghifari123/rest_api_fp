<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Account extends REST_Controller
{
    // declare constructor
    function __construct()
    {
        parent::__construct();
        $this->load->model('account_model');
    }

    // method POST sebagai validasi login
    function index_post()
    {
        // isi value parameter username, password
        $email = $this->post('email');
        $password = $this->post('password');

        // load model -> login function
        $data = $this->account_model->login($email, $password);

        // response
        if (empty($data)) {
            $output = array(
                'success' => false,
                'message' => 'Login failed! Please check your username / password!',
                'data' => null
            );
            $this->response($output, REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        } else {
            $result = $data;
            $output = array(
                'success' => true,
                'message' => 'Login Success!',
                'data' => $data
            );
            $this->response($output, REST_Controller::HTTP_OK);
        }
    }
}
