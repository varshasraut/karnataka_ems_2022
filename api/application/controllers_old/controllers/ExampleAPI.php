<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class ExampleAPI extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model(array('ExampleModel','CommonModel'));
        $this->load->helper(array('cookie', 'url'));
    }
    public function index_post(){
        $data = $this->post();
        // print_r($data);die;
        $data = $this->ExampleModel->insertdata($data);
        if($data == 1){
            $this->response([
                'data' => ([
                    'code' => 1,
                    'message' => 'Sucessfully Inserted'
                ]),
                'error' => null
            ],REST_Controller::HTTP_OK); 
        }else{
            $this->response([
                'data' => null,
                'error' => ([
                    'code' => 1,
                    'message' => 'Not inserted'
                ])
            ],REST_Controller::HTTP_OK);
        }
    }
    public function register_post(){
        $data = $this->ExampleModel->getdata();
        $this->response([
            'data' => $data,
            'error' => null
        ],REST_Controller::HTTP_OK); 
    }
}