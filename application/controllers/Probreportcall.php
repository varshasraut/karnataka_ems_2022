<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Probreportcall extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->load->model(array('test_model', 'colleagues_model', 'inc_model', 'call_model', 'problem_reporting_model'));

        $this->load->helper(array('url', 'comman_helper'));

        $this->post = $this->input->get_post(NULL);

        $this->clg = $this->session->userdata('current_user');

        $this->post['base_month'] = get_base_month();
    }

    public function index($generated = false) {

        echo "This is Problem Reporting call controller";
    }

    /////////////////MI44/////////////////////
    //
    // Purpose : To Confirm test details.
    //
    /////////////////////////////////////

    function confirm_save() {

        $this->session->unset_userdata('prob_report_details');
        $this->session->unset_userdata('call_id');


        $inc_details = $this->input->get_post('incient');
        $forword = $this->input->get_post('forword');
        
        $inc_id = $this->session->userdata('inc_ref_id');

        if ($inc_id == '') {
            $inc_id = generate_inc_ref_id();
            $this->session->set_userdata('inc_ref_id', $inc_id);
            update_inc_ref_id($inc_id);
        }

        $data['inc_ref_id'] = $inc_id;
        
                
        $data = array(
            'rcl_base_month' => $this->post['base_month'],
            'rcl_cl_id' => $this->post['call_id'],
            'rcl_clr_id' => $this->post['caller_id'],
            'rcl_date' => date('Y-m-d H:i:s'),
            'rcl_inc_ref_id' => $inc_id,
            'rcl_added_by' => $this->clg->clg_ref_id,
            'rcl_standard' => $this->post['rcl_standard'],
        );

        $this->session->set_userdata('prob_report_details', $data);


        $report_inc = array(
            'inc_ref_id' => $inc_id,
            'inc_ero_standard_summary' =>  $this->post['rcl_standard'],
            'inc_ero_summary' => $inc_details['inc_ero_standard_summary'],
            'inc_remark'=> $inc_details['inc_ero_summary'],
            'inc_base_month' => $this->post['base_month'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_datetime' => date('Y-m-d H:i:s'),
            'inc_dispatch_time' => $inc_details['caller_dis_timer'],
            'inc_recive_time' => $inc_details['inc_recive_time'],
            'inc_type' => $inc_details['inc_type'],
            'inc_cl_id' => $this->post['call_id'],
            'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
        );

        //var_dump($inc_details);die();

        $this->session->set_userdata('report_incidence_details', $report_inc);
       // $data1['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inc_details['inc_ero_standard_summary']));

        $data['forword'] = $forword;
        $data['re_name'] = $inc_details['inc_ero_standard_summary'];
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];

        $this->output->add_to_popup($this->load->view('frontend/prob_report_calls/confirm_report_view', $data, TRUE), '600', '250');
    }

    //// Created by MI44 ////////////////////
    // 
    // Purpose : To save and forword test details.
    // 
    /////////////////////////////////////////

    function save() {

//        if ($this->post['fwd_test_call']) {

        $args = $this->session->userdata('prob_report_details');



        $rcl_id = $this->problem_reporting_model->insert_prob_report($args);

        $inc_args = $this->session->userdata('report_incidence_details');
        
        $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_args['inc_ref_id']));
        if(!empty($is_exits)){
            $this->output->message = "<div class='error'>Incident Id alredy exists</div>";
            return;
        }

        $inc_data = $this->inc_model->insert_inc($inc_args);

        $inc_id = $inc_args['inc_ref_id'];
       

        $arg = array(
            'sub_id' => $rcl_id,
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'base_month' => $this->post['base_month'],
            'sub_type' => 'PRO_REP_SER'
        );
       
        $res = $this->common_model->assign_operator($arg);
        //////////////////////forword///////////////////////


        if ($this->post['fwd_all'] == 'yes') {


            $police_user = $this->inc_model->get_fire_user($sr_user, 'UG-Grievance');
            if($police_user){

                $police_operator2 = array(
                    'sub_id' => $inc_id,
                    'operator_id' => $police_user->clg_ref_id,
                    'operator_type' => 'UG-Grievance',
                    'sub_status' => 'ASG',
                    'sub_type' => $inc_args['inc_type'],
                    'base_month' => $this->post['base_month']
                );

                $police_operator = $this->common_model->assign_operator($police_operator2);
            }
        }


        //////////////////////////////////////////////////////            

        if ($inc_data) {

            $this->output->status = 1;

            $this->output->closepopup = "yes";
            $url = base_url("calls");
            $this->output->message = "<h3>Problem Reporting Call</h3><br><p>Problem reporting details forwarded successfully.</p><script>window.location.href = '".$url."';</script>";

            $this->output->moveto = 'top';

            $this->output->add_to_position('', 'content', TRUE);
        }
//        }
    }

}
