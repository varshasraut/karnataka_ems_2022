<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Support extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->load->model(array('support_model'));

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

        $this->output->add_to_position($this->load->view('frontend/support/answer_view', $data, TRUE), 'get_answer', TRUE);
    }

    //////////////////MI42////////////////////
    //
    // Purpose : Enquiry confirm details.
    //
    /////////////////////////////////////

    function confirm_save() {

        /////////////////////////////////////////////////////////

        $this->session->unset_userdata('enq_details');

        $data = array(
            'support_que' => implode(',', $this->post['que']),
            'support_base_month' => $this->post['base_month'],
            'support_date' => date('Y-m-d H:i:s'),
            'enqis_deleted' => '0'
        );

        //////////Question are Other /////////////////////           

        if (in_array("166", $this->post['que'])) {
            $data['enq_other_que'] = $this->post['other_que'];
        }

        $this->session->set_userdata('support_details', $data);
        $data['forword'] = $this->post['forword'];

        //////////////////////////////////////////////////////////////

        $lang = get_lang($this->post['lang']);
        $data['enq_que'] = array();
        $q = 0;

        if(is_array($this->post['que'])){
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

        $this->output->add_to_popup($this->load->view('frontend/support/confirm_support_view', $data, TRUE), '600', '350');
    }

    ////////////////////MI44//////////////////
    //
    // Purpose : Enquiry save and forword 
    //
    ////////////////////////////////////////


    function save_and_forword() {

            $args = $this->session->userdata('support_details');
            $enq_id = $this->support_model->insert_support_enquiry($args);

            $this->session->unset_userdata('support_details');

            /////////////////////////////////////////////////////


            $args = array(
                'sub_id' => $enq_id,
                'operator_id' => $this->clg->clg_ref_id,
                'operator_type' => $this->clg->clg_group,
                'base_month' => $this->post['base_month'],
                'sub_type' => 'SUPPORT'
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

            if ($res) {

                $this->output->status = 1;

                $this->output->closepopup = "yes";

                ($this->post['forword'] != '') ? $msg = "forworded" : $msg = "save";

                $this->output->message = "<h3>Support Call</h3><br><p>Support details " . $msg . " successfully.</p><script>start_incoming_call();</script>";
                
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

        $data['get_question'] = $this->common_model->get_question(array('que_type' => 'Support'));

        $data['emr_details'] = $this->common_model->emergency_details(array('oname' => 'ms_about_108'));

        $this->output->add_to_position($this->load->view('frontend/support/support_form_view', $data, TRUE), 'content', TRUE);
    }

}
