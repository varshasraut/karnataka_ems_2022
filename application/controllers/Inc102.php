<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class INC102 extends EMS_Controller {

    function __construct() {

        parent::__construct();
        $this->active_module = "M-INC";
        $this->pg_limit = $this->config->item('pagination_limit');
        $this->load->model(array('inc_model', 'get_city_state_model', 'options_model', 'module_model', 'amb_model', 'call_model', 'pet_model', 'hp_model', 'pcr_model', 'colleagues_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper','cct_helper'));
        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));
        $this->post = $this->input->get_post(NULL);
        $this->clg = $this->session->userdata('current_user');
        $this->post['base_month'] = get_base_month();

        $this->google_api_key = $this->config->item('google_api_key');
        //$this->check_user_permission($this->session->userdata('current_user')->clg_id , $this->session->userdata('current_user')->clg_group );
    }
    function confirm_pickup_save(){
        $this->session->unset_userdata('incient');
        $this->session->unset_userdata('inter');
        $this->session->unset_userdata('call_type');

        $call_type = $this->input->get();
        $call_type = $this->input->get_post('call_type');
        
        $inc_post_details = $this->input->post();

        $inc_details = $this->input->get_post('incient');
        $inter_details = $this->input->get_post('inter');
        $patient = $this->input->get_post('patient');
        $caller_details = $this->input->get_post('caller');
        $datetime = date('Y-m-d H:i:s');


        $dup_inc = $inc_details['dup_inc'];
        
        if($inc_post_details['call_type'] == 'terminate'){
            if($inc_details['amb_id'] != ''){

                $this->output->message = "<div class='error'>Remove Ambulance Selected ambulance</div>";
                return;

            }
        }

        $call_id = $this->input->get_post('call_id');
        $this->session->set_userdata('mic_details', $inc_details);
        $this->session->set_userdata('incient', $inc_details);
        $this->session->set_userdata('inter', $inter_details);
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

        if($call_type != 'terminate'  && $call_type != 'transfer_108' && $call_type != 'transfer_102'  && $call_type != 'enable_dispatch'){
            if ($inc_details['amb_id'] == '' && $dup_inc == 'No') {

                $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";

                return;
            }
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
            update_inc_ref_id($inc_id);
            $this->session->set_userdata('inc_ref_id', $inc_id);
        }
        //var_dump($inc_id);die();
        $data['inc_ref_id'] = $inc_id;
        $data['patient'] = $patient;

        $data['get_amb_details'] = $get_amb_details;
        $data['inc_details'] = $inc_details;

        $data['hospital_id'] = $inc_details['hospital_id'];
        $data['hospital_other'] = $inc_details['hospital_other'];
        $data['caller_details'] = $session_caller_details;
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];

        $data['place'] = $inc_details['place'];

        $data['cl_type'] = $call_type;
        $data['inc_datetime'] = $datetime;
       // var_dump($data['inc_ref_id']);
        $this->output->add_to_popup($this->load->view('frontend/inc/confirm_pickup_view', $data, TRUE), '600', '560');

    }
    function app_confirm_save() {
        // echo "hii";die;
        $this->session->unset_userdata('mic_details');
        $this->session->unset_userdata('call_type');       
        $inc_post_details = $this->input->post();
        $call_type = $inc_post_details['incient']['inc_type'];
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
        // $this->session->set_userdata('call_type', $call_type);
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
    function amb_drop_back_not_assi_save(){
        $non_eme_call = $this->input->get_post('non_eme_call');
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
        $incidence_details = array('inc_cl_id' => $call_id,
        'inc_ref_id' => $inc_id,
        'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
        'inc_type' => $cl_type,
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
            $this->session->set_userdata('amb_not_assi_details', $amb_call);
            $data1['reason'] = $this->call_model->get_district_name(array('inc_district_id' => $amb_call['inc_district_id']));
            $amb_call['dst_name'] =  $data1['reason'][0]->dst_name;
            $amb_call['details'] = $this->get_amb_detailed_data($ambulances); 
            // print_r($amb_call['inc_type']);die;
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
        $this->session->set_userdata('call_id', $call_id);
        // $call_id = $this->input->get_post('call_id');
        $patient = $this->session->userdata('patient');
        $caller_details = $this->session->userdata('caller_details');
        // print_r($caller_details);die;

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
    function confirm_dropback_save() {

        $this->session->unset_userdata('incient');
        $this->session->unset_userdata('inter');
        $this->session->unset_userdata('call_type');

        $call_type = $this->input->get();
        $call_type = $this->input->get_post('call_type');
        
        $inc_post_details = $this->input->post();

        $inc_details = $this->input->get_post('incient');
        $inter_details = $this->input->get_post('inter');
        $patient = $this->input->get_post('patient');
        $caller_details = $this->input->get_post('caller');
        $datetime = date('Y-m-d H:i:s');


        $dup_inc = $inc_details['dup_inc'];
        
        if($inc_post_details['call_type'] == 'terminate'){
            if($inc_details['amb_id'] != ''){

                $this->output->message = "<div class='error'>Remove Ambulance Selected ambulance</div>";
                return;

            }
        }

        $call_id = $this->input->get_post('call_id');
        $this->session->set_userdata('mic_details', $inc_details);
        $this->session->set_userdata('incient', $inc_details);
        $this->session->set_userdata('inter', $inter_details);
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

        if($call_type != 'terminate'  && $call_type != 'transfer_108' && $call_type != 'transfer_102'  && $call_type != 'enable_dispatch'){
            if ($inc_details['amb_id'] == '' && $dup_inc == 'No') {

                $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";

                return;
            }
        }

        if ($inc_details["amb_id"]) {

            foreach ($inc_details["amb_id"] as $amb) {

                $args = array(
                    'rg_no' => $amb,
                );



                $get_amb_details[] = $this->inc_model->get_amb_details($args);
            }
        }

        //$inc_id = $this->session->userdata('inc_ref_id');
        if ($inc_id == '') {
             $inc_id = generate_inc_ref_id();
            $this->session->set_userdata('inc_ref_id', $inc_id);
            update_inc_ref_id($inc_id);
//            $inc_id = generate_102_inc_ref_id();
//            update_102_inc_ref_id($inc_id);
//            $this->session->set_userdata('inc_ref_id', $inc_id);
        }
        $data['inc_ref_id'] = $inc_id;
        $data['patient'] = $patient;

        $data['get_amb_details'] = $get_amb_details;
        $data['inc_details'] = $inc_details;

        $data['hospital_id'] = $inc_details['hospital_id'];
        $data['hospital_other'] = $inc_details['hospital_other'];
        $data['caller_details'] = $session_caller_details;
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];

        $data['place'] = $inc_details['place'];

        $data['cl_type'] = $call_type;
        $data['inc_datetime'] = $datetime;

        $this->output->add_to_popup($this->load->view('frontend/inc/confirm_dropback_view', $data, TRUE), '600', '560');

        //   $this->output->add_to_position($this->load->view('frontend/patient/pt_inc_summary_view', $data, TRUE), 'summary_div', TRUE);
    }
    function save_pickup(){
        $call_type = $this->input->get();
        $inc_details = $this->input->get_post('incient');
        $inter_details = $this->input->get_post('inter');
        $call_id = $this->input->get_post('call_id');
        $caller_details = $this->session->userdata('caller_details');
        $inc_details = $this->session->userdata('mic_details');
        $inter_details = $this->session->userdata('inter');
        $inc_post_details = $this->session->userdata('inc_post_details');
        $patient= $this->session->userdata('patient');
        $cl_type = $this->input->get_post('cl_type');

        
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
            $inc_post_details['incient_state'] = "MP";
        }
        $date = str_replace('-', '', date('Y-m-d'));

        //$inc_id = $date.$call_id;
        $inc_id = $this->session->userdata('inc_ref_id');




        $sr_user = $this->clg->clg_ref_id;

        $sms_amb_details = $inc_details['amb_id'];
        
        if($call_type != 'terminate'  && $call_type != 'transfer_108' && $call_type != 'transfer_102'){
            if ($inc_details['amb_id'] == '' && $dup_inc == 'Yes' ) {

                $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";

                return;
            }
        }


        if($inc_details['inc_ref_id'] != ""){
            if ($dup_inc == 'No') {
            $amb_count =0;
            $inc_re_id = $inc_id;
            foreach ($inc_details['amb_id'] as $key=>$select_amb) {
                $amb_count++;
                $inc_re_id = $inc_details['inc_ref_id'];
                
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
                'inc_back_hospital' => $inter_details['facility'],
                'current_district' => $inter_details['current_district'],
                'inc_back_home_address' => $inc_details['home_address'],
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
                'inc_district_id' => $district,
                'inc_area' => $inc_details['area'],
                'inc_landmark' => $inc_details['landmark'],
                'inc_lane' => $inc_details['lane'],
                'inc_h_no' => $inc_details['h_no'],
                'inc_pincode' => $inc_details['pincode'],
                'inc_lat' => $inc_details['lat'],
                'inc_long' => $inc_details['lng'],
                'destination_hospital_id' => $inc_details['hospital_id'],
                'destination_hospital_other' => $inc_details['hospital_other'],
                'inc_datetime' => $datetime,
                'inc_service' => $inc_details_service,
                'inc_duplicate' => $dup_inc,
                'inc_base_month' => $this->post['base_month'],
                //'inc_set_amb' => '1',
                'inc_recive_time' => $inc_details['inc_recive_time'],
                'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
                'inc_added_by' => $this->clg->clg_ref_id,
                'inc_wht_three_wrd' => $inc_details['3word'],
                'bk_inc_ref_id' => $inc_id,
                'inc_thirdparty' => $this->clg->thirdparty,
                 'inc_system_type' => $system  
            );
                  
        
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
        
        
        $incidence_details['hospital_id'] = $inter_details['facility'];
        
        $priority_hospital = get_hospital_by_id($inter_details['facility']);
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
              $this->call_model->update_booking_details($caller_details['clr_mobile']);

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
        //var_dump($args);die();
        
        $denial_id = $this->session->userdata('denial_id');
        if($denial_id){
            foreach($denial_id as $denial){
                $com_args = array('inc_ref_id'=>$inc_id,'id'=>$denial);
                $update_app_call_details = $this->Dashboard_model->update_denial($com_args);

            } 
        }
        
      // $send_API = send_API($args);
                $inc_details['amb_id'] = $select_amb;
                $EMT = "";
                $pilot = '';        
                $emp_inc_data = $this->inc_model->get_amb_emp($inc_details['amb_id'], $sft_id);

                if (empty($emp_inc_data)) {
                    $tm_team_date = date('Y-m-d');
                    $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);
                  

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

                if($pilot != ''){
                    $args_operator1 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $pilot,
                        'operator_type' => 'UG-PILOT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'PICK_UP',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator1 = $this->common_model->assign_operator($args_operator1);
                }

                if($EMT != ''){
                    $args_operator2 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $EMT,
                        'operator_type' => 'UG-EMT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'PICK_UP',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator2 = $this->common_model->assign_operator($args_operator2);
                }

                
                $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);

                $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
                
                 $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                if ($inc_details['chief_complete_other'] != '') {
                    $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                //die();
                

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
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                        'ptn_mob_no' => $patient['ptn_mob_no'],
                        'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                    $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }
                
                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "PICK_UP",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                
            }

            if ($inc_details['stand_amb_id']) {

                foreach ($inc_details['stand_amb_id'] as $key=>$stand_amb_id) {
                    
                    
                  if($inc_post_details['incient_districts'] == '')
                {
                    $district = $inc_post_details['incient_district'];
                }else{
                    $district = $inc_post_details['incient_districts'];
                }    
                $inc_re_id = $inc_details['inc_ref_id'];
                $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_type' => $inc_details['inc_type'],
                'inc_back_hospital' => $inter_details['facility'],
                'current_district' => $inter_details['current_district'],
                'inc_back_home_address' => $inc_details['home_address'],
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
                'inc_recive_time' => $inc_details['inc_recive_time'],
                'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
                'inc_added_by' => $this->clg->clg_ref_id,
                'inc_wht_three_wrd' => $inc_details['3word'],
                'bk_inc_ref_id' => $inc_id,
                'inc_thirdparty' => $this->clg->thirdparty,
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
                $incidence_details['hospital_id'] = $inter_details['facility'];
        
        $priority_hospital = get_hospital_by_id($inter_details['facility']);
        $district_hospital = $priority_hospital[0]->hp_district;
        $hosp_type = get_hosp_type_by_id($priority_hospital[0]->hp_type);
        $incidence_details['hospital_type'] = $hosp_type;
        $incidence_details['hospital_district'] = $district_hospital;

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
                        $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);

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
                    $amb_details = $this->inc_model->get_ambulance_details_API($inc_details['amb_id']);
                    $amb_lat = $amb_details[0]->amb_lat;
                    $amb_log = $amb_details[0]->amb_log;
                    $thirdparty = $amb_details[0]->thirdparty;
                    $ward_id = $amb_details[0]->ward_id;
                    $ward_name = $amb_details[0]->ward_name;
                    $hp_id = $amb_details[0]->hp_id;
                    $hp_name = $amb_details[0]->hp_name;

                    $incidence_amb_details = array('amb_rto_register_no' => $inc_details['stand_amb_id'],
                        'inc_ref_id' => $inc_re_id,
                        'ward_id' => $ward_id,
                        'ward_name' => $ward_name,
                        'base_location_id' => $hp_id,
                        'base_location_name' => $hp_name,
                        'amb_pilot_id' => $pilot,
                        'amb_emt_id' => $EMT,
                        'amb_type'=> 'standby',
                        'inc_base_month' => $this->post['base_month'],
                        'assigned_time' => $datetime);

                    $this->inc_model->insert_inc_amb($incidence_amb_details);
                    
                    if($pilot != ''){
                    
                        $args_operator1 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $pilot,
                            'operator_type' => 'UG-PILOT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'PICK_UP',
                            'base_month' => $this->post['base_month']
                        );
                        $args_operator1 = $this->common_model->assign_operator($args_operator1);
                    }

                    if($EMT != ''){
                        $args_operator2 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $EMT,
                            'operator_type' => 'UG-EMT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'PICK_UP',
                            'base_month' => $this->post['base_month']
                        );

                        $args_operator2 = $this->common_model->assign_operator($args_operator2);
                    }
                    
                
                    $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                    if ($inc_details['chief_complete_other'] != '') {
                        $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                    }

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
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_birth_date' => $patient['dob'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')    
                    );

                $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $denial_id = $this->session->userdata('denial_id');
                if($denial_id){
                    foreach($denial_id as $denial){
                        $com_args = array('inc_ref_id'=>$inc_re_id,'id'=>$denial);
                        $update_app_call_details = $this->Dashboard_model->update_denial($com_args);

                    } 
                }
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }

                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "PICK_UP",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                }
            }
        }

        //update_102_inc_ref_id($inc_id);
        $call_history_id = $this->session->userdata('call_history_id');
			
		_ucd_dispatch_call($inc_details['inc_ref_id'],$this->clg->clg_ref_id,$call_history_id);


        /* send sms to patient  */
        $sms_amb = $inc_details['amb_id'];
        $get_mobile_no = array('rg_no' => $sms_amb);
        $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);
        $driver = $this->colleagues_model->get_user_info($pilot);
        $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;
        $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;

        //$inc_id = $inc_id;
        // $amb_url = base_url() . "amb/loc/" . $inc_re_id;
        $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_re_id;

        //$amb_url = "http://210.212.165.123/tdd/amb/loc/" . $inc_id;
        //$amb_dir_url = "http://210.212.165.123/tdd/amb/amb_dir/" . $inc_id;



        $doctor = $this->colleagues_model->get_user_info($EMT);
        $sms_doctor = $doctor[0]->clg_first_name;
        $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;
        $patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];
        $patient_mobile_no = $caller_details['clr_mobile'];
        //$patient_mobile_no = "9730015484";
        $patient_name = $caller_details['clr_fname'];

        //$patient_sms_text = "Ambulance dispatched: $sms_amb\n Ambulance Contact - $sms_doctor_contact_no\n Track Link- $amb_url\nJAES";
        $sms_amb1 = implode('',(explode("-",$sms_amb)));
        $txtMsg1 = '';
        $txtMsg1.= "Dear ".$patient_full_name.", \n";
        $txtMsg1.= "Ambulance dispatched: ".$sms_amb1 .", \n";
        $txtMsg1.= "Ambulance Contact: ".$sms_doctor_contact_no .", \n" ;
        //$txtMsg1.= "Link: ".$amb_dir_url."\n" ;
        $txtMsg1 .= "Please click on the following link for downloading the 108 Sanjeevani app on your mobile Android User - https://tinyurl.com/2p87kfu6 and iOS User- https://tinyurl.com/3pup8pp4\n";
        $txtMsg1.= "JAES" ;

        $patient_sms_to = $caller_details['clr_mobile'];
        //$patient_sms_to =  "8551995260";
        $args = array(
            'msg' => $txtMsg1,
            'mob_no' => $patient_sms_to,
            'sms_user'=>'Patient',
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

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];
        $chief_complaint = get_cheif_complaint($incidence_details['inc_complaint']);
        // $hospital_name = $inc_details['hos_name'];
         if($inc_details['hos_name']!='' || $inc_details['hos_name']!='null'){
             $hospital_name = $inc_details['hos_name'];
         }else{
             $hospital_name = $inc_details['hospital_other'];
         }
         if($hospital_name==''){
            $hospital_name='NA';
        }
        $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
        //$doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call 108 ERC for Case ID creation.  JAES";
        $datetime = date('d-m-Y H:i:s');
            $txtMsg2 ='';
            $txtMsg2.= "Patient name: ".$patient_full_name.",\n"; 
            $txtMsg2.= " Address: ".$inc_address.",\n";
            $txtMsg2.= " Caller No: ".$patient_mobile_no.",\n";
            $txtMsg2.= " Incident Date Time: ".$datetime.",\n";
            $txtMsg2.= " Incident id: ".$inc_re_id.",\n";
            $txtMsg2.= " Chief Complaint: ".$chief_complaint.",\n";
            $txtMsg2.= " Hospital Name- ".$hospital_name.",\n";
            $txtMsg2.= " JAES" ;

            $sms_to = $sms_doctor_contact_no;
            $args = array(
                'msg' => $txtMsg2,
                'mob_no' => $sms_to,
                'sms_user'=>'EMT',
                'inc_id'=>$inc_re_id,
            );
            $sms_data = sms_send($args);
            $mno = $sms_to;
            $mno = substr($mno, -10);
            $inc_link_args = array( 'mobile_no'=>$mno,
                                    'incident_id'=>$inc_re_id,
                                    'track_link'=>$amb_dir_url,
                                    'added_date' =>   date('Y-m-d H:i:s'));
            
            $inc_link = $this->call_model->insert_track_link($inc_link_args); 
        /* send sms to Pilot  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];

       // $driver_sms_text = "Dear Pilot, Patient name: $patient_full_name,  Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id , Patient id:$last_pat_id  Navigate- $amb_dir_url JAES";
       $datetime = date('d-m-Y H:i:s');
            $txtMsg2 ='';
            $txtMsg2.= "Patient name: ".$patient_full_name.",\n"; 
            $txtMsg2.= " Address: ".$inc_address.",\n";
            $txtMsg2.= " Caller No: ".$patient_mobile_no.",\n";
            $txtMsg2.= " Incident Date Time: ".$datetime.",\n";
            $txtMsg2.= " Incident id: ".$inc_re_id.",\n";
            $txtMsg2.= " Chief Complaint: ".$chief_complaint.",\n";
            $txtMsg2.= " Hospital Name- ".$hospital_name.",\n";
            $txtMsg2.= " JAES" ;

       $sms_to = $sms_driver_contact_no;
       $args = array(
           'msg' => $txtMsg2,
           'mob_no' => $sms_to,
           'sms_user'=>'EMT',
           'inc_id'=>$inc_re_id,
       );
       $sms_data = sms_send($args);
       $mno = $sms_to;
       $mno = substr($mno, -10);
       $inc_link_args = array( 'mobile_no'=>$mno,
                               'incident_id'=>$inc_re_id,
                               'track_link'=>$amb_dir_url,
                               'added_date' =>   date('Y-m-d H:i:s'));
       
       $inc_link = $this->call_model->insert_track_link($inc_link_args); 
        

        if ($call_type['cl_type'] == 'transfer_108') {

            _ucd_assign_call($inc_re_id);
        }
        
        if ($call_type['cl_type'] == 'transfer_102') {

            _ucd_102_assign_call($inc_re_id,$this->clg->clg_group);
        }
        
        $this->output->status = 1;
        $this->output->closepopup = "yes";
        ($call_type['cl_type'] == 'forword') ? $msg = "forworded" : $msg = "Added";
        $url = base_url("calls");
        $this->output->message = "<h3>Drop Back Call</h3><br><p>Ambulance Dispatch Successfully</p><script>window.location.href = '".$url."';</script>";
        $this->output->moveto = 'top';
        $this->output->add_to_position('', 'content', TRUE);
        
        }else{
        if ($dup_inc == 'No') {
            $amb_count =0;
            $inc_re_id = $inc_id;
            if($inc_details['amb_id']){
                foreach ($inc_details['amb_id'] as $key=>$select_amb) {
                $amb_count++;
                $inc_re_id = $inc_id;
                
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
                'inc_back_hospital' => $inter_details['facility'],
                'current_district' => $inter_details['current_district'],
                'inc_back_home_address' => $inc_details['home_address'],
                'inc_ero_summary' => $inc_details['inc_ero_summary'],
                'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
                'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
                'inc_dispatch_time' => $inc_details['caller_dis_timer'],
                // 'inc_city' => $inc_details['inc_city'],
                'inc_city_id' => $inc_post_details['incient_ms_city'],
                //'inc_state' => $inc_post_details['incient_state'],
                'inc_state_id' => $inc_post_details['incient_state'],
                'inc_address' => $inc_details['place'],
                 'inc_tahshil_id' => $inc_post_details['incient_tahsil'],
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
                //'inc_set_amb' => '1',
                'inc_recive_time' => $inc_details['inc_recive_time'],
                'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
                'inc_added_by' => $this->clg->clg_ref_id,
                'inc_system_type' => $system
            );
                
        
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
                $incidence_details['hospital_id'] = $inter_details['facility'];
        
        $priority_hospital = get_hospital_by_id($inter_details['facility']);
        $district_hospital = $priority_hospital[0]->hp_district;
        $hosp_type = get_hosp_type_by_id($priority_hospital[0]->hp_type);
        $incidence_details['hospital_type'] = $hosp_type;
        $incidence_details['hospital_district'] = $district_hospital;
            
            
                $inc_details['amb_id'] = $select_amb;
                $EMT = "";
                $pilot = '';        
                $emp_inc_data = $this->inc_model->get_amb_emp($inc_details['amb_id'], $sft_id);

                if (empty($emp_inc_data)) {
                    $tm_team_date = date('Y-m-d');
                    $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);
                  

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
                
                 $drop_back = array(
                'home_city_id' => $inc_post_details['incient_ms_city'],
                'home_state_id' => $inc_post_details['incient_state'],
                'home_address' => $inc_details['place'],
                //'home_tahsil_id' => $inc_post_details['incient_district'],
                'home_district_id' => $inc_post_details['incient_districts'],
                'home_location' => $inc_details['area'],
                'home_landmark' => $inc_details['landmark'],
                'home_lane' => $inc_details['lane'],
                'home_houseno' => $inc_details['h_no'],
                'home_pin' => $inc_details['pincode'],
                'inc_ref_id'=>$inc_re_id);
            
               $drop_back_data = $this->inc_model->insert_dropback($drop_back);

                if($pilot != ''){
                    $args_operator1 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $pilot,
                        'operator_type' => 'UG-PILOT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'PICK_UP',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator1 = $this->common_model->assign_operator($args_operator1);
                }

                if($EMT != ''){
                    $args_operator2 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $EMT,
                        'operator_type' => 'UG-EMT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'PICK_UP',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator2 = $this->common_model->assign_operator($args_operator2);
                }

                
                $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);

                $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
                
                 $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                if ($inc_details['chief_complete_other'] != '') {
                    $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                
                
                $drop_back = array(
                                    'home_city_id' => $inc_post_details['incient_ms_city'],
                                    'home_state_id' => $inc_post_details['incient_state'],
                                    'home_address' => $inc_details['place'],
                                    //'home_tahsil_id' => $inc_post_details['incient_district'],
                                    'home_district_id' => $inc_post_details['incient_districts'],
                                    'home_location' => $inc_details['area'],
                                    'home_landmark' => $inc_details['landmark'],
                                    'home_lane' => $inc_details['lane'],
                                    'home_houseno' => $inc_details['h_no'],
                                    'home_pin' => $inc_details['pincode'],
                                    'inc_ref_id'=>$inc_re_id);
            
                        $drop_back_data = $this->inc_model->insert_dropback($drop_back);


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
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_birth_date' => $patient['dob'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                    $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }
                
                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "PICK_UP",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                
            }
            }
            
            if ($inc_details['stand_amb_id']) {

                foreach ($inc_details['stand_amb_id'] as $key=>$stand_amb_id) {
                    
                    
                  if($inc_post_details['incient_districts'] == '')
                {
                    $district = $inc_post_details['incient_district'];
                }else{
                    $district = $inc_post_details['incient_districts'];
                }    
                $inc_re_id = $inc_id;
                $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_type' => $inc_details['inc_type'],
                'inc_back_hospital' => $inter_details['facility'],
                'current_district' => $inter_details['current_district'],
                'inc_back_home_address' => $inc_details['home_address'],
                'inc_ero_summary' => $inc_details['inc_ero_summary'],
                'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
                'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
                'inc_dispatch_time' => $inc_details['caller_dis_timer'],
                // 'inc_city' => $inc_details['inc_city'],
                'inc_city_id' => $inc_post_details['incient_ms_city'],
                //'inc_state' => $inc_post_details['incient_state'],
                'inc_state_id' => $inc_post_details['incient_state'],
                'inc_address' => $inc_details['place'],
                 'inc_tahshil_id' => $inc_post_details['incient_tahsil'],
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
                        $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);

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
                    $amb_details = $this->inc_model->get_ambulance_details_API($inc_details['amb_id']);
                    $amb_lat = $amb_details[0]->amb_lat;
                    $amb_log = $amb_details[0]->amb_log;
                    $thirdparty = $amb_details[0]->thirdparty;
                    $ward_id = $amb_details[0]->ward_id;
                    $ward_name = $amb_details[0]->ward_name;
                    $hp_id = $amb_details[0]->hp_id;
                    $hp_name = $amb_details[0]->hp_name;

                    $incidence_amb_details = array('amb_rto_register_no' => $inc_details['stand_amb_id'],
                        'inc_ref_id' => $inc_re_id,
                        'ward_id' => $ward_id,
                        'ward_name' => $ward_name,
                        'base_location_id' => $hp_id,
                        'base_location_name' => $hp_name,
                        'amb_pilot_id' => $pilot,
                        'amb_emt_id' => $EMT,
                        'amb_type'=> 'standby',
                        'inc_base_month' => $this->post['base_month'],
                        'assigned_time' => $datetime);

                    $this->inc_model->insert_inc_amb($incidence_amb_details);
                    
                    if($pilot != ''){
                    
                        $args_operator1 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $pilot,
                            'operator_type' => 'UG-PILOT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'DROP_BACK',
                            'base_month' => $this->post['base_month']
                        );
                        $args_operator1 = $this->common_model->assign_operator($args_operator1);
                    }

                    if($EMT != ''){
                        $args_operator2 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $EMT,
                            'operator_type' => 'UG-EMT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'DROP_BACK',
                            'base_month' => $this->post['base_month']
                        );

                        $args_operator2 = $this->common_model->assign_operator($args_operator2);
                    }
                    
                
                    $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                    if ($inc_details['chief_complete_other'] != '') {
                        $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                    }

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
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }

                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "PICK_UP",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                }
            }
        }

        //update_102_inc_ref_id($inc_id);


        /* send sms to patient  */
        $sms_amb = $inc_details['amb_id'];
        $get_mobile_no = array('rg_no' => $sms_amb);
        $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);
        $driver = $this->colleagues_model->get_user_info($pilot);
        $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;
        $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;

        //$inc_id = $inc_id;
        // $amb_url = base_url() . "amb/loc/" . $inc_re_id;
        $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_re_id;

        //$amb_url = "http://210.212.165.123/tdd/amb/loc/" . $inc_id;
        //$amb_dir_url = "http://210.212.165.123/tdd/amb/amb_dir/" . $inc_id;



        $doctor = $this->colleagues_model->get_user_info($EMT);
        $sms_doctor = $doctor[0]->clg_first_name;
        $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;
        $patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];
        $patient_mobile_no = $caller_details['clr_mobile'];
        //$patient_mobile_no = "9730015484";
        $patient_name = $caller_details['clr_fname'];

       // $patient_sms_text = "Ambulance dispatched: $sms_amb\n Ambulance Contact - $sms_doctor_contact_no\n Track Link- $amb_url\nJAES";
        	
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

       $patient_sms_to = $caller_details['clr_mobile'];
      
       $args = array(
           'msg' => $txtMsg1,
           'mob_no' => $patient_sms_to,
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

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];
        $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
       //$doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call 108 ERC for Case ID creation.  JAES";
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
        if($inc_details['hos_name']!='' || $inc_details['hos_name']!='null'){
            $hospital_name = $inc_details['hos_name'];
        }else{
            $hospital_name = $inc_details['hospital_other'];
        }
        if($hospital_name==''){
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
            $txtMsg2.= " Incident id: ".$inc_re_id.",\n";
            $txtMsg2.= " Chief Complaint: ".$chief_complaint.",\n";
            $txtMsg2.= " Hospital Name- ".$pri_hosp_name.",\n";
            $txtMsg2.= " JAES" ;

           $sms_to = $sms_doctor_contact_no;
           $args = array(
               'msg' => $txtMsg2,
               'mob_no' => $sms_to,
               'sms_user'=>'EMT',
               'inc_id'=>$inc_re_id,
           );
           $sms_data = sms_send($args);
           $mno = $sms_to;
           $mno = substr($mno, -10);
           $inc_link_args = array( 'mobile_no'=>$mno,
                                   'incident_id'=>$inc_re_id,
                                   'track_link'=>$amb_dir_url,
                                   'added_date' =>   date('Y-m-d H:i:s'));
           
           $inc_link = $this->call_model->insert_track_link($inc_link_args); 

        $doctor_sms_to = $sms_doctor_contact_no;
        

        /* send sms to Pilot  */

        $inc_address = $inc_details['place'];
       // $patient_name = $caller_details['clr_fname'];
        $driver_contact_no = $sms_driver_contact_no;
        //$driver_sms_text = "Dear Pilot, Patient name: $patient_full_name,  Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id , Patient id:$last_pat_id  Navigate- $amb_dir_url JAES";
        $datetime = date('d-m-Y H:i:s');
            $txtMsg2 ='';
            $txtMsg2.= "Patient name: ".$patient_full_name.",\n"; 
            $txtMsg2.= " Address: ".$inc_address.",\n";
            $txtMsg2.= " Caller No: ".$patient_mobile_no.",\n";
            $txtMsg2.= " Incident Date Time: ".$datetime.",\n";
            $txtMsg2.= " Incident id: ".$inc_re_id.",\n";
            $txtMsg2.= " Chief Complaint: ".$chief_complaint.",\n";
            $txtMsg2.= " Hospital Name- ".$pri_hosp_name.",\n";
            $txtMsg2.= " JAES" ;
 
        $sms_to = $sms_driver_contact_no;
        $args = array(
            'msg' => $txtMsg2,
            'mob_no' => $sms_to,
            'sms_user'=>'Pilot',
            'inc_id'=>$inc_re_id,
        );
        $sms_data = sms_send($args);
        $mno = $sms_to;
        $mno = substr($mno, -10);
        $inc_link_args = array( 'mobile_no'=>$mno,
                                'incident_id'=>$inc_re_id,
                                'track_link'=>$amb_url,
                                'added_date' =>   date('Y-m-d H:i:s'));
        
 
        $inc_link = $this->call_model->insert_track_link($inc_link_args); 
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
            'Caller_Location' => "$inc_address",
            'Hospital_Location' => "$destination_hos",
            'JobNo' => "$inc_re_id",
            'HospitalLatlong' => "$hos_lat".','."$hos_lng",
            'stateCode' => 'MP',
            'AmbulanceNo' =>"$select_amb_API",
            'CallerLatlong' =>"$caller_lat".','."$caller_lng"
        );
        $send_API = send_API($args);
       

        if ($call_type['cl_type'] == 'transfer_108') {

            _ucd_assign_call($inc_re_id);
        }
        
        if ($call_type['cl_type'] == 'transfer_102') {

           _ucd_102_assign_call($inc_re_id,$this->clg->clg_group);
        }
        //die();
        $this->output->status = 1;
        $this->output->closepopup = "yes";
        ($call_type['cl_type'] == 'forword') ? $msg = "forworded" : $msg = "Added";
        $url = base_url("calls");
        $this->output->message = "<h3>PickUp Call</h3><br><p>Ambulance Dispatch Successfully</p><script>window.location.href = '".$url."';</script>";
        $this->output->moveto = 'top';
        $this->output->add_to_position('', 'content', TRUE);
        }
    }
    function save_dropback() {

        $call_type = $this->input->get();
        $inc_details = $this->input->get_post('incient');
        $inter_details = $this->input->get_post('inter');
        $call_id = $this->input->get_post('call_id');
        $caller_details = $this->session->userdata('caller_details');
        $inc_details = $this->session->userdata('mic_details');
        $inter_details = $this->session->userdata('inter');
        $inc_post_details = $this->session->userdata('inc_post_details');
        $patient= $this->session->userdata('patient');
        $cl_type = $this->input->get_post('cl_type');

        
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
            $inc_post_details['incient_state'] = "MP";
        }
        $date = str_replace('-', '', date('Y-m-d'));

        //$inc_id = $date.$call_id;
        $inc_id = $this->session->userdata('inc_ref_id');




        $sr_user = $this->clg->clg_ref_id;

        $sms_amb_details = $inc_details['amb_id'];
        
        if($call_type != 'terminate'  && $call_type != 'transfer_108' && $call_type != 'transfer_102'){
            if ($inc_details['amb_id'] == '' && $dup_inc == 'Yes' ) {

                $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";

                return;
            }
        }

        
        if($inc_details['inc_ref_id'] != ""){
            if ($dup_inc == 'No') {
            $amb_count =0;
            $inc_re_id = $inc_id;
            foreach ($inc_details['amb_id'] as $key=>$select_amb) {
                $amb_count++;
                $inc_re_id = $inc_details['inc_ref_id'];
                
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
                'inc_back_hospital' => $inter_details['facility'],
                'current_district' => $inter_details['current_district'],
                'inc_back_home_address' => $inc_details['home_address'],
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
                'inc_district_id' => $district,
                'inc_area' => $inc_details['area'],
                'inc_landmark' => $inc_details['landmark'],
                'inc_lane' => $inc_details['lane'],
                'inc_h_no' => $inc_details['h_no'],
                'inc_pincode' => $inc_details['pincode'],
                'inc_lat' => $inc_details['lat'],
                'inc_long' => $inc_details['lng'],
                'destination_hospital_id' => $inc_details['hospital_id'],
                'destination_hospital_other' => $inc_details['hospital_other'],
                'inc_datetime' => $datetime,
                'inc_service' => $inc_details_service,
                'inc_duplicate' => $dup_inc,
                'inc_base_month' => $this->post['base_month'],
                //'inc_set_amb' => '1',
                'inc_recive_time' => $inc_details['inc_recive_time'],
                'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
                'inc_added_by' => $this->clg->clg_ref_id,
                'inc_wht_three_wrd' => $inc_details['3word'],
                'bk_inc_ref_id' => $inc_id,
                'inc_thirdparty' => $this->clg->thirdparty,
                 'inc_system_type' => $system  
            );
                
        
         if($cl_type == 'transfer_108'){
             
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
              $this->call_model->update_booking_details($caller_details['clr_mobile']);
              
        $incidence_details['hospital_id'] = $inter_details['facility'];
        
        $priority_hospital = get_hospital_by_id($inter_details['facility']);
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

        $caller_loc = $inc_details['place'];
        $caller_lat = $inc_details['lat'];
        $caller_lng = $inc_details['lng'];
        $destination_hos = $pri_hosp_name;
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
        //var_dump($args);die();
        
        $denial_id = $this->session->userdata('denial_id');
        if($denial_id){
            foreach($denial_id as $denial){
                $com_args = array('inc_ref_id'=>$inc_id,'id'=>$denial);
                $update_app_call_details = $this->Dashboard_model->update_denial($com_args);

            } 
        }
        
      // $send_API = send_API($args);
                $inc_details['amb_id'] = $select_amb;
                $EMT = "";
                $pilot = '';        
                $emp_inc_data = $this->inc_model->get_amb_emp($inc_details['amb_id'], $sft_id);

                if (empty($emp_inc_data)) {
                    $tm_team_date = date('Y-m-d');
                    $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);
                  

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

                if($pilot != ''){
                    $args_operator1 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $pilot,
                        'operator_type' => 'UG-PILOT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'DROP_BACK',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator1 = $this->common_model->assign_operator($args_operator1);
                }

                if($EMT != ''){
                    $args_operator2 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $EMT,
                        'operator_type' => 'UG-EMT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'DROP_BACK',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator2 = $this->common_model->assign_operator($args_operator2);
                }

                
                $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);

                $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
                
                 $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                if ($inc_details['chief_complete_other'] != '') {
                    $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                //die();
                

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
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                    $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }
                
                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "DROP_BACK",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                
            }

            if ($inc_details['stand_amb_id']) {

                foreach ($inc_details['stand_amb_id'] as $key=>$stand_amb_id) {
                    
                     if($inc_post_details['incient_districts'] == '')
                {
                    $district = $inc_post_details['incient_district'];
                }else{
                    $district = $inc_post_details['incient_districts'];
                } 
                $inc_re_id = $inc_details['inc_ref_id'];
                $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_type' => $inc_details['inc_type'],
                'inc_back_hospital' => $inter_details['facility'],
                'current_district' => $inter_details['current_district'],
                'inc_back_home_address' => $inc_details['home_address'],
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
                'inc_recive_time' => $inc_details['inc_recive_time'],
                'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
                'inc_added_by' => $this->clg->clg_ref_id,
                'inc_wht_three_wrd' => $inc_details['3word'],
                'bk_inc_ref_id' => $inc_id,
                'inc_thirdparty' => $this->clg->thirdparty,
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
                        $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);

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
                    $amb_details = $this->inc_model->get_ambulance_details_API($inc_details['amb_id']);
                    $amb_lat = $amb_details[0]->amb_lat;
                    $amb_log = $amb_details[0]->amb_log;
                    $thirdparty = $amb_details[0]->thirdparty;
                    $ward_id = $amb_details[0]->ward_id;
                    $ward_name = $amb_details[0]->ward_name;
                    $hp_id = $amb_details[0]->hp_id;
                    $hp_name = $amb_details[0]->hp_name;

                    $incidence_amb_details = array('amb_rto_register_no' => $inc_details['stand_amb_id'],
                        'inc_ref_id' => $inc_re_id,
                        'ward_id' => $ward_id,
                        'ward_name' => $ward_name,
                        'base_location_id' => $hp_id,
                        'base_location_name' => $hp_name,
                        'amb_pilot_id' => $pilot,
                        'amb_emt_id' => $EMT,
                        'amb_type'=> 'standby',
                        'inc_base_month' => $this->post['base_month'],
                        'assigned_time' => $datetime);

                    $this->inc_model->insert_inc_amb($incidence_amb_details);
                    
                    if($pilot != ''){
                    
                        $args_operator1 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $pilot,
                            'operator_type' => 'UG-PILOT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'DROP_BACK',
                            'base_month' => $this->post['base_month']
                        );
                        $args_operator1 = $this->common_model->assign_operator($args_operator1);
                    }

                    if($EMT != ''){
                        $args_operator2 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $EMT,
                            'operator_type' => 'UG-EMT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'DROP_BACK',
                            'base_month' => $this->post['base_month']
                        );

                        $args_operator2 = $this->common_model->assign_operator($args_operator2);
                    }
                    
                
                    $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                    if ($inc_details['chief_complete_other'] != '') {
                        $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                    }

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
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')    
                    );

                $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $denial_id = $this->session->userdata('denial_id');
                if($denial_id){
                    foreach($denial_id as $denial){
                        $com_args = array('inc_ref_id'=>$inc_re_id,'id'=>$denial);
                        $update_app_call_details = $this->Dashboard_model->update_denial($com_args);

                    } 
                }
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }

                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "DROP_BACK",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                }
            }
        }

        //update_102_inc_ref_id($inc_id);
        $call_history_id = $this->session->userdata('call_history_id');
			
		_ucd_dispatch_call($inc_details['inc_ref_id'],$this->clg->clg_ref_id,$call_history_id);
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
        if($inc_details['hos_name']!='' || $inc_details['hos_name']!='null'){
            $hospital_name = $inc_details['hos_name'];
        }else{
            $hospital_name = $inc_details['hospital_other'];
        }
        /* send sms to patient  */
        $sms_amb = $inc_details['amb_id'];
        $get_mobile_no = array('rg_no' => $sms_amb);
        $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);
        $driver = $this->colleagues_model->get_user_info($pilot);
        $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;
        $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;

        //$inc_id = $inc_id;
        // $amb_url = base_url() . "amb/loc/" . $inc_re_id;
        $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_re_id;

        //$amb_url = "http://210.212.165.123/tdd/amb/loc/" . $inc_id;
        //$amb_dir_url = "http://210.212.165.123/tdd/amb/amb_dir/" . $inc_id;



        $doctor = $this->colleagues_model->get_user_info($EMT);
        $sms_doctor = $doctor[0]->clg_first_name;
        $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;
        $patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];
        $patient_mobile_no = $caller_details['clr_mobile'];
        //$patient_mobile_no = "9730015484";
        $patient_name = $caller_details['clr_fname'];

       // $patient_sms_text = "Ambulance dispatched: $sms_amb\n Ambulance Contact - $sms_doctor_contact_no\n Track Link- $amb_url\nJAES";
       $sms_amb1 = implode('',(explode("-",$sms_amb)));
       if($patient_full_name == ' '){
        $patient_full_name ='Unknown';
       }
       $txtMsg1 = '';
       $txtMsg1.= "Dear ".$patient_full_name.", \n";
       $txtMsg1.= "Ambulance dispatched: ".$sms_amb1 .", \n";
       $txtMsg1.= "Ambulance Contact: ".$sms_doctor_contact_no .", \n" ;
       //$txtMsg1.= "Link: ".$amb_dir_url."\n" ;
       $txtMsg1 .= "Please click on the following link for downloading the 108 Sanjeevani app on your mobile Android User - https://tinyurl.com/2p87kfu6 and iOS User- https://tinyurl.com/3pup8pp4\n";
       $txtMsg1.= "JAES" ;
        $patient_sms_to = $caller_details['clr_mobile'];
       
        $args = array(
            'msg' => $txtMsg1,
            'mob_no' => $patient_sms_to,
            'sms_user'=>'patient',
            'inc_id'=>$inc_id,
        );
        
       $sms_data = sms_send($args);
        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_re_id,
            'sms_usertype' => 'patient',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);



        /* send sms to doctor  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];

        if($hospital_name==''){
            $hospital_name='NA';
        }
        $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
       
       $datetime = date('d-m-Y H:i:s');
       $txtMsg2 ='';
            $txtMsg2.= "Patient name: ".$patient_name.",\n"; 
            $txtMsg2.= " Address: ".$inc_address.",\n";
            $txtMsg2.= " Caller No: ".$patient_mobile_no.",\n";
            $txtMsg2.= " Incident Date Time: ".$datetime.",\n";
            $txtMsg2.= " Incident id: ".$inc_id.",\n";
            $txtMsg2.= " Chief Complaint: ".$chief_complaint.",\n";
            $txtMsg2.= " Hospital Name- ".'NA'.",\n";
            $txtMsg2.= " JAES" ;

        $doctor_sms_to = $sms_doctor_contact_no;
        
        $args = array(
            'inc_id' => $inc_id,
            'msg' => $txtMsg2,
            'mob_no' => $doctor_sms_to,
            'sms_user'=>'EMT',
        );
        $sms_data = sms_send($args);
        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_re_id,
            'sms_usertype' => 'EMT',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);

        /* send sms to Pilot  */

        $inc_address = $inc_details['place'];
        //$patient_name = $caller_details['clr_fname'];
        $datetime = date('d-m-Y H:i:s');
        $txtMsg2 ='';
        $txtMsg2.= "Patient name: ".$patient_name.",\n"; 
        $txtMsg2.= " Address: ".$inc_address.",\n";
        $txtMsg2.= " Caller No: ".$patient_mobile_no.",\n";
        $txtMsg2.= " Incident Date Time: ".$datetime.",\n";
        $txtMsg2.= " Incident id: ".$inc_id.",\n";
        $txtMsg2.= " Chief Complaint: ".$chief_complaint.",\n";
        $txtMsg2.= " Hospital Name- ".'NA'.",\n";
        $txtMsg2.= " JAES" ;
       
      
      $driver_contact_no = $sms_driver_contact_no;
      $args = array(
            'inc_id' => $inc_id,
            'msg' => $txtMsg2,
            'mob_no' => $driver_contact_no,
            'sms_user'=>'Pilot',
        );
        
        $sms_data = sms_send($args);
        
    
        if ($call_type['cl_type'] == 'transfer_108') {

            _ucd_assign_call($inc_re_id);
        }
        
      
        
        $this->output->status = 1;
        $this->output->closepopup = "yes";
        ($call_type['cl_type'] == 'forword') ? $msg = "forworded" : $msg = "Added";
        $url = base_url("calls");
        $this->output->message = "<h3>Drop Back Call</h3><br><p>Ambulance Dispatch Successfully</p><script>window.location.href = '".$url."';</script>";
        $this->output->moveto = 'top';
        $this->output->add_to_position('', 'content', TRUE);
        
        }else{
            
        if ($dup_inc == 'No') {
            $amb_count =0;
            $inc_re_id = $inc_id;
            if($inc_details['amb_id']){
                foreach ($inc_details['amb_id'] as $key=>$select_amb) {
                $amb_count++;
                $inc_re_id = $inc_id;
                
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
                'inc_back_hospital' => $inter_details['facility'],
                'current_district' => $inter_details['current_district'],
                'inc_back_home_address' => $inc_details['home_address'],
                'inc_ero_summary' => $inc_details['inc_ero_summary'],
                'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
                'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
                'inc_dispatch_time' => $inc_details['caller_dis_timer'],
                // 'inc_city' => $inc_details['inc_city'],
                'inc_city_id' => $inc_post_details['incient_ms_city'],
                //'inc_state' => $inc_post_details['incient_state'],
                'inc_state_id' => $inc_post_details['incient_state'],
                'inc_address' => $inc_details['place'],
                 'inc_tahshil_id' => $inc_post_details['incient_tahsil'],
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
                //'inc_set_amb' => '1',
                'inc_recive_time' => $inc_details['inc_recive_time'],
                'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
                'inc_added_by' => $this->clg->clg_ref_id,
                'inc_system_type' => $system
            );
                
        
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
    
           if($inter_details['facility'] != ''){
                $incidence_details['hospital_id'] = $inter_details['facility'];
                $priority_hospital = get_hospital_by_id($inter_details['facility']);
                $district_hospital = $priority_hospital[0]->hp_district;
                $hosp_type = get_hosp_type_by_id($priority_hospital[0]->hp_type);
                $incidence_details['hospital_type'] = $hosp_type;
                $incidence_details['hospital_district'] = $district_hospital;
            }
        
                   
                $inc_details['amb_id'] = $select_amb;
                $EMT = "";
                $pilot = '';        
                $emp_inc_data = $this->inc_model->get_amb_emp($inc_details['amb_id'], $sft_id);

                if (empty($emp_inc_data)) {
                    $tm_team_date = date('Y-m-d');
                    $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);
                  

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
                
                $drop_back = array(
                'home_city_id' => $inc_post_details['home_dtl_ms_city'],
                'home_state_id' => $inc_post_details['home_dtl_state'],
                'home_address' => $inc_details['place'],
                'home_tahsil_id' => $inc_post_details['home_dtl_tahsil'],
                'home_district_id' => $inc_post_details['home_dtl_districts'],
                'home_location' => $inc_post_details['home_dtl']['area'],
                'home_landmark' => $inc_details['home_dtl_lmark'],
                'inc_ref_id'=>$inc_re_id);
        
              // var_dump($drop_back);  
               $drop_back_data = $this->inc_model->insert_dropback($drop_back);

                if($pilot != ''){
                    $args_operator1 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $pilot,
                        'operator_type' => 'UG-PILOT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'DROP_BACK',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator1 = $this->common_model->assign_operator($args_operator1);
                }

                if($EMT != ''){
                    $args_operator2 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $EMT,
                        'operator_type' => 'UG-EMT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'DROP_BACK',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator2 = $this->common_model->assign_operator($args_operator2);
                }

                
                $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);

                $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
                
                 $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                if ($inc_details['chief_complete_other'] != '') {
                    $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                
                
                $drop_back = array(
                                    'home_city_id' => $inc_post_details['incient_ms_city'],
                                    'home_state_id' => $inc_post_details['incient_state'],
                                    'home_address' => $inc_details['place'],
                                    //'home_tahsil_id' => $inc_post_details['incient_district'],
                                    'home_district_id' => $inc_post_details['incient_districts'],
                                    'home_location' => $inc_details['area'],
                                    'home_landmark' => $inc_details['landmark'],
                                    'home_lane' => $inc_details['lane'],
                                    'home_houseno' => $inc_details['h_no'],
                                    'home_pin' => $inc_details['pincode'],
                                    'inc_ref_id'=>$inc_re_id);
            
                        $drop_back_data = $this->inc_model->insert_dropback($drop_back);


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
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                    $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }
                
                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "DROP_BACK",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                
            }
            }
            
            if ($inc_details['stand_amb_id']) {

                foreach ($inc_details['stand_amb_id'] as $key=>$stand_amb_id) {
                    
               
                if($inc_post_details['incient_districts'] == ''){
                    $district = $inc_post_details['incient_district'];
                }else{
                    $district = $inc_post_details['incient_districts'];
                }
                $inc_re_id = $inc_id;
                $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_type' => $inc_details['inc_type'],
                'inc_back_hospital' => $inter_details['facility'],
                'current_district' => $inter_details['current_district'],
                'inc_back_home_address' => $inc_details['home_address'],
                'inc_ero_summary' => $inc_details['inc_ero_summary'],
                'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
                'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
                'inc_dispatch_time' => $inc_details['caller_dis_timer'],
                // 'inc_city' => $inc_details['inc_city'],
                'inc_city_id' => $inc_post_details['incient_ms_city'],
                //'inc_state' => $inc_post_details['incient_state'],
                'inc_state_id' => $inc_post_details['incient_state'],
                'inc_address' => $inc_details['place'],
                 'inc_tahshil_id' => $inc_post_details['incient_tahsil'],
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
                        $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);

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
                    $amb_details = $this->inc_model->get_ambulance_details_API($inc_details['amb_id']);
                    $amb_lat = $amb_details[0]->amb_lat;
                    $amb_log = $amb_details[0]->amb_log;
                    $thirdparty = $amb_details[0]->thirdparty;
                    $ward_id = $amb_details[0]->ward_id;
                    $ward_name = $amb_details[0]->ward_name;
                    $hp_id = $amb_details[0]->hp_id;
                    $hp_name = $amb_details[0]->hp_name;

                    $incidence_amb_details = array('amb_rto_register_no' => $inc_details['stand_amb_id'],
                        'inc_ref_id' => $inc_re_id,
                        'ward_id' => $ward_id,
                        'ward_name' => $ward_name,
                        'base_location_id' => $hp_id,
                        'base_location_name' => $hp_name,
                        'amb_pilot_id' => $pilot,
                        'amb_emt_id' => $EMT,
                        'amb_type'=> 'standby',
                        'inc_base_month' => $this->post['base_month'],
                        'assigned_time' => $datetime);

                    $this->inc_model->insert_inc_amb($incidence_amb_details);
                    
                    if($pilot != ''){
                    
                        $args_operator1 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $pilot,
                            'operator_type' => 'UG-PILOT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'DROP_BACK',
                            'base_month' => $this->post['base_month']
                        );
                        $args_operator1 = $this->common_model->assign_operator($args_operator1);
                    }

                    if($EMT != ''){
                        $args_operator2 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $EMT,
                            'operator_type' => 'UG-EMT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'DROP_BACK',
                            'base_month' => $this->post['base_month']
                        );

                        $args_operator2 = $this->common_model->assign_operator($args_operator2);
                    }
                    
                
                    $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                    if ($inc_details['chief_complete_other'] != '') {
                        $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                    }

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
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }

                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "DROP_BACK",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                }
            }
        }

        //update_102_inc_ref_id($inc_id);


        /* send sms to patient  */
        $sms_amb = $inc_details['amb_id'];
        $get_mobile_no = array('rg_no' => $sms_amb);
        $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);
        $driver = $this->colleagues_model->get_user_info($pilot);
        $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;
        $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;

        //$inc_id = $inc_id;
        // $amb_url = base_url() . "amb/loc/" . $inc_re_id;
        $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_re_id;

        //$amb_url = "http://210.212.165.123/tdd/amb/loc/" . $inc_id;
        //$amb_dir_url = "http://210.212.165.123/tdd/amb/amb_dir/" . $inc_id;



        $doctor = $this->colleagues_model->get_user_info($EMT);
        $sms_doctor = $doctor[0]->clg_first_name;
        $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;
        $patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];
        $patient_mobile_no = $caller_details['clr_mobile'];
        //$patient_mobile_no = "9730015484";
        $patient_name = $caller_details['clr_fname'];
        if($patient_full_name == ''){
            $patient_full_name='Unkonown';
        }
       // $patient_sms_text = "Ambulance dispatched: $sms_amb\n Ambulance Contact - $sms_doctor_contact_no\n Track Link- $amb_url\nJAES";
       $sms_amb1 = implode('',(explode("-",$sms_amb)));
       $txtMsg1 = '';
       $txtMsg1.= "Dear ".$patient_full_name.", \n";
       $txtMsg1.= "Ambulance dispatched: ".$sms_amb1 .", \n";
       $txtMsg1.= "Ambulance Contact: ".$sms_doctor_contact_no .", \n" ;
       //$txtMsg1.= "Link: ".$amb_dir_url."\n" ;
       $txtMsg1 .= "Please click on the following link for downloading the 108 Sanjeevani app on your mobile Android User - https://tinyurl.com/2p87kfu6 and iOS User- https://tinyurl.com/3pup8pp4\n";
       $txtMsg1.= "JAES" ;
      

        $patient_sms_to = $caller_details['clr_mobile'];
        $args = array(
            'inc_id' => $inc_id,
            'msg' => $txtMsg1,
            'mob_no' => $patient_sms_to,
            'sms_user'=>'patient',
        );
       
        $sms_data = sms_send($args);
        $mno = substr($patient_sms_to, -10);
        $inc_link_args = array( 'mobile_no'=>$mno,
                                'incident_id'=>$inc_id,
                                'track_link'=>$amb_dir_url,
                                'added_date' =>   date('Y-m-d H:i:s'));
        
        $inc_link = $this->call_model->insert_track_link($inc_link_args);

       
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
        //$chief_complaint = get_cheif_complaint($incidence_details['inc_complaint']);
        // $hospital_name = $inc_details['hos_name'];
         if($inc_details['hos_name']!='' || $inc_details['hos_name']!='null'){
             $hospital_name = $inc_details['hos_name'];
         }else{
             $hospital_name = $inc_details['hospital_other'];
         }
         if($hospital_name==''){
            $hospital_name='NA';
        }
        /* send sms to doctor  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];
        $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
        //$doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call 108 ERC for Case ID creation.  JAES";
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
            $txtMsg2.= " Hospital Name- ".'NA'.",\n";
            $txtMsg2.= " JAES" ;
        //var_dump($txtMsg2);die();
        $doctor_sms_to = $sms_doctor_contact_no;
       
     
       $args = array(
        'inc_id' => $inc_re_id,
        'msg' => $txtMsg2,
        'mob_no' => $doctor_sms_to,
        'sms_user'=>'EMT',
    );
    
    $sms_data = sms_send($args);

    $mno = $doctor_sms_to;
    $mno = substr($mno, -10);
    $inc_link_args = array( 'mobile_no'=>$mno,
                            'incident_id'=>$inc_id,
                            'track_link'=>$amb_dir_url,
                            'added_date' =>   date('Y-m-d H:i:s'));
    
    $inc_link = $this->call_model->insert_track_link($inc_link_args);
    //die();
        /* send sms to Pilot  */

        $inc_address = $inc_details['place'];
        //$patient_name = $caller_details['clr_fname'];

      
        $txtMsg2 ='';
            $txtMsg2.= "Patient name: ".$patient_full_name.",\n"; 
            $txtMsg2.= " Address: ".$inc_address.",\n";
            $txtMsg2.= " Caller No: ".$patient_mobile_no.",\n";
            $txtMsg2.= " Incident Date Time: ".$datetime.",\n";
            $txtMsg2.= " Incident id: ".$inc_id.",\n";
            $txtMsg2.= " Chief Complaint: ".$chief_complaint.",\n";
            $txtMsg2.= " Hospital Name- ".'NA'.",\n";
            $txtMsg2.= " JAES" ;
        $driver_contact_no = $sms_driver_contact_no;
        $args = array(
            'inc_id' => $inc_re_id,
            'msg' => $txtMsg2,
            'mob_no' => $driver_contact_no,
            'sms_user'=>'Pilot',
        );
        $sms_data = sms_send($args);

        $mno = substr($mno, -10);
        $inc_link_args = array( 'mobile_no'=>$driver_contact_no,
                                'incident_id'=>$inc_id,
                                'track_link'=>$amb_dir_url,
                                'added_date' =>   date('Y-m-d H:i:s'));
        
        $inc_link = $this->call_model->insert_track_link($inc_link_args);
        
        if ($call_type['cl_type'] == 'transfer_108') {

            _ucd_assign_call($inc_re_id);
        }
        
        if ($call_type['cl_type'] == 'transfer_102') {

           _ucd_102_assign_call($inc_re_id,$this->clg->clg_group);
        }
        $caller_lat = $inc_details['lat'];
        $caller_lng = $inc_details['lng'];
      
        $select_amb_API= str_replace('-','',$inc_details['amb_id']);
        //$select_amb = implode('',(explode("-",$inc_details['amb_id'])));
        $args = array(
            'LastActivityTime' => "$datetime" ,
            'JobStatus' => 'Dispatched' ,
            'onRoadStatus' =>'1' ,
            'Caller_Location' => "$inc_address",
            'Hospital_Location' => "NA",
            'JobNo' => "$inc_id",
            'HospitalLatlong' => "Na",
            'stateCode' => 'MP',
            'AmbulanceNo' =>"$select_amb_API",
            'CallerLatlong' =>"$caller_lat".','."$caller_lng"
            
        );
        
        $send_API = send_API($args);
        //die();
        $this->output->status = 1;
        $this->output->closepopup = "yes";
        ($call_type['cl_type'] == 'forword') ? $msg = "forworded" : $msg = "Added";
        $url = base_url("calls");
        $this->output->message = "<h3>Drop Back Call</h3><br><p>Ambulance Dispatch Successfully</p><script>window.location.href = '".$url."';</script>";
        $this->output->moveto = 'top';
        $this->output->add_to_position('', 'content', TRUE);
        }
    }
    
    function save_terminate_dropback() {

        $call_type = $this->input->get();
        $inc_details = $this->input->get_post('incient');
        $call_id = $this->input->get_post('call_id');
        $caller_details = $this->session->userdata('caller_details');
        $inc_details = $this->session->userdata('incient');
        $inc_post_details = $this->session->userdata('inc_post_details');
        $patient= $this->session->userdata('patient');
        $inter_details = $this->session->userdata('inter');
        $cl_type = $this->input->get_post('cl_type');
        //var_dump($inc_details);die();
        
        
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
            $inc_post_details['incient_state'] = "MP";
        }
        $date = str_replace('-', '', date('Y-m-d'));

        //$inc_id = $date.$call_id;
        $inc_id = $this->session->userdata('inc_ref_id');




        $sr_user = $this->clg->clg_ref_id;

        $sms_amb_details = $inc_details['amb_id'];
        
        if($call_type != 'terminate'  && $call_type != 'transfer_108' && $call_type != 'transfer_102' && $cl_type != 'enable_dispatch'){
            if ($inc_details['amb_id'] == '' && $dup_inc == 'Yes' ) {

                $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";

                return;
            }
        }


        if($inc_details['inc_ref_id'] != ""){
            if ($dup_inc == 'No') {
            $amb_count =0;
            $inc_re_id = $inc_id;
            if($inc_details['amb_id']){
                foreach ($inc_details['amb_id'] as $key=>$select_amb) {
                $amb_count++;
                $inc_re_id = $inc_details['inc_ref_id'];

                  if($inc_post_details['incient_districts'] == '')
                {
                    $district = $inc_post_details['incient_district'];
                }else{
                    $district = $inc_post_details['incient_districts'];
                }
                $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_type' => $inc_details['inc_type'],
                'inc_back_hospital' => $inter_details['facility'],
                'current_district' => $inter_details['current_district'],
                'inc_back_home_address' => $inc_details['home_address'],
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
                //'inc_set_amb' => '1',
                'inc_recive_time' => $inc_details['inc_recive_time'],
                'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
                'inc_added_by' => $this->clg->clg_ref_id,
                'inc_wht_three_wrd' => $inc_details['3word'],
            'bk_inc_ref_id' => $inc_id,
            'inc_thirdparty' => $this->clg->thirdparty,
                 'inc_system_type' => $system  
            );
                
        
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
        

                $inc_details['amb_id'] = $select_amb;
                $EMT = "";
                $pilot = '';        
                $emp_inc_data = $this->inc_model->get_amb_emp($inc_details['amb_id'], $sft_id);

                if (empty($emp_inc_data)) {
                    $tm_team_date = date('Y-m-d');
                    $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);
                  

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
                if( $inc_details['amb_id']){
                    $incidence_amb_details = array('amb_rto_register_no' => $inc_details['amb_id'],
                        'inc_ref_id' => $inc_re_id,
                        'amb_pilot_id' => $pilot,
                        'amb_emt_id' => $EMT,
                        'inc_base_month' => $this->post['base_month'],
                        'assigned_time' => $datetime);
                    $this->inc_model->insert_inc_amb($incidence_amb_details);
                }

                if($pilot != ''){
                    $args_operator1 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $pilot,
                        'operator_type' => 'UG-PILOT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'DROP_BACK',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator1 = $this->common_model->assign_operator($args_operator1);
                }

                if($EMT != ''){
                    $args_operator2 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $EMT,
                        'operator_type' => 'UG-EMT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'DROP_BACK',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator2 = $this->common_model->assign_operator($args_operator2);
                }

                
                $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);

                $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
                
                 $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                if ($inc_details['chief_complete_other'] != '') {
                    $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                
                if($cl_type == 'enable_dispatch'){

                    $item_key= $inc_details['enable_standard_summary'];

                     foreach ($item_key as $key=>$enable_standard_summary) {

                         $enable_data = array(
                             'inc_ref_id' => $inc_re_id,
                             'enable_remark' => $enable_standard_summary,
                             'amb_reg_no' => $inc_details['enable_ambulance'][$key],
                             'added_date' => $datetime,
                             'added_by' => $this->clg->clg_ref_id,
                         );
                         $enable = $this->inc_model->insert_inc_enable_dispatch($enable_data);
                     }
                 }
                

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
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                    $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => "DROP_BACK",
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }
                
                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "DROP_BACK",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                
            }

            }else if ($inc_details['stand_amb_id']) {

                foreach ($inc_details['stand_amb_id'] as $key=>$stand_amb_id) {
                      if($inc_post_details['incient_districts'] == '')
                {
                    $district = $inc_post_details['incient_district'];
                }else{
                    $district = $inc_post_details['incient_districts'];
                }
                    
                $inc_re_id = $inc_details['inc_ref_id'];
                $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_type' => $inc_details['inc_type'],
                'inc_back_hospital' => $inter_details['facility'],
                'current_district' => $inter_details['current_district'],
                'inc_back_home_address' => $inc_details['home_address'],
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
                        $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);

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

                   if($inc_details['stand_amb_id']){
                        $incidence_amb_details = array('amb_rto_register_no' => $inc_details['stand_amb_id'],
                        'inc_ref_id' => $inc_re_id,
                        'amb_pilot_id' => $pilot,
                        'amb_emt_id' => $EMT,
                        'amb_type'=> 'standby',
                        'inc_base_month' => $this->post['base_month'],
                        'assigned_time' => $datetime);

                        $this->inc_model->insert_inc_amb($incidence_amb_details);
                    }
                    
                    if($pilot != ''){
                    
                        $args_operator1 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $pilot,
                            'operator_type' => 'UG-PILOT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'DROP_BACK',
                            'base_month' => $this->post['base_month']
                        );
                        $args_operator1 = $this->common_model->assign_operator($args_operator1);
                    }

                    if($EMT != ''){
                        $args_operator2 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $EMT,
                            'operator_type' => 'UG-EMT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'DROP_BACK',
                            'base_month' => $this->post['base_month']
                        );

                        $args_operator2 = $this->common_model->assign_operator($args_operator2);
                    }
                    
                
                    $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                    if ($inc_details['chief_complete_other'] != '') {
                        $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                    }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                
                if($cl_type == 'enable_dispatch'){

                    $item_key= $inc_details['enable_standard_summary'];

                     foreach ($item_key as $key=>$enable_standard_summary) {

                         $enable_data = array(
                             'inc_ref_id' => $inc_re_id,
                             'enable_remark' => $enable_standard_summary,
                             'amb_reg_no' => $inc_details['enable_ambulance'][$key],
                             'added_date' => $datetime,
                             'added_by' => $this->clg->clg_ref_id,
                         );
                         $enable = $this->inc_model->insert_inc_enable_dispatch($enable_data);
                     }
                 }
                

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
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => "DROP_BACK",
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }

                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "DROP_BACK",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                }
            }
        }

        //update_102_inc_ref_id($inc_id);
        $call_history_id = $this->session->userdata('call_history_id');
			
		_ucd_dispatch_call($inc_details['inc_ref_id'],$this->clg->clg_ref_id,$call_history_id);


        /* send sms to patient  */
        $sms_amb = $inc_details['amb_id'];
        $get_mobile_no = array('rg_no' => $sms_amb);
        $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);
        $driver = $this->colleagues_model->get_user_info($pilot);
        $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;
        $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;

        //$inc_id = $inc_id;
        $amb_url = base_url() . "amb/loc/" . $inc_re_id;
        $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_re_id;

        //$amb_url = "http://210.212.165.123/tdd/amb/loc/" . $inc_id;
        //$amb_dir_url = "http://210.212.165.123/tdd/amb/amb_dir/" . $inc_id;



        $doctor = $this->colleagues_model->get_user_info($EMT);
        $sms_doctor = $doctor[0]->clg_first_name;
        $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;
        $patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];
        $patient_mobile_no = $caller_details['clr_mobile'];
        //$patient_mobile_no = "9730015484";
        $patient_name = $caller_details['clr_fname'];

        $patient_sms_text = "Ambulance dispatched: $sms_amb\n Ambulance Contact - $sms_doctor_contact_no\n Track Link- $amb_url\nJAES";


        $patient_sms_to = $caller_details['clr_mobile'];
        //$patient_sms_to =  "8551995260";
        $send_dr_sms = $this->_send_sms($patient_sms_to, $patient_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_re_id,
            'sms_usertype' => 'Caller',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);



        /* send sms to doctor  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];


            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call 108 ERC for Case ID creation.  JAES";
      

        $doctor_sms_to = $sms_doctor_contact_no;
        // $doctor_sms_to = '8551995260';
        $send_dr_sms = $this->_send_sms($doctor_sms_to, $doctor_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_re_id,
            'sms_usertype' => 'EMT',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);

        /* send sms to Pilot  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];

        $driver_sms_text = "Dear Pilot, Patient name: $patient_full_name,  Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id , Patient id:$last_pat_id  Navigate- $amb_dir_url JAES";

        $driver_contact_no = $sms_driver_contact_no;

        if ($call_type['cl_type'] == 'transfer_108') {

            _ucd_assign_call($inc_re_id);
        }
        
        if ($call_type['cl_type'] == 'transfer_102') {

            _ucd_102_assign_call($inc_re_id,$this->clg->clg_group);
        }
        //die();
        
        $this->output->status = 1;
        $this->output->closepopup = "yes";
        ($call_type['cl_type'] == 'forword') ? $msg = "forworded" : $msg = "Added";
        $url = base_url("calls");
        $this->output->message = "<h3>Drop Back Call</h3><br><p>Ambulance Dispatch Successfully</p><script>window.location.href = '".$url."';</script>";
        $this->output->moveto = 'top';
        $this->output->add_to_position('', 'content', TRUE);
        }else{
        if ($dup_inc == 'No') {
            $amb_count =0;
            $inc_re_id = $inc_id;
            if($inc_details['amb_id']){
                foreach ($inc_details['amb_id'] as $key=>$select_amb) {
                $amb_count++;
                $inc_re_id = $inc_id;

                  if($inc_post_details['incient_districts'] == '')
                {
                    $district = $inc_post_details['incient_district'];
                }else{
                    $district = $inc_post_details['incient_districts'];
                }
                
                $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_type' => $inc_details['inc_type'],
                'inc_back_hospital' => $inter_details['facility'],
                'current_district' => $inter_details['current_district'],
                'inc_back_home_address' => $inc_details['home_address'],
                'inc_ero_summary' => $inc_details['inc_ero_summary'],
                'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
                'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
                'inc_dispatch_time' => $inc_details['caller_dis_timer'],
                // 'inc_city' => $inc_details['inc_city'],
                'inc_city_id' => $inc_post_details['incient_ms_city'],
                //'inc_state' => $inc_post_details['incient_state'],
                'inc_state_id' => $inc_post_details['incient_state'],
                'inc_address' => $inc_details['place'],
                 'inc_tahshil_id' => $inc_post_details['incient_tahsil'],
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
                //'inc_set_amb' => '1',
                'inc_recive_time' => $inc_details['inc_recive_time'],
                'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
                'inc_added_by' => $this->clg->clg_ref_id,
                'inc_system_type' => $system
            );
                
        
         if($cl_type == 'transfer_108'){
             
            $incidence_details['inc_set_amb'] = '0';
            $incidence_details['incis_deleted'] = '0';
             
         }else if($cl_type == 'transfer_102'){
            $incidence_details['inc_set_amb'] = '0';
            $incidence_details['incis_deleted'] = '0';
             
         }else if($cl_type == 'terminate'){
             $incidence_details['inc_set_amb'] = '1';
             $incidence_details['incis_deleted'] = '2';
             
         }else if($cl_type == 'enable_dispatch'){
             $incidence_details['inc_set_amb'] = '0';
             $incidence_details['incis_deleted'] = '3';
             
         }else{
               $incidence_details['inc_set_amb'] = '1';
               $incidence_details['incis_deleted'] = '0';
               $incidence_details['inc_system_type'] = $system;
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
            
            
                $inc_details['amb_id'] = $select_amb;
                $EMT = "";
                $pilot = '';        
                $emp_inc_data = $this->inc_model->get_amb_emp($inc_details['amb_id'], $sft_id);

                if (empty($emp_inc_data)) {
                    $tm_team_date = date('Y-m-d');
                    $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);
                  

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
             
                if($inc_details['amb_id']){
                    $incidence_amb_details = array('amb_rto_register_no' => $inc_details['amb_id'],
                        'inc_ref_id' => $inc_re_id,
                        'amb_pilot_id' => $pilot,
                        'amb_emt_id' => $EMT,
                        'inc_base_month' => $this->post['base_month'],
                        'assigned_time' => $datetime);
                      // var_dump($incidence_amb_details);
                //die();
                    $this->inc_model->insert_inc_amb($incidence_amb_details);
                }
                
                 $drop_back = array(
                'home_city_id' => $inc_post_details['incient_ms_city'],
                'home_state_id' => $inc_post_details['incient_state'],
                'home_address' => $inc_details['place'],
                //'home_tahsil_id' => $inc_post_details['incient_district'],
                'home_district_id' => $inc_post_details['incient_district'],
                'home_location' => $inc_details['area'],
                'home_landmark' => $inc_details['landmark'],
                'home_lane' => $inc_details['lane'],
                'home_houseno' => $inc_details['h_no'],
                'home_pin' => $inc_details['pincode'],
                'inc_ref_id'=>$inc_re_id);
            
               $drop_back_data = $this->inc_model->insert_dropback($drop_back);

                if($pilot != ''){
                    $args_operator1 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $pilot,
                        'operator_type' => 'UG-PILOT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'DROP_BACK',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator1 = $this->common_model->assign_operator($args_operator1);
                }

                if($EMT != ''){
                    $args_operator2 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $EMT,
                        'operator_type' => 'UG-EMT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'DROP_BACK',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator2 = $this->common_model->assign_operator($args_operator2);
                }

                
                $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);

                $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
                
                 $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                if ($inc_details['chief_complete_other'] != '') {
                    $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                
                if($cl_type == 'enable_dispatch'){

                    $item_key= $inc_details['enable_standard_summary'];

                     foreach ($item_key as $key=>$enable_standard_summary) {

                         $enable_data = array(
                             'inc_ref_id' => $inc_re_id,
                             'enable_remark' => $enable_standard_summary,
                             'amb_reg_no' => $inc_details['enable_ambulance'][$key],
                             'added_date' => $datetime,
                             'added_by' => $this->clg->clg_ref_id,
                         );
                         $enable = $this->inc_model->insert_inc_enable_dispatch($enable_data);
                     }
                 }
                
                $drop_back = array(
                                    'home_city_id' => $inc_post_details['incient_ms_city'],
                                    'home_state_id' => $inc_post_details['incient_state'],
                                    'home_address' => $inc_details['place'],
                                    //'home_tahsil_id' => $inc_post_details['incient_district'],
                                    'home_district_id' => $inc_post_details['incient_district'],
                                    'home_location' => $inc_details['area'],
                                    'home_landmark' => $inc_details['landmark'],
                                    'home_lane' => $inc_details['lane'],
                                    'home_houseno' => $inc_details['h_no'],
                                    'home_pin' => $inc_details['pincode'],
                                    'inc_ref_id'=>$inc_re_id);
            
                        $drop_back_data = $this->inc_model->insert_dropback($drop_back);


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
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                    $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => "DROP_BACK",
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }
                
                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "DROP_BACK",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                
            }
            }else if ($inc_details['stand_amb_id']) {

                foreach ($inc_details['stand_amb_id'] as $key=>$stand_amb_id) {
                    
                  
                if($inc_post_details['incient_districts'] == '')
                {
                    $district = $inc_post_details['incient_district'];
                }else{
                    $district = $inc_post_details['incient_districts'];
                }
                $inc_re_id = $inc_id;
                $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_type' => $inc_details['inc_type'],
                'inc_back_hospital' => $inter_details['facility'],
                'current_district' => $inter_details['current_district'],
                'inc_back_home_address' => $inc_details['home_address'],
                'inc_ero_summary' => $inc_details['inc_ero_summary'],
                'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
                'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
                'inc_dispatch_time' => $inc_details['caller_dis_timer'],
                // 'inc_city' => $inc_details['inc_city'],
                'inc_city_id' => $inc_post_details['incient_ms_city'],
                //'inc_state' => $inc_post_details['incient_state'],
                'inc_state_id' => $inc_post_details['incient_state'],
                'inc_address' => $inc_details['place'],
                 'inc_tahshil_id' => $inc_post_details['incient_tahsil'],
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
                        $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);

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

                    if($inc_details['stand_amb_id']){
                        
                        $incidence_amb_details = array('amb_rto_register_no' => $inc_details['stand_amb_id'],
                            'inc_ref_id' => $inc_re_id,
                            'amb_pilot_id' => $pilot,
                            'amb_emt_id' => $EMT,
                            'amb_type'=> 'standby',
                            'inc_base_month' => $this->post['base_month'],
                            'assigned_time' => $datetime);

                        $this->inc_model->insert_inc_amb($incidence_amb_details);
                    }
                    
                    if($pilot != ''){
                    
                        $args_operator1 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $pilot,
                            'operator_type' => 'UG-PILOT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'DROP_BACK',
                            'base_month' => $this->post['base_month']
                        );
                        $args_operator1 = $this->common_model->assign_operator($args_operator1);
                    }

                    if($EMT != ''){
                        $args_operator2 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $EMT,
                            'operator_type' => 'UG-EMT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'DROP_BACK',
                            'base_month' => $this->post['base_month']
                        );

                        $args_operator2 = $this->common_model->assign_operator($args_operator2);
                    }
                    
                
                    $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                    if ($inc_details['chief_complete_other'] != '') {
                        $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                    }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                
                if($cl_type == 'enable_dispatch'){

                    $item_key= $inc_details['enable_standard_summary'];

                     foreach ($item_key as $key=>$enable_standard_summary) {

                         $enable_data = array(
                             'inc_ref_id' => $inc_re_id,
                             'enable_remark' => $enable_standard_summary,
                             'amb_reg_no' => $inc_details['enable_ambulance'][$key],
                             'added_date' => $datetime,
                             'added_by' => $this->clg->clg_ref_id,
                         );
                         $enable = $this->inc_model->insert_inc_enable_dispatch($enable_data);
                     }
                 }
                

                $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
                $last_pat_id = $last_insert_pat_id[0]->p_id + 1;
               // $last_pat_id = $this->clg->clg_id.'_'.$last_pat_id;
                $last_pat_id = generate_ptn_id();

                    $incidence_patient_details = array('ptn_fname' => ucfirst($patient['first_name']),
                        'ptn_mname' => ucfirst($patient['middle_name']),
                        'ptn_lname' => ucfirst($patient['last_name']),
                        'ptn_gender' => $patient['gender'],
                        'ptn_fullname' => ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']),
                        'ptn_age' => $patient['age'],
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }

                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "DROP_BACK",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                }
            }else{
                    
                  if($inc_post_details['incient_districts'] == '')
                {
                    $district = $inc_post_details['incient_district'];
                }else{
                    $district = $inc_post_details['incient_districts'];
                }
                
                $inc_re_id = $inc_id;
                $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_type' => $inc_details['inc_type'],
                'inc_back_hospital' => $inter_details['facility'],
                'current_district' => $inter_details['current_district'],
                'inc_back_home_address' => $inc_details['home_address'],
                'inc_ero_summary' => $inc_details['inc_ero_summary'],
                 'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
                'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
                'inc_dispatch_time' => $inc_details['caller_dis_timer'],
                // 'inc_city' => $inc_details['inc_city'],
                'inc_city_id' => $inc_post_details['incient_ms_city'],
                //'inc_state' => $inc_post_details['incient_state'],
                'inc_state_id' => $inc_post_details['incient_state'],
                'inc_address' => $inc_details['place'],
                 'inc_tahshil_id' => $inc_post_details['incient_tahsil'],
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
                'inc_recive_time' => $inc_details['inc_recive_time'],
                'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
                'inc_added_by' => $this->clg->clg_ref_id,
                'inc_system_type' => $system
            );
        if($cl_type == 'transfer_108'){
             
            $incidence_details['inc_set_amb'] = '0';
            $incidence_details['incis_deleted'] = '0';
             
         }else if($cl_type == 'transfer_102'){
            $incidence_details['inc_set_amb'] = '0';
            $incidence_details['incis_deleted'] = '0';
             
         }else if($cl_type == 'terminate'){
             $incidence_details['inc_set_amb'] = '1';
             $incidence_details['incis_deleted'] = '2';
             
         }else if($cl_type == 'enable_dispatch'){
             $incidence_details['inc_set_amb'] = '0';
             $incidence_details['incis_deleted'] = '3';
             
         }else{
               $incidence_details['inc_set_amb'] = '1';
               $incidence_details['incis_deleted'] = '0';
               $incidence_details['inc_system_type'] = $system;
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
                        $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);

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

            if($cl_type != 'enable_dispatch'){          
                    if($inc_details['stand_amb_id']){
                        $incidence_amb_details = array('amb_rto_register_no' => $inc_details['stand_amb_id'],
                            'inc_ref_id' => $inc_re_id,
                            'amb_pilot_id' => $pilot,
                            'amb_emt_id' => $EMT,
                            'amb_type'=> 'standby',
                            'inc_base_month' => $this->post['base_month'],
                            'assigned_time' => $datetime);

                        $this->inc_model->insert_inc_amb($incidence_amb_details);
                    }
                    
                 
                    if($pilot != ''){
                    
                        $args_operator1 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $pilot,
                            'operator_type' => 'UG-PILOT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'DROP_BACK',
                            'base_month' => $this->post['base_month']
                        );
                        $args_operator1 = $this->common_model->assign_operator($args_operator1);
                    }

                    if($EMT != ''){
                        $args_operator2 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $EMT,
                            'operator_type' => 'UG-EMT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'DROP_BACK',
                            'base_month' => $this->post['base_month']
                        );

                        $args_operator2 = $this->common_model->assign_operator($args_operator2);
                    }
            }
                
                    $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                    if ($inc_details['chief_complete_other'] != '') {
                        $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                    }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                
                if($cl_type == 'enable_dispatch'){

                    $item_key= $inc_details['enable_standard_summary'];

                     foreach ($item_key as $key=>$enable_standard_summary) {

                         $enable_data = array(
                             'inc_ref_id' => $inc_re_id,
                             'enable_remark' => $enable_standard_summary,
                             'amb_reg_no' => $inc_details['enable_ambulance'][$key],
                             'added_date' => $datetime,
                             'added_by' => $this->clg->clg_ref_id,
                         );
                         $enable = $this->inc_model->insert_inc_enable_dispatch($enable_data);
                     }
                 }
                

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
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }

                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "DROP_BACK",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
            
            }
            
        }
        //update_102_inc_ref_id($inc_id);


        /* send sms to patient  */
        $sms_amb = $inc_details['amb_id'];
        $get_mobile_no = array('rg_no' => $sms_amb);
        $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);
        $driver = $this->colleagues_model->get_user_info($pilot);
        $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;
        $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;

        //$inc_id = $inc_id;
        $amb_url = base_url() . "amb/loc/" . $inc_re_id;
        $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_re_id;

        //$amb_url = "http://210.212.165.123/tdd/amb/loc/" . $inc_id;
        //$amb_dir_url = "http://210.212.165.123/tdd/amb/amb_dir/" . $inc_id;



        $doctor = $this->colleagues_model->get_user_info($EMT);
        $sms_doctor = $doctor[0]->clg_first_name;
        $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;
        $patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];
        $patient_mobile_no = $caller_details['clr_mobile'];
        //$patient_mobile_no = "9730015484";
        $patient_name = $caller_details['clr_fname'];

        $patient_sms_text = "Ambulance dispatched: $sms_amb\n Ambulance Contact - $sms_doctor_contact_no\n Track Link- $amb_url\nJAES";


        $patient_sms_to = $caller_details['clr_mobile'];
        //$patient_sms_to =  "8551995260";
        $send_dr_sms = $this->_send_sms($patient_sms_to, $patient_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_re_id,
            'sms_usertype' => 'Caller',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);



        /* send sms to doctor  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];



        $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call 108 ERC for Case ID creation.  JAES";


        $doctor_sms_to = $sms_doctor_contact_no;
        // $doctor_sms_to = '8551995260';
        $send_dr_sms = $this->_send_sms($doctor_sms_to, $doctor_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_re_id,
            'sms_usertype' => 'EMT',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);

        /* send sms to Pilot  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];

        $driver_sms_text = "Dear Pilot, Patient name: $patient_full_name,  Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id , Patient id:$last_pat_id  Navigate- $amb_dir_url JAES";

        $driver_contact_no = $sms_driver_contact_no;

        if ($call_type['cl_type'] == 'transfer_108') {


            _ucd_assign_call($inc_re_id);
        }
        
        if ($call_type['cl_type'] == 'transfer_102') {

           _ucd_102_assign_call($inc_re_id,$this->clg->clg_group);
        }
         //die();
        
        $this->output->status = 1;
        $this->output->closepopup = "yes";
        ($call_type['cl_type'] == 'forword') ? $msg = "forworded" : $msg = "Added";
        $url = base_url("calls");
        $this->output->message = "<h3>Drop Back Call</h3><br><p>Ambulance Dispatch Successfully</p><script>window.location.href = '".$url."';</script>";
        $this->output->moveto = 'top';
        $this->output->add_to_position('', 'content', TRUE);
        }
    }
    
    
    
    
    function confirm_childcare_save() {
        $this->session->unset_userdata('incient');
        $this->session->unset_userdata('call_type');

        $call_type = $this->input->get();
        $call_type = $this->input->get_post('call_type');
        
        $inc_post_details = $this->input->post();

        $inc_details = $this->input->get_post('incient');
        $patient = $this->input->get_post('patient');
        $caller_details = $this->input->get_post('caller');
      
        if($inc_post_details['call_type'] == 'terminate'){
            if($inc_details['amb_id'] != ''){

                $this->output->message = "<div class='error'>Remove Ambulance Selected ambulance</div>";
                return;

            }
        }


        $dup_inc = $inc_details['dup_inc'];
        $datetime = date('Y-m-d H:i:s');

        $call_id = $this->input->get_post('call_id');
        $this->session->set_userdata('mic_details', $inc_details);
        $this->session->set_userdata('incient', $inc_details);
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

        if($call_type != 'terminate'  && $call_type != 'transfer_108' && $call_type != 'transfer_102'){
            if ($inc_details['amb_id'] == '' && $dup_inc == 'No' ) {

                $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";

                return;
            }
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
            update_inc_ref_id($inc_id);
            $this->session->set_userdata('inc_ref_id', $inc_id);
        }
        $data['inc_ref_id'] = $inc_id;
        $data['patient'] = $patient;

        $data['get_amb_details'] = $get_amb_details;
        $data['inc_details'] = $inc_details;
        $data['hospital_id'] = $inc_details['hospital_id'];
        $data['hospital_other'] = $inc_details['hospital_other'];

        $data['caller_details'] = $session_caller_details;
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];

        $data['place'] = $inc_details['place'];

        $data['cl_type'] = $call_type;
        $data['inc_datetime'] = $datetime;

        $this->output->add_to_popup($this->load->view('frontend/inc/confirm_child_care_view', $data, TRUE), '600', '560');

        //   $this->output->add_to_position($this->load->view('frontend/patient/pt_inc_summary_view', $data, TRUE), 'summary_div', TRUE);
    }
    function confirm_onscenecare_save() {
        $this->session->unset_userdata('mic_details');
        $this->session->unset_userdata('call_type');
        $this->session->unset_userdata('patient');
        $this->session->unset_userdata('incient');
        $this->session->unset_userdata('inc_datetime');
        $this->session->unset_userdata('inc_ref_id');
        


        $call_type = $this->input->get();
        $inc_post_details = $this->input->post();
       
        $inc_details = $this->input->get_post('incient');
        $patient = $this->input->get_post('patient');
        $caller_details = $this->input->get_post('caller');
        $call_type = $this->input->get_post('call_type');
       

        //$dup_inc = $inc_details['dup_inc'];
        $datetime = date('Y-m-d H:i:s');

        $call_id = $this->input->get_post('call_id');
        $this->session->set_userdata('mic_details', $inc_details);
        $this->session->set_userdata('call_type', $call_type);
        $this->session->set_userdata('call_id', $call_id);
        $this->session->set_userdata('patient', $patient);
        $this->session->set_userdata('inc_datetime', $datetime);



        $session_caller_details = $this->session->userdata('caller_details_data');


        $this->session->set_userdata('inc_post_details', $inc_post_details);
        
        if ($inc_post_details['amb_reg_id'] == '') {

            $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";

            return;
        }
        $args = array(
            'rg_no' => $inc_post_details['amb_reg_id'],
        );
        $get_amb_details[] = $this->inc_model->get_amb_details($args);
        $this->session->set_userdata('amb_details', $get_amb_details);
        
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
        
         $data['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inc_details['inc_ero_standard_summary']));
         
        if($inc_details['chief_complete'] != ''){
              $data['nature'] = $this->inc_model->get_chief_comp_service($inc_details['chief_complete']);
        }
        $this->output->add_to_popup($this->load->view('frontend/inc/confirm_on_scene_care_view', $data, TRUE), '600', '560');
    }
   /* function confirm_onscenecare_save() {
        // var_dump($this->input->post());die();
        $this->session->unset_userdata('incient');
        $this->session->unset_userdata('call_type');

        $call_type = $this->input->get();
        $call_type = $this->input->get_post('call_type');
        
        $inc_post_details = $this->input->post();

        $inc_details = $this->input->get_post('incient');
       // var_dump($inc_post_details);die();
        $patient = $this->input->get_post('patient');
        $caller_details = $this->input->get_post('caller');

        $amb_reg_id = $inc_post_details['amb_reg_id'];
        

        //$dup_inc = $inc_details['dup_inc'];
        $datetime = date('Y-m-d H:i:s');

        $call_id = $this->input->get_post('call_id');
        $this->session->set_userdata('mic_details', $inc_details);
        $this->session->set_userdata('incient', $inc_details);
        $this->session->set_userdata('call_type', $call_type);
        $this->session->set_userdata('call_id', $call_id);
        $this->session->set_userdata('patient', $patient);
        $this->session->set_userdata('inc_datetime', $datetime);



        $session_caller_details = $this->session->userdata('caller_details');


        $this->session->set_userdata('inc_post_details', $inc_post_details);
        // var_dump( $this->input->get_post('caller'));
        // die();

        //$data['police_chief'] = $this->call_model->get_police_chief_comp(array('po_ct_id' => $inc_details['police_chief_complete']));
        
       // $data['fire_chief'] = $this->call_model->get_fire_chief_comp(array('fi_ct_id' => $inc_details['fire_chief_complete']));

        //$data['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inc_details['inc_ero_standard_summary']));




        //$data['nature'] = $this->inc_model->get_chief_comp_service($inc_details['chief_complete']);

        /*if($call_type != 'terminate'  && $call_type != 'transfer_108' && $call_type != 'transfer_102'){
            if ($inc_details['amb_id'] == '' && $dup_inc == 'No' ) {

                $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";

                return;
            }
        }*/

       /* $args = array(
            'rg_no' => $amb_reg_id,
        );
        $get_amb_details[] = $this->inc_model->get_amb_details($args);
        

        $inc_id = $this->session->userdata('inc_ref_id');
        $amb_details = $this->session->set_userdata($get_amb_details);
        
        //var_dump($get_amb_details);die();
        if ($inc_id == '') {
            $inc_id = generate_inc_ref_id();
            $this->session->set_userdata('inc_ref_id', $inc_id);
            update_inc_ref_id($inc_id);
        }
        
        $data['inc_ref_id'] = $inc_id;
        $data['patient'] = $patient;

        $data['get_amb_details'] = $get_amb_details;
        $data['inc_details'] = $inc_details;
        // $data['hospital_id'] = $inc_details['hospital_id'];
        // $data['hospital_other'] = $inc_details['hospital_other'];

        $data['caller_details'] = $session_caller_details;
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];

        $data['place'] = $inc_details['place'];

        $data['cl_type'] = $call_type;
        $data['inc_datetime'] = $datetime;
        $data['amb_reg_id'] = $amb_reg_id;
        //var_dump($get_amb_details);die();
        $this->output->add_to_popup($this->load->view('frontend/inc/confirm_on_scene_care_view', $data, TRUE), '600', '560');

        
    }*/
    function save_childcare() {

        $call_type = $this->input->get();
        $inc_details = $this->input->get_post('incient');
        $call_id = $this->input->get_post('call_id');
        $caller_details = $this->session->userdata('caller_details');
        $inc_details = $this->session->userdata('mic_details');
        $inc_post_details = $this->session->userdata('inc_post_details');
        $patient= $this->session->userdata('patient');
        $cl_type = $this->input->get_post('cl_type');


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
            $inc_post_details['incient_state'] = "MP";
        }
        $date = str_replace('-', '', date('Y-m-d'));

        //$inc_id = $date.$call_id;
        $inc_id = $this->session->userdata('inc_ref_id');




        $sr_user = $this->clg->clg_ref_id;

        $sms_amb_details = $inc_details['amb_id'];
        
        if($call_type != 'terminate'  && $call_type != 'transfer_108' && $call_type != 'transfer_102'){  
            if ($inc_details['amb_id'] == '' && $dup_inc == 'Yes') {

                $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";

                return;
            }
        }


        if($inc_details['inc_ref_id'] != ""){
            if ($dup_inc == 'No') {
            $amb_count =0;
            $inc_re_id = $inc_id;
            foreach ($inc_details['amb_id'] as $key=>$select_amb) {
                $amb_count++;
                $inc_re_id = $inc_id.'-'.$amb_count;
                
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
                'inc_tahshil_id' => $inc_post_details['incient_tahsil'],
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
                //'inc_set_amb' => '1',
                'inc_recive_time' => $inc_details['inc_recive_time'],
                'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
                'inc_added_by' => $this->clg->clg_ref_id,
                'inc_wht_three_wrd' => $inc_details['3word'],
            'bk_inc_ref_id' => $inc_id,
            'inc_thirdparty' => $this->clg->thirdparty,
                'inc_system_type' => $system
            );
                
        
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
              $this->call_model->update_booking_details($caller_details['clr_mobile']);
            
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
        $caller_loc = $inc_details['place'];
        $caller_lat = $inc_details['lat'];
        $caller_lng = $inc_details['lng'];
        $destination_hos = $pri_hosp_name;
        $hos_lat = $pri_hosp_lat;
        $hos_lng =$pri_hosp_lng;
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
        
        $denial_id = $this->session->userdata('denial_id');
        if($denial_id){
            foreach($denial_id as $denial){
                $com_args = array('inc_ref_id'=>$inc_id,'id'=>$denial);
                $update_app_call_details = $this->Dashboard_model->update_denial($com_args);

            } 
        }
       
        
       
                $inc_details['amb_id'] = $select_amb;
                $EMT = "";
                $pilot = '';        
                $emp_inc_data = $this->inc_model->get_amb_emp($inc_details['amb_id'], $sft_id);

                if (empty($emp_inc_data)) {
                    $tm_team_date = date('Y-m-d');
                    $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);
                  

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
                if($inc_details['amb_id']){  
                    $incidence_amb_details = array('amb_rto_register_no' => $inc_details['amb_id'],
                        'inc_ref_id' => $inc_re_id,
                        'amb_pilot_id' => $pilot,
                        'amb_emt_id' => $EMT,
                        'inc_base_month' => $this->post['base_month'],
                        'assigned_time' => $datetime);
                    $this->inc_model->insert_inc_amb($incidence_amb_details);
                }

                if($pilot != ''){
                    $args_operator1 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $pilot,
                        'operator_type' => 'UG-PILOT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'Child_CARE_CALL',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator1 = $this->common_model->assign_operator($args_operator1);
                }

                if($EMT != ''){
                    $args_operator2 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $EMT,
                        'operator_type' => 'UG-EMT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'Child_CARE_CALL',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator2 = $this->common_model->assign_operator($args_operator2);
                }

                
                $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);

                $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
                
                 $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                if ($inc_details['chief_complete_other'] != '') {
                    $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                }

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
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                    $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }

                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "Child_CARE_CALL",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                
            }

            if ($inc_details['stand_amb_id']) {

                foreach ($inc_details['stand_amb_id'] as $key=>$stand_amb_id) {
                  
                    
                  if($inc_post_details['incient_districts'] == '')
                {
                    $district = $inc_post_details['incient_district'];
                }else{
                    $district = $inc_post_details['incient_districts'];
                }    
                    
                $inc_re_id = $inc_id.'-'.$key+1;
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
                 'inc_tahshil_id' => $inc_post_details['incient_tahsil'],
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

                    $inc_details['stand_amb_id'] = $stand_amb_id;

                    $EMT = "";
                    $pilot = '';
                    //$emp_inc_data = $this->inc_model->get_amb_default_emp(trim($inc_details['amb_id']), $sft_id);
                    //$emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['stand_amb_id'], $sft_id);
                    //
                    //$pilot = $emp_inc_data[0]->tm_pilot_id;
                    //$EMT = $emp_inc_data[0]->tm_emt_id;

                    $emp_inc_data = $this->inc_model->get_amb_emp($inc_details['amb_id'], $sft_id);

                    if (empty($emp_inc_data)) {
                        $tm_team_date = date('Y-m-d');
                        $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);

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

                    if($inc_details['stand_amb_id']){  
                        $incidence_amb_details = array('amb_rto_register_no' => $inc_details['stand_amb_id'],
                            'inc_ref_id' => $inc_re_id,
                            'amb_pilot_id' => $pilot,
                            'amb_emt_id' => $EMT,
                            'amb_type'=> 'standby',
                            'inc_base_month' => $this->post['base_month'],
                            'assigned_time' => $datetime);

                        $this->inc_model->insert_inc_amb($incidence_amb_details);
                    }
                    
                    if($pilot != ''){
                    
                        $args_operator1 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $pilot,
                            'operator_type' => 'UG-PILOT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'Child_CARE_CALL',
                            'base_month' => $this->post['base_month']
                        );
                        $args_operator1 = $this->common_model->assign_operator($args_operator1);
                    }

                    if($EMT != ''){
                        $args_operator2 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $EMT,
                            'operator_type' => 'UG-EMT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'Child_CARE_CALL',
                            'base_month' => $this->post['base_month']
                        );

                        $args_operator2 = $this->common_model->assign_operator($args_operator2);
                    }
                    
                
                    $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                    if ($inc_details['chief_complete_other'] != '') {
                        $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                    }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                

                $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
                $last_pat_id = $last_insert_pat_id[0]->p_id + 1;
                //$last_pat_id = $this->clg->clg_id.'_'.$last_pat_id;
                 $last_pat_id = generate_ptn_id();
                
                $denial_id = $this->session->userdata('denial_id');
                if($denial_id){
                    foreach($denial_id as $denial){
                        $com_args = array('inc_ref_id'=>$inc_re_id,'id'=>$denial);
                        $update_app_call_details = $this->Dashboard_model->update_denial($com_args);

                    } 
                }

                    $incidence_patient_details = array('ptn_fname' => ucfirst($patient['first_name']),
                        'ptn_mname' => ucfirst($patient['middle_name']),
                        'ptn_lname' => ucfirst($patient['last_name']),
                        'ptn_gender' => $patient['gender'],
                        'ptn_fullname' => ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']),
                        'ptn_age' => $patient['age'],
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                $ques_ans = $inc_details['ques'];
                
                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }
                

                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "Child_CARE_CALL",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                }
            }
        }

          //update_102_inc_ref_id($inc_id);
        $call_history_id = $this->session->userdata('call_history_id');
			
		_ucd_dispatch_call($inc_details['inc_ref_id'],$this->clg->clg_ref_id,$call_history_id);


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

        $patient_sms_text = "Ambulance dispatched: $sms_amb\n Ambulance Contact - $sms_doctor_contact_no\n Track Link- $amb_url\nJAES";


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

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id, Patient id:$last_pat_id, Navigate- $amb_url JAES";
        } else if ($get_driver_no[0]->amb_user_type = 'bike') {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call Bike Desk for Case ID creation. JAES";
        } else {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call 108 ERC for Case ID creation.  JAES";
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

        $driver_sms_text = "Dear Pilot, Patient name: $patient_full_name,  Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id , Patient id:$last_pat_id  Navigate- $amb_dir_url JAES";

        $driver_contact_no = $sms_driver_contact_no;

        if ($call_type['cl_type'] == 'transfer_108') {

             _ucd_assign_call($inc_id);
        }
        
        if ($call_type['cl_type'] == 'transfer_102') {

            _ucd_102_assign_call($inc_re_id,$this->clg->clg_group);
        }
        
        $this->output->status = 1;
        $this->output->closepopup = "yes";
        ($call_type['cl_type'] == 'forword') ? $msg = "forworded" : $msg = "Added";
        
        $url = base_url("calls");
        $this->output->message = "<h3>Child Care Call</h3><br><p>Ambulance Dispatch Successfully</p><script>window.location.href = '".$url."';</script>";
        $this->output->moveto = 'top';
        $this->output->add_to_position('', 'content', TRUE);
        }else{
        if ($dup_inc == 'No') {
            $amb_count =0;
            $inc_re_id = $inc_id;
            if($inc_details['amb_id']){
                foreach ($inc_details['amb_id'] as $key=>$select_amb) {
                $amb_count++;
                $inc_re_id = $inc_id;

                
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
                'inc_district_id' => $inc_post_details['incient_districts'],
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
                //'inc_set_amb' => '1',
                'inc_recive_time' => $inc_details['inc_recive_time'],
                'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
                'inc_added_by' => $this->clg->clg_ref_id,
                'inc_system_type' => $system
            );
                
        
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
            
            
                $inc_details['amb_id'] = $select_amb;
                $EMT = "";
                $pilot = '';        
                $emp_inc_data = $this->inc_model->get_amb_emp($inc_details['amb_id'], $sft_id);

                if (empty($emp_inc_data)) {
                    $tm_team_date = date('Y-m-d');
                    $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);
                  

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
                if($inc_details['amb_id']){  
                    $incidence_amb_details = array('amb_rto_register_no' => $inc_details['amb_id'],
                        'inc_ref_id' => $inc_re_id,
                        'amb_pilot_id' => $pilot,
                        'amb_emt_id' => $EMT,
                        'inc_base_month' => $this->post['base_month'],
                        'assigned_time' => $datetime);
                    $this->inc_model->insert_inc_amb($incidence_amb_details);
                }

                if($pilot != ''){
                    $args_operator1 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $pilot,
                        'operator_type' => 'UG-PILOT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'Child_CARE_CALL',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator1 = $this->common_model->assign_operator($args_operator1);
                }

                if($EMT != ''){
                    $args_operator2 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $EMT,
                        'operator_type' => 'UG-EMT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'Child_CARE_CALL',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator2 = $this->common_model->assign_operator($args_operator2);
                }

                
                $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);

                $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
                
                 $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                if ($inc_details['chief_complete_other'] != '') {
                    $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                

                $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
                $last_pat_id = $last_insert_pat_id[0]->p_id + 1;
                // $last_pat_id = $this->clg->clg_id.'_'.$last_pat_id;
                 $last_pat_id = generate_ptn_id();

                $incidence_patient_details = array('ptn_fname' => ucfirst($patient['first_name']),
                        'ptn_mname' => ucfirst($patient['middle_name']),
                        'ptn_lname' => ucfirst($patient['last_name']),
                        'ptn_gender' => $patient['gender'],
                        'ptn_fullname' => ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']),
                        'ptn_age' => $patient['age'],
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                    $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }

                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "Child_CARE_CALL",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                
            }
            }

            if ($inc_details['stand_amb_id']) {

                foreach ($inc_details['stand_amb_id'] as $key=>$stand_amb_id) {
                    
                    
                $inc_re_id = $inc_id.'-'.$key+1;
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
                'inc_district_id' => $inc_post_details['incient_districts'],
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

                    $inc_details['stand_amb_id'] = $stand_amb_id;

                    $EMT = "";
                    $pilot = '';
                    //$emp_inc_data = $this->inc_model->get_amb_default_emp(trim($inc_details['amb_id']), $sft_id);
                //$emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['stand_amb_id'], $sft_id);
                            //
                //$pilot = $emp_inc_data[0]->tm_pilot_id;
                //$EMT = $emp_inc_data[0]->tm_emt_id;

                    $emp_inc_data = $this->inc_model->get_amb_emp($inc_details['amb_id'], $sft_id);

                    if (empty($emp_inc_data)) {
                        $tm_team_date = date('Y-m-d');
                        $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);

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
                        'assigned_time' => $datetime);

                    $this->inc_model->insert_inc_amb($incidence_amb_details);
                    
                    if($pilot != ''){
                    
                        $args_operator1 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $pilot,
                            'operator_type' => 'UG-PILOT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'Child_CARE_CALL',
                            'base_month' => $this->post['base_month']
                        );
                        $args_operator1 = $this->common_model->assign_operator($args_operator1);
                    }

                    if($EMT != ''){
                        $args_operator2 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $EMT,
                            'operator_type' => 'UG-EMT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'Child_CARE_CALL',
                            'base_month' => $this->post['base_month']
                        );

                        $args_operator2 = $this->common_model->assign_operator($args_operator2);
                    }
                    
                
                    $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                    if ($inc_details['chief_complete_other'] != '') {
                        $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                    }

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
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                $ques_ans = $inc_details['ques'];
                
                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }
                

                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "Child_CARE_CALL",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                }
            }
        }

        //update_102_inc_ref_id($inc_id);


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

        $patient_sms_text = "Ambulance dispatched: $sms_amb\n Ambulance Contact - $sms_doctor_contact_no\n Track Link- $amb_url\nJAES";


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

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id, Patient id:$last_pat_id, Navigate- $amb_url JAES";
        } else if ($get_driver_no[0]->amb_user_type = 'bike') {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call Bike Desk for Case ID creation. JAES";
        } else {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call 108 ERC for Case ID creation.  JAES";
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

        $driver_sms_text = "Dear Pilot, Patient name: $patient_full_name,  Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_id , Patient id:$last_pat_id  Navigate- $amb_dir_url JAES";

        $driver_contact_no = $sms_driver_contact_no;

        if ($call_type['cl_type'] == 'transfer_108') {

             _ucd_assign_call($inc_id);
        }
        
        if ($call_type['cl_type'] == 'transfer_102') {

            _ucd_102_assign_call($inc_re_id,$this->clg->clg_group);
        }
        
        $this->output->status = 1;
        $this->output->closepopup = "yes";
        ($call_type['cl_type'] == 'forword') ? $msg = "forworded" : $msg = "Added";
        
        $url = base_url("calls");
        $this->output->message = "<h3>Child Care Call</h3><br><p>Ambulance Dispatch Successfully</p><script>window.location.href = '".$url."';</script>";
        $this->output->moveto = 'top';
        $this->output->add_to_position('', 'content', TRUE);
    }
    }

    

    /*function save_onscenecare() {

        $call_type = $this->input->get();
        $inc_details = $this->input->get_post('incient');
        $call_id = $this->input->get_post('call_id');
        $caller_details = $this->session->userdata('caller_details');
        $inc_details = $this->session->userdata('mic_details');
        $amb_details = $this->session->userdata('amb_details');
        // $inc_details = $this->input->get_post('amb_id');
        var_dump($amb_details);
       // get_amb_details
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

       // $state_id = $this->inc_model->get_state_id($inc_details['state']);
       // $district_id = $this->inc_model->get_district_id($inc_details['inc_district'], $state_id->st_code);

      //  $city_id = $this->inc_model->get_city_id($inc_details['incient_ms_city'], $district_id->dst_code, $state_id->st_code);
        
        if($this->clg->clg_group == 'UG-ERO-102'){
            $system = '102';
        }if($this->clg->clg_group == 'UG-BIKE-ERO'){
            $system = 'BIKE';
        }else{
            $system = '108';
        }


        /*if (isset($district_id)) {

            $district_id = $district_id->dst_code;
        } else {

            $district_id = "0";
        }*/

        /*if (isset($city_id)) {

            $city_id = $city_id->cty_id;
        } else {

            $city_id = "0";
        }*/

        /*if (isset($state_id)) {

            $state_id = $state_id->st_code;
        } else {

            $state_id = "0";
        }*/


       /* $inc_details_service = serialize($inc_details['service']);
        


        if ($inc_post_details['incient_state'] == '') {
            $inc_post_details['incient_state'] = "";
        }
        $date = str_replace('-', '', date('Y-m-d'));
         //var_dump($get_amb_details);die();
        //get_amb_details
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
            'destination_hospital_id' => $inc_details['hos_id'],
            'destination_hospital_other' => $inc_details['hospital_other'],
            // 'hospital_id' => $inc_details['hospital_id'],
           // 'hospital_name' => $inc_details['hospital_other'],
           // 'hospital_type' => 'ALL',
            'inc_datetime' => $datetime,
            'inc_service' => $inc_details_service,
            'inc_duplicate' => $dup_inc,
            'inc_base_month' => $this->post['base_month'],
            'inc_set_amb' => '1',
            'inc_suggested_amb' => $inc_details['inc_suggested_amb'],
            'inc_recive_time' => $inc_details['inc_recive_time'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_wht_three_wrd' => $inc_details['3word'],
            'bk_inc_ref_id' => $inc_id,
            'inc_thirdparty' => $this->clg->thirdparty,
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


        // $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
        // if ($inc_details['chief_complete_other'] != '') {
        //     $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
        // }
        // if($thirdparty!='' || $thirdparty != '0'){
        // $incidence_details['inc_thirdparty'] = $thirdparty;
        // }
        // else{
        //     $incidence_details['inc_thirdparty'] = $this->clg->thirdparty;
        // }
       
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
       
        $api_url = "http://localhost/mhems/api/googlenotification";
		$json_data = array('ambulanceNo'=>$select_amb,
						   'incidentId'=>$inc_id);

        $json_data= json_encode($json_data);
                
        $api_google = api_notification_app($api_url,$json_data);

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
        //var_dump($args);die();
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

           /* if ($inc_details['service'][2] == '2') {

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

                $incidence_patient_details = array('ptn_fname' => ucfirst($patient['first_name']),
                    'ptn_mname' => ucfirst($patient['middle_name']),
                    'ptn_lname' => ucfirst($patient['last_name']),
                    'ptn_gender' => $patient['gender'],
                    'ptn_fullname' => ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']),
                    'ptn_age' => $patient['age'],
                    'ptn_age_type' => $patient['age_type'],
                    'ptn_birth_date' => $patient['dob'],
                    'ptn_id' => $last_pat_id
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
        // var_dump( $ems_summary);die();
                $this->inc_model->insert_ems_summary($ems_summary);
            }
        }

        /* send sms to patient */
     /*   $sms_amb = $select_amb;
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
        // $chief_complaint = get_cheif_complaint($incidence_details['inc_complaint']);
       // $hospital_name = $inc_details['hos_name'];
        // if($inc_details['hos_name']!='' || $inc_details['hos_name']!='null'){
        //     $hospital_name = $inc_details['hos_name'];
        // }else{
        //     $hospital_name = $inc_details['hospital_other'];
        // }
        //$patient_sms_text = "Ambulance dispatched: $sms_amb\n Ambulance Contact - $sms_doctor_contact_no\n Track Link- $amb_url\nJAES";
        $txtMsg1.= "BVG\n";
       // $txtMsg1.= "Dear ".$patient_full_name."\n";
        $txtMsg1.= "Ambulance dispatched: ".$sms_amb."\n";
        $txtMsg1.= "Ambulance Contact - ".$sms_doctor_contact_no."\n" ;
       // $txtMsg1.= "TrackAmbulance- ".$amb_url."\n";
        $txtMsg1.= "EMS" ;
        $sms_to = $caller_details['clr_mobile'];
        $args = array(
            'inc_id' => $inc_id,
            'msg' => $txtMsg1,
            'mob_no' => $sms_to,
            'sms_user'=>'patient',
        );
       $sms_data = sms_send($args);
         /* send sms to doctor  */
    /*    $patient_name = $caller_details['clr_fname'];
            //$txtMsg2.= "BVG\n";
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
        
        /* send sms to Pilot notification to pilot */
      
      /*  $api_url = "http://localhost/mhems/api/googlenotification";
		$json_data = array('ambulanceNo'=>$inc_details['amb_id'],
						   'incidentId'=>$inc_id);

        $json_data= json_encode($json_data);
                
        $api_google = api_notification_app($api_url,$json_data);

        // nuvas send API
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


        if($inc_data){
        $this->output->message = "<h3>On Scene Care Call</h3><br><p>Ambulance Dispatch Successfully</p><script>window.location.reload(true);</script>";



        $this->output->moveto = 'top';



        $this->output->add_to_position('', 'content', TRUE);
        
        }else{
               $this->output->message = "<h3>On Scene Care Call</h3><br><p>Error in Ambulance Dispatch</p>";
        }
    }
*/
function save_onscenecare() {

        
        
        
    $call_type = $this->input->get();
    $inc_details = $this->input->get_post('incient');
    $call_id = $this->input->get_post('call_id');
    $caller_details = $this->session->userdata('caller_details');
    $inc_details = $this->session->userdata('mic_details');
    $amb_details = $this->session->userdata('amb_details');
    $pt_count = $this->input->get_post('inc_patient_cnt');
    $inc_post_details = $this->session->userdata('inc_post_details');
    //var_dump($inc_patient_cnt);

    $datetime = date('Y-m-d H:i:s');
    $datetime = $this->session->userdata('inc_datetime');

    $sft_id = get_cur_shift();

    $call_id = $this->session->userdata('call_id');


   // $dup_inc = $inc_details['dup_inc'];

    $district_id = "0";
    $city_id = "0";
    $state_id = "0";

    $state_id = $amb_details[0][0]->amb_state;
    $district_id =   $amb_details[0][0]->amb_district;
    $city_id =   $amb_details[0][0]->amb_city;
    if($this->clg->clg_group == 'UG-ERO-102'){
        $system = '102';
    }if($this->clg->clg_group == 'UG-BIKE-ERO'){
        $system = 'BIKE';
    }else{
        $system = '108';
    }


    if (isset($district_id)) {

        $district_id = $district_id;
    } else {

        $district_id = "0";
    }

    if (isset($city_id)) {

        $city_id = $city_id;
    } else {

        $city_id = "0";
    }

    if (isset($state_id)) {

        $state_id = $state_id;
    } else {

        $state_id = 'MP';
    }


   // $inc_details_service = serialize($inc_details['service']);


    if ($inc_post_details['incient_state'] == '') {
        $inc_post_details['incient_state'] = "MP";
    }
    $date = str_replace('-', '', date('Y-m-d'));
 
    
//foreach ($inc_details['amb_id'] as $key => $select_amb) {

   // $amb_count++;
          
    $inc_id = $this->session->userdata('inc_ref_id');
   
    $inc_id = $inc_id;
    //var_dump($amb_details[0][0]->amb_rto_register_no );
   
    $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_id));
    if(!empty($is_exits)){
        $this->output->message = "<div class='error'>Incident Id alredy exists</div>";
        return;
    }

    $dispatch_time = $this->session->userdata('dispatch_time');

    $current_time = time();
    $res_time = $current_time - $dispatch_time;
    $h = ($res_time / (60 * 60)) % 24;
    $m = ($res_time / 60) % 60;
    
    $district = $district_id;
            
    $sr_user = $this->clg->clg_ref_id;

    $patient = $this->input->get_post('patient');

    $patient = $this->session->userdata('patient');

    $EMT = "";

    $pilot = '';

    $tm_team_date = date('Y-m-d');

    $emp_inc_data = $this->inc_model->get_amb_default_emp($amb_details[0][0]->amb_rto_register_no , $sft_id, $tm_team_date);
     $amb_details1 = $this->inc_model->get_ambulance_details_API($amb_details[0][0]->amb_rto_register_no );
    $amb_lat = $amb_details1[0]->amb_lat;
    $amb_log = $amb_details1[0]->amb_log;
    $thirdparty = $amb_details1[0]->thirdparty;
    $ward_id = $amb_details1[0]->ward_id;
    $ward_name = $amb_details1[0]->ward_name;
    $hp_id = $amb_details1[0]->hp_id;
    $hp_name = $amb_details1[0]->hp_name;
    
    //var_dump($ambulance_lat);die;
    if ($emp_inc_data) {
        $pilot = $emp_inc_data[0]->tm_pilot_id;
        $EMT = $emp_inc_data[0]->tm_emt_id;
    }   

    $incidence_details = array('inc_cl_id' => $call_id,
        'inc_ref_id' => $inc_id,
        'inc_patient_cnt' => $inc_post_details['inc_patient_cnt'],
        'inc_type' => $inc_details['inc_type'],
        'inc_ero_summary' => $inc_details['inc_ero_summary'],
        'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
        'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
        'inc_dispatch_time' => $inc_details['caller_dis_timer'],
        'inc_city_id' => $city_id,
        'inc_state_id' => $state_id,
        'inc_div_id' => $amb_details[0][0]->amb_div_code,
        'inc_address' => $hp_name,
        'bed_type' => $inc_details['bed_type'],
        'inc_tahshil_id' => '0',
        'inc_district_id' => $district,
        'inc_area' => $inc_details['area'],
        'inc_landmark' => '0',
        'inc_lane' => '0',
        'inc_h_no' => '0',
        'inc_pincode' => '0',
        'inc_lat' => $amb_details[0][0]->amb_lat,
        'inc_long' => $amb_details[0][0]->amb_log,
        'destination_hospital_id' => $inc_details['hos_id'],
        'destination_hospital_other' => $inc_details['hospital_other'],
        // 'hospital_id' => $inc_details['hospital_id'],
       // 'hospital_name' => $inc_details['hospital_other'],
       // 'hospital_type' => 'ALL',
        'inc_datetime' => $datetime,
        'inc_service' => '1',
        'inc_duplicate' => 'NO',
        'inc_base_month' => $this->post['base_month'],
        'inc_set_amb' => '1',
        'inc_suggested_amb' => '1',
        'inc_recive_time' => $inc_details['inc_recive_time'],
        'inc_added_by' => $this->clg->clg_ref_id,
        'inc_wht_three_wrd' => $inc_details['3word'],
        'bk_inc_ref_id' => $inc_id,
        'inc_thirdparty' => $this->clg->thirdparty,
        'inc_system_type' => $system
    );


    if ($inc_details['chief_complete'] != '') {
        $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
    }
    if ($inc_details['chief_complete_other'] != '') {
        $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
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


    if($thirdparty!='' || $thirdparty != '0'){
    $incidence_details['inc_thirdparty'] = $thirdparty;
    }
    else{
        $incidence_details['inc_thirdparty'] = $this->clg->thirdparty;
    }
   
   // var_dump($incidence_details);die();
    $inc_data = $this->inc_model->insert_inc($incidence_details);       
   //die();

  
   
    $api_url = "http://localhost/JAEms/api/googlenotification";
    $json_data = array('ambulanceNo'=>$amb_details[0][0]->amb_rto_register_no,
                       'incidentId'=>$inc_id,
                       'cheifComplaint' => 'On Scene Care');

    $json_data= json_encode($json_data);
            
    $api_google = api_notification_app($api_url,$json_data);
    
                
            $comm_api_url = "http://localhost/JAEms/communityapp/googlenotification";
            $json_data = array('userMobileNo'=>$caller_details['clr_mobile'],
                               'ambulanceNo'=>$inc_details['amb_id'],
                               'incidentId'=>$inc_id,
                               'cheifComplaint' => get_cheif_complaint($inc_details['chief_complete']));

            $json_data= json_encode($json_data);

            $api_google = api_notification_app($comm_api_url,$json_data);
              $this->call_model->update_booking_details($caller_details['clr_mobile']);

    $caller_loc = $inc_details['place'];
        $caller_lat = $inc_details['lat'];
        $caller_lng = $inc_details['lng'];
        $destination_hos = $pri_hosp_name;
        $hos_lat = $pri_hosp_lat ;
        $hos_lng = $pri_hosp_lng ;
        $select_amb_API= str_replace('-','',$inc_details['amb_id']);
        //$select_amb = implode('',(explode("-",$inc_details['amb_id'])));
        $args = array(
            'LastActivityTime' => "$datetime" ,
            'JobStatus' => 'Dispatched' ,
            'onRoadStatus' =>'1' ,
            'Caller_Location' => "$caller_loc",
            'Hospital_Location' => "NA",
            'JobNo' => "$inc_id",
            'HospitalLatlong' => "$hos_lat".','."$hos_lng",
            'stateCode' => 'MP',
            'AmbulanceNo' =>"$select_amb_API",
            'CallerLatlong' =>"$caller_lat".','."$caller_lng"
        );
       // $send_API = send_API($args);
   

   

   $sr_user = $this->clg->clg_ref_id;
$select_amb = $amb_details[0][0]->amb_rto_register_no;
   





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
    //}

    if (!empty($patient)) {
        if (ucfirst($patient['first_name']) != '') {

            $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
            $last_pat_id = $last_insert_pat_id[0]->p_id + 1;
            //$last_pat_id = $this->clg->clg_id.$last_pat_id;
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
                'blood_group' => $patient['blood_gp'],
                'ptn_birth_date' => $patient['dob'],
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
    $amb_url = "http://localhost/JAEms/amb/loc/" . $inc_id;
    $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_id;
    $patient_name = $caller_details['clr_fname'];
    $doctor = $this->colleagues_model->get_user_info($EMT);
    $sms_doctor = $doctor[0]->clg_first_name;
    $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;
    $str = ltrim($sms_doctor_contact_no, '0');
    $patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];
    $patient_mobile_no = $caller_details['clr_mobile'];
    $inc_address = $inc_details['place'];
    $chief_complaint = get_cheif_complaint($incidence_details['inc_complaint']);
   if($inc_details['hos_name']!='' || $inc_details['hos_name']!='null'){
        $hospital_name = $inc_details['hos_name'];
    }else{
        $hospital_name = $inc_details['hospital_other'];
    }
    $txtMsg1 = '';
    //$txtMsg1.= "BVG\n";
   // $txtMsg1.= "Dear ".$patient_full_name."\n";
    $txtMsg1.= "Ambulance dispatched: ".$sms_amb."\n";
    $txtMsg1.= "Ambulance Contact - ".$sms_doctor_contact_no."\n" ;
    //$txtMsg1.= "TrackAmbulance- ".$amb_url."\n";
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
    $patient_name = $caller_details['clr_fname'];
        $txtMsg2 = '';
        //$txtMsg2.= "BVG\n";
        $txtMsg2.= "Patient name: ".$patient_full_name."\n"; 
        $txtMsg2.= "Address: ".$inc_address."\n";
        $txtMsg2.= "Caller No: ".$patient_mobile_no."\n";
        $txtMsg2.= "Incident id: ".$inc_id."\n";
        $txtMsg2.= "Hospital Name- ".$hospital_name."\n";
        $txtMsg2.= "Track Ambulance- ".$amb_url."\n";
        $txtMsg2.= "JAES" ;
  
    $sms_to = $sms_doctor_contact_no;
    $args = array(
        'inc_id' => $inc_id,
        'msg' => $txtMsg2,
        'mob_no' => $sms_to,
        'sms_user'=>'EMT',
    );
    $sms_data = sms_send($args);
    
    $sms_pilot_contact_no = $get_driver_no[0]->amb_pilot_mobile; 
    $sms_pilot_contact_no = ltrim($sms_pilot_contact_no, '0');


    $patient_name = $caller_details['clr_fname'];
    $txtMsg3 = '';
    //$txtMsg3.= "BVG\n";
    $txtMsg3.= "Patient name: ".$patient_full_name."\n"; 
    $txtMsg3.= "Address: ".$inc_address."\n";
    $txtMsg3.= "Caller No: ".$patient_mobile_no."\n";
    $txtMsg3.= "Incident id: ".$inc_id."\n";
    $txtMsg3.= "Hospital Name: ".$inc_id_hp."\n";
    //$txtMsg3.= "TrackAmbulance- ".$amb_url."\n";
    $txtMsg3.= "JAES" ;

    $sms_to_pilot = $sms_pilot_contact_no;
    $args = array(
        'msg' => $txtMsg3,
        'mob_no' => $sms_to_pilot,
            'sms_user'=>'Pilot',
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
              $this->call_model->update_booking_details($caller_details['clr_mobile']);

    // nuvas send API
    $caller_loc = $inc_details['place'];
    $caller_lat = $inc_details['lat'];
    $caller_lng = $inc_details['lng'];
    $destination_hos = $pri_hosp_name ;
    $hos_lat = $pri_hosp_lat ;
    $hos_lng = $pri_hosp_lng ;
    $select_amb_API= str_replace('-','',$inc_details['amb_id']);
   // $select_amb = implode('',(explode("-",$inc_details['amb_id'])));
    $args = array(
        'LastActivityTime' => "$datetime" ,
        'JobStatus' => 'Dispatched' ,
        'onRoadStatus' =>'1' ,
        'Caller_Location' => "$caller_loc",
        'Hospital_Location' => "NA",
        'JobNo' => "$inc_id",
        'HospitalLatlong' => "NA",
        'stateCode' => 'MP',
        'AmbulanceNo' =>"$select_amb_API",
        'CallerLatlong' =>"$caller_lat".','."$caller_lng"
    );
    $send_API = send_API($args);
    
//}

 


    $this->output->status = 1;



    $this->output->closepopup = "yes";



    ($call_type['cl_type'] == 'forword') ? $msg = "forworded" : $msg = "Added";


    if($inc_data){
        $url = base_url("calls");
    $this->output->message = "<h3>Non-MCI Call</h3><br><p>Ambulance Dispatch Successfully</p><script>window.location.href = '".$url."';</script>";



    $this->output->moveto = 'top';



    $this->output->add_to_position('', 'content', TRUE);
    
    }else{
           $this->output->message = "<h3>Non-MCI Call</h3><br><p>Error in Ambulance Dispatch</p>";
    }
}
    function save_terminate_onscenecare() {

        $call_type = $this->input->get();
        $inc_details = $this->input->get_post('incient');
        $call_id = $this->input->get_post('call_id');
        $caller_details = $this->session->userdata('caller_details');
        $inc_details = $this->session->userdata('incient');
        $inc_post_details = $this->session->userdata('inc_post_details');
        $patient= $this->session->userdata('patient');
        $cl_type = $this->input->get_post('cl_type');
        
        
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
            $inc_post_details['incient_state'] = "MP";
        }
        $date = str_replace('-', '', date('Y-m-d'));

        //$inc_id = $date.$call_id;
        $inc_id = $this->session->userdata('inc_ref_id');




        $sr_user = $this->clg->clg_ref_id;

        $sms_amb_details = $inc_details['amb_id'];
        
        if($call_type != 'terminate'  && $call_type != 'transfer_108' && $call_type != 'transfer_102' && $call_type != 'enable_dispatch'){
            if ($inc_details['amb_id'] == '' && $dup_inc == 'Yes' ) {

                $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";

                return;
            }
        }
     


        if($inc_details['inc_ref_id'] != ""){
            if ($dup_inc == 'No') {
            $amb_count =0;
            $inc_re_id = $inc_id;
            if ($inc_details['amb_id']) {
                foreach ($inc_details['amb_id'] as $key=>$select_amb) {
                $amb_count++;
                $inc_re_id = $inc_details['inc_ref_id'];

                
                $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_type' => $inc_details['inc_type'],
               // 'inc_back_hospital' => $inter_details['facility'],
                //'current_district' => $inter_details['current_district'],
                //'inc_back_home_address' => $inc_details['home_address'],
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
                'inc_district_id' => $inc_post_details['incient_districts'],
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
                //'inc_set_amb' => '1',
                'inc_recive_time' => $inc_details['inc_recive_time'],
                'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
                'inc_added_by' => $this->clg->clg_ref_id,
                'inc_wht_three_wrd' => $inc_details['3word'],
            'bk_inc_ref_id' => $inc_id,
            'inc_thirdparty' => $this->clg->thirdparty,
                'inc_system_type' => $system  
            );
                
        
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
        

                $inc_details['amb_id'] = $select_amb;
                $EMT = "";
                $pilot = '';        
                $emp_inc_data = $this->inc_model->get_amb_emp($inc_details['amb_id'], $sft_id);

                if (empty($emp_inc_data)) {
                    $tm_team_date = date('Y-m-d');
                    $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);
                  

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
               // var_dump($inc_details['amb_id']);
               // die();
                if($inc_details['amb_id']){
                    $incidence_amb_details = array('amb_rto_register_no' => $inc_details['amb_id'],
                        'inc_ref_id' => $inc_re_id,
                        'amb_pilot_id' => $pilot,
                        'amb_emt_id' => $EMT,
                        'inc_base_month' => $this->post['base_month'],
                        'assigned_time' => $datetime);
                    $this->inc_model->insert_inc_amb($incidence_amb_details);
                }

                if($pilot != ''){
                    $args_operator1 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $pilot,
                        'operator_type' => 'UG-PILOT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'on_scene_care',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator1 = $this->common_model->assign_operator($args_operator1);
                }

                if($EMT != ''){
                    $args_operator2 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $EMT,
                        'operator_type' => 'UG-EMT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'on_scene_care',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator2 = $this->common_model->assign_operator($args_operator2);
                }

                
                $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);

                $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
                
                 $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                if ($inc_details['chief_complete_other'] != '') {
                    $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                
                if($cl_type == 'enable_dispatch'){

                    $item_key= $inc_details['enable_standard_summary'];

                     foreach ($item_key as $key=>$enable_standard_summary) {

                         $enable_data = array(
                             'inc_ref_id' => $inc_re_id,
                             'enable_remark' => $enable_standard_summary,
                             'amb_reg_no' => $inc_details['enable_ambulance'][$key],
                             'added_date' => $datetime,
                             'added_by' => $this->clg->clg_ref_id,
                         );
                         $enable = $this->inc_model->insert_inc_enable_dispatch($enable_data);
                     }
                 }
                

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
                         'ptn_birth_date' => $patient['dob'],
                         'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                    $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }
                
                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "on_scene_care",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                
            }
            }else if ($inc_details['stand_amb_id']) {

                foreach ($inc_details['stand_amb_id'] as $key=>$stand_amb_id) {
                    
                    
                $inc_re_id = $inc_details['inc_ref_id'];
                $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_type' => $inc_details['inc_type'],
                //'inc_back_hospital' => $inter_details['facility'],
                //'current_district' => $inter_details['current_district'],
               // 'inc_back_home_address' => $inc_details['home_address'],
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
                'inc_district_id' => $inc_post_details['incient_districts'],
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
                        $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);

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

                   if($inc_details['stand_amb_id']){
                        $incidence_amb_details = array('amb_rto_register_no' => $inc_details['stand_amb_id'],
                        'inc_ref_id' => $inc_re_id,
                        'amb_pilot_id' => $pilot,
                        'amb_emt_id' => $EMT,
                        'amb_type'=> 'standby',
                        'inc_base_month' => $this->post['base_month'],
                        'assigned_time' => $datetime);

                        $this->inc_model->insert_inc_amb($incidence_amb_details);
                    }
                    
                    if($pilot != ''){
                    
                        $args_operator1 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $pilot,
                            'operator_type' => 'UG-PILOT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'on_scene_care',
                            'base_month' => $this->post['base_month']
                        );
                        $args_operator1 = $this->common_model->assign_operator($args_operator1);
                    }

                    if($EMT != ''){
                        $args_operator2 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $EMT,
                            'operator_type' => 'UG-EMT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'on_scene_care',
                            'base_month' => $this->post['base_month']
                        );

                        $args_operator2 = $this->common_model->assign_operator($args_operator2);
                    }
                    
                
                    $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                    if ($inc_details['chief_complete_other'] != '') {
                        $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                    }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                if($cl_type == 'enable_dispatch'){

                    $item_key= $inc_details['enable_standard_summary'];

                     foreach ($item_key as $key=>$enable_standard_summary) {

                         $enable_data = array(
                             'inc_ref_id' => $inc_re_id,
                             'enable_remark' => $enable_standard_summary,
                             'amb_reg_no' => $inc_details['enable_ambulance'][$key],
                             'added_date' => $datetime,
                             'added_by' => $this->clg->clg_ref_id,
                         );
                         $enable = $this->inc_model->insert_inc_enable_dispatch($enable_data);
                     }
                 }
                

                $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
                $last_pat_id = $last_insert_pat_id[0]->p_id + 1;
               // $last_pat_id = $this->clg->clg_id.'_'.$last_pat_id;
               $last_pat_id = generate_ptn_id();

                    $incidence_patient_details = array('ptn_fname' => ucfirst($patient['first_name']),
                        'ptn_mname' => ucfirst($patient['middle_name']),
                        'ptn_lname' => ucfirst($patient['last_name']),
                        'ptn_gender' => $patient['gender'],
                        'ptn_fullname' => ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']),
                        'ptn_age' => $patient['age'],
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                        'ptn_mob_no' => $patient['ptn_mob_no'],
                        'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                         'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }

                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "on_scene_care",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                }
            }
        }

        //update_102_inc_ref_id($inc_id);
        $call_history_id = $this->session->userdata('call_history_id');
			
		_ucd_dispatch_call($inc_details['inc_ref_id'],$this->clg->clg_ref_id,$call_history_id);


        /* send sms to patient  */
        $sms_amb = $inc_details['amb_id'];
        $get_mobile_no = array('rg_no' => $sms_amb);
        $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);
        $driver = $this->colleagues_model->get_user_info($pilot);
        $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;
        $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;

        //$inc_id = $inc_id;
        $amb_url = base_url() . "amb/loc/" . $inc_re_id;
        $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_re_id;

        //$amb_url = "http://210.212.165.123/tdd/amb/loc/" . $inc_id;
        //$amb_dir_url = "http://210.212.165.123/tdd/amb/amb_dir/" . $inc_id;



        $doctor = $this->colleagues_model->get_user_info($EMT);
        $sms_doctor = $doctor[0]->clg_first_name;
        $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;
        $patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];
        $patient_mobile_no = $caller_details['clr_mobile'];
        //$patient_mobile_no = "9730015484";
        $patient_name = $caller_details['clr_fname'];

        $patient_sms_text = "Ambulance dispatched: $sms_amb\n Ambulance Contact - $sms_doctor_contact_no\n Track Link- $amb_url\nJAES";


        $patient_sms_to = $caller_details['clr_mobile'];
        //$patient_sms_to =  "8551995260";
        $send_dr_sms = $this->_send_sms($patient_sms_to, $patient_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_re_id,
            'sms_usertype' => 'Caller',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);



        /* send sms to doctor  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];

        if ($get_driver_no[0]->amb_user_type == 'tdd') {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url JAES";
        } else if ($get_driver_no[0]->amb_user_type = 'bike') {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call Bike Desk for Case ID creation. JAES";
        } else {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call 108 ERC for Case ID creation.  JAES";
        }

        $doctor_sms_to = $sms_doctor_contact_no;
        // $doctor_sms_to = '8551995260';
        $send_dr_sms = $this->_send_sms($doctor_sms_to, $doctor_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_re_id,
            'sms_usertype' => 'EMT',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);

        /* send sms to Pilot  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];

        $driver_sms_text = "Dear Pilot, Patient name: $patient_full_name,  Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id , Patient id:$last_pat_id  Navigate- $amb_dir_url JAES";

        $driver_contact_no = $sms_driver_contact_no;

        if ($call_type['cl_type'] == 'transfer_108') {

            _ucd_assign_call($inc_re_id);
        }
        
        if ($call_type['cl_type'] == 'transfer_102') {

            _ucd_102_assign_call($inc_re_id,$this->clg->clg_group);
        }
        
        $this->output->status = 1;
        $this->output->closepopup = "yes";
        ($call_type['cl_type'] == 'forword') ? $msg = "forworded" : $msg = "Added";
        
        $url = base_url("calls");
        $this->output->message = "<h3>Drop Back Call</h3><br><p>Ambulance Dispatch Successfully</p><script>window.location.href = '".$url."';</script>";
        $this->output->moveto = 'top';
        $this->output->add_to_position('', 'content', TRUE);
        }else{
        if ($dup_inc == 'No') {
            $amb_count =0;
            $inc_re_id = $inc_id;
            if($inc_details['amb_id']){
                foreach ($inc_details['amb_id'] as $key=>$select_amb) {
                $amb_count++;
                $inc_re_id = $inc_id;

                
                $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_type' => $inc_details['inc_type'],
                //'inc_back_hospital' => $inter_details['facility'],
                //'current_district' => $inter_details['current_district'],
                //'inc_back_home_address' => $inc_details['home_address'],
                'inc_ero_summary' => $inc_details['inc_ero_summary'],
                    'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
                'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
                'inc_dispatch_time' => $inc_details['caller_dis_timer'],
                // 'inc_city' => $inc_details['inc_city'],
                'inc_city_id' => $inc_post_details['incient_ms_city'],
                //'inc_state' => $inc_post_details['incient_state'],
                'inc_state_id' => $inc_post_details['incient_state'],
                'inc_address' => $inc_details['place'],
                 'inc_tahshil_id' => $inc_post_details['incient_tahsil'],
                //'inc_district' => $inc_post_details['incient_district'],
                'inc_district_id' => $inc_post_details['incient_districts'],
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
                //'inc_set_amb' => '1',
                'inc_recive_time' => $inc_details['inc_recive_time'],
                'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
                'inc_added_by' => $this->clg->clg_ref_id,
                'inc_system_type' => $system
            );
                
        
         if($cl_type == 'transfer_108'){
             
            $incidence_details['inc_set_amb'] = '0';
            $incidence_details['incis_deleted'] = '0';
             
         }else if($cl_type == 'transfer_102'){
            $incidence_details['inc_set_amb'] = '0';
            $incidence_details['incis_deleted'] = '0';
             
         }else if($cl_type == 'terminate'){
             $incidence_details['inc_set_amb'] = '1';
             $incidence_details['incis_deleted'] = '2';
             
         }else if($cl_type == 'enable_dispatch'){
             $incidence_details['inc_set_amb'] = '0';
             $incidence_details['incis_deleted'] = '3';
             
         }else{
               $incidence_details['inc_set_amb'] = '1';
               $incidence_details['incis_deleted'] = '0';
               $incidence_details['inc_system_type'] = $system;
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
            
            
                $inc_details['amb_id'] = $select_amb;
                $EMT = "";
                $pilot = '';        
                $emp_inc_data = $this->inc_model->get_amb_emp($inc_details['amb_id'], $sft_id);

                if (empty($emp_inc_data)) {
                    $tm_team_date = date('Y-m-d');
                    $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);
                  

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
            if($call_type != 'enable_dispatch'){      
                if($inc_details['amb_id']){
                    
                    $incidence_amb_details = array('amb_rto_register_no' => $inc_details['amb_id'],
                        'inc_ref_id' => $inc_re_id,
                        'amb_pilot_id' => $pilot,
                        'amb_emt_id' => $EMT,
                        'inc_base_month' => $this->post['base_month'],
                        'assigned_time' => $datetime);
                    
                    $this->inc_model->insert_inc_amb($incidence_amb_details);
                }
                    if($pilot != ''){
                    $args_operator1 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $pilot,
                        'operator_type' => 'UG-PILOT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'on_scene_care',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator1 = $this->common_model->assign_operator($args_operator1);
                }

                if($EMT != ''){
                    $args_operator2 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $EMT,
                        'operator_type' => 'UG-EMT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'on_scene_care',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator2 = $this->common_model->assign_operator($args_operator2);
                }

                
                $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);

                $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
                
            }
                
                 $drop_back = array(
                'home_city_id' => $inc_post_details['incient_ms_city'],
                'home_state_id' => $inc_post_details['incient_state'],
                'home_address' => $inc_details['place'],
                //'home_tahsil_id' => $inc_post_details['incient_district'],
                'home_district_id' => $inc_post_details['incient_districts'],
                'home_location' => $inc_details['area'],
                'home_landmark' => $inc_details['landmark'],
                'home_lane' => $inc_details['lane'],
                'home_houseno' => $inc_details['h_no'],
                'home_pin' => $inc_details['pincode'],
                'inc_ref_id'=>$inc_re_id);
            
               $drop_back_data = $this->inc_model->insert_dropback($drop_back);

            
                
                 $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                if ($inc_details['chief_complete_other'] != '') {
                    $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                
                if($cl_type == 'enable_dispatch'){

                    $item_key= $inc_details['enable_standard_summary'];

                     foreach ($item_key as $key=>$enable_standard_summary) {

                         $enable_data = array(
                             'inc_ref_id' => $inc_re_id,
                             'enable_remark' => $enable_standard_summary,
                             'amb_reg_no' => $inc_details['enable_ambulance'][$key],
                             'added_date' => $datetime,
                             'added_by' => $this->clg->clg_ref_id,
                         );
                         $enable = $this->inc_model->insert_inc_enable_dispatch($enable_data);
                     }
                 }
                
                $drop_back = array(
                                    'home_city_id' => $inc_post_details['incient_ms_city'],
                                    'home_state_id' => $inc_post_details['incient_state'],
                                    'home_address' => $inc_details['place'],
                                    //'home_tahsil_id' => $inc_post_details['incient_district'],
                                    'home_district_id' => $inc_post_details['incient_district'],
                                    'home_location' => $inc_details['area'],
                                    'home_landmark' => $inc_details['landmark'],
                                    'home_lane' => $inc_details['lane'],
                                    'home_houseno' => $inc_details['h_no'],
                                    'home_pin' => $inc_details['pincode'],
                                    'inc_ref_id'=>$inc_re_id);
            
                        $drop_back_data = $this->inc_model->insert_dropback($drop_back);


                $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
                $last_pat_id = $last_insert_pat_id[0]->p_id + 1;
               // $last_pat_id = $this->clg->clg_id.'_'.$last_pat_id;
                 $last_pat_id = generate_ptn_id();

                $incidence_patient_details = array('ptn_fname' => ucfirst($patient['first_name']),
                        'ptn_mname' => ucfirst($patient['middle_name']),
                        'ptn_lname' => ucfirst($patient['last_name']),
                        'ptn_gender' => $patient['gender'],
                        'ptn_fullname' => ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']),
                        'ptn_age' => $patient['age'],
                         'ptn_birth_date' => $patient['dob'],
                         'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                     'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                    $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }
                
                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "on_scene_care",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                
            }
            }else if($inc_details['stand_amb_id']) {

                foreach ($inc_details['stand_amb_id'] as $key=>$stand_amb_id) {
                    
                    
                $inc_re_id = $inc_id;
                $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_type' => $inc_details['inc_type'],
                //'inc_back_hospital' => $inter_details['facility'],
                //'current_district' => $inter_details['current_district'],
                //'inc_back_home_address' => $inc_details['home_address'],
                'inc_ero_summary' => $inc_details['inc_ero_summary'],
                    'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
                'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
                'inc_dispatch_time' => $inc_details['caller_dis_timer'],
                // 'inc_city' => $inc_details['inc_city'],
                'inc_city_id' => $inc_post_details['incient_ms_city'],
                //'inc_state' => $inc_post_details['incient_state'],
                'inc_state_id' => $inc_post_details['incient_state'],
                'inc_address' => $inc_details['place'],
                 'inc_tahshil_id' => $inc_post_details['incient_tahsil'],
                //'inc_district' => $inc_post_details['incient_district'],
                'inc_district_id' => $inc_post_details['incient_districts'],
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
                        $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);

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

                    if($call_type != 'enable_dispatch'){
                        if($inc_details['stand_amb_id']){
                            $incidence_amb_details = array('amb_rto_register_no' => $inc_details['stand_amb_id'],
                                'inc_ref_id' => $inc_re_id,
                                'amb_pilot_id' => $pilot,
                                'amb_emt_id' => $EMT,
                                'amb_type'=> 'standby',
                                'inc_base_month' => $this->post['base_month'],
                                'assigned_time' => $datetime);

                            $this->inc_model->insert_inc_amb($incidence_amb_details);
                        }

                        if($pilot != ''){

                            $args_operator1 = array(
                                'sub_id' => $inc_re_id,
                                'operator_id' => $pilot,
                                'operator_type' => 'UG-PILOT',
                                'sub_status' => 'ASG',
                                'sub_type' => 'on_scene_care',
                                'base_month' => $this->post['base_month']
                            );
                            $args_operator1 = $this->common_model->assign_operator($args_operator1);
                        }

                        if($EMT != ''){
                            $args_operator2 = array(
                                'sub_id' => $inc_re_id,
                                'operator_id' => $EMT,
                                'operator_type' => 'UG-EMT',
                                'sub_status' => 'ASG',
                                'sub_type' => 'on_scene_care',
                                'base_month' => $this->post['base_month']
                            );

                            $args_operator2 = $this->common_model->assign_operator($args_operator2);
                        }
                    }
                    
                
                    $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                    if ($inc_details['chief_complete_other'] != '') {
                        $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                    }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                if($cl_type == 'enable_dispatch'){

                    $item_key= $inc_details['enable_standard_summary'];

                     foreach ($item_key as $key=>$enable_standard_summary) {

                         $enable_data = array(
                             'inc_ref_id' => $inc_re_id,
                             'enable_remark' => $enable_standard_summary,
                             'amb_reg_no' => $inc_details['enable_ambulance'][$key],
                             'added_date' => $datetime,
                             'added_by' => $this->clg->clg_ref_id,
                         );
                         $enable = $this->inc_model->insert_inc_enable_dispatch($enable_data);
                     }
                 }
                

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
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                         'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }

                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "on_scene_care",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                }
            }else{
                    
                    
                $inc_re_id = $inc_id;
                $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_type' => $inc_details['inc_type'],
                //'inc_back_hospital' => $inc_details['new_facility'],
                //'inc_back_home_address' => $inc_details['home_address'],
                'inc_ero_summary' => $inc_details['inc_ero_summary'],
                    'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
                'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
                'inc_dispatch_time' => $inc_details['caller_dis_timer'],
                // 'inc_city' => $inc_details['inc_city'],
                'inc_city_id' => $inc_post_details['incient_ms_city'],
                //'inc_state' => $inc_post_details['incient_state'],
                'inc_state_id' => $inc_post_details['incient_state'],
                'inc_address' => $inc_details['place'],
                 'inc_tahshil_id' => $inc_post_details['incient_tahsil'],
                //'inc_district' => $inc_post_details['incient_district'],
                'inc_district_id' => $inc_post_details['incient_districts'],
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
                
        if($cl_type == 'transfer_108'){
             
            $incidence_details['inc_set_amb'] = '0';
            $incidence_details['incis_deleted'] = '0';
             
        }else if($cl_type == 'transfer_102'){
            $incidence_details['inc_set_amb'] = '0';
            $incidence_details['incis_deleted'] = '0';
             
        }else if($cl_type == 'terminate'){
             $incidence_details['inc_set_amb'] = '1';
             $incidence_details['incis_deleted'] = '2';
             
        }else if($cl_type == 'enable_dispatch'){
             $incidence_details['inc_set_amb'] = '0';
             $incidence_details['incis_deleted'] = '3';
             
        }else{
               $incidence_details['inc_set_amb'] = '1';
               $incidence_details['incis_deleted'] = '0';
               $incidence_details['inc_system_type'] = $system;
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
                        $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);

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

                    if($cl_type == 'enable_dispatch'){
                        if($inc_details['stand_amb_id']){
                            $incidence_amb_details = array('amb_rto_register_no' => $inc_details['stand_amb_id'],
                                'inc_ref_id' => $inc_re_id,
                                'amb_pilot_id' => $pilot,
                                'amb_emt_id' => $EMT,
                                'amb_type'=> 'standby',
                                'inc_base_month' => $this->post['base_month'],
                                'assigned_time' => $datetime);

                            $this->inc_model->insert_inc_amb($incidence_amb_details);
                        }

                        if($pilot != ''){

                            $args_operator1 = array(
                                'sub_id' => $inc_re_id,
                                'operator_id' => $pilot,
                                'operator_type' => 'UG-PILOT',
                                'sub_status' => 'ASG',
                                'sub_type' => 'on_scene_care',
                                'base_month' => $this->post['base_month']
                            );
                            $args_operator1 = $this->common_model->assign_operator($args_operator1);
                        }

                        if($EMT != ''){
                            $args_operator2 = array(
                                'sub_id' => $inc_re_id,
                                'operator_id' => $EMT,
                                'operator_type' => 'UG-EMT',
                                'sub_status' => 'ASG',
                                'sub_type' => 'on_scene_care',
                                'base_month' => $this->post['base_month']
                            );

                            $args_operator2 = $this->common_model->assign_operator($args_operator2);
                        }
                    }
                    
                
                    $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                    if ($inc_details['chief_complete_other'] != '') {
                        $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                    }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                if($cl_type == 'enable_dispatch'){

               $item_key= $inc_details['enable_standard_summary'];
            
                foreach ($item_key as $key=>$enable_standard_summary) {

                    $enable_data = array(
                        'inc_ref_id' => $inc_re_id,
                        'enable_remark' => $enable_standard_summary,
                        'amb_reg_no' => $inc_details['enable_ambulance'][$key],
                        'added_date' => $datetime,
                        'added_by' => $this->clg->clg_ref_id,
                    );
                    $enable = $this->inc_model->insert_inc_enable_dispatch($enable_data);
                }
            }
                

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
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id, 
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }

                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "on_scene_care",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
            
            }
            
        }

        //update_102_inc_ref_id($inc_id);


        /* send sms to patient  */
        $sms_amb = $inc_details['amb_id'];
        $get_mobile_no = array('rg_no' => $sms_amb);
        $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);
        $driver = $this->colleagues_model->get_user_info($pilot);
        $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;
        $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;

        //$inc_id = $inc_id;
        $amb_url = base_url() . "amb/loc/" . $inc_re_id;
        $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_re_id;

        //$amb_url = "http://210.212.165.123/tdd/amb/loc/" . $inc_id;
        //$amb_dir_url = "http://210.212.165.123/tdd/amb/amb_dir/" . $inc_id;



        $doctor = $this->colleagues_model->get_user_info($EMT);
        $sms_doctor = $doctor[0]->clg_first_name;
        $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;
        $patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];
        $patient_mobile_no = $caller_details['clr_mobile'];
        //$patient_mobile_no = "9730015484";
        $patient_name = $caller_details['clr_fname'];

        $patient_sms_text = "Ambulance dispatched: $sms_amb\n Ambulance Contact - $sms_doctor_contact_no\n Track Link- $amb_url\nJAES";


        $patient_sms_to = $caller_details['clr_mobile'];
        //$patient_sms_to =  "8551995260";
        $send_dr_sms = $this->_send_sms($patient_sms_to, $patient_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_re_id,
            'sms_usertype' => 'Caller',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);



        /* send sms to doctor  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];

        if ($get_driver_no[0]->amb_user_type == 'tdd') {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url JAES";
        } else if ($get_driver_no[0]->amb_user_type = 'bike') {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call Bike Desk for Case ID creation. JAES";
        } else {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call 108 ERC for Case ID creation.  JAES";
        }

        $doctor_sms_to = $sms_doctor_contact_no;
        // $doctor_sms_to = '8551995260';
        $send_dr_sms = $this->_send_sms($doctor_sms_to, $doctor_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_re_id,
            'sms_usertype' => 'EMT',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);

        /* send sms to Pilot  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];

        $driver_sms_text = "Dear Pilot, Patient name: $patient_full_name,  Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id , Patient id:$last_pat_id  Navigate- $amb_dir_url JAES";

        $driver_contact_no = $sms_driver_contact_no;

        if ($call_type['cl_type'] == 'transfer_108') {

            _ucd_assign_call($inc_re_id);
        }
        
        if ($call_type['cl_type'] == 'transfer_102') {

           _ucd_102_assign_call($inc_re_id,$this->clg->clg_group);
        }
        
        $this->output->status = 1;
        $this->output->closepopup = "yes";
        ($call_type['cl_type'] == 'forword') ? $msg = "forworded" : $msg = "Added";
        $url = base_url("calls");
        $this->output->message = "<h3>On Scene Care Call</h3><br><p>Ambulance Dispatch Successfully</p><script> window.location.href = '".$url."';</script>";
        $this->output->moveto = 'top';
        $this->output->add_to_position('', 'content', TRUE);
        }
}
    function save_terminate_childcare() {

        $call_type = $this->input->get();
        $inc_details = $this->input->get_post('incient');
        $call_id = $this->input->get_post('call_id');
        $caller_details = $this->session->userdata('caller_details');
        $inc_details = $this->session->userdata('incient');
        $inc_post_details = $this->session->userdata('inc_post_details');
        $patient= $this->session->userdata('patient');
        $cl_type = $this->input->get_post('cl_type');
        
        
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
            $inc_post_details['incient_state'] = "MP";
        }
        $date = str_replace('-', '', date('Y-m-d'));

        //$inc_id = $date.$call_id;
        $inc_id = $this->session->userdata('inc_ref_id');




        $sr_user = $this->clg->clg_ref_id;

        $sms_amb_details = $inc_details['amb_id'];
        
        if($call_type != 'terminate'  && $call_type != 'transfer_108' && $call_type != 'transfer_102' && $call_type != 'enable_dispatch'){
            if ($inc_details['amb_id'] == '' && $dup_inc == 'Yes' ) {

                $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";

                return;
            }
        }
     


        if($inc_details['inc_ref_id'] != ""){
            if ($dup_inc == 'No') {
            $amb_count =0;
            $inc_re_id = $inc_id;
            if ($inc_details['amb_id']) {
                foreach ($inc_details['amb_id'] as $key=>$select_amb) {
                $amb_count++;
                $inc_re_id = $inc_details['inc_ref_id'];

                
                $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_type' => $inc_details['inc_type'],
               // 'inc_back_hospital' => $inter_details['facility'],
                //'current_district' => $inter_details['current_district'],
                //'inc_back_home_address' => $inc_details['home_address'],
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
                'inc_district_id' => $inc_post_details['incient_districts'],
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
                //'inc_set_amb' => '1',
                'inc_recive_time' => $inc_details['inc_recive_time'],
                'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
                'inc_added_by' => $this->clg->clg_ref_id,
                'inc_wht_three_wrd' => $inc_details['3word'],
            'bk_inc_ref_id' => $inc_id,
            'inc_thirdparty' => $this->clg->thirdparty,
                'inc_system_type' => $system  
            );
                
        
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
        

                $inc_details['amb_id'] = $select_amb;
                $EMT = "";
                $pilot = '';        
                $emp_inc_data = $this->inc_model->get_amb_emp($inc_details['amb_id'], $sft_id);

                if (empty($emp_inc_data)) {
                    $tm_team_date = date('Y-m-d');
                    $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);
                  

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
               // var_dump($inc_details['amb_id']);
               // die();
                if($inc_details['amb_id']){
                    $incidence_amb_details = array('amb_rto_register_no' => $inc_details['amb_id'],
                        'inc_ref_id' => $inc_re_id,
                        'amb_pilot_id' => $pilot,
                        'amb_emt_id' => $EMT,
                        'inc_base_month' => $this->post['base_month'],
                        'assigned_time' => $datetime);
                    $this->inc_model->insert_inc_amb($incidence_amb_details);
                }

                if($pilot != ''){
                    $args_operator1 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $pilot,
                        'operator_type' => 'UG-PILOT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'Child_CARE_CALL',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator1 = $this->common_model->assign_operator($args_operator1);
                }

                if($EMT != ''){
                    $args_operator2 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $EMT,
                        'operator_type' => 'UG-EMT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'Child_CARE_CALL',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator2 = $this->common_model->assign_operator($args_operator2);
                }

                
                $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);

                $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
                
                 $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                if ($inc_details['chief_complete_other'] != '') {
                    $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                
                if($cl_type == 'enable_dispatch'){

                    $item_key= $inc_details['enable_standard_summary'];

                     foreach ($item_key as $key=>$enable_standard_summary) {

                         $enable_data = array(
                             'inc_ref_id' => $inc_re_id,
                             'enable_remark' => $enable_standard_summary,
                             'amb_reg_no' => $inc_details['enable_ambulance'][$key],
                             'added_date' => $datetime,
                             'added_by' => $this->clg->clg_ref_id,
                         );
                         $enable = $this->inc_model->insert_inc_enable_dispatch($enable_data);
                     }
                 }
                

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
                         'ptn_birth_date' => $patient['dob'],
                         'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                     'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                    $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }
                
                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "Child_CARE_CALL",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                
            }
            }else if ($inc_details['stand_amb_id']) {

                foreach ($inc_details['stand_amb_id'] as $key=>$stand_amb_id) {
                    
                    
                $inc_re_id = $inc_details['inc_ref_id'];
                $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_type' => $inc_details['inc_type'],
                //'inc_back_hospital' => $inter_details['facility'],
                //'current_district' => $inter_details['current_district'],
               // 'inc_back_home_address' => $inc_details['home_address'],
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
                'inc_district_id' => $inc_post_details['incient_districts'],
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
                        $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);

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

                   if($inc_details['stand_amb_id']){
                        $incidence_amb_details = array('amb_rto_register_no' => $inc_details['stand_amb_id'],
                        'inc_ref_id' => $inc_re_id,
                        'amb_pilot_id' => $pilot,
                        'amb_emt_id' => $EMT,
                        'amb_type'=> 'standby',
                        'inc_base_month' => $this->post['base_month'],
                        'assigned_time' => $datetime);

                        $this->inc_model->insert_inc_amb($incidence_amb_details);
                    }
                    
                    if($pilot != ''){
                    
                        $args_operator1 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $pilot,
                            'operator_type' => 'UG-PILOT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'Child_CARE_CALL',
                            'base_month' => $this->post['base_month']
                        );
                        $args_operator1 = $this->common_model->assign_operator($args_operator1);
                    }

                    if($EMT != ''){
                        $args_operator2 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $EMT,
                            'operator_type' => 'UG-EMT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'Child_CARE_CALL',
                            'base_month' => $this->post['base_month']
                        );

                        $args_operator2 = $this->common_model->assign_operator($args_operator2);
                    }
                    
                
                    $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                    if ($inc_details['chief_complete_other'] != '') {
                        $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                    }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                if($cl_type == 'enable_dispatch'){

                    $item_key= $inc_details['enable_standard_summary'];

                     foreach ($item_key as $key=>$enable_standard_summary) {

                         $enable_data = array(
                             'inc_ref_id' => $inc_re_id,
                             'enable_remark' => $enable_standard_summary,
                             'amb_reg_no' => $inc_details['enable_ambulance'][$key],
                             'added_date' => $datetime,
                             'added_by' => $this->clg->clg_ref_id,
                         );
                         $enable = $this->inc_model->insert_inc_enable_dispatch($enable_data);
                     }
                 }
                

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
                         'ptn_birth_date' => $patient['dob'],
                         'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                         'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }

                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "Child_CARE_CALL",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                }
            }
        }

        //update_102_inc_ref_id($inc_id);
        $call_history_id = $this->session->userdata('call_history_id');
			
		_ucd_dispatch_call($inc_details['inc_ref_id'],$this->clg->clg_ref_id,$call_history_id);


        /* send sms to patient  */
        $sms_amb = $inc_details['amb_id'];
        $get_mobile_no = array('rg_no' => $sms_amb);
        $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);
        $driver = $this->colleagues_model->get_user_info($pilot);
        $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;
        $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;

        //$inc_id = $inc_id;
        $amb_url = base_url() . "amb/loc/" . $inc_re_id;
        $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_re_id;

        //$amb_url = "http://210.212.165.123/tdd/amb/loc/" . $inc_id;
        //$amb_dir_url = "http://210.212.165.123/tdd/amb/amb_dir/" . $inc_id;



        $doctor = $this->colleagues_model->get_user_info($EMT);
        $sms_doctor = $doctor[0]->clg_first_name;
        $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;
        $patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];
        $patient_mobile_no = $caller_details['clr_mobile'];
        //$patient_mobile_no = "9730015484";
        $patient_name = $caller_details['clr_fname'];

        $patient_sms_text = "Ambulance dispatched: $sms_amb\n Ambulance Contact - $sms_doctor_contact_no\n Track Link- $amb_url\nJAES";


        $patient_sms_to = $caller_details['clr_mobile'];
        //$patient_sms_to =  "8551995260";
        $send_dr_sms = $this->_send_sms($patient_sms_to, $patient_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_re_id,
            'sms_usertype' => 'Caller',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);



        /* send sms to doctor  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];

        if ($get_driver_no[0]->amb_user_type == 'tdd') {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url JAES";
        } else if ($get_driver_no[0]->amb_user_type = 'bike') {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call Bike Desk for Case ID creation. JAES";
        } else {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call 108 ERC for Case ID creation.  JAES";
        }

        $doctor_sms_to = $sms_doctor_contact_no;
        // $doctor_sms_to = '8551995260';
        $send_dr_sms = $this->_send_sms($doctor_sms_to, $doctor_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_re_id,
            'sms_usertype' => 'EMT',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);

        /* send sms to Pilot  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];

        $driver_sms_text = "Dear Pilot, Patient name: $patient_full_name,  Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id , Patient id:$last_pat_id  Navigate- $amb_dir_url JAES";

        $driver_contact_no = $sms_driver_contact_no;

        if ($call_type['cl_type'] == 'transfer_108') {

            _ucd_assign_call($inc_re_id);
        }
        
        if ($call_type['cl_type'] == 'transfer_102') {

            _ucd_102_assign_call($inc_re_id,$this->clg->clg_group);
        }
        
        $this->output->status = 1;
        $this->output->closepopup = "yes";
        ($call_type['cl_type'] == 'forword') ? $msg = "forworded" : $msg = "Added";
        $url = base_url("calls");
        $this->output->message = "<h3>Drop Back Call</h3><br><p>Ambulance Dispatch Successfully</p><script>window.location.href = '".$url."';</script>";
        $this->output->moveto = 'top';
        $this->output->add_to_position('', 'content', TRUE);
        }else{
        if ($dup_inc == 'No') {
            $amb_count =0;
            $inc_re_id = $inc_id;
            if($inc_details['amb_id']){
                foreach ($inc_details['amb_id'] as $key=>$select_amb) {
                $amb_count++;
                $inc_re_id = $inc_id.'-'.$amb_count;

                
                $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_type' => $inc_details['inc_type'],
                //'inc_back_hospital' => $inter_details['facility'],
                //'current_district' => $inter_details['current_district'],
                //'inc_back_home_address' => $inc_details['home_address'],
                'inc_ero_summary' => $inc_details['inc_ero_summary'],
                    'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
                'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
                'inc_dispatch_time' => $inc_details['caller_dis_timer'],
                // 'inc_city' => $inc_details['inc_city'],
                'inc_city_id' => $inc_post_details['incient_ms_city'],
                //'inc_state' => $inc_post_details['incient_state'],
                'inc_state_id' => $inc_post_details['incient_state'],
                'inc_address' => $inc_details['place'],
                 'inc_tahshil_id' => $inc_post_details['incient_tahsil'],
                //'inc_district' => $inc_post_details['incient_district'],
                'inc_district_id' => $inc_post_details['incient_districts'],
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
                //'inc_set_amb' => '1',
                'inc_recive_time' => $inc_details['inc_recive_time'],
                'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
                'inc_added_by' => $this->clg->clg_ref_id,
                'inc_system_type' => $system
            );
                
        
         if($cl_type == 'transfer_108'){
             
            $incidence_details['inc_set_amb'] = '0';
            $incidence_details['incis_deleted'] = '0';
             
         }else if($cl_type == 'transfer_102'){
            $incidence_details['inc_set_amb'] = '0';
            $incidence_details['incis_deleted'] = '0';
             
         }else if($cl_type == 'terminate'){
             $incidence_details['inc_set_amb'] = '1';
             $incidence_details['incis_deleted'] = '2';
             
         }else if($cl_type == 'enable_dispatch'){
             $incidence_details['inc_set_amb'] = '0';
             $incidence_details['incis_deleted'] = '3';
             
         }else{
               $incidence_details['inc_set_amb'] = '1';
               $incidence_details['incis_deleted'] = '0';
               $incidence_details['inc_system_type'] = $system;
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
            
            
                $inc_details['amb_id'] = $select_amb;
                $EMT = "";
                $pilot = '';        
                $emp_inc_data = $this->inc_model->get_amb_emp($inc_details['amb_id'], $sft_id);

                if (empty($emp_inc_data)) {
                    $tm_team_date = date('Y-m-d');
                    $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);
                  

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
            if($call_type != 'enable_dispatch'){      
                if($inc_details['amb_id']){
                    
                    $incidence_amb_details = array('amb_rto_register_no' => $inc_details['amb_id'],
                        'inc_ref_id' => $inc_re_id,
                        'amb_pilot_id' => $pilot,
                        'amb_emt_id' => $EMT,
                        'inc_base_month' => $this->post['base_month'],
                        'assigned_time' => $datetime);
                    
                    $this->inc_model->insert_inc_amb($incidence_amb_details);
                }
                    if($pilot != ''){
                    $args_operator1 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $pilot,
                        'operator_type' => 'UG-PILOT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'Child_CARE_CALL',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator1 = $this->common_model->assign_operator($args_operator1);
                }

                if($EMT != ''){
                    $args_operator2 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $EMT,
                        'operator_type' => 'UG-EMT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'Child_CARE_CALL',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator2 = $this->common_model->assign_operator($args_operator2);
                }

                
                $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);

                $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
                
            }
                
                 $drop_back = array(
                'home_city_id' => $inc_post_details['incient_ms_city'],
                'home_state_id' => $inc_post_details['incient_state'],
                'home_address' => $inc_details['place'],
                //'home_tahsil_id' => $inc_post_details['incient_district'],
                'home_district_id' => $inc_post_details['incient_districts'],
                'home_location' => $inc_details['area'],
                'home_landmark' => $inc_details['landmark'],
                'home_lane' => $inc_details['lane'],
                'home_houseno' => $inc_details['h_no'],
                'home_pin' => $inc_details['pincode'],
                'inc_ref_id'=>$inc_re_id);
            
               $drop_back_data = $this->inc_model->insert_dropback($drop_back);

            
                
                 $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                if ($inc_details['chief_complete_other'] != '') {
                    $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                
                if($cl_type == 'enable_dispatch'){

                    $item_key= $inc_details['enable_standard_summary'];

                     foreach ($item_key as $key=>$enable_standard_summary) {

                         $enable_data = array(
                             'inc_ref_id' => $inc_re_id,
                             'enable_remark' => $enable_standard_summary,
                             'amb_reg_no' => $inc_details['enable_ambulance'][$key],
                             'added_date' => $datetime,
                             'added_by' => $this->clg->clg_ref_id,
                         );
                         $enable = $this->inc_model->insert_inc_enable_dispatch($enable_data);
                     }
                 }
                
                $drop_back = array(
                                    'home_city_id' => $inc_post_details['incient_ms_city'],
                                    'home_state_id' => $inc_post_details['incient_state'],
                                    'home_address' => $inc_details['place'],
                                    //'home_tahsil_id' => $inc_post_details['incient_district'],
                                    'home_district_id' => $inc_post_details['incient_district'],
                                    'home_location' => $inc_details['area'],
                                    'home_landmark' => $inc_details['landmark'],
                                    'home_lane' => $inc_details['lane'],
                                    'home_houseno' => $inc_details['h_no'],
                                    'home_pin' => $inc_details['pincode'],
                                    'inc_ref_id'=>$inc_re_id);
            
                        $drop_back_data = $this->inc_model->insert_dropback($drop_back);


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
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                    $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }
                
                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "Child_CARE_CALL",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                
            }
            }else if($inc_details['stand_amb_id']) {

                foreach ($inc_details['stand_amb_id'] as $key=>$stand_amb_id) {
                    
                    
                $inc_re_id = $inc_id.'-'.$key+1;
                $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_type' => $inc_details['inc_type'],
                //'inc_back_hospital' => $inter_details['facility'],
                //'current_district' => $inter_details['current_district'],
                //'inc_back_home_address' => $inc_details['home_address'],
                'inc_ero_summary' => $inc_details['inc_ero_summary'],
                    'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
                'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
                'inc_dispatch_time' => $inc_details['caller_dis_timer'],
                // 'inc_city' => $inc_details['inc_city'],
                'inc_city_id' => $inc_post_details['incient_ms_city'],
                //'inc_state' => $inc_post_details['incient_state'],
                'inc_state_id' => $inc_post_details['incient_state'],
                'inc_address' => $inc_details['place'],
                 'inc_tahshil_id' => $inc_post_details['incient_tahsil'],
                //'inc_district' => $inc_post_details['incient_district'],
                'inc_district_id' => $inc_post_details['incient_districts'],
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
                        $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);

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

                    if($call_type != 'enable_dispatch'){
                        if($inc_details['stand_amb_id']){
                            $incidence_amb_details = array('amb_rto_register_no' => $inc_details['stand_amb_id'],
                                'inc_ref_id' => $inc_re_id,
                                'amb_pilot_id' => $pilot,
                                'amb_emt_id' => $EMT,
                                'amb_type'=> 'standby',
                                'inc_base_month' => $this->post['base_month'],
                                'assigned_time' => $datetime);

                            $this->inc_model->insert_inc_amb($incidence_amb_details);
                        }

                        if($pilot != ''){

                            $args_operator1 = array(
                                'sub_id' => $inc_re_id,
                                'operator_id' => $pilot,
                                'operator_type' => 'UG-PILOT',
                                'sub_status' => 'ASG',
                                'sub_type' => 'Child_CARE_CALL',
                                'base_month' => $this->post['base_month']
                            );
                            $args_operator1 = $this->common_model->assign_operator($args_operator1);
                        }

                        if($EMT != ''){
                            $args_operator2 = array(
                                'sub_id' => $inc_re_id,
                                'operator_id' => $EMT,
                                'operator_type' => 'UG-EMT',
                                'sub_status' => 'ASG',
                                'sub_type' => 'Child_CARE_CALL',
                                'base_month' => $this->post['base_month']
                            );

                            $args_operator2 = $this->common_model->assign_operator($args_operator2);
                        }
                    }
                    
                
                    $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                    if ($inc_details['chief_complete_other'] != '') {
                        $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                    }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                if($cl_type == 'enable_dispatch'){

                    $item_key= $inc_details['enable_standard_summary'];

                     foreach ($item_key as $key=>$enable_standard_summary) {

                         $enable_data = array(
                             'inc_ref_id' => $inc_re_id,
                             'enable_remark' => $enable_standard_summary,
                             'amb_reg_no' => $inc_details['enable_ambulance'][$key],
                             'added_date' => $datetime,
                             'added_by' => $this->clg->clg_ref_id,
                         );
                         $enable = $this->inc_model->insert_inc_enable_dispatch($enable_data);
                     }
                 }
                

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
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }

                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "Child_CARE_CALL",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                }
            }else{
                    
                    
                $inc_re_id = $inc_id;
                $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_type' => $inc_details['inc_type'],
                //'inc_back_hospital' => $inc_details['new_facility'],
                //'inc_back_home_address' => $inc_details['home_address'],
                'inc_ero_summary' => $inc_details['inc_ero_summary'],
                    'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
                'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
                'inc_dispatch_time' => $inc_details['caller_dis_timer'],
                // 'inc_city' => $inc_details['inc_city'],
                'inc_city_id' => $inc_post_details['incient_ms_city'],
                //'inc_state' => $inc_post_details['incient_state'],
                'inc_state_id' => $inc_post_details['incient_state'],
                'inc_address' => $inc_details['place'],
                 'inc_tahshil_id' => $inc_post_details['incient_tahsil'],
                //'inc_district' => $inc_post_details['incient_district'],
                'inc_district_id' => $inc_post_details['incient_districts'],
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
                
        if($cl_type == 'transfer_108'){
             
            $incidence_details['inc_set_amb'] = '0';
            $incidence_details['incis_deleted'] = '0';
             
        }else if($cl_type == 'transfer_102'){
            $incidence_details['inc_set_amb'] = '0';
            $incidence_details['incis_deleted'] = '0';
             
        }else if($cl_type == 'terminate'){
             $incidence_details['inc_set_amb'] = '1';
             $incidence_details['incis_deleted'] = '2';
             
        }else if($cl_type == 'enable_dispatch'){
             $incidence_details['inc_set_amb'] = '0';
             $incidence_details['incis_deleted'] = '3';
             
        }else{
               $incidence_details['inc_set_amb'] = '1';
               $incidence_details['incis_deleted'] = '0';
               $incidence_details['inc_system_type'] = $system;
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
                        $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);

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

                    if($cl_type == 'enable_dispatch'){
                        if($inc_details['stand_amb_id']){
                            $incidence_amb_details = array('amb_rto_register_no' => $inc_details['stand_amb_id'],
                                'inc_ref_id' => $inc_re_id,
                                'amb_pilot_id' => $pilot,
                                'amb_emt_id' => $EMT,
                                'amb_type'=> 'standby',
                                'inc_base_month' => $this->post['base_month'],
                                'assigned_time' => $datetime);

                            $this->inc_model->insert_inc_amb($incidence_amb_details);
                        }

                        if($pilot != ''){

                            $args_operator1 = array(
                                'sub_id' => $inc_re_id,
                                'operator_id' => $pilot,
                                'operator_type' => 'UG-PILOT',
                                'sub_status' => 'ASG',
                                'sub_type' => 'Child_CARE_CALL',
                                'base_month' => $this->post['base_month']
                            );
                            $args_operator1 = $this->common_model->assign_operator($args_operator1);
                        }

                        if($EMT != ''){
                            $args_operator2 = array(
                                'sub_id' => $inc_re_id,
                                'operator_id' => $EMT,
                                'operator_type' => 'UG-EMT',
                                'sub_status' => 'ASG',
                                'sub_type' => 'Child_CARE_CALL',
                                'base_month' => $this->post['base_month']
                            );

                            $args_operator2 = $this->common_model->assign_operator($args_operator2);
                        }
                    }
                    
                
                    $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                    if ($inc_details['chief_complete_other'] != '') {
                        $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                    }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                if($cl_type == 'enable_dispatch'){

               $item_key= $inc_details['enable_standard_summary'];
            
                foreach ($item_key as $key=>$enable_standard_summary) {

                    $enable_data = array(
                        'inc_ref_id' => $inc_re_id,
                        'enable_remark' => $enable_standard_summary,
                        'amb_reg_no' => $inc_details['enable_ambulance'][$key],
                        'added_date' => $datetime,
                        'added_by' => $this->clg->clg_ref_id,
                    );
                    $enable = $this->inc_model->insert_inc_enable_dispatch($enable_data);
                }
            }
                

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
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }

                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "Child_CARE_CALL",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
            
            }
            
        }

        //update_102_inc_ref_id($inc_id);


        /* send sms to patient  */
        $sms_amb = $inc_details['amb_id'];
        $get_mobile_no = array('rg_no' => $sms_amb);
        $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);
        $driver = $this->colleagues_model->get_user_info($pilot);
        $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;
        $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;

        //$inc_id = $inc_id;
        $amb_url = base_url() . "amb/loc/" . $inc_re_id;
        $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_re_id;

        //$amb_url = "http://210.212.165.123/tdd/amb/loc/" . $inc_id;
        //$amb_dir_url = "http://210.212.165.123/tdd/amb/amb_dir/" . $inc_id;



        $doctor = $this->colleagues_model->get_user_info($EMT);
        $sms_doctor = $doctor[0]->clg_first_name;
        $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;
        $patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];
        $patient_mobile_no = $caller_details['clr_mobile'];
        //$patient_mobile_no = "9730015484";
        $patient_name = $caller_details['clr_fname'];

        $patient_sms_text = "Ambulance dispatched: $sms_amb\n Ambulance Contact - $sms_doctor_contact_no\n Track Link- $amb_url\nJAES";


        $patient_sms_to = $caller_details['clr_mobile'];
        //$patient_sms_to =  "8551995260";
        $send_dr_sms = $this->_send_sms($patient_sms_to, $patient_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_re_id,
            'sms_usertype' => 'Caller',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);



        /* send sms to doctor  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];

        if ($get_driver_no[0]->amb_user_type == 'tdd') {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url JAES";
        } else if ($get_driver_no[0]->amb_user_type = 'bike') {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call Bike Desk for Case ID creation. JAES";
        } else {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call 108 ERC for Case ID creation.  JAES";
        }

        $doctor_sms_to = $sms_doctor_contact_no;
        // $doctor_sms_to = '8551995260';
        $send_dr_sms = $this->_send_sms($doctor_sms_to, $doctor_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_re_id,
            'sms_usertype' => 'EMT',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);

        /* send sms to Pilot  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];

        $driver_sms_text = "Dear Pilot, Patient name: $patient_full_name,  Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id , Patient id:$last_pat_id  Navigate- $amb_dir_url JAES";

        $driver_contact_no = $sms_driver_contact_no;

        if ($call_type['cl_type'] == 'transfer_108') {

            _ucd_assign_call($inc_re_id);
        }
        
        if ($call_type['cl_type'] == 'transfer_102') {

           _ucd_102_assign_call($inc_re_id,$this->clg->clg_group);
        }
        
        $this->output->status = 1;
        $this->output->closepopup = "yes";
        ($call_type['cl_type'] == 'forword') ? $msg = "forworded" : $msg = "Added";
        $url = base_url("calls");
        $this->output->message = "<h3>Child Care Call</h3><br><p>Ambulance Dispatch Successfully</p><script>window.location.href = '".$url."';</script>";
        $this->output->moveto = 'top';
        $this->output->add_to_position('', 'content', TRUE);
        }
}
 
    function confirm_pregancy_save() {

        $this->session->unset_userdata('incient');
        $this->session->unset_userdata('call_type');

        $call_type = $this->input->get();
        $call_type = $this->input->get_post('call_type');
        
        $inc_post_details = $this->input->post();
        $datetime = date('Y-m-d H:i:s');

        $inc_details = $this->input->get_post('incient');
        $patient = $this->input->get_post('patient');
        $caller_details = $this->input->get_post('caller');
        
        if($inc_post_details['call_type'] == 'terminate'){
            if($inc_details['amb_id'] != ''){

                $this->output->message = "<div class='error'>Remove Ambulance Selected ambulance</div>";
                return;

            }
        }


        $dup_inc = $inc_details['dup_inc'];

        $call_id = $this->input->get_post('call_id');
        $this->session->set_userdata('mic_details', $inc_details);
        $this->session->set_userdata('incient', $inc_details);
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

        
   
        if($call_type != 'terminate'  && $call_type != 'transfer_108' && $call_type != 'transfer_102'){
           
            if ($inc_details['amb_id'] == '' && $dup_inc == 'No') {

                $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";

                return;
            }
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
            update_inc_ref_id($inc_id);
            $this->session->set_userdata('inc_ref_id', $inc_id);
        }
        $data['inc_ref_id'] = $inc_id;
        $data['patient'] = $patient;

        $data['get_amb_details'] = $get_amb_details;
        $data['inc_details'] = $inc_details;
        $data['hospital_id'] = $inc_details['hospital_id'];
        $data['hospital_other'] = $inc_details['hospital_other'];


        $data['caller_details'] = $session_caller_details;
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];

        $data['place'] = $inc_details['place'];

        $data['cl_type'] = $call_type;
        $data['inc_datetime'] = $datetime;

        $this->output->add_to_popup($this->load->view('frontend/inc/confirm_pregancy_care_view', $data, TRUE), '600', '560');

        //   $this->output->add_to_position($this->load->view('frontend/patient/pt_inc_summary_view', $data, TRUE), 'summary_div', TRUE);
    }
    
    function save_pregancy() {

        $call_type = $this->input->get();
        $inc_details = $this->input->get_post('incient');
        $call_id = $this->input->get_post('call_id');
        $caller_details = $this->session->userdata('caller_details');
        $inc_details = $this->session->userdata('mic_details');
        $inc_post_details = $this->session->userdata('inc_post_details');
        $patient= $this->session->userdata('patient');
        $cl_type = $this->input->get_post('cl_type');


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

        if($inc_details['inc_ref_id'] != ""){
        if ($dup_inc == 'No') {
            $amb_count =0;
            $inc_re_id = $inc_id;
            if($inc_details['amb_id']){
            foreach ($inc_details['amb_id'] as $key=>$select_amb) {
                $amb_count++;
                $inc_re_id = $inc_id.'-'.$amb_count;
                $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_re_id));
                if(!empty($is_exits)){
                    $this->session->set_userdata('inc_ref_id','');
                    $this->output->message = "<div class='error'>Incident Id alredy exists</div>";
                    return;
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
                //'inc_district' => $inc_post_details['incient_district'],
                'inc_district_id' => $inc_post_details['incient_districts'],
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
                //'inc_set_amb' => '1',
                'inc_recive_time' => $inc_details['inc_recive_time'],
                'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
                'inc_added_by' => $this->clg->clg_ref_id,
                'inc_wht_three_wrd' => $inc_details['3word'],
            'bk_inc_ref_id' => $inc_id,
            'inc_thirdparty' => $this->clg->thirdparty,
                'inc_system_type' => $system
            );
                
        
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
            
            
                $inc_details['amb_id'] = $select_amb;
                $EMT = "";
                $pilot = '';        
                $emp_inc_data = $this->inc_model->get_amb_emp($inc_details['amb_id'], $sft_id);

                if (empty($emp_inc_data)) {
                    $tm_team_date = date('Y-m-d');
                    $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);
                  

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
              $this->call_model->update_booking_details($caller_details['clr_mobile']);
                
                $denial_id = $this->session->userdata('denial_id');
                if($denial_id){
                    foreach($denial_id as $denial){
                        $com_args = array('inc_ref_id'=>$inc_id,'id'=>$denial);
                        $update_app_call_details = $this->Dashboard_model->update_denial($com_args);

                    } 
                }

                $caller_loc = $inc_details['place'];
        $caller_lat = $inc_details['lat'];
        $caller_lng = $inc_details['lng'];
        $destination_hos = 'Dahod Rd, near kuber water plant, Alirajpur, MP 457887';
        $hos_lat = $inc_details['lat'];
        $hos_lng = $inc_details['lng'];
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
                if($pilot != ''){
                    $args_operator1 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $pilot,
                        'operator_type' => 'UG-PILOT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'PREGANCY_CALL',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator1 = $this->common_model->assign_operator($args_operator1);
                }

                if($EMT != ''){
                    $args_operator2 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $EMT,
                        'operator_type' => 'UG-EMT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'PREGANCY_CALL',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator2 = $this->common_model->assign_operator($args_operator2);
                }

                
                $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);

                $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
                
                 $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                if ($inc_details['chief_complete_other'] != '') {
                    $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                }

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
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                     'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                    $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }

                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "PREGANCY_CALL",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                
            }
            }else if ($inc_details['stand_amb_id']) {

                foreach ($inc_details['stand_amb_id'] as $key=>$stand_amb_id) {
                    
                    
                $inc_re_id = $inc_id.'-'.$key+1;
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
                'inc_district_id' => $inc_post_details['incient_districts'],
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
                        $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);

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
                    
                    if($pilot != ''){
                    
                        $args_operator1 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $pilot,
                            'operator_type' => 'UG-PILOT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'PREGANCY_CALL',
                            'base_month' => $this->post['base_month']
                        );
                        $args_operator1 = $this->common_model->assign_operator($args_operator1);
                    }

                    if($EMT != ''){
                        $args_operator2 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $EMT,
                            'operator_type' => 'UG-EMT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'PREGANCY_CALL',
                            'base_month' => $this->post['base_month']
                        );

                        $args_operator2 = $this->common_model->assign_operator($args_operator2);
                    }
                    
                
                    $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                    if ($inc_details['chief_complete_other'] != '') {
                        $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                    }

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
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }

                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "PREGANCY_CALL",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                }
            }
        }

          //update_102_inc_ref_id($inc_id);
        $call_history_id = $this->session->userdata('call_history_id');
			
		_ucd_dispatch_call($inc_details['inc_ref_id'],$this->clg->clg_ref_id,$call_history_id);


        /* send sms to patient  */
        $sms_amb = $inc_details['amb_id'];
        $get_mobile_no = array('rg_no' => $sms_amb);
        $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);
        $driver = $this->colleagues_model->get_user_info($pilot);
        $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;
        $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;

        //$inc_id = $inc_id;
        $amb_url = base_url() . "amb/loc/" . $inc_re_id;
        $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_re_id;

        //$amb_url = "http://210.212.165.123/tdd/amb/loc/" . $inc_id;
        //$amb_dir_url = "http://210.212.165.123/tdd/amb/amb_dir/" . $inc_id;



        $doctor = $this->colleagues_model->get_user_info($EMT);
        $sms_doctor = $doctor[0]->clg_first_name;
        $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;
        $patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];
        $patient_mobile_no = $caller_details['clr_mobile'];
        //$patient_mobile_no = "9730015484";
        $patient_name = $caller_details['clr_fname'];

        $patient_sms_text = "Ambulance dispatched: $sms_amb\n Ambulance Contact - $sms_doctor_contact_no\n Track Link- $amb_url\nJAES";


        $patient_sms_to = $caller_details['clr_mobile'];
        //$patient_sms_to =  "8551995260";
        $send_dr_sms = $this->_send_sms($patient_sms_to, $patient_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_re_id,
            'sms_usertype' => 'Caller',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);



        /* send sms to doctor  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];

        if ($get_driver_no[0]->amb_user_type == 'tdd') {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url JAES";
        } else if ($get_driver_no[0]->amb_user_type = 'bike') {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call Bike Desk for Case ID creation. JAES";
        } else {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call 108 ERC for Case ID creation.  JAES";
        }

        $doctor_sms_to = $sms_doctor_contact_no;
        // $doctor_sms_to = '8551995260';
        $send_dr_sms = $this->_send_sms($doctor_sms_to, $doctor_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_re_id,
            'sms_usertype' => 'EMT',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);

        /* send sms to Pilot  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];

        $driver_sms_text = "Dear Pilot, Patient name: $patient_full_name,  Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id , Patient id:$last_pat_id  Navigate- $amb_dir_url JAES";

        $driver_contact_no = $sms_driver_contact_no;;

        if ($call_type['cl_type'] == 'transfer_108') {

            _ucd_assign_call($inc_re_id);
        }
        
        if ($call_type['cl_type'] == 'transfer_102') {

            _ucd_102_assign_call($inc_re_id,$this->clg->clg_group);
        }
        
        $this->output->status = 1;
        $this->output->closepopup = "yes";
        ($call_type['cl_type'] == 'forword') ? $msg = "forworded" : $msg = "Added";
        $url = base_url("calls");
        $this->output->message = "<h3>Pregancy Care Call</h3><br><p>Ambulance Dispatch Successfully</p><script>window.location.href = '".$url."';</script>";
        $this->output->moveto = 'top';
        $this->output->add_to_position('', 'content', TRUE);
        }else{
            if ($dup_inc == 'No') {
            $inc_re_id = $inc_id;
            $amb_count =0;
            if($inc_details['amb_id']){
                
                foreach ($inc_details['amb_id'] as $key=>$select_amb) {
                $amb_count++;
                $inc_re_id = $inc_id.'-'.$amb_count;

                
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
                'inc_district_id' => $inc_post_details['incient_districts'],
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
                //'inc_set_amb' => '1',
                'inc_recive_time' => $inc_details['inc_recive_time'],
                'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
                'inc_added_by' => $this->clg->clg_ref_id,
                 'inc_system_type' => $system
            );
                
        
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
            
            
                $inc_details['amb_id'] = $select_amb;
                $EMT = "";
                $pilot = '';        
                $emp_inc_data = $this->inc_model->get_amb_emp($inc_details['amb_id'], $sft_id);

                if (empty($emp_inc_data)) {
                    $tm_team_date = date('Y-m-d');
                    $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);
                  

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

                if($pilot != ''){
                    $args_operator1 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $pilot,
                        'operator_type' => 'UG-PILOT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'PREGANCY_CALL',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator1 = $this->common_model->assign_operator($args_operator1);
                }

                if($EMT != ''){
                    $args_operator2 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $EMT,
                        'operator_type' => 'UG-EMT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'PREGANCY_CALL',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator2 = $this->common_model->assign_operator($args_operator2);
                }

                
                $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);

                $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
                
                 $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                if ($inc_details['chief_complete_other'] != '') {
                    $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                

                $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
                $last_pat_id = $last_insert_pat_id[0]->p_id + 1;
               // $last_pat_id = $this->clg->clg_id.'_'.$last_pat_id;
                 $last_pat_id = generate_ptn_id();

                $incidence_patient_details = array('ptn_fname' => ucfirst($patient['first_name']),
                        'ptn_mname' => ucfirst($patient['middle_name']),
                        'ptn_lname' => ucfirst($patient['last_name']),
                        'ptn_gender' => $patient['gender'],
                        'ptn_fullname' => ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']),
                        'ptn_age' => $patient['age'],
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                    $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $denial_id = $this->session->userdata('denial_id');
                if($denial_id){
                    foreach($denial_id as $denial){
                        $com_args = array('inc_ref_id'=>$inc_re_id,'id'=>$denial);
                        $update_app_call_details = $this->Dashboard_model->update_denial($com_args);

                    } 
                }
                
                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }

                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "PREGANCY_CALL",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                
            }
            
            }else if ($inc_details['stand_amb_id']) {

                foreach ($inc_details['stand_amb_id'] as $key=>$stand_amb_id) {
                    
                    
                $inc_re_id = $inc_id.'-'.$key+1;
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
                        $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);

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
                    
                    if($pilot != ''){
                    
                        $args_operator1 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $pilot,
                            'operator_type' => 'UG-PILOT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'PREGANCY_CALL',
                            'base_month' => $this->post['base_month']
                        );
                        $args_operator1 = $this->common_model->assign_operator($args_operator1);
                    }

                    if($EMT != ''){
                        $args_operator2 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $EMT,
                            'operator_type' => 'UG-EMT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'PREGANCY_CALL',
                            'base_month' => $this->post['base_month']
                        );

                        $args_operator2 = $this->common_model->assign_operator($args_operator2);
                    }
                    
                
                    $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                    if ($inc_details['chief_complete_other'] != '') {
                        $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                    }

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
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }

                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "PREGANCY_CALL",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                }
            }
        }

        //update_102_inc_ref_id($inc_id);


        /* send sms to patient  */
        $sms_amb = $inc_details['amb_id'];
        $get_mobile_no = array('rg_no' => $sms_amb);
        $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);
        $driver = $this->colleagues_model->get_user_info($pilot);
        $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;
        $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;

        //$inc_id = $inc_id;
        $amb_url = base_url() . "amb/loc/" . $inc_re_id;
        $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_re_id;

        //$amb_url = "http://210.212.165.123/tdd/amb/loc/" . $inc_id;
        //$amb_dir_url = "http://210.212.165.123/tdd/amb/amb_dir/" . $inc_id;



        $doctor = $this->colleagues_model->get_user_info($EMT);
        $sms_doctor = $doctor[0]->clg_first_name;
        $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;
        $patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];
        $patient_mobile_no = $caller_details['clr_mobile'];
        //$patient_mobile_no = "9730015484";
        $patient_name = $caller_details['clr_fname'];

        $patient_sms_text = "Ambulance dispatched: $sms_amb\n Ambulance Contact - $sms_doctor_contact_no\n Track Link- $amb_url\nJAES";


        $patient_sms_to = $caller_details['clr_mobile'];
        //$patient_sms_to =  "8551995260";
        $send_dr_sms = $this->_send_sms($patient_sms_to, $patient_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_re_id,
            'sms_usertype' => 'Caller',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);



        /* send sms to doctor  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];

        if ($get_driver_no[0]->amb_user_type == 'tdd') {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url JAES";
        } else if ($get_driver_no[0]->amb_user_type = 'bike') {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call Bike Desk for Case ID creation. JAES";
        } else {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call 108 ERC for Case ID creation.  JAES";
        }

        $doctor_sms_to = $sms_doctor_contact_no;
        // $doctor_sms_to = '8551995260';
        $send_dr_sms = $this->_send_sms($doctor_sms_to, $doctor_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_re_id,
            'sms_usertype' => 'EMT',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);

        /* send sms to Pilot  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];

        $driver_sms_text = "Dear Pilot, Patient name: $patient_full_name,  Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id , Patient id:$last_pat_id  Navigate- $amb_dir_url JAES";

        $driver_contact_no = $sms_driver_contact_no;

        if ($call_type['cl_type'] == 'transfer_108') {

            _ucd_assign_call($inc_re_id);
        }
        
        if ($call_type['cl_type'] == 'transfer_102') {

            _ucd_102_assign_call($inc_re_id,$this->clg->clg_group);
        }
        
        $this->output->status = 1;
        $this->output->closepopup = "yes";
        ($call_type['cl_type'] == 'forword') ? $msg = "forworded" : $msg = "Added";
        $url = base_url("calls");
        $this->output->message = "<h3>Pregancy Care Call</h3><br><p>Ambulance Dispatch Successfully</p><script>window.location.href = '".$url."';</script>";
        $this->output->moveto = 'top';
        $this->output->add_to_position('', 'content', TRUE);
        }
    }
    
    function save_terminate_pregancy() {

        $call_type = $this->input->get();
        $inc_details = $this->input->get_post('incient');
        $call_id = $this->input->get_post('call_id');
        $caller_details = $this->session->userdata('caller_details');
        $inc_details = $this->session->userdata('incient');
        $inc_post_details = $this->session->userdata('inc_post_details');
        $patient= $this->session->userdata('patient');
        $cl_type = $this->input->get_post('cl_type');
        
        
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
            $inc_post_details['incient_state'] = "MP";
        }
        $date = str_replace('-', '', date('Y-m-d'));

        //$inc_id = $date.$call_id;
        $inc_id = $this->session->userdata('inc_ref_id');




        $sr_user = $this->clg->clg_ref_id;

        $sms_amb_details = $inc_details['amb_id'];
        
        if($call_type != 'terminate'  && $call_type != 'transfer_108' && $call_type != 'transfer_102' && $call_type != 'enable_dispatch'){
            if ($inc_details['amb_id'] == '' && $dup_inc == 'Yes' ) {

                $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";

                return;
            }
        }


        if($inc_details['inc_ref_id'] != ""){
            if ($dup_inc == 'No') {
            $amb_count =0;
            $inc_re_id = $inc_id;
            foreach ($inc_details['amb_id'] as $key=>$select_amb) {
                $amb_count++;
                $inc_re_id = $inc_details['inc_ref_id'];

                
                $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_type' => $inc_details['inc_type'],
               // 'inc_back_hospital' => $inc_details['new_facility'],
               // 'inc_back_home_address' => $inc_details['home_address'],
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
                'inc_district_id' => $inc_post_details['incient_districts'],
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
                //'inc_set_amb' => '1',
                'inc_recive_time' => $inc_details['inc_recive_time'],
                'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
                'inc_added_by' => $this->clg->clg_ref_id,
                 'inc_system_type' => $system  
            );
                
        
         if($cl_type == 'transfer_108'){
             
            $incidence_details['inc_set_amb'] = '0';
            $incidence_details['incis_deleted'] = '0';
             
         }else if($cl_type == 'transfer_102'){
            $incidence_details['inc_set_amb'] = '0';
            $incidence_details['incis_deleted'] = '0';
             
         }else if($cl_type == 'terminate'){
             $incidence_details['inc_set_amb'] = '1';
             $incidence_details['incis_deleted'] = '2';
             
         }else if($cl_type == 'enable_dispatch'){
             $incidence_details['inc_set_amb'] = '0';
             $incidence_details['incis_deleted'] = '3';
             
         }else{
               $incidence_details['inc_set_amb'] = '1';
               $incidence_details['incis_deleted'] = '0';
               $incidence_details['inc_system_type'] = $system;
               
                	
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
        

                $inc_details['amb_id'] = $select_amb;
                $EMT = "";
                $pilot = '';        
                $emp_inc_data = $this->inc_model->get_amb_emp($inc_details['amb_id'], $sft_id);

                if (empty($emp_inc_data)) {
                    $tm_team_date = date('Y-m-d');
                    $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);
                  

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
                if($cl_type != 'enable_dispatch'){
                    if( $inc_details['amb_id']){
                        $incidence_amb_details = array('amb_rto_register_no' => $inc_details['amb_id'],
                            'inc_ref_id' => $inc_re_id,
                            'amb_pilot_id' => $pilot,
                            'amb_emt_id' => $EMT,
                            'inc_base_month' => $this->post['base_month'],
                            'assigned_time' => $datetime);
                        $this->inc_model->insert_inc_amb($incidence_amb_details);
                    }

                    if($pilot != ''){
                        $args_operator1 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $pilot,
                            'operator_type' => 'UG-PILOT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'PREGANCY_CALL',
                            'base_month' => $this->post['base_month']
                        );
                        $args_operator1 = $this->common_model->assign_operator($args_operator1);
                    }

                    if($EMT != ''){
                        $args_operator2 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $EMT,
                            'operator_type' => 'UG-EMT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'PREGANCY_CALL',
                            'base_month' => $this->post['base_month']
                        );
                        $args_operator2 = $this->common_model->assign_operator($args_operator2);
                    }


                    $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);

                    $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
                }
                
                 $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                if ($inc_details['chief_complete_other'] != '') {
                    $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                if($cl_type == 'enable_dispatch'){

                    $item_key= $inc_details['enable_standard_summary'];

                     foreach ($item_key as $key=>$enable_standard_summary) {

                         $enable_data = array(
                             'inc_ref_id' => $inc_re_id,
                             'enable_remark' => $enable_standard_summary,
                             'amb_reg_no' => $inc_details['enable_ambulance'][$key],
                             'added_date' => $datetime,
                             'added_by' => $this->clg->clg_ref_id,
                         );
                         $enable = $this->inc_model->insert_inc_enable_dispatch($enable_data);
                     }
                 }
                

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
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                    $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }
                
                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "PREGANCY_CALL",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                
            }

            if ($inc_details['stand_amb_id']) {

                foreach ($inc_details['stand_amb_id'] as $key=>$stand_amb_id) {
                    
                    
                $inc_re_id = $inc_details['inc_ref_id'];
                $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_type' => $inc_details['inc_type'],
                //'inc_back_hospital' => $inc_details['new_facility'],
                //'inc_back_home_address' => $inc_details['home_address'],
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
                'inc_district_id' => $inc_post_details['incient_districts'],
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
                        $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);

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

                if($cl_type != 'enable_dispatch'){
                   if($inc_details['stand_amb_id']){
                        $incidence_amb_details = array('amb_rto_register_no' => $inc_details['stand_amb_id'],
                        'inc_ref_id' => $inc_re_id,
                        'amb_pilot_id' => $pilot,
                        'amb_emt_id' => $EMT,
                        'amb_type'=> 'standby',
                        'inc_base_month' => $this->post['base_month'],
                        'assigned_time' => $datetime);

                        $this->inc_model->insert_inc_amb($incidence_amb_details);
                    }
                    
                    if($pilot != ''){
                    
                        $args_operator1 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $pilot,
                            'operator_type' => 'UG-PILOT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'PREGANCY_CALL',
                            'base_month' => $this->post['base_month']
                        );
                        $args_operator1 = $this->common_model->assign_operator($args_operator1);
                    }

                    if($EMT != ''){
                        $args_operator2 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $EMT,
                            'operator_type' => 'UG-EMT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'PREGANCY_CALL',
                            'base_month' => $this->post['base_month']
                        );

                        $args_operator2 = $this->common_model->assign_operator($args_operator2);
                    }
                }
                    
                
                    $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                    if ($inc_details['chief_complete_other'] != '') {
                        $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                    }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                
                if($cl_type == 'enable_dispatch'){

                    $item_key= $inc_details['enable_standard_summary'];

                     foreach ($item_key as $key=>$enable_standard_summary) {

                         $enable_data = array(
                             'inc_ref_id' => $inc_re_id,
                             'enable_remark' => $enable_standard_summary,
                             'amb_reg_no' => $inc_details['enable_ambulance'][$key],
                             'added_date' => $datetime,
                             'added_by' => $this->clg->clg_ref_id,
                         );
                         $enable = $this->inc_model->insert_inc_enable_dispatch($enable_data);
                     }
                 }
                

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
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }

                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "PREGANCY_CALL",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                }
            }
        }

        //update_102_inc_ref_id($inc_id);
        $call_history_id = $this->session->userdata('call_history_id');
			
		_ucd_dispatch_call($inc_details['inc_ref_id'],$this->clg->clg_ref_id,$call_history_id);


        /* send sms to patient  */
        $sms_amb = $inc_details['amb_id'];
        $get_mobile_no = array('rg_no' => $sms_amb);
        $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);
        $driver = $this->colleagues_model->get_user_info($pilot);
        $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;
        $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;

        //$inc_id = $inc_id;
        $amb_url = base_url() . "amb/loc/" . $inc_re_id;
        $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_re_id;

        //$amb_url = "http://210.212.165.123/tdd/amb/loc/" . $inc_id;
        //$amb_dir_url = "http://210.212.165.123/tdd/amb/amb_dir/" . $inc_id;



        $doctor = $this->colleagues_model->get_user_info($EMT);
        $sms_doctor = $doctor[0]->clg_first_name;
        $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;
        $patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];
        $patient_mobile_no = $caller_details['clr_mobile'];
        //$patient_mobile_no = "9730015484";
        $patient_name = $caller_details['clr_fname'];

        $patient_sms_text = "Ambulance dispatched: $sms_amb\n Ambulance Contact - $sms_doctor_contact_no\n Track Link- $amb_url\nJAES";


        $patient_sms_to = $caller_details['clr_mobile'];
        //$patient_sms_to =  "8551995260";
        $send_dr_sms = $this->_send_sms($patient_sms_to, $patient_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_re_id,
            'sms_usertype' => 'Caller',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);



        /* send sms to doctor  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];

        if ($get_driver_no[0]->amb_user_type == 'tdd') {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url JAES";
        } else if ($get_driver_no[0]->amb_user_type = 'bike') {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call Bike Desk for Case ID creation. JAES";
        } else {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call 108 ERC for Case ID creation.  JAES";
        }

        $doctor_sms_to = $sms_doctor_contact_no;
        // $doctor_sms_to = '8551995260';
        $send_dr_sms = $this->_send_sms($doctor_sms_to, $doctor_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_re_id,
            'sms_usertype' => 'EMT',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);

        /* send sms to Pilot  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];

        $driver_sms_text = "Dear Pilot, Patient name: $patient_full_name,  Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id , Patient id:$last_pat_id  Navigate- $amb_dir_url JAES";

        $driver_contact_no = $sms_driver_contact_no;

        if ($call_type['cl_type'] == 'transfer_108') {

            _ucd_assign_call($inc_re_id);
        }
        
        if ($call_type['cl_type'] == 'transfer_102') {

            _ucd_102_assign_call($inc_re_id,$this->clg->clg_group);
        }
        
        $this->output->status = 1;
        $this->output->closepopup = "yes";
        ($call_type['cl_type'] == 'forword') ? $msg = "forworded" : $msg = "Added";
        $url = base_url("calls");
        $this->output->message = "<h3>Pregancy Care Call</h3><br><p>Ambulance Dispatch Successfully</p><script>window.location.href = '".$url."';</script>";
        $this->output->moveto = 'top';
        $this->output->add_to_position('', 'content', TRUE);
        }else{
           
        if ($dup_inc == 'No') {
            $amb_count =0;
            $inc_re_id = $inc_id;
            if($inc_details['amb_id']){
                
                foreach ($inc_details['amb_id'] as $key=>$select_amb) {
                    
                $amb_count++;
                $inc_re_id = $inc_id;

                
                $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_type' => $inc_details['inc_type'],
                //'inc_back_hospital' => $inc_details['new_facility'],
               // 'inc_back_home_address' => $inc_details['home_address'],
                'inc_ero_summary' => $inc_details['inc_ero_summary'],
                'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
                'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
                'inc_dispatch_time' => $inc_details['caller_dis_timer'],
                // 'inc_city' => $inc_details['inc_city'],
                'inc_city_id' => $inc_post_details['incient_ms_city'],
                //'inc_state' => $inc_post_details['incient_state'],
                'inc_state_id' => $inc_post_details['incient_state'],
                'inc_address' => $inc_details['place'],
                 'inc_tahshil_id' => $inc_post_details['incient_tahsil'],
                //'inc_district' => $inc_post_details['incient_district'],
                'inc_district_id' => $inc_post_details['incient_districts'],
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
                //'inc_set_amb' => '1',
                'inc_recive_time' => $inc_details['inc_recive_time'],
                'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
                'inc_added_by' => $this->clg->clg_ref_id,
                'inc_system_type' => $system
            );
                
        
         if($cl_type == 'transfer_108'){
             
            $incidence_details['inc_set_amb'] = '0';
            $incidence_details['incis_deleted'] = '0';
             
         }else if($cl_type == 'transfer_102'){
            $incidence_details['inc_set_amb'] = '0';
            $incidence_details['incis_deleted'] = '0';
             
         }else if($cl_type == 'terminate'){
             $incidence_details['inc_set_amb'] = '1';
             $incidence_details['incis_deleted'] = '2';
             
         }else if($cl_type == 'enable_dispatch'){
             $incidence_details['inc_set_amb'] = '0';
             $incidence_details['incis_deleted'] = '3';
             
         }else{
               $incidence_details['inc_set_amb'] = '1';
               $incidence_details['incis_deleted'] = '0';
               $incidence_details['inc_system_type'] = $system;
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
            
            
                $inc_details['amb_id'] = $select_amb;
                 
                $EMT = "";
                $pilot = '';        
                $emp_inc_data = $this->inc_model->get_amb_emp($inc_details['amb_id'], $sft_id);

                if (empty($emp_inc_data)) {
                    $tm_team_date = date('Y-m-d');
                    $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);
                  

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
                if($cl_type != 'enable_dispatch'){
                    if(isset($inc_details['amb_id'])){

                        $incidence_amb_details = array('amb_rto_register_no' => $inc_details['amb_id'],
                            'inc_ref_id' => $inc_re_id,
                            'amb_pilot_id' => $pilot,
                            'amb_emt_id' => $EMT,
                            'inc_base_month' => $this->post['base_month'],
                            'assigned_time' => $datetime);
                        $this->inc_model->insert_inc_amb($incidence_amb_details);
                    }

                    if($pilot != ''){
                        $args_operator1 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $pilot,
                            'operator_type' => 'UG-PILOT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'PREGANCY_CALL',
                            'base_month' => $this->post['base_month']
                        );
                        $args_operator1 = $this->common_model->assign_operator($args_operator1);
                    }

                    if($EMT != ''){
                        $args_operator2 = array(
                            'sub_id' => $inc_re_id,
                            'operator_id' => $EMT,
                            'operator_type' => 'UG-EMT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'PREGANCY_CALL',
                            'base_month' => $this->post['base_month']
                        );
                        $args_operator2 = $this->common_model->assign_operator($args_operator2);
                    }


                    $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);

                    $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
                
                }
                
                 $drop_back = array(
                'home_city_id' => $inc_post_details['incient_ms_city'],
                'home_state_id' => $inc_post_details['incient_state'],
                'home_address' => $inc_details['place'],
                //'home_tahsil_id' => $inc_post_details['incient_district'],
                'home_district_id' => $inc_post_details['incient_district'],
                'home_location' => $inc_details['area'],
                'home_landmark' => $inc_details['landmark'],
                'home_lane' => $inc_details['lane'],
                'home_houseno' => $inc_details['h_no'],
                'home_pin' => $inc_details['pincode'],
                'inc_ref_id'=>$inc_re_id);
            
               $drop_back_data = $this->inc_model->insert_dropback($drop_back);


                
                 $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                if ($inc_details['chief_complete_other'] != '') {
                    $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                
                if($cl_type == 'enable_dispatch'){

                    $item_key= $inc_details['enable_standard_summary'];

                     foreach ($item_key as $key=>$enable_standard_summary) {

                         $enable_data = array(
                             'inc_ref_id' => $inc_re_id,
                             'enable_remark' => $enable_standard_summary,
                             'amb_reg_no' => $inc_details['enable_ambulance'][$key],
                             'added_date' => $datetime,
                             'added_by' => $this->clg->clg_ref_id,
                         );
                         $enable = $this->inc_model->insert_inc_enable_dispatch($enable_data);
                     }
                 }
                
                $drop_back = array(
                                    'home_city_id' => $inc_post_details['incient_ms_city'],
                                    'home_state_id' => $inc_post_details['incient_state'],
                                    'home_address' => $inc_details['place'],
                                    //'home_tahsil_id' => $inc_post_details['incient_district'],
                                    'home_district_id' => $inc_post_details['incient_district'],
                                    'home_location' => $inc_details['area'],
                                    'home_landmark' => $inc_details['landmark'],
                                    'home_lane' => $inc_details['lane'],
                                    'home_houseno' => $inc_details['h_no'],
                                    'home_pin' => $inc_details['pincode'],
                                    'inc_ref_id'=>$inc_re_id);
            
                        $drop_back_data = $this->inc_model->insert_dropback($drop_back);


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
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                    $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }
                
                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "PREGANCY_CALL",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                
            }
            }else if ($inc_details['stand_amb_id']) {
                
                   
                foreach ($inc_details['stand_amb_id'] as $key=>$stand_amb_id) {
                    
                    
                $inc_re_id = $inc_id;
                $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_type' => $inc_details['inc_type'],
               // 'inc_back_hospital' => $inc_details['new_facility'],
                //'inc_back_home_address' => $inc_details['home_address'],
                'inc_ero_summary' => $inc_details['inc_ero_summary'],
                'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
                'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
                'inc_dispatch_time' => $inc_details['caller_dis_timer'],
                // 'inc_city' => $inc_details['inc_city'],
                'inc_city_id' => $inc_post_details['incient_ms_city'],
                //'inc_state' => $inc_post_details['incient_state'],
                'inc_state_id' => $inc_post_details['incient_state'],
                'inc_address' => $inc_details['place'],
                 'inc_tahshil_id' => $inc_post_details['incient_tahsil'],
                //'inc_district' => $inc_post_details['incient_district'],
                'inc_district_id' => $inc_post_details['incient_districts'],
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
                        $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);

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
                    
                    if($cl_type != 'enable_dispatch'){
                        if(isset($inc_details['amb_id'])){
                            $incidence_amb_details = array('amb_rto_register_no' => $inc_details['stand_amb_id'],
                                'inc_ref_id' => $inc_re_id,
                                'amb_pilot_id' => $pilot,
                                'amb_emt_id' => $EMT,
                                'amb_type'=> 'standby',
                                'inc_base_month' => $this->post['base_month'],
                                'assigned_time' => $datetime);

                            $this->inc_model->insert_inc_amb($incidence_amb_details);
                        }

                        if($pilot != ''){

                            $args_operator1 = array(
                                'sub_id' => $inc_re_id,
                                'operator_id' => $pilot,
                                'operator_type' => 'UG-PILOT',
                                'sub_status' => 'ASG',
                                'sub_type' => 'PREGANCY_CALL',
                                'base_month' => $this->post['base_month']
                            );
                            $args_operator1 = $this->common_model->assign_operator($args_operator1);
                        }

                        if($EMT != ''){
                            $args_operator2 = array(
                                'sub_id' => $inc_re_id,
                                'operator_id' => $EMT,
                                'operator_type' => 'UG-EMT',
                                'sub_status' => 'ASG',
                                'sub_type' => 'PREGANCY_CALL',
                                'base_month' => $this->post['base_month']
                            );

                            $args_operator2 = $this->common_model->assign_operator($args_operator2);
                        }
                    }
                    
                
                    $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                    if ($inc_details['chief_complete_other'] != '') {
                        $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                    }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                
                if($cl_type == 'enable_dispatch'){

                    $item_key= $inc_details['enable_standard_summary'];

                     foreach ($item_key as $key=>$enable_standard_summary) {

                         $enable_data = array(
                             'inc_ref_id' => $inc_re_id,
                             'enable_remark' => $enable_standard_summary,
                             'amb_reg_no' => $inc_details['enable_ambulance'][$key],
                             'added_date' => $datetime,
                             'added_by' => $this->clg->clg_ref_id,
                         );
                         $enable = $this->inc_model->insert_inc_enable_dispatch($enable_data);
                     }
                }
                
                

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
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }

                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "PREGANCY_CALL",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                }
            }else{
                
                                  
               
                $amb_count++;
                $inc_re_id = $inc_id;

                
                $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_type' => $inc_details['inc_type'],
               // 'inc_back_hospital' => $inc_details['new_facility'],
                //'inc_back_home_address' => $inc_details['home_address'],
                'inc_ero_summary' => $inc_details['inc_ero_summary'],
                'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
                'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
                'inc_dispatch_time' => $inc_details['caller_dis_timer'],
                // 'inc_city' => $inc_details['inc_city'],
                'inc_city_id' => $inc_post_details['incient_ms_city'],
                //'inc_state' => $inc_post_details['incient_state'],
                'inc_state_id' => $inc_post_details['incient_state'],
                'inc_address' => $inc_details['place'],
                 'inc_tahshil_id' => $inc_post_details['incient_tahsil'],
                //'inc_district' => $inc_post_details['incient_district'],
                'inc_district_id' => $inc_post_details['incient_districts'],
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
                //'inc_set_amb' => '1',
                'inc_recive_time' => $inc_details['inc_recive_time'],
                'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
                'inc_added_by' => $this->clg->clg_ref_id,
                'inc_system_type' => $system
            );
                
        
         if($cl_type == 'transfer_108'){
             
            $incidence_details['inc_set_amb'] = '0';
            $incidence_details['incis_deleted'] = '0';
             
         }else if($cl_type == 'transfer_102'){
            $incidence_details['inc_set_amb'] = '0';
            $incidence_details['incis_deleted'] = '0';
             
         }else if($cl_type == 'terminate'){
             $incidence_details['inc_set_amb'] = '1';
             $incidence_details['incis_deleted'] = '2';
             
         }else if($cl_type == 'enable_dispatch'){
             $incidence_details['inc_set_amb'] = '0';
             $incidence_details['incis_deleted'] = '3';
             
         }else{
               $incidence_details['inc_set_amb'] = '1';
               $incidence_details['incis_deleted'] = '0';
               $incidence_details['inc_system_type'] = $system;
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
            
            
                $inc_details['amb_id'] = $select_amb;
                $EMT = "";
                $pilot = '';        
                $emp_inc_data = $this->inc_model->get_amb_emp($inc_details['amb_id'], $sft_id);

                if (empty($emp_inc_data)) {
                    $tm_team_date = date('Y-m-d');
                    $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);
                  

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
                
                if($cl_type != 'enable_dispatch'){
                if($inc_details['amb_id']){
                    $incidence_amb_details = array('amb_rto_register_no' => $inc_details['amb_id'],
                        'inc_ref_id' => $inc_re_id,
                        'amb_pilot_id' => $pilot,
                        'amb_emt_id' => $EMT,
                        'inc_base_month' => $this->post['base_month'],
                        'assigned_time' => $datetime);
                    $this->inc_model->insert_inc_amb($incidence_amb_details);
                    
                    if($pilot != ''){
                         $args_operator1 = array(
                             'sub_id' => $inc_re_id,
                             'operator_id' => $pilot,
                             'operator_type' => 'UG-PILOT',
                             'sub_status' => 'ASG',
                             'sub_type' => 'PREGANCY_CALL',
                             'base_month' => $this->post['base_month']
                         );
                         $args_operator1 = $this->common_model->assign_operator($args_operator1);
                     }

                     if($EMT != ''){
                         $args_operator2 = array(
                             'sub_id' => $inc_re_id,
                             'operator_id' => $EMT,
                             'operator_type' => 'UG-EMT',
                             'sub_status' => 'ASG',
                             'sub_type' => 'PREGANCY_CALL',
                             'base_month' => $this->post['base_month']
                         );
                         $args_operator2 = $this->common_model->assign_operator($args_operator2);
                     }
                }
                
                }
                
                 $drop_back = array(
                'home_city_id' => $inc_post_details['incient_ms_city'],
                'home_state_id' => $inc_post_details['incient_state'],
                'home_address' => $inc_details['place'],
                //'home_tahsil_id' => $inc_post_details['incient_district'],
                'home_district_id' => $inc_post_details['incient_district'],
                'home_location' => $inc_details['area'],
                'home_landmark' => $inc_details['landmark'],
                'home_lane' => $inc_details['lane'],
                'home_houseno' => $inc_details['h_no'],
                'home_pin' => $inc_details['pincode'],
                'inc_ref_id'=>$inc_re_id);
            
               $drop_back_data = $this->inc_model->insert_dropback($drop_back);



                
                $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);

                $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
                
                 $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                if ($inc_details['chief_complete_other'] != '') {
                    $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                
                if($cl_type == 'enable_dispatch'){

                    $item_key= $inc_details['enable_standard_summary'];

                     foreach ($item_key as $key=>$enable_standard_summary) {

                         $enable_data = array(
                             'inc_ref_id' => $inc_re_id,
                             'enable_remark' => $enable_standard_summary,
                             'amb_reg_no' => $inc_details['enable_ambulance'][$key],
                             'added_date' => $datetime,
                             'added_by' => $this->clg->clg_ref_id,
                         );
                         $enable = $this->inc_model->insert_inc_enable_dispatch($enable_data);
                     }
                 }
                
                $drop_back = array(
                                    'home_city_id' => $inc_post_details['incient_ms_city'],
                                    'home_state_id' => $inc_post_details['incient_state'],
                                    'home_address' => $inc_details['place'],
                                    //'home_tahsil_id' => $inc_post_details['incient_district'],
                                    'home_district_id' => $inc_post_details['incient_district'],
                                    'home_location' => $inc_details['area'],
                                    'home_landmark' => $inc_details['landmark'],
                                    'home_lane' => $inc_details['lane'],
                                    'home_houseno' => $inc_details['h_no'],
                                    'home_pin' => $inc_details['pincode'],
                                    'inc_ref_id'=>$inc_re_id);
            
                        $drop_back_data = $this->inc_model->insert_dropback($drop_back);


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
                        'ptn_birth_date' => $patient['dob'],
                        'ayushman_id' => $patient['ayu_id'],
                    'ptn_mob_no' => $patient['ptn_mob_no'],
                    'ptn_bgroup' => $patient['blood_gp'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                    $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
                $ques_ans = $inc_details['ques'];

                if (isset($ques_ans)) {
                    foreach ($ques_ans as $key => $ques) {

                        $ems_summary = array('sum_base_month' => $this->post['base_month'],
                            'sum_sub_id' => $inc_re_id,
                            'sum_sub_type' => $inc_details['inc_type'],
                            'sum_que_id' => $key,
                            'sum_que_ans' => $ques
                        );

                        $this->inc_model->insert_ems_summary($ems_summary);
                    }
                }
                
                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "PREGANCY_CALL",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                
                    
            }
            
            
        }

        //update_102_inc_ref_id($inc_id);


        /* send sms to patient  */
        $sms_amb = $inc_details['amb_id'];
        $get_mobile_no = array('rg_no' => $sms_amb);
        $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);
        $driver = $this->colleagues_model->get_user_info($pilot);
        $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;
        $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;

        //$inc_id = $inc_id;
        $amb_url = base_url() . "amb/loc/" . $inc_re_id;
        $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_re_id;

        //$amb_url = "http://210.212.165.123/tdd/amb/loc/" . $inc_id;
        //$amb_dir_url = "http://210.212.165.123/tdd/amb/amb_dir/" . $inc_id;



        $doctor = $this->colleagues_model->get_user_info($EMT);
        $sms_doctor = $doctor[0]->clg_first_name;
        $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;
        $patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];
        $patient_mobile_no = $caller_details['clr_mobile'];
        //$patient_mobile_no = "9730015484";
        $patient_name = $caller_details['clr_fname'];

        $patient_sms_text = "Ambulance dispatched: $sms_amb\n Ambulance Contact - $sms_doctor_contact_no\n Track Link- $amb_url\nJAES";


        $patient_sms_to = $caller_details['clr_mobile'];
        //$patient_sms_to =  "8551995260";
        $send_dr_sms = $this->_send_sms($patient_sms_to, $patient_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_re_id,
            'sms_usertype' => 'Caller',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);



        /* send sms to doctor  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];

        if ($get_driver_no[0]->amb_user_type == 'tdd') {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url JAES";
        } else if ($get_driver_no[0]->amb_user_type = 'bike') {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call Bike Desk for Case ID creation. JAES";
        } else {

            $doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call 108 ERC for Case ID creation.  JAES";
        }

        $doctor_sms_to = $sms_doctor_contact_no;
        // $doctor_sms_to = '8551995260';
        $send_dr_sms = $this->_send_sms($doctor_sms_to, $doctor_sms_text, $lang = "english");

        $asSMSReponse = explode("-", $send_dr_sms);
        $res_sms = array('inc_ref_id' => $inc_re_id,
            'sms_usertype' => 'EMT',
            'sms_res' => $asSMSReponse[0],
            'sms_res_text' => $asSMSReponse[1] ? $asSMSReponse[1] : '',
            'sms_datetime' => $datetime);
        $this->inc_model->insert_sms_response($res_sms);

        /* send sms to Pilot  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];

        $driver_sms_text = "Dear Pilot, Patient name: $patient_full_name,  Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id , Patient id:$last_pat_id  Navigate- $amb_dir_url JAES";

        $driver_contact_no = $sms_driver_contact_no;

        if ($call_type['cl_type'] == 'transfer_108') {

            _ucd_assign_call($inc_re_id);
        }
        
        if ($call_type['cl_type'] == 'transfer_102') {

           _ucd_102_assign_call($inc_re_id,$this->clg->clg_group);
        }
        
        $this->output->status = 1;
        $this->output->closepopup = "yes";
        ($call_type['cl_type'] == 'forword') ? $msg = "forworded" : $msg = "Added";
        $url = base_url("calls");
        $this->output->message = "<h3>Child Care Call</h3><br><p>Ambulance Dispatch Successfully</p><script>window.location.href = '".$url."';</script>";
        $this->output->moveto = 'top';
        $this->output->add_to_position('', 'content', TRUE);
        }
    }
    function enable_dispatch(){
         $this->output->add_to_position($this->load->view('frontend/inc/enable_dispatch_view', $data, TRUE), 'enable_dispatch_outer', TRUE);
    }
    
    function confirm_pvthos_save() {

        $this->session->unset_userdata('incient');
        $this->session->unset_userdata('inter');
        $this->session->unset_userdata('call_type');

        $call_type = $this->input->get();
        $call_type = $this->input->get_post('call_type');
        
        $inc_post_details = $this->input->post();

        $inc_details = $this->input->get_post('incient');
        $inter_details = $this->input->get_post('inter');
        $patient = $this->input->get_post('patient');
        $caller_details = $this->input->get_post('caller');
        $datetime = date('Y-m-d H:i:s');


        $dup_inc = $inc_details['dup_inc'];
        
        if($inc_post_details['call_type'] == 'terminate'){
            if($inc_details['amb_id'] != ''){
                $this->output->message = "<div class='error'>Remove Ambulance Selected ambulance</div>";
              return;

            }
        }

        $call_id = $this->input->get_post('call_id');
        $this->session->set_userdata('mic_details', $inc_details);
        $this->session->set_userdata('incient', $inc_details);
        $this->session->set_userdata('inter', $inter_details);
        $this->session->set_userdata('call_type', $call_type);
        $this->session->set_userdata('call_id', $call_id);
        $this->session->set_userdata('patient', $patient);
        $this->session->set_userdata('inc_datetime', $datetime);
        $session_caller_details = $this->session->userdata('caller_details');
        $this->session->set_userdata('inc_post_details', $inc_post_details);

        if($call_type != 'terminate'  && $call_type != 'transfer_108' && $call_type != 'transfer_102'  && $call_type != 'enable_dispatch'){
            if ($inc_details['amb_id'] == '' && $dup_inc == 'No') {

                $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";

                return;
            }
        }

        if ($inc_details["amb_id"]) {

            foreach ($inc_details["amb_id"] as $amb) {

                $args = array(
                    'rg_no' => $amb,
                );



                $get_amb_details[] = $this->inc_model->get_amb_details($args);
            }
        }

        if ($inc_id == '') {
             $inc_id = generate_inc_ref_id();
            $this->session->set_userdata('inc_ref_id', $inc_id);
            update_inc_ref_id($inc_id);
        }
        $data['nature'] = $this->inc_model->get_chief_comp_service($inc_details['chief_complete']);
        $data['inc_ref_id'] = $inc_id;
        $data['patient'] = $patient;

        $data['get_amb_details'] = $get_amb_details;
        $data['inc_details'] = $inc_details;

        $data['hospital_id'] = $inc_details['hospital_id'];
        $data['hospital_other'] = $inc_details['hospital_other'];
        $data['caller_details'] = $session_caller_details;
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];

        $data['place'] = $inc_details['place'];

        $data['cl_type'] = $call_type;
        $data['inc_datetime'] = $datetime;

        $this->output->add_to_popup($this->load->view('frontend/inc/confirm_pvthos_view', $data, TRUE), '600', '560');

    }
     function save_pvthos_save() {

        $call_type = $this->input->get();
        $inc_details = $this->input->get_post('incient');
        $inter_details = $this->input->get_post('inter');
        $call_id = $this->input->get_post('call_id');
        $caller_details = $this->session->userdata('caller_details');
        $inc_details = $this->session->userdata('mic_details');
        $inter_details = $this->session->userdata('inter');
        $inc_post_details = $this->session->userdata('inc_post_details');
        $patient= $this->session->userdata('patient');
        $cl_type = $this->input->get_post('cl_type');
      
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
            $inc_post_details['incient_state'] = "MP";
        }
        $date = str_replace('-', '', date('Y-m-d'));

        //$inc_id = $date.$call_id;
        $inc_id = $this->session->userdata('inc_ref_id');




        $sr_user = $this->clg->clg_ref_id;

        $sms_amb_details = $inc_details['amb_id'];
        
        if($call_type != 'terminate'  && $call_type != 'transfer_108' && $call_type != 'transfer_102'){
            if ($inc_details['amb_id'] == '' && $dup_inc == 'Yes' ) {

                $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";

                return;
            }
        }


            
        if ($dup_inc == 'No') {
            $amb_count =0;
            $inc_re_id = $inc_id;
            if($inc_details['amb_id']){
                foreach ($inc_details['amb_id'] as $key=>$select_amb) {
                $amb_count++;
                $inc_re_id = $inc_id;
                
                $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_re_id));
                if(!empty($is_exits)){
                    $this->session->set_userdata('inc_ref_id','');
                    $this->output->message = "<div class='error'>Incident Id alredy exists</div>";
                    return;
                }
                $district_hospital=0;
                $hosp_type = '';
                if($inc_details['drop_hospital'] != ''){
                    $drop_hospital = get_hospital_by_id($inc_details['drop_hospital']);
                    $district_hospital = $drop_hospital[0]->hp_district;
                    $hosp_type = get_hosp_type_by_id($drop_hospital[0]->hp_type);
                }

                
                $incidence_details = array('inc_cl_id' => $call_id,
                'inc_ref_id' => $inc_re_id,
                'inc_type' => $inc_details['inc_type'],
                'inc_back_hospital' => $inter_details['facility'],
                'current_district' => $inter_details['current_district'],
               // 'inc_back_home_address' => $inc_details['home_address'],
               'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
                'inc_ero_summary' => $inc_details['inc_ero_summary'],
                'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
                'inc_dispatch_time' => $inc_details['caller_dis_timer'],
                // 'inc_city' => $inc_details['inc_city'],
                'inc_city_id' => $inc_post_details['incient_ms_city'],
                //'inc_state' => $inc_post_details['incient_state'],
                'inc_state_id' => $inc_post_details['incient_state'],
                'inc_address' => $inc_details['place'],
                 'inc_tahshil_id' => $inc_post_details['incient_tahsil'],
                //'inc_district' => $inc_post_details['incient_district'],
                'inc_district_id' => $inc_post_details['incient_districts'],
                'inc_area' => $inc_details['area'],
                'inc_landmark' => $inc_details['landmark'],
                'inc_lane' => $inc_details['lane'],
                'inc_h_no' => $inc_details['h_no'],
                'inc_pincode' => $inc_details['pincode'],
                'inc_lat' => $inc_details['lat'],
                'inc_long' => $inc_details['lng'],
                'inc_datetime' => $datetime,
                //'inc_service' => $inc_details_service,
                'inc_duplicate' => $dup_inc,
                'inc_base_month' => $this->post['base_month'],
                'hospital_id' => $inc_details['drop_hospital'],
                'hospital_type' => $hosp_type,
                'hospital_district' => $district_hospital,
                'inc_recive_time' => $inc_details['inc_recive_time'],
                'inc_patient_cnt' => $inc_details['inc_patient_cnt'],
                'inc_added_by' => $this->clg->clg_ref_id,
                'inc_system_type' => $system
            );
                
        
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
                
            
  
            
            
                $inc_details['amb_id'] = $select_amb;
                $EMT = "";
                $pilot = '';        
                $emp_inc_data = $this->inc_model->get_amb_emp($inc_details['amb_id'], $sft_id);

                if (empty($emp_inc_data)) {
                    $tm_team_date = date('Y-m-d');
                    $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);
                  

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
                

                if($pilot != ''){
                    $args_operator1 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $pilot,
                        'operator_type' => 'UG-PILOT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'EMG_PVT_HOS',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator1 = $this->common_model->assign_operator($args_operator1);
                }

                if($EMT != ''){
                    $args_operator2 = array(
                        'sub_id' => $inc_re_id,
                        'operator_id' => $EMT,
                        'operator_type' => 'UG-EMT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'EMG_PVT_HOS',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator2 = $this->common_model->assign_operator($args_operator2);
                }

                
                $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);

                $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
                
                 $incidence_details['inc_complaint'] = $inc_details['chief_complete'];
                if ($inc_details['chief_complete_other'] != '') {
                    $incidence_details['inc_complaint_other'] = $inc_details['chief_complete_other'];
                }

                $inc_data = $this->inc_model->insert_inc($incidence_details);
                
                     
                $hosp_private = array(
                                    'pr_base_to_inc_distance' => $inc_details['base_to_inc_distance'],
                                    'pr_inc_to_hosp_distance' => $inc_details['inc_to_hosp_distance'],
                                    'pr_hp_to_base_distance' => $inc_details['hp_to_base_distance'],
                                    'pr_case_total_distance' => $inc_details['case_total_distance'],
                                    'pr_drop_hospital' => $inc_details['drop_hospital'],
                                    'pr_hos_incident_address' => $inc_details['hos_incident_address'],
                                    'pr_base_id'=>$inc_details['base_id'],
                                    'pr_drop_hospital_address' => $inc_details['drop_hospital_address'],
                                    'pr_drop_hospital_district' => $inc_details['drop_hospital_district'],
                                    'pr_drop_hospital_type' => $inc_details['drop_hospital_type'],
                                    'pr_total_amount'=>$inc_details['total_amount'],
                                    'pr_base_location_address' => $inc_details['base_location_address'],
                                    'pr_base_month ' => $this->post['base_month'],
                                    'pr_inc_ref_id'=>$inc_re_id);
            
                
                $private_hospital_data = $this->inc_model->insert_private_hospital($hosp_private);
            
                          
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
                $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

                $incidence_patient = array('inc_id' => $inc_re_id,
                    'ptn_id' => $last_pat_id);

                $this->pet_model->insert_inc_pat($incidence_patient);
                
 
                
                $args = array(
                    'sub_id' => $inc_re_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ASG',
                    'sub_type' => "EMG_PVT_HOS",
                    'base_month' => $this->post['base_month']
                );

                $res = $this->common_model->assign_operator($args);
                
            }
            }

        

        //update_102_inc_ref_id($inc_id);


        /* send sms to patient  */
        $sms_amb = $inc_details['amb_id'];
        $get_mobile_no = array('rg_no' => $sms_amb);
        $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);
        $driver = $this->colleagues_model->get_user_info($pilot);
        $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;
        $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;


        $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_re_id;




        $doctor = $this->colleagues_model->get_user_info($EMT);
        $sms_doctor = $doctor[0]->clg_first_name;
        $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;
        $patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];
        $patient_mobile_no = $caller_details['clr_mobile'];
        //$patient_mobile_no = "9730015484";
         $patient_name = $caller_details['clr_fname'];
         $inc_re_id_new = base64_encode($inc_re_id);
       // $patient_sms_text = "Ambulance dispatched: $sms_amb\n Ambulance Contact - $sms_doctor_contact_no\n Track Link- $amb_url\nJAES";
       $sms_amb1 = implode('',(explode("-",$sms_amb)));
       $txtMsg1 = '';
         $txtMsg1.= "Dear ".$patient_full_name.", \n";
         $txtMsg1.= "Ambulance dispatched: ".$sms_amb1 .", \n";
         $txtMsg1.= "Ambulance Contact: ".$sms_doctor_contact_no .", \n" ;
         //$txtMsg1.= "Link: ".$amb_dir_url."\n" ;
         $txtMsg1 .= "Please click on the following link for downloading the 108 Sanjeevani app on your mobile Android User - https://tinyurl.com/2p87kfu6 and iOS User- https://tinyurl.com/3pup8pp4\n ";
         $txtMsg1 .= "Click on following link for payment https://irts.jaesmp.com/setting/load_payment/$inc_re_id_new\n ";
        $txtMsg1.= "JAES" ;
      

        $patient_sms_to = $caller_details['clr_mobile'];
        $args = array(
            'inc_id' => $inc_id,
            'msg' => $txtMsg1,
            'mob_no' => $patient_sms_to,
            'sms_user'=>'pvt_patient_msg',
        );
       
        $sms_data = sms_send($args);
        $mno = substr($patient_sms_to, -10);
        $inc_link_args = array( 'mobile_no'=>$mno,
                                'incident_id'=>$inc_id,
                                'track_link'=>$amb_dir_url,
                                'added_date' =>   date('Y-m-d H:i:s'));
        
        $inc_link = $this->call_model->insert_track_link($inc_link_args);

       

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
        /* send sms to doctor  */
        $report_args2 = array('drop_hospital'=> $inc_details['drop_hospital']);
        $hp_data = $this->amb_model->get_drop_hospital_name($report_args2);
        $hp_name = $hp_data[0]->hp_name;
        if (strlen($hp_name) > 30){
            $hp_name = substr($hp_name, 0, 30);
        }
        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];
        $patient_full_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . ucfirst($patient['last_name']);
        //$doctor_sms_text = "Patient name: $patient_full_name, Address- $inc_address, Caller No - $patient_mobile_no, Incident id:$inc_re_id, Patient id:$last_pat_id, Navigate- $amb_url\n Note: Call 108 ERC for Case ID creation.  JAES";
        $datetime = date('d-m-Y H:i:s');
        $txtMsg2 ='';
        $txtMsg2.= "Patient name: ".$patient_full_name.",\n"; 
        $txtMsg2.= " Address: ".$inc_address.",\n";
        $txtMsg2.= " Caller No: ".$patient_mobile_no.",\n";
        $txtMsg2.= " Incident Date Time: ".$datetime.",\n";
        $txtMsg2.= " Incident id: ".$inc_id.",\n";
        $txtMsg2.= " Chief Complaint: ".$chief_complaint.",\n";
        $txtMsg2.= " Hospital Name- ".$hp_name.",\n";
        $txtMsg2.= " JAES" ;

        $doctor_sms_to = $sms_doctor_contact_no;
       
     
       $args = array(
        'inc_id' => $inc_id,
        'msg' => $txtMsg2,
        'mob_no' => $doctor_sms_to,
        'sms_user'=>'EMT',
    );
    
    $sms_data = sms_send($args);
    ///PriceDetails SMS*****
    

   $datetime = date('Y-m-d H:i:s');
   $amb_category = $amb_details[0]->amb_category;
   $amb_owner = $amb_details[0]->amb_owner;
    $category=$amb_category;
    $owner=$amb_owner;
    $base_location=$inc_details['base_location_address'];
    $hospital_location=$inc_details['drop_hospital_address'];
    $Distance=$inc_details['case_total_distance'];
    $report_args1 = array('rto_no'=> $sms_amb);
    $amb_data = $this->amb_model->get_amb_make_model_by_regno($report_args1);
    $ambu_price = $amb_data[0]->ambu_price;
    $data['price']=$ambu_price;
    $Rate=$data['price'];
    $amount=$inc_details['total_amount'];
    $report_args2 = array('drop_hospital'=> $inc_details['drop_hospital']);
    $hp_data = $this->amb_model->get_drop_hospital_name($report_args2);
    $hp_name = $hp_data[0]->hp_name;
    
  
    $amb_args = array('amb_no'=> $sms_amb);
    
    $dm_data = $this->amb_model->get_dm_mob_no($amb_args);
    $dm_mob = $dm_data[0]->clg_mobile_no;
    $dm_name = $dm_data[0]->clg_first_name;
    //die();
    if (strlen($base_location) > 30){
        $base_location = substr($base_location, 0, 30);
    }
    if (strlen($inc_address) > 30){
        $inc_address = substr($inc_address, 0, 30);
    }
    if (strlen($hospital_location) > 30){
        $hospital_location = substr($hospital_location, 0, 30);
    }
    if (strlen($hp_name) > 30){
        $hp_name = substr($hp_name, 0, 30);
    }
    $txtMsg4 = '';
    $txtMsg4.= "Incident ID : ".$inc_re_id.", \n"; 
    $txtMsg4.= "Date Time : ".$datetime.", \n";
    $txtMsg4.= "Ambulance No : ".$sms_amb1.", \n";
    $txtMsg4.= "Type : ".$category."-".$owner.", \n";
    $txtMsg4.= "Base location : ".$base_location.",\n";
    $txtMsg4.= "Incident Location : ".$inc_address.", \n";
    $txtMsg4.= "Hospital Location : ".$hospital_location.", \n";
    $txtMsg4.= "Hospital Name : ".$hp_name.", \n";
    $txtMsg4.= "Total Distance : ".$Distance.", \n";
    $txtMsg4.= "Per KM Rate : ".$Rate.", \n";
    $txtMsg4.= "Total amount to be collected : ".$amount.",";
    $txtMsg4.= "JAES";
   //var_dump($txtMsg4);
    $doctor_sms_to = $sms_doctor_contact_no;
       
    // var_dump($txtMsg4);die();
    $args = array(
        'inc_id' => $inc_re_id,
        'msg' => $txtMsg4,
        'mob_no' => $dm_mob,
        'sms_user'=>'EMT_PVT_HOS_DM',
    );
    //var_dump($args);die();
    $sms_data = sms_send($args);
   

    ///PriceDetails SMS*****
    $mno = $doctor_sms_to;
    $mno = substr($mno, -10);
    $inc_link_args = array( 'mobile_no'=>$mno,
                            'incident_id'=>$inc_id,
                            'track_link'=>$amb_url,
                            'added_date' =>   date('Y-m-d H:i:s'));
    
    $inc_link = $this->call_model->insert_track_link($inc_link_args);

        /* send sms to Pilot  */

        $inc_address = $inc_details['place'];
        $patient_name = $caller_details['clr_fname'];

      
        $datetime = date('d-m-Y H:i:s');
        $txtMsg2 ='';
        $txtMsg2.= "Patient name: ".$patient_full_name.",\n"; 
        $txtMsg2.= " Address: ".$inc_address.",\n";
        $txtMsg2.= " Caller No: ".$patient_mobile_no.",\n";
        $txtMsg2.= " Incident Date Time: ".$datetime.",\n";
        $txtMsg2.= " Incident id: ".$inc_id.",\n";
        $txtMsg2.= " Chief Complaint: ".$chief_complaint.",\n";
        $txtMsg2.= " Hospital Name- ".$hp_name.",\n";
        $txtMsg2.= " JAES" ;
        $driver_contact_no = $sms_driver_contact_no;
        $args = array(
            'inc_id' => $inc_id,
            'msg' => $txtMsg2,
            'mob_no' => $driver_contact_no,
            'sms_user'=>'Pilot',
        );
        $sms_data = sms_send($args);
        $args = array(
            'inc_id' => $inc_re_id,
            'msg' => $txtMsg4,
            'mob_no' => $driver_contact_no,
            'sms_user'=>'EMT_PVT_HOS_PILOT',
        );
        
        $sms_data = sms_send($args);


        $mno = substr($mno, -10);
        $inc_link_args = array( 'mobile_no'=>$driver_contact_no,
                                'incident_id'=>$inc_id,
                                'track_link'=>$amb_url,
                                'added_date' =>   date('Y-m-d H:i:s'));
        
        $inc_link = $this->call_model->insert_track_link($inc_link_args);
              
      
        
        $caller_lat = $inc_details['lat'];
        $caller_lng = $inc_details['lng'];
        $destination_hos = $pri_hosp_name;
        $hp_lat = $hp_data[0]->hp_lat;
        $hp_long = $hp_data[0]->hp_long;
        $select_amb_API= str_replace('-','',$inc_details['amb_id']);
        //$select_amb = implode('',(explode("-",$inc_details['amb_id'])));
        $args = array(
            'LastActivityTime' => "$datetime" ,
            'JobStatus' => 'Dispatched' ,
            'onRoadStatus' =>'1' ,
            'Caller_Location' => "$inc_address",
            'Hospital_Location' => "$hp_name",
            'JobNo' => "$inc_id",
            'HospitalLatlong' => "$hp_lat".','."$hp_long",
            'stateCode' => 'MP',
            'AmbulanceNo' =>"$select_amb_API",
            'CallerLatlong' =>"$caller_lat".','."$caller_lng"
        );
        //var_dump($args);die();
        $send_API = send_API($args);
        if ($call_type['cl_type'] == 'transfer_108') {

            _ucd_assign_call($inc_re_id);
        }
        
        if ($call_type['cl_type'] == 'transfer_102') {

           _ucd_102_assign_call($inc_re_id,$this->clg->clg_group);
        }

        //die();
        $this->output->status = 1;
        $this->output->closepopup = "yes";
        ($call_type['cl_type'] == 'forword') ? $msg = "forworded" : $msg = "Added";
        $url = base_url("calls");
        $this->output->message = "<h3>Private hospital Call</h3><br><p>Ambulance Dispatch Successfully</p><script>window.location.href = '".$url."';</script>";
        $this->output->moveto = 'top';
        $this->output->add_to_position('', 'content', TRUE);
        }
    }

}
