<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pcrt extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));
        $this->load->model(array('pet_model', 'add_res_model', 'colleagues_model', 'inc_model', 'amb_model', 'pcr_model', 'call_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper', 'language_helper'));


        $this->post = $this->input->get_post(NULL);
        $this->post['base_month'] = get_base_month();

         $this->clg = $this->session->userdata('current_user');
         
        $this->today = date('Y-m-d H:i:s');
    }

    public function index($generated = false) {
        
        $args = array(
            'operator_id' => $this->clg->clg_ref_id,
            'base_month' => $this->post['base_month'],
        );
        $inc_info = $this->pcr_model->get_inc_by_emt($args);
        
        $inc_data = array();
        
        foreach($inc_info as $inc){
  
            $args = array(
                'inc_ref_id' => $inc->sub_id,
            );
            $inc_count = $this->pcr_model->get_patient_count($args);
            $pending   = ($inc->inc_patient_cnt - $inc_count[0]->pt_cn);
            $closer    =  $inc_count[0]->pt_cn;
            
            $inc->pending = $pending;
            $inc->closer = $closer;
            
            $inc_data[] = $inc;
        }
        
        $data['inc_info'] = $inc_data;
        $this->output->add_to_position($this->load->view('frontend/pcr/dashboard_view',$data,TRUE),$this->post['output_position'],TRUE);
        $this->output->template = "pcr";
        
    }

    function consents() {
        
        $this->output->add_to_position($this->load->view('frontend/pcr/consents_form_view', '', TRUE), $this->post['output_position'], TRUE);
        //$this->output->template = "pcr";

//        $this->output->add_to_position($this->load->view('frontend/pcr/consents_form_view',$data, TRUE), 'content', TRUE);
//        $this->output->template = "pcr";
    }

    ////////////MI44//////////////////////
    //
    // Purpose :
    //
    //////////////////////////////////////

    function consent_name_info() {

        $data['cons_id'] = $this->post['cons_name'];

        $data['consent_info'] = $this->common_model->consents_info($data);

        $data['amb_services'] = $this->common_model->emergency_details(array('oname' => 'ms_amb_services'));

        $data['lang'] = $this->post['lang'];

        $this->output->add_to_position($this->load->view('frontend/pcr/contents_details_view', $data, TRUE), 'get_details', TRUE);
    }

    function call_info() {

        $this->output->add_to_position($this->load->view('frontend/pcr/call_details_view', '', TRUE), $this->post['output_position'], TRUE);
        $this->output->template = "pcr";
    }

    function call_info_inc() {

        $this->output->add_to_position($this->load->view('frontend/pcr/call_inc_details_view', '', TRUE), $this->post['output_position'], TRUE);
        $this->output->template = "pcr";
    }

    function caller_details() {

        $args = array(
            'inc_ref_id' => $this->post['inc_ref_id'],
            'base_month' => $this->post['base_month'],
        );

        // $pcr_id = 'PCR-' . time() . rand(11, 99);


        $data['pt_info'] = $this->pet_model->get_ptinc_info($args);

        // $data['police_info'] = $this->pcr_model->get_police_info($args);

        $data['vahicle_info'] = $this->pcr_model->get_inc_amb_by_inc($args);

        $data['patient_info'] = $this->pcr_model->get_pat_by_inc($args);

        $this->session->set_userdata('pcr_inc_ref_id', $this->post['inc_ref_id']);
        //$this->session->set_userdata('pcr_id', $pcr_id);


        $data['increfid'] = $this->post['inc_ref_id'];

        $data['resource'] = true;


        $this->output->add_to_position($this->load->view('frontend/common/incident_info_view', $data, TRUE), 'inc_pt_info', TRUE);
        $this->output->add_to_position($this->load->view('frontend/pcr/caller_details_view', '', TRUE), $this->post['output_position'], TRUE);

        $this->output->template = "pcr";
    }

    function vehical_info() {

        $pcr_inc_ref_id = $this->session->userdata('pcr_inc_ref_id');

        $amb_reg_no = $this->post['amb_reg_no'];

        $args = array(
            'inc_ref_id' => $pcr_inc_ref_id,
            'amb_ref_id' => $amb_reg_no,
            'base_month' => $this->post['base_month'],
        );

        $data['inc_info'] = $this->pcr_model->get_inc_amb($args);

        $this->output->add_to_position($this->load->view('frontend/pcr/vehical_info_view', $data, TRUE), 'vehical_info', TRUE);
        $this->output->template = "pcr";
    }

    function patient_details() {


        if($this->post['ptn_id']){
            
            $data['ptn']=$this->pet_model->get_petinfo(array('ptn_id'=>$this->post['ptn_id']));
            
            $data['ptn_id']=$this->post['ptn_id'];
        }
        
        
        
        $this->output->add_to_position($this->load->view('frontend/pcr/patient_details_view', $data, TRUE), $this->post['output_position'], TRUE);


        $this->output->template = "pcr";
    }

    //// Created by MI42 //////////////////////////////
    // 
    // Purpose : To Save/Update patient inforamation.
    // 
    //////////////////////////////////////////////////

    function save_patient_details() {

        $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
        $last_pat_id = $last_insert_pat_id[0]->p_id+1;
        $last_pat_id = generate_ptn_id();
        
        $args = array(
            'ptn_state' => $this->post['state'],
            'ptn_district' => $this->post['district'],
            'ptn_city' => $this->post['ms_city']
        );

        $args = array_merge($this->post['ptn'], $args);

        /////////////////////////////////////////////////////////

        $inc_id = $this->session->userdata('inc_ref_id');

        /////////////////////////////////////////////////////////

        if ($this->post['ptn_id']) {

            $this->pet_model->update_petinfo(array('ptn_id' => $this->post['ptn_id']), $args);

            $this->output->status = 1;

            $this->output->closepopup = "yes";

            $this->output->message = "<div class='success'>Details updated successfully</div>";
        } else {

            $arg_pt = array('ptn_id' => $last_pat_id);
            $args = array_merge($args,$arg_pt);
            $pt_id = $this->pet_model->insert_patient_details($args);

            $args = array('inc_id' => $inc_id, 'ptn_id' => $last_pat_id);

            $this->pet_model->insert_inc_pat($args);

            $this->output->status = 1;

            $this->output->closepopup = "yes";

            $this->output->message = "<div class='success'>Details inserted successfully</div>";
        }

        $this->post['ptn_id'] = $last_pat_id;

        $this->update_patient_details();
    }

    function save_call_info() {

        $pcr_insert_info = $this->input->post();

        $pcr_inc_ref_id = $this->session->userdata('pcr_inc_ref_id');

        $data_pcr = array(
            'inc_ref_id' => $pcr_insert_info['inc_ref_id'],
            'amb_rto_register_no' => $pcr_insert_info['amb_reg_no'],
            'patient_id' => $pcr_insert_info['patient_id'],
            'base_month' => $this->post['base_month'],
            'date' => date('Y-m-d H:i:s'));

        $pcr_id = $this->pcr_model->insert_pcr($data_pcr);

        $pcr_data[$pcr_insert_info['inc_ref_id']] = array('patient_id' => $pcr_insert_info['patient_id'],
            'inc_ref_id' => $pcr_insert_info['inc_ref_id'],
            'rto_no' => $pcr_insert_info['amb_reg_no'],
            'pcr_id' => $pcr_id);


        $this->session->set_userdata('pcr_details', $pcr_data);

        $this->output->message = "<div class='success'><script>$('#PCR_STEPS a[data-pcr_step=3]').click();</script></div>";
        //$this->output->add_to_position($this->load->view('frontend/pcr/patient_details_view', $data, TRUE), 'patient_details', TRUE);
    }

    function epcr() {

        $args = array(
            'inc_ref_id' => $this->post['inc_ref_id'],
            'base_month' => $this->post['base_month'],
        );
        // var_dump($args);

        $this->session->set_userdata('inc_ref_id', $this->post['inc_ref_id']);

        $data['inc_ref_id'] = $this->post['inc_ref_id'];
        $data['pt_info'] = $this->pet_model->get_ptinc_info($args);
        $data['vahicle_info'] = $this->pcr_model->get_inc_amb_by_inc($args);
        $data['patient_info'] = $this->pcr_model->get_pat_by_inc($args);
        $data['inc_emp_info'] = $this->pcr_model->get_inc_amb($args);

        $data['inc_details'] = $this->pcr_model->get_epcr_inc_details($args);
        //var_dump($data['inc_details'] );
        if (empty($data['inc_details'])) {
            $data['inc_details'] = $this->inc_model->get_inc_details($args);
        }

        $this->output->add_to_position($this->load->view('frontend/pcr/epcr_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "pcr";
    }

    function save_epcr() {

        $epcr_info = $this->input->post();

        $epcr_insert_info = array('amb_reg_id' => $epcr_info['amb_reg_id'],
            'inc_ref_id' => $epcr_info['inc_ref_id'],
            'ptn_id' => $epcr_info['pat_id'],
            'loc' => $epcr_info['loc'],
            'provider_impressions' => $epcr_info['provider_impressions'],
            'drugs' => $epcr_info['drags'],
            'interventions_done' => $epcr_info['interventions'],
            'rec_hospital_name' => $epcr_info['receiving_host'],
            'rec_hospital_add' => $epcr_info['rec_hos_add'],
            'call_received' => $epcr_info['call_rec_time'],
            'at_scene' => $epcr_info['at_scene'],
            'from_scene' => $epcr_info['from_scene'],
            'at_hospital' => $epcr_info['at_hospital'],
            'hand_over' => $epcr_info['hand_over'],
            'base_month' => $this->post['base_month'],
            'back_to_base' => $epcr_info['back_to_base'],
            'start_odometer' => $epcr_info['start_odmeter'],
            'end_odometer' => $epcr_info['end_odmeter']);

        $epcr_insert_info = $this->pcr_model->insert_epcr($epcr_insert_info);

        $pcr_data[$epcr_info['inc_ref_id']] = array('patient_id' => $epcr_info['pat_id'],
            'inc_ref_id' => $epcr_info['inc_ref_id'],
            'rto_no' => $epcr_info['amb_reg_id'],
            'pcr_id' => $epcr_insert_info);


        $this->session->set_userdata('pcr_details', $pcr_data);

        $data_pcr = array(
            'inc_ref_id' => $epcr_info['inc_ref_id'],
            'amb_rto_register_no' => $epcr_info['amb_reg_id'],
            'patient_id' => $epcr_info['pat_id'],
            'base_month' => $this->post['base_month'],
            'pcr_id' => $epcr_insert_info,
            'date' => date('Y-m-d H:i:s'));

        $pcr_id = $this->pcr_model->insert_pcr($data_pcr);


        $upadate_amb_data = array('amb_register_no' => $epcr_insert_info['amb_reg_id'],
            'amb_status' => 1);

        //$update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
//$this->output->message = "<div class='success'> Added successfully<script>$('#PCR_STEPS a[data-pcr_step=1]').click();</script></div>";
        $this->output->message = "<div class='success'> Added successfully <script>$('#PCR_STEPS a[data-pcr_step=2]').click();</script></div>";
    }

    function update_amb_details() {

        $inc_ref_id = $this->session->userdata('inc_ref_id');
        $args_amb = array(
            'inc_ref_id' => $inc_ref_id,
            'base_month' => $this->post['base_month'],
        );
        $data['vahicle_info'] = $this->pcr_model->get_inc_amb_by_inc($args_amb);

        $args = array(
            'amb_ref_id' => $this->post['amb_id'],
            'base_month' => $this->post['base_month'],
        );


        $data['inc_emp_info'] = $this->pcr_model->get_inc_amb($args);
        $this->output->add_to_position($this->load->view('frontend/pcr/epcr_amb_view', $data, TRUE), 'amb_details_block', TRUE);
    }

    public function update_patient_details() {


        $inc_ref_id = $this->session->userdata('inc_ref_id');

        $args_pat = array(
            'ptn_id' => $this->post['ptn_id'],
            'base_month' => $this->post['base_month'],
        );



        $data['pt_info'] = $this->pet_model->get_petinfo($args_pat);



        $args = array(
            'inc_ref_id' => $inc_ref_id,
            'base_month' => $this->post['base_month'],
        );


        $data['patient_info'] = $this->pcr_model->get_pat_by_inc($args);

        $this->output->add_to_position($this->load->view('frontend/pcr/epcr_pat_view', $data, TRUE), 'pat_details_block', TRUE);
        
        
        ////////////////////////////////////////////////////////////////////////////////
        
        $lnk="<a href='".base_url()."/pcr/patient_details' class='onpage_popup' data-qr='output_position=popup_div&amp;ptn_id=".$this->post['ptn_id']."' data-popupwidth='1250' data-popupheight='850'>( Update patient details )</a>";  
        
        $this->output->add_to_position($lnk, 'ptn_form_lnk', TRUE);
        
         
        
    }

    ////////////////////////////// Added by MI42  ///////////////////////////////
    // 
    // Purpose : Show Patient history.
    //
    ////////////////////////////////////////////////////////////////////////////


    function patient_history() {



        $data['chief_comp'] = $this->call_model->get_chief_comp();

        $data['case_type'] = $this->common_model->case_type();

        $data['med_his'] = $this->common_model->past_med_his();


        ////////////////////////////////////////////////////////////////////////////////////////


        $pcr = $this->session->userdata('pcr_details');

        $inc_id = key($pcr);

        $pcr_id=$pcr[$inc_id]['pcr_id'];
        
        $pcr_details = $this->pcr_model->get_pcr_details(array('pcr_id' => $pcr_id));

        $data['ptn'] = $this->pet_model->get_petinfo(array('ptn_id' => $pcr_details[0]->patient_id));


        ////////////////////////////////////////////////////////////////////////////////////////

        
        $his_data = array(
            'pcr_id' => $pcr_id,
        );


        ////////////////////////////////////////////////////////////////////////////////////////

        $case_type = $this->pet_model->get_pet_hc($his_data);

        if ($case_type) {

            $data['cs_id'] = explode(",", $case_type[0]->case_id);
            
        }

        //////////////////////////////////////////////////////////////////////

        $medh = $this->pet_model->get_pet_mh($his_data);

        
        
        if ($medh) {

            $dis = explode(",", $medh[0]->dis_id);

            foreach ($data['med_his'] as $mdh) {

                if (in_array($mdh->dis_id, $dis) && $mdh->dis_type == 'o') {

                    $odis.=$mdh->dis_title . ",";
                } else if (in_array($mdh->dis_id, $dis)) {

                    $data['mh_id'][] = $mdh->dis_id;
                }
            }


            if ($odis) {

                $data['his_past_odis'] = rtrim($odis, ",");
            }
        }

        //////////////////////////////////////////////////////////////////////

        $ccom = $this->pet_model->get_pet_cc($his_data);

        
        
        
        
        if ($ccom) {

            $data['cc_id'] = explode(",", $ccom[0]->ct_id);
        }

        
        
        /////////////////////////////////////////////////////////////////////////////////////////

        $data['cur_med'] = $this->pet_model->get_pet_med($his_data);

        /////////////////////////////////////////////////////////////////////////////////////////

        $data['inc_id'] = $inc_id;

        $data['pcr_id'] = $pcr_id;

        
        if ($data['inc_id']) { 

            $this->output->add_to_position($this->load->view('frontend/pcr/patient_hst_view', $data, TRUE), $this->post['output_position'], TRUE);
        } else {

            $this->output->message = "<div class='error'>Please select indicence </div>";
        }
    }

    ////////////////////////////// Added by MI42  ///////////////////////////////
    //
    //  Purpose : Save patient history.
    //
    ////////////////////////////////////////////////////////////////////////////

    function save_patient_history() {

        $args = array(
            'pcr_id' => $this->post['pcr_id']
        );


        $dis_cs = implode(",", $this->post['his_cs']);


        $his_dis = implode(",", $this->post['his_dis']);


        $dis_cc = implode(",", $this->post['his_cc']);


        $cur_med = $this->post['his_cur_med'];


        ////////////////////////////////////////////////////////////////////////

        if (!empty($dis_cs)) {

            $args1 = array(
                'case_id' => $dis_cs,
                'hc_date' => $this->today,
                'hc_base_month' => $this->post['base_month']
            );

            $args1 = array_merge($args1, $args);

            $this->pet_model->save_pet_hc($args1);
        }

        ////////////////////////////////////////////////////////////////////////

        if ($this->post['his_odis']) {

            $his_odis = explode(",", $this->post['his_odis']);

            foreach ($his_odis as $dis) {

                $res = $this->pet_model->save_pet_dis(array('dis_title' => $dis, 'dis_type' => 'o'));

                if ($res) {

                    $odis[] = $res;
                }
            }

            if (!empty($odis)) {

                $his_dis = $his_dis . "," . (implode(",", $odis));
            }
        }



        if ($his_dis) {

            $args1 = array(
                'dis_id' => $his_dis,
                'mh_date' => $this->today,
                'mh_base_month' => $this->post['base_month']
            );

            
            
            $args1 = array_merge($args1, $args);

            $this->pet_model->save_pet_mh($args1);
        }


        ////////////////////////////////////////////////////////////////////////

        if (!empty($dis_cc)) {

            $args1 = array(
                'ct_id' => $dis_cc,
                'cc_date' => $this->today,
                'cc_base_month' => $this->post['base_month']
            );

            $args1 = array_merge($args1, $args);

            $this->pet_model->save_pet_cc($args1);
        }


        ////////////////////////////////////////////////////////////////////////

        if ($cur_med) {

            $args1 = array(
                'med_title' => $cur_med,
                'med_date' => $this->today,
                'med_base_month' => $this->post['base_month']
            );

            $args1 = array_merge($args1, $args);

            $this->pet_model->insert_pet_med($args1);
        }
    }

    ///////////MI44///////////////////////////
    //
    //Purpose : save consents details
    //
    ///////////////////////////////////////////


   function save_consents(){
        
//        $pcr_data[$pcr_insert_info['inc_ref_id']] = array('pcr_id' => $pcr_id);
//        
//        $this->session->set_userdata('pcr_details', $pcr_data);
//        
//        $pcr = $this->session->userdata('pcr_details');
        
        $pcr = $this->session->userdata('pcr_details');     
        $inc_id = key($pcr);     
                        
         
          if($this->post['cons_sub_form']){    
              
              $data = array(
                            'cons_name' => $this->post['cons_name'],
                            'cons_relation' => $this->post['cons_rel'],
                            'cons_consentee_name' => $this->post['consentee_name'],
                            'cons_time' => $this->post['cons_time'],
                            'cons_pcr_id'=> $pcr[$inc_id]['pcr_id']
                          );
              
              
            $insert = $this->pcr_model->insert_consents($data);  
            
            if($insert){
                $this->output->message = "<div class='success'>Consents details is save successfully</div>";
                
                $this->patient_history();
            }else{
               
                $this->output->message = "<div class='error'>Something going wrong</div>";
            }
          }
    }

}
