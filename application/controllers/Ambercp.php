<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ambercp extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->load->model(array('test_model', 'colleagues_model', 'inc_model', 'call_model', 'amb_erc_call_model','problem_reporting_model','Pet_model'));

        $this->load->helper(array('url', 'comman_helper'));

        $this->post = $this->input->get_post(NULL);

        $this->clg = $this->session->userdata('current_user');

        $this->post['base_month'] = get_base_month();
        $this->today = date('Y-m-d H:i:s');
    }

    public function index($generated = false) {

        echo "This is Transfer Call to 102 controller";
    }

    /////////////////MI44/////////////////////
    //
    // Purpose : To Confirm test details.
    //
    /////////////////////////////////////

    function confirm_save() {

        $this->session->unset_userdata('amb_details');
        $this->session->unset_userdata('call_id');


        $inc_details = $this->input->get_post('incient');

        $inc_id = $this->session->userdata('inc_ref_id');
        if ($inc_id == '') {
            $inc_id = generate_inc_ref_id();
            $this->session->set_userdata('inc_ref_id', $inc_id);
            update_inc_ref_id($inc_id);
        }

        $data['inc_ref_id'] = $inc_id;

        $data = array(
            'amb_erccl_base_month' => $this->post['base_month'],
            'amb_erccl_cl_id' => $this->post['call_id'],
            'amb_erccl_clr_id' => $this->post['caller_id'],
            'amb_erccl_date' => date('Y-m-d H:i:s'),
            'amb_erccl_inc_ref_id' => $inc_id,
            'amb_erccl_added_by' => $this->clg->clg_ref_id,
            'amb_ercclis_deleted' => '0',
            'amb_erccl_dept_name' => $this->post['dept_name'],
        );

        $this->session->set_userdata('amb_details', $data);


        $amb_inc = array(
            'inc_ref_id' => $inc_id,
            'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
            'inc_ero_summary' => $inc_details['inc_ero_summary'],
            'inc_base_month' => $this->post['base_month'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_datetime' => date('Y-m-d H:i:s'),
            'inc_dispatch_time' => $inc_details['caller_dis_timer'],
            'inc_recive_time' => $inc_details['inc_recive_time'],
            'inc_type' => $inc_details['inc_type'],
            'inc_cl_id' => $this->post['call_id'],
        );


        $this->session->set_userdata('amb_erc_incidence_details', $amb_inc);
        $data1['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inc_details['inc_ero_standard_summary']));

        $data['re_name'] = $data1['standard_remark'][0]->re_name;
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];

        $this->output->add_to_popup($this->load->view('frontend/amb_erc/confirm_amb_erc_view', $data, TRUE), '600', '250');
    }

    //// Created by MI44 ////////////////////
    // 
    // Purpose : To save and forword test details.
    // 
    /////////////////////////////////////////

    function save() {



        $args = $this->session->userdata('amb_details');
        
        $inc_id = $this->session->userdata('inc_ref_id');
        $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_id));
        
        if(!empty($is_exits)){
            $this->session->set_userdata('inc_ref_id','');
            $this->output->add_to_position("<script>alert('Incident Id already exists !! Cancel and dispatch again')</script>", 'custom_script', TRUE);
        }

        $trcl_id = $this->amb_erc_call_model->insert_amb_erc($args);

        $inc_args = $this->session->userdata('amb_erc_incidence_details');

        $inc_data = $this->inc_model->insert_inc($inc_args);
        $inc_id = $inc_args['inc_ref_id'];
        

        $erc_args = array(
            'sub_id' => $trcl_id,
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'base_month' => $this->post['base_month'],
            'sub_type' => 'AMB_TO_ERC'
        );

        $res = $this->common_model->assign_operator($erc_args);
        
        $sr_user = $this->clg->clg_ref_id;
        
        $dept_user = $this->inc_model->get_fire_user($sr_user, $args['amb_erccl_dept_name']);

        if($dept_user){
            $dept_user_operator = array(
                'sub_id' => $inc_id,
                'operator_id' => $dept_user->clg_ref_id,
                'operator_type' => $dept_user->clg_group,
                'sub_status' => 'ASG',
                'sub_type' => 'AMB_TO_ERC',
                'base_month' => $this->post['base_month']
            );


            $police_operator = $this->common_model->assign_operator($dept_user_operator);
        }
    
        if ($inc_data) {

            $this->output->status = 1;

            $this->output->closepopup = "yes";

            $url = base_url("calls");
            $this->output->message = "<h3>Ambuance TO ERC</h3><br><p>Ambuance TO ERC save Successfully.</p><script>window.location.href = '".$url."';</script>";

            $this->output->moveto = 'top';

            $this->output->add_to_position('', 'content', TRUE);
        }
    }
    
    function ercp_incoming_call(){
        
        if (!isset($this->post['inc_ref_id'])) {

            $data['opt_id'] = $this->post['opt_id'];

            $data['sub_id'] = $this->post['sub_id'];

            $args = array('opt_id' => $data['opt_id'],
                'sub_id' => $data['sub_id'],
                'sub_type' => 'ADV');

            update_opt_status($args);

            $args = array(
                'sub_id' => $data['sub_id'],
                'operator_id' => $this->clg->clg_ref_id,
                'operator_type' => $this->clg->clg_group,
                'base_month' => $this->post['base_month'],
                'sub_type' => 'ADV',
                'sub_status' => 'ATNG'
            );



            $this->common_model->assign_operator($args);


            $args = array(
                'opt_id' => $data['opt_id'],
                'sub_id' => $data['sub_id'],
                'base_month' => $this->post['base_month']
            );

            $data['cl_dtl'] = $this->Medadv_model->call_detials($args);
        } else {

            $args = array(
                'inc_ref_id' => trim($this->post['inc_ref_id']),
            );

            $data['inc_ref_id'] = trim($this->post['inc_ref_id']);

            $this->session->set_userdata('es_inc_ref_id', $this->post['inc_ref_id']);

            $data['cl_dtl'] = $this->problem_reporting_model->get_grivance_call_detials($args);

            $this->session->set_userdata('caller_information', $data['cl_dtl']);
            $this->session->set_userdata('inc_ref_id', $data['inc_ref_id']);

            $args_remark = array('re_id' => $data['cl_dtl'][0]->inc_ero_standard_summary);
            $standard_remark = $this->call_model->get_ero_summary_remark($args_remark);
            $data['re_name'] = $standard_remark[0]->re_name;
        }

        if (empty($data['cl_dtl'])) {
            $this->output->message = "<p>No Record Found</p>";

            return;
        }

        $this->output->add_to_position($this->load->view('frontend/amb_erc/incoming_inc_details_view', $data, TRUE), 'content', TRUE);
    }
    function save_incoming_call() {

        $inc_id = $this->post['sf']['sf_inc_ref_id'];


        $sf = $this->post['sf'];


        $args = array(
            'inc_ref_id'=>$this->post['inc_ref_id'],
            'base_month' => $this->post['base_month'],
            'added_date' => $this->today,
            'added_by' => $this->clg->clg_ref_id,
            'modify_date' => $this->today,
            'modify_by' => $this->clg->clg_ref_id,
        );


        $args = array_merge($this->post['sf'], $args);


        $shiftmanager = $this->amb_erc_call_model->add_call_summary($args);

        $shiftmanager_operator = array(
            'sub_id' => $this->post['inc_ref_id'],
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'sub_status' => 'ATND',
        );

        $shiftmanager_args = array(
            'sub_id' => $this->post['inc_ref_id'],
            'operator_type' => $this->clg->clg_group,
        );

        $shiftmanager = $this->common_model->update_operator($shiftmanager_args, $shiftmanager_operator);

        if ($shiftmanager) {

           // $this->output->message = "<div class='success'>Details saved successfully</div><script>window.location.reload(true);</script>";
             $this->output->status = 1;

            $this->output->closepopup = "yes";

            $this->output->message = "<p>Details saved Successfully.</p><script>window.location.reload(true);</script>";

            $this->output->moveto = 'top';

           // $this->output->add_to_position('', 'content', TRUE);
        }
    }
    function eme_professional_call(){
        $this->post = $this->input->post();
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');

        $this->post['base_month'] = get_base_month();

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $data['ero_id'] = ($this->post['ero_id']) ? $this->post['ero_id'] : $this->fdata['ero_id'];

        //$this->pg_limit = 10;
        ///////////set page number////////////////////
        $args_dash = array();
        $page_no = 1;

        if ($this->post['from_date'] != '') {
            $args_dash['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date']));
        }else{
             $args_dash['from_date'] = date('Y-m-d');
        }


        if ($this->post['to_date'] != '') {
            $args_dash['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->post['to_date']));
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


            
        //$args_dash['operator_id'] = $this->clg->clg_ref_id;
        $args_dash['base_month'] = $this->post['base_month'];
        
       

//        var_dump($args_dash);
//        die();
        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;


        //$incomplete_inc_amb = $this->pcr_model->get_incomplete_inc_amb();
        //$inc_info = $this->pcr_model->get_inc_by_emt($args_dash, $offset, $limit,$filter,$sortby,$incomplete_inc_amb);

        $inc_info = $this->call_model->get_inc_professional($args_dash, $offset, $limit);


        $inc_data = (object) array();

        $data['per_page'] = $limit;

        $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->call_model->get_inc_professional($args_dash);
        //$total_cnt = $this->pcr_model->get_inc_by_emt($args_dash,'','',$filter,$sortby,$incomplete_inc_amb);

        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("ambercp/eme_professional_call"),
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



        $this->output->add_to_position($this->load->view('frontend/amb_erc/professional_call_view', $data, TRUE), 'content', TRUE);
    }

    function view_professional_call(){
        

            $args_dash['base_month'] = $this->post['base_month'];
            
            $args = array(
                'inc_ref_id' => trim($this->post['ref_id']),
                'base_month'=>$args_dash['base_month']
            );

            $data['inc_ref_id'] = trim($this->post['ref_id']);

            $this->session->set_userdata('es_inc_ref_id', $this->post['ref_id']);
            

            $data['cl_dtl'] = $this->problem_reporting_model->get_grivance_call_detials($args);

            $this->session->set_userdata('caller_information', $data['cl_dtl']);
            $this->session->set_userdata('inc_ref_id', $data['ref_id']);

            $args_remark = array('re_id' => $data['cl_dtl'][0]->inc_ero_standard_summary);
            $standard_remark = $this->call_model->get_ero_summary_remark($args_remark);
            $data['re_name'] = $standard_remark[0]->re_name;
      

        if (empty($data['cl_dtl'])) {
            $this->output->message = "<p>No Record Found</p>";

            return;
        }
        
        $this->output->add_to_popup($this->load->view('frontend/amb_erc/professional_view', $data, TRUE), '1200', '1000');
        //$this->output->add_to_position($this->load->view('frontend/escalation/escalation_view', $data, TRUE), 'content', TRUE);
    }
    function supervisor104_incoming_call(){
        
        if (!isset($this->post['inc_ref_id'])) {

            $data['opt_id'] = $this->post['opt_id'];

            $data['sub_id'] = $this->post['sub_id'];

            $args = array('opt_id' => $data['opt_id'],
                'sub_id' => $data['sub_id'],
                'sub_type' => 'ADV');

            update_opt_status($args);

            $args = array(
                'sub_id' => $data['sub_id'],
                'operator_id' => $this->clg->clg_ref_id,
                'operator_type' => $this->clg->clg_group,
                'base_month' => $this->post['base_month'],
                'sub_type' => 'ADV',
                'sub_status' => 'ATNG'
            );



            $this->common_model->assign_operator($args);


            $args = array(
                'opt_id' => $data['opt_id'],
                'sub_id' => $data['sub_id'],
                'base_month' => $this->post['base_month']
            );

            $data['cl_dtl'] = $this->Medadv_model->call_detials($args);
        } else {

            $args = array(
                'inc_ref_id' => trim($this->post['inc_ref_id']),
            );

            $data['inc_ref_id'] = trim($this->post['inc_ref_id']);

            $this->session->set_userdata('es_inc_ref_id', $this->post['inc_ref_id']);

            $data['cl_dtl'] = $this->problem_reporting_model->get_grivance_call_detials($args);
            
            if(!empty($data['cl_dtl'])){
                $data['pt_info'] = $this->Pet_model->get_ptinc_info($args);
            }

            $this->session->set_userdata('caller_information', $data['cl_dtl']);
            $this->session->set_userdata('inc_ref_id', $data['inc_ref_id']);

            
            $comp_args=array('id'=>$data['cl_dtl'][0]->help_complaint_type);
            $get_cmp_type = $this->call_model->get_help_complaints_types($comp_args);
            $data['re_name'] = $get_cmp_type[0]->cmp_name;
        }

        if (empty($data['cl_dtl'])) {
            $this->output->message = "<p>No Record Found</p>";

            return;
        }

        $this->output->add_to_position($this->load->view('frontend/amb_erc/incoming_104_inc_details_view', $data, TRUE), 'content', TRUE);
    }
    
    
    function save_104_incoming_call() {


        $inc_id = $this->post['inc_ref_id'];
        $call_type = $this->post['inc_type'];
        $district_id = $this->post['inc_district_id'];
        $ero_summary = $this->post['inc_ero_summary'];
        
        $args_dist = array('district_id'=>$district_id);
        $district_data = $this->common_model->get_district($args_dist);
        $div_id = $district_data[0]->div_id;

        $sf = $this->post['sf'];
        
        $inc_args = array('inc_ref_id' => trim($this->post['inc_ref_id']));
        $inc_details = $this->inc_model->get_inc_details_ref_id($inc_args);
        
        $update_inc_args = array('inc_ref_id' => trim($this->post['inc_ref_id']), 'inc_pcr_status' => $ero_summary);
        $update_inc = $this->inc_model->update_incident($update_inc_args);

        $args = array(
            'es_inc_ref_id'=>$this->post['inc_ref_id'],
            'es_base_month' => $this->post['base_month'],
            'added_date' => $this->today,
            'added_by' => $this->clg->clg_ref_id,
            'modify_date' => $this->today,
            'modify_by' => $this->clg->clg_ref_id,
        );


        $args = array_merge($this->post['sf'], $args);
        $shiftmanager = $this->amb_erc_call_model->insert_supervisor_inc($args);

        $shiftmanager_operator = array(
            'sub_id' => $this->post['inc_ref_id'],
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'sub_status' => 'ATND',
        );

        $shiftmanager_args = array(
            'sub_id' => $this->post['inc_ref_id'],
            'operator_type' => $this->clg->clg_group,
        );
        $shiftmanager_op = $this->common_model->update_operator($shiftmanager_args, $shiftmanager_operator);
        
      
        if($this->input->post('type') == 'grivaince'){
            
            $gri_user = $this->inc_model->get_fire_user($sr_user, 'UG-Grievance');
            
            if(empty($gri_user)){
                $gri_user = $this->inc_model->get_user_by_group('UG-Grievance');
            }

            //var_dump($gri_user);
            $args = array(
                'sub_id' => $this->post['inc_ref_id'],
                'operator_id' => $gri_user->clg_ref_id,
                'operator_type' => 'UG-Grievance',
                'sub_status' => 'ASG',
                'base_month' => $this->post['base_month'],
                'sub_type' => $call_type
            );

            $res = $this->common_model->assign_operator($args);
            
        }else if($this->input->post('type') == 'cmho'){
            $args_clg = array('cm_zone_id'=>$div_id);
            $register_result_clg = $this->inc_model->get_cmho_data($args_clg);
           
            $mobile_no = $inc_details[0]->clr_mobile;
            $inc_datetime= $inc_details[0]->inc_datetime;
            $inc_district = get_district_by_id($inc_details[0]->inc_district_id);
            $inc_city_id = "NA";
            if($inc_details[0]->inc_city_id != ''){
                $inc_city_id = $this->inc_model->get_city_by_id($inc_details[0]->inc_city_id);
            }
            $es_summary = $sf['es_summary'];
            if($register_result_clg){ 
            foreach($register_result_clg as $register){
                
               $mailContent = "Dear Officer,<br>The Follow up has been generated with Complaint Details Listed below.<br><br><br>Incident ID<br>
                $inc_id<br><br><br><br>Caller Phone No<br>
                $mobile_no<br><br><br>Job Creation Date & Time<br>
                $inc_datetime<br><br>District<br>
                $inc_district<br><br>City<br>$inc_city_id<br><br>Complaint Description<br>$es_summary<br><br>Thanks & Regards,<br>Team 104";
                

    
            $from = 'mp104healthhelpline@gmail.com';

            $email = $register->cm_email;
            //$email = "chaitali.fartade@mulikainfotech.com";
            
            $subject = "Complaint Follow up";
            $mail_res = $this->_send_smtp_email($email, $from,$subject, $mailContent);
            
            $mail_data = array('mail_id'=>$email,'mail_body'=>$mailContent,'mail_datetime'=>date('Y-m-d H:i:s'),'mail_res'=>$mail_res);
             file_put_contents('./logs/'.date("Y-m-d").'/104_mail_res.log', json_encode($mail_data)."\r\n", FILE_APPEND);

            
            }
          }
        }

        if ($shiftmanager) {

            $this->output->status = 1;
            $this->output->closepopup = "yes";
            $this->output->message = "<p>Details saved Successfully.</p><script>window.location.reload(true);</script>";
            $this->output->moveto = 'top';

           // $this->output->add_to_position('', 'content', TRUE);
        }
    }
}
