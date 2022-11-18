<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Trans_call extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->load->model(array('test_model', 'colleagues_model', 'inc_model', 'call_model', 'problem_reporting_model'));

        $this->load->helper(array('url', 'comman_helper'));

        $this->post = $this->input->get_post(NULL);

        $this->clg = $this->session->userdata('current_user');

        $this->post['base_month'] = get_base_month();
    }

    public function index($generated = false) {

        echo "This is Problem Reporting call controller";
    }

    /////////////////MI13/////////////////////
    //
    // Purpose : To Confirm test details.
    //
    /////////////////////////////////////

    function confirm_pda_save() {

        $this->session->unset_userdata('pda_details');
        $this->session->unset_userdata('call_id');


        $inc_details = $this->input->get_post('incient');
        $forword = $this->input->get_post('forword');
        
        $inc_id = $this->session->userdata('inc_ref_id');
        if ($inc_id == '') {
            $inc_id = generate_inc_ref_id();
            update_inc_ref_id($inc_id);
            $this->session->set_userdata('inc_ref_id', $inc_id);
        }

        $data['inc_ref_id'] = $inc_id;



        $data = array(
            'rcl_base_month' => $this->post['base_month'],
            'rcl_cl_id' => $this->post['call_id'],
            'rcl_clr_id' => $this->post['caller_id'],
            'rcl_date' => date('Y-m-d H:i:s'),
            'rcl_inc_ref_id' => $inc_id,
            'rcl_added_by' => $this->clg->clg_ref_id,
            'rcl_standard' => $this->post['rcl_standard'],
        );

        $this->session->set_userdata('pda_details', $data);


        $report_inc = array(
            'inc_ref_id' => $inc_id,
            'inc_ero_standard_summary' => $this->post['rcl_standard'],
            'inc_ero_summary' => $inc_details['inc_remark'],
            'pda_std_summary' => $inc_details['inc_ero_summary'],
            //'inc_remark' => $inc_details['inc_remark'],
            'inc_base_month' => $this->post['base_month'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_datetime' => date('Y-m-d H:i:s'),
            'inc_dispatch_time' => $inc_details['caller_dis_timer'],
            'inc_recive_time' => $inc_details['inc_recive_time'],
            'inc_type' => $inc_details['inc_type'],
            'inc_cl_id' => $this->post['call_id'],
            'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
        );
        if($inc_details['inc_remark'] != ''){
            $report_inc['inc_remark']=$inc_details['inc_remark'] ;
        }

     

        $this->session->set_userdata('report_incidence_details', $report_inc);
        $data1['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inc_details['inc_ero_standard_summary']));

        $data['forword'] = $forword;
        $data['re_name'] = $this->post['rcl_standard'];
        $data['inc_ero_summary'] = $inc_details['inc_remark'];
         $data['pda_std_summary'] = $inc_details['inc_ero_summary'];

        $this->output->add_to_popup($this->load->view('frontend/call_transfer/pda_confirm_report_view', $data, TRUE), '600', '250');
    }

    //// Created by MI13 ////////////////////
    // 
    // Purpose : To save and forword test details.
    // 
    /////////////////////////////////////////

    function pda_save() {

//        if ($this->post['fwd_test_call']) {

        $args = $this->session->userdata('pda_details');



        //$rcl_id = $this->problem_reporting_model->insert_prob_report($args);

        $inc_args = $this->session->userdata('report_incidence_details');
        
        $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_args['inc_ref_id']));
        if(!empty($is_exits)){
             $this->session->set_userdata('inc_ref_id','');
            $this->output->add_to_position("<script>alert('Incident Id already exists !! Cancel and dispatch again')</script>", 'custom_script', TRUE);
        }

        $inc_data = $this->inc_model->insert_inc($inc_args);


        $inc_id = $inc_args['inc_ref_id'];
        


        $arg = array(
            'sub_id' => $inc_args['inc_ref_id'],
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'base_month' => $this->post['base_month'],
            'sub_type' => 'TRANS_PDA'
        );
       
        $res = $this->common_model->assign_operator($arg);
        //////////////////////forword///////////////////////


        if ($this->post['fwd_all'] == 'yes') {


            $police_user = $this->inc_model->get_fire_user($sr_user, 'UG-PDA');
            if($police_user){

                $police_operator2 = array(
                    'sub_id' => $inc_id,
                    'operator_id' => $police_user->clg_ref_id,
                    'operator_type' => 'UG-PDA',
                    'sub_status' => 'ASG',
                    'sub_type' => 'TRANS_PDA',
                    'base_month' => $this->post['base_month']
                );

                $police_operator = $this->common_model->assign_operator($police_operator2);
            }
        }


        //////////////////////////////////////////////////////            

        if ($inc_data) {

            $this->output->status = 1;

            $this->output->closepopup = "yes";
            $url = base_url("calls");
            $this->output->message = "<h3>Call Transfer to PDA</h3><br><p>Call Transfer to PDA forwarded successfully.</p><script>window.location.href = '".$url."';</script>";

            $this->output->moveto = 'top';

            $this->output->add_to_position('', 'content', TRUE);
        }
//        }
    }
    
        /////////////////MI13/////////////////////
    //
    // Purpose : To Confirm test details.
    //
    /////////////////////////////////////
    function confirm_fleet_save(){
        $this->session->unset_userdata('fleet_details');
        $this->session->unset_userdata('call_id');
        $this->session->unset_userdata('report_incidence_details');


        $inc_details = $this->input->get_post('incient');
        $forword = $this->input->get_post('forword');
        
        $inc_id = $this->session->userdata('inc_ref_id');
        if ($inc_id == '') {
            $inc_id = generate_inc_ref_id();
            update_inc_ref_id($inc_id);
            $this->session->set_userdata('inc_ref_id', $inc_id);
        }

        $data['inc_ref_id'] = $inc_id;



        $data = array(
            'rcl_base_month' => $this->post['base_month'],
            'rcl_cl_id' => $this->post['call_id'],
            'rcl_clr_id' => $this->post['caller_id'],
            'rcl_date' => date('Y-m-d H:i:s'),
            'rcl_inc_ref_id' => $inc_id,
            'rcl_added_by' => $this->clg->clg_ref_id,
            'rcl_standard' => $this->post['rcl_standard'],
        );

        $this->session->set_userdata('fleet_details', $data);


        $report_inc = array(
            'inc_ref_id' => $inc_id,
            'inc_ero_standard_summary' => $this->post['rcl_standard'],
            'inc_ero_summary' => $inc_details['inc_ero_summary'],
            'fda_std_summary' => $inc_details['inc_ero_standard_summary'],
            // 'inc_remark' => $inc_details['inc_remark'],
            'inc_base_month' => $this->post['base_month'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_datetime' => date('Y-m-d H:i:s'),
            'inc_dispatch_time' => $inc_details['caller_dis_timer'],
            'inc_recive_time' => $inc_details['inc_recive_time'],
            'inc_type' => $inc_details['inc_type'],
            'inc_cl_id' => $this->post['call_id'],
            'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
        );
        if($inc_details['inc_remark'] != ''){
            $report_inc['inc_remark']=$inc_details['inc_remark'] ;
        }

     
       // var_dump($report_inc);die();
        $this->session->set_userdata('report_incidence_details', $report_inc);
        $data1['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inc_details['inc_ero_standard_summary']));

        $data['forword'] = $forword;
        $data['re_name'] = $this->post['rcl_standard'];
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];
        $data['inc_ero_standard_summary_new'] = $inc_details['inc_ero_standard_summary'];
        $data['inc_remark'] = $inc_details['inc_remark'];

        $this->output->add_to_popup($this->load->view('frontend/call_transfer/fleet_confirm_report_view', $data, TRUE), '600', '250');
    
    }
    function confirm_situational_save(){
        $this->session->unset_userdata('situational_details');
        $this->session->unset_userdata('call_id');
        $this->session->unset_userdata('report_incidence_details');


        $inc_details = $this->input->get_post('incient');
        $forword = $this->input->get_post('forword');
        
        $inc_id = $this->session->userdata('inc_ref_id');
        if ($inc_id == '') {
            $inc_id = generate_inc_ref_id();
            update_inc_ref_id($inc_id);
            $this->session->set_userdata('inc_ref_id', $inc_id);
        }

        $data['inc_ref_id'] = $inc_id;



        $data = array(
            'rcl_base_month' => $this->post['base_month'],
            'rcl_cl_id' => $this->post['call_id'],
            'rcl_clr_id' => $this->post['caller_id'],
            'rcl_date' => date('Y-m-d H:i:s'),
            'rcl_inc_ref_id' => $inc_id,
            'rcl_added_by' => $this->clg->clg_ref_id,
            'rcl_standard' => $this->post['rcl_standard'],
        );

        $this->session->set_userdata('situational_details', $data);


        $report_inc = array(
            'inc_ref_id' => $inc_id,
            'inc_ero_standard_summary' => $this->post['rcl_standard'],
            'inc_ero_summary' => $inc_details['inc_ero_summary'],
            'fda_std_summary' => $inc_details['inc_ero_standard_summary'],
            // 'inc_remark' => $inc_details['inc_remark'],
            'inc_base_month' => $this->post['base_month'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_datetime' => date('Y-m-d H:i:s'),
            'inc_dispatch_time' => $inc_details['caller_dis_timer'],
            'inc_recive_time' => $inc_details['inc_recive_time'],
            'inc_type' => $inc_details['inc_type'],
            'inc_cl_id' => $this->post['call_id'],
            'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
        );
        if($inc_details['inc_remark'] != ''){
            $report_inc['inc_remark']=$inc_details['inc_remark'] ;
        }

     
       // var_dump($report_inc);die();
        $this->session->set_userdata('report_incidence_details', $report_inc);
        $data1['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inc_details['inc_ero_standard_summary']));

        $data['forword'] = $forword;
        $data['re_name'] = $this->post['rcl_standard'];
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];
        $data['inc_ero_standard_summary_new'] = $inc_details['inc_ero_standard_summary'];
        $data['inc_remark'] = $inc_details['inc_remark'];

        $this->output->add_to_popup($this->load->view('frontend/call_transfer/situational_confirm_report_view', $data, TRUE), '600', '250');
    

    }
    function confirm_tdd_save(){
        $this->session->unset_userdata('tdd_details');
        $this->session->unset_userdata('call_id');
        $this->session->unset_userdata('report_incidence_details');


        $inc_details = $this->input->get_post('incient');
        $forword = $this->input->get_post('forword');
        
        $inc_id = $this->session->userdata('inc_ref_id');
        if ($inc_id == '') {
            $inc_id = generate_inc_ref_id();
            update_inc_ref_id($inc_id);
            $this->session->set_userdata('inc_ref_id', $inc_id);
        }

        $data['inc_ref_id'] = $inc_id;



        $data = array(
            'rcl_base_month' => $this->post['base_month'],
            'rcl_cl_id' => $this->post['call_id'],
            'rcl_clr_id' => $this->post['caller_id'],
            'rcl_date' => date('Y-m-d H:i:s'),
            'rcl_inc_ref_id' => $inc_id,
            'rcl_added_by' => $this->clg->clg_ref_id,
            'rcl_standard' => $this->post['rcl_standard'],
        );

        $this->session->set_userdata('tdd_details', $data);


        $report_inc = array(
            'inc_ref_id' => $inc_id,
            'inc_ero_standard_summary' => $this->post['rcl_standard'],
            'inc_ero_summary' => $inc_details['inc_ero_summary'],
            'fda_std_summary' => $inc_details['inc_ero_standard_summary'],
            // 'inc_remark' => $inc_details['inc_remark'],
            'inc_base_month' => $this->post['base_month'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_datetime' => date('Y-m-d H:i:s'),
            'inc_dispatch_time' => $inc_details['caller_dis_timer'],
            'inc_recive_time' => $inc_details['inc_recive_time'],
            'inc_type' => $inc_details['inc_type'],
            'inc_cl_id' => $this->post['call_id'],
            'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
        );
        if($inc_details['inc_remark'] != ''){
            $report_inc['inc_remark']=$inc_details['inc_remark'] ;
        }

     
       // var_dump($report_inc);die();
        $this->session->set_userdata('report_incidence_details', $report_inc);
        $data1['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inc_details['inc_ero_standard_summary']));

        $data['forword'] = $forword;
        $data['re_name'] = $this->post['rcl_standard'];
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];
        $data['inc_ero_standard_summary_new'] = $inc_details['inc_ero_standard_summary'];
        $data['inc_remark'] = $inc_details['inc_remark'];

        $this->output->add_to_popup($this->load->view('frontend/call_transfer/tdd_confirm_report_view', $data, TRUE), '600', '250');
    

    }
    function confirm_bike_save() {

        $this->session->unset_userdata('bike_details');
        $this->session->unset_userdata('call_id');
        $this->session->unset_userdata('report_incidence_details');


        $inc_details = $this->input->get_post('incient');
        $forword = $this->input->get_post('forword');
        
        $inc_id = $this->session->userdata('inc_ref_id');
        if ($inc_id == '') {
            $inc_id = generate_inc_ref_id();
            update_inc_ref_id($inc_id);
            $this->session->set_userdata('inc_ref_id', $inc_id);
        }

        $data['inc_ref_id'] = $inc_id;



        $data = array(
            'rcl_base_month' => $this->post['base_month'],
            'rcl_cl_id' => $this->post['call_id'],
            'rcl_clr_id' => $this->post['caller_id'],
            'rcl_date' => date('Y-m-d H:i:s'),
            'rcl_inc_ref_id' => $inc_id,
            'rcl_added_by' => $this->clg->clg_ref_id,
            'rcl_standard' => $this->post['rcl_standard'],
        );

        $this->session->set_userdata('bike_details', $data);


        $report_inc = array(
            'inc_ref_id' => $inc_id,
            'inc_ero_standard_summary' => $this->post['rcl_standard'],
            'inc_ero_summary' => $inc_details['inc_ero_summary'],
            'fda_std_summary' => $inc_details['inc_ero_standard_summary'],
            // 'inc_remark' => $inc_details['inc_remark'],
            'inc_base_month' => $this->post['base_month'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_datetime' => date('Y-m-d H:i:s'),
            'inc_dispatch_time' => $inc_details['caller_dis_timer'],
            'inc_recive_time' => $inc_details['inc_recive_time'],
            'inc_type' => $inc_details['inc_type'],
            'inc_cl_id' => $this->post['call_id'],
            'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
        );
        if($inc_details['inc_remark'] != ''){
            $report_inc['inc_remark']=$inc_details['inc_remark'] ;
        }

     
       // var_dump($report_inc);die();
        $this->session->set_userdata('report_incidence_details', $report_inc);
        $data1['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inc_details['inc_ero_standard_summary']));

        $data['forword'] = $forword;
        $data['re_name'] = $this->post['rcl_standard'];
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];
        $data['inc_ero_standard_summary_new'] = $inc_details['inc_ero_standard_summary'];
        $data['inc_remark'] = $inc_details['inc_remark'];

        $this->output->add_to_popup($this->load->view('frontend/call_transfer/bike_confirm_report_view', $data, TRUE), '600', '250');
    }
    function confirm_fda_save() {

        $this->session->unset_userdata('fda_details');
        $this->session->unset_userdata('call_id');
        $this->session->unset_userdata('report_incidence_details');


        $inc_details = $this->input->get_post('incient');
        $forword = $this->input->get_post('forword');
        
        $inc_id = $this->session->userdata('inc_ref_id');
        if ($inc_id == '') {
            $inc_id = generate_inc_ref_id();
            update_inc_ref_id($inc_id);
            $this->session->set_userdata('inc_ref_id', $inc_id);
        }

        $data['inc_ref_id'] = $inc_id;



        $data = array(
            'rcl_base_month' => $this->post['base_month'],
            'rcl_cl_id' => $this->post['call_id'],
            'rcl_clr_id' => $this->post['caller_id'],
            'rcl_date' => date('Y-m-d H:i:s'),
            'rcl_inc_ref_id' => $inc_id,
            'rcl_added_by' => $this->clg->clg_ref_id,
            'rcl_standard' => $this->post['rcl_standard'],
        );

        $this->session->set_userdata('fda_details', $data);


        $report_inc = array(
            'inc_ref_id' => $inc_id,
            'inc_ero_standard_summary' => $this->post['rcl_standard'],
            'inc_ero_summary' => $inc_details['inc_ero_summary'],
            'fda_std_summary' => $inc_details['inc_ero_standard_summary'],
            // 'inc_remark' => $inc_details['inc_remark'],
            'inc_base_month' => $this->post['base_month'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_datetime' => date('Y-m-d H:i:s'),
            'inc_dispatch_time' => $inc_details['caller_dis_timer'],
            'inc_recive_time' => $inc_details['inc_recive_time'],
            'inc_type' => $inc_details['inc_type'],
            'inc_cl_id' => $this->post['call_id'],
            'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
        );
        if($inc_details['inc_remark'] != ''){
            $report_inc['inc_remark']=$inc_details['inc_remark'] ;
        }

     
       // var_dump($report_inc);die();
        $this->session->set_userdata('report_incidence_details', $report_inc);
        $data1['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inc_details['inc_ero_standard_summary']));

        $data['forword'] = $forword;
        $data['re_name'] = $this->post['rcl_standard'];
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];
        $data['inc_ero_standard_summary_new'] = $inc_details['inc_ero_standard_summary'];
        $data['inc_remark'] = $inc_details['inc_remark'];

        $this->output->add_to_popup($this->load->view('frontend/call_transfer/fda_confirm_report_view', $data, TRUE), '600', '250');
    }

    //// Created by MI13 ////////////////////
    // 
    // Purpose : To save and forword test details.
    // 
    /////////////////////////////////////////
    function fleet_save(){
        //        if ($this->post['fwd_test_call']) {

            $args = $this->session->userdata('fleet_details');



            //  $rcl_id = $this->problem_reporting_model->insert_prob_report($args);
       
               $inc_args = $this->session->userdata('report_incidence_details');
         // var_dump($inc_args);
                $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_args['inc_ref_id']));
                if(!empty($is_exits)){
                    $this->session->set_userdata('inc_ref_id','');
                    $this->output->add_to_position("<script>alert('Incident Id already exists !! Cancel and dispatch again')</script>", 'custom_script', TRUE);
                }
               $inc_data = $this->inc_model->insert_inc($inc_args);
       
               
       
               $inc_id = $inc_args['inc_ref_id'];
               
       
       
               $arg = array(
                   'sub_id' => $inc_id,
                   'operator_id' => $this->clg->clg_ref_id,
                   'operator_type' => $this->clg->clg_group,
                   'base_month' => $this->post['base_month'],
                   'sub_type' => 'TRANS_FDA'
               );
              
               $res = $this->common_model->assign_operator($arg);
               //die();
               //////////////////////forword///////////////////////
       
       
               if ($this->post['fwd_all'] == 'yes') {
       
       
                   $police_user = $this->inc_model->get_fire_user($sr_user, 'UG-FDA');
                   if($police_user){
       
                       $police_operator2 = array(
                           'sub_id' => $inc_id,
                           'operator_id' => $police_user->clg_ref_id,
                           'operator_type' => 'UG-FLEETDESK',
                           'sub_status' => 'ASG',
                           'sub_type' => $inc_args['inc_type'],
                           'base_month' => $this->post['base_month']
                       );
       
                       $police_operator = $this->common_model->assign_operator($police_operator2);
                   }
               }
       
       
               //////////////////////////////////////////////////////            
       
               if ($inc_data) {
       
                   $this->output->status = 1;
       
                   $this->output->closepopup = "yes";
       
                   $url = base_url("calls");
                   $this->output->message = "<h3>Call Transfer to Fleet</h3><br><p>Call Transfer to Fleet forwarded successfully.</p><script>window.location.href = '".$url."';</script>";
       
                   $this->output->moveto = 'top';
       
                   $this->output->add_to_position('', 'content', TRUE);
               }
       //        }
    }
    function tdd_save(){
        //        if ($this->post['fwd_test_call']) {

            $args = $this->session->userdata('tdd_details');



            //  $rcl_id = $this->problem_reporting_model->insert_prob_report($args);
       
               $inc_args = $this->session->userdata('report_incidence_details');
               
                $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_args['inc_ref_id']));
            if(!empty($is_exits)){
                $this->session->set_userdata('inc_ref_id','');
                $this->output->add_to_position("<script>alert('Incident Id already exists !! Cancel and dispatch again')</script>", 'custom_script', TRUE);
            }
         
               $inc_data = $this->inc_model->insert_inc($inc_args);
       
               
       
               $inc_id = $inc_args['inc_ref_id'];
               
       
       
               $arg = array(
                   'sub_id' => $inc_id,
                   'operator_id' => $this->clg->clg_ref_id,
                   'operator_type' => $this->clg->clg_group,
                   'base_month' => $this->post['base_month'],
                   'sub_type' => 'TRANS_FDA'
               );
              
               $res = $this->common_model->assign_operator($arg);
               //die();
               //////////////////////forword///////////////////////
       
       
               if ($this->post['fwd_all'] == 'yes') {
       
       
                   $police_user = $this->inc_model->get_fire_user($sr_user, 'UG-FDA');
                   if($police_user){
       
                       $police_operator2 = array(
                           'sub_id' => $inc_id,
                           'operator_id' => $police_user->clg_ref_id,
                           'operator_type' => 'UG-BIKE',
                           'sub_status' => 'ASG',
                           'sub_type' => $inc_args['inc_type'],
                           'base_month' => $this->post['base_month']
                       );
       
                       $police_operator = $this->common_model->assign_operator($police_operator2);
                   }
               }
       
       
               //////////////////////////////////////////////////////            
       
               if ($inc_data) {
       
                   $this->output->status = 1;
       
                   $this->output->closepopup = "yes";
                   $url = base_url("calls");
                   $this->output->message = "<h3>Call Transfer to TDD</h3><br><p>Call Transfer to TDD forwarded successfully.</p><script>window.location.href = '".$url."';</script>";
       
                   $this->output->moveto = 'top';
       
                   $this->output->add_to_position('', 'content', TRUE);
               }
       //        }
    }
    function situational_save(){
       //        if ($this->post['fwd_test_call']) {

        $args = $this->session->userdata('situational_details');



        //  $rcl_id = $this->problem_reporting_model->insert_prob_report($args);
   
           $inc_args = $this->session->userdata('report_incidence_details');
     // var_dump($inc_args);
           
            $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_args['inc_ref_id']));
        if(!empty($is_exits)){
             $this->session->set_userdata('inc_ref_id','');
               $this->output->add_to_position("<script>alert('Incident Id already exists !! Cancel and dispatch again')</script>", 'custom_script', TRUE);
        }
           $inc_data = $this->inc_model->insert_inc($inc_args);
   
           
   
           $inc_id = $inc_args['inc_ref_id'];
           
   
   
           $arg = array(
               'sub_id' => $inc_id,
               'operator_id' => $this->clg->clg_ref_id,
               'operator_type' => $this->clg->clg_group,
               'base_month' => $this->post['base_month'],
               'sub_type' => 'TRANS_FDA'
           );
          
           $res = $this->common_model->assign_operator($arg);
           //die();
           //////////////////////forword///////////////////////
   
   
           if ($this->post['fwd_all'] == 'yes') {
   
            $sr_user = $this->clg->clg_ref_id;
               $situational_user = $this->inc_model->get_situational_desk_user($sr_user, 'UG-SITUATIONAL-DESK');
               if($situational_user){
   
                   $situational_user_array = array(
                       'sub_id' => $inc_id,
                       'operator_id' => $situational_user->clg_ref_id,
                       'operator_type' => 'UG-SITUATIONAL-DESK',
                       'sub_status' => 'ASG',
                       'sub_type' => $inc_args['inc_type'],
                       'base_month' => $this->post['base_month']
                   );
   
                   $situational_operator = $this->common_model->assign_operator($situational_user_array);
               }
           }
   
   
           //////////////////////////////////////////////////////            
   
           if ($inc_data) {
   
               $this->output->status = 1;
   
               $this->output->closepopup = "yes";
               $url = base_url("calls");
               $this->output->message = "<h3>Call Transfer to Situational Desk</h3><br><p>Call Transfer to Situational forwarded successfully.</p><script>window.location.href = '".$url."';</script>";
   
               $this->output->moveto = 'top';
   
               $this->output->add_to_position('', 'content', TRUE);
           }
   //        } 
    }
    function bike_save(){
        //        if ($this->post['fwd_test_call']) {

            $args = $this->session->userdata('bike_details');



            //  $rcl_id = $this->problem_reporting_model->insert_prob_report($args);
       
               $inc_args = $this->session->userdata('report_incidence_details');
         // var_dump($inc_args);
                $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_args['inc_ref_id']));
        if(!empty($is_exits)){
             $this->session->set_userdata('inc_ref_id','');
               $this->output->add_to_position("<script>alert('Incident Id already exists !! Cancel and dispatch again')</script>", 'custom_script', TRUE);
        }
               $inc_data = $this->inc_model->insert_inc($inc_args);
       
               
       
               $inc_id = $inc_args['inc_ref_id'];
               
       
       
               $arg = array(
                   'sub_id' => $inc_id,
                   'operator_id' => $this->clg->clg_ref_id,
                   'operator_type' => $this->clg->clg_group,
                   'base_month' => $this->post['base_month'],
                   'sub_type' => 'TRANS_FDA'
               );
              
               $res = $this->common_model->assign_operator($arg);
               //die();
               //////////////////////forword///////////////////////
       
       
               if ($this->post['fwd_all'] == 'yes') {
       
       
                   $police_user = $this->inc_model->get_fire_user($sr_user, 'UG-FDA');
                   if($police_user){
       
                       $police_operator2 = array(
                           'sub_id' => $inc_id,
                           'operator_id' => $police_user->clg_ref_id,
                           'operator_type' => 'UG-BIKE',
                           'sub_status' => 'ASG',
                           'sub_type' => $inc_args['inc_type'],
                           'base_month' => $this->post['base_month']
                       );
       
                       $police_operator = $this->common_model->assign_operator($police_operator2);
                   }
               }
       
       
               //////////////////////////////////////////////////////            
       
               if ($inc_data) {
       
                   $this->output->status = 1;
       
                   $this->output->closepopup = "yes";
                   $url = base_url("calls");
       
                   $this->output->message = "<h3>Call Transfer to Bike</h3><br><p>Call Transfer to Bike forwarded successfully.</p><script>window.location.href = '".$url."';</script>";
       
                   $this->output->moveto = 'top';
       
                   $this->output->add_to_position('', 'content', TRUE);
               }
       //        }
    }
    function fda_save() {

//        if ($this->post['fwd_test_call']) {

        $args = $this->session->userdata('fda_details');



     //  $rcl_id = $this->problem_reporting_model->insert_prob_report($args);

        $inc_args = $this->session->userdata('report_incidence_details');
  // var_dump($inc_args);
         $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_args['inc_ref_id']));
        if(!empty($is_exits)){
             $this->session->set_userdata('inc_ref_id','');
             $this->output->add_to_position("<script>alert('Incident Id already exists !! Cancel and dispatch again')</script>", 'custom_script', TRUE);
        }
        $inc_data = $this->inc_model->insert_inc($inc_args);

        

        $inc_id = $inc_args['inc_ref_id'];
        


        $arg = array(
            'sub_id' => $inc_id,
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'base_month' => $this->post['base_month'],
            'sub_type' => 'TRANS_FDA'
        );
       
        $res = $this->common_model->assign_operator($arg);
        //die();
        //////////////////////forword///////////////////////


        if ($this->post['fwd_all'] == 'yes') {


            $police_user = $this->inc_model->get_fire_user($sr_user, 'UG-FDA');
            if($police_user){

                $police_operator2 = array(
                    'sub_id' => $inc_id,
                    'operator_id' => $police_user->clg_ref_id,
                    'operator_type' => 'UG-FDA',
                    'sub_status' => 'ASG',
                    'sub_type' => $inc_args['inc_type'],
                    'base_month' => $this->post['base_month']
                );

                $police_operator = $this->common_model->assign_operator($police_operator2);
            }
        }


        //////////////////////////////////////////////////////            

        if ($inc_data) {

            $this->output->status = 1;

            $this->output->closepopup = "yes";

            $url = base_url("calls");
            $this->output->message = "<h3>Call Transfer to FDA</h3><br><p>Call Transfer to FDA forwarded successfully.</p><script>window.location.href = '".$url."';</script>";

            $this->output->moveto = 'top';

            $this->output->add_to_position('', 'content', TRUE);
        }
//        }
    }


}
