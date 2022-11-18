<?php

function check_avaya_status($args=array()){
    $CI = get_instance();
    $CI->load->model('call_model'); 
    
    $ser_args = array('agent_no'=>$args['agent_id']);
    $agent_data = $CI->call_model->get_last_call_status($ser_args);
    
    //if($agent_data->status == 'C'){
        
//      
//        if(strtotime($agent_data->call_datetime) > strtotime("-30 minutes")) {
//            return $agent_data;
//        }else{
//             return false;
//        }
   // }else{
         return false;
    //}
    
}
function get_avaya_status($args=array()){
    $CI = get_instance();
    $CI->load->model('call_model'); 
    
    $ser_args = array('agent_no'=>$args['agent_id']);
    $agent_data = $CI->call_model->get_last_call_status($ser_args);
    
    if($agent_data->status == 'C'){
       
            return $agent_data;
   
    }else{
         return false;
    }
    
}
function cct_agent_action($google_map_url='',$data = '',$action_id=''){
     return false;
    $CI = get_instance();
      
    $http_header = array('Content-Type:application/json');
    
    if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
    }
    
    $CI->load->model('common_model');
    
    
    $data_insert = array('action_id'=>$action_id,
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

    $avaya_resp =  mi_curl_request($google_map_url,$args);
   // $avaya_data = json_decode($avaya_resp);
    return $avaya_resp;
    
}

function cct_agent_makecall($google_map_url='',$data = ''){
    
    $CI = get_instance();
      
    $http_header = array('Content-Type:application/json');
 
    $args = array(
                'data'        => $data,
                'method'      => 'POST',
                'referer_url' => '',
                'http_header' => $http_header,
                'header'      => false,
                'timeout'     => 0
            );
 return false;
    $avaya_resp =  mi_curl_request($google_map_url,$args);
   // $avaya_data = json_decode($avaya_resp);
    return $avaya_resp;
}

function cct_agent_disconnectcall($google_map_url='',$data = ''){
    
    $CI = get_instance();
      
    $http_header = array('Content-Type:application/json');
 
    $args = array(
                'data'        => $data,
                'method'      => 'POST',
                'referer_url' => '',
                'http_header' => $http_header,
                'header'      => false,
                'timeout'     => 0
            );
 return false;
    $avaya_resp =  mi_curl_request($google_map_url,$args);
   // $avaya_data = json_decode($avaya_resp);
    return $avaya_resp;
}

function cct_agent_tranfercall($google_map_url='',$data = ''){
    
    //$CI = get_instance();
      
    $http_header = array('Content-Type:application/json');
    
     file_put_contents('./logs/transfer/avaya_call_transfer_102_cct'.date("Y-m-d").'.log', $data."\r\n", FILE_APPEND);
 
    $args = array(
                'data'        => $data,
                'method'      => 'POST',
                'referer_url' => '',
                'http_header' => $http_header,
                'header'      => false,
                'timeout'     => 0
            );
 return false;
    $avaya_resp =  mi_curl_request($google_map_url,$args);
   // $avaya_data = json_decode($avaya_resp);
    return $avaya_resp;
}

function cct_agent_holdcall($google_map_url='',$data = ''){
    
    $CI = get_instance();
    $http_header = array('Content-Type:application/json');
    $args = array(
                'data'        => $data,
                'method'      => 'POST',
                'referer_url' => '',
                'http_header' => $http_header,
                'header'      => false,
                'timeout'     => 0);
 return false;
    $avaya_resp =  mi_curl_request($google_map_url,$args);
   // $avaya_data = json_decode($avaya_resp);
    return $avaya_resp;
}

function cct_agent_unholdcall($google_map_url='',$data = ''){
    
    $CI = get_instance();
    $http_header = array('Content-Type:application/json');
    $args = array(
                'data'        => $data,
                'method'      => 'POST',
                'referer_url' => '',
                'http_header' => $http_header,
                'header'      => false,
                'timeout'     => 0);
 return false;
    $avaya_resp =  mi_curl_request($google_map_url,$args);
   // $avaya_data = json_decode($avaya_resp);
    return $avaya_resp;
}

function cct_agent_answercall($google_map_url='',$data = ''){
    
    $CI = get_instance();
    $http_header = array('Content-Type:application/json');
    $args = array(
                'data'        => $data,
                'method'      => 'POST',
                //'referer_url' => '',
                'http_header' => $http_header,
               // 'header'      => false,
                'timeout'     => 0);
 return false;
    $avaya_resp =  mi_curl_request($google_map_url,$args);
   // $avaya_data = json_decode($avaya_resp);
    return $avaya_resp;
}
function api_notification_app($api_url='',$data = ''){
    
    $CI = get_instance();

    
    $CI->load->model('common_model');
    $http_header = array('Content-Type: application/json');
  file_put_contents('./logs/notification/api_notification_app'.date("Y-m-d").'.log', $data."\r\n", FILE_APPEND);
    $args = array(
                'data'        => $data,
                'method'      => 'POST',
               // 'referer_url' => '',
                'http_header' => $http_header,
                //'header'      => false,
               // 'timeout'     => 0
            );

    $avaya_resp =  mi_curl_request($api_url,$args);
     $api_google_data= json_encode($avaya_resp);
     file_put_contents('./logs/notification/api_notification'.date("Y-m-d").'.log', $api_google_data."\r\n", FILE_APPEND);
   
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
    
    function mi_curl_request( $url, $atts = array() ){
//        $resp = '{"ActionID":"1073_1628846394","AgentID":"1","AgentExtension":"1073","AgentCampaign":201,"AgentAction":"BO","AgentActionParam":"1","ResCode":"0"}';
//         
//         return array(   
//                'resp' => $resp,  
//                'info' => $info       
//            );  
   
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
                $query_string = http_build_query( $args['data'] );
                if ( $query_string != '' ) {
                    $url = trim( $url, "?" ) . "?" . $query_string;
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
            session_start();

            return array( 
                'resp' => $resp,
                'info' => $info
            );

        }

    }