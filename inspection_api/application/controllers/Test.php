<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
// Authentication
class Test extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        // Load the user model
        $this->load->model('Test_model');
    }
    public function index_post(){
        $data['name'] = $this->post('Name');
        $data['Mob'] = $this->post('Mob');
        $data['Age'] = $this->post('Age');
        $insertdata  = $this->Test_model->addtest($data);
        if(isset($insertdata)){
            $this->response([
                'data' => ([
                    'code' => 1,
                    'message' => 'Inserted Successfully'
                ]),
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => null,
                'error' => ([
                    'code' => 1,
                    'message' => 'Not Inserted Successfully'
                ])
            ],REST_Controller::HTTP_OK);
        }
        print_r($data);
    }

}