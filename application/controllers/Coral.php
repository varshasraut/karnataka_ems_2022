<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Coral extends EMS_Controller {
    
    function __construct() {

        parent::__construct();

        $this->active_module = "M-CORAL";
        $this->pg_limit = $this->config->item('pagination_limit');


        $this->bvgtoken = $this->config->item('bvgtoken');
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper','coral_helper'));
        $this->load->model(array('options_model', 'module_model', 'common_model','call_model','inc_model','corona_model'));
        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));


	    $this->clg = $this->session->userdata('current_user');
        $this->post = $this->input->get_post(NULL);
        $this->corel_server_url = $this->config->item('corel_server_url');

    }

    public function index($generated = false) {

        echo "This is Corel controller";
        //die();

    }
    
    public function blocked_number_listing(){

        $this->post = $this->input->post();

        $this->post['base_month'] = get_base_month();
       

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->cdata['pg_rec'];
        $data['ero_id'] = ($this->post['ero_id']) ? $this->post['ero_id'] : $this->cdata['ero_id'];

        //$this->pg_limit = 10;
        ///////////set page number////////////////////
        $args_dash = array();
        $page_no = 1;

        if ($this->post['from_date'] != '' || $this->cdata['from_date'] != '') {
            $args_dash['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->cdata['from_date']));
        }else{
             $args_dash['from_date'] = date('Y-m-d', strtotime("-1 days"));
        }


        if ($this->post['to_date'] != '' || $this->cdata['to_date'] != '') {
            $args_dash['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->cdata['to_date']));
        }else{
             $args_dash['to_date'] = date('Y-m-d');
        }
        
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }


        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        $data['clg_group'] = $this->clg->clg_group;

       
        
        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;


        $inc_info = $this->call_model->get_blocked_number($args_dash, $offset, $limit);


        $inc_data = (object) array();

        $data['per_page'] = $limit;

        $data['result'] = $inc_info;

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->call_model->get_blocked_number($args_dash);
        //$total_cnt = $this->pcr_model->get_inc_by_emt($args_dash,'','',$filter,$sortby,$incomplete_inc_amb);

        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("coral/blocked_number_listing"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
            )
        );


       // $config = get_pagination($pgconf);
        //$data['pagination'] = get_pagination($pgconf);

        $this->output->add_to_position($this->load->view('frontend/coral/block_list_view', $data, TRUE), 'content', TRUE);
        
    
    }
    
    function add_blocked_number(){
        
        $this->output->add_to_position($this->load->view('frontend/coral/add_blocked_number_view', $data, TRUE), 'popup_div', TRUE);
        
        //$this->output->add_to_position($this->load->view('frontend/coral/add_blocked_number_view', $data, TRUE), 'content', TRUE);
        
    }
    function save_blocked_number(){
        
        if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
        }
        $post_data = $this->input->post();
        $mobile_no = $post_data['mobile_number'];
        $url  = $this->corel_server_url."/blocknumber";
        $clg_ref_id = $this->clg->clg_ref_id;
        
        $data_en = array('number'=>corel_encrypt_str($mobile_no));
        
        $res = corel_curl_post_api($url,$data_en);
        //var_dump($res);
        //die();
        $resp = $res["resp"];
       
       $res_data = json_decode($resp);
        file_put_contents('./logs/'.date("Y-m-d").'avaya_blocked_log.log', $resp.",\r\n", FILE_APPEND);
        
        if($res_data->status == 1){
            
            $this->output->message = "<div class='error'>Error in Blocking Number.</div>";
            return;
            
        }
        
        $insert_data = array('block_number'=>$mobile_no,
                            'is_deleted'=>'0',
                            'added_by'=>$clg_ref_id,
                            'added_date'=>date('Y-m-d H:i:s'));
        
            
        $insert = $this->call_model->insert_block_number($insert_data);    
        if ($insert){
            $this->output->message = "<div class='success'>Mobile Number Block successfully</div>";
            $this->blocked_number_listing();
        }else{
            $this->output->message = "<div class='error'>Error in Blocking Number.</div>";
        }
        
      
    }
    function un_blocked_number(){
        if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
        }
        
        $post_data = $this->input->post();
        $mobile_no = $post_data['mobile_number'];
        $url  = $this->corel_server_url."/unblocknumber";
        $clg_ref_id = $this->clg->clg_ref_id;
        
        $data_en = array('number'=>corel_encrypt_str($mobile_no));
        
        $res = corel_curl_post_api($url,$data_en);
        $resp = $res["resp"];
//        var_dump($resp);
//        die();

        $res_data = json_decode($res["resp"]);
        file_put_contents('./logs/'.date("Y-m-d").'avaya_unblocked_log.log', $resp.",\r\n", FILE_APPEND);
        
        if($res_data->status == 1){
            
            $this->output->message = "<div class='error'>Error in Blocking Number.</div>";
            return;
            
        }
        
        $insert_data = array('block_number'=>$mobile_no,
                            'modify_by'=>$clg_ref_id,
                            'modify_date'=>date('Y-m-d H:i:s'),
                            'is_deleted'=> '1');
         
        $update = $this->call_model->update_block_number($insert_data);
      
        if($update){
            $this->output->message = "<div class='success'>Mobile Number Unblock successfully<script>$('.module_coral .mt_coral_blocked').click();</script></div>";
           // $this->blocked_number_listing();
        }else{
            $this->output->message = "<div class='error'>Error in Unblock Number.</div>";
        }
        
    }
    
    
}