<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Clg extends EMS_Controller {

    function __construct() {

        parent::__construct();

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
        $this->load->model(array('colleagues_model', 'options_model', 'module_model', 'call_model', 'cluster_model', 'common_model', 'dashboard_model','shiftmanager_model','inc_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper', 'language_helper', 'coral_helper', 'cct_helper','dash_helper'));
        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));
        $this->site_name = $this->config->item('site_name');
        $this->site = $this->config->item('site');
        $this->post = $this->input->get_post(NULL);

        if ($this->session->userdata('login_state')) {
            $this->login_state = $this->session->userdata('login_state');
        } else {
            $this->login_state = $this->session->set_userdata('login_state', 'generate_otp'); // generate_otp/login_by_otp/login_by_pass 
        }

        if ($this->input->post('filters', TRUE) == 'reset') {
            $this->session->unset_userdata('filters')['CLG'];
        }

        if ($this->session->userdata('filters')['CLG']) {
            $this->fdata = $this->session->userdata('filters')['CLG'];
        }
        $this->post['base_month'] = get_base_month();
        $this->clg = $this->session->userdata('current_user');
        $this->avaya_server_url = $this->config->item('avaya_server_url');
        $this->corel_server_url = $this->config->item('corel_server_url');
    }

    public function index($generated = false) {

        $data = array();
        $ref_id = get_cookie("username");

        if ($ref_id != '') {
            $current_user = $this->colleagues_model->get_user_info($ref_id);

            if ($current_user) {
                $data['current_user'] = $current_user[0];
                $this->session->set_userdata('current_user', $current_user[0]);
                $this->session->set_userdata('user_logged_in', TRUE);
                header("location: " . $this->base_url . "dash");
            } else {
                $this->login();
            }
        } else {
            $this->login();
        }
    }

    /* Added by MI-42
     *  
     *  This function is used to get login colleague information.
     */

    function logged_in_clgs() {

        $list = $this->colleagues_model->logged_in_clgs_list();

        foreach ($list as $session) {

            $clg_list[] = $session->usr_ref_id;
        }

        return $clg_list;
    }

    /* Added by MI-42
     *  
     *  This function is used to destroy colleagues session.
     */

    function logout() {

        $agent_id=$this->clg->clg_avaya_agentid;
        $ext_no = $this->session->userdata('avaya_extension_no');
        
        $current_user_data = $this->session->userdata('current_user');
        $this->session->unset_userdata('temp_usr');
        
        $login_status_update = $this->colleagues_model->update_clg_field($current_user_data->clg_ref_id, 'clg_is_login', 'no');
        
        //$clg_last_login_time = $current_user_data->clg_last_login_time;
        $login_history_id = $this->session->userdata('login_history_id');
        $login_summary = $this->colleagues_model->update_login_details( $login_history_id);

		
		$ext_no = $this->session->userdata('avaya_extension_no');
        //$this->clg->clg_avaya_agentid = "5001";
        $agent_id = $this->session->userdata('avaya_extension_no');
        $extension_no = $this->session->userdata('extension_no');
        
        $ser_args = array('ext_no'=>$extension_no);
        $service_data = $this->call_model->get_all_avaya_extension_new($ser_args);
        $service_type = $service_data[0]->type;
     
        
        if($ext_no != '' || $ext_no != null){
        
            $agent_id=$this->clg->clg_avaya_agentid;
            $avaya_server_url = $this->avaya_server_url . '/SetAgentAction';
            
                 
            $unique_id1 = $ext_no.'_'.time();
            $avaya_args = array('ActionID' => $unique_id1,
               'AgentID' => $agent_id,
                'AgentExtension' => $ext_no,
                'AgentCampaign' => 201,
                'AgentAction' => 'WO',
                'AgentActionParam' => $agent_id);


            $avaya_data = json_encode($avaya_args);
		
	    if($ext_no != '' || $ext_no != null){
             //file_put_contents('./logs/'.date("Y-m-d").'/'.$extension_no.'avaya_wrapout_log_spero.log', $avaya_data.",\r\n", FILE_APPEND);
			//$avaya_res = cct_agent_action($avaya_server_url, $avaya_data,$unique_id1);
		}
        
        
            $unique_id1 = $ext_no.'_'.time();
            $avaya_args = array('ActionID' => $unique_id1,
               'AgentID' => $agent_id,
                'AgentExtension' => $ext_no,
                'AgentCampaign' => 201,
                'AgentAction' => 'LO',
                'AgentActionParam' => $agent_id);


            $avaya_data = json_encode($avaya_args);
		
	    if($ext_no != '' || $ext_no != null){
             //file_put_contents('./logs/'.date("Y-m-d").'/'.$extension_no.'avaya_logout_log_spero.log', $avaya_data.",\r\n", FILE_APPEND);
			//$avaya_res = cct_agent_action($avaya_server_url, $avaya_data,$unique_id1);
            
		}
           
        
        }

     
        $ref_id = get_cookie("username");
        $clg_last_login_time = $current_user_data->clg_last_login_time;
        

        $login_status_update = $this->colleagues_model->update_clg_field($ref_id, 'clg_is_login', 'no');

        $login_summary = $this->colleagues_model->update_login_details(strtolower($ref_id), $clg_last_login_time);

        $clg_data = array('clg_ref_id' => $ref_id,
            'clg_break_type' => 'LO');

        $result = $this->colleagues_model->clg_update_data($clg_data);
        
        $remove_eros = $this->call_model->delete_call_user($ref_id);
        $remove_eros_users = $this->call_model->delete_ero_call_user($ref_id);

      

        $this->session->unset_userdata('current_user');
        $this->session->unset_userdata('login_history_id');
        $this->session->unset_userdata('user_logged_in');
        session_destroy();
        set_cookie('username', '', time());
        set_cookie('user_logged_in', '', time());

      
       //redirect($this->base_url . "clg/login", 'location');
        $logout_group = array('UG-JAES-NHM-DASHBOARD','UG-JAES-DASHBOARD','UG-CM','UG-HOSP','UG-KPI-DASHBOARD','UG-CENTERDASH');
        if( in_array($this->clg->clg_group, $logout_group)){
            header("Location: ".$this->base_url."clg/login");
        }else{
            $this->output->add_to_position("<script>window.location='".$this->base_url."clg/login';</script>", 'custom_script', TRUE);
        }
    }

    /* Added by MI-42
     *  
     *  This function is used to lock screen.
     */

    function clg_break() {

        $ext_no = get_cookie("avaya_extension_no");
        $agent_id=$this->clg->clg_avaya_agentid;
        if($this->clg->clg_group == 'UG-ERO'){
            if($ext_no != '' && $agent_id != ''){

                $avaya_status_args = array('ext_no'=>$ext_no,'agent_id'=>$agent_id);
                $avaya_status = check_avaya_status($avaya_status_args);
                if(!empty($avaya_status)){
                     $this->output->message = "<p> Sorry!...... Agent is on call </p>";
                     return;
                }
            }
        }
    
        
        $break_type = $this->colleagues_model->break_name();
        $clg_ref_id = $this->clg->clg_ref_id;
                     $current_date = date('Y-m-d');
        $current_time = date('Y-m-d');
        
        $args_break = array('to_date'=>$current_date,
                            'from_date'=>$current_time,
                            'clg_ref_id'=>$clg_ref_id,
                            'break_type'=>$break_type);
        foreach($break_type as $break){
          
            $args_break['break_type'] = $break->break_id;
            $break_summary = $this->shiftmanager_model->get_break_total_time_user($args_break);
            $break->break_total_time = $break_summary[0]->break_total_time;    
            $data['break_type'][]=$break;
        }
        //get_current_user_break($clg_ref_id);

         $this->output->add_to_popup($this->load->view('frontend/clg/clg_break_view', $data, TRUE), '600', '500');
       // $this->output->add_to_position($this->load->view('frontend/clg/clg_break_view', $data, TRUE), 'popup_div', TRUE);
    }

    function other_break_textbox() {
        $this->output->add_to_position($this->load->view('frontend/clg/other_break_textbox_view', $data, TRUE), 'other_break_textbox', TRUE);
    }

    function save_break(){
        
        
        if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
        }
                
        $break_type = $this->input->post('break_type');

        $other_break = $this->input->post('other_break');
        $other_break_data = "";
        
         $current_user_data = $this->session->userdata('current_user');
        
        $ext_no = $this->session->userdata('avaya_extension_no');
        $agent_id = $current_user_data->clg_avaya_agentid;
        $ser_args = array('ext_no'=>$ext_no);
                  
        $service_data = $this->call_model->get_all_avaya_extension_new($ser_args);
        $service_type = $service_data[0]->type;
            
                    $ref_id = $current_user_data->clg_ref_id;

        $clg_data = array('clg_ref_id' => $ref_id,
            'clg_break_type' => 'BI',
            'clg_is_login' => 'break');

        $result = $this->colleagues_model->clg_update_data($clg_data);
      
        if ($service_type == 'avaya') {

            $avaya_server_url = $this->avaya_server_url . '/SetAgentAction';

            $unique_id = $ext_no . '_' . time();
            $avaya_args = array('ActionID' => $unique_id,
                'AgentID' => $agent_id,
                'AgentExtension' => $ext_no,
                'AgentCampaign' => 201,
                'AgentAction' => 'BI',
                'AgentActionParam' => $agent_id);

            $avaya_data = json_encode($avaya_args);

            
                $avaya_res = cct_agent_action($avaya_server_url, $avaya_data, $unique_id);
                
                
                   file_put_contents('./logs/'.date("Y-m-d").'/'.date("Y-m-d").'avaya_breakin_log.log', $avaya_res['resp'].",\r\n", FILE_APPEND);
                   
                   $res = json_decode($avaya_res['resp']);
                   
//                    if($current_user_data->clg_group == 'UG-ERO' || $current_user_data->clg_group == 'UG-BIKE-ERO'){
//                        if($res == NULL ){
//                            $this->output->message = "<div class='error'> Error to break avaya..!! please try again..!!</div>";
//                            $this->output->closepopup = 'yes';
//                            $this->output->status = 1;
//                            return false;
//                       }
//                    }
        } else if ($service_type == 'coral') {
            // $agent_id ="5001";

            $coral_url = $this->corel_server_url . '/agentbreak';
            $avaya_args = array('agentid' => corel_encrypt_str($agent_id));

            if (!is_dir('./logs/' . date("Y-m-d"))) {
                mkdir('./logs/' . date("Y-m-d"), 0755, true);
            }



            $avaya_res = corel_curl_post_api($coral_url, $avaya_args);

            $avaya_res_encode = $avaya_res["resp"];
            $avaya_res_code = json_decode($avaya_res_encode, true);

            $avaya_res_code['log_time'] = date('Y-m-d H:i:s');
            $post_encode = json_encode($avaya_res_code);

            file_put_contents('./logs/' . date("Y-m-d") . '/' . date("Y-m-d") . 'avaya_break_log.log', $post_encode . ",\r\n", FILE_APPEND);
        }
        
        $data_insert = array('action_id'=>'breakin',
                            'action_data'=>json_encode($avaya_args),
                            'action_datetime'=>date('Y-m-d H:i:s'));
        
        $state = $this->call_model->insert_avaya_action($data_insert);
        // sleep(2);
      
        // $avaya_res = get_avaya_action($unique_id);
        
        // if($avaya_res['ResponseCode'] == '-1' || $avaya_res['ResponseCode'] == -1){
            
            // $this->output->message = "<div class='error'>".$avaya_res['ResponseDesc']."..!! please try again..!!</div>";
            // $this->output->closepopup = 'yes';
             // $this->output->status = 1;
            // return false;
            // 
        // }

        if ($other_break != "") {
            $other_break_data = $this->input->post('other_break');
        }
       
        
        $args_break = array('clg_ref_id'=>$ref_id,
                            'break_type'=>$break_type);
        
        $break_summary = $this->shiftmanager_model->get_break_total_time_user($args_break);
        $break_total_time = $break_summary[0]->break_total_time;
       // var_dump($break_total_time);
      //  die();

        $last_login = $current_user_data->clg_last_login_time;

        $clg_total_break_time = $break_total_time;

        $clg_break_time = date('Y-m-d H:i:s');       
        $this->session->set_userdata('clg_break_time', $clg_break_time);
        $this->session->set_userdata('break_total_time', $break_total_time);
        $this->session->set_userdata('break_type', $break_type);

        $break_summary = $this->colleagues_model->add_break_details($ref_id, $last_login, 'break', $break_type, $other_break_data, $clg_break_time);
        
        $update_call_args = array(
        'status' => 'break',
        'brktype' => $break_type,
        'brk_time'=> $clg_break_time   );
        $update_call_res = $this->call_model->update_ero_user_status($update_call_args, $ref_id);

        $this->output->closepopup = 'yes';
        $this->output->status = 1;
        $this->output->add_to_position("<script> lock_screen(); </script>");
    }

    function save_action_break() {
        $break_type = $this->input->post('break_action');
        $break_action = $this->input->post('break_action');


        $other_break = $this->input->post('other_break');
        $other_break_data = "";

        if ($other_break != "") {
            $other_break_data = $this->input->post('other_break');
        }

        $current_user_data = $this->session->userdata('current_user');
        
        $ext_no = $this->session->userdata('avaya_extension_no');
        $agent_id = $current_user_data->clg_avaya_agentid;
        
        
        $avaya_server_url = $this->avaya_server_url . '/SetAgentAction';

        $unique_id = $ext_no.'_'.time();
        $avaya_args = array('ActionID' => $unique_id,
            'AgentID' => $agent_id,
            'AgentExtension' => $ext_no,
            'AgentCampaign' => 201,
            'AgentAction' => 'BO',
            'AgentActionParam' => $agent_id);

        $avaya_data = json_encode($avaya_args);
		
		if($ext_no != '' || $ext_no != null){
			$avaya_res = cct_agent_action($avaya_server_url, $avaya_data,$unique_id);
             $res = json_decode($avaya_res['resp']);
                   
                   
                    if($res == NULL ){
                        $this->output->message = "<div class='error'> Error to break avaya..!! please try again..!!</div>";
                        $this->output->closepopup = 'yes';
                        $this->output->status = 1;
                        return false;
                   }
		}
        
        // sleep(2);
        // $avaya_res = get_avaya_action($unique_id);
         
        // if($avaya_res['ResponseCode'] == '-1' || $avaya_res['ResponseCode'] == -1){
            // $this->output->message = "<div class='error'>".$avaya_res['ResponseDesc']."..!! please try again..!!</div>";
            // return false;
        // }


        $action_array = Array('Login' => 'LI', 'Logout' => 'LO', 'Ready' => 'RD', 'Notready' => 'NR', 'BreakIn' => 'BI', 'BreakOut' => 'BO', 'WrapIn' => 'WI', 'WrapOut' => 'WO');
        $action_param = Array('LI' => '001', 'LO' => '002', 'RD' => '003', 'NR' => '004', 'BI' => '005', 'BO' => '006', 'WI' => '007', 'WO' => '008');

        $ref_id = $current_user_data->clg_ref_id;
        $last_login = $current_user_data->clg_last_login_time;
        $clg_break_time = date('Y-m-d H:i:s');
        $this->session->set_userdata('clg_break_time', $clg_break_time);
        $break_summary = $this->colleagues_model->add_avaya_break_details($ref_id, $last_login, 'break', $break_type, $other_break_data, $clg_break_time);
        
        $update_call_args = array(
        'status' => 'break',
        'brk_time'=>date('Y-m-d H:i:s')
    );
        $update_call_res = $this->call_model->update_ero_user_status($update_call_args, $ref_id);

        $clg_data = array('clg_ref_id' => $ref_id,
            'clg_break_type' => $break_action);

        $result = $this->colleagues_model->clg_update_data($clg_data);
        $params = $action_param[$break_action];
		
        $clg_data = array('clg_ref_id' => $ref_id,
                          'clg_break_type' => $break_action);

        $result = $this->colleagues_model->clg_update_data($clg_data);
//        $this->output->closepopup = 'yes';
//        $this->output->status = 1;
        $this->output->add_to_position("<script> window.location.reload(true); </script>");
    }

    function user_screen_lock() {

        $current_user_data = $this->session->userdata('current_user');
        $break_type = $this->session->userdata('break_type');

        $ref_id = $current_user_data->clg_ref_id;

        $login_status_update = $this->colleagues_model->update_clg_field($ref_id, 'clg_is_login', 'break');


        $remove_eros = $this->call_model->delete_call_user($ref_id);

        $data = array();


        $lock_status = $this->post['LOCK_STATUS'];
        $break_total_time= $this->session->userdata('break_total_time');

        if ($lock_status) {
            $this->session->set_userdata("screen_locked", '1');
        }
        $break_args = array('break_id'=>$break_type);
        $break_type_data = $this->colleagues_model->break_name($break_args);
        $break_type_name = $break_type_data[0]->break_name;

        
        $this->session->set_userdata('break_time', time());
        $this->session->set_userdata('break_type', $break_type);
        $this->session->set_userdata('break_type_name',$break_type_name);
        
        $data = array('div_id' => 'break_timer_clock',
            'break_total_time'=>$break_total_time,
            'break_type'=>$break_type,
            'break_type_name'=>$break_type_name,
            'start_time' => time());
        
        echo json_encode($data);
        exit();
    }

    /* Added by MI-42
     *  
     *  This function is used to authenticate password when colleagues login from lock screen.
     */

    function authenticate_lc_pwd() {
        if (!$this->post['password'] == null) {
            
            
            $ref_id = get_cookie('username');

            if ($ref_id == 'null' || $ref_id == "") {

                $ref_id = $this->post['ref_id'];
            }
             $ip = $_SERVER['REMOTE_ADDR'];

             $ip_en = corel_encrypt_str($ip);
            

            $password = md5($this->post['password']);
            $user_group = $this->post['user_group'];
            $break_timer = $this->post['break_total_timer_clock'];
            $break_type = $this->post['break_type'];
            
            $args_break = array('clg_ref_id'=>$ref_id,
                            'break_type'=>$break_type);
        
            
            $break_summary = $this->shiftmanager_model->get_break_total_time_user($args_break);
              

            $break_args = array('break_id'=>$break_type);
            $break_type = $this->colleagues_model->break_name($break_args);
            $break_seconds = $break_summary[0]->break_total_time ;
            $break_minutes = floor($break_seconds / 60);
            
            $current_user_data = $this->session->userdata('current_user');
            $clg_last_login_time = $current_user_data->clg_last_login_time;


            $result = $this->colleagues_model->check_password($ref_id, $password, $user_group);
            
            $ext_no = $this->session->userdata('avaya_extension_no');
           
            $ext_no = $this->session->userdata('avaya_extension_no');
            
            if($ext_no == '' || $ext_no == null){
                $ext_no =  get_cookie('avaya_extension_no');
            }
            $agent_id=$this->session->userdata('avaya_extension_no');
            $extension_no=$this->session->userdata('avaya_extension_no');

            
            $shift_group = array('UG-ShiftManager');
            

            if ($result) {
                
               if($break_type[0]->break_time < $break_minutes){
                    $reg_name = '';
                    if($ref_id != ''){
                        $reg_name = get_clg_name_by_ref_id($ref_id);
                    }
                     
                    
                     $note_data = array(
                        'nr_base_month' => $this->post['base_month'],
                        'nr_notice' => "$reg_name-$ref_id is exceed Break time limit",
                        'nr_date' => date('Y-m-d H:i:s'),
                        'is_deleted' => '0',
                        'notice_added_by' => $ref_id,
                        'nr_user_group' => json_encode($shift_group),
                        'notice_exprity_date' =>date('Y-m-d')." 23:59:59"
                    );

                    $nr_id = $this->colleagues_model->insert_notice($note_data);
                    
                    $args = array('user_group' => array('UG-ShiftManager','UG-EROSupervisor') );

                    $data1['clg_data'] = $this->colleagues_model->get_clg_data($args);


                    if($data1['clg_data']){
                        foreach ($data1['clg_data'] as $value) {

                            $clg_data = array(
                                'clg_ref_id' => $value->clg_ref_id,
                                'nr_notice_id' => $nr_id,
                                'n_added_by' => $this->clg->clg_ref_id,
                                'n_added_date' => date('Y-m-d H:i:s'),
                            );

                            $insert_clg_notice = $this->colleagues_model->insert_clg_notice($clg_data);

                        }
                    }

                }
               
        $ser_args = array('ext_no'=>$ext_no);
            
        $service_data = $this->call_model->get_all_avaya_extension_new($ser_args);
        $service_type = $service_data[0]->type;
      
        
        if($service_type == 'avaya'){
            
               $agent_id =  $result[0]->clg_avaya_agentid;
                $avaya_server_url = $this->avaya_server_url . '/SetAgentAction';
                $unique_id = $ext_no.'_'.time();
				$avaya_args = array('ActionID' => $unique_id,
                'AgentID' => $agent_id,
                'AgentExtension' => $ext_no,
                'AgentCampaign' => 201,
                'AgentAction' => 'BO',
                'AgentActionParam' => $agent_id);
                
				$avaya_data = json_encode($avaya_args);
                
                $data_insert = array('action_id'=>'break out',
                            'action_data'=>$avaya_data,
                            'action_datetime'=>date('Y-m-d H:i:s'));
        
                $state = $this->call_model->insert_avaya_action($data_insert);
                
                
				//if($ext_no != '' || $ext_no != null){
					$avaya_res = cct_agent_action($avaya_server_url, $avaya_data,$unique_id);
                    file_put_contents('./logs/'.date("Y-m-d").'/'.date("Y-m-d").'avaya_breakout_log.log', $avaya_res['resp'].",\r\n", FILE_APPEND);
				//}
        }else if($service_type == 'coral'){
        $coral_url = $this->corel_server_url.'/agentlogin';
	//	$avaya_args = array('agentid' => corel_encrypt_str($agent_id));
         $agent_id =  $result[0]->clg_avaya_agentid;
         $agent_id_en = corel_encrypt_str($agent_id);
        //$avaya_args = array('agentid' => $extension_no,'extension' => $extension_no,'ipaddress'=>$ip_en);
        $avaya_args = array('agentid' => $agent_id_en,'extension' => $extension_no,'ipaddress'=>$ip_en);
  
        if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
        }

    
        $data_insert = array('action_id'=>'break out',
                            'action_data'=>json_encode($avaya_args),
                            'action_datetime'=>date('Y-m-d H:i:s'));
        
      $state = $this->call_model->insert_avaya_action($data_insert);
 //var_dump($coral_url);
 //die();
        $avaya_res = corel_curl_post_api($coral_url, $avaya_args);
        
        
        $avaya_res_encode = $avaya_res["resp"];
        
        file_put_contents('./logs/'.date("Y-m-d").'/'.date("Y-m-d").'coral_breakout_log.log', $avaya_res_encode.",\r\n", FILE_APPEND);
        }
				
			
                $ref_id = $result[0]->clg_ref_id;
                $clg_break_time = $this->session->userdata('clg_break_time');

                $login_summary = $this->colleagues_model->update_break_details($ref_id, $clg_last_login_time, $clg_break_time, $break_timer);

                $this->session->unset_userdata('break_time');
                $this->session->unset_userdata('clg_break_time');


                set_cookie('username', $ref_id, time() + (86400 * 30));
                set_cookie('user_logged_in', 'TRUE', time() + (86400 * 30));
				set_cookie('avaya_extension_no',  $ext_no, time() + (86400 * 30));
                
                 $this->session->set_userdata('current_user', $result[0]);
                $this->session->set_userdata('user_logged_in', TRUE);
                $this->session->set_userdata('user_default_key', $result[0]->user_default_key);
                $this->session->set_userdata('avaya_extension_no',$ext_no);

                $is_live_time = time();
                $live_time_update = $this->colleagues_model->update_clg_field($ref_id, 'clg_is_alive_time', $is_live_time);
                $login_status_update = $this->colleagues_model->update_clg_field($ref_id, 'clg_is_login', 'yes');

								
                $clg_data = array('clg_ref_id' => $ref_id,
                    'clg_break_type' => 'BO');
                $result = $this->colleagues_model->clg_update_data($clg_data);
                
                if ($user_group == 'UG-ERO' || $user_group == 'UG-ERO-102' || $user_group == 'UG-ERO-HD') {
                    $is_users = $this->call_model->is_free_user_exists($ref_id);

                    if (empty($is_users)) {
                        $new_clg_args = array(
                            'user_ref_id' => $ref_id,
                            'call_status' => 'free',
                            'datetime' => microtime(true));

                        $call_res = $this->call_model->insert_call_user($new_clg_args);
                    }
                }
                
                ero_free_user_call($ref_id);
            }

            if ($result) {

                $this->session->set_userdata("screen_locked", '0');

                $screen_locked = $this->session->userdata("screen_locked");

                //$this->output->add_to_position("<script>keep_alive_clg();</script>", 'custom_script', true);
                 $this->output->add_to_position("<script>sessionStorage.setItem('clg_details', '$ref_id_encode');</script>", 'custom_script', true);
                $this->output->add_to_position("<script> unlock_screen(); window.location.reload(true);</script>");
            } else {

                $this->output->message = "<div class='error'>Invalid password..!! please try again..!!</div>";
            }
        }
    }

    /* Added by MI-42
     *  
     *  This function is used to change user from lock screen.
     */

    // function changeUser() {



        // $current_user_data = $this->session->userdata('current_user');
        // $break_timer = $this->post['break_timer_clock'];
        // $clg_last_login_time = $current_user_data->clg_last_login_time;
        // $ref_id = $current_user_data->clg_ref_id;
        // $clg_break_time = $this->session->userdata('clg_break_time');

        // $login_summary = $this->colleagues_model->update_break_details($ref_id, $clg_last_login_time, $clg_break_time, $break_timer);

        // $this->session->set_userdata("screen_locked", '0');


        // $this->output->add_to_position("<script> unlock_screen(); </script>");


        // $this->logout();
    // }

    /* Added by MI-42
     *  
     *  This function is used to login colleagues.
     */

    function login() {

        $data = array();

        $this->get_user_message();

        $data['login_state'] = $this->login_state;

        $data['ref_id'] = get_cookie('username');
        $current_user_sess =  $this->session->userdata('current_user');
        //var_dump($data['ref_id'] );die();

        $data['message'] = $this->success . $this->warning . $this->error;

        $login = array('ip_address'=>$_SERVER['REMOTE_ADDR'],'login_try_date'=>date('Y-m-d H:i:s'));
        $get_login_count = $this->colleagues_model->get_login_count($login);
        
        $data['login_count'] = $get_login_count[0]->login_attempt;
        

        if (($data['ref_id'] != "" && $data['ref_id'] != "null") || !(empty($current_user_sess))) {

            $data['login_state'] = 'login_by_pass';

            $current_user = $this->colleagues_model->get_user_info($data['ref_id']);

            $data['current_user'] = $current_user[0];
        }

        $data['users'] = $this->module_model->get_users_groups();
		$data['extention_no'] = $this->call_model->get_all_avaya_extension();
        $this->output->set_focus_to = "user_group";

        $this->output->add_to_position($this->load->view('frontend/clg/login_view', $data, true));

        $this->output->template = "cell";
        
    }

    function authenticate_password() {

//        $user_group = trim($this->post['user_group']);
//
//        $gp_is_active = $this->colleagues_model->edit_group('', $user_group, 'active');
//
//
//        if (empty($gp_is_active)) {
//            $this->set_user_message("<div class='error'>User group " . $user_group . " is inactive!!</div>", "error");
//            redirect($this->base_url . "clg/login", 'location');
//        }
       
  
        


        if (!$this->input->post('password', TRUE) == null) {

            $ref_id = get_cookie('username');
            $ref_id = trim($this->post['ref_id']);

            //$user_group = trim($this->post['user_group']);

            $password = md5($this->post['password']);

            $clg_details = array('clg_ref_id' => $ref_id);
            $clg_details_pass = array('clg_ref_id' => $ref_id,'password'=>$password);
            $clg_is_group_exists = array('clg_ref_id' => $ref_id,'password'=>$password,'clg_group'=>$user_group);

            $clg_is_exists = $this->colleagues_model->clg_is_exists($clg_details);
            $clg_is_pass_exists = $this->colleagues_model->clg_is_pass_exists($clg_details_pass);
            
            $clg_is_group_exists = $this->colleagues_model->clg_is_group_exists($clg_is_group_exists);
            
                     
           
            
            
//            if($agent_id != ''){
//                $clg_is_avaya_exists = array('clg_avaya_agentid'=>$agent_id);
//                $clg_is_agent_exists = $this->colleagues_model->clg_is_agent_login($clg_is_avaya_exists);
//            }
                        

            
            if(empty($clg_is_exists)){
                $this->set_user_message("<div class='error'>Username not valid...!!</div>", "error");
                redirect($this->base_url . "clg/login", 'location');
            }
            if(empty($clg_is_pass_exists)){
                $this->set_user_message("<div class='error'>Password not valid...!!</div>", "error");
                redirect($this->base_url . "clg/login", 'location');
            }
            if(empty($clg_is_group_exists)){
                $this->set_user_message("<div class='error'>User group not valid...!!</div>", "error");
                redirect($this->base_url . "clg/login", 'location');
            }
            if(!empty($clg_is_agent_exists)){
                $this->set_user_message("<div class='error'>Extension already login...!!</div>", "error");
                redirect($this->base_url . "clg/login", 'location');
            }
            
            $result = $this->colleagues_model->check_password($ref_id, $password);
//            if($_SERVER["HTTP_HOST"] == 'irts.jaesmp.com'){
//          
//                $groups_array = array('UG-SuperAdmin','UG-Dashboard','UG-DASHBOARD-NHM','UG-Dashboard-view','UG-NHM-DASHBOARD','UG-MemsDashboard','UG-JAES-NHM-DASHBOARD','UG-JAES-DASHBOARD','UG-DM','UG-ZM','UG-IT','UG-OP-HEAD','UG-HO-JAES','UG-FleetManagement','UG-INSPECTION');
//
//
//                if(!in_array( $result[0]->clg_group,$groups_array)){
//                   $this->set_user_message("<div class='error'>Your not authorised user please contact administrator!!</div>", "error");
//                   redirect($this->base_url . "clg/login", 'location');
//                }
//
//            }

            
            

            if ($clg_is_exists) {
                $this->session->set_userdata('temp_usr', $this->post['ref_id']);
            } else {
                $this->session->unset_userdata('temp_usr');
            }


           
            
            $extension_no = $this->post['extension_no'];
            $ser_args = array('ext_no'=>$this->post['extension_no']);
            
            $service_data = $this->call_model->get_all_avaya_extension_new($ser_args);
            $service_type = $service_data[0]->type;
           
                   
            //$agent_id = 5001;
            $ip = $_SERVER['REMOTE_ADDR'];
           
           // $ip = '210.212.165.114';
               
          

            if ($result) {
                $newDate = strtotime(" -2 minutes");
                
                 $agent_id =  $result[0]->clg_avaya_agentid;
              
                if ($result[0]->clg_group == 'UG-Dashboard' || $result[0]->clg_is_login == 'no' || $result[0]->clg_is_alive_time < $newDate ) {
                    

                     

                    
					if($this->post['extension_no'] != '' || $this->post['extension_no'] != null){
                        
                        if($service_type == 'avaya'){
                            
                            
                             $avaya_server_url = $this->avaya_server_url . '/SetAgentAction';
                            		$unique_id = $extension_no.'_'.time();
                                $avaya_args = array('ActionID' => $unique_id,
                                    'AgentID' => $agent_id,
                                    'AgentExtension' => $extension_no,
                                    'AgentCampaign' => 201,
                                    'AgentAction' => 'LI',
                                    'AgentActionParam' => $agent_id);
                                    //var_dump($avaya_args);die();

                                $avaya_data = json_encode($avaya_args);
                                if($extension_no != '' || $extension_no != null){
                                    $avaya_res = cct_agent_action($avaya_server_url, $avaya_data,$unique_id);
                                    
                                    file_put_contents('./logs/'.date("Y-m-d").'/'.$this->post['extension_no'].'avaya_login_log.log', json_encode($avaya_res).",\r\n", FILE_APPEND);
                                }
                                 file_put_contents('./logs/'.date("Y-m-d").'/'.$this->post['extension_no'].'avaya_login_log_spero.log', json_encode($avaya_res).",\r\n", FILE_APPEND);




                                $unique_id1 = time();
                                $avaya_args = array('ActionID' => $unique_id1,
                                    'AgentID' => $agent_id,
                                    'AgentExtension' => $extension_no,
                                    'AgentCampaign' => 201,
                                    'AgentAction' => 'BO',
                                    'AgentActionParam' => $agent_id);

                                $avaya_data = json_encode($avaya_args);
                                if($extension_no != '' || $extension_no != null){
                                    $avaya_res = cct_agent_action($avaya_server_url, $avaya_data,$unique_id1);
                                    
                                }
                                file_put_contents('./logs/'.date("Y-m-d").'/'.$this->post['extension_no'].'avaya_breakout_log_spero.log', json_encode($avaya_res).",\r\n", FILE_APPEND);
                                
                                 $this->colleagues_model->update_clg_field($ref_id, 'clg_avaya_extension', $this->post['extension_no']);
                                 
                            
                        }else if($service_type == 'coral'){
                            $agent_id = $this->post['extension_no'];
                            
                            $avaya_server_url = $this->corel_server_url . '/agentlogin';
                            $extension_no_en = corel_encrypt_str($this->post['extension_no']);
                            $agent_id_en = corel_encrypt_str($agent_id);
                            $ip_en = corel_encrypt_str($ip);
                            //$pass_en = corel_encrypt_str('123456');

                            $avaya_args = array('agentid' => $agent_id_en,'extension' => $extension_no_en,'ipaddress'=>$ip_en); 
                           
                                                   //  file_put_contents('./logs/'.date("Y-m-d").'/'.$this->post['extension_no'].'avaya_login_log_spero.log', json_encode($avaya_args).",\r\n", FILE_APPEND);
                        
              
                        
						$avaya_res = corel_curl_post_api_login($avaya_server_url, $avaya_args);
                        
                        if (!is_dir('./logs/' . date("Y-m-d"))) {
                            mkdir('./logs/' . date("Y-m-d"), 0755, true);
                        }
                        
                        $ares = json_decode($avaya_res["resp"]);
                       
                        
                        
                        file_put_contents('./logs/'.date("Y-m-d").'/'.$this->post['extension_no'].'avaya_login_log.log', $avaya_res["resp"].",\r\n", FILE_APPEND);
                        
                        if(!empty($ares)){
                            if($ares->status == '1' ){


                                $this->output->message = "<div class='error'>".$avaya_res['message']."..!! please try again..!!!!</div>";
                                return false;

                            }
                        
                        }else{
                             
                            $this->set_user_message("<div class='error'>!! please try again... Coral not login..!!!!</div>", "error");
                            redirect($this->base_url . "clg/login", 'location');
                        }
;
                      
                        
        

                    }
                        $avaya_history = array('ext_id'=>$this->post['extension_no'],'clg_ref_id'=>$ref_id,'login_time'=>date('Y-m-d H:i:s'));
                        $this->colleagues_model->insert_avaya_history($avaya_history);
                        set_cookie('avaya_extension_no',  $extension_no, time() + (86400 * 30));
                    }
                 
		
                    set_cookie('username', $ref_id, time() + (86400 * 30));
                    set_cookie('user_logged_in', 'TRUE', time() + (86400 * 30));
					

                    $result[0]->usr_type = "clg";

                    $this->session->set_userdata('current_user', $result[0]);
                    $this->session->set_userdata('user_default_key', $result[0]->user_default_key);
                    $this->session->set_userdata('user_logged_in', TRUE);
					$this->session->set_userdata('avaya_extension_no', $extension_no);
                    $this->session->set_userdata('extension_no', $this->post['extension_no']);

                    $otp = $this->mi_random_string(6);
                    $is_live_time = time();

                    $this->colleagues_model->load_otp($ref_id, $otp, $is_live_time);

                    $last_login = $result[0]->clg_last_login_time;
                    $user_group = $result[0]->clg_group;

                    $login_time_update = $this->colleagues_model->update_clg_field($ref_id, 'clg_last_login_time', $is_live_time);

                    $current_session_id = session_id();
                    
                    $session_table_update = $this->colleagues_model->update_session_fields($current_session_id, $ref_id, "clg");
                    

                    
                    //$agent_update = $this->colleagues_model->update_clg_field($ref_id,'clg_avaya_agentid',$agent_id);
                   
                    
                    
                    $login_status_update = $this->colleagues_model->update_clg_field($ref_id, 'clg_is_alive_time', $is_live_time);

                    $login_status_update1 = $this->colleagues_model->update_clg_field($ref_id, 'clg_is_login', 'yes');
                   
 


                    $login_summary = $this->colleagues_model->add_login_details(strtolower($ref_id), $is_live_time, 'login', 'login');
                    
                    $this->session->set_userdata('login_history_id', $login_summary);
                    

                   // $ip['ext_ip'] = $_SERVER['REMOTE_ADDR'];

                    $result = $this->colleagues_model->update_clg_field($ref_id, 'clg_break_type', 'LI');
                    
                    //if ($user_group == 'UG-DCOSupervisor' || $user_group == 'UG-EROSupervisor' ||$user_group == 'UG-DCO' || $user_group == 'UG-ERO' || $user_group == 'UG-ERO-102' || $user_group == 'UG-ERO-HD') {
                        $is_users = $this->call_model->is_free_user_exists($ref_id);

                        if (empty($is_users)) {
                            $new_clg_args = array(
                                'user_ref_id' => $ref_id,
                                'user_group' => $user_group,
                                'call_status' => 'free',
                                'datetime' => microtime(true));

                            $call_res = $this->call_model->insert_call_user($new_clg_args);
                        }
                        $is_ero_users = $this->call_model->is_ero_free_user_exists($ref_id);

                        if (empty($is_ero_users)) {
                            $new_ero_clg_args = array(
                                'user_ref_id' => $ref_id,
                                'extension_no' => $this->post['extension_no'],
                                 'user_group' => $user_group,
                                'status' => 'free',
                                'added_date' => date('Y-m-d H:i:s'),
                                'brk_time'=>date('Y-m-d H:i:s'),
                                'is_alive_time'=>time());

                            $call_res = $this->call_model->insert_ero_call_user($new_ero_clg_args);
                        }
                    //}

                    if ($user_group == 'UG-POLICE') {
                        $is_users = $this->call_model->is_free_user_exists($ref_id);

                        if (empty($is_users)) {
                            $new_clg_args = array(
                                'user_ref_id' => $ref_id,
                                'user_group' => $user_group,
                                'call_status' => 'free',
                                'datetime' => microtime(true),
                                'user_group' => $user_group
                            );

                            $call_res = $this->call_model->insert_call_user($new_clg_args);
                        }
                    }

                    if ($last_login == '') {


                        $this->post['ref_id'] = $this->post['ref_id'];

                        redirect($this->base_url . "Clg/change_password_first_login", 'location');
                    } else {
                        $ref_id_encode = base64_encode($ref_id);
                        $this->output->add_to_position("<script>sessionStorage.setItem('AgentExtension', '$extension_no'); </script>", 'custom_script', true);
                        //var_dump(location);
                       // die();
                        $url =$this->base_url . "clg/login_successful";
                        header('Location: '.$url);
                        die();
                        //redirect($this->base_url . "clg/login_successful", 'location');
                        //redirect($this->base_url . "dash", 'location');
                    }
                } else {

                    $this->set_user_message("<div class='error'>This user is login to another browser. Please logout</div>", "error");
                }
            } else {

                $this->set_user_message("<div class='error'>Incorrect Password..!!</div>", "error");
            }
        } else {

            $this->set_user_message("<div class='error'>Invalid password..!!</div>", "error");
        }
        $url =$this->base_url . "clg/login";
        header('Location: '.$url);
        die();

        //redirect($this->base_url . "clg/login", 'location');
    }

    /* Added by MI-42 
     * 
     *  This function used to display colleagues.
     */

//    function colleagues($param=array()) {
//
//       
//        ///////////////  Filters carry //////////////////
//        
//        ($this->input->get_post('order_clg_by', TRUE)!='') ? ($data['order_by']=$args['order_by']=$this->input->get_post('order_clg_by', TRUE)) && ($data_qr.="&order_clg_by=".$args['order_by']) : "";
//            
//        ($this->input->get_post('clg_group', TRUE)!='') ? ($data['clg_group']=$args['clg_group']=$this->input->get_post('clg_group', TRUE)) && ($data_qr.="&clg_group=".$args['clg_group']) : "";
//        
//        ($this->input->get_post('search', TRUE)!='') ? ($data['search']=$args['search']=$this->input->get_post('search', TRUE)) && ($data_qr.="&search=".$args['search']) : "";
//            
//        
//        /////////////// Page number carry after any action ( delete ,edit ) ///////////////
//        
//         (isset($param['page_no']))?$page_number=$param['page_no']:$page_number = ($this->uri->segment(4))?$this->uri->segment(4):1;
//    
//         
//        $args['order_type'] = strstr($args['order_by'], '_', true);
//          
//        $column_name = strstr($args['order_by'], '_');
//
//        $args['column_name'] = trim($column_name, '_');
//        
//        $offset = ($page_number == 1) ? 0 : ($page_number * $this->pg_limit) - $this->pg_limit;
//        
//        $data['colleagues'] = $this->colleagues_model->get_all_colleagues($args, $offset, $this->pg_limit);
//        
//        $args['get_count']=TRUE;
//        
//        $config['total_rows']=$data['total_colleagues']= $total_colleagues = $this->colleagues_model->get_all_colleagues($args);
//        
//        $data['page_no']=$config['cur_page']=$page_number;
//        
//        $config['base_url'] = base_url("clg/colleagues");
//
//        $config['per_page'] = $this->pg_limit;
//        
//        $config['use_page_numbers'] = TRUE;
//
//        $config['attributes'] = array('class' => 'click-xhttp-request','data-qr'=>'output_position=content'.$data_qr);
//        
//        $config['uri_segment'] = 4;
//
//        $this->pagination->initialize($config);
//
//        $data['pagination'] = $this->pagination->create_links();
//        
//        $data['page_records']=count($data['colleagues']);
//        
//        $data['logged_in_clgs'] = $this->logged_in_clgs();
//
//        $data['users'] = $this->colleagues_model->get_groups();
//        
//        $this->output->add_to_position($this->load->view('ems-admin/colleagues/colleagues_list_view1', $data, true), $this->input->get_post('output_position',true), true);
//        
//        $this->output->add_to_position($this->load->view('ems-admin/colleagues/clg_filter_view',$data,TRUE),'clg_filters',TRUE);
//        
//    }




    function registration() {
       
        $data = array();


        $args = array(
            'clg_group' => $this->clg->clg_group
        );

        // $data['clg'] = $this->colleagues_model->get_type_level($args);

        $data['clg_group'] = $this->clg->clg_group;
        $data['group_info'] = $this->colleagues_model->get_groups();
        //var_dump($data['group_info'][0]->gparent);

        $data['super_groups'] = array('UG-OperationHR', 'UG-ERCHead', 'UG-SuperAdmin', 'UG-ERCManager');

        // if() $data['clg_group'] = $this->post['clg_group'];
        if ($data['group_info'][0]->gparent != "") {
            $data['get_parent'] = $this->colleagues_model->get_parent_member($data);
        }

        $state_args = array('st_code'=>'MP');
        $data['district_list'] = $this->inc_model->get_district_name($state_args);
        //var_dump($data['district_list']);
        //die();

        $data['action_type'] = "Add Employee";

        //$this->output->add_to_position($this->load->view('frontend/clg/register_view', $data, true));
        $this->output->add_to_popup($this->load->view('frontend/clg/register_view', $data, TRUE), '1200', '500');
    }

function check_mobile_exist(){
    $mobile_no = $this->post['mobile_no'];
    $user_group_id = $this->post['user_group_id'];
    
    if($user_group_id == 'UG-EMT' || $user_group_id == 'UG-PILOT'){
        $result = $this->colleagues_model->check_mobile_exist($mobile_no);
        if($result){
           
            $message = "<p style='font-size:10px; color:red;'>Mobile no already exist for ".$result[0]->clg_ref_id."!</p>";
             $this->output->add_to_position($message, 'mobile_error', 'TRUE');
        }
     
    }
      
}
    function create_user_id() {
        $str = $this->post['user_group'];
       // var_dump($str);
        $args = array(
            'clg_group' => $this->post['user_group']
        );
        $args['get_count'] = 'TRUE';
        $count = $this->colleagues_model->get_clg_data_for_new_emp($args); //added by snehal new fun in colleague model
       
         if($str == 'UG-EMT'){
           // $str = str_replace("MHEMT", "", $str);
            $cnt = $count + 1;
            $str1 .= "MPES-" . $cnt;
            $data['user_id'] = $str1;
        }
        elseif($str == 'UG-Pilot'){
           // $str = str_replace("UG-", "", $str);
            $cnt = $count + 1;
            $str1 .= "MPES-" . $cnt;
            $data['user_id'] = $str1;
            //var_dump( $data['user_id']);die;
        }
        else{
        $str = str_replace("UG-", "", $str);
       // var_dump($str);die;
        $cnt = $count + 1;
        $str .= "-" . $cnt;
       
        $data['user_id'] = $str; }
            
        $clg_data['clg_group'] = $this->post['user_group'];
        $data['clg_group'] = $this->post['user_group'];
        $data['group'] = $this->post['user_group'];
        $data['clg_designation'] = $this->post['user_group'];
        $data['clg_designation_name'] = get_EMS_title($this->post['user_group']);
        $this->output->add_to_position($this->load->view('frontend/clg/designation_view', $data, TRUE), 'designation_group', 'TRUE');
          
      
        
        
        $clg_data['get_team'] = 'true';
        $data['get_parent'] = $this->colleagues_model->get_parent_member($clg_data);

        if (!empty($data['get_parent'])) {
            $this->output->add_to_position($this->load->view('frontend/clg/team_member_view', $data, TRUE), 'senior_team_member', 'TRUE');
        } else {
            $this->output->add_to_position('', 'senior_team_member', 'TRUE');
        }
        if( $data['group'] == 'UG-EMT' ||  $data['group'] == 'UG-Pilot'){
             $this->output->add_to_position($this->load->view('frontend/clg/clg_sap_id', $data, TRUE), 'clg_avaya_agentid', 'TRUE');
        }else{
            $this->output->add_to_position($this->load->view('frontend/clg/clg_avaya_agentid', $data, TRUE), 'clg_avaya_agentid', 'TRUE');
        }


        $this->output->add_to_position($this->load->view('frontend/clg/user_view', $data, TRUE), 'clg_user_id', 'TRUE');
    
    }

    /* Added by MI-42
     *  
     *  This function is used to list colleagues group.
     */

    function group_list() {

        $this->tool_code = 'MT-CLG-GROUP-LIST';

        $data = array();

        $user_group = "";

        $data['group_id'] = '';

        $data['users'] = $this->colleagues_model->get_groups();

        $data['total_groups'] = count($data['users']);

        $this->output->add_to_position($this->load->view('frontend/clg/group_list_view', $data, true), 'content');
    }

    /* Added by MI-42
     *  
     *  This function is used to add colleagues group.
     */

    function add_group() {

        $this->tool_code = 'MT-CLG-ADD-GROUP';

        $data = array();

        $data['action'] = $this->modules->get_tool_config($this->tool_code, $this->active_module, true);

        $data['group_result'] = array();

        $data['group_id'] = '';

        if ($this->input->post('submit_group', TRUE)) {



            $this->form_validation->set_rules('user_gname', 'User Group name', 'required');



            $this->form_validation->set_rules('user_gcode', 'User Group code', 'required');



            $this->form_validation->set_rules('user_gstatus', 'User Group status', 'required');



            if ($this->form_validation->run() == TRUE) {


                $user_name = $this->post['user_gname'];



                $gcode = $this->post['user_gcode'];



                $glevel = 'secondary';



                $status = $this->post['user_gstatus'];



                $is_deleted = '0';



                $capital_gcode = 'UG-' . strtoupper($gcode);


                $result = $this->colleagues_model->add_group($user_name, $capital_gcode, $glevel, $status, $is_deleted);


                if ($result == true) {



                    $this->output->status = 1;



                    $this->output->message = "<div class='success'>Group Created Successfully!</div>";



                    $this->group_list();
                } else {

                    $this->output->message = "<div class='error'>Error Occur</div>";
                }
            } else {


                $this->output->message = "<div class='error'>" . validation_errors() . "</div>";
            }
        } else {

            $this->output->add_to_position($this->load->view('frontend/clg/add_group_view', $data, true));
        }
    }

    function edit_group() {


        $this->tool_code = 'MT-CLG-GROUP-EDIT';

        $data = array();

        $data['action'] = $this->modules->get_tool_config($this->tool_code, $this->active_module, true);

        $group_id = base64_decode($this->post['id']);


        $data['group_result'] = $this->colleagues_model->edit_group($group_id);

        $data['group_id'] = $group_id;



        if ($this->input->post('submit_group', TRUE)) {



            $this->form_validation->set_rules('user_gname', 'User Gname', 'required');



            $this->form_validation->set_rules('user_gcode', 'User Gcode', 'required');



            $this->form_validation->set_rules('user_gstatus', 'User_Gstatus', 'required');



            if ($this->form_validation->run() == TRUE) {

                $group_id = $this->post['group_id'];



                $user_group = array(
                    'ugname' => $this->post['user_gname'],
                    'status' => $this->post['user_gstatus']);



                if ($data['group_result'][0]->glevel != 'primary') {



                    $result = $this->colleagues_model->update_group($user_group, $group_id);



                    if ($result) {



                        $this->output->status = 1;



                        $this->output->message = "<div class='success'>Group Updated Successfully!</div>";



                        $this->group_list();
                    } else {




                        $this->output->message = "<div class='error'>Error Occur</div>";
                    }
                } else {


                    $this->output->message = "<div class='error'>Not allowed to edit this group..!!</div>";
                }
            } else {



                $this->output->message = "<div class='error'>" . validation_errors() . "</div>";
            }
        } else {


            $this->output->add_to_position($this->load->view('frontend/clg/add_group_view', $data, true));
        }
    }

    /* Added by MI-42
     *  
     *  This function is used to delete colleagues group.
     */

    function delete_group() {

        if (!empty($this->post['id'])) {

            $group_id = array_map("base64_decode", $this->post['id']);
        } else {

            $this->output->message = "<div class='error'>Please select atleast one group to delete</div>";
            return;
        }




        $is_delete = array('is_deleted' => '1');



        if (is_array($group_id)) {

            $delete_group = $this->colleagues_model->delete_groups($group_id, $is_delete);

            if ($delete_group == true) {

                $this->group_list();

                $this->output->status = 1;

                $this->output->message = "<div class='success'>Group Deleted Successfully!</div>";
            } else {

                $this->output->message = "<div class='error'>Error Occured</div>";
            }
        } else {

            $this->output->message = "<div class='error'>Please Select Group</div>";
        }
    }

    /* Added by MI-42
     *  
     *  This function is used to update colleagues group.
     */

    function update_group() {


        if ($this->post['id'] != "" && $this->post['status'] != "") {
            $status = array("active" => "inactive", "inactive" => "active");

            $update_status = $this->colleagues_model->update_groups_status(base64_decode($this->post['id']), array('status' => $status[$this->post['status']]));



            if ($update_status) {


                $this->output->message = "<div class='success'>Group Updated Successfully!</div>";

                $this->group_list();
            } else {

                $this->output->message = "<div class='error'>Failed to update group</div>";
            }
        }
    }

    /* Added by MI-42
     *  
     *  This function is used to register colleagues.
     */

    public function register_colleague() {

        $clg_data = $this->post['clg'];
        //var_dump($clg_data);die();

        $upload_err = FALSE;
        
          if($clg_data['clg_group'] == 'UG-EMT' || $clg_data['clg_group'] == 'UG-PILOT'){
                    $result = $this->colleagues_model->check_mobile_exist($clg_data['clg_mobile_no']);
                   
                    if($result){

                         $this->output->message = "<div class='error'>Mobile no already exist for ".$result[0]->clg_ref_id."!</div>";
                         return;
                    }

                }

//        $data['cluster_list'] = $this->cluster_model->get_cluster_data();



        //if (!$this->colleagues_model->check_colleague_mail($clg_data['clg_email'])) {
            $district_id = $this->clg->clg_district_id;
        $district_id = explode( ",", $district_id);
            $regex = "([\[|\]|^\"|\"$])"; 
            $replaceWith = ""; 
            $district_id = preg_replace($regex, $replaceWith, $district_id);
            
            if(is_array($district_id)){
                $district_id = implode("','",$district_id);
            }

            if (isset($_FILES['profile_photo']) && !empty($_FILES['profile_photo'])) {

                $img_extension = pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION);

                $img_size = $_FILES['profile_photo']['size'];

                $config = $this->clg_pic_config;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload('profile_photo')) {

                    $this->output->message = "<div class='error'>Profile photo size or type invalid..!! Please upload again..!</div>";
                    $upload_err = TRUE;
                    
                } 
//                else {
//
//
//                    $data = array('upload_data' => $this->upload->data());
//
//                    $new_img = $data['upload_data']['file_path'] . "thumb/" . $data['upload_data']['raw_name'] . $data['upload_data']['file_ext'];
//                   
//
//                    $config = $this->clg_pic_resize_config;
//
//                    $config['source_image'] = $data['upload_data']['full_path'];
//
//                    $config['new_image'] = $new_img;
//
//                    $this->image_lib->initialize($config);
//                    
//
//                    if (!$this->image_lib->resize()) {
//
//                        $this->output->message = "<div class='error'>Profile1 photo size or type invalid..!! Please upload again..!</div>";
//                        $upload_err = TRUE;
//                    }
//                }
            }



            if (isset($_FILES['clg_resume']) && !empty($_FILES['clg_resume'])) {

                $resume_extension = pathinfo($_FILES['clg_resume']['name'], PATHINFO_EXTENSION);

                $upload_path = FCPATH . $this->upload_path . "/colleague_profile/resumes";
                $_FILES['clg_resume']['name'] = $clg_data["clg_ref_id"] . "_" . $this->sanitize_string($_FILES['clg_resume']['name']);

                $rsm_config = $this->clg_rsm_config;

                $this->upload->initialize($rsm_config);
                
                

                if (!$this->upload->do_upload('clg_resume')) {
                    $msg =  $this->upload->display_errors();
                    $this->output->message = "<div class='error'>$msg .. Please upload again..!</div>";
                    $upload_err = TRUE;
                }

               
            }


            if (!$upload_err) {
                
                
              

                if (isset($_FILES['clg_resume']) && !empty($_FILES['clg_resume'])) {
                    $clg_data['clg_resume'] = $_FILES['clg_resume']['name'];
                }

                if (isset($_FILES['profile_photo']) && !empty($_FILES['profile_photo'])) {
                    $clg_data['clg_photo'] = $_FILES['profile_photo']['name'];
                }
                $clg_data['clg_avaya_agentid'] = $clg_data['clg_avaya_id'];

                $clg_pwd = $clg_data['clg_password'];
                $clg_pwd = '111111';
                
                if($clg_data['clg_group'] == 'UG-EMT' || $clg_data['clg_group'] == 'UG-PILOT'){
                     $clg_pwd = '112233';
                }

                $clg_data['clg_password'] = md5($clg_pwd);

                $clg_data['clg_is_active'] = '1';


                $clg_data['clg_joining_date'] = date('Y-m-d', strtotime($clg_data['clg_joining_date']));

                $clg_data['clg_dob'] = date('Y-m-d', strtotime($clg_data['clg_dob']));
                if (isset($clg_data['cluster_id'])) {
                    $clg_data['cluster_id'] = implode(',', $clg_data['cluster_id']);
                }
               // var_dump( $clg_data['clg_district_id']);
                if(!empty($clg_data['clg_district_id'])){
                    $clg_data['clg_district_id'] = json_encode( $clg_data['clg_district_id']);
                }
                

                $emp_cat = $clg_data['thirdparty'];
                $clg_data['thirdparty'] =$emp_cat;
                $ref_id = $clg_data['clg_ref_id'];
                $ref_id_count = strlen($clg_data['clg_ref_id']);
                $ref_id_middle_value = ($ref_id_count/2);

                $ref_id_first = substr($ref_id,0,2);
                $ref_id_midle = substr($ref_id,$ref_id_middle_value,2);
                $ref_id_last = substr($ref_id,-2);

                $ref_rand = $ref_id_first.$ref_id_midle.$ref_id_last;
                
                $clg_data['user_default_key'] = strtoupper($ref_rand);
                $clg_data['added_by'] = $this->clg->clg_ref_id;
                $clg_data['added_date'] = date('Y-m-d H:i:s');
                $clg_data['modify_by'] = $this->clg->clg_ref_id;
                $clg_data['modify_date'] = date('Y-m-d H:i:s');
                
                if($clg_data['clg_group']=='UG-DCO' || $clg_data['clg_group']=='UG-DCO-102' || $clg_data['clg_group']=='UG-EMT'){                  
                     $clg_data['clg_emso_id']=$ref_id;                 
                }
                
                //if($district_id == $this->post['hp_dtl_district'])
               // {
					$clg_group = $this->clg->clg_group;
                    $thirdparty = $this->clg->thirdparty;
              
                    if($emp_cat != '1') {
                          // var_dump($emp_cat);
                        //if($district_id == $this->post['hp_dtl_district']){
                              // var_dump($district_id);
                            
                        $register_result = $this->colleagues_model->clg_register($clg_data);
                        
//                        }else{
//                            $this->output->message = "<div class='success'>Colleague registered Successfully!</div>";
//                        }
                    }else{
                        $register_result = $this->colleagues_model->clg_register($clg_data);
                    }


                if ($register_result === TRUE) {
					
                    $this->output->status = 1;

                    $this->output->message = "<div class='success'>Colleague registered Successfully!</div>";
                    $clg_name = $clg_data['clg_first_name'] . " " . $clg_data['clg_last_name'];

                    $clg_group = $this->colleagues_model->get_groups($clg_data['clg_group']);

                    $user = array('ref_id' => $clg_data['clg_ref_id'], 'clg_name' => $clg_name, 'clg_group' => $clg_group[0]->ugname, 'clg_email' => $clg_data['clg_email']);

                    $this->send_clg_password_mail($clg_pwd, $user);

                    $this->output->closepopup = 'yes';
                    $this->output->status = 1;
                    $this->colleagues();
					
                } else if ($register_result == "duplicate") {

                    $this->output->add_to_position("<div class='error'>Duplicate Reference Id.. Not allowed.. please try another..</div>", 'dublicate_id', TRUE);
                } else {

                    $this->output->message = "<div class='error'>Not registered.. please retry</div>";
                }
            //}else{
              //  $this->output->message = "<div class='error'>District not matched...please try again</div>";
              //  }
            }
       // } else {

       //     $this->output->message = "<div class='error'>This email is allready exists please try another !</div>";
       //     $this->output->closepopup = 'no';
       // }
    }

    /* Added by MI42
     * 
     *  This function is used to send username and password to the colleagues after registration successful
     */

    function send_clg_password_mail($password, $user) {

        if ($reply_mail) {


            $message .= "Dear " . ucwords($user['clg_name']) . ", <br/><br/>"
                . "You are sucessfully register with \"" . site_url() . "\" as " . $user['clg_group'] . " <br/><br/>"
                . "Your " . $this->site_name . " login details are : <br/>"
                . "Username:" . $user['ref_id'] . " <br/>"
                . "Password :" . $password . " <br/><br/> "
                . "Thanks, <br/>"
                . $this->site_name;

            $email = $user['clg_email'];

            $subject = $this->site . " Details";


            $this->send_email($reply_mail, $message, $email, $subject);
        }
    }

    //// Created by MI44 ////////////////////
    // 
    // Purpose : Colleagues list
    // 
    /////////////////////////////////////////


    function colleagues() {


        ///////////////  Filters //////////////////

        $district_id = $this->clg->clg_district_id;
        $clg_group = $this->clg->clg_group;
        $district_id = explode( ",", $district_id);
            $regex = "([\[|\]|^\"|\"$])"; 
            $replaceWith = ""; 
            $district_id = preg_replace($regex, $replaceWith, $district_id);
            
            if(is_array($district_id)){
                $district_id_clg = implode("','",$district_id);
            }
            if($this->clg->thirdparty != '1'){
                $data['district_id'] = $district_id_clg;
                $data['thirdparty']=$this->clg->thirdparty;
            }else{ $data['thirdparty']=$this->clg->thirdparty; 
            }

        $data['clg_status'] = (isset($this->post['clg_status'])) ? $this->post['clg_status'] : $this->fdata['clg_status'];

        $data['order_by'] = ($this->post['order_clg_by']) ? $this->post['order_clg_by'] : $this->fdata['order_by'];

        $data['clg_group'] = ($this->post['clg_group'] != '') ? $this->post['clg_group'] : $this->fdata['clg_group'];

        $data['search'] = ($this->post['search']) ? $this->post['search'] : $this->fdata['search'];

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];




        //////////////////////////////////

        $data['order_type'] = strstr($data['order_by'], '_', true);

        $column_name = strstr($data['order_by'], '_');

        $data['column_name'] = trim($column_name, '_');

        $clgflt['CLG'] = $data;

        /////////////// //// ///////////////

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }

        ///////////limit & offset////////

        $data['get_count'] = TRUE;

        $data['super_groups'] = array('UG-OperationHR', 'UG-ERCHead', 'UG-SuperAdmin', 'UG-ERCManager');
        $data['cur_clg_group'] = $this->clg->clg_group;
        $data['group_info'] = $this->colleagues_model->get_groups();
        $group_info = $data['group_info'];
        $group_code = array();
        foreach ($group_info as $group) {

            if (($data['cur_clg_group'] != $group->gparent) && !in_array($cur_clg_group, $data['super_groups'])) {
                continue;
            }
            //if(trim($group->gparent) != ''){ continue; }

            $group_code[] = $group->gcode;
            foreach ($group_info as $group_l1) {

                if (trim($group->gcode) != trim($group_l1->gparent)) {
                    continue;
                }

                $group_code[] = $group_l1->gcode;

                foreach ($group_info as $group_l2) {

                    if (trim($group_l1->gcode) != trim($group_l2->gparent)) {
                        continue;
                    }
                    $group_code[] = $group_l2->gcode;

                    foreach ($group_info as $group_l3) {

                        if (trim($group_l2->gcode) != trim($group_l3->gparent)) {
                            continue;
                        }
                        $group_code[] = $group_l3->gcode;
                    }
                }
            }
        }
        $group_code = implode("','", $group_code);
        $data['group_code'] = $group_code;


        $data['total_count'] = $this->colleagues_model->get_all_colleagues($data);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        $clgflt['CLG'] = $data;

        $this->session->set_userdata('filters', $clgflt);

        ///////////////////////////////////

        unset($data['get_count']);



        $data['colleagues'] = $this->colleagues_model->get_all_colleagues($data, $offset, $limit);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("clg/colleagues"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        $data['pagination'] = get_pagination($pgconf);

        /////////////////////////////////

        $data['page_records'] = count($data['colleagues']);

        $data['logged_in_clgs'] = $this->logged_in_clgs();

        $data['users'] = $this->colleagues_model->get_groups();


        $this->output->add_to_position($this->load->view('frontend/clg/clg_list_view', $data, true), $this->post['output_position'], true);

        $this->output->add_to_position($this->load->view('frontend/clg/clg_filter_view', $data, TRUE), 'clg_filters', TRUE);
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose :  edit section / view /profile of clg
    // 
    /////////////////////////////////////////


    function edit_clg() {

        

        if ($this->post['ref_id'] != '') {

            $data['ref_id'] = $ref_id = base64_decode($this->post['ref_id']);
            $data['clg_group'] = $this->post['clg_group'];
        }
        
         $data['clg_group1'] = $this->clg->clg_group;

        $data['super_groups'] = array('UG-OperationHR', 'UG-ERCHead', 'UG-SuperAdmin', 'UG-ERCManager','UG-OP-HEAD');

        $data['group_info'] = $this->colleagues_model->get_groups();



        $data['image_path'] = $this->config->item('upload_path_colleague_images');

        $data['current_data'] = $current_data = $this->colleagues_model->get_user_info($ref_id);

        $data['get_parent'] = array();

        $data['get_parent'] = $this->colleagues_model->get_parent_member($data);


        $data['update'] = true;

        $data['prof'] = $this->post['prof'];

        $output_position = (isset($this->post['prof'])) ? 'popup_div' : 'content';

        $data['view_clg'] = $this->post['clg_view'];

        $data['colleagues'] = $this->post;

        if ($popup == 'close') {
            $this->output->closepopup = 'yes';
        }

        $data['call_pcr'] = $this->post['call'];

        $data['action_type'] = $this->post['action_type'] . " Profile";

        $clg_data['clg_group'] = $data['clg_group'];


        $clg_data['get_team'] = 'true';

        $data['get_parent'] = $this->colleagues_model->get_parent_member($clg_data);

        $state_args = array('st_code'=>'MP');
        $data['district_list'] = $this->inc_model->get_district_name($state_args);

        if ($this->post['action_type'] == 'View') {
            $data['clg_district_name'] = array();
            $clg_district_id = json_decode($current_data[0]->clg_district_id);
            if(is_array($clg_district_id)){
                foreach($clg_district_id as $dist_id){
                    $state_args = array('dst_code'=>$dist_id);
                     $district = $this->inc_model->get_district_name($state_args);
                     $clg_district[] = $district[0]->dst_name;
                }
                $data['clg_district_name'] = $clg_district;
            }

            
            //$this->output->add_to_position($this->load->view('frontend/clg/clg_register_view', $data, TRUE), 'popup_div', TRUE);
            $this->output->add_to_popup($this->load->view('frontend/clg/clg_register_view', $data, TRUE), '1200', '500');
        } else {
            //echo "hi";
            $this->output->add_to_popup($this->load->view('frontend/clg/register_view', $data, TRUE), '1200', '500');
            //$this->output->add_to_position($this->load->view('frontend/clg/register_view', $data, TRUE), 'popup_div', TRUE);
        }
    }

//    function profile(){
//
//        $ref_id =$this->post['ref_id'];
//        
//        $data['group_info'] = $this->colleagues_model->get_groups();
//
//        $data['current_data'] = $this->colleagues_model->get_user_info($ref_id);
//        
//        $data['update'] = true;
//        
//        $data['prof']  = $this->post['prof'];
//        
//        $this->output->add_to_position($this->load->view('frontend/clg/register_view',$data,TRUE),'popup_div',TRUE);
//      
//    }
    //// Created by MI42 ////////////////////
    // 
    // Purpose : Delete clg.
    // 
    /////////////////////////////////////////



    function delete_clg() {

        if (!empty($this->post['ref_id'])) {
            $ref_id = array_map("base64_decode", $this->post['ref_id']);
        } else {
            $this->output->message = "<div class='error'>Please select atleast colleague to delete</div>";
            return;
        }


        $delete_status = array('clg_is_deleted' => '1');

        $delete_result = $this->colleagues_model->delete_colleague($ref_id, $delete_status);

        if (!$delete_result) {
            $this->output->message = "<div class='error'>Not deleted..! Something went wrong..! Please try again..!!</div>";
        } else {
            $this->output->status = 1;

            $this->output->status = 1;
            $ref_id = (array) $ref_id;
            $this->output->message = "<div class='success'>Colleague with ID: " . implode(' ', $ref_id) . " Deleted Successfully!</div>";

            $this->colleagues();
        }
    }
    
    function inactivate_clg() {

        if (!empty($this->post['ref_id'])) {
            $ref_id = array_map("base64_decode", $this->post['ref_id']);
        } else {
            $this->output->message = "<div class='error'>Please select atleast colleague to delete</div>";
            return;
        }


        $delete_status = array('clg_is_active' => $this->post['active']);

        $delete_result = $this->colleagues_model->delete_colleague($ref_id, $delete_status);
        if($this->post['active'] == '0'){
            $msg = 'Inactive';
        }else{
            $msg = 'Active';
        }

        if (!$delete_result) {
            $this->output->message = "<div class='error'>Not $msg..! Something went wrong..! Please try again..!!</div>";
        } else {
            $this->output->status = 1;

            $this->output->status = 1;
            $ref_id = (array) $ref_id;
            $this->output->message = "<div class='success'>Colleague with ID: " . implode(' ', $ref_id) . " $msg Successfully!</div>";

            $this->colleagues();
        }
    }

    /* Added by MI-42
     *  
     *  This function is used to update colleagues information.
     */

    function update_colleague_data() {

        $district_id = $this->clg->clg_district_id;
        $clg_group = $this->clg->clg_group;
        $district_id = explode( ",", $district_id);
        $regex = "([\[|\]|^\"|\"$])"; 
        $replaceWith = ""; 
        $district_id = preg_replace($regex, $replaceWith, $district_id);
        if(is_array($district_id)){
            $district_id = implode("','",$district_id);
        }

        $current_user = $this->session->userdata('current_user');

        $clg_data = $this->post['clg'];


        $current_data = $this->colleagues_model->get_user_info($clg_data['clg_ref_id']);

        unset($clg_data['clg_photo']);

        unset($clg_data['clg_resume']);

        unset($clg_data['clg_password']);

        //if ($current_data[0]->clg_email == $clg_data['clg_email'] || !$this->colleagues_model->check_colleague_mail($clg_data['clg_email'])) {


            if (isset($_FILES['profile_photo'])) {

                $img_extension = pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION);
                $_FILES['profile_photo']['name'] = time() .'_'.$this->sanitize_file_name($clg_data['clg_ref_id']).$img_extension;
                
              

                $img_size = $_FILES['profile_photo']['size'];


                $config = $this->clg_pic_config;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload('profile_photo')) {

                    $this->output->message = "<div class='error'>Profile photo size(5MB) or type invalid..!! Please upload again..!</div>";
                    $upload_err = TRUE;
                } else {


                    $data = array('upload_data' => $this->upload->data());

                    $new_img = $data['upload_data']['file_path'] . "thumb/" . $data['upload_data']['raw_name'] . $data['upload_data']['file_ext'];

                    $config = $this->clg_pic_resize_config;

                    $config['source_image'] = $data['upload_data']['full_path'];

                    $config['new_image'] = $new_img;

                    $this->image_lib->initialize($config);

                    if (!$this->image_lib->resize()) {

                        $this->output->message = "<div class='error'>Profile photo size(5MB) or type invalid..!! Please upload again..!</div>";
                    }

                    $clg_data['clg_photo'] = $_FILES['profile_photo']['name'];
                }
            }



            if (isset($_FILES['clg_resume']) && !empty($_FILES['clg_resume'])) {

                $resume_extension = pathinfo($_FILES['clg_resume']['name'], PATHINFO_EXTENSION);

                $upload_path = FCPATH . $this->upload_path . "/colleague_profile/resumes";

                $_FILES['clg_resume']['name'] = $clg_data["clg_ref_id"] . "_" . $this->sanitize_string($_FILES['clg_resume']['name']);
                
                $rsm_config = $this->clg_rsm_config;

                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('clg_resume')) {
                    $msg = $this->upload->display_errors();
                    $this->output->message = "<div class='error'>$msg .. Please upload again..!</div>";
                    $upload_err = TRUE;
                } elseif($resume_extension != "pdf" && $resume_extension != "doc" && $resume_extension != "docx") {
                    $this->output->message = "<div class='error'>Invalid file extention .. Please upload valid file..!</div>";
                    $upload_err = TRUE;             
                    }else{
                    $clg_data['clg_resume'] = $_FILES['clg_resume']['name'];
                }
            }

            if (!$upload_err) {
                if ($clg_data['cluster_id']) {
                    $clg_data['cluster_id'] = implode(',', $clg_data['cluster_id']);
                }

                $clg_data['clg_gender'] = $clg_data['clg_gender'];
                //$clg_data['thirdparty'] = $clg_data['thirdparty'];
                $clg_data['clg_dob'] = $date = date('Y-m-d', strtotime($clg_data['clg_dob']));
                $clg_data['clg_joining_date'] = $date = date('Y-m-d', strtotime($clg_data['clg_joining_date']));
                
                $clg_data['modify_by'] = $this->clg->clg_ref_id;
                
                $clg_data['modify_date'] = date('Y-m-d H:i:s');
                $clg_data['clg_district_id'] = json_encode($clg_data['clg_district_id']);
            // var_dump($clg_data);die;
            if($clg_group=='UG-REMOTE'){
                if($district_id == $this->post['hp_dtl_district']){
                    $result = $this->colleagues_model->clg_update_data($clg_data);

                    if ($result) {
    
                        $this->output->status = 1;
    
                        $this->output->closepopup = 'yes';
    
                        $this->output->message = "<div class='success'>Employee updated Successfully<script>$('.module_systemusers .mt_clg_list').click();</script></div>";
    
                        if ($current_user->clg_group == 'UG-ADMIN') {
                            $this->colleagues();
                        }
                    }
                }else{
                    $this->output->message = "<div class='error'>District not matched...please try again</div>";
                }
            }else{
                $result = $this->colleagues_model->clg_update_data($clg_data);

                if ($result) {

                    $this->output->status = 1;

                    $this->output->closepopup = 'yes';

                    $this->output->message = "<div class='success'>Employee updated Successfully<script>$('.module_systemusers .mt_clg_list').click();</script></div>";

                    if ($current_user->clg_group == 'UG-ADMIN') {
                        $this->colleagues();
                    }
                }
            }
            }
//        } else {
//            $this->output->message = "<div class='error'>This email is allready exists!!</div>";
//        }
    }

    /* Added by MI-42
     *  
     *  This function is used to perform actions on colleagues.
     */

    function action_multi_clgs() {



        $action = $this->post['action_name'];



        $clg_ids = $this->post['clg_id_select'];



        if ($action == 'search_clgs') {


            $search_str = $this->post['search'];

            $filter = $this->post['filter_for_data'];


            if (!$search_str) {

                $this->output->message = "<div class='warning'>Search box can not be blank..! Please enter data box to be searched in search box..!!</div>";
            } else {


                $search_results = $this->colleagues_model->search_clg($search_str, $filter);



                if ($search_results) {



                    $data['colleagues'] = $search_results;


                    $data['search_str'] = $search_str;

                    $data['filter'] = $filter;

                    $data['order_by'] = $this->post['order_clg_by'];

                    $data['logged_in_clgs'] = $this->logged_in_clgs();


                    $this->output->status = 1;

                    $this->output->message = "<div class='success'>Related Colleagues data found to your search..!!</div>";

                    $data['users'] = $this->colleagues_model->get_groups();

                    $this->output->add_to_position($this->load->view('frontend/clg/clg_list_view', $data, true));
                } else {



                    $this->output->message = "<div class='error'>No records found related to your search..!!</div>";
                }
            }
        } else {



            if (!empty($clg_ids)) {



                switch ($action) {



                    case 'delete_clgs':





                        $ids = "'" . implode("','", $clg_ids) . "'";



                        $delete_result = $this->colleagues_model->delete_colleague($ids);





                        if (!$delete_result) {



                            $this->output->message = "<div class='error'>Error deleting colleague(s)..! please try again..!!</div>";
                        } else {



                            $this->output->status = 1;



                            $this->output->message = "<div class='success'>Selected Colleagues Deleted Successfully..!!</div>";
                        }





                        break;



                    case 'block_clgs':


                        $ids = "'" . implode("','", $clg_ids) . "'";





                        $block_result = $this->colleagues_model->block_colleague($ids);





                        if (!$block_result) {




                            $this->output->message = "<div class='error'>Error blocking colleague ID(s).. please try again..!!</div>";
                        } else {



                            $this->output->status = 1;



                            $this->output->message = "<div class='success'>Selected Colleagues Blocked Successfully..!!</div>";
                        }





                        break;



                    case 'unblock_clgs':



                        $ids = "'" . implode("','", $clg_ids) . "'";





                        $unblock_result = $this->colleagues_model->unblock_colleague($ids);





                        if (!$unblock_result) {



                            $this->output->message = "<div class='error'>Can not unblock selected IDs..  Something went wrong..! please try again..!!</div>";
                        } else {



                            $this->output->status = 1;



                            $this->output->message = "<div class='success'>Selected IDs Unblocked Successfully..!!</div>";
                        }





                        break;



                    default:

                        $this->output->message = "<div class='error'>No action selected.. Please select any action..!!</div>";

                        break;
                }
            } else {


                $this->output->message = "<div class='error'>Please select colleagues..!!</div>";
            }
        }

        $this->colleagues();
    }

    function log() {

        $this->load->view('frontend/clg/log_view', TRUE);
    }

    ////////////MI44/////////////
    //
    //Purpose: get team member
    //
    /////////////////////////////


    function get_team_member() {

        $clg_data = $this->post['clg'];


        $clg_data['get_team'] = 'true';

        $data['get_parent'] = $this->colleagues_model->get_parent_member($clg_data);


        $this->output->add_to_position($this->load->view('frontend/clg/team_member_view', $data, TRUE), 'parent_member', TRUE);
    }

    function get_cluster_list() {
        $clg_data = $this->post['clg'];
        if ($clg_data['clg_group'] == 'UG-EMT') {
            $data['cluster_list'] = $this->cluster_model->get_cluster_data();

            $this->output->add_to_position($this->load->view('frontend/clg/cluster_view', $data, TRUE), 'parent_member', TRUE);
        } else {
            $this->output->add_to_position('', 'parent_member', TRUE);
        }
    }

    function change_password_first_login() {
        $current_user_data = $this->session->userdata('current_user');

        $data['ref_id'] = $ref_id = $current_user_data->clg_ref_id;

        $data['current_data'] = $this->colleagues_model->get_user_info($ref_id);
        $data['first'] = 'yes';

        $this->output->add_to_position($this->load->view('frontend/clg/change_password_form_view', $data, true));
    }

    function get_pwd_user_details() {

        $data['ref_id'] = $ref_id = $this->post['ref_id'];

        $data['current_data'] = $this->colleagues_model->get_user_info($ref_id);

        $this->output->add_to_position($this->load->view('frontend/clg/change_password_form_view', $data, true));
    }

    function reset_password(){
           $data['ref_id'] = $ref_id = $this->post['ref_id'];

        $data['current_data'] = $this->colleagues_model->get_user_info($ref_id);

        $this->output->add_to_position($this->load->view('frontend/clg/reset_password_form_view', $data, true));
    }
    function change_reset_clg_pwd() {

        $data['ref_id'] = $ref_id = $this->post['ref_id'];

        $current_user = $this->session->userdata('current_user');

        $password = md5($this->post['reset_password']);

        $current_data = $this->colleagues_model->get_user_info($data['ref_id']);


        $change_result = $this->colleagues_model->change_password($ref_id, $password);

        if ($change_result) {
            $redirect = "";
            if ($current_user->clg_group == 'UG-EMT') {
                $url = $this->base_url . 'emt/emt_home';
                $redirect = "<script>window.location = '$url';</script>";
            } else if ($current_user->clg_group == 'UG-ERO' || $current_user->clg_group == 'UG-ERO-102') {
               $url = $this->base_url . 'calls';
                //$url = $this->base_url . 'calls/calls_blank';
                $redirect = "<script>window.location = '$url';</script>";
            } else if ($current_user->clg_group == 'UG-ERCP') {
                $url = $this->base_url . 'ercp';
                $redirect = "<script>window.location = '$url';</script>";
            } else if ($current_user->clg_group == 'UG-ERO-108') {
                $url = $this->base_url . 'calls';
                $redirect = "<script>window.location = '$url';</script>";
            } else if ($current_user->clg_group == 'UG-DCO') {
                $url = $this->base_url . 'job_closer';
                $redirect = "<script>window.location = '$url';</script>";
            } else if ($current_user->clg_group == 'UG-Dashboard') {
                $url = $this->base_url . 'dashboard';
                $redirect = "<script>window.location = '$url';</script>";
            } else {
                $url = $this->base_url . 'dash';
                $redirect = "<script>window.location = '$url';</script>";
            }

            $this->output->closepopup = 'yes';
            $this->output->status = 1;
            $this->output->message = "<div class='success'>Password for id " . $ref_id . " changed Successfully..!!$redirect</div>";

            if ($current_user->clg_group == 'UG-ADMIN') {
                $this->colleagues();
            }
        } else {
            $this->output->message = "<div class='error'>Some error occured.. please retry..!!</div>";
        }
    }
    function change_clg_pwd() {

        $data['ref_id'] = $ref_id = $this->post['ref_id'];

        $current_user = $this->session->userdata('current_user');

        $password = md5($this->post['password']);

        $confirm_pass = md5($this->post['confirm_password']);

        $current_password = md5($this->post['current_password']);

        $current_data = $this->colleagues_model->get_user_info($data['ref_id']);
        $previous_password = $current_data[0]->clg_password;

        if ($previous_password != $current_password) {
            $this->output->status = 1;
            $this->output->closepopup = "yes";
            $this->output->message = "<div class='error'>Cureent password did not match with current password.. Please retry..!!</div>";
            return false;
        }
        if ($password != $confirm_pass) {

            $this->output->status = 1;
            $this->output->closepopup = "yes";

            $this->output->message = "<div class='error'>Confirm password did not match with password.. Please retry..!!</div>";
            return false;
        }

        $change_result = $this->colleagues_model->change_password($ref_id, $password);

        if ($change_result) {
            $redirect = "";
            if ($current_user->clg_group == 'UG-EMT') {
                $url = $this->base_url . 'emt/emt_home';
                $redirect = "<script>window.location = '$url';</script>";
            } else if ($current_user->clg_group == 'UG-ERO' || $current_user->clg_group == 'UG-ERO-102') {
               $url = $this->base_url . 'calls';
                //$url = $this->base_url . 'calls/calls_blank';
                $redirect = "<script>window.location = '$url';</script>";
            } else if ($current_user->clg_group == 'UG-ERCP') {
                $url = $this->base_url . 'ercp';
                $redirect = "<script>window.location = '$url';</script>";
            } else if ($current_user->clg_group == 'UG-ERO-108') {
                $url = $this->base_url . 'calls';
                $redirect = "<script>window.location = '$url';</script>";
            } else if ($current_user->clg_group == 'UG-DCO') {
                $url = $this->base_url . 'job_closer';
                $redirect = "<script>window.location = '$url';</script>";
            } else if ($current_user->clg_group == 'UG-Dashboard') {
                $url = $this->base_url . 'dashboard';
                $redirect = "<script>window.location = '$url';</script>";
            } else {
                $url = $this->base_url . 'dash';
                $redirect = "<script>window.location = '$url';</script>";
            }

            $this->output->closepopup = 'yes';
            $this->output->status = 1;
            $this->output->message = "<div class='success'>Password for id " . $ref_id . " changed Successfully..!!$redirect</div>";

            if ($current_user->clg_group == 'UG-ADMIN') {
                $this->colleagues();
            }
        } else {
            $this->output->message = "<div class='error'>Some error occured.. please retry..!!</div>";
        }
    }

    /* Added by MI-42
     *  
     *  This function is used to destroy colleagues session.
     */

//    function admin_logout() {
//
//        $ref_id = $this->post['ref_id'];
//        
//        if ($ref_id) {
//
//            $delete_usr_session = $this->colleagues_model->delete_user_session($ref_id);
//        
//            if ($delete_usr_session) {
//
//                $this->output->message = "<div class='success'>User with Reference id " . $ref_id . " logged out successfully..!!</div>";
//                
//               // $this->logout();
//            }
//        }else {
//
//            $this->output->message = "<div class='error'>Reference id not received..!!</div>";
//        }
//    }

    public function download_rsm() {

        if ($this->uri->segment(3)) {

            $this->download($this->uri->segment(3));
        }
    }

    function is_exists() {

        if ($this->post['clg_ref_id']) {
            $res = $this->colleagues_model->clg_is_exists(array('clg_ref_id' => $this->post['clg_ref_id']));

            if ($res) {

                $this->output->add_to_position("<script>$('#clg_ref_id').attr('data-exists','yes');</script>", 'custom_script', true);
            } else {
                $this->output->add_to_position("<script>$('#clg_ref_id').attr('data-exists','no');</script>", 'custom_script', true);
            }
        }

        if ($this->post['clg_email']) {




            $flag = true;

            if ($this->post['ud_clg_id'] != '') {

                $clg = $this->colleagues_model->get_user_info($this->post['ud_clg_id']);

                $flag = ($clg[0]->clg_email != $this->post['clg_email']) ? true : false;
            }



            if ($flag) {


                $res = $this->colleagues_model->clg_is_exists(array('clg_email' => trim($this->post['clg_email'])));

                ($res) ? $this->output->add_to_position("<script>$('#clg_email').attr('data-exists','yes');</script>", 'custom_script', true) : $this->output->add_to_position("<script>$('#clg_email').attr('data-exists','no');</script>", 'custom_script', true);
            }
        }
    }

    function clg_notice() {

        $this->output->add_to_position($this->load->view('frontend/clg/clg_notice_view', $data, TRUE), $output_position, TRUE);
    }

    function clg_supervisor_notice() {

        $this->output->add_to_position($this->load->view('frontend/clg/supervisor_notice_view', $data, TRUE), $output_position, TRUE);
    }

    function save_notice() {

        $data = array(
            'nr_base_month' => $this->post['base_month'],
            'nr_notice' => $this->input->post('notice'),
            'nr_date' => date('Y-m-d H:i:s'),
            'is_deleted' => '0',
            'notice_added_by' => $this->clg->clg_ref_id,
            'nr_user_group' => json_encode($this->input->post('user_group')),
            'notice_exprity_date' => date('Y-m-d H:i:s', strtotime($this->input->post('expiry_date')))
        );

        $nr_id = $this->colleagues_model->insert_notice($data);

        $args = array(
            'user_group' => $this->input->post('user_group')
        );

        $data1['clg_data'] = $this->colleagues_model->get_clg_data($args);



        foreach ($data1['clg_data'] as $value) {

            $clg_data = array(
                'clg_ref_id' => $value->clg_ref_id,
                'nr_notice_id' => $nr_id,
                'n_added_by' => $this->clg->clg_ref_id,
                'n_added_date' => date('Y-m-d H:i:s'),
            );

            $this->colleagues_model->insert_clg_notice($clg_data);
        }

        if ($nr_id) {

            $this->output->status = 1;

            $this->output->closepopup = "yes";

            $this->output->message = "<h3>Remark </h3><br><p>added successfully.</p><script>window.location.reload(true);</script>";

            $this->output->moveto = 'top';

            $this->output->add_to_position('', 'content', TRUE);
        }
    }

    function get_notice() {

        $clg_group = array('nr_user_group' => $this->clg->clg_group,
            'nr_id' => $this->post['nr_id']
        );

        $data['call_res'] = $this->colleagues_model->get_clg_notice($clg_group);

        $args = array(
            'nr_notice_id' => $this->post['nr_id'],
            'clg_ref_id' => $this->clg->clg_ref_id,
            'n_is_closed' => '1'
        );


        $data['result'] = $this->colleagues_model->update_notice_rem($args);

        $this->output->status = 1;

        $this->output->message = '';

        $this->output->add_to_position($this->load->view('frontend/clg/clg_notice_view', $data, TRUE), $output_position, TRUE);

        $this->output->add_to_position($this->load->view('frontend/clg/clg_notice_count_view', $data, TRUE), 'header_notice_reminder', TRUE);
    }
    
    function login_successful(){
        
        $ref_id = get_cookie("username");
         $ext_no =  $this->session->userdata('extension_no');
        $data['ext_no'] = $ext_no; 

        $data['ref_id_encode'] = base64_encode($ref_id);
		$data['clg_group'] = $this->clg->clg_group;
        $data['clg_avaya_agentid'] = trim($this->clg->clg_avaya_agentid);
        
        $this->output->add_to_position($this->load->view('frontend/clg/login_successful_view', $data, true));

        $this->output->template = "cell";
        
    }
    
    function keep_alive_clg(){
        $ref_id = get_cookie("username");
        $current_user = $this->colleagues_model->get_user_info($ref_id);

        $is_live_time = time();
        $login_status_update = $this->colleagues_model->update_clg_field($ref_id, 'clg_is_alive_time', $is_live_time);
        
        $ero_args = array('is_alive_time'=>$is_live_time);
        $login_status_update = $this->call_model->update_ero_user_status($ero_args,$ref_id);
        
 
        $clg_is_alive_time=  $current_user[0]->clg_last_login_time;
  
         $ero_args = array(
            'clg_is_alive_time'=>$is_live_time
        );
        $login_history_id = $this->session->userdata('login_history_id');
        $login_details_live = $this->colleagues_model->update_login_details_live(strtolower($ref_id),$login_history_id,$ero_args);
       
        
        //return $login_status_update;
        die();
    }
    function is_login_set_no(){
        //$ref_id = get_cookie("username");
        $ref_id = $this->post['ref_id'];
        $login_status_update = $this->colleagues_model->update_clg_field($ref_id,  'clg_is_login', 'no');
        die();
    }
    
    function update_clg_login_status(){
        //set_time_limit(0);
       // $x = 1;
        
        //while($x <= 4) {
        
        	//file_put_contents('./logs/crons/'.date("Y-m-d").'_update_clg_login_status.log', time().",\r\n", FILE_APPEND);
//        $current_data = $this->colleagues_model->get_last_login_user();
//        $current_user = json_encode($current_data);
//        file_put_contents('./logs/logout_avaya/'.date("Y-m-d").'_update_clg_login_status.log', $current_user.",\r\n", FILE_APPEND);
//        
//            $is_live_time = time();
//            $current_data = $this->colleagues_model->update_auto_logout_flag($is_live_time);
//
//
//            $is_live_time = time();
//            $current_data = $this->call_model->delete_ero_call_user_cron($is_live_time);
//            
//            $current_time = date('Y-m-d H:i:s');
//            $current_data = $this->colleagues_model->update_auto_logout_colleague($current_time);
            
            //$x++;
           // sleep(60);
           
      //  } 
       // die();
       
        //die();
        $current_data = $this->colleagues_model->get_last_login_user();

        if(!empty($current_data)){
         foreach($current_data as $clg){
             
            $clg_data = array('clg_ref_id' => $clg->clg_ref_id,
                              'clg_break_type' => 'LO',
                              'clg_is_login' => 'no');

            //$result = $this->colleagues_model->clg_update_data($clg_data);
            
            $result = $this->colleagues_model->update_clg_field($clg->clg_ref_id, 'clg_break_type', 'LO');
            $result1 = $this->colleagues_model->update_clg_field($clg->clg_ref_id, 'clg_is_login', 'no');
            $current_user_data = $this->call_model->is_ero_free_user_exists($clg->clg_ref_id);
            
            
        $ext_no = $this->session->userdata('avaya_extension_no');
        $agent_id= corel_encrypt_str($this->clg->clg_avaya_agentid);
        
        
        $coral_url = $this->corel_server_url.'/agentlogout';
		$avaya_args = array('agentid' => $agent_id);
        
        if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
        }
       
    
        $data_insert = array('action_id'=>'logout',
                            'action_data'=>json_encode($avaya_args),
                            'action_datetime'=>date('Y-m-d H:i:s'));
        
        $state = $this->call_model->insert_avaya_action($data_insert);

        //$avaya_res = corel_curl_post_api($coral_url, $avaya_args);
        
        //$avaya_res_encode = $avaya_res["resp"];
        
        file_put_contents('./logs/'.date("Y-m-d").'/'.date("Y-m-d").'avaya_logout_log.log', $avaya_res_encode.",\r\n", FILE_APPEND);

            
            
           $clg_login = $this->colleagues_model->clg_user_last_login($clg->clg_ref_id);
           
           if($clg_login){
               $clg_last_login = $this->colleagues_model->update_login_details_cron(strtolower($clg->clg_ref_id),$clg_login[0]->id);
           }
                    
            $current_data = $this->call_model->delete_ero_call_user($clg->clg_ref_id);
            
            
         }
        }
        $current_time = date('Y-m-d H:i:s');
        $current_data = $this->colleagues_model->update_auto_logout_colleague();
             

        // var_dump($current_data);
         die();
     
    }
    function update_user_key(){
       
        $data = $this->colleagues_model->get_all_colleagues();
   
        foreach($data as $clg){
            
            $ref_id = preg_replace('/[^A-Za-z0-9\-]/', '',$clg->clg_ref_id);
            $ref_id_count = strlen($ref_id);
            $ref_id_middle_value = ($ref_id_count/2);

            $ref_id_first = substr($ref_id,0,2);
            $ref_id_midle = substr($ref_id,$ref_id_middle_value,2);
            $ref_id_last = substr($ref_id,-2);

            $ref_rand = $ref_id_first.$ref_id_midle.$ref_id_last;
            $ref_rand = strtoupper( $ref_rand);
            $res = $this->colleagues_model->clg_user_default_key_exists(array('user_default_key' => trim($ref_rand)));
            if($res){
               $ref_rand= str_shuffle($ref_rand);
            }
            
            $login_status_update = $this->colleagues_model->update_clg_field($clg->clg_ref_id, 'user_default_key', $ref_rand);
        
        }
        die();
    }
    
    function login_agents() {

        $login_clg_list = $this->colleagues_model->logged_in_clgs();
        //var_dump($login_clg_list);
        
        $list = array();
        
        foreach($login_clg_list as $login_clg){
            //var_dump($login_clg->clg_group);
            
            if($login_clg->clg_group == "UG-ERO" || $login_clg->clg_group == "UG-ERO-102"){
                $list['ERO'] = $list['ERO']+1;
            }
            if($login_clg->clg_group == "UG-DCO" || $login_clg->clg_group == "UG-DCO-102"){
                $list['DCO'] = $list['DCO']+1;
            }
            if($login_clg->clg_group == "UG-EMT"){
                $list['EMT'] = $list['EMT']+1;
            }
            if($login_clg->clg_group == "UG-ERCP"){
                $list['ERCP'] = $list['ERCP']+1;
            }
            if($login_clg->clg_group == "UG-PDA"){
                $list['PDA'] = $list['PDA']+1;
            }
            if($login_clg->clg_group == "UG-FDA"){
                $list['FDA'] = $list['FDA']+1;
            }
             if($login_clg->clg_group == "UG-Grievance"){
                $list['Grievance'] = $list['Grievance']+1;
            }
            if($login_clg->clg_group == "UG-Feedback"){
                $list['Feedback'] = $list['Feedback']+1;
            }
            if($login_clg->clg_group == "UG-Quality"){
                $list['Quality'] = $list['Quality']+1;
            }
            
            
            
            if($login_clg->clg_group == "UG-EROSupervisor"){
                $list['EROSupervisor'] = $list['EROSupervisor']+1;
            }
            if($login_clg->clg_group == "UG-DCOSupervisor"){
                $list['DCOSupervisor'] = $list['DCOSupervisor']+1;
            }
            if($login_clg->clg_group == "UG-EMTSupervisor"){
                $list['EMTSupervisor'] = $list['EMTSupervisor']+1;
            }
            if($login_clg->clg_group == "UG-ERCPSupervisor"){
                $list['ERCPSupervisor'] = $list['ERCPSupervisor']+1;
            }
            if($login_clg->clg_group == "UG-PDASupervisor"){
                $list['PDASupervisor'] = $list['PDASupervisor']+1;
            }
            if($login_clg->clg_group == "UG-FDASupervisor"){
                $list['FDASupervisor'] = $list['FDASupervisor']+1;
            }
              if($login_clg->clg_group == "UG-GrievianceManager"){
                $list['GrievianceManager'] = $list['GrievianceManager']+1;
            }
              if($login_clg->clg_group == "UG-FeedbackManager"){
                $list['FeedbackManager'] = $list['FeedbackManager']+1;
            }
            if($login_clg->clg_group =="UG-ERCTRAINING"){
                $list['ERCTRAINING'] = $list['ERCTRAINING']+1;
            }

            if($login_clg->clg_group =="UG-ERCManager"){
                $list['ERCManager'] = $list['ERCManager']+1;
            }
            if($login_clg->clg_group =="UG-ShiftManager"){
                $list['ShiftManager'] = $list['ShiftManager']+1;
            }
            if($login_clg->clg_group =="UG-QualityManager"){
                $list['QualityManager'] = $list['QualityManager']+1;
            }
            if($login_clg->clg_group =="UG-BioMedicalManager"){
                $list['BioMedicalManager'] = $list['BioMedicalManager']+1;
            }
            if($login_clg->clg_group =="UG-ERCPSupervisor"){
                $list['ERCPSupervisor'] = $list['ERCPSupervisor']+1;
            }
          
            
        }
        $data['login_clg'] = $list;
        $this->output->add_to_position($this->load->view('frontend/clg/login_agents_view', $data, true));
    }
    function show_login_user(){
        
        $clg_group = $this->post['clg_group'];
        
        $data['group_code'] =str_replace(",","','",$clg_group);
        $call_status = array('free','atnd');
        
        if($this->post['clg_is_login'] != ''){
            
            if(in_array($this->post['clg_is_login'], $call_status)){
                 $data['status'] = $this->post['clg_is_login'];
            }else{
                $data['clg_is_login'] = array($this->post['clg_is_login']);
            }
        }else{
        $data['clg_is_login'] = array('yes','break');
        }
       
        
        $data['order_by'] = ($this->post['order_clg_by']) ? $this->post['order_clg_by'] : $this->fdata['order_by'];
        $data['clg_ref_id'] = ($this->post['user_id']) ? $this->post['user_id'] : $this->fdata['clg_ref_id'];
        $data['search'] = ($this->post['search_user']) ? $this->post['search_user'] : $this->fdata['search_user'];


        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $data['agent_id'] = $this->clg->clg_avaya_agentid;



        /////////////// //// ///////////////

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }

        ///////////limit & offset////////

        $data['get_count'] = TRUE;
 
       $data['total_count'] = $this->colleagues_model->get_all_colleagues($data);
       // die();

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        $clgflt['CLG'] = $data;

        $this->session->set_userdata('filters', $clgflt);

        ///////////////////////////////////

        unset($data['get_count']);



        $data['colleagues'] = $this->colleagues_model->get_all_colleagues($data, $offset, $limit);
        //var_dump($data['colleagues']);die();
        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("clg/show_login_user"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        $data['pagination'] = get_pagination($pgconf);

        /////////////////////////////////

        $data['page_records'] = count($data['colleagues']);



        $this->output->add_to_position($this->load->view('frontend/clg/show_login_user_view', $data, true), 'login_user_list', TRUE);
        
    }
    function sanitize_string( $string, $sep = '-' ){
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9 -_\.]+/', '', $string);
        $string = trim($string);
        $string = str_replace(' ', $sep, $string);
        return trim($string, '-_');
    }
    function show_avaya_extenstion(){
        $user_name_id = $this->input->post('user_name_id');
       
        
        $colleagues = $this->colleagues_model->get_clg_data(array('clg_reff_id'=>$user_name_id));
        
        $group= $colleagues[0]->clg_group;

       
        
            //var_dump($group);die();
            $groups_array = array('UG-ERO','UG-ERO-102','UG-ERO-104','UG-DCO','UG-EROSupervisor','UG-DCOSupervisor','UG-FleetManagement','UG-FleetManagementHR','UG-ShiftManager');

            if(in_array( $group,$groups_array)){
                $data['extention_no'] = $this->call_model->get_all_avaya_extension_new();
                //var_dump($data['extention_no']);die();
                $this->output->add_to_position($this->load->view('frontend/clg/avaya_extension_view', $data, true), 'extension_block_outer', TRUE);
            }else{
               $this->output->add_to_position('', 'extension_block_outer', TRUE); 
            }
        
    }
 function show_extenstion(){
        
        $user_name_id = $this->input->post('user_name_id');
       
        
        $colleagues = $this->colleagues_model->get_clg_data(array('clg_reff_id'=>$user_name_id));
        
        $group= $colleagues[0]->clg_group;

        
        $groups_array = array('UG-ERO','UG-ERO-102','UG-DCO','UG-EROSupervisor','UG-DCOSupervisor','UG-FleetManagement','UG-FleetManagementHR');
			
        if(in_array( $group,$groups_array)){
            $data['extention_no'] = $this->call_model->get_all_avaya_extension();
            $this->output->add_to_position($this->load->view('frontend/clg/extension_view', $data, true), 'extension_block_outer', TRUE);
        }else{
           $this->output->add_to_position('', 'extension_block_outer', TRUE); 
        }
    }
    function get_district_by_div(){
        $data = array();
        $div_code = $this->input->post('div_code');
        $state_args = array('st_code'=>'MH','div_code' =>  $data['div_code'] );
        $data['district_list'] = $this->common_model->get_dist_by_div(array('div_code' => $div_code));
       // $data['district_list'] = $this->inc_model->get_district_name($state_args);
        $this->output->add_to_position($this->load->view('frontend/clg/get_district_by_div', $data, true), 'div_district', TRUE);
       
    }
    function mapping_ip_extension(){
        
        $extention_list = $this->call_model->get_all_avaya_extension();


        foreach($extention_list as $list){
            
            $extension_no = corel_encrypt_str($list->extension_no);
            
            $queueid = corel_encrypt_str($list->queueid);
            $ip_en = corel_encrypt_str($list->ip_address);
            $avaya_server_url = $this->avaya_server_url . '/ipextensionmapping';
//            $extension_no = corel_encrypt_str('5015');
//            
//            $queueid = corel_encrypt_str('11');
//            $ip_en = corel_encrypt_str('10.108.3.37');
                    
			$avaya_args = array('queueid' => $queueid,'extension' => $extension_no,'ipaddress'=>$ip_en);
    
            $avaya_res = corel_curl_post_api($avaya_server_url, $avaya_args);
            //var_dump($avaya_res);
           // die();
            
        }
        echo "done";
        die();
    }
     function sanitize_file_name( $string, $sep = '-' ){
        $path_info = pathinfo($string);
        $string = $path_info['filename'];
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9 -_]+/', '', $string);
        $string = trim($string);
        $string = str_replace(' ', $sep, $string);
        $string = str_replace('.', '-', $string);
        $string .= '.'.$path_info['extension'];
        return trim($string, '-_');
    }
        function forcefully_logout() {


        ///////////////  Filters //////////////////

        $district_id = $this->clg->clg_district_id;
        $clg_group = $this->clg->clg_group;
        $district_id = explode( ",", $district_id);
            $regex = "([\[|\]|^\"|\"$])"; 
            $replaceWith = ""; 
            $district_id = preg_replace($regex, $replaceWith, $district_id);
            
            if(is_array($district_id)){
                $district_id_clg = implode("','",$district_id);
            }
//            if($this->clg->thirdparty != '1'){
//                $data['district_id'] = $district_id_clg;
//                $data['thirdparty']=$this->clg->thirdparty;
//            }else{ 
//                $data['thirdparty']=$this->clg->thirdparty; 
//            }
       // var_dump($clg_group);
        if($clg_group == 'UG-FeedbackManager'){
            $data['group_code'] ='feedback'; 
        }
       
        $data['clg_status'] = (isset($this->post['clg_status'])) ? $this->post['clg_status'] : $this->fdata['clg_status'];

        $data['order_by'] = ($this->post['order_clg_by']) ? $this->post['order_clg_by'] : $this->fdata['order_by'];

        $data['clg_group'] = ($this->post['clg_group'] != '') ? $this->post['clg_group'] : $this->fdata['clg_group'];

        $data['search'] = ($this->post['search']) ? $this->post['search'] : $this->fdata['search'];

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];




        //////////////////////////////////

        $data['order_type'] = strstr($data['order_by'], '_', true);

        $column_name = strstr($data['order_by'], '_');

        $data['column_name'] = trim($column_name, '_');

        $clgflt['CLG'] = $data;

        /////////////// //// ///////////////

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }

        ///////////limit & offset////////

        $data['get_count'] = TRUE;

       // $data['super_groups'] = array('UG-OperationHR', 'UG-ERCHead', 'UG-SuperAdmin', 'UG-ERCManager');
       // $data['cur_clg_group'] = $this->clg->clg_group;
        $data['clg_is_login']='yes';

        $data['total_count'] = $this->colleagues_model->get_all_colleagues($data);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        $clgflt['CLG'] = $data;

        $this->session->set_userdata('filters', $clgflt);

        ///////////////////////////////////

        unset($data['get_count']);



        $data['colleagues'] = $this->colleagues_model->get_all_colleagues($data, $offset, $limit);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("clg/forcefully_logout"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        $data['pagination'] = get_pagination($pgconf);

        /////////////////////////////////

        $data['page_records'] = count($data['colleagues']);

        $data['logged_in_clgs'] = $this->logged_in_clgs();

        $data['users'] = $this->colleagues_model->get_groups();


        $this->output->add_to_position($this->load->view('frontend/clg/clg_forcefully_list_view', $data, true), $this->post['output_position'], true);

        $this->output->add_to_position($this->load->view('frontend/clg/clg_forcefully_filter_view', $data, TRUE), 'clg_filters', TRUE);
    }
    
    function force_logout(){
        
        //$this->output->add_to_position($this->load->view('frontend/clg/clg_forcefully_view', $data, true), $this->post['output_position'], true);
        $data['ref_id'] =$this->input->post('ref_id');
        $this->output->add_to_popup($this->load->view('frontend/clg/clg_forcefully_view', $data, TRUE), '1200', '500');
        
    }
    
    function save_force_logout(){
        $force_data = $this->input->post();
        $force_data['ref_id']= base64_decode($force_data['ref_id']);
        
        $data_insert = array('logout_remark'=>$force_data['logout_remark'],
                            'logout_ref_id'=> $force_data['ref_id'],
                            'added_by'=>$this->clg->clg_ref_id,
                            'added_date'=>date('Y-m-d H:i:s'));
        
        $state = $this->colleagues_model->insert_forcefully_logout($data_insert);
        
        $result = $this->colleagues_model->update_clg_field($force_data['ref_id'], 'clg_break_type', 'LO');
        $result1 = $this->colleagues_model->update_clg_field($force_data['ref_id'], 'clg_is_login', 'no');
        $current_user_data = $this->call_model->is_ero_free_user_exists($force_data['ref_id']);
        $this->output->message = "<div class='success'>Forcefully Logout Successfully!</div>";
        $this->forcefully_logout();
    }

    function import_clg()   
    {
        $data['test']=1;
        $this->output->add_to_position($this->load->view('frontend/clg/import_clg_view', $data, TRUE), 'popup_div', TRUE);
       // $this->output->add_to_popup($this->load->view('frontend/clg/import_clg_view', $data, TRUE), 'popup_div', TRUE);
    }
    function download_sample_format()
    {
        $header = array(
            'User ID [Text]',
            'Employee ID [Text]',
            'Group [Text]',
            'Designation [Text]',
            'First Name [Text]',
            'Middle Name [Text]',
            'Last Name [Text]',
            'Email [Text]',
            'Mobile No  [Int]',
            'Gender [Text]',
            'Marital Status [Text]',
            'Date of Birth [Date]',
            'Joining Date [Date]',
            'Address [Text]',
            'City [Text]',
            'District [int]',
            'Division [int]',
            'Employee Category [int]',
        );
        $filename = "Add_Employee_format.csv";
        $fp = fopen('php://output', 'w');

        header('Content-type: application/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        fputcsv($fp, $header);
        $data = array(
            'clg_ref_id' => 'Superadmin-10',
            'clg_jaesemp_id' => 'ABC1234',
            'clg_group' => 'UG-SuperAdmin',
            'clg_designation' => 'SuperAdmin',
            'clg_first_name'  => 'Demo',
            'clg_mid_name' => 'Test',
            'clg_last_name' => 'Demo',
            'clg_email' => 'Demo@gmail.com',
            'clg_mobile_no' => '1234567890',
            'clg_gender' => 'male',
            'clg_marital_status' => 'single',
            'clg_dob' => '22-04-1997',
            'clg_joining_date' => '24-09-2022',
            'clg_address' => 'Bhopal Madhhya Pradesh',
            'clg_city' => 'Bhopal',
            'clg_district_id' => '["1"]',
            'clg_zone' => '2',
            'thirdparty' => '1'

        );
        fputcsv($fp, $data);
        fclose($fp);
        exit;
    }
    function save_import_clg()
    {
        $post_data = $this->input->post();
        $filename = $_FILES["file"]["tmp_name"];

        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($filename, "r");
            $a = array();
            $c = array();
            while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
                $column_count = count($getData);
                // var_dump($column_count);die();
                if ($column_count == 18) {
                    if ($count == 0) {
                        $count++;
                        continue;
                    } else {
                        if($getData[0] == '')
                        {
                            $this->output->status = 1;
                            $this->output->message = "<div class='error'>" . "User ID should not be blank" . "</div>";
                            $this->output->closepopup = 'yes';
                            $this->output->status = 1;
                            $this->colleagues();
                        }
                        else if($getData[1] == ''){
                            $this->output->status = 1;
                            $this->output->message = "<div class='error'>" . "Employee ID should not be blank" . "</div>";
                            $this->output->closepopup = 'yes';
                            $this->output->status = 1;
                            $this->colleagues();
                        }
                        else if($getData[2] == ''){
                            $this->output->status = 1;
                            $this->output->message = "<div class='error'>" . "Employee Group should not be blank" . "</div>";
                            $this->output->closepopup = 'yes';
                            $this->output->status = 1;
                            $this->colleagues();
                        }
                        else if($getData[4] == ''){
                            $this->output->status = 1;
                            $this->output->message = "<div class='error'>" . "First Name should not be blank" . "</div>";
                            $this->output->closepopup = 'yes';
                            $this->output->status = 1;
                            $this->colleagues();
                        }
                        else if($getData[6] == ''){
                            $this->output->status = 1;
                            $this->output->message = "<div class='error'>" . "Last Name should not be blank" . "</div>";
                            $this->output->closepopup = 'yes';
                            $this->output->status = 1;
                            $this->colleagues();
                        }
                        else if($getData[8] == ''){
                            $this->output->status = 1;
                            $this->output->message = "<div class='error'>" . "Mobile Number should not be blank" . "</div>";
                            $this->output->closepopup = 'yes';
                            $this->output->status = 1;
                            $this->colleagues();
                        }
                        else if($getData[15] == ''){
                            $this->output->status = 1;
                            $this->output->message = "<div class='error'>" . "District should not be blank" . "</div>";
                            $this->output->closepopup = 'yes';
                            $this->output->status = 1;
                            $this->colleagues();
                        }
                        else{
                        $clg_data = array(

                            'clg_ref_id' => $getData[0],
                            'clg_jaesemp_id' => $getData[1],
                            'clg_group' => $getData[2],
                            'clg_designation' => $getData[3],
                            'clg_first_name'  => $getData[4],
                            'clg_password'=> '96e79218965eb72c92a549dd5a330112',
                            'clg_mid_name' => $getData[5],
                            'clg_last_name' => $getData[6],
                            'clg_email' => $getData[7],
                            'clg_mobile_no' => $getData[8],
                            'clg_gender' => $getData[9],
                            'clg_marital_status' => $getData[10],
                            'clg_dob' => date('Y-m-d',strtotime($getData[11])),
                            'clg_joining_date' => date('Y-m-d',strtotime($getData[12])),
                            'clg_address' => $getData[13],
                            'clg_city' => $getData[14],
                            'clg_district_id' => $getData[15],
                            'clg_zone' => $getData[16],
                            'thirdparty' => $getData[17],
                            'modify_date_sync' => date('Y-m-d H:i:s'),
                            'added_date'=>date('Y-m-d H:i:s'),
                            'clg_is_active' => '1'
                        );
                        $insert = $this->colleagues_model->insert_clg($clg_data);
                        if (is_array($insert)){
                            $data = implode(', ',$insert[0]);
                            array_push($c,$d,'break');
                            $this->output->add_to_position("<div class='success' style='color : blue;font-weight:bold'>Last Record: User ID = $insert[1], Employee ID = $insert[2], Name = $insert[3] $insert[4]..</div><br>", 'last_record', TRUE);
                            $this->output->add_to_position("<div class='error' style='color : red;font-weight:bold;margin-bottom:20px;'>Error:<br>Duplicate Entry ($data).. Not allowed.. please try another..</div>", 'duplicate_emp_id', TRUE);
                            break;
                        }else{
                            array_push($a,$b,'insert');
                            continue;
                        }
                    }
                    }
                } else {
                    $this->output->message = "<div class='error'>" . "Employee column count not match" . "</div>";
                }
            }
            if(!empty($a) && empty($c)){
                $this->output->status = 1;
                $this->output->message = "<div class='success'>" . "Employee Details is added successfully" . "</div>";
                $this->output->closepopup = 'yes';
                $this->output->status = 1;
                $this->colleagues();
            }
        }
    }
    function download_sample_format_clg_grp(){
        $header = array(
            'Name',
            'Employee Group',
        );
        $data = $this->colleagues_model->get_all_grps();;

        $filename = "employee_group_format.csv";
        $fp = fopen('php://output', 'w');

        header('Content-type: application/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        fputcsv($fp, $header);
        //var_dump($data);die();
        $grp_data = array();
        foreach ($data as $row) {
            //var_dump($row);
            $grp_data = array(
                'ugname' =>  $row->ugname,
                'gcode' => $row->gcode,
            );
            fputcsv($fp, $grp_data);
        }
        fclose($fp);
        exit;
    }

    function report_login(){
        $data = [];
            $this->session->set_userdata('temp_usr', "NHM");
            $this->session->set_userdata('password', "Nhm@108");
        // $this->session->set_userdata('temp_usr', "CENTERDASH-2");
        //             $this->session->set_userdata('password', "111111");
        $this->output->add_to_position($this->load->view('frontend/clg/login_view', $data, true));
        $this->output->template = "cell";

    }

    function nhm_login(){
        $this->session->set_userdata('temp_usr', "Nhm-Dashboard");
        $this->session->set_userdata('password', "111111");
        // $this->session->set_userdata('temp_usr', "CENTERDASH-1");
        //             $this->session->set_userdata('password', "111111");
    }
}