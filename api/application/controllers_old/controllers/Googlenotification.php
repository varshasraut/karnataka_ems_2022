<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Googlenotification extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
        $php_input =  file_get_contents( 'php://input' );
        $post = json_decode($php_input);
        //var_dump($post);
        
        if(json_last_error()){ return false; }
       
        file_put_contents('./logs/notification.log', $php_input);
        
        define('API_ACCESS_KEY','AAAAdHbcA2w:APA91bGpaFIHWqD35tEQR0suCf_IRdOysTOvMsObjFgeIzGS_G2daBJjmRJrNyzQ13R5wrqBI9iVUTm-Ns_pIcs2R__m1s48RBNl__1FkFoQWAyUMZ4OPsDHNFg0a_rd2F9lXhHfInQB');
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        // $data = $this->user->getLoginAmb();
        $amb_no =$post->ambulanceNo;
        // $token = $this->post('token');
        $incidentId = $post->incidentId;
        $cheifComplaint = $post->cheifComplaint;
        $data = $this->user->chkUserLogin($amb_no);
        
        for($i=0;$i<count($data);$i++){
            $token = $data[$i][0]['token'];
            // $incidentId = $data1['inc_ref_id'];
            // print_r($token);
            $notification = [
                'title' =>'Assined New Incident Id',
                'type' =>'Call',
                'incidentId' => $incidentId,
                'discription' => 'Incident Id : '.$incidentId,
                'message' => 'New Incident Assigned',
                'ambulanceNo' => $amb_no,
                'cheifComplaint' => $cheifComplaint
            ];
            // $extraNotificationData = ["message" => $notification,"moredata" =>'dd'];

            $fcmNotification = [
                //'registration_ids' => $tokenList, //multiple token array
                'to'        => $token, //single token
                // 'notification' => $notification,
                'data' => $notification
            ];

            $headers = [
                'Authorization: key=' . API_ACCESS_KEY,
                'Content-Type: application/json'
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$fcmUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
            $result = curl_exec($ch);
            curl_close($ch);


            echo $result;
        }
        // print_r($data);die;
        
        // define('API_ACCESS_KEY','AAAAdHbcA2w:APA91bGpaFIHWqD35tEQR0suCf_IRdOysTOvMsObjFgeIzGS_G2daBJjmRJrNyzQ13R5wrqBI9iVUTm-Ns_pIcs2R__m1s48RBNl__1FkFoQWAyUMZ4OPsDHNFg0a_rd2F9lXhHfInQB');
        // $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        // $token='ejhRMqZw72I:APA91bFSP3ZH01B5dW7akvxNuDPEUjFPWPboo6wCFkR31fBUyLXpSTIrMW1O-aug6E9KyFV0vTIqZ_htvoyoLO64TC4mr79svFMZH51B5GNtNMkOf0y41af36K7Qdf76gqDCEDrPQHM2';

        // $notification = [
        //     'title' =>'New Incident Details',
        //     'body' => 'Incident Details',
        // ];
        // $extraNotificationData = ["message" => $notification,"moredata" =>'dd'];

        // $fcmNotification = [
        //     //'registration_ids' => $tokenList, //multiple token array
        //     'to'        => $token, //single token
        //     'notification' => $notification,
        //     'data' => $extraNotificationData
        // ];

        // $headers = [
        //     'Authorization: key=' . API_ACCESS_KEY,
        //     'Content-Type: application/json'
        // ];

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        // $result = curl_exec($ch);
        // curl_close($ch);


        // echo $result;
    }
}