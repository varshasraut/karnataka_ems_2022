<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Battery extends EMS_Controller {

    function __construct() {

        parent::__construct();


        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));
        $this->load->model(array('battery_model','amb_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper', 'language_helper'));

        $this->active_module = "M-BATTERY";

        $this->post = $this->input->get_post(NULL);
        $this->post['base_month'] = get_base_month();
        $this->clg = $this->session->userdata('current_user');

        $this->pg_limit = $this->config->item('pagination_limit_clg');
        $this->pg_limits = $this->config->item('report_clg');
        $this->default_state = $this->config->item('default_state');


        $this->today = date('Y-m-d H:i:s');
    }
    function battery_listing(){
        
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        
        $data['inc_info'] = $this->battery_model->get_total_battery($args_dash, $offset, $limit);
         
        $total_cnt = $this->battery_model->get_total_battery($args_dash);
        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;
        
        $pgconf = array(
            'url' => base_url("battery/battery_listing"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
            'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
            )
        );


        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);

        
        $this->output->add_to_position($this->load->view('frontend/battery/battery_listing_view', $data, TRUE), 'content', TRUE);
    }
    
    function add_battery_life(){
        
        $data['clg_ref_id'] = $this->clg->clg_ref_id;
              
        if ($this->post['bt_id'] != '') {

            $data['bt_id'] = $ref_id = $this->post['bt_id'];
            $data['preventive']  = $this->battery_model->get_total_battery($args_dash);
        }
        if ($this->post['action_type'] == 'Update') {

            $data['action_type'] = "Update Battery Life";
            $data['type'] = "Update";
            $data['update'] = 'True';

            
            $this->output->add_to_popup($this->load->view('frontend/battery/add_battery_life_view', $data, TRUE), '1200', '500');
          //  $this->output->add_to_position($this->load->view('frontend/battery/add_battery_life_view', $data, TRUE), 'popup_div', TRUE);
            
        }else if ($this->post['action_type'] == 'Update_replace') {

            $data['action_type'] = "Update - After Battery Replacement";
            $data['type'] = "Update_replace";

            $data['Update_replace'] = 'True';

            $this->output->add_to_popup($this->load->view('frontend/battery/add_battery_life_view', $data, TRUE), '1200', '500');
        }  else {
            
            $state_id = $this->clg->clg_state_id;
            $data['state_id'] = $state_id;
            $data['action_type'] = "Add Battery Life";
            $this->output->add_to_position($this->load->view('frontend/battery/add_battery_life_view', $data, TRUE), 'popup_div', TRUE);
            
        }
        
        //$this->output->add_to_position($this->load->view('frontend/amb/add_amb_view', $data, TRUE), 'popup_div', TRUE);
    }
    
    function battery_save(){

        $maintaince_data = $this->post['battery'];


        $maintaince = $this->input->post();
        
       // $prev= generate_maintaince_id('ems_accidental_id');
        
       // $prev_id = "MHEMS-AM-".$prev;
        

     
        $district_id =  $this->input->post('maintaince_district');
        
        $main_data = array('state' => $this->input->post('maintaince_state'),
            'district' => $district_id,
            'amb_ref_no' => $this->input->post('maintaince_ambulance'),
            'mt_in_odometer' => $this->input->post('in_odometer'),
            'mt_previos_odometer' => $this->input->post('previous_odometer'),
          //  'mt_odometer_diff' => $this->input->post('odometer_diff'),
            'base_location' => $this->input->post('base_location'),
            'amb_type' => $this->input->post('amb_type'),
            'mt_make' => $this->input->post('ambt_make'),
            'mt_module' => $this->input->post('ambt_model'),
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'base_month' => $this->post['base_month'],
            'remark' =>$this->input->post('battery[remark]'),
            'pilot_name' => $this->input->post('pilot_id'),
        );
        
        

        $args = array_merge($this->post['battery'], $main_data);
        

        
        $register_result = $this->battery_model->insert_battery_life($args);

          $total_km = (int)$this->input->post('in_odometer') - (int)$this->input->post('previous_odometer');

        $amb_record_data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'start_odmeter' => $this->input->post('previous_odometer'),
            'end_odmeter' => $this->input->post('in_odometer'),
            'total_km' => $total_km,
            'inc_ref_id'=>$register_result,
            'odometer_type'  => 'Battery Life',
            'timestamp' => date('Y-m-d H:i:s'));
            
            //var_dump($amb_record_data);die;
        if (!empty($maintaince_data['mt_remark'])) {
            $amb_record_data['other_remark'] = $maintaince_data['mt_remark'];
        }
        $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);

        $amb_update_summary = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => 1,
            'start_odometer' => $this->input->post('in_odometer'),
           'off_road_status' => "Battery Life",
            'off_road_remark' => $maintaince_data['mt_stnd_remark'],
            'off_road_date' => date('Y-m-d', strtotime($maintaince_data['mt_offroad_datetime'])),
            'off_road_time' => date('H:i:s', strtotime($maintaince_data['mt_offroad_datetime'])),
            'added_date' => date('Y-m-d H:i:s'));
          // var_dump($amb_update_summary);die;
        if (!empty($maintaince_data['mt_remark'])) {
            $amb_update_summary['off_road_remark_other'] = $maintaince_data['mt_remark'];
        }


        if ($register_result) {

           // $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
            $add_summary = $this->battery_model->insert_amb_staus_summary($amb_update_summary);

            //$update = $this->amb_model->update_amb($data);

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Battery Life Registered Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->battery_listing();
        }
    }
    
    function approve_battery_life() {

        if ($this->post['bt_id'] != '') {

            $data['bt_id'] = $ref_id = $this->post['bt_id'];
            $data['preventive']  = $this->battery_model->get_total_battery($args_dash);
        }

        
        if ($this->post['action_type'] == 'Update') {

            $data['action_type'] = "Update Battery Life";
            $data['type'] = "Update";

            $data['update'] = 'True';

            $this->output->add_to_popup($this->load->view('frontend/battery/add_battery_life_view', $data, TRUE), '1200', '500');
        } else if ($this->post['action_type'] == 'Update_replace') {

            $data['action_type'] = "Update - After Battery Replacement";
            $data['type'] = "Update_replace";

            $data['Update_replace'] = 'True';

            $this->output->add_to_popup($this->load->view('frontend/battery/add_battery_life_view', $data, TRUE), '1200', '500');
        } elseif($this->post['action_type'] == 'Approve') {
            
            $data['action_type'] = "Approve Battery Life";
            $data['type'] = "Approve";
            $data['Approve'] = 'True';
            $this->output->add_to_popup($this->load->view('frontend/battery/add_battery_life_view', $data, TRUE), '1200', '500');
        }else {
            $data['action_type'] = "Add Battery Life";
           // $data['type'] = "Update";
            $this->output->add_to_popup($this->load->view('frontend/battery/add_battery_life_view', $data, TRUE), '1200', '500');
        }
    }
        function update_approve_battery_life() {
        $app_data = $this->input->post('app');
       // var_dump($app_data['mt_approval']);die();
        $Approved_by = $this->clg->clg_ref_id;
        $approved_date = date('Y-m-d H:i:s');
        $onroaddate = date('Y-m-d H:i:s', strtotime($app_data['mt_app_onroad_datetime']));
        
        if($app_data['mt_approval']=="1"){
            $approval = 'Approved';
        }else if($app_data['mt_approval']=="2"){
            $approval = 'Approval Rejected';
        }else if($app_data['mt_approval']=="3"){
            $approval = 'Under Process';
        }
        
        $app_data = array(
            'bt_id' => $app_data['bt_id'],
            'mt_approval' => $app_data['mt_approval'],
            'mt_app_remark' => $app_data['mt_app_remark'],
            'mt_ambulance_status' => $approval,
            'approved_by' => $Approved_by,
            //'modify_by' => modify_datetime,
            //'modify_datetime' => date('Y-m-d H:i:s'),
            'approved_date' => $approved_date
        );
        

        
        //var_dump($app_data); die;
        $register_result = $this->battery_model->update_battery_life($app_data);

        if ($register_result) {

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Approval Registered Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->battery_listing();
        }
    }
    function update_battery() {
        $app_data = $this->input->post('app');

        $onroaddate = date('Y-m-d H:i:s', strtotime($app_data['mt_app_onroad_datetime']));
        
        
        $app_data = array(
            'bt_id' => $app_data['bt_id'],
            'is_updated' => 1,
            'update_by' => $this->clg->clg_ref_id,
            'update_datetime' => date('Y-m-d H:i:s')
        );
        

        
        //var_dump($app_data); die;
        
        $args = array_merge($this->post['app'], $app_data);
        $register_result = $this->battery_model->update_battery_life($args);
        
         $total_km = $this->input->post('in_odometer') - $this->input->post('previous_odometer');

        $amb_record_data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'start_odmeter' => $this->input->post('previous_odometer'),
            'end_odmeter' => $this->input->post('in_odometer'),
            'total_km' => $total_km,
            'odometer_type'       => 'onroad_offroad maintenance',
            'offroad_reason'       => $maintaince_data['mt_offroad_reason'],
            'inc_ref_id'=>$register_result,
            'timestamp' => date('Y-m-d H:i:s'));

        if (!empty($maintaince_data['mt_remark'])) {
            $amb_record_data['other_remark'] = $maintaince_data['mt_remark'];
        }
        if (!empty($maintaince_data['mt_other_offroad_reason'])) {
            $amb_record_data['other_offroad_reason'] = $maintaince_data['mt_other_offroad_reason'];
        }


        if ($register_result) {
            
             $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);

            $this->output->status = 1;

            $this->output->message = "<div class='success'>updated Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->battery_listing();
        }
    }

     function update_approval_accidental_maintaince() {
        $app_data = $this->input->post('app');
        $Approved_by = $this->clg->clg_ref_id;
        $approved_date = date('Y-m-d H:i:s');
        $onroad = date('Y-m-d H:i:s', strtotime($app_data['mt_app_onroad_datetime']));
        //var_dump($app_data);die;
        if($app_data['mt_approval']=="1"){
            $approval = 'Approved';
            
        }else if($app_data['mt_approval']=="2"){
            $approval = 'Approval Rejected';
        }
        //$approval=1;
        $app_data = array(
            'mt_id' => $app_data['mt_id'],
            'mt_approval' => $app_data['mt_approval'],
            'mt_app_onroad_datetime' => $onroad,
            'mt_offroad_datetime' => $approved_date,
            'mt_app_remark' => $app_data['mt_app_remark'],
            'mt_app_est_amt' => $app_data['mt_app_est_amt'],
            'mt_app_rep_time' => $app_data['mt_app_rep_time'],
            'mt_app_work_shop' => $app_data['mt_app_work_shop'],
            'mt_app_amb_off_status' => $app_data['mt_app_amb_off_status'],
            'mt_ambulance_status' => $approval,
            'mt_app_under_process_remark' => $app_data['mt_app_under_process_remark'],
            'approved_by' => $Approved_by,
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'),
            'approved_date' => $approved_date
        );
       
        $register_result = $this->ambmain_model->update_ambulance_accidental_maintance($app_data);
         //var_dump($register_result);die;
        $history_data = array(
            're_id' => $app_data['re_id'],
            're_mt_id' => $app_data['mt_id'],
            're_approval_status' => $app_data['mt_approval'],
            're_app_onroad_datetime' => date('Y-m-d H:i:s', strtotime($app_data['mt_app_onroad_datetime'])),
            're_remark' => $app_data['mt_app_remark'],
            're_rejected_by' => $this->clg->clg_ref_id,
            're_mt_type' => 'Accidental',
            're_rejected_date' => date('Y-m-d H:i:s')
        );
        $history_data_detail = $this->ambmain_model->insert_accidental_maintaince_history($history_data);
        if($app_data['mt_approval']=="1"){
            
        $data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => '7',
        );
        //$update = $this->amb_model->update_amb($data);
        $total_km = $this->input->post('mt_end_odometer') - $this->input->post('previous_odometer');

       
       /* $amb_update_summary = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => '7,1',
            'end_odometer' => $this->input->post('mt_end_odometer'),
            'on_road_status' => "Ambulance Accidental maintenance on road",
            'on_road_remark' => $maintaince_data['mt_on_stnd_remark'],
           // 'on_road_date' => date('Y-m-d', strtotime($maintaince_data['mt_onroad_datetime'])),
            'on_road_time' => date('H:i:s', strtotime($maintaince_data['mt_onroad_datetime'])),
            'added_date' => date('Y-m-d H:i:s'));
        */
        $amb_update_summary = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => '7',
            //'start_odometer' => $this->input->post('previous_odometer'),
           'off_road_status' => "Ambulance Accidental maintenance off road",
            'off_road_remark' => $app_data['mt_app_remark'],
            'off_road_date' => date('Y-m-d'),
            'off_road_time' => date('H:i:s'),
            'added_date' => date('Y-m-d H:i:s'));
           // var_dump($amb_update_summary);die;
        if (!empty($maintaince_data['mt_on_remark'])) {
            $amb_update_summary['on_road_remark_other'] = $maintaince_data['mt_on_remark'];
        }

        $data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => '7',
        );
        $off_road_status = "Pending for Approval";
        $add_summary = $this->amb_model->update_ambulance_staus_summary($amb_update_summary, $off_road_status);
        //$record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
        //var_dump($add_summary);die;
        if($app_data['mt_app_amb_off_status']=='Yes'){
        //$update = $this->amb_model->update_amb($data);//var_dump($update);die;
        }
    }
        if ($register_result) {

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Accidental Maintenance Registered Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->battery_listing();
        }
    }

}