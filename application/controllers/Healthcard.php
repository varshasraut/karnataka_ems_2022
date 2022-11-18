<?php 
Class Healthcard extends EMS_Controller {
    
    function __construct() {
        parent::__construct();

        $this->active_module = "M-HEALTHCARD";

        $this->load->model(array('dashboard_model', 'users_model','student_model','emt_model','prescription_model','sickroom_model','hp_model'));

        $this->pg_limit = $this->config->item('pagination_limit');
         $this->healthcar_path= $this->config->item('healthcards');
        $this->clg = $this->session->userdata('current_user');
        $this->post = $this->input->get_post(NULL);
    }
    
    function healthcard_list(){

        $this->pg_limit = 50;
        $data['stud_search'] = ($this->post['stud_search']) ? $this->post['stud_search'] : $this->fdata['stud_search'];
        $data['page_no'] = ($this->post['page_no'] || $this->post['pglnk']) ? $this->post['page_no'] : $this->fdata['page_no'];
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        
        $page_no = 1;
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
            
        }
        
        
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

           $args_dash = array(     
               'base_month' => $this->post['base_month'],
               'stud_status'=>1
           );
      
        
        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;
        
        $data['page_no'] = $page_no;

        $data['get_count'] = TRUE;
        
        
        
        
        $total_cnt = $this->student_model->get_all_students($args_dash,'','',$data['stud_search'],$sortby);

        $stud_info = $this->student_model->get_all_students($args_dash, $offset, $limit,$data['stud_search'],$sortby);
     
    
        

        $data['per_page'] = $limit;
        $data['inc_offset'] = $offset;

        $data['student_data'] = $stud_info;

        $data['total_count'] = count($total_cnt);
       
        $data['per_page'] = $limit;

        $pgconf = array(
            'url' => base_url("healthcard/healthcard_list"),
            'total_rows' => count($total_cnt),
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
            'data-qr' => "output_position=content&amp;pglnk=true&amp;type=healthcard"
            )
        );


        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);

        $this->output->add_to_position($this->load->view('frontend/healthcard/healthcard_list_view', $data, TRUE), $this->post['output_position'], TRUE);
        $this->output->add_to_position($this->load->view('frontend/healthcard/student_filters_view', $data, TRUE), 'healthcard_filters', TRUE);

         
    }
    function view_health_card(){
       
        $stud_id =  base64_decode($this->input->post('stud_id'));

        
        $args_dash = array('stud_id' => $stud_id);
        $data['stud_last_schedule'] = $this->student_model->get_last_schedule($args_dash);
        $schedule_id = $data['stud_last_schedule'][0]->schedule_id;

        
        $stud_array = array('stud_id' => $stud_id,'schedule_id' =>$schedule_id);

        $data['stud_info'] = $this->student_model->get_all_students($stud_array);
        $data['stud_basic_info'] = $this->student_model->get_stud_basic_info($stud_array);
        
        
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
        
        
        $data['stud_prescriptionp'] = $this->emt_model->get_stud_prescription($stud_array);
        $data['stud_investigation']= $this->emt_model->get_stud_investigation($stud_array);
        $test_title = (json_decode($data['stud_investigation'][0]->test_title));
        $test_array = array();
        foreach($test_title as $test){
            $test_array[] = $test;
        }
        $data['test_array'] = $test_array;
       

        $schedule_count = 5;
        $schedule_list = $this->student_model->get_last_schedule($args_dash,$schedule_count);
       //var_dump($schedule_list);
        foreach($schedule_list as $schedule){
            $stud_checked_checkbox_sch = array();
           
            $stud_sch_array = array('stud_id' => $stud_id,'schedule_id' =>$schedule->schedule_id);
           
            $stud['stud_screen_chekbox_sch'] = $this->student_model->get_stud_screening($stud_sch_array);
            $medicle = $this->emt_model->get_stud_medicle_exam($stud_sch_array);
            $chief_complaint = $medicle[0]->chief_complaint;
            $symptoms = $medicle[0]->symptoms;
            

         
            if ($stud['stud_screen_chekbox_sch'][0]->birth_deffects != 'null' && $stud['stud_screen_chekbox_sch'][0]->birth_deffects != NULL) {
                $birth_defects = array('id' => json_decode(($stud['stud_screen_chekbox_sch'][0]->birth_deffects), TRUE));
                if(!empty($birth_defects['id'])){
                    $data['birth_defects_chekbox'] = $this->common_model->get_birth_effects($birth_defects);
                    foreach ($data['birth_defects_chekbox'] as $key => $value) {
                        $stud_checked_checkbox_sch['birth_defects'][] = $value->birth_effects_title;
                    }
                }
            }
            if ($stud['stud_screen_chekbox_sch'][0]->checkbox_if_normal != 'null' && $stud['stud_screen_chekbox_sch'][0]->checkbox_if_normal != NULL) {
                $checkbox_if_normal = array('id' => json_decode(($stud['stud_screen_chekbox_sch'][0]->checkbox_if_normal)));
                if(!empty($checkbox_if_normal['id'])){
                    $data['checkbox_if_normal_chekbox'] = $this->common_model->get_normal_checkbox($checkbox_if_normal);
                    foreach ($data['checkbox_if_normal_chekbox'] as $key => $value) {

                        $stud_checked_checkbox_sch['checkbox_if_normal'][] = $value->normal_checkbox_title;
                    }
                }
            }
            if ($stud['stud_screen_chekbox_sch'][0]->diagnosis != 'null' && $stud['stud_screen_chekbox_sch'][0]->diagnosis != NULL) {
                $diagnosis = array('id' => json_decode(($stud['stud_screen_chekbox_sch'][0]->diagnosis)));
                if(!empty($diagnosis['id'])){
                    $data['diagnosis_chekbox'] = $this->common_model->get_diagnosis($diagnosis);
                    foreach ($data['diagnosis_chekbox'] as $key => $value) {
                        $stud_checked_checkbox_sch['diagnosis'][] = $value->diagnosis_title;
                    }
                }
            }
            if ($stud['stud_screen_chekbox_sch'][0]->skin_condition != 'null' && $stud['stud_screen_chekbox_sch'][0]->skin_condition != NULL) {
                $skin_condition = array('id' => json_decode(($stud['stud_screen_chekbox_sch'][0]->skin_condition)));
                $data['skin_condition_chekbox'] = $this->common_model->get_skin_condition($skin_condition);
                foreach ($data['skin_condition_chekbox'] as $key => $value) {
                    $stud_checked_checkbox_sch['skin_condition'][] = $value->skin_condition_title;
                }
            }
            if ($stud['stud_screen_chekbox_sch'][0]->deficiencies != 'null' && $stud['stud_screen_chekbox_sch'][0]->deficiencies != NULL) {
                $deficiencies = array('id' => json_decode(($stud['stud_screen_chekbox_sch'][0]->deficiencies)));
                $data['deficiencies_chekbox'] = $this->common_model->get_deficiencies($deficiencies);
                foreach ($data['deficiencies_chekbox'] as $key => $value) {
                    $stud_checked_checkbox_sch['deficiencies'][] = $value->deficiencies_title;
                }
            }
            if ($stud['stud_screen_chekbox_sch'][0]->childhood_disease != 'null' && $stud['stud_screen_chekbox_sch'][0]->childhood_disease != NULL) {
                $childhood_disease = array('id' => json_decode(($stud['stud_screen_chekbox_sch'][0]->childhood_disease)));
                $data['childhood_disease_chekbox'] = $this->common_model->get_childhood_disease($childhood_disease);
                foreach ($data['childhood_disease_chekbox'] as $key => $value) {


                    $stud_checked_checkbox_sch['childhood_disease'][] = $value->childhood_disease_title;
                }
            }

            $stud['stud_auditary_checkbox'] = $this->emt_model->get_stud_ent($stud_sch_array);
            if ($stud['stud_auditary_checkbox'][0]->ent_check_if_present != 'null' && $stud['stud_auditary_checkbox'][0]->ent_check_if_present != NULL) {
                $ent_check_if_present = array('id' => json_decode($stud['stud_auditary_checkbox'][0]->ent_check_if_present));
                $data['ent_check_if_present_chekbox'] = $this->common_model->get_auditary($ent_check_if_present);
                foreach ($data['ent_check_if_present_chekbox'] as $key => $value) {

                    $stud_checked_checkbox_sch['ent_check_if_present'][] = $value->auditary_title;
                }
            }
            $stud['stud_vision_checkbox'] = $this->emt_model->get_stud_vision($stud_sch_array);
           
            if ($stud['stud_vision_checkbox'][0]->opthalmological != 'null' && $stud['stud_vision_checkbox'][0]->opthalmological != NULL) {
                $opthalmological = array('id' => json_decode($stud['stud_vision_checkbox'][0]->opthalmological));
                $data['opthalmological_chekbox'] = $this->common_model->get_opthalmological($opthalmological);

                foreach ($data['opthalmological_chekbox'] as $key => $value) {

                    $stud_checked_checkbox_sch['opthalmological'][] = $value->opthalmological_title;
                    
                   
                }
            }
            
            $stud_prescription = $this->emt_model->get_stud_prescription($stud_sch_array);
            
            $stud_hospital =$this->emt_model->get_stud_hospitalizaion($stud_sch_array);
            if($medicle[0]->remark == 'treated_at_scene'){
                $remark = 'Treated at scene';
            }else if($medicle[0]->remark == 'treated_at_sick_room'){
                $remark = 'Treated at scene';
            }else if( $medicle[0]->remark ==  'admitted_in_hospital'){
                $hp_args = array('hp_id' => $stud_hospital[0]->hosp_id);
                $hp_data = $this->hp_model->get_hp_data($hp_args);
             
                $remark = "Admitted in '" + $hp_data[0]->hp_name + "' hospital";
            }
            
            $stduent_sch[] = array( 'student_data'   => $stud_checked_checkbox_sch,
                                    'schedule_date'  => $schedule->schedule_date,
                                    'symptoms'       => $symptoms,
                                    'chief_complaint' => $chief_complaint,
                                    'stud_id' => $stud_id,
                                    'stud_prescription' => $stud_prescription[0]->drug_details,
                                    'schedule_id' =>$schedule->schedule_id,
                                    'remark'=>$remark
                                    );
            
        }
        
        $data['previous_schedules'] =  $stduent_sch;
        
        $this->output->add_to_position($this->load->view('frontend/healthcard/student_healthcard_view', $data, true));
        
    }
    
    function download_healthcard_link(){
        
        $stud_id = base64_decode($this->input->post('student_id'));
        $student_id = base64_decode($this->input->post('student_id'));
        
        $dis_file_name = $this->healthcar_path.'/healthcard_'.$student_id.'.pdf';
        
        $url = base_url().'healthcard/download_healthcard?student_id='.$stud_id;
        $js_url = FCPATH."healthcard_pdf_script.js";
        $phontam_js = "/var/wamp/www/phantomjs/phantomjs-1.9.8-linux-x86_64/bin/phantomjs";
      
        $output =  shell_exec("$phontam_js $js_url $url $dis_file_name");
        
       // if($output == 'success'){
            
          
            $fullfile = FCPATH.$dis_file_name;
            $pdf_file_name = 'healthcard_'.$student_id.'.pdf';

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

       // }
        
    }
    function download_healthcard(){
       
        $this->post['student_id'] = ($this->input->get('student_id'));
        $stud_id =  $this->post['student_id'];
        
        $args_dash = array('stud_id' => $stud_id);
        $data['stud_last_schedule'] = $this->student_model->get_last_schedule($args_dash);
        $schedule_id = $data['stud_last_schedule'][0]->schedule_id;

        
        $stud_array = array('stud_id' => $stud_id,'schedule_id' =>$schedule_id);
        
        $data['stud_info'] = $this->student_model->get_all_students($stud_array);
        $data['stud_basic_info'] = $this->student_model->get_stud_basic_info($stud_array);
        
        
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
               
            }
        }
        $stduent['student_data'][] = $stud_checked_checkbox;
               
        
        $data['diagonosis'] = $stduent['student_data'][0];
        $data['stud_prescriptionp'] = $this->emt_model->get_stud_prescription($stud_array);
        
        $data['stud_investigation']= $this->emt_model->get_stud_investigation($stud_array);
        $test_title = (json_decode($data['stud_investigation'][0]->test_title));
        $test_array = array();
        foreach($test_title as $test){
            $test_array[] = $test;
        }
        $data['test_array'] = $test_array;
        
        $schedule_count = 5;
        $schedule_list = $this->student_model->get_last_schedule($args_dash,$schedule_count);
       
        foreach($schedule_list as $schedule){
            $stud_checked_checkbox_sch = array();
           
            $stud_sch_array = array('stud_id' => $stud_id,'schedule_id' =>$schedule->schedule_id);;
           
            $stud['stud_screen_chekbox_sch'] = $this->student_model->get_stud_screening($stud_sch_array);
            $medicle = $this->emt_model->get_stud_medicle_exam($stud_sch_array);
            $chief_complaint = $medicle[0]->chief_complaint;
            $symptoms = $medicle[0]->symptoms;
            
            $stud_prescription = $this->emt_model->get_stud_prescription($stud_sch_array);
            

         
            if ($stud['stud_screen_chekbox_sch'][0]->birth_deffects != 'null' && $stud['stud_screen_chekbox_sch'][0]->birth_deffects != NULL) {
                $birth_defects = array('id' => json_decode(($stud['stud_screen_chekbox_sch'][0]->birth_deffects), TRUE));
                $data['birth_defects_chekbox'] = $this->common_model->get_birth_effects($birth_defects);
                foreach ($data['birth_defects_chekbox'] as $key => $value) {
                    $stud_checked_checkbox_sch['birth_defects'][] = $value->birth_effects_title;
                }
            }
            if ($stud['stud_screen_chekbox_sch'][0]->checkbox_if_normal != 'null' && $stud['stud_screen_chekbox_sch'][0]->checkbox_if_normal != NULL) {
                $checkbox_if_normal = array('id' => json_decode(($stud['stud_screen_chekbox_sch'][0]->checkbox_if_normal)));
                $data['checkbox_if_normal_chekbox'] = $this->common_model->get_normal_checkbox($checkbox_if_normal);
                foreach ($data['checkbox_if_normal_chekbox'] as $key => $value) {

                    $stud_checked_checkbox_sch['checkbox_if_normal'][] = $value->normal_checkbox_title;
                }
            }
            if ($stud['stud_screen_chekbox_sch'][0]->diagnosis != 'null' && $stud['stud_screen_chekbox_sch'][0]->diagnosis != NULL) {
                $diagnosis = array('id' => json_decode(($stud['stud_screen_chekbox_sch'][0]->diagnosis)));
                $data['diagnosis_chekbox'] = $this->common_model->get_diagnosis($diagnosis);
                foreach ($data['diagnosis_chekbox'] as $key => $value) {
                    $stud_checked_checkbox_sch['diagnosis'][] = $value->diagnosis_title;
                }
            }
            if ($stud['stud_screen_chekbox_sch'][0]->skin_condition != 'null' && $stud['stud_screen_chekbox_sch'][0]->skin_condition != NULL) {
                $skin_condition = array('id' => json_decode(($stud['stud_screen_chekbox_sch'][0]->skin_condition)));
                $data['skin_condition_chekbox'] = $this->common_model->get_skin_condition($skin_condition);
                foreach ($data['skin_condition_chekbox'] as $key => $value) {
                    $stud_checked_checkbox_sch['skin_condition'][] = $value->skin_condition_title;
                }
            }
            if ($stud['stud_screen_chekbox_sch'][0]->deficiencies != 'null' && $stud['stud_screen_chekbox_sch'][0]->deficiencies != NULL) {
                $deficiencies = array('id' => json_decode(($stud['stud_screen_chekbox_sch'][0]->deficiencies)));
                $data['deficiencies_chekbox'] = $this->common_model->get_deficiencies($deficiencies);
                foreach ($data['deficiencies_chekbox'] as $key => $value) {
                    $stud_checked_checkbox_sch['deficiencies'][] = $value->deficiencies_title;
                }
            }
            if ($stud['stud_screen_chekbox_sch'][0]->childhood_disease != 'null' && $stud['stud_screen_chekbox_sch'][0]->childhood_disease != NULL) {
                $childhood_disease = array('id' => json_decode(($stud['stud_screen_chekbox_sch'][0]->childhood_disease)));
                $data['childhood_disease_chekbox'] = $this->common_model->get_childhood_disease($childhood_disease);
                foreach ($data['childhood_disease_chekbox'] as $key => $value) {


                    $stud_checked_checkbox_sch['childhood_disease'][] = $value->childhood_disease_title;
                }
            }

            $stud['stud_auditary_checkbox'] = $this->emt_model->get_stud_ent($stud_sch_array);
            if ($stud['stud_auditary_checkbox'][0]->ent_check_if_present != 'null' && $stud['stud_auditary_checkbox'][0]->ent_check_if_present != NULL) {
                $ent_check_if_present = array('id' => json_decode($stud['stud_auditary_checkbox'][0]->ent_check_if_present));
                $data['ent_check_if_present_chekbox'] = $this->common_model->get_auditary($ent_check_if_present);
                foreach ($data['ent_check_if_present_chekbox'] as $key => $value) {

                    $stud_checked_checkbox_sch['ent_check_if_present'][] = $value->auditary_title;
                }
            }
            $stud['stud_vision_checkbox'] = $this->emt_model->get_stud_vision($stud_sch_array);
           
            if ($stud['stud_vision_checkbox'][0]->opthalmological != 'null' && $stud['stud_vision_checkbox'][0]->opthalmological != NULL) {
                $opthalmological = array('id' => json_decode($stud['stud_vision_checkbox'][0]->opthalmological));
                $data['opthalmological_chekbox'] = $this->common_model->get_opthalmological($opthalmological);

                foreach ($data['opthalmological_chekbox'] as $key => $value) {

                    $stud_checked_checkbox_sch['opthalmological'][] = $value->opthalmological_title;
                    
                   
                }
            }
            
            $stud_hospital =$this->emt_model->get_stud_hospitalizaion($stud_sch_array);
            $remark = "";
            if($medicle[0]->remark == 'treated_at_scene'){
                $remark = 'Treated at scene';
            }else if($medicle[0]->remark == 'treated_at_sick_room'){
                $remark = 'Treated at scene';
            }else if( $medicle[0]->remark ==  'admitted_in_hospital'){
                $hp_args = array('hp_id' => $stud_hospital[0]->hosp_id);
                $hp_data = $this->hp_model->get_hp_data($hp_args);
             
                $remark = "Admitted in '" + $hp_data[0]->hp_name + "' hospital";
            }

          
            $stduent_sch[] = array('student_data' => $stud_checked_checkbox_sch,
                                   'symptoms'       => $symptoms,
                                   'chief_complaint' => $chief_complaint,
                                   'stud_prescription' => $stud_prescription[0]->drug_details,
                                   'remark' =>$remark,
                                   'schedule_date' => $schedule->schedule_date);
//                    if (isset($stduent_sch['student_data'][0])) {
//                        break;
//            }
        }
        
       
        $data['previous_schedules'] =  $stduent_sch;
        
        $this->output->add_to_position($this->load->view('frontend/healthcard/healthcard_view', $data, true));
        $this->output->template = "cell";
        
    }
   function previous_healthcard(){
       
        $stud_id =  $this->input->post('stud_id');
        $schedule_id =  $this->input->post('schedule_id');
        $data['action'] = $this->input->post('action');
        
        $args_dash = array('stud_id' => $stud_id);
        
        $stud_array = array('stud_id' => $stud_id,'schedule_id' =>$schedule_id);

        $data['stud_info'] = $this->student_model->get_all_students($stud_array);
        $data['stud_basic_info'] = $this->student_model->get_stud_basic_info($stud_array);
        
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
               
            }
        }
        $stduent['student_data'][] = $stud_checked_checkbox;
               
        
        $data['diagonosis'] = $stduent['student_data'][0];
        
        $data['stud_prescriptionp'] = $this->emt_model->get_stud_prescription($stud_array);
        $data['stud_hospitalization'] = $this->prescription_model->get_hospitalization($stud_array);
        
        $data['stud_sickroom'] = $this->sickroom_model->get_sickroom($stud_array);

        
        $this->output->add_to_popup($this->load->view('frontend/healthcard/previous_healthcard_view', $data, TRUE), '1000', '800');
       // $this->output->add_to_position($this->load->view('frontend/healthcard/previous_healthcard_view', $data, true));
        
   }
}