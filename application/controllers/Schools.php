<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Schools extends EMS_Controller {
    function __construct() {

        parent::__construct();

        $this->active_module = "M-SCHO";

        $this->pg_limit = $this->config->item('pagination_limit');

        $this->pg_limits = $this->config->item('report_clg');

        $this->load->model(array('call_model', 'get_city_state_model', 'options_model', 'module_model', 'common_model', 'Pet_model', 'Ercp_model', 'amb_model','inc_model','colleagues_model','school_model','student_model','emt_model'));

        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper', 'language_helper'));

        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));

        $this->site_name = $this->config->item('site_name');

        $this->site = $this->config->item('site');
		$this->clg = $this->session->userdata('current_user');
		
		
        $this->post = $this->input->get_post(NULL);
      
        $this->post['base_month'] = get_base_month();
        $this->clg = $this->session->userdata('current_user');
    }
    function school_listing(){
                //////////// Filter////////////

        $data['school_name'] = ($this->post['school_name']) ? $this->post['school_name'] : $this->fdata['school_name'];
        $data['mob_no'] = ($this->post['mob_no']) ? $this->post['mob_no'] : $this->fdata['mob_no'];
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

        $data['total_count'] = $this->school_model->get_school_data($data);

        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['AMB'] = $data;

        $this->session->set_userdata('filters', $ambflt);

        /////////////////////////////////////////////////////

        unset($data['get_count']);

        $data['result'] = $this->school_model->get_school_data($data, $offset, $limit);

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("schools/school_listing"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        $data['pagination'] = get_pagination($pgconf);
        
        $this->output->add_to_position($this->load->view('frontend/schools/school_list_view', $data, TRUE), $this->post['output_position'], TRUE);

        $this->output->add_to_position($this->load->view('frontend/schools/school_filters_view', $data, TRUE), 'amb_filters', TRUE);
    }
    
    function add_school(){
      
        $this->output->add_to_popup($this->load->view('frontend/schools/add_school_view', $data, TRUE), '1000', '800');
        
    }
    function save_school(){
       
        $school_data = $this->post['school'];
        $args = array(
            'school_state' => $this->post['school_dtl_state'],
            'school_district' => $this->post['school_dtl_district'],
            'school_city' => $this->post['school_dtl_ms_city'],
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s')
        );
        

        $args = array_merge($school_data, $args);
        
        
        if(isset($args['school_heathsupervisior'])){
            $args['school_heathsupervisior'] = implode(',', $args['school_heathsupervisior']);
        }
         if(isset($school_data['school_warden'])){
            $args['school_warden'] = implode(',', $args['school_warden']);
        }

       
        $res = $this->school_model->insert_school($args);
        
      
        $assign_headmaster = $this->colleagues_model->update_clg_field($school_data['school_headmastername'],'clg_is_set_school',$res);
        
        foreach($school_data['school_heathsupervisior'] as $health_supervisor){
            $assign_healthsupervison = $this->colleagues_model->update_clg_field($health_supervisor,'clg_is_set_school',$res);
        }
         foreach($school_data['school_warden'] as $school_warden){
            $assign_school_warden = $this->colleagues_model->update_clg_field($school_warden,'clg_is_set_school',$res);
        }
        

        if ($res) {

            $this->output->message = "<div class='success'>Details saved successfully</div>";
             $this->school_listing();
        }
    }
    
    function edit_school(){
        
        if ($this->post['school_id'] != '') {
            $school_id = array_map("base64_decode", $this->post['school_id']);
        }
     
    
        $data['school_action'] = $this->input->post('school_action');
        $args_dash = array('school_id'=>$school_id[0]);
        $data['update'] = $this->school_model->get_school_data($args_dash);
       
        
        $this->output->add_to_popup($this->load->view('frontend/schools/add_school_view', $data, TRUE), '1000', '800');
    }
    
    function del_school(){
         if ($this->post['school_id'] != '') {
            $school_id = array_map("base64_decode", $this->post['school_id']);
        }
        
        
        if (empty($school_id)) {
            $this->output->message = "<div class='error'>Please select at least one item to delete</div>";
            return;
        }
        $args['school_isdeleted'] = '1';

        $status = $this->school_model->delete_school($school_id, $args);
        
        if ($status) {
            $this->output->message = "<div class='success'>School details is deleted successfully.</div>";
            $this->school_listing();
        } else {
            $this->output->message = "<div class='error'>School details is deleted successfully.</div>";
        }
    }
     function update_school(){
       
         $data['school_action'] = $this->input->post('school_action');
       
        if ($this->post['school_id'] != '') {
            $school_id = base64_decode($this->post['school_id']);
        }
        $arg_school = array('school_id'=> $school_id[0]);
        $school_data = $this->post['school'];
        
        $args = array(
            'school_state' => $this->post['school_dtl_state'],
            'school_district' => $this->post['school_dtl_district'],
            'school_city' => $this->post['school_dtl_ms_city'],
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s')
        );
       
        $args = array_merge($this->post['school'], $args);
        
        if(isset($args['school_heathsupervisior'])){
            $args['school_heathsupervisior'] = implode(',', $args['school_heathsupervisior']);
        }
         if(isset($args['school_warden'])){
            $args['school_warden'] = implode(',', $args['school_warden']);
        }
       
        $res = $this->school_model->updte_school_details($arg_school,$args);
        
        $remove_previously_assing_school = $this->colleagues_model->update_clg_set_school($res);
        
        $assign_headmaster = $this->colleagues_model->update_clg_field($school_data['school_headmastername'],'clg_is_set_school',$res);
        
        foreach($school_data['school_heathsupervisior'] as $health_supervisor){
            $assign_healthsupervison = $this->colleagues_model->update_clg_field($health_supervisor,'clg_is_set_school',$res);
        }
         foreach($school_data['school_warden'] as $school_warden){
            $assign_school_warden = $this->colleagues_model->update_clg_field($school_warden,'clg_is_set_school',$res);
        }
        
        if ($res) {

            $this->output->message = "<div class='success'>Details Updated successfully</div>";
            $this->school_listing();
        }
    }
    function send_daily_sms(){
        
        
        
        $sms_rec = $this->school_model->get_sms_recipients();
       
        $today = date('d-m-Y');
        $today = date('Y-m-d',strtotime("yesterday"));
        
        
        $current_date =  $today;
        $report_args =  array('from_date' => date('Y-m-d',strtotime($current_date)),
                              'to_date' => date('Y-m-d',strtotime($current_date)),
                               'base_month'=>$this->post['base_month']
                                              );
        
        // total screening
        $report_args['get_count'] = 'true';
        $today_screening = $this->student_model->get_screening_by_date($report_args);

        $current_month = date('m');
        $current_year= date('Y');
        $current_month_date =  $current_year.'-'.$current_month.'-01';
        $args =  array('from_date' => date('Y-m-d',strtotime($current_month_date)),
                       'to_date' => date('Y-m-d',strtotime($current_date)));
        $args['get_count'] = 'true';
        $month_screening = $this->student_model->get_screening_by_date($args);

        $total_args['get_count'] = 'true';
        $total_screening = $this->student_model->get_screening_by_date($total_args);
        
        //sick room
        $report_args['get_count'] = 'true';
        $today_sickroom = $this->emt_model->get_stud_sickroom($report_args);

        $current_month = date('m');
        $current_year= date('Y');
        $current_month_date =  $current_year.'-'.$current_month.'-01';
        $args =  array('from_date' => date('Y-m-d',strtotime($current_month_date)),
                       'to_date' => date('Y-m-d',strtotime($current_date)));
        $args['get_count'] = 'true';
        $month_sickroom = $this->emt_model->get_stud_sickroom($args);

        $total_args['get_count'] = 'true';
        $total_sickroom = $this->emt_model->get_stud_sickroom($total_args);
       
        //sick room
        $report_args['get_count'] = 'true';
        $today_sickroom = $this->emt_model->get_stud_sickroom($report_args);

        $current_month = date('m');
        $current_year= date('y');
        $current_month_date =  $current_year.'-'.$current_month.'-01';
        $args =  array('from_date' => date('Y-m-d',strtotime($current_month_date)),
                       'to_date' => date('Y-m-d',strtotime($current_date)));
        $args['get_count'] = 'true';
        $month_sickroom = $this->emt_model->get_stud_sickroom($args);

        $total_args['get_count'] = 'true';
        $total_sickroom = $this->emt_model->get_stud_sickroom($total_args);
        
        //Hospitalized patient
        $report_args['get_count'] = 'true';
        $today_hospitalizaion = $this->emt_model->get_stud_hospitalizaion($report_args);

        $current_month = date('m');
        $current_year= date('Y');
        $current_month_date =  $current_year.'-'.$current_month.'-01';
        $args =  array('from_date' => date('Y-m-d',strtotime($current_month_date)),
                       'to_date' => date('Y-m-d',strtotime($current_date)));
        $args['get_count'] = 'true';
        $month_hospitalizaion = $this->emt_model->get_stud_hospitalizaion($args);

        $total_args['get_count'] = 'true';
        $total_hospitalizaion = $this->emt_model->get_stud_hospitalizaion($total_args);
        
        // Emergency Transport
        $today_inc = $this->inc_model->get_inc_report_by_date($report_args);
        $today_inc = count($today_inc);
        
        $current_month = date('m');
        $current_month_date =  '2018-'.$current_month.'-01';
        $args =  array('from_date' => date('Y-m-d',strtotime($current_month_date)),
                       'to_date' => date('Y-m-d',strtotime($current_date)),
                       'base_month'=>$this->post['base_month']);
        
        $month_inc = $this->inc_model->get_inc_report_by_date($args);
        $month_inc = count($month_inc);
        
        $total_args = array( 'base_month'=>$this->post['base_month']);
        $total_inc = $this->inc_model->get_inc_report_by_date($total_args);
        $total_inc = count($total_inc);
        
        $datetime = date('Y-m-d H:i:s');
        
       
        foreach ($sms_rec as $rec){
            
            $sms_to = $rec->contact_number;
            
            if($rec->template_id == '1'){
                $msg = "BVG,\nAtal Arogya Vahini\nReport for $today Today;Till Date\nStudents Treated in Sick Room: $today_sickroom; $total_sickroom\nNo. Of Emergency Transport: $today_inc;$total_inc\nNo. Of Patients Hospitalized: $today_hospitalizaion;$total_hospitalizaion\nBVG ,TDD";
                $send_sms = $this->_send_sms($sms_to, $msg, $lang = "english");
           
            }else if($rec->template_id == '2'){
                $msg = "BVG,\nAtal Arogya Vahini\nReport for $today Today;MTD;Till Date\nStudents Treated in Sick Room: $today_sickroom; $month_sickroom; $total_sickroom\nNo. Of Emergency Transport: $today_inc; $month_inc; $total_inc\nNo. Of Patients Hospitalized: $today_hospitalizaion; $month_hospitalizaion; $total_hospitalizaion\nBVG ,TDD ";
                $send_sms = $this->_send_sms($sms_to, $msg, $lang = "english");
                
            }else if($rec->template_id == '1,2'){
                
//                $msg = "BVG,\nAtal Arogya Vahini\nReport for $today Today;Till Date\nStudents Treated in Sick Room: $today_sickroom; $total_sickroom\nNo. Of Emergency Transport: $today_inc;$total_inc\nNo. Of Patients Hospitalized: $today_hospitalizaion;$total_hospitalizaion\nNo. Of Student Screened (Acheived/Target): $today_screening;$total_screening\nTDD MEMS";
//                $send_sms = $this->_send_sms($sms_to, $msg, $lang = "english");
//                
//                $msg1 = "BVG,\nAtal Arogya Vahini\nReport for $today Today;MTD;Till Date\nStudents Treated in Sick Room: $today_sickroom; $month_sickroom; $total_sickroom\nNo. Of Emergency Transport: $today_inc ; $month_inc ; $total_inc\nNo. Of Patients Hospitalized: $today_hospitalizaion; $month_hospitalizaion; $total_hospitalizaion\nNo. Of Student Screened (Acheived/Target): $today_screening; $month_screening; $total_screening\nTDD MEMS";
                
                
                 $msg = "BVG,\nAtal Arogya Vahini\nReport for $today Today;Till Date\nStudents Treated in Sick Room: $today_sickroom; $total_sickroom\nNo. Of Emergency Transport: $today_inc;$total_inc\nNo. Of Patients Hospitalized: $today_hospitalizaion;$total_hospitalizaion\nBVG ,TDD ";
                $send_sms = $this->_send_sms($sms_to, $msg, $lang = "english");
                
                $msg1 = "BVG,\nAtal Arogya Vahini\nReport for $today Today;MTD;Till Date\nStudents Treated in Sick Room: $today_sickroom; $month_sickroom; $total_sickroom\nNo. Of Emergency Transport: $today_inc ; $month_inc ; $total_inc\nNo. Of Patients Hospitalized: $today_hospitalizaion; $month_hospitalizaion; $total_hospitalizaion\nBVG ,TDD ";
                $send_sms = $this->_send_sms($sms_to, $msg1, $lang = "english");
            }
      
            
           
            $asSMSReponse = explode("-",$send_sms);
            $res_sms = array('inc_ref_id'=>'daily_8AM_'.$sms_to,
                             'sms_usertype'=>'sms_recipients_table',
                             'sms_res'=>$asSMSReponse[0],
                             'sms_res_text'=>$asSMSReponse[1]?$asSMSReponse[1]:'',
                             'sms_datetime'=>$datetime);
            $this->inc_model->insert_sms_response($res_sms);
        }
//      $file_data = file_get_contents('send_daily_sms.txt');
//      file_put_contents('send_daily_sms.txt', $send_sms."\r\n".$file_data);
      die();
    }
    function send_daily_calls_sms(){
        
        $today = date('d-m-Y');
        $today = date('Y-m-d',strtotime("yesterday"));
        
        
        $current_date =  $today;
        $report_args =  array('from_date' => date('Y-m-d',strtotime($current_date)),
                              'to_date' => date('Y-m-d',strtotime($current_date)),
                              'base_month'=>$this->post['base_month']);
       
        
        // Emergency Transport
        $today_inc = $this->inc_model->get_inc_report_by_date($report_args);

        $medical_other = 0;
        $medicle_fever = 0;
        $General_Eliments =0;
        $Medical_Pain =0;
        $Medical_Vometting = 0;
        $trauma =0;
        $Medical_Skin = 0;
        
        
        $medical_other_comp= array('33','34','35','36','37','38','39','40','41','42','6','9','15','10','18','31','43','50','14','17','24','25','4','23','16','7','28','2','30','8','11','13','52','5','20','26','29','27','32');
        $medical_fever_comp= array('19');
        $General_Eliments_comp= array('21','51','53');
        $Medical_Pain_comp= array('1','12');
        $Medical_Vometting_comp = array('22','49');
        $truama_comp = array('44','45','46','47','48');
        $Medical_Skin_other = array('3');

        foreach($today_inc as $today){
			
		    if(in_array($today['inc_complaint'], $medical_fever_comp)){
				$medicle_fever = $medicle_fever+1;
			}else if(in_array($today['inc_complaint'], $General_Eliments_comp)){
				$General_Eliments = $General_Eliments+1;
			}else if(in_array($today['inc_complaint'], $Medical_Pain_comp)){
				$Medical_Pain = $Medical_Pain+1;
			}else if(in_array($today['inc_complaint'], $Medical_Vometting_comp)){
				$Medical_Vometting = $Medical_Vometting+1;
			}else if(in_array($today['inc_complaint'], $medical_other_comp)){
				$medical_other = $medical_other+1;
			}else if(in_array($today['inc_complaint'], $truama_comp)){
				$trauma = $trauma+1;
            }else if(in_array($today['inc_complaint'], $Medical_Skin_other)){
				$Medical_Skin = $Medical_Skin+1;
            }  
        }
        
       $msg_text = "";
       
       if($medicle_fever > 0){
           $msg_text .= "\nMedical Fever: $medicle_fever,";
       }
       if($Medical_Vometting > 0){
           $msg_text .= "\nMedical Vometting: $Medical_Vometting,";
       } 
       if($Medical_Pain > 0){
           $msg_text .= "\nMedical Abdominal Pain: $Medical_Pain,";
       }
        if($medical_other > 0){
           $msg_text .= "\nMedical Other: $medical_other,";
       }
       if($Medical_Skin > 0){
           $msg_text .= "\nMedical Skin: $Medical_Skin,";
       }
       if($General_Eliments > 0){
           $msg_text .= "\nGeneral Elements: $General_Eliments,";
       }
       $total_no_amb = $medicle_fever+$Medical_Vometting+$Medical_Pain+$medical_other+$Medical_Skin+$General_Eliments;
       
        $datetime = date('Y-m-d H:i:s');
        $sms_rec = $this->school_model->get_sms_recipients();
        foreach ($sms_rec as $rec){
            
            $sms_to = $rec->contact_number;
            
           // $sms_to = 8551995260;
            //$sms_to = 9730015484;
                //   $today = date('Y-m-d',strtotime("yesterday"));
            $sms_today = date('d/m/Y',strtotime("yesterday"));

            $msg = "BVG,\nAtal Arogya Vahini \nReport for $sms_today \nTotal ambulances dispatched:$total_no_amb $msg_text \nBVG TDD"; 
							
							
            $send_sms = $this->_send_sms($sms_to, $msg, $lang = "english");
       
            $asSMSReponse = explode("-",$send_sms);
            $res_sms = array('inc_ref_id'=>'daily_'.$sms_to,
                             'sms_usertype'=>'daily_call_sms',
                             'sms_res'=>$asSMSReponse[0],
                             'sms_res_text'=>$asSMSReponse[1]?$asSMSReponse[1]:'',
                             'sms_datetime'=>$datetime);
            $this->inc_model->insert_sms_response($res_sms);
        }
     
      die();
    }
}