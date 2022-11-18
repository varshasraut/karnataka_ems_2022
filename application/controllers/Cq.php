<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cq extends EMS_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->active_module = "M-CQ";
        $this->pg_limit = $this->config->item('pagination_limit');
        $this->gps_url = $this->config->item('amb_gps_url');
        $this->gps_url_pcmc = $this->config->item('amb_gps_url_pcmc');
        $this->google_api_key = $this->config->item('google_api_key');
        $this->gps_url_pmc = $this->config->item('amb_gps_url_pmc');
        $this->gps_url_Ahmednagar = $this->config->item('amb_gps_url_Ahmednagar');
        $this->amb_gps_url_bike = $this->config->item('amb_gps_url_bike');


        $this->allow_img_type = $this->config->item('upload_image_types');
        $this->upload_path = $this->config->item('upload_path');
        $this->upload_image_size = $this->config->item('upload_image_size');
        $this->upload_rsm_type = $this->config->item('upload_rsm_types');
        $this->cq_pic = $this->config->item('cq_pic');
        
        $this->load->model(array('Dashboard_model_final_updated', 'colleagues_model', 'get_city_state_model', 'options_model', 'module_model', 'amb_model', 'inc_model', 'pcr_model', 'hp_model', 'ambmain_model', 'dashboard_model','cq_model','common_model'));

        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper','cct_helper',));

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

    public function index($generated = false)
    {

        echo "This is Ambulance controller";
    }
    function cq_listing()
    {
        //var_dump('hii');die();
        $district_id = $this->clg->clg_district_id;
        $clg_group = $this->clg->clg_group;
        
        $page_no = 1;
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        //////////////////////////limit & offset//////
        $data['get_count'] = TRUE;

        $data['total_count'] = $this->cq_model->get_cq_data_listing($data);
        //var_dump($data['total_count']);die();
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['AMB'] = $data;

        $this->session->set_userdata('filters', $ambflt);

        /////////////////////////////////////////////////////

        unset($data['get_count']);

        $data['result'] = $this->cq_model->get_cq_data_listing($data, $offset, $limit);
       
        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("cq/cq_listing"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array(
                'class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );
        
        $data['pagination'] = get_pagination($pgconf);
        $this->output->add_to_position('', 'caller_details', TRUE);
        $this->output->add_to_position($this->load->view('frontend/cq/cq_list_view', $data, TRUE), $this->post['output_position'], TRUE);

        //$this->output->add_to_position($this->load->view('frontend/amb/amb_filters_view', $data, TRUE), 'amb_filters', TRUE);
        $this->output->template = "emt";
    }
    function add_cq()
    {
        $data['test']=1;
        $this->output->add_to_position($this->load->view('frontend/cq/add_cq_view', $data, TRUE), 'popup_div', TRUE);
    }
    function save_cq(){

            $amb = $this->post['cq_ambulance'];
            if($amb != ' ' || $amb != null){
            $amb_nos = explode(",",$amb);
            // print_r($amb);die();
            $note = $this->post['cq_note'];
            $image_name=[];
            $cq_video=[];
            $randomno = rand();
            
            if(!empty($_FILES['amb_photo']['name'])){
                foreach ($_FILES['amb_photo']['name'] as $key => $image) {
                    $ext = explode(".", $image);
                    array_push($image_name,$randomno.'_'.date('Y_m_d_H_i_s').".".$ext[1]);
                }
                $image_name1 = implode(",",$image_name);
            }
            if(!empty($_FILES['amb_video']['name'])){
                foreach ($_FILES['amb_video']['name'] as $key => $image) {
                    $ext = explode(".", $image);
                    array_push($cq_video,$randomno.'_'.date('Y_m_d_H_i_s').".".$ext[1]);
                    $image_vedio1 = implode(",",$cq_video);
                }
            }
            foreach($amb_nos as $amb_no){
                // print_r($amb_no);die();
           
            $data = array(
                "cq_vehicle"    =>  $amb_no,
                "cq_msg"    =>  $note,
                "cq_images"    =>  $image_name1,
                "cq_video" => $image_vedio1,
                "cq_added_date"    =>  date('Y-m-d H:i:s'),
            );
            // print_r($data);die();
            $insert = $this->cq_model->insert_cq_data($data);
        }
            
            if(!empty($_FILES['amb_photo']['name'])){
                foreach ($_FILES['amb_photo']['name'] as $key => $image) {
                    
                    $image1 = array();
    
                   
                    $_FILES['photo']['name']= $_FILES['amb_photo']['name'][$key];
                    $_FILES['photo']['type']= $_FILES['amb_photo']['type'][$key];
                    $_FILES['photo']['tmp_name']= $_FILES['amb_photo']['tmp_name'][$key];
                    $_FILES['photo']['error']= $_FILES['amb_photo']['error'][$key];
                    $_FILES['photo']['size']= $_FILES['amb_photo']['size'][$key];
                   // $_FILES['photo']['name'] = date('Y-m-d_H:i:s') .'_'.$_FILES['photo']['name'][$key];
                   $ext = explode(".", $_FILES['amb_photo']['name'][$key]);
                  
                    $_FILES['photo']['name'] = $randomno."_".date('Y_m_d_H_i_s_') . "." . $ext[1];
                    $image = $randomno."_".date('Y_m_d_H_i_s_')  . "." . $ext[1];
                    //array_push($image1,$image);
                 
                    $rsm_config = $this->cq_pic;
                    $this->upload->initialize($rsm_config);
  
                    if (!$this->upload->do_upload('photo')) {
                                 $msg_p =  $this->upload->display_errors();
                                  $this->output->message = "<div class='error'>$msg_p .. Please upload again..!</div>";
                                $upload_err = TRUE;
                                return;
                    }
                  
                    if (!$upload_err) {
                        $this->output->message = "<div class='success'>Image uploaded successfully..!</div>";  
                    }
    
                }
            }
            
            if(!empty($_FILES['amb_video']['name'])){
                
                foreach ($_FILES['amb_video']['name'] as $key => $image) {
                    
                    $Video = array();
    
                    
                    $_FILES['photo']['name']= $_FILES['amb_video']['name'][$key];
                    $_FILES['photo']['type']= $_FILES['amb_video']['type'][$key];
                    $_FILES['photo']['tmp_name']= $_FILES['amb_video']['tmp_name'][$key];
                    $_FILES['photo']['error']= $_FILES['amb_video']['error'][$key];
                    $_FILES['photo']['size']= $_FILES['amb_video']['size'][$key];
                    //$_FILES['photo']['name'] = date('Y-m-d_H:i:s') .'_'.$_FILES['amb_video']['name'][$key];
                    $ext = explode(".", $_FILES['amb_video']['name'][$key]);
                    $_FILES['photo']['name'] = $randomno."_".date('Y_m_d_H_i_s_') . "." . $ext[1];
                    $image = $randomno."_".date('Y_m_d_H_i_s_') .  "." . $ext[1];
                    array_push($Video,$image);

                    $rsm_config = $this->cq_pic;
                    $this->upload->initialize($rsm_config);
   
                    if (!$this->upload->do_upload('photo')) {
                                 $msg_p =  $this->upload->display_errors();
                                  $this->output->message = "<div class='error'>$msg_p .. Please upload again..!</div>";
                                $upload_err = TRUE;
                                return;
                    }
                    
                    if (!$upload_err) {
                        $this->output->message = "<div class='success'>Vedio uploaded successfully..!</div>";  
                    }
    
                }
            }
            if($insert)
            {
                $comm_api_url = "http://localhost/JAEms/api/cqnotification";
                $json_data = array('ambulanceNo'=>$amb_no);
                $json_data= json_encode($json_data);
                $api_google = api_notification_app($comm_api_url,$json_data);
                $this->output->closepopup = 'yes';
                $this->output->status = 1;
                $this->output->closepopup = "yes";
                $this->output->message = "<div class='success'>CQ Data Save Successfully</div>";
                $this->cq_listing();
               
                
            }
        }
        else{
            $msg_p =  $this->upload->display_errors();
            $this->output->message = "<div class='Error'>Error Please Select Ambulance</div>";
            $upload_err = TRUE;
            return;
             
            // $this->cq_listing();
        }
    }
    function view_detail(){
        $data['action'] = $this->input->post('action');
        if ($this->post['cq_id'] != '') {
            $cq_id = array_map("base64_decode", $this->post['cq_id']);
        }
        $data['cq_id'] = $cq_id[0];
       
        $data['update'] = $this->cq_model->get_cq_data_listing($data);
        $this->output->add_to_position($this->load->view('frontend/cq/add_cq_view', $data, TRUE), 'popup_div', TRUE);
    }
    function view_amb($args = array()){
        $data['amb'] = $this->common_model->get_ambulance(array('amb_rto_register_no' => $args['amb_ref_no'],  'amb_state' => $args['st_code']));
        echo json_encode($data);
        die;
    }
   
}
