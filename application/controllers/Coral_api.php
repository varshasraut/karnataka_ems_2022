<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Coral_api extends EMS_Controller {
    
    function __construct() {

        parent::__construct();

        $this->active_module = "M-CORAL";
        $this->pg_limit = $this->config->item('pagination_limit');


        $this->bvgtoken = $this->config->item('bvgtoken');
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper','coral_helper'));
        $this->load->model(array('options_model', 'module_model', 'common_model','call_model','inc_model','corona_model'));
        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));


	    $this->clg = $this->session->userdata('current_user');
        $this->post = $this->input->get_post(NULL);
        $this->corel_server_url = $this->config->item('corel_server_url');

    }

    public function index($generated = false) {

        echo "This is Corel API controller";
        //die();

    }
    
    /* API 1:- PBX HEALTH STATUS*/
   public function pbx_health_status(){
       $url = $this->corel_server_url."/pbxhealthstatus";

        $avaya_args = corel_curl_api($url);
        return $avaya_args;
   }
   /* API 2:- SET PBX SERVER TIME*/
    public function pbx_server_time(){
       $url = $this->corel_server_url."/setpbxservertime";
       $date = corel_encrypt_str(date("j F Y h:i:s"));
       
       $avaya_args = array('Newtime'=>$date);

        $avaya_args = corel_curl_api($url);
        return $avaya_args;
   }
   
    /* API 19-GET PBX ACTIVE CALLS (REALTIME STATUS)*/
    public function pbx_active_calls(){
        
        if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
        }
        
        $url = $this->corel_server_url."/getactivecalls";

        $avaya_args = corel_curl_api($url);
        $data = json_encode($avaya_args["resp"]);
        
        file_put_contents('./logs/'.date("Y-m-d").'avaya_setaction_log.log', $data.",\r\n", FILE_APPEND);

        return $avaya_args;
   }
   
   /* API 20 - FORCED FULLY KILL PBX ACTIVE CALLS */
   public function pbx_kill_calls(){
       $url = $this->corel_server_url."/killactivecalls";

        $avaya_args = corel_curl_api($url);
        return $avaya_args;
   }
   public function start_call_barging(){

        $agent_id = $this->post['agentid'];
        //var_dump($agent_id);
       // $agent_id = get_cookie("avaya_extension_no");
        $supervisorextension = $this->session->userdata('avaya_extension_no');

        $avaya_server_url = $this->corel_server_url."/startcallbarging";

        
       
            $avaya_args_cr = array('agentid' => corel_encrypt_str($agent_id),
                'supervisorextension' => $supervisorextension );
            
            $en_res = json_encode($avaya_args_cr);
            
            file_put_contents('./logs/'.date("Y-m-d").'/'.date("Y-m-d").'avaya_startbar_log.log', $en_res.",\r\n", FILE_APPEND);
            

            $avaya_resp =  corel_curl_post_api($avaya_server_url,$avaya_args_cr);
//            var_dump($avaya_resp["resp"]);
//            die();
            $avaya_resp_en = json_decode($avaya_resp["resp"]);
            
            

            file_put_contents('./logs/'.date("Y-m-d").'/'.date("Y-m-d").'avaya_startbarging_log.log', $avaya_resp["resp"].",\r\n", FILE_APPEND);
            if($avaya_resp_en->status == 0){
                $data['avaya_agentid'] = $agent_id;
                $this->output->add_to_position($this->load->view('frontend/coral/end_call_barging', $data, TRUE), 'call_barging', TRUE);
            }else{
                 $this->output->message = "<p>".$avaya_resp_en->message."</p>";
            }
        
        
   }
    public function end_call_barging(){
       
        $agent_id = $this->session->userdata('extension_no');
        
        $clg_id = $this->post['clg_id'];
        $avaya_server_url = $this->corel_server_url."/endcallbarging";
        $active_calls =  pbx_active_calls();


       
        $active_call_decode = json_decode($active_calls['resp']);
        $active_calls_data = json_decode($active_call_decode->data);
        $uuid = "";
        if(!empty($active_calls_data)){
            foreach($active_calls_data as $calls){

                if($calls->extension == $agent_id){
                    $uuid = $calls->uuid;
                }

            }
        }
            if($uuid != ""){
                $avaya_args_cr = array('uuid' => corel_encrypt_str($uuid)
                    );

                $avaya_resp =  corel_curl_post_api($avaya_server_url,$avaya_args_cr);
                $avaya_resp_en = json_encode($avaya_resp["resp"]);
                file_put_contents('./logs/'.date("Y-m-d").'/'.date("Y-m-d").'avaya_stopbarging_log.log', $avaya_resp_en.",\r\n", FILE_APPEND);
                $data['avaya_agentid'] = $agent_id;
                $this->output->add_to_position($this->load->view('frontend/coral/start_call_barging', $data, TRUE), 'call_barging', TRUE);
            }else{
                //$this->output->message = "<p> Sorry!...... No call active</p>";
                $this->output->add_to_position($this->load->view('frontend/coral/start_call_barging', $data, TRUE), 'call_barging', TRUE);
            }
       
   }
    
}