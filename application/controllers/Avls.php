<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Avls extends EMS_Controller{

    function __construct() {

        parent::__construct();
        $this->active_module = "M-AVLS";

        $this->pg_limit = $this->config->item('pagination_limit');



        $this->gps_url = $this->config->item('amb_gps_url');

        $this->gps_url_pcmc = $this->config->item('amb_gps_url_pcmc');
        $this->gps_url_pmc = $this->config->item('amb_gps_url_pmc');
        $this->gps_url_Ahmednagar = $this->config->item('amb_gps_url_Ahmednagar');


        $this->load->model(array('colleagues_model', 'get_city_state_model', 'options_model', 'module_model', 'amb_model', 'inc_model', 'pcr_model','hp_model','Avls_model'));



        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper'));



        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));



        $this->post = $this->input->get_post(NULL);



        if ($this->post['filters'] == 'reset') {

            $this->session->unset_userdata('filters')['AMB'];
        }



        if ($this->session->userdata('filters')['AMB']) {

            $this->fdata = $this->session->userdata('filters')['AMB'];
        }
        $this->post['base_month'] = get_base_month();
        $this->clg = $this->session->userdata('current_user');
    }
    public function index(){
        $this->output->add_to_position($this->load->view('avls/vehicle_tracking', $data, TRUE), 'content', TRUE);
    }
    function vehicle(){
        // var_dump('hii');die;
       // $data['vehicle']='1';
        $data['amb'] = $this->Avls_model->get_ambulance();
        // var_dump($data['amb']);die;
        $args['ambNo'] = $this->input->post('vehicleNo');
        $args['frm_date'] = $this->input->post('frm_date');
        if($args['ambNo'] != '' && $args['frm_date'] != '')
        {
            $data = $this->Avls_model->getAmbWiseLatLng($args);
            $a = array();
            $inctabel = array();
            foreach($data as $key => $value){
                $data2 = '['.$value['lat'].','.$value['long'].']';
                array_push($a,$data2);
                $intbl['vehicleNumber'] = $value['vehicleNumber'];
                $intbl['speed'] = (int) $value['speed'];
                $intbl['date'] = date("d-m-Y", strtotime($value['packetdatetime']));
                $intbl['time'] = date("H:i:s", strtotime($value['packetdatetime']));
                $intbl['lat'] = $value['lat'];
                $intbl['long'] = $value['long'];
                $place = $this->placename($intbl['lat'],$intbl['long']);
                $intbl['placename'] = $place->Response->View[0]->Result[0]->Location->Address->Label;
                array_push($inctabel,$intbl);
            }
            $data1['inctabel'] = json_encode($inctabel);
            if(!empty($a)){
                $data1['latlong'] = implode(',',$a);
            }else{
                $data1['latlong'] = '1';
            }
            $this->output->add_to_position($this->load->view('avls/vehicle_tracking_view', $data1, TRUE), 'vehiclediv', TRUE);
            $this->output->template = "emt";
        }else{
            $this->output->add_to_position($this->load->view('avls/vehicle_tracking_view', $data, TRUE), 'vehiclediv', TRUE);
            $this->output->template = "emt";
        }
    }
    function incident(){
        // $data['vehicle']='2';
        $args['incidentId'] = $this->input->post('incidentid');
        // print_r($args['incidentId']);
        if($args['incidentId'] != '')
        {
            $data = $this->Avls_model->getIncidentWiseLatLng($args);
            $a = array();
            $inctabel = array();
            foreach($data as $key => $value){
                $data2 = '['.$value['lat'].','.$value['long'].']';
                array_push($a,$data2);
                $intbl['vehicleNumber'] = $value['vehicleNumber'];
                $intbl['speed'] = (int) $value['speed'];
                $intbl['date'] = date("d-m-Y", strtotime($value['packetdatetime']));
                $intbl['time'] = date("H:i:s", strtotime($value['packetdatetime']));
                $intbl['lat'] = $value['lat'];
                $intbl['long'] = $value['long'];
                $place = $this->placename($intbl['lat'],$intbl['long']);
                $intbl['placename'] = $place->Response->View[0]->Result[0]->Location->Address->Label;
                array_push($inctabel,$intbl);
            }
            $data1['inctabel'] = json_encode($inctabel);
            if(!empty($a)){
                $data1['latlong'] = implode(',',$a);
                // echo $data1;die;
            }else{
                $data1['latlong'] = '1';
            }
            $this->output->add_to_position($this->load->view('avls/incident_tracking_view', $data1, TRUE), 'incidentdiv', TRUE);
            $this->output->template = "emt";
        }else{
            $this->output->add_to_position($this->load->view('avls/incident_tracking_view', $data, TRUE), 'incidentdiv', TRUE);
            $this->output->template = "emt";
        }
    }
    function placename($lat,$long){
        // echo $lat;
        $url = "https://reverse.geocoder.ls.hereapi.com/6.2/reversegeocode.json?prox=$lat%2C$long%2C1000&mode=retrieveLandmarks&gen=9&apiKey=yrjPrIYd0xU9KJpe1xlaR1_K1wFrwc9U-_-99n040JQ";
        // print_r($url);
        //  Initiate curl
        $ch = curl_init();
        // Disable SSL verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($ch, CURLOPT_URL,$url);
        // Execute
        $result=curl_exec($ch);
        // Closing
        curl_close($ch);

        // Print the return data
        return json_decode($result);

    }
    function get_ambulance(){
        $term = trim($this->input->get_post('term', TRUE));
       // var_dump($term);
        $data = $this->Avls_model->get_ambulance(array('term' => $term));
        if ($data) {

            foreach ($data as $district) {

                $data1[] = array("id" => $district->amb_rto_register_no, "label" => $district->amb_rto_register_no, "value" => $district->amb_rto_register_no);
            }
        }
        echo json_encode($data1);
        die;
    }
    function live_tracking(){
        $args['vehicleNo'] = $this->input->post('vehicleNo');
        // print_r($args['vehicleNo']);
        if($this->session->flashdata('vehicleNo') != ''){
            // $this->session->flashdata('vehicleNo');die;
            $this->session->unset_flashdata('vehicleNo');
        }
        $this->session->set_flashdata('vehicleNo',$args['vehicleNo']);
        
        if($args['vehicleNo'] != '')
        {
            $data = $this->Avls_model->get_live_tracking_data($args);
            $latlng = [];
            foreach($data as $value) {
                $latlng = [$value->lat, $value->long];  
            }
            $data1['latlong'] = $latlng;
            $this->output->add_to_position($this->load->view('avls/live_tracking_view', $data1, TRUE), 'livetrackingdiv', TRUE);
            $this->output->template = "emt";
        }else{
            $this->output->add_to_position($this->load->view('avls/live_tracking_view', $data, TRUE), 'livetrackingdiv', TRUE);
            $this->output->template = "emt";
        }
        
    }
    function get_live_data(){
        $args['vehicleNo'] = $this->input->post('veh');
        $args['user'] = $this->input->post('user');
        // print_r($args['vehicleNo']);die;
        $data = $this->Avls_model->get_live_tracking_data1($args);
        $latlng = array();
        foreach($data as $value) {
            // $latlng = [$value->lat, $value->long];
            $latlng1 = array(
                'amb_rto_register_no' => $value->vehicleNumber,
                'amb_lat' => $value->lat,
                'amb_log' => $value->long
            );  
            array_push($latlng,$latlng1);
        }
        // $data1['latlong'] = $latlng;
        echo json_encode($latlng);
        die();
    }
    function get_all_live_data(){
        $args['vehicleNo'] = $this->input->post('veh');
        $args['pilot'] = $this->input->post('pilot');
        $args['emt'] = $this->input->post('emt');
        // print_r($args['vehicleNo']);die;
        $pilot = $this->Avls_model->get_all_pilot_live_tracking_data($args);
        $emt = $this->Avls_model->get_all_emt_live_tracking_data($args);
        $amb = $this->Avls_model->get_all_amb_live_tracking_data($args);
        $data['pilot1'] = array();
        if(!empty($pilot)){
            foreach($pilot as $value) {
                $pilot2 = array(
                    'amb_rto_register_no' => $value->vehicleNumber,
                    'amb_lat' => $value->lat,
                    'amb_log' => $value->long,
                    'amb_packet' => $value->packetdatetime
                );  
                array_push($data['pilot1'],$pilot2);
            } 
        }
        $data['emt1'] = array();
        if(!empty($emt)){
            foreach($emt as $value) {
                $emt2 = array(
                    'amb_rto_register_no' => $value->vehicleNumber,
                    'amb_lat' => $value->lat,
                    'amb_log' => $value->long,
                    'amb_packet' => $value->packetdatetime
                );  
                array_push($data['emt1'],$emt2);
            }
        }
        $data['amb1'] = array();
        if(!empty($amb)){
            foreach($amb as $value) {
                $amb2 = array(
                    'amb_rto_register_no' => $value->amb_rto_register_no,
                    'amb_lat' => $value->amb_lat,
                    'amb_log' => $value->amb_log,
                    'amb_packet' => $value->amb_rto_register_no
                );  
                array_push($data['amb1'],$amb2);
            }
        }
        echo json_encode($data);
        die();
    }
}