<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Base_location extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->active_module = "M-BASE-LOC";

        $this->pg_limit = $this->config->item('pagination_limit');

        $this->load->model(array('colleagues_model', 'get_city_state_model', 'options_model', 'module_model', 'hp_model'));

        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper'));

        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));

        $this->post = $this->input->get_post(NULL);

        if ($this->post['filters'] == 'reset') {
            $this->session->unset_userdata('filters')['HP'];
        }

        if ($this->session->userdata('filters')['HP']) {
            $this->fdata = $this->session->userdata('filters')['HP'];
        }
        $this->post['base_month'] = get_base_month();
        $this->clg = $this->session->userdata('current_user');
    }

    public function index($generated = false) {
        echo "This is Hospital controller";
    }

    ////////////MI44////////////////////////////
    //
    //Purpose : Hosital Listing
    //
    /////////////////////////////////////////////

    function bs_listing() {

        //////////// ////////////////Filter/////////////////////////////////////////////

        $data['hp_name'] = ($this->post['h_name']) ? $this->post['h_name'] : $this->fdata['h_name'];

        $data['mob_no'] = ($this->post['mob_no']) ? $this->post['mob_no'] : $this->fdata['mob_no'];

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        $hpflt['HP'] = $data;

        //////////////////////set page number//////////////////////////////////////////

        $page_no = 1;
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }

        //////////////////////////limit & offset////////////////////////////////////


        $data['get_count'] = TRUE;
        
        $district_id = "";
        //var_dump($this->clg->clg_group);
        if($this->clg->clg_group ==  'UG-DM' || $this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
            $data['amb_district'] = $district_id;
            
        }

        $data['total_count'] = $this->hp_model->get_hp_data($data);

        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        ///////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $hpflt['HP'] = $data;

        $this->session->set_userdata('filters', $hpflt);

        /////////////////////////////////////////////
        unset($data['get_count']);
        $district_id = $this->clg->clg_district_id;
        $clg_group = $this->clg->clg_group;
       // var_dump($clg_group);die;
        if($clg_group=='UG-REMOTE' || $clg_group=='UG-Remote-ShiftManager'){

            $district_id = explode( ",", $district_id);
        $regex = "([\[|\]|^\"|\"$])"; 
         $replaceWith = ""; 
        $district_id = preg_replace($regex, $replaceWith, $district_id);
        if(is_array($district_id)){
            $district_id = implode("','",$district_id);
        }
            $data['district_id'] = $district_id;
        }
        unset($data['get_count']);

        $data['result'] = $this->hp_model->get_hp_data($data, $offset, $limit);

        $data['get_data'] = $this->hp_model->get_hp_to_city();
        $data['get_data1'] = $this->hp_model->get_hp_to_dist();
        $data['cur_page'] = $page_no;
       //var_dump($data['get_data'] );die;
        $pgconf = array(
            'url' => base_url("base_location/bs_listing"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        $data['pagination'] = get_pagination($pgconf);

        $this->output->add_to_position($this->load->view('frontend/base_location/hosp_list_view', $data, TRUE), $this->post['output_position'], TRUE);
        $data['filter_function'] = 'bs_listing';
        $this->output->add_to_position($this->load->view('frontend/base_location/hosp_filters_view', $data, TRUE), 'hosp_filters', TRUE);
    }

    ////////////MI44////////////////////////////
    //
    //Purpose : Add hosital
    //
    /////////////////////////////////////////////
    
    function add_hp() {

        if ($this->post['sub_hp']) {
            $result = $this->common_model->get_district(array('dst_code' => $this->post['hp_dtl_districts']));
            $division_id = $result[0]->div_id;
         
            $data = array(
                'hp_name' => $this->post['hp_name'],
                'hp_type' => $this->post['location_type'],
                'hp_area_type' => $this->post['working_area'],
                'hp_adm' => $this->post['adm'],
                'hp_mobile' => $this->post['mb_no'],
                'hp_system' => $this->post['system_type'],
                'geo_fence' => $this->post['geo_no'],
                'hp_register_no' => $this->post['hp_reg_no'],
                'hp_contact_person' => $this->post['hp_con_name'],
                'hp_contact_mobile' => $this->post['hp_con_no'],
                'hp_email' => $this->post['hp_email'],
              //  'hp_url' => $this->post['hp_url'],
                'hp_state' => $this->post['hp_dtl_state'],
               // 'hp_division' => $division_id,
                'hp_district' => $this->post['hp_dtl_districts'],
                'hp_tahsil' => $this->post['hp_dtl_tahsil'],
                'hp_city' => $this->post['hp_dtl_ms_city'],
                'hp_area' => $this->post['hp_dtl_area'],
                'hp_lmark' => $this->post['hp_dtl_lmark'],
               'hp_lane_street' => $this->post['hp_dtl_lane'],
//                'hp_house_no' => $this->post['hp_dtl_hno'],
               'hp_pincode' => $this->post['hp_dtl_lat'],
                'hp_address' => $this->post['hp_add'],
                'hp_lat' => $this->post['lttd'],
                'hp_long' => $this->post['lgtd'],
                'hp_status' => 1,
                'base_added_by' => $this->clg->clg_ref_id,
                'base_added_date' => date('Y-m-d H:i:s')
            );


            //var_dump($data);die();
            $result = $this->hp_model->insert_hp($data);
//die();
            if ($result) {

                $this->output->status = 1;
                $this->output->closepopup = "yes";
                $this->output->message = "<div class='success'>Base Location Added Successfully</div>";

                //////////////MI13 interhospital///////////////////////
                if ($this->post['req'] != 'ero') {
                    $this->bs_listing();
                } else {
                    $this->post['fc_type'] = $this->post['fc'];
                    $this->post['in_hp_id'] = $result;
                    $this->update_current_hos_details();
                }

                ///////////////////////////////////////
            } else {
                $this->output->message = "<div class='error'>Base Location Is Not Added.</div>";
            }
        } else {

            $data['req'] = $this->post['req'];
            $data['fc_type'] = $this->post['fc'];

            $this->output->add_to_popup($this->load->view('frontend/base_location/add_hp_view', $data, TRUE), '1200', '1000');
            // $this->output->add_to_position($this->load->view('frontend/hosp/add_hp_view',$data,TRUE),'popup_div',TRUE);
        }
    }

    ////////////MI44////////////////////////////
    //
    //Purpose : Delete hosital
    //
    /////////////////////////////////////////////
    function del_wrd(){
        if ($this->post['ward_id'] != '') {
            $ward_id = array_map("base64_decode", $this->post['ward_id']);
        }

        if (empty($ward_id)) {
            $this->output->message = "<div class='error'>Please select atleast one item to delete</div>";
            return;
        }

        $args['isdeleted'] = '1';
        $status = $this->hp_model->delete_wrd($ward_id, $args);

        if ($status) {
            $this->output->message = "<div class='success'>WARD Location details is deleted successfully.</div>";
            $this->bs_listing();
        } else {
            $this->output->message = "<div class='error'>WARD Location details is deleted successfully.</div>";
        }
    }
    function del_hp() {

        if ($this->post['hp_id'] != '') {
            $hp_id = array_map("base64_decode", $this->post['hp_id']);
        }

        if (empty($hp_id)) {
            $this->output->message = "<div class='error'>Please select atleast one item to delete</div>";
            return;
        }

        $args['hpis_deleted'] = '1';
        $status = $this->hp_model->delete_hp($hp_id, $args);

        if ($status) {
            $this->output->message = "<div class='success'>Base Location Details Is Deleted Successfully.</div>";
            $this->bs_listing();
        } else {
            $this->output->message = "<div class='error'>Base Location Details Is Deleted Successfully.</div>";
        }
    }

    ////////////MI44////////////////////////////
    //
    //Purpose : Edit hosital
    //
    /////////////////////////////////////////////
    function edit_wrd(){
        $data['wrd_action'] = $this->input->post('wrd_action');


        if ($this->post['ward_id'] != '') {
            $ward_id = array_map("base64_decode", $this->post['ward_id']);
            $ward_id = $ward_id[0];
        }

        if ($this->input->post('sub_hp', TRUE)) {
//var_dump($this->post['location_type']);die();
            $data = array(
                'ward_id' => $ward_id,
//               
                'wrd_area_type' => $this->post['working_area'],
                'mob_no' => $this->post['mb_no'],
                'wrd_state' => $this->post['hp_dtl_state'],
                'wrd_district' => $this->post['hp_dtl_districts'],
                'wrd_city' => $this->post['hp_dtl_ms_city'],
                'wrd_area' => $this->post['hp_dtl_area'],
                'wrd_lmark' => $this->post['hp_dtl_lmark'],
//                'hp_lane_street' => $this->post['hp_dtl_lane'],
//                'hp_house_no' => $this->post['hp_dtl_hno'],
                'wrd_pincode' => $this->post['hp_dtl_pincode'],
                'wrd_address' => $this->post['hp_add'],
                'wrd_lat' => $this->post['lttd'],
                'wrd_long' => $this->post['lgtd'],
                //'geo_fence' => $this->post['geo_fence'],
                'status' => 1
            );
            
            //var_dump($ward_id);die();
            $update = $this->hp_model->update_wrd($data);

            if ($update) {

                $this->output->status = 1;
                $this->output->closepopup = "yes";
                $this->output->message = "<div class='success'>Ward Location details updated successfully</div>";
                $this->ward_listing($post_data);
            } else {
                $this->output->message = "<div class='error'>Ward Location details is not updated.</div>";
            }
        } else {

            $data['ward_id'] = $ward_id[0];
            $data['update'] = $this->hp_model->get_wrd_to_dist($data);
            $this->output->add_to_popup($this->load->view('frontend/base_location/add_ward_view', $data, TRUE), '1200', '1000');
        }
    }
    function edit_hp() {

        $data['hp_action'] = $this->input->post('hp_action');


        if ($this->post['hp_id'] != '') {
            $hp_id = array_map("base64_decode", $this->post['hp_id']);
        }

        if ($this->input->post('sub_hp', TRUE)) {
//var_dump($this->post['location_type']);die();
            $data = array(
                'hp_id' => $hp_id[0],
//                'hp_name' => $this->post['hp_name'],
                'hp_type' => $this->post['type_hp'],
                'hp_area_type' => $this->post['location_type'],
                'hp_adm' => $this->post['adm'],
                'hp_type' => $this->post['working_area'],
                'hp_mobile' => $this->post['mb_no'],
                'hp_system' => $this->post['system_type'],

                'hp_register_no' => $this->post['hp_reg_no'],
                'hp_email' => $this->post['hp_email'],
                //'hp_url' => $this->post['hp_url'],
                'hp_state' => $this->post['hp_dtl_state'],
                'hp_district' => $this->post['hp_dtl_districts'],
                'hp_tahsil' => $this->post['hp_dtl_tahsil'],
                'hp_city' => $this->post['hp_dtl_ms_city'],
                'hp_area' => $this->post['hp_dtl_area'],
                'hp_lmark' => $this->post['hp_dtl_lmark'],
                'hp_contact_person' => $this->post['hp_con_name'],
                'hp_contact_mobile' => $this->post['hp_con_no'],
               'hp_lane_street' => $this->post['hp_dtl_lane'],
//                'hp_house_no' => $this->post['hp_dtl_hno'],
                'hp_pincode' => $this->post['hp_dtl_lat'],
                'hp_address' => $this->post['hp_add'],
               'hp_lat' => $this->post['lttd'],
               'hp_long' => $this->post['lgtd'],
                'geo_fence' => $this->post['geo_fence'],
                'hp_status' => 1

            );
            

            $update = $this->hp_model->update_hp($data);

            if ($update) {

                $this->output->status = 1;
                $this->output->closepopup = "yes";
                $this->output->message = "<div class='success'>Base Location Details Updated Successfully</div>";
                $this->bs_listing($post_data);
            } else {
                $this->output->message = "<div class='error'>Base Location Details Is Not Updated.</div>";
            }
        } else {

            $data['hp_id'] = $hp_id[0];
            $data['update'] = $this->hp_model->get_hp_data($data);

            //    $data['update_data'] = $this->hp_model->get_dt_th_cty($data);
            //$this->output->add_to_position($this->load->view('frontend/hosp/add_hp_view',$data,TRUE),'popup_div',TRUE);
            $this->output->add_to_popup($this->load->view('frontend/base_location/add_hp_view', $data, TRUE), '1200', '1000');
        }
    }

    ////////////MI44////////////////////////////
    //
    //Purpose : Hosital status (Active,Inactive)
    //
    /////////////////////////////////////////////

    function up_hp_status() {

        $sts = get_toggle_sts();

        $status = $this->hp_model->update_hp(array('hp_status' => $sts[$this->post['hp_sts']], 'hp_id' => $this->post['hp_id']));
        if ($status) {
            $this->output->message = "<div class='success'>Base Location Status Updated Successfully</div>";
            $this->bs_listing();
        } else {
            $this->output->message = "<div class='error'>Base Location Status Is Not Updated</div>";
        }
    }

    public function update_current_hos_details() {

        $data = array();
        $hp_id = $this->post['in_hp_id'];

        $data['hospital'] = $this->hp_model->get_hp_data(array('hp_id' => $hp_id));

        if ($this->input->post('fc_type') == 'new') {
            $data['facility'] = "new_";
            $this->output->add_to_position($this->load->view('frontend/in_hos/facility_details_view', $data, TRUE), 'new_facility_details', TRUE);
            $this->output->add_to_position($this->load->view('frontend/in_hos/facility_box_view', $data, TRUE), 'new_facility_box', TRUE);
        } else {
            $data['facility'] = "";
            $this->output->add_to_position($this->load->view('frontend/in_hos/facility_details_view', $data, TRUE), 'facility_details', TRUE);
            $this->output->add_to_position($this->load->view('frontend/in_hos/facility_box_view', $data, TRUE), 'current_facility_box', TRUE);
        }
    }
    function ward_listing() {

        //////////// ////////////////Filter/////////////////////////////////////////////
        $district_id = $this->clg->clg_district_id;
        $clg_group = $this->clg->clg_group;
        //var_dump($district_id);die();
        $district_id = explode( ",", $district_id);
            $regex = "([\[|\]|^\"|\"$])"; 
            $replaceWith = ""; 
            $district_id = preg_replace($regex, $replaceWith, $district_id);
            
            if(is_array($district_id)){
                $district_id = implode("','",$district_id);
            }
            if($clg_group=='UG-REMOTE'){
                $data['district_id'] = $district_id;
                }
                //var_dump($data['district_id']);die();
                if($this->clg->thirdparty == '4'){
                    $data['thirdparty']=$this->clg->thirdparty;
        
                }else if($this->clg->thirdparty == '3'){
                     $data['thirdparty']=$this->clg->thirdparty;
        
                }else{
                    $data['thirdparty']= "1','2";
                }
        $data['hp_name'] = ($this->post['h_name']) ? $this->post['h_name'] : $this->fdata['h_name'];

        $data['mob_no'] = ($this->post['mob_no']) ? $this->post['mob_no'] : $this->fdata['mob_no'];

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        $hpflt['HP'] = $data;

        //////////////////////set page number//////////////////////////////////////////

        $page_no = 1;
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }

        //////////////////////////limit & offset////////////////////////////////////


        $data['get_count'] = TRUE;

        $data['total_count'] = $this->hp_model->get_ward_data($data);
        
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        ///////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $hpflt['HP'] = $data;

        $this->session->set_userdata('filters', $hpflt);

        /////////////////////////////////////////////

        unset($data['get_count']);

        $data['result'] = $this->hp_model->get_ward_data($data, $offset, $limit);

        $data['get_data'] = $this->hp_model->get_wrd_to_city();
        $data['get_data1'] = $this->hp_model->get_wrd_to_dist();
        $data['cur_page'] = $page_no;
       //var_dump($data['get_data1'] );die;
        $pgconf = array(
            'url' => base_url("base_location/ward_listing"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        $data['pagination'] = get_pagination($pgconf);

        $this->output->add_to_position($this->load->view('frontend/base_location/ward_list_view', $data, TRUE), $this->post['output_position'], TRUE);

        $this->output->add_to_position($this->load->view('frontend/base_location/ward_filters_view', $data, TRUE), 'hosp_filters', TRUE);
    }
    function add_ward() {

        if ($this->post['sub_hp']) {
            $result = $this->common_model->get_district(array('dst_code' => $this->post['hp_dtl_district']));
            $division_id = $result[0]->div_id;
            $data = array(
                'ward_name' => $this->post['wrd_name'],
                'mob_no' => $this->post['mb_no'],
                'wrd_area_type' => $this->post['working_area'],

                'wrd_state' => $this->post['hp_dtl_state'],
                'wrd_division' => $division_id,
                'wrd_district' => $this->post['hp_dtl_districts'],
                'wrd_city' => $this->post['hp_dtl_city'],
                'wrd_area' => $this->post['hp_dtl_area'],
                'wrd_lmark' => $this->post['hp_dtl_lmark'],
                //'wrd_pincode' => $this->post['hp_dtl_pincode'],
                'wrd_lat' => $this->post['lttd'],
                'wrd_long' => $this->post['lgtd'],
                'wrd_address' => $this->post['hp_add'],
                'status' => 1,
                'isdeleted' => '0'
            );
           // var_dump($data);die();
            $result = $this->hp_model->insert_wrd($data);
           //var_dump($result);die();
            if ($result) {

                $this->output->status = 1;
                $this->output->closepopup = "yes";
                $this->output->message = "<div class='success'>Ward added successfully</div>";

                //////////////MI13 interhospital///////////////////////
              /*  if ($this->post['req'] != 'ero') {
                    $this->bs_listing();
                } else {
                    $this->post['fc_type'] = $this->post['fc'];
                    $this->post['in_hp_id'] = $result;
                    $this->update_current_hos_details();
                }*/

                ///////////////////////////////////////
            } else {
                $this->output->message = "<div class='error'>Ward is not added.</div>";
            }
        } else {

            $data['req'] = $this->post['req'];
            $data['fc_type'] = $this->post['fc'];

            $this->output->add_to_popup($this->load->view('frontend/base_location/add_ward_view', $data, TRUE), '1200', '1000');
            // $this->output->add_to_position($this->load->view('frontend/hosp/add_hp_view',$data,TRUE),'popup_div',TRUE);
        }
    }

}
