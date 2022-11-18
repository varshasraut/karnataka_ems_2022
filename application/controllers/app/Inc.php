<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class INC extends EMS_Controller {

    function __construct() {

        parent::__construct();
        $this->active_module = "M-INC";
        $this->pg_limit = $this->config->item('pagination_limit');
        $this->load->model(array('inc_model', 'get_city_state_model', 'options_model', 'module_model', 'amb_model', 'call_model', 'pet_model', 'hp_model', 'pcr_model', 'colleagues_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date','cct_helper', 'comman_helper'));
        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));
        $this->post = $this->input->get_post(NULL);
        $this->clg = $this->session->userdata('current_user');
        $this->post['base_month'] = get_base_month();

        $this->google_api_key = $this->config->item('google_api_key');
        //$this->check_user_permission($this->session->userdata('current_user')->clg_id , $this->session->userdata('current_user')->clg_group );
    }

    function index() {
        
    }

    function load_inc() {

        $call_purpose = $this->input->get_post('caller');
        $inc_view_name = strtolower($call_purpose["cl_purpose"]) . '_view';
        //$this->output->add_to_position($this->load->view('frontend/calls/mci_calls_view',$data,TRUE),$this->post['output_position'],TRUE);    

        $this->output->add_to_position($this->load->view('frontend/inc/' . $inc_view_name, $data, TRUE), 'inc_details', TRUE);
    }

    function save_inc() {

        $call_type = $this->input->get();
        $inc_details = $this->input->get_post('incient');
        $call_id = $this->input->get_post('call_id');
        $caller_details = $this->session->userdata('caller_details');
        $inc_details = $this->session->userdata('mic_details');
        $inc_post_details = $this->session->userdata('inc_post_details');
        $patient = $this->session->userdata('patient');
        
         if($this->clg->clg_group == 'UG-ERO-102'){
            $system = '102';
        }else{
            $system = '108';
        }

        $datetime = date('Y-m-d H:i:s');

        $sft_id = '';

        $shift_time = explode(":", date('H:i:s'));

        if ($shift_time[0] >= 0 && $shift_time[0] <= 6) {

            $sft_id = 3;
        }if ($shift_time[0] >= 6 && $shift_time[0] <= 16) {

            $sft_id = 1;
        }if ($shift_time[0] >= 16 && $shift_time[0] <= 23) {

            $sft_id = 2;
        }

        /// $call_type = $this->session->userdata('call_type');

        $call_id = $this->session->userdata('call_id');
        $dup_inc = $inc_details['dup_inc'];

        $district_id = "0";
        $city_id = "0";
        $state_id = "0";

        $state_id = $this->inc_model->get_state_id($inc_details['state']);
        $district_id = $this->inc_model->get_district_id($inc_details['inc_district'], $state_id->st_code);


        $city_id = $this->inc_model->get_city_id($inc_details['inc_city'], $district_id->dst_code, $state_id->st_code);

        if (isset($district_id)) {

            $district_id = $district_id->dst_code;
        } else {

            $district_id = "0";
        }

        if (isset($city_id)) {

            $city_id = $city_id->cty_id;
        } else {

            $city_id = "0";
        }

        if (isset($state_id)) {

            $state_id = $state_id->st_code;
        } else {

            $state_id = "0";
        }


        $inc_details_service = serialize($inc_details['service']);


        if ($inc_post_details['incient_state'] == '') {
            $inc_post_details['incient_state'] = "MP";
        }
        $date = str_replace('-', '', date('Y-m-d'));

        //$inc_id = $date.$call_id;
        $inc_id = $this->session->userdata('inc_ref_id');




        $sr_user = $this->clg->clg_ref_id;

        $sms_amb_details = $inc_details['amb_id'];

        if ($inc_details['amb_id'] == '' && $dup_inc == 'Yes') {

            $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";

            return;
        }


        if ($dup_inc == 'No') {
            $amb_count = 0;
            foreach ($inc_details['amb_id'] as $key => $select_amb) {
                $amb_count++;
                $inc_re_id = $inc_id . '-' . $amb_count;


                $incidence_details = array('inc_cl_id' => $call_id,
                    'inc_ref_id' => $inc_re_id,
                    'inc_type' => $inc_details['inc_type'],
                    'inc_ero_summary' => $inc_details['inc_ero_summary'],
                    'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
                    'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
                    'inc_dispatch_time' => $inc_details['caller_dis_timer'],

                    // 'inc_city' => $inc_details['inc_city'],
                    'inc_city_id' => $inc_post_details['incient_ms_city'],
                    //'inc_state' => $inc_post_details['incient_state'],
                    'inc_state_id' => $inc_post_details['incient_state'],
                    'inc_address' => $inc_details['place'],
                    //'inc_district' => $inc_post_details['incient_district'],
                    'inc_district_id' => $inc_post_details['incient_district'],
                    'inc_area' => $inc_details['area'],
                    'inc_landmark' => $inc_details['landmark'],
                    'inc_lane' => $inc_details['lane'],
                    'inc_h_no' => $inc_details['h_no'],
                    'inc_pincode' => $inc_details['pincode'],
                    'inc_lat' => $inc_details['lat'],
                    'inc_long' => $inc_details['lng'],
                    'inc_datetime' => $datetime,
                    'inc_service' => $inc_details_service,
                    'inc_duplicate' => $dup_inc,
                    'inc_base_month' => $this->post['base_month'],
                    'inc_set_amb' => '1',
                    'inc_recive_time' => $inc_details['inc_recive_time'],
                    'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
                    'inc_added_by' => $this->clg->clg_ref_id,
                    'inc_system_type' => $system
                );


                if ($inc_details['cluster_name'] != '') {
                    $incidence_details['inc_cluster_id'] = $inc_details['cluster_name'];
                }
                if ($inc_details['chief_complete_other'] != '') {
                    $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                }
                if ($inc_details['police_chief_complete'] != '') {
                    $incidence_details['police_chief_complete'] = $inc_details['police_chief_complete'];
                }
                if ($inc_details['police_chief_complete_other'] != '') {
                    $incidence_details['police_chief_complete_other'] = $inc_details['police_chief_complete_other'];
                }
                if ($inc_details['fire_chief_complete'] != '') {
                    $incidence_details['fire_chief_complete'] = $inc_details['fire_chief_complete'];
                }
                if ($inc_details['fire_chief_complete_other'] != '') {
                    $incidence_details['fire_chief_complete_other'] = $inc_details['fire_chief_complete_other'];
                }

               
                if ($inc_details['service'][1] == 'on' || $inc_details['service'][1] == '1') {

                    $ercp_user = $this->inc_model->get_fire_user($sr_user, 'UG-ERCP');

                    $ercp_operator = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $ercp_user->clg_ref_id,
                        'operator_type' => 'UG-ERCP',
                        'sub_status' => 'ASG',
                        'sub_type' => $inc_details['inc_type'],
                        'base_month' => $this->post['base_month']
                    );


                    if (isset($ercp_user)) {
                        $police_operator = $this->common_model->assign_operator($ercp_operator);
                    }
                }

                if ($inc_details['service'][2] == '2') {

                    $police_user = $this->inc_model->get_fire_user($sr_user, 'UG-PDA');

//                if (!isset($police_user)) {
//
//                    $this->output->message = "<div class='error'>No police team member under this ERO</div>";
//
//                    return;
//                }

                    $police_operator2 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $police_user->clg_ref_id,
                        'operator_type' => 'UG-PDA',
                        'sub_status' => 'ASG',
                        'sub_type' => $inc_details['inc_type'],
                        'base_month' => $this->post['base_month']
                    );


                    if (isset($police_user)) {
                        $police_operator = $this->common_model->assign_operator($police_operator2);
                    }
                }

                if ($inc_details['service'][3] == '3') {

                    $fire_user = $this->inc_model->get_fire_user($sr_user, 'UG-FDA');



                    $fire_operator = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $fire_user->clg_ref_id,
                        'operator_type' => 'UG-FDA',
                        'sub_status' => 'ASG',
                        'sub_type' => $inc_details['inc_type'],
                        'base_month' => $this->post['base_month']
                    );
                    if (isset($fire_user)) {
                        $fire_operator = $this->common_model->assign_operator($fire_operator);
                    }
                }


                $inc_details['amb_id'] = $select_amb;
                $EMT = "";
                $pilot = '';
                //$emp_inc_data = $this->inc_model->get_amb_default_emp(trim($inc_details['amb_id']), $sft_id);
//                    $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id);
//
//                    $pilot = $emp_inc_data[0]->tm_pilot_id;
//                    $EMT = $emp_inc_data[0]->tm_emt_id;

                $emp_inc_data = $this->inc_model->get_amb_emp($inc_details['amb_id'], $sft_id);




                if (empty($emp_inc_data)) {
                    $tm_team_date = date('Y-m-d');
                    $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id, $tm_team_date);


                    if (!empty($emp_inc_data)) {
                        $pilot = $emp_inc_data[0]->tm_pilot_id;

                        $EMT = $emp_inc_data[0]->tm_emt_id;
                    }
                } else {



                    foreach ($emp_inc_data as $amb_emp) {

                        if ($amb_emp->scd_amb_team_member_type == 'EMT') {

                            $EMT = $amb_emp->scd_amb_team_member_id;
                        }

                        if ($amb_emp->scd_amb_team_member_type == 'Pilot') {

                            $pilot = $amb_emp->scd_amb_team_member_id;
                        }
                    }
                }
                $incidence_amb_details = array('amb_rto_register_no' => $inc_details['amb_id'],
                    'inc_ref_id' => $inc_re_id,
                    'amb_pilot_id' => $pilot,
                    'amb_emt_id' => $EMT,
                    'inc_base_month' => $this->post['base_month'],
                    'assigned_time' => $datetime);
                $this->inc_model->insert_inc_amb($incidence_amb_details);

                if ($pilot != '') {
                    $args_operator1 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $pilot,
                        'operator_type' => 'UG-PILOT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'MCI',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator1 = $this->common_model->assign_operator($args_operator1);
                }

                if ($EMT != '') {
                    $args_operator2 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $EMT,
                        'operator_type' => 'UG-EMT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'MCI',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator2 = $this->common_model->assign_operator($args_operator2);
                }


                $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);

                $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);

                $incidence_details['inc_mci_nature'] = $inc_details['mci_nature'];

                $inc_data = $this->inc_model->insert_inc($incidence_details);


                $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
                $last_pat_id = $last_insert_pat_id[0]->p_id + 1;

                $incidence_patient_details = array('ptn_fname' => $patient['first_name'],
                    'ptn_mname' => $patient['middle_name'],
                    'ptn_lname' => $patient['last_name'],
                    'ptn_gender' => $patient['gender'],
                    'ptn_fullname' => $patient['first_name'] . ' ' . $patient['middle_name'] . ' ' . $patient['last_name'],
                    'ptn_age' => $patient['age'],
                    'ptn_birth_date' => $patient['dob'],
                    'ptn_id' => $last_pat_id
                );

                $patient_full_name = $patient['first_name'] . ' ' . $patient['middle_name'] . ' ' . $patient['last_name'];
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);

                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "MCI",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
            }

            if ($inc_details['stand_amb_id']) {

                foreach ($inc_details['stand_amb_id'] as $key => $stand_amb_id) {


                    $inc_re_id = $inc_id . '-' . $key + 1;
                    $incidence_details = array('inc_cl_id' => $call_id,
                        'inc_ref_id' => $inc_re_id,
                        'inc_type' => $inc_details['inc_type'],
                        'inc_ero_summary' => $inc_details['inc_ero_summary'],
                        'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
                        'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
                        'inc_dispatch_time' => $inc_details['caller_dis_timer'],
                        // 'inc_city' => $inc_details['inc_city'],
                        'inc_city_id' => $inc_post_details['incient_ms_city'],
                        //'inc_state' => $inc_post_details['incient_state'],
                        'inc_state_id' => $inc_post_details['incient_state'],
                        'inc_address' => $inc_details['place'],
                        //'inc_district' => $inc_post_details['incient_district'],
                        'inc_district_id' => $inc_post_details['incient_district'],
                        'inc_area' => $inc_details['area'],
                        'inc_landmark' => $inc_details['landmark'],
                        'inc_lane' => $inc_details['lane'],
                        'inc_h_no' => $inc_details['h_no'],
                        'inc_pincode' => $inc_details['pincode'],
                        'inc_lat' => $inc_details['lat'],
                        'inc_long' => $inc_details['lng'],
                        'inc_datetime' => $datetime,
                        'inc_service' => $inc_details_service,
                        'inc_duplicate' => $dup_inc,
                        'inc_base_month' => $this->post['base_month'],
                        'inc_set_amb' => '1',
                        'inc_recive_time' => $inc_details['inc_recive_time'],
                        'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
                        'inc_added_by' => $this->clg->clg_ref_id,
                        'inc_system_type' => $system
                    );

                    if ($inc_details['cluster_name'] != '') {
                        $incidence_details['inc_cluster_id'] = $inc_details['cluster_name'];
                    }
                    if ($inc_details['chief_complete_other'] != '') {
                        $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                    }
                    if ($inc_details['police_chief_complete'] != '') {
                        $incidence_details['police_chief_complete'] = $inc_details['police_chief_complete'];
                    }
                    if ($inc_details['police_chief_complete_other'] != '') {
                        $incidence_details['police_chief_complete_other'] = $inc_details['police_chief_complete_other'];
                    }
                    if ($inc_details['fire_chief_complete'] != '') {
                        $incidence_details['fire_chief_complete'] = $inc_details['fire_chief_complete'];
                    }
                    if ($inc_details['fire_chief_complete_other'] != '') {
                        $incidence_details['fire_chief_complete_other'] = $inc_details['fire_chief_complete_other'];
                    }

                    if ($inc_details['service'][1] == 'on' || $inc_details['service'][1] == '1') {

                        $ercp_user = $this->inc_model->get_fire_user($sr_user, 'UG-ERCP');


                        if (isset($ercp_user)) {

                            $ercp_operator = array(
                                'sub_id' => $inc_re_id,
                                'operator_id' => $ercp_user->clg_ref_id,
                                'operator_type' => 'UG-ERCP',
                                'sub_status' => 'ASG',
                                'sub_type' => $inc_details['inc_type'],
                                'base_month' => $this->post['base_month']
                            );


                            $police_operator = $this->common_model->assign_operator($ercp_operator);
                        }
                    }

                    if ($inc_details['service'][2] == '2') {

                        $police_user = $this->inc_model->get_fire_user($sr_user, 'UG-PDA');

//                if (!isset($police_user)) {
//
//                    $this->output->message = "<div class='error'>No police team member under this ERO</div>";
//
//                    return;
//                }

                        $police_operator2 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $police_user->clg_ref_id,
                            'operator_type' => 'UG-PDA',
                            'sub_status' => 'ASG',
                            'sub_type' => $inc_details['inc_type'],
                            'base_month' => $this->post['base_month']
                        );


                        if ($police_user) {
                            $police_operator = $this->common_model->assign_operator($police_operator2);
                        }
                    }

                    if ($inc_details['service'][3] == '3') {

                        $fire_user = $this->inc_model->get_fire_user($sr_user, 'UG-FDA');

//                if (!isset($fire_user)) {
//
//                    $this->output->message = "<div class='error'>No Fire team member under this ERO</div>";
//
//                    return;
//                }

                        $fire_operator = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $fire_user->clg_ref_id,
                            'operator_type' => 'UG-FDA',
                            'sub_status' => 'ASG',
                            'sub_type' => $inc_details['inc_type'],
                            'base_month' => $this->post['base_month']
                        );
                        if ($fire_user) {
                            $fire_operator = $this->common_model->assign_operator($fire_operator);
                        }
                    }



                    $inc_details['stand_amb_id'] = $stand_amb_id;

                    $EMT = "";
                    $pilot = '';
                    //$emp_inc_data = $this->inc_model->get_amb_default_emp(trim($inc_details['amb_id']), $sft_id);
//                    $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['stand_amb_id'], $sft_id);
//
//                    $pilot = $emp_inc_data[0]->tm_pilot_id;
//                    $EMT = $emp_inc_data[0]->tm_emt_id;

                    $emp_inc_data = $this->inc_model->get_amb_emp($inc_details['amb_id'], $sft_id);

                    if (empty($emp_inc_data)) {
                        $tm_team_date = date('Y-m-d');
                        $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id, $tm_team_date);

                        $pilot = $emp_inc_data[0]->tm_pilot_id;
                        $EMT = $emp_inc_data[0]->tm_emt_id;
                    } else {



                        foreach ($emp_inc_data as $amb_emp) {

                            if ($amb_emp->scd_amb_team_member_type == 'EMT') {

                                $EMT = $amb_emp->scd_amb_team_member_id;
                            }

                            if ($amb_emp->scd_amb_team_member_type == 'Pilot') {

                                $pilot = $amb_emp->scd_amb_team_member_id;
                            }
                        }
                    }

                    $incidence_amb_details = array('amb_rto_register_no' => $inc_details['stand_amb_id'],
                        'inc_ref_id' => $inc_re_id,
                        'amb_pilot_id' => $pilot,
                        'amb_emt_id' => $EMT,
                        'amb_type'=> 'standby',
                        'inc_base_month' => $this->post['base_month'],
                        'assigned_time' => $datetime);

                    $this->inc_model->insert_inc_amb($incidence_amb_details);

                    if ($pilot != '') {

                        $args_operator1 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $pilot,
                            'operator_type' => 'UG-PILOT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'MCI',
                            'base_month' => $this->post['base_month']
                        );
                        $args_operator1 = $this->common_model->assign_operator($args_operator1);
                    }

                    if ($EMT != '') {
                        $args_operator2 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $EMT,
                            'operator_type' => 'UG-EMT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'MCI',
                            'base_month' => $this->post['base_month']
                        );

                        $args_operator2 = $this->common_model->assign_operator($args_operator2);
                    }


                    $incidence_details['inc_mci_nature'] = $inc_details['mci_nature'];

                    $inc_data = $this->inc_model->insert_inc($incidence_details);


                    $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
                    $last_pat_id = $last_insert_pat_id[0]->p_id + 1;

                    $incidence_patient_details = array('ptn_fname' => $patient['first_name'],
                        'ptn_mname' => $patient['middle_name'],
                        'ptn_lname' => $patient['last_name'],
                        'ptn_gender' => $patient['gender'],
                        'ptn_fullname' => $patient['first_name'] . ' ' . $patient['middle_name'] . ' ' . $patient['last_name'],
                        'ptn_age' => $patient['age'],
                        'ptn_birth_date' => $patient['dob'],
                        'ptn_id' => $last_pat_id
                    );

                    $patient_full_name = $patient['first_name'] . ' ' . $patient['middle_name'] . ' ' . $patient['last_name'];
                    $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                    $incidence_patient = array('inc_id' => $inc_re_id,
                        'ptn_id' => $last_pat_id);

                    $this->pet_model->insert_inc_pat($incidence_patient);

                    $args = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $this->clg->clg_ref_id,
                        'operator_type' => $this->clg->clg_group,
                        'sub_status' => 'ASG',
                        'sub_type' => "MCI",
                        'base_month' => $this->post['base_month']
                    );

                    $res = $this->common_model->assign_operator($args);
                }
            }
        }

        update_inc_ref_id($inc_id);


        /* send sms to patient  */
        $sms_amb = $inc_details['amb_id'];
        $get_mobile_no = array('rg_no' => $sms_amb);
        $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);
        $driver = $this->colleagues_model->get_user_info($pilot);
        $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;
        $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;

        //$inc_id = $inc_id;
        $amb_url = base_url() . "amb/loc/" . $inc_id;
        $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_id;

        //$amb_url = "http://210.212.165.123/tdd/amb/loc/" . $inc_id;
        //$amb_dir_url = "http://210.212.165.123/tdd/amb/amb_dir/" . $inc_id;



        $doctor = $this->colleagues_model->get_user_info($EMT);
        $sms_doctor = $doctor[0]->clg_first_name;
        $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;
        $patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];
        $patient_mobile_no = $caller_details['clr_mobile'];
        //$patient_mobile_no = "9730015484";
        $patient_name = $caller_details['clr_fname'];

        $patient_sms_text = "BVG,\n Ambulance dispatched: $sms_amb\n Ambulance Contact - $sms_doctor_contact_no\n Track Link- $amb_url\nMEMS";


        $patient_sms_to = $caller_details['clr_mobile'];
        //$patient_sms_to =  "8551995260";
        $send_dr_sms = $this->_send_sms($patient_sms_to, $patient_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_id,
            'sms_usertype' => 'Caller',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);



        /* send sms to doctor  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];

        if ($get_driver_no[0]->amb_user_type == 'tdd') {

            $doctor_sms_text = "BVG,\nPatient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id, Patient id:$last_pat_id, Navigate- $amb_url MEMS";
        } else if ($get_driver_no[0]->amb_user_type = 'bike') {

            $doctor_sms_text = "BVG,\nPatient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call Bike Desk for Case ID creation. MEMS";
        } else {

            $doctor_sms_text = "BVG,\nPatient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call 108 ERC for Case ID creation.  MEMS";
        }

        $doctor_sms_to = $sms_doctor_contact_no;
        // $doctor_sms_to = '8551995260';
        $send_dr_sms = $this->_send_sms($doctor_sms_to, $doctor_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_id,
            'sms_usertype' => 'EMT',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);

        /* send sms to Pilot  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];

        $driver_sms_text = "BVG,\nDear Pilot, Patient name: $patient_full_name,  Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id , Patient id:$last_pat_id  Navigate- $amb_dir_url MEMS";

        $driver_contact_no = $sms_driver_contact_no;

        if ($call_type['cl_type'] == 'forword') {

            $super_user = $this->inc_model->get_user_by_group('UG-SUPP-CH');


            $args = array(
                'sub_id' => $inc_id,
                'operator_id' => $super_user->clg_ref_id,
                'operator_type' => $super_user->clg_group,
                'base_month' => $this->post['base_month'],
                'sub_type' => $inc_details['inc_type']
            );


            $forword_res = $this->common_model->assign_operator($args);
        }

        $this->output->status = 1;
        $this->output->closepopup = "yes";
        ($call_type['cl_type'] == 'forword') ? $msg = "forworded" : $msg = "Added";
        $this->output->message = "<h3>MCI Call</h3><br><p>Ambulance Dispatch Successfully</p><script> window.location.reload(true);</script>";
        $this->output->moveto = 'top';
        $this->output->add_to_position('', 'content', TRUE);
    }

    function save_nonmci_inc() {

        $call_type = $this->input->get();
        $inc_details = $this->input->get_post('incient');
        $call_id = $this->input->get_post('call_id');
        $caller_details = $this->session->userdata('caller_details');
        $inc_details = $this->session->userdata('mic_details');

        $inc_post_details = $this->session->userdata('inc_post_details');

        $datetime = date('Y-m-d H:i:s');

        $sft_id = get_cur_shift();

        $call_id = $this->session->userdata('call_id');


        $dup_inc = $inc_details['dup_inc'];

        $district_id = "0";
        $city_id = "0";
        $state_id = "0";

        $state_id = $this->inc_model->get_state_id($inc_details['state']);
        $district_id = $this->inc_model->get_district_id($inc_details['inc_district'], $state_id->st_code);

        $city_id = $this->inc_model->get_city_id($inc_details['incient_ms_city'], $district_id->dst_code, $state_id->st_code);
        
        if($this->clg->clg_group == 'UG-ERO-102'){
            $system = '102';
        }else{
            $system = '108';
        }


        if (isset($district_id)) {

            $district_id = $district_id->dst_code;
        } else {

            $district_id = "0";
        }

        if (isset($city_id)) {

            $city_id = $city_id->cty_id;
        } else {

            $city_id = "0";
        }

        if (isset($state_id)) {

            $state_id = $state_id->st_code;
        } else {

            $state_id = "0";
        }


        $inc_details_service = serialize($inc_details['service']);


        if ($inc_post_details['incient_state'] == '') {
            $inc_post_details['incient_state'] = "MP";
        }
        $date = str_replace('-', '', date('Y-m-d'));

        $inc_id = $this->session->userdata('inc_ref_id');

        $dispatch_time = $this->session->userdata('dispatch_time');

        $current_time = time();
        $res_time = $current_time - $dispatch_time;
        $h = ($res_time / (60 * 60)) % 24;
        $m = ($res_time / 60) % 60;
        $incidence_details = array('inc_cl_id' => $call_id,
            'inc_ref_id' => $inc_id,
            'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
            'inc_type' => $inc_details['inc_type'],
            'inc_ero_summary' => $inc_details['inc_ero_summary'],
            'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
            'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
            'inc_dispatch_time' => $inc_details['caller_dis_timer'],
            'inc_city_id' => $inc_post_details['incient_ms_city'],
            'inc_state_id' => $inc_post_details['incient_state'],
            'inc_address' => $inc_details['place'],
            'inc_tahshil_id' => $inc_post_details['incient_tahsil'],
            'inc_district_id' => $inc_post_details['incient_district'],
            'inc_area' => $inc_details['area'],
            'inc_landmark' => $inc_details['landmark'],
            'inc_lane' => $inc_details['lane'],
            'inc_h_no' => $inc_details['h_no'],
            'inc_pincode' => $inc_details['pincode'],
            'inc_lat' => $inc_details['lat'],
            'inc_long' => $inc_details['lng'],
            'inc_datetime' => $datetime,
            'inc_service' => $inc_details_service,
            'inc_duplicate' => $dup_inc,
            'inc_base_month' => $this->post['base_month'],
            'inc_set_amb' => '1',
            'inc_suggested_amb' => $inc_details['inc_suggested_amb'],
            'inc_recive_time' => $inc_details['inc_recive_time'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_system_type' => $system
        );


        if ($inc_details['cluster_name'] != '') {
            $incidence_details['inc_cluster_id'] = $inc_details['cluster_name'];
        }
        if ($inc_details['chief_complete_other'] != '') {
            $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
        }

        if ($inc_details['police_chief_complete'] != '') {
            $incidence_details['police_chief_complete'] = $inc_details['police_chief_complete'];
        }
        if ($inc_details['police_chief_complete_other'] != '') {
            $incidence_details['police_chief_complete_other'] = $inc_details['police_chief_complete_other'];
        }
        if ($inc_details['fire_chief_complete'] != '') {
            $incidence_details['fire_chief_complete'] = $inc_details['fire_chief_complete'];
        }
        if ($inc_details['fire_chief_complete_other'] != '') {
            $incidence_details['fire_chief_complete_other'] = $inc_details['fire_chief_complete_other'];
        }
                
         if($cl_type == 'transfer_108'){
             
            $incidence_details['inc_set_amb'] = '0';
            $incidence_details['incis_deleted'] = '0';
             
         }else if($cl_type == 'transfer_102'){
            $incidence_details['inc_set_amb'] = '0';
            $incidence_details['incis_deleted'] = '0';
             
         }else if($cl_type == 'terminate'){
             $incidence_details['inc_set_amb'] = '1';
             $incidence_details['incis_deleted'] = '2';
             
         }else{
               $incidence_details['inc_set_amb'] = '1';
               $incidence_details['incis_deleted'] = '0';
               $incidence_details['inc_system_type'] = $system;
               
                	
         }


        if ($inc_details['amb_id'] == '' && $dup_inc == 'Yes') {

            $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";

            return;
        }

        $sr_user = $this->clg->clg_ref_id;

        $patient = $this->input->get_post('patient');

        $patient = $this->session->userdata('patient');

        $EMT = "";

        $pilot = '';



        foreach ($inc_details['amb_id'] as $select_amb) {
            $inc_details['amb_id'] = $select_amb;
        }

        $tm_team_date = date('Y-m-d');

        $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id, $tm_team_date);
//        var_dump($emp_inc_data);
        if ($emp_inc_data) {
            $pilot = $emp_inc_data[0]->tm_pilot_id;
            $EMT = $emp_inc_data[0]->tm_emt_id;
        }

//        if ($EMT == '' && $pilot == '') {
//            $this->output->message = "<div class='error'>Please Assign Pilot and EMT to Ambulance OR Select another ambulance</div>";
//            return;
//        }


        $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
        if ($inc_details['chief_complete_other'] != '') {
            $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
        }
        $inc_data = $this->inc_model->insert_inc($incidence_details);

       


        update_inc_ref_id($inc_id);


        $sr_user = $this->clg->clg_ref_id;

        if ($dup_inc == 'No') {
            
   


            if ($inc_details['service'][1] == '1') {
                  

                $ercp_user = $this->inc_model->get_fire_user($sr_user, 'UG-ERCP');
                

                $ecrp_operator2 = array(
                    'sub_id' => $inc_id,
                    'operator_id' => $ercp_user->clg_ref_id,
                    'operator_type' => 'UG-ERCP',
                    'sub_status' => 'ASG',
                    'sub_type' => $inc_details['inc_type'],
                    'base_month' => $this->post['base_month']
                );

             

                if ($ercp_user) {
                    $ercp_operator = $this->common_model->assign_operator($ecrp_operator2);
                }
            }

            if ($inc_details['service'][2] == '2') {

                $police_user = $this->inc_model->get_fire_user($sr_user, 'UG-PDA');

                $police_operator2 = array(
                    'sub_id' => $inc_id,
                    'operator_id' => $police_user->clg_ref_id,
                    'operator_type' => 'UG-PDA',
                    'sub_status' => 'ASG',
                    'sub_type' => $inc_details['inc_type'],
                    'base_month' => $this->post['base_month']
                );


                if ($police_user) {
                    $police_operator = $this->common_model->assign_operator($police_operator2);
                }
            }



            if ($inc_details['service'][3] == '3') {

                $fire_user = $this->inc_model->get_fire_user($sr_user, 'UG-FDA');



                $fire_operator = array(
                    'sub_id' => $inc_id,
                    'operator_id' => $fire_user->clg_ref_id,
                    'operator_type' => 'UG-FDA',
                    'sub_status' => 'ASG',
                    'sub_type' => $inc_details['inc_type'],
                    'base_month' => $this->post['base_month']
                );

                if ($fire_user) {
                    $fire_operator = $this->common_model->assign_operator($fire_operator);
                }
            }



            if ($pilot != '') {

                $args_operator1 = array(
                    'sub_id' => $inc_id,
                    'operator_id' => $pilot,
                    'operator_type' => 'UG-PILOT',
                    'sub_status' => 'ASG',
                    'sub_type' => $inc_details['inc_type'],
                    'base_month' => $this->post['base_month']
                );
                $args_operator1 = $this->common_model->assign_operator($args_operator1);
            }

            if ($EMT != '') {
                $args_operator2 = array(
                    'sub_id' => $inc_id,
                    'operator_id' => $EMT,
                    'operator_type' => 'UG-EMT',
                    'sub_status' => 'ASG',
                    'sub_type' => $inc_details['inc_type'],
                    'base_month' => $this->post['base_month']
                );
                $args_operator2 = $this->common_model->assign_operator($args_operator2);
            }

            $incidence_amb_details = array('amb_rto_register_no' => $inc_details['amb_id'],
                'inc_ref_id' => $inc_id,
                'amb_pilot_id' => $pilot,
                'amb_emt_id' => $EMT,
                'inc_base_month' => $this->post['base_month'],
                'assigned_time' => $datetime);

            $this->inc_model->insert_inc_amb($incidence_amb_details);



            $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);

            $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
        }

        if (!empty($patient)) {
            if ($patient['first_name'] != '') {

                $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
                $last_pat_id = $last_insert_pat_id[0]->p_id + 1;

                $incidence_patient_details = array('ptn_fname' => $patient['first_name'],
                    'ptn_mname' => $patient['middle_name'],
                    'ptn_lname' => $patient['last_name'],
                    'ptn_gender' => $patient['gender'],
                    'ptn_fullname' => $patient['first_name'] . ' ' . $patient['middle_name'] . ' ' . $patient['last_name'],
                    'ptn_age' => $patient['age'],
                    'ptn_birth_date' => $patient['dob'],
                    'ptn_id' => $last_pat_id
                );

                $patient_full_name = $patient['first_name'] . ' ' . $patient['middle_name'] . ' ' . $patient['last_name'];
                //$patient_full_name = $patient['full_name'];
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
            }
        } else {
            $patient_full_name = $caller_details['clr_fullname'];
        }


        $args = array(
            'sub_id' => $inc_id,
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'sub_status' => 'ASG',
            'sub_type' => $inc_details['inc_type'],
            'base_month' => $this->post['base_month']
        );

        $res = $this->common_model->assign_operator($args);



        $ques_ans = $inc_details['ques'];

        if (isset($ques_ans)) {
            foreach ($ques_ans as $key => $ques) {

                $ems_summary = array('sum_base_month' => $this->post['base_month'],
                    'sum_sub_id' => $inc_id,
                    'sum_sub_type' => $inc_details['inc_type'],
                    'sum_que_id' => $key,
                    'sum_que_ans' => $ques
                );

                $this->inc_model->insert_ems_summary($ems_summary);
            }
        }

        /* send sms to patient */

        $sms_amb = $inc_details['amb_id'];

        $get_mobile_no = array('rg_no' => $sms_amb);

        $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);


        $driver = $this->colleagues_model->get_user_info($pilot);

        $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;

        $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;


        $inc_id = $inc_id;

        $amb_url = base_url() . "amb/loc/" . $inc_id;
        $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_id;

        //$amb_url = "http://210.212.165.123/tdd/amb/loc/" . $inc_id;
        //$amb_dir_url = "http://210.212.165.123/tdd/amb/amb_dir/" . $inc_id;

        $patient_name = $caller_details['clr_fname'];



        $doctor = $this->colleagues_model->get_user_info($EMT);

        $sms_doctor = $doctor[0]->clg_first_name;

        $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;

        //$patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];

        $patient_mobile_no = $caller_details['clr_mobile'];
        // $patient_mobile_no = "9730015484";
        $inc_address = $inc_details['place'];

        $patient_sms_text = "BVG,\n Ambulance dispatched: $sms_amb\n Ambulance Contact - $sms_doctor_contact_no\n Track Link- $amb_url\nMEMS";

        $patient_sms_to = $caller_details['clr_mobile'];
        // $patient_sms_to =  "8551995260";
        $send_ptn_sms = $this->_send_sms($patient_sms_to, $patient_sms_text, $lang = "english");


        $asSMSReponse = explode("-", $send_ptn_sms);
        $res_sms = array('inc_ref_id' => $inc_id,
            'sms_usertype' => 'Caller',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);

        $this->inc_model->insert_sms_response($res_sms);



        /* send sms to doctor  */
        $patient_name = $caller_details['clr_fname'];
        if ($get_driver_no[0]->amb_user_type == 'tdd') {

            $doctor_sms_text = "BVG,\nPatient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id, Patient id:$last_pat_id, Navigate- $amb_url MEMS";
        } else if ($get_driver_no[0]->amb_user_type = 'bike') {

            $doctor_sms_text = "BVG,\nPatient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call Bike Desk for Case ID creation. MEMS";
        } else {

            $doctor_sms_text = "BVG,\nPatient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call 108 ERC for Case ID creation.  MEMS";
        }

        $doctor_sms_to = $sms_doctor_contact_no;
        // $doctor_sms_to = '8551995260';
        $send_dr_sms = $this->_send_sms($doctor_sms_to, $doctor_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_id,
            'sms_usertype' => 'EMT',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);


        /* send sms to Pilot  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];
        $driver_sms_text = "BVG,\nDear Pilot, Patient name: $patient_full_name,  Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id  Navigate- $amb_dir_url MEMS";
        $driver_contact_no = $sms_driver_contact_no;
        //$driver_contact_no = "8551995260";
        //$send_dri_sms = $this->_send_sms($driver_contact_no, $driver_sms_text, $lang = "english");





        if ($call_type['cl_type'] == 'forword') {

            $super_user = $this->inc_model->get_user_by_group('UG-SUPP-CH');

            $args = array(
                'sub_id' => $inc_id,
                'operator_id' => $super_user->clg_ref_id,
                'operator_type' => $super_user->clg_group,
                'base_month' => $this->post['base_month'],
                'sub_type' => $inc_details['inc_type']
            );



            $forword_res = $this->common_model->assign_operator($args);
        }
        if ($call_type['cl_type'] == 'transfer_108') {

            _ucd_assign_call($inc_id);
        }
        
        if ($call_type['cl_type'] == 'transfer_102') {

            _ucd_102_assign_call($inc_id,$this->clg->clg_group);
        }


        $this->output->status = 1;



        $this->output->closepopup = "yes";



        ($call_type['cl_type'] == 'forword') ? $msg = "forworded" : $msg = "Added";



        $this->output->message = "<h3>Non-MCI Call</h3><br><p>Ambulance Dispatch Successfully</p><script>window.location.reload(true);</script>";



        $this->output->moveto = 'top';



        $this->output->add_to_position('', 'content', TRUE);
    }

    function get_inc_ambu() {
        $lng_data = $this->input->get();

        $data = array();
       

        $data['user_group'] = $this->clg->clg_group;


        $data['inc_type'] = $lng_data['inc_type'];
        
        $data['ambu_data1']=array();
        
        $data['ambu_data2']=array();
  

        if($lng_data['inc_ref_id'] != ''){
            $args =array('inc_ref_id'=>trim($lng_data['inc_ref_id']));
             $data['ambu_data1'] = $this->inc_model->get_inc_ambulance($args);
           
            
              
             
             
            $origins = array();
            if ($data['ambu_data1']) {
                foreach ($data['ambu_data1'] as $key => $search_amb) {
                    $origins[] = trim($search_amb->amb_lat) . ',' . trim($search_amb->amb_log);
                }
            }

            $destination = $lng_data['lat'] . ',' . $lng_data['lng'];
            if ($data['ambu_data1']) {
                $origins_str = trim(implode('|', $origins));

                //$google_api_key = 'AIzaSyBtAZEUryIBFm-pAoQXya4TnjxrwyUIUWI';
                $google_api_key = $this->google_api_key;



                $google_map_url = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $origins_str . '&destinations=' . $destination . '&region=in&key=' . $google_api_key;

                $location_data = file_get_contents($google_map_url);
                //$location_resp =  $this->_send_curl_request($google_map_url,'','get');
                $location_data = json_decode($location_data);


                $ambu_data = array();

                if (!empty($location_data->origin_addresses)) {
                      
                    foreach ($location_data->origin_addresses as $key => $amb_row) {

                        $duration_value = $location_data->rows[$key]->elements[0]->duration->value;
                        if($duration_value == ''){
                            $duration_value = $key;
                        }
                        

                        $ambu_data[$duration_value] = $data['ambu_data1'][$key];
                        $ambu_data[$duration_value]->assign = $data['ambu_data1'][$key]->inc_amb_type;

                        $ambu_data[$duration_value]->duration = $location_data->rows[$key]->elements[0]->duration->text;

                        $ambu_data[$duration_value]->duration_value = $location_data->rows[$key]->elements[0]->duration->value;

                        $ambu_data[$duration_value]->road_distance = $location_data->rows[$key]->elements[0]->distance->text;

                        $ambu_data[$duration_value]->road_distance_value = $location_data->rows[$key]->elements[0]->distance->value;
                    }

                    ksort($ambu_data);
                  
                    $data['ambu_data1'] = $ambu_data;
                    
                    
                }
            }
            
        }
       

        $data['ambu_data2']=array();
        if ($lng_data['lat'] != '' && $lng_data['lng'] != '') {


            $data['ambu_data2'] = $this->inc_model->get_am_in_inc_area($lng_data['lat'], $lng_data['lng'], $lng_data['amb_tp'], $lng_data['min_distance'], $lng_data['inc_status'], $lng_data['district_id']);


            $origins = array();
            if ($data['ambu_data2']) {
                foreach ($data['ambu_data2'] as $key => $search_amb) {
                    $origins[] = trim($search_amb->amb_lat) . ',' . trim($search_amb->amb_log);
                }
            }

            $destination = $lng_data['lat'] . ',' . $lng_data['lng'];
            if ($data['ambu_data2']) {
                $origins_str = trim(implode('|', $origins));

                //$google_api_key = 'AIzaSyBtAZEUryIBFm-pAoQXya4TnjxrwyUIUWI';
                $google_api_key = $this->google_api_key;



                $google_map_url = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $origins_str . '&destinations=' . $destination . '&region=in&key=' . $google_api_key;
             

                $location_data = file_get_contents($google_map_url);
                //$location_resp =  $this->_send_curl_request($google_map_url,'','get');
                $location_data = json_decode($location_data);


                $ambu_data = array();

                if ($location_data) {
                    foreach ($location_data->origin_addresses as $key => $amb_row) {

                        $duration_value = $location_data->rows[$key]->elements[0]->duration->value;

                        $ambu_data[$duration_value] = $data['ambu_data2'][$key];
                        $ambu_data[$duration_value]->assign = 'no';

                        $ambu_data[$duration_value]->duration = $location_data->rows[$key]->elements[0]->duration->text;

                        $ambu_data[$duration_value]->duration_value = $location_data->rows[$key]->elements[0]->duration->value;

                        $ambu_data[$duration_value]->road_distance = $location_data->rows[$key]->elements[0]->distance->text;

                        $ambu_data[$duration_value]->road_distance_value = $location_data->rows[$key]->elements[0]->distance->value;
                    }

                    ksort($ambu_data);


                    $data['ambu_data2'] = $ambu_data;
                }
            }
            
        } else {
            // $amb_user_type = 'tdd';
            $data['ambu_data2'] = $this->inc_model->get_am_in_inc_area('', '', $lng_data['amb_tp'], '', $lng_data['inc_status'], $lng_data['district_id']);
            
        }
        if(!empty($data['ambu_data2'])){
            $data['ambu_data'] = array_merge($data['ambu_data1'],$data['ambu_data2']);
        }
        

        $this->output->add_to_position($this->load->view('frontend/inc/inc_ambu_list_view', $data, TRUE), 'inc_map_details', TRUE);
    }

    public function get_mci_nature_service() {



        $ntr_id = $this->input->get_post('ntr_id', TRUE);

        $data['mci_nature_services'] = $this->inc_model->get_mci_nature_service($ntr_id);

        $data['cmp_service'] = $this->common_model->get_services();



        $this->output->add_to_position($this->load->view('frontend/inc/mci_service_view', $data, TRUE), 'inc_services_details', TRUE);
        
        $data['amb_type_list'] = $this->amb_model->get_amb_type();
       
      //  if ($cm_id == 52) {
            $data['ambu_type_data'] = array(3, 4);
      //  }
	  if ($cm_id == 59) {
            $data['ambu_type_data'] = array(3, 4);
        }

        $data['get_reference_ambu_type'] = array();

        $this->output->add_to_position($this->load->view('frontend/inc/inc_recomended_ambu_view', $data, TRUE), 'inc_recomended_ambu', TRUE);
    }

    public function get_chief_complete_service() {


        $cm_id = $this->input->get_post('cm_id', TRUE);

        $data['chief_comps_services'] = $this->inc_model->get_chief_comp_service($cm_id);

        $data['clg_group'] = $this->clg->clg_group;

        $data['cmp_service'] = $this->common_model->get_services();

        $data['questions'] = $this->call_model->get_questions($cm_id);

        $this->output->add_to_position($this->load->view('frontend/inc/service_view', $data, TRUE), 'inc_services_details', TRUE);

        //var_dump($data['chief_comps_services'][0]->ct_type);
        // if (strstr($data['chief_comps_services'][0]->ct_type, "pregnancy")) { 
//if (strstr($data['chief_comps_services'][0]->ct_type, "pregnancy") || strstr($data['chief_comps_services'][0]->ct_type, "Pregnancy") || strstr($data['chief_comps_services'][0]->ct_type, "pregnant")) {
//
//        $this->output->add_to_position($this->load->view('frontend/inc/non_mci_patient_gender_view', $data, TRUE), 'non_mci_patient_gender', TRUE);
//}

        $data['amb_type_list'] = $this->amb_model->get_amb_type();
        if ($cm_id == 52) {
            $data['ambu_type_data'] = array(3, 4);
        }
        if ($cm_id == 59) {
            $data['ambu_type_data'] = array(3, 4);
        }

        $data['get_reference_ambu_type'] = array();

        $this->output->add_to_position($this->load->view('frontend/inc/inc_recomended_ambu_view', $data, TRUE), 'inc_recomended_ambu', TRUE);

        // }
    }

    function inc_age_calculator() {

        $ptn_dob = $this->input->get_post('ptn_dob', TRUE);
        $field_name = $this->input->get_post('ptn_field', TRUE);


        $birthDate = $ptn_dob;
        $today = date("Y-m-d");

        $dateA = new DateTime($today);
        $dateB = new DateTime($birthDate);

        $dateDiff = $dateA->diff($dateB);
        if ($dateDiff->y > 0) {
            $data['age'] .= "{$dateDiff->y} Y,";
        }
        if ($dateDiff->m > 0) {
            $data['age'] .= "{$dateDiff->m} M, and";
        }
        if ($dateDiff->d >= 0) {
            $data['age'] .= " {$dateDiff->d} Days";
        }
        $data['field_name'] = $field_name;
        //$data['age'] .= "{$dateDiff->y} Y, {$dateDiff->m} M and {$dateDiff->d} D";
        $this->output->add_to_position($this->load->view('frontend/inc/ptn_age_view', $data, TRUE), 'ptn_age_outer', TRUE);
    }

    public function get_ambu_type() {



        $inc_ques_details = $this->input->get_post('incient');

        $ques_ans = $inc_ques_details['ques'];

        $ct_id = $inc_ques_details['chief_complete'];
        $amb_type = $this->input->post('amb_type');

        $ques_result = array();

        foreach ($ques_ans as $key => $ques) {

            $ques_result[] = $key . ":" . $ques;
        }

        $amb_ans = implode(',', $ques_result);



        $ambu_type_ques = $this->call_model->get_cm_ambu_type($ct_id, $amb_ans);

        $data['ambu_type'] = $this->call_model->get_cm_ambu_type($ct_id, $amb_ans);

        $rec_ambu_type = $data['ambu_type']->ambu_type;
        $data['rec_ambu_type'] = $rec_ambu_type;

        if (!empty($amb_type)) {

            if (!in_array($rec_ambu_type, $amb_type)) {

                array_push($amb_type, $rec_ambu_type);
            }
            $data['ambu_type_data'] = $amb_type;
        } else {
            $data['ambu_type_data'][] = $data['ambu_type']->ambu_type;
        }

        $data['amb_type_list'] = $this->amb_model->get_amb_type();


        $data_amb_level = $this->amb_model->get_amb_type_level_by_id($data['ambu_type_data'][0]);
        $data['amb_level'] = $data_amb_level[0]->ambu_level;


        $this->output->add_to_position($this->load->view('frontend/inc/ambu_type_view', $data, TRUE), 'inc_ambu_type_details', TRUE);

        $data['get_reference_ambu_type'] = $this->call_model->get_reference_ambu_type($rec_ambu_type);
        //var_dump($data['get_reference_ambu_type']);
        $this->output->add_to_position($this->load->view('frontend/inc/inc_recomended_ambu_view', $data, TRUE), 'inc_recomended_ambu', TRUE);
    }

    public function get_facility_details() {

        $data = array();

        $get_data = $this->input->get();

        $hp_id = $this->input->get_post('hp_id', TRUE);

        $data['hospital'] = $this->hp_model->get_hp_data1(array('hp_id' => $hp_id));

        if ($get_data['facility'] == 'new') {

            $this->session->set_userdata('new_hospital', $data['hospital']);

            $this->output->add_to_position($this->load->view('frontend/in_hos/facility_details_view', $data, TRUE), 'new_facility_details', TRUE);
        } else {

            $this->session->set_userdata('hospital', $data['hospital']);
            $this->output->add_to_position($this->load->view('frontend/in_hos/facility_details_view', $data, TRUE), 'facility_details', TRUE);
        }
    }

    public function save_inter() {

        $call_type = $this->input->get();
        $inter_hos = $this->input->get_post('inter');
        $call_id = $this->input->get_post('call_id');
        $inter_hos = $this->session->userdata('inter');
        $inter_hos_details = $this->session->userdata('inter_post_details');
        $post_data = $this->input->post();
        $patient = $this->session->userdata('patient');


        /// $call_type = $this->session->userdata('call_type');

        $call_id = $this->session->userdata('call_id');
        $caller_details = $this->session->userdata('caller_details');
        $datetime = date('Y-m-d H:i:s');

        $sft_id = '';

        if($this->clg->clg_group == 'UG-ERO-102'){
            $system = '102';
        }else{
            $system = '108';
        }
        
        $shift_time = explode(":", date('H:i:s'));

        if ($shift_time[0] >= 0 && $shift_time[0] <= 6) {

            $sft_id = 3;
        }if ($shift_time[0] >= 6 && $shift_time[0] <= 16) {

            $sft_id = 1;
        }if ($shift_time[0] >= 16 && $shift_time[0] <= 23) {

            $sft_id = 2;
        }

        $EMT = "";
        $pilot = '';

        $inc_details = $this->input->get_post('incient');
        $inc_details = $this->session->userdata('incient');






        $state_id = $this->inc_model->get_state_id($inter_hos['state']);
        $district_id = $this->inc_model->get_district_id($inter_hos['inc_district'], $state_id->st_code);
        $city_id = $this->inc_model->get_city_id($inter_hos['inc_city'], $district_id->dst_code, $state_id->st_code);

        if (isset($district_id)) {

            $district_id = $district_id->dst_code;
        } else {

            $district_id = "0";
        }

        if (isset($city_id)) {

            $city_id = $city_id->cty_id;
        } else {

            $city_id = "0";
        }

        if (isset($state_id)) {

            $state_id = $state_id->st_code;
        } else {

            $state_id = "0";
        }

        $inc_id = $this->session->userdata('inc_ref_id');

        $call_type_terminate = $this->input->post('call_type');
        $amb_count = 0;
        foreach ($inc_details['amb_id'] as $select_amb) {
            $amb_count++;
            $inter_hos['amb_id'] = $select_amb;

            $tm_team_date = date('Y-m-d');
            $emp_inc_data = $this->inc_model->get_amb_default_emp($inter_hos['amb_id'], $sft_id, $tm_team_date);


            if ($emp_inc_data) {

                $pilot = $emp_inc_data[0]->tm_pilot_id;
                $EMT = $emp_inc_data[0]->tm_emt_id;
            }

            if (isset($patient['condition'])) {
                $condition = $patient['condition'];
            } else {
                $condition = "";
            }


            $inc_re_id = $inc_id . '-' . $amb_count;
            $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_patient_cnt' => $inter_hos['inc_patient_cnt'],
                'inc_complaint' => $inter_hos['chief_complete'],
                'inc_type' => 'IN_HO_P_TR',
                'inc_ero_summary' => $inter_hos['inc_ero_summary'],
                'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
                'inc_ero_standard_summary' => $inter_hos['inc_ero_standard_summary'],
                'inc_city_id' => $inter_hos_details['incient_ms_city'],
                'inc_state_id' => $inter_hos_details['incient_state'],
                'inc_address' => $inc_details['place'],
                'inc_district_id' => $inter_hos_details['incient_district'],
                'inc_area' => $inter_hos['area'],
                'inc_landmark' => $inter_hos['landmark'],
                'inc_lane' => $inter_hos['lane'],
                'inc_h_no' => $inter_hos['h_no'],
                'inc_pincode' => $inter_hos['pincode'],
                'inc_lat' => $inter_hos['lat'],
                'inc_long' => $inter_hos['lng'],
                'inc_datetime' => $datetime,
                'inc_dispatch_time' => $inter_hos['caller_dis_timer'],
                'inc_base_month' => $this->post['base_month'],
                'ptn_condition' => $condition,
                'inc_set_amb' => '1',
                'inc_recive_time' => $inter_hos['inc_recive_time'],
                'inc_added_by' => $this->clg->clg_ref_id,
                'inc_system_type' => $system
            );

            if ($call_type_terminate == 'terminate') {
                $incidence_details['incis_deleted'] = '2';
            }
            if ($inter_hos_details['chief_complete_other'] != '') {
                $incidence_details['inc_complaint_other'] = $inter_hos_details['chief_complete_other'];
            }
            if ($post_data['termination_reason'] != '') {
                $incidence_details['termination_reason'] = $post_data['termination_reason'];
            }
            if ($post_data['termination_reason_other'] != '') {
                $incidence_details['termination_reason_other'] = $post_data['termination_reason_other'];
            }


            $inc_data = $this->inc_model->insert_inc($incidence_details);

            //$inc_data = $this->inc_model->insert_inter_call($inter_details);

            $incidence_details = array(
                'inc_ref_id' => $inc_re_id,
                'current_district' => $inter_hos['current_district'],
                'facility' => $inter_hos['facility'],
                'rpt_doc' => $inter_hos['rpt_doc'],
                'mo_no' => $inter_hos['mo_no'],
                'new_district' => $inter_hos['new_district'],
                'new_facility' => $inter_hos['new_facility'],
                'new_rpt_doc' => $inter_hos['new_rpt_doc'],
                'new_mo_no' => $inter_hos['new_mo_no'],
            );

            $this->inc_model->insert_inc_facility($incidence_details);

            $incidence_amb_details = array('amb_rto_register_no' => $inter_hos['amb_id'],
                'inc_ref_id' => $inc_re_id,
                'amb_pilot_id' => $pilot,
                'amb_type'=> 'standby',
                'amb_emt_id' => $EMT,
                'inc_base_month' => $inter_hos['base_month'],
                'assigned_time' => $datetime);

            $this->inc_model->insert_inc_amb($incidence_amb_details);


            if ($pilot != '') {

                $args_operator1 = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $pilot,
                    'operator_type' => 'PILOT',
                    'sub_type' => 'IN_HO_P_TR',
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args_operator1);
            }

            if ($EMT != '') {

                $args_operator2 = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $EMT,
                    'operator_type' => 'EMT',
                    'sub_type' => 'IN_HO_P_TR',
                    'base_month' => $this->post['base_month']
                );
                $res2 = $this->common_model->assign_operator($args_operator2);
            }

            $patient = $this->input->get_post('patient');

            $patient = $this->session->userdata('patient');
            if (!empty($patient)) {
                if (($patient['middle_name'] != '') || ($patient['first_name'] != '') || ($patient['last_name'] != '')) {


                    $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
                    $last_pat_id = $last_insert_pat_id[0]->p_id + 1;

                    $inter_patient_details = array('ptn_fname' => $patient['first_name'],
                        'ptn_mname' => $patient['middle_name'],
                        'ptn_lname' => $patient['last_name'],
                        'ptn_gender' => $patient['gender'],
                        'ptn_age' => $patient['age'],
                        'ptn_birth_date' => $patient['dob'],
                        //'ptn_type'   => '3'
                        'ptn_condition' => $condition,
                        'ptn_id' => $last_pat_id
                    );

                    $patient_full_name = $patient['first_name'] . ' ' . $patient['middle_name'] . ' ' . $patient['last_name'];

                    $pat_details = $this->pet_model->insert_patient_details($inter_patient_details);
                    $incidence_patient = array('inc_id' => $inc_re_id,
                        'ptn_id' => $last_pat_id);

                    $this->pet_model->insert_inc_pat($incidence_patient);
                }
            } else {
                $patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];
            }



            $args_operator = array(
                'sub_id' => $inc_re_id,
                'operator_id' => $this->clg->clg_ref_id,
                'operator_type' => $this->clg->clg_group,
                'sub_type' => 'IN_HO_P_TR',
                'base_month' => $this->post['base_month']
            );
            $res = $this->common_model->assign_operator($args_operator);



            // $inc_details = $this->input->get_post('incient');  

            $ques_ans = $inc_details['ques'];



            foreach ($ques_ans as $key => $ques) {

                $ems_summary = array('sum_base_month' => $inter_hos['base_month'],
                    'sum_sub_id' => $inc_re_id,
                    'sum_sub_type' => 'IN_HO_P_TR',
                    'sum_que_id' => $key,
                    'sum_que_ans' => $ques
                );

                $this->inc_model->insert_ems_summary($ems_summary);
            }

            if ($call_type['cl_type'] == 'forword') {

                $super_user = $this->inc_model->get_user_by_group('UG-SUPP-CH');
                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $super_user->clg_ref_id,
                    'operator_type' => $super_user->clg_group,
                    'base_month' => $this->post['base_month'],
                    'sub_type' => 'IN_HO_P_TR'
                );

                $forword_res = $this->common_model->assign_operator($args);
            }

            $upadate_amb_data = array('amb_rto_register_no' => $inter_hos['amb_id'], 'amb_status' => 2);

            $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
        }


        update_inc_ref_id($inc_id);

        /* send sms to patient  */

        $sms_amb = $inter_hos['amb_id'];

        $get_mobile_no = array('rg_no' => $sms_amb);
        $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);

        $driver = $this->colleagues_model->get_user_info($pilot);

        $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;

        $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;

//        $inc_id =$inc_id;

        $amb_url = base_url() . "amb/loc/" . $inc_id;

        $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_id;

        //$amb_url = "http://210.212.165.123/tdd/amb/loc/" . $inc_id;
        //$amb_dir_url = "http://210.212.165.123/tdd/amb/amb_dir/" . $inc_id;


        $doctor = $this->colleagues_model->get_user_info($EMT);

        $sms_doctor = $doctor[0]->clg_first_name;

        $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;

        //$patient_full_name = $patient['first_name'] . ' ' . $patient['middle_name'] . ' ' . $patient['last_name'];

        $patient_mobile_no = $caller_details['clr_mobile'];
        // $patient_mobile_no = "9730015484";
        $patient_name = $patient['first_name'];

        // echo $patient_sms_text;
        $patient_sms_text = "BVG,\n Ambulance dispatched: $sms_amb\n Ambulance Contact - $sms_doctor_contact_no\n Track Link- $amb_url\nMEMS";



        $patient_sms_to = $caller_details['clr_mobile'];
        //$patient_sms_to = "8551995260";
        $send_ptn_sms = $this->_send_sms($patient_sms_to, $patient_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_ptn_sms);
        $res_sms = array('inc_ref_id' => $inc_id,
            'sms_usertype' => 'Caller',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);



        /* send sms to doctor  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];

        if ($get_driver_no[0]->amb_user_type == 'tdd') {

            $doctor_sms_text = "BVG,\nPatient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id, Patient id:$last_pat_id, Navigate- $amb_url MEMS";
        } else if ($get_driver_no[0]->amb_user_type = 'bike') {

            $doctor_sms_text = "BVG,\nPatient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call Bike Desk for Case ID creation. MEMS";
        } else {

            $doctor_sms_text = "BVG,\nPatient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call 108 ERC for Case ID creation.  MEMS";
        }

        $doctor_sms_to = $sms_doctor_contact_no;
        // $doctor_sms_to = '8551995260';
        $send_dr_sms = $this->_send_sms($doctor_sms_to, $doctor_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_id,
            'sms_usertype' => 'EMT',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);

        /* send sms to Pilot  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];
        $driver_sms_text = "BVG,\nDear Pilot, Patient name: $patient_full_name,  Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id  Navigate- $amb_dir_url MEMS";
        $driver_contact_no = $sms_driver_contact_no;
        //$driver_contact_no = '8551995260';
        //$send_dri_sms = $this->_send_sms($driver_contact_no, $driver_sms_text, $lang = "english");


        $this->output->status = 1;
        $this->output->closepopup = "yes";

        ( $call_type['cl_type'] == 'forword') ? $msg = "forworded" : $msg = "Added";
        if ($call_type_terminate == 'terminate'){
            $msg = "Terminate";
        }
        if ($call_type_terminate == 'transfer_108') {

            _ucd_assign_call($inc_id);
        }
        
        if ($call_type_terminate == 'transfer_102') {

            _ucd_102_assign_call($inc_id,$this->clg->clg_group);
        }

        
        $this->output->message = "<h3>Inter Hospital transfer Call</h3><br><p>Ambulance $msg Successfully</p><script>  window.location.reload(true);</script>";


        $this->output->moveto = 'top';

        $this->output->add_to_position('', 'content', TRUE);
    }

    function change_view() {

        $inc_details = $this->input->get_post('incient');
        $call_type = $this->input->get_post('call_type');

        $caller_relation = $this->session->userdata('caller_relation');

        $caller_details = $this->session->userdata('caller_details');

        $data['purpose_of_calls'] = $this->call_model->get_purpose_of_calls();

        if ($this->agent->is_mobile()) {
            $data['agent_mobile'] = 'yes';
        } else {
            $data['agent_mobile'] = 'no';
        }

        if ($caller_relation == 6) {

            $data['caller_details_data'] = $caller_details;
        }

        $data['focus_input'] = '';



        $data['services'] = $this->common_model->get_services();


        if ((trim($inc_details[inc_patient_cnt]) > 5)) {


            $data['questions'] = $this->call_model->get_questions('inter');
            $data['int_count'] = $inc_details[inc_patient_cnt];



            $call_data = array(
                'cl_purpose' => 'MCI',
            );



            $data['call_id'] = $caller_details['cl_id'];
            $data['cl_purpose'] = 'MCI';



            $upadate_call_id = $this->call_model->update_call_details($call_data, $caller_details['cl_id']);


            if (($call_type == 'NON_MCI')) {
                $this->output->add_to_position($this->load->view('frontend/inc/mci_view', $data, TRUE), 'content', TRUE);
                $this->output->add_to_position($this->load->view('frontend/calls/calller_details_purpose_call', $data, TRUE), 'purpose_of_calls', TRUE);
            }

            $this->output->set_focus_to = "chief_complete";
        } else {

            $call_data = array(
                'cl_purpose' => 'NON_MCI',
            );
            $data['cl_purpose'] = 'NON_MCI';
            $upadate_call_id = $this->call_model->update_call_details($call_data, $caller_details['cl_id']);

            $data['call_id'] = $caller_details['cl_id'];

            $data['int_count'] = $inc_details[inc_patient_cnt];

            if (($call_type == 'MCI')) {
                $this->output->add_to_position($this->load->view('frontend/inc/non_mci_view', $data, TRUE), 'content', TRUE);
                $this->output->add_to_position($this->load->view('frontend/calls/calller_details_purpose_call', $data, TRUE), 'purpose_of_calls', TRUE);
            }

            $this->output->set_focus_to = "chief_complete";
        }
    }

    function confirm_mci_save() {

        $this->session->unset_userdata('mic_details');
        $this->session->unset_userdata('call_type');
        $this->session->unset_userdata('patient');
        $this->session->unset_userdata('call_id');

        $call_type = $this->input->get();
        $inc_post_details = $this->input->post();
        $patient = $this->input->get_post('patient');

        $inc_details = $this->input->get_post('incient');


        $call_id = $this->input->get_post('call_id');

        $this->session->set_userdata('mic_details', $inc_details);
        $this->session->set_userdata('call_type', $call_type);
        $this->session->set_userdata('call_id', $call_id);
        $this->session->set_userdata('inc_post_details', $inc_post_details);
        $this->session->set_userdata('patient', $patient);

        $dup_inc = $inc_details['dup_inc'];

        $inc_id = $this->session->userdata('inc_ref_id');

        if ($inc_id == '') {
            $inc_id = generate_inc_ref_id();
            $this->session->set_userdata('inc_ref_id', $inc_id);
        }



        $data['inc_ref_id'] = $inc_id;
        $data['inc_details'] = $inc_details;

        $data['nature'] = $this->inc_model->get_mci_nature_service($inc_details['mci_nature']);

        $data['police_chief'] = $this->call_model->get_police_chief_comp(array('po_ct_id' => $inc_details['police_chief_complete']));
        $data['fire_chief'] = $this->call_model->get_fire_chief_comp(array('fi_ct_id' => $inc_details['fire_chief_complete']));

        $data['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inc_details['inc_ero_standard_summary']));

        if ($inc_details['amb_id'] == '' && $dup_inc == 'No') {

            //$this->output->message = "<p class='error'>Please select Ambulance in Map</p>";

            $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";

            return;
        }



        if ($inc_details["amb_id"]) {

            foreach ($inc_details["amb_id"] as $amb) {

                $args = array(
                    'rg_no' => $amb,
                );
                $get_amb_details[] = $this->inc_model->get_amb_details($args);
            }

            $data['get_amb_details'] = $get_amb_details;
        }


        if ($inc_details['stand_amb_id']) {

            foreach ($inc_details["stand_amb_id"] as $amb) {

                $args = array(
                    'rg_no' => $amb,
                );
                $stand_amb_id[] = $this->inc_model->get_amb_details($args);
            }

            $data['stand_amb_id'] = $stand_amb_id;
        }

        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];

        $data['place'] = $inc_details['place'];

        $data['cl_type'] = $call_type;

        $this->output->add_to_popup($this->load->view('frontend/inc/confirm_mci_view', $data, TRUE), '600', '600');
    }

    function confirm_non_mci_save() {

        $this->session->unset_userdata('mic_details');
        $this->session->unset_userdata('call_type');

        $call_type = $this->input->get();
        $inc_post_details = $this->input->post();
       

        $inc_details = $this->input->get_post('incient');
        $patient = $this->input->get_post('patient');
        $caller_details = $this->input->get_post('caller');
        $call_type = $this->input->get_post('call_type');
        //$data['cl_type'] = $call_type;
        


        $dup_inc = $inc_details['dup_inc'];

        $call_id = $this->input->get_post('call_id');
        $this->session->set_userdata('mic_details', $inc_details);
        $this->session->set_userdata('call_type', $call_type);
        $this->session->set_userdata('call_id', $call_id);
        $this->session->set_userdata('patient', $patient);



        $session_caller_details = $this->session->userdata('caller_details');


        $this->session->set_userdata('inc_post_details', $inc_post_details);
        // var_dump( $this->input->get_post('caller'));
        // die();

        $data['police_chief'] = $this->call_model->get_police_chief_comp(array('po_ct_id' => $inc_details['police_chief_complete']));
        $data['fire_chief'] = $this->call_model->get_fire_chief_comp(array('fi_ct_id' => $inc_details['fire_chief_complete']));

        $data['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inc_details['inc_ero_standard_summary']));




        $data['nature'] = $this->inc_model->get_chief_comp_service($inc_details['chief_complete']);

        if ($inc_details['amb_id'] == '' && $dup_inc == 'No') {

            $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";

            return;
        }

        if ($inc_details["amb_id"]) {

            foreach ($inc_details["amb_id"] as $amb) {

                $args = array(
                    'rg_no' => $amb,
                );



                $get_amb_details[] = $this->inc_model->get_amb_details($args);
            }
        }
        $this->session->unset_userdata('inc_ref_id');
        $inc_id = $this->session->userdata('inc_ref_id');

        // var_dump($inc_id);
        if ($inc_id == '') {
            $inc_id = generate_inc_ref_id();
            $this->session->set_userdata('inc_ref_id', $inc_id);
        }
        //var_dump($inc_id);
        //  die();

        $data['inc_ref_id'] = $inc_id;
        $data['patient'] = $patient;

        $data['get_amb_details'] = $get_amb_details;
        $data['inc_details'] = $inc_details;


        $data['caller_details'] = $session_caller_details;
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];

        $data['place'] = $inc_details['place'];

        $data['cl_type'] = $call_type;

        $this->output->add_to_popup($this->load->view('frontend/inc/confirm_non_mci_view', $data, TRUE), '600', '560');

        //   $this->output->add_to_position($this->load->view('frontend/patient/pt_inc_summary_view', $data, TRUE), 'summary_div', TRUE);
    }

    function confirm_mci_terminate() {

        $this->session->unset_userdata('mic_details');
        $this->session->unset_userdata('call_type');

        $call_type = $this->input->get();
        $inc_post_details = $this->input->post();

        $inc_details = $this->input->get_post('incient');
        $patient = $this->input->get_post('patient');


        $call_id = $this->input->get_post('call_id');

        $inc_id = $this->session->userdata('inc_ref_id');
        if ($inc_id == '') {
            $inc_id = generate_inc_ref_id();
            $this->session->set_userdata('inc_ref_id', $inc_id);
        }
        $data['inc_ref_id'] = $inc_id;


        $this->session->set_userdata('mic_details', $inc_details);
        $this->session->set_userdata('call_type', $call_type);
        $this->session->set_userdata('call_id', $call_id);
        $this->session->set_userdata('inc_post_details', $inc_post_details);
        $this->session->set_userdata('patient', $patient);


        $dup_inc = $inc_details['dup_inc'];

        $data['inc_details'] = $inc_details;

        $data['nature'] = $this->inc_model->get_mci_nature_service($inc_details['mci_nature']);

        $data['police_chief'] = $this->call_model->get_police_chief_comp(array('po_ct_id' => $inc_details['police_chief_complete']));
        $data['fire_chief'] = $this->call_model->get_fire_chief_comp(array('fi_ct_id' => $inc_details['fire_chief_complete']));

        $data['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inc_details['inc_ero_standard_summary']));
//
//        if ($inc_details['amb_id'] == '' && $dup_inc == 'No') {
//
//            //$this->output->message = "<p class='error'>Please select Ambulance in Map</p>";
//
//            $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";
//
//            return;
//        }



        if ($inc_details["amb_id"]) {

            foreach ($inc_details["amb_id"] as $amb) {

                $args = array(
                    'rg_no' => $amb,
                );
                $get_amb_details[] = $this->inc_model->get_amb_details($args);
            }

            $data['get_amb_details'] = $get_amb_details;
        }


        if ($inc_details['stand_amb_id']) {

            foreach ($inc_details["stand_amb_id"] as $amb) {

                $args = array(
                    'rg_no' => $amb,
                );
                $stand_amb_id[] = $this->inc_model->get_amb_details($args);
            }

            $data['stand_amb_id'] = $stand_amb_id;
        }

        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];
        $data['inc_details'] = $inc_details;

        $data['place'] = $inc_details['place'];

        $data['cl_type'] = $call_type;

        $this->output->add_to_popup($this->load->view('frontend/inc/terminate_mci_view', $data, TRUE), '600', '600');
    }

    function confirm_non_mci_terminate() {

        $this->session->unset_userdata('mic_details');
        $this->session->unset_userdata('call_type');

        $call_type = $this->input->get();
        $inc_post_details = $this->input->post();

        $inc_details = $this->input->get_post('incient');
        $patient = $this->input->get_post('patient');

        $dup_inc = $inc_details['dup_inc'];

        $inc_id = $this->session->userdata('inc_ref_id');
        if ($inc_id == '') {
            $inc_id = generate_inc_ref_id();
            $this->session->set_userdata('inc_ref_id', $inc_id);
        }

        $call_id = $this->input->get_post('call_id');
        $this->session->set_userdata('mic_details', $inc_details);
        $this->session->set_userdata('call_type', $call_type);
        $this->session->set_userdata('call_id', $call_id);
        $this->session->set_userdata('patient', $patient);

        $this->session->set_userdata('inc_post_details', $inc_post_details);

//        if ($inc_details['amb_id'] == '' && $dup_inc == 'No') {
//
//            //$this->output->message = "<p class='error'>Please select Ambulance in Map</p>";
//
//            $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";
//
//            return;
//        }



        $data['nature'] = $this->inc_model->get_chief_comp_service($inc_details['chief_complete']);


        if ($inc_details["amb_id"]) {

            foreach ($inc_details["amb_id"] as $amb) {

                $args = array(
                    'rg_no' => $amb,
                );



                $get_amb_details[] = $this->inc_model->get_amb_details($args);
            }
        }

        $data['patient'] = $patient;
        $data['get_amb_details'] = $get_amb_details;
        $data['inc_ref_id'] = $inc_id;
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];
        $data['place'] = $inc_details['place'];
        $data['cl_type'] = $call_type;
        $this->output->add_to_popup($this->load->view('frontend/inc/terminate_non_mci_view', $data, TRUE), '600', '560');

        //   $this->output->add_to_position($this->load->view('frontend/patient/pt_inc_summary_view', $data, TRUE), 'summary_div', TRUE);
    }

    function terminate_nonmci_inc() {

        $call_type = $this->input->get();
        $inc_details = $this->input->get_post('incient');
        $call_id = $this->input->get_post('call_id');
        $caller_details = $this->session->userdata('caller_details');
        $inc_details = $this->session->userdata('mic_details');
        $inc_post_details = $this->session->userdata('inc_post_details');
        $call_id = $this->session->userdata('call_id');
        $post_data = $this->input->post();
        $patient = $this->session->userdata('patient');

        $datetime = date('Y-m-d H:i:s');

         if($this->clg->clg_group == 'UG-ERO-102'){
            $system = '102';
        }else{
            $system = '108';
        }

        $inc_id = $this->session->userdata('inc_ref_id');
        $inc_details_service = serialize($inc_details['service']);
        $dup_inc = $inc_details['dup_inc'];

        if (is_array($inc_details['amb_id'])) {
            foreach ($inc_details['amb_id'] as $select_amb) {
                $inc_details['amb_id'] = $select_amb;
            }
        }
        $sft_id = get_cur_shift();

        $tm_team_date = date('Y-m-d');
        $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id, $tm_team_date);

        if ($emp_inc_data) {
            $pilot = $emp_inc_data[0]->tm_pilot_id;
            $EMT = $emp_inc_data[0]->tm_emt_id;
        }

//        if ($EMT == '' && $pilot == '') {
//            $this->output->message = "<div class='error'>Please Assign Pilot and EMT to Ambulance OR Select another ambulance</div>";
//            return;
//        }

        $incidence_details = array('inc_cl_id' => $call_id,
            'inc_ref_id' => $inc_id,
            'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
            'inc_type' => $inc_details['inc_type'],
            'inc_ero_summary' => $inc_details['inc_ero_summary'],
            'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
            'inc_dispatch_time' => $inc_details['caller_dis_timer'],
            'inc_city_id' => $inc_post_details['incient_ms_city'],
            'inc_state_id' => $inc_post_details['incient_state'],
            'inc_address' => $inc_details['place'],
            'inc_tahshil_id' => $inc_post_details['incient_tahsil'],
            'inc_district_id' => $inc_post_details['incient_district'],
            'inc_area' => $inc_details['area'],
            'inc_landmark' => $inc_details['landmark'],
            'inc_lane' => $inc_details['lane'],
            'inc_h_no' => $inc_details['h_no'],
            'inc_pincode' => $inc_details['pincode'],
            'inc_lat' => $inc_details['lat'],
            'inc_long' => $inc_details['lng'],
            'inc_datetime' => $datetime,
            'inc_service' => $inc_details_service,
            'inc_duplicate' => $dup_inc,
            'inc_base_month' => $this->post['base_month'],
            'inc_set_amb' => '1',
            'inc_suggested_amb' => $inc_details['inc_suggested_amb'],
            'inc_recive_time' => $inc_details['inc_recive_time'],
            'incis_deleted' => '2',
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_system_type' => $system
        );
        $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
        if ($inc_details['chief_complete_other'] != '') {
            $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
        }
        if ($inc_details['cluster_name'] != '') {
            $incidence_details['inc_cluster_id'] = $inc_details['cluster_name'];
        }
        if ($inc_details['police_chief_complete'] != '') {
            $incidence_details['police_chief_complete'] = $inc_details['police_chief_complete'];
        }
        if ($inc_details['police_chief_complete_other'] != '') {
            $incidence_details['police_chief_complete_other'] = $inc_details['police_chief_complete_other'];
        }
        if ($inc_details['fire_chief_complete'] != '') {
            $incidence_details['fire_chief_complete'] = $inc_details['fire_chief_complete'];
        }
        if ($inc_details['fire_chief_complete_other'] != '') {
            $incidence_details['fire_chief_complete_other'] = $inc_details['fire_chief_complete_other'];
        }
        if ($post_data['termination_reason'] != '') {
            $incidence_details['termination_reason'] = $post_data['termination_reason'];
        }
        if ($post_data['termination_reason_other'] != '') {
            $incidence_details['termination_reason_other'] = $post_data['termination_reason_other'];
        }

        $inc_data = $this->inc_model->insert_inc($incidence_details);
        update_inc_ref_id($inc_id);

        $sr_user = $this->clg->clg_ref_id;

        if ($dup_inc == 'No') {



            if ($inc_details['service'][2] == 'on') {

                $police_user = $this->inc_model->get_fire_user($sr_user, 'UG-PDA');


                $police_operator2 = array(
                    'sub_id' => $inc_id,
                    'operator_id' => $police_user->clg_ref_id,
                    'operator_type' => 'UG-PDA',
                    'sub_status' => 'ASG',
                    'sub_type' => $inc_details['inc_type'],
                    'base_month' => $this->post['base_month']
                );


                if ($police_user) {
                    $police_operator = $this->common_model->assign_operator($police_operator2);
                }
            }

            if ($inc_details['service'][3] == 'on') {

                $fire_user = $this->inc_model->get_fire_user($sr_user, 'UG-FDA');
                if ($fire_user) {
                    $fire_operator = array(
                        'sub_id' => $inc_id,
                        'operator_id' => $fire_user->clg_ref_id,
                        'operator_type' => 'UG-FDA',
                        'sub_status' => 'ASG',
                        'sub_type' => $inc_details['inc_type'],
                        'base_month' => $this->post['base_month']
                    );


                    if ($fire_operator) {
                        $fire_operator = $this->common_model->assign_operator($fire_operator);
                        ;
                    }
                }
            }


            if ($pilot != '') {

                $args_operator1 = array(
                    'sub_id' => $inc_id,
                    'operator_id' => $pilot,
                    'operator_type' => 'UG-PILOT',
                    'sub_status' => 'ASG',
                    'sub_type' => $inc_details['inc_type'],
                    'base_month' => $this->post['base_month']
                );
                $args_operator1 = $this->common_model->assign_operator($args_operator1);
            }


            if ($EMT != '') {
                $args_operator2 = array(
                    'sub_id' => $inc_id,
                    'operator_id' => $EMT,
                    'operator_type' => 'UG-EMT',
                    'sub_status' => 'ASG',
                    'sub_type' => $inc_details['inc_type'],
                    'base_month' => $this->post['base_month']
                );
                $args_operator2 = $this->common_model->assign_operator($args_operator2);
            }




            if ($inc_details['amb_id']) {
                $incidence_amb_details = array('amb_rto_register_no' => $inc_details['amb_id'],
                    'inc_ref_id' => $inc_id,
                    'amb_pilot_id' => $pilot,
                    'amb_emt_id' => $EMT,
                    'inc_base_month' => $this->post['base_month'],
                    'assigned_time' => $datetime);

                $this->inc_model->insert_inc_amb($incidence_amb_details);



                $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);

                $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
            }
        }

        if (!empty($patient)) {
            if ($patient['first_name'] != '') {

                $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
                $last_pat_id = $last_insert_pat_id[0]->p_id + 1;

                $incidence_patient_details = array('ptn_fname' => $patient['first_name'],
                    'ptn_mname' => $patient['middle_name'],
                    'ptn_lname' => $patient['last_name'],
                    'ptn_gender' => $patient['gender'],
                    'ptn_fullname' => $patient['first_name'] . ' ' . $patient['middle_name'] . ' ' . $patient['last_name'],
                    'ptn_age' => $patient['age'],
                    'ptn_birth_date' => $patient['ptn_birth_date'],
                    'ptn_id' => $last_pat_id
                    //'ptn_type'   => '2' 
                );


                $patient_full_name = $patient['first_name'] . ' ' . $patient['middle_name'] . ' ' . $patient['last_name'];
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
            }
        } else {
            $patient_full_name = $caller_details['clr_fullname'];
        }


        $args = array(
            'sub_id' => $inc_id,
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'sub_status' => 'ASG',
            'sub_type' => $inc_details['inc_type'],
            'base_month' => $this->post['base_month']
        );
        $res = $this->common_model->assign_operator($args);

        $ques_ans = $inc_details['ques'];
        if (isset($ques_ans)) {
            foreach ($ques_ans as $key => $ques) {

                $ems_summary = array('sum_base_month' => $this->post['base_month'],
                    'sum_sub_id' => $inc_id,
                    'sum_sub_type' => $inc_details['inc_type'],
                    'sum_que_id' => $key,
                    'sum_que_ans' => $ques
                );

                $this->inc_model->insert_ems_summary($ems_summary);
            }
        }

        $this->output->status = 1;
        $this->output->closepopup = "yes";
        $msg = "Call terminated";
        $this->output->message = "<h3>Non-MCI Call</h3><br><p>Incident " . $msg . " successfull.</p><script>window.location.reload(true);</script>";
        $this->output->moveto = 'top';
        $this->output->add_to_position('', 'content', TRUE);
    }

    function terminate_mci_inc() {

        $call_type = $this->input->get();
        $inc_details = $this->input->get_post('incient');
        $call_id = $this->input->get_post('call_id');
        $caller_details = $this->session->userdata('caller_details');
        $inc_details = $this->session->userdata('mic_details');
        $inc_post_details = $this->session->userdata('inc_post_details');
        $patient = $this->session->userdata('patient');
        $post_data = $this->input->post();

        $datetime = date('Y-m-d H:i:s');

        $sft_id = '';

        $shift_time = explode(":", date('H:i:s'));

        if ($shift_time[0] >= 0 && $shift_time[0] <= 6) {

            $sft_id = 3;
        }if ($shift_time[0] >= 6 && $shift_time[0] <= 16) {

            $sft_id = 1;
        }if ($shift_time[0] >= 16 && $shift_time[0] <= 23) {

            $sft_id = 2;
        }
         if($this->clg->clg_group == 'UG-ERO-102'){
            $system = '102';
        }else{
            $system = '108';
        }

        /// $call_type = $this->session->userdata('call_type');

        $call_id = $this->session->userdata('call_id');
        $dup_inc = $inc_details['dup_inc'];

        $district_id = "0";
        $city_id = "0";
        $state_id = "0";

        $state_id = $this->inc_model->get_state_id($inc_details['state']);
        $district_id = $this->inc_model->get_district_id($inc_details['inc_district'], $state_id->st_code);


        $city_id = $this->inc_model->get_city_id($inc_details['inc_city'], $district_id->dst_code, $state_id->st_code);

        if (isset($district_id)) {

            $district_id = $district_id->dst_code;
        } else {

            $district_id = "0";
        }

        if (isset($city_id)) {

            $city_id = $city_id->cty_id;
        } else {

            $city_id = "0";
        }

        if (isset($state_id)) {

            $state_id = $state_id->st_code;
        } else {

            $state_id = "0";
        }


        $inc_details_service = serialize($inc_details['service']);


        if ($inc_post_details['incient_state'] == '') {
            $inc_post_details['incient_state'] = "MP";
        }
        $date = str_replace('-', '', date('Y-m-d'));

        //$inc_id = $date.$call_id;
        $inc_id = $this->session->userdata('inc_ref_id');
        if ($inc_id == '') {
            $inc_id = generate_inc_ref_id();
            $this->session->set_userdata('inc_ref_id', $inc_id);
        }


        $incidence_details = array('inc_cl_id' => $call_id,
            'inc_ref_id' => $inc_id,
            'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
            'inc_type' => $inc_details['inc_type'],
            'inc_ero_summary' => $inc_details['inc_ero_summary'],
            'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
            'inc_dispatch_time' => $inc_details['caller_dis_timer'],
            // 'inc_city' => $inc_details['inc_city'],
            'inc_city_id' => $inc_post_details['incient_ms_city'],
            //'inc_state' => $inc_post_details['incient_state'],
            'inc_state_id' => $inc_post_details['incient_state'],
            'inc_address' => $inc_details['place'],
            //'inc_district' => $inc_post_details['incient_district'],
            'inc_district_id' => $inc_post_details['incient_district'],
            'inc_area' => $inc_details['area'],
            'inc_landmark' => $inc_details['landmark'],
            'inc_lane' => $inc_details['lane'],
            'inc_h_no' => $inc_details['h_no'],
            'inc_pincode' => $inc_details['pincode'],
            'inc_lat' => $inc_details['lat'],
            'inc_long' => $inc_details['lng'],
            'inc_datetime' => $datetime,
            'inc_service' => $inc_details_service,
            'inc_duplicate' => $dup_inc,
            'inc_base_month' => $this->post['base_month'],
            'inc_set_amb' => '1',
            'incis_deleted' => '2',
            'inc_recive_time' => $inc_details['inc_recive_time'],
            // 'inc_suggested_amb' => $inc_details['inc_suggested_amb'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_system_type' => $system
        );

        if ($inc_details['cluster_name'] != '') {
            $incidence_details['inc_cluster_id'] = $inc_details['cluster_name'];
        }
        if ($inc_details['chief_complete_other'] != '') {
            $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
        }
        if ($inc_details['police_chief_complete'] != '') {
            $incidence_details['police_chief_complete'] = $inc_details['police_chief_complete'];
        }
        if ($inc_details['police_chief_complete_other'] != '') {
            $incidence_details['police_chief_complete_other'] = $inc_details['police_chief_complete_other'];
        }
        if ($inc_details['fire_chief_complete'] != '') {
            $incidence_details['fire_chief_complete'] = $inc_details['fire_chief_complete'];
        }
        if ($inc_details['fire_chief_complete_other'] != '') {
            $incidence_details['fire_chief_complete_other'] = $inc_details['fire_chief_complete_other'];
        }
        if ($post_data['termination_reason'] != '') {
            $incidence_details['termination_reason'] = $post_data['termination_reason'];
        }
        if ($post_data['termination_reason_other'] != '') {
            $incidence_details['termination_reason_other'] = $post_data['termination_reason_other'];
        }

//        if ($inc_details['amb_id'] == '' && $dup_inc == 'Yes') {
//
//            $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";
//
//            return;
//        }

        $sr_user = $this->clg->clg_ref_id;



        if ($dup_inc == 'No') {

            if ($inc_details['service'][2] == 'on') {

                $police_user = $this->inc_model->get_fire_user($sr_user, 'UG-PDA');

                if (isset($police_user)) {

                    

                $police_operator2 = array(
                    'sub_id' => $inc_id,
                    'operator_id' => $police_user->clg_ref_id,
                    'operator_type' => 'UG-PDA',
                    'sub_status' => 'ASG',
                    'sub_type' => $inc_details['inc_type'],
                    'base_month' => $this->post['base_month']
                );



                $police_operator = $this->common_model->assign_operator($police_operator2);
                }
            }

            if ($inc_details['service'][3] == 'on') {

                $fire_user = $this->inc_model->get_fire_user($sr_user, 'UG-FDA');

                if (isset($fire_user)) {

                  

                $fire_operator = array(
                    'sub_id' => $inc_id,
                    'operator_id' => $fire_user->clg_ref_id,
                    'operator_type' => 'UG-FDA',
                    'sub_status' => 'ASG',
                    'sub_type' => $inc_details['inc_type'],
                    'base_month' => $this->post['base_month']
                );
                $fire_operator = $this->common_model->assign_operator($fire_operator);
                }
            }
        }

        $sms_amb_details = $inc_details['amb_id'];


        if ($dup_inc == 'No') {

            if ($inc_details['amb_id']) {
                foreach ($inc_details['amb_id'] as $select_amb) {
                    $inc_details['amb_id'] = $select_amb;
                    $EMT = "";
                    $pilot = '';
                    //$emp_inc_data = $this->inc_model->get_amb_default_emp(trim($inc_details['amb_id']), $sft_id);
//                    $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id);
//
//                    $pilot = $emp_inc_data[0]->tm_pilot_id;
//                    $EMT = $emp_inc_data[0]->tm_emt_id;

                    $emp_inc_data = $this->inc_model->get_amb_emp($inc_details['amb_id'], $sft_id);



                    if (empty($emp_inc_data)) {

                        $tm_team_date = date('Y-m-d');
                        $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id, $tm_team_date);

                        if (!empty($emp_inc_data)) {
                            $pilot = $emp_inc_data[0]->tm_pilot_id;

                            $EMT = $emp_inc_data[0]->tm_emt_id;
                        }
                    } else {



                        foreach ($emp_inc_data as $amb_emp) {

                            if ($amb_emp->scd_amb_team_member_type == 'EMT') {

                                $EMT = $amb_emp->scd_amb_team_member_id;
                            }

                            if ($amb_emp->scd_amb_team_member_type == 'Pilot') {

                                $pilot = $amb_emp->scd_amb_team_member_id;
                            }
                        }
                    }
                    $incidence_amb_details = array('amb_rto_register_no' => $inc_details['amb_id'],
                        'inc_ref_id' => $inc_id,
                        'amb_pilot_id' => $pilot,
                        'amb_emt_id' => $EMT,
                        'inc_base_month' => $this->post['base_month'],
                        'assigned_time' => $datetime);
                    $this->inc_model->insert_inc_amb($incidence_amb_details);

                    if ($pilot != '') {
                        $args_operator1 = array(
                            'sub_id' => $inc_id,
                            'operator_id' => $pilot,
                            'operator_type' => 'UG-PILOT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'MCI',
                            'base_month' => $this->post['base_month']
                        );
                        $args_operator1 = $this->common_model->assign_operator($args_operator1);
                    }

                    if ($EMT != '') {
                        $args_operator2 = array(
                            'sub_id' => $inc_id,
                            'operator_id' => $EMT,
                            'operator_type' => 'UG-EMT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'MCI',
                            'base_month' => $this->post['base_month']
                        );

                        $args_operator2 = $this->common_model->assign_operator($args_operator2);
                    }



                    $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);

                    $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
                }
            }

            if ($inc_details['stand_amb_id']) {

                foreach ($inc_details['stand_amb_id'] as $stand_amb_id) {



                    $inc_details['stand_amb_id'] = $stand_amb_id;

                    $EMT = "";
                    $pilot = '';
                    //$emp_inc_data = $this->inc_model->get_amb_default_emp(trim($inc_details['amb_id']), $sft_id);
//                    $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['stand_amb_id'], $sft_id);
//
//                    $pilot = $emp_inc_data[0]->tm_pilot_id;
//                    $EMT = $emp_inc_data[0]->tm_emt_id;

                    $emp_inc_data = $this->inc_model->get_amb_emp($inc_details['amb_id'], $sft_id);

                    if (empty($emp_inc_data)) {
                        $tm_team_date = date('Y-m-d');
                        $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id, $tm_team_date);

                        $pilot = $emp_inc_data[0]->tm_pilot_id;

                        $EMT = $emp_inc_data[0]->tm_emt_id;
                    } else {



                        foreach ($emp_inc_data as $amb_emp) {

                            if ($amb_emp->scd_amb_team_member_type == 'EMT') {

                                $EMT = $amb_emp->scd_amb_team_member_id;
                            }

                            if ($amb_emp->scd_amb_team_member_type == 'Pilot') {

                                $pilot = $amb_emp->scd_amb_team_member_id;
                            }
                        }
                    }

                    $incidence_amb_details = array('amb_rto_register_no' => $inc_details['stand_amb_id'],
                        'inc_ref_id' => $inc_id,
                        'amb_pilot_id' => $pilot,
                        'amb_emt_id' => $EMT,
                        'inc_base_month' => $this->post['base_month'],
                        'amb_type'=> 'standby',
                        'assigned_time' => $datetime);

                    $this->inc_model->insert_inc_amb($incidence_amb_details);

                    if ($pilot != '') {
                        $args_operator1 = array(
                            'sub_id' => $inc_id,
                            'operator_id' => $pilot,
                            'operator_type' => 'UG-PILOT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'MCI',
                            'base_month' => $this->post['base_month']
                        );
                        $args_operator1 = $this->common_model->assign_operator($args_operator1);
                    }

                    if ($EMT != '') {
                        $args_operator2 = array(
                            'sub_id' => $inc_id,
                            'operator_id' => $EMT,
                            'operator_type' => 'UG-EMT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'MCI',
                            'base_month' => $this->post['base_month']
                        );
                        $args_operator2 = $this->common_model->assign_operator($args_operator2);
                    }
                }
            }
        }


        $incidence_details['inc_mci_nature'] = $inc_details['mci_nature'];

        $inc_data = $this->inc_model->insert_inc($incidence_details);
        update_inc_ref_id($inc_id);

        $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
        $last_pat_id = $last_insert_pat_id[0]->p_id + 1;

        $incidence_patient_details = array('ptn_fname' => $patient['first_name'],
            'ptn_mname' => $patient['middle_name'],
            'ptn_lname' => $patient['last_name'],
            'ptn_gender' => $patient['gender'],
            'ptn_fullname' => $patient['first_name'] . ' ' . $patient['middle_name'] . ' ' . $patient['last_name'],
            'ptn_age' => $patient['age'],
            'ptn_birth_date' => $patient['dob'],
            'ptn_id' => $last_pat_id
        );

        $patient_full_name = $patient['first_name'] . ' ' . $patient['middle_name'] . ' ' . $patient['last_name'];


        $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

        $incidence_patient = array('inc_id' => $inc_id,
            'ptn_id' => $last_pat_id);



        $this->pet_model->insert_inc_pat($incidence_patient);

        $args = array(
            'sub_id' => $inc_id,
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'sub_status' => 'ASG',
            'sub_type' => "MCI",
            'base_month' => $this->post['base_month']
        );

        $res = $this->common_model->assign_operator($args);


        /* send sms to patient  */
        $sms_amb = $inc_details['amb_id'];

        $get_mobile_no = array('rg_no' => $sms_amb);

        $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);

        $driver = $this->colleagues_model->get_user_info($pilot);

        $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;

        $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;

        //$inc_id = $inc_id;
        $amb_url = base_url() . "amb/loc/" . $inc_id;
        $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_id;

        //$amb_url = "http://210.212.165.123/tdd/amb/loc/" . $inc_id;
        // $amb_dir_url = "http://210.212.165.123/tdd/amb/amb_dir/" . $inc_id;



        $doctor = $this->colleagues_model->get_user_info($EMT);
        $sms_doctor = $doctor[0]->clg_first_name;
        $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;
        $patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];
        $patient_mobile_no = $caller_details['clr_mobile'];
        //$patient_mobile_no = "9730015484";
        $patient_name = $caller_details['clr_fname'];

        $patient_sms_text = "BVG,\n Ambulance dispatched: $sms_amb\n Ambulance Contact - $sms_doctor_contact_no\n Track Link- $amb_url\nMEMS";


        $patient_sms_to = $caller_details['clr_mobile'];
        //$patient_sms_to =  "8551995260";
        $send_dr_sms = $this->_send_sms($patient_sms_to, $patient_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_id,
            'sms_usertype' => 'Caller',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);



        /* send sms to doctor  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];

        if ($get_driver_no[0]->amb_user_type == 'tdd') {

            $doctor_sms_text = "BVG,\nPatient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id, Patient id:$last_pat_id, Navigate- $amb_url MEMS";
        } else if ($get_driver_no[0]->amb_user_type = 'bike') {

            $doctor_sms_text = "BVG,\nPatient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call Bike Desk for Case ID creation. MEMS";
        } else {

            $doctor_sms_text = "BVG,\nPatient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call 108 ERC for Case ID creation.  MEMS";
        }

        $doctor_sms_to = $sms_doctor_contact_no;
        // $doctor_sms_to = '8551995260';
        $send_dr_sms = $this->_send_sms($doctor_sms_to, $doctor_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_id,
            'sms_usertype' => 'EMT',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);

        /* send sms to Pilot  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];

        $driver_sms_text = "BVG,\nDear Pilot, Patient name: $patient_full_name,  Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id , Patient id:$last_pat_id  Navigate- $amb_dir_url MEMS";

        $driver_contact_no = $sms_driver_contact_no;
        //  $driver_contact_no = "8551995260";
        //$send_dri_sms = $this->_send_sms($driver_contact_no, $driver_sms_text, $lang = "english");

        if ($call_type['cl_type'] == 'forword') {

            $super_user = $this->inc_model->get_user_by_group('UG-SUPP-CH');


            $args = array(
                'sub_id' => $inc_id,
                'operator_id' => $super_user->clg_ref_id,
                'operator_type' => $super_user->clg_group,
                'base_month' => $this->post['base_month'],
                'sub_type' => $inc_details['inc_type']
            );


            $forword_res = $this->common_model->assign_operator($args);
        }

        $this->output->status = 1;
        $this->output->closepopup = "yes";
        ($call_type['cl_type'] == 'forword') ? $msg = "forworded" : $msg = "dispatch";
        $msg = "Terminated call";
        $this->output->message = "<h3>MCI Call</h3><br><p>Incident " . $msg . " successfull.</p><script> window.location.reload(true);</script>";
        $this->output->moveto = 'top';
        $this->output->add_to_position('', 'content', TRUE);
    }

    function confirm_inter_hos_save() {

        $this->session->unset_userdata('inter');
        $this->session->unset_userdata('call_type');
        $this->session->unset_userdata('patient');
        $this->session->unset_userdata('call_id');
        $this->session->unset_userdata('incient');

        $call_type = $this->input->get();

        $inter_details = $this->input->get_post('inter');
        $inter_post_details = $this->input->post();

        $data['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inter_details['inc_ero_standard_summary']));

        $inc_id = $this->session->userdata('inc_ref_id');
        if ($inc_id == '') {
            $inc_id = generate_inc_ref_id();
            $this->session->set_userdata('inc_ref_id', $inc_id);
        }
        $data['inc_ref_id'] = $inc_id;


        $incient_details = $this->input->get_post('incient');
        $patient = $this->input->get_post('patient');
        $call_id = $this->input->get_post('call_id');

        $this->session->set_userdata('inter', $inter_details);
        $this->session->set_userdata('incient', $incient_details);
        $this->session->set_userdata('call_type', $call_type);
        $this->session->set_userdata('call_id', $call_id);
        $this->session->set_userdata('patient', $patient);
        $this->session->set_userdata('inter_post_details', $inter_post_details);


        //$data['nature'] = $this->inc_model->get_chief_comp_service($inter_details['chief_complete']);

        if ($incient_details['amb_id'] == '') {

            $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";

            return;
        }



        if ($incient_details["amb_id"]) {

            foreach ($incient_details["amb_id"] as $amb) {

                $args = array(
                    'rg_no' => $amb,
                );

                $get_amb_details[] = $this->inc_model->get_amb_details($args);
            }
        }

        $data['patient'] = $patient;

        $data['get_amb_details'] = $get_amb_details;


        $data['nature'] = $this->inc_model->get_chief_comp_service($inter_details['chief_complete']);


        $data['new_facility'] = $this->session->userdata('new_hospital');
        $data['facility'] = $this->session->userdata('hospital');

        $data['inc_ero_summary'] = $inter_details['inc_ero_summary'];
        $data['inter_details'] = $inter_details;

        $data['place'] = $incient_details['place'];

        $data['cl_type'] = $call_type;
        $this->output->add_to_popup($this->load->view('frontend/in_hos/confirm_inter_hos_view', $data, TRUE), '600', '560');

        //   $this->output->add_to_position($this->load->view('frontend/patient/pt_inc_summary_view', $data, TRUE), 'summary_div', TRUE);
    }

    function confirm_inter_hos_terminate() {

        $this->session->unset_userdata('inter');
        $this->session->unset_userdata('call_type');
        $this->session->unset_userdata('patient');
        $this->session->unset_userdata('call_id');
        $this->session->unset_userdata('incient');

        $post_data = $this->input->post();

        $call_type = $this->input->get();



        $inter_details = $this->input->get_post('inter');
        $inter_post_details = $this->input->post();

        $incient_details = $this->input->get_post('incient');
        $patient = $this->input->get_post('patient');
        $call_id = $this->input->get_post('call_id');

        $data['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inter_details['inc_ero_standard_summary']));


        $inc_id = $this->session->userdata('inc_ref_id');
        if ($inc_id == '') {
            $inc_id = generate_inc_ref_id();
            $this->session->set_userdata('inc_ref_id', $inc_id);
        }
        $data['inc_ref_id'] = $inc_id;

        $this->session->set_userdata('inter', $inter_details);
        $this->session->set_userdata('incient', $incient_details);
        $this->session->set_userdata('call_type', $call_type);
        $this->session->set_userdata('call_id', $call_id);
        $this->session->set_userdata('patient', $patient);
        $this->session->set_userdata('inter_post_details', $inter_post_details);

        $data['new_facility'] = $this->session->userdata('new_hospital');
        $data['facility'] = $this->session->userdata('hospital');
        $data['inc_ero_summary'] = $inter_details['inc_ero_summary'];

        $data['nature'] = $this->inc_model->get_chief_comp_service($inter_details['chief_complete']);
        $data['inter_details'] = $inter_details;

        //$data['nature'] = $this->inc_model->get_chief_comp_service($inter_details['chief_complete']);
//        if ($incient_details['amb_id'] == '') {
//
//            $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";
//
//            return;
//        }



        if ($incient_details["amb_id"]) {

            foreach ($incient_details["amb_id"] as $amb) {

                $args = array(
                    'rg_no' => $amb,
                );



                $get_amb_details[] = $this->inc_model->get_amb_details($args);
            }
        }

        $data['patient'] = $patient;

        $data['get_amb_details'] = $get_amb_details;



        $data['inc_ero_summary'] = $inter_details['inc_ero_summary'];

        $data['place'] = $incient_details['place'];

        $data['cl_type'] = $call_type;
        $this->output->add_to_popup($this->load->view('frontend/in_hos/confirm_inter_hos_terminate', $data, TRUE), '600', '560');

        //   $this->output->add_to_position($this->load->view('frontend/patient/pt_inc_summary_view', $data, TRUE), 'summary_div', TRUE);
    }

    function previous_incident() {



        $cm_id = $this->input->post();
//         var_dump($cm_id);
        // $cm_id = $this->input->get_post('incient', TRUE);
        // var_dump($cm_id);
        //  die();



        if (isset($cm_id['mci_nature'])) {

            $nature_id = $cm_id['mci_nature'];

            $chief_complete = $this->inc_model->get_mci_nature_service($nature_id);

            $data['chief_complete'] = $chief_complete[0]->ntr_nature;
        }

        if (isset($cm_id['chief_complete'])) {

            $comp_id = $cm_id['chief_complete'];

            $chief_complete = $this->inc_model->get_chief_comp_service($comp_id);

            $data['chief_complete'] = $chief_complete[0]->ct_type;
        }

        $inc_type = $this->input->get_post('inc_type', TRUE);
        $data['inc_type'] = $this->input->get_post('inc_type');
        $distance = $this->input->get_post('inc_distance');



        if ($distance == '') {

            $distance = 10;
        }

        $args = array(
            'lat' => $lng_data['lat'],
            'lng' => $lng_data['lng'],
            'inc_type' => $inc_type,
            'distance' => $distance,
            'base_month' => $this->post['base_month']
        );

        if (!empty($comp_id)) {

            $args['comp_tp'] = $comp_id;
        }

        if (!empty($cm_id)) {

            $args['nature_id'] = $nature_id;
        }

        $data['inc_data'] = $this->inc_model->get_pre_inc_area($args);
        $this->output->add_to_position($this->load->view('frontend/inc/previous_incident_view', $data, TRUE), 'previous_incident_details', TRUE);
    }

    function test_amb() {
        $this->output->add_to_position($this->load->view('frontend/inc/amb_loc_view', $data, TRUE), 'previous_incident_details', TRUE);
    }

    function extend_map() {
        $this->output->add_to_position($this->load->view('frontend/inc/extended_map', $data, TRUE), 'content', TRUE);
        $this->output->template = "cell";
    }

    function confirm_vip_save() {

        $this->session->unset_userdata('mic_details');
        $this->session->unset_userdata('call_type');
        $this->session->unset_userdata('patient');
        $this->session->unset_userdata('call_id');

        $inc_post_details = $this->input->post();

        $inc_details = $this->input->get_post('incient');
        $patient = $this->input->get_post('patient');

        $caller_details = $this->input->get_post('caller');

        $call_type = $inc_post_details['call_type'];


        $dup_inc = $inc_details['dup_inc'];

        $call_id = $this->input->get_post('call_id');
        $this->session->set_userdata('mic_details', $inc_details);
        $this->session->set_userdata('call_type', $call_type);
        $this->session->set_userdata('call_id', $call_id);
        $this->session->set_userdata('patient', $patient);




        $session_caller_details = $this->session->userdata('caller_details');


        $this->session->set_userdata('inc_post_details', $inc_post_details);
        // var_dump( $this->input->get_post('caller'));
        // die();

        $data['police_chief'] = $this->call_model->get_police_chief_comp(array('po_ct_id' => $inc_details['police_chief_complete']));
        $data['fire_chief'] = $this->call_model->get_fire_chief_comp(array('fi_ct_id' => $inc_details['fire_chief_complete']));

        $data['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inc_details['inc_ero_standard_summary']));




        $data['nature'] = $this->inc_model->get_chief_comp_service($inc_details['chief_complete']);

        if ($inc_details['amb_id'] == '' && $dup_inc == 'No' && $call_type != 'terminate') {

            $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";

            return;
        }

        if ($inc_details["amb_id"]) {

            foreach ($inc_details["amb_id"] as $amb) {

                $args = array(
                    'rg_no' => $amb,
                );



                $get_amb_details[] = $this->inc_model->get_amb_details($args);
            }
        }

        $inc_id = $this->session->userdata('inc_ref_id');
        if ($inc_id == '') {
            $inc_id = generate_inc_ref_id();
            $this->session->set_userdata('inc_ref_id', $inc_id);
        }
        $data['inc_ref_id'] = $inc_id;
        $data['patient'] = $patient;

        $data['get_amb_details'] = $get_amb_details;
        $data['inc_details'] = $inc_details;


        $data['caller_details'] = $session_caller_details;
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];

        $data['place'] = $inc_details['place'];

        $data['cl_type'] = $call_type;

        $this->output->add_to_popup($this->load->view('frontend/inc/confirm_vip_view', $data, TRUE), '600', '450');
    }

    function save_vip() {

        $call_type = $this->input->get();
        $inc_details = $this->input->get_post('incient');
        $call_id = $this->input->get_post('call_id');
        $caller_details = $this->session->userdata('caller_details');
        $inc_details = $this->session->userdata('mic_details');
        $post_data = $this->input->post();


        $inc_post_details = $this->session->userdata('inc_post_details');


        if($this->clg->clg_group == 'UG-ERO-102'){
            $system = '102';
        }else{
            $system = '108';
        }


        $datetime = date('Y-m-d H:i:s');

        $sft_id = get_cur_shift();

        $call_id = $this->session->userdata('call_id');


        $dup_inc = $inc_details['dup_inc'];

        $district_id = "0";
        $city_id = "0";
        $state_id = "0";

        $state_id = $this->inc_model->get_state_id($inc_details['state']);
        $district_id = $this->inc_model->get_district_id($inc_details['inc_district'], $state_id->st_code);

        $city_id = $this->inc_model->get_city_id($inc_details['incient_ms_city'], $district_id->dst_code, $state_id->st_code);


        if (isset($district_id)) {

            $district_id = $district_id->dst_code;
        } else {

            $district_id = "0";
        }

        if (isset($city_id)) {

            $city_id = $city_id->cty_id;
        } else {

            $city_id = "0";
        }

        if (isset($state_id)) {

            $state_id = $state_id->st_code;
        } else {

            $state_id = "0";
        }


        $inc_details_service = serialize($inc_details['service']);


        if ($inc_post_details['incient_state'] == '') {
            $inc_post_details['incient_state'] = "MP";
        }
        $date = str_replace('-', '', date('Y-m-d'));

        $inc_id = $this->session->userdata('inc_ref_id');

        $dispatch_time = $this->session->userdata('dispatch_time');
        $call_type_terminate = $this->input->post('call_type');
        //var_dump($call_type_terminate);
        //die();

        $current_time = time();
        $res_time = $current_time - $dispatch_time;
        $h = ($res_time / (60 * 60)) % 24;
        $m = ($res_time / 60) % 60;
        $incidence_details = array('inc_cl_id' => $call_id,
            'inc_ref_id' => $inc_id,
            'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
            'inc_type' => $inc_details['inc_type'],
            'inc_ero_summary' => $inc_details['inc_ero_summary'],
            'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
            'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
            'inc_dispatch_time' => $inc_details['caller_dis_timer'],
            'inc_city_id' => $inc_post_details['incient_ms_city'],
            'inc_state_id' => $inc_post_details['incient_state'],
            'inc_address' => $inc_details['place'],
            'inc_tahshil_id' => $inc_post_details['incient_tahsil'],
            'inc_district_id' => $inc_post_details['incient_district'],
            'inc_area' => $inc_details['area'],
            'inc_landmark' => $inc_details['landmark'],
            'inc_lane' => $inc_details['lane'],
            'inc_h_no' => $inc_details['h_no'],
            'inc_pincode' => $inc_details['pincode'],
            'inc_lat' => $inc_details['lat'],
            'inc_long' => $inc_details['lng'],
            'inc_datetime' => $datetime,
            'inc_service' => $inc_details_service,
            'inc_duplicate' => $dup_inc,
            'inc_base_month' => $this->post['base_month'],
            'inc_set_amb' => '1',
            'inc_suggested_amb' => $inc_details['inc_suggested_amb'],
            'inc_recive_time' => $inc_details['inc_recive_time'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_system_type' => $system
        );
        if ($call_type_terminate == 'terminate') {
            $incidence_details['incis_deleted'] = '2';
        }

        if ($inc_details['cluster_name'] != '') {
            $incidence_details['inc_cluster_id'] = $inc_details['cluster_name'];
        }
        if ($inc_details['chief_complete_other'] != '') {
            $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
        }

        if ($inc_details['police_chief_complete'] != '') {
            $incidence_details['police_chief_complete'] = $inc_details['police_chief_complete'];
        }
        if ($inc_details['police_chief_complete_other'] != '') {
            $incidence_details['police_chief_complete_other'] = $inc_details['police_chief_complete_other'];
        }
        if ($inc_details['fire_chief_complete'] != '') {
            $incidence_details['fire_chief_complete'] = $inc_details['fire_chief_complete'];
        }
        if ($inc_details['fire_chief_complete_other'] != '') {
            $incidence_details['fire_chief_complete_other'] = $inc_details['fire_chief_complete_other'];
        }
        if ($post_data['termination_reason'] != '') {
            $incidence_details['termination_reason'] = $post_data['termination_reason'];
        }
        if ($post_data['termination_reason_other'] != '') {
            $incidence_details['termination_reason_other'] = $post_data['termination_reason_other'];
        }


        if ($inc_details['amb_id'] == '' && $dup_inc == 'Yes') {

            $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";

            return;
        }

        $sr_user = $this->clg->clg_ref_id;

        $patient = $this->input->get_post('patient');

        $patient = $this->session->userdata('patient');

        $EMT = "";

        $pilot = '';



        foreach ($inc_details['amb_id'] as $select_amb) {
            $inc_details['amb_id'] = $select_amb;
        }

        $tm_team_date = date('Y-m-d');

        $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id, $tm_team_date);
//        var_dump($emp_inc_data);
        if ($emp_inc_data) {
            $pilot = $emp_inc_data[0]->tm_pilot_id;
            $EMT = $emp_inc_data[0]->tm_emt_id;
        }

//        if ($EMT == '' && $pilot == '') {
//            $this->output->message = "<div class='error'>Please Assign Pilot and EMT to Ambulance OR Select another ambulance</div>";
//            return;
//        }


        $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
        if ($inc_details['chief_complete_other'] != '') {
            $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
        }

        $inc_data = $this->inc_model->insert_inc($incidence_details);
        update_inc_ref_id($inc_id);


        $sr_user = $this->clg->clg_ref_id;

        if ($dup_inc == 'No') {
            
            if ($inc_details['service'][1] == '1') {

                $ercp_user = $this->inc_model->get_fire_user($sr_user, 'UG-ERCP');

                $ecrp_operator2 = array(
                    'sub_id' => $inc_id,
                    'operator_id' => $ercp_user->clg_ref_id,
                    'operator_type' => 'UG-ERCP',
                    'sub_status' => 'ASG',
                    'sub_type' => $inc_details['inc_type'],
                    'base_month' => $this->post['base_month']
                );


                if ($ercp_user) {
                    $ercp_operator = $this->common_model->assign_operator($ecrp_operator2);
                }
            }



            if ($inc_details['service'][2] == '2') {

                $police_user = $this->inc_model->get_fire_user($sr_user, 'UG-PDA');

                $police_operator2 = array(
                    'sub_id' => $inc_id,
                    'operator_id' => $police_user->clg_ref_id,
                    'operator_type' => 'UG-PDA',
                    'sub_status' => 'ASG',
                    'sub_type' => $inc_details['inc_type'],
                    'base_month' => $this->post['base_month']
                );



                if($police_user){
                    $police_operator = $this->common_model->assign_operator($police_operator2);
                }
            }



            if ($inc_details['service'][3] == '3') {

                $fire_user = $this->inc_model->get_fire_user($sr_user, 'UG-FDA');



                $fire_operator = array(
                    'sub_id' => $inc_id,
                    'operator_id' => $fire_user->clg_ref_id,
                    'operator_type' => 'UG-FDA',
                    'sub_status' => 'ASG',
                    'sub_type' => $inc_details['inc_type'],
                    'base_month' => $this->post['base_month']
                );


                if($fire_user){
                    $fire_operator = $this->common_model->assign_operator($fire_operator);
                }
            }


            if ($pilot != '') {
                $args_operator1 = array(
                    'sub_id' => $inc_id,
                    'operator_id' => $pilot,
                    'operator_type' => 'UG-PILOT',
                    'sub_status' => 'ASG',
                    'sub_type' => $inc_details['inc_type'],
                    'base_month' => $this->post['base_month']
                );
                $args_operator1 = $this->common_model->assign_operator($args_operator1);
            }

            if ($EMT != '') {
                $args_operator2 = array(
                    'sub_id' => $inc_id,
                    'operator_id' => $EMT,
                    'operator_type' => 'UG-EMT',
                    'sub_status' => 'ASG',
                    'sub_type' => $inc_details['inc_type'],
                    'base_month' => $this->post['base_month']
                );
                $args_operator2 = $this->common_model->assign_operator($args_operator2);
            }

            if ($inc_details['amb_id']) {
                $incidence_amb_details = array('amb_rto_register_no' => $inc_details['amb_id'],
                    'inc_ref_id' => $inc_id,
                    'amb_pilot_id' => $pilot,
                    'amb_emt_id' => $EMT,
                    'inc_base_month' => $this->post['base_month'],
                    'assigned_time' => $datetime);



                $this->inc_model->insert_inc_amb($incidence_amb_details);



                $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);

                $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
            }
        }

        if (!empty($patient)) {
            if ($patient['first_name'] != '') {

                $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
                $last_pat_id = $last_insert_pat_id[0]->p_id + 1;

                $incidence_patient_details = array('ptn_fname' => $patient['first_name'],
                    'ptn_mname' => $patient['middle_name'],
                    'ptn_lname' => $patient['last_name'],
                    'ptn_gender' => $patient['gender'],
                    'ptn_fullname' => $patient['first_name'] . ' ' . $patient['middle_name'] . ' ' . $patient['last_name'],
                    'ptn_age' => $patient['age'],
                    'ptn_birth_date' => $patient['dob'],
                    'ptn_id' => $last_pat_id
                );

                $patient_full_name = $patient['first_name'] . ' ' . $patient['middle_name'] . ' ' . $patient['last_name'];
                //$patient_full_name = $patient['full_name'];
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
            }
        } else {
            $patient_full_name = $caller_details['clr_fullname'];
        }


        $args = array(
            'sub_id' => $inc_id,
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'sub_status' => 'ASG',
            'sub_type' => $inc_details['inc_type'],
            'base_month' => $this->post['base_month']
        );

        $res = $this->common_model->assign_operator($args);



        $ques_ans = $inc_details['ques'];

        if (isset($ques_ans)) {
            foreach ($ques_ans as $key => $ques) {

                $ems_summary = array('sum_base_month' => $this->post['base_month'],
                    'sum_sub_id' => $inc_id,
                    'sum_sub_type' => $inc_details['inc_type'],
                    'sum_que_id' => $key,
                    'sum_que_ans' => $ques
                );

                $this->inc_model->insert_ems_summary($ems_summary);
            }
        }

        /* send sms to patient */

        $sms_amb = $inc_details['amb_id'];

        $get_mobile_no = array('rg_no' => $sms_amb);

        $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);


        $driver = $this->colleagues_model->get_user_info($pilot);

        $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;

        $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;


        $inc_id = $inc_id;

        $amb_url = base_url() . "amb/loc/" . $inc_id;
        $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_id;

        //$amb_url = "http://210.212.165.123/tdd/amb/loc/" . $inc_id;
        //$amb_dir_url = "http://210.212.165.123/tdd/amb/amb_dir/" . $inc_id;

        $patient_name = $caller_details['clr_fname'];



        $doctor = $this->colleagues_model->get_user_info($EMT);

        $sms_doctor = $doctor[0]->clg_first_name;

        $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;

        //$patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];

        $patient_mobile_no = $caller_details['clr_mobile'];
        // $patient_mobile_no = "9730015484";
        $inc_address = $inc_details['place'];

        $patient_sms_text = "BVG,\n Ambulance dispatched: $sms_amb\n Ambulance Contact - $sms_doctor_contact_no\n Track Link- $amb_url\nMEMS";

        $patient_sms_to = $caller_details['clr_mobile'];
        // $patient_sms_to =  "8551995260";
        $send_ptn_sms = $this->_send_sms($patient_sms_to, $patient_sms_text, $lang = "english");


        $asSMSReponse = explode("-", $send_ptn_sms);
        $res_sms = array('inc_ref_id' => $inc_id,
            'sms_usertype' => 'Caller',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);

        $this->inc_model->insert_sms_response($res_sms);



        /* send sms to doctor  */
        $patient_name = $caller_details['clr_fname'];
        if ($get_driver_no[0]->amb_user_type == 'tdd') {

            $doctor_sms_text = "BVG,\nPatient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id, Patient id:$last_pat_id, Navigate- $amb_url MEMS";
        } else if ($get_driver_no[0]->amb_user_type = 'bike') {

            $doctor_sms_text = "BVG,\nPatient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call Bike Desk for Case ID creation. MEMS";
        } else {

            $doctor_sms_text = "BVG,\nPatient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call 108 ERC for Case ID creation.  MEMS";
        }

        $doctor_sms_to = $sms_doctor_contact_no;
        // $doctor_sms_to = '8551995260';
        $send_dr_sms = $this->_send_sms($doctor_sms_to, $doctor_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_id,
            'sms_usertype' => 'EMT',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);


        /* send sms to Pilot  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];
        $driver_sms_text = "BVG,\nDear Pilot, Patient name: $patient_full_name,  Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id  Navigate- $amb_dir_url MEMS";
        $driver_contact_no = $sms_driver_contact_no;
        //$driver_contact_no = "8551995260";
        //$send_dri_sms = $this->_send_sms($driver_contact_no, $driver_sms_text, $lang = "english");





        if ($call_type['cl_type'] == 'forword') {

            $super_user = $this->inc_model->get_user_by_group('UG-SUPP-CH');

            $args = array(
                'sub_id' => $inc_id,
                'operator_id' => $super_user->clg_ref_id,
                'operator_type' => $super_user->clg_group,
                'base_month' => $this->post['base_month'],
                'sub_type' => $inc_details['inc_type']
            );



            $forword_res = $this->common_model->assign_operator($args);
        }



        $this->output->status = 1;



        $this->output->closepopup = "yes";



        ($call_type['cl_type'] == 'forword') ? $msg = "forworded" : $msg = "Displatch";
        if ($call_type_terminate == 'terminate') {
            $msg = "Terminate";
        }



        $this->output->message = "<h3>VIP Call</h3><br><p>Ambulance $msg Successfully</p><script>window.location.reload(true);</script>";



        $this->output->moveto = 'top';



        $this->output->add_to_position('', 'content', TRUE);
    }

    function generating_load() {
        //die();
        $longitude = (float) -2.708077;
        $latitude = (float) 53.754842;
        $radius = 20; // in miles

        $datetime = date('Y-m-d H:i:s');

        $lng_min = $longitude - $radius / abs(cos(deg2rad($latitude)) * 69);
        $lng_max = $longitude + $radius / abs(cos(deg2rad($latitude)) * 69);
        $lat_min = $latitude - ($radius / 69);
        $lat_max = $latitude + ($radius / 69);

        $lng = $lng_min . '/' . $lng_max . PHP_EOL;
        $lat = $lat_min . '/' . $lat_max;


        $district_id = "1";
        $city_id = "0";
        $state_id = "MP";

        $cl_base_month = $this->post['base_month'] = '139';


        $randnum = rand(1111111111, 9999999999);

        $i = 1;
        $k = 1000;
        for ($i = 1; $i++; $i <= $k) {

            $ambulance = array('MH 12 QL 6419', 'MH 12 QL 6418', 'MH 12 QL 6423', 'MH 12 QL 6421');

            $inc_details['service'][1] = '1';
            $inc_details['service'][2] = '2';
            $inc_details['amb_id'] = $ambulance[array_rand($ambulance, 1)];
            $inc_details['amb_id'] = 'MH 12 QL 6419';

            $caller_data = array('clr_mobile' => $randnum,
                'clr_fname' => 'Unknown',
                'clr_mname' => 'Unknown',
                'clr_lname' => 'Unknown',
                'clr_fullname' => 'Unknown');
            $caller_id = $this->call_model->insert_caller_details($caller_data);

            $call_data = array('cl_base_month' => $cl_base_month,
                'cl_clr_id' => $caller_id,
                'clr_ralation' => '2',
                'cl_purpose' => '2',
                'cl_datetime' => $datetime);

            $call_id = $this->call_model->insert_call_details($call_data);


            $inc_details['inc_type'] = 'NON_MCI';
            $inc_re_id = generate_inc_ref_id();
            $call_type = $this->input->get();

            $inc_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_type' => $inc_details['inc_type'],
                'inc_ero_summary' => 'inc_ero_summary',
                'inc_ero_standard_summary' => '2',
                'inc_dispatch_time' => $datetime,
                // 'inc_city' => $inc_details['inc_city'],
                'inc_city_id' => $city_id,
                //'inc_state' => $inc_post_details['incient_state'],
                'inc_state_id' => $state_id,
                'inc_address' => 'shirur pune',
                //'inc_district' => $inc_post_details['incient_district'],
                'inc_district_id' => $district_id,
                'inc_area' => '',
                'inc_landmark' => '',
                'inc_lane' => '',
                'inc_h_no' => '',
                'inc_pincode' => '',
                'inc_lat' => $lat,
                'inc_long' => $lng,
                'inc_datetime' => $datetime,
                'inc_service' => $inc_details_service,
                'inc_duplicate' => 'NO',
                'inc_base_month' => $this->post['base_month'],
                'inc_set_amb' => '1',
                'inc_recive_time' => $datetime,
                'inc_patient_cnt' => '1',
                'inc_added_by' => 'ERO-1');


            $sft_id = '';

            $shift_time = explode(":", date('H:i:s'));

            if ($shift_time[0] >= 0 && $shift_time[0] <= 6) {

                $sft_id = 3;
            }if ($shift_time[0] >= 6 && $shift_time[0] <= 16) {

                $sft_id = 1;
            }if ($shift_time[0] >= 16 && $shift_time[0] <= 23) {

                $sft_id = 2;
            }

            /// $call_type = $this->session->userdata('call_type');
            // $call_id = $this->session->userdata('call_id');
            $dup_inc = 'No';


            $inc_details_service = serialize($inc_details['service']);



            $date = str_replace('-', '', date('Y-m-d'));

            //$inc_id = $date.$call_id;
            $inc_id = $this->session->userdata('inc_ref_id');




            $sr_user = 'ERO-1';

            $sms_amb_details = $inc_details['amb_id'];

            if ($inc_details['amb_id'] == '' && $dup_inc == 'Yes') {

                $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";
                return;
            }


            // $amb_count =0;
            // foreach ($inc_details['amb_id'] as $key=>$select_amb) {
            // $amb_count++;
            // $inc_re_id = $inc_id.'-'.$amb_count;


            $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_type' => $inc_details['inc_type'],
                'inc_ero_summary' => $inc_details['inc_ero_summary'],
                'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
                'inc_dispatch_time' => $inc_details['inc_dispatch_time'],
                // 'inc_city' => $inc_details['inc_city'],
                'inc_city_id' => $city_id,
                //'inc_state' => $inc_post_details['incient_state'],
                'inc_state_id' => 'MP',
                'inc_address' => 'shirur pune',
                //'inc_district' => $inc_post_details['incient_district'],
                'inc_district_id' => $district_id,
                'inc_area' => 'shirur pune',
                'inc_landmark' => '',
                'inc_lane' => '',
                'inc_h_no' => '',
                'inc_pincode' => '',
                'inc_lat' => $latitude,
                'inc_long' => $longitude,
                'inc_datetime' => $datetime,
                'inc_service' => $inc_details_service,
                'inc_duplicate' => $dup_inc,
                'inc_base_month' => $this->post['base_month'],
                'inc_set_amb' => '1',
                'inc_recive_time' => $inc_details['inc_recive_time'],
                'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
                'inc_added_by' => 'ERO-1'
            );


            if ($inc_details['cluster_name'] != '') {
                $incidence_details['inc_cluster_id'] = $inc_details['cluster_name'];
            }
            if ($inc_details['chief_complete_other'] != '') {
                $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
            }
            if ($inc_details['police_chief_complete'] != '') {
                $incidence_details['police_chief_complete'] = $inc_details['police_chief_complete'];
            }
            if ($inc_details['police_chief_complete_other'] != '') {
                $incidence_details['police_chief_complete_other'] = $inc_details['police_chief_complete_other'];
            }
            if ($inc_details['fire_chief_complete'] != '') {
                $incidence_details['fire_chief_complete'] = $inc_details['fire_chief_complete'];
            }
            if ($inc_details['fire_chief_complete_other'] != '') {
                $incidence_details['fire_chief_complete_other'] = $inc_details['fire_chief_complete_other'];
            }


            if ($inc_details['service'][1] == 'on' || $inc_details['service'][1] == '1') {

                $ercp_user = 'ERCP-1';


                if (isset($ercp_user)) {                  
                    $ercp_operator = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => 'ERCP-1',
                        'operator_type' => 'UG-ERCP',
                        'sub_status' => 'ASG',
                        'sub_type' => $inc_details['inc_type'],
                        'base_month' => $this->post['base_month']
                    );



                    $police_operator = $this->common_model->assign_operator($ercp_operator);
                }
            }

            if ($inc_details['service'][2] == '2') {

                $police_user = 'PDA-1';

                if (isset($police_user)) {
                  

                    $police_operator2 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => 'PDA-1',
                        'operator_type' => 'UG-PDA',
                        'sub_status' => 'ASG',
                        'sub_type' => $inc_details['inc_type'],
                        'base_month' => $this->post['base_month']
                    );
                    $police_operator = $this->common_model->assign_operator($police_operator2);
                }
            }

            if ($inc_details['service'][3] == '3') {

                $fire_user = 'FDA-1';

                if (isset($fire_user)) {

                    $this->output->message = "<div class='error'>No Fire team member under this ERO</div>";

                    return;
                }

                $fire_operator = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $fire_user,
                    'operator_type' => 'UG-FDA',
                    'sub_status' => 'ASG',
                    'sub_type' => $inc_details['inc_type'],
                    'base_month' => $this->post['base_month']
                );
                $fire_operator = $this->common_model->assign_operator($fire_operator);
            }


            $inc_details['amb_id'] = 'MH 12 QL 6419';
            $EMT = "";
            $pilot = '';

            $incidence_amb_details = array('amb_rto_register_no' => $inc_details['amb_id'],
                'inc_ref_id' => $inc_re_id,
                'amb_pilot_id' => $pilot,
                'amb_emt_id' => $EMT,
                'inc_base_month' => $this->post['base_month'],
                'assigned_time' => $datetime);
            $this->inc_model->insert_inc_amb($incidence_amb_details);

            if ($pilot != '') {
                $args_operator1 = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $pilot,
                    'operator_type' => 'UG-PILOT',
                    'sub_status' => 'ASG',
                    'sub_type' => 'MCI',
                    'base_month' => $this->post['base_month']
                );
                $args_operator1 = $this->common_model->assign_operator($args_operator1);
            }

            if ($EMT != '') {
                $args_operator2 = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $EMT,
                    'operator_type' => 'UG-EMT',
                    'sub_status' => 'ASG',
                    'sub_type' => 'MCI',
                    'base_month' => $this->post['base_month']
                );
                $args_operator2 = $this->common_model->assign_operator($args_operator2);
            }


            $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);

            $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);

            $incidence_details['inc_mci_nature'] = '3';

            $inc_data = $this->inc_model->insert_inc($incidence_details);


            $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
            $last_pat_id = $last_insert_pat_id[0]->p_id + 1;

            $incidence_patient_details = array(
                'ptn_fullname' => 'unknown',
                'ptn_fname' => 'unknown',
                'ptn_id' => $last_pat_id
            );

            $patient_full_name = $patient['full_name'];
            $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

            $incidence_patient = array('inc_id' => $inc_re_id,
                'ptn_id' => $last_pat_id);

            $this->pet_model->insert_inc_pat($incidence_patient);

            $args = array(
                'sub_id' => $inc_re_id,
                'operator_id' => 'ERO-1',
                'operator_type' => 'UG-ERO',
                'sub_status' => 'ASG',
                'sub_type' => "MCI",
                'base_month' => $this->post['base_month']
            );

            $res = $this->common_model->assign_operator($args);

            // }

            if ($inc_details['stand_amb_id']) {

                // foreach ($inc_details['stand_amb_id'] as $key=>$stand_amb_id) {


                $inc_re_id = $inc_id;
                $incidence_details = array('inc_cl_id' => $call_id,
                    'inc_ref_id' => $inc_re_id,
                    'inc_type' => $inc_details['inc_type'],
                    'inc_ero_summary' => $inc_details['inc_ero_summary'],
                    'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
                    'inc_dispatch_time' => $inc_details['caller_dis_timer'],
                    // 'inc_city' => $inc_details['inc_city'],
                    'inc_city_id' => $inc_post_details['incient_ms_city'],
                    //'inc_state' => $inc_post_details['incient_state'],
                    'inc_state_id' => $inc_post_details['incient_state'],
                    'inc_address' => $inc_details['place'],
                    //'inc_district' => $inc_post_details['incient_district'],
                    'inc_district_id' => $inc_post_details['incient_district'],
                    'inc_area' => $inc_details['area'],
                    'inc_landmark' => $inc_details['landmark'],
                    'inc_lane' => $inc_details['lane'],
                    'inc_h_no' => $inc_details['h_no'],
                    'inc_pincode' => $inc_details['pincode'],
                    'inc_lat' => $inc_details['lat'],
                    'inc_long' => $inc_details['lng'],
                    'inc_datetime' => $datetime,
                    'inc_service' => $inc_details_service,
                    'inc_duplicate' => $dup_inc,
                    'inc_base_month' => $this->post['base_month'],
                    'inc_set_amb' => '1',
                    'inc_recive_time' => $inc_details['inc_recive_time'],
                    'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
                    'inc_added_by' => 'ERO-1'
                );

                if ($inc_details['cluster_name'] != '') {
                    $incidence_details['inc_cluster_id'] = $inc_details['cluster_name'];
                }
                if ($inc_details['chief_complete_other'] != '') {
                    $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                }
                if ($inc_details['police_chief_complete'] != '') {
                    $incidence_details['police_chief_complete'] = $inc_details['police_chief_complete'];
                }
                if ($inc_details['police_chief_complete_other'] != '') {
                    $incidence_details['police_chief_complete_other'] = $inc_details['police_chief_complete_other'];
                }
                if ($inc_details['fire_chief_complete'] != '') {
                    $incidence_details['fire_chief_complete'] = $inc_details['fire_chief_complete'];
                }
                if ($inc_details['fire_chief_complete_other'] != '') {
                    $incidence_details['fire_chief_complete_other'] = $inc_details['fire_chief_complete_other'];
                }

                if ($inc_details['service'][1] == 'on' || $inc_details['service'][1] == '1') {

                    $ercp_user = $this->inc_model->get_fire_user($sr_user, 'UG-ERCP');


                    if (!isset($ercp_user)) {

                        $this->output->message = "<div class='error'>No ERCP team member under this ERO</div>";

                        return;
                    }

                    $ercp_operator = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $ercp_user->clg_ref_id,
                        'operator_type' => 'UG-ERCP',
                        'sub_status' => 'ASG',
                        'sub_type' => $inc_details['inc_type'],
                        'base_month' => $this->post['base_month']
                    );



                    $police_operator = $this->common_model->assign_operator($ercp_operator);
                }

                if ($inc_details['service'][2] == '2') {

                    $police_user = $this->inc_model->get_fire_user($sr_user, 'UG-PDA');

                    if (isset($police_user)) {

                        $police_operator2 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => 'PDA-1',
                            'operator_type' => 'UG-PDA',
                            'sub_status' => 'ASG',
                            'sub_type' => $inc_details['inc_type'],
                            'base_month' => $this->post['base_month']
                        );



                        $police_operator = $this->common_model->assign_operator($police_operator2);
                    }
                }

                if ($inc_details['service'][3] == '3') {

                    $fire_user = $this->inc_model->get_fire_user($sr_user, 'UG-FDA');

                    if (isset($fire_user)) {



                        $fire_operator = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => 'FDA-1',
                            'operator_type' => 'UG-FDA',
                            'sub_status' => 'ASG',
                            'sub_type' => $inc_details['inc_type'],
                            'base_month' => $this->post['base_month']
                        );
                        $fire_operator = $this->common_model->assign_operator($fire_operator);
                    }
                }



                $inc_details['stand_amb_id'] = $stand_amb_id;

                $EMT = "";
                $pilot = '';
                //$emp_inc_data = $this->inc_model->get_amb_default_emp(trim($inc_details['amb_id']), $sft_id);
                //                    $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['stand_amb_id'], $sft_id);
                //
                //                    $pilot = $emp_inc_data[0]->tm_pilot_id;
                //                    $EMT = $emp_inc_data[0]->tm_emt_id;

                $emp_inc_data = $this->inc_model->get_amb_emp($inc_details['amb_id'], $sft_id);

                if (empty($emp_inc_data)) {
                    $tm_team_date = date('Y-m-d');
                    $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id, $tm_team_date);

                    $pilot = $emp_inc_data[0]->tm_pilot_id;
                    $EMT = $emp_inc_data[0]->tm_emt_id;
                } else {



                    foreach ($emp_inc_data as $amb_emp) {

                        if ($amb_emp->scd_amb_team_member_type == 'EMT') {

                            $EMT = $amb_emp->scd_amb_team_member_id;
                        }

                        if ($amb_emp->scd_amb_team_member_type == 'Pilot') {

                            $pilot = $amb_emp->scd_amb_team_member_id;
                        }
                    }
                }

                $incidence_amb_details = array('amb_rto_register_no' => $inc_details['stand_amb_id'],
                    'inc_ref_id' => $inc_re_id,
                    'amb_pilot_id' => $pilot,
                    'amb_emt_id' => $EMT,
                    'inc_base_month' => $this->post['base_month'],
                    'amb_type'=> 'standby',
                    'assigned_time' => $datetime);

                $this->inc_model->insert_inc_amb($incidence_amb_details);

                if ($pilot != '') {

                    $args_operator1 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $pilot,
                        'operator_type' => 'UG-PILOT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'MCI',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator1 = $this->common_model->assign_operator($args_operator1);
                }

                if ($EMT != '') {
                    $args_operator2 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $EMT,
                        'operator_type' => 'UG-EMT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'MCI',
                        'base_month' => $this->post['base_month']
                    );

                    $args_operator2 = $this->common_model->assign_operator($args_operator2);
                }


                $incidence_details['inc_mci_nature'] = $inc_details['mci_nature'];

                $inc_data = $this->inc_model->insert_inc($incidence_details);


                $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
                $last_pat_id = $last_insert_pat_id[0]->p_id + 1;

                $incidence_patient_details = array(
                    'ptn_fullname' => 'unknown',
                    'ptn_fname' => 'unknown',
                    'ptn_id' => $last_pat_id
                );

                $patient_full_name = $patient['full_name'];
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);

                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => 'ERO-1',
                    'operator_type' => 'UG-ERO',
                    'sub_status' => 'ASG',
                    'sub_type' => "MCI",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                //}
            }


            update_inc_ref_id($inc_re_id);


            /* send sms to patient  */
            $sms_amb = $inc_details['amb_id'];
            $get_mobile_no = array('rg_no' => $sms_amb);
            $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);
            $driver = $this->colleagues_model->get_user_info($pilot);
            $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;
            $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;

            //$inc_id = $inc_id;
            $amb_url = base_url() . "amb/loc/" . $inc_id;
            $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_id;

            //$amb_url = "http://210.212.165.123/tdd/amb/loc/" . $inc_id;
            //$amb_dir_url = "http://210.212.165.123/tdd/amb/amb_dir/" . $inc_id;



            $doctor = $this->colleagues_model->get_user_info($EMT);
            $sms_doctor = $doctor[0]->clg_first_name;
            $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;
            $patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];
            $patient_mobile_no = $caller_details['clr_mobile'];
            //$patient_mobile_no = "9730015484";
            $patient_name = $caller_details['clr_fname'];


            $driver_contact_no = $sms_driver_contact_no;

            if ($call_type['cl_type'] == 'forword') {

                $super_user = $this->inc_model->get_user_by_group('UG-SUPP-CH');


                $args = array(
                    'sub_id' => $inc_id,
                    'operator_id' => $super_user->clg_ref_id,
                    'operator_type' => $super_user->clg_group,
                    'base_month' => $this->post['base_month'],
                    'sub_type' => $inc_details['inc_type']
                );


                $forword_res = $this->common_model->assign_operator($args);
            }
        }
        die();
    }

}
