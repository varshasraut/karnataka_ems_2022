<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->steps_cnt = $this->config->item('pcr_steps');

        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));
        $this->load->model(array('student_model','school_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper', 'language_helper'));


        $this->post = $this->input->get_post(NULL);
        $this->post['base_month'] = get_base_month();
        $this->clg = $this->session->userdata('current_user');
        
        $this->pg_limit = $this->config->item('pagination_limit_clg');
        $this->pg_limits = $this->config->item('report_clg');
        $this->active_module = "M-STUD";

        $this->today = date('Y-m-d H:i:s');
    }
 
    public function student_listing($generated = false) {
            
        $this->pg_limit = 50;
        $data['page_no'] = ($this->post['page_no'] || $this->post['pglnk']) ? $this->post['page_no'] : $this->fdata['page_no'];
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        
        $page_no = 1;
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
            
        }
        
        $data['amb_reg_id'] = "";
        $data['filter'] = $filter = "";
        if(isset($_POST['filter'])){
            
            $data['filter'] = $_POST['filter'];
            if( $_POST['filter'] == 'amb_reg_no'){
                $filter = '';
                $sortby  =   $_POST['amb_reg_id'];
                $data['amb_reg_id'] = $sortby;
            }else{
                $filter =  $_POST['filter'];
            }
            
        }
        
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

           $args_dash = array(     
               'base_month' => $this->post['base_month']
           );
      
        if($this->clg->clg_group == 'UG-HEAD-MASTER'){
            $args_dash['school_headmastername'] = $this->clg->clg_ref_id;
        }
        
        if($this->clg->clg_group == 'UG-HEALTH-SUP'){
            $args_dash['school_heathsupervisior'] = $this->clg->clg_ref_id;
        } 
        
        if($this->clg->clg_group == 'UG-WARDEN'){
            $args_dash['school_warden'] = $this->clg->clg_ref_id;
        } 
        
        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;
        
        $data['page_no'] = $page_no;

        $data['get_count'] = TRUE;
        
        
        $total_cnt = $this->student_model->get_all_students($args_dash,'','',$filter,$sortby);

        $stud_info = $this->student_model->get_all_students($args_dash, $offset, $limit,$filter,$sortby);
     
    
        

        $data['per_page'] = $limit;
        $data['inc_offset'] = $offset;

        $data['student_data'] = $stud_info;

        $data['total_count'] = count($total_cnt);
       
        $data['per_page'] = $limit;

        $pgconf = array(
            'url' => base_url("students/student_listing"),
            'total_rows' => count($total_cnt),
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
            'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
            )
        );


        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);

        $this->output->add_to_position($this->load->view('frontend/students/student_list', $data, TRUE), $this->post['output_position'], TRUE);
    
    }
        
    function add_students(){
        
        $this->output->add_to_popup($this->load->view('frontend/students/add_student_view', $data, TRUE), '1000', '800');
        
    }
    function save_students(){
        //$args = $this->input->post();
        
        $args = array(
            'stud_state' => $this->post['stud_dtl_state'],
            'stud_district' => $this->post['stud_dtl_district'],
            'stud_city' => $this->post['stud_dtl_ms_city'],
            'locality' => $this->post['stud_dtl_area'],
            'lankmark' => $this->post['stud_dtl_lmark'],
            'road' => $this->post['stud_dtl_lane'],
            'house_no' => $this->post['stud_dtl_hno'],
            'stud_pincode' => $this->post['stud_dtl_pincode'],
            'stud_status' => '2',
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s')
        );

        $args = array_merge($this->post['stud'], $args);
       // var_dump($args);die();
        $res = $this->student_model->insert_students($args);
       // var_dump($res);
      //  die();
        
        if ($res) {

            $this->output->message = "<div class='success'>Details saved successfully</div>";
             $this->student_listing();
        }
    }
    function edit_students(){

         if ($this->post['stud_id'] != '') {
            $stud_id = array_map("base64_decode", $this->post['stud_id']);
        }
     
         $data['stud_action'] = $this->input->post('stud_action');
        $args_dash = array('stud_id'=>$stud_id[0]);
        $data['student_data'] = $this->student_model->get_students($args_dash);
        
        $this->output->add_to_popup($this->load->view('frontend/students/add_student_view', $data, TRUE), '1000', '800');
        
    }
    function delete_students(){
         if ($this->post['stud_id'] != '') {
            $stud_id = array_map("base64_decode", $this->post['stud_id']);
        }
        if (empty($stud_id)) {
            $this->output->message = "<div class='error'>Please select at least one item to delete</div>";
            return;
        }
        $args['stud_isdeleted'] = '1';
        $args['stud_isapproved'] = 0;

        $status = $this->student_model->delete_stud($stud_id, $args);
        
        if ($status) {
            $this->output->message = "<div class='success'>Students details is deleted successfully.</div>";
            $this->student_listing();
        } else {
            $this->output->message = "<div class='error'>Students details is deleted successfully.</div>";
        }
    }
    function approve_students(){
       
         if ($this->post['stud_id'] != '') {
            $stud_id = array_map("base64_decode", $this->post['stud_id']);
        }
        if (empty($stud_id)) {
            $this->output->message = "<div class='error'>Please select at least one item to Approve</div>";
            return;
        }
        
        $args = array('stud_isapproved'=> '1');
        $arg_stud = array('stud_id'=> $stud_id[0]);
        
        $args = array_merge($arg_stud, $args);
        
        $status = $this->student_model->updte_student_details($arg_stud,$args);
        
        if ($status) {
            $this->output->message = "<div class='success'>Students details is Approve successfully.</div>";
            $this->student_listing();
        } else {
            $this->output->message = "<div class='error'>Students details is Approve successfully.</div>";
        }
    }
    function update_students(){
        
        $data['stud_action'] = $this->input->post('stud_action');
        
        if ($this->post['stud_id'] != '') {
            $stud_id = array_map("base64_decode", $this->post['stud_id']);
        }
        $arg_stud = array('stud_id'=> $stud_id[0]);

          $args = array(
            'stud_state' => $this->post['stud_dtl_state'],
            'stud_district' => $this->post['stud_dtl_district'],
            'stud_city' => $this->post['stud_dtl_ms_city'],
            'locality' => $this->post['stud_dtl_area'],
            'lankmark' => $this->post['stud_dtl_lmark'],
            'road' => $this->post['stud_dtl_lane'],
            'house_no' => $this->post['stud_dtl_hno'],
            'pincode' => $this->post['stud_dtl_pincode'],
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'),
            'stud_isapproved'=>0
        );

        $args = array_merge($this->post['stud'], $args);
        
        $res = $this->student_model->updte_student_details($arg_stud,$args);
        
        if ($res) {

            $this->output->message = "<div class='success'>Details Updated successfully</div>";
             $this->student_listing();
        }
    
    }
}