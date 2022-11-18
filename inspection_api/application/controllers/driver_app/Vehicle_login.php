<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
// Authentication
class Vehicle_login extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        // Load the user model
        $this->load->model('driver_app/Vehicle_Login_model');
    }
    public function index_post(){
        $vehicleNumber = $this->post('vehicleNumber');
        if(!empty($vehicleNumber)){
            $chkVehicleReg = $this->Vehicle_Login_model->getVehicleData($vehicleNumber);
            if(empty($chkVehicleReg)){
                $this->response([
                    'data' => null,
                    'error' => ([
                        'code' => 1,
                        'message' => 'Vehicle Number Not Registered'
                    ])
                ],REST_Controller::HTTP_OK);
            }else if(count($chkVehicleReg) > 1){
                $this->response([
                    'data' => null,
                    'error' => ([
                        'code' => 2,
                        'message' => 'Vehicle Number Is Registered Multiple Time'
                    ])
                ],REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'data' => ([
                        'code' => 1,
                        'message' => 'Successfully Login'
                    ]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
                // $chkVehicleLogin = $this->Vehicle_Login_model->getVehicleLogin($vehicleNumber);
                // if(empty($chkVehicleLogin)){
                //     $this->response([
                //         'data' => ([
                //             'code' => 1,
                //             'message' => 'Successfully Login'
                //         ]),
                //         'error' => ([])
                //     ],REST_Controller::HTTP_OK);
                // }else{
                //     $msg = "Another user is (User Id: ".$chkVehicleLogin[0]->clg_id.") logined on this vehicle number";
                //     $this->response([
                //         'data' => null,
                //         'error' => ([
                //             'code' => 3,
                //             'message' => $msg
                //         ])
                //     ],REST_Controller::HTTP_OK);
                // }
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_OK);
        }
    }
}
