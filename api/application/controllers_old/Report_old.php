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
         
            $configVideo['upload_path'] = FCPATH . 'incidentvideo'; # check path is correct
          $configVideo['max_size'] = '102400';
          $configVideo['allowed_types'] = 'mp4'; # add video extenstion on here
          $configVideo['overwrite'] = FALSE;
          $configVideo['remove_spaces'] = TRUE;
          $video_name = random_string('numeric', 5);
          $configVideo['file_name'] = $video_name;
    
          $this->load->library('upload', $configVideo);
          $this->upload->initialize($configVideo);
    
          if (!$this->upload->do_upload('video')) # form input field attribute
          {
            print_r('error');
              # Upload Failed
              // $this->session->set_flashdata('error', $this->upload->display_errors());
              // redirect('controllerName/method');
          }
          else
          {
              $video['inc_video'] = $video_name;
              // $set1 =  $this->user->insertvideo($url);
              // print_r($video_name);
              $incvideo = $this->user->insertVideo($video,$incidentId);
              if($incvideo == 1){
                $this->response([
                  'data' => ([
                      'code' => 1,
                      'message' => 'Video Has been Uploaded'
                  ]),
                  'error' => null
                ],REST_Controller::HTTP_OK);
              }else{
                $this->response([
                  'data' => ([
                      'code' => 2,
                      'message' => 'Not Inserted'
                  ]),
                  'error' => null
                ],REST_Controller::HTTP_OK);
              }
          }
         
      // retrieve the number of images uploaded;
      // print_r((count($_FILES['uploadedimages']['tmp_name'])));die;
        $number_of_files = sizeof(($_FILES['uploadedimages']['tmp_name']));
        // print_r($_FILES['uploadedimages']);die;
    // considering that do_upload() accepts single files, we will have to do a small hack so that we can upload multiple files. For this we will have to keep the data of uploaded files in a variable, and redo the $_FILE.
    $files = $_FILES['uploadedimages'];
    $errors = array();
 
    // first make sure that there is no error in uploading the files
    for($i=0;$i<$number_of_files;$i++)
    {
      if($_FILES['uploadedimages']['error'][$i] != 0) $errors[$i][] = 'Couldn\'t upload file '.$_FILES['uploadedimages']['name'][$i];
    }
    if(sizeof($errors)==0)
    {
      // now, taking into account that there can be more than one file, for each file we will have to do the upload
      // we first load the upload library
      $this->load->library('upload');
      // next we pass the upload path for the images
      $config['upload_path'] =  FCPATH . 'incidentimages';
    //   print_r($config['upload_path']);die;
      // also, we make sure we allow only certain type of images
      $config['allowed_types'] = '*';
      for ($i = 0; $i < $number_of_files; $i++) {
        $_FILES['uploadedimage']['name'] = $files['name'][$i];
        $_FILES['uploadedimage']['type'] = $files['type'][$i];
        $_FILES['uploadedimage']['tmp_name'] = $files['tmp_name'][$i];
        $_FILES['uploadedimage']['error'] = $files['error'][$i];
        $_FILES['uploadedimage']['size'] = $files['size'][$i];
        //now we initialize the upload library
        $this->upload->initialize($config);
        // print_r($this->upload->initialize($config));
        // we retrieve the number of files that were uploaded
        if ($this->upload->do_upload('uploadedimage'))
        {
          $data['uploads'][$i] = $this->upload->data();
        }
        else
        {
          $data['upload_errors'][$i] = $this->upload->display_errors();
        }
      }
    }
    else
    {
        $this->response([
          'data' => $errors,
          'error' => null
        ],REST_Controller::HTTP_OK);
    //   print_r($errors);
    }
    $a = array();
    // print_r($data['uploads']);
    if(count($data['uploads']) > 1){
      foreach($data['uploads'] as $uploads){
        array_push($a,$uploads['file_name']);
      }
      $img['inc_images'] = implode(',',$a);
      $incImg = $this->user->insertImages($img,$incidentId);
      if($incImg == 1){
        $this->response([
          'data' => ([
              'code' => 1,
              'message' => 'Successfully Inserted'
          ]),
          'error' => null
        ],REST_Controller::HTTP_OK);
      }else{
        $this->response([
          'data' => ([
              'code' => 2,
              'message' => 'Not Inserted'
          ]),
          'error' => null
        ],REST_Controller::HTTP_OK);
      }
    }else{
      $img['inc_images'] = $data['uploads'][0]['file_name'];
      $incImg = $this->user->insertImages($img,$incidentId);
      if($incImg == 1){
        $this->response([
          'data' => ([
              'code' => 1,
              'message' => 'Successfully Inserted'
          ]),
          'error' => null
        ],REST_Controller::HTTP_OK);
      }else{
        $this->response([
          'data' => ([
              'code' => 2,
              'message' => 'Not Inserted'
          ]),
          'error' => null
        ],REST_Controller::HTTP_OK);
      }
    }
    echo '<pre>';
    // print_r($data['uploads'][0]['file_name']);
    echo '</pre>';
        
        // $number_of_files = sizeof($_FILES['uploadedimages']['tmp_name']);
        // $files = $_FILES['uploadedimages'];
        // $errors = array();
        // for($i=0;$i<$number_of_files;$i++)
        // {
        //   if($_FILES['uploadedimages']['error'][$i] != 0) $errors[$i][] = 'Couldn\'t upload file '.$_FILES['uploadedimages']['name'][$i];
        // }
        // if(sizeof($errors)==0)
        // {
        //   $this->load->library('upload');
        //   $config['upload_path'] =  FCPATH . 'incidentimages';
        //   $config['allowed_types'] = 'gif|jpg|png|jpeg';
        //   for ($i = 0; $i < $number_of_files; $i++) {
        //     $_FILES['uploadedimage']['name'] = $files['name'][$i];
        //     $_FILES['uploadedimage']['type'] = $files['type'][$i];
        //     $_FILES['uploadedimage']['tmp_name'] = $files['tmp_name'][$i];
        //     $_FILES['uploadedimage']['error'] = $files['error'][$i];
        //     $_FILES['uploadedimage']['size'] = $files['size'][$i];
        //     $this->upload->initialize($config);
        //     if ($this->upload->do_upload('uploadedimage'))
        //     {
        //       $data['uploads'][$i] = $this->upload->data();
        //     }
        //     else
        //     {
        //       $data['upload_errors'][$i] = $this->upload->display_errors();
        //     }
        //   }
        // }
        // else
        // {
        //   print_r($errors);
        // }
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
    }
}