<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ercpcall extends EMS_Controller {

    function __construct() {

        parent::__construct();


        $this->load->model(array('Ercp_model'));

        $this->load->helper(array('url', 'comman_helper'));

        $this->load->library(array('session', 'modules'));

        $this->clg = $this->session->userdata('current_user');

        $this->post = $this->input->get_post(NULL);

        $this->post['base_month'] = get_base_month();

        $this->today = date('Y-m-d H:i:s');
    }

    public function index($generated = false) {

        echo "This is Ercp call controller";
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To load info of ero call details
    // 
    /////////////////////////////////////////

    function call_details() {


        $data['opt_id'] = $this->post['opt_id'];

        $data['sub_id'] = $this->post['sub_id'];



        //////////////////////////////////////////////////////////////


        $args = array('opt_id' => $data['opt_id'],
            'sub_id' => $data['sub_id'],
            'sub_status' => 'ATNG',
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


        //////////////////////////////////////////////////////////////


        $args = array(
            'opt_id' => $data['opt_id'],
            'base_month' => $this->post['base_month']
        );

        $data['cl_dtl'] = $this->Ercp_model->call_detials($args);


        ////////////////////////////////////////////////////////////////

        $this->output->add_to_position($this->load->view('frontend/ercp_calls/amb_details_view', $data, TRUE), 'content', TRUE);

        $this->output->add_to_position($this->load->view('frontend/ercp_calls/inc_details_view', $data, TRUE), 'content', TRUE);
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To load advice Ans.
    // 
    /////////////////////////////////////////

    function get_madv_ans() {

        $ans = $this->common_model->get_answer(array('ans_que_id' => $this->post['que_id']));

        $que = $this->common_model->get_question(array('que_id' => $this->post['que_id']));

        $prepared_ans = "<p>" . $que[0]->que_question . "</p>" . $ans[0]->ans_answer;

        $this->output->add_to_position($prepared_ans, 'madv_ans', TRUE);
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To save advice details.
    // 
    /////////////////////////////////////////

    function save() {

        $args = array('cl_ercp_id' => $this->clg->clg_ref_id,
            'cl_base_month' => $this->post['base_month'],
            'cl_date' => $this->today
        );

        $args = array_merge($this->post['cdata'], $args);

        $res = $this->Ercp_model->add($args);

        //////////////////////////////////////////////

        $args = array('opt_id' => $this->clg->clg_ref_id,
            'sub_id' => $this->post['cdata']['sub_id'],
            'sub_type' => 'ADV'
        );

        update_opt_status($args);

        //////////////////////////////////////////////

        if ($res) {

            $this->output->message = "<div class='success'>Details saved successfully<script>start_incoming_call();</script></div>";

            $this->output->add_to_position('', 'content', TRUE);
        }
    }

}
