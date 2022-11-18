<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Maintenanceapproverej extends REST_Controller
{
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie','url'));
        $this->load->library('encryption');
    }
   
    public function index_post()
    {
          /*
        Tyre Maintennace = 14
        Accidental Maintenace = 7
        Breakdown Maintenance = 18
        OffRoad Maintenance = 12
        Preventive Maintenance = 16
        */
        if((isset($_COOKIE['cookie']))){
            $maintenanceType = $this->post('maintenanceType');
            if($maintenanceType == '7'){
                $data['re_mt_type'] = 'accidental';
                $summery['off_road_status'] = "In Accidental Maintenance-OFF Road";
                 $ambStatus1['amb_status_chk'] = '7';
            }else if($maintenanceType == '14'){
                $data['re_mt_type'] = 'tyre';
                $summery['off_road_status'] = "In Tyre Life Maintenance-OFF Road";
                 $ambStatus1['amb_status_chk'] = '14';
            }else if($maintenanceType == '18'){
                $data['re_mt_type'] = 'breakdown';
                $summery['off_road_status'] = "In Breakdown Maintenance-OFF Road";
                 $ambStatus1['amb_status_chk'] = '18';
            }else if($maintenanceType == '12'){
                $data['re_mt_type'] = 'onroad_offroad';
                $summery['off_road_status'] = "In Maintenance OFF Road"; 
                 $ambStatus1['amb_status_chk'] = '12';
            }else if($maintenanceType == '16'){
                $data['re_mt_type'] = 'preventive';
                $summery['off_road_status'] = "In Preventive Maintenance-OFF Road";
                $ambStatus1['amb_status_chk'] = '16';
            }
            $ambStatus1['off_road_status'] = "Pending for approval";

            $ambStatus1['ambNo'] = $this->post('vehicleNumber');
            $status=$this->post('aprrovalStatus');
            
             if($status==0)
            {
                $status=1;
            }else{
                $status=2;
            }
            
            
            $type = $this->post('type');
            $id = $this->encryption->decrypt($_COOKIE['cookie']);    
            $logindata = $this->user->getclgdetails($id);
            $reqId = $this->post('requestId');
            $data['re_mt_id'] = $reqId;
            $data['re_approval_status'] = $status;
            $data['re_remark'] = $this->post('remark');
            $data['re_rejected_date'] = date('Y-m-d H:i:s');
            $data['re_rejected_by'] = $logindata[0]['clg_ref_id'];
            
            $updatedata['mt_approved_cost'] = $this->post('approvedCost');
            $updatedata['mt_approved_ex_datetime'] = $this->post('approvedExDatetime');
           
            $approveRej = $this->user->insertAprroveRejData($data);
            
            // if($approveRej == 1){
               
            if($status == '1')
            {
                $this->user->updateSummery($ambStatus1,$summery);
                $this->user->updatemaintaincedata($updatedata,$reqId,$maintenanceType);
                
            }
            $this->response([
                'data' => array(
                    'message' => 'Insert Successfully'
                ),
                'error' => null
            ],REST_Controller::HTTP_OK);
        // }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    
}

