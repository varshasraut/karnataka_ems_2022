<?php
defined('BASEPATH') OR exit('No direct script access allowed');
   header("Accept: application/json");
    header("Content-Type: application/json; charset=UTF-8");
class Send_daily_incident_data extends EMS_Controller {

    function __construct() {

        parent::__construct();
        $this->active_module = "M-INC";
        $this->pg_limit = $this->config->item('pagination_limit');
        $this->load->model(array('send_daily_incident_data_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date','cct_helper', 'comman_helper'));
        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));
        $this->post = $this->input->get_post(NULL);
        $this->clg = $this->session->userdata('current_user');
        $this->post['base_month'] = get_base_month();

        $this->google_api_key = $this->config->item('google_api_key');
        //$this->check_user_permission($this->session->userdata('current_user')->clg_id , $this->session->userdata('current_user')->clg_group );
    }
    function send_incident_details()
    {
      
        $yes_date=date('Y-m-d',strtotime("-1 days"));
        $args = array('date' => $yes_date);
          //var_dump($args);die();
         $inc_data = $this->send_daily_incident_data_model->get_inc_details($args);

        foreach($inc_data as $inc){
            // Inc date
            $inc_date = date("Y-m-d", strtotime($inc->inc_datetime ));
            // INC complaint
            $inc_complaint = get_cheif_complaint($inc->inc_complaint);
            //base location
            if($inc->amb_base_location != '' || $inc->amb_base_location != 0 ){ 
                $amb_base_location1 = get_base_location_by_id($inc->amb_base_location);
                $amb_base_location = $amb_base_location1[0]->hp_name;
             
              }else{
                  $amb_base_location = "";
              }
               if($inc->rec_hospital_name == '' || $inc->rec_hospital_name == 0 ){ 
                  $rec_hospital_name = "Other";
                  $rec_hospital_type = "-";
             
              }else{
                
                  $rec_hospital = get_hospital_by_id($inc->rec_hospital_name);
                $rec_hospital_name = $rec_hospital[0]->hp_name;
                $rec_hospital_type = $rec_hospital[0]->hosp_type;
              }
              
              
       
              
            //provider immpretion
            if($inc->provider_impressions != ''){ $provider_impressions = get_provider_impression($inc->provider_impressions); }else{ $provider_impressions = ""; }
               
            $data = array ( "eventId"=> (int) $inc->inc_ref_id,
            "victimId"=> (int) $inc->inc_ref_id.''.$inc->ptn_id,
            "eventDate"=> $inc_date,
            "victimName"=> $inc->ptn_fname.''.$inc->ptn_lname, 
            "victimAge"=> $inc->ptn_age,
            "callerNumber"=> $inc->clr_mobile,
            "district"=> $inc->dst_name,
            "callerName"=> $inc->clr_fname.''.$inc->clr_lname,
            "chiefComplaint"=> $inc_complaint,
            "ambulance"=> $inc->amb_reg_id,
            "baselocation"=>$amb_base_location,
            "startOdo"=> (float) $inc->start_odometer,
            "endOdo"=> (float) $inc->end_odometer,
            "caseType"=> $provider_impressions,
            "incidentAssignedDateTime"=> $inc->inc_datetime,
            "vehicleStartDateTime"=> $inc->start_from_base,
            "atSceneDateTime"=> $inc->dp_on_scene,
            "fromSceneDateTime"=> $inc->dp_reach_on_scene,
            "atHospitalDateTime"=> $inc->dp_hosp_time,
            "handoverDateTime"=> $inc->dp_hand_time,
            "backToBaseDateTime"=> $inc->dp_back_to_loc,
            "hospitalName"=> $rec_hospital_name,
            "hospitalType"=>$rec_hospital_type, 
            "incidentAddress"=> $inc->inc_address,
        );
        
        
        }
       $data_to_post = json_encode($data);
      //print_r($data_to_post);
      
        // $form_url = "http://10.108.1.120:3000/googlemaps/CoronaController/coronaCaseAPI";
        $form_url = "http://210.212.165.124:3000/googlemaps/CoronaController/coronaCaseAPI";
      
       $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $form_url);
            curl_setopt($curl, CURLOPT_POST, $data_to_post);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
            $result = curl_exec($curl);
           // var_dump($result);die();
            curl_close($curl); 
  }
    function mi_curl_request( $url, $atts = array() ){
    
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

            return array( 
                'resp' => $resp,
                'info' => $info
            );

        }

    }

}
?>