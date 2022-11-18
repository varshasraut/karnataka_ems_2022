<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Grievance extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->active_module = "M-CALLS";

        $this->pg_limit = $this->config->item('pagination_limit');
        $this->pg_limits = $this->config->item('report_clg');
        $this->allow_img_type = $this->config->item('upload_image_types');
        $this->dummy_csv = $this->config->item('dummy_csv_contact_file');
        $this->upload_path = $this->config->item('upload_path');
        $this->upload_image_size = $this->config->item('upload_image_size');
        $this->gri_pic = $this->config->item('gri_pic');
        $this->clg_pic_resize_config = $this->config->item('clg_pic_resize');
        $this->gri_doc = $this->config->item('gri_doc');
        $this->upload_rsm_type = $this->config->item('upload_rsm_types');
        $this->reply_mail = $this->config->item('reply_mail');
        $this->pg_limits = $this->config->item('report_clg');

        $this->load->model(array( 'ambmain_model','call_model', 'get_city_state_model', 'options_model', 'module_model', 'common_model', 'Pet_model', 'Ercp_model', 'amb_model', 'inc_model', 'colleagues_model', 'pcr_model', 'problem_reporting_model', 'medadv_model', 'enquiry_model', 'fleet_model', 'police_model', 'grievance_model','feedback_model'));

        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper', 'language_helper'));

        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));


        $this->site_name = $this->config->item('site_name');
        $this->post['base_month'] = get_base_month();

        $this->site = $this->config->item('site');
        $this->clg = $this->session->userdata('current_user');
        $this->default_state = $this->config->item('default_state');



        $this->post['base_month'] = get_base_month();
        $this->clg = $this->session->userdata('current_user');
        $this->post = $this->input->get_post(NULL);


        $this->clg = $this->session->userdata('current_user');

        $this->today = date('Y-m-d H:i:s');


        if ($this->post['filters'] == 'reset') {
            $this->session->unset_userdata('grievance_filter');
        }

        if ($this->session->userdata('grievance_filter')) {
            $this->fdata = $this->session->userdata('grievance_filter');
        }
        $this->post['base_month'] = get_base_month();
    }

    public function index($generated = false) {


        ///////////////  Filters //////////////////

        $data['search'] = ($this->post['search']) ? $this->post['search'] : $this->fdata['search'];


        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];




        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        $data['complaint_type'] = "";
        $data['filter'] = $filter = "";
        $data['filter'] = $_POST['filter'] ? $this->post['filter'] : $this->fdata['filter'];

        $data['complaint_type'] = $_POST['complaint_type'] ? $this->post['complaint_type'] : $this->fdata['complaint_type'];
        $data['district_id'] = $_POST['district_id'] ? $this->post['district_id'] : $this->fdata['district_id'];
        $data['inc_date'] = $_POST['inc_date'] ? $this->post['inc_date'] : $this->fdata['inc_date'];
        $data['status'] = $_POST['status'] ? $this->post['status'] : $this->fdata['status'];
        $data['complaint_id'] = $_POST['complaint_id'] ? $this->post['complaint_id'] : $this->fdata['complaint_id'];
        $data['incident_id'] = $_POST['incident_id'] ? $this->post['incident_id'] : $this->fdata['incident_id'];
            $data['gri_date_serach'] = $_POST['gri_date_serach'] ? $this->post['gri_date_serach'] : $this->fdata['gri_date_serach'];
            $data['gri_E_Complaint'] = $_POST['gri_E_Complaint'] ? $this->post['gri_E_Complaint'] : $this->fdata['gri_E_Complaint'];
            
        if (isset($data['filter'])) {
            
            if ($data['filter'] == 'complaint_type') {
                $filter = '';
                $sortby['complaint_type'] = $data['complaint_type'];
                $data['complaint_type'] = $sortby['complaint_type'];
                if ($data['complaint_type'] == 'e_complaint') {
                    $filter = '';
                    $sortby['gri_E_Complaint'] = $data['gri_E_Complaint'];
                    $data['gri_E_Complaint'] = $data['gri_E_Complaint'];
                   }
            } else if ($data['filter'] == 'dst_name') {
                $filter = '';
                $sortby['district_id'] = $data['district_id'];
                $data['district_id'] = $sortby['district_id'];
            } else if ($data['filter'] == 'status') {
                $filter = '';
                $sortby['status'] = $data['status'];
                $data['status'] = $sortby['status'];
            } else if ($data['filter'] == 'complaint_id') {
                $filter = '';
                $sortby['complaint_id'] = $data['complaint_id'];
                $data['complaint_id'] = $data['complaint_id'];
            }
            else if ($data['filter'] == 'incident_id') {
            $filter = '';
            $sortby['incident_id'] = $data['incident_id'];
            $data['incident_id'] = $data['incident_id'];
            }
            else if ($data['filter'] == 'Date') {
            $filter = '';
                $sortby['gri_date_serach'] = $data['gri_date_serach'];
                $data['gri_date_serach'] = $data['gri_date_serach'];
            }
           
        }
        $this->session->set_userdata('grievance_filter', $data);
        
          if($this->clg->clg_group == 'UG-GrievianceManager' || $this->clg->clg_group ==  'UG-GrievanceManager'){           
            
            $args['clg_senior'] = $this->clg->clg_ref_id;
            $data['clg_senior'] = $this->clg->clg_ref_id;
            
            
            $clg_args = array('clg_senior'=>$this->clg->clg_ref_id,'clg_group'=>'UG-Grievance');
           
            $data['ero_clg'] = $this->colleagues_model->get_clg_data($clg_args);
            
            foreach($data['ero_clg'] as $ero){
                $child_ero[] = $ero->clg_ref_id;
            }

            if(is_array($child_ero)){
                $child_ero = implode("','", $child_ero);
            }
            
            
            
            //$data['gc_added_by'] = $child_ero;
            
            $data['base_month'] = $this->post['base_month'];
            
        } else {
            
                $data['operator_id'] = $this->clg->clg_ref_id;
                $data['base_month'] = $this->post['base_month'];
        }
        
        ///////////limit & offset////////

        $data['get_count'] = TRUE;
       // $data['gc_inc_call_type'] = 'PREV';
       $data['clg_group'] = $this->clg->clg_group;
        $data['total_count'] = $this->grievance_model->get_inc_by_grievance($data, '', '', $filter, $sortby);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        unset($data['get_count']);


        $data['clg_group'] = $this->clg->clg_group;
        $data['inc_info'] = $this->grievance_model->get_inc_by_grievance($data, $offset, $limit, $filter, $sortby);

        /////////////////////////
        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("grievance/gri_dash"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

           // Total Closure 
       $month = date('m');
       $year = date('Y');
       $day = date('d');
       $query_date = $year.'-'.$month.'-'.$day;

       //echo $query_date;
       $first_day_this_month = date('Y-m-01', strtotime($query_date));

       // Last day of the month.
       $last_day_this_month = date('Y-m-t', strtotime($query_date));
       $month_report_args =  array('from_date' => date('Y-m-d',strtotime($first_day_this_month)),
                      'to_date' => date('Y-m-d', strtotime($last_day_this_month)));

       $month_report_args['get_count'] = 'true';
       $month_report_args['operator_id'] = $this->clg->clg_ref_id;
       
       $data['get_all_calls'] = $this->grievance_model->get_all_calls($month_report_args);
       $data['get_all_closure_calls'] = $this->grievance_model->get_all_closure_calls($month_report_args);
       $data['get_all_pending_calls'] = $this->grievance_model->get_all_pending_calls($month_report_args);
      
       //Today call
       $today_report_args =  array('from_date' => date('Y-m-d',strtotime($query_date)),
                      'to_date' => date('Y-m-d', strtotime($query_date)));
       $today_report_args['get_count'] = 'true';
       $today_report_args['operator_id'] = $this->clg->clg_ref_id;

      //$data['get_all_today_calls'] = $this->grievance_model->get_all_calls($today_report_args);
      $data['get_today_closure_calls'] = $this->grievance_model->get_all_closure_calls($today_report_args);
      $data['get_today_pending_calls'] = $this->grievance_model->get_all_pending_calls($today_report_args);
     

        $data['pgconf'] = $pgconf;
        $data['pagination'] = get_pagination($pgconf);

        /////////////////////////////////

        $data['page_records'] = count($data['inc_info']);


        $data['default_state'] = $this->default_state;
        $this->output->add_to_position($this->load->view('frontend/Gravience/grivance_previous_dashboard_view', $data, TRUE), 'content', TRUE);
        
          if($this->clg->clg_group ==  'UG-Grievance' ){
             $this->output->template = "calls";
        }

        $this->output->template = "calls";
    }
    function show_gri_sub_type(){
        $chief_complete = $this->input->post('chief_complete');
        $args = array('chief_complete' => $chief_complete);
        $data['id']=$chief_complete;
       /// $data['gri_data'] = $this->grievance_model->get_gri_sub_type($args);
       //var_dump($data['id']);die();
        $this->output->add_to_position($this->load->view('frontend/Gravience/gri_subtype_view', $data, TRUE), 'gri_sub_type', TRUE);
        
    }
    
    public function grievance_call_list($generated = false) {


        ///////////////  Filters //////////////////

        $data['search'] = ($this->post['search']) ? $this->post['search'] : $this->fdata['search'];


        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];




        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        $data['complaint_type'] = "";
        $data['filter'] = $filter = "";
        $data['filter'] = $_POST['filter'] ? $this->post['filter'] : $this->fdata['filter'];

        $data['complaint_type'] = $_POST['complaint_type'] ? $this->post['complaint_type'] : $this->fdata['complaint_type'];
        $data['district_id'] = $_POST['district_id'] ? $this->post['district_id'] : $this->fdata['district_id'];
        $data['inc_date'] = $_POST['inc_date'] ? $this->post['inc_date'] : $this->fdata['inc_date'];
        $data['status'] = $_POST['status'] ? $this->post['status'] : $this->fdata['status'];
        $data['complaint_id'] = $_POST['complaint_id'] ? $this->post['complaint_id'] : $this->fdata['complaint_id'];
        $data['incident_id'] = $_POST['incident_id'] ? $this->post['incident_id'] : $this->fdata['incident_id'];
        $data['gri_date_serach'] = $_POST['gri_date_serach'] ? $this->post['gri_date_serach'] : $this->fdata['gri_date_serach'];
        $data['gri_E_Complaint'] = $_POST['gri_E_Complaint'] ? $this->post['gri_E_Complaint'] : $this->fdata['gri_E_Complaint'];

        if (isset($data['filter'])) {


            if ($data['filter'] == 'complaint_type') {
                $filter = '';
                $sortby['complaint_type'] = $data['complaint_type'];
                $data['complaint_type'] = $sortby['complaint_type'];
                if ($data['complaint_type'] == 'e_complaint') {
                    $filter = '';
                    $sortby['gri_E_Complaint'] = $data['gri_E_Complaint'];
                    $data['gri_E_Complaint'] = $data['gri_E_Complaint'];
                   }
            } else if ($data['filter'] == 'dst_name') {
                $filter = '';
                $sortby['district_id'] = $data['district_id'];
                $data['district_id'] = $sortby['district_id'];
            } else if ($data['filter'] == 'status') {
                $filter = '';
                $sortby['status'] = $data['status'];
                $data['status'] = $sortby['status'];
            } else if ($data['filter'] == 'complaint_id') {
                $filter = '';
                $sortby['complaint_id'] = $data['complaint_id'];
                $data['complaint_id'] = $data['complaint_id'];
            }else if ($data['filter'] == 'incident_id') {
                $filter = '';
                $sortby['incident_id'] = $data['incident_id'];
                $data['incident_id'] = $data['incident_id'];
            }
            else if ($data['filter'] == 'Date') {
                $filter = '';
                    $sortby['gri_date_serach'] = $data['gri_date_serach'];
                    $data['gri_date_serach'] = $data['gri_date_serach'];
                }
           
                    
        }

        $this->session->set_userdata('grievance_filter', $data);
        
        if($this->clg->clg_group == 'UG-GrievianceManager' || $this->clg->clg_group ==  'UG-GrievanceManager'){           
            
            $args['clg_senior'] = $this->clg->clg_ref_id;
            $data['clg_senior'] = $this->clg->clg_ref_id;
            
            
            $clg_args = array('clg_senior'=>$this->clg->clg_ref_id,'clg_group'=>'UG-Grievance');
            $data['ero_clg'] = $this->colleagues_model->get_clg_data($clg_args);
            
            foreach($data['ero_clg'] as $ero){
                $child_ero[] = $ero->clg_ref_id;
            }

            if(is_array($child_ero)){
                $child_ero = implode("','", $child_ero);
            }
            
            
            
            $data['gc_added_by'] = $child_ero;
            
            $data['base_month'] = $this->post['base_month'];
            
        } else {
            
                $data['operator_id'] = $this->clg->clg_ref_id;
                $data['base_month'] = $this->post['base_month'];
        }
        ///////////limit & offset////////

        $data['get_count'] = TRUE;
        //$data['gc_inc_call_type'] = 'PREV';
        if($this->clg->clg_group != 'UG-GrievianceManager'){    
        $data['clg_group'] = $this->clg->clg_group;
        }
        $data['total_count'] = $this->grievance_model->get_inc_by_grievance($data, '', '', $filter, $sortby);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        unset($data['get_count']);



        $data['inc_info'] = $this->grievance_model->get_inc_by_grievance($data, $offset, $limit, $filter, $sortby);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("grievance/gri_dash"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

           // Total Closure 
       $month = date('m');
       $year = date('Y');
       $day = date('d');
       $query_date = $year.'-'.$month.'-'.$day;

       //echo $query_date;
       $first_day_this_month = date('Y-m-01', strtotime($query_date));

       // Last day of the month.
       $last_day_this_month = date('Y-m-t', strtotime($query_date));
       $month_report_args =  array('from_date' => date('Y-m-d',strtotime($first_day_this_month)),
                      'to_date' => date('Y-m-d', strtotime($last_day_this_month)));

       $month_report_args['get_count'] = 'true';
       if($this->clg->clg_group != 'UG-GrievianceManager'){ 
       $month_report_args['operator_id'] = $this->clg->clg_ref_id;
       }
       $data['get_all_calls'] = $this->grievance_model->get_all_calls($month_report_args);
       $data['get_all_closure_calls'] = $this->grievance_model->get_all_closure_calls($month_report_args);
       $data['get_all_pending_calls'] = $this->grievance_model->get_all_pending_calls($month_report_args);
      
       //Today call
       $today_report_args =  array('from_date' => date('Y-m-d',strtotime($query_date)),
                      'to_date' => date('Y-m-d', strtotime($query_date)));
       $today_report_args['get_count'] = 'true';
       if($this->clg->clg_group != 'UG-GrievianceManager'){ 
       $today_report_args['operator_id'] = $this->clg->clg_ref_id;
       }
      //$data['get_all_today_calls'] = $this->grievance_model->get_all_calls($today_report_args);
      $data['get_today_closure_calls'] = $this->grievance_model->get_all_closure_calls($today_report_args);
      $data['get_today_pending_calls'] = $this->grievance_model->get_all_pending_calls($today_report_args);
     
        $data['pgconf'] = $pgconf;
        $data['pagination'] = get_pagination($pgconf);

        /////////////////////////////////

        $data['page_records'] = count($data['inc_info']);

        $data['default_state'] = $this->default_state;
        $this->output->add_to_position($this->load->view('frontend/Gravience/grivance_previous_dashboard_view', $data, TRUE), 'content', TRUE);

           if($this->clg->clg_group ==  'UG-Grievance' ){
             $this->output->template = "calls";
        }
    }

    function close_complaint() {

        $data = array();

        $data['gc_id'] = base64_decode($this->post['gc_id']);

        $data['gc_inc_ref_id'] = base64_decode($this->post['gc_inc_ref_id']);

        $data['gc_complaint_type'] = base64_decode($this->post['gc_complaint_type']);

        $data['action_type'] = ucwords($data['gc_complaint_type']) . ' Complaint ';
        if($this->clg->clg_group != 'UG-GrievianceManager'){ 
        $data['clg_group'] = $this->clg->clg_group;
        }
        $data['grievance_data'] = $this->grievance_model->get_inc_by_grievance($data, $offset, $limit);



        $data['update'] = 'update';

        $args = array(
            'gc_inc_ref_id' => base64_decode($this->post['gc_inc_ref_id'])
        );
        $data['clg_group'] = $this->clg->clg_group;
        $data['cl_dtl'] = $this->grievance_model->get_inc_by_grievance($args);
        $data['gr_clg'] = $this->grievance_model->get_gr_clg();
       
        $args = array('gc_id' => $data['gc_id'],'Grievace' => 'Grievace');
        $his = $this->ambmain_model->get_grievance_photo($args);
        foreach($his as $history){ 
        // var_dump($history);
        // $args = array('mt_id' => $this->post['mt_id'], 're_request_id' => $history->re_request_id);
        // $history->his_photo[] = $this->ambmain_model->get_history_photo($args);
        $data['his'][] = $history;
        }
        //var_dump($data['gr_clg']);die;
        $this->output->add_to_position($this->load->view('frontend/Gravience/external_close_complaint_view', $data, TRUE), $output_position, TRUE);
    }

    function prev_gri_call_info() {


        $args = array(
            'gc_id' => $this->post['gc_id']
        );
        $data['clg_group'] = $this->clg->clg_group;
        $data['cl_dtl'] = $this->Medadv_model->get_inc_by_grievance($args);



        $this->output->add_to_position($this->load->view('frontend/Gravience/prev_gri_call_dtl', $data, TRUE), $this->post['output_position'], TRUE);
    }

    function grievance_call_update() {


        $gri_data = $this->post['gri'];
        $gri_data['gc_modify_by'] = $this->clg->clg_ref_id;
        $gri_data['gc_modify_date'] = date('Y-m-d H:i:s');
        if ($this->post['gri']['gc_closure_status'] == 'complaint_close') {
            $gri_data['gc_is_closed'] = '1';
            $gri_data['gc_close_by'] = $this->clg->clg_ref_id;
            $gri_data['gc_closed_date'] = date('Y-m-d H:i:s');
        }


        $start_date = new DateTime(date('Y-m-d h:i:s', strtotime($gri_data['gc_time_required'])));

        $since_start = $start_date->diff(new DateTime(date('Y-m-d h:i:s')));

        $resolve_time = $since_start->h . ':' . $since_start->i . ':' . $since_start->s;

        $gri_data['gc_time_required'] = date("H:i:s", strtotime($resolve_time));



        $result = $this->grievance_model->grievance_update_call_data($gri_data);


        if ($result) {

            $this->output->status = 1;

            $this->output->closepopup = 'yes';

            $this->output->message = "<div class='success'>Grievance Updated Successfully</div><script>window.location.reload(true);</script>";
        }
    }

    function griviance_call_details() {

        if (!isset($this->post['inc_ref_id'])) {

            $data['opt_id'] = $this->post['opt_id'];

            $data['sub_id'] = $this->post['sub_id'];

            $args = array('opt_id' => $data['opt_id'],
                'sub_id' => $data['sub_id'],
                'sub_type' => 'ADV');

            update_opt_status($args);

            $args = array(
                'sub_id' => $data['sub_id'],
                'operator_id' => $this->clg->clg_ref_id,
                'operator_type' => $this->clg->clg_group,
                'base_month' => $this->post['base_month'],
                'sub_type' => 'ADV',
                'sub_status' => 'ATNG'
            );



            $this->common_model->assign_operator($args);


            $args = array(
                'opt_id' => $data['opt_id'],
                'sub_id' => $data['sub_id'],
                'base_month' => $this->post['base_month']
            );

            $data['cl_dtl'] = $this->Medadv_model->call_detials($args);
        } else {

            $args = array(
                'inc_ref_id' => trim($this->post['inc_ref_id']),
            );

            $data['inc_ref_id'] = trim($this->post['inc_ref_id']);

            $this->session->set_userdata('ercp_inc_ref_id', $this->post['inc_ref_id']);

            $data['cl_dtl'] = $this->problem_reporting_model->get_grivance_call_detials($args);
            //$data['cl_dtl'] = $this->grievance_model->get_inc_by_grievance($args);
            

            $this->session->set_userdata('caller_information', $data['cl_dtl']);
            $this->session->set_userdata('inc_ref_id', $data['inc_ref_id']);

            $args_remark = array('re_id' => $data['cl_dtl'][0]->inc_ero_standard_summary);
            $standard_remark = $this->call_model->get_ero_summary_remark($args_remark);
            $data['re_name'] = $standard_remark[0]->re_name;
        }

        if (empty($data['cl_dtl'])) {
            $this->output->message = "<p>No Record Found</p>";

            return;
        }

        $this->output->add_to_position($this->load->view('frontend/Gravience/gravience_inc_details_view', $data, TRUE), 'content', TRUE);
    }

    function show_external_complaint_type() {

        $data['comp_type'] = $this->post['value'];

        $this->output->add_to_position($this->load->view('frontend/Gravience/grivance_search_action_view', $data, TRUE), 'grivance_inc_action', TRUE);
    }

    function show_complaint_type() {

       // $data['gc_inc_call_type'] = 'PREV';

        $this->output->add_to_position($this->load->view('frontend/Gravience/manual_complaint_type_view', $data, TRUE), 'grivience_info', TRUE);
    }

    function show_inc_search() {

        $data['default_state'] = $this->default_state;
        $this->output->add_to_position($this->load->view('frontend/Gravience/grivance_inc_filter_view', $data, TRUE), 'grivance_inc_filter', TRUE);
    }

    function show_manual_inc_search() {

        $data['default_state'] = $this->default_state;
        $this->output->add_to_position($this->load->view('frontend/Gravience/grivance_manual_inc_filter_view', $data, TRUE), 'grivance_inc_filter', TRUE);
    }

    function grivience_manual_pt_inc_list() {

        if (!empty($this->post['inc_time'])) {

            $inctm = get_formated_time($this->post['inc_time']);

            $this->post['inc_timef'] = $inctm[0];

            $this->post['inc_timet'] = $inctm[1];
        }



        if (!empty($this->post['inc_date']) && empty($this->post['inc_id'])) {

            $this->post['inc_date'] = date('Y-m-d', strtotime($this->post['inc_date']));



            $this->post['inc_datef'] = $this->post['inc_date'] . " " . $this->post['inc_timef'];

            $this->post['inc_datet'] = $this->post['inc_date'] . " " . $this->post['inc_timet'];
        }
        if (!empty($this->post['inc_district']) && empty($this->post['inc_date'])) {

            $this->post['inc_date_time'] = date('Y-m-d');
        }

        $base_month = $this->post['base_month'];

        $args = array(
            'base_month' => $this->post['base_month'],
        );


        $arg = array_merge($this->post, $args);

        $data['pt_details'] = $this->Pet_model->get_pt_inc($arg);

        $this->session->unset_userdata('inc_act');

        $data['cl_purpose'] = $this->post['cl_purpose'];

        $this->output->add_to_position($this->load->view('frontend/Gravience/manual_inc_details_view', $data, TRUE), 'inc_details', TRUE);
    }

    function grivience_pt_inc_list() {

        if (!empty($this->post['inc_time'])) {

            $inctm = get_formated_time($this->post['inc_time']);

            $this->post['inc_timef'] = $inctm[0];

            $this->post['inc_timet'] = $inctm[1];
        }



        if (!empty($this->post['inc_date']) && empty($this->post['inc_id'])) {

            $this->post['inc_date'] = date('Y-m-d', strtotime($this->post['inc_date']));



            $this->post['inc_datef'] = $this->post['inc_date'] . " " . $this->post['inc_timef'];

            $this->post['inc_datet'] = $this->post['inc_date'] . " " . $this->post['inc_timet'];
        }
        if (!empty($this->post['inc_district']) && empty($this->post['inc_date'])) {

            $this->post['inc_date_time'] = date('Y-m-d');
        }

        $base_month = $this->post['base_month'];

        $args = array(
            'base_month' => $this->post['base_month'],
        );


        $arg = array_merge($this->post, $args);

        $data['pt_details'] = $this->Pet_model->get_pt_inc($arg);

        $this->session->unset_userdata('inc_act');

        $data['cl_purpose'] = $this->post['cl_purpose'];

        $this->output->add_to_position($this->load->view('frontend/Gravience/inc_details_view', $data, TRUE), 'inc_details', TRUE);
    }

    function gr_inc_info() {
        $data['default_state'] = $this->default_state;

        if ($this->session->userdata('inc_act')['inc_ref_id'] == $this->post['inc_ref_id'] && $this->session->userdata('inc_act')['act'] == 'close') {

            $this->output->add_to_position("", 'inc_pt_info', TRUE);

            $scrpt = "<script>$('.incact').val('SELECT');$('#inc_fwd_note').show();</script>";

            $this->output->add_to_position($scrpt, 'popup_div', TRUE);

            $this->session->unset_userdata('inc_act');

            $this->output->add_to_position('', 'fwdcmp_btn', TRUE);
        } else {

            $inc_act = array('inc_ref_id' => $this->post['inc_ref_id'], 'act' => 'close');

            $this->session->set_userdata('inc_act', $inc_act);

            $args = array(
                'inc_ref_id' => $this->post['inc_ref_id'],
                'base_month' => $this->post['base_month']
            );

            $data['pt_info'] = $this->Pet_model->get_ptinc_info($args);


            $data['inc_amb'] = $this->inc_model->get_inc_ambulance($args);
            if ($data['inc_amb'][0]->amb_rto_register_no != '') {
                $data['ambdtl'] = true;
            }
            $data['cl_dtl'] = $this->problem_reporting_model->get_grivance_call_detials($args);
            $data['fd_dtl'] = $this->feedback_model->get_feedback_call_detials($args);
//var_dump($data['fd_dtl']);die;
            
            $data['increfid'] = $this->post['inc_ref_id'];

            $scrpt = "<script>$('.incact').val('SELECT');$('.inc_act" . $this->post['inc_ref_id'] . "').val('CLOSE'); $('#inc_fwd_note').hide();</script>";


            $this->output->add_to_position($scrpt, 'popup_div', TRUE);

            $this->output->add_to_position($this->load->view('frontend/Gravience/inc_info_view', $data, TRUE), 'inc_pt_info', TRUE);

         //   $data['gc_inc_call_type'] = 'PREV';

            $this->output->add_to_position($this->load->view('frontend/Gravience/external_complaint_type_view', $data, TRUE), 'grivience_info', TRUE);

            $this->output->add_to_position($fwdbtn, 'fwdcmp_btn', TRUE);
        }
    }

    function gr_manual_inc_info() {
       $gc_complaint_type = $this->post['gri']['gc_complaint_type'];
       $data['default_state'] = $this->default_state;
        if ($this->session->userdata('inc_act')['inc_ref_id'] == $this->post['inc_ref_id'] && $this->session->userdata('inc_act')['act'] == 'close') {

            $this->output->add_to_position("", 'inc_pt_info', TRUE);

            $scrpt = "<script>$('.incact').val('SELECT');$('#inc_fwd_note').show();</script>";

            $this->output->add_to_position($scrpt, 'popup_div', TRUE);

            $this->session->unset_userdata('inc_act');

            $this->output->add_to_position('', 'fwdcmp_btn', TRUE);
        } else {







            //////////////////////////////////////////////////////////////////////////////



            $inc_act = array('inc_ref_id' => $this->post['inc_ref_id'], 'act' => 'close');

            $this->session->set_userdata('inc_act', $inc_act);

            $args = array(
                'inc_ref_id' => $this->post['inc_ref_id'],
                'base_month' => $this->post['base_month']
            );

            $data['pt_info'] = $this->Pet_model->get_ptinc_info($args);
            $data['inc_amb'] = $this->inc_model->get_inc_ambulance($args);
            $data['cl_dtl'] = $this->problem_reporting_model->get_grivance_call_detials($args);
            $data['fd_dtl'] = $this->feedback_model->get_feedback_call_detials($args);
            $data['increfid'] = $this->post['inc_ref_id'];

            $scrpt = "<script>$('.incact').val('SELECT');$('.inc_act" . $this->post['inc_ref_id'] . "').val('CLOSE'); $('#inc_fwd_note').hide();</script>";


            $this->output->add_to_position($scrpt, 'popup_div', TRUE);

            $this->output->add_to_position($this->load->view('frontend/Gravience/inc_info_view', $data, TRUE), 'inc_pt_info', TRUE);

           // $data['gc_inc_call_type'] = 'MANUAL';
            $data['comp_type'] = $gc_complaint_type; 
            $this->output->add_to_position($this->load->view('frontend/Gravience/external_complaint_type_view', $data, TRUE), 'grivience_info', TRUE);

            $this->output->add_to_position($fwdbtn, 'fwdcmp_btn', TRUE);
        }
    }

    function save_call() {
        $clg_group =  $this->clg->clg_group;
        
        if($clg_group == 'UG-COMPLIANCE'){
            $inc_id = $this->post['gri']['gc_inc_ref_id'];
        if ($inc_id == '') {
            $inc_id = generate_grievance_inc_ref_id();
            update_grievance_inc_ref_id($inc_id);
        }
       
        
        /*if (isset($_FILES['grievance_photo'])) {

            $img_extension = pathinfo($_FILES['grievance_photo']['name'], PATHINFO_EXTENSION);

            $img_size = $_FILES['grievance_photo']['size'];

            $grievance_photo = $this->gri_pic;

            $this->upload->initialize($grievance_photo);
           if (!$this->upload->do_upload('grievance_photo')) {

                $this->output->message = "<div class='error'>Profile photo size or type invalid..!! Please upload again..!</div>";
                $upload_err = TRUE;
            } else {


                $data = array('upload_data' => $this->upload->data());
                
                
                $new_img = $data['upload_data']['file_path'] . "thumb/" . $data['upload_data']['raw_name'] . $data['upload_data']['file_ext'];

                $config = $this->clg_pic_resize_config;
                
                $config['source_image'] = $data['upload_data']['full_path'];

                $config['new_image'] = $new_img;

                $this->image_lib->initialize($config);

                if (!$this->image_lib->resize()) {

                    $this->output->message = "<div class='error'>Profile photo size or type invalid..!! Please upload again..!</div>";
                }

                $args['clg_photo'] = $_FILES['grievance_photo']['name'];
            }
        }*/
        $gri = $this->post['gri'];

        $args = array(
            //'gri_doc' => $gri_doc,
            'gc_base_month' => $this->post['base_month'],
            'gc_district_code' => $this->post['maintaince_district'],
            'gc_ambulance_no' => $this->post['maintaince_ambulance'],
            'gc_added_date' => $this->today,
            'gc_added_by' => $this->clg->clg_ref_id,
            'gc_modify_date' => $this->today,
            'gc_modify_by' => $this->clg->clg_ref_id,
            'gc_date_time' => date('Y-m-d h:i:s', strtotime($gri['gc_date_time'])),
            'gc_complaint_register_by' => $this->clg->clg_ref_id,
//            'gc_closure_status' => 'complaint_open'
        );

        if ($this->post['gri']['gc_closure_status'] == '') {
            $args['gc_closure_status'] = 'complaint_open';
        }

        if ($this->post['gri']['gc_closure_status'] == 'complaint_close') {
            $gri_data['gc_is_closed'] = '1';
            $gri_data['gc_modify_by'] = $this->clg->clg_ref_id;
            $gri_data['gc_close_by'] = $this->clg->clg_ref_id;
            $gri_data['gc_modify_date'] = date('Y-m-d H:i:s');
            $gri_data['gc_closed_date'] = date('Y-m-d H:i:s');
            $gri_data['gc_inc_ref_id'] = $this->post['gri']['gc_inc_ref_id'];


            $result = $this->grievance_model->grievance_update_call_data($gri_data);
        }

        if ($this->post['gri']['gc_inc_ref_id'] == '') {
            $args['gc_inc_ref_id'] = 'GC-' . $inc_id;
        }


        $args = array_merge($this->post['gri'], $args);
        $compalint_type = $args['gc_complaint_type'];
        $call_type = $args['gc_inc_call_type'];
        //var_dump($args);die();
        $police = $this->grievance_model->add_gri_call($args);
        
        if (isset($_FILES['gri_doc']) && !empty($_FILES['gri_doc'])) {
            foreach ($_FILES['gri_doc']['name'] as $key => $image) {
                
             
                //var_dump($_FILES['gri_doc']['name']);
                $_FILES['photo']['name'] = $_FILES['gri_doc']['name'][$key];
                $_FILES['photo']['type'] = $_FILES['gri_doc']['type'][$key];
                $_FILES['photo']['tmp_name'] = $_FILES['gri_doc']['tmp_name'][$key];
                $_FILES['photo']['error'] = $_FILES['gri_doc']['error'][$key];
                $_FILES['photo']['size'] = $_FILES['gri_doc']['size'][$key];

           
            $resume_extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $_FILES['photo']['name'] = $this->sanitize_string($_FILES['photo']['name']);
    
            $gri_doc = $this->gri_doc;
            $this->upload->initialize($gri_doc);
            
             if (!$this->upload->do_upload('photo')) {
                $msg = $this->upload->display_errors();
                $this->output->message = "<div class='error'>$msg .. Please upload again..!</div>";
                $upload_err = TRUE;
            } 

                $media_args = array();
                $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['user_id'] = $police;
                
                $media_args['media_data'] = 'Government Compliance Desk';
                $this->ambmain_model->insert_media_maintance($media_args);
            
        }
  
        }

        if(!empty($_FILES['grievance_photo']['name'])){
            
            foreach ($_FILES['grievance_photo']['name'] as $key => $image) {
                $media_args = array();
                $_FILES['photo']['name']= $_FILES['grievance_photo']['name'][$key];
                $_FILES['photo']['type']= $_FILES['grievance_photo']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['grievance_photo']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['grievance_photo']['error'][$key];
                $_FILES['photo']['size']= $_FILES['grievance_photo']['size'][$key];
                $_FILES['photo']['name'] = time() .'_'. $this->sanitize_file_name($_FILES['photo']['name']);
               

                $rsm_config = $this->gri_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                            $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                            $upload_err = TRUE;
                }
                $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['user_id'] = $police;
                //$media_args['media_data'] = $call_type.'-'.$compalint_type;
                $media_args['media_data'] = 'Grievace';
                $this->ambmain_model->insert_media_maintance($media_args);
               
            }
        }

        $police_operator = array(
            'sub_id' => $this->post['inc_ref_id'],
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'sub_status' => 'ATND',
        );

        $police_args = array(
            'sub_id' => $this->post['inc_ref_id'],
            'operator_type' => $this->clg->clg_group,
        );

        $police_ope = $this->common_model->update_operator($police_args, $police_operator);

        if ($police) {

            $this->output->message = "<div class='success'>Details saved successfully</div><script>window.location.reload(true);</script>";
        }

        }else{

        
        $inc_id = $this->post['gri']['gc_inc_ref_id'];
        if ($inc_id == '') {
            $inc_id = generate_grievance_inc_ref_id();
            update_grievance_inc_ref_id($inc_id);
        }
       
        
        /*if (isset($_FILES['grievance_photo'])) {

            $img_extension = pathinfo($_FILES['grievance_photo']['name'], PATHINFO_EXTENSION);

            $img_size = $_FILES['grievance_photo']['size'];

            $grievance_photo = $this->gri_pic;

            $this->upload->initialize($grievance_photo);
           if (!$this->upload->do_upload('grievance_photo')) {

                $this->output->message = "<div class='error'>Profile photo size or type invalid..!! Please upload again..!</div>";
                $upload_err = TRUE;
            } else {


                $data = array('upload_data' => $this->upload->data());
                
                
                $new_img = $data['upload_data']['file_path'] . "thumb/" . $data['upload_data']['raw_name'] . $data['upload_data']['file_ext'];

                $config = $this->clg_pic_resize_config;
                
                $config['source_image'] = $data['upload_data']['full_path'];

                $config['new_image'] = $new_img;

                $this->image_lib->initialize($config);

                if (!$this->image_lib->resize()) {

                    $this->output->message = "<div class='error'>Profile photo size or type invalid..!! Please upload again..!</div>";
                }

                $args['clg_photo'] = $_FILES['grievance_photo']['name'];
            }
        }*/
        $gri = $this->post['gri'];

        $args = array(
            //'gri_doc' => $gri_doc,
            'gc_base_month' => $this->post['base_month'],
            'gc_district_code' => $this->post['maintaince_district'],
            'gc_ambulance_no' => $this->post['maintaince_ambulance'],
            'gc_added_date' => $this->today,
            'gc_added_by' => $this->clg->clg_ref_id,
            'gc_modify_date' => $this->today,
            'gc_modify_by' => $this->clg->clg_ref_id,
            'gc_date_time' => date('Y-m-d h:i:s', strtotime($gri['gc_date_time'])),
            'gc_complaint_register_by' => $this->clg->clg_ref_id,
//            'gc_closure_status' => 'complaint_open'
        );

        if ($this->post['gri']['gc_closure_status'] == '') {
            $args['gc_closure_status'] = 'complaint_open';
        }

        if ($this->post['gri']['gc_closure_status'] == 'complaint_close') {
            $gri_data['gc_is_closed'] = '1';
            $gri_data['gc_modify_by'] = $this->clg->clg_ref_id;
            $gri_data['gc_close_by'] = $this->clg->clg_ref_id;
            $gri_data['gc_modify_date'] = date('Y-m-d H:i:s');
            $gri_data['gc_closed_date'] = date('Y-m-d H:i:s');
            $gri_data['gc_inc_ref_id'] = $this->post['gri']['gc_inc_ref_id'];


            $result = $this->grievance_model->grievance_update_call_data($gri_data);
        }

        if ($this->post['gri']['gc_inc_ref_id'] == '') {
            $args['gc_inc_ref_id'] = 'G-' . $inc_id;
        }


        $args = array_merge($this->post['gri'], $args);
        $compalint_type = $args['gc_complaint_type'];
        $call_type = $args['gc_inc_call_type'];
        //var_dump($args);die();
        $police = $this->grievance_model->add_gri_call($args);
        
        if (isset($_FILES['gri_doc']) && !empty($_FILES['gri_doc'])) {
            foreach ($_FILES['gri_doc']['name'] as $key => $image) {
                
             
                //var_dump($_FILES['gri_doc']['name']);
                $_FILES['photo']['name'] = $_FILES['gri_doc']['name'][$key];
                $_FILES['photo']['type'] = $_FILES['gri_doc']['type'][$key];
                $_FILES['photo']['tmp_name'] = $_FILES['gri_doc']['tmp_name'][$key];
                $_FILES['photo']['error'] = $_FILES['gri_doc']['error'][$key];
                $_FILES['photo']['size'] = $_FILES['gri_doc']['size'][$key];

           
            $resume_extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $_FILES['photo']['name'] = $this->sanitize_string($_FILES['photo']['name']);
    
            $gri_doc = $this->gri_doc;
            $this->upload->initialize($gri_doc);
            
             if (!$this->upload->do_upload('photo')) {
                $msg = $this->upload->display_errors();
                $this->output->message = "<div class='error'>$msg .. Please upload again..!</div>";
                $upload_err = TRUE;
            } 

                $media_args = array();
                $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['user_id'] = $police;
                
                $media_args['media_data'] = 'Grievace';
                $this->ambmain_model->insert_media_maintance($media_args);
            
        }
  
        }

        if(!empty($_FILES['grievance_photo']['name'])){
            
            foreach ($_FILES['grievance_photo']['name'] as $key => $image) {
                $media_args = array();
                $_FILES['photo']['name']= $_FILES['grievance_photo']['name'][$key];
                $_FILES['photo']['type']= $_FILES['grievance_photo']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['grievance_photo']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['grievance_photo']['error'][$key];
                $_FILES['photo']['size']= $_FILES['grievance_photo']['size'][$key];
                $_FILES['photo']['name'] = time() .'_'. $this->sanitize_file_name($_FILES['photo']['name']);
               

                $rsm_config = $this->gri_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                            $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                            $upload_err = TRUE;
                }
                $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['user_id'] = $police;
                //$media_args['media_data'] = $call_type.'-'.$compalint_type;
                $media_args['media_data'] = 'Grievace';
                $this->ambmain_model->insert_media_maintance($media_args);
               
            }
        }

        $police_operator = array(
            'sub_id' => $this->post['inc_ref_id'],
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'sub_status' => 'ATND',
        );

        $police_args = array(
            'sub_id' => $this->post['inc_ref_id'],
            'operator_type' => $this->clg->clg_group,
        );

        $police_ope = $this->common_model->update_operator($police_args, $police_operator);

        if ($police) {

            $this->output->message = "<div class='success'>Details saved successfully</div><script>window.location.reload(true);</script>";
        }
    }
    }
    function sanitize_string( $string, $sep = '-' ){
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9 -_\.]+/', '', $string);
        $string = trim($string);
        $string = str_replace(' ', $sep, $string);
       //  $string = str_replace('.', '_', $string);
        return trim($string, '-_');
    }
    function sanitize_file_name( $string, $sep = '-' ){
        $path_info = pathinfo($string);
        $string = $path_info['filename'];
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9 -_]+/', '', $string);
        $string = trim($string);
        $string = str_replace(' ', $sep, $string);
        $string = str_replace('.', '-', $string);
        $string .= '.'.$path_info['extension'];
        return trim($string, '-_');
    }
    public function gri_dash($generated = false) {

        $this->post = $this->input->post();
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');

        $this->post['base_month'] = get_base_month();

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $data['call_search'] = ($this->post['call_search']) ? $this->post['call_search'] : $this->fdata['call_search'];

        //$this->pg_limit = 10;
        ///////////set page number////////////////////

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }


        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;



        $args_dash = array(
            'base_month' => $this->post['base_month']
        );
        if ($data['call_search'] != '') {
            $args_dash['call_search'] = $data['call_search'];
        }
        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        $data['get_count'] = TRUE;
        $data['clg_group'] = $this->clg->clg_group;
        $inc_info = $this->grievance_model->get_inc_by_grievance($args_dash, $offset, $limit);

        $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;
        $data['clg_group'] = $this->clg->clg_group;
        $total_cnt = $this->grievance_model->get_inc_by_grievance($args_dash);
        //$total_cnt = $this->pcr_model->get_inc_by_emt($args_dash,'','',$filter,$sortby,$incomplete_inc_amb);

        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("grievance/gri_dash"),
            'total_rows' => $total_cnt,
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


        $type = $this->post['type'];

        $data['default_state'] = $this->default_state;
        $this->output->add_to_position($this->load->view('frontend/police_calls/police_dashboard_view', $data, TRUE), 'calls_amb_list', TRUE);

        $this->output->template = "calls";
    }

    function search_call() {
        $this->output->add_to_position($this->load->view('frontend/police_calls/inc_police_search_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "calls";
    }

    function police_incident_search() {

        $this->output->add_to_position($this->load->view('frontend/police_calls/inc_search_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "calls";
    }

    function grievance_manual_call() {

      //  $data['gc_inc_call_type'] = 'MANUAL';


        $data['comp_type'] = $this->post['value'];

        $this->output->add_to_position($this->load->view('frontend/Gravience/complaint_type_view', $data, TRUE), 'complaint_type', TRUE);

        $this->output->template = "calls";
    }

    function grievance_auto_manual_call() {

        //$data['gc_inc_call_type'] = 'PREV';

        $data['caller_info'] = $this->session->userdata('caller_information');
        $data['inc_ref_id'] = $this->session->userdata('inc_ref_id');

        $data['comp_type'] = $this->post['f_val'];
        $data['default_state'] = $this->default_state;
       // var_dump($data['default_state']);

        $this->output->add_to_position($this->load->view('frontend/Gravience/manual_complaint_type_view', $data, TRUE), 'grivience_info', TRUE);

        $this->output->template = "calls";
    }

    function grievance_call() {

       // $data['gc_inc_call_type'] = 'MANUAL';

        $data['comp_type'] = $this->post['f_val'];

        $data['default_state'] = $this->default_state;
        $this->output->add_to_position($this->load->view('frontend/Gravience/manual_complaint_type_view', $data, TRUE), 'grivience_info', TRUE);

        $this->output->template = "calls";
    }

    function get_police_caller_details() {

        $m_no = $this->input->post('caller');


        if (isset($m_no)) {
            $data['m_no'] = $m_no["cl_mobile_number"];
        } else {
            $data['m_no'] = $this->input->get('m_no');
        }
        $form_call_data = $this->input->post('caller');

        if (isset($form_call_data)) {

            $mobile_no = explode('+91', $form_call_data['cl_mobile_number']);
            $mobile_no = $form_call_data['cl_mobile_number'];
            $data['m_no'] = $mobile_no;
        }


        $data['caller_details'] = $this->call_model->get_caller_details($data['m_no']);


        $data['emt_details'] = $this->call_model->get_emt_user_details($data['m_no']);
        $datetime = date('Y-m-d H:i:s');
        $data['attend_call_time'] = date('Y-m-d H:i:s');





        $this->output->add_to_position($this->load->view('frontend/police_calls/caller_details_view', $data, TRUE), 'caller_details', TRUE);

        $this->output->set_focus_to = "caller_relation";
    }

    function save_call_details() {

        $data['caller'] = $this->post['caller'];


        $data['attend_call_time'] = date('Y-m-d H:i:s');

        $this->output->add_to_position($this->load->view('frontend/police_calls/inc_manual_call_filter_search_view', $data, TRUE), 'police_inc_call', TRUE);
        $this->output->template = "calls";
    }

    function save_manual_police() {



        if ($inc_id == '') {
            $inc_id = generate_police_inc_ref_id();
            update_police_inc_ref_id($inc_id);
        }

        $data['police'] = $this->post['police'];

        $args = array(
            'pc_base_month' => $this->post['base_month'],
            'pc_added_date' => $this->today,
            'pc_added_by' => $this->clg->clg_ref_id,
            'pc_modify_date' => $this->today,
            'pc_modify_by' => $this->clg->clg_ref_id,
            'pc_inc_ref_id' => 'p_' . $inc_id,
            'pc_state_code' => $this->post['incient_state'],
            'pc_district_code' => $this->post['incient_district'],
            'pc_police_station_id' => $this->post['incient_police'],
            'pc_assign_time' => date('Y-m-d H:i:s', strtotime($data['police']->pc_assign_time))
        );

        $args = array_merge($this->post['police'], $args);

        $police = $this->police_model->add_police($args);


        $manual_args = array(
            'mc_base_month' => $this->post['base_month'],
            'mc_added_date' => $this->today,
            'mc_added_by' => $this->clg->clg_ref_id,
            'mc_modify_date' => $this->today,
            'mc_modify_by' => $this->clg->clg_ref_id,
            'mc_inc_ref_id' => 'p_' . $inc_id,
            'mc_state_code' => $this->post['hp_dtl_state'],
            'mc_district_code' => $this->post['hp_dtl_district'],
            'mc_inc_address' => $this->post['hp_add'],
            'mc_dtl_lmark' => $this->post['hp_dtl_lmark'],
            'mc_dtl_area' => $this->post['hp_dtl_area'],
            'mc_dtl_lane' => $this->post['hp_dtl_lane'],
            'mc_dtl_pincode' => $this->post['hp_dtl_pincode'],
            'mc_dtl_ms_city' => $this->post['hp_dtl_ms_city'],
            'mc_dtl_hno' => $this->post['hp_dtl_hno'],
        );



        $inc_args = array_merge($this->post['caller'], $manual_args);

        $police_manual = $this->police_model->add_police_manual_call($inc_args);


        $police_operator = array(
            'sub_id' => $this->post['inc_ref_id'],
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'sub_status' => 'ATND',
        );

        $police_args = array(
            'sub_id' => $this->post['inc_ref_id'],
            'operator_type' => $this->clg->clg_group,
        );

        $res = $this->common_model->update_operator($police_args, $police_operator);

        if ($res) {

            $this->output->message = "<div class='success'>Details saved successfully</div><script>window.location.reload(true);</script>";
        }
    }

    function view_complaint() {
       //var_dump($grievance_data[0]->gc_pre_inc_ref_id);
        $data = array();

        $data['gc_id'] = base64_decode($this->post['gc_id']);

        $data['gc_complaint_type'] = base64_decode($this->post['gc_complaint_type']);

        $data['action_type'] = 'View Complaint Details';

        $data['view'] = 'view';
        if($this->clg->clg_group != 'UG-GrievianceManager'){ 
        $data['clg_group'] = $this->clg->clg_group;
        }
        $data['grievance_data'] = $this->grievance_model->get_inc_by_grievance($data, $offset, $limit);
        //for single record data
       
        $inc_ref_id =$data['grievance_data'][0]->gc_pre_inc_ref_id;

        $ero_name = get_clg_data_by_ref_id($inc_call_type[0]->inc_added_by);
        $data['type'] = $this->post['type'];
        $this->post['base_month'] = get_base_month();
        $data['inc_ref_id'] = $inc_ref_id;

      // $reff_id = $this->post['inc_added_by'];
       $data['inc_added_by'] = $reff_id;

        $data['inc_ref_no'] = $data['grievance_data'][0]->gc_pre_inc_ref_id;


        $args_dash = array('inc_id' => $inc_ref_id,
            'base_month' => $this->post['base_month']);

        //$data['inc_data'] = $this->call_model->get_inc_by_ero_calls($args_dash);
        //$data['feedback_details'] = $this->feedback_model->get_feedback_details(array('inc_ref_id' => trim($data['inc_ref_no'])));

        $args = array('inc_ref_id' => $inc_ref_id,
            'base_month' => $this->post['base_month'],
            'user_type' => $data['user_type']);
          
        $data['inc_call_type'] = $this->inc_model->get_inc_ref_id($args);
        $data['inc_details'] = $this->inc_model->get_inc_call_details_ref_id($args);
        
        //$data['audit_details'] = $this->quality_model->get_quality_audit($args);

        $args_st = array('st_code' => $data['inc_details'][0]->inc_state_id);
        $state = $this->inc_model->get_state_name($args_st);
        $data['state_name'] = $state[0]->st_name;

        $args_dst = array('st_code' => $data['inc_details'][0]->inc_state_id, 'dst_code' => $data['inc_details'][0]->inc_district_id);

        $district = $this->inc_model->get_district_name($args_dst);
        $data['district_name'] = $district[0]->dst_name;

        $args_th = array('thl_id' => $data['inc_details'][0]->inc_tahshil_id);
        $tahshil = $this->inc_model->get_tahshil($args_th);
        $data['tahshil_name'] = $tahshil[0]->thl_name;


        $args_ct = array('cty_id' => $data['inc_details'][0]->inc_city_id, 'dst_code' => $data['inc_details'][0]->inc_district_id);

        $city = $this->inc_model->get_city_name($args_ct);
        $data['city_name'] = $city[0]->cty_name;

        $data['cl_relation'] = $inc_data[0]->cl_relation;
        $cm_id = $data['inc_details'][0]->inc_complaint;
        $chief_comp = $this->inc_model->get_chief_comp_service($cm_id);
        $data['chief_complete_name'] = $chief_comp[0]->ct_type;
        $args_pt = array('get_count' => TRUE,
            'inc_ref_id' => $data['inc_ref_no']);

        $data['ptn_count'] = $this->pcr_model->get_pat_by_inc($args_pt);
       
        $gri_args = array(
            'gc_inc_ref_id' => trim($this->input->post('inc_ref_id'))
        );

        $data['clg_group'] = $this->clg->clg_group;
        $data['grievance_info'] = $this->grievance_model->get_inc_by_grievance($data, $offset, $limit);

        $args = array('gc_inc_ref_id' => $data['grievance_data'][0]->gc_pre_inc_ref_id);
        $data['clg_group'] = $this->clg->clg_group;
        $data['cl_dtl'] = $this->grievance_model->get_inc_by_grievance($args);

        $sup_remark_args = array(
            's_inc_ref_id' => $data['grievance_data'][0]->gc_pre_inc_ref_id);
        $data['supervisor_remark'] = $this->call_model->get_inc_supervisor_remark($sup_remark_args);


        $cm_id = $data['inc_details'][0]->inc_complaint;
        $chief_comp = $this->inc_model->get_chief_comp_service($cm_id);
        $data['chief_complete_name'] = $chief_comp[0]->ct_type;

        $args_pur = array('pcode' => $data['inc_details'][0]->cl_purpose);

        $data['pname'] = $this->inc_model->get_purpose_call($args_pur);

       // $data['pt_info'] = $this->Pet_model->get_ptinc_info($arg);

        $args_pur = array('pcode' => $data['pt_info'][0]->inc_type);

        //$data['pname'] = $call_pur[0]->pname;
        $ptn_args = array('inc_ref_id' => $data['inc_ref_no'],
//                'ptn_id' => $data['inc_details'][0]->ptn_id,
             'base_month' => $this->post['base_month'],
        );

       // $data['ptn_details'] = $this->Pet_model->get_ptinc_info($ptn_args);
       // $data['ptn_details'] = $this->pcr_model->get_pat_by_inc($ptn_args);
        
        $data['facility_details'] = $this->inc_model->get_hospital_facility(array('inc_ref_id' => trim($data['inc_ref_no'])));

        //$data['feedback_details'] = $this->feedback_model->get_feedback_details(array('inc_ref_id' => trim($data['inc_ref_no'])));
         $inc_args = array(
                'inc_ref_id' => $data['inc_ref_no'],
                'inc_type' => $data['inc_call_type'][0]->inc_type
            );


        $data['questions'] = $this->inc_model->get_inc_summary($inc_args);

        $ques_args = array(
            'inc_ref_id' => $data['inc_ref_no'],
            'inc_type' => 'FEED_' . $data['inc_call_type'][0]->inc_type
        );



        $data['feed_questions'] = $this->inc_model->get_inc_summary($ques_args);

        $amb_args = array('inc_ref_id' => $data['inc_ref_no']);

        $data['enquiry_data'] = $this->enquiry_model->get_enquiry($amb_args);

        $myArray = explode(',', $data['enquiry_data'][0]->enq_que);


        $data['enq_que'] = array();
        $q = 0;

        if (is_array($myArray)) {
            foreach ($myArray as $que) {

                $enq_que = $this->common_model->get_question(array('que_id' => $que));

                $serialize_que = $enq_que[0]->que_question;

                $data['enq_que'][$q]['que'] = get_lang_data($serialize_que, $data['enquiry_data'][0]->enq_lang);

                $ans = $this->common_model->get_answer(array('ans_que_id' => $que));

                $serialize_ans = $ans[0]->ans_answer;

                $data['enq_que'][$q]['ans'] = get_lang_data($serialize_ans, $data['enquiry_data'][0]->enq_lang);

                $data['enq_que'][$q]['que_id'] = $que;

                $q++;
            }
        }


        $data['epcr_inc_details'] = $this->pcr_model->get_epcr_inc_details_by_inc_id($inc_args);
        $data['er_inc_details'] = $this->medadv_model->get_epcr_by_inc_id($inc_args);

        $data['driver_data'] = $this->pcr_model->get_driver(array('inc_ref_id' => trim($data['inc_ref_no'])));
        //for single record data

        $args = array(
            'gc_inc_ref_id' => base64_decode($this->post['gc_inc_ref_id'])
        );
        $data['clg_group'] = $this->clg->clg_group;
        $data['cl_dtl'] = $this->grievance_model->get_inc_by_grievance($args);
        $data['default_state'] = $this->default_state;
        $args = array('gc_id' => $data['gc_id'],'Grievace' => 'Grievace');
        $his = $this->ambmain_model->get_grievance_photo($args);
        foreach($his as $history){ 
        // var_dump($history);
        // $args = array('mt_id' => $this->post['mt_id'], 're_request_id' => $history->re_request_id);
        // $history->his_photo[] = $this->ambmain_model->get_history_photo($args);
        $data['his'][] = $history;
        }
//        $this->output->add_to_position($this->load->view('frontend/Gravience/complaint_view', $data, TRUE), $output_position, TRUE);
        $this->output->add_to_position($this->load->view('frontend/Gravience/external_close_complaint_view', $data, TRUE), $output_position, TRUE);
    }

    function grievance_pre_inc_calls() {


        ///////////////  Filters //////////////////

        $data['search'] = ($this->post['search']) ? $this->post['search'] : $this->fdata['search'];


        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];




        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        $data['complaint_type'] = "";
        $data['filter'] = $filter = "";
        $data['filter'] = $_POST['filter'] ? $this->post['filter'] : $this->fdata['filter'];

        $data['complaint_type'] = $_POST['complaint_type'] ? $this->post['complaint_type'] : $this->fdata['complaint_type'];
        $data['district_id'] = $_POST['district_id'] ? $this->post['district_id'] : $this->fdata['district_id'];
        $data['inc_date'] = $_POST['inc_date'] ? $this->post['inc_date'] : $this->fdata['inc_date'];
        $data['status'] = $_POST['status'] ? $this->post['status'] : $this->fdata['status'];
        $data['complaint_id'] = $_POST['complaint_id'] ? $this->post['complaint_id'] : $this->fdata['complaint_id'];


        if (isset($data['filter'])) {


            if ($data['filter'] == 'complaint_type') {
                $filter = '';
                $sortby['complaint_type'] = $data['complaint_type'];
                $data['complaint_type'] = $sortby['complaint_type'];
            } else if ($data['filter'] == 'dst_name') {
                $filter = '';
                $sortby['district_id'] = $data['district_id'];
                $data['district_id'] = $sortby['district_id'];
            } else if ($data['filter'] == 'status') {
                $filter = '';
                $sortby['status'] = $data['status'];
                $data['status'] = $sortby['status'];
            } else if ($data['filter'] == 'complaint_id') {
                $filter = '';
                $sortby['complaint_id'] = $data['complaint_id'];
                $data['complaint_id'] = $data['complaint_id'];
            }
        }

        $this->session->set_userdata('grievance_filter', $data);
        
          if($this->clg->clg_group == 'UG-GrievianceManager' || $this->clg->clg_group ==  'UG-GrievanceManager'){           
            
            $args['clg_senior'] = $this->clg->clg_ref_id;
            $data['clg_senior'] = $this->clg->clg_ref_id;
            
            
            $clg_args = array('clg_senior'=>$this->clg->clg_ref_id,'clg_group'=>'UG-Grievance');
           
            $data['ero_clg'] = $this->colleagues_model->get_clg_data($clg_args);
            
            foreach($data['ero_clg'] as $ero){
                $child_ero[] = $ero->clg_ref_id;
            }

            if(is_array($child_ero)){
                $child_ero = implode("','", $child_ero);
            }
            
            
            
            $data['gc_added_by'] = $child_ero;
            
            $data['base_month'] = $this->post['base_month'];
            
        } else {
            
                $data['operator_id'] = $this->clg->clg_ref_id;
                $data['base_month'] = $this->post['base_month'];
        }
        ///////////limit & offset////////

        $data['get_count'] = TRUE;
       // $data['gc_inc_call_type'] = 'PREV';
       $data['clg_group'] = $this->clg->clg_group;
        $data['total_count'] = $this->grievance_model->get_inc_by_grievance($data, '', '', $filter, $sortby);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        unset($data['get_count']);


        $data['clg_group'] = $this->clg->clg_group;
        $data['inc_info'] = $this->grievance_model->get_inc_by_grievance($data, $offset, $limit, $filter, $sortby);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("grievance/gri_dash"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );
          // Total Closure 
       $month = date('m');
       $year = date('Y');
       $day = date('d');
       $query_date = $year.'-'.$month.'-'.$day;

       //echo $query_date;
       $first_day_this_month = date('Y-m-01', strtotime($query_date));

       // Last day of the month.
       $last_day_this_month = date('Y-m-t', strtotime($query_date));
       $month_report_args =  array('from_date' => date('Y-m-d',strtotime($first_day_this_month)),
                      'to_date' => date('Y-m-d', strtotime($last_day_this_month)));

       $month_report_args['get_count'] = 'true';
       $month_report_args['operator_id'] = $this->clg->clg_ref_id;
       
       $data['get_all_calls'] = $this->grievance_model->get_all_calls($month_report_args);
       $data['get_all_closure_calls'] = $this->grievance_model->get_all_closure_calls($month_report_args);
       $data['get_all_pending_calls'] = $this->grievance_model->get_all_pending_calls($month_report_args);
      
       //Today call
       $today_report_args =  array('from_date' => date('Y-m-d',strtotime($query_date)),
                      'to_date' => date('Y-m-d', strtotime($query_date)));
       $today_report_args['get_count'] = 'true';
       $today_report_args['operator_id'] = $this->clg->clg_ref_id;

      //$data['get_all_today_calls'] = $this->grievance_model->get_all_calls($today_report_args);
      $data['get_today_closure_calls'] = $this->grievance_model->get_all_closure_calls($today_report_args);
      $data['get_today_pending_calls'] = $this->grievance_model->get_all_pending_calls($today_report_args);

        $data['pgconf'] = $pgconf;
        $data['pagination'] = get_pagination($pgconf);

        /////////////////////////////////

        $data['page_records'] = count($data['inc_info']);

        $data['default_state'] = $this->default_state;
        $this->output->add_to_position($this->load->view('frontend/Gravience/grivance_previous_dashboard_view', $data, TRUE), 'griev_incident_calls', TRUE);

        $this->output->template = "calls";
    }

    function grievance_manual_calls() {
        ///////////////  Filters //////////////////

        $data['search'] = ($this->post['search']) ? $this->post['search'] : $this->fdata['search'];


        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];




        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        $data['complaint_type'] = "";
        $data['filter'] = $filter = "";
        $data['filter'] = $_POST['filter'] ? $this->post['filter'] : $this->fdata['filter'];

        $data['complaint_type'] = $_POST['complaint_type'] ? $this->post['complaint_type'] : $this->fdata['complaint_type'];
        $data['district_id'] = $_POST['district_id'] ? $this->post['district_id'] : $this->fdata['district_id'];
        $data['inc_date'] = $_POST['inc_date'] ? $this->post['inc_date'] : $this->fdata['inc_date'];
        $data['status'] = $_POST['status'] ? $this->post['status'] : $this->fdata['status'];
        $data['complaint_id'] = $_POST['complaint_id'] ? $this->post['complaint_id'] : $this->fdata['complaint_id'];
        $data['gri_date_serach'] = $_POST['gri_date_serach'] ? $this->post['gri_date_serach'] : $this->fdata['gri_date_serach'];
        $data['gri_E_Complaint'] = $_POST['gri_E_Complaint'] ? $this->post['gri_E_Complaint'] : $this->fdata['gri_E_Complaint'];
        if (isset($data['filter'])) {


            if ($data['filter'] == 'complaint_type') {
                $filter = '';
                $sortby['complaint_type'] = $data['complaint_type'];
                $data['complaint_type'] = $sortby['complaint_type'];
                if ($data['complaint_type'] == 'e_complaint') {
                    $filter = '';
                    $sortby['gri_E_Complaint'] = $data['gri_E_Complaint'];
                    $data['gri_E_Complaint'] = $data['gri_E_Complaint'];
                   }
            } else if ($data['filter'] == 'dst_name') {
                $filter = '';
                $sortby['district_id'] = $data['district_id'];
                $data['district_id'] = $sortby['district_id'];
            } else if ($data['filter'] == 'status') {
                $filter = '';
                $sortby['status'] = $data['status'];
                $data['status'] = $sortby['status'];
            } else if ($data['filter'] == 'complaint_id') {
                $filter = '';
                $sortby['complaint_id'] = $data['complaint_id'];
                $data['complaint_id'] = $data['complaint_id'];
            }
            else if ($data['filter'] == 'Date') {
                $filter = '';
                    $sortby['gri_date_serach'] = $data['gri_date_serach'];
                    $data['gri_date_serach'] = $data['gri_date_serach'];
                }
                
                    
    
        }

        $this->session->set_userdata('grievance_filter', $data);
        ///////////limit & offset////////
        
          if($this->clg->clg_group == 'UG-GrievianceManager' || $this->clg->clg_group ==  'UG-GrievanceManager'){           
            
            $args['clg_senior'] = $this->clg->clg_ref_id;
            $data['clg_senior'] = $this->clg->clg_ref_id;
            
            
            $clg_args = array('clg_senior'=>$this->clg->clg_ref_id,'clg_group'=>'UG-Grievance');
           
            $data['ero_clg'] = $this->colleagues_model->get_clg_data($clg_args);
            
            foreach($data['ero_clg'] as $ero){
                $child_ero[] = $ero->clg_ref_id;
            }

            if(is_array($child_ero)){
                $child_ero = implode("','", $child_ero);
            }
            
            
            
            $data['gc_added_by'] = $child_ero;
            
            $data['base_month'] = $this->post['base_month'];
            
        } else {
            
                $data['operator_id'] = $this->clg->clg_ref_id;
                $data['base_month'] = $this->post['base_month'];
        }

        $data['get_count'] = TRUE;

       // $data['gc_inc_call_type'] = 'MANUAL';
       $data['clg_group'] = $this->clg->clg_group;
        $data['total_count'] = $this->grievance_model->get_inc_by_grievance($data, '', '', $filter, $sortby);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        unset($data['get_count']);

        $data['clg_group'] = $this->clg->clg_group;

        $data['inc_info'] = $this->grievance_model->get_inc_by_grievance($data, $offset, $limit, $filter, $sortby);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("grievance/grievance_manual_calls"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        $data['pgconf'] = $pgconf;
        $data['pagination'] = get_pagination($pgconf);

        /////////////////////////////////

        $data['page_records'] = count($data['inc_info']);
        $data['default_state'] = $this->default_state;
        $this->output->add_to_position($this->load->view('frontend/Gravience/grivance_manual_dashboard_view', $data, TRUE), 'griev_incident_calls', TRUE);

        $this->output->template = "calls";
    }

    function search_grievance_call() {
        $data['default_state'] = $this->default_state;
        $this->output->add_to_position($this->load->view('frontend/Gravience/inc_grivance_search_view', $data, TRUE), 'content', TRUE);
//          $this->output->add_to_position($this->load->view('frontend/Gravience/complaint_type_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "calls";
    }
    function single_pt_inc_list(){
        //$abc = $this->input->post('incident_id');
        //$this->input->get_post('mobile_no')
        
        $srgs = array(
            'district_id' => $this->post['district_id'],
            'incident_id' => $this->post['incident_id'],
            'date_serach' => $this->post['date_serach'],
            'Caller_Number' => $this->post['Caller_Number']
        );

        $data['pt_details'] = $this->grievance_model->get_pt_inc_search_list($srgs);
        $this->output->add_to_position($this->load->view('frontend/inc/single_record_inc_details_view', $data, TRUE), 'inc_details', TRUE);

       // $this->output->add_to_position('', 'fwdcmp_btn', TRUE);
    }

}
