<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_v2 extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->active_module = "M-API";
        $this->pg_limit = $this->config->item('pagination_limit');
        $this->gps_url = $this->config->item('amb_gps_url');
        $this->bvgtoken = $this->config->item('bvgtoken');
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper', 'api_helper'));
        $this->load->model(array('call_model','inc_model'));
        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));
	    $this->clg = $this->session->userdata('current_user');
        $this->ameyo_server_url = $this->config->item('ameyo_server_url');
    }



    public function index($generated = false) {
        echo "This is API controller";
    }
    
    function ameyo_login(){
      
     
        $php_input =  file_get_contents( 'php://input' );

        $xml = simplexml_load_string($php_input, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
        }
        
        file_put_contents('./logs/'.date("Y-m-d").'/all_ameyo_login.log', $json."\r\n", FILE_APPEND);
        $json_decode = json_decode($json);
        
        
        

        $user_id = $json_decode->userId;
        $password = $json_decode->password;
        $session_id = time().'-'.$json_decode->userId;

        $command  = $json_decode->command;
    
        if($command == 'login'){
        
        if($user_id != '' && $password != ''){
            $clg_data = array('clg_avaya_agentid' => $user_id,
                              'clg_avaya_passwd' => $password,
                              'clg_crmsessionId' => $session_id);

            $result = $this->colleagues_model->clg_is_ameyo_user_exists($clg_data);
            if($result){
                $result = $this->colleagues_model->clg_update_details($clg_data);

                $return_data = '<response>
<status>success</status>
<message>Auth Successful</message>
<crmSessionId>'.$session_id.'</crmSessionId>
</response>';
            }else{
                $return_data = '<response>
<status>failed</status>
<message>Incorrect Password</message>
<crmSessionId></crmSessionId>
</response>';
            }
        }else{
            $return_data = '<response>
<status>failed</status>
<message>Incorrect data</message>
<crmSessionId></crmSessionId>
</response>';
        }
          file_put_contents('./logs/'.date("Y-m-d").'/all_ameyo_login_res.log', $return_data."\r\n", FILE_APPEND);
        echo $return_data; 
        die();
        }else if($command == 'logout'){
            
            $ref_id = get_cookie("username");
            $current_user_data = $this->session->userdata('current_user');
            $clg_last_login_time = $current_user_data->clg_last_login_time;
            $session_id = $current_user_data->clg_crmsessionId;


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
            $return_data = '<response>
                        <status>success</status>
                        <message>Auth Logout Successful</message>
                        <crmSessionId>'.$session_id.'</crmSessionId>
                        </response>';
        file_put_contents('./logs/'.date("Y-m-d").'/all_ameyo_login_res.log', $return_data."\r\n", FILE_APPEND);
        echo $return_data; 
        die();

        }else{
            $return_data = '<response>
        <status>failed</status>
        <message>Incorrect data</message>
        <crmSessionId></crmSessionId>
        </response>';
                
                  file_put_contents('./logs/'.date("Y-m-d").'/all_ameyo_login_res.log', $return_data."\r\n", FILE_APPEND);
                echo $return_data; 
                die();
        }
    }
    
    function ameyo_call_handler(){
               
        $user_data = $post = $this->input->get();
          
        $session_sessionId = $this->session->userdata('sessionId');
//        if($user_data['sessionId'] == $session_sessionId){
//            echo json_encode(array('status'=>'success','message'=>"Call Already Handled"));
//            die();  
//        }     
        if($user_data['sessionId'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"Session id not getting"));
            die();
        }
        if($user_data['userId'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"userId not getting"));
            die();
        }
        if($user_data['unique_id'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"unique_id not getting"));
            die();
        }
        if($user_data['call_date'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"call_date not getting"));
            die();
        }
        if($user_data['call_time'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"call_time not getting"));
            die();
        }       
//        if($user_data['callstatedesc'] == ''){
//            echo json_encode(array('status'=>'fail','message'=>"callstatedesc not getting"));
//            die();
//        }
//        if($user_data['customerId'] == ''){
//            echo json_encode(array('status'=>'fail','message'=>"customerId not getting"));
//            die();
//        }
         if($user_data['phone'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"phone not getting"));
            die();
        }
        if($user_data['callstate'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"callstate not getting"));
            die();
        }
       
        if($user_data['campaignId'] != '5' && $user_data['campaignId'] != '1' && $user_data['campaignId'] != '2' && $user_data['campaignId'] != '10' && $user_data['campaignId'] != '9' && $user_data['campaignId'] != '3'){
            
            echo json_encode(array('status'=>'success','message'=>"Call  successfully"));
            die();
            
        }
     
        
        if($user_data['sessionId'] != ''){

       
        if (!is_dir('./logs/avaya_calls')) {
            mkdir('./logs/avaya_calls', 0755, true);
        }    
        $agent = $user_data['userId'];
        $data_input = json_encode( $user_data);
     
        file_put_contents('./logs/avaya_calls/'.$agent.'.json', $data_input);
        
        $post['log_time'] = date('Y-m-d H:i:s');
		$post_encode = json_encode($user_data);
        
        
        if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
        }
       
        file_put_contents('./logs/'.date("Y-m-d").'/all_avaya_call_records.log', $post_encode."\r\n", FILE_APPEND);
		file_put_contents('./logs/'.date("Y-m-d").'/'.$post['userId'].'_call_record.log', $post_encode.",\r\n", FILE_APPEND);
       
         
        $current_time = strtotime(date('Y-m-d H:i:s')); 
        $avaya_data = array(
           'calling_phone_no' => $post['phone'],
           'CallUniqueID'=>$post['unique_id'],
           'agent_no' => $post['userId'],
           'message' => $post['callstatedesc'],
           'status' => $post['callstate'],
           //'call_datetime' => date('Y-m-d H:i:s'),
           'is_deleted' => '0');
       
            if(($post['callstate'] == "R") ){

                //file_put_contents('./logs/'.date("Y-m-d").'/debug.log', "hello2 \r\n", FILE_APPEND);
                $avaya_data['call_rinning_datetime'] = date('Y-m-d').' '.$post['call_time'];;
                $avaya_data['avaya_call_time'] = $post['call_time'];
                $avaya_data['call_datetime'] = date('Y-m-d H:i:s');
                $avaya_ext = $this->call_model->insert_avaya_incoming_call($avaya_data);


            }
        


            //echo json_encode(array('status'=>'success','message'=>"inbound Call Data successfully!"));
            //die();
         
            $this->session->set_userdata('qr_parameter','');
            $this->session->set_userdata('call_action','');
            $this->session->unset_userdata('dispose_dial');
            
            $data['qr_parameter'] = $qr_parameter  = "output_position=content&tool_code=mt_atnd_calls&m_no=".$post['phone']."&ext_no=".$post['sessionId']."&CallUniqueID=".$post['crtObjectId']."&sessionid=".$post['sessionId']."&crtObjectId=".$post['crtObjectId']."&userCrtObjectId=".$post['userCrtObjectId']."&callType=".$post['callType'];
            
            $this->session->set_userdata('qr_parameter',$qr_parameter);
            $this->session->set_userdata('call_action','C');
            $this->session->set_userdata('sessionId',$post['sessionId']);
            
            if($user_data['campaignId'] == '5' || $user_data['campaignId'] == '1' ){
            
                $this->output->add_to_position($this->load->view('frontend/avaya/ameyo_dialer_button_view', $data, TRUE), 'content', TRUE);
            
            }else if( $user_data['campaignId'] == '2' || $user_data['campaignId'] == '9' ){
                   $data['qr_parameter'] = $qr_parameter  = "output_position=content&tool_code=mt_cons_calls&m_no=".$post['phone']."&ext_no=".$post['sessionId']."&CallUniqueID=".$post['crtObjectId']."&sessionid=".$post['sessionId']."&crtObjectId=".$post['crtObjectId']."&userCrtObjectId=".$post['userCrtObjectId']."&callType=".$post['callType'];
                   
               $this->output->add_to_position($this->load->view('frontend/avaya/counseler_dialer_button_view', $data, TRUE), 'content', TRUE);
            }else if( $user_data['campaignId'] == '10'  || $user_data['campaignId'] == '3' ){
                   $data['qr_parameter'] = $qr_parameter  = "output_position=content&tool_code=mt_cons_calls&m_no=".$post['phone']."&ext_no=".$post['sessionId']."&CallUniqueID=".$post['crtObjectId']."&sessionid=".$post['sessionId']."&crtObjectId=".$post['crtObjectId']."&userCrtObjectId=".$post['userCrtObjectId']."&callType=".$post['callType'];
                   
               $this->output->add_to_position($this->load->view('frontend/avaya/ercp_dialer_button_view', $data, TRUE), 'content', TRUE);
            }
            
             
            $this->output->template = "calls";

        }else{
            echo json_encode(array('status'=>'fail','message'=>"Session id not getting"));
            die();
        }

        
    }
    
    function ameyo_incoming_call_api(){

        $user_data = $post = $this->input->get();
        
        
        if($user_data['sessionId'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"Session id not getting"));
            die();
        }
        if($user_data['userId'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"userId not getting"));
            die();
        }
        if($user_data['unique_id'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"unique_id not getting"));
            die();
        }
        if($user_data['call_date'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"call_date not getting"));
            die();
        }
        if($user_data['call_time'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"call_time not getting"));
            die();
        }
        if($user_data['callstatedesc'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"callstatedesc not getting"));
            die();
        }
//        if($user_data['customerId'] == ''){
//            echo json_encode(array('status'=>'fail','message'=>"customerId not getting"));
//            die();
//        }
         if($user_data['phone'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"phone not getting"));
            die();
        }
        if($user_data['callstate'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"callstate not getting"));
            die();
        }
        
        
        
        if($user_data['sessionId'] != '' ){

       
        if (!is_dir('./logs/avaya_calls')) {
            mkdir('./logs/avaya_calls', 0755, true);
        }    
        $agent = $user_data['userId'];
        $data_input = json_encode( $user_data);
     
        file_put_contents('./logs/avaya_calls/'.$agent.'.json', $data_input);
        
        $post['log_time'] = date('Y-m-d H:i:s');
		$post_encode = json_encode($user_data);
        
        
        if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
        }
       
        file_put_contents('./logs/'.date("Y-m-d").'/all_outbound_call_records.log', $post_encode."\r\n", FILE_APPEND);
		file_put_contents('./logs/'.date("Y-m-d").'/'.$post['userId'].'_outbound_call_record.log', $post_encode.",\r\n", FILE_APPEND);
       
         
        $current_time = strtotime(date('Y-m-d H:i:s')); 
        $avaya_data = array(
           'calling_phone_no' => $post['phone'],
           'CallUniqueID'=>$post['unique_id'],
           'agent_no' => $post['userId'],
           'message' => $post['callstatedesc'],
           'status' => $post['callstate'],
           //'call_datetime' => date('Y-m-d H:i:s'),
           'is_deleted' => '0');
       
            if(($post['callstate'] == "R")){

                //file_put_contents('./logs/'.date("Y-m-d").'/debug.log', "hello2 \r\n", FILE_APPEND);
                $avaya_data['call_rinning_datetime'] = date('Y-m-d').' '.$post['call_time'];;
                $avaya_data['avaya_call_time'] = $post['call_time'];
                $avaya_data['call_datetime'] = date('Y-m-d H:i:s');
                $avaya_ext = $this->call_model->insert_avaya_incoming_call($avaya_data);


            }else{

                if($post['param1'] != ''){
                    $avaya_data['call_audio'] = $post['Param1'];
                }

                $avaya_data['dis_conn_massage'] = $post['callstatedesc'];

                if($post['callstate'] == "D"){
                    $avaya_data['call_disconnect_datetime'] = date('Y-m-d').' '.$post['call_time'];
                }else if($post['callstate'] == "C"){
                    $avaya_data['call_connect_datetime'] = date('Y-m-d').' '.$post['call_time'];
                }


                $avaya_call = $this->call_model->update_avaya_call_by_calluniqueid($avaya_data);   
                //$avaya_call = $this->corona_model->update_avaya_call_by_calluniqueid($avaya_data);   
            } 
        
            if($post['callstate'] == "D" && $post['unique_id'] != ""){


                $inc_avaya_data = array('inc_avaya_uniqueid'=>$post['unique_id']);
                if($post['Param1'] != ''){
                    $inc_avaya_data['inc_audio_file']=$post['param1'];
                }
                $avaya_call = $this->inc_model->update_incident_by_avayaid($inc_avaya_data);


            }

            echo json_encode(array('status'=>'success','message'=>"Call successfully!"));
            die();

        }else{
            echo json_encode(array('status'=>'fail','message'=>"Session id not getting"));
            die();
        }
    }
    
    function login() {

        if(!isset($_GET['ref'])){
            $url = $this->base_url . "api_v2/login?".$_SERVER['QUERY_STRING'].'&ref=1';
            
            echo "<script>window.location='$url'</script>";
             //redirect($url, 'location');
          //  redirect('http://172.16.60.243/cookie_testing/index.php?&ref=1', 'location');
            die();
        }
        
        //echo '<iframe src="http://172.16.60.186/JAEms/calls" width="500" height="500" border="1"></iframe>';
       // var_dump($_SESSION);
        //die();
       
       $userId = $this->input->get('userid');
       $crmSessionId = $this->input->get('crmSessionId');

       // echo "hi1<br>";
        if ($crmSessionId != '') {

                      $clg_data = array('clg_avaya_agentid' => $userId,'clg_crmsessionId'=>$crmSessionId);
                      //$clg_data = array('clg_avaya_agentid' => $userId);
        $result = $this->colleagues_model->clg_is_ameyo_user($clg_data);
      
//            if($_SERVER["HTTP_HOST"] == 'irts.jaesmp.com'){
//          
//                $groups_array = array('UG-SuperAdmin','UG-Dashboard','UG-DASHBOARD-NHM','UG-Dashboard-view','UG-NHM-DASHBOARD','UG-MemsDashboard','UG-JAES-NHM-DASHBOARD','UG-JAES-DASHBOARD','UG-DM','UG-ZM','UG-IT','UG-OP-HEAD','UG-HO-JAES','UG-FleetManagement');
//
//
//                if(!in_array( $result[0]->clg_group,$groups_array)){
//                   $this->set_user_message("<div class='error'>Your not authorised user please contact administrator!!</div>", "error");
//                   redirect($this->base_url . "clg/login", 'location');
//                }
//
//            }
 //echo "hi2<br>";
            if ($result) {
                // echo "hi3<br>";
                $newDate = strtotime(" -2 minutes");
                
                $agent_id =  $result[0]->clg_avaya_agentid;
                $ref_id =$result[0]->clg_ref_id;

                set_cookie('username', $ref_id, time() + (86400 * 30));
                set_cookie('user_logged_in', 'TRUE', time() + (86400 * 30));
                                  
                    $result[0]->usr_type = "clg";

                    $this->session->set_userdata('current_user', $result[0]);
                    $this->session->set_userdata('user_default_key', $result[0]->user_default_key);
                    $this->session->set_userdata('user_logged_in', TRUE);
                    $this->session->set_userdata('username', $ref_id);
                                         
		
                    $otp = $this->mi_random_string(6);
                    $is_live_time = time();

                    $this->colleagues_model->load_otp($ref_id, $otp, $is_live_time);

                    $last_login = $result[0]->clg_last_login_time;
                    $user_group = $result[0]->clg_group;

                    $login_time_update = $this->colleagues_model->update_clg_field($ref_id, 'clg_last_login_time', $is_live_time);

                    $current_session_id = session_id();
                    
                    $session_table_update = $this->colleagues_model->update_session_fields($current_session_id, $ref_id, "clg");          
                    
                    $login_status_update = $this->colleagues_model->update_clg_field($ref_id, 'clg_is_alive_time', $is_live_time);

                    $login_status_update1 = $this->colleagues_model->update_clg_field($ref_id, 'clg_is_login', 'yes');

                    $login_summary = $this->colleagues_model->add_login_details(strtolower($ref_id), $is_live_time, 'login', 'login');
                    
                    $this->session->set_userdata('login_history_id', $login_summary);
                    

                    $ip['ext_ip'] = $_SERVER['REMOTE_ADDR'];

                    $result = $this->colleagues_model->update_clg_field($ref_id, 'clg_break_type', 'LI');
                        $is_users = $this->call_model->is_free_user_exists($ref_id);
//echo "hi4<br>";
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

                        $this->post['ref_id'] = $ref_id;
                        redirect($this->base_url . "Clg/change_password_first_login", 'location');
                        die();
                    } else {
                        //$ref_id_encode = base64_encode($ref_id);
                       // $this->output->add_to_position("<script>sessionStorage.setItem('AgentExtension', '$extension_no'); </script>", 'custom_script', true);

//die();
                        sleep(2);

                        
                        redirect($this->base_url . "clg/login_successful?mi-debug=yes&mi_debug=yes&mi_session_id=".session_id(), 'location');
                        
                        
                        //redirect($this->base_url . "clg/ameyo_login_successful", 'location');
                        //header("refresh: 0; url = {$this->base_url}clg/login_successful");
                        die();
                        
                    }

            } else {

              
                echo "<div class='error' style='color:red; padding:10px; border:1px solid red; background:#ff000008;'>Incorrect crmSessionId and userID..!!</div>";
                die();
                
            }
        } else {

            echo "<div class='error' style='color:red; padding:10px; border:1px solid red;  background:#ff000008;'>Incorrect userID..!!</div>";
                die();
        }
die();
        //redirect($this->base_url . "clg/login", 'location');
    }
    
    function soft_dial(){
        $ext_no = get_cookie("avaya_extension_no");
        $agent_id=$this->clg->clg_avaya_agentid;
        $crmsessionId=$this->clg->clg_crmsessionId;
        $campaignId=$this->clg->clg_avaya_campaign;
        
        $mobile_no = $this->input->post('mobile_no');
        
         
           $sessionid = $this->session->userdata('sessionid');
        $crtObjectId =  $this->session->userdata('crtObjectId');
        $userCrtObjectId =  $this->session->userdata('userCrtObjectId');
         $requestId = get_uniqid($this->session->userdata('user_default_key'));
        $requestId = 'manual-diale'.substr($requestId, -21);
                
       
       if(!empty($crmsessionId)){
        
           
           $data ='{
"additionalParams" :null,
"campaignId" : 5,
"contextVsContextAdditionalData" : { },
  "customerId" : -1,
  "customerRecord": { "Phone1":"'.$mobile_no.'", "name":"test" },
  "phone":"'.$mobile_no.'",
 "userCRTObjectId":"'.$userCrtObjectId.'",
  "shouldAddCustomer" : true,
  "requestId" : "'.$requestId.'",
"sessionId" :"'.$sessionid.'"
    }';
        //$avaya_server_url =  'https://172.16.60.195:8888/ameyorestapi/voice/manualdial';
        $avaya_server_url =  $this->ameyo_server_url.'/ameyorestapi/voice/manualdial';

        file_put_contents('./logs/'.date("Y-m-d").'/'.$agent_id.'_soft_dial_parameter.log', $data.",\r\n", FILE_APPEND);
        
        //$avaya_server_url =  'http://localhost/Spero_MPDIAL_108/call_recive_api.php?data='.$data;
        
        $unique_id = time();
        $avaya_args = array('ActionID'=>$unique_id,
                            'AgentID'=>$agent_id,
                            'Destination'=>$mobile_no);
							
        
        $this->session->set_userdata('dial_history', $avaya_args);
        $this->session->set_userdata('call_action', 'dialing');
        $this->session->set_userdata('soft_dial_mobile', $mobile_no);
       
        
        $avaya_data = json_encode($avaya_args);
        

        $avaya_resp =  agent_makecall($avaya_server_url,$data);
      
        if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
        }
     
      	file_put_contents('./logs/'.date("Y-m-d").'/'.$agent_id.'_soft_dial.log', $avaya_resp['resp'].",\r\n", FILE_APPEND);
        $avaya_resp = json_decode($avaya_resp["resp"]);

     
        
        if($avaya_resp->result == 'success'){
            
                $caller = array();
                $caller["CallUniqueID"] = $unique_id;
                $caller["call_extension"] = $ext_no;
                $caller["call_mobile"] = $mobile_no;
                $caller["call_agentid"] = $agent_id;
               // $caller["call_data"] = 'dialing';
                //$caller["call_message"] = $avaya_resp->ResMessage;
                $caller["call_datetime"] = date('Y-m-d H:i:s');
                $clr_id = $this->call_model->insert_softdial_details($caller);
               // $data['call_data'] = $avaya_args;
               // $data["call_type_data"] = 'dialing';
                
//                $this->output->add_to_position($this->load->view('frontend/avaya/avaya_connected_dialer_view', $data, TRUE), 'dialerscreen', TRUE);
                //$this->output->message = "<p> Make call Successful</p>";
                
        }else{
            $this->output->message = "<p> Sorry!...... Error... $avaya_resp->reason</p>";
        }
        
       }else{
            $this->output->message = "<p> Sorry!...... CrmsessionId not found</p>";
       }
    }
    
    function conference_call(){
        $ext_no = get_cookie("avaya_extension_no");
        $agent_id=$this->clg->clg_avaya_agentid;
        $crmsessionId=$this->clg->clg_crmsessionId;
        $campaignId=$this->clg->clg_avaya_campaign;
        
        $mobile_no = $this->input->post('mobile_no');
        
         $mobile_no ="6269695049";
         
         $sessionid = $this->session->userdata('sessionid');
         $crtObjectId =  $this->session->userdata('crtObjectId');
         $userCrtObjectId =  $this->session->userdata('userCrtObjectId');
         $requestId = get_uniqid($this->session->userdata('user_default_key'));
         $requestId = 'manual-diale'.substr($requestId, -21);
                
       
       if(!empty($userCrtObjectId)){
           
        $data ='{
    "phone":"'.$mobile_no.'",
    "campaignId":5,
    "requestId":"ameyorestapi/voice/conferWithPhone",
    "userCRTObjectId":"'.$userCrtObjectId.'"
}';
           
        //$avaya_server_url =  'https://172.16.60.195:8888/ameyorestapi/voice/conferWithPhone';
        $avaya_server_url =  $this->ameyo_server_url.'/ameyorestapi/voice/conferWithPhone';

        file_put_contents('./logs/'.date("Y-m-d").'/'.$agent_id.'_soft_dial_parameter.log', $data.",\r\n", FILE_APPEND);
        
        //$avaya_server_url =  'http://localhost/Spero_MPDIAL_108/call_recive_api.php?data='.$data;
        
        $unique_id = time();
        $avaya_args = array('ActionID'=>$unique_id,
                            'AgentID'=>$agent_id,
                            'Destination'=>$mobile_no);
							
        
        $this->session->set_userdata('dial_history', $avaya_args);
        $this->session->set_userdata('call_action', 'dialing');
        $this->session->set_userdata('soft_dial_mobile', $mobile_no);
       
        
        $avaya_data = json_encode($avaya_args);
        

        $avaya_resp =  agent_makecall($avaya_server_url,$data);
      
        if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
        }
     
      	file_put_contents('./logs/'.date("Y-m-d").'/'.$agent_id.'_con_dial.log', $avaya_resp['resp'].",\r\n", FILE_APPEND);
        $avaya_resp = $avaya_resp["resp"];
      

        if($avaya_resp["resp"] == 'ok'){
            
                $caller = array();
                $caller["CallUniqueID"] = $unique_id;
                $caller["call_extension"] = $ext_no;
                $caller["call_mobile"] = $mobile_no;
                $caller["call_agentid"] = $agent_id;
               // $caller["call_data"] = 'dialing';
                //$caller["call_message"] = $avaya_resp->ResMessage;
                $caller["call_datetime"] = date('Y-m-d H:i:s');
                $clr_id = $this->call_model->insert_softdial_details($caller);
               // $data['call_data'] = $avaya_args;
               // $data["call_type_data"] = 'dialing';
                
//                $this->output->add_to_position($this->load->view('frontend/avaya/avaya_connected_dialer_view', $data, TRUE), 'dialerscreen', TRUE);
                //$this->output->message = "<p> Make call Successful</p>";
                
        }else{
            $this->output->message = "<p> Sorry!...... Error... $avaya_resp</p>";
        }
        
       }else{
            $this->output->message = "<p> Sorry!...... userCrtObjectId not found</p>";
       }
    }
    
    function dispose_soft_dial(){
        $ext_no = get_cookie("avaya_extension_no");
        $agent_id=$this->clg->clg_avaya_agentid;
        $crmsessionId=$this->clg->clg_crmsessionId;
        $campaignId=$this->clg->clg_avaya_campaign;
        
        
        $mobile_no = $this->input->post('mobile_no');
        
        $sessionid = $this->session->userdata('sessionid');
        $crtObjectId =  $this->session->userdata('crtObjectId');
        $userCrtObjectId =  $this->session->userdata('userCrtObjectId');
       // $sessionid = 'd580-63088cf7-ses-testuser-69vHXZtc-175';
        $requestId = get_uniqid($this->session->userdata('user_default_key'));
        $requestId = substr($requestId, -21);
       
        
       
       if(!empty($crmsessionId)){
        
          //$data = '{"campaignId":"'.$campaignId.'","sessionId":"'.$sessionid.'","dispositionCode":"Redial","phone":"'.$mobile_no.'","userCRTObjectId":"'.$userCrtObjectId.'","crtObjectId":"'.$crtObjectId.'","customerId":"-1"}';
           $dipose =  $this->session->userdata('dispose_dial');

           if($dipose != 1){
          
               if($campaignId == 5){
   $data = '{"campaignContextId":'.$campaignId.',"userCRTObjectId":"'.$userCrtObjectId.'","crtObjectId":"'.$crtObjectId.'","dispositionCode":"Redial","phone":"'.$mobile_no.'","customerId":"-1","requestId":"'.$requestId.'"}';
               }else{
                    $data = '{"campaignContextId":'.$campaignId.',"userCRTObjectId":"'.$userCrtObjectId.'","crtObjectId":"'.$crtObjectId.'","dispositionCode":"Other","phone":"'.$mobile_no.'","customerId":"-1","requestId":"'.$requestId.'"}';
               }
           
        //$avaya_server_url = 'https://172.16.60.195:8888/ameyorestapi/voice/disposeAndManualDial';
        $avaya_server_url = $this->ameyo_server_url.'/ameyorestapi/voice/disposeAndManualDial';
        
        
           }else{
                          $data ='{
"additionalParams" :null,
"campaignId" : '.$campaignId.',
"contextVsContextAdditionalData" : { },
  "customerId" : -1,
  "customerRecord": { "Phone1":"'.$mobile_no.'", "name":"test" },
  "phone":"'.$mobile_no.'",
 "userCRTObjectId":"'.$userCrtObjectId.'",
  "shouldAddCustomer" : true,
  "requestId" : "'.$requestId.'",
"sessionId" :"'.$sessionid.'"
    }';
        //$avaya_server_url =  'https://172.16.60.195:8888/ameyorestapi/voice/manualdial';
        $avaya_server_url =  $this->ameyo_server_url.'/ameyorestapi/voice/manualdial';
        
        
        
           }

            
        	file_put_contents('./logs/'.date("Y-m-d").'/'.$agent_id.'dispose_soft_dial_parameter.log', $data.",\r\n", FILE_APPEND);

        //$avaya_server_url =  'http://localhost/Spero_MPDIAL_108/call_recive_api.php?data='.$data;
        
        $unique_id = time();
        $avaya_args = array('ActionID'=>$unique_id,
                            'AgentID'=>$agent_id,
                            'Destination'=>$mobile_no);
							
        
        $this->session->set_userdata('dial_history', $avaya_args);
        $this->session->set_userdata('call_action', 'dialing');
        $this->session->set_userdata('soft_dial_mobile', $mobile_no);
       
        
        $avaya_data = json_encode($avaya_args);
        
        $avaya_resp =  agent_makecall($avaya_server_url,$data);
        
        
        if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
        }
 
     
      	file_put_contents('./logs/'.date("Y-m-d").'/'.$agent_id.'dispose_soft_dial.log', $avaya_resp['resp'].",\r\n", FILE_APPEND); 
        $avaya_resp = $avaya_resp["resp"];
     
         $this->session->set_userdata('dispose_dial','1');
        
        if($avaya_resp == 'ok'){
            
               
            
                $caller = array();
                $caller["CallUniqueID"] = $unique_id;
                $caller["call_extension"] = $ext_no;
                $caller["call_mobile"] = $mobile_no;
                $caller["call_agentid"] = $agent_id;
               // $caller["call_data"] = 'dialing';
                //$caller["call_message"] = $avaya_resp->ResMessage;
                $caller["call_datetime"] = date('Y-m-d H:i:s');
                $clr_id = $this->call_model->insert_softdial_details($caller);
               // $data['call_data'] = $avaya_args;
               // $data["call_type_data"] = 'dialing';
                
//                $this->output->add_to_position($this->load->view('frontend/avaya/avaya_connected_dialer_view', $data, TRUE), 'dialerscreen', TRUE);
               // $this->output->message = "<p> Make call Successful</p>";
                
        }else{
            $this->output->message = "<p> Sorry!...... Error ..$avaya_resp </p>";
        }
        
       }else{
            $this->output->message = "<p> Sorry!...... CrmsessionId not found</p>";
       }
    }
    
    function ameyo_post_data(){
        $php_input =  file_get_contents( 'php://input' );

        $xml = simplexml_load_string($php_input, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
        }
        
        file_put_contents('./logs/'.date("Y-m-d").'/ameyo_post_data.log', $php_input."\r\n", FILE_APPEND);
        
    }
    
    function api_audio_file_data(){
        $inc_data = $this->inc_model->get_incident_for_audio_files();
        
        foreach($inc_data as $inc){

             $crtobj = $inc->inc_avaya_uniqueid;
             $agent_id  = $inc->inc_added_by;
                //$avaya_server_url =  "https://172.16.60.195:8888/ameyowebaccess/command?command=downloadVoiceLog&data={crtObjectId:'$crtobj'}";
                
                $avaya_server_url =  $this->ameyo_server_url."/ameyowebaccess/command?command=downloadVoiceLog&data={crtObjectId:'$crtobj'}";
 
                //$avaya_resp =  agent_dispose_call($avaya_server_url);
                if (!is_dir('./logs/' . date("Y-m-d"))) {
                    mkdir('./logs/' . date("Y-m-d"), 0755, true);
                }
            
     
                file_put_contents('./logs/'.date("Y-m-d").'/'.$agent_id.'_audio_file_log.log', $avaya_resp['resp'].",\r\n", FILE_APPEND); 
        
        }
        echo "done";
        die();
        
    }
    
    function counseler_call_handler(){
               
         $user_data = $post = $this->input->get();
        
        if($user_data['sessionId'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"Session id not getting"));
            die();
        }
        if($user_data['userId'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"userId not getting"));
            die();
        }
        if($user_data['unique_id'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"unique_id not getting"));
            die();
        }
        if($user_data['call_date'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"call_date not getting"));
            die();
        }
        if($user_data['call_time'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"call_time not getting"));
            die();
        }
        if($user_data['phone'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"phone not getting"));
            die();
        }
        if($user_data['callstate'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"callstate not getting"));
            die();
        }
        
     
        
        if($user_data['sessionId'] != ''){

       
            if (!is_dir('./logs/avaya_calls')) {
                mkdir('./logs/avaya_calls', 0755, true);
            }    
            $agent = $user_data['userId'];
            $data_input = json_encode( $user_data);

            file_put_contents('./logs/avaya_calls/'.$agent.'.json', $data_input);

            $post['log_time'] = date('Y-m-d H:i:s');
            $post_encode = json_encode($user_data);


            if (!is_dir('./logs/' . date("Y-m-d"))) {
                mkdir('./logs/' . date("Y-m-d"), 0755, true);
            }
       
            file_put_contents('./logs/'.date("Y-m-d").'/all_avaya_call_records.log', $post_encode."\r\n", FILE_APPEND);
            file_put_contents('./logs/'.date("Y-m-d").'/'.$post['userId'].'_call_record.log', $post_encode.",\r\n", FILE_APPEND);
       
         
        $current_time = strtotime(date('Y-m-d H:i:s')); 
        $avaya_data = array(
           'calling_phone_no' => $post['phone'],
           'CallUniqueID'=>$post['unique_id'],
           'agent_no' => $post['userId'],
           'message' => $post['callstatedesc'],
           'status' => $post['callstate'],
           //'call_datetime' => date('Y-m-d H:i:s'),
           'is_deleted' => '0');

         
            $this->session->set_userdata('qr_parameter','');
            $this->session->set_userdata('call_action','');
            $this->session->unset_userdata('dispose_dial');
            
            $data['qr_parameter'] = $qr_parameter  = "output_position=content&tool_code=mt_cons_calls&m_no=".$post['phone']."&ext_no=".$post['sessionId']."&CallUniqueID=".$post['crtObjectId']."&sessionid=".$post['sessionId']."&crtObjectId=".$post['crtObjectId']."&userCrtObjectId=".$post['userCrtObjectId']."&callType=".$post['callType'];
            
            $this->session->set_userdata('qr_parameter',$qr_parameter);
            $this->session->set_userdata('call_action','C');
            $this->session->set_userdata('sessionId',$post['sessionId']);
            
            $this->output->add_to_position($this->load->view('frontend/avaya/counseler_dialer_button_view', $data, TRUE), 'content', TRUE);
             
            $this->output->template = "calls";
            
 

        }else{
            echo json_encode(array('status'=>'fail','message'=>"Session id not getting"));
            die();
        }

        
    }
    
    function ercp_call_handler(){
               
         $user_data = $post = $this->input->get();
        
        if($user_data['sessionId'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"Session id not getting"));
            die();
        }
        if($user_data['userId'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"userId not getting"));
            die();
        }
        if($user_data['unique_id'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"unique_id not getting"));
            die();
        }
        if($user_data['call_date'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"call_date not getting"));
            die();
        }
        if($user_data['call_time'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"call_time not getting"));
            die();
        }
        if($user_data['phone'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"phone not getting"));
            die();
        }
        if($user_data['callstate'] == ''){
            echo json_encode(array('status'=>'fail','message'=>"callstate not getting"));
            die();
        }
        
     
        
        if($user_data['sessionId'] != ''){

       
            if (!is_dir('./logs/avaya_calls')) {
                mkdir('./logs/avaya_calls', 0755, true);
            }    
            $agent = $user_data['userId'];
            $data_input = json_encode( $user_data);

            file_put_contents('./logs/avaya_calls/'.$agent.'.json', $data_input);

            $post['log_time'] = date('Y-m-d H:i:s');
            $post_encode = json_encode($user_data);


            if (!is_dir('./logs/' . date("Y-m-d"))) {
                mkdir('./logs/' . date("Y-m-d"), 0755, true);
            }
       
            file_put_contents('./logs/'.date("Y-m-d").'/all_avaya_call_records.log', $post_encode."\r\n", FILE_APPEND);
            file_put_contents('./logs/'.date("Y-m-d").'/'.$post['userId'].'_call_record.log', $post_encode.",\r\n", FILE_APPEND);
       
         
        $current_time = strtotime(date('Y-m-d H:i:s')); 
        $avaya_data = array(
           'calling_phone_no' => $post['phone'],
           'CallUniqueID'=>$post['unique_id'],
           'agent_no' => $post['userId'],
           'message' => $post['callstatedesc'],
           'status' => $post['callstate'],
           //'call_datetime' => date('Y-m-d H:i:s'),
           'is_deleted' => '0');

         
            $this->session->set_userdata('qr_parameter','');
            $this->session->set_userdata('call_action','');
            $this->session->unset_userdata('dispose_dial');
            
            $data['qr_parameter'] = $qr_parameter  = "output_position=content&tool_code=mt_cons_calls&m_no=".$post['phone']."&ext_no=".$post['sessionId']."&CallUniqueID=".$post['crtObjectId']."&sessionid=".$post['sessionId']."&crtObjectId=".$post['crtObjectId']."&userCrtObjectId=".$post['userCrtObjectId']."&callType=".$post['callType'];
            
            $this->session->set_userdata('qr_parameter',$qr_parameter);
            $this->session->set_userdata('call_action','C');
            
            $this->output->add_to_position($this->load->view('frontend/avaya/ercp_dialer_button_view', $data, TRUE), 'content', TRUE);
             
            $this->output->template = "calls";
            
 

        }else{
            echo json_encode(array('status'=>'fail','message'=>"Session id not getting"));
            die();
        }

        
    }

} 