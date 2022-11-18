<?php

defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Kolkata');


class EMS_Controller extends CI_Controller {

    public $active_menu;

    function __construct() {

        ini_set('default_charset', 'UTF-8');
        ini_set('session.gc_maxlifetime', 32400);
        ini_set('memory_limit', '-1');

        parent::__construct();



        $this->load->helper('url');

        $this->load->helper('cookie');
        $this->load->library('user_agent');



        $this->upload_path = $this->config->item('upload_path');

        $this->site_name = $this->config->item('site_name');

        $this->site = $this->config->item('site');

        $this->base_url = $this->config->item('base_url');

        $this->load->model(array('options_model', 'manufacture_model', 'common_model', 'med_model', 'eqp_model', 'inv_model','inc_model'));

        // $this->output->nocache();

        error_reporting(E_ALL & ~E_NOTICE);
    }

    function get_app_environment() {



        return APPLICATION_ENVIRONMENT;
    }

    function get_language() {



        return APPLICATION_LANGUAGE;
    }

    public function get_user_message() {



        if ($this->session->flashdata('warning')) {

            $this->warning = $this->session->flashdata('warning');
        }

        if ($this->session->flashdata('success')) {

            $this->success = $this->session->flashdata('success');
        }

        if ($this->session->flashdata('error')) {
            $this->error = $this->session->flashdata('error');
        }
    }

    public function set_user_message($message, $type = 'success') {



        $this->session->set_flashdata($type, $message);
    }

    function _send_email($to, $from, $subject, $message, $attachment = '') {

        $this->load->library('email');

        $config = $this->config->item('email_config');
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->to($to);
        $this->email->from($from);
        $this->email->subject($subject);
        $this->email->message($message);
        ($attachment != '') ? $this->email->attach($attachment, 'attachment') : "";


        $res = $this->email->send();
        
        if (! $this->email->send()){
            return $this->email->print_debugger();  
        } else{
              return 'Sent';
        }


    }
    function _send_smtp_email($to, $from, $subject, $message, $attachment = '') {

         $this->load->library('phpmailer_lib');
        
        // PHPMailer object
        $mail = $this->phpmailer_lib->load();
        
        $config = $this->config->item('smtp_email_config');
        
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host     = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mp104healthhelpline@gmail.com';
        $mail->Password = 'nuaobzkhdcbxaihz';
        $mail->SMTPSecure = false;
        $mail->Port     = 587;
        
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        
        $mail->setFrom($from, 'Health Helpline 104');
        $mail->addReplyTo($from, 'Health Helpline 104');
        
        // Add a recipient
        $mail->addAddress($to);
        
        
        // Email subject
        $mail->Subject = 'Complaint Follow up';
        
        // Set email format to HTML
        $mail->isHTML(true);
        
        // Email body content

        $mail->Body = $message;
        
        // Send email
        if(!$mail->send()){
            return 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            return 'Message has been sent';
        }


    }

    public function _send_curl_request($url, $parameter = '', $method = "get", $header = array("Content-Type: text/xml;charset=windows-1250")) {



        set_time_limit(0);



        if (function_exists("curl_init") && $url) {



            $user_agent = $_SERVER['HTTP_USER_AGENT'];



            $ch = curl_init();



            if (is_array($parameter)) {
                $query_string = http_build_query($parameter);
            } else {
                $query_string = $parameter;
            }

            curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookiesjar.txt');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

            if ($method == "post") {


                curl_setopt($ch, CURLOPT_POST, true);

                if ($parameter != "") {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
                }
            } else {

                curl_setopt($ch, CURLOPT_HTTPGET, 1);
                if ($parameter != "") {
                    $url = trim($url, "?") . "?" . $query_string;
                }
            }



            curl_setopt($ch, CURLOPT_URL, $url);
            $document = curl_exec($ch);
            curl_close($ch);



            return $document;
        }
    }

    public function _send_sms($to, $msg, $lang = "english") {
        $url = $this->config->item('sms_api_url');

        $sms_api_username = $this->config->item('sms_auth_user');

        $sms_api_password = $this->config->item('sms_auth_pass');

        $sms_from = "SperocHL";

        $to = trim($to, "+");

        $fp = fopen('sms.txt', 'a+');

        $txt = "\n\url:" . $url . "\nUser:" . $sms_api_username . "\nTo:" . $to . "\nMsg:" . $msg . "\nDate:" . date('l jS \of F Y h:i:s A') . "================================|\n";

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



                $fp = fopen('sms.txt', 'a+');



                fwrite($fp, $document);

                fclose($fp);



                return $document;
            }
        }
    }

    public function _filter_image($param = array()) {





        $new_img = $param['new_img'];



        $file_info = GetImageSize($new_img);

        $old_width = $file_info[0];

        $old_height = $file_info[1];



        $asp_ratio = $old_width / $old_height;



        $x1 = $y1 = 0;

        if ($old_width > $old_height) {



            $new_width = 100;

            $new_height = $new_width / $asp_ratio;

            $y = 100 - $new_height;

            $y1 = $y / 2;
        } else if ($old_width < $old_height) {



            $new_height = 100;

            $new_width = $new_height / $asp_ratio;

            $x = 100 - $new_width;

            $x1 = $x / 2;
        }



        $filename = basename($new_img);



        $exp = explode(".", $filename);



        $imp = $exp[0] . "_thumb" . "." . $exp[1];



        $type = $file_info['mime'];



        if ($type == "image/jpeg" || $type == "image/jpg") {

            $source_image = imagecreatefromjpeg($new_img);

            $type = "image/jpg";
        } elseif ($type == "image/png") {

            $source_image = imagecreatefrompng($new_img);

            $type = "image/png";
        } elseif ($type == "image/gif") {

            $source_image = imagecreatefromgif($new_img);

            $type = "image/gif";
        }



        //          header("Content-Type: $type");

        $im = @imagecreatetruecolor(100, 100);

        $white = imagecolorallocate($im, 255, 255, 255);

        imagefill($im, 0, 0, $white);



        $background_img_path = FCPATH . $this->upload_path . "/discount_img/thumb/" . $imp;



        imagecopyresampled($im, $source_image, $x1, $y1, 0, 0, $new_width, $new_height, $old_width, $old_height);



        if ($type == "image/jpeg" || $type == "image/jpg") {

            imagejpeg($im, $background_img_path);
        } elseif ($type == "image/png") {

            imagepng($im, $background_img_path);
        } elseif ($type == "image/gif") {

            imagegif($im, $background_img_path);
        }



        imagedestroy($im);
    }

    /*

     * 

     * This function used to download dummy csv file

     */

    public function download($name) {

        $file = $this->config->item('rsm_path') . "/" . $name;

        if ($file) {
            if (function_exists('finfo_open')) {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $content_type = finfo_file($finfo, $file);
                finfo_close($finfo);
            } else if (function_exists('mime_content_type')) {
                $content_type = mime_content_type($file);
            } else {
                $content_type = "application/octet-stream";
            }

            if (file_exists($file)) {
                header('Content-Description: File Download');
                header('Content-Type: ' . $content_type);
                header('Content-Disposition: attachment; filename=' . basename($file));
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                ob_clean();
                flush();
                readfile($file);
                exit;
            }
            die();
        } else {

            $this->output->message = "<div class='error'>Filed to get backup!!</div>";
        }
    }

    public function mi_random_string($length = 12, $type = '') {

        if ($type == 'numbers') {
            $randomnr = substr(str_shuffle("0123456789"), 0, $length);
        } else {
            $randomnr = substr(str_shuffle("0123456789abcdefghiMHlmnopqrstuvwxyzABCDEFGHIMHLMNOPQRSTUVWXYZ"), 0, $length);
        }

        return $randomnr;
    }

    /*     * ****  This function is added by mi13 to Send mail ************ */

    function send_email($reply_mail, $message, $email, $subject, $attachment = '') {

        $this->load->library('email');
        $config = $this->config->item('email_config');
        $this->email->initialize($config);
        $this->email->from($reply_mail);
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($message);
        ($attachment != '') ? $this->email->attach($attachment, 'attachment') : "";
        $res = $this->email->send();
        if (! $this->email->send())
            {

                return $this->email->print_debugger();

              
            } else{
              return 'Sent';
            }

    }

    public function time_date($time = "", $showtime = true, $showday = false) {



        $timepat = "";



        $daypat = "";



        if ($showtime) {

            $timepat = ", [g:i A]";
        }


        if ($showday) {
            $daypat = "l ";
        }

        if ($time != "") {
            $time_date = str_replace(array("``", "`^`"), array("<sup>", "</sup>"), date($daypat . "j``S`^` M  Y" . $timepat, $time));
        } else {
            $time_date = str_replace(array("``", "`^`"), array("<sup>", "</sup>"), date($daypat . "j``S`^` M  Y" . $timepat));
        }

        return $time_date;
    }

    public function get_base_month($curent_date = '') {

        if ($curent_date == '') {

            $curent_date = date("Y-m-d");
        }

        $result = $this->db->query("SELECT period_diff( date_format( '$curent_date' , '%Y%m' ) , date_format('2008-01-01' , '%Y%m' ) ) AS months");

        return $result;
    }

    ////////////////MI42////////////////////
    //

    //Purpose:Load addresses from google.
    //

    ////////////////////////////////////////





    function manage_addr() {

       

        $tab = $this->post['tab'];
        $data['dt_rel'] = $this->post['dt_rel'];
        
        $data['auto'] = $this->post['dt_auto_addr'];
        $data['ptn_ayu_id'] = $this->post['ptn_ayu_id'];
      
        
        //////////////////////////////////////////////////////////////////////////////////////////

        if ($this->post['dt_state']) {

             $this->post['loc_state'] = "Madhya Pradesh";
            if($this->post['loc_state'] == ''){
                $this->post['loc_state'] = "Madhya Pradesh";
                
//                $dist_array = array('Anantnag','Bandipora','Baramulla','Budgam','Doda','Ganderbal','Jammu','Kathua','Kishtwar','Kulgam','Kupwara','Poonch','Pulwama','Rajouri','Ramban','Reasi','Samba','Shopian','Srinagar','Udhampur');
//                if(in_array($this->post['loc_dist'],$dist_array)){
//                     $this->post['loc_state'] = "Maharashtra";
//                }
               
            }
            $state = $this->common_model->get_state(array('st_name' => $this->post['loc_state']));
            

            if (empty($state)) {

                $args = array(
                    'st_code' => $this->base_state[$this->post['loc_state']],
                    'st_name' => $this->post['loc_state']
                );
               // $state = $this->common_model->insert_state($args);
               // $state = $this->common_model->get_state(array('st_id' => $state));
            }



            ////////////////////////////////////////
            $data['st_code'] = $state[0]->st_code;
            $data['tab'] = ++$tab;
            $this->output->add_to_position($this->load->view('frontend/common/auto_state_view', $data, TRUE), $data['dt_rel'] . '_state', TRUE);
        }



        //////////////////////////////////////////////////////////////////////////////////////////



        if ($this->post['dt_dist']) {
            if( $this->post['loc_dist'] == 'Mumbai Suburban'){
                $this->post['loc_dist'] = "Mumbai";
            }
//            if( $this->post['loc_dist'] == 'Raigarh'){
//                $this->post['loc_dist'] = "Raigad";
//            }
            if( $this->post['loc_dist'] == 'Buldana'){
                $this->post['loc_dist'] = "buldhana";
            }
            $district = $this->common_model->get_district(array('st_id' => $state[0]->st_code, 'st_name' => $this->post['loc_dist']));
            $div_id = $district[0]->div_id;
        

            if (empty($district)) {

                //$district = $this->common_model->get_district(array('st_id' => $state[0]->st_code, 'order' => 'DESC'), 1, 0);
                $args = array(
                    'dst_name' => $this->post['loc_dist'],
                    'dst_state' => $state[0]->st_code,
                    'dst_code' => ($district[0]->dst_code) + 1
                    
                    
                );
                
                  //var_dump($this->post['dt_dist']);
        

                
                
                
                //$district = $this->common_model->insert_distrcit($args);
                //$district = $this->common_model->get_district(array('dst_id' => $district));
            }
    
             $division = $this->common_model->get_division(array('st_id' => $state[0]->st_code, 'div_code' =>$div_id));
             //var_dump($division);


            ////////////////////////////////////////
             
            $data['div_code'] = $division[0]->div_code;
            $data['div_name'] = $division[0]->div_name;
            $this->output->add_to_position($this->load->view('frontend/common/auto_div_view', $data, TRUE), $data['dt_rel'] . '_div', TRUE);



            $data['st_code'] = $state[0]->st_code;
            $data['dst_code'] = $district[0]->dst_code;
            $data['tab'] = ++$tab;
            $this->output->add_to_position($this->load->view('frontend/common/auto_dist_view', $data, TRUE), $data['dt_rel'] . '_dist', TRUE);
            
            $data['dist_code'] = $district[0]->dst_code;
            $this->output->add_to_position($this->load->view('frontend/inc/inc_temp_hospital_view', $data, TRUE), 'inc_temp_hospital', TRUE);
            
            $data['dist_code'] = $district[0]->dst_code;
            $this->output->add_to_position($this->load->view('frontend/inc/districtwise_hos_pvt_call', $data, TRUE), 'districtwise_hos', TRUE);
            
            $data['dist_code'] = $district[0]->dst_code;
             //$this->output->add_to_position($this->load->view('frontend/common/manual_ambulace_search', $data, TRUE), 'search_amb', TRUE);
              $this->output->add_to_position($this->load->view('frontend/common/manual_baselocation_search', $data, TRUE), 'search_amb', TRUE);
        }


        //////////////////////////////////////////////////////////////////////////////////////////
        
       // var_dump($this->input->post());

        //var_dump($this->post['dt_thl'] ); var_dump($this->post['dt_thl'] ); die();
        if ($this->post['dt_thl'] && $this->post['dt_thl'] != 'undefined' && $this->post['dt_thl'] != 'no') {
            //var_dump($this->post['dt_thl'] ); var_dump($this->post['dt_thl'] ); die();

            $tahsil = $this->common_model->get_tahshil(array('dst_code' => $district[0]->dst_code, 'thl_name' => $this->post['loc_thl']));


            if (empty($tahsil)) {

                $tahsil_max = $this->common_model->get_tahshil_max_code();
                $args = array(
                    'thl_name' => $this->post['loc_thl'],
                    'thl_district_code' => $district[0]->dst_code,
                    'thl_code' => $tahsil_max[0]->tahsil_code + 1
                );

                //$tahsil = $this->common_model->insert_tahsil($args);
               // $city = $this->common_model->get_tahshil(array('thl_id' => $tahsil));
            }



            ///////////////////////////////////////


            $data['thl_id'] = $tahsil[0]->thl_id;
            $data['dst_code'] = $district[0]->dst_code;
            $data['tab'] = ++$tab;
            $this->output->add_to_position($this->load->view('frontend/common/auto_tahsil_view', $data, TRUE), $data['dt_rel'] . '_tahsil', TRUE);
        } else {
            // var_dump($district[0]->dst_code);
            //  $tahsil = $this->common_model->get_tahshil(array('dst_code' =>  $district[0]->dst_code));   

            $data['dst_code'] = $district[0]->dst_code;
            $data['tab'] = ++$tab;
            $this->output->add_to_position($this->load->view('frontend/common/auto_tahsil_view', $data, TRUE), $data['dt_rel'] . '_tahsil', TRUE);
        }


        //////////////////////////////////////////////////////////////////////////////////////////

       

        if ($this->post['dt_city'] && $this->post['dt_city'] != 'no') {

            $city = $this->common_model->get_city(array('dist_code' => $district[0]->dst_code, 'cty_name' => $this->post['loc_city']));



            if (empty($city)) {

                if ($this->post['loc_city'] != 'yes') {
                    $args = array(
                        'cty_name' => $this->post['loc_city'],
                        'cty_dist_code' => $district[0]->dst_code
                    );

                   // $city = $this->common_model->insert_city($args);
                   // $city = $this->common_model->get_city(array('cty_id' => $city));
                }
            }



            ///////////////////////////////////////

            $data['cty_id'] = $city[0]->cty_id;
            $data['dst_code'] = $district[0]->dst_code;
            $data['tab'] = ++$tab;

            $this->output->add_to_position($this->load->view('frontend/common/auto_city_view', $data, TRUE), $data['dt_rel'] . '_city', TRUE);
        }



        //////////////////////////////////////////////////////////////////////////////////////////



        if ($this->post['dt_area']) {

            $data['area'] = ($this->post['loc_area'] != 'undefined') ? $this->post['loc_area'] : '';
            $data['tab'] = ++$tab;
            $this->output->add_to_position($this->load->view('frontend/common/auto_area_view', $data, TRUE), $data['dt_rel'] . '_area', TRUE);
        }



        //////////////////////////////////////////////////////////////////////////////////////////



        if ($this->post['dt_lmark']) {



            $data['landmark'] = ($this->post['loc_lmark'] != 'undefined') ? $this->post['loc_lmark'] : '';



            $data['tab'] = ++$tab;



            $this->output->add_to_position($this->load->view('frontend/common/auto_lmark_view', $data, TRUE), $data['dt_rel'] . '_lmark', TRUE);
        }



        //////////////////////////////////////////////////////////////////////////////////////////



        if ($this->post['dt_lane']) {



            $data['lane'] = ($this->post['loc_lane'] != 'undefined') ? $this->post['loc_lane'] : '';



            $data['tab'] = ++$tab;



            $this->output->add_to_position($this->load->view('frontend/common/auto_lane_view', $data, TRUE), $data['dt_rel'] . '_lane', TRUE);
        }



        //////////////////////////////////////////////////////////////////////////////////////////



        if ($this->post['dt_pin']) {



            $data['pincode'] = ($this->post['loc_pin'] != 'undefined') ? $this->post['loc_pin'] : '';



            $data['tab'] = ++$tab;



            $this->output->add_to_position($this->load->view('frontend/common/auto_pincode_view', $data, TRUE), $data['dt_rel'] . '_pcode', TRUE);
            $this->output->add_to_position($this->load->view('frontend/common/auto_pincode_view', $data, TRUE), $data['dt_rel'] . '_pin', TRUE);
        }

        if ($this->post['dt_lat']) {



            $data['latitude'] = ($this->post['dt_lat'] != 'undefined') ? $this->post['dt_lat'] : '';
         


            $data['tab'] = ++$tab;



            $this->output->add_to_position($this->load->view('frontend/common/auto_latitude_view', $data, TRUE), $data['dt_rel'] . '_lat', TRUE);
        }
           if ($this->post['dt_log']) {



            $data['longitude'] = ($this->post['dt_log'] != 'undefined') ? $this->post['dt_log'] : '';
         


            $data['tab'] = ++$tab;



            $this->output->add_to_position($this->load->view('frontend/common/auto_longitude_view', $data, TRUE), $data['dt_rel'] . '_log', TRUE);
        }
        
        $data['dist_code'] = $district[0]->dst_code;
        $cm_id =  $this->post['chief_complete'];
        $data['chief_comps_services'] = $this->inc_model->get_chief_comp_service($cm_id);
        
        $data['ct_hosp_pri_one'] = $data['chief_comps_services'][0]->ct_hosp_pri_one;
        $this->output->add_to_position($this->load->view('frontend/inc/hospital_priority_based', $data, TRUE), 'inc_one_temp_hospital', TRUE);
        
        $data['ct_hosp_pri_two'] = $data['chief_comps_services'][0]->ct_hosp_pri_two;
        $this->output->add_to_position($this->load->view('frontend/inc/hospital_priority_two_based', $data, TRUE), 'inc_two_temp_hospital', TRUE);
    }

    ////////////////MI42////////////////////
    //

    //Purpose:Load auto district.
    //

    ////////////////////////////////////////



    function auto_dist() {



        $data['st_code'] = $this->post['st_code'];



        $data['auto'] = $this->post['auto'];



        $data['dt_rel'] = $this->post['dt_rel'];



        $data['tab'] = $this->post['tab'] + 1;



        $this->output->add_to_position($this->load->view('frontend/common/auto_dist_view', $data, TRUE), $data['dt_rel'] . "_dist", TRUE);



        $data['tab'] = $this->post['tab'] + 2;



        $this->output->add_to_position($this->load->view('frontend/common/auto_city_view', $data, TRUE), $data['dt_rel'] . "_city", TRUE);

        $data['tab'] = $this->post['tab'] + 2;

        $this->output->add_to_position($this->load->view('frontend/common/auto_tahsil_view', $data, TRUE), $data['dt_rel'] . "_tahsil", TRUE);
    }

    ////////////////////////////////
    //

    //Purpose:Load auto district tahsil.
    //

    ////////////////////////////////////////

    function auto_dist_tahsil() {



        $data['st_code'] = $this->post['st_code'];



        $data['auto'] = $this->post['auto'];



        $data['dt_rel'] = $this->post['dt_rel'];



        $data['tab'] = $this->post['tab'] + 1;



        $this->output->add_to_position($this->load->view('frontend/common/auto_dist_tal_view', $data, TRUE), $data['dt_rel'] . "_dist", TRUE);


        $data['tab'] = $this->post['tab'] + 2;

        $this->output->add_to_position($this->load->view('frontend/common/auto_tahsil_view', $data, TRUE), $data['dt_rel'] . "_tahsil", TRUE);
    }
	
	function get_district_by_div(){
        $div_code = $this->post['st_code'];
        $data['div_code'] = $this->post['st_code'];
        $data['auto'] = $this->post['auto'];
        $data['dt_rel'] = $this->post['dt_rel'];
        $data['tab'] = $this->post['tab'] + 1;
        //var_dump($data['dt_rel']);

        
        $this->output->add_to_position($this->load->view('frontend/common/auto_district_by_div', $data, TRUE), $data['dt_rel'] . "_dist", TRUE);
        
    }

    function auto_district() {



        $data['st_code'] = $this->post['st_code'];



        $data['auto'] = $this->post['auto'];



        $data['dt_rel'] = $this->post['dt_rel'];



        $data['tab'] = $this->post['tab'] + 1;

        $this->output->add_to_position($this->load->view('frontend/common/auto_district_view', $data, TRUE), $data['dt_rel'] . "_dist", TRUE);
    }

    function auto_closer_district() {



        $data['st_code'] = $this->post['st_code'];



        $data['auto'] = $this->post['auto'];



        $data['dt_rel'] = $this->post['dt_rel'];



        $data['tab'] = $this->post['tab'] + 1;

        $this->output->add_to_position($this->load->view('frontend/common/auto_closer_district_view', $data, TRUE), $data['dt_rel'] . "_district", TRUE);
    }

    function auto_break_maint_district() {



        $data['st_code'] = $this->post['st_code'];



        $data['auto'] = $this->post['auto'];



        $data['dt_rel'] = $this->post['dt_rel'];



        $data['tab'] = $this->post['tab'] + 1;

        $this->output->add_to_position($this->load->view('frontend/common/auto_break_district_view', $data, TRUE), $data['dt_rel'] . "_district", TRUE);
    }
      function auto_preventive_district() {



        $data['st_code'] = $this->post['st_code'];



        $data['auto'] = $this->post['auto'];



        $data['dt_rel'] = $this->post['dt_rel'];



        $data['tab'] = $this->post['tab'] + 1;

        $this->output->add_to_position($this->load->view('frontend/common/auto_preventive_district_view', $data, TRUE), $data['dt_rel'] . "_district", TRUE);
    }
    function auto_fuel_closer_district() {



        $data['st_code'] = $this->post['st_code'];



        $data['auto'] = $this->post['auto'];



        $data['dt_rel'] = $this->post['dt_rel'];



        $data['tab'] = $this->post['tab'] + 1;

        $this->output->add_to_position($this->load->view('frontend/common/auto_fuel_dis_view', $data, TRUE), $data['dt_rel'] . "_district", TRUE);
    }
    function auto_oxygen_closer_district() {
        $data['st_code'] = $this->post['st_code'];
        $data['auto'] = $this->post['auto'];
        $data['dt_rel'] = $this->post['dt_rel'];
        $data['tab'] = $this->post['tab'] + 1;
        $this->output->add_to_position($this->load->view('frontend/common/auto_oxygen_dis_view', $data, TRUE), $data['dt_rel'] . "_district", TRUE);
        
    }
       function auto_vahicle_closer_district() {
        $data['st_code'] = $this->post['st_code'];
        $data['auto'] = $this->post['auto'];
        $data['dt_rel'] = $this->post['dt_rel'];
        $data['tab'] = $this->post['tab'] + 1;

        $this->output->add_to_position($this->load->view('frontend/common/auto_vahicle_dis_view', $data, TRUE), $data['dt_rel'] . "_district", TRUE);
        
    }
        function auto_demo_closer_district() {



        $data['st_code'] = $this->post['st_code'];



        $data['auto'] = $this->post['auto'];



        $data['dt_rel'] = $this->post['dt_rel'];



        $data['tab'] = $this->post['tab'] + 1;

        $this->output->add_to_position($this->load->view('frontend/common/auto_demo_dis_view', $data, TRUE), $data['dt_rel'] . "_district", TRUE);
        
    }
    function auto_acc_closer_district() {



        $data['st_code'] = $this->post['st_code'];



        $data['auto'] = $this->post['auto'];



        $data['dt_rel'] = $this->post['dt_rel'];



        $data['tab'] = $this->post['tab'] + 1;
          
        $this->output->add_to_position($this->load->view('frontend/common/auto_acc_dis_view', $data, TRUE), $data['dt_rel'] . "_district", TRUE);
    }
    function auto_inspection_closer_district() {
        
        $data['st_code'] = $this->post['st_code'];



        $data['auto'] = $this->post['auto'];



        $data['dt_rel'] = $this->post['dt_rel'];



        $data['tab'] = $this->post['tab'] + 1;
          
        $this->output->add_to_position($this->load->view('frontend/common/auto_inspection_dis_view', $data, TRUE), $data['dt_rel'] . "_district", TRUE);
    
    }
        function auto_accident_closer_district() {



        $data['st_code'] = $this->post['st_code'];



        $data['auto'] = $this->post['auto'];



        $data['dt_rel'] = $this->post['dt_rel'];



        $data['tab'] = $this->post['tab'] + 1;
          
        $this->output->add_to_position($this->load->view('frontend/common/auto_accidental_dis_view', $data, TRUE), $data['dt_rel'] . "_district", TRUE);
    }
    function auto_tyre_closer_district() {



        $data['st_code'] = $this->post['st_code'];



        $data['auto'] = $this->post['auto'];



        $data['dt_rel'] = $this->post['dt_rel'];



        $data['tab'] = $this->post['tab'] + 1;
          
        $this->output->add_to_position($this->load->view('frontend/common/auto_tyre_dis_view', $data, TRUE), $data['dt_rel'] . "_district", TRUE);
    }

    function auto_police_district() {



        $data['st_code'] = $this->post['st_code'];



        $data['auto'] = $this->post['auto'];



        $data['dt_rel'] = $this->post['dt_rel'];



        $data['tab'] = $this->post['tab'] + 1;

        $this->output->add_to_position($this->load->view('frontend/common/auto_police_district_view', $data, TRUE), $data['dt_rel'] . "_dist", TRUE);
    }
    
    function auto_police_tahsil() {



        $data['dst_code'] = $this->post['dst_code'];



        $data['auto'] = $this->post['auto'];



        $data['dt_rel'] = $this->post['dt_rel'];



        $data['tab'] = $this->post['tab'] + 1;

        $this->output->add_to_position($this->load->view('frontend/common/auto_police_tahsil_view', $data, TRUE), $data['dt_rel'] . "_tahsil", TRUE);
    }

    function auto_fire_district() {



        $data['st_code'] = $this->post['st_code'];



        $data['auto'] = $this->post['auto'];



        $data['dt_rel'] = $this->post['dt_rel'];



        $data['tab'] = $this->post['tab'] + 1;

        $this->output->add_to_position($this->load->view('frontend/common/auto_fire_district_view', $data, TRUE), $data['dt_rel'] . "_dist", TRUE);
    }

    function auto_police_station() {



        $data['dst_code'] = $this->post['dst_code'];



        $data['auto'] = $this->post['auto'];



        $data['dt_rel'] = $this->post['dt_rel'];



        $data['tab'] = $this->post['tab'] + 1;

        $this->output->add_to_position($this->load->view('frontend/common/auto_police_station_view', $data, TRUE), $data['dt_rel'] . "_police", TRUE);
    }

    function auto_fire_station() {



        $data['dst_code'] = $this->post['dst_code'];
        $data['f_tahsil'] = $this->post['dst_code'];
    


        $data['auto'] = $this->post['auto'];



        $data['dt_rel'] = $this->post['dt_rel'];



        $data['tab'] = $this->post['tab'] + 1;

        $this->output->add_to_position($this->load->view('frontend/common/auto_fire_station_view', $data, TRUE), $data['dt_rel'] . "_police", TRUE);
    }
    
    function auto_fire_tahsil() {


        $data['thl_id'] = $this->post['thl_id'];
        $data['dst_code'] = $this->post['dst_code'];



        $data['auto'] = $this->post['auto'];



        $data['dt_rel'] = $this->post['dt_rel'];



        $data['tab'] = $this->post['tab'] + 1;

        $this->output->add_to_position($this->load->view('frontend/common/auto_fire_tahsil_views', $data, TRUE), $data['dt_rel'] . "_tahsil", TRUE);
    }

    function auto_dist_ambulance() {



        $data['dst_code'] = $this->post['st_code'];



        $data['auto'] = $this->post['auto'];



        $data['dt_rel'] = $this->post['dt_rel'];



        $data['tab'] = $this->post['tab'] + 1;



        $this->output->add_to_position($this->load->view('frontend/common/auto_dist_amb_view', $data, TRUE), $data['dt_rel'] . "_ambulance", TRUE);


        $data['tab'] = $this->post['tab'] + 2;

        $this->output->add_to_position($this->load->view('frontend/common/auto_tahsil_view', $data, TRUE), $data['dt_rel'] . "_tahsil", TRUE);
    }

    ////////////////MI42////////////////////
    //

    //Purpose:Load auto city.
    //

    ////////////////////////////////////////



    function auto_city() {



        $data['dst_code'] = $this->post['dst_code'];



        $data['auto'] = $this->post['auto'];



        $data['dt_rel'] = $this->post['dt_rel'];



        $data['tab'] = $this->post['tab'] + 1;



        $this->output->add_to_position($this->load->view('frontend/common/auto_city_view', $data, TRUE), $data['dt_rel'] . "_city", TRUE);
    }

    function auto_city_tahsil() {



        $data['thshil_code'] = $this->post['thshil_code'];



        $data['auto'] = $this->post['auto'];



        $data['dt_rel'] = $this->post['dt_rel'];



        $data['tab'] = $this->post['tab'] + 1;



        $this->output->add_to_position($this->load->view('frontend/common/auto_city_tahsil_view', $data, TRUE), $data['dt_rel'] . "_city", TRUE);
    }

    function auto_tal() {
        $data['dst_code'] = $this->post['st_code'];
        $data['auto'] = $this->post['auto'];
        $data['dt_rel'] = $this->post['dt_rel'];
        $data['tab'] = $this->post['tab'] + 1;
        $this->output->add_to_position($this->load->view('frontend/common/auto_tahsil_view', $data, TRUE), $data['dt_rel'] . "_tahsil", TRUE);
    }

    function auto_amb() {

        $data['dst_code'] = $this->post['st_code'];
        $data['auto'] = $this->post['auto'];
        $data['dt_rel'] = $this->post['dt_rel'];
        $data['tab'] = $this->post['tab'] + 1;
        $this->output->add_to_position($this->load->view('frontend/common/auto_amb_view', $data, TRUE), $data['dt_rel'] . "_ambulance", TRUE);
    }

    function auto_closer_amb() {

        $data['dst_code'] = $this->post['st_code'];
        $data['auto'] = $this->post['auto'];
        $data['dt_rel'] = $this->post['dt_rel'];
        $data['amb_type'] = $this->post['amb_type'];
        $data['tab'] = $this->post['tab'] + 1;
        $this->output->add_to_position($this->load->view('frontend/common/auto_amb_closer_view', $data, TRUE), $data['dt_rel'] . "_ambulance", TRUE);
    }
    function auto_closer_amb_gri() {

        $data['dst_code'] = $this->post['st_code'];
        $data['auto'] = $this->post['auto'];
        $data['dt_rel'] = $this->post['dt_rel'];
        $data['amb_type'] = $this->post['amb_type'];
        $data['tab'] = $this->post['tab'] + 1;
        $this->output->add_to_position($this->load->view('frontend/common/auto_amb_closer_view_gri', $data, TRUE), $data['dt_rel'] . "_ambulance", TRUE);
    }
    function auto_preventive_amb() {

        $data['dst_code'] = $this->post['st_code'];
        $data['auto'] = $this->post['auto'];
        $data['dt_rel'] = $this->post['dt_rel'];
        $data['amb_type'] = $this->post['amb_type'];
        $data['tab'] = $this->post['tab'] + 1;
        $this->output->add_to_position($this->load->view('frontend/common/auto_preventive_closer_view', $data, TRUE), $data['dt_rel'] . "_ambulance", TRUE);
        $this->output->add_to_position($this->load->view('frontend/common/district_work_shop_view', $data, TRUE), "ambulance_work_shop", TRUE);
    }
    
    function auto_onroad_offroad_district(){
        $data['st_code'] = $this->post['st_code'];
        $data['auto'] = $this->post['auto'];
        $data['dt_rel'] = $this->post['dt_rel'];
        $data['tab'] = $this->post['tab'] + 1;

        $this->output->add_to_position($this->load->view('frontend/common/auto_onroad_offroad_district_view', $data, TRUE), $data['dt_rel'] . "_district", TRUE);
    }
    function auto_onroad_offroad_amb() {

        $data['dst_code'] = $this->post['st_code'];
        $data['auto'] = $this->post['auto'];
        $data['dt_rel'] = $this->post['dt_rel'];
        $data['tab'] = $this->post['tab'] + 1;
        $this->output->add_to_position($this->load->view('frontend/common/auto_amb_onroad_offroad_view', $data, TRUE), $data['dt_rel'] . "_ambulance", TRUE);
    }

    function auto_acc_amb() {

        $data['dst_code'] = $this->post['st_code'];
        $data['auto'] = $this->post['auto'];
        $data['dt_rel'] = $this->post['dt_rel'];
        $data['tab'] = $this->post['tab'] + 1;
        $this->output->add_to_position($this->load->view('frontend/common/auto_amb_acc_view', $data, TRUE), $data['dt_rel'] . "_ambulance", TRUE);
    }
    function auto_inspection_amb(){
        $data['dst_code'] = $this->post['st_code'];
        $data['auto'] = $this->post['auto'];
        $data['dt_rel'] = $this->post['dt_rel'];
        $data['tab'] = $this->post['tab'] + 1;
        $this->output->add_to_position($this->load->view('frontend/common/auto_amb_inspection_view', $data, TRUE), $data['dt_rel'] . "_ambulance", TRUE);
    
    }
        function auto_accidental_amb() {

        $data['dst_code'] = $this->post['st_code'];
        $data['auto'] = $this->post['auto'];
        $data['dt_rel'] = $this->post['dt_rel'];
        $data['tab'] = $this->post['tab'] + 1;
        $this->output->add_to_position($this->load->view('frontend/common/auto_amb_accidental_view', $data, TRUE), $data['dt_rel'] . "_ambulance", TRUE);
    }
    function auto_tyre_amb() {

        $data['dst_code'] = $this->post['st_code'];
        $data['auto'] = $this->post['auto'];
        $data['dt_rel'] = $this->post['dt_rel'];
        $data['tab'] = $this->post['tab'] + 1;
        $this->output->add_to_position($this->load->view('frontend/common/auto_amb_tyre_view', $data, TRUE), $data['dt_rel'] . "_ambulance", TRUE);
    }
    function auto_fuel_closer_amb() {

        $data['dst_code'] = $this->post['st_code'];
        $data['auto'] = $this->post['auto'];
        $data['dt_rel'] = $this->post['dt_rel'];
        $data['tab'] = $this->post['tab'] + 1;
        $this->output->add_to_position($this->load->view('frontend/common/auto_amb_fuel_view', $data, TRUE), $data['dt_rel'] . "_ambulance", TRUE);
    }  
         function auto_oxygen_closer_amb() {

        $data['dst_code'] = $this->post['st_code'];
        $data['auto'] = $this->post['auto'];
        $data['dt_rel'] = $this->post['dt_rel'];
        $data['tab'] = $this->post['tab'] + 1;
        $this->output->add_to_position($this->load->view('frontend/common/auto_amb_oxygen_view', $data, TRUE), $data['dt_rel'] . "_ambulance", TRUE);
    }  
    function auto_vahicle_closer_amb() {

        $data['dst_code'] = $this->post['st_code'];
        $data['auto'] = $this->post['auto'];
        $data['dt_rel'] = $this->post['dt_rel'];
        $data['tab'] = $this->post['tab'] + 1;
        $this->output->add_to_position($this->load->view('frontend/common/auto_amb_vahicle_view', $data, TRUE), $data['dt_rel'] . "_ambulance", TRUE);
    } 
    function auto_demo_clo_amb() {

        $data['dst_code'] = $this->post['st_code'];
        $data['auto'] = $this->post['auto'];
        $data['dt_rel'] = $this->post['dt_rel'];
        $data['tab'] = $this->post['tab'] + 1;
        $this->output->add_to_position($this->load->view('frontend/common/auto_amb_demo_view', $data, TRUE), $data['dt_rel'] . "_ambulance", TRUE);
    } 
    function auto_break_clo_amb() {

        $data['dst_code'] = $this->post['st_code'];
        $data['auto'] = $this->post['auto'];
        $data['dt_rel'] = $this->post['dt_rel'];
        $data['tab'] = $this->post['tab'] + 1;
        $this->output->add_to_position($this->load->view('frontend/common/auto_amb_break_view', $data, TRUE), $data['dt_rel'] . "_ambulance", TRUE);
    } 
    function auto_base_location() {

        $data['amb_id'] = $this->post['amb_id'];
        $data['auto'] = $this->post['auto'];
        $data['dt_rel'] = $this->post['dt_rel'];
        $data['tab'] = $this->post['tab'] + 1;
        $this->output->add_to_position($this->load->view('frontend/common/auto_base_location', $data, TRUE), $data['dt_rel'] . "_base_location", TRUE);
    }

    function get_auto_po() {

        $data['atc_id'] = $this->post['atc_id'];
        $data['tab'] = $this->post['tab'] + 1;

        $this->output->add_to_position($this->load->view('frontend/common/auto_po_view', $data, TRUE), 'get_auto_po_by_atc', TRUE);
    }
    function auto_ward(){
        $data['dst_code'] = $this->post['dst_code'];
$this->output->add_to_position($this->load->view('frontend/common/auto_ward_view', $data, TRUE), $data['dt_rel'] . "ward_name", TRUE);
   
    }

}
