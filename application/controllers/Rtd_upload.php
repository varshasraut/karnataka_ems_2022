<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rtd_Upload extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->active_module = "M-UPLOAD-RTD";

        $this->pg_limit = $this->config->item('pagination_limit');

        $this->load->model(array('rtd_model'));

        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper'));

        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));

        $this->post = $this->input->get_post(NULL);

        $this->clg = $this->session->userdata('current_user');
    }

    public function index($generated = false) {
        echo "This is  controller";
    }
    
    
    function upload_rtd(){
        
        $this->output->add_to_position($this->load->view('frontend/rtd_upload/add_rtd_view', $data, TRUE), 'content', TRUE);
        
    }
    function upload_B12Data(){
        
        $this->output->add_to_position($this->load->view('frontend/rtd_upload/add_b12_report', $data, TRUE), 'content', TRUE);
        
    }
    function save_upload_b12(){
        
        $post_data = $this->input->post();
     
        $filename = $_FILES["file"]["tmp_name"];
         
        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($filename, "r");
            while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
                $column_count = count($getData);
                
                if ($column_count == 6) {

                        $team_data = array(
                            //'erc_selected_date' => date('Y-m-d', strtotime($post_data['rtd_date'])),
                            'SrNo' => $getData[0],
                            'B12_Type' => $getData[1],
                            'today' => $getData[2],
                            'this_month' => $getData[3],
                            'till_date' => $getData[4],
                            'date' => $getData[5],
                            'added_date' => date('Y-m-d H:i:s'),
                            'status' => '1');

                        $insert = $this->rtd_model->insert_excel_B12($team_data);
                   
                } else {
                    $message = "column count not match";
                    //$this->output->message = "<div class='error'>" . "Manage team column count not match" . "</div>";
                }
            }
              
            if ($insert) {

                $this->output->closepopup = 'yes';
                $this->output->status = 1;
                $this->output->message = "<div class='success'>" . "added successfully" . "</div>";
               // $this->shift_amb_list();
            } else {
                $this->output->message = "<div class='error'>" . $message . "</div>";
            }
        }
    }
    function save_upload_rtd() {
        $post_data = $this->input->post();
        $filename = $_FILES["file"]["tmp_name"];
//        var_dump($_FILES["file"]["size"]);
//        die();

        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($filename, "r");
            while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
                $column_count = count($getData);
                if ($column_count == 9) {

                    //$emp_inc_data = $this->inc_model->get_amb_default_emp($getData[0], $getData[1], date('Y-m-d', strtotime($getData[2])));
                 //   if ($emp_inc_data) {
                        $team_data = array(
                            'erc_selected_date' => date('Y-m-d', strtotime($post_data['rtd_date'])),
                            'inc_ref_id' => $getData[0],
                            'district' => $getData[1],
                            'ambulance_no' => $getData[2],
                            'res_date' => date('Y-m-d', strtotime($getData[3])) ,
                            'type_inc' => $getData[4],
                            'assign_time' => $getData[5],
                           // 'ambulance_start_from_base' => $getData[4],
                            'ambulance_reach_at_scane' => $getData[6],
                            'area' => $getData[7],
                            'remark' => $getData[8],
                            'added_by' =>   $this->clg->clg_ref_id,
                            'added_date' => date('Y-m-d H:i:s'));

                        $insert = $this->rtd_model->insert_excel_rtd($team_data);
                   
                } else {
                    $message = "column count not match";
                    //$this->output->message = "<div class='error'>" . "Manage team column count not match" . "</div>";
                }
            }
              
            if ($insert) {

                $this->output->closepopup = 'yes';
                $this->output->status = 1;
                $this->output->message = "<div class='success'>" . "added successfully" . "</div>";
               // $this->shift_amb_list();
            } else {
                $this->output->message = "<div class='error'>" . $message . "</div>";
            }
        }
    }
      function upload_dist_data(){
        
        $this->output->add_to_position($this->load->view('frontend/rtd_upload/add_district_data', $data, TRUE), 'content', TRUE);
        
    }
    function uploadonroad_dist_data(){
        
        $this->output->add_to_position($this->load->view('frontend/rtd_upload/add_district_onroad_data', $data, TRUE), 'content', TRUE);
        
    }
    function uploadoffroad_dist_data(){
        
        $this->output->add_to_position($this->load->view('frontend/rtd_upload/add_district_offroad_data', $data, TRUE), 'content', TRUE);
        
    }
    function save_district_onroad_data(){
        $post_data = $this->input->post();
        $filename = $_FILES["file"]["tmp_name"];
        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($filename, "r");
            while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
                $column_count = count($getData);
                if ($column_count == 4) {

                    //$emp_inc_data = $this->inc_model->get_amb_default_emp($getData[0], $getData[1], date('Y-m-d', strtotime($getData[2])));
                 //   if ($emp_inc_data) {
                        $team_data = array(
                            'district_name' => $getData[0],
                            'base_location' => $getData[1],
                            'amb_number' => $getData[2],
                            'veh_type' => $getData[3] ,
                             'select_time' => $post_data['select_time'] ,
                            //'added_date' => date('Y-m-d H:m:s')
                        );
                      
                             $insert = $this->rtd_model->insert_onroad_detalis($team_data);
                   
                } else {
                    $message = "column count not match";
                    //$this->output->message = "<div class='error'>" . "Manage team column count not match" . "</div>";
                }
            }
              
            if ($insert) {

                $this->output->closepopup = 'yes';
                $this->output->status = 1;
                $this->output->message = "<div class='success'>" . "added successfully" . "</div>";
               // $this->shift_amb_list();
            } else {
                $this->output->message = "<div class='error'>" . $message . "</div>";
            }
        }
    }
    function save_district_offroad_data(){
        $post_data = $this->input->post();
        $filename = $_FILES["file"]["tmp_name"];
        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($filename, "r");
            while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
                $column_count = count($getData);
                if ($column_count == 4) {

                    //$emp_inc_data = $this->inc_model->get_amb_default_emp($getData[0], $getData[1], date('Y-m-d', strtotime($getData[2])));
                 //   if ($emp_inc_data) {
                    $team_data = array(
                        'district_name' => $getData[0],
                        'base_location' => $getData[1],
                        'amb_number' => $getData[2],
                        'veh_type' => $getData[3] ,
                          'select_time' => $post_data['select_time'] ,
                        //'added_date' => date('Y-m-d H:m:s')
                    );

                        $insert = $this->rtd_model->insert_offroad_detalis($team_data);
                   
                } else {
                    $message = "column count not match";
                    //$this->output->message = "<div class='error'>" . "Manage team column count not match" . "</div>";
                }
            }
              
            if ($insert) {

                $this->output->closepopup = 'yes';
                $this->output->status = 1;
                $this->output->message = "<div class='success'>" . "added successfully" . "</div>";
               // $this->shift_amb_list();
            } else {
                $this->output->message = "<div class='error'>" . $message . "</div>";
            }
        }
    }
    function save_district_data() {
        $post_data = $this->input->post();
        $filename = $_FILES["file"]["tmp_name"];
//        var_dump($_FILES["file"]["size"]);
//        die();
        
 //$delete = $this->rtd_model->delete_district_wise_offroad();
        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($filename, "r");
            while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
                $column_count = count($getData);
                if ($column_count == 5) {

                    //$emp_inc_data = $this->inc_model->get_amb_default_emp($getData[0], $getData[1], date('Y-m-d', strtotime($getData[2])));
                 //   if ($emp_inc_data) {
                        $team_data = array(
                            'district_name' => $getData[0],
                            'amb_count' => $getData[1],
                            'off_road_doctor' => $getData[2],
                            'total_offroad' => $getData[3] ,
                            'offroad_date' => $getData[4] ,
                            'select_time' => $post_data['select_time'] ,
                            'added_date' => date('Y-m-d H:m:s')
                        );
                        $insert = $this->rtd_model->insert_district_wise_offroad($team_data);
                   
                } else {
                    $message = "column count not match";
                    //$this->output->message = "<div class='error'>" . "Manage team column count not match" . "</div>";
                }
            }
              
            if ($insert) {

                $this->output->closepopup = 'yes';
                $this->output->status = 1;
                $this->output->message = "<div class='success'>" . "added successfully" . "</div>";
               // $this->shift_amb_list();
            } else {
                $this->output->message = "<div class='error'>" . $message . "</div>";
            }
        }
    }
}
