<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Emt extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));
        $this->load->model(array('pet_model', 'add_res_model', 'colleagues_model', 'inc_model', 'amb_model', 'pcr_model', 'call_model', 'medadv_model', 'student_model', 'school_model', 'schedule_model', 'emt_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper', 'language_helper'));


        $this->post = $this->input->get_post(NULL);
        $this->post['base_month'] = get_base_month();
        $this->clg = $this->session->userdata('current_user');

        $this->pg_limit = $this->config->item('pagination_limit_clg');
        $this->pg_limits = $this->config->item('report_clg');

        $this->steps_cnt = $this->config->item('screening_steps');

        $this->today = date('Y-m-d H:i:s');
    }

    function emt_home() {

        $this->output->add_to_position('', "pcr_top_steps", TRUE);
        $this->output->add_to_position($this->load->view('frontend/emt/emt_dashboard_view', $data, TRUE), $this->post['output_position'], TRUE);
        $this->output->template = "emt";
    }

    function emt_landing_page() {
        $this->output->add_to_position('', "pcr_top_steps", TRUE);
        $this->output->add_to_position($this->load->view('frontend/emt/emt_landing_page', $data, TRUE), $this->post['output_position'], TRUE);
        $this->output->template = "emt";
    }

    function screen_dash() {

        $data['schedule_date'] = ($this->post['schedule_date']) ? $this->post['schedule_date'] : $this->fdata['schedule_date'];
        $data['schedule_type'] = ($this->post['schedule_type']) ? $this->post['schedule_type'] : $this->fdata['schedule_type'];
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $ambflt['AMB'] = $data;

        ///////////set page number////////////////////
        $page_no = 1;
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        //////////////////////////limit & offset//////

        $data['get_count'] = TRUE;
        $data['schedule_isaprove'] = '1';
        $data['schedule_type'] = '2';


        $data['total_count'] = $this->schedule_model->get_schedule_data($data);

        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        //$page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $scheduleflt['SCHEDULE'] = $data;

        $this->session->set_userdata('filters', $scheduleflt);

        /////////////////////////////////////////////////////

        unset($data['get_count']);

        //$data['result'] = $this->schedule_model->get_schedule_data($data, $offset, $limit);
        $result = $this->schedule_model->get_schedule_data($data, $offset, $limit);

        $shedule = array();

        foreach ($result as $result_data) {


            $school_arg = array('school_id' => $result_data->schedule_schoolid);

            $school_data = $this->school_model->get_school_data($school_arg);
            $result_data->school_name = $school_data[0]->school_name;
            $shedule[] = $result_data;
        }

        $data['result'] = $shedule;

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("schedule/screen_dash"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        $data['pagination'] = get_pagination($pgconf);

        $this->output->add_to_position($this->load->view('frontend/emt/screen_dash_view', $data, TRUE), $this->post['output_position'], TRUE);
        $this->output->template = "emt";
    }

    function student_search() {

        $schedule_id = base64_decode($this->input->get('schedule_id'));
        //var_dump($schedule_id);

        $data['schedule_id'] = $schedule_id;


        $this->output->add_to_position($this->load->view('frontend/emt/search_student_view', $data, TRUE), $this->post['output_position'], TRUE);

        $arg_array = array('schedule_id' => $schedule_id);

        $schedule = $this->schedule_model->get_schedule_data($arg_array);
        
        $data['student_data'] = $this->student_model->get_search_stud_by_shedule_id($arg_array);

        $data['schedule_data'] = array('schedule_date' => date('d-M-Y', strtotime($schedule[0]->schedule_date)),
            'schedule_time' => date('g A', strtotime($schedule[0]->schedule_time)),
            'school_name' => $schedule[0]->school_name);

        $this->session->set_userdata('schedule_info', $data['schedule_data']);
        $data['student_top_info_data'] = array();

        $this->output->add_to_position($this->load->view('frontend/emt/student_schedule_info', $data, TRUE), 'schedule_student_top', TRUE);
        $this->output->add_to_position($this->load->view('frontend/emt/search_student_list_view', $data, TRUE), 'student_search_list', TRUE);
        $this->output->template = "emt";
    }

    function student_search_list() {

        $schedule_id = ($this->input->post('schedule_id'));


        $arg_array = array();

        if ($this->input->post('reg_no') != '') {
            $arg_array['reg_no'] = $this->input->post('reg_no');
        }

        if ($this->input->post('last_name') != '') {
            $arg_array['last_name'] = $this->input->post('last_name');
        }

        if ($this->input->post('first_name') != '') {
            $arg_array['first_name'] = $this->input->post('first_name');
        }

        $arg_array['schedule_id'] = $schedule_id;
        $data['schedule_id'] = $schedule_id;

        $data['student_data'] = $this->student_model->get_search_stud_by_shedule_id($arg_array);


        $this->output->add_to_position($this->load->view('frontend/emt/search_student_list_view', $data, TRUE), 'student_search_list', TRUE);
        $this->output->template = "emt";
    }

    function student_basic_info() {

        $get_data = $this->input->get();
       
        if (empty($get_data)) {

            $data['student_id'] = $this->session->userdata('student_id');
            $data['schedule_id'] = $this->session->userdata('schedule_id');
        } else {

            $data['student_id'] = base64_decode($get_data['stud_id']);
            $data['schedule_id'] = base64_decode($get_data['schedule_id']);

            $this->session->set_userdata('student_id', $data['student_id']);
            $this->session->set_userdata('schedule_id', $data['schedule_id']);
        }


        $arg_array = array();

        $arg_array['stud_id'] = $data['student_id'];

        $data['student_data'] = $this->student_model->get_search_stud_by_shedule_id($arg_array);

        $stud_array = array('stud_id' => $data['student_id'],
            'schedule_id' => $data['schedule_id']);



        $data['student_info_data'] = $this->student_model->get_stud_basic_info($stud_array);

        $this->increase_step($pcr_data[$inc_id]['pcr_id']);

        $data['schedule_data'] = $this->session->userdata('schedule_info');
        $data['student_top_info_data'] = $data['student_data'];

        $this->output->add_to_position($this->load->view('frontend/emt/student_schedule_info', $data, TRUE), 'schedule_student_top', TRUE);
        $this->output->add_to_position($this->load->view('frontend/emt/student_basic_info_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "emt";
       // $this->increase_step($student_data["student_id"],$student_data["schedule_id"]);
    }

    function save_student_basic_info() {
        $student_data = $this->input->post();
//        var_dump($student_data['schedule_id']);
//        var_dump($student_data['student_id']);
//        die();
        

        $data_vacine = array('bcg_given' => $student_data["bcg_given"],
            'bcg_date' => $student_data["bcg_date"],
            'opv_given' => $student_data["opv_given"],
            'opv_date' => $student_data["opv_date"],
            'hep_b_given' => $student_data["hep_b_given"],
            'hep_b_date' => $student_data["hep_b_date"],
            'opv1_given' => $student_data["opv1_given"],
            'opv1_date' => $student_data["opv1_date"],
            'opv2_given' => $student_data["opv2_given"],
            'opv2_date' => $student_data["opv2_date"],
            'opv3_given' => $student_data["opv3_given"],
            'opv3_date' => $student_data["opv3_date"],
            'ipv_given' => $student_data["ipv_given"],
            'ipv_date' => $student_data["ipv_date"],
            'mmr_one_given' => $student_data["mmr_one_given"],
            'mmr_one_date' => $student_data["mmr_one_date"],
            'je_given' => $student_data["je_given"],
            'je_date' => $student_data["je_date"],
            'mmr_given' => $student_data["mmr_given"],
            'mmr_date' => $student_data["mmr_date"],
            'dpt_given' => $student_data["dpt_given"],
            'dpt_date' => $student_data["dpt_date"],
            'je_vaccine_two_given' => $student_data["je_vaccine_two_given"],
            'je_vaccine_two_date' => $student_data["je_vaccine_two_date"],
            'dpt_2nd_booter_given' => $student_data["dpt_2nd_booter_given"],
            'dpt_2nd_booter_date' => $student_data["dpt_2nd_booter_date"],
            'tt1_given' => $student_data["tt1_given"],
            'tt1_date' => $student_data["tt1_date"],
            'tt2_given' => $student_data["tt2_given"],
            'tt2_date' => $student_data["tt2_date"]);

        $stud_data = array('schedule_id' => $student_data["schedule_id"],
            'student_id' => $student_data["student_id"],
            'past_medicle_history' => $student_data["past_medicle_history"],
            'prev_hospitalization' => $student_data["prev_hospitalization"],
            'current_medication' => $student_data["current_medication"],
            'allergies' => $student_data["allergies"],
            'vacines' => json_encode($data_vacine),
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'),);

        $stud_array = array('stud_id' => $student_data["student_id"],
            'schedule_id' => $student_data["schedule_id"]);

        $student_data_insert = $this->student_model->get_stud_basic_info($stud_array);
        if (empty($student_data_insert)) {
            $insert_student_data = $this->student_model->insert_stud_basic_info($stud_data);
            $this->output->message = "<div class='success'>Details Added successfully<script>$('#PCR_STEPS a[data-pcr_step=2]').click();</script></div>";
        } else {
            $insert_student_data = $this->student_model->update_stud_basic_info($stud_data);
            $this->output->message = "<div class='success'>Details updated successfully<script>$('#PCR_STEPS a[data-pcr_step=2]').click();</script></div>";
        }

        screening_steps($student_data['student_id'],$student_data["schedule_id"], "BASIC");
        $this->increase_step($student_data["student_id"],$student_data["schedule_id"]);
    }

    function student_screening() {

        $get_data = $this->input->get();
        if (empty($get_data)) {

            $data['student_id'] = $this->session->userdata('student_id');
            $data['schedule_id'] = $this->session->userdata('schedule_id');
        } else {

            $data['student_id'] = base64_decode($get_data['stud_id']);
            $data['schedule_id'] = base64_decode($get_data['schedule_id']);

            $this->session->set_userdata('student_id', $data['student_id']);
            $this->session->set_userdata('schedule_id', $data['schedule_id']);
        }

       // $this->increase_step($pcr_data[$inc_id]['pcr_id']);

        $data['birth_effects'] = $this->common_model->get_birth_effects();

        $data['childhood_disease'] = $this->common_model->get_childhood_disease();

        $data['deficienciese'] = $this->common_model->get_deficiencies();
        $data['skin_condition'] = $this->common_model->get_skin_condition();
        $data['orthopedics'] = $this->common_model->get_orthopedics();
        $data['diagnosis'] = $this->common_model->get_diagnosis();
        $data['normal_checkbox'] = $this->common_model->get_normal_checkbox();

        $data['user_ref_id'] = $this->clg->clg_ref_id;

        $stud_array = array('stud_id' => $data["student_id"],
            'schedule_id' => $data["schedule_id"]);

        $data['screening'] = $this->student_model->get_stud_screening($stud_array);
        
        $arg_array['stud_id'] = $data['student_id'];

        $data['student_data'] = $this->student_model->get_search_stud_by_shedule_id($arg_array);

        $this->output->add_to_position($this->load->view('frontend/emt/student_sreening_view', $data, TRUE), $this->post['output_position'], TRUE);
        $this->output->template = "emt";
    }

    function save_student_screening() {

        $student_screening_data = $this->input->post();

        $data['user_ref_id'] = $this->clg->clg_ref_id;

$stud_screen_data = array('student_id' => $student_screening_data["student_id"],
            'schedule_id' => $student_screening_data["schedule_id"],
            'pulse' => $student_screening_data["pulse_radial"],
            'sys_mm' => $student_screening_data["sys_mm"],
            //'sys_hg' => $student_screening_data["sys_hg"],
            'dys_mm' => $student_screening_data["dys_mm"],
            //'dys_hg' => $student_screening_data["dys_hg"],
            'height' => $student_screening_data["height"],
            'weight' => $student_screening_data["weight"],
            'bmi' => $student_screening_data["bmi"],
            'hb' => $student_screening_data["hb"],
            'oxygen_saturation' => $student_screening_data["oxygen_saturation"],
            'rr' => $student_screening_data["asst_rr"],
            'temp' => $student_screening_data["temp"],
            'head' => $student_screening_data["head"],
            'eye' => $student_screening_data["eye"],
            'nose' => $student_screening_data["nose"],
            'hair_color' => $student_screening_data["hair"],
            'hair_density' => $student_screening_data["hair_density"],
            'hair_texture' => $student_screening_data["hair_texture"],
            'alopecia' => $student_screening_data["alopecia"],
            'skin_color' => $student_screening_data["skin_color"],
            'skin_texture' => $student_screening_data["skin_texture"],
            'skin_lesions' => $student_screening_data["skin_lesions"],
            'lips' => $student_screening_data["lips"],
            'gums' => $student_screening_data["gums"],
            'dention' => $student_screening_data["dention"],
            'oral_mucosa' => $student_screening_data["oral_mucosa"],
            'tongue' => $student_screening_data["tongue"],
            //'throat' => $student_screening_data["throat"],
            'neck' => $student_screening_data["neck"],
            'chest' => $student_screening_data["chest"],
            'abdomen' => $student_screening_data["abdomen"],
            'extremity' => $student_screening_data["extremity"],
            'resp_right' => $student_screening_data["resp_right"],
            'resp_left' => $student_screening_data["resp_left"],
            'reflexes' => $student_screening_data["reflexes"],
            'pupils' => $student_screening_data["pupils"],
            'cvs' => $student_screening_data["cvs"],
            'cns' => $student_screening_data["cns"],
            'rombergs' => $student_screening_data["rombergs"],
            'p_a' => $student_screening_data["p_a"],
            'tenderness' => $student_screening_data["tenderness"],
            'guarding' => $student_screening_data["guarding"],
            'joints' => $student_screening_data["joints"],
            'varicose_veins' => $student_screening_data["varicose_veins"],
            'No_swollen_joints' => $student_screening_data["swollen_joint"],
            'reproductive' => $student_screening_data["reproductive"],
            'reproductive_date' => date('Y-m-d',strtotime($student_screening_data["reproductive_date"])),
            'oral_hygiene' => $student_screening_data["oral_hygiene"],
            'carious_tooth' => $student_screening_data["carious_tooth"],
            'fluorosis' => $student_screening_data["fluorosis"],
            'orthodontic_treatment' => $student_screening_data["orthodontic_treatment"],
            'extraction' => $student_screening_data["extraction"],
            'dental_comment' => $student_screening_data["dental_comment"],
            'reffered_specialist' => $student_screening_data["reffered_specialist"]?$student_screening_data["reffered_specialist"]:'',
            'auditary_screening_left' => $student_screening_data["auditary_screening_left"],
            'auditary_screening_right' => $student_screening_data["auditary_screening_right"],
            'vision_screening' => $student_screening_data["vision_screening"],
            'speech_screening' => $student_screening_data["speech_screening"],
            //'vision_with_glasses_right' => $student_screening_data["with_glasses_right"],
            //'vision_with_glasses_left' => $student_screening_data["with_glasses_left"],
            //'vision_without_glasses_right' => $student_screening_data["without_glasses_right"],
           // 'vision_without_glasses_left' => $student_screening_data["without_glasses_left"],
            'color_blindness_left' => $student_screening_data["color_blindness"],
            //'color_blindness_right' => $student_screening_data["color_blindness_right"],
            'vision_screening_comment' => $student_screening_data["vision_screening_comment"],
            'vision_reffered_specialist' => $student_screening_data["vision_reffered_specialist"]?$student_screening_data["vision_reffered_specialist"]:'',
            'language_delay' => $student_screening_data["disability_language_delay"],
            'behavioural_disorder' => $student_screening_data["behavioural_disorder"],
            'disability_comment' => $student_screening_data["disability_comment"],
            'disability_reffered_specialist' => $student_screening_data["disability_reffered_specialist"]?$student_screening_data["disability_reffered_specialist"]:'',
            'birth_deffects' => json_encode($student_screening_data["birth_eff_"]),
            'childhood_disease' => json_encode($student_screening_data["child_dis_"]),
            'deficiencies' => json_encode($student_screening_data["def_"]),
            'skin_condition' => json_encode($student_screening_data["skin_"]),
            'orthopedics' => json_encode($student_screening_data["ortho_"]),
            'checkbox_if_normal' => json_encode($student_screening_data["check_normal_"]),
            'diagnosis' => json_encode($student_screening_data["diagn_"]),
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'));


        $stud_array = array('stud_id' => $student_screening_data["student_id"],
            'schedule_id' => $student_screening_data["schedule_id"]);

  
        
          //          Medical Event save
        $stud_med_screen_data = array('student_id' => $student_screening_data["student_id"],
            'schedule_id' => $student_screening_data["schedule_id"],
            'pulse' => $student_screening_data["pulse_radial"],
            'sys_mm' => $student_screening_data["sys_mm"],
            'dys_mm' => $student_screening_data["dys_mm"],
            'sats' => $student_screening_data["oxygen_saturation"],
            'temp' => $student_screening_data["temp"],
            'resp_right' => $student_screening_data["resp_right"],
            'resp_left' => $student_screening_data["resp_left"],
            'reflexes' => $student_screening_data["reflexes"],
            'pupils' => $student_screening_data["pupils"],
            'cvs' => $student_screening_data["cvs"],
            'cns' => $student_screening_data["cns"],
            'ascitis' => $student_screening_data["ascitis"],
            'rombergs' => $student_screening_data["rombergs"],
            'p_a' => $student_screening_data["p_a"],
            'tenderness' => $student_screening_data["tenderness"],
            'guarding' => $student_screening_data["guarding"],
            'joints' => $student_screening_data["joints"],
            'varicose_veins' => $student_screening_data["varicose_veins"],
            'No_swollen_joints' => $student_screening_data["swollen_joint"],
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'));


//        dental screen save data
        $dental_data = array(
            'schedule_id' => $student_screening_data['schedule_id'],
            'student_id' => $student_screening_data['student_id'],
            'oral_hygiene' => $student_screening_data['oral_hygiene'],
            'carious_teeth' => $student_screening_data['carious_tooth'],
            'orthodontic_treatment' => $student_screening_data['orthodontic_treatment'],
            'extraction_done' => $student_screening_data['extraction'],
            'fluorosis' => $student_screening_data['fluorosis'],
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'));
       
        

        $stud_array = array('stud_id' => $student_screening_data["student_id"],
            'schedule_id' => $student_screening_data["schedule_id"]);

        $stud_medicle_exam = $this->emt_model->get_stud_medicle_exam($stud_array);
       

        if (empty($stud_medicle_exam)) {
            $insert_student_data = $this->emt_model->insert_stud_medicle_exam($stud_med_screen_data);
            
        } else {
            $insert_student_data = $this->emt_model->update_stud_medicle_exam($stud_med_screen_data); 
        }
        //dental screen 
        $student_dental_data = $this->emt_model->get_stud_dental($stud_array);


        if (empty($student_dental_data)) {
            $insert_student_data = $this->emt_model->insert_stud_dental($dental_data);
         
        } else {
            $insert_student_data = $this->emt_model->update_stud_dental($dental_data);
          
        }

        $student_screening_data_insert = $this->student_model->get_stud_screening($stud_array);
        
        $update_stud_args = array('stud_id' =>$student_screening_data["student_id"],
                                  'stud_status' => '1');
                
        $insert_student = $this->student_model->updte_student_details($update_stud_args,$update_stud_args);
        
        if (empty($student_screening_data_insert)) {
            $insert_student_data = $this->student_model->insert_stud_screening($stud_screen_data);
            $this->output->message = "<div class='success'>Details Added successfully<script>$('#PCR_STEPS a[data-pcr_step=3]').click();</script></div>";
        } else {
            $insert_student_data = $this->student_model->update_stud_screening($stud_screen_data);
            $this->output->message = "<div class='success'>Details updated successfully<script>$('#PCR_STEPS a[data-pcr_step=3]').click();</script></div>";
        }
        
        screening_steps($student_screening_data["student_id"],$student_screening_data["schedule_id"], "SCREEN");
        $this->increase_step($student_screening_data["student_id"],$student_screening_data["schedule_id"]);
    }

    function dental() {

        $get_data = $this->input->get();
        if (empty($get_data)) {

            $data['student_id'] = $this->session->userdata('student_id');
            $data['schedule_id'] = $this->session->userdata('schedule_id');
        } else {

            $data['student_id'] = base64_decode($get_data['stud_id']);
            $data['schedule_id'] = base64_decode($get_data['schedule_id']);

            $this->session->set_userdata('student_id', $data['student_id']);
            $this->session->set_userdata('schedule_id', $data['schedule_id']);
        }

        //$this->increase_step($pcr_data[$inc_id]['pcr_id']);
                $stud_array = array('stud_id' => $data["student_id"],
            'schedule_id' => $data["schedule_id"]);

        $data['student_dental_data'] = $this->emt_model->get_stud_dental($stud_array);

        $this->output->add_to_position($this->load->view('frontend/emt/student_dental_view', $data, TRUE), $this->post['output_position'], TRUE);
        $this->output->template = "emt";
    }

    function save_dental() {

        $dental_screening_data = $this->input->post();

        $data['user_ref_id'] = $this->clg->clg_ref_id;

        $dental_data = array(
            'schedule_id' => $dental_screening_data['schedule_id'],
            'student_id' => $dental_screening_data['student_id'],
            'oral_hygiene' => $dental_screening_data['oral_hygiene']?$dental_screening_data['oral_hygiene']:'',
            'gum_condition' => $dental_screening_data['gum_condition']?$dental_screening_data['gum_condition']:'',
            'oral_ulcers' => $dental_screening_data['oral_ulcers']?$dental_screening_data['oral_ulcers']:'',
            'gum_bleeding' => $dental_screening_data['gum_bleeding']?$dental_screening_data['gum_bleeding']:'',
            'sensitive_teeth' => $dental_screening_data['sensitive_teeth']?$dental_screening_data['sensitive_teeth']:'',
            'discoloration_of_teeth' => $dental_screening_data['discoloration_of_teeth']?$dental_screening_data['discoloration_of_teeth']:'',
            'food_impaction' => $dental_screening_data['food_impaction']?$dental_screening_data['food_impaction']:'',
            'carious_teeth' => $dental_screening_data['carious_teeth']?$dental_screening_data['carious_teeth']:'',
            'malalignment' => $dental_screening_data['malalignment']?$dental_screening_data['malalignment']:'',
            'orthodontic_treatment' => $dental_screening_data['orthodontic_treatment']?$dental_screening_data['orthodontic_treatment']:'',
            'extraction_done' => $dental_screening_data['extraction_done']?$dental_screening_data['extraction_done']:'',
            'tooth_brushing_frequency' => $dental_screening_data['tooth_brushing_frequency']?$dental_screening_data['tooth_brushing_frequency']:'',
            'dental_comment' => $dental_screening_data['dental_comment'],
            'dental_treatment_given' => $dental_screening_data['dental_treatment_given'],
            'oral_hygiene_text' => $dental_screening_data['oral_hygiene_text'],
            'gum_condition_text' => $dental_screening_data['gum_condition_text'],
            'oral_ulcers_text' => $dental_screening_data['oral_ulcers_text'],
            'gum_bleeding_text' => $dental_screening_data['gum_bleeding_text'],
            'sensitive_teeth_text' => $dental_screening_data['sensitive_teeth_text'],
            'discoloration_of_teeth_text' => $dental_screening_data['discoloration_of_teeth_text'],
            'food_impaction_text' => $dental_screening_data['food_impaction_text'],
            'carious_teeth_text' => $dental_screening_data['carious_teeth_text'],
            'malalignment_text' => $dental_screening_data['malalignment_text'],
            'orthodontic_treatment_text' => $dental_screening_data['orthodontic_treatment_text'],
            'extraction_done_text' => $dental_screening_data['extraction_done_text'],
            'tooth_brushing_frequency_text' => $dental_screening_data['tooth_brushing_frequency_text'],
            'fluorosis' => $dental_screening_data["fluorosis"]?$dental_screening_data['fluorosis']:'',
            'fluorosis_text' => $dental_screening_data["fluorosis_text"],
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s')
        );




        $stud_array = array('stud_id' => $dental_screening_data["student_id"],
            'schedule_id' => $dental_screening_data["schedule_id"]);

        $student_dental_data = $this->emt_model->get_stud_dental($stud_array);

        if (empty($student_dental_data)) {
            $insert_student_data = $this->emt_model->insert_stud_dental($dental_data);
            $this->output->message = "<div class='success'>Details Added successfully <script>$('#PCR_STEPS a[data-pcr_step=4]').click();</script></div>";
        } else {
            $insert_student_data = $this->emt_model->update_stud_dental($dental_data);
            $this->output->message = "<div class='success'>Details updated successfully <script>$('#PCR_STEPS a[data-pcr_step=4]').click();</script></div>";
        }

        screening_steps($dental_screening_data["student_id"],$dental_screening_data["schedule_id"], "DENTAL");
        $this->increase_step($student_data["student_id"],$student_data["schedule_id"]);
    }

    function vision() {

        $get_data = $this->input->get();
        if (empty($get_data)) {

            $data['student_id'] = $this->session->userdata('student_id');
            $data['schedule_id'] = $this->session->userdata('schedule_id');
        } else {

            $data['student_id'] = base64_decode($get_data['stud_id']);
            $data['schedule_id'] = base64_decode($get_data['schedule_id']);

            $this->session->set_userdata('student_id', $data['student_id']);
            $this->session->set_userdata('schedule_id', $data['schedule_id']);
        }

        $stud_array = array('stud_id' => $student_data["student_id"],
            'schedule_id' => $student_data["schedule_id"]);

        $data['student_vison_data'] = $this->emt_model->get_stud_vision($stud_array);

        $this->increase_step($pcr_data[$inc_id]['pcr_id']);

        $data['opthalmological'] = $this->common_model->get_opthalmological();
        $this->output->add_to_position($this->load->view('frontend/emt/student_vision_view', $data, TRUE), $this->post['output_position'], TRUE);
        $this->output->template = "emt";
    }

    function save_vision() {
        $vision_screening_data = $this->input->post();
     //   var_dump($vision_screening_data);
     //   die();
     



        $data['user_ref_id'] = $this->clg->clg_ref_id;

        $vision_data = array(
            'schedule_id' => $vision_screening_data['schedule_id'],
            'student_id' => $vision_screening_data['student_id'],
            'refractive_error' => $vision_screening_data['refractive_error'],
            'eye_muscle_control' => json_encode($vision_screening_data['eye_muscle_control']),
            'visual_perimetry' => $vision_screening_data['visual_perimetry'],
            'vision_comment' => $vision_screening_data['vision_comment'],
            'vision_treatment' => $vision_screening_data['vision_treatment'],
            //'without_glasses_left' => $vision_screening_data['without_glasses_left'],
            //'without_glasses_right' => $vision_screening_data['without_glasses_right'],
           // 'with_glasses_right' => $vision_screening_data['with_glasses_right'],
           // 'with_glasses_left' => $vision_screening_data['with_glasses_left'],
            'opthalmological' => json_encode($vision_screening_data["opthalmological_"]),
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s')
        );




        $stud_array = array('stud_id' => $vision_screening_data["student_id"],
            'schedule_id' => $vision_screening_data["schedule_id"]);

        $student_dental_data = $this->emt_model->get_stud_vision($stud_array);


        if (empty($student_dental_data)) {
            $insert_student_data = $this->emt_model->insert_stud_vision($vision_data);
            $this->output->message = "<div class='success'>Details Added successfully<script>$('#PCR_STEPS a[data-pcr_step=5]').click();</script></div>";
        } else {
            $insert_student_data = $this->emt_model->update_stud_vision($vision_data);
            $this->output->message = "<div class='success'>Details updated successfully<script>$('#PCR_STEPS a[data-pcr_step=5]').click();</script></div>";
        }
        
        screening_steps($vision_screening_data["student_id"],$vision_screening_data["schedule_id"], "VISION");
        $this->increase_step($vision_screening_data["student_id"],$vision_screening_data["schedule_id"]);
    }

    function auditary() {

        $get_data = $this->input->get();
        if (empty($get_data)) {

            $data['student_id'] = $this->session->userdata('student_id');
            $data['schedule_id'] = $this->session->userdata('schedule_id');
        } else {

            $data['student_id'] = base64_decode($get_data['stud_id']);
            $data['schedule_id'] = base64_decode($get_data['schedule_id']);

            $this->session->set_userdata('student_id', $data['student_id']);
            $this->session->set_userdata('schedule_id', $data['schedule_id']);
        }

        $stud_array = array('stud_id' => $data["student_id"],
            'schedule_id' => $data["schedule_id"]);

        $data['student_ent_data'] = $this->emt_model->get_stud_ent($stud_array);

        $this->increase_step($pcr_data[$inc_id]['pcr_id']);
        $data['auditary'] = $this->common_model->get_auditary();
       
        
        $this->output->add_to_position($this->load->view('frontend/emt/student_auditary_view', $data, TRUE), $this->post['output_position'], TRUE);
        $this->output->template = "emt";
    }

    function save_auditary() {
        $auditary_screening_data = $this->input->post();



        $data['user_ref_id'] = $this->clg->clg_ref_id;

        $dental_data = array(
            'schedule_id' => $auditary_screening_data['schedule_id'],
            'student_id' => $auditary_screening_data['student_id'],
            'hearing_left' => $auditary_screening_data['hearing_left'],
            'hearing_right' => $auditary_screening_data['hearing_right'],
            'otoscopic_exam' => $auditary_screening_data['otoscopic_exam'],
            'ent_comment' => $auditary_screening_data['ent_comment'],
            'treatment_given' => $auditary_screening_data['ent_treatment'],
            'ent_check_if_present' => json_encode($auditary_screening_data["auditary_"]),
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s')
        );

        $stud_array = array('stud_id' => $auditary_screening_data["student_id"],
            'schedule_id' => $auditary_screening_data["schedule_id"]);

        $student_auditory_data = $this->emt_model->get_stud_ent($stud_array);

        if (empty($student_auditory_data)) {
            $insert_student_data = $this->emt_model->insert_stud_ent($dental_data);
            $this->output->message = "<div class='success'>Details Added successfully<script>$('#PCR_STEPS a[data-pcr_step=6]').click();</script></div>";
        } else {
            $insert_student_data = $this->emt_model->update_stud_ent($dental_data);
            $this->output->message = "<div class='success'>Details Update successfully<script>$('#PCR_STEPS a[data-pcr_step=6]').click();</script></div>";
        }
        
        screening_steps($auditary_screening_data["student_id"],$auditary_screening_data["schedule_id"], "AUD");
        $this->increase_step($auditary_screening_data["student_id"],$auditary_screening_data["schedule_id"]);
    }

    function medicle_events() {

        $get_data = $this->input->get();
        if (empty($get_data)) {

            $data['student_id'] = $this->session->userdata('student_id');
            $data['schedule_id'] = $this->session->userdata('schedule_id');
        } else {

            $data['student_id'] = base64_decode($get_data['stud_id']);
            $data['schedule_id'] = base64_decode($get_data['schedule_id']);

            $this->session->set_userdata('student_id', $data['student_id']);
            $this->session->set_userdata('schedule_id', $data['schedule_id']);
        }

        $stud_array = array('stud_id' => $data["stud_id"],
            'schedule_id' => $data["schedule_id"]);

        $data['medical_data'] = $this->emt_model->get_stud_medicle_exam($stud_array);
        
        $data['ins_procedure'] = $this->common_model->get_mas_diagonosis(array('diagnosis_id'=>$data['medical_data'][0]->diagnosis_name));

        $this->increase_step($pcr_data[$inc_id]['pcr_id']);

        $this->output->add_to_position($this->load->view('frontend/emt/student_medicle_events_view', $data, TRUE), $this->post['output_position'], TRUE);
        $this->output->template = "emt";
    }

    function save_medicle_events() {
        $medicle_events_data = $this->input->post();
       

        $medical_data = array(
            'schedule_id' => $medicle_events_data['schedule_id'],
            'student_id' => $medicle_events_data['student_id'],
            'chief_complaint' => $medicle_events_data['chief_complaint'],
            'pulse' => $medicle_events_data['pulse'],
            'sys_mm' => $medicle_events_data["sys_mm"],
            'sys_hg' => $medicle_events_data["sys_hg"],
            'dys_mm' => $medicle_events_data["dys_mm"],
            'dys_hg' => $medicle_events_data["dys_hg"],
            'edema' => $medicle_events_data['edema'],
            'pallor' => $medicle_events_data['pallor'],
            'temp' => $medicle_events_data['temp'],
            'sats' => $medicle_events_data['sats'],
            'lymphadenopathy' => $medicle_events_data['lymphadenopathy'],
            'icterus' => $medicle_events_data['icterus'],
            'cvs' => $medicle_events_data['cvs'],
            'cns' => $medicle_events_data['cns'],
            'reflexes' => $medicle_events_data['reflexes'],
            'pupils' => $medicle_events_data['pupils'],
            'resp_right' => $medicle_events_data['resp_right'],
            'resp_left' => $medicle_events_data['resp_left'],
            'rombergs' => $medicle_events_data['rombergs'],
            'p_a' => $medicle_events_data['p_a'],
            'tenderness' => $medicle_events_data['tenderness'],
            'guarding' => $medicle_events_data['guarding'],
            'ascitis' => $medicle_events_data['ascitis'],
            'diagnosis_name' => $medicle_events_data['diagnosis_name'],
            'joints' => $medicle_events_data['joints'],
            'varicose_veins' => $medicle_events_data['varicose_veins'],
            'No_swollen_joints' => $medicle_events_data['No_swollen_joints'],
            'other_signs' => $medicle_events_data['other_signs'],
            'symptoms' => $medicle_events_data['symptoms'],
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s')
        );
        

        $stud_array = array('stud_id' => $medicle_events_data["student_id"],
            'schedule_id' => $medicle_events_data["schedule_id"]);



        $stud_medicle_exam = $this->emt_model->get_stud_medicle_exam($stud_array);
       

        if (empty($stud_medicle_exam)) {
            $insert_student_data = $this->emt_model->insert_stud_medicle_exam($medical_data);
            if($medicle_events_data['type']=='transper_hospital'){
                $this->output->message = "<div class='success'>Details Added successfully <script>$('#PCR_STEPS a[data-pcr_step=9]').click();</script></div>";
            }else if($medicle_events_data['type']=='prescription'){
                $this->output->message = "<div class='success'>Details Added successfully <script>$('#PCR_STEPS a[data-pcr_step=8]').click();</script></div>";
            }
            
        } else {
            $insert_student_data = $this->emt_model->update_stud_medicle_exam($medical_data);
            if($medicle_events_data['type']=='transper_hospital'){
                $this->output->message = "<div class='success'>Details Updated successfully <script>$('#PCR_STEPS a[data-pcr_step=9]').click();</script></div>";
            }else if($medicle_events_data['type']=='prescription'){
                $this->output->message = "<div class='success'>Details Updated successfully <script>$('#PCR_STEPS a[data-pcr_step=8]').click();</script></div>";
            }
            
        }
        screening_steps($medicle_events_data["student_id"],$medicle_events_data["schedule_id"], "MED");
        $this->increase_step($medicle_events_data["student_id"],$medicle_events_data["schedule_id"]);
    }

    function sick_room() {
        $data['student_id'] = $this->session->userdata('student_id');
        $data['schedule_id'] = $this->session->userdata('schedule_id');


        $stud_array = array('stud_id' => $data["student_id"],
            'schedule_id' => $data["schedule_id"]);

        $data['stud_sickroom'] = $this->emt_model->get_stud_sickroom($stud_array);


        $this->output->add_to_position($this->load->view('frontend/emt/student_sick_room_view', $data, TRUE), 'popup_div', TRUE);
    }

    function save_sickroom() {
        $sickroom_data = $this->input->post();



        $data['user_ref_id'] = $this->clg->clg_ref_id;

        $sickroom = array(
            'schedule_id' => $sickroom_data['schedule_id'],
            'student_id' => $sickroom_data['student_id'],
            'doctor_note' => $sickroom_data['doctor_note'],
            'treatment_order' => $sickroom_data['treatment_order'],
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s')
        );




        $stud_array = array('stud_id' => $student_data["student_id"],
            'schedule_id' => $student_data["schedule_id"]);

        $student_dental_data = $this->emt_model->get_stud_sickroom($stud_array);

        if (empty($student_dental_data)) {
            $insert_student_data = $this->emt_model->insert_stud_sickroom($sickroom);
            $this->output->status = 1;
            $this->output->closepopup = "yes";
            $this->output->message = "<div class='success'>Details Added successfully</div>";
        } else {
            $insert_student_data = $this->emt_model->update_stud_sickroom($sickroom);
            $this->output->status = 1;
            $this->output->closepopup = "yes";
            $this->output->message = "<div class='success'>Details updated successfully</div>";
        }
    }

    function investigation() {
        
        $get_data = $this->input->get();
        if (empty($get_data)) {

            $data['student_id'] = $this->session->userdata('student_id');
            $data['schedule_id'] = $this->session->userdata('schedule_id');
        } else {

            $data['student_id'] = base64_decode($get_data['stud_id']);
            $data['schedule_id'] = base64_decode($get_data['schedule_id']);

            $this->session->set_userdata('student_id', $data['student_id']);
            $this->session->set_userdata('schedule_id', $data['schedule_id']);
        }

        $stud_array = array('stud_id' => $data["stud_id"],
            'schedule_id' => $data["schedule_id"]);

        $data['stud_investigation'] = $this->emt_model->get_stud_investigation($stud_array);
        
        $this->increase_step($pcr_data[$inc_id]['pcr_id']);

        $data['test'] = $this->common_model->get_tests();
        $data['selected_test_list'] = $this->session->userdata('selected_test');


        $this->output->add_to_position($this->load->view('frontend/emt/student_investigation_view', $data, TRUE), $this->post['output_position'], TRUE);
        $this->output->template = "emt";
    }
   public function save_investigation() {
       
        $investigation_screen_data = $this->input->post();
        $investigation_data = array(
            'schedule_id' => $investigation_screen_data['schedule_id'],
            'student_id' => $investigation_screen_data['student_id'],
            'test_title' => json_encode($investigation_screen_data["test"]),
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s')
        );

        $stud_array = array('stud_id' => $investigation_screen_data["student_id"],
            'schedule_id' => $investigation_screen_data["schedule_id"]);

        $student_investigation_screen = $this->emt_model->get_stud_investigation($stud_array);


        if (empty($student_investigation_screen)) {
            $insert_student_data = $this->emt_model->insert_stud_investigation($investigation_data);
            $this->output->message = "<div class='success'>Details Added successfully</div>";
        } else {
            $insert_student_data = $this->emt_model->update_stud_investigation($investigation_data);
            $this->output->message = "<div class='success'>Details Updated successfully</div>";
        }
    }

    function prescription() {
        $get_data = $this->input->get();
        if (empty($get_data)) {

            $data['student_id'] = $this->session->userdata('student_id');
            $data['schedule_id'] = $this->session->userdata('schedule_id');
        } else {

            $data['student_id'] = base64_decode($get_data['stud_id']);
            $data['schedule_id'] = base64_decode($get_data['schedule_id']);

            $this->session->set_userdata('student_id', $data['student_id']);
            $this->session->set_userdata('schedule_id', $data['schedule_id']);
        }

        $stud_array = array('stud_id' => $data["student_id"],
            'schedule_id' => $data["schedule_id"]);

        $data['medical_data'] = $this->emt_model->get_stud_medicle_exam($stud_array);
        
         $data['ins_procedure'] = $this->common_model->get_mas_diagonosis(array('diagnosis_id'=>$data['medical_data'][0]->diagnosis_name));
        $this->increase_step($pcr_data[$inc_id]['pcr_id']);

        $data['drugs'] = $this->common_model->get_drugs($$args);

        $this->output->add_to_position($this->load->view('frontend/emt/student_prescription_view', $data, TRUE), $this->post['output_position'], TRUE);
        $this->output->template = "emt";
    }
    public function save_prescription() {
        $prescription_data = $this->input->post();

        $prescription_info = array(
            'schedule_id' => $prescription_data['schedule_id'],
            'student_id' => $prescription_data['student_id'],
            'drug_details' =>  json_encode($prescription_data['drug']),
            'diagnosis_name' => $prescription_data['diagnosis_name'],
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s')
        );

        $stud_array = array('stud_id' => $prescription_data["student_id"],
            'schedule_id' => $prescription_data["schedule_id"]);



        $stud_prescription = $this->emt_model->get_stud_prescription($stud_array);


        if (empty($stud_prescription)) {
            $insert_student_data = $this->emt_model->insert_stud_prescription($prescription_info);
        } else {
            $insert_student_data = $this->emt_model->update_stud_prescription($prescription_info);
        }
    }


    function hospitalisation() {
        $get_data = $this->input->get();
        if (empty($get_data)) {

            $data['student_id'] = $this->session->userdata('student_id');
            $data['schedule_id'] = $this->session->userdata('schedule_id');
        } else {

            $data['student_id'] = base64_decode($get_data['stud_id']);
            $data['schedule_id'] = base64_decode($get_data['schedule_id']);

            $this->session->set_userdata('student_id', $data['student_id']);
            $this->session->set_userdata('schedule_id', $data['schedule_id']);
        }
        $stud_array = array('stud_id' => $data["student_id"],
            'schedule_id' => $data["schedule_id"]);
        

        $data['medical_data'] = $this->emt_model->get_stud_medicle_exam($stud_array);

        
        $data['ins_procedure'] = $this->common_model->get_mas_diagonosis(array('diagnosis_id'=>$data['medical_data'][0]->diagnosis_name));
        
        $data['stud_hospitalizaion'] = $this->emt_model->get_stud_hospitalizaion($stud_array);
  
        $this->increase_step($pcr_data[$inc_id]['pcr_id']);

        $this->output->add_to_position($this->load->view('frontend/emt/student_hospitalisation_view', $data, TRUE), $this->post['output_position'], TRUE);
        $this->output->template = "emt";
    }
    function save_hospitalization(){
        $hospitalization_data = $this->input->post();


        $hospitalization_info = array(
            'schedule_id' => $hospitalization_data['schedule_id'],
            'student_id' => $hospitalization_data['student_id'],
            'diagnosis_name' => $hospitalization_data['diagnosis_name'],
            'brief_history' => $hospitalization_data['brief_history'],
            'insurance' => $hospitalization_data['insurance'],
            'insurance_procedure' => $hospitalization_data['insurance_procedure'],
            'hosp' => $hospitalization_data['hosp'],
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s')
        );

        $stud_array = array('stud_id' => $prescription_data["student_id"],
            'schedule_id' => $prescription_data["schedule_id"]);



        $stud_hospitalizaion = $this->emt_model->get_stud_hospitalizaion($stud_array);


        if (empty($stud_hospitalizaion)) {
            $insert_student_data = $this->emt_model->insert_stud_hospitalizaion($hospitalization_info);
            $this->output->message = "<div class='success'>Details Added successfully</div>";
        } else {
            $insert_student_data = $this->emt_model->update_stud_hospitalizaion($hospitalization_info);
            $this->output->message = "<div class='success'>Details Updated successfully</div>";
        }
    }
    function healthcard() {
        $this->increase_step($pcr_data[$inc_id]['pcr_id']);

        $this->output->add_to_position($this->load->view('frontend/emt/student_healthcard_view', $data, TRUE), $this->post['output_position'], TRUE);
        $this->output->template = "emt";
    }

    function increase_step($student_id='',$schedule_id='') {

        if ($student_id) {

            $screening_steps = $this->emt_model->get_sreening_steps(array('student_id' => $student_id,'schedule_id'=>$schedule_id));

            $data['steps_cnt'] = $this->steps_cnt;

            if ($screening_steps[0]->screening_steps != '') {

                $data['step_com'] = explode(",", $screening_steps[0]->screening_steps);

                $data['step_com_cnt'] = count($data['step_com']);
            }


            $this->output->add_to_position($this->load->view('frontend/emt/progressbar_view', $data, TRUE), "pcr_progressbar", TRUE);
        }



        $this->output->add_to_position($this->load->view('frontend/emt/pcr_top_steps_view', $data, TRUE), "pcr_top_steps", TRUE);
    }

    function get_selected_test() {


        $args = array(
            'test_id' => $this->input->post('test_id'),
        );

        $res = $this->common_model->get_tests($args);

        $test_title = $res[0]->test_title;
        $test_id = $res[0]->id;

        $str = '\"';

        $res_tpl = "<tr id='row_$test_id'><td>$test_title</td><td><div id='removebutton_$test_id' class='remove_button'></div></td></tr>";


        //////////////////////////////////////////////////////////////////////////////
        //$this->session->set_userdata('selected_test', '');

        $selected_test_list = $this->session->userdata('selected_test');

        if ($selected_test_list == '') {
            $selected_test_list = array();
        }

        if (isset($selected_test_list[$res[0]->id])) {
            $script = "<script></script>";
        } else {
            $selected_test_list[$res[0]->id] = array('id' => $res[0]->id, 'test_name' => $res[0]->test_title);

            $inp_tpl = "<input type='hidden' name='test[$test_id][id][]' value='$test_id'><input type='hidden' name='test[$test_id][test_name][]' value='$test_title'>";
            $script = "<script>$('.investigation_test').show().append(\"" . $inp_tpl . "\");$('.investigation_test table').append(\"" . $res_tpl . "\");</script>";
            //$script = "<script>$('.investigation_test table').append(\"" . $res_tpl . "\");</script>";
        }

        $this->session->set_userdata('selected_test', $selected_test_list);

        $this->output->add_to_position($script, 'custom_script', TRUE);
    }

    function remove_test() {

        $div_id = $this->input->post();
        $div = $div_id['test_id'];
        $remove_div = "<script>$( 'tr#row_" . $div . "' ).remove();</script>";
        $data['med_qty_script'] = $remove_div;
        $type = $div;
        //var_dump($type);



        $med_selected_qty_inv_list = $this->session->userdata('selected_test');
        unset($med_selected_qty_inv_list[$type]);



        $this->output->add_to_position($remove_div, "custom_script", TRUE);
        $this->output->template = "";
        //die();
    }

}
