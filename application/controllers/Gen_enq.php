<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gen_enq extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->load->model(array('Gen_enq_model', 'colleagues_model', 'inc_model', 'call_model'));

        $this->load->helper(array('url', 'comman_helper'));

        $this->post = $this->input->get_post(NULL);

        $this->clg = $this->session->userdata('current_user');

        $this->post['base_month'] = get_base_month();
    }

    public function index($generated = false) {

        echo "This is General Enquiry Call controller";
    }

    /////////////////MI44/////////////////////
    //
    // Purpose : To Confirm test details.
    //
    /////////////////////////////////////

    function confirm_save() {

        //$this->session->unset_userdata('tst_details');
       // $this->session->unset_userdata('call_id');

        $inc_details = $this->input->get_post('incient');

        $inc_id = $this->session->userdata('inc_ref_id');
//        if ($inc_id == '') {
//            $inc_id = generate_inc_ref_id();
//            
//            $this->session->set_userdata('inc_ref_id', $inc_id);
//            update_inc_ref_id($inc_id);
//        }
        if ($inc_id == '' && $this->clg->clg_group != 'UG-BIKE-ERO') {
            $inc_id = generate_inc_ref_id();
            $this->session->set_userdata('inc_ref_id', $inc_id);
            update_inc_ref_id($inc_id);
            
        }else if($this->clg->clg_group == 'UG-BIKE-ERO'){
                 $inc_id = "BK-".generate_bk_inc_ref_id();
                 $this->session->set_userdata('inc_ref_id', $inc_id);
                update_inc_ref_id($inc_id);
        }

        $data['inc_ref_id'] = $inc_id;
     
       

        $data = array(
            'tcl_base_month' => $this->post['base_month'],
            'tcl_cl_id' => $this->post['call_id'],
            'tcl_clr_id' => $this->post['caller_id'],
//            'tcl_ero_note' => $this->post['test_notes'],
            'tcl_date' => date('Y-m-d H:i:s'),
            'inc_ref_id' => $inc_id,
            'tcl_added_by' => $this->clg->clg_ref_id,
        );

        $this->session->set_userdata('tst_details', $data);


        $test_inc = array(
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
        //var_dump($test_inc);

        $this->session->set_userdata('test_incidence_details', $test_inc);
        $data1['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $inc_details['inc_ero_standard_summary']));
        
        $data['re_name'] =$data1['standard_remark'][0]->re_name;
        $data['inc_ero_summary'] = $inc_details['inc_ero_summary'];
        

        $this->output->add_to_popup($this->load->view('frontend/gen_enq/confirm_gen_enq_view', $data, TRUE), '600', '250');
    }

    //// Created by MI44 ////////////////////
    // 
    // Purpose : To save and forword test details.
    // 
    /////////////////////////////////////////

    function save() {
        //var_dump($this->session->userdata('tst_details'));die;
//var_dump($this->post['gen_enq_form']);die;
        if ($this->session->userdata('tst_details')) {

            $args = $this->session->userdata('tst_details');
            
            $inc_id = $this->session->userdata('inc_ref_id');
        
            $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_id));
            if(!empty($is_exits)){
                    $this->session->set_userdata('inc_ref_id','');
                   $this->output->add_to_position("<script>alert('Incident Id already exists !! Cancel and dispatch again')</script>", 'custom_script', TRUE);
            }

            $tcl_id = $this->Gen_enq_model->insert_gen_enq($args);

            $inc_args = $this->session->userdata('test_incidence_details');

            $inc_data = $this->inc_model->insert_inc($inc_args);
            $inc_id = $inc_args['inc_ref_id'];
            //update_inc_ref_id($inc_id);


            $args = array(
                'sub_id' => $tcl_id,
                'operator_id' => $this->clg->clg_ref_id,
                'operator_type' => $this->clg->clg_group,
                'base_month' => $this->post['base_month'],
                'sub_type' => 'GEN_ENQ'
            );

            $res = $this->common_model->assign_operator($args);


            //////////////////////forword///////////////////////


            if ($this->post['forword'] != '' && $this->clg->clg_senior != 'NA') {

                $get_parent = $this->common_model->select_senior($args);

                $args['operator_id'] = $this->clg->clg_senior;

                $args['operator_type'] = $get_parent[0]->clg_group;

                $res = $this->common_model->assign_operator($args);
            }


            //////////////////////////////////////////////////////            

            if ($inc_data) {

                $this->output->status = 1;

                $this->output->closepopup = "yes";
                $url = base_url("calls");
                $this->output->message = "<h3>General Enquiry Call</h3><br><p>General Enquiry Successfully added.</p><script>window.location.href = '".$url."';</script>";

                $this->output->moveto = 'top';

                $this->output->add_to_position('', 'content', TRUE);
            }
        }
    }

}
