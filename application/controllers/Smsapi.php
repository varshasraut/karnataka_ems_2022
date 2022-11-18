<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Smsapi extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->active_module = "M-SMSAPI";

	    $this->clg = $this->session->userdata('current_user');

    }

    function send_delivary_report(){
        
        $url = $this->config->item('sms_api_url');

        $sms_api_username = $this->config->item('sms_auth_user');

        $sms_api_password = $this->config->item('sms_auth_pass');
        
        $data_reasons = array(
            'New Error Code' => 'This status displays when the error code provided by the subscribers terminating operator is not mapped with the existing status.',
            'Sub-SMSC' => 'The message is on SMSC queue i.e. the message has been inserted into the SMSC database but the status of the message is yet to be received.',
            'DELIVRD' => 'Successfully delivered.',
            'FAILED' => 'The message is permanently failed due to CallBarred, Error in Destination Number, Error in TeleService Provider etc.',
            'NDNC_Failed' => 'Failed Due to DND Registration',
            'Promo_Blocked' => 'IUC charges are not active for your account.',
            'Blacklist' => 'Black-listed number.',
            'Whitelist' => 'Opt-In account sends messages to a non white listed number',
            'Invalid Series' => 'Number format is invalid.',
            'Prepaid Reject' => 'Messages are rejected due to insufficient credits.',
            'Night_Expiry' => 'These messages have not been processed because of legal restrictions of sending messages late hours.',
            'Night_Purge' => 'These are promotional messages submitted between 9PM and 12AM which are not processed on request.',
            'EXP-AbsSubs' => 'The message is rejected because there was no paging response, the IMSI record is marked detached, or the MS is subject to roaming restrictions.',
            'EXP-MEM-EXCD' => 'Message rejected because the MS doesnt have enough memory.',
            'EXP-NW-FAIL' => 'Message rejected due to network failure.');

        $sms_from = "SperocHL";

        $sms_data = $this->input->get();
        $from = $sms_data['dest'];
        $to = '919730015484';
        $msg_key = $sms_data['reason'];
        $msg = $from.' '.$data_reasons[$msg_key];
        $stime = date('l jS \of F Y h:i:s A',strtotime($sms_data['stime']));
        $dtime = date('l jS \of F Y h:i:s A',strtotime($sms_data['dtime']));
        //die();
        //$to = trim($to, "+");

        $fp = fopen('ressms.txt', 'a+');

        $txt = "\n\url:" . $url . "\nUser:" . $sms_api_username .  "\nTo:" . $to . "\nMsg:" . $msg . "\nSent Time:" . $stime ."\nDelivary time".$dtime. "================================|\n";

        fwrite($fp, $txt);

        fclose($fp);



        if ($to != "" && $msg != "") {


            $parameter = array();

            $parameter['uname'] = $sms_api_username;

            $parameter['pass'] = $sms_api_password;

            $parameter['send'] = 'SperocHL';

            $parameter['dest'] = $to;

            $parameter['msg'] = $msg;

            $parameter['concat'] = '1';

            $parameter['prty'] = '1';

            $parameter['cs'] = '4';







            if (function_exists("curl_init") && $url) {



                $user_agent = $_SERVER['HTTP_USER_AGENT'];



                $ch = curl_init();



                if (is_array($parameter)) {



                    $query_string = http_build_query($parameter);
                } else {



                    $query_string = $parameter;
                }



                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);



                curl_setopt($ch, CURLOPT_POST, true);



                if ($parameter != "") {



                    curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
                }



                curl_setopt($ch, CURLOPT_URL, $url);



                $document = curl_exec($ch);



                curl_close($ch);



                $fp = fopen('ressms.txt', 'a+');



                fwrite($fp, $document);

                fclose($fp);



                return $document;
            }
        }
    }

}