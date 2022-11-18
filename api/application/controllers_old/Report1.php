<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Report1 extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
        $this->load->library(['session']); 
        $this->load->helper(['url','file','form']); 
    }
    public function index_post(){
        $incidentId = $this->post('incidentId');
        $config['upload_path'] = FCPATH . 'incidentimages'; 
        $config['allowed_types'] = '*';
        // $config['max_size'] = 2000;
        // $config['max_width'] = 1500;
        // $config['max_height'] = 1500;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('profile_image')) {
            $error = array('error' => $this->upload->display_errors());

            $this->response([
                'data' => $error,
                'error' => null
            ],REST_Controller::HTTP_OK);
        } else {
            $data = array('image_metadata' => $this->upload->data());
            $img['inc_images'] = $data['image_metadata']['file_name'];
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

        // if($_FILES['fileUpload']['name'] !='')
        // {
        //     $config['upload_path'] = FCPATH . 'incidentimages'; 
        //     $config['allowed_types'] = 'zip';
        //     $config['encrypt_name'] = TRUE; 
        //     $this->load->library('upload');
        //     $this->upload->initialize($config);
        //     if (!$this->upload->do_upload('fileUpload'))
        //     {
        //         $this->session->set_flashdata('error',$this->
        //         upload->display_errors());
        //         redirect('zipandUnzip/index');
        //     }else{
        //         $data      = $this->upload->data();
        //         $zip_file  = new ZipArchive;
        //         $full_path = $data['full_path'];


        //         if ($zip_file->open($full_path) === TRUE) 
        //         {
        //             $zip_file->extractTo(FCPATH . 'incidentimages');
        //             $zip_file->close();
        //             print_r($data);
        //             echo 'ok';
        //         }else{
        //             echo 'failed';
        //         }		
        //     }
        // }else{
        //     $this->session->set_flashdata('error','File not 
        //     selected');
        // }
    }
    
}