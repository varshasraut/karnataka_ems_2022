<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Amb extends EMS_Controller
{

    function __construct()
    {



        parent::__construct();



        $this->active_module = "M-AMBU";

        $this->pg_limit = $this->config->item('pagination_limit');



        $this->gps_url = $this->config->item('amb_gps_url');

        $this->gps_url_pcmc = $this->config->item('amb_gps_url_pcmc');
        $this->google_api_key = $this->config->item('google_api_key');
        $this->gps_url_pmc = $this->config->item('amb_gps_url_pmc');
        $this->gps_url_Ahmednagar = $this->config->item('amb_gps_url_Ahmednagar');
        $this->amb_gps_url_bike = $this->config->item('amb_gps_url_bike');


        $this->load->model(array('Dashboard_model_final_updated', 'colleagues_model', 'get_city_state_model', 'options_model', 'module_model', 'amb_model', 'inc_model', 'pcr_model', 'hp_model', 'ambmain_model', 'dashboard_model'));



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

    public function index($generated = false)
    {

        echo "This is Ambulance controller";
    }

    ////////////////MI44////////////////////
    //

    //Purpose:Listing ambulance data
    //

    ////////////////////////////////////////





    function amb_listing()
    {

        //////////// Filter////////////
        $district_id = $this->clg->clg_district_id;
        $clg_group = $this->clg->clg_group;
        $district_id = explode(",", $district_id);
        $regex = "([\[|\]|^\"|\"$])";
        $replaceWith = "";
        $district_id = preg_replace($regex, $replaceWith, $district_id);

        if (is_array($district_id)) {
            $district_id = implode("','", $district_id);
        }

        $data['rg_no'] = ($this->post['rg_no']) ? $this->post['rg_no'] : $this->fdata['rg_no'];
        $data['search_amb'] = ($this->post['search_amb']) ? $this->post['search_amb'] : $this->fdata['search_amb'];
        $data['amb_search'] = ($this->post['amb_search']) ? $this->post['amb_search'] : $this->fdata['amb_search'];
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $ambflt['AMB'] = $data;

        ///////////set page number////////////////////
        $page_no = 1;
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        //////////////////////////limit & offset//////

        $data['get_count'] = TRUE;


        //$district_id = "";
        if ($this->clg->clg_group ==  'UG-DM' || $this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER') {

            $district_code = $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if (is_array($clg_district_id)) {
                $district_id = implode("','", $clg_district_id);
            }
            $data['amb_district'] = $district_id;
        }

        if ($this->clg->clg_group ==  'UG-AMB-Supervisor') {

            $data['amb_supervisor'] = $this->clg->clg_ref_id;
        }

        if ($this->clg->thirdparty != '1') {
            $data['district_id'] = $district_id;
            $data['thirdparty'] = $this->clg->thirdparty;
        } else {
            $data['thirdparty'] = $this->clg->thirdparty;
        }

        $data['total_count'] = $this->amb_model->get_amb_data_listing($data);
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

        //        var_dump($data);

        $data['result'] = $this->amb_model->get_amb_data_listing($data, $offset, $limit);


        // result

        //$data['get_data'] = $this->amb_model->get_working_area();


        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("amb/amb_listing"),
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
        $this->output->add_to_position($this->load->view('frontend/amb/amb_list_view', $data, TRUE), $this->post['output_position'], TRUE);

        $this->output->add_to_position($this->load->view('frontend/amb/amb_filters_view', $data, TRUE), 'amb_filters', TRUE);
        $this->output->template = "emt";
    }
    function up_amb_status()
    {

        $status = $this->amb_model->update_amb_status(array('amb_status' => $this->post['amb_sts'], 'amb_id' => $this->post['amb_id']));
        //var_dump($status);die();
        if ($status) {
            $this->output->message = "<div class='success'>Ambulance status updated successfully<script>$('.module_ambulancemanagement .mt_amb_list').click();</script></div>";
            $this->amb_listing();
        } else {
            $this->output->message = "<div class='error'>Ambulance status is not updated</div>";
        }
    }
    function change_status()
    {

        $amb_details = $this->input->post();
        $amb_id = base64_decode($amb_details['amb_id']);
        $args = array(
            'amb_id' => $amb_id,
        );
        $data['status'] = $amb_details['status'];
        $data['amb_id'] = $amb_id;
        $data['get_amb_details'] = $this->amb_model->get_amb_data($args);

        // $this->output->add_to_position($this->load->view('frontend/amb/update_amb_status', $data, TRUE), 'popup_div', TRUE);
        $this->output->add_to_popup($this->load->view('frontend/amb/update_ambs_status', $data, TRUE), '600', '560');
    }
    function save_change_status()
    {

        $amb_details = $this->input->post();
        $amb_id = base64_decode($amb_details['amb_id']);

        $data = array(
            'amb_id' => $amb_id,
            'amb_status' => $amb_details['amb_status'],
        );


        $update = $this->amb_model->update_amb($data);

        $data_sum = array(
            'amb_reg_id' => $amb_details['amb_reg_no'],
            'current_amb_status' => $amb_details['amb_status'],
            'old_amb_status' => $amb_details['amb_old_status'],
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
        );


        $summary = $this->amb_model->insert_update_amb_summary($data_sum);

        if ($update) {
            $this->output->closepopup = 'yes';
            $this->output->status = 1;
            $this->output->message = "<div class='success'>" . "Ambulance status updated successfully </div>";
            $this->amb_listing();
        }
    }
    ////////////////MI44////////////////////
    //

    //Purpose:Add ambulance data
    //

    ////////////////////////////////////////

    function add_amb()
    {
        // echo $this->post['start_odo'];die();
        $district_id = $this->clg->clg_district_id;
        $district_id = explode(",", $district_id);
        $regex = "([\[|\]|^\"|\"$])";
        $replaceWith = "";
        $district_id = preg_replace($regex, $replaceWith, $district_id);

        if (is_array($district_id)) {
            $district_id = implode("','", $district_id);
        }
        $data['thirdparty'] = $this->clg->thirdparty;
        $result1 = $this->common_model->get_thirdparty_nm(array('thirdparty' => $this->clg->thirdparty));
        $data['thirdparty_name'] = $result1[0]->thirdparty_name;
        if ($this->post['submit_amb']) {

            $result = $this->common_model->get_district(array('dst_code' => $this->post['amb_district']));
            $division_id = $result[0]->div_id;

            if ($this->post['amb_district'] == '') {
                $amb_district = $this->post['hp_dtl_wrd_district'];
            }
            if ($this->post['hp_dtl_wrd_district'] == '') {
                $amb_district = $this->post['amb_district'];
            }
            if ($this->post['amb_tehsil'] == '') {
                $amb_tehsil = $this->post['amb_tehsil'];
            }
            $data = array(
                'amb_rto_register_no' => $this->post['reg_no'],
                'amb_default_mobile' => $this->post['mb_no'],
                'pilot_nm' => $this->post['pilot_nm'],
                'vehical_make' => $this->post['vehical_make'],
                'vehical_make_type' => $this->post['vehical_model'],
                'vehical_model' => $this->post['model'],
                'amb_owner' => $this->post['amb_owner'],
                'ward_name' => $this->post['ward_name'],
                'amb_pilot_mobile' => $this->post['pilot_mb_no'],
                'amb_serial_number' => $this->post['amb_serial_no'],
                'amb_working_area' => $this->post['working_area'],
                'amb_google_address' => $this->post['hp_add'],
                'amb_state' => $this->post['hp_dtl_state'],
                'amb_div_code' => $division_id,
                'amb_district' => $this->post['hp_dtl_districts'],
                'amb_tahsil' => $this->post['hp_dtl_tahsil'],
                'amb_city' => $this->post['hp_dtl_ms_city'],
                'amb_lat' => $this->post['lttd'],
                'amb_log' => $this->post['lgtd'], 
                'amb_type' => $this->post['amb_type'],
                'amb_supervisor' => $this->post['amb_supervisor'],
                'amb_vendor' => $this->post['amb_vendor'],
                'thirdparty' => $this->post['amb_cat'],
                'amb_category' => $this->post['amb_category'],
                'amb_status' => '1',
                'ambis_backup' => $this->post['ambis_backup'],
                'amb_user_type' => $this->post['amb_sys_type'],
                'amb_user' => $this->post['amb_sys_type'],
                'amb_base_location' => $this->post['base_location'],
                'amb_gps_imei_no' => $this->post['amb_gps_imei_no'],
                'amb_gps_sim_no' => $this->post['amb_gps_sim_no'],
                'amb_mdt_srn_no' => $this->post['amb_mdt_srn_no'],
                'amb_mdt_imei_no' => $this->post['amb_mdt_imei_no'],
                'amb_mdt_simcnt_no' => $this->post['amb_mdt_simcnt_no'],
                'chases_no' => $this->post['chases_no'],
                
                'amb_added_by' => $this->clg->clg_ref_id,
                'amb_added_date' => date('Y-m-d H:i:s'),
            );


            //var_dump($data);die();
            $result = $this->amb_model->check_reg_no($data);

            $data_timestamp = array(
                'amb_rto_register_no' => $this->post['reg_no'],
                'start_odmeter' => $this->post['start_odo'],
                'end_odmeter' => $this->post['start_odo'],
                'total_km' => 0,
                'timestamp' => date('Y-m-d H:i:s'),
                'remark' => "New Ambulance added",
                'flag' => "1",
            );


            if ($result === TRUE) {
                $thirdparty = $this->clg->thirdparty;

                if ($thirdparty != '1') {
                    if ($district_id == $amb_district) {
                        $insert = $this->amb_model->insert_amb($data);
                        if (!$insert) {
                            $this->output->message = "<div class='error'>Not registered.. please retry</div>";
                        } else {
                            $this->output->closepopup = 'yes';
                            $this->output->status = 1;
                            $this->output->message = "<div class='success'>" . "Ambulance details is added successfully" . "</div>";
                            $this->amb_listing();
                            $insert1 = $this->amb_model->insert_timestamp_record($data_timestamp);
                        }
                    } else {
                        $this->output->message = "<div class='error'>District not matched...please try again</div>";
                        return FALSE;
                    }
                } else {
                    $insert = $this->amb_model->insert_amb($data);
                    if (!$insert) {
                        $this->output->message = "<div class='error'>Not registered.. please retry</div>";
                    } else {
                        $this->output->closepopup = 'yes';
                        $this->output->status = 1;
                        $this->output->message = "<div class='success'>" . "Ambulance details is added successfully" . "</div>";
                        $this->amb_listing();
                        $insert1 = $this->amb_model->insert_timestamp_record($data_timestamp);
                    }
                }
            } else if ($result == FALSE) {
                $this->output->message = "<div class='error'>Duplicate register number.. Not allowed.. please try to differnt register number..</div>";
                return FALSE;
            }
        }
        $data['start_odo'] = $this->post['start_odo'];

        $this->output->add_to_position($this->load->view('frontend/amb/add_amb_view', $data, TRUE), 'popup_div', TRUE);
    }
    ////////////////MI44////////////////////
    //

    //Purpose: Delete ambulance data
    //

    ////////////////////////////////////////
    function del_amb()
    {

        if ($this->post['amb_id'] != '') {
            $amb_id = array_map("base64_decode", $this->post['amb_id']);
        }
        if (empty($amb_id)) {
            $this->output->message = "<div class='error'>Please select at least one item to delete</div>";
            return;
        }
        $args['ambis_deleted'] = '1';

        $status = $this->amb_model->delete_amb($amb_id, $args);

        if ($status) {
            $this->output->message = "<div class='success'>Ambulance details is deleted successfully.<script>$('.module_ambulancemanagement .mt_amb_list').click();</script></div>";
            $this->amb_listing();
        } else {
            $this->output->message = "<div class='error'>Ambulance details is not deleted</div>";
        }
    }

    //// Created by MI44 ////////////////////
    // 
    // Purpose : To edit/view ambulance data
    // 
    /////////////////////////////////////////



    function edit_amb()
    {

        $data['amb_action'] = $this->input->post('amb_action');
        $district_id = $this->clg->clg_district_id;
        $clg_group = $this->clg->clg_group;
        $district_id = explode(",", $district_id);
        $regex = "([\[|\]|^\"|\"$])";
        $replaceWith = "";
        $district_id = preg_replace($regex, $replaceWith, $district_id);

        if (is_array($district_id)) {
            $district_id = implode("','", $district_id);
        }


        if ($this->post['amb_id'] != '') {
            $amb_id = array_map("base64_decode", $this->post['amb_id']);
        }
        if ($this->input->post('submit_amb', TRUE)) {

        if($this->post['amb_vendor'] == '')
        {
            $vendor = NULL;
        }
        else
        {
            $vendor = $this->post['amb_vendor'];
        }

            $data = array(
                'amb_id' => $amb_id[0],
                // 'amb_pilot_mobile' => $this->post['pilot_mb_no'],
                // 'amb_working_area' => $this->post['working_area'],
                // 'amb_default_mobile' => $this->post['mb_no'],
                // 'pilot_nm' => $this->post['pilot_nm'],
                // 'vehical_make' => $this->post['vehical_make'],
                // 'vehical_make_type' => $this->post['vehical_model'],
                // 'vehical_model' => $this->post['model'],
                // 'amb_owner' => $this->post['amb_owner'],
                // 'amb_type' => $this->post['amb_type'],
                // 'amb_category' => $this->post['amb_category'],
                // 'amb_serial_number' => $this->post['amb_serial_no'],
                // 'amb_user_type' => $this->post['amb_sys_type'],
                // 'amb_user' => $this->post['amb_sys_type'],
                // 'amb_base_location' => $this->post['base_location'],
                // 'amb_gps_imei_no' => $this->post['amb_gps_imei_no'],
                // 'amb_gps_sim_no' => $this->post['amb_gps_sim_no'],
                // 'amb_mdt_srn_no' => $this->post['amb_mdt_srn_no'],
                // 'amb_mdt_imei_no' => $this->post['amb_mdt_imei_no'],
                // 'amb_mdt_simcnt_no' => $this->post['amb_mdt_simcnt_no'],
                // 'amb_supervisor' => $this->post['amb_supervisor'],
                // 'amb_vendor' => $vendor,
                // 'amb_state' => $this->post['hp_dtl_state'],
                // 'amb_district' => $this->post['hp_dtl_districts'],
                // 'amb_tahsil' => $this->post['hp_dtl_tahsil'],
                // 'amb_city' => $this->post['hp_dtl_ms_city'],
                // 'amb_google_address' => $this->post['hp_add'],
                // 'chases_no' => $this->post['chases_no'],
                // 'thirdparty' => $this->post['amb_cat'],
                'amb_default_mobile' => $this->post['mb_no'],
                'pilot_nm' => $this->post['pilot_nm'],
                'vehical_make' => $this->post['vehical_make'],
                'vehical_make_type' => $this->post['vehical_model'],
                'vehical_model' => $this->post['model'],
                'amb_owner' => $this->post['amb_owner'],
                'ward_name' => $this->post['ward_name'],
                'amb_pilot_mobile' => $this->post['pilot_mb_no'],
                'amb_serial_number' => $this->post['amb_serial_no'],
                'amb_working_area' => $this->post['working_area'],
                'amb_google_address' => $this->post['hp_add'],
                'amb_state' => $this->post['hp_dtl_state'],
                'amb_div_code' => $division_id,
                'amb_district' => $this->post['hp_dtl_districts'],
                'amb_tahsil' => $this->post['hp_dtl_tahsil'],
                'amb_city' => $this->post['hp_dtl_ms_city'],
                'amb_lat' => $this->post['lttd'],
                'amb_log' => $this->post['lgtd'], 
                'amb_type' => $this->post['amb_type'],
                'amb_supervisor' => $this->post['amb_supervisor'],
                'amb_vendor' => $vendor,
                'thirdparty' => $this->post['amb_cat'],
                'amb_category' => $this->post['amb_category'],
                // 'amb_status' => '1',
                'ambis_backup' => $this->post['ambis_backup'],
                'amb_user_type' => $this->post['amb_sys_type'],
                'amb_user' => $this->post['amb_sys_type'],
                'amb_base_location' => $this->post['base_location'],
                'amb_gps_imei_no' => $this->post['amb_gps_imei_no'],
                'amb_gps_sim_no' => $this->post['amb_gps_sim_no'],
                'amb_mdt_srn_no' => $this->post['amb_mdt_srn_no'],
                'amb_mdt_imei_no' => $this->post['amb_mdt_imei_no'],
                'amb_mdt_simcnt_no' => $this->post['amb_mdt_simcnt_no'],
                'chases_no' => $this->post['chases_no'],
                'amb_modify_by' => $this->clg->clg_ref_id,
                'amb_modify_date' => date('Y-m-d H:i:s')
            );
            // if ($this->post['hp_dtl_state'] != "") {
            //     $data['amb_state'] = $this->post['hp_dtl_state'];
            // }
            // if ($this->post['hp_dtl_districts'] != "") {
            //     $data['amb_district'] = $this->post['hp_dtl_districts'];
            // }
            // if ($this->post['lttd'] != "") {
            //     $data['amb_lat'] = $this->post['lttd'];
            // }
            // if ($this->post['lgtd'] != "") {
            //     $data['amb_log'] = $this->post['lgtd'];
            // }
            // if ($this->post['hp_add'] != "") {
            //     $data['amb_google_address'] = $this->post['hp_add'];
            // }
            // if ($this->post['base_location'] != "") {
            //     $data['amb_base_location'] = $this->post['base_location'];
            // }
            // if ($this->post['hp_dtl_ms_city'] != "") {
            //     $data['amb_city'] = $this->post['hp_dtl_ms_city'];
            // }
            // if ($this->post['amb_type'] != "") {
            //     $data['amb_type'] = $this->post['amb_type'];
            // }
            // if ($this->post['working_area'] != "") {
            //     $data['amb_working_area'] = $this->post['working_area'];
            // }

            $update = $this->amb_model->update_amb($data);
            $amb_no = $this->amb_model->get_amb_by_id($data);
            
            $amb_no = (array)$amb_no;
            $amb_no = (array)$amb_no[0];
            // print_r($amb_no);die();
            $mod = $this->session->userdata('current_user');
            $mod = (array)$mod;
            // print_r($mod);die();
            $amb_reg_no = $amb_no['amb_rto_register_no'];
            
            if ($update) {
                $this->output->closepopup = 'yes';
                $this->output->status = 1;
                $this->output->closepopup = "yes";
                $this->output->message = "<div class='success'>Ambulance details updated successfully</div>";
                $this->amb_listing($post_data);
               
            } else {
                $this->output->message = "<div class='error'>Ambulance details is not updated.</div>";
            }
        }

        $data['amb_id'] = $amb_id[0];

        // $data['update'] = $this->amb_model->get_amb_data($data);
        $data['update'] = $this->amb_model->get_amb_data_new($data);

        $data['update_data'] = $this->amb_model->get_working_area($data);
        $data['thirdparty'] = $this->clg->thirdparty;
        $result1 = $this->common_model->get_thirdparty_nm(array('thirdparty' => $this->clg->thirdparty));
        $data['thirdparty_name'] = $result1[0]->thirdparty_name;

        $this->output->add_to_position($this->load->view('frontend/amb/add_amb_view', $data, TRUE), 'popup_div', TRUE);
    }
    function reopen_ambid()
    {
        if ($this->post['amb_id'] != '') {

            $amb_id = array_map("base64_decode", $this->post['amb_id']);
        }
        $data['amb_id'] = $amb_id[0];

        $data['update'] = $this->amb_model->get_amb_data($data);

        $this->output->add_to_position($this->load->view('frontend/amb/reopen_ambid_view', $data, TRUE), 'popup_div', TRUE);
    }
    function  reopen_ambid_save()
    {
        $replace_amb_info = $this->input->post();
        if ($this->post['submit_amb']) {

            $data['amb_rto_register_no'] = $replace_amb_info['replace'];
            // $amb_details = $this->amb_model->get_amb_data($data);
            //$hp_name = $amb_details[0]->hp_name;
            //hp_name
            $data = array(
                'assign_amb_no' => $replace_amb_info['assign'],
                'incident_no' => $replace_amb_info['incident_no'],
                //'replace_amb_no' => $replace_amb_info['replace'],
                'remark' => $this->post['remark'],
                'added_by' => $this->clg->clg_ref_id,
                'date_and_time' =>  $replace_amb_info['date']
            );
            $update = array(
                // 'replace' => $replace_amb_info['replace'],
                'incident_no' => $replace_amb_info['incident_no'],

            );
            // var_dump($update);die();
            $insert = $this->amb_model->insert_reopen_ambid($data);
            //epcr
            $update_ambulance = $this->amb_model->update_reopen_id($update);

            $update_ambulance_timestmp = $this->amb_model->update_reopen_timestam($update);

            //incidedance
            $update_ambulance1 = $this->amb_model->update_reopen_id_incident($update);


            if ($insert && !$update_ambulance && !$update_ambulance1) {
                $this->output->message = "<div class='error'>ID Not Open...</div>";
            } else {
                $this->output->closepopup = 'yes';
                $this->output->status = 1;
                $this->output->message = "<div class='success'>" . "Ambulance Id Reopen successfully Done" . "</div>";
                $this->amb_listing();
            }
        }
    }
    function replac_amb()
    {
        if ($this->post['amb_id'] != '') {

            $amb_id = array_map("base64_decode", $this->post['amb_id']);
        }
        $data['amb_id'] = $amb_id[0];

        $data['update'] = $this->amb_model->get_amb_data($data);

        $this->output->add_to_position($this->load->view('frontend/amb/replac_amb_view', $data, TRUE), 'popup_div', TRUE);
    }


    function  replac_amb_save()
    {
        $replace_amb_info = $this->input->post();
        if ($this->post['submit_amb']) {

            $data['amb_rto_register_no'] = $replace_amb_info['replace'];
            $amb_details = $this->amb_model->get_amb_data($data);
            $hp_name = $amb_details[0]->hp_name;
            //hp_name
            $data = array(
                'assign_amb_no' => $replace_amb_info['assign'],
                'incident_no' => $replace_amb_info['incident_no'],
                'replace_amb_no' => $replace_amb_info['replace'],
                'remark' => $this->post['remark'],
                'added_by' => $this->clg->clg_ref_id,
                'date_and_time' =>  $replace_amb_info['date']
            );
            $update = array(
                'replace' => $replace_amb_info['replace'],
                'incident_no' => $replace_amb_info['incident_no'],
                'base_location_name' => $hp_name
            );
            // var_dump($update);die();
            $insert = $this->amb_model->insert_replace_amb($data);
            $update_ambulance = $this->amb_model->update_replace_amb($update);
            $args = array('inc_ref_id' => $replace_amb_info['incident_no']);

            $incident_data = $this->inc_model->get_inc_ref_id($args);

            if ($incident_data[0]->inc_type == 'on_scene_care') {
                $amb_details1 = $this->inc_model->get_ambulance_details_API($replace_amb_info['replace']);
                $amb_lat = $amb_details1[0]->amb_lat;
                $amb_log = $amb_details1[0]->amb_log;
                $thirdparty = $amb_details1[0]->thirdparty;
                $ward_id = $amb_details1[0]->ward_id;
                $ward_name = $amb_details1[0]->ward_name;
                $hp_id = $amb_details1[0]->hp_id;
                $hp_name = $amb_details1[0]->hp_name;


                $incidence_details = array(
                    'inc_ref_id' => $replace_amb_info['incident_no'],
                    'inc_div_id' => $amb_details1[0]->amb_div_code,
                    'inc_address' => $hp_name,
                    'inc_tahshil_id' => $amb_details1[0]->amb_tahsil,
                    'inc_district_id' => $amb_details1[0]->amb_district,
                    'inc_area' => $amb_details1[0]->amb_google_address,
                    'inc_lat' => $amb_details1[0]->amb_lat,
                    'inc_long' => $amb_details1[0]->amb_log,
                );
                $inc_data = $this->inc_model->update_inc_details($incidence_details);
            }



            // $update_ambulance = $this->amb_model->update_epcr_replace_amb($update);



            if ($insert && !$update_ambulance) {

                $this->output->message = "<div class='error'>Not registered.. please retry</div>";
            } else {
                $this->output->closepopup = 'yes';
                $this->output->status = 1;
                $this->output->message = "<div class='success'>" . "Ambulance Replacement details is added successfully" . "</div>";
                $this->amb_listing();
            }
        }
    }





    function Odometerc_amb()
    {

        if ($this->post['amb_id'] != '') {
            $amb_id = array_map("base64_decode", $this->post['amb_id']);
        }

        $data['amb_id'] = $amb_id[0];
        $data['update'] = $this->amb_model->get_amb_data($data);
        $this->output->add_to_position($this->load->view('frontend/amb/odometer_amb_view', $data, TRUE), 'popup_div', TRUE);
    }
    function set_odometer()
    {
        if ($this->post['submit_amb']) {
            $data = array(
                'amb_no' => $this->post['amb'],
                'start_odometer' => $this->post['start_odometer'],
                'remark' => $this->post['remark'],
                'added_by' => $this->clg->clg_ref_id,
                'end_odometer' => $this->post['end_odometer'],
                'date_and_time' => $this->post['date']
            );
            $end = $this->post['end_odometer'];
            $total_km = $this->post['end_odometer'] - $this->post['start_odometer'];


            $update_timestamp_amb_odometer = array(
                'amb_rto_register_no' => $this->post['amb'],
                'start_odmeter' => $this->post['start_odometer'],
                'end_odmeter' => $this->post['end_odometer'],
                'total_km' => $total_km,
                'odometer_type' => 'Chng_new_fitted_odometer',
                'timestamp' => date('Y-m-d H:i:s')
            );
            $amb_no = array(
                'amb_no' => $this->post['amb']
            );
            $update_timestamp_record = array(
                'flag' => 2
            );
            $insert = $this->amb_model->insert_amb_odometer($data);
            $update_timestamp_record = $this->amb_model->update_timestamp_odometer_amb_new($update_timestamp_record, $amb_no);

            $update_timestamp_amb_odometers = $this->amb_model->insert_amb_timestamp_record($update_timestamp_amb_odometer);
            // var_dump($insert);
            //var_dump($update_timestamp_amb_odometers);die();
            if (!$insert &&  !$update_timestamp_amb_odometers) {

                $this->output->message = "<div class='error'>ERROR In Odometer change</div>";
            } else {
                $this->output->closepopup = 'yes';
                $this->output->status = 1;
                $this->output->message = "<div class='success'>" . " Odometer details is added successfully" . "</div>";
                $this->amb_listing();
            }
        }
    }
    function amb_odometer_save()
    {
        $amb_odometer_info = $this->input->post();
        if ($this->post['submit_amb']) {

            $data = array(
                'amb_no' => $amb_odometer_info['amb'],
                'incident_id' => $amb_odometer_info['insident_no'],
                'start_odometer' => $amb_odometer_info['start_odometer'],
                'remark' => $this->post['remark'],
                'added_by' => $this->clg->clg_ref_id,
                'end_odometer' => $amb_odometer_info['end_odometer'],
                'date_and_time' => $amb_odometer_info['date']
            );
            $end = $this->post['end_odometer'];
            $amb_odometer_info['total_km'] = $amb_odometer_info['end_odometer'] - $amb_odometer_info['start_odometer'];

            $update_amb_odometer = array(
                'start_odometer' => $amb_odometer_info['start_odometer'],
                'end_odometer' => $amb_odometer_info['end_odometer'],
                'total_km' => $amb_odometer_info['total_km']
            );

            $update_odo = array(
                'inc_ref_id' => $amb_odometer_info['insident_no']
            );
            $update_timestamp_amb_odometer = array(
                'start_odmeter' => $amb_odometer_info['start_odometer'],
                'end_odmeter' => $amb_odometer_info['end_odometer'],
                'odometer_type' => 'Chng_closure_inc',
                'total_km' => $amb_odometer_info['total_km'],
                'timestamp' => date('Y-m-d H:i:s'),
                'modify_by' => $this->clg->clg_ref_id,
            );

            $timestamp = array(
                'insident_no' => $amb_odometer_info['insident_no']
            );

            $update_pcr_odometer = array(
                'start_odometer' => $amb_odometer_info['start_odometer'],
                'end_odometer' => $amb_odometer_info['end_odometer']
            );

            $pcr_odom = array(
                'insident_no' => $amb_odometer_info['insident_no']
            );


            $insert = $this->amb_model->insert_amb_odometer($data);

            $update_amb_odometers = $this->amb_model->update_odometer_amb($update_amb_odometer,  $update_odo);
            $update_timestamp_amb_odometers = $this->amb_model->update_timestamp_odometer_amb($update_timestamp_amb_odometer, $timestamp);
            $update_driver_pcr = $this->amb_model->update_driver_pcr_odometer($update_pcr_odometer, $pcr_odom);


            if (!$insert && !$$update_amb_odometers && !$update_timestamp_amb_odometers && !$update_driver_pcr) {

                $this->output->message = "<div class='error'> Not registered.. please retry</div>";
            } else {
                $this->output->closepopup = 'yes';
                $this->output->status = 1;
                $this->output->message = "<div class='success'>" . "Ambulance Odometer details is added successfully" . "</div>";
                $this->amb_listing();
            }
        }
    }
    /////////////MI44////////////////
    ///
    ///  Purpose:Action:Manage Team
    ///
    ////////////////////////////////

    function manage_team()
    {

        $data = array(
            'amb_id' => base64_decode($this->post['amb_id']),
            'amb_sts' => $this->post['amb_sts'],
            'amb_type' => $this->post['amb_type'],
            'cty_name' => $this->post['cty_name'],
            'rto_no' => $this->post['rto_no']
        );

        $data['get_amb_details'] = $this->amb_model->get_amb_data($data);

        $reg_attr = array(
            'rto_no' => $this->post['rto_no']
        );


        $get_amb_team_data = $this->amb_model->get_manage_team($reg_attr);


        $first_shift_emt = "";
        $second_shift_emt = "";
        $third_shift_emt = "";

        $first_shift_emt_name = "";
        $second_shift_emt_name = "";
        $third_shift_emt_name = "";

        $first_shift_pilot = "";
        $second_shift_pilot = "";
        $third_shift_pilot = "";

        $first_shift_pilot_name = "";
        $second_shift_pilot_name = "";
        $third_shift_pilot_name = "";



        if ($get_amb_team_data) {

            foreach ($get_amb_team_data as $team_data) {

                $emt_attr = array(
                    'clg_ref_id' => $team_data->tm_emt_id
                );
                $emt_name = $this->amb_model->get_clg_by_refid($emt_attr);

                $pilot_attr = array(
                    'clg_ref_id' => $team_data->tm_pilot_id
                );
                $pilot_name = $this->amb_model->get_clg_by_refid($pilot_attr);

                if ($team_data->tm_shift == '1') {
                    $first_shift_emt = $team_data->tm_emt_id;
                    $first_shift_emt_name = $emt_name[0]->clg_first_name . ' ' . $emt_name[0]->clg_mid_name . ' ' . $emt_name[0]->clg_last_name;

                    $first_shift_pilot = $team_data->tm_pilot_id;
                    $first_shift_pilot_name = $pilot_name[0]->clg_first_name . ' ' . $pilot_name[0]->clg_mid_name . ' ' . $pilot_name[0]->clg_last_name;
                }
                if ($team_data->tm_shift == '2') {
                    $second_shift_emt = $team_data->tm_emt_id;
                    $second_shift_emt_name = $emt_name[0]->clg_first_name . ' ' . $emt_name[0]->clg_mid_name . ' ' . $emt_name[0]->clg_last_name;

                    $second_shift_pilot = $team_data->tm_pilot_id;
                    $second_shift_pilot_name = $pilot_name[0]->clg_first_name . ' ' . $pilot_name[0]->clg_mid_name . ' ' . $pilot_name[0]->clg_last_name;;
                }
                if ($team_data->tm_shift == '3') {
                    $third_shift_emt = $team_data->tm_emt_id;
                    $third_shift_emt_name = $emt_name[0]->clg_first_name . ' ' . $emt_name[0]->clg_mid_name . ' ' . $emt_name[0]->clg_last_name;

                    $third_shift_pilot = $team_data->tm_pilot_id;
                    $third_shift_pilot_name = $pilot_name[0]->clg_first_name . ' ' . $pilot_name[0]->clg_mid_name . ' ' . $pilot_name[0]->clg_last_name;;
                }
            }
        }
        $data['first_shift_emt'] = $first_shift_emt;
        $data['second_shift_emt'] = $second_shift_emt;
        $data['third_shift_emt'] = $third_shift_emt;

        $data['first_shift_emt_name'] = $first_shift_emt_name;
        $data['second_shift_emt_name'] = $second_shift_emt_name;
        $data['third_shift_emt_name'] = $third_shift_emt_name;

        $data['first_shift_pilot'] = $first_shift_pilot;
        $data['second_shift_pilot'] = $second_shift_pilot;
        $data['third_shift_pilot'] = $third_shift_pilot;

        $data['first_shift_pilot_name'] = $first_shift_pilot_name;
        $data['second_shift_pilot_name'] = $second_shift_pilot_name;
        $data['third_shift_pilot_name'] = $third_shift_pilot_name;


        //$this->output->add_to_position($this->load->view('frontend/amb/manage_team_view', $data, TRUE), 'popup_div', TRUE);
        $this->output->add_to_popup($this->load->view('frontend/amb/manage_team_view', $data, TRUE), '1200', '600');
    }

    ////////////////MI44////////////////////
    //

    //Purpose:Add manage team.
    //

    ////////////////////////////////////////

    function add_manage_team()
    {

        if ($this->post['submit_amb_team']) {
            $pilot = $this->post['pilot'];
            $emt = $this->post['emt'];
            $rto_no = $this->post['rto_no'];

            if (array_filter($pilot) && array_filter($emt)) {

                $insert = $this->amb_model->insert_manage_team($pilot, $emt, $rto_no);

                if ($insert) {

                    $this->output->closepopup = 'yes';
                    $this->output->status = 1;
                    $this->output->message = "<div class='success'>" . "Manage team is added successfully" . "</div>";
                    $this->amb_listing();
                } else {
                    $this->output->message = "<div class='error'>" . "Manage team is not added" . "</div>";
                }
            } else {
                $this->output->message = "<div class='error'>Please select at least one EMT and PILOT....</div>";
            }
        }
    }

    ////////////////MI42/////////////////////////////
    //

    //Purpose:To update ambulance location(lat,lng).
    //

    ////////////////////////////////////////////////



    function update_loctaion()
    {

        //        $data = $this->_send_curl_request($this->gps_url);
        //        $xml = simplexml_load_string($data, "SimpleXMLElement", LIBXML_NOCDATA);
        //        $json = json_encode($xml);
        //        $details = json_decode($json, TRUE);
        //        $ambu = json_decode($details[0], TRUE);

        $x = 1;
        //while($x <= 4) {

        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );

        $data = file_get_contents($this->gps_url, false, stream_context_create($arrContextOptions));

        //$data = $this->_send_curl_request($this->gps_url);

        $ambu = json_decode($data, TRUE);



        if (is_array($ambu['detail_data'])) {

            foreach ($ambu['detail_data'] as $amb) {
               

                if (isset($amb['latitude']) && isset($amb['longitude'])) {
                    $args = array(
                        'amb_rto_register_no' => str_replace('-', '', $amb['vehicle_no']),
                        'amb_google_address' => $amb['location'],
                        'gps_amb_lat' => $amb['latitude'],
                        'gps_amb_log' => $amb['longitude'],
                        'amb_speed' => $amb['speed'],
                        'amb_Ignition_status' => $amb['ignition_status'],
                        'amb_lat' => $amb['latitude'],
                        'amb_log' => $amb['longitude'],
                        'gps_date_time' => date("Y-m-d H:i:s", strtotime($amb['date_time']))
                    );
                }


                $this->amb_model->update_amb_ln($args);
            }
        }


        echo "Done";

        $this->output->template = "blank";
    }

    function gpsapi()
    {

        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );

        $data = file_get_contents($this->gps_url, false, stream_context_create($arrContextOptions));

        //        $xml = simplexml_load_string($data, "SimpleXMLElement", LIBXML_NOCDATA);
        //        $json = json_encode($xml);
        //        $details = json_decode($json, TRUE);
        //        $ambu = json_decode($details[0], TRUE);
        $ambu = json_decode($data, TRUE);

        if (is_array($ambu['detail_data'])) {

            foreach ($ambu['detail_data'] as $amb) {

                $args[] = array(
                    'amb_rto_register_no' => $amb['vehicle_no'],
                    'amb_lat' => $amb['latitude'],
                    'amb_log' => $amb['longitude']
                );
            }

            echo json_encode($args);
        }
        die();
    }

    ////////////////MI42/////////////////////////////
    //

    //Purpose:Show ambulance on map.
    //

    ////////////////////////////////////////////////



    function loc()
    {
        $args = array('inc_ref_id' => $this->uri->segment(3));
        $data['amb_data'] = $this->inc_model->get_inc_ambulance($args);
        $data['inc_data'] = $this->inc_model->get_inc_details($args);
        $data['inc_id'] = $this->uri->segment(3);

        $this->output->add_to_position($this->load->view('frontend/amb/amb_loc_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "amb_loc_map";
    }

    ////////////////MI42/////////////////////////////
    //

    //Purpose:Show all ambulance on map.
    //

    ////////////////////////////////////////////////

    function all_amb()
    {

        $args = array('base_month' => $this->post['base_month']);

        $data['amb_data'] = $this->amb_model->get_gps_amb_data($args);
        //$data['amb_data'] = $this->amb_model->get_amb_data($args);
        //var_dump($data['amb_data']);
        //$this->output->add_to_popup($this->load->view('frontend/amb/all_amb_loc_view', $data, TRUE), '1000', '800');

        $this->output->add_to_position($this->load->view('frontend/amb/all_amb_loc_pop_view', $data, TRUE), 'content', TRUE);

        //  $this->output->template = "amb_loc_map";
    }

    function nhm_all()
    {
        $args = array('base_month' => $this->post['base_month']);
        $data['amb_data'] = $this->amb_model->get_gps_amb_data($args);

        //This code for show all ambulance some of them not having incident

        // $data['amb_data'] = array();
        // $tdd_amb = $this->amb_model->get_tdd_amb();



        //            foreach( $tdd_amb as $amb){
        //                $args = array('amb_rto_register'=>$tdd->amb_rto_register_no);
        //                $amb_data = $this->amb_model->get_gps_amb_data($args);
        //               
        //                if($amb_data){
        //                    $amb_result = $amb_data;
        //                }else{
        //                    $amb_result = $amb;
        //                }
        //                
        //            }
        $data['amb_data'] =  $data['amb_data'];

        $this->output->add_to_position($this->load->view('frontend/amb/nhm_all_amb_loc_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "amb_loc_map";
    }
    function all()
    {

        $args = array('base_month' => $this->post['base_month']);

        $amb_all = array('system_type' => array('108', '102'), 'status' => '7');
        $data['amb_maintainance'] = $this->Dashboard_model_final_updated->get_amb_count($amb_all);

        $amb_available = array('system_type' => array('108', '102'), 'status' => '1');
        $data['amb_available'] = $this->Dashboard_model_final_updated->get_amb_count($amb_available);

        $amb_busy = array('system_type' => array('108', '102'), 'status' => '2');
        $data['amb_busy'] = $this->Dashboard_model_final_updated->get_amb_count($amb_busy);

        $data['amb_data'] = $this->amb_model->get_gps_amb_data();

        $data['dist'] = $this->common_model->get_district(array('st_id' => 'MP'));
        //$this->output->add_to_position($this->load->view('frontend/dash/nhm_all_amb_loc_view', $data, TRUE), 'content', TRUE);
        $this->output->add_to_position($this->load->view('frontend/amb/all_amb_loc_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "amb_loc_map";
    }
    function load_single_amb()
    {
        $amb_id = $this->input->post('amb_id');
        $args = array('amb_rto_register' => $amb_id);
        $data['amb_data'] = $this->amb_model->get_gps_amb_data($args);
        $this->output->add_to_position($this->load->view('frontend/bed/nhm_all_amb_loc_view_bed', $data, TRUE), 'tabs-2', TRUE);
        // $this->output->add_to_position($this->load->view('frontend/dash/nhm_all_amb_loc_view', $data, TRUE), 'tabs-2', TRUE);
        //$this->output->template = "amb_loc_map";
    }

    function B12_data()
    {
        $header = array(
            'Type of Emergency',
            'Today',
            'Till Date',

        );
        $start_date = '2020-03-24';
        $today_date =  date("Y/m/d");
        $report_args1 = array(
            'from_date' => date('Y-m-d', strtotime($today_date)),
            'to_date' => date('Y-m-t', strtotime($today_date))
        );
        $report_args2 = array(
            'from_date' => date('Y-m-d', strtotime($start_date)),
            'to_date' => date('Y-m-t', strtotime($today_date))
        );
        // 2020-06-01
        $report_data = $this->inc_model->get_medical_b12_report($report_args1);
        $other_data = $this->inc_model->get_other_b12_report($report_args1);
        $assault_data = $this->inc_model->get_assault_b12_report($report_args1);
        $labour_data = $this->inc_model->get_labour_b12_report($report_args1);
        $poision_data = $this->inc_model->get_poision_b12_report($report_args1);
        $trauma_data = $this->inc_model->get_trauma_b12_report($report_args1);
        $traumanon_data = $this->inc_model->get_traumanon_b12_report($report_args1);
        $attack_data = $this->inc_model->get_attack_b12_report($report_args1);
        $suicide_data = $this->inc_model->get_suicide_b12_report($report_args1);
        $burn_data = $this->inc_model->get_burn_b12_report($report_args1);
        $mass_data = $this->inc_model->get_mass_b12_report($report_args1);
        $light_data = $this->inc_model->get_light_b12_report($report_args1);

        $report_data_till = $this->inc_model->get_medical_b12_report($report_args2);
        $other_data_till = $this->inc_model->get_other_b12_report($report_args2);
        $assault_data_till = $this->inc_model->get_assault_b12_report($report_args2);
        $labour_data_till = $this->inc_model->get_labour_b12_report($report_args2);
        $poision_data_till = $this->inc_model->get_poision_b12_report($report_args2);
        $trauma_data_till = $this->inc_model->get_trauma_b12_report($report_args2);
        $traumanon_data_till = $this->inc_model->get_traumanon_b12_report($report_args2);
        $attack_data_till = $this->inc_model->get_attack_b12_report($report_args2);
        $suicide_data_till = $this->inc_model->get_suicide_b12_report($report_args2);
        $burn_data_till = $this->inc_model->get_burn_b12_report($report_args2);
        $mass_data_till = $this->inc_model->get_mass_b12_report($report_args2);
        $light_data_till = $this->inc_model->get_light_b12_report($report_args2);


        $inc_data[] = array(
            'medical' => $report_data[0]->total_count,
            'other' => $other_data[0]->total_count,
            'assault' => $assault_data[0]->total_count,
            'labour' => $labour_data[0]->total_count,
            'trauma' => $trauma_data[0]->total_count,
            'traumanon' => $traumanon_data[0]->total_count,
            'suicide' => $suicide_data[0]->total_count,
            'burn' => $burn_data[0]->total_count,
            'mass' => $mass_data[0]->total_count,
            'light' => $light_data[0]->total_count,
            'poision' => $poision_data[0]->total_count,
            'attack' => $attack_data[0]->total_count,

            'medical_till' => $report_data_till[0]->total_count,
            'other_till' => $other_data_till[0]->total_count,
            'assault_till' => $assault_data_till[0]->total_count,
            'labour_till' => $labour_data_till[0]->total_count,
            'trauma_till' => $trauma_data_till[0]->total_count,
            'traumanon_till' => $traumanon_data_till[0]->total_count,
            'suicide_till' => $suicide_data_till[0]->total_count,
            'burn_till' => $burn_data_till[0]->total_count,
            'mass_till' => $mass_data_till[0]->total_count,
            'light_till' => $light_data_till[0]->total_count,
            'poision_till' => $poision_data_till[0]->total_count,
            'attack_till' => $attack_data_till[0]->total_count,

        );
        $data['header'] = $header;
        $data['inc_data'] = $inc_data;
        $this->output->add_to_position($this->load->view('dashboard/nhm_b12_reports_view', $data, TRUE), 'content', TRUE);
        //var_dump('hii');die();
        $this->output->template = "amb_loc_map";
    }
    function amb_dir()
    {



        $args = array('inc_ref_id' => $this->uri->segment(3));


        $data['amb_data'] = $this->inc_model->get_inc_ambulance($args);
        $data['inc_data'] = $this->inc_model->get_inc_details($args);


        $data_lat = $data['inc_data'][0]->inc_lat;
        $data_lan = $data['inc_data'][0]->inc_long;
        $data['data_lat'] = $data_lat;
        $data['data_lan'] = $data_lan;


        $data['inc_id'] = $this->uri->segment(3);



        $this->output->add_to_position($this->load->view('frontend/amb/amb_dir_view', $data, TRUE), 'content', TRUE);



        $this->output->template = "amb_loc_map";
    }
    function update_amb_table_vendor()
    {
        $amb_pet_data = $this->amb_model->get_update_status_amb();
        foreach ($amb_pet_data as $amb) {
            $upadate_amb_data = array('amb_rto_register_no' => $amb->amb_no, 'card' => $amb->card, 'vendor' => $amb->vendor);
            $update_amb = $this->amb_model->update_amb_hpcl($upadate_amb_data);
        }


        //var_dump($prve_amb_data);
        die();
    }
    function update_amb_status()
    {
        $amb_data = $this->amb_model->get_amb_to_update_status();
        $amb_after_data = array();
        $amb_after_data = $this->amb_model->get_amb_before_two_hours();
        if ($amb_data) {
            foreach ($amb_data as $amb) {
                $now = now();
                $my_date_time = date('Y-m-d H:i:s', strtotime("+2 hours", strtotime($amb->assigned_time)));
                $amb_assign_time = strtotime($my_date_time);

                if ($amb_assign_time < $now) {
                    if ($amb->amb_status == '2') {
                        $upadate_amb_data = array('amb_rto_register_no' => $amb->amb_rto_register_no, 'amb_status' => 1);
                        $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
                    }
                }
            }
        }
        //var_dump($prve_amb_data);
        die();
    }




    function download_sample_format_div_dis()
    {
        $header = array(
            'District Name',
            'District ID',
            'Division ID',
        );
        $data = $this->common_model->get_district(array('st_id' => 'MH'));

        $filename = "div_dist_format.csv";
        $fp = fopen('php://output', 'w');

        header('Content-type: application/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        fputcsv($fp, $header);
        //var_dump($data);die();
        $ward_data = array();
        foreach ($data as $row) {
            //var_dump($row);
            $ward_data = array(
                'dst_nm' =>  $row->dst_name,
                'dst_id' => $row->dst_code,
                'div_id' => $row->div_id,
            );
            fputcsv($fp, $ward_data);
        }
        fclose($fp);
        exit;
    }
    function download_sample_format_ward()
    {
        $header = array(
            'Ward ID',
            'Ward Name',
        );
        $data = $this->amb_model->get_ward_name();

        $filename = "ward_format.csv";
        $fp = fopen('php://output', 'w');

        header('Content-type: application/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        fputcsv($fp, $header);
        //var_dump($data);die();
        $ward_data = array();
        foreach ($data as $row) {
            //var_dump($row);
            $ward_data = array(
                'ward_id' =>  $row->ward_id,
                'ward_nm' => $row->ward_name,
            );
            fputcsv($fp, $ward_data);
        }
        fclose($fp);
        exit;
    }
    function download_sample_format_amb_type()
    {
        $header = array(
            'ID',
            'Ambulance Type',
        );
        $data = $this->amb_model->get_amb_type();

        $filename = "amb_type_format.csv";
        $fp = fopen('php://output', 'w');

        header('Content-type: application/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        fputcsv($fp, $header);
        //var_dump($data);die();
        $ward_data = array();
        foreach ($data as $row) {
            //var_dump($row);
            $ward_data = array(
                'id' =>  $row->ambt_id,
                'amb_type' => $row->ambt_name,
            );
            fputcsv($fp, $ward_data);
        }
        fclose($fp);
        exit;
    }
    function download_sample_format_baseloc()
    {
        $header = array(
            'ID',
            'Base Location',
        );
        $data = $this->hp_model->get_hp_data();

        $filename = "amb_base_location_format.csv";
        $fp = fopen('php://output', 'w');

        header('Content-type: application/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        fputcsv($fp, $header);
        //var_dump($data);die();
        $ward_data = array();
        foreach ($data as $row) {
            //var_dump($row);
            $ward_data = array(
                'id' =>  $row->hp_id,
                'amb_type' => $row->hp_name,
            );
            fputcsv($fp, $ward_data);
        }
        fclose($fp);
        exit;
    }
    function import_amb()
    {
        $this->output->add_to_popup($this->load->view('frontend/amb/import_amb_view', $data, TRUE), '1200', '800');
        // $this->output->add_to_position($this->load->view('frontend/amb/import_amb_view', $data, TRUE), 'popup_div', TRUE);
    }
    function download_sample_format()
    {
        $header = array(
            'Ambulance Register No.',
            'Ambulance mob no [int]',
            'Pilot Name [Text]',
            'Vehical Make [Text]',
            'Vehical Model [Text]',
            'Ward ID [int]',
            'Pilot Name  [Text]',
            'Ambulance Serial Number [int]',
            'Working Area [int]',
            'Google Address [Text]',
            'Division [int]',
            'District [int]',
            'Latitide [float]',
            'Longitude [float]',
            'Ambulance Type [int]',
            'ThirdParty [Text] ',
            'Base Location [int]',

        );
        $filename = "Add_ambulance_format.csv";
        $fp = fopen('php://output', 'w');

        header('Content-type: application/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        fputcsv($fp, $header);
        $data = array(
            'amb_rto_register_no' => 'MH-11-AA-1111',
            'amb_default_mobile' => '2222222222',
            'pilot_nm' => 'XYZ',
            'vehical_make' => 'Maruti',
            'vehical_model'  => '1234',
            'ward_name' => '3',
            'amb_pilot_mobile' => '1111111111',
            'amb_serial_number' => '1234',
            'amb_working_area' => '2',
            'amb_google_address' => 'Bhopal, Madhyapradesh, India',
            'amb_div_code' => '3',
            'amb_district' => '518',
            'amb_lat' => '12.777777',
            'amb_log' => '12.9999989',
            'amb_type' => '2',
            'thirdparty' => '1',
            'amb_base_location' => '2',

        );
        fputcsv($fp, $data);
        fclose($fp);
        exit;
    }
    function load_case_closure_odo()
    {
        $amb = $this->input->post('amb');
        $data['amb'] = $amb;
        $this->output->add_to_position($this->load->view('frontend/amb/load_case_closure_odo_view', $data, TRUE), 'odo_view', TRUE);
    }
    function load_new_fitted_odo()
    {
        $amb = $this->input->post('amb');
        $data['amb'] = $amb;
        $this->output->add_to_position($this->load->view('frontend/amb/load_new_fitted_odo_view', $data, TRUE), 'odo_view', TRUE);
    }
    function load_wardlocation_address()
    {
        //var_dump('hi');die();
        $post_data = $this->input->post('wardlocation');
        $data['ward_id'] = $post_data;
        $data['update'] = $this->hp_model->get_ward_data($data);
        $this->output->add_to_position($this->load->view('frontend/amb/load_wardlocation_address_view', $data, TRUE), 'load_baselocation_address', TRUE);
    }
    function save_import_amb()
    {

        $post_data = $this->input->post();
        $filename = $_FILES["file"]["tmp_name"];

        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($filename, "r");
            while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
                $column_count = count($getData);
                // var_dump($column_count);
                if ($column_count == 17) {
                    if ($count == 0) {
                        $count++;
                        continue;
                    } else {
                        $amb_data = array(

                            'amb_rto_register_no' => $getData[0],
                            'amb_default_mobile' => $getData[1],
                            'pilot_nm' => $getData[2],
                            'vehical_make' => $getData[3],
                            'vehical_model'  => $getData[4],
                            'ward_name' => $getData[5],
                            'amb_pilot_mobile' => $getData[6],
                            'amb_serial_number' => $getData[7],
                            'amb_working_area' => $getData[8],
                            'amb_google_address' => $getData[9],
                            'amb_state' => 'MP',
                            'amb_div_code' => $getData[10],
                            'amb_district' => $getData[11],
                            'amb_lat' => $getData[12],
                            'amb_log' => $getData[13],
                            'amb_type' => $getData[14],
                            'thirdparty' => $getData[15],
                            'amb_status' => '1',
                            'amb_base_location' => $getData[16],
                            'modify_date_sync' => date('Y-m-d H:i:s')
                        );


                        $insert = $this->amb_model->insert_amb($amb_data);
                    }
                } else {
                    $this->output->message = "<div class='error'>" . "Ambulance column count not match" . "</div>";
                }
            }
            if ($insert) {

                $this->output->closepopup = 'yes';
                $this->output->status = 1;
                $this->output->message = "<div class='success'>" . "Ambulance is added successfully" . "</div>";
                $this->amb_listing();
            } else {
                $this->output->message = "<div class='error'>" . "Ambulance is not added" . "</div>";
            }
        }
    }
    function load_amb_typewise()
    {

        $amb_id = $this->input->post('amb_id');
        if ($amb_id == 'all') {
            //$args = array('amb_rto_register' => $amb_id);
        } else if ($amb_id == '108amb') {
            $args = array('108amb' => $amb_id);
        } else if ($amb_id == '102amb') {
            $args = array('102amb' => $amb_id);
        } else {
            $args = array('amb_rto_register' => $amb_id);
        }
        $data['amb_data'] = $this->amb_model->get_gps_amb_data($args);
        $data['amb_rto_register'] = $amb_id;
        $this->output->add_to_position($this->load->view('frontend/amb/all_amb_loc_view', $data, TRUE), 'content', TRUE);
        // $this->output->template = ('blank');
        $this->output->template = "amb_loc_map";
    }
    function load_single_amb_dash()
    {
        $amb_id = $this->input->post('amb_id');
        $args = array('amb_rto_register' => $amb_id);
        //var_dump($args);die();
        $data['amb_data'] = $this->amb_model->get_gps_amb_data($args);
        $this->output->add_to_position($this->load->view('frontend/amb/all_amb_loc_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "amb_loc_map";
    }
    function load_baselocation_address()
    {
        $post_data = $this->input->post('base_location');
        //var_dump($post_data);

        $data['hp_id'] = $post_data;

        $data['update'] = $this->hp_model->get_hp_data($data);
        //        var_dump($data['update']);
        //        die();

        $this->output->add_to_position($this->load->view('frontend/amb/load_baselocation_address_view', $data, TRUE), 'load_baselocation_address', TRUE);
    }
    function amb_odometer_listing(){

        $post_data = $this->input->post();

        if ($post_data['flt'] == 'true') {
            $data['incient_district'] = $post_data['incient_district'];
            $data['incient_ambulance'] = $post_data['incient_ambulance'];

            if ($post_data['to_date'] != '' && $post_data['from_date'] != '') {
                $data['to_date'] = date('Y-m-d', strtotime($post_data['to_date']));
                $data['from_date'] = date('Y-m-d', strtotime($post_data['from_date']));
            } else {
                $data['to_date'] = date('Y-m-d');
                $data['from_date'] = date('Y-m-d', strtotime("-1 days"));
            }

            //$data['result'] = $this->amb_model->get_amb_odometer_listing($data);
        } else {
            $data['flt'] = $post_data['flt'] ? $post_data['flt'] : $this->fdata['flt'];
            $data['incient_district'] = $post_data['incient_district'] ? $post_data['incient_district'] : $this->fdata['incient_district'];
            $data['incient_ambulance'] = $post_data['incient_ambulance'] ? $post_data['incient_ambulance'] : $this->fdata['incient_ambulance'];

            if ($post_data['to_date'] != '' && $post_data['from_date'] != '') {

                $data['to_date'] = date('Y-m-d', strtotime($post_data['to_date'])) ? date('Y-m-d', strtotime($post_data['to_date'])) : $this->fdata['to_date'];
                $data['from_date'] = date('Y-m-d', strtotime($post_data['from_date'])) ? date('Y-m-d', strtotime($post_data['from_date'])) : $this->fdata['from_date'];
            } else {
                $data['to_date'] = date('Y-m-d') ? date('Y-m-d') : $this->fdata['to_date'];
                $data['from_date'] = date('Y-m-d', strtotime("-1 days")) ? date('Y-m-d', strtotime("-1 days")) : $this->fdata['from_date'];
            }

            //$data['result'] = $this->amb_model->get_amb_odometer_listing($data);
        }
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else {
            $page_no = 1;
        }
        $data['get_count'] =TRUE;
        $total_cnt = $this->amb_model->get_amb_odometer_listing($data);
      
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        
       $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;
        $page_no = get_pgno($total_cnt, $limit, $page_no);
        
        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['AMB'] = $data;

        $this->session->set_userdata('filters', $ambflt);

        /////////////////////////////////////////////////////

        unset($data['get_count']);

        $data['result'] = $this->amb_model->get_amb_odometer_listing($data, $offset, $limit);
       
        $ambflt['AMB'] = $data;
        
        
        $pgconf = array(
            'url' => base_url("amb/amb_odometer_listing"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
            'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
            )
        );


        $data['pagination'] = get_pagination($pgconf);
      
        $this->output->add_to_position($this->load->view('frontend/amb/amb_odometer_listing_view', $data, TRUE), 'content', TRUE);
        
        
    }
    
    function amb_odometer_update()
    {
        $post_data = $this->input->post();
        $data['id'] = base64_decode($post_data['tm_id']);

        $data['update'] = $this->amb_model->get_amb_odometer_listing($data);
        $this->output->add_to_position($this->load->view('frontend/amb/update_odometer_view', $data, TRUE), 'content', TRUE);
    }
    function update_amb_odo()
    {
        $post_data = $this->input->post();

        $update = $this->input->post('update_odo');
        $start_odmeter = $update['start_odmeter'];
        $end_odmeter = $update['end_odmeter'];
        $total_odmeter = $end_odmeter - $start_odmeter;
        $update['id'] = base64_decode($post_data['tm_id']);
        $update['modify_by'] = $this->clg->clg_ref_id;
        $update['total_km'] = $update['total_km'];
        $update['inc_ref_id'] = $update['inc_ref_id_new'];


        if ($update['inc_ref_id_new'] != '') {
            $update_amb_odometer = array(
                'start_odometer' => $update['start_odmeter'],
                'end_odometer' => $update['end_odmeter'],
                'total_km' => $total_odmeter
            );

            $update_pcr_odometer = array(
                'start_odometer' => $update['start_odmeter'],
                'end_odometer' => $update['end_odmeter']
            );
            $pcr_odom = array(
                'insident_no' => $update['inc_ref_id_new']
            );


            $update_odo = array(
                'inc_ref_id' => $update['inc_ref_id_new']
            );

            if ($update['odometer_type'] == 'Closure') {
                $epcr_details = $this->pcr_model->get_epcr_validated($update_odo);
            } else if ($post_data['odometer_type'] == 'Case Closure') {
                $epcr_details = $this->pcr_model->get_epcr_deleted($update_odo);
            }

            $update_amb_odometers = $this->amb_model->update_odometer_amb($update_amb_odometer,  $update_odo);
            $update_driver_pcr = $this->amb_model->update_driver_pcr_odometer($update_pcr_odometer, $pcr_odom);
        }
        $data = array(
            'amb_no' => $update['amb_rto_register_no'],
            'incident_id'=> $update['inc_ref_id_new'],
            'start_odometer' => $update['start_odmeter'],
            'remark' => $this->post['update_odo_remark'],
            'added_by' => $this->clg->clg_ref_id,
            'end_odometer' => $update['end_odmeter'],
            'date_and_time' => date('Y-m-d H:i:s')
        );
        $insert = $this->amb_model->insert_amb_odometer($data);
        unset($update['inc_ref_id_new']);
        unset($update['odometer_type']);
        $result = $this->amb_model->update_amb_odometer($update);
        
        if ($result) {

            $this->output->closepopup = 'yes';
            $this->output->status = 1;
            $this->output->message = "<div class='success'>" . "Ambulance Odometer Updated successfully" . "</div>";
            $this->amb_odometer_listing();
        } else {
            $this->output->message = "<div class='error'>" . "Ambulance Odometer is not Updated" . "</div>";
        }
    }
    public function applogoutcronjob()
    {
        $time = time();
        $date = strtotime('-12 hours', $time);
        $hrs = date('Y-m-d H:i:s', $date);
        $data = $this->amb_model->logoutappuser($hrs);
        if ($data == 1) {
            echo 'success';
        }
        die;
        // echo date('d-m-y H:i', $date);
    }
    function amb_offraod()
    {
        $data['submit_function'] = 'download_offorad_report';
        $this->output->add_to_position($this->load->view('frontend/amb/nhm_file_report_view', $data, TRUE), 'content', TRUE);
    }
    function download_offorad_report()
    {
        $post_reports = $this->input->post();
        $year = $post_reports['from_year'];
        $month = $post_reports['from_date'];
        //$files_data = file_get_contents('http://210.212.165.116/Offorad_report/reports.php');
        $files_data = file_get_contents('http://10.108.1.50/Offorad_report/reports.php');

        $files = json_decode($files_data, true);
        $data['file_listing'] = $files['dir'][$year]['dir'][$month];

        $this->output->add_to_position($this->load->view('frontend/amb/nhm_file_listing_view', $data, TRUE), 'report_listing', TRUE);
    }
    function load_report_form()
    {

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        // $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');

        $post_reports = $this->input->post();
        $files = $post_reports['report_type'];
        // $files = './2015/January/Annex A-I_Jan_2015.xlsx';
        $files = explode("./", $files);
        $file = str_replace(' ', '%20', $files[1]);



        $files_data = file_get_contents('http://10.108.1.50/Offorad_report/' . $file);
        //$files_data = file_get_contents('http://210.212.165.116/Offorad_report/'.$file);
        $temp_file = time() . '.xlsx';
        // $temp_file ='1626526058.xlsx';

        file_put_contents('./temp/' . $temp_file, $files_data);

        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load(FCPATH . '/temp/' . $temp_file);
        // $d=$spreadsheet->getSheet(0)->toArray();
        $no_of_sheet = $spreadsheet->getSheetCount();
        $result_data = array();
        $sheet_names = $spreadsheet->getSheetNames();
        for ($ii = 0; $ii < $no_of_sheet; $ii++) {
            $result_data[$ii] = $spreadsheet->getSheet($ii)->toArray();
        }


        $data['result_data'] = $result_data;
        $data['sheet_names'] = $sheet_names;
        $this->output->add_to_position($this->load->view('frontend/amb/load_result_view', $data, TRUE), 'popup_div', TRUE);
    }
    function denial_report()
    {

        if ($this->clg->clg_group ==  'UG-DM' || $this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER') {

            $district_code = $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if (is_array($clg_district_id)) {
                $district_id = implode("','", $clg_district_id);
            }
            $data['amb_district'] = $district_id;
            $data['district_data'] = $this->common_model->get_district(array('st_id' => 'MP', 'district_id' => $district_id));
        } else {

            $data['district_data'] = $this->common_model->get_district(array('st_id' => 'MP'));
        }
        $this->output->add_to_position($this->load->view('frontend/amb/amb_denial_report_view', $data, TRUE), 'content', TRUE);
    }
    function view_denial_report()
    {
        $post_reports = $this->input->post();

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $to_data = date('Y-m-d', strtotime($post_reports['from_date']));
        $system = $post_reports['system'];

        $report_args = array(
            'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'system' => $system,
            'district' => $post_reports['incient_district']

        );
        $date_range = $this->getDatesFromRange($from_date, $to_data, $format = 'Y-m-d');
        $report_data = $this->pcr_model->get_denail_report($report_args);






        $header = array('Ambulance Reg No', 'District', 'Base location', 'Challenge', 'Description', 'ERC Remark', 'Date and time');
        $tl_group = array('UG-SuperAdmin', 'UG-ShiftManager', 'UG-EROSupervisor', 'UG-FLD-OPE-DESK', 'UG-ERCHead', 'UG-ERCManager', 'UG-Grievance');

        $header_sr = array();
        if (in_array($this->clg->clg_group, $tl_group)) {
            $header_sr = array('ERO Name', 'TL', 'SM');
        }
        $header = array_merge($header, $header_sr);

        if ($post_reports['reports'] == 'view') {
            $data['header'] = $header;
            $data['hpcl_data'] = $report_data;
            $data['report_args'] = $report_args;
            $data['date_range'] = $date_range;
            $data['clg_group'] = $this->clg->clg_group;
            $data['submit_function'] = 'view_denial_report';
            $this->output->add_to_position($this->load->view('frontend/amb/denial_report', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "view_denial_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();

            if ($report_data) {
                foreach ($report_data as $key => $report) {

                    $tl_group = array('UG-SuperAdmin', 'UG-ShiftManager', 'UG-EROSupervisor', 'UG-FLD-OPE-DESK', 'UG-ERCHead', 'UG-ERCManager', 'UG-Grievance');

                    if (in_array($this->clg->clg_group, $tl_group)) {
                        $clg_senior = '';
                        if ($report->clg_senior != '') {
                            $clg_senior = get_clg_name_by_ref_id($report->clg_senior);
                            $clg_senior_data = get_clg_data_by_ref_id($report->clg_senior);
                        }

                        $clg_tl =  "";
                        if ($clg_senior_data[0]->clg_senior != '') {
                            $clg_tl = get_clg_name_by_ref_id($clg_senior_data[0]->clg_senior);
                        }
                    }


                    $inc_data = array(
                        'amb_no' => $report->amb_no,
                        'dst_name' => $report->dst_name,
                        'hp_name' => $report->hp_name,
                        'challenge_val' => $report->challenge_val,
                        'meaning' => $report->meaning,
                        'denial_remark' => $report->denial_remark,
                        'added_date' => $report->added_date,
                        'added_by' => $report->clg_first_name . ' ' . $report->clg_mid_name . ' ' . $report->clg_last_name,
                        'clg_senior' => $clg_senior,
                        'clg_tl' => $clg_tl,
                    );
                    fputcsv($fp, $inc_data);
                }
            }

            fclose($fp);
            exit;
        }
    }

    function add_denial_remark()
    {
        $post_reports = $this->input->post();
        $denial_id = base64_decode($post_reports['denial_id']);
        $amb_id = $post_reports['amb'];
        $data['denial_data'] = $post_reports;
        $data['amb_id'] = $amb_id;
        $data['denial_id'] = $denial_id;
        $this->output->add_to_position($this->load->view('frontend/amb/add_denial_remark', $data, TRUE), 'popup_div', TRUE);
    }

    function save_denial_remark()
    {
        $denial_id = $this->input->post('denial_id');

        // var_dump($data);die; 
        $args_data = array(
            'denial_id' => $denial_id,
            'remark' => $this->input->post('remark'),
            'amb_id' => $this->input->post('amb_id'),
            'added_date' => date('Y-m-d H:i:s'),
            'added_by' => $this->clg->clg_ref_id
        );
        $rem = $this->dashboard_model->save_denial_remarks($args_data);

        if ($rem) {
            $this->output->message = "<h3>Add Remark</h3><br><p>Remark Added successfull.</p>";
            $this->output->moveto = 'top';
        } else {
            $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";
        }
    }
    function view_denial_remark()
    {
        $post_reports = $this->input->post();
        $denial_id = base64_decode($post_reports['denial_id']);
        $remark_data = $this->dashboard_model->get_denial_remarks($denial_id);
        $data['remark_data'] = $remark_data;
        $this->output->add_to_position($this->load->view('frontend/amb/view_denial_remark', $data, TRUE), 'popup_div', TRUE);
    }
    function getDatesFromRange($start, $end, $format = 'Y-m-d')
    {

        // Declare an empty array
        $array = array();

        // Variable that store the date interval
        // of period 1 day
        $interval = new DateInterval('P1D');

        $realEnd = new DateTime($end);
        $realEnd->add($interval);

        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

        // Use loop to store date into array
        foreach ($period as $date) {
            $array[] = $date->format($format);
        }

        // Return the array elements
        return $array;
    }
    function load_baselocation_amb()
    {
        $base_id = $this->input->post('base_id');
        $data['base_id'] = $base_id;

        $args = array('hp_id' => $base_id);
        $data['amb_data'] = $this->amb_model->get_map_amb_data($args);


        $this->output->add_to_position($this->load->view('frontend/common/manual_baselocation_ambulace_search', $data, TRUE), 'baselocation_ambulance', TRUE);
    }
    function pvt_load_baselocation_amb_address()
    {

        $post = $this->input->post();

        $base_id = $this->input->post('base_id');
        $bs_dis = 0;
        $hp_dis = 0;
        $hp_base = 0;

        $inc_amb_args = array('rto_no' => $post['inc_amb']);
        $amb_data = $this->amb_model->get_amb_make_model_by_regno($inc_amb_args);
        $ambu_price = $amb_data[0]->ambu_price;
        $data['price']=$ambu_price;


        $base_args = array('hp_id' => $base_id);
        $base_data = $this->hp_model->get_hp_data_hospital($base_args);



        $data['baselocation_address'] = $base_data[0]->hp_address;
        $data['amb_category'] = $base_data[0]->amb_category;
        $data['ambt_name'] = $base_data[0]->ambt_name;
        $data['hp_district_name'] =  $base_data[0]->dst_name;
        $data['hosp_type'] = $base_data[0]->full_name;
        
        $google_api_key = $this->google_api_key;

        $destination = trim($post['base_lat']) . ',' . trim($post['base_lng']);
        $origins_str = trim($this->input->post('inc_lat')) . ',' . trim($this->input->post('inc_lng'));

        $google_map_url = 'https://matrix.route.ls.hereapi.com/routing/7.2/calculatematrix.json?mode=fastest;car;traffic:enabled;&start0=' . $destination . '&destination0=' . $origins_str . '&apiKey=' . $google_api_key . '&summaryAttributes=traveltime,distance';

        $location_data = file_get_contents($google_map_url);
        $location_data = json_decode($location_data, true);

        if ($location_data) {
            foreach ($location_data['response']['matrixEntry'] as $distance) {

                $bs_dis = $distance['summary']['distance'];
                $road_distance = round((($distance['summary']['distance']) / 1000), 2) . " Km";
            }
        }
        $data['inc_base_road_distance'] = $road_distance;


        //$destination_hp = trim($post['base_lat']) . ',' . trim($post['base_lng']);
        $destination_str = trim($this->input->post('inc_lat')) . ',' . trim($this->input->post('inc_lng'));
        $origins_str_hp = trim($base_data[0]->hp_lat) . ',' . trim($base_data[0]->hp_long);

        $google_map_url = 'https://matrix.route.ls.hereapi.com/routing/7.2/calculatematrix.json?mode=fastest;car;traffic:enabled;&start0=' . $destination_str . '&destination0=' . $origins_str_hp . '&apiKey=' . $google_api_key . '&summaryAttributes=traveltime,distance';

        $location_data = file_get_contents($google_map_url);
        $location_data = json_decode($location_data, true);

        if ($location_data) {
            foreach ($location_data['response']['matrixEntry'] as $distance) {

                $hp_dis = $distance['summary']['distance'];
                $hp_road_distance = round((($distance['summary']['distance']) / 1000), 2) . " Km";
            }
        }
        $data['base_hp_road_distance'] = $hp_road_distance;

        $data['total_dist'] = round((($total_dist) / 1000), 2) . " Km";

        $destination_hp = trim($post['base_lat']) . ',' . trim($post['base_lng']);
        $origins_str_hp = trim($base_data[0]->hp_lat) . ',' . trim($base_data[0]->hp_long);

        $google_map_url = 'https://matrix.route.ls.hereapi.com/routing/7.2/calculatematrix.json?mode=fastest;car;traffic:enabled;&start0=' . $destination_hp . '&destination0=' . $origins_str_hp . '&apiKey=' . $google_api_key . '&summaryAttributes=traveltime,distance';

        $location_data = file_get_contents($google_map_url);
        $location_data = json_decode($location_data, true);

        if ($location_data) {
            foreach ($location_data['response']['matrixEntry'] as $distance) {

                $hp_base = $distance['summary']['distance'];
                $hp_base_distance = round((($distance['summary']['distance']) / 1000), 2) . " Km";
            }
        }
        $data['hp_base_distance'] = $hp_base_distance;

        $total_dist = $hp_dis + $bs_dis + $hp_base;
        $data_total_dist = round((($total_dist) / 1000), 2);
        $data['total_dist'] = round((($total_dist) / 1000), 2) . " Km";

        $data['total_amount'] = $data_total_dist * $ambu_price;
        
        $data['total_amount'] = number_format($data['total_amount'], 2, '.', '');
        $this->output->add_to_position($this->load->view('frontend/inc/incident_drop_address', $data, TRUE), 'incident_drop_address', TRUE);
        
         $this->output->add_to_position($this->load->view('frontend/inc/private_hospital_data', $data, TRUE), 'private_hospital_data', TRUE);
        $this->output->add_to_position($this->load->view('frontend/inc/incident_distance_block', $data, TRUE), 'distance_block', TRUE);
    }

    function amb_odometer_listing_all(){

        $post_data = $this->input->post();

        if ($post_data['flt'] == 'true') {
            $data['incient_district'] = $post_data['incient_district'];
            $data['incient_ambulance'] = $post_data['incient_ambulance'];

            if ($post_data['to_date'] != '' && $post_data['from_date'] != '') {
                $data['to_date'] = date('Y-m-d', strtotime($post_data['to_date']));
                $data['from_date'] = date('Y-m-d', strtotime($post_data['from_date']));
            } else {
                $data['to_date'] = date('Y-m-d');
                $data['from_date'] = date('Y-m-d', strtotime("-1 days"));
            }

            //$data['result'] = $this->amb_model->get_amb_odometer_listing($data);
        } else {
            $data['flt'] = $post_data['flt'] ? $post_data['flt'] : $this->fdata['flt'];
            $data['incient_district'] = $post_data['incient_district'] ? $post_data['incient_district'] : $this->fdata['incient_district'];
            $data['incient_ambulance'] = $post_data['incient_ambulance'] ? $post_data['incient_ambulance'] : $this->fdata['incient_ambulance'];

            if ($post_data['to_date'] != '' && $post_data['from_date'] != '') {

                $data['to_date'] = date('Y-m-d', strtotime($post_data['to_date'])) ? date('Y-m-d', strtotime($post_data['to_date'])) : $this->fdata['to_date'];
                $data['from_date'] = date('Y-m-d', strtotime($post_data['from_date'])) ? date('Y-m-d', strtotime($post_data['from_date'])) : $this->fdata['from_date'];
            } else {
                $data['to_date'] = date('Y-m-d') ? date('Y-m-d') : $this->fdata['to_date'];
                $data['from_date'] = date('Y-m-d', strtotime("-1 days")) ? date('Y-m-d', strtotime("-1 days")) : $this->fdata['from_date'];
            }

            //$data['result'] = $this->amb_model->get_amb_odometer_listing($data);
        }
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else {
            $page_no = 1;
        }
        $data['get_count'] =TRUE;
        $total_cnt = $this->amb_model->get_amb_odometer_listing_all($data);
      
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        
       $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;
        $page_no = get_pgno($total_cnt, $limit, $page_no);
        
        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['AMB'] = $data;
        
        $this->session->set_userdata('filters', $ambflt);

        /////////////////////////////////////////////////////

        unset($data['get_count']);

        $data['result'] = $this->amb_model->get_amb_odometer_listing_all($data, $offset, $limit);
       
        $ambflt['AMB'] = $data;
        
        
        $pgconf = array(
            'url' => base_url("amb/amb_odometer_listing_all"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
            'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
            )
        );


        $data['pagination'] = get_pagination($pgconf);
      
        $this->output->add_to_position($this->load->view('frontend/amb/amb_odo_filter_view', $data, TRUE), 'content', TRUE);
    }

    function update_amb_odo_all()
    {
        $post_data = $this->input->post();

        $update = $this->input->post('update_odo');
        $start_odmeter = $update['start_odmeter'];
        $scene_odometer = $update['scene_odometer'];
        $from_scene_odometer= $update['from_scene_odometer'];
        $handover_odometer = $update['handover_odometer'];
        $hospital_odometer = $update['hospital_odometer'];
        $end_odmeter = $update['end_odmeter'];
        // $other_remark = $update['other_remark'];
        $total_odmeter = $end_odmeter - $start_odmeter;
        $update['id'] = base64_decode($post_data['tm_id']);
        $update['modify_by'] = $this->clg->clg_ref_id;
        $update['total_km'] = $update['total_km'];
        $update['inc_ref_id'] = $update['inc_ref_id_new'];

            $update_amb_odometer = array(
                'start_odmeter' => $update['start_odmeter'],
                'end_odmeter' => $update['end_odmeter'],
                'scene_odometer' =>$update['scene_odometer'],
                'from_scene_odometer'=>$update['from_scene_odometer'],
                'handover_odometer' =>$update['handover_odometer'],
                'hospital_odometer' =>$update['hospital_odometer'],
                // 'other_remark' => $update['other_remark'],
                'total_km' => $total_odmeter
            );
            
            $update_odo = array(
                'amb_rto_register_no' => $update['amb_rto_register_no'],
                'inc_ref_id' => $update['inc_ref_id']
            );

            $update_amb_odometers = $this->amb_model->update_timestamp_odometer_amb_all($update_amb_odometer,  $update_odo);
    
        if ($update_amb_odometers) {

            $this->output->closepopup = 'yes';
            $this->output->status = 1;
            $this->output->message = "<div class='success'>" . "Ambulance Odometer Updated successfully" . "</div>";
            $this->amb_odometer_listing_all();
        } else {
            $this->output->message = "<div class='error'>" . "Ambulance Odometer is not Updated" . "</div>";
        }
    }

    // toggle flag between 1 & 2
    function update_amb_odo_flag(){
        $update =  $this->input->post();
        $ref=$update['inc_ref_id'];
        $receivedflag=$update['flag'];
        
        $show_flag = $this->amb_model->show_timestamp_flag($ref);


        $flag = $show_flag['0']['flag'];
        if($flag==1){
            $set_flag=2;
            $update_amb_odometers = $this->amb_model->update_timestamp_flag($ref,$set_flag);
        }else if($flag==2){
            $set_flag=1;
            $update_amb_odometers = $this->amb_model->update_timestamp_flag($ref,$set_flag);
        }else{
            echo "Set Flag Error";
        }
       
        // print_r($flag);die;
        
    }
    function amb_odometer_enable_status_all(){

        $post_data = $this->input->post();

        if ($post_data['flt'] == 'true') {
            $data['incient_district'] = $post_data['incient_district'];
            $data['incient_ambulance'] = $post_data['incient_ambulance'];

            if ($post_data['to_date'] != '' && $post_data['from_date'] != '') {
                $data['to_date'] = date('Y-m-d', strtotime($post_data['to_date']));
                $data['from_date'] = date('Y-m-d', strtotime($post_data['from_date']));
            } else {
                $data['to_date'] = date('Y-m-d');
                $data['from_date'] = date('Y-m-d', strtotime("-1 days"));
            }

            //$data['result'] = $this->amb_model->get_amb_odometer_listing($data);
        } else {
            $data['flt'] = $post_data['flt'] ? $post_data['flt'] : $this->fdata['flt'];
           
            $data['incient_district'] = $post_data['incient_district'] ? $post_data['incient_district'] : $this->fdata['incient_district'];
            $data['incient_ambulance'] = $post_data['incient_ambulance'] ? $post_data['incient_ambulance'] : $this->fdata['incient_ambulance'];

            if ($post_data['to_date'] != '' && $post_data['from_date'] != '') {

                $data['to_date'] = date('Y-m-d', strtotime($post_data['to_date'])) ? date('Y-m-d', strtotime($post_data['to_date'])) : $this->fdata['to_date'];
                $data['from_date'] = date('Y-m-d', strtotime($post_data['from_date'])) ? date('Y-m-d', strtotime($post_data['from_date'])) : $this->fdata['from_date'];
            } else {
                $data['to_date'] = date('Y-m-d') ? date('Y-m-d') : $this->fdata['to_date'];
                $data['from_date'] = date('Y-m-d', strtotime("-1 days")) ? date('Y-m-d', strtotime("-1 days")) : $this->fdata['from_date'];
            }

            //$data['result'] = $this->amb_model->get_amb_odometer_listing($data);
        }
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else {
            $page_no = 1;
        }
        $data['get_count'] =TRUE;
        $total_cnt = $this->amb_model->get_amb_odometer_listing_all($data);
      
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        
       $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;
        $page_no = get_pgno($total_cnt, $limit, $page_no);
        
        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['AMB'] = $data;

        $this->session->set_userdata('filters', $ambflt);

        /////////////////////////////////////////////////////

        unset($data['get_count']);
        $enable['enable'] = $this->amb_model->get_amb_odometer_enable_all($data);
        $data['result'] = $this->amb_model->get_amb_odometer_listing_all($data, $offset, $limit);
       
        $ambflt['AMB'] = $data;
        
        
        $pgconf = array(
            'url' => base_url("amb/amb_odometer_listing_all"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
            'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
            )
        );


        $data['pagination'] = get_pagination($pgconf);
      
        $this->output->add_to_position($this->load->view('frontend/amb/amb_odo_filter_view', $data, TRUE), 'content', TRUE);
    }
    function amb_odometer_disable_status_all(){

        $post_data = $this->input->post();

        if ($post_data['flt'] == 'true') {
            $data['incient_district'] = $post_data['incient_district'];
            $data['incient_ambulance'] = $post_data['incient_ambulance'];

            if ($post_data['to_date'] != '' && $post_data['from_date'] != '') {
                $data['to_date'] = date('Y-m-d', strtotime($post_data['to_date']));
                $data['from_date'] = date('Y-m-d', strtotime($post_data['from_date']));
            } else {
                $data['to_date'] = date('Y-m-d');
                $data['from_date'] = date('Y-m-d', strtotime("-1 days"));
            }

            //$data['result'] = $this->amb_model->get_amb_odometer_listing($data);
        } else {
            $data['flt'] = $post_data['flt'] ? $post_data['flt'] : $this->fdata['flt'];
           
            $data['incient_district'] = $post_data['incient_district'] ? $post_data['incient_district'] : $this->fdata['incient_district'];
            $data['incient_ambulance'] = $post_data['incient_ambulance'] ? $post_data['incient_ambulance'] : $this->fdata['incient_ambulance'];

            if ($post_data['to_date'] != '' && $post_data['from_date'] != '') {

                $data['to_date'] = date('Y-m-d', strtotime($post_data['to_date'])) ? date('Y-m-d', strtotime($post_data['to_date'])) : $this->fdata['to_date'];
                $data['from_date'] = date('Y-m-d', strtotime($post_data['from_date'])) ? date('Y-m-d', strtotime($post_data['from_date'])) : $this->fdata['from_date'];
            } else {
                $data['to_date'] = date('Y-m-d') ? date('Y-m-d') : $this->fdata['to_date'];
                $data['from_date'] = date('Y-m-d', strtotime("-1 days")) ? date('Y-m-d', strtotime("-1 days")) : $this->fdata['from_date'];
            }

            //$data['result'] = $this->amb_model->get_amb_odometer_listing($data);
        }
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else {
            $page_no = 1;
        }
        $data['get_count'] =TRUE;
        $total_cnt = $this->amb_model->get_amb_odometer_listing_all($data);
      
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        
       $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;
        $page_no = get_pgno($total_cnt, $limit, $page_no);
        
        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['AMB'] = $data;

        $this->session->set_userdata('filters', $ambflt);

        /////////////////////////////////////////////////////

        unset($data['get_count']);
        $disable['disable'] = $this->amb_model->get_amb_odometer_disable_all($data);
        $data['result'] = $this->amb_model->get_amb_odometer_listing_all($data, $offset, $limit);
       
        $ambflt['AMB'] = $data;
        
        
        $pgconf = array(
            'url' => base_url("amb/amb_odometer_listing_all"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
            'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
            )
        );


        $data['pagination'] = get_pagination($pgconf);
      
        $this->output->add_to_position($this->load->view('frontend/amb/amb_odo_filter_view', $data, TRUE), 'content', TRUE);
    }
    function amb_all_odometer_update()
    {
        $post_data = $this->input->post();
        $data['id'] = base64_decode($post_data['tm_id']);

        $data['update'] = $this->amb_model->get_amb_odometer_listing($data);
        $this->output->add_to_position($this->load->view('frontend/amb/update_all_odometer_view', $data, TRUE), 'content', TRUE);
    }

    
}
