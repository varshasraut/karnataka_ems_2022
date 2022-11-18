<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sickroom extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));
        $this->load->model(array('sickroom_model','student_model','common_model','emt_model','school_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper', 'language_helper'));


        $this->post = $this->input->get_post(NULL);
        $this->post['base_month'] = get_base_month();
        $this->clg = $this->session->userdata('current_user');
        $this->active_module = "M-SICK-ROOM";

        $this->pg_limit = 50;
        $this->pg_limits = $this->config->item('report_clg');

        $this->steps_cnt = $this->config->item('screening_steps');

        $this->today = date('Y-m-d H:i:s');
    }

    function sickroom_stud_list() {
        
        //////////// Filter////////////

        $data['sick_search'] = ($this->post['sick_search']) ? $this->post['sick_search'] : $this->fdata['sick_search'];
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
        //$data['clg_ref_id'] = $this->clg->clg_ref_id;

        $data['total_count'] = $this->sickroom_model->get_sickroom($data);
        

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
        $data['result'] = $this->sickroom_model->get_sickroom($data, $offset, $limit);

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("sickroom/sickroom_stud_list"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
            'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        $data['pagination'] = get_pagination($pgconf);
        
        $this->output->add_to_position($this->load->view('frontend/sickroom/sickroom_list_view', $data, TRUE), $this->post['output_position'], TRUE);

        $this->output->add_to_position($this->load->view('frontend/sickroom/sickroom_filters_view', $data, TRUE), 'sickroom_filters', TRUE);
    }
    function view_sickroom(){
        

        $sick_id =  base64_decode($this->input->post('sick_id'));
        
        $data['sick_id'] = $sick_id;

        $data['stud_sickroom'] = $this->sickroom_model->get_sickroom($data);
        
        
         $args = array(
            'sick_id' => $sick_id,
            'base_month' => $this->post['base_month']
        );

        /////////////////////////////////////////////////////////////////////

        $min = array(10, 20, 30, 40);

        foreach ($min as $mn) {

            $args['asst_min'] = $mn;

            $asst_min = "min_asst" . $mn;

            $data[$asst_min] = $this->sickroom_model->get_sick_asst($args);
        }
        
        $this->output->add_to_position($this->load->view('frontend/sickroom/sickroom_open_view', $data, TRUE), $this->post['output_position'], TRUE);
        
    }
    function save_sickroom(){

       
        if($this->post['action'] == '2'){
             $status = '1';
        }else if($this->post['action'] == '3'){
             $status = '2';
        }else{
             $status = '0';
        }

        
        $sick_data = array(
            'sick_id' => $this->post['sick_id'],
            'student_id' =>$this->post['student_id'],
            'schedule_id' =>$this->post['schedule_id'],
            'asst_base_month' => $this->post['base_month'],
            'asst_date' => $this->today
        );
        
        $sick_data_args = array(
            'student_id' =>$this->post['student_id'],
            'schedule_id' =>$this->post['schedule_id'],
            'sick_status' => $status
        );

        $min = array(10, 20, 30, 40);

        foreach ($min as $mn) {

            $asst_min = "sick_asst" . $mn;

            $args = array_merge(array('asst_min' => (string) $mn), $this->post[$asst_min]);

            $sick_asst = array_merge($args, $sick_data);

            $res = $this->sickroom_model->save_sick_asst($sick_asst);
        }
        
        $sickroom_date= array_merge($this->post['sick'], $sick_data_args);

        $res = $this->sickroom_model->updte_sickroom_details($sick_data_args,$sickroom_date);



        //////////////////////////////////////////////////////////

        $this->output->message = "<div class='success'>Saved successfully</div>";
        $this->sickroom_stud_list();
    }
    
    function sickroom_addmission_list(){
        
        //////////// Filter////////////

        $data['sick_ad_search'] = ($this->post['sick_ad_search']) ? $this->post['sick_ad_search'] : $this->fdata['sick_ad_search'];
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $ambflt['SICK_AD'] = $data;

        ///////////set page number////////////////////
        
        $page_no = 1;
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        //////////////////////////limit & offset//////

        $data['get_count'] = TRUE;
        //$data['clg_ref_id'] = $this->clg->clg_ref_id;

        $data['total_count'] = $this->sickroom_model->get_sickroom_addmission($data);
        

        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['SICK_AD'] = $data;

        $this->session->set_userdata('filters', $ambflt);

        /////////////////////////////////////////////////////

        unset($data['get_count']);

        $data['offset'] = $offset;
        $data['result'] = $this->sickroom_model->get_sickroom_addmission($data, $offset, $limit);

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("sickroom/sickroom_stud_list"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
            'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        $data['pagination'] = get_pagination($pgconf);

        $this->output->add_to_position($this->load->view('frontend/sickroom/sickroom_admission_list', $data, TRUE), $this->post['output_position'], TRUE);
        $this->output->add_to_position($this->load->view('frontend/sickroom/sickroom_filters_view', $data, TRUE), 'sickroom_filters', TRUE);
    }
    
    function add_to_sickroom(){
        
        $this->output->add_to_position($this->load->view('frontend/sickroom/sickroom_admission_view', $data, TRUE), 'popup_div', TRUE);
    }
    
    function get_student_by_school(){
        $data['school_id'] =$this->input->post('school_id');
        $this->output->add_to_position($this->load->view('frontend/sickroom/get_student_by_school', $data, TRUE), 'school_student_data', TRUE);
    }
    function save_add_sickroom(){

         if($this->post['action'] == '2'){
             $status = '1';
        }else if($this->post['action'] == '3'){
             $status = '2';
        }else{
             $status = '0';
        }
        
        $sick_data_args = array(
            'student_id' =>$this->post['student_id'],
            'sickroom_id' =>$this->post['sickroom_id'],
            'school_id' =>$this->post['school_id'],
            'sick_status' => $status,
            'sick_base_month' => $this->post['base_month'],
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s') 
        );            

        $res = $this->sickroom_model->insert_add_sickroom_details($sick_data_args);
        
        $sick_data = array(
            'sick_id' =>$res,
            'student_id' =>$this->post['student_id'],    
            'asst_base_month' => $this->post['base_month'],
            'asst_date' => $this->today,
            'asst_type' =>'admsn');

        $min = array(10, 20, 30, 40);

        foreach ($min as $mn) {

            $asst_min = "sick_asst" . $mn;

            $args = array_merge(array('asst_min' => (string) $mn), $this->post[$asst_min]);

            $sick_asst = array_merge($args, $sick_data);

            $res = $this->sickroom_model->save_sick_asst($sick_asst);
        }
        


        //////////////////////////////////////////////////////////

        $this->output->message = "<div class='success'>Saved successfully</div>";
        $this->sickroom_addmission_list();
    }
     function view_add_sickroom(){
        

        $sick_id =  base64_decode($this->input->post('id'));
        
        $data['sick_id'] = $sick_id;
        $data['view'] = 'view';

        $data['stud_sickroom'] = $this->sickroom_model->get_sickroom_addmission($data);
        
        $student_args = array('stud_id'=>$data['stud_sickroom'][0]->student_id);
        
        $data['students'] = $this->student_model->get_all_students($student_args);
        
        $school_args = array('school_id'=>$data['stud_sickroom'][0]->school_id);
        
        $data['school'] = $this->school_model->get_school_data($school_args);
        
        $sickroom_args = array('school_id'=>$data['stud_sickroom'][0]->sickroom_id);
        
        $data['sickroom'] = $this->school_model->get_sickroom_type($sickroom_args);

        
         $args = array(
            'sick_id' => $sick_id,
            'base_month' => $this->post['base_month']
        );

        /////////////////////////////////////////////////////////////////////

        $min = array(10, 20, 30, 40);

        foreach ($min as $mn) {

            $args['asst_min'] = $mn;

            $asst_min = "min_asst" . $mn;

            $data[$asst_min] = $this->sickroom_model->get_sick_asst($args);
        }
        
        $this->output->add_to_position($this->load->view('frontend/sickroom/sickroom_admission_view', $data, TRUE), $this->post['output_position'], TRUE);
        
    }
}