<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transfercall extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->load->model(array('test_model', 'colleagues_model', 'inc_model', 'call_model', 'transfer_call_model'));

        $this->load->helper(array('url', 'comman_helper'));

        $this->post = $this->input->get_post(NULL);

        $this->clg = $this->session->userdata('current_user');

        $this->post['base_month'] = get_base_month();
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

        $this->session->unset_userdata('transfer_call_details');
        $this->session->unset_userdata('call_id');


        $inc_details = $this->input->get_post('incient');

        $inc_id = $this->session->userdata('inc_ref_id');
        if ($inc_id == '') {
            $inc_id = generate_inc_ref_id();
            update_inc_ref_id($inc_id);
            $this->session->set_userdata('inc_ref_id', $inc_id);
        }

        $data['inc_ref_id'] = $inc_id;

        $data = array(
            'trcl_base_month' => $this->post['base_month'],
            'trcl_cl_id' => $this->post['call_id'],
            'trcl_clr_id' => $this->post['caller_id'],
            'trcl_date' => date('Y-m-d H:i:s'),
            'trcl_inc_ref_id' => $inc_id,
            'trcl_added_by' => $this->clg->clg_ref_id,
            'trclis_deleted' => '0'
        );

        $this->session->set_userdata('transfer_call_details', $data);


        $call_inc = array(
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
            'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
        );


        $this->session->set_userdata('call_incidence_details', $call_inc);
        $data1['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inc_details['inc_ero_standard_summary']));

        $data['re_name'] = $data1['standard_remark'][0]->re_name;
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];

        $this->output->add_to_popup($this->load->view('frontend/trans_calls/confirm_call_view', $data, TRUE), '600', '250');
    }

    //// Created by MI44 ////////////////////
    // 
    // Purpose : To save and forword test details.
    // 
    /////////////////////////////////////////

    function save() {



        $args = $this->session->userdata('transfer_call_details');
         $inc_args = $this->session->userdata('call_incidence_details');
        
        $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_args['inc_ref_id']));
        if(!empty($is_exits)){
             $this->session->set_userdata('inc_ref_id','');
            $this->output->message = "<div class='error'>Incident Id alredy exists</div>";
            return;
        }

        $trcl_id = $this->transfer_call_model->insert_transfer_call($args);

       

        $inc_data = $this->inc_model->insert_inc($inc_args);
          $inc_id = $inc_args['inc_ref_id'];
           // update_inc_ref_id($inc_id);


        $args = array(
            'sub_id' => $trcl_id,
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'base_month' => $this->post['base_month'],
            'sub_type' => 'CALL_TRANS_104'
        );

        $res = $this->common_model->assign_operator($args);

            

        if ($inc_data) {

            $this->output->status = 1;

            $this->output->closepopup = "yes";

            $url = base_url("calls");
            $this->output->message = "<h3>Transfer Call To 104</h3><script>window.location.href = '".$url."';</script>";

            $this->output->moveto = 'top';

            $this->output->add_to_position('', 'content', TRUE);
        }

    }
    
     function confirm_108_save() {

        $this->session->unset_userdata('transfer_call_details');
        $this->session->unset_userdata('call_id');


        $inc_details = $this->input->get_post('incient');
      

        $inc_id = $this->session->userdata('inc_ref_id');
        if ($inc_id == '') {
            $inc_id = generate_inc_ref_id();
            $this->session->set_userdata('inc_ref_id', $inc_id);
        }

        $data['inc_ref_id'] = $inc_id;

        $data = array(
            'trcl_base_month' => $this->post['base_month'],
            'trcl_cl_id' => $this->post['call_id'],
            'trcl_clr_id' => $this->post['caller_id'],
            'trcl_date' => date('Y-m-d H:i:s'),
            'trcl_inc_ref_id' => $inc_id,
            'trcl_added_by' => $this->clg->clg_ref_id,
            'trclis_deleted' => '0'
        );

        $this->session->set_userdata('transfer_call_details', $data);


        $call_inc = array(
            'inc_ref_id' => $inc_id,
            'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
            'inc_ero_summary' => $inc_details['inc_ero_summary'],
            'inc_base_month' => $this->post['base_month'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_datetime' => date('Y-m-d H:i:s'),
            'inc_dispatch_time' => $inc_details['caller_dis_timer'],
            'inc_recive_time' => $inc_details['inc_recive_time'],
            'inc_type' => $inc_details['inc_type'],
            'inc_cl_id' => $this->post['call_id']
        );


        $this->session->set_userdata('call_incidence_details', $call_inc);
        $data1['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inc_details['inc_ero_standard_summary']));

        $data['re_name'] = $data1['standard_remark'][0]->re_name;
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];

        $this->output->add_to_popup($this->load->view('frontend/trans_calls/confirm_108_call_view', $data, TRUE), '600', '250');
    }

}
