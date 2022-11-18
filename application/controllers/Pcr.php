<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pcr extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->steps_cnt = $this->config->item('pcr_steps');

        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));
        $this->load->model(array('pet_model', 'add_res_model', 'colleagues_model', 'inc_model', 'amb_model', 'pcr_model', 'call_model', 'medadv_model', 'inv_stock_model', 'ind_model', 'hp_model', 'med_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper', 'language_helper'));


        $this->post = $this->input->get_post(NULL);
        $this->post['base_month'] = get_base_month();
        $this->clg = $this->session->userdata('current_user');

        $this->pg_limit = $this->config->item('pagination_limit_clg');
        $this->pg_limits = $this->config->item('report_clg');

        $this->today = date('Y-m-d H:i:s');
    }

    public function index($generated = false) {
        $this->pg_limit = 50;
        $data['page_no'] = ($this->post['page_no'] || $this->post['pglnk']) ? $this->post['page_no'] : $this->fdata['page_no'];
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        $page_no = 1;
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }

        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        if ($this->clg->clg_group == 'UG-DCO' || $this->clg->clg_group == 'UG-ADMIN') {
            $args_dash = array(
                'base_month' => $this->post['base_month']
            );
        } else {
            $args_dash = array(
                'operator_id' => $this->clg->clg_ref_id,
                'base_month' => $this->post['base_month']
            );
        }

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        $data['get_count'] = TRUE;

        $inc_info = $this->pcr_model->get_inc_by_emt($args_dash, $offset, $limit);


        $data['per_page'] = $limit;
        $data['inc_offset'] = $offset;

        $inc_data = array();

        foreach ($inc_info as $inc) {

            $args = array(
                'inc_ref_id' => $inc->sub_id,
            );
            $inc_count = $this->pcr_model->get_patient_count($args);
            $pending = ($inc->inc_patient_cnt - $inc_count[0]->pt_cn);
            $closer = $inc_count[0]->pt_cn;

            $inc->pending = $pending;
            $inc->closer = $closer;

            $inc_data[] = $inc;
        }

        $data['inc_info'] = $inc_data;


        $total_cnt = $this->pcr_model->get_inc_by_emt($args_dash);
        $data['total_count'] = count($total_cnt);
        $data['per_page'] = $limit;

        $pgconf = array(
            'url' => base_url("pcr/pcr_listing"),
            'total_rows' => count($total_cnt),
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
            )
        );


        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);

        $this->output->add_to_position($this->load->view('frontend/pcr/dashboard_view', $data, TRUE), $this->post['output_position'], TRUE);
        $this->output->template = "pcr";
    }

    function pcr_listing() {
        $this->pg_limit = 50;
        $data['page_no'] = ($this->post['page_no'] || $this->post['pglnk']) ? $this->post['page_no'] : $this->fdata['page_no'];
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        $page_no = 1;
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }


        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        if ($this->clg->clg_group == 'UG-DCO' || $this->clg->clg_group == 'UG-ADMIN') {
            $args_dash = array(
                'base_month' => $this->post['base_month']
            );
        } else {
            $args_dash = array(
                'operator_id' => $this->clg->clg_ref_id,
                'base_month' => $this->post['base_month']
            );
        }

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        $data['get_count'] = TRUE;

        $inc_info = $this->pcr_model->get_inc_by_emt($args_dash, $offset, $limit);

        $data['per_page'] = $limit;
        $data['inc_offset'] = $offset;

        $inc_data = array();

        foreach ($inc_info as $inc) {

            $args = array(
                'inc_ref_id' => $inc->sub_id,
            );
            $inc_count = $this->pcr_model->get_patient_count($args);
            $pending = ($inc->inc_patient_cnt - $inc_count[0]->pt_cn);
            $closer = $inc_count[0]->pt_cn;

            $inc->pending = $pending;
            $inc->closer = $closer;

            $inc_data[] = $inc;
        }

        $data['inc_info'] = $inc_data;


        $total_cnt = $this->pcr_model->get_inc_by_emt($args_dash);
        $data['total_count'] = count($total_cnt);
        $data['per_page'] = $limit;

        $pgconf = array(
            'url' => base_url("pcr/pcr_listing"),
            'total_rows' => count($total_cnt),
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 2,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
            )
        );


        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);

        $this->output->add_to_position($this->load->view('frontend/pcr/dashboard_view', $data, TRUE), $this->post['output_position'], TRUE);
        $this->output->template = "pcr";
    }

    ////////////////MI44///////////////////////////////
    //
    //Purpose : load Consents view and seleced data
    //
    /////////////////////////////////////////////////

    function consents() {

        $pcr_data = $this->session->userdata('pcr_details');

        if ($pcr_data) {

            $inc_id = key($pcr_data);

            $data['consent_data'] = $cons_id = $this->pcr_model->check_consents(array('pcr_id' => $pcr_data[$inc_id]['pcr_id']));



            if ($cons_id[0]->consents_id != '') {

                $args['cons_id'] = $cons_id[0]->consents_id;

                $data['consent_info'] = $this->common_model->consents_info($args);
                $data['lang'] = $cons_id[0]->cons_lang;
            }

            $this->increase_step($pcr_data[$inc_id]['pcr_id']);

            $this->output->add_to_position($this->load->view('frontend/pcr/consents_form_view', $data, TRUE), $this->post['output_position'], TRUE);
        } else {
            $this->output->message = "<div class='error'>Please fill trip closer form first</div>";
        }
    }

    ////////////MI44//////////////////////
    //
    // Purpose : Consents name info content 
    //
    //////////////////////////////////////

    function consent_name_info() {

        $data['cons_id'] = $this->post['cons_name'];

        $data['consent_info'] = $this->common_model->consents_info($data);

        $data['amb_services'] = $this->common_model->emergency_details(array('oname' => 'ms_amb_services'));

        $data['lang'] = $this->post['lang'];

        $this->output->add_to_position($this->load->view('frontend/pcr/contents_details_view', $data, TRUE), 'get_details', TRUE);
    }

    ///////////MI44///////////////////////////
    //
    //Purpose : save consents details
    //
    ///////////////////////////////////////////


    function save_consents() {

        $pcr = $this->session->userdata('pcr_details');
        $inc_id = key($pcr);

        if ($this->post['cons_sub_form']) {

            $data = array(
                'cons_name' => $this->post['cons_name'],
                'cons_relation' => $this->post['cons_rel'],
                'cons_consentee_name' => $this->post['consentee_name'],
                'cons_time' => $this->post['cons_time'],
                'cons_pcr_id' => $pcr[$inc_id]['pcr_id'],
                'cons_lang' => $this->post['lang']
            );


            $insert = $this->pcr_model->insert_consents($data);


            //////////////////////////////////////////////////////////

            pcr_steps($pcr[$inc_id]['pcr_id'], "CNS");

            //////////////////////////////////////////////////////////

            if ($insert) {
                $this->output->message = "<div class='success'>Consent saved sucessfully!<script>$('#PCR_STEPS a[data-pcr_step=3]').click();</script></div>";

                /////////////////////// Update progressbar /////////////////////

                $this->increase_step($pcr[$inc_id]['pcr_id']);

                ///////////////////////////////////////////////////////////////
            } else {
                $this->output->message = "<div class='error'>Something going wrong</div>";
            }
        }
    }

    ///////////MI44//////////////////////////////////////
    //
    //Purpose : Get addtional patient assessment details.
    //
    //////////////////////////////////////////////////////

    function ptn_advasst() {


        $pcr = $this->session->userdata('pcr_details');

        if (empty($pcr)) {

            $this->output->message = "<div class='error'>Please fill Trip closer first</div>";

            return;
        }

        $inc_id = key($pcr);

        $pcr_id = $pcr[$inc_id]['pcr_id'];


        /////////////////////////////////////////////////////////////////////

        $args = array(
            'pcr_id' => $pcr_id,
            'base_month' => $this->post['base_month']
        );

        /////////////////////////////////////////////////////////////////////

        $min = array(10, 20, 30, 40);

        foreach ($min as $mn) {

            $args['asst_min'] = $mn;

            $asst_min = "min_asst" . $mn;

            $data[$asst_min] = $this->pet_model->get_patient_asst($args);
        }

        /////////////////////////////////////////////////////////////////////

        $args['asst_type'] = 'amb';

        $data['add_asst'] = $this->pet_model->get_patient_addasst($args);

        if (!empty($data['add_asst'][0]->asst_pdignosis)) {

            $data['asst_dig'] = explode(",", $data['add_asst'][0]->asst_pdignosis);
        }

        $data['pcr_id'] = $pcr_id;

        $data['pdignosis'] = $this->common_model->get_pdignosis();

        $this->output->add_to_position($this->load->view('frontend/pcr/ptn_advasst_view', $data, TRUE), 'content', TRUE);
    }

    ///////////MI44//////////////////////////////////////
    //
    //Purpose : save addtional patient assessment details.
    //
    //////////////////////////////////////////////////////

    function save_ptn_advasst() {




        $asst_data = array(
            'pcr_id' => $this->post['pcr_id'],
            'asst_date' => $this->today,
            'asst_base_month' => $this->post['base_month']
        );


        /////////////////////////////////////////////////////////////////

        $min = array(10, 20, 30, 40);

        foreach ($min as $mn) {

            $asst_min = "min_asst" . $mn;

            $args = array_merge(array('asst_min' => (string) $mn), $this->post[$asst_min]);

            $ptn_asst = array_merge($args, $asst_data);

            $res = $this->pet_model->save_patient_asst($ptn_asst);
        }


        $asst_data['asst_pdignosis'] = implode(",", $this->post['dig']);

        $ptn_addasst = array_merge($this->post['add_asst'], $asst_data);

        $res = $this->pet_model->save_patient_addasst($ptn_addasst);

        //////////////////////////////////////////////////////////

        pcr_steps($this->post['pcr_id'], "AS2");

        //////////////////////////////////////////////////////////

        $this->output->message = "<div class='success'> Assessment saved successfully <script>$('#PCR_STEPS a[data-pcr_step=7]').click();</script></div>";


        /////////////////////// Update progressbar /////////////////////

        $this->increase_step($this->post['pcr_id']);

        ///////////////////////////////////////////////////////////////
    }

    ///////////MI44///////////////////////////
    //
    //Purpose :  patient assessment.
    //
    ///////////////////////////////////////////

    function ptn_asst() {

        $pcr = $this->session->userdata('pcr_details');

        if (empty($pcr)) {

            $this->output->message = "<div class='error'>Please fill Trip Closer first</div>";

            return;
        }

        $inc_id = key($pcr);

        $pcr_id = $pcr[$inc_id]['pcr_id'];

        if (!$pcr_id) {

            $this->output->message = "<div class='error'>Please fill trip closure first</div>";

            return;
        }


        /////////////////////////////////////////////////////////////////////

        $args = array(
            'pcr_id' => $pcr_id,
            'base_month' => $this->post['base_month']
        );

        /////////////////////////////////////////////////////////////////////

        $data['asst'] = $this->pet_model->get_patient_asst($args);

        $data['add_asst'] = $this->pet_model->get_patient_addasst($args);

        $data['pcr_id'] = $pcr_id;

        ////////////////////////////////////////////////////////////////////

        $args = array(
            'inc_ref_id' => $inc_id,
            'base_month' => $this->post['base_month']
        );

        $data['loc'] = $this->pcr_model->get_epcr_inc_details($args);


        ////////////////////////////////////////////////////////////////////

        $this->output->add_to_position($this->load->view('frontend/pcr/ptn_asst_view', $data, TRUE), 'content', TRUE);
    }

    ///////////MI44///////////////////////////
    //
    //Purpose : save patient assessment details.
    //
    ///////////////////////////////////////////

    function save_ptn_asst() {

        $args = array(
            'pcr_id' => $this->post['pcr_id'],
            'asst_min' => '0',
            'asst_date' => $this->today,
            'asst_base_month' => $this->post['base_month']
        );

        $ptn_asst = array_merge($this->post['asst'], $args);

        $ptn_addasst = array_merge($this->post['add_asst'], $args);

        $res = $this->pet_model->save_patient_asst($ptn_asst);

        $ptn_addasst['asst1'] = "yes";

        $res = $this->pet_model->save_patient_addasst($ptn_addasst);

        /////////////////////////////////////////////////////////////

        $args = array(
            'pcr_id' => $this->post['pcr_id'],
            'loc' => $this->post['asst']['asst_loc']
        );

        $this->pcr_model->update_epcr_loc($args);

        /////////////////////////////////////////////////////////////

        pcr_steps($this->post['pcr_id'], "AS1");

        //////////////////////////////////////////////////////////


        $this->output->message = "<div class='success'> Assessment saved successfully <script>$('#PCR_STEPS a[data-pcr_step=5]').click();</script></div>";

        /////////////////////// Update progressbar /////////////////////

        $this->increase_step($this->post['pcr_id']);

        ///////////////////////////////////////////////////////////////
    }

    function call_info() {
        $this->session->unset_userdata('front_injury_data');
        $this->session->unset_userdata('back_injury_data');
        $this->session->unset_userdata('side_injury_data');
        $this->session->unset_userdata('pcr_details');
        $this->session->unset_userdata('inc_ref_id');


        $data['init_step'] = 'yes';

        $this->output->add_to_position($this->load->view('frontend/pcr/pcr_top_steps_view', $data, TRUE), 'pcr_top_steps', TRUE);

        $this->output->add_to_position('', 'pcr_progressbar', TRUE);

        $this->output->add_to_position($this->load->view('frontend/pcr/call_details_view', '', TRUE), 'content', TRUE);
        $this->output->template = "pcr";
    }

    function caller_details() {

        $args = array(
            'inc_ref_id' => $this->post['inc_ref_id'],
            'base_month' => $this->post['base_month'],
        );

        // $pcr_id = 'PCR-' . time() . rand(11, 99);


        $data['pt_info'] = $this->pet_model->get_ptinc_info($args);

        $data['police_info'] = $this->pcr_model->get_police_info($args);

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
    function add_patient_details_onscene(){
        $data['reopen'] = $this->post['reopen'];
        $data['pt_count'] = $this->input->get('pt_count', TRUE);
        $data['pt_count_ero'] = $this->input->get('pt_count_ero', TRUE);
        $data['epcr_call_type'] = 3;
        
        
        if ($this->post['ptn_id']) {

            $inc_id = $this->session->userdata('inc_ref_id');
            $ptn = $this->pet_model->get_petinfo(array('ptn_id' => $this->post['ptn_id']));
            
            
            $inc_args = array(
                'inc_ref_id' =>$inc_id,
                'ptn_id' =>$this->post['ptn_id'],
            );
            $data['inc_details'] = $this->pcr_model->get_epcr_inc_details($inc_args);

            $data['ptn_id'] = $this->post['ptn_id'];
            $data['p_id'] = $ptn[0]->p_id;

            $inc_args = array(
                'inc_ref_id' => trim($inc_id),
                'base_month' => $this->post['base_month'],
            );

            $inc = $this->inc_model->get_inc_details($inc_args);
           
            
            
            if ($ptn[0]->ptn_state == '') {
                $ptn[0]->ptn_state = $inc[0]->inc_state_id;
            }
            if ($ptn[0]->ptn_district == '' || $ptn[0]->ptn_district =='0') {
                $ptn[0]->ptn_district = $inc[0]->inc_district_id;
            }
            if ($ptn[0]->ptn_city == '' || $ptn[0]->ptn_city == '0' ) {
                $ptn[0]->ptn_city = $inc[0]->inc_city_id;
            }
            if ($ptn[0]->ptn_address == '') {
                $ptn[0]->ptn_address = $inc[0]->inc_address;
            }
            if ($ptn[0]->ptn_ltd == '') {
                $ptn[0]->ptn_ltd = $inc[0]->inc_lat;
            }
            if ($ptn[0]->ptn_lng == '') {
                $ptn[0]->ptn_lng = $inc[0]->inc_long;
            }

            $data['ptn'] = $ptn;
            $data['inc_id'] = $inc_id;
            $this->output->add_to_popup($this->load->view('frontend/pcr/onscene_update_patient_details_view', $data, TRUE), '1200', '500');
        } else {
         
            $inc_id =$this->post['inc_ref_id'];
            if($inc_id == ''){
                $inc_id = $this->session->userdata('inc_ref_id');
            }

            $inc_args = array(
                'inc_ref_id' => trim($inc_id),
            );

            $ptn = $this->inc_model->get_inc_details($inc_args);
	
            $inc['ptn_state'] = $ptn[0]->inc_state_id;
            $inc['ptn_district'] = $ptn[0]->inc_district_id;
            $inc['ptn_city'] = $ptn[0]->inc_city_id;
            $inc['ptn_address'] = $ptn[0]->inc_address;
            $inc['ptn_ltd'] = $ptn[0]->inc_lat;
            $inc['ptn_lng'] = $ptn[0]->inc_long;

            $data['inc'] = $inc;
            $data['inc_id'] = $inc_id;
            $data['ptn_bd']='0000-00-00 00:00:00';
            $this->output->add_to_popup($this->load->view('frontend/pcr/onscene_add_patient_details_view', $data, TRUE), '1200', '500');
        }
       
    }
    function add_patient_details(){
        $data['reopen'] = $this->post['reopen'];
        $data['pt_count'] = $this->input->get('pt_count', TRUE);
        $data['pt_count_ero'] = $this->input->get('pt_count_ero', TRUE);
        $data['epcr_call_type'] = $this->input->get('epcr_call_type', TRUE);
        $data['blood_gp'] = $this->call_model->get_bloodgp();
        if ($this->post['ptn_id']) {

            $inc_id =$this->post['inc_ref_id'];
            if($inc_id == ''){
                $inc_id = $this->session->userdata('inc_ref_id');
            }
            $ptn = $this->pet_model->get_petinfo(array('ptn_id' => $this->post['ptn_id']));

            $data['ptn_id'] = $this->post['ptn_id'];
            $data['p_id'] = $ptn[0]->p_id;

            $inc_args = array(
                'inc_ref_id' => trim($inc_id),
                'base_month' => $this->post['base_month'],
            );

            $inc = $this->inc_model->get_inc_details($inc_args);
           
            
            
            if ($ptn[0]->ptn_state == '') {
                $ptn[0]->ptn_state = $inc[0]->inc_state_id;
            }
            if ($ptn[0]->ptn_district == '' || $ptn[0]->ptn_district =='0') {
                $ptn[0]->ptn_district = $inc[0]->inc_district_id;
            }
            if ($ptn[0]->ptn_city == '' || $ptn[0]->ptn_city == '0' ) {
                $ptn[0]->ptn_city = $inc[0]->inc_city_id;
            }
            if ($ptn[0]->ptn_address == '') {
                $ptn[0]->ptn_address = $inc[0]->inc_address;
            }
            if ($ptn[0]->ptn_ltd == '') {
                $ptn[0]->ptn_ltd = $inc[0]->inc_lat;
            }
            if ($ptn[0]->ptn_lng == '') {
                $ptn[0]->ptn_lng = $inc[0]->inc_long;
            }

            $data['ptn'] = $ptn;
            $data['inc_id'] = $inc_id;
            $this->output->add_to_popup($this->load->view('frontend/pcr/update_patient_details_view', $data, TRUE), '1200', '500');
        } else {
         
            $inc_id =$this->post['inc_ref_id'];
            if($inc_id == ''){
                $inc_id = $this->session->userdata('inc_ref_id');
            }

            $inc_args = array(
                'inc_ref_id' => trim($inc_id),
                'base_month' => $this->post['base_month'],
            );

            $ptn = $this->inc_model->get_inc_details($inc_args);
	
            $inc['ptn_state'] = $ptn[0]->inc_state_id;
            $inc['ptn_district'] = $ptn[0]->inc_district_id;
            $inc['ptn_city'] = $ptn[0]->inc_city_id;
            $inc['ptn_address'] = $ptn[0]->inc_address;
            $inc['ptn_ltd'] = $ptn[0]->inc_lat;
            $inc['ptn_lng'] = $ptn[0]->inc_long;

            $data['inc'] = $inc;
            $data['inc_id'] = $inc_id;
            $data['ptn_bd']='0000-00-00 00:00:00';
            $this->output->add_to_popup($this->load->view('frontend/pcr/add_patient_details_view', $data, TRUE), '1200', '500');
        }
       
}
    function patient_details() {


        if ($this->post['ptn_id']) {

           
            $inc_id =$this->post['inc_ref_id'];
            if($inc_id == ''){
                $inc_id = $this->session->userdata('inc_ref_id');
            }
            $ptn = $this->pet_model->get_petinfo(array('ptn_id' => $this->post['ptn_id']));

            $data['ptn_id'] = $this->post['ptn_id'];
            $data['p_id'] = $ptn[0]->p_id;

            $inc_args = array(
                'inc_ref_id' => trim($inc_id),
                'base_month' => $this->post['base_month'],
            );

            $inc = $this->inc_model->get_inc_details($inc_args);
           
            
            
            if ($ptn[0]->ptn_state == '') {
                $ptn[0]->ptn_state = $inc[0]->inc_state_id;
            }
            if ($ptn[0]->ptn_district == '' || $ptn[0]->ptn_district =='0') {
                $ptn[0]->ptn_district = $inc[0]->inc_district_id;
            }
            if ($ptn[0]->ptn_city == '' || $ptn[0]->ptn_city == '0' ) {
                $ptn[0]->ptn_city = $inc[0]->inc_city_id;
            }
            if ($ptn[0]->ptn_address == '') {
                $ptn[0]->ptn_address = $inc[0]->inc_address;
            }
            if ($ptn[0]->ptn_ltd == '') {
                $ptn[0]->ptn_ltd = $inc[0]->inc_lat;
            }
            if ($ptn[0]->ptn_lng == '') {
                $ptn[0]->ptn_lng = $inc[0]->inc_long;
            }

            $data['ptn'] = $ptn;
            $data['inc_id'] = $inc_id;
        } else {
         
            $inc_id =$this->post['inc_ref_id'];
            if($inc_id == ''){
                $inc_id = $this->session->userdata('inc_ref_id');
            }

            $inc_args = array(
                'inc_ref_id' => trim($inc_id),
                'base_month' => $this->post['base_month'],
            );

            $ptn = $this->inc_model->get_inc_details($inc_args);
	
            $inc['ptn_state'] = $ptn[0]->inc_state_id;
            $inc['ptn_district'] = $ptn[0]->inc_district_id;
            $inc['ptn_city'] = $ptn[0]->inc_city_id;
            $inc['ptn_address'] = $ptn[0]->inc_address;
            $inc['ptn_ltd'] = $ptn[0]->inc_lat;
            $inc['ptn_lng'] = $ptn[0]->inc_long;

            $data['inc'] = $inc;
            $data['inc_id'] = $inc_id;
            $data['ptn_bd']='0000-00-00 00:00:00';
        }
       // var_dump($data['ptn_bd']);die();

        //$this->output->add_to_position($this->load->view('frontend/pcr/patient_details_view', $data, TRUE), $this->post['output_position'], TRUE);

        $this->output->add_to_popup($this->load->view('frontend/pcr/patient_details_view', $data, TRUE), '1000', '1000');

//           $this->output->template = "pcr";
    }

    //// Created by MI42 //////////////////////////////
    // 
    // Purpose : To Save/Updasave_add_patient_detailste patient inforamation.
    // 
    //////////////////////////////////////////////////
    function save_add_patient_details(){
        
        $ptn = $this->post['ptn'];
        $reopen = $this->post['reopen'];
             
        $fname = ucfirst($ptn['ptn_fname']);
        $mname = ucfirst($ptn['ptn_mname']);
        $lname = ucfirst($ptn['ptn_lname']);
        $ptn_birth_date='';
        if($this->post['ptn']['ptn_birth_date'] != ''){
            $ptn_birth_date = date('Y-m-d', strtotime($this->post['ptn']['ptn_birth_date']));
        }
        $args = array(
            'ptn_fullname' => $fname.' '.$mname.' '.$lname,
            'ptn_age' => $this->post['ptn']['ptn_age'],
            'ptn_age_type' => $this->post['ptn']['ptn_age_type'],
            'ayushman_id' => $this->post['ptn']['ayushman_id'],
            'ptn_bgroup' => $this->post['ptn']['ptn_bgroup'],
            'ptn_opd_id' => $this->post['ptn']['ptn_opd_id'],
            'ptn_pcf_no' => $this->post['ptn']['ptn_pcf_no']
        );
       
      
        $args = array_merge($this->post['ptn'], $args);
        $args['ptn_fname'] = ucfirst($args['ptn_fname']);
        $args['ptn_mname'] = ucfirst($args['ptn_mname']);
        $args['ptn_lname'] = ucfirst($args['ptn_lname']);
        $inc_id = $this->session->userdata('inc_ref_id');
        
        if ($this->post['ptn_id'] != '') {
            $args['ptn_modify_by'] = $this->clg->clg_ref_id;
            $args['ptn_modify_date'] = date('Y-m-d H:i:s');
             
             
            $this->pet_model->update_petinfo(array('ptn_id' => $this->post['ptn_id']), $args);

            $this->output->status = 1;

            $this->output->closepopup = "yes";

            $this->output->message = "<div class='success'>Details updated successfully</div>";

            $pt_id = $this->post['ptn_id'];
            
        }else{
            foreach ($this->post['ptn'] as $dt) {
                if($dt['ptn_fname'] == '' && $dt['ptn_lname']=='' && $dt['ptn_age']=='' && $dt['ptn_gender']=='' ){
                    continue;
                }
            $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
            $clg_id = $this->clg->clg_id;
            $last_pat_id = $last_insert_pat_id[0]->p_id + 1;
           // $last_pat_id = $clg_id.'_'.$last_pat_id;
            $last_pat_id = generate_ptn_id();


            $dt['ptn_id'] = $last_pat_id;
            $dt['ptn_added_by'] = $this->clg->clg_ref_id;
            $dt['ptn_added_date'] = date('Y-m-d H:i:s');
           
               $inc_id = $this->session->userdata('inc_ref_id');
                $dt['ptn_fname'] = ucfirst($dt['ptn_fname']);
                $dt['ptn_mname'] = ucfirst($dt['ptn_mname']);
                $dt['ptn_lname'] = ucfirst($dt['ptn_lname']);
                $dt['ayushman_id'] = ucfirst($dt['ayushman_id']);
                $dt['ptn_bgroup'] = ucfirst($dt['ptn_bgroup']);
                $dt['ptn_opd_id'] = ucfirst($dt['ptn_opd_id']);
                $dt['ptn_pcf_no'] = ucfirst($dt['ptn_pcf_no']);
               
                $pt_id = $this->pet_model->insert_updated_patient_details($dt);
              
            
//            if($dt['ptn_lname'] !='' && $dt['ptn_age'] !=''){
//                
//                
//                $dt['ptn_fname'] = ucfirst($dt['ptn_fname']);
//                $dt['ptn_mname'] = ucfirst($dt['ptn_mname']);
//                $dt['ptn_lname'] = ucfirst($dt['ptn_lname']);
//                
//                $ptn_exists = $this->pet_model->get_patient_details($dt,$inc_id);
//                if(empty($ptn_exists)){
//                    $pt_id = $this->pet_model->insert_updated_patient_details($dt);
//                }else{
//                    $this->output->message = "<div class='error'>Patient Name alredy exists for this incident</div>";
//                    return;
//                }
//            
//            }
         
            if($pt_id){
                if($dt['ptn_lname'] !='' && $dt['ptn_age'] !=''){
                    
                $args = array('inc_id' => $inc_id, 'ptn_id' => $last_pat_id);

                $add_patient =  $this->pet_model->insert_inc_pat($args);

                 $args_pt = array('get_count' => TRUE,
                'inc_ref_id' => $inc_id);

                $ptn_count = $this->pcr_model->get_pat_by_inc($args_pt);

                if($reopen != 'y'){
                    if ($pcr_count == $ptn_count || $pcr_count >= $ptn_count) {

                        $update_inc_args = array('inc_ref_id' => $inc_id, 'inc_pcr_status' => '1');
                        $update_inc = $this->inc_model->update_incident($update_inc_args);

                    } else {

                        $update_inc_args = array('inc_ref_id' => $inc_id, 'inc_pcr_status' => '0');
                        $update_inc = $this->inc_model->update_incident($update_inc_args);

                    }
                }

                $this->output->status = 1;

                $this->output->closepopup = "yes";

                $this->output->message = "<div class='success'>Details inserted successfully</div>";
                
                }
            }else{
                  $this->output->message = "<div class='error'>Error</div>";
                  
            }
        } }
        //return;
        $this->post['p_id'] = $pt_id;
        $this->post['ptn_id'] = $pt_id;
        $this->post['reopen']= $reopen;
        

        $this->update_new_patient_details();

       // die();
    }
    function save_patient_details() {


        $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
        $clg_id = $this->clg->clg_id;
        $last_pat_id = $last_insert_pat_id[0]->p_id + 1;
        $last_pat_id = generate_ptn_id();
        //$last_pat_id = $clg_id.'_'.$pat_id;

       
        $ptn = $this->post['ptn'];
        $fname = ucfirst($ptn['ptn_fname']);
        $mname = ucfirst($ptn['ptn_mname']);
        $lname = ucfirst($ptn['ptn_lname']);
        $ptn_birth_date='';
        if($this->post['ptn']['ptn_birth_date'] != ''){
            $ptn_birth_date = date('Y-m-d', strtotime($this->post['ptn']['ptn_birth_date']));
        }
        $args = array(
            'ptn_fullname' => $fname.' '.$mname.' '.$lname,
            'ptn_state' => $this->post['ptn_dtl_state'],
            'ptn_district' => $this->post['ptn_dtl_districts'],
            'ptn_city' => $this->post['ptn_dtl_ms_city'],
            'ptn_area' => $this->post['ptn_dtl_area'],
            'ptn_landmark' => $this->post['ptn_dtl_lmark'],
            'ptn_lane' => $this->post['ptn_dtl_lane'],
            'ptn_house_no' => $this->post['ptn_dtl_hno'],
            'ptn_pincode' => $this->post['ptn_dtl_pincode'],
            'ptn_age' => $this->post['ptn']['ptn_age'],
            'ptn_birth_date' =>$ptn_birth_date,
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

            $pt_id = $this->post['ptn_id'];
        } else {
            $arg_pt = array('ptn_id' => $last_pat_id);
            
            $args = array_merge($args, $arg_pt);
            $pt_id = $this->pet_model->insert_patient_details($args);
            if($pt_id){
                $args = array('inc_id' => $inc_id, 'ptn_id' => $last_pat_id);

                $add_patient =  $this->pet_model->insert_inc_pat($args);

                 $args_pt = array('get_count' => TRUE,
                'inc_ref_id' => $inc_id);

                $ptn_count = $this->pcr_model->get_pat_by_inc($args_pt);

                if ($pcr_count == $ptn_count || $pcr_count >= $ptn_count) {

                    $update_inc_args = array('inc_ref_id' => $inc_id, 'inc_pcr_status' => '1');
                    $update_inc = $this->inc_model->update_incident($update_inc_args);

                } else {

                    $update_inc_args = array('inc_ref_id' => $inc_id, 'inc_pcr_status' => '0');
                    $update_inc = $this->inc_model->update_incident($update_inc_args);

                }

                $this->output->status = 1;

                $this->output->closepopup = "yes";

                $this->output->message = "<div class='success'>Details inserted successfully</div>";
            }else{
                  $this->output->message = "<div class='error'>Error</div>";
                  return;
            }
        }

        $this->post['p_id'] = $pt_id;
        $this->post['ptn_id'] = $pt_id;

        $this->update_patient_details();
    }
    
    function save_onscene_add_patient_details(){
        
        $ptn = $this->post['ptn'];
        
        $fname = ucfirst($ptn['ptn_fname']);
        $mname = ucfirst($ptn['ptn_mname']);
        $lname = ucfirst($ptn['ptn_lname']);
        $ptn_birth_date='';
 
        if($this->post['ptn']['ptn_birth_date'] != ''){
            $ptn_birth_date = date('Y-m-d', strtotime($this->post['ptn']['ptn_birth_date']));
        }
        $args = array(
            'ptn_fullname' => $fname.' '.$mname.' '.$lname,
            'ptn_age' => $this->post['ptn']['ptn_age'],
            'ptn_age_type' => $this->post['ptn']['ptn_age_type']
        );
       
      
        $args = array_merge($this->post['ptn'], $args);
        $args['ptn_fname'] = ucfirst($args['ptn_fname']);
        $args['ptn_mname'] = ucfirst($args['ptn_mname']);
        $args['ptn_lname'] = ucfirst($args['ptn_lname']);
        if($this->post['inc_ref_id'] == ''){
            $inc_id = $this->session->userdata('inc_ref_id');
        }else{
             $inc_id = $this->post['inc_ref_id'];
        }
       
        if ($this->post['ptn_id'] != '') {
            
            $args['ptn_modify_by'] = $this->clg->clg_ref_id;
            $args['ptn_modify_date'] = date('Y-m-d H:i:s');
             
             
            $this->pet_model->update_petinfo(array('ptn_id' => $this->post['ptn_id']), $args);
            
            $epcr_info = $this->post['epcr'];
            
            $epcr_insert_info = array(
            'inc_ref_id' => $inc_id,
            'ptn_id' => $this->post['ptn_id'],
           // 'loc' => $epcr_info['loc'],
            'provider_casetype' => $epcr_info['provider_casetype'],
            'provider_impressions' => $epcr_info['provider_impressions']);
            
            if (!empty($epcr_info['provider_casetype_other'])) {
                $epcr_insert_info['provider_casetype_other'] = $epcr_info['provider_casetype_other'];
            }
            
            $epcr_insert_info = $this->pcr_model->insert_epcr($epcr_insert_info);
             
            $this->output->status = 1;

            $this->output->closepopup = "no";

            $this->output->message = "<div class='success'>Details updated successfully</div>";

            $pt_id = $this->post['ptn_id'];
            
            $this->post['p_id'] = $pt_id;
            $this->post['ptn_id'] = $pt_id;

            $this->update_new_patient_details_onscene();
            
        }else{
            foreach ($this->post['ptn'] as $key=>$dt) {
              $epcr_info =  $this->input->post('epcr');
            $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
            $clg_id = $this->clg->clg_id;
            $last_pat_id = $last_insert_pat_id[0]->p_id + 1;
            $last_pat_id = generate_ptn_id();


            $dt['ptn_id'] = $last_pat_id;
            $dt['ptn_added_by'] = $this->clg->clg_ref_id;
            $dt['ptn_added_date'] = date('Y-m-d H:i:s');
           
             $inc_id = $this->session->userdata('inc_ref_id');   
              $dt['ptn_fname'] = ucfirst($dt['ptn_fname']);
                $dt['ptn_mname'] = ucfirst($dt['ptn_mname']);
                $dt['ptn_lname'] = ucfirst($dt['ptn_lname']);
                $pt_id = $this->pet_model->insert_updated_patient_details($dt);
//            if($dt['ptn_lname'] !='' && $dt['ptn_age'] !=''){
//                
//                
//                $dt['ptn_fname'] = ucfirst($dt['ptn_fname']);
//                $dt['ptn_mname'] = ucfirst($dt['ptn_mname']);
//                $dt['ptn_lname'] = ucfirst($dt['ptn_lname']);
//                
//                $ptn_exists = $this->pet_model->get_patient_details($dt,$inc_id);
//                if(empty($ptn_exists)){
//                    $pt_id = $this->pet_model->insert_updated_patient_details($dt);
//                }else{
//                    $this->output->message = "<div class='error'>Patient Name alredy exists for this incident</div>";
//                    return;
//                }
//            
//            }
         
            if($pt_id){
                if($dt['ptn_lname'] !='' && $dt['ptn_age'] !=''){
                    
                $args = array('inc_id' => $inc_id, 'ptn_id' => $last_pat_id);

                $add_patient =  $this->pet_model->insert_inc_pat($args);

                 $args_pt = array('get_count' => TRUE,
                'inc_ref_id' => $inc_id);

                $ptn_count = $this->pcr_model->get_pat_by_inc($args_pt);

                if ($pcr_count == $ptn_count || $pcr_count >= $ptn_count) {

                    $update_inc_args = array('inc_ref_id' => $inc_id, 'inc_pcr_status' => '1');
                    $update_inc = $this->inc_model->update_incident($update_inc_args);

                } else {

                    $update_inc_args = array('inc_ref_id' => $inc_id, 'inc_pcr_status' => '0');
                    $update_inc = $this->inc_model->update_incident($update_inc_args);

                }
                
            $epcr_insert_info = array(
            'date' => date('m/d/Y'),
            'time' => date('H:i:s'),
            'inc_ref_id' => $inc_id,
            'ptn_id' => $last_pat_id,
           // 'loc' => $epcr_info['loc'],
            'provider_casetype' => $epcr_info[$key]['provider_casetype'],
            'provider_impressions' => $epcr_info[$key]['provider_impressions']);
            
            $epcr_insert_info['added_date']=date('Y-m-d H:i:s');
            $epcr_insert_info['operate_by']=$this->clg->clg_ref_id;
            
            if (!empty($epcr_info[$key]['provider_casetype_other'])) {
                $epcr_insert_info['provider_casetype_other'] = $epcr_info[$key]['provider_casetype_other'];
            }
             $epcr_insert_info = $this->pcr_model->insert_epcr($epcr_insert_info);
                            


//                $this->output->closepopup = "no";
//
//                $this->output->message = "<div class='success'>Details inserted successfully</div>";
                
                
                
                }
            }else{
                  $this->output->message = "<div class='error'>Error</div>";
                  
            }
        } 
        
       }
        //return;
//        $this->post['p_id'] = $pt_id;
//        $this->post['ptn_id'] = $pt_id;
//
//        $this->update_new_patient_details();

       // die();
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

        $this->output->message = "<div class='success'><script>$('#PCR_STEPS a[data-pcr_step=2]').click();</script></div>";
        //$this->output->add_to_position($this->load->view('frontend/pcr/patient_details_view', $data, TRUE), 'patient_details', TRUE);
    }

    function epcr() {
        //$this->session->unset_userdata('inc_ref_id');

        if ($this->post['inc_ref_id'] == '') {
            $this->post['inc_ref_id'] = base64_decode($this->input->get('inc_id'));
        }

        if ($this->post['inc_ref_id'] == '') {
            // $this->post['inc_ref_id'] = $this->session->userdata('inc_ref_id');
            $pcr = $this->session->userdata('pcr_details');
            $inc_id = key($pcr);
            $this->post['inc_ref_id'] = $inc_id;
            $patient_id = $pcr[$inc_id]['patient_id'];
        }


        if (($this->post['inc_ref_id'] == "") && ($this->post['inc_ref_id'] == NULL )) {

            $this->call_info();
            return;
        }

        $data['inc_ref_id'] = trim($this->post['inc_ref_id']);


        $this->session->set_userdata('inc_ref_id', $this->post['inc_ref_id']);


        if ($this->clg->clg_group == 'UG-DCO' || $this->clg->clg_group == 'UG-ADMIN') {
            $inc_args = array(
                'inc_ref_id' => trim($this->post['inc_ref_id']),
                'base_month' => $this->post['base_month']);
        } else {
            $inc_args = array(
                'inc_ref_id' => trim($this->post['inc_ref_id']),
                'operator_id' => $this->clg->clg_ref_id,
                'base_month' => $this->post['base_month']);
        }

        $args = array(
            'inc_ref_id' => trim($this->post['inc_ref_id']),
            'base_month' => $this->post['base_month'],
        );
        $data['vahicle_info'] = $this->pcr_model->get_inc_amb_by_inc($args);


        $ptn_args = array(
            'ptn_id' => $data['inc_details'][0]->ptn_id,
            'base_month' => $this->post['base_month']);

        $data['patient_info'] = $this->pcr_model->get_pending_pat_by_inc($args);

        $data['inc_details'] = $this->pcr_model->get_epcr_inc_details($inc_args);

        if (!empty($data['inc_details'])) {

            if (!isset($pcr)) {
                $pcr_data[$this->post['inc_ref_id']] = array('patient_id' => $data['inc_details'][0]->ptn_id,
                    'inc_ref_id' => $this->post['inc_ref_id'],
                    'rto_no' => $data['inc_details'][0]->amb_reg_id,
                    'pcr_id' => $data['inc_details'][0]->id);

                $this->session->set_userdata('pcr_details', $pcr_data);
            }
        }

        if (empty($data['inc_details'])) {
            $this->session->unset_userdata('pcr_details');
            $data['inc_details'] = $this->inc_model->get_inc_details($inc_args);
        }
        if (!empty($data['inc_details'])) {

            $amb_args = array(
                'inc_ref_id' => trim($this->post['inc_ref_id']),
                'amb_ref_id' => $data['inc_details'][0]->amb_ref_id,
                'base_month' => $this->post['base_month']);

            $data['inc_emp_info'] = $this->pcr_model->get_inc_amb($amb_args);


            if (!empty($patient_id) && $patient_id != NULL) {
                $data['patient_id'] = $patient_id;
                $ptn_args = array(
                    'ptn_id' => trim($patient_id),
                    'base_month' => $this->post['base_month'],
                );
            } else {

                $data['patient_id'] = $data['inc_details'][0]->ptn_id;
                $ptn_args = array(
                    'ptn_id' => $data['inc_details'][0]->ptn_id,
                    'base_month' => $this->post['base_month'],
                );
            }


            $data['pt_info'] = $this->pet_model->get_petinfo($ptn_args);
            $args = array(
                'pcr_id' => $data['inc_details'][0]->id,
                'patient_id' => $data['inc_details'][0]->ptn_id,
                'base_month' => $this->post['base_month']
            );

            $data['driver_data'] = $this->pcr_model->get_driver(array('dp_pcr_id' => $data['inc_details'][0]->id));

            $get_amb_stock = array('pcr_id' => $data['inc_details'][0]->id,
                'sub_type' => 'pcr',
                'as_item_type' => 'NCA');

            $data['pcr_na_med_inv_data'] = $this->ind_model->get_amb_stock($get_amb_stock);

            $get_amb_stock = array('pcr_id' => $data['inc_details'][0]->id,
                'sub_type' => 'pcr',
                'as_item_type' => 'CA');

            $data['pcr_med_inv_data'] = $this->ind_model->get_amb_stock($get_amb_stock);

            $non_unit_args = array(
                'inv_id' => $data['inc_details'][0]->drugs,
            );

            $args = array('inv_type' => 'CA');
            $data['invitem'] = $this->inv_model->get_inv($args);

            $non_args = array('inv_type' => 'NCA');
            $data['noninvitem'] = $this->inv_model->get_inv($non_args);

            //////////////////// Update progressbar ///////////////////////////

            $this->increase_step($data['inc_details'][0]->id);

            ///////////////////////////////////////////////////////////////////

            $this->output->add_to_position($this->load->view('frontend/pcr/epcr_view1', $data, TRUE), 'content', TRUE);
            // $this->output->add_to_position($this->load->view('frontend/pcr/footer_steps', $data, TRUE), 'footer_steps', TRUE);
            //  $this->output->template = "pcr";
        } else {
            $this->output->message = "<div class='error'>Please Enter valid Incident Id</div>";
        }
    }

    function save_epcr() {

        $epcr_info = $this->input->post();


        $obious_death_ques = "";
        if (isset($epcr_info['obious_death']['ques'])) {
            $obious_death_ques = serialize($epcr_info['obious_death']['ques']);
        }

        $total_km = $epcr_info['end_odmeter'] - $epcr_info['start_odmeter'];
        $epcr_insert_info = array(
            'date' => date('m/d/Y'),
            'time' => date('H:i:s'),
            'amb_reg_id' => $epcr_info['amb_reg_id'],
            'inc_ref_id' => $epcr_info['inc_ref_id'],
            'ptn_id' => $epcr_info['pat_id'],
            'loc' => $epcr_info['loc'],
            'provider_impressions' => $epcr_info['provider_impressions'],
            'rec_hospital_name' => $epcr_info['receiving_host'],
            'base_month' => $this->post['base_month'],
            'state_id' => $epcr_info['tc_dtl_state'],
            'district_id' => $epcr_info['tc_dtl_district'],
            'city_id' => $epcr_info['tc_dtl_ms_city'],
            'start_odometer' => $epcr_info['start_odmeter'],
            'end_odometer' => $epcr_info['end_odmeter'],
            'total_km' => $total_km,
            'locality' => $epcr_info['locality'],
            'emt_name' => $epcr_info['emt_name'],
            'emso_id' => $epcr_info['emt_id'],
            'pilot_name' => $epcr_info['pilot_name'],
            'pilot_id' => $epcr_info['pilot_id'],
            'remark' => $epcr_info['epcr_remark'],
            'inc_datetime' => $epcr_info['inc_datetime'],
            'obious_death_ques' => $obious_death_ques,
            'operate_by' => $this->clg->clg_ref_id,
        );


        if (!empty($epcr_info['other_provider'])) {
            $epcr_insert_info['other_provider_img'] = $epcr_info['other_provider'];
        }

        if (!empty($epcr_info['other_receiving_host'])) {
            $epcr_insert_info['other_receiving_host'] = $epcr_info['other_receiving_host'];
        }
        if (!empty($epcr_info['other_units'])) {
            $epcr_insert_info['other_units'] = $epcr_info['other_units'];
        }

        if (!empty($epcr_info['other_non_units'])) {
            $epcr_insert_info['other_non_units'] = $epcr_info['other_non_units'];
        }

        $inc_amb = array('inc_ref_id' => $epcr_info['inc_ref_id'],
            'amb_pilot_id' => $epcr_info['pilot_id'],
            'amb_emt_id' => $epcr_info['emt_id']);

        $this->inc_model->update_inc_amb($inc_amb);

        $epcr_insert_info = $this->pcr_model->insert_epcr($epcr_insert_info);

        $update_inc_args = array('inc_ref_id' => $epcr_info['inc_ref_id'], 'inc_pcr_status' => '1');
        $update_inc = $this->inc_model->update_incident($update_inc_args);

        $inc_date = explode(' ', $epcr_info['inc_datetime']);


        $d_start = new DateTime($epcr_info['inc_datetime']);
        $d_end = new DateTime($epcr_info['at_scene']);
        $resonse_time = $d_start->diff($d_end);
        //  $resonse_time = date_diff( $epcr_info['at_scene'] , $epcr_info['inc_datetime']);

        $resonse_time = $resonse_time->h . ':' . $resonse_time->i . ':' . $resonse_time->s;

        $data = array('dp_cl_from_desk' => $epcr_info['call_rec_time'],
            'dp_started_base_loc' => $epcr_info['at_scene'],
            'dp_reach_on_scene' => $epcr_info['from_scene'],
            'dp_on_scene' => $epcr_info['at_scene'],
            'dp_hosp_time' => $epcr_info['at_hospital'],
            'dp_hand_time' => $epcr_info['hand_over'],
            'dp_back_to_loc' => $epcr_info['back_to_base'],
            'dp_pcr_id' => $epcr_insert_info,
            'dp_base_month' => $this->post['base_month'],
            'start_odometer' => $epcr_info['start_odmeter'],
            'end_odometer' => $epcr_info['end_odmeter'],
            'start_from_base' => $epcr_info['start_from_base'],
            'dp_date' => date('Y-m-d H:i:s'),
            'inc_ref_id' => $epcr_info['inc_ref_id'],
            'responce_time' => $resonse_time,
            'responce_time_remark' => $epcr_info['responce_time_remark'],
            'responce_time_remark_other' => $epcr_info['responce_time_remark_other'],
            'inc_dispatch_time' => $inc_date[1],
            'dp_operated_by' => $this->clg->clg_ref_id,
            'inc_date' => $inc_date[0]
        );
        //var_dump($data);

        $insert = $this->pcr_model->insert_deriver_pcr($data);

         $unique_id = get_uniqid( $this->session->userdata('user_default_key'));
        $amb_record_data = array(
                            'id'=>$unique_id,
                            'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                            'inc_ref_id'          => $epcr_info['inc_ref_id'],
                            'start_odmeter'       => $epcr_info['start_odmeter'],
                            'end_odmeter'         => $epcr_info['end_odmeter'],
                            'total_km'            => $total_km,
                            'timestamp'           => date('Y-m-d H:i:s')  );

        if (!empty($epcr_info['odometer_remark'])) {
            $amb_record_data['remark'] = $epcr_info['odometer_remark'];
        }

        if (!empty($epcr_info['remark_other'])) {
            $amb_record_data['other_remark'] = $epcr_info['remark_other'];
        }
        if (!empty($epcr_info['end_odometer_remark'])) {
            $amb_record_data['end_odometer_remark'] = $epcr_info['end_odometer_remark'];
        }

        if (!empty($epcr_info['endodometer_remark_other'])) {
            $amb_record_data['endodometer_remark_other'] = $epcr_info['endodometer_remark_other'];
        }

        $odo_args = array('inc_ref_id' => $epcr_info['inc_ref_id']);
        $get_odometer = $this->amb_model->get_amb_odometer_by_inc($odo_args);
        if (empty($get_odometer)) {
            $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
        }


        $args = array(
            'ptn_id' => $epcr_info['pat_id'],
            'ptn_state' => $epcr_info['tc_dtl_state'],
            'ptn_district' => $epcr_info['tc_dtl_district'],
            'ptn_city' => $epcr_info['tc_dtl_ms_city'],
            'ptn_address' => $epcr_info['locality'],
        );


        $this->pet_model->update_petinfo(array('ptn_id' => $epcr_info['pat_id']), $args);


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


        $upadate_amb_data = array('amb_rto_register_no' => $epcr_info['amb_reg_id'],
            'amb_status' => 1);

        //$update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);

        $deletet_amb_stock = array('pcr_id' => $epcr_insert_info,
            'sub_type' => 'pcr');
        $this->ind_model->deletet_amb_stock($deletet_amb_stock);



        if (isset($epcr_info['obious_death']['ques'])) {
            foreach ($epcr_info['obious_death']['ques'] as $key => $ques) {

                $ems_summary = array('sum_base_month' => $this->post['base_month'],
                    'sum_epcr_id' => $epcr_insert_info,
                    'inc_ref_id' => $epcr_info['inc_ref_id'],
                    'ptn_id' => $epcr_info['pat_id'],
                    'sum_que_id' => $key,
                    'sum_que_ans' => $ques
                );

                $this->pcr_model->insert_obvious_death_ques_summary($ems_summary);
            }
        }

        if (isset($epcr_info['unit'])) {
            foreach ($epcr_info['unit'] as $unit) {

                if ($unit['value'] != '' && $unit['type'] != '') {

                    $unit_args = array(
                        'as_item_id' => $unit['id'],
                        'as_item_type' => $unit['type'],
                        'as_stk_in_out' => 'out',
                        'as_item_qty' => $unit['value'],
                        'as_sub_id' => $epcr_insert_info,
                        'as_sub_type' => 'pcr',
                        'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                        'as_date' => $this->today,
                        'as_base_month' => $this->post['base_month'],
                    );


                    $this->ind_model->insert_amb_stock($unit_args);
                }
            }
        }
        if (isset($epcr_info['non_unit'])) {
            foreach ($epcr_info['non_unit'] as $unit) {
                if ($unit['id'] != '' && $unit['type'] != '') {
                    $unit_args = array(
                        'as_item_id' => $unit['id'],
                        'as_item_type' => $unit['type'],
                        'as_stk_in_out' => 'out',
                        'as_item_qty' => 1,
                        'as_sub_id' => $epcr_insert_info,
                        'as_sub_type' => 'pcr',
                        'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                        'as_date' => $this->today,
                        'as_base_month' => $this->post['base_month'],
                    );

                    $this->ind_model->insert_amb_stock($unit_args);
                }
            }
        }

        $this->session->set_userdata('pcr_steps', '1');

        //////////////////////////////////////////////////////////

        $flforms = pcr_steps($epcr_insert_info, "PCR");

        //////////////////////////////////////////////////////////
        //$this->output->message = "<div class='success'> Added successfully<script>window.location.reload(true);</script></div>";
        $this->output->message = "<div class='success'> Added successfully <a href='" . $this->base_url . "bike' class='orange'>Back to Dashboard</a></div>";

        //////////////////// Update progressbar ///////////////////////////

        $this->increase_step($epcr_insert_info);

        ///////////////////////////////////////////////////////////////////
    }

    function show_unit_drugs_ca() {

        $epcr_info = $this->input->post();
        // var_dump($epcr_info);

        $na_con_data = array();
        $cons_data = array();

        if (isset($epcr_info['unit'])) {
            foreach ($epcr_info['unit'] as $key => $unit) {

                if ($unit['value'] != '') {

                    if ($unit['type'] == 'CA') {
                        $cons_data[$key] = array('inv_id' => $unit['id'],
                            'inv_qty' => $unit['value'],
                            'inv_type' => $unit['type']);

                        $args = array('inv_id' => $unit['id'],
                            'inv_type' => $unit['type']);
                        $invitem = $this->inv_model->get_inv($args);

                        $cons_data[$key]['inv_title'] = $invitem[0]->inv_title;
                    }
                }
            }
        }



        $data['cons_data'] = $cons_data;

        $this->output->add_to_position($this->load->view('frontend/pcr/unit_drugs_view', $data, TRUE), 'show_selected_unit_item_ca', TRUE);
    }
    function show_intervention_drugs(){
        $epcr_info = $this->input->post();

        $na_con_data = array();
        //  $na_con_data = $this->session->set_userdata('na_con_data');


        if (isset($epcr_info['intervention'])) {
            foreach ($epcr_info['intervention'] as $key => $unit) {
                
              

                if ($unit['id'] != '') {
                    

                        $na_con_data[$key] = array('inv_id' => $unit['id'],
                            'inv_qty' => 0,
                            'inv_type'=>'INT');

                        $args = array('inj_id' => $unit['id']);
                       
                        
                        //$invitem = $this->inv_model->get_inv($args);
                        $invitem = $this->med_model->get_intervention_list($args);
                         // var_dump($invitem);

                        $na_con_data[$key]['int_name'] = $invitem[0]->int_name;
                    
                }
            }
        }
        //var_dump($na_con_data);
        // $inc_ref_id = $this->session->set_userdata('na_con_data',$na_con_data);
        $data['cons_data'] = $na_con_data;

        $this->output->add_to_position($this->load->view('frontend/pcr/intervention_drugs_view', $data, TRUE), 'selected_intervention_box_view', TRUE);
        //$this->output->add_to_position($this->load->view('frontend/pcr/non_unit_drugs_view', $data, TRUE), 'selected_non_unit_drugs_view', TRUE);
    
    }
    function show_injury_drugs(){
        $epcr_info = $this->input->post();

        $na_con_data = array();
        //  $na_con_data = $this->session->set_userdata('na_con_data');


        if (isset($epcr_info['injury'])) {
            foreach ($epcr_info['injury'] as $key => $unit) {
                
              

                if ($unit['id'] != '') {
                    

                        $na_con_data[$key] = array('inv_id' => $unit['id'],
                            'inv_qty' => 0,
                            'inv_type'=>'INT');

                        $args = array('inj_id' => $unit['id']);
                       
                        
                        //$invitem = $this->inv_model->get_inv($args);
                        $invitem = $this->pcr_model->get_injury($args);
                         // var_dump($invitem);

                        $na_con_data[$key]['int_name'] = $invitem[0]->inj_name;
                    
                }
            }
        }
        //var_dump($na_con_data);
        // $inc_ref_id = $this->session->set_userdata('na_con_data',$na_con_data);
        $data['cons_data'] = $na_con_data;

        $this->output->add_to_position($this->load->view('frontend/pcr/intervention_drugs_view', $data, TRUE), 'selected_injury_box_view', TRUE);
        //$this->output->add_to_position($this->load->view('frontend/pcr/non_unit_drugs_view', $data, TRUE), 'selected_non_unit_drugs_view', TRUE);
    
    }
    function show_unit_drugs() {

        $epcr_info = $this->input->post();
        // var_dump($epcr_info);

        $na_con_data = array();
        $cons_data = array();
        $med_cons_data = array();

        if (isset($epcr_info['unit'])) {
            foreach ($epcr_info['unit'] as $key => $unit) {

                if ($unit['value'] != '') {

                    if ($unit['type'] == 'CA') {
                        $cons_data[$key] = array('inv_id' => $unit['id'],
                            'inv_qty' => $unit['value'],
                            'inv_type' => $unit['type']);

                        $args = array('inv_id' => $unit['id'],
                            'inv_type' => $unit['type']);
                        $invitem = $this->inv_model->get_inv($args);

                        $cons_data[$key]['inv_title'] = $invitem[0]->inv_title;
                    }
                }
            }
        }


        if (isset($epcr_info['med'])) {

            foreach ($epcr_info['med'] as $key => $m_unit) {
                if ($m_unit['value'] != '') {
                    if ($m_unit['type'] == 'MED') {

                        $med_cons_data[$key] = array('inv_id' => $m_unit['id'],
                            'inv_qty' => $m_unit['value'],
                            'inv_type' => $m_unit['type']);

                        $args = array('med_id' => $m_unit['id'],
                            'inv_type' => $m_unit['type']);
                        $invitem = $this->med_model->get_med_list($args);

                        $med_cons_data[$key]['inv_title'] = $invitem[0]->med_title;
                    }
                }
            }
        }

        $data['cons_data'] = array_merge($cons_data, $med_cons_data);

        $this->output->add_to_position($this->load->view('frontend/pcr/unit_drugs_view', $data, TRUE), 'show_selected_unit_item', TRUE);
    }
    
    

    function show_non_unit_drugs() {

        $epcr_info = $this->input->post();

        $na_con_data = array();
        //  $na_con_data = $this->session->set_userdata('na_con_data');



        if (isset($epcr_info['non_unit'])) {
            foreach ($epcr_info['non_unit'] as $key => $unit) {

                if ($unit['id'] != '') {
                    if ($unit['type'] == 'NCA') {

                        $na_con_data[$key] = array('inv_id' => $unit['id'],
                            'inv_qty' => 0,
                            'inv_type' => $unit['type']);

                        $args = array('inv_id' => $unit['id'],
                            'inv_type' => $unit['type']);
                        $invitem = $this->inv_model->get_inv($args);

                        $na_con_data[$key]['inv_title'] = $invitem[0]->inv_title;
                    }
                }
            }
        }

        // $inc_ref_id = $this->session->set_userdata('na_con_data',$na_con_data);
        $data['cons_data'] = $na_con_data;


        $this->output->add_to_position($this->load->view('frontend/pcr/non_unit_drugs_view', $data, TRUE), 'selected_non_unit_drugs_view', TRUE);
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

        $data['inc_details'] = $this->pcr_model->get_epcr_inc_details($args_amb);



//        if ($data['inc_details'][0]->id != '') {
//
//            $data['driver_data'] = $this->pcr_model->get_driver(array('dp_pcr_id' => $data['inc_details'][0]->id));
//            $odo_args = array('inc_ref_id' => trim($data['inc_details'][0]->inc_ref_id));
//
//            $data['get_odometer'] = $this->amb_model->get_amb_odometer_by_inc($odo_args);
//        } else {

        $args_odometer = array(
            'amb_rto_register_no' => $data['inc_emp_info'][0]->amb_rto_register_no,
            'inc_ref_id' => trim($data['inc_details'][0]->inc_ref_id)
        );
        $data['get_odometer'] = $this->amb_model->get_amb_odometer_by_inc_amb_no($args_odometer);

//        if (empty($data['previous_odometer'])) {
//            $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;
//        }

        if (empty($data['previous_odometer'])) {
            $data['previous_odometer'] = 0;
        }
//        }
        $this->output->add_to_position($this->load->view('frontend/pcr/epcr_amb_view', $data, TRUE), 'amb_details_block', TRUE);

        $this->output->add_to_position($this->load->view('frontend/pcr/odometer_view', $data, TRUE), 'ercp_odometer_block', TRUE);
    }
    public function job_closure_update_patient_details(){
        $inc_ref_id = $this->session->userdata('inc_ref_id');
        $reopen =$data['reopen']= $this->post['reopen'];
        $epcr_call_type = $this->post['epcr_call_type'];
      
        
         if ($this->post['inc_ref_id'] == '') {
            $this->post['inc_ref_id'] =$inc_ref_id = $this->session->userdata('inc_ref_id');
            $pcr = $this->session->userdata('pcr_details');

            if (isset($pcr)) {
                $inc_id = key($pcr);
                $this->post['inc_ref_id'] = $inc_id;
                $patient_id = $pcr[$inc_id]['patient_id'];
            }
        }else{
            $inc_ref_id =  $this->post['inc_ref_id'];
        }
      


        $args_pat = array(
            'ptn_id' => $this->post['ptn_id'],
            'base_month' => $this->post['base_month'],
        );
         
        $data['pt_info'] = $this->pet_model->get_petinfo($args_pat);
        $inc_id = $this->session->userdata('inc_ref_id');


        $args = array(
            'inc_ref_id' => $inc_ref_id,
            'base_month' => $this->post['base_month'],
            'ptn_id' => $this->post['ptn_id']
        );

        $data['patient_id'] = $this->post['ptn_id'];
      
         if($reopen == 'y'){
           $args['pcr_status'] = '1'; 
           $args['pcr_validation_status'] = '0'; 
        }
 
        $kids_args = array(
                'ptn_id' => $this->post['ptn_id'],
                'inc_ref_id' => $inc_ref_id);
        
            $data['kid_details'] = $this->pcr_model->get_kid_details($kids_args);
           
        
        $data['patient_info'] = $this->pcr_model->get_pending_pat_by_inc($args);
        $data['pt_count'] = count($data['patient_info']);
        $data['user_group'] = $this->clg->clg_group;

        if ($this->post['inc_ref_id'] == '') {
            $this->post['inc_ref_id'] = base64_decode($this->input->get('inc_id'));
        }

       


        if (($this->post['inc_ref_id'] == "") && ($this->post['inc_ref_id'] == NULL )) {

            $this->call_info();
            return;
        }

        $data['inc_ref_id'] = trim($this->post['inc_ref_id']);


        $this->session->set_userdata('inc_ref_id', $this->post['inc_ref_id']);

        $inc_args = array(
            'inc_ref_id' => trim($this->post['inc_ref_id']),
            //  'operator_id' => $this->clg->clg_ref_id,
            'base_month' => $this->post['base_month'],
        );
        if($reopen == 'y'){
            if ($this->post['ptn_id'] != '') {
                $inc_args['ptn_id'] = $this->post['ptn_id'];
            }
        }

        $args = array(
            'inc_ref_id' => trim($this->post['inc_ref_id']),
            'base_month' => $this->post['base_month'],
        );
        $data['vahicle_info'] = $this->pcr_model->get_inc_amb_by_inc($args);


        $ptn_args = array(
            'ptn_id' => $this->post['ptn_id'],
            'base_month' => $this->post['base_month']);

        //$data['patient_info'] = $this->pcr_model->get_pat_by_inc($args);
       // $data['patient_info'] = $this->pcr_model->get_pending_pat_by_inc($args);
        
       $data['inc_details'] = $this->pcr_model->get_epcr_inc_details($inc_args);

      

        if (!empty($data['inc_details'])) {

            if (!isset($pcr)) {
                $pcr_data[$this->post['inc_ref_id']] = array('patient_id' => $data['inc_details'][0]->ptn_id,
                    'inc_ref_id' => $this->post['inc_ref_id'],
                    'rto_no' => $data['inc_details'][0]->amb_reg_id,
                    'pcr_id' => $data['inc_details'][0]->id);
                $this->session->set_userdata('pcr_details', $pcr_data);
            }
        }
       
        if (empty($data['inc_details'])) {
            //$this->session->unset_userdata('pcr_details');
            $data['inc_details'] = $this->inc_model->get_inc_details($inc_args);
        }
        $data['inc_type'] = $this->inc_model->get_inc_details($inc_args);
        $data['inc_details_data'] = $this->inc_model->get_inc_details($inc_args);
        if( $data['inc_details_data'][0]->inc_complaint != 0 && $data['inc_details_data'][0]->inc_complaint != ''){
            $data['ct_type'] = get_cheif_complaint($data['inc_details_data'][0]->inc_complaint);
        }
        if( $data['inc_details_data'][0]->inc_mci_nature != 0 && $data['inc_details_data'][0]->inc_mci_nature != ''){
            $data['ct_type'] = get_mci_nature_service($data['inc_details_data'][0]->inc_mci_nature);
        }
        if (!empty($data['inc_details'])) {
            $amb_args = array(
                'inc_ref_id' => trim($this->post['inc_ref_id']),
                'amb_ref_id' => $data['inc_details'][0]->amb_ref_id,
                'base_month' => $this->post['base_month']);

            $data['inc_emp_info'] = $this->pcr_model->get_inc_amb($amb_args);
            $data['ar_name'] = $data['inc_emp_info'][0]->ar_name;
                //var_dump($data['inc_emp_info']);die();
            $args_odometer = array('rto_no' => $data['inc_emp_info'][0]->amb_rto_register_no);
            //$args_odometer = array( 'inc_ref_id'  =>  trim($this->post['inc_ref_id']));

            $amb_odometer = $this->amb_model->get_amb_odometer_closure($args_odometer);
            $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;

            if (empty($data['previous_odometer'])) {
                $data['previous_odometer'] = 0;
            }


            $args = array(
                'pcr_id' => $data['inc_details'][0]->id,
                'patient_id' => $data['inc_details'][0]->ptn_id,
                'base_month' => $this->post['base_month']
            );

            $data['driver_data'] = array();

            if (!empty($data['inc_details'][0]->id)) {


                $data['driver_data'] = $this->pcr_model->get_driver(array('dp_pcr_id' => $data['inc_details'][0]->id));
              
                //$data['driver_data'] = $this->pcr_model->get_driver(array( 'inc_ref_id' => trim($this->post['inc_ref_id'])));
                $odo_args = array('inc_ref_id' => trim($data['inc_details'][0]->inc_ref_id));


                $data['get_odometer'] = $this->amb_model->get_amb_odometer_by_inc($odo_args);


                $data['get_odometer']['start_odmeter'] = $data['inc_details'][0]->start_odometer;
                $data['get_odometer']['end_odmeter'] = $data['inc_details'][0]->end_odometer;
            }

            $args_odometer = array('inc_ref_id' => trim($this->post['inc_ref_id']));

            $data['get_odometer'] = $this->amb_model->get_amb_odometer_by_inc($args_odometer);

            $get_amb_stock = array('pcr_id' => $data['inc_details'][0]->id,
                'sub_type' => 'pcr',
                'as_item_type' => 'NCA');

            $data['pcr_na_med_inv_data'] = $this->ind_model->get_amb_stock($get_amb_stock);

            $get_amb_stock = array('pcr_id' => $data['inc_details'][0]->id,
                'sub_type' => 'pcr',
                'as_item_type' => 'CA');

            $data['pcr_med_inv_data'] = $this->ind_model->get_amb_stock($get_amb_stock);

            $get_med_amb_stock = array('pcr_id' => $data['inc_details'][0]->id,
                'sub_type' => 'pcr',
                'as_item_type' => 'MED');

            $data['pcr_med_data'] = $this->ind_model->get_amb_stock($get_med_amb_stock);

            $non_unit_args = array(
                'inv_id' => $data['inc_details'][0]->drugs,
            );

            $args = array('inv_type' => 'CA');
            $data['invitem'] = $this->inv_model->get_inv_list($args);

            $non_args = array('inv_type' => 'NCA');
            $data['noninvitem'] = $this->inv_model->get_inv_list($non_args);

            $data['med_list'] = $this->med_model->get_med_list();
            $data['intervention_list'] = $this->med_model->get_intervention_list();
            $data['injury_list'] = $this->pcr_model->get_injury();       
            
            //////////////////// Update progressbar ///////////////////////////
            
            //$this->increase_step($data['inc_details'][0]->id);
            
            ///////////////////////////////////////////////////////////////////

            $this->output->status = 1;

            $this->output->closepopup = "yes";
            $data['inc_type'] = $data['inc_type'][0]->inc_type;
            
            
            $data['inc_details'][0]->inc_type = $data['inc_type'] ;
            $data['epcr_call_type'] = $epcr_call_type;
            $data['amb_type'] = $data['inc_emp_info'][0]->ambt_id;
            if($epcr_call_type == '1'){
                $this->output->add_to_position($this->load->view('frontend/pcr/patient_notavailable_epcr_view', $data, TRUE), 'call_type_view', TRUE);
            }elseif($epcr_call_type == '2'){
              
                $this->output->add_to_position($this->load->view('frontend/pcr/patient_available_epcr_view', $data, TRUE), 'call_type_view', TRUE);
            }elseif($epcr_call_type == '3'){
                $this->output->add_to_position($this->load->view('frontend/pcr/on_scene_care_epcr_view', $data, TRUE), 'call_type_view', TRUE);
            }
           // $this->output->add_to_position($this->load->view('frontend/pcr/epcr_view1', $data, TRUE), 'content', TRUE);
        }
//        if($epcr_call_type == '3'){
//            
//            $this->output->add_to_position($this->load->view('frontend/pcr/onscene_job_closure_pat_view', $data, TRUE), 'pat_details_block', TRUE);
//        }else{
            
            $this->output->add_to_position($this->load->view('frontend/pcr/job_closure_pat_view', $data, TRUE), 'pat_details_block', TRUE);
        //}
        ////////////////////////////////////////////////////////////////////////////////

//        if($epcr_call_type == '3'){
//             $lnk = "<a href='" . base_url() . "pcr/add_patient_details_onscene' class='click-xhttp-request style1' data-qr='ptn_id=" . $this->post['ptn_id'] . "' data-popupwidth='1250' data-popupheight='870'>( Update New patient details )</a>";
//        }else{
          $inc_ref_id =  $this->post['inc_ref_id'];
        $lnk = "<a href='" . base_url() . "pcr/add_patient_details' class='click-xhttp-request style1' data-qr='ptn_id=".$this->post['ptn_id']."&inc_ref_id=".$inc_ref_id."&reopen=".$reopen."' data-popupwidth='1250' data-popupheight='870'>( Update New Patient Details )</a><a href='" . base_url() . "pcr/delete_patient_details' class='click-xhttp-request style1' data-qr='ptn_id=" . $this->post['ptn_id'] . "' data-confirm='yes' data-confirmmessage='Are you sure to delete' style='color:#f00  !important'>( Delete Patient )</a>";
        //}

        $this->output->add_to_position($lnk, 'ptn_form_lnk', TRUE);
    }
    
    public function delete_patient_details(){
        $pat_id = $this->post['ptn_id'];
          $args = array(
            'ptnis_deleted' => '1',
            
        );
        $args1 = array(
            'epcris_deleted' => '1',
            
        );


        $this->pet_model->update_petinfo(array('ptn_id' => $pat_id), $args);        
        $this->pet_model->update_validate_patinfo($args1,$pat_id);        
        $this->update_patient_details();         
    }
    public function update_new_patient_details_onscene(){
        $inc_id = $inc_ref_id = $this->session->userdata('inc_ref_id');
        $reopen =$data['reopen']= $this->post['reopen'];
       


        $args_pat = array(
            'ptn_id' => $this->post['ptn_id'],
            'base_month' => $this->post['base_month'],
        );
        $data['pt_info'] = $this->pet_model->get_petinfo($args_pat);
        $inc_id = $this->session->userdata('inc_ref_id');


        $args = array(
            'inc_ref_id' => $inc_ref_id,
            'base_month' => $this->post['base_month'],
        );

        $data['patient_id'] = $this->post['ptn_id'];
          if($reopen == 'y'){
           $args['pcr_status'] = '1'; 
        }
        $data['patient_info'] = $this->pcr_model->get_pending_pat_by_inc($args);
//         $this->clg = $this->session->userdata('current_user');
//          
//          if($this->clg->clg_ref_id == 'dco-9'){
//               var_dump($args );
//              var_dump($data['patient_info'] );
//              die();
//          }
        $arrLength = count($data['patient_info']);
        //var_dump($arrLength);
        $data['pt_count'] = $arrLength;
        $data['user_group'] = $this->clg->clg_group;

        if ($this->post['inc_ref_id'] == '') {
            $this->post['inc_ref_id'] = base64_decode($this->input->get('inc_id'));
        }

        if ($this->post['inc_ref_id'] == '') {
            $this->post['inc_ref_id'] = $this->session->userdata('inc_ref_id');
            $pcr = $this->session->userdata('pcr_details');

            if (isset($pcr)) {
                $inc_id = key($pcr);
                $this->post['inc_ref_id'] = $inc_id;
                $patient_id = $pcr[$inc_id]['patient_id'];
            }
        }


        if (($this->post['inc_ref_id'] == "") && ($this->post['inc_ref_id'] == NULL )) {

            $this->call_info();
            return;
        }

        $data['inc_ref_id'] = trim($this->post['inc_ref_id']);


        $this->session->set_userdata('inc_ref_id', $this->post['inc_ref_id']);

        $inc_args = array(
            'inc_ref_id' => trim($this->post['inc_ref_id']),
            //  'operator_id' => $this->clg->clg_ref_id,
            'base_month' => $this->post['base_month'],
        );
        if ($this->post['ptn_id'] != '') {
            $inc_args['ptn_id'] = $this->post['ptn_id'];
        }

        $args = array(
            'inc_ref_id' => trim($this->post['inc_ref_id']),
            'base_month' => $this->post['base_month'],
        );
        $data['vahicle_info'] = $this->pcr_model->get_inc_amb_by_inc($args);


        $ptn_args = array(
            'ptn_id' => $this->post['ptn_id'],
            'base_month' => $this->post['base_month']);

        //$data['patient_info'] = $this->pcr_model->get_pat_by_inc($args);
       // $data['patient_info'] = $this->pcr_model->get_pending_pat_by_inc($args);
        
        

        $data['inc_details'] = $this->pcr_model->get_epcr_inc_details($inc_args);

        if (!empty($data['inc_details'])) {

            if (!isset($pcr)) {
                $pcr_data[$this->post['inc_ref_id']] = array('patient_id' => $data['inc_details'][0]->ptn_id,
                    'inc_ref_id' => $this->post['inc_ref_id'],
                    'rto_no' => $data['inc_details'][0]->amb_reg_id,
                    'pcr_id' => $data['inc_details'][0]->id);
                $this->session->set_userdata('pcr_details', $pcr_data);
            }
        }
        if (empty($data['inc_details'])) {
            //$this->session->unset_userdata('pcr_details');
            $data['inc_details'] = $this->inc_model->get_inc_details($inc_args);
        }
        $data['inc_details_data'] = $this->inc_model->get_inc_details($inc_args);
        if (!empty($data['inc_details'])) {
            $amb_args = array(
                'inc_ref_id' => trim($this->post['inc_ref_id']),
                'amb_ref_id' => $data['inc_details'][0]->amb_ref_id,
                'base_month' => $this->post['base_month']);

            $data['inc_emp_info'] = $this->pcr_model->get_inc_amb($amb_args);


            $args_odometer = array('rto_no' => $data['inc_emp_info'][0]->amb_rto_register_no);
            //$args_odometer = array( 'inc_ref_id'  =>  trim($this->post['inc_ref_id']));

            $amb_odometer = $this->amb_model->get_amb_odometer($args_odometer);
            $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;

            if (empty($data['previous_odometer'])) {
                $data['previous_odometer'] = 0;
            }


            $args = array(
                'pcr_id' => $data['inc_details'][0]->id,
                'patient_id' => $data['inc_details'][0]->ptn_id,
                'base_month' => $this->post['base_month']
            );

            $data['driver_data'] = array();


            if (!empty($data['inc_details'][0]->id)) {


                $data['driver_data'] = $this->pcr_model->get_driver(array('dp_pcr_id' => $data['inc_details'][0]->id));

                $odo_args = array('inc_ref_id' => trim($data['inc_details'][0]->inc_ref_id));


                $data['get_odometer'] = $this->amb_model->get_amb_odometer_by_inc($odo_args);


                $data['get_odometer']['start_odmeter'] = $data['inc_details'][0]->start_odometer;
                $data['get_odometer']['end_odmeter'] = $data['inc_details'][0]->end_odometer;
            }

            $args_odometer = array('inc_ref_id' => trim($this->post['inc_ref_id']));

            $data['get_odometer'] = $this->amb_model->get_amb_odometer_by_inc($args_odometer);

            $get_amb_stock = array('pcr_id' => $data['inc_details'][0]->id,
                'sub_type' => 'pcr',
                'as_item_type' => 'NCA');

            $data['pcr_na_med_inv_data'] = $this->ind_model->get_amb_stock($get_amb_stock);

            $get_amb_stock = array('pcr_id' => $data['inc_details'][0]->id,
                'sub_type' => 'pcr',
                'as_item_type' => 'CA');

            $data['pcr_med_inv_data'] = $this->ind_model->get_amb_stock($get_amb_stock);

            $get_med_amb_stock = array('pcr_id' => $data['inc_details'][0]->id,
                'sub_type' => 'pcr',
                'as_item_type' => 'MED');

            $data['pcr_med_data'] = $this->ind_model->get_amb_stock($get_med_amb_stock);

            $non_unit_args = array(
                'inv_id' => $data['inc_details'][0]->drugs,
            );

            $args = array('inv_type' => 'CA');
            $data['invitem'] = $this->inv_model->get_inv_list($args);

            $non_args = array('inv_type' => 'NCA');
            $data['noninvitem'] = $this->inv_model->get_inv_list($non_args);

            $data['med_list'] = $this->med_model->get_med_list();
            //////////////////// Update progressbar ///////////////////////////
            //$this->increase_step($data['inc_details'][0]->id);
            ///////////////////////////////////////////////////////////////////

            $this->output->status = 1;

            $this->output->closepopup = "yes";


           // $this->output->add_to_position($this->load->view('frontend/pcr/epcr_view1', $data, TRUE), 'content', TRUE);
        }

        $this->output->add_to_position($this->load->view('frontend/pcr/job_closure_pat_view', $data, TRUE), 'pat_details_block', TRUE);
        ////////////////////////////////////////////////////////////////////////////////

         $inc_ref_id =  $this->post['inc_ref_id'];
        $lnk = "<a href='" . base_url() . "pcr/add_patient_details_onscene' class='click-xhttp-request style1' data-qr='ptn_id=".$this->post['ptn_id']."&inc_ref_id=".$inc_ref_id."&reopen=".$reopen."' data-popupwidth='1250' data-popupheight='870'>( Update New patient details )</a><a href='" . base_url() . "pcr/delete_patient_details' class='click-xhttp-request style1' data-qr='ptn_id=" . $this->post['ptn_id'] . "' data-confirm='yes' data-confirmmessage='Are you sure to delete' style='color:#f00  !important'>( Delete Patient )</a>";

        $this->output->add_to_position($lnk, 'ptn_form_lnk', TRUE);
    }
    public function update_new_patient_details(){
    
        $inc_id = $inc_ref_id =$this->post['inc_id'];
        $data['reopen'] = $reopen = $this->post['reopen'];
//        if($inc_ref_id == ''){
//            $inc_id = $inc_ref_id = $this->session->userdata('inc_ref_id');
//        }
      


        $args_pat = array(
            'ptn_id' => $this->post['ptn_id'],
            'base_month' => $this->post['base_month'],
        );
        $data['pt_info'] = $this->pet_model->get_petinfo($args_pat);
        //$inc_id = $this->session->userdata('inc_ref_id');


        $args = array(
            'inc_ref_id' => $inc_ref_id,
            'base_month' => $this->post['base_month'],
        );

        $data['patient_id'] = $this->post['ptn_id'];
        if($reopen == 'y'){
           $args['pcr_status'] = '1'; 
        }

        $data['patient_info'] = $this->pcr_model->get_pending_pat_by_inc($args);
        $arrLength = count($data['patient_info']);
        //var_dump($arrLength);
        $data['pt_count'] = $arrLength;
        $data['user_group'] = $this->clg->clg_group;

        if ($this->post['inc_ref_id'] == '') {
            $this->post['inc_ref_id'] = base64_decode($this->input->get('inc_id'));
        }

        if ($this->post['inc_ref_id'] == '') {
            $this->post['inc_ref_id'] = $this->session->userdata('inc_ref_id');
            $pcr = $this->session->userdata('pcr_details');

            if (isset($pcr)) {
                $inc_id = key($pcr);
                $this->post['inc_ref_id'] = $inc_id;
                $patient_id = $pcr[$inc_id]['patient_id'];
            }
        }


        if (($this->post['inc_ref_id'] == "") && ($this->post['inc_ref_id'] == NULL )) {

            $this->call_info();
            return;
        }

        $data['inc_ref_id'] = trim($this->post['inc_ref_id']);


        $this->session->set_userdata('inc_ref_id', $this->post['inc_ref_id']);

        $inc_args = array(
            'inc_ref_id' => trim($this->post['inc_ref_id']),
            //  'operator_id' => $this->clg->clg_ref_id,
            'base_month' => $this->post['base_month'],
        );
        if ($this->post['ptn_id'] != '') {
            $inc_args['ptn_id'] = $this->post['ptn_id'];
        }

        $args = array(
            'inc_ref_id' => trim($this->post['inc_ref_id']),
            'base_month' => $this->post['base_month'],
        );
        $data['vahicle_info'] = $this->pcr_model->get_inc_amb_by_inc($args);


        $ptn_args = array(
            'ptn_id' => $this->post['ptn_id'],
            'base_month' => $this->post['base_month']);

        //$data['patient_info'] = $this->pcr_model->get_pat_by_inc($args);
       // $data['patient_info'] = $this->pcr_model->get_pending_pat_by_inc($args);
        
        

        $data['inc_details'] = $this->pcr_model->get_epcr_inc_details($inc_args);

        if (!empty($data['inc_details'])) {

            if (!isset($pcr)) {
                $pcr_data[$this->post['inc_ref_id']] = array('patient_id' => $data['inc_details'][0]->ptn_id,
                    'inc_ref_id' => $this->post['inc_ref_id'],
                    'rto_no' => $data['inc_details'][0]->amb_reg_id,
                    'pcr_id' => $data['inc_details'][0]->id);
                $this->session->set_userdata('pcr_details', $pcr_data);
            }
        }
        if (empty($data['inc_details'])) {
            //$this->session->unset_userdata('pcr_details');
            $data['inc_details'] = $this->inc_model->get_inc_details($inc_args);
        }
        $data['inc_details_data'] = $this->inc_model->get_inc_details($inc_args);
        if (!empty($data['inc_details'])) {
            $amb_args = array(
                'inc_ref_id' => trim($this->post['inc_ref_id']),
                'amb_ref_id' => $data['inc_details'][0]->amb_ref_id,
                'base_month' => $this->post['base_month']);

            $data['inc_emp_info'] = $this->pcr_model->get_inc_amb($amb_args);


            $args_odometer = array('rto_no' => $data['inc_emp_info'][0]->amb_rto_register_no);
            //$args_odometer = array( 'inc_ref_id'  =>  trim($this->post['inc_ref_id']));

            $amb_odometer = $this->amb_model->get_amb_odometer($args_odometer);
            $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;

            if (empty($data['previous_odometer'])) {
                $data['previous_odometer'] = 0;
            }


            $args = array(
                'pcr_id' => $data['inc_details'][0]->id,
                'patient_id' => $data['inc_details'][0]->ptn_id,
                'base_month' => $this->post['base_month']
            );

            $data['driver_data'] = array();


            if (!empty($data['inc_details'][0]->id)) {


                $data['driver_data'] = $this->pcr_model->get_driver(array('dp_pcr_id' => $data['inc_details'][0]->id));

                $odo_args = array('inc_ref_id' => trim($data['inc_details'][0]->inc_ref_id));


                $data['get_odometer'] = $this->amb_model->get_amb_odometer_by_inc($odo_args);


                $data['get_odometer']['start_odmeter'] = $data['inc_details'][0]->start_odometer;
                $data['get_odometer']['end_odmeter'] = $data['inc_details'][0]->end_odometer;
            }

            $args_odometer = array('inc_ref_id' => trim($this->post['inc_ref_id']));

            $data['get_odometer'] = $this->amb_model->get_amb_odometer_by_inc($args_odometer);

            $get_amb_stock = array('pcr_id' => $data['inc_details'][0]->id,
                'sub_type' => 'pcr',
                'as_item_type' => 'NCA');

            $data['pcr_na_med_inv_data'] = $this->ind_model->get_amb_stock($get_amb_stock);

            $get_amb_stock = array('pcr_id' => $data['inc_details'][0]->id,
                'sub_type' => 'pcr',
                'as_item_type' => 'CA');

            $data['pcr_med_inv_data'] = $this->ind_model->get_amb_stock($get_amb_stock);

            $get_med_amb_stock = array('pcr_id' => $data['inc_details'][0]->id,
                'sub_type' => 'pcr',
                'as_item_type' => 'MED');

            $data['pcr_med_data'] = $this->ind_model->get_amb_stock($get_med_amb_stock);

            $non_unit_args = array(
                'inv_id' => $data['inc_details'][0]->drugs,
            );

            $args = array('inv_type' => 'CA');
            $data['invitem'] = $this->inv_model->get_inv_list($args);

            $non_args = array('inv_type' => 'NCA');
            $data['noninvitem'] = $this->inv_model->get_inv_list($non_args);

            $data['med_list'] = $this->med_model->get_med_list();
            //////////////////// Update progressbar ///////////////////////////
            //$this->increase_step($data['inc_details'][0]->id);
            ///////////////////////////////////////////////////////////////////

            $this->output->status = 1;

            $this->output->closepopup = "yes";


           // $this->output->add_to_position($this->load->view('frontend/pcr/epcr_view1', $data, TRUE), 'content', TRUE);
        }

        $this->output->add_to_position($this->load->view('frontend/pcr/job_closure_pat_view', $data, TRUE), 'pat_details_block', TRUE);
        ////////////////////////////////////////////////////////////////////////////////
        $inc_ref_id =$this->post['inc_ref_id'];
        $lnk = "<a href='" . base_url() . "pcr/add_patient_details' class='click-xhttp-request style1' data-qr='ptn_id=".trim($this->post['ptn_id'])."&inc_ref_id=".$inc_ref_id."&reopen=".$reopen."' data-popupwidth='1250' data-popupheight='870'>( Update New patient details )</a><a href='" . base_url() . "pcr/delete_patient_details' class='click-xhttp-request style1' data-qr='ptn_id=" . $this->post['ptn_id'] . "' data-confirm='yes' data-confirmmessage='Are you sure to delete' style='color:#f00  !important'>( Delete Patient )</a>";

        $this->output->add_to_position($lnk, 'ptn_form_lnk', TRUE);
    }
    public function update_patient_details() {

        $inc_ref_id = $this->session->userdata('inc_ref_id');


        $args_pat = array(
            'ptn_id' => $this->post['ptn_id'],
            'base_month' => $this->post['base_month'],
        );
        $data['pt_info'] = $this->pet_model->get_petinfo($args_pat);
        $inc_id = $this->session->userdata('inc_ref_id');


        $args = array(
            'inc_ref_id' => $inc_ref_id,
            'base_month' => $this->post['base_month'],
        );

        $data['patient_id'] = $this->post['ptn_id'];
        $data['patient_info'] = $this->pcr_model->get_pending_pat_by_inc($args);
        $data['user_group'] = $this->clg->clg_group;

        if ($this->post['inc_ref_id'] == '') {
            $this->post['inc_ref_id'] = base64_decode($this->input->get('inc_id'));
        }

        if ($this->post['inc_ref_id'] == '') {
            $this->post['inc_ref_id'] = $this->session->userdata('inc_ref_id');
            $pcr = $this->session->userdata('pcr_details');

            if (isset($pcr)) {
                $inc_id = key($pcr);
                $this->post['inc_ref_id'] = $inc_id;
                $patient_id = $pcr[$inc_id]['patient_id'];
            }
        }


        if (($this->post['inc_ref_id'] == "") && ($this->post['inc_ref_id'] == NULL )) {

            $this->call_info();
            return;
        }

        $data['inc_ref_id'] = trim($this->post['inc_ref_id']);


        $this->session->set_userdata('inc_ref_id', $this->post['inc_ref_id']);

        $inc_args = array(
            'inc_ref_id' => trim($this->post['inc_ref_id']),
            //  'operator_id' => $this->clg->clg_ref_id,
            'base_month' => $this->post['base_month'],
        );
        if ($this->post['ptn_id'] != '') {
            $inc_args['ptn_id'] = $this->post['ptn_id'];
        }

        $args = array(
            'inc_ref_id' => trim($this->post['inc_ref_id']),
            'base_month' => $this->post['base_month'],
        );
        $data['vahicle_info'] = $this->pcr_model->get_inc_amb_by_inc($args);


        $ptn_args = array(
            'ptn_id' => $this->post['ptn_id'],
            'base_month' => $this->post['base_month']);

        //$data['patient_info'] = $this->pcr_model->get_pat_by_inc($args);
       // $data['patient_info'] = $this->pcr_model->get_pending_pat_by_inc($args);
        
        

        $data['inc_details'] = $this->pcr_model->get_epcr_inc_details($inc_args);

        if (!empty($data['inc_details'])) {

            if (!isset($pcr)) {
                $pcr_data[$this->post['inc_ref_id']] = array('patient_id' => $data['inc_details'][0]->ptn_id,
                    'inc_ref_id' => $this->post['inc_ref_id'],
                    'rto_no' => $data['inc_details'][0]->amb_reg_id,
                    'pcr_id' => $data['inc_details'][0]->id);
                $this->session->set_userdata('pcr_details', $pcr_data);
            }
        }
        if (empty($data['inc_details'])) {
            //$this->session->unset_userdata('pcr_details');
            $data['inc_details'] = $this->inc_model->get_inc_details($inc_args);
        }
        $data['inc_details_data'] = $this->inc_model->get_inc_details($inc_args);
        if (!empty($data['inc_details'])) {
            $amb_args = array(
                'inc_ref_id' => trim($this->post['inc_ref_id']),
                'amb_ref_id' => $data['inc_details'][0]->amb_ref_id,
                'base_month' => $this->post['base_month']);

            $data['inc_emp_info'] = $this->pcr_model->get_inc_amb($amb_args);


            $args_odometer = array('rto_no' => $data['inc_emp_info'][0]->amb_rto_register_no);
            //$args_odometer = array( 'inc_ref_id'  =>  trim($this->post['inc_ref_id']));

            $amb_odometer = $this->amb_model->get_amb_odometer($args_odometer);
            $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;

            if (empty($data['previous_odometer'])) {
                $data['previous_odometer'] = 0;
            }


            $args = array(
                'pcr_id' => $data['inc_details'][0]->id,
                'patient_id' => $data['inc_details'][0]->ptn_id,
                'base_month' => $this->post['base_month']
            );

            $data['driver_data'] = array();


            if (!empty($data['inc_details'][0]->id)) {


                $data['driver_data'] = $this->pcr_model->get_driver(array('dp_pcr_id' => $data['inc_details'][0]->id));

                $odo_args = array('inc_ref_id' => trim($data['inc_details'][0]->inc_ref_id));


                $data['get_odometer'] = $this->amb_model->get_amb_odometer_by_inc($odo_args);


                $data['get_odometer']['start_odmeter'] = $data['inc_details'][0]->start_odometer;
                $data['get_odometer']['end_odmeter'] = $data['inc_details'][0]->end_odometer;
            }

            $args_odometer = array('inc_ref_id' => trim($this->post['inc_ref_id']));

            $data['get_odometer'] = $this->amb_model->get_amb_odometer_by_inc($args_odometer);

            $get_amb_stock = array('pcr_id' => $data['inc_details'][0]->id,
                'sub_type' => 'pcr',
                'as_item_type' => 'NCA');

            $data['pcr_na_med_inv_data'] = $this->ind_model->get_amb_stock($get_amb_stock);

            $get_amb_stock = array('pcr_id' => $data['inc_details'][0]->id,
                'sub_type' => 'pcr',
                'as_item_type' => 'CA');

            $data['pcr_med_inv_data'] = $this->ind_model->get_amb_stock($get_amb_stock);

            $get_med_amb_stock = array('pcr_id' => $data['inc_details'][0]->id,
                'sub_type' => 'pcr',
                'as_item_type' => 'MED');

            $data['pcr_med_data'] = $this->ind_model->get_amb_stock($get_med_amb_stock);

            $non_unit_args = array(
                'inv_id' => $data['inc_details'][0]->drugs,
            );

            $args = array('inv_type' => 'CA');
            $data['invitem'] = $this->inv_model->get_inv_list($args);

            $non_args = array('inv_type' => 'NCA');
            $data['noninvitem'] = $this->inv_model->get_inv_list($non_args);

            $data['med_list'] = $this->med_model->get_med_list();
            //////////////////// Update progressbar ///////////////////////////
            //$this->increase_step($data['inc_details'][0]->id);
            ///////////////////////////////////////////////////////////////////

            $this->output->status = 1;

            $this->output->closepopup = "yes";


           // $this->output->add_to_position($this->load->view('frontend/pcr/epcr_view1', $data, TRUE), 'content', TRUE);
        }

        $this->output->add_to_position($this->load->view('frontend/pcr/epcr_pat_view', $data, TRUE), 'pat_details_block', TRUE);
        ////////////////////////////////////////////////////////////////////////////////

        $lnk = "<a href='" . base_url() . "pcr/patient_details' class='click-xhttp-request style1' data-qr='ptn_id=" . $this->post['ptn_id'] . "' data-popupwidth='1250' data-popupheight='870'>( Update Patient Details )</a><a href='" . base_url() . "pcr/delete_patient_details' class='click-xhttp-request style1' data-qr='ptn_id=" . $this->post['ptn_id'] . "' data-confirm='yes' data-confirmmessage='Are you sure to delete' style='color:#f00  !important'>( Delete Patient )</a>";

        $this->output->add_to_position($lnk, 'ptn_form_lnk', TRUE);
    }

////////////////////////////// Added by MI42  ///////////////////////////////
    // 
    // Purpose : Show Patient history.
    //
    ////////////////////////////////////////////////////////////////////////////


    function patient_history() {


        $pcr = $this->session->userdata('pcr_details');


        if (empty($pcr)) {

            $this->output->message = "<div class='error'>Please fill Trip closer first</div>";

            return;
        }


        $inc_id = key($pcr);

        $pcr_id = $pcr[$inc_id]['pcr_id'];


        $pcr_details = $this->pcr_model->get_pcr_details(array('pcr_id' => $pcr_id));

        $data['ptn'] = $this->pet_model->get_petinfo(array('ptn_id' => $pcr_details[0]->patient_id));



        ////////////////////////////////////////////////////////////////////////////////////////


        $data['chief_comp'] = $this->call_model->get_chief_comp();

        $data['case_type'] = $this->common_model->case_type();

        $data['med_his'] = $this->common_model->past_med_his();


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

                    $odis .= $mdh->dis_title . ",";
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


            $data['cc_other'] = $ccom[0]->cc_other;

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
                'case_other' => $this->post['case_other'],
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
                'cc_other' => $this->post['his_occ'],
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

        /////////////////////////////////////////////////////////////

        pcr_steps($this->post['pcr_id'], "HIS");

        /////////////////////////////////////////////////////////////


        $this->output->message = "<div class='success'> History saved successfully <script>$('#PCR_STEPS a[data-pcr_step=4]').click();</script></div>";

        //////////////////// Update progressbar ///////////////////////////

        $this->increase_step($this->post['pcr_id']);

        ///////////////////////////////////////////////////////////////////
    }

    ///////////MI44///////////////////////////
    //
    //Purpose : Patient management 1
    //
    ///////////////////////////////////////////


    function patient_mng() {

        $pcr_data = $this->session->userdata('pcr_details');

        if ($pcr_data) {

            $inc_id = key($pcr_data);

            $data['get_pat_mng_data'] = $this->pcr_model->get_pat_mng_data(array('pcr_id' => $pcr_data[$inc_id]['pcr_id']));

            $add_adv_data = $data['check_inc_id'] = $this->medadv_model->check_inc_ref_id(array('adv_inc_ref_id' => $inc_id));


            if (count($add_adv_data) > 0) {

                foreach ($add_adv_data as $adv_data) {

                    $args = array('adv_cl_inc_id' => $adv_data->adv_inc_ref_id,
                        'adv_cl_adv_id' => $adv_data->adv_ids,
                        'base_month' => $adv_data->base_month,
                        'is_deleted' => 'false');

                    $data['result'][] = $this->medadv_model->prev_call_adv($args);
                }
            }

            $this->output->add_to_position($this->load->view('frontend/pcr/patient_management_view', $data, TRUE), 'content', TRUE);
        } else {
            $this->output->message = "<div class='error'>Please fill trip closer form first</div>";
        }
    }

    ///////////////MI44///////////////////
    //
    //Purpose : Driver pcr
    //
    /////////////////////////////////////

    function driver_pcr() {

        $pcr_data = $this->session->userdata('pcr_details');

        if ($pcr_data) {
            $inc_id = key($pcr_data);

            $data['driver_data'] = $this->pcr_model->get_driver(array('dp_pcr_id' => $pcr_data[$inc_id]['pcr_id']));

            $this->output->add_to_position($this->load->view('frontend/pcr/driver_pcr_view', $data, TRUE), 'content', TRUE);
        } else {
            $this->output->message = "<div class='error'>Please fill trip closer form first</div>";
        }
    }

    ///////////MI44///////////////////////////
    //
    //Purpose : Save Patient management 1 details
    //
    ///////////////////////////////////////////


    function save_patient_mng() {

        $pcr = $this->session->userdata('pcr_details');

        $inc_id = key($pcr);

        if ($this->post['adv_id'] != '') {
            $ercp_advice = implode(',', $this->post['adv_id']);
        }
        $start_time = ($this->post['start_time'] != '' && $this->post['start_time'] != '00:00:00') ? date("Y-m-d" . " " . $this->post['start_time']) : '';

        $ass = array('as_emt_notes' => $this->post['emt_notes'],
            'as_ercp_advice' => $this->post['ercp_adv'],
            'as_ercp_advice_auto_trans' => $ercp_advice,
            'as_pcr_id' => $pcr[$inc_id]['pcr_id']
        );

        $cardic = array('cr_bystander_cpr' => $this->post['bystan_cpr'],
            'cr_rosc' => $this->post['rosc'],
            'cr_puls_rosc' => $this->post['pulse_at_rosc'],
            'cr_no_of_shocks' => $this->post['shocks'],
            'cr_diastolic' => $this->post['dyast'],
            'cr_start_time' => $start_time,
            'cr_systolic' => $this->post['syst'],
            'cr_loc_at_rosc' => $this->post['loc_at_rosc'],
            'cr_pcr_id' => $pcr[$inc_id]['pcr_id']
        );

        $birth = array('birth_at_home' => $this->post['birth_home'],
            'birth_at_amb' => $this->post['birth_amb'],
            'birth_time' => $this->post['time_of_birth'],
            'birth_pcr_id' => $pcr[$inc_id]['pcr_id']
        );

        $apgar = array('ap_1min' => $this->post['score1'],
            'ap_5min' => $this->post['score5'],
            'ap_pcr_id' => $pcr[$inc_id]['pcr_id']
        );

        $insert_ass = $this->pcr_model->insert_assessment($ass);

        $insert_cardic = $this->pcr_model->insert_cardic($cardic);

        $insert_birth = $this->pcr_model->insert_birth_details($birth);

        $insert_cardic = $this->pcr_model->insert_apgar($apgar);

        /////////////////////////////////////////////////////////////

        pcr_steps($pcr[$inc_id]['pcr_id'], "MG1");

        /////////////////////////////////////////////////////////////

        if ($insert_ass && $insert_cardic && $insert_birth && $insert_cardic) {
            $this->output->message = "<div class='success'>Patient assessment saved sucessfully!<script>$('#PCR_STEPS a[data-pcr_step=8]').click();</script></div>";

            /////////////////////// Update progressbar /////////////////////

            $this->increase_step($pcr[$inc_id]['pcr_id']);

            ///////////////////////////////////////////////////////////////
        } else {
            $this->output->message = "<div class='error'>Something going wrong</div>";
        }
    }

    ////////////////MI44// Purose: birth at ambulance view/////////////////

    function birth_amb() {

        $data['birth_home'] = $this->post['birth_home'];

        $this->output->add_to_position($this->load->view('frontend/pcr/birth_ambulance_view', $data, TRUE), 'birth_amb', TRUE);
    }

    ///////////////MI44///////////////////
    //
    //Purpose : Save Driver pcr
    //
    /////////////////////////////////////

    function save_driver_pcr() {

        //////////////////////////////////////////////////////////////

        $pcr = $this->session->userdata('pcr_details');

        $inc_id = key($pcr);

        $current_user = $this->session->userdata('current_user');

        /////////////////////////////////////////////////////

        $data = array('dp_cl_from_desk' => $this->post['cl_from_dsk'],
            'dp_cl_from_dsk_km' => $this->post['cl_from_dsk_km'],
            'dp_started_base_loc' => $this->post['started_base_loc'],
            'dp_started_base_loc_km' => $this->post['started_base_loc_km'],
            'dp_reach_on_scene' => $this->post['reached_on_scene'],
            'dp_reach_on_scene_km' => $this->post['reached_on_scene_km'],
            'dp_on_scene' => $this->post['on_scene_time'],
            'dp_on_scene_km' => $this->post['on_scene_km'],
            'dp_hosp_time' => $this->post['scene_hosp_time'],
            'dp_hosp_time_km' => $this->post['scene_hosp_km'],
            'dp_hand_time' => $this->post['pat_hand_time'],
            'dp_back_to_loc' => $this->post['back_to_base_loc'],
            'dp_back_to_loc_km' => $this->post['back_to_base_loc_km'],
            'dp_pcr_id' => $pcr[$inc_id]['pcr_id'],
            'dp_operated_by' => $current_user->clg_ref_id,
            'dp_base_month' => $this->post['base_month'],
            'dp_date' => date('Y-m-d H:i:s')
        );
        $insert = $this->pcr_model->insert_deriver_pcr($data);

        /////////////////////////////////////////////////////////////

        pcr_steps($pcr[$inc_id]['pcr_id'], "DPR");

        /////////////////////////////////////////////////////////////

        if ($insert) {
            $this->output->message = "<div class='success'>Driver PCR saved sucessfully!<script>$('#PCR_STEPS a[data-pcr_step=1]').click();</script></div>";

            /////////////////////// Update progressbar /////////////////////

            $this->increase_step($pcr[$inc_id]['pcr_id']);

            ///////////////////////////////////////////////////////////////
        } else {
            $this->output->message = "<div class='error'>Something going wrong</div>";
        }
    }

    function hospital_transfer() {




        $pcr_data = $this->session->userdata('pcr_details');
        $inc_id = key($pcr_data);
        $pcr_id = $pcr_data[$inc_id]['pcr_id'];
        $patient_id = $pcr_data[$inc_id]['patient_id '];
        //  
//        $pcr_id     = '11' ;
//        $patient_id     = '17' ;
        $args = array(
            'pcr_id' => $pcr_id,
            'base_month' => $this->post['base_month'],
            'asst_min' => 'handover'
        );

        $data['hospital'] = $this->pcr_model->get_trans_hosp($args);
        $data['asst'] = $this->pet_model->get_patient_asst($args);

        $add_args = array(
            'pcr_id' => $pcr_id,
            'base_month' => $this->post['base_month'],
            'asst_type' => 'handover'
        );
        $data['add_asst'] = $this->pet_model->get_patient_addasst($add_args);


        $this->output->add_to_position($this->load->view('frontend/pcr/hospital_transfer_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "pcr";
    }

    /* MI13
     * Save Patient hosptal Transfer tab */

    function save_transfer_hospital() {

        $transfer_hospital = $this->input->post();

        $pcr_data = $this->session->userdata('pcr_details');


        $inc_id = key($pcr_data);
        $pcr_id = $pcr_data[$inc_id]['pcr_id'];
        $patient_id = $pcr_data[$inc_id]['patient_id'];
        //  
//        $pcr_id = '11';
//        $patient_id = '17';

        $hp_tr_args = array(
            'pcr_id' => $pcr_id,
            'date' => $this->today,
            'base_month' => $this->post['base_month'],
            'patient_id' => $patient_id
        );

        $hp_tr_data = array_merge($this->post['hosp'], $hp_tr_args);

        $hos = $this->pcr_model->save_trasfer_hospital($hp_tr_data);

        $args = array(
            'pcr_id' => $pcr_id,
            'asst_date' => $this->today,
            'asst_base_month' => $this->post['base_month'],
            'asst_min' => 'handover'
        );

        $ptn_asst = array_merge($this->post['asst'], $args);


        $ptn_addasst = array_merge($this->post['add_asst'], $args);

        $res = $this->pcr_model->save_patient_asst_hos($ptn_asst);

        $ptn_addasst['asst_type'] = 'handover';

        $res = $this->pcr_model->save_patient_addasst_hos($ptn_addasst);

        /////////////////////////////////////////////////////////////

        pcr_steps($pcr_id, "HPT");

        /////////////////////////////////////////////////////////////

        $this->output->message = "<div class='success'> Hospital Transfer saved successfully <script>$('#PCR_STEPS a[data-pcr_step=10]').click();</script></div>";

        /////////////////////// Update progressbar /////////////////////

        $this->increase_step($pcr_id);

        ///////////////////////////////////////////////////////////////
    }

    function ptn_inv() {

        $this->session->unset_userdata('consumables_selected_inv_list');
        $this->session->unset_userdata('na_consumables_selected_inv_list');
        $this->session->unset_userdata('med_item_selected_inv_list');
        $this->session->unset_userdata('na_consumables_selected_qty_inv_list');
        $this->session->unset_userdata('med_selected_qty_inv_list');
        $this->session->unset_userdata('consumables_selected_qty_inv_list');

        $pcr_data = $this->session->userdata('pcr_details');


        //   if($pcr_data){
        $inc_id = key($pcr_data);
//        $inc_id = 'INC-13';
//        $pcr_id = '11';
//        $patient_id = '17';

        $pcr_id = $pcr_data[$inc_id]['pcr_id'];
        $patient_id = $pcr_data[$inc_id]['patient_id'];

        $get_amb_stock = array('pcr_id' => $pcr_id,
            'sub_type' => 'pcr',
            'as_item_type' => 'CA');

        $consumable_data = $this->ind_model->get_amb_stock($get_amb_stock);

        $get_amb_stock = array('pcr_id' => $pcr_id,
            'sub_type' => 'pcr',
            'as_item_type' => 'NCA');

        $nonconsumable_data = $this->ind_model->get_amb_stock($get_amb_stock);

        $get_amb_stock = array('pcr_id' => $pcr_id,
            'sub_type' => 'pcr',
            'as_item_type' => 'MED');

        $medication_data = $this->ind_model->get_amb_stock($get_amb_stock);



        $script = '';
        $qty_script = '';
        if (!empty($consumable_data)) {

            foreach ($consumable_data as $consumable) {

                $args = array(
                    'inv_id' => $consumable->as_item_id,
                    'inv_type' => $consumable->as_item_type,
                );

                $res = $this->inv_model->get_inv($args);

                $max = $res[0]->stk_in - $res[0]->stk_out;
                $min = $res[0]->inv_base_quantity;

                $str = '\"';


                $res_tpl = "<tr><td> " . $res[0]->inv_title . " </td><td><input type='text' name='item_qty' value='$consumable->as_item_qty' class='filter_required'  placeholder='Qty' value='' data-base='select_" . $consumable->as_item_type . $res[0]->inv_id . "' data-errors='{filter_required:$str Item quanity should not be blank$str}'></td><td> " . $res[0]->inv_base_quantity . "</td><td> " . $max . " </td><td> " . $res[0]->unt_title . " </td><td><input name='select_" . $consumable->as_item_type . $res[0]->inv_id . "' class='base-xhttp-request style6' data-href='" . base_url() . "/inv_stock/release_stock' data-qr='inv_id=" . $res[0]->inv_id . "&inv_type=" . $consumable->as_item_type . "&item_name=" . $res[0]->inv_title . "' value='SELECT' type='button'></td></tr>";


                $consumables_selected_inv_list[$consumable->as_item_id] = array('inv_id' => $consumable->as_item_id, 'inv_name' => $res[0]->inv_title);

                $consumables_selected_qty_inv_list[$consumable->as_item_id] = array('inv_id' => $consumable->as_item_id, 'inv_qty' => $consumable->as_item_qty, 'item_name' => $res[0]->inv_title, 'item_type' => $consumable->as_item_type);

                $inp_tpl = "<input type='hidden' name='' data-auto='CA' value='" . $consumable->inv_id . "'>";
                $script .= "<script>$( document ).ready(function() { $('.CA_items').show().append(\"" . $inp_tpl . "\");$('.CA_items table tbody').append(\"" . $res_tpl . "\") });</script>";


                $rel_item_tpl = "<tr id=" . $consumable->as_item_type . '_' . $consumable->as_item_id . "><td>" . $res[0]->inv_title . "</td><td>" . $consumable->as_item_qty . "</td><td><input name='remove_$consumable->as_item_type" . $consumable->as_item_id . "' class='base-xhttp-request style6' data-href='" . base_url() . "/inv_stock/remove_stock' data-qr='id=" . $consumable->as_item_type . '_' . $consumable->as_item_id . "' value='REMOVE' type='button'></td></tr>";

                $qty_script .= "<script>$( document ).ready(function() { $('.CA_rel_items').show();$('.CA_rel_items table tbody').append(\"" . $rel_item_tpl . "\") });</script>";
            }

            $this->session->set_userdata('consumables_selected_inv_list', $consumables_selected_inv_list);
            $this->session->set_userdata('consumables_selected_qty_inv_list', $consumables_selected_qty_inv_list);
        }

        $na_script = '';
        $na_qty_script = '';
        if (!empty($nonconsumable_data)) {

            foreach ($nonconsumable_data as $nonconsumable) {
                $args = array(
                    'inv_id' => $nonconsumable->as_item_id,
                    'inv_type' => $nonconsumable->as_item_type,
                );

                $res = $this->inv_model->get_inv($args);

                $max = $res[0]->stk_in - $res[0]->stk_out;
                $min = $res[0]->inv_base_quantity;

                $str = '\"';

                $res_tpl = "<tr><td> " . $res[0]->inv_title . " </td><td><input type='text' value='$nonconsumable->as_item_qty' name='item_qty'  class='filter_required'  placeholder='Qty' value='' data-base='select_" . $nonconsumable->as_item_type . $res[0]->inv_id . "' data-errors='{filter_required:$str Item quanity should not be blank$str}'></td><td> " . $res[0]->inv_base_quantity . "</td><td> " . $max . " </td><td> " . $res[0]->unt_title . " </td><td><input name='select_" . $nonconsumable->as_item_type . $res[0]->inv_id . "' class='base-xhttp-request style6' data-href='" . base_url() . "/inv_stock/release_stock' data-qr='inv_id=" . $res[0]->inv_id . "&inv_type=" . $nonconsumable->as_item_type . "&item_name=" . $res[0]->inv_title . "' value='SELECT' type='button'></td></tr>";


                $na_consumables_selected_inv_list[$nonconsumable->as_item_id] = array('inv_id' => $res[0]->inv_id, 'inv_name' => $res[0]->inv_title);
                $na_consumables_selected_qty_inv_list[$nonconsumable->as_item_id] = array('inv_id' => $res[0]->inv_id, 'inv_qty' => $nonconsumable->as_item_qty, 'item_name' => $res[0]->inv_title, 'item_type' => $nonconsumable->as_item_type);

                $inp_tpl = "<input type='hidden' name='' data-auto='NCA' value='" . $nonconsumable->as_item_id . "'>";
                $na_script .= "<script>$( document ).ready(function() { $('.NCA_items').show().append(\"" . $inp_tpl . "\");$('.NCA_items table tbody').append(\"" . $res_tpl . "\") });</script>";


                $rel_item_tpl = "<tr id=" . $nonconsumable->as_item_type . '_' . $nonconsumable->as_item_id . "><td>" . $res[0]->inv_title . "</td><td>" . $nonconsumable->as_item_qty . "</td><td><input name='$nonconsumable->as_item_type" . $nonconsumable->as_item_id . "' class='base-xhttp-request style6' data-href='" . base_url() . "/inv_stock/remove_stock' data-qr='id=" . $nonconsumable->as_item_type . '_' . $nonconsumable->as_item_id . "' value='REMOVE' type='button'></td></tr>";
                // echo $rel_item_tpl;

                $na_qty_script = "<script>$( document ).ready(function() { $('.NCA_rel_items').show();$('.NCA_rel_items table tbody').append(\"" . $rel_item_tpl . "\") });</script>";
            }

            $this->session->set_userdata('na_consumables_selected_inv_list', $na_consumables_selected_inv_list);
            $this->session->set_userdata('na_consumables_selected_qty_inv_list', $na_consumables_selected_qty_inv_list);
        }


        $med_script = '';
        $med_qty_script = '';
        if (!empty($medication_data)) {

            foreach ($medication_data as $medication) {


                $args = array(
                    'inv_id' => $medication->as_item_id,
                    'inv_type' => $medication->as_item_type,
                );
                $res = $this->med_model->get_med($args);




                $max = $res[0]->stk_in - $res[0]->stk_out;
                $min = $res[0]->med_base_quantity;

                $str = '\"';

                $res_tpl = "<tr><td> " . $res[0]->med_title . " </td><td><input type='text' value='$medication->as_item_qty' name='item_qty'  class='filter_required '  placeholder='Qty' value='' data-base='select_" . $medication->as_item_type . $res[0]->inv_id . "' data-errors='{filter_required:$str Item quanity should not be blank$str}'></td><td> " . $res[0]->med_base_quantity . "</td><td> " . $max . " </td><td> " . $res[0]->unt_title . " </td><td><input name='select_" . $medication->as_item_type . $res[0]->inv_id . "' class='base-xhttp-request style6' data-href='" . base_url() . "/inv_stock/release_stock' data-qr='inv_id=" . $res[0]->inv_id . "&inv_type=" . $medication->as_item_type . "&item_name=" . $res[0]->inv_title . "' value='SELECT' type='button'></td></tr>";



                $med_item_selected_inv_list[$medication->as_item_id] = array('med_id' => $res[0]->med_id, 'med_title' => $res[0]->med_title);
                $med_selected_qty_inv_list[$medication->as_item_id] = array('inv_id' => $res[0]->med_id, 'inv_qty' => $medication->as_item_qty, 'item_name' => $res[0]->med_title, 'item_type' => $medication->as_item_type);



                $inp_tpl = "<input type='hidden' name='' data-auto='MED' value='" . $res[0]->med_id . "'>";
                $med_script = "<script>$( document ).ready(function() {  $('.MED_items').show().append(\"" . $inp_tpl . "\");$('.MED_items table tbody').append(\"" . $res_tpl . "\") });</script>";


                $rel_item_tpl = "<tr id=" . $medication->as_item_type . '_' . $res[0]->med_id . "><td>" . $res[0]->med_title . "</td><td>" . $medication->as_item_qty . "</td><td><input name='$medication->as_item_type" . $medication->inv_id . "' class='base-xhttp-request style6' data-href='" . base_url() . "/inv_stock/remove_stock' data-qr='id=" . $medication->as_item_type . '_' . $res[0]->med_id . "' value='REMOVE' type='button'></td></tr>";

                $med_qty_script = "<script>$( document ).ready(function() { $('.MED_rel_items').show();$('.MED_rel_items table tbody').append(\"" . $rel_item_tpl . "\") });</script>";
            }

            $this->session->set_userdata('med_item_selected_inv_list', $med_item_selected_inv_list);
            $this->session->set_userdata('med_selected_qty_inv_list', $med_selected_qty_inv_list);
        }

        $data['script'] = $script;
        $data['qty_script'] = $qty_script;

        $data['na_script'] = $na_script;
        $data['na_qty_script'] = $na_qty_script;

        $data['med_script'] = $med_script;
        $data['med_qty_script'] = $med_qty_script;

        $this->output->add_to_position($this->load->view('frontend/pcr/ptn_inv_view', $data, TRUE), "content", TRUE);

        // }
    }

    function save_ptn_inv() {

        $ptn_inv = $this->input->post();

        $consumables_selected_inv_list = $this->session->userdata('consumables_selected_inv_list');
        $na_consumables_selected_inv_list = $this->session->userdata('na_consumables_selected_inv_list');
        $med_item_selected_inv_list = $this->session->userdata('med_item_selected_inv_list');
        $na_consumables_selected_qty_inv_list = $this->session->userdata('na_consumables_selected_qty_inv_list');
        $med_selected_qty_inv_list = $this->session->userdata('med_selected_qty_inv_list');
        $consumables_selected_qty_inv_list = $this->session->userdata('consumables_selected_qty_inv_list');

        $pcr_data = $this->session->userdata('pcr_details');
        $inc_id = key($pcr_data);
        $pcr_id = $pcr_data[$inc_id]['pcr_id'];
        $patient_id = $pcr_data[$inc_id]['patient_id'];

        $deletet_amb_stock = array('pcr_id' => $pcr_id,
            'sub_type' => 'pcr');
        $this->ind_model->deletet_amb_stock($deletet_amb_stock);

        if (isset($na_consumables_selected_qty_inv_list)) {
            foreach ($na_consumables_selected_qty_inv_list as $na_consumable) {

                $unit_args = array(
                    'as_item_id' => $na_consumable['inv_id'],
                    'as_item_type' => $na_consumable['item_type'],
                    'as_stk_in_out' => 'in',
                    'as_item_qty' => $na_consumable['inv_qty'],
                    'as_sub_id' => $pcr_id,
                    'as_sub_type' => 'pcr',
                    'as_date' => $this->today,
                    'as_base_month' => $this->post['base_month'],
                );

                $this->ind_model->insert_amb_stock($unit_args);
            }
        }

        if (isset($consumables_selected_qty_inv_list)) {
            foreach ($consumables_selected_qty_inv_list as $consumable) {
                $unit_args = array(
                    'as_item_id' => $consumable['inv_id'],
                    'as_item_type' => $consumable['item_type'],
                    'as_stk_in_out' => 'in',
                    'as_item_qty' => $consumable['inv_qty'],
                    'as_sub_id' => $pcr_id,
                    'as_sub_type' => 'pcr',
                    'as_date' => $this->today,
                    'as_base_month' => $this->post['base_month'],
                );

                $this->ind_model->insert_amb_stock($unit_args);
            }
        }

        if (isset($med_selected_qty_inv_list)) {
            foreach ($med_selected_qty_inv_list as $med) {
                $unit_args = array(
                    'as_item_id' => $med['inv_id'],
                    'as_item_type' => $med['item_type'],
                    'as_stk_in_out' => 'in',
                    'as_item_qty' => $med['inv_qty'],
                    'as_sub_id' => $pcr_id,
                    'as_sub_type' => 'pcr',
                    'as_date' => $this->today,
                    'as_base_month' => $this->post['base_month'],
                );

                $this->ind_model->insert_amb_stock($unit_args);
            }
        }

        /////////////////////////////////////////////////////////////

        pcr_steps($pcr_id, "MG2");

        /////////////////////////////////////////////////////////////

        $this->output->message = "PATIENT MANAGEMENT 2 saved successfully <script>$('#PCR_STEPS a[data-pcr_step=9]').click();</script>";


        /////////////////////// Update progressbar /////////////////////

        $this->increase_step($pcr_id);

        ///////////////////////////////////////////////////////////////
    }

    /** MI13
     *  Trauma Assessment tab
      /
     *  
     */
    function trauma_assessment() {


        $pcr_data = $this->session->userdata('pcr_details');

        if ($pcr_data) {

            $inc_id = key($pcr_data);

            $pcr_id = $pcr_data[$inc_id]['pcr_id'];
            $patient_id = $pcr_data[$inc_id]['patient_id'];
            $args = array(
                'pcr_id' => $pcr_id,
                'patient_id' => $patient_id,
                'base_month' => $this->post['base_month']
            );


            $truama_data = $this->pcr_model->get_trauma($args);

            $front_injury_data = json_decode($truama_data[0]->truama_front);
            $side_injury_data = json_decode($truama_data[0]->truama_side);
            $back_injury_data = json_decode($truama_data[0]->truama_back);

            if (!empty($front_injury_data)) {
                $front_injury = array();
                foreach ($front_injury_data as $front) {

                    $inj_args = array('inj_id' => $front->injury_id);
                    $inj_name = $this->pcr_model->get_injury($inj_args);

                    $front_args = array('id' => $front->front_id);
                    $front_name = $this->pcr_model->get_front($front_args);
                    $rand_id = $front->front_id . '_' . $front->injury_id;


                    $front_injury[$rand_id] = array('rand_id' => $rand_id,
                        'inj_name' => $inj_name[0]->inj_name,
                        'inj_id' => $front->injury_id,
                        'front_name' => $front_name[0]->front_name,
                        'front_id' => $front->back_id
                    );
                    $this->session->set_userdata('front_injury_data', $front_injury);
                }

                $data['front_injury_info'] = $front_injury;
            }

            if (!empty($back_injury_data)) {
                $back_injury = array();
                foreach ($back_injury_data as $back) {

                    $inj_args = array('inj_id' => $back->injury_id);
                    $inj_name = $this->pcr_model->get_injury($inj_args);

                    $back_args = array('id' => $back->back_id);
                    $back_name = $this->pcr_model->get_back($back_args);
                    $rand_id = $back->back_id . '_' . $back->injury_id;


                    $back_injury[$rand_id] = array('rand_id' => $rand_id,
                        'inj_name' => $inj_name[0]->inj_name,
                        'inj_id' => $back->injury_id,
                        'back_name' => $back_name[0]->back_name,
                        'back_id' => $back->back_id
                    );
                    $this->session->set_userdata('back_injury_data', $back_injury);
                }

                $data['back_injury_info'] = $back_injury;
            }

            if (!empty($side_injury_data)) {
                $side_injury = array();
                foreach ($side_injury_data as $side) {

                    $inj_args = array('inj_id' => $side->injury_id);
                    $inj_name = $this->pcr_model->get_injury($inj_args);

                    $side_args = array('id' => $side->side_id);
                    $side_name = $this->pcr_model->get_side($side_args);
                    $rand_id = $side->side_id . '_' . $side->injury_id;

                    $side_injury[$rand_id] = array('rand_id' => $rand_id,
                        'inj_name' => $inj_name[0]->inj_name,
                        'inj_id' => $side->injury_id,
                        'side_name' => $side_name[0]->side_name,
                        'side_id' => $side->side_id
                    );
                    $this->session->set_userdata('side_injury_data', $side_injury);
                }

                $data['side_injury_info'] = $side_injury;
            }


            $this->output->add_to_position($this->load->view('frontend/pcr/truma_ass_view', $data, TRUE), $this->post['output_position'], TRUE);
            $this->output->template = "pcr";
        } else {
            $this->output->message = "<div class='error'>Please fill trip closer form first</div>";
        }
    }

    function selecte_front_injury() {


        $truama_inj = $this->input->post();

        $front_injury_data = $this->session->userdata('front_injury_data');

        $rand_id = $truama_inj['front'] . '_' . $truama_inj['injury'];

        if (!isset($front_injury_data[$rand_id])) {

            $inj_args = array('inj_id' => $truama_inj['injury']);
            $inj_name = $this->pcr_model->get_injury($inj_args);

            $front_args = array('id' => $truama_inj['front']);
            $front_name = $this->pcr_model->get_front($front_args);

            $front_injury_data[$rand_id] = array('rand_id' => $rand_id,
                'inj_name' => $inj_name[0]->inj_name,
                'inj_id' => $truama_inj['injury'],
                'front_name' => $front_name[0]->front_name,
                'front_id' => $truama_inj['front']
            );

            $this->session->set_userdata('front_injury_data', $front_injury_data);
        }
        $data['injury_info'] = $front_injury_data;
        $this->output->add_to_position($this->load->view('frontend/pcr/truma_ass_front_view', $data, TRUE), $this->input->get_post('output_position', true), FALSE);
    }

    function remove_front_injury() {

        $remove_inj = $this->input->post();

        $front_injury_data = $this->session->userdata('front_injury_data');
        unset($front_injury_data[$remove_inj['injury_row_id']]);

        $this->session->set_userdata('front_injury_data', $front_injury_data);
        $data['injury_info'] = $front_injury_data;
        $this->output->add_to_position($this->load->view('frontend/pcr/truma_ass_front_view', $data, TRUE), $this->input->get_post('output_position', true), FALSE);
    }

    function selecte_back_injury() {


        $truama_inj = $this->input->post();

        $back_injury_data = $this->session->userdata('back_injury_data');

        $rand_id = $truama_inj['back'] . '_' . $truama_inj['back_injury'];

        if (!isset($back_injury_data[$rand_id])) {

            $inj_args = array('inj_id' => $truama_inj['back_injury']);
            $inj_name = $this->pcr_model->get_injury($inj_args);

            $back_args = array('id' => $truama_inj['back']);
            $back_name = $this->pcr_model->get_back($back_args);

            $back_injury_data[$rand_id] = array('rand_id' => $rand_id,
                'inj_name' => $inj_name[0]->inj_name,
                'inj_id' => $truama_inj['back_injury'],
                'back_name' => $back_name[0]->back_name,
                'back_id' => $truama_inj['back']
            );
            $this->session->set_userdata('back_injury_data', $back_injury_data);
        }

        $data['injury_info'] = $back_injury_data;
        $this->output->add_to_position($this->load->view('frontend/pcr/truma_ass_back_view', $data, TRUE), $this->input->get_post('output_position', true), FALSE);
    }

    function remove_back_injury() {

        $remove_inj = $this->input->post();

        $back_injury_data = $this->session->userdata('back_injury_data');
        unset($back_injury_data[$remove_inj['back_injury_row_id']]);

        $this->session->set_userdata('back_injury_data', $back_injury_data);
        $data['injury_info'] = $back_injury_data;
        $this->output->add_to_position($this->load->view('frontend/pcr/truma_ass_back_view', $data, TRUE), $this->input->get_post('output_position', true), FALSE);
    }

    function selecte_side_injury() {


        $truama_inj = $this->input->post();

        $side_injury_data = $this->session->userdata('side_injury_data');

        $rand_id = $truama_inj['side'] . '_' . $truama_inj['side_injury'];

        if (!isset($side_injury_data[$rand_id])) {

            $inj_args = array('inj_id' => $truama_inj['side_injury']);
            $inj_name = $this->pcr_model->get_injury($inj_args);

            $side_args = array('id' => $truama_inj['side']);
            $side_name = $this->pcr_model->get_side($side_args);

            $side_injury_data[$rand_id] = array('rand_id' => $rand_id,
                'inj_name' => $inj_name[0]->inj_name,
                'inj_id' => $truama_inj['side_injury'],
                'side_name' => $side_name[0]->side_name,
                'side_id' => $truama_inj['side']
            );
            $this->session->set_userdata('side_injury_data', $side_injury_data);
        }

        $data['injury_info'] = $side_injury_data;
        $this->output->add_to_position($this->load->view('frontend/pcr/truma_ass_side_view', $data, TRUE), $this->input->get_post('output_position', true), FALSE);
    }

    function remove_side_injury() {

        $remove_inj = $this->input->post();

        $side_injury_data = $this->session->userdata('side_injury_data');
        unset($side_injury_data[$remove_inj['side_injury_row_id']]);

        $this->session->set_userdata('side_injury_data', $side_injury_data);
        $data['injury_info'] = $side_injury_data;
        $this->output->add_to_position($this->load->view('frontend/pcr/truma_ass_side_view', $data, TRUE), $this->input->get_post('output_position', true), FALSE);
    }

    function save_trauma_assessment() {

        $front_injury_data = $this->session->userdata('front_injury_data');

        $front_data = array();
        if ($front_injury_data) {
            foreach ($front_injury_data as $front) {
                $front_data[] = array('front_id' => $front['front_id'],
                    'injury_id' => $front['inj_id']);
            }
        }

        $back_injury_data = $this->session->userdata('back_injury_data');
        $back_data = array();
        if ($back_injury_data) {
            foreach ($back_injury_data as $back) {
                $back_data[] = array('back_id' => $back['back_id'],
                    'injury_id' => $back['inj_id']);
            }
        }

        $side_injury_data = $this->session->userdata('side_injury_data');
        $side_data = array();
        if ($side_injury_data) {
            foreach ($side_injury_data as $side) {
                $side_data[] = array('side_id' => $side['side_id'],
                    'injury_id' => $side['inj_id']);
            }
        }

        $side_data = json_encode($side_data);
        $back_data = json_encode($back_data);
        $front_data = json_encode($front_data);

        $pcr_data = $this->session->userdata('pcr_details');
        $inc_id = key($pcr_data);
        $pcr_id = $pcr_data[$inc_id]['pcr_id'];
        $patient_id = $pcr_data[$inc_id]['patient_id'];

        $truama_data = array('truama_front' => $front_data,
            'truama_back' => $back_data,
            'truama_side' => $side_data,
            'pcr_id' => $pcr_id,
            'patient_id' => $patient_id);

        $truama = $this->pcr_model->insert_trauma($truama_data);

        /////////////////////////////////////////////////////////////

        pcr_steps($pcr_data[$inc_id]['pcr_id'], "TRA");

        /////////////////////////////////////////////////////////////

        $this->output->message = "<div class='success'> Truama Added successfully <script>$('#PCR_STEPS a[data-pcr_step=6]').click();</script></div>";

        /////////////////////// Update progressbar /////////////////////

        $this->increase_step($pcr_id);

        ///////////////////////////////////////////////////////////////
    }

    ////////////MI44//////////////////////
    //
    // Purpose : Update steps progressbar. 
    //
    //////////////////////////////////////

    function increase_step($pcr_id = '') {

        if ($pcr_id) {

            $epcr_steps = $this->pcr_model->get_pcr_details(array('pcr_id' => $pcr_id));

            $data['steps_cnt'] = $this->steps_cnt;

            if ($epcr_steps[0]->pcr_steps != '') {

                $data['step_com'] = explode(",", $epcr_steps[0]->pcr_steps);

                $data['step_com_cnt'] = count($data['step_com']);
            }


            $this->output->add_to_position($this->load->view('frontend/pcr/progressbar_view', $data, TRUE), "pcr_progressbar", TRUE);
        }



        $this->output->add_to_position($this->load->view('frontend/pcr/pcr_top_steps_view', $data, TRUE), "pcr_top_steps", TRUE);
    }

    function send_hospital_sms() {
        $details = $this->input->post();
        $per_args = array('ptn_id' => $details["pat_id"]);
        $pet_info = $this->pet_model->get_petinfo($per_args);

        $hos_args = array('hp_id' => $details["receiving_host"]);
        $host_info = $this->hp_model->get_hp_data($hos_args);

        $inc_args = array('inc_ref_id' => $details["inc_ref_id"]);
        $inc_info = $this->inc_model->get_inc_details($inc_args);

        $origins = array();

        $destination = $host_info[0]->hp_lat . ',' . $host_info[0]->hp_long;
        if ($inc_info) {

            foreach ($inc_info as $search_amb) {

                $origins[] = trim($search_amb->inc_lat) . ',' . trim($search_amb->inc_long);
            }


            $origins = trim(implode('|', $origins));


            // $google_api_key = 'AIzaSyCcSwiJ9TapOs5uuGC5Hf_dqaGik-qFA5c';
            $google_api_key = $this->config->item('google_api_key');

            $google_map_url = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $origins . '&destinations=' . $destination . '&region=in&key=' . $google_api_key;



            $location_data = file_get_contents($google_map_url);

            //$location_data =  $this->_send_curl_request($google_map_url,'','get');

            $location_data = json_decode($location_data);

            $ambu_data = array();

            foreach ($location_data->origin_addresses as $key => $amb_row) {

                //$duration_value = $location_data->rows[0]->elements[0]->duration->value;

                $duration_value = $location_data->rows[0]->elements[0]->duration->text;
            }

            $chief_comp = $this->inc_model->get_chief_comp_service($inc_info[0]->inc_complaint);

            $hp_name = $host_info[0]->hp_name;
            $patient_name = $pet_info[0]->ptn_fname . ' ' . $pet_info[0]->ptn_mname . ' ' . $pet_info[0]->ptn_lname;
            $patient_age = $pet_info[0]->ptn_age;
            $patient_gener = $pet_info[0]->ptn_gender;
            $inc_compte = $chief_comp[0]->ct_type;
            $hp_mobile = $host_info[0]->hp_mobile;
           // $hp_mobile = '8698989880';
            // $hp_mobile ='8551905260';
            //$hp_mobile ='9730015484';
            $inc_id = $details["inc_ref_id"];
            $amb_url = base_url() . "amb/loc/" . $inc_id;

            //$sms_text = "Attention: $hp_name, Patient:$patient_name Age:$patient_age Sex:$patient_gener Chief Complaint:$inc_compte is arriving at $duration_value";
            $sms_text = "BVG,\nIncident ID: $inc_id \nPatient:$patient_name \nChief Complaint:$inc_compte \nBase Lacation Name :$hp_name \nMobile no : $hp_mobile,\ncurrent location link : $amb_url, \nETA: $duration_value \nMEMS, TDD";

            $patient_sms_to = $caller_details['clr_mobile'];
            $send_ptn_sms = $this->_send_sms($hp_mobile, $sms_text, $lang = "english");
            if ($send_ptn_sms) {
                $this->output->message = "<h3>Send Sms to Hospital</h3><br><p>SMS send successfull.</p>";
                $this->output->moveto = 'top';

                $this->output->add_to_position('', 'content', TRUE);
            }
        }
    }
    
    function last_ten_odometer(){
        $form_call_data = $this->input->post('amb_no');
            
        $odo_args = array('rto_no' => $form_call_data);
        $data['get_odometer'] = $this->amb_model->get_last_ten_odometer($odo_args);
        
        
        $this->output->add_to_popup($this->load->view('frontend/pcr/last_ten_odometer_view', $data, TRUE), '800', '500');
    }

    function last_ten_odometer_ff(){
        $form_call_data = $this->input->post('amb_no');
            
        $odo_args = array('rto_no' => $form_call_data);
        $data['get_odometer'] = $this->amb_model->get_last_ten_odometer($odo_args);
         
        $str='<div class="width100">
        <div class="head_outer">
            <h3 class="txt_clr2 width1">Previous Odometer List</h3> 
        </div>
                                <div id="list_table" style="overflow: auto; max-height: 370px;" >
    
                            <table class="table report_table table-bordered table-responsive tblclr">
                                <tr>
    
                                    <th>Date & Time</th>
                                    <th>Incident ID</th>
                                    <th>Odometer Type</th>
                                    <th>Ambulance No</th>
                                    <th>Start Odometer</th>
                                    <th>End Odometer</th>
                                </tr>';


                                if($data['get_odometer']){
                                    foreach($data['get_odometer'] as $odometer){ 
                                        $str .='<tr><td>'.$odometer->timestamp.'</td><td>';
                                    if($odometer->odometer_type != ''){
                                        if(strpos('closure', $odometer->odometer_type) !== false){
                                                                $str .= $odometer->inc_ref_id; 
                                                            } 
                                                        }
                                    $str .='</td><td>'. ucfirst(str_replace('_',' ',$odometer->odometer_type)).'</td><td>'. $odometer->amb_rto_register_no .'</td><td>'. $odometer->start_odmeter.'</td><td>'. $odometer->end_odmeter.'</td></tr>';
                                    }
                                }

                                echo ($str);die();
        // $this->output->add_to_position($this->load->view('frontend/pcr/last_ten_odometer_view', $data, TRUE), 'content', TRUE);
        // $this->output->add_to_popup($this->load->view('frontend/pcr/last_ten_odometer_view', $data, TRUE), '800', '500');
    }
}