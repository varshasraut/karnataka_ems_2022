<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';
class Editinitialassessment extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
        if(isset($_COOKIE['cookie'])){
            $patientId = $this->post('patientId');
            if(!empty($patientId)){
                $initial = $this->user->EditPatientInitialAssessment($patientId);
                // print_r($initial);die;
                $this->response([
                    'data' => $initial,
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'data' => ([]),
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