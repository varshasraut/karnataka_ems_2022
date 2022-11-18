<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Loginodometer extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->model('CommonModel');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
        $this->load->library('upload');
        $this->load->helper('string');
    }
    public function index_post(){
        $type = $this->post('type');
        $vehicle = $this->post('vehicleNumber');
        $loginOdometer = $this->post('loginOdometer');
        $loginquestion = $this->post('loginquestion');
        $veh = explode(' ',$vehicle);
        $vehicleNumber = implode('-',$veh);
        $id = $this->encryption->decrypt($_COOKIE['cookie']);
        $logindata = $this->user->getUserLogin($id,$type);
        $dp_operated_by = array();
        foreach($logindata as $logindata1){
            if(count($logindata)==1){
                if($logindata1['login_type'] == 'P'){
                    $emso_id = $logindata1['clg_ref_id'];
                    array_push($dp_operated_by,$emso_id);
                }else{
                    $pilot_id = $logindata1['clg_ref_id'];
                    array_push($dp_operated_by,$pilot_id);
                }
            }else{
                if($logindata1['login_type'] == 'P'){
                    $emso_id = $logindata1['clg_ref_id'];
                    array_push($dp_operated_by,$emso_id);
                }else{
                    $pilot_id = $logindata1['clg_ref_id'];
                    array_push($dp_operated_by,$pilot_id);
                }
            }
            
        }
        if(count($dp_operated_by) == 2){
            $dp_operated_by1 = implode(',',$dp_operated_by);
        }else{
            if(!empty($dp_operated_by)){
                $dp_operated_by1 = $dp_operated_by[0];
            }else{
                $dp_operated_by1 = null;
            }
        }
        
        $extractpath = FCPATH . "vehicleDocuments/Loginodometer";
        $date = date("Y_m_d");
        $imageFlag = false;
        $imageData =  $this->processImagesData($extractpath,$dp_operated_by1,$vehicleNumber,$type,$loginOdometer,$loginquestion);
        if (strpos($imageData, "UploadError" !== false)) {
            $errorString = explode("@#@", $imageData);
            $aaa =  explode("##", $errorString[1]);
            return $this->response([
            'data' => $aaa,
            'error' => null
            ],REST_Controller::HTTP_OK);
        } else {
            $imageFlag = true;
        }
    }
    public function processImagesData($extractpath,$dp_operated_by1,$vehicleNumber,$type,$loginOdometer,$loginquestion){
        if(isset($extractpath)){
            // echo $extractpath;
            // print_r($_FILES);
            // if($chkUploadImg == "true"){
              $number_of_files = $_FILES['uploadedimage']['tmp_name'];
              $files = $_FILES['uploadedimage'];
              $errors = array();
              $errorArr = array();
              
              for($i=0;$i<$number_of_files;$i++)
              {
                if($_FILES['uploadedimages']['error'] != 0) $errors[] = 'Couldn\'t upload file '.$_FILES['uploadedimages']['name'];
              }
              if(sizeof($errors)==0)
              {
                $imgSize = 0;
                $config['upload_path'] =  $extractpath;
                $config['allowed_types'] = '*';
                $image1 = array();
                // print_r($config['upload_path']);die;
                // for ($i = 0; $i < $number_of_files; $i++) {
                  $_FILES['uploadedimage']['name'] = $files['name'];
                  $_FILES['uploadedimage']['type'] = $files['type'];
                  $_FILES['uploadedimage']['tmp_name'] = $files['tmp_name'];
                  $_FILES['uploadedimage']['error'] = $files['error'];
                  $_FILES['uploadedimage']['size'] = $files['size'];
                  // $imgSizeCal = $imgSize + $_FILES['uploadedimage']['size'];
                  // array_push($imgessize,$imgSizeCal);
                  $randomString = random_string('numeric', 5);
                  $ext = explode(".", $files['name']);
                  $_FILES['uploadedimage']['name'] = $randomString."_".date('Y_m_d_H_i_s'). "." . $ext[1];
                  $image = $randomString."_".date('Y_m_d_H_i_s') . "." . $ext[1];
                  array_push($image1,$image);
                  $this->upload->initialize($config);
                  if (! $this->upload->do_upload('uploadedimage')) {
                    $data['upload_errors'] = $this->upload->display_errors();
                    $errorArr[] = $data['upload_errors'];
                  }
                  
                  unset($ext, $imageFileName);
                // }
                
                if (empty($errorArr)) {
                    $loginodo['login_logout_odo_image'] = implode(",",$image1);
                    $loginodo['login_logout_odo_loginstatus'] = '1';
                    $loginodo['login_logout_odo_operated_by'] = $dp_operated_by1;
                    $loginodo['login_logout_odo_odometer'] = $loginOdometer;
                    $loginodo['login_logout_odo_login_type'] = $type;
                    $loginodo['login_logout_odo_vehicle_no'] = $vehicleNumber;
                    $loginodo['login_logout_odo_added_date'] = date('Y-m-d H:i:s');
                    $loginodo['login_logout_odo_questionstatus'] = $loginquestion;
                    //$data['ptn_id'] = $patientId == '' ? '' : $patientId;
                    $this->user->insertLoginOdometer($loginodo);
                    $this->response([
                      'data' => [
                          "code" => 1,
                          "message" => "Sucessfully Uploaded"
                        ],
                      'error' => null
                    ],REST_Controller::HTTP_OK);
                //   echo "uploadSuccess";
                  exit;
                } else {
                  $str = '';
                  for($j=0;$j<=count($errorArr);$j++){
                    $str .= $errorArr[$j]."##";
                  }
                  echo "UploadError@#@". $str;
                  exit;
                }
     
              }
              else{
                return $this->response([
                  'data' => $errors,
                  'error' => null
                ],REST_Controller::HTTP_OK);
              }
          }
    }
}