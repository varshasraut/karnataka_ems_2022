<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';
class Latlong extends CI_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
    }
    public function index(){
        $url = "https://www.nuevastech.com/API/API_Dashboard_all.aspx?username=TDDAMBULANCE&accesskey=342EA5D59EC2D64112E1";

        $client = curl_init($url);

        curl_setopt($client,CURLOPT_RETURNTRANSFER,true);

        $respone = curl_exec($client);

        $result = json_decode($respone);
        foreach($result as $result1){
            $latlong1 = array(
                'ambulanceNo' => $result1->vehicleName,
                'status' => $result1->STATUS,
                'lat' => $result1->latitude,
                'log' => $result1->longitude,
                'speed' => $result1->speed,
                'ignition' => $result1->Ignition,
                'fuel' => $result1->fuel
            );
            $this->user->insertLatLong($latlong1);
        }
        
    }
}