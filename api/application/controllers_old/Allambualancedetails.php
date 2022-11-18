<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';
class Allambualancedetails extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
    }
    public function index_post(){
      
            $district = $this->post('district');
            $ambulancedetails = $this->user->getallambulances($district);
           print_r($ambulancedetails);
                        $this->response([
                            'data' => ([
                                'total_amb' => $ambulancedetails[0]['amb_count'],
                                'onroad' => $ambulancedetails[0]['off_road_doctor'],
                                'offroad' => $ambulancedetails[0]['total_offroad'],                                
                              
                            ]),
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                 
           
    }
 public function Getambulancedetails_post(){
        $ambno1 = $this->post('ambno');
        $output = preg_split('//', $ambno1, -1, PREG_SPLIT_NO_EMPTY);
        $ambno = $output[0].$output[1]." ".$output[2].$output[3]." ".$output[4].$output[5]." ".$output[6].$output[7].$output[8].$output[9];
        $ambnodetails = $this->user->getallambulancesstatus($ambno);
        // print_r($ambnodetails);die;
        $loginuser = array();
        // $emt = array();
        // $logindetails = array();
        if(!empty($ambnodetails)){
            if(count($ambnodetails) == '1'){
                if($ambnodetails[0]['login_type'] == 'D'){
                    $loginuser += array(
                        'Pilot_name' => $ambnodetails[0]['clg_first_name'],
                        'PilotMbNo' => $ambnodetails[0]['clg_mobile_no'],
                        'EMSOname' => "",
                        'EMSOMbNo' => ""
                    );
                }
                if($ambnodetails[0]['login_type'] == 'P'){
                    $loginuser += array(
                        'Pilot_name' => "",
                        'PilotMbNo' => "",
                        'EMSOname' => $ambnodetails[0]['clg_first_name'],
                        'EMSOMbNo' => $ambnodetails[0]['clg_mobile_no']
                    );
                }
            }else if(count($ambnodetails) == '2'){
                foreach($ambnodetails as $ambnodetails1){
                    if($ambnodetails1['login_type'] == 'D'){
                        $loginuser += array(
                            'Pilot_name' => $ambnodetails1['clg_first_name'],
                            'PilotMbNo' => $ambnodetails1['clg_mobile_no']
                        );
                    }else if($ambnodetails1['login_type'] == 'P'){
                        $loginuser += array(
                            'EMSOname' => $ambnodetails1['clg_first_name'],
                            'EMSOMbNo' => $ambnodetails1['clg_mobile_no']
                        );
                    }
                }
            }
            $amb = array();
            if(!empty($ambnodetails)){
                for($i = 0; $i<1; $i++){
                    $loginuser += array(
                        "ambNo" => $ambnodetails[$i]['amb_rto_register_no'],
                        "ambBaseloc" => $ambnodetails[$i]['hp_name'],
                        "PilotdefualtNo" => $ambnodetails[$i]['amb_pilot_mobile'],
                        "EMSOdefualtNo" => $ambnodetails[$i]['amb_default_mobile'],
                        "ambSattus" => $ambnodetails[$i]['ambs_name'],
                        "ambType" => $ambnodetails[$i]['ambt_name'],
                        "distName" => $ambnodetails[$i]['dst_name'],
                    );
                    // break;
                }
            }
            $this->response([
                'data' => $loginuser,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $loginuser = array(
                'Pilot_name' => "",
                'PilotMbNo' => "",
                'EMSOname' => "",
                'EMSOMbNo' => "",
                "ambNo" => $ambno,
                "ambBaseloc" => "",
                "PilotdefualtNo" => "",
                "EMSOdefualtNo" => "",
                "ambSattus" => "",
                "ambType" => "",
                "distName" => "",
            );
            $this->response([
                'data' => $loginuser,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }
    }
    public function allambdetails_post(){
        $dist = $this->post('distId');
        $ambnodetails = $this->user->getambulancesdetails($dist);
        $amb = array();
        if(!empty($ambnodetails)){
            foreach($ambnodetails as $ambnodetails1){
                $amb1 = array(
                    'AmbNo' => $ambnodetails1['amb_rto_register_no'],
                    'AmbLat' => $ambnodetails1['amb_lat'],
                    'AmbLng' => $ambnodetails1['amb_log'],
                    'AmbStatus' => $ambnodetails1['ambs_name']
                );
                array_push($amb,$amb1);
            }
            $this->response([
                'data' => $amb,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => [],
                'error' => null
            ],REST_Controller::HTTP_OK);
        }
    }
    public function ambstatuscount_post(){
        $dist = $this->post('distId');
        //$ambnodetails = $this->user->getambstatuscount($dist);
        // print_r($ambnodetails);die;
        $offroadcount = $this->user->getoffroadcount();
        // print_r($offroadcount);die;
        $available = array();
        $busy = array();
        $availableCount = 347;
        $offroad = array();
        if(!empty($offroadcount)){
            $avaCount = $availableCount - $offroadcount[0]['total_offroad'];
            $offCount = $offroadcount[0]['total_offroad'];
            $data = array(
                'Available' => $avaCount,
                'Busy' => 590,
                'Offroad' => (int) $offCount,
            );
            $this->response([
                'data' => $data,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => [],
                'error' => null
            ],REST_Controller::HTTP_OK);
        }
    }
    // public function ambstatuscount_post(){
    //     $dist = $this->post('distId');
    //     $ambnodetails = $this->user->getambstatuscount($dist);
    //     // print_r($ambnodetails);die;
    //     $available = array();
    //     $busy = array();
    //     $offroad = array();
    //     if(!empty($ambnodetails)){
    //         foreach($ambnodetails as $ambnodetails1){
    //             if($ambnodetails1['ambs_name'] = 'Available'){
    //                 $available1 = array(
    //                     'AmbNo' => $ambnodetails1['amb_rto_register_no']
    //                 );
    //                 array_push($available,$available1);
    //             }else if($ambnodetails1['ambs_name'] = 'Busy'){
    //                 $busy1 = array(
    //                     'AmbNo' => $ambnodetails1['amb_rto_register_no']
    //                 );
    //                 array_push($busy,$busy1);
    //             }
    //             else if($ambnodetails1['ambs_name'] = 'Off Road'){
    //                 $offroad1 = array(
    //                     'AmbNo' => $ambnodetails1['amb_rto_register_no']
    //                 );
    //                 array_push($offroad,$offroad1);
    //             }
                
    //         }
    //         $data = array(
    //             'Available' => count($available),
    //             'Busy' => count($busy),
    //             'Offroad' => count($offroad),
    //         );
    //         $this->response([
    //             'data' => $data,
    //             'error' => null
    //         ],REST_Controller::HTTP_OK);
    //     }else{
    //         $this->response([
    //             'data' => [],
    //             'error' => null
    //         ],REST_Controller::HTTP_OK);
    //     }
    // }
}


