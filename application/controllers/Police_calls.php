<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Police_calls extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->active_module = "M-CALLS";

        $this->pg_limit = $this->config->item('pagination_limit');

        $this->pg_limits = $this->config->item('report_clg');

        $this->load->model(array('call_model', 'get_city_state_model', 'options_model', 'module_model', 'common_model', 'Pet_model', 'Ercp_model', 'amb_model', 'inc_model', 'colleagues_model', 'pcr_model', 'cluster_model', 'medadv_model', 'enquiry_model', 'fleet_model', 'police_model','Dashboard_model_final'));

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


        $this->post['base_month'] = get_base_month();

        $this->clg = $this->session->userdata('current_user');

        $this->today = date('Y-m-d H:i:s');
    }

    public function index($generated = false) {
        
        $user_group=$this->clg->clg_group;  
    
        if ($user_group == 'UG-PDA' || $user_group == 'UG-PDASupervisors' || $user_group == 'UG-PDASupervisor') {

        $this->post = $this->input->post();
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');

        $this->post['base_month'] = get_base_month();

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $data['pda_id'] = ($this->post['pda_id']) ? $this->post['pda_id'] : $this->fdata['pda_id'];


        if ($this->post['from_date'] != '') {
            $args_dash['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date']));
        }


        if ($this->post['to_date'] != '') {
            $args_dash['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->post['to_date']));
        }
        


         	

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

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        if ($this->post['from_date'] != '') {
            $args_dash['from_date'] = date('Y-m-d', strtotime($this->post['from_date']));
        } else {
//            $data['from_date'] = date('Y-m-d');
        }


        if ($this->post['to_date'] != '') {
            $args_dash['to_date'] = date('Y-m-d', strtotime($this->post['to_date']));
        } else {
//            $data['to_date'] = date('Y-m-d');
        }
        
                if ($this->post['inc_ref_id'] != '') {
            $args_dash['inc_ref_id'] = $this->post['inc_ref_id'] ? $this->post['inc_ref_id']: $this->post['inc_ref_id'];
        }
         if ($this->post['pc_inc_ref_id'] != '') {
            $args_dash['pc_inc_ref_id'] = $this->post['pc_inc_ref_id'] ? $this->post['pc_inc_ref_id']: $this->post['pc_inc_ref_id'];
        }
        if($this->clg->clg_group == 'UG-PDASupervisor'){           
            
            //$args['ercp_id'] = ($this->post['ercp_id']) ? $this->post['ercp_id'] : $this->fdata['ercp_id'];
            $args['clg_senior'] = $this->clg->clg_ref_id;
            $data['clg_senior'] = $this->clg->clg_ref_id;
            
            
            $clg_args = array('clg_senior'=>$this->clg->clg_ref_id,'clg_group'=>'UG-PDA');
           
            $data['pda_clg'] = $this->colleagues_model->get_clg_data($clg_args);
            
            foreach($data['pda_clg'] as $pda){
                $child_pda[] = $pda->clg_ref_id;
            }

            if(is_array($child_pda)){
                $child_ercp = implode("','", $child_pda);
            }
            
            
            if ( $data['pda_id']  != '') {
                $args_dash['pda_operator_id'] = $this->post['pda_id'];
            }else{
               // $args_dash['child_pda'] = $child_ercp;
            }
            
    }else{
        
        
            $clg_args = array('clg_group'=>'UG-PDA');
            $data['pda_clg'] = $this->colleagues_model->get_clg_data($clg_args);
            
            if ( $data['pda_id']  != '') {
                $args_dash['pda_operator_id'] = $this->post['pda_id'];
            }else{
               $args_dash['pda_operator_id'] = $this->clg->clg_ref_id;
            }
            
        
        }


        $data['inc_info'] = $this->police_model->get_inc_by_police($args_dash, $offset, $limit);


        $inc_data = (object) array();

        $data['per_page'] = $limit;

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->police_model->get_inc_by_police($args_dash);


        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("police_calls/police_dash"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
            )
        );

         // Total calls
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
         
         $data['get_all_calls'] = $this->police_model->get_all_calls($month_report_args);
         $data['get_all_calls_assign'] = $this->police_model->get_all_calls_assign($month_report_args);
         //Today call
         $today_report_args =  array('from_date' => date('Y-m-d',strtotime($query_date)),
                        'to_date' => date('Y-m-d', strtotime($query_date)));
         $today_report_args['get_count'] = 'true';
         $today_report_args['operator_id'] = $this->clg->clg_ref_id;
 
        $data['get_all_today_calls'] = $this->police_model->get_all_calls($today_report_args);
        $data['get_today_calls_assign'] = $this->police_model->get_all_calls_assign($today_report_args);
        
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
        
        $data['get_all_calls'] = $this->police_model->get_all_calls($month_report_args);
        $data['get_all_calls_assign'] = $this->police_model->get_all_calls_assign($month_report_args);
        //Today call
        $today_report_args =  array('from_date' => date('Y-m-d',strtotime($query_date)),
                       'to_date' => date('Y-m-d', strtotime($query_date)));
        $today_report_args['get_count'] = 'true';
        $today_report_args['operator_id'] = $this->clg->clg_ref_id;

       $data['get_all_today_calls'] = $this->police_model->get_all_calls($today_report_args);
       $data['get_today_calls_assign'] = $this->police_model->get_all_calls_assign($today_report_args);
       
       
        $data['get_today_rta_call'] = $this->Dashboard_model_final->get_rta_inc($today_report_args);
        $data['get_monday_rta_call'] = $this->Dashboard_model_final->get_rta_inc($month_report_args);
       
      
        
        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);


        $this->output->add_to_position($this->load->view('frontend/police_calls/police_dashboard_view', $data, TRUE), 'content', TRUE);

        $this->output->template = "calls";
        }else{
            dashboard_redirect($user_group,$this->base_url );
        }
    }

    function previous_incident_calls() {

        $this->post = $this->input->post();
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');

        $this->post['base_month'] = get_base_month();

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $data['pda_id'] = ($this->post['pda_id']) ? $this->post['pda_id'] : $this->fdata['pda_id'];

        if ($this->post['from_date'] != '') {
            $args_dash['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date']));
        }


        if ($this->post['to_date'] != '') {
            $args_dash['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->post['to_date']));
        }

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

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        if ($this->post['from_date'] != '') {
            $args_dash['from_date'] =$data['from_date'] = date('Y-m-d', strtotime($this->post['from_date']));
        } else {
//            $data['from_date'] = date('Y-m-d');
        }


        if ($this->post['to_date'] != '') {
            $args_dash['to_date'] =$data['to_date'] = date('Y-m-d', strtotime($this->post['to_date']));
        } else {
//            $data['to_date'] = date('Y-m-d');
        }
        if($this->clg->clg_group == 'UG-PDASupervisor'){           
            
            //$args['ercp_id'] = ($this->post['ercp_id']) ? $this->post['ercp_id'] : $this->fdata['ercp_id'];
            $args['clg_senior'] = $this->clg->clg_ref_id;
            $data['clg_senior'] = $this->clg->clg_ref_id;
            
            
            $clg_args = array('clg_senior'=>$this->clg->clg_ref_id,'clg_group'=>'UG-PDA');
            
           
            $data['pda_clg'] = $this->colleagues_model->get_clg_data($clg_args);
            
            foreach($data['pda_clg'] as $pda){
                $child_pda[] = $pda->clg_ref_id;
            }

            if(is_array($child_pda)){
                $child_ercp = implode("','", $child_pda);
            }
            
            
            if ( $data['pda_id']  != '') {
                $args_dash['pda_operator_id'] = $this->post['pda_id'];
            }else{
                //$args_dash['child_pda'] = $child_ercp;
            }
            
            }else{

                $clg_args = array('clg_group'=>'UG-PDA');
            
           
               $data['pda_clg'] = $this->colleagues_model->get_clg_data($clg_args);
                if ( $data['pda_id']  != '') {
                    $args_dash['pda_operator_id'] = $this->post['pda_id'];
                }else{
                   $args_dash['pda_operator_id'] = $this->clg->clg_ref_id;
                }

            }
            
                if ($this->post['inc_ref_id'] != '') {
            $args_dash['inc_ref_id'] = $this->post['inc_ref_id'] ? $this->post['inc_ref_id']: $this->post['inc_ref_id'];
        }
         if ($this->post['pc_inc_ref_id'] != '') {
            $args_dash['pc_inc_ref_id'] = $this->post['pc_inc_ref_id'] ? $this->post['pc_inc_ref_id']: $this->post['pc_inc_ref_id'];
        }



        $data['inc_info'] = $this->police_model->get_inc_by_police($args_dash, $offset, $limit);


        $inc_data = (object) array();

        $data['per_page'] = $limit;

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->police_model->get_inc_by_police($args_dash);


        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("police_calls/police_dash"),
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

//        $this->output->add_to_position($this->load->view('frontend/police_calls/police_dashboard_view', $data, TRUE), 'content', TRUE);
        $this->output->add_to_position($this->load->view('frontend/police_calls/police_call_dashboard_view', $data, TRUE), 'police_incident_calls', TRUE);

        $this->output->template = "calls";
    }

    function manual_calls() {

        $this->post = $this->input->post();
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');

        $this->post['base_month'] = get_base_month();

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        if ($this->post['from_date'] != '') {
            $args_dash['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date']));
        }


        if ($this->post['to_date'] != '') {
            $args_dash['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->post['to_date']));
        }

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

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        if ($this->post['from_date'] != '') {
            $args_dash['from_date'] = date('Y-m-d', strtotime($this->post['from_date']));
        } else {
//            $data['from_date'] = date('Y-m-d');
        }


        if ($this->post['to_date'] != '') {
            $args_dash['to_date'] = date('Y-m-d', strtotime($this->post['to_date']));
        } else {
//            $data['to_date'] = date('Y-m-d');
        }
        
        if($this->clg->clg_group == 'UG-PDASupervisor'){           
            
            //$args['ercp_id'] = ($this->post['ercp_id']) ? $this->post['ercp_id'] : $this->fdata['ercp_id'];
            $args['clg_senior'] = $this->clg->clg_ref_id;
            $data['clg_senior'] = $this->clg->clg_ref_id;
            
            
            $clg_args = array('clg_senior'=>$this->clg->clg_ref_id,'clg_group'=>'UG-PDA');
           
            $data['pda_clg'] = $this->colleagues_model->get_clg_data($clg_args);
            
            foreach($data['pda_clg'] as $pda){
                $child_pda[] = $pda->clg_ref_id;
            }

            if(is_array($child_pda)){
                $child_ercp = implode("','", $child_pda);
            }
            
            
            if ( $data['pda_id']  != '') {
                $args_dash['pda_operator_id'] = $this->post['pda_id'];
            }else{
                //$args_dash['child_pda'] = $child_ercp;
            }
            
        }else{
        
            
            $clg_args = array('clg_group'=>'UG-PDA');
            $data['pda_clg'] = $this->colleagues_model->get_clg_data($clg_args);
            if ( $data['pda_id']  != '') {
                $args_dash['pda_operator_id'] = $this->post['pda_id'];
            }else{
               $args_dash['pda_operator_id'] = $this->clg->clg_ref_id;
            }
        
        }
        
        if ($this->post['inc_ref_id'] != '') {
            $args_dash['inc_ref_id'] = $this->post['inc_ref_id'] ? $this->post['inc_ref_id']: $this->post['inc_ref_id'];
        }
         if ($this->post['pc_inc_ref_id'] != '') {
            $args_dash['pc_inc_ref_id'] = $this->post['pc_inc_ref_id'] ? $this->post['pc_inc_ref_id']: $this->post['pc_inc_ref_id'];
        }


        $data['inc_info'] = $this->police_model->get_inc_by_manual_police_call($args_dash, $offset, $limit);


        $inc_data = (object) array();

        $data['per_page'] = $limit;

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->police_model->get_inc_by_manual_police_call($args_dash);


        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("police_calls/police_dash"),
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

        $this->output->add_to_position($this->load->view('frontend/police_calls/police_manual_call_dashboard_view', $data, TRUE), 'police_incident_calls', TRUE);

        $this->output->template = "calls";
    }

    function police_call_details() {

        $inc_args = array(
            'inc_ref_id' => $this->post['sub_id'],
            'base_month' => $this->post['base_month'],
        );

        $data['inc_data'] = $this->call_model->get_inc_type($inc_args);

        $inc_type = $data['inc_data'][0]->inc_type;

        $call_name = $data['inc_data'][0]->pname;



        if ($inc_type != 'IN_HO_P_TR' && $inc_type != 'MCI' && $inc_type != 'NON_MCI' && $inc_type != 'AD_SUP_REQ' && $inc_type != 'VIP_CALL' && $inc_type != 'TRANS_PDA') {

            $this->output->message = "<p>Call Type : " . $call_name . "</p><br><p>This call not for Police call </p>.";

            return;
        }
       
        if (!isset($this->post['inc_ref_id']) && $this->post['inc_ref_id'] != '') {

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
 //var_dump($args); die;
            $data['cl_dtl'] = $this->Medadv_model->call_detials($args);

            $inc_args = array(
                'inc_ref_id' => $data['sub_id'],
                'base_month' => $this->post['base_month']
            );

            $data['pt_info'] = $this->Pet_model->get_ptinc_info($inc_args);
            if(!empty($data['pt_info'])){
                $data['pt_info'] = $this->Pet_model->get_ptinc_info_non_em($args);
            }
            $data['patient_id'] = $data['pt_info'][0]->ptn_id;

            $args_pur = array('pcode' => $data['pt_info'][0]->inc_type);
            $call_pur = $this->inc_model->get_purpose_call($args_pur);
            $data['pname'] = $call_pur[0]->pname;

            $data['patient_info'] = $this->pcr_model->get_pat_by_inc($inc_args);
        } else {

            $args = array(
                'inc_ref_id' => trim($this->post['sub_id']),
                 'base_month' => $this->post['base_month']
            );


            $this->session->set_userdata('ercp_inc_ref_id', $this->post['sub_id']);
           // var_dump($args);

            $data['cl_dtl'] = $this->medadv_model->get_ercp_call_detials($args);


            $data['pt_info'] = $this->Pet_model->get_ptinc_info($args);
            if(empty($data['pt_info'])){
                $data['pt_info'] = $this->Pet_model->get_ptinc_info_non_em($args);
            }

            $data['questions'] = $this->inc_model->get_inc_summary($args);

            $data['patient_info'] = $this->pcr_model->get_pat_by_inc($args);
            $data['patient_id'] = $data['pt_info'][0]->ptn_id;
            $args_pur = array('pcode' => $data['pt_info'][0]->cl_purpose);

            $call_pur = $this->inc_model->get_purpose_call($args_pur);
            $data['pname'] = $call_pur[0]->pname;


            $args_remark = array('re_id' => $data['pt_info'][0]->inc_ero_standard_summary);
            $standard_remark = $this->call_model->get_ero_summary_remark($args_remark);
            $data['re_name'] = $standard_remark[0]->re_name;
           
        }
        
        if (!empty($data['cl_dtl'])) {
           // print_r($data); exit;
            $this->output->add_to_position($this->load->view('frontend/police_calls/inc_details_view', $data, TRUE), 'content', TRUE);
        } else {
            //echo "Hi11111"; exit;
            $this->output->message = "<p>No Record Found</p>";
            return;
        }

        //   $this->output->add_to_position($this->load->view('frontend/police_calls/manual_inc_details_view', $data, TRUE), 'content', TRUE);
        
    }
    
        function search_police_call_details() {

        $inc_args = array(
            'inc_ref_id' => $this->post['inc_ref_id'],
            'base_month' => $this->post['base_month'],
        );

        $data['inc_data'] = $this->call_model->get_inc_type($inc_args);

        $inc_type = $data['inc_data'][0]->inc_type;

        $call_name = $data['inc_data'][0]->pname;



        if ($inc_type != 'IN_HO_P_TR' && $inc_type != 'MCI' && $inc_type != 'NON_MCI' && $inc_type != 'AD_SUP_REQ' && $inc_type != 'VIP_CALL' && $inc_type != 'TRANS_PDA') {
            $this->output->message = "<p>Call Type : " . $call_name . "</p><br><p>This call not for Police call </p>.";
            return;
        }

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

            $inc_args = array(
                'inc_ref_id' => $data['sub_id'],
                'base_month' => $this->post['base_month']
            );

            $data['pt_info'] = $this->Pet_model->get_ptinc_info($inc_args);

            $data['patient_id'] = $data['pt_info'][0]->ptn_id;

            $args_pur = array('pcode' => $data['pt_info'][0]->inc_type);
            $call_pur = $this->inc_model->get_purpose_call($args_pur);
            $data['pname'] = $call_pur[0]->pname;

            $data['patient_info'] = $this->pcr_model->get_pat_by_inc($inc_args);
        } else {

            $args = array(
                'inc_ref_id' => trim($this->post['inc_ref_id']),
            );


            $this->session->set_userdata('ercp_inc_ref_id', $this->post['inc_ref_id']);

            $data['cl_dtl'] = $this->medadv_model->get_ercp_call_detials($args);
            $data['pt_info'] = $this->Pet_model->get_ptinc_info($args);
            $data['questions'] = $this->inc_model->get_inc_summary($args);

            $data['patient_info'] = $this->pcr_model->get_pat_by_inc($args);
            $data['patient_id'] = $data['pt_info'][0]->ptn_id;
            $args_pur = array('pcode' => $data['pt_info'][0]->cl_purpose);

            $call_pur = $this->inc_model->get_purpose_call($args_pur);
            $data['pname'] = $call_pur[0]->pname;


            $args_remark = array('re_id' => $data['pt_info'][0]->inc_ero_standard_summary);
            $standard_remark = $this->call_model->get_ero_summary_remark($args_remark);
            $data['re_name'] = $standard_remark[0]->re_name;
        }

        if (empty($data['cl_dtl'])) {
            $this->output->message = "<p>No Record Found</p>";

            return;
        }

           $this->output->add_to_position($this->load->view('frontend/police_calls/manual_inc_details_view', $data, TRUE), 'content', TRUE);
//        $this->output->add_to_position($this->load->view('frontend/police_calls/inc_details_view', $data, TRUE), 'content', TRUE);
    }

    function get_police_station_information() {

        $data = array(
            'p_id' => $this->post['p_id'],
        );
        if($this->post['p_id'] != 'Other'){
            $data['police_station'] = $this->fleet_model->get_all_police_station($data);
            $this->output->add_to_position($this->load->view('frontend/police_calls/police_station_information_view', $data, TRUE), 'police_station_information', TRUE);
        }
        
        
    }

    function save_police() {


        if ($inc_id == '') {
            $inc_id = generate_police_inc_ref_id();
            update_police_inc_ref_id($inc_id);
        }


        $args = array(
            'pc_base_month' => $this->post['base_month'],
            'pc_added_date' => $this->today,
            'pc_added_by' => $this->clg->clg_ref_id,
            'pc_modify_date' => $this->today,
            'pc_modify_by' => $this->clg->clg_ref_id,
            'pc_inc_ref_id' => 'P-' . $inc_id,
            'pc_state_code' => $this->post['incient_state'],
            'pc_district_code' => $this->post['incient_district'],
            'pc_police_station_id' => $this->post['incient_police'],
            'pc_pre_inc_ref_id' => $this->post['inc_ref_id'],
           // 'pc_assign_time' => date('Y-m-d H:i:s', strtotime($this->post['pc_assign_time']))
        );
        if($this->post['pc_assign_time'] != ''){
            
           $args['pc_assign_time'] =  date('Y-m-d H:i:s', strtotime($this->post['pc_assign_time']));
           
        }

        $args = array_merge($this->post['police'], $args);

        $police = $this->police_model->add_police($args);

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

    public function police_dash($generated = false) {

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

        $inc_info = $this->police_model->get_inc_by_police($args_dash, $offset, $limit);

        $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->police_model->get_inc_by_police($args_dash);
     

        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("police_calls/police_dash"),
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


        //////////// Filter////////////

        $data['amb_search'] = ($this->post['amb_search']) ? $this->post['amb_search'] : $this->fdata['amb_search'];
        $data['pg_rec_amb'] = ($this->post['pg_rec_amb']) ? $this->post['pg_rec_amb'] : $this->fdata['pg_rec_amb'];

        $ambflt['AMB'] = $data;


        //////////////////////////limit & offset//////
        //$data['amb_user_type']= 'tdd';

        $data['get_count'] = TRUE;

        $data['total_count'] = $this->amb_model->get_amb_data($data);

        $limit = ($data['pg_rec_amb']) ? $data['pg_rec_amb'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;


        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['AMB'] = $data;

        $this->session->set_userdata('filters', $ambflt);


        /////////////////////////////////////////////////////


        unset($data['get_count']);

        $data['result'] = $this->amb_model->get_amb_data($data, $offset, $limit);


        $data['get_data'] = $this->amb_model->get_working_area();

        $data['cur_page'] = $page_no;
        $pgconf_amb = array(
            'url' => base_url("calls/ero_dash"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=amb"
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
        
        $data['get_all_calls'] = $this->police_model->get_all_calls($month_report_args);
        $data['get_all_calls_assign'] = $this->police_model->get_all_calls_assign($month_report_args);
        //Today call
        $today_report_args =  array('from_date' => date('Y-m-d',strtotime($query_date)),
                       'to_date' => date('Y-m-d', strtotime($query_date)));
        $today_report_args['get_count'] = 'true';
        $today_report_args['operator_id'] = $this->clg->clg_ref_id;

       $data['get_all_today_calls'] = $this->police_model->get_all_calls($today_report_args);
       $data['get_today_calls_assign'] = $this->police_model->get_all_calls_assign($today_report_args);
       
        $config = get_pagination($pgconf_amb);
        $data['amb_pagination'] = get_pagination($pgconf_amb);
        $type = $this->post['type'];


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

    function police_manual_call() {

        $data['attend_call_time'] = date('Y-m-d H:i:s');

        $this->output->add_to_position($this->load->view('frontend/police_calls/inc_manual_call_search_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "calls";
    }

    function get_police_caller_details() {

        $m_no = $this->input->post('caller');


//
//        if (isset($m_no)) {
//            $data['m_no'] = $m_no["cl_mobile_number"];
//        } else {
//            $data['m_no'] = $this->input->get('m_no');
//        }
        $form_call_data = $this->input->post('caller');

        if (isset($form_call_data)) {

            $mobile_no = $form_call_data['cl_mobile_number'];

//            $mobile_no = $form_call_data['cl_mobile_number'];
            $data['m_no'] = $mobile_no;
        }


        $data['caller_details'] = $this->call_model->get_caller_details($data['m_no']);

        $data['emt_details'] = $this->call_model->get_emt_user_details($data['m_no']);
        $datetime = date('Y-m-d H:i:s');
        $data['attend_call_time'] = date('Y-m-d H:i:s');





        $this->output->add_to_position($this->load->view('frontend/police_calls/caller_details_view', $data, TRUE), 'caller_details', TRUE);

        $this->output->set_focus_to = "caller_relation";


        $data['caller'] = $this->post['caller'];


        $data['attend_call_time'] = date('Y-m-d H:i:s');

        $this->output->add_to_position($this->load->view('frontend/police_calls/inc_manual_call_filter_search_view', $data, TRUE), 'police_inc_call', TRUE);
        $this->output->template = "calls";
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
            'pc_inc_ref_id' => 'P-' . $inc_id,
            'pc_state_code' => $this->post['incient_state'],
            'pc_district_code' => $this->post['incient_district'],
            'pc_police_station_id' => $this->post['incient_police'],
            //'pc_assign_time' => date('Y-m-d H:i:s', strtotime($this->post['pc_assign_time']))
        );
         if($this->post['pc_assign_time'] != ''){
            
           $args['pc_assign_time'] =  date('Y-m-d H:i:s', strtotime($this->post['pc_assign_time']));
           
        }

        $args = array_merge($this->post['police'], $args);
        
        $police = $this->police_model->add_police($args);
        

        $manual_args = array(
            'mc_base_month' => $this->post['base_month'],
            'mc_added_date' => $this->today,
            'mc_added_by' => $this->clg->clg_ref_id,
            'mc_modify_date' => $this->today,
            'mc_modify_by' => $this->clg->clg_ref_id,
            'mc_inc_ref_id' => 'P-' . $inc_id,
        );

        if ($this->post['hp_dtl_state'] != '') {
            $manual_args['mc_state_code'] = $this->post['hp_dtl_state'];
        }

        if ($this->post['hp_dtl_districts'] != '') {
            $manual_args['mc_district_code'] = $this->post['hp_dtl_districts'];
        }

        if ($this->post['hp_add'] != '') {
            $manual_args['mc_inc_address'] = $this->post['hp_add'];
        }

        if ($this->post['hp_dtl_lmark'] != '') {
            $manual_args['mc_dtl_lmark'] = $this->post['hp_dtl_lmark'];
        }


        if ($this->post['hp_dtl_area'] != '') {
            $manual_args['mc_dtl_area'] = $this->post['hp_dtl_area'];
        }

        if ($this->post['hp_dtl_lane'] != '') {
            $manual_args['mc_dtl_lane'] = $this->post['hp_dtl_lane'];
        }

        if ($this->post['hp_dtl_pincode'] != '') {
            $manual_args['mc_dtl_pincode'] = $this->post['hp_dtl_pincode'];
        }

        if ($this->post['hp_dtl_ms_city'] != '') {
            $manual_args['mc_dtl_ms_city'] = $this->post['hp_dtl_ms_city'];
        }

        if ($this->post['hp_dtl_hno'] != '') {
            $manual_args['mc_dtl_hno'] = $this->post['hp_dtl_hno'];
        }

        $form_call_data = $this->post['caller'];
   
         $caller_data = array('clr_mobile' => $form_call_data['cl_mobile_number'],
                    'clr_fname' => $form_call_data['cl_firstname'] ? $form_call_data['cl_firstname'] : 'Unknown',
                    'clr_mname' => $form_call_data['cl_middlename'] ? $form_call_data['cl_middlename'] : '',
                    'clr_lname' => $form_call_data['cl_lastname'] ? $form_call_data['cl_lastname'] : '',
                    'clr_fullname' => $form_call_data['cl_firstname'] ? $form_call_data['cl_firstname'] : 'Unknown' . ' ' . $form_call_data['cl_middlename'] ? $form_call_data['cl_middlename'] : '' . ' ' . $form_call_data['cl_lastname'] ? $form_call_data['cl_lastname'] : '');
         
       
        $caller_id = $this->call_model->insert_caller_details($caller_data);
        
        $call_data = array('cl_base_month' => $this->post['base_month'],
                    'cl_clr_id' => $caller_id,
                    'clr_ralation' => $form_call_data['cl_relation'],
                    'cl_purpose' => $form_call_data['parent_purpose'],
                    'cl_datetime' => $form_call_data['cl_datetime']);
        $call_id = $this->call_model->insert_call_details($call_data);
       
        $args_caller = array('mc_attend_call_time'=>$this->post['caller']['attend_call_time'],'mc_caller_id'=>$caller_id,'mc_caller_relation'=>$form_call_data['cl_relation'],'mc_call_id'=>$call_id);

      
        
        $inc_args = array_merge($args_caller, $manual_args);
        $police_manual = $this->police_model->add_police_manual_call($inc_args);
        

         $police_operator = array(
            'sub_id' => $data['police']['pc_pre_inc_ref_id'],
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'sub_status' => 'ATND',
        );

        $police_args = array(
            'sub_id' => $data['police']['pc_pre_inc_ref_id'],
            'operator_type' => $this->clg->clg_group,
        );

        $res = $this->common_model->update_operator($police_args, $police_operator);
        if ($police_manual) {

            $this->output->message = "<div class='success'>Details saved successfully</div><script>window.location.reload(true);</script>";
        }
    }

    function police_records_view() {

        $data['action_type'] = $this->post['action_type'];

        $args = array(
            'pc_inc_ref_id' => base64_decode($this->post['pc_inc_ref_id']),
            'base_month' => $this->post['base_month']
        );

        $data['inc_info'] = $this->police_model->get_inc_by_police($args, $offset, $limit);

        if ($this->post['inc_ref_id'] != '') {
            $arg = array(
                'inc_ref_id' => base64_decode($this->post['inc_ref_id']),
            );

            $data['cl_dtl'] = $this->medadv_model->get_ercp_call_detials($arg);

            $data['pt_info'] = $this->Pet_model->get_ptinc_info($arg);

            $args_pur = array('pcode' => $data['pt_info'][0]->inc_type);
            $call_pur = $this->inc_model->get_purpose_call($args_pur);
            $data['pname'] = $call_pur[0]->pname;
        }



        $this->output->add_to_position($this->load->view('frontend/police_calls/police_records_view', $data, TRUE), $output_position, TRUE);
    }

    function police_manual_records_view() {


        $data['action_type'] = $this->post['action_type'];

        $args = array(
            'pc_inc_ref_id' => base64_decode($this->post['pc_inc_ref_id']),
            'base_month' => $this->post['base_month']
        );

        $data['inc_info'] = $this->police_model->get_inc_by_manual_police_call($args, $offset, $limit);

        $this->output->add_to_position($this->load->view('frontend/police_calls/police_manual_records_view', $data, TRUE), $output_position, TRUE);
         //$this->output->add_to_position($this->load->view('frontend/police_calls/inc_manual_call_search_view', $data, TRUE),$output_position, TRUE);
    }

    function update_police() {


        $police_data = $this->post['police'];
        $police_data['pc_modify_by'] = $this->clg->clg_ref_id;
        $police_data['pc_modify_date'] = date('Y-m-d H:i:s');


     //   $police_data['pc_assign_time'] = date('Y-m-d H:i:s', strtotime($police_data['pc_curr_date_time']));

        $police_data['pc_is_close'] = '1';



        $result = $this->police_model->update_police($police_data);


        if ($result) {

            $this->output->status = 1;

            $this->output->closepopup = 'yes';

            $this->output->message = "<div class='success'>Police Updated Successfully</div><script>window.location.reload(true);</script>";
        }
    }

    function show_other_police_remark() {

        $this->output->add_to_position($this->load->view('frontend/police_calls/other_remark_textbox_view', $data, TRUE), 'police_remark_other_textbox', TRUE);
    }
    function all_police_call(){

        $this->post = $this->input->post();
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');

        $this->post['base_month'] = get_base_month();

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $data['pda_id'] = ($this->post['pda_id']) ? $this->post['pda_id'] : $this->fdata['pda_id'];

        if ($this->post['from_date'] != '') {
            $args_dash['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date']));
        }


        if ($this->post['to_date'] != '') {
            $args_dash['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->post['to_date']));
        }

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

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        if ($this->post['from_date'] != '') {
            $args_dash['from_date'] = date('Y-m-d', strtotime($this->post['from_date']));
        } 


        if ($this->post['to_date'] != '') {
            $args_dash['to_date'] = date('Y-m-d', strtotime($this->post['to_date']));
        } 
        if($this->clg->clg_group == 'UG-PDASupervisor'){           
            
            //$args['ercp_id'] = ($this->post['ercp_id']) ? $this->post['ercp_id'] : $this->fdata['ercp_id'];
            $args['clg_senior'] = $this->clg->clg_ref_id;
            $data['clg_senior'] = $this->clg->clg_ref_id;
            
            
            $clg_args = array('clg_senior'=>$this->clg->clg_ref_id,'clg_group'=>'UG-PDA');
            
           
            $data['pda_clg'] = $this->colleagues_model->get_clg_data($clg_args);
            
            foreach($data['pda_clg'] as $pda){
                $child_pda[] = $pda->clg_ref_id;
            }

            if(is_array($child_pda)){
                $child_ercp = implode("','", $child_pda);
            }
            
            
            if ( $data['pda_id']  != '') {
                $args_dash['pda_operator_id'] = $this->post['pda_id'];
            }else{
                //$args_dash['child_pda'] = $child_ercp;
            }
            
            }else{

                $clg_args = array('clg_group'=>'UG-PDA');
            
           
               $data['pda_clg'] = $this->colleagues_model->get_clg_data($clg_args);
                if ( $data['pda_id']  != '') {
                    $args_dash['pda_operator_id'] = $this->post['pda_id'];
                }

            }
            
                if ($this->post['inc_ref_id'] != '') {
            $args_dash['inc_ref_id'] = $this->post['inc_ref_id'] ? $this->post['inc_ref_id']: $this->post['inc_ref_id'];
        }
         if ($this->post['pc_inc_ref_id'] != '') {
            $args_dash['pc_inc_ref_id'] = $this->post['pc_inc_ref_id'] ? $this->post['pc_inc_ref_id']: $this->post['pc_inc_ref_id'];
        }



        $data['inc_info'] = $this->police_model->get_inc_for_police($args_dash, $offset, $limit);


        $inc_data = (object) array();

        $data['per_page'] = $limit;

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->police_model->get_inc_for_police($args_dash);


        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("police_calls/police_dash"),
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

//        $this->output->add_to_position($this->load->view('frontend/police_calls/police_dashboard_view', $data, TRUE), 'content', TRUE);
        $this->output->add_to_position($this->load->view('frontend/police_calls/all_incident_call', $data, TRUE), 'police_incident_calls', TRUE);

        $this->output->template = "calls";
    }
        function police_api_call_details() {

        $inc_args = array(
            'inc_ref_id' => $this->post['sub_id'],
            'base_month' => $this->post['base_month'],
        );

        $data['inc_data'] = $this->call_model->get_inc_type($inc_args);

        $inc_type = $data['inc_data'][0]->inc_type;

        $call_name = $data['inc_data'][0]->pname;


        $this->output->add_to_position($this->load->view('frontend/police_calls/manual_inc_details_view', $data, TRUE), 'content', TRUE);
        
    }
     function api_police_call_details() {

        $this->session->unset_userdata('mic_details');
        $this->session->unset_userdata('call_type');
        $this->session->unset_userdata('CADIncidentID');
        $this->session->unset_userdata('CallUniqueID');
        $this->session->unset_userdata('caller_details_data');
        $this->session->unset_userdata('inc_datetime');
        $this->session->unset_userdata('patient');
        $this->session->unset_userdata('call_id');

        $inc_args = array(
            'emg_cad_inc_id' => $this->post['sub_id'],
            'base_month' => $this->post['base_month'],
        );
        $data['clg_group'] = $this->clg->clg_group;

        $inc_pda_data= $this->inc_model->get_pda_api_calls($inc_args)[0];
        
        $data['CADIncidentID'] =$CADIncidentID= $this->post['sub_id'] ;
      
       
        $eme_pda_data = array('emg_cad_inc_id'=>$CADIncidentID,'call_status'=>'attending');
         $state_id = $this->inc_model->update_insertEmgVehDis($eme_pda_data);     
        $this->session->set_userdata('CADIncidentID',$CADIncidentID);
        //var_dump($inc_pda_data);
        
        $data['m_no'] = $inc_pda_data->emg_callerno;
        
        $pur_args=array('p_parent'=>'EMG','p_systen'=>'108');
        
        
        $this->output->add_to_position('', 'content', TRUE);
        $data['child_purpose_of_calls'] = $this->call_model->get_purpose_of_calls($pur_args);
        
        $parent_args = array('p_systen'=>'108');
        $data['purpose_of_calls'] = $this->call_model->get_parent_purpose_of_calls($parent_args);
        
        $caller_details = new ArrayObject();
        $caller_details->clr_fname = $inc_pda_data->emg_callername;
        $caller_details->clr_mobile = $inc_pda_data->emg_callerno;
        $caller_details->clr_fullname = $inc_pda_data->emg_callername;
        
        $data['caller_id'] = $this->call_model->insert_caller_details($caller_details);
        $$data['caller_details']['clr_id'] =$caller_details->clr_id =  $data['caller_id'];
        
        $call_data = array('cl_base_month' => $this->post['base_month'],
                'cl_clr_id' => $data['caller_id'],
                'cl_purpose' => 'EMG',
                'cl_datetime' => date('Y-m-d H:i:s'));

        $data['call_id'] = $this->call_model->insert_call_details($call_data);
        
        $data['caller_details'] = $caller_details;
        
        $caller_details_data = array('clr_fname' => $inc_pda_data->emg_callername,
                'clr_mobile'=>$inc_pda_data->emg_callerno,
                'clr_mname' => $inc_pda_data->emg_callername,
                'clr_full_name' => $inc_pda_data->emg_callername,
                'patient_gender' => ucfirst($inc_pda_data->emg_patientgender),
                'age_type'=>'Years',
                'patient_age' => $inc_pda_data->emg_patientage);
            
        $data['caller_details_data'] = $caller_details_data;
        
         $session_caller_details = $this->session->set_userdata('caller_details_data',$caller_details_data);
        
        $common_data_form = array(
                'full_name' => $inc_pda_data->emg_patientname,
                'first_name'  => $inc_pda_data->emg_patientname,
                'age'=> $inc_pda_data->emg_patientage,
                'age_type'=>'Years',
                'gender'=> ucfirst($inc_pda_data->emg_patientgender) );
            
            $data['common_data_form'] = $common_data_form;
        
        

         $app_call_details[0] =(object) array(
                'lat' => $inc_pda_data->emg_incidentlat,
                'inc_address' => $inc_pda_data->emg_incidentadd ,
                'lng' => $inc_pda_data->emg_incidentlng);
         
         $data['app_call_details'] = $app_call_details;
         
            $cm_id =  $inc_pda_data->emg_cheifcompliant;
            $data['services'] = $this->common_model->get_services();

            $chief_comp = $this->inc_model->get_chief_comp_service($cm_id);
             $data['questions'] =  $this->call_model->get_active_questions($cm_id);
         
          $inc_details = array(
                'lat' => $inc_pda_data->emg_incidentlat,
                'inc_address' => $inc_pda_data->emg_incidentadd ,
                'lng' => $inc_pda_data->emg_incidentlng,
                'chief_complete_id' => $cm_id,
                'chief_complete' => $chief_comp[0]->ct_type,
                'emg_cad_inc_id'=>$CADIncidentID
              
              );
         
         $data['inc_details'] = $inc_details;
         
        if ($this->agent->is_mobile()) {
            $data['agent_mobile'] = 'yes';
        } else {
            $data['agent_mobile'] = 'no';
        }

        $this->output->add_to_position($this->load->view('frontend/calls/caller_details_view', $data, TRUE), 'call_detail', TRUE);
        
        $this->output->add_to_position($this->load->view('frontend/inc/non_mci_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "calls";
    }

}
