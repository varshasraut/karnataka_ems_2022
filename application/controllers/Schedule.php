<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Schedule extends EMS_Controller {
    function __construct() {

        parent::__construct();

        $this->active_module = "M-SCHEDULE";

        $this->pg_limit = $this->config->item('pagination_limit');

        $this->pg_limits = $this->config->item('report_clg');

        $this->load->model(array('call_model', 'get_city_state_model', 'options_model', 'module_model', 'common_model','inc_model','colleagues_model','school_model','schedule_model','student_model','emt_model'));

        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper', 'language_helper'));

        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));

        $this->site_name = $this->config->item('site_name');

        $this->site = $this->config->item('site');
		$this->clg = $this->session->userdata('current_user');
		
		

        $this->post['base_month'] = get_base_month();
        $this->clg = $this->session->userdata('current_user');
        $this->post['flt'] = 'true';
       $this->post = $this->input->get_post(NULL);

        
        if ($this->post['filters'] == 'reset') {
            $this->session->unset_userdata('schedule_item');
             $this->session->unset_userdata('filters');
        }
        if ($this->session->userdata('filters')['SCH']) {

            $this->fdata = $this->session->userdata('filters')['SCH'];
        }
		
       //  var_dump($this->fdata);
    }
    function schedule_listing(){
     
        //////////// Filter////////////
       
        $data['schedule_type'] = $this->input->post('schedule_type') ? $this->input->post('schedule_type') : $this->fdata['schedule_type'];
        $data['schedule_item'] = $this->input->post('schedule_item') ? $this->input->post('schedule_item') : $this->fdata['schedule_item'];
        $data['pg_rec'] = $this->post['pg_rec'] ? $this->input->post('pg_rec') : $this->fdata['pg_rec'];
        $data['filter'] = $this->input->post('filter');
        $scheduleflt['SCH'] = $data;
      
      
        ///////////set page number////////////////////
        $page_no = 1;
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        //////////////////////////limit & offset//////

        $data['get_count'] = TRUE;
        if($this->clg->clg_group == 'UG-EMTM'){
           $data['is_forward'] = '1';
           $data['show_approve'] = '1';
        }
        
        
        //var_dump($this->input->post('schedule_item'));
  
        $data['schedule_clusterid']= $this->clg->cluster_id;

        $data['total_count'] = $this->schedule_model->get_schedule_data($data);

        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
       
      

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;
        

        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;


        $this->session->set_userdata('filters', $scheduleflt);

        /////////////////////////////////////////////////////

        unset($data['get_count']);

        $data['result'] = $this->schedule_model->get_schedule_data($data, $offset, $limit);

        $data['cur_page'] = $page_no;
        $data['offset'] = $offset;

        $pgconf = array(
            'url' => base_url("schedule/schedule_listing"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        $data['pagination'] = get_pagination($pgconf);

        $this->output->add_to_position($this->load->view('frontend/schedule/schedule_list_view', $data, TRUE), $this->post['output_position'], TRUE);
        $this->output->add_to_position($this->load->view('frontend/schedule/schedule_filters_view', $data, TRUE), 'schedule_filters', TRUE);
    }
    
    function add_schedule(){
        
        if ($this->input->post('submit_schedule')) {
            
            $data = array(
                'schedule_date' => date('Y-m-d', strtotime($this->input->post('schedule_date'))),
                'schedule_time' => date('H:i:s', strtotime($this->input->post('schedule_time'))),
                'schedule_clusterid' => $this->input->post('schedule_clusterid'),
                'schedule_type' => $this->input->post('schedule_type'),
                'schedule_schoolid' => $this->input->post('schedule_schoolid'),
                'added_by' => $this->clg->clg_ref_id,
                'added_date' => date('Y-m-d H:i:s'),
                'modify_by' => $this->clg->clg_ref_id,
                'modify_date' => date('Y-m-d H:i:s')
            );
			$insert = $this->schedule_model->insert_schedule($data);
            
            $students = $this->input->post('student_');
            foreach($students as $student){
                $student_data = array(
                    'schedule_id' => $insert,
                    'stud_id' => $student,
                    'added_by' => $this->clg->clg_ref_id,
                    'added_date' => date('Y-m-d H:i:s'),
                    'modify_by' => $this->clg->clg_ref_id,
                    'modify_date' => date('Y-m-d H:i:s')
                );
                $insert_student = $this->schedule_model->insert_schedule_student($student_data);
                
                $update_stud_args = array('stud_id' =>$student,
                                          'stud_status' => '0');
                
                 $insert_student = $this->student_model->updte_student_details($update_stud_args,$update_stud_args);
                
               
            }
            
            
			if (!$insert) {
				$this->output->message = "<div class='error'>Not saved.. please retry</div>";
			} else {
				$this->output->closepopup = 'yes';
				$this->output->status = 1;
				$this->output->message = "<div class='success'>" . "Schedule details is added successfully" . "</div>";
				$this->schedule_listing();
			}
        }
        
        $this->output->add_to_position($this->load->view('frontend/schedule/add_schedule_view', $data, TRUE), 'popup_div', TRUE);
    }
    
    function edit_schedule(){
        $data['schedule_action'] = $this->input->post('schedule_action');
        if ($this->input->post('schedule_id') != '') {
            $schedule_id = array_map("base64_decode", $this->input->post('schedule_id'));
        }
        if ($this->input->post('submit_schedule', TRUE)) {
            
            $data = array(
                'schedule_id' => $schedule_id[0],
                'schedule_date' => date('Y-m-d', strtotime($this->input->post('schedule_date'))),
                'schedule_time' => date('H:i:s', strtotime($this->input->post('schedule_time'))),
                'schedule_clusterid' => $this->input->post('schedule_clusterid'),
                'schedule_schoolid' => $this->input->post('schedule_schoolid'),
                'modify_by' => 1,
                'modify_date' => date('Y-m-d')
            );
            
            $update = $this->schedule_model->update_schedule($data);
            
            $delete_args = array( 'schedule_id' => $schedule_id[0]);
            $update = $this->schedule_model->delete_schedule_student($data);
            
            $students = $this->input->post('student_');
            
            foreach($students as $student){
                
                $student_data = array(
                    'schedule_id' => $schedule_id[0],
                    'stud_id' => $student,
                    'modify_by' => $this->clg->clg_ref_id,
                    'modify_date' => date('Y-m-d H:i:s')
                );
                $insert_student = $this->schedule_model->insert_schedule_student($student_data);
                
                $update_stud_args = array('stud_id' =>$student,
                                          'stud_status' => '0');
                
                 $insert_student = $this->student_model->updte_student_details($update_stud_args,$update_stud_args);
            }

            if ($update) {
                $this->output->status = 1;
                $this->output->closepopup = "yes";
                $this->output->message = "<div class='success'>Schedule details updated successfully</div>";
                $this->schedule_listing($post_data);
            } else {
                $this->output->message = "<div class='error'>Schedule details is not updated.</div>";
            }
        }



        $data['schedule_id'] = $schedule_id[0];
        $data['update'] = $this->schedule_model->get_schedule_data($data);

        $this->output->add_to_position($this->load->view('frontend/schedule/add_schedule_view', $data, TRUE), 'popup_div', TRUE);
        $args = array('schedule_id' => $schedule_id[0]);
  
        $data['students_seleted'] = $this->student_model->get_search_stud_by_shedule_id($args);
        
        foreach($data['students_seleted'] as $selected){
            $student[] = $selected->stud_id;
        }
        $selected_stud = implode("','", $student);
        $args_student = array('school_id'=>$data['update'][0]->schedule_schoolid,'stud_id'=>$selected_stud);
        $data['students'] = $this->schedule_model->get_student_list_to_schedule($args_student);
        $this->output->add_to_position($this->load->view('frontend/schedule/stuedent_checklist_view', $data, TRUE), 'student_check_list', TRUE);
        
    }
    
    function del_schedule(){
        $data['schedule_action'] = $this->input->post('schedule_action');
        if ($this->input->post('schedule_id') != '') {
            $schedule_id = array_map("base64_decode", $this->input->post('schedule_id'));
        }
        if (empty($schedule_id)) {
            $this->output->message = "<div class='error'>Please select at least one item to delete</div>";
            return;
        }
        $args['schedule_isdeleted'] = '1';

        $status = $this->schedule_model->delete_schedule($schedule_id, $args);
        
        if ($status) {
            $this->output->message = "<div class='success'>Schedule details deleted successfully.</div>";
            $this->schedule_listing();
        } else {
            $this->output->message = "<div class='error'>Schedule details deleted successfully.</div>";
        }
        
    }
//    function shamschedule_listing(){
//                //////////// Filter////////////
//
//        $data['schedule_date'] = ($this->post['schedule_date']) ? $this->post['schedule_date'] : $this->fdata['schedule_date'];
//        $data['schedule_type'] = ($this->post['schedule_type']) ? $this->post['schedule_type'] : $this->fdata['schedule_type'];
//        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
//        $shamscheduleflt['SHAMSCHEDULE'] = $data;
//
//        ///////////set page number////////////////////
//        $page_no = 1;
//        if ($this->uri->segment(3)) {
//            $page_no = $this->uri->segment(3);
//        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
//            $page_no = $this->fdata['page_no'];
//        }
//        //////////////////////////limit & offset//////
//
//        $data['get_count'] = TRUE;
//
//        $data['total_count'] = $this->schedule_model->get_schedule_data($data);
//
//        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
//
//        $page_no = get_pgno($data['total_count'], $limit, $page_no);
//
//        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;
//
//        /////////////////////////////////////////////////////////
//
//        $data['page_no'] = $page_no;
//
//        $shamscheduleflt['SHAMSCHEDULE'] = $data;
//
//        $this->session->set_userdata('filters', $shamscheduleflt);
//
//        /////////////////////////////////////////////////////
//
//        unset($data['get_count']);
//
//        $data['result'] = $this->schedule_model->get_schedule_data($data, $offset, $limit);
//
//        $data['cur_page'] = $page_no;
//
//        $pgconf = array(
//            'url' => base_url("schedule/shamschedule_listing"),
//            'total_rows' => $data['total_count'],
//            'per_page' => $limit,
//            'cur_page' => $page_no,
//            'attributes' => array('class' => 'click-xhttp-request',
//                'data-qr' => "output_position=content&amp;pglnk=true"
//            )
//        );
//
//        $data['pagination'] = get_pagination($pgconf);
//        
//        $this->output->add_to_position($this->load->view('frontend/schedule/shamschedule_list_view', $data, TRUE), $this->post['output_position'], TRUE);
//
//        $this->output->add_to_position($this->load->view('frontend/schedule/shamschedule_filters_view', $data, TRUE), 'shamschedule_filters', TRUE);
//    }
    function approve_schedule(){
        $data['schedule_action'] = $this->input->post('schedule_action');
    
        if(is_array($this->input->post('schedule_id'))){
            $schedule_id = implode(',',$this->input->post('schedule_id'));

        }else{
            $schedule_id = base64_decode( $this->input->post('schedule_id'));
        }

        if (empty($schedule_id)) {
            $this->output->message = "<div class='error'>Please select at least one item to approve</div>";
            return;
        }
        $args = array('schedule_isaprove' => $this->input->post('isaprove'));
        

        $status = $this->schedule_model->approve_schedule($schedule_id, $args);
    
        
        if ($status) {
            $this->output->message = "<div class='success'>Schedule approved successfully.</div>";
            $this->schedule_listing();
        } else {
            $this->output->message = "<div class='error'>Schedule not approved.</div>";
        }
        
    }
    
    function open_student_list_schedule(){

        ///////////set page number////////////////////
        $page_no = 1;
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        //////////////////////////limit & offset//////

        $data['get_count'] = TRUE;

        $data['total_count'] = $this->schedule_model->get_student_list_schedule_data($data);

        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

       

        /////////////////////////////////////////////////////

        unset($data['get_count']);


        $data['result'] = $this->schedule_model->get_student_list_schedule_data($data, $offset, $limit);

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("schedule/studentschedule_listing"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        $data['pagination'] = get_pagination($pgconf);
        
        $this->output->add_to_position($this->load->view('frontend/schedule/studentschedule_list_view', $data, TRUE), $this->post['output_position'], TRUE);

    }
    
    function forword_to_shpm(){

        $data['schedule_action'] = $this->input->post('schedule_action');
        $schedule_id = $this->input->post('schedule_id');
        
        if (!empty($schedule_id)) {
            
            $args['schedule_id'] = base64_decode($schedule_id[0]);
        }
        
        if (empty($args)) {
            $this->output->message = "<div class='error'>Please select at least one item to forward</div>";
            return;
        }
        $args['schedule_fwdshpm'] = '1';
        
        $status = $this->schedule_model->forword_to_shpm($args);
        
        if ($status) {
            $this->output->message = "<div class='success'>Schedule forwarded successfully.</div>";
            $this->schedule_listing();
        } else {
            $this->output->message = "<div class='error'>Schedule not forwarded.</div>";
        }
        
    }
    function cluster_schools(){
        $cluster_id = $this->input->post('cluster_id');
        //$clean = trim($cluster_id,'"');
        $data['cluster_id'] = $cluster_id;
        $this->output->add_to_position($this->load->view('frontend/schedule/cluster_schools_view', $data, TRUE), 'schedule_clusterid', TRUE);
    }
    
    function student_checklist(){
        $school_id = $this->input->post('school_id');
        //$clean = trim($cluster_id,'"');
        
        $data['school_id'] = $school_id;
        $args = array('school_id'=>$school_id);
        
        $data['students'] = $this->schedule_model->get_student_list_to_schedule($args);
        
        $this->output->add_to_position($this->load->view('frontend/schedule/stuedent_checklist_view', $data, TRUE), 'student_check_list', TRUE);
    }
}