<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Emt extends EMS_Controller {

    function __construct() {

        parent::__construct();

        header('Access-Control-Allow-Origin: *');


         $this->active_module = "M-CLG";

        $this->pg_limit = $this->config->item('pagination_limit');

        $this->pg_limits = $this->config->item('report_clg');

        $this->allow_img_type = $this->config->item('upload_image_types');

        $this->dummy_csv = $this->config->item('dummy_csv_contact_file');

        $this->upload_path = $this->config->item('upload_path');

        $this->upload_image_size = $this->config->item('upload_image_size');

        $this->clg_pic_config = $this->config->item('clg_pic');

        $this->clg_pic_resize_config = $this->config->item('clg_pic_resize');

        $this->clg_rsm_config = $this->config->item('clg_rsm');

        $this->upload_rsm_type = $this->config->item('upload_rsm_types');

        $this->reply_mail = $this->config->item('reply_mail');

        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));
        $this->load->model(array('pet_model', 'add_res_model', 'colleagues_model', 'inc_model', 'amb_model', 'pcr_model', 'call_model', 'medadv_model', 'student_model', 'school_model', 'schedule_model', 'emt_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper', 'language_helper'));


        $this->post = $this->input->get_post(NULL);
        $this->post['base_month'] = get_base_month();

        $this->clg = $this->session->userdata('current_user');

        $this->pg_limit = $this->config->item('pagination_limit_clg');
        $this->pg_limits = $this->config->item('report_clg');

        $this->steps_cnt = $this->config->item('pcr_steps');

        $this->today = date('Y-m-d H:i:s');
    }

    public function screen_schedule() {
        $page_no = 1;
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }

        $data['get_count'] = TRUE;
        $data['schedule_isaprove'] = '1';

        $data['total_count'] = $this->schedule_model->get_schedule_data($data);

        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        $scheduleflt['SCHEDULE'] = $data;

        $this->session->set_userdata('filters', $scheduleflt);

        unset($data['get_count']);


        $result = $this->schedule_model->get_schedule_data($data, $offset, $limit);

        $shedule = array();

        foreach ($result as $result_data) {
            $school_arg = array('school_id' => $result_data->schedule_schoolid);
            $school_data = $this->school_model->get_school_data($school_arg);
            $result_data->school_name = $school_data[0]->school_name;

            $result_data->schedule_time = date('g A', strtotime($result_data->schedule_time));
            $result_data->schedule_date = date("d-m-y", strtotime($result_data->schedule_date));
            $result_data->schedule_month = date("M", strtotime($result_data->schedule_date));
            $shedule[] = $result_data;
        }

        $return['student'] = $shedule;
        echo json_encode($return);
        exit();
    }

    public function student_school_info() {
        $schedule_id = $this->input->post('schedule_id');

        $data['schedule_id'] = $schedule_id;


        $this->output->add_to_position($this->load->view('frontend/emt/search_student_view', $data, TRUE), $this->post['output_position'], TRUE);

        $arg_array = array('schedule_id' => $schedule_id);


        $schedule = $this->schedule_model->get_schedule_data($arg_array);

        $data['student_data'] = $this->student_model->get_search_stud_by_shedule_id($arg_array);

        $data['schedule_data'] = array('schedule_date' => date('d-M-Y', strtotime($schedule[0]->schedule_date)),
            'schedule_time' => date('g A', strtotime($schedule[0]->schedule_time)),
            'school_name' => $schedule[0]->school_name);


        $return['student_top_info_data'] = $data['schedule_data'];
        echo json_encode($return);
        exit();
    }

    function update_stud_status() {

        $student_data = $this->input->post();


        $student = $this->student_model->update_stud_status($student_data);

        $msg = "Screening Completed!!";
        echo json_encode($msg);
        exit();
    }

    public function student_search() {

        $schedule_id = $this->input->post('schedule_id', TRUE);

        $arg_array = array();

        if ($this->input->post('student_registration', TRUE) != '') {
            $arg_array['reg_no'] = $this->input->post('student_registration', TRUE);
        }

        if ($this->input->post('last_name', TRUE) != '') {
            $arg_array['last_name'] = $this->input->post('last_name', TRUE);
        }

        if ($this->input->post('first_name', TRUE) != '') {
            $arg_array['first_name'] = $this->input->post('first_name', TRUE);
        }

        $arg_array['schedule_id'] = $schedule_id;
        $data['schedule_id'] = $schedule_id;

        $schedule = $this->schedule_model->get_schedule_data($arg_array);
        $data['student_data'] = $this->student_model->get_search_stud_by_shedule_id($arg_array);


        $data['schedule_data'] = array('schedule_date' => date('d-M-Y', strtotime($schedule[0]->schedule_date)),
            'schedule_time' => date('g A', strtotime($schedule[0]->schedule_time)),
            'school_name' => $schedule[0]->school_name,
            'schedule_id' => $schedule[0]->schedule_id,);



        foreach ($data['student_data'] as $key => $value) {

            $student_data['stud_sr_no'] = $key + 1;
            $student_data['stud_id'] = $value->stud_id;
            $student_data['stud_first_name'] = $value->stud_first_name;
            $student_data['stud_last_name'] = $value->stud_last_name;
            $student_data['stud_reg_no'] = $value->stud_reg_no;
            $student_data['schd_school_id'] = $value->schd_school_id;
            $student_data['schedule_id'] = $schedule[0]->schedule_id;
            $student_search_data[] = $student_data;
        }

        $return['student'] = $student_search_data;

        $return['student_top_info_data'] = $data['schedule_data'];

        echo json_encode($return);
        exit();
    }

    function student_search_screening_completed() {
        $schedule_id = $this->input->post('schedule_id', TRUE);
        $arg_array['schedule_id'] = $schedule_id;
        $data['schedule_id'] = $schedule_id;

        $schedule = $this->schedule_model->get_schedule_data($arg_array);
        $data['student_data'] = $this->student_model->get_search_stud_by_shedule_id($arg_array);

        $data['schedule_data'] = array('schedule_date' => date('d-M-Y', strtotime($schedule[0]->schedule_date)),
            'schedule_time' => date('g A', strtotime($schedule[0]->schedule_time)),
            'school_name' => $schedule[0]->school_name,
            'schedule_id' => $schedule[0]->schedule_id,);



        foreach ($data['student_data'] as $key => $value) {

            $student_data['stud_sr_no'] = $key + 1;
            $student_data['stud_id'] = $value->stud_id;
            $student_data['stud_first_name'] = $value->stud_first_name;
            $student_data['stud_last_name'] = $value->stud_last_name;
            $student_data['stud_reg_no'] = $value->stud_reg_no;
            $student_data['schd_school_id'] = $value->schd_school_id;
            $student_data['schedule_id'] = $schedule[0]->schedule_id;
            $student_search_data[] = $student_data;
        }

        $return['student'] = $student_search_data;

        $return['student_top_info_data'] = $data['schedule_data'];

        echo json_encode($return);
        exit();
    }

    public function student_basic_info() {
        $data['schedule_id'] = $this->input->post('schedule_id', TRUE);

        $data['stud_id'] = $this->input->post('stud_id', TRUE);
//
//        $arg_array = array();
//
//        $arg_array['stud_id'] = $data['stud_id'];


        $stud_array = array('stud_id' => $data['stud_id'],
            'schedule_id' => $data['schedule_id']);

        $stud['student_data'] = $this->student_model->get_search_stud_by_shedule_id($stud_array);

        $stud_array = array('stud_id' => $data['stud_id'], 'schedule_id' => $data['schedule_id']);

        $stud['student_info_data'] = $this->student_model->get_stud_basic_info($stud_array);



//        $return['student_basic_info'] = $stud;


        echo json_encode($stud);

        exit();
    }

    public function student_basic_info_save() {
        $student_data = $this->input->post();

        $data_vacine = array('bcg_given' => $student_data["vacinne"]["bcg"]["given"],
            'bcg_date' => $student_data["vacinne"]["bcg"]["date"],
            'opv_given' => $student_data["vacinne"]["OPV0"]["given"],
            'opv_date' => $student_data["vacinne"]["OPV0"]["date"],
            'hep_b_given' => $student_data["vacinne"]["hep_b"]["given"],
            'hep_b_date' => $student_data["vacinne"]["hep_b"]["date"],
            'opv1_given' => $student_data["vacinne"]["opv1"]["given"],
            'opv1_date' => $student_data["vacinne"]["opv1"]["date"],
            'opv2_given' => $student_data["vacinne"]["opv2"]["given"],
            'opv2_date' => $student_data["vacinne"]["opv2"]["date"],
            'opv3_given' => $student_data["vacinne"]["opv3"]["given"],
            'opv3_date' => $student_data["vacinne"]["opv3"]["date"],
            'ipv_given' => $student_data["vacinne"]["ipv"]["given"],
            'ipv_date' => $student_data["vacinne"]["ipv"]["date"],
            'opv_boos_given' => $student_data["vacinne"]["opv_boos"]["given"],
            'opv_boos_date' => $student_data["vacinne"]["opv_boos"]["date"],
            'mmr_one_given' => $student_data["vacinne"]["mmr_mr1"]["given"],
            'mmr_one_date' => $student_data["vacinne"]["mmr_mr1"]["date"],
            'je_given' => $student_data["vacinne"]["je1"]["given"],
            'je_date' => $student_data["vacinne"]["je1"]["date"],
            'mmr_given' => $student_data["vacinne"]["mmr1"]["given"],
            'mmr_date' => $student_data["vacinne"]["mmr1"]["date"],
            'dpt_given' => $student_data["vacinne"]["dpt1"]["given"],
            'dpt_date' => $student_data["vacinne"]["dpt1"]["date"],
            'je_vaccine_two_given' => $student_data["vacinne"]["je2"]["given"],
            'je_vaccine_two_date' => $student_data["vacinne"]["je2"]["date"],
            'dpt_2nd_booter_given' => $student_data["vacinne"]["dpt_2boost"]["given"],
            'dpt_2nd_booter_date' => $student_data["vacinne"]["dpt_2boost"]["date"],
            'tt1_given' => $student_data["vacinne"]["tt1"]["given"],
            'tt1_date' => $student_data["vacinne"]["tt1"]["date"],
            'tt2_given' => $student_data["vacinne"]["tt2"]["given"],
            'tt2_date' => $student_data["vacinne"]["tt2"]["date"]);

        if ($student_data["past_medicle_history"] == "") {
            $student_data["past_medicle_history"] = 'None';
        }
        if ($student_data["prev_hospitalization"] == "") {
            $student_data["prev_hospitalization"] = 'None';
        }
        if ($student_data["current_medication"] == "") {
            $student_data["current_medication"] = 'None';
        }
        if ($student_data["allergies"] == "") {
            $student_data["allergies"] = 'None';
        }

        $stud_data = array('schedule_id' => $student_data["schedule_id"],
            'student_id' => $student_data["student_id"],
            'past_medicle_history' => $student_data["past_medicle_history"],
            'prev_hospitalization' => $student_data["prev_hospitalization"],
            'current_medication' => $student_data["current_medication"],
            'allergies' => $student_data["allergies"],
            'vacines' => json_encode($data_vacine),
            'added_by' => $student_data["clg_ref_id"],
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $student_data["clg_ref_id"],
            'modify_date' => date('Y-m-d H:i:s'),);

        $stud_array = array('stud_id' => $student_data["student_id"],
            'schedule_id' => $student_data["schedule_id"]);

        $student_data = $this->student_model->get_stud_basic_info($stud_array);

        if (empty($student_data)) {
            $insert_student_data = $this->student_model->insert_stud_basic_info($stud_data);
            $msg = "Student Added Sucessfully!";
        } else {
            $insert_student_data = $this->student_model->update_stud_basic_info($stud_data);
            $msg = "Student Updated Sucessfully!";
        }

        echo json_encode($msg);

        exit();
    }

    public function student_screening_app() {

        $stud_screening = $this->input->post();
        $data['birth_deffects'] = $this->common_model->get_birth_effects();

        $data['childhood_disease'] = $this->common_model->get_childhood_disease();
        $data['deficienciese'] = $this->common_model->get_deficiencies();
        $data['skin_condition'] = $this->common_model->get_skin_condition();
        $data['orthopedics'] = $this->common_model->get_orthopedics();
        $data['diagnosis'] = $this->common_model->get_diagnosis();
        $data['checkbox_if_normal'] = $this->common_model->get_normal_checkbox();
        $stud_array = array('stud_id' => $stud_screening["stud_id"],
            'schedule_id' => $stud_screening["schedule_id"]);
        $data['screening'] = $this->student_model->get_stud_screening($stud_array);

        $return['stud_screen_checkboxes'] = $data;

        echo json_encode($return);

        exit();
    }

    public function student_screening_save_app() {

        $student_screening_data = $this->input->post();


        $stud_array = array('stud_id' => $student_screening_data["student_id"],
            'schedule_id' => $student_screening_data["schedule_id"]);

        $stud_screen_data = array('student_id' => $student_screening_data["student_id"],
            'schedule_id' => $student_screening_data["schedule_id"],
            'pulse' => $student_screening_data["pulse"],
            'sys_mm' => $student_screening_data["sys_mm"],
            'dys_mm' => $student_screening_data["dys_mm"],
            'hb' => $student_screening_data["hb"],
            'height' => $student_screening_data["height"],
            'weight' => $student_screening_data["weight"],
            'bmi' => $student_screening_data["bmi"],
            'oxygen_saturation' => $student_screening_data["oxygen_saturation"],
            'rr' => $student_screening_data["rr"],
            'temp' => $student_screening_data["temp"],
            'head' => $student_screening_data["head"],
            'eye' => $student_screening_data["eye"],
            'nose' => $student_screening_data["nose"],
            'hair_color' => $student_screening_data["hair_color"],
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
            'reproductive_date' => $student_screening_data["reproductive_date"],
            'oral_hygiene' => $student_screening_data["oral_hygiene"],
            'carious_tooth' => $student_screening_data["carious_tooth"],
            'fluorosis' => $student_screening_data["fluorosis"],
            'ascitis' => $student_screening_data["ascitis"],
            'orthodontic_treatment' => $student_screening_data["orthodontic_treatment"],
            'extraction' => $student_screening_data["extraction"],
            'dental_comment' => $student_screening_data["dental_comment"],
            'reffered_specialist' => $student_screening_data["reffered_specialist"],
            'auditary_screening_left' => $student_screening_data["auditary_screening_left"],
            'auditary_screening_right' => $student_screening_data["auditary_screening_right"],
            'vision_screening' => $student_screening_data["vision_screening"],
            'speech_screening' => $student_screening_data["speech_screening"],
            'color_blindness_left' => $student_screening_data["color_blindness_left"],
            'vision_screening_comment' => $student_screening_data["vision_screening_comment"],
            'vision_reffered_specialist' => $student_screening_data["vision_reffered_specialist"],
            'language_delay' => $student_screening_data["disability_language_delay"],
            'behavioural_disorder' => $student_screening_data["behavioural_disorder"],
            'disability_comment' => $student_screening_data["disability_comment"],
            'disability_reffered_specialist' => $student_screening_data["disability_reffered_specialist"],
            'birth_deffects' => json_encode($student_screening_data["birth_deffects"]),
            'childhood_disease' => json_encode($student_screening_data["childhood_disease"]),
            'deficiencies' => json_encode($student_screening_data["deficiencies"]),
            'skin_condition' => json_encode($student_screening_data["skin_condition"]),
            'checkbox_if_normal' => json_encode($student_screening_data["checkbox_if_normal"]),
            'diagnosis' => json_encode($student_screening_data["diagnosis"]),
            'added_by' => $student_screening_data["clg_ref_id"],
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $student_screening_data["clg_ref_id"],
            'modify_date' => date('Y-m-d H:i:s'),);


//          Medical Event save
        $stud_med_screen_data = array('student_id' => $student_screening_data["student_id"],
            'schedule_id' => $student_screening_data["schedule_id"],
            'pulse' => $student_screening_data["pulse"],
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
            'added_by' => $student_screening_data["clg_ref_id"],
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $student_screening_data["clg_ref_id"],
            'modify_date' => date('Y-m-d H:i:s'),);


//        dental screen save data
        $dental_data = array(
            'schedule_id' => $student_screening_data['schedule_id'],
            'student_id' => $student_screening_data['student_id'],
            'oral_hygiene' => $student_screening_data['oral_hygiene'],
            'carious_teeth' => $student_screening_data['carious_tooth'],
            'orthodontic_treatment' => $student_screening_data['orthodontic_treatment'],
            'extraction_done' => $student_screening_data['extraction'],
            'fluorosis' => $student_screening_data['fluorosis'],
            'added_by' => $student_screening_data["clg_ref_id"],
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $student_screening_data["clg_ref_id"],
            'modify_date' => date('Y-m-d H:i:s')
        );
        //Student Screening
        $student_screening_data = $this->student_model->get_stud_screening($stud_array);

        if (empty($student_screening_data)) {
            $insert_student_data = $this->student_model->insert_stud_screening($stud_screen_data);
            $msg = "Details Added Sucessfully!";
        } else {
            $insert_student_data = $this->student_model->update_stud_screening($stud_screen_data);
            $msg = "Details Updated Sucessfully!";
        }
        //Student Nedical Event Exanm Event

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

        echo json_encode($msg);
        exit();
    }

    public function dental_screen_save() {
        $dental_screening_data = $this->input->post();
        $dental_data = array(
            'schedule_id' => $dental_screening_data['schedule_id'],
            'student_id' => $dental_screening_data['student_id'],
            'oral_hygiene' => $dental_screening_data['oral_hygiene'],
            'gum_condition' => $dental_screening_data['gum_condition'],
            'oral_ulcers' => $dental_screening_data['oral_ulcers'],
            'gum_bleeding' => $dental_screening_data['gum_bleeding'],
            'sensitive_teeth' => $dental_screening_data['sensitive_teeth'],
            'discoloration_of_teeth' => $dental_screening_data['discoloration_of_teeth'],
            'food_impaction' => $dental_screening_data['food_impaction'],
            'carious_teeth' => $dental_screening_data['carious_teeth'],
            'malalignment' => $dental_screening_data['malalignment'],
            'orthodontic_treatment' => $dental_screening_data['orthodontic_treatment'],
            'extraction_done' => $dental_screening_data['extraction_done'],
            'fluorosis' => $dental_screening_data['fluorosis'],
            'tooth_brushing_frequency' => $dental_screening_data['tooth_brushing_frequency'],
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
            'fluorosis_text' => $dental_screening_data['fluorosis_text'],
            'tooth_brushing_frequency_text' => $dental_screening_data['tooth_brushing_frequency_text'],
            'dental_comment' => $dental_screening_data['dental_comment'],
            'dental_treatment_given' => $dental_screening_data['dental_treatment_given'],
            'added_by' => $dental_screening_data["clg_ref_id"],
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $dental_screening_data["clg_ref_id"],
            'modify_date' => date('Y-m-d H:i:s')
        );

        $stud_array = array('stud_id' => $dental_screening_data["student_id"],
            'schedule_id' => $dental_screening_data["schedule_id"]);



        $student_dental_data = $this->emt_model->get_stud_dental($stud_array);


        if (empty($student_dental_data)) {
            $insert_student_data = $this->emt_model->insert_stud_dental($dental_data);
            $msg = "Details Added Sucessfully!";
        } else {
            $insert_student_data = $this->emt_model->update_stud_dental($dental_data);
            $msg = "Details Updated Sucessfully!";
        }

//        $return['student_dental'] = $student_dental_data;

        echo json_encode($msg);

        exit();
    }

    public function dental_screen_info() {
        $dental_screening_data = $this->input->post();

        $stud_array = array('stud_id' => $dental_screening_data["stud_id"],
            'schedule_id' => $dental_screening_data["schedule_id"]);


        $student_dental_data = $this->emt_model->get_stud_dental($stud_array);

        $return['student_dental'] = $student_dental_data;
        echo json_encode($return);
        exit();
    }

    public function vision_screen_info() {
        $data['opthalmological'] = $this->common_model->get_opthalmological();
        $return['stud_vision_checkboxes'] = $data;
        echo json_encode($return);
        exit();
    }

    function get_vision_screen_info() {
        $vision_screening_data = $this->input->post();
        $stud_array = array('stud_id' => $vision_screening_data["stud_id"],
            'schedule_id' => $vision_screening_data["schedule_id"]);
        $student_vision_data = $this->emt_model->get_stud_vision($stud_array);
        $return['stud_vision_data'] = $student_vision_data;
        echo json_encode($return);
        exit();
    }

    public function vision_screen_save() {
        $vision_screening_data = $this->input->post();
        $dental_data = array(
            'schedule_id' => $vision_screening_data['schedule_id'],
            'student_id' => $vision_screening_data['student_id'],
            'refractive_error' => $vision_screening_data['refractive_error'],
            'eye_muscle_control' => json_encode($vision_screening_data["eye_muscle_control"]),
            'visual_perimetry' => $vision_screening_data['visual_perimetry'],
            'vision_comment' => $vision_screening_data['vision_comment'],
            'vision_treatment' => $vision_screening_data['vision_treatment'],
            'vision_with_glasses' => $vision_screening_data['vision_with_glasses'],
            'vision_without_glasses' => $vision_screening_data['vision_without_glasses'],
            'opthalmological' => json_encode($vision_screening_data["opthalmological"]),
            'added_by' => $vision_screening_data["clg_ref_id"],
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $vision_screening_data["clg_ref_id"],
            'modify_date' => date('Y-m-d H:i:s')
        );
        $stud_array = array('stud_id' => $vision_screening_data["student_id"],
            'schedule_id' => $vision_screening_data["schedule_id"]);
        $student_dental_data = $this->emt_model->get_stud_vision($stud_array);
        if (empty($student_dental_data)) {
            $insert_student_data = $this->emt_model->insert_stud_vision($dental_data);
            $msg = "Details Added Sucessfully!";
        } else {
            $insert_student_data = $this->emt_model->update_stud_vision($dental_data);
            $msg = "Details Updated Sucessfully!";
        }
        echo json_encode($msg);
        exit();
    }

    function student_auditary() {
        $data['auditary'] = $this->common_model->get_auditary();
        $return['stud_auditary_checkboxes'] = $data;
        $auditary_screening_data = $this->input->post();
        $stud_array = array('stud_id' => $auditary_screening_data["stud_id"],
            'schedule_id' => $auditary_screening_data["schedule_id"]);
        $student_auditary_data = $this->emt_model->get_stud_ent($stud_array);
        $return['stud_audiatry_data'] = $student_auditary_data;
        echo json_encode($return);
        exit();
    }

    function auditary_screen_save() {
        $auditary_screening_data = $this->input->post();
        $auditary_data = array(
            'schedule_id' => $auditary_screening_data['schedule_id'],
            'student_id' => $auditary_screening_data['student_id'],
            'hearing_left' => $auditary_screening_data['hearing_left'],
            'hearing_right' => $auditary_screening_data['hearing_right'],
            'otoscopic_exam' => $auditary_screening_data['otoscopic_exam'],
            'ent_comment' => $auditary_screening_data['ent_comment'],
            'treatment_given' => $auditary_screening_data['ent_treatment'],
            'ent_check_if_present' => json_encode($auditary_screening_data["ent_check_if_present"]),
            'added_by' => $auditary_screening_data["clg_ref_id"],
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $auditary_screening_data["clg_ref_id"],
            'modify_date' => date('Y-m-d H:i:s')
        );

        $stud_array = array('stud_id' => $auditary_screening_data["student_id"],
            'schedule_id' => $auditary_screening_data["schedule_id"]);

        $student_dental_data = $this->emt_model->get_stud_ent($stud_array);

        if (empty($student_dental_data)) {
            $insert_student_data = $this->emt_model->insert_stud_ent($auditary_data);
            $msg = "Details Added Sucessfully!";
        } else {
            $insert_student_data = $this->emt_model->update_stud_ent($auditary_data);
            $msg = "Details Updated Sucessfully!";
        }
        echo json_encode($msg);
        exit();
    }

    public function investigation() {
        $data['test'] = $this->common_model->get_tests();
        $return['test'] = $data;

        $investigation_screen_data = $this->input->post();
        $stud_array = array('stud_id' => $investigation_screen_data["stud_id"],
            'schedule_id' => $investigation_screen_data["schedule_id"]);

        $return['investigation_info'] = $this->emt_model->get_stud_investigation($stud_array);
        echo json_encode($return);
        exit();
    }

    public function investigation_save() {
        $investigation_screen_data = $this->input->post();

        $investigation_data = array(
            'schedule_id' => $investigation_screen_data['schedule_id'],
            'student_id' => $investigation_screen_data['student_id'],
            'test_title' => json_encode($investigation_screen_data["test_title"]),
            'added_by' => $investigation_screen_data["clg_ref_id"],
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $investigation_screen_data["clg_ref_id"],
            'modify_date' => date('Y-m-d H:i:s')
        );

        $stud_array = array('stud_id' => $investigation_screen_data["student_id"],
            'schedule_id' => $investigation_screen_data["schedule_id"]);

        $student_investigation_screen = $this->emt_model->get_stud_investigation($stud_array);


        if (empty($student_investigation_screen)) {
            $insert_student_data = $this->emt_model->insert_stud_investigation($investigation_data);
            $msg = "Details Added Sucessfully!";
        } else {
            $insert_student_data = $this->emt_model->update_stud_investigation($investigation_data);
            $msg = "Details Updated Sucessfully!";
        }
        echo json_encode($msg);
        exit();
    }

    public function medical_event_info() {
        $medical_screening_data = $this->input->post();
        $stud_array = array('stud_id' => $medical_screening_data["stud_id"],
            'schedule_id' => $medical_screening_data["schedule_id"]);

        $data['student_medical_data'] = $this->emt_model->get_stud_medicle_exam($stud_array);

        $stud['stud_screen_chekbox'] = $this->student_model->get_stud_screening($stud_array);

        if ($stud['stud_screen_chekbox'][0]->birth_deffects != 'null' && $stud['stud_screen_chekbox'][0]->birth_deffects != NULL) {
            $birth_defects = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->birth_deffects), TRUE));
            $data['birth_defects_chekbox'] = $this->common_model->get_birth_effects($birth_defects);
        }
        if ($stud['stud_screen_chekbox'][0]->checkbox_if_normal != 'null' && $stud['stud_screen_chekbox'][0]->checkbox_if_normal != NULL) {
            $checkbox_if_normal = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->checkbox_if_normal)));
            $data['checkbox_if_normal_chekbox'] = $this->common_model->get_normal_checkbox($checkbox_if_normal);
        }
        if ($stud['stud_screen_chekbox'][0]->diagnosis != 'null' && $stud['stud_screen_chekbox'][0]->diagnosis != NULL) {
            $diagnosis = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->diagnosis)));
            $data['diagnosis_chekbox'] = $this->common_model->get_diagnosis($diagnosis);
        }
        if ($stud['stud_screen_chekbox'][0]->skin_condition != 'null' && $stud['stud_screen_chekbox'][0]->skin_condition != NULL) {
            $skin_condition = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->skin_condition)));
            $data['skin_condition_chekbox'] = $this->common_model->get_skin_condition($skin_condition);
        }
        if ($stud['stud_screen_chekbox'][0]->deficiencies != 'null' && $stud['stud_screen_chekbox'][0]->deficiencies != NULL) {
            $deficiencies = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->deficiencies)));
            $data['deficiencies_chekbox'] = $this->common_model->get_deficiencies($deficiencies);
        }
        if ($stud['stud_screen_chekbox'][0]->childhood_disease != 'null' && $stud['stud_screen_chekbox'][0]->childhood_disease != NULL) {
            $childhood_disease = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->childhood_disease)));
            $data['childhood_disease_chekbox'] = $this->common_model->get_childhood_disease($childhood_disease);
        }

        $stud['stud_auditary_checkbox'] = $this->emt_model->get_stud_ent($stud_array);
        if ($stud['stud_auditary_checkbox'][0]->ent_check_if_present != 'null' && $stud['stud_auditary_checkbox'][0]->ent_check_if_present != NULL) {
            $ent_check_if_present = array('id' => json_decode($stud['stud_auditary_checkbox'][0]->ent_check_if_present));
            $data['ent_check_if_present_chekbox'] = $this->common_model->get_auditary($ent_check_if_present);
        }
        $stud['stud_vision_checkbox'] = $this->emt_model->get_stud_vision($stud_array);
        if ($stud['stud_vision_checkbox'][0]->opthalmological != 'null' && $stud['stud_vision_checkbox'][0]->opthalmological != NULL) {
            $opthalmological = array('id' => json_decode($stud['stud_vision_checkbox'][0]->opthalmological));
            $data['opthalmological_chekbox'] = $this->common_model->get_opthalmological($opthalmological);
        }
        echo json_encode($data);
        exit();
    }

    public function stud_med_event_save() {
        $medicle_events_data = $this->input->post();

        $medical_data = array(
            'schedule_id' => $medicle_events_data['schedule_id'],
            'student_id' => $medicle_events_data['student_id'],
            'chief_complaint' => $medicle_events_data['chief_complaint'],
            'pulse' => $medicle_events_data['pulse'],
            'sys_mm' => $medicle_events_data["sys_mm"],
            'dys_mm' => $medicle_events_data["dys_mm"],
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
//            'diagnosis_name' => $medicle_events_data['diagnosis_name'],
            'joints' => $medicle_events_data['joints'],
            'varicose_veins' => $medicle_events_data['varicose_veins'],
            'No_swollen_joints' => $medicle_events_data['No_swollen_joints'],
            'other_signs' => $medicle_events_data['other_signs'],
            'symptoms' => $medicle_events_data['symptoms'],
            'added_by' => $medicle_events_data["clg_ref_id"],
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $medicle_events_data["clg_ref_id"],
            'modify_date' => date('Y-m-d H:i:s')
        );

        $stud_array = array('stud_id' => $medicle_events_data["student_id"],
            'schedule_id' => $medicle_events_data["schedule_id"]);



        $stud_medicle_exam = $this->emt_model->get_stud_medicle_exam($stud_array);

        if (empty($stud_medicle_exam)) {
            $insert_student_data = $this->emt_model->insert_stud_medicle_exam($medical_data);
            $msg = "Details Added Sucessfully!";
        } else {
            $insert_student_data = $this->emt_model->update_stud_medicle_exam($medical_data);
            $msg = "Details Updated Sucessfully!";
        }
        echo json_encode($msg);
        exit();
    }

    function prescription_drug() {
        $term = $this->input->post('query', TRUE);
        if ($term != "") {

            $res = $this->common_model->get_drugs(array('drug_title' => $term));

            if ($res) {

                foreach ($res as $clu) {
                    $data[] = array("id" => $clu->id, "name" => $clu->drug_title);
                }
            }

            $return['drug_data'] = $data;

            echo json_encode($return);
            exit();
        }
    }

    function prescription() {

        $prescription_data = $this->input->post();

        $stud_array = array('stud_id' => $prescription_data["stud_id"],
            'schedule_id' => $prescription_data["schedule_id"]);



        $stduent['stud_prescriptionp'] = $this->emt_model->get_stud_prescription($stud_array);


        $stud['stud_screen_chekbox'] = $this->student_model->get_stud_screening($stud_array);
        if ($stud['stud_screen_chekbox'][0]->birth_deffects != 'null' && $stud['stud_screen_chekbox'][0]->birth_deffects != NULL) {
            $birth_defects = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->birth_deffects), TRUE));
            $data['birth_defects_chekbox'] = $this->common_model->get_birth_effects($birth_defects);
            foreach ($data['birth_defects_chekbox'] as $key => $value) {
                $stud_checked_checkbox['birth_defects'][] = $value->birth_effects_title;
            }
        }
        if ($stud['stud_screen_chekbox'][0]->checkbox_if_normal != 'null' && $stud['stud_screen_chekbox'][0]->checkbox_if_normal != NULL) {
            $checkbox_if_normal = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->checkbox_if_normal)));
            $data['checkbox_if_normal_chekbox'] = $this->common_model->get_normal_checkbox($checkbox_if_normal);
            foreach ($data['checkbox_if_normal_chekbox'] as $key => $value) {

                $stud_checked_checkbox['checkbox_if_normal'][] = $value->normal_checkbox_title;
            }
        }
        if ($stud['stud_screen_chekbox'][0]->diagnosis != 'null' && $stud['stud_screen_chekbox'][0]->diagnosis != NULL) {
            $diagnosis = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->diagnosis)));
            $data['diagnosis_chekbox'] = $this->common_model->get_diagnosis($diagnosis);
            foreach ($data['diagnosis_chekbox'] as $key => $value) {
                $stud_checked_checkbox['diagnosis'][] = $value->diagnosis_title;
            }
        }
        if ($stud['stud_screen_chekbox'][0]->skin_condition != 'null' && $stud['stud_screen_chekbox'][0]->skin_condition != NULL) {
            $skin_condition = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->skin_condition)));
            $data['skin_condition_chekbox'] = $this->common_model->get_skin_condition($skin_condition);
            foreach ($data['skin_condition_chekbox'] as $key => $value) {
                $stud_checked_checkbox['skin_condition'][] = $value->skin_condition_title;
            }
        }
        if ($stud['stud_screen_chekbox'][0]->deficiencies != 'null' && $stud['stud_screen_chekbox'][0]->deficiencies != NULL) {
            $deficiencies = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->deficiencies)));
            $data['deficiencies_chekbox'] = $this->common_model->get_deficiencies($deficiencies);
            foreach ($data['deficiencies_chekbox'] as $key => $value) {
                $stud_checked_checkbox['deficiencies'][] = $value->deficiencies_title;
            }
        }
        if ($stud['stud_screen_chekbox'][0]->childhood_disease != 'null' && $stud['stud_screen_chekbox'][0]->childhood_disease != NULL) {
            $childhood_disease = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->childhood_disease)));
            $data['childhood_disease_chekbox'] = $this->common_model->get_childhood_disease($childhood_disease);
            foreach ($data['childhood_disease_chekbox'] as $key => $value) {


                $stud_checked_checkbox['childhood_disease'][] = $value->childhood_disease_title;
            }
        }

        $stud['stud_auditary_checkbox'] = $this->emt_model->get_stud_ent($stud_array);
        if ($stud['stud_auditary_checkbox'][0]->ent_check_if_present != 'null' && $stud['stud_auditary_checkbox'][0]->ent_check_if_present != NULL) {
            $ent_check_if_present = array('id' => json_decode($stud['stud_auditary_checkbox'][0]->ent_check_if_present));
            $data['ent_check_if_present_chekbox'] = $this->common_model->get_auditary($ent_check_if_present);
            foreach ($data['ent_check_if_present_chekbox'] as $key => $value) {

                $stud_checked_checkbox['ent_check_if_present'][] = $value->auditary_title;
            }
        }
        $stud['stud_vision_checkbox'] = $this->emt_model->get_stud_vision($stud_array);
        if ($stud['stud_vision_checkbox'][0]->opthalmological != 'null' && $stud['stud_vision_checkbox'][0]->opthalmological != NULL) {
            $opthalmological = array('id' => json_decode($stud['stud_vision_checkbox'][0]->opthalmological));
            $data['opthalmological_chekbox'] = $this->common_model->get_opthalmological($opthalmological);

            foreach ($data['opthalmological_chekbox'] as $key => $value) {

                $stud_checked_checkbox['opthalmological'][] = $value->opthalmological_title;
                $stduent['student_data'][] = $stud_checked_checkbox;
                if (isset($stduent['student_data'][0])) {
                    break;
                }
            }
        }

        echo json_encode($stduent);
        exit();
    }

    function prescription_save() {
        $prescription_data = $this->input->post();


        $prescription_info = array(
            'schedule_id' => $prescription_data['schedule_id'],
            'student_id' => $prescription_data['student_id'],
            'drug_details' => json_encode($prescription_data['drug_details']),
            'added_by' => $prescription_data["clg_ref_id"],
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $prescription_data["clg_ref_id"],
            'modify_date' => date('Y-m-d H:i:s')
        );


        $stud_array = array('stud_id' => $prescription_data["student_id"],
            'schedule_id' => $prescription_data["schedule_id"]);

        $stud_prescription = $this->emt_model->get_stud_prescription($stud_array);


        if (empty($stud_prescription)) {
            $insert_student_data = $this->emt_model->insert_stud_prescription($prescription_info);
            $msg = "Inserted Sucessfully!";
        } else {
            $insert_student_data = $this->emt_model->update_stud_prescription($prescription_info);
            $msg = "Updated Sucessfully!";
        }


        echo json_encode($msg);

        exit();
    }

    function get_diagnosis() {
        $student_data = $this->input->post();
        $stud_array = array('stud_id' => $student_data["stud_id"],
            'schedule_id' => $student_data["schedule_id"]);
        $stud_medicle_exam = $this->emt_model->get_stud_medicle_exam_dignosis($stud_array);
        $dig_array = array('diagnosis_id' => $stud_medicle_exam[0]->diagnosis_name);
        if ($dig_array['diagnosis_id'] != "") {
            $res = $this->common_model->get_mas_diagonosis($dig_array);
        } else {
            $res = [];
        }
        $res = $this->common_model->get_mas_diagonosis($dig_array);
        $return['selected_diagnosis'] = $res;
        echo json_encode($return);
        exit();
    }

    function get_selected_test() {
        $args = array(
            'test_id' => $this->input->post('test_id'),
        );
        $res = $this->common_model->get_tests($args);
        $return['test'] = $res;
        echo json_encode($return);
        exit();
    }

    function remove_test() {
        $div_id = $this->input->post();
        $div = $div_id['test_id'];
        $remove_div = "<script>$( 'tr#row_" . $div . "' ).remove();</script>";
        $data['med_qty_script'] = $remove_div;
        $type = $div;
        $med_selected_qty_inv_list = $this->session->userdata('selected_test');
        unset($med_selected_qty_inv_list[$type]);
        $this->output->add_to_position($remove_div, "custom_script", TRUE);
        $this->output->template = "";
        //die();
    }

    function get_auto_diagosis_code() {
        $term = $this->input->post('query', TRUE);
        if ($term != "") {
            $res = $this->common_model->get_mas_diagonosis(array('diagnosis_title' => $term));
            if ($res) {
                foreach ($res as $clu) {
                    $data[] = array("label" => $clu->diagnosis_title, "value" => $clu->id);
                }
            }
//            $return['dignosis_data'] = $data;
            echo json_encode($data);
            exit();
        }
    }

    function hospitalization_info() {
        $student_data = $this->input->post();
        $stud_array = array('stud_id' => $student_data["stud_id"],
            'schedule_id' => $student_data["schedule_id"]);

        $stud['stud_screen_chekbox'] = $this->student_model->get_stud_screening($stud_array);
        if ($stud['stud_screen_chekbox'][0]->birth_deffects != 'null' && $stud['stud_screen_chekbox'][0]->birth_deffects != NULL) {
            $birth_defects = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->birth_deffects), TRUE));
            $data['birth_defects_chekbox'] = $this->common_model->get_birth_effects($birth_defects);
            foreach ($data['birth_defects_chekbox'] as $key => $value) {
                $stud_checked_checkbox['birth_defects'][] = $value->birth_effects_title;
            }
        }
        if ($stud['stud_screen_chekbox'][0]->checkbox_if_normal != 'null' && $stud['stud_screen_chekbox'][0]->checkbox_if_normal != NULL) {
            $checkbox_if_normal = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->checkbox_if_normal)));
            $data['checkbox_if_normal_chekbox'] = $this->common_model->get_normal_checkbox($checkbox_if_normal);
            foreach ($data['checkbox_if_normal_chekbox'] as $key => $value) {

                $stud_checked_checkbox['checkbox_if_normal'][] = $value->normal_checkbox_title;
            }
        }
        if ($stud['stud_screen_chekbox'][0]->diagnosis != 'null' && $stud['stud_screen_chekbox'][0]->diagnosis != NULL) {
            $diagnosis = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->diagnosis)));
            $data['diagnosis_chekbox'] = $this->common_model->get_diagnosis($diagnosis);
            foreach ($data['diagnosis_chekbox'] as $key => $value) {
                $stud_checked_checkbox['diagnosis'][] = $value->diagnosis_title;
            }
        }
        if ($stud['stud_screen_chekbox'][0]->skin_condition != 'null' && $stud['stud_screen_chekbox'][0]->skin_condition != NULL) {
            $skin_condition = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->skin_condition)));
            $data['skin_condition_chekbox'] = $this->common_model->get_skin_condition($skin_condition);
            foreach ($data['skin_condition_chekbox'] as $key => $value) {
                $stud_checked_checkbox['skin_condition'][] = $value->skin_condition_title;
            }
        }
        if ($stud['stud_screen_chekbox'][0]->deficiencies != 'null' && $stud['stud_screen_chekbox'][0]->deficiencies != NULL) {
            $deficiencies = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->deficiencies)));
            $data['deficiencies_chekbox'] = $this->common_model->get_deficiencies($deficiencies);
            foreach ($data['deficiencies_chekbox'] as $key => $value) {
                $stud_checked_checkbox['deficiencies'][] = $value->deficiencies_title;
            }
        }
        if ($stud['stud_screen_chekbox'][0]->childhood_disease != 'null' && $stud['stud_screen_chekbox'][0]->childhood_disease != NULL) {
            $childhood_disease = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->childhood_disease)));
            $data['childhood_disease_chekbox'] = $this->common_model->get_childhood_disease($childhood_disease);
            foreach ($data['childhood_disease_chekbox'] as $key => $value) {


                $stud_checked_checkbox['childhood_disease'][] = $value->childhood_disease_title;
            }
        }

        $stud['stud_auditary_checkbox'] = $this->emt_model->get_stud_ent($stud_array);
        if ($stud['stud_auditary_checkbox'][0]->ent_check_if_present != 'null' && $stud['stud_auditary_checkbox'][0]->ent_check_if_present != NULL) {
            $ent_check_if_present = array('id' => json_decode($stud['stud_auditary_checkbox'][0]->ent_check_if_present));
            $data['ent_check_if_present_chekbox'] = $this->common_model->get_auditary($ent_check_if_present);
            foreach ($data['ent_check_if_present_chekbox'] as $key => $value) {

                $stud_checked_checkbox['ent_check_if_present'][] = $value->auditary_title;
            }
        }
        $stud['stud_vision_checkbox'] = $this->emt_model->get_stud_vision($stud_array);
        if ($stud['stud_vision_checkbox'][0]->opthalmological != 'null' && $stud['stud_vision_checkbox'][0]->opthalmological != NULL) {
            $opthalmological = array('id' => json_decode($stud['stud_vision_checkbox'][0]->opthalmological));
            $data['opthalmological_chekbox'] = $this->common_model->get_opthalmological($opthalmological);

            foreach ($data['opthalmological_chekbox'] as $key => $value) {

                $stud_checked_checkbox['opthalmological'][] = $value->opthalmological_title;
                $stduent['student_data'][] = $stud_checked_checkbox;
                if (isset($stduent['student_data'][0])) {
                    break;
                }
            }
        }

        echo json_encode($stduent);
        exit();
    }

    function hospitalization_save() {
        $hospitalization_data = $this->input->post();
        $hospitalization_info = array(
            'schedule_id' => $hospitalization_data['schedule_id'],
            'student_id' => $hospitalization_data['student_id'],
            'diagnosis_name' => $hospitalization_data['diagnosis_title'],
            'brief_history' => $hospitalization_data['brief_history'],
            'insurance' => $hospitalization_data['insurance'],
            'insurance_procedure' => $hospitalization_data['diagnosis_procedure'],
            'hosp' => 'hosp',
            'added_by' => $hospitalization_data["clg_ref_id"],
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $hospitalization_data["clg_ref_id"],
            'modify_date' => date('Y-m-d H:i:s')
        );

        $stud_array = array('stud_id' => $hospitalization_data["student_id"],
            'schedule_id' => $hospitalization_data["schedule_id"]);

        $stud_hospitalizaion = $this->emt_model->get_stud_hospitalizaion($stud_array);


        if (empty($stud_hospitalizaion)) {
            $insert_student_data = $this->emt_model->insert_stud_hospitalizaion($hospitalization_info);
            $msg = "Details Added successfully";
        } else {
            $insert_student_data = $this->emt_model->update_stud_hospitalizaion($hospitalization_info);
            $msg = "Details Updated successfully";
        }
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

        $sickroom = array(
            'schedule_id' => $sickroom_data['schedule_id'],
            'student_id' => $sickroom_data['student_id'],
            'doctor_note' => $sickroom_data['doctor_note'],
            'treatment_order' => $sickroom_data['treatment_order'],
            'added_by' => $sickroom_data["clg_ref_id"],
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $sickroom_data["clg_ref_id"],
            'modify_date' => date('Y-m-d H:i:s')
        );

        $stud_array = array('stud_id' => $sickroom_data["student_id"],
            'schedule_id' => $sickroom_data["schedule_id"]);

        $student_sick_room_data = $this->emt_model->get_stud_sickroom($stud_array);

        if (empty($student_sick_room_data)) {
            $insert_student_data = $this->emt_model->insert_stud_sickroom($sickroom);
            $msg = "Details Added successfully";
        } else {
            $insert_student_data = $this->emt_model->update_stud_sickroom($sickroom);
            $msg = "Details updated successfully";
        }
    }

    function stud_healthcard() {

        $student_data = $this->input->post();

        $stud_array = array('stud_id' => $student_data["stud_id"],
            'schedule_id' => $student_data["schedule_id"]);

        $arg_array = array('schedule_id' => $student_data["schedule_id"]);

//        $data['school_info'] = $this->schedule_model->get_schedule_data($arg_array);

        $data['stud_info'] = $this->student_model->get_search_stud_by_shedule_id($stud_array);


//
//        $data['stud_basic_info'] = $this->student_model->get_stud_basic_info($stud_array);
//        $data['stud_screening'] = $this->student_model->get_stud_screening($stud_array);
//
//        $stud_prescription = $this->emt_model->get_stud_prescription($stud_array);
//
//        if ($stud_prescription[0]->drug_details != 'null' && $stud_prescription[0]->drug_details != NULL) {
//            $json = json_decode($stud_prescription[0]->drug_details, true);
//
//            foreach ($json['drug_name'] as $key => $val) {
//                $student_data['drug_name'][] = $val;
//            }
//        }
//        $data['investigation_info'] = $this->emt_model->get_stud_investigation($stud_array);
//     
//        if ($data['investigation_info'][0]->test_title != 'null' && $data['investigation_info'][0]->test_title != NULL) {
//              $test_json = $data['investigation_info'][0]->test_title;
//            $test_obj = json_decode($test_json, TRUE);
// 
//            foreach ($test_obj as $key => $value) {
//                $student_data['test_name'][] = $value;
//            }
//        }
//        foreach ($data['school_info'] as $key => $value) {
//            $student_data['school_name'] = $value->school_name;
//            $student_data['school_address'] = $value->school_address;
//        }

        foreach ($data['stud_info'] as $key => $value) {
            $student_data['stud_id'] = $value->stud_id;
            $student_data['stud_first_name'] = $value->stud_first_name;
            $student_data['stud_last_name'] = $value->stud_last_name;
            $student_data['stud_middle_name'] = $value->stud_middle_name;
            $student_data['stud_reg_no'] = $value->stud_reg_no;
            $student_data['stud_age'] = $value->stud_age;
            $student_data['stud_dob'] = date("d-m-Y", strtotime($value->stud_dob));
            $student_data['stud_adhar_no'] = $value->stud_adhar_no;
            $student_data['stud_blood_group'] = $value->stud_blood_group;
            $student_data['stud_gender'] = $value->stud_gender;
            $student_data['stud_state'] = $value->stud_state;
            $student_data['stud_district'] = $value->stud_district;
            $student_data['stud_city'] = $value->stud_city;
            $student_data['stud_pincode'] = $value->stud_pincode;
            $student_data['stud_gaurdian_information'] = $value->stud_gaurdian_information;
            $student_data['rel_with_stud'] = $value->rel_with_stud;
            $student_data['house_no'] = $value->house_no;
            $student_data['road'] = $value->road;
            $student_data['lankmark'] = $value->lankmark;
            $student_data['locality'] = $value->locality;
            $student_data['contact_no'] = $value->contact_no;
            $student_search_data[] = $student_data;
        }
//        foreach ($data['stud_basic_info'] as $key => $value) {
//            $student_data['past_medicle_history'] = $value->past_medicle_history;
//            $student_data['prev_hospitalization'] = $value->prev_hospitalization;
//            $student_data['current_medication'] = $value->current_medication;
//            $student_data['allergies'] = $value->allergies;
//            $student_data['schedule_id'] = $schedule[0]->schedule_id;
//            $student_data['added_by'] = $value->added_by;
//            $student_data['modify_date'] = date("d-m-Y", strtotime($value->modify_date));
//        }
//        foreach ($data['stud_screening'] as $key => $value) {
//            $student_data['height'] = $value->height;
//            $student_data['weight'] = $value->weight;
//            $student_search_data[] = $student_data;
//        }
        $return['stud_info'] = $student_search_data;
        echo json_encode($return);

        exit();
    }

    function get_emplanned_hospitals() {

        $term = $this->input->post('query', TRUE);

        $term = $this->input->post('query', TRUE);
        if ($term != "") {
            $res = $this->emt_model->get_emplanned_hospital(array('hp_name' => $term));

            if ($res) {
                foreach ($res as $clu) {
                    $data[] = array("id" => $clu->hp_id, "name" => $clu->hp_name);
                }
            }
            $return['hospital_data'] = $data;

            echo json_encode($return);

            exit();
        }
    }

    function get_refrerral_slip_details() {
        $student_data = $this->input->post();

        $stud_array = array('stud_id' => $student_data["stud_id"],
            'schedule_id' => $student_data["schedule_id"]);


        $data['school_info'] = $this->schedule_model->get_schedule_data($arg_array);

        $data['stud_info'] = $this->student_model->get_search_stud_by_shedule_id($stud_array);



        foreach ($data['school_info'] as $key => $value) {

            $student_data['school_name'] = $value->school_name;
            $student_data['school_address'] = $value->school_address;
        }

        foreach ($data['stud_info'] as $key => $value) {

            $student_data['stud_id'] = $value->stud_id;
            $student_data['stud_first_name'] = $value->stud_first_name;
            $student_data['stud_last_name'] = $value->stud_last_name;
            $student_data['stud_middle_name'] = $value->stud_middle_name;
            $student_data['stud_reg_no'] = $value->stud_reg_no;
            $student_data['stud_age'] = $value->stud_age;
            $student_data['stud_dob'] = $value->stud_dob;
            $student_data['stud_adhar_no'] = $value->stud_adhar_no;
            $student_data['stud_blood_group'] = $value->stud_blood_group;
            $student_data['stud_gender'] = $value->stud_gender;
            $student_data['stud_state'] = $value->stud_state;
            $student_data['stud_district'] = $value->stud_district;
            $student_data['stud_city'] = $value->stud_city;
            $student_data['stud_pincode'] = $value->stud_pincode;
            $student_data['stud_gaurdian_information'] = $value->stud_gaurdian_information;
            $student_data['rel_with_stud'] = $value->rel_with_stud;
            $student_data['house_no'] = $value->house_no;
            $student_data['road'] = $value->road;
            $student_data['lankmar'] = $value->lankmark;
            $student_data['locality'] = $value->locality;
            $student_data['contact_no'] = $value->contact_no;

            $student_search_data[] = $student_data;
        }
        $return['stud_info'] = $student_search_data;
        echo json_encode($return);

        exit();
    }

    function get_govt_hospitals() {
        $term = $this->input->post('query', TRUE);


        if ($term != "") {
            $res = $this->emt_model->get_govt_hospital(array('hp_name' => $term));

            if ($res) {
                foreach ($res as $clu) {
                    $data[] = array("id" => $clu->hp_id, "name" => $clu->hp_name);
                }
            }
            $return['hospital_data'] = $data;

            echo json_encode($return);

            exit();
        }
    }

    function send_hospital_mail() {
        $data = $this->input->post();
        $decoded = base64_decode($data["msg_content"]);
        $reply_mail = 'chaitali.fartade@mulikainfotech.com';
        $message .="$decoded Thanks, <br/>"
                . $this->site_name;
        $email = 'chaitali.fartade@mulikainfotech.com';
        $subject = $this->site . " Details";
        $res_mail = $this->send_email($reply_mail, $message, $email, $subject);

    }

//    }
}
