<?php 
      $php_input =  file_get_contents( 'php://input' );
        $post = json_decode( $php_input,true);
        
        if(json_last_error()){ return false; }
        
        $required_array = array('DeviceID','CallUniqueID','CallState','CalledDevice');
        $error_message = '';
        foreach($required_array as $field){
            if(!isset($post[$field])){
                $error_message = $field." not found! ";
                break;
            }
        }
        

        if(trim($error_message) != ''){
            $resp['status'] = "fail";
            $resp['message'] = $error_message;
            echo json_encode($resp);
            die();
        }
       
        $agent = $post['CallingDevice'];
        file_put_contents('./logs/avaya_calls/'.$agent.'.json', $php_input);
        
        $post['log_time'] = date('Y-m-d H:i:s');
		$post_encode = json_encode($post);
        
        if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
        }
        file_put_contents('./logs/'.date("Y-m-d").'/all_avaya_call_records.log', $post_encode."\r\n", FILE_APPEND);
		file_put_contents('./logs/'.date("Y-m-d").'/'.$post['CallingDevice'].'_avaya_call_records.log', $post_encode.",\r\n", FILE_APPEND);
         
        $current_time = strtotime(date('Y-m-d H:i:s')); 
        $avaya_data = array(
           'calling_phone_no' => $post['CalledDevice'],
           'CallUniqueID'=>$post['CallUniqueID'],
           'agent_no' => $post['CallingDevice'],
           'message' => $post['CallStateDesc'],
           'status' => $post['CallState'],
           'is_deleted' => '0');
       
        if($post['CallState'] == "R" || $post['CallState'] == "B"){
            
            $avaya_data['call_rinning_datetime'] = date('Y-m-d').' '.$post['CallTime'];;
            $avaya_data['avaya_call_time'] = $post['CallTime'];
			$avaya_data['call_datetime'] = date('Y-m-d H:i:s');
            /* use to insert data in db */
            //$avaya_ext = $this->call_model->insert_avaya_incoming_call($avaya_data);
 
        
        }else{
               
            if($post['Param1'] != '' && $post['CallType'] == 'I'){
                $avaya_data['call_audio'] = $post['Param1'];
            }
            
            $avaya_data['dis_conn_massage'] = $post['CallStateDesc'];
            
            if($post['CallState'] == "D"){
                $avaya_data['call_disconnect_datetime'] = date('Y-m-d').' '.$post['CallTime'];
            }else if($post['CallState'] == "C"){
                $avaya_data['call_connect_datetime'] = date('Y-m-d').' '.$post['CallTime'];
            }
            /* use to insert data in db */
           // $avaya_call = $this->call_model->update_avaya_call_by_calluniqueid($avaya_data);   
           // $avaya_call = $this->corona_model->update_avaya_call_by_calluniqueid($avaya_data);   
        } 
        
        if($post['CallState'] == "D"){

            
            $inc_avaya_data = array('inc_avaya_uniqueid'=>$post['CallUniqueID']);
            if($post['Param1'] != '' && $post['CallType'] == 'I'){
                $inc_avaya_data['inc_audio_file']=$post['Param1'];
            }
            /* use to insert data in db */
            //$avaya_call = $this->inc_model->update_incident_by_avayaid($inc_avaya_data);
            

        }
        
        $post['status'] = "success";
        echo json_encode($post);
        die();
        