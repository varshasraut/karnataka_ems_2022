<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
class ExampleController extends CI_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model(array('ExampleModel','CommonModel'));
        $this->load->helper(array('cookie', 'url'));
    }
    public function index(){
        
        $this->load->view('register');
    }
    public function register(){
        $data = $this->input->post();
        // print_r($data);die;
        $data = $this->ExampleModel->insertdata($data);
        if($data == 1){
            echo 'Inserted Successfully';
        }else{
            echo 'Not Inserted Successfully';
        }
    }
}