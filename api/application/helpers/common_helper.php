<?php
function generate_ptn_id($clg_id_for_new_ptn1) {
    
    $CI = get_instance();
    $CI->load->model('options_model');
    
    $date = date('Ymd');
    
    // $clg = $CI->session->userdata('current_user');
    $clg_id = $clg_id_for_new_ptn1;
    
    $ems_ptn_id = $CI->options_model->get_option('ems_ptn_id');
    $inc_id_data = json_decode($ems_ptn_id, true);
    if(!isset($inc_id_data[$date])){
       // $CI->inc_model->reset_ptn_index();
    }
    
    $inc_index = $CI->options_model->get_ptn_index($clg_id);
    $inc_id_ref =  $inc_index;
 
    $data = array($date => $inc_id_ref);
    $ref_id = json_encode($data, true);
    $inc_id = $CI->options_model->add_option('ems_ptn_id',$ref_id);

    return $inc_id_ref;
    
}

?>