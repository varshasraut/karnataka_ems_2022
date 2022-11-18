<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//@session_start();

class CI_MIUsers {

    function __construct() {

        if (class_exists('CI_Controller')) {



            $CI = &get_instance();

            $CI->load->library('session');

            $CI->load->library('modules');

            $this->base_url = $CI->config->item('base_url');

            $CI->load->model('colleagues_model');
        }
    }

    function __get($var) {

        if ($var == "CI") {

            return get_instance();
        } else {

            return $var;
        }
    }

    function getBrowser() {



        $agent_componant = array();


        $a = array("MSIE", "Firefox", "Chrome", "Opera", "Safari");

        $http_user_agent = $_SERVER['HTTP_USER_AGENT'];



        for ($it = 0; $it < count($a); $it++) {

            $index = stristr($http_user_agent, $a[$it]);

            if ($index !== false) {
                return $a[$it];
            }
        }

        return "Default";
    }

    function is_login() {



        
        $RTR = & load_class('Router', 'core', isset($routing) ? $routing : NULL);

        $class = ucfirst($RTR->class);

        $method = $RTR->method;
      
        $current_login_user  = $_SESSION['current_user'];

        if(empty($current_login_user)){
               
            $ref_id = trim(get_cookie("username"));
            if($ref_id != ''){
                $current_user = $this->CI->colleagues_model->get_user_info($ref_id);
                $this->CI->session->set_userdata('current_user',$current_user);
            }
        }

        if ('frontend' == $this->CI->get_app_environment()) {



            $ignore_methods = array("users" => array(),
                "clg" => array("show_avaya_extenstion","login", "generate_otp", "authenticate_otp", "authenticate_password", "authenticate_password_lc", "authenticate_lc_pwd", "update_clg_login_status","show_extenstion","mapping_ip_extension","show_avaya_extenstion","ameyo_login_successful"),
                "page" => array("index"),
                "amb" => array("update_loctaion", "loc", "all", "gpsapi", "gpsdebug", "update_amb_status","applogoutcronjob"),
                "calls" => array("reassing_calls","show_user_download_data","download_login_details_link","get_avaya_incoming_call_record"),
                "inc" => array("generating_load"),
                "healthcard" => array("download_healthcard"),
                "dashboard" => array("all_dash_amb","view","chartdata","update_total_count_for_cron","nhm_data","update_nhm_data","dash_data","nhm_dashabord_cron","update_total_km_cron","nhm_dashabord_cron_for_report","nhm_dashabord_b12data_cron_for_report","ems_incidance_analytics_data","update_analytic_epcr_data_by_date"),
                "database" => array("auto_backup_generator"),
                "screendashboard" => array("index", "calls_dash"),
                "screendashboard2" => array("index"),
                "api" => array("receiver","police_api_receiver"),
                "avaya_api" => array("call_recveing", "soft_dial", "soft_dial_disconnect", "conference_transfer_call_responce","record_action_status","call_recveing_audio","call_recveing_avaya","call_recveing_audio","disconnected_call_receiving_avaya"),
                "smsapi" => array("send_delivary_report"),
                "schools" => array("send_daily_sms_template", "send_daily_calls_sms"),
                "user" => array("userlogin"),
                "sync" => array("download_sync_main", "upload_sync_main"),
                "feedback" => array("feedback_list"),
                "job_closer" => array("update_epcr_patient_status","update_epcr_status","send_daily_sms_template"),
                "grievance" => array("grievance_call_list"),
                "erc_reports" => array("get_amb_availability_status"),
                "hp" => array("update_hospital_data"),
                "bed" => array("nhm_dashboard"),
                "hp" => array("update_hospital_data"),
                "auto" => array("get_ambulance_map"),
                "send_daily_incident_data" => array("send_incident_details"),
                "hpcl_api" => array("get_hpcl_data"),
                "cron_job" => array("update_ambulance_status_cron","wrap_out_cron"),
                "feedback" => array("pt_feedback","save_pt_feedback"),
                "uploads"=>array(),
                "setting"=>array('load_payment','getTransactionToken','getcURLRequest','getSiteURL','transactionStatus','callback'),
                "dashboard_updated" => array("nhm_dashabord_cron"),
                "api_v2" => array("ameyo_login","ameyo_call_handler","ameyo_incoming_call_api","login","api_audio_file_data","counseler_call_handler","ercp_call_handler"),
                "dash" => array("push_closure_validate_data_to_gps","inc_table_update_gps_rec"),
            );
           

            if (in_array(strtolower($method), (array) $ignore_methods[strtolower($class)])) {

                return true;
            }



            $user_logged_in = get_cookie("user_logged_in");

            //if(!$this->CI->session->userdata('user_logged_in')){
            if (!$user_logged_in) {



                if ($this->CI->input->is_ajax_request()) {



                    $result = array();



                    $result['message'] = "<div class='error'>Session expired: Could You Please Login to System!</div><script>window.location = '" . $this->base_url . "clg/login" . "';</script>";

                    $result['notifications'] = "";

                    $result['position'] = "";

                    echo json_encode($result);

                    exit();
                } else {


                    $this->CI->session->set_flashdata('warning', "<div class='warning'>Could You Please Login to System!</div>");

                    header("Location: " . $this->base_url . "clg/login");

                    exit();
                }
            }

            // return true;
        }
    }

    function load_user_modulebar() {

        $this->CI->modules->load_modulebar();
    }

    function load_user_toolbar() {

        $this->CI->modules->load_toolbar();
    }

}
