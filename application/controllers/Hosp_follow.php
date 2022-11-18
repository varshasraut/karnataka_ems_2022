<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Hosp_follow extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));
        $this->load->model(array('prescription_model','student_model','common_model','emt_model','hp_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper', 'language_helper'));


        $this->post = $this->input->get_post(NULL);
        $this->post['base_month'] = get_base_month();
        $this->clg = $this->session->userdata('current_user');

        $this->pg_limit = 50;
        $this->pg_limits = $this->config->item('report_clg');

        $this->steps_cnt = $this->config->item('screening_steps');

        $this->today = date('Y-m-d H:i:s');
    }

    function hosp_follow_list() {
        
        //////////// Filter////////////

        $data['hosp_search'] = ($this->post['hosp_search']) ? $this->post['hosp_search'] : $this->fdata['hosp_search'];
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
        $data['is_hosp_null'] = TRUE;

        $data['total_count'] = $this->prescription_model->get_hospitalization($data);
        

        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['AMB'] = $data;

        $this->session->set_userdata('filters', $ambflt);

        /////////////////////////////////////////////////////

        unset($data['get_count']);

        $data['offset'] = $offset;
        $data['result'] = $this->prescription_model->get_hospitalization($data, $offset, $limit);

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("hosp_follow/hosp_follow_list"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        $data['pagination'] = get_pagination($pgconf);
        
        $this->output->add_to_position($this->load->view('frontend/hosp_follow/hosp_follow_list_view', $data, TRUE), $this->post['output_position'], TRUE);

        $this->output->add_to_position($this->load->view('frontend/hosp_follow/hosp_follow_filters_view', $data, TRUE), 'prescription_filters', TRUE);
    }

    function hosp_follow_view(){
       
        $hosp_id =  base64_decode($this->input->post('hosp_id'));
        
        $data['hosp_id'] = $hosp_id;
        $data['result'] = $this->prescription_model->get_hospitalization($data);
        
        $hp_id = $data['result'][0]->hosp_id;
        $hp_args = array('hp_id'=>$hp_id);
        $data['hosp_data'] = $this->hp_model->get_hp_data($hp_args);
        
        $stud_array = array('stud_id' => $data['result'][0]->student_id,
                            'schedule_id' => $data['result'][0]->schedule_id);

         
         $stud['stud_screen_chekbox'] = $this->student_model->get_stud_screening($stud_array);
         
        if ($stud['stud_screen_chekbox'][0]->birth_deffects != 'null' && $stud['stud_screen_chekbox'][0]->birth_deffects != NULL) {
            $birth_defects = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->birth_deffects), TRUE));
           
            if(!empty($birth_defects['id'])){
                $data['birth_defects_chekbox'] = $this->common_model->get_birth_effects($birth_defects);
                foreach ($data['birth_defects_chekbox'] as $key => $value) {
                    $stud_checked_checkbox['birth_defects'][] = $value->birth_effects_title;
                }
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
            if(!empty($diagnosis['id'])){
                $data['diagnosis_chekbox'] = $this->common_model->get_diagnosis($diagnosis);
                foreach ($data['diagnosis_chekbox'] as $key => $value) {
                    $stud_checked_checkbox['diagnosis'][] = $value->diagnosis_title;
                }
            }
        }
        if ($stud['stud_screen_chekbox'][0]->skin_condition != 'null' && $stud['stud_screen_chekbox'][0]->skin_condition != NULL) {
            $skin_condition = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->skin_condition)));
            
            if(!empty($skin_condition['id'])){
                $data['skin_condition_chekbox'] = $this->common_model->get_skin_condition($skin_condition);
                foreach ($data['skin_condition_chekbox'] as $key => $value) {
                    $stud_checked_checkbox['skin_condition'][] = $value->skin_condition_title;
                }
            }
            
        }
        if ($stud['stud_screen_chekbox'][0]->deficiencies != 'null' && $stud['stud_screen_chekbox'][0]->deficiencies != NULL) {
            $deficiencies = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->deficiencies)));
            
            if(!empty($deficiencies['id'])){
                $data['deficiencies_chekbox'] = $this->common_model->get_deficiencies($deficiencies);
                foreach ($data['deficiencies_chekbox'] as $key => $value) {
                    $stud_checked_checkbox['deficiencies'][] = $value->deficiencies_title;
                }
            }
            
        }
        if ($stud['stud_screen_chekbox'][0]->childhood_disease != 'null' && $stud['stud_screen_chekbox'][0]->childhood_disease != NULL) {
            $childhood_disease = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->childhood_disease)));
            
            if(!empty($childhood_disease['id'])){
                $data['childhood_disease_chekbox'] = $this->common_model->get_childhood_disease($childhood_disease);
                foreach ($data['childhood_disease_chekbox'] as $key => $value) {
                    $stud_checked_checkbox['childhood_disease'][] = $value->childhood_disease_title;
                }
            }
            
        }

        $stud['stud_auditary_checkbox'] = $this->emt_model->get_stud_ent($stud_array);
        if ($stud['stud_auditary_checkbox'][0]->ent_check_if_present != 'null' && $stud['stud_auditary_checkbox'][0]->ent_check_if_present != NULL) {
            $ent_check_if_present = array('id' => json_decode($stud['stud_auditary_checkbox'][0]->ent_check_if_present));
            
            if(!empty($ent_check_if_present['id'])){
                $data['ent_check_if_present_chekbox'] = $this->common_model->get_auditary($ent_check_if_present);
                foreach ($data['ent_check_if_present_chekbox'] as $key => $value) {
                    $stud_checked_checkbox['ent_check_if_present'][] = $value->auditary_title;
                }
            }
        }
        $stud['stud_vision_checkbox'] = $this->emt_model->get_stud_vision($stud_array);
        if ($stud['stud_vision_checkbox'][0]->opthalmological != 'null' && $stud['stud_vision_checkbox'][0]->opthalmological != NULL) {
            $opthalmological = array('id' => json_decode($stud['stud_vision_checkbox'][0]->opthalmological));
            
            if(!empty($opthalmological['id'])){
                $data['opthalmological_chekbox'] = $this->common_model->get_opthalmological($opthalmological);
                foreach ($data['opthalmological_chekbox'] as $key => $value) {

                    $stud_checked_checkbox['opthalmological'][] = $value->opthalmological_title;
                }
            }
        }
        $stduent['student_data'][] = $stud_checked_checkbox;
                
        $data['diagonosis'] = $stduent['student_data'][0];
        
        
        $this->output->add_to_position($this->load->view('frontend/hosp_follow/hosp_follow_view', $data, TRUE), 'content', TRUE);
    }
    function intra_hosp_view(){
       
        $hosp_id =  base64_decode($this->input->post('hosp_id'));
        
        $data['hosp_id'] = $hosp_id;
        $data['result'] = $this->prescription_model->get_hospitalization($data);
        
        $this->output->add_to_position($this->load->view('frontend/hosp_follow/intra_hosp_view', $data, TRUE), 'content', TRUE);
    }
    
     function post_hospitalisation_view(){
       
        $hosp_id =  base64_decode($this->input->post('hosp_id'));
        
        $data['hosp_id'] = $hosp_id;
        $data['result'] = $this->prescription_model->get_hospitalization($data);
        
            $stud_array = array('stud_id' => $data['result'][0]->student_id,
                            'schedule_id' => $data['result'][0]->schedule_id);

         $stud['stud_screen_chekbox'] = $this->student_model->get_stud_screening($stud_array);
         
        if ($stud['stud_screen_chekbox'][0]->birth_deffects != 'null' && $stud['stud_screen_chekbox'][0]->birth_deffects != NULL) {
            $birth_defects = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->birth_deffects), TRUE));
            
            if(!empty($birth_defects['id'])){
                $data['birth_defects_chekbox'] = $this->common_model->get_birth_effects($birth_defects);
                foreach ($data['birth_defects_chekbox'] as $key => $value) {
                    $stud_checked_checkbox['birth_defects'][] = $value->birth_effects_title;
                }
            }
        }
        if ($stud['stud_screen_chekbox'][0]->checkbox_if_normal != 'null' && $stud['stud_screen_chekbox'][0]->checkbox_if_normal != NULL) {
            $checkbox_if_normal = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->checkbox_if_normal)));
            
            if(!empty($checkbox_if_normal['id'])){
                $data['checkbox_if_normal_chekbox'] = $this->common_model->get_normal_checkbox($checkbox_if_normal);
                foreach ($data['checkbox_if_normal_chekbox'] as $key => $value) {

                    $stud_checked_checkbox['checkbox_if_normal'][] = $value->normal_checkbox_title;
                }
            }
        }
        if ($stud['stud_screen_chekbox'][0]->diagnosis != 'null' && $stud['stud_screen_chekbox'][0]->diagnosis != NULL) {
            $diagnosis = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->diagnosis)));
            
            if(!empty($diagnosis['id'])){
                $data['diagnosis_chekbox'] = $this->common_model->get_diagnosis($diagnosis);
                foreach ($data['diagnosis_chekbox'] as $key => $value) {
                    $stud_checked_checkbox['diagnosis'][] = $value->diagnosis_title;
                }
            }
        }
        if ($stud['stud_screen_chekbox'][0]->skin_condition != 'null' && $stud['stud_screen_chekbox'][0]->skin_condition != NULL) {
            $skin_condition = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->skin_condition)));
            
            if(!empty($skin_condition['id'])){
                $data['skin_condition_chekbox'] = $this->common_model->get_skin_condition($skin_condition);
                foreach ($data['skin_condition_chekbox'] as $key => $value) {
                    $stud_checked_checkbox['skin_condition'][] = $value->skin_condition_title;
                }
            }
        }
        if ($stud['stud_screen_chekbox'][0]->deficiencies != 'null' && $stud['stud_screen_chekbox'][0]->deficiencies != NULL) {
            $deficiencies = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->deficiencies)));
            
            if(!empty($deficiencies['id'])){
                $data['deficiencies_chekbox'] = $this->common_model->get_deficiencies($deficiencies);
                foreach ($data['deficiencies_chekbox'] as $key => $value) {
                    $stud_checked_checkbox['deficiencies'][] = $value->deficiencies_title;
                }
            }
        }
        if ($stud['stud_screen_chekbox'][0]->childhood_disease != 'null' && $stud['stud_screen_chekbox'][0]->childhood_disease != NULL) {
            $childhood_disease = array('id' => json_decode(($stud['stud_screen_chekbox'][0]->childhood_disease)));
            
            if(!empty($childhood_disease['id'])){
                $data['childhood_disease_chekbox'] = $this->common_model->get_childhood_disease($childhood_disease);
                foreach ($data['childhood_disease_chekbox'] as $key => $value) {
                    $stud_checked_checkbox['childhood_disease'][] = $value->childhood_disease_title;
                }
            }
        }

        $stud['stud_auditary_checkbox'] = $this->emt_model->get_stud_ent($stud_array);
        if ($stud['stud_auditary_checkbox'][0]->ent_check_if_present != 'null' && $stud['stud_auditary_checkbox'][0]->ent_check_if_present != NULL) {
            $ent_check_if_present = array('id' => json_decode($stud['stud_auditary_checkbox'][0]->ent_check_if_present));
            
            if(!empty($ent_check_if_present['id'])){
                $data['ent_check_if_present_chekbox'] = $this->common_model->get_auditary($ent_check_if_present);
                foreach ($data['ent_check_if_present_chekbox'] as $key => $value) {
                    $stud_checked_checkbox['ent_check_if_present'][] = $value->auditary_title;
                }
            }
            
        }
        $stud['stud_vision_checkbox'] = $this->emt_model->get_stud_vision($stud_array);
        if ($stud['stud_vision_checkbox'][0]->opthalmological != 'null' && $stud['stud_vision_checkbox'][0]->opthalmological != NULL) {
            $opthalmological = array('id' => json_decode($stud['stud_vision_checkbox'][0]->opthalmological));
            if(!empty($opthalmological['id'])){
                $data['opthalmological_chekbox'] = $this->common_model->get_opthalmological($opthalmological);
                foreach ($data['opthalmological_chekbox'] as $key => $value) {
                    $stud_checked_checkbox['opthalmological'][] = $value->opthalmological_title;
                }
            }
        }
        $stduent['student_data'][] = $stud_checked_checkbox;
                
        $data['diagonosis'] = $stduent['student_data'][0];
        
        $this->output->add_to_position($this->load->view('frontend/hosp_follow/post_hospitalisation_view', $data, TRUE), 'content', TRUE);
    }
    
    function save_hospitalisation(){
        
        $hospitalization = $this->input->post('hosp');
        
        $admited_on = date('Y-m-d',strtotime($hospitalization['admitted_on']));
        $hospitalization['admitted_on'] = $admited_on;
        
        $result = $this->emt_model->update_stud_hospitalizaion($hospitalization);
        
        if ($result) {
            
            $this->output->message = "<div class='success'>" . "Hospitalisation updated successfully" . "<script>$('#hosp_step_two').click();</script></div>";

        }else{
            $this->output->message = "<div class='success'>" . "Error Occure" . "</div>";
            $this->output->add_to_position($this->load->view('frontend/hosp_follow/hosp_follow_view', $data, TRUE), 'content', TRUE);
        }
        
    }
    function save_intra_hospitalisation(){
        
        $intra= $this->input->post('intra');
        $hospitalization = $this->input->post('hosp');
        
        $discharge_date= date('Y-m-d',strtotime($hospitalization['discharge_date']));
        $drop_back_datetime= date('Y-m-d H:i:s',strtotime($hospitalization['drop_back_datetime']));
        
        
        $hospitalization['discharge_date'] = $discharge_date;
        $hospitalization['drop_back_datetime'] = $drop_back_datetime;
        $hospitalization['inter_hosp_details'] = json_encode($intra);
        
        $result = $this->emt_model->update_stud_hospitalizaion($hospitalization);
        
        if ($result) {
            
            $this->output->message = "<div class='success'>" . "Intra Hospitalisation updated successfully" . "<script>$('#hosp_step_three').click();</script></div>";

        }else{
            $this->output->message = "<div class='success'>" . "Error Occure" . "</div>";
            $this->output->add_to_position($this->load->view('frontend/hosp_follow/intra_hosp_view', $data, TRUE), 'content', TRUE);
        }
        
    }
     function save_post_hospitalisation(){
        
        $intra= $this->input->post('intra');
        $hospitalization = $this->input->post('hosp');
        
        $discharge_date= date('Y-m-d',strtotime($hospitalization['discharge_date']));
        $drop_back_datetime= date('Y-m-d H:i:s',strtotime($hospitalization['drop_back_datetime']));
        

        $result = $this->emt_model->update_stud_hospitalizaion($hospitalization);
        
        if ($result) {
            
            $this->output->message = "<div class='success'>" . "Post Hospitalisation updated successfully" . "</div>";

        }else{
            $this->output->message = "<div class='success'>" . "Error Occure" . "</div>";
            $this->output->add_to_position($this->load->view('frontend/hosp_follow/post_hospitalisation_view', $data, TRUE), 'content', TRUE);
        }
        
    }

}
