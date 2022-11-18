<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ambulance_maintaince extends EMS_Controller {

    function __construct() {


        parent::__construct();

        $this->pg_limit = $this->config->item('pagination_limit');

        $this->load->library(array('session', 'modules', 'upload','email'));

        $this->load->model(array('module_model', 'call_model', 'amb_model', 'colleagues_model', 'fleet_model', 'pcr_model', 'ambmain_model','maintenance_part_model'));

        $this->load->helper(array('comman_helper'));
        $this->active_module = "M-AMB-MAINT";

        $this->post = $this->input->get_post(NULL);

        $this->post['base_month'] = get_base_month();

        $this->clg = $this->session->userdata('current_user');
        $this->allow_img_type = $this->config->item('upload_image_types');
        $this->upload_path = $this->config->item('upload_path');
        $this->upload_image_size = $this->config->item('upload_image_size');
        $this->upload_rsm_type = $this->config->item('upload_rsm_types');
         $this->amb_pic = $this->config->item('amb_pic');

        $this->today = date('Y-m-d H:i:s');
        $this->default_state = $this->config->item('default_state');
        if ($this->post['filters'] == 'reset') {

            $this->session->unset_userdata('filters')['PREV'];
        }
        if ($this->session->userdata('filters')['PREV']) {
            $this->fdata = $this->session->userdata('filters')['PREV'];
        }
        
    }

    function preventive_maintaince() {

        ///////////////  Filters //////////////////
       // var_dump($this->fdata['from_date']); die;
        $data['search'] = $search = ($this->post['search']) ? $this->post['search'] : $this->fdata['search'];
        $data['search_status'] =$search_status = ($this->post['search_status']) ? $this->post['search_status'] : $this->fdata['search_status'];
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        if ($this->post['from_date'] != '') {
            $data['from_date'] =$from_date = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->fdata['from_date']));
            $from_date = $data['from_date'];
        }

        if ($this->post['to_date'] != '') {
            $data['to_date'] = $to_date = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->fdata['to_date']));
            $to_date = $data['to_date'];
        }
        if($data['search_status'] == '' || $data['search_status'] == NULL){
           $data['mt_isupdated'] = '0';
           
        }


        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        
        

        ///////////limit & offset////////

        $data['get_count'] = TRUE;
        $data['mt_type'] = 'preventive';
        
        $district_id = "";
        if($this->clg->clg_group ==  'UG-DM' || $this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER' ||  $this->clg->clg_group  == 'UG-FLEETDESK' ||  $this->clg->clg_group  == 'UG-OP-HEAD'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
            $data['amb_district'] = $district_id;
            
        }
        $data['thirdparty'] = $this->clg->thirdparty;
        $data['total_count'] = $this->ambmain_model->get_ambulance_maintance_data($data);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        $ambflt['PREV'] = $data;

        $this->session->set_userdata('filters', $ambflt);

        unset($data['get_count']);



        $data['maintance_data'] = $this->ambmain_model->get_ambulance_maintance_data($data, $offset, $limit);
       // var_dump($data['maintance_data']);
       // die;
        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("ambulance_maintaince/preventive_maintaince"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&search=$search&search_status=$search_status&from_date=$from_date&to_date=$to_date"
            )
        );

        $data['pgconf'] = $pgconf;
        $data['pagination'] = get_pagination($pgconf);

        /////////////////////////////////

        $data['page_records'] = $data['total_count'];


        $this->output->add_to_position($this->load->view('frontend/maintaince/preventive_maintaince_list_view', $data, true), $this->post['output_position'], true);
    }

    function preventive_maintaince_registrartion() {

        $this->session->set_userdata('cons_data','');
        $data['clg_ref_id'] = $this->clg->clg_ref_id;

        if ($this->post['mt_id'] != '') {

            $data['mt_id'] = $ref_id = base64_decode($this->post['mt_id']);
            $data['mt_type'] = 'preventive';
            $data['preventive'] = $this->ambmain_model->get_ambulance_maintance_data($data);
            $non_args = array('inv_type' => $data['preventive'][0]->mt_make,'mt_maintanance_type'=>'1');
          //   var_dump($non_args);
          //  die();
            $data['invitem'] = $this->maintenance_part_model->get_maintenance_part_list($non_args,0,400);
           
          
            $data['media'] = $this->ambmain_model->get_media_maintance($data);
            $arr =array(
            'mt_id'=>       $data['mt_id'],
            'mt_type'=>      'preventive',
            're_request_id'=> $this->post['re_request_id']);
            $his = $this->ambmain_model->get_history($arr);
            
            foreach($his as $history){ 
            $args = array('mt_id' => $this->post['mt_id'], 're_request_id' => $history->re_request_id);
            $history->his_photo[] = $this->ambmain_model->get_history_photo($args);
            $data['his'][] = $history;
            }
        }
        $data['shift_info'] = $this->common_model->get_shift($args);


        if ($this->post['action_type'] == 'Update') {

            $data['action_type'] = "Update Preventive Maintenance";
            $data['type'] = "Update";
            $data['update'] = 'True';

            $this->output->add_to_popup($this->load->view('frontend/maintaince/preventive_maintaince_register_view', $data, TRUE), '1600', '1000');
        } else {
            $state_id = $this->clg->clg_state_id;
            $data['state_id'] = $state_id;
            $data['action_type'] = "Add Preventive Maintenance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/preventive_maintaince_register_view', $data, TRUE), '1600', '1000');
        }
    }

    function approve_preventive_maintaince() {
        if ($this->post['mt_id'] != '') {

            $data['mt_id'] = $ref_id = $this->post['mt_id'];
            $data['mt_type'] = 'preventive';
            $data['preventive'] = $this->ambmain_model->get_ambulance_maintance_data($data);
            $data['media'] = $this->ambmain_model->get_media_maintance($data);
        }
        $args =array(
            'mt_id'=>       $this->post['mt_id'],
            'mt_type'=>      $data['mt_type']
        );
        $re_request_id = $this->ambmain_model->get_photo_history($args);
        $data['media'] = $this->ambmain_model->get_media_maintance($data);
        $arr =array(
            'mt_id'=>       $this->post['mt_id'],
            'mt_type'=>      $data['mt_type'],
            're_request_id'=> $this->post['re_request_id']
        );
        $his = $this->ambmain_model->get_history($arr);
        foreach($his as $history){ //var_dump($history);
        $args = array('mt_id' => $this->post['mt_id'], 're_request_id' => $history->re_request_id);
        $history->his_photo[] = $this->ambmain_model->get_history_photo($args);
        $data['his'][] = $history;
        }
        if ($this->post['action_type'] == 'Update') {

            $data['action_type'] = "Update Preventive Maintenance";
            $data['type'] = "Update";
            $data['update'] = 'True';

            $this->output->add_to_popup($this->load->view('frontend/maintaince/preventive_maintaince_register_view', $data, TRUE), '1600', '1000');
        } elseif ($this->post['action_type'] == 'Approve') {
            $data['type'] = "Approve";
            $data['action_type'] = "Approve Preventive Maintenance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/preventive_maintaince_register_view', $data, TRUE), '1600', '1000');
        }elseif($this->post['action_type'] == 'Rerequest') {
            $data['type'] = "Rerequest";
            $data['action_type'] = "Re-request Preventive Maintenance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/preventive_maintaince_register_view', $data, TRUE), '1600', '1000');
        }else{
            $data['action_type'] = "Add Preventive Maintenance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/preventive_maintaince_register_view', $data, TRUE), '1600', '1000');
        }
       
        }
    
        function update_approve_preventive_maintaince() {
            $app_data = $this->input->post('app');
            
            $Approved_by = $this->clg->clg_ref_id;
            $approved_date = date('Y-m-d H:i:s');
            $onroad = date('Y-m-d H:i:s', strtotime($app_data['mt_app_onroad_datetime']));
                
            if($app_data['mt_approval']=="1")
            {
                $approval = 'Approved';
               
            }else if($app_data['mt_approval']=="2"){
                $approval = 'Approval Rejected';
            }else if($app_data['mt_approval']=="3"){
            $approval = 'Under Process';
            }

            $app_data = $this->input->post('app');
            $app_data = array(
            'mt_id' => $app_data['mt_id'],
            'mt_approval' => $app_data['mt_approval'],
            'mt_offroad_datetime' => $approved_date,
            'mt_app_onroad_datetime' => $onroad,
            'mt_app_remark' => $app_data['mt_app_remark'],
            'mt_app_est_amt'=> $app_data['mt_app_est_amt'],
            'mt_app_rep_time'=> $app_data['mt_app_rep_time'],
            'mt_app_work_shop' => $app_data['mt_app_work_shop'],
            'mt_app_amb_off_status' => $app_data['mt_app_amb_off_status'],
            'mt_ambulance_status' => $approval,
            'mt_app_under_process_remark' => $app_data['mt_app_under_process_remark'],
            'approved_by' => $Approved_by,
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'),
            'approved_date' => $approved_date
        );
    
            $register_result = $this->ambmain_model->update_ambulance_maintance($app_data);
            //die();

            $history_data = array(
                're_id' => $app_data['re_id'],
                're_mt_id' => $app_data['mt_id'],
                're_approval_status' => $app_data['mt_approval'],
                'mt_app_est_amt' => $app_data['mt_app_est_amt'],
                'mt_app_rep_time' => $app_data['mt_app_rep_time'],
                're_app_onroad_datetime' => date('Y-m-d H:i:s', strtotime($app_data['mt_app_onroad_datetime'])),
                're_remark' => $app_data['mt_app_remark'],
                're_mt_type' => 'preventive',
                're_rejected_by' => $this->clg->clg_ref_id,
                're_rejected_date' => date('Y-m-d H:i:s')
            );
            $history_data_detail = $this->ambmain_model->insert_accidental_maintaince_history($history_data);
           
            $data = array(
                'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
                'amb_status' => '7',
            );
            //$update = $this->amb_model->update_amb($data);
    
            $register_result = $this->ambmain_model->update_ambulance_accidental_maintance($app_data);
        if($app_data['mt_approval']=="1"){
            $total_km = $this->input->post('mt_end_odometer') - $this->input->post('previous_odometer');

            $amb_record_data = array(
                'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
                'start_odmeter' => $this->input->post('previous_odometer'),
                'end_odmeter' => $this->input->post('mt_end_odometer'),
                'total_km' => $total_km,
                'timestamp' => date('Y-m-d H:i:s'));
    
            if (!empty($maintaince_data['mt_off_remark'])) {
                $amb_record_data['other_remark'] = $maintaince_data['mt_off_remark'];
            }
    
            $amb_update_summary = array(
                'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
                'amb_status' => '7',
                'end_odometer' => $this->input->post('mt_end_odometer'),
                'off_road_status' => "Ambulance preventive maintenance off road",
                'off_road_remark' => $maintaince_data['mt_on_stnd_remark'],
                'on_road_date' => date('Y-m-d', strtotime($maintaince_data['mt_onroad_datetime'])),
                'on_road_time' => date('H:i:s', strtotime($maintaince_data['mt_onroad_datetime'])),
                'added_date' => date('Y-m-d H:i:s'));
    
            if (!empty($maintaince_data['mt_on_remark'])) {
                $amb_update_summary['on_road_remark_other'] = $maintaince_data['mt_on_remark'];
            }
    
            $data = array(
                'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
                'amb_status' => 1,
            );
            $off_road_status = "Pending for Approval";
            $add_summary = $this->amb_model->update_ambulance_staus_summary($amb_update_summary, $off_road_status);
           // $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
           if($app_data['mt_app_amb_off_status']=='Yes'){
            //$update = $this->amb_model->update_amb($data);//var_dump($update);die;
            }
           // $update = $this->amb_model->update_amb($data);
        }
                     if(!empty($_FILES['amb_photo']['name'])){
            foreach ($_FILES['amb_photo']['name'] as $key => $image) {
                $media_args = array();


                $_FILES['photo']['name']= $_FILES['amb_photo']['name'][$key];
                $_FILES['photo']['type']= $_FILES['amb_photo']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['amb_photo']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['amb_photo']['error'][$key];
                $_FILES['photo']['size']= $_FILES['amb_photo']['size'][$key];

                $_FILES['photo']['name'] = time().'_'.$this->sanitize_file_name($_FILES['photo']['name']);
                
                
               // var_dump($_FILES['amb_photo']['name']);
                //die();

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                    $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                    $upload_err = TRUE;
                }
                $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['user_id'] = $app_data['mt_id'];
                $media_args['media_data'] = 'preventive';
                $this->ambmain_model->insert_media_maintance($media_args);
                // var_dump($media_args);die;
            }
        }
        
            if ($register_result) {
    
    
    
                $this->output->status = 1;
    
                $this->output->message = "<div class='success'>Preventive Maintenance Approved Successfully!</div>";
    
                $this->output->closepopup = 'yes';
    
                $this->preventive_maintaince();
            }
        }
        function final_update_approve_breakdown_maintaince(){
            
        $app_data = $this->input->post('app');
        $Approved_by = $this->clg->clg_ref_id;
        $approved_date = date('Y-m-d H:i:s');
        $onroaddate = date('Y-m-d H:i:s', strtotime($app_data['mt_app_onroad_datetime']));
        $data = array();
        $data['mt_id'] = $ref_id = $maintaince_data['mt_id'];
        $preventive = $this->ambmain_model->get_ambulance_break_maintance_data($data)[0];
        
  
        
          
        if($app_data['mt_approval']=="1"){
            $approval = 'Final Invoice Approved';
        }else if($app_data['mt_approval']=="2"){
            $approval = 'Final Invoice Rejected';
        }else if($app_data['mt_approval']=="3"){
                $approval = 'Final Invoice Rejected';
        }
       
      
        
            $app_data = array(
            'mt_id' => $app_data['mt_id'],
            'mt_isupdated' => '7',
            'mt_ambulance_status'=>$approval,
            'mt_app_fn_approval' => $app_data['mt_approval'],
            'mt_app_fn_remark' => $app_data['mt_app_remark'],
            'final_total_cost' => $this->input->post('final_total_cost'),
            'mt_final_remark' => $this->input->post('mt_final_remark'),
            'final_labour_cost' => $this->input->post('final_labour_cost'),
            'final_part_cost' => $this->input->post('final_part_cost'),
            'final_bill_number' => $this->input->post('final_bill_number'),
            'final_approved_by' => $Approved_by,
            'final_approved_date' => $approved_date
        );
        //if($this->input->post('Breakdown_Severity') == 'Minor'){
            //$app_data['mt_isupdated'] = '1';
        //}
 
            
            $vender_data = get_clg_data_by_ref_id($preventive->vendor_id)[0];
            $vendor_name = $vender_data->clg_first_name.' '.$vender_data->clg_last_name;



            $vd_sms_to = $vender_data->clg_mobile_no;
            $mtype = $preventive->mt_breakdown_id ;
            $mdate = $preventive->added_date;
            $mt_total_cost = $preventive->total_cost;
            

            $vdMsg = "";;
            
            $vdMsg .= "BVG,\n"
                    ."$vendor_name,"
                    ."Your invoice no $mtype dated $mdate"
                    ." Of amount Rs.$mt_total_cost has been approved by $Approved_by."
                    ."Please courier hard copy of invoice & \n"
                    ."Job card to following address.\n"
                    ."Invoice Desk\n"
                    ."BVG INDIA LTD (108)\n"
                    ."2nd Floor Old Building,\n"
                    ."Aundh Chest Hospital,\n" 
                    ."Sangvi Phata\n"
                    ."Aundh Pune. 411027,\n"
                    ."Mo No +91 72492 91255\n"
                    ."MHEMS";
            
            $super_args = array(
                'msg' => $vdMsg,
                'mob_no' => $vd_sms_to,
                'sms_user' => 'breakdown',
            );

            $sms_data = sms_send($super_args);


            $register_result = $this->ambmain_model->update_ambulance_break_maintance($app_data);
           
            $history_data = array(
                're_id' => $app_data['re_id'],
                're_mt_id' => $app_data['mt_id'],
                're_approval_status' => $approval,
                're_app_onroad_datetime' => date('Y-m-d H:i:s', strtotime($app_data['mt_app_onroad_datetime'])),
                're_remark' => $app_data['mt_app_remark'],
                're_mt_type' => 'breakdown',
                're_rejected_by' => $this->clg->clg_ref_id,
                're_rejected_date' => date('Y-m-d H:i:s')
            );
            $history_data_detail = $this->ambmain_model->insert_accidental_maintaince_history($history_data);

       
            if ($register_result) {
    

                $this->output->status = 1;
    
                $this->output->message = "<div class='success'>Breakdown Maintenance Final Approved Successfully!</div>";
    
                $this->output->closepopup = 'yes';
    
                $this->breakdown_maintaince();
            }
        }
        function update_approve_breakdown_maintaince() {

        $app_data = $this->input->post('app');
        $Approved_by = $this->clg->clg_ref_id;
        $approved_date = date('Y-m-d H:i:s');
        $onroaddate = date('Y-m-d H:i:s', strtotime($app_data['mt_app_onroad_datetime']));
       
        if($this->input->post('vendor_id') != ''){
        $vender_data = get_clg_data_by_ref_id($this->input->post('vendor_id'))[0];
        $vd_sms_to = $vender_data->clg_mobile_no;
        }
       
        $preventive = $this->ambmain_model->get_ambulance_break_maintance_data($app_data)[0];
    
         
         
        $main_type = $this->input->post('mt_breakdown_id');
        $link = 'https://www.mhems.in';
        $vahicle = $this->input->post('maintaince_ambulance');
            
         if($app_data['mt_approval']=="1"){
            $status = '2';
            $approval = 'Pending for invoice upload by vendor';
            
            $vdMsg = "";
   
            $vdMsg .= "BVG,\n"
."Maintenance request approved for $main_type.\n"
."Final Estimate Approval By :$Approved_by\n"
."Vehicle No :$vahicle,\n"
."After work completion kindly upload invoice/bills along with images on $link,\n"
."MHEMS";
            $msg = "Breakdown Maintenance Approved Successfully!";
   
        }else if($app_data['mt_approval']=="2"){
              $status = '3';
            $approval = 'Request Rejected Re-request';
            
            $vdMsg = ""; 
            $vdMsg .= "BVG,\n"
."Maintenance request Reject for $main_type.\n"
."Rejected By :$Approved_by\n"
."Vehicle No :$vahicle,\n"
."Please check on $link,\n"
."MHEMS";
            
$msg = "Breakdown Maintenance Rejected Re-request!";
            
        }else if($app_data['mt_approval']=="3"){
              $status = '3';
                $approval = 'Request Rejected Re-request';
                
            $vdMsg = "";
            $vdMsg .= "BVG,\n"
."Maintenance request Reject for $main_type.\n"
."Rejected By :$Approved_by\n"
."Vehicle No :$vahicle,\n"
."Please check on $link,\n"
."MHEMS";
            
            $msg = "Breakdown Maintenance under-process";
            
        }
        if($preventive->mt_payment_type == 'hppay_card'){
              $status = '5';
              $approval = 'Approved';
              
              if($app_data['mt_approval']=="1"){
                   $approval = 'Approved';
                  
              }else if($app_data['mt_approval']=="2"){
                   $approval = 'Rejected';
                  
              }else if($app_data['mt_approval']=="3"){
                    $approval = 'Under Process';
              }
              
        }
        if($preventive->mt_payment_type == 'vendor'){
        
            $super_args = array(
                'msg' => $vdMsg,
                'mob_no' => $vd_sms_to,
                'sms_user' => 'breakdown',
            );

            if($this->clg->clg_group == 'UG-FLEETDESK'){
                $sms_data = sms_send($super_args);
            }
        }
            $app_data = array(
            'mt_id' => $app_data['mt_id'],
            'mt_isupdated' => $status,
            'mt_approval' => $app_data['mt_approval'],
            'mt_app_onroad_datetime' => $onroaddate,
            'mt_offroad_datetime' => $approved_date,
            'mt_app_remark' => $app_data['mt_app_remark'],
            'mt_app_est_amt'=> $app_data['mt_app_est_amt'],
            'mt_ambulance_status' => $approval,
            'mt_app_rep_time'=> $app_data['mt_app_rep_time'],
            'mt_app_work_shop' => $app_data['mt_app_work_shop'],
            'mt_app_amb_off_status' => $app_data['mt_app_amb_off_status'],
            'mt_app_under_process_remark' => $app_data['mt_app_under_process_remark'],
            'mt_nature_of_breakdown' => $app_data['nature_of_breakdown'],
            'approved_by' => $Approved_by,
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'),
            'approved_date' => $approved_date
        );
        //if($this->input->post('Breakdown_Severity') == 'Minor'){
            //$app_data['mt_isupdated'] = '1';
        //}
       //var_dump($app_data);die(); 
            $register_result = $this->ambmain_model->update_ambulance_break_maintance($app_data);
            //var_dump($register_result);die;
            $history_data = array(
                're_id' => $app_data['re_id'],
                're_mt_id' => $app_data['mt_id'],
                're_approval_status' => $app_data['mt_approval'],
                're_app_onroad_datetime' => date('Y-m-d H:i:s', strtotime($app_data['mt_app_onroad_datetime'])),
                're_remark' => $app_data['mt_app_remark'],
                're_mt_type' => 'breakdown',
                're_rejected_by' => $this->clg->clg_ref_id,
                're_rejected_date' => date('Y-m-d H:i:s')
            );
            $history_data_detail = $this->ambmain_model->insert_accidental_maintaince_history($history_data);
            if($app_data['mt_approval']=="1"){
                
//                if($this->input->post('Breakdown_Severity') != 'Minor'){
//                    $data = array(
//                        'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
//                        'amb_status' => '7',
//                    );
//                    $update = $this->amb_model->update_amb($data);
//                }
    
          //  $register_result = $this->ambmain_model->update_ambulance_accidental_maintance($app_data);
    
    
            $total_km = (int)$this->input->post('mt_end_odometer') - (int)$this->input->post('previous_odometer');
    
            $amb_record_data = array(
                'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
                'start_odmeter' => $this->input->post('previous_odometer'),
                'end_odmeter' => $this->input->post('mt_end_odometer'),
                'total_km' => $total_km,
                'timestamp' => date('Y-m-d H:i:s'));
    
            if (!empty($maintaince_data['mt_off_remark'])) {
                $amb_record_data['other_remark'] = $maintaince_data['mt_off_remark'];
            }
    
            $amb_update_summary = array(
                'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
                'amb_status' => '7',
                'end_odometer' => $this->input->post('mt_end_odometer'),
                'off_road_status' => "Ambulance Breakdown maintenance off road",
                'off_road_remark' => $maintaince_data['mt_stnd_remark'],
                'off_road_date' => date('Y-m-d', strtotime($maintaince_data['mt_onroad_datetime'])),
                'off_road_time' => date('H:i:s', strtotime($maintaince_data['mt_onroad_datetime'])),
                'added_date' => date('Y-m-d H:i:s'));
    
            if (!empty($maintaince_data['mt_on_remark'])) {
                $amb_update_summary['on_road_remark_other'] = $maintaince_data['mt_on_remark'];
            }
    
            $data = array(
                'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
                'amb_status' => '7',
            );
           // $off_road_status = "Pending for Approval";
           // $add_summary = $this->amb_model->update_ambulance_staus_summary($amb_update_summary, $off_road_status);
            //$record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
    
                if($app_data['mt_app_amb_off_status']=='Yes'){
                   // $update = $this->amb_model->update_amb($data);//var_dump($update);die;
                }
            //$update = $this->amb_model->update_amb($data);
        }
            if(!empty($_FILES['amb_photo']['name'])){
            foreach ($_FILES['amb_photo']['name'] as $key => $image) {
                $media_args = array();


                $_FILES['photo']['name']= $_FILES['amb_photo']['name'][$key];
                $_FILES['photo']['type']= $_FILES['amb_photo']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['amb_photo']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['amb_photo']['error'][$key];
                $_FILES['photo']['size']= $_FILES['amb_photo']['size'][$key];

                $_FILES['photo']['name'] = time().'_'.$this->sanitize_file_name($_FILES['photo']['name']);
               // var_dump($_FILES['amb_photo']['name']);
                //die();

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                    $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                    $upload_err = TRUE;
                }
                $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['user_id'] = $app_data['mt_id'];
                $media_args['media_data'] = 'breakdown';
                $this->ambmain_model->insert_media_maintance($media_args);
                // var_dump($media_args);die;
            }
        }
      //  echo "ho";
      //  die();
            if ($register_result) {
    
    
    
                $this->output->status = 1;
    
                $this->output->message = "<div class='success'>".$msg."</div>";
    
                $this->output->closepopup = 'yes';
    
                $this->breakdown_maintaince();
            }
        }

    function preventive_maintaince_save() {

        $maintaince_data = $this->post['maintaince'];
        $maintaince_data['mt_stnd_remark'] = "Preventive Maintenance";

        $maintaince = $this->input->post();
        
        
        
        $state = $this->input->post('maintaince_state');
        
        if($state == 'RJ'){
             $prev= generate_maintaince_id('ems_rj_preventive_id');
            $prev_id = "RJEMS-PM-".$prev;
        }else if($state == 'MP'){
            $prev= generate_maintaince_id('ems_pm_preventive_id');
            $prev_id = "MPEMS-PM-".$prev;
        }else{
            $prev= generate_maintaince_id('ems_preventive_id');
            $prev_id = "MHEMS-PM-".$prev;
        }
        if($this->input->post('maintaince_district') == 'Backup'){
            $amb_data = $this->amb_model->get_amb_district(array('amb_id' =>$this->input->post('maintaince_ambulance')));
            $district_id = $amb_data[0]->amb_district ;
        }
        else{
            $district_id =  $this->input->post('maintaince_district');
        }
        //var_dump($district_id);die();
        $main_data = array(
            'mt_preventive_id'=>$prev_id,
            'mt_state_id' => $this->input->post('maintaince_state'),
            'mt_district_id' => $district_id,
            'mt_amb_no' => $this->input->post('maintaince_ambulance'),
            'mt_in_odometer' => $this->input->post('in_odometer'),
            'mt_previos_odometer' => $this->input->post('previous_odometer'),
            'mt_Estimatecost' => $this->input->post('Estimatecost'),
            'mt_base_loc' => $this->input->post('base_location'),
             'amb_type' => $this->input->post('amb_type'),
            'mt_make' => $this->input->post('ambt_make'),
            'mt_module' => $this->input->post('ambt_model'),
            'mt_odometer_diff' => $this->input->post('odometer_diff'),
           // 'mt_offroad_datetime' => date('Y-m-d H:i:s', strtotime($maintaince_data['mt_offroad_datetime'])),
           // 'mt_ex_onroad_datetime' => $this->input->post('ex_onroad_datetime'),
            'informed_to' => json_encode($this->input->post('user_group')),
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'),
            'mt_isdeleted' => '0',
            'mt_type' => 'preventive',
            'mt_base_month' => $this->post['base_month'],
            'mt_ambulance_status' => 'Pending Approval',
            'mt_pilot_name' => $this->input->post('pilot_id'),
        );
        
        $args = array_merge($this->post['maintaince'], $main_data);
        
        if(!empty($_FILES['amb_photo']['name'])){
            foreach ($_FILES['amb_photo']['name'] as $key => $image) {
                
               
                $media_args = array();


                $_FILES['photo']['name']= $_FILES['amb_photo']['name'][$key];
                $_FILES['photo']['type']= $_FILES['amb_photo']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['amb_photo']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['amb_photo']['error'][$key];
                $_FILES['photo']['size']= $_FILES['amb_photo']['size'][$key];


                $_FILES['photo']['name'] = time() .'_'. $this->sanitize_file_name($_FILES['photo']['name']);
               // var_dump($_FILES['amb_photo']['name']);
                //die();

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                             $msg_p =  $this->upload->display_errors();
                              $this->output->message = "<div class='error'>$msg_p .. Please upload again..!</div>";
                            $upload_err = TRUE;
                            return;
                }
                if (!$upload_err) {
                    $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";  
                }

                $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['user_id'] = $register_result;
                $media_args['media_data'] = 'preventive';
                //$this->ambmain_model->insert_media_maintance($media_args);
                 $media_records[$key] = $media_args;
            }
        }

        $register_result = $this->ambmain_model->insert_ambulance_maintance($args);
        
        if($media_records){
        foreach($media_records as $media_record){
            $media_record['user_id'] = $register_result;
            $media = $this->ambmain_model->insert_media_maintance($media_record);
               
        }
        }
        
         if($state == 'RJ'){
             $prev= generate_maintaince_id('ems_rj_onoffroad_id');
            $prev_id = "RJEMS-OM-".$prev;
        }else if($state == 'MP'){
            $prev= generate_maintaince_id('ems_pm_onoffroadl_id');
            $prev_id = "MPEMS-OM-".$prev;
        }else{
            $prev= generate_maintaince_id('ems_onoffroad_id');
            $prev_id = "MHEMS-OM-".$prev;
        }
        if($this->input->post('maintaince_district') == 'Backup'){
            $amb_data = $this->amb_model->get_amb_district(array('amb_id' =>$this->input->post('maintaince_ambulance')));
            $district_id = $amb_data[0]->amb_district ;
        }
        else{
            $district_id =  $this->input->post('maintaince_district');
        }
        
        $main_off_data = array('mt_state_id' => $this->input->post('maintaince_state'),
            'mt_onoffroad_id'=>$prev_id,
            'mt_district_id' => $district_id,
            'mt_amb_no' => $this->input->post('maintaince_ambulance'),
            'mt_in_odometer' => $this->input->post('in_odometer'),
            'mt_previos_odometer' => $this->input->post('previous_odometer'),
            'mt_odometer_diff' => $this->input->post('odometer_diff'),
            'mt_base_loc' => $this->input->post('base_location'),
            'mt_Estimatecost' => $this->input->post('Estimatecost'),
           // 'mt_offroad_datetime' => date('Y-m-d H:i:s', strtotime($maintaince_data['mt_offroad_datetime'])),
            // 'mt_ex_onroad_datetime' =>$this->input->post('ex_onroad_datetime'),
             'amb_type' => $this->input->post('amb_type'),
            'mt_make' => $this->input->post('ambt_make'),
            'mt_module' => $this->input->post('ambt_model'),
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'),
            'mt_isdeleted' => '0',
            'mt_type' => 'onroad_offroad',
            'mt_offroad_reason' => 'Preventive Maintenance',
            'mt_informed_group' => json_encode($this->input->post('user_group')),
            'mt_remark' => $maintaince_data['mt_remark'],
            'mt_base_month' => $this->post['base_month'],
            'mt_ambulance_status' => 'Pending Approval',
            'mt_pilot_id' =>  $maintaince_data['mt_pilot_id'],
            'amb_owner' =>  $maintaince_data['amb_owner'],
            'mt_pilot_name' => $this->input->post('pilot_id'),
            
        );

         
       

       // $main_off_data = array_merge($this->post['accidental'],$main_off_data);
       // $main_off_data['amb_owner'] = $main_off_data['mt_owner'];
      //  unset($main_off_data['mt_owner']);
        
       if($register_result){
            $off_register_result = $this->ambmain_model->insert_ambulance_on_off_maintance($main_off_data);
       }
        
        $inform_user_group = $this->input->post('user_group'); 
        //$district_id = $this->input->post('maintaince_district');
        if(!empty($inform_user_group)){
            foreach($inform_user_group as $user_group){
                if($user_group != ''){

                $args_clg = array('clg_group'=>$user_group,'clg_district_id'=>$district_id);
                $register_result_clg = $this->colleagues_model->get_clg_data($args_clg);
              //  var_dump($register_result_clg);
                if($register_result_clg){
                    //var_dump($maintaince_data['mt_work_shop']);
                      if($maintaince_data['mt_work_shop'] != ''){
                            $work_shop = show_work_shop_by_id($maintaince_data['mt_work_shop']);
                         }
                       
                    foreach($register_result_clg as $register){

                        $sms_to = $register->clg_mobile_no;                          
                        $district = get_district_by_id($this->input->post('maintaince_district'));
                        $txtMsg2 = "";
                        $txtMsg2.= "BVG\n";
                        $txtMsg2.= "Ambulance No: ".$this->input->post('maintaince_ambulance').",\n"; 
                        $txtMsg2.= "District: ".$district." \n";
                        $txtMsg2.= "Base Location: ".$this->input->post('base_location')."\n"; 
                        $txtMsg2.= "Date & Time of Schedule Servicing: ".$maintaince_data['mt_offroad_datetime']."\n";
                        $txtMsg2.= "Workshop location: ".$work_shop."\n";
                        $txtMsg2 .= "Expected Date & Time of Completion Schedule Servicing Work:".$maintaince_data['mt_ex_onroad_datetime']."\n";
                        
                        $txtMsg2.= "MHEMS";
                       
                        
                        $body ="<H2>Reason	Vehicle is due for Schedule Service (Preventive Maintenance)<H2><br><table><tr><td>Ambulance Registration No:</td><td>".$this->input->post('maintaince_ambulance')."</td></tr>
<tr><td>Base Location:</td><td>".$this->input->post('base_location')."</td></tr>
<tr><td>Odo Meter Reading:</td><td>".$this->input->post('odometer_diff')."</td></tr>
<tr><td>Escalated To:</td><td>".$inform_user_group."</td></tr>
<tr><td>District:</td><td>".$district."</td></tr>
<tr><td>Status:</td><td>Open</td></tr>
<tr><td>Schedule Service Type:</td><td>Preventive Maintenance</td></tr>
<tr><td>Work Location:</td><td>".$work_shop."</td></tr>
<tr><td>Date of Schedule Servicing Work</td><td>".$maintaince_data['mt_offroad_datetime']."</td></tr>
<tr><td>Expected Date & Time of Completion Schedule Servicing Work</td><td>".$maintaince_data['mt_ex_onroad_datetime']."</td></tr></table><br>Thanks & Regards<br>ADM, BVG - MEMS";
     
                        $super_args = array(
                            'msg' => $txtMsg2,
                            'mob_no' => $sms_to,
                            'sms_user' => 'Preventive',
                        );

                        //$sms_data = sms_send($super_args);


  
                        $from = 'fleetdeskmems@bvgmems.com';

                        $email = $register->clg_email;
                       // $email = "chaitali.fartade@mulikainfotech.com";
                        $subject = "Ambulance On Preventive Maintenance";
                        $mail_res = $this->_send_email($email, $from,$subject, $txtMsg2);
                    }
                }
            }
            }
        }
        if($this->input->post('pilot_id') != ''){
            $pilot_clg = array('clg_ref_id'=>$this->input->post('pilot_id'));
            $pilot_clg_result = $this->colleagues_model->get_clg_data($pilot_clg);
            if($maintaince_data['mt_work_shop'] != ''){
                $work_shop = show_work_shop_by_id($maintaince_data['mt_work_shop']);
            }
            foreach($pilot_clg_result as $pilot){

                        $pilot_sms_to = $pilot->clg_mobile_no;
                        $district = get_district_by_id($this->input->post('maintaince_district'));
                        $txtMsg2 = "";
                        $txtMsg2.= "BVG\n";
                        $txtMsg2.= "Ambulance No: ".$this->input->post('maintaince_ambulance')."\n"; 
                        $txtMsg2.= "District: ".$district."\n";
                        $txtMsg2.= "Base Location: ".$this->input->post('base_location')."\n"; 
                        $txtMsg2.= "Date & Time of Schedule Servicing: ".$maintaince_data['mt_offroad_datetime']."\n";
                        $txtMsg2.= "Workshop location: ".$work_shop."\n";
                        $txtMsg2 .= "Expected Date & Time of Completion Schedule Servicing Work:".$maintaince_data['mt_ex_onroad_datetime'].",\n";
                        
                        $txtMsg2.= "MHEMS";
                         

                $pilot_args = array(
                    'msg' => $txtMsg2,
                    'mob_no' => $pilot_sms_to,
                    'sms_user' => 'Preventive pilot'
                );

                //$pilot_sms_data = sms_send($pilot_args);
                
                $from = 'fleetdeskmems@bvgmems.com';

                $email = $pilot->clg_email;
                $subject = "Ambulance On Maintenance";
                $mail_res = $this->_send_email($email, $from,$subject, $txtMsg2);
            }
        }
   
        
        
          
        $total_km = $this->input->post('in_odometer') - $this->input->post('previous_odometer');

        $amb_record_data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'start_odmeter' => $this->input->post('previous_odometer'),
            'end_odmeter' => $this->input->post('in_odometer'),
            'odometer_type'       => 'preventive maintenance',
            'total_km' => $total_km,
            'inc_ref_id'=>$register_result,
            'timestamp' => date('Y-m-d H:i:s'));

        if (!empty($maintaince_data['mt_remark'])) {
            $amb_record_data['other_remark'] = $maintaince_data['mt_remark'];
        }

        $amb_update_summary = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => 1,
            'start_odometer' => $this->input->post('previous_odometer'),
            'off_road_status' => "Pending for Approval",      
            'off_road_remark' => $maintaince_data['mt_stnd_remark'],
            'off_road_date' => date('Y-m-d', strtotime($maintaince_data['mt_offroad_datetime'])),
            'off_road_time' => date('H:i:s', strtotime($maintaince_data['mt_offroad_datetime'])),
            'added_date' => date('Y-m-d H:i:s'));

        if (!empty($maintaince_data['mt_remark'])) {
            $amb_update_summary['off_road_remark_other'] = $maintaince_data['mt_remark'];
        }

        $data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => 1,
        );
        
     
        if ($register_result) {

            $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
            $add_summary = $this->amb_model->insert_amb_staus_summary($amb_update_summary);
           // $update = $this->amb_model->update_amb($data);

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Preventive Maintenance Registered Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->preventive_maintaince();
        }
    }

    function update_preventive_maintaince() {

        $maintaince_data = $this->post['maintaince'];
        $maintaince_part = $this->post['unit'];

        $main_data = array('mt_end_odometer' => $this->input->post('mt_end_odometer'),
            'mt_onroad_datetime' => date('Y-m-d H:i:s', strtotime($maintaince_data['mt_onroad_datetime'])),
            'mt_isupdated' => '1',
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'),
            'mt_ambulance_status' => 'Available',
            'bill_number' => $this->input->post('mt_bill_number'),
            'part_cost' => $this->input->post('mt_part_cost'),
            'labour_cost' => $this->input->post('mt_labour_cost'),
            'total_cost' => $this->input->post('mt_total_cost'));

        $args = array_merge($this->post['maintaince'], $main_data);

        $register_result = $this->ambmain_model->update_ambulance_maintance($args);
        
        if(!empty($_FILES['amb_job_card']['name'])){
            foreach ($_FILES['amb_job_card']['name'] as $key => $image) {
                $media_args = array();


                $_FILES['photo']['name']= $_FILES['amb_job_card']['name'][$key];
                $_FILES['photo']['type']= $_FILES['amb_job_card']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['amb_job_card']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['amb_job_card']['error'][$key];
                $_FILES['photo']['size']= $_FILES['amb_job_card']['size'][$key];

                $_FILES['photo']['name'] = time() .'_'. $this->sanitize_file_name($_FILES['photo']['name']);
               // var_dump($_FILES['amb_photo']['name']);
                //die();

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                    $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                    $upload_err = TRUE;
                }
                $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['user_id'] = $maintaince_data['mt_id'];
                $media_args['media_data'] = 'job_card_preventive';
                $this->ambmain_model->insert_media_maintance($media_args);
                // var_dump($media_args);die;
            }
        }
        
        if(!empty($_FILES['amb_invoice']['name'])){
            foreach ($_FILES['amb_invoice']['name'] as $key => $image) {
                $media_args = array();


                $_FILES['amb_invoice']['name']= $_FILES['amb_invoice']['name'][$key];
                $_FILES['amb_invoice']['type']= $_FILES['amb_invoice']['type'][$key];
                $_FILES['amb_invoice']['tmp_name']= $_FILES['amb_invoice']['tmp_name'][$key];
                $_FILES['amb_invoice']['error']= $_FILES['amb_invoice']['error'][$key];
                $_FILES['amb_invoice']['size']= $_FILES['amb_invoice']['size'][$key];

                $_FILES['amb_invoice']['name'] = time().'_'.$this->sanitize_file_name($_FILES['amb_invoice']['name']);
               // var_dump($_FILES['amb_photo']['name']);
                //die();

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                    $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                    $upload_err = TRUE;
                }
                $media_args['media_name'] = $_FILES['amb_invoice']['name'];
                $media_args['user_id'] = $maintaince_data['mt_id'];
                $media_args['media_data'] = 'invoice_preventive';
                $this->ambmain_model->insert_media_maintance($media_args);
                // var_dump($media_args);die;
            }
        }
   
     
        
         if (isset($maintaince_part)) {
            foreach ($maintaince_part as $unit) {

                if ($unit['value'] != '' ) {

                    $unit_args = array(
                        'as_item_id' => $unit['id'],
                        'as_item_type' => $unit['type'],
                        'as_stk_in_out' => 'out',
                        'as_item_qty' => $unit['value'],
                        'as_sub_id' => $maintaince_data['mt_id'],
                        'as_sub_type' => 'pre_maintaince_part',
                        'as_district_id' => $maintaince_data['mt_district_id'],
                        'as_amb_reg_no' => $this->input->post('maintaince_ambulance'),
                        'as_date' => $this->today,
                        'as_base_month' => $this->post['base_month'],
                    );


                    $this->maintenance_part_model->insert_maintenance_part_stock($unit_args);
                }
            }
        }
        


        $total_km = $this->input->post('mt_end_odometer') - $this->input->post('previous_odometer');

        $amb_record_data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'start_odmeter' => $this->input->post('previous_odometer'),
            'end_odmeter' => $this->input->post('mt_end_odometer'),
            'odometer_type'       => 'update preventive maintenance',
            'total_km' => $total_km,
            'inc_ref_id'=>$maintaince_data['mt_id'],
            'timestamp' => date('Y-m-d H:i:s'));

        if (!empty($maintaince_data['mt_off_remark'])) {
            $amb_record_data['other_remark'] = $maintaince_data['mt_off_remark'];
        }

        $amb_update_summary = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => '7,1',
            'end_odometer' => $this->input->post('mt_end_odometer'),
            'on_road_status' => "Ambulance Preventive maintenance on road",
            'on_road_remark' => $maintaince_data['mt_on_stnd_remark'],
             'inc_ref_id'=>$maintaince_data['mt_id'],
            'on_road_date' => date('Y-m-d', strtotime($maintaince_data['mt_onroad_datetime'])),
            'on_road_time' => date('H:i:s', strtotime($maintaince_data['mt_onroad_datetime'])),
            'added_date' => date('Y-m-d H:i:s'));

        if (!empty($maintaince_data['mt_on_remark'])) {
            $amb_update_summary['on_road_remark_other'] = $maintaince_data['mt_on_remark'];
        }

        $data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => 1,
        );
        $off_road_status = "Ambulance preventive maintenance off road";
        $add_summary = $this->amb_model->update_ambulance_staus_summary($amb_update_summary, $off_road_status);
        $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);

       // $update = $this->amb_model->update_amb($data);

        if ($register_result) {



            $this->output->status = 1;

            $this->output->message = "<div class='success'>Preventive Maintenance Updated Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->preventive_maintaince();
        }
    }

    function preventive_maintaince_view() {


        $data = array();


        $data['action_type'] = 'View Preventive Maintenance';

        $data['mt_id'] = $ref_id = $this->post['mt_id'];
        $data['preventive'] = $this->ambmain_model->get_ambulance_maintance_data($data);
        $data['mt_type'] ='preventive';
        $data['media'] = $this->ambmain_model->get_media_maintance($data);
        
          $inv_args = array('as_sub_id'=>$data['mt_id'],'as_sub_type'=>'pre_maintaince_part','as_stk_in_out'=>'out');
            $data['used_invitem'] = $this->maintenance_part_model->get_breakdown_maintaince_part($inv_args);

        //Request page - Approve / Reject history
        $args =array(
            'mt_id'=> $data['mt_id'],
            'mt_type'=>  $data['mt_type']
        );
        $data['app_rej_his'] = $this->ambmain_model->get_app_rej_his($args);
       // var_dump($data['app_rej_his']);die();
        //approve page - Re-request history
        $args =array(
            'mt_id'=>       $this->post['mt_id'],
            'mt_type'=>      $data['mt_type']
        );
        $re_request_id = $this->ambmain_model->get_photo_history($args);
        
        $data['media'] = $this->ambmain_model->get_media_maintance($data);
        $job_data = array('mt_id'=>$ref_id,'mt_type'=>'job_card_preventive');
        $data['job_media'] = $this->ambmain_model->get_media_maintance($job_data);
        
        
        $other_data = array('mt_id'=>$ref_id,'mt_type'=>'invoice_preventive');
        $data['invoice_media'] = $this->ambmain_model->get_media_maintance($other_data);
        $arr =array(
            'mt_id'=>       $this->post['mt_id'],
            'mt_type'=>      $data['mt_type'],
            're_request_id'=> $this->post['re_request_id']
        );
        $his = $this->ambmain_model->get_history($arr);
        foreach($his as $history){ //var_dump($history);
            $args_his = array('mt_id' => $this->post['mt_id'], 're_request_id' => $history->re_request_id);
            $history_images = $this->ambmain_model->get_history_photo($args_his);
            $history->his_photo = $history_images;
            $data['his'][] = $history;
        }

        $this->output->add_to_popup($this->load->view('frontend/maintaince/preventive_maintaince_view', $data, TRUE), '1600', '1000');
         //$this->output->add_to_position($this->load->view('frontend/maintaince/preventive_maintaince_view', $data, true), 'popup_div', true);
    }

    function breakdown_maintaince() {
        ///////////////  Filters //////////////////

        $data['search'] = $search = ($this->post['search']) ? $this->post['search'] : $this->fdata['search'];
        $data['search_status'] =$search_status  = ($this->post['search_status']) ? $this->post['search_status'] : $this->fdata['search_status'];
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        if ($this->post['from_date'] != '') {
            $data['from_date'] = $from_date = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date']));
        }

        if ($this->post['to_date'] != '') {
            $data['to_date'] =$to_date = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->post['to_date']));
        }

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }

        ///////////limit & offset////////

        $data['get_count'] = TRUE;
        
        
        $data['mt_type'] = 'breakdown';
        
        $district_id = "";
        
        if($this->clg->clg_group ==  'UG-DM' || $this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER' ||  $this->clg->clg_group  == 'UG-FLEETDESK' ||  $this->clg->clg_group  == 'UG-OP-HEAD'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
            $data['amb_district'] = $district_id;
            
        }
        if($this->clg->clg_group !=  'UG-VENDOR' ){
            $data['thirdparty'] = $this->clg->thirdparty;
        }
        if($this->clg->clg_group ==  'UG-VENDOR' ){
            $data['vendor_id'] = $this->clg->clg_ref_id;
        }
        $data['total_count'] = $this->ambmain_model->get_ambulance_break_maintance_data($data);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;



        unset($data['get_count']);



        $data['maintance_data'] = $this->ambmain_model->get_ambulance_break_maintance_data($data, $offset, $limit);

        /////////////////////////

        $data['cur_page'] = $page_no;
        $search = $data['search'];

        $pgconf = array(
            'url' => base_url("ambulance_maintaince/breakdown_maintaince"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
            'data-qr' => "output_position=content&amp;pglnk=true&search=$search&search_status=$search_status&to_date=$to_date&from_date=$from_date"
            )
        );

        $data['pgconf'] = $pgconf;
        $data['pagination'] = get_pagination($pgconf);

        /////////////////////////////////

        $data['page_records'] = $data['total_count'];
        $data['clg_group'] = $this->clg->clg_group;

        $this->output->add_to_position($this->load->view('frontend/maintaince/breakdown_maintaince_list_view', $data, true), $this->post['output_position'], true);
    }

    function breakdown_maintaince_registrartion() {
        $data['clg_ref_id'] = $this->clg->clg_ref_id;
        $this->session->set_userdata('cons_data','');

        if ($this->post['mt_id'] != '') {

            $data['mt_id'] = $ref_id = base64_decode($this->post['mt_id']);
            
            $data['mt_type'] = 'breakdown';
            $data['preventive'] = $this->ambmain_model->get_ambulance_break_maintance_data($data);
            $data['media'] = $this->ambmain_model->get_media_maintance($data);
            
            $vendor_job = array('mt_id'=>$ref_id,'mt_type' =>'vendor_job_card_breakdown');
            $data['vendor_job_card'] = $this->ambmain_model->get_media_maintance($vendor_job);
            
         
            $in_job_data = array('mt_id'=>$ref_id,'mt_type'=>'vendor_invoice_breakdown');
            $data['vendor_invoice'] = $this->ambmain_model->get_media_maintance($in_job_data);
           
            //var_dump($data );die;
             $inv_args = array('as_sub_id'=>$data['mt_id'],'as_sub_type'=>'break_maintaince_part','as_stk_in_out'=>'out');
            $data['used_invitem'] = $this->maintenance_part_model->get_breakdown_maintaince_part($inv_args);
             
            $args_part = array('req_maintanance_id'=>$data['mt_id'],'req_maintanance_type'=>'breakdown_maintaince');
            $data['indent_data'] = $this->maintenance_part_model->get_all_maintenance_part($args_part);

            
            if($data['indent_data']){
                $args_req_part = array('req_id'=>$data['indent_data'][0]->req_id);
                $data['req_mate_part'] = $this->maintenance_part_model->get_item_maintenance_part_data($args_req_part);
            }
        }
       
             $non_args = array('mt_maintanance_type'=>'0');
            $data['invitem'] = $this->maintenance_part_model->get_maintenance_part_list($non_args,0,400);
        //var_dump($data['invitem']);
       // die();
        $data['shift_info'] = $this->common_model->get_shift($args);
        $data['clg_group'] = $this->clg->clg_group;


        if ($this->post['action_type'] == 'Update_Breakdown') {

            $data['action_type'] = "Update Breakdown Maintenance Request";
            $data['type'] = "Update_Breakdown";
            $data['update'] = 'True';

            $this->output->add_to_popup($this->load->view('frontend/maintaince/breakdown_maintaince_register_view', $data, TRUE), '1600', '1000');
        }else if ($this->post['action_type'] == 'Update') {

            $data['action_type'] = "Closure and Invoice Approval";
            $data['type'] = "Update";
            $data['update'] = 'True';

            $this->output->add_to_popup($this->load->view('frontend/maintaince/breakdown_maintaince_register_view', $data, TRUE), '1600', '1000');
        }else if ($this->post['action_type'] == 'upload_job_card') {

            $data['action_type'] = "Upload Job Card Image/Photo/Estimate";
            $data['type'] = "upload_job_card";
            $data['update'] = 'True';

            $this->output->add_to_popup($this->load->view('frontend/maintaince/breakdown_maintaince_register_view', $data, TRUE), '1600', '1000');
        } else if ($this->post['action_type'] == 'upload_invoice') {

            $data['action_type'] = "Upload Invoice/Bill";
            $data['type'] = "upload_invoice";
            $data['update'] = 'True';

            $this->output->add_to_popup($this->load->view('frontend/maintaince/breakdown_maintaince_register_view', $data, TRUE), '1600', '1000');
        } else {

            $data['action_type'] = "Add Request for Breakdown Maintenance(Repair)";
            $state_id = $this->clg->clg_state_id;
            $data['state_id'] = $state_id;
            $this->output->add_to_popup($this->load->view('frontend/maintaince/breakdown_maintaince_register_view', $data, TRUE), '1600', '1000');
            

        }
    }

    function rerequest_breakdown_maintaince(){
       
        $data['clg_group']=$this->clg->clg_group;
        if ($this->post['mt_id'] != '') {

            $data['mt_id'] = $ref_id = $this->post['mt_id'];
            
            $data['mt_type'] = 'breakdown';
            $data['preventive'] = $this->ambmain_model->get_ambulance_break_maintance_data($data);
            $data['media'] = $this->ambmain_model->get_media_maintance($data);
        }

        $args =array(
            'mt_id'=>       $this->post['mt_id'],
            'mt_type'=>      $data['mt_type']
        );
        $data['app_rej_his'] = $this->ambmain_model->get_app_rej_his($args);
        if ($this->post['action_type'] == 'Update') {

            $data['action_type'] = "Update Breakdown Maintenance";
            $data['type'] = "Update";
            $data['update'] = 'True';

            $this->output->add_to_popup($this->load->view('frontend/maintaince/breakdown_maintaince_register_view', $data, TRUE), '1600', '1000');
        } elseif($this->post['action_type'] == 'Approve'){
            $data['type'] = "Approve";
            $data['action_type'] = "Approve Breakdown Maintenance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/breakdown_maintaince_register_view', $data, TRUE), '1600', '1000');
        }elseif($this->post['action_type'] == 'Rerequest') {
            $data['type'] = "Rerequest";
            $data['action_type'] = "Re-request Breakdown Maintenance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/breakdown_maintaince_register_view', $data, TRUE), '1600', '1000');
        }else{
            $data['action_type'] = "Add Breakdown Maintenance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/breakdown_maintaince_register_view', $data, TRUE), '1600', '1000');
        
        }

    }

    function approve_breakdown_maintaince() {



        if ($this->post['mt_id'] != '') {

            $data['mt_id'] = $ref_id = $this->post['mt_id'];
            $data['re_request_id'] = $this->post['re_request_id'];
            $data['mt_type'] = 'breakdown';
            $data['preventive'] = $this->ambmain_model->get_ambulance_break_maintance_data($data);
            $data['media'] = $this->ambmain_model->get_media_maintance($data);
            
            $vendor_job = array('mt_id'=>$ref_id,'mt_type' =>'vendor_job_card_breakdown');
            $data['vendor_job_card'] = $this->ambmain_model->get_media_maintance($vendor_job);
            
         
            $in_job_data = array('mt_id'=>$ref_id,'mt_type'=>'vendor_invoice_breakdown');
            $data['vendor_invoice'] = $this->ambmain_model->get_media_maintance($in_job_data);
            
              $inv_args = array('as_sub_id'=>$data['mt_id'],'as_sub_type'=>'break_maintaince_part','as_stk_in_out'=>'out');
            $data['used_invitem'] = $this->maintenance_part_model->get_breakdown_maintaince_part($inv_args);
             

            $args_part = array('req_maintanance_id'=>$data['mt_id'],'req_maintanance_type'=>'breakdown_maintaince');
            $data['indent_data'] = $this->maintenance_part_model->get_all_maintenance_part($args_part);

            
            if($data['indent_data']){
                $args_req_part = array('req_id'=>$data['indent_data'][0]->req_id);
                $data['req_mate_part'] = $this->maintenance_part_model->get_item_maintenance_part_data($args_req_part);
            }
        }
        $args =array(
            'mt_id'=>       $this->post['mt_id'],
            'mt_type'=>      $data['mt_type'],
            're_request_id'=> $this->post['re_request_id']
        );
        $re_request_id = $this->ambmain_model->get_photo_history($args);

        $data['media'] = $this->ambmain_model->get_media_maintance($data);
        $arr =array(
            'mt_id'=>       $this->post['mt_id'],
            'mt_type'=>      $data['mt_type'],
            're_request_id'=> $this->post['re_request_id']
        );
        $his = $this->ambmain_model->get_history($arr);
        foreach($his as $history){ //var_dump($history);
            $args_his = array('mt_id' => $this->post['mt_id'], 're_request_id' => $history->re_request_id);
            $history_images = $this->ambmain_model->get_history_photo($args_his);
            $history->his_photo = $history_images;
            $data['his'][] = $history;
        }
        
        if ($this->post['action_type'] == 'Update') {

            $data['action_type'] = "Update Breakdown Maintenance";
            $data['type'] = "Update";
            $data['update'] = 'True';

            $this->output->add_to_popup($this->load->view('frontend/maintaince/breakdown_maintaince_register_view', $data, TRUE), '1600', '1000');
        } elseif($this->post['action_type'] == 'Approve'){
            $data['type'] = "Approve";
            $data['action_type'] = "Approve Breakdown Maintenance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/breakdown_maintaince_register_view', $data, TRUE), '1600', '1000');
        }elseif($this->post['action_type'] == 'Rerequest') {
            $data['type'] = "Rerequest";
            $data['action_type'] = "Re-request Breakdown Maintenance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/preventive_maintaince_register_view', $data, TRUE), '1600', '1000');
        }elseif($this->post['action_type'] == 'FinalApprove'){
            $data['type'] = "FinalApprove";
            $data['action_type'] = "Final Approve Breakdown Maintenance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/breakdown_maintaince_register_view', $data, TRUE), '1600', '1000');
       
        }else{
            $data['action_type'] = "Add Breakdown Maintenance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/breakdown_maintaince_register_view', $data, TRUE), '1600', '1000');
        
        }
    }

    function breakdown_maintaince_view() {


        $data = array();


        $data['action_type'] = 'View Breakdown Maintenance';

        $data['mt_id'] = $ref_id = $this->post['mt_id'];
        $data['mt_type'] = 'breakdown';
        $data['preventive'] = $this->ambmain_model->get_ambulance_break_maintance_data($data);
        $data['media'] = $this->ambmain_model->get_media_maintance($data);
        
        
        $inv_args = array('as_sub_id'=>$data['mt_id'],'as_sub_type'=>'break_maintaince_part','as_stk_in_out'=>'out');
        $data['used_invitem'] = $this->maintenance_part_model->get_breakdown_maintaince_part($inv_args);


        $args_part = array('req_maintanance_id'=>$data['mt_id'],'req_maintanance_type'=>'breakdown_maintaince');
        $data['indent_data'] = $this->maintenance_part_model->get_all_maintenance_part($args_part);


        if($data['indent_data']){
            $args_req_part = array('req_id'=>$data['indent_data'][0]->req_id);
            $data['req_mate_part'] = $this->maintenance_part_model->get_item_maintenance_part_data($args_req_part);
        }
        
        
        $job_data = array('mt_id'=>$ref_id,'mt_type'=>'job_card_breakdown');
        $data['job_media'] = $this->ambmain_model->get_media_maintance($job_data);
        
        $v_job_data = array('mt_id'=>$ref_id,'mt_type'=>'vendor_job_card_breakdown');
        $data['vendor_job_card'] = $this->ambmain_model->get_media_maintance($v_job_data);
        
        $in_job_data = array('mt_id'=>$ref_id,'mt_type'=>'vendor_invoice_breakdown');
        $data['vendor_invoice'] = $this->ambmain_model->get_media_maintance($in_job_data);
        
        
        $other_data = array('mt_id'=>$ref_id,'mt_type'=>'invoice_breakdown');
        $data['invoice_media'] = $this->ambmain_model->get_media_maintance($other_data);

        //Request page - Approve / Reject history
        $args =array(
            'mt_id'=> $data['mt_id'],
            'mt_type'=>  $data['mt_type']
        );
        $data['app_rej_his'] = $this->ambmain_model->get_app_rej_his($args);
       // var_dump($data['app_rej_his']);die();
        //approve page - Re-request history
        $args =array(
            'mt_id'=>       $this->post['mt_id'],
            'mt_type'=>      $data['mt_type']
        );
        $re_request_id = $this->ambmain_model->get_photo_history($args);
        $data['media'] = $this->ambmain_model->get_media_maintance($data);
        $arr =array(
            'mt_id'=>       $this->post['mt_id'],
            'mt_type'=>      $data['mt_type'],
            're_request_id'=> $this->post['re_request_id']
        );
        $his = $this->ambmain_model->get_history($arr);
        foreach($his as $history){ //var_dump($history);
            $args_his = array('mt_id' => $this->post['mt_id'], 're_request_id' => $history->re_request_id);
            $history_images = $this->ambmain_model->get_history_photo($args_his);
            $history->his_photo = $history_images;
            $data['his'][] = $history;
        }

        $data['clg_group'] = $this->clg->clg_group;
        $this->output->add_to_popup($this->load->view('frontend/maintaince/breakdown_maintaince_view', $data, TRUE), '1600', '1000');
    }

    function update_breakdown_maintaince() {

        $maintaince_data = $this->post['breakdown'];
        $maintaince_part = $this->post['unit'];
         
        $prev_args   = array('mt_id'=>$maintaince_data['mt_id']);
         $preventive = $this->ambmain_model->get_ambulance_break_maintance_data($prev_args)[0];
        

        $status = '6';
        $approve  = 'Pending for final invoice approval by fleetdesk';
       
        if($preventive->mt_payment_type == 'hppay_card'){
              $status   = '7';
              $approve  = 'Request closure done';
        }
        $main_data = array('mt_end_odometer' => $this->input->post('mt_end_odometer'),
            'mt_onroad_datetime' => date('Y-m-d H:i:s', strtotime($maintaince_data['mt_onroad_datetime'])),
            'mt_isupdated' => $status,
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'),
            'mt_ambulance_status' =>$approve,
            'mt_clo_total_cost' => $this->input->post('mt_clo_total_cost'),
            'mt_clo_part_cost' => $this->input->post('mt_clo_part_cost'),
            'mt_clo_labour_cost' => $this->input->post('mt_clo_labour_cost'),
            'mt_clo_bill_number' => $this->input->post('mt_clo_bill_number'));

        $args = array_merge($this->post['breakdown'], $main_data);


         
        
        $register_result = $this->ambmain_model->update_ambulance_break_maintance($args);
        
         if(!empty($_FILES['amb_job_card']['name'])){
            foreach ($_FILES['amb_job_card']['name'] as $key => $image) {
                $media_args = array();


                $_FILES['photo']['name']= $_FILES['amb_job_card']['name'][$key];
                $_FILES['photo']['type']= $_FILES['amb_job_card']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['amb_job_card']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['amb_job_card']['error'][$key];
                $_FILES['photo']['size']= $_FILES['amb_job_card']['size'][$key];

                $_FILES['photo']['name'] = time() .'_'. $this->sanitize_file_name($_FILES['photo']['name']);
               // var_dump($_FILES['amb_photo']['name']);
                //die();

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                    $msg_p =  $this->upload->display_errors();
                    $this->output->message = "<div class='error'>".$msg_p.".. Please upload againn..!</div>";
                    //$this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                    $upload_err = TRUE;
                }
                $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['user_id'] = $maintaince_data['mt_id'];
                $media_args['media_data'] = 'job_card_breakdown';
                $this->ambmain_model->insert_media_maintance($media_args);
                // var_dump($media_args);die;
            }
        }
        
        if(!empty($_FILES['amb_invoice']['name'])){
            foreach ($_FILES['amb_invoice']['name'] as $key => $image) {
                $media_args = array();


                $_FILES['amb_invoice']['name']= $_FILES['amb_invoice']['name'][$key];
                $_FILES['amb_invoice']['type']= $_FILES['amb_invoice']['type'][$key];
                $_FILES['amb_invoice']['tmp_name']= $_FILES['amb_invoice']['tmp_name'][$key];
                $_FILES['amb_invoice']['error']= $_FILES['amb_invoice']['error'][$key];
                $_FILES['amb_invoice']['size']= $_FILES['amb_invoice']['size'][$key];

                $_FILES['amb_invoice']['name'] = time().'_'.$this->sanitize_file_name($_FILES['amb_invoice']['name']);
               // var_dump($_FILES['amb_photo']['name']);
                //die();

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('amb_invoice')) {
                     $msg_p =  $this->upload->display_errors();
                    $this->output->message = "<div class='error'>".$msg_p.".. Please upload againn..!</div>";
                    //$this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                    $upload_err = TRUE;
                }
                $media_args['media_name'] = $_FILES['amb_invoice']['name'];
                $media_args['user_id'] = $maintaince_data['mt_id'];
                $media_args['media_data'] = 'invoice_breakdown';
                $this->ambmain_model->insert_media_maintance($media_args);
                // var_dump($media_args);die;
            }
        }


        $total_km = $this->input->post('mt_end_odometer') - $this->input->post('previous_odometer');

        $amb_record_data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'start_odmeter' => $this->input->post('previous_odometer'),
            'end_odmeter' => $this->input->post('mt_end_odometer'),
            'total_km' => $total_km,
            'inc_ref_id'=>$maintaince_data['mt_id'],
            'odometer_type'       => 'update breakdown maintaince',
            'timestamp' => date('Y-m-d H:i:s'));

        if (!empty($maintaince_data['mt_off_remark'])) {
            $amb_record_data['other_remark'] = $maintaince_data['mt_off_remark'];
        }

        $amb_update_summary = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => '7,1',
            'end_odometer' => $this->input->post('mt_end_odometer'),
            'on_road_status' => "Ambulance Breakdown maintenance on road",
            'on_road_remark' => $maintaince_data['mt_on_stnd_remark'],
            'on_road_date' => date('Y-m-d', strtotime($maintaince_data['mt_onroad_datetime'])),
            'on_road_time' => date('H:i:s', strtotime($maintaince_data['mt_onroad_datetime'])),
            'added_date' => date('Y-m-d H:i:s'));

        if (!empty($maintaince_data['mt_on_remark'])) {
            $amb_update_summary['on_road_remark_other'] = $maintaince_data['mt_on_remark'];
        }

        $data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => 1,
        );
        $off_road_status = "Ambulance Breakdown maintenance off road";
        $add_summary = $this->amb_model->update_ambulance_staus_summary($amb_update_summary, $off_road_status);
        $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
        //var_dump($data);die;
        //$update = $this->amb_model->update_amb($data);
        //var_dump($update);die;
        
        if (isset($maintaince_part)) {
            foreach ($maintaince_part as $unit) {

                if ($unit['value'] != '' ) {

                    $unit_args = array(
                        'as_item_id' => $unit['id'],
                        'as_item_type' => $unit['type'],
                        'as_stk_in_out' => 'out',
                        'as_item_qty' => $unit['value'],
                        'as_sub_id' => $maintaince_data['mt_id'],
                        'as_sub_type' => 'update_break_maintaince_part',
                        'as_district_id' => $this->input->post('maintaince_district'),
                        'as_amb_reg_no' => $this->input->post('maintaince_ambulance'),
                        'as_date' => $this->today,
                        'as_base_month' => $this->post['base_month'],
                    );

                    $da = $this->maintenance_part_model->insert_maintenance_part_stock($unit_args);
                   
                }
            }
        }
       
     

        if ($register_result) {



            $this->output->status = 1;

            $this->output->message = "<div class='success'>Breakdown Maintenance Updated Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->breakdown_maintaince();
        }
    }

    function breakdown_maintaince_save() {

        $maintaince_data = $this->post['breakdown'];
        $maintaince_part = $this->post['unit'];  
        $maintaince = $this->input->post();
        //$prev= generate_maintaince_id('ems_breakdown_id');
        
        //$prev_id = "MHEMS-BM-".$prev;
        
         if($state == 'RJ'){
             $prev= generate_maintaince_id('ems_rj_breakdown_id');
            $prev_id = "RJEMS-BM-".$prev;
        }else if($state == 'MP'){
            $prev= generate_maintaince_id('ems_pm_breakdown_id');
            $prev_id = "MPEMS-BM-".$prev;
        }else{
            $prev= generate_maintaince_id('ems_breakdown_id');
            $prev_id = "MHEMS-BM-".$prev;
        }
        if($this->input->post('maintaince_district') == 'Backup'){
            $amb_data = $this->amb_model->get_amb_district(array('amb_id' =>$this->input->post('maintaince_ambulance')));
            $district_id = $amb_data[0]->amb_district ;
        }
        else{
            $district_id =  $this->input->post('maintaince_district');
        }
        
        
        $main_data = array(
            'mt_breakdown_id'=>$prev_id,
            'mt_state_id' => $this->input->post('maintaince_state'),
            'mt_district_id' => $district_id,
            'mt_amb_no' => $this->input->post('maintaince_ambulance'),
            'mt_in_odometer' => $this->input->post('in_odometer'),
            'mt_previos_odometer' => $this->input->post('previous_odometer'),
            //'mt_odometer_diff' => $this->input->post('odometer_diff'),
            'mt_base_loc' => $this->input->post('base_location'),
            'mt_Estimatecost' => $this->input->post('Estimatecost'),
            'amb_type' => $this->input->post('amb_type'),
            'mt_make' => $this->input->post('ambt_make'),
            'ambt_owner' => $this->input->post('mt_owner'),
            'mt_module' => $this->input->post('ambt_model'),
            //'mt_offroad_datetime' => date('Y-m-d H:i:s', strtotime($maintaince_data['mt_offroad_datetime'])),
            //'mt_ex_onroad_datetime' => $this->input->post('ex_onroad_datetime'),
            'informed_to' => json_encode($this->input->post('user_group')),
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'),
            'mt_isdeleted' => '0',
            'mt_type' => 'breakdown',
            'mt_base_month' => $this->post['base_month'],
            'mt_ambulance_status' => 'Pending for Job-card and Estimate',
            'mt_pilot_name' => $this->input->post('pilot_id'),
            'mt_stnd_remark'=>'Breakdown Maintenance',
            //'mt_breakdown_datetime' => 'Pending Approval',
            //'mt_breakdown_route_location' => 'Pending Approval',
            //'mt_emt_name' => $this->input->post('emt_name'),
            'other_break_type' => $this->input->post('Other'),
            'mt_breakdown_type' => $this->input->post('breakdown[mt_breakdown_type]')
        );
        
        if($maintaince_data['mt_payment_type'] == 'hppay_card'){
            $main_data['mt_isupdated'] = '1';
            $main_data['mt_ambulance_status'] = 'Pending for Approval';
            
              
        }
      
      
        if($maintaince_data['mt_work_shop'] != ''){
            $main_data['vendor_id']  = get_work_station_vendor($maintaince_data['mt_work_shop']);
            $vender_data = get_clg_data_by_ref_id($main_data['vendor_id'])[0];
            $vendor_name =$vender_data->clg_first_name.' '.$vender_data->clg_last_name; 
           
            
            
                        $vd_sms_to = $vender_data->clg_mobile_no;
                        $req_by = $this->clg->clg_ref_id;
                        $main_type = 'Breakdown Maintenance';
                       $vehicle = $this->input->post('maintaince_ambulance');
                        $link = ' https://www.mhems.in';
                        $vdMsg = "";
//                        $vdMsg .= "BVG,\n";
//                        $vdMsg .= "Maintenance request generated,";
//                        $vdMsg .= "Vendor Name:".$vendor_name; 
//                        $vdMsg .= "Vehical No:".$this->input->post('maintaince_ambulance').","; 
//                        $vdMsg .= "Requested By :".$this->clg->clg_ref_id.","; 
//                        $vdMsg .= "Please upload photo, estimate and job-card on".$link.","; 
//                        $vdMsg .= "MHEMS" ;
        $vdMsg = "BVG,\n"
."Maintenance request generated,\n"
."Vendor Name:$vendor_name\n"
."Vehicle No:$vehicle,\n"
."Requested By :$req_by,\n"
."Please upload photo, estimate and job-card on$link,\n"
."MHEMS";
                       


if($maintaince_data['mt_payment_type'] == 'vendor'){
                    $super_args = array(
                        'msg' => $vdMsg,
                        'mob_no' => $vd_sms_to,
                        'sms_user' => 'breakdown',
                    );

                    $sms_data = sms_send($super_args);
                    
        }
        }
        
        $args = array_merge($this->post['breakdown'], $main_data);
        unset($args['mt_owner']);
        
                if(!empty($_FILES['amb_photo']['name'])){
            foreach ($_FILES['amb_photo']['name'] as $key => $image) {
//                 $f_type= $_FILES['amb_photo']['type'][$key];
//
//                if ($f_type== "image/png" OR $f_type== "image/jpeg" OR $f_type== "image/JPEG" OR $f_type== "image/PNG" OR $f_type== "image/GIF"){
//                    
//                    $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
//                    $upload_err = TRUE;
//                }
               $media_args = array();


               $_FILES['photo']['name']= $_FILES['amb_photo']['name'][$key];
               $_FILES['photo']['type']= $_FILES['amb_photo']['type'][$key];
               $_FILES['photo']['tmp_name']= $_FILES['amb_photo']['tmp_name'][$key];
               $_FILES['photo']['error']= $_FILES['amb_photo']['error'][$key];
               $_FILES['photo']['size']= $_FILES['amb_photo']['size'][$key];

               //$_FILES['photo']['name'] = time().'_'.$this->sanitize_string($_FILES['photo']['name']);
               
                $_FILES['photo']['name'] = time().'_'. $this->sanitize_file_name($_FILES['photo']['name']);
             

               $rsm_config = $this->amb_pic;
               $this->upload->initialize($rsm_config);
               if (!$this->upload->do_upload('photo')) {
                    $msg_p =  $this->upload->display_errors();
                           $this->output->message = "<div class='error'>".$msg_p.".. Please upload again..!</div>";
                           $upload_err = TRUE;
                           return false;
               }
               $media_args['media_name'] = $_FILES['photo']['name'];
              // $media_args['user_id'] = $register_result;
               $media_args['media_data'] = 'breakdown';
               
               $media_records[$key] = $media_args;
               //$this->ambmain_model->insert_media_maintance($media_args);

           }
        }
     
        
        $register_result = $this->ambmain_model->insert_ambulance_break_maintance($args);
        
        if($media_records){
        foreach($media_records as $media_record){
                $media_record['user_id'] = $register_result;
                $media = $this->ambmain_model->insert_media_maintance($media_record);
               
        }
        }
        
                if($state == 'RJ'){
             $prev= generate_maintaince_id('ems_rj_onoffroad_id');
            $prev_id = "RJEMS-OM-".$prev;
        }else if($state == 'MP'){
            $prev= generate_maintaince_id('ems_pm_onoffroadl_id');
            $prev_id = "MPEMS-OM-".$prev;
        }else{
            $prev= generate_maintaince_id('ems_onoffroad_id');
            $prev_id = "MHEMS-OM-".$prev;
        }
        if($this->input->post('maintaince_district') == 'Backup'){
            $amb_data = $this->amb_model->get_amb_district(array('amb_id' =>$this->input->post('maintaince_ambulance')));
            $district_id = $amb_data[0]->amb_district ;
        }
        else{
            $district_id =  $this->input->post('maintaince_district');
        }
        
        $main_off_data = array('mt_state_id' => $this->input->post('maintaince_state'),
            'mt_onoffroad_id'=>$prev_id,
            'mt_district_id' => $district_id,
            'mt_amb_no' => $this->input->post('maintaince_ambulance'),
            'mt_in_odometer' => $this->input->post('in_odometer'),
            'mt_previos_odometer' => $this->input->post('previous_odometer'),
            'mt_odometer_diff' => $this->input->post('odometer_diff'),
            'mt_base_loc' => $this->input->post('base_location'),
            //'mt_Estimatecost' => $this->input->post('Estimatecost'),
           // 'mt_offroad_datetime' => date('Y-m-d H:i:s', strtotime($maintaince_data['mt_offroad_datetime'])),
            // 'mt_ex_onroad_datetime' =>$this->input->post('ex_onroad_datetime'),
             'amb_type' => $this->input->post('amb_type'),
            'mt_make' => $this->input->post('ambt_make'),
            'mt_module' => $this->input->post('ambt_model'),
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'),
            'mt_isdeleted' => '0',
            'mt_type' => 'onroad_offroad',
            'mt_offroad_reason' => 'Breakdown Maintenance',
            'mt_informed_group' => json_encode($this->input->post('user_group')),
            'mt_remark' => $maintaince_data['mt_remark'],
            'mt_base_month' => $this->post['base_month'],
            'mt_ambulance_status' => 'Pending Approval',
            'mt_pilot_id' =>  $maintaince_data['mt_pilot_id'],
            'amb_owner' =>  $maintaince_data['amb_owner'],
            'mt_pilot_name' => $this->input->post('pilot_id'),
            
        );

         
       

       // $main_off_data = array_merge($this->post['accidental'],$main_off_data);
       // $main_off_data['amb_owner'] = $main_off_data['mt_owner'];
      //  unset($main_off_data['mt_owner']);
        
       if($register_result){
            $off_register_result = $this->ambmain_model->insert_ambulance_on_off_maintance($main_off_data);
           
       }
       
        
       
        $inform_user_group= array();
        $inform_user_group = $this->input->post('user_group'); 
      //  $district_id = $this->input->post('maintaince_district');
      
        if(!empty($inform_user_group)){
            foreach($inform_user_group as $user_group){
                
                if($user_group != ''){
                $args_clg = array('clg_group'=>$user_group,'clg_district_id'=>$district_id);
                $register_result_clg = $this->colleagues_model->get_clg_data($args_clg);
                 if($register_result_clg){
                foreach($register_result_clg as $register){

                    $sms_to = $register->clg_mobile_no;
                        $txtMsg2 = "";
                        $txtMsg2 .= "BVG\n";
                        $txtMsg2 .= "Ambulance On Maintenance\n";
                        $txtMsg2 .= "Ambulance Number: ".$this->input->post('maintaince_ambulance')."\n"; 
                        $txtMsg2 .= "MHEMS" ;
//                    $district = get_district_by_id($this->input->post('maintaince_district'));
//                        $txtMsg2.= "";
//                        $txtMsg2.= "BVG,\n";
//                      
//                        $txtMsg2.= "Ambulance No: ".$this->input->post('maintaince_ambulance').",\n"; 
//                        $txtMsg2.= "District: ".$district." ,Base Location: ".$this->input->post('base_location')."\n"; 
//                        $txtMsg2.= "Date & Time of Schedule Servicing: ".$this->input->post('base_location')."\n"; 
//                        $txtMsg2.= "MEMS" ;

                    $super_args = array(
                        'msg' => $txtMsg2,
                        'mob_no' => $sms_to,
                        'sms_user' => 'breakdown',
                    );

                    //$sms_data = sms_send($super_args);

                    $from = 'fleetdeskmems@bvgmems.com';

                    $email = $register->clg_email;
                    $subject = "Ambulance On Maintenance";
                    $mail_res = $this->_send_email($email, $from,$subject, $txtMsg2);               
                }

            }
            }
            }
        }
        
        if($this->input->post('pilot_id') != ''){
            $pilot_clg = array('clg_ref_id'=>$this->input->post('pilot_id'));
            $pilot_clg_result = $this->colleagues_model->get_clg_data($pilot_clg);
            foreach($pilot_clg_result as $pilot){

                    $pilot_sms_to = $pilot->clg_mobile_no;
                    $txtMsg2= "";
                    $txtMsg2.= "BVG\n";
                    $txtMsg2 .= "Ambulance On Maintenance\n";
                    $txtMsg2.= "Ambulance Number: ".$this->input->post('maintaince_ambulance')."\n"; 
                    $txtMsg2.= "MHEMS" ;

                $pilot_args = array(
                    'msg' => $txtMsg2,
                    'mob_no' => $pilot_sms_to,
                    'sms_user' => 'breakdown',
                );

                //$pilot_sms_data = sms_send($pilot_args);
                
                $from = 'fleetdeskmems@bvgmems.com';

                $email = $pilot->clg_email;
                $subject = "Ambulance On Maintenance";
                $mail_res = $this->_send_email($email, $from,$subject, $txtMsg2); 
            }
        }
        

        
        //if (!$upload_err){

        $total_km = (int)$this->input->post('in_odometer') - (int)$this->input->post('previous_odometer');

        $amb_record_data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'start_odmeter' => $this->input->post('previous_odometer'),
            'end_odmeter' => $this->input->post('in_odometer'),
            'odometer_type'       => 'breakdown maintenance',
            'inc_ref_id'=>$register_result,
            'total_km' => $total_km,
            'timestamp' => date('Y-m-d H:i:s'));

        if (!empty($maintaince_data['mt_remark'])) {
            $amb_record_data['other_remark'] = $maintaince_data['mt_remark'];
        }

        $amb_update_summary = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => 1,
            'start_odometer' => $this->input->post('previous_odometer'),
            'off_road_status' => "Pending for Approval",
            'off_road_remark' => $maintaince_data['mt_stnd_remark'],
           // 'off_road_date' => date('Y-m-d', strtotime($maintaince_data['mt_offroad_datetime'])),
            //'off_road_time' => date('H:i:s', strtotime($maintaince_data['mt_offroad_datetime'])),
            'added_date' => date('Y-m-d H:i:s'));

        if (!empty($maintaince_data['mt_remark'])) {
            $amb_update_summary['off_road_remark_other'] = $maintaince_data['mt_remark'];
        }

        $amb_update = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => 1,
        );   
       
        if (isset($maintaince_part)) {
            foreach ($maintaince_part as $unit) {

                if ($unit['value'] != '' ) {

                    $unit_args = array(
                        'as_item_id' => $unit['id'],
                        'as_item_type' => $unit['type'],
                        'as_stk_in_out' => 'out',
                        'as_item_qty' => $unit['value'],
                        'as_sub_id' => $register_result,
                        'as_sub_type' => 'break_maintaince_part',
                        'as_district_id' => $main_data['mt_district_id'],
                        'as_amb_reg_no' => $this->input->post('maintaince_ambulance'),
                        'as_date' => $this->today,
                        'as_base_month' => $this->post['base_month'],
                    );

                    $this->maintenance_part_model->insert_maintenance_part_stock($unit_args);
                }
            }
        }
       
        
        if($maintaince_data['mt_send_material_request'] == 'Yes'){

            $args = array(
                'req_date' => $this->today,
                'req_base_month' => $this->post['base_month'],
                'req_by' => $this->clg->clg_ref_id,
                'req_state_code' => $this->input->post('maintaince_state'),
                'req_amb_reg_no' => $this->input->post('maintaince_ambulance'),
                'req_district_code' => $this->input->post('maintaince_district'),
                'req_base_location'=>$this->input->post('base_location'),
                'current_odometer'=>$this->input->post('in_odometer'),
               // 'req_shift_type' => $ind_data['req_shift_type'],
             //   'req_expected_date_time' => date('Y-m-d H:i:s', strtotime($ind_data['req_expected_date_time'])),
                //'req_district_manager' => $ind_data['req_district_manager'],
                'req_standard_remark' => 'Maintenance Part Request send sucessfully',
              //  'req_supervisor' => $ind_data['req_supervisor'],
                'req_maintanance_type' => 'breakdown_maintaince',
                'req_maintanance_id' => $register_result,
                'req_isdeleted' => '0',
            );

         
            $item_key = array('Force_BSIII', 'Force_BSIV','Ashok_Leyland_BSIV');
            $req = $this->maintenance_part_model->insert_maintenance_part($args);

            foreach ($item_key as $key) {
                if (is_array($this->post['req'][$key])) {

                    foreach ($this->post['req'][$key] as $dt) {

                        if (!empty($dt['id'])) {

                              $ind_data = array(
                                'ind_item_id' => $dt['id'],
                                'ind_quantity' => $dt['qty'],
                                'ind_item_type' => $key,
                                'ind_req_id' => $req,
                            );


                            $result = $this->maintenance_part_model->maintenance_part_item($ind_data);
                        }
                    }
                }
            }
        }


        if ($register_result) {

            $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
            $add_summary = $this->amb_model->insert_amb_staus_summary($amb_update_summary);
            //$update = $this->amb_model->update_amb($amb_update);

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Breakdown Maintenance Registered Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->breakdown_maintaince();
        }
        //}
    }
        function breakdown_maintaince_update() {

        $maintaince_data = $this->post['breakdown'];
        $maintaince_part = $this->post['unit'];  
        $maintaince = $this->input->post();
        //$prev= generate_maintaince_id('ems_breakdown_id');
       
        //$prev_id = "MHEMS-BM-".$prev;

        if($this->input->post('maintaince_district') == 'Backup'){
            $amb_data = $this->amb_model->get_amb_district(array('amb_id' =>$this->input->post('maintaince_ambulance')));
            $district_id = $amb_data[0]->amb_district ;
        }
        else{
            $district_id =  $this->input->post('maintaince_district');
        }
       
        
        $main_data = array(
            

            //'mt_odometer_diff' => $this->input->post('odometer_diff'),
            'mt_base_loc' => $this->input->post('base_location'),
            'mt_Estimatecost' => $this->input->post('Estimatecost'),
            'amb_type' => $this->input->post('amb_type'),
            'mt_make' => $this->input->post('ambt_make'),
            'ambt_owner' => $this->input->post('mt_owner'),
            'mt_module' => $this->input->post('ambt_model'),
            //'mt_offroad_datetime' => date('Y-m-d H:i:s', strtotime($maintaince_data['mt_offroad_datetime'])),
            //'mt_ex_onroad_datetime' => $this->input->post('ex_onroad_datetime'),
            'informed_to' => json_encode($this->input->post('user_group')),
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'),
            'mt_isdeleted' => '0',
            'mt_type' => 'breakdown',
            'mt_base_month' => $this->post['base_month'],
            'mt_ambulance_status' => 'Pending for Job-card and Estimate',
            'mt_pilot_name' => $this->input->post('pilot_id'),
            'mt_stnd_remark'=>'Breakdown Maintenance',
            //'mt_breakdown_datetime' => 'Pending Approval',
            //'mt_breakdown_route_location' => 'Pending Approval',
            //'mt_emt_name' => $this->input->post('emt_name'),
            'other_break_type' => $this->input->post('Other'),
            'mt_breakdown_type' => $this->input->post('breakdown[mt_breakdown_type]')
        );
        if($maintaince_data['mt_payment_type'] == 'hppay_card'){
            $main_data['mt_isupdated'] = '1';
            $main_data['mt_ambulance_status'] = 'Pending for Approval';
            
              
        }
      
        
        $args = array_merge($this->post['breakdown'], $main_data);
        unset($args['mt_owner']);
        
         if(!empty($_FILES['amb_photo']['name'])){
            foreach ($_FILES['amb_photo']['name'] as $key => $image) {

               $media_args = array();


               $_FILES['photo']['name']= $_FILES['amb_photo']['name'][$key];
               $_FILES['photo']['type']= $_FILES['amb_photo']['type'][$key];
               $_FILES['photo']['tmp_name']= $_FILES['amb_photo']['tmp_name'][$key];
               $_FILES['photo']['error']= $_FILES['amb_photo']['error'][$key];
               $_FILES['photo']['size']= $_FILES['amb_photo']['size'][$key];

               //$_FILES['photo']['name'] = time().'_'.$this->sanitize_string($_FILES['photo']['name']);
               
                $_FILES['photo']['name'] = time().'_'. $this->sanitize_file_name($_FILES['photo']['name']);
             

               $rsm_config = $this->amb_pic;
               $this->upload->initialize($rsm_config);
               if (!$this->upload->do_upload('photo')) {
                    $msg_p =  $this->upload->display_errors();
                           $this->output->message = "<div class='error'>".$msg_p.".. Please upload again..!</div>";
                           $upload_err = TRUE;
                           return false;
               }
               $media_args['media_name'] = $_FILES['photo']['name'];
              // $media_args['user_id'] = $register_result;
               $media_args['media_data'] = 'breakdown';
               
               $media_records[$key] = $media_args;
               //$this->ambmain_model->insert_media_maintance($media_args);

           }
        }
     
        
        $register_result = $this->ambmain_model->update_ambulance_break_maintance($args);
        
        if($media_records){
        foreach($media_records as $media_record){
                $media_record['user_id'] = $maintaince_data['mt_id'];
                $media = $this->ambmain_model->insert_media_maintance($media_record);
               
        }
        }

        
        //if (!$upload_err){

        $total_km = (int)$this->input->post('in_odometer') - (int)$this->input->post('previous_odometer');

        $amb_record_data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'start_odmeter' => $this->input->post('previous_odometer'),
            'end_odmeter' => $this->input->post('in_odometer'),
            'odometer_type'       => 'breakdown maintenance',
            'inc_ref_id'=>$register_result,
            'total_km' => $total_km,
            'timestamp' => date('Y-m-d H:i:s'));

        if (!empty($maintaince_data['mt_remark'])) {
            $amb_record_data['other_remark'] = $maintaince_data['mt_remark'];
        }

        $amb_update = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => 1,
        );   
       
        if (isset($maintaince_part)) {
            foreach ($maintaince_part as $unit) {

                if ($unit['value'] != '' ) {

                    $unit_args = array(
                        'as_item_id' => $unit['id'],
                        'as_item_type' => $unit['type'],
                        'as_stk_in_out' => 'out',
                        'as_item_qty' => $unit['value'],
                        'as_sub_id' => $register_result,
                        'as_sub_type' => 'break_maintaince_part',
                        'as_district_id' => $main_data['mt_district_id'],
                        'as_amb_reg_no' => $this->input->post('maintaince_ambulance'),
                        'as_date' => $this->today,
                        'as_base_month' => $this->post['base_month'],
                    );

                    //$this->maintenance_part_model->insert_maintenance_part_stock($unit_args);
                }
            }
        }
       
        
        if($maintaince_data['mt_send_material_request'] == 'Yes'){

            $args = array(
                'req_date' => $this->today,
                'req_base_month' => $this->post['base_month'],
                'req_by' => $this->clg->clg_ref_id,
                'req_state_code' => $this->input->post('maintaince_state'),
                'req_amb_reg_no' => $this->input->post('maintaince_ambulance'),
                'req_district_code' => $this->input->post('maintaince_district'),
                'req_base_location'=>$this->input->post('base_location'),
                'current_odometer'=>$this->input->post('in_odometer'),
               // 'req_shift_type' => $ind_data['req_shift_type'],
             //   'req_expected_date_time' => date('Y-m-d H:i:s', strtotime($ind_data['req_expected_date_time'])),
                //'req_district_manager' => $ind_data['req_district_manager'],
                'req_standard_remark' => 'Maintenance Part Request send sucessfully',
              //  'req_supervisor' => $ind_data['req_supervisor'],
                'req_maintanance_type' => 'breakdown_maintaince',
                'req_maintanance_id' => $register_result,
                'req_isdeleted' => '0',
            );

         
            $item_key = array('Force_BSIII', 'Force_BSIV','Ashok_Leyland_BSIV');
           // $req = $this->maintenance_part_model->insert_maintenance_part($args);

            foreach ($item_key as $key) {
                if (is_array($this->post['req'][$key])) {

                    foreach ($this->post['req'][$key] as $dt) {

                        if (!empty($dt['id'])) {

                              $ind_data = array(
                                'ind_item_id' => $dt['id'],
                                'ind_quantity' => $dt['qty'],
                                'ind_item_type' => $key,
                                'ind_req_id' => $req,
                            );


                           // $result = $this->maintenance_part_model->maintenance_part_item($ind_data);
                        }
                    }
                }
            }
        }


        if ($register_result) {

            $record_data = $this->amb_model->insert_timestamp_record($amb_record_data);
            //$add_summary = $this->amb_model->insert_amb_staus_summary($amb_update_summary);
            //$update = $this->amb_model->update_amb($amb_update);

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Breakdown Maintenance Registered Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->breakdown_maintaince();
        }
        //}
    }
    
    function upload_job_card(){
        $maintaince_data = $this->post['breakdown'];
         


        $main_data = array(
            'mt_isupdated' => '1',
            'jobcard_upload_by' => $this->clg->clg_ref_id,
            'mt_ambulance_status' => 'Pending for estimate approval by fleetdesk',
            'jobcard_upload_date' => date('Y-m-d H:i:s'));

        $args = array_merge($this->post['breakdown'], $main_data);


        $register_result = $this->ambmain_model->update_ambulance_break_maintance($args);
      
        
         if(!empty($_FILES['vendor_job_card']['name'])){
            foreach ($_FILES['vendor_job_card']['name'] as $key => $image) {
                $media_args = array();


                $_FILES['photo']['name']= $_FILES['vendor_job_card']['name'][$key];
                $_FILES['photo']['type']= $_FILES['vendor_job_card']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['vendor_job_card']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['vendor_job_card']['error'][$key];
                $_FILES['photo']['size']= $_FILES['vendor_job_card']['size'][$key];
            //    var_dump( $_FILES['photo']['name']); die();
               $_FILES['photo']['name'] = time() .'_'. $this->sanitize_file_name($_FILES['photo']['name']);
               // var_dump($_FILES['amb_photo']['name']);
                //die();

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                    $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                    $upload_err = TRUE;
                }
                $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['user_id'] = $maintaince_data['mt_id'];
                $media_args['media_data'] = 'vendor_job_card_breakdown';
                $this->ambmain_model->insert_media_maintance($media_args);
                // var_dump($media_args);die;
            }
        }


        if ($register_result) {



            $this->output->status = 1;

            $this->output->message = "<div class='success'>Breakdown Maintenance Updated Successfully!</div>";

            $this->output->closepopup = 'yes';

           $this->breakdown_maintaince();
       //}
    
    

         ///   $this->vendor_view();
        }
    }
       function vendor_view(){
       // $this->load->view('templates/header');
           $data=array('vendor_id'=>$this->clg->clg_ref_id);
           
        $data['maintance_data'] = $this->ambmain_model->get_ambulance_break_maintance_data($data, $offset, $limit);
        $data['clg_group'] = $this->clg->clg_group;
        $this->output->add_to_position($this->load->view('frontend/maintaince/breakdown_maintaince_list_view', $data, true), $this->post['output_position'], true);
       //$this->output->add_to_position($this->load->view('frontend/maintaince/vendor_breakdown_maintaince_list_view_new1', $data, true), $this->post['output_position'], true);
       // $this->output->add_to_position($this->load->view('frontend/maintaince/vendor_breakdown_maintaince_list_view', $data, true), $this->post['output_position'], true);
       //$this->load->view('templates/footer');
        //$this->output->template = "nhm_blank";
        
    }
    function upload_invoice_bill(){
        $maintaince_data = $this->post['breakdown'];
         


        $main_data = array('mt_isupdated' => '5',
             'mt_ambulance_status' => 'Pending for invoice Approve by Fleet Manager',);


        $args = array_merge($this->post['breakdown'], $main_data);
        
        
        $data['mt_id'] = $ref_id = $maintaince_data['mt_id'];
         $preventive = $this->ambmain_model->get_ambulance_break_maintance_data($data)[0];
       
     
         if(!empty($_FILES['vendor_invoice']['name'])){
            foreach ($_FILES['vendor_invoice']['name'] as $key => $image) {
                $media_args = array();


                $_FILES['photo']['name'] = $_FILES['vendor_invoice']['name'][$key];
                $_FILES['photo']['type'] = $_FILES['vendor_invoice']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['vendor_invoice']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['vendor_invoice']['error'][$key];
                $_FILES['photo']['size']= $_FILES['vendor_invoice']['size'][$key];

                $_FILES['photo']['name'] = time() .'_'. $this->sanitize_file_name($_FILES['photo']['name']);
               // var_dump($_FILES['amb_photo']['name']);
                //die();

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                     $msg_p =  $this->upload->display_errors();
                    $this->output->message = "<div class='error'>$msg_p .. Please upload again..!</div>";
                    $upload_err = TRUE;
                }
                $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['user_id'] = $maintaince_data['mt_id'];
                $media_args['media_data'] = 'vendor_invoice_breakdown';
                $this->ambmain_model->insert_media_maintance($media_args);
                // var_dump($media_args);die;
            }
        }
         $register_result = $this->ambmain_model->update_ambulance_break_maintance($args);

        if ($register_result) {
            
                $vender_data = get_clg_data_by_ref_id($this->input->post('vendor_id'))[0];
                $vendor_name = $vender_data->clg_first_name.' '.$vender_data->clg_last_name;
           
            
            
                $vd_sms_to = $vender_data->clg_mobile_no;
                $mtype = $this->input->post('mt_breakdown_id');
                $vehicle = $this->input->post('maintaince_ambulance');
             
                $vdMsg = "";
                $vdMsg .= "BVG,\n"
."$vendor_name\n"
."Your invoice has been uploaded for "
."$mtype.\n"
."Vehicle No :$vehicle,\n"
."We will process & inform,\n"
."Thank You.\n"
."MHEMS";


            $super_args = array(
                'msg' => $vdMsg,
                'mob_no' => $vd_sms_to,
                'sms_user' => 'breakdown',
            );

            $sms_data = sms_send($super_args);



            $this->output->status = 1;

            $this->output->message = "<div class='success'>Breakdown Maintenance Updated Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->breakdown_maintaince();
        }
    }

    function show_other_break_type() {

        $this->output->add_to_position($this->load->view('frontend/maintaince/other_break_type_view', $data, TRUE), 'remark_other_textbox', TRUE);
    }
    function accidental_maintaince() {

        ///////////////  Filters //////////////////

        $data['search'] =$search = ($this->post['search']) ? $this->post['search'] : $this->fdata['search'];
        $data['search_status'] = $search_status = ($this->post['search_status']) ? $this->post['search_status'] : $this->fdata['search_status'];
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        if ($this->post['from_date'] != '') {
            $data['from_date']= $from_date = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date']));
        }

        if ($this->post['to_date'] != '') {
            $data['to_date'] = $to_date = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->post['to_date']));
        }

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }

        ///////////limit & offset////////

        $data['get_count'] = TRUE;
        $data['mt_type'] = 'accidental';
        
        $district_id = "";
        if($this->clg->clg_group ==  'UG-DM' || $this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER' ||  $this->clg->clg_group  == 'UG-FLEETDESK' ||  $this->clg->clg_group  == 'UG-OP-HEAD'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
            $data['amb_district'] = $district_id;
            
        }
        $data['thirdparty'] = $this->clg->thirdparty;
        $data['total_count'] = $this->ambmain_model->get_ambulance_accidental_maintance_data($data);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;



        unset($data['get_count']);



        $data['maintance_data'] = $this->ambmain_model->get_ambulance_accidental_maintance_data($data, $offset, $limit);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("ambulance_maintaince/accidental_maintaince"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
            'data-qr' => "output_position=content&amp;pglnk=true&search=$search&search_status=$search_status&to_date=$to_date&from_date=$from_date"
            )
        );

        $data['pgconf'] = $pgconf;
        $data['pagination'] = get_pagination($pgconf);

        /////////////////////////////////

        $data['page_records'] = $data['total_count'];


        $this->output->add_to_position($this->load->view('frontend/maintaince/accidental_maintaince_list_view', $data, true), $this->post['output_position'], true);
    }

    function approve_accidental_maintaince() {
 
//var_dump($this->input->post()); die;
        if ($this->post['mt_id'] != '') {

            $data['mt_id'] = $ref_id = $this->post['mt_id'];
            $data['mt_type'] = 'accidental';
            $data['preventive'] = $this->ambmain_model->get_ambulance_accidental_maintance_data($data);
            //var_dump($data);die;
            
            $args_part = array('req_maintanance_id'=>$data['mt_id'],'req_maintanance_type'=>'accidental_maintaince');
            $data['indent_data'] = $this->maintenance_part_model->get_all_maintenance_part($args_part);

            
            if($data['indent_data']){
                $args_req_part = array('req_id'=>$data['indent_data'][0]->req_id);
                $data['req_mate_part'] = $this->maintenance_part_model->get_item_maintenance_part_data($args_req_part);
            }
        }
        $args =array(
            'mt_id'=> $this->post['mt_id'],
            'mt_type'=> $data['mt_type']
        );
        
        $re_request_id = $this->ambmain_model->get_photo_history($args);
       $data['media'] = $this->ambmain_model->get_media_maintance($data); 
        $arr =array(
            'mt_id'=> $this->post['mt_id'],
            'mt_type'=> $data['mt_type'],
            're_request_id'=> $this->post['re_request_id']
        );
       
        $his = $this->ambmain_model->get_history($arr);
        foreach($his as $history){
            //var_dump($history);
            $args_his = array('mt_id' => $this->post['mt_id'], 're_request_id' => $history->re_request_id);
            $history_images = $this->ambmain_model->get_history_photo($args_his);
            $history->his_photo = $history_images;
            $data['his'][] = $history;
        }
      
      //$data['req_'] = $this->ambmain_model->get_history($this->post['mt_id'],$this->post['re_request_id']);
       
        if ($this->post['action_type'] == 'Update') {

            $data['action_type'] = "Update Accidental Maintenance";
            $data['type'] = "Update";
            $data['update'] = 'True';
            $this->output->add_to_popup($this->load->view('frontend/maintaince/accidental_maintaince_register_view', $data, TRUE), '1200', '500');
        }elseif($this->post['action_type'] == 'Approve') {
            //echo "hi"; die;
            $data['type'] = "Approve";
            $data['action_type'] = "Approve Accidental Maintenance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/accidental_maintaince_register_view', $data, TRUE), '1200', '500');
        }elseif($this->post['action_type'] == 'Rerequest') {
            //echo "hi"; die;
            $data['type'] = "Rerequest";
            $data['action_type'] = "Rerequest Accidental Maintenance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/accidental_maintaince_register_view', $data, TRUE), '1200', '500');
        }else{
            $data['action_type'] = "Add Accidental Maintenance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/accidental_maintaince_register_view', $data, TRUE), '1200', '500');

        }
        
    }
    function update_rerequest_breakdown_maintaince(){

        $app_data = $this->input->post('app');
        //var_dump($app_data);die;
         $app_data = array(
            //'re_request_id' = > $app_data['re_request_id'],
            'mt_id' => $app_data['mt_id'],
            're_request_remark' => $app_data['re_request_remark'],
            're_mt_type' => 'breakdown',
             're_requestby' => $this->clg->clg_ref_id,
            're_request_date' => date('Y-m-d H:i:s')
        );
        $register_result = $this->ambmain_model->re_request_ambulance_accidental_maintance($app_data);
        if(!empty($_FILES['amb_photo']['name'])){
            
            foreach ($_FILES['amb_photo']['name'] as $key => $image) {
                $media_args = array();
                $_FILES['photo']['name']= $_FILES['amb_photo']['name'][$key];
                $_FILES['photo']['type']= $_FILES['amb_photo']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['amb_photo']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['amb_photo']['error'][$key];
                $_FILES['photo']['size']= $_FILES['amb_photo']['size'][$key];
                $_FILES['photo']['name'] = time() .'_'. $this->sanitize_file_name($_FILES['photo']['name']);
               //var_dump($_FILES['amb_photo']['name']);
                //die();

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                            $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                            $upload_err = TRUE;
                }
               $media_args['re_request_id'] =$register_result;
                $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['user_id'] = $app_data['mt_id'];
                $media_args['media_data'] = 'breakdown';
                $this->ambmain_model->insert_media_maintance($media_args);

            }
        }
        
        if ($register_result) {
            $this->output->status = 1;
            $this->output->message = "<div class='success'>Breakdown Maintenance Re-request Registered Successfully!</div>";
            $this->output->closepopup = 'yes';
            $this->breakdown_maintaince();
        }
    }
    function preventive_re_request()
    {
        $data['clg_group']=$this->clg->clg_group;
        if ($this->post['mt_id'] != '') {

            $data['mt_id'] = $ref_id = $this->post['mt_id'];
            $data['mt_type'] = 'preventive';
            $data['preventive'] = $this->ambmain_model->get_ambulance_maintance_data($data);
            $data['media'] = $this->ambmain_model->get_media_maintance($data);
             $arr =array(
            'mt_id'=>       $data['mt_id'],
            'mt_type'=>      'preventive',
            're_request_id'=> $this->post['re_request_id']);
            $his = $this->ambmain_model->get_history($arr);
            
            foreach($his as $history){ 
            $args = array('mt_id' => $this->post['mt_id'], 're_request_id' => $history->re_request_id);
            $history->his_photo[] = $this->ambmain_model->get_history_photo($args);
            $data['his'][] = $history;
            }
        }
        $args =array(
            'mt_id'=>       $this->post['mt_id'],
            'mt_type'=>      $data['mt_type']
        );
        $data['app_rej_his'] = $this->ambmain_model->get_app_rej_his($args);
        if ($this->post['action_type'] == 'Update') {

            $data['action_type'] = "Update Preventive Maintenance";
            $data['type'] = "Update";
            $data['update'] = 'True';

            $this->output->add_to_popup($this->load->view('frontend/maintaince/preventive_maintaince_register_view', $data, TRUE), '1600', '1000');
        } elseif ($this->post['action_type'] == 'Approve') {
            $data['type'] = "Approve";
            $data['action_type'] = "Approve Preventive Maintenance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/preventive_maintaince_register_view', $data, TRUE), '1600', '1000');
        }elseif($this->post['action_type'] == 'Rerequest') {
            $data['type'] = "Rerequest";
            $data['action_type'] = "Modify Preventive Maintenance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/preventive_maintaince_register_view', $data, TRUE), '1600', '1000');
        }else{
            $data['action_type'] = "Add Preventive Maintenance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/preventive_maintaince_register_view', $data, TRUE), '1600', '1000');
        }

    }
    function tyre_re_request()
    {
         $data['clg_group']=$this->clg->clg_group;
        if ($this->post['mt_id'] != '') {

            $data['mt_id'] = $ref_id = $this->post['mt_id'];
            $data['mt_type'] = 'tyre';
            $data['preventive'] = $this->ambmain_model->get_ambulance_tyre_data($data);
            $data['media'] = $this->ambmain_model->get_media_maintance($data);
        }
        $args =array(
            'mt_id'=>       $this->post['mt_id'],
            'mt_type'=>      $data['mt_type']
        );
        $data['app_rej_his'] = $this->ambmain_model->get_app_rej_his($args);

        if ($this->post['action_type'] == 'Update') {

            $data['action_type'] = "Update Tyre Life";
            $data['type'] = "Update";

            $data['update'] = 'True';

            $this->output->add_to_popup($this->load->view('frontend/maintaince/tyre_maintaince_register_view', $data, TRUE), '1200', '500');
        } elseif($this->post['action_type'] == 'Approve') {
            
            $data['action_type'] = "Approve Tyre Life";
            $data['type'] = "Approve";
            $data['Approve'] = 'True';
            $this->output->add_to_popup($this->load->view('frontend/maintaince/tyre_maintaince_register_view', $data, TRUE), '1200', '500');
        }elseif($this->post['action_type'] == 'Rerequest') {
            $data['type'] = "Rerequest";
            $data['action_type'] = "Re-request Tyre Maintenance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/tyre_maintaince_register_view', $data, TRUE), '1200', '500');
        }else {
            $data['action_type'] = "Add Tyre Life";
           // $data['type'] = "Update";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/tyre_maintaince_register_view', $data, TRUE), '1200', '500');
        }
    }
    
    function accidental_re_request() {
 

        if ($this->post['mt_id'] != '') {

            $data['mt_id'] = $ref_id = $this->post['mt_id'];
            $data['mt_type'] = 'accidental';
            $data['preventive'] = $this->ambmain_model->get_ambulance_accidental_maintance_data($data);
            $data['media'] = $this->ambmain_model->get_media_maintance($data);
        }
        $args =array(
            'mt_id'=>       $this->post['mt_id'],
            'mt_type'=>      $data['mt_type']
        );
        $data['app_rej_his'] = $this->ambmain_model->get_app_rej_his($args);

        if ($this->post['action_type'] == 'Update') {

            $data['action_type'] = "Update Accidental Maintenance";
            $data['type'] = "Update";
            $data['update'] = 'True';
            $this->output->add_to_popup($this->load->view('frontend/maintaince/accidental_maintaince_register_view', $data, TRUE), '1200', '500');
        }elseif($this->post['action_type'] == 'Approve') {
            $data['type'] = "Approve";
            $data['action_type'] = "Approve Accidental Maintenance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/accidental_maintaince_register_view', $data, TRUE), '1200', '500');
        }elseif($this->post['action_type'] == 'Rerequest') {
            $data['type'] = "Rerequest";
            $data['action_type'] = "Re-request Accidental Maintenance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/accidental_maintaince_register_view', $data, TRUE), '1200', '500');
        }else{
            $data['action_type'] = "Add Accidental Maintenance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/accidental_maintaince_register_view', $data, TRUE), '1200', '500');

        }
    }
    
    function onroad_offroad_re_request()
    { 
        if ($this->post['mt_id'] != '') {

            $data['mt_id'] = $ref_id = $this->post['mt_id'];
           
            $data['mt_type'] = 'onroad_offroad';
            $data['preventive'] = $this->ambmain_model->get_ambulance_onroad_offroad_maintance_data($data);
            $data['media'] = $this->ambmain_model->get_media_maintance($data);
        }

        $args =array(
            'mt_id'=>       $this->post['mt_id'],
            'mt_type'=>      $data['mt_type']
        );
        $data['app_rej_his'] = $this->ambmain_model->get_app_rej_his($args);
        //var_dump($data['app_rej_his']);
        //die();
        if ($this->post['action_type'] == 'Update') {

            $data['action_type'] = "Update Ambulance Off-Road / Ambulance On-Road";
            $data['type'] = "Update";
            $data['update'] = 'True';

            $this->output->add_to_popup($this->load->view('frontend/maintaince/onroad_offroad_maintaince_register_view', $data, TRUE), '1200', '500');
        } elseif ($this->post['action_type'] == 'Approve') {
            $data['type'] = "Approve";
            $data['action_type'] = "Approve Ambulance Off-Road / Ambulance On-Road";

            $this->output->add_to_popup($this->load->view('frontend/maintaince/onroad_offroad_maintaince_register_view', $data, TRUE), '1200', '500');
        }elseif($this->post['action_type'] == 'Rerequest') {
            $data['type'] = "Rerequest";
            $data['action_type'] = "Re-request Accidental Maintenance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/onroad_offroad_maintaince_register_view', $data, TRUE), '1200', '500');
        }
       /* if ($this->post['mt_id'] != '') {

            $data['mt_id'] = $ref_id = base64_decode($this->post['mt_id']);
            $data['mt_type'] = 'accidental';
            $data['preventive'] = $this->ambmain_model->get_ambulance_accidental_maintance_data($data);
            $data['media'] = $this->ambmain_model->get_media_maintance($data);
        }
        $data['app_rej_his'] = $this->ambmain_model->get_app_rej_his($this->post['mt_id']);

        if ($this->post['action_type'] == 'Update') {

            $data['action_type'] = "Update Accidental Maintainance";
            $data['type'] = "Update";
            $data['update'] = 'True';
            $this->output->add_to_popup($this->load->view('frontend/maintaince/accidental_maintaince_register_view', $data, TRUE), '1000', '500');
        }elseif($this->post['action_type'] == 'Approve') {
            $data['type'] = "Approve";
            $data['action_type'] = "Approve Accidental Maintainance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/accidental_maintaince_register_view', $data, TRUE), '1000', '500');
        }elseif($this->post['action_type'] == 'Rerequest') {
            $data['type'] = "Rerequest";
            $data['action_type'] = "Re-request Accidental Maintainance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/onroad_offroad_maintaince_register_view', $data, TRUE), '1000', '500');
        }else{
            $data['action_type'] = "Add Accidental Maintainance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/accidental_maintaince_register_view', $data, TRUE), '1000', '500');

        }*/
    }

    function accidental_maintaince_registrartion() {

        $data['clg_ref_id'] = $this->clg->clg_ref_id;

        if ($this->post['mt_id'] != '') {

            $data['mt_id'] = $ref_id = base64_decode($this->post['mt_id']);
            $data['mt_type'] = 'accidental';
            $data['preventive'] = $this->ambmain_model->get_ambulance_accidental_maintance_data($data);
            $data['media'] = $this->ambmain_model->get_media_maintance($data);
            
            $args_part = array('req_maintanance_id'=>$data['mt_id'],'req_maintanance_type'=>'accidental_maintaince');
            $data['indent_data'] = $this->maintenance_part_model->get_all_maintenance_part($args_part);

            
            if($data['indent_data']){
                $args_req_part = array('req_id'=>$data['indent_data'][0]->req_id);
                $data['req_mate_part'] = $this->maintenance_part_model->get_item_maintenance_part_data($args_req_part);
            }
           
        }


        if ($this->post['action_type'] == 'Update') {

            $data['action_type'] = "Update Accidental Maintenance";
            $data['type'] = "Update";
            $data['update'] = 'True';
            $this->output->add_to_popup($this->load->view('frontend/maintaince/accidental_maintaince_register_view', $data, TRUE), '1200', '500');
        } else {
            $state_id = $this->clg->clg_state_id;
            $data['state_id'] = $state_id;
            $data['action_type'] = "Add Accidental Maintenance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/accidental_maintaince_register_view', $data, TRUE), '1200', '1200');
        }
    }

    function accidental_maintaince_save() {

        $maintaince_data = $this->post['accidental'];


        $maintaince = $this->input->post();
        
       // $prev= generate_maintaince_id('ems_accidental_id');
        
       // $prev_id = "MHEMS-AM-".$prev;
        
        if($state == 'RJ'){
             $prev= generate_maintaince_id('ems_rj_accidental_id');
            $prev_id = "RJEMS-AM-".$prev;
        }else if($state == 'MP'){
            $prev= generate_maintaince_id('ems_pm_accidental_id');
            $prev_id = "MPEMS-AM-".$prev;
        }else{
            $prev= generate_maintaince_id('ems_accidental_id');
            $prev_id = "MHEMS-AM-".$prev;
        }
        if($this->input->post('maintaince_district') == 'Backup'){
            $amb_data = $this->amb_model->get_amb_district(array('amb_id' =>$this->input->post('maintaince_ambulance')));
            $district_id = $amb_data[0]->amb_district ;
        }
        else{
            $district_id =  $this->input->post('maintaince_district');
        }
        $main_data = array('mt_state_id' => $this->input->post('maintaince_state'),
            'mt_accidental_id'=>$prev_id,
            'mt_district_id' => $district_id,
            'mt_amb_no' => $this->input->post('maintaince_ambulance'),
            'mt_in_odometer' => $this->input->post('in_odometer'),
            'mt_previos_odometer' => $this->input->post('previous_odometer'),
          //  'mt_odometer_diff' => $this->input->post('odometer_diff'),
            'mt_base_loc' => $this->input->post('base_location'),
            'mt_accidentdate' => date('Y-m-d H:i:s', strtotime($maintaince_data['mt_accidentdate'])),
            'mt_Estimatecost' => $this->input->post('Estimatecost'),
            'mt_repair_Estimatecost'=> $this->input->post('repair_Estimatecost'),
            'amb_type' => $this->input->post('amb_type'),
            'mt_make' => $this->input->post('ambt_make'),
            'mt_module' => $this->input->post('ambt_model'),
            //'mt_offroad_datetime' => date('Y-m-d H:i:s', strtotime($maintaince_data['mt_offroad_datetime'])),
            //'mt_ex_onroad_datetime' => $this->input->post('accidental[mt_ex_onroad_datetime]'),
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'),
            'mt_isdeleted' => '0',
            'mt_type' => 'accidental',
            'informed_to' => json_encode($maintaince_data['informed_to']),
            'mt_base_month' => $this->post['base_month'],
            'mt_ambulance_status' => 'Pending Approval',
            'mt_informed_group' => json_encode($this->input->post('user_group')),
            'mt_remark' =>$this->input->post('accidental[mt_app_remark]'),
            'mt_pilot_name' => $this->input->post('pilot_id'),
        );
        
        

        $args = array_merge($this->post['accidental'], $main_data);
        
        if(!empty($_FILES['amb_photo']['name'])){
            foreach ($_FILES['amb_photo']['name'] as $key => $image) {
                $media_args = array();


                $_FILES['photo']['name']= $_FILES['amb_photo']['name'][$key];
                $_FILES['photo']['type']= $_FILES['amb_photo']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['amb_photo']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['amb_photo']['error'][$key];
                $_FILES['photo']['size']= $_FILES['amb_photo']['size'][$key];

                $_FILES['photo']['name'] = time() .'_'. $this->sanitize_file_name($_FILES['photo']['name']);
               // var_dump($_FILES['amb_photo']['name']);
                //die();

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                                $msg_p =  $this->upload->display_errors();
                $this->output->message = "<div class='error'>$msg_p .. Please upload again..!</div>";
                    $upload_err = TRUE;
                    return;
                }
                $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['user_id'] = $register_result;
                $media_args['media_data'] = 'accidental';
                $media_records[$key] = $media_args;
                //$this->ambmain_model->insert_media_maintance($media_args);
                // var_dump($media_args);die;
            }
        }
        
        $register_result = $this->ambmain_model->insert_ambulance_accidental_maintance($args);
        if($media_records){
            foreach($media_records as $media_record){
                    $media_record['user_id'] = $register_result;
                    $media = $this->ambmain_model->insert_media_maintance($media_record);

            }
        }
        
        
        if($state == 'RJ'){
             $prev= generate_maintaince_id('ems_rj_onoffroad_id');
            $prev_id = "RJEMS-OM-".$prev;
        }else if($state == 'MP'){
            $prev= generate_maintaince_id('ems_pm_onoffroadl_id');
            $prev_id = "MPEMS-OM-".$prev;
        }else{
            $prev= generate_maintaince_id('ems_onoffroad_id');
            $prev_id = "MHEMS-OM-".$prev;
        }
        if($this->input->post('maintaince_district') == 'Backup'){
            $amb_data = $this->amb_model->get_amb_district(array('amb_id' =>$this->input->post('maintaince_ambulance')));
            $district_id = $amb_data[0]->amb_district ;
        }
        else{
            $district_id =  $this->input->post('maintaince_district');
        }
        
        $main_off_data = array('mt_state_id' => $this->input->post('maintaince_state'),
            'mt_onoffroad_id'=>$prev_id,
            'mt_district_id' => $district_id,
            'mt_amb_no' => $this->input->post('maintaince_ambulance'),
            'mt_in_odometer' => $this->input->post('in_odometer'),
            'mt_previos_odometer' => $this->input->post('previous_odometer'),
            'mt_odometer_diff' => $this->input->post('odometer_diff'),
            'mt_base_loc' => $this->input->post('base_location'),
            'mt_Estimatecost' => $this->input->post('Estimatecost'),
           // 'mt_offroad_datetime' => date('Y-m-d H:i:s', strtotime($maintaince_data['mt_offroad_datetime'])),
            // 'mt_ex_onroad_datetime' =>$this->input->post('ex_onroad_datetime'),
             'amb_type' => $this->input->post('amb_type'),
            'mt_make' => $this->input->post('ambt_make'),
            'mt_module' => $this->input->post('ambt_model'),
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'),
            'mt_isdeleted' => '0',
            'mt_type' => 'onroad_offroad',
            'mt_offroad_reason' => 'Accidental Maintenance',
            'mt_informed_group' => json_encode($this->input->post('user_group')),
            'mt_remark' => $maintaince_data['mt_remark'],
            'mt_base_month' => $this->post['base_month'],
            'mt_ambulance_status' => 'Pending Approval',
            'mt_pilot_id' =>  $maintaince_data['mt_pilot_id'],
            'amb_owner' =>  $maintaince_data['amb_owner'],
            'mt_pilot_name' => $this->input->post('pilot_id'),
            
        );

         
       

       // $main_off_data = array_merge($this->post['accidental'],$main_off_data);
       // $main_off_data['amb_owner'] = $main_off_data['mt_owner'];
      //  unset($main_off_data['mt_owner']);
        
       if($register_result){
            $off_register_result = $this->ambmain_model->insert_ambulance_on_off_maintance($main_off_data);
       }
       
        
        $inform_user_group = $this->input->post('user_group'); 
        //$district_id = $this->input->post('maintaince_district');
        if(!empty($inform_user_group)){

            foreach($inform_user_group as $user_group){
                if($user_group != ''){
                $args_clg = array('clg_group'=>$user_group,'clg_district_id'=>$district_id);
                $register_result = $this->colleagues_model->get_clg_data($args_clg);
                foreach($register_result as $register){

                    $sms_to = $register->clg_mobile_no;
                        $txtMsg2 = "";
                        $txtMsg2 .= "BVG\n";
                        $txtMsg2 .= "Ambulance On Maintenance\n";
                        $txtMsg2 .= "Ambulance Number: ".$this->input->post('maintaince_ambulance')."\n"; 
                        $txtMsg2 .= "MHEMS" ;

                    $super_args = array(
                        'msg' => $txtMsg2,
                        'mob_no' => $sms_to,
                        'sms_user' => 'accidental',
                    );

                    //$sms_data = sms_send($super_args);
                    
                    $from = 'fleetdeskmems@bvgmems.com';

                    $email = $register->clg_email;
                    $subject = "Ambulance On Maintenance";
                    $mail_res = $this->_send_email($email, $from,$subject, $txtMsg2);
                   
                    //var_dump($mail_res);
                    //die();
                }

            }
            }
        }
       
        
        

        if($this->input->post('pilot_id') != ''){
            $pilot_clg = array('clg_ref_id'=>$this->input->post('pilot_id'));
            $pilot_clg_result = $this->colleagues_model->get_clg_data($pilot_clg);
            foreach($pilot_clg_result as $pilot){

                    $pilot_sms_to = $pilot->clg_mobile_no;
                    $txtMsg2 = "";
                    $txtMsg2 .= "BVG\n";
                    $txtMsg2 .= "Ambulance On Maintenance\n";
                    $txtMsg2.= "Ambulance Number: ".$this->input->post('maintaince_ambulance').",\n"; 
                    $txtMsg2.= "MHEMS" ;

                $pilot_args = array(
                    'msg' => $txtMsg2,
                    'mob_no' => $pilot_sms_to,
                    'sms_user' => 'accidental',
                );

                //$pilot_sms_data = sms_send($pilot_args);
                
                $from = 'fleetdeskmems@bvgmems.com';

                $email = $pilot->clg_email;
                $subject = "Ambulance On Maintenance";
                $mail_res = $this->_send_email($email, $from,$subject, $txtMsg2);
            }
        }
       
        
        

        $total_km = (int)$this->input->post('in_odometer') - (int)$this->input->post('previous_odometer');

        $amb_record_data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'start_odmeter' => $this->input->post('previous_odometer'),
            'end_odmeter' => $this->input->post('in_odometer'),
            'total_km' => $total_km,
            'inc_ref_id'=>$register_result,
            'odometer_type'  => 'accidental maintenance',
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
           'off_road_status' => "Pending for approval",
            'off_road_remark' => $maintaince_data['mt_stnd_remark'],
            'off_road_date' => date('Y-m-d', strtotime($maintaince_data['mt_offroad_datetime'])),
            'off_road_time' => date('H:i:s', strtotime($maintaince_data['mt_offroad_datetime'])),
            'added_date' => date('Y-m-d H:i:s'));
          // var_dump($amb_update_summary);die;
        if (!empty($maintaince_data['mt_remark'])) {
            $amb_update_summary['off_road_remark_other'] = $maintaince_data['mt_remark'];
        }

       /* $data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => 7,
        );*/
        
         if($maintaince_data['mt_send_material_request'] == 'Yes'){

            $args = array(
                'req_date' => $this->today,
                'req_base_month' => $this->post['base_month'],
                'req_by' => $this->clg->clg_ref_id,
                'req_state_code' => $this->input->post('maintaince_state'),
                'req_amb_reg_no' => $this->input->post('maintaince_ambulance'),
                'req_district_code' => $this->input->post('maintaince_district'),
                'req_base_location'=>$this->input->post('base_location'),
                'current_odometer'=>$this->input->post('in_odometer'),
               // 'req_shift_type' => $ind_data['req_shift_type'],
             //   'req_expected_date_time' => date('Y-m-d H:i:s', strtotime($ind_data['req_expected_date_time'])),
                //'req_district_manager' => $ind_data['req_district_manager'],
                'req_standard_remark' => 'Maintenance Part Request send sucessfully',
                'req_maintanance_type' => 'accidental_maintaince',
                'req_maintanance_id' => $register_result,
                'req_isdeleted' => '0',
            );

         
            $item_key = array('Force_BSIII', 'Force_BSIV','Ashok_Leyland_BSIV');
            $req = $this->maintenance_part_model->insert_maintenance_part($args);

            foreach ($item_key as $key) {
                if (is_array($this->post['req'][$key])) {

                    foreach ($this->post['req'][$key] as $dt) {

                        if (!empty($dt['id'])) {

                              $ind_data = array(
                                'ind_item_id' => $dt['id'],
                                'ind_quantity' => $dt['qty'],
                                'ind_item_type' => $key,
                                'ind_req_id' => $req,
                            );


                            $result = $this->maintenance_part_model->maintenance_part_item($ind_data);
                        }
                    }
                }
            }
        }
        
//die();

        if ($register_result) {

           // $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
            $add_summary = $this->amb_model->insert_amb_staus_summary($amb_update_summary);

            //$update = $this->amb_model->update_amb($data);

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Accidental Maintenance Registered Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->accidental_maintaince();
        }
    }

     function send_test_mail() {
//        $data = $this->input->post();
//        $decoded = base64_decode($data["msg_content"]);
//        $reply_mail = 'fleetdeskmems@bvgmems.com';
//        $message .="Test Mail Thanks, <br/>";
//        $email = 'fleetdeskmems@bvgmems.com';
//        $subject = "Test Mail";
//        $mail_res = $this->send_email($reply_mail, $message, $email, $subject);
//        var_dump($mail_res);
//        die();
        
        $this->load->library('email');

        $config['protocol']    = 'smtp';
        $config['smtp_host']    = 'mulikainfotech.com';
        $config['smtp_port']    = '587';
        $config['smtp_timeout'] = '7';
        $config['smtp_user']    = 'fleetdeskmems@bvgmems.com';
        $config['smtp_pass']    = 'chaitali1991@7';
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'text'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not      

        $this->email->initialize($config);

        $this->email->from('fleetdeskmems@bvgmems.com', 'test');
        $this->email->to('chaitali.fartade17@gmail.com'); 
        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');  

        $this->email->send();

        echo $this->email->print_debugger();
        die();

    }
    function accidental_maintaince_view() {


        $data = array();


        $data['action_type'] = 'View Accidental Maintenance';

        $data['mt_id'] = $ref_id = trim($this->post['mt_id']);
        $data['mt_type'] = 'accidental';
        $data['preventive'] = $this->ambmain_model->get_ambulance_accidental_maintance_data($data);
        $data['media'] = $this->ambmain_model->get_media_maintance($data);
        
        $args_part = array('req_maintanance_id'=>$data['mt_id'],'req_maintanance_type'=>'accidental_maintaince');
        $data['indent_data'] = $this->maintenance_part_model->get_all_maintenance_part($args_part);


        if($data['indent_data']){
            $args_req_part = array('req_id'=>$data['indent_data'][0]->req_id);
            $data['req_mate_part'] = $this->maintenance_part_model->get_item_maintenance_part_data($args_req_part);
        }

        $args =array(
            'mt_id'=> $data['mt_id'],
            'mt_type'=>  $data['mt_type']
        );
        $data['app_rej_his'] = $this->ambmain_model->get_app_rej_his($args);
       // var_dump($data['app_rej_his']);die();
        //approve page - Re-request history
        $args =array(
            'mt_id'=>       $this->post['mt_id'],
            'mt_type'=>      $data['mt_type']
        );
        $args_media =array(
            're_mt_id'=>       $this->post['mt_id'],
            'mt_type'=>      $data['mt_type']
        );
       
        $re_request_id = $this->ambmain_model->get_photo_history($args);
        $data['media'] = $this->ambmain_model->get_media_maintance($args_media);
        
        $job_data = array('mt_id'=>$ref_id,'mt_type'=>'job_card_accidental');
        $data['job_media'] = $this->ambmain_model->get_media_maintance($job_data);
        
        
        $other_data = array('mt_id'=>$ref_id,'mt_type'=>'invoice_accidental');
        $data['invoice_media'] = $this->ambmain_model->get_media_maintance($other_data);
        
        $arr =array(
            'mt_id'=>       $this->post['mt_id'],
            'mt_type'=>      $data['mt_type'],
            're_request_id'=> $this->post['re_request_id']
        );
        $his = $this->ambmain_model->get_history($arr);
        foreach($his as $history){ //var_dump($his);die;
        $args_his = array('mt_id' => $this->post['mt_id'], 're_request_id' => $history->re_request_id);
        $history_images = $this->ambmain_model->get_history_photo($args_his);
        $history->his_photo = $history_images;
        $data['his'][] = $history;
        }

        $this->output->add_to_popup($this->load->view('frontend/maintaince/accidental_maintaince_view', $data, TRUE), '1200', '500');
    }

    function update_accidental_maintaince() {

        $maintaince_data = $this->post['accidental'];
        
        $app_data = $this->input->post('app');
        $maintaince_data['mt_id'] = $app_data['mt_id'];
        //var_dump($this->input->post('previos_odometer') );die;
       
        $main_data = array(
            'mt_id' => $app_data['mt_id'],
            'mt_end_odometer' => $this->input->post('mt_end_odometer'),
            'mt_onroad_datetime' => date('Y-m-d H:i:s', strtotime($maintaince_data['mt_onroad_datetime'])),
            'mt_isupdated' => '1',
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'),
            'mt_ambulance_status' => 'Available',
            'mt_amb_no' => $this->input->post('maintaince_ambulance'),
            'bill_number' => $this->input->post('mt_bill_number'),
            'part_cost' => $this->input->post('mt_part_cost'),
            'labour_cost' => $this->input->post('mt_labour_cost'),
            'total_cost' => $this->input->post('mt_total_cost'),

        );
         //var_dump($main_data);die;
        $args = array_merge($this->post['accidental'], $main_data);
        

        $register_result = $this->ambmain_model->update_ambulance_accidental_maintance($args);
        //var_dump($main_data);die;
        
         if(!empty($_FILES['amb_job_card']['name'])){
            foreach ($_FILES['amb_job_card']['name'] as $key => $image) {
                $media_args = array();


                $_FILES['photo']['name']= $_FILES['amb_job_card']['name'][$key];
                $_FILES['photo']['type']= $_FILES['amb_job_card']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['amb_job_card']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['amb_job_card']['error'][$key];
                $_FILES['photo']['size']= $_FILES['amb_job_card']['size'][$key];

                $_FILES['photo']['name'] = time() .'_'. $this->sanitize_file_name($_FILES['photo']['name']);
               // var_dump($_FILES['amb_photo']['name']);
                //die();

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                    $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                    $upload_err = TRUE;
                }
                $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['user_id'] = $maintaince_data['mt_id'];
                $media_args['media_data'] = 'job_card_accidental';
                $this->ambmain_model->insert_media_maintance($media_args);
                // var_dump($media_args);die;
            }
        }
        
        if(!empty($_FILES['amb_invoice']['name'])){
            foreach ($_FILES['amb_invoice']['name'] as $key => $image) {
                $media_args = array();


                $_FILES['amb_invoice']['name']= $_FILES['amb_invoice']['name'][$key];
                $_FILES['amb_invoice']['type']= $_FILES['amb_invoice']['type'][$key];
                $_FILES['amb_invoice']['tmp_name']= $_FILES['amb_invoice']['tmp_name'][$key];
                $_FILES['amb_invoice']['error']= $_FILES['amb_invoice']['error'][$key];
                $_FILES['amb_invoice']['size']= $_FILES['amb_invoice']['size'][$key];

                $_FILES['amb_invoice']['name'] = time() .'_'.$this->sanitize_file_name($_FILES['amb_invoice']['name']);
               // var_dump($_FILES['amb_photo']['name']);
                //die();

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                    $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                    $upload_err = TRUE;
                }
                $media_args['media_name'] = $_FILES['amb_invoice']['name'];
                $media_args['user_id'] = $maintaince_data['mt_id'];
                $media_args['media_data'] = 'invoice_accidental';
                $this->ambmain_model->insert_media_maintance($media_args);
                // var_dump($media_args);die;
            }
        }


        $total_km = $this->input->post('mt_end_odometer') - $this->input->post('previous_odometer');

        $amb_record_data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'start_odmeter' => $this->input->post('previous_odometer'),
            'end_odmeter' => $this->input->post('mt_end_odometer'),
            'total_km' => $total_km,
            'inc_ref_id'=>$maintaince_data['mt_id'],
            'odometer_type'       => 'update accidental maintaince',
            'timestamp' => date('Y-m-d H:i:s'));
   // var_dump($amb_record_data);die;
        if (!empty($maintaince_data['mt_off_remark'])) {
            $amb_record_data['other_remark'] = $maintaince_data['mt_off_remark'];
        }

        $amb_update_summary = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => '7,1',
            'end_odometer' => $this->input->post('mt_end_odometer'),
            'on_road_status' => "Ambulance Accidental maintenance on road",
            'on_road_remark' => $maintaince_data['mt_on_stnd_remark'],
            'on_road_date' => date('Y-m-d', strtotime($maintaince_data['mt_onroad_datetime'])),
            'on_road_time' => date('H:i:s', strtotime($maintaince_data['mt_onroad_datetime'])),
            'added_date' => date('Y-m-d H:i:s'));

        if (!empty($maintaince_data['mt_on_remark'])) {
            $amb_update_summary['on_road_remark_other'] = $maintaince_data['mt_on_remark'];
        }

        $data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => 1,
        );
        $off_road_status = "Ambulance Accidental maintenance off road";
        $add_summary = $this->amb_model->update_ambulance_staus_summary($amb_update_summary, $off_road_status);
        $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
      
        //$update = $this->amb_model->update_amb($data);

        if ($register_result) {

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Accidental Maintenance Registered Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->accidental_maintaince();
        }
    }
    function remove_images(){
        $id = $this->post['id'];
        
        $args = array('id'=>$id);
        
        $register_result = $this->ambmain_model->get_media_maintance($args);
        $dis_file_name= $register_result[0]->media_name;
        
        $filepath = $pic_path = FCPATH . "uploads/ambulance/".$dis_file_name;
        $file = fopen($filepath, "w");
        fwrite($file, $datas);
        fclose($file);
        header("Content-Disposition: attachment; filename=DayPrintList" . date("Y-m-d") . ".csv");
        header("Content-Type: application/vnd.ms-excel");
        readfile($filepath);
        unlink($filepath);
//        exit();
        $register_result = $this->ambmain_model->delete_media($id);
        $this->output->add_to_position('', $this->post['output_position'], TRUE);
//        var_dump($register_result);
//        die();
    }

    function approve_onroad_offroad_maintaince() {
        if ($this->post['mt_id'] != '') {

            $data['mt_id'] = $ref_id = $this->post['mt_id'];
            $data['mt_type'] = 'onroad_offroad';
            $data['preventive'] = $this->ambmain_model->get_ambulance_onroad_offroad_maintance_data($data);
            $data['media'] = $this->ambmain_model->get_media_maintance($data);
        
       $args =array(
            'mt_id'=>       $this->post['mt_id'],
            'mt_type'=>      $data['mt_type']
        );
        $re_request_id = $this->ambmain_model->get_photo_history($args);
        //$data['media'] = $this->ambmain_model->get_media_maintance($data);
        $arr =array(
            'mt_id'=>       $this->post['mt_id'],
            'mt_type'=>      $data['mt_type'],
            're_request_id'=> $this->post['re_request_id']
        );
        $his = $this->ambmain_model->get_history($arr);
        foreach($his as $history){ //var_dump($history);
            $args_his = array('mt_id' => $this->post['mt_id'], 're_request_id' => $history->re_request_id);
            $history_images = $this->ambmain_model->get_history_photo($args_his);
            $history->his_photo = $history_images;
            $data['his'][] = $history;
        }
        }
        
         if ($this->post['action_type'] == 'Update') {

            $data['action_type'] = "Update Ambulance Off-Road / Ambulance On-Road";
            $data['type'] = "Update";
            $data['update'] = 'True';

            $this->output->add_to_popup($this->load->view('frontend/maintaince/onroad_offroad_maintaince_register_view', $data, TRUE), '1200', '500');
        } elseif ($this->post['action_type'] == 'Approve') {
            $data['type'] = "Approve";
            $data['action_type'] = "Approve Ambulance Off-Road / Ambulance On-Road";
             $data['update'] = 'True';

            $this->output->add_to_popup($this->load->view('frontend/maintaince/onroad_offroad_maintaince_register_view', $data, TRUE), '1200', '500');
        }elseif($this->post['action_type'] == 'Rerequest') {
            $data['type'] = "Rerequest";
            $data['action_type'] = "Re-request Accidental Maintenance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/onroad_offroad_maintaince_register_view', $data, TRUE), '1200', '500');
        }
       
    }

    function update_approval_onroad_offroad_maintaince() {
        $app_data = $this->input->post('app');
        
        $Approved_by = $this->clg->clg_ref_id;
        $approved_date = date('Y-m-d H:i:s');
        $onroad = date('Y-m-d H:i:s', strtotime($app_data['mt_app_onroad_datetime']));

        if($app_data['mt_approval']=="1")
        {
            $approval = 'Approved';
        }else if($app_data['mt_approval'] == "2"){
            $approval = 'Approval Rejected';
        }
        $app_data = array(
            'mt_id' => $app_data['mt_id'],
            'mt_approval' => $app_data['mt_approval'],
            'mt_app_onroad_datetime' => $onroad,
            'mt_offroad_datetime' => $approved_date,
            'mt_app_remark' => $app_data['mt_app_remark'],
            'mt_app_amb_off_status' => $app_data['mt_app_amb_off_status'],
            'mt_ambulance_status' => $approval,
            'approved_by' => $Approved_by,
            'modify_by' => $this->clg->clg_ref_id,
            
            'modify_date' => date('Y-m-d H:i:s'),
            'approved_date' => $approved_date
        );
        //$app_data['mt_pilot_name'] = $this->input->post('pilot_id');
        //$app_data['mt_Estimatecost'] = $this->input->post('mt_Estimatecost');
        
        $register_result = $this->ambmain_model->update_ambulance_on_off_maintance($app_data);
         $history_data = array(
            're_id' => $app_data['re_id'],
            're_mt_id' => $app_data['mt_id'],
            're_approval_status' => $app_data['mt_approval'],
            're_mt_type' => 'onroad_offroad',
            're_app_onroad_datetime' => date('Y-m-d H:i:s', strtotime($app_data['mt_app_onroad_datetime'])),
            're_remark' => $app_data['mt_app_remark'],
            're_rejected_by' => $this->clg->clg_ref_id,
            're_rejected_date' => date('Y-m-d H:i:s')
        );
        $history_data_detail = $this->ambmain_model->insert_accidental_maintaince_history($history_data);
        if($app_data['mt_approval']=="1"){
            $data = array(
                'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
                'amb_status' => '7',
            );
            $update = $this->amb_model->update_amb($data);

            $total_km = $this->input->post('mt_end_odometer') - $this->input->post('previous_odometer');

            $amb_record_data = array(
                'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
                'start_odmeter' => $this->input->post('previous_odometer'),
                'end_odmeter' => $this->input->post('mt_end_odometer'),
                'total_km' => $total_km,
                'inc_ref_id'=>$maintaince_data['mt_id'],
                'timestamp' => date('Y-m-d H:i:s'));

            if (!empty($maintaince_data['mt_off_remark'])) {
                $amb_record_data['other_remark'] = $maintaince_data['mt_off_remark'];
            }

            $amb_update_summary = array(
                'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
                'amb_status' => '7',
                //'end_odometer' => $this->input->post('mt_end_odometer'),
                'off_road_status' => "Ambulance onroad_offroad maintenance off road",
                'on_road_remark' => $maintaince_data['mt_on_stnd_remark'],
                'off_road_date' => date('Y-m-d'),
                'off_road_time' => date('H:i:s'),
                'added_date' => date('Y-m-d H:i:s'));

            if (!empty($maintaince_data['mt_on_remark'])) {
                $amb_update_summary['on_road_remark_other'] = $maintaince_data['mt_on_remark'];
            }

            $data = array(
                'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
                'amb_status' => 7,
            );

            $off_road_status = "Pending for Approval";
            $add_summary = $this->amb_model->update_ambulance_staus_summary($amb_update_summary, $off_road_status);
           // $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
           if($app_data['mt_app_amb_off_status']=='Yes'){
               $pilot_login_status = $this->amb_model->get_amb_login_status(array('amb_rto_register_no'=>$this->input->post('maintaince_ambulance'),'type'=>'P','status'=>'1'));
               
                if(!empty($pilot_login_status)){
                    $pilot_status = array('status'=>'2','logout_time'=>date('Y-m-d H:i:s'));
                    $update = $this->amb_model->update_amb_login_status($pilot_login_status[0]->id,$pilot_status);             
                    
                }
               
              
               
                $driver_login_status = $this->amb_model->get_amb_login_status(array('amb_rto_register_no'=>$this->input->post('maintaince_ambulance'),'type'=>'D','status'=>'1'));
           
                if(!empty($driver_login_status)){
                    $driver_status = array('status'=>'2','logout_time'=>date('Y-m-d H:i:s'));
                    $update = $this->amb_model->update_amb_login_status($driver_login_status[0]->id,$driver_status);             
                }
               

            $update = $this->amb_model->update_amb($data); 
            
           }
        }
        
        if(!empty($_FILES['amb_photo']['name'])){
            
            foreach ($_FILES['amb_photo']['name'] as $key => $image) {
                $media_args = array();


                $_FILES['photo']['name']= $_FILES['amb_photo']['name'][$key];
                $_FILES['photo']['type']= $_FILES['amb_photo']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['amb_photo']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['amb_photo']['error'][$key];
                $_FILES['photo']['size']= $_FILES['amb_photo']['size'][$key];

                $_FILES['photo']['name'] = time() .'_'. $this->sanitize_file_name($_FILES['photo']['name']);
               // var_dump($_FILES['amb_photo']['name']);
                //die();

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                    $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                    $upload_err = TRUE;
                }
                $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['user_id'] = $app_data['mt_id'];
                $media_args['media_data'] = 'onroad_offroad';
                $this->ambmain_model->insert_media_maintance($media_args);
                // var_dump($media_args);die;
            }
        }
        if ($register_result) {

            $this->output->status = 1;
            $this->output->message = "<div class='success'>Approval Registered Successfully!</div>";
            $this->output->closepopup = 'yes';
            $this->onraod_offroad_maintaince();
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

        $amb_record_data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'start_odmeter' => $this->input->post('previous_odometer'),
             'inc_ref_id'=>$maintaince_data['mt_id'],
            //'end_odmeter' => $this->input->post('mt_end_odometer'),
            //'total_km' => $total_km,
            'timestamp' => date('Y-m-d H:i:s'));
          //var_dump($amb_record_data);die;
        if (!empty($maintaince_data['mt_off_remark'])) {
            $amb_record_data['other_remark'] = $maintaince_data['mt_off_remark'];
        }
       
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
    if(!empty($_FILES['amb_photo']['name'])){
            foreach ($_FILES['amb_photo']['name'] as $key => $image) {
                $media_args = array();


                $_FILES['photo']['name']= $_FILES['amb_photo']['name'][$key];
                $_FILES['photo']['type']= $_FILES['amb_photo']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['amb_photo']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['amb_photo']['error'][$key];
                $_FILES['photo']['size']= $_FILES['amb_photo']['size'][$key];

                $_FILES['photo']['name'] = time() .'_'. $this->sanitize_file_name($_FILES['photo']['name']);
               // var_dump($_FILES['amb_photo']['name']);
                //die();

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                    $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                    $upload_err = TRUE;
                }
                $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['user_id'] = $app_data['mt_id'];
                $media_args['media_data'] = 'accidental';
                $this->ambmain_model->insert_media_maintance($media_args);
                // var_dump($media_args);die;
            }
        }
        if ($register_result) {

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Accidental Maintenance Registered Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->accidental_maintaince();
        }
    }

    function update_re_request_onroad_offroad_maintaince()
    {
         $app_data = $this->input->post('app');
        $main_data = array(
            'mt_id' => $app_data['mt_id'],
           // 'mt_state_id' => $this->input->post('maintaince_state'),
           
            //'mt_district_id' => $district_id,
           // 'mt_amb_no' => $this->input->post('maintaince_ambulance'),
            'mt_in_odometer' => $this->input->post('in_odometer'),
            'mt_previos_odometer' => $this->input->post('previous_odometer'),
            'mt_odometer_diff' => $this->input->post('in_odometer')-$this->input->post('previous_odometer'),
            'mt_base_loc' => $this->input->post('base_location'),
            'mt_Estimatecost' => $this->input->post('Estimatecost'),
             'amb_type' => $this->input->post('amb_type'),
            'mt_make' => $this->input->post('ambt_make'),
            'mt_module' => $this->input->post('ambt_model'),
           
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'),
            'mt_isdeleted' => '0',
            'mt_type' => 'onroad_offroad',
            'mt_stnd_remark' => $maintaince_data['mt_stnd_remark'],
            'mt_informed_group' => json_encode($this->input->post('user_group')),
            'mt_remark' => $maintaince_data['mt_remark'],
            'mt_base_month' => $this->post['base_month'],
            'mt_ambulance_status' => 'Pending Approval',
            'mt_pilot_name' => $this->input->post('pilot_id'),
            
        );

        $main_data = array_merge($this->post['maintaince'],$main_data);
        
        if(!empty($_FILES['amb_photo']['name'])){
            
            foreach ($_FILES['amb_photo']['name'] as $key => $image) {
                $media_args = array();
                $_FILES['photo']['name']= $_FILES['amb_photo']['name'][$key];
                $_FILES['photo']['type']= $_FILES['amb_photo']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['amb_photo']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['amb_photo']['error'][$key];
                $_FILES['photo']['size']= $_FILES['amb_photo']['size'][$key];
                $_FILES['photo']['name'] = time() .'_'. $this->sanitize_file_name($_FILES['photo']['name']);
               //var_dump($_FILES['amb_photo']['name']);
                //die();

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                        $msg_p =  $this->upload->display_errors();
                        $this->output->message = "<div class='error'>$msg_p .. Please upload again..!</div>";
                         return;
                }
             
                $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['user_id'] = $app_data['mt_id'];
                $media_args['media_data'] = 're_request_onroad_offroad';
                $media_records[$key] = $media_args;
                //$this->ambmain_model->insert_media_maintance($media_args);

            }
        }

        $update_register_result = $this->ambmain_model->update_ambulance_on_off_maintance($main_data);
        
                //var_dump($app_data);die;
         $app_data = array(
            //'re_request_id' = > $app_data['re_request_id'],
            'mt_id' => $app_data['mt_id'],
            're_request_remark' => $app_data['re_request_remark'],
            're_mt_type' => 'onroad_offroad',
             're_requestby' => $this->clg->clg_ref_id,
            're_request_date' => date('Y-m-d H:i:s')
        );
         
         
        $register_result = $this->ambmain_model->re_request_ambulance_accidental_maintance($app_data);
        
        if($media_records){
        foreach($media_records as $media_record){
                //$media_record['user_id'] = $register_result;
                $media_args['re_request_id'] =$register_result;
                $media = $this->ambmain_model->insert_media_maintance($media_record);
               
        }
        }
       
        if ($register_result) {
            $this->output->status = 1;
            $this->output->message = "<div class='success'>Onroad Offroad Maintenance Re-request Registered Successfully!</div>";
            $this->output->closepopup = 'yes';
            $this->onraod_offroad_maintaince();
        }
    }
    function update_re_request_preventive_maintaince()
    {
        $app_data = $this->input->post('re_request');
        $app_data['mt_id']= $this->input->post('mt_id');
       
        
         $app_data = array(
            //'re_request_id' = > $app_data['re_request_id'],
            'mt_id' => $app_data['mt_id'],
            're_request_remark' => $app_data['re_request_remark'],
            're_mt_type' => 'preventive',
            're_requestby' => $this->clg->clg_ref_id,
            're_request_date' => date('Y-m-d H:i:s')
        );
        $register_result = $this->ambmain_model->re_request_ambulance_accidental_maintance($app_data);
        //$register_result = $this->ambmain_model->update_ambulance_maintance($app_data);
       
        if(!empty($_FILES['amb_photo']['name'])){
            
            foreach ($_FILES['amb_photo']['name'] as $key => $image) {
                $media_args = array();
                $_FILES['photo']['name']= $_FILES['amb_photo']['name'][$key];
                $_FILES['photo']['type']= $_FILES['amb_photo']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['amb_photo']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['amb_photo']['error'][$key];
                $_FILES['photo']['size']= $_FILES['amb_photo']['size'][$key];
                $_FILES['photo']['name'] = time() .'_'. $this->sanitize_file_name($_FILES['photo']['name']);
               //var_dump($_FILES['amb_photo']['name']);
                //die();

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                            $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                            $upload_err = TRUE;
                }
               $media_args['re_request_id'] =$register_result;
                $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['user_id'] = $app_data['mt_id'];
                $media_args['media_data'] = 're_request preventive';
                $this->ambmain_model->insert_media_maintance($media_args);

            }
        }
        if ($register_result) {
            $this->output->status = 1;
            $this->output->message = "<div class='success'>Preventive Maintenance Re-request Registered Successfully!</div>";
            $this->output->closepopup = 'yes';
            $this->preventive_maintaince();
        }
    }
    function update_re_request_tyre_maintaince(){
        $app_data = $this->input->post('app');
        //var_dump($app_data);die;
         $app_data = array(
            //'re_request_id' = > $app_data['re_request_id'],
            'mt_id' => $app_data['mt_id'],
            're_request_remark' => $app_data['re_request_remark'],
            're_mt_type' => 'Tyre',
             're_requestby' => $this->clg->clg_ref_id,
            're_request_date' => date('Y-m-d H:i:s')
        );
        $register_result = $this->ambmain_model->re_request_ambulance_accidental_maintance($app_data);
        if(!empty($_FILES['amb_photo']['name'])){
            
            foreach ($_FILES['amb_photo']['name'] as $key => $image) {
                $media_args = array();
                $_FILES['photo']['name']= $_FILES['amb_photo']['name'][$key];
                $_FILES['photo']['type']= $_FILES['amb_photo']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['amb_photo']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['amb_photo']['error'][$key];
                $_FILES['photo']['size']= $_FILES['amb_photo']['size'][$key];
                $_FILES['photo']['name'] = time() .'_'. $this->sanitize_file_name($_FILES['photo']['name']);
               //var_dump($_FILES['amb_photo']['name']);
                //die();

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                   $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                    $upload_err = TRUE;
                }
               $media_args['re_request_id'] =$register_result;
                $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['user_id'] = $app_data['mt_id'];
                $media_args['media_data'] = 'tyre';
                $this->ambmain_model->insert_media_maintance($media_args);

            }
        }
        if ($register_result) {
            $this->output->status = 1;
            $this->output->message = "<div class='success'>Tyre Maintenance Re-request Registered Successfully!</div>";
            $this->output->closepopup = 'yes';
            $this->tyre_maintaince();
        }
    }
    function update_re_request_accidental_maintaince() {
       
        $app_data = $this->input->post('app');
       
     
        
        if(!empty($_FILES['amb_photo']['name'])){
            
            foreach ($_FILES['amb_photo']['name'] as $key => $image) {
                $media_args = array();
                $_FILES['photo']['name']= $_FILES['amb_photo']['name'][$key];
                $_FILES['photo']['type']= $_FILES['amb_photo']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['amb_photo']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['amb_photo']['error'][$key];
                $_FILES['photo']['size']= $_FILES['amb_photo']['size'][$key];
                $_FILES['photo']['name'] = time() .'_'. $this->sanitize_file_name($_FILES['photo']['name']);
               //var_dump($_FILES['amb_photo']['name']);
                //die();
                
               $upload_path = FCPATH . $this->upload_path . "\ambulance";
                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);
                if (!$this->upload->do_upload('photo')) {
                     $msg =  $this->upload->display_errors();
                     $this->output->message = "<div class='error'>".$msg." .. Please upload again..!</div>";
                     $upload_err = TRUE;
                     return;
                }
                $media_args['re_request_id'] =$register_result;
                $media_args['media_name'] = $_FILES['photo']['name'];
               // $media_args['user_id'] = $app_data['mt_id'];
                $media_args['media_data'] = 'accidental';
                $media_records[$key] = $media_args;
              // $upload_images = $this->ambmain_model->insert_media_maintance($media_args);
         // var_dump($upload_images);
        //die;

            }
        }
        
            $app_data = array(
            //'re_request_id' = > $app_data['re_request_id'],
            'mt_id' => $app_data['mt_id'],
            're_request_remark' => $app_data['re_request_remark'],
            're_mt_type' => 'accidental',
             're_requestby' => $this->clg->clg_ref_id,
            're_request_date' => date('Y-m-d H:i:s')
        );
        $register_result = $this->ambmain_model->re_request_ambulance_accidental_maintance($app_data);
        
        if($media_records){
         foreach($media_records as $media_record){
                $media_record['user_id'] = $app_data['mt_id'];
                $media_record['re_request_id'] =$register_result;
                $media = $this->ambmain_model->insert_media_maintance($media_record);
               
            }
        }
            
        if ($register_result) {
            $this->output->status = 1;
            $this->output->message = "<div class='success'>Accidental Maintenance Re-request Registered Successfully!</div>";
            $this->output->closepopup = 'yes';
            $this->accidental_maintaince();
        }
    }
    function onraod_offroad_maintaince() {


        ///////////////  Filters //////////////////

        $data['search'] = ($this->post['search']) ? $this->post['search'] : $this->fdata['search'];
        $data['search_status'] = ($this->post['search_status']) ? $this->post['search_status'] : $this->fdata['search_status'];
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }

        if ($this->post['from_date'] != '') {
            $data['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date']));
        }

        if ($this->post['to_date'] != '') {
            $data['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->post['to_date']));
        }

        ///////////limit & offset////////

        $data['get_count'] = TRUE;
        $data['mt_type'] = 'onroad_offroad';
        
        $district_id = "";
        if($this->clg->clg_group ==  'UG-DM' || $this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER' ||  $this->clg->clg_group  == 'UG-FLEETDESK' ||  $this->clg->clg_group  == 'UG-OP-HEAD'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
            $data['amb_district'] = $district_id;
            
        }
        $data['thirdparty'] = $this->clg->thirdparty;
        $data['total_count'] = $this->ambmain_model->get_ambulance_onroad_offroad_maintance_data($data);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        unset($data['get_count']);

        $data['maintance_data'] = $this->ambmain_model->get_ambulance_onroad_offroad_maintance_data($data, $offset, $limit);
        //var_dump($data['maintance_data']);die();
        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("ambulance_maintaince/onraod_offroad_maintaince"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        $data['pgconf'] = $pgconf;
        $data['pagination'] = get_pagination($pgconf);

        /////////////////////////////////

        $data['page_records'] = $data['total_count'];


        $this->output->add_to_position($this->load->view('frontend/maintaince/onroad_offroad_maintaince_list_view', $data, true), $this->post['output_position'], true);
    }

    function onroad_offroad_maintaince_registrartion() {

        $data['clg_ref_id'] = $this->clg->clg_ref_id;
        if ($this->post['mt_id'] != '') {

            $data['mt_id'] = $ref_id = base64_decode($this->post['mt_id']);
            $data['mt_type'] = 'onroad_offroad';
            $data['preventive'] = $this->ambmain_model->get_ambulance_onroad_offroad_maintance_data($data);
            $data['media'] = $this->ambmain_model->get_media_maintance($data);
        }
        $data['shift_info'] = $this->common_model->get_shift($args);

        if ($this->post['action_type'] == 'Update') {

            $data['action_type'] = "Update Ambulance Off-Road / Ambulance On-Road";
            $data['type'] = "Update";
            $data['update'] = 'True';

            $this->output->add_to_popup($this->load->view('frontend/maintaince/onroad_offroad_maintaince_register_view', $data, TRUE), '1200', '500');
        }elseif ($this->post['action_type'] == 'Rerequest') {

            $data['action_type'] = "Rerequest Ambulance Off-Road / Ambulance On-Road";
            $data['type'] = "Rerequest";
            $data['Rerequest'] = 'True';

            $this->output->add_to_popup($this->load->view('frontend/maintaince/onroad_offroad_maintaince_register_view', $data, TRUE), '1200', '500');
        }else{
            
            $data['action_type'] = "Add Ambulance Off-Road / Ambulance On-Road";
            $state_id = $this->clg->clg_state_id;
            $data['state_id'] = $state_id;
            $this->output->add_to_popup($this->load->view('frontend/maintaince/onroad_offroad_maintaince_register_view', $data, TRUE), '1200', '500');
        }
    }

    function onroad_offroad_maintaince_save() {

        $maintaince_data = $this->post['maintaince'];
        

        $maintaince = $this->input->post();
        //$prev= generate_maintaince_id('ems_onoffroad_id');
        //$prev_id = "MHEMS-OM-".$prev;
        
        if($state == 'RJ'){
             $prev= generate_maintaince_id('ems_rj_onoffroad_id');
            $prev_id = "RJEMS-OM-".$prev;
        }else if($state == 'MP'){
            $prev= generate_maintaince_id('ems_pm_onoffroadl_id');
            $prev_id = "MPEMS-OM-".$prev;
        }else{
            $prev= generate_maintaince_id('ems_onoffroad_id');
            $prev_id = "MHEMS-OM-".$prev;
        }
        if($this->input->post('maintaince_district') == 'Backup'){
            $amb_data = $this->amb_model->get_amb_district(array('amb_id' =>$this->input->post('maintaince_ambulance')));
            $district_id = $amb_data[0]->amb_district ;
        }
        else{
            $district_id =  $this->input->post('maintaince_district');
        }
        $main_data = array('mt_state_id' => $this->input->post('maintaince_state'),
            'mt_onoffroad_id'=>$prev_id,
            'mt_district_id' => $district_id,
            'mt_amb_no' => $this->input->post('maintaince_ambulance'),
            'mt_in_odometer' => $this->input->post('in_odometer'),
            'mt_previos_odometer' => $this->input->post('previous_odometer'),
            'mt_odometer_diff' => $this->input->post('odometer_diff'),
            'mt_base_loc' => $this->input->post('base_location'),
            'mt_Estimatecost' => $this->input->post('Estimatecost'),
           // 'mt_offroad_datetime' => date('Y-m-d H:i:s', strtotime($maintaince_data['mt_offroad_datetime'])),
            // 'mt_ex_onroad_datetime' =>$this->input->post('ex_onroad_datetime'),
             'amb_type' => $this->input->post('amb_type'),
            'mt_make' => $this->input->post('ambt_make'),
            'mt_module' => $this->input->post('ambt_model'),
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'),
            'mt_isdeleted' => '0',
            'mt_type' => 'onroad_offroad',
            'mt_stnd_remark' => $maintaince_data['mt_stnd_remark'],
            'mt_informed_group' => json_encode($this->input->post('user_group')),
            'mt_remark' => $maintaince_data['mt_remark'],
            'mt_base_month' => $this->post['base_month'],
            'mt_ambulance_status' => 'Pending Approval',
            'mt_pilot_name' => $this->input->post('pilot_id'),
            
        );

        $main_data = array_merge($this->post['maintaince'],$main_data);
                if(!empty($_FILES['amb_photo']['name'])){
            foreach ($_FILES['amb_photo']['name'] as $key => $image) {
            $media_args = array();
            
            $_FILES['photo']['name']= $_FILES['amb_photo']['name'][$key];
            $_FILES['photo']['type']= $_FILES['amb_photo']['type'][$key];
            $_FILES['photo']['tmp_name']= $_FILES['amb_photo']['tmp_name'][$key];
            $_FILES['photo']['error']= $_FILES['amb_photo']['error'][$key];
            $_FILES['photo']['size']= $_FILES['amb_photo']['size'][$key];

            $_FILES['photo']['name'] = time() .'_'. $this->sanitize_file_name($_FILES['photo']['name']);
           // var_dump($_FILES['amb_photo']['name']);
            //die();

            $rsm_config = $this->amb_pic;
            $this->upload->initialize($rsm_config);

            if (!$this->upload->do_upload('photo')) {
                    $msg_p =  $this->upload->display_errors();
                    $this->output->message = "<div class='error'>$msg_p .. Please upload again..!</div>";
                    $upload_err = TRUE;
                    return;
            }
            $media_args['media_name'] = $_FILES['photo']['name'];
            $media_args['user_id'] = $register_result;
            $media_args['media_data'] = 'onroad_offroad';
            //$this->ambmain_model->insert_media_maintance($media_args);
             $media_records[$key] = $media_args;
            
        }
        }

        
        $register_result = $this->ambmain_model->insert_ambulance_on_off_maintance($main_data);
        
        if($media_records){
        foreach($media_records as $media_record){
                $media_record['user_id'] = $register_result;
                $media = $this->ambmain_model->insert_media_maintance($media_record);
               
        }
        }
        
        $inform_user_group = $this->input->post('user_group'); 
       // $district_id = $this->input->post('maintaince_district');
         if(!empty($inform_user_group)){
        foreach($inform_user_group as $user_group){
            if($user_group != ''){
            $args_clg = array('clg_group'=>$user_group,'clg_district_id'=>$district_id);
            $register_result_a = $this->colleagues_model->get_clg_data($args_clg);
            foreach($register_result_a as $register){
                
                $sms_to = $register->clg_mobile_no;
                    $txtMsg2 = "";
                    $txtMsg2.= "BVG\n";
                    $txtMsg2 .= "Ambulance On Maintenance\n";
                    $txtMsg2.= "Ambulance Number: ".$this->input->post('maintaince_ambulance')."\n"; 
                    $txtMsg2.= "MHEMS" ;

                $super_args = array(
                    'msg' => $txtMsg2,
                    'mob_no' => $sms_to,
                    'sms_user' => 'onroad offroad',
                );
              
                //$sms_data = sms_send($super_args);
                
                $from = 'fleetdeskmems@bvgmems.com';

                $email = $register->clg_email;
                $subject = "Ambulance On Maintenance";
                $mail_res = $this->_send_email($email, $from,$subject, $txtMsg2);
            }
        }
        }
         }
        
        if($this->input->post('pilot_id') != ''){
        $pilot_clg = array('clg_ref_id'=>$this->input->post('pilot_id'));
        $pilot_clg_result = $this->colleagues_model->get_clg_data($pilot_clg);
        foreach($pilot_clg_result as $pilot){

                $pilot_sms_to = $pilot->clg_mobile_no;
                $txtMsg2 = "";
                $txtMsg2.= "BVG\n";
                $txtMsg2 .= "Ambulance On Maintenance\n";
                $txtMsg2.= "Ambulance Number: ".$this->input->post('maintaince_ambulance')."\n"; 
                $txtMsg2.= "MHEMS" ;

            $pilot_args = array(
                'msg' => $txtMsg2,
                'mob_no' => $pilot_sms_to,
                'sms_user' => 'onroad-offroad pilot',
            );

            //$pilot_sms_data = sms_send($pilot_args);
            
            $from = 'fleetdeskmems@bvgmems.com';

                    $email = $pilot->clg_email;
                    $subject = "Ambulance On Maintenance";
                    $mail_res = $this->_send_email($email, $from,$subject, $txtMsg2);
        }
        }
        

        
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

        
        $amb_update_summary = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => 1,
            'start_odometer' => $this->input->post('previous_odometer'),
            'off_road_status' => "Pending for approval",
            'off_road_remark' => $maintaince_data['mt_stnd_remark'],
            'off_road_date' => date('Y-m-d', strtotime($maintaince_data['mt_offroad_datetime'])),
            'off_road_time' => date('H:i:s', strtotime($maintaince_data['mt_offroad_datetime'])),
            'added_date' => date('Y-m-d H:i:s'));

        if (!empty($maintaince_data['mt_remark'])) {
            $amb_update_summary['off_road_remark_other'] = $maintaince_data['mt_remark'];
        }

        $data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => 1,
        );

        if ($register_result) {

            $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
            $add_summary = $this->amb_model->insert_amb_staus_summary($amb_update_summary);
            //$update = $this->amb_model->update_amb($data);

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Offroad Onroad Maintenance Registered Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->onraod_offroad_maintaince();
        }
    }

    function onroad_offroad_maintaince_view() {


        $data = array();
        $data['action_type'] = 'View Ambulance Off-Road / Ambulance On-Road';

        $data['mt_id'] = $ref_id = $this->post['mt_id'];
        $data['preventive'] = $this->ambmain_model->get_ambulance_onroad_offroad_maintance_data($data);
        $data['mt_type'] = 'onroad_offroad';
        $data['media'] = $this->ambmain_model->get_media_maintance($data);
        //Request page - Approve / Reject history
        $args =array(
            'mt_id'=> $data['mt_id'],
            'mt_type'=>  $data['mt_type']
        );
        $data['app_rej_his'] = $this->ambmain_model->get_app_rej_his($args);
       // var_dump($data['app_rej_his']);die();
        //approve page - Re-request history
        $args =array(
            'mt_id'=>       $this->post['mt_id'],
            'mt_type'=>      $data['mt_type']
        );
       // var_dump($data);
        $re_request_id = $this->ambmain_model->get_photo_history($args);
        $data['media'] = $this->ambmain_model->get_media_maintance($data);
        
        $job_data = array('mt_id'=>$ref_id,'mt_type'=>'job_card_onroad_offroad');
        $data['job_media'] = $this->ambmain_model->get_media_maintance($job_data);
        
        
        $other_data = array('mt_id'=>$ref_id,'mt_type'=>'invoice_onroad_offroad');
        $data['invoice_media'] = $this->ambmain_model->get_media_maintance($other_data);
        $arr =array(
            'mt_id'=>       $this->post['mt_id'],
            'mt_type'=>      $data['mt_type'],
            're_request_id'=> $this->post['re_request_id']
        );
        $his = $this->ambmain_model->get_history($arr);
        foreach($his as $history){ //var_dump($history);
            $args_his = array('mt_id' => $this->post['mt_id'], 're_request_id' => $history->re_request_id);
            $history_images = $this->ambmain_model->get_history_photo($args_his);
            $history->his_photo = $history_images;
            $data['his'][] = $history;
        }

        $this->output->add_to_popup($this->load->view('frontend/maintaince/onroad_offroad_maintaince_view', $data, TRUE), '1200', '500');
    }

    function update_onroad_offroad_maintaince() {

        $maintaince_data = $this->post['maintaince'];
        $app_data = $this->post['app'];

        $main_data = array('mt_end_odometer' => $this->input->post('mt_end_odometer'),
            'mt_isupdated' => '1',
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'),
            'mt_ambulance_status' => 'Available');
        
        if($app_data['mt_onroad_datetime'] != ''){
            $main_data['mt_onroad_datetime'] = date('Y-m-d H:i:s', strtotime($app_data['mt_onroad_datetime']));
        }
        if($app_data['mt_app_onroad_datetime'] != ''){
            $main_data['mt_app_onroad_datetime'] = date('Y-m-d H:i:s', strtotime($app_data['mt_app_onroad_datetime']));
        }

        $args = array_merge($this->post['maintaince'], $main_data);
        //var_dump($args);

        $register_result = $this->ambmain_model->update_ambulance_on_off_maintance($args);
        
         if(!empty($_FILES['amb_job_card']['name'])){
            foreach ($_FILES['amb_job_card']['name'] as $key => $image) {
                $media_args = array();


                $_FILES['photo']['name']= $_FILES['amb_job_card']['name'][$key];
                $_FILES['photo']['type']= $_FILES['amb_job_card']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['amb_job_card']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['amb_job_card']['error'][$key];
                $_FILES['photo']['size']= $_FILES['amb_job_card']['size'][$key];

                $_FILES['photo']['name'] = time() .'_'. $this->sanitize_file_name($_FILES['photo']['name']);
               // var_dump($_FILES['amb_photo']['name']);
                //die();

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                    $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                    $upload_err = TRUE;
                }
                $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['user_id'] = $maintaince_data['mt_id'];
                $media_args['media_data'] = 'job_card_onroad_offroad';
                $this->ambmain_model->insert_media_maintance($media_args);
                // var_dump($media_args);die;
            }
        }
        
        if(!empty($_FILES['amb_invoice']['name'])){
            foreach ($_FILES['amb_invoice']['name'] as $key => $image) {
                $media_args = array();


                $_FILES['amb_invoice']['name']= $_FILES['amb_invoice']['name'][$key];
                $_FILES['amb_invoice']['type']= $_FILES['amb_invoice']['type'][$key];
                $_FILES['amb_invoice']['tmp_name']= $_FILES['amb_invoice']['tmp_name'][$key];
                $_FILES['amb_invoice']['error']= $_FILES['amb_invoice']['error'][$key];
                $_FILES['amb_invoice']['size']= $_FILES['amb_invoice']['size'][$key];

                $_FILES['amb_invoice']['name'] = time() .'_'.$this->sanitize_file_name($_FILES['amb_invoice']['name']);
               // var_dump($_FILES['amb_photo']['name']);
                //die();

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                    $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                    $upload_err = TRUE;
                }
                $media_args['media_name'] = $_FILES['amb_invoice']['name'];
                $media_args['user_id'] = $maintaince_data['mt_id'];
                $media_args['media_data'] = 'invoice_onroad_offroad';
                $this->ambmain_model->insert_media_maintance($media_args);
                // var_dump($media_args);die;
            }
        }


        $total_km = $this->input->post('mt_end_odometer') - $this->input->post('previous_odometer');
  //var_dump($this->input->post('previos_odometer'));
        $amb_record_data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'start_odmeter' => $this->input->post('previous_odometer'),
            'end_odmeter' => $this->input->post('mt_end_odometer'),
            'total_km' => $total_km,
            'odometer_type'       => 'update onroad offroad maintaince',
            'inc_ref_id'=>$maintaince_data['mt_id'],
            'timestamp' => date('Y-m-d H:i:s'));
           //var_dump($amb_record_data);die;
        if (!empty($maintaince_data['mt_off_remark'])) {
            $amb_record_data['other_remark'] = $maintaince_data['mt_off_remark'];
        }

        $amb_update_summary = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => '7,1',
            'end_odometer' => $this->input->post('mt_end_odometer'),
            'on_road_status' => "Ambulance onroad offroad maintenance on road",
            'on_road_remark' => $maintaince_data['mt_on_stnd_remark'],
            'on_road_date' => date('Y-m-d', strtotime($maintaince_data['mt_onroad_datetime'])),
            'on_road_time' => date('H:i:s', strtotime($maintaince_data['mt_onroad_datetime'])),
            'added_date' => date('Y-m-d H:i:s'));

        if (!empty($maintaince_data['mt_on_remark'])) {
            $amb_update_summary['on_road_remark_other'] = $maintaince_data['mt_on_remark'];
        }

        $data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => 1,
        );
        $off_road_status = "Ambulance onroad_offroad maintenance off road";
        $add_summary = $this->amb_model->update_ambulance_staus_summary($amb_update_summary, $off_road_status);
        $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);

        $update = $this->amb_model->update_amb($data);

        if ($register_result) {

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Onroad Offroad Maintenance Registered Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->onraod_offroad_maintaince();
        }
    }

    function tyre_maintaince() {

        ///////////////  Filters //////////////////

        $data['search'] = $search = ($this->post['search']) ? $this->post['search'] : $this->fdata['search'];
        $data['search_status'] =$search_status = ($this->post['search_status']) ? $this->post['search_status'] : $this->fdata['search_status'];
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        if ($this->post['from_date'] != '') {
            $data['from_date'] = $from_date = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date']));
        }

        if ($this->post['to_date'] != '') {
            $data['to_date'] = $to_date = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->post['to_date']));
        }


        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }

        ///////////limit & offset////////

        $data['get_count'] = TRUE;
        $data['mt_type'] = 'tyre';
        
        $district_id = "";
        if($this->clg->clg_group ==  'UG-DM'  || $this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER' ||  $this->clg->clg_group  == 'UG-FLEETDESK' ||  $this->clg->clg_group  == 'UG-OP-HEAD'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
            $data['amb_district'] = $district_id;
            
        }
        $data['thirdparty'] = $this->clg->thirdparty;
        $data['total_count'] = $this->ambmain_model->get_ambulance_tyre_data($data);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;



        unset($data['get_count']);



        $data['maintance_data'] = $this->ambmain_model->get_ambulance_tyre_data($data, $offset, $limit);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("ambulance_maintaince/tyre_maintaince"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&search=$search&search_status=$search_status&to_date=$to_date&from_date=$from_date"
            )
        );

        $data['pgconf'] = $pgconf;
        $data['pagination'] = get_pagination($pgconf);

        /////////////////////////////////

        $data['page_records'] = $data['total_count'];


        $this->output->add_to_position($this->load->view('frontend/maintaince/tyre_maintaince_list_view', $data, true), 'content', true);
    }

    function tyre_maintaince_view() {
        $data = array();
        $data['action_type'] = 'View Tyre Life';

        $data['mt_id'] = $ref_id =$this->post['mt_id'];
         $data['mt_type'] = 'tyre';
        $data['preventive'] = $this->ambmain_model->get_ambulance_tyre_data($data);
        $data['media'] = $this->ambmain_model->get_media_maintance($data);

        //Request page - Approve / Reject historyinvoice_tyre
        $args =array(
            'mt_id'=> $data['mt_id'],
            'mt_type'=>  $data['mt_type']
        );
        $data['app_rej_his'] = $this->ambmain_model->get_app_rej_his($args);
       // var_dump($data['app_rej_his']);die();
        //approve page - Re-request history
        $args =array(
            'mt_id'=>       $this->post['mt_id'],
            'mt_type'=>      $data['mt_type']
        );
        $re_request_id = $this->ambmain_model->get_photo_history($args);
        $data['media'] = $this->ambmain_model->get_media_maintance($data);
        
        $job_data = array('mt_id'=>$ref_id,'mt_type'=>'job_card_tyre');
        $data['job_media'] = $this->ambmain_model->get_media_maintance($job_data);
        
        
        $other_data = array('mt_id'=>$ref_id,'mt_type'=>'invoice_tyre');
        $data['invoice_media'] = $this->ambmain_model->get_media_maintance($other_data);
        
        $arr =array(
            'mt_id'=>       $this->post['mt_id'],
            'mt_type'=>      $data['mt_type'],
            're_request_id'=> $this->post['re_request_id']
        );
        $his = $this->ambmain_model->get_history($arr);
        foreach($his as $history){ //var_dump($history);
            $args_his = array('mt_id' => $this->post['mt_id'], 're_request_id' => $history->re_request_id);
            $history_images = $this->ambmain_model->get_history_photo($args_his);
            $history->his_photo = $history_images;
            $data['his'][] = $history;
        }

        $this->output->add_to_popup($this->load->view('frontend/maintaince/tyre_maintaince_view', $data, TRUE), '1200', '500');
    }

    function tyre_maintaince_registrartion() {

        $data['clg_ref_id'] = $this->clg->clg_ref_id;
        if ($this->post['mt_id'] != '') {

            $data['mt_id'] = $ref_id = base64_decode($this->post['mt_id']);
            $data['mt_type'] = 'tyre';
            $data['preventive'] = $this->ambmain_model->get_ambulance_tyre_data($data);
            $data['media'] = $this->ambmain_model->get_media_maintance($data);
        }
        $data['shift_info'] = $this->common_model->get_shift($args);


        if ($this->post['action_type'] == 'Update') {

            $data['action_type'] = "Update Tyre Maintenance";
            $data['type'] = "Update";
            $data['update'] = 'True';

            $this->output->add_to_popup($this->load->view('frontend/maintaince/tyre_maintaince_register_view', $data, TRUE), '1200', '500');
        // } elseif ($this->post['action_type'] == 'Approve') {
        //     $data['action_type'] = "Approve Tyre Life";
        //     $data['type'] = "Approve";
        //     $data['Approve'] = 'True';

        //     $this->output->add_to_popup($this->load->view('frontend/maintaince/tyre_maintaince_register_view', $data, TRUE), '1000', '500');
        }else{

            $data['action_type'] = "Add Tyre Maintenance";
            $state_id = $this->clg->clg_state_id;
            $data['state_id'] = $state_id;
            $this->output->add_to_popup($this->load->view('frontend/maintaince/tyre_maintaince_register_view', $data, TRUE), '1200', '500');
        }
    }

    function approve_tyre_life_maintaince() {

        if ($this->post['mt_id'] != '') {

            $data['mt_id'] = $ref_id = $this->post['mt_id'];
            $data['mt_type'] = 'tyre';
            $data['preventive'] = $this->ambmain_model->get_ambulance_tyre_data($data);
            $data['media'] = $this->ambmain_model->get_media_maintance($data);
        }
        $args =array(
            'mt_id'=>       $this->post['mt_id'],
            'mt_type'=>      $data['mt_type']
        );
        $re_request_id = $this->ambmain_model->get_photo_history($args);
        $data['media'] = $this->ambmain_model->get_media_maintance($data);
        $arr =array(
            'mt_id'=>       $this->post['mt_id'],
            'mt_type'=>      $data['mt_type'],
            're_request_id'=> $this->post['re_request_id']
        );
        $his = $this->ambmain_model->get_history($arr);
        foreach($his as $history){ //var_dump($history);
            $args_his = array('mt_id' => $this->post['mt_id'], 're_request_id' => $history->re_request_id);
            $history_images = $this->ambmain_model->get_history_photo($args_his);
            $history->his_photo = $history_images;
            $data['his'][] = $history;
        }
        
        if ($this->post['action_type'] == 'Update') {

            $data['action_type'] = "Update Tyre Life";
            $data['type'] = "Update";

            $data['update'] = 'True';

            $this->output->add_to_popup($this->load->view('frontend/maintaince/tyre_maintaince_register_view', $data, TRUE), '1200', '500');
        } elseif($this->post['action_type'] == 'Approve') {
            
            $data['action_type'] = "Approve Tyre Life";
            $data['type'] = "Approve";
            $data['Approve'] = 'True';
            $this->output->add_to_popup($this->load->view('frontend/maintaince/tyre_maintaince_register_view', $data, TRUE), '1200', '500');
        }elseif($this->post['action_type'] == 'Rerequest') {
            $data['type'] = "Rerequest";
            $data['action_type'] = "Re-request Tyre Maintenance";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/tyre_maintaince_register_view', $data, TRUE), '1200', '500');
        }else {
            $data['action_type'] = "Add Tyre Life";
           // $data['type'] = "Update";
            $this->output->add_to_popup($this->load->view('frontend/maintaince/tyre_maintaince_register_view', $data, TRUE), '1200', '500');
        }
    }

    function tyre_maintaince_save() {

        $maintaince_data = $this->post['maintaince'];


        $maintaince = $this->input->post();

       // $prev= generate_maintaince_id('ems_tyre_id');
        //$prev_id = "MHEMS-TM-".$prev;
        
        if($state == 'RJ'){
             $prev= generate_maintaince_id('ems_rj_tyre_id');
            $prev_id = "RJEMS-TM-".$prev;
        }else if($state == 'MP'){
            $prev= generate_maintaince_id('ems_pm_tyre_id');
            $prev_id = "MPEMS-TM-".$prev;
        }else{
            $prev= generate_maintaince_id('ems_tyre_id');
            $prev_id = "MHEMS-TM-".$prev;
        }
        if($this->input->post('maintaince_district') == 'Backup'){
            $amb_data = $this->amb_model->get_amb_district(array('amb_id' =>$this->input->post('maintaince_ambulance')));
            $district_id = $amb_data[0]->amb_district ;
        }
        else{
            $district_id =  $this->input->post('maintaince_district');
        }
        $main_data = array('mt_state_id' => $this->input->post('maintaince_state'),
            'mt_tyre_id'=>$prev_id,
            'mt_district_id' => $district_id,
            'mt_amb_no' => $this->input->post('maintaince_ambulance'),
             'mt_in_odometer' => $this->input->post('in_odometer'),
            'mt_previos_odometer' => $this->input->post('previous_odometer'),
            'mt_odometer_diff' => $this->input->post('odometer_diff'),
            'mt_base_loc' => $this->input->post('base_location'),
           // 'mt_offroad_datetime' => date('Y-m-d H:i:s', strtotime($maintaince_data['mt_offroad_datetime'])),
           'mt_Estimatecost' => $this->input->post('Estimatecost'),
            //'mt_ex_onroad_datetime' => $this->input->post('ex_onroad_datetime'),
            'amb_type' => $this->input->post('amb_type'),
            'mt_make' => $this->input->post('ambt_make'),
            'mt_module' => $this->input->post('ambt_model'),
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'informed_to' => json_encode($this->input->post('user_group')),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'),
            'mt_isdeleted' => '0',
            'mt_type' => 'tyre',
            'mt_base_month' => $this->post['base_month'],
            'mt_ambulance_status' => 'Pending Approval',
            'mt_tyre_type' => json_encode($this->input->post('maintaince[mt_tyre_type][]'))
        );
       // var_dump($main_data);die;
        $args = array_merge($this->post['maintaince'], $main_data);
      

        $register_result = $this->ambmain_model->insert_ambulance_tyre_maintance($args);
        
            $main_off_data = array('mt_state_id' => $this->input->post('maintaince_state'),
            'mt_onoffroad_id'=>$prev_id,
            'mt_district_id' => $district_id,
            'mt_amb_no' => $this->input->post('maintaince_ambulance'),
            'mt_in_odometer' => $this->input->post('in_odometer'),
            'mt_previos_odometer' => $this->input->post('previous_odometer'),
            'mt_odometer_diff' => $this->input->post('odometer_diff'),
            'mt_base_loc' => $this->input->post('base_location'),
            'mt_Estimatecost' => $this->input->post('Estimatecost'),
           // 'mt_offroad_datetime' => date('Y-m-d H:i:s', strtotime($maintaince_data['mt_offroad_datetime'])),
            // 'mt_ex_onroad_datetime' =>$this->input->post('ex_onroad_datetime'),
             'amb_type' => $this->input->post('amb_type'),
            'mt_make' => $this->input->post('ambt_make'),
            'mt_module' => $this->input->post('ambt_model'),
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'),
            'mt_isdeleted' => '0',
            'mt_type' => 'onroad_offroad',
            'mt_offroad_reason' => 'Tyre Maintenance',
            'mt_informed_group' => json_encode($this->input->post('user_group')),
            'mt_remark' => $maintaince_data['mt_remark'],
            'mt_base_month' => $this->post['base_month'],
            'mt_ambulance_status' => 'Pending Approval',
            'mt_pilot_id' =>  $maintaince_data['mt_pilot_id'],
            'amb_owner' =>  $maintaince_data['amb_owner'],
            'mt_pilot_name' => $this->input->post('pilot_id'),
            
        );

        
       if($register_result){
            //$off_register_result = $this->ambmain_model->insert_ambulance_on_off_maintance($main_off_data);
       }
        
                $inform_user_group = $this->input->post('user_group'); 
        //$district_id = $this->input->post('maintaince_district');
         
        if(!empty($inform_user_group)){
           
        foreach($inform_user_group as $user_group){
            if($user_group != ''){
            // var_dump($register_result_clg);
            $args_clg = array('clg_group'=>$user_group,'clg_district_id'=>$district_id);
            $register_result_clg = $this->colleagues_model->get_clg_data($args_clg);
             if($register_result_clg){ 
            foreach($register_result_clg as $register){
                
                $sms_to = $register->clg_mobile_no;
                    $txtMsg2 = "";
                    $txtMsg2.= "BVG\n";
                    $txtMsg2 .= "Ambulance On Maintenance\n";
                    $txtMsg2.= "Ambulance Number: ".$this->input->post('maintaince_ambulance')."\n"; 
                    $txtMsg2.= "MHEMS" ;

                $super_args = array(
                    'msg' => $txtMsg2,
                    'mob_no' => $sms_to,
                    'sms_user' => 'tyre'
                );

                //$sms_data = sms_send($super_args);

            
            $from = 'fleetdeskmems@bvgmems.com';

            $email = $register->clg_email;
            $subject = "Ambulance On Maintenance";
            $mail_res = $this->_send_email($email, $from,$subject, $txtMsg2);
              //var_dump($call_res);
             // die();
            }
          }
        }
        }
        }
        
        if($this->input->post('pilot_id') != ''){
            $pilot_clg = array('clg_ref_id'=>$this->input->post('pilot_id'));
            $pilot_clg_result = $this->colleagues_model->get_clg_data($pilot_clg);
            foreach($pilot_clg_result as $pilot){

                    $pilot_sms_to = $pilot->clg_mobile_no;
                    $txtMsg2 = "";
                    $txtMsg2.= "BVG\n";
                    $txtMsg2 .= "Ambulance On Maintenance\n";
                    $txtMsg2.= "Ambulance Number: ".$this->input->post('maintaince_ambulance')."\n"; 
                    $txtMsg2.= "MHEMS" ;

                $pilot_args = array(
                    'msg' => $txtMsg2,
                    'mob_no' => $pilot_sms_to,
                    'sms_user' => 'tyre'    
                );

                //$pilot_sms_data = sms_send($pilot_args);


                $from = 'fleetdeskmems@bvgmems.com';

                $email = $pilot->clg_email;
                $subject = "Ambulance On Maintenance";
                $mail_res = $this->_send_email($email, $from,$subject, $txtMsg2);
            }
        }
        
        //var_dump($register_result);die();
        if(!empty($_FILES['amb_photo']['name'])){
            foreach ($_FILES['amb_photo']['name'] as $key => $image) {
                $media_args = array();

                $_FILES['photo']['name']= $_FILES['amb_photo']['name'][$key];
                $_FILES['photo']['type']= $_FILES['amb_photo']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['amb_photo']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['amb_photo']['error'][$key];
                $_FILES['photo']['size']= $_FILES['amb_photo']['size'][$key];

                $_FILES['photo']['name'] = time() .'_'. $this->sanitize_file_name($_FILES['photo']['name']);
               // var_dump($_FILES['amb_photo']['name']);
                //die();

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                            $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                            $upload_err = TRUE;
                }
                $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['user_id'] = $register_result;
                $media_args['media_data'] = 'tyre';
                $this->ambmain_model->insert_media_maintance($media_args);

            }
        }


        $total_km = $this->input->post('in_odometer') - $this->input->post('previous_odometer');

        $amb_record_data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'start_odmeter' => $this->input->post('previous_odometer'),
            'end_odmeter' => $this->input->post('in_odometer'),
            'odometer_type'       => 'tyre maintenance',
            'total_km' => $total_km,       
            'inc_ref_id'=>$register_result,
            'timestamp' => date('Y-m-d H:i:s'));

        if (!empty($maintaince_data['mt_remark'])) {
            $amb_record_data['other_remark'] = $maintaince_data['mt_remark'];
        }

        $amb_update_summary = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => 1,
            'start_odometer' => $this->input->post('previous_odometer'),
            'off_road_status' => "Pending for approval",
            'off_road_remark' => $maintaince_data['mt_stnd_remark'],
            'off_road_date' => date('Y-m-d', strtotime($maintaince_data['mt_offroad_datetime'])),
            'off_road_time' => date('H:i:s', strtotime($maintaince_data['mt_offroad_datetime'])),
            'added_date' => date('Y-m-d H:i:s'));

        if (!empty($maintaince_data['mt_remark'])) {
            $amb_update_summary['off_road_remark_other'] = $maintaince_data['mt_remark'];
        }

        $data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => 1,
        );
//

        if ($register_result) {

            $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
            $add_summary = $this->amb_model->insert_amb_staus_summary($amb_update_summary);
            //$update = $this->amb_model->update_amb($data);

            $this->output->status = 1;
            $this->output->closepopup = "yes";

            $this->output->message = "<div class='success'>Tyre  Maintenance Registered Successfully!</div>";

            $this->tyre_maintaince();
        }
    }
    function update_approve_tyre_maintaince() {
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
            'mt_id' => $app_data['mt_id'],
            'mt_approval' => $app_data['mt_approval'],
            'mt_offroad_datetime' => $approved_date,
            'mt_app_onroad_datetime' => $onroaddate,
            'mt_app_remark' => $app_data['mt_app_remark'],
            'mt_app_under_process_remark' => $app_data['mt_app_under_process_remark'],
            'mt_app_est_amt'=> $app_data['mt_app_est_amt'],
            'mt_app_rep_time'=> $app_data['mt_app_rep_time'],
            'mt_app_amb_off_status' => $app_data['mt_app_amb_off_status'],
            'mt_ambulance_status' => $approval,
            'approved_by' => $Approved_by,
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'),
            'approved_date' => $approved_date
        );
        
        if($app_data['mt_approval']=="3"){
            //$app_data['mt_isupdated'] = '1';
        }
        
        //var_dump($app_data); die;
        $register_result = $this->ambmain_model->update_ambulance_tyre_maintance($app_data);

        $history_data = array(
            're_id' => $app_data['re_id'],
            're_mt_id' => $app_data['mt_id'],
            're_approval_status' => $app_data['mt_approval'],
            're_app_onroad_datetime' => date('Y-m-d H:i:s', strtotime($app_data['mt_app_onroad_datetime'])),
            're_remark' => $app_data['mt_app_remark'],
            're_mt_type' => 'tyre',
            're_rejected_by' => $this->clg->clg_ref_id,
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

        $amb_record_data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'start_odmeter' => $this->input->post('previous_odometer'),
            'end_odmeter' => $this->input->post('mt_end_odometer'),
            'total_km' => $total_km,
            'timestamp' => date('Y-m-d H:i:s'));

        if (!empty($maintaince_data['mt_off_remark'])) {
            $amb_record_data['other_remark'] = $maintaince_data['mt_off_remark'];
        }

        $amb_update_summary = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => '7',
            'end_odometer' => $this->input->post('mt_end_odometer'),
            'off_road_status' => "Ambulance tyre maintenance off road",
            'off_road_remark' => $maintaince_data['mt_on_stnd_remark'],
            'off_road_date' => date('Y-m-d'),
            'off_road_time' => date('H:i:s'),
            'added_date' => date('Y-m-d H:i:s'));

        if (!empty($maintaince_data['mt_on_remark'])) {
            $amb_update_summary['on_road_remark_other'] = $maintaince_data['mt_on_remark'];
        }

        $data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => 7,
        );
        $off_road_status = "Pending for approval";
        $add_summary = $this->amb_model->update_ambulance_staus_summary($amb_update_summary, $off_road_status);
        //$record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);

        if($app_data['mt_app_amb_off_status']=='Yes'){
            //$update = $this->amb_model->update_amb($data);//var_dump($update);die;
            }
            
    }
    
          if(!empty($_FILES['amb_photo']['name'])){
            foreach ($_FILES['amb_photo']['name'] as $key => $image) {
                $media_args = array();


                $_FILES['photo']['name']= $_FILES['amb_photo']['name'][$key];
                $_FILES['photo']['type']= $_FILES['amb_photo']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['amb_photo']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['amb_photo']['error'][$key];
                $_FILES['photo']['size']= $_FILES['amb_photo']['size'][$key];

                $_FILES['photo']['name'] = time() .'_'. $this->sanitize_file_name($_FILES['photo']['name']);
               // var_dump($_FILES['amb_photo']['name']);
                //die();

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                    $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                    $upload_err = TRUE;
                }
                $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['user_id'] = $app_data['mt_id'];
                $media_args['media_data'] = 'tyre';
                $this->ambmain_model->insert_media_maintance($media_args);
                // var_dump($media_args);die;
            }
        }
        if ($register_result) {

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Approval Registered Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->tyre_maintaince();
        }
    }
    function update_tyre_maintaince() {

        $maintaince_data = $this->post['maintaince'];
//var_dump($this->input->post());die;
$renew = json_encode($this->input->post('renew1'));
//var_dump($renew);die;
$new = json_encode($this->input->post('new'));
        $main_data = array('mt_end_odometer' => $this->input->post('mt_end_odometer'),
           // 'mt_onroad_datetime' => date('Y-m-d H:i:s', strtotime($maintaince_data['mt_onroad_datetime'])),
            'mt_isupdated' => '1',
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'),
            'mt_ambulance_status' => 'Available',
             'main_type' => $renew,
             'tyre_type_value' => $new,
             'mt_tyre_make' => $this->input->post('mt_tyre_make'),
             'mt_tyre_size' => $this->input->post('mt_tyre_size'),
             'bill_number' => $this->input->post('mt_bill_number'),
            'part_cost' => $this->input->post('mt_part_cost'),
            'labour_cost' => $this->input->post('mt_labour_cost'),
            'total_cost' => $this->input->post('mt_total_cost')
        );

        $args = array_merge($this->post['maintaince'], $main_data);
       //var_dump($main_data);die;
        $register_result = $this->ambmain_model->update_ambulance_tyre_maintance($args);
        
         if(!empty($_FILES['amb_job_card']['name'])){
            foreach ($_FILES['amb_job_card']['name'] as $key => $image) {
                $media_args = array();


                $_FILES['photo']['name']= $_FILES['amb_job_card']['name'][$key];
                $_FILES['photo']['type']= $_FILES['amb_job_card']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['amb_job_card']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['amb_job_card']['error'][$key];
                $_FILES['photo']['size']= $_FILES['amb_job_card']['size'][$key];

                $_FILES['photo']['name'] = time() .'_'. $this->sanitize_file_name($_FILES['photo']['name']);
               // var_dump($_FILES['amb_photo']['name']);
                //die();

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                    $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                    $upload_err = TRUE;
                }
                $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['user_id'] = $maintaince_data['mt_id'];
                $media_args['media_data'] = 'job_card_tyre';
                $this->ambmain_model->insert_media_maintance($media_args);
                // var_dump($media_args);die;
            }
        }
        
        if(!empty($_FILES['amb_invoice']['name'])){
            foreach ($_FILES['amb_invoice']['name'] as $key => $image) {
                $media_args = array();


                $_FILES['amb_invoice']['name']= $_FILES['amb_invoice']['name'][$key];
                $_FILES['amb_invoice']['type']= $_FILES['amb_invoice']['type'][$key];
                $_FILES['amb_invoice']['tmp_name']= $_FILES['amb_invoice']['tmp_name'][$key];
                $_FILES['amb_invoice']['error']= $_FILES['amb_invoice']['error'][$key];
                $_FILES['amb_invoice']['size']= $_FILES['amb_invoice']['size'][$key];

                $_FILES['amb_invoice']['name'] = time().'_'.$this->sanitize_file_name($_FILES['amb_invoice']['name']);
               // var_dump($_FILES['amb_photo']['name']);
                //die();

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                    $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                    $upload_err = TRUE;
                }
                $media_args['media_name'] = $_FILES['amb_invoice']['name'];
                $media_args['user_id'] = $maintaince_data['mt_id'];
                $media_args['media_data'] = '';
                $this->ambmain_model->insert_media_maintance($media_args);
                // var_dump($media_args);die;
            }
        }


        $total_km = $this->input->post('mt_end_odometer') - $this->input->post('previous_odometer');

        $amb_record_data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'start_odmeter' => $this->input->post('previous_odometer'),
            'end_odmeter' => $this->input->post('mt_end_odometer'),
            'total_km' => $total_km,
            'odometer_type'       => 'update tyre maintaince',
             'inc_ref_id'=>$maintaince_data['mt_id'],
            'timestamp' => date('Y-m-d H:i:s'));

        if (!empty($maintaince_data['mt_off_remark'])) {
            $amb_record_data['other_remark'] = $maintaince_data['mt_off_remark'];
        }
//var_dump($amb_record_data);
//die();
        $amb_update_summary = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => '7,1',
            'end_odometer' => $this->input->post('mt_end_odometer'),
            'on_road_status' => "Ambulance tyre maintenance on road",
            'on_road_remark' => $maintaince_data['mt_on_stnd_remark'],
            'on_road_date' => date('Y-m-d', strtotime($maintaince_data['mt_onroad_datetime'])),
            'on_road_time' => date('H:i:s', strtotime($maintaince_data['mt_onroad_datetime'])),
            'added_date' => date('Y-m-d H:i:s'));

        if (!empty($maintaince_data['mt_on_remark'])) {
            $amb_update_summary['on_road_remark_other'] = $maintaince_data['mt_on_remark'];
        }

        $data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => 1,
        );
        $off_road_status = "Ambulance tyre maintenance off road";
        $add_summary = $this->amb_model->update_ambulance_staus_summary($amb_update_summary, $off_road_status);
        $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);

       // $update = $this->amb_model->update_amb($data);

        if ($register_result) {

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Tyre Life Maintaince updated Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->tyre_maintaince();
        }
    }

     function sanitize_string( $string, $sep = '-' ){
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9 -_\.]+/', '', $string);
        $string = trim($string);
        $string = str_replace(' ', $sep, $string);
       //  $string = str_replace('.', '_', $string);
        return trim($string, '-_');
    }
     function sanitize_file_name( $string, $sep = '-' ){
        $path_info = pathinfo($string);
        $string = $path_info['filename'];
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9 -_]+/', '', $string);
        $string = trim($string);
        $string = str_replace(' ', $sep, $string);
        $string = str_replace('.', '-', $string);
        $string .= '.'.$path_info['extension'];
        return trim($string, '-_');
    }
    function show_other_remark() {

        $this->output->add_to_position($this->load->view('frontend/maintaince/other_accident_type_view', $data, TRUE), 'remark_other_textbox', TRUE);
    }
    function upload_photos(){

    $amb_type =$this->input->post('type');

        if(!empty($_FILES['amb_photo']['name'])){
            foreach ($_FILES['amb_photo']['name'] as $key => $image) {
                $media_args = array();


                $_FILES['photo']['name']= $_FILES['amb_photo']['name'][$key];
                $_FILES['photo']['type']= $_FILES['amb_photo']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['amb_photo']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['amb_photo']['error'][$key];
                $_FILES['photo']['size']= $_FILES['amb_photo']['size'][$key];

                //$_FILES['photo']['name'] = time().'_'.$this->sanitize_file_name($_FILES['photo']['name']);
               // var_dump($_FILES['amb_photo']['name']);
                //die();
                $_FILES['photo']['name'] = time() .'_'. $this->sanitize_file_name($_FILES['photo']['name']);

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                    $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                    $upload_err = TRUE;
                }
                $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['media_data'] = $amb_type;

                $image_id = $this->ambmain_model->insert_media_maintance($media_args);
                //die();
                $data['media_name'] =  $_FILES['photo']['name'];
                
                $data['img_id'] = $image_id;
                $photos[] = array('media_name' =>$_FILES['photo']['name'],
                    'img_id'=>$image_id);
                //$this->output->add_to_position($this->load->view('frontend/maintaince/upload_images_view', $data, TRUE), 'uploaded_images_block', TRUE);
                 
                //var_dump($image_id);
            }
            $data['media'] = $photos;
            $this->output->add_to_position($this->load->view('frontend/maintaince/upload_images_view', $data, TRUE), 'uploaded_images_block', false);
    }
    }

    
    // function update_tyre_maintainance() {

    //     $args = array(
    //         'amb_ref_id' => $this->post['amb_id'],
    //     );


    // //     $data['inc_emp_info'] = $this->pcr_model->get_amb_location($args);

    // //     $args_odometer = array('rto_no' => $this->post['amb_id']);
    // //     $amb_odometer = $this->amb_model->get_amb_odometer($args_odometer);
    //    $data['amb_info']= $this->amb_model->get_amb_tyre_data($args);
    // //     if (empty($data['previous_odometer'])) {
    // //         $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;
    // //     }

    // //     if (empty($data['previous_odometer'])) {
    // //         $data['previous_odometer'] = 0;
    // //     }
    //   //var_dump($data);die;
    //   $this->output->add_to_position($this->load->view('frontend/maintaince/tyre_uid_view', $data, TRUE), 'uid', TRUE);

        
    // }
    function load_baselocation_ambulance(){
        $base_location = $this->post['base_location'];
        
        
 
        $data['amb_base_location']=$base_location;
        
        $this->output->add_to_position($this->load->view('frontend/maintaince/load_baselocation_ambulance', $data, TRUE), 'maintaince_ambulance', TRUE);
        
      
    }
    function show_maintanance_part_list(){
        $epcr_info = $this->input->post();
//        var_dump($epcr_info);
//        die();
  

        $na_con_data = array();
        $cons_data = array();
        if($this->session->userdata('cons_data') != ''){
            $cons_data= $this->session->userdata('cons_data');
        }

        if (isset($epcr_info['unit'])) {
            foreach ($epcr_info['unit'] as $key => $unit) {

                if ($unit['value'] != '') {

                    
                        $cons_data[$key] = array('inv_id' => $unit['id'],
                            'inv_qty' => $unit['value'],
                            'inv_type' => $unit['type']);

                        $args = array('mt_part_id' => $unit['id'],
                            'inv_type' => $unit['type']);
                        $invitem = $this->maintenance_part_model->get_maintenance_part_list($args);

                        $cons_data[$key]['inv_title'] = $invitem[0]->mt_part_title;
                        $cons_data[$key]['Item_Code'] = $invitem[0]->Item_Code;
                        
                    
                }
            }
        }



        $data['cons_data'] = $cons_data;
        $this->clg = $this->session->set_userdata('cons_data' ,$cons_data);

        $this->output->add_to_position($this->load->view('frontend/maintaince/maintanance_part_view', $data, TRUE), 'show_selected_unit_item_ca', TRUE);
    }
    function fleetdesk(){
        $user_group=$this->clg->clg_group;  
        if ($user_group == 'UG-FleetManagement' || $user_group == 'UG-FLEET-SUGARFCTORY') {
        $data['header'] = array('Parameter','Today','Week Till Date','Month Till Date');
        $from_date =  date('Y-m-d');
        $report_args_till_month = array('from_date' => date('Y-m-d', strtotime($from_date)),
              'to_date' => date('Y-m-t', strtotime($from_date)),
              'get_count'=>TRUE);
        
        $report_args_till_date = array('from_date' => date('Y-m-d'),
              'to_date' => date('Y-m-d'),
              'get_count'=>TRUE);
        
        
        $date_array = getdate (time());
        $numdays = $date_array["wday"];

        $startdate = date("Y-m-d", time() - ($numdays * 24*60*60));
        $enddate = date("Y-m-d", time() + ((7 - $numdays) * 24*60*60));

        $report_args_till_week = array('from_date' => date('Y-m-d', strtotime($startdate)),
                'to_date' => date('Y-m-d', strtotime($enddate)),
                'get_count'=>TRUE);
        
        $till_date_schedule = $this->ambmain_model->preventive_maintenance_report($report_args_till_date);
        $till_week_schedule  = $this->ambmain_model->preventive_maintenance_report($report_args_till_week);
        $till_month_schedule  = $this->ambmain_model->preventive_maintenance_report($report_args_till_month);
       // die();
     
        
        $completed_args_till_month = array('from_date' => date('Y-m-d', strtotime($from_date)),
              'to_date' => date('Y-m-t', strtotime($from_date)),
              'mt_isupdated'=>'1',
              'get_count'=>TRUE);
        
        $completed_args_till_date = array('from_date' => date('Y-m-d'),
              'to_date' => date('Y-m-d'),
              'mt_isupdated'=>'1',
              'get_count'=>TRUE);
        $completed_args_till_week = array('from_date' => date('Y-m-d', strtotime($startdate)),
                'to_date' => date('Y-m-d', strtotime($enddate)),
                'mt_isupdated'=>'1',
                'get_count'=>TRUE);
        $till_date_completed = $this->ambmain_model->preventive_maintenance_report($completed_args_till_date);
        $till_week_completed  = $this->ambmain_model->preventive_maintenance_report($completed_args_till_week);
        $till_month_completed  = $this->ambmain_model->preventive_maintenance_report($completed_args_till_month);
        
        $pending_args_till_month = array('from_date' => date('Y-m-d', strtotime($from_date)),
              'to_date' => date('Y-m-t', strtotime($from_date)),
              'mt_approval'=>'0',
              'get_count'=>TRUE);
        
        $pending_args_till_date = array('from_date' => date('Y-m-d'),
              'to_date' => date('Y-m-d'),
              'mt_approval'=>'0',
              'get_count'=>TRUE);
        $pending_args_till_week = array('from_date' => date('Y-m-d', strtotime($startdate)),
                'to_date' => date('Y-m-d', strtotime($enddate)),
                'mt_approval'=>'0',
                'get_count'=>TRUE);
        
        $till_date_pending = $this->ambmain_model->preventive_maintenance_report($pending_args_till_date);
        $till_week_pending  = $this->ambmain_model->preventive_maintenance_report($pending_args_till_week);
        $till_month_pending = $this->ambmain_model->preventive_maintenance_report($pending_args_till_month);
        
        $data_report= array('till_date_schedule'=>$till_date_schedule,
                            'till_week_schedule'=>$till_week_schedule,
                            'till_month_schedule'=>$till_month_schedule,
                            'till_date_completed'=>$till_date_completed,
                            'till_week_completed'=>$till_week_completed,
                            'till_month_completed'=>$till_month_completed,
                            'till_date_pending'=>$till_date_pending,
                            'till_week_pending'=>$till_week_pending,
                            'till_month_pending'=>$till_month_pending);
        
        $data['data_report'] = $data_report;

        
        $this->output->add_to_position($this->load->view('frontend/erc_reports/show_pre_maintaince_details_report_view', $data, TRUE), 'content', TRUE);
        }else{
             dashboard_redirect($user_group,$this->base_url );
        }
    }
    function send_daily_preventive_maintanance_sms(){
         //$report_args =  $this->input->post();
        $data['header'] = array('Parameter','Today','Week Till Date','Month Till Date');
        $from_date =  date('Y-m-d');
        $report_args_till_month = array('from_date' => date('Y-m-d', strtotime($from_date)),
              'to_date' => date('Y-m-t', strtotime($from_date)),
              'get_count'=>TRUE);
        
        $report_args_till_date = array('from_date' => date('Y-m-d'),
              'to_date' => date('Y-m-d'),
              'get_count'=>TRUE);
        
        
        $date_array = getdate (time());
        $numdays = $date_array["wday"];

        $startdate = date("Y-m-d", time() - ($numdays * 24*60*60));
        $enddate = date("Y-m-d", time() + ((7 - $numdays) * 24*60*60));

        $report_args_till_week = array('from_date' => date('Y-m-d', strtotime($startdate)),
                'to_date' => date('Y-m-d', strtotime($enddate)),
                'get_count'=>TRUE);
        
        $till_date_schedule = $this->ambmain_model->preventive_maintenance_report($report_args_till_date);
        $till_week_schedule  = $this->ambmain_model->preventive_maintenance_report($report_args_till_week);
        $till_month_schedule  = $this->ambmain_model->preventive_maintenance_report($report_args_till_month);
       // die();
     
        
        $completed_args_till_month = array('from_date' => date('Y-m-d', strtotime($from_date)),
              'to_date' => date('Y-m-t', strtotime($from_date)),
              'mt_isupdated'=>'1',
              'get_count'=>TRUE);
        
        $completed_args_till_date = array('from_date' => date('Y-m-d'),
              'to_date' => date('Y-m-d'),
              'mt_isupdated'=>'1',
              'get_count'=>TRUE);
        $completed_args_till_week = array('from_date' => date('Y-m-d', strtotime($startdate)),
                'to_date' => date('Y-m-d', strtotime($enddate)),
                'mt_isupdated'=>'1',
                'get_count'=>TRUE);
        $till_date_completed = $this->ambmain_model->preventive_maintenance_report($completed_args_till_date);
        $till_week_completed  = $this->ambmain_model->preventive_maintenance_report($completed_args_till_week);
        $till_month_completed  = $this->ambmain_model->preventive_maintenance_report($completed_args_till_month);
        
        $pending_args_till_month = array('from_date' => date('Y-m-d', strtotime($from_date)),
              'to_date' => date('Y-m-t', strtotime($from_date)),
              'mt_approval'=>'0',
              'get_count'=>TRUE);
        
        $pending_args_till_date = array('from_date' => date('Y-m-d'),
              'to_date' => date('Y-m-d'),
              'mt_approval'=>'0',
              'get_count'=>TRUE);
        $pending_args_till_week = array('from_date' => date('Y-m-d', strtotime($startdate)),
                'to_date' => date('Y-m-d', strtotime($enddate)),
                'mt_approval'=>'0',
                'get_count'=>TRUE);
        
        $till_date_pending = $this->ambmain_model->preventive_maintenance_report($pending_args_till_date);
        $till_week_pending  = $this->ambmain_model->preventive_maintenance_report($pending_args_till_week);
        $till_month_pending = $this->ambmain_model->preventive_maintenance_report($pending_args_till_month);
        
        $sms_text = "BVG\n Total Ambulances Scheduled For Preventive Maintenance- Today:$till_date_schedule, Till Week $till_week_schedule, Till Month:$till_month_schedule\nTotal Ambulances Preventive Maintenance Completed - Today:$till_date_completed, Till Week $till_week_completed, Till Month:$till_month_completed\nTotal Ambulances Pending For Preventive Maintenance - Today:$till_date_pending, Till Week $till_week_pending, Till Month:$till_month_pending\n MEMS";
        
//         $sms_args = array(
//                    'msg' => $sms_text,
//                    'mob_no' => "9975175477",
//                    'sms_user' => 'daily preventive maintaice',
//                );
//
//                $sms_data = sms_send($sms_args);
                
         $sms_args = array(
                    'msg' => $sms_text,
                    'mob_no' => "9730015484",
                    'sms_user' => 'daily preventive maintaice',
                );

                $sms_data = sms_send($sms_args);
          
                die();
    }
    
    function load_maintananace_part_search(){
        $post_data =  $this->input->post();
        
            $data['mt_type'] = 'preventive';
            $args = array('mt_id'=>$post_data['mt_id']);
            $data['preventive'] = $this->ambmain_model->get_ambulance_maintance_data($args);
            $non_args = array('inv_type' => $data['preventive'][0]->mt_make,'term'=>$post_data['term']);
            $data['invitem'] = $this->maintenance_part_model->get_maintenance_part_list($non_args);
            
            $this->output->add_to_position($this->load->view('frontend/maintaince/load_maintananace_part_search_view', $data, TRUE), 'unit_drugs_box_list', TRUE);
    }
    function breakdown_severity(){
        $post_data =  $this->input->post('breakdown');
        $brakdown_severity = $post_data['mt_brakdown_severity'];
         if($brakdown_severity == 'Major'){
         $this->output->add_to_position($this->load->view('frontend/maintaince/majore_severity', $data, TRUE), 'major_severity', TRUE);
         }else if($brakdown_severity == 'Minor'){
             $this->output->add_to_position($this->load->view('frontend/maintaince/minor_severity', $data, TRUE), 'major_severity', TRUE);
         }
    }
    function material_used(){
        $post_data =  $this->input->post('breakdown');
        $mt_material_used = $post_data['mt_material_used'];
        
            //$data['mt_id'] = $ref_id = base64_decode($this->post['mt_id']);
           
           // $data['preventive'] = $this->ambmain_model->get_ambulance_maintance_data($data);
            $non_args = array('mt_maintanance_type'=>'0');
            $data['invitem'] = $this->maintenance_part_model->get_maintenance_part_list($non_args,0,400);
            
            
         if($mt_material_used == 'Available Stock'){
         $this->output->add_to_position($this->load->view('frontend/maintaince/available_material_used', $data, TRUE), 'material_type_block', TRUE);
         }else if($mt_material_used == 'Local Purchase'){
             $this->output->add_to_position($this->load->view('frontend/maintaince/local_material_used', $data, TRUE), 'material_type_block', TRUE);
         }
    }
    function labor_type(){
        $post_data =  $this->input->post('breakdown');
        $mt_labor_type = $post_data['mt_labor_type'];
         if($mt_labor_type == 'Inhouse-Free'){
         $this->output->add_to_position('', 'labour_cost_block', TRUE);
         }else if($mt_labor_type == 'Outside Vendor/Mech'){
             $this->output->add_to_position($this->load->view('frontend/maintaince/labor_cost', $data, TRUE), 'labour_cost_block', TRUE);
         }
    }
    function maintance_part_request(){
        $ambt_name =  $this->input->post('ambt_name');
       // var_dump($ambt_name);
       // die();
          if( strtolower($ambt_name) == 'force'){
            
             $this->output->add_to_position($this->load->view('frontend/maintenance_part/force_maintenance_part', $data, TRUE), 'send_material_request_block', TRUE);
            $this->output->add_to_position($this->load->view('frontend/maintenance_part/force_hidden_maintenance_part', $data, TRUE), 'hidden_maintence_part', TRUE);
             
        }else{
            
             $this->output->add_to_position($this->load->view('frontend/maintenance_part/ashok_maintenance_part', $data, TRUE), 'send_material_request_block', TRUE);
               $this->output->add_to_position($this->load->view('frontend/maintenance_part/ashok_hidden_maintenance_part', $data, TRUE), 'hidden_maintence_part', TRUE);
             
        }
    }
        function app_maintance_part_request(){
        $ambt_name =  $this->input->post('ambt_name');
       // var_dump($ambt_name);
       // die();
          if( strtolower($ambt_name) == 'force'){
            
             $this->output->add_to_position($this->load->view('frontend/maintenance_part/force_maintenance_part', $data, TRUE), 'app_send_material_request_block', TRUE);
            $this->output->add_to_position($this->load->view('frontend/maintenance_part/force_hidden_maintenance_part', $data, TRUE), 'app_hidden_maintence_part', TRUE);
             
        }else{
            
             $this->output->add_to_position($this->load->view('frontend/maintenance_part/ashok_maintenance_part', $data, TRUE), 'app_send_material_request_block', TRUE);
               $this->output->add_to_position($this->load->view('frontend/maintenance_part/ashok_hidden_maintenance_part', $data, TRUE), 'app_hidden_maintence_part', TRUE);
             
        }
    }
    
   function offraod_preventive_maintaince_cron() {

        $data['to_date'] = date('Y-m-d H:i:s', strtotime('+5 minutes'));
        $data['from_date'] = date('Y-m-d H:i:s');;
        $data['mt_isupdated'] = '0';
        $data['mt_type'] = 'preventive';
        

        $total_amb = $this->ambmain_model->get_preventive_amb($data);
        if($total_amb){
            foreach($total_amb as $amb){
                $amb_update = array(
                    'amb_rto_register_no' => $amb->mt_amb_no,
                    'amb_status' => '7',
                ); 
                $update = $this->amb_model->update_amb($amb_update);
            }
        }
        die();
        
        }
    
}

