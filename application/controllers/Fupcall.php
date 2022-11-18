<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Fupcall extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->load->library(array('session', 'modules'));

        $this->load->model(array('fupcall_model', 'Pet_model','inc_model','call_model'));

        $this->load->helper(array('url', 'comman_helper'));

        $this->post = $this->input->get_post(NULL);

        $this->clg = $this->session->userdata('current_user');

        $this->post['base_month'] = get_base_month();

        $this->today = date('Y-m-d H:i:s');
        $this->default_state = $this->config->item('default_state');
    }

    public function index($generated = false) {

        echo "This is Follow up Call controller";
    }

    //// Created by MI42 //////////////////////////
    // 
    // Purpose : To confirm follow up call details.
    // 
    //////////////////////////////////////////////

    function confirm_save() {


        $this->session->unset_userdata('fupcall_details');
        
         $inc_details = $this->input->get_post('incient');

        $inc_id = $this->session->userdata('inc_ref_id');
        
        if ($inc_id == '') {
            $inc_id = generate_inc_ref_id();
            
            $this->session->set_userdata('inc_ref_id', $inc_id);
            update_inc_ref_id($inc_id);
        }

        $data['inc_ref_id'] = $inc_id;

        $data = array(
            'fcl_inc_id' => $inc_id,
            'fcl_amb_rto_register_no' => $this->post['ambregno'],
            'fcl_base_month' => $this->post['base_month'],
            'fcl_date' => $this->today,
            'fcl_added_by' => $this->clg->clg_ref_id,
            'fcl_cl_id' => $this->post['call_id'],
            'fcl_clr_id' => $this->post['caller_id'],
        );

        $this->session->set_userdata('fupcall_details', $data);


        /////////////////////////////////////////////////////////////////////

        $args = array(
            'inc_ref_id' => $this->post['increfid'],
            'base_month' => $this->post['base_month']
        );


        $data['pt_info'] = $this->Pet_model->get_ptinc_info($args);

        $data['ambdtl'] = true;

        $foll_inc = array(
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
            'pre_inc_ref_id' => $this->post['increfid'],
            'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
        );


        $this->session->set_userdata('foll_incidence_details', $foll_inc);
        $data1['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inc_details['inc_ero_standard_summary']));

        $data['re_name'] = $data1['standard_remark'][0]->re_name;
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];

        $this->output->add_to_popup($this->load->view('frontend/fupcall/confirm_fucall_view', $data, TRUE), '600', '650');
        $this->output->add_to_position($this->load->view('frontend/patient/pt_inc_summary_view', $data, TRUE), 'summary_div', TRUE);
    }

    //// Created by MI42 //////////////////////////
    // 
    // Purpose : To save follow up call  details.
    // 
    //////////////////////////////////////////////

    function save() {


        if ($this->post['fwd_fupcall_call']) {
            
            $inc_id = $this->session->userdata('inc_ref_id');
        
            $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_id));
            if(!empty($is_exits)){
                $this->session->set_userdata('inc_ref_id','');
                $this->output->add_to_position("<script>alert('Incident Id already exists !! Cancel and dispatch again')</script>", 'custom_script', TRUE);
            }


            $args = $this->session->userdata('fupcall_details');

            $id = $this->fupcall_model->add($args);

            $inc_args = $this->session->userdata('foll_incidence_details');

            $inc_data = $this->inc_model->insert_inc($inc_args);
              $inc_id = $inc_args['inc_ref_id'];
            //update_inc_ref_id($inc_id);
            
            $this->session->unset_userdata('fupcall_details');




            $args = array(
                'sub_id' => $id,
                'operator_id' => $this->clg->clg_ref_id,
                'operator_type' => $this->clg->clg_group,
                'base_month' => $this->post['base_month'],
                'sub_type' => 'FOLC'
            );


            $res = $this->common_model->assign_operator($args);




            if ($inc_data) {

                $this->output->status = 1;

                $this->output->closepopup = "yes";
                $url = base_url("calls");

                $this->output->message = "<h3>Followup Call</h3><br><p>Call details forwarded successfully.</p><script>window.location.href = '".$url."';</script>";

                $this->output->moveto = 'top';

                $this->output->add_to_position('', 'content', TRUE);
            }
        }
    }

}
