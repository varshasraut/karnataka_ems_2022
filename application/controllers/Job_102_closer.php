<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Job_102_Closer extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->steps_cnt = $this->config->item('pcr_steps');

        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));
        $this->load->model(array('pet_model', 'add_res_model', 'colleagues_model', 'inc_model', 'amb_model', 'pcr_model', 'call_model', 'medadv_model', 'inv_stock_model', 'ind_model', 'hp_model', 'med_model', 'hp_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper', 'language_helper'));


        $this->post = $this->input->get_post(NULL);
        $this->post['base_month'] = get_base_month();
        $this->clg = $this->session->userdata('current_user');

        $this->pg_limit = $this->config->item('pagination_limit_clg');
        $this->pg_limits = $this->config->item('report_clg');
        $this->default_state = $this->config->item('default_state');

        if ($this->post['filters'] == 'reset') {
            $this->session->unset_userdata('epcr_filter');
         
        }

        if ($this->session->userdata('epcr_filter')) {
            $this->fdata = $this->session->userdata('epcr_filter');
        }

        $this->today = date('Y-m-d H:i:s');
    }

    public function index($generated = false) {

        $this->pg_limit = 50;

        $data['page_no'] = ($this->post['page_no'] || $this->post['pglnk']) ? $this->post['page_no'] : $this->fdata['page_no'];
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        $page_no = 1;
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        if ($this->post['filters'] == 'reset') {
            $this->session->unset_userdata('epcr_filter');
   
        }
//        var_dump($this->fdata);
//        die();
//        
        
       
        $data['amb_reg_id'] = "";
        $data['filter'] = $filter = "";
        $data['filter'] = $_POST['filter'] ? $this->post['filter'] : $this->fdata['filter'];

        $data['amb_reg_id'] = $_POST['amb_reg_id'] ? $this->post['amb_reg_id'] : $this->fdata['amb_reg_id'];
        $data['district_id'] = $_POST['district_id'] ? $this->post['district_id'] : $this->fdata['district_id'];
        $data['inc_date'] = $_POST['inc_date'] ? $this->post['inc_date'] : $this->fdata['inc_date'];
        $data['hp_id'] = $_POST['hp_id'] ? $this->post['hp_id'] : $this->fdata['hp_id'];
        $data['inc_id'] = $_POST['inc_id'] ? $this->post['inc_id'] : $this->fdata['inc_id'];
        $data['dco_id'] = $_POST['dco_id'] ? $this->post['dco_id'] : $this->fdata['dco_id'];
        
        
        

        if (isset($data['filter'])) {


            if ($data['filter'] == 'amb_reg_no') {
                $filter = '';
                $sortby['amb_reg_id'] = $data['amb_reg_id'];
                $data['amb_reg_id'] = $sortby['amb_reg_id'];
            } else if ($data['filter'] == 'dst_name') {
                $filter = '';
                $sortby['district_id'] = $data['district_id'];
                $data['district_id'] = $sortby['district_id'];
            } else if ($data['filter'] == 'hp_name') {
                $filter = '';
                $sortby['hp_id'] = $data['hp_id'];
                $data['hp_id'] = $data['hp_id'];
                $hp_args = array('hp_id' => $data['hp_id']);
                $hp_data = $this->hp_model->get_hp_data($hp_args);
                $data['hp_name'] = $hp_data[0]->hp_name;
            } else if ($data['filter'] == 'inc_datetime') {
                $filter = '';
                $sortby['inc_date'] = date('Y-m-d', strtotime($_POST['inc_date']));
                $data['inc_date'] = $data['inc_date'];
            } else if ($data['filter'] == 'inc_ref_id') {
                $filter = '';
                $sortby['inc_id'] = $data['inc_id'];
                $data['inc_id'] = $data['inc_id'];
            }
        }

        $this->session->set_userdata('epcr_filter', $data);

        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        if ($this->clg->clg_group == 'UG-DCO' || $this->clg->clg_group == 'UG-ADMIN') {
            $args_dash = array(
                'base_month' => $this->post['base_month']
                
            );
        }else if($this->clg->clg_group == 'UG-DCOSupervisor'){           
            
            $args['clg_senior'] = $this->clg->clg_ref_id;
            $data['clg_senior'] = $this->clg->clg_ref_id;
            
            
            $clg_args = array('clg_senior'=>$this->clg->clg_ref_id,'clg_group'=>'UG-DCO');
           
            $data['dco_clg'] = $this->colleagues_model->get_clg_data($clg_args);
            
            foreach($data['dco_clg'] as $dco){
                $child_dco[] = $dco->clg_ref_id;
            }

            if(is_array($child_dco)){
                $child_dco = implode("','", $child_dco);
            }
            
            
            if ( $data['dco_id']  != '') {
                $args_dash['operator_id'] = $this->post['dco_id'];
            }else{
               // $args_dash['child_dco'] = $this->fdata['dco_id'];
            }
            
        } else {
            $args_dash = array(
                'operator_id' => $this->clg->clg_ref_id,
                'base_month' => $this->post['base_month']
            );
        }
        
        if ($this->clg->clg_group == 'UG-DCO'){
              $args_dash['system_type'] = '108';
        }else if ($this->clg->clg_group == 'UG-DCO-102'){
            $args_dash['system_type'] = '102';
        }

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        $data['get_count'] = TRUE;

        $inc_amb_details = $this->pcr_model->get_first_inc_by_amb();

        $data['closer_data'] = $inc_amb_details;


        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->pcr_model->get_inc_by_emt($args_dash, '', '', $filter, $sortby, $incomplete_inc_amb);

        unset($args_dash['get_count']);
        $inc_info = $this->pcr_model->get_inc_by_emt($args_dash, $offset, $limit, $filter, $sortby, $incomplete_inc_amb);
        
//        var_dump($inc_info);
//        die();

        $arg_amb = array('amb_user_type' => 'tdd');
        $data['amb_list'] = $this->amb_model->get_amb_data($arg_amb);
        // $data['amb_list'] = $this->amb_model->get_amb_data();

        $data['per_page'] = $limit;
        $data['inc_offset'] = $offset;

        $data['inc_info'] = $inc_info;

        $data['total_count'] = $total_cnt;

        $data['per_page'] = $limit;

        $pgconf = array(
            'url' => base_url("job_closer/index"),
            'total_rows' => $total_cnt,
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
        $data['default_state'] = $this->default_state;

        $this->output->add_to_position($this->load->view('frontend/pcr/dashboard_view', $data, TRUE), 'content', TRUE);
        
        if ($this->clg->clg_group == 'UG-DCO'){
            $this->output->template = "pcr";
        }
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
        $args_dash = array();


        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        $data['get_count'] = TRUE;

        $data['amb_reg_id'] = "";
        $data['filter'] = $filter = "";

        $data['amb_reg_id'] = $_POST['amb_reg_id'] ? $this->post['amb_reg_id'] : $this->fdata['amb_reg_id'];
        $data['district_id'] = $_POST['district_id'] ? $this->post['district_id'] : $this->fdata['district_id'];
        $data['inc_date'] = $_POST['inc_date'] ? $this->post['inc_date'] : $this->fdata['inc_date'];
        $data['hp_id'] = $_POST['hp_id'] ? $this->post['hp_id'] : $this->fdata['hp_id'];
        $data['inc_id'] = $_POST['inc_id'] ? $this->post['inc_id'] : $this->fdata['inc_id'];
        $data['dco_id'] = $_POST['dco_id'] ? $this->post['dco_id'] : $this->fdata['dco_id'];


        if (isset($data['filter'])) {


            if ($data['filter'] == 'amb_reg_no') {
                $filter = '';
                $sortby['amb_reg_id'] = $data['amb_reg_id'];
                $data['amb_reg_id'] = $sortby['amb_reg_id'];
            } else if ($data['filter'] == 'dst_name') {
                $filter = '';
                $sortby['district_id'] = $data['district_id'];
                $data['district_id'] = $sortby['district_id'];
            } else if ($data['filter'] == 'hp_name') {
                $filter = '';
                $sortby['hp_id'] = $data['hp_id'];
                $data['hp_id'] = $data['hp_id'];
                $hp_args = array('hp_id' => $data['hp_id']);
                $hp_data = $this->hp_model->get_hp_data($hp_args);
                $data['hp_name'] = $hp_data[0]->hp_name;
            } else if ($data['filter'] == 'inc_datetime') {
                $filter = '';
                $sortby['inc_date'] = date('Y-m-d', strtotime($_POST['inc_date']));
                $data['inc_date'] = $data['inc_date'];
            } else if ($data['filter'] == 'inc_ref_id') {
                $filter = '';
                $sortby['inc_id'] = $data['inc_id'];
                $data['inc_id'] = $data['inc_id'];
            }
        }

        $this->session->set_userdata('epcr_filter', $data);
        
        if ($this->clg->clg_group == 'UG-DCO' || $this->clg->clg_group == 'UG-ADMIN') {
            $args_dash = array(
                'base_month' => $this->post['base_month']
                
            );
        }else if($this->clg->clg_group == 'UG-DCOSupervisor'){           
            
            $args['clg_senior'] = $this->clg->clg_ref_id;
            $data['clg_senior'] = $this->clg->clg_ref_id;
            
            
            $clg_args = array('clg_senior'=>$this->clg->clg_ref_id,'clg_group'=>'UG-DCO');
           
            $data['dco_clg'] = $this->colleagues_model->get_clg_data($clg_args);
            
            foreach($data['dco_clg'] as $dco){
                $child_dco[] = $dco->clg_ref_id;
            }

            if(is_array($child_dco)){
                $child_dco = implode("','", $child_dco);
            }
            
            
            if ( $data['dco_id']  != '') {
                $args_dash['operator_id'] = $this->post['dco_id'];
            }else{
                //$args_dash['child_dco'] = $this->fdata['dco_id'];
            }
            
        } else {
            $args_dash = array(
                'operator_id' => $this->clg->clg_ref_id,
                'base_month' => $this->post['base_month']
            );
        }


        $inc_amb_details = $this->pcr_model->get_first_inc_by_amb();
        $data['closer_data'] = $inc_amb_details;


        // $incomplete_inc_amb = $this->pcr_model->get_incomplete_inc_amb($args_dash);

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->pcr_model->get_inc_by_emt($args_dash, '', '', $filter, $sortby, $incomplete_inc_amb);

        unset($args_dash['get_count']);
        $inc_info = $this->pcr_model->get_inc_by_emt($args_dash, $offset, $limit, $filter, $sortby, $incomplete_inc_amb);

        $arg_amb = array('amb_user_type' => 'tdd');
        $data['amb_list'] = $this->amb_model->get_amb_data();

        $data['per_page'] = $limit;
        $data['inc_offset'] = $offset;

        $inc_data = array();

//		foreach ($inc_info as $key=>$inc) {
//
//            $args = array(
//                'inc_ref_id' => $inc->inc_ref_id,
//            );
//			$inc_data_details = $this->pcr_model->get_inc_by_inc_id($args);
//			
//			$inc->amb_rto_register_no = $inc_data_details[0]->amb_rto_register_no;
//			$inc->hp_name = $inc_data_details[0]->hp_name;
//			$inc->clg_first_name = $inc_data_details[0]->clg_first_name;
//			$inc->clg_last_name = $inc_data_details[0]->clg_last_name;
//			$inc->amb_default_mobile = $inc_data_details[0]->amb_default_mobile;
//			$inc->dst_name = $inc_data_details[0]->dst_name;
//			$inc->amb_default_mobile = $inc_data_details[0]->amb_default_mobile;
//			$inc->amb_pilot_mobile = $inc_data_details[0]->amb_pilot_mobile;
//			$inc->inc_bvg_ref_number = $inc_data_details[0]->inc_bvg_ref_number;
//		   
//            
//             if(!isset($incomplete_inc_amb[$inc->inc_ref_id]['epcr_count'])){
//                $incomplete_inc_amb[$inc->inc_ref_id]['epcr_count'] = 0;
//            }
//		   
//            
//            $pending = $incomplete_inc_amb[$inc->inc_ref_id]['ptn_count'] - $incomplete_inc_amb[$inc->inc_ref_id]['epcr_count'] ;
//            
//            $closer = $incomplete_inc_amb[$inc->inc_ref_id]['epcr_count'];
//
//            $inc->total_pnt = $incomplete_inc_amb[$inc->inc_ref_id]['ptn_count'];
//            $inc->inc_patient_cnt = $incomplete_inc_amb[$inc->inc_ref_id]['ptn_count'];
//            $inc->pending = $pending;
//            $inc->closer = $closer;
//            
//            $inc_data[] = $inc;
//      
//        }
        //       $data['incomplete_inc_amb'] = $incomplete_inc_amb;
        $data['inc_info'] = $inc_info;

        $data['total_count'] = $total_cnt;

        $data['per_page'] = $limit;

        $pgconf = array(
            'url' => base_url("job_closer/pcr_listing"),
            'total_rows' => $total_cnt,
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

        $this->output->add_to_position($this->load->view('frontend/pcr/dashboard_view', $data, TRUE), 'content', TRUE);
        //$this->output->template = "pcr";
        if ($this->clg->clg_group == 'UG-DCO'){
            $this->output->template = "pcr";
        }
    }

    function call_info() {

        $this->session->unset_userdata('front_injury_data');
        $this->session->unset_userdata('back_injury_data');
        $this->session->unset_userdata('side_injury_data');
        $this->session->unset_userdata('pcr_details');
        $this->session->unset_userdata('inc_ref_id');

        $data['user_group'] = $this->clg->clg_group;
        $data['init_step'] = 'yes';

        // $this->output->add_to_position($this->load->view('frontend/pcr/pcr_top_steps_view', $data, TRUE), 'pcr_top_steps', TRUE);

        $this->output->add_to_position('', 'pcr_progressbar', TRUE);

        $this->output->add_to_position($this->load->view('frontend/pcr/call_details_view', $data, TRUE), 'content', TRUE);
        // $this->output->template = "pcr";
    }

    function epcr() {
        //$this->session->unset_userdata('inc_ref_id');

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

        $args = array(
            'inc_ref_id' => trim($this->post['inc_ref_id']),
            'base_month' => $this->post['base_month'],
        );
        $data['vahicle_info'] = $this->pcr_model->get_inc_amb_by_inc($args);


        //$data['patient_info'] = $this->pcr_model->get_pat_by_inc($args);
        $data['patient_info'] = $this->pcr_model->get_pending_pat_by_inc($args);

        $data['inc_details'] = $this->pcr_model->get_epcr_inc_details($inc_args);



        if (empty($data['inc_details'])) {

            $this->session->unset_userdata('pcr_details');
            $data['inc_details'] = $this->inc_model->get_inc_details($inc_args);
        }

        $data['inc_details_data'] = $this->inc_model->get_inc_details($inc_args);



        if (!empty($data['inc_details'])) {

            $amb_args = array(
                'inc_ref_id' => trim($this->post['inc_ref_id']),
                'amb_ref_id' => $data['inc_details'][0]->amb_ref_id,
                'base_month' => $this->post['base_month']);


            $data['inc_emp_info'] = $this->pcr_model->get_inc_amb($amb_args);

            $data['patient_id'] = $data['inc_details'][0]->ptn_id;

            $ptn_args = array(
                'ptn_id' => $data['inc_details'][0]->ptn_id,
                'base_month' => $this->post['base_month']);



            $data['pt_info'] = $this->pet_model->get_petinfo($ptn_args);


            $args = array(
                'pcr_id' => $data['inc_details'][0]->id,
                'patient_id' => $data['inc_details'][0]->ptn_id,
                'base_month' => $this->post['base_month']
            );

            $data['driver_data'] = array();

            if ($data['inc_details'][0]->id != '') {

                $data['driver_data'] = $this->pcr_model->get_driver(array('dp_pcr_id' => $data['inc_details'][0]->id));
                $odo_args = array('inc_ref_id' => trim($data['inc_details'][0]->inc_ref_id));

                $data['get_odometer'] = $this->amb_model->get_amb_odometer_by_inc($odo_args);
            } else {

                $args_odometer = array('rto_no' => $data['inc_emp_info'][0]->amb_rto_register_no);
                $amb_odometer = $this->amb_model->get_amb_odometer($args_odometer);

                if (empty($data['previous_odometer'])) {
                    $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;
                }

                if (empty($data['previous_odometer'])) {
                    $data['previous_odometer'] = 0;
                }
            }


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
            $data['invitem'] = $this->inv_model->get_inv($args);
            $data['med_list'] = $this->med_model->get_med();


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

        $odo_args = array('inc_ref_id' => $epcr_info['inc_ref_id']);
        $get_odometer = $this->amb_model->get_amb_odometer_by_inc($odo_args);
        $total_km = $epcr_info['end_odmeter'] - $epcr_info['start_odmeter'];

        $epcr_insert_info = array(
            'date' => date('Y-m-d'),
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
//        var_dump($epcr_insert_info);
//        die();

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
                $closer_operator = array(
                    'sub_id' => $epcr_info['inc_ref_id'],
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'sub_status' => 'ATD',
                    'sub_type' => 'CLOSER',
                    'base_month' => $this->post['base_month']
                );



        $closer_operator = $this->common_model->assign_operator($closer_operator);

        $inc_date = explode(' ', $epcr_info['inc_datetime']);

        $resonse_time = "";
        if($epcr_info['at_scene'] != ''){
            $d_start = new DateTime($epcr_info['inc_datetime']);
            $d_end = new DateTime($epcr_info['at_scene'] . ':00');
            $resonse_time = $d_start->diff($d_end);
        }
        //die();
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


        $insert = $this->pcr_model->insert_deriver_pcr($data);

        $epc_args = array('inc_ref_id' => $epcr_info['inc_ref_id']);
        $pcr_count = $this->pcr_model->get_epcr_count_by_inc($epc_args);

        $args_pt = array('get_count' => TRUE,
            'inc_ref_id' => $epcr_info['inc_ref_id']);

        $ptn_count = $this->pcr_model->get_pat_by_inc($args_pt);

        if ($pcr_count == $ptn_count || $pcr_count >= $ptn_count) {
            
            $update_inc_args = array('inc_ref_id' => $epcr_info['inc_ref_id'], 'inc_pcr_status' => '1');
            $update_inc = $this->inc_model->update_incident($update_inc_args);
            
            $upadate_amb_data = array('amb_rto_register_no' => $epcr_info['amb_reg_id'],'amb_status' => 1);
            //$update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
            
        } else {
            
            $update_inc_args = array('inc_ref_id' => $epcr_info['inc_ref_id'], 'inc_pcr_status' => '0');
            $update_inc = $this->inc_model->update_incident($update_inc_args);
            
        }
        
        $update_pat_args = array('ptn_id' => $epcr_info['pat_id']);
        $pat_data = array( 'ptn_pcr_status' => '1');
        $update_pat = $this->pet_model->update_petinfo($update_pat_args,$pat_data);
        
        $unique_id = get_uniqid( $this->session->userdata('user_default_key'));
        $amb_record_data = array(
                            'id'=>$unique_id,
                            'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                            'inc_ref_id'          => $epcr_info['inc_ref_id'],
                            'start_odmeter'       => $epcr_info['start_odmeter'],
                            'end_odmeter'         => $epcr_info['end_odmeter'],
                            'odometer_type'       => 'closure',
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

        if (isset($epcr_info['med'])) {
            foreach ($epcr_info['med'] as $med) {

                if ($med['value'] != '' && $med['type'] != '') {

                    $unit_args = array(
                        'as_item_id' => $med['id'],
                        'as_item_type' => $med['type'],
                        'as_stk_in_out' => 'out',
                        'as_item_qty' => $med['value'],
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
        $this->output->message = "<div class='success'> Added successfully <a href='" . $this->base_url . "job_closer' class='dark_blue'>Back to Dashboard</a></div>";

        //////////////////// Update progressbar ///////////////////////////

        $this->increase_step($epcr_insert_info);

        ///////////////////////////////////////////////////////////////////
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


            //$this->output->add_to_position($this->load->view('frontend/pcr/progressbar_view', $data, TRUE), "pcr_progressbar", TRUE);
        }



        // $this->output->add_to_position($this->load->view('frontend/pcr/pcr_top_steps_view', $data, TRUE), "pcr_top_steps", TRUE);
    }

    function show_remark_odometer() {

        $this->output->add_to_position($this->load->view('frontend/amb/odometer_standard_remark', $data, TRUE), 'remark_textbox', TRUE);
    }

    function show_remark_end_odometer() {

        $this->output->add_to_position($this->load->view('frontend/amb/end_odometer_standard_remark', $data, TRUE), 'show_remark_end_odometer', TRUE);
    }

    function show_remark_other_odometer() {
        $this->output->add_to_position($this->load->view('frontend/amb/other_end_odometer_view', $data, TRUE), 'end_odometer_remark_other_textbox', TRUE);
    }

    function other_provider_impression() {

        $this->output->add_to_position($this->load->view('frontend/pcr/other_provider_impression_view', $data, TRUE), 'other_provider_impression', TRUE);
    }

    function show_end_odometer() {

        $odometer = $this->input->post();

        $data['start'] = $odometer['start_odo'];

        $this->output->add_to_position($this->load->view('frontend/amb/end_odometer_view', $data, TRUE), 'end_odometer_textbox', TRUE);
    }

    function other_hospital_textbox() {
        $this->output->add_to_position($this->load->view('frontend/pcr/other_hospital_textbox_view', $data, TRUE), 'other_hospital_textbox', TRUE);
    }

    function show_unit_other() {
        $this->output->add_to_position($this->load->view('frontend/pcr/show_unit_other', $data, TRUE), 'show_other_unit', TRUE);
    }

    function show_non_unit_other() {
        $this->output->add_to_position($this->load->view('frontend/pcr/show_non_unit_other', $data, TRUE), 'show_non_unit_other', TRUE);
    }

    function obious_death_popup() {

        $data['questions'] = $this->pcr_model->get_obious_death_questions();


        $this->output->add_to_position($this->load->view('frontend/pcr/obious_death_questions_view', $data, TRUE), 'other_provider_impression', TRUE);
        //$this->output->add_to_popup($this->load->view('frontend/pcr/obious_death_questions_view', $data, TRUE), '600', '600');


        $this->output->template = "pcr";
    }

    function show_emso_id() {

        $emt_id = $this->input->post('emt_id');
        $args = array('clg_group' => 'UG-EMT', 'clg_emso_id' => $emt_id);

        $clg = $this->colleagues_model->get_clg_data($args);
        $data['emso_name'] = $clg[0]->clg_first_name . ' ' . $clg[0]->clg_mid_name . ' ' . $clg[0]->clg_last_name;
        $data['clg_ref_id'] = $clg[0]->clg_ref_id;
        $this->output->add_to_position($this->load->view('frontend/pcr/emso_id_view', $data, TRUE), 'show_emso_name', TRUE);
    }

    function show_pilot_id() {
        $ref_id = $this->input->post('ref_id');

        //$args = array('clg_group' => 'UG-PILOT', 'clg_ref_id' => $emt_id);
        //$clg = $this->colleagues_model->get_clg_data($args);
        $data['ref_id'] = $ref_id;
        $this->output->add_to_position($this->load->view('frontend/pcr/pilot_id_view', $data, TRUE), 'show_pilot_id', TRUE);
    }
    function show_pilot() {
        $ref_id = $this->input->post('ref_id');

        //$args = array('clg_group' => 'UG-PILOT', 'clg_ref_id' => $emt_id);
        //$clg = $this->colleagues_model->get_clg_data($args);
        $data['ref_id'] = $ref_id;
        $this->output->add_to_position($this->load->view('frontend/pcr/pilot_id_view', $data, TRUE), 'show_pilot_id', TRUE);
    }

    function update_epcr_status() {
        $inc = $this->inc_model->get_all_inc();

        foreach ($inc as $epcr_info) {

            $epc_args = array('inc_ref_id' => $epcr_info['inc_ref_id']);
            $pcr_count = $this->pcr_model->get_epcr_count_by_inc($epc_args);

            $args_pt = array('get_count' => TRUE,
                'inc_ref_id' => $epcr_info['inc_ref_id']);

            $ptn_count = $this->pcr_model->get_pat_by_inc($args_pt);

            if ($pcr_count == $ptn_count || $pcr_count >= $ptn_count) {
                //  echo $epcr_info['inc_ref_id'];
                $update_inc_args = array('inc_ref_id' => $epcr_info['inc_ref_id'], 'inc_pcr_status' => '1');
                $update_inc = $this->inc_model->update_incident($update_inc_args);
                // echo $update_inc;
            } else {
                // echo 'in';
                $update_inc_args = array('inc_ref_id' => $epcr_info['inc_ref_id'], 'inc_pcr_status' => '0');
                $update_inc = $this->inc_model->update_incident($update_inc_args);
                //   echo $update_inc;
            }
        }
    }
    
    function update_epcr_patient_status() {
            
        $inc = $this->inc_model->get_all_inc();

        foreach ($inc as $epcr_info) {

            $epc_args = array('inc_ref_id' => $epcr_info['inc_ref_id']);
            $patient_info = $this->pcr_model->get_pat_by_inc($epc_args);
            foreach($patient_info as $ptn){  
                $args_pt = array( 'inc_ref_id' => $epcr_info['inc_ref_id'],
                                  'ptn_id'=>$ptn->ptn_id);

                $ptn_data = $this->pcr_model->get_epcr_inc_details($args_pt);
                
                if(empty($ptn_data)){
                  
                    $update_pat_args = array('ptn_id' => $ptn->ptn_id);   
                    $pat_data = array( 'ptn_pcr_status' => '0');
                    $update_pat = $this->pet_model->update_petinfo($update_pat_args,$pat_data);
                }else{
                    $update_pat_args = array('ptn_id' => $ptn->ptn_id);   
                    $pat_data = array('ptn_pcr_status' => '1');
                    $update_pat = $this->pet_model->update_petinfo($update_pat_args,$pat_data);
                    
                }
               
            }

        }
        die();
    }

}
