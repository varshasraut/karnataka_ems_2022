<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Fire_calls extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->active_module = "M-CALLS";

        $this->pg_limit = $this->config->item('pagination_limit');

        $this->pg_limits = $this->config->item('report_clg');

        $this->load->model(array('call_model', 'get_city_state_model', 'options_model', 'module_model', 'common_model', 'Pet_model', 'Ercp_model', 'amb_model', 'inc_model', 'colleagues_model', 'pcr_model', 'cluster_model', 'medadv_model', 'enquiry_model', 'fleet_model', 'police_model', 'fire_model'));

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
    
        if ($user_group == 'UG-FDA' || $user_group == 'UG-FDASupervisor') {

        $this->post = $this->input->post();
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');

        $this->post['base_month'] = get_base_month();

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        ///////////////  Filters //////////////////

        $data['search'] = ($this->post['search']) ? $this->post['search'] : $this->fdata['search'];


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
            // 'operator_id' => $this->clg->clg_ref_id,
            'base_month' => $this->post['base_month']
        );
        
        if($this->clg->clg_group == 'UG-FDASupervisor' || $this->clg->clg_group == 'UG-FDASupervisors'){ 
            
            
            //$args['ercp_id'] = ($this->post['ercp_id']) ? $this->post['ercp_id'] : $this->fdata['ercp_id'];
            $args['clg_senior'] = $this->clg->clg_ref_id;
            $data['clg_senior'] = $this->clg->clg_ref_id;
            
            
            $clg_args = array('clg_senior'=>$this->clg->clg_ref_id,'clg_group'=>'UG-FDA');
           
            $data['fda_clg'] = $this->colleagues_model->get_clg_data($clg_args);
            
            
            
            foreach($data['fda_clg'] as $fda){
                $child_fda[] = $fda->clg_ref_id;
            }

            if(is_array($child_fda)){
                $child_fda= implode("','", $child_fda);
            }
            
            
            if ( $data['fda_id']  != '') {
                $args_dash['operator_id'] = $this->post['fda_id'];
            }else{
                //$args_dash['child_fda'] = $child_fda;
            }
            
        }else{
            $args_dash['operator_id'] = $this->clg->clg_ref_id;
            $args_dash['base_month'] = $this->post['base_month'];
            //$args_dash['pda_operator_id'] = $this->clg->clg_ref_id;
        
        }
  

        



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

        $data['inc_info'] = $this->fire_model->get_inc_by_fire($args_dash, $offset, $limit);


        $inc_data = (object) array();

        $data['per_page'] = $limit;

//        $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->fire_model->get_inc_by_fire($args_dash);
      


        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("fire_calls/fire_dash"),
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

        $data['pg_rec_amb'] = ($this->post['pg_rec_amb']) ? $this->post['pg_rec_amb'] : $this->fdata['pg_rec_amb'];

        $ambflt['AMB'] = $data;


        //////////////////////////limit & offset//////


        $data['get_count'] = TRUE;

        // $data['amb_user_type']= 'tdd';
        $data['total_count'] = $this->amb_model->get_amb_data($data);

        $limit = ($data['pg_rec_amb']) ? $data['pg_rec_amb'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;


        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['AMB'] = $data;

        //$this->session->set_userdata('filters', $ambflt);
        /////////////////////////////////////////////////////


        unset($data['get_count']);

        $data['result'] = $this->amb_model->get_amb_data($data, $offset, $limit);


        $data['get_data'] = $this->amb_model->get_working_area();

        $data['cur_page'] = $page_no;
        $pgconf_amb = array(
            'url' => base_url("fire_calls/fire_dash"),
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

        $this->output->add_to_position($this->load->view('frontend/fire_calls/fire_dashboard_view', $data, TRUE), 'content', TRUE);

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

        

        $args_dash = array('base_month' => $this->post['base_month']);
        if($this->clg->clg_group == 'UG-FDASupervisor'){    
            
            
            //$args['ercp_id'] = ($this->post['ercp_id']) ? $this->post['ercp_id'] : $this->fdata['ercp_id'];
            $args['clg_senior'] = $this->clg->clg_ref_id;
            $data['clg_senior'] = $this->clg->clg_ref_id;
            
            
            $clg_args = array('clg_senior'=>$this->clg->clg_ref_id,'clg_group'=>'UG-FDA');
           
            $data['fda_clg'] = $this->colleagues_model->get_clg_data($clg_args);
            
            foreach($data['fda_clg'] as $fda){
                $child_fda[] = $fda->clg_ref_id;
            }

            if(is_array($child_fda)){
                $child_fda= implode("','", $child_fda);
            }
            
            
            if ( $data['fda_id']  != '') {
                $args_dash['operator_id'] = $this->post['fda_id'];
            }else{
                //$args_dash['child_fda'] = $child_fda;
            }
            
        }else{
            $args_dash['operator_id'] = $this->clg->clg_ref_id;
            $args_dash['base_month'] = $this->post['base_month'];
            //$args_dash['pda_operator_id'] = $this->clg->clg_ref_id;
        
        }

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

        $data['inc_info'] = $this->fire_model->get_inc_by_fire($args_dash, $offset, $limit);


        $inc_data = (object) array();

        $data['per_page'] = $limit;

//        $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->fire_model->get_inc_by_fire($args_dash);


        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("fire_calls/fire_dash"),
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


        $this->output->add_to_position($this->load->view('frontend/fire_calls/fire_previous_dashboard_view', $data, TRUE), 'fire_incident_calls', TRUE);

        $this->output->template = "calls";
    }

    function f_manual_call() {
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
            // 'operator_id' => $this->clg->clg_ref_id,
            'base_month' => $this->post['base_month']
        );
        
        if($this->clg->clg_group == 'UG-FDASupervisor' || $this->clg->clg_group == 'UG-FDASupervisors'){ 
            
            
            //$args['ercp_id'] = ($this->post['ercp_id']) ? $this->post['ercp_id'] : $this->fdata['ercp_id'];
            $args['clg_senior'] = $this->clg->clg_ref_id;
            $data['clg_senior'] = $this->clg->clg_ref_id;
            
            
            $clg_args = array('clg_senior'=>$this->clg->clg_ref_id,'clg_group'=>'UG-FDA');
           
            $data['fda_clg'] = $this->colleagues_model->get_clg_data($clg_args);
            
            
            
            foreach($data['fda_clg'] as $fda){
                $child_fda[] = $fda->clg_ref_id;
            }

            if(is_array($child_fda)){
                $child_fda= implode("','", $child_fda);
            }
            
            
            if ( $data['fda_id']  != '') {
                $args_dash['operator_id'] = $this->post['fda_id'];
            }else{
                //$args_dash['child_fda'] = $child_fda;
            }
            
        }else{
            $args_dash['operator_id'] = $this->clg->clg_ref_id;
            $args_dash['base_month'] = $this->post['base_month'];
            //$args_dash['pda_operator_id'] = $this->clg->clg_ref_id;
        
        }

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

        $data['inc_info'] = $this->fire_model->get_inc_by_fire_manual_calls($args_dash, $offset, $limit);

        $inc_data = (object) array();

        $data['per_page'] = $limit;


        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->fire_model->get_inc_by_fire_manual_calls($args_dash);


        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("fire_calls/fire_dash"),
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

        $data['pg_rec_amb'] = ($this->post['pg_rec_amb']) ? $this->post['pg_rec_amb'] : $this->fdata['pg_rec_amb'];

        $ambflt['AMB'] = $data;


        //////////////////////////limit & offset//////


        $data['get_count'] = TRUE;

        // $data['amb_user_type']= 'tdd';
        $data['total_count'] = $this->amb_model->get_amb_data($data);

        $limit = ($data['pg_rec_amb']) ? $data['pg_rec_amb'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;


        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['AMB'] = $data;

        //$this->session->set_userdata('filters', $ambflt);
        /////////////////////////////////////////////////////


        unset($data['get_count']);

        $data['result'] = $this->amb_model->get_amb_data($data, $offset, $limit);


        $data['get_data'] = $this->amb_model->get_working_area();

        $data['cur_page'] = $page_no;
        $pgconf_amb = array(
            'url' => base_url("fire_calls/fire_dash"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=amb"
            )
        );

        $config = get_pagination($pgconf_amb);
        $data['amb_pagination'] = get_pagination($pgconf_amb);
        $type = $this->post['type'];

        $this->output->add_to_position($this->load->view('frontend/fire_calls/fire_manual_call_dashboard_view', $data, TRUE), 'fire_incident_calls', TRUE);

        $this->output->template = "calls";
    }

    function fire_call_details() {


        $inc_args = array(
            'inc_ref_id' => $this->post['inc_ref_id'],
            'base_month' => $this->post['base_month'],
        );

        $data['inc_data'] = $this->call_model->get_inc_type($inc_args);

        $inc_type = $data['inc_data'][0]->inc_type;

        $call_name = $data['inc_data'][0]->pname;



        if ($inc_type != 'IN_HO_P_TR' && $inc_type != 'MCI' && $inc_type != 'NON_MCI' && $inc_type != 'AD_SUP_REQ' && $inc_type != 'AD_SUP_REQ' && $inc_type != 'TRANS_FDA') {

            $this->output->message = "<p>Call Type : " . $call_name . "</p><br><p>This call not for fire call </p>.";

            return;
        }


        if (!isset($this->post['inc_ref_id'])) {

            $data['opt_id'] = $this->post['opt_id'];

            $data['sub_id'] = $this->post['sub_id'];



            ////////////////////////////////////////////////////////////

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

            ////////////////////////////////////////////////////////////


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




        ////////////////////////////////////////////////////////////////


        $args = array(
            'adv_cl_inc_id' => $data['cl_dtl'][0]->adv_inc_ref_id,
            'base_month' => $this->post['base_month']
        );


        $data['prev_cl_dtl'] = $this->medadv_model->prev_call_adv($args);


        $args_pat = array(
            'adv_cl_ptn_id' => $data['pt_info'][0]->ptn_id,
            'adv_cl_base_month' => $this->post['base_month'],
            'adv_cl_inc_id' => $this->post['inc_ref_id'],
        );

        $data['medadv_info'] = $this->medadv_model->get_medadv_by_inc($args_pat);





        $this->output->set_focus_to = "madv_loc";

//        $this->output->add_to_position($this->load->view('frontend/fire_calls/manual_fire_details_view', $data, TRUE), 'content', TRUE);
        $this->output->add_to_position($this->load->view('frontend/fire_calls/fire_details_view', $data, TRUE), 'content', TRUE);
    }
    
    function search_fire_call_details(){
         $inc_args = array(
            'inc_ref_id' => $this->post['inc_ref_id'],
            'base_month' => $this->post['base_month'],
        );

        $data['inc_data'] = $this->call_model->get_inc_type($inc_args);

        $inc_type = $data['inc_data'][0]->inc_type;

        $call_name = $data['inc_data'][0]->pname;



        if ($inc_type != 'IN_HO_P_TR' && $inc_type != 'MCI' && $inc_type != 'NON_MCI' && $inc_type != 'AD_SUP_REQ' && $inc_type != 'AD_SUP_REQ' && $inc_type != 'TRANS_FDA') {

            $this->output->message = "<p>Call Type : " . $call_name . "</p><br><p>This call not for fire call </p>.";

            return;
        }


        if (!isset($this->post['inc_ref_id'])) {

            $data['opt_id'] = $this->post['opt_id'];

            $data['sub_id'] = $this->post['sub_id'];



            ////////////////////////////////////////////////////////////

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

            ////////////////////////////////////////////////////////////


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




        ////////////////////////////////////////////////////////////////


        $args = array(
            'adv_cl_inc_id' => $data['cl_dtl'][0]->adv_inc_ref_id,
            'base_month' => $this->post['base_month']
        );


        $data['prev_cl_dtl'] = $this->medadv_model->prev_call_adv($args);


        $args_pat = array(
            'adv_cl_ptn_id' => $data['pt_info'][0]->ptn_id,
            'adv_cl_base_month' => $this->post['base_month'],
            'adv_cl_inc_id' => $this->post['inc_ref_id'],
        );

        $data['medadv_info'] = $this->medadv_model->get_medadv_by_inc($args_pat);





        $this->output->set_focus_to = "madv_loc";

        $this->output->add_to_position($this->load->view('frontend/fire_calls/manual_fire_details_view', $data, TRUE), 'content', TRUE);
    }

    function get_fire_caller_details() {

        $m_no = $this->input->post('caller');


//        if (isset($m_no)) {
//            $data['m_no'] = $m_no["cl_mobile_number"];
//        } else {
//            $data['m_no'] = $this->input->get('m_no');
//        }
        $form_call_data = $this->input->post('caller');

        if (isset($form_call_data)) {

            $mobile_no =  $form_call_data['cl_mobile_number'];
           // $mobile_no = explode('+91', $form_call_data['cl_mobile_number']);
//            $mobile_no = $form_call_data['cl_mobile_number'];
            $data['m_no'] = $mobile_no;
        }


        $data['caller_details'] = $this->call_model->get_caller_details($data['m_no']);


        $data['emt_details'] = $this->call_model->get_emt_user_details($data['m_no']);
        $datetime = date('Y-m-d H:i:s');
        $data['attend_call_time'] = date('Y-m-d H:i:s');





        $this->output->add_to_position($this->load->view('frontend/fire_calls/caller_details_view', $data, TRUE), 'caller_details', TRUE);

        $this->output->set_focus_to = "caller_relation";


        $data['attend_call_time'] = date('Y-m-d H:i:s');

        $this->output->add_to_position($this->load->view('frontend/fire_calls/inc_manual_call_filter_search_view', $data, TRUE), 'fire_incident_calls', TRUE);
        $this->output->template = "calls";
    }

    function get_fire_station_information() {

        $data = array(
            'f_id' => $this->post['f_id'],
        );

        $data['fire_station'] = $this->fleet_model->get_all_fire_station($data);

        $this->output->add_to_position($this->load->view('frontend/fire_calls/fire_station_information_view', $data, TRUE), 'police_station_information', TRUE);
    }

    function save_fire() {

        if ($inc_id == '') {
            $inc_id = generate_fire_inc_ref_id();
            update_fire_inc_ref_id($inc_id);
        }

        $args = array(
            'fc_base_month' => $this->post['base_month'],
            'fc_added_date' => $this->today,
            'fc_added_by' => $this->clg->clg_ref_id,
            'fc_modify_date' => $this->today,
            'fc_modify_by' => $this->clg->clg_ref_id,
            'fc_inc_ref_id' => 'F-' . $inc_id,
            'fc_state_code' => $this->post['incient_state'],
            'fc_district_code' => $this->post['incient_district'],
            'fc_fire_station_id' => $this->post['incient_fire'],
            'fc_pre_inc_ref_id' => $this->post['inc_ref_id'],
            'fc_assign_time' => date('Y-m-d H:i:s', strtotime($this->post['fc_assign_time']))
        );


        $args = array_merge($this->post['fire'], $args);


        $fire = $this->fire_model->add_fire($args);


        $fire_operator = array(
            'sub_id' => $this->post['inc_ref_id'],
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'sub_status' => 'ATND',
        );

        $fire_args = array(
            'sub_id' => $this->post['inc_ref_id'],
            'operator_type' => $this->clg->clg_group,
        );

        $res = $this->common_model->update_operator($fire_args, $fire_operator);


        if ($res) {

            $this->output->message = "<div class='success'>Details saved successfully</div><script>window.location.reload(true);</script>";
        }
    }

    function search_call() {
        $this->output->add_to_position($this->load->view('frontend/fire_calls/inc_fire_search_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "calls";
    }

    function fire_incident_search() {

        $this->output->add_to_position($this->load->view('frontend/fire_calls/fire_incident_search', $data, TRUE), 'content', TRUE);
        $this->output->template = "calls";
    }

    function fire_manual_call() {

        $data['attend_call_time'] = date('Y-m-d H:i:s');

        $this->output->add_to_position($this->load->view('frontend/fire_calls/inc_manual_call_search_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "calls";
    }

    public function fire_dash($generated = false) {

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

        $inc_info = $this->fire_model->get_inc_by_fire($args_dash, $offset, $limit);

        $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->fire_model->get_inc_by_fire($args_dash);
        //$total_cnt = $this->pcr_model->get_inc_by_emt($args_dash,'','',$filter,$sortby,$incomplete_inc_amb);

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
            'url' => base_url("fire_calls/fire_dash"),
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


        $this->output->add_to_position($this->load->view('frontend/fire_calls/fire_dashboard_view', $data, TRUE), 'calls_amb_list', TRUE);

        $this->output->template = "calls";
    }

    function save_call_details() {

        $data['caller'] = $this->post['caller'];



        $data['attend_call_time'] = date('Y-m-d H:i:s');

        $this->output->add_to_position($this->load->view('frontend/fire_calls/inc_manual_call_filter_search_view', $data, TRUE), 'fire_incident_calls', TRUE);
        $this->output->template = "calls";
    }

    function save_manual_fire() {

        if ($inc_id == '') {
            $inc_id = generate_fire_inc_ref_id();
            update_fire_inc_ref_id($inc_id);
        }

        $data['fire'] = $this->post['fire'];
        
       

    
        $args = array(
            'fc_base_month' => $this->post['base_month'],
            'fc_added_date' => $this->today,
            'fc_added_by' => $this->clg->clg_ref_id,
            'fc_modify_date' => $this->today,
            'fc_modify_by' => $this->clg->clg_ref_id,
            'fc_inc_ref_id' => 'F-' . $inc_id,
            'fc_state_code' => $this->post['incient_state'],
            'fc_district_code' => $this->post['incient_district'],
            'fc_fire_station_id' => $this->post['incient_fire'],
            'fc_assign_time' => date('Y-m-d H:i:s', strtotime($data['fire']['fc_assign_time']))
        );
        
     

        $args = array_merge($this->post['fire'], $args);

        $police = $this->fire_model->add_fire($args);


        $manual_args = array(
            'mc_base_month' => $this->post['base_month'],
            'mc_added_date' => $this->today,
            'mc_added_by' => $this->clg->clg_ref_id,
            'mc_modify_date' => $this->today,
            'mc_modify_by' => $this->clg->clg_ref_id,
            'mc_inc_ref_id' => 'F-' . $inc_id,

        );

        if ($this->post['hp_dtl_state'] != '') {
            $manual_args['mc_state_code'] = $this->post['hp_dtl_state'];
        }

        if ($this->post['hp_dtl_district'] != '') {
            $manual_args['mc_district_code'] = $this->post['hp_dtl_district'];
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



        $inc_args = array_merge($this->post['caller'], $manual_args);

        $fire_manual = $this->fire_model->add_fire_manual_call($inc_args);


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

    function fire_records_view() {

        $data['action_type'] = $this->post['action_type'];

        $args = array(
            'fc_inc_ref_id' => base64_decode($this->post['fc_inc_ref_id']),
            'base_month' => $this->post['base_month']
        );

        $data['inc_info'] = $this->fire_model->get_inc_by_fire($args, $offset, $limit);
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



        $this->output->add_to_position($this->load->view('frontend/fire_calls/fire_records_view', $data, TRUE), $output_position, TRUE);
    }

    function fire_manual_records_view() {


        $data['action_type'] = $this->post['action_type'];

        $args = array(
            'fc_inc_ref_id' => base64_decode($this->post['fc_inc_ref_id']),
            'base_month' => $this->post['base_month']
        );

        $data['inc_info'] = $this->fire_model->get_inc_by_fire_manual_calls($args, $offset, $limit);

        $this->output->add_to_position($this->load->view('frontend/fire_calls/fire_manual_records_view', $data, TRUE), $output_position, TRUE);
    }

    function update_fire() {


        $police_data = $this->post['fire'];
        $police_data['fc_modify_by'] = $this->clg->clg_ref_id;
        $police_data['fc_modify_date'] = date('Y-m-d H:i:s');


        $police_data['fc_curr_date_time'] = date('Y-m-d H:i:s', strtotime($police_data['fc_curr_date_time']));

        $police_data['fc_is_close'] = '1';



        $result = $this->fire_model->update_fire($police_data);


        if ($result) {

            $this->output->status = 1;

            $this->output->closepopup = 'yes';

            $this->output->message = "<div class='success'>Fire Updated Successfully</div><script>window.location.reload(true);</script>";
        }
    }

    function show_other_fire_remark() {

        $this->output->add_to_position($this->load->view('frontend/fire_calls/other_remark_textbox_view', $data, TRUE), 'fire_remark_other_textbox', TRUE);
    }

}
