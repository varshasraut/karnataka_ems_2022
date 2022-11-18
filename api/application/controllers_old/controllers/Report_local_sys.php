<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Report extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
        $this->load->helper('string');
        $this->load->library('upload');
    }
    public function img(){
      $this->load->helper('form');
      $data = array();
      $data['title'] = 'Multiple file upload';
      $this->load->view('img',$data);
    }
    public function index_post(){
        if((isset($_COOKIE['cookie']))){
          $incidentId = $this->post('incidentId');
          $remark = $this->post('remark');
          $chkUploadImg = $this->post('chkUploadImg');
          $chkUploadVideo = $this->post('chkUploadVideo');
          $patientId = $this->post('patientId');
        //   if(!empty($patientId1)){
        //       $patientId = $patientId1;
        //   }else{
        //       $patientId = "";
        //   }
        //   print_r($_FILES);die;
          if($chkUploadImg == 'false' && $chkUploadVideo == 'false'){
            $data['remark'] = $remark;
            $data['incident_id'] = $incidentId;
            $data['ptn_id'] = $patientId == '' ? '' : $patientId;
            // print_r($data);
            $this->user->insertReport($data);
            $this->response([
              'data' => [
                  "code" => 1,
                  "message" => "Sucessfully Uploaded"
                ],
              'error' => null
            ],REST_Controller::HTTP_OK);
            exit;
          }
          // print_r($_FILES);die;
        
          $configVideo['upload_path'] = FCPATH . 'incidentvideozip';
          $configVideo['max_size'] = '20000000';
          $configVideo['allowed_types'] = 'zip';
          $configVideo['overwrite'] = FALSE;
          $configVideo['remove_spaces'] = TRUE;
          $video_name = random_string('numeric', 5);
          $configVideo['file_name'] = $video_name;
          $configVideo['client_name'] = $video_name;
          $this->upload->initialize($configVideo);
     
          $extractpath = FCPATH . "incidentData";
          //Create directory
     
          $date = date("Y_m_d");
          if (is_dir($extractpath)) {
            if (!is_dir($extractpath . '/' . $date)) {
              $mainDir = mkdir($extractpath . '/' . $date);
            } else {
              $mainDir = $extractpath . '/' . $date;
            }
     
            if (is_dir($extractpath . '/' . $date)) {
              // create a dir with incident number
              if (!empty($incidentId)) {
                if(!is_dir($extractpath . '/' . $date . '/' . $incidentId)){
                  $dir = mkdir($extractpath . '/' . $date . '/' . $incidentId);
                  $dir = $extractpath . '/' . $date . '/' . $incidentId;
                } else {
                  $dir = $extractpath . '/' . $date . '/' . $incidentId;
                }
              }
            }
          }
     
        //   $videoData = $this->processVideoData($mainDir,$dir, $this->upload->data());
        //   $videoFlag = false;
        //   if (!empty($videoData)) {
        //       // check is it string contain error message
        //       if (strpos($videoData, "UploadError" !== false)) {
        //           $errorString = explode("@#@", $videoData);
        //           return $this->response([
        //             'data' => $errorString[1],
        //             'error' => null
        //           ],REST_Controller::HTTP_OK);
        //       } else {
        //         $videoFlag = true;
        //       }
              
        //   }
     
          if($chkUploadImg == "true") {
            $imageFlag = false;
            $imageData =  $this->processImagesData($mainDir,$dir,$incidentId,$remark);
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
     
          if ($videoFlag && $imageFlag) {
            return $this->response([
              'data' => 'Success',
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
 
 
    public function processVideoData($mainDir,$dir,$uploadData) {
      if(isset($mainDir) && isset($dir) && isset($uploadData)){
      if (!$this->upload->do_upload('video')) 
      {
         echo "UploadError";
         echo "@#@";
         echo $this->upload->display_errors();
         exit;
      } else {
        $data = $this->upload->data();
        $zip_file  = new ZipArchive;
        $full_path = $data['full_path']; 
        $extractpath = FCPATH . "incidentvideo";
        $this->upload->initialize($data);
        if ($zip_file->open($full_path) === TRUE)
        {
          // create a folder datewise
          $zip_file->extractTo($dir);
          $files1 = scandir($dir,1);
          if(!empty($files1[0])) {
            $filearray = explode('.', $files1[0]);
            if($filearray[1]){
              $fileName = rename($dir . '/'. $files1[0], $dir .'/'. date('Y_m_d_H_i_s') . '.' .$filearray[1]);
              $VideoName = date('Y_m_d_H_i_s') . '.' .$filearray[1];
            }
          }
            $zip_file->close();
            echo "uploadSuccess";
            exit;
        }  
      }
      }
    }
 
    public function processImagesData($mainDir,$dir,$incidentId,$remark) {
       
      if(isset($mainDir) && isset($dir)){
        // if($chkUploadImg == "true"){
          $number_of_files = sizeof(($_FILES['uploadedimages']['tmp_name']));
          $files = $_FILES['uploadedimages'];
          $errors = array();
          $errorArr = array();
          
          for($i=0;$i<$number_of_files;$i++)
          {
            if($_FILES['uploadedimages']['error'][$i] != 0) $errors[$i][] = 'Couldn\'t upload file '.$_FILES['uploadedimages']['name'][$i];
          }
          if(sizeof($errors)==0)
          {
            $imgSize = 0;
            $config['upload_path'] =  $dir;
            $config['allowed_types'] = '*';
            $image1 = array();
            
            for ($i = 0; $i < $number_of_files; $i++) {
              $_FILES['uploadedimage']['name'] = $files['name'][$i];
              $_FILES['uploadedimage']['type'] = $files['type'][$i];
              $_FILES['uploadedimage']['tmp_name'] = $files['tmp_name'][$i];
              $_FILES['uploadedimage']['error'] = $files['error'][$i];
              $_FILES['uploadedimage']['size'] = $files['size'][$i];
              // $imgSizeCal = $imgSize + $_FILES['uploadedimage']['size'];
              // array_push($imgessize,$imgSizeCal);
              
              $ext = explode(".", $files['name'][$i]);
              $_FILES['uploadedimage']['name'] = date('Y_m_d_H_i_s_') . $i . "." . $ext[1];
              $image = date("Y_m_d")."/".$incidentId."/".date('Y_m_d_H_i_s_') . $i . "." . $ext[1];
              array_push($image1,$image);
              $this->upload->initialize($config);
              if (! $this->upload->do_upload('uploadedimage')) {
                $data['upload_errors'][$i] = $this->upload->display_errors();
                $errorArr[] = $data['upload_errors'][$i];
              }
              
              unset($ext, $imageFileName);
            }
            
            if (empty($errorArr)) {
                $data['images'] = implode(",",$image1);
                $data['remark'] = $remark;
                $data['incident_id'] = $incidentId;
                $data['ptn_id'] = isset($patientId) ? $patientId : '';
                //$data['ptn_id'] = $patientId == '' ? '' : $patientId;
                $this->user->insertReport($data);
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


 
    public function processImagesData1($mainDir,$dir,$incidentId,$remark) {
      if(isset($mainDir) && isset($dir)){
        // if($chkUploadImg == "true"){
          $number_of_files = sizeof(($_FILES['uploadedimages']['tmp_name']));
          
          $errors = array();
          $errorArr = array();
          // print_r($files);die;
          for($i=0;$i<$number_of_files;$i++)
          {
            if($_FILES['uploadedimages']['error'][$i] != 0) $errors[$i][] = 'Couldn\'t upload file '.$_FILES['uploadedimages']['name'][$i];
          }
          if(sizeof($errors)==0)
          {
            $imgSize = 0;
            $config['upload_path'] =  $dir;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $image1 = array();
            // print_r(count($_FILES['uploadedimages']['name'])); die;
            
            for ($i = 0; $i < count($_FILES['uploadedimages']['name']); $i++) {
                
                // echo '<pre>';
                // print_r($_FILES['uploadedimages']['name']);die;
                
                
            //   $_FILES['uploadedimages']['name'] = $_FILES['uploadedimages']['name'][$i];
            //   $_FILES['uploadedimages']['type'] = $_FILES['uploadedimages']['type'][$i];
            //   $_FILES['uploadedimages']['tmp_name'] = $_FILES['uploadedimages']['tmp_name'][$i];
            //   $_FILES['uploadedimages']['error'] = $_FILES['uploadedimages']['error'][$i];
            //   $_FILES['uploadedimages']['size'] = $_FILES['uploadedimages']['size'][$i];
              // $imgSizeCal = $imgSize + $_FILES['uploadedimage']['size'];
              // array_push($imgessize,$imgSizeCal);
              
              $ext = explode(".", $_FILES['uploadedimages']['name'][$i]);
              
              
              $_FILES['uploadedimages']['name'][$i] = date('Y_m_d_H_i_s_') . $i . "." . $ext[1];
              print_r($_FILES['uploadedimages']['name']);echo '<pre>';
              
              $image = date("Y_m_d")."/".$incidentId."/".$_FILES['uploadedimages']['name'][$i];
            //   array_push($image1,$image);
              $this->upload->initialize($config);
              if (! $this->upload->do_upload($_FILES['uploadedimages']['name'][$i])) {
                $data['upload_errors'][$i] = $this->upload->display_errors();
                $errorArr[] = $data['upload_errors'][$i];
              }
              
              unset($ext, $imageFileName,$image);
            }
            
            //exit;
            print_r($image1);
            if (empty($errorArr)) {
              echo "uploadSuccess";
              
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
