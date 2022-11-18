<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends EMS_Controller {

    function __construct() {

        parent::__construct();

        header('Access-Control-Allow-Origin: *');
        $this->active_module = "M-AMBU";
        $this->pg_limit = $this->config->item('pagination_limit');
        $this->gps_url = $this->config->item('amb_gps_url');
        $this->load->model(array('colleagues_model', 'get_city_state_model', 'options_model', 'module_model', 'amb_model', 'inc_model', 'pcr_model', 'sync_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper'));
        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));
        $this->post = $this->input->get_post(NULL);

        if ($this->post['filters'] == 'reset') {
            $this->session->unset_userdata('filters')['AMB'];
        }
        if ($this->session->userdata('filters')['AMB']) {

            $this->fdata = $this->session->userdata('filters')['AMB'];
        }
    }

    public function userlogin() {

        $data['ref_id'] = $this->input->post('username', TRUE);
        $data['password'] = $this->input->post('password', TRUE);
            

        if ($data['ref_id'] != "" && $data['ref_id'] != "null") {
            $current_user = $this->colleagues_model->get_user_info($data['ref_id']);
        }
        if ($data['ref_id'] != "" && $data['ref_id'] != "null" && $data['password'] != "null") {

            $password = md5($data['password']);
            $result = $this->colleagues_model->check_password($data['ref_id'], $password);

            if ($password === $result[0]->clg_password) {
                if ($current_user[0]->clg_ref_id != '') {
                    $col_name = 'clg_token';
                    $clg_token = substr(str_shuffle("0123456789abcdefghiMHlmnopqrstuvwxyzABCDEFGHIMHLMNOPQRSTUVWXYZ"), 0, 32);

                    $rel = $this->colleagues_model->update_clg_field($current_user[0]->clg_ref_id, $col_name, $clg_token);
                }
            }
        }

        if ($rel == true) {
            $current_user = $this->colleagues_model->get_user_info($data['ref_id']);
         
            $user['clg_id'] = $current_user[0]->clg_id;
            $user['clg_ref_id'] = $current_user[0]->clg_ref_id;
            $user['clg_address'] = $current_user[0]->clg_address;
            $user['clg_email'] = $current_user[0]->clg_email;
            $user['clg_token'] = $current_user[0]->clg_token;
            $user['clg_mobile_no'] = $current_user[0]->clg_mobile_no;
            $user['clg_group'] = $current_user[0]->clg_group;
            $user['clg_first_name'] = $current_user[0]->clg_first_name;
//            $user['cluster_id'] = $current_user[0]->cluster_id;
            $user['user_default_key'] = $current_user[0]->user_default_key;
        }
      
    
//        $po_data = $this->sync_model->get_cluser_po($user['cluster_id']);
      
//        $po_clusters = $this->sync_model->get_po_clusers($po_data[0]->po);
//        $cluster_ids = array();
//        foreach ($po_clusters as $item) {
//            $cluster_ids[] = $item->cluster_id;
//        }
//        $user['po_cluster_id'] = $cluster_ids;
        $usr['clg'] = $user;

        echo json_encode($usr);
        exit();
        
    }

}
