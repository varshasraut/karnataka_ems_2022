<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';
class Common extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model(array('Common_model'));
    }
  public function bloodgrp_post(){
    $rec = $this->Common_model->getbloodgrp();
    $this->response([
        'data' => $rec,
        'error' => null
    ],REST_Controller::HTTP_OK);
  }
  public function calltype_post(){
    $rec = $this->Common_model->getcalltype();
    $this->response([
        'data' => $rec,
        'error' => null
    ],REST_Controller::HTTP_OK);
  }
  public function chiefcomplaint_post(){
    $callType = $this->post('callType');
    $rec = $this->Common_model->getchiefcomplaint($callType);
    $this->response([
        'data' => $rec,
        'error' => null
    ],REST_Controller::HTTP_OK);
  }
  public function nearbloodbank_post(){
    $data['lat'] = $this->post('lat');
    $data['lng'] = $this->post('lng');
    $rec = $this->Common_model->getnearbloodbank($data);
    $this->response([
        'data' => $rec,
        'error' => null
    ],REST_Controller::HTTP_OK);
  }
  public function hospitaltype_post(){
    $rec = $this->Common_model->gethospitaltype();
    $this->response([
        'data' => $rec,
        'error' => null
    ],REST_Controller::HTTP_OK);
  }
  public function hospitallist_post(){
    $hospitalType = $this->post('hospitalType');
    $data['lat'] = $this->post('lat');
    $data['lng'] = $this->post('lng');
    $rec = $this->Common_model->gethospitallist($hospitalType,$data);
    $this->response([
        'data' => $rec,
        'error' => null
    ],REST_Controller::HTTP_OK);
  }
  public function nearhospital_post(){
    $data['hospitalType'] = $this->post('hospitalType');
    $data['lat'] = $this->post('lat');
    $data['lng'] = $this->post('lng');
    $rec = $this->Common_model->getnearhospital($data);
    $this->response([
        'data' => $rec,
        'error' => null
    ],REST_Controller::HTTP_OK);
  }
}