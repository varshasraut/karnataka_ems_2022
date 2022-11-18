<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class INC extends EMS_Controller {

    function __construct() {

        parent::__construct();
        $this->active_module = "M-INC";
        $this->active_module = "M-VALID-USER";
        $this->pg_limit = $this->config->item('pagination_limit');
        $this->load->model(array('inc_model', 'get_city_state_model', 'options_model', 'module_model', 'amb_model', 'call_model', 'pet_model', 'hp_model', 'pcr_model', 'colleagues_model','Dashboard_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date','cct_helper', 'comman_helper'));
        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));
        $this->post = $this->input->get_post(NULL);
        $this->clg = $this->session->userdata('current_user');
        $this->post['base_month'] = get_base_month();
        $this->default_state = $this->config->item('default_state');
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
    function save_followup_mci_inc(){
        $call_type = $this->input->get();
        $post_data = $this->input->post();
        $inc_details = $this->input->get_post('incient');
        $call_id = $this->input->get_post('call_id');
        $caller_details = $this->session->userdata('caller_details');
        $inc_details = $this->session->userdata('mic_details');
        $inc_post_details = $this->session->userdata('inc_post_details');
        $patient = $this->session->userdata('patient');
        //var_dump($inc_details);
        //var_dump($inc_post_details);
        //die();
         if($this->clg->clg_group == 'UG-ERO-102'){
            $system = '102';
        }else{
            $system = '108';
        }

        $datetime = date('Y-m-d H:i:s');
        $datetime = $this->session->userdata('inc_datetime');

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
            $inc_post_details['incient_state'] = "MH";
        }
        $date = str_replace('-', '', date('Y-m-d'));

        //$inc_id = $date.$call_id;
        $inc_id = $this->session->userdata('inc_ref_id');




        $sr_user = $this->clg->clg_ref_id;

        $sms_amb_details = $inc_details['amb_id'];

       if ($dup_inc == 'No') {
            $amb_count = 0;
            foreach ($inc_details['amb_id'] as $key => $select_amb) {
                $amb_count++;
                $inc_re_id = $inc_id . '-' . $amb_count;
                
                $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_re_id));
                if(!empty($is_exits)){
                    $this->session->set_userdata('inc_ref_id','');
                    $this->output->message = "<div class='error'>Incident Id alredy exists</div>";
                    return;
                }

                if($inc_post_details['incient_districts'] == '')
                {
                    $district = $inc_post_details['incient_district'];
                }else{
                    $district = $inc_post_details['incient_districts'];
                }

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
                    'bed_type' => $inc_details['bed_type'],
                    //'inc_district' => $inc_post_details['incient_district'],
                    'inc_district_id' => $district,
                    'inc_area' => $inc_details['area'],
                    'inc_landmark' => $inc_details['landmark'],
                    'inc_lane' => $inc_details['lane'],
                    'inc_h_no' => $inc_details['h_no'],
                    'inc_pincode' => $inc_details['pincode'],
                    'inc_lat' => $inc_details['lat'],
                    'inc_long' => $inc_details['lng'],
                    'destination_hospital_id' => $inc_details['hospital_id'],
                    'destination_hospital_two' => $inc_details['hospital_two_id'],
                    'destination_hospital_other' => $inc_details['hospital_other'],
                    'inc_datetime' => $datetime,
                    'inc_service' => $inc_details_service,
                    'inc_duplicate' => $dup_inc,
                    'inc_base_month' => $this->post['base_month'],
                    'inc_set_amb' => '1',
                    'inc_recive_time' => $inc_details['inc_recive_time'],
                    'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
                    'inc_added_by' => $this->clg->clg_ref_id,
                    'inc_wht_three_wrd' => $inc_details['3word'],
                    'bk_inc_ref_id' => $inc_re_id,
                    'inc_thirdparty' => $this->clg->thirdparty,
                    'inc_system_type' => $system,
                    'followup_status' => '1'
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
                if ($post_data['followup_reason'] != '') {
                    $incidence_details['followup_reason'] = $post_data['followup_reason'];
                }
                if ($post_data['followup_reason_other'] != '') {
                    $incidence_details['followup_reason_other'] = $post_data['followup_reason_other'];
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
                $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id, $tm_team_date);$amb_details = $this->inc_model->get_ambulance_details_API($inc_details['amb_id']);
                $amb_lat = $amb_details[0]->amb_lat;
                $amb_log = $amb_details[0]->amb_log;
                $thirdparty = $amb_details[0]->thirdparty;
                $ward_id = $amb_details[0]->ward_id;
                $ward_name = $amb_details[0]->ward_name;
                $hp_id = $amb_details[0]->hp_id;
                $hp_name = $amb_details[0]->hp_name;

              /*  $incidence_amb_details = array('amb_rto_register_no' => $inc_details['amb_id'],
                    'inc_ref_id' => $inc_re_id,
                    'ward_id' => $ward_id,
                    'ward_name' => $ward_name,
                    'base_location_id' => $hp_id,
                    'base_location_name' => $hp_name,
                    'amb_pilot_id' => $pilot,
                    'amb_emt_id' => $EMT,
                    'inc_base_month' => $this->post['base_month'],
                    'assigned_time' => $datetime);
                $this->inc_model->insert_inc_amb($incidence_amb_details);
*/
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


               // $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);

               // $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);

                $incidence_details['inc_mci_nature'] = $inc_details['mci_nature'];

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                //die();


                $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
                //$last_pat_id = $last_insert_pat_id[0]->p_id + 1;
                //$last_pat_id = $this->clg->clg_id.'_'.$last_pat_id;
                 $last_pat_id = generate_ptn_id();
                

                $incidence_patient_details = array('ptn_fname' => ucfirst($patient['first_name']),
                    'ptn_mname' => ucfirst($patient['middle_name']),
                    'ptn_lname' => ucfirst($patient['last_name']),
                    'ptn_gender' => $patient['gender'],
                    'ptn_fullname' => ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']),
                    'ptn_age' => $patient['age'],
                    'ptn_age_type' => $patient['age_type'],
                    'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                    'ptn_birth_date' => $patient['dob'],
                    'ptn_id' => $last_pat_id,
                    'ptn_added_by' => $this->clg->clg_ref_id,
                    'ptn_added_date' => date('Y-m-d H:i:s'),
                );

                $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
               
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
                        'inc_wht_three_wrd' => $inc_details['3word'],
                        'bk_inc_ref_id' => $inc_re_id,
                        'inc_thirdparty' => $this->clg->thirdparty,
                        'inc_system_type' => $system,
                        'followup_status' => '1'
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
                    if ($post_data['followup_reason'] != '') {
                        $incidence_details['followup_reason'] = $post_data['followup_reason'];
                    }
                    if ($post_data['followup_reason_other'] != '') {
                        $incidence_details['followup_reason_other'] = $post_data['followup_reason_other'];
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

                   /* $incidence_amb_details = array('amb_rto_register_no' => $inc_details['stand_amb_id'],
                        'inc_ref_id' => $inc_re_id,
                        'amb_pilot_id' => $pilot,
                        'amb_emt_id' => $EMT,
                        'amb_type'=> 'standby',
                        'inc_base_month' => $this->post['base_month'],
                        'assigned_time' => $datetime);

                    $this->inc_model->insert_inc_amb($incidence_amb_details);
*/
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
                    //$last_pat_id = $last_insert_pat_id[0]->p_id + 1;
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
        


        /* send sms to patient  */
        $sms_amb = $inc_details['amb_id'];
        $get_mobile_no = array('rg_no' => $sms_amb);
        $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);
        $driver = $this->colleagues_model->get_user_info($pilot);
        $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;
        $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;

        //$inc_id = $inc_id;
        $amb_url =  "http://localhost/JAEms/amb/loc/" . $inc_id;
        $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_id;

        //$amb_url = "http://210.212.165.123/tdd/amb/loc/" . $inc_id;
        //$amb_dir_url = "http://210.212.165.123/tdd/amb/amb_dir/" . $inc_id;



        $doctor = $this->colleagues_model->get_user_info($EMT);
        $sms_doctor = $doctor[0]->clg_first_name;
        $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;
        $sms_doctor_contact_no = ltrim($sms_doctor_contact_no, '0');
        $patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];
        $patient_mobile_no = $caller_details['clr_mobile'];
       
        $txtMsg1 = '';
        $txtMsg1.= "Dear ".$patient_full_name.",\n";
        $txtMsg1.= "Your request is received for service,\n";
        $txtMsg1.= "For enquiry or followup or any query please call on ".$no."\n" ;
        $txtMsg1.= "Your Incident Id is ".$incident_id."\n";
        $txtMsg1.= "JAES" ;

        $args = array(
            'msg' => $txtMsg1,
            'mob_no' => $patient_mobile_no,
            'sms_user'=>'Patient',
            'inc_id'=>$inc_id,
        );
       //$sms_data = sms_send($args);
       

        
      

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
        $url = base_url("calls");
        $this->output->message = "<h3>MCI Call</h3><br><p>Call save & Queue in foloowup list</p><script>window.location.href = '".$url."';</script>";
        $this->output->moveto = 'top';
        $this->output->add_to_position('', 'content', TRUE);  
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
        
    
        
         if($this->clg->clg_group == 'UG-PDA'){
             $emg_cad_inc_id = $CADIncidentID= $this->session->userdata('CADIncidentID');
             $eme_pda_data = array('emg_cad_inc_id'=>$emg_cad_inc_id,'call_status'=>'attended');
             $state_id = $this->inc_model->update_insertEmgVehDis($eme_pda_data);           
         }

        $datetime = date('Y-m-d H:i:s');
        $datetime = $this->session->userdata('inc_datetime');

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
                
                if($this->clg->clg_group == 'UG-PDA'){
                    $pda_inc_id[] = $inc_re_id;
                    $pda_select_amb[] = $select_amb;
                    $get_mobile_no = array('rg_no' => $select_amb);
                    $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);
                    $amb_url = "http://localhost/JAEms/amb/loc/" . $inc_re_id;
                    $driver_contact_no = $get_driver_no[0]->amb_default_mobile;
                    $pda_driver_no[] = $driver_contact_no;
                    $pda_amb_url[] = $amb_url;
                }
                
                $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_re_id));
                if(!empty($is_exits)){
                    $this->session->set_userdata('inc_ref_id','');
                    $this->output->message = "<div class='error'>Incident Id alredy exists</div>";
                    return;
                }
                
                if($inc_post_details['incient_districts'] == ''){
                    $district = $inc_post_details['incient_district'];
                }else{
                    $district = $inc_post_details['incient_districts'];
                }

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
                    'bed_type' => $inc_details['bed_type'],
                    //'inc_district' => $inc_post_details['incient_district'],
                    'inc_district_id' => $district,
                    'inc_area' => $inc_details['area'],
                    'inc_landmark' => $inc_details['landmark'],
                    'inc_lane' => $inc_details['lane'],
                    'inc_h_no' => $inc_details['h_no'],
                    'inc_pincode' => $inc_details['pincode'],
                    'inc_lat' => $inc_details['lat'],
                    'inc_long' => $inc_details['lng'],
                    'destination_hospital_id' => $inc_details['hospital_id'],
                    'destination_hospital_two' => $inc_details['hospital_two_id'],
                    'destination_hospital_other' => $inc_details['hospital_other'],
                    'inc_datetime' => $datetime,
                    'inc_service' => $inc_details_service,
                    'inc_duplicate' => $dup_inc,
                    'inc_base_month' => $this->post['base_month'],
                    'inc_set_amb' => '1',
                    'inc_recive_time' => $inc_details['inc_recive_time'],
                    'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
                    'inc_added_by' => $this->clg->clg_ref_id,
                    'inc_wht_three_wrd' => $inc_details['3word'],
                    'bk_inc_ref_id' => $inc_re_id,
                    'inc_thirdparty' => $this->clg->thirdparty,
                    'inc_system_type' => $system
                );

                if($this->clg->clg_group == 'UG-PDA'){
                    $incidence_details['is_pda_inc'] = 'yes';
                    $incidence_details['CADIncidentID'] = $this->session->userdata('CADIncidentID');
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
                         if($inc_details['hospital_id'] != ''){
            $incidence_details['hospital_id'] = $inc_details['hospital_id'];
         }     
         if($inc_details['hospital_two_id'] != ''){
            $incidence_details['hospital_id'] = $inc_details['hospital_two_id'];
         }
         $priority_hospital = get_hospital_by_id($incidence_details['hospital_id']);
         $district_hospital = $priority_hospital[0]->hp_district;
         $hosp_type = get_hosp_type_by_id($priority_hospital[0]->hp_type);
         $incidence_details['hospital_type'] = $hosp_type;
         $incidence_details['hospital_district'] = $district_hospital;

               
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
                
                if ($dup_inc == 'No') {

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

                            $call_hisotory_args = array(
                            'incident_id' => $inc_re_id,
                            'ero_id'=>$this->clg->clg_ref_id,
                            'pda_id' => $police_user->clg_ref_id,
                            'pda_status' => 'ASG',
                            'incident_date' => $datetime,
                            'added_date' => $datetime
                        );
                        $police_operator = $this->common_model->insert_call_history($call_hisotory_args);

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

                             $call_hisotory_args = array(
                            'incident_id' => $inc_re_id,
                            'ero_id'=>$this->clg->clg_ref_id,
                            'fda_id' => $fire_user->clg_ref_id,
                            'fda_status' => 'ASG',
                            'incident_date' => $datetime,
                            'added_date' => $datetime );

                            $fda_operator = $this->common_model->insert_fda_call_history($call_hisotory_args);
                        }
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
                $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id, $tm_team_date);
                $amb_details = $this->inc_model->get_ambulance_details_API($inc_details['amb_id']);
                $amb_lat = $amb_details[0]->amb_lat;
                $amb_log = $amb_details[0]->amb_log;
                $thirdparty = $amb_details[0]->thirdparty;
                $ward_id = $amb_details[0]->ward_id;
                $ward_name = $amb_details[0]->ward_name;
                $hp_id = $amb_details[0]->hp_id;
                $hp_name = $amb_details[0]->hp_name;

                $incidence_amb_details = array('amb_rto_register_no' => $inc_details['amb_id'],
                    'inc_ref_id' => $inc_re_id,
                    'ward_id' => $ward_id,
                    'ward_name' => $ward_name,
                    'base_location_id' => $hp_id,
                    'base_location_name' => $hp_name,
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
                //die();


                $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
                //$last_pat_id = $last_insert_pat_id[0]->p_id + 1;
                //$last_pat_id = $this->clg->clg_id.'_'.$last_pat_id;
                 $last_pat_id = generate_ptn_id();

                $incidence_patient_details = array('ptn_fname' => ucfirst($patient['first_name']),
                    'ptn_mname' => ucfirst($patient['middle_name']),
                    'ptn_lname' => ucfirst($patient['last_name']),
                    'ptn_gender' => $patient['gender'],
                    'ptn_fullname' => ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']),
                    'ptn_age' => $patient['age'],
                    'ptn_age_type' => $patient['age_type'],
                    'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                    'ptn_birth_date' => $patient['dob'],
                    'ptn_id' => $last_pat_id,
                    'ptn_added_by' => $this->clg->clg_ref_id,
                    'ptn_added_date' => date('Y-m-d H:i:s'),
                );

                $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
               
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
                
                        
                $denial_id = $this->session->userdata('denial_id');
                if($denial_id){
                    foreach($denial_id as $denial){
                        $com_args = array('inc_ref_id'=>$inc_re_id,'id'=>$denial);
                        $update_app_call_details = $this->Dashboard_model->update_denial($com_args);
                    } 
                }
         
     
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
                        'inc_wht_three_wrd' => $inc_details['3word'],
                        'bk_inc_ref_id' => $inc_re_id,
                        'inc_thirdparty' => $this->clg->thirdparty,
                        'inc_system_type' => $system
                    );

                    if($this->clg->clg_group == 'UG-PDA'){
                     $incidence_details['is_pda_inc'] = 'yes';
                      $incidence_details['CADIncidentID'] = $this->session->userdata('CADIncidentID');
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
                     if($inc_details['hospital_id'] != ''){
                        $incidence_details['hospital_id'] = $inc_details['hospital_id'];
                     }     
                     if($inc_details['hospital_two_id'] != ''){
                        $incidence_details['hospital_id'] = $inc_details['hospital_two_id'];
                     }
                     $priority_hospital = get_hospital_by_id($incidence_details['hospital_id']);
                     $district_hospital = $priority_hospital[0]->hp_district;
                     $hosp_type = get_hosp_type_by_id($priority_hospital[0]->hp_type);
                     $incidence_details['hospital_type'] = $hosp_type;
                     $incidence_details['hospital_district'] = $district_hospital;
         
                    if($inc_details['hospital_id'] != ''){
                         $pri_hospital_data = get_hospital_by_id($inc_details['hospital_id']);
                         $pri_hosp_name = $pri_hospital_data[0]->hp_name;
                         $pri_hosp_lat = $pri_hospital_data[0]->hp_lat;
                         $pri_hosp_lng = $pri_hospital_data[0]->hp_long;
                    }else{
                         $pri_hospital_data = get_hospital_by_id($inc_details['hospital_two_id']);
                         $pri_hosp_name = $pri_hospital_data[0]->hp_name;
                         $pri_hosp_lat = $pri_hospital_data[0]->hp_lat;
                         $pri_hosp_lng = $pri_hospital_data[0]->hp_long;
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

                    if ($dup_inc == 'No') {
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

                                 $call_hisotory_args = array(
                                'incident_id' => $inc_re_id,
                                'ero_id'=>$this->clg->clg_ref_id,
                                'pda_id' => $police_user->clg_ref_id,
                                'pda_status' => 'ASG',
                                'incident_date' => $datetime,
                                'added_date' => $datetime
                            );
                            if($this->clg->clg_group != 'UG-PDA'){
                                    $police_operator = $this->common_model->insert_call_history($call_hisotory_args);
                            }
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

                                 $call_hisotory_args = array(
                                'incident_id' => $inc_re_id,
                                'ero_id'=>$this->clg->clg_ref_id,
                                'fda_id' => $fire_user->clg_ref_id,
                                'fda_status' => 'ASG',
                                'incident_date' => $datetime,
                                'added_date' => $datetime );

                                $fda_operator = $this->common_model->insert_fda_call_history($call_hisotory_args);
                            }
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
                    //$last_pat_id = $this->clg->clg_id.'_'.$last_pat_id;
                     $last_pat_id = generate_ptn_id();

                    $incidence_patient_details = array('ptn_fname' => ucfirst($patient['first_name']),
                        'ptn_mname' => ucfirst($patient['middle_name']),
                        'ptn_lname' => ucfirst($patient['last_name']),
                        'ptn_gender' => $patient['gender'],
                        'ptn_fullname' => ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']),
                        'ptn_age' => $patient['age'],
                        'ptn_age_type' => $patient['age_type'],
                        'ayushman_id' => $patient['ayu_id'],
                        'ptn_mob_no' => $patient['ptn_mob_no'],
                        'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_birth_date' => $patient['dob'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s'),
                    );

                    $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
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
        $api_url = "http://localhost/JAEms/api/googlenotification";
		$json_data = array('ambulanceNo'=>$inc_details['amb_id'],
						   'incidentId'=>$inc_id,
						   'cheifComplaint' => get_cheif_complaint($inc_details['chief_complete']));

        $json_data= json_encode($json_data);
                
        $api_google = api_notification_app($api_url,$json_data);
        
        $comm_api_url = "http://localhost/JAEms/communityapp/googlenotification";
		$json_data = array('userMobileNo'=>$caller_details['clr_mobile'],
                           'ambulanceNo'=>$inc_details['amb_id'],
						   'incidentId'=>$inc_id,
						   'cheifComplaint' => get_cheif_complaint($inc_details['chief_complete']));

        $json_data= json_encode($json_data);
                
        $api_google = api_notification_app($comm_api_url,$json_data);
        
        if($this->clg->clg_group == 'UG-PDA'){
            
            $pda_inc    = implode(',',$pda_inc_id);
            $pda_amb    = implode(',',$pda_select_amb);
            $pda_dri_no = implode(',',$pda_driver_no);
            $pda_url    = implode(',',$pda_amb_url);
            $CADIncidentID = $this->session->userdata('CADIncidentID');

//            $json_data  =  array('incidentID'=>$pda_inc,
//                                'ambulanceNo'=>$pda_amb,
//                                'ambulanceContactNo' => $pda_dri_no,
//                                'ambulanceTracking'=>$pda_url,
//                                'CADIncidentID'=> $this->session->userdata('CADIncidentID'));
                $json_data  = '{
                                "data": {
                                "incidentID": "'.$pda_inc.'",
                                "ambulanceNo": "'.$pda_amb.'",
                                "ambulanceContactNo": "'.$pda_dri_no.'",
                                "ambulanceTracking": "'.$pda_url.'",
                                "CADIncidentID ":"'.$CADIncidentID.'"
                                }
                                }';

            //$json_data  = json_encode($json_data);

            $api_pda = pda_update_api($json_data);
        }
        

        $caller_loc = $inc_details['place'];
        $caller_lat = $inc_details['lat'];
        $caller_lng = $inc_details['lng'];
        $destination_hos = $pri_hosp_name ;
        $hos_lat = $pri_hosp_lat;
        $hos_lng = $pri_hosp_lng;
        $select_amb_API= str_replace('-','',$inc_details['amb_id']);
        //$select_amb = implode('',(explode("-",$inc_details['amb_id'])));
        $args = array(
            'LastActivityTime' => "$datetime" ,
            'JobStatus' => 'Dispatched' ,
            'onRoadStatus' =>'1' ,
            'Caller_Location' => "$caller_loc",
            'Hospital_Location' => "$destination_hos",
            'JobNo' => "$inc_id",
            'HospitalLatlong' => "$hos_lat".','."$hos_lng",
            'stateCode' => 'MP',
            'AmbulanceNo' =>"$select_amb_API",
            'CallerLatlong' =>"$caller_lat".','."$caller_lng"
        );
        $send_API = send_API($args);
       // update_inc_ref_id($inc_id);


        /* send sms to patient  */
        $sms_amb = $inc_details['amb_id'];
        $get_mobile_no = array('rg_no' => $sms_amb);
        $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);
        $driver = $this->colleagues_model->get_user_info($pilot);
        $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;
        $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;
        $sms_pilot_contact_no = $get_driver_no[0]->amb_pilot_mobile;
        $sms_pilot_contact_no = ltrim($sms_pilot_contact_no, '0');

        //$inc_id = $inc_id;
        // $amb_url = "http://localhost/JAEms/amb/loc/" . $inc_re_id;
        $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_id;

        $doctor = $this->colleagues_model->get_user_info($EMT);
        $sms_doctor = $doctor[0]->clg_first_name;
        $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;
        $sms_doctor_contact_no = ltrim($sms_doctor_contact_no, '0');
        $patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];
        $patient_mobile_no = $caller_details['clr_mobile'];
        if($patient_full_name==' '){
            $patient_full_name='Unkonwn';
        }
        $txtMsg1 = '';
        $sms_amb1 = implode('',(explode("-",$sms_amb)));
        $txtMsg1 = '';
        $txtMsg1.= "Dear ".$patient_full_name.", \n";
        $txtMsg1.= "Ambulance dispatched: ".$sms_amb1 .", \n";
        $txtMsg1.= "Ambulance Contact: ".$sms_doctor_contact_no .", \n" ;
        //$txtMsg1.= "Link: ".$amb_dir_url."\n" ;
        $txtMsg1 .= "Please click on the following link for downloading the 108 Sanjeevani app on your mobile Android User - https://tinyurl.com/2p87kfu6 and iOS User- https://tinyurl.com/3pup8pp4\n";
        $txtMsg1.= "JAES" ;

        $args = array(
            'msg' => $txtMsg1,
            'mob_no' => $patient_mobile_no,
            'sms_user'=>'patient',
            'inc_id'=>$inc_id,
        );
       $sms_data = sms_send($args);
       $mno = $caller_details['clr_mobile'];
        $mno = substr($mno, -10);
        $inc_link_args = array( 'mobile_no'=>$mno,
                                'incident_id'=>$inc_id,
                                'track_link'=>$amb_url,
                                'added_date' =>   date('Y-m-d H:i:s'));
        
        $inc_link = $this->call_model->insert_track_link($inc_link_args); 


        /* send sms to doctor  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];
        if($inc_details['mci_nature'] == 9){
            $chief_complaint = 'Mass Activity-Riots/Stampede';
        }else{
            $chief_complaint = get_mci_nature_service($inc_details['mci_nature']);
        }
        
        // $hospital_name = $inc_details['hos_name'];
        $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
        if($inc_details['hos_name']!='' || $inc_details['hos_name']!='null'){
            $hospital_name = $inc_details['hos_name'];
        }else{
            $hospital_name = $inc_details['hospital_other'];
        }
        if($hospital_name == ''){
            $hospital_name='NA';
        }
        if($inc_details['hospital_id'] != ''){
            $pri_hospital_data = get_hospital_by_id($inc_details['hospital_id']);
            $pri_hosp_name = $pri_hospital_data[0]->hp_name;
            $pri_hosp_lat = $pri_hospital_data[0]->hp_lat;
            $pri_hosp_lng = $pri_hospital_data[0]->hp_long;
        }else{
            $pri_hospital_data = get_hospital_by_id($inc_details['hospital_two_id']);
            $pri_hosp_name = $pri_hospital_data[0]->hp_name;
            $pri_hosp_lat = $pri_hospital_data[0]->hp_lat;
            $pri_hosp_lng = $pri_hospital_data[0]->hp_long;
        }
            
            $datetime = date('d-m-Y H:i:s');
            $txtMsg2 ='';
            $txtMsg2.= "Patient name: ".$patient_full_name.",\n"; 
            $txtMsg2.= " Address: ".$inc_address.",\n";
            $txtMsg2.= " Caller No: ".$patient_mobile_no.",\n";
            $txtMsg2.= " Incident Date Time: ".$datetime.",\n";
            $txtMsg2.= " Incident id: ".$inc_id.",\n";
            $txtMsg2.= " Chief Complaint: ".$chief_complaint.",\n";
            $txtMsg2.= " Hospital Name- ".$pri_hosp_name.",\n";
            $txtMsg2.= " JAES" ;
        
      
        $sms_to = $sms_doctor_contact_no;
        $args = array(
            'msg' => $txtMsg2,
            'mob_no' => $sms_to,
            'sms_user'=>'EMT',
            'inc_id'=>$inc_id,
        );
        $sms_data = sms_send($args);
       //die();
           $patient_name = $caller_details['clr_fname'];
           $datetime = date('d-m-Y H:i:s');
           $txtMsg2 ='';
           $txtMsg2.= "Patient name: ".$patient_full_name.",\n"; 
           $txtMsg2.= " Address: ".$inc_address.",\n";
           $txtMsg2.= " Caller No: ".$patient_mobile_no.",\n";
           $txtMsg2.= " Incident Date Time: ".$datetime.",\n";
           $txtMsg2.= " Incident id: ".$inc_id.",\n";
           $txtMsg2.= " Chief Complaint: ".$chief_complaint.",\n";
           $txtMsg2.= " Hospital Name- ".$pri_hosp_name.",\n";
           $txtMsg2.= " JAES" ;
            
      
        $sms_to_pilot = $sms_pilot_contact_no;
        $args = array(
            'msg' => $txtMsg2,
            'mob_no' => $sms_to_pilot,
            'sms_user'=>'Pilot',
            'inc_id'=>$inc_id,
        );
        $sms_data = sms_send($args);
        
        $mno = $caller_details['clr_mobile'];
        $mno = substr($mno, -10);
        $inc_link_args = array( 'mobile_no'=>$mno,
                                'incident_id'=>$inc_re_id,
                                'track_link'=>$amb_url,
                                'added_date' =>   date('Y-m-d H:i:s'));
        
        $inc_link = $this->call_model->insert_track_link($inc_link_args);
       

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
        $url = base_url("calls");
        $this->output->message = "<h3>MCI Call</h3><br><p>Ambulance Dispatch Successfully</p><script>window.location.href = '".$url."';</script>";
        $this->output->moveto = 'top';
        $this->output->add_to_position('', 'content', TRUE);
    }
    function save_followup_action_inc(){
        $datetime = date('Y-m-d H:i:s');
        
        $followup_reason = $this->input->post('followup_reason');
        $inc_id = $this->input->post('inc_id');   
        
        
         $inc_ero_followup_status = $this->input->post('inc_ero_followup_status');  
          $call_status_remark = $this->input->post('call_status_remark');  
          $inc_ero_followup_summary = $this->input->post('inc_ero_followup_summary');  
          
        
        $followup_details = array('followup_reason_id' => $followup_reason,
            'inc_ref_id' => $inc_id,
            'inc_added_by' => $this->clg->clg_ref_id,
            'added_date' => $datetime,
            'is_deleted' => '0',
            //'call_status_remark'=>$call_status_remark,
            'inc_ero_followup_summary'=> $inc_ero_followup_summary,
            'inc_ero_followup_status'=>$inc_ero_followup_status
        );
        if($inc_ero_followup_status == 'Denied/Cancelled' || $inc_ero_followup_status == 'Ambulance Dispatched'){
            $inc_args = array(
                'inc_ref_id' => $inc_id,
                'followup_status' => '2'
            );
        }

        
        $inc_data = $this->inc_model->insert_followupinc($followup_details);
        $inc_details_update = $this->inc_model->update_inc_details($inc_args);

        $this->output->status = 1;
        $this->output->closepopup = "yes";
        ($call_type['cl_type'] == 'forword') ? $msg = "forworded" : $msg = "Added";
        $url = base_url("calls");
        $this->output->message = "<h3>Followup Call</h3><br><p>Details saved Successfully</p><script>window.location.href = '".$url."';</script>";
        $this->output->moveto = 'top';
        $this->output->add_to_position('', 'content', TRUE);
    }
    function save_followup_nonmci_inc(){
        $call_type = $this->input->get();
        $inc_details = $this->input->get_post('incient');
        $call_id = $this->input->get_post('call_id');
        $caller_details = $this->session->userdata('caller_details');
        $inc_details = $this->session->userdata('mic_details');
        $inc_post_details = $this->session->userdata('inc_post_details');
        $post_data = $this->input->post();
        $datetime = date('Y-m-d H:i:s');
        $datetime = $this->session->userdata('inc_datetime');
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
        }if($this->clg->clg_group == 'UG-BIKE-ERO'){
            $system = 'BIKE';
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
            $inc_post_details['incient_state'] = "MH";
        }
        $date = str_replace('-', '', date('Y-m-d'));

        $inc_id = $this->session->userdata('inc_ref_id');
        
        $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_id));
        if(!empty($is_exits)){
            $this->session->set_userdata('inc_ref_id','');
            $this->output->message = "<div class='error'>Incident Id alredy exists</div>";
            return;
        }

        $dispatch_time = $this->session->userdata('dispatch_time');

        $current_time = time();
        $res_time = $current_time - $dispatch_time;
        $h = ($res_time / (60 * 60)) % 24;
        $m = ($res_time / 60) % 60;
        
         if($inc_post_details['incient_districts'] == ''){
                    $district = $inc_post_details['incient_district'];
                }else{
                    $district = $inc_post_details['incient_districts'];
                }
                if($dup_inc == ''){
                    $dup_inc = 'No';
                }
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
            'inc_div_id' => $inc_post_details['incient_division'],
            'inc_address' => $inc_details['place'],
            'inc_tahshil_id' => $inc_post_details['incient_tahsil'],
            'inc_district_id' =>$district,
            'inc_area' => $inc_details['area'],
            'inc_landmark' => $inc_details['landmark'],
            'inc_lane' => $inc_details['lane'],
            'inc_h_no' => $inc_details['h_no'],
            'inc_pincode' => $inc_details['pincode'],
            'inc_lat' => $inc_details['lat'],
            'inc_long' => $inc_details['lng'],
            'destination_hospital_id' => $inc_details['hospital_id'],
            'destination_hospital_other' => $inc_details['hospital_other'],

            // 'hospital_id' => $inc_details['hospital_id'],
           // 'hospital_name' => $inc_details['hospital_other'],
           // 'hospital_type' => 'ALL',
            'inc_datetime' => $datetime,
            'inc_service' => $inc_details_service,
            'inc_duplicate' => $dup_inc,
            'inc_base_month' => $this->post['base_month'],
            'inc_set_amb' => '0',
          //  'inc_suggested_amb' => $inc_details['inc_suggested_amb'],
            'inc_recive_time' => $inc_details['inc_recive_time'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_wht_three_wrd' => $inc_details['3word'],
            'bk_inc_ref_id' => $inc_id,
            'inc_thirdparty' => $this->clg->thirdparty,
            'bed_type' => $inc_details['bed_type'],
            'followup_schedule_datetime' => $inc_details['followup_schedule_datetime'],
            'inc_system_type' => $system,
            'followup_status'=>'1'
        );


        if ($inc_details['inc_suggested_amb'] != '') {
            $incidence_details['inc_suggested_amb'] = $inc_details['inc_suggested_amb'];
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
        if ($post_data['followup_reason'] != '') {
            $incidence_details['followup_reason'] = $post_data['followup_reason'];
        }
        if ($post_data['followup_reason_other'] != '') {
            $incidence_details['followup_reason_other'] = $post_data['followup_reason_other'];
        }      
        $incidence_details['inc_set_amb'] = '1';
       // $incidence_details['incis_deleted'] = '0';
        $incidence_details['inc_system_type'] = $system;
               
        

        $sr_user = $this->clg->clg_ref_id;

        $patient = $this->input->get_post('patient');

        $patient = $this->session->userdata('patient');

        $EMT = "";

        $pilot = '';


        if($inc_details['amb_id']){
            foreach ($inc_details['amb_id'] as $select_amb) {
                $inc_details['amb_id'] = $select_amb;
            }
        }

        $tm_team_date = date('Y-m-d');

        //$emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id, $tm_team_date);
       // $amb_details = $this->inc_model->get_ambulance_details_API($inc_details['amb_id']);
//        $amb_lat = $amb_details[0]->amb_lat;
//        $amb_log = $amb_details[0]->amb_log;
//        $thirdparty = $amb_details[0]->thirdparty;
//        $ward_id = $amb_details[0]->ward_id;
//        $ward_name = $amb_details[0]->ward_name;
//        $hp_id = $amb_details[0]->hp_id;
//        $hp_name = $amb_details[0]->hp_name;
        
        //var_dump($ambulance_lat);die;
//        if ($emp_inc_data) {
//            $pilot = $emp_inc_data[0]->tm_pilot_id;
//            $EMT = $emp_inc_data[0]->tm_emt_id;
//        }
        
         $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
        if ($inc_details['chief_complete_other'] != '') {
            $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
        }
        if($thirdparty!='' || $thirdparty != '0'){
        $incidence_details['inc_thirdparty'] = $thirdparty;
        }
        else{
            $incidence_details['inc_thirdparty'] = $this->clg->thirdparty;
        }
       
        //var_dump($incidence_details);die();
        $inc_data = $this->inc_model->insert_inc($incidence_details);
        //var_dump($inc_data);die();

       
       $sr_user = $this->clg->clg_ref_id;

        if (!empty($patient)) {
            if (ucfirst($patient['first_name']) != '') {

                $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
                $last_pat_id = $last_insert_pat_id[0]->p_id + 1;
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
                    'ptn_added_date' => date('Y-m-d H:i:s')
                );

                $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
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
                if($inc_details['que_lan']=="")
                {
                    $inc_details['que_lan']="0";
                
                }
                $ems_summary = array('sum_base_month' => $this->post['base_month'],
                    'sum_sub_id' => $inc_id,
                    'sum_sub_type' => $inc_details['inc_type'],
                    'sum_que_id' => $key,
                    'sum_que_ans' => $ques,
                    'sum_que_lan' => $inc_details['que_lan']
                );

                $this->inc_model->insert_ems_summary($ems_summary);
            }
        }


        if ($call_type['cl_type'] == 'forword') {

            $super_user = $this->inc_model->get_user_by_group('UG-FOLLOWUPERO');

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


        $url = base_url("calls");
        $this->output->message = "<h3>Non-MCI Call</h3><br><p>Call forword in Followup Queue</p><script>window.location.href = '".$url."';</script>";



        $this->output->moveto = 'top';



        //$this->output->add_to_position('', 'content', TRUE); 
    }
    function save_nonmci_inc() {

       
        
        
        $call_type = $this->input->get();
        $inc_details = $this->input->get_post('incient');
        $call_id = $this->input->get_post('call_id');
        $caller_details = $this->session->userdata('caller_details');
        $inc_details = $this->session->userdata('mic_details');
        
        $inc_post_details = $this->session->userdata('inc_post_details');
       
        $datetime = date('Y-m-d H:i:s');
        $datetime = $this->session->userdata('inc_datetime');

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
        }if($this->clg->clg_group == 'UG-BIKE-ERO'){
            $system = 'BIKE';
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
        
        if($this->clg->clg_group == 'UG-PDA'){
            $emg_cad_inc_id = $CADIncidentID = $this->session->userdata('CADIncidentID');
            $eme_pda_data = array('emg_cad_inc_id'=>$emg_cad_inc_id,'call_status'=>'attended');
            $state_id = $this->inc_model->update_insertEmgVehDis($eme_pda_data);           
        }


        $inc_details_service = serialize($inc_details['service']);


        if ($inc_post_details['incient_state'] == '') {
            $inc_post_details['incient_state'] = "MP";
        }
        $date = str_replace('-', '', date('Y-m-d'));
     
        
  foreach ($inc_details['amb_id'] as $key => $select_amb) {
   
        $amb_count++;
              
        $inc_id = $this->session->userdata('inc_ref_id');
       
        if(count($inc_details['amb_id'] ) == 1){
        $inc_id = $inc_id;
        }else{
             $inc_id = $inc_id . '-' . $amb_count;
        }
        $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_id));
        if(!empty($is_exits)){
            $this->session->set_userdata('inc_ref_id','');
            $this->output->message = "<div class='error'>Incident Id alredy exists</div>";
            return;
        }

        $dispatch_time = $this->session->userdata('dispatch_time');

        $current_time = time();
        $res_time = $current_time - $dispatch_time;
        $h = ($res_time / (60 * 60)) % 24;
        $m = ($res_time / 60) % 60;
        
         if($inc_post_details['incient_districts'] == '')
                {
                    $district = $inc_post_details['incient_district'];
                }else{
                    $district = $inc_post_details['incient_districts'];
                }
                
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
            'inc_div_id' => $inc_post_details['incient_division'],
            'inc_address' => $inc_details['place'],
            'bed_type' => $inc_details['bed_type'],
            'inc_tahshil_id' => $inc_post_details['incient_tahsil'],
            'inc_district_id' => $district,
            'inc_area' => $inc_details['area'],
            'inc_landmark' => $inc_details['landmark'],
            'inc_lane' => $inc_details['lane'],
            'inc_h_no' => $inc_details['h_no'],
            'inc_pincode' => $inc_details['pincode'],
            'inc_lat' => $inc_details['lat'],
            'inc_long' => $inc_details['lng'],
            'destination_hospital_id' => $inc_details['hospital_id'],
            'destination_hospital_two' => $inc_details['hospital_two_id'],
            'destination_hospital_other' => $inc_details['hospital_other'],
            // 'hospital_id' => $inc_details['hospital_id'],
           // 'hospital_name' => $inc_details['hospital_other'],
           // 'hospital_type' => 'ALL',
            'inc_datetime' => $datetime,
            'inc_service' => $inc_details_service,
            'inc_duplicate' => $dup_inc,
            'inc_base_month' => $this->post['base_month'],
            'inc_set_amb' => '1',
           // 'inc_suggested_amb' => $inc_details['inc_suggested_amb'],
            'inc_recive_time' => $inc_details['inc_recive_time'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_wht_three_wrd' => $inc_details['3word'],
            'bk_inc_ref_id' => $inc_id,
            'inc_thirdparty' => $this->clg->thirdparty,
            'inc_system_type' => $system
        );
         
        if($this->clg->clg_group == 'UG-PDA'){
            $incidence_details['is_pda_inc'] = 'yes';
            $incidence_details['CADIncidentID'] = $this->session->userdata('CADIncidentID');         
                     
        }
                
        if ($inc_details['inc_suggested_amb'] != '') {
            $incidence_details['inc_suggested_amb'] = $inc_details['inc_suggested_amb'];
        }
         if ($inc_details['pre_inc_ref_id'] != '') {
            $incidence_details['pre_inc_ref_id'] = $inc_details['pre_inc_ref_id'];
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
         if($inc_details['hospital_id'] != ''){
            $incidence_details['hospital_id'] = $inc_details['hospital_id'];
         }     
         if($inc_details['hospital_two_id'] != ''){
            $incidence_details['hospital_id'] = $inc_details['hospital_two_id'];
         }
         $priority_hospital = get_hospital_by_id($incidence_details['hospital_id']);
         $district_hospital = $priority_hospital[0]->hp_district;
         $hosp_type = get_hosp_type_by_id($priority_hospital[0]->hp_type);
         $incidence_details['hospital_type'] = $hosp_type;
         $incidence_details['hospital_district'] = $district_hospital;
                  

         if($inc_details['hospital_id'] != ''){
             $pri_hospital_data = get_hospital_by_id($inc_details['hospital_id']);
             $pri_hosp_name = $pri_hospital_data[0]->hp_name;
             $pri_hosp_lat = $pri_hospital_data[0]->hp_lat;
             $pri_hosp_lng = $pri_hospital_data[0]->hp_long;
         }else{
             $pri_hospital_data = get_hospital_by_id($inc_details['hospital_two_id']);
             $pri_hosp_name = $pri_hospital_data[0]->hp_name;
             $pri_hosp_lat = $pri_hospital_data[0]->hp_lat;
             $pri_hosp_lng = $pri_hospital_data[0]->hp_long;
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



       // foreach ($inc_details['amb_id'] as $select_amb) {
           // $inc_details['amb_id'] = $select_amb;
        //}

        $tm_team_date = date('Y-m-d');

        $emp_inc_data = $this->inc_model->get_amb_default_emp($select_amb, $sft_id, $tm_team_date);
         $amb_details = $this->inc_model->get_ambulance_details_API($select_amb);
        $amb_lat = $amb_details[0]->amb_lat;
        $amb_log = $amb_details[0]->amb_log;
        $thirdparty = $amb_details[0]->thirdparty;
        $ward_id = $amb_details[0]->ward_id;
        $ward_name = $amb_details[0]->ward_name;
        $hp_id = $amb_details[0]->hp_id;
        $hp_name = $amb_details[0]->hp_name;
        
        //var_dump($ambulance_lat);die;
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
        if($thirdparty!='' || $thirdparty != '0'){
        $incidence_details['inc_thirdparty'] = $thirdparty;
        }
        else{
            $incidence_details['inc_thirdparty'] = $this->clg->thirdparty;
        }
       
       // var_dump($incidence_details);die();
        $inc_data = $this->inc_model->insert_inc($incidence_details);       
       //die();

       $args = array(
            'inc_id' => $inc_id,
            'caseStatus' => 'true',
            'vehicleName' => $select_amb,
            'caseOn' => $datetime,
            'vLat' => $amb_lat,
            'vLong' => $amb_log,
            'pLat' => $inc_details['lat'],
            'pLong' => $inc_details['lng'],
            'pationAddress' =>$inc_details['place'],
        );
       
        $api_url = "http://localhost/JAEms/api/googlenotification";
		$json_data = array(
                           'ambulanceNo'=>$select_amb,
						   'incidentId'=>$inc_id,
						   'cheifComplaint' => get_cheif_complaint($inc_details['chief_complete']));

        $json_data= json_encode($json_data);
                
        $auser_req_idpi_google = api_notification_app($api_url,$json_data);
        
         $comm_api_url = "http://localhost/JAEms/communityapp/googlenotification";
		$json_data = array('userMobileNo'=>$caller_details['clr_mobile'],
                           'ambulanceNo'=>$select_amb,
						   'incidentId'=>$inc_id,
						   'cheifComplaint' => get_cheif_complaint($inc_details['chief_complete']));

        $json_data= json_encode($json_data);
                
        $api_google = api_notification_app($comm_api_url,$json_data);
        
         $this->call_model->update_booking_details($inc_details['user_req_id']);
 
        
        if($this->clg->clg_group == 'UG-PDA'){
            $get_mobile_no = array('rg_no' => $select_amb);
            $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);
            $amb_url = "http://localhost/JAEms/amb/loc/" . $inc_id;
            $driver_contact_no = $get_driver_no[0]->amb_default_mobile;
            $CADIncidentID = $this->session->userdata('CADIncidentID');

//            $json_data = array('incidentID'=>$inc_id,
//                                'ambulanceNo'=>$select_amb,
//                                'ambulanceContactNo' => $driver_contact_no,
//                                'ambulanceTracking'=>$amb_url,
//                                'CADIncidentID'=> $this->session->userdata('CADIncidentID'));
//
//            $json_data= json_encode($json_data);
            $json_data  = '{
                                "data": {
                                "incidentID": "'.$inc_id.'",
                                "ambulanceNo": "'.$select_amb.'",
                                "ambulanceContactNo": "'.$driver_contact_no.'",
                                "ambulanceTracking": "'.$amb_url.'",
                                "CADIncidentID ":"'.$CADIncidentID.'"
                                }
                                }';

            $api_pda = pda_update_api($json_data);
        }

        $caller_loc = $inc_details['place'];
        $caller_lat = $inc_details['lat'];
        $caller_lng = $inc_details['lng'];
        $destination_hos = $pri_hosp_name;
        $hos_lat = $pri_hosp_lat;
        $hos_lng = $pri_hosp_lng;
        $select_amb_API= str_replace('-','',$select_amb);
        //var_dump($select_amb);
        //die();
       //$select_amb = implode('',(explode("-",$select_amb)));
        $args = array(
            'LastActivityTime' => "$datetime" ,
            'JobStatus' => 'Dispatched' ,
            'onRoadStatus' =>'1' ,
            'Caller_Location' => "$caller_loc",
            'Hospital_Location' => "$destination_hos",
            'JobNo' => "$inc_id",
            'HospitalLatlong' => "$hos_lat".','."$hos_lng",
            'stateCode' => 'MP',
            'AmbulanceNo' =>"$select_amb_API",
            'CallerLatlong' =>"$caller_lat".','."$caller_lng"
        );
        //$send_API = send_API($args);
       

       $sr_user = $this->clg->clg_ref_id;

        if ($dup_inc == 'No') {
            
   

            /*  if ($inc_details['service'][1] == '1') {
                  

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
            } */

            if ($dup_inc == 'No') {
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

                             $call_hisotory_args = array(
                                    'incident_id' => $inc_id,
                                    'ero_id'=>$this->clg->clg_ref_id,
                                    'pda_id' => $police_user->clg_ref_id,
                                    'pda_status' => 'ASG',
                                    'incident_date' => $datetime,
                                    'added_date' => $datetime
                                );
                            $police_operator = $this->common_model->insert_call_history($call_hisotory_args);
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

                        $call_hisotory_args = array(
                            'incident_id' => $inc_re_id,
                            'ero_id'=>$this->clg->clg_ref_id,
                            'fda_id' => $fire_user->clg_ref_id,
                            'fda_status' => 'ASG',
                            'incident_date' => $datetime,
                            'added_date' => $datetime );
                        $fda_operator = $this->common_model->insert_fda_call_history($call_hisotory_args);
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

            $incidence_amb_details = array('amb_rto_register_no' =>$select_amb ,
                'inc_ref_id' => $inc_id,
                'ward_id' => $ward_id,
                'ward_name' => $ward_name,
                'base_location_id' => $hp_id,
                'base_location_name' => $hp_name,
                'amb_pilot_id' => $pilot,
                'amb_emt_id' => $EMT,
                'inc_base_month' => $this->post['base_month'],
                'assigned_time' => $datetime);

            $this->inc_model->insert_inc_amb($incidence_amb_details);



            $upadate_amb_data = array('amb_rto_register_no' =>$select_amb, 'amb_status' => 2);

            $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
        }

        if (!empty($patient)) {
            if (ucfirst($patient['first_name']) != '') {

                $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
                $last_pat_id = $last_insert_pat_id[0]->p_id + 1;
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
                if($inc_details['que_lan']=="")
                {
                    $inc_details['que_lan']="0";
                
                }

                $ems_summary = array('sum_base_month' => $this->post['base_month'],
                    'sum_sub_id' => $inc_id,
                    'sum_sub_type' => $inc_details['inc_type'],
                    'sum_que_id' => $key,
                    'sum_que_ans' => $ques,
                    'sum_que_lan' => $inc_details['que_lan']
                
                );
// var_dump( $ems_summary);die();
                $this->inc_model->insert_ems_summary($ems_summary);
            }
        }

        /* send sms to patient */
        $sms_amb = $select_amb;
        $get_mobile_no = array('rg_no' => $sms_amb);
        $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);
        $driver = $this->colleagues_model->get_user_info($pilot);
        $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;
        $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;
        $inc_id = $inc_id;
        // $amb_url = "http://localhost/JAEms/amb/loc/" . $inc_id;
        $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_id;
        //$amb_url = "http://210.212.165.123/tdd/amb/loc/" . $inc_id;
        //$amb_dir_url = "http://210.212.165.123/tdd/amb/amb_dir/" . $inc_id;
        $patient_name = $caller_details['clr_fname'];
        $doctor = $this->colleagues_model->get_user_info($EMT);
        $sms_doctor = $doctor[0]->clg_first_name;
        $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;
        $str = ltrim($sms_doctor_contact_no, '0');
        $patient_full_name = trim($caller_details['clr_fname']). ' ' .trim($caller_details['clr_mname']). ' ' .trim($caller_details['clr_lname']);
        $patient_mobile_no = $caller_details['clr_mobile'];
        $inc_address = $inc_details['place'];
        $Chief_Complaint_extra_length = array('32','4','15','89','92','50');
        if(in_array($incidence_details['inc_complaint'],$Chief_Complaint_extra_length))
        {
            if($incidence_details['inc_complaint']==32)
            {
                $chief_complaint = 'Child/Pediatric Patient';
            }
            if($incidence_details['inc_complaint']==4)
            {
                $chief_complaint = 'Altered Mental Status';
            }
            if($incidence_details['inc_complaint']==15)
            {
                $chief_complaint = 'Lightning Strike';
            }
            if($incidence_details['inc_complaint']==89 || $incidence_details['inc_complaint']==92 )
            {
                $chief_complaint = 'Children/Infacts/Newborn sick';
            }
            if($incidence_details['inc_complaint']==50)
            {
                $chief_complaint = 'Unconscious Patient';
            }
        }else{
            $chief_complaint = get_cheif_complaint($incidence_details['inc_complaint']);
        }
        if($inc_details['hos_name']!='' || $inc_details['hos_name']!='null'){
            $hospital_name = $inc_details['hos_name'];
        }else{
            $hospital_name = $inc_details['hospital_other'];
        }
        $sms_amb1 = implode('',(explode("-",$sms_amb)));
        $txtMsg1 = '';
        $txtMsg1.= "Dear ".$patient_full_name.", \n";
        $txtMsg1.= "Ambulance dispatched: ".$sms_amb1 .", \n";
        $txtMsg1.= "Ambulance Contact: ".$sms_doctor_contact_no .", \n" ;
        //$txtMsg1.= "Link: ".$amb_dir_url."\n" ;
        $txtMsg1 .= "Please click on the following link for downloading the 108 Sanjeevani app on your mobile Android User - https://tinyurl.com/2p87kfu6 and iOS User- https://tinyurl.com/3pup8pp4\n";
        $txtMsg1.= "JAES" ;
        $sms_to = $caller_details['clr_mobile'];
        $args = array(
            'inc_id' => $inc_id,
            'msg' => $txtMsg1,
            'mob_no' => $sms_to,
            'sms_user'=>'patient',
        );
       $sms_data = sms_send($args);

        $mno = $caller_details['clr_mobile'];
        $mno = substr($mno, -10);
        $inc_link_args = array( 'mobile_no'=>$mno,
                                'incident_id'=>$inc_id,
                                'track_link'=>$amb_url,
                                'added_date' =>   date('Y-m-d H:i:s'));
        
        $inc_link = $this->call_model->insert_track_link($inc_link_args);
       /* send sms to doctor  */
       //Patient name: {#var#} Address: {#var#} Caller No: {#var#} Incident id: {#var#} Chief Complaint: {#var#} Hospital Name- {#var#} JAES
        if($hospital_name==''){
            $hospital_name='NA';
        }
        if (strlen($pri_hosp_name) > 30){
            $pri_hosp_name = substr($pri_hosp_name, 0, 30);
        }
       $patient_name = $caller_details['clr_fname'];
       $datetime = date('d-m-Y H:i:s');
            $txtMsg2 ='';
            $txtMsg2.= "Patient name: ".$patient_full_name_sms.",\n"; 
            $txtMsg2.= " Address: ".$inc_address.",\n";
            $txtMsg2.= " Caller No: ".$patient_mobile_no.",\n";
            $txtMsg2.= " Incident Date Time: ".$datetime.",\n";
            $txtMsg2.= " Incident id: ".$inc_id.",\n";
            $txtMsg2.= " Chief Complaint: ".$chief_complaint.",\n";
            $txtMsg2.= " Hospital Name- ".$pri_hosp_name.",\n";
            $txtMsg2.= " JAES" ;
       //var_dump($txtMsg2);die();
        $sms_to = $sms_doctor_contact_no;
        $args = array(
            'inc_id' => $inc_id,
            'msg' => $txtMsg2,
            'mob_no' => $sms_to,
            'sms_user'=>'EMT',
        );
        $sms_data = sms_send($args);
        
       // die();
            $sms_pilot_contact_no = $get_driver_no[0]->amb_pilot_mobile; 
            $sms_pilot_contact_no = ltrim($sms_pilot_contact_no, '0');

        
            $patient_name = $caller_details['clr_fname'];
            $datetime = date('d-m-Y H:i:s');
            $txtMsg2 ='';
            $txtMsg2.= "Patient name: ".$patient_full_name_sms.",\n"; 
            $txtMsg2.= " Address: ".$inc_address.",\n";
            $txtMsg2.= " Caller No: ".$patient_mobile_no.",\n";
            $txtMsg2.= " Incident Date Time: ".$datetime.",\n";
            $txtMsg2.= " Incident id: ".$inc_id.",\n";
            $txtMsg2.= " Chief Complaint: ".$chief_complaint.",\n";
            $txtMsg2.= " Hospital Name- ".$pri_hosp_name.",\n";
            $txtMsg2.= " JAES" ;
      
        $sms_to_pilot = $sms_pilot_contact_no;
        $args = array(
            'msg' => $txtMsg2,
            'mob_no' => $sms_to_pilot,
            'sms_user'=>'Pilot',
            'inc_id'=>$inc_id,
        );
        
        $sms_data = sms_send($args);
        //die();
        $mno = $caller_details['clr_mobile'];
        $mno = substr($mno, -10);
        $inc_link_args = array( 'mobile_no'=>$mno,
                                'incident_id'=>$inc_id,
                                'track_link'=>$amb_url,
                                'added_date' =>   date('Y-m-d H:i:s'));
        
        $inc_link = $this->call_model->insert_track_link($inc_link_args);
        /* send sms to Pilot notification to pilot */
      
        $api_url = "http://localhost/JAEms/api/googlenotification";
		$json_data = array('ambulanceNo'=>$inc_details['amb_id'],
						   'incidentId'=>$inc_id,
						   'cheifComplaint' => get_cheif_complaint($inc_details['chief_complete']));

        $json_data= json_encode($json_data);
                
        $api_google = api_notification_app($api_url,$json_data);
        
        $comm_api_url = "http://localhost/JAEms/communityapp/googlenotification";
		$json_data = array('userMobileNo'=>$caller_details['clr_mobile'],
                           'ambulanceNo'=>$inc_details['amb_id'],
						   'incidentId'=>$inc_id,
						   'cheifComplaint' => get_cheif_complaint($inc_details['chief_complete']));

        $json_data= json_encode($json_data);
                
        $api_google = api_notification_app($comm_api_url,$json_data);
        
        $this->call_model->update_booking_details($inc_details['user_req_id']);

        //  send API
        $caller_loc = $inc_details['place'];
        $caller_lat = $inc_details['lat'];
        $caller_lng = $inc_details['lng'];
        $destination_hos = $pri_hosp_name;
        $hos_lat = $pri_hosp_lat;
        $hos_lng = $pri_hosp_lng;
      //  var_dump($inc_details['amb_id']);
      $select_amb_API= str_replace('-','',$sms_amb);
       // $select_amb = implode('',(explode("-",$inc_details['amb_id'])));
        $args = array(
            'LastActivityTime' => "$datetime" ,
            'JobStatus' => 'Dispatched' ,
            'onRoadStatus' =>'1' ,
            'Caller_Location' => "$caller_loc",
            'Hospital_Location' => "$destination_hos",
            'JobNo' => "$inc_id",
            'HospitalLatlong' => "$hos_lat".','."$hos_lng",
            'stateCode' => 'MP',
            'AmbulanceNo' =>"$select_amb_API",
            'CallerLatlong' =>"$caller_lat".','."$caller_lng"
        );
        $send_API = send_API($args);
        $denial_id = $this->session->userdata('denial_id');
        if($denial_id){
            foreach($denial_id as $denial){
                $com_args = array('inc_ref_id'=>$inc_id,'id'=>$denial);
                $update_app_call_details = $this->Dashboard_model->update_denial($com_args);
          
            } 
        }
        
 }

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

        //die();
        if($inc_data){
            
        $url = base_url("calls");   
        $this->output->message = "<h3>Non-MCI Call</h3><br><p>Ambulance Dispatch Successfully</p><script>window.location.href = '".$url."';</script>";



        $this->output->moveto = 'top';



        $this->output->add_to_position('', 'content', TRUE);
        
        }else{
               $this->output->message = "<h3>Non-MCI Call</h3><br><p>Error in Ambulance Dispatch</p>";
        }
    }

//    function get_inc_ambu() {
//        $lng_data = $this->input->get();
//
//        $data = array();
//       
//
//        $data['user_group'] = $this->clg->clg_group;
//
//
//        $data['inc_type'] = $lng_data['inc_type'];
//        
//        $data['ambu_data1']=array();
//        
//        $data['ambu_data2']=array();
//        
//        $destination = $lng_data['lat'] . ',' . $lng_data['lng'];
//  
//
//        if($lng_data['inc_ref_id'] != ''){
//            $args =array('inc_ref_id'=>trim($lng_data['inc_ref_id']));
//             $data['ambu_data1'] = $this->inc_model->get_inc_ambulance($args);
//           
//            
//              
//             
//             
//            $origins = array();
//            if ($data['ambu_data1']) {
//                foreach ($data['ambu_data1'] as $key => $) {
//                    
//                    $origins[] = trim($search_amb->amb_lat) . ',' . trim($search_amb->amb_log);
//                    
//                    
//                }
//            }
//
//           
//            if ($data['ambu_data1']) {
//                $origins_str = trim(implode('|', $origins));
//
//                //$google_api_key = 'AIzaSyBtAZEUryIBFm-pAoQXya4TnjxrwyUIUWI';
//                $google_api_key = $this->google_api_key;
//
//
//
//                $google_map_url = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $origins_str . '&destinations=' . $destination . '&region=in&key=' . $google_api_key;
//
//                $location_data = file_get_contents($google_map_url);
//                //$location_resp =  $this->_send_curl_request($google_map_url,'','get');
//                $location_data = json_decode($location_data);
//
//
//                $ambu_data = array();
//
//                if (!empty($location_data->origin_addresses)) {
//                      
//                    foreach ($location_data->origin_addresses as $key => $amb_row) {
//
//                        $duration_value = $location_data->rows[$key]->elements[0]->duration->value;
//                        if($duration_value == ''){
//                            $duration_value = $key;
//                        }
//                        
//
//                        $ambu_data[$duration_value] = $data['ambu_data1'][$key];
//                        $ambu_data[$duration_value]->assign = $data['ambu_data1'][$key]->inc_amb_type;
//
//                        $ambu_data[$duration_value]->duration = $location_data->rows[$key]->elements[0]->duration->text;
//
//                        $ambu_data[$duration_value]->duration_value = $location_data->rows[$key]->elements[0]->duration->value;
//
//                        $ambu_data[$duration_value]->road_distance = $location_data->rows[$key]->elements[0]->distance->text;
//
//                        $ambu_data[$duration_value]->road_distance_value = $location_data->rows[$key]->elements[0]->distance->value;
//                    }
//
//                    ksort($ambu_data);
//                  
//                    $data['ambu_data1'] = $ambu_data;
//                    
//                    
//                }
//            }
//            
//        }
//       
//
//        $data['ambu_data2']=array();
//        if ($lng_data['lat'] != '' && $lng_data['lng'] != '') {
//
//
//            $data['ambu_data2'] = $this->inc_model->get_am_in_inc_area($lng_data['lat'], $lng_data['lng'], $lng_data['amb_tp'], $lng_data['min_distance'], $lng_data['inc_status'], $lng_data['district_id']);
//
//
//            $origins = array();
//            if ($data['ambu_data2']) {
//                foreach ($data['ambu_data2'] as $key => $search_amb) {
//                    $origins = trim($search_amb->amb_lat) . ',' . trim($search_amb->amb_log);
//                    if ($data['ambu_data2']) {
//                      $google_map_url = "https://router.hereapi.com/v8/routes?transportMode=car&origin=$origins&destination=$destination&apiKey=yrjPrIYd0xU9KJpe1xlaR1_K1wFrwc9U-_-99n040JQ&return=summary";
//
//
//                        $location_data = file_get_contents($google_map_url);
//                        //$location_resp =  $this->_send_curl_request($google_map_url,'','get');
//                        $location_data = json_decode($location_data);
//                        $res_summary = $location_data->routes[0]->sections[0]->summary;
//                        //var_dump($res_summary);
//                        //die();
//
//                        
//                        $->road_distance = $res_summary->length*0.001." Km";
//                        $->duration = floor($res_summary->duration/60)." Min";;
//
//                        $data['ambu_data2'][] = $;
//                        
//                    }
//                }
//            }
//            
//        } else {
//            // $amb_user_type = 'tdd';
//            $data['ambu_data2'] = $this->inc_model->get_am_in_inc_area('', '', $lng_data['amb_tp'], '', $lng_data['inc_status'], $lng_data['district_id']);
//            
//        }
//        if(!empty($data['ambu_data2'])){
//            $data['ambu_data'] = array_merge($data['ambu_data1'],$data['ambu_data2']);
//        }
//        
//
//        $this->output->add_to_position($this->load->view('frontend/inc/inc_ambu_list_view', $data, TRUE), 'inc_map_details', TRUE);
//    }

    function get_inc_ambu() {
        $lng_data = $this->input->get();
//        $district_id = $this->clg->clg_district_id;
//        $district_id = explode( ",", $district_id);
//            $regex = "([\[|\]|^\"|\"$])"; 
//            $replaceWith = ""; 
//            $district_id = preg_replace($regex, $replaceWith, $district_id);
//            
//            if(is_array($district_id)){
//                $district_id = implode("','",$district_id);
//            }
        $district_name = $lng_data['dist_name'];
        
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
                    if($search_amb->amb_lat != '' && $search_amb->amb_log != ''){
                        $origins[] = trim($search_amb->amb_lat) . ',' . trim($search_amb->amb_log);
                    }
                }
            }

            $destination = $lng_data['lat'] . ',' . $lng_data['lng'];
            if ($data['ambu_data1']) {
                $origins_str = trim(implode('&', $origins));
                

                //$google_api_key = 'AIzaSyBtAZEUryIBFm-pAoQXya4TnjxrwyUIUWI';
                $google_api_key = $this->google_api_key;



               // $google_map_url = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $origins_str . '&destinations=' . $destination . '&region=in&key=' . $google_api_key;
                $google_map_url = 'https://matrix.route.ls.hereapi.com/routing/7.2/calculatematrix.json?mode=fastest;car;traffic:enabled;&start0=' . $destination . '&destination0=' . $origins_str . '&apiKey=' . $google_api_key . '&summaryAttributes=traveltime,distance';

               
                //$location_data = file_get_contents($google_map_url);
                $location_data = $this->_send_curl_request($google_map_url);
                //$location_resp =  $this->_send_curl_request($google_map_url,'','get');
                $location_data = json_decode($location_data);
                
//var_dump($location_data);
//                die();


                $ambu_data = array();

                if (!empty($location_data->origin_addresses)) {
                      
                    foreach ($location_data->origin_addresses as $key => $amb_row) {

                        $duration_value = $location_data->response->matrixEntry[$key]->summary->travelTime;

                        $ambu_data[$duration_value] = $data['ambu_data2'][$key];
                        $ambu_data[$duration_value]->assign = 'no';

                        //$ambu_data[$duration_value]->duration = $location_data->response->matrixEntry[$key]->summary->travelTime;

                        //$ambu_data[$duration_value]->duration_value = $location_data->response->matrixEntry[$key]->summary->travelTime;
                        
                         $ambu_data[$duration_value]->duration = floor($location_data->response->matrixEntry[$key]->summary->travelTime/60)." Min";

                        $ambu_data[$duration_value]->duration_value = floor($location_data->response->matrixEntry[$key]->summary->travelTime/60)." Min";

                        $ambu_data[$duration_value]->road_distance = round((($location_data->response->matrixEntry[$key]->summary->distance)/1000),2);

                        $ambu_data[$duration_value]->road_distance_value = round((($location_data->response->matrixEntry[$key]->summary->distance)/1000),2);
                        
                        
                        
                    }

                    ksort($ambu_data,SORT_NUMERIC);
                  
                    $data['ambu_data1'] = $ambu_data;
                    
                    
                }
            }
            
        }
       

        $data['ambu_data2']=array();
        if ($lng_data['lat'] != '' && $lng_data['lng'] != '') {
          

            if($this->clg->clg_group == 'UG-REMOTE' && ($this->clg->thirdparty == '3' || $this->clg->thirdparty == '4'|| $this->clg->thirdparty == '2' || $this->clg->thirdparty == '4'|| $this->clg->thirdparty == '5' || $this->clg->thirdparty == '4'|| $this->clg->thirdparty == '6')){
                if($this->clg->thirdparty != '1'){
                    $thirdparty=$this->clg->thirdparty;
                }
              $lng_data['amb_tp'] = '2,'.$lng_data['amb_tp'];
                $data['ambu_data2'] = $this->inc_model->get_am_in_inc_area($lng_data['lat'], $lng_data['lng'], $lng_data['amb_tp'], $lng_data['min_distance'], $lng_data['inc_status'],$district_id,$thirdparty,$lng_data['amb_id'],$district_name,$lng_data['base_id']);
            }
            else if ($data['inc_type'] == "DROP_BACK" && $lng_data['amb_tp']==""){
                $lng_data['amb_tp'] = '1';
                $data['ambu_data2'] = $this->inc_model->get_am_in_inc_area($lng_data['lat'], $lng_data['lng'], $lng_data['amb_tp'], $lng_data['min_distance'], $lng_data['inc_status'],'','',$lng_data['amb_id'],$district_name,$lng_data['base_id']);
                }
            else{
            $data['ambu_data2'] = $this->inc_model->get_am_in_inc_area($lng_data['lat'], $lng_data['lng'], $lng_data['amb_tp'], $lng_data['min_distance'], $lng_data['inc_status'],'','',$lng_data['amb_id'],$district_name,$lng_data['base_id']);
            }

            $origins = array();
            $cnt=0;
            
            if ($data['ambu_data2']) {
                foreach ($data['ambu_data2'] as $key => $search_amb) {
                    if($search_amb->amb_lat != 0 &&  $search_amb->amb_log != 0 ){
                        if($search_amb->amb_lat != '' &&  $search_amb->amb_log != '' ){
                            $origins[] = 'destination'.$cnt.'='.trim($search_amb->amb_lat) . ',' . trim($search_amb->amb_log);
                        }
                    }else{
                        //if($search_amb->hp_lat != '' &&  $search_amb->hp_long != '' ){
                            $origins[] = 'destination'.$cnt.'='.trim($search_amb->hp_lat) . ',' . trim($search_amb->hp_long);
                        //}
                    }
                    
                $cnt=$cnt+1; 
               
                }
            }
            

            $destination = $lng_data['lat'] . ',' . $lng_data['lng'];
            if ($data['ambu_data2']) {
                $origins_str = trim(implode('&', $origins));

                $google_api_key = $this->google_api_key;

               $google_map_url = 'https://matrix.route.ls.hereapi.com/routing/7.2/calculatematrix.json?mode=fastest;car;traffic:enabled;&start0=' . $destination . '&' . $origins_str . '&apiKey=' . $google_api_key . '&summaryAttributes=traveltime,distance';
             
            
                $location_data = file_get_contents($google_map_url);
               // $location_data = $this->_send_curl_request($google_map_url);
               
                $location_data = json_decode($location_data);
                

                $ambu_data = array();

                if ($location_data) {
                    foreach ($location_data->response->matrixEntry as $key => $amb_row) {
                       

                        $duration_value = $location_data->response->matrixEntry[$key]->summary->travelTime;
                        

                        $ambu_data[$key] = $data['ambu_data2'][$key];
                        $ambu_data[$key]->assign = 'no';
                                              
                        $ambu_data[$key]->duration = floor($location_data->response->matrixEntry[$key]->summary->travelTime/60)." Min";

                        $ambu_data[$key]->duration_value = floor($location_data->response->matrixEntry[$key]->summary->travelTime/60)." Min";

                        $ambu_data[$key]->road_distance = round((($location_data->response->matrixEntry[$key]->summary->distance)/1000),2)." Km";

                        $ambu_data[$key]->road_distance_value = round((($location_data->response->matrixEntry[$key]->summary->distance)/1000),2)." Km";
                    }

                   // ksort($ambu_data,SORT_NUMERIC);
                    $data['ambu_data2'] = $ambu_data;
 
                }else{
					 $data['ambu_data2'] = $ambu_data;
				}
            }
          
           
        } else {
            // $amb_user_type = 'tdd';
			//echo "hi";
            $data['ambu_data2'] = $this->inc_model->get_am_in_inc_area('', '', '', '', $lng_data['inc_status'], $lng_data['district_id'], '', $lng_data['amb_id'],$district_name,$lng_data['base_id']);        
			//var_dump($data['ambu_data2']);
            
        }
   
  
		     

        // $data['ambu_data'] = array_merge($data['ambu_data1'],$data['ambu_data2']);
		 $data['ambu_data'] = $data['ambu_data2'];

         $data['emso_challenge'] = $this->Dashboard_model->emso_challenge();
         
         $data['pilot_challenge'] = $this->Dashboard_model->pilot_challenge();
         $data['equipment_challenge'] = $this->Dashboard_model->equipment_challenge();
         $data['tech_challenge'] = $this->Dashboard_model->tech_challenge();
         
         $data['clg_ref_id'] = $this->clg->clg_ref_id;
         
         
        $cm_id = $lng_data['chief_complete'];
        $data['dist_code'] =  $lng_data['district_id'];
        $data['chief_comps_services'] = $this->inc_model->get_chief_comp_service($cm_id);
        $data['ct_hosp_pri_one'] = $data['chief_comps_services'][0]->ct_hosp_pri_one;
        $data['call_action'] =  $this->session->userdata('call_action');


        $this->output->add_to_position($this->load->view('frontend/inc/inc_ambu_list_view', $data, TRUE), 'inc_map_details', TRUE);
        
        $data['ct_hosp_pri_one'] = $data['chief_comps_services'][0]->ct_hosp_pri_one;
        $this->output->add_to_position($this->load->view('frontend/inc/hospital_priority_based', $data, TRUE), 'inc_one_temp_hospital', TRUE);
        
        $data['ct_hosp_pri_two'] = $data['chief_comps_services'][0]->ct_hosp_pri_two;
        $this->output->add_to_position($this->load->view('frontend/inc/hospital_priority_two_based', $data, TRUE), 'inc_two_temp_hospital', TRUE);
    }
     public function get_inc_ambu_here(){
        $lng_data = $this->input->get();
        //var_dump($lng_data); die;
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
            $amb_tp= trim(implode(',', $lng_data['amb_tp']));
            //var_dump($amb_tp); die;
            $data['ambu_data2'] = $this->inc_model->get_am_in_inc_area_here($lng_data['lat'], $lng_data['lng'], $amb_tp, $lng_data['min_distance'], $lng_data['inc_status'],$district_name);
			


            $origins = array();
            $cnt=0;
            if ($data['ambu_data2']) {
                foreach ($data['ambu_data2'] as $key => $search_amb) {
                    $origins[] = 'destination'.$cnt.'='.trim($search_amb->amb_lat) . ',' . trim($search_amb->amb_log);
               $cnt=$cnt+1; }
            }

            



            // $destination = $lng_data['lat'] . ',' . $lng_data['lng'];
            // if ($data['ambu_data2']) {
            //     $origins_str = trim(implode('&', $origins));

            //     $google_api_key = $this->google_api_key;



            //     //$google_map_url = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $origins_str . '&destinations=' . $destination . '&region=in&key=' . $google_api_key;
            //    $google_map_url = 'https://matrix.route.ls.hereapi.com/routing/7.2/calculatematrix.json?mode=fastest;car;traffic:enabled;&start0=' . $destination . '&' . $origins_str . '&apiKey=' . $google_api_key . '&summaryAttributes=traveltime,distance';
               
            //     //$location_data = file_get_contents($google_map_url);
            //     //$location_resp =  $this->_send_curl_request($google_map_url,'','get');
            //     $location_data = json_decode($location_data);
            //     // var_dump($location_data->response->matrixEntry); die;
            //     // var_dump($location_data->matrixEntry); die;


            //     $ambu_data = array();

            //     if ($location_data) {
            //         foreach ($location_data->response->matrixEntry as $key => $amb_row) {
            //             //var_dump($location_data->response->matrixEntry[$key]->summary->distance); 
                        

            //             $duration_value = $location_data->response->matrixEntry[$key]->summary->travelTime;

            //             $ambu_data[$duration_value] = $data['ambu_data2'][$key];
            //             $ambu_data[$duration_value]->assign = 'no';

            //             $ambu_data[$duration_value]->duration = $location_data->response->matrixEntry[$key]->summary->travelTime;

            //             $ambu_data[$duration_value]->duration_value = $location_data->response->matrixEntry[$key]->summary->travelTime;

            //             $ambu_data[$duration_value]->road_distance = ($location_data->response->matrixEntry[$key]->summary->distance)/1000;

            //             $ambu_data[$duration_value]->road_distance_value = ($location_data->response->matrixEntry[$key]->summary->distance)/1000;
            //         }

            //         ksort($ambu_data);
                    
            //        //die;

                   
                // }else{
				// 	 $data['ambu_data2'] = $ambu_data;
				// }
          //  }
            
        } else {
            // $amb_user_type = 'tdd';
			//echo "hi";
            $data['ambu_data2'] = $this->inc_model->get_am_in_inc_area_here($lng_data['lat'], $lng_data['lng'], $amb_tp, $lng_data['min_distance'], $lng_data['inc_status']);
			//var_dump($data['ambu_data2']);
            
        }
		//var_dump($data['ambu_data2']);die;

         $data['ambu_data'] = array_merge($data['ambu_data1'],$data['ambu_data2']);
         $data['ambu_data'] = $data['ambu_data2'];
         echo json_encode($data['ambu_data']); die;
    }
    public function get_mci_nature_service() {



        $ntr_id = $this->input->get_post('ntr_id', TRUE);

        $data['mci_nature_services'] = $this->inc_model->get_mci_nature_service($ntr_id);

        $data['cmp_service'] = $this->common_model->get_services();



        $this->output->add_to_position($this->load->view('frontend/inc/mci_service_view', $data, TRUE), 'inc_services_details', TRUE);
        
        $data['amb_type_list'] = $this->amb_model->get_amb_type();
       
      //  if ($cm_id == 52) {
            $data['ambu_type_data'] = array('3','4');
      //  }

        $data['get_reference_ambu_type'] = array();

        $this->output->add_to_position($this->load->view('frontend/inc/inc_recomended_ambu_view', $data, TRUE), 'inc_recomended_ambu', TRUE);
    }

    public function get_chief_complete_service() {


        $cm_id = $this->input->get_post('cm_id', TRUE);

        $data['chief_comps_services'] = $this->inc_model->get_chief_comp_service($cm_id);
        

        $data['clg_group'] = $clg_group= $this->clg->clg_group;

        $data['cmp_service'] = $this->common_model->get_services();

        //$data['questions'] = $this->call_model->get_questions($cm_id);

        $data['questions'] = $this->call_model->get_active_questions($cm_id);

        $this->output->add_to_position($this->load->view('frontend/inc/service_view', $data, TRUE), 'inc_services_details', TRUE);

        //var_dump($data['chief_comps_services'][0]->ct_type);
        // if (strstr($data['chief_comps_services'][0]->ct_type, "pregnancy")) { 
//if (strstr($data['chief_comps_services'][0]->ct_type, "pregnancy") || strstr($data['chief_comps_services'][0]->ct_type, "Pregnancy") || strstr($data['chief_comps_services'][0]->ct_type, "pregnant")) {
//
//        $this->output->add_to_position($this->load->view('frontend/inc/non_mci_patient_gender_view', $data, TRUE), 'non_mci_patient_gender', TRUE);
//}
      /*  $args_type = array();
        if($clg_group == 'UG-BIKE-ERO'){
            $args_type = array('ambty_id'=>"'1'");
        }
       
        if($clg_group == 'UG-ERO' &&  $this->clg->thirdparty == '1'){
             $args_type = array('ambty_id'=>"'2','3','4'");
        }
        if($clg_group == 'UG-REMOTE' || $clg_group == 'UG-Remote-ShiftManager'){
            $args_type = array('ambty_id'=>"'2','16'");
       }*/
       $data['amb_type_list'] = $this->amb_model->get_amb_type($args_type);
       /* if ($cm_id == 52 || $cm_id == 59 ) {
            //$data['ambu_type_data'] = array(3, 4);
        
            $thirdparty = $this->clg->thirdparty;
            if ($thirdparty != 1) {
                $data['ambu_type_data'] = array(2);
            }else{
                $data['ambu_type_data'] = array(3, 4);
            }
        } */
        
        $data['get_reference_ambu_type'] = array();

        $this->output->add_to_position($this->load->view('frontend/inc/inc_recomended_ambu_view', $data, TRUE), 'inc_recomended_ambu', TRUE);

        $data['ct_hosp_pri_one'] = $data['chief_comps_services'][0]->ct_hosp_pri_one;
        $this->output->add_to_position($this->load->view('frontend/inc/hospital_priority_based', $data, TRUE), 'inc_one_temp_hospital', TRUE);
        
        $data['ct_hosp_pri_two'] = $data['chief_comps_services'][0]->ct_hosp_pri_two;
        $this->output->add_to_position($this->load->view('frontend/inc/hospital_priority_two_based', $data, TRUE), 'inc_two_temp_hospital', TRUE);
        
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
        $clg_group =  $this->clg->clg_group;
       
        $amb_type = $this->input->post('amb_type');
        $ques_result = array();

        foreach ($ques_ans as $key => $ques) {

            $ques_result[] = $key . ":" . $ques;
        }

        $amb_ans = implode(',', $ques_result);



        $ambu_type_ques = $this->call_model->get_cm_ambu_type($ct_id, $amb_ans);

        $data['ambu_type'] = $this->call_model->get_cm_ambu_type($ct_id, $amb_ans);
        
        $rec_ambu_type = $data['ambu_type']->ambu_type;
       // $rec_ambu_type = '1';
        $data['rec_ambu_type'] = $rec_ambu_type;
        

        if (!empty($amb_type)) {

            if (!in_array($rec_ambu_type, $amb_type)) {

                array_push($amb_type, $rec_ambu_type);
            }
            $data['ambu_type_data'] = $amb_type;
        } else {
            $data['ambu_type_data'][] = $data['ambu_type']->ambu_type;
        }
        if($this->session->userdata('cl_purpose')=='IN_HO_P_TR'){
            $data['ambu_type_data'] = array('2','3');
        }
        if($this->session->userdata('cl_purpose')=='PICK_UP'){
            $data['ambu_type_data'] = array('1','2','3');
        }
        if($this->session->userdata('cl_purpose')=='DROP_BACK'){
            $data['ambu_type_data'] = array('1');
        }
       // $data['ambu_type_data'] = array('3','2','1');
       // var_dump($data['ambu_type_data']);die();
        /*if ($ct_id == 52 || $ct_id == 59 ) {
            $thirdparty = $this->clg->thirdparty;
            if ($thirdparty != 1) {
                $data['ambu_type_data'] = array(2);
            }else{
                $data['ambu_type_data'] = array(3, 4);
            }
        }
        
        if($clg_group=='UG-BIKE-ERO'){
            $data['ambu_type_data'] = array(1);
        }
        $args_type = array();
        if($clg_group == 'UG-BIKE-ERO'){
            $args_type = array('ambty_id'=>"'1'");
        }
        
        if($clg_group == 'UG-ERO' &&  $this->clg->thirdparty == '1'){
             $args_type = array('ambty_id'=>"'2','3','4','14','8','11','16'");
        }
        if($clg_group == 'UG-REMOTE' || $clg_group == 'UG-Remote-ShiftManager'){
            $args_type = array('ambty_id'=>"'2','16'");
       }
       $amb_type_args = array();
       if($clg_group == 'UG-ERO' ){
             $amb_type_args['not_ambty_id'] = array('1');
        } */
       
        $data['amb_type_list'] = $this->amb_model->get_amb_type($amb_type_args);


        $data_amb_level = $this->amb_model->get_amb_type_level_by_id($data['ambu_type_data'][0]);
        $data['amb_level'] = $data_amb_level[0]->ambu_level;

        
        $this->output->add_to_position($this->load->view('frontend/inc/ambu_type_view', $data, TRUE), 'inc_ambu_type_details', TRUE);
        
        $data['get_reference_ambu_type'] = $this->call_model->get_reference_ambu_type($rec_ambu_type);
       
        $this->output->add_to_position($this->load->view('frontend/inc/inc_recomended_ambu_view', $data, TRUE), 'inc_recomended_ambu', TRUE);
    }

    public function get_facility_details() {

        $data = array();

        $get_data = $this->input->get();

        $hp_id = $this->input->get_post('hp_id', TRUE);

        $data['hospital'] = $this->hp_model->get_hp_data1(array('hp_id' => $hp_id));
       if ($get_data['facility'] == 'new') {

            $this->session->set_userdata('new_hospital', $data['hospital']);

            $this->output->add_to_position($this->load->view('frontend/in_hos/facility_details_view_new', $data, TRUE), 'new_facility_details', TRUE);
           
            
        } else {

            $this->session->set_userdata('hospital', $data['hospital']);
            $this->output->add_to_position($this->load->view('frontend/in_hos/facility_details_view', $data, TRUE), 'facility_details', TRUE);
           
           
             
        }
    }

    public function get_facility_details_new() {

        $data = array();

        $get_data = $this->input->get();

        $hp_id = $this->input->get_post('hp_id', TRUE);

        $data['hospital'] = $this->hp_model->get_hp_data1_new(array('hp_id' => $hp_id));
       if ($get_data['facility'] == 'new') {

            $this->session->set_userdata('new_hospital', $data['hospital']);

            $this->output->add_to_position($this->load->view('frontend/in_hos/facility_details_view_new1', $data, TRUE), 'new_facility_details', TRUE);
           
            
        } else {

            $this->session->set_userdata('hospital', $data['hospital']);
            $this->output->add_to_position($this->load->view('frontend/in_hos/facility_details_view1', $data, TRUE), 'facility_details', TRUE);
           
           
             
        }
    }
    function show_selected_hospital(){
        
        $hp_id = $this->input->get_post('hp_id', TRUE);
        $hospital = $this->hp_model->get_hp_data1(array('hp_id' => $hp_id));
        $data['hospital'] = $hospital[0];
        $this->output->add_to_position($this->load->view('frontend/inc/hospital_selected_view', $data, TRUE), 'inc_temp_hospital', TRUE);
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
        $datetime = $this->session->userdata('inc_datetime');

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
        
        $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_id));
        if(!empty($is_exits)){
            $this->session->set_userdata('inc_ref_id','');
            $this->output->message = "<div class='error'>Incident Id alredy exists</div>";
            return;
        }

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

        if($inter_hos_details['incient_districts'] == '')
                {
                    $district = $inter_hos_details['incient_district'];
                }else{
                    $district = $inter_hos_details['incient_districts'];
                }
            //$inc_re_id = $inc_id . '-' . $amb_count;
            $inc_re_id = $inc_id;
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
                'inc_tahshil_id' => $inter_hos_details['incient_tahsil'],
                
                'inc_address' => $inc_details['place'],
                'inc_district_id' => $district,
                'inc_div_id' => $inc_details['incient_division'],
                'inc_area' => $inc_details['area'],
                'inc_landmark' => $inc_details['landmark'],
                'inc_lane' => $inter_hos['lane'],
                'inc_h_no' => $inter_hos['h_no'],
                'inc_pincode' => $inter_hos['pincode'],
                'inc_lat' => $inter_hos['lat'],
                'inc_long' => $inter_hos['lng'],
                'destination_hospital_id' => $inc_details['hospital_id'],
                
                'destination_hospital_other' => $inc_details['hospital_other'],
                'inc_datetime' => $datetime,
                'inc_dispatch_time' => $inter_hos['caller_dis_timer'],
                'inc_base_month' => $this->post['base_month'],
                'ptn_condition' => $condition,
                'inc_set_amb' => '1',
                'inc_recive_time' => $inter_hos['inc_recive_time'],
                'inc_added_by' => $this->clg->clg_ref_id,
                'inc_wht_three_wrd' => $inc_details['3word'],
'bk_inc_ref_id' => $inc_re_id,
'inc_thirdparty' => $this->clg->thirdparty,
                'inc_system_type' => $system
            );

            if ($inter_hos['chief_complete'] != '') {
                $incidence_details['inc_complaint'] = $inter_hos['chief_complete'];
            }
            if ($call_type_terminate == 'terminate') {
                $incidence_details['incis_deleted'] = '2';
            }
            if ($inter_hos['chief_complete_other'] != '') {
                $incidence_details['inc_complaint_other'] = $inter_hos['chief_complete_other'];
            }
            if ($post_data['termination_reason'] != '') {
                $incidence_details['termination_reason'] = $post_data['termination_reason'];
            }
            if ($post_data['termination_reason_other'] != '') {
                $incidence_details['termination_reason_other'] = $post_data['termination_reason_other'];
            }
            
            if($inter_hos['new_facility'] != ''){
                $incidence_details['hospital_id'] = $inter_hos['new_facility'];
                $priority_hospital = get_hospital_by_id($inter_hos['new_facility']);
                $district_hospital = $priority_hospital[0]->hp_district;
                $hosp_type = get_hosp_type_by_id($priority_hospital[0]->hp_type);
                $incidence_details['hospital_type'] = $hosp_type;
                $incidence_details['hospital_district'] = $district_hospital;
            }
            
            if($inc_details['hospital_id'] != ''){
                 $pri_hospital_data = get_hospital_by_id($inter_hos['new_facility']);
                 $hospital_name = $pri_hospital_data[0]->hp_name;
                 $pri_hosp_lat = $pri_hospital_data[0]->hp_lat;
                 $pri_hosp_lng = $pri_hospital_data[0]->hp_long;
            }else{
                 $pri_hospital_data = get_hospital_by_id($inter_hos['new_facility']);
                 $hospital_name = $pri_hospital_data[0]->hp_name;
                 $pri_hosp_lat = $pri_hospital_data[0]->hp_lat;
                 $pri_hosp_lng = $pri_hospital_data[0]->hp_long;
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

            $amb_details = $this->inc_model->get_ambulance_details_API($inter_hos['amb_id']);
            $amb_lat = $amb_details[0]->amb_lat;
            $amb_log = $amb_details[0]->amb_log;
            $thirdparty = $amb_details[0]->thirdparty;
            $ward_id = $amb_details[0]->ward_id;
            $ward_name = $amb_details[0]->ward_name;
            $hp_id = $amb_details[0]->hp_id;
            $hp_name = $amb_details[0]->hp_name;

            $incidence_amb_details = array('amb_rto_register_no' => $inter_hos['amb_id'],
                'inc_ref_id' => $inc_re_id,
                'ward_id' => $ward_id,
                'ward_name' => $ward_name,
                'base_location_id' => $hp_id,
                'base_location_name' => $hp_name,
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
                if ((ucfirst($patient['middle_name']) != '') || (ucfirst($patient['first_name']) != '') || (ucfirst($patient['last_name']) != '')) {


                    //$last_insert_pat_id = $this->pet_model->last_insert_pat_id();
                    //$last_pat_id = $last_insert_pat_id[0]->p_id + 1;
                    $last_pat_id = generate_ptn_id();

                    $inter_patient_details = array('ptn_fname' => ucfirst($patient['first_name']),
                        'ptn_mname' => ucfirst($patient['middle_name']),
                        'ptn_lname' => ucfirst($patient['last_name']),
                        'ptn_gender' => $patient['gender'],
                        'ptn_age' => $patient['age'],
                        'ptn_birth_date' => $patient['dob'],
                        'ptn_age_type' => $patient['age_type'],
                        'ayushman_id' => $patient['ayu_id'],
                        'ptn_mob_no' => $patient['ptn_mob_no'],
                        'ptn_bgroup' => $patient['blood_gp'],
                        //'ptn_type'   => '3'
                        'ptn_condition' => $condition,
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s'),
                    );

                    $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);

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
            
            $denial_id = $this->session->userdata('denial_id');
            if($denial_id){
                foreach($denial_id as $denial){
                    $com_args = array('inc_ref_id'=>$inc_re_id,'id'=>$denial);
                    $update_app_call_details = $this->Dashboard_model->update_denial($com_args);

                } 
            }
        }
        $api_url = "http://localhost/JAEms/api/googlenotification";
		$json_data = array('ambulanceNo'=>$inc_details['amb_id'],
						   'incidentId'=>$inc_id,
						   'cheifComplaint' => get_cheif_complaint($inc_details['chief_complete']));

        $json_data= json_encode($json_data);
                
        $api_google = api_notification_app($api_url,$json_data);
        
        $comm_api_url = "http://localhost/JAEms/communityapp/googlenotification";
		$json_data = array('userMobileNo'=>$caller_details['clr_mobile'],
                           'ambulanceNo'=>$inc_details['amb_id'],
						   'incidentId'=>$inc_id,
						   'cheifComplaint' => get_cheif_complaint($inter_hos['chief_complete']));

        $json_data= json_encode($json_data);
                
        $api_google = api_notification_app($comm_api_url,$json_data);
        $this->call_model->update_booking_details($inc_details['user_req_id']);
        if($inter_hos['new_facility'] != ''){
            $pri_hospital_data = get_hospital_by_id($inter_hos['new_facility']);
            $pri_hosp_name = $pri_hospital_data[0]->hp_name;
            $pri_hosp_lat = $pri_hospital_data[0]->hp_lat;
            $pri_hosp_lng = $pri_hospital_data[0]->hp_long;
        }else{
            $pri_hospital_data = get_hospital_by_id($inter_hos['new_facility']);
            $pri_hosp_name = $pri_hospital_data[0]->hp_name;
            $pri_hosp_lat = $pri_hospital_data[0]->hp_lat;
            $pri_hosp_lng = $pri_hospital_data[0]->hp_long;
        }
        $caller_loc = $inc_details['place'];
        $caller_lat = $inc_details['lat'];
        $caller_lng = $inc_details['lng'];
        $destination_hos =  $pri_hosp_name;
        $hos_lat = $pri_hosp_lat;
        $hos_lng = $pri_hosp_lng;
        $select_amb_API= str_replace('-','',$inter_hos['amb_id']);
        //$select_amb = implode('',(explode("-",$inc_details['amb_id'])));
        $args = array(
            'LastActivityTime' => "$datetime" ,
            'JobStatus' => 'Dispatched' ,
            'onRoadStatus' =>'1' ,
            'Caller_Location' => "$caller_loc",
            'Hospital_Location' => "$destination_hos",
            'JobNo' => "$inc_id",
            'HospitalLatlong' => "$hos_lat".','."$hos_lng",
            'stateCode' => 'MP',
            'AmbulanceNo' =>"$select_amb_API",
            'CallerLatlong' =>"$caller_lat".','."$caller_lng"
        );
        $send_API = send_API($args);
        //update_inc_ref_id($inc_id);

        //update_inc_ref_id($inc_id);

        /* send sms to patient  */

        $sms_amb = $inter_hos['amb_id'];

        $get_mobile_no = array('rg_no' => $sms_amb);
        $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);

        $driver = $this->colleagues_model->get_user_info($pilot);

        $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;

        $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;

        // $amb_url =  "http://localhost/JAEms/amb/loc/" . $inc_re_id;

        $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_id;

        //$amb_url = "http://210.212.165.123/tdd/amb/loc/" . $inc_id;
        //$amb_dir_url = "http://210.212.165.123/tdd/amb/amb_dir/" . $inc_id;


        $doctor = $this->colleagues_model->get_user_info($EMT);

        $sms_doctor = $doctor[0]->clg_first_name;

        $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;
        $str = ltrim($sms_doctor_contact_no, '0');
        $sms_doctor_contact_no = ltrim($sms_doctor_contact_no, '0');
        //$patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
        $patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];
        $patient_mobile_no = $caller_details['clr_mobile'];
        // $patient_mobile_no = "9730015484";
        $patient_name = ucfirst($patient['first_name']);
        if($patient_full_name == ' '){
            $patient_full_name ='Unknown';
           }
         $sms_amb1 = implode('',(explode("-",$sms_amb)));
         $txtMsg1 = '';
         $txtMsg1.= "Dear ".$patient_full_name.", \n";
         $txtMsg1.= "Ambulance dispatched: ".$sms_amb1 .", \n";
         $txtMsg1.= "Ambulance Contact: ".$sms_doctor_contact_no .", \n" ;
         //$txtMsg1.= "Link: ".$amb_dir_url."\n" ;
         $txtMsg1 .= "Please click on the following link for downloading the 108 Sanjeevani app on your mobile Android User - https://tinyurl.com/2p87kfu6 and iOS User- https://tinyurl.com/3pup8pp4\n";
         $txtMsg1.= "JAES" ;
        $sms_to = $caller_details['clr_mobile'];
        $args = array(
            'msg' => $txtMsg1,
            'mob_no' => $sms_to,
            'sms_user'=>'patient',
            'inc_id'=>$inc_id,
        );
        
       $sms_data = sms_send($args); 
       $mno = $caller_details['clr_mobile'];
        $mno = substr($mno, -10);
        $inc_link_args = array( 'mobile_no'=>$mno,
                                'incident_id'=>$inc_id,
                                'track_link'=>$amb_dir_url,
                                'added_date' =>   date('Y-m-d H:i:s'));
        
        $inc_link = $this->call_model->insert_track_link($inc_link_args); 
     
      


        /* send sms to doctor  */
        //$chief_complaint = get_cheif_complaint($inter_hos['chief_complete']);
        $Chief_Complaint_extra_length = array('32','4','15','89','92','50');
        if(in_array($inter_hos['inc_complaint'],$Chief_Complaint_extra_length))
        {
            if($inter_hos['inc_complaint']==32)
            {
                $chief_complaint = 'Child/Pediatric Patient';
            }
            if($inter_hos['inc_complaint']==4)
            {
                $chief_complaint = 'Altered Mental Status';
            }
            if($inter_hos['inc_complaint']==15)
            {
                $chief_complaint = 'Lightning Strike';
            }
            if($inter_hos['inc_complaint']==89 || $incidence_details['inc_complaint']==89 )
            {
                $chief_complaint = 'Children/Infacts/Newborn sick';
            }
            if($inter_hos['inc_complaint']==50)
            {
                $chief_complaint = 'Unconscious Patient';
            }
        }else{
            $chief_complaint = get_cheif_complaint($inter_hos['inc_complaint']);
        }
        // $hospital_name = $inc_details['hos_name'];
        $inc_address = $inc_details['place'];
        $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
       // $patient_name = $caller_details['clr_fname'];
       if($inter_hos['new_facility'] != ''){
        $pri_hospital_data = get_hospital_by_id($inter_hos['new_facility']);
        $pri_hosp_name = $pri_hospital_data[0]->hp_name;
        $pri_hosp_lat = $pri_hospital_data[0]->hp_lat;
        $pri_hosp_lng = $pri_hospital_data[0]->hp_long;
    }else{
        $pri_hospital_data = get_hospital_by_id($inter_hos['new_facility']);
        $pri_hosp_name = $pri_hospital_data[0]->hp_name;
        $pri_hosp_lat = $pri_hospital_data[0]->hp_lat;
        $pri_hosp_lng = $pri_hospital_data[0]->hp_long;
    }
       $datetime = date('d-m-Y H:i:s');
       $txtMsg2 ='';
       $txtMsg2.= "Patient name: ".$patient_full_name.",\n"; 
       $txtMsg2.= " Address: ".$inc_address.",\n";
       $txtMsg2.= " Caller No: ".$patient_mobile_no.",\n";
       $txtMsg2.= " Incident Date Time: ".$datetime.",\n";
       $txtMsg2.= " Incident id: ".$inc_id.",\n";
       $txtMsg2.= " Chief Complaint: ".$chief_complaint.",\n";
       $txtMsg2.= " Hospital Name- ".$pri_hosp_name.",\n";
       $txtMsg2.= " JAES" ;
  
    $sms_to = $sms_doctor_contact_no;
    $args = array(
        'msg' => $txtMsg2,
        'mob_no' => $sms_to,
        'sms_user'=>'EMT',
        'inc_id'=>$inc_id,
    );
    $sms_data = sms_send($args);
    
        $sms_pilot_contact_no = $get_driver_no[0]->amb_pilot_mobile; 
        $sms_pilot_contact_no = ltrim($sms_pilot_contact_no, '0');


        $patient_name = $caller_details['clr_fname'];
        $datetime = date('d-m-Y H:i:s');
        $txtMsg2 ='';
        $txtMsg2.= "Patient name: ".$patient_full_name.",\n"; 
        $txtMsg2.= " Address: ".$inc_address.",\n";
        $txtMsg2.= " Caller No: ".$patient_mobile_no.",\n";
        $txtMsg2.= " Incident Date Time: ".$datetime.",\n";
        $txtMsg2.= " Incident id: ".$inc_id.",\n";
        $txtMsg2.= " Chief Complaint: ".$chief_complaint.",\n";
        $txtMsg2.= " Hospital Name- ".$pri_hosp_name.",\n";
        $txtMsg2.= " JAES" ;
      
        $sms_to_pilot = $sms_pilot_contact_no;
        $args = array(
            'msg' => $txtMsg2,
            'mob_no' => $sms_to_pilot,
            'sms_user'=>'Pilot',
            'inc_id'=>$inc_id,
        );
        $sms_data = sms_send($args);
        
        $mno = $caller_details['clr_mobile'];
        $mno = substr($sms_to_pilot, -10);
        $inc_link_args = array( 'mobile_no'=>$mno,
                                'incident_id'=>$inc_re_id,
                                'track_link'=>$amb_url,
                                'added_date' =>   date('Y-m-d H:i:s'));
        
        $inc_link = $this->call_model->insert_track_link($inc_link_args);
       
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

        //die();
        if($inc_data){
            
            $url = base_url("calls");
            $this->output->message = "<h3>Inter Hospital transfer Call</h3><br><p>Ambulance $msg Successfully</p><script>window.location.href = '".$url."';</script>";


            $this->output->moveto = 'top';

            $this->output->add_to_position('', 'content', TRUE);
        }else{
            $this->output->message = "<div class='error'>Error! Something went wrong please check...</div>";
        }
    }
    
    public function save_inter_terminated() {

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
        $datetime = $this->session->userdata('inc_datetime');

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
        
        $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_id));
        if(!empty($is_exits)){
            $this->session->set_userdata('inc_ref_id','');
            $this->output->message = "<div class='error'>Incident Id alredy exists</div>";
            return;
        }

        $call_type_terminate = $this->input->post('call_type');
        $amb_count = 0;

            $inter_hos['amb_id'] = $inc_details['amb_id'];

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

        if($inter_hos_details['incient_districts'] == '')
                {
                    $district = $inter_hos_details['incient_district'];
                }else{
                    $district = $inter_hos_details['incient_districts'];
                }
            //$inc_re_id = $inc_id . '-' . $amb_count;
            $inc_re_id = $inc_id;
            
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
                'inc_district_id' => $district,
                'inc_area' => $inter_hos['area'],
                'inc_landmark' => $inter_hos['landmark'],
                'inc_lane' => $inter_hos['lane'],
                'inc_h_no' => $inter_hos['h_no'],
                'inc_pincode' => $inter_hos['pincode'],
                'inc_lat' => $inter_hos['lat'],
                'inc_long' => $inter_hos['lng'],
                'destination_hospital_id' => $inc_details['hospital_id'],
                'destination_hospital_other' => $inc_details['hospital_other'],
                'inc_datetime' => $datetime,
                'inc_dispatch_time' => $inter_hos['caller_dis_timer'],
                'inc_base_month' => $this->post['base_month'],
                'ptn_condition' => $condition,
                'inc_set_amb' => '1',
                'inc_recive_time' => $inter_hos['inc_recive_time'],
                'inc_added_by' => $this->clg->clg_ref_id,
                'inc_wht_three_wrd' => $inc_details['3word'],
'bk_inc_ref_id' => $inc_re_id,
'inc_thirdparty' => $this->clg->thirdparty,
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

            $amb_details = $this->inc_model->get_ambulance_details_API($inter_hos['amb_id']);
            $amb_lat = $amb_details[0]->amb_lat;
            $amb_log = $amb_details[0]->amb_log;
            $thirdparty = $amb_details[0]->thirdparty;
            $ward_id = $amb_details[0]->ward_id;
            $ward_name = $amb_details[0]->ward_name;
            $hp_id = $amb_details[0]->hp_id;
            $hp_name = $amb_details[0]->hp_name;

            $incidence_amb_details = array('amb_rto_register_no' => $inter_hos['amb_id'],
                'inc_ref_id' => $inc_re_id,
                'ward_id' => $ward_id,
                'ward_name' => $ward_name,
                'base_location_id' => $hp_id,
                'base_location_name' => $hp_name,
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
                if ((ucfirst($patient['middle_name']) != '') || (ucfirst($patient['first_name']) != '') || (ucfirst($patient['last_name']) != '')) {


                    $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
                    $last_pat_id = $last_insert_pat_id[0]->p_id + 1;
                    //$last_pat_id = $this->clg->clg_id.'_'.$last_pat_id;
                     $last_pat_id = generate_ptn_id();

                    $inter_patient_details = array('ptn_fname' => ucfirst($patient['first_name']),
                        'ptn_mname' => ucfirst($patient['middle_name']),
                        'ptn_lname' => ucfirst($patient['last_name']),
                        'ptn_gender' => $patient['gender'],
                        'ptn_age' => $patient['age'],
                        'ayushman_id' => $patient['ayu_id'],
                        'ptn_mob_no' => $patient['ptn_mob_no'],
                        'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_birth_date' => $patient['dob'],
                        //'ptn_type'   => '3'
                        'ptn_condition' => $condition,
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s'),
                    );

                    $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);

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

        if($inc_data){
            $url = base_url("calls");
            $this->output->message = "<h3>Inter Hospital transfer Call</h3><br><p>Ambulance $msg Successfully</p><script> window.location.href = '".$url."';</script>";


            $this->output->moveto = 'top';

            $this->output->add_to_position('', 'content', TRUE);
        }else{
            $this->output->message = "<div class='error'>Error! Something went wrong please check...</div>";
        }
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
    function confirm_mci_save_followup(){
        $this->session->unset_userdata('mic_details');
        $this->session->unset_userdata('call_type');

        $call_type = $this->input->get();
        $inc_post_details = $this->input->post();

        $inc_details = $this->input->get_post('incient');
        $patient = $this->input->get_post('patient');
        
        $datetime = date('Y-m-d H:i:s');
        $datetime = $this->session->userdata('inc_datetime');


        $call_id = $this->input->get_post('call_id');

//        $inc_id = $this->session->userdata('inc_ref_id');
//        if ($inc_id == '') {
//            $inc_id = generate_inc_ref_id();
//            $this->session->set_userdata('inc_ref_id', $inc_id);
//            update_inc_ref_id($inc_id);
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


        $this->session->set_userdata('mic_details', $inc_details);
        $this->session->set_userdata('call_type', $call_type);
        $this->session->set_userdata('call_id', $call_id);
        $this->session->set_userdata('inc_post_details', $inc_post_details);
        $this->session->set_userdata('patient', $patient);
        $this->session->set_userdata('inc_datetime', $datetime);


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
        $session_caller_details = $this->session->userdata('caller_details_data');
        $data['caller_details'] = $session_caller_details;

        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];
        $data['inc_details'] = $inc_details;

        $data['place'] = $inc_details['place'];

        $data['cl_type'] = $call_type;
        $data['inc_datetime'] = $datetime;

        $this->output->add_to_popup($this->load->view('frontend/inc/followup_mci_view', $data, TRUE), '600', '600');
   
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

        $datetime = date('Y-m-d H:i:s');
        
        /*if($inc_details['inc_datetime'] != ''){
             $datetime =$inc_details['inc_datetime'];
        }else{
            $datetime = date('Y-m-d H:i:s');
        }*/
        
        $this->session->set_userdata('mic_details', $inc_details);
        $this->session->set_userdata('call_type', $call_type);
        $this->session->set_userdata('call_id', $call_id);
        $this->session->set_userdata('inc_post_details', $inc_post_details);
        $this->session->set_userdata('patient', $patient);
        $this->session->set_userdata('inc_datetime', $datetime);

        $dup_inc = $inc_details['dup_inc'];

        $inc_id = $this->session->userdata('inc_ref_id');

//        if ($inc_id == '') {
//            $inc_id = generate_inc_ref_id();
//            $this->session->set_userdata('inc_ref_id', $inc_id);
//            update_inc_ref_id($inc_id);
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
        $data['inc_details'] = $inc_details;
        $data['hospital_id'] = $inc_details['hospital_id'];
        $data['hospital_other'] = $inc_details['hospital_other'];
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
        $session_caller_details = $this->session->userdata('caller_details_data');
        $data['caller_details'] = $session_caller_details;

        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];

        $data['place'] = $inc_details['place'];

        $data['cl_type'] = $call_type;
        $data['inc_datetime'] = $datetime;

        $this->output->add_to_popup($this->load->view('frontend/inc/confirm_mci_view', $data, TRUE), '600', '600');
    }

    function confirm_non_mci_save() {

        $this->session->unset_userdata('mic_details');
        $this->session->unset_userdata('call_type');

        $call_type = $this->input->get();
        $inc_post_details = $this->input->post();
       
       // var_dump($inc_post_details);die();
        $inc_details = $this->input->get_post('incient');
        $patient = $this->input->get_post('patient');
        $caller_details = $this->input->get_post('caller');
        $call_type = $this->input->get_post('call_type');
       
       
        

        $dup_inc = $inc_details['dup_inc'];
        $datetime = date('Y-m-d H:i:s');
        /*if($inc_details['inc_datetime'] != ''){
             $datetime =$inc_details['inc_datetime'];
        }else{
            $datetime = date('Y-m-d H:i:s');
        }*/

        $call_id = $this->input->get_post('call_id');
        $this->session->set_userdata('mic_details', $inc_details);
        $this->session->set_userdata('call_type', $call_type);
        $this->session->set_userdata('call_id', $call_id);
        $this->session->set_userdata('patient', $patient);
        $this->session->set_userdata('inc_datetime', $datetime);



        $session_caller_details = $this->session->userdata('caller_details_data');


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
        if ($inc_id == '' && $this->clg->clg_group != 'UG-BIKE-ERO') {
            $inc_id = generate_inc_ref_id();
            $this->session->set_userdata('inc_ref_id', $inc_id);
            update_inc_ref_id($inc_id);
            
        }else if($this->clg->clg_group == 'UG-BIKE-ERO'){
                 $inc_id = "BK-".generate_bk_inc_ref_id();
                 $this->session->set_userdata('inc_ref_id', $inc_id);
                update_inc_ref_id($inc_id);
        }
        //var_dump($inc_id);
        //  die();

        $data['inc_ref_id'] = $inc_id;
        $data['patient'] = $patient;

        $data['get_amb_details'] = $get_amb_details;
        $data['inc_details'] = $inc_details;


        $data['caller_details'] = $session_caller_details;
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];
        $data['hospital_id'] = $inc_details['hospital_id'];
        $data['hospital_other'] = $inc_details['hospital_other'];
        $data['place'] = $inc_details['place'];

        $data['cl_type'] = $call_type;
        $data['inc_datetime'] = $datetime;

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
        
        $datetime = date('Y-m-d H:i:s');
        $datetime = $this->session->userdata('inc_datetime');

                
         if($inc_details['amb_id'] != ''){
 
            $this->output->message = "<div class='error'>Remove Ambulance Selected ambulance</div>";
            return;
          
        }

        $call_id = $this->input->get_post('call_id');
        
        $this->session->unset_userdata('inc_ref_id');
        $inc_id = $this->session->userdata('inc_ref_id');

        
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


        $this->session->set_userdata('mic_details', $inc_details);
        $this->session->set_userdata('call_type', $call_type);
        $this->session->set_userdata('call_id', $call_id);
        $this->session->set_userdata('inc_post_details', $inc_post_details);
        $this->session->set_userdata('patient', $patient);
        $this->session->set_userdata('inc_datetime', $datetime);


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
        $session_caller_details = $this->session->userdata('caller_details_data');
        $data['caller_details'] = $session_caller_details;

        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];
        $data['inc_details'] = $inc_details;

        $data['place'] = $inc_details['place'];

        $data['cl_type'] = $call_type;
        $data['inc_datetime'] = $datetime;

        $this->output->add_to_popup($this->load->view('frontend/inc/terminate_mci_view', $data, TRUE), '600', '600');
    }
    function confirm_non_mci_followup(){
        $this->session->unset_userdata('mic_details');
        $this->session->unset_userdata('call_type');

        $call_type = $this->input->get();
        $inc_post_details = $this->input->post();

        $inc_details = $this->input->get_post('incient');
        $patient = $this->input->get_post('patient');

        $dup_inc = $inc_details['dup_inc'];
        $datetime = date('Y-m-d H:i:s');
        //$datetime = $this->session->set_userdata('inc_datetime',$datetime);
        
        $this->session->unset_userdata('inc_ref_id');
        $inc_id = $this->session->userdata('inc_ref_id');

        if ($inc_id == '' && $this->clg->clg_group != 'UG-BIKE-ERO') {
            $inc_id = generate_inc_ref_id();
            $this->session->set_userdata('inc_ref_id', $inc_id);
            update_inc_ref_id($inc_id);
            
        }else if($this->clg->clg_group == 'UG-BIKE-ERO'){
                 $inc_id = "BK-".generate_bk_inc_ref_id();
                 $this->session->set_userdata('inc_ref_id', $inc_id);
                update_inc_ref_id($inc_id);
        }

        $call_id = $this->input->get_post('call_id');
        $this->session->set_userdata('mic_details', $inc_details);
        $this->session->set_userdata('call_type', $call_type);
        $this->session->set_userdata('call_id', $call_id);
        $this->session->set_userdata('patient', $patient);

        $this->session->set_userdata('inc_post_details', $inc_post_details);
        $this->session->set_userdata('inc_datetime', $datetime);


        $data['nature'] = $this->inc_model->get_chief_comp_service($inc_details['chief_complete']);


        if ($inc_details["amb_id"]) {

            foreach ($inc_details["amb_id"] as $amb) {

                $args = array(
                    'rg_no' => $amb,
                );



                $get_amb_details[] = $this->inc_model->get_amb_details($args);
            }
        }
        $session_caller_details = $this->session->userdata('caller_details_data');
        $data['caller_details'] = $session_caller_details;

        $data['patient'] = $patient;
        $data['get_amb_details'] = $get_amb_details;
        $data['inc_ref_id'] = $inc_id;
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];
        $data['hospital_id'] = $inc_details['hospital_id'];
        $data['hospital_other'] = $inc_details['hospital_other'];
        $data['place'] = $inc_details['place'];
        $data['cl_type'] = $call_type;
        $data['inc_datetime'] = $datetime;
        
        $this->output->add_to_popup($this->load->view('frontend/inc/followup_non_mci_view', $data, TRUE), '600', '560');

        
     
    }
    function confirm_non_mci_terminate() {

        $this->session->unset_userdata('mic_details');
        $this->session->unset_userdata('call_type');

        $call_type = $this->input->get();
        $inc_post_details = $this->input->post();
        
        if($inc_post_details['incient']['amb_id'] != ''){
 
            $this->output->message = "<div class='error'>Remove Ambulance OR Select Another Ambulance</div>";
            return;
          
        }

        $inc_details = $this->input->get_post('incient');
        $patient = $this->input->get_post('patient');

        $dup_inc = $inc_details['dup_inc'];
        $datetime = date('Y-m-d H:i:s');
        $datetime = $this->session->userdata('inc_datetime');

        $inc_id = $this->session->userdata('inc_ref_id');
//        if ($inc_id == '') {
//            $inc_id = generate_inc_ref_id();
//            $this->session->set_userdata('inc_ref_id', $inc_id);
//            update_inc_ref_id($inc_id);
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

        $call_id = $this->input->get_post('call_id');
        $this->session->set_userdata('mic_details', $inc_details);
        $this->session->set_userdata('call_type', $call_type);
        $this->session->set_userdata('call_id', $call_id);
        $this->session->set_userdata('patient', $patient);

        $this->session->set_userdata('inc_post_details', $inc_post_details);
        $this->session->set_userdata('inc_datetime', $datetime);

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
        $session_caller_details = $this->session->userdata('caller_details_data');
        $data['caller_details'] = $session_caller_details;

        $data['patient'] = $patient;
        $data['get_amb_details'] = $get_amb_details;
        $data['inc_ref_id'] = $inc_id;
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];
        $data['hospital_id'] = $inc_details['hospital_id'];
        $data['hospital_other'] = $inc_details['hospital_other'];
        $data['place'] = $inc_details['place'];
        $data['cl_type'] = $call_type;
        $data['inc_datetime'] = $datetime;
        
        $this->output->add_to_popup($this->load->view('frontend/inc/terminate_non_mci_view', $data, TRUE), '600', '560');

        //   $this->output->add_to_position($this->load->view('frontend/patient/pt_inc_summary_view', $data, TRUE), 'summary_div', TRUE);
    }

    function app_confirm_save() {
        $this->session->unset_userdata('mic_details');
        $this->session->unset_userdata('call_type');

        // $call_type = $this->input->get();
        $inc_post_details = $this->input->post();
       
        $inc_details = $this->input->get_post('incient');
        $patient = $this->input->get_post('patient');
        $caller_details = $this->input->get_post('caller');
        $call_type = $inc_details['inc_type'];
        // print_r($call_type);die();
        if($inc_post_details['incient']['amb_id'] != ''){
 
            $this->output->message = "<div class='error'>Remove Ambulance OR Select Another Ambulance</div>";
            return;
          
        }

       
        $patient = $this->input->get_post('patient');

        $dup_inc = $inc_details['dup_inc'];
        $datetime = date('Y-m-d H:i:s');
        $datetime = $this->session->userdata('inc_datetime');

        $inc_id = $this->session->userdata('inc_ref_id');
//        if ($inc_id == '') {
//            $inc_id = generate_inc_ref_id();
//            $this->session->set_userdata('inc_ref_id', $inc_id);
//            update_inc_ref_id($inc_id);
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

        $call_id = $this->input->get_post('call_id');
        $this->session->set_userdata('mic_details', $inc_details);
        $this->session->set_userdata('call_type', $call_type);
        $this->session->set_userdata('call_id', $call_id);
        $this->session->set_userdata('patient', $patient);
        $this->session->set_userdata('inc_post_details', $inc_post_details);
        $this->session->set_userdata('inc_datetime', $datetime);
        $data['nature'] = $this->inc_model->get_chief_comp_service($inc_details['chief_complete']);

        if ($inc_details["amb_id"]) {

            foreach ($inc_details["amb_id"] as $amb) {

                $args = array(
                    'rg_no' => $amb,
                );



                $get_amb_details[] = $this->inc_model->get_amb_details($args);
            }
        }
        $session_caller_details = $this->session->userdata('caller_details_data');
        $data['caller_details'] = $session_caller_details;
        $data['patient'] = $patient;
        $data['get_amb_details'] = $get_amb_details;
        $data['inc_ref_id'] = $inc_id;
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];
        $data['hospital_id'] = $inc_details['hospital_id'];
        $data['hospital_other'] = $inc_details['hospital_other'];
        $data['place'] = $inc_details['place'];
        $data['cl_type'] = $call_type;
        $data['inc_datetime'] = $datetime;
        // $data['cl_type'] = 'AMB_NT_ASSIGND';
        $data['default_state'] = $this->default_state;
        // print_r($data);die;
        $this->output->add_to_popup($this->load->view('frontend/non_eme_calls/amb_not_assign_form_view', $data, TRUE),'1200', '500');
    }
    function app_inter_hos_confirm_save() {
        $this->session->unset_userdata('mic_details');
        $this->session->unset_userdata('call_type');

        // $call_type = $this->input->get();
        $inc_post_details = $this->input->post();
        // print_r($inc_post_details);die();
        $inc_details = $this->input->get_post('inter');
        $patient = $this->input->get_post('patient');
        $caller_details = $this->input->get_post('caller');
        $call_type = $inc_post_details['inter']['inc_type'];
        // print_r($call_type);die();
        if($inc_post_details['incient']['amb_id'] != ''){
 
            $this->output->message = "<div class='error'>Remove Ambulance OR Select Another Ambulance</div>";
            return;
          
        }

       
        $patient = $this->input->get_post('patient');

        $dup_inc = $inc_details['dup_inc'];
        $datetime = date('Y-m-d H:i:s');
        $datetime = $this->session->userdata('inc_datetime');

        $inc_id = $this->session->userdata('inc_ref_id');
//        if ($inc_id == '') {
//            $inc_id = generate_inc_ref_id();
//            $this->session->set_userdata('inc_ref_id', $inc_id);
//            update_inc_ref_id($inc_id);
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

        $call_id = $this->input->get_post('call_id');
        $this->session->set_userdata('mic_details', $inc_details);
        $this->session->set_userdata('call_type', $call_type);
        $this->session->set_userdata('call_id', $call_id);
        $this->session->set_userdata('patient', $patient);
        $this->session->set_userdata('inc_post_details', $inc_post_details);
        $this->session->set_userdata('inc_datetime', $datetime);
        $data['nature'] = $this->inc_model->get_chief_comp_service($inc_details['chief_complete']);

        if ($inc_details["amb_id"]) {

            foreach ($inc_details["amb_id"] as $amb) {

                $args = array(
                    'rg_no' => $amb,
                );



                $get_amb_details[] = $this->inc_model->get_amb_details($args);
            }
        }
        $session_caller_details = $this->session->userdata('caller_details_data');
        $data['caller_details'] = $session_caller_details;
        $data['patient'] = $patient;
        $data['get_amb_details'] = $get_amb_details;
        $data['inc_ref_id'] = $inc_id;
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];
        $data['hospital_id'] = $inc_details['hospital_id'];
        $data['hospital_other'] = $inc_details['hospital_other'];
        $data['place'] = $inc_details['place'];
        $data['cl_type'] = $call_type;
        $data['inc_datetime'] = $datetime;
        // $data['cl_type'] = 'AMB_NT_ASSIGND';
        $data['default_state'] = $this->default_state;
        // print_r($data);die;
        $this->output->add_to_popup($this->load->view('frontend/non_eme_calls/amb_not_assign_form_view', $data, TRUE),'1200', '500');
    }
    function amb_not_assi_save() {
        $cl_type = 'AMB_NT_ASSIGND';
        $inc_details = $this->input->get_post('incient');
        $call_id = $this->input->get_post('call_id');
        $caller_details = $this->session->userdata('caller_details');
        $inc_details = $this->session->userdata('mic_details');
        $inc_post_details = $this->session->userdata('inc_post_details');
        $call_id = $this->session->userdata('call_id');

        $inc_details_service = serialize($inc_details['service']);
        $patient = $this->session->userdata('patient');
        $non_eme_call = $this->input->get_post('non_eme_call');
        $inc_id = $this->session->userdata('inc_ref_id');
        $datetime = date('Y-m-d H:i:s');
        if($inc_post_details['incient_districts'] == '')
        {
            $district = $inc_post_details['incient_district'];
        }else{
            $district = $inc_post_details['incient_districts'];
        }
        // print_r($this->clg->clg_group);die;
        if($this->clg->clg_group == 'UG-ERO'){
            $system = '108';
        }else{
            $system = '102';
        }
        $datetime1 = new DateTime($datetime);
        $datetime2 = new DateTime($inc_details['inc_recive_time']);
        $interval = $datetime2->diff($datetime1);
        $time = $interval->format('%H:%i:%s');
        // print_r($time);die;
        // if()
        $incidence_details = array('inc_cl_id' => $call_id,
            'inc_ref_id' => $inc_id,
            'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
            'inc_type' => 'AMB_NT_ASSIGND',
            'inc_ero_summary' => $inc_details['inc_ero_summary'],
            'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
            'inc_dispatch_time' => $time,
            // 'inc_city' => $inc_details['inc_city'],
            'inc_city_id' => $inc_post_details['incient_ms_city'],
            //'inc_state' => $inc_post_details['incient_state'],
            'inc_state_id' => $inc_post_details['incient_state'],
            'inc_address' => $inc_details['place'],
            //'inc_district' => $inc_post_details['incient_district'],
            'inc_district_id' => $district,
            'inc_area' => $inc_details['area'],
            'inc_landmark' => $inc_details['landmark'],
            'inc_lane' => $inc_details['lane'],
            'inc_h_no' => $inc_details['h_no'],
            'inc_pincode' => $inc_details['pincode'],
            'inc_lat' => $inc_details['lat'],
            'inc_long' => $inc_details['lng'],
            'inc_datetime' => $datetime,
            'inc_service' => $inc_details_service,
            // 'inc_duplicate' => $dup_inc,
            'inc_base_month' => $this->post['base_month'],
            'inc_set_amb' => '1',
            'incis_deleted' => '2',
            'inc_recive_time' => $inc_details['inc_recive_time'],
            // 'inc_suggested_amb' => $inc_details['inc_suggested_amb'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_system_type' => $system
        );
        // print_r($incidence_details);die;
        $this->session->set_userdata('incidence_details', $incidence_details);
        $datetime = $this->session->userdata('inc_datetime');
            $data = array(
                'ncl_base_month' => $this->post['base_month'],
                'ncl_cl_id' => $this->input->post('call_id'),
                'ncl_clr_id' => $this->input->post('caller_id'),
                'ncl_date' => date('Y-m-d H:i:s'),
                'ncl_inc_ref_id' => $inc_id,
                'ncl_added_by' => $this->clg->clg_ref_id,
                'nclis_deleted' => '0',
                'ncl_call_type' => $non_eme_call['cl_type'],
                'ncl_district' =>  $this->input->post('inc_district_id'),
                'ncl_cl_purpose' => $this->input->get_post('cl_purpose'),
                'ncl_cl_appriciation' => $inc_details['appriciation'],
            );
            
            $this->session->set_userdata('amb_not_assi_details', $data);
            
            $ambulances = $_POST['langOpt'];
            // print_r($ambulances[0]);die;
            $cbx1="";  
            foreach($ambulances as $cbx1)  
            {  
                $cb1 .= $cbx1.",";  
            } 
            $amb_call = array(
                'inc_ref_id' => $inc_id,
                'inc_district_id'=> $this->input->post('inc_district_id'),
                'inc_amb_not_assgn_reason' => $this->input->post('inc_amb_not_assgn_reason'),
                'inc_amb_not_assgn_ambulances' => $cb1,
                'inc_added_by' => $this->clg->clg_ref_id,
                'inc_datetime' => date('Y-m-d H:i:s'),
                'inc_dispatch_time' => $inc_details['caller_dis_timer'],
                'inc_recive_time' => $inc_details['inc_recive_time'],
                'inc_type' => $non_eme_call['cl_type'],
                'inc_cl_id' => $this->input->post('call_id'), 
                'inc_place'=> $this->input->post('inc_place'),
                'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
            );
            
            // print_r($amb_call);die;
            $this->session->set_userdata('amb_not_assi_details', $amb_call);
            $data1['reason'] = $this->call_model->get_district_name(array('inc_district_id' => $amb_call['inc_district_id']));
            // print_r($ambulances);die;
            $amb_call['dst_name'] =  $data1['reason'][0]->dst_name;
            $amb_call['details'] = $this->get_amb_detailed_data($ambulances);
            // print_r($amb_call);die;    
            $this->output->add_to_popup($this->load->view('frontend/non_eme_calls/confirm_amb_not_assi', $amb_call, TRUE), '600', '500');
        
        }
        
        function get_amb_detailed_data($amb){
            // $ids = $_POST['ids'];
            $data = array();
            foreach($amb as $values){
                // print_r($values);die;
                $pat_details = $this->inc_model->get_dtld_amb_details($values);
                // print_r($pat_details);die;
                array_push($data,$pat_details);
            }
            // print_r($data);die;
            return($data);
            // 
        }
        function save_amb_not_assign(){
            
                $inc_args = $this->session->userdata('amb_not_assi_details');
                $amb_data =  $this->session->userdata('amb_not_assi_details_all_data');
                $inc_id = $this->session->unset_userdata('inc_ref_id');
                $incidence_details = $this->session->userdata('incidence_details');
                $call_id = $this->input->get_post('call_id');
                $patient = $this->session->userdata('patient');
                $caller_details = $this->session->userdata('caller_details');
                // print_r($patient);die;
        
                if ($inc_details["amb_id"]) {
        
                    foreach ($inc_details["amb_id"] as $amb) {
        
                        $args = array(
                            'rg_no' => $amb,
                        );
        
        
        
                        $get_amb_details[] = $this->inc_model->get_amb_details($args);
                    }
                }
                
                $data['get_amb_details'] = $get_amb_details;
                $data['inc_ref_id'] = $inc_id;
                $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];
                $data['hospital_id'] = $inc_details['hospital_id'];
                $data['hospital_other'] = $inc_details['hospital_other'];
                $data['place'] = $inc_details['place'];
                $data['cl_type'] = $call_type;
                $data['inc_datetime'] = $datetime;
                $data['cl_type'] = 'AMB_NT_ASSIGND';
                $data['default_state'] = $this->default_state;
                // print_r($incidence_details);die;
                $inc_data = $this->inc_model->insert_inc($incidence_details);
    
                $data = array(
                    'inc_ref_id' => $inc_args['inc_ref_id'],
                    'non_eme_clr_id'  => $inc_args['inc_cl_id'],
                    'non_eme_district' => $inc_args['inc_district_id'],
                    'non_eme_remark' => $inc_args['inc_amb_not_assgn_reason'],
                    'non_eme_place' => $inc_args['inc_place'],
                    'added_by' => $inc_args['inc_added_by'],
                    'added_date' => date('Y-m-d H:i:s'),
                );
                
                $ambul = array();
                foreach($amb_data as $amb_d){
                    $p_data  = array();
                    foreach($amb_d as $amb){
                        $p_data = array('non_eme_amb_ambulances'=>$amb['amb_rto_register_no'],
                        'non_eme_amb_status'=>$amb['ambs_name'],
                        'non_eme_clg_ref_id_emt' => $amb['clg_ref_id'],
                        'non_eme_base_loc' => $amb['hp_name']);
                        
                        if($amb['login_type']=='P'){
                            $p_data['non_eme_clg_ref_id_emt'] = $amb['clg_ref_id'];
        
                        }else{
                            $p_data['non_eme_clg_ref_id_pilot'] = $amb['clg_ref_id'];
                        }
                          
                      
                    }

                    $merged = array_merge($data,$p_data); 
                    
                    $call_name = $child_purpose_of_calls[0]->pname;
                    $inc_data = $this->pet_model->insert_ems_patient_details($patient);
                    $inc_data = $this->call_model->insert_caller_details($caller_details);
                    // $inc_data = $this->inc_model->insert_non_eme_data($incidence_details);
                    $inc_data =  $this->inc_model->insert_non_eme_call($merged);
                }
                if ($inc_data) {
        
                    $this->output->status = 1;
        
                    $this->output->close00opup = "yes";
        
                    $url = base_url("calls");
                    $this->output->message = "<h3>".$call_name."</h3><br><p>$call_name call details save successfully.</p><script>window.location.href = '".$url."';</script>";
        
                    $this->output->moveto = 'top';
        
                }
            }
            function save_inter_hos_amb_not_assign(){
            
                $inc_args = $this->session->userdata('amb_not_assi_details');
                $amb_data =  $this->session->userdata('amb_not_assi_details_all_data');
                $inc_id = $this->session->unset_userdata('inc_ref_id');
                $incidence_details = $this->session->userdata('incidence_details');
                $call_id = $this->input->get_post('call_id');
                $patient = $this->session->userdata('patient');
                $caller_details = $this->session->userdata('caller_details');
                // print_r($patient);die;
        
                if ($inc_details["amb_id"]) {
        
                    foreach ($inc_details["amb_id"] as $amb) {
        
                        $args = array(
                            'rg_no' => $amb,
                        );
        
        
        
                        $get_amb_details[] = $this->inc_model->get_amb_details($args);
                    }
                }
                
                $data['get_amb_details'] = $get_amb_details;
                $data['inc_ref_id'] = $inc_id;
                $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];
                $data['hospital_id'] = $inc_details['hospital_id'];
                $data['hospital_other'] = $inc_details['hospital_other'];
                $data['place'] = $inc_details['place'];
                $data['cl_type'] = $call_type;
                $data['inc_datetime'] = $datetime;
                $data['cl_type'] = 'AMB_NT_ASSIGND';
                $data['default_state'] = $this->default_state;
                // print_r($incidence_details);die;
                $inc_data = $this->inc_model->insert_inc($incidence_details);
    
                $data = array(
                    'inc_ref_id' => $inc_args['inc_ref_id'],
                    'non_eme_clr_id'  => $inc_args['inc_cl_id'],
                    'non_eme_district' => $inc_args['inc_district_id'],
                    'non_eme_remark' => $inc_args['inc_amb_not_assgn_reason'],
                    'non_eme_place' => $inc_args['inc_place'],
                    'added_by' => $inc_args['inc_added_by'],
                    'added_date' => date('Y-m-d H:i:s'),
                );
                
                $ambul = array();
                foreach($amb_data as $amb_d){
                    $p_data  = array();
                    foreach($amb_d as $amb){
                        $p_data = array('non_eme_amb_ambulances'=>$amb['amb_rto_register_no'],
                        'non_eme_amb_status'=>$amb['ambs_name'],
                        'non_eme_clg_ref_id_emt' => $amb['clg_ref_id'],
                        'non_eme_base_loc' => $amb['hp_name']);
                        
                        if($amb['login_type']=='P'){
                            $p_data['non_eme_clg_ref_id_emt'] = $amb['clg_ref_id'];
        
                        }else{
                            $p_data['non_eme_clg_ref_id_pilot'] = $amb['clg_ref_id'];
                        }
                          
                      
                    }

                    $merged = array_merge($data,$p_data); 
                    // print_r($merged);die;
                    $call_name = $child_purpose_of_calls[0]->pname;
                    $inc_data = $this->pet_model->insert_ems_patient_details($patient);
                    $inc_data = $this->call_model->insert_caller_details($caller_details);
                    // $inc_data = $this->inc_model->insert_non_eme_data($incidence_details);
                    $inc_data =  $this->inc_model->insert_non_eme_call($merged);
                }
                if ($inc_data) {
        
                    $this->output->status = 1;
        
                    $this->output->close00opup = "yes";
        
                    $url = base_url("calls");
                    $this->output->message = "<h3>".$call_name."</h3><br><p>$call_name call details save successfully.</p><script>window.location.href = '".$url."';</script>";
        
                    $this->output->moveto = 'top';
        
                }
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
        $datetime = $this->session->userdata('inc_datetime');

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
     
                if($inc_post_details['incient_districts'] == '')
                {
                    $district = $inc_post_details['incient_district'];
                }else{
                    $district = $inc_post_details['incient_districts'];
                }
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
            'inc_district_id' => $district,
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


                     $call_hisotory_args = array(
                            'incident_id' => $inc_id,
                            'ero_id'=>$this->clg->clg_ref_id,
                            'pda_id' => $police_user->clg_ref_id,
                            'pda_status' => 'ASG',
                            'incident_date' => $datetime,
                            'added_date' => $datetime
                        );


                    if ($police_user) {
                        $police_operator = $this->common_model->assign_operator($police_operator2);
                        $police_operator = $this->common_model->insert_call_history($call_hisotory_args);
                    }
                
            }

            if ($inc_details['service'][3] == '3') {

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


                 
                        $fire_operator = $this->common_model->assign_operator($fire_operator);
                        
                        $call_hisotory_args = array(
                        'incident_id' => $inc_re_id,
                        'ero_id'=>$this->clg->clg_ref_id,
                        'fda_id' => $fire_user->clg_ref_id,
                        'fda_status' => 'ASG',
                        'incident_date' => $datetime,
                        'added_date' => $datetime );
                        
                        $fda_operator = $this->common_model->insert_fda_call_history($call_hisotory_args);
                  
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
            if (ucfirst($patient['first_name']) != '') {

                $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
                $last_pat_id = $last_insert_pat_id[0]->p_id + 1;
                //$last_pat_id = $this->clg->clg_id.'_'.$last_pat_id;
                 $last_pat_id = generate_ptn_id();

                $incidence_patient_details = array('ptn_fname' => ucfirst($patient['first_name']),
                    'ptn_mname' => ucfirst($patient['middle_name']),
                    'ptn_lname' => ucfirst($patient['last_name']),
                    'ptn_gender' => $patient['gender'],
                    'ptn_fullname' => ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']),
                    'ptn_age' => $patient['age'],
                    'ptn_age_type' => $patient['age_type'],
                    'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_birth_date' => $patient['ptn_birth_date'],
                    'ptn_id' => $last_pat_id,
                    'ptn_added_by' => $this->clg->clg_ref_id,
                    'ptn_added_date' => date('Y-m-d H:i:s'),
                    //'ptn_type'   => '2' 
                );


                $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
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
                if($inc_details['que_lan']=="")
                {
                    $inc_details['que_lan']="0";
                }
                
                $ems_summary = array('sum_base_month' => $this->post['base_month'],
                    'sum_sub_id' => $inc_id,
                    'sum_sub_type' => $inc_details['inc_type'],
                    'sum_que_id' => $key,
                    'sum_que_ans' => $ques,
                    'sum_que_lan' => $inc_details['que_lan']
                );

                $this->inc_model->insert_ems_summary($ems_summary);
            }
        }

        $this->output->status = 1;
        $this->output->closepopup = "yes";
        $msg = "Call terminated";
        $url = base_url("calls");
        $this->output->message = "<h3>Non-MCI Call</h3><br><p>Incident " . $msg . " successfull.</p><script>window.location.href = '".$url."';</script>";
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
        $datetime = $this->session->userdata('inc_datetime');

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
            $inc_post_details['incient_state'] = "MH";
        }
        $date = str_replace('-', '', date('Y-m-d'));

        //$inc_id = $date.$call_id;
        $inc_id = $this->session->userdata('inc_ref_id');
//        if ($inc_id == '') {
//            $inc_id = generate_inc_ref_id();
//            $this->session->set_userdata('inc_ref_id', $inc_id);
//            update_inc_ref_id($inc_id);
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
                if($inc_post_details['incient_districts'] == ''){
                    $district = $inc_post_details['incient_district'];
                }else{
                    $district = $inc_post_details['incient_districts'];
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
            'inc_district_id' => $district,
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

            if ($inc_details['service'][2] == '2') {

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
                
                 $call_hisotory_args = array(
                        'incident_id' => $inc_id,
                        'ero_id'=>$this->clg->clg_ref_id,
                        'pda_id' => $police_user->clg_ref_id,
                        'pda_status' => 'ASG',
                        'incident_date' => $datetime,
                        'added_date' => $datetime
                );
                $police_operator = $this->common_model->insert_call_history($call_hisotory_args);
                }
            }

            if ($inc_details['service'][3] == '3') {

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
                
                 $call_hisotory_args = array(
                        'incident_id' => $inc_re_id,
                        'ero_id'=>$this->clg->clg_ref_id,
                        'fda_id' => $fire_user->clg_ref_id,
                        'fda_status' => 'ASG',
                        'incident_date' => $datetime,
                        'added_date' => $datetime );
                        
                        $fda_operator = $this->common_model->insert_fda_call_history($call_hisotory_args);
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
       // update_inc_ref_id($inc_id);

        $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
        $last_pat_id = $last_insert_pat_id[0]->p_id + 1;
        //$last_pat_id = $this->clg->clg_id.'_'.$last_pat_id;
         $last_pat_id = generate_ptn_id();

        $incidence_patient_details = array('ptn_fname' => ucfirst($patient['first_name']),
            'ptn_mname' => ucfirst($patient['middle_name']),
            'ptn_lname' => ucfirst($patient['last_name']),
            'ptn_gender' => $patient['gender'],
            'ptn_fullname' => ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']),
            'ptn_age' => $patient['age'],
            'ptn_age_type' => $patient['age_type'],
            'ayushman_id' => $patient['ayu_id'],
            'ptn_mob_no' => $patient['ptn_mob_no'],
            'ptn_birth_date' => $patient['dob'],
            'ptn_bgroup' => $patient['blood_gp'],
            'ptn_id' => $last_pat_id,
            'ptn_added_by' => $this->clg->clg_ref_id,
            'ptn_added_date' => date('Y-m-d H:i:s'),
        );

        $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);


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
        $amb_url = "http://localhost/JAEms/amb/loc/" . $inc_id;
        $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_id;

        //$amb_url = "http://210.212.165.123/tdd/amb/loc/" . $inc_id;
        // $amb_dir_url = "http://210.212.165.123/tdd/amb/amb_dir/" . $inc_id;

        $doctor = $this->colleagues_model->get_user_info($EMT);
        $sms_doctor = $doctor[0]->clg_first_name;
        $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;
        $str = ltrim($sms_doctor_contact_no, '0');
        $patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];
        $patient_mobile_no = $caller_details['clr_mobile'];
        //$patient_mobile_no = "9730015484";
        $patient_name = $caller_details['clr_fname'];

        $patient_sms_text = "Ambulance dispatched: $sms_amb\n Ambulance Contact - $sms_doctor_contact_no\n Track Link- $amb_url\n";


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

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id, Patient id:$last_pat_id, Navigate- $amb_url ";
        } else if ($get_driver_no[0]->amb_user_type = 'bike') {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call Bike Desk for Case ID creation. ";
        } else {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call 108 ERC for Case ID creation.  ";
        }
        $doctor_sms_text="Dear Doctor/Nurse, following is the patient details: $patient_full_name, Age -  ,Address- $inc_address, Contact No - $patient_mobile_no,Chief complaint - $chief_complaint,Incident id: $inc_id  URL : $amb_url ";
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

        $driver_sms_text = "Dear Pilot, Patient name: $patient_full_name,  Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id , Patient id:$last_pat_id  Navigate- $amb_dir_url ";

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
        $url = base_url("calls");
        $this->output->message = "<h3>MCI Call</h3><br><p>Incident " . $msg . " successfull.</p><script>window.location.href = '".$url."';</script>";
        $this->output->moveto = 'top';
        $this->output->add_to_position('', 'content', TRUE);
    }

    function confirm_inter_hos_save() {

        $this->session->unset_userdata('inter');
        $this->session->unset_userdata('call_type');
        $this->session->unset_userdata('patient');
        $this->session->unset_userdata('call_id');
        $this->session->unset_userdata('incient');
         $this->session->unset_userdata('inc_datetime');
       // $this->session->unset_userdata('new_hospital');
       // $this->session->unset_userdata('hospital');
       
        $call_type = $this->input->get();
        
        $datetime = date('Y-m-d H:i:s');
       
        
        $this->session->set_userdata('inc_datetime',$datetime);

        $inter_details = $this->input->get_post('inter');
        
       /* if($inter_details['inc_datetime'] != ''){
             $datetime =$inter_details['inc_datetime'];
        }else{
            $datetime = date('Y-m-d H:i:s');
        }*/
        
        $inter_post_details = $this->input->post();

        $data['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inter_details['inc_ero_standard_summary']));

        $inc_id = $this->session->userdata('inc_ref_id');
//        if ($inc_id == '') {
//            $inc_id = generate_inc_ref_id();
//            $this->session->set_userdata('inc_ref_id', $inc_id);
//            update_inc_ref_id($inc_id);
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


        $incient_details = $this->input->get_post('incient');
        $patient = $this->input->get_post('patient');
        $call_id = $this->input->get_post('call_id');

        $this->session->set_userdata('inter', $inter_details);
        $this->session->set_userdata('incient', $incient_details);
        $this->session->set_userdata('call_type', $call_type);
        $this->session->set_userdata('call_id', $call_id);
        $this->session->set_userdata('patient', $patient);
        $this->session->set_userdata('inter_post_details', $inter_post_details);
        $this->session->set_userdata('inc_datetime', $datetime);
        $session_caller_details = $this->session->userdata('caller_details_data');


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
        
        if($inter_details['facility'] == '0'){
            $current_facility =   "Other";
        }else if($inter_details['facility'] == 'on_scene_care'){
            $current_facility =   "On scene care";
        }else if($inter_details['facility']== 'at_scene_care'){
            $current_facility =   "At Scene Care";
        }else{
        $current_facility =  $this->hp_model->get_hp_data1(array('hp_id' => $inter_details['facility'])); 
        }
        
        
         if($inter_details['new_facility'] == '0'){
            $new_facility =   "Other";
        }else if($inter_details['new_facility'] == 'on_scene_care'){
            $new_facility =   "On scene care";
        }else if($inter_details['new_facility']== 'at_scene_care'){
            $new_facility =   "At Scene Care";
        }else{
        $new_facility =  $this->hp_model->get_hp_data1(array('hp_id' => $inter_details['new_facility'])); 
        }
        
        $data['new_hospital'] = $new_facility;     
        $this->session->set_userdata('new_hospital', $data['new_hospital']);
        
        $data['facility'] =$current_facility;     
        $this->session->set_userdata('hospital', $data['facility']);

        $data['new_facility'] = $data['new_hospital'];
        $data['facility'] = $data['facility'];
        
 

        $data['inc_ero_summary'] = $inter_details['inc_ero_summary'];
        $data['inter_details'] = $inter_details;

        $data['place'] = $incient_details['place'];
        $data['inc_datetime'] = $datetime;
        $data['caller_details'] = $session_caller_details;

        $data['cl_type'] = $call_type;
        $data['hospital_id'] = $inc_details['hospital_id'];
        $data['hospital_other'] = $inc_details['hospital_other'];
        $this->output->add_to_popup($this->load->view('frontend/in_hos/confirm_inter_hos_view', $data, TRUE), '600', '560');

        //   $this->output->add_to_position($this->load->view('frontend/patient/pt_inc_summary_view', $data, TRUE), 'summary_div', TRUE);
    }
    function amb_inter_hos_not_assi_save() {
        $cl_type = 'AMB_NT_ASSIGND';
        $inc_details = $this->input->get_post('incient');
        $call_id = $this->input->get_post('call_id');
        $caller_details = $this->session->userdata('caller_details');
        $inc_details = $this->session->userdata('mic_details');
        $inc_post_details = $this->session->userdata('inc_post_details');
        $call_id = $this->session->userdata('call_id');

        $inc_details_service = serialize($inc_details['service']);
        $patient = $this->session->userdata('patient');
        $non_eme_call = $this->input->get_post('non_eme_call');
        $inc_id = $this->session->userdata('inc_ref_id');
        $datetime = date('Y-m-d H:i:s');
        if($inc_post_details['incient_districts'] == '')
        {
            $district = $inc_post_details['incient_district'];
        }else{
            $district = $inc_post_details['incient_districts'];
        }
        // print_r($this->clg->clg_group);die;
        if($this->clg->clg_group == 'UG-ERO'){
            $system = '108';
        }else{
            $system = '102';
        }
        $datetime1 = new DateTime($datetime);
        $datetime2 = new DateTime($inc_details['inc_recive_time']);
        $interval = $datetime2->diff($datetime1);
        $time = $interval->format('%H:%i:%s');
        // print_r($time);die;
        // if()
        $incidence_details = array('inc_cl_id' => $call_id,
            'inc_ref_id' => $inc_id,
            'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
            'inc_type' => 'AMB_NT_ASSIGND',
            'inc_ero_summary' => $inc_details['inc_ero_summary'],
            'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
            'inc_dispatch_time' => $time,
            // 'inc_city' => $inc_details['inc_city'],
            'inc_city_id' => $inc_post_details['incient_ms_city'],
            //'inc_state' => $inc_post_details['incient_state'],
            'inc_state_id' => $inc_post_details['incient_state'],
            'inc_address' => $inc_details['place'],
            //'inc_district' => $inc_post_details['incient_district'],
            'inc_district_id' => $district,
            'inc_area' => $inc_details['area'],
            'inc_landmark' => $inc_details['landmark'],
            'inc_lane' => $inc_details['lane'],
            'inc_h_no' => $inc_details['h_no'],
            'inc_pincode' => $inc_details['pincode'],
            'inc_lat' => $inc_details['lat'],
            'inc_long' => $inc_details['lng'],
            'inc_datetime' => $datetime,
            'inc_service' => $inc_details_service,
            // 'inc_duplicate' => $dup_inc,
            'inc_base_month' => $this->post['base_month'],
            'inc_set_amb' => '1',
            'incis_deleted' => '2',
            'inc_recive_time' => $inc_details['inc_recive_time'],
            // 'inc_suggested_amb' => $inc_details['inc_suggested_amb'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_system_type' => $system
        );
        // print_r($incidence_details);die;
        $this->session->set_userdata('incidence_details', $incidence_details);
        $datetime = $this->session->userdata('inc_datetime');
            $data = array(
                'ncl_base_month' => $this->post['base_month'],
                'ncl_cl_id' => $this->input->post('call_id'),
                'ncl_clr_id' => $this->input->post('caller_id'),
                'ncl_date' => date('Y-m-d H:i:s'),
                'ncl_inc_ref_id' => $inc_id,
                'ncl_added_by' => $this->clg->clg_ref_id,
                'nclis_deleted' => '0',
                'ncl_call_type' => $non_eme_call['cl_type'],
                'ncl_district' =>  $this->input->post('inc_district_id'),
                'ncl_cl_purpose' => $this->input->get_post('cl_purpose'),
                'ncl_cl_appriciation' => $inc_details['appriciation'],
            );
            
            $this->session->set_userdata('amb_not_assi_details', $data);
            
            $ambulances = $_POST['langOpt'];
            // print_r($ambulances[0]);die;
            $cbx1="";  
            foreach($ambulances as $cbx1)  
            {  
                $cb1 .= $cbx1.",";  
            } 
            $amb_call = array(
                'inc_ref_id' => $inc_id,
                'inc_district_id'=> $this->input->post('inc_district_id'),
                'inc_amb_not_assgn_reason' => $this->input->post('inc_amb_not_assgn_reason'),
                'inc_amb_not_assgn_ambulances' => $cb1,
                'inc_added_by' => $this->clg->clg_ref_id,
                'inc_datetime' => date('Y-m-d H:i:s'),
                'inc_dispatch_time' => $inc_details['caller_dis_timer'],
                'inc_recive_time' => $inc_details['inc_recive_time'],
                'inc_type' => $non_eme_call['cl_type'],
                'inc_cl_id' => $this->input->post('call_id'), 
                'inc_place'=> $this->input->post('inc_place'),
                'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
            );
            
            // print_r($amb_call);die;
            $this->session->set_userdata('amb_not_assi_details', $amb_call);
            $data1['reason'] = $this->call_model->get_district_name(array('inc_district_id' => $amb_call['inc_district_id']));
            // print_r($ambulances);die;
            $amb_call['dst_name'] =  $data1['reason'][0]->dst_name;
            $amb_call['details'] = $this->get_amb_detailed_data($ambulances);
            // print_r($amb_call);die;    
            $this->output->add_to_popup($this->load->view('frontend/non_eme_calls/confirm_amb_not_assi', $amb_call, TRUE), '600', '500');
        
        }
    function confirm_inter_hos_terminate() {

        $this->session->unset_userdata('inter');
        $this->session->unset_userdata('call_type');
        $this->session->unset_userdata('patient');
        $this->session->unset_userdata('call_id');
        $this->session->unset_userdata('incient');

        $post_data = $this->input->post();
        
        
         if($post_data['incient']['amb_id'] != ''){
 
            $this->output->message = "<div class='error'>Remove Ambulance Selected ambulance</div>";
            return;
          
        }

        $call_type = $this->input->get();
        $datetime = date('Y-m-d H:i:s');
         $this->session->set_userdata('inc_datetime',$datetime);



        $inter_details = $this->input->get_post('inter');
        $inter_post_details = $this->input->post();

        $incient_details = $this->input->get_post('incient');
        $patient = $this->input->get_post('patient');
        $call_id = $this->input->get_post('call_id');

        $data['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inter_details['inc_ero_standard_summary']));


        $inc_id = $this->session->userdata('inc_ref_id');
//        if ($inc_id == '') {
//            $inc_id = generate_inc_ref_id();
//            $this->session->set_userdata('inc_ref_id', $inc_id);
//            update_inc_ref_id($inc_id);
//        }
        
        
          if ($inc_id == NULL && $inc_id == '' && $this->clg->clg_group != 'UG-BIKE-ERO') {
            $inc_id = generate_inc_ref_id();
            $this->session->set_userdata('inc_ref_id', $inc_id);
           // update_inc_ref_id($inc_id);
            
        }else if($this->clg->clg_group == 'UG-BIKE-ERO'){
                 $inc_id = "BK-".generate_bk_inc_ref_id();
                 $this->session->set_userdata('inc_ref_id', $inc_id);
               // update_inc_ref_id($inc_id);
        }
        $data['inc_ref_id'] = $inc_id;
      
        $this->session->set_userdata('inter', $inter_details);
        $this->session->set_userdata('incient', $incient_details);
        $this->session->set_userdata('call_type', $call_type);
        $this->session->set_userdata('call_id', $call_id);
        $this->session->set_userdata('patient', $patient);
        $this->session->set_userdata('inter_post_details', $inter_post_details);
        $this->session->set_userdata('inc_datetime', $datetime);

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
        $session_caller_details = $this->session->userdata('caller_details_data');
        $data['caller_details'] = $session_caller_details;



        $data['inc_ero_summary'] = $inter_details['inc_ero_summary'];

        $data['place'] = $incient_details['place'];
        $data['inc_datetime'] = $datetime;

        $data['cl_type'] = $call_type;
        $this->output->add_to_popup($this->load->view('frontend/in_hos/confirm_inter_hos_terminate', $data, TRUE), '600', '560');

        //   $this->output->add_to_position($this->load->view('frontend/patient/pt_inc_summary_view', $data, TRUE), 'summary_div', TRUE);
    }

    function previous_incident() {



        $cm_id = $this->input->post('incient');
//         var_dump($cm_id);
         $cm1_id = $this->input->post();
        //var_dump($cm1_id);
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
            'lat' => $cm1_id['lat'],
            'lng' => $cm1_id['lng'],
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
        
        if($inc_post_details['call_type'] == 'terminate'){
            if($inc_details['amb_id'] != ''){

                $this->output->message = "<div class='error'>Remove Ambulance Selected ambulance</div>";
                return;

            }
        }



        $dup_inc = $inc_details['dup_inc'];
        $datetime = date('Y-m-d H:i:s');
       // $datetime = $this->session->set_userdata('inc_datetime',$datetime);

        $call_id = $this->input->get_post('call_id');
        $this->session->set_userdata('mic_details', $inc_details);
        $this->session->set_userdata('call_type', $call_type);
        $this->session->set_userdata('call_id', $call_id);
        $this->session->set_userdata('patient', $patient);
        $this->session->set_userdata('inc_datetime', $datetime);




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
//        if ($inc_id == '') {
//            $inc_id = generate_inc_ref_id();
//            $this->session->set_userdata('inc_ref_id', $inc_id);
//            update_inc_ref_id($inc_id);
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
        $data['patient'] = $patient;

        $data['get_amb_details'] = $get_amb_details;
        $data['inc_details'] = $inc_details;
        $data['hospital_id'] = $inc_details['hospital_id'];
        $data['hospital_other'] = $inc_details['hospital_other'];

        $session_caller_details = $this->session->userdata('caller_details_data');
        $data['caller_details'] = $session_caller_details;
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];

        $data['place'] = $inc_details['place'];

        $data['cl_type'] = $call_type;
        $data['inc_datetime'] = $datetime;

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


        //$datetime = date('Y-m-d H:i:s');
        $datetime = $this->session->userdata('inc_datetime');

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
            $inc_post_details['incient_state'] = "MH";
        }
        $date = str_replace('-', '', date('Y-m-d'));

        $inc_id = $this->session->userdata('inc_ref_id');
        
        $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_id));
        if(!empty($is_exits)){
            $this->session->set_userdata('inc_ref_id','');
            $this->output->message = "<div class='error'>Incident Id alredy exists</div>";
            return;
        }

        $dispatch_time = $this->session->userdata('dispatch_time');
        $call_type_terminate = $this->input->post('call_type');
        //var_dump($call_type_terminate);
        //die();

        $current_time = time();
        $res_time = $current_time - $dispatch_time;
        $h = ($res_time / (60 * 60)) % 24;
        $m = ($res_time / 60) % 60;
        
           if($inc_post_details['incient_districts'] == '')
                {
                    $district = $inc_post_details['incient_district'];
                }else{
                    $district = $inc_post_details['incient_districts'];
                }
                
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
            'inc_district_id' => $district,
            'inc_area' => $inc_details['area'],
            'inc_landmark' => $inc_details['landmark'],
            'inc_lane' => $inc_details['lane'],
            'inc_h_no' => $inc_details['h_no'],
            'inc_pincode' => $inc_details['pincode'],
            'inc_lat' => $inc_details['lat'],
            'inc_long' => $inc_details['lng'],
            'destination_hospital_id' => $inc_details['hospital_id'],
            'destination_hospital_two' => $inc_details['hospital_two_id'],
            'destination_hospital_other' => $inc_details['hospital_other'],
            'inc_datetime' => $datetime,
            'inc_service' => $inc_details_service,
            'inc_duplicate' => $dup_inc,
            'inc_base_month' => $this->post['base_month'],
            'inc_set_amb' => '1',
            'inc_suggested_amb' => $inc_details['inc_suggested_amb'],
            'inc_recive_time' => $inc_details['inc_recive_time'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_wht_three_wrd' => $inc_details['3word'],
            'inc_wht_three_wrd' => $inc_details['3word'],
            'bk_inc_ref_id' => $inc_id,
            'inc_thirdparty' => $this->clg->thirdparty,
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
        if($inc_details['hospital_id'] != ''){
           $incidence_details['hospital_id'] = $inc_details['hospital_id'];
        }     
        if($inc_details['hospital_two_id'] != ''){
           $incidence_details['hospital_id'] = $inc_details['hospital_two_id'];
        }
        $priority_hospital = get_hospital_by_id($incidence_details['hospital_id']);
        $district_hospital = $priority_hospital[0]->hp_district;
        $hosp_type = get_hosp_type_by_id($priority_hospital[0]->hp_type);
        $incidence_details['hospital_type'] = $hosp_type;
        $incidence_details['hospital_district'] = $district_hospital;

        if($inc_details['hospital_id'] != ''){
             $pri_hospital_data = get_hospital_by_id($inc_details['hospital_id']);
             $hospital_name = $pri_hospital_data[0]->hp_name;
             $pri_hosp_lat = $pri_hospital_data[0]->hp_lat;
             $pri_hosp_lng = $pri_hospital_data[0]->hp_long;
         }else{
             $pri_hospital_data = get_hospital_by_id($inc_details['hospital_two_id']);
             $hospital_name = $pri_hospital_data[0]->hp_name;
             $pri_hosp_lat = $pri_hospital_data[0]->hp_lat;
             $pri_hosp_lng = $pri_hospital_data[0]->hp_long;
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


        if ($dup_inc == 'No') {    
            
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
                    
                     $call_hisotory_args = array(
                        'incident_id' => $inc_id,
                        'ero_id'=>$this->clg->clg_ref_id,
                        'pda_id' => $police_user->clg_ref_id,
                        'pda_status' => 'ASG',
                        'incident_date' => $datetime,
                        'added_date' => $datetime
                );
                $police_operator = $this->common_model->insert_call_history($call_hisotory_args);
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
                    
                     $call_hisotory_args = array(
                        'incident_id' => $inc_id,
                        'ero_id'=>$this->clg->clg_ref_id,
                        'fda_id' => $fire_user->clg_ref_id,
                        'fda_status' => 'ASG',
                        'incident_date' => $datetime,
                        'added_date' => $datetime );
                        
                        $fda_operator = $this->common_model->insert_fda_call_history($call_hisotory_args);
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
      
                $amb_details = $this->inc_model->get_ambulance_details_API($inc_details['amb_id']);
                $amb_lat = $amb_details[0]->amb_lat;
                $amb_log = $amb_details[0]->amb_log;
                $thirdparty = $amb_details[0]->thirdparty;
                $ward_id = $amb_details[0]->ward_id;
                $ward_name = $amb_details[0]->ward_name;
                $hp_id = $amb_details[0]->hp_id;
                $hp_name = $amb_details[0]->hp_name;

                $incidence_amb_details = array('amb_rto_register_no' => $inc_details['amb_id'],
                    'inc_ref_id' => $inc_id,
                    'ward_id' => $ward_id,
                    'ward_name' => $ward_name,
                    'base_location_id' => $hp_id,
                    'base_location_name' => $hp_name,
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
            if (ucfirst($patient['first_name']) != '') {

                $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
                $last_pat_id = $last_insert_pat_id[0]->p_id + 1;
                //$last_pat_id = $this->clg->clg_id.'_'.$last_pat_id;
                 $last_pat_id = generate_ptn_id();

                $incidence_patient_details = array('ptn_fname' => ucfirst($patient['first_name']),
                    'ptn_mname' => ucfirst($patient['middle_name']),
                    'ptn_lname' => ucfirst($patient['last_name']),
                    'ptn_gender' => $patient['gender'],
                    'ptn_fullname' => ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']),
                    'ptn_age' => $patient['age'],
                    'ptn_age_type' => $patient['age_type'],
                    'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                    'ptn_birth_date' => $patient['dob'],
                    'ptn_id' => $last_pat_id,
                    'ptn_added_by' => $this->clg->clg_ref_id,
                    'ptn_added_date' => date('Y-m-d H:i:s'),
                );

                $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
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

        
        $denial_id = $this->session->userdata('denial_id');
        if($denial_id){
            foreach($denial_id as $denial){
                $com_args = array('inc_ref_id'=>$inc_id,'id'=>$denial);
                $update_app_call_details = $this->Dashboard_model->update_denial($com_args);

            } 
        }


        $ques_ans = $inc_details['ques'];

        if (isset($ques_ans)) {
            foreach ($ques_ans as $key => $ques) {
                if($inc_details['que_lan']=="")
                {
                    $inc_details['que_lan']="0";
                
                }
                $ems_summary = array('sum_base_month' => $this->post['base_month'],
                    'sum_sub_id' => $inc_id,
                    'sum_sub_type' => $inc_details['inc_type'],
                    'sum_que_id' => $key,
                    'sum_que_ans' => $ques,
                    'sum_que_lan' => $inc_details['que_lan']
                );

                $this->inc_model->insert_ems_summary($ems_summary);
            }
        }
        $api_url = "http://localhost/JAEms/api/googlenotification";
		$json_data = array('ambulanceNo'=>$inc_details['amb_id'],
						   'incidentId'=>$inc_id,
						   'cheifComplaint' => get_cheif_complaint($inc_details['chief_complete']));

        $json_data= json_encode($json_data);
                
        $api_google = api_notification_app($api_url,$json_data);
        
        $comm_api_url = "http://localhost/JAEms/communityapp/googlenotification";
		$json_data = array('userMobileNo'=>$caller_details['clr_mobile'],
                           'ambulanceNo'=>$inc_details['amb_id'],
						   'incidentId'=>$inc_id,
						   'cheifComplaint' => get_cheif_complaint($inc_details['chief_complete']));

        $json_data= json_encode($json_data);
                
        $api_google = api_notification_app($comm_api_url,$json_data);
        $this->call_model->update_booking_details($inc_details['user_req_id']);
        
        

        $caller_loc = $inc_details['place'];
        $caller_lat = $inc_details['lat'];
        $caller_lng = $inc_details['lng'];
        $destination_hos = $hospital_name;
        $hos_lat = $pri_hosp_lat;
        $hos_lng = $pri_hosp_lng;
        $select_amb_API= str_replace('-','',$inc_details['amb_id']);
       // $select_amb = implode('',(explode("-",$inc_details['amb_id'])));
        $args = array(
            'LastActivityTime' => "$datetime" ,
            'JobStatus' => 'Dispatched' ,
            'onRoadStatus' =>'1' ,
            'Caller_Location' => "$caller_loc",
            'Hospital_Location' => "$destination_hos",
            'JobNo' => "$inc_id",
            'HospitalLatlong' => "$hos_lat".','."$hos_lng",
            'stateCode' => 'MP',
            'AmbulanceNo' =>"$select_amb_API",
            'CallerLatlong' =>"$caller_lat".','."$caller_lng"
        );
        $send_API = send_API($args);
        /* send sms to patient */

        $sms_amb = $inc_details['amb_id'];

        $get_mobile_no = array('rg_no' => $sms_amb);

        $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);


        $driver = $this->colleagues_model->get_user_info($pilot);

        $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;

        $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;


        $inc_id = $inc_id;

        // $amb_url ="http://localhost/JAEms/amb/loc/" . $inc_id;
        $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_id;

        //$amb_url = "http://210.212.165.123/tdd/amb/loc/" . $inc_id;
        //$amb_dir_url = "http://210.212.165.123/tdd/amb/amb_dir/" . $inc_id;

        $patient_name = $caller_details['clr_fname'];



        $doctor = $this->colleagues_model->get_user_info($EMT);

        $sms_doctor = $doctor[0]->clg_first_name;

        $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;
        $sms_doctor_contact_no = ltrim($sms_doctor_contact_no, '0');
        $patient_mobile_no = $caller_details['clr_mobile'];
         $inc_address = $inc_details['place'];
         $sms_amb1 = implode('',(explode("-",$sms_amb)));
         $patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];
         $txtMsg1 = '';
         $txtMsg1.= "Dear ".$patient_full_name.", \n";
         $txtMsg1.= "Ambulance dispatched: ".$sms_amb1 .", \n";
         $txtMsg1.= "Ambulance Contact: ".$sms_doctor_contact_no .", \n" ;
         //$txtMsg1.= "Link: ".$amb_dir_url."\n" ;
         $txtMsg1 .= "Please click on the following link for downloading the 108 Sanjeevani app on your mobile Android User - https://tinyurl.com/2p87kfu6 and iOS User- https://tinyurl.com/3pup8pp4\n";
         $txtMsg1.= "JAES" ;
         $sms_to = $caller_details['clr_mobile'];
         $args = array(
             'msg' => $txtMsg1,
             'mob_no' => $sms_to,
             'sms_user'=>'patient',
             'inc_id'=>$inc_id,
         );
        $sms_data = sms_send($args);
        $mno = $caller_details['clr_mobile'];
        $mno = substr($mno, -10);
        $inc_link_args = array( 'mobile_no'=>$mno,
                                'incident_id'=>$inc_id,
                                'track_link'=>$amb_dir_url,
                                'added_date' =>   date('Y-m-d H:i:s'));
        
        $inc_link = $this->call_model->insert_track_link($inc_link_args); 
	

        /* send sms to doctor  */
        $patient_name = $caller_details['clr_fname'];
        $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
        //$chief_complaint = get_cheif_complaint($incidence_details['inc_complaint']);
        $Chief_Complaint_extra_length = array('32','4','15','89','92','50');
        if(in_array($incidence_details['inc_complaint'],$Chief_Complaint_extra_length))
        {
            if($incidence_details['inc_complaint']==32)
            {
                $chief_complaint = 'Child/Pediatric Patient';
            }
            if($incidence_details['inc_complaint']==4)
            {
                $chief_complaint = 'Altered Mental Status';
            }
            if($incidence_details['inc_complaint']==15)
            {
                $chief_complaint = 'Lightning Strike';
            }
            if($incidence_details['inc_complaint']==89 || $incidence_details['inc_complaint']==89 )
            {
                $chief_complaint = 'Children/Infacts/Newborn sick';
            }
            if($incidence_details['inc_complaint']==50)
            {
                $chief_complaint = 'Unconscious Patient';
            }
        }else{
            $chief_complaint = get_cheif_complaint($incidence_details['inc_complaint']);
        }
        // $hospital_name = $inc_details['hos_name'];
        $datetime = date('d-m-Y H:i:s');
        $txtMsg2 ='';
        $txtMsg2.= "Patient name: ".$patient_full_name.",\n"; 
        $txtMsg2.= " Address: ".$inc_address.",\n";
        $txtMsg2.= " Caller No: ".$patient_mobile_no.",\n";
        $txtMsg2.= " Incident Date Time: ".$datetime.",\n";
        $txtMsg2.= " Incident id: ".$inc_id.",\n";
        $txtMsg2.= " Chief Complaint: ".$chief_complaint.",\n";
        $txtMsg2.= " Hospital Name- ".$hospital_name.",\n";
        $txtMsg2.= " JAES" ;
      
        $sms_to = $sms_doctor_contact_no;
        $args = array(
            'msg' => $txtMsg2,
            'mob_no' => $sms_to,
            'sms_user'=>'EMT',
            'inc_id'=>$inc_id,
        );
        
        $sms_data = sms_send($args);
        /* send sms to Pilot  */
        
        $sms_pilot_contact_no = $get_driver_no[0]->amb_pilot_mobile; 
        $sms_pilot_contact_no = ltrim($sms_pilot_contact_no, '0');


        $patient_name = $caller_details['clr_fname'];
        if($hospital_name==''){
            $hospital_name='NA';
        }
      // $patient_name = $caller_details['clr_fname'];
       $datetime = date('d-m-Y H:i:s');
       $txtMsg2 ='';
       $txtMsg2.= "Patient name: ".$patient_full_name.",\n"; 
       $txtMsg2.= " Address: ".$inc_address.",\n";
       $txtMsg2.= " Caller No: ".$patient_mobile_no.",\n";
       $txtMsg2.= " Incident Date Time: ".$datetime.",\n";
       $txtMsg2.= " Incident id: ".$inc_id.",\n";
       $txtMsg2.= " Chief Complaint: ".$chief_complaint.",\n";
       $txtMsg2.= " Hospital Name- ".$hospital_name.",\n";
       $txtMsg2.= " JAES" ;
      
        $sms_to_pilot = $sms_pilot_contact_no;
        $args = array(
            'msg' => $txtMsg2,
            'mob_no' => $sms_to_pilot,
             'sms_user'=>'Pilot',
             'inc_id'=>$inc_id,
        );
        $sms_data = sms_send($args);
        
        $mno = $caller_details['clr_mobile'];
        $mno = substr($mno, -10);
        $inc_link_args = array( 'mobile_no'=>$mno,
                                'incident_id'=>$inc_id,
                                'track_link'=>$amb_dir_url,
                                'added_date' =>   date('Y-m-d H:i:s'));
        
        $inc_link = $this->call_model->insert_track_link($inc_link_args);
        
       
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

        //die();

        $url = base_url("calls");
        $this->output->message = "<h3>VIP Call</h3><br><p>Ambulance $msg Successfully</p><script>window.location.href = '".$url."';</script>";



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
        $state_id = "MH";

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
                    
                    
                     $call_hisotory_args = array(
                        'incident_id' => $inc_re_id,
                        'ero_id'=>$this->clg->clg_ref_id,
                        'pda_id' => 'PDA-1',
                        'pda_status' => 'ASG',
                        'incident_date' => $datetime,
                        'added_date' => $datetime
                    );
                $police_operator = $this->common_model->insert_call_history($call_hisotory_args);
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
                
                 $call_hisotory_args = array(
                        'incident_id' => $inc_re_id,
                        'ero_id'=>$this->clg->clg_ref_id,
                        'fda_id' => $fire_user->clg_ref_id,
                        'fda_status' => 'ASG',
                        'incident_date' => $datetime,
                        'added_date' => $datetime );
                        
                $fda_operator = $this->common_model->insert_fda_call_history($call_hisotory_args);
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
            $last_pat_id = generate_ptn_id();

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
                
                if ($dup_inc == 'No') {
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

                             $call_hisotory_args = array(
                            'incident_id' => $inc_re_id,
                            'ero_id'=>$this->clg->clg_ref_id,
                            'fda_id' => $fire_user->clg_ref_id,
                            'fda_status' => 'ASG',
                            'incident_date' => $datetime,
                            'added_date' => $datetime );

                            $fda_operator = $this->common_model->insert_fda_call_history($call_hisotory_args);
                        }
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
                $last_pat_id = generate_ptn_id();

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
$api_url = "http://localhost/JAEms/api/googlenotification";
			$json_data = array('ambulanceNo'=>$inc_details['amb_id'],
							   'incidentId'=>$inc_re_id,
							   'cheifComplaint' => get_cheif_complaint($inc_details['chief_complete']));
			$json_data= json_encode($json_data);
			api_notification_app($api_url,$json_data);
            
            
            $comm_api_url = "http://localhost/JAEms/communityapp/googlenotification";
            $json_data = array('userMobileNo'=>$caller_details['clr_mobile'],
                               'ambulanceNo'=>$inc_details['amb_id'],
                               'incidentId'=>$inc_id,
                               'cheifComplaint' => get_cheif_complaint($inc_details['chief_complete']));

            $json_data= json_encode($json_data);

            $api_google = api_notification_app($comm_api_url,$json_data);
              $this->call_model->update_booking_details($caller_details['clr_mobile']);

            update_inc_ref_id($inc_re_id);


            /* send sms to patient  */
            $sms_amb = $inc_details['amb_id'];
            $get_mobile_no = array('rg_no' => $sms_amb);
            $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);
            $driver = $this->colleagues_model->get_user_info($pilot);
            $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;
            $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;

            //$inc_id = $inc_id;
            $amb_url = "http://localhost/JAEms/amb/loc/" . $inc_id;
            $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_id;

            //$amb_url = "http://210.212.165.123/tdd/amb/loc/" . $inc_id;
            //$amb_dir_url = "http://210.212.165.123/tdd/amb/amb_dir/" . $inc_id;



            $doctor = $this->colleagues_model->get_user_info($EMT);
            $sms_doctor = $doctor[0]->clg_first_name;
            $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;
            $str = ltrim($sms_doctor_contact_no, '0');
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
    function load_three_word_validation()
    {
        $three_word = $this->input->get_post('three_word', TRUE);
        /*
                ^\/{0,}[^0-9`~!@#$%^&*()+\-_=[{\]}\\|'<,.>?/";:£§º©®\s]{1,}[・.。][^0-9`~!@#$%^&*()+\-_=[{\]}\\|'<,.>?/";:£§º©®\s]{1,}
                [・.。][^0-9`~!@#$%^&*()+\-_=[{\]}\\|'<,.>?/";:£§º©®\s]{1}$
        */
        //$text  = "index.home.raft";
        $regex = '/^\/*(?:\p{L}\p{M}*){1,}[・.。](?:\p{L}\p{M}*){1,}[・.。](?:\p{L}\p{M}*){1,}$/u';

        if (preg_match($regex, $three_word)){
            $data['validation_result'] = "Given word is the format of a three word address";
            $form_url = "https://api.what3words.com/v3/convert-to-coordinates?words=".urlencode($three_word)."&key=WSH62F9P"; 
               // $form_url = "https://api.what3words.com/v3/convert-to-coordinates?key=ZGJYC4Z7&words=".urlencode($three_word)."&format=json";
                $ch = curl_init();
            $headers = array(
                'Accept: application/json',
                'Content-Type: application/json',
            
                );
            curl_setopt($ch, CURLOPT_URL, $form_url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            //var_dump($result);die();
           // curl_close($curl);
            $lat_long_data = json_decode($result, TRUE);
           // var_dump($lat_long_data);die();
          $coordinates= $lat_long_data['coordinates'];
          foreach($coordinates as $key=>$valServices)
          {
            $latitude = $coordinates['lat'];
            $longitude = $coordinates['lng'];
          }

            $args = array(
                'country' => $lat_long_data['country'],
                //'square' => $lat_long_data['square'],
                'nearestPlace' => $lat_long_data['nearestPlace'],
                'lat' => $latitude,
                'lang' => $longitude,
                'words' => $lat_long_data['words'],
                'map' => $lat_long_data['map'],
                'validation_result' => 'Given word is the format of a three word address'
            );
            
            if($three_word == ''){
                $args['validation_result'] = '';
            }
           // $this->output->add_to_position($this->load->view('frontend/inc/validation_result_view', $data, TRUE), 'validation_result', TRUE);
            echo json_encode($args);die();
        }
        else{
            $args = array(
             
                'validation_result' => 'Given word is not a three word address'
            );
        
            if($three_word == ''){
                $args['validation_result'] = '';
            }
            echo json_encode($args);die();
           // $data['validation_result'] = "Given word is not a three word address";
       }
      
}

function show_amb_clo_pending(){
        
    $post_data = $this->input->post();
    
    $args = array('amb_reg_no'=>$post_data['amb_reg_no'],'filter_time'=>$post_data['filter_time']);
    $data['pending_incident'] = $this->inc_model->get_closure_pending_ambulance_wise($args);
    $amb_args = array('amb_rto_register_no'=>$post_data['amb_reg_no']);
    
    $data['clg_group'] = $this->clg->clg_group;
    $data['amb'] = $this->amb_model->get_amb_data($amb_args);
    $data['amb_reg_no'] = $post_data['amb_reg_no'];

    $this->output->add_to_position($this->load->view('frontend/inc/show_amb_clo_pending_view', $data, TRUE), 'popup_div', TRUE);
  
}
function show_amb_val_pending(){
        
    $post_data = $this->input->post();
     // print_r($post_data['filter_time']);die;
    $args = array('amb_reg_no'=>$post_data['amb_reg_no'],'filter_time'=>$post_data['filter_time']);
    $data['pending_incident'] = $this->inc_model->get_validation_pending_ambulance_wise($args);
    // print_r($data['pending_incident']);die;
    $amb_args = array('amb_rto_register_no'=>$post_data['amb_reg_no']);
    
    $data['clg_group'] = $this->clg->clg_group;
    $data['amb'] = $this->amb_model->get_amb_data($amb_args);
    $data['amb_reg_no'] = $post_data['amb_reg_no'];

    $this->output->add_to_position($this->load->view('frontend/inc/show_amb_val_pending_view', $data, TRUE), 'popup_div', TRUE);
  
}
    function show_amb_inc_details(){
        
        $post_data = $this->input->post();
         // var_dump($post_data );die();
        $args = array('amb_reg_no'=>$post_data['amb_reg_no']);
        $data['pending_incident'] = $this->inc_model->get_closure_pending_ambulance_wise($args);
       // var_dump(  $data['pending_incident'] );die();

        $amb_args = array('amb_rto_register_no'=>$post_data['amb_reg_no']);
        $data['amb'] = $this->amb_model->get_amb_data($amb_args);
        $data['amb_reg_no'] = $post_data['amb_reg_no'];
    
        $this->output->add_to_popup($this->load->view('frontend/inc/show_amb_inc_details_view', $data, TRUE), '800', '600');
        
    }

	function inc_temp_hospital(){
        $post_data = $this->input->post('dist_code');
        $data = array('dist_code'=>$post_data);
        $this->output->add_to_position($this->load->view('frontend/inc/inc_temp_hospital_view', $data, TRUE), 'inc_temp_hospital', TRUE);
    }
    public function otp_varification1(){
        $otp = $this->input->post('otp');
        $otp_inc_id = $this->input->post('otp_inc_id');

        $args = array('bed_otp'=>$otp,'inc_ref_id'=>$otp_inc_id);
        $inc_details = $this->inc_model->get_inc_details_otp($args);
        echo $inc_details;
        die();
        
    } 
    function confirm_non_mci_withoutamb_save(){
        $this->session->unset_userdata('mic_details');
        $this->session->unset_userdata('call_type');

        $call_type = $this->input->get();
        $inc_post_details = $this->input->post();
       
       // var_dump($inc_post_details);die();
        $inc_details = $this->input->get_post('incient');
        $patient = $this->input->get_post('patient');
        $caller_details = $this->input->get_post('caller');
        $call_type = $this->input->get_post('call_type');
       

        $dup_inc = $inc_details['dup_inc'];
        $datetime = date('Y-m-d H:i:s');

        $call_id = $this->input->get_post('call_id');
        $this->session->set_userdata('mic_details', $inc_details);
        $this->session->set_userdata('call_type', $call_type);
        $this->session->set_userdata('call_id', $call_id);
        $this->session->set_userdata('patient', $patient);
        $this->session->set_userdata('inc_datetime', $datetime);



        $session_caller_details = $this->session->userdata('caller_details_data');


        $this->session->set_userdata('inc_post_details', $inc_post_details);
        // var_dump( $this->input->get_post('caller'));
        // die();

        $data['police_chief'] = $this->call_model->get_police_chief_comp(array('po_ct_id' => $inc_details['police_chief_complete']));
        $data['fire_chief'] = $this->call_model->get_fire_chief_comp(array('fi_ct_id' => $inc_details['fire_chief_complete']));

        $data['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inc_details['inc_ero_standard_summary']));




        $data['nature'] = $this->inc_model->get_chief_comp_service($inc_details['chief_complete']);

        $this->session->unset_userdata('inc_ref_id');
        $inc_id = $this->session->userdata('inc_ref_id');

        // var_dump($inc_id);
        if ($inc_id == '' && $this->clg->clg_group != 'UG-BIKE-ERO') {
            $inc_id = generate_inc_ref_id();
            $this->session->set_userdata('inc_ref_id', $inc_id);
            update_inc_ref_id($inc_id);
            
        }else if($this->clg->clg_group == 'UG-BIKE-ERO'){
                 $inc_id = "BK-".generate_bk_inc_ref_id();
                 $this->session->set_userdata('inc_ref_id', $inc_id);
                update_inc_ref_id($inc_id);
        }
        //var_dump($inc_id);
        //  die();

        $data['inc_ref_id'] = $inc_id;
        $data['patient'] = $patient;

        $data['get_amb_details'] = $get_amb_details;
        $data['inc_details'] = $inc_details;


        $data['caller_details'] = $session_caller_details;
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];
        $data['hospital_id'] = $inc_details['hospital_id'];
        $data['hospital_other'] = $inc_details['hospital_other'];
        $data['place'] = $inc_details['place'];

        $data['cl_type'] = $call_type;
        $data['inc_datetime'] = $datetime;

        $this->output->add_to_popup($this->load->view('frontend/inc/confirm_non_mci_withoutamb_view', $data, TRUE), '600', '560');

    }
    function save_nonmci_withoutamb_inc(){
        $call_type = $this->input->get();
        $inc_details = $this->input->get_post('incient');
        $call_id = $this->input->get_post('call_id');
        $caller_details = $this->session->userdata('caller_details');
        $inc_details = $this->session->userdata('mic_details');
        //var_dump($inc_details);

        $inc_post_details = $this->session->userdata('inc_post_details');
        //var_dump($inc_post_details);

        $datetime = date('Y-m-d H:i:s');
        $datetime = $this->session->userdata('inc_datetime');

        $sft_id = get_cur_shift();

        $call_id = $this->session->userdata('call_id');


        $dup_inc = $inc_details['dup_inc'];

        $district_id = "0";
        $city_id = "0";
        $state_id = "0";

        $state_id = $this->inc_model->get_state_id($inc_details['state']);
        $district_id = $this->inc_model->get_district_id($inc_details['inc_district'], $state_id->st_code);

        $city_id = $this->inc_model->get_city_id($inc_details['incient_ms_city'], $district_id->dst_code, $state_id->st_code);
        
        
        $system = '108';
        


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
            $inc_post_details['incient_state'] = "MH";
        }
        $date = str_replace('-', '', date('Y-m-d'));

        $inc_id = $this->session->userdata('inc_ref_id');
        
        $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_id));
        if(!empty($is_exits)){
            $this->session->set_userdata('inc_ref_id','');
            $this->output->message = "<div class='error'>Incident Id alredy exists</div>";
            return;
        }

        $dispatch_time = $this->session->userdata('dispatch_time');

        $current_time = time();
        $res_time = $current_time - $dispatch_time;
        $h = ($res_time / (60 * 60)) % 24;
        $m = ($res_time / 60) % 60;
        if($inc_post_details['incient_districts'] == '')
                {
                    $district = $inc_post_details['incient_district'];
                }else{
                    $district = $inc_post_details['incient_districts'];
                }
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
            'inc_div_id' => $inc_post_details['incient_division'],
            'inc_address' => $inc_details['place'],
            'inc_tahshil_id' => $inc_post_details['incient_tahsil'],
            'inc_district_id' => $district,
            'inc_area' => $inc_details['area'],
            'inc_landmark' => $inc_details['landmark'],
            'inc_lane' => $inc_details['lane'],
            'inc_h_no' => $inc_details['h_no'],
            'inc_pincode' => $inc_details['pincode'],
            'inc_lat' => $inc_details['lat'],
            'inc_long' => $inc_details['lng'],
            'destination_hospital_id' => $inc_details['hos_id'],
            'destination_hospital_two' => $inc_details['hospital_two_id'],
            'destination_hospital_other' => $inc_details['hospital_other'],
            'bed_type' => $inc_details['bed_type'],
            // 'hospital_id' => $inc_details['hospital_id'],
           // 'hospital_name' => $inc_details['hospital_other'],
           // 'hospital_type' => 'ALL',
            'inc_datetime' => $datetime,
            'inc_service' => $inc_details_service,
           // 'inc_duplicate' => $dup_inc,
            'inc_base_month' => $this->post['base_month'],
            'inc_set_amb' => '0',
            'inc_suggested_amb' => $inc_details['inc_suggested_amb'],
            'inc_recive_time' => $inc_details['inc_recive_time'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_wht_three_wrd' => $inc_details['3word'],
            'bk_inc_ref_id' => $inc_id,
            'inc_thirdparty' => $this->clg->thirdparty,
            'inc_system_type' => $system,
            'followup_status'=> '1'
        );

        if ($inc_details['bed_type'] != '') {
            $incidence_details['admitted_status'] = 'book';
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
         if($inc_details['hospital_id'] != ''){
            $incidence_details['hospital_id'] = $inc_details['hospital_id'];
         }     
         if($inc_details['hospital_two_id'] != ''){
            $incidence_details['hospital_id'] = $inc_details['hospital_two_id'];
         }
         $priority_hospital = get_hospital_by_id($incidence_details['hospital_id']);
         $district_hospital = $priority_hospital[0]->hp_district;
         $hosp_type = get_hosp_type_by_id($priority_hospital[0]->hp_type);
         $incidence_details['hospital_type'] = $hosp_type;
         $incidence_details['hospital_district'] = $district_hospital;
         
        if($inc_details['hospital_id'] != ''){
             $pri_hospital_data = get_hospital_by_id($inc_details['hospital_id']);
             $pri_hosp_name = $pri_hospital_data[0]->hp_name;
             $pri_hosp_lat = $pri_hospital_data[0]->hp_lat;
             $pri_hosp_lng = $pri_hospital_data[0]->hp_long;
         }else{
             $pri_hospital_data = get_hospital_by_id($inc_details['hospital_two_id']);
             $pri_hosp_name = $pri_hospital_data[0]->hp_name;
             $pri_hosp_lat = $pri_hospital_data[0]->hp_lat;
             $pri_hosp_lng = $pri_hospital_data[0]->hp_long;
         }


       
        $sr_user = $this->clg->clg_ref_id;

        $patient = $this->input->get_post('patient');

        $patient = $this->session->userdata('patient');

        $EMT = "";

        $pilot = '';


        $tm_team_date = date('Y-m-d');

        $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id, $tm_team_date);
         $amb_details = $this->inc_model->get_ambulance_details_API($inc_details['amb_id']);
        $amb_lat = $amb_details[0]->amb_lat;
        $amb_log = $amb_details[0]->amb_log;
        $thirdparty = $amb_details[0]->thirdparty;
        $ward_id = $amb_details[0]->ward_id;
        $ward_name = $amb_details[0]->ward_name;
        $hp_id = $amb_details[0]->hp_id;
        $hp_name = $amb_details[0]->hp_name;
        
        //var_dump($ambulance_lat);die;
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
        if($thirdparty!='' || $thirdparty != '0'){
        $incidence_details['inc_thirdparty'] = $thirdparty;
        }
        else{
            $incidence_details['inc_thirdparty'] = $this->clg->thirdparty;
        }
       
      //  var_dump($incidence_details);die();
        $inc_data = $this->inc_model->insert_inc($incidence_details);
       //die();

       $args = array(
            'inc_id' => $inc_id,
            'caseStatus' => 'true',
            'vehicleName' => $inc_details['amb_id'],
            'caseOn' => $datetime,
            'vLat' => $amb_lat,
            'vLong' => $amb_log,
            'pLat' => $inc_details['lat'],
            'pLong' => $inc_details['lng'],
            'pationAddress' =>$inc_details['place'],
        );
       
       /* $api_url = "http://localhost/mhems_api/googlenotification";
		$json_data = array('ambulanceNo'=>$inc_details['amb_id'],
						   'incidentId'=>$inc_id,
						   'cheifComplaint' => get_cheif_complaint($inc_details['chief_complete']));

        $json_data= json_encode($json_data);
                
        $api_google = api_notification_app($api_url,$json_data);
        
        $args = array(
            'inc_id' => $inc_id,
            'caseStatus' => 'true',
            'vehicleName' => $inc_details['amb_id'],
            'caseOn' => $datetime,
            'vLat' => $amb_lat,
            'vLong' => $amb_log,
            'pLat' => $inc_details['lat'],
            'pLong' => $inc_details['lng'],
            'pationAddress' =>$inc_details['place'],
        );
        //var_dump($args);die();
       $send_API = send_API($args);
       */
      $caller_loc = $inc_details['place'];
        $caller_lat = $inc_details['lat'];
        $caller_lng = $inc_details['lng'];
        $destination_hos = $pri_hosp_name;
        $hos_lat = $pri_hosp_lat;
        $hos_lng = $pri_hosp_lng;
        $select_amb_API= str_replace('-','',$inc_details['amb_id']);
       // $select_amb = implode('',(explode("-",$inc_details['amb_id'])));
        $args = array(
            'LastActivityTime' => "$datetime" ,
            'JobStatus' => 'Dispatched' ,
            'onRoadStatus' =>'1' ,
            'Caller_Location' => "$caller_loc",
            'Hospital_Location' => "$destination_hos",
            'JobNo' => "$inc_id",
            'HospitalLatlong' => "$hos_lat".','."$hos_lng",
            'stateCode' => 'MP',
            'AmbulanceNo' =>"$select_amb_API",
            'CallerLatlong' =>"$caller_lat".','."$caller_lng"
        );
        $send_API = send_API($args);

       $sr_user = $this->clg->clg_ref_id;

        if ($dup_inc == 'No') {
            
   

            /*  if ($inc_details['service'][1] == '1') {
                  

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
            } */
        if ($dup_inc == 'No') {    
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
                    
                    $call_hisotory_args = array(
                        'incident_id' => $inc_id,
                        'ero_id'=>$this->clg->clg_ref_id,
                        'pda_id' => $police_user->clg_ref_id,
                        'pda_status' => 'ASG',
                        'incident_date' => $datetime,
                        'added_date' => $datetime
                );
                $police_operator = $this->common_model->insert_call_history($call_hisotory_args);
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
                    
                    $call_hisotory_args = array(
                        'incident_id' => $inc_re_id,
                        'ero_id'=>$this->clg->clg_ref_id,
                        'fda_id' => $fire_user->clg_ref_id,
                        'fda_status' => 'ASG',
                        'incident_date' => $datetime,
                        'added_date' => $datetime );
                        
                    $fda_operator = $this->common_model->insert_fda_call_history($call_hisotory_args);
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

          
        }

        if (!empty($patient)) {
            if (ucfirst($patient['first_name']) != '') {

                $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
                $last_pat_id = $last_insert_pat_id[0]->p_id + 1;
                //$last_pat_id = $this->clg->clg_id.'_'.$last_pat_id;
                $last_pat_id = generate_ptn_id();

                $incidence_patient_details = array('ptn_fname' => ucfirst($patient['first_name']),
                    'ptn_mname' => ucfirst($patient['middle_name']),
                    'ptn_lname' => ucfirst($patient['last_name']),
                    'ptn_gender' => $patient['gender'],
                    'ptn_fullname' => ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']),
                    'ptn_age' => $patient['age'],
                    'ptn_age_type' => $patient['age_type'],
                    'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                    'ptn_birth_date' => $patient['dob'],
                    'ptn_id' => $last_pat_id,
                    'ptn_added_by' => $this->clg->clg_ref_id,
                    'ptn_added_date' => date('Y-m-d H:i:s'),
                );
                $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
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
                if($inc_details['que_lan']=="")
                {
                    $inc_details['que_lan']="0";
                
                }
                $ems_summary = array('sum_base_month' => $this->post['base_month'],
                    'sum_sub_id' => $inc_id,
                    'sum_sub_type' => $inc_details['inc_type'],
                    'sum_que_id' => $key,
                    'sum_que_ans' => $ques,
                    'sum_que_lan' => $inc_details['que_lan']
              
                );

                $this->inc_model->insert_ems_summary($ems_summary);
            }
        }

        /* send sms to patient */
      /*  $sms_amb = $inc_details['amb_id'];
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
        $str = ltrim($sms_doctor_contact_no, '0');
        $patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];
        $patient_mobile_no = $caller_details['clr_mobile'];
        $inc_address = $inc_details['place'];
        $chief_complaint = get_cheif_complaint($incidence_details['inc_complaint']);
       // $hospital_name = $inc_details['hos_name'];
        if($inc_details['hos_name']!='' || $inc_details['hos_name']!='null'){
            $hospital_name = $inc_details['hos_name'];
        }else{
            $hospital_name = $inc_details['hospital_other'];
        }
        //$patient_sms_text = "Ambulance dispatched: $sms_amb\n Ambulance Contact - $sms_doctor_contact_no\n Track Link- $amb_url\n";
        
       // $txtMsg1.= "Dear ".$patient_full_name."\n";
        $txtMsg1.= "Ambulance dispatched: ".$sms_amb."\n";
        $txtMsg1.= "Ambulance Contact - ".$sms_doctor_contact_no."\n" ;
       // $txtMsg1.= "TrackAmbulance- ".$amb_url."\n";
        $txtMsg1.= "JAES" ;
        $sms_to = $caller_details['clr_mobile'];
        $args = array(
            'inc_id' => $inc_id,
            'msg' => $txtMsg1,
            'mob_no' => $sms_to,
            'sms_user'=>'patient',
        );
       $sms_data = sms_send($args);
         /* send sms to doctor  */
     /*   $patient_name = $caller_details['clr_fname'];
            
            $txtMsg2.= "Patient name: ".$patient_full_name."\n"; 
            $txtMsg2.= "Address: ".$inc_address."\n";
            $txtMsg2.= "Caller No: ".$patient_mobile_no."\n";
            $txtMsg2.= "Incident id: ".$inc_id."\n";
            $txtMsg2.= "Hospital Name- ".$hospital_name."\n";
           // $txtMsg2.= "Track Ambulance- ".$amb_url."\n";
            $txtMsg2.= "JAES" ;
      
        $sms_to = $sms_doctor_contact_no;
        $args = array(
            'inc_id' => $inc_id,
            'msg' => $txtMsg2,
            'mob_no' => $sms_to,
            'sms_user'=>'amb_no',
        );
        $sms_data = sms_send($args);
        
     */
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


        $url = base_url("calls");
        $this->output->message = "<h3>Non-MCI Call</h3><br><p>Bed Booked Successfully</p><script>window.location.href = '".$url."';</script>";



        $this->output->moveto = 'top';



        $this->output->add_to_position('', 'content', TRUE);
		
		
		
		 
    } 
//    function save_denial_reason()
//	{
//        $data['added_by']  = $this->clg->clg_ref_id;
//        // var_dump($data['added_by']);die();
//		$data['amb_no']=$this->input->post('amb_no');
//		$data['amb_district']=$this->input->post('amb_district');
//		$data['hp_name']=$this->input->post('hp_name');
//		$data['amb_default_mobile']=$this->input->post('amb_default_mobile');
//		$data['amb_pilot_mobile']=$this->input->post('amb_pilot_mobile');
//		$data['challenge_val']=$this->input->post('challenge_val');
//        $data['denial_remark']=$this->input->post('denial_remark');
//        $data['emso_id']=$this->input->post('emso_id');
//        $data['pilot_id']=$this->input->post('pilot_id');
//        $data['conversation_done']=$this->input->post('conversation_done');
//        $data['conversation_name']=$this->input->post('conversation_name');
//               
//		$emso_challenge=$this->input->post('emso_challenge');
//		$pilot_challenge=$this->input->post('pilot_challenge');
//		$equipment_challenge=$this->input->post('equipment_challenge');
//		$tech_challenge=$this->input->post('tech_challenge');
// 
//        if($emso_challenge!='')
//        {
//            $reason =  $emso_challenge;
//        }else if($pilot_challenge!='')
//        {
//            $reason =  $pilot_challenge;
//        }else if($equipment_challenge!='')
//        {
//            $reason =  $equipment_challenge;
//        }else if($tech_challenge!='')
//        {
//            $reason =  $tech_challenge;
//        }
//        $data['meaning']=$reason;
//        
//               
//        if($data['meaning'] == '32' || $data['meaning'] == 32){
//            $args = array('amb_no'=>$this->input->post('amb_no'));
//            $amb_incident = $this->inc_model->get_last_incident_by_amb($args);
//            $data['last_inc_datetime']=$amb_incident[0]->inc_datetime;
//            $data['last_inc_ref_id']=$amb_incident[0]->inc_ref_id;
//        
//        }
//        
//		$data['added_date']=date('Y-m-d H:i:s');
//		// $data['added_by']=$this->clg->clg_ref_id;
//		// var_dump($data); 
//		$den = $this->Dashboard_model->save_denial($data);
//        $denial_id = array();
//        $denial_id = $this->session->userdata('denial_id');
//        $denial_id[] = $den;
//        $this->session->set_userdata('denial_id',$denial_id);
//                
////        if($den == 1){
////            echo json_encode("Saved Successfully");
////        }	
//        echo $den;
//        die();
//	}   
//    
    
        function save_denial_reason(){
        $data['added_by']  = $this->clg->clg_ref_id;
        // var_dump($data['added_by']);die();
		$data['amb_no']=$this->input->post('amb_no');
		$data['amb_district']=$this->input->post('amb_district');
		$data['hp_name']=$this->input->post('hp_name');
		$data['amb_default_mobile']=$this->input->post('amb_default_mobile');
		$data['amb_pilot_mobile']=$this->input->post('amb_pilot_mobile');
		$data['conversation_name']=$this->input->post('conversation_name');
		$data['conversation_done']=$this->input->post('conversation_done');
		$data['denial_remark']=$this->input->post('denial_remark');
		$data['pilot_id']=$this->input->post('pilot_id');
		$data['emso_id']=$this->input->post('emso_id');
		$data['challenge_val']=$this->input->post('challenge_val');

		$emso_challenge=$this->input->post('emso_challenge');
		$pilot_challenge=$this->input->post('pilot_challenge');
		$equipment_challenge=$this->input->post('equipment_challenge');
		$tech_challenge=$this->input->post('tech_challenge');

        if($emso_challenge!='')
        {
            $reason =  $emso_challenge;
        }else if($pilot_challenge!='')
        {
            $reason =  $pilot_challenge;
        }else if($equipment_challenge!='')
        {
            $reason =  $equipment_challenge;
        }else if($tech_challenge!='')
        {
            $reason =  $tech_challenge;
        }
        $data['meaning']=$reason;
		$data['added_date']=date('Y-m-d H:i:s');
		// $data['added_by']=$this->clg->clg_ref_id;
		// var_dump($data); 
		$den = $this->Dashboard_model->save_denial($data);
        //var_dump($den);
       //die();
       
        if($den == 1){
            echo json_encode("Saved Successfully");
        }		
	}   
    function validate_user(){
        $data['dist'] = $this->common_model->get_district(array('st_id' => 'MP'));
        $this->output->add_to_position($this->load->view('frontend/valid_user/valid_user_view', $data, TRUE), 'content', TRUE);
    } 
    function show_validate_user(){
        $clg_district_id =  $this->input->post('clg_district_id');
        $args = array('district_id' => $clg_district_id);
        $data['amb_data'] = $this->inv_model->get_emso_pilot($args);
        $amb_data=$data['amb_data'];
        // var_dump($amb_data);die;
        foreach($amb_data as $data) {
        //var+
        $new_data[] = $data;
    }
        echo json_encode($new_data);
        die();
    }
    function show_hospital_address(){
        $hp = $this->input->post('hp_id');
        
        
        $agrs = array();
        
        $agrs['hp_id'] = $hp;
        $data['dt_rel'] = 'hosp_add';
        

        $hosp = $this->hp_model->get_hos_data($agrs);
        
        
        $division = $this->common_model->get_division(array('st_id' => 'MP', 'div_code' =>$hosp[0]->div_id));
             //var_dump($division);


            ////////////////////////////////////////
             
            $data['div_code'] = $division[0]->div_code;
            $data['div_name'] = $division[0]->div_name;
            //var_dump($division[0]->div_code);
            //die();
            $this->output->add_to_position($this->load->view('frontend/common/auto_div_view', $data, TRUE), $data['dt_rel'] . '_div', TRUE);
        
      
           $data['dst_code'] = $hosp[0]->dst_code;
           $this->output->add_to_position($this->load->view('frontend/common/auto_dist_view', $data, TRUE), $data['dt_rel'] . '_dist', TRUE);
           
            $data['thl_id'] = $hosp[0]->hp_tahsil;
            $data['dst_code'] = $hosp[0]->dst_code;
            $this->output->add_to_position($this->load->view('frontend/common/auto_tahsil_view', $data, TRUE), $data['dt_rel'] . '_tahsil', TRUE);
            
            
            $data['cty_id'] = $hosp[0]->hp_city;
            $data['dst_code'] = $hosp[0]->dst_code;
           $this->output->add_to_position($this->load->view('frontend/common/auto_city_view', $data, TRUE), $data['dt_rel'] . '_city', TRUE);
             $data['area'] =  ($hosp[0]->hp_area != '' && $hosp[0]->hp_area != '0') ? $hosp[0]->hp_area: '';
            $this->output->add_to_position($this->load->view('frontend/common/auto_area_view', $data, TRUE), $data['dt_rel'] . '_area', TRUE);
            
             $data['landmark'] = ($hosp[0]->hp_lmark != '' && $hosp[0]->hp_lmark != '0') ? $hosp[0]->hp_lmark: '';
            $this->output->add_to_position($this->load->view('frontend/common/auto_lmark_view', $data, TRUE), $data['dt_rel'] . '_lmark', TRUE);
       
    }


}
