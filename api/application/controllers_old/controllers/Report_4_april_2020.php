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
    }
    public function img(){
      $this->load->helper('form');
      $data = array();
      $data['title'] = 'Multiple file upload';
      $this->load->view('img',$data);
    }
    public function index_post(){
      $incidentId = $this->post('incidentId');
      $remark = $this->post('remark');
      $chkUploadImg = $this->post('chkUploadImg');
    //   print_r($chkUploadImg);die;
      $chkImgUpload = $_FILES['uploadedimages']['tmp_name'];

      $configVideo['upload_path'] = FCPATH . 'incidentvideo';
      $configVideo['max_size'] = '20000000';
      $configVideo['allowed_types'] = '*';
      $configVideo['overwrite'] = FALSE;
      $configVideo['remove_spaces'] = TRUE;
    //   $video_name = random_string('numeric', 5);
      $configVideo['file_name'] = $_FILES['video']['name'];
        // print_r($configVideo['file_name']);die;
      $this->load->library('upload', $configVideo);
      $this->upload->initialize($configVideo);

      if (!$this->upload->do_upload('video')) 
      {
        $this->response([
          'data' => $this->upload->display_errors(),
          'error' => null
        ],REST_Controller::HTTP_OK);
      }

        if($chkUploadImg == "true"){
            // print_r('hhh');die;
            $number_of_files = sizeof(($_FILES['uploadedimages']['tmp_name']));
            $files = $_FILES['uploadedimages'];
            $errors = array();
            for($i=0;$i<$number_of_files;$i++)
            {
              if($_FILES['uploadedimages']['error'][$i] != 0) $errors[$i][] = 'Couldn\'t upload file '.$_FILES['uploadedimages']['name'][$i];
            }
            // $imgsizechk = 5000000;
            // $imgessize = array();
            if(sizeof($errors)==0)
            {
              $imgSize = 0;
              $this->load->library('upload');
              $config['upload_path'] =  FCPATH . 'incidentimages';
              $config['allowed_types'] = '*';
              for ($i = 0; $i < $number_of_files; $i++) {
                $_FILES['uploadedimage']['name'] = $files['name'][$i];
                $_FILES['uploadedimage']['type'] = $files['type'][$i];
                $_FILES['uploadedimage']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['uploadedimage']['error'] = $files['error'][$i];
                $_FILES['uploadedimage']['size'] = $files['size'][$i];
                // $imgSizeCal = $imgSize + $_FILES['uploadedimage']['size'];
                // array_push($imgessize,$imgSizeCal);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('uploadedimage'))
                {
                  $data['uploads'][$i] = $this->upload->data();
                }
                else
                {
                  $data['upload_errors'][$i] = $this->upload->display_errors();
                  $this->response([
                    'data' => $data['upload_errors'][$i],
                    'error' => null
                  ],REST_Controller::HTTP_OK);
                }
              }
            }
            else{
              $this->response([
                'data' => $errors,
                'error' => null
              ],REST_Controller::HTTP_OK);
            }
            $a = array();
            if(count($data['uploads']) > 1){
              foreach($data['uploads'] as $uploads){
                array_push($a,$uploads['file_name']);
              }
              $img['inc_images'] = implode(',',$a);
            }else{
              $img['inc_images'] = $data['uploads'][0]['file_name'];
            }
        // if($imgessize > $imgsizechk){
        //   $this->response([
        //     'data' => null,
        //     'error' => ([
        //       'code' => 1,
        //       'message' => 'images size is begger'
        //     ])
        //   ],REST_Controller::HTTP_OK);
        //   exit;
        // }
      }

      $img['inc_video'] = $configVideo['file_name'];
      $img['report_inc_remark'] = $remark;
      $incImg = $this->user->insertImages($img,$incidentId);
      if($incImg == 1){
        $this->response([
          'data' => ([
              'code' => 1,
              'message' => 'Successfully Upload'
          ]),
          'error' => null
        ],REST_Controller::HTTP_OK);
      }else{
        $this->response([
          'data' => ([
              'code' => 2,
              'message' => 'Not Upload'
          ]),
          'error' => null
        ],REST_Controller::HTTP_OK);
      }
    }
}