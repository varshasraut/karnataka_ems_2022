<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Cqmessage extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('Cq_model');
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
        $type = $this->post('type');
        $vehicle = $this->post('vehicleNumber');
        $veh = explode(' ',$vehicle);
        $vehicleNumber = implode('-',$veh);
        $id = $this->encryption->decrypt($_COOKIE['cookie']);
        $chklogindata = $this->user->getId($id,$type);
        $deviceId = $this->encryption->decrypt($_COOKIE['deviceId']);
        $deviceIdLogin = $this->user->checkDeviceLogin($deviceId);
        if($chklogindata == 1 || (empty($deviceIdLogin))){
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $rec = $this->Cq_model->get_cq_data($vehicleNumber);
            $img = array();
            $url = base_url().'cq_images_video/';
            if(!empty($rec)){
                foreach($rec as $key=>$rec1){
                    $imgs = explode(",",$rec1['cq_images']);
                    $imgage = array();
                    if(!empty($imgs[0])){
                        foreach($imgs as $key1=>$img1){
                            // $imgpath = array(
                            //     'img' => $url.$img1
                            // );
                            $imgpath =  $url.$img1;
                            array_push($imgage,$imgpath);
                        }
                    }
                    $imgg[$key]['img'] = $imgage;
                    $imgg[$key]['vid'] = isset($rec1['cq_video']) ? $url.$rec1['cq_video'] : '';
                    $imgg[$key]['msg'] = isset($rec1['cq_msg']) ? $rec1['cq_msg'] : '';
                }
            }
        }
        $this->response([
            'data' => $imgg,
            'error' => null
        ],REST_Controller::HTTP_OK);
    }
    public function cqnotification_post(){
        $php_input =  file_get_contents( 'php://input' );
        $post = json_decode($php_input);
        if(json_last_error()){ return false; }
        file_put_contents('./logs/notification.log', $php_input);
        define('API_ACCESS_KEY','AAAAdHbcA2w:APA91bGpaFIHWqD35tEQR0suCf_IRdOysTOvMsObjFgeIzGS_G2daBJjmRJrNyzQ13R5wrqBI9iVUTm-Ns_pIcs2R__m1s48RBNl__1FkFoQWAyUMZ4OPsDHNFg0a_rd2F9lXhHfInQB');
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $amb_no =$post->ambulanceNo;
        $data = $this->user->chkUserLogin($amb_no);
        for($i=0;$i<count($data);$i++){
            $token = $data[$i][0]['token'];
            $notification = [
                'title' => 'New Notification',
                'type' => 'CQ',
                'message' => 'New Message From ERC Department'
            ];
            $fcmNotification = [
                'to'        => $token,
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
    }
}