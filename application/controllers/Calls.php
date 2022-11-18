<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calls extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->active_module = "M-CALLS";

        $this->pg_limit = $this->config->item('pagination_limit');

        $this->pg_limits = $this->config->item('report_clg');

        $this->load->model(array('counslor_model','pet_model','call_model', 'get_city_state_model', 'options_model', 'module_model', 'common_model', 'Pet_model', 'Ercp_model', 'amb_model', 'inc_model', 'colleagues_model', 'pcr_model', 'cluster_model', 'medadv_model', 'enquiry_model', 'module_model', 'feedback_model', 'quality_model', 'grievance_model', 'police_model','fire_model','problem_reporting_model','hp_model','shiftmanager_model','biomedical_model'));

        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper', 'language_helper','dash_helper','api_helper'));
        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));
        
        $this->site_name = $this->config->item('site_name');
         $this->post = $this->input->get_post(NULL);
        $this->post['base_month'] = get_base_month();
        $this->site = $this->config->item('site');
         $this->sess_expiration = $this->config->item('sess_expiration');
        $this->clg = $this->session->userdata('current_user');
        $this->default_state = $this->config->item('default_state');
        //$this->post['base_month'] = get_base_month();
        $this->clg = $this->session->userdata('current_user');
        $this->today = date('Y-m-d H:i:s');
        $this->ameyo_server_url = $this->config->item('ameyo_server_url');

        
        if ($this->input->post('filters', TRUE) == 'reset') {
            $this->session->unset_userdata('filters')['ALL_CALL'];
        }
        if ($this->input->post('filters', TRUE) == 'reset') {
            $this->session->unset_userdata('filters')['AMB'];
        }

        if ($this->session->userdata('filters')['ALL_CALL']) {
            $this->fdata = $this->session->userdata('filters')['ALL_CALL'];
        }
        if ($this->session->userdata('filters')['AMB']) {
            $this->cdata = $this->session->userdata('filters')['AMB'];
        }
    }
    //    function update_incidence_id(){
//        
//        $incidence = $this->inc_model->get_incidence_by_epcr_update();
//        foreach($incidence as $inc){
//            if($inc->inc_ref_id != ''){
//            $args = array('inc_id'=>$inc->inc_id,'inc_ref_id'=>$inc->inc_ref_id);
//            $inc_data =$this->inc_model->get_incidence_by_epcr_update_inc($args);
//            }
//        }
//        die();
//    }
//    function update_incidence_ambulance_id(){
//        
//        $incidence = $this->inc_model->get_incidence_amb_by_epcr_update();
//        foreach($incidence as $inc){
//           // var_dump($inc);
//            if($inc->inc_ref_id != ''){
//                $args = array('inc_amb_id'=>$inc->inc_amb_id,'inc_ref_id'=>$inc->inc_ref_id);
//                $inc_data = $this->inc_model->get_incidence_by_epcr_update_inc_amb($args);
//            }
//
//        }
//       die();
//    }
    
    function calls_blank(){
        $this->output->add_to_position($this->load->view('frontend/calls/ero_blank_view', $data, TRUE), 'content', TRUE);
           $this->output->template = "calls";
    }
    public function erorfollowup_list(){
        $data['default_state'] = $this->default_state; 
        $this->post = $this->input->post();
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');

        $this->post['base_month'] = get_base_month();
        
        ero_free_user_call($this->clg->clg_ref_id);

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->cdata['pg_rec'];
        $data['ero_id'] = ($this->post['ero_id']) ? $this->post['ero_id'] : $this->cdata['ero_id'];

        //$this->pg_limit = 10;
        ///////////set page number////////////////////
        $args_dash = array();
        $page_no = 1;

        if ($this->post['from_date'] != '') {
            $args_dash['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->cdata['from_date']));
        }else{
             $args_dash['from_date'] = date('Y-m-d', strtotime("-1 days"));
        }


        if ($this->post['to_date'] != '') {
            $args_dash['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->cdata['to_date']));
        }else{
             $args_dash['to_date'] = date('Y-m-d');
        }
        
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }


        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        $data['clg_group'] = $this->clg->clg_group;

            
        $args_dash['operator_id'] = $this->clg->clg_ref_id;
        $args_dash['base_month'] = $this->post['base_month'];
        
        if($this->post['team_type'] != ''){
            $team_type =$args_dash['team_type'] = $data['team_type']= $this->post['team_type'];
        }
        
        $args_dash['pcr_status'] = '0,1';
        $args_dash['incis_deleted'] = '0';
        $args_dash['followup_status'] = '1';


        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        $inc_info = $this->call_model->get_inc_by_followupero($args_dash, $offset, $limit);


        $inc_data = (object) array();

        $data['per_page'] = $limit;

        $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->call_model->get_inc_by_followupero($args_dash);
        //die();
     
        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("calls/erorfollowup_list"),
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
        
        $current_month = date('m');
		$current_year = date('Y');
        
        $current_date = date('Y-m-d');
        $current_month_date =  $current_year.'-'.$current_month.'-01';
        $END_day = date("Y-m-t", strtotime($current_month_date));

        $start_date_amb = date('Y-m-d', strtotime($post_reports['from_date']));
        $end_date_amb = date('Y-m-t', strtotime($post_reports['from_date']));


        $data['all_purpose_of_calls'] = $this->call_model->get_all_child_purpose_of_calls();
        $data['operator_id'] = $this->clg->clg_ref_id;
      
        
        $this->output->add_to_position('', 'call_detail', TRUE);
        $this->output->add_to_position($this->load->view('frontend/calls/followuoero_dashboard_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "calls";
        
    }
    public function index($generated = false) {
        
        $user_group=$this->clg->clg_group;  
       
        
        if($user_group == 'UG-ERO-102' || $user_group == 'UG-ERO' || $user_group == 'UG-EROSupervisor' || $user_group == 'UG-REMOTE' || $user_group == 'UG-BIKE-ERO' || $user_group == 'UG-ERCTRAINING' ||$user_group == 'UG-ERO-104' || $user_group == 'UG-EROSupervisor-104') {
            
        $data['default_state'] = $this->default_state; 
        $this->post = $this->input->post();
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');

        $this->post['base_month'] = get_base_month();
        
        ero_free_user_call($this->clg->clg_ref_id);
        
        
        $ext_no = get_cookie("avaya_extension_no");
        $agent_id1=$this->clg->clg_avaya_agentid; 
        $agent_id='-1'; 
        $crmsessionId=$this->clg->clg_crmsessionId; 
      
        $campaign=$this->clg->clg_avaya_campaign; 
        $sessionid= $this->session->userdata('sessionid');
        $crtObjectId =  $this->session->userdata('crtObjectId');
        $userCrtObjectId =  $this->session->userdata('userCrtObjectId');
        $cti_mobile_number =  $this->session->userdata('cti_mobile_number');
        
        $cl_purpose = $this->session->userdata('cl_purpose');
        
        $disposition_code = 'Dispatch';
        if($cl_purpose != ''){
            $disposition_code = get_purpose_of_call($cl_purpose);
        }
          
        if($sessionid != ''){      
            
            
            $crm_data = 'phone='.$cti_mobile_number.'&campaignId='.$campaign.'&customerId='.$agent_id.'&dispositionCode='.$disposition_code.'&sessionId='.$sessionid.'&crtObjectId='.$crtObjectId.'&userCrtObjectId='.$userCrtObjectId.'&selfCallback=true';
            $avaya_server_url =  $this->ameyo_server_url.'/dacx/dispose?'.$crm_data;
            
            if (!is_dir('./logs/' . date("Y-m-d"))) {
                mkdir('./logs/' . date("Y-m-d"), 0755, true);
            }           
              //file_put_contents('./logs/'.date("Y-m-d").'/'.$agent_id1.'_dispose_call_para.log', $avaya_server_url.",\r\n", FILE_APPEND);

          
            $avaya_resp =  agent_dispose_call($avaya_server_url,$data);
            
            //file_put_contents('./logs/'.date("Y-m-d").'/'.$agent_id1.'_all_dispose_call.log', json_encode($avaya_resp).",\r\n", FILE_APPEND);
            //file_put_contents('./logs/'.date("Y-m-d").'/'.$agent_id1.'_dispose_call.log', $avaya_resp['resp'].",\r\n", FILE_APPEND);
        
        }
        $this->session->unset_userdata('cti_mobile_number');
        $this->session->unset_userdata('dispose_dial');
        $this->session->set_userdata('call_action','');
        
        $ser_args = array('ext_no'=>$ext_no);
        $service_data = $this->call_model->get_all_avaya_extension_new($ser_args);
        $service_type = $service_data[0]->type;
              
        $app_call_details = $this->session->userdata('app_call_details');
        $com_args = array('calld_id'=>$app_call_details[0]->calld_id,'call_status'=>'Call End');
        $update_app_call_details = $this->call_model->update_app_call_details($com_args);

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->cdata['pg_rec'];
        $data['ero_id'] = ($this->post['ero_id']) ? $this->post['ero_id'] : $this->cdata['ero_id'];

        //$this->pg_limit = 10;
        ///////////set page number////////////////////
        $args_dash = array();
        $page_no = 1;

        if ($this->post['from_date'] != '') {
            $args_dash['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->cdata['from_date']));
        }else{
            $args_dash['from_date'] = date('Y-m-d', strtotime("-6 hours"));
        }


        if ($this->post['to_date'] != '') {
            $args_dash['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->cdata['to_date']));
        }else{
             $args_dash['to_date'] = date('Y-m-d');
        }
        
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }


        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        $data['clg_group'] = $this->clg->clg_group;


        if($this->clg->clg_group == 'UG-EROSupervisor'){           
            
            $args['clg_senior'] = $this->clg->clg_ref_id;
            $data['clg_senior'] = $this->clg->clg_ref_id;
            
            
            $clg_args = array('clg_senior'=>$this->clg->clg_ref_id,'clg_group'=>'UG-ERO');
           //var_dump($data['ero_clg']);die;
            $data['ero_clg'] = $this->colleagues_model->get_clg_data($clg_args);
            
            foreach($data['ero_clg'] as $ero){
                $child_ero[] = $ero->clg_ref_id;
            }

            if(is_array($child_ero)){
                $child_ero = implode("','", $child_ero);
            }
            
            
            if ( $this->post['user_id']  != '') {
                $args_dash['operator_id'] = $this->post['user_id'];
            }else{
               // $args_dash['child_ero'] = $child_ero;
            }
             $args_dash['base_month'] = $this->post['base_month'];
            
        } else {
            
                $args_dash['operator_id'] = $this->clg->clg_ref_id;
                $args_dash['base_month'] = $this->post['base_month'];
        }
        if($this->post['team_type'] != ''){
            $team_type =$args_dash['team_type'] = $data['team_type']= $this->post['team_type'];
        }
        
        $args_dash['pcr_status'] = '0,1';
        $args_dash['incis_deleted'] = '0,2';


        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        $inc_info = $this->call_model->get_inc_by_ero($args_dash, $offset, $limit);


        $inc_data = (object) array();

        $data['per_page'] = $limit;

        $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->call_model->get_inc_by_ero($args_dash);
        //die();
     
        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("calls/ero_dash"),
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
        
        $current_month = date('m');
		$current_year = date('Y');
        
        $current_date = date('Y-m-d');
        $current_month_date =  $current_year.'-'.$current_month.'-01';
        $END_day = date("Y-m-t", strtotime($current_month_date));

        $start_date_amb = date('Y-m-d', strtotime($post_reports['from_date']));
        $end_date_amb = date('Y-m-t', strtotime($post_reports['from_date']));


        $quality_args = array(
            'base_month' => $this->post['base_month'],
            'user_type' => 'ERO',
            'from_date' => $current_month_date,
            'to_date' => $END_day,
            'qa_ad_user_ref_id' => $this->clg->clg_ref_id);

        $data['audit_details'] = $this->quality_model->get_quality_audit($quality_args);
        //$data['audit_details'] =  0;
        
        
        $current_month = date('m');
        $current_year = date('Y');
        $current_month_date =  $current_year.'-'.$current_month.'-01';
        $month_report_args =  array('from_date' => date('Y-m-d',strtotime($current_month_date)),
                       'to_date' => date('Y-m-t', strtotime($current_month_date)));

        $month_report_args['get_count'] = 'true';
        $month_report_args['operator_id'] = $this->clg->clg_ref_id;
        $month_report_args['base_month'] = $this->post['base_month'];
        $data['total_month_call'] = $this->inc_model->get_all_inc($month_report_args);
        //$data['total_month_call'] = 0;
        
        $data['total_month_dispatch_call'] = $this->inc_model->get_all_dispatch_inc($month_report_args);
        //$data['total_month_dispatch_call'] = 0;
       

        $today_report_args =  array('from_date' => date('Y-m-d',strtotime($current_date)),
                       'to_date' => date('Y-m-d',strtotime($current_date)));

        $today_report_args['get_count'] = 'true';
        $today_report_args['operator_id'] = $this->clg->clg_ref_id;
        $today_report_args['base_month'] = $this->post['base_month'];
        $data['today_month_call'] = $this->inc_model->get_all_inc($today_report_args);
        //$data['today_month_call'] = 0;
        
        $data['today_month_dispatch_call'] = $this->inc_model->get_all_dispatch_inc($today_report_args);
        //$data['today_month_dispatch_call'] = 0;

       $data['all_purpose_of_calls'] = $this->call_model->get_all_child_purpose_of_calls();
       

       $data['all_purpose_of_104_calls'] = $this->call_model->get_all_child_purpose_of_104_calls();

       
        $data['operator_id'] = $this->clg->clg_ref_id;
        $args = array();
        $clg_ref_id = trim($this->input->post('clg_ref_id'));
        $args = array('clg_reff_id' => trim($this->input->post('clg_ref_id')));

        $report_args = array(
                'clg_ref_id'=>$this->clg->clg_ref_id,
                'single_date' => date('Y-m-d'),
                'base_month' => $this->post['base_month']
            );
         $data['login_details'] = array();
         $data['login_details'] = $this->shiftmanager_model->get_login_details_ero($report_args);
         $data['login_details'] = 0;
        
        $aht = $this->session->userdata('aht_time');
        $current_datetime =date('Y-m-d H:i:s');
        $newdate =  date("Y-m-d H:i:s", (strtotime ('+2 hour' , strtotime ($aht)))) ;
        //$newdate =  date("Y-m-d H:i:s", (strtotime ('-2 hour' , strtotime ($aht)))) ;
     //$aht =  NULL;
        
        
        
             
        if ($aht == NULL) {

            $this->session->set_userdata('aht_time', date('Y-m-d H:i:s'));

            $aht_eme_args = array(
                'to_date' => date('Y-m-d'),
                'from_date' => date('Y-m-d'),
                'base_month' => $this->post['base_month'],
                'clg_ref_id'=>$this->clg->clg_ref_id,
            );
            $data['emergency_aht'] = $this->call_model->get_emergency_aht($aht_eme_args);
            //$data['emergency_aht'] = 0;
          
            $this->session->set_userdata('emergency_aht', $data['emergency_aht']);

            $data['non_emergency_aht'] = $this->call_model->get_non_emergency_aht($aht_eme_args);
            //$data['non_emergency_aht'] = 0;
            $this->session->set_userdata('non_emergency_aht', $data['non_emergency_aht']);

            $data['total_aht'] = $this->call_model->get_total_aht($aht_eme_args);
            //$data['total_aht'] = 0;
            $this->session->set_userdata('total_aht', $data['total_aht']);

            $mdt_aht_eme_args = array(
                'to_date' => date('Y-m-01', strtotime($current_datetime)),
                'from_date' => date('Y-m-t', strtotime($current_datetime)),
                'base_month' => $this->post['base_month'],
                'clg_ref_id'=>$this->clg->clg_ref_id,
            );

            $data['mdt_emergency_aht'] = $this->call_model->get_emergency_aht($mdt_aht_eme_args);
            //$data['mdt_emergency_aht'] = 0;
           
            $this->session->set_userdata('mdt_emergency_aht', $data['mdt_emergency_aht']);


            $data['mdt_non_emergency_aht'] = $this->call_model->get_non_emergency_aht($mdt_aht_eme_args);
            //$data['mdt_non_emergency_aht'] = 0;
            
            $this->session->set_userdata('mdt_non_emergency_aht', $data['mdt_non_emergency_aht']);

            $data['mdt_total_aht'] = $this->call_model->get_total_aht($mdt_aht_eme_args);
            //$data['mdt_total_aht'] = 0;
            $this->session->set_userdata('mdt_total_aht', $data['mdt_total_aht']);
        } else {
         
          
            if (strtotime($newdate) < strtotime($aht)) {
                
             
                $this->session->set_userdata('aht_time', date('Y-m-d H:i:s'));

                $aht_eme_args = array(
                    'to_date' => date('Y-m-d'),
                    'from_date' => date('Y-m-d'),
                    'base_month' => $this->post['base_month'],
                    'clg_ref_id'=>$this->clg->clg_ref_id,
                );
                $data['emergency_aht'] = $this->call_model->get_emergency_aht($aht_eme_args);
                //$data['emergency_aht'] = 0;
                $this->session->set_userdata('emergency_aht', $data['emergency_aht']);

                $data['non_emergency_aht'] = $this->call_model->get_non_emergency_aht($aht_eme_args);
                //$data['non_emergency_aht'] = 0;
                $this->session->set_userdata('non_emergency_aht', $data['non_emergency_aht']);

                $data['total_aht'] = $this->call_model->get_total_aht($aht_eme_args);
                //$data['total_aht'] = 0;
                $this->session->set_userdata('total_aht', $data['total_aht']);

                $mdt_aht_eme_args = array(
                    'to_date' => date('Y-m-01', strtotime($current_datetime)),
                    'from_date' => date('Y-m-t', strtotime($current_datetime)),
                    'base_month' => $this->post['base_month'],
                    'clg_ref_id'=>$this->clg->clg_ref_id,
                );
               
                $data['mdt_emergency_aht'] = $this->call_model->get_emergency_aht($mdt_aht_eme_args);
                //$data['mdt_emergency_aht'] = 0;
                $this->session->set_userdata('mdt_emergency_aht', $data['mdt_emergency_aht']);


                $data['mdt_non_emergency_aht'] = $this->call_model->get_non_emergency_aht($mdt_aht_eme_args);
                //$data['mdt_non_emergency_aht'] = 0;
                $this->session->set_userdata('mdt_non_emergency_aht', $data['mdt_non_emergency_aht']);

                $data['mdt_total_aht'] = $this->call_model->get_total_aht($mdt_aht_eme_args);
                //$data['mdt_total_aht'] = 0;
                $this->session->set_userdata('mdt_total_aht', $data['mdt_total_aht']);
            } else {
             
                $data['emergency_aht'] = $this->session->userdata('emergency_aht');
                $data['non_emergency_aht'] = $this->session->userdata('non_emergency_aht');
                $data['total_aht'] = $this->session->userdata('total_aht');
                $data['mdt_emergency_aht'] = $this->session->userdata('mdt_emergency_aht');
                $data['mdt_non_emergency_aht'] = $this->session->userdata('mdt_non_emergency_aht');
                $data['mdt_total_aht'] = $this->session->userdata('mdt_total_aht');
            }
        }



        $ero_bref = array('to_date'=>date('Y-m-d'),
                                'from_date'=>date('Y-m-d'),
                                'clg_ref_id'=>$this->clg->clg_ref_id,
                                'break_type'=>'2');
        //$ero_bref_break_summary = $this->shiftmanager_model->get_break_total_time_user($ero_bref);
        //$ero_bref_total_time = gmdate("H:i:s", $ero_bref_break_summary[0]->break_total_time);
        $ero_bref_total_time = 0;

        $ero_feed = array('to_date'=>date('Y-m-d'),
                                'from_date'=>date('Y-m-d'),
                                'clg_ref_id'=>$this->clg->clg_ref_id,
                                'break_type'=>'3');
        //$ero_feed_break_summary = $this->shiftmanager_model->get_break_total_time_user($ero_feed);
        //$ero_feed_total_time = gmdate("H:i:s", $ero_feed_break_summary[0]->break_total_time);
        $ero_feed_total_time = 0;

        $man_meet = array('to_date'=>date('Y-m-d'),
                                'from_date'=>date('Y-m-d'),
                                'clg_ref_id'=>$this->clg->clg_ref_id,
                                'break_type'=>'8');
        //$man_meet_break_summary = $this->shiftmanager_model->get_break_total_time_user($man_meet);
        //$man_meet_total_time = gmdate("H:i:s", $man_meet_break_summary[0]->break_total_time);
        $man_meet_total_time = 0;
        
        $qa_feed = array('to_date'=>date('Y-m-d'),
                                'from_date'=>date('Y-m-d'),
                                'clg_ref_id'=>$this->clg->clg_ref_id,
                                'break_type'=>'9');
        //$qa_feed_break_summary = $this->shiftmanager_model->get_break_total_time_user($qa_feed);
        //$qa_feed_total_time = gmdate("H:i:s", $qa_feed_break_summary[0]->break_total_time);
        $qa_feed_total_time = 0;
    
        $tl_feed = array('to_date'=>date('Y-m-d'),
                'from_date'=>date('Y-m-d'),
                'clg_ref_id'=>$this->clg->clg_ref_id,
                'break_type'=>'12');
        //$tl_feed_break_summary = $this->shiftmanager_model->get_break_total_time_user($tl_feed);
        //$tl_feed_total_time = gmdate("H:i:s", $tl_feed_break_summary[0]->break_total_time);
        $tl_feed_total_time =0;

        $tl_meet = array('to_date'=>date('Y-m-d'),
                            'from_date'=>date('Y-m-d'),
                            'clg_ref_id'=>$this->clg->clg_ref_id,
                            'break_type'=>'13');
//        $tl_meet_break_summary = $this->shiftmanager_model->get_break_total_time_user($tl_meet);
//        $tl_meet_total_time = gmdate("H:i:s", $tl_meet_break_summary[0]->break_total_time);
          $tl_meet_total_time = 0;
          
        $arr = [
            $ero_bref_total_time, $ero_feed_total_time , $man_meet_total_time,
            $qa_feed_total_time, $tl_feed_total_time , $tl_meet_total_time
        ];
        
        $total = 0;
        
        foreach( $arr as $element):
            $temp = explode(":", $element);
            $total+= (int) $temp[0] * 3600;
            $total+= (int) $temp[1] * 60;
            $total+= (int) $temp[2];
        endforeach;
        $formatted = sprintf('%02d:%02d:%02d',
                        ($total / 3600),
                        ($total / 60 % 60),
                        $total % 60);
        
        // echo $formatted;

        $data['tea_break']= $formatted;


        // $data['tea_break'] = $ero_brk1_total_time + $break_total_time ;           
        
        $args_meal_break = array('to_date'=>date('Y-m-d'),
                            'from_date'=>date('Y-m-d'),
                            'clg_ref_id'=>$this->clg->clg_ref_id,
                            'break_type'=>'7');
        //$meal_break_summary = $this->shiftmanager_model->get_break_total_time_user($args_meal_break);
        //$meal_total_time = gmdate("H:i:s", $meal_break_summary[0]->break_total_time);
        //$data['meal_break'] = $meal_total_time;    
        $data['meal_break'] = 0;   
        
        
        $args_boi_break = array('to_date'=>date('Y-m-d'),
                            'from_date'=>date('Y-m-d'),
                            'clg_ref_id'=>$this->clg->clg_ref_id,
                            'break_type'=>'1');
        // $boi_break_summary = $this->shiftmanager_model->get_break_total_time_user($args_boi_break);
        //$boi_total_time = gmdate("H:i:s", $boi_break_summary[0]->break_total_time);
        //$data['boi_break'] = $boi_total_time; 
        $data['boi_break'] =0;
        
        //die();

        
        $this->output->add_to_position('', 'call_detail', TRUE);
        if($this->clg->clg_group == 'UG-ERO-104'){
            $this->output->add_to_position($this->load->view('frontend/calls/104_dashboard_view', $data, TRUE), 'content', TRUE);

        }else{
            $this->output->add_to_position($this->load->view('frontend/calls/ero_dashboard_view', $data, TRUE), 'content', TRUE);

        }

        if($this->clg->clg_group == 'UG-ERO' || $this->clg->clg_group == 'UG-ERO-102' || $this->clg->clg_group == 'UG-ERO-HD' || $this->clg->clg_group == 'UG-BIKE-ERO'|| $this->clg->clg_group == 'UG-ERO-104'){  
            $this->output->template = "calls";
        } else{
            $this->output->template = "calls_remote";
        }
        }else{
             dashboard_redirect($user_group,$this->base_url );
        }
    }
    public function followupero_dash($generated = false){
        $this->post = $this->input->post();
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');
        $data['default_state'] = $this->default_state; 

        $this->post['base_month'] = get_base_month();
      
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->cdata['pg_rec'];
        $data['call_search'] = ($this->post['call_search']) ? $this->post['call_search'] : $this->cdata['call_search'];
        $args_dash = array();
        if ($this->post['from_date'] != '' || $this->cdata['from_date'] != '') {
            if($args_dash['from_date'] == ''){
                $fm_date=date('Y-m-d', strtotime($this->post['from_date'])) ;
                $args_dash['from_date'] =$this->post['from_date'] ? $fm_date : $this->cdata['from_date'];
            }else{
                 $args_dash['from_date'] = date('Y-m-d', strtotime("-1 days"));
            }
            $data['from_date'] = $args_dash['from_date'];
        }else{
             
             $data['from_date'] = $args_dash['from_date'] = date('Y-m-d', strtotime("-1 days"));
        }
        if ($this->post['to_date'] != '' || $this->cdata['to_date'] != '') {
            if($args_dash['to_date'] == ''){
                $to_date=date('Y-m-d', strtotime($this->post['to_date'])) ;
                $args_dash['to_date'] =($this->post['to_date']) ? $to_date : $this->cdata['to_date'];
            }else{
                $args_dash['to_date'] = date('Y-m-d', strtotime($this->post['to_date']));
            }
            $data['to_date'] = $args_dash['to_date'];
        }else{
             $args_dash['to_date'] = date('Y-m-d');
        }
        
        $data['to_date'] = $args_dash['to_date'];
        $data['from_date'] = $args_dash['from_date'];
        $page_no = 1;
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->cdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->cdata['page_no'];
        }


        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        $args_dash['operator_id'] = $this->clg->clg_ref_id;
        $args_dash['base_month'] = $this->post['base_month'];
            
        
        if ($data['call_search'] != '') {
            $args_dash['call_search'] = $data['call_search'];
        }
        $data['team_type'] = $this->post['team_type']; 
        if($this->post['team_type'] != ''){
            if($this->post['team_type'] == 'UG-ERO' || $this->post['team_type'] == 'UG-BIKE-ERO'){
                $team_type =$args_dash['system_type'] = $data['system_type'] = '108';
            }else if($this->post['team_type'] == 'UG-ERO-102'){
                $team_type =$args_dash['system_type'] = $data['system_type'] = '102';
            }
            else if($this->post['team_type'] == 'UG-ERO-104'){
                $team_type =$args_dash['system_type'] = $data['system_type'] = '104';
            }
             
        }
        $data['user_id'] = $args_dash['operator_id'];
        
        
        $data['ero_clg'] = $this->colleagues_model->get_all_eros(array('team_type' => $data['team_type']));
        
        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        $data['get_count'] = TRUE;
        //var_dump($args_dash);die;
        $inc_info = $this->call_model->get_inc_by_followupero_search($args_dash, $offset, $limit);
        $data['all_purpose_of_calls'] = $this->call_model->get_all_child_purpose_of_calls();
        $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->call_model->get_inc_by_followupero_search($args_dash);
        //$total_cnt = $this->pcr_model->get_inc_by_emt($args_dash,'','',$filter,$sortby,$incomplete_inc_amb);

        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("calls/followupero_dash"),
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

        //$data['total_count'] = $this->amb_model->get_amb_data($data);

        $limit = ($data['pg_rec_amb']) ? $data['pg_rec_amb'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;


        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['AMB'] = $data;

        $this->session->set_userdata('filters', $ambflt);


        /////////////////////////////////////////////////////


        unset($data['get_count']);

        //$data['result'] = $this->amb_model->get_amb_data($data, $offset, $limit);


        //$data['get_data'] = $this->amb_model->get_working_area();

        $data['cur_page'] = $page_no;
        $pgconf_amb = array(
            'url' => base_url("calls/followupero_dash"),
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
        if ($type == 'inc') {
            $this->output->add_to_position($this->load->view('frontend/calls/followupero_dashboard_inc', $data, TRUE), 'calls_inc_list', TRUE);
        } else {
            $this->output->add_to_position($this->load->view('frontend/calls/ero_dashboard_amb', $data, TRUE), 'calls_amb_list', TRUE);
        }
        
        $this->output->template = "calls";
        
    }
    public function ero_dash($generated = false) {
        
        $this->post = $this->input->post();
        //var_dump($this->post);die;
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');
        $data['default_state'] = $this->default_state; 

        $this->post['base_month'] = get_base_month();
      //  var_dump($this->session->userdata('filters'));
      $data['all_purpose_of_104_calls'] = $this->call_model->get_all_child_purpose_of_104_calls();


        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->cdata['pg_rec'];
        $data['call_search'] = ($this->post['call_search']) ? $this->post['call_search'] : $this->cdata['call_search'];
        $data['call_purpose'] = ($this->post['call_purpose']) ? $this->post['call_purpose'] : $this->cdata['call_purpose'];
        $data['incident_status'] = ($this->post['incident_status']) ? $this->post['incident_status'] : $this->cdata['incident_status'];
        $data['ero_id'] = ($this->post['ero_id']) ? $this->post['ero_id'] : $this->post['user_id'];
        //var_dump($data['ero_id']); die;
        $args_dash = array();

        if ($this->post['from_date'] != '' || $this->cdata['from_date'] != '') {
             
            if($args_dash['from_date'] == ''){
                $fm_date=date('Y-m-d', strtotime($this->post['from_date'])) ;
                //var_dump($fm_date);die;
                $args_dash['from_date'] =$this->post['from_date'] ? $fm_date : $this->cdata['from_date'];
                
            }else{
                 $args_dash['from_date'] = date('Y-m-d', strtotime("-1 days"));
            }
            //$args_dash['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : $this->cdata['from_date'];
            
            
            $data['from_date'] = $args_dash['from_date'];
        }else{
             
             $data['from_date'] = $args_dash['from_date'] = date('Y-m-d', strtotime("-1 days"));
        }
        
        


        if ($this->post['to_date'] != '' || $this->cdata['to_date'] != '') {
            //$args_dash['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) :$this->cdata['to_date'];
            if($args_dash['to_date'] == ''){
               // $args_dash['to_date'] =$this->cdata['to_date'];
               $to_date=date('Y-m-d', strtotime($this->post['to_date'])) ;

                 $args_dash['to_date'] =($this->post['to_date']) ? $to_date : $this->cdata['to_date'];

            }else{
                 $args_dash['to_date'] = date('Y-m-d', strtotime($this->post['to_date']));
            }
            $data['to_date'] = $args_dash['to_date'];
        }else{
             $args_dash['to_date'] = date('Y-m-d');
        }
        
        $data['to_date'] = $args_dash['to_date'];
        $data['from_date'] = $args_dash['from_date'];
        
        
       
        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->cdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->cdata['page_no'];
        }


        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;



         if($this->clg->clg_group == 'UG-EROSupervisor'){           
            
            $args['clg_senior'] = $this->clg->clg_ref_id;
            $data['clg_senior'] = $this->clg->clg_ref_id;
            
            
            $clg_args = array('clg_senior'=>$this->clg->clg_ref_id,'clg_group'=>'UG-ERO');
           
            $data['ero_clg'] = $this->colleagues_model->get_clg_data($clg_args);
            
            foreach($data['ero_clg'] as $ero){
                $child_ero[] = $ero->clg_ref_id;
            }

            if(is_array($child_ero)){
                $child_ero = implode("','", $child_ero);
            }
            
            
            if ( $this->post['user_id']  != '') {
                $args_dash['operator_id'] = $this->post['user_id'];
            }else{
              //  $args_dash['child_ero'] = $child_ero;
            }
             $args_dash['base_month'] = $this->post['base_month'];
            
        } else {
            
                $args_dash['operator_id'] = $this->clg->clg_ref_id;
                $args_dash['base_month'] = $this->post['base_month'];
            
        }
        if ($data['call_search'] != '') {
            $args_dash['call_search'] = $data['call_search'];
        }
        if ($data['call_purpose'] != '') {
            $args_dash['call_purpose'] = $data['call_purpose'];
        }
        if ($this->post['call_status'] != '') {
            $args_dash['call_status'] = $this->post['call_status'];
        }
        if ($data['incident_status'] != '') {
            $args_dash['incident_status'] = $data['incident_status'];
        }
        $args_dash['district_id'] = $this->post['district_id'];
        
        $data['team_type'] = $this->post['team_type']; 
        if($this->post['team_type'] != ''){
            if($this->post['team_type'] == 'UG-ERO' || $this->post['team_type'] == 'UG-BIKE-ERO'){
                $team_type =$args_dash['system_type'] = $data['system_type'] = '108';
            }else if($this->post['team_type'] == 'UG-ERO-102'){
                $team_type =$args_dash['system_type'] = $data['system_type'] = '102';
            }else if($this->post['team_type'] == 'UG-ERO-104'){
                $team_type =$args_dash['system_type'] = $data['system_type'] = '104';
            }

             
        }
        $data['user_id'] = $args_dash['operator_id'];
        
        
//        if($args_dash['call_purpose'] == 'all' || $data['call_search'] != '' && ($this->post['from_date'] == "" && $this->post['to_date'] == "")){
//            $args_dash['from_date'] = '';
//            $args_dash['to_date'] = '';
//        }
        
        $args_dash['pcr_status'] = '0,1';
        //$args_dash['incis_deleted'] = '0,2';
        
        $data['ero_clg'] = $this->colleagues_model->get_all_eros(array('team_type' => $data['team_type']));
        
        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        $data['get_count'] = TRUE;
       
        $inc_info = $this->call_model->get_inc_by_ero($args_dash, $offset, $limit);
        $data['all_purpose_of_calls'] = $this->call_model->get_all_child_purpose_of_calls();
        $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->call_model->get_inc_by_ero($args_dash);
        //$total_cnt = $this->pcr_model->get_inc_by_emt($args_dash,'','',$filter,$sortby,$incomplete_inc_amb);

        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("calls/ero_dash"),
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

        //$data['total_count'] = $this->amb_model->get_amb_data($data);

        $limit = ($data['pg_rec_amb']) ? $data['pg_rec_amb'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;


        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['AMB'] = $data;

        $this->session->set_userdata('filters', $ambflt);


        /////////////////////////////////////////////////////


        unset($data['get_count']);

        //$data['result'] = $this->amb_model->get_amb_data($data, $offset, $limit);


        //$data['get_data'] = $this->amb_model->get_working_area();

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

        $config = get_pagination($pgconf_amb);
        $data['amb_pagination'] = get_pagination($pgconf_amb);
        $type = $this->post['type'];

        // $this->output->add_to_position($this->load->view('frontend/calls/ero_dashboard_view', $data, TRUE), 'content', TRUE);

        if ($type == 'inc') {

        if($this->clg->clg_group ==  'UG-ERO-104'){
            $this->output->add_to_position($this->load->view('frontend/calls/104_dashboard_view', $data, TRUE), 'calls_inc_list', TRUE);
        }else{
            $this->output->add_to_position($this->load->view('frontend/calls/ero_dashboard_inc', $data, TRUE), 'calls_inc_list', TRUE);
        }
        } else {
            $this->output->add_to_position($this->load->view('frontend/calls/ero_dashboard_amb', $data, TRUE), 'calls_amb_list', TRUE);
        }
        if($this->clg->clg_group == 'UG-ERO' ){  
            $this->output->template = "calls";
        }
    }

    public function atnd_cls() {
          
        $this->output->template = "calls";
        $this->session->set_userdata('dispatch_time', '');
        $this->session->unset_userdata('cl_purpose');
        $this->session->unset_userdata('inc_ref_id');
        $this->session->unset_userdata('CallUniqueID');
        $this->session->unset_userdata('patient');
        $this->session->unset_userdata('call_id');
        $this->session->unset_userdata('mic_details');
        $this->session->unset_userdata('call_type');
        $this->session->unset_userdata('inc_datetime');
        $this->session->unset_userdata('inc_post_details');
        $this->session->unset_userdata('attend_call_time');
        $this->session->unset_userdata('incoming_call_ip_phone','no');
        $this->session->unset_userdata('inter');
        $this->session->unset_userdata('app_call_details');
        $this->session->unset_userdata('denial_id');
        $this->session->unset_userdata('hospital');
        $this->session->unset_userdata('new_hospital');
        $this->session->unset_userdata('set_lbs_mobile_number');
        $this->session->unset_userdata('sessionid');
        $this->session->unset_userdata('crtObjectId');
        $this->session->unset_userdata('userCrtObjectId');
        
        $ext_no = get_cookie("avaya_extension_no");
        $agent_id=$this->clg->clg_avaya_agentid;  
        $sessionid =  $this->input->post('sessionid');
        
        if ($sessionid != '') {
           $this->session->set_userdata('sessionid', $sessionid);
        }
        $crtObjectId =  $this->input->post('crtObjectId');
        if ($crtObjectId != '') {
           $this->session->set_userdata('crtObjectId', $crtObjectId);
        }
        
        $userCrtObjectId =  $this->input->post('userCrtObjectId'); 
        if ($userCrtObjectId != '') {
           $this->session->set_userdata('userCrtObjectId', $userCrtObjectId);
        }

        $callType =  $this->input->post('callType'); 
        if ($callType != '') {
           $this->session->set_userdata('callType', $callType);
        }        
        
    
        
        $ser_args = array('ext_no'=>$ext_no);
        $service_data = $this->call_model->get_all_avaya_extension_new($ser_args);
        $service_type = $service_data[0]->type;     
        $datetime = date('Y-m-d H:i:s');
        $data['attend_call_time'] = date('Y-m-d H:i:s');
        $this->session->set_userdata('attend_call_time', $datetime);
        $unset_dispatch_time = $this->session->userdata('dispatch_time');
        if (empty($unset_dispatch_time)) {
            $this->session->set_userdata('dispatch_time', time());
        }
        //$this->output->add_to_position('&nbsp;', 'content', TRUE);

        $clg_group = $this->clg->clg_group;
        $data['clg_group'] = $clg_group;
        $thirdparty = $this->clg->thirdparty;
        if($clg_group == 'UG-ERO'  || $clg_group == 'UG-BIKE-ERO' || $clg_group == 'UG-ERCTRAINING' || $clg_group == 'UG-FOLLOWUPERO'){
           $clg_user_type = '108'; 
        }else if($clg_group == 'UG-ERO-102'){
            $clg_user_type = '102'; 
        }else if($clg_group == 'UG-ERO-HD'){
            $clg_user_type = 'hd'; 
        }else if($clg_group == 'UG-REMOTE')
        {
            $clg_user_type = 'Remote';  
        }else if($clg_group == 'UG-ERO-104')
        {
            $clg_user_type = '104';     
        }else{
            $clg_user_type = '102,108';
        }
        if($clg_user_type == 'hd'){
            $this->output->add_to_position('&nbsp;', 'content', TRUE);
        }


        //    var_dump($clg_user_type);die();
       // if($thirdparty == 3 || $thirdparty == 4){
           
            $this->output->add_to_position('&nbsp;', 'content', TRUE);
       // }
        $data['clg_user_type']=$clg_user_type;
        
        
        $parent_args = array('p_systen'=>$clg_user_type);
        
        $data['purpose_of_calls'] = $this->call_model->get_parent_purpose_of_calls($parent_args);
        //var_dump($data['purpose_of_calls']);die();
        $data['blood_gp'] = $this->call_model->get_bloodgp();
               
        $data['m_no'] = $this->input->post('m_no');
        $this->session->set_userdata('cti_mobile_number',$data['m_no']);

        $data['inc_ref_no'] = $this->input->get('inc_ref_no');

        if (!empty($data['m_no'])) {
            $data['caller_details'] = $this->call_model->get_caller_details($data['m_no']);
        }
      
//        if($data['inc_ref_no'] != ""){
//            
//            if(_is_in_dispatch_process($data['inc_ref_no'])){
//
//            $this->output->message = "<h3>MCI Call</h3><br><p>Incident Call Inprocess.</p><script>start_incoming_call();  window.location.reload(true);</script>";
//
//            return;
//            }
//        }


        if ($data['m_no']) {
            $data['emt_details'] = $this->call_model->get_emt_user_details($data['m_no']);
        }

        if ($this->agent->is_mobile()) {
            $data['agent_mobile'] = 'yes';
        } else {
            $data['agent_mobile'] = 'no';
        }
        
        if ($clg_user_type == '108' || $clg_user_type == 'Remote') {
            $parent_purpose = "EMG";
            // $purpose_child_name="NON_MCI"; 
        } else if ($clg_user_type == '102') {
            $parent_purpose = "DROP_BACK_CALL";
        }else if ($clg_user_type == 'hd') {
            $parent_purpose = "CORONA_CALLS";
        }else if ($clg_user_type == '104') {
           // $parent_purpose = "104";
            $parent_purpose="HELP_EME_INFO";
            // $parent_purpose="HELP_EME_COMP";  

        }
        
        
      
        $data['CallUniqueID'] = $CallUniqueID = $this->input->post('CallUniqueID');
     
        
        $comu_args = array('mobile_no'=>$data['m_no'],'call_status'=>'Call Dial');
      
        $data['app_call_details'] = $this->call_model->get_comu_app_call_details($comu_args);
       // var_dump(  $data['app_call_details'] );
       // die();

        $data['services'] = $this->common_model->get_services();
        $data['questions'] = $this->call_model->get_active_questions($booking_data[0]->user_req_chiefcomplaint);
                
        if(!empty($data['app_call_details'])){
            $this->session->set_userdata('app_call_details',$data['app_call_details']);

            $com_args = array('calld_id'=>$data['app_call_details'][0]->calld_id,'call_status'=>'Received');
            $update_app_call_details = $this->call_model->update_app_call_details($com_args);
            
            $app_call_details = $this->call_model->get_comu_app_reg_details(array('mobile_no'=>$data['m_no']));
             
            $data['caller_details'] = (object)array('clr_fname'=>$app_call_details[0]->f_name,
                'clr_lname'=>$app_call_details[0]->l_name,);
           
            
        }
        //var_dump($app_call_details);
//          if(empty($data['app_call_details'])){
//           
//             
//           if(trim($data['m_no']) != ''){
//            $timestamp_lbs = time();
//            $this->output->add_to_position('Waiting for LBS location...', 'procesing_lbs', TRUE); 
//          
//            $lbs_data = get_lbs_data($data['m_no'],$timestamp_lbs);
//
//            $this->session->set_userdata('set_lbs_mobile_number',$data['m_no']);
//         
//            $xml = simplexml_load_string($lbs_data['resp'], "SimpleXMLElement", LIBXML_NOCDATA);
//            $json = json_decode(json_encode($xml), true);
//                    
//             $lbs_args_res = array('lbs_timestamp'=>$timestamp_lbs,'lbs_res_datetime'=>date('Y-m-d H:i:s'),'lbs_responce'=>addslashes($lbs_data['resp']));
//            $this->call_model->update_lbs_data($lbs_args_res); 
//            $this->output->add_to_position('', 'procesing_lbs', TRUE);  
//          
//           
//            if($json["Response"]["longitude"] == '0' && $json["Response"]["latitude"] == '0'){
//                 
//                $this->output->add_to_position('No LBS Data Found...', 'procesing_lbs', TRUE);
//            }
//            if(empty($json["Response"]["longitude"])){
//               
//                $this->output->add_to_position('No LBS Data Found...', 'procesing_lbs', TRUE);
//            }
//
//            if(!empty($json["Response"]["latitude"]) && !empty($json["Response"]["latitude"])){
//                
//                $lat =$json["Response"]["latitude"];
//                $lng =$json["Response"]["longitude"];
//
//                $data['app_call_details'][0] =(object)array('lat'=>$lat,'lng'=>$lng);
//                  $this->output->add_to_position('<b style="color:#009515;">LBS Data Found...</b>', 'procesing_lbs', TRUE);
//                
//            }
//            $this->session->set_userdata('app_call_details',$data['app_call_details']);
//           }
//         
//            
//        }   
                $booking_args = array('mobile_no'=>$data['m_no']);
                $booking_data = $this->call_model->get_booking_details($booking_args);  
         
                
                if(!empty($booking_data)){
                    $data['inc_details'] = array('chief_complete'=>$booking_data[0]->ct_type,
                        'chief_complete_id'=>$booking_data[0]->user_req_chiefcomplaint,
                        'destination_hp_name'=>$booking_data[0]->hp_name,
                        'destination_hospital_id'=>$booking_data[0]->user_req_hospid,
                        'user_req_id'=>$booking_data[0]->user_req_id);
                    
                    $data['app_call_details'][0] =(object)array('lat'=>$booking_data[0]->user_req_userlat,'lng'=>$booking_data[0]->user_req_userlng);
                    
                   
                    $data['services'] = $this->common_model->get_services();
                    $data['questions'] = $this->call_model->get_active_questions($booking_data[0]->user_req_chiefcomplaint);
                
                   
                }
     
		if($data['CallUniqueID'] == '' && $CallUniqueID == ''){
            $data['CallUniqueID'] = $CallUniqueID = 'direct_atnd_call';
           
        }else{
           
            $inc_data = $this->inc_model->get_incident_by_avayaid(array('inc_avaya_uniqueid'=>$CallUniqueID));
        
           
            
        }

		$this->session->set_userdata('CallUniqueID',$CallUniqueID);
       
        
        
        $pur_args=array('p_parent'=>$parent_purpose,'p_systen'=>$clg_user_type);
        // var_dump($pur_args);die();
        
        $data['child_purpose_of_calls'] = $this->call_model->get_purpose_of_calls($pur_args);
        // var_dump($data['child_purpose_of_calls']);die();
        $clg_break_time = date('Y-m-d H:i:s'); 
        $update_call_args = array(
        'status' => 'atnd',
        'brk_time'=>$clg_break_time
    
    );
        $update_call_res = $this->call_model->update_ero_user_status($update_call_args, $this->clg->clg_ref_id);
        
        //$cm_id='60';
        
        if ($data['inc_ref_no'] != '')   {

           
            $call_history_id = $this->input->get('id');
            $this->session->set_userdata('call_history_id', $call_history_id);
            $current_user = $this->clg->clg_ref_id;
            
            $args = array();
            $args = array('inc_ref_id' => $data['inc_ref_no']);
            $this->session->set_userdata('inc_ref_id', $data['inc_ref_no']);


            $inc_data = $this->inc_model->get_inc_details_ref_id($args);
            $data['call_id'] = $inc_data[0]->cl_id;
           

           // $data['inc_bvg_ref_number'] = $inc_data[0]->inc_bvg_ref_number;
            $caller_details = new ArrayObject();
            $caller_details->clr_fname = $inc_data[0]->clr_fname;
            $caller_details->clr_mname = $inc_data[0]->clr_mname;
            $caller_details->clr_lname = $inc_data[0]->clr_lname;
            $caller_details->clr_mobile = $inc_data[0]->clr_mobile;
            $caller_details->clr_fullname = $inc_data[0]->clr_fullname;
            $caller_details->clr_ext_no = $inc_data[0]->clr_ext_no;

            $data['m_no'] = $inc_data[0]->clr_mobile;

            $data['caller_details'] = $caller_details;

            $data_caller_details = array('clr_fname' => $inc_data[0]->clr_fname,
                'clr_mname' => $inc_data[0]->clr_mname,
                'clr_lname' => $inc_data[0]->clr_lname,
                'clr_mobile' => $inc_data[0]->clr_mobile,
                'clr_fullname' => $inc_data[0]->clr_fullname,
                'clr_ext_no' => $inc_data[0]->clr_ext_no,
                'inc_bvg_ref_number' => $inc_data[0]->inc_bvg_ref_number
            );

            $this->session->set_userdata('caller_details', $data_caller_details);


            $caller_details_data = array('clr_fname' => $inc_data[0]->ptn_fname,
                'clr_mname' => $inc_data[0]->ptn_mname,
                'clr_lname' => $inc_data[0]->ptn_lname,
                'clr_full_name' => $inc_data[0]->ptn_fullname,
                'patient_gender' => $inc_data[0]->ptn_gender,
                'ptn_dob' => $inc_data[0]->ptn_birth_date,
                'age_type'=>$inc_data[0]->ptn_age_type,
                'patient_age' => $inc_data[0]->ptn_age);
            
            $data['caller_details_data'] = $caller_details_data;
           
            
            $common_data_form = array(
                'full_name' => $inc_data[0]->ptn_fname.' '.$inc_data[0]->ptn_lname,
                'first_name'=> $inc_data[0]->ptn_fname,
                'middle_name'=> $inc_data[0]->ptn_mname,
                'last_name'=> $inc_data[0]->ptn_lname,
                'dob'=> $inc_data[0]->ptn_birth_date,
                'age'=> $inc_data[0]->ptn_age,
                'age_type'=>$inc_data[0]->ptn_age_type,
                'gender'=> $inc_data[0]->ptn_gender );
            
            $data['common_data_form'] = $common_data_form;

            $data['m_no'] = $inc_data[0]->clr_mobile;
            //$data['cl_purpose'] = 'NON_MCI';
            $data['cl_purpose'] = $inc_data[0]->inc_type;

            $data['cl_relation'] = $inc_data[0]->cl_relation;


            $data['int_count'] = $inc_data[0]->inc_patient_cnt;


            $cm_id = $inc_data[0]->inc_complaint;
            $data['services'] = $this->common_model->get_services();

            $chief_comp = $this->inc_model->get_chief_comp_service($cm_id);
                       
            if ($inc_data[0]->inc_district_id != '') {
                $geo_fence_data = $this->inc_model->get_geo_fence_radius($inc_data[0]->inc_district_id);
                $data['geo_fence'] = $geo_fence_data[0]->geo_fence_radius;
            } else {
                $data['geo_fence'] = 5;
            }
         

            $inc_details = new ArrayObject();
            $inc_details = array(
                'inc_ref_id' => $data['inc_ref_no'],
                'chief_complete_id' => $cm_id,
                'chief_complete' => $chief_comp[0]->ct_type,
                'state_id' => $inc_data[0]->inc_state_id,
                'inc_datetime' => $datetime,
                'district_id' => $inc_data[0]->inc_district_id,
                'tahsil_id' => $inc_data[0]->inc_tahshil_id,
                'inc_city_id' => $inc_data[0]->inc_city_id,
                'inc_city' => $inc_data[0]->inc_city_id,
                'h_no' => $inc_data[0]->inc_h_no,
                'pincode' => $inc_data[0]->inc_pincode,
                'lane' => $inc_data[0]->inc_lane,
                'landmark' => $inc_data[0]->inc_landmark,
                'area' => $inc_data[0]->inc_area,
                'inc_city' => $inc_data[0]->inc_city,
                'inc_ero_standard_summary' => $inc_data[0]->inc_ero_standard_summary,
                'inc_back_home_address' => $inc_data[0]->inc_back_home_address,
                'inc_back_district' => $inc_data[0]->inc_back_district,
                'inc_back_hospital' => $inc_data[0]->inc_back_hospital,
                'inc_ero_summary' => $inc_data[0]->inc_ero_summary,
                'lng' => $inc_data[0]->inc_long,
                'lat' => $inc_data[0]->inc_lat,
                'inc_address' => $inc_data[0]->inc_address,
                'inc_service' => $inc_data[0]->inc_address,
                'inc_datetime' => $datetime,
                'destination_hospital_id'=> $inc_data[0]->destination_hospital_id
            );
            
            if( $inc_data[0]->destination_hospital_id != ''){
				$hp_remark = array('hp_id' =>$inc_data[0]->destination_hospital_id);
				$hospital_data = $this->hp_model->get_hp_data1($hp_remark);
              
                $inc_details['destination_hp_name'] = $hospital_data[0]->hp_name;
            }
           
            
            if( $inc_data[0]->inc_ero_standard_summary != ''){
				$args_remark = array('re_id' => $data['inc_details'][0]->inc_ero_standard_summary);
				$standard_remark = $this->call_model->get_ero_summary_remark($args_remark);

				$inc_details['re_name'] = $standard_remark[0]->re_name;
			}
           
            if( $inc_data[0]->inc_back_hospital != ''){
				$hp_remark = array('hp_id' =>$inc_data[0]->inc_back_hospital);
				$hp_data = $this->hp_model->get_hp_data($hp_remark);
				$inc_details['hp_name'] = $hp_data[0]->hp_name;
                $dis_args = array('dst_code'=>$inc_details['inc_back_district']);
                $dist_data = $this->inc_model->get_district_name($dis_args);
                
                $inc_details['inc_back_district_name']=$dist_data[0]->dst_name;
			}

            
            if( $inc_data[0]->inc_back_home_address != ''){
				$home_remark = array('inc_ref_id' => $data['inc_details'][0]->inc_ref_id);
				$home_data = $this->inc_model->get_dropback($home_remark);
                $data['home_data']=$data['ptn'] = $home_data;

			}



            _ucd_atnd_call($data['inc_ref_no'], $this->clg->clg_ref_id, $call_history_id);

            $data['inc_details'] = $inc_details;
            //$data['amb_type'] = '1';

            $data['chief_comps_services'] = $this->inc_model->get_chief_comp_service($cm_id);
            $data['cmp_service'] = $this->common_model->get_services();
           // $data['questions'] = $this->call_model->get_questions($cm_id);
            $data['questions_ans'] = $this->inc_model->get_inc_summary($args);
          
            
             $data['questions'] =  $this->call_model->get_active_questions($cm_id);
            
            $parent_purpose = "EMG";
            $pur_args=array('p_parent'=>$parent_purpose);
            $data['child_purpose_of_calls'] = $this->call_model->get_purpose_of_calls($pur_args);

            $this->output->closepopup = 'yes';
            $this->output->status = 1;
            
            $comu_args = array('mobile_no'=>$data['m_no'],'call_status'=>'Call Dial');
            $data['app_call_details'] = $this->call_model->get_comu_app_call_details($comu_args);
           
            if(!empty($data['app_call_details'])){
            $this->session->set_userdata('app_call_details',$data['app_call_details']);

            $com_args = array('calld_id'=>$data['app_call_details'][0]->calld_id,'call_status'=>'Received');
            $update_app_call_details = $this->call_model->update_app_call_details($com_args);
            }
            // var_dump($data['cl_purpose']);die();
            if($data['cl_purpose'] == 'NON_MCI_WITHOUT_AMB'){
                  $data['cl_purpose'] = 'NON_MCI';
            }
      
                    $args_type = array();
        if($clg_group == 'UG-BIKE-ERO'){
            $args_type = array('ambty_id'=>"'1'");
        }
       
        if($clg_group == 'UG-ERO' &&  $this->clg->thirdparty == '1'){
             $args_type = array('ambty_id'=>"'2','3','4'");
        }
        if($clg_group == 'UG-REMOTE' || $clg_group == 'UG-Remote-ShiftManager'){
            $args_type = array('ambty_id'=>"'2','16'");
       }
       $data['amb_type_list'] = $this->amb_model->get_amb_type($args_type);
       if ($cm_id == 52 || $cm_id == 59 ) {
            //$data['ambu_type_data'] = array(3, 4);
        
            $thirdparty = $this->clg->thirdparty;
            if ($thirdparty != 1) {
                $data['ambu_type_data'] = array(2);
            }else{
                $data['ambu_type_data'] = array(3, 4);
            }
        }
            $this->output->add_to_position($this->load->view('frontend/calls/caller_details_view', $data, TRUE), 'call_detail', TRUE);
           
            if($data['cl_purpose'] == 'NON_MCI'){
            $this->output->add_to_position($this->load->view('frontend/inc/non_mci_view', $data, TRUE), 'content', TRUE);
            $this->output->add_to_position($this->load->view('frontend/inc/non_mci_patient_gender_view', $data, TRUE), 'non_mci_patient_gender', TRUE);
            $this->output->add_to_position($this->load->view('frontend/inc/service_view', $data, TRUE), 'inc_services_details', TRUE);
            }else if($data['cl_purpose'] == 'MCI'){
                $this->output->add_to_position($this->load->view('frontend/inc/mci_view', $data, TRUE), 'content', TRUE);

            $this->output->add_to_position($this->load->view('frontend/inc/non_mci_patient_gender_view', $data, TRUE), 'non_mci_patient_gender', TRUE);
            $this->output->add_to_position($this->load->view('frontend/inc/service_view', $data, TRUE), 'inc_services_details', TRUE);
            
            }else if($data['cl_purpose'] == 'NON_MCI_WITHOUT_AMB'){
                 $data['cl_purpose'] = 'NON_MCI';
              
                //$this->output->add_to_position($this->load->view('frontend/inc/non_mci_without_amb_view', $data, TRUE), 'content', TRUE);
                  $this->output->add_to_position($this->load->view('frontend/inc/non_mci_view', $data, TRUE), 'content', TRUE);
                $this->output->add_to_position($this->load->view('frontend/inc/non_mci_patient_gender_view', $data, TRUE), 'non_mci_patient_gender', TRUE);
                $this->output->add_to_position($this->load->view('frontend/inc/service_view', $data, TRUE), 'inc_services_details', TRUE);
            }else if($data['cl_purpose'] == 'DROP_BACK'){

                $this->output->add_to_position($this->load->view('frontend/inc/drop_back_call_view', $data, TRUE), 'content', TRUE);
                $this->output->add_to_position($this->load->view('frontend/inc/non_mci_patient_gender_view', $data, TRUE), 'non_mci_patient_gender', TRUE);
                $this->output->add_to_position($this->load->view('frontend/inc/service_view', $data, TRUE), 'inc_services_details', TRUE);

           
            }else if($data['cl_purpose'] == 'PREGANCY_CALL'){
                       
                $this->output->add_to_position($this->load->view('frontend/inc/pregancy_call_view', $data, TRUE), 'content', TRUE);
                $this->output->add_to_position($this->load->view('frontend/inc/non_mci_patient_gender_view', $data, TRUE), 'non_mci_patient_gender', TRUE);
                $this->output->add_to_position($this->load->view('frontend/inc/service_view', $data, TRUE), 'inc_services_details', TRUE);
              
            }else if($data['cl_purpose'] == 'Child_CARE_CALL'){
                       
                $this->output->add_to_position($this->load->view('frontend/inc/child_care_call_view', $data, TRUE), 'content', TRUE);
                $this->output->add_to_position($this->load->view('frontend/inc/non_mci_patient_gender_view', $data, TRUE), 'non_mci_patient_gender', TRUE);
                $this->output->add_to_position($this->load->view('frontend/inc/service_view', $data, TRUE), 'inc_services_details', TRUE);
              
            }
              $this->output->add_to_position("<script>$('#get_ambu_details').click(); init_autocomplete();</script>", 'custom_script', true);
            
      
       // var_dump($data['ambu_type_data']);
       //  var_dump($data['amb_type_list']);
        
             $this->output->add_to_position($this->load->view('frontend/inc/inc_recomended_ambu_view', $data, TRUE), 'inc_recomended_ambu', TRUE);
               
           
            $this->output->template = "calls";
        }else if (!empty($data['emt_details'])) {

            $this->output->closepopup = 'yes';
            $this->output->status = 1;
           
            //$this->output->add_to_position($this->load->view('frontend/calls/emt_caller_details_view', $data, TRUE), 'call_detail', TRUE);
             $this->output->add_to_position($this->load->view('frontend/calls/caller_details_view', $data, TRUE), 'call_detail', TRUE);
            $this->output->add_to_position($this->load->view('frontend/inc/non_mci_view', $data, TRUE), 'content', TRUE);
            $this->output->add_to_position($this->load->view('frontend/inc/non_mci_patient_gender_view', $data, TRUE), 'non_mci_patient_gender', TRUE);
            $this->output->add_to_position($this->load->view('frontend/inc/service_view', $data, TRUE), 'inc_services_details', TRUE);
            $this->output->template = "calls";
            
        } else if (($this->input->post('ext_no') !== NULL) && $this->input->post('ext_no') !== '') {

            $data['m_no'] = $this->input->post('m_no');
            $data['ext_no'] = $this->input->post('ext_no');     
            
            //call receiving 
            
             $ext_no = get_cookie("avaya_extension_no");
           // die();
            $agent_id=$this->clg->clg_avaya_agentid;
            
            $args_call = array('CallUniqueID' => $CallUniqueID);
            $avaya_call = $this->call_model->get_avaya_call_by_ext($args_call);
            
             

            //if($avaya_call->status == 'R'){
            
                 $ser_args = array('ext_no'=>$data['ext_no']);
            
                $service_data = $this->call_model->get_all_avaya_extension_new($ser_args);
                 $service_type = $service_data[0]->type;
                

                $this->session->set_userdata('incoming_call_ip_phone','yes');
                
            //}
        
            $data['chief_comps_services'] = $this->inc_model->get_chief_comp_service($cm_id);
            $data['cmp_service'] = $this->common_model->get_services();
           
            $data['questions'] = $this->call_model->get_questions($cm_id);

            $caller_data = array('clr_mobile' => $data['m_no'],
                'clr_ext_no' => $data['ext_no']);
            
            
             $data['caller_details'] = $this->call_model->get_caller_details(ltrim($data['m_no'], '0'));
   
           if(empty($data['caller_details'])){
                $data['caller_details'] = (object)array();
                
                if(!empty($data['app_call_details'])){

            
                    $app_call_details = $this->call_model->get_comu_app_reg_details(array('mobile_no'=>$data['m_no']));
                    $data['caller_details'] = (object)array('clr_fname'=>$app_call_details[0]->f_name,
                        'clr_lname'=>$app_call_details[0]->l_name,
                        );
                    
                    $caller_data['clr_fname'] = $app_call_details[0]->f_name;
                    $caller_data['clr_lname'] = $app_call_details[0]->l_name;


                }
			   
                $data['caller_id'] = $this->call_model->insert_caller_details($caller_data);
               
				if(!empty($data['caller_id'])){
					$data['caller_details']->clr_id = $data['caller_id'];
				}
           }
           
  
            if($data['caller_details']->clr_id == ''){
                $call_data = array('cl_base_month' => $this->post['base_month'],
                    'cl_clr_id' => $data['caller_details']->clr_id);

                $data['call_id'] = $this->call_model->insert_call_details($call_data);
            }

            $data['caller_details']->cl_id = $data['call_id'];

            $this->output->closepopup = 'yes';
            $this->output->status = 1;

            $this->output->add_to_position('', 'dialerscreen', TRUE);
            $this->output->add_to_position($this->load->view('frontend/calls/caller_details_view', $data, TRUE), 'call_detail', TRUE);
            if($clg_user_type == '108'){

                $this->output->add_to_position($this->load->view('frontend/inc/non_mci_view', $data, TRUE), 'content', TRUE);
               // $this->output->add_to_position($this->load->view('frontend/inc/non_mci_patient_gender_view', $data, TRUE), 'non_mci_patient_gender', TRUE);
                $this->output->add_to_position($this->load->view('frontend/inc/service_view', $data, TRUE), 'inc_services_details', TRUE);
                
            }else if($clg_user_type == 'hd'){
                $cm_id='60';
                $data['advice'] = $this->call_model->get_advice();
                $data['questions'] = $this->call_model->get_questions($cm_id);
               // var_dump($data['questions']);die();
                  $this->output->add_to_position($this->load->view('frontend/corona/corona_call_view', $data, TRUE), 'content', TRUE);
            }else if($clg_user_type == '104'){
                $cm_id='60';
                $data['advice'] = $this->call_model->get_advice();
                $data['questions'] = $this->call_model->get_questions($cm_id);
               // var_dump($data['questions']);die();
                  $this->output->add_to_position('', 'content', TRUE);
            }else{
                
                $this->output->add_to_position($this->load->view('frontend/inc/drop_back_call_view', $data, TRUE), 'content', TRUE);
                //$this->output->add_to_position($this->load->view('frontend/inc/non_mci_patient_gender_view', $data, TRUE), 'non_mci_patient_gender', TRUE);
                $this->output->add_to_position($this->load->view('frontend/inc/service_view', $data, TRUE), 'inc_services_details', TRUE);
                
            }
        }else {
        
            //$this->output->closepopup = 'yes';
            //$this->output->status = 1;
           

            $this->output->add_to_position($this->load->view('frontend/calls/caller_details_view', $data, TRUE), 'call_detail', TRUE);
           
             if($clg_user_type == '102'){
              $this->output->add_to_position($this->load->view('frontend/inc/drop_back_call_view', $data, TRUE), 'content', TRUE);
            }
            else if($clg_user_type == '104'){
                $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_blank_view', $data, TRUE), 'content', TRUE);
              }else if($clg_user_type == 'hd'){
                 $cm_id='60';
                $data['advice'] = $this->call_model->get_advice();
                $data['questions'] = $this->call_model->get_questions($cm_id);
                //var_dump($data['questions']);die();
                 $this->output->add_to_position($this->load->view('frontend/corona/corona_call_view', $data, TRUE), 'content', TRUE);
            }else{
                 $this->output->add_to_position($this->load->view('frontend/inc/non_mci_view', $data,TRUE),'content',TRUE);
            }
            $this->output->template = "calls";
            
        }

        
        // $data['questions'] = $this->call_model->get_questions('inter');
        //$this->output->add_to_position($this->load->view('frontend/inc/mci_view', $data,TRUE),'call_purpose_form',TRUE);
    }

    Public function save_call_details() {
        
        $this->session->unset_userdata('inc_ref_id');

        $form_call_data = $this->input->post('caller', TRUE);
        
        $atend_user = $this->session->userdata('current_user');
        $mobile = $form_call_data['cl_mobile_number'];
        $common_data_form = array(); 
        $common_data_form = $this->input->post('patient', TRUE);

        $data['cl_purpose'] = $this->input->post('caller[cl_purpose]', TRUE);
        $data['parent_purpose'] = $this->input->post('caller[parent_purpose]', TRUE);
        $data['CallUniqueID'] = $CallUniqueID = $this->session->userdata('CallUniqueID');
        $data['common_data_form'] = $common_data_form;
        $data['pt_gender'] = $patient_gender = $common_data_form['gender'];
        // print_r($data['cl_purpose']);die;

        $data['CallUniqueID'] = $CallUniqueID = $this->session->userdata('CallUniqueID');
        $data['common_data_form'] = $common_data_form;
        $data['pt_gender'] = $patient_gender = $common_data_form['gender'];
        $this->session->set_userdata('patient_info', $common_data_form);
        

        $comp_args=array('cmp_type'=>'2');
      
        $data['get_cmp_type'] = $this->call_model->get_help_complaints_types($comp_args);
        
        $comp_args=array('cmp_type'=>'3');
        $data['get_food_cmp_type'] = $this->call_model->get_help_complaints_types($comp_args);
        
        $comp_args=array('cmp_type'=>'1');
        $data['get_hosp_cmp_type'] = $this->call_model->get_help_complaints_types($comp_args);
        
        $comp_args=array('cmp_type'=>'4');
        $data['get_other_cmp_type'] = $this->call_model->get_help_complaints_types($comp_args);
        
        $comu_args = array('mobile_no'=>$form_call_data['cl_mobile_number'],'call_status'=>'Call Dial');
        $data['app_call_details'] = $this->call_model->get_comu_app_call_details($comu_args);
        
        if(!empty($data['app_call_details'])){
            $comu_args = array('mobile_no'=>$form_call_data['cl_mobile_number'],'call_status'=>'Received');
            $data['app_call_details'] = $this->call_model->get_comu_app_call_details($comu_args);
        }
        
        $comu_args = array('mobile_no'=>$form_call_data['cl_mobile_number'],'call_status'=>'Call Dial');
        $data['app_call_details'] = $this->call_model->get_comu_app_call_details($comu_args);
      
        if(!empty($data['app_call_details'])){
            $comu_args = array('mobile_no'=>$form_call_data['cl_mobile_number'],'call_status'=>'Received');
            $data['app_call_details'] = $this->call_model->get_comu_app_call_details($comu_args);
        }
        // if($data['cl_purpose'] == 'ABUSED_CALL' &&  $data['parent_purpose'] == 'NON_EME'){
        //      "Hellooo";
        // }
        $booking_args = array('mobile_no'=>$form_call_data['cl_mobile_number']);
        $booking_data = $this->call_model->get_booking_details($booking_args);  
         
                 
             
                if(!empty($booking_data)){
                    $data['inc_details'] = array('chief_complete'=>$booking_data[0]->ct_type,
                        'chief_complete_id'=>$booking_data[0]->user_req_chiefcomplaint,
                        'destination_hp_name'=>$booking_data[0]->hp_name,
                        'destination_hospital_id'=>$booking_data[0]->user_req_hospid,
                        'user_req_id'=>$booking_data[0]->user_req_id);
                    
                    $data['app_call_details'][0] =(object)array('lat'=>$booking_data[0]->user_req_userlat,'lng'=>$booking_data[0]->user_req_userlng);
                    
                    $data['services'] = $this->common_model->get_services();
                    $data['questions'] = $this->call_model->get_active_questions($booking_data[0]->user_req_chiefcomplaint);
                    
                    
                    if( $booking_data[0]->user_req_usertype == '2'){
                       $data['common_data_form'] = array('first_name' => $booking_data[0]->fam_f_name,
                        'clr_fname' => $booking_data[0]->fam_f_name,
                        'clr_lname' => $booking_data[0]->fam_l_name,
                        'middle_name' => $booking_data[0]->fam_f_name,
                        'last_name' => $booking_data[0]->fam_l_name,
                        'ayu_id'=> $booking_data[0]->fam_ayushman_id,
                       // 'clr_full_name' => $patient->ptn_fullname,
                        'age_type' => 'Years',
                        'patient_gender' => $booking_data[0]->fam_gender,
                        'patient_dob' => $booking_data[0]->fam_f_name,
                        'patient_age' => $booking_data[0]->fam_age);
                    }else{
                           $data['common_data_form'] = array('first_name' => $booking_data[0]->f_name,
                            'last_name' => $booking_data[0]->l_name,
                            'clr_fname' => $booking_data[0]->f_name,
                            'clr_lname' => $booking_data[0]->l_name,
                            'ayu_id'=> $booking_data[0]->user_ayushman_id,
                           // 'clr_full_name' => $patient->ptn_fullname,
                            'age_type' => 'Years',
                            'patient_gender' => $booking_data[0]->gender,
                            'patient_age' => $booking_data[0]->age);
                    }
                    $this->output->add_to_position('', 'procesing_lbs', TRUE);
               
                }
            
              
              
              $callType =  $this->session->userdata('callType');
      
        if(empty($data['app_call_details']) && $form_call_data["parent_purpose"] == 'EMG' && $callType != 'outbound.manual.dial'){
            
            if(trim($form_call_data['cl_mobile_number']) != ''){
             
           
            $timestamp_lbs = time();
        
 
            if($this->session->userdata('set_lbs_mobile_number') != $form_call_data['cl_mobile_number']){
            $this->output->add_to_position('Waiting for LBS location...', 'procesing_lbs', TRUE); 
          
            $lbs_data = get_lbs_data($form_call_data['cl_mobile_number'],$timestamp_lbs);
            //var_dump($lbs_data);
            $this->session->set_userdata('set_lbs_mobile_number',$form_call_data['cl_mobile_number']);
         
            //$lbs_data = get_lbs_data('07828113726');
            $xml = simplexml_load_string($lbs_data['resp'], "SimpleXMLElement", LIBXML_NOCDATA);
            $json = json_decode(json_encode($xml), true);
                    
             $lbs_args_res = array('lbs_timestamp'=>$timestamp_lbs,'lbs_res_datetime'=>date('Y-m-d H:i:s'),'lbs_responce'=>addslashes($lbs_data['resp']));
            $this->call_model->update_lbs_data($lbs_args_res); 
            $this->output->add_to_position('', 'procesing_lbs', TRUE);  
           
            if($json["Response"]["longitude"] == '0' && $json["Response"]["latitude"] == '0'){
                 
                $this->output->add_to_position('No LBS Data Found...', 'procesing_lbs', TRUE);
            }
            if(empty($json["Response"]["longitude"])){
               
                $this->output->add_to_position('No LBS Data Found...', 'procesing_lbs', TRUE);
            }

            if(!empty($json["Response"]["latitude"]) && !empty($json["Response"]["latitude"])){
                
                $lat =$json["Response"]["latitude"];
                $lng =$json["Response"]["longitude"];

                $data['app_call_details'][0] =(object)array('lat'=>$lat,'lng'=>$lng);
                  $this->output->add_to_position('<b style="color:#009515;">LBS Data Found...</b>', 'procesing_lbs', TRUE);
                
            }
            $this->session->set_userdata('app_call_details',$data['app_call_details']);
         
            }else{
                $data['app_call_details']=$this->session->userdata('app_call_details');
            }
            }
        }
          
        $patient = $common_data_form;
    
        if($patient['dob'] != '')
        {
            $dob = $patient['dob'];
        }else{
            $dob = '';
        }
            if(!empty($common_data_form)){
                 $caller_details_data = array('clr_fname' => $patient['first_name'],
                 'clr_mname' => $patient['middle_name'],
                 'clr_lname' => $patient['last_name'],
                // 'clr_full_name' => $patient->ptn_fullname,
                 'patient_gender' => $patient['ptn_gender'],
                 'ptn_dob' => $dob,
                 'patient_age' => $patient['age']);
    
             $data['caller_details_data'] = $caller_details_data;
            }
           
            
            $clg_group = $this->clg->clg_group;
            $data['clg_group']=$this->clg->clg_group;
           
            
            if($clg_group == 'UG-ERO' ||  $clg_group == 'UG-BIKE-ERO'){
               $clg_user_type = '108'; 
            }else if($clg_group == 'UG-ERO-102'){
                $clg_user_type = '102'; 
            }else if($clg_group == 'UG-ERO-104'){
                $clg_user_type = '104'; 
            }else if($clg_group == 'UG-ERO-HD'){
                $clg_user_type = 'hd'; 
            }else if($clg_group == 'UG-REMOTE'){
                $clg_user_type = 'Remote';  
            }else{
                $clg_user_type = '102,108';
            }
            $data['clg_user_type']=$clg_user_type;
    
    
            $emt_details = $this->call_model->get_emt_user_details($mobile);
             
    
            if (isset($form_call_data['cl_mobile_number'])) {            
               
                $this->session->set_userdata('caller_no', $form_call_data['cl_mobile_number']);
                $mobile_no = $form_call_data['cl_mobile_number'];
                $data['m_no'] = $mobile_no;
            
                $data['caller_details'] = $this->call_model->get_caller_details($data['m_no']);
                if (!empty($data['caller_details'])) {
                    $form_call_data['caller_id'] = $data['caller_details']->clr_id;
                }
                $this->session->set_userdata('caller_details_data',  (array)$data['caller_details']);
            }
             
            
            $data['attend_call_time'] = $form_call_data['attend_call_time'];
    
    
            $relation_flag = 0;
    
            ////////////  MI42 ////////////////
    
            $this->session->unset_userdata('inc_act');
    
            //////////////////////////////////
            //////////////////////////////////
    
            if ($form_call_data['cl_purpose'] != $this->session->userdata('cl_purpose')) {
                $dispatch = $this->session->userdata('dispatch_time');
                // var_dump($dispatch);
    
                $current_time = time();
                // $this->session->set_userdata('dispatch_time', time());
    
                $this->output->add_to_position("<script> clock_timer('timer_clock','$dispatch','$current_time')</script>", 'custom_script', true);
            }
    
    
            $this->session->unset_userdata('caller_relation');
    
            if ($this->agent->is_mobile()) {
                $data['agent_mobile'] = 'yes';
            } else {
                $data['agent_mobile'] = 'no';
            }
    
        $this->output->add_to_position($this->load->view('frontend/calls/chief_complete_view', $data, TRUE), 'chief_complete_outer', TRUE);
        $this->output->add_to_position($this->load->view('frontend/calls/inter_chief_complete_view', $data, TRUE), 'inter_chief_complete_outer', TRUE);
            if (($form_call_data['cl_purpose'] == 'EMT_MED_AD') || ($form_call_data['cl_purpose'] == 'TEST_CALL')) {
                $relation_flag = 1;
    //            $this->output->add_to_position('', 'caller_relation_div', TRUE);
            } else {
    
                //  if ($form_call_data['cl_relation'] == "") {
                if (empty($emt_details)) {
                    //  $this->output->message = "<div class='error'>Please Select Relation Filed</div>";
                    //$data1['form_data'] = $form_call_data;
                    $relation_flag = 1;
                    //$this->output->add_to_position($this->load->view('frontend/calls/caller_details_re_view', $data1, TRUE), 'caller_relation_div', TRUE);
                } else {
    
                    $relation_flag = 1;
                }
                // } else {
                //      $relation_flag = 1;
                //  }
            }
                   
            if($form_call_data['cl_purpose'] == "AD_SUP_REQ" || $form_call_data['cl_purpose'] == "EMT_MED_AD" ){
             
               // $this->output->add_to_position('', 'call_common_info', TRUE);
                
                $script_message = "<script> jQuery(document).ready(function(){  $('#call_common_info .call_common_info').addClass('hide_div'); $('#call_common_info #ptn_first_name').removeClass('filter_required'); $('#call_common_info #ptn_last_name').removeClass('filter_required'); $('#call_common_info #ptn_age').removeClass('filter_required'); $('#call_common_info #patient_gender').removeClass('filter_required'); $('.three_word ').attr('data-qr','mobile_no=$mobile'); });</script>";
                  $this->output->add_to_position($script_message, 'custom_script', TRUE); 
    
            }else if($form_call_data['cl_purpose'] == "NON_MCI" || $form_call_data['cl_purpose'] == "Child_CARE_CALL" || $form_call_data['cl_purpose'] == "DROP_BACK" || $form_call_data['cl_purpose'] == "IN_HO_P_TR" || $form_call_data['cl_purpose'] == "MCI" || $form_call_data['cl_purpose'] == "PREGANCY_CALL" || $form_call_data['cl_purpose'] == "VIP_CALL" ){
                
                 $script_message = "<script>jQuery(document).ready(function () {  $('#call_common_info .call_common_info').removeClass('hide_div'); $('#call_common_info #ptn_first_name').addClass('filter_required'); $('#call_common_info #ptn_last_name').addClass('filter_required'); $('#call_common_info #ptn_age').addClass('filter_required'); $('#call_common_info #patient_gender').addClass('filter_required'); $('.three_word ').attr('data-qr','mobile_no=$mobile'); });  </script>";
                  $this->output->add_to_position($script_message, 'custom_script', TRUE); 
                 
                 //$this->output->add_to_position($this->load->view('frontend/calls/common_patient_info', $data, TRUE), 'call_common_info', TRUE);
               
            }
            
            if ($relation_flag == 1) {
              
                if (!isset($form_call_data['cl_relation'])) {
                    $form_call_data['cl_relation'] = "";
                }
                
               //if($data['caller_details']->clr_fname != $form_call_data['cl_firstname'] || $data['caller_details']->clr_mname != $form_call_data['cl_middlename'] || $data['caller_details']->clr_lname != $form_call_data['cl_lastname']){
                    $caller_data = array('clr_mobile' => $form_call_data['cl_mobile_number'],
                        'clr_fname' => $form_call_data['cl_firstname'] ? $form_call_data['cl_firstname'] : 'Unknown',
                        'clr_mname' => $form_call_data['cl_middlename'] ? $form_call_data['cl_middlename'] : '',
                        'clr_lname' => $form_call_data['cl_lastname'] ? $form_call_data['cl_lastname'] : '',
                        'clr_fullname' => $form_call_data['cl_firstname'] ? $form_call_data['cl_firstname'] : 'Unknown' . ' ' . $form_call_data['cl_middlename'] ? $form_call_data['cl_middlename'] : '' . ' ' . $form_call_data['cl_lastname'] ? $form_call_data['cl_lastname'] : '');
             //  }
    
                $caller_id = $form_call_data['caller_id'];
    
                $form_call_data['cl_datetime'] = date('Y-m-d H:i:s');
                $current_date = date('Y-m-d');
                $base_month = $this->common_model->get_base_month($current_date);
                $cl_base_month = $data['cl_base_month'] = $base_month[0]->months;
    
                $call_id = $this->input->post('call_id', TRUE);
    
                $data['tahshil'] = $form_call_data['cl_tehsil'];
    
                if ($call_id == '') {
                    $data['call_id'] = $form_call_data['call_id'];
                }
                if ($data['caller_id'] == '') {
                    $data['caller_id'] = $form_call_data['caller_id'];
                }
                //var_dump( $data['caller_details'] );
                // var_dump( $caller_data );
               // var_dump($form_call_data['call_id']);
                   
                if ($form_call_data['call_id'] != '') {
    
                    if ($caller_data['clr_fname'] != '' || $caller_data['clr_fname'] != '' || $caller_data['clr_fname'] != '') {
                        //$caller_data['caller_id'] = $form_call_data['caller_id'];
                        $data['caller_details'] = $caller_data;
                      
                        $data['caller_id'] = $this->call_model->insert_caller_details($caller_data);
                        //$data['caller_id'] = $this->call_model->update_caller_details($caller_data,$form_call_data['caller_id']);
                       
                       // $data['caller_details']['clr_id'] =  $data['caller_id'];
                     
                    }
    
                    $call_data = array('cl_base_month' => $cl_base_month,
                        'cl_clr_id' =>  $data['caller_id'],
                        'clr_ralation' => $form_call_data['cl_relation'],
                        'cl_purpose' => $form_call_data['parent_purpose'],
                        'cl_datetime' => $form_call_data['cl_datetime']
                    );
                $upadate_call_id = $this->call_model->update_call_details($call_data, $form_call_data['call_id']);
    
                      $this->output->add_to_position($this->load->view('frontend/calls/hidden_caller_id_block_view', $data, TRUE), 'hidden_caller_id_block_view', TRUE);
                      
                } else {
                    
    
                    if ($form_call_data['caller_id'] == '') {
    
                        $data['caller_details'] = $caller_data;
                         if ($caller_data['clr_fname'] != '' || $caller_data['clr_fname'] != '' || $caller_data['clr_fname'] != '') {
                        $data['caller_id'] = $this->call_model->insert_caller_details($caller_data);
                        $$data['caller_details']['clr_id'] =  $data['caller_id'];
                        }
                        
                    }else {
                        $data['caller_details'] = $caller_data;
                        $data['caller_id'] = $this->call_model->insert_caller_details($caller_data);
                        $data['caller_details']['clr_id'] =  $data['caller_id'];
                        
                    }
                    $call_data = array('cl_base_month' => $cl_base_month,
                        'cl_clr_id' => $data['caller_id'],
                        'clr_ralation' => $form_call_data['cl_relation'],
                        'cl_purpose' => $form_call_data['parent_purpose'],
                        'cl_datetime' => $form_call_data['cl_datetime']
                    );
                    $data['call_id'] = $this->call_model->insert_call_details($call_data);
                     $this->output->add_to_position($this->load->view('frontend/calls/hidden_caller_id_block_view', $data, TRUE), 'hidden_caller_id_block_view', TRUE);
                      
                }
    
                $data['caller_details'] = array('cl_id' => $data['call_id'],
                    'clr_id' => $data['caller_id'],
                    'clr_mobile' => $form_call_data['cl_mobile_number'],
                    'clr_fname' => $form_call_data['cl_firstname'],
                    'clr_mname' => $form_call_data['cl_middlename'],
                    'clr_lname' => $form_call_data['cl_lastname'],
                    'clr_fullname' => $form_call_data['clr_fullname']);
    
                if ($form_call_data['cl_relation'] == 6) {
                    $data['caller_details_data'] = $data['caller_details'];
                }
               
                //            if($form_call_data['cl_purpose'] == $this->session->userdata('cl_purpose') && $form_call_data['cl_purpose'] != 'CORONA'){
                //              
                //                  // var_dump($form_call_data['cl_purpose']);
                //                $this->output->add_to_position($this->load->view('frontend/inc/patient_hidden_details', $data, TRUE), 'patient_hidden_div', TRUE);
                //                return false;
                //            }
                        
                //var_dump($form_call_data['cl_purpose']);
                $this->session->set_userdata('cl_purpose', $form_call_data['cl_purpose']);
                $this->session->set_userdata('caller_relation', $form_call_data['cl_relation']);
                $this->session->set_userdata('caller_details', $data['caller_details']);
    
                $this->session->unset_userdata('inc_ref_id');
    
                
                 $this->output->add_to_position($this->load->view('frontend/calls/hidden_caller_id_block_view', $data, TRUE), 'hidden_caller_id_block_view', TRUE);
         
                if ($form_call_data["cl_purpose"] == "CORONA") {
                    $cm_id='60';
                    $data['advice'] = $this->call_model->get_advice();
                    $data['questions'] = $this->call_model->get_questions($cm_id);
                    //var_dump($data['questions']);die();
                    $this->output->add_to_position($this->load->view('frontend/corona/corona_call_view', $data, TRUE), 'content', TRUE);
                } else if (strstr($form_call_data["cl_purpose"], "MCI")) {
                    // $inc_id = generate_inc_ref_id();
                    //var_dump($form_call_data["cl_purpose"]);
                    //$data['inc_details'] = array('inc_ref_id'=> $inc_id);
                    
                    //$data['questions'] = $this->call_model->get_questions('inter');
                    $data['services'] = $this->common_model->get_services();
    
                    $inc_view_name = strtolower($form_call_data["cl_purpose"]) . '_view';
                    //var_dump($inc_view_name);
                    $this->output->add_to_position($this->load->view('frontend/inc/' . $inc_view_name, $data, TRUE), 'content', TRUE);
                   
    
                    
                    $this->output->set_focus_to = "ptn_no";
                } else if ($form_call_data["cl_purpose"] === 'VIP_CALL') {
    
                    $data['questions'] = $this->call_model->get_questions('inter');
                    $data['services'] = $this->common_model->get_services();
                    $this->output->add_to_position($this->load->view('frontend/inc/vip_call_view', $data, TRUE), 'content', TRUE);
                    $this->output->set_focus_to = "ptn_no";
                } else if ($form_call_data["cl_purpose"] === 'EMG_PVT_HOS') {
                    $data['questions'] = $this->call_model->get_questions('inter');
                    $data['services'] = $this->common_model->get_services();
                    $this->output->add_to_position($this->load->view('frontend/inc/pvt_hos_call_view', $data, TRUE), 'content', TRUE);
                    $this->output->set_focus_to = "ptn_no";
                } else if ($form_call_data["cl_purpose"] === 'IN_HO_P_TR') {
    
                    $data['default_state'] = $this->default_state; 
                    $data['questions'] = $this->call_model->get_inter_questions('inter');
                    $this->output->add_to_position($this->load->view('frontend/in_hos/inter_hos_pet_view', $data, TRUE), 'content', TRUE);
                    $this->output->set_focus_to = "ptn_no";
                } else if (strstr($form_call_data["cl_purpose"], "UNREC_CALL")) {
    
                    $this->output->add_to_position($this->load->view('frontend/unrecog/unrecog_form_view', $data, TRUE), 'content', TRUE);
                } else if (strstr($form_call_data["cl_purpose"], "TEST_CALL")) {
    
                    $data['get_question'] = $this->common_model->get_question(array('que_type' => 'test'));
    
                    $this->output->add_to_position($this->load->view('frontend/test/test_form_view', $data, TRUE), 'content', TRUE);
                } else if (strstr($form_call_data["cl_purpose"], "ENQ_CALL")) {
    
                    unset($_COOKIE['set_question']);
                    $current_user_group=$this->session->userdata['current_user']->clg_group;
                    if($current_user_group=='UG-ERO' || $current_user_group == 'UG-BIKE-ERO'){
                        $system="108";
                     }else if($current_user_group=='UG-ERO-102'){
                        $system="102";
                     }else if($current_user_group=='UG-ERO-104'){
                        $system="104";
                     }else if($current_user_group=='UG-ERO-HD'){
                        $system="hd";
                    }else{
                        $system="";
                    }
    
                    if($system == "108"){
                    $data['emr_details'] = $this->common_model->emergency_details(array('oname' => 'ms_about_108'));
                    $data['get_question'] = $this->common_model->get_question(array('que_type' => 'enq_108'));
                    }else{
                    $data['emr_details'] = $this->common_model->emergency_details(array('oname' => 'ms_about_102'));   
                    $data['get_question'] = $this->common_model->get_question(array('que_type' => 'enq_102'));
                    }
    
                    
    
                    $this->output->add_to_position($this->load->view('frontend/enq/enq_form_view', $data, TRUE), 'content', TRUE);
                } else if (strstr($form_call_data["cl_purpose"], "AD_SUP_REQ")) {
    
                    $data['get_sevice'] = $this->common_model->get_services();
    
                    $this->output->add_to_position($this->load->view('frontend/resource/add_resource_view', $data, TRUE), 'content', TRUE);
                      //$this->output->add_to_position('&nbsp;', 'call_common_info', TRUE);
                      //$this->output->add_to_position('&nbsp;', 'patient_hidden_div', TRUE);
                      
                    
                } else if (strstr($form_call_data["cl_purpose"], "COMP_CALL")) {
                 
                    $data['cl_purpose'] = 'COMP_CALL';
    
                    $this->output->set_focus_to = "cctype";
    
                    $this->output->add_to_position($this->load->view('frontend/complaint/complaint_form_view', $data, TRUE), 'content', TRUE);
    
                    $this->output->add_to_position($this->load->view('frontend/inc/inc_filter_view', $data, TRUE), 'inc_filters', TRUE);
                } else if (strstr($form_call_data["cl_purpose"], "EMT_MED_AD")) {
    
    
    
                    $args = array('amb_mob' => $form_call_data['cl_mobile_number'], 'base_month' => $cl_base_month);
    
    
                    $data['inc_id'] = $this->common_model->get_curinc($args);
                    $data['default_state'] = $this->default_state; 
    
                    $this->output->set_focus_to = "cmadv_incid";
    
                    $this->output->add_to_position($this->load->view('frontend/medadv/med_adv_form_view', $data, TRUE), 'content', TRUE);
    
    
                    //////////////////////////////// Load auto incident ////////////////////////////////////
    
                    if (!empty($data['inc_id'])) {
    
                        $args = array(
                            'inc_ref_id' => $data['inc_id'][0]->inc_ref_id,
                            'base_month' => $cl_base_month
                        );
    
    
                        $data['default_state'] = $this->default_state; 
                        $data['pt_info'] = $this->Pet_model->get_ptinc_info($args);
    
                        $data['increfid'] = $data['inc_id'][0]->inc_ref_id;
    
                        $this->output->add_to_position($this->load->view('frontend/medadv/med_adv_info', $data, TRUE), 'adv_pt_info', TRUE);
                    }
    
                    //$this->output->add_to_position('&nbsp;', 'call_common_info', TRUE);
                    //$this->output->add_to_position('&nbsp;', 'patient_hidden_div', TRUE);
    
                    ////////////////////////////////////////////////////////////////
                } else if (strstr($form_call_data["cl_purpose"], "FEED_CALL")) {
    
                    $data['cl_purpose'] = 'FEED_CALL';
    
                    $this->output->set_focus_to = "cftype";
    
                    $this->output->add_to_position($this->load->view('frontend/feedback/feedback_form_view', $data, TRUE), 'content', TRUE);
    
    
                    $this->output->add_to_position($this->load->view('frontend/inc/inc_filter_view', $data, TRUE), 'inc_filters', TRUE);
                } else if (strstr($form_call_data["cl_purpose"], "FOLL_CALL")) {
    
                    $data['cl_purpose'] = 'FOLL_CALL';
    
                    $this->output->set_focus_to = "cinc_id";
    
                    $data['default_state'] = $this->default_state;
    
                    $this->output->add_to_position($this->load->view('frontend/fupcall/fupcall_form_view', $data, TRUE), 'content', TRUE);
    
                    $this->output->add_to_position($this->load->view('frontend/fupcall/fup_inc_filter_view', $data, TRUE), 'inc_filters', TRUE);
                } else if ($form_call_data["cl_purpose"] == "SUPPORT") {
    
                    unset($_COOKIE['set_sup_question']);
    
                    $data['emr_details'] = $this->common_model->emergency_details(array('oname' => 'ms_about_108'));
    
                    $data['get_question'] = $this->common_model->get_question(array('que_type' => 'support'));
    
                    $this->output->add_to_position($this->load->view('frontend/support/support_form_view', $data, TRUE), 'content', TRUE);
                }else if (strstr($form_call_data["cl_purpose"], "APP_SUPPORT_CALL")) {
    
                    $data['cl_purpose'] = 'APP_SUPPORT_CALL';
                    $data['cl_type'] = 'APP_SUPPORT_CALL';
    
    
                    $this->output->add_to_position($this->load->view('frontend/non_eme_calls/app_support_call_view', $data, TRUE), 'content', TRUE);
                } else if (strstr($form_call_data["cl_purpose"], "PRO_REP_SER")) {
                    $data['cl_purpose'] = 'PRO_REP_SER';
    
    
                    $this->output->add_to_position($this->load->view('frontend/prob_report_calls/prob_report_form_view', $data, TRUE), 'content', TRUE);
                } else if (strstr($form_call_data["cl_purpose"], "TRANS_PDA")) {
    
                    $data['cl_purpose'] = 'TRANS_PDA';
    
    
                    $this->output->add_to_position($this->load->view('frontend/call_transfer/trans_pda_form_view', $data, TRUE), 'content', TRUE);
                } else if (strstr($form_call_data["cl_purpose"], "TRANS_BIKE")) {
    
                    $data['cl_purpose'] = 'TRANS_BIKE';
                    $this->output->add_to_position($this->load->view('frontend/call_transfer/trans_bike_call_form_view', $data, TRUE), 'content', TRUE);
                } else if (strstr($form_call_data["cl_purpose"], "TRANS_SITUATIONALDESK")) {
    
                    $data['cl_purpose'] = 'TRANS_SITUATIONALDESK';
                    $this->output->add_to_position($this->load->view('frontend/call_transfer/trans_situational_form_view', $data, TRUE), 'content', TRUE);
                } else if (strstr($form_call_data["cl_purpose"], "TRANS_TDD")) {
    
                    $data['cl_purpose'] = 'TRANS_TDD';
                    $this->output->add_to_position($this->load->view('frontend/call_transfer/trans_tdd_call_form_view', $data, TRUE), 'content', TRUE);
                } 
                else if (strstr($form_call_data["cl_purpose"], "on_scene_care")) {
    
                    $this->output->add_to_position($this->load->view('frontend/inc/on_scene_care_view', $data, TRUE), 'content', TRUE);
                }else if (strstr($form_call_data["cl_purpose"], "TRANS_FLEET")) {
    
                    $data['cl_purpose'] = 'TRANS_FLEET';
                    $this->output->add_to_position($this->load->view('frontend/call_transfer/trans_fleet_from_view', $data, TRUE), 'content', TRUE);
                } else if (strstr($form_call_data["cl_purpose"], "TRANS_102")) {
    
                    $data['cl_purpose'] = 'TRANS_102';
                    $this->output->add_to_position($this->load->view('frontend/trans_calls/trans_call_form_view', $data, TRUE), 'content', TRUE);
                }
                else if (strstr($form_call_data["cl_purpose"], "TRANS_FDA")) {
    
                    $data['cl_purpose'] = 'TRANS_FDA';
    
    
                    $this->output->add_to_position($this->load->view('frontend/call_transfer/trans_fda_form_view', $data, TRUE), 'content', TRUE);
                } else if (strstr($form_call_data["cl_purpose"], "AMB_TO_ERC")) {
    
                    $data['cl_purpose'] = 'AMB_TO_ERC';
    
                    $data['users'] = $this->module_model->get_users_groups();
    
                    $this->output->add_to_position($this->load->view('frontend/amb_erc/amb_erc_form_view', $data, TRUE), 'content', TRUE);
                } else if (strstr($form_call_data["cl_purpose"], "CALL_TRANS_102")) {
    
                    $data['cl_purpose'] = 'CALL_TRANS_102';
    
                    $this->output->add_to_position($this->load->view('frontend/trans_calls/trans_call_form_view', $data, TRUE), 'content', TRUE);
                }else if (strstr($form_call_data["cl_purpose"], "TRANS_CALL_108")) {
    
                    $data['cl_purpose'] = 'TRANS_CALL_108';
    
                    $this->output->add_to_position($this->load->view('frontend/trans_calls/trans_108_call_form_view', $data, TRUE), 'content', TRUE);
                } else if (strstr($form_call_data["cl_purpose"], "NON_EME_CALL")) {
    
                    $data['cl_purpose'] = 'NON_EME_CALL';
                    $data['non_eme_calls'] = $this->call_model->get_non_eme_calls();
    
                    $this->output->add_to_position($this->load->view('frontend/non_eme_calls/non_eme_form_view', $data, TRUE), 'content', TRUE);
                }else if ($form_call_data["cl_purpose"] == 'ABU_NOT_COUN_CALL') {
    
                $data['cl_type'] = 'ABU_NOT_COUN_CALL';
    
                $this->output->add_to_position($this->load->view('frontend/non_eme_calls/abuse_call_form_view', $data, TRUE), 'content', TRUE);
            } else if (strstr($form_call_data["cl_purpose"], "ABU_COUN_CALL")) {
    
                $data['cl_type'] = 'ABU_COUN_CALL';
    
                $this->output->add_to_position($this->load->view('frontend/non_eme_calls/abuse_coun_call_form_view', $data, TRUE), 'content', TRUE);
            }else if (strstr($form_call_data["cl_purpose"], "ABUSED_CALL")) {
    
                $data['cl_type'] = 'ABUSED_CALL';
    
                $this->output->add_to_position($this->load->view('frontend/non_eme_calls/abuse_form_view', $data, TRUE), 'content', TRUE);
            } else if( strstr($form_call_data["cl_purpose"], "MISS_CALL")) {
    
                $data['cl_type'] = 'MISS_CALL';
    
                $this->output->add_to_position($this->load->view('frontend/non_eme_calls/miss_call_form_view', $data, TRUE), 'content', TRUE);
            } else if( strstr($form_call_data["cl_purpose"], "AMB_NT_ASSIGND")) {
    
                $data['cl_type'] = 'AMB_NT_ASSIGND';
    
                $this->output->add_to_position($this->load->view('frontend/non_eme_calls/amb_not_assign_form_view', $data, TRUE), 'content', TRUE);
            }else if ( strstr($form_call_data["cl_purpose"], "APP_CALL")) {
    
                $caller_no = $this->session->userdata('caller_no');
                $args = array(
                    'clr_mobile' => $caller_no
                );
                $data['default_state'] = $this->default_state;
                $data['purpose_of_calls'] = $this->call_model->get_purpose_of_calls();
                $data['inc_details'] = $this->call_model->get_incedence_details_by_c_no($args);
    
    
                $data['cl_type'] = 'APP_CALL';
    
                $this->output->add_to_position($this->load->view('frontend/non_eme_calls/app_call_form_view', $data, TRUE), 'content', TRUE);
            } else if (strstr($form_call_data["cl_purpose"], "UNATT_CALL")) {
    
                $data['cl_type'] = 'UNATT_CALL';
    
                $this->output->add_to_position($this->load->view('frontend/non_eme_calls/unattend_call_form_view', $data, TRUE), 'content', TRUE);
            } else if (strstr($form_call_data["cl_purpose"], "DISS_CON_CALL")) {
    
                $data['cl_type'] = 'DISS_CON_CALL';
    
                $this->output->add_to_position($this->load->view('frontend/non_eme_calls/disconnected_call_form_view', $data, TRUE), 'content', TRUE);
            } else if (strstr($form_call_data["cl_purpose"], "DUP_CALL")) {
    
                $data['cl_type'] = 'DUP_CALL';
    
                $this->output->add_to_position($this->load->view('frontend/non_eme_calls/dupblicated_call_form_view', $data, TRUE), 'content', TRUE);
            } else if (strstr($form_call_data["cl_purpose"], "AMB_NOT_AVA")) {
    
                $data['cl_type'] = 'AMB_NOT_AVA';
    
                $this->output->add_to_position($this->load->view('frontend/non_eme_calls/amb_no_ava_call_form_view', $data, TRUE), 'content', TRUE);
            } else if ( strstr($form_call_data["cl_purpose"], "NO_RES_CALL")) {
    
                $data['cl_type'] = 'NO_RES_CALL';
    
                $this->output->add_to_position($this->load->view('frontend/non_eme_calls/no_resp_call_form_view', $data, TRUE), 'content', TRUE);
            } else if (strstr($form_call_data["cl_purpose"], "WRONG_CALL")) {
    
                $data['cl_type'] = 'WRONG_CALL';
    
                $this->output->add_to_position($this->load->view('frontend/non_eme_calls/wrong_call_form_view', $data, TRUE), 'content', TRUE);
            } else if (strstr($form_call_data["cl_purpose"], "NUS_CALL")) {
    
                $data['cl_type'] = 'NUS_CALL';
    
                $this->output->add_to_position($this->load->view('frontend/non_eme_calls/nusion_call_form_view', $data, TRUE), 'content', TRUE);
            } else if (strstr($form_call_data["cl_purpose"], "SLI_CALL")) {
    
                $data['cl_type'] = 'SLI_CALL';
    
                $this->output->add_to_position($this->load->view('frontend/non_eme_calls/slient_call_form_view', $data, TRUE), 'content', TRUE);
            } else if (strstr($form_call_data["cl_purpose"], "SUGG_CALL")) {
    
                $data['cl_type'] = 'SUGG_CALL';
    
                $this->output->add_to_position($this->load->view('frontend/non_eme_calls/suggested_call_form_view', $data, TRUE), 'content', TRUE);
            }else if (strstr($form_call_data["cl_purpose"], "CHILD_CALL")) {
    
                $data['cl_type'] = 'CHILD_CALL';
    
                $this->output->add_to_position($this->load->view('frontend/non_eme_calls/child_call_form_view', $data, TRUE), 'content', TRUE);
            }else if (strstr($form_call_data["cl_purpose"], "ESCALATION_CALL")) {
    
                $data['cl_type'] = 'ESCALATION_CALL';
    
                $this->output->add_to_position($this->load->view('frontend/non_eme_calls/esacalation_call_form_view', $data, TRUE), 'content', TRUE);
            }else if (strstr($form_call_data["cl_purpose"], "DEMO_CALL")) {
    
                $data['cl_type'] = 'DEMO_CALL';
    
                $this->output->add_to_position($this->load->view('frontend/non_eme_calls/demo_call_form_view', $data, TRUE), 'content', TRUE);
            }else if (strstr($form_call_data["cl_purpose"], "SERVICE_NOT_REQUIRED")) {
    
                $data['cl_type'] = 'SERVICE_NOT_REQUIRED';
    
                $this->output->add_to_position($this->load->view('frontend/non_eme_calls/service_call_form_view', $data, TRUE), 'content', TRUE);
            }else if (strstr($form_call_data["cl_purpose"], "PREGANCY_CALL")) {
    
                    $data['cl_type'] = 'PREGANCY_CALL';
                    $data['questions'] = $this->call_model->get_questions('com');
                    $data['services'] = $this->common_model->get_services();
                    $this->output->add_to_position($this->load->view('frontend/inc/pregancy_call_view', $data, TRUE), 'content', TRUE);
                    $this->output->set_focus_to = "ptn_no";
            }else if (strstr($form_call_data["cl_purpose"], "Child_CARE_CALL")) {
    
                $data['cl_type'] = 'Child_CARE_CALL';
                    $data['questions'] = $this->call_model->get_questions('com');
                    $data['services'] = $this->common_model->get_services();
                    $this->output->add_to_position($this->load->view('frontend/inc/child_care_call_view', $data, TRUE), 'content', TRUE);
                    $this->output->set_focus_to = "ptn_no";
            }else if (strstr($form_call_data["cl_purpose"], "DROP_BACK")) {
    
                $data['cl_type'] = 'DROP_BACK';
                    $data['questions'] = $this->call_model->get_questions('com');
                    $data['services'] = $this->common_model->get_services();
                    $this->output->add_to_position($this->load->view('frontend/inc/drop_back_call_view', $data, TRUE), 'content', TRUE);
                    $this->output->set_focus_to = "ptn_no";
            }else if (strstr($form_call_data["cl_purpose"], "PICK_UP")) {
    
                $data['cl_type'] = 'PICK_UP';
                    $data['questions'] = $this->call_model->get_questions('com');
                    $data['services'] = $this->common_model->get_services();
                    $this->output->add_to_position($this->load->view('frontend/inc/pickup_call_view', $data, TRUE), 'content', TRUE);
                    $this->output->set_focus_to = "ptn_no";
            }else if (strstr($form_call_data["cl_purpose"], "GEN_ENQ")) {
    
                $data['cl_type'] = 'GEN_ENQ';
                    //$data['questions'] = $this->call_model->get_questions('com');
                    //$data['services'] = $this->common_model->get_services();
                    $this->output->add_to_position($this->load->view('frontend/gen_enq/gen_enq_form_view', $data, TRUE), 'content', TRUE);
                    
            }else if ($form_call_data["cl_purpose"] == "CORONA") {
                 $cm_id='60';
                    $data['advice'] = $this->call_model->get_advice();
                $data['questions'] = $this->call_model->get_questions($cm_id);
                //var_dump($data['questions']);die();
                    $this->output->add_to_position($this->load->view('frontend/corona/corona_call_view', $data, TRUE), 'content', TRUE);
                }else if ($form_call_data["cl_purpose"] == "CORONA_GENERAL_ENQUIRY_AD") {
                 $cm_id='60';
                    $data['advice'] = $this->call_model->get_advice();
                $data['questions'] = $this->call_model->get_questions($cm_id);
                //var_dump($data['questions']);die();
                    $this->output->add_to_position($this->load->view('frontend/corona/General_Enquiry_Administrative', $data, TRUE), 'content', TRUE);
                }else if ($form_call_data["cl_purpose"] == "CORONA_GENERAL_ENQUIRY") {
                 $cm_id='60';
                    $data['advice'] = $this->call_model->get_advice();
                $data['questions'] = $this->call_model->get_questions($cm_id);
                //var_dump($data['questions']);die();
                    $this->output->add_to_position($this->load->view('frontend/corona/General_Enquiry_Corona', $data, TRUE), 'content', TRUE);
                }else if (strstr($form_call_data["cl_purpose"], "HELP_VACC_INFO")) {
                    $data['cl_type'] = 'HELP_VACC_INFO';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_vaccine_info_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_VACC_CERT")) {
                    $data['cl_type'] = 'HELP_VACC_CERT';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_vaccine_cert_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_VACC_CORR")) {
                    $data['cl_type'] = 'HELP_VACC_CORR';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_vaccine_corr_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_COR_REG")) {
                    $data['cl_type'] = 'HELP_COR_REG';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_corana_test_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_HOS_INFO")) {
                    $data['cl_type'] = 'HELP_HOS_INFO';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_hosp_info_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_AYU_CALL")) {
                    $data['cl_type'] = 'HELP_AYU_CALL';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_ayu_rel_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_BLD_BANK")) {
                    $data['cl_type'] = 'HELP_BLD_BANK';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_bld_bnk_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_AMB_TRS")) {
                    $data['cl_type'] = 'HELP_AMB_TRS';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_amb_rel_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_INFO_HEA_LIN")) {
                    $data['cl_type'] = 'HELP_INFO_HEA_LIN';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_info_104_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_INFO_BIRTH")) {
                    $data['cl_type'] = 'HELP_INFO_BIRTH';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_info_birth_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_INFO_AMB_SER")) {
                    $data['cl_type'] = 'HELP_INFO_AMB_SER';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_info_108_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_INFO_ENQ")) {
                    $data['cl_type'] = 'HELP_INFO_ENQ';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_info_enq_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_INFO_COR")) {
                    $data['cl_type'] = 'HELP_INFO_COR';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_info_covid_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_INFO_INT")) {
                    $data['cl_type'] = 'HELP_INFO_INT';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_info_state_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_INFO_MED_INFO")) {
                    $data['cl_type'] = 'HELP_INFO_MED_INFO';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_info_med_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_INFO_SCH_REL")) {
                    $data['cl_type'] = 'HELP_INFO_SCH_REL';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_info_scheme_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_COUN_TEN")) {
                    $data['cl_type'] = 'HELP_COUN_TEN';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_coun_ten_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_COUN_DEP")) {
                    $data['cl_type'] = 'HELP_COUN_DEP';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_coun_dep_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_COUN_CER")) {
                    $data['cl_type'] = 'HELP_COUN_CER';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_coun_carr_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_COUN_PER")) {
                    $data['cl_type'] = 'HELP_COUN_PER';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_coun_per_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_COUN_FAM")) {
                    $data['cl_type'] = 'HELP_COUN_FAM';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_coun_fam_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_COUN_PSY")) {
                    $data['cl_type'] = 'HELP_COUN_PSY';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_coun_psy_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_COUN_SUB")) {
                    $data['cl_type'] = 'HELP_COUN_SUB';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_coun_sub_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_COUN_LOG")) {
                    $data['cl_type'] = 'HELP_COUN_LOG';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_coun_log_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_COUN_ADO")) {
                    $data['cl_type'] = 'HELP_COUN_ADO';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_coun_ado_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_COUN_SOC")) {
                    $data['cl_type'] = 'HELP_COUN_SOC';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_coun_soc_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_COUN_BEH")) {
                    $data['cl_type'] = 'HELP_COUN_BEH';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_coun_beh_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_COUN_REL")) {
                    $data['cl_type'] = 'HELP_COUN_REL';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_coun_rel_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_COUN_OTH")) {
                    $data['cl_type'] = 'HELP_COUN_OTH';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_coun_oth_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_COUN_SUI")) {
                    $data['cl_type'] = 'HELP_COUN_SUI';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_coun_suid_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_COMP_JSSY")) {
                    $data['cl_type'] = 'HELP_COMP_JSSY';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_comp_jssy_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_COMP_PMVVY")) {
                    $data['cl_type'] = 'HELP_COMP_PMVVY';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_comp_pmvvy_view', $data, TRUE), 'content', TRUE);
    
                }
                // else if (strstr($form_call_data["cl_purpose"], "HELP_COMP_HOS")) {
                //     $data['cl_type'] = 'HELP_COMP_HOS';
                //     $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_comp_hosp_view', $data, TRUE), 'content', TRUE);
    
                // }
                else if (strstr($form_call_data["cl_purpose"], "HELP_COMP_INTR")) {
                    $data['cl_type'] = 'HELP_COMP_INTR';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_comp_inter_view', $data, TRUE), 'content', TRUE);
    
                }else if (strstr($form_call_data["cl_purpose"], "HELP_COMP_VACC")) {
                    $data['cl_type'] = 'HELP_COMP_VACC';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_comp_vacc_view', $data, TRUE), 'content', TRUE);
    
                } else if(strstr($form_call_data["cl_purpose"], "HELP_EME_CALL_MED")){
                 
                    $data['cl_type'] = 'HELP_EME_CALL_MED';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_medical_call', $data, TRUE), 'content', TRUE);
                }else if(strstr($form_call_data["cl_purpose"], "COMPLAT_HELP_CALL")){
                 
                    $data['cl_type'] = 'COMPLAT_HELP_CALL';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_comp_call', $data, TRUE), 'content', TRUE);
                }
                else if(strstr($form_call_data["cl_purpose"], "HELP_COMP_AMB")){
                 
                    $data['cl_type'] = 'HELP_COMP_AMB';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_complaint_amb_view', $data, TRUE), 'content', TRUE);
                }
                else if(strstr($form_call_data["cl_purpose"], "HELP_COMP_FOOD")){
                 
                    $data['cl_type'] = 'HELP_COMP_FOOD';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_complaint_food_view', $data, TRUE), 'content', TRUE);
                }
                else if(strstr($form_call_data["cl_purpose"], "HELP_COMP_HOS")){
                 
                    $data['cl_type'] = 'HELP_COMP_HOS';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_complaint_hos_view', $data, TRUE), 'content', TRUE);
                }
                else if(strstr($form_call_data["cl_purpose"], "HELP_COMP_OTHR")){
                 
                    $data['cl_type'] = 'HELP_COMP_OTHR';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_complaint_other_view', $data, TRUE), 'content', TRUE);
                }
                else if(strstr($form_call_data["cl_purpose"], "HELP_OTHER_OTH")){
                 
                    $data['cl_type'] = 'HELP_OTHER_OTH';
                    $this->output->add_to_position($this->load->view('frontend/help_desk_104/help_other_view', $data, TRUE), 'content', TRUE);
                }
                
    
                if ($this->input->get_post('fcrel', TRUE) == 'yes') {
                    $this->output->set_focus_to = "caller_relation";
                }
    
                  // var_dump($data['caller_details']);
                //die();
             
                $this->output->add_to_position($this->load->view('frontend/calls/common_call_script_view', $data, TRUE), 'common_call_script_view', TRUE);
    
                $this->output->template = "calls";
            }
        }

    function change_status() {

        $amb_details = $this->input->post();
        $amb_id = base64_decode($amb_details['amb_id']);
        $args = array(
            'amb_id' => $amb_id,
        );
        $data['status'] = $amb_details['status'];
        $data['amb_id'] = $amb_id;
        $data['get_amb_details'] = $this->amb_model->get_amb_data($args);

        // $this->output->add_to_position($this->load->view('frontend/amb/update_amb_status', $data, TRUE), 'popup_div', TRUE);
        $this->output->add_to_popup($this->load->view('frontend/amb/update_amb_status', $data, TRUE), '600', '560');
    }
  function eqp_break_show_ambulance_odometer() {
        $amb_details = $this->input->post();

        $args_odometer = array('rto_no' => $amb_details['amb_id']);
        $amb_odometer = $this->amb_model->get_amb_odometer($args_odometer);
    
        
        if ($amb_odometer[0]->end_odmeter != 'NULL' && $amb_odometer[0]->end_odmeter != NULL) {
            $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;
        } else {
            $data['previous_odometer'] = 0;
        }
        
        $breakdown_data = $this->biomedical_model->get_last_breakdown_maintaince_data($args_odometer);
         if (!empty($breakdown_data[0]->mt_end_odometer)) {
            $data['previous_breakdown_odometer'] = $breakdown_data[0]->mt_end_odometer;
        } else {
            $data['previous_breakdown_odometer'] = 0;
        }


        
        $data['amb_status'] = $amb_details['amb_status'];
        $this->output->add_to_position($this->load->view('frontend/amb/eqp_amb_odometer_view', $data, TRUE), 'ambu_start_end_record', TRUE);
    }
    function show_ambulance_odometer() {
        $amb_details = $this->input->post();

        $args_odometer = array('rto_no' => $amb_details['amb_id']);
        $amb_odometer = $this->amb_model->get_amb_odometer($args_odometer);
        if (!empty($amb_odometer[0]->end_odmeter)) {
            $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;
        } else {
            $data['previous_odometer'] = 0;
        }

        $data['amb_status'] = $amb_details['amb_status'];
        $this->output->add_to_position($this->load->view('frontend/amb/amb_odometer_view', $data, TRUE), 'ambu_start_end_record', TRUE);
    }

    function show_ambulance_change_status() {
        $amb_details = $this->input->post();
        $data['amb_status'] = $amb_details['amb_status'];
        $this->output->add_to_position($this->load->view('frontend/amb/show_ambulance_change_status', $data, TRUE), 'ambu_start_end_record', TRUE);
    }

    function show_other_odometer() {
        $this->output->add_to_position($this->load->view('frontend/amb/other_odometer_view', $data, TRUE), 'odometer_remark_other_textbox', TRUE);
    }

    function save_change_status() {

        $amb_details = $this->input->post();
        $amb_id = base64_decode($amb_details['amb_id']);

        $data = array(
            'amb_id' => $amb_id,
            'amb_status' => $amb_details['amb_status'],
        );



        if ($amb_details['amb_status'] == '7' || $amb_details['amb_status'] == '8' || $amb_details['amb_status'] == '4') {

            $total_km = '';
            if ($amb_details['previous_odmeter'] < $amb_details['end_odmeter']) {
                $total_km = $amb_details['end_odmeter'] - $amb_details['previous_odmeter'];
            }

            if ($amb_details['amb_status'] == '7') {

                $amb_details['previous_odmeter'] = $amb_details['start_odmeter'];

                $amb_update_summary = array(
                    'amb_rto_register_no' => $amb_details['amb_reg_no'],
                    'amb_status' => $amb_details['amb_status'],
                    'start_odometer' => $amb_details['start_odmeter'],
                    'off_road_status' => "Ambulance off road",
                    'off_road_remark' => $amb_details['remark'],
                    'common_other_remark_all' => $amb_details['common_remark_other'],
                    'off_road_date' => date('Y-m-d', strtotime($amb_details['odometer_date'])),
                    'off_road_time' => date('H:i:s', strtotime($amb_details['odometer_time'])),
                    'added_date' => date('Y-m-d H:i:s'));

                if (!empty($amb_details['remark_other'])) {
                    $amb_update_summary['off_road_remark_other'] = $amb_details['remark_other'];
                }

                $add_summary = $this->amb_model->insert_amb_staus_summary($amb_update_summary);
            } else if ($amb_details['amb_status'] == '8') {

                $amb_summary = array(
                    'amb_rto_register_no' => $amb_details['amb_reg_no'],
                    'amb_status' => '7,8',
                    'end_odometer' => $amb_details['end_odmeter'],
                    'off_road_status' => "Ambulance off road",
                    'on_road_status' => "Ambulance on road",
                    'on_road_remark' => $amb_details['remark'],
                    'common_other_remark_all' => $amb_details['common_remark_other'],
                    'on_road_date' => date('Y-m-d', strtotime($amb_details['odometer_date'])),
                    'on_road_time' => date('H:i:s', strtotime($amb_details['odometer_time'])),
                    'modify_date' => date('Y-m-d H:i:s'));

                if (!empty($amb_details['remark_other'])) {
                    $amb_summary['on_road_remark_other'] = $amb_details['remark_other'];
                }

                $add_summary = $this->amb_model->update_amb_staus_summary($amb_summary);
            }



            $amb_record_data = array(
                'amb_rto_register_no' => $amb_details['amb_reg_no'],
                'start_odmeter' => $amb_details['previous_odmeter'],
                'end_odmeter' => $amb_details['end_odmeter'],
                'total_km' => $total_km,
                'remark' => $amb_details['remark'],
                'odometer_date' => date('Y-m-d', strtotime($amb_details['odometer_date'])),
                'odometer_time' => date('H:i:s', strtotime($amb_details['odometer_time'])),
                'timestamp' => date('Y-m-d H:i:s'));

            if ($amb_details['amb_status'] == '7') {
                $amb_record_data['start_odmeter'] = $amb_details['start_odmeter'];
                $amb_record_data['end_odmeter'] = $amb_details['start_odmeter'];
            }
            if ($amb_details['amb_status'] == '8') {
                $amb_record_data['start_odmeter'] = $amb_details['previous_odmeter'];
                $amb_record_data['end_odmeter'] = $amb_details['end_odmeter'];
            }

            if (!empty($amb_details['remark_other'])) {
                $amb_record_data['other_remark'] = $amb_details['remark_other'];
            }

            $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
        } else {
            $args_odometer = array('rto_no' => $amb_details['amb_reg_no']);

            $amb_odometer = $this->amb_model->get_amb_odometer($args_odometer);
            //var_dump($amb_odometer);
            if (!empty($amb_odometer[0]->end_odmeter)) {
                $previous_odometer = $amb_odometer[0]->end_odmeter;
            } else {
                $previous_odometer = 0;
            }

            if ($amb_details['amb_status'] == '9') {

                $amb_details['previous_odmeter'] = $amb_details['start_odmeter'];

                $amb_update_summary = array(
                    'amb_rto_register_no' => $amb_details['amb_reg_no'],
                    'amb_status' => $amb_details['amb_status'],
                    'start_odometer' => $previous_odometer,
                    'end_odometer' => $previous_odometer,
                    'off_road_status' => "EMSO Not Available",
                    'off_road_remark' => $amb_details['remark'],
                    'common_other_remark_all' => $amb_details['common_remark_other'],
                    'off_road_date' => date('Y-m-d', strtotime($amb_details['odometer_date'])),
                    'off_road_time' => date('H:i:s', strtotime($amb_details['odometer_time'])),
                    'added_date' => date('Y-m-d H:i:s'));

                if (!empty($amb_details['remark_other'])) {
                    $amb_update_summary['off_road_remark_other'] = $amb_details['remark_other'];
                }

                $add_summary = $this->amb_model->insert_amb_staus_summary($amb_update_summary);
            } else if ($amb_details['amb_status'] == '1') {

                $amb_summary = array(
                    'amb_rto_register_no' => $amb_details['amb_reg_no'],
                    'amb_status' => '1,9',
                    'start_odometer' => $previous_odometer,
                    'end_odometer' => $previous_odometer,
                    'off_road_status' => "EMSO Not Available",
                    'on_road_status' => "Available",
                    'on_road_remark' => $amb_details['common_remark_other'],
                    // 'common_other_remark_all'  => $amb_details['common_remark_other'],
                    'on_road_date' => date('Y-m-d', strtotime($amb_details['odometer_date'])),
                    'on_road_time' => date('H:i:s', strtotime($amb_details['odometer_time'])),
                    'modify_date' => date('Y-m-d H:i:s'));

                if (!empty($amb_details['remark_other'])) {
                    $amb_summary['on_road_remark_other'] = $amb_details['remark_other'];
                }

                $add_summary = $this->amb_model->update_amb_emos_staus_summary($amb_summary);
            } else {
                $amb_update_summary = array(
                    'amb_rto_register_no' => $amb_details['amb_reg_no'],
                    'amb_status' => $amb_details['amb_status'],
                    'on_road_date' => date('Y-m-d', strtotime($amb_details['odometer_date'])),
                    'on_road_time' => date('H:i:s', strtotime($amb_details['odometer_time'])),
                    'on_road_remark' => $amb_details['remark'],
                    'common_other_remark_all' => $amb_details['common_remark_other'],
                    'start_odometer' => $previous_odometer,
                    'end_odometer' => $previous_odometer,
                    'added_date' => date('Y-m-d H:i:s'));


                $add_summary = $this->amb_model->insert_amb_staus_summary($amb_update_summary);
            }
        }
        $update = $this->amb_model->update_amb($data);
        if ($update) {
            $this->output->closepopup = 'yes';
            $this->output->status = 1;
            $this->output->message = "<div class='success'>" . "Ambulance status updated successfully" . "<script>window.location.reload(true);</script></div>";
            //$this->ero_dash();
        }
    }

    function get_caller_details() {

  
        $this->session->unset_userdata('caller_details');
       // $clg_user_type = $this->clg->clg_user_type;
       $data['caller_details'] = array();
       $data['blood_gp'] = $this->call_model->get_bloodgp();
        
       $clg_group = $this->clg->clg_group;
        
        if($clg_group == 'UG-ERO' ||  $clg_group == 'UG-BIKE-ERO' || $clg_group == 'UG-ERCTRAINING'){
           $clg_user_type = '108'; 
        }else if($clg_group == 'UG-ERO-102'){
            $clg_user_type = '102'; 
        }else if($clg_group == 'UG-ERO-HD'){
            $clg_user_type = 'hd'; 
        }else if($clg_group == 'UG-REMOTE')
        {
            $clg_user_type = 'Remote';  
        }else if($clg_group == 'UG-ERO-104')
        {
            $clg_user_type = '104';  
        }else{
            $clg_user_type = '102,108';
        }
        $data['clg_user_type']=$clg_user_type;
        $parent_args = array('p_systen'=>$clg_user_type);

        $data['purpose_of_calls'] = $this->call_model->get_parent_purpose_of_calls($parent_args);
        
       

        $m_no = $this->input->post('caller');
       
        $patient = $this->input->post('patient');
        //var_dump($patient['gender']);
        $caller_details_data = array('clr_fname' => $patient['first_name'],
             'clr_mname' => $patient['middle_name'],
             'clr_lname' => $patient['last_name'],
            // 'clr_full_name' => $patient->ptn_fullname,
             'patient_gender' => $patient['gender'],
             'patient_dob' => $patient['dob'],
             'patient_age' => $patient['age']);

  


        
        if (isset($m_no)) {
            $data['m_no'] = $m_no["cl_mobile_number"];
        } else {
            $data['m_no'] = $this->input->get('m_no');
        }
       
         if(empty($patient['first_name'])){
                $booking_args = array('mobile_no'=> $data['m_no']);
                $booking_data = $this->call_model->get_booking_details($booking_args);  
         
                
                if(!empty($booking_data)){

                   if( $booking_data[0]->user_req_usertype == '2'){
                        $caller_details_data = array('first_name' => $booking_data[0]->fam_f_name,
                        'middle_name' => $booking_data[0]->fam_f_name,
                        'last_name' => $booking_data[0]->fam_l_name,
                        'clr_fname' => $booking_data[0]->fam_f_name,
                        'clr_lname' => $booking_data[0]->fam_l_name,
                        'ayu_id'=> $booking_data[0]->fam_ayushman_id,
                       // 'clr_full_name' => $patient->ptn_fullname,
                        'age_type' => 'Years',
                        'patient_gender' => $booking_data[0]->fam_gender,
                        'patient_dob' => $booking_data[0]->fam_f_name,
                        'patient_age' => $booking_data[0]->fam_age);
                    }else{
                         $caller_details_data = array('first_name' => $booking_data[0]->f_name,
                        'last_name' => $booking_data[0]->l_name,
                        'clr_fname' => $booking_data[0]->f_name,
                         'clr_lname' => $booking_data[0]->l_name,
                        'ayu_id'=> $booking_data[0]->user_ayushman_id,
                       // 'clr_full_name' => $patient->ptn_fullname,
                        'age_type' => 'Years',
                        'patient_gender' => $booking_data[0]->gender,
                        'patient_age' => $booking_data[0]->age);
                    }
   
                         $data['services'] = $this->common_model->get_services();
                         $data['questions'] = $this->call_model->get_active_questions($booking_data[0]->user_req_chiefcomplaint);
                }
         }
         
                $data['caller_details_data'] = $caller_details_data;
        $form_call_data = $this->input->post('caller');
        $parent_purpose=$form_call_data['parent_purpose'];
        

        if (isset($form_call_data)) {

            //$mobile_no = explode('+91', $form_call_data['cl_mobile_number']);
            $mobile_no = $form_call_data['cl_mobile_number'];
            $data['m_no'] = $mobile_no;
        }
        $data['cl_purpose'] = $form_call_data['cl_purpose'];
         $data['parent_purpose'] = $form_call_data['parent_purpose'];
         
         
        $pur_args=array('p_parent'=>$form_call_data['parent_purpose'],'p_systen'=>$clg_user_type);
        $data['child_purpose_of_calls'] = $this->call_model->get_purpose_of_calls($pur_args);

       /* $m_lenght = strlen($data['m_no']);
        if($m_lenght < 10)
        {
            $this->output->message = "<div class='error'>Please Enter Caller No 10 Digit</div>";
            return false;
        }*/
        $data['caller_details'] = $this->call_model->get_caller_details($data['m_no']);
           
        if(empty($data['caller_details'])){  
            $data['caller_details'] = array('clr_fname' => "Unknown");
           
        }
        
  $this->session->set_userdata('caller_details_data',  (array)$data['caller_details']);
//   
//        $data['emt_details'] = $this->call_model->get_emt_user_details($data['m_no']);

        $data['attend_call_time'] = $this->session->userdata('attend_call_time');


        if (($data['caller_details']) != '') {

            $this->output->add_to_position($this->load->view('frontend/calls/caller_details_view', $data, TRUE), 'caller_details', TRUE);
        } else {
//            $data['caller_details'] = (object) array(
//                    'clr_fname' => 'Unknown'
//            );

            $this->output->add_to_position($this->load->view('frontend/calls/caller_details_view', $data, TRUE), 'caller_details', TRUE);
        }
        
        
        if($parent_purpose == "EMG" || $parent_purpose == "PREGANCY_CARE_CALL" || $parent_purpose == "Child_CARE" || $parent_purpose == "DROP_BACK_CALL" || $parent_purpose == "HELP_EME_INFO"){
          // echo "hi";
           // $this->output->add_to_position($this->load->view('frontend/calls/common_patient_info', $data, TRUE), 'call_common_info', TRUE);
            //$this->output->add_to_position('', 'content', TRUE);
        }else{
            // echo "hisd";
            //$this->output->add_to_position('&nbsp;', 'call_common_info', TRUE);
            $this->output->add_to_position($this->load->view(' ', TRUE), 'call_common_info', TRUE);
            
           // $this->output->add_to_position('', 'content', TRUE);
        }
               
        if($form_call_data['parent_purpose'] == 'EMG'){
            $this->output->add_to_position('Waiting for LBS location...', 'procesing_lbs', TRUE); 
        }
         
        
      
        $this->output->set_focus_to = "caller_relation";
    }

    function ero108() {
        $datetime = date('Y-m-d H:i:s');

        $data = array();

        $date = str_replace('-', '', date('Y-m-d'));
        $data['event_id'] = $date . '1';
        $data['event_id'] = "";

        $data['result'] = $this->amb_model->get_amb_working_area($data);




        $this->output->add_to_position($this->load->view('frontend/ero108/ero108_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "calls";
    }

    function save_ero108() {




        $event_details = $this->input->post();

        $datetime = date('Y-m-d H:i:s');

        $data_event = $this->get_event_details(trim($event_details['event_id']));

        $is_event_exist = $this->inc_model->get_incident_by_event_id(trim($event_details['event_id']));

        if ($data_event["caller"] == "" && $data_event['district'] == "" && $data_event['state'] == "" && $data_event['city_town'] == "") {


            $this->output->message = "<h3>Event</h3><br><p>Insufficient data for add event</p>";

            return;
        }
        if (!empty($is_event_exist)) {
            $this->output->message = "<h3>Event</h3><br><p>Dublicate Event Id</p>";
            return;
        }


        if (isset($data_event) && isset($data_event["caller"]) && empty($is_event_exist)) {

            $data['caller_details'] = $this->call_model->get_caller_details($data_event['informer_number']);
            if (empty($data['caller_details'])) {

                $caller_name = explode(' ', $data_event['caller_name']);


                $caller_data = array('clr_mobile' => $data_event['caller'],
                    'clr_fullname' => $data_event['caller_name'] ? $data_event['caller_name'] : 'NA',
                );

                $data['caller_id'] = $this->call_model->insert_caller_details($caller_data);
            } else {
                $data['caller_id'] = $data['caller_details']->clr_id;
            }

            $call_data = array('cl_base_month' => $this->post['base_month'],
                'cl_clr_id' => $data['caller_id'],
                'clr_ralation' => $data_event['relation_type'] ? $data_event['relation_type'] : 'NA',
                'cl_purpose' => $data_event['cl_purpose'] ? $data_event['cl_purpose'] : 'nonmci',
                'cl_datetime' => $data_event['incident_date_time'] ? $data_event['incident_date_time'] : $datetime
            );

            $call_id = $data['call_id'] = $this->call_model->insert_call_details($call_data);

            $state_id = $this->inc_model->get_state_id($data_event['state']);

            if ($data_event['district'] != '')
                $district_id = $this->inc_model->get_district_id($data_event['district'], $state_id->st_code);
            $city_id = $this->inc_model->get_city_id($data_event['city_town'], $district_id->dst_code);
            $comp_id = $this->inc_model->get_chief_comp_service_by_name($data_event["med_patient_information"][0]["chief_complaint_type_ero"]);

            //$inc_address = $data_event['house'].', '. $data_event['lane_street'].', '. $data_event['landmark'].', '. $data_event['locality'].', '. $data_event['city_town'].' '. $data_event['district'].', '. $data_event['state'];
            $address_array = array($data_event['lane_street'], $data_event['locality'], $data_event['city_town'], $data_event['district'], $data_event['state']);
            $address_array = array_unique($address_array);

            $inc_address = implode(",", $address_array);
            // $inc_address = trim($data_event['lane_street'].', '.$data_event['locality'].', '. $data_event['city_town'].' '. $data_event['district'].', '. $data_event['state'],',');

            $google_api_key = 'AIzaSyDv9VS1rKXBfGTdDbZ5wB-sKAXambQjO8M';
            $address = urlencode($inc_address);
            $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$address&key=$google_api_key";

            $searched_address = $this->_send_curl_request($url, '', 'get');
            $searched_address = json_decode($searched_address, true);


            $inc_lat = $searched_address['results'][0]['geometry']['location']['lat'];
            $inc_lng = $searched_address['results'][0]['geometry']['location']['lng'];
            if (count($data_event['patient_info']) > 0) {
                $patien_cnt = count($data_event['patient_info']);
            } else {
                $patien_cnt = 1;
            }


            $inc_id = generate_inc_ref_id();
            update_inc_ref_id($inc_id);
            $date = str_replace('-', '', date('Y-m-d'));
            $inc_id = $inc_id;

            $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_id,
                'inc_patient_cnt' => $patien_cnt,
                'inc_type' => 'non-mci',
                'inc_ero_summary' => $data_event['remarks'] ? $data_event['remarks'] : 'NA',
                'inc_city' => $data_event['city_town'] ? $data_event['city_town'] : 'NA',
                'inc_city_id' => $city_id->cty_id ? $city_id->cty_id : '',
                'inc_state' => $data_event['state'] ? $data_event['state'] : 'NA',
                'inc_state_id' => $state_id->st_code ? $state_id->st_code : '',
                'inc_address' => $inc_address,
                'inc_district' => $data_event['district'],
                'inc_district_id' => $district_id->dst_code ? $district_id->dst_code : '',
                'inc_area' => $data_event['locality'] ? $data_event['locality'] : 'NA',
                'inc_landmark' => $data_event['landmark'] ? $data_event['landmark'] : 'NA',
                'inc_lane' => $data_event['lane_street'] ? $data_event['lane_street'] : 'NA',
                'inc_h_no' => $data_event['house'] ? $data_event['house'] : 'NA',
                //'inc_datetime' => $data_event['incident_date_time']?$data_event['incident_date_time']:$datetime,
                'inc_base_month' => $this->post['base_month'],
                'inc_bvg_ref_number' => $event_details['event_id'],
                'inc_call_type' => $event_details['call_type'] ? $event_details['call_type'] : 'NA',
                'inc_lat' => $inc_lat,
                'inc_long' => $inc_lng,
                'inc_complaint' => $comp_id[0]->ct_id ? $comp_id[0]->ct_id : 'NA');
            $inc_data = $this->inc_model->insert_inc($incidence_details);

            _ucd_assign_call($inc_id);



            $args = array(
                'sub_id' => $inc_id,
                'operator_id' => $this->clg->clg_ref_id,
                'operator_type' => $this->clg->clg_group,
                'sub_status' => 'ASG',
                'sub_type' => "non-mci",
                'base_month' => $this->post['base_month']
            );
            $res = $this->common_model->assign_operator($args);

            $pilot_ref_id = "pilot";
            $EMT_ref_id = "EMT";
            $pilot = array();
            $EMT = array();

            if (!empty($data_event['pilot'])) {
                $pilot = $this->call_model->get_user_info_inc($data_event['pilot'], 'UG-PILOT');
            }
            if (!empty($data_event['emso'])) {
                $EMT = $this->call_model->get_user_info_inc($data_event['emso'], 'UG-EMT');
            }

            if (!empty($pilot)) {
                $pilot_ref_id = $pilot[0]->clg_ref_id;
                $pilot_args = array(
                    'sub_id' => $inc_id,
                    'operator_id' => $pilot[0]->clg_ref_id . '',
                    'operator_type' => 'UG-PILOT',
                    'sub_status' => 'ASG',
                    'sub_type' => 'non-mci',
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($pilot_args);
            }

            if (!empty($EMT)) {
                $EMT_ref_id = $EMT[0]->clg_ref_id;
                $emt_args = array(
                    'sub_id' => $inc_id,
                    'operator_id' => $EMT[0]->clg_ref_id,
                    'operator_type' => 'UG-EMT',
                    'sub_status' => 'ASG',
                    'sub_type' => "non-mci",
                    'base_month' => $this->post['base_month']
                );
                $res = $this->common_model->assign_operator($emt_args);
            }
            if (!empty($data_event['med_patient_information'])) {

                foreach ($data_event['med_patient_information'] as $med_patient_information) {

                    $incidence_amb_details = array('amb_rto_register_no' => $med_patient_information['vehicle'],
                        'inc_ref_id' => $inc_id,
                        'amb_pilot_id' => $pilot_ref_id,
                        'amb_emt_id' => $EMT_ref_id,
                        'inc_base_month' => $this->post['base_month'],
                        'assigned_time' => $data_event['incident_date_time'],
                        'amb_status' => 'current'
                    );


                    $this->inc_model->insert_inc_amb($incidence_amb_details);
                }
            }
            if (!empty($data_event['patient_info'])) {

                foreach ($data_event['patient_info'] as $patient) {

                    if (!empty($patient['age'])) {
                        $age = explode(' ', $patient['age']);
                    }
                    if (!empty($patient['gender'])) {
                        if ($patient['gender'] == 'Male') {
                            $gender = 'M';
                        } else {
                            $gender = 'F';
                        }
                    }
                    $patient_details = array('ptn_fullname' => $patient['patient_name'],
                        'ptn_gender' => $gender,
                        'ptn_age' => $age[0]);
                    $pat_details = $this->Pet_model->insert_patient_details($patient_details);
                    $incidence_patient = array('inc_id' => $inc_id,
                        'ptn_id' => $pat_details);
                    $this->Pet_model->insert_inc_pat($incidence_patient);
                }
            }

            $this->output->status = 1;
            $this->output->closepopup = "yes";
            $msg = "Added";
            $this->output->message = "<h3>Event</h3><br><p>Event " . $msg . " successfull.</p>";
            $this->output->moveto = 'top';

            $this->output->add_to_position($this->load->view('frontend/ero108/ero108_view', $data, TRUE), 'content', TRUE);
            $this->output->template = "calls";
            //$this->output->add_to_position('', 'content', TRUE);
        } else {

            $this->output->status = 1;
            $this->output->closepopup = "yes";
            $this->output->message = "<h3>Event</h3><br><p>Insufficient data for add event Or Dublicate Event Id</p>";
            $this->output->moveto = 'top';

            $this->output->add_to_position($this->load->view('frontend/ero108/ero108_view', $data, TRUE), 'content', TRUE);
            $this->output->template = "calls";
        }
    }

    function get_event_details($event_id) {

        $event_api_url = $this->config->item('event_api_url');

        $event_api_url = $event_api_url . '&eventid=' . $event_id;
        $site_html = file_get_contents('event_test/event_resp.html');
        //$site_html = file_get_contents($event_api_url);
        //$site_html =  $this->_send_curl_request($event_api_url,'','get');

        $dom = new DOMDocument();
        @$dom->loadHTML($site_html);
        $domxpath = new DOMXPath($dom);


        $event_data = array();

// Hiddend input field values
        $hidden_inputs = $domxpath->query('//input[@type="hidden"]');
        foreach ($hidden_inputs as $input_field) {

            $field_name = $input_field->getAttribute('name');
            if ($field_name == 'hidmodule_id') {
                $field_value = $input_field->getAttribute('value');
                $event_data['module_id'] = $field_value;
            }
            if ($field_name == 'hiduserid_id') {
                $field_value = $input_field->getAttribute('value');
                $event_data['user_id'] = $field_value;
            }
            if ($field_name == 'hidventid1') {
                $field_value = $input_field->getAttribute('value');
                $event_data['event_id'] = $field_value;
            }
            if ($field_name == 'hidventid2') {
                $field_value = $input_field->getAttribute('value');
                $event_data['event_id_2'] = $field_value;
            }
        }


// Incident details
        $inc_fields = $domxpath->query('//form/table/table/tr[not(@class)]/td[@colspan!="4"] | //form/table/table/tr[not(@class)]/td[not(@colspan)] | //form/table/table/tbody/tr[not(@class)]/td[@colspan!="4"] | //form/table/table/tbody/tr[not(@class)]/td[not(@colspan)]');

        $field_name = '';
        $field_value = '';
        foreach ($inc_fields as $key => $field) {

            if (($key + 1) % 2 == 0) {
                $field_value = trim($field->nodeValue);
                $new_field = array($field_name => $field_value);
                $event_data = array_merge($event_data, $new_field);
                $field_name = '';
                $field_value = '';
            } else {
                $field_name = $this->sanitize($field->nodeValue);
            }
        }


// Patient Details
        $inc_petient_fields_tr = $domxpath->query('//form/table/table/tr/td[@colspan="4"]/table/tr | //form/table/table/tbody/tr/td[@colspan="4"]/table/tbody/tr');

        $petient_fields = array();
        $petient_fields_keys = array('s_no', 'patient_id', 'patient_name', 'age', 'gender');
        $petient_fields_values = array();
        foreach ($inc_petient_fields_tr as $key => $field_row) {

            if ($key == 0) {
                continue;
            }

            $field_row_fields = $field_row->childNodes;
            $petient_fields_values = array();
            foreach ($field_row_fields as $pr_field) {
                if ($pr_field->nodeName == 'td') {
                    $petient_fields_values[] = trim($pr_field->nodeValue);
                }
            }

            $petient_fields[] = array_combine($petient_fields_keys, $petient_fields_values);
        }
        $event_data['patient_info'] = $petient_fields;



// Medical Details

        $med_petient_fields_trs = $domxpath->query('//table//div[@class="tabber"]/div[@class="tabbertab"][1]//tr');

        $med_petient_fields = array();
        $event_data_key = '';

        foreach ($med_petient_fields_trs as $key => $med_petient_fields_tr) {

            if ($med_petient_fields_tr->nodeName != 'tr') {
                continue;
            }

            $tr_class = $med_petient_fields_tr->getAttribute('class');

            // Data array key
            if ($tr_class == 'trcolor') {
                $event_data_key = 'med_' . $this->sanitize($med_petient_fields_tr->nodeValue);
            }

            if ($tr_class == 'drContent1') {

                // Keys
                $med_petient_fields_keys = array();
                $field_col_fields = $med_petient_fields_tr->childNodes;
                foreach ($field_col_fields as $pr_field) {
                    if ($pr_field->nodeName == 'td') {
                        $med_petient_fields_keys[] = $this->sanitize($pr_field->nodeValue);
                    }
                }
            }

            if (!$med_petient_fields_tr->hasAttribute('class')) {

                // Values
                $med_petient_fields_values = array();
                $field_col_fields = $med_petient_fields_tr->childNodes;
                foreach ($field_col_fields as $pr_field) {
                    if ($pr_field->nodeName == 'td') {
                        $med_petient_fields_values[] = trim($pr_field->nodeValue);
                    }
                }

                $event_data[$event_data_key][] = array_combine($med_petient_fields_keys, $med_petient_fields_values);
            }
        }
        return $event_data;
    }

    function sanitize($string) {
        $string = strtolower(preg_replace('/[^A-Za-z0-9_]+/', '_', trim($string)));
        return trim($string, '_');
    }

    /* "Check call in dispatch proccess" */

    function get_incoming_calls() {

        $atend_user = $this->session->userdata('current_user');
        
        if ($atend_user->clg_group == 'UG-COUNSELOR-104') {


            $args = array(
                'clg_ref_id' => $atend_user->clg_ref_id,
                'clg_group' => 'UG-COUNSELOR-104',
                'base_month' => $this->post['base_month'],
            );
          
            $data['COUNSLOR_DATA'] = $this->common_model->get_counsler_104($args);
            
            $data['COUNSLOR_CALL_DATA'] = $this->common_model->get_counsler_calls_104($args);

            $data['adv_call'] = "yes";
            $this->output->add_to_position($this->load->view('frontend/calls/counslor_call_view', $data, TRUE), 'incoming_call_nav', TRUE);
        } 
        if ($atend_user->clg_group == 'UG-ERCP-104') {


            $args = array(
                'clg_ref_id' => $atend_user->clg_ref_id,
                'clg_group' => 'UG-ERCP-104',
                'base_month' => $this->post['base_month'],
            );
          
            $data['ERO_data'] = $this->common_model->get_ercp_104($args);
            
            $data['ERO_data_calls'] = $this->common_model->get_ercp_calls_104($args);

            $data['adv_call'] = "yes";

            $this->output->add_to_position($this->load->view('frontend/calls/adv_call_view', $data, TRUE), 'incoming_call_nav', TRUE);


           // $this->output->add_to_position("<span>ERCP Call </span>", 'section_title', TRUE);
        } 
        else if ($atend_user->clg_group == 'UG-ERCP') {


            $args = array(
                'clg_ref_id' => $atend_user->clg_ref_id,
                'clg_group' => 'UG-ERCP',
                'base_month' => $this->post['base_month'],
            );
          
            $data['ERO_data'] = $this->common_model->get_ercp($args);
          //  var_dump($data['ERO_data']);
           // die();
            
            
            $data['ERO_data_calls'] = $this->common_model->get_ercp_calls($args);
            
            
            $data['dco_ERO_data'] = $this->common_model->get_dcosupervisor_calls($args);
            
            
            

            $data['adv_call'] = "yes";

            $this->output->add_to_position($this->load->view('frontend/calls/adv_call_view', $data, TRUE), 'incoming_call_nav', TRUE);


           // $this->output->add_to_position("<span>ERCP Call </span>", 'section_title', TRUE);
        } else if ($atend_user->clg_group == 'UG-PDA') {


            $args = array(
                'clg_ref_id' => $atend_user->clg_ref_id,
                'clg_group' => 'UG-PDA',
                'base_month' => $this->post['base_month'],
            );
            $data['ERO_data'] = $this->common_model->get_police_calls($args);


            if (empty($data['ERO_data'])) {
                
            }

            $data['adv_call'] = "yes";

            $this->output->add_to_position($this->load->view('frontend/calls/police_call_view', $data, TRUE), 'incoming_call_nav', TRUE);


            //$this->output->add_to_position("<span>Police Call </span>", 'section_title', TRUE);
        } else if ($atend_user->clg_group == 'UG-FDA') {


            $args = array(
                'clg_ref_id' => $atend_user->clg_ref_id,
                'clg_group' => 'UG-FDA',
                'base_month' => $this->post['base_month'],
            );
            $data['ERO_data'] = $this->common_model->get_fire_calls($args);


            if (empty($data['ERO_data'])) {
                
            }

            $data['adv_call'] = "yes";

            $this->output->add_to_position($this->load->view('frontend/calls/fire_call_view', $data, TRUE), 'incoming_call_nav', TRUE);


            //$this->output->add_to_position("<span>Fire Call </span>", 'section_title', TRUE);
        } else if ($atend_user->clg_group == 'UG-SITUATIONAL-DESK') {


            $args = array(
                'clg_ref_id' => $atend_user->clg_ref_id,
                'clg_group' => 'UG-SITUATIONAL-DESK',
                'base_month' => $this->post['base_month'],
            );
            $data['ERO_data'] = $this->common_model->get_situaltional_calls($args);


            if (empty($data['ERO_data'])) {
                
            }

            $data['adv_call'] = "yes";

            $this->output->add_to_position($this->load->view('frontend/calls/situational_desk_call_view', $data, TRUE), 'incoming_call_nav', TRUE);


            //$this->output->add_to_position("<span>Fire Call </span>", 'section_title', TRUE);
        } else if ($atend_user->clg_group == 'UG-Grievance') {


            $args = array(
                'clg_ref_id' => $atend_user->clg_ref_id,
                'clg_group' => 'UG-Grievance',
                'base_month' => $this->post['base_month'],
            );



            $data['ERO_data'] = $this->common_model->get_grieviance_calls($args);


            if (empty($data['ERO_data'])) {
                
            }

            $data['adv_call'] = "yes";

            $this->output->add_to_position($this->load->view('frontend/calls/griviance_call_view', $data, TRUE), 'incoming_call_nav', TRUE);


            //$this->output->add_to_position("<span>Grievance Call </span>", 'section_title', TRUE);
        }else if ($atend_user->clg_group == 'UG-EROSupervisor') {


            $args = array(
                'clg_ref_id' => $atend_user->clg_ref_id,
                'clg_group' => 'UG-EROSupervisor',
                'base_month' => $this->post['base_month'],
            );


            $data['ERO_data'] = $this->common_model->get_erosupervisor_calls($args);


            if (empty($data['ERO_data'])) {
                
            }

            $data['adv_call'] = "yes";

            $this->output->add_to_position($this->load->view('frontend/calls/erosupervisor_call_view', $data, TRUE), 'incoming_call_nav', TRUE);


          //  $this->output->add_to_position("<span>ERO Supervisor </span>", 'section_title', TRUE);
        }else if ($atend_user->clg_group == 'UG-ShiftManager') {


            $args = array(
                'clg_ref_id' => $atend_user->clg_ref_id,
                'clg_group' => 'UG-ShiftManager',
                'base_month' => $this->post['base_month'],
            );



            $data['ERO_data'] = $this->common_model->get_shiftmanager_calls($args);


            if (empty($data['ERO_data'])) {
                
            }

            $data['adv_call'] = "yes";

            $this->output->add_to_position($this->load->view('frontend/calls/shiftmanager_call_view', $data, TRUE), 'incoming_call_nav', TRUE);


            //$this->output->add_to_position("<span>ShiftManager </span>", 'section_title', TRUE);
        }else if ($atend_user->clg_group == 'UG-DCO') {


            $args = array(
                'clg_ref_id' => $atend_user->clg_ref_id,
                'clg_group' => 'UG-DCO',
                'base_month' => $this->post['base_month'],
            );
            $data['ERO_data'] = $this->common_model->get_dcosupervisor_calls($args);

            $data['adv_call'] = "yes";

            $this->output->add_to_position($this->load->view('frontend/calls/dcosupervisor_call_view', $data, TRUE), 'incoming_call_nav', TRUE);

           // $this->output->add_to_position("<span>DCO  </span>", 'section_title', TRUE);
            
            
        }else if ($atend_user->clg_group == 'UG-DCOSupervisor') {


            $args = array(
                'clg_ref_id' => $atend_user->clg_ref_id,
                'clg_group' => 'UG-DCOSupervisor',
                'base_month' => $this->post['base_month'],
            );
            $data['ERO_data'] = $this->common_model->get_dcosupervisor_calls($args);

            $data['adv_call'] = "yes";

            $this->output->add_to_position($this->load->view('frontend/calls/dcosupervisor_call_view', $data, TRUE), 'incoming_call_nav', TRUE);

           // $this->output->add_to_position("<span>DCOSupervisor </span>", 'section_title', TRUE);
            
            
        }else if ($atend_user->clg_group == 'UG-EROSupervisor') {


            $args = array(
                'clg_ref_id' => $atend_user->clg_ref_id,
                'clg_group' => 'UG-EROSupervisor',
                'base_month' => $this->post['base_month'],
            );
            $data['ERO_data'] = $this->common_model->get_dcosupervisor_calls($args);

            $data['adv_call'] = "yes";

            $this->output->add_to_position($this->load->view('frontend/calls/dcosupervisor_call_view', $data, TRUE), 'incoming_call_nav', TRUE);

            //$this->output->add_to_position("<span>EROSupervisor</span>", 'section_title', TRUE);
            
            
        }else if ($atend_user->clg_group == 'UG-PDASupervisor') {


            $args = array(
                'clg_ref_id' => $atend_user->clg_ref_id,
                'clg_group' => 'UG-PDASupervisor',
                'base_month' => $this->post['base_month'],
            );
            $data['ERO_data'] = $this->common_model->get_dcosupervisor_calls($args);

            $data['adv_call'] = "yes";

            $this->output->add_to_position($this->load->view('frontend/calls/dcosupervisor_call_view', $data, TRUE), 'incoming_call_nav', TRUE);

            //$this->output->add_to_position("<span>PDASupervisor </span>", 'section_title', TRUE);
            
            
        }else if ($atend_user->clg_group == 'UG-FDASupervisor') {


            $args = array(
                'clg_ref_id' => $atend_user->clg_ref_id,
                'clg_group' => 'UG-FDASupervisor',
                'base_month' => $this->post['base_month'],
            );
            $data['ERO_data'] = $this->common_model->get_dcosupervisor_calls($args);

            $data['adv_call'] = "yes";

            $this->output->add_to_position($this->load->view('frontend/calls/dcosupervisor_call_view', $data, TRUE), 'incoming_call_nav', TRUE);

            //$this->output->add_to_position("<span>FDASupervisor </span>", 'section_title', TRUE);
            
            
        }else if ($atend_user->clg_group == 'UG-HELPDESK') {


            $args = array(
                'clg_ref_id' => $atend_user->clg_ref_id,
                'clg_group' => 'UG-HELPDESK',
                'base_month' => $this->post['base_month'],
            );
            $data['ERO_data'] = $this->common_model->get_dcosupervisor_calls($args);

            $data['adv_call'] = "yes";

            $this->output->add_to_position($this->load->view('frontend/calls/dcosupervisor_call_view', $data, TRUE), 'incoming_call_nav', TRUE);

           // $this->output->add_to_position("<span>HELPDESK </span>", 'section_title', TRUE);
            
            
        }else if ($atend_user->clg_group == 'UG-ERO-102') {


           
            $inc_data = $this->inc_model->get_incident_ref($atend_user->clg_ref_id);
            $last_inc_data = $this->inc_model->get_last_inc_ref($atend_user->clg_ref_id);
            // _expire_in_dispatch_process();
            $inc_ref = array();
            foreach ($inc_data as $inc) {

                $inc_ref[] = $inc->inc_ref_id . '_' . $inc->id;
            }

            $data['call_queue'] = $inc_ref;

            $data['last_inc_data'] = $last_inc_data[0]->inc_ref_id;

            $this->output->add_to_position($this->load->view('frontend/calls/incoming_call_view', $data, TRUE), 'incoming_call_nav', TRUE);
            
            
        } else if ($atend_user->clg_group == 'UG-ERO-104') {


           
            $inc_data = $this->inc_model->get_incident_ref($atend_user->clg_ref_id);
            $last_inc_data = $this->inc_model->get_last_inc_ref($atend_user->clg_ref_id);
            // _expire_in_dispatch_process();
            $inc_ref = array();
            foreach ($inc_data as $inc) {

                $inc_ref[] = $inc->inc_ref_id . '_' . $inc->id;
            }

            $data['call_queue'] = $inc_ref;

            $data['last_inc_data'] = $last_inc_data[0]->inc_ref_id;

            $this->output->add_to_position($this->load->view('frontend/calls/incoming_call_view', $data, TRUE), 'incoming_call_nav', TRUE);
            
            
        }else if ($atend_user->clg_group == 'UG-EROSupervisor-104') {


            $args = array(
                'clg_ref_id' => $atend_user->clg_ref_id,
                'clg_group' => 'UG-EROSupervisor-104',
                'base_month' => $this->post['base_month'],
            );
            $data['ERO_data'] = $this->common_model->get_dcosupervisor_calls($args);
            

            $data['adv_call'] = "yes";

            $this->output->add_to_position($this->load->view('frontend/calls/ero_104_supervisor_call_view', $data, TRUE), 'incoming_call_nav', TRUE);

            //$this->output->add_to_position("<span>EROSupervisor</span>", 'section_title', TRUE);
            
            
        }else {


            $inc_data = $this->inc_model->get_incident_ref($atend_user->clg_ref_id);
            $last_inc_data = $this->inc_model->get_last_inc_ref($atend_user->clg_ref_id);
            // _expire_in_dispatch_process();
            $inc_ref = array();
            foreach ($inc_data as $inc) {

                $inc_ref[] = $inc->inc_ref_id . '_' . $inc->id;
            }

            $data['call_queue'] = $inc_ref;

            $data['last_inc_data'] = $last_inc_data[0]->inc_ref_id;

            $this->output->add_to_position($this->load->view('frontend/calls/incoming_call_view', $data, TRUE), 'incoming_call_nav', TRUE);
        }
    }
    
    function avaya_get_incoming_calls() {

        $atend_user = $this->session->userdata('current_user');

        if ($atend_user->clg_group == 'UG-ERO' || $atend_user->clg_group == 'UG-ERO-102'|| $atend_user->clg_group == 'UG-ERO-104') {
            
            $avaya_ext = get_cookie("avaya_extension_no");
            $agent_id=$this->clg->clg_avaya_agentid;
            $avaya_campaign=$this->clg->clg_avaya_campaign;
            
            $data = array();
            $current_time = strtotime(date('Y-m-d H:i:s'));

            if (!empty($agent_id)) {

                $ext_no = $avaya_ext;
                
                $args_call = array('agent_no' => $agent_id,'status'=>'R');
                $avaya_call = $this->call_model->get_avaya_call_by_ext($args_call);
                
                $current_call = $this->session->userdata('current_call');

                if ( !empty($avaya_call) && $avaya_call->CallUniqueID != $current_call ) {

                    $this->session->set_userdata('current_call', $avaya_call->CallUniqueID);

                        $data['m_no'] = $avaya_call->calling_phone_no;
                        $data['ext_no'] = $avaya_call->agent_no;
                        $data['CallUniqueID'] = $avaya_call->CallUniqueID;
                        $data["mobile_no"] = $data['m_no'];
                        
                        if($atend_user->clg_group == 'UG-ERO'){
                            $data['cl_purpose'] = 'NON_MCI';
                        }else{
                              $data['cl_purpose'] = 'DROP_BACK';
                        }
                        $this->output->add_to_position($this->load->view('frontend/avaya/call_popup_dialer_view', $data, TRUE), 'dialerscreen', TRUE);

                }else if( empty($avaya_call) && $current_call != "" ){
                    
                    $this->session->set_userdata('current_call', '');
                    $this->output->add_to_position('', 'dialerscreen', TRUE);
                    
                }
            }
        }
    }
    
    function avaya_get_incoming_calls_event(){
        die();
        header("Content-Type: text/event-stream");
        header('Cache-Control: no-cache');
        
        $avaya_ext = get_cookie("avaya_extension_no");
        $agent_id=$this->clg->clg_avaya_agentid;
        $atend_user = $this->session->userdata('current_user');
        
        $this->session->set_userdata('incoming_calls_event',1);
        
        while (1) {

            echo "event:ping".PHP_EOL;
            echo 'data:{"time": "' . time() . '"}'.PHP_EOL;
            echo PHP_EOL;
            
            $incoming_calls_event = $this->session->userdata('incoming_calls_event');
            
            if ( connection_aborted() || connection_status() != CONNECTION_NORMAL || $incoming_calls_event == 0 ){   
                file_put_contents('event.log', 'done');
                exit();    
            }
           // $file_data = file_get_contents('./logs/avaya_call_resp_'.date("Y-m-d").'.log');
     
            if ($atend_user->clg_group == 'UG-ERO' || $atend_user->clg_group == 'UG-ERO-102' || $atend_user->clg_group == 'UG-ERO-104') {
                $data = array();
                $current_time = strtotime(date('Y-m-d H:i:s'));

                if (!empty($agent_id)) {

                    $ext_no = $avaya_ext;
                    $args_call = array('agent_no' => $agent_id,'status'=>'R');
                    
                    //$avaya_call_records = file_get_contents('./logs/'.$agent_id.'_avaya_call_records.json');
                    //$avaya_call_records = json_decode("[{$avaya_call_records}]");
                    //$avaya_call = $avaya_call_records[count($avaya_call_records)-1];
                    
                    $avaya_call = $this->call_model->get_avaya_call_by_ext($args_call);

                    $current_call = $this->session->userdata('current_call');

                    if ( !empty($avaya_call) && $avaya_call->CallUniqueID != $current_call ) {

                        $this->session->set_userdata('current_call', $avaya_call->CallUniqueID);

                        $data['m_no'] = $avaya_call->calling_phone_no;
                        $data['ext_no'] = $avaya_call->agent_no;
                        $data['CallUniqueID'] = $avaya_call->CallUniqueID;
                        $data["mobile_no"] = $avaya_call->calling_phone_no;
                        $data["action"] = 'open_dialer';
                        $data["data_qr"] = "output_position=content&tool_code=mt_atnd_calls&m_no={$avaya_call->calling_phone_no}&ext_no={$avaya_call->agent_no}&CallUniqueID={$avaya_call->CallUniqueID}";
                        
                        $data = json_encode($data);
                        
                        echo "id:".time() . PHP_EOL;
                        echo "data:$data" . PHP_EOL;
                        echo PHP_EOL;
                        
                    }else if( empty($avaya_call) && $current_call != "" ){
                        
                        $data =  json_encode(array('action'=>'hide_dialer'));
 
                        echo "id:".time() . PHP_EOL;
                        echo "data:$data" . PHP_EOL;
                        echo PHP_EOL;
                        
                    }

                }
            }
            
            while (ob_get_level() > 0) {
                ob_end_flush();
            }
            flush();
                       
            usleep(1000000);
            //break;
            
        }
        
        exit();
        
    }
    
    
    function avaya_end_incoming_calls_event(){
        
        $agent_id = $_GET['agentid'];
        $avaya_call_flag=json_encode(array('incoming_calls_event'=>0));
        file_put_contents('./logs/avaya_calls/'.$agent_id.'_flag.json',$avaya_call_flag);
        exit();
    }


    function reassing_calls() {

        $x = 0;
        while ($x < 3) {

            $call_data = $this->call_model->get_calls_to_reassign();

            if ($call_data) {

                foreach ($call_data as $call) {

                    $time_diff = time() - $call->datetime;

                    if ($call->user_ref_id == '0') {
                        $call_res = $this->call_model->update_call_status($call->id, 'unattended');
                        _ucd_assign_call($call->inc_ref_id);
                    } else if ($time_diff > 180) {
                        $call_res = $this->call_model->update_call_status($call->id, 'unattended');
                        _ucd_assign_call($call->inc_ref_id);
                    }
                }

                $x++;
                sleep(15);
            }
        }

        die();
    }

    function left_single_record() {

        $this->output->add_to_position($this->load->view('frontend/calls/inc_search_view', $data, TRUE), 'content', TRUE);
    }

    function caller_record() {
        
        
        $data['all_purpose_of_calls'] = $this->call_model->get_all_child_purpose_of_calls();
        $args = array('clg_group' => 'UG-ERO');
        $data['clg_list'] = $this->colleagues_model->get_clg_data($args);
        $data['default_state'] = $this->default_state; 

        //$this->output->add_to_popup($this->load->view('frontend/calls/caller_search_view', $data, TRUE), '1900', '1700');
          $this->output->add_to_position($this->load->view('frontend/calls/caller_search_view', $data, TRUE), 'content', TRUE);
        $this->output->set_focus_to = "inc_ref_id";
         $this->output->template = "draggable_blank";
    }
        function caller_record_reset() {
        
        
        $data['all_purpose_of_calls'] = $this->call_model->get_all_child_purpose_of_calls();
        $args = array('clg_group' => 'UG-ERO');
        $data['clg_list'] = $this->colleagues_model->get_clg_data($args);
        $data['default_state'] = $this->default_state; 

        //$this->output->add_to_popup($this->load->view('frontend/calls/caller_search_view', $data, TRUE), '1900', '1700');
          $this->output->add_to_position($this->load->view('frontend/calls/caller_search_view', $data, TRUE), 'mydivheader', TRUE);
    }
    
    function caller_record_popup() {
        
        $data['mobile_no'] = $this->input->post('mobile_no');
        $data['all_purpose_of_calls'] = $this->call_model->get_all_child_purpose_of_calls();
        $args = array('clg_group' => 'UG-ERO');
        $data['clg_list'] = $this->colleagues_model->get_clg_data($args);
        $data['default_state'] = $this->default_state; 

        //$this->output->add_to_popup($this->load->view('frontend/calls/caller_search_view', $data, TRUE), '1900', '1700');
          $this->output->add_to_position($this->load->view('frontend/calls/caller_search_popup_view', $data, TRUE), 'popup_div', TRUE);
        $this->output->set_focus_to = "inc_ref_id";
       
    }

    function single_record() {
        $data['clg_group'] = $this->clg->clg_group;
        
        //$this->output->add_to_popup($this->load->view('frontend/calls/inc_search_view', $data, TRUE), '1900', '1700');
           $this->output->add_to_position($this->load->view('frontend/calls/inc_search_view', $data, TRUE), 'content', TRUE);

        $this->output->set_focus_to = "inc_ref_id";
        $this->output->template = "draggable_blank";
    }
    function followupactionpopup(){
        $search_data = $this->input->post();
        //var_dump($this->input->post('inc_ref_id'));die;
        $position = $this->input->post('output_position');
      //  var_dump($position);die();
        
        
        $current_user = $this->clg->clg_ref_id;

        $args = array();
        $data = array('inc_ref_id' => trim($this->input->post('inc_ref_id')),
                      'followup_reason' =>  trim($this->input->post('followup_reason'))              
        );
        $followup_reason = trim($this->input->post('followup_reason'));
        /*if($followup_reason == '7')
        {
            $args = array(
                'inc_ref_id' => trim($this->post['inc_ref_id'])
                
            );
            if ($this->agent->is_mobile()) {
    
                $data['agent_mobile'] = 'yes';
            } else {
    
                $data['agent_mobile'] = 'no';
            }
    
            $data['pt_info'] = $this->pet_model->get_ptinc_info_followup($args);
            //var_dump($data['pt_info']);die();
    
            $data['increfid'] = $this->post['inc_ref_id'];
    
            $data['resource'] = true;
    
            $data['resource_type'] = $this->post['resource_type'];
            $data['inc_amb'] = $this->inc_model->get_inc_ambulance($args);

            
            $this->output->add_to_position($this->load->view('frontend/calls/followupaction_dispatch_view', $data, TRUE), $position, TRUE);
        }
        else{ */
            $this->output->add_to_position($this->load->view('frontend/calls/followupaction_view', $data, TRUE), $position, TRUE);
        //}
    

    }

    function single_record_view(){

       
        $search_data = $this->input->post();
        if(empty($search_data)){
            $search_data = $this->input->get();
        }
        

        $position = $this->input->post('output_position');
     
        if($position == ""){
          $position =   "single_record_details";
        }
        
        $current_user = $this->clg->clg_ref_id;

        $args = array();
        $get['inc_ref_id'] = trim($this->input->get('inc_ref_id'));
       
        if($get['inc_ref_id'] == '')
        {
            $args = array('inc_ref_id' => trim($this->input->post('inc_ref_id')),'from_date'=>$incident_date,'to_date'=>$incident_date);
            $get['inc_ref_id'] = trim($this->input->post('inc_ref_id'));
        }
       else{
        $args = array('inc_ref_id' => trim($this->input->get('inc_ref_id')),'from_date'=>$incident_date,'to_date'=>$incident_date);
         $get['inc_ref_id'] = trim($this->input->get('inc_ref_id'));
       }


        $get_inc_date = str_replace('A-', '', trim( $get['inc_ref_id']));
        $get_inc_date = str_replace('BK-', '', $get_inc_date);
        $year = substr($get_inc_date, 0, 4);
        $month = substr($get_inc_date, 4, 2);
        $date = substr($get_inc_date, 6, 2);
        $incident_date = $year.'-'.$month.'-'.$date;
  
        $data['inc_call_type'] = $this->inc_model->get_inc_ref_id($args);
      
      
       
        if (!empty($data['inc_call_type'])) {

           
               // $data['inc_ref_no'] = $data['inc_ref_id'] ;
                $data['inc_ref_no'] = $data['inc_call_type'][0]->inc_ref_id;
                $data['inc_ref_id'] = $data['inc_call_type'][0]->inc_ref_id;
           
            if ($data['inc_call_type'][0]->inc_type != 'AD_SUP_REQ') {

                $data['inc_details'] = $this->inc_model->get_inc_details_ref_id($args);

            } else {

                $data['inc_details'] = $this->inc_model->get_inc_call_details_ref_id($args);
                
            }
            
            $data['inc_list'] = $this->medadv_model->get_inc_by_ercp($args, $offset, $limit);
            
           if ($data['inc_details'][0]->police_chief_complete != '') {
                $args_police = array('po_ct_id' => $data['inc_details'][0]->police_chief_complete);
                $police_comp = $this->call_model->get_police_chief_comp($args_police);
                $data['po_ct_name'] = $police_comp[0]->po_ct_name;
            }

            if ($data['inc_details'][0]->fire_chief_complete != '') {
                $args_fire = array('fi_ct_id' => $data['inc_details'][0]->fire_chief_complete);
                $fire_comp = $this->call_model->get_fire_chief_comp($args_fire);
                $data['fi_ct_name'] = $fire_comp[0]->fi_ct_name;
            }

           if( $data['inc_details'][0]->inc_ero_standard_summary != ''){
				$args_remark = array('re_id' => $data['inc_details'][0]->inc_ero_standard_summary);
				$standard_remark = $this->call_model->get_ero_summary_remark($args_remark);

				$data['re_name'] = $standard_remark[0]->re_name;
            }
          //  var_dump($data['inc_details'][0]->inc_ero_standard_summary);die();
           // $data['re_name'] = $standard_remark[0]->re_name;
           $standard_remark= $data['inc_details'][0]->inc_ero_standard_summary;
            $data['re_name'] = $standard_remark;
            $args_pur = array('pcode' => $data['inc_details'][0]->cl_purpose);

            $call_pur = $this->inc_model->get_purpose_call($args_pur);
            $data['pname'] = $call_pur[0]->pname;

           
            if($data['inc_details'][0]->inc_suggested_amb != '' && $data['inc_details'][0]->inc_type != 'on_scene_care'){
                $args_amb_type = array('inc_suggested_amb' => $data['inc_details'][0]->inc_suggested_amb);
                $amb_type = $this->inc_model->get_sugg_amb_type($args_amb_type);
                $data['ambt_name'] = $amb_type[0]->ambt_name;
            }

            $args_st = array('st_code' => $data['inc_details'][0]->inc_state_id);
            $state = $this->inc_model->get_state_name($args_st);
            $data['state_name'] = $state[0]->st_name;

            $args_dst = array('st_code' => $data['inc_details'][0]->inc_state_id, 'dst_code' => $data['inc_details'][0]->inc_district_id);

            if( $data['inc_details'][0]->inc_district_id != '' || $data['inc_details'][0]->inc_district_id != '0'){
                $district = $this->inc_model->get_district_name($args_dst);
                $data['district_name'] = $district[0]->dst_name;
            }

            
            $args_th = array('thl_id' => $data['inc_details'][0]->inc_tahshil_id);
            if( $data['inc_details'][0]->thl_name != '' || $data['inc_details'][0]->thl_name != '0'){
                $tahshil = $this->inc_model->get_tahshil($args_th);
                $data['tahshil_name'] = $tahshil[0]->thl_name;
            }


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


            
            $inc_args = array(
                'inc_ref_id' => $data['inc_ref_id'],
                'inc_type' => $data['inc_call_type'][0]->inc_type
            );


        
            $data['questions'] = $this->inc_model->get_inc_summary($inc_args);
            
            $ques_args = array(
                'inc_ref_id' => $data['inc_ref_no'],
                'inc_type' => 'FEED_' . $data['inc_call_type'][0]->inc_type
            );



            $data['feed_questions'] = $this->inc_model->get_inc_summary($ques_args);

            $inc_audit_args = array(
                'inc_ref_id' => $data['inc_ref_no']
                //'inc_type' => $data['inc_call_type'][0]->inc_type
            );
            $data['audit_questions'] = $this->inc_model->get_inc_audit_summary($inc_audit_args);

            $amb_args = array('inc_ref_id' => $data['inc_ref_no'],'from_date'=>$incident_date,'to_date'=>$incident_date);

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






            $data['amb_data'] = $this->inc_model->get_inc_details($amb_args);


//        $amb_args_hp = array('rg_no' => $data['amb_data'][0]->amb_rto_register_no);
//
//        $amb_data_hp = $this->amb_model->get_amb_data($amb_args_hp);
//
//        $data['hp_name'] = $amb_data_hp[0]->hp_name;
//        $data['amb_default_mobile'] = $amb_data_hp[0]->amb_default_mobile;



            $data['sms_data'] = $this->inc_model->get_inc_sms_response($data['inc_ref_no']);

            $ptn_args = array('inc_ref_id' => $data['inc_ref_no'],
//                'ptn_id' => $data['inc_details'][0]->ptn_id,
                'from_date'=>$incident_date,
                'to_date'=>$incident_date
            );

            $data['ptn_details'] = $this->Pet_model->get_ptinc_info($ptn_args);



            $inc_args = array(
                'inc_ref_id' => trim($data['inc_ref_no']),
                'from_date'=>$incident_date,
                'to_date'=>$incident_date
            );


            $data['facility_details'] = $this->inc_model->get_hospital_facility(array('inc_ref_id' => trim($data['inc_ref_no'])));
            
            
            $data['folloup_details'] = $this->inc_model->get_followupinc(array('inc_ref_id' => trim($data['inc_ref_no'])));
           

            $data['feedback_details'] = $this->feedback_model->get_feedback_details(array('inc_ref_id' => trim($data['inc_ref_no'])));


            $args['base_month'] = $this->post['base_month'];
            $data['epcr_inc_details'] = $this->pcr_model->get_epcr_inc_details_by_inc_id($inc_args);
            $data['er_inc_details'] = $this->medadv_model->get_epcr_by_inc_id($inc_args);
            $data['counslor_list'] = $this->counslor_model->get_inc_by_counslor($args, $offset, $limit);
            $data['driver_data'] = $this->pcr_model->get_driver(array('inc_ref_id' => trim($data['inc_ref_no']),'from_date'=>$incident_date,'to_date'=>$incident_date));
            $data['tdo_id'] = $this->call_model->get_tdo_inc($data['inc_ref_no']);
        }

        $gri_args = array(
            'gc_inc_ref_id' => trim($data['inc_ref_no'])
        );
        
       
        $data['grievance_info'] = $this->grievance_model->get_inc_by_grievance($gri_args, '', '', $filter, $sortby);
        
        $args = array('gc_inc_ref_id' =>$data['inc_ref_no']);

        $data['cl_dtl'] = $this->grievance_model->get_inc_by_grievance($args);
        
        $sup_remark_args = array(
            's_inc_ref_id' => trim($data['inc_ref_no'])
        );
        $data['supervisor_remark'] = $this->call_model->get_inc_supervisor_remark($sup_remark_args);

           
      
        if ($this->clg->clg_group == 'UG-Grievance') {
            $this->output->add_to_position('', 'inc_details', TRUE);
            $this->output->add_to_position($this->load->view('frontend/calls/single_record_view', $data, TRUE), $position, TRUE);
            
        } else if ($this->clg->clg_group == 'UG-PDA' && (strstr($this->input->post('pc_inc_ref_id'), "P-"))) {
        
             
            $args1 = array(
            'pc_inc_ref_id' => $this->input->post('pc_inc_ref_id'),
            'base_month' => $this->post['base_month']
        );
           
            
        $data['pda_info'] = $this->police_model->get_inc_by_police($args1, $offset, $limit);
        
     
        $arg = array(
                'inc_ref_id' => $data['pda_info'][0]->pc_pre_inc_ref_id,
            );

           

            $data['pt_info'] = $this->Pet_model->get_ptinc_info($arg);

            $args_pur = array('pcode' => $data['pt_info'][0]->inc_type);
            $call_pur = $this->inc_model->get_purpose_call($args_pur);
            $data['pname'] = $call_pur[0]->pname;
            
            $this->output->add_to_position($this->load->view('frontend/calls/pda_single_record_view', $data, TRUE), $position, TRUE);
            
        }else if ($this->clg->clg_group == 'UG-FDA' && (strstr($this->input->post('fc_inc_ref_id'), "F-"))) {
            
               $args = array(
            'fc_inc_ref_id' =>$data['inc_ref_no'],
            'base_month' => $this->post['base_month']
        );
        //var_dump($args);die;
      

        $data['fda_info'] = $this->fire_model->get_inc_by_fire($args, $offset, $limit);
      
        //var_dump($data['fda_info']);die;
            
             $arg = array(
                'inc_ref_id' => $data['fda_info'][0]->fc_pre_inc_ref_id,
            );

           

            $data['pt_info'] = $this->Pet_model->get_ptinc_info($arg);

            $args_pur = array('pcode' => $data['pt_info'][0]->inc_type);
            $call_pur = $this->inc_model->get_purpose_call($args_pur);
            $data['pname'] = $call_pur[0]->pname;
        

            
            $this->output->add_to_position($this->load->view('frontend/calls/fda_single_record_view', $data, TRUE), $position, TRUE);
            
        } else {
           
            
            if($this->clg->clg_group == 'UG-FOLLOWUPERO'){
               
                $this->output->add_to_position($this->load->view('frontend/calls/single_record_view', $data, TRUE), 'content', TRUE);
                $this->output->template = "amb_loc_map";
            }else{
            $this->output->add_to_position($this->load->view('frontend/calls/single_record_view', $data, TRUE), $position, TRUE);
            }
            
        }

        $this->output->set_focus_to = "inc_ref_id";
    }

    function call_dialer() {

        $ext_no = get_cookie("avaya_extension_no");
        $data['mobile_no'] = $this->input->post('mobile_no');
       
        
        $ser_args = array('agent_no'=>$this->clg->clg_avaya_agentid);
        $agent_data = $this->call_model->get_avaya_call_by_ext($ser_args);
        $agent_data->status = 'C';
      
        $ser_args = array('ext_no'=>$ext_no);
            
        $service_data = $this->call_model->get_all_avaya_extension_new($ser_args);
        $service_type = $service_data[0]->type;
       
        if($agent_data->status == "D"){
            
            $action = $this->session->userdata('call_action');
            $mobile = $this->session->userdata('soft_dial_mobile');
            if($action != '' && $action != 'disconnect' ){
                $ac = 'C';
            }
            $agent_data = (object)array('calling_phone_no'=>$mobile,
                                'agent_no'=>$this->clg->clg_avaya_agentid,
                                'status' =>$ac);
            
        }
   
        
        $data['agent_data'] = $agent_data;
      
        
            
//        if($service_type == 'avaya'){
           $this->output->add_to_position($this->load->view('frontend/avaya/avaya_dialer_view', $data, TRUE), 'dialerscreen', TRUE);
//        }else if($service_type == 'coral'){
        
        //$this->output->add_to_position($this->load->view('frontend/avaya/dialer_view', $data, TRUE), 'dialerscreen', TRUE);
        
       // }
        //$this->output->add_to_popup($this->load->view('frontend/calls/call_dialer_view', $data, TRUE), '600', '560');
    }

    public function all_listing($generated = false) {
        
        $this->post = $this->input->post();
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');

        $this->post['base_month'] = get_base_month();
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->post['pg_rec'];
        $data['call_search'] = ($this->post['call_search']) ? $this->post['call_search'] : $this->fdata['call_search'];
        //var_dump($data);die;
        $this->pg_limit = 50;
        ///////////set page number////////////////////

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }


        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


        $args_dash = array(
            //'operator_id' => $this->clg->clg_ref_id,
            //'operator_id' => $this->clg->clg_ref_id,
            'base_month' => $this->post['base_month']
        );

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;
        //$offset = $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
       // var_dump($offset);

        $data['page_no'] = $page_no;


        $current_date = date('Y-m-d');
        $current_month = date('m');
        $current_year = date('Y');
        $current_month_date = $current_year . '-' . $current_month . '-01';
        
        if ($this->post['from_date'] != '') {
            $args_dash['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date'])) ;
        }


        if ($this->post['to_date'] != '') {
            $args_dash['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) :  date('Y-m-d', strtotime($this->post['to_date']));
        }
        
        if($args_dash['to_date'] != '' && $args_dash['from_date'] != ''){
            $args_dash = array('from_date' => $args_dash['from_date'],
            'to_date' => $args_dash['to_date'],
            'base_month' => $this->post['base_month']);
        }else{

            $args_dash = array('from_date' => date('Y-m-d', strtotime("-1 days")),
                'to_date' => $current_date,
                'base_month' => $this->post['base_month']);
        }

        if ($data['call_search'] != '') {
            $args_dash['call_search'] = $data['call_search'];
            
        }
        

        $data['from_date']= $from_date = $args['from_date'];
        $data['to_date']= $to_date = $args['to_date'];
        $pg_rec=$data['pg_rec'];

        
        if($this->post['ero'] != ''){
            $args_dash['ero']= $this->post['ero'];
        }
        
        if($this->post['avaya'] != ''){
            $args_dash['avaya']= $this->post['avaya'];
        }
        $inc_info = $this->inc_model->get_all_inc_by_date($args_dash, $offset, $limit);
       
        //var_dump($inc_info);die;

        $inc_data = array();

        foreach ($inc_info as $inc) {
            //$inc_data[] = $inc;
            //$ero_108 = $this->call_model->get_inc_ero_108($inc['inc_ref_id']);

            $caller_details = $this->call_model->get_caller_details_by_callid($inc['inc_cl_id']);

            $inc['clr_fullname'] = $caller_details[0]['clr_fname'] . ' ' . $caller_details[0]['clr_lname'];
            $inc['clr_mobile'] = $caller_details[0]['clr_mobile'];

            //$incient_district = $this->inc_model->get_district_by_id($inc['inc_district_id']);
            //$inc['dst_name'] = $incient_district->dst_name;

            $inc_emt_data = $this->call_model->get_emt_pilot_amb_by_inc_id($inc['inc_ref_id']);


            $inc['amb_default_mobile'] = $inc_emt_data[0]->clg_mobile_no;
            $inc['amb_rto_register_no'] = $inc_emt_data[0]->amb_rto_register_no;
            $inc['amb_emt_id'] = $inc_emt_data[0]->amb_emt_id;

            $inc['amb_pilot_id'] = $inc_emt_data[0]->amb_pilot_id;

            $inc['amb_pilot_mobile'] = $inc_emt_data[0]->clg_pilot_mobile;
            $inc_data[] = $inc;
        }

        $data['ero_clg'] = $this->colleagues_model->get_all_ero($args);
        $data['inc_info'] = $inc_data;

        $args_dash['get_count'] = TRUE;
        
        $total_cnt = $this->inc_model->get_all_inc_by_date($args_dash);
        // var_dump($total_cnt);

        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("calls/all_listing_filter"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc&from_date=$from_date&to_date=$to_date&pg_rec=$pg_rec&action=view"
            )
        );


        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);
        //$args = 'UG-ERO,UG-ERO-102';
        //$data['ero_clg'] = $this->colleagues_model->get_all_eros($args);

        // $this->output->add_to_position($this->load->view('frontend/calls/ero_dashboard_view', $data, TRUE), 'content', TRUE);
         $this->output->add_to_position('', 'caller_details', TRUE);
        $data['all_purpose_of_calls'] = $this->call_model->get_all_child_purpose_of_calls();
        $this->output->add_to_position($this->load->view('frontend/calls/inc_all_call_view', $data, TRUE), 'content', TRUE);
        // $this->output->template = "calls";
    }
    public function all_listing_filter($generated = false) {
        
        //$this->post = $this->input->post();
        
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');
       
        $current_date = date('Y-m-d');
        $current_month = date('m');
        $current_year = date('Y');
        $current_month_date = $current_year . '-' . $current_month . '-01';
        
       // var_dump($this->fdata);
       //die();
        
        if ($this->post['from_date'] != '') {
           // $data['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date'])) ;
             $data['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : $this->post['from_date'];
        }else{
              $data['from_date'] = date('Y-m-d', strtotime("-1 days"));

        }

        if ($data['call_search'] != '') {
            $data['call_search'] = $this->post['call_search'];
            
        }
        if ($this->post['to_date'] != '') {
            //$data['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) :  date('Y-m-d', strtotime($this->post['to_date']));
            $data['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) :  $this->post['to_date'];
        }else{
              $data['to_date'] = $current_date;
        }
        $this->pg_limit = 50;

        $this->post['base_month'] = get_base_month();
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->post['pg_rec'];
       
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $data['call_search'] = ($this->post['call_search']) ? $this->post['call_search'] : $this->post['call_search'];
        
        

        ///////////set page number////////////////////

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        //var_dump($page_no);


        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


        $args_dash = array(
            //'operator_id' => $this->clg->clg_ref_id,
            //'operator_id' => $this->clg->clg_ref_id,
            'base_month' => $this->post['base_month']
        );
       

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

       // $offset = $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $limit;

       // $offset = $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $data['page_no'] = $page_no;


        $current_date = date('Y-m-d');
        $current_month = date('m');
        $current_year = date('Y');
        $current_month_date = $current_year . '-' . $current_month . '-01';
        
        $from_date=$data['from_date'];
        $to_date=$data['to_date'];
        $pg_rec=$data['pg_rec'];
       

        
        if($this->post['user_id'] != ''){
            $data['ero']= $data['ero_clg']= $data['user_id'] = $user_id = $this->post['user_id'];
        }
        if($this->post['avaya'] != ''){
            $data['avaya']= $this->post['avaya'];
        }
        if($this->post['team_type'] != ''){
            $team_type =$args_dash['team_type'] = $data['team_type']= $this->post['team_type'];
        }
        if ($this->post['call_purpose'] != '') {

            $call_purpose = $data['call_purpose'] = $this->post['call_purpose'];
        }
        if($this->post['call_search'] != ''){
            $data['call_search']= $this->post['call_search'];

           $call_search = $data['call_search']= $this->post['call_search'];

        }
        if ($this->post['call_purpose'] != '') {

            $call_purpose = $data['call_purpose'] = $this->post['call_purpose'];
        }
        

        $data['get_count'] = TRUE;
        //var_dump($data);die;
        $total_cnt = $this->inc_model->get_all_inc_by_date($data);
       // var_dump($total_cnt);
       // die();
        $data['page_no'] = $page_no;
        
        $config['per_page'] = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
       // $page_no = get_pgno($total_cnt, $limit, $page_no);
        //$offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;
        $data['get_count'] = FALSE;
       // $data['page_no'] = $page_no;
        //var_dump($data);die();
        $clgflt['ALL_CALL'] = $data;

        $this->session->set_userdata('filters', $clgflt);
        
         
        $inc_info = $this->inc_model->get_all_inc_by_date($data, $offset, $limit);
        $inc_data = array();

        foreach ($inc_info as $inc) {
            //$inc_data[] = $inc;
            //$ero_108 = $this->call_model->get_inc_ero_108($inc['inc_ref_id']);

            $caller_details = $this->call_model->get_caller_details_by_callid($inc['inc_cl_id']);

            $inc['clr_fullname'] = $caller_details[0]['clr_fname'] . ' ' . $caller_details[0]['clr_lname'];
            $inc['clr_mobile'] = $caller_details[0]['clr_mobile'];

            $incient_district = $this->inc_model->get_district_by_id($inc['inc_district_id']);
            $inc['dst_name'] = $incient_district->dst_name;

            $inc_emt_data = $this->call_model->get_emt_pilot_amb_by_inc_id($inc['inc_ref_id']);


            $inc['amb_default_mobile'] = $inc_emt_data[0]->clg_mobile_no;
            $inc['amb_rto_register_no'] = $inc_emt_data[0]->amb_rto_register_no;
            $inc['amb_emt_id'] = $inc_emt_data[0]->amb_emt_id;

            $inc['amb_pilot_id'] = $inc_emt_data[0]->amb_pilot_id;

            $inc['amb_pilot_mobile'] = $inc_emt_data[0]->clg_pilot_mobile;
            $inc_data[] = $inc;
        }

        $data['ero_clg'] = $this->colleagues_model->get_all_ero($args);
        $data['inc_info'] = $inc_data;

        $args['get_count'] = TRUE;
        
        //$total_cnt = $this->inc_model->get_all_inc_by_date($args);
        // var_dump($total_cnt);

        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;
        $clgflt['CLG1'] = $data;

        $this->session->set_userdata('filters', $clgflt);


        $pgconf = array(
            'url' => base_url("calls/all_listing_filter"),
            'total_rows' => $total_cnt,
            'per_page' => $pg_rec,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc&from_date=$from_date&to_date=$to_date&pg_rec=$pg_rec&call_search=$call_search&call_purpose=$call_purpose&team_type=$team_type&user_id=$user_id&action=view"
            )
        );


        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);
        $data['rg_no'] = ($this->post['rg_no']) ? $this->post['rg_no'] : $this->fdata['rg_no'];
        $data['mob_no'] = ($this->post['mob_no']) ? $this->post['mob_no'] : $this->fdata['mob_no'];
        $data['all_purpose_of_calls'] = $this->call_model->get_all_child_purpose_of_calls();
        
        if($this->post['action'] == 'view'){
            
            $this->output->add_to_position($this->load->view('frontend/calls/inc_all_call_view', $data, TRUE), 'content', TRUE);
        
        }else{
            $filename = "call_dashboard.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            $header = array('Date','Call Type','Incidence ID','Caller Name','District','Caller Mobile No','EMT NAME','EMT Mobile','ERO Name','Ameyo ID','Audio File','Ambulance','Call Time','Incident status','Closure Status');
            fputcsv($fp, $header);
            foreach($data['inc_info'] as $inc){
                
                if($inc['clr_fullname'] != ''){
                    $caller_name = $inc['clr_fullname'];
                }else{
                    $caller_name = $inc['clr_fname']." ".$inc['clr_mname']." ".$inc['clr_lname'];
                }
                          
                           
                $row['date']  = $inc['inc_datetime'];
                $row['pname'] = ucwords($inc['pname']);
                $row['inc_ref_id'] = $inc['inc_ref_id'];
                $row['caller_name'] = $caller_name;
                $row['dst_name'] = $inc['dst_name'];
                $row['clr_mobile'] = $inc['clr_mobile'];
                $row['inc_address'] = $inc['inc_address'];
                $row['amb_emt_id'] = $inc['amb_emt_id'];
                $row['on_road_date_time'] = $on_road;
                $row['amb_default_mobile'] = $inc['amb_default_mobile'];
                $row['clg_name'] = ucwords(strtolower($inc['clg_first_name']." ".$inc['clg_last_name']));;
                $row['clg_avaya_id'] = $inc['clg_avaya_id'];
                $row['amb_rto_register_no'] = $inc['amb_rto_register_no'];
                $row['inc_dispatch_time'] = $inc['inc_dispatch_time'];
               
                if($inc['inc_district_id'] != "0"){
                    if($inc['incis_deleted'] == 0){
                        $disptched = "Dispatched";
                    }
                    if($inc['incis_deleted'] == 2){
                        $disptched = "Terminated";
                    }
                    if($inc['incis_deleted'] == 1){
                        $disptched = "Deleted";
                    }

                }else{
                    $disptched ="NA";
                }

                if($inc['inc_district_id'] != "0"){
                    if($inc['inc_pcr_status'] == '0' || $inc['inc_pcr_status'] == 0){
                        $closer = "Closure Pending";
                    }else{
                        $closer = "Closure Done";
                    }
                }else{
                    $closer ="Closed";
                }
                $row['disptched'] = $disptched;
                $row['closer'] = $closer;
                
                fputcsv($fp, $row);
                
            }
               fclose($fp);
            exit;

        }

    }

    function show_clusters() {
        $data['cluster_data'] = $this->cluster_model->get_cluster_data();
        $this->output->add_to_position($this->load->view('frontend/calls/show_cluster_view', $data, TRUE), 'cluster_view', TRUE);
    }

    function caller_history() {

        //$mobile_no = $this->input->post('mobile_no');
        $mobile_no = $this->input->post();
          //print_r ($mobile_no['mobile_no']); die;
        if ($mobile_no['mobile_no'] == '') {

            $this->output->message = "<p>Record Not Found</p>.";
            return;
        }


        $args_dash = array(
            'clr_mobile' => $mobile_no['mobile_no'],
            'base_month' => $this->post['base_month']
        );
        $data['clr_mobile'] = $mobile_no['mobile_no'];
        $data['inc_info'] = $this->call_model->get_inc_by_ero_calls_history($args_dash, $offset, $limit);
        //print_r($data);die;

        $args_dash['get_count'] = 'True';

        $data['total_count'] = $this->call_model->get_inc_by_ero_calls_history($args_dash, $offset, $limit);



        $data['cur_page'] = $page_no;
        $pgconf_amb = array(
            'url' => base_url("calls/caller_history"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=amb"
            )
        );

        $config = get_pagination($pgconf_amb);
        $data['inc_total_count'] = get_pagination($pgconf_amb);

        $this->output->add_to_popup($this->load->view('frontend/calls/caller_history_view', $data, TRUE), '1500', '560');
    }
    function incident_Current_Status_Deatis(){
        $dispatch_status = $this->input->post('dispatch_status');
        $inc_ref_id = $this->input->post('inc_ref_id');
        $inc_datetime = $this->input->post('inc_datetime');
        $call_type = $this->input->post('call_purpose');
//        if ($mobile_no == '' || $call_type == '') {
//            $this->output->message = "<p>Please Fill data </p>.";
//            return;
//        }

        $current_date =date('Y-m-d H:i:s');
        $newdate = date('Y-m-d H:i:s',strtotime ( '-48 hour' , strtotime($current_date))) ;
        
        $args_dash = array(
            'inc_ref_id' => $inc_ref_id
        );

        $data['dispatch_status'] = $dispatch_status;
          $data['inc_ref_id'] = $inc_ref_id;
          $data['inc_datetime'] = $inc_datetime;
        $data['inc_info'] = $this->inc_model->get_inc_details_ref_id_driver_para($args_dash);

        $args_dash['get_count'] = 'True';

        $data['total_count'] = $this->inc_model->get_inc_details_ref_id_driver_para($args_dash);

        

        $data['cur_page'] = $page_no;
        $pgconf_amb = array(
            'url' => base_url("calls/incident_Current_Status_Deatis"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=amb"
            )
        );

        $config = get_pagination($pgconf_amb);
        $data['inc_total_count'] = get_pagination($pgconf_amb);

        //this->output->add_to_position($this->load->view('frontend/calls/single_caller_history_view', $data, TRUE), 'popup_div', TRUE);
        // $this->output->add_to_position($this->load->view('frontend/calls/single_caller_history_view', $data, TRUE), 'popup_div', TRUE);
      //$this->output->add_to_popup($this->load->view('frontend/calls/single_caller_history_view', $data, TRUE), '1300', '560');
        $this->output->add_to_position($this->load->view('frontend/calls/incident_Current_Status_Detail', $data, TRUE), $position, TRUE);
    
    }
    function caller_history_number() {

        $mobile_no = $this->input->post('mobile_no');
        $call_type = $this->input->post('call_purpose');
//        if ($mobile_no == '' || $call_type == '') {
//            $this->output->message = "<p>Please Fill data </p>.";
//            return;
//        }

        $current_date =date('Y-m-d H:i:s');
        $newdate = date('Y-m-d H:i:s',strtotime ( '-24 hour' , strtotime($current_date))) ;
        
        $args_dash = array(
            'clr_mobile' => $mobile_no,
            'base_month' => $this->post['base_month'],
            'call_type' => $call_type,
            'from_date' =>$newdate ,
           'to_date' =>$current_date,
        );

        $data['clr_mobile'] = $mobile_no;
        $data['inc_info'] = $this->call_model->get_inc_by_ero_calls_history($args_dash, $offset, $limit);

        $args_dash['get_count'] = 'True';

        $data['total_count'] = $this->call_model->get_inc_by_ero_calls_history($args_dash, $offset, $limit);



        $data['cur_page'] = $page_no;
        $pgconf_amb = array(
            'url' => base_url("calls/single_caller_history"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=amb"
            )
        );

        $config = get_pagination($pgconf_amb);
        $data['inc_total_count'] = get_pagination($pgconf_amb);

        //this->output->add_to_position($this->load->view('frontend/calls/single_caller_history_view', $data, TRUE), 'popup_div', TRUE);
        // $this->output->add_to_position($this->load->view('frontend/calls/single_caller_history_view', $data, TRUE), 'popup_div', TRUE);
      //$this->output->add_to_popup($this->load->view('frontend/calls/single_caller_history_view', $data, TRUE), '1300', '560');
        $this->output->add_to_position($this->load->view('frontend/calls/single_caller_history_view', $data, TRUE), 'popup_div', TRUE);
    }
    function single_caller_history() {

        $mobile_no = $this->input->post('mobile_no');
        $search_caller_details = $this->input->post('search_caller_details');
        $clg_id = $this->input->post('clg_id');
        $call_type = $this->input->post('h_call_purpose');
      
        
       



        $current_date =date('Y-m-d H:i:s');
        $newdate = date('Y-m-d H:i:s',strtotime ( '-24 hour' , strtotime($current_date))) ;
        
        $args_dash = array(
            
            'operator_id' => $clg_id,
            'clr_mobile' => $mobile_no,
            'base_month' => $this->post['base_month'],
            'search_caller_details' => $search_caller_details,
            'call_type' => $call_type,
            'from_date' =>$newdate ,
           'to_date' =>$current_date,
        );
         if ($this->input->post('h_from_date') != '' || $this->cdata['h_from_date'] != '') {
            $args_dash['h_from_date'] = date('Y-m-d', strtotime($this->input->post('h_from_date'))) ? date('Y-m-d', strtotime($this->input->post('h_from_date'))) : date('Y-m-d', strtotime($this->cdata['h_from_date']));
        }


        if ($this->input->post('h_to_date') != '' || $this->cdata['h_to_date'] != '') {
            $args_dash['to_date'] = date('Y-m-d', strtotime($this->input->post('h_to_date'))) ? date('Y-m-d', strtotime($this->input->post('h_to_date'))) : date('Y-m-d', strtotime($this->cdata['h_to_date']));
        }
        
   
        if ($data['call_purpose'] != '') {
            $args_dash['call_purpose'] = $data['call_purpose'];
        }
        if ($data['call_status'] != '') {
            $args_dash['call_status'] = $data['h_call_status'];
        }
        $args_dash['district_id'] = $this->input->post('h_district_id');
       

        $data['clr_mobile'] = $mobile_no;
        $data['inc_info'] = $this->call_model->get_inc_by_ero_calls_history($args_dash, $offset, $limit);

        $args_dash['get_count'] = 'True';

        $data['total_count'] = $this->call_model->get_inc_by_ero_calls_history($args_dash, $offset, $limit);



        $data['cur_page'] = $page_no;
        $pgconf_amb = array(
            'url' => base_url("calls/single_caller_history"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=amb"
            )
        );

        $config = get_pagination($pgconf_amb);
        $data['inc_total_count'] = get_pagination($pgconf_amb);

        $this->output->add_to_position($this->load->view('frontend/calls/single_caller_history_view', $data, TRUE), 'caller_single_record_details', TRUE);
        //$this->output->set_focus_to = "inc_ref_id";
    }
    function load_child_purpose(){
        
        $clg_group = $this->clg->clg_group;
        
        if($clg_group == 'UG-ERO'  || $clg_group == 'UG-ERCTRAINING' || $clg_group == 'UG-FOLLOWUPERO'){
           $clg_user_type = '108'; 
        }
        else if($clg_group == 'UG-ERO-104'){
            $clg_user_type = '104';
        }else{
            $clg_user_type = '102,108';
        }
        $parent_purpose = $this->input->post('parent_purpose');
        $args=array('p_parent'=>$parent_purpose,'p_systen'=>$clg_user_type);
        $data['parent_purpose_of_calls'] = $this->call_model->get_purpose_of_calls($args);
		$data['blood_gp'] = $this->call_model->get_bloodgp();
		$data['CallUniqueID'] = $CallUniqueID = $this->session->userdata('CallUniqueID');
		
        // if($parent_purpose == "EMG" || $parent_purpose == "PREGANCY_CARE_CALL" || $parent_purpose == "Child_CARE" || $parent_purpose == "DROP_BACK_CALL" || $parent_purpose == "HELP_EME_INFO" || $parent_purpose == "HELP_EME_OTHER" || $parent_purpose == "HELP_EME_MED" || $parent_purpose == "HELP_EME_COMP" || $parent_purpose == "HELP_EME_COUN") {
            if($parent_purpose == "EMG" || $parent_purpose == "PREGANCY_CARE_CALL" || $parent_purpose == "Child_CARE" || $parent_purpose == "DROP_BACK_CALL" || $parent_purpose == "HELP_EME_INFO" || $parent_purpose == "HELP_EME_MED" || $parent_purpose == "HELP_EME_COMP" || $parent_purpose == "HELP_EME_COUN") {
            // if($parent_purpose == "HELP_EME_INFO" || $parent_purpose == "HELP_EME_OTHER" || $parent_purpose == "HELP_EME_MED" || $parent_purpose == "HELP_EME_COMP" || $parent_purpose == "HELP_EME_COUN"){
                if($parent_purpose == "HELP_EME_INFO" || $parent_purpose == "HELP_EME_MED" || $parent_purpose == "HELP_EME_COMP" || $parent_purpose == "HELP_EME_COUN"){
                $this->output->add_to_position($this->load->view('frontend/calls/common_patient_info1', $data, TRUE), 'call_common_info', TRUE);
                $this->output->add_to_position('', 'content', TRUE);
            }
            else{
                $this->output->add_to_position($this->load->view('frontend/calls/common_patient_info', $data, TRUE), 'call_common_info', TRUE);
                $this->output->add_to_position('', 'content', TRUE);
            $this->output->add_to_position($this->load->view('frontend/calls/relation_view', $data, TRUE), 'caller_relation_div', TRUE);
            }
            
            
        }else{
            
            $this->output->add_to_position('', 'call_common_info', TRUE);
            $this->output->add_to_position('', 'content', TRUE);
            
        }
        
        $this->output->add_to_position($this->load->view('frontend/calls/child_call_purpose', $data, TRUE), 'child_purpose_of_calls', TRUE);
        
        
       
    }
    function situational_call_details(){
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
           // var_dump($data['cl_dtl']);die();
        } else {

            $args = array(
                'inc_ref_id' => trim($this->post['inc_ref_id']),
            );

            $data['inc_ref_id'] = trim($this->post['inc_ref_id']);

            $this->session->set_userdata('es_inc_ref_id', $this->post['inc_ref_id']);

            $data['cl_dtl'] = $this->inc_model->get_situational_call_detials($args);
           // var_dump($data['cl_dtl']);die();
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

        $this->output->add_to_position($this->load->view('frontend/calls/situational_inc_details_view', $data, TRUE), 'content', TRUE);
   
    }
    function erosupervisor_call_details(){
    
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

            $this->session->set_userdata('es_inc_ref_id', $this->post['inc_ref_id']);

            $data['cl_dtl'] = $this->problem_reporting_model->get_grivance_call_detials($args);

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

        $this->output->add_to_position($this->load->view('frontend/calls/erosupervisor_inc_details_view', $data, TRUE), 'content', TRUE);
    }
    function situational_call_list($generated = false){
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
          
          
              
            $data['operator_id'] = $this->clg->clg_ref_id;
            $data['base_month'] = $this->post['base_month'];
          
          ///////////limit & offset////////
  
          $data['get_count'] = TRUE;
          //$data['gc_inc_call_type'] = 'PREV';
          $data['clg_group'] = $this->clg->clg_group;
          $data['total_count'] = $this->inc_model->get_situational_desk_list_calls($data, '', '', $filter, $sortby);
          $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
  
       //   $page_no = get_pgno($data['total_count'], $limit, $page_no);
  
          $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;
  
          $data['page_no'] = $page_no;
  
          unset($data['get_count']);
  
  
  
          $data['inc_info'] = $this->inc_model->get_situational_desk_list_calls($data, $offset, $limit, $filter, $sortby);
          
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
         
         $data['get_all_calls'] = $this->inc_model->get_situational_desk_list_calls($month_report_args);
         
         //Today call
         $today_report_args =  array('from_date' => date('Y-m-d',strtotime($query_date)),
                        'to_date' => date('Y-m-d', strtotime($query_date)));
         $today_report_args['get_count'] = 'true';
         $today_report_args['operator_id'] = $this->clg->clg_ref_id;
  
         
        //  $data['pgconf'] = $pgconf;
         // $data['pagination'] = get_pagination($pgconf);
  
          /////////////////////////////////
          $data['page_records'] = count($data['inc_info']);
  
          $data['default_state'] = $this->default_state;
          $this->output->add_to_position($this->load->view('frontend/calls/situational_dash_view', $data, TRUE), 'content', TRUE);
  
             if($this->clg->clg_group ==  'UG-SITUATIONAL-DESK' ){
               $this->output->template = "calls";
          }
    }
    function save_situational_call(){
        $inc_id = $this->post['es']['es_inc_ref_id'];
        if ($inc_id == '') {
            $inc_id = generate_situational_inc_ref_id();
            update_situational_inc_ref_id($inc_id);
        }
         $sf = $this->post['sf'];
        $args = array(
            'pre_inc_ref_id'=>$this->post['inc_ref_id'],
            'base_month' => $this->post['base_month'],
            'added_date' => $this->today,
            'added_by' => $this->clg->clg_ref_id,
            'modify_date' => $this->today,
            'modify_by' => $this->clg->clg_ref_id,
        );


        if ($this->post['es']['es_inc_ref_id'] == '') {
            $args['inc_ref_id'] = 'SD-' . $inc_id;
        }
        $args = array_merge($this->post['es'], $args);
        
        $shift_args = array(
            'sub_id' => $this->post['inc_ref_id'],
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'base_month' => $this->post['base_month'],
            'sub_type' => 'Situational Call Close'
        );

        $args_shift = array('clg_group'=>'UG-SITUATIONAL-DESK');
        $get_ShiftManager = $this->colleagues_model->get_all_colleagues($args_shift);
            
        $shift_args['operator_id'] = $get_ShiftManager[0]->clg_ref_id;

        $shift_args['operator_type'] = $get_ShiftManager[0]->clg_group;

        $res = $this->common_model->assign_operator($shift_args);
        
        $shiftmanager = $this->call_model->add_situational_call($args);

        $shiftmanager_operator = array(
            'sub_id' => $this->post['inc_ref_id'],
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'sub_status' => 'ATND',
        );

        $shiftmanager_args = array(
            'sub_id' => $this->post['inc_ref_id'],
            'operator_type' => $this->clg->clg_group,
        );

        $shiftmanager = $this->common_model->update_operator($shiftmanager_args, $shiftmanager_operator);

        if ($shiftmanager) {

            $this->output->message = "<div class='success'>Details saved successfully</div><script>window.location.reload(true);</script>";
        }
    }
    function save_erosupervisor_call(){
        $inc_id = $this->post['es']['es_inc_ref_id'];


        if ($inc_id == '') {
            $inc_id = generate_erosupervisor_inc_ref_id();
            update_erosupervisor_inc_ref_id($inc_id);
        }
        
        $sf = $this->post['sf'];
        $args = array(
            'es_pre_inc_ref_id'=>$this->post['inc_ref_id'],
            'es_base_month' => $this->post['base_month'],
            'added_date' => $this->today,
            'added_by' => $this->clg->clg_ref_id,
            'modify_date' => $this->today,
            'modify_by' => $this->clg->clg_ref_id,
        );


        if ($this->post['es']['es_inc_ref_id'] == '') {
            $args['es_inc_ref_id'] = 'ES-' . $inc_id;
        }


        $args = array_merge($this->post['es'], $args);
        
        $shift_args = array(
            'sub_id' => $this->post['inc_ref_id'],
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'base_month' => $this->post['base_month'],
            'sub_type' => 'NON_EME_CALL'
        );

        $args_shift = array('clg_group'=>'UG-ShiftManager');
        $get_ShiftManager = $this->colleagues_model->get_all_colleagues($args_shift);
            
        $shift_args['operator_id'] = $get_ShiftManager[0]->clg_ref_id;

        $shift_args['operator_type'] = $get_ShiftManager[0]->clg_group;

        $res = $this->common_model->assign_operator($shift_args);

        $shiftmanager = $this->call_model->add_erosupervisor_call($args);

        $shiftmanager_operator = array(
            'sub_id' => $this->post['inc_ref_id'],
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'sub_status' => 'ATND',
        );

        $shiftmanager_args = array(
            'sub_id' => $this->post['inc_ref_id'],
            'operator_type' => $this->clg->clg_group,
        );

        $shiftmanager = $this->common_model->update_operator($shiftmanager_args, $shiftmanager_operator);

        if ($shiftmanager) {

            $this->output->message = "<div class='success'>Details saved successfully</div><script>window.location.reload(true);</script>";
        }
    }
    
    public function last_three_hour_call_listing($generated = false) {

        return;
        $this->post = $this->input->post();
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');

        $this->post['base_month'] = get_base_month();

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        $this->pg_limit = 50;
        ///////////set page number////////////////////

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }


        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


        $args_dash = array(
            //'operator_id' => $this->clg->clg_ref_id,
            //'operator_id' => $this->clg->clg_ref_id,
            'base_month' => $this->post['base_month']
        );

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;


        $current_date =date('Y-m-d H:i:s');
        $newdate = strtotime ( '-3 hour' , strtotime ( $current_date ) ) ;
        
        if ($this->post['from_date'] == '') {
           // $args_dash['from_date'] = $newdate;
        }


        if ($this->post['to_date'] != '') {
            $args_dash['to_date'] = $current_date;
        }

        $args_dash['last_three_hours'] = '1';
        
        //var_dump($args_dash); die;

        $inc_info = $this->inc_model->get_all_inc_by_date($args_dash, $offset, $limit);


        $inc_data = array();

        foreach ($inc_info as $inc) {
            //var_dump($inc);
            //$inc_data[] = $inc;
            //$ero_108 = $this->call_model->get_inc_ero_108($inc['inc_ref_id']);

           // $caller_details = $this->call_model->get_caller_details_by_callid($inc['inc_cl_id']);

            //$inc['clr_fullname'] = $caller_details[0]['clr_fname'] . ' ' . $caller_details[0]['clr_lname'];
            //$inc['clr_mobile'] = $caller_details[0]['clr_mobile'];



            $inc_emt_data = $this->call_model->get_emt_pilot_amb_by_inc_id($inc['inc_ref_id']);
            //$inc['ero_clg'] = $this->colleagues_model->get_all_ero($args);
            $inc['amb_default_mobile'] = $inc_emt_data[0]->clg_mobile_no;
            $inc['amb_rto_register_no'] = $inc_emt_data[0]->amb_rto_register_no;
            $inc['amb_emt_id'] = $inc_emt_data[0]->amb_emt_id;
            $inc['amb_pilot_id'] = $inc_emt_data[0]->amb_pilot_id;
            $inc['amb_pilot_mobile'] = $inc_emt_data[0]->clg_pilot_mobile;
            $inc_data[] = $inc;
        }


        $data['inc_info'] = $inc_data;

        $args['get_count'] = TRUE;
        //$total_cnt = $this->inc_model->get_all_inc_by_date($args);
        // var_dump($total_cnt);

        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("calls/last_three_hour_call_listing"),
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


        // $this->output->add_to_position($this->load->view('frontend/calls/ero_dashboard_view', $data, TRUE), 'content', TRUE);

        $this->output->add_to_position($this->load->view('frontend/calls/last_three_hour_call_listing', $data, TRUE), 'last_tree_hour_incident', TRUE);
        // $this->output->template = "calls";
    }
    function show_user_all_data(){
        
        $args = array();
        $clg_ref_id = trim($this->input->post('clg_ref_id'));
        $group_code = $this->input->post('group_code');
        $args = array('clg_reff_id' => trim($this->input->post('clg_ref_id')));
        
        
         $data['clg_data'] = $this->colleagues_model->get_clg_data($args);
         
           $report_args = array(
                'clg_ref_id'=>$clg_ref_id,
                'single_date' => date('Y-m-d'),
                'base_month' => $this->post['base_month']
            );
        
        $data['login_details'] = $this->shiftmanager_model->get_login_details($report_args);
        
        
        $data['break_details'] = $this->shiftmanager_model->get_break_details_by_user($report_args);

        $data['user_status'] = $this->call_model->get_ero_user_status($clg_ref_id);
        $data['call_details'] = $this->call_model->get_all_child_purpose_of_calls();
        $data['group_code'] = $group_code;
       // var_dump($group_code);die();
        if($group_code == 'UG-ERO'){
            $this->output->add_to_position($this->load->view('frontend/calls/show_user_all_data', $data, TRUE), $position, TRUE);
        }
        if($group_code == 'UG-DCO'){
            $this->output->add_to_position($this->load->view('frontend/calls/show_user_all_data_dco', $data, TRUE), $position, TRUE);
            
        }
        
    }
    function show_user_download_data(){
        
        $args = array();
        $clg_ref_id = trim($this->input->get_post('clg_ref_id'));
        
        $args = array('clg_ref_id' => trim($this->input->get_post('clg_ref_id')));
        
        
         $data['clg_data'] = $this->colleagues_model->get_clg_data($args);
         
           $report_args = array(
                'clg_ref_id'=>$clg_ref_id,
                'single_date' => date('Y-m-d'),
                'base_month' => $this->post['base_month']
            );
        
        $data['login_details'] = $this->shiftmanager_model->get_login_details($report_args);
        
        
        $data['break_details'] = $this->shiftmanager_model->get_break_details_by_user($report_args);
        $data['user_status'] = $this->call_model->get_ero_user_status($clg_ref_id);
        $data['call_details'] = $this->call_model->get_all_child_purpose_of_calls();
        $this->output->add_to_position($this->load->view('frontend/calls/show_user_all_data_pdf', $data, TRUE), $position, TRUE);
        $this->output->template = "cell";
    }
        
    function download_login_details_link(){
        
        $clg_ref_id = $this->input->post('clg_ref_id');
        
        $dis_file_name = './upload/login_details_'.$clg_ref_id.'.pdf';
        
        $url = base_url().'calls/show_user_download_data?clg_ref_id='.$clg_ref_id;
        $js_url = FCPATH."healthcard_pdf_script.js";
        $phontam_js = "/home/MHems/phantomjs/phantomjs-2.1.1-linux-x86_64/bin/phantomjs";
        ///home/MHems/phantomjs/phantomjs-1.9.8-linux-x86_64/bin
      
        $output =  shell_exec("$phontam_js '$js_url' '$url' '$dis_file_name'");

//        /home/MHems/phantomjs/phantomjs-2.1.1-linux-x86_64/bin/phantomjs "/home/MHems/www/MHEms/healthcard_pdf_script.js" "http://MHems.in/calls/show_user_download_data?clg_ref_id=ero-56&t=12" "/home/MHems/www/MHEms/upload/login_details_ero-56-1.pdf"
        if($output){
            
          
            $fullfile = FCPATH.$dis_file_name;
            $pdf_file_name = 'login_details_'.$clg_ref_id.'.pdf';

            $fsize = filesize( $fullfile );
            
            header('Content-Description: File Transfer');
            header('Content-type:application/octet-stream ');
            header("Content-Length:".$fsize); 
            header('Content-Disposition:attachment; filename='.$pdf_file_name);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            readfile($fullfile);
          //  unlink($pdf_file);
            exit();

        }
        
    }
    function three_word_popup(){
        $mobile_no = $this->input->post();
        
        if ($mobile_no['mobile_no'] == '') {

            $this->output->message = "<p>Please Enter Mobile No</p>.";
            return;
        }
        $data['mobile_no'] = $mobile_no['mobile_no'];
        $this->output->add_to_popup($this->load->view('frontend/calls/three_word_view', $data, TRUE), '500', '200');
    }
    function send_sms_three_word(){
       
        $mobile_no = $this->input->get_post('mobile_no');
       //  var_dump($mobile_no);die();
         
       // Sanjeevani108, MP is trying to find your location, click on the link: {#var#} and read out the 3 words at the bottom. JAES
         $txtMsg1='';
         $txtMsg1.= "Sanjeevani108,\n";
         $txtMsg1.= " MP is trying to find your location, click on the link: in.findme.w3w.co and read out the 3 words at the bottom.";
         $txtMsg1.= " JAES" ;
         
         
         $args = array(
             'msg' => $txtMsg1,
             'mob_no' => $mobile_no,
             'sms_user'=>'W3W_patient'
         );
        
         $sms_data = sms_send($args);
         $this->output->closepopup = 'yes';
         
     }
     function terminate_calls(){
              $this->post = $this->input->post();
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');

        $this->post['base_month'] = get_base_month();
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->post['pg_rec'];
        $data['call_search'] = ($this->post['call_search']) ? $this->post['call_search'] : $this->fdata['call_search'];
        //var_dump($data);die;
        $this->pg_limit = 50;
        ///////////set page number////////////////////

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }


        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


        $args_dash = array(
            //'operator_id' => $this->clg->clg_ref_id,
            //'operator_id' => $this->clg->clg_ref_id,
            'base_month' => $this->post['base_month']
        );

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;
        //$offset = $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
       // var_dump($offset);

        $data['page_no'] = $page_no;


        $current_date = date('Y-m-d');
        $current_month = date('m');
        $current_year = date('Y');
        $current_month_date = $current_year . '-' . $current_month . '-01';
        
        if ($this->post['from_date'] != '') {
            $args_dash['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date'])) ;
        }


        if ($this->post['to_date'] != '') {
            $args_dash['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) :  date('Y-m-d', strtotime($this->post['to_date']));
        }
        
        if($args_dash['to_date'] != '' && $args_dash['from_date'] != ''){
            $args_dash = array('from_date' => $args_dash['from_date'],
            'to_date' => $args_dash['to_date'],
            'base_month' => $this->post['base_month']);
        }else{

            $args_dash = array('from_date' => date('Y-m-d', strtotime("-1 days")),
                'to_date' => $current_date,
                'base_month' => $this->post['base_month']);
        }

        if ($data['call_search'] != '') {
            $args_dash['call_search'] = $data['call_search'];
            
        }
        

        $data['from_date']= $from_date = $args['from_date'];
        $data['to_date']= $to_date = $args['to_date'];
        $pg_rec=$data['pg_rec'];

        
        if($this->post['ero'] != ''){
            $args_dash['ero']= $this->post['ero'];
        }
        
        if($this->post['avaya'] != ''){
            $args_dash['avaya']= $this->post['avaya'];
        }
        $args_dash['incis_deleted']='2';
        $inc_info = $this->inc_model->get_all_inc_by_date($args_dash, $offset, $limit);
       
        //var_dump($inc_info);die;

        $inc_data = array();

        foreach ($inc_info as $inc) {
            //$inc_data[] = $inc;
            //$ero_108 = $this->call_model->get_inc_ero_108($inc['inc_ref_id']);

            $caller_details = $this->call_model->get_caller_details_by_callid($inc['inc_cl_id']);

            $inc['clr_fullname'] = $caller_details[0]['clr_fname'] . ' ' . $caller_details[0]['clr_lname'];
            $inc['clr_mobile'] = $caller_details[0]['clr_mobile'];

            //$incient_district = $this->inc_model->get_district_by_id($inc['inc_district_id']);
            //$inc['dst_name'] = $incient_district->dst_name;

            $inc_emt_data = $this->call_model->get_emt_pilot_amb_by_inc_id($inc['inc_ref_id']);


            $inc['amb_default_mobile'] = $inc_emt_data[0]->clg_mobile_no;
            $inc['amb_rto_register_no'] = $inc_emt_data[0]->amb_rto_register_no;
            $inc['amb_emt_id'] = $inc_emt_data[0]->amb_emt_id;

            $inc['amb_pilot_id'] = $inc_emt_data[0]->amb_pilot_id;

            $inc['amb_pilot_mobile'] = $inc_emt_data[0]->clg_pilot_mobile;
            $inc_data[] = $inc;
        }

        $data['ero_clg'] = $this->colleagues_model->get_all_ero($args);
        $data['inc_info'] = $inc_data;

        $args_dash['get_count'] = TRUE;
        
        $total_cnt = $this->inc_model->get_all_inc_by_date($args_dash);
        // var_dump($total_cnt);

        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("calls/terminate_calls"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc&from_date=$from_date&to_date=$to_date&pg_rec=$pg_rec&action=view"
            )
        );


        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);
        //$args = 'UG-ERO,UG-ERO-102';
        //$data['ero_clg'] = $this->colleagues_model->get_all_eros($args);

        // $this->output->add_to_position($this->load->view('frontend/calls/ero_dashboard_view', $data, TRUE), 'content', TRUE);
         $this->output->add_to_position('', 'caller_details', TRUE);
        $data['all_purpose_of_calls'] = $this->call_model->get_all_child_purpose_of_calls();
        $this->output->add_to_position($this->load->view('frontend/calls/inc_terminated_call_view', $data, TRUE), 'content', TRUE);
        // $this->output->template = "calls";
     }
     function update_call_details(){
        $parent_purpose=$this->post['parent_purpose'];
       
        $caller_call_id=$this->post['caller_call_id'];
        $call_data = array(
        'cl_purpose' => $parent_purpose,
      );

    $upadate_call_id = $this->call_model->update_call_details($call_data, $caller_call_id);
     }
     
    function get_avaya_incoming_call_record(){
         
        $current_date =date('Y-m-d H:i:s');
        $newdate =  date("Y-m-d H:i:s", (strtotime ('-1 hours' , strtotime ($current_date)))) ;
      
        
        $report_args = array('to_date' => $current_date,
                             'from_date' => $newdate);
        
         //file_put_contents('./logs/'.date("Y-m-d").'/'.date("Y-m-d").'audio_file_cron.log', json_encode($report_args).",\r\n", FILE_APPEND);
        
        $avaya_call = $this->call_model->get_avaya_audio_current_date($report_args);
        
        if($avaya_call){
            foreach($avaya_call as $avaya){
               
                if($avaya->call_audio != ''){
                    
                  
                    
                    $inc_avaya_data = array('inc_avaya_uniqueid'=>$avaya->CallUniqueID,'inc_audio_file'=>$avaya->call_audio);
                      //file_put_contents('./logs/'.date("Y-m-d").'/'.date("Y-m-d").'audio_file_cron.log', json_encode($inc_avaya_data).",\r\n", FILE_APPEND);
                    $avaya_call = $this->inc_model->update_incident_by_avayaid($inc_avaya_data);
                }
            }
        }
        die();
        
     }
     function show_photo_notification(){
         
        $mobile_no=$this->post['caller_no'];
        
         
        //$mobile_no='9730015484';
        $report_args = array('mobile_no'=>$mobile_no);
         
        $data['photo_data'] = $this->call_model->get_photo_notificatin($report_args);
         $this->output->add_to_position($this->load->view('frontend/calls/photo_notification_view', $data, TRUE), 'photo_notification', TRUE);
     }
     function show_counslor_calls(){
         
        $atend_user = $this->session->userdata('current_user');
        
       // $args = array('asign_counslor' => $atend_user->clg_ref_id);
        $args = array(
            'clg_ref_id' => $atend_user->clg_ref_id,
            'clg_group' => 'UG-COUNSELOR-104',
            'base_month' => $this->post['base_month'],
        );
           
        $data['COUNSLOR_DATA'] = $this->common_model->get_counsler_104($args);
            
        $data['COUNSLOR_CALL_DATA'] = $this->common_model->get_counsler_calls_104($args);
        $data['adv_call'] = "yes";
        $this->output->add_to_position($this->load->view('frontend/calls/counslor_call_view', $data, TRUE), 'incoming_call_nav', TRUE);
        
     }
    function show_pda_calls(){
         
        $atend_user = $this->session->userdata('current_user');
        
        $args = array('asign_pda' => $atend_user->clg_ref_id);
           
        $data['ERO_data'] = $this->inc_model->get_pda_api_calls($args);

        $this->output->add_to_position($this->load->view('frontend/calls/police_api_call_view', $data, TRUE), 'pda_incoming_call_nav', TRUE);
     }
     function selected_ambulance_address(){
         $base_id=$this->input->get();
         $report_args = array('amb_rto_register_no'=> $base_id['base_id']);
         $data['amb_data'] = $this->amb_model->get_map_amb_data($report_args);
         $data['base_selected_amb']= $base_id['base_id'];
         $report_args1 = array('rto_no'=> $base_id['base_id']);
         $amb_data = $this->amb_model->get_amb_make_model_by_regno($report_args1);
         $ambu_price = $amb_data[0]->ambu_price;
         $data['price']=$ambu_price;
         
           $this->output->add_to_position($this->load->view('frontend/inc/selected_ambulance_address_view', $data, TRUE), 'selected_ambulance_address_block', TRUE);
        
     }
}
