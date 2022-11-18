<?php

    function agent_makecall($req_url = '', $data) {

        $CI = get_instance();
        //$json_data = json_decode($data);
        
        $sessionid = $CI->session->userdata('sessionid');
       
        
        $http_header = array('Content-Type: application/json', 'sessionId: '.$sessionid);

        $args = array(
            'data' => $data,
            'method' => 'POST',
            'http_header' => $http_header,
            'timeout' => 0
        );
        
     
        $avaya_resp = mi_api_curl_request($req_url, $args);
        // $avaya_data = json_decode($avaya_resp);
        return $avaya_resp;
    }

    function agent_dispose_call($req_url = '') {

        $CI = get_instance();
        $http_header = array('Content-Type:application/json');

        $args = array(
            'method' => 'GET',
            'referer_url' => '',
            'http_header' => $http_header,
            'header' => false,
            'timeout' => 0
        );
        $avaya_resp = mi_api_curl_request($req_url, $args);
        // $avaya_data = json_decode($avaya_resp);
        return $avaya_resp;
    }
    function ameyo_dispose_call(){
        $agent_id=$this->clg->clg_avaya_agentid; 
        $agent_id='-1'; 
        $crmsessionId=$this->clg->clg_crmsessionId; 
      
        $campaign=$this->clg->clg_avaya_campaign; 
        $sessionid= $this->session->userdata('sessionid');
        $crtObjectId =  $this->session->userdata('crtObjectId');
        $userCrtObjectId =  $this->session->userdata('userCrtObjectId');
        $cti_mobile_number =  $this->session->userdata('cti_mobile_number');
        
            
        if($crmsessionId != ''){      
            
            
            $crm_data = 'phone='.$cti_mobile_number.'&campaignId='.$campaign.'&customerId='.$agent_id.'&dispositionCode=Dispatch&sessionId='.$sessionid.'&crtObjectId='.$crtObjectId.'&userCrtObjectId='.$userCrtObjectId.'&selfCallback=true';
            $avaya_server_url =  'http://172.16.60.195:8888/dacx/dispose?'.$crm_data;
            
            if (!is_dir('./logs/' . date("Y-m-d"))) {
                mkdir('./logs/' . date("Y-m-d"), 0755, true);
            }           
              file_put_contents('./logs/'.date("Y-m-d").'/'.$agent_id.'_dispose_call_para.log', $avaya_server_url.",\r\n", FILE_APPEND);

          
            $avaya_resp =  agent_dispose_call($avaya_server_url,$data);
            
           
            file_put_contents('./logs/'.date("Y-m-d").'/'.$agent_id.'_dispose_call.log', $avaya_resp['resp'].",\r\n", FILE_APPEND);
        
        }
        $this->session->unset_userdata('sessionid');
        $this->session->unset_userdata('crtObjectId');
        $this->session->unset_userdata('userCrtObjectId');
        $this->session->unset_userdata('cti_mobile_number');
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

    function mi_api_curl_request($url, $atts = array()) {
    //        $resp = '{"ActionID":"1073_1628846394","AgentID":"1","AgentExtension":"1073","AgentCampaign":201,"AgentAction":"BO","AgentActionParam":"1","ResCode":"0"}';
    //         
    //         return array(   
    //                'resp' => $resp,  
    //                'info' => $info       
    //            );  

        $args = array(
            'data' => array(),
            'method' => 'GET',
            'referer_url' => '',
            'http_header' => array(),
            'header' => false,
            'timeout' => 0
        );
        $args = array_merge($args, $atts);

        set_time_limit($args['timeout']);

        if (function_exists("curl_init") && $url) {

            $user_agent = $_SERVER['HTTP_USER_AGENT'];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, $args['header']);
            curl_setopt($ch, CURLOPT_TIMEOUT, $args['timeout']);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $args['timeout']);

            if (strtolower($args['method']) == "post") {
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $args['data']);
            } else {
                curl_setopt($ch, CURLOPT_HTTPGET, 1);
                $query_string = http_build_query($args['data']);
                if ($query_string != '') {
                    $url = trim($url, "?") . "?" . $query_string;
                }
            }

            if ($args['referer_url'] != '') {
                curl_setopt($ch, CURLOPT_REFERER, $args['referer_url']);
            }

            if (!empty($args['http_header'])) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, $args['http_header']);
            }

            curl_setopt($ch, CURLOPT_URL, $url);

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
