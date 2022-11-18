<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
// Authentication
class Addgrievance extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        // Load the user model
        $this->load->model(array('Grievance_model','Login_model'));
        $this->load->helper('string');
        $this->load->helper('number');
    }
    public function index_post(){
        $data['login_secret_key'] =  $this->post('loginSecretKey');
        $data['device_id'] =  $this->post('uniqueId');
        $data['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data);
        if($auth == 1){
            $insp_id = $this->post('inspectionId');
            $amb_no = $this->post('ambulanceNo');
            
            $gri['ins_id'] = $insp_id;
            $gri['amb_no'] = $amb_no;
            $gri['grievance_type'] = $this->post('grievanceType');
            $gri['grievance_sub_type'] = $this->post('grievanceSubType');
            $gri['prilimnari_inform'] = $this->post('prilimnariInform');
            $gri['remark'] = $this->post('remark');
            $gri['added_date'] = date('Y-m-d H:i:s');
            $gri['added_by'] = $data['username'];
            $gri['status'] = '0';
            $griData = $this->Grievance_model->insertGrievance($gri);
            if($griData == 1){
                $this->response([
                    'data' => ([
                        'code' => 1,
                        'message' => 'Inserted Record Sucessfully.'
                    ]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

}