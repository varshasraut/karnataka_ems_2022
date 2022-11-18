<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Coral_Avaya_Api extends EMS_Controller {
    
    function __construct() {

        parent::__construct();

        $this->active_module = "M-API";
        $this->pg_limit = $this->config->item('pagination_limit');

        $this->gps_url = $this->config->item('amb_gps_url');

        $this->bvgtoken = $this->config->item('bvgtoken');
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper','cct_helper','coral_helper'));
        $this->load->model(array('options_model', 'module_model', 'common_model','call_model','inc_model','corona_model'));
        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));


	    $this->clg = $this->session->userdata('current_user');
        $this->post = $this->input->get_post(NULL);
        $this->avaya_server_url = $this->config->item('avaya_server_url');
        
        $this->corel_server_url = $this->config->item('corel_server_url');

    }

    public function index($generated = false) {

        echo "This is Avaya API controller";

    }
    
    function soft_dial(){
        
        $avaya_password =  $this->clg->clg_avaya_passwd;
        $avaya_username =  $this->clg->clg_avaya_agentid;
        $this->session->unset_userdata('conference_dial_mobile','');
         $this->session->unset_userdata('soft_dial_mobile');
         $this->session->unset_userdata('active_calls');
        
        
        $ip = $_SERVER['REMOTE_ADDR'];

        $avaya_ext = $this->call_model->get_avaya_extension($ip);

        $ext_no=$avaya_ext->ext_no;
        $agent_id=$avaya_ext->agent_id;
      
        $ext_no = get_cookie("avaya_extension_no");
        if($this->clg->clg_group == 'UG-FleetManagement'){
           //$agent_id= corel_encrypt_str($this->clg->clg_avaya_agentid);  
        }
        $agent_id = $this->session->userdata('avaya_extension_no');
       // $agent_id= corel_encrypt_str($this->clg->clg_avaya_agentid);  
        
       // $agent_id=5001;
        
        $mobile_no = $this->post['mobile_no'];

       //if(!empty($ext_no)){
        
        
        $avaya_server_url = $this->avaya_server_url.'/originatecall';
        
        
        $unique_id = time();
        $avaya_args = array(//'ActionID'=>$unique_id,
                            'AgentID'=>$agent_id,
                            'callerextension'=>$agent_id,
                            'callernumber'=>$mobile_no);
							
        
        $this->session->set_userdata('dial_history', $avaya_args);
        $this->session->set_userdata('call_action', 'dialing');
        $this->session->set_userdata('soft_dial_mobile', $mobile_no);
       
        
        //$avaya_data = json_encode($avaya_args);
	
        
        $avaya_resp =  coral_agent_makecall($avaya_args);
       // var_dump($avaya_resp);
        //die();
        
       //$avaya_resp["resp"] = '"{\"status\":0,\"message\":\"Call has been originated to  : 09730015484\",\"data\":null}"';
        
        $avaya_resp = $avaya_resp["resp"];
       
        
       
        $avaya_resp_de = json_decode($avaya_resp);
        //$avaya_resp_de->status = '0';
        
      
        if($avaya_resp_de->status == 0 || $avaya_resp_de->status == '0'){
                sleep(3);
           
                $avaya_pickupcall_url = $this->avaya_server_url.'/autopickupphone';


                $avaya_args = array('agentnumber'=>$agent_id);

                //$avaya_resp_ans =  corel_curl_post_api($avaya_pickupcall_url,$avaya_args);
        
        
        }
        
         if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
        }
       file_put_contents('./logs/'.date("Y-m-d").'/'.date("Y-m-d").'avaya_softdial_log.log', $avaya_resp.",\r\n", FILE_APPEND);
      

       if(!empty($avaya_resp)){
            if($avaya_resp->status == 0 || $avaya_resp->status == '0'){
                
                $active_call = $this->session->userdata('all_calls');
              
                
                if($active_call){   

                $active_call[] = array('mobile_no'=>$mobile_no,
                                     'call_status'=>'active');
                
                $active_calls = $active_call;
              
                }else{
                     $active_calls[] = array('mobile_no'=>$mobile_no,
                                     'call_status'=>'active');
                }
                $this->session->set_userdata('all_calls', $active_calls);
               
                
    
                $caller = array();
                $caller["CallUniqueID"] = $unique_id;
                $caller["call_extension"] = $ext_no;
                $caller["call_mobile"] = $mobile_no;
               // $caller["call_agentid"] = $agent_id;
               // $caller["call_data"] = 'dialing';
                //$caller["call_message"] = $avaya_resp->ResMessage;
                $caller["call_datetime"] = date('Y-m-d H:i:s');
                $clr_id = $this->call_model->insert_softdial_details($caller);
                $data['call_data'] = $avaya_args;
                $data["call_type_data"] = 'dialing';
                $data['active_calls'] =$this->session->userdata('all_calls');
                
                $this->output->add_to_position($this->load->view('frontend/avaya/connected_dialer_view', $data, TRUE), 'dialerscreen', TRUE);
                
        }else{
            $this->output->message = "<p> Sorry!...... Error occure</p>";
        }
        
      }else{
           $this->output->message = "<p> Sorry!...... Call Not Initiated</p>";
      }
        
    }
    function hd_soft_dial(){
        
        $avaya_password =  $this->clg->clg_avaya_passwd;
        $avaya_username =  $this->clg->clg_avaya_agentid;
        
        $ip = $_SERVER['REMOTE_ADDR'];

        $avaya_ext = $this->call_model->get_avaya_extension($ip);

        $ext_no=$avaya_ext->ext_no;
        $agent_id=$avaya_ext->agent_id;
      
        $ext_no = get_cookie("avaya_extension_no");
        //$agent_id=$this->clg->clg_avaya_agentid;
        
        $mobile_no = $this->post['mobile_no'];

       if(!empty($ext_no)){
        
        
        $avaya_server_url = $this->avaya_server_url.'/MakeCall';
        
        $unique_id = time();
        $avaya_args = array('ActionID'=>$unique_id,
                            'AgentID'=>$agent_id,
                            'AgentExtension'=>$ext_no,
                            'Destination'=>$mobile_no);
							
        
        $this->session->set_userdata('dial_history', $avaya_args);
        $this->session->set_userdata('call_action', 'dialing');
       
        
        $avaya_data = json_encode($avaya_args);
	
        $avaya_resp =  cct_agent_makecall($avaya_server_url,$avaya_data);
        $avaya_resp = json_decode($avaya_resp["resp"]);
        
        if($avaya_resp){
            
                $caller = array();
                $caller["CallUniqueID"] = $unique_id;
                $caller["call_extension"] = $ext_no;
                $caller["calling_phone_no"] = $mobile_no;
                $caller["agent_no"] = $agent_id;
               // $caller["call_data"] = 'dialing';
                //$caller["call_message"] = $avaya_resp->ResMessage;
                $caller["call_datetime"] = date('Y-m-d H:i:s');
               
                $clr_id = $this->corona_model->insert_softdial_details($caller);
                //$data['call_data'] = $avaya_args;
                $data["status"] = 'dialing';
                $data["CallUniqueID"] = $unique_id;
                
                // $this->output->add_to_position($this->load->view('frontend/avaya/connected_dialer_view', $data, TRUE), 'dialerscreen', TRUE);
                $this->output->add_to_position($this->load->view('frontend/corona/unique_id_view', $data, TRUE), 'avaya_unique_id', TRUE);
                 $this->output->message = "<p> Call Connected .....</p>";
         
                
       }else{
            $this->output->message = "<p> Sorry!...... Error occure</p>";
       }
        
       }else{
            $this->output->message = "<p> Sorry!...... Avaya Extension not found</p>";
       }
        
    }
    
       function disconnect_call(){
        
        $post = $this->input->post();
        $avaya_ext = get_cookie("avaya_extension_no");
            $agent_id=$this->clg->clg_avaya_agentid;
            $avaya_campaign=$this->clg->clg_avaya_campaign;

                      
                $avaya_server_url = $this->avaya_server_url.'/HangupCall';
        
                $avaya_args = array('ActionID'=>time(),
                                    'AgentID'=>$agent_id,
                                    'AgentExtension'=>$avaya_ext,
                                     'Destination'=>1212);

                $avaya_data = json_encode($avaya_args);
                $avaya_resp =  cct_agent_disconnectcall($avaya_server_url,$avaya_data);

                $avaya_resp = json_decode($avaya_resp["resp"]);
                
                $this->session->unset_userdata('dial_history');
                $this->session->set_userdata('call_action', 'disconnect');
                $this->session->unset_userdata('all_calls');
                
                $data["call_type_data"] = 'disconnect';
                //<script>$AVAYA_INCOMING_CALL_FLAG = 0;
                
                $this->output->add_to_position('', 'dialerscreen', TRUE);
                

        
        
    }
    

    
    function soft_dial_disconnect(){
        
        $post = $this->input->post();
         if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
        }
       // var_dump($post['AgentID']);
        //$post['AgentID'] = 5001;
        $post['AgentID'] = $this->session->userdata('extension_no');
        $this->session->unset_userdata('conference_dial_mobile');
        $this->session->unset_userdata('dial_history');
        $this->session->set_userdata('call_action', 'disconnect');
        $this->session->unset_userdata('all_calls');
         
     
        if($post['AgentID'] != ''){
    
            if(!empty($post['AgentID'])){
                      
                $avaya_server_url = $this->avaya_server_url.'/HangupCall';
                $agent_id = $post['AgentID'];
        
                $avaya_args = array('ActionID'=>$post['ActionID'],
                                    'AgentID'=>$post['AgentID'],
                                    'AgentExtension'=>$post['AgentExtension']);

                $avaya_data = json_encode($avaya_args);
                $active_calls =  pbx_active_calls();
                
                $active_call_decode = json_decode($active_calls['resp']);
                $active_calls_data = json_decode($active_call_decode->data);
                if(!empty($active_calls_data)){
                    foreach($active_calls_data as $calls){
                        if($calls->extension == $agent_id){
                            $uuid = $calls->uuid;
                        }

                    }
                }
         
              
               $avaya_active_encode = json_encode($active_calls);
        
                file_put_contents('./logs/'.date("Y-m-d").'/'.date("Y-m-d").'avaya_active_log.log', $avaya_active_encode.",\r\n", FILE_APPEND);

              
                $avaya_args_cr = array('uuid' => corel_encrypt_str($uuid));
                $avaya_kill_resp =  pbx_kill_calls($avaya_args_cr);

             
                $avaya_resp = json_decode($avaya_resp["resp"]);
                
                $this->session->unset_userdata('dial_history');
                $this->session->set_userdata('call_action', 'disconnect');
                

                $caller = array();
                //$caller["call_id"] = $post['ActionID'];
                $caller["call_agentid"] = $post['AgentID'];
                $caller["call_extension"] = $post['AgentExtension'];
                //$caller["call_data"] = 'disconnect';
                $caller["call_message"] = 'Disconnect Successfully';
                $caller["call_datetime"] = date('Y-m-d H:i:s');
                

                $clr_id = $this->call_model->insert_softdial_details($caller);
                $data["call_type_data"] = 'disconnect';
                $this->output->add_to_position('', 'dialerscreen', TRUE);
                

            }else{
                echo "Insuffient data";
                die();
            }
        }
        
    }
    
    function call_recveing(){
      
        $php_input =  file_get_contents( 'php://input' );
       // $php_input =  '{"calldate":"2020-09-21","calltime":"16:58:35","deviceid":"5004","calluniqueid":"50f516dc-9372-41ea-883b-1c3d94313822","callstate":"R","callstatedesc":"Disconnected","calltype":"I","callingdevice":"5004","calleddevice":"5010","sessionuuid":"0549c19c-d655-497a-87dd-dfb228a9a180","log_time":"2020-09-21 16:58:26"}';
        $post = json_decode( $php_input,true);
        
        if(json_last_error()){ 
            echo json_encode(array('status'=>'fail','message'=>"Wrong json data!"));
            die();
        }
       
        $agent = $post['callingdevice'];
        file_put_contents('./logs/avaya_calls/'.$agent.'.json', $php_input);
        
        $post['log_time'] = date('Y-m-d H:i:s');
		$post_encode = json_encode($post);
        
        if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
        }
        file_put_contents('./logs/'.date("Y-m-d").'/all_avaya_call_records.log', $post_encode."\r\n", FILE_APPEND);
		file_put_contents('./logs/'.date("Y-m-d").'/'.$agent.'_avaya_call_records.log', $post_encode.",\r\n", FILE_APPEND);
         
        $current_time = strtotime(date('Y-m-d H:i:s')); 
        $avaya_data = array(
           'calling_phone_no' => $post['calleddevice'],
           'CallUniqueID'=>$post['sessionuuid'],
           'sessionuuid'=>$post['sessionuuid'],
           'agent_no' => $post['callingdevice'],
           'message' => $post['callstatedesc'],
           'status' => $post['callstate'],
           //'call_datetime' => date('Y-m-d H:i:s'),
           'is_deleted' => '0');
        
        
        if ($post['sessionuuid'] == ''){
            die();
        }
 
       
        if($post['callstate'] == "R" || $post['callstate'] == "B"){
            
            $avaya_data['call_rinning_datetime'] = date('Y-m-d').' '.$post['calltime'];;
            $avaya_data['avaya_call_time'] = $post['calltime'];
			$avaya_data['call_datetime'] = date('Y-m-d H:i:s');
            $avaya_ext = $this->call_model->insert_avaya_incoming_call($avaya_data);
 
        
        }else{
               
            if($post['param1'] != '' ){
                $avaya_data['call_audio'] = $post['param1'];
            }
            
            $avaya_data['dis_conn_massage'] = $post['callstatedesc'];
            
            if($post['callstate'] == "D"){
                $avaya_data['call_disconnect_datetime'] = date('Y-m-d').' '.$post['CallTime'];
            }else if($post['callstate'] == "C"){
                $avaya_data['call_connect_datetime'] = date('Y-m-d').' '.$post['CallTime'];
            }
            
            //if($post['callstate'] == "D" && $post['param1'] != ''){
            
            //    $avaya_call = $this->call_model->update_avaya_call_by_sessionuuid($avaya_data);   
            
           // }else{
                $avaya_call = $this->call_model->update_avaya_call_by_calluniqueid($avaya_data);   
                $avaya_call = $this->corona_model->update_avaya_call_by_calluniqueid($avaya_data);
          //  }
        } 
        
        if($post['callstate'] == "D"){

            
            $inc_avaya_data = array('inc_avaya_uniqueid'=>$post['sessionuuid']);
            if($post['param1'] != ''){
                $inc_avaya_data['inc_audio_file']=$post['param1'];
            }
           // var_dump($inc_avaya_data);
            $avaya_call = $this->inc_model->update_incident_by_avayaid($inc_avaya_data);
            

        }
        
        echo json_encode(array('status'=>'success','message'=>"Call receive successfully!"));
        die();
        
    }
    
    function call_recveing_audio(){
      
        $php_input =  file_get_contents( 'php://input' );
       // $php_input =  '{"calldate":"2020-09-21","calltime":"16:58:35","deviceid":"5004","calluniqueid":"50f516dc-9372-41ea-883b-1c3d94313822","callstate":"R","callstatedesc":"Disconnected","calltype":"I","callingdevice":"5004","calleddevice":"5010","sessionuuid":"0549c19c-d655-497a-87dd-dfb228a9a180","log_time":"2020-09-21 16:58:26"}';
        $post = json_decode( $php_input,true);
        
        if(json_last_error()){ 
            echo json_encode(array('status'=>'fail','message'=>"Wrong json data!"));
            die();
        }
       
        $agent = $post['callingdevice'];
        
        $post['log_time'] = date('Y-m-d H:i:s');
		$post_encode = json_encode($post);
        
        if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
        }
        file_put_contents('./logs/'.date("Y-m-d").'/all_avaya_call_audio_records.log', $post_encode."\r\n", FILE_APPEND);
		file_put_contents('./logs/'.date("Y-m-d").'/'.$agent.'_avaya_call_audio_records.log', $post_encode.",\r\n", FILE_APPEND);
         
        $current_time = strtotime(date('Y-m-d H:i:s')); 
         if ($post['sessionuuid'] == ''){
            die();
        }
        $avaya_data = array(
            'sessionuuid'=>$post['sessionuuid'],
           );
 
       
       
        if($post['callstate'] == "D" ){
            
        
            if($post['param1'] != '' ){
                $avaya_data['call_audio'] = $post['param1'];
            }
           // $avaya_call = $this->call_model->update_avaya_call_by_calluniqueid($avaya_data); 
           // die();
                $avaya_call = $this->call_model->update_avaya_call_by_sessionuuid($avaya_data);   
               // $avaya_call = $this->corona_model->update_avaya_call_by_calluniqueid($avaya_data);
         
        } 
        
        if($post['callstate'] == "D"){

            
            $inc_avaya_data = array('inc_avaya_uniqueid'=>$post['sessionuuid']);
            
            if($post['param1'] != ''){
                $inc_avaya_data['inc_audio_file']=$post['param1'];
            }
            
            $avaya_call = $this->inc_model->update_incident_by_avayaid($inc_avaya_data);

        }
        
        echo json_encode(array('status'=>'audio success','message'=>"Call audio receive successfully!"));
        die();
        
    }

    
    function send_curl_request($url, $parameter = '', $method = "get") {

        set_time_limit(0);

        if (function_exists("curl_init") && $url) {

            $user_agent = $_SERVER['HTTP_USER_AGENT'];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);

            if (is_array($parameter)) {

                //$query_string = http_build_query($parameter);
				$query_string = array();
				
				foreach($parameter as $key => $value){
					
					$query_string []= $key."=".$value;
				
				}
				$query_string = join("&",$query_string);
				
            } else {

                $query_string = $parameter;
            }
           
            curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookiesjar.txt');

           
          
           curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);

            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

           /// curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

            if ($method == "post") {

                curl_setopt($ch, CURLOPT_POST, 1);

                if ($parameter != "") {

                    curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
                }
            } else {

                curl_setopt($ch, CURLOPT_HTTPGET, 1);

                if ($parameter != "") {

                    $url = trim($url, "?") . "?" . urlencode($query_string);
                }
            }
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            $document = curl_exec($ch);

           // echo "error>". curl_error($ch);
          //  print_r($document);

            curl_close($ch);

            return $document;
        }
    }
    
    function conference_transfer_call_responce(){
        $php_input =  file_get_contents( 'php://input' );
        $post = json_decode( $php_input,true);
       
        
		file_put_contents('./logs/avaya_conf_call_resp_'.date("Y-m-d").'.log', $php_input."\r\n", FILE_APPEND);
        
        if($post['status_code'] == '105' && $post['status_code'] == '106' && $post['status_code'] == '107'){
            if(!empty($post['callingFromPhoneNumber'])){

                $caller = array();
                $caller["call_form"] = $post['callingFromPhoneNumber'];
                $caller["call_to"] = $post['callingToPhoneNumber'];
                $caller["call_message"] = $post['message'];
                $caller["call_datetime"] = date('Y-m-d H:i:s');

                $clr_id = $this->call_model->insert_softdial_details($caller);
                
                
                $post['status'] = "success";

                echo json_encode($post);
                die();

            }else{
                echo "Insuffient data";
                die();
            }
        }
    }
    function start_conference_call(){
        
        $ext_no = get_cookie("avaya_extension_no");
        $agent_id = $this->session->userdata('extension_no');;
        
        $mobile_no = $this->post['mobile_no'];
       
        if(!empty($ext_no)){
        
        $this->session->set_userdata('call_action', 'conference');
        
       $agent_id=corel_encrypt_str($this->clg->clg_avaya_agentid);
       
 
        
        $avaya_server_url = $this->avaya_server_url.'/startmultipartyconference';
        
        $unique_id = time();
        $avaya_args = array(//'ActionID'=>$unique_id,
                            'agentnumber'=>$agent_id);
							
        
       
        
        //$avaya_data = json_encode($avaya_args);
	
        
        $avaya_resp =  corel_curl_post_api($avaya_server_url,$avaya_args);
        
        
        
        $avaya_resp = json_decode($avaya_resp["resp"]);
      
     
        
        if($avaya_resp->status == 0){
            
                
                   $active_calls = $this->session->userdata('all_calls');
                    if($active_calls){
                       foreach($active_calls as $activ){
                          $activ['call_status'] = 'active';
                          $up_active_calls[]=$activ;
                       }
                    }
                $this->session->set_userdata('all_calls', $up_active_calls);
                $data["active_calls"] = $this->session->userdata('all_calls');

           
                $data["call_type_data"] = 'start_conference';
                
                $this->output->add_to_position($this->load->view('frontend/avaya/connected_dialer_view', $data, TRUE), 'dialerscreen', TRUE);
                
        }else{
            
            $this->output->message = "<p> Sorry!...... Error occure <b>".$avaya_resp->message."</b></p>";
            
        }
        
       }else{
            $this->output->message = "<p> Sorry!...... Avaya Extension not found</p>";
       }
       
        
    }
    function add_conference_call(){
        
        $ext_no = get_cookie("avaya_extension_no");
        $agent_id = $this->session->userdata('extension_no');;
        
        $mobile_no = $this->post['mobile_no'];
        $agent_id=corel_encrypt_str($this->clg->clg_avaya_agentid);
       
        if(!empty($ext_no)){
        
        $this->session->set_userdata('call_action', 'conference');
 
        
        $avaya_server_url = $this->avaya_server_url.'/addinmultipartyconference';
        
        $unique_id = time();
        $avaya_args = array(//'ActionID'=>$unique_id,
                            'agentnumber'=>$agent_id,
                            'number'=>$mobile_no);
        
        $session_conf_mobile= $this->session->userdata('conference_dial_mobile');
        $session_conf_mobile[]=$mobile_no;
        $data['conf_mobile']=$session_conf_mobile;
        $data['soft_dial_mobile']=$this->session->userdata('soft_dial_mobile');
							
        
        $this->session->set_userdata('dial_history', $avaya_args);
        $this->session->set_userdata('conference_dial_mobile', $session_conf_mobile);
       
        
        //$avaya_data = json_encode($avaya_args);
	
        
        $avaya_resp =  corel_curl_post_api($avaya_args);
        file_put_contents('./logs/'.date("Y-m-d").'/avaya_conf_call_resp_'.date("Y-m-d").'.log', $avaya_resp["resp"]."\r\n", FILE_APPEND);
        
        $avaya_resp = json_decode($avaya_resp["resp"]);
        
        if($avaya_resp->status == 0){
            
                $active_call = $this->session->userdata('all_calls');
              
                
                if($active_call){   

                $active_call[] = array('mobile_no'=>$mobile_no,
                                     'call_status'=>'active');
                
                $active_calls = $active_call;
              
                }else{
                     $active_calls[] = array('mobile_no'=>$mobile_no,
                                     'call_status'=>'active');
                }
                $this->session->set_userdata('all_calls', $active_calls);
            
                $caller = array();
                $caller["CallUniqueID"] = $unique_id;
                $caller["call_extension"] = $ext_no;
               // $caller["call_mobile"] = $mobile_no;
                $caller["call_agentid"] = $agent_id;
                //$caller["call_data"] = 'conference';
                $caller["call_message"] = $avaya_resp->message;
                $caller["call_datetime"] = date('Y-m-d H:i:s');
                $clr_id = $this->call_model->insert_softdial_details($caller);
                $data['call_data'] = $avaya_args;
                $data['active_calls'] = $this->session->userdata('all_calls');
                $data["call_type_data"] = 'conference';
                
                $this->output->add_to_position($this->load->view('frontend/avaya/connected_dialer_view', $data, TRUE), 'dialerscreen', TRUE);
                
        }else{
            
            $this->output->message = "<p> Sorry!...... Error occure</p>";
            
        }
        
       }else{
            $this->output->message = "<p> Sorry!...... Avaya Extension not found</p>";
       }
       
        
    }
    function conference_call(){
        
        $ext_no = get_cookie("avaya_extension_no");
        $agent_id = $this->session->userdata('extension_no');;
        $agent_id=$this->clg->clg_avaya_agentid;
     
        
        $mobile_no = $this->session->userdata('soft_dial_mobile');
        
         $agent_id = $this->session->userdata('avaya_extension_no');
        
       
        if(!empty($agent_id)){
        
        
        $avaya_server_url = $this->avaya_server_url.'/originatecall';
        
    
//        $avaya_args_cr = array('agentnumber' => corel_encrypt_str($agent_id),
//                'thirdpartynumber' => corel_encrypt_str($mobile_no) );
//        
         //$avaya_args_cr = array('agentnumber' =>$ext_no );
         
         
          $avaya_args_cr = array(//'ActionID'=>$unique_id,
                            'AgentID'=>$agent_id,
                            'callerextension'=>$agent_id,
                            'callernumber'=>$mobile_no);


        
        $this->session->set_userdata('dial_history', $avaya_args_cr);
        $this->session->set_userdata('call_action', 'conference');

          
        //$avaya_resp = corel_curl_post_api($avaya_server_url,$avaya_args_cr);
        
       $avaya_resp =  coral_agent_makecall($avaya_args);
              
        file_put_contents('./logs/'.date("Y-m-d").'/avaya_conf_call_resp_'.date("Y-m-d").'.log', $avaya_resp["resp"]."\r\n", FILE_APPEND);
        
        $avaya_resp = json_decode($avaya_resp["resp"]);
        $active_call = $this->session->userdata('all_calls');
              
                
                if($active_call){   

                $active_call[] = array('mobile_no'=>$mobile_no,
                                     'call_status'=>'active');
                
                $active_calls = $active_call;
              
                }else{
                     $active_calls[] = array('mobile_no'=>$mobile_no,
                                     'call_status'=>'active');
                }
                $this->session->set_userdata('all_calls', $active_calls);
        
        if($avaya_resp->status == 0){
            
                $caller = array();
                $caller["CallUniqueID"] = $unique_id;
                $caller["call_extension"] = $ext_no;
               // $caller["call_mobile"] = $mobile_no;
                $caller["call_agentid"] = $agent_id;
                //$caller["call_data"] = 'conference';
                $caller["call_message"] = $avaya_resp->message;
                $caller["call_datetime"] = date('Y-m-d H:i:s');
                $clr_id = $this->call_model->insert_softdial_details($caller);
                $data['call_data'] = $avaya_args;
                $data['active_calls'] = $this->session->userdata('all_calls');
                $data["call_type_data"] = 'merge';
                
                $this->output->add_to_position($this->load->view('frontend/avaya/connected_dialer_view', $data, TRUE), 'dialerscreen', TRUE);
                
        }else{
            
            $this->output->message = "<p> Sorry!......".$avaya_resp->message."</p>";
            
        }
        
       }else{
            $this->output->message = "<p> Sorry!...... Avaya Extension not found</p>";
       }
       
        
    }
    
    function transfter_call(){
        $avaya_password =  $this->clg->clg_avaya_passwd;
        $avaya_username =  $this->clg->clg_avaya_agentid;
        
        $ip = $_SERVER['REMOTE_ADDR'];

        $avaya_ext = $this->call_model->get_avaya_extension($ip);

        $ext_no=$avaya_ext->ext_no;
        $agent_id=$avaya_ext->agent_id;
      
        
        $ext_no = get_cookie("avaya_extension_no");
        $agent_id= $this->session->userdata('extension_no');
        $soft_dial_mobile= $this->session->userdata('soft_dial_mobile');
        $this->session->unset_userdata('conference_dial_mobile');
        $this->session->unset_userdata('dial_history');
        $this->session->set_userdata('call_action', 'disconnect');
        $this->session->unset_userdata('all_calls');
        
        $mobile_no = $this->post['mobile_no'];

       if(!empty($ext_no)){
        
        
        $avaya_server_url = $this->avaya_server_url.'/queuetransfercall';
        
        $unique_id = time();
        $avaya_args = array('ActionID'=>$unique_id,
                            'AgentID'=>$agent_id,
                            'AgentExtension'=>$ext_no,
                            'Destination'=>$mobile_no);
        
        $this->session->set_userdata('dial_history', $avaya_args);
        $this->session->set_userdata('call_action', 'transfer');
        
        $active_calls =  pbx_active_calls();
        $active_call_decode = json_decode($active_calls['resp']);
        $active_calls_data = json_decode($active_call_decode->data);
       
        $uuid = "";
        if(!empty($active_calls_data)){
            
            foreach($active_calls_data as $calls){

                if($calls->destination == $soft_dial_mobile){
                    $uuid = $calls->calleeuuid;
                    $agentextnum = $calls->extension;
                    $calleridnumber = $mobile_no;
                }

            }
        }
//        var_dump($uuid);
//         var_dump($agentextnum);
//         var_dump($calleridnumber);
        $avaya_args_cr1 = array('calleridnumber'=>($soft_dial_mobile),
            'uuid' => ($uuid),
            'agentextnum'=>($agentextnum),
            'transfernumber' => ($calleridnumber)
                );
//        var_dump($active_calls_data);
//       die();
        
        
        $avaya_args_cr = array('calleridnumber'=>corel_encrypt_str($soft_dial_mobile),
            'uuid' => corel_encrypt_str($uuid),
            'agentextnum'=>corel_encrypt_str($agentextnum),
            'transfernumber' => corel_encrypt_str($calleridnumber)
                );
        $avaya_data = json_encode($avaya_args);
       
        
        
        $avaya_resp_r =  corel_curl_post_api($avaya_server_url,$avaya_args_cr);
//         var_dump($avaya_args_cr);
//         var_dump($avaya_resp_r);
//         die();
       
        
        $avaya_resp = json_decode($avaya_resp_r["resp"]);
        // var_dump($avaya_resp);
        
         file_put_contents('./logs/transfer/avaya_call_transfer_'.date("Y-m-d").'.log', $avaya_resp_r["resp"]."\r\n", FILE_APPEND);
        
        if($avaya_resp->status == 0){
            
                $caller = array();
               // $caller["call_id"] = $unique_id;
                $caller["call_extension"] = $ext_no;
                $caller["call_mobile"] = $mobile_no;
                $caller["call_agentid"] = $agent_id;
                //$caller["call_type_data"] = 'transfer';
                $caller["call_message"] = $avaya_resp->message;
                $caller["call_datetime"] = date('Y-m-d H:i:s');
                $clr_id = $this->call_model->insert_softdial_details($caller);
                $data['call_data'] = $avaya_args;
                $this->output->message = "<p> Trasfer call successfully</p>";
                $this->output->add_to_position('', 'dialerscreen', TRUE);
                $data["call_type_data"] = 'transfer';
               // $this->output->add_to_position($this->load->view('frontend/avaya/connected_dialer_view', $data, TRUE), 'dialerscreen', TRUE);
                
        }else{
            $this->output->message = "<p> Sorry!...... Error occure ".$avaya_resp->message."</p>";
        }
        
       }else{
            $this->output->message = "<p> Sorry!...... Avaya Extension not found</p>";
       }
    }
    
    function hold_call(){

        if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
        }
    
        $ext_no = get_cookie("avaya_extension_no");
        $agent_id = $this->clg->clg_avaya_agentid;
        //$agent_id = 5001;
          //$agent_id = $this->session->userdata('extension_no');;

        $dial_history = $this->session->userdata('dial_history');


       if(!empty($agent_id)){
        
        
        $avaya_server_url = $this->corel_server_url.'/holdcall';
        
        
        $this->session->set_userdata('hold_dial_history', $avaya_args);
        $this->session->set_userdata('call_action', 'hold');
        
        $hold_avaya_server_url = $this->avaya_server_url.'/callcenterholdcall';
        
        
        $this->session->set_userdata('dial_history', $avaya_args_cr);
        $this->session->set_userdata('call_action', 'holdcall');

        $avaya_args_cr1 = array('agentnumber' => corel_encrypt_str($agent_id));
        $avaya_args_cr1 = array('agentnumber' => $ext_no);
       
        $hold_avaya_resp =  corel_curl_post_api($hold_avaya_server_url,$avaya_args_cr1);
       

        //$avaya_args_cr = array('uuid' => corel_encrypt_str('c3c4c97f-7a51-4306-a568-f581cc09dba0'));
        
//        $active_calls =  pbx_active_calls();
//       
//        $active_call_decode = json_decode($active_calls['resp']);
//        $active_calls_data = json_decode($active_call_decode->data);
//        //var_dump($active_calls_data);
//       // die();
//        if($active_calls_data){
//            foreach($active_calls_data as $calls){
//                if($calls->extension == $agent_id){
//                    $uuid = $calls->uuid;
//                }
//            }
//        }
//       // $avaya_args_cr = array('uuid' => corel_encrypt_str($uuid));
//       // $avaya_resp =  corel_curl_post_api($avaya_server_url,$avaya_args_cr);
        $avaya_resp_en = json_encode($avaya_resp["resp"]);
        file_put_contents('./logs/'.date("Y-m-d").'avaya_holdcall_log.log', $avaya_resp_en.",\r\n", FILE_APPEND);
        
        $active_calls = $this->session->userdata('all_calls');
       if($active_calls){
           foreach($active_calls as $activ){
              $activ['call_status'] = 'call_hold';
              $up_active_calls[]=$activ;
           }
       }
        
        
       
       //if($avaya_resp){
            
            $caller = array();
            ///$caller["call_id"] = $unique_id;
           // $caller["call_mobile"] = $dial_history['DialNo'];
            $caller["call_extension"] = $ext_no;
            $caller["call_agentid"] = $agent_id;
            //$caller["call_data"] = 'hold';
            $caller["call_message"] = $avaya_resp->message;
            $caller["call_datetime"] = date('Y-m-d H:i:s');
            $clr_id = $this->call_model->insert_softdial_details($caller);
            $this->session->set_userdata('all_calls', $up_active_calls);
            $data['active_calls']=$up_active_calls;
            
            $data["call_type_data"] = 'hold';
          
          //  $data['call_data'] = $avaya_args;
            
            //$this->output->message = "<p>Call Hold successfully</p>";
            $this->output->add_to_position($this->load->view('frontend/avaya/connected_dialer_view', $data, TRUE), 'dialerscreen', TRUE);
                
       // }else{
       //     $this->output->message = "<p> Sorry!...... Error occure</p>";
       // }
        
       }else{
            $this->output->message = "<p> Sorry!...... Avaya Extension not found</p>";
       }
    }
   
    function unhold_call(){
        $avaya_password =  $this->clg->clg_avaya_passwd;
        $avaya_username =  $this->clg->clg_avaya_agentid;
        
        $ip = $_SERVER['REMOTE_ADDR'];

        $avaya_ext = $this->call_model->get_avaya_extension($ip);

        $ext_no=$avaya_ext->ext_no;
       // $agent_id=$avaya_ext->agent_id;
        
        $ext_no = get_cookie("avaya_extension_no");
        $agent_id=$this->clg->clg_avaya_agentid;
        //$agent_id = 5001;
     

        $dial_history = $this->session->userdata('dial_history');
        


       if(!empty($ext_no)){
        
       
        //$avaya_server_url = $this->corel_server_url.'/unholdcall';
        $avaya_server_url = $this->corel_server_url.'/callcenterunholdcall';
        
        
        
        $unique_id = time();
        $avaya_args = array('ActionID'=>$unique_id,
                            'AgentID'=>$agent_id,
                            'AgentExtension'=>$ext_no);
        
        $this->session->set_userdata('hold_dial_history', $avaya_args);
        $this->session->set_userdata('call_action', 'hold');
        
        $active_calls = $this->session->userdata('all_calls');
        if($active_calls){
           foreach($active_calls as $activ){
              $activ['call_status'] = 'active';
              $up_active_calls[]=$activ;
           }
        }
       
       // $avaya_data = json_encode($avaya_args);
        //$avaya_resp =  cct_agent_holdcall($avaya_server_url,$avaya_data);
//        $active_calls =  pbx_active_calls();
//       
//        $active_call_decode = json_decode($active_calls['resp']);
//        $active_calls_data = json_decode($active_call_decode->data);
//
//        foreach($active_calls_data as $calls){
//            if($calls->extension == $agent_id){
//                $uuid = $calls->uuid;
//            }
//        }
       // var_dump($uuid);
     // die();
       // $avaya_args_cr = array('uuid' => corel_encrypt_str($uuid));
        $avaya_args_en = array('agentnumber' => $ext_no);
        $avaya_resp =  corel_curl_post_api($avaya_server_url,$avaya_args_en);
        
        $avaya_resp_en = json_encode($avaya_resp["resp"]);
        file_put_contents('./logs/'.date("Y-m-d").'avaya_holdcall_log.log', $avaya_resp_en.",\r\n", FILE_APPEND);
        
        $avaya_resp = json_decode($avaya_resp["resp"]);
        $active_calls = $this->session->userdata('all_calls');
        
        if($active_calls){
           foreach($active_calls as $activ){
              $activ['call_status'] = 'active';
              $up_active_calls=$activ;
           }
        }
                
       // if($avaya_resp){
            
            $caller = array();
            $caller["call_id"] = $unique_id;
            $caller["call_mobile"] = $dial_history['DialNo'];
            $caller["call_extension"] = $ext_no;
            $caller["call_agentid"] = $agent_id;
            $caller["call_data"] = 'unhold';
            $caller["call_message"] = $avaya_resp->ResMessage;
            $caller["call_datetime"] = date('Y-m-d H:i:s');
            $clr_id = $this->call_model->insert_softdial_details($caller);
            
            
            $this->session->set_userdata('all_calls', $up_active_calls);
            $data['active_calls']=$up_active_calls;
            
            $data["call_type_data"] = 'unhold';
          //  $data['call_data'] = $avaya_args;
            
//            $this->output->message = "<p>Call Hold successfully</p>";
            $this->output->add_to_position($this->load->view('frontend/avaya/connected_dialer_view', $data, TRUE), 'dialerscreen', TRUE);
                
      //  }else{
      //      $this->output->message = "<p> Sorry!...... Error occure</p>";
     //   }
        
       }else{
            $this->output->message = "<p> Sorry!...... Avaya Extension not found</p>";
       }
    }
    
    function  merge_call(){
        
    }
	function record_action_status(){
        
        $php_input =  file_get_contents( 'php://input' );       
        $post = json_decode( $php_input,true);
        $avaya_server_url = $this->avaya_server_url . '/SetAgentAction';
      
        //$file_data = file_get_contents('avaya_call_action.txt');
        file_put_contents('./logs/avaya_call_action_status_'.date("Y-m-d").'.log', $php_input."\r\n", FILE_APPEND);
		
        if($post['ActionID'] != ''){

			 $avaya_data = array(
				'action_id' => $post['ActionID'],
				'response' => $php_input,
				'action_datetime' => date('Y-m-d H:i:s')
			);
             
            $clg_group = array(
                'ActionID' => $post['ActionID'],
            );

           
             
            if($call_res[0]->ResponseCode == -1 || $call_res[0]->ResponseCode == '-1'){
                $call_res = $this->call_model->get_avaya_action_summary($clg_group);
                //$avaya_res = cct_agent_action($avaya_server_url, $call_res[0]->action_data,$post['ActionID']);
            }

            $avaya_ext = $this->call_model->insert_avaya_action($avaya_data);
                 
        }
        echo $avaya_ext;
        die();
   }
     function avaya_call_recveing(){
       
        $php_input =  file_get_contents( 'php://input' );
        $post = json_decode( $php_input,true);
        
        if(json_last_error()){ 
            echo json_encode(array('status'=>'fail','message'=>"Wrong json data!"));
            die();  
        }
       
        $agent = $post['CallingDevice'];
        file_put_contents('./logs/avaya_calls/'.$agent.'.json', $php_input);
        
        $post['log_time'] = date('Y-m-d H:i:s');
		$post_encode = json_encode($post);
        
        if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
        }
       
        //file_put_contents('./logs/'.date("Y-m-d").'/all_avaya_call_records.log', $post_encode."\r\n", FILE_APPEND);
		file_put_contents('./logs/'.date("Y-m-d").'/'.$post['CallingDevice'].'_audio_call_records.log', $post_encode.",\r\n", FILE_APPEND);
       
         
        $current_time = strtotime(date('Y-m-d H:i:s')); 
        $avaya_data = array(
           'calling_phone_no' => $post['CalledDevice'],
           'CallUniqueID'=>$post['CallUniqueID'],
           'agent_no' => $post['CallingDevice'],
           'message' => $post['CallStateDesc'],
           'status' => $post['CallState'],
           //'call_datetime' => date('Y-m-d H:i:s'),
           'is_deleted' => '0');
       
        if(($post['CallState'] == "R")){
            
            //file_put_contents('./logs/'.date("Y-m-d").'/debug.log', "hello2 \r\n", FILE_APPEND);
            $avaya_data['call_rinning_datetime'] = date('Y-m-d').' '.$post['CallTime'];;
            $avaya_data['avaya_call_time'] = $post['CallTime'];
			$avaya_data['call_datetime'] = date('Y-m-d H:i:s');
            $avaya_ext = $this->call_model->insert_avaya_incoming_call($avaya_data);
            
     
        }else{
               
            if($post['Param1'] != ''){
                $avaya_data['call_audio'] = $post['Param1'];
            }
            
            $avaya_data['dis_conn_massage'] = $post['CallStateDesc'];
            
            if($post['CallState'] == "D"){
                $avaya_data['call_disconnect_datetime'] = date('Y-m-d').' '.$post['CallTime'];
            }else if($post['CallState'] == "C"){
                $avaya_data['call_connect_datetime'] = date('Y-m-d').' '.$post['CallTime'];
            }
           
            
            $avaya_call = $this->call_model->update_avaya_call_by_calluniqueid($avaya_data);   
            //$avaya_call = $this->corona_model->update_avaya_call_by_calluniqueid($avaya_data);   
        } 
        
        if($post['CallState'] == "D" && $post['CallUniqueID'] != ""){

            
            $inc_avaya_data = array('inc_avaya_uniqueid'=>$post['CallUniqueID']);
            if($post['Param1'] != ''){
                $inc_avaya_data['inc_audio_file']=$post['Param1'];
            }
            $avaya_call = $this->inc_model->update_incident_by_avayaid($inc_avaya_data);
            

        }
        
        echo json_encode(array('status'=>'success','message'=>"Call receive successfully!"));
        die();
        
    }
  function avaya_disconnected_call_receiving(){
       
        $php_input =  file_get_contents( 'php://input' );
        $post = json_decode( $php_input,true);
        
        if(json_last_error()){ 
            echo json_encode(array('status'=>'fail','message'=>"Wrong json data!"));
            die();  
        }


        $avaya_data = array(
           'calling_phone_no' => $post['CalledDevice'],
           'CallUniqueID'=>$post['CallUniqueID'],
           'agent_no' => $post['CallingDevice'],
           'message' => $post['CallStateDesc'],
           'status' => $post['CallState'],
           //'call_datetime' => date('Y-m-d H:i:s'),
           'is_deleted' => '0');
       
       
        if(($post['CallState'] == "D")){

               
            if($post['Param1'] != ''){
                $avaya_data['call_audio'] = $post['Param1'];
            }
            
            $avaya_data['dis_conn_massage'] = $post['CallStateDesc'];
            
            if($post['CallState'] == "D"){
                $avaya_data['call_disconnect_datetime'] = date('Y-m-d').' '.$post['CallTime'];
            }
           
            
            $avaya_call = $this->call_model->update_avaya_call_by_calluniqueid($avaya_data);   
            //$avaya_call = $this->corona_model->update_avaya_call_by_calluniqueid($avaya_data);   
        } 
        
        if($post['CallState'] == "D" && $post['CallUniqueID'] != ""){

            
            $inc_avaya_data = array('inc_avaya_uniqueid'=>$post['CallUniqueID']);
            if($post['Param1'] != ''){
                $inc_avaya_data['inc_audio_file']=$post['Param1'];
            }
            //$avaya_call = $this->inc_model->update_incident_by_avayaid($inc_avaya_data);
            

        }
        
        echo json_encode(array('status'=>'success','message'=>"Audio File successfully!"));
        die();
        
    }
    
    function call_recveing_avaya(){
       
        $php_input =  file_get_contents( 'php://input' );
        $post = json_decode( $php_input,true);
        
        if(json_last_error()){ 
            echo json_encode(array('status'=>'fail','message'=>"Wrong json data!"));
            die();  
        }
       
        $agent = $post['CallingDevice'];
        file_put_contents('./logs/avaya_calls/'.$agent.'.json', $php_input);
        
        $post['log_time'] = date('Y-m-d H:i:s');
		$post_encode = json_encode($post);
        
        if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
        }
       
        //file_put_contents('./logs/'.date("Y-m-d").'/all_avaya_call_records.log', $post_encode."\r\n", FILE_APPEND);
		file_put_contents('./logs/'.date("Y-m-d").'/'.$post['CallingDevice'].'_audio_call_records.log', $post_encode.",\r\n", FILE_APPEND);
       
         
        $current_time = strtotime(date('Y-m-d H:i:s')); 
        $avaya_data = array(
           'calling_phone_no' => $post['CalledDevice'],
           'CallUniqueID'=>$post['CallUniqueID'],
           'agent_no' => $post['CallingDevice'],
           'message' => $post['CallStateDesc'],
           'status' => $post['CallState'],
           //'call_datetime' => date('Y-m-d H:i:s'),
           'is_deleted' => '0');
       
        if(($post['CallState'] == "R")){
            
            //file_put_contents('./logs/'.date("Y-m-d").'/debug.log', "hello2 \r\n", FILE_APPEND);
            $avaya_data['call_rinning_datetime'] = date('Y-m-d').' '.$post['CallTime'];;
            $avaya_data['avaya_call_time'] = $post['CallTime'];
			$avaya_data['call_datetime'] = date('Y-m-d H:i:s');
            $avaya_ext = $this->call_model->insert_avaya_incoming_call($avaya_data);
            
     
        }else{
               
            if($post['Param1'] != ''){
                $avaya_data['call_audio'] = $post['Param1'];
            }
            
            $avaya_data['dis_conn_massage'] = $post['CallStateDesc'];
            
            if($post['CallState'] == "D"){
                $avaya_data['call_disconnect_datetime'] = date('Y-m-d').' '.$post['CallTime'];
            }else if($post['CallState'] == "C"){
                $avaya_data['call_connect_datetime'] = date('Y-m-d').' '.$post['CallTime'];
            }
           
            
            $avaya_call = $this->call_model->update_avaya_call_by_calluniqueid($avaya_data);   
            //$avaya_call = $this->corona_model->update_avaya_call_by_calluniqueid($avaya_data);   
        } 
        
        if($post['CallState'] == "D" && $post['CallUniqueID'] != ""){

            
            $inc_avaya_data = array('inc_avaya_uniqueid'=>$post['CallUniqueID']);
            if($post['Param1'] != ''){
                $inc_avaya_data['inc_audio_file']=$post['Param1'];
            }
            $avaya_call = $this->inc_model->update_incident_by_avayaid($inc_avaya_data);
            

        }
        
        echo json_encode(array('status'=>'success','message'=>"Call receive successfully!"));
        die();
        
    }
    
    function disconnected_call_receiving_avaya(){
       
        $php_input =  file_get_contents( 'php://input' );
        $post = json_decode( $php_input,true);
        
        if(json_last_error()){ 
            echo json_encode(array('status'=>'fail','message'=>"Wrong json data!"));
            die();  
        }


        $avaya_data = array(
           'calling_phone_no' => $post['CalledDevice'],
           'CallUniqueID'=>$post['CallUniqueID'],
           'agent_no' => $post['CallingDevice'],
           'message' => $post['CallStateDesc'],
           'status' => $post['CallState'],
           //'call_datetime' => date('Y-m-d H:i:s'),
           'is_deleted' => '0');
       
       
        if(($post['CallState'] == "D")){

               
            if($post['Param1'] != ''){
                $avaya_data['call_audio'] = $post['Param1'];
            }
            
            $avaya_data['dis_conn_massage'] = $post['CallStateDesc'];
            
            if($post['CallState'] == "D"){
                $avaya_data['call_disconnect_datetime'] = date('Y-m-d').' '.$post['CallTime'];
            }
           
            
            $avaya_call = $this->call_model->update_avaya_call_by_calluniqueid($avaya_data);   
            //$avaya_call = $this->corona_model->update_avaya_call_by_calluniqueid($avaya_data);   
        } 
        
        if($post['CallState'] == "D" && $post['CallUniqueID'] != ""){

            
            $inc_avaya_data = array('inc_avaya_uniqueid'=>$post['CallUniqueID']);
            if($post['Param1'] != ''){
                $inc_avaya_data['inc_audio_file']=$post['Param1'];
            }
            //$avaya_call = $this->inc_model->update_incident_by_avayaid($inc_avaya_data);
            

        }
        
        echo json_encode(array('status'=>'success','message'=>"Audio File successfully!"));
        die();
        
    }
}