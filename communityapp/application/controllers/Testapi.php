<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';
class Testapi extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model(array('Testapi_model','Common_model'));
    }
  public function trialapi_post(){
    $data['first_name']=$this->post('fname');
    $data['last_name']=$this->post('lname');
    $data['password']=$this->post('pass');
    $rec = $this->Testapi_model->testuserdata($data);
    echo $rec;
  }
}