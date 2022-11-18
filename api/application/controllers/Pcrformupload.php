<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Pcrformupload extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
        $this->load->helper('string');
        $this->load->library('upload');
    }
    public function index_post(){
        $type = $this->post('type');
        $vehicle = $this->post('vehicleNumber');
        $incidentId = $this->post('incidentId');
        $veh = explode(' ',$vehicle);
        $vehicleNumber = implode('-',$veh);
        $id = $this->encryption->decrypt($_COOKIE['cookie']);
        $logindata = $this->user->getUserLogin($id,$type);
        $dp_operated_by = array();
        $id = $this->encryption->decrypt($_COOKIE['cookie']);
        $chklogindata = $this->user->getId($id,$type);
        $deviceId = $this->encryption->decrypt($_COOKIE['deviceId']);
        $deviceIdLogin = $this->user->checkDeviceLogin($deviceId);
        if($chklogindata == 1 || (empty($deviceIdLogin))){
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }else{
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
          $extractpath = FCPATH . "vehicleDocuments/Pcrform";
          $date = date("Y_m_d");
          $imageFlag = false;
          $imageData =  $this->processImagesData($extractpath,$dp_operated_by1,$vehicleNumber,$type,$incidentId);
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
    }
    public function processImagesData($extractpath,$dp_operated_by1,$vehicleNumber,$type,$incidentId){
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
                    $pcrform['pcrform_image'] = implode(",",$image1);
                    $pcrform['pcrform_operated_by'] = $dp_operated_by1;
                    $pcrform['pcrformo_login_type'] = $type;
                    $pcrform['pcrform_vehicle_no'] = $vehicleNumber;
                    $pcrform['pcrform_added_date'] = date('Y-m-d H:i:s');
                    $pcrform['pcrform_inc_ref_id'] = $incidentId;
                    //$data['ptn_id'] = $patientId == '' ? '' : $patientId;
                    $rec = $this->user->insertPcrFormdometer($pcrform);
                    if($rec == 1){
                        $this->response([
                            'data' => [
                                "code" => 1,
                                "message" => "Sucessfully Uploaded"
                              ],
                            'error' => null
                          ],REST_Controller::HTTP_OK);
                    }
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
    public function pcrformuploadstatus_post(){
      $incidentId = $this->post('incidentId');
      $rec = $this->user->getpcrformuploadstatus($incidentId);
      if(!empty($rec)){
        $status = true;
      }else{
        $status = false;
      }
      $this->response([
        'data' => [
            "code" => 1,
            "pcrformuploadstatus" => $status
          ],
        'error' => null
      ],REST_Controller::HTTP_OK);
    }
    public function delivinambphoto_post(){
      // echo 'kk';die;
      $takephoto = $this->post('takePhoto');
      $type = $this->post('type');
      $vehicle = $this->post('vehicleNumber');
      $incidentId = $this->post('incidentId');
      $patientId = $this->post('patientId');
      $veh = explode(' ',$vehicle);
      $vehicleNumber = implode('-',$veh);
      $id = $this->encryption->decrypt($_COOKIE['cookie']);
      $logindata = $this->user->getUserLogin($id,$type);
      $dp_operated_by = array();
      $id = $this->encryption->decrypt($_COOKIE['cookie']);
      $chklogindata = $this->user->getId($id,$type);
      $deviceId = $this->encryption->decrypt($_COOKIE['deviceId']);
      $deviceIdLogin = $this->user->checkDeviceLogin($deviceId);
      if($chklogindata == 1 || (empty($deviceIdLogin))){
          $this->response([
              'data' => ([]),
              'error' => null
          ],REST_Controller::HTTP_UNAUTHORIZED);
      }else{
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
        if($takephoto == 'yes'){
          $extractpath = FCPATH . "vehicleDocuments/Deliv_in_amb";
          $date = date("Y_m_d");
          $imageFlag = false;
          $imageData =  $this->deliv_in_amb_images($extractpath,$dp_operated_by1,$vehicleNumber,$type,$incidentId,$patientId,$takephoto);
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
        }else{
          $delivinamb['deliv_in_amb_operated_by'] = $dp_operated_by1;
          $delivinamb['deliv_in_amb_login_type'] = $type;
          $delivinamb['deliv_in_amb_vehicle_no'] = $vehicleNumber;
          $delivinamb['deliv_in_amb_added_date'] = date('Y-m-d H:i:s');
          $delivinamb['deliv_in_amb_inc_ref_id'] = $incidentId;
          $delivinamb['deliv_in_amb_patient_id'] = $patientId;
          $delivinamb['deliv_in_amb_take_photo'] = $takephoto;
          $rec = $this->user->insertDelivInAmb($delivinamb);
          if($rec == 1){
            $this->response([
                'data' => [
                    "code" => 1,
                    "message" => "Sucessfully Uploaded"
                  ],
                'error' => null
              ],REST_Controller::HTTP_OK);
        }
        }
      }
    }
    public function deliv_in_amb_images($extractpath,$dp_operated_by1,$vehicleNumber,$type,$incidentId,$patientId,$takephoto){
      if(isset($extractpath)){
        //  echo $extractpath;
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
                $delivinamb['deliv_in_amb_image'] = implode(",",$image1);
                $delivinamb['deliv_in_amb_operated_by'] = $dp_operated_by1;
                $delivinamb['deliv_in_amb_login_type'] = $type;
                $delivinamb['deliv_in_amb_vehicle_no'] = $vehicleNumber;
                $delivinamb['deliv_in_amb_added_date'] = date('Y-m-d H:i:s');
                $delivinamb['deliv_in_amb_inc_ref_id'] = $incidentId;
                $delivinamb['deliv_in_amb_patient_id'] = $patientId;
                $delivinamb['deliv_in_amb_take_photo'] = $takephoto;
                //$data['ptn_id'] = $patientId == '' ? '' : $patientId;
                $rec = $this->user->insertDelivInAmb($delivinamb);
                if($rec == 1){
                    $this->response([
                        'data' => [
                            "code" => 1,
                            "message" => "Sucessfully Uploaded"
                          ],
                        'error' => null
                      ],REST_Controller::HTTP_OK);
                }
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