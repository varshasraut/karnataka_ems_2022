<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inspection extends EMS_Controller {

    function __construct() {
        parent::__construct();
        $this->active_module = "M-INSPECTION";
        $this->pg_limit = $this->config->item('pagination_limit');
        $this->load->model(array('inspection_model','colleagues_model', 'get_city_state_model', 'options_model', 'module_model', 'amb_model', 'inc_model', 'pcr_model','hp_model','ambmain_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper'));
        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));
        $this->post = $this->input->get_post(NULL);
        $this->ins_pic = $this->config->item('ins_pic');
        if ($this->post['filters'] == 'reset') {
            $this->session->unset_userdata('filters')['AMB'];
        }
        if ($this->session->userdata('filters')['AMB']) {

            $this->fdata = $this->session->userdata('filters')['AMB'];
        }
        $this->post['base_month'] = get_base_month();
        $this->clg = $this->session->userdata('current_user');
    }
    public function index($generated = false) {

        echo "This is INSPECTION controller";
    }
    // public function load_dashboard(){
        
    //     $this->output->add_to_position($this->load->view('frontend/inspection/head_tabs', $data, TRUE), 'content', TRUE);
    //     $this->output->template = "mb_view";
    // }
    public function dashboard(){

        $district_id = $this->clg->clg_district_id;
        $clg_group = $this->clg->clg_group;
        $district_id = explode( ",", $district_id);
        $data['clg_ref_id'] = $this->clg->clg_ref_id;
        $data['clg_group'] = $clg_group;
        $regex = "([\[|\]|^\"|\"$])"; 
        $replaceWith = ""; 
        $district_id = preg_replace($regex, $replaceWith, $district_id);
            
        if(is_array($district_id)){
            $district_id = implode("','",$district_id);
        }
        // if($clg_group == 'UG-INSPECTION'){
        //     $data['get_dist'] = '';
        // }else {
        //     $data['get_dist'] = $district_id;
        // }
       $total_count_gri = $this->inspection_model->get_gri_records_count($data);
       $total_count_ins = $this->inspection_model->get_ins_records_count($data);

       $total_count_ins_month = $this->inspection_model->get_ins_records_count_month($data);
       $total_count_gri_month = $this->inspection_model->get_gri_records_count_month($data);

       $total_count_ins_progress = $this->inspection_model->get_ins_records_inprogress($data);
       $total_count_gri_progress = $this->inspection_model->get_gri_records_inprogress($data);

       $total_gri_comp_records_count = $this->inspection_model->get_gri_comp_records_count($data);

       $data['total_count_ins'] = $total_count_ins[0]->total_count_ins;
       $data['total_count_ins_month'] = $total_count_ins_month[0]->total_count_ins_month;
       $data['total_count_ins_progress'] = $total_count_ins_progress[0]->total_count_ins_progress;

       $data['total_count_gri_progress'] = $total_count_gri_progress[0]->total_count_gri_progress;
       $data['total_count_gri'] = $total_count_gri[0]->total_count_gri;
       $data['total_count_gri_month'] = $total_count_gri_month[0]->total_count_gri_month;
       $data['total_count_comp_gri'] = $total_gri_comp_records_count[0]->total_count_comp_gri;
       $this->output->add_to_position($this->load->view('frontend/inspection/ins_dashboard', $data, TRUE), $this->post['output_position'], TRUE);    //    $this->output->template = "blank";
       $this->output->template = "emt";

    }

    public function ins_listing(){
        $district_id = $this->clg->clg_district_id;
        $clg_group = $this->clg->clg_group;
        $data['clg_ref_id'] = $this->clg->clg_ref_id;
        $district_id = explode( ",", $district_id);
        $regex = "([\[|\]|^\"|\"$])"; 
        $replaceWith = ""; 
        $district_id = preg_replace($regex, $replaceWith, $district_id);
            
        if(is_array($district_id)){
            $district_id = implode("','",$district_id);
        }
        $data['rg_no'] = ($this->post['rg_no']) ? $this->post['rg_no'] : $this->fdata['rg_no'];
        $data['search_amb'] = ($this->post['search_amb']) ? $this->post['search_amb'] : $this->fdata['search_amb'];
        $data['amb_search'] = ($this->post['amb_search']) ? $this->post['amb_search'] : $this->fdata['amb_search'];
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $insflt['INSPECTION'] = $data;
        ///////////set page number////////////////////
        $page_no = 1;
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        //////////////////////////limit & offset//////
        $data['get_count'] = TRUE;
        $data['thirdparty']=$this->clg->thirdparty;

        if($clg_group == 'UG-QualityManager' || $clg_group == 'UG-SuperAdmin' || $clg_group == 'UG-HO-JAES'){
            $data['get_dist'] = '';
            $data['clg_ref_id'] = '';
        }else {
            $data['get_dist'] = $district_id;
            $data['clg_ref_id'] = $this->clg->clg_ref_id;
        }
        

        $data['total_count'] = $this->inspection_model->get_ins_records($data);
        //var_dump($data['total_count']);die();
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['INSPECTION'] = $data;

        $this->session->set_userdata('filters', $ambflt);

        /////////////////////////////////////////////////////

        unset($data['get_count']);
      
    //    var_dump($data['get_dist']);die();
        $data['result'] = $this->inspection_model->get_ins_records($data, $offset, $limit);
        //var_dump($data['result']);die();
       // $data['result'] = 0;
        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("inspection/ins_listing"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
            'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );
        $data['pagination'] = get_pagination($pgconf);
        $this->output->add_to_position($this->load->view('frontend/inspection/ins_list_view', $data, TRUE), $this->post['output_position'], TRUE);
        $this->output->template = "emt";
        // $this->output->add_to_position($this->load->view('frontend/inspection/ins_list_view', $data, TRUE), 'content', TRUE);
        // $this->output->add_to_position($this->load->view('frontend/amb/amb_filters_view', $data, TRUE), 'amb_filters', TRUE);
        // $this->output->template = "blank";
        // $this->output->template = "mb_view";
           
    }
    public function gri_listing(){
        $district_id = $this->clg->clg_district_id;
        $clg_group = $this->clg->clg_group;
        $district_id = explode( ",", $district_id);
        $data['clg_ref_id'] = $this->clg->clg_ref_id;
        $regex = "([\[|\]|^\"|\"$])"; 
        $replaceWith = ""; 
        $district_id = preg_replace($regex, $replaceWith, $district_id);
            
        if(is_array($district_id)){
            $district_id = implode("','",$district_id);
        }
        $data['rg_no'] = ($this->post['rg_no']) ? $this->post['rg_no'] : $this->fdata['rg_no'];
        $data['search_amb'] = ($this->post['search_amb']) ? $this->post['search_amb'] : $this->fdata['search_amb'];
        $data['amb_search'] = ($this->post['amb_search']) ? $this->post['amb_search'] : $this->fdata['amb_search'];
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $insflt['INSPECTION'] = $data;
        ///////////set page number////////////////////
        $page_no = 1;
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        //////////////////////////limit & offset//////
        $data['get_count'] = TRUE;
        if($clg_group == 'UG-QualityManager' || $clg_group == 'UG-SuperAdmin' || $clg_group == 'UG-HO-JAES'){
            $data['get_dist'] = '';
            $data['clg_ref_id'] = '';
        }else {
            $data['get_dist'] = $district_id;
            $data['clg_ref_id'] = $this->clg->clg_ref_id;
        }
    
        $data['total_count'] = $this->inspection_model->get_gri_records($data);
        //var_dump($data['total_count']);die();
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['INSPECTION'] = $data;

        $this->session->set_userdata('filters', $ambflt);

        /////////////////////////////////////////////////////

        unset($data['get_count']);
        
//        var_dump($data);
        $data['result'] = $this->inspection_model->get_gri_records($data, $offset, $limit);
        //var_dump($data['result']);die();
       // $data['result'] = 0;
        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("inspection/gri_listing"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
            'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );
        $data['pagination'] = get_pagination($pgconf);
        $this->output->add_to_position($this->load->view('frontend/inspection/gri_list_view', $data, TRUE), $this->post['output_position'], TRUE);
        // $this->output->add_to_position($this->load->view('frontend/amb/amb_filters_view', $data, TRUE), 'amb_filters', TRUE);
        $this->output->template = "emt";
        // $this->output->template = "blank";
        //    $this->output->template = "mb_view"; 
    }
    function save_grievance_ins(){
        $district_id = $this->clg->clg_district_id;
        $clg_group = $this->clg->clg_group;
        $district_id = explode( ",", $district_id);
        $regex = "([\[|\]|^\"|\"$])"; 
        $replaceWith = ""; 
        $district_id = preg_replace($regex, $replaceWith, $district_id);
            
        if(is_array($district_id)){
            $district_id = implode("','",$district_id);
        }
        $data['get_dist'] = $district_id;

        $data['gri'] = $this->input->post('gri');
        $args = array(  'added_date' => date('Y-m-d H:i:s'),
        'added_by' => $this->clg->clg_ref_id,
        'ins_dist' => $data['get_dist'] );
        $gri_data = array_merge($data['gri'],$args);

        $gri_data = $this->inspection_model->insert_gri($gri_data);
        $update = array(
            'ins_id' => $data['gri']['ins_id'],
        );

        // var_dump($update);die();
        $ins_data_update = $this->inspection_model->update_ins($update);
        if ($gri_data) {
            $this->output->closepopup = 'yes';
            $this->output->status = 1;
            $this->output->closepopup = "yes";
            $this->output->message = "<div class='success'>Grievance details updated successfully</div>";
            $this->gri_listing();
        } else {
            $this->output->message = "<div class='error'>Grievance details is not updated.</div>";
        } 
    }
    function save_inspection(){
        // var_dump( $this->input->post('clean'));die;
        $data['main'] = $this->input->post('main');
        $data['clean'] = $this->input->post('clean');
        // $data['main_med_eqp'] = $this->input->post('main_med_eqp');
        $data['main_med_stock'] = $this->input->post('main_med_stock');

        // $data['main_gps'] = $this->input->post('main_gps');
        $data['main_pcs_stock_reg'] = $this->input->post('main_pcs_stock_reg');
        $data['sign_attnd_sheet'] = $this->input->post('sign_attnd_sheet');
        $data['ins_med'] = $this->input->post('ins_med');
        $data['minor_eqp_status'] = $this->input->post('minor_eqp_status');
        $data['major_eqp_status'] = $this->input->post('major_eqp_status');
        $data['critical_eqp_status'] = $this->input->post('critical_eqp_status');

        $image_name=[];
        $ins_video=[];
        $randomno = rand();
        if(!empty($_FILES['ins_photo']['name'])){
            foreach ($_FILES['ins_photo']['name'] as $key => $image) {
                $ext = explode(".", $image);
                array_push($image_name,$randomno.'_'.date('Y_m_d_H_i_s').".".$ext[1]);
            }
            $image_name1 = implode(",",$image_name);
        }
        if(!empty($_FILES['ins_video']['name'])){
            foreach ($_FILES['ins_video']['name'] as $key => $image) {
                $ext = explode(".", $image);
                array_push($ins_video,$randomno.'_'.date('Y_m_d_H_i_s').".".$ext[1]);
                $image_vedio1 = implode(",",$ins_video);
            }
        }

        $args = array( 
             'remark' => $this->input->post('remark'),
             'ins_state' => $this->input->post('inspection_state'),
             'ins_dist' => $this->input->post('inspection_district'),
             'ins_amb_no' => $this->input->post('inspection_ambulance'),
             'ins_baselocation' => $this->input->post('base_location'),
             'med_Remark' => $this->input->post('med_Remark'),

             //'ins_baselocation' => 'jj',
             'ins_amb_type' => $this->input->post('amb_type'),
             'ins_amb_model' => $this->input->post('ambt_model'),
             'ins_amb_current_status' => $this->input->post('ins_amb_current_status'),
             'ins_gps_status' => $this->input->post('ins_gps_status'),
             'ins_emso' => $this->input->post('ins_emso'),
             'ins_pilot' => $this->input->post('ins_pilot'),
             'ins_odometer' => $this->input->post('ins_odometer'),
             'forword_grievance' => $this->input->post('forword_grievance'),
             //'ins_images'=>$image_name1,
            // 'ins_video'=>$image_vedio1,
             'added_date' => date('Y-m-d H:i:s'),
             'added_by' => $this->clg->clg_ref_id,
             'added_by_source'=> "Web"
         );

               
        //  var_dump($data['main_pcs_stock_reg']);die;

         $ins_data = array_merge($data['main'],
                              $data['clean'],
                              $data['main_med_stock'],
                              $data['main_pcs_stock_reg'],
                              $data['sign_attnd_sheet'],
                              $args
                             );
                            //    var_dump($data['ins_data']);die;
                             
         $ins_data = $this->inspection_model->insert_insp($ins_data);
         $ins_media_data = array(
                                'insp_id' => $ins_data,
                                'form_no'=>'0',
                                'upload_img_path' => $image_name1,
                                'upload_video_path' => $image_vedio1
                             );
         $photo_video_data = $this->inspection_model->insert_ins_media_insp($ins_media_data);
        // ems_insp_upload_file
        foreach($data['ins_med'] as $key=>$ins_med)
        {
            // var_dump($ins_med);die();
            if($ins_med['med']!=''){
            $med = array(
                'ins_id' => $ins_data,
                'med_id' => $key,
                'med_status' => $ins_med['med'],
                'med_qty' => $ins_med['qty'],
            );
            $med_data = $this->inspection_model->insert_insp_med($med);
            }
        }
        foreach($data['minor_eqp_status'] as $key=>$eqp_minor)
        {
            // var_dump(date('Y-m-d', strtotime($eqp_minor['date_from'])));die;
            if(($eqp_minor['date_from']) == " "){
                $date_from_minor = " ";

            }
            else{
                $date_from_minor = date('Y-m-d', strtotime($eqp_minor['date_from']));
            }
            $eqp_minor = array(
                        'ins_id' => $ins_data,
                        'eqp_id' => $key,
                        'status' => $eqp_minor['status'],
                        'oprational' => $eqp_minor['oprational'],
                        'date_from' => $date_from_minor,
                        'remark' => $this->input->post('minor_eqp_status_remark'),
                        'type'=>'1'
                    );
            $eqp_data = $this->inspection_model->insert_insp_equp($eqp_minor);
            
        }
        foreach($data['major_eqp_status'] as $key=>$eqp_major)
        {
            if(($eqp_major['date_from']) == " "){
                $date_from_major = "";

            }
            else{
                $date_from_major = date('Y-m-d', strtotime($eqp_major['date_from']));
            }

            $eqp_major = array(
                'ins_id' => $ins_data,
                'eqp_id' => $key,
                'status' => $eqp_major['status'],
                'oprational' => $eqp_major['oprational'],
                'date_from' => $date_from_major,

                'remark' => $this->input->post('major_eqp_status_remark'),
                'type'=>'2'
            );
            $eqp_data = $this->inspection_model->insert_insp_equp($eqp_major);
        }
        foreach($data['critical_eqp_status'] as $key=>$eqp_critical)
        {

        
            if(($eqp_critical['date_from']) == " "){
                $date_from_critical = "";

            }
            else{
                $date_from_critical = date('Y-m-d', strtotime($eqp_critical['date_from']));
            }

            $eqp_critical = array(
                'ins_id' => $ins_data,
                'eqp_id' => $key,
                'status' => $eqp_critical['status'],
                'oprational' => $eqp_critical['oprational'],
                'date_from' =>  $date_from_critical,

                'remark' => $this->input->post('critical_eqp_status_remark'),
                'type'=>'3'
            );
            $eqp_data = $this->inspection_model->insert_insp_equp($eqp_critical);
        }
        if(!empty($_FILES['ins_photo']['name'])){
            foreach ($_FILES['ins_photo']['name'] as $key => $image) {
                
                $image1 = array();

               
                $_FILES['photo']['name']= $_FILES['ins_photo']['name'][$key];
                $_FILES['photo']['type']= $_FILES['ins_photo']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['ins_photo']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['ins_photo']['error'][$key];
                $_FILES['photo']['size']= $_FILES['ins_photo']['size'][$key];
               // $_FILES['photo']['name'] = date('Y-m-d_H:i:s') .'_'.$_FILES['photo']['name'][$key];
               $ext = explode(".", $_FILES['ins_photo']['name'][$key]);
              
                $_FILES['photo']['name'] = $randomno."_".date('Y_m_d_H_i_s_') . "." . $ext[1];
                $image = $randomno."_".date('Y_m_d_H_i_s_')  . "." . $ext[1];
                //array_push($image1,$image);
             
                $rsm_config = $this->ins_pic;
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
        
        if(!empty($_FILES['ins_video']['name'])){
            
            foreach ($_FILES['ins_video']['name'] as $key => $image) {
                
                $Video = array();

                
                $_FILES['photo']['name']= $_FILES['ins_video']['name'][$key];
                $_FILES['photo']['type']= $_FILES['ins_video']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['ins_video']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['ins_video']['error'][$key];
                $_FILES['photo']['size']= $_FILES['ins_video']['size'][$key];
                //$_FILES['photo']['name'] = date('Y-m-d_H:i:s') .'_'.$_FILES['amb_video']['name'][$key];
                $ext = explode(".", $_FILES['ins_video']['name'][$key]);
                $_FILES['photo']['name'] = $randomno."_".date('Y_m_d_H_i_s_') . "." . $ext[1];
                $image = $randomno."_".date('Y_m_d_H_i_s_') .  "." . $ext[1];
                array_push($Video,$image);

                $rsm_config = $this->ins_pic;
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
        if ($ins_data) {
            $this->output->closepopup = 'yes';
            $this->output->status = 1;
            $this->output->closepopup = "yes";
            $this->output->message = "<div class='success'>Inspection details updated successfully</div>";
            $this->ins_listing();
        } else {
            $this->output->message = "<div class='error'>Inspection details is not updated.</div>";
        } 
        

    }
    function view_grievance(){
        $arr = array(
               'ins_id' => $this->post['id']
            );
            $data['action'] ='view';
         $data['result'] = $this->inspection_model->get_ins_gri_records($arr);
         $this->output->add_to_position($this->load->view('frontend/inspection/add_gri_view', $data, TRUE), 'popup_div', TRUE);  
        
    }
    function add_grievance(){
        $gri_action = $this->post['gri_action'];
        $data['id']=$this->post['id'];
        $data['amb_no'] = $this->post['amb_no'];
       // var_dump($data);die();
       
        $this->output->add_to_position($this->load->view('frontend/inspection/add_gri_view', $data, TRUE), 'popup_div', TRUE);  
       
       
    }
    function view_inspection(){
        
        //var_dump($this->input->post('ins_id'));die();
        $data['medicine_list'] = $this->inspection_model->get_ins_medicine_list();    
        $args = array('cat_type' => '1');

        $data['equipment_list_minor'] = $this->inspection_model->get_equipment_list($args);
        $args = array('cat_type' => '2');
        // var_dump( $data['equipment_list_minor']);

        $data['equipment_list_major'] = $this->inspection_model->get_equipment_list($args);
        $args = array('cat_type' => '3');
                // var_dump( $data['equipment_list_major']);

        $data['equipment_list_critical'] = $this->inspection_model->get_equipment_list($args);
        $arr = array(
            'ins_id' => $this->post['ins_id']
         );
        //  var_dump( $data['equipment_list_critical']);die();

        $data['action'] ='view';
        $data['result'] = $this->inspection_model->get_ins_records($arr);
        $data['result_media'] = $this->inspection_model->get_ins_media_records($arr);
       // $data['result_med'] = $this->inspection_model->get_ins_med_records($arr);
        $data['result_equip'] = $this->inspection_model->get_ins_equip_records($arr);
//    var_dump( $data['result_equip']);die();
        $this->output->add_to_position($this->load->view('frontend/inspection/add_inspection_view', $data, TRUE), 'popup_div', TRUE);
    
    }
    function add_inspection(){
        //$this->output->add_to_popup($this->load->view('frontend/inspection/add_inspection_view', $data, TRUE), '1900', '1700');
        $data['medicine_list'] = $this->inspection_model->get_ins_medicine_list();    
        $args = array('cat_type' => '1');
        $data['equipment_list_minor'] = $this->inspection_model->get_equipment_list($args);
        $args = array('cat_type' => '2');
        $data['equipment_list_major'] = $this->inspection_model->get_equipment_list($args);
        $args = array('cat_type' => '3');
        $data['equipment_list_critical'] = $this->inspection_model->get_equipment_list($args);
        
        $this->output->add_to_position($this->load->view('frontend/inspection/add_inspection_view', $data, TRUE), 'popup_div', TRUE);
    }
    function update_base_location_inspection(){
        $args = array(
            'amb_ref_id' => $this->post['amb_id'],
        );

       // $data['inc_emp_info'] = $this->pcr_model->get_amb_location($args);

        $args_odometer = array('rto_no' => $this->post['amb_id']);
        
       
        $amb_odometer = $this->amb_model->get_amb_odometer($args_odometer);
        $amb_type = $this->amb_model->get_amb_make_model_by_regno($args_odometer);
        $data['inc_emp_info'] = $this->pcr_model->get_amb_location($args);
        $data['amb_type']=$amb_type[0]->ambt_name;
        $data['vehical_model']=$amb_type[0]->vehical_model;
        $data['ambt_name']=$amb_type[0]->ambu_type;
        $data['ambt_id'] = $amb_type[0]->ambt_id;
          
        if (!empty($amb_odometer_fuel)) {
            if(!empty($amb_odometer_fuel[0]->mt_in_odometer)){
                $data['current_odometer'] = $amb_odometer_fuel[0]->mt_in_odometer;
                
            }else{
                $data['current_odometer'] = 0;
            }
        }else{
                $data['current_odometer'] = 0;
            }

        if($amb_odometer[0]->end_odmeter != ''){
            $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;
        }else{
            $data['previous_odometer'] = 0;
        }
        $args = array('ambu_type'=>$amb_type[0]->ambt_id); 
        $data['medicine_list'] = $this->inspection_model->get_ins_medicine_list($args);    
        $args = array('cat_type' => '1','ambu_type'=>$amb_type[0]->ambt_id);
        $data['equipment_list_minor'] = $this->inspection_model->get_equipment_list($args);
        $args = array('cat_type' => '2','ambu_type'=>$amb_type[0]->ambt_id);
        $data['equipment_list_major'] = $this->inspection_model->get_equipment_list($args);
        $args = array('cat_type' => '3','ambu_type'=>$amb_type[0]->ambt_id);
        $data['equipment_list_critical'] = $this->inspection_model->get_equipment_list($args);

        $this->output->add_to_position($this->load->view('frontend/fleet/base_location_view', $data, TRUE), 'amb_base_location', TRUE);
        $this->output->add_to_position($this->load->view('frontend/fleet/ambu_type_view', $data, TRUE), 'amb_type_div_outer', TRUE);

        $this->output->add_to_position($this->load->view('frontend/fleet/amb_type_view', $data, TRUE), 'amb_type_div', TRUE);
        $this->output->add_to_position($this->load->view('frontend/fleet/amb_model_view', $data, TRUE), 'amb_amb_model', TRUE);
        $this->output->add_to_position($this->load->view('frontend/inspection/amb_equiment_model_view', $data, TRUE), 'amb_equipment_model', TRUE); 
        $this->output->add_to_position($this->load->view('frontend/inspection/amb_medicine_model_view', $data, TRUE), 'amb_medicine_model', TRUE); 
       
   
    }
    function load_inspection_ambulance_main(){
        $type = $this->post['type'];
        $data['type'] = $type;
        if($type=='1'){
            $this->output->add_to_position($this->load->view('frontend/inspection/maintainance_of_vehicle_view', $data, TRUE), 'maintaince_ambulance_type_view', TRUE);
        }else if($type=='2'){
            $this->output->add_to_position($this->load->view('frontend/inspection/maintainance_of_vehicle_view', $data, TRUE), 'maintaince_ambulance_type_view', TRUE);
        }
        else if($type=='3'){
            $this->output->add_to_position($this->load->view('frontend/inspection/maintainance_of_vehicle_view', $data, TRUE), 'maintaince_ambulance_type_view', TRUE);
        }
        else if($type=='4'){
            $this->output->add_to_position($this->load->view('frontend/inspection/maintainance_of_vehicle_view', $data, TRUE), 'maintaince_ambulance_type_view', TRUE);
        }
        else if($type=='5'){
            $this->output->add_to_position($this->load->view('frontend/inspection/maintainance_of_vehicle_view', $data, TRUE), 'maintaince_ambulance_type_view', TRUE);
        }
        else if($type=='6'){
            $this->output->add_to_position($this->load->view('frontend/inspection/maintainance_of_vehicle_view', $data, TRUE), 'maintaince_ambulance_type_view', TRUE);
        }
        else if($type=='7'){
            $this->output->add_to_position($this->load->view('frontend/inspection/maintainance_of_vehicle_view', $data, TRUE), 'maintaince_ambulance_type_view', TRUE);
        }
        
       
    }
}
?>