<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Medadv extends EMS_Controller {

    var $dtmf, $dtmt; // default time from/to

    function __construct() {

        parent::__construct();

        $this->load->library(array('session', 'modules'));

        $this->load->model(array('module_model', 'Pet_model', 'Medadv_model', 'Ercp_model', 'pcr_model', 'inc_model', 'call_model', 'pet_model', 'inc_model','pet_model'));

        $this->load->helper(array('comman_helper','api_helper'));

        $this->post = $this->input->get_post(NULL);

        $this->post['base_month'] = get_base_month();

        $this->clg = $this->session->userdata('current_user');

        $this->today = date('Y-m-d H:i:s');

        $this->dtmf = "00:00:00";

        $this->dtmt = "24:00:00";
        $this->ameyo_server_url = $this->config->item('ameyo_server_url');
    }

    public function index($generated = false) {


        echo "You are in the Medical advice controllers";
    }

    //// Created by MI42 ///////////////////////////
    // 
    // Purpose : To get patient inforamation.
    // 
    ////////////////////////////////////////////////

    function petinfo() {


        $args = array(
            'inc_ref_id' => trim($this->post['inc_id']),
            'base_month' => $this->post['base_month']
        );

        $data['pt_info'] = $this->Pet_model->get_ptinc_info($args);

        $data['amb_data'] = $this->inc_model->get_inc_details_mul_amb($args);
        
      

        $data['increfid'] = $this->post['inc_id'];

        $this->output->add_to_position($this->load->view('frontend/medadv/med_adv_info', $data, TRUE), 'adv_pt_info', TRUE);
    }
    
    function petinfo_new() {


        
        $args = array(
            'inc_ref_id' => trim($this->post['inc_id']),
            'base_month' => $this->post['base_month']
        );
        
                //var_dump($this->post['filter']);
        if($this->post['filter'] == 'true'){
            //$this->output->add_to_position($this->load->view('frontend/inc/inc_details_view', $data, TRUE), 'inc_details', TRUE);
            $this->output->add_to_position('', 'inc_details', TRUE);
            $this->output->add_to_position('', 'fwdcmp_btn', TRUE);
            $this->output->add_to_position($this->load->view('frontend/fupcall/fup_inc_filter_view', $data, TRUE), 'inc_filters', TRUE);
            return false;
        }
      
        ////////////////////////// Set inc datetime //////////////////////////

        if (!empty($this->post['inc_time'])) {

            $inctm = get_formated_time($this->post['inc_time']);

            $this->post['inc_timef'] = $inctm[0];

            $this->post['inc_timet'] = $inctm[1];
        }else{
            $this->post['inc_timef'] = '00:00:00';

            $this->post['inc_timet'] = '23:59:59';
        }



        if (!empty($this->post['inc_date']) && empty($this->post['inc_id'])) {

            $this->post['inc_date'] = date('Y-m-d', strtotime($this->post['inc_date']));

            ////////////////////////////////////////////////////////////////////////////

            $this->post['inc_datef'] = $this->post['inc_date'] . " " . $this->post['inc_timef'];

            $this->post['inc_datet'] = $this->post['inc_date'] . " " . $this->post['inc_timet'];

            ////////////////////////////////////////////////////////////////////////////
        }
        if (!empty($this->post['inc_district']) && empty($this->post['inc_date'])) {

            $this->post['inc_date_time'] = date('Y-m-d');
        }


        $data['pt_info'] = $this->Pet_model->get_ptinc_info($args);

        $data['amb_data'] = $this->inc_model->get_inc_details_mul_amb($args);
        
      

        $data['increfid'] = $this->post['inc_id'];

        $this->output->add_to_position($this->load->view('frontend/medadv/med_adv_info', $data, TRUE), 'adv_pt_info', TRUE);
    }

    //// Created by MI42 /////////////////////////////////////////////
    // 
    // Purpose : To confirm advice details inforamation(ERO).
    // 
    //////////////////////////////////////////////////////////////////

    function confirm_save() {


        $this->session->unset_userdata('medadv_details');

        $this->session->unset_userdata('call_id');

        $inc_details = $this->input->get_post('incient');
        
        $inc_id = $this->session->userdata('inc_ref_id');
        if ($inc_id == '') {
            $inc_id = generate_inc_ref_id();
            $this->session->set_userdata('inc_ref_id', $inc_id);
             update_inc_ref_id($inc_id);
        }

        $data['adv_new_inc_ref_id'] = $inc_id;

        $data = array(
            'adv_cl_id' => $this->post['call_id'],
            'adv_inc_ref_id' => $this->post['increfid'],
            'adv_base_month' => $this->post['base_month'],
            'adv_emt' => $this->clg->clg_ref_id,
            'adv_advice' => '',
            'adv_date' => $this->today,
            'adv_new_inc_ref_id' => $inc_id
        );


        $this->session->set_userdata('medadv_details', $data);

        $med_inc = array(
            'inc_ref_id' => $inc_id,
            'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
            'inc_ero_summary' => $inc_details['inc_ero_summary'],
            'inc_base_month' => $this->post['base_month'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_datetime' => date('Y-m-d H:i:s'),
            'inc_dispatch_time' => $inc_details['caller_dis_timer'],
            'inc_recive_time' => $inc_details['inc_recive_time'],
            'inc_type' => $inc_details['inc_type'],
            'inc_cl_id' => $this->post['call_id'],
            'pre_inc_ref_id' => $this->post['increfid'],
            'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
        );


        $this->session->set_userdata('med_incidence_details', $med_inc);
        $data1['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inc_details['inc_ero_standard_summary']));

        $data['re_name'] = $data1['standard_remark'][0]->re_name;
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];



        /////////////////////////////////////////////////////////////////////


        $args = array(
            'inc_ref_id' => $this->post['increfid'],
            'base_month' => $this->post['base_month']
        );


        $data['pt_info'] = $this->Pet_model->get_ptinc_info($args);

        $this->output->add_to_popup($this->load->view('frontend/medadv/confirm_medadv_view', $data, TRUE), '600', '495');

        $this->output->add_to_position($this->load->view('frontend/patient/pt_inc_summary_view', $data, TRUE), 'summary_div', TRUE);
    }

    //// Created by MI42 ///////////////////////////
    // 
    // Purpose : To save advice details inforamation.
    // 
    ////////////////////////////////////////////////

    ///////////////////////////
    //NON MCI CALL FORWARD TO ERCP
    function confirm_save_104() {


        $this->session->unset_userdata('medadv_details');

        $this->session->unset_userdata('call_id');

        $inc_details = $this->input->get_post('incient');
        $help_desk_call = $this->input->get_post('104_call'); 
        
        $inc_id = $this->session->userdata('inc_ref_id');
        if ($inc_id == '') {
            $inc_id = generate_inc_ref_id();
            $this->session->set_userdata('inc_ref_id', $inc_id);
             update_inc_ref_id($inc_id);
        }
        $p_call_type = $help_desk_call['cl_type'];
        $pur_args=array('pcode'=>$p_call_type);
        $child_purpose_of_calls = $this->call_model->get_purpose_of_calls($pur_args);
        $p_call_name = $child_purpose_of_calls[0]->p_parent;
        $data['adv_new_inc_ref_id'] = $inc_id;

        $data = array(
            'adv_cl_id' => $this->post['call_id'],
            'adv_inc_ref_id' => $this->post['increfid'],
            'adv_base_month' => $this->post['base_month'],
            'adv_emt' => $this->clg->clg_ref_id,
            'adv_advice' => '',
            'adv_date' => $this->today,
            'adv_new_inc_ref_id' => $inc_id
        );


        $this->session->set_userdata('medadv_details', $data);

        $med_inc = array(
            'inc_ref_id' => $inc_id,
            'help_standard_summary' => $inc_details['help_standard_summary'],
            'inc_ero_summary' => $inc_details['inc_ero_summary'],
            'help_desk_chief_complaint' => $inc_details['help_desk_chief_complaint'],
            'inc_base_month' => $this->post['base_month'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_datetime' => date('Y-m-d H:i:s'),
            'inc_dispatch_time' => $inc_details['caller_dis_timer'],
            'inc_recive_time' => $inc_details['inc_recive_time'],
            'inc_type' => $help_desk_call['cl_type'],
            'inc_cl_id' => $this->post['call_id'],
            'pre_inc_ref_id' => $this->post['increfid'],
            'inc_system_type' => "104",
            'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
            'inc_district_id' => $inc_details['dist'],
            'inc_tahshil_id' => $inc_details['tahsil'],
            'inc_area' => $inc_details['area'],
            'inc_state_id' => $inc_details['state'],
            'inc_patient_cnt' => 1,
        );


        $this->session->set_userdata('med_incidence_details', $med_inc);
        // $data1['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inc_details['inc_ero_standard_summary']));
        $data['help_standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inc_details['help_standard_summary']));

        $data['nature'] = $this->inc_model->get_chief_comp_service_help($inc_details['help_desk_chief_complaint']);
        // var_dump($data['nature']);die();
        // $data['re_name'] = $data1['standard_remark'][0]->re_name;
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];


        $args = array(
            'inc_ref_id' => $this->post['increfid'],
            'base_month' => $this->post['base_month']
        );


        $this->output->add_to_popup($this->load->view('frontend/help_desk_104/forward_to_ercp_view', $data, TRUE), '600', '300');
    }



    ////////////////////////////
    function save() {

        if ($this->post['fwd_medadv_call']) {


            $med_args = $this->session->userdata('med_incidence_details');



            $med_data = $this->inc_model->insert_inc($med_args);

            $inc_id = $med_args['inc_ref_id'];
           

            $args = $this->session->userdata('medadv_details');
            $sr_user = $this->clg->clg_ref_id;
            $ercp_user = $this->inc_model->get_fire_user($sr_user, 'UG-ERCP');
          
            if($ercp_user){
                $args['adv_emt'] = $ercp_user->clg_ref_id;
                $adv_id = $this->Medadv_model->add($args);
                       
            }
      
            

            $this->session->unset_userdata('medadv_details');


            //            $this->session->unset_userdata('med_incidence_details');
            //////////////////////////////////////////////////////////////


            $args = array(
                'sub_id' => $adv_id,
                'operator_id' => $this->clg->clg_ref_id,
                'operator_type' => $this->clg->clg_group,
                'sub_type' => 'ADV',
                'base_month' => $this->post['base_month'],
                'sub_status' => 'ASG'
            );



            $res = $this->common_model->assign_operator($args);
           
            //$ercp_user = $this->inc_model->get_fire_user($sr_user, 'UG-ERCP');
           
            

                    $ercp_operator = array(
                        'sub_id' => $inc_id,
                        'operator_id' => $ercp_user->clg_ref_id,
                        'operator_type' => 'UG-ERCP',
                        'sub_status' => 'ASG',
                        'sub_type' => 'ADV',
                        'base_month' => $this->post['base_month']
                    );


                    if (isset($ercp_user)) {
                        $police_operator = $this->common_model->assign_operator($ercp_operator);
                       
                    }


         
            if ($res) {

                $this->output->status = 1;

                $this->output->closepopup = "yes";

                $this->output->message = "<h3>Medical Advice Call</h3><br><p>Medical Advice Forwarded Successfully.</p><script>window.location.reload(true);</script>";

                $this->output->moveto = 'top';

                $this->output->add_to_position('', 'content', TRUE);
            }
        }
    }

    ///////////////////////////save ercp_104

    function save_ercp_104() {

        if ($this->post['fwd_medadv_call_104']) {


            $med_args = $this->session->userdata('med_incidence_details');
            $patient = $this->session->userdata('patient_info');

            // var_dump($patient);die();

            $med_data = $this->inc_model->insert_inc($med_args);

            $inc_id = $med_args['inc_ref_id'];
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
           

            $args = $this->session->userdata('medadv_details');
            $sr_user = $this->clg->clg_ref_id;
            $ercp_user = $this->inc_model->get_fire_user($sr_user, 'UG-ERCP-104');
          
            // var_dump($ercp_user);die();
            if($ercp_user){
                $args['adv_emt'] = $ercp_user->clg_ref_id;

               
                $adv_id = $this->Medadv_model->add($args);
                //  var_dump($args['adv_emt']);die();
                       
            }
      
            

            $this->session->unset_userdata('medadv_details');


            //            $this->session->unset_userdata('med_incidence_details');
            //////////////////////////////////////////////////////////////


            $args = array(
                'sub_id' => $adv_id,
                'operator_id' => $this->clg->clg_ref_id,
                'operator_type' => $this->clg->clg_group,
                'sub_type' => 'ADV',
                'base_month' => $this->post['base_month'],
                'sub_status' => 'ASG'
            );



            $res = $this->common_model->assign_operator($args);
           
            //$ercp_user = $this->inc_model->get_fire_user($sr_user, 'UG-ERCP');
           
            

                    $ercp_operator = array(
                        'sub_id' => $inc_id,
                        'operator_id' => $ercp_user->clg_ref_id,
                        'operator_type' => 'UG-ERCP-104',
                        'sub_status' => 'ASG',
                        'sub_type' => 'ADV',
                        'base_month' => $this->post['base_month']
                    );


                    if (isset($ercp_user)) {
                        $police_operator = $this->common_model->assign_operator($ercp_operator);
                       
                    }


         
            if ($med_data) {
               

                $this->output->status = 1;

                $this->output->closepopup = "yes";
                 $url = base_url("calls");

                $this->output->message = "<h3>Medical Advice Call</h3><br><p>Medical Advice Forwarded Successfully.</p><script>window.location.href = '".$url."';</script>";

                $this->output->moveto = 'top';

                $this->output->add_to_position('', 'content', TRUE);
            }
        }
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To load info of ero call details
    // 
    /////////////////////////////////////////

    function call_details() {


        
        $data['opt_id'] = $this->post['opt_id'];

        $data['sub_id'] = $this->post['sub_id'];
        if (isset($this->post['inc_ref_id']) && strlen($this->post['inc_ref_id']) < 12) {
            $this->output->message = "<p>No Record Found</p>";

            return;
        }
        if (!isset($this->post['inc_ref_id'])) {
           // echo "jo";
            //var_dump($this->post['sub_id']);
           // die();

            $data['opt_id'] = $this->post['opt_id'];
            
            $data['sub_id'] = $this->post['sub_id'];
            

            ////////////////////////////////////////////////////////////


            $args = array(
                'opt_id' => $data['opt_id'],
                'sub_id' => $data['sub_id'],
                //'inc_ref_id' => $data['adv_inc_ref_id'],
                'clr_mobile' => $data['mobile_no'],
                'base_month' => $this->post['base_month']
            );

            $data['cl_dtl'] = $this->Medadv_model->call_detials($args);
            
            

            $this->session->set_userdata('ercp_inc_ref_id', $data['cl_dtl'][0]->adv_inc_ref_id);

            $inc_args = array(
                'inc_ref_id' => $data['cl_dtl'][0]->adv_inc_ref_id,
                'base_month' => $this->post['base_month']
            );

            $data['pt_info'] = $this->Pet_model->get_ptinc_info($inc_args);

            $data['patient_id'] = $data['pt_info'][0]->ptn_id;

            $args_pur = array('pcode' => $data['pt_info'][0]->inc_type);
            $call_pur = $this->inc_model->get_purpose_call($args_pur);
            $data['pname'] = $call_pur[0]->pname;

            $data['patient_info'] = $this->pcr_model->get_pat_by_inc($inc_args);
            $data['amb_data'] = $this->inc_model->get_inc_details($inc_args);
        } else {
           // echo "jqwo";
            $data['sub_id'] = $this->post['sub_id'];

            $args_ercp = array(
                'inc_ref_id' => trim($this->post['inc_ref_id']),
                'clr_mobile' => trim($this->post['mobile_no']),
                
                // 'base_month' => $this->post['base_month']
            );


            $this->session->set_userdata('ercp_inc_ref_id', $this->post['inc_ref_id']);
            //var_dump($args_ercp);

            $data['cl_dtl'] = $this->Medadv_model->get_ercp_call_detials($args_ercp);
            
            
           $args = array(
                'inc_ref_id' => $data['cl_dtl'][0]->adv_inc_ref_id,
  
            );


            if(!empty($data['cl_dtl'])){
                $data['pt_info'] = $this->Pet_model->get_ptinc_info($args);

                $data['amb_data'] = $this->inc_model->get_inc_details($args);

                $data['questions'] = $this->inc_model->get_inc_summary($args);

                $data['patient_info'] = $this->pcr_model->get_pat_by_inc($args);
            }

            $data['patient_id'] = $data['pt_info'][0]->ptn_id;
            $args_pur = array('pcode' => $data['pt_info'][0]->cl_purpose);
            //  $args_pur = array('pcode' =>trim($data['pt_info'][0]->inc_type));
            $call_pur = $this->inc_model->get_purpose_call($args_pur);
            $data['pname'] = $call_pur[0]->pname;


            $args_remark = array('re_id' => $data['pt_info'][0]->inc_ero_standard_summary);
            $standard_remark = $this->call_model->get_ero_summary_remark($args_remark);
            $data['re_name'] = $standard_remark[0]->re_name;


            $data['help_standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $data['pt_info'][0]->help_standard_summary));


        }

        if (empty($data['cl_dtl'])) {
            $this->output->message = "<p>No Record Found</p>";

            return;
        }

//        ////////////////////////////////////////////////////////////
//
//            $args = array('opt_id' => $data['opt_id'],
//                'sub_id' => $data['sub_id'],
//                'sub_type' => 'ADV');
//            
//            update_opt_status($args);
//
//
//
//            $args = array(
//                'sub_id' => $data['sub_id'],
//                'operator_id' => $this->clg->clg_ref_id,
//                'operator_type' => $this->clg->clg_group,
//                'base_month' => $this->post['base_month'],
//                'sub_type' => 'ADV',
//                'sub_status' => 'ATNG'
//            );
//
//
//
//            $this->common_model->assign_operator($args);
        ////////////////////////////////////////////////////////////////


        $args = array(
            'adv_cl_inc_id' => $data['cl_dtl'][0]->adv_inc_ref_id,
            'base_month' => $this->post['base_month']
        );


        $data['prev_cl_dtl'] = $this->Medadv_model->prev_call_adv($args);


        $args_pat = array(
            'adv_cl_ptn_id' => $data['pt_info'][0]->ptn_id,
            'adv_cl_base_month' => $this->post['base_month'],
            'adv_cl_inc_id' => $this->post['inc_ref_id'],
        );

        if ($this->clg->clg_group == 'UG-ERCP-104') {
            $data['medadv_info'] = $this->Medadv_model->get_medadv_by_inc_help_desk($args_pat);
        }else{
            $data['medadv_info'] = $this->Medadv_model->get_medadv_by_inc($args_pat);

        }

        ////////////////////////////////////////////////////////////////

        $this->output->add_to_position($this->load->view('frontend/medadv/amb_details_view', $data, TRUE), 'content', TRUE);

        $this->output->set_focus_to = "madv_loc";

        $this->output->add_to_position($this->load->view('frontend/medadv/inc_details_view', $data, TRUE), 'content', TRUE);

//        $this->output->add_to_position("<span>ERCP Call </span>", 'section_title', TRUE);
    }

        function ero_call_details() {


        
            $data['opt_id'] = $this->post['opt_id'];
            
            $data['sub_id'] = $this->post['sub_id'];
        if (!isset($this->post['inc_ref_id'])) {
           // echo "jo";
            //var_dump($this->post['sub_id']);
           // die();

            $data['opt_id'] = $this->post['opt_id'];
            
            $data['sub_id'] = $this->post['sub_id'];
            

            ////////////////////////////////////////////////////////////


            $args = array(
                'opt_id' => $data['opt_id'],
                'sub_id' => $data['sub_id'],
                //'inc_ref_id' => $data['adv_inc_ref_id'],
                'clr_mobile' => $data['mobile_no'],
                'base_month' => $this->post['base_month']
            );

            $data['cl_dtl'] = $this->Medadv_model->call_detials($args);
            
            

            $this->session->set_userdata('ercp_inc_ref_id', $data['cl_dtl'][0]->adv_inc_ref_id);

            $inc_args = array(
                'inc_ref_id' => $data['cl_dtl'][0]->adv_inc_ref_id,
                'base_month' => $this->post['base_month']
            );

            $data['pt_info'] = $this->Pet_model->get_ptinc_info($inc_args);

            $data['patient_id'] = $data['pt_info'][0]->ptn_id;

            $args_pur = array('pcode' => $data['pt_info'][0]->inc_type);
            $call_pur = $this->inc_model->get_purpose_call($args_pur);
            $data['pname'] = $call_pur[0]->pname;

            $data['patient_info'] = $this->pcr_model->get_pat_by_inc($inc_args);
            $data['amb_data'] = $this->inc_model->get_inc_details($inc_args);
        } else {
           // echo "jqwo";
            $data['sub_id'] = $this->post['sub_id'];

            $args_ercp = array(
                'inc_ref_id' => trim($this->post['inc_ref_id']),
                'clr_mobile' => trim($this->post['mobile_no']),
                
                // 'base_month' => $this->post['base_month']
            );


            $this->session->set_userdata('ercp_inc_ref_id', $this->post['inc_ref_id']);
            //var_dump($args_ercp);

            $data['cl_dtl'] = $this->Medadv_model->get_ercp_call_detials($args_ercp);
            
            
           $args = array(
                'inc_ref_id' => $data['cl_dtl'][0]->adv_inc_ref_id,
  
            );


            $data['pt_info'] = $this->Pet_model->get_ptinc_info($args);
            $data['amb_data'] = $this->inc_model->get_inc_details($args);

            $data['questions'] = $this->inc_model->get_inc_summary($args);

            $data['patient_info'] = $this->pcr_model->get_pat_by_inc($args);
            $data['patient_id'] = $data['pt_info'][0]->ptn_id;
            $args_pur = array('pcode' => $data['pt_info'][0]->cl_purpose);
            //  $args_pur = array('pcode' =>trim($data['pt_info'][0]->inc_type));
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
        $args = array(
            'adv_cl_inc_id' => $data['cl_dtl'][0]->adv_inc_ref_id,
            'base_month' => $this->post['base_month']
        );


        $data['prev_cl_dtl'] = $this->Medadv_model->prev_call_adv($args);


        $args_pat = array(
            'adv_cl_ptn_id' => $data['pt_info'][0]->ptn_id,
            'adv_cl_base_month' => $this->post['base_month'],
            'adv_cl_inc_id' => $this->post['inc_ref_id'],
        );

        $data['medadv_info'] = $this->Medadv_model->get_medadv_by_inc($args_pat);

        ////////////////////////////////////////////////////////////////
        $data['help_standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $data['pt_info'][0]->help_standard_summary));

        $this->output->add_to_position($this->load->view('frontend/medadv/amb_details_view', $data, TRUE), 'content', TRUE);

        $this->output->set_focus_to = "madv_loc";

        $this->output->add_to_position($this->load->view('frontend/medadv/inc_details_view', $data, TRUE), 'content', TRUE);

//        $this->output->add_to_position("<span>ERCP Call </span>", 'section_title', TRUE);
    }
    //// Created by MI42 ////////////////////
    // 
    // Purpose : To load advice Ans.
    // 
    /////////////////////////////////////////

    function get_madv_ans() {

        $ans = $this->common_model->get_answer(array('ans_que_id' => $this->post['que_id']));

        $que = $this->common_model->get_question(array('que_id' => $this->post['que_id']));

        $prepared_ans = "<p>" . $que[0]->que_question . "</p>" . $ans[0]->ans_answer;

        $this->output->add_to_position($prepared_ans, 'madv_ans', TRUE);
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To save advice details(ERCP).
    // 
    /////////////////////////////////////////

    function save_adv() {
        

       // var_dump($this->input->post());
        // die();
        $args = array(
            'adv_cl_base_month' => $this->post['base_month'],
            'adv_cl_date' => $this->today,
            'adv_cl_added_by' => $this->clg->clg_ref_id,
            'atnd_date' => date('Y-m-d H:i:s', strtotime($this->input->post('hi')))  
            );
           //
        $args = array_merge($this->post['cdata'], $args);
         //  var_dump($args['adv_inc_ref_id']);
        

        $res = $this->Medadv_model->add_adv($args);
          
        //var_dump($res);die;
        $added_date=date('Y-m-d H:i:s');
        $args_adv = array(
            'adv_inc_ref_id' => $this->post['cdata']['adv_cl_inc_id'],
            'adv_cl_id' => $this->post['cdata']['adv_cl_adv_id'],
            'adv_emt' => $this->clg->clg_ref_id,
            'adv_base_month' => $this->post['base_month'],
            'adv_advice' => $this->post['cdata']['adv_cl_ercp_addinfo']
            //'adv_date' => $added_date
        );



        $adv_id = $this->Medadv_model->add($args_adv);

        //////////////////////////////////////////////

        $args = array(
            'sub_id' => $adv_id,
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'sub_type' => 'ADV',
            'base_month' => $this->post['base_month'],
            'sub_status' => 'ATND'
        );

       //var_dump($args);die;

        $res = $this->common_model->assign_operator($args);

        
        $args_up = array('opt_id' =>  $this->clg->clg_ref_id,
            'sub_id' => $args_adv['adv_inc_ref_id'],
            'sub_type' => 'ADV');
          update_opt_status($args_up);

        ////////////////////////////////////////////////////////////

        $args = array('opt_id' => $this->post['opt_id'],
            'sub_id' => $this->post['sub_id'],
            'sub_type' => 'ADV');

        update_opt_status($args);
        //die();


        //////////////////////////////////////////////

        if ($res) {

            $this->output->message = "<div class='success'>Details saved successfully</div><script>window.location.reload(true);</script>";
            //$this->output->message = "<div class='success'>Details saved successfully</div>";
        }
    }


    //Counslor Data
    function save_counslor_desk_info(){
        $args = array(
            'cons_cl_base_month' => $this->post['base_month'],
            'cons_cl_date' => $this->today,
            'cons_cl_added_by' => $this->clg->clg_ref_id,
            'cons_atnd_date' => date('Y-m-d H:i:s', strtotime($this->input->post('hi')))  
            );
           
            // var_dump($this->post['cdata']);die();
        $args = array_merge($this->post['cdata'], $args);
      
        $res = $this->Medadv_model->add_counslor_desk_adv($args);
        
        $added_date=date('Y-m-d H:i:s');
        $args_adv = array(
            'cons_inc_ref_id' => $this->post['cdata']['cons_cl_inc_id'],
            'cons_cl_id' => $this->post['cdata']['cons_cl_adv_id'],
            'cons_emt' => $this->clg->clg_ref_id,
            'cons_base_month' => $this->post['base_month'],
            'cons_advice' => $this->post['cdata']['cons_counslor_note'],
            'cons_remark' => $this->post['cdata']['cons_std_remark'],
            'cons_date' => $added_date,
            'cons_new_inc_ref_id'  => $this->post['cdata']['cons_cl_inc_id'],
            'cons_is_deleted' => '0'
        );
        //var_dump($args_adv);
        $adv_id = $this->Medadv_model->add_counslor_desk($args_adv);
        $args = array(
            'sub_id' => $adv_id,
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'sub_type' => 'COUNSLOR',
            'base_month' => $this->post['base_month'],
            'sub_status' => 'ATND'
        );


        $res = $this->common_model->assign_operator($args);

       
        $args_up = array('opt_id' =>  $this->clg->clg_ref_id,
            'sub_id' => $this->post['cdata']['cons_cl_inc_id'],
            'sub_type' => 'COUNSLOR');
            //var_dump($args_up);die();
          update_opt_status($args_up);
       // die();
        $args = array('opt_id' => $this->post['opt_id'],
            'sub_id' => $this->post['cdata']['cons_cl_inc_id'],
            'sub_type' => 'COUNSLOR');

        update_opt_status($args);
        
        $agent_id=$this->clg->clg_avaya_agentid; 
        $agent_id='-1'; 
        $crmsessionId=$this->clg->clg_crmsessionId; 
      
        $campaign=$this->clg->clg_avaya_campaign; 
        $sessionid= $this->session->userdata('sessionid');
        $crtObjectId =  $this->session->userdata('crtObjectId');
        $userCrtObjectId =  $this->session->userdata('userCrtObjectId');
        $cti_mobile_number =  $this->session->userdata('cti_mobile_number');
        
        $cl_purpose = $this->session->userdata('cl_purpose');
        
        $disposition_code = 'Couseling Call Done';

          
        if($crmsessionId != ''){      
            
            
            $crm_data = 'phone='.$cti_mobile_number.'&campaignId='.$campaign.'&customerId='.$agent_id.'&dispositionCode='.$disposition_code.'&sessionId='.$sessionid.'&crtObjectId='.$crtObjectId.'&userCrtObjectId='.$userCrtObjectId.'&selfCallback=true';
            $avaya_server_url =  $this->ameyo_server_url.'/dacx/dispose?'.$crm_data;
            
            if (!is_dir('./logs/' . date("Y-m-d"))) {
                mkdir('./logs/' . date("Y-m-d"), 0755, true);
            }           
              file_put_contents('./logs/'.date("Y-m-d").'/'.$agent_id.'_dispose_call_para.log', $avaya_server_url.",\r\n", FILE_APPEND);

          
            $avaya_resp =  agent_dispose_call($avaya_server_url,$data);
            
           
            file_put_contents('./logs/'.date("Y-m-d").'/'.$agent_id.'_dispose_call.log', $avaya_resp['resp'].",\r\n", FILE_APPEND);
        
        }
        $this->session->unset_userdata('cti_mobile_number');
        $this->session->unset_userdata('dispose_dial');
        $this->session->set_userdata('call_action','');
        
        //die();
        if ($res) {

            $url = base_url("counselor104");
            $this->output->message = "<div class='success'>Details saved successfully</div><script>window.location.href = '".$url."';</script>";
        }
    }
    //// save 104 advice 
    function save_help_desk_adv() {

         $args = array(
             'adv_cl_base_month' => $this->post['base_month'],
             'adv_cl_date' => $this->today,
             'adv_cl_added_by' => $this->clg->clg_ref_id,
             'atnd_date' => date('Y-m-d H:i:s', strtotime($this->input->post('hi')))  
             );

            //  var_dump($args);die();
         $args = array_merge($this->post['cdata'], $args);
       
         $res = $this->Medadv_model->add_help_desk_adv($args);
           
         $added_date=date('Y-m-d H:i:s');
         $args_adv = array(
             'adv_inc_ref_id' => $this->post['cdata']['adv_cl_inc_id'],
             'adv_cl_id' => $this->post['cdata']['adv_cl_adv_id'],
             'adv_emt' => $this->clg->clg_ref_id,
             'adv_base_month' => $this->post['base_month'],
             'adv_advice' => $this->post['cdata']['adv_cl_ercp_addinfo'],
             'adv_date' => $added_date
         );
 
         $adv_id = $this->Medadv_model->add_help_desk($args_adv);
  
         $args = array(
             'sub_id' => $adv_id,
             'operator_id' => $this->clg->clg_ref_id,
             'operator_type' => $this->clg->clg_group,
             'sub_type' => 'ADV',
             'base_month' => $this->post['base_month'],
             'sub_status' => 'ATND'
         );

 
         $res = $this->common_model->assign_operator($args);
 
         
         $args_up = array('opt_id' =>  $this->clg->clg_ref_id,
             'sub_id' => $args_adv['adv_inc_ref_id'],
             'sub_type' => 'ADV');
           update_opt_status($args_up);
  
         $args = array('opt_id' => $this->post['opt_id'],
             'sub_id' => $this->post['sub_id'],
             'sub_type' => 'ADV');
 
         update_opt_status($args);

         if ($res) {
 
             $this->output->message = "<div class='success'>Details saved successfully</div><script>window.location.reload(true);</script>";
         }
     }
    //// Created by MI42 ///////////////////////////////////
    // 
    // Purpose : To get previous advice details(ERCP).
    // 
    ////////////////////////////////////////////////////////

    function prev_call_info() {


        $args = array(
            'base_month' => $this->post['base_month'],
            'adv_cl_id' => $this->post['adv_cl_id']
        );

        $data['cl_dtl'] = $this->Medadv_model->prev_call_dtl($args);


        $inc_args = array(
            'inc_ref_id' => $data['cl_dtl'][0]->adv_cl_inc_id,
            'base_month' => $this->post['base_month']
        );

        $data['patient_info'] = $this->pcr_model->get_pat_by_inc($inc_args);

        $this->output->add_to_position($this->load->view('frontend/medadv/prev_call_dtl', $data, TRUE), $this->post['output_position'], TRUE);
    }

    function prev_help_call_info() {


        $args = array(
            'base_month' => $this->post['base_month'],
            'adv_cl_id' => $this->post['adv_cl_id']
        );

        $data['cl_dtl'] = $this->Medadv_model->prev_call_dtl_help_desk($args);
        // var_dump($data['cl_dtl']);die();

        // $inc_args = array(
        //     'inc_ref_id' => $data['cl_dtl'][0]->adv_cl_inc_id,
        //     'base_month' => $this->post['base_month']
        // );

        // $data['patient_info'] = $this->pcr_model->get_pat_by_inc($inc_args);

        $this->output->add_to_position($this->load->view('frontend/medadv/prev_call_dtl_help_view', $data, TRUE), $this->post['output_position'], TRUE);
    }

    function ercp_patient_details() {

        $data['blood_gp'] = $this->call_model->get_bloodgp();

        if ($this->post['ptn_id']) {

            $inc_id = $this->session->userdata('ercp_inc_ref_id');
            $data['ptn'] = $this->pet_model->get_petinfo(array('ptn_id' => $this->post['ptn_id']));

            $data['ptn_id'] = $this->post['ptn_id'];
            $data['p_id'] = $data['ptn'][0]->p_id;
            $data['inc_id'] = $inc_id;
        } else {
            $inc_id = $this->session->userdata('ercp_inc_ref_id');

            $inc_args = array(
                'inc_ref_id' => trim($inc_id),
                'base_month' => $this->post['base_month'],
            );
         
 $inc_args = array(
                'inc_ref_id' => trim($inc_id),
                'base_month' => $this->post['base_month'],
            );
           
            $ptn = $this->inc_model->get_inc_details($inc_args);
            

            if($ptn[0]->pre_inc_ref_id != ''){
                
                $inc_args = array(
                    'inc_ref_id' => trim($ptn[0]->pre_inc_ref_id),
                    'base_month' => $this->post['base_month'],
                );
           
                $ptn = $this->inc_model->get_inc_details($inc_args);
            }
            $inc['ptn_state'] = $ptn[0]->inc_state_id;
            $inc['ptn_district'] = $ptn[0]->inc_district_id;
            $inc['ptn_city'] = $ptn[0]->inc_city_id;
            $inc['ptn_address'] = $ptn[0]->inc_address;
            $inc['ptn_ltd'] = $ptn[0]->inc_lat;
            $inc['ptn_lng'] = $ptn[0]->inc_long;
            

               
         

           
            $ptn = $this->inc_model->get_inc_details($inc_args);

            $data['inc'] = $inc;
            $data['inc_id'] = $inc_id;
        }

       /// $this->output->add_to_popup($this->load->view('frontend/medadv/patient_details_view', $data, TRUE), '1000', '1000');
         //$this->output->add_to_popup($this->load->view('frontend/medadv/add_patient_details_view', $data, TRUE), '1200', '500');
         $this->output->add_to_position($this->load->view('frontend/medadv/add_patient_details_view', $data, TRUE), 'popup_div', TRUE);
    }

//    function ercp_save_patient_details() {
//
//        $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
//
//        $last_pat_id = $last_insert_pat_id[0]->p_id + 1;
//        $last_pat_id = generate_ptn_id();
//        
//
//        $args = array(
//            'ptn_state' => $this->post['ptn_dtl_state'],
//            'ptn_district' => $this->post['ptn_dtl_districts'],
//            //'ptn_city' => $this->post['ptn_dtl_ms_city'],
//            //'ptn_area' => $this->post['ptn_dtl_area'],
//            //'ptn_landmark' => $this->post['ptn_dtl_lmark'],
//            //'ptn_lane' => $this->post['ptn_dtl_lane'],
//            //'ptn_house_no' => $this->post['ptn_dtl_hno'],
//            //'ptn_pincode' => $this->post['ptn_dtl_pincode'],
//            'ptn_age' => $this->post['ptn']['ptn_age'],
//            'ptn_birth_date' => date('Y-m-d', strtotime($this->post['ptn']['ptn_birth_date'])),
//            'ptn_added_by' => $this->clg->clg_ref_id,
//            'ptn_added_date' => date('Y-m-d H:i:s'),
//            'ptn_modify_by' => $this->clg->clg_ref_id,
//            'ptn_modify_date' => date('Y-m-d H:i:s'),
//        );
//
//        $args = array_merge($this->post['ptn'], $args);
//
//        /////////////////////////////////////////////////////////
//
//        $inc_id = $this->session->userdata('ercp_inc_ref_id');
//
//
//        /////////////////////////////////////////////////////////
//
//        if ($this->post['ptn_id']) {
//
//            $this->pet_model->update_petinfo(array('ptn_id' => $this->post['ptn_id']), $args);
//
//            $this->output->status = 1;
//
//            $this->output->closepopup = "yes";
//
//            $this->output->message = "<div class='success'>Details updated successfully</div>";
//
//            $pt_id = $this->post['ptn_id'];
//        } else {
//            $arg_pt = array('ptn_id' => $last_pat_id);
//            $args = array_merge($args, $arg_pt);
//            $pt_id = $this->pet_model->insert_patient_details($args);
//              
//            if($pt_id){
//                $args = array('inc_id' => $inc_id, 'ptn_id' => $last_pat_id);
//
//                $this->pet_model->insert_inc_pat($args);
//
//                $this->output->status = 1;
//
//                $this->output->closepopup = "yes";
//
//                $this->output->message = "<div class='success'>Details inserted successfully</div>";
//            }else{
//                 $this->output->message = "<div class='error'>Error..!! Please try again..!!</div>";
//            }
//        }
//
//
//        $this->post['p_id'] = $pt_id;
//        $this->post['ptn_id'] = $last_pat_id;
//
//        $this->update_ercp_patient_details();
//    }

        function ercp_save_patient_details(){
        
        $ptn = $this->post['ptn'];
        
        $fname = ucfirst($ptn['ptn_fname']);
        $mname = ucfirst($ptn['ptn_mname']);
        $lname = ucfirst($ptn['ptn_lname']);
        $ptn_birth_date='';
        if($this->post['ptn']['ptn_birth_date'] != ''){
            $ptn_birth_date = date('Y-m-d', strtotime($this->post['ptn']['ptn_birth_date']));
        }
        $args = array(
            'ptn_fullname' => $fname.' '.$mname.' '.$lname,
            'ptn_age' => $this->post['ptn']['ptn_age'],
            'ptn_age_type' => $this->post['ptn']['ptn_age_type'],
            'ayushman_id' => $this->post['ptn']['ayushman_id'],
            'ptn_bgroup' => $this->post['ptn']['ptn_bgroup'],
            'ptn_opd_id' => $this->post['ptn']['ptn_opd_id'],
            'ptn_pcf_no' => $this->post['ptn']['ptn_pcf_no']
        );
       
      
        $args = array_merge($this->post['ptn'], $args);
        $args['ptn_fname'] = ucfirst($args['ptn_fname']);
        $args['ptn_mname'] = ucfirst($args['ptn_mname']);
        $args['ptn_lname'] = ucfirst($args['ptn_lname']);
        $inc_id = $this->session->userdata('ercp_inc_ref_id');
      
        
        if ($this->post['ptn_id'] != '') {
            $args['ptn_modify_by'] = $this->clg->clg_ref_id;
            $args['ptn_modify_date'] = date('Y-m-d H:i:s');
             
             
            $this->pet_model->update_petinfo(array('ptn_id' => $this->post['ptn_id']), $args);

            $this->output->status = 1;

            $this->output->closepopup = "yes";

            $this->output->message = "<div class='success'>Details updated successfully</div>";

            $pt_id = $this->post['ptn_id'];
            
        }else{
            foreach ($this->post['ptn'] as $dt) {
                if($dt['ptn_fname'] == '' && $dt['ptn_lname']=='' && $dt['ptn_age']=='' && $dt['ptn_gender']=='' ){
                    continue;
                }
            $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
            $clg_id = $this->clg->clg_id;
            $last_pat_id = $last_insert_pat_id[0]->p_id + 1;
           // $last_pat_id = $clg_id.'_'.$last_pat_id;
            $last_pat_id = generate_ptn_id();


            $dt['ptn_id'] = $last_pat_id;
            $dt['ptn_added_by'] = $this->clg->clg_ref_id;
            $dt['ptn_added_date'] = date('Y-m-d H:i:s');
           
               $inc_id = $this->session->userdata('ercp_inc_ref_id');
                $dt['ptn_fname'] = ucfirst($dt['ptn_fname']);
                $dt['ptn_mname'] = ucfirst($dt['ptn_mname']);
                $dt['ptn_lname'] = ucfirst($dt['ptn_lname']);
                $dt['ayushman_id'] = ucfirst($dt['ayushman_id']);
                $dt['ptn_bgroup'] = ucfirst($dt['ptn_bgroup']);
                $dt['ptn_opd_id'] = ucfirst($dt['ptn_opd_id']);
                $dt['ptn_pcf_no'] = ucfirst($dt['ptn_pcf_no']);
                
                $pt_id = $this->pet_model->insert_updated_patient_details($dt);
              
            
//            if($dt['ptn_lname'] !='' && $dt['ptn_age'] !=''){
//                
//                
//                $dt['ptn_fname'] = ucfirst($dt['ptn_fname']);
//                $dt['ptn_mname'] = ucfirst($dt['ptn_mname']);
//                $dt['ptn_lname'] = ucfirst($dt['ptn_lname']);
//                
//                $ptn_exists = $this->pet_model->get_patient_details($dt,$inc_id);
//                if(empty($ptn_exists)){
//                    $pt_id = $this->pet_model->insert_updated_patient_details($dt);
//                }else{
//                    $this->output->message = "<div class='error'>Patient Name alredy exists for this incident</div>";
//                    return;
//                }
//            
//            }
         
            if($pt_id){
                if($dt['ptn_lname'] !='' && $dt['ptn_age'] !=''){
                    
                $args = array('inc_id' => $inc_id, 'ptn_id' => $last_pat_id);

                $add_patient =  $this->pet_model->insert_inc_pat($args);

                 $args_pt = array('get_count' => TRUE,
                'inc_ref_id' => $inc_id);

                $ptn_count = $this->pcr_model->get_pat_by_inc($args_pt);

                if ($pcr_count == $ptn_count || $pcr_count >= $ptn_count) {

                    $update_inc_args = array('inc_ref_id' => $inc_id, 'inc_pcr_status' => '1');
                    $update_inc = $this->inc_model->update_incident($update_inc_args);

                } else {

                    $update_inc_args = array('inc_ref_id' => $inc_id, 'inc_pcr_status' => '0');
                    $update_inc = $this->inc_model->update_incident($update_inc_args);

                }

                $this->output->status = 1;

                $this->output->closepopup = "yes";

                $this->output->message = "<div class='success'>Details inserted successfully</div>";
                
                }
            }else{
                  $this->output->message = "<div class='error'>Error</div>";
                  
            }
        } }
        //return;
        $this->post['p_id'] = $pt_id;
        $this->post['ptn_id'] = $pt_id;

        $this->update_ercp_patient_details();
       // die();
    }
    public function update_ercp_patient_details() {


        $inc_ref_id = $this->session->userdata('ercp_inc_ref_id');

        $args_pat = array(
            'adv_cl_ptn_id' => $this->post['ptn_id'],
            'adv_cl_base_month' => $this->post['base_month'],
            'adv_cl_inc_id' => $inc_ref_id
        );


        $args = array(
            'inc_ref_id' => trim($inc_ref_id),
            'base_month' => $this->post['base_month'],
        );

        $data['questions'] = $this->inc_model->get_inc_summary($args);
        $data['patient_info'] = $this->pcr_model->get_pat_by_inc($args);

        $data['amb_data'] = $this->inc_model->get_inc_details($args);
        $data['medadv_info'] = $this->Medadv_model->get_medadv_by_inc($args_pat);

        $data['cl_dtl'] = $this->Medadv_model->get_ercp_call_detials($args);

        $args = array(
            'adv_cl_inc_id' => trim($inc_ref_id),
            'base_month' => $this->post['base_month']
        );


        $data['prev_cl_dtl'] = $this->Medadv_model->prev_call_adv($args);

        $pt_args = array(
            'inc_ref_id' => trim($inc_ref_id),
            'base_month' => $this->post['base_month'],
            'ptn_id' => $this->post['ptn_id'],
        );

        $data['pt_info'] = $this->Pet_model->get_ptinc_info($pt_args);


        $data['patient_id'] = $this->post['ptn_id'];

        $this->output->status = 1;

        $this->output->closepopup = "yes";


        //$this->output->add_to_position($this->load->view('frontend/medadv/inc_details_view', $data, TRUE), 'call_purpose_form_outer', TRUE);

        $this->output->add_to_position($this->load->view('frontend/medadv/ercp_pat_view', $data, TRUE), 'pat_details_block', TRUE);
    }

}
