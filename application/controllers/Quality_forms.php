<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Quality_Forms extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->active_module = "M-QUALITY-FORMS";
        $this->pg_limit = $this->config->item('pagination_limit');
        $this->load->library(array('session', 'modules'));
        $this->load->model(array('module_model', 'colleagues_model', 'quality_model', 'call_model', 'feedback_model', 'inc_model', 'pcr_model', 'enquiry_model', 'options_model', 'common_model', 'Pet_model', 'medadv_model', 'inc_model', 'grievance_model', 'feedback_model', 'fire_model', 'police_model','colleagues_model'));

        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper', 'language_helper'));

        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));

        $this->post = $this->input->get_post(NULL);
        $this->post['base_month'] = get_base_month();
        $this->clg = $this->session->userdata('current_user');
        $this->post['base_month'] = get_base_month();
    }

    public function index($generated = false) {
        echo "You are in the Quality Forms controllers";
    }

    function quality_forms() {

        $data['all_purpose_of_calls'] = $this->call_model->get_all_child_purpose_of_calls();
        $data['qa'] = $this->call_model->get_all_qa();
        $this->output->add_to_position($this->load->view('frontend/quality/quality_forms_views', $data, TRUE), 'content', TRUE);
    }

    function show_form_list() {

        $team_type = $this->post['team_type'];
        //var_dump($team_type);die;
        ///////////limit & offset////////

        $data['get_count'] = TRUE;
        // $team_type =str_replace(",","','",$team_type);
        $data['clg_ref_id_qality'] = $team_type;




        $data['added_by'] = $this->post['qa_name'];
        if ($this->post['from_date'] != '') {
            $data['from_date'] = date('Y-m-d', strtotime($this->post['from_date']));
        }
        if ($this->post['to_date'] != '') {
            $data['to_date'] = date('Y-m-d', strtotime($this->post['to_date']));
        }


        $data['total_count'] = $this->quality_model->get_qa_form_team($data);

        //$config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        ///////////set page number////////////////////
        $page_no = 1;
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        unset($data['get_count']);

        $data['maintance_data'] = $this->quality_model->get_qa_form_team($data, $offset, $limit);


        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("quality_forms/show_form_list"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&team_type=$team_type"
            )
        );

        $data['pgconf'] = $pgconf;
        $data['pagination'] = get_pagination($pgconf);

        /////////////////////////////////

        $data['page_records'] = $data['total_count'];

        $this->output->add_to_position($this->load->view('frontend/quality/show_form_list_view', $data, TRUE), 'list_table', TRUE);
    }

    function view_incidence_quality() {
       
        
        if (!empty($this->post['search_chief_comp'])) {

            $this->session->set_userdata('search_chief_comp', $this->post['search_chief_comp']);
        } else {

            $search_chief_comp = $this->session->userdata('search_chief_comp');
        }

        $data['search_chief_comp'] = ($this->post['search_chief_comp']) ? $this->post['search_chief_comp'] : $this->post['search_chief_comp'];

        if ($this->post['from_date'] != '') {
            $data['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date']));
        } else {
            $data['from_date'] = date('Y-m-d');
        }


        if ($this->post['to_date'] != '') {
            $data['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->post['to_date']));
        } else {
            $data['to_date'] = date('Y-m-d');
        }
        if ($this->post['call_purpose'] != '') {

            $data['call_purpose'] = $this->post['call_purpose'];
        }
        if ($this->post['team_type'] != '') {

          $args_dash['team_type'] = $data['user_type'] = $this->post['team_type'];
        }


        $ref_id = $data['user_id'] = $this->post['user_id'];
        $team_type = $this->post['team_type'];
        


        if (!empty($ref_id)) {

            $this->session->set_userdata('quality_ref_id', $ref_id);
        } else {

            $ref_id = $this->session->userdata('quality_ref_id');
        }






        $data['ref_id'] = $ref_id;

        $this->post = $this->input->post();
        $this->post['base_month'] = get_base_month();
        $data['team_type'] = $this->post['team_type'];

        $data['user_type'] = $this->post['user_type'];

        if (strstr($team_type, 'ERO')) {
            $data['user_type'] = 'ERO';
        } else {
            $data['user_type'] = 'DCO';
         }
        if (!empty($data['user_type'])) {
            $this->session->set_userdata('quality_user_type', $data['user_type']);
        } else {
            $data['user_type'] = $this->session->userdata('quality_user_type');
        }



        $data['pg_rec'] = $pg_rec = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        //$this->pg_limit = 10;
        ///////////set page number////////////////////

        $page_no = 1;


        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }

        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


        $args_dash = array(
            'operator_id' => $ref_id,
            'base_month' => $this->post['base_month'],
            //'search_chief_comp' => $data['search_chief_comp'],
            'search_chief_comp' => $this->post['search_chief_comp'],
            //'today' => date('Y-m-d', strtotime("-1 days"))
        );

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
 //unset($data['get_count']);

        if ($this->post['from_date'] != '') {
            $args_dash['from_date'] = date('Y-m-d', strtotime($this->post['from_date']));
        } else {
            $args_dash['from_date'] = date('Y-m-d', strtotime("-1 days"));
        }


        if ($this->post['to_date'] != '') {
            $args_dash['to_date'] = date('Y-m-d', strtotime($this->post['to_date']));
        } else {
            $args_dash['to_date'] = date('Y-m-d');
        }
        $args_dash['closure_done_inc'] = "0,1";
        if ($this->post['call_purpose'] != '') {

            $args_dash['call_purpose'] = $this->post['call_purpose'];
            $call_purpose = $this->post['call_purpose'];
        }
        if ($this->post['team_type'] != '') {

            $args_dash['team_type'] = $this->post['team_type'];
        }
        if ($this->post['qa_id'] != '') {
            $args_dash['qa_id'] = $this->post['qa_id'];
        }
        //$data['team_type'] = $this->post['team_type'];

       
        if (strstr($team_type, 'ERO')) {
           
            $inc_info = $this->call_model->get_inc_by_ero_audit($args_dash, $offset, $limit);
        }else if(strstr($team_type, 'DCO')) {
            $inc_info = $this->inc_model->get_epcr_by_group($args_dash, $offset, $limit);
        }else{
            $inc_info = $this->call_model->get_inc_by_ero_audit($args_dash, $offset, $limit);
        }




        $inc_data = (object) array();

        $data['per_page'] = $limit;

        $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;

        if (strstr($team_type, 'ERO')) {
            
            $total_cnt = $this->call_model->get_inc_by_ero_audit($args_dash);
        }else if(strstr($team_type, 'DCO')) {
            $total_cnt = $this->inc_model->get_epcr_by_group($args_dash);
        }else{
            
            $total_cnt = $this->call_model->get_inc_by_ero_audit($args_dash);
        }
        // if (strstr($team_type, 'ERO')) {
        //     $total_cnt = $this->call_model->get_inc_by_ero_audit($args_dash);
        // } else {
        //     $total_cnt = $this->inc_model->get_epcr_by_group($args_dash);
        // }



        $data['total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("quality_forms/view_incidence_quality"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
            'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc&ref_id=$ref_id&team_type=$team_type&pg_rec=$pg_rec&call_purpose=$call_purpose"
            )
        );


        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);

        // $this->output->add_to_position($this->load->view('frontend/fleet/date_filter_view', $data, true), 'date_filter', true);

        $this->output->add_to_position($this->load->view('frontend/quality/view_incidence_quality', $data, TRUE), 'list_table', TRUE);
    }

    function view_ero_incidence_quality() {
//var_dump($this->input->post()); die;

        if (!empty($this->post['search_chief_comp'])) {

            $this->session->set_userdata('search_chief_comp', $this->post['search_chief_comp']);
        } else {

            $search_chief_comp = $this->session->userdata('search_chief_comp');
        }

        $data['search_chief_comp'] = ($this->post['search_chief_comp']) ? $this->post['search_chief_comp'] : $search_chief_comp;

        if ($this->post['from_date'] != '') {
            $data['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date']));
        }


        if ($this->post['to_date'] != '') {
            $data['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->post['to_date']));
        }


        $ref_id = $this->post['ref_id'];

        if (!empty($ref_id)) {

            $this->session->set_userdata('quality_ref_id', $ref_id);
        } else {

            $ref_id = $this->session->userdata('quality_ref_id');
        }






        $data['ref_id'] = $ref_id;

        $this->post = $this->input->post();
        $this->post['base_month'] = get_base_month();

        $data['user_type'] = $this->post['user_type'];

        if (!empty($data['user_type'])) {
            $this->session->set_userdata('quality_user_type', $data['user_type']);
        } else {
            $data['user_type'] = $this->session->userdata('quality_user_type');
        }



        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        //$this->pg_limit = 10;
        ///////////set page number////////////////////

        $page_no = 1;


        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


        $args_dash = array(
            'operator_id' => $ref_id,
            'base_month' => $this->post['base_month'],
            //'search_chief_comp' => $data['search_chief_comp'],
            'search_chief_comp' => $this->post['search_chief_comp'],
            'today' => date('Y-m-d', strtotime("-1 days"))
        );

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;


        if ($this->post['from_date'] != '') {
            $args_dash['from_date'] = date('Y-m-d', strtotime($this->post['from_date']));
        } else {
//            $data['from_date'] = date('Y-m-d');
        }


        if ($this->post['to_date'] != '') {
            $args_dash['to_date'] = date('Y-m-d', strtotime($this->post['to_date']));
        } else {
//            $data['to_date'] = date('Y-m-d');
        }
        $args_dash['closure_done_inc'] = "0,1";


        $inc_info = $this->call_model->get_inc_by_ero_audit($args_dash, $offset, $limit);




        $inc_data = (object) array();

        $data['per_page'] = $limit;

        $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->call_model->get_inc_by_ero_audit($args_dash);


        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("quality_forms/view_ero_incidence_quality"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc&ref_id=$ref_id"
            )
        );


        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);

        $this->output->add_to_position($this->load->view('frontend/fleet/date_filter_view', $data, true), 'date_filter', true);

        $this->output->add_to_position($this->load->view('frontend/quality/view_incidence_quality', $data, TRUE), 'content', TRUE);
    }

    function view_dco_incidence_quality() {

        $ref_id = $this->post['ref_id'];
        if (!empty($ref_id)) {
            $this->session->set_userdata('quality_ref_id', $ref_id);
        } else {
            $ref_id = $this->session->userdata('quality_ref_id');
        }


        $data['ref_id'] = $ref_id;

        $this->post = $this->input->post();
        $this->post['base_month'] = get_base_month();

        $data['user_type'] = $this->post['user_type'];

        if (!empty($data['user_type'])) {
            $this->session->set_userdata('quality_user_type', $data['user_type']);
        } else {
            $data['user_type'] = $this->session->userdata('quality_user_type');
        }



        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        $this->pg_limit = 10;
        ///////////set page number////////////////////

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


        $args_dash = array(
            'operator_id' => $ref_id,
            'base_month' => $this->post['base_month']
        );

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        $inc_info = $this->inc_model->get_epcr_by_group($args_dash, $offset, $limit);

        $inc_data = (object) array();

        $data['per_page'] = $limit;
        $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->inc_model->get_epcr_by_group($args_dash);

        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("quality_forms/view_dco_incidence_quality"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content"
            )
        );


//        $config = get_pagination($pgconf);
//        $data['pagination'] = get_pagination($pgconf);

        $this->output->add_to_position($this->load->view('frontend/quality/view_dco_incidence_quality', $data, TRUE), 'content', TRUE);
    }

    function view_ercp_incidence_quality() {

        $ref_id = $this->post['ref_id'];
        if (!empty($ref_id)) {
            $this->session->set_userdata('quality_ref_id', $ref_id);
        } else {
            $ref_id = $this->session->userdata('quality_ref_id');
        }


        $data['ref_id'] = $ref_id;

        $this->post = $this->input->post();
        $this->post['base_month'] = get_base_month();

        $data['user_type'] = $this->post['user_type'];

        if (!empty($data['user_type'])) {
            $this->session->set_userdata('quality_user_type', $data['user_type']);
        } else {
            $data['user_type'] = $this->session->userdata('quality_user_type');
        }



        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        $this->pg_limit = 10;
        ///////////set page number////////////////////

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


        $args_dash = array(
            'operator_id' => $ref_id,
            'base_month' => $this->post['base_month']
        );

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        $inc_info = $this->medadv_model->get_ercp_by_group($args_dash, $offset, $limit);

        $inc_data = (object) array();

        $data['per_page'] = $limit;
        $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->medadv_model->get_ercp_by_group($args_dash);

        $data['inc_total_count'] = $total_cnt;
        $data['total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("quality_forms/view_ercp_incidence_quality"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content"
            )
        );


//        $config = get_pagination($pgconf);
//        $data['pagination'] = get_pagination($pgconf);

        $this->output->add_to_position($this->load->view('frontend/quality/view_ercp_incidence_quality', $data, TRUE), 'content', TRUE);
    }

    function view_grieviance_incidence_quality() {

        $ref_id = $this->post['ref_id'];
        if (!empty($ref_id)) {
            $this->session->set_userdata('quality_ref_id', $ref_id);
        } else {
            $ref_id = $this->session->userdata('quality_ref_id');
        }


        $data['ref_id'] = $ref_id;

        $this->post = $this->input->post();
        $this->post['base_month'] = get_base_month();

        $data['user_type'] = $this->post['user_type'];

        if (!empty($data['user_type'])) {
            $this->session->set_userdata('quality_user_type', $data['user_type']);
        } else {
            $data['user_type'] = $this->session->userdata('quality_user_type');
        }



        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        $this->pg_limit = 10;
        ///////////set page number////////////////////

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


        $args_dash = array(
            'operator_id' => $ref_id,
            'base_month' => $this->post['base_month']
        );

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        $inc_info = $this->grievance_model->get_inc_by_grievance($args_dash, $offset, $limit);

        $inc_data = (object) array();

        $data['per_page'] = $limit;
        $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->grievance_model->get_inc_by_grievance($args_dash);

        $data['inc_total_count'] = $total_cnt;
        $data['total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("quality_forms/view_grieviance_incidence_quality"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content"
            )
        );


//        $config = get_pagination($pgconf);
//        $data['pagination'] = get_pagination($pgconf);

        $this->output->add_to_position($this->load->view('frontend/quality/view_griviance_incidence_quality', $data, TRUE), 'content', TRUE);
    }

    function view_fda_incidence_quality() {

        $ref_id = $this->post['ref_id'];
        if (!empty($ref_id)) {
            $this->session->set_userdata('quality_ref_id', $ref_id);
        } else {
            $ref_id = $this->session->userdata('quality_ref_id');
        }


        $data['ref_id'] = $ref_id;

        $this->post = $this->input->post();
        $this->post['base_month'] = get_base_month();

        $data['user_type'] = $this->post['user_type'];

        if (!empty($data['user_type'])) {
            $this->session->set_userdata('quality_user_type', $data['user_type']);
        } else {
            $data['user_type'] = $this->session->userdata('quality_user_type');
        }



        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        $this->pg_limit = 10;
        ///////////set page number////////////////////

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


        $args_dash = array(
            'operator_id' => $ref_id,
            'base_month' => $this->post['base_month']
        );

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        $inc_info = $this->fire_model->get_inc_by_fire($args_dash, $offset, $limit);

        $inc_data = (object) array();

        $data['per_page'] = $limit;
        $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->fire_model->get_inc_by_fire($args_dash);

        $data['inc_total_count'] = $total_cnt;
        $data['total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("quality_forms/view_fda_incidence_quality"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content"
            )
        );


//        $config = get_pagination($pgconf);
//        $data['pagination'] = get_pagination($pgconf);

        $this->output->add_to_position($this->load->view('frontend/quality/view_fire_incidence_quality', $data, TRUE), 'content', TRUE);
    }

    function view_pda_incidence_quality() {

        $ref_id = $this->post['ref_id'];

        if (!empty($ref_id)) {
            $this->session->set_userdata('quality_ref_id', $ref_id);
        } else {
            $ref_id = $this->session->userdata('quality_ref_id');
        }

        $data['ref_id'] = $ref_id;

        $this->post = $this->input->post();
        $this->post['base_month'] = get_base_month();

        $data['user_type'] = $this->post['user_type'];

        if (!empty($data['user_type'])) {
            $this->session->set_userdata('quality_user_type', $data['user_type']);
        } else {
            $data['user_type'] = $this->session->userdata('quality_user_type');
        }



        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        $this->pg_limit = 10;
        ///////////set page number////////////////////

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


        $args_dash = array(
            'pda_operator_id' => $ref_id,
            'base_month' => $this->post['base_month']
        );

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        $inc_info = $this->police_model->get_inc_by_police($args_dash, $offset, $limit);

        $inc_data = (object) array();

        $data['per_page'] = $limit;
        $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->police_model->get_inc_by_police($args_dash);

        $data['inc_total_count'] = $total_cnt;
        $data['total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("quality_forms/view_pda_incidence_quality"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content"
            )
        );


//        $config = get_pagination($pgconf);
//        $data['pagination'] = get_pagination($pgconf);

        $this->output->add_to_position($this->load->view('frontend/quality/view_pda_incidence_quality', $data, TRUE), 'content', TRUE);
    }
    function open_feedback(){   
        $data['current_user_group']= $this->clg->clg_group;
        if (!empty($ref_id)) {
            $this->session->set_userdata('quality_ref_id', $ref_id);
        } else {
            $ref_id = $this->session->userdata('quality_ref_id');
        }
        $inc_ref_id = $this->post['inc_ref_id'];
        $ero_name = get_clg_data_by_ref_id($inc_call_type[0]->inc_added_by);
        $data['type'] = $this->post['type'];
        $this->post['base_month'] = get_base_month();
        $data['inc_ref_id'] = $inc_ref_id;

       $reff_id = $this->post['inc_added_by'];
       $data['inc_added_by'] = $reff_id;
        $usr_id = $this->post['ref_id'];

        $data['user_type'] = $this->post['user_type'];
        $ref_id = 'UG-' . $data['user_type'];

        $data['ref_id'] = $this->post['ref_id'];
        $data['user_type'] = $this->post['user_type'];
        $data['inc_ref_no'] = $this->post['inc_ref_id'];


        $args_dash = array('inc_id' => $inc_ref_id,
            'base_month' => $this->post['base_month']);

        //$data['inc_data'] = $this->call_model->get_inc_by_ero_calls($args_dash);
        $data['feedback_details'] = $this->feedback_model->get_feedback_details(array('inc_ref_id' => trim($data['inc_ref_no'])));

        $args = array('inc_ref_id' => $inc_ref_id,
            'base_month' => $this->post['base_month'],
            'user_type' => $data['user_type']
            
            );

        $data['inc_call_type'] = $this->inc_model->get_inc_ref_id($args);
        $data['inc_details'] = $this->inc_model->get_inc_call_details_ref_id($args);
        
        $data['audit_details'] = $this->quality_model->get_quality_audit($args);

        $args_st = array('st_code' => $data['inc_details'][0]->inc_state_id);
        $state = $this->inc_model->get_state_name($args_st);
        $data['state_name'] = $state[0]->st_name;

        $args_dst = array('st_code' => $data['inc_details'][0]->inc_state_id, 'dst_code' => $data['inc_details'][0]->inc_district_id);

        $district = $this->inc_model->get_district_name($args_dst);
        $data['district_name'] = $district[0]->dst_name;

        $args_th = array('thl_id' => $data['inc_details'][0]->inc_tahshil_id);
        $tahshil = $this->inc_model->get_tahshil($args_th);
        $data['tahshil_name'] = $tahshil[0]->thl_name;


        $args_ct = array('cty_id' => $data['inc_details'][0]->inc_city_id, 'dst_code' => $data['inc_details'][0]->inc_district_id);

        $city = $this->inc_model->get_city_name($args_ct);
        $data['city_name'] = $city[0]->cty_name;

        $data['cl_relation'] = $inc_data[0]->cl_relation;
        $cm_id = $data['inc_details'][0]->inc_complaint;
        $chief_comp = $this->inc_model->get_chief_comp_service($cm_id);
        $data['chief_complete_name'] = $chief_comp[0]->ct_type;
        $args_pt = array('get_count' => TRUE,
            'inc_ref_id' => $data['inc_ref_no']);

        $data['ptn_count'] = $this->pcr_model->get_pat_by_inc($args_pt);

        $gri_args = array(
            'gc_inc_ref_id' => trim($this->input->post('inc_ref_id'))
        );


        $data['grievance_info'] = $this->grievance_model->get_inc_by_grievance($gri_args, '', '', $filter, $sortby);

        $args = array('gc_inc_ref_id' => $this->input->post('inc_ref_id'));

        $data['cl_dtl'] = $this->grievance_model->get_inc_by_grievance($args);

        $sup_remark_args = array(
            's_inc_ref_id' => trim($this->input->post('inc_ref_id'))
        );
        $data['supervisor_remark'] = $this->call_model->get_inc_supervisor_remark($sup_remark_args);


        $cm_id = $data['inc_details'][0]->inc_complaint;
        $chief_comp = $this->inc_model->get_chief_comp_service($cm_id);
        $data['chief_complete_name'] = $chief_comp[0]->ct_type;

        $args_pur = array('pcode' => $data['inc_details'][0]->cl_purpose);

        $data['pname'] = $this->inc_model->get_purpose_call($args_pur);

        $data['pt_info'] = $this->Pet_model->get_ptinc_info_quality($arg);

        $args_pur = array('pcode' => $data['pt_info'][0]->inc_type);

        //$data['pname'] = $call_pur[0]->pname;
        $ptn_args = array('inc_ref_id' => $data['inc_ref_no'],
//                'ptn_id' => $data['inc_details'][0]->ptn_id,
        );

        $data['ptn_details'] = $this->Pet_model->get_ptinc_info_quality($ptn_args);
        $data['facility_details'] = $this->inc_model->get_hospital_facility(array('inc_ref_id' => trim($data['inc_ref_no'])));

        $data['feedback_details'] = $this->feedback_model->get_feedback_details(array('inc_ref_id' => trim($data['inc_ref_no'])));
         $inc_args = array(
                'inc_ref_id' => $data['inc_ref_no'],
                'inc_type' => $data['inc_call_type'][0]->inc_type
            );


        $data['questions'] = $this->inc_model->get_inc_summary($inc_args);

        $ques_args = array(
            'inc_ref_id' => $data['inc_ref_no'],
            'inc_type' => 'FEED_' . $data['inc_call_type'][0]->inc_type
        );



        $data['feed_questions'] = $this->inc_model->get_inc_summary($ques_args);

        $amb_args = array('inc_ref_id' => $data['inc_ref_no']);

        $data['enquiry_data'] = $this->enquiry_model->get_enquiry($amb_args);

        $myArray = explode(',', $data['enquiry_data'][0]->enq_que);
        
        

        $data['enq_que'] = array();

        $q = 0;
       // var_dump($myArray); die;
        if ($myArray) {
            foreach ($myArray as $que) {
                if($que != ""){

                    $enq_que = $this->common_model->get_question(array('que_id' => $que));

                    $serialize_que = $enq_que[0]->que_question;

                    $data['enq_que'][$q]['que'] = get_lang_data($serialize_que, $data['enquiry_data'][0]->enq_lang);

                    $ans = $this->common_model->get_answer(array('ans_que_id' => $que));

                    $serialize_ans = $ans[0]->ans_answer;

                    $data['enq_que'][$q]['ans'] = get_lang_data($serialize_ans, $data['enquiry_data'][0]->enq_lang);

                    $data['enq_que'][$q]['que_id'] = $que;

                    $q++;
                }
                
            }
        }


        $data['epcr_inc_details'] = $this->pcr_model->get_epcr_inc_details_by_inc_id($inc_args);
        $data['er_inc_details'] = $this->medadv_model->get_epcr_by_inc_id($inc_args);

        $data['driver_data'] = $this->pcr_model->get_driver(array('inc_ref_id' => trim($data['inc_ref_no'])));
        $data['tdo_id'] = $this->call_model->get_tdo_inc($data['inc_ref_no']);


        $ver_args = array('qa_user_group' => $ref_id,
            'qa_ques_type' => 'ver_mat');
        $data['ero_ver_mat'] = $this->quality_model->get_quality_question($ver_args);

        $ver_args = array('qa_user_group' => $ref_id,
            'qa_ques_type' => 'open_greet');
        $data['ero_open_greet'] = $this->quality_model->get_quality_question($ver_args);

        $ver_args = array('qa_user_group' => $ref_id,
            'qa_ques_type' => 'comp_systm');
        $data['ero_comp_systm'] = $this->quality_model->get_quality_question($ver_args);

        $ver_args = array('qa_user_group' => $ref_id,
            'qa_ques_type' => 'notification');
        $data['ero_notification'] = $this->quality_model->get_quality_question($ver_args);

        $hold_procedure_args = array('qa_user_group' => $ref_id,
            'qa_ques_type' => 'hold_procedure');
        $data['ero_hold_procedure'] = $this->quality_model->get_quality_question($hold_procedure_args);

        $commu_skill_args = array('qa_user_group' => $ref_id,
            'qa_ques_type' => 'commu_skill');
        $data['ero_commu_skill'] = $this->quality_model->get_quality_question($commu_skill_args);

        $commu_closing_greet = array('qa_user_group' => $ref_id,
            'qa_ques_type' => 'closing_greet');
        $data['ero_closing_greet'] = $this->quality_model->get_quality_question($commu_closing_greet);

        $fetal_indicator = array('qa_user_group' => $ref_id,
            'qa_ques_type' => 'fetal_indicator');
        $data['ero_fetal_indicator'] = $this->quality_model->get_quality_question($fetal_indicator);

        $data['ero_id'] = $usr_id;
        $data['current_user_group']= $this->clg->clg_group;
        $this->output->add_to_popup($this->load->view('frontend/quality/open_audit_view', $data, TRUE), '1200', '800');  
    }
    function open_audit() {
  
       // $ref_id = $this->post['ref_id'];
       $data['current_user_group']= $this->clg->clg_group;
        if (!empty($ref_id)) {
            $this->session->set_userdata('quality_ref_id', $ref_id);
        } else {
            $ref_id = $this->session->userdata('quality_ref_id');
        }
        //var_dump($ref_id);die;
        $inc_ref_id = $this->post['inc_ref_id'];
       $ero_name = get_clg_data_by_ref_id($inc_call_type[0]->inc_added_by);
        //var_dump($ref_id);die;user_quality
        $data['type'] = $this->post['type'];
        $this->post['base_month'] = get_base_month();
        $data['inc_ref_id'] = $inc_ref_id;
        $data['feedback'] =$this->post['feedback'];

       $reff_id = $this->post['inc_added_by'];
       $data['inc_added_by'] = $reff_id;
        $usr_id = $this->post['ref_id'];

        $data['user_type'] = $this->post['user_type'];
        $ref_id =  $data['user_type'];

        $data['ref_id'] = $this->post['ref_id'];
        //$data['user_type'] = $this->post['user_type'];

        $data['inc_ref_no'] = $this->post['inc_ref_id'];


        $args_dash = array('inc_id' => $inc_ref_id,
            'base_month' => $this->post['base_month']);

        //$data['inc_data'] = $this->call_model->get_inc_by_ero_calls($args_dash);
        $data['feedback_details'] = $this->feedback_model->get_feedback_details(array('inc_ref_id' => trim($data['inc_ref_no'])));

        $args = array('inc_ref_id' => $inc_ref_id,
            'base_month' => $this->post['base_month'],
            'user_type' => $data['user_type']);

        $data['inc_call_type'] = $this->inc_model->get_inc_ref_id($args);
        $data['inc_details'] = $this->inc_model->get_inc_call_details_ref_id($args);
        
        $data['audit_details'] = $this->quality_model->get_quality_audit($args);
        //var_dump($data['audit_details'][0]);die;
        $args_st = array('st_code' => $data['inc_details'][0]->inc_state_id);
        $state = $this->inc_model->get_state_name($args_st);
        $data['state_name'] = $state[0]->st_name;

        $args_dst = array('st_code' => $data['inc_details'][0]->inc_state_id, 'dst_code' => $data['inc_details'][0]->inc_district_id);

        $district = $this->inc_model->get_district_name($args_dst);
        $data['district_name'] = $district[0]->dst_name;

        $args_th = array('thl_id' => $data['inc_details'][0]->inc_tahshil_id);
        $tahshil = $this->inc_model->get_tahshil($args_th);
        $data['tahshil_name'] = $tahshil[0]->thl_name;


        $args_ct = array('cty_id' => $data['inc_details'][0]->inc_city_id, 'dst_code' => $data['inc_details'][0]->inc_district_id);

        $city = $this->inc_model->get_city_name($args_ct);
        $data['city_name'] = $city[0]->cty_name;

        $data['cl_relation'] = $inc_data[0]->cl_relation;
        $cm_id = $data['inc_details'][0]->inc_complaint;
        $chief_comp = $this->inc_model->get_chief_comp_service($cm_id);
        $data['chief_complete_name'] = $chief_comp[0]->ct_type;
        $args_pt = array('get_count' => TRUE,
            'inc_ref_id' => $data['inc_ref_no']);

        $data['ptn_count'] = $this->pcr_model->get_pat_by_inc($args_pt);

        $gri_args = array(
            'gc_inc_ref_id' => trim($this->input->post('inc_ref_id'))
        );


        $data['grievance_info'] = $this->grievance_model->get_inc_by_grievance($gri_args, '', '', $filter, $sortby);

        $args = array('gc_inc_ref_id' => $this->input->post('inc_ref_id'));

        $data['cl_dtl'] = $this->grievance_model->get_inc_by_grievance($args);

        $sup_remark_args = array(
            's_inc_ref_id' => trim($this->input->post('inc_ref_id'))
        );
        $data['supervisor_remark'] = $this->call_model->get_inc_supervisor_remark($sup_remark_args);


        $cm_id = $data['inc_details'][0]->inc_complaint;
        $chief_comp = $this->inc_model->get_chief_comp_service($cm_id);
        $data['chief_complete_name'] = $chief_comp[0]->ct_type;

        $args_pur = array('pcode' => $data['inc_details'][0]->cl_purpose);

        $data['pname'] = $this->inc_model->get_purpose_call($args_pur);

//        $data['pt_info'] = $this->Pet_model->get_ptinc_info($arg);
//
//        $args_pur = array('pcode' => $data['pt_info'][0]->inc_type);

        //$data['pt_info'] = $this->Pet_model->get_ptinc_info_quality($arg);

        $args_pur = array('pcode' => $data['pt_info'][0]->inc_type);


        //$data['pname'] = $call_pur[0]->pname;
        $ptn_args = array('inc_ref_id' => $data['inc_ref_no'],
//                'ptn_id' => $data['inc_details'][0]->ptn_id,
        );


        $data['ptn_details'] = $this->pcr_model->get_pat_by_inc($ptn_args);
        
        $data['dco_info'] = $this->inc_model->get_epcr_by_group($ptn_args);

       // $data['ptn_details'] = $this->Pet_model->get_ptinc_info_quality($ptn_args);
        $data['facility_details'] = $this->inc_model->get_hospital_facility(array('inc_ref_id' => trim($data['inc_ref_no'])));

        $data['feedback_details'] = $this->feedback_model->get_feedback_details(array('inc_ref_id' => trim($data['inc_ref_no'])));
         $inc_args = array(
                'inc_ref_id' => $data['inc_ref_no'],
                'inc_type' => $data['inc_call_type'][0]->inc_type
            );


        $data['questions'] = $this->inc_model->get_inc_summary($inc_args);

        $ques_args = array(
            'inc_ref_id' => $data['inc_ref_no'],
            'inc_type' => 'FEED_' . $data['inc_call_type'][0]->inc_type
        );



        $data['feed_questions'] = $this->inc_model->get_inc_summary($ques_args);

        $amb_args = array('inc_ref_id' => $data['inc_ref_no']);

        $data['enquiry_data'] = $this->enquiry_model->get_enquiry($amb_args);

        $myArray = explode(',', $data['enquiry_data'][0]->enq_que);
        
        

        $data['enq_que'] = array();

        $q = 0;
       // var_dump($myArray); die;
        if ($myArray) {
            foreach ($myArray as $que) {
                if($que != ""){

                    $enq_que = $this->common_model->get_question(array('que_id' => $que));

                    $serialize_que = $enq_que[0]->que_question;

                    $data['enq_que'][$q]['que'] = get_lang_data($serialize_que, $data['enquiry_data'][0]->enq_lang);

                    $ans = $this->common_model->get_answer(array('ans_que_id' => $que));

                    $serialize_ans = $ans[0]->ans_answer;

                    $data['enq_que'][$q]['ans'] = get_lang_data($serialize_ans, $data['enquiry_data'][0]->enq_lang);

                    $data['enq_que'][$q]['que_id'] = $que;

                    $q++;
                }
                
            }
        }


        $data['epcr_inc_details'] = $this->pcr_model->get_epcr_inc_details_by_inc_id($inc_args);
        $data['er_inc_details'] = $this->medadv_model->get_epcr_by_inc_id($inc_args);

        $data['driver_data'] = $this->pcr_model->get_driver(array('inc_ref_id' => trim($data['inc_ref_no'])));
        $data['tdo_id'] = $this->call_model->get_tdo_inc($data['inc_ref_no']);


        $ver_args = array('qa_user_group' => $ref_id,
            'qa_ques_type' => 'ver_mat');
        $data['ero_ver_mat'] = $this->quality_model->get_quality_question($ver_args);

        $ver_args = array('qa_user_group' => $ref_id,
            'qa_ques_type' => 'open_greet');
        $data['ero_open_greet'] = $this->quality_model->get_quality_question($ver_args);

        $ver_args = array('qa_user_group' => $ref_id,
            'qa_ques_type' => 'comp_systm');
        $data['ero_comp_systm'] = $this->quality_model->get_quality_question($ver_args);

        $ver_args = array('qa_user_group' => $ref_id,
            'qa_ques_type' => 'notification');
        $data['ero_notification'] = $this->quality_model->get_quality_question($ver_args);

        $hold_procedure_args = array('qa_user_group' => $ref_id,
            'qa_ques_type' => 'hold_procedure');
        $data['ero_hold_procedure'] = $this->quality_model->get_quality_question($hold_procedure_args);

        $commu_skill_args = array('qa_user_group' => $ref_id,
            'qa_ques_type' => 'commu_skill');
        $data['ero_commu_skill'] = $this->quality_model->get_quality_question($commu_skill_args);

        $commu_closing_greet = array('qa_user_group' => $ref_id,
            'qa_ques_type' => 'closing_greet');
        $data['ero_closing_greet'] = $this->quality_model->get_quality_question($commu_closing_greet);

        $fetal_indicator = array('qa_user_group' => $ref_id,
            'qa_ques_type' => 'fetal_indicator');
        $data['ero_fetal_indicator'] = $this->quality_model->get_quality_question($fetal_indicator);

        $data['ero_id'] = $usr_id;
        $data['open_audit'] = $this->post['user_quality'];
        $data['current_user_group']= $this->clg->clg_group;
        //var_dump($data['open_audit']); die;
        $this->output->add_to_popup($this->load->view('frontend/quality/open_audit_view', $data, TRUE), '1200', '800');

        //$this->output->add_to_position($this->load->view('frontend/quality/open_audit_view', $data, TRUE), 'content', TRUE);
    }

    function save_ero_notice() {
        //var_dump($this->input->post('ref_id'));die;
        $quality_user_name = $this->clg->clg_first_name . ' ' . $this->clg->clg_last_name;

        $audit = $this->input->post('audit');
        if($audit['ero_invite_time'] != ''){
            
            $date_time = date('Y-m-d H:i:s', strtotime($audit['ero_invite_time']));
        
        }else{
            $date_time = date('Y-m-d H:i:s');
        }
        //var_dump($this->input->post('qa_ad_inc_ref_id'));die;
        $data = array(
            'er_notice' => "Requesting you to meet $quality_user_name for discussion on the quality review on $date_time",
            'er_added_date' => date('Y-m-d H:i:s'),
            'er_notice_date' => date('Y-m-d H:i:s'),
            'er_is_deleted' => '0',
            'er_added_by' => $this->clg->clg_ref_id,
            'er_usr' => $this->input->post('ref_id'),
            'inc_ref_id' => $this->input->post('inc_ref_id')
          
        );



        $nr_id = $this->quality_model->insert_ero_notice($data);

    }

    function get_notice_ero_view() {

        $clg_group = array('nr_user_group' => $this->clg->clg_group,
            'id' => $this->post['id']
        );

        $data['call_res'] = $this->quality_model->get_ero_notice($clg_group);
//var_dump( $data['call_res'] ); die;

        $args = array(
            'id' => $this->post['id'],
            'er_is_closed' => '1'
        );


        $data['result'] = $this->quality_model->update_notice_ero($args);

        $this->output->status = 1;

        $this->output->message = '';

        $this->output->add_to_position($this->load->view('frontend/clg/ero_notice_view', $data, TRUE), $output_position, TRUE);

        $this->output->add_to_position($this->load->view('frontend/clg/ero_notice_count_view', $data, TRUE), 'header_ero_notice', TRUE);
    }

    function save_audit() {

        $audit = $this->post['audit'];
        //echo "<pre>";
//var_dump($audit); die;

        $audit_data = array(
            'inc_ref_id' => $this->post['incident_id'],
            'ver_mat' => json_encode($audit['ver_mat']),
            'ver_mat_chk' => json_encode($audit['ver_mat_chk']),
            'ver_matrix_marks' => $audit['ver_matrix_marks'],
            'open_greet' => json_encode($audit['open_greet']),
            'open_greet_chk' => json_encode($audit['open_greet_chk']),
            'open_greet_marks' => $audit['open_greet_marks'],
            'comp_systm' => json_encode($audit['comp_systm']),
            'comp_systm_chk' => json_encode($audit['comp_systm_chk']),
            'commu_skill_chk' => json_encode($audit['commu_skill_chk']),
            'comp_systm_marks' => $audit['comp_systm_marks'],
            'notification' => json_encode($audit['notification']),
            'notification_chk' => json_encode($audit['notification_chk']),
            'notification_marks' => $audit['notification_marks'],
            'hold_procedure' => json_encode($audit['hold_procedure']),
            'hold_procedure_marks' => $audit['hold_procedure_marks'],
            'hold_procedure_chk' => json_encode($audit['hold_procedure_chk']),
            'commu_skill' => json_encode($audit['commu_skill']),
            'commu_skill_marks' => $audit['commu_skill_marks'],
            'closing_greet' => json_encode($audit['closing_greet']),
            'closing_greet_marks' => $audit['closing_greet_marks'],
            'fetal_indicator' => json_encode($audit['fetal_indicator']),
            'fetal_indicator_chk' => json_encode($audit['fetal_indicator_chk']),
            'closing_greet_chk' => json_encode($audit['closing_greet_chk']),
            'fetal_error_indicator' => $audit['fetal_error_indicator'],
            'call_observation' => $audit['call_observation'],
            'quality_score' => $audit['quality_score'],
            'performer_group' => $audit['performer_group'],
            'tna' => $audit['tna'],
            'audit_method' => $audit['audit_method'],
            'quality_remark' => $audit['quality_remark'],
            'ero_meeting_time' => $audit['ero_invite_time'],
            'feedback_remark' => $audit['feedback_remark'],
            //'feedback_status' => $audit['feedback_status'],
            //'feedback_added_date' => $audit['feedback_added_date'],
            //'remark' => $audit['remark'],
            'qa_ad_user_ref_id' => $this->post['qa_ad_user_ref_id'],
            'qa_ad_user_group' => $this->post['qa_ad_user_group'],
            'user_system_type' => $this->post['user_system_type'],
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            //'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'),
            'is_deleted' => '0',
            'other_fatal_error_inc' => $this->post['other_fatal_inc_error'],
        );



        $audit_data = $this->quality_model->insert_qa_audit($audit_data);



        if ($this->post['qa_ad_user_group'] == 'ERO') {


            $audit_args = array(
                'quality_audit_status' => '1',
            );

            $inc_args['inc_datetime'] = date('Y-m-d', strtotime($this->post['inc_datetime']));
            $inc_args['inc_added_by'] = $this->post['qa_ad_user_ref_id'];
            $data['ero_id'] = $this->post['qa_ad_user_ref_id'];

            $inc_update = $this->inc_model->update_incident_audit($inc_args, $audit_args);

            $data = array(
                'inc_ref_id' => $this->post['incident_id'],
                'er_added_date' => date('Y-m-d H:i:s'),
                'er_notice_date' => date('Y-m-d H:i:s'),
                'er_is_deleted' => '0',
                'er_added_by' => $this->clg->clg_ref_id,
                'er_usr' => $this->input->post('ref_id'),
                //'er_remark' => $audit['remark'],
                'quality_score' => $audit['quality_score'],
                'er_usr' => $this->post['ref_id'],
            );



            $nr_id = $this->quality_model->insert_ero_notice($data);
            $inc_args = array('inc_ref_id' => $this->post['incident_id'], 'inc_audit_status' => '1', 'quality_audit_status' => '0');
            $inc_update = $this->inc_model->update_incident($inc_args);
        } else if ($this->post['qa_ad_user_group'] == 'DCO') {

            $inc_args = array('inc_ref_id' => $this->post['incident_id']);
            $inc_update = $this->pcr_model->update_epcr_audit($inc_args);
        } else if ($this->post['qa_ad_user_group'] == 'ERCP') {

            $inc_args = array('adv_inc_ref_id' => $this->post['incident_id'], 'inc_audit_status' => '1');
            $inc_update = $this->medadv_model->update_incidence_advice($inc_args);
        } else if ($this->post['qa_ad_user_group'] == 'Grieviance') {

            $inc_args = array('gc_inc_ref_id' => $this->post['incident_id'], 'inc_audit_status' => '1');
            $inc_update = $this->grievance_model->grievance_update_call_data($inc_args);
        } else if ($this->post['qa_ad_user_group'] == 'FDA') {

            $inc_args = array('fc_inc_ref_id' => $this->post['incident_id'], 'inc_audit_status' => '1');
            $inc_update = $this->fire_model->update_fire($inc_args);
        } else if ($this->post['qa_ad_user_group'] == 'PDA') {

            $inc_args = array('pc_inc_ref_id' => $this->post['incident_id'], 'police_audit_status' => '1');
            $inc_update = $this->police_model->update_police($inc_args);
        }



        $function = "view_" . $this->post['qa_ad_user_group'] . "_incidence_quality()";

        if ($audit_data) {
            $this->output->status = 1;
            $this->output->message = "<div class='success'>Audit save Successfully!</div>";
            $this->output->closepopup = 'yes';
            $this->$function;
        }
    }

    function update_audit() {

        $audit = $this->post['audit'];
        //var_dump($audit);die;

        $audit_data = array(
            //'qa_ad_id'=> $this->post['qa_ad_id'],
            'inc_ref_id' => $this->post['incident_id'],


            // 'inc_ref_id' => $this->post['incident_id'],
            // 'fetal_error_indicator' => $audit['fetal_error_indicator'],
            // 'audit_method' => $audit['audit_method'],
            // 'ero_meeting_time' => $audit['ero_invite_time'],
            'feedback_remark' => $audit['feedback_remark'],
            'feedback_status' => $audit['feedback_status'],
            'feedback_added_date' => $audit['feedback_added_date'],
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'));
            // var_dump($audit_data);die();

        $audit_data = $this->quality_model->update_qa_audit($audit_data);
        $function = "view_" . $this->post['qa_ad_user_group'] . "_incidence_quality()";

        if ($audit_data) {
            $this->output->status = 1;
            $this->output->message = "<div class='success'>Updated Successfully!</div>";
            $this->output->closepopup = 'yes';
            $this->$function;
        }
    }
    // function update_audit_qm() {

    //     $audit = $this->post['audit'];
    //     //var_dump($audit);die;

    //     $audit_data = array(
    //         //'qa_ad_id'=> $this->post['qa_ad_id'],
    //         'inc_ref_id' => $this->post['incident_id'],
    //         'ver_mat' => json_encode($audit['ver_mat']),
    //         'ver_mat_chk' => json_encode($audit['ver_mat_chk']),
    //         'ver_matrix_marks' => $audit['ver_matrix_marks'],
    //         'open_greet' => json_encode($audit['open_greet']),
    //         'open_greet_chk' => json_encode($audit['open_greet_chk']),
    //         'open_greet_marks' => $audit['open_greet_marks'],
    //         'comp_systm' => json_encode($audit['comp_systm']),
    //         'comp_systm_chk' => json_encode($audit['comp_systm_chk']),
    //         'commu_skill_chk' => json_encode($audit['commu_skill_chk']),
    //         'comp_systm_marks' => $audit['comp_systm_marks'],
    //         'notification' => json_encode($audit['notification']),
    //         'notification_chk' => json_encode($audit['notification_chk']),
    //         'notification_marks' => $audit['notification_marks'],
    //         'hold_procedure' => json_encode($audit['hold_procedure']),
    //         'hold_procedure_marks' => $audit['hold_procedure_marks'],
    //         'hold_procedure_chk' => json_encode($audit['hold_procedure_chk']),
    //         'commu_skill' => json_encode($audit['commu_skill']),
    //         'commu_skill_marks' => $audit['commu_skill_marks'],
    //         'closing_greet' => json_encode($audit['closing_greet']),
    //         'closing_greet_marks' => $audit['closing_greet_marks'],
    //         'fetal_indicator' => json_encode($audit['fetal_indicator']),
    //         'fetal_indicator_chk' => json_encode($audit['fetal_indicator_chk']),
    //         'closing_greet_chk' => json_encode($audit['closing_greet_chk']),
    //         'fetal_error_indicator' => $audit['fetal_error_indicator'],
    //         //'call_observation' => $audit['call_observation'],
    //         // 'quality_score' => $audit['quality_score'],
    //         'performer_group' => $audit['performer_group'],


    //         // 'inc_ref_id' => $this->post['incident_id'],
    //         'fetal_error_indicator' => $audit['fetal_error_indicator'],
    //         // 'audit_method' => $audit['audit_method'],
    //         // 'ero_meeting_time' => $audit['ero_invite_time'],
    //         'feedback_remark' => $audit['feedback_remark'],
    //         'feedback_status' => $audit['feedback_status'],
    //         'feedback_added_date' => $audit['feedback_added_date'],
    //         'modify_by' => $this->clg->clg_ref_id,
    //         'modify_date' => date('Y-m-d H:i:s'));
    //         // var_dump($audit_data);die();

    //     $audit_data = $this->quality_model->update_qa_audit($audit_data);
    //     $function = "view_" . $this->post['qa_ad_user_group'] . "_incidence_quality()";

    //     if ($audit_data) {
    //         $this->output->status = 1;
    //         $this->output->message = "<div class='success'>Updated Successfully!</div>";
    //         $this->output->closepopup = 'yes';
    //         $this->$function;
    //     }
    // }
    function cross_audit() {


        $this->output->add_to_position($this->load->view('frontend/quality/view_cross_audit', $data, TRUE), 'content', TRUE);
    }

    function cross_audit_inc_list() {

        $qa_name = $data['qa_name'] = $this->post['qa_name'];
        $from_date = $data['from_date'] = date('Y-m-d', strtotime($this->post['from_date']));
        $to_date = $data['to_date'] = date('Y-m-d', strtotime($this->post['to_date']));

        $ref_id = $data['qa_name'];
        if (!empty($ref_id)) {
            $this->session->set_userdata('quality_ref_id', $ref_id);
        } else {
            $ref_id = $this->session->userdata('quality_ref_id');
        }


        $data['ref_id'] = $data['qa_name'];

        $this->post = $this->input->post();
        $this->post['base_month'] = get_base_month();

        $data['user_type'] = $this->post['user_type'];

        if (!empty($data['user_type'])) {
            $this->session->set_userdata('quality_user_type', $data['user_type']);
        } else {
            $data['user_type'] = $this->session->userdata('quality_user_type');
        }



        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        //$this->pg_limit = 10;
        ///////////set page number////////////////////

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


        $args_dash = array(
            'operator_id' => $ref_id,
            'base_month' => $this->post['base_month']
        );

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        $inc_info = $this->quality_model->get_quality_audit_by_user($data, $offset, $limit);



        $inc_data = (object) array();

        $data['per_page'] = $limit;

        $data['inc_info'] = $inc_info;

        $data['get_count'] = TRUE;
        $total_cnt = $this->quality_model->get_quality_audit_by_user($data);


        $data['total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("quality_forms/cross_audit_inc_list"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
            'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc&qa_name=$qa_name&from_date=$from_date&to_date=$to_date"
            )
        );


        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);

        $this->output->add_to_position($this->load->view('frontend/quality/cross_audit_inc_list', $data, TRUE), 'list_table', TRUE);
    }

    function single_record_view() {


        $search_data = $this->input->post();
        $data['audit_id'] = $this->input->post('audit_id');

        $current_user = $this->clg->clg_ref_id;

        $cross_args = array('cr_audit_id' => $data['audit_id']);
        $data['audit_data'] = $this->quality_model->get_quality_cross_audit($cross_args);

        $audit_args = array('qa_ad_id' => $data['audit_id']);
        $data['quality_audit_data'] = $this->quality_model->get_quality_audit_by_user($audit_args);
        $ref_id = 'UG-' . $data['quality_audit_data'][0]->qa_ad_user_group;
        if($ref_id == ''){
        $qa_ad_user_ref_id = $this->colleagues_model->get_user_info($data['quality_audit_data'][0]->qa_ad_user_ref_id);
        $ref_id = $qa_ad_user_ref_id[0]->clg_group;
            if($ref_id == 'UG-ERO-102'){
                $ref_id = 'UG-ERO';
            } else if($ref_id == 'UG-DCO-102'){
                 $ref_id = 'UG-DCO';
            }
        }


        $args = array();
        $args = array('inc_ref_id' => trim($this->input->post('inc_ref_id')));
        $data['inc_ref_id'] = $this->input->post('inc_ref_id');


        $data['inc_call_type'] = $this->inc_model->get_inc_ref_id($args);
        $data['inc_ref_no'] = trim($this->input->post('inc_ref_id'));

        if (!empty($data['inc_call_type'])) {


            $data['inc_ref_no'] = trim($this->input->post('inc_ref_id'));

            if ($data['inc_call_type'][0]->inc_type != 'AD_SUP_REQ') {
                $data['inc_details'] = $this->inc_model->get_inc_details_ref_id($args);
            } else {
                $data['inc_details'] = $this->inc_model->get_inc_call_details_ref_id($args);
            }




            if ($data['inc_details'][0]->police_chief_complete != '') {
                $args_police = array('po_ct_id' => $data['inc_details'][0]->police_chief_complete);
                $police_comp = $this->call_model->get_police_chief_comp($args_police);
                $data['po_ct_name'] = $police_comp[0]->po_ct_name;
            }

            if ($data['inc_details'][0]->fire_chief_complete != '') {
                $args_fire = array('fi_ct_id' => $data['inc_details'][0]->fire_chief_complete);
                $fire_comp = $this->call_model->get_fire_chief_comp($args_fire);
                $data['fi_ct_name'] = $fire_comp[0]->fi_ct_name;
            }

            $args_remark = array('re_id' => $data['inc_details'][0]->inc_ero_standard_summary);
            $standard_remark = $this->call_model->get_ero_summary_remark($args_remark);

            $data['re_name'] = $standard_remark[0]->re_name;



            $args_pur = array('pcode' => $data['inc_details'][0]->cl_purpose);

            $call_pur = $this->inc_model->get_purpose_call($args_pur);
            $data['pname'] = $call_pur[0]->pname;



            $args_amb_type = array('inc_suggested_amb' => $data['inc_details'][0]->inc_suggested_amb);
            $amb_type = $this->inc_model->get_sugg_amb_type($args_amb_type);
            $data['ambt_name'] = $amb_type[0]->ambt_name;

            $args_st = array('st_code' => $data['inc_details'][0]->inc_state_id);
            $state = $this->inc_model->get_state_name($args_st);
            $data['state_name'] = $state[0]->st_name;

            $args_dst = array('st_code' => $data['inc_details'][0]->inc_state_id, 'dst_code' => $data['inc_details'][0]->inc_district_id);

            $district = $this->inc_model->get_district_name($args_dst);
            $data['district_name'] = $district[0]->dst_name;

            $args_th = array('thl_id' => $data['inc_details'][0]->inc_tahshil_id);
            $tahshil = $this->inc_model->get_tahshil($args_th);
            $data['tahshil_name'] = $tahshil[0]->thl_name;


            $args_ct = array('cty_id' => $data['inc_details'][0]->inc_city_id, 'dst_code' => $data['inc_details'][0]->inc_district_id);

            $city = $this->inc_model->get_city_name($args_ct);
            $data['city_name'] = $city[0]->cty_name;

//      var_dump($data['inc_details']);die();
            $data['cl_relation'] = $inc_data[0]->cl_relation;
            $cm_id = $data['inc_details'][0]->inc_complaint;
            $chief_comp = $this->inc_model->get_chief_comp_service($cm_id);
            $data['chief_complete_name'] = $chief_comp[0]->ct_type;
            $args_pt = array('get_count' => TRUE,
                'inc_ref_id' => $data['inc_ref_no']);

            $data['ptn_count'] = $this->pcr_model->get_pat_by_inc($args_pt);



            $inc_args = array(
                'inc_ref_id' => $data['inc_ref_no'],
                'inc_type' => $data['inc_call_type'][0]->inc_type
            );



            $data['questions'] = $this->inc_model->get_inc_summary($inc_args);

            $ques_args = array(
                'inc_ref_id' => $data['inc_ref_no'],
                'inc_type' => 'FEED_' . $data['inc_call_type'][0]->inc_type
            );



            $data['feed_questions'] = $this->inc_model->get_inc_summary($ques_args);

            $amb_args = array('inc_ref_id' => $data['inc_ref_no']);

            $data['enquiry_data'] = $this->enquiry_model->get_enquiry($amb_args);

            $myArray = explode(',', $data['enquiry_data'][0]->enq_que);


            $data['enq_que'] = array();
            $q = 0;

            if (is_array($myArray)) {
                foreach ($myArray as $que) {

                    $enq_que = $this->common_model->get_question(array('que_id' => $que));

                    $serialize_que = $enq_que[0]->que_question;

                    $data['enq_que'][$q]['que'] = get_lang_data($serialize_que, $data['enquiry_data'][0]->enq_lang);

                    $ans = $this->common_model->get_answer(array('ans_que_id' => $que));

                    $serialize_ans = $ans[0]->ans_answer;

                    $data['enq_que'][$q]['ans'] = get_lang_data($serialize_ans, $data['enquiry_data'][0]->enq_lang);

                    $data['enq_que'][$q]['que_id'] = $que;

                    $q++;
                }
            }


            $data['amb_data'] = $this->inc_model->get_inc_details($amb_args);

            $data['sms_data'] = $this->inc_model->get_inc_sms_response($data['inc_ref_no']);

            $ptn_args = array('inc_ref_id' => $data['inc_ref_no'],
                'ptn_id' => $data['inc_details'][0]->ptn_id,
            );

            $data['ptn_details'] = $this->Pet_model->get_ptinc_info_quality($ptn_args);



            $inc_args = array(
                'inc_ref_id' => trim($data['inc_ref_no'])
            );


            $data['facility_details'] = $this->inc_model->get_hospital_facility(array('inc_ref_id' => trim($data['inc_ref_no'])));

            $data['feedback_details'] = $this->feedback_model->get_feedback_details(array('inc_ref_id' => trim($data['inc_ref_no'])));



            $data['epcr_inc_details'] = $this->pcr_model->get_epcr_inc_details_by_inc_id($inc_args);
            $data['er_inc_details'] = $this->medadv_model->get_epcr_by_inc_id($inc_args);

            $data['driver_data'] = $this->pcr_model->get_driver(array('inc_ref_id' => trim($data['inc_ref_no'])));
            $data['tdo_id'] = $this->call_model->get_tdo_inc($data['inc_ref_no']);


            $ver_args = array('qa_user_group' => $ref_id,
                'qa_ques_type' => 'ver_mat');

            $data['ero_ver_mat'] = $this->quality_model->get_quality_question($ver_args);


            $ver_args = array('qa_user_group' => $ref_id,
                'qa_ques_type' => 'open_greet');
            $data['ero_open_greet'] = $this->quality_model->get_quality_question($ver_args);

            $ver_args = array('qa_user_group' => $ref_id,
                'qa_ques_type' => 'comp_systm');
            $data['ero_comp_systm'] = $this->quality_model->get_quality_question($ver_args);

            $ver_args = array('qa_user_group' => $ref_id,
                'qa_ques_type' => 'notification');
            $data['ero_notification'] = $this->quality_model->get_quality_question($ver_args);

            $hold_procedure_args = array('qa_user_group' => $ref_id,
                'qa_ques_type' => 'hold_procedure');
            $data['ero_hold_procedure'] = $this->quality_model->get_quality_question($hold_procedure_args);

            $commu_skill_args = array('qa_user_group' => $ref_id,
                'qa_ques_type' => 'commu_skill');
            $data['ero_commu_skill'] = $this->quality_model->get_quality_question($commu_skill_args);

            $commu_closing_greet = array('qa_user_group' => $ref_id,
                'qa_ques_type' => 'closing_greet');
            $data['ero_closing_greet'] = $this->quality_model->get_quality_question($commu_closing_greet);

            $fetal_indicator = array('qa_user_group' => $ref_id,
                'qa_ques_type' => 'fetal_indicator');
            $data['ero_fetal_indicator'] = $this->quality_model->get_quality_question($fetal_indicator);
        }

        $this->output->add_to_popup($this->load->view('frontend/quality/single_record_view', $data, TRUE), '1500', '1000');
    }

    function save_quality_remark() {

        $cross = $this->post['cross'];

        $main_data = array(
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'));
        $args = array_merge($cross, $main_data);


        $audit_data = $this->quality_model->insert_cross_audit($args);

        if ($audit_data) {

            $this->output->status = 1;
            $this->output->message = "<div class='success'>Inserted Successfully!</div>";
            $this->output->closepopup = 'yes';
            $this->cross_audit_inc_list();
        }
    }

    function update_quality_remark() {

        $cross = $this->post['cross'];

        $main_data = array(
            //'added_by'=> $this->clg->clg_ref_id,
            //'added_date'=> date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'));

        $args = array_merge($cross, $main_data);


        $audit_data = $this->quality_model->update_cross_audit($args);

        if ($audit_data) {

            $this->output->status = 1;
            $this->output->message = "<div class='success'>Updated Successfully!</div>";
            $this->output->closepopup = 'yes';
            $this->cross_audit_inc_list();
        }
    }

    function quality_report() {
        
        $report_type = $this->input->post('report_type');
        $data['form_type']=$report_type;
        

        if ($report_type == 'quality_report') {
            
            $data['submit_function'] = "quality_filter_report";
            $data['title'] = "Quality Report";
            $this->output->add_to_position($this->load->view('frontend/quality/quality_report_view', $data, TRUE), $output_position, TRUE);
        
        }else if ($report_type == 'quality_master_report') {
            $data['submit_function'] = "quality_filter_report";
            $data['title'] = "Quality Master Report";
            $this->output->add_to_position($this->load->view('frontend/quality/quality_report_view', $data, TRUE), $output_position, TRUE);
        }
    }
    function ambulance_maintenance_report()
    {
        $report_type = $this->input->post('report_type');
        $data['form_type']=$report_type;
        $data['submit_function'] = "ambulance_maintenance_report";
        $data['title'] = "Ambulance Maintenance Report";
        $this->output->add_to_position($this->load->view('frontend/reports/ambulance_maintenance_report_view', $data, TRUE), $output_position, TRUE);
        
    }
    function shift_roster_report()
    {
        $report_type = $this->input->post('report_type');
        $data['form_type']=$report_type;
        $data['submit_function'] = "shift_roster_report";
        $data['title'] = "Shift Roster Report";
       $this->output->add_to_position($this->load->view('frontend/reports/shift_roster_report_view', $data, TRUE), $output_position, TRUE);
        
    }

    function shiftmanager_filter_report() {
        $data = $this->input->post();
        //var_dump($data); die;
        //$data['clg_ref_id'] = $this->input->post();
        $data['submit_function'] = "tl_filter_report";
        $this->output->add_to_position($this->load->view('frontend/quality/shiftmanger_filter_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
    }

    function tl_filter_report() {
        
        $report_type = $this->input->post('shiftmanager');
        //var_dump($report_type);die;

        $data['submit_function'] = "quality_filter_report";
        $this->output->add_to_position($this->load->view('frontend/quality/tl_filter_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
    }

    function tl_by_shiftmanager() {
        $data = $this->input->post();
        //$clg_ref_id = $this->input->post('clg_ref_id');
        $data['tl_data'] = $this->colleagues_model->get_all_tlname($data);
        $this->output->add_to_position($this->load->view('frontend/quality/quality_tl_view', $data, TRUE), 'tl_outer', TRUE);
    }
       function get_ero_data() {
        $tl_id = $this->input->post('tl_id');

        $data['tl_data'] = $this->colleagues_model->get_all_eros($tl_id);
        // var_dump($data);die;
        $this->output->add_to_position($this->load->view('frontend/quality/quality_ero_data_view', $data, TRUE), 'ero_list_outer', TRUE);
    }

    function get_ero_data_qality() {
        //var_dump($this->input->post());die;
        $data = $this->input->post();

        $data['tl_data'] = $this->colleagues_model->get_all_eros(array('team_type' => $data['team_type']));
        //var_dump($data['tl_data']); die;
        $this->output->add_to_position($this->load->view('frontend/quality/quality_ero_data_view_qality', $data, TRUE), 'ero_list_outer_qality', TRUE);
    }

    function get_system_report_data_qality() {

        $data = $this->input->post();
        //var_dump($data); die;
        $data['tl_data'] = $this->colleagues_model->get_all_eros(array('system_type' => $data['system_type']));

       // $data['tl_data'] = $this->colleagues_model->get_all_eros($data);
        //var_dump($data['tl_data']); die;
        $this->output->add_to_position($this->load->view('frontend/quality/quality_filter_system_type', $data, TRUE), 'system_type_quality', TRUE);
    }
    function get_ero_report_data_qality() {

        $data = $this->input->post();
        //var_dump($data); die;

        $data['tl_data'] = $this->colleagues_model->get_all_eros($data);
        //var_dump($data['tl_data']); die;
        $this->output->add_to_position($this->load->view('frontend/quality/quality_ero_data_view_qality', $data, TRUE), 'ero_list_outer_qality', TRUE);
    }

    function quality_filter_report() {
        //echo "hi";
        $report_type = $this->input->post('form_type');

        //$args['term']="";
        if($report_type == 'quality_report'){
            $data['submit_function'] = "view_quality_report";
        }else if($report_type == 'quality_master_report'){
            $data['submit_function'] = "view_quality_master_report";
        }
        
        $data['sm'] = $this->colleagues_model->get_all_shiftmanager();
        //var_dump($data['sm']);
        $data['purpose_calls'] = $this->call_model->get_all_child_purpose_of_calls();

        $this->output->add_to_position($this->load->view('frontend/quality/quality_filter_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        $this->output->add_to_position('', 'Sub_date_report_block_fields', TRUE);
        $this->output->add_to_position('', 'list_table', TRUE);
    }

    function load_quality_sub_date_report_form() {
        // echo "hi";
        $report_type = $this->input->post('report_type');

        if ($report_type == 'ERO') {
            $data['submit_function'] = "load_incident_sub_date_report_form";
            $this->output->add_to_position($this->load->view('frontend/quality/incident_sub_report_view', $data, TRUE), 'Sub_report_block_fields22', TRUE);
            $this->output->add_to_position('', 'Sub_date_report_block_fields22', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
        if ($report_type == 'DCO') {
            $data['submit_function'] = "load_month_date_report_form";
            $this->output->add_to_position($this->load->view('frontend/quality/incident_sub_other_report_view', $data, TRUE), 'Sub_report_block_fields22', TRUE);
            $this->output->add_to_position('', 'Sub_date_report_block_fields22', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
        // $report_type = $this->input->post('report_type');
        // $data['report_type'] = $report_type;
        // $data['submit_function'] = "view_quality_report";
        // $this->output->add_to_position($this->load->view('frontend/quality/report_date_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
    }

    function load_incident_sub_date_report_form() {
        //echo "hihi";
        $report_type = $this->input->post('type');
        if ($report_type == '1') {
            $data['submit_function'] = "view_quality_report";
            $this->output->add_to_position($this->load->view('frontend/quality/export_inc_reports_view', $data, TRUE), 'Sub_date_report_block_fields22', TRUE);
        }
        if ($report_type == '2') {
            $data['submit_function'] = "view_quality_report";
            $this->output->add_to_position($this->load->view('frontend/quality/export_amb_reports_view', $data, TRUE), 'Sub_date_report_block_fields22', TRUE);
        }
    }

    function load_month_date_report_form() {
        $report_type = $this->input->post('type');
        if ($report_type == '1') {
            $data['submit_function'] = "view_month_report";
            $this->output->add_to_position($this->load->view('frontend/quality/export_inc_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        if ($report_type == '2') {
            $data['submit_function'] = "view_month_report";
            $this->output->add_to_position($this->load->view('frontend/quality/export_amb_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
    }

    function view_quality_report() {

        $post_reports = $this->input->post();
        //var_dump( $post_reports);die;
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        if ($post_reports['to_date'] != '') {

            
            $post_reports['from_date'] = date('Y-m-d', strtotime($post_reports['from_date']));
            $post_reports['to_date'] = date('Y-m-d', strtotime($post_reports['to_date']));
            $post_reports['base_month'] = $this->post['base_month'];
            $post_reports['system_type'] = $this->post['system_type'];
            
         }if($post_reports['month_date'] != ''){ 
            $post_reports['from_date'] = date('Y-m-d', strtotime($post_reports['month_date']));
            $post_reports['to_date'] = date('Y-m-t', strtotime($post_reports['month_date']));
            $post_reports['base_month'] = $this->post['base_month'];
            $post_reports['system_type'] = $this->post['system_type'];
         } else {

            
                $post_reports['from_date'] = $post_reports['from_date'];
                $post_reports['to_date'] = $post_reports['to_date'];
                $post_reports['base_month'] = $this->post['base_month'];
                $post_reports['system_type'] = $this->post['system_type'];

        }
        
        $post_reports['system_type'] = $this->post['system_type'];
        
        $user_group_name = $data['report_type'] . ' Name';
        $report_data = $this->quality_model->get_audit_report($post_reports);
        $header = array('Sr.No', 'Audit Date', $user_group_name,'Performer Group', 'Audit Count', 'Fatal Indicator', 'Quality Score', 'Quality Remark',);


        $inc_file_name = strtotime($post_reports['from_date']);
        $filename = "quality_" . $inc_file_name . ".csv";



        if ($post_reports['reports'] == 'view') {

            $data['header'] = $header;
            $data['inc_data'] = $report_data;
            $data['report_args'] = $post_reports;
            
        //var_dump($data['report_args']);die;
            $data['submit_function'] = 'view_quality_report';
            $this->output->add_to_position($this->load->view('frontend/quality/quality_report_list_view', $data, TRUE), 'list_table', TRUE);
        } else {
            
            $filename = "quality_report.csv";
            $fp = fopen('php://output', 'w');


            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);
 
            // $count = 1;
            $data = array();
            foreach ($report_data as $key => $row) {
                $added_date = $row->added_date;
                //var_dump($report_data);die;
                $u_name = get_clg_data_by_ref_id($row->qa_ad_user_ref_id);
                $user_name = $u_name[0]->clg_first_name . ' ' . $u_name[0]->clg_mid_name . ' ' . $u_name[0]->clg_last_name;
                if($row->fetal_error_indicator){ $fatal=$row->fetal_error_indicator;}else{$fatal="NA";}
                if($added_date != NULL){
                    $add_date = date('Y-m-d', strtotime($added_date));
                     $add_time = date('H:i:s', strtotime($added_date));
                     $final_date= $add_date.'-'.$add_time;
                                 }
                                 else{
                                     $final_date= '';
                                 }

                $data = array('sr_no' => $key + 1,
                    'audit_date'=> $final_date,
                    'user_name' => ucwords($user_name),
                    'performer_group' => $row->performer_group,
                    'audit_count' => $row->qa_count,
                    'fatal_indicator' => $fatal,
                    'quality_score' => $row->quality_score,
                    'quality_remark' => $row->quality_remark
                    // 
                    // 'audit_count' => $row->qa_count,
                    // 'audit_count' => $row->qa_count,
                );
              
                fputcsv($fp, $data); //$count++;
            }

            fclose($fp);
            exit;
        }
    }

    function view_month_report() {
        // echo "hi";
        $post_reports = $this->input->post();

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;
        $data['report_type'] = $this->input->post('report_type');

        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'report_type' => $data['report_type'],
                'base_month' => $this->post['base_month']);
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'report_type' => $data['report_type'],
                'base_month' => $this->post['base_month']);
        }


        $user_group_name = $data['report_type'] . ' Name';
        $report_data = $this->quality_model->get_audit_report($report_args);

        $header = array('Sr.No', $user_group_name, 'Audit count');


        $inc_file_name = strtotime($post_reports['from_date']);
        $filename = "quality_" . $inc_file_name . ".csv";



        if ($post_reports['reports'] == 'view') {

            $data['header'] = $header;
            $data['inc_data'] = $report_data;
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'view_month_report';
            $this->output->add_to_position($this->load->view('frontend/quality/quality_report_list_view', $data, TRUE), 'list_table', TRUE);
        } else {

            $filename = "quality_report.csv";
            $fp = fopen('php://output', 'w');


            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            //$count = 1;
            $data = array();
            foreach ($report_data as $key => $row) {

                $u_name = get_clg_data_by_ref_id($row->qa_ad_user_ref_id);
                $user_name = $u_name[0]->clg_first_name . ' ' . $u_name[0]->clg_mid_name . ' ' . $u_name[0]->clg_last_name;

                $data = array('sr_no' => $key + 1,
                    'user_name' => $user_name,
                    'audit_count' => $row->qa_count
                );
                fputcsv($fp, $data); //$count++;
            }

            fclose($fp);
            exit;
        }
    }
    
    function view_quality_master_report(){

        $post_reports = $this->input->post();

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        if ($post_reports['to_date'] != '') {

            
            $post_reports['from_date'] = date('Y-m-d', strtotime($post_reports['from_date']));
            $post_reports['to_date'] = date('Y-m-d', strtotime($post_reports['to_date']));
            $post_reports['base_month'] = $this->post['base_month'];
            
        }if($post_reports['month_date'] != ''){ 
             
            $post_reports['from_date'] = date('Y-m-d', strtotime($post_reports['month_date']));
            $post_reports['to_date'] = date('Y-m-t', strtotime($post_reports['month_date']));
            $post_reports['base_month'] = $this->post['base_month'];
            $post_reports['system_type'] = $this->post['system_type'];
            
        }else{
                $post_reports['from_date'] = $post_reports['from_date'];
                $post_reports['to_date'] = $post_reports['to_date'];
                $post_reports['base_month'] = $this->post['base_month'];
        }
        
        if ($post_reports['system_type'] != '') {
            $post_reports['system_type'];
            if(strstr($post_reports['system_type'],"102")){
                $strs="ERO-102";}
                else{
                    $strs="ERO"; 
                }
        }

        $post_reports['system_type'] = $strs;
        
        $user_group_name = $data['report_type'] . ' Name';
        $report_data = $this->quality_model->get_quality_master_report($post_reports);


        $header = array('Sr.No','Month', 'Audit Date', 'Date','Week', 'ERO Name', 'TL Name', 'SM Name', 'QA Name','Incident ID','Purpose of Call','Caller Number','Call Type','Chief Complain','Opening Greeting','Verification Matrix','Complete Call & System Flow','Notifications','Hold Procedure','Communication Skills','Closing Greeting','Fatal Indicators','Score','Performer Group','Audit Method','QA Call Observations','TNA','Date of Feedback','Feedback Status','Quality Remarks','Modify By','Feedback Remark','Feedback Status','Feedback Date');



        $inc_file_name = strtotime($post_reports['from_date']);
        $filename = "quality_" . $inc_file_name . ".csv";



        if ($post_reports['reports'] == 'view') {

            $data['header'] = $header;
            $data['inc_data'] = $report_data;
            $data['report_args'] = $post_reports;
            $data['submit_function'] = 'view_quality_report';
            $this->output->add_to_position($this->load->view('frontend/quality/quality_master_report_list_view', $data, TRUE), 'list_table', TRUE);
        } else {

            $filename = "quality_report.csv";
            $fp = fopen('php://output', 'w');


            header('Content-type: application/csv; charset=UTF-8');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            // $count = 1;
            $data = array();
            foreach ($report_data as $key => $inc) {
                
                $week = weekOfMonth(date('Y-m-d', strtotime($inc->added_date)));

                $u_name = get_clg_data_by_ref_id($inc->qa_ad_user_ref_id); 
                $ero_name = ucwords($u_name[0]->clg_first_name.' '.$u_name[0]->clg_mid_name.' '.$u_name[0]->clg_last_name); 

                $tl_name = get_clg_data_by_ref_id($u_name[0]->clg_senior);
                $tl_name_full = ucwords($tl_name[0]->clg_first_name.' '.$tl_name[0]->clg_mid_name.' '.$tl_name[0]->clg_last_name);

                $sm_name = get_clg_data_by_ref_id($tl_name[0]->clg_senior);
                $sm_name_full = ucwords($sm_name[0]->clg_first_name.' '.$sm_name[0]->clg_mid_name.' '.$sm_name[0]->clg_last_name);

                $qa_name = get_clg_data_by_ref_id($inc->added_by); 
                $qa_name_full =  ucwords($qa_name[0]->clg_first_name.' '.$qa_name[0]->clg_mid_name.' '.$qa_name[0]->clg_last_name);

                if($inc->inc_complaint != '' || $inc->inc_complaint != 0){
                    $inc_complaint =  get_cheif_complaint( $inc->inc_complaint);
                }else if($inc->inc_mci_nature != '' || $inc->inc_mci_nature != 0){
                    $inc_complaint = get_mci_nature_service( $inc->inc_mci_nature);
                }

                $open_greet = json_decode($inc->open_greet);          
                if($open_greet->open_greet == 'Y'){  $open_greet_name =  "YES"; }else{ $open_greet_name = "NO";}

                $ver_mat = json_decode($inc->ver_mat);
                if($ver_mat->ver_mat == 'Y'){ $ver_mat_name = "YES";}else{ $ver_mat_name = "NO";}

                $comp_systm = json_decode($inc->comp_systm);
                if($comp_systm->comp_systm == 'Y'){ $comp_systm_name = "YES"; }else{ $comp_systm_name = "NO";}

                $notification = json_decode($inc->notification);
                if($notification->notification == 'Y'){ $notification_name = "YES";}else{ $notification_name = "NO";}

                $hold_procedure = json_decode($inc->hold_procedure);
                if($hold_procedure->hold_procedure == 'Y'){ $hold_procedure_name = "YES";}else{ $hold_procedure_name = "NO";}

                $commu_skill = json_decode($inc->commu_skill);
                if($commu_skill->commu_skill == 'Y'){ $commu_skill_name =  "YES"; }else{ $commu_skill_name = "NO"; }

                $closing_greet = json_decode($inc->closing_greet);
                if($closing_greet->closing_greet == 'Y'){ $closing_greet_name = "YES";}else{ $closing_greet_name = "NO";}

                $fetal_indicator = json_decode($inc->fetal_indicator);
                if($fetal_indicator->fetal_indicator == 'Y'){ $fetal_indicator_name = "YES";}else{ $fetal_indicator_name = "NO";}

                if($week == '1'){
                    $weeks = "1";
                }else if($week == '2'){
                    $weeks = "2";
                }else if($week == '3'){
                    $weeks = "3";
                }else if($week == '4'){
                    $weeks = "4";
                }else if($week == '5'){
                    $weeks = "5";
                }
                if($inc->fetal_error_indicator){
                    $fetal= $inc->fetal_error_indicator;
                }else{
                    $fetal= "NA";
                    
                }
                if($inc->feedback_remark != NULL){
                    $feedback_status= "Complete";}
                    else{
                        $feedback_status="Pending"; }
                        if($inc->added_date != NULL){
           $added_date = date('Y-m-d', strtotime($inc->added_date));
            $added_time = date('H:i:s', strtotime($inc->added_date));
            $final_date= $added_date.'-'.$added_time;
                        }
                        else{
                            $final_date= '';
                        }
                        if($inc->feedback_added_date != NULL){
            $feedback_added_date = date('Y-m-d', strtotime($inc->feedback_added_date));
            $feedback_added_time = date('H:i:s', strtotime($inc->feedback_added_date));
            $feed_final_date= $feedback_added_date.'-'.$feedback_added_time;
                        }
                        else{
                            $feed_final_date='';
                        }
                $inc_data = array(
                'sr_no' => $key + 1,   
                'month' => date('F', strtotime($inc->added_date)),
                'added_date' =>  $final_date,
                'added_date_date' => date('Y-m-d', strtotime($inc->inc_datetime)),
                'added_week' => 'Week '.$weeks,
                'ero_name' => $ero_name,
                'tl_name_full' => $tl_name_full,
                'sm_name_full' => $sm_name_full,
                'qa_name_full' => $qa_name_full,
                //'shift' => '',
                'inc_ref_id' => $inc->inc_ref_id,
                'cl_purpose' => get_parent_purpose_of_call( $inc->inc_type),
                'clr_mobile'=>$inc->clr_mobile,
                'inc_type'=> ucwords(get_purpose_of_call( $inc->inc_type)),
                'inc_complaint' => $inc_complaint,
                'open_greet_name'=> $inc->open_greet_marks,
                'ver_mat_name'=> $inc->ver_matrix_marks,
                'comp_systm_name'=> $inc->comp_systm_marks,
                'notification_name'=> $inc->notification_marks,
                'hold_procedure_name'=> $inc->hold_procedure_marks,
                'commu_skill_name'=> $inc->commu_skill_marks,
                'closing_greet_name'=> $inc->closing_greet_marks,
                'fetal_indicator_name'=> $fetal,
                'quality_score' => $inc->quality_score."%",
                'performer_group' => $inc->performer_group,
                'audit_method' =>ucwords($inc->audit_method),
                'call_observation' => $inc->call_observation,
                'tna' => ucwords($inc->tna),
                'feedback_added_date' => $feed_final_date,
                'feedback_remark' => $feedback_status,
                'quality_remark' => $inc->quality_remark,
                'modify_by' => $inc->modify_by,
                'feedback_remark1' => $inc->feedback_remark,
                'feedback_status' => $inc->feedback_status,
                'feedback_date' => $inc->feedback_added_date);
                
                fputcsv($fp, $inc_data); //$count++;
            }

            fclose($fp);
            exit;
        }
        //var_dump($post_reports);die;
        if($post_reports['flt'] == 'reset'){
            $data=array();
            $data['submit_function'] = "quality_filter_report";
            $data['title'] = "Quality Master Report";
            
            $this->output->add_to_position($this->load->view('frontend/quality/quality_report_view', $data, TRUE), 'popup_div', TRUE);
           // $data['submit_function'] = "view_quality_master_report";
            //$data['sm'] = $this->colleagues_model->get_all_shiftmanager();
            //$data['purpose_calls'] = $this->call_model->get_all_child_purpose_of_calls();

            //$this->output->add_to_position($this->load->view('frontend/quality/quality_filter_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_date_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
    }

    function view_feedback_incidence_quality() {

        $ref_id = $this->post['ref_id'];
        if (!empty($ref_id)) {
            $this->session->set_userdata('quality_ref_id', $ref_id);
        } else {
            $ref_id = $this->session->userdata('quality_ref_id');
        }


        $data['ref_id'] = $ref_id;
        $this->post = $this->input->post();
        $this->post['base_month'] = get_base_month();

        $data['user_type'] = $this->post['user_type'];

        if (!empty($data['user_type'])) {
            $this->session->set_userdata('quality_user_type', $data['user_type']);
        } else {
            $data['user_type'] = $this->session->userdata('quality_user_type');
        }



        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $this->pg_limit = 10;
        ///////////set page number////////////////////

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


        $args_dash = array(
            'operator_id' => $ref_id,
            'base_month' => $this->post['base_month']
        );

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        $inc_info = $this->feedback_model->get_feedback_details_by_user($args_dash, $offset, $limit);

        $inc_data = (object) array();

        $data['per_page'] = $limit;
        $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->feedback_model->get_feedback_details_by_user($args_dash);

        $data['inc_total_count'] = $total_cnt;
        $data['total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("quality_forms/view_feedback_incidence_quality"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content"
            )
        );


        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);

        $this->output->add_to_position($this->load->view('frontend/quality/view_feedback_incidence_quality', $data, TRUE), 'content', TRUE);
    }

    function other_fatal_indicator() {

        $this->output->add_to_position($this->load->view('frontend/quality/other_fatal_indicator_view', $data, TRUE), 'other_fatal_indicator', TRUE);
    }

    function quality_score(){
//var_dump($this->input->post());die;
         $this->post = $this->input->post();
         $data =array();
        //if($this->clg->clg_group == 'UG-EROSupervisor'){ 
        // $data['rg_no'] = ($this->post['rg_no']) ? $this->post['rg_no'] : $this->fdata['rg_no'];
        // $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
         
         
        // ///////////set page number////////////////////
        // $page_no = 1;
        // if ($this->uri->segment(3)) {
        //     $page_no = $this->uri->segment(3);
        // } else if ($this->fdata['page_no'] && !$this->post['flt']) {
        //     $page_no = $this->fdata['page_no'];
        // }
        // //////////////////////////limit & offset//////

        // $data['get_count'] = TRUE;

        // $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        // $page_no = get_pgno($data['total_count'], $limit, $page_no);

        // $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        
        $data['pg_rec'] = $pg_rec = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        //$this->pg_limit = 10;
        ///////////set page number////////////////////

        $page_no = 1;


        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        /////////////////////////////////////////////////////////

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        $data['clg_senior'] = $this->clg->clg_ref_id;
        

        if($this->post['user_id'] != ''){
            
            $child_ero = $this->post['user_id'];
            $clg_args = array('clg_reff_id' => $child_ero);
            

            $data['ero_clg'] = $this->colleagues_model->get_clg_data($clg_args, $offset, $limit);
            
        }else{
            $clg_args = array('clg_senior' => $this->clg->clg_ref_id, 'clg_group' => 'UG-ERO,UG-ERO-102');

            $data['ero_clg'] = $this->colleagues_model->get_clg_data($clg_args, $offset, $limit);

            foreach ($data['ero_clg'] as $ero) {
                $child_ero[] = $ero->clg_ref_id;
            }

            if (is_array($child_ero)) {
                $child_ero = implode("','", $child_ero);
            }
        }
        if($this->post['team_type'] != ''){
            
            $team_type = $this->post['team_type'];
            
        //    if(strstr($team_type, '102')){
        //     $team_type= "-102";
        //    }elseif(strstr($team_type, 'DCO')){
        //     $team_type = "DCO";
        //    }else{
        //     $team_type= "all";
        //    }
           $data['team_type'] = $team_type;
         }

        if($this->post['qa_id'] != ''){
           $qa_id = $data['qa_id'] = $this->post['qa_id'];
        }

        if($this->post['from_date'] != '' && $this->post['to_date'] != ''){
            $data['from_date'] = $current_month_date = date('Y-m-d', strtotime($this->post['from_date']));
            $data['to_date'] = $END_day = date('Y-m-d', strtotime($this->post['to_date']));
           //var_dump($start_date_amb);die;
        }else{
            $current_month = date('m');
            $current_year = date('Y');

            $current_date = date('Y-m-d');
            $current_month_date =$current_date;
            //$END_day = date("Y-m-t", strtotime($current_month_date));
            $current_month_date = $current_year . '-' . $current_month . '-01';
            $END_day = date("Y-m-t", strtotime($current_month_date));

            $start_date_amb = date('Y-m-d', strtotime($post_reports['from_date']));
            $end_date_amb = date('Y-m-t', strtotime($post_reports['from_date']));
        }
//ar_dump($current_month);die;
        $data['child_ero']=$child_ero;

        $quality_args = array(
            'base_month' => $this->post['base_month'],
            'team_type' => $team_type,
            //'user_type' => $data['team_type'],
            // 'limit'=>$limit,
            // 'offset'=>$offset,
            'from_date' => $current_month_date,
            'to_date' => $END_day,
            'qa_ad_ref_id' => $child_ero,
            'qa_id'=> $qa_id
        );
        //var_dump($END_day); die;
        
           $data['from_date'] =$current_month_date;
           $data['to_date'] = $END_day;
        
        // var_dump($quality_args);
        // die();



        $audit_details = $this->quality_model->get_quality_audit($quality_args);
        

        $quality_marks = array();
        $data['quality_count'] = count($audit_details);
        //var_dump($audit_details);die;
        if ($audit_details) {

            foreach ($audit_details as $audit) {


                if (isset($audit->qa_ad_user_ref_id)) {

                    $audit->qa_ad_user_ref_id = strtoupper($audit->qa_ad_user_ref_id);

                    if (!in_array($audit->qa_ad_user_ref_id, (array) $quality_marks[$audit->qa_ad_user_ref_id]['ero_id'])) {



                        $quality_marks[$audit->qa_ad_user_ref_id]['ero_id'] = $audit->qa_ad_user_ref_id;
                        $quality_marks[$audit->qa_ad_user_ref_id]['quality_call'] = $quality_marks[$audit->qa_ad_user_ref_id]['quality_call'] + 1;
                        (int)$quality_marks[$audit->qa_ad_user_ref_id]['quality_score'] = (int)$quality_marks[$audit->qa_ad_user_ref_id]['quality_score'] + (int)$audit->quality_score;
                        //var_dump($quality_marks[$audit->qa_ad_user_ref_id]['quality_call']); die;

                        $fetal_indicator = json_decode($quality->fetal_indicator);
                        if ($quality->quality_score == '0' || $audit->quality_score == 0) {
                            $quality_marks[$audit->qa_ad_user_ref_id]['fetal_indicator'] = $quality_marks[$audit->qa_ad_user_ref_id]['fetal_indicator'] + 1;
                        }
                    } else {

                        (int)$quality_marks[$audit->qa_ad_user_ref_id]['quality_score'] = (int)$quality_marks[$audit->qa_ad_user_ref_id]['quality_score'] + (int)$audit->quality_score;
                        $quality_marks[$audit->qa_ad_user_ref_id]['quality_call'] = $quality_marks[$audit->qa_ad_user_ref_id]['quality_call'] + 1;

                        $fetal_indicator = json_decode($quality->fetal_indicator);
                        if ($quality->quality_score == '0' || $audit->quality_score == 0) {
                            $quality_marks[$audit->qa_ad_user_ref_id]['fetal_indicator'] = $quality_marks[$audit->qa_ad_user_ref_id]['fetal_indicator'] + 1;
                        }
                    }
                }
            }
        } else {
            //var_dump($data['ero_clg']);
            foreach ($data['ero_clg'] as $clg) {
                $clg->clg_ref_id = strtoupper($clg->clg_ref_id);
                $quality_marks[$clg->clg_ref_id]['ero_id'] = $clg->clg_ref_id;
                $quality_marks[$clg->clg_ref_id]['quality_call'] = 0;
                $quality_marks[$clg->clg_ref_id]['quality_score'] = 0;
                $quality_marks[$clg->clg_ref_id]['fetal_indicator'] = 0;
            }
        }

        // var_dump($quality_marks);
        //foreach($quality_marks as $quality_mark){

        foreach ($data['ero_clg'] as $clg) {

            $clg->clg_ref_id = strtoupper($clg->clg_ref_id);

            if (!(array_key_exists($clg->clg_ref_id, $quality_marks))) {
                $quality_marks[$clg->clg_ref_id]['ero_id'] = $clg->clg_ref_id;
                $quality_marks[$clg->clg_ref_id]['quality_call'] = 0;
                $quality_marks[$clg->clg_ref_id]['quality_score'] = 0;
                $quality_marks[$clg->clg_ref_id]['fetal_indicator'] = 0;
            }
        }

        //}


        $data['quality_score'] = $quality_marks;
        
        $data['qa'] = $this->call_model->get_all_qa();
        

        $data['cur_page'] = $page_no;
        $data['total_count'] = $data['quality_count'];
        // $data['total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;
        $to_date =$current_month_date;
           $from_date = $END_day;

        $total_cnt = $data['quality_count'];

        $pgconf = array(
            'url' => base_url("quality_forms/quality_score"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
           'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc&ref_id=$ref_id&team_type=$team_type&to_date=$to_date&from_date=$from_date&pg_rec=$pg_rec"
            
            )
        );

        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);
        
        $this->output->add_to_position($this->load->view('frontend/quality/view_quality_score', $data, TRUE), 'content', TRUE);
    }
    
    function quality_score_download() {

         $this->post = $this->input->post();
        //if($this->clg->clg_group == 'UG-EROSupervisor'){           
        //var_dump($this->post);die;
        $data['clg_senior'] = $this->clg->clg_ref_id;


        if($this->post['user_id'] != ''){
            
            $child_ero = $this->post['user_id'];
            $clg_args = array('clg_reff_id' => $child_ero);
            

            $data['ero_clg'] = $this->colleagues_model->get_clg_data($clg_args);
            
        }else{
            $clg_args = array('clg_senior' => $this->clg->clg_ref_id, 'clg_group' => 'UG-ERO');

            $data['ero_clg'] = $this->colleagues_model->get_clg_data($clg_args);

            foreach ($data['ero_clg'] as $ero) {
                $child_ero[] = $ero->clg_ref_id;
            }

            if (is_array($child_ero)) {
                $child_ero = implode("','", $child_ero);
            }
        }

        if($this->post['team_type'] != ''){
            
            $data['team_type'] = $team_type = $this->post['team_type'];
            
        //    if(strstr($team_type, '102')){
        //     $team_type= "-102";
        //    }elseif(strstr($team_type, 'DCO')){
        //     $team_type = "DCO";
        //    }else{
        //     $team_type= "all";
        //    }
          // $data['team_type'] = $team_type;
         }
        // var_dump($this->post['qa_id']);die;
        if($this->post['qa_id'] != ''){
            $qa_id = $data['qa_id'] = $this->post['qa_id'];
         }
        
         if($this->post['from_date'] != '' && $this->post['to_date'] != ''){
            $data['from_date'] = $current_month_date = date('Y-m-d', strtotime($this->post['from_date']));
            $data['to_date'] = $END_day = date('Y-m-d', strtotime($this->post['to_date']));
            //var_dump($start_date_amb);die;
         }else{
             $current_month = date('m');
             $current_year = date('Y');
 
             $current_date = date('Y-m-d');
             $current_month_date =$current_date;
             //$END_day = date("Y-m-t", strtotime($current_month_date));
             $current_month_date = $current_year . '-' . $current_month . '-01';
             $END_day = date("Y-m-t", strtotime($current_month_date));
 
             $start_date_amb = date('Y-m-d', strtotime($post_reports['from_date']));
             $end_date_amb = date('Y-m-t', strtotime($post_reports['from_date']));
         }


        $quality_args = array(
            'base_month' => $this->post['base_month'],
            'team_type' => $data['team_type'],
            //'user_type' => $data['team_type'],
            'from_date' => $current_month_date,
            'to_date' => $END_day,
            'qa_ad_ref_id' => $child_ero,
            'qa_id'=> $qa_id
        );
        //var_dump($quality_args);die;
        $audit_details = $this->quality_model->get_quality_audit($quality_args);
        

        $quality_marks = array();
        $data['quality_count'] = count($audit_details);
        if ($audit_details) {

            foreach ($audit_details as $audit) {
//var_dump($audit);die;

                if (isset($audit->qa_ad_user_ref_id)) {

                    $audit->qa_ad_user_ref_id = strtoupper($audit->qa_ad_user_ref_id);

                    if (!in_array($audit->qa_ad_user_ref_id, (array) $quality_marks[$audit->qa_ad_user_ref_id]['ero_id'])) {



                        $quality_marks[$audit->qa_ad_user_ref_id]['ero_id'] = $audit->qa_ad_user_ref_id;
                        $quality_marks[$audit->qa_ad_user_ref_id]['quality_call'] = $quality_marks[$audit->qa_ad_user_ref_id]['quality_call'] + 1;
                        (int)$quality_marks[$audit->qa_ad_user_ref_id]['quality_score'] = (int)$quality_marks[$audit->qa_ad_user_ref_id]['quality_score'] + (int)$audit->quality_score;
    

                        $fetal_indicator = json_decode($quality->fetal_indicator);
                        if ($quality->quality_score == '0' || $audit->quality_score == 0) {
                            $quality_marks[$audit->qa_ad_user_ref_id]['fetal_indicator'] = $quality_marks[$audit->qa_ad_user_ref_id]['fetal_indicator'] + 1;
                        }
                    } else {

                        $quality_marks[$audit->qa_ad_user_ref_id]['quality_score'] = $quality_marks[$audit->qa_ad_user_ref_id]['quality_score'] + $audit->quality_score;
                        $quality_marks[$audit->qa_ad_user_ref_id]['quality_call'] = $quality_marks[$audit->qa_ad_user_ref_id]['quality_call'] + 1;

                        $fetal_indicator = json_decode($quality->fetal_indicator);
                        if ($quality->quality_score == '0' || $audit->quality_score == 0) {
                            $quality_marks[$audit->qa_ad_user_ref_id]['fetal_indicator'] = $quality_marks[$audit->qa_ad_user_ref_id]['fetal_indicator'] + 1;
                        }
                    }
                }
            }
        } else {
            //var_dump($data['ero_clg']);
            foreach ($data['ero_clg'] as $clg) {
                $clg->clg_ref_id = strtoupper($clg->clg_ref_id);
                $quality_marks[$clg->clg_ref_id]['ero_id'] = $clg->clg_ref_id;
                $quality_marks[$clg->clg_ref_id]['quality_call'] = 0;
                $quality_marks[$clg->clg_ref_id]['quality_score'] = 0;
                $quality_marks[$clg->clg_ref_id]['fetal_indicator'] = 0;
            }
        }

        // var_dump($quality_marks);
        //foreach($quality_marks as $quality_mark){

        foreach ($data['ero_clg'] as $clg) {

            $clg->clg_ref_id = strtoupper($clg->clg_ref_id);

            if (!(array_key_exists($clg->clg_ref_id, $quality_marks))) {
                $quality_marks[$clg->clg_ref_id]['ero_id'] = $clg->clg_ref_id;
                $quality_marks[$clg->clg_ref_id]['quality_call'] = 0;
                $quality_marks[$clg->clg_ref_id]['quality_score'] = 0;
                $quality_marks[$clg->clg_ref_id]['fetal_indicator'] = 0;
            }
        }

        //}


        $data['quality_score'] = $quality_marks;
        
$header = array('Ero name','Audit Count', 'Quality Score','Fatal Call','Fatal Score');
          
            $filename = "quality_score_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
    
            
            
        if( $data['quality_score']){
        foreach( $data['quality_score'] as $quality_marks){ 

           

            $clg_data = get_clg_data_by_ref_id( $quality_marks['ero_id']);
            $clg_name = $quality_marks['ero_id'].'-'.$clg_data[0]->clg_first_name.' '.$clg_data[0]->clg_last_name;
            //echo $clg_name;
            
             $quality_marks['quality_call'];
            if($quality_marks['quality_call'] > 0){ $quality_score =number_format($quality_marks['quality_score']/$quality_marks['quality_call'],2); }else{ $quality_score = "0"; } 
             $quality_marks['fetal_indicator']?$quality_marks['fetal_indicator']:0;
            if($quality_marks['quality_call'] > 0){ $quality_percent = ($quality_marks['fetal_indicator']/$quality_marks['quality_call'])*100; $quality_percent = number_format($quality_percent,2);  }else{ $quality_percent =  "0"; } 
           
       
	   $inc_data = array(
                    'ero_name'=> $clg_name,
                    'quality_call'=> $quality_marks['quality_call'],
                    'quality_score' => $quality_score,
                    'fetal_indicator' => $quality_marks['fetal_indicator'],
                    'quality_percent' => $quality_percent.'%',
                );
                    fputcsv($fp, $inc_data);
        } } 

            
           fclose($fp);
            exit;
            
    }


    function quality_feedback()
    {
        //var_dump($this->post['feedback']); die;
        if (!empty($this->post['search_chief_comp'])) {

            //$this->session->set_userdata('search_chief_comp', $this->post['search_chief_comp']);
        } else {

            //$search_chief_comp = $this->session->userdata('search_chief_comp');
            $data['search_chief_comp'] = ($this->post['search_chief_comp']) ? $this->post['search_chief_comp'] :  $this->post['search_chief_comp'];
        }
        $data['feedback'] =$this->post['feedback'];

        $data['search_chief_comp'] = ($this->post['search_chief_comp']) ? $this->post['search_chief_comp'] :  $this->post['search_chief_comp'];

        if ($this->post['from_date'] != '') {
            $data['from_date'] =$from_date = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime("-1 days"));
        } else {
            $data['from_date'] = date('Y-m-d', strtotime("-1 days"));
        }
//var_dump(date('Y-m-d', strtotime("-1 days"))); die;

        if ($this->post['to_date'] != '') {
            $data['to_date'] =$to_date = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->post['to_date']));
        } else {
            $data['to_date'] = date('Y-m-d');
        }
        if ($this->post['call_purpose'] != '') {

            $data['call_purpose'] = $this->post['call_purpose'];
        }
        if ($this->post['qa_id'] != '') {
            $data['qa_id'] = $args_dash['qa_id'] = $this->post['qa_id'];
        }


        $ref_id = $this->post['user_id'];
        $team_type = $this->post['team_type'];
        $data['user_id'] = $this->post['user_id'];

        $this->post = $this->input->post();
        $this->post['base_month'] = get_base_month();
        $data['team_type'] = $this->post['team_type'];

        //$data['user_type'] = $this->post['user_type'];

        if (strstr($team_type, 'ERO')) {
            $data['user_type'] = 'ERO';
        } elseif (strstr($team_type, 'DCO')){
            $data['user_type'] = 'DCO';
        }else{
            $data['user_type'] = 'ERO';
        }
        
        if (!empty($data['user_type'])) {
            $this->session->set_userdata('quality_user_type', $data['user_type']);
        } else {
            $data['user_type'] = $this->session->userdata('quality_user_type');
        }

        

        $data['pg_rec'] = $pg_rec = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        //$this->pg_limit = 10;
        ///////////set page number////////////////////

        $page_no = 1;


        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
       

        $args_dash = array(
            'operator_id' => $ref_id,
            'base_month' => $this->post['base_month'],
            'from_date' => $data['from_date'],
            'to_date' => $data['to_date'],
            'qa_id' => $data['qa_id'],
            'call_purpose' => $data['call_purpose'],
            'search_chief_comp' => $this->post['search_chief_comp'],
            'team_type' => $data['team_type'],
            'user_type' => $data['user_type']
        );
        
        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        $args_dash['closure_done_inc'] = "0,1";

        // if ($this->post['from_date'] != '') {
        //     $args_dash['from_date'] = date('Y-m-d', strtotime($this->post['from_date']));
        // } else {
        //     $args_dash['from_date'] = date('Y-m-d', strtotime("-1 days"));
        // }


        // if ($this->post['to_date'] != '') {
        //     $args_dash['to_date'] = date('Y-m-d', strtotime($this->post['to_date']));
        // } else {
        //     $args_dash['to_date'] = date('Y-m-d');
        // }
        // 
        // if ($this->post['call_purpose'] != '') {

        //     $data['call_purpose'] = $args_dash['call_purpose'] = $this->post['call_purpose'];
        // }
        // if ($this->post['team_type'] != '') {

        //     $args_dash['team_type'] = $this->post['team_type'];
        // }

        
        if (strstr($team_type, 'ERO')) {
            //var_dump($args_dash);die;
            $inc_info = $this->call_model->get_inc_audit_done($args_dash, $offset, $limit);
            //var_dump($inc_info);die;
        } else if (strstr($team_type, 'DCO')) {
           $inc_info = $this->inc_model->get_epcr_by_group($args_dash, $offset, $limit);
        }else{
            //var_dump($args_dash);die;
                $inc_info = $this->call_model->get_inc_audit_done($args_dash, $offset, $limit);
                //var_dump($inc_info);die;
        }

        $inc_data = (object) array();

        $data['per_page'] = $limit;

        $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;

       if (strstr($team_type, 'ERO')) {
            $total_cnt = $this->call_model->get_inc_audit_done($args_dash);
        } elseif(strstr($team_type, 'DCO')) { 
           $total_cnt = $this->inc_model->get_epcr_by_group($args_dash);
        }else{
            $total_cnt = $this->call_model->get_inc_audit_done($args_dash);
        }



        $data['total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("quality_forms/quality_feedback"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
           'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc&ref_id=$ref_id&team_type=$team_type&to_date=$to_date&from_date=$from_date&pg_rec=$pg_rec"
            )
        );

        
        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);

        // $this->output->add_to_position($this->load->view('frontend/fleet/date_filter_view', $data, true), 'date_filter', true);

        //$this->output->add_to_position($this->load->view('frontend/quality/view_incidence_quality', $data, TRUE), 'content', TRUE);
        $data['all_purpose_of_calls'] = $this->call_model->get_all_child_purpose_of_calls();
        $data['qa'] = $this->call_model->get_all_qa();
        $this->output->add_to_position($this->load->view('frontend/quality/feedback_list_view', $data, TRUE), 'content', TRUE);
    }
    
    function quality_feedback_download(){
        //var_dump($this->input->post()); die;
        if (!empty($this->post['search_chief_comp'])) {

            $this->session->set_userdata('search_chief_comp', $this->post['search_chief_comp']);
        } else {

            $search_chief_comp = $this->session->userdata('search_chief_comp');
        }

        $data['search_chief_comp'] = ($this->post['search_chief_comp']) ? $this->post['search_chief_comp'] : $this->post['search_chief_comp'];

        $data['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date']));


        $data['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->post['to_date']));
       
            
        if ($this->post['call_purpose'] != '') {

            $data['call_purpose'] = $this->post['call_purpose'];
        }
        if ($this->post['qa_id'] != '') {
            $data['qa_id'] = $args_dash['qa_id'] = $this->post['qa_id'];
        }


        $ref_id = $this->post['user_id'];
        $team_type = $this->post['team_type'];

        $this->post['base_month'] = get_base_month();
        $data['team_type'] = $this->post['team_type'];

        $data['user_type'] = $this->post['user_type'];

        if (strstr($team_type, 'ERO')) {
            $data['user_type'] = 'ERO';
        } elseif (strstr($team_type, 'DCO')){
            $data['user_type'] = 'DCO';
        }else{
            $data['user_type'] = 'ERO';
        }
        if (!empty($data['user_type'])) {
            $this->session->set_userdata('quality_user_type', $data['user_type']);
        } else {
            $data['user_type'] = $this->session->userdata('quality_user_type');
        }


        $args_dash = array(
            'operator_id' => $ref_id,
            'base_month' => $this->post['base_month'],
            'search_chief_comp' => $data['search_chief_comp'],
            'qa_id' => $data['qa_id'],
            'team_type' => $data['team_type'],
            'from_date' => $data['from_date'],
            'to_date' => $data['to_date'],
            'call_purpose' => $data['call_purpose'],
            'user_type' => $data['user_type']
        );
     
        if (strstr($team_type, 'ERO')) {
           
            $inc_info = $this->call_model->get_inc_audit_done($args_dash, $offset, $limit);
            
        }elseif (strstr($team_type, 'DCO')) {
           $inc_info = $this->inc_model->get_epcr_by_group($args_dash, $offset, $limit);
        }else{
            $inc_info = $this->call_model->get_inc_audit_done($args_dash, $offset, $limit);
        }
        //var_dump($args_dash);die;
          $header = array('Ero name','Incident Id', 'Call type','Call Time','Audit Done By','Quality Score', 'Ero meeting Time', 'Feedback Status');
          
            $filename = "feedback_report.csv; charset=UTF-8";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            //var_dump($inc_info);die;
            foreach ($inc_info as $row) {

                // if ($row->fc_feedback_type == 'negative_feedback') {
                //     $type = 'Negative Feedback';
                // } else {
                //     $type = 'Positive Feedback';
                // }
                if($row->feedback_status){
                    $staus = "Completed";
                    
                }else{
                    $staus = "Pending";
                    
                }

                $inc_data = array(
                    
                    // 'clg_avaya_agentid'=> $row->clg_avaya_agentid,
                    'clg_name'=> ucwords($row->clg_first_name. " " .$row->clg_mid_name. " " .$row->clg_last_name),
                    'inc_ref_id' => $row->inc_ref_id,
                    'pname'=>$row->pname,
                    'inc_datetime' => $row->inc_dispatch_time,
                    'added_by' => $row->added_by,
                    'quality_score' => $row->quality_score,
                    'ero_meeting_time' => $row->ero_meeting_time,
                    'fc_feedback_status' => $staus,
                );
                fputcsv($fp, $inc_data);
            }

            fclose($fp);
            exit;
            
    }

    function view_incidence_feedback()
    {
        //var_dump($this->input->post());die;
        if (!empty($this->post['search_chief_comp'])) {

            $this->session->set_userdata('search_chief_comp', $this->post['search_chief_comp']);
        } else {

            $search_chief_comp = $this->session->userdata('search_chief_comp');
        }

        $data['search_chief_comp'] = ($this->post['search_chief_comp']) ? $this->post['search_chief_comp'] : $this->post['search_chief_comp'];

        if ($this->post['from_date'] != '') {
            $data['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date']));
        } else {
            $data['from_date'] = date('Y-m-d');
        }


        if ($this->post['to_date'] != '') {
            $data['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->post['to_date']));
        } else {
            $data['to_date'] = date('Y-m-d');
        }
        if ($this->post['call_purpose'] != '') {

            $data['call_purpose'] = $this->post['call_purpose'];
        }


        $ref_id = $this->post['user_id'];
        $team_type = $this->post['team_type'];



       // if (!empty($ref_id)) {

         //   $this->session->set_userdata('quality_ref_id', $ref_id);
      //  } else {

        //    $ref_id = $this->session->userdata('quality_ref_id');
     //   }






        //$data['ref_id'] = $ref_id;

        $this->post = $this->input->post();
        $this->post['base_month'] = get_base_month();
        $data['team_type'] = $this->post['team_type'];

        $data['user_type'] = $this->post['user_type'];

        if (strstr($team_type, 'ERO')) {
            $data['user_type'] = 'ERO';
        } else {
            $data['user_type'] = 'DCO';
        }
        if (!empty($data['user_type'])) {
            $this->session->set_userdata('quality_user_type', $data['user_type']);
        } else {
            $data['user_type'] = $this->session->userdata('quality_user_type');
        }

        

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        //$this->pg_limit = 10;
        ///////////set page number////////////////////

        $page_no = 1;


        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


        $args_dash = array(
            'operator_id' => $ref_id,
            'base_month' => $this->post['base_month'],
            //'search_chief_comp' => $data['search_chief_comp'],
            'search_chief_comp' => $this->post['search_chief_comp'],
            //'today' => date('Y-m-d', strtotime("-1 days"))
        );

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;


        if ($this->post['from_date'] != '') {
            $args_dash['from_date'] = date('Y-m-d', strtotime($this->post['from_date']));
        } else {
            $args_dash['from_date'] = date('Y-m-d', strtotime("-1 days"));
        }


        if ($this->post['to_date'] != '') {
            $args_dash['to_date'] = date('Y-m-d', strtotime($this->post['to_date']));
        } else {
            $args_dash['to_date'] = date('Y-m-d');
        }
        $args_dash['closure_done_inc'] = "0,1";
        if ($this->post['call_purpose'] != '') {

            $args_dash['call_purpose'] = $this->post['call_purpose'];
        }
        if ($this->post['team_type'] != '') {

            $args_dash['team_type'] = $this->post['team_type'];
        }
        if ($this->post['qa_id'] != '') {
            $args_dash['qa_id'] = $this->post['qa_id'];
        }
        //$data['team_type'] = $this->post['team_type'];

        
        //if (strstr($team_type, 'ERO')) {
            $inc_info = $this->call_model->get_inc_audit_done($args_dash, $offset, $limit);
            //var_dump($inc_info);die;
        //} else {
      //     $inc_info = $this->inc_model->get_epcr_by_group($args_dash, $offset, $limit);
       // }




        $inc_data = (object) array();

        $data['per_page'] = $limit;

        $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;

       //if (strstr($team_type, 'ERO')) {
            $total_cnt = $this->call_model->get_inc_audit_done($args_dash);
        //} else {
         //   $total_cnt = $this->inc_model->get_epcr_by_group($args_dash);
       // }



        $data['total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("quality_forms/quality_feedback"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc&ref_id=$ref_id&team_type=$team_type"
            )
        );

        
        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);

        // $this->output->add_to_position($this->load->view('frontend/fleet/date_filter_view', $data, true), 'date_filter', true);

        //$this->output->add_to_position($this->load->view('frontend/quality/view_incidence_quality', $data, TRUE), 'content', TRUE);
        $data['all_purpose_of_calls'] = $this->call_model->get_all_child_purpose_of_calls();
        $this->output->add_to_position($this->load->view('frontend/quality/feedback_list_view', $data, TRUE), 'list_table', TRUE);
    }

    function view_incidence_quality_download() {
       
        //echo " hi"; die;
        if (!empty($this->post['search_chief_comp'])) {
            $this->session->set_userdata('search_chief_comp', $this->post['search_chief_comp']);
        } else {
            $search_chief_comp = $this->session->userdata('search_chief_comp');
        }
        $data['search_chief_comp'] = ($this->post['search_chief_comp']) ? $this->post['search_chief_comp'] : $search_chief_comp;
        if ($this->post['from_date'] != '') {
            $data['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date']));
        } else {
            $data['from_date'] = date('Y-m-d');
        }
        if ($this->post['to_date'] != '') {
            $data['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->post['to_date']));
        } else {
            $data['to_date'] = date('Y-m-d');
        }
        if ($this->post['call_purpose'] != '') {
            $data['call_purpose'] = $this->post['call_purpose'];
        }
        if ($this->post['qa_id'] != '') {

            $data['qa_id'] = $this->post['qa_id'];
        }
        $ref_id = $this->post['user_id'];
        $team_type = $this->post['team_type'];
        if (!empty($ref_id)) {
            $this->session->set_userdata('quality_ref_id', $ref_id);
        } else {
           //$ref_id = $this->session->userdata('quality_ref_id');
           $data['ref_id'] = ($this->post['user_id']) ? $this->post['search_chief_comp'] : $ref_id;
        }
        //$data['ref_id'] = $ref_id;
        $this->post = $this->input->post();
        $this->post['base_month'] = get_base_month();
        $data['team_type'] = $this->post['team_type'];
        $data['user_type'] = $this->post['user_type'];
        if (strstr($team_type, 'ERO')) {
            $data['user_type'] = 'ERO';
        } else {
            $data['user_type'] = 'DCO';
        }
        if (!empty($data['user_type'])) {
            $this->session->set_userdata('quality_user_type', $data['user_type']);
        } else {
            $data['user_type'] = $this->session->userdata('quality_user_type');
        }
        if ($this->post['from_date'] != '') {
            $args_dash['from_date'] = date('Y-m-d', strtotime($this->post['from_date']));
        } else {
            $args_dash['from_date'] = date('Y-m-d', strtotime("-1 days"));
        }
        if ($this->post['to_date'] != '') {
            $args_dash['to_date'] = date('Y-m-d', strtotime($this->post['to_date']));
        } else {
            $args_dash['to_date'] = date('Y-m-d');
        }
        $args_dash['closure_done_inc'] = "0,1";
        if ($this->post['call_purpose'] != '') {
            $args_dash['call_purpose'] = $this->post['call_purpose'];
        }
        if ($this->post['qa_id'] != '') {
            $args_dash['qa_id'] = $this->post['qa_id'];
        }
        if ($this->post['team_type'] != '') {
            $args_dash['team_type'] = $this->post['team_type'];
        }
        //$data['team_type'] = $this->post['team_type'];
        $args_dash = array(
            'operator_id' => $ref_id,
            'base_month' => $this->post['base_month'],
            'team_type' => $data['team_type'],
            'from_date'=> $data['from_date'],
            'to_date' => $data['to_date'],
            'call_purpose'=>$data['call_purpose'],
            //'search_chief_comp' => $data['search_chief_comp'],
            'search_chief_comp' => $this->post['search_chief_comp']
        );
        //var_dump($args_dash);die;
        if (strstr($team_type, 'ERO')) {
            //var_dump($args_dash);die;
            $inc_info = $this->call_model->get_inc_by_ero_audit($args_dash, $offset="0", $limit="");
        } else if (strstr($team_type, 'DCO')) {
            $inc_info = $this->inc_model->get_epcr_by_group($args_dash, $offset="0", $limit="");
        }else{
            $inc_info = $this->call_model->get_inc_by_ero_audit($args_dash, $offset="0", $limit="");
        }
        
        $header = array('Date Time','Incident Id','Ero name','District','Caller Name','Caller Number','Call type','Chief Complaint','Call Time' );
          
            $filename = "Quality_form_report.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);
            $inc_data = array();
            //var_dump($inc_info);die;
            foreach ($inc_info as $row) {
                // if ($row->fc_feedback_type == 'negative_feedback') {
                //     $type = 'Negative Feedback';
                // } else {
                //     $type = 'Positive Feedback';
                // }
                $inc_data = array(
                    'inc_datetime' => $row->inc_datetime,
                    'inc_ref_id' => $row->inc_ref_id,
                    'clg_name'=> ucwords($row->clg_first_name. "  " .$row->clg_last_name),
                    // 'avaya_id'=> $row->inc_avaya_uniqueid,
                    'ditrisct'=> $row->dst_name,
                    'caller_name'=> ucwords($row->clr_fname. "  " .$row->clr_lname),
                    'caller_mobile'=>$row->clr_mobile,
                    'call_type'=>$row->pname,
                    'chief_complaint'=>$row->ct_type,
                    'call_time'=>$row->inc_dispatch_time
                    
                );
                fputcsv($fp, $inc_data);
            }
            fclose($fp);
            exit;
            
    }

}
