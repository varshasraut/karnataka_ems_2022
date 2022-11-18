<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Enquiry extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->load->model(array('enquiry_model', 'inc_model'));

        $this->load->helper(array('url', 'comman_helper', 'language_helper'));

        $this->post = $this->input->get_post(NULL);

        $this->clg = $this->session->userdata('current_user');

        $this->post['base_month'] = get_base_month();
    }

    public function index($generated = false) {

        echo "This is Enquiry controller";
    }

    //// Created by MI44 ////////////////////
    // 
    // Purpose : To get_answer.
    // 
    /////////////////////////////////////////

    function get_answer() {

        $args = array('ans_que_id' => $this->post['que']);

        $data['lang'] = $this->post['lang'];

        $data['answer'] = $this->common_model->get_answer($args);

        $this->output->add_to_position($this->load->view('frontend/enq/answer_view', $data, TRUE), 'get_answer', TRUE);
    }
    
    function check_question() {

        $args = array('ans_que_id' => $this->post['que']);

        $data['lang'] = $this->post['lang'];
        //var_dump($this->input->post());
        //die();
        

        $data['answer'] = $this->common_model->get_answer($args);

        $this->output->add_to_position($this->load->view('frontend/enq/answer_view', $data, TRUE), 'get_answer', TRUE);
    }

    //////////////////MI42////////////////////
    //
    // Purpose : Enquiry confirm details.
    //
    /////////////////////////////////////

    function confirm_save() {

        /////////////////////////////////////////////////////////

        $this->session->unset_userdata('enq_details');
           $this->session->unset_userdata('call_id');

        $inc_details = $this->input->get_post('incient');
        

        $inc_id = $this->session->userdata('inc_ref_id');
//        if ($inc_id == '') {
//            $inc_id = generate_inc_ref_id();
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
            'enq_que' => implode(',', $this->post['que']),
            'enq_base_month' => $this->post['base_month'],
            'enq_date' => date('Y-m-d H:i:s'),
            'enqis_deleted' => '0',
            'enq_inc_ref_id' => $inc_id,
            'enq_added_by' => $this->clg->clg_ref_id,
            'enq_lang' => $this->post['lang']
        );

        //////////Question are Other /////////////////////           

        if (in_array("166", $this->post['que'])) {
            $data['enq_other_que'] = $this->post['other_que'];
        }

        $this->session->set_userdata('enq_details', $data);


        $inc = array(
            'inc_ref_id' => $inc_id,
            'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
            'inc_ero_summary' => $inc_details['inc_ero_summary'],
            'inc_base_month' => $this->post['base_month'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_datetime' => date('Y-m-d H:i:s'),
            'inc_dispatch_time'=>$inc_details['caller_dis_timer'],
            'inc_recive_time'=>$inc_details['inc_recive_time'],
            'inc_type' => $inc_details['inc_type'],
            'inc_cl_id' => $this->post['call_id'],
            'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
        );

        $this->session->set_userdata('incidence_details', $inc);


        $data['forword'] = $this->post['forword'];

        //////////////////////////////////////////////////////////////

        $lang = get_lang($this->post['lang']);
        $data['enq_que'] = array();
        $q = 0;

        if (is_array($this->post['que'])) {
            foreach ($this->post['que'] as $que) {

                $enq_que = $this->common_model->get_question(array('que_id' => $que));

                $serialize_que = $enq_que[0]->que_question;

                $data['enq_que'][$q]['que'] = get_lang_data($serialize_que, $lang);

                $ans = $this->common_model->get_answer(array('ans_que_id' => $que));

                $serialize_ans = $ans[0]->ans_answer;

                $data['enq_que'][$q]['ans'] = get_lang_data($serialize_ans, $lang);

                $data['enq_que'][$q]['que_id'] = $que;

                $q++;
            }
        }


        $this->output->add_to_popup($this->load->view('frontend/enq/confirm_enq_view', $data, TRUE), '600', '350');
    }

    ////////////////////MI44//////////////////
    //
    // Purpose : Enquiry save and forword 
    //
    ////////////////////////////////////////


    function save_and_forword() {

        $args = $this->session->userdata('enq_details');

        $inc_args = $this->session->userdata('incidence_details');
        
        $inc_id = $this->session->userdata('inc_ref_id');
        
        $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_id));
        if(!empty($is_exits)){
                $this->session->set_userdata('inc_ref_id','');
                $this->output->message = "<div class='error'>Incident Id alredy exists</div>";
                return;
        }

        $inc_data = $this->inc_model->insert_inc($inc_args);
          $inc_id = $inc_args['inc_ref_id'];
          //update_inc_ref_id($inc_id);

        $enq_id = $this->enquiry_model->insert_enquiry($args);

        $this->session->unset_userdata('enq_details');

        /////////////////////////////////////////////////////


        $args = array(
            'sub_id' => $enq_id,
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'base_month' => $this->post['base_month'],
            'sub_type' => 'ENQ'
        );


        $res = $this->common_model->assign_operator($args);

        /////////////////////////forword/////////////////////////

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

            ($this->post['forword'] != '') ? $msg = "forworded" : $msg = "save";

            $url = base_url("calls");
            $this->output->message = "<h3>Enquiry Call</h3><br><p>Enquiry details " . $msg . " successfully.</p><script>window.location.href = '".$url."';</script>";

            $this->output->moveto = 'top';

            $this->output->add_to_position('', 'content', TRUE);
        }
    }

    ///////////MI44/////////////////////////
    //
    //Purpose : enquiry call change lang
    //
    ////////////////////////////////////////

    function chng_lang() {

        $data['cookie_ques_id'] = $_COOKIE['set_question'];

        $data['lang'] = $this->post['lang'];
        $current_user_group=$this->session->userdata['current_user']->clg_group;
       // if($current_user_group=='UG-ERO'){
            $system="108";
        //}else{
        //    $system="102";
        //}
       
        if($system == "108"){
        $data['emr_details'] = $this->common_model->emergency_details(array('oname' => 'ms_about_108'));
        $data['get_question'] = $this->common_model->get_question(array('que_type' => 'enq_108'));
        }else{
        $data['emr_details'] = $this->common_model->emergency_details(array('oname' => 'ms_about_102'));   
        $data['get_question'] = $this->common_model->get_question(array('que_type' => 'enq_102'));
        }

        //$data['get_question'] = $this->common_model->get_question(array('que_type' => 'enq'));

        //$data['emr_details'] = $this->common_model->emergency_details(array('oname' => 'ms_about_108'));

        $this->output->add_to_position($this->load->view('frontend/enq/enq_form_view', $data, TRUE), 'content', TRUE);
    }

}
