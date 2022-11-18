<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Emergenvehdis extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('Policefire/Emergenvehdismodel');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
        $data['emg_callerno'] = $this->post('callerNo');
        $data['emg_callername'] = $this->post('callerName');
        $data['emg_patientname'] = $this->post('patientName');
        $data['emg_patientage'] = $this->post('patientAge');
        $data['emg_patientgender'] = $this->post('patientGender');
        $data['emg_incidentadd'] = $this->post('incidentAdd');
        $data['emg_incidentlat'] = $this->post('incidentLat');
        $data['emg_incidentlng'] = $this->post('incidentLng');
        $data['emg_cheifcompliant'] = $this->post('incidentDist');
        $data['emg_typeofcall'] = $this->post('eventType');
        $data['emg_cheifcompliant'] = $this->post('subeventType');
        $data['emg_cad_inc_id'] = $this->post('CADIncidentID');
        $data['emg_added_date'] = date('Y-m-d H:i:s');
        $rec = $this->Emergenvehdismodel->insertEmgVehDis($data);
        if($rec == 1){
            $this->response([
                'data' => ([
                    'code' => 1,
                    'message' => 'Record Successfully Added'
                ]),
                'error' => null
            ],REST_Controller::HTTP_OK);
        }
        
    }
    public function emgdisambdetails_post(){
        $data['incidentID'] = "202107260001";
        $data['ambulanceNo'] = "MH 12 DM 0001";
        $data['ambulanceContactNo'] = "1234567890";
        $data['ambulanceTracking'] = "http://ambulancetracking";
        $data['CADIncidentID'] = "CFS023432";
        $this->response([
            'data' => (
                $data
            ),
            'error' => null
        ],REST_Controller::HTTP_OK);

    }
    public function emgcallclosedstatus_post(){
        // $data['startfrombaseloc'] = "2021-01-07 15:32:05";
        // $data['atscene'] = "2021-01-07 16:00:05";
        // $data['fromscene'] = "2021-01-07 16:15:05";
        // $data['athospital'] = "2021-01-07 16:30:05";
        // $data['patienthandover'] = "2021-01-07 16:45:00";
        // $data['backtobaselocation'] = "2021-01-07 17:00:05";
        $data['eventstatus'] = "closed";
        $data['CADIncidentID'] = "CFS023432";
        $this->response([
            'data' => (
                $data
            ),
            'error' => null
        ],REST_Controller::HTTP_OK);
    }

}