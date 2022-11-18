<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sam_dash extends EMS_Controller {

    function __construct() {
        parent::__construct();
        $this->active_module = "M-SM-DASH";

        $this->load->model(array('dashboard_model', 'users_model', 'amb_model', 'student_model', 'cluster_model', 'school_model', 'inc_model', 'inv_model', 'eqp_model', 'call_model','colleagues_model'));

        $this->pg_limit = $this->config->item('pagination_limit');
        $this->clg = $this->session->userdata('current_user');
    }
    public function index($generated = false)
    {
        echo "This Is Samruddhi Mahamarg Dashboard";
    }

   
    function maha_dash() {
        // var_dump('hii');die;
        $clg_group = $this->clg->clg_group;
        $ref_id = get_cookie("username");
        
        $current_user = $this->colleagues_model->get_user_info($ref_id);

        $data = array();

        $data['user_group'] = $current_user[0]->clg_group;
        $data['ref_id_encode'] = base64_encode($ref_id);
        $this->output->add_to_position($this->load->view('frontend/sm_dashboard/sm_dash_view', $data, true));
        $this->output->template = "maha_marg";    }

 

}
