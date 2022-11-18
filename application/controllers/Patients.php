<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Patients extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->active_module = "M-PATIENTS";

        $this->pg_limit = $this->config->item('pagination_limit_clg');

        $this->load->library(array('session', 'modules'));

        $this->load->model(array('module_model', 'Pet_model', 'inc_model','call_model','amb_model'));

        $this->load->helper(array('comman_helper'));

        $this->post = $this->input->get_post(NULL);

        $this->post['base_month'] = get_base_month();

        $this->dtmf = "00:00:00";

        $this->dtmt = "24:00:00";
    }

    public function index($generated = false) {
        echo "You are in the Patients controllers";
    }

    //// Created by MI42 ///////////////////////
    // 
    // Purpose : To get patient incident list.
    // 
    ////////////////////////////////////////////

    function pt_inc_list() {

//        $inc_args = array(
//            'inc_ref_id' => $this->post['inc_id'],
//            'base_month' => $this->post['base_month'],
//        );
//
//        $data['inc_data'] = $this->call_model->get_inc_type($inc_args);
//
//        $inc_type = $data['inc_data'][0]->inc_type;
//
//        $call_name = $data['inc_data'][0]->pname;
//
//
//
//        if ($inc_type != 'IN_HO_P_TR' && $inc_type != 'MCI' && $inc_type != 'NON_MCI' && $inc_type != 'AD_SUP_REQ' && $inc_type != 'AD_SUP_REQ') {
//
//            $this->output->message = "<p>Call Type : " . $call_name . "</p><br><p>Follow up call not for " . $call_name . "  </p>.";
//
//            return;
//        }



        //var_dump($this->post['filter']);
        if($this->post['filter'] == 'true'){
            //$this->output->add_to_position($this->load->view('frontend/inc/inc_details_view', $data, TRUE), 'inc_details', TRUE);
            $this->output->add_to_position('', 'inc_details', TRUE);
            $this->output->add_to_position('', 'fwdcmp_btn', TRUE);
            $this->output->add_to_position($this->load->view('frontend/fupcall/fup_inc_filter_view', $data, TRUE), 'inc_filters', TRUE);
            return false;
        }
      
        ////////////////////////// Set inc datetime //////////////////////////

        if (!empty($this->post['inc_time'])) {

            $inctm = get_formated_time($this->post['inc_time']);
            
           if($inctm != '' ){
           
            $this->post['inc_timef'] = $inctm[0];

            $this->post['inc_timet'] = $inctm[1];
           }else{
               $this->post['from_data'] = date('Y-m-d H:i:s');
               $this->post['to_date'] = date('Y-m-d H:i:s', strtotime("-6 hours"));;
           }
            
            
        }else{
            
            $this->post['inc_timef'] = '00:00:00';

            $this->post['inc_timet'] = '23:59:59';
            
            $this->post['from_data'] = date('Y-m-d H:i:s');
           $this->post['to_date'] = date('Y-m-d H:i:s', strtotime("-6 hours"));;
        }
       



        if (!empty($this->post['inc_date']) && empty($this->post['inc_id'])) {

            $this->post['inc_date'] = date('Y-m-d', strtotime($this->post['inc_date']));

            ////////////////////////////////////////////////////////////////////////////

            $this->post['inc_datef'] = $this->post['inc_date'] . " " . $this->post['inc_timef'];

            $this->post['inc_datet'] = $this->post['inc_date'] . " " . $this->post['inc_timet'];

            ////////////////////////////////////////////////////////////////////////////
        }
        if (!empty($this->post['inc_district']) && empty($this->post['inc_date'])) {

            $this->post['inc_date_time'] = date('Y-m-d');
        }
        if (!empty($this->post['amb_reg_no']) && !empty($this->post['inc_date'])) {

            $this->post['inc_date_time'] = date('Y-m-d');
        }
        if($this->post['cl_purpose'] == 'EMT_MED_AD'){
            $this->post['inc_pcr_status'] = '0';
        }
        //print_r($this->post); die;

        $data['pt_details'] = $this->Pet_model->get_pt_inc_search_list($this->post);

        $this->session->unset_userdata('inc_act');

        $data['cl_purpose'] = $this->post['cl_purpose'];
           // var_dump($this->post['cl_purpose']); die();

        $this->output->add_to_position($this->load->view('frontend/inc/inc_details_view', $data, TRUE), 'inc_details', TRUE);

        $this->output->add_to_position('', 'fwdcmp_btn', TRUE);
    }

    //// Created by MI42 //////////////////////////////
    // 
    // Purpose : To get patient incident inforamation.
    // 
    //////////////////////////////////////////////////

    function pt_inc_info() {


        if ($this->session->userdata('inc_act')['inc_ref_id'] == $this->post['inc_ref_id'] && $this->session->userdata('inc_act')['act'] == 'close') {

            $this->output->add_to_position("", 'inc_pt_info', TRUE);

            $scrpt = "<script>$('.incact').val('SELECT');$('#inc_fwd_note').show();</script>";

            $this->output->add_to_position($scrpt, 'popup_div', TRUE);

            $this->session->unset_userdata('inc_act');

            $this->output->add_to_position('', 'fwdcmp_btn', TRUE);
        } else {



            ////////////////////// Set fowrward buttons as per call type //////////////////////////
           // var_dump($this->post['cl_purpose']); die();

            if ($this->post['cl_purpose'] == 'COMP_CALL') {



                $fwdbtn = "<input name='search_btn' value='FORWARD TO SUPERVISER' class='style4 form-xhttp-request' data-href='" . base_url() . "complaint/confirm_save' output_position='content' type='button' tabindex='14'>";
            } else if ($this->post['cl_purpose'] == 'FEED_CALL') {



                $fwdbtn = "<input name='search_btn' value='FORWARD TO SUPERVISER' class='style4 form-xhttp-request' data-href='" . base_url() . "feedback/confirm_save' output_position='content' type='button' tabindex='24'>";
            } else if ($this->post['cl_purpose'] == 'FOLL_CALL') {

                $data['ambdtl'] = true;

                // $fwdbtn = "<input name='search_btn' value='FORWARD TO SUPERVISER' class='style4 form-xhttp-request' data-href='" . base_url() . "fupcall/confirm_save' type='button' tabindex='14'>";
                $fwdbtn = "<input name='search_btn' value='SAVE' class=' form-xhttp-request' data-href='" . base_url() . "fupcall/confirm_save' type='button' tabindex='14'>";
            }else if($this->post['cl_purpose'] == 'EMT_MED_AD'){
                 $fwdbtn = "<input name='fwd_btn' value='FORWARD TO ERCP' class='style4 form-xhttp-request' data-href='" . base_url() . "medadv/confirm_save' data-qr='output_position=summary_div' type='button' tabindex='8'>";
                 
                 //$this->output->add_to_position($this->load->view('frontend/medadv/med_adv', $data, TRUE), 'adv_pt_info', TRUE);
            } else if($this->post['cl_purpose'] == 'APP_CALL'){
                 $fwdbtn = "<input name='fwd_btn' value='SAVE' class='form-xhttp-request' data-href='" . base_url() . "non_eme_calls/app_confirm_save' data-qr='output_position=summary_div' type='button' tabindex='13' autocomplete='off'>";
                 
                 //$this->output->add_to_position($this->load->view('frontend/medadv/med_adv', $data, TRUE), 'adv_pt_info', TRUE);
            }
            else if($this->post['cl_purpose'] == 'SERVICE_NOT_REQUIRED'){
                 $fwdbtn = "<input name='fwd_btn' value='SAVE' class='form-xhttp-request' data-href='" . base_url() . "non_eme_calls/service_confirm_save' data-qr='output_position=summary_div' type='button' tabindex='13' autocomplete='off'>";
                 
                 //$this->output->add_to_position($this->load->view('frontend/medadv/med_adv', $data, TRUE), 'adv_pt_info', TRUE);
            }
             




            //////////////////////////////////////////////////////////////////////////////



            $inc_act = array('inc_ref_id' => $this->post['inc_ref_id'], 'act' => 'close');

            $this->session->set_userdata('inc_act', $inc_act);

            $args = array(
                'inc_ref_id' => $this->post['inc_ref_id'],
                'base_month' => $this->post['base_month']
            );


            $data['pt_info'] = $this->Pet_model->get_ptinc_info($args);
            $data['inc_amb'] = $this->inc_model->get_inc_ambulance($args);

            $data['increfid'] = $this->post['inc_ref_id'];

            $scrpt = "<script>$('.incact').val('SELECT');$('.inc_act" . $this->post['inc_ref_id'] . "').val('CLOSE'); $('#inc_fwd_note').hide();</script>";


            $this->output->add_to_position($scrpt, 'popup_div', TRUE);

            $this->output->add_to_position($this->load->view('frontend/patient/pt_info_view', $data, TRUE), 'inc_pt_info', TRUE);
             $this->output->add_to_position('', 'inc_fwd_note', TRUE);




            $this->output->add_to_position($fwdbtn, 'fwdcmp_btn', TRUE);
        }
    }
    
    
     function pt_adv_inc_list() {

//        $inc_args = array(
//            'inc_ref_id' => $this->post['inc_id'],
//            'base_month' => $this->post['base_month'],
//        );
//
//        $data['inc_data'] = $this->call_model->get_inc_type($inc_args);
//
//        $inc_type = $data['inc_data'][0]->inc_type;
//
//        $call_name = $data['inc_data'][0]->pname;
//
//
//
//        if ($inc_type != 'IN_HO_P_TR' && $inc_type != 'MCI' && $inc_type != 'NON_MCI' && $inc_type != 'AD_SUP_REQ' && $inc_type != 'AD_SUP_REQ') {
//
//            $this->output->message = "<p>Call Type : " . $call_name . "</p><br><p>Follow up call not for " . $call_name . "  </p>.";
//
//            return;
//        }


        if($this->post['filter'] == 'true'){
            //$this->output->add_to_position($this->load->view('frontend/inc/inc_details_view', $data, TRUE), 'inc_details', TRUE);
            if($this->post['inc_type'] == 'AD_SUP_REQ'){
                $this->output->add_to_position('', 'inc_details', TRUE);
                $this->output->add_to_position('', 'fwdcmp_btn', TRUE);
                
                //$data['get_sevice'] = $this->common_model->get_services();
                $this->output->add_to_position($this->load->view('frontend/resource/resource_filter', $data, TRUE), 'inc_filters', TRUE);
            
                return false;
                
            }else{
                $this->output->add_to_position('', 'inc_details', TRUE);
                $this->output->add_to_position('', 'fwdcmp_btn', TRUE);
                $this->output->add_to_position($this->load->view('frontend/fupcall/fup_inc_filter_view', $data, TRUE), 'inc_filters', TRUE);
                return false;
            }
        }
      
        ////////////////////////// Set inc datetime //////////////////////////

        if (!empty($this->post['inc_time'])) {

            $inctm = get_formated_time($this->post['inc_time']);

            $this->post['inc_timef'] = $inctm[0];

            $this->post['inc_timet'] = $inctm[1];
        }else{
            $this->post['inc_timef'] = '00:00:00';

            $this->post['inc_timet'] = '23:59:59';
        }

       


        if (!empty($this->post['inc_date']) && empty($this->post['inc_id'])) {

            $this->post['inc_date'] = date('Y-m-d', strtotime($this->post['inc_date']));

            ////////////////////////////////////////////////////////////////////////////

            $this->post['inc_datef'] = $this->post['inc_date'] . " " . $this->post['inc_timef'];

            $this->post['inc_datet'] = $this->post['inc_date'] . " " . $this->post['inc_timet'];

            ////////////////////////////////////////////////////////////////////////////
        }
        if (!empty($this->post['inc_district']) && empty($this->post['inc_date'])) {

            $this->post['inc_date_time'] = date('Y-m-d');
        }
        $this->post['inc_pcr_status'] = '0';


        $data['pt_details'] = $this->Pet_model->get_pt_inc_search($this->post);

       $data['resource_type'] = $this->post['resource_type'];
      // var_dump($data['resource_type']);
        $this->session->unset_userdata('inc_act');

        $data['cl_purpose'] = $this->post['cl_purpose'];

        $this->output->add_to_position($this->load->view('frontend/inc/adv_inc_details_view', $data, TRUE), 'inc_details', TRUE);

        $this->output->add_to_position('', 'fwdcmp_btn', TRUE);
    }
    
    
    function pt_adv_inc_info() {


         $data['attend_call_time'] = $this->session->userdata('attend_call_time');
        if ($this->session->userdata('inc_act')['inc_ref_id'] == $this->post['inc_ref_id'] && $this->session->userdata('inc_act')['act'] == 'close') {

            $this->output->add_to_position("", 'inc_pt_info', TRUE);

            $scrpt = "<script>$('.incact').val('SELECT');$('#inc_fwd_note').show();</script>";

            $this->output->add_to_position($scrpt, 'popup_div', TRUE);

            $this->session->unset_userdata('inc_act');

            $this->output->add_to_position('', 'fwdcmp_btn', TRUE);
        } else {



            ////////////////////// Set fowrward buttons as per call type //////////////////////////
            //var_dump($this->post['cl_purpose']);

            if ($this->post['cl_purpose'] == 'COMP_CALL') {



                $fwdbtn = "<input name='search_btn' value='FORWARD TO SUPERVISER' class='style4 form-xhttp-request' data-href='" . base_url() . "complaint/confirm_save' output_position='content' type='button' tabindex='14'>";
            } else if ($this->post['cl_purpose'] == 'FEED_CALL') {



                $fwdbtn = "<input name='search_btn' value='FORWARD TO SUPERVISER' class='style4 form-xhttp-request' data-href='" . base_url() . "feedback/confirm_save' output_position='content' type='button' tabindex='24'>";
            } else if ($this->post['cl_purpose'] == 'FOLL_CALL') {

                $data['ambdtl'] = true;

                // $fwdbtn = "<input name='search_btn' value='FORWARD TO SUPERVISER' class='style4 form-xhttp-request' data-href='" . base_url() . "fupcall/confirm_save' type='button' tabindex='14'>";
                $fwdbtn = "<input name='search_btn' value='SAVE' class=' form-xhttp-request' data-href='" . base_url() . "fupcall/confirm_save' type='button' tabindex='14'>";
            }else if($this->post['cl_purpose'] == 'EMT_MED_AD'){
                 $this->output->add_to_position("<script>$('#get_ambu_details').click()</script>", 'custom_script', true);
                 $fwdbtn = "<input name='fwd_btn' value='FORWARD TO ERCP' class='style4 form-xhttp-request' data-href='" . base_url() . "medadv/confirm_save' data-qr='output_position=summary_div' type='button' tabindex='8'> <input type='hidden' name='increfid' value='<?php echo $increfid; ?>'>";
                 
                 //$this->output->add_to_position($this->load->view('frontend/medadv/med_adv', $data, TRUE), 'adv_pt_info', TRUE);
            }
           
            




            //////////////////////////////////////////////////////////////////////////////



            $inc_act = array('inc_ref_id' => $this->post['inc_ref_id'], 'act' => 'close');

            $this->session->set_userdata('inc_act', $inc_act);

            $args = array(
                'inc_ref_id' => $this->post['inc_ref_id'],
                'base_month' => $this->post['base_month']
            );


            $data['pt_info'] = $this->Pet_model->get_ptinc_info($args);
            $data['inc_amb'] = $this->inc_model->get_inc_ambulance($args);
            
            $this->session->set_userdata('pt_info',  $data['pt_info']);

            $data['inc_details'] =$inc_details = $this->inc_model->get_inc_details_ref_id($args);
            //$data['a['inc_details']inc_details'] = $inc_data[0];
            //var_dump($data['inc_details']);
            

            $data['increfid'] = $this->post['inc_ref_id'];
            
            $args = array(
            'inc_ref_id' => trim($this->post['inc_ref_id']),
            'base_month' => $this->post['base_month']);



        if ($this->agent->is_mobile()) {

            $data['agent_mobile'] = 'yes';
        } else {

            $data['agent_mobile'] = 'no';
        }

        //$data['pt_info'] = $this->Pet_model->get_ptinc_info($args);
        //$data['pt_info'] = $this->Pet_model->get_pt_inc_search($this->post);


        $data['increfid'] = $this->post['inc_ref_id'];

        $data['resource'] = true;

        $data['resource_type'] = $this->post['resource_type'];
        $data['inc_amb'] = $this->inc_model->get_inc_ambulance($args);




        
            $scrpt = "<script>$('.incact').val('SELECT');$('.inc_act" . $this->post['inc_ref_id'] . "').val('CLOSE'); $('#inc_fwd_note').hide();</script>";


            $this->output->add_to_position($scrpt, 'popup_div', TRUE);

            $this->output->add_to_position($this->load->view('frontend/patient/pt_info_view', $data, TRUE), 'inc_pt_info', TRUE);


        $data['amb_type_list'] = $this->amb_model->get_amb_type();
        $data['ambu_type_data'] = array(3, 4);
        
        $data['get_reference_ambu_type'] = array();
        $data['rec_ambu_type']=$inc_details[0]->inc_suggested_amb;
       // var_dump($data['amb_type_list']);
        //die();


            $this->output->add_to_position($fwdbtn, 'fwdcmp_btn', TRUE);
            $this->output->add_to_position($this->load->view('frontend/common/incident_info_view', $data, TRUE), 'inc_pt_info', TRUE);
            $this->output->add_to_position($this->load->view('frontend/resource/amb_map_view', $data, TRUE), 'amb_map_view', TRUE);
            
        $this->output->add_to_position($this->load->view('frontend/inc/inc_recomended_ambu_view', $data, TRUE), 'inc_recomended_ambu', TRUE);

        }
    }

}
