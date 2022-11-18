<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Hospital_terminal extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));
        $this->load->model(array('inc_model','Dashboard_model_final','common_model','hp_model','bed_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper', 'language_helper'));


        $this->post = $this->input->get_post(NULL);
        $this->post['base_month'] = get_base_month();
        $this->clg = $this->session->userdata('current_user');

        $this->pg_limit = 50;
        $this->pg_limits = $this->config->item('report_clg');

        $this->steps_cnt = $this->config->item('screening_steps');

        $this->today = date('Y-m-d H:i:s');
    }

    function index() {
        $args['hp_id'] = $this->clg->clg_hosp_id;
        $data['hosp'] = $this->common_model->get_hospital($args['hp_id']);
        $data['inc'] = $this->hp_model->get_hospital_arriving_inc($args['hp_id']);
        $urll = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=40.6655101,-73.89188969999998&destinations=40.6905615%2C-73.9976592&key=AIzaSyDCrfpYkqNLwUaG0iipCOJec5Z9hwEL-I8';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,$urll);
        $result=curl_exec($ch);
        curl_close($ch);                                                                                                                     
        $distances = json_decode($result, TRUE); 
        $data['duration'] = $distances['rows'][0]['elements'][0]['duration']['text'];
        $data['distance'] = $distances['rows'][0]['elements'][0]['distance']['text']; 
        // var_dump($data['hosp'][0]); die;
        $this->load->view('templates/header_hosp', $data);
        $this->load->view('frontend/hospital_terminal/dash', $data);
        $this->load->view('templates/footer_hosp');
        $this->output->template = ('blank');
    }
    function hos_serch_function(){
        $args['inc_id'] = $this->input->post('inc_id'); 
        $data['inc_details'] = $this->hp_model->get_hospital_arriving_inc_serch($args['inc_id']);
        //var_dump($data['inc_details'][0]);
        echo json_encode($data['inc_details'][0]);
        exit;
         
    }
    function patients_arrived(){
        
        $args['hp_id'] = $this->clg->clg_hosp_id;
        $data['hosp'] = $this->common_model->get_hospital($args['hp_id']);
        $data['inc'] = $this->hp_model->get_hospital_arrived_inc($args['hp_id']);
        $this->load->view('templates/header_hosp', $data);
        $this->load->view('frontend/hospital_terminal/patients_arrived_view', $data);
        $this->load->view('templates/footer');
        $this->output->template = ('blank');
    }
    public function otp_varification1(){
        $otp = $this->input->post('otp');
        $otp_inc_id = $this->input->post('otp_inc_id');

        $args = array('bed_otp'=>$otp,'inc_ref_id'=>$otp_inc_id);
        $inc_details = $this->inc_model->get_inc_details_otp($args);
        echo $inc_details;
        die();
        
    } 
    public function patient_admit_confirmation(){
        $otp_inc_id = $this->input->post('inc_id');
        $args['hp_id'] = $this->clg->clg_hosp_id;
        $inc_data = $this->inc_model->get_incident_by_inc_ref_id($otp_inc_id);
        $hp_info = $this->hp_model->get_hos_details($args['hp_id']);
        

        $column_key = array('test','ICUWoVenti','ICUwithVenti','ICUwithdialysisBed','C19Positive','central_oxygen');
        

        $column_name = $column_key[$inc_data[0]->bed_type];
        
        $total_column = $column_name.'_Total_Beds';
        $Occupied_column = $column_name.'_Occupied';
        $Vacant_column = $column_name.'_Vacant';
        
        $C19_Total_Beds_column = 'C19_Total_Beds';
        $C19_Vacant_column = 'C19_Vacant';
        $C19_Occupied_column = 'C19_Occupied';
        
        $Total_Beds = $hp_info[0]->$total_column;
        $C19_Total_Beds = $hp_info[0]->$C19_Total_Beds_column;
       
        $Occupied = ($hp_info[0]->$Occupied_column)+1;
        $C19_Occupied = ($hp_info[0]->$C19_Occupied_column)+1;
        
        if($hp_info[0]->$Vacant_column != '0' && $hp_info[0]->$Vacant_column != 0 && $hp_info[0]->$Vacant_column  != 'null' && $hp_info[0]->$Vacant_column  != ''){
             $Vacant = ($hp_info[0]->$Vacant_column)-1;
             $C19_Vacant = ($hp_info[0]->$C19_Vacant_column)-1;
             
        }else{
            $Vacant = (int)$Total_Beds - (int)$Occupied;
            $C19_Vacant = (int)$C19_Total_Beds - (int)$C19_Occupied;
            
        }

        

        $update_bed = array('Hospital_id'=>$args['hp_id'],$Occupied_column=>$Occupied,$Vacant_column=>$Vacant,$C19_Vacant_column=>$C19_Vacant,$C19_Occupied_column=>$C19_Occupied);
        $inc_data = $this->bed_model->bed_update($update_bed);

 
        $datetime = date('Y-m-d H:i:s');
        $args = array('inc_ref_id'=>$otp_inc_id,'admitted_time' => $datetime);
        $inc_details = $this->inc_model->bed_confirmation($args);
        
        
        echo $inc_details;
       
        
    } 

}