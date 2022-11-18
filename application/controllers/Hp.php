<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Hp extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->active_module = "M-HOSP";

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
        $this->clg = $this->session->userdata('current_user');

        $this->hospital_data_url = $this->config->item('hospital_url');
    }

    public function index($generated = false) {
        echo "This is Hospital controller";
    }

    ////////////MI44////////////////////////////
    //
    //Purpose : Hosital Listing
    //
    /////////////////////////////////////////////

    function hp_listing() {

        //////////// ////////////////Filter/////////////////////////////////////////////
        $district_id = $this->clg->clg_district_id;
       // var_dump($district_id);die();
         $district_id = explode( ",", $district_id);
             $regex = "([\[|\]|^\"|\"$])"; 
             $replaceWith = ""; 
             $district_id = preg_replace($regex, $replaceWith, $district_id);
             
             if(is_array($district_id)){
                 $district_id = implode("','",$district_id);
             }
         /*$clg_group = $this->clg->clg_group;
         if($clg_group == 'UG-REMOTE'){
             $data['district_id_new'] = $district_id;
             }*/
            //var_dump($data['district_id_new']);die();
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
        // var_dump();die();
        $district_id = "";
        if($this->clg->clg_group ==  'UG-DM' ||$this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
        }
        
        $data['amb_district'] = $district_id;

        $data['total_count'] = $this->hp_model->get_hp_data1($data);

        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        ///////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $hpflt['HP'] = $data;

        $this->session->set_userdata('filters', $hpflt);

        /////////////////////////////////////////////

        unset($data['get_count']);
        $clg_group = $this->clg->clg_group;
        if($this->clg->thirdparty != '1'){
            $data['district_id_new'] = $district_id;
        }
       
        $data['result'] = $this->hp_model->get_hp_data1($data, $offset, $limit);

        $data['get_data'] = $this->hp_model->get_hp_to_city1();
        $data['dst_data'] = $this->hp_model->get_hp_to_dist();
        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("hp/hp_listing"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        $data['pagination'] = get_pagination($pgconf);
        //var_dump($data);die();
        $this->output->add_to_position($this->load->view('frontend/hosp/hosp_list_view', $data, TRUE), $this->post['output_position'], TRUE);

        $data['filter_function'] = 'hp_listing';
        $this->output->add_to_position($this->load->view('frontend/hosp/hosp_filters_view', $data, TRUE), 'hosp_filters', TRUE);
    }

    ////////////MI44////////////////////////////
    //
    //Purpose : Add hosital
    //
    /////////////////////////////////////////////

    function add_hp() {
        $district_id = $this->clg->clg_district_id;
        $district_id = explode( ",", $district_id);
            $regex = "([\[|\]|^\"|\"$])"; 
            $replaceWith = ""; 
            $district_id = preg_replace($regex, $replaceWith, $district_id);
            
            if(is_array($district_id)){
                $district_id = implode("','",$district_id);
            }
            //var_dump($district_id);die();
        if ($this->post['sub_hp']) {

            $data = array(
                'hp_name' => $this->post['hp_name'],
                'hp_type' => $this->post['type_hp'],
                'hp_area_type' => $this->post['area_type'],
                'hp_mobile' => $this->post['mb_no'],
                'hp_contact_person' => $this->post['contact_person'],
                'hp_contact_mobile' => $this->post['contact_person_mobile'],
                'hp_register_no' => $this->post['reg_no'],
                'hp_email' => $this->post['hp_email'],
                'hp_url' => $this->post['hp_url'],
                'hp_state' => $this->post['hp_dtl_state'],
                'hp_district' => $this->post['hp_dtl_districts'],
                'hp_tahsil' => $this->post['hp_dtl_tahsil'],
                'hp_city' => $this->post['hp_dtl_ms_city'],
                'hp_area' => $this->post['hp_dtl_area'],
                'hp_lmark' => $this->post['hp_dtl_lmark'],
//                'hp_lane_street' => $this->post['hp_dtl_lane'],
//                'hp_house_no' => $this->post['hp_dtl_hno'],
//                'hp_pincode' => $this->post['hp_dtl_pincode'],
                'hp_address' => $this->post['hp_add'],
//                'hp_lat' => $this->post['lttd'],
//                'hp_long' => $this->post['lgtd'],
                'geo_fence' => $this->post['geo_fence'],
                'hp_status' => 1
            );



            if ($this->post['hp_dtl_pincode'] != '') {
                $data['hp_pincode'] = $this->post['hp_dtl_pincode'];
            }
            $clg_group = $this->clg->clg_group;
            $thirdparty = $this->clg->thirdparty;
            if($thirdparty != '1') {
                if($district_id == $this->post['hp_dtl_districts'] ){
                $result = $this->hp_model->insert_hp1($data);
                if ($result) {
                $this->output->status = 1;
                $this->output->closepopup = "yes";
                $this->output->message = "<div class='success'>Hospital added successfully</div>";

                //////////////MI13 interhospital///////////////////////
    
                if ($this->post['req'] != 'ero') {
                    $this->hp_listing();
                } else {
                    
                    $this->post['fc_type'] = $this->post['fc'];
                    $this->post['in_hp_id'] = $result;
                    $this->update_current_hos_details();
                }

                ///////////////////////////////////////
            } else {
                $this->output->message = "<div class='error'>Hospital is not added.</div>";
            }
        }else{
                $this->output->message = "<div class='error'>District not matched...please try again</div>";
                return FALSE;  
            }
        }else{
            $result = $this->hp_model->insert_hp1($data);
            if ($result) {
            $this->output->status = 1;
            $this->output->closepopup = "yes";
            $this->output->message = "<div class='success'>Hospital added successfully</div>";

            //////////////MI13 interhospital///////////////////////

            if ($this->post['req'] != 'ero') {
                $this->hp_listing();
            } else {
                
                $this->post['fc_type'] = $this->post['fc'];
                $this->post['in_hp_id'] = $result;
                $this->update_current_hos_details();
            }

            ///////////////////////////////////////
        } else {
            $this->output->message = "<div class='error'>Hospital is not added.</div>";
        }
        }
        } else {

            $data['req'] = $this->post['req'];
            $data['fc_type'] = $this->post['fc'];

            $this->output->add_to_popup($this->load->view('frontend/hosp/add_hp_view', $data, TRUE), '1200', '800');
            // $this->output->add_to_position($this->load->view('frontend/hosp/add_hp_view',$data,TRUE),'popup_div',TRUE);
        }
    }

    ////////////MI44////////////////////////////
    //
    //Purpose : Delete hosital
    //
    /////////////////////////////////////////////

    function del_hp() {

        if ($this->post['hp_id'] != '') {
            $hp_id = array_map("base64_decode", $this->post['hp_id']);
        }

        if (empty($hp_id)) {
            $this->output->message = "<div class='error'>Please select atleast one item to delete</div>";
            return;
        }

        $args['hpis_deleted'] = '1';
        $status = $this->hp_model->delete_hp1($hp_id, $args);

        if ($status) {
            $this->output->message = "<div class='success'>Hospital details is deleted successfully.</div>";
            $this->hp_listing();
        } else {
            $this->output->message = "<div class='error'>Hospital details is deleted successfully.</div>";
        }
    }

    ////////////MI44////////////////////////////
    //
    //Purpose : Edit hosital
    //
    /////////////////////////////////////////////

    function edit_hp() {

        $data['hp_action'] = $this->input->post('hp_action');
        $district_id = $this->clg->clg_district_id;
        $clg_group = $this->clg->clg_group;
        $district_id = explode( ",", $district_id);
            $regex = "([\[|\]|^\"|\"$])"; 
            $replaceWith = ""; 
            $district_id = preg_replace($regex, $replaceWith, $district_id);
            
            if(is_array($district_id)){
                $district_id = implode("','",$district_id);
            }


        if ($this->post['hp_id'] != '') {
            $hp_id = array_map("base64_decode", $this->post['hp_id']);
        }

        if ($this->input->post('sub_hp', TRUE)) {

            $data = array(
                'hp_id' => $hp_id[0],
//                'hp_name' => $this->post['hp_name'],
                'hp_type' => $this->post['type_hp'],
                'hp_area_type' => $this->post['area_type'],
                'hp_mobile' => $this->post['mb_no'],
                'hp_contact_person' => $this->post['contact_person'],
                'hp_contact_mobile' => $this->post['contact_person_mobile'],
                'hp_register_no' => $this->post['reg_no'],
                'hp_email' => $this->post['hp_email'],
                'hp_url' => $this->post['hp_url'],
                'hp_state' => $this->post['hp_dtl_state'],
                'hp_district' => $this->post['hp_dtl_district'],
                'hp_tahsil' => $this->post['hp_dtl_tahsil'],
                'hp_city' => $this->post['hp_dtl_ms_city'],
                'hp_area' => $this->post['hp_dtl_area'],
                'hp_lmark' => $this->post['hp_dtl_lmark'],
//                'hp_lane_street' => $this->post['hp_dtl_lane'],
//                'hp_house_no' => $this->post['hp_dtl_hno'],
                'hp_pincode' => $this->post['hp_dtl_pincode'],
                'hp_address' => $this->post['hp_add'],
//                'hp_lat' => $this->post['lttd'],
//                'hp_long' => $this->post['lgtd'],
                'geo_fence' => $this->post['geo_fence'],
                'hp_status' => 1
            );
            if($clg_group=='UG-REMOTE'){
                if($district_id == $this->post['hp_dtl_district']){
                                $update = $this->hp_model->update_hp1($data);

                        if ($update) {

                            $this->output->status = 1;
                            $this->output->closepopup = "yes";
                            $this->output->message = "<div class='success'>Hospital details updated successfully</div>";
                            $this->hp_listing($post_data);
                        } else {
                            $this->output->message = "<div class='error'>Hospital details is not updated.</div>";
                        }
                }else{
                    $this->output->message = "<div class='error'>District not matched...please try again</div>";
                }

            }else{
            $update = $this->hp_model->update_hp1($data);

            if ($update) {

                $this->output->status = 1;
                $this->output->closepopup = "yes";
                $this->output->message = "<div class='success'>Hospital details updated successfully</div>";
                $this->hp_listing($post_data);
            } else {
                $this->output->message = "<div class='error'>Hospital details is not updated.</div>";
            }
        }
        } else {

            $data['hp_id'] = $hp_id[0];
            $data['update'] = $this->hp_model->get_hp_data1($data);
            // print_r($data['update']);die;
            //    $data['update_data'] = $this->hp_model->get_dt_th_cty($data);
            //$this->output->add_to_position($this->load->view('frontend/hosp/add_hp_view',$data,TRUE),'popup_div',TRUE);
            $this->output->add_to_popup($this->load->view('frontend/hosp/add_hp_view', $data, TRUE), '1200', '800');
        }
    }

    ////////////MI44////////////////////////////
    //
    //Purpose : Hosital status (Active,Inactive)
    //
    /////////////////////////////////////////////

    function up_hp_status() {

        $sts = get_toggle_sts();

        $status = $this->hp_model->update_hp1(array('hp_status' => $sts[$this->post['hp_sts']], 'hp_id' => $this->post['hp_id']));
        if ($status) {
            $this->output->message = "<div class='success'>Hospital status updated successfully</div>";
            $this->hp_listing();
        } else {
            $this->output->message = "<div class='error'>Hospital status is not updated</div>";
        }
    }

    public function update_current_hos_details() {

        $data = array();
        $hp_id = $this->post['in_hp_id'];

        $data['hospital'] = $this->hp_model->get_hp_data1(array('hp_id' => $hp_id));

        if ($this->input->post('fc_type') == 'new') {
            $data['facility'] = "new_";
            $data['call_back_func'] = "facility_new_details";
            $this->output->add_to_position($this->load->view('frontend/in_hos/facility_details_view', $data, TRUE), 'new_facility_details', TRUE);
            $this->output->add_to_position($this->load->view('frontend/in_hos/facility_box_view', $data, TRUE), 'new_facility_box', TRUE);
        } else {
            $data['facility'] = "";
            $data['call_back_func'] = "facility_details";
            $this->output->add_to_position($this->load->view('frontend/in_hos/facility_details_view', $data, TRUE), 'facility_details', TRUE);
            $this->output->add_to_position($this->load->view('frontend/in_hos/facility_box_view', $data, TRUE), 'current_facility_box', TRUE);
        }
    }
    function drop_district_wise_hospital(){
        $data = array();
        $data['district_id'] = $this->post['district_id'];
        
        $data['hospital'] = $this->hp_model->get_hp_data1(array('district_id' => $data['district_id']));
        $this->output->add_to_position($this->load->view('frontend/hosp/drop_district_wise_hp', $data, TRUE), 'current_facility_box', TRUE);
    }
    function district_wise_hospital(){
        $data = array();
        $data['district_id'] = $this->post['district_id'];
        $data['chief_complete'] = $this->post['chief_complete'];
        //var_dump($data['district_id']);
        $data['hospital'] = $this->hp_model->get_hp_data1(array('district_id' => $data['district_id']));
        $this->output->add_to_position($this->load->view('frontend/hosp/district_wise_hp', $data, TRUE), 'current_facility_box', TRUE);
    }
    function district_wise_hospital_new(){
        $data = array();
        $data['district_id'] = $this->post['district_id'];
        $data['chief_complete'] = $this->post['chief_complete'];
        
        $data['hospital'] = $this->hp_model->get_hp_data1(array('district_id' => $district_id));
        $this->output->add_to_position($this->load->view('frontend/hosp/district_wise_hp_new', $data, TRUE), 'new_facility_box', TRUE);
    }
        function district_wise_hospital_epcr(){
        $data = array();
        $data['district_id'] = $this->post['district_id'];

        $data['hospital'] = $this->hp_model->get_hp_data1(array('district_id' => $district_id));
        $this->output->add_to_position($this->load->view('frontend/hosp/district_wise_hp_epcr', $data, TRUE), 'new_facility_box', TRUE);
    }
    function update_bed_details(){
        $data['hp_action'] = $this->input->post('hp_action');  
        $hos_id = array_map("base64_decode", $this->post['hp_id']);
        $clg_ref_id = $this->clg->clg_ref_id;
        $data['clg_group'] = $this->clg->clg_group;
       
        $data['title'] = 'Update Hospital Bed Avaibility';
        $result = $this->hp_model->get_hp1_data($hos_id[0]);
        $info = $this->hp_model->get_hos_details($hos_id[0]);
        
        $data['hp_name'] = $result[0]->hp_name;
        $data['hp_id'] = $result[0]->hp_id;
        $data['hospital_data'] = $info;
        //var_dump($info);die();
        $this->output->add_to_popup($this->load->view('frontend/hosp/add_bed_hp_view', $data, TRUE), '1200', '1200');
    }
    function add_bed_availability(){
        $hp_id=$this->post['hp_id'];
        $bed = $this->input->get_post('bed');
        
        if($hp_id)
        {
            $result = $this->hp_model->get_hos_details($hp_id);
            $version = $result[0]->version;
            $version = $version + 1 ;
           
            
            $clg_ref_id = $this->clg->clg_ref_id;
            $todaydate=$this->today = date('Y-m-d H:i:s');

            $bed['added_datetime'] = $todaydate;
            $bed['Hospital_id'] = $hp_id;
            $bed['status']='1';
            $bed['version']=$version;
            $bed['added_by'] = $clg_ref_id;
            $bed['actual_datetime'] = $this->post['date_time'];
            $bed['added_name'] = $this->post['added_name'];
            $result = $this->hp_model->insert_hos_bed_details($bed);
          // var_dump($result);die();
        }
        if ($result) {

            $this->output->status = 1;
            $this->output->closepopup = "yes";
            $this->output->message = "<div class='success'>Hospital deatils added successfully</div>";
            $this->hp_listing();
            
        } else {
            $this->output->message = "<div class='error'>Hospital details is not added.</div>";
        }
    }
    function import_hos_details()
    {
        $this->output->add_to_popup($this->load->view('frontend/amb/import_hos_detail_view', $data, TRUE), '1000', '800');
      
    }
    function download_sample_format(){
        $header = array(
                        'Hospital_id',
                        'COVID-19 Total_Beds [int]',
                        'COVID-19 Occupied [int]',
                        'COVID-19 Vacant [int]',
                        'COVID-19 Remarks[varchar]',
                        'Non COVID-19 Total_Beds [int]',
                        'Non COVID-19 _Occupied [int]',
                        'Non COVID-19 _Vacant [int]',
                        'Non COVID-19 _Remarks [varchar]',
                        'ICUWoVenti_Total_Beds [int]',
                        'ICUWoVenti_Occupied [int]',
                        'ICUWoVenti_Vacant [int]',
                        'ICUWoVenti_Remarks [varchar]',
                        'ICUwithVenti_Total_Beds [int]',
                        'ICUwithVenti_Occupied [int]',
                        'ICUwithVenti_Vacant [int]',
                        'ICUwithVenti_Remarks [varchar]',
                        'ICUwithdialysisBed_Total_Beds [int]',
                        'ICUwithdialysisBed_Occupied [int]',
                        'ICUwithdialysisBed_Vacant [int]',
                        'ICUwithdialysisBed_Remarks [varchar]',
                        'C19Ward_Total_Beds [int]',
                        'C19Ward_Occupied [int]',
                        'C19Ward_Vacant [int]',
                        'C19Ward_Remarks [varchar]',
                        'C19Positive_Total_Beds [int]',
                        'C19Positive_Occupied [int]',
                        'C19Positive_Vacant [int]',
                        'C19Positive_Remarks [varchar]',
                        'central_oxygen_Total_Beds [int]',
                        'central_oxygen_Occupied [int]',
                        'central_oxygen_Vacant [int]',
                        'central_oxygen_Remarks [varchar]',
                        'SspectC19_Total_Beds [int]',
                        'SspectC19_Occupied [int]',
                        'SspectC19_Vacant [int]',
                        'SspectC19_Remarks [varchar]',
                        'SspectSymptWoComorbid_Total_Beds [int]',
                        'SspectSymptWoComorbid_Occupied [int]',
                        'SspectSymptWoComorbid_Vacant [int]',
                        'SspectSymptWoComorbid_Remarks [varchar]',
                        'SspectASymptWoComorbid_Total_Beds [int]',
                        'SspectASymptWoComorbid_Occupied [int]',
                        'SspectASymptWoComorbid_Vacant [int]',
                        'SspectASymptWoComorbid_Remarks [varchar]',
                        'PositiveSymptWoComorbid_Total_Beds [int]',
                        'PositiveSymptWoComorbid_Occupied [int]',
                        'PositiveSymptWoComorbid_Vacant [int]',
                        'PositiveSymptWoComorbid_Remarks [varchar]',
                        'PositiveASymptWoComorbid_Total_Beds [int]',
                        'PositiveASymptWoComorbid_Occupied [int]',
                        'PositiveASymptWoComorbid_Vacant [int]',
                        'PositiveASymptWoComorbid_Remarks [varchar]',
                        'ASymptC19SspectwithComorbidStable_Total_Beds [int]',
                        'ASymptC19SspectwithComorbidStable_Occupied [int]',
                        'ASymptC19SspectwithComorbidStable_Vacant [int]',
                        'ASymptC19SspectwithComorbidStable_Remarks [varchar]',
                        'SymptC19SspectwithComorbidStable_Total_Beds [int]',
                        'SymptC19SspectwithComorbidStable_Occupied [int]',
                        'SymptC19SspectwithComorbidStable_Vacant [int]',
                        'SymptC19SspectwithComorbidStable_Remarks [varchar]',
                        'ASymptPositivewithComorbidStable_Total_Beds [int]',
                        'ASymptPositivewithComorbidStable_Occupied [int]',
                        'ASymptPositivewithComorbidStable_Vacant[int]',
                        'ASymptPositivewithComorbidStable_Remarks [varchar]',
                        'SymptPositivewithComorbidStable_Total_Beds [int]',
                        'SymptPositivewithComorbidStable_Occupied [int]',
                        'SymptPositivewithComorbidStable_Vacant [int]',
                        'SymptPositivewithComorbidStable_Remarks [varchar]',
                        'ASymptC19SspectwithComorbidCritical_Total_Beds[int]',
                        'ASymptC19SspectwithComorbidCritical_Occupied [int]',
                        'ASymptC19SspectwithComorbidCritical_Vacant [int]',
                        'ASymptC19SspectwithComorbidCritical_Remarks [varchar]',
                        'SymptC19SspectwithComorbidCritical_Total_Beds [int]',
                        'SymptC19SspectwithComorbidCritical_Occupied [int]',
                        'SymptC19SspectwithComorbidCritical_Vacant [int]',
                        'SymptC19SspectwithComorbidCritical_Remarks[varchar] ',
                        'ASymptC19PositivewithComorbidCritical_Total_Beds[int]',
                        'ASymptC19PositivewithComorbidCritical_Occupied [int]',
                        'ASymptC19PositivewithComorbidCritical_Vacant [int]',
                        'ASymptC19PositivewithComorbidCritical_Remarks[varchar]',
                        'SymptC19PositivewithComorbidCritical_Total_Beds[int]',
                        'SymptC19PositivewithComorbidCritical_Occupied[int]',
                        'SymptC19PositivewithComorbidCritical_Vacant[int]',
                        'SymptC19PositivewithComorbidCritical_Remarks[varchar]',
                        'MorturyBeds_Total_Beds [int]',
                        'MorturyBeds_Occupied[int]',
                        'MorturyBeds_Vacant [int]',
                        'MorturyBeds_Remarks[varchar]',
                        'Others_Total_Beds[int]',
                        'Others_Occupied[int]',
                        'Others_Vacant[int]',
                        'Others_Remarks[varchar]',
                        'NonC19ICUWoVenti_Total_Beds[int]',
                        'NonC19ICUWoVenti_Occupied[int]',
                        'NonC19ICUWoVenti_Vacant[int]',
                        'NonC19ICUWoVenti_Remarks[varchar]',
                        'NonC19ICUwithVenti_Total_Beds[int]',
                        'NonC19ICUwithVenti_Occupied[int]',
                        'NonC19ICUwithVenti_Vacant[int]',
                        'NonC19ICUwithVenti_Remarks[varchar]',
                        'NonC19ICUwithdialysisBed_Total_Beds[int]',
                        'NonC19ICUwithdialysisBed_Occupied[int]',
                        'NonC19ICUwithdialysisBed_Vacant[int]',
                        'NonC19ICUwithdialysisBed_Remarks[varchar]',
                        'NonC19Ward_Total_Beds[int]',
                        'NonC19Ward_Occupied[int]',
                        'NonC19Ward_Vacant[int]',
                        'NonC19Ward_Remarks[varchar]',
                        'actual_datetime[date time]',
                        'added_name[varchar]',
                    ); 
        $filename = "Bed_avaibility_format.csv";
        $fp = fopen('php://output', 'w');

        header('Content-type: application/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        fputcsv($fp, $header);
        $data = array (
            'Hospital_id' =>'1',
            'C19_Total_Beds' =>'2',
            'C19_Occupied' =>'1',
            'C19_Vacant' =>'1',
            'C19_Remarks' =>'XYZ',
            'NonC19_Total_Beds' =>'2',
            'NonC19_Occupied' =>'1',
            'NonC19_Vacant' =>'1',
            'NonC19_Remarks' =>'XYZ',
            'ICUWoVenti_Total_Beds' =>'2',
            'ICUWoVenti_Occupied' =>'1',
            'ICUWoVenti_Vacant' =>'1',
            'ICUWoVenti_Remarks' =>'XYZ',
            'ICUwithVenti_Total_Beds' =>'2',
            'ICUwithVenti_Occupied' =>'1',
            'ICUwithVenti_Vacant' =>'1',
            'ICUwithVenti_Remarks' =>'XYZ',
            'ICUwithdialysisBed_Total_Beds' =>'2',
            'ICUwithdialysisBed_Occupied' =>'1',
            'ICUwithdialysisBed_Vacant' =>'1',
            'ICUwithdialysisBed_Remarks' =>'XYZ',
            'C19Ward_Total_Beds' =>'2',
            'C19Ward_Occupied' =>'1',
            'C19Ward_Vacant' =>'1',
            'C19Ward_Remarks' =>'XYZ',
            'C19Positive_Total_Beds' =>'2',
            'C19Positive_Occupied' =>'1',
            'C19Positive_Vacant' =>'1',
            'C19Positive_Remarks' =>'XYZ',
            'central_oxygen_Total_Beds' =>'2',
            'central_oxygen_Occupied' =>'1',
            'central_oxygen_Vacant' =>'1',
            'central_oxygen_Remarks' =>'XYZ',
            'SspectC19_Total_Beds' =>'2',
            'SspectC19_Occupied' =>'1',
            'SspectC19_Vacant' =>'1',
            'SspectC19_Remarks' =>'XYZ',
            'SspectSymptWoComorbid_Total_Beds' =>'2',
            'SspectSymptWoComorbid_Occupied' =>'1',
            'SspectSymptWoComorbid_Vacant' =>'1',
            'SspectSymptWoComorbid_Remarks' =>'XYZ',
            'SspectASymptWoComorbid_Total_Beds' =>'2',
            'SspectASymptWoComorbid_Occupied' =>'1',
            'SspectASymptWoComorbid_Vacant' =>'1',
            'SspectASymptWoComorbid_Remarks' =>'XYZ',
            'PositiveSymptWoComorbid_Total_Beds' =>'2',
            'PositiveSymptWoComorbid_Occupied' =>'1',
            'PositiveSymptWoComorbid_Vacant' =>'1',
            'PositiveSymptWoComorbid_Remarks' =>'XYZ',
            'PositiveASymptWoComorbid_Total_Beds' =>'2',
            'PositiveASymptWoComorbid_Occupied' =>'1',
            'PositiveASymptWoComorbid_Vacant' =>'1',
            'PositiveASymptWoComorbid_Remarks' =>'XYZ',
            'ASymptC19SspectwithComorbidStable_Total_Beds' =>'2',
            'ASymptC19SspectwithComorbidStable_Occupied' =>'1',
            'ASymptC19SspectwithComorbidStable_Vacant' =>'1',
            'ASymptC19SspectwithComorbidStable_Remarks' =>'XYZ',
            'SymptC19SspectwithComorbidStable_Total_Beds' =>'2',
            'SymptC19SspectwithComorbidStable_Occupied' =>'1',
            'SymptC19SspectwithComorbidStable_Vacant' =>'1',
            'SymptC19SspectwithComorbidStable_Remarks' =>'XYZ',
            'ASymptPositivewithComorbidStable_Total_Beds' =>'2',
            'ASymptPositivewithComorbidStable_Occupied' =>'1',
            'ASymptPositivewithComorbidStable_Vacant' =>'1',
            'ASymptPositivewithComorbidStable_Remarks' =>'XYZ',
            'SymptPositivewithComorbidStable_Total_Beds' =>'2',
            'SymptPositivewithComorbidStable_Occupied' =>'1',
            'SymptPositivewithComorbidStable_Vacant' =>'1',
            'SymptPositivewithComorbidStable_Remarks' =>'XYZ',
            'ASymptC19SspectwithComorbidCritical_Total_Beds' =>'2',
            'ASymptC19SspectwithComorbidCritical_Occupied' =>'1',
            'ASymptC19SspectwithComorbidCritical_Vacant' =>'1',
            'ASymptC19SspectwithComorbidCritical_Remarks' =>'XYZ',
            'SymptC19SspectwithComorbidCritical_Total_Beds' =>'2',
            'SymptC19SspectwithComorbidCritical_Occupied' =>'1',
            'SymptC19SspectwithComorbidCritical_Vacant' =>'1',
            'SymptC19SspectwithComorbidCritical_Remarks' =>'XYZ',
            'ASymptC19PositivewithComorbidCritical_Total_Beds' =>'2',
            'ASymptC19PositivewithComorbidCritical_Occupied' =>'1',
            'ASymptC19PositivewithComorbidCritical_Vacant' =>'1',
            'ASymptC19PositivewithComorbidCritical_Remarks' =>'XYZ',
            'SymptC19PositivewithComorbidCritical_Total_Beds' =>'2',
            'SymptC19PositivewithComorbidCritical_Occupied' =>'1',
            'SymptC19PositivewithComorbidCritical_Vacant' =>'1',
            'SymptC19PositivewithComorbidCritical_Remarks' =>'XYZ',
            'MorturyBeds_Total_Beds' =>'2',
            'MorturyBeds_Occupied' =>'1',
            'MorturyBeds_Vacant' =>'1',
            'MorturyBeds_Remarks' =>'XYZ',
            'Others_Total_Beds' =>'2',
            'Others_Occupied' =>'1',
            'Others_Vacant' =>'1',
            'Others_Remarks' =>'XYZ',
            'NonC19ICUWoVenti_Total_Beds' =>'2',
            'NonC19ICUWoVenti_Occupied' =>'1',
            'NonC19ICUWoVenti_Vacant' =>'1',
            'NonC19ICUWoVenti_Remarks' =>'XYZ',
            'NonC19ICUwithVenti_Total_Beds' =>'2',
            'NonC19ICUwithVenti_Occupied' =>'1',
            'NonC19ICUwithVenti_Vacant' =>'1',
            'NonC19ICUwithVenti_Remarks' =>'XYZ',
            'NonC19ICUwithdialysisBed_Total_Beds' =>'2',
            'NonC19ICUwithdialysisBed_Occupied' =>'1',
            'NonC19ICUwithdialysisBed_Vacant' =>'1',
            'NonC19ICUwithdialysisBed_Remarks' =>'XYZ',
            'NonC19Ward_Total_Beds' =>'2',
            'NonC19Ward_Occupied' =>'1',
            'NonC19Ward_Vacant' =>'1',
            'NonC19Ward_Remarks' =>'XYZ',
            'actual_datetime' =>'2020-05-04 13:39:39',
            'added_name' =>'XYZ'
            
        );
        fputcsv($fp, $data);
        fclose($fp);
        exit;
    }
    function save_hospital_details(){
        $count = 0;
        $post_data = $this->input->post();
       $clg_ref_id = $this->clg->clg_ref_id;
        //var_dump($post_data);die();
        $filename=$_FILES["file"]["tmp_name"];   
        $todaydate=$this->today = date('Y-m-d H:i:s');
        if($_FILES["file"]["size"] > 0) {
            $file = fopen($filename, "r");
            while (($getData = fgetcsv($file, 10000, ",")) !== FALSE){
                $column_count = count($getData);
                //var_dump($getData[0]);
                if($column_count == 111){
                   
                    if($count == 0)
                    { 
                        $count++; 
                        continue;
                     }
                     else{
                    $result = $this->hp_model->get_hos_details($getData[0]);
                    $version = $result[0]->version;
                    $version = $version + 1 ;
                    $hos_data = array(
                                        'Hospital_id'=>$getData[0],
                                        'C19_Total_Beds'=>$getData[1],
                                        'C19_Occupied' =>$getData[2],
                                        'C19_Vacant'=>$getData[3],
                                        'C19_Remarks' =>$getData[4],

                                        'NonC19_Total_Beds' =>$getData[5],
                                        'NonC19_Occupied' =>$getData[6],
                                        'NonC19_Vacant' =>$getData[7],
                                        'NonC19_Remarks' =>$getData[8],

                                        'ICUWoVenti_Total_Beds' =>$getData[9],
                                        'ICUWoVenti_Occupied' =>$getData[10],
                                        'ICUWoVenti_Vacant' =>$getData[11],
                                        'ICUWoVenti_Remarks' =>$getData[12],

                                        'ICUwithVenti_Total_Beds' =>$getData[13],
                                        'ICUwithVenti_Occupied' =>$getData[14],
                                        'ICUwithVenti_Vacant' =>$getData[15],
                                        'ICUwithVenti_Remarks' =>$getData[16],

                                        'ICUwithdialysisBed_Total_Beds' =>$getData[17],
                                        'ICUwithdialysisBed_Occupied' =>$getData[18],
                                        'ICUwithdialysisBed_Vacant' =>$getData[19],
                                        'ICUwithdialysisBed_Remarks' =>$getData[20],

                                        
                                        'C19Ward_Total_Beds' =>$getData[21],
                                        'C19Ward_Occupied' =>$getData[22], 
                                        'C19Ward_Vacant' =>$getData[23],
                                        'C19Ward_Remarks' =>$getData[24],

                                        'C19Positive_Total_Beds' =>$getData[25],
                                        'C19Positive_Occupied' =>$getData[26],
                                        'C19Positive_Vacant' =>$getData[27],
                                        'C19Positive_Remarks'=> $getData[28],

                                        'central_oxygen_Total_Beds' =>$getData[29],
                                        'central_oxygen_Occupied' =>$getData[30],
                                        'central_oxygen_Vacant' =>$getData[31],
                                        'central_oxygen_Remarks'=> $getData[32],

                                        'SspectC19_Total_Beds' =>$getData[33],
                                        'SspectC19_Occupied' =>$getData[34],
                                        'SspectC19_Vacant' =>$getData[35],
                                        'SspectC19_Remarks' =>$getData[36],

                                        'SspectSymptWoComorbid_Total_Beds' =>$getData[37],
                                        'SspectSymptWoComorbid_Occupied' =>$getData[38],
                                        'SspectSymptWoComorbid_Vacant' =>$getData[39],
                                        'SspectSymptWoComorbid_Remarks' =>$getData[40],

                                        'SspectASymptWoComorbid_Total_Beds' =>$getData[41],
                                        'SspectASymptWoComorbid_Occupied' =>$getData[42],
                                        'SspectASymptWoComorbid_Vacant' =>$getData[43],
                                        'SspectASymptWoComorbid_Remarks' =>$getData[44],

                                        'PositiveSymptWoComorbid_Total_Beds'=>$getData[45],
                                        'PositiveSymptWoComorbid_Occupied' =>$getData[46],
                                        'PositiveSymptWoComorbid_Vacant'  =>$getData[47],
                                        'PositiveSymptWoComorbid_Remarks' =>$getData[48],

                                        'PositiveASymptWoComorbid_Total_Beds' =>$getData[49],
                                        'PositiveASymptWoComorbid_Occupied' =>$getData[50],
                                        'PositiveASymptWoComorbid_Vacant' =>$getData[51],
                                        'PositiveASymptWoComorbid_Remarks' =>$getData[52],
                                        
                                        'ASymptC19SspectwithComorbidStable_Total_Beds' =>$getData[53],
                                        'ASymptC19SspectwithComorbidStable_Occupied' =>$getData[54],
                                        'ASymptC19SspectwithComorbidStable_Vacant' =>$getData[55],
                                        'ASymptC19SspectwithComorbidStable_Remarks'=>$getData[56],

                                        'SymptC19SspectwithComorbidStable_Total_Beds' =>$getData[57],
                                        'SymptC19SspectwithComorbidStable_Occupied' =>$getData[58],
                                        'SymptC19SspectwithComorbidStable_Vacant' =>$getData[59],
                                        'SymptC19SspectwithComorbidStable_Remarks' =>$getData[60],

                                        'ASymptPositivewithComorbidStable_Total_Beds' =>$getData[61],
                                        'ASymptPositivewithComorbidStable_Occupied' =>$getData[62],
                                        'ASymptPositivewithComorbidStable_Vacant' =>$getData[63],
                                        'ASymptPositivewithComorbidStable_Remarks' =>$getData[64],

                                        'SymptPositivewithComorbidStable_Total_Beds' =>$getData[65],
                                        'SymptPositivewithComorbidStable_Occupied' =>$getData[66],
                                        'SymptPositivewithComorbidStable_Vacant' =>$getData[67],
                                        'SymptPositivewithComorbidStable_Remarks' =>$getData[68],

                                        'ASymptC19SspectwithComorbidCritical_Total_Beds' =>$getData[69],
                                        'ASymptC19SspectwithComorbidCritical_Occupied' =>$getData[70], 
                                        'ASymptC19SspectwithComorbidCritical_Vacant' =>$getData[71],
                                        'ASymptC19SspectwithComorbidCritical_Remarks' =>$getData[72],

                                        'SymptC19SspectwithComorbidCritical_Total_Beds' =>$getData[73],
                                        'SymptC19SspectwithComorbidCritical_Occupied' =>$getData[74],
                                        'SymptC19SspectwithComorbidCritical_Vacant' =>$getData[75],
                                        'SymptC19SspectwithComorbidCritical_Remarks' =>$getData[76],

                                        'ASymptC19PositivewithComorbidCritical_Total_Beds'=>$getData[77],
                                        'ASymptC19PositivewithComorbidCritical_Occupied' =>$getData[78],
                                        'ASymptC19PositivewithComorbidCritical_Vacant' =>$getData[79],
                                        'ASymptC19PositivewithComorbidCritical_Remarks' =>$getData[80],

                                        'SymptC19PositivewithComorbidCritical_Total_Beds' =>$getData[81],
                                        'SymptC19PositivewithComorbidCritical_Occupied' =>$getData[82],
                                        'SymptC19PositivewithComorbidCritical_Vacant' =>$getData[83],
                                        'SymptC19PositivewithComorbidCritical_Remarks' =>$getData[84],

                                        'MorturyBeds_Total_Beds' =>$getData[85],
                                        'MorturyBeds_Occupied' =>$getData[86],
                                        'MorturyBeds_Vacant' =>$getData[87], 
                                        'MorturyBeds_Remarks' =>$getData[88],

                                        'Others_Total_Beds' =>$getData[89],
                                        'Others_Occupied' =>$getData[90],
                                        'Others_Vacant'=>$getData[91], 
                                        'Others_Remarks' =>$getData[92],

                                        'NonC19ICUWoVenti_Total_Beds' =>$getData[93],
                                        'NonC19ICUWoVenti_Occupied' =>$getData[94],
                                        'NonC19ICUWoVenti_Vacant'=>$getData[95], 
                                        'NonC19ICUWoVenti_Remarks' =>$getData[96],

                                        'NonC19ICUwithVenti_Total_Beds' =>$getData[97],
                                        'NonC19ICUwithVenti_Occupied' =>$getData[98],
                                        'NonC19ICUwithVenti_Vacant'=>$getData[99], 
                                        'NonC19ICUwithVenti_Remarks' =>$getData[100],

                                        'NonC19ICUwithdialysisBed_Total_Beds' =>$getData[101],
                                        'NonC19ICUwithdialysisBed_Occupied' =>$getData[102],
                                        'NonC19ICUwithdialysisBed_Vacant'=>$getData[103], 
                                        'NonC19ICUwithdialysisBed_Remarks' =>$getData[104],

                                        'NonC19Ward_Total_Beds' =>$getData[105],
                                        'NonC19Ward_Occupied' =>$getData[106],
                                        'NonC19Ward_Vacant'=>$getData[107], 
                                        'NonC19Ward_Remarks' =>$getData[108],
                                   
                                        'version' => $version,
                                        'actual_datetime'=>$getData[109],
                                        'added_name'=>$getData[110],
                                    
                                    
                                    'status'=>'1',
                                    'added_datetime'=>$todaydate,
                                    'added_by'=>$clg_ref_id
                                    );

                    $insert = $this->hp_model->insert_hos_bed_details($hos_data);
                                }           
                }else {
                    $this->output->message = "<div class='error'>" . "Columns count not match" . "</div>";
                }

            }
            if ($insert) {

                    $this->output->closepopup = 'yes';
                    $this->output->status = 1;
                    $this->output->message = "<div class='success'>" . "Deatails is added successfully" . "</div>";
                    $this->hp_listing();
                } else {
                    $this->output->message = "<div class='error'>" . "Deatails is not added" . "</div>";
                }
            
        }
    }
    function ero_other_hospital(){
        
        $this->output->add_to_position($this->load->view('frontend/inc/other_hos_textbox_view', $data, TRUE), 'hospital_details', TRUE);
    }
    function ero_other_hospital_two(){
        
        $this->output->add_to_position($this->load->view('frontend/inc/other_hos_textbox_view_two', $data, TRUE), 'hospital_details', TRUE);
    }
    function ero_hospital(){
        //return true;
        $host = $this->input->post('host');
        
        $data['hos_details']  = $this->hp_model->get_hospital_details_ERO_new($host);
       // $data['info'] = $this->hp_model->get_hos_details($host);
        //$data['bed_count'] = $this->hp_model->get_bed_count_details();
        $this->output->add_to_position($this->load->view('frontend/inc/selected_hospital_details', $data, TRUE), 'hospital_details', TRUE);
        /*$result = $this->hp_model->get_hp1_data($host[0]);
        $data['hp_id'] = $host;
        $data['title'] = 'Hospital Bed Availability';
        $data['hp_name'] = $result[0]->hp_name;
        $clg_ref_id = $this->clg->clg_ref_id;
        $data['clg_group'] = $this->clg->clg_group;
        $hos_data = $this->amb_model->get_hos_details($host);
        $data['hospital_data'] = $hos_data;
        $this->output->add_to_popup($this->load->view('frontend/hosp/add_bed_hp_view', $data, TRUE), '1200', '1200');*/
        
    }

    function ero_hospital_new(){
        //return true;
        $host = $this->input->post('host');
        
        $data['hos_details']  = $this->hp_model->get_hospital_details_ERO($host);
       // $data['info'] = $this->hp_model->get_hos_details($host);
        //$data['bed_count'] = $this->hp_model->get_bed_count_details();
        $this->output->add_to_position($this->load->view('frontend/inc/selected_hospital_details_new', $data, TRUE), 'hospital_details', TRUE);
        /*$result = $this->hp_model->get_hp1_data($host[0]);
        $data['hp_id'] = $host;
        $data['title'] = 'Hospital Bed Availability';
        $data['hp_name'] = $result[0]->hp_name;
        $clg_ref_id = $this->clg->clg_ref_id;
        $data['clg_group'] = $this->clg->clg_group;
        $hos_data = $this->amb_model->get_hos_details($host);
        $data['hospital_data'] = $hos_data;
        $this->output->add_to_popup($this->load->view('frontend/hosp/add_bed_hp_view', $data, TRUE), '1200', '1200');*/
        
    }

    function ero_hospital1(){
        //return true;
        $host = $this->input->post('host');
        
        $data['hos_details']  = $this->hp_model->get_hospital_details_ERO($host);
       // $data['info'] = $this->hp_model->get_hos_details($host);
        //$data['bed_count'] = $this->hp_model->get_bed_count_details();
        $this->output->add_to_position($this->load->view('frontend/inc/selected_hospital_details', $data, TRUE), 'hospital_details_two', TRUE);
        /*$result = $this->hp_model->get_hp1_data($host[0]);
        $data['hp_id'] = $host;
        $data['title'] = 'Hospital Bed Availability';
        $data['hp_name'] = $result[0]->hp_name;
        $clg_ref_id = $this->clg->clg_ref_id;
        $data['clg_group'] = $this->clg->clg_group;
        $hos_data = $this->amb_model->get_hos_details($host);
        $data['hospital_data'] = $hos_data;
        $this->output->add_to_popup($this->load->view('frontend/hosp/add_bed_hp_view', $data, TRUE), '1200', '1200');*/
        
    }

    function ero_hospital1_new(){
        //return true;
        $host = $this->input->post('host');
        
        $data['hos_details']  = $this->hp_model->get_hospital_details_ERO($host);
       // $data['info'] = $this->hp_model->get_hos_details($host);
        //$data['bed_count'] = $this->hp_model->get_bed_count_details();
        $this->output->add_to_position($this->load->view('frontend/inc/selected_hospital_details_new', $data, TRUE), 'hospital_details_two', TRUE);
        /*$result = $this->hp_model->get_hp1_data($host[0]);
        $data['hp_id'] = $host;
        $data['title'] = 'Hospital Bed Availability';
        $data['hp_name'] = $result[0]->hp_name;
        $clg_ref_id = $this->clg->clg_ref_id;
        $data['clg_group'] = $this->clg->clg_group;
        $hos_data = $this->amb_model->get_hos_details($host);
        $data['hospital_data'] = $hos_data;
        $this->output->add_to_popup($this->load->view('frontend/hosp/add_bed_hp_view', $data, TRUE), '1200', '1200');*/
        
    }
    function ero_hospital_details_view(){
        $host = $this->input->post('hp_id');
        $data['hos_details']  = $this->hp_model->get_hospital_details_ERO($host);
        $result = $this->hp_model->get_hp1_data($host);
        $data['hp_id'] = $host;
        $data['title'] = 'Hospital Bed Availability';
        $data['hp_name'] = $result[0]->hp_name;
        $clg_ref_id = $this->clg->clg_ref_id;
        $data['clg_group'] = $this->clg->clg_group;
        $hos_data = $this->hp_model->get_hos_details($host);
        $data['hospital_data'] = $hos_data;
        $this->output->add_to_popup($this->load->view('frontend/hosp/add_bed_hp_view', $data, TRUE), '1200', '1200');
    }
    function update_hospital_data(){
        // $this->hospital_data_url
        
         $x = 1;
         $arrContextOptions=array(
             "ssl"=>array(
                 "verify_peer"=>false,
                 "verify_peer_name"=>false,
             ),
         );
         $data = file_get_contents($this->hospital_data_url, false, stream_context_create($arrContextOptions));
        
         $hospital_data = json_decode($data, TRUE);
        // var_dump($hospital_data);die();
       
        // $count = 754;
            foreach ($hospital_data[results] as $hos_data) {
                $result = $this->common_model->get_district(array('dst_name' => $hos_data['district']));
                $dst_id = $result[0]->dst_code;
                 
                $args = array(

                   // 'Hospital_id' => $count,
                    'API_hospital_id' => $hos_data['hospital_id'],
                    

                    'C19Positive_Occupied' => $hos_data['isolation_allocated_beds'],
                    'C19Positive_Vacant' => $hos_data['isolation_available_beds'],
                    'C19Positive_Total_Beds' => $hos_data['isolation_allocated_beds'] + $hos_data['isolation_available_beds'],

                    'central_oxygen_Occupied' => $hos_data['allocated_isolation_beds_central_Oxygen'],
                    'central_oxygen_Vacant' => $hos_data['vacent_isolation_beds_central_Oxygen'],
                    'central_oxygen_Total_Beds' => $hos_data['allocated_isolation_beds_central_Oxygen'] +  $hos_data['vacent_isolation_beds_central_Oxygen'],

                    'ICUWoVenti_Occupied' => $hos_data['icu_allocated_beds'],
                    'ICUWoVenti_Vacant' => $hos_data['icu_available_beds'],
                    'ICUWoVenti_Total_Beds' => $hos_data['icu_allocated_beds'] +  $hos_data['icu_available_beds'],

                    'ICUwithVenti_Occupied' => $hos_data['allocated_icu_bed_with_ventilator'],
                    'ICUwithVenti_Vacant' => $hos_data['vacent_icu_bed_with_ventilator'],
                    'ICUwithVenti_Total_Beds' => $hos_data['allocated_icu_bed_with_ventilator'] +  $hos_data['vacent_icu_bed_with_ventilator'],
                    	
                    'C19_Occupied' => $hos_data['isolation_allocated_beds'] + $hos_data['icu_allocated_beds'] + $hos_data['allocated_icu_bed_with_ventilator'] + $hos_data['allocated_isolation_beds_central_Oxygen'],
                    'C19_Vacant' => $hos_data['isolation_available_beds'] + $hos_data['icu_available_beds'] + $hos_data['vacent_icu_bed_with_ventilator'] + $hos_data['vacent_isolation_beds_central_Oxygen'],
                    'C19_Total_Beds' =>  $hos_data['isolation_allocated_beds'] + $hos_data['isolation_available_beds'] + $hos_data['icu_allocated_beds'] + $hos_data['icu_available_beds'] + $hos_data['allocated_icu_bed_with_ventilator'] + $hos_data['vacent_icu_bed_with_ventilator'] + $hos_data['allocated_isolation_beds_central_Oxygen'] + $hos_data['vacent_isolation_beds_central_Oxygen'],
                );
                $hp_args = array(
                    'API_hospital_id' => $hos_data['hospital_id'],
                    'hp_district' => $dst_id,
                    'hp_state' =>'MP',
                    'hp_name' => $hos_data['hospital_name'],
                );
                
              //  var_dump($args);die();
                $args['added_by']='API';
                $args['version']='1';
                $this->hp_model->update_hospital_data($args,$hp_args);
                
                 
                 //var_dump($update);
                 $count++;
            }
        $x++;
    echo "Done";
    $this->output->template = "blank";
 
    }


    
}
