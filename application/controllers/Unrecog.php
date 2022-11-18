<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Unrecog extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->load->model(array('unrecog_model'));

        $this->load->helper(array('url', 'comman_helper'));

        $this->post = $this->input->get_post(NULL);

        $this->clg = $this->session->userdata('current_user');

        $this->post['base_month'] = get_base_month();
    }

    public function index($generated = false) {

        echo "This is Unrecognized controller";
    }

    //////////////////////////////////////////////////
    //
    // Purpose : To Confirm unrecognized call details.
    //
    /////////////////////////////////////////////////

    function confirm_save() {

        $this->session->unset_userdata('unrec_details');

        $data = array(
            'ucl_base_month' => $this->post['base_month'],
            'ucl_cl_id' => $this->post['call_id'],
            'ucl_ero_note' => $this->post['ero_notes'],
            'ucl_cl_type' => $this->post['cl_type'],
            'ucl_date' => date('Y-m-d H:i:s'),
        );

        $this->session->set_userdata('unrec_details', $data);

        $data['cl_type'] = $this->common_model->get_call_type(array('cl_id' => $this->post['cl_type']));

        $this->output->add_to_popup($this->load->view('frontend/unrecog/confirm_unrec_view', $data, TRUE), '600', '250');
    }

    //////////////MI44////////////////
    //
    //Purpose :Add unrecognized call
    //
    ///////////////////////////////////


    function save() {


        if ($this->post['fwd_unrec_call']) {

            $args = $this->session->userdata('unrec_details');

            $cl_id = $this->unrecog_model->add($args);

            $args = array(
                'sub_id' => $cl_id,
                'operator_id' => $this->clg->clg_ref_id,
                'operator_type' => $this->clg->clg_group,
                'base_month' => $this->post['base_month'],
                'sub_type' => 'UNREC'
            );

            $res = $this->common_model->assign_operator($args);

            if ($res) {

                $this->output->status = 1;

                $this->output->closepopup = "yes";

                $this->output->message = "<h3>Unrecognized Call</h3><br><p>Unrecognized call forwarded successfully.</p><script>start_incoming_call();</script>";

                $this->output->moveto = 'top';

                $this->output->add_to_position('', 'content', TRUE);
            }
        }
    }

}
