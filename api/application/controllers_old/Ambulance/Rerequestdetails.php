<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';

class Rerequestdetails extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model(array('CommonModel','user'));
        $this->load->library('encryption');
        $this->load->helper('string');
        $this->amb_pic = $this->config->item('amb_pic');
        $this->accidental = $this->config->item('accidental');
        $this->breakdown = $this->config->item('breakdown');
        $this->offroad = $this->config->item('offroad');
        $this->preventive = $this->config->item('preventive');
        $this->load->library('upload');
        $this->load->helper(['url','file','form']); 
    }
    public function index_post(){
        /*
        Tyre Maintennace = 14
        Accidental Maintennace = 7
        Breakdown Maintenance = 18
        OffRoad Maintenance = 12
        Preventive Maintenance = 16
        */
        $maintenanceType = $this->post('maintenanceType');
        $requestId = $this->post('requestId');
        $ambulanceNo = $this->post('vehicleNumber');
        if(!empty($requestId) && !empty($ambulanceNo)){
                $data['requestId'] = $requestId;
                $data['ambulanceNo'] = $ambulanceNo;
                $data['maintenanceType'] = $maintenanceType;
            if($maintenanceType == '14'){
                $data['maintenance'] = 'tyre';
            }else if($maintenanceType == '7'){
                $data['maintenance'] = 'accidental';
            }else if($maintenanceType == '18'){
                $data['maintenance'] = 'breakdown';
            }else if($maintenanceType == '12'){
                $data['maintenance'] = 'onroad_offroad';
            }else if($maintenanceType == '16'){
                $data['maintenance'] = 'preventive';
            }
            $rerequest = $this->user->getReRequestdata($data);
            $this->response([
                'data' => $rerequest,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => [],
                'error' => null
            ],REST_Controller::HTTP_OK);
        }
    }
    
}