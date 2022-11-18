<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Non_Eme_Calls extends EMS_Controller {

    function __construct() {

        parent::__construct();



        $this->pg_limit = $this->config->item('pagination_limit');

        $this->pg_limits = $this->config->item('report_clg');

        $this->load->model(array('call_model', 'get_city_state_model', 'options_model', 'module_model', 'common_model', 'Pet_model', 'Ercp_model', 'amb_model', 'inc_model', 'colleagues_model', 'pcr_model', 'cluster_model', 'medadv_model', 'non_eme_call_model', 'pet_model'));

        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper', 'language_helper'));

        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));


        $this->site_name = $this->config->item('site_name');
        $this->post['base_month'] = get_base_month();

        $this->site = $this->config->item('site');
        $this->clg = $this->session->userdata('current_user');



        $this->post['base_month'] = get_base_month();
        $this->clg = $this->session->userdata('current_user');

//        $this->dtmf="00:00:00";
//            
//        $this->dtmt="24:00:00";
    }

    Public function save_non_eme_call_details() {

        $form_call_data = $this->input->post('non_eme_call', TRUE);
        $atend_user = $this->session->userdata('current_user');


        if ($form_call_data["cl_type"] === 'ABUSED_CALL') {

            $data['cl_type'] = 'ABUSED_CALL';

            $this->output->add_to_position($this->load->view('frontend/non_eme_calls/abuse_call_form_view', $data, TRUE), 'non_eme_call', TRUE);
        } else if ($form_call_data["cl_type"] === 'ABU_NOT_COUN_CALL') {

            $data['cl_type'] = 'ABU_NOT_COUN_CALL';

            $this->output->add_to_position($this->load->view('frontend/non_eme_calls/abuse_call_form_view', $data, TRUE), 'non_eme_call', TRUE);
        } else if ($form_call_data["cl_type"] === 'ABU_COUN_CALL') {

            $data['cl_type'] = 'ABU_COUN_CALL';

            $this->output->add_to_position($this->load->view('frontend/non_eme_calls/abuse_coun_call_form_view', $data, TRUE), 'non_eme_call', TRUE);
        } else if ($form_call_data["cl_type"] === 'MISS_CALL') {

            $data['cl_type'] = 'MISS_CALL';

            $this->output->add_to_position($this->load->view('frontend/non_eme_calls/miss_call_form_view', $data, TRUE), 'non_eme_call', TRUE);
        } else if ($form_call_data["cl_type"] === 'APP_CALL') {

            $caller_no = $this->session->userdata('caller_no');
            $args = array(
                'clr_mobile' => $caller_no
            );
            $data['purpose_of_calls'] = $this->call_model->get_purpose_of_calls();
            $data[inc_details] = $this->call_model->get_incedence_details_by_c_no($args);


            $data['cl_type'] = 'APP_CALL';

            $this->output->add_to_position($this->load->view('frontend/non_eme_calls/app_call_form_view', $data, TRUE), 'non_eme_call', TRUE);
        } else if ($form_call_data["cl_type"] === 'UNATT_CALL') {

            $data['cl_type'] = 'UNATT_CALL';

            $this->output->add_to_position($this->load->view('frontend/non_eme_calls/unattend_call_form_view', $data, TRUE), 'non_eme_call', TRUE);
        } else if ($form_call_data["cl_type"] === 'DISS_CON_CALL') {

            $data['cl_type'] = 'DISS_CON_CALL';

            $this->output->add_to_position($this->load->view('frontend/non_eme_calls/disconnected_call_form_view', $data, TRUE), 'non_eme_call', TRUE);
        } else if ($form_call_data["cl_type"] === 'DUP_CALL') {

            $data['cl_type'] = 'DUP_CALL';

            $this->output->add_to_position($this->load->view('frontend/non_eme_calls/dupblicated_call_form_view', $data, TRUE), 'non_eme_call', TRUE);
        } else if ($form_call_data["cl_type"] === 'AMB_NOT_AVA') {

            $data['cl_type'] = 'AMB_NOT_AVA';

            $this->output->add_to_position($this->load->view('frontend/non_eme_calls/amb_no_ava_call_form_view', $data, TRUE), 'non_eme_call', TRUE);
        } else if ($form_call_data["cl_type"] === 'NO_RES_CALL') {

            $data['cl_type'] = 'NO_RES_CALL';

            $this->output->add_to_position($this->load->view('frontend/non_eme_calls/no_resp_call_form_view', $data, TRUE), 'non_eme_call', TRUE);
        } else if ($form_call_data["cl_type"] === 'WRONG_CALL') {

            $data['cl_type'] = 'WRONG_CALL';

            $this->output->add_to_position($this->load->view('frontend/non_eme_calls/wrong_call_form_view', $data, TRUE), 'non_eme_call', TRUE);
        } else if ($form_call_data["cl_type"] === 'NUS_CALL') {

            $data['cl_type'] = 'NUS_CALL';

            $this->output->add_to_position($this->load->view('frontend/non_eme_calls/nusion_call_form_view', $data, TRUE), 'non_eme_call', TRUE);
        } else if ($form_call_data["cl_type"] === 'SLI_CALL') {

            $data['cl_type'] = 'SLI_CALL';

            $this->output->add_to_position($this->load->view('frontend/non_eme_calls/slient_call_form_view', $data, TRUE), 'non_eme_call', TRUE);
        } else if ($form_call_data["cl_type"] === 'SUGG_CALL') {

            $data['cl_type'] = 'SUGG_CALL';

            $this->output->add_to_position($this->load->view('frontend/non_eme_calls/suggested_call_form_view', $data, TRUE), 'non_eme_call', TRUE);
        }
    }

    function abuse_confirm_save() {

        $this->session->unset_userdata('ambuse_call_details');
        $this->session->unset_userdata('call_id');
        $this->session->unset_userdata('inc_ref_id');


        $inc_details = $this->input->get_post('incient');

        $non_eme_call = $this->input->get_post('non_eme_call');



        //$inc_id = $this->session->userdata('inc_ref_id');
//        if ($inc_id == '') {
//            $inc_id = generate_inc_ref_id();
//            update_inc_ref_id($inc_id);
//            $this->session->set_userdata('inc_ref_id', $inc_id);
//        }
        if ($inc_id == '' && $this->clg->clg_group != 'UG-BIKE-ERO') {
            $inc_id = generate_inc_ref_id();
            update_inc_ref_id($inc_id);
            $this->session->set_userdata('inc_ref_id', $inc_id);
           
            
        }else if($this->clg->clg_group == 'UG-BIKE-ERO'){
                $inc_id = "BK-".generate_bk_inc_ref_id();
                $this->session->set_userdata('inc_ref_id', $inc_id);
                update_inc_ref_id($inc_id);
        }


        $data['inc_ref_id'] = $inc_id;

        $data = array(
            'ncl_base_month' => $this->post['base_month'],
            'ncl_cl_id' => $this->input->post('call_id'),
            'ncl_clr_id' => $this->input->post('caller_id'),
            'ncl_date' => date('Y-m-d H:i:s'),
            'ncl_inc_ref_id' => $inc_id,
            'ncl_added_by' => $this->clg->clg_ref_id,
            'nclis_deleted' => '0',
            'ncl_call_type' => $non_eme_call['cl_type'],
        );

        $this->session->set_userdata('ambuse_call_details', $data);

         if($inc_details['CallUniqueID'] == ''){
            $CallUniqueID = $this->session->userdata('CallUniqueID');
            
        }else{
            $CallUniqueID = $inc_details['CallUniqueID'];
        }

        $ambuse_call = array(
            'inc_ref_id' => $inc_id,
            'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
            'inc_ero_summary' => $inc_details['inc_ero_summary'],
            'inc_avaya_uniqueid' => $CallUniqueID,
            'inc_base_month' => $this->post['base_month'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_datetime' => date('Y-m-d H:i:s'),
            'inc_dispatch_time' => $inc_details['caller_dis_timer'],
            'inc_recive_time' => $inc_details['inc_recive_time'],
            'inc_type' => $non_eme_call['cl_type'],
            'inc_cl_id' => $this->input->post('call_id')
        );


        $this->session->set_userdata('amb_call_inc_details', $ambuse_call);
        $data1['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inc_details['inc_ero_standard_summary']));

        $data['re_name'] = $data1['standard_remark'][0]->re_name;
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];

        if ($non_eme_call['cl_type'] == 'ABU_NOT_COUN_CALL') {
            $this->output->add_to_popup($this->load->view('frontend/non_eme_calls/confirm_ambuse_call_view', $data, TRUE), '600', '250');
        }else if ($non_eme_call['cl_type'] == 'ABUSED_CALL') {
            $this->output->add_to_popup($this->load->view('frontend/non_eme_calls/confirm_ambuse_view', $data, TRUE), '600', '250');
        } else if ($non_eme_call['cl_type'] == 'ABU_COUN_CALL') {
            $this->output->add_to_popup($this->load->view('frontend/non_eme_calls/confirm_ambuse_coun_call_view', $data, TRUE), '600', '250');
        } else if ($non_eme_call['cl_type'] == 'MISS_CALL') {
            $this->output->add_to_popup($this->load->view('frontend/non_eme_calls/confirm_miss_call_view', $data, TRUE), '600', '250');
        } else if ($non_eme_call['cl_type'] == 'APP_CALL') {
            $this->output->add_to_popup($this->load->view('frontend/non_eme_calls/confirm_app_call_view', $data, TRUE), '600', '250');
        } else if ($non_eme_call['cl_type'] == 'UNATT_CALL') {
            $this->output->add_to_popup($this->load->view('frontend/non_eme_calls/confirm_unatt_call_view', $data, TRUE), '600', '250');
        } else if ($non_eme_call['cl_type'] == 'DISS_CON_CALL') {
            $this->output->add_to_popup($this->load->view('frontend/non_eme_calls/confirm_disconnected_call_view', $data, TRUE), '600', '250');
        } else if ($non_eme_call['cl_type'] == 'DUP_CALL') {
            $this->output->add_to_popup($this->load->view('frontend/non_eme_calls/confirm_dupb_call_view', $data, TRUE), '600', '250');
        } else if ($non_eme_call['cl_type'] == 'AMB_NOT_AVA') {
            $this->output->add_to_popup($this->load->view('frontend/non_eme_calls/confirm_avt_to_amb_call_view', $data, TRUE), '600', '250');
        } else if ($non_eme_call['cl_type'] == 'NO_RES_CALL') {
            $this->output->add_to_popup($this->load->view('frontend/non_eme_calls/confirm_no_resp_call_view', $data, TRUE), '600', '250');
        } else if ($non_eme_call['cl_type'] == 'WRONG_CALL') {
            $this->output->add_to_popup($this->load->view('frontend/non_eme_calls/confirm_wrong_call_view', $data, TRUE), '600', '250');
        } else if ($non_eme_call['cl_type'] == 'NUS_CALL') {
            $this->output->add_to_popup($this->load->view('frontend/non_eme_calls/confirm_nusion_call_view', $data, TRUE), '600', '250');
        } else if ($non_eme_call['cl_type'] == 'SLI_CALL') {
            $this->output->add_to_popup($this->load->view('frontend/non_eme_calls/confirm_slient_call_view', $data, TRUE), '600', '250');
        } else if ($non_eme_call['cl_type'] == 'SUGG_CALL') {
            $this->output->add_to_popup($this->load->view('frontend/non_eme_calls/confirm_suggested_call_view', $data, TRUE), '600', '250');
        }else if ($non_eme_call['cl_type'] == 'CHILD_CALL') {
            $this->output->add_to_popup($this->load->view('frontend/non_eme_calls/confirm_child_call_view', $data, TRUE), '600', '250');
        }else if ($non_eme_call['cl_type'] == 'ESCALATION_CALL') {
            $this->output->add_to_popup($this->load->view('frontend/non_eme_calls/confirm_escalation_call_view', $data, TRUE), '600', '250');
        }else if ($non_eme_call['cl_type'] == 'DEMO_CALL') {
            $this->output->add_to_popup($this->load->view('frontend/non_eme_calls/confirm_demo_call_view', $data, TRUE), '600', '250');
        }else if ($non_eme_call['cl_type'] == 'SERVICE_NOT_REQUIRED') {
            $this->output->add_to_popup($this->load->view('frontend/non_eme_calls/confirm_service_call_view', $data, TRUE), '600', '250');
        }else if ($non_eme_call['cl_type'] == 'APP_SUPPORT_CALL') {
            $this->output->add_to_popup($this->load->view('frontend/non_eme_calls/confirm_app_support_call_view', $data, TRUE), '600', '250');
        }
    }
    
    
    
    
    function app_confirm_save() {

        $this->session->unset_userdata('ambuse_call_details');
        $this->session->unset_userdata('call_id');
        $this->session->unset_userdata('inc_ref_id');


        $inc_details = $this->input->get_post('incient');
        
        $perv_inc_ref_id = $this->input->get_post('inc_id');
      
        $non_eme_call = $this->input->get_post('non_eme_call');



        $inc_id = $this->session->userdata('inc_ref_id');
//        if ($inc_id == '') {
//            $inc_id = generate_inc_ref_id();
//            update_inc_ref_id($inc_id);
//            $this->session->set_userdata('inc_ref_id', $inc_id);
//        }
        if ($inc_id == '' && $this->clg->clg_group != 'UG-BIKE-ERO') {
            $inc_id = generate_inc_ref_id();
            $this->session->set_userdata('inc_ref_id', $inc_id);
            update_inc_ref_id($inc_id);
            
        }else if($this->clg->clg_group == 'UG-BIKE-ERO'){
                 $inc_id = "BK-".generate_bk_inc_ref_id();
                 $this->session->set_userdata('inc_ref_id', $inc_id);
                update_inc_ref_id($inc_id);
        }


        $data['inc_ref_id'] = $inc_id;

        $data = array(
            'ncl_base_month' => $this->post['base_month'],
            'ncl_cl_id' => $this->input->post('call_id'),
            'ncl_clr_id' => $this->input->post('caller_id'),
            'ncl_date' => date('Y-m-d H:i:s'),
            'ncl_inc_ref_id' => $inc_id,
            'ncl_added_by' => $this->clg->clg_ref_id,
            'nclis_deleted' => '0',
            'ncl_call_type' => $non_eme_call['cl_type'],
            'ncl_district' =>  $this->input->post('incient_district'),
            'ncl_cl_purpose' => $this->input->get_post('cl_purpose'),
            'ncl_cl_appriciation' => $inc_details['appriciation'],
        );

        $this->session->set_userdata('ambuse_call_details', $data);


        $ambuse_call = array(
            'inc_ref_id' => $inc_id,
            'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
            'inc_ero_summary' => $inc_details['inc_ero_summary'],
            'inc_base_month' => $this->post['base_month'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_datetime' => date('Y-m-d H:i:s'),
            'inc_dispatch_time' => $inc_details['caller_dis_timer'],
            'inc_recive_time' => $inc_details['inc_recive_time'],
            'inc_type' => $inc_details['inc_type'],
            'inc_cl_id' => $this->input->post('call_id'),
            'pre_inc_ref_id'=> $perv_inc_ref_id,
            'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
            
        );


        $this->session->set_userdata('amb_call_inc_details', $ambuse_call);
        $data1['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inc_details['inc_ero_standard_summary']));

        $data['re_name'] = $data1['standard_remark'][0]->re_name;
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];
        $data['appriciation'] = $inc_details['appriciation'];
        
        $this->output->add_to_popup($this->load->view('frontend/non_eme_calls/confirm_app_call_view', $data, TRUE), '600', '250');
    }
//    function amb_not_assi_save() {
//     $this->session->unset_userdata('amb_not_assi_details');
//     $this->session->unset_userdata('call_id');
//     $this->session->unset_userdata('inc_ref_id');
//     // print_r($_POST['langOpt']);die;

//     $inc_details = $this->input->get_post('incient');
    
//     // $perv_inc_ref_id = $this->input->get_post('inc_id');
  
//     $non_eme_call = $this->input->get_post('non_eme_call');



//     $inc_id = $this->session->userdata('inc_ref_id');
//        if ($inc_id == '') {
//            $inc_id = generate_inc_ref_id();
//            update_inc_ref_id($inc_id);
//            $this->session->set_userdata('inc_ref_id', $inc_id);
//        }
//     if ($inc_id == '' && $this->clg->clg_group != 'UG-BIKE-ERO') {
//         $inc_id = generate_inc_ref_id();
//         $this->session->set_userdata('inc_ref_id', $inc_id);
//         update_inc_ref_id($inc_id);
        
//     }else if($this->clg->clg_group == 'UG-BIKE-ERO'){
//              $inc_id = "BK-".generate_bk_inc_ref_id();
//              $this->session->set_userdata('inc_ref_id', $inc_id);
//             update_inc_ref_id($inc_id);
//     }
        

//         $data['inc_ref_id'] = $inc_id;

//         $data = array(
//             'ncl_base_month' => $this->post['base_month'],
//             'ncl_cl_id' => $this->input->post('call_id'),
//             'ncl_clr_id' => $this->input->post('caller_id'),
//             'ncl_date' => date('Y-m-d H:i:s'),
//             'ncl_inc_ref_id' => $inc_id,
//             'ncl_added_by' => $this->clg->clg_ref_id,
//             'nclis_deleted' => '0',
//             'ncl_call_type' => $non_eme_call['cl_type'],
//             'ncl_district' =>  $this->input->post('inc_district_id'),
//             'ncl_cl_purpose' => $this->input->get_post('cl_purpose'),
//             'ncl_cl_appriciation' => $inc_details['appriciation'],
//         );
        
//         $this->session->set_userdata('amb_not_assi_details', $data);
        
//         $ambulances = $_POST['langOpt'];
//         // print_r($ambulances[0]);die;
//         $cbx1="";  
//         foreach($ambulances as $cbx1)  
//         {  
//             $cb1 .= $cbx1.",";  
//         } 
//         $amb_call = array(
//             'inc_ref_id' => $inc_id,
//             'inc_district_id'=> $this->input->post('inc_district_id'),
//             'inc_amb_not_assgn_reason' => $this->input->post('inc_amb_not_assgn_reason'),
//             'inc_amb_not_assgn_ambulances' => $cb1,
//             'inc_added_by' => $this->clg->clg_ref_id,
//             'inc_datetime' => date('Y-m-d H:i:s'),
//             'inc_dispatch_time' => $inc_details['caller_dis_timer'],
//             'inc_recive_time' => $inc_details['inc_recive_time'],
//             'inc_type' => $non_eme_call['cl_type'],
//             'inc_cl_id' => $this->input->post('call_id'), 
//             'inc_place'=> $this->input->post('inc_place'),
//             'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
//         );
//         // print_r($amb_call);die;
//         // $amb_call = array(
//         //     'inc_ref_id' => $inc_id,
//         //     'inc_district_id'=> $this->input->post('inc_district_id'),
//         //     'inc_amb_not_assgn_reason' => $this->input->post('inc_amb_not_assgn_reason'),
//         //     'inc_amb_not_assgn_ambulances' => $cb1,
//         //     'inc_added_by' => $this->clg->clg_ref_id,
//         //     'inc_datetime' => date('Y-m-d H:i:s'),
//         //     'inc_dispatch_time' => $inc_details['caller_dis_timer'],
//         //     'inc_recive_time' => $inc_details['inc_recive_time'],
//         //     'inc_type' => $non_eme_call['cl_type'],
//         //     'inc_cl_id' => $this->input->post('call_id'), 
//         //     'inc_place'=> $this->input->post('inc_place'),
//         //     'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
//         // );
//         //   print_r($amb_call);die;
//         $this->session->set_userdata('amb_not_assi_details', $amb_call);
//         $data1['reason'] = $this->call_model->get_district_name(array('inc_district_id' => $amb_call['inc_district_id']));
//         // print_r($ambulances);die;
//         $amb_call['dst_name'] =  $data1['reason'][0]->dst_name;
//         $amb_call['details'] = $this->get_amb_detailed_data($ambulances);
//         // print_r($amb_call);die;    
//         $this->output->add_to_popup($this->load->view('frontend/non_eme_calls/confirm_amb_not_assi', $amb_call, TRUE), '600', '500');
    
//     }
    // function get_amb_detailed_data($amb){
    //     // $ids = $_POST['ids'];
    //     $data = array();
    //     foreach($amb as $values){
    //         // print_r($values);die;
    //         $pat_details = $this->inc_model->get_dtld_amb_details($values);
    //         // print_r($pat_details);die;
    //         array_push($data,$pat_details);
    //     }
    //     // print_r($data);die;
    //     return($data);
    //     // 
    // }
    function save() {
        $inc_args = $this->session->userdata('amb_call_inc_details');
        $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_args['inc_ref_id']));
        
        if(!empty($is_exits)){
            $this->session->set_userdata('inc_ref_id','');
           // $this->output->message = "<div class='error'>Incident Id alredy exists</div>";
           // $this->output->message = "<script>alert('Incident Id alredy exists !!')</script>";
            $this->output->add_to_position("<script>alert('Incident Id already exists !! Cancel and dispatch again')</script>", 'custom_script', TRUE);
            
        }

        $args = $this->session->userdata('ambuse_call_details');
        
        $call_type = $args['ncl_call_type'];
    //    print_r($call_type);die();
        $pur_args=array('pcode'=>$call_type);
        $child_purpose_of_calls = $this->call_model->get_purpose_of_calls($pur_args);
        $call_name = $child_purpose_of_calls[0]->pname;
       

        $cl_id = $this->non_eme_call_model->insert_non_eme_call($args);

        
       // var_dump($inc_args);
       // die();

        $inc_data = $this->inc_model->insert_inc($inc_args);
    
          $inc_id = $inc_args['inc_ref_id'];
            //update_inc_ref_id($inc_id);

        $this->session->unset_userdata('ambuse_call_details');
        if($call_type == 'SUGG_CALL'){
        $gri_user = $this->inc_model->get_fire_user($sr_user, 'UG-Grievance');
            if(empty($gri_user)){
                $gri_user = $this->inc_model->get_user_by_group('UG-Grievance');
            }

        $args = array(
            'sub_id' => $inc_id,
            'operator_id' => $gri_user->clg_ref_id,
            'operator_type' => 'UG-Grievance',
            'sub_status' => 'ASG',
            'base_month' => $this->post['base_month'],
            'sub_type' => $call_type
            //PRO_REP_SER

        );

        $res = $this->common_model->assign_operator($args);

        $args = array(
            'sub_id' => $cl_id,
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'base_month' => $this->post['base_month'],
            'sub_type' => $call_type
        );

        $res = $this->common_model->assign_operator($args); 
       
    }else{
        $args = array(
            'sub_id' => $cl_id,
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'base_month' => $this->post['base_month'],
            'sub_type' => $call_type
        );

        $res = $this->common_model->assign_operator($args);

    }
        //////////////////////////////////////////////////////            

        if (isset($inc_data)) {

            $this->output->status = 1;

            $this->output->closepopup = "yes";
            
            $url = base_url("calls");
            $this->output->message = "<h3>".$call_name."</h3><br><p>$call_name call details save successfully.</p><script>window.location.href = '".$url."';</script>";

            $this->output->moveto = 'top';

            //$this->output->add_to_position('', 'content', TRUE);
        }
    }
    // function save_amb_not_assign(){
       
    //     $inc_args = $this->session->userdata('amb_not_assi_details');
    //     $amb_data =  $this->session->userdata('amb_not_assi_details_all_data');
    //     $inc_id = $this->session->unset_userdata('inc_ref_id');
    //     // if ($inc_id == '') {
    //     //     $inc_id = generate_inc_ref_id();
    //     //     update_inc_ref_id($inc_id);
    //     //     $this->session->set_userdata('inc_ref_id', $inc_id);
    //     // }
    //     // print_r($inc_args);die;
    //     $data = array(
    //         'inc_ref_id' => $inc_args['inc_ref_id'],
    //         'non_eme_clr_id'  => $inc_args['inc_cl_id'],
    //         'non_eme_district' => $inc_args['inc_district_id'],
    //         'non_eme_remark' => $inc_args['inc_amb_not_assgn_reason'],
    //         'non_eme_place' => $inc_args['inc_place'],
    //         'added_by' => $inc_args['inc_added_by'],
    //         'added_date' => date('Y-m-d H:i:s'),
    //     );
    //     $inc_data = $this->inc_model->insert_inc($inc_args);
    //     $ambul = array();
    //     foreach($amb_data as $amb_d){
    //         $p_data  = array();
    //         foreach($amb_d as $amb){
    //             $p_data = array('non_eme_amb_ambulances'=>$amb['amb_rto_register_no'],
    //             'non_eme_amb_status'=>$amb['ambs_name'],
    //             'non_eme_clg_ref_id_emt' => $amb['clg_ref_id'],
    //             'non_eme_base_loc' => $amb['hp_name']);
                
    //             if($amb['login_type']=='P'){
    //                 $p_data['non_eme_clg_ref_id_emt'] = $amb['clg_ref_id'];

    //             }else{
    //                 $p_data['non_eme_clg_ref_id_pilot'] = $amb['clg_ref_id'];
    //             }
                  
              
    //         }
           
    //         $merged = array_merge($data,$p_data); 
    //         $call_name = $child_purpose_of_calls[0]->pname;
    //         // print_r($merged);die;
    //         $inc_data =  $this->inc_model->insert_non_eme_call($merged);
    //     }
    //     if ($inc_data) {

    //         $this->output->status = 1;

    //         $this->output->closepopup = "yes";

    //         $url = base_url("calls");
    //         $this->output->message = "<h3>".$call_name."</h3><br><p>$call_name call details save successfully.</p><script>window.location.href = '".$url."';</script>";

    //         $this->output->moveto = 'top';

    //         //$this->output->add_to_position('', 'content', TRUE);
    //     }
    // }
    function escalation_save() {
           
        $post_data = $this->input->post();
        $amb_args = $this->session->userdata('amb_call_inc_details');

        $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$amb_args['inc_ref_id']));
        if(!empty($is_exits)){
            $this->session->set_userdata('inc_ref_id','');
            $this->output->message = "<div class='error'>Incident Id alredy exists</div>";
            return;
        }

        $inc_args = $this->session->userdata('ambuse_call_details');
       // var_dump($inc_args);
      //  die();
        
        $call_type = $inc_args['ncl_call_type'];
       
        $pur_args=array('pcode'=>$call_type);
        $child_purpose_of_calls = $this->call_model->get_purpose_of_calls($pur_args);
        $call_name = $child_purpose_of_calls[0]->pname;

        $cl_id = $this->non_eme_call_model->insert_non_eme_call($inc_args);
     
       
     

        $inc_data = $this->inc_model->insert_inc($amb_args);
        $inc_id = $amb_args['inc_ref_id'];
        
        
        //update_inc_ref_id($inc_id);

        $this->session->unset_userdata('ambuse_call_details');


        $args = array(
            'sub_id' => $inc_id,
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'base_month' => $this->post['base_month'],
            'sub_type' => $call_type
        );

        $res = $this->common_model->assign_operator($args);
        
       
            

        if ($post_data['forword'] == 'forword' && $this->clg->clg_senior != 'NA') {

            

            $get_parent = $this->common_model->select_senior($args);

            $args['operator_id'] = $this->clg->clg_senior;

            $args['operator_type'] = $get_parent[0]->clg_group;

            $res = $this->common_model->assign_operator($args);   
        }


        //////////////////////////////////////////////////////            

        if ($inc_data) {

            $this->output->status = 1;

            $this->output->closepopup = "yes";

            $url = base_url("calls");
            $this->output->message = "<h3>".$call_name."</h3><br><p>ESCALATION call details forwarded successfully.</p><script>window.location.href = '".$url."';</script>";
          //  redirect('/calls', 'location');

            $this->output->moveto = 'top';

            //$this->output->add_to_position('', 'content', TRUE);
        }
    }

    function abuse_coun_confirm_save() {

        $this->session->unset_userdata('ambuse_call_details');
        $this->session->unset_userdata('call_id');
        $this->session->unset_userdata('inc_ref_id');


        $inc_details = $this->input->get_post('incient');

        $non_eme_call = $this->input->get_post('non_eme_call');


        $inc_id = $this->session->userdata('inc_ref_id');
//        if ($inc_id == '') {
//            $inc_id = generate_inc_ref_id();
//            update_inc_ref_id($inc_id);
//            $this->session->set_userdata('inc_ref_id', $inc_id);
//        }
           if ($inc_id == '' && $this->clg->clg_group != 'UG-BIKE-ERO') {
            $inc_id = generate_inc_ref_id();
            $this->session->set_userdata('inc_ref_id', $inc_id);
            update_inc_ref_id($inc_id);
            
        }else if($this->clg->clg_group == 'UG-BIKE-ERO'){
                 $inc_id = "BK-".generate_bk_inc_ref_id();
                 $this->session->set_userdata('inc_ref_id', $inc_id);
                update_inc_ref_id($inc_id);
        }


        $data['inc_ref_id'] = $inc_id;

        $data = array(
            'ncl_base_month' => $this->post['base_month'],
            'ncl_cl_id' => $this->input->post('call_id'),
            'ncl_clr_id' => $this->input->post('caller_id'),
            'ncl_date' => date('Y-m-d H:i:s'),
            'ncl_inc_ref_id' => $inc_id,
            'ncl_added_by' => $this->clg->clg_ref_id,
            'nclis_deleted' => '0',
            'ncl_call_type' => $non_eme_call['cl_type'],
        );

        $this->session->set_userdata('ambuse_call_details', $data);

        if($inc_details['CallUniqueID'] == ''){
            $CallUniqueID = $this->session->userdata('CallUniqueID');
            
        }else{
            $CallUniqueID = $inc_details['CallUniqueID'];
        }

        $ambuse_call = array(
            'inc_ref_id' => $inc_id,
            'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
            'inc_avaya_uniqueid' => $CallUniqueID,
            'inc_ero_summary' => $inc_details['inc_ero_summary'],
            'inc_base_month' => $this->post['base_month'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_datetime' => date('Y-m-d H:i:s'),
            'inc_dispatch_time' => $inc_details['caller_dis_timer'],
            'inc_recive_time' => $inc_details['inc_recive_time'],
            'inc_type' => $inc_details['inc_type'],
            'inc_cl_id' => $this->input->post('call_id')
        );


        $this->session->set_userdata('amb_call_inc_details', $ambuse_call);
        $data1['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inc_details['inc_ero_standard_summary']));

        $data['re_name'] = $data1['standard_remark'][0]->re_name;
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];

        $this->output->add_to_popup($this->load->view('frontend/non_eme_calls/confirm_ambuse_call_view', $data, TRUE), '600', '250');
    }
    function service_confirm_save() {

        $this->session->unset_userdata('ambuse_call_details');
        $this->session->unset_userdata('call_id');
        $this->session->unset_userdata('inc_ref_id');


        $inc_details = $this->input->get_post('incient');
        
        $perv_inc_ref_id = $this->input->get_post('inc_id');
      
        $non_eme_call = $this->input->get_post('non_eme_call');



        $inc_id = $this->session->userdata('inc_ref_id');
//        if ($inc_id == '') {
//            $inc_id = generate_inc_ref_id();
//            update_inc_ref_id($inc_id);
//            $this->session->set_userdata('inc_ref_id', $inc_id);
//        }
        if ($inc_id == '' && $this->clg->clg_group != 'UG-BIKE-ERO') {
            $inc_id = generate_inc_ref_id();
            $this->session->set_userdata('inc_ref_id', $inc_id);
            update_inc_ref_id($inc_id);
            
        }else if($this->clg->clg_group == 'UG-BIKE-ERO'){
                 $inc_id = "BK-".generate_bk_inc_ref_id();
                 $this->session->set_userdata('inc_ref_id', $inc_id);
                update_inc_ref_id($inc_id);
        }


        $data['inc_ref_id'] = $inc_id;

        $data = array(
            'ncl_base_month' => $this->post['base_month'],
            'ncl_cl_id' => $this->input->post('call_id'),
            'ncl_clr_id' => $this->input->post('caller_id'),
            'ncl_date' => date('Y-m-d H:i:s'),
            'ncl_inc_ref_id' => $inc_id,
            'ncl_added_by' => $this->clg->clg_ref_id,
            'nclis_deleted' => '0',
            'ncl_call_type' => $non_eme_call['cl_type'],
            'ncl_district' =>  $this->input->post('incient_district'),
            'ncl_cl_purpose' => $this->input->get_post('cl_purpose'),
            //'ncl_cl_appriciation' => $inc_details['appriciation'],
        );

        $this->session->set_userdata('ambuse_call_details', $data);


        $ambuse_call = array(
            'inc_ref_id' => $inc_id,
            'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
            'inc_ero_summary' => $inc_details['inc_ero_summary'],
            'inc_base_month' => $this->post['base_month'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_datetime' => date('Y-m-d H:i:s'),
            'inc_dispatch_time' => $inc_details['caller_dis_timer'],
            'inc_recive_time' => $inc_details['inc_recive_time'],
            'inc_type' => $inc_details['inc_type'],
            'inc_cl_id' => $this->input->post('call_id'),
            'pre_inc_ref_id'=> $perv_inc_ref_id,
            'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
            
        );


        $this->session->set_userdata('amb_call_inc_details', $ambuse_call);
        $data1['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inc_details['inc_ero_standard_summary']));

        $data['re_name'] = $data1['standard_remark'][0]->re_name;
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];
        $data['appriciation'] = $inc_details['appriciation'];


        $this->output->add_to_popup($this->load->view('frontend/non_eme_calls/confirm_service_call_view', $data, TRUE), '600', '250');
    }

    function help_104_save() {

        $this->session->unset_userdata('help_call_details');
        $this->session->unset_userdata('call_id');
        $this->session->unset_userdata('inc_ref_id');

        $inc_details = $this->input->get_post('incient');
// print_r($inc_details);die();
        // $dist = $this->input->get_post('incient_district');
        // var_dump($dist);die();
        
        $help_desk_call = $this->input->get_post('104_call');  
        // print_r($help_desk_call);die();
            $inc_id = generate_inc_ref_id();
            update_inc_ref_id($inc_id);
            $this->session->set_userdata('inc_ref_id', $inc_id);

        $data['inc_ref_id'] = $inc_id;

        $p_call_type = $help_desk_call['cl_type'];
        $pur_args=array('pcode'=>$p_call_type);
        $child_purpose_of_calls = $this->call_model->get_purpose_of_calls($pur_args);
        $p_call_name = $child_purpose_of_calls[0]->p_parent;
        // var_dump($p_call_name);die();

        $data = array(
            'ncl_base_month' => $this->post['base_month'],
            'ncl_cl_id' => $this->input->post('call_id'),
            'ncl_clr_id' => $this->input->post('caller_id'),
            'ncl_date' => date('Y-m-d H:i:s'),
            'ncl_inc_ref_id' => $inc_id,
            'ncl_cl_purpose' => $p_call_name,
            'ncl_added_by' => $this->clg->clg_ref_id,
            'nclis_deleted' => '0',
            'ncl_call_type' => $help_desk_call['cl_type'],
        );

        $this->session->set_userdata('help_call_details', $data);

         if($inc_details['CallUniqueID'] == ''){
            $CallUniqueID = $this->session->userdata('CallUniqueID');
            
        }else{
            $CallUniqueID = $inc_details['CallUniqueID'];
        }
        if($help_desk_call['cl_type']=='HELP_OTHER_OTH'){
            $pt_cnt = 0;
        }
        else{
            $pt_cnt = 1;
        }

        $help_call = array(
            'inc_ref_id' => $inc_id,
            'help_complaint_type' => $inc_details['help_complaint_type'],
            'help_standard_summary' => $inc_details['help_standard_summary'],
            'inc_ero_summary' => $inc_details['inc_ero_summary'],
            'inc_avaya_uniqueid' => $CallUniqueID,
            'inc_base_month' => $this->post['base_month'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_datetime' => date('Y-m-d H:i:s'),
            'inc_dispatch_time' => $inc_details['caller_dis_timer'],
            'inc_recive_time' => $inc_details['inc_recive_time'],
            'inc_type' => $help_desk_call['cl_type'],
            'inc_system_type' => "104",
            'inc_cl_id' => $this->input->post('call_id'),
            'inc_district_id' => $inc_details['dist'],
            'inc_tahshil_id' => $inc_details['tahsil'],
            'inc_area' => $inc_details['area'],
            'inc_state_id' => $inc_details['state'],
            'inc_patient_cnt' => $pt_cnt,
        );


        $this->session->set_userdata('help_call_inc_details', $help_call);
        $data['help_standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inc_details['help_standard_summary']));
       
        $data['complaint_type'] = $this->call_model->get_help_complaints_name(array('cmp_id' => $inc_details['help_complaint_type']));

        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];
        
        if ($help_desk_call['cl_type'] == 'HELP_AYU_CALL') {

            $data['call_name'] ="Ayushman Related Call";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_info_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_BLD_BANK') {
            $data['call_name'] ="Blood Bank Related Call";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_info_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_COR_REG') {
            $data['call_name'] ="Corona Test Regarding Call";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_info_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_HOS_INFO') {
            $data['call_name'] ="Hospital Information Related Call";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_info_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_VACC_CERT') {
            $data['call_name'] ="Vaccinated Certificate Related Call";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_info_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_VACC_CORR') {
            $data['call_name'] ="Vaccination Correction Related Call";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_info_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_VACC_INFO') {
            $data['call_name'] ="Vaccination Related Information Call";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_info_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_INFO_HEA_LIN') {
            $data['call_name'] ="104 Health Help Line Related Information";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_info_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_INFO_AMB_SER') {
            $data['call_name'] ="108 Ambulance Service Related";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_info_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_AMB_TRS') {
            $data['call_name'] ="Ambulance Regarding Call (108 Call Transfer)";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_info_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_INFO_BIRTH') {
            $data['call_name'] ="Birth Certificate Related Information";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_info_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_INFO_ENQ') {
            $data['call_name'] ="Complaint Enquire";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_info_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_INFO_COR') {
            $data['call_name'] ="Corona-19 Related Information";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_info_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_INFO_INT') {
            $data['call_name'] ="Interstate Call";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_info_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_INFO_MED_INFO') {
            $data['call_name'] ="Medical Information";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_info_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_INFO_SCH_REL') {
            $data['call_name'] ="Scheme Related Information";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_info_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_COUN_CER') {
            $data['call_name'] ="Career Related Problem";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_coun_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_COUN_DEP') {
            $data['call_name'] ="Depression Related Problem";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_coun_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_COUN_FAM') {
            $data['call_name'] ="Family Related Problem";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_coun_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_COUN_PER') {
            $data['call_name'] ="Sexual Related Problem";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_coun_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_COUN_SUI') {
            $data['call_name'] ="Suicide Case Related Problem";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_coun_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_COUN_TEN') {
            $data['call_name'] ="Tension Related Problem";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_coun_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_COUN_ADO') {
            $data['call_name'] ="Adolescence Counselling";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_coun_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_COUN_BEH') {
            $data['call_name'] ="Behavioral Counselling";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_coun_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_COUN_OTH') {
            $data['call_name'] ="Other Problem";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_coun_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_COUN_PSY') {
            $data['call_name'] ="Psychiatric Problem";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_coun_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_COUN_LOG') {
            $data['call_name'] ="Psychological Problem";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_coun_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_COUN_REL') {
            $data['call_name'] ="Relationship Counselling";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_coun_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_COUN_SOC') {
            $data['call_name'] ="Social Adjustment Related";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_coun_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_COUN_SUB') {
            $data['call_name'] ="Substance Abuse";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_coun_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_COMP_INTR') {
            $data['call_name'] ="108 Service Related Internal Complaint Call";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_coun_confirm_view', $data, TRUE), '600', '250');
        }
        // else if ($help_desk_call['cl_type'] == 'HELP_COMP_HOS') {
        //     $data['call_name'] ="Hospital Service Related Complaint Call";
        //     $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_ayu_confirm_view', $data, TRUE), '600', '250');
        // }
        else if ($help_desk_call['cl_type'] == 'HELP_COMP_JSSY') {
            $data['call_name'] ="JSSY Scheme Related Complaint Call";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_ayu_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_COMP_PMVVY') {
            $data['call_name'] ="PMVVY Scheme Related Complaint Call";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_ayu_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_COMP_VACC') {
            $data['call_name'] ="Vaccination Related Complaint Call";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_ayu_confirm_view', $data, TRUE), '600', '250');
        }else if ($help_desk_call['cl_type'] == 'HELP_EME_CALL_MED') {
            $data['call_name'] ="Medical Call";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_other_confirm_view', $data, TRUE), '600', '250');
        }else if ($help_desk_call['cl_type'] == 'COMPLAT_HELP_CALL') {
            $data['call_name'] ="Complaint Call";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_comp_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_COMP_HOS') {
            $data['call_name'] ="Hospital Management Related Complaint Call";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_complaint_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_COMP_AMB') {
            $data['call_name'] ="108 Ambulance Service Related Complaint Call";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_complaint_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_COMP_OTHR') {
            $data['call_name'] ="Other Complaint Call";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_complaint_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_COMP_FOOD') {
            $data['call_name'] ="Food Related Complaint Call";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_complaint_confirm_view', $data, TRUE), '600', '250');
        }
        else if ($help_desk_call['cl_type'] == 'HELP_OTHER_OTH') {
            $data['call_name'] ="Other Call";
            $this->output->add_to_popup($this->load->view('frontend/help_desk_104/help_other_confirm_view', $data, TRUE), '600', '250');
        }
        
    }
    

    function save_104() {
        $inc_args = $this->session->userdata('help_call_inc_details');
        $patient = $this->session->userdata('patient_info');
        // print_r($patient);die();
        $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_args['inc_ref_id']));
        
        if(!empty($is_exits)){
            $this->session->set_userdata('inc_ref_id','');
            $this->output->add_to_position("<script>alert('Incident Id already exists !! Cancel and dispatch again')</script>", 'custom_script', TRUE);
            
        }

        $args = $this->session->userdata('help_call_details');
        $call_type = $args['ncl_call_type'];
        $pur_args=array('pcode'=>$call_type);
        $child_purpose_of_calls = $this->call_model->get_purpose_of_calls($pur_args);
        $call_name = $child_purpose_of_calls[0]->pname;
       
        $cl_id = $this->non_eme_call_model->insert_non_eme_call($args);

        $inc_data = $this->inc_model->insert_inc($inc_args);
        $inc_id = $inc_args['inc_ref_id'];
        $this->session->unset_userdata('help_call_details');
        if (!empty($patient)) {
            // print_r($patient);die();
            if (ucfirst($patient['first_name']) != '') {

                $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
                // var_dump($last_pat_id);die();
                $last_pat_id = (int)($last_insert_pat_id[0]->p_id) + 1;
                
                //$last_pat_id = $this->clg->clg_id.'_'.$last_pat_id;
                 $last_pat_id = generate_ptn_id();
               
                $incidence_patient_details = array('ptn_fname' => ucfirst($patient['first_name']),
                    'ptn_mname' => ucfirst($patient['middle_name']),
                    'ptn_lname' => ucfirst($patient['last_name']),
                    'ptn_gender' => $patient['gender'],
                    'ptn_fullname' => ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']),
                    'ptn_age' => $patient['age'],
                    'ptn_age_type' => $patient['age_type'],
                    'ptn_birth_date' => $patient['dob'],
                    'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                    'ptn_id' => $last_pat_id,
                    'ptn_added_by' => $this->clg->clg_ref_id,
                    'ptn_added_date' => date('Y-m-d H:i:s'),
                );
                $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                //$patient_full_name = $patient['full_name'];
                //var_dump($incidence_patient_details); die();
                $patient_full_name_sms=$patient_full_name;
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
            }
        } 
        if($call_type == 'SUGG_CALL'){
        $args = array(
            'sub_id' => $inc_id,
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'base_month' => $this->post['base_month'],
            'sub_type' => $call_type
        );

        $res = $this->common_model->assign_operator($args); 
       
    }else{
        $args = array(
            'sub_id' => $inc_id,
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'base_month' => $this->post['base_month'],
            'sub_type' => $call_type
        );

        $res = $this->common_model->assign_operator($args);

    }
    $counslor_operator = array(
        'sub_id' => $inc_id,
        'operator_id' => $this->clg->clg_ref_id,
        'operator_type' => 'UG-COUNSELOR-104',
        'sub_status' => 'ASG',
        'sub_type' => 'COUNSLOR',
        'base_month' => $this->post['base_month']
    );
    if (isset($counslor_operator)) {
            $counselor_operator = $this->common_model->assign_operator($counslor_operator);
        
        }
        //////////////////////////////////////////////////////            

        if ($inc_data) {

            $this->output->status = 1;

            $this->output->closepopup = "yes";

            $url = base_url("calls");
            $this->output->message = "<h3>".$call_name."</h3><br><p>$call_name call details save successfully.</p><script>window.location.href = '".$url."';</script>";

            $this->output->moveto = 'top';

            //$this->output->add_to_position('', 'content', TRUE);
        }
    }
    
    function save_complaint_call_104() {
        $inc_args = $this->session->userdata('help_call_inc_details');
        $patient = $this->session->userdata('patient_info');
        // print_r($patient);die();
        $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_args['inc_ref_id']));
        
        if(!empty($is_exits)){
            $this->session->set_userdata('inc_ref_id','');
            $this->output->add_to_position("<script>alert('Incident Id already exists !! Cancel and dispatch again')</script>", 'custom_script', TRUE);
            
        }

        $args = $this->session->userdata('help_call_details');
        $call_type = $args['ncl_call_type'];
        $pur_args=array('pcode'=>$call_type);
        $child_purpose_of_calls = $this->call_model->get_purpose_of_calls($pur_args);
        $call_name = $child_purpose_of_calls[0]->pname;
       
        $cl_id = $this->non_eme_call_model->insert_non_eme_call($args);

        $inc_data = $this->inc_model->insert_inc($inc_args);
        $inc_id = $inc_args['inc_ref_id'];
        $this->session->unset_userdata('help_call_details');
        if (!empty($patient)) {
            // print_r($patient);die();
            if (ucfirst($patient['first_name']) != '') {

                $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
                // var_dump($last_pat_id);die();
                $last_pat_id = (int)($last_insert_pat_id[0]->p_id) + 1;
                
                //$last_pat_id = $this->clg->clg_id.'_'.$last_pat_id;
                 $last_pat_id = generate_ptn_id();
               
                $incidence_patient_details = array('ptn_fname' => ucfirst($patient['first_name']),
                    'ptn_mname' => ucfirst($patient['middle_name']),
                    'ptn_lname' => ucfirst($patient['last_name']),
                    'ptn_gender' => $patient['gender'],
                    'ptn_fullname' => ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']),
                    'ptn_age' => $patient['age'],
                    'ptn_age_type' => $patient['age_type'],
                    'ptn_birth_date' => $patient['dob'],
                    'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                    'ptn_id' => $last_pat_id,
                    'ptn_added_by' => $this->clg->clg_ref_id,
                    'ptn_added_date' => date('Y-m-d H:i:s'),
                );
                $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                //$patient_full_name = $patient['full_name'];
                //var_dump($incidence_patient_details); die();
                $patient_full_name_sms=$patient_full_name;
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
            }
        } 
        $args = array(
            'sub_id' => $inc_id,
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'base_month' => $this->post['base_month'],
            'sub_type' => $call_type
        );

        $res = $this->common_model->assign_operator($args);

        $counselor_operator = $this->inc_model->get_fire_user($sr_user, 'UG-EROSupervisor-104');
        if(empty($counselor_operator)){
            $counselor_operator = $this->inc_model->get_user_by_group('UG-EROSupervisor-104');
        }
        if ($counselor_operator) {
  
                $supervisor_operator = array(
                    'sub_id' => $inc_id,
                    'operator_id' => $counselor_operator->clg_ref_id,
                    'operator_type' => 'UG-EROSupervisor-104',
                    'sub_status' => 'ASG',
                    'sub_type' => $call_type,
                    'base_month' => $this->post['base_month']
                );

                $counselor_operator = $this->common_model->assign_operator($supervisor_operator);
        
        
        }
        //////////////////////////////////////////////////////            

        if ($inc_data) {

            $this->output->status = 1;

            $this->output->closepopup = "yes";

            $url = base_url("calls");
            $this->output->message = "<h3>".$call_name."</h3><br><p>$call_name call details save successfully.</p><script>window.location.href = '".$url."';</script>";

            $this->output->moveto = 'top';

            //$this->output->add_to_position('', 'content', TRUE);
        }
    }
    // function get_detailed_data(){
    //     $ids = $_POST['ids'];
    
    //     $data = array();
    //     foreach($ids as $values){
    //         // print_r($values);die;
    //         $pat_details = $this->inc_model->get_dtld_amb_details($values);
    //         // print_r($pat_details);die;
    //         array_push($data,$pat_details);
    //     }
    //     $this->session->set_userdata('amb_not_assi_details_all_data', $data);
        
    //     echo json_encode($data);
    //     die;
    //     // 
    // }
    function get_detailed_data(){
        $ids = $_POST['ids'];
    
        $data = array();
        foreach($ids as $values){
            // print_r($values);die;
            $pat_details = $this->inc_model->get_dtld_amb_details($values);
            // print_r($pat_details);
            $array_len = count($pat_details);
            // print_r($pat_details[0]['login_type']);die;
            $final = array();
            if($array_len > 1){
                $arr['login_type1'] = $pat_details[0]['login_type'];
                // print_r($arr['first']);die;
                // $arr['first'] = ;
                $arr['login_type2'] = $pat_details[1]['login_type'];
                $arr['amb_rto_register_no'] = $pat_details[1]['amb_rto_register_no'];
                $arr['amb_status'] = $pat_details[1]['amb_status'];
                $arr['ambs_id'] = $pat_details[1]['ambs_id'];
                $arr['ambs_name'] = $pat_details[1]['ambs_name'];
                $arr['hp_id'] = $pat_details[1]['hp_id'];
                $arr['hp_name'] = $pat_details[1]['hp_name'];
                $arr['clg_id'] = $pat_details[1]['clg_id'];
                $arr['status'] = $pat_details[1]['status'];
                $arr['clg_ref_id'] = $pat_details[1]['clg_ref_id'];
                $arr['clg_first_name'] = $pat_details[1]['clg_first_name'];
                array_push($final,$arr);
                // $merged = array_merge($arr1,$arr2);
                // print_r($final);die;
            }else{
                $arr['login_type1'] = $pat_details[0]['login_type'];
                // print_r($arr['first']);die;
                // $arr['first'] = ;
                // $arr['login_type2'] = $pat_details[0]['login_type'];
                $arr['amb_rto_register_no'] = $pat_details[0]['amb_rto_register_no'];
                $arr['amb_status'] = $pat_details[0]['amb_status'];
                $arr['ambs_id'] = $pat_details[0]['ambs_id'];
                $arr['ambs_name'] = $pat_details[0]['ambs_name'];
                $arr['hp_id'] = $pat_details[0]['hp_id'];
                $arr['hp_name'] = $pat_details[0]['hp_name'];
                $arr['clg_id'] = $pat_details[0]['clg_id'];
                $arr['status'] = $pat_details[0]['status'];
                $arr['clg_ref_id'] = $pat_details[0]['clg_ref_id'];
                $arr['clg_first_name'] = $pat_details[0]['clg_first_name'];
                array_push($final,$arr);
                // print_r($final);die;
            }
            // print_r($variable);die;/
            // if($pat_details)
            // array_push($data,$pat_details);
        }
        $this->session->set_userdata('amb_not_assi_details_all_data', $final);
        print_r(json_encode($final));die;
        // echo json_encode($final);
        die;
        // 
    }
}