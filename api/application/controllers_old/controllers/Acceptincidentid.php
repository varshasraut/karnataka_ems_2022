<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Acceptincidentid extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
        if((isset($_COOKIE['cookie']))){
            $incidentId = $this->post('incidentId');
            // $data['accept_incident_id'] = $this->post('message');
            $data['accept_incident_id'] = 'accepted';
            $this->user->acceptIncidentId($incidentId,$data);
            $this->response([
                'data' => $data['accept_incident_id'],
                'error' => null
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
}