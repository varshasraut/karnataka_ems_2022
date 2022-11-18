<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Avaya_Api extends EMS_Controller {
    
    function __construct() {

        parent::__construct();

        $this->active_module = "M-API";
        $this->pg_limit = $this->config->item('pagination_limit');

        $this->gps_url = $this->config->item('amb_gps_url');

        $this->bvgtoken = $this->config->item('bvgtoken');
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper','cct_helper'));
        $this->load->model(array('options_model', 'module_model', 'common_model','call_model','inc_model','corona_model','colleagues_model'));
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
           
        $ext_no = get_cookie("avaya_extension_no");
        $agent_id=$this->clg->clg_avaya_agentid;
        
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
        $this->session->set_userdata('soft_dial_mobile', $mobile_no);
       
        
        $avaya_data = json_encode($avaya_args);
        
	
        $avaya_resp =  cct_agent_makecall($avaya_server_url,$avaya_data);
        $avaya_resp = json_decode($avaya_resp["resp"]);
        
        //if($avaya_resp){
            
                $caller = array();
                $caller["CallUniqueID"] = $unique_id;
                $caller["call_extension"] = $ext_no;
                $caller["call_mobile"] = $mobile_no;
                $caller["call_agentid"] = $agent_id;
               // $caller["call_data"] = 'dialing';
                //$caller["call_message"] = $avaya_resp->ResMessage;
                $caller["call_datetime"] = date('Y-m-d H:i:s');
                $clr_id = $this->call_model->insert_softdial_details($caller);
                $data['call_data'] = $avaya_args;
                $data["call_type_data"] = 'dialing';
                
                $this->output->add_to_position($this->load->view('frontend/avaya/avaya_connected_dialer_view', $data, TRUE), 'dialerscreen', TRUE);
                
//        }else{
//            $this->output->message = "<p> Sorry!...... Error occure</p>";
//        }
        
       }else{
            $this->output->message = "<p> Sorry!...... Avaya Extension not found</p>";
       }
        
    }
    function hd_soft_dial(){
        
      
        $ext_no = get_cookie("avaya_extension_no");
        $agent_id=$this->clg->clg_avaya_agentid;
        
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
//                 $this->output->message = "<p> Call Connected .....</p>";
//                  $this->output->status = 0;
//                 $this->output->closepopup = 'no';
         
                
       }else{
//            $this->output->message = "<p> Sorry!...... Error occure</p>";
//             $this->output->status = 0;
//            $this->output->closepopup = 'no';
       }
        
       }else{
//            $this->output->message = "<p> Sorry!...... Avaya Extension not found</p>";
//             $this->output->status = 0;
//            $this->output->closepopup = 'no';
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
                
                $data["call_type_data"] = 'disconnect';
                //<script>$AVAYA_INCOMING_CALL_FLAG = 0;
                
                $this->output->add_to_position('', 'dialerscreen', TRUE);
                

        
        
    }
    
    function soft_dial_disconnect(){
        
        $post = $this->input->post();
     
        if($post['ActionID'] != ''){
    
            if(!empty($post['AgentID'])){
                      
                $avaya_server_url = $this->avaya_server_url.'/HangupCall';
        
                $avaya_args = array('ActionID'=>$post['ActionID'],
                                    'AgentID'=>$post['AgentID'],
                                    'AgentExtension'=>$post['AgentExtension']);

                $avaya_data = json_encode($avaya_args);
                $avaya_resp =  cct_agent_disconnectcall($avaya_server_url,$avaya_data);

                $avaya_resp = json_decode($avaya_resp["resp"]);
                
                $this->session->unset_userdata('dial_history');
                $this->session->set_userdata('call_action', 'disconnect');
                

                $caller = array();
                $caller = array();
                //$caller["call_id"] = $post['ActionID'];
                $caller["call_agentid"] = $post['AgentID'];
                $caller["call_extension"] = $post['AgentExtension'];
                //$caller["call_data"] = 'disconnect';
                $caller["call_message"] = 'Disconnect Successfully';
                $caller["call_datetime"] = date('Y-m-d H:i:s');
                

                $clr_id = $this->call_model->insert_softdial_details($caller);
                $data["call_type_data"] = 'disconnect';
                //$this->output->add_to_position('', 'dialerscreen', TRUE);
                $this->output->add_to_position($this->load->view('frontend/avaya/avaya_dialer_view', $data, TRUE), 'dialerscreen', TRUE);
                

            }else{
                echo "Insuffient data";
                die();
            }
        }
        
    }
    function call_recveing_test(){
       
        $php_input =  file_get_contents( 'php://input' );
        $php_input = '{"CallDate":"20200805","CallTime":"00:32:02","Device":"1117","DeviceID":"1117","CallUniqueID":"20200805155844","CallState":"B","CallStateDesc":"Dialing","CallType":"O","CallSubType":"T","CallingDevice":"1117","CalledDevice":"1117","Param1":"","Param2":"N","Param3":"","Param4":"","Param5":"","log_time":"2020-08-05 00:29:19"}';
        $post = json_decode( $php_input,true);
        
        if(json_last_error()){ return false; }
       
        $agent = $post['CallingDevice'];
        file_put_contents('./logs/avaya_calls/'.$agent.'.json', $php_input);
        
        $post['log_time'] = date('Y-m-d H:i:s');
		$post_encode = json_encode($post);
        
        if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
        }
        //file_put_contents('./logs/'.date("Y-m-d").'/all_avaya_call_records.log', $post_encode."\r\n", FILE_APPEND);
		//file_put_contents('./logs/'.date("Y-m-d").'/'.$post['CallingDevice'].'_avaya_call_records.log', $post_encode.",\r\n", FILE_APPEND);
        
         
        $current_time = strtotime(date('Y-m-d H:i:s')); 
        $avaya_data = array(
           'calling_phone_no' => $post['CalledDevice'],
           'CallUniqueID'=>$post['CallUniqueID'],
           'agent_no' => $post['CallingDevice'],
           'message' => $post['CallStateDesc'],
           'status' => $post['CallState'],
           //'call_datetime' => date('Y-m-d H:i:s'),
           'is_deleted' => '0');
       
        if(($post['CallState'] == "R" || $post['CallState'] == "B")){
            
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
            $avaya_call = $this->corona_model->update_avaya_call_by_calluniqueid($avaya_data);   
        } 
        
        if($post['CallState'] == "D" && $post['CallUniqueID'] != ""){

            
            $inc_avaya_data = array('inc_avaya_uniqueid'=>$post['CallUniqueID']);
            if($post['Param1'] != ''){
                $inc_avaya_data['inc_audio_file']=$post['Param1'];
            }
            $avaya_call = $this->inc_model->update_incident_by_avayaid($inc_avaya_data);
            

        }
        
        $post['status'] = "success";
        echo json_encode($post);
        die();
        
    }
  function call_recveing(){
       
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
		//file_put_contents('./logs/'.date("Y-m-d").'/'.$post['CallingDevice'].'_audio_call_record.log', $post_encode.",\r\n", FILE_APPEND);
       
         
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
  function disconnected_call_receiving(){
       
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
       
        
		//file_put_contents('./logs/avaya_conf_call_resp_'.date("Y-m-d").'.log', $php_input."\r\n", FILE_APPEND);
        
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

    function conference_call(){
        
        $ext_no = get_cookie("avaya_extension_no");
        $agent_id=$this->clg->clg_avaya_agentid;
        
        $mobile_no = $this->post['mobile_no'];
       
        if(!empty($ext_no)){
        
        
       // $avaya_server_url = $this->avaya_server_url.'/ConferenceCall';
        $avaya_server_url = $this->avaya_server_url.'/MakeCall';
        
        $unique_id = time();
        $avaya_args = array('ActionID'=>$unique_id,
                            'AgentID'=>$agent_id,
                            'AgentExtension'=>$ext_no,
                            'Destination'=>$mobile_no);
        
        $this->session->set_userdata('dial_history', $avaya_args);
        $this->session->set_userdata('call_action', 'conference');
       
        
        $avaya_data = json_encode($avaya_args);
        $avaya_resp =  cct_agent_makecall($avaya_server_url,$avaya_data);
        $avaya_resp = json_decode($avaya_resp["resp"]);
     
        
        if($avaya_resp){
            
                $caller = array();
                $caller["CallUniqueID"] = $unique_id;
                $caller["call_extension"] = $ext_no;
               // $caller["call_mobile"] = $mobile_no;
                $caller["call_agentid"] = $agent_id;
                //$caller["call_data"] = 'conference';
                $caller["call_message"] = $avaya_resp->ResMessage;
                $caller["call_datetime"] = date('Y-m-d H:i:s');
                $clr_id = $this->call_model->insert_softdial_details($caller);
                $data['call_data'] = $avaya_args;
                $data["call_type_data"] = 'conference';
                  $this->output->add_to_position($this->load->view('frontend/avaya/avaya_connected_dialer_view', $data, TRUE), 'dialerscreen', TRUE);
                
               
                
        }else{
            $this->output->message = "<p> Sorry!...... Error occure</p>";
        }
        
       }else{
            $this->output->message = "<p> Sorry!...... Avaya Extension not found</p>";
       }
       
        
    }
        function make_transfter_call(){
        
        $ext_no = get_cookie("avaya_extension_no");
        $agent_id=$this->clg->clg_avaya_agentid;
        
        $mobile_no = $this->post['mobile_no'];

       if(!empty($ext_no)){
                 
        //$avaya_server_url = $this->avaya_server_url.'/TransferCall';
        $avaya_server_url = $this->avaya_server_url.'/MakeCall';
        
        $unique_id = time();
        $avaya_args = array('ActionID'=>$unique_id,
                            'AgentID'=>$agent_id,
                            'AgentExtension'=>$ext_no,
                            'Destination'=>$mobile_no);
        
        $this->session->set_userdata('dial_history', $avaya_args);
        $this->session->set_userdata('call_action', 'transfer');
       
        
        $avaya_data = json_encode($avaya_args);
         //file_put_contents('./logs/transfer/avaya_call_transfer_'.date("Y-m-d").'.log', $avaya_data."\r\n", FILE_APPEND);
        $avaya_resp =  cct_agent_tranfercall($avaya_server_url,$avaya_data);
              
        $avaya_resp = json_decode($avaya_resp["resp"]);
        
        if($avaya_resp){
            
                $caller = array();
               // $caller["call_id"] = $unique_id;
                $caller["call_extension"] = $ext_no;
                $caller["call_mobile"] = $mobile_no;
                $caller["call_agentid"] = $agent_id;
                //$caller["call_type_data"] = 'transfer';
                $caller["call_message"] = $avaya_resp->ResMessage;
                $caller["call_datetime"] = date('Y-m-d H:i:s');
                $clr_id = $this->call_model->insert_softdial_details($caller);
                $data['call_data'] = $avaya_args;
               // $this->output->message = "<p> Trasfer call successfully</p>";
                //$this->output->add_to_position('', 'dialerscreen', TRUE);
                $data["call_type_data"] = 'transfer';
               // $this->output->add_to_position($this->load->view('frontend/avaya/avaya_connected_dialer_view', $data, TRUE), 'dialerscreen', TRUE);
                
        }else{
            $this->output->message = "<p> Sorry!...... Error occure</p>";
        }
        
       }else{
            $this->output->message = "<p> Sorry!...... Avaya Extension not found</p>";
       }
    }
    function transfter_call(){
        
        $ext_no = get_cookie("avaya_extension_no");
        $agent_id=$this->clg->clg_avaya_agentid;
        
        $mobile_no = $this->post['mobile_no'];

       if(!empty($ext_no)){
                 
        $avaya_server_url = $this->avaya_server_url.'/TransferCall';
       // $avaya_server_url = $this->avaya_server_url.'/MakeCall';
        
        $unique_id = time();
        $avaya_args = array('ActionID'=>$unique_id,
                            'AgentID'=>$agent_id,
                            'AgentExtension'=>$ext_no,
                            'Destination'=>$mobile_no);
        
        $this->session->set_userdata('dial_history', $avaya_args);
        $this->session->set_userdata('call_action', 'transfer');
       
        
        $avaya_data = json_encode($avaya_args);
         //file_put_contents('./logs/transfer/avaya_call_transfer_'.date("Y-m-d").'.log', $avaya_data."\r\n", FILE_APPEND);
        $avaya_resp =  cct_agent_tranfercall($avaya_server_url,$avaya_data);
              
        $avaya_resp = json_decode($avaya_resp["resp"]);
        
        if($avaya_resp){
            
                $caller = array();
               // $caller["call_id"] = $unique_id;
                $caller["call_extension"] = $ext_no;
                $caller["call_mobile"] = $mobile_no;
                $caller["call_agentid"] = $agent_id;
                //$caller["call_type_data"] = 'transfer';
                $caller["call_message"] = $avaya_resp->ResMessage;
                $caller["call_datetime"] = date('Y-m-d H:i:s');
                $clr_id = $this->call_model->insert_softdial_details($caller);
                $data['call_data'] = $avaya_args;
                $this->output->message = "<p> Trasfer call successfully</p>";
                $this->output->add_to_position('', 'dialerscreen', TRUE);
                $data["call_type_data"] = 'transfer';
               // $this->output->add_to_position($this->load->view('frontend/avaya/avaya_connected_dialer_view', $data, TRUE), 'dialerscreen', TRUE);
                
        }else{
            $this->output->message = "<p> Sorry!...... Error occure</p>";
        }
        
       }else{
            $this->output->message = "<p> Sorry!...... Avaya Extension not found</p>";
       }
    }
    
    function hold_call(){
      
        $ext_no = get_cookie("avaya_extension_no");
        $agent_id=$this->clg->clg_avaya_agentid;

        $dial_history = $this->session->userdata('dial_history');


       if(!empty($ext_no)){
        
        
        $avaya_server_url = $this->avaya_server_url.'/HoldCall';
        
        $unique_id = time();
        $avaya_args = array('ActionID'=>$unique_id,
                            'AgentID'=>$agent_id,
                            'AgentExtension'=>$ext_no);
        
        $this->session->set_userdata('hold_dial_history', $avaya_args);
        $this->session->set_userdata('call_action', 'hold');
       
        $avaya_data = json_encode($avaya_args);
        $avaya_resp =  cct_agent_holdcall($avaya_server_url,$avaya_data);
        $avaya_resp = json_decode($avaya_resp["resp"]);
        
        if($avaya_resp){
            
            $caller = array();
            ///$caller["call_id"] = $unique_id;
           // $caller["call_mobile"] = $dial_history['DialNo'];
            $caller["call_extension"] = $ext_no;
            $caller["call_agentid"] = $agent_id;
            //$caller["call_data"] = 'hold';
            $caller["call_message"] = $avaya_resp->ResMessage;
            $caller["call_datetime"] = date('Y-m-d H:i:s');
            $clr_id = $this->call_model->insert_softdial_details($caller);
            
            $data["call_type_data"] = 'hold';
          //  $data['call_data'] = $avaya_args;
            
            $this->output->message = "<p>Call Hold successfully</p>";
           // $this->output->add_to_position($this->load->view('frontend/avaya/avaya_connected_dialer_view', $data, TRUE), 'dialerscreen', TRUE);
                
        }else{
            $this->output->message = "<p> Sorry!...... Error occure</p>";
        }
        
       }else{
            $this->output->message = "<p> Sorry!...... Avaya Extension not found</p>";
       }
    }
   
    function unhold_call(){
        
        $ext_no = get_cookie("avaya_extension_no");
        $agent_id=$this->clg->clg_avaya_agentid;
     

        $dial_history = $this->session->userdata('dial_history');


       if(!empty($ext_no)){
        
       
        $avaya_server_url = $this->avaya_server_url.'/UnholdCall';
        
        $unique_id = time();
        $avaya_args = array('ActionID'=>$unique_id,
                            'AgentID'=>$agent_id,
                            'AgentExtension'=>$ext_no);
        
        $this->session->set_userdata('hold_dial_history', $avaya_args);
        $this->session->set_userdata('call_action', 'hold');
       
        $avaya_data = json_encode($avaya_args);
        $avaya_resp =  cct_agent_holdcall($avaya_server_url,$avaya_data);
        $avaya_resp = json_decode($avaya_resp["resp"]);
        
        if($avaya_resp){
            
            $caller = array();
            $caller["call_id"] = $unique_id;
            $caller["call_mobile"] = $dial_history['DialNo'];
            $caller["call_extension"] = $ext_no;
            $caller["call_agentid"] = $agent_id;
            $caller["call_data"] = 'unhold';
            $caller["call_message"] = $avaya_resp->ResMessage;
            $caller["call_datetime"] = date('Y-m-d H:i:s');
            $clr_id = $this->call_model->insert_softdial_details($caller);
            
            $data["call_type_data"] = 'unhold';
          //  $data['call_data'] = $avaya_args;
            
            $this->output->message = "<p>Call Hold successfully</p>";
            $this->output->add_to_position($this->load->view('frontend/avaya/avaya_connected_dialer_view', $data, TRUE), 'dialerscreen', TRUE);
                
        }else{
            $this->output->message = "<p> Sorry!...... Error occure</p>";
        }
        
       }else{
            $this->output->message = "<p> Sorry!...... Avaya Extension not found</p>";
       }
    }
    
    function  merge_call(){
           $ext_no = get_cookie("avaya_extension_no");
        $agent_id=$this->clg->clg_avaya_agentid;
        
        $mobile_no = $this->post['mobile_no'];
        
       
        if(!empty($ext_no)){
        
        
        $avaya_server_url = $this->avaya_server_url.'/ConferenceCall';
        
        $unique_id = time();
        $avaya_args = array('ActionID'=>$unique_id,
                            'AgentID'=>$agent_id,
                            'AgentExtension'=>$ext_no,
                            'Destination'=>'');
        
        $this->session->set_userdata('dial_history', $avaya_args);
        $this->session->set_userdata('call_action', 'conference');
       
        
        $avaya_data = json_encode($avaya_args);
        //  var_dump($avaya_data);
        $avaya_resp =  cct_agent_makecall($avaya_server_url,$avaya_data);
        $avaya_resp = json_decode($avaya_resp["resp"]);
       // var_dump($avaya_resp);
        
        if($avaya_resp){
            
                $caller = array();
                $caller["CallUniqueID"] = $unique_id;
                $caller["call_extension"] = $ext_no;
               // $caller["call_mobile"] = $mobile_no;
                $caller["call_agentid"] = $agent_id;
                //$caller["call_data"] = 'conference';
                $caller["call_message"] = $avaya_resp->ResMessage;
                $caller["call_datetime"] = date('Y-m-d H:i:s');
                $clr_id = $this->call_model->insert_softdial_details($caller);
                $data['call_data'] = $avaya_args;
                $data["call_type_data"] = 'conference';
                $this->output->add_to_position($this->load->view('frontend/avaya/avaya_connected_dialer_view', $data, TRUE), 'dialerscreen', TRUE);
                
               
                
        }else{
            $this->output->message = "<p> Sorry!...... Error occure</p>";
        }
        
       }else{
            $this->output->message = "<p> Sorry!...... Avaya Extension not found</p>";
       }
       
    }
	function record_action_status(){
        
        $php_input =  file_get_contents( 'php://input' );       
        $post = json_decode( $php_input,true);
        $avaya_server_url = $this->avaya_server_url . '/SetAgentAction';
      
        //$file_data = file_get_contents('avaya_call_action.txt');
        //file_put_contents('./logs/avaya_call_action_status_'.date("Y-m-d").'.log', $php_input."\r\n", FILE_APPEND);
		
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
         function call_recveing_avaya(){
       
        $php_input =  file_get_contents( 'php://input' );
        $post = json_decode( $php_input,true);
        
        if(json_last_error()){ 
            echo json_encode(array('status'=>'fail','message'=>"Wrong json data!"));
            die();  
        }
       
        $agent = $post['CallingDevice'];
        if( $post['CallType'] == 'I'){
        file_put_contents('./logs/avaya_calls/'.$agent.'.json', $php_input);
        }
        
        $post['log_time'] = date('Y-m-d H:i:s');
		$post_encode = json_encode($post);
        
        if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
        }
       
        //file_put_contents('./logs/'.date("Y-m-d").'/all_avaya_call_records.log', $post_encode."\r\n", FILE_APPEND);
	//	file_put_contents('./logs/'.date("Y-m-d").'/'.$post['CallingDevice'].'_call_records.log', $post_encode.",\r\n", FILE_APPEND);
       
         
        $current_time = strtotime(date('Y-m-d H:i:s')); 
        $avaya_data = array(
           'calling_phone_no' => $post['CalledDevice'],
           'CallUniqueID'=>$post['CallUniqueID'],
           'agent_no' => $post['CallingDevice'],
           'message' => $post['CallStateDesc'],
           'status' => $post['CallState'],
           'CallType' => $post['CallType'],
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
                $avaya_data['is_connected'] = 'yes';
                $avaya_data['call_connect_datetime'] = date('Y-m-d').' '.$post['CallTime'];
            }
           
            
            $avaya_call = $this->call_model->update_avaya_call_by_calluniqueid($avaya_data);   
            //$avaya_call = $this->corona_model->update_avaya_call_by_calluniqueid($avaya_data);   
        } 
        
        if($post['CallState'] == "D" && $post['CallUniqueID'] != ""){

            
            $avaya_server_url = $this->avaya_server_url . '/SetAgentAction';

            $unique_id = $ext_no . '_' . time();
            $avaya_args = array('ActionID' => $unique_id,
                'AgentID' => $agent_id,
                'AgentExtension' => $ext_no,
                'AgentCampaign' => 201,
                'AgentAction' => 'WI',
                'AgentActionParam' => $agent_id);

            $wrp_avaya_data = json_encode($avaya_args);
            
            $exten_data = $this->colleagues_model->get_collegue_extension($agent_id);
            
           
            $wrap_in_args = array('agent_id'=>$agent_id,
                                  'extension_no'=>$exten_data[0]->clg_avaya_extension,
                                  'status' => 'WI',
                                  'wrap_time'=>date('Y-m-d H:i:s'));
            
            $this->call_model->insert_wrap_status($wrap_in_args);   
            

            if ($exten_data[0]->clg_avaya_extension != '' || $exten_data[0]->clg_avaya_extension != null) {
                $avaya_res = cct_agent_action($avaya_server_url, $wrp_avaya_data, $unique_id);
                   //file_put_contents('./logs/'.date("Y-m-d").'/'.date("Y-m-d").'avaya_wrapin_log.log', $avaya_data.",\r\n", FILE_APPEND);
            }
        
            
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
        //file_put_contents('./logs/'.date("Y-m-d").'/'.date("Y-m-d").'avaya_audio_logs.log', $php_input.",\r\n", FILE_APPEND);
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
        
        $ext_no = get_cookie("avaya_extension_no");
        $agent_id = $post['CallingDevice'] ;
        
       
         
       
        if(($post['CallState'] == "D")){
            

            $avaya_server_url = $this->avaya_server_url . '/SetAgentAction';

            $unique_id = $ext_no . '_' . time();
            $avaya_args = array('ActionID' => $unique_id,
                'AgentID' => $agent_id,
                'AgentExtension' => $ext_no,
                'AgentCampaign' => 201,
                'AgentAction' => 'WI',
                'AgentActionParam' => $agent_id);

            $wrp_avaya_data = json_encode($avaya_args);
            
            $exten_data = $this->colleagues_model->get_collegue_extension($agent_id);
            
           
            $wrap_in_args = array('agent_id'=>$agent_id,
                                  'extension_no'=>$exten_data[0]->clg_avaya_extension,
                                  'status' => 'WI',
                                  'wrap_time'=>date('Y-m-d H:i:s'));
            
            $this->call_model->insert_wrap_status($wrap_in_args);   
            

            if ($exten_data[0]->clg_avaya_extension != '' || $exten_data[0]->clg_avaya_extension != null) {
               $avaya_res = cct_agent_action($avaya_server_url, $wrp_avaya_data, $unique_id);
                  // file_put_contents('./logs/'.date("Y-m-d").'/'.date("Y-m-d").'avaya_wrapin_log.log', $avaya_data.",\r\n", FILE_APPEND);
            }
        
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
            
             //file_put_contents('./logs/'.date("Y-m-d").'/inc_'.date("Y-m-d").'avaya_audio_log.log', json_encode($inc_avaya_data).",\r\n", FILE_APPEND);
           // $avaya_call = $this->inc_model->update_incident_by_avayaid($inc_avaya_data);
            

        }
        
        echo json_encode(array('status'=>'success','message'=>"Audio File successfully!"));
        die();
        
    }
    function start_call_barging(){
      
        $ext_no = get_cookie("avaya_extension_no");
        $agent_id=$this->clg->clg_avaya_agentid;
        
        $mobile_no = $this->post['agentid'];
        $extension =$data['extension'] = $this->post['ext'];
        $clg_id =$data['clg_id'] = $this->post['clg_id'];
       
       if(!empty($ext_no)){
        
        
        $avaya_server_url = $this->avaya_server_url.'/MakeCall';
        
        $unique_id = time();
        $avaya_args = array('ActionID'=>$unique_id,
                            'AgentID'=>$agent_id,
                            'AgentExtension'=>$ext_no,
                            'Destination'=>'*6'.$extension);
					
        
        $avaya_data = json_encode($avaya_args);
	 //file_put_contents('./logs/'.date("Y-m-d").'/'.date("Y-m-d").'avaya_startbarging_args_log.log', $avaya_data.",\r\n", FILE_APPEND);
        $avaya_resp =  cct_agent_makecall($avaya_server_url,$avaya_data);
        // file_put_contents('./logs/'.date("Y-m-d").'/'.date("Y-m-d").'avaya_startbarging_log.log', $avaya_resp["resp"].",\r\n", FILE_APPEND);
       
        //$avaya_resp = json_decode($avaya_resp["resp"]);
        
        if($avaya_resp){
            
                
           
            //if($avaya_resp_en->status == 0){
                $data['avaya_agentid'] = $agent_id;
                 $data['avaya_agentid'] = $agent_id;
                $this->output->add_to_position($this->load->view('frontend/avaya/end_call_barging', $data, TRUE), 'call_barging_'.$clg_id, TRUE);
            //}else{
            //     $this->output->message = "<p>".$avaya_resp_en->message."</p>";
            //}
                
        }else{
            $this->output->message = "<p> Sorry!...... Error occure</p>";
        }
        
       }else{
            $this->output->message = "<p> Sorry!...... Avaya Extension not found</p>";
       }
    }
        public function end_call_barging(){
       
            $post = $this->input->post();
         
            $avaya_ext = get_cookie("avaya_extension_no");
            $agent_id=$this->clg->clg_avaya_agentid;
            $avaya_campaign=$this->clg->clg_avaya_campaign;
            $clg_id =$data['clg_id'] = $this->post['clg_id'];

                      
                $avaya_server_url = $this->avaya_server_url.'/HangupCall';
        
                $avaya_args = array('ActionID'=>time(),
                                    'AgentID'=>$agent_id,
                                    'AgentExtension'=>$avaya_ext,
                                     'Destination'=>1212);

                $avaya_data = json_encode($avaya_args);
                 //file_put_contents('./logs/'.date("Y-m-d").'/'.date("Y-m-d").'avaya_stopbarging_args_log.log', $avaya_data.",\r\n", FILE_APPEND);  
                $avaya_resp =  cct_agent_disconnectcall($avaya_server_url,$avaya_data);
                // file_put_contents('./logs/'.date("Y-m-d").'/'.date("Y-m-d").'avaya_stopbarging_log.log', $avaya_resp["resp"].",\r\n", FILE_APPEND);  

               // $avaya_resp = json_decode($avaya_resp["resp"]);
              
            if($avaya_resp){
               
               
                
               
                $data['avaya_agentid'] = $post['agentid'];
                $data['extension'] = $post['ext'];
                $this->output->add_to_position($this->load->view('frontend/avaya/start_call_barging', $data, TRUE), 'call_barging_'.$clg_id, TRUE);
                
            }else{
                $this->output->message = "<p> Sorry!...... No call active</p>";
               // $this->output->add_to_position($this->load->view('frontend/avaya/start_call_barging', $data, TRUE), 'call_barging', TRUE);
            }
       
   }
}