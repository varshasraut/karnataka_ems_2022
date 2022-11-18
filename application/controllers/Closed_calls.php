<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Closed_calls extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->active_module = "M-CLOSED-CALL";

        $this->pg_limit = $this->config->item('pagination_limit');

        $this->pg_limits = $this->config->item('report_clg');

        $this->load->model(array('call_model', 'get_city_state_model', 'options_model', 'module_model', 'common_model', 'Pet_model', 'Ercp_model', 'amb_model', 'inc_model', 'colleagues_model', 'pcr_model', 'cluster_model', 'medadv_model', 'enquiry_model', 'module_model', 'feedback_model', 'quality_model', 'grievance_model', 'police_model','fire_model','problem_reporting_model'));

        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper', 'language_helper'));
        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));
        $this->site_name = $this->config->item('site_name');
         $this->post = $this->input->get_post(NULL);
        $this->post['base_month'] = get_base_month();
        $this->site = $this->config->item('site');
         $this->sess_expiration = $this->config->item('sess_expiration');
        $this->default_state = $this->config->item('default_state');
        $this->clg = $this->session->userdata('current_user');
        $this->today = date('Y-m-d H:i:s');
    }

    public function index($generated = false) {
//         $this->post = $this->input->post();
//         $get_data = $this->input->get();
//         $get_data = $this->input->get('type');

//         $this->post['base_month'] = get_base_month();

//         $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
//         $data['ero_id'] = ($this->post['ero_id']) ? $this->post['ero_id'] : $this->fdata['ero_id'];

//         //$this->pg_limit = 10;
//         ///////////set page number////////////////////
//         $args_dash = array();
//         $page_no = 1;

//         if ($this->post['from_date'] != '') {
//             $args_dash['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date']));
//         }else{
//              $args_dash['from_date'] = date('Y-m-d');
//         }


//         if ($this->post['to_date'] != '') {
//             $args_dash['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->post['to_date']));
//         }else{
//              $args_dash['to_date'] = date('Y-m-d');
//         }
        
//         if ($this->uri->segment(3)) {
//             $page_no = $this->uri->segment(3);
//         } else if ($this->fdata['page_no'] && !$this->post['flt']) {
//             $page_no = $this->fdata['page_no'];
//         }


//         $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
//         $data['clg_group'] = $this->clg->clg_group;


            
//         //$args_dash['operator_id'] = $this->clg->clg_ref_id;
//         $args_dash['base_month'] = $this->post['base_month'];
        
       

// //        var_dump($args_dash);
// //        die();
//         $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

//         $data['page_no'] = $page_no;


//         //$incomplete_inc_amb = $this->pcr_model->get_incomplete_inc_amb();
//         //$inc_info = $this->pcr_model->get_inc_by_emt($args_dash, $offset, $limit,$filter,$sortby,$incomplete_inc_amb);

//         $inc_info = $this->call_model->get_inc_closed($args_dash, $offset, $limit);


//         $inc_data = (object) array();

//         $data['per_page'] = $limit;

//         $data['inc_info'] = $inc_info;

//         $args_dash['get_count'] = TRUE;
//         $total_cnt = $this->call_model->get_inc_closed($args_dash);
//         //$total_cnt = $this->pcr_model->get_inc_by_emt($args_dash,'','',$filter,$sortby,$incomplete_inc_amb);

//         $data['inc_total_count'] = $total_cnt;
//         $data['inc_offset'] = $offset;
//         $data['per_page'] = $limit;


//         $pgconf = array(
//             'url' => base_url("closed_calls/index"),
//             'total_rows' => $total_cnt,
//             'per_page' => $limit,
//             'cur_page' => $page_no,
//             'uri_segment' => 3,
//             'use_page_numbers' => TRUE,
//             'attributes' => array('class' => 'click-xhttp-request',
//                 'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
//             )
//         );


//         $config = get_pagination($pgconf);
//         $data['pagination'] = get_pagination($pgconf);



//         $this->output->add_to_position($this->load->view('frontend/closed_calls/closed_call_view', $data, TRUE), 'content', TRUE);
       
$this->post = $this->input->post();
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');

        $this->post['base_month'] = get_base_month();

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        $this->pg_limit = 50;
        ///////////set page number////////////////////

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }


        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


        $args_dash = array(
            //'operator_id' => $this->clg->clg_ref_id,
            //'operator_id' => $this->clg->clg_ref_id,
            'base_month' => $this->post['base_month']
        );

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;


        $current_date = date('Y-m-d');
        $current_month = date('m');
        $current_year = date('Y');
        $current_month_date = $current_year . '-' . $current_month . '-01';
        
        if ($this->post['from_date'] != '') {
            $args_dash['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date']));
        }


        if ($this->post['to_date'] != '') {
            
            $args_dash['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->post['to_date']));
            
        }
        
        if($args_dash['to_date'] != '' && $args_dash['from_date'] != ''){
            
            $args = array('from_date' => $args_dash['from_date'],
            'to_date' => $args_dash['to_date'],
            'base_month' => $this->post['base_month']);
            
        }else{
            
            $current_date =date('Y-m-d H:i:s');
            $newdate = date('Y-m-d H:i:s',strtotime ( '-48 hour' , strtotime($current_date))) ;

            $args = array('from_date' => $newdate,
                'to_date' => $current_date,
                'base_month' => $this->post['base_month']);
        }
        $from_date=$args['from_date'];
        $to_date=$args['to_date'];
        $pg_rec=$data['pg_rec'];
        $district_id = "";
        
        if($this->clg->clg_group ==  'UG-DM' || $this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
            $args['amb_district'] = $district_id;
            
        }


        $inc_info = $this->inc_model->get_all_inc_by_closure($args, $offset, $limit);


        $inc_data = array();

        foreach ($inc_info as $inc) {
            //$inc_data[] = $inc;
            //$ero_108 = $this->call_model->get_inc_ero_108($inc['inc_ref_id']);

            $caller_details = $this->call_model->get_caller_details_by_callid($inc['inc_cl_id']);

            $inc['clr_fullname'] = $caller_details[0]['clr_fname'] . ' ' . $caller_details[0]['clr_lname'];
            $inc['clr_mobile'] = $caller_details[0]['clr_mobile'];

            $incient_district = $this->inc_model->get_district_by_id($inc['inc_district_id']);
            $inc['dst_name'] = $incient_district->dst_name;

            $inc_emt_data = $this->call_model->get_emt_pilot_amb_by_inc_id($inc['inc_ref_id']);


            $inc['amb_default_mobile'] = $inc_emt_data[0]->clg_mobile_no;
            $inc['amb_rto_register_no'] = $inc_emt_data[0]->amb_rto_register_no;
            $inc['amb_emt_id'] = $inc_emt_data[0]->amb_emt_id;

            $inc['amb_pilot_id'] = $inc_emt_data[0]->amb_pilot_id;

            $inc['amb_pilot_mobile'] = $inc_emt_data[0]->clg_pilot_mobile;
            $inc_data[] = $inc;
        }


        $data['inc_info'] = $inc_data;

        $args['get_count'] = TRUE;
        $total_cnt = $this->inc_model->get_all_inc_by_closure($args);
        // var_dump($total_cnt);

        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("closed_calls/index"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
            'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc&from_date=$from_date&to_date=$to_date&pg_rec=$pg_rec"
            )
        );


        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);


        // $this->output->add_to_position($this->load->view('frontend/calls/ero_dashboard_view', $data, TRUE), 'content', TRUE);

        $this->output->add_to_position($this->load->view('frontend/closed_calls/closed_call_view', $data, TRUE), 'content', TRUE);
        // $this->output->template = "calls";
    }
    // function view_closed_call(){
        


    //         $args = array(
    //             'inc_ref_id' => trim($this->post['inc_ref_id']),
    //         );

    //         $data['inc_ref_id'] = trim($this->post['inc_ref_id']);

    //        // $this->session->set_userdata('closed_inc_ref_id', $this->post['inc_ref_id']);

    //         //$data['cl_dtl'] = $this->problem_reporting_model->get_grivance_call_detials($args);

    //         $this->session->set_userdata('caller_information', $data['cl_dtl']);
    //         $this->session->set_userdata('inc_ref_id', $data['inc_ref_id']);

    //         $args_remark = array('re_id' => $data['cl_dtl'][0]->inc_ero_standard_summary);
    //         $standard_remark = $this->call_model->get_ero_summary_remark($args_remark);
    //         $data['re_name'] = $standard_remark[0]->re_name;
      

    //     if (empty($data['cl_dtl'])) {
    //         $this->output->message = "<p>No Record Found</p>";

    //         return;
    //     }
        
    //     $this->output->add_to_popup($this->load->view('frontend/escalation/escalation_view', $data, TRUE), '1000', '1000');
    //     //$this->output->add_to_position($this->load->view('frontend/escalation/escalation_view', $data, TRUE), 'content', TRUE);
    // }
}