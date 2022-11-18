<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Driverparameters extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
        if((isset($_COOKIE['cookie']))){
            $data['incidenId'] = $this->post('incidentId');
            $data['ambno'] = $this->session->userdata['cookie']['ambno'];
            $data['parametersType'] = $this->post('parametersType');
            if(isset($this->session->userdata['cookie']['pilotId'])){
                $data['pilotId'] = $this->session->userdata['cookie']['pilotId'];
                $data['emtId'] = '';
            }
            if(isset($this->session->userdata['cookie']['emtId'])){
                $data['emtId'] = $this->session->userdata['cookie']['emtId'];
                $data['pilotId'] = '';
            }
            if((isset($this->session->userdata['cookie']['pilotId'])) && (isset($this->session->userdata['cookie']['emtId']))){
                $data['pilotId'] = $this->session->userdata['cookie']['pilotId'];
                $data['emtId'] = $this->session->userdata['cookie']['emtId'];
            }
            $data['dateTime'] = $this->post('dateTime');
            $para = $this->user->addDriverParameters($data);
            if($para == 1){
                $this->response([
                    'data' => ([
                        'code' => $para,
                        'message' => 'Already inserted'
                    ]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'data' => ([
                        'code' => $para
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