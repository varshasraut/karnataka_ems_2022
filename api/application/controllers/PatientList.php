<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class PatientList extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
        $incidentID = $this->post('incidentId');
        if((isset($_COOKIE['cookie']))){
            if(!empty($incidentID)){
                $checkIncidentIdClose = $this->user->checkIncidentIdClose($incidentID);
			
                if(empty($checkIncidentIdClose)){
                    $patient = $this->user->getPatientDetails($incidentID);
				
                    $this->response([
                        'data' =>  $patient,
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }else{
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'code' => 105,
                            'message' => 'Incident Id Completed'
                        ])
                    ],REST_Controller::HTTP_OK);
                }
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