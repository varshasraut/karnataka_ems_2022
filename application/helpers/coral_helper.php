<?php

function corel_encrypt_str($data) {
    $iv = 'C)r@L#m$#%([C^rM';
    $key = 'p@*CR$%*&^([a~^I';
    $encodedEncryptedData = base64_encode(openssl_encrypt($data, "aes-128-cbc", $key, OPENSSL_RAW_DATA, $iv));
    $encodedIV = base64_encode($iv);
    $encryptedPayload = $encodedEncryptedData.":".$encodedIV;
//    var_dump($encryptedPayload);
//    die();
    return base64_encode($encryptedPayload);
}
function corel_decrypt_str($data) {
    $key = 'p@*CR$%*&^([a~^I';
    $parts = explode(':', $data);
    $decryptedData = openssl_decrypt(base64_decode($parts[0]), "aes-128-cbc", $key, OPENSSL_RAW_DATA, base64_decode($parts[1]));
    return $decryptedData;
}

//function corel_encrypt_str($string){
//
//    $simple_string = $string; 
//    //$ciphering = "AES-256-CBC"; 
//    $ciphering = "AES-128-CBC"; 
//
//
//    $iv_length = openssl_cipher_iv_length($ciphering); 
//    $options = 0; 
//
//    // Non-NULL Initialization Vector for encryption 
//    $encryption_iv = 'C)r@L#m$#%([C^rM'; 
//
//    // Store the encryption key 
//    $encryption_key = "p@*CR$%*&^([a~^I"; 
//
//    // Use openssl_encrypt() function to encrypt the data 
//    $encryption = openssl_encrypt($simple_string, $ciphering, $encryption_key, $options, $encryption_iv); 
//    //var_dump($encryption);
//    $encode_encryption = base64_encode($encryption);
//    //var_dump($decode_encryption);
//    return $encode_encryption;
//    
//}

    function corel_curl_api($google_map_url='',$data = ''){

        $CI = get_instance();

        $http_header = array('Content-Type:application/json');
        $CI->load->model('common_model');



        $args = array(
                    'data'        => $data,
                    'method'      => 'GET',
                    'referer_url' => '',
                    'http_header' => $http_header,
                    'header'      => false,
                    'timeout'     => 0
                );

        $avaya_resp =  mi_coral_curl_request($google_map_url,$args);
//        $avaya_resp = '{
//    "status": 0,
//    "message": "Active Calls List",
//    "data": "[{\"direction\":\"outbound\",\"extension\":\"9730015484\",\"destination\":\"5001\",\"state\":\"ACTIVE\",\"uuid\":\"21cb5535-839c-42db-b424-4d3c36cdc685\",\"created\":\"2020-08-25 18:56:32\",\"calleruuid\":\"21cb5535-839c-42db-b424-4d3c36cdc685\",\"calleeuuid\":\"6a1f6d32-0e6d-4b43-8e05-3033fb13682e\"},{\"direction\":\"inbound\",\"extension\":\"5001\",\"destination\":\"9730015484\",\"state\":\"ACTIVE\",\"uuid\":\"b6936f5f-4445-47af-a8f0-f63390ecdf2c\",\"created\":\"2020-08-25 18:56:32\",\"calleruuid\":\"b6936f5f-4445-47af-a8f0-f63390ecdf2c\",\"calleeuuid\":\"d3478162-4f47-43ca-9558-a0f52a62fa9f\"},{\"direction\":\"inbound\",\"extension\":\"5001\",\"destination\":\"9730015484\",\"state\":\"ACTIVE\",\"uuid\":\"27a0d62c-6822-492a-9f0d-82463d0180b2\",\"created\":\"2020-08-25 18:56:52\",\"calleruuid\":\"27a0d62c-6822-492a-9f0d-82463d0180b2\",\"calleeuuid\":\"20a8c483-159e-4e7b-94d1-352bdafe2a68\"},{\"direction\":\"outbound\",\"extension\":\"9730015484\",\"destination\":\"5001\",\"state\":\"ACTIVE\",\"uuid\":\"b23d8cb9-39be-4cb9-af25-be254f8ce23a\",\"created\":\"2020-08-25 18:56:52\",\"calleruuid\":\"b23d8cb9-39be-4cb9-af25-be254f8ce23a\",\"calleeuuid\":\"\"}]"
//}';
       // $avaya_data = json_decode($avaya_resp);
        return $avaya_resp;

    }
    
    function corel_curl_post_api($google_map_url='',$data = ''){

        return true;
        $CI = get_instance();

       // $http_header = array('Content-Type:application/json');
       // $http_header = array('Content-Type: x-www-form-urlencoded');
        

        $args = array(
                    'data'        => $data,
                    'method'      => 'POST',
                    //  'referer_url' => '',
                    //'http_header' => $http_header,
                    //'header'      => false,
                    'timeout'     => 0
                );

        $avaya_resp =  mi_coral_curl_request($google_map_url,$args);
        
        return $avaya_resp;

    }
        function corel_curl_post_api_login($google_map_url='',$data = ''){

        $CI = get_instance();

       // $http_header = array('Content-Type:application/json');
       // $http_header = array('Content-Type: x-www-form-urlencoded');
        

        $args = array(
                    'data'        => $data,
                    'method'      => 'POST',
                    //  'referer_url' => '',
                    //'http_header' => $http_header,
                    //'header'      => false,
                    'timeout'     => 0
                );

        $avaya_resp =  mi_coral_login_curl_request($google_map_url,$args);
        
        return $avaya_resp;

    }
    
   /* API 19-GET PBX ACTIVE CALLS (REALTIME STATUS)*/
    function pbx_active_calls(){
        $CI = get_instance();
        $url = $CI->config->item('corel_server_url')."/getactivecalls";

        $avaya_args = corel_curl_api($url);
        return $avaya_args;
   }
   
   /* API 20 - FORCED FULLY KILL PBX ACTIVE CALLS */
    function pbx_kill_calls($avaya_args){
        $CI = get_instance();
       $url = $CI->config->item('corel_server_url')."/killactivecalls";

        $avaya_args = corel_curl_post_api($url,$avaya_args);
        return $avaya_args;
    }
   
    function coral_agent_login($agentid){
        
        
    
    $CI = get_instance();
      
    $http_header = array('Content-Type:application/json');
    
    $coral_url = $CI->config->item('corel_server_url').'agentlogin';
    
    if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
    }
    
    $CI->load->model('common_model');
    
    
    $data = json_encode(array('agentid'=>corel_encrypt_str($agentid)));
    
    $data_insert = array('action_id'=>'login',
                        'action_data'=>$data,
                        'action_datetime'=>date('Y-m-d H:i:s'));
    
    
    $state = $CI->call_model->insert_avaya_action($data_insert);
    
    file_put_contents('./logs/'.date("Y-m-d").'avaya_setaction_log.log', $data.",\r\n", FILE_APPEND);
 
    $args = array(
                'data'        => $data,
                'method'      => 'POST',
                'referer_url' => '',
                'http_header' => $http_header,
                'header'      => false,
                'timeout'     => 0
            );

    $avaya_resp =  mi_coral_curl_request($coral_url,$args);
   // $avaya_data = json_decode($avaya_resp);
    return $avaya_resp;
    
}
    function coral_agent_makecall($agent_args){

        $CI = get_instance();

        //$http_header = array('Content-Type:application/json');
        $ext_no = get_cookie("avaya_extension_no");

        $coral_url = $CI->config->item('corel_server_url').'/originatecall';

        $input_array = array('callerextension'=>$ext_no,
                             'callername'=> "TEST",
                             'calleenumber'=>corel_encrypt_str($agent_args['callernumber']));

       // $data = json_encode($input_array);
        file_put_contents('./logs/'.date("Y-m-d").'/'.date("Y-m-d").'avaya_make_log.log', $avaya_resp.",\r\n", FILE_APPEND);


        $args = array(
                    'data'        => $input_array,
                    'method'      => 'POST',
                   // 'referer_url' => '',
                   // 'http_header' => $http_header,
                   // 'header'      => false,
                    'timeout'     => 0
                );

        $avaya_resp =  mi_coral_curl_request($coral_url,$args);
       // $avaya_data = json_decode($avaya_resp);
        return $avaya_resp;

    }
    function coral_agent_logout($agentid){
        
        
    
    $CI = get_instance();
      
    $http_header = array('Content-Type:application/json');
    
    $coral_url = $CI->config->item('corel_server_url').'agentlogout';
    
    if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
    }
    
    $CI->load->model('common_model');
    
    $ext_no = get_cookie("avaya_extension_no");
    
    
    
    $data = json_encode(array('agentid'=>$ext_no));
    
    $data_insert = array('action_id'=>'logout',
                        'action_data'=>$data,
                        'action_datetime'=>date('Y-m-d H:i:s'));
    
    
    $state = $CI->call_model->insert_avaya_action($data_insert);
    
    file_put_contents('./logs/'.date("Y-m-d").'avaya_setaction_log.log', $data.",\r\n", FILE_APPEND);
 
    $args = array(
                'data'        => $data,
                'method'      => 'POST',
                'referer_url' => '',
                'http_header' => $http_header,
                'header'      => false,
                'timeout'     => 0
            );

    $avaya_resp =  mi_coral_curl_request($coral_url,$args);
   // $avaya_data = json_decode($avaya_resp);
    return $avaya_resp;
    
    }
    
    function coral_agent_break($agentid){
        
        
    
    $CI = get_instance();
      
    $http_header = array('Content-Type:application/json');
    
    $coral_url = $CI->config->item('corel_server_url').'agentbreak';
    
    if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
    }
    
    $CI->load->model('common_model');
    
    
    $data = json_encode(array('agentid'=>corel_encrypt_str($agentid)));
    
    $data_insert = array('action_id'=>'break',
                        'action_data'=>$data,
                        'action_datetime'=>date('Y-m-d H:i:s'));
    
    
    
    $state = $CI->call_model->insert_avaya_action($data_insert);
    
    file_put_contents('./logs/'.date("Y-m-d").'avaya_setaction_log.log', $data.",\r\n", FILE_APPEND);
 
    $args = array(
                'data'        => $data,
                'method'      => 'POST',
                'referer_url' => '',
                'http_header' => $http_header,
                'header'      => false,
                'timeout'     => 0
            );

    $avaya_resp =  mi_coral_curl_request($coral_url,$args);
   // $avaya_data = json_decode($avaya_resp);
    return $avaya_resp;
    
}
    /* MI CURL request

    $atts = array(
        'data'        => array(), // GET/POST Data
        'method'      => 'GET',   // GET/POST Method
        'referer_url' => '',      // HTTP referer url
        'http_header' => array(), // Send Row HTTP header
        'header'      => false,   // Get HTTP header of responce
        'timeout'     => 0        // Connection and Request Time Out
    );

    Return array(
        'resp' => ' Responce value'
        'info' => array( 'Request and Responce details' )
    );

    Ex.
    1) For ajax request: 
       $http_header = array('X-Requested-With: XMLHttpRequest');
    2) Submit row file content with type
       $http_header = array('Content-Type: text/xml');
       $http_header = array('Content-Type: application/json');
    3) To Send/Upload file: 
       $parameters = array( 'file' = '@/filepath/filename.jpg' );
    */
    
    function mi_coral_curl_request( $url, $atts = array() ){
       return false;
    
        $args = array(
            'data'        => array(),
            'method'      => 'GET',
            'referer_url' => '',
            'http_header' => array(),
            'header'      => false,
            'timeout'     => 0
        );
        $args = array_merge( $args, $atts );

        set_time_limit( $args['timeout'] );

        if (function_exists("curl_init") && $url) {

            $user_agent = $_SERVER['HTTP_USER_AGENT'];

            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_USERAGENT, $user_agent );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch, CURLOPT_HEADER, $args['header'] );
            curl_setopt( $ch, CURLOPT_TIMEOUT, $args['timeout'] );
            curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $args['timeout'] );

            if ( strtolower( $args['method'] ) == "post" ) {
                curl_setopt( $ch, CURLOPT_POST, true );
                curl_setopt( $ch, CURLOPT_POSTFIELDS, $args['data'] );
            } else {
                curl_setopt( $ch, CURLOPT_HTTPGET, 1);
                if($args['data'] != ''){
                    $query_string = http_build_query( $args['data'] );
                    if ( $query_string != '' ) {
                        $url = trim( $url, "?" ) . "?" . $query_string;
                    }
                }
            }

            if ( $args['referer_url'] != '' ) { 
                curl_setopt( $ch, CURLOPT_REFERER, $args['referer_url'] );
            }

            if ( !empty( $args['http_header'] ) ) {
                curl_setopt( $ch, CURLOPT_HTTPHEADER, $args['http_header'] );
            }

            curl_setopt( $ch, CURLOPT_URL, $url );

            $resp = curl_exec($ch);
            $info = curl_getinfo($ch);

            curl_close($ch);

            return array( 
                'resp' => $resp,
                //'info' => $info
            );

        }

    }
        function mi_coral_login_curl_request( $url, $atts = array() ){
        return false;
    
        $args = array(
            'data'        => array(),
            'method'      => 'GET',
            'referer_url' => '',
            'http_header' => array(),
            'header'      => false,
            'timeout'     => 2
        );
        $args = array_merge( $args, $atts );

        set_time_limit( $args['timeout'] );

        if (function_exists("curl_init") && $url) {

            $user_agent = $_SERVER['HTTP_USER_AGENT'];

            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_USERAGENT, $user_agent );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch, CURLOPT_HEADER, $args['header'] );
            curl_setopt( $ch, CURLOPT_TIMEOUT, $args['timeout'] );
            curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $args['timeout'] );

            if ( strtolower( $args['method'] ) == "post" ) {
                curl_setopt( $ch, CURLOPT_POST, true );
                curl_setopt( $ch, CURLOPT_POSTFIELDS, $args['data'] );
            } else {
                curl_setopt( $ch, CURLOPT_HTTPGET, 1);
                if($args['data'] != ''){
                    $query_string = http_build_query( $args['data'] );
                    if ( $query_string != '' ) {
                        $url = trim( $url, "?" ) . "?" . $query_string;
                    }
                }
            }

            if ( $args['referer_url'] != '' ) { 
                curl_setopt( $ch, CURLOPT_REFERER, $args['referer_url'] );
            }

            if ( !empty( $args['http_header'] ) ) {
                curl_setopt( $ch, CURLOPT_HTTPHEADER, $args['http_header'] );
            }

            curl_setopt( $ch, CURLOPT_URL, $url );

            $resp = curl_exec($ch);
            $info = curl_getinfo($ch);

            curl_close($ch);

            return array( 
                'resp' => $resp,
                //'info' => $info
            );

        }

    }