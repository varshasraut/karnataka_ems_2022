<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Complaint extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->load->library(array('session', 'modules'));

        $this->load->model(array('cmplnt_model', 'Pet_model'));

        $this->load->helper(array('url', 'comman_helper'));

        $this->post = $this->input->get_post(NULL);

        $this->clg = $this->session->userdata('current_user');

        $this->post['base_month'] = get_base_month();
    }

    public function index($generated = false) {

        echo "This is Complaint controller";
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To confirm complaint details.
    // 
    /////////////////////////////////////////


    function confirm_save() {


        $this->session->unset_userdata('com_details');

        $data = array(
            'cmpl_type' => $this->post['cmp_type'],
            'cmpl_cl_id' => $this->post['call_id'],
            'cmpl_inc_id' => $this->post['increfid'],
            'cmpl_details' => $this->post['cmp_details'],
            'cmpl_base_month' => $this->post['base_month']
        );


        $this->session->set_userdata('com_details', $data);



        /////////////////////////////////////////////////////////////////////

        $data['cmpl'] = $this->cmplnt_model->get_cct_type(array('cct_id' => $this->post['cmp_type']));

        /////////////////////////////////////////////////////////////////////

        $args = array(
            'inc_ref_id' => $this->post['increfid'],
            'base_month' => $this->post['base_month']
        );


        $data['pt_info'] = $this->Pet_model->get_ptinc_info($args);

        $this->output->add_to_popup($this->load->view('frontend/complaint/confirm_com_view', $data, TRUE), '600', '560');
        $this->output->add_to_position($this->load->view('frontend/patient/pt_inc_summary_view', $data, TRUE), 'summary_div', TRUE);
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To save complaint details.
    // 
    /////////////////////////////////////////

    function save() {


        if ($this->post['fwd_com_call']) {

            $args = $this->session->userdata('com_details');

            $cmp_id = $this->cmplnt_model->add($args);

            $this->session->unset_userdata('com_details');

            //////////////////////////////////////////////////////

            $args = array(
                'sub_id' => $cmp_id,
                'operator_id' => $this->clg->clg_ref_id,
                'operator_type' => $this->clg->clg_group,
                'base_month' => $this->post['base_month'],
                'tahshil' => $this->post['tah_id'],
                'sub_type' => 'COM'
            );


            $res = $this->common_model->assign_operator($args);


            if ($res) {

                $this->output->status = 1;

                $this->output->closepopup = "yes";

                $this->output->message = "<h3>Complaint Call</h3><br><p>Call details forwarded successfully.</p><script>window.location.reload(true);</script>";

                $this->output->moveto = 'top';

                $this->output->add_to_position('', 'content', TRUE);
            
            }
        }
    }

}
