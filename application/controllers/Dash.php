<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dash extends EMS_Controller {

    function __construct() {
        parent::__construct();

        $this->active_module = "M-DSB";

        $this->load->model(array('dashboard_model', 'users_model', 'amb_model', 'student_model', 'cluster_model', 'school_model', 'inc_model', 'inv_model', 'eqp_model', 'call_model','colleagues_model'));

        $this->pg_limit = $this->config->item('pagination_limit');
        $this->clg = $this->session->userdata('current_user');
    }

    function index() {

        $clg_group = $this->clg->clg_group;
        $ref_id = get_cookie("username");
        $current_user = $this->colleagues_model->get_user_info($ref_id);

        $data = array();

        $data['user_group'] = $current_user[0]->clg_group;
        $data['ref_id_encode'] = base64_encode($ref_id);
        $ref_id_encode = base64_encode($ref_id);
        $this->output->add_to_position("<script>sessionStorage.setItem('clg_details', '$ref_id_encode'); window.location = '$this->base_url'/dash;</script>", 'custom_script', true);
        $this->output->add_to_position($this->load->view('frontend/dash/dashboard_blank_view', $data, true));
        $this->output->template = "pcr";
    }
    function dashboard() {
        $clg_group = $this->clg->clg_group;
        $ref_id = get_cookie("username");
        
        $current_user = $this->colleagues_model->get_user_info($ref_id);

        $data = array();

        $data['user_group'] = $current_user[0]->clg_group;
        $data['ref_id_encode'] = base64_encode($ref_id);
        $this->output->add_to_position($this->load->view('frontend/dash/dashboard_view', $data, true));
        $this->output->template = "emt";
    }

    /* Function for lise the recent calls */

    function rec_cls() {

        $this->output->add_to_position($this->load->view('ems-admin/recent_calls_view', $data, true), 'recent_calls', true);
    }

    function total_ope_amb() {

        if ($this->clg->clg_group == 'UG-PRO-OFF') {
            $data['function_name'] = 'total_ope_amb_po';
            $po_id = $this->clg->clg_po;
            $cluster_id = get_cluster_by_po($atc->po_id);
            if (is_array($cluster_id)) {
                $cluster_ids = implode(",", $cluster_id[$po_id]);
            }
        } else if ($this->clg->clg_group == 'UG-ASS-TRI-COM') {

            $data['function_name'] = 'total_ope_amb_atc';
            $atc_id = $this->clg->clg_atc;
            $cluster_id = get_cluster_by_atc($atc_id);
            if (is_array($cluster_id)) {
                $cluster_ids = implode(",", $cluster_id[$atc_id]);
            }
        }

        $args = array('cluster_id' => $cluster_ids);

        $data['total_amb'] = $this->amb_model->get_tdd_total_amb($args);

        $args = array('amb_status' => '1,2,3,6', 'cluster_id' => $cluster_ids);
        $data['total_onroad_amb'] = $this->amb_model->get_tdd_total_amb($args);

        $this->output->add_to_position($this->load->view('frontend/dash/total_operational_amb_view', $data, true), 'content', true);
    }

    function stud_screen_status() {
        $current_date = date('Y-m-d');
        $current_month = date('m');
        $current_year = date('Y');
        $cluster_ids = "";

        if ($this->clg->clg_group == 'UG-PRO-OFF') {
            $data['function_name'] = 'total_ope_amb_po';
            $po_id = $this->clg->clg_po;
            $cluster_id = get_cluster_by_po($atc->po_id);
            if (is_array($cluster_id)) {
                $cluster_ids = implode(",", $cluster_id[$po_id]);
            }
            $data['function_name'] = 'studen_screening_po';
        } else if ($this->clg->clg_group == 'UG-ASS-TRI-COM') {

            $data['function_name'] = 'total_ope_amb_atc';
            $atc_id = $this->clg->clg_atc;
            $cluster_id = get_cluster_by_atc($atc_id);
            if (is_array($cluster_id)) {
                $cluster_ids = implode(",", $cluster_id[$atc_id]);
            }
            $data['function_name'] = 'studen_screening_atc';
        }

        $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
            'to_date' => date('Y-m-d', strtotime($current_date)),
            'cluster_id' => $cluster_ids);

        $report_args['get_count'] = 'true';
        $today_screening = $this->student_model->get_screening_atc_by_date($report_args);
        $data['today_screening'] = $today_screening;


        $current_month_date = $current_year . '-' . $current_month . '-01';
        $args = array('from_date' => date('Y-m-d', strtotime($current_month_date)),
            'to_date' => date('Y-m-d', strtotime($current_date)),
            'cluster_id' => $cluster_ids);
        $args['get_count'] = 'true';
        $nov_screening = $this->student_model->get_screening_atc_by_date($args);
        //var_dump($nov_screening); die();
        $data['month_screening'] = $nov_screening;

        $current_year_date = $current_year . '-01-01';
        $args = array('from_date' => date('Y-m-d', strtotime($current_year_date)),
            'to_date' => date('Y-m-d', strtotime($current_date)),
            'cluster_id' => $cluster_ids);
        $args['get_count'] = 'true';
        $total_screening = $this->student_model->get_screening_atc_by_date($args);
        $data['year_total_screening'] = $total_screening;

        $total_args['get_count'] = 'true';
        $total_args['cluster_id'] = $cluster_ids;
        $total_screening = $this->student_model->get_screening_atc_by_date($total_args);
        $data['total_screening'] = $total_screening;

        $data['current_date'] = $current_date;
        $this->output->add_to_position($this->load->view('frontend/dash/stud_screen_status_view', $data, true), 'content', true);
    }

    function distance_travel_by_amb() {

        $current_date = date('Y-m-d');
        $current_month = date('m');
        $current_year = date('Y');

        $cluster_id = $this->clg->cluster_id;
        $cluster_id = "";
        $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
            'to_date' => date('Y-m-d', strtotime($current_date)),
            'cluster_id' => $cluster_id);


        $report_data = $this->inc_model->get_distance_report_by_date($report_args);

        $today_district_data = array();
        $today_district_data['amb'] = array();
        $today_district_data['total_km'] = 0;
        $today_district_data['inc_ref_id'] = array();

        foreach ($report_data as $report) {

            if (!in_array($report['amb_reg_id'], $today_district_data['amb'])) {
                $today_district_data['amb'][] = $report['amb_reg_id'];
            }

            if (!in_array($report['inc_ref_id'], $today_district_data['inc_ref_id'])) {
                if (!empty($report['start_odometer'])) {
                    if ($report['end_odometer'] >= $report['start_odometer']) {

                        $report_odometer = $report['end_odometer'] - $report['start_odometer'];
                        $today_district_data['total_km'] += $report['total_km'];
                    }
                }
            }
        }
        $data['today_distance'] = $today_district_data['total_km'];

        $current_month_start_date = $current_year . '-' . $current_month . '-01';

        $current_month__args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
            'to_date' => date('Y-m-d', strtotime($current_date)),
            'cluster_id' => $cluster_id);

        $report_data = $this->inc_model->get_distance_report_by_date($current_month__args);

        $month_district_data = array();
        $month_district_data['total_km'] = 0;
        $month_district_data['inc_ref_id'] = array();
        $month_district_data['amb'] = array();

        foreach ($report_data as $report) {

            if (!in_array($report['amb_reg_id'], $month_district_data['amb'])) {
                $month_district_data['amb'][] = $report['amb_reg_id'];
            }

            if (!in_array($report['inc_ref_id'], $month_district_data['inc_ref_id'])) {
                if (!empty($report['start_odometer'])) {
                    if ($report['end_odometer'] >= $report['start_odometer']) {

                        $report_odometer = $report['end_odometer'] - $report['start_odometer'];
                        $month_district_data['total_km'] += $report['total_km'];
                    }
                }
            }
        }
        $data['current_month_distance'] = $month_district_data['total_km'];

        $current_year_start_date = $current_year . '-01-01';
        $current_month__args = array('from_date' => date('Y-m-d', strtotime($current_year_start_date)),
            'to_date' => date('Y-m-d', strtotime($current_date)),
            'cluster_id' => $cluster_id);
        $report_data = $this->inc_model->get_distance_report_by_date($current_month__args);

        $year_district_data = array();
        $year_district_data['total_km'] = 0;
        $year_district_data['inc_ref_id'] = array();
        $year_district_data['amb'] = array();

        foreach ($report_data as $report) {

            if (!in_array($report['amb_reg_id'], $year_district_data['amb'])) {
                $year_district_data['amb'][] = $report['amb_reg_id'];
            }

            if (!in_array($report['inc_ref_id'], $year_district_data['inc_ref_id'])) {
                if (!empty($report['start_odometer'])) {
                    if ($report['end_odometer'] >= $report['start_odometer']) {

                        $report_odometer = $report['end_odometer'] - $report['start_odometer'];
                        $year_district_data['total_km'] += $report['total_km'];
                    }
                }
            }
        }
        $data['current_year_distance'] = $year_district_data['total_km'];


        $year_args['cluster_id'] = $cluster_id;
        $report_data = $this->inc_model->get_distance_report_by_date($year_args);

        $total_district_data = array();
        $total_district_data['total_km'] = 0;
        $total_district_data['inc_ref_id'] = array();
        $total_district_data['amb'] = array();

        foreach ($report_data as $report) {
            if (!in_array($report['amb_reg_id'], $total_district_data['amb'])) {
                $total_district_data['amb'][] = $report['amb_reg_id'];
            }
            if (!in_array($report['inc_ref_id'], $total_district_data['inc_ref_id'])) {
                if (!empty($report['start_odometer'])) {
                    if ($report['end_odometer'] >= $report['start_odometer']) {

                        $report_odometer = $report['end_odometer'] - $report['start_odometer'];
                        $total_district_data['total_km'] += $report['total_km'];
                    }
                }
            }
        }
        $data['total_distance'] = $total_district_data['total_km'];
        $data['current_date'] = $current_date;

        $this->output->add_to_position($this->load->view('frontend/dash/distance_travel_by_amb_view', $data, true), 'content', true);
    }

    function sick_inv_status_drug() {

        $args['req_type'] = 'sick_room';
        $data['item_list'] = $this->inv_model->get_inv_dashboard($args);
        $data['item_avail_list'] = $this->inv_model->get_inv_dashboard($args);

        $med_args = array('med_type' => 'sickroom');
        $item_list = $this->inv_model->get_dashboard_med_name($med_args);
        $item_list_data = array();

        if (mi_empty($this->input->post('cluster'))) {

            foreach ($item_list as $item) {

                $args = array('med_id' => $item->med_id,
                    'type' => 'MED',
                    'req_type' => 'sick_room');

                $item_avail_list = $this->med_model->get_med_sick_out_stock_cluster($args);
                $item_min_in_qty = $this->med_model->get_med_sick_in_stock_cluster($args);

                $item_min_in_qty = (array) $item_min_in_qty;
                $item_avail_list = (array) $item_avail_list;

                if (!empty($item_min_in_qty)) {
                    $item->in_stk = $item_min_in_qty['in_stk'];
                } else {
                    $item->in_stk = 0;
                }


                $item->out_stk = $item_avail_list['out_stk'];

                if ($item->in_stk > 0) {
                    $available_stock = $item->in_stk - $item->out_stk;
                } else {
                    //$available_stock =  $item->med_base_quantity - $item->out_stk;
                    $available_stock = 0;
                }

                $item->available_stk = $available_stock;
                $item_list_data[] = $item;
            }
        } else {

            $post = $this->input->post('cluster');

            $atc = $post['atc'];
            $po = $post['po'];
            $cluster_id = $post['cluster_id'];
            $data['cluster'] = $post;


            if (!empty($atc)) {
                $atc_args = array('atc_id' => $atc);
                $data['atc_data'] = $this->dashboard_model->get_atc_list($atc_args);
            }

            if (!empty($po)) {
                $po_args = array('po_id' => $po);
                $data['po_data'] = $this->dashboard_model->get_auto_po_by_atc_id($po_args);
            }

            if (!empty($cluster_id)) {
                $cluster_args = array('cluster_id' => $cluster_id);
                $data['cluster_data'] = $this->cluster_model->get_cluster_data($cluster_args);
            }

            $cluster_ids = array();

            if ($cluster_id) {

                $cluster_ids = $cluster_id;
            } else if ($po) {
                $po_cluster_ids = $this->dashboard_model->get_cluter_by_po_id($po);
                foreach ($po_cluster_ids as $po_cluster) {
                    $cluster_ids[] = $po_cluster->cluster_id;
                }
                $cluster_ids = implode(",", $cluster_ids);
            } else if ($atc) {
                $atc_args = array('atc' => $atc);
                $atc_cluster_ids = $this->cluster_model->get_cluster_data($atc_args);
                foreach ($atc_cluster_ids as $po_cluster) {
                    $cluster_ids[] = $po_cluster->cluster_id;
                }
                $cluster_ids = implode(",", $cluster_ids);
            }

            foreach ($item_list as $item) {

                $args = array('med_id' => $item->med_id,
                    'type' => 'MED',
                    'req_type' => 'sick_room');

                if (!empty($cluster_ids)) {
                    $args['cluster_id'] = $cluster_ids;
                }
//var_dump($cluster_ids);
                $item_avail_list = $this->med_model->get_med_sick_out_stock_cluster($args);
                $item_min_in_qty = $this->med_model->get_med_sick_in_stock_cluster($args);

                $item_min_in_qty = (array) $item_min_in_qty;
                $item_avail_list = (array) $item_avail_list;

                if (!empty($item_min_in_qty)) {
                    $item->in_stk = $item_min_in_qty['in_stk'];
                } else {
                    $item->in_stk = 0;
                }


                $item->out_stk = $item_avail_list['out_stk'];

                if ($item->in_stk > 0) {
                    $available_stock = $item->in_stk - $item->out_stk;
                } else {
                    //$available_stock =  $item->med_base_quantity - $item->out_stk;
                    $available_stock = 0;
                }

                $item->available_stk = $available_stock;
                $item_list_data[] = $item;
            }
        }

        $data['item_list'] = $item_list_data;

        $this->output->add_to_position($this->load->view('frontend/dash/sick_inv_status_drug_view', $data, true), 'content', true);
    }

    function ope_amb_atc() {
        $data['atc_data'] = $this->dashboard_model->get_atc_list();

        foreach ($data['atc_data'] as $atc) {
            $atc_screening[$atc->atc_id]['atc_name'] = $atc->atc_name;
            $atc_screening[$atc->atc_id]['atc_id'] = $atc->atc_id;
        }
        $data['atc_screening'] = $atc_screening;
        $data['atc_po_linke'] = 'po_ope_amb';

        $this->output->add_to_position($this->load->view('frontend/dash/atc_ope_amb_view', $data, true), 'content', true);
    }

    function po_ope_amb() {
        $data['atc'] = $this->input->post('atc');
        $data['po'] = $this->input->post('po');

        $this->output->add_to_position($this->load->view('frontend/dash/po_ope_amb_view', $data, true), 'content', true);
    }

    function cluster_ope_amb() {
        $data['po'] = $this->input->post('po');
        $data['atc'] = $this->input->post('atc');

        $this->output->add_to_position($this->load->view('frontend/dash/cluster_ope_amb_view', $data, true), 'content', true);
    }

    function school_ope_amb() {
        $data['po'] = $this->input->post('po');
        $data['cluster'] = $this->input->post('cluster');

        $this->output->add_to_position($this->load->view('frontend/dash/school_ope_amb_view', $data, true), 'content', true);
    }

    function total_ope_amb_atc() {
        $data['bread_title'] = "Total Operational Ambulance ";
        $data['bread_title_link'] = "total_ope_amb";

        if ($this->clg->clg_group == 'UG-PRO-OFF') {

            $po_id = $this->clg->clg_po;
            $cluster_id = get_cluster_by_po($atc->po_id);
            if (is_array($cluster_id)) {
                $cluster_ids = implode(",", $cluster_id[$po_id]);
            }
        } else if ($this->clg->clg_group == 'UG-ASS-TRI-COM') {

            $atc_id = $this->clg->clg_atc;
            $cluster_id = get_cluster_by_atc($atc_id);

            if (is_array($cluster_id)) {
                $cluster_ids = implode(",", $cluster_id[$atc_id]);
            }

            $atc_args = array('atc_id' => $atc_id);
            $atc_data = $this->dashboard_model->get_atc_list($atc_args);
            $atc = $atc_data[0];

            $atc_screening[$atc->atc_id]['atc_name'] = $atc->atc_name;
            $atc_screening[$atc->atc_id]['atc_id'] = $atc->atc_id;
            $args = array('cluster_id' => $cluster_ids);

            $total_amb = $this->amb_model->get_tdd_total_amb($args);
            $atc_screening[$atc->atc_id]['total_amb'] = $total_amb;

            $on_args = array('amb_status' => '1,2,3,6',
                'cluster_id' => $cluster_ids);
            $atc_screening[$atc->atc_id]['total_onroad_amb'] = $this->amb_model->get_tdd_total_amb($on_args);
        } else {

            $data['atc_data'] = $this->dashboard_model->get_atc_list();

            foreach ($data['atc_data'] as $atc) {

                $cluster_id = get_cluster_by_atc($atc->atc_id);
                if (is_array($cluster_id)) {
                    $cluster_ids = implode(",", $cluster_id[$atc->atc_id]);
                }

                $atc_screening[$atc->atc_id]['atc_name'] = $atc->atc_name;
                $atc_screening[$atc->atc_id]['atc_id'] = $atc->atc_id;
                $args = array('cluster_id' => $cluster_ids);

                $total_amb = $this->amb_model->get_tdd_total_amb($args);
                $atc_screening[$atc->atc_id]['total_amb'] = $total_amb;

                $on_args = array('amb_status' => '1,2,3,6',
                    'cluster_id' => $cluster_ids);
                $atc_screening[$atc->atc_id]['total_onroad_amb'] = $this->amb_model->get_tdd_total_amb($on_args);
            }
        }

        $data['atc_screening'] = $atc_screening;
        $data['atc_po_linke'] = 'total_ope_amb_po';

        $this->output->add_to_position($this->load->view('frontend/dash/total_ope_amb_atc_view', $data, true), 'content', true);
    }

    function total_ope_amb_po() {

        $data['atc'] = $this->input->post('atc');

        $data['bread_title'] = "Total Operational Ambulance ";
        $data['bread_title_link'] = "total_ope_amb";
        $data['bread_title_link_atc'] = "total_ope_amb_atc";


        $data['cluster_link_atc'] = "total_ope_amb_cluster";

        $args = array('atc_id' => $data['atc']);
        $atc_data = $this->dashboard_model->get_atc_list($args);
        $data['atc_name'] = $atc_data[0]->atc_name;

        $data['po_data'] = $this->dashboard_model->get_po_by_atc_id($data['atc']);

        if ($this->clg->clg_group == 'UG-PRO-OFF') {

            $po_id = $this->clg->clg_po;
            $cluster_id = get_cluster_by_po($atc->po_id);
            if (is_array($cluster_id)) {
                $cluster_ids = implode(",", $cluster_id[$po_id]);
            }

            $po_args = array('po_id' => $po_id);
            $atc_data = $this->dashboard_model->get_auto_po_by_atc_id($po_args);
            $atc = $atc_data[0];

            $atc_screening[$atc->po_id]['po_name'] = $atc->po_name;
            $atc_screening[$atc->po_id]['atc_id'] = $atc->atc_id;
            $atc_screening[$atc->po_id]['po_id'] = $atc->po_id;

            $args = array('cluster_id' => $cluster_ids);

            $total_amb = $this->amb_model->get_tdd_total_amb($args);

            $atc_screening[$atc->po_id]['total_amb'] = $total_amb;

            $on_args = array('amb_status' => '1,2,3,6',
                'cluster_id' => $cluster_ids);
            $atc_screening[$atc->po_id]['total_onroad_amb'] = $this->amb_model->get_tdd_total_amb($on_args);
        } else {
            foreach ($data['po_data'] as $atc) {

                $cluster_id = get_cluster_by_po($atc->po_id);

                $cluster_ids = implode(",", $cluster_id[$atc->po_id]);

                $atc_screening[$atc->po_id]['po_name'] = $atc->po_name;
                $atc_screening[$atc->po_id]['atc_id'] = $atc->atc_id;
                $atc_screening[$atc->po_id]['po_id'] = $atc->po_id;

                $args = array('cluster_id' => $cluster_ids);

                $total_amb = $this->amb_model->get_tdd_total_amb($args);

                $atc_screening[$atc->po_id]['total_amb'] = $total_amb;

                $on_args = array('amb_status' => '1,2,3,6',
                    'cluster_id' => $cluster_ids);
                $atc_screening[$atc->po_id]['total_onroad_amb'] = $this->amb_model->get_tdd_total_amb($on_args);
            }
        }
        $data['atc_screening'] = $atc_screening;
        $this->output->add_to_position($this->load->view('frontend/dash/total_ope_amb_po_view', $data, true), 'content', true);
    }

    function total_ope_amb_cluster() {

        $data['atc'] = $this->input->post('atc');

        $data['po'] = $this->input->post('po');

        $data['bread_title'] = "Total Operational Ambulance ";
        $data['bread_title_link'] = "total_ope_amb";
        $data['bread_title_link_atc'] = "total_ope_amb_atc";
        $data['bread_title_link_po'] = "total_ope_amb_po";

        $data['school_link'] = "total_ope_amb_school";

        $args = array('atc_id' => $data['atc']);
        $atc_data = $this->dashboard_model->get_atc_list($args);
        $data['atc_name'] = $atc_data[0]->atc_name;

        $po_args = array('po_id' => $data['po']);
        $po_data = $this->dashboard_model->get_auto_po_by_atc_id($po_args);
        $data['po_name'] = $po_data[0]->po_name;

        $data['cluter_data'] = $this->dashboard_model->get_cluter_by_po_id($data['po']);

        foreach ($data['cluter_data'] as $atc) {

            $cluster_ids = $atc->cluster_id;

            $atc_screening[$atc->cluster_id]['cluster_name'] = $atc->cluster_name;
            $atc_screening[$atc->cluster_id]['atc_id'] = $atc->atc;
            $atc_screening[$atc->cluster_id]['po_id'] = $atc->po;
            $atc_screening[$atc->cluster_id]['cluster_id'] = $atc->cluster_id;

            $args = array('cluster_id' => $cluster_ids);

            $total_amb = $this->amb_model->get_tdd_total_amb($args);

            $atc_screening[$atc->cluster_id]['total_amb'] = $total_amb;

            $on_args = array('amb_status' => '1,2,3,6',
                'cluster_id' => $cluster_ids);
            $atc_screening[$atc->cluster_id]['total_onroad_amb'] = $this->amb_model->get_tdd_total_amb($on_args);
        }

        $data['atc_screening'] = $atc_screening;


        $this->output->add_to_position($this->load->view('frontend/dash/total_ope_amb_cluster_view', $data, true), 'content', true);
    }

    function total_ope_amb_school() {

        $data['atc'] = $this->input->post('atc');
        $data['po'] = $this->input->post('po');
        $data['cluster_id'] = $this->input->post('cluster_id');

        $args = array('atc_id' => $data['atc']);
        $atc_data = $this->dashboard_model->get_atc_list($args);
        $data['atc_name'] = $atc_data[0]->atc_name;

        $po_args = array('po_id' => $data['po']);
        $po_data = $this->dashboard_model->get_auto_po_by_atc_id($po_args);
        $data['po_name'] = $po_data[0]->po_name;

        $clu_args = array('cluster_id' => $data['cluster_id']);
        $clu_data = $this->cluster_model->get_cluster_data($clu_args);
        $data['cluster_name'] = $clu_data[0]->cluster_name;

        $data['bread_title'] = "Total Operational Ambulance ";
        $data['bread_title_link'] = "total_ope_amb";
        $data['bread_title_link_atc'] = "total_ope_amb_atc";
        $data['bread_title_link_po'] = "total_ope_amb_po";
        $data['link_cluster'] = "total_ope_amb_cluster";

        $data['school_data'] = $this->dashboard_model->get_school_by_cluster_id($data['cluster_id']);
        foreach ($data['school_data'] as $atc) {


            $cluster_ids = $atc->school_id;

            $atc_screening[$atc->school_id]['school_name'] = $atc->school_name;
            $atc_screening[$atc->school_id]['atc_id'] = $data['atc'];
            $atc_screening[$atc->school_id]['po_id'] = $data['po'];
            $atc_screening[$atc->school_id]['cluster_id'] = $atc->cluster_id;
        }

        $data['atc_screening'] = $atc_screening;

        $this->output->add_to_position($this->load->view('frontend/dash/school_view', $data, true), 'content', true);
    }

    function studen_screening_atc() {
        $data['bread_title'] = "Students Screening Status";
        $data['bread_title_link'] = "stud_screen_status";

        if ($this->clg->clg_group == 'UG-ASS-TRI-COM') {

            $atc_id = $this->clg->clg_atc;
            $cluster_id = get_cluster_by_atc($atc_id);

            if (is_array($cluster_id)) {
                $cluster_ids = implode(",", $cluster_id[$atc_id]);
            }

            $atc_args = array('atc_id' => $atc_id);
            $atc_data = $this->dashboard_model->get_atc_list($atc_args);
            $atc = $atc_data[0];

            $atc_screening[$atc->atc_id]['atc_name'] = $atc->atc_name;
            $atc_screening[$atc->atc_id]['atc_id'] = $atc->atc_id;

            $current_date = date('Y-m-d');
            $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);

            $report_args['get_count'] = 'true';
            $today_screening = $this->student_model->get_screening_atc_by_date($report_args);
            $atc_screening[$atc->atc_id]['today_screening'] = $today_screening;

            $current_month = date('m');
            $current_year = date('Y');
            $current_month_date = $current_year . '-' . $current_month . '-01';
            $args = array('from_date' => date('Y-m-d', strtotime($current_month_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);
            $args['get_count'] = 'true';
            $nov_screening = $this->student_model->get_screening_atc_by_date($args);

            $atc_screening[$atc->atc_id]['month_screening'] = $nov_screening;

            $current_month = date('m');
            $current_year = date('Y');
            $current_month_date = $current_year . '-01-01';

            $args = array('from_date' => date('Y-m-d', strtotime($current_month_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);
            $args['get_count'] = 'true';
            $year_total_screening = $this->student_model->get_screening_atc_by_date($args);
            $atc_screening[$atc->atc_id]['year_total_screening'] = $year_total_screening;

            $total_args['get_count'] = 'true';
            $total_args['cluster_id'] = $cluster_ids;
            $total_screening = $this->student_model->get_screening_atc_by_date($total_args);
            $atc_screening[$atc->atc_id]['total_screening'] = $total_screening;
        } else {
            $data['atc_data'] = $this->dashboard_model->get_atc_list();

            foreach ($data['atc_data'] as $atc) {

                $cluster_id = get_cluster_by_atc($atc->atc_id);

                if (is_array($cluster_id)) {
                    $cluster_ids = implode(",", $cluster_id[$atc->atc_id]);
                }


                $atc_screening[$atc->atc_id]['atc_name'] = $atc->atc_name;
                $atc_screening[$atc->atc_id]['atc_id'] = $atc->atc_id;

                $current_date = date('Y-m-d');
                $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids);

                $report_args['get_count'] = 'true';
                $today_screening = $this->student_model->get_screening_atc_by_date($report_args);
                $atc_screening[$atc->atc_id]['today_screening'] = $today_screening;

                $current_month = date('m');
                $current_year = date('Y');
                $current_month_date = $current_year . '-' . $current_month . '-01';
                $args = array('from_date' => date('Y-m-d', strtotime($current_month_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids);
                $args['get_count'] = 'true';
                $nov_screening = $this->student_model->get_screening_atc_by_date($args);

                $atc_screening[$atc->atc_id]['month_screening'] = $nov_screening;

                $current_month = date('m');
                $current_year = date('Y');
                $current_month_date = $current_year . '-01-01';

                $args = array('from_date' => date('Y-m-d', strtotime($current_month_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids);
                $args['get_count'] = 'true';
                $year_total_screening = $this->student_model->get_screening_atc_by_date($args);
                $atc_screening[$atc->atc_id]['year_total_screening'] = $year_total_screening;

                $total_args['get_count'] = 'true';
                $total_args['cluster_id'] = $cluster_ids;
                $total_screening = $this->student_model->get_screening_atc_by_date($total_args);
                $atc_screening[$atc->atc_id]['total_screening'] = $total_screening;
            }
        }
        $data['atc_screening'] = $atc_screening;
        $data['atc_po_linke'] = 'studen_screening_po';
        $data['current_date'] = $current_date;
        $this->output->add_to_position($this->load->view('frontend/dash/studen_screening_atc_view', $data, true), 'content', true);
    }

    function studen_screening_po() {

        $data['atc'] = $this->input->post('atc');

        $args = array('atc_id' => $data['atc']);
        $atc_data = $this->dashboard_model->get_atc_list($args);
        $data['atc_name'] = $atc_data[0]->atc_name;


        $data['po_data'] = $this->dashboard_model->get_po_by_atc_id($data['atc']);

        $current_date = date('Y-m-d');
        $current_month = date('m');
        $current_year = date('Y');

        if ($this->clg->clg_group == 'UG-PRO-OFF') {

            $po_id = $this->clg->clg_po;
            $cluster_id = get_cluster_by_po($atc->po_id);
            if (is_array($cluster_id)) {
                $cluster_ids = implode(",", $cluster_id[$po_id]);
            }

            $po_args = array('po_id' => $po_id);
            $atc_data = $this->dashboard_model->get_auto_po_by_atc_id($po_args);
            $atc = $atc_data[0];

            $atc_screening[$atc->po_id]['po_name'] = $atc->po_name;
            $atc_screening[$atc->po_id]['atc_id'] = $atc->atc_id;
            $atc_screening[$atc->po_id]['po_id'] = $atc->po_id;


            $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);

            $report_args['get_count'] = 'true';

            $today_screening = $this->student_model->get_screening_atc_by_date($report_args);
            // var_dump($today_screening);
            $atc_screening[$atc->po_id]['today_screening'] = $today_screening;


            $current_month_date = $current_year . '-' . $current_month . '-01';
            $args = array('from_date' => date('Y-m-d', strtotime($current_month_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);
            $args['get_count'] = 'true';
            $nov_screening = $this->student_model->get_screening_atc_by_date($args);
            // var_dump($nov_screening);
            $atc_screening[$atc->po_id]['month_screening'] = $nov_screening;


            $current_year_date = $current_year . '-01-01';

            $args = array('from_date' => date('Y-m-d', strtotime($current_year_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);
            $args['get_count'] = 'true';
            $year_total_screening = $this->student_model->get_screening_atc_by_date($args);
            // var_dump($total_screening);
            $atc_screening[$atc->po_id]['year_total_screening'] = $year_total_screening;

            $total_args['get_count'] = 'true';
            $total_args['cluster_id'] = $cluster_ids;
            $total_screening = $this->student_model->get_screening_atc_by_date($total_args);
            // var_dump($total_screening);
            $atc_screening[$atc->po_id]['total_screening'] = $total_screening;
        } else {
            foreach ($data['po_data'] as $atc) {

                $cluster_id = get_cluster_by_po($atc->po_id);

                $cluster_ids = implode(",", $cluster_id[$atc->po_id]);

                $atc_screening[$atc->po_id]['po_name'] = $atc->po_name;
                $atc_screening[$atc->po_id]['atc_id'] = $atc->atc_id;
                $atc_screening[$atc->po_id]['po_id'] = $atc->po_id;


                $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids);

                $report_args['get_count'] = 'true';

                $today_screening = $this->student_model->get_screening_atc_by_date($report_args);
                // var_dump($today_screening);
                $atc_screening[$atc->po_id]['today_screening'] = $today_screening;


                $current_month_date = $current_year . '-' . $current_month . '-01';
                $args = array('from_date' => date('Y-m-d', strtotime($current_month_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids);
                $args['get_count'] = 'true';
                $nov_screening = $this->student_model->get_screening_atc_by_date($args);
                // var_dump($nov_screening);
                $atc_screening[$atc->po_id]['month_screening'] = $nov_screening;


                $current_year_date = $current_year . '-01-01';

                $args = array('from_date' => date('Y-m-d', strtotime($current_year_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids);
                $args['get_count'] = 'true';
                $year_total_screening = $this->student_model->get_screening_atc_by_date($args);
                // var_dump($total_screening);
                $atc_screening[$atc->po_id]['year_total_screening'] = $year_total_screening;

                $total_args['get_count'] = 'true';
                $total_args['cluster_id'] = $cluster_ids;
                $total_screening = $this->student_model->get_screening_atc_by_date($total_args);
                // var_dump($total_screening);
                $atc_screening[$atc->po_id]['total_screening'] = $total_screening;
            }
        }

        $data['atc_screening'] = $atc_screening;

        $data['bread_title'] = "Students Screening Status";
        $data['bread_title_link'] = "stud_screen_status";
        $data['bread_title_link_atc'] = "studen_screening_atc";

        $data['cluster_link_atc'] = "studen_screening_cluster";
        $data['current_date'] = $current_date;

        $this->output->add_to_position($this->load->view('frontend/dash/studen_screening_po_view', $data, true), 'content', true);
    }

    function studen_screening_cluster() {

        $data['atc'] = $this->input->post('atc');

        $data['po'] = $this->input->post('po');

        $args = array('atc_id' => $data['atc']);
        $atc_data = $this->dashboard_model->get_atc_list($args);
        $data['atc_name'] = $atc_data[0]->atc_name;

        $po_args = array('po_id' => $data['po']);
        $po_data = $this->dashboard_model->get_auto_po_by_atc_id($po_args);
        $data['po_name'] = $po_data[0]->po_name;

        $data['cluter_data'] = $this->dashboard_model->get_cluter_by_po_id($data['po']);

        $current_month = date('m');
        $current_year = date('Y');
        $current_date = date('Y-m-d');

        foreach ($data['cluter_data'] as $atc) {


            $cluster_ids = $atc->cluster_id;

            $atc_screening[$atc->cluster_id]['cluster_name'] = $atc->cluster_name;
            $atc_screening[$atc->cluster_id]['atc_id'] = $atc->atc;
            $atc_screening[$atc->cluster_id]['po_id'] = $atc->po;
            $atc_screening[$atc->cluster_id]['cluster_id'] = $atc->cluster_id;


            $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);

            $report_args['get_count'] = 'true';
            $today_screening = $this->student_model->get_screening_atc_by_date($report_args);
            $atc_screening[$atc->cluster_id]['today_screening'] = $today_screening;


            $current_month_date = $current_year . '-' . $current_month . '-01';
            $args = array('from_date' => date('Y-m-d', strtotime($current_month_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);
            $args['get_count'] = 'true';
            $nov_screening = $this->student_model->get_screening_atc_by_date($args);
            $atc_screening[$atc->cluster_id]['month_screening'] = $nov_screening;

            $current_month_date = $current_year . '-01-01';
            $args = array('from_date' => date('Y-m-d', strtotime($current_month_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);
            $args['get_count'] = 'true';
            $total_screening = $this->student_model->get_screening_atc_by_date($args);
            $atc_screening[$atc->cluster_id]['year_total_screening'] = $total_screening;

            $total_args['get_count'] = 'true';
            $total_args['cluster_id'] = $cluster_ids;
            $total_screening = $this->student_model->get_screening_atc_by_date($total_args);
            $atc_screening[$atc->cluster_id]['total_screening'] = $total_screening;
        }

        $data['atc_screening'] = $atc_screening;

        $data['bread_title'] = "Students Screening Status";
        $data['bread_title_link'] = "stud_screen_status";
        $data['bread_title_link_atc'] = "studen_screening_atc";
        $data['bread_title_link_po'] = "studen_screening_po";

        $data['school_link'] = "studen_screening_school";
        $data['current_date'] = $current_date;

        $this->output->add_to_position($this->load->view('frontend/dash/studen_screening_cluster_view', $data, true), 'content', true);
    }

    function studen_screening_school() {

        $data['atc'] = $this->input->post('atc');
        $data['po'] = $this->input->post('po');
        $data['cluster_id'] = $this->input->post('cluster_id');

        $args = array('atc_id' => $data['atc']);
        $atc_data = $this->dashboard_model->get_atc_list($args);
        $data['atc_name'] = $atc_data[0]->atc_name;

        $po_args = array('po_id' => $data['po']);
        $po_data = $this->dashboard_model->get_auto_po_by_atc_id($po_args);
        $data['po_name'] = $po_data[0]->po_name;

        $clu_args = array('cluster_id' => $data['cluster_id']);
        $clu_data = $this->cluster_model->get_cluster_data($clu_args);
        $data['cluster_name'] = $clu_data[0]->cluster_name;


        $data['school_data'] = $this->dashboard_model->get_school_by_cluster_id($data['cluster_id']);

        $current_date = date('Y-m-d');
        $current_month = date('m');
        $current_year = date('Y');

        foreach ($data['school_data'] as $atc) {


            $cluster_ids = $atc->school_id;

            $atc_screening[$atc->school_id]['school_name'] = $atc->school_name;
            $atc_screening[$atc->school_id]['atc_id'] = $data['atc'];
            $atc_screening[$atc->school_id]['po_id'] = $data['po'];
            $atc_screening[$atc->school_id]['cluster_id'] = $atc->cluster_id;


            $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'school_id' => $cluster_ids);

            $report_args['get_count'] = 'true';
            $today_screening = $this->student_model->get_screening_atc_by_date($report_args);
            $atc_screening[$atc->school_id]['today_screening'] = $today_screening;


            $current_month_date = $current_year . '-' . $current_month . '-01';
            $args = array('from_date' => date('Y-m-d', strtotime($current_month_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'school_id' => $cluster_ids);
            $args['get_count'] = 'true';
            $nov_screening = $this->student_model->get_screening_atc_by_date($args);
            $atc_screening[$atc->school_id]['month_screening'] = $nov_screening;

            $current_month_date = $current_year . '-' . $current_month . '-01';
            $args = array('from_date' => date('Y-m-d', strtotime($current_month_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'school_id' => $cluster_ids);
            $args['get_count'] = 'true';
            $total_screening = $this->student_model->get_screening_atc_by_date($args);
            $atc_screening[$atc->school_id]['year_total_screening'] = $total_screening;

            $total_args['get_count'] = 'true';
            $total_args['school_id'] = $cluster_ids;
            $total_screening = $this->student_model->get_screening_atc_by_date($total_args);
            $atc_screening[$atc->school_id]['total_screening'] = $total_screening;
        }

        $data['atc_screening'] = $atc_screening;

        $data['bread_title'] = "Students Screening Status";
        $data['bread_title_link'] = "stud_screen_status";
        $data['bread_title_link_atc'] = "studen_screening_atc";
        $data['bread_title_link_po'] = "studen_screening_po";
        $data['link_cluster'] = "studen_screening_cluster";
        $data['current_date'] = $current_date;

        $this->output->add_to_position($this->load->view('frontend/dash/studen_screening_school_view', $data, true), 'content', true);
    }

    function sick_room_attends() {

        $current_date = date('Y-m-d');
        $current_month = date('m');
        $current_year = date('Y');


        $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
            'to_date' => date('Y-m-d', strtotime($current_date)),
            'rec_hospital_name' => 'sickroom');

        $report_data = $this->inc_model->get_epcr_by_cluster($report_args);
        $data['today_sickroom'] = count($report_data);


        $current_month_date = $current_year . '-' . $current_month . '-01';
        $month_report_args = array('from_date' => date('Y-m-d', strtotime($current_month_date)),
            'to_date' => date('Y-m-d', strtotime($current_date)),
            'rec_hospital_name' => 'sickroom');

        $month_report_data = $this->inc_model->get_epcr_by_cluster($month_report_args);
        $data['month_sickroom'] = count($month_report_data);


        $current_year_date = $current_year . '-01-01';
        $years_args = array('from_date' => date('Y-m-d', strtotime($current_year_date)),
            'to_date' => date('Y-m-d', strtotime($current_date)),
            'rec_hospital_name' => 'sickroom');

        $year_report_data = $this->inc_model->get_epcr_by_cluster($years_args);
        $data['year_sickroom'] = count($year_report_data);


        $total_args['rec_hospital_name'] = 'sickroom';
        $total_sickroomt_data = $this->inc_model->get_epcr_by_cluster($total_args);
        $data['total_sickroom'] = count($total_sickroomt_data);
        $data['current_date'] = $current_date;

        $data['bread_title_link_atc'] = "sick_room_atnd_atc";

        $this->output->add_to_position($this->load->view('frontend/dash/sick_room_attends_view', $data, true), 'content', true);
    }

    function sick_room_atnd_atc() {
        $data['bread_title'] = "Sick Room Attendance ";
        $data['bread_title_link'] = "sick_room_attends";
        $data['bread_title_link_atc'] = "sick_room_atnd_atc";

        $current_date = date('Y-m-d');
        $current_month = date('m');
        $current_year = date('Y');

        $data['atc_data'] = $this->dashboard_model->get_atc_list();

        foreach ($data['atc_data'] as $atc) {

            $cluster_id = get_cluster_by_atc($atc->atc_id);
            if (is_array($cluster_id)) {
                $cluster_ids = implode(",", $cluster_id[$atc->atc_id]);
            }

            $atc_screening[$atc->atc_id]['atc_name'] = $atc->atc_name;
            $atc_screening[$atc->atc_id]['atc_id'] = $atc->atc_id;

            $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids,
                'rec_hospital_name' => 'sickroom');

            $report_data = $this->inc_model->get_epcr_by_cluster($report_args);
            $atc_screening[$atc->atc_id]['today_sickroom'] = count($report_data);

            $current_month_date = $current_year . '-' . $current_month . '-01';
            $month_report_args = array('from_date' => date('Y-m-d', strtotime($current_month_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids,
                'rec_hospital_name' => 'sickroom');

            $month_report_data = $this->inc_model->get_epcr_by_cluster($month_report_args);
            $atc_screening[$atc->atc_id]['month_sickroom'] = count($month_report_data);


            $current_year_date = $current_year . '-01-01';
            $years_args = array('from_date' => date('Y-m-d', strtotime($current_year_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids,
                'rec_hospital_name' => 'sickroom');

            $year_data = $this->inc_model->get_epcr_by_cluster($years_args);
            $atc_screening[$atc->atc_id]['year_sickroom'] = count($year_data);


            $total['cluster_id'] = $cluster_ids;
            $total['rec_hospital_name'] = 'sickroom';
            $total_data = $this->inc_model->get_epcr_by_cluster($total);
            $atc_screening[$atc->atc_id]['total_sickroom'] = count($total_data);
        }
        $data['atc_screening'] = $atc_screening;
        $data['atc_po_linke'] = 'sick_room_po';
        $data['current_date'] = $current_date;

        $this->output->add_to_position($this->load->view('frontend/dash/sick_room_atnd_atc_view', $data, true), 'content', true);
    }

    function sick_room_po() {

        $data['atc'] = $this->input->post('atc');

        $current_date = date('Y-m-d');
        $curent_month = date('m');
        $current_year = date('Y');

        $data['bread_title'] = "Sick Room Attendance ";
        $data['bread_title_link'] = "sick_room_attends";
        $data['bread_title_link_atc'] = "sick_room_atnd_atc";

        $data['cluster_link_atc'] = "sick_room_cluster";

        $args = array('atc_id' => $data['atc']);
        $atc_data = $this->dashboard_model->get_atc_list($args);
        $data['atc_name'] = $atc_data[0]->atc_name;

        $data['po_data'] = $this->dashboard_model->get_po_by_atc_id($data['atc']);

        foreach ($data['po_data'] as $atc) {

            $cluster_id = get_cluster_by_po($atc->po_id);

            $cluster_ids = implode(",", $cluster_id[$atc->po_id]);
            //var_dump($cluster_ids);


            $atc_screening[$atc->po_id]['po_name'] = $atc->po_name;
            $atc_screening[$atc->po_id]['atc_id'] = $atc->atc_id;
            $atc_screening[$atc->po_id]['po_id'] = $atc->po_id;

            $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids,
                'rec_hospital_name' => 'sickroom');

            $report_data = $this->inc_model->get_epcr_by_cluster($report_args);
            $atc_screening[$atc->po_id]['today_sickroom'] = count($report_data);



            $current_month_date = $current_year . '-' . $curent_month . '-01';


            $month_report_args = array('from_date' => date('Y-m-d', strtotime($current_month_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids,
                'rec_hospital_name' => 'sickroom');



            $month_report_data = $this->inc_model->get_epcr_by_cluster($month_report_args);
            $atc_screening[$atc->po_id]['month_sickroom'] = count($month_report_data);


            $current_year_date = $current_year . '-01-01';
            $years_args = array('from_date' => date('Y-m-d', strtotime($current_year_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids,
                'rec_hospital_name' => 'sickroom');

            $year_data = $this->inc_model->get_epcr_by_cluster($years_args);
            $atc_screening[$atc->po_id]['year_sickroom'] = count($year_data);


            $total['cluster_id'] = $cluster_ids;
            $total['rec_hospital_name'] = 'sickroom';
            $total_data = $this->inc_model->get_epcr_by_cluster($total);
            $atc_screening[$atc->po_id]['total_sickroom'] = count($total_data);
        }

        $data['atc_screening'] = $atc_screening;
        $data['current_date'] = $current_date;

        $this->output->add_to_position($this->load->view('frontend/dash/sick_room_atnd_po_view', $data, true), 'content', true);
    }

    function sick_room_cluster() {

        $data['atc'] = $this->input->post('atc');

        $data['po'] = $this->input->post('po');

        $data['bread_title'] = "Sick Room Attendance ";
        $data['bread_title_link'] = "sick_room_attends";
        $data['bread_title_link_atc'] = "sick_room_atnd_atc";
        $data['bread_title_link_po'] = "sick_room_po";

        $data['school_link'] = "sick_room_school";

        $current_date = date('Y-m-d');
        $current_month = date('m');
        $current_year = date('Y');

        $args = array('atc_id' => $data['atc']);
        $atc_data = $this->dashboard_model->get_atc_list($args);
        $data['atc_name'] = $atc_data[0]->atc_name;

        $po_args = array('po_id' => $data['po']);
        $po_data = $this->dashboard_model->get_auto_po_by_atc_id($po_args);
        $data['po_name'] = $po_data[0]->po_name;

        $data['cluter_data'] = $this->dashboard_model->get_cluter_by_po_id($data['po']);

        foreach ($data['cluter_data'] as $atc) {

            $cluster_ids = $atc->cluster_id;

            $atc_screening[$atc->cluster_id]['cluster_name'] = $atc->cluster_name;
            $atc_screening[$atc->cluster_id]['atc_id'] = $atc->atc;
            $atc_screening[$atc->cluster_id]['po_id'] = $atc->po;
            $atc_screening[$atc->cluster_id]['cluster_id'] = $atc->cluster_id;

            $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids,
                'rec_hospital_name' => 'sickroom');

            $report_data = $this->inc_model->get_epcr_by_cluster($report_args);
            $atc_screening[$atc->cluster_id]['today_sickroom'] = count($report_data);


            $current_month_date = $current_year . '-' . $current_month . '-01';
            $month_report_args = array('from_date' => date('Y-m-d', strtotime($current_month_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids,
                'rec_hospital_name' => 'sickroom');

            $month_report_data = $this->inc_model->get_epcr_by_cluster($month_report_args);
            $atc_screening[$atc->cluster_id]['month_sickroom'] = count($month_report_data);


            $current_year_date = $current_year . '-01-01';
            $years_args = array('from_date' => date('Y-m-d', strtotime($current_year_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids,
                'rec_hospital_name' => 'sickroom');

            $year_sickroom = $this->inc_model->get_epcr_by_cluster($years_args);
            $atc_screening[$atc->cluster_id]['year_sickroom'] = count($year_sickroom);


            $total['cluster_id'] = $cluster_ids;
            $total['rec_hospital_name'] = 'sickroom';
            $total_sickroom = $this->inc_model->get_epcr_by_cluster($total);
            $atc_screening[$atc->cluster_id]['total_sickroom'] = count($total_sickroom);
        }

        $data['atc_screening'] = $atc_screening;
        $data['current_date'] = $current_date;

        $this->output->add_to_position($this->load->view('frontend/dash/sick_room_atnd_cluster_view', $data, true), 'content', true);
    }

    function sick_room_school() {

        $data['atc'] = $this->input->post('atc');
        $data['po'] = $this->input->post('po');
        $data['cluster_id'] = $this->input->post('cluster_id');

        $args = array('atc_id' => $data['atc']);
        $atc_data = $this->dashboard_model->get_atc_list($args);
        $data['atc_name'] = $atc_data[0]->atc_name;

        $po_args = array('po_id' => $data['po']);
        $po_data = $this->dashboard_model->get_auto_po_by_atc_id($po_args);
        $data['po_name'] = $po_data[0]->po_name;

        $clu_args = array('cluster_id' => $data['cluster_id']);
        $clu_data = $this->cluster_model->get_cluster_data($clu_args);
        $data['cluster_name'] = $clu_data[0]->cluster_name;

        $data['bread_title'] = "Sick Room Attendance ";
        $data['bread_title_link'] = "sick_room_attends";
        $data['bread_title_link_atc'] = "sick_room_atc";
        $data['bread_title_link_po'] = "sick_room_po";
        $data['link_cluster'] = "sick_room_cluster";

        $data['school_data'] = $this->dashboard_model->get_school_by_cluster_id($data['cluster_id']);

        foreach ($data['school_data'] as $atc) {


            $cluster_ids = $atc->school_id;

            $atc_screening[$atc->school_id]['school_name'] = $atc->school_name;
            $atc_screening[$atc->school_id]['atc_id'] = $data['atc'];
            $atc_screening[$atc->school_id]['po_id'] = $data['po'];
            $atc_screening[$atc->school_id]['cluster_id'] = $atc->cluster_id;
        }

        $data['current_date'] = $current_date;
        $this->output->add_to_position($this->load->view('frontend/dash/sick_room_atnd_school_view', $data, true), 'content', true);
    }

    function chronic_condition_status() {


        $current_date = date('Y-m-d');
        // $current_date =  date('2018-12-31');
        $current_months = date('m');
        $current_years = date('Y');
//            $current_month = 12;
//            $current_year= 2018;

        $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
            'to_date' => date('Y-m-d', strtotime($current_date)),
        );

        $today_screening_data = $this->student_model->get_screening_atc_by_date($report_args);
//            $data['birth_defect'] =0;
//            $data['deficiencies'] =0;
//            $data['childhood_disease']=0;
//            
//             $data['today']['ent_check_if_present'] =0;
//             $data['current_month']['ent_check_if_present'] =0;
//             $data['current_year']['ent_check_if_present'] =0;
//             $data['total_screening']['ent_check_if_present'] =0;
//             
//             $data['today']['opthalmological'] =0;
//             $data['current_month']['opthalmological'] =0;
//             $data['current_year']['opthalmological'] =0;
//             $data['total_screening']['opthalmological'] =0;

        foreach ($today_screening_data as $today_screening) {

            $birth_defect = json_decode($today_screening->birth_deffects);
            $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13');


            if (is_array($birth_defect)) {

                if (array_intersect($birth_defect_ids, $birth_defect)) {
                    $data['today']['birth_defect'] = $data['today']['birth_defect'] + 1;
                }
            }

            $childhood_disease = json_decode($today_screening->childhood_disease);
            $childhood_disease_ids = array('3', '4', '13', '17', '15', '14', '18');

            if (is_array($childhood_disease)) {

                if (array_intersect($childhood_disease_ids, $childhood_disease)) {
                    $data['today']['childhood_disease'] = $data['today']['childhood_disease'] + 1;
                }
            }

            $today_screening->deficiencies;
            $deficiencies = json_decode($today_screening->deficiencies);
            $childhood_disease_ids = array('3', '5', '6', '8', '10');

            if (is_array($deficiencies)) {

                if (array_intersect($childhood_disease_ids, $deficiencies)) {
                    $data['today']['deficiencies'] = $data['today']['deficiencies'] + 1;
                }
            }

            $today_screening->skin_condition;
            $skin_condition = json_decode($today_screening->skin_condition);
            $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18');

            if (is_array($skin_condition)) {

                if (array_intersect($childhood_disease_ids, $skin_condition)) {
                    $data['today']['skin_condition'] = $data['today']['skin_condition'] + 1;
                }
            }

            $today_screening->orthopedics;
            $today_screening->diagnosis;
            $today_screening->checkbox_if_normal;
        }

        $today_ent_data = $this->student_model->get_ent_atc_by_date($report_args);
        foreach ($today_ent_data as $today_ent) {
            $ent_check_if_present = json_decode($today_ent->ent_check_if_present);
            $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16');

            if (is_array($ent_check_if_present)) {

                if (array_intersect($birth_defect_ids, $ent_check_if_present)) {
                    $data['today']['ent_check_if_present'] = $data['today']['ent_check_if_present'] + 1;
                }
            }
        }

        $today_opthalmological = $this->student_model->get_vision_atc_by_date($report_args);
        foreach ($today_opthalmological as $today_opthalmological) {
            $opthalmological = json_decode($today_opthalmological->opthalmological);
            $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11');

            if (is_array($opthalmological)) {

                if (array_intersect($birth_defect_ids, $opthalmological)) {
                    $data['today']['opthalmological'] = $data['today']['opthalmological'] + 1;
                }
            }
        }

        $current_month_start_date = $current_years . '-' . $current_months . '-01';
        $report_args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
            'to_date' => date('Y-m-d', strtotime($current_date)),
        );

        $current_month_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

        foreach ($current_month_screening_data as $current_month_data) {

            $birth_defect = json_decode($current_month_data->birth_deffects);
            $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13');

            if (is_array($birth_defect)) {

                if (array_intersect($birth_defect_ids, $birth_defect)) {
                    $data['current_month']['birth_defect'] = $data['current_month']['birth_defect'] + 1;
                }
            }

            $childhood_disease = json_decode($current_month_data->childhood_disease);
            $childhood_disease_ids = array('3', '4', '13', '17', '15', '14', '18');

            if (is_array($childhood_disease)) {

                if (array_intersect($childhood_disease_ids, $childhood_disease)) {
                    $data['current_month']['childhood_disease'] = $data['current_month']['childhood_disease'] + 1;
                }
            }


            $deficiencies = json_decode($current_month_data->deficiencies);
            $childhood_disease_ids = array('3', '5', '6', '8', '10');

            if (is_array($deficiencies)) {

                if (array_intersect($childhood_disease_ids, $deficiencies)) {
                    $data['current_month']['deficiencies'] = $data['current_month']['deficiencies'] + 1;
                }
            }


            $skin_condition = json_decode($current_month_data->skin_condition);
            $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18');

            if (is_array($skin_condition)) {

                if (array_intersect($childhood_disease_ids, $skin_condition)) {
                    $data['current_month']['skin_condition'] = $data['current_month']['skin_condition'] + 1;
                }
            }
        }

        $current_month_ent_data = $this->student_model->get_ent_atc_by_date($report_args);
        foreach ($current_month_ent_data as $current_month_ent) {
            $ent_check_if_present = json_decode($current_month_ent->ent_check_if_present);
            $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16');

            if (is_array($ent_check_if_present)) {

                if (array_intersect($birth_defect_ids, $ent_check_if_present)) {
                    $data['current_month']['ent_check_if_present'] = $data['current_month']['ent_check_if_present'] + 1;
                }
            }
        }

        $current_month_opthalmological = $this->student_model->get_vision_atc_by_date($report_args);

        foreach ($current_month_opthalmological as $month_opthalmological) {
            $opthalmological = json_decode($month_opthalmological->opthalmological);
            $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11');

            if (is_array($opthalmological)) {

                if (array_intersect($birth_defect_ids, $opthalmological)) {
                    $data['current_month']['opthalmological'] = $data['current_month']['opthalmological'] + 1;
                }
            }
        }

        $current_years_date = $current_years . '-01-01';
        $report_args = array('from_date' => date('Y-m-d', strtotime($current_years_date)),
            'to_date' => date('Y-m-d', strtotime($current_date)),
        );

        $years_screening_data = $this->student_model->get_screening_atc_by_date($report_args);
        foreach ($years_screening_data as $current_year_data) {

            $birth_defect = json_decode($current_year_data->birth_deffects);
            $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13');

            if (is_array($birth_defect)) {

                if (array_intersect($birth_defect_ids, $birth_defect)) {
                    $data['current_year']['birth_defect'] = $data['current_year']['birth_defect'] + 1;
                }
            }

            $childhood_disease = json_decode($current_year_data->childhood_disease);
            $childhood_disease_ids = array('3', '4', '13', '17', '15', '14', '18');

            if (is_array($childhood_disease)) {

                if (array_intersect($childhood_disease_ids, $childhood_disease)) {
                    $data['current_year']['childhood_disease'] = $data['current_year']['childhood_disease'] + 1;
                }
            }

            $deficiencies = json_decode($current_year_data->deficiencies);
            $childhood_disease_ids = array('3', '5', '6', '8', '10');

            if (is_array($deficiencies)) {

                if (array_intersect($childhood_disease_ids, $deficiencies)) {
                    $data['current_year']['deficiencies'] = $data['current_year']['deficiencies'] + 1;
                }
            }

            $current_month->skin_condition;
            $skin_condition = json_decode($current_year_data->skin_condition);
            $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18');

            if (is_array($skin_condition)) {

                if (array_intersect($childhood_disease_ids, $skin_condition)) {
                    $data['current_year']['skin_condition'] = $data['current_year']['skin_condition'] + 1;
                }
            }
        }

        $current_year_ent_data = $this->student_model->get_ent_atc_by_date($report_args);
        foreach ($current_year_ent_data as $current_year_ent) {
            $ent_check_if_present = json_decode($current_year_ent->ent_check_if_present);
            $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16');

            if (is_array($ent_check_if_present)) {

                if (in_array($birth_defect_ids, $ent_check_if_present)) {
                    $data['current_year']['ent_check_if_present'] = $data['current_year']['ent_check_if_present'] + 1;
                }
            }
        }

        $current_year_ent_data = $this->student_model->get_vision_atc_by_date($report_args);
        foreach ($current_year_ent_data as $current_year_ent) {
            $ent_check_if_present = json_decode($current_year_ent->opthalmological);
            $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11');

            if (is_array($ent_check_if_present)) {

                if (in_array($birth_defect_ids, $ent_check_if_present)) {
                    $data['current_year']['opthalmological'] = $data['current_year']['opthalmological'] + 1;
                }
            }
        }
        //var_dump($data);

        $total_screening_data = $this->student_model->get_screening_atc_by_date();
        foreach ($total_screening_data as $total_screening) {

            $birth_defect = json_decode($total_screening->birth_deffects);
            $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13');

            if (is_array($birth_defect)) {

                if (array_intersect($birth_defect_ids, $birth_defect)) {
                    $data['total_screening']['birth_defect'] = $data['total_screening']['birth_defect'] + 1;
                }
            }


            $childhood_disease = json_decode($total_screening->childhood_disease);
            $childhood_disease_ids = array('3', '4', '13', '17', '15', '14', '18');

            if (is_array($childhood_disease)) {

                if (array_intersect($childhood_disease_ids, $childhood_disease)) {
                    $data['total_screening']['childhood_disease'] = $data['total_screening']['childhood_disease'] + 1;
                }
            }

            $total_screening->deficiencies;
            $deficiencies = json_decode($total_screening->deficiencies);
            $childhood_disease_ids = array('3', '5', '6', '8', '10');

            if (is_array($deficiencies)) {

                if (array_intersect($childhood_disease_ids, $deficiencies)) {
                    $data['total_screening']['deficiencies'] = $data['total_screening']['deficiencies'] + 1;
                }
            }

            $total_screening->skin_condition;
            $skin_condition = json_decode($total_screening->skin_condition);
            $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18');

            if (is_array($skin_condition)) {

                if (array_intersect($childhood_disease_ids, $skin_condition)) {
                    $data['total_screening']['skin_condition'] = $data['total_screening']['skin_condition'] + 1;
                }
            }

            $total_screening->orthopedics;
            $total_screening->diagnosis;
            $total_screening->checkbox_if_normal;
        }

        $total_ent_data = $this->student_model->get_ent_atc_by_date($report_args);
        foreach ($total_ent_data as $total_ent) {
            $ent_check_if_present = json_decode($total_ent->ent_check_if_present);
            $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16');

            if (is_array($ent_check_if_present)) {

                if (array_intersect($birth_defect_ids, $ent_check_if_present)) {
                    $data['total_screening']['ent_check_if_present'] = $data['total_screening']['ent_check_if_present'] + 1;
                }
            }
        }

        $total_ent_data = $this->student_model->get_vision_atc_by_date($report_args);
        foreach ($total_ent_data as $total_ent) {
            $ent_check_if_present = json_decode($total_ent->opthalmological);
            $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11');

            if (is_array($ent_check_if_present)) {

                if (array_intersect($birth_defect_ids, $ent_check_if_present)) {
                    $data['total_screening']['opthalmological'] = $data['total_screening']['opthalmological'] + 1;
                }
            }
        }



        $data['current_date'] = $current_date;
        $this->output->add_to_position($this->load->view('frontend/dash/chronic_condition_status_view', $data, true), 'content', true);
    }

    function chronic_birth_defects() {
        $data['action'] = $this->input->post('action');
        // var_dump($data);
        if ($data['action'] == 'chronic_birth_defects') {
            
        }
    }

    function chronic_condition_atc() {

        $data['action'] = $this->input->post('action');
        $data['bread_title'] = "Chronic Conditions Status ";
        $data['bread_title_link'] = "chronic_condition_status";
        $data['atc_data'] = $this->dashboard_model->get_atc_list();

        $current_date = date('Y-m-d');
        $current_months = date('m');
        $current_years = date('Y');

        $data['atc_po_linke'] = 'chronic_condition_po';

        $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
            'to_date' => date('Y-m-d', strtotime($current_date)));


        $data['atc_data'] = $this->dashboard_model->get_atc_list();

        foreach ($data['atc_data'] as $atc) {

            $cluster_id = get_cluster_by_atc($atc->atc_id);
            if (is_array($cluster_id)) {
                $cluster_ids = implode(",", $cluster_id[$atc->atc_id]);
            }

            $atc_screening[$atc->atc_id]['atc_name'] = $atc->atc_name;
            $atc_screening[$atc->atc_id]['atc_id'] = $atc->atc_id;
            // $report_args['cluster_id'] = $cluster_ids;



            if ($data['action'] == 'chronic_birth_defects') {

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );
                $today_screening_data = $this->student_model->get_screening_atc_by_date($report_args);
                foreach ($today_screening_data as $today_screening) {

                    $birth_defect = json_decode($today_screening->birth_deffects);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13');

                    if (is_array($birth_defect)) {
                        if (array_intersect($birth_defect_ids, $birth_defect)) {
                            $atc_screening[$atc->atc_id]['today']['birth_defect'] = $atc_screening[$atc->atc_id]['today']['birth_defect'] + 1;
                        }
                    }
                }

                $current_month_start_date = $current_years . '-' . $current_months . '-01';

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $current_month_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($current_month_screening_data as $current_month_data) {

                    $birth_defect = json_decode($current_month_data->birth_deffects);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13');

                    if (is_array($birth_defect)) {

                        if (array_intersect($birth_defect_ids, $birth_defect)) {
                            $atc_screening[$atc->atc_id]['current_month']['birth_defect'] = $atc_screening[$atc->atc_id]['current_month']['birth_defect'] + 1;
                        }
                    }
                }


                $current_years_date = $current_years . '-01-01';
                $report_args = array('from_date' => date('Y-m-d', strtotime($current_years_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $years_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($years_screening_data as $current_year_data) {

                    $birth_defect = json_decode($current_year_data->birth_deffects);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13');

                    if (is_array($birth_defect)) {

                        if (array_intersect($birth_defect_ids, $birth_defect)) {

                            $atc_screening[$atc->atc_id]['current_year']['birth_defect'] = $atc_screening[$atc->atc_id]['current_year']['birth_defect'] + 1;
                        }
                    }
                }


                $args = array('cluster_id' => $cluster_ids);
                $total_screening_data = $this->student_model->get_screening_atc_by_date($args);
                foreach ($total_screening_data as $total_screening) {

                    $birth_defect = json_decode($total_screening->birth_deffects);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13');

                    if (is_array($birth_defect)) {

                        if (array_intersect($birth_defect_ids, $birth_defect)) {
                            $atc_screening[$atc->atc_id]['total_screening']['birth_defect'] = $atc_screening[$atc->atc_id]['total_screening']['birth_defect'] + 1;
                        }
                    }
                }
            }

            if ($data['action'] == 'deficiencies') {

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );
                $today_screening_data = $this->student_model->get_screening_atc_by_date($report_args);
                foreach ($today_screening_data as $today_screening) {

                    $deficiencies = json_decode($today_screening->deficiencies);
                    $childhood_disease_ids = array('3', '5', '6', '8', '10');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->atc_id]['today']['deficiencies'] = $atc_screening[$atc->atc_id]['today']['deficiencies'] + 1;
                        }
                    }
                }

                $current_month_start_date = $current_years . '-' . $current_months . '-01';

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $current_month_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($current_month_screening_data as $current_month_data) {

                    $current_month->deficiencies;
                    $deficiencies = json_decode($current_month->deficiencies);
                    $childhood_disease_ids = array('3', '5', '6', '8', '10');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->atc_id]['current_month']['deficiencies'] = $atc_screening[$atc->atc_id]['current_month']['deficiencies'] + 1;
                        }
                    }
                }


                $current_years_date = $current_years . '-01-01';
                $report_args = array('from_date' => date('Y-m-d', strtotime($current_years_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $years_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($years_screening_data as $current_year) {


                    $deficiencies = json_decode($current_year->deficiencies);
                    $childhood_disease_ids = array('3', '5', '6', '8', '10');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->atc_id]['current_year']['deficiencies'] = $atc_screening[$atc->atc_id]['current_year']['deficiencies'] + 1;
                        }
                    }
                }


                $args = array('cluster_id' => $cluster_ids);
                $total_screening_data = $this->student_model->get_screening_atc_by_date($args);
                foreach ($total_screening_data as $total_screening) {

                    $deficiencies = json_decode($total_screening->deficiencies);
                    $childhood_disease_ids = array('3', '5', '6', '8', '10');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->atc_id]['total_screening']['deficiencies'] = $atc_screening[$atc->atc_id]['total_screening']['deficiencies'] + 1;
                        }
                    }
                }
            }

            if ($data['action'] == 'skin_condition') {

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );
                $today_screening_data = $this->student_model->get_screening_atc_by_date($report_args);
                foreach ($today_screening_data as $today_screening) {

                    $deficiencies = json_decode($today_screening->skin_condition);
                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->atc_id]['today']['skin_condition'] = $atc_screening[$atc->atc_id]['today']['skin_condition'] + 1;
                        }
                    }
                }

                $current_month_start_date = $current_years . '-' . $current_months . '-01';

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $current_month_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($current_month_screening_data as $current_month_data) {

                    $month_skin_condition = json_decode($current_month_data->skin_condition);
                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18');

                    if (is_array($month_skin_condition)) {

                        if (array_intersect($childhood_disease_ids, $month_skin_condition)) {
                            $atc_screening[$atc->atc_id]['current_month']['skin_condition'] = $atc_screening[$atc->atc_id]['current_month']['skin_condition'] + 1;
                        }
                    }
                }


                $current_years_date = $current_years . '-01-01';
                $report_args = array('from_date' => date('Y-m-d', strtotime($current_years_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $years_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($years_screening_data as $current_year_data) {


                    $deficiencies = json_decode($current_year_data->skin_condition);
                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->atc_id]['current_year']['skin_condition'] = $atc_screening[$atc->atc_id]['current_year']['skin_condition'] + 1;
                        }
                    }
                }


                $args = array('cluster_id' => $cluster_ids);
                $total_screening_data = $this->student_model->get_screening_atc_by_date($args);
                foreach ($total_screening_data as $total_screenings) {

                    $total_skin_condition = json_decode($total_screenings->skin_condition);

                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18');

                    if (is_array($total_skin_condition)) {

                        if (array_intersect($childhood_disease_ids, $total_skin_condition)) {
                            $atc_screening[$atc->atc_id]['total_screening']['skin_condition'] = $atc_screening[$atc->atc_id]['total_screening']['skin_condition'] + 1;
                        }
                    }
                }
            }

            if ($data['action'] == 'childhood_disease') {

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );
                $today_screening_data = $this->student_model->get_screening_atc_by_date($report_args);
                foreach ($today_screening_data as $today_screening) {

                    $deficiencies = json_decode($today_screening->childhood_disease);
                    $childhood_disease_ids = array('3', '4', '13', '17', '15', '14', '18');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->atc_id]['today']['childhood_disease'] = $atc_screening[$atc->atc_id]['today']['childhood_disease'] + 1;
                        }
                    }
                }

                $current_month_start_date = $current_years . '-' . $current_months . '-01';

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $current_month_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($current_month_screening_data as $current_month_data) {

                    $deficiencies = json_decode($current_month_data->childhood_disease);
                    $childhood_disease_ids = array('3', '4', '13', '17', '15', '14', '18');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->atc_id]['current_month']['childhood_disease'] = $atc_screening[$atc->atc_id]['current_month']['childhood_disease'] + 1;
                        }
                    }
                }


                $current_years_date = $current_years . '-01-01';
                $report_args = array('from_date' => date('Y-m-d', strtotime($current_years_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $years_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($years_screening_data as $current_year_data) {


                    $deficiencies = json_decode($current_year_data->childhood_disease);
                    $childhood_disease_ids = array('3', '4', '13', '17', '15', '14', '18');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->atc_id]['current_year']['childhood_disease'] = $atc_screening[$atc->atc_id]['current_year']['childhood_disease'] + 1;
                        }
                    }
                }


                $args = array('cluster_id' => $cluster_ids);
                $total_screening_data = $this->student_model->get_screening_atc_by_date($args);
                foreach ($total_screening_data as $total_screenings) {

                    $total_skin_condition = json_decode($total_screenings->childhood_disease);
                    $childhood_disease_ids = array('3', '4', '13', '17', '15', '14', '18');

                    if (is_array($total_skin_condition)) {

                        if (array_intersect($childhood_disease_ids, $total_skin_condition)) {
                            $atc_screening[$atc->atc_id]['total_screening']['childhood_disease'] = $atc_screening[$atc->atc_id]['total_screening']['childhood_disease'] + 1;
                        }
                    }
                }
            }

            if ($data['action'] == 'opthalmological') {

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );
                $today_opthalmological = $this->student_model->get_vision_atc_by_date($report_args);

                foreach ($today_opthalmological as $today_opthalmological) {
                    $ent_check_if_present = json_decode($today_opthalmological->opthalmological);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11');

                    if (is_array($ent_check_if_present)) {

                        if (array_intersect($birth_defect_ids, $ent_check_if_present)) {
                            $atc_screening[$atc->atc_id]['today']['opthalmological'] = $atc_screening[$atc->atc_id]['today']['opthalmological'] + 1;
                        }
                    }
                }

                $current_month_start_date = $current_years . '-' . $current_months . '-01';

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $current_month_screening_data = $this->student_model->get_vision_atc_by_date($report_args);

                foreach ($current_month_screening_data as $current_month_data) {

                    $deficiencies = json_decode($current_month_data->opthalmological);
                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->atc_id]['current_month']['opthalmological'] = $atc_screening[$atc->atc_id]['current_month']['opthalmological'] + 1;
                        }
                    }
                }


                $current_years_date = $current_years . '-01-01';
                $report_args = array('from_date' => date('Y-m-d', strtotime($current_years_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $years_screening_data = $this->student_model->get_vision_atc_by_date($report_args);

                foreach ($years_screening_data as $current_year_data) {


                    $deficiencies = json_decode($current_year_data->opthalmological);
                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->atc_id]['current_year']['opthalmological'] = $atc_screening[$atc->atc_id]['current_year']['opthalmological'] + 1;
                        }
                    }
                }


                $args = array('cluster_id' => $cluster_ids);
                $total_screening_data = $this->student_model->get_vision_atc_by_date($report_args);
                foreach ($total_screening_data as $total_screenings) {

                    $total_skin_condition = json_decode($total_screenings->opthalmological);
                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11');

                    if (is_array($total_skin_condition)) {

                        if (array_intersect($childhood_disease_ids, $total_skin_condition)) {
                            $atc_screening[$atc->atc_id]['total_screening']['opthalmological'] = $atc_screening[$atc->atc_id]['total_screening']['opthalmological'] + 1;
                        }
                    }
                }
            }

            if ($data['action'] == 'ent_check_if_present') {

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids);

                $today_ent_data = $this->student_model->get_ent_atc_by_date($report_args);
                foreach ($today_ent_data as $today_ent) {
                    $birth_defect = json_decode($today_ent->ent_check_if_present);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16');

                    if (is_array($birth_defect)) {

                        if (array_intersect($birth_defect_ids, $birth_defect)) {
                            $atc_screening[$atc->atc_id]['ent_check_if_present'] = $atc_screening[$atc->atc_id]['ent_check_if_present'] + 1;
                        }
                    }
                }

                $current_month_start_date = $current_years . '-' . $current_months . '-01';

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids);

                $current_month_ent_data = $this->student_model->get_ent_atc_by_date($report_args);

                foreach ($current_month_ent_data as $current_month_ent) {

                    $deficiencies = json_decode($current_month_ent->ent_check_if_present);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->atc_id]['current_month']['ent_check_if_present'] = $atc_screening[$atc->atc_id]['current_month']['ent_check_if_present'] + 1;
                        }
                    }
                }


                $current_years_date = $current_years . '-01-01';
                $report_args = array('from_date' => date('Y-m-d', strtotime($current_years_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $years_screening_data = $this->student_model->get_ent_atc_by_date($report_args);

                foreach ($years_screening_data as $current_year_data) {


                    $deficiencies = json_decode($current_year_data->ent_check_if_present);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16');
                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->atc_id]['current_year']['ent_check_if_present'] = $atc_screening[$atc->atc_id]['current_year']['ent_check_if_present'] + 1;
                        }
                    }
                }


                $args = array('cluster_id' => $cluster_ids);
                $total_screening_data = $this->student_model->get_ent_atc_by_date($report_args);
                foreach ($total_screening_data as $total_screenings) {

                    $total_skin_condition = json_decode($total_screenings->ent_check_if_present);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16');

                    if (is_array($total_skin_condition)) {

                        if (array_intersect($childhood_disease_ids, $total_skin_condition)) {
                            $atc_screening[$atc->atc_id]['total_screening']['ent_check_if_present'] = $atc_screening[$atc->atc_id]['total_screening']['ent_check_if_present'] + 1;
                        }
                    }
                }
            }
        }

        $data['atc_screening'] = $atc_screening;

        $this->output->add_to_position($this->load->view('frontend/dash/chronic_condition_status_atc_view', $data, true), 'content', true);
    }

    function chronic_condition_po() {

        $data['action'] = $this->input->post('action');
        $data['atc'] = $this->input->post('atc');

        $current_date = date('Y-m-d');
        $curent_months = date('m');
        $current_years = date('Y');

        $data['bread_title'] = "Chronic Conditions Status ";
        $data['bread_title_link'] = "chronic_condition_status";
        $data['bread_title_link_atc'] = "chronic_condition_atc";

        $data['cluster_link_atc'] = "chronic_condition_cluster";

        $args = array('atc_id' => $data['atc']);
        $atc_data = $this->dashboard_model->get_atc_list($args);
        $data['atc_name'] = $atc_data[0]->atc_name;

        $data['po_data'] = $this->dashboard_model->get_po_by_atc_id($data['atc']);

        foreach ($data['po_data'] as $atc) {

            $cluster_id = get_cluster_by_po($atc->po_id);

            $cluster_ids = implode(",", $cluster_id[$atc->po_id]);

            $atc_screening[$atc->po_id]['po_name'] = $atc->po_name;
            $atc_screening[$atc->po_id]['atc_id'] = $atc->atc_id;
            $atc_screening[$atc->po_id]['po_id'] = $atc->po_id;

            // $report_args['cluster_id'] = $cluster_ids;



            if ($data['action'] == 'chronic_birth_defects') {

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );
                $today_screening_data = $this->student_model->get_screening_atc_by_date($report_args);
                foreach ($today_screening_data as $today_screening) {

                    $birth_defect = json_decode($today_screening->birth_deffects);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13');

                    if (is_array($birth_defect)) {
                        if (array_intersect($birth_defect_ids, $birth_defect)) {
                            $atc_screening[$atc->po_id]['today']['birth_defect'] = $atc_screening[$atc->po_id]['today']['birth_defect'] + 1;
                        }
                    }
                }

                $current_month_start_date = $current_years . '-' . $current_months . '-01';

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );
                $current_month_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($current_month_screening_data as $current_month_data) {

                    $birth_defect = json_decode($current_month_data->birth_deffects);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13');

                    if (is_array($birth_defect)) {

                        if (array_intersect($birth_defect_ids, $birth_defect)) {
                            $atc_screening[$atc->po_id]['current_month']['birth_defect'] = $atc_screening[$atc->po_id]['current_month']['birth_defect'] + 1;
                        }
                    }
                }


                $current_years_date = $current_years . '-01-01';
                $report_args = array('from_date' => date('Y-m-d', strtotime($current_years_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $years_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($years_screening_data as $current_year_data) {

                    $birth_defect = json_decode($current_year_data->birth_deffects);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13');

                    if (is_array($birth_defect)) {

                        if (array_intersect($birth_defect_ids, $birth_defect)) {

                            $atc_screening[$atc->po_id]['current_year']['birth_defect'] = $atc_screening[$atc->po_id]['current_year']['birth_defect'] + 1;
                        }
                    }
                }


                $args = array('cluster_id' => $cluster_ids);
                $total_screening_data = $this->student_model->get_screening_atc_by_date($args);
                foreach ($total_screening_data as $total_screening) {

                    $birth_defect = json_decode($total_screening->birth_deffects);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13');

                    if (is_array($birth_defect)) {

                        if (array_intersect($birth_defect_ids, $birth_defect)) {
                            $atc_screening[$atc->po_id]['total_screening']['birth_defect'] = $atc_screening[$atc->po_id]['total_screening']['birth_defect'] + 1;
                        }
                    }
                }
            }

            if ($data['action'] == 'deficiencies') {

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );
                $today_screening_data = $this->student_model->get_screening_atc_by_date($report_args);
                foreach ($today_screening_data as $today_screening) {

                    $deficiencies = json_decode($today_screening->deficiencies);
                    $childhood_disease_ids = array('3', '5', '6', '8', '10');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->po_id]['today']['deficiencies'] = $atc_screening[$atc->po_id]['today']['deficiencies'] + 1;
                        }
                    }
                }

                $current_month_start_date = $current_years . '-' . $current_months . '-01';

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $current_month_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($current_month_screening_data as $current_month_data) {

                    $current_month->deficiencies;
                    $deficiencies = json_decode($current_month->deficiencies);
                    $childhood_disease_ids = array('3', '5', '6', '8', '10');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->po_id]['current_month']['deficiencies'] = $atc_screening[$atc->po_id]['current_month']['deficiencies'] + 1;
                        }
                    }
                }


                $current_years_date = $current_years . '-01-01';
                $report_args = array('from_date' => date('Y-m-d', strtotime($current_years_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $years_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($years_screening_data as $current_year_data) {


                    $deficiencies = json_decode($current_year_data->deficiencies);
                    $childhood_disease_ids = array('3', '5', '6', '8', '10');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->po_id]['current_year']['deficiencies'] = $atc_screening[$atc->po_id]['current_year']['deficiencies'] + 1;
                        }
                    }
                }


                $args = array('cluster_id' => $cluster_ids);
                $total_screening_data = $this->student_model->get_screening_atc_by_date($args);
                foreach ($total_screening_data as $total_screening) {

                    $deficiencies = json_decode($total_screening->deficiencies);
                    $childhood_disease_ids = array('3', '5', '6', '8', '10');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->po_id]['total_screening']['deficiencies'] = $atc_screening[$atc->po_id]['total_screening']['deficiencies'] + 1;
                        }
                    }
                }
            }

            if ($data['action'] == 'skin_condition') {

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );
                $today_screening_data = $this->student_model->get_screening_atc_by_date($report_args);
                foreach ($today_screening_data as $today_screening) {

                    $deficiencies = json_decode($today_screening->skin_condition);
                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->po_id]['today']['skin_condition'] = $atc_screening[$atc->po_id]['today']['skin_condition'] + 1;
                        }
                    }
                }

                $current_month_start_date = $current_years . '-' . $current_months . '-01';

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $current_month_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($current_month_screening_data as $current_month_data) {

                    $month_skin_condition = json_decode($current_month_data->skin_condition);
                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18');

                    if (is_array($month_skin_condition)) {

                        if (array_intersect($childhood_disease_ids, $month_skin_condition)) {
                            $atc_screening[$atc->po_id]['current_month']['skin_condition'] = $atc_screening[$atc->po_id]['current_month']['skin_condition'] + 1;
                        }
                    }
                }


                $current_years_date = $current_years . '-01-01';
                $report_args = array('from_date' => date('Y-m-d', strtotime($current_years_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $years_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($years_screening_data as $current_year_data) {


                    $deficiencies = json_decode($current_year_data->skin_condition);
                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->po_id]['current_year']['skin_condition'] = $atc_screening[$atc->po_id]['current_year']['skin_condition'] + 1;
                        }
                    }
                }


                $args = array('cluster_id' => $cluster_ids);
                $total_screening_data = $this->student_model->get_screening_atc_by_date($args);
                foreach ($total_screening_data as $total_screenings) {

                    $total_skin_condition = json_decode($total_screenings->skin_condition);

                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18');

                    if (is_array($total_skin_condition)) {

                        if (array_intersect($childhood_disease_ids, $total_skin_condition)) {
                            $atc_screening[$atc->po_id]['total_screening']['skin_condition'] = $atc_screening[$atc->po_id]['total_screening']['skin_condition'] + 1;
                        }
                    }
                }
            }

            if ($data['action'] == 'childhood_disease') {

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );
                $today_screening_data = $this->student_model->get_screening_atc_by_date($report_args);
                foreach ($today_screening_data as $today_screening) {

                    $deficiencies = json_decode($today_screening->childhood_disease);
                    $childhood_disease_ids = array('3', '4', '13', '17', '15', '14', '18');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->po_id]['today']['childhood_disease'] = $atc_screening[$atc->po_id]['today']['childhood_disease'] + 1;
                        }
                    }
                }

                $current_month_start_date = $current_years . '-' . $current_months . '-01';

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $current_month_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($current_month_screening_data as $current_month_data) {

                    $deficiencies = json_decode($current_month_data->childhood_disease);
                    $childhood_disease_ids = array('3', '4', '13', '17', '15', '14', '18');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->po_id]['current_month']['childhood_disease'] = $atc_screening[$atc->po_id]['current_month']['childhood_disease'] + 1;
                        }
                    }
                }


                $current_years_date = $current_years . '-01-01';
                $report_args = array('from_date' => date('Y-m-d', strtotime($current_years_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $years_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($years_screening_data as $current_year_data) {


                    $deficiencies = json_decode($current_year_data->childhood_disease);
                    $childhood_disease_ids = array('3', '4', '13', '17', '15', '14', '18');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->po_id]['current_year']['childhood_disease'] = $atc_screening[$atc->po_id]['current_year']['childhood_disease'] + 1;
                        }
                    }
                }


                $args = array('cluster_id' => $cluster_ids);
                $total_screening_data = $this->student_model->get_screening_atc_by_date($args);
                foreach ($total_screening_data as $total_screenings) {

                    $total_skin_condition = json_decode($total_screenings->childhood_disease);
                    $childhood_disease_ids = array('3', '4', '13', '17', '15', '14', '18');

                    if (is_array($total_skin_condition)) {

                        if (array_intersect($childhood_disease_ids, $total_skin_condition)) {
                            $atc_screening[$atc->po_id]['total_screening']['childhood_disease'] = $atc_screening[$atc->po_id]['total_screening']['childhood_disease'] + 1;
                        }
                    }
                }
            }

            if ($data['action'] == 'opthalmological') {

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );
                $today_opthalmological = $this->student_model->get_vision_atc_by_date($report_args);

                foreach ($today_opthalmological as $today_opthalmological) {
                    $ent_check_if_present = json_decode($today_opthalmological->opthalmological);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11');

                    if (is_array($ent_check_if_present)) {

                        if (array_intersect($birth_defect_ids, $ent_check_if_present)) {
                            $atc_screening[$atc->po_id]['today']['opthalmological'] = $atc_screening[$atc->po_id]['today']['opthalmological'] + 1;
                        }
                    }
                }

                $current_month_start_date = $current_years . '-' . $current_months . '-01';

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $current_month_screening_data = $this->student_model->get_vision_atc_by_date($report_args);

                foreach ($current_month_screening_data as $current_month_data) {

                    $deficiencies = json_decode($current_month_data->opthalmological);
                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->po_id]['current_month']['opthalmological'] = $atc_screening[$atc->po_id]['current_month']['opthalmological'] + 1;
                        }
                    }
                }


                $current_years_date = $current_years . '-01-01';
                $report_args = array('from_date' => date('Y-m-d', strtotime($current_years_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $years_screening_data = $this->student_model->get_vision_atc_by_date($report_args);

                foreach ($years_screening_data as $current_year_data) {


                    $deficiencies = json_decode($current_year_data->opthalmological);
                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->po_id]['current_year']['opthalmological'] = $atc_screening[$atc->po_id]['current_year']['opthalmological'] + 1;
                        }
                    }
                }


                $args = array('cluster_id' => $cluster_ids);
                $total_screening_data = $this->student_model->get_vision_atc_by_date($report_args);
                foreach ($total_screening_data as $total_screenings) {

                    $total_skin_condition = json_decode($total_screenings->opthalmological);
                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11');

                    if (is_array($total_skin_condition)) {

                        if (array_intersect($childhood_disease_ids, $total_skin_condition)) {
                            $atc_screening[$atc->po_id]['total_screening']['opthalmological'] = $atc_screening[$atc->po_id]['total_screening']['opthalmological'] + 1;
                        }
                    }
                }
            }

            if ($data['action'] == 'ent_check_if_present') {

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids);

                $today_ent_data = $this->student_model->get_ent_atc_by_date($report_args);
                foreach ($today_ent_data as $today_ent) {
                    $birth_defect = json_decode($today_ent->ent_check_if_present);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16');

                    if (is_array($birth_defect)) {

                        if (array_intersect($birth_defect_ids, $birth_defect)) {
                            $atc_screening[$atc->po_id]['ent_check_if_present'] = $atc_screening[$atc->po_id]['ent_check_if_present'] + 1;
                        }
                    }
                }

                $current_month_start_date = $current_years . '-' . $current_months . '-01';

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids);

                $current_month_ent_data = $this->student_model->get_ent_atc_by_date($report_args);

                foreach ($current_month_ent_data as $current_month_ent) {

                    $deficiencies = json_decode($current_month_ent->ent_check_if_present);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->po_id]['current_month']['ent_check_if_present'] = $atc_screening[$atc->po_id]['current_month']['ent_check_if_present'] + 1;
                        }
                    }
                }


                $current_years_date = $current_years . '-01-01';
                $report_args = array('from_date' => date('Y-m-d', strtotime($current_years_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $years_screening_data = $this->student_model->get_ent_atc_by_date($report_args);

                foreach ($years_screening_data as $current_year_data) {


                    $deficiencies = json_decode($current_year_data->ent_check_if_present);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16');
                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->po_id]['current_year']['ent_check_if_present'] = $atc_screening[$atc->po_id]['current_year']['ent_check_if_present'] + 1;
                        }
                    }
                }


                $args = array('cluster_id' => $cluster_ids);
                $total_screening_data = $this->student_model->get_ent_atc_by_date($report_args);
                foreach ($total_screening_data as $total_screenings) {

                    $total_skin_condition = json_decode($total_screenings->ent_check_if_present);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16');

                    if (is_array($total_skin_condition)) {

                        if (array_intersect($childhood_disease_ids, $total_skin_condition)) {
                            $atc_screening[$atc->po_id]['total_screening']['ent_check_if_present'] = $atc_screening[$atc->po_id]['total_screening']['ent_check_if_present'] + 1;
                        }
                    }
                }
            }
        }

        $data['atc_screening'] = $atc_screening;

        $this->output->add_to_position($this->load->view('frontend/dash/chronic_condition_status_po_view', $data, true), 'content', true);
    }

    function chronic_condition_cluster() {
        $data['action'] = $this->input->post('action');
        $data['atc'] = $this->input->post('atc');

        $data['po'] = $this->input->post('po');

        $current_date = date('Y-m-d');
        $curent_months = date('m');
        $current_years = date('Y');

        $data['bread_title'] = "Chronic Conditions Status ";
        $data['bread_title_link'] = "chronic_condition_status";
        $data['bread_title_link_atc'] = "chronic_condition_atc";
        $data['bread_title_link_po'] = "chronic_condition_po";

        $data['school_link'] = "chronic_condition_school";

        $args = array('atc_id' => $data['atc']);
        $atc_data = $this->dashboard_model->get_atc_list($args);
        $data['atc_name'] = $atc_data[0]->atc_name;

        $po_args = array('po_id' => $data['po']);
        $po_data = $this->dashboard_model->get_auto_po_by_atc_id($po_args);
        $data['po_name'] = $po_data[0]->po_name;

        $clu_args = array('cluster_id' => $data['cluster_id']);
        $clu_data = $this->cluster_model->get_cluster_data($clu_args);
        $data['cluster_name'] = $clu_data[0]->cluster_name;


        $data['cluter_data'] = $this->dashboard_model->get_cluter_by_po_id($data['po']);

        foreach ($data['cluter_data'] as $atc) {

            $cluster_ids = $atc->cluster_id;

            $atc_screening[$atc->cluster_id]['cluster_name'] = $atc->cluster_name;
            $atc_screening[$atc->cluster_id]['atc_id'] = $atc->atc;
            $atc_screening[$atc->cluster_id]['po_id'] = $atc->po;
            $atc_screening[$atc->cluster_id]['cluster_id'] = $atc->cluster_id;

            // $report_args['cluster_id'] = $cluster_ids;



            if ($data['action'] == 'chronic_birth_defects') {

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );
                $today_screening_data = $this->student_model->get_screening_atc_by_date($report_args);
                foreach ($today_screening_data as $today_screening) {

                    $birth_defect = json_decode($today_screening->birth_deffects);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13');

                    if (is_array($birth_defect)) {
                        if (array_intersect($birth_defect_ids, $birth_defect)) {
                            $atc_screening[$atc->cluster_id]['today']['birth_defect'] = $atc_screening[$atc->cluster_id]['today']['birth_defect'] + 1;
                        }
                    }
                }

                $current_month_start_date = $current_years . '-' . $current_months . '-01';

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $current_month_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($current_month_screening_data as $current_month_data) {

                    $birth_defect = json_decode($current_month_data->birth_deffects);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13');

                    if (is_array($birth_defect)) {

                        if (array_intersect($birth_defect_ids, $birth_defect)) {
                            $atc_screening[$atc->cluster_id]['current_month']['birth_defect'] = $atc_screening[$atc->cluster_id]['current_month']['birth_defect'] + 1;
                        }
                    }
                }


                $current_years_date = $current_years . '-01-01';
                $report_args = array('from_date' => date('Y-m-d', strtotime($current_years_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $years_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($years_screening_data as $current_year) {

                    $birth_defect = json_decode($current_year->birth_deffects);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13');

                    if (is_array($birth_defect)) {

                        if (array_intersect($birth_defect_ids, $birth_defect)) {

                            $atc_screening[$atc->cluster_id]['current_year']['birth_defect'] = $atc_screening[$atc->cluster_id]['current_year']['birth_defect'] + 1;
                        }
                    }
                }


                $args = array('cluster_id' => $cluster_ids);
                $total_screening_data = $this->student_model->get_screening_atc_by_date($args);
                foreach ($total_screening_data as $total_screening) {

                    $birth_defect = json_decode($total_screening->birth_deffects);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13');

                    if (is_array($birth_defect)) {

                        if (array_intersect($birth_defect_ids, $birth_defect)) {
                            $atc_screening[$atc->cluster_id]['total_screening']['birth_defect'] = $atc_screening[$atc->cluster_id]['total_screening']['birth_defect'] + 1;
                        }
                    }
                }
            }

            if ($data['action'] == 'deficiencies') {

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );
                $today_screening_data = $this->student_model->get_screening_atc_by_date($report_args);
                foreach ($today_screening_data as $today_screening) {

                    $deficiencies = json_decode($today_screening->deficiencies);
                    $childhood_disease_ids = array('3', '5', '6', '8', '10');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->cluster_id]['today']['deficiencies'] = $atc_screening[$atc->cluster_id]['today']['deficiencies'] + 1;
                        }
                    }
                }

                $current_month_start_date = $current_years . '-' . $current_months . '-01';

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $current_month_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($current_month_screening_data as $current_month_data) {

                    $current_month->deficiencies;
                    $deficiencies = json_decode($current_month->deficiencies);
                    $childhood_disease_ids = array('3', '5', '6', '8', '10');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->cluster_id]['current_month']['deficiencies'] = $atc_screening[$atc->cluster_id]['current_month']['deficiencies'] + 1;
                        }
                    }
                }


                $current_years_date = $current_years . '-01-01';
                $report_args = array('from_date' => date('Y-m-d', strtotime($current_years_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $years_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($years_screening_data as $current_year) {


                    $deficiencies = json_decode($current_year->deficiencies);
                    $childhood_disease_ids = array('3', '5', '6', '8', '10');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->cluster_id]['current_year']['deficiencies'] = $atc_screening[$atc->cluster_id]['current_year']['deficiencies'] + 1;
                        }
                    }
                }


                $args = array('cluster_id' => $cluster_ids);
                $total_screening_data = $this->student_model->get_screening_atc_by_date($args);
                foreach ($total_screening_data as $total_screening) {

                    $deficiencies = json_decode($total_screening->deficiencies);
                    $childhood_disease_ids = array('3', '5', '6', '8', '10');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->cluster_id]['total_screening']['deficiencies'] = $atc_screening[$atc->cluster_id]['total_screening']['deficiencies'] + 1;
                        }
                    }
                }
            }

            if ($data['action'] == 'skin_condition') {

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );
                $today_screening_data = $this->student_model->get_screening_atc_by_date($report_args);
                foreach ($today_screening_data as $today_screening) {

                    $deficiencies = json_decode($today_screening->skin_condition);
                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->cluster_id]['today']['skin_condition'] = $atc_screening[$atc->cluster_id]['today']['skin_condition'] + 1;
                        }
                    }
                }

                $current_month_start_date = $current_years . '-' . $current_months . '-01';

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $current_month_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($current_month_screening_data as $current_month_data) {

                    $month_skin_condition = json_decode($current_month_data->skin_condition);
                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18');

                    if (is_array($month_skin_condition)) {

                        if (array_intersect($childhood_disease_ids, $month_skin_condition)) {
                            $atc_screening[$atc->cluster_id]['current_month']['skin_condition'] = $atc_screening[$atc->cluster_id]['current_month']['skin_condition'] + 1;
                        }
                    }
                }


                $current_years_date = $current_years . '-01-01';
                $report_args = array('from_date' => date('Y-m-d', strtotime($current_years_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $years_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($years_screening_data as $current_year) {


                    $deficiencies = json_decode($current_year->skin_condition);
                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->cluster_id]['current_year']['skin_condition'] = $atc_screening[$atc->cluster_id]['current_year']['skin_condition'] + 1;
                        }
                    }
                }


                $args = array('cluster_id' => $cluster_ids);
                $total_screening_data = $this->student_model->get_screening_atc_by_date($args);
                foreach ($total_screening_data as $total_screenings) {

                    $total_skin_condition = json_decode($total_screenings->skin_condition);

                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18');

                    if (is_array($total_skin_condition)) {

                        if (array_intersect($childhood_disease_ids, $total_skin_condition)) {
                            $atc_screening[$atc->cluster_id]['total_screening']['skin_condition'] = $atc_screening[$atc->cluster_id]['total_screening']['skin_condition'] + 1;
                        }
                    }
                }
            }

            if ($data['action'] == 'childhood_disease') {

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );
                $today_screening_data = $this->student_model->get_screening_atc_by_date($report_args);
                foreach ($today_screening_data as $today_screening) {

                    $deficiencies = json_decode($today_screening->childhood_disease);
                    $childhood_disease_ids = array('3', '4', '13', '17', '15', '14', '18');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->cluster_id]['today']['childhood_disease'] = $atc_screening[$atc->cluster_id]['today']['childhood_disease'] + 1;
                        }
                    }
                }

                $current_month_start_date = $current_years . '-' . $current_months . '-01';

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $current_month_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($current_month_screening_data as $current_month_data) {

                    $deficiencies = json_decode($current_month_data->childhood_disease);
                    $childhood_disease_ids = array('3', '4', '13', '17', '15', '14', '18');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->cluster_id]['current_month']['childhood_disease'] = $atc_screening[$atc->cluster_id]['current_month']['childhood_disease'] + 1;
                        }
                    }
                }


                $current_years_date = $current_years . '-01-01';
                $report_args = array('from_date' => date('Y-m-d', strtotime($current_years_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $years_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($years_screening_data as $current_year) {


                    $deficiencies = json_decode($today_screening->childhood_disease);
                    $childhood_disease_ids = array('3', '4', '13', '17', '15', '14', '18');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->cluster_id]['current_year']['childhood_disease'] = $atc_screening[$atc->po_id]['current_year']['childhood_disease'] + 1;
                        }
                    }
                }


                $args = array('cluster_id' => $cluster_ids);
                $total_screening_data = $this->student_model->get_screening_atc_by_date($args);
                foreach ($total_screening_data as $total_screenings) {

                    $total_skin_condition = json_decode($total_screenings->childhood_disease);
                    $childhood_disease_ids = array('3', '4', '13', '17', '15', '14', '18');

                    if (is_array($total_skin_condition)) {

                        if (array_intersect($childhood_disease_ids, $total_skin_condition)) {
                            $atc_screening[$atc->cluster_id]['total_screening']['childhood_disease'] = $atc_screening[$atc->po_id]['total_screening']['childhood_disease'] + 1;
                        }
                    }
                }
            }

            if ($data['action'] == 'opthalmological') {

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );
                $today_opthalmological = $this->student_model->get_vision_atc_by_date($report_args);

                foreach ($today_opthalmological as $today_opthalmological) {
                    $ent_check_if_present = json_decode($today_opthalmological->opthalmological);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11');

                    if (is_array($ent_check_if_present)) {

                        if (array_intersect($birth_defect_ids, $ent_check_if_present)) {
                            $atc_screening[$atc->cluster_id]['today']['opthalmological'] = $atc_screening[$atc->po_id]['today']['opthalmological'] + 1;
                        }
                    }
                }

                $current_month_start_date = $current_years . '-' . $current_months . '-01';

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $current_month_screening_data = $this->student_model->get_vision_atc_by_date($report_args);

                foreach ($current_month_screening_data as $current_month_data) {

                    $deficiencies = json_decode($current_month_data->opthalmological);
                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->cluster_id]['current_month']['opthalmological'] = $atc_screening[$atc->po_id]['current_month']['opthalmological'] + 1;
                        }
                    }
                }


                $current_years_date = $current_years . '-01-01';
                $report_args = array('from_date' => date('Y-m-d', strtotime($current_years_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $years_screening_data = $this->student_model->get_vision_atc_by_date($report_args);

                foreach ($years_screening_data as $current_year) {


                    $deficiencies = json_decode($current_year->opthalmological);
                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->cluster_id]['current_year']['opthalmological'] = $atc_screening[$atc->po_id]['current_year']['opthalmological'] + 1;
                        }
                    }
                }


                $args = array('cluster_id' => $cluster_ids);
                $total_screening_data = $this->student_model->get_vision_atc_by_date($report_args);
                foreach ($total_screening_data as $total_screenings) {

                    $total_skin_condition = json_decode($total_screenings->opthalmological);
                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $total_skin_condition)) {
                            $atc_screening[$atc->cluster_id]['total_screening']['opthalmological'] = $atc_screening[$atc->po_id]['total_screening']['opthalmological'] + 1;
                        }
                    }
                }
            }

            if ($data['action'] == 'ent_check_if_present') {

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids);

                $today_ent_data = $this->student_model->get_ent_atc_by_date($report_args);
                foreach ($today_ent_data as $today_ent) {
                    $birth_defect = json_decode($today_ent->ent_check_if_present);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16');

                    if (is_array($birth_defect)) {

                        if (array_intersect($birth_defect_ids, $birth_defect)) {
                            $atc_screening[$atc->cluster_id]['ent_check_if_present'] = $atc_screening[$atc->po_id]['ent_check_if_present'] + 1;
                        }
                    }
                }

                $current_month_start_date = $current_years . '-' . $current_months . '-01';

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids);

                $current_month_ent_data = $this->student_model->get_ent_atc_by_date($report_args);

                foreach ($current_month_ent_data as $current_month_ent) {

                    $deficiencies = json_decode($current_month_ent->ent_check_if_present);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->cluster_id]['current_month']['ent_check_if_present'] = $atc_screening[$atc->po_id]['current_month']['ent_check_if_present'] + 1;
                        }
                    }
                }


                $current_years_date = $current_years . '-01-01';
                $report_args = array('from_date' => date('Y-m-d', strtotime($current_years_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $years_screening_data = $this->student_model->get_ent_atc_by_date($report_args);

                foreach ($years_screening_data as $current_year) {


                    $deficiencies = json_decode($current_year->ent_check_if_present);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16');
                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->cluster_id]['current_year']['ent_check_if_present'] = $atc_screening[$atc->po_id]['current_year']['ent_check_if_present'] + 1;
                        }
                    }
                }


                $args = array('cluster_id' => $cluster_ids);
                $total_screening_data = $this->student_model->get_ent_atc_by_date($report_args);
                foreach ($total_screening_data as $total_screenings) {

                    $total_skin_condition = json_decode($total_screenings->ent_check_if_present);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16');

                    if (is_array($total_skin_condition)) {

                        if (array_intersect($childhood_disease_ids, $total_skin_condition)) {
                            $atc_screening[$atc->cluster_id]['total_screening']['ent_check_if_present'] = $atc_screening[$atc->po_id]['total_screening']['ent_check_if_present'] + 1;
                        }
                    }
                }
            }
        }

        $data['atc_screening'] = $atc_screening;

        $this->output->add_to_position($this->load->view('frontend/dash/chronic_condition_status_cluster_view', $data, true), 'content', true);
    }

    function chronic_condition_school() {

        $data['action'] = $this->input->post('action');
        $data['atc'] = $this->input->post('atc');
        $data['po'] = $this->input->post('po');
        $data['cluster_id'] = $this->input->post('cluster_id');

        $data['bread_title'] = "Chronic Conditions Status ";
        $data['bread_title_link'] = "chronic_condition_status";
        $data['bread_title_link_atc'] = "chronic_condition_atc";
        $data['bread_title_link_po'] = "chronic_condition_po";
        $data['link_cluster'] = "chronic_condition_cluster";

        $args = array('atc_id' => $data['atc']);
        $atc_data = $this->dashboard_model->get_atc_list($args);
        $data['atc_name'] = $atc_data[0]->atc_name;

        $po_args = array('po_id' => $data['po']);
        $po_data = $this->dashboard_model->get_auto_po_by_atc_id($po_args);
        $data['po_name'] = $po_data[0]->po_name;

        $clu_args = array('cluster_id' => $data['cluster_id']);
        $clu_data = $this->cluster_model->get_cluster_data($clu_args);
        $data['cluster_name'] = $clu_data[0]->cluster_name;

        $data['school_data'] = $this->dashboard_model->get_school_by_cluster_id($data['cluster_id']);

        foreach ($data['school_data'] as $atc) {

            $cluster_ids = $atc->school_id;

            $atc_screening[$atc->school_id]['school_name'] = $atc->school_name;
            $atc_screening[$atc->school_id]['atc_id'] = $data['atc'];
            $atc_screening[$atc->school_id]['po_id'] = $data['po'];
            $atc_screening[$atc->school_id]['cluster_id'] = $atc->cluster_id;

            $current_date = date('Y-m-d');
            $curent_months = date('m');
            $current_years = date('Y');


            // $report_args['cluster_id'] = $cluster_ids;



            if ($data['action'] == 'chronic_birth_defects') {

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'school_id' => $cluster_ids);


                $today_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($today_screening_data as $today_screening) {

                    $birth_defect = json_decode($today_screening->birth_deffects);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13');

                    if (is_array($birth_defect)) {
                        if (array_intersect($birth_defect_ids, $birth_defect)) {
                            $atc_screening[$atc->school_id]['today']['birth_defect'] = $atc_screening[$atc->school_id]['today']['birth_defect'] + 1;
                        }
                    }
                }

                $current_month_start_date = $current_years . '-' . $current_months . '-01';

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'school_id' => $cluster_ids
                );

                $current_month_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($current_month_screening_data as $current_month_data) {

                    $birth_defect = json_decode($current_month_data->birth_deffects);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13');

                    if (is_array($birth_defect)) {

                        if (array_intersect($birth_defect_ids, $birth_defect)) {
                            $atc_screening[$atc->school_id]['current_month']['birth_defect'] = $atc_screening[$atc->school_id]['current_month']['birth_defect'] + 1;
                        }
                    }
                }


                $current_years_date = $current_years . '-01-01';
                $report_args = array('from_date' => date('Y-m-d', strtotime($current_years_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'school_id' => $cluster_ids
                );

                $years_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($years_screening_data as $current_year) {

                    $birth_defect = json_decode($current_year->birth_deffects);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13');

                    if (is_array($birth_defect)) {

                        if (array_intersect($birth_defect_ids, $birth_defect)) {

                            $atc_screening[$atc->school_id]['current_year']['birth_defect'] = $atc_screening[$atc->school_id]['current_year']['birth_defect'] + 1;
                        }
                    }
                }


                $args = array('school_id' => $cluster_ids);
                $total_screening_data = $this->student_model->get_screening_atc_by_date($args);
                foreach ($total_screening_data as $total_screening) {

                    $birth_defect = json_decode($total_screening->birth_deffects);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13');

                    if (is_array($birth_defect)) {

                        if (array_intersect($birth_defect_ids, $birth_defect)) {
                            $atc_screening[$atc->school_id]['total_screening']['birth_defect'] = $atc_screening[$atc->school_id]['total_screening']['birth_defect'] + 1;
                        }
                    }
                }
            }

            if ($data['action'] == 'deficiencies') {

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'school_id' => $cluster_ids
                );
                $today_screening_data = $this->student_model->get_screening_atc_by_date($report_args);
                foreach ($today_screening_data as $today_screening) {

                    $deficiencies = json_decode($today_screening->deficiencies);
                    $childhood_disease_ids = array('3', '5', '6', '8', '10');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->school_id]['today']['deficiencies'] = $atc_screening[$atc->school_id]['today']['deficiencies'] + 1;
                        }
                    }
                }

                $current_month_start_date = $current_years . '-' . $current_months . '-01';

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'school_id' => $cluster_ids
                );

                $current_month_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($current_month_screening_data as $current_month_data) {

                    $current_month->deficiencies;
                    $deficiencies = json_decode($current_month->deficiencies);
                    $childhood_disease_ids = array('3', '5', '6', '8', '10');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->school_id]['current_month']['deficiencies'] = $atc_screening[$atc->school_id]['current_month']['deficiencies'] + 1;
                        }
                    }
                }


                $current_years_date = $current_years . '-01-01';
                $report_args = array('from_date' => date('Y-m-d', strtotime($current_years_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'school_id' => $cluster_ids
                );

                $years_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($years_screening_data as $current_year) {


                    $deficiencies = json_decode($current_year->deficiencies);
                    $childhood_disease_ids = array('3', '5', '6', '8', '10');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->school_id]['current_year']['deficiencies'] = $atc_screening[$atc->school_id]['current_year']['deficiencies'] + 1;
                        }
                    }
                }


                $args = array('school_id' => $cluster_ids);
                $total_screening_data = $this->student_model->get_screening_atc_by_date($args);
                foreach ($total_screening_data as $total_screening) {

                    $deficiencies = json_decode($total_screening->deficiencies);
                    $childhood_disease_ids = array('3', '5', '6', '8', '10');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->school_id]['total_screening']['deficiencies'] = $atc_screening[$atc->school_id]['total_screening']['deficiencies'] + 1;
                        }
                    }
                }
            }

            if ($data['action'] == 'skin_condition') {


                $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'school_id' => $cluster_ids
                );
                $today_screening_data = $this->student_model->get_screening_atc_by_date($report_args);
                foreach ($today_screening_data as $today_screening) {

                    $deficiencies = json_decode($today_screening->skin_condition);
                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->school_id]['today']['skin_condition'] = $atc_screening[$atc->school_id]['today']['skin_condition'] + 1;
                        }
                    }
                }

                $current_month_start_date = $current_years . '-' . $current_months . '-01';

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'school_id' => $cluster_ids
                );

                $current_month_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($current_month_screening_data as $current_month_data) {

                    $month_skin_condition = json_decode($current_month_data->skin_condition);
                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18');

                    if (is_array($month_skin_condition)) {

                        if (array_intersect($childhood_disease_ids, $month_skin_condition)) {
                            $atc_screening[$atc->school_id]['current_month']['skin_condition'] = $atc_screening[$atc->school_id]['current_month']['skin_condition'] + 1;
                        }
                    }
                }


                $current_years_date = $current_years . '-01-01';
                $report_args = array('from_date' => date('Y-m-d', strtotime($current_years_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'school_id' => $cluster_ids
                );

                $years_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($years_screening_data as $current_year) {


                    $deficiencies = json_decode($current_year->skin_condition);
                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->school_id]['current_year']['skin_condition'] = $atc_screening[$atc->school_id]['current_year']['skin_condition'] + 1;
                        }
                    }
                }


                $args = array('school_id' => $cluster_ids);
                $total_screening_data = $this->student_model->get_screening_atc_by_date($args);

                foreach ($total_screening_data as $total_screenings) {

                    $total_skin_condition = json_decode($total_screenings->skin_condition);

                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18');

                    if (is_array($total_skin_condition)) {

                        if (array_intersect($childhood_disease_ids, $total_skin_condition)) {
                            $atc_screening[$atc->school_id]['total_screening']['skin_condition'] = $atc_screening[$atc->school_id]['total_screening']['skin_condition'] + 1;
                        }
                    }
                }
            }


            if ($data['action'] == 'childhood_disease') {

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'school_id' => $cluster_ids
                );
                $today_screening_data = $this->student_model->get_screening_atc_by_date($report_args);
                foreach ($today_screening_data as $today_screening) {

                    $deficiencies = json_decode($today_screening->childhood_disease);
                    $childhood_disease_ids = array('3', '4', '13', '17', '15', '14', '18');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->school_id]['today']['childhood_disease'] = $atc_screening[$atc->school_id]['today']['childhood_disease'] + 1;
                        }
                    }
                }

                $current_month_start_date = $current_years . '-' . $current_months . '-01';

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'school_id' => $cluster_ids
                );

                $current_month_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($current_month_screening_data as $current_month_data) {

                    $deficiencies = json_decode($current_month_data->childhood_disease);
                    $childhood_disease_ids = array('3', '4', '13', '17', '15', '14', '18');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->school_id]['current_month']['childhood_disease'] = $atc_screening[$atc->school_id]['current_month']['childhood_disease'] + 1;
                        }
                    }
                }


                $current_years_date = $current_years . '-01-01';
                $report_args = array('from_date' => date('Y-m-d', strtotime($current_years_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'school_id' => $cluster_ids
                );

                $years_screening_data = $this->student_model->get_screening_atc_by_date($report_args);

                foreach ($years_screening_data as $current_year) {


                    $deficiencies = json_decode($today_screening->childhood_disease);
                    $childhood_disease_ids = array('3', '4', '13', '17', '15', '14', '18');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->school_id]['current_year']['childhood_disease'] = $atc_screening[$atc->school_id]['current_year']['childhood_disease'] + 1;
                        }
                    }
                }


                $args = array('school_id' => $cluster_ids);
                $total_screening_data = $this->student_model->get_screening_atc_by_date($args);
                foreach ($total_screening_data as $total_screenings) {

                    $total_skin_condition = json_decode($total_screenings->childhood_disease);
                    $childhood_disease_ids = array('3', '4', '13', '17', '15', '14', '18');

                    if (is_array($total_skin_condition)) {

                        if (array_intersect($childhood_disease_ids, $total_skin_condition)) {
                            $atc_screening[$atc->school_id]['total_screening']['childhood_disease'] = $atc_screening[$atc->school_id]['total_screening']['childhood_disease'] + 1;
                        }
                    }
                }
            }

            if ($data['action'] == 'opthalmological') {

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );
                $today_opthalmological = $this->student_model->get_vision_atc_by_date($report_args);

                foreach ($today_opthalmological as $today_opthalmological) {
                    $ent_check_if_present = json_decode($today_opthalmological->opthalmological);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11');

                    if (is_array($ent_check_if_present)) {

                        if (array_intersect($birth_defect_ids, $ent_check_if_present)) {
                            $atc_screening[$atc->school_id]['today']['opthalmological'] = $atc_screening[$atc->school_id]['today']['opthalmological'] + 1;
                        }
                    }
                }

                $current_month_start_date = $current_years . '-' . $current_months . '-01';

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids
                );

                $current_month_screening_data = $this->student_model->get_vision_atc_by_date($report_args);

                foreach ($current_month_screening_data as $current_month_data) {

                    $deficiencies = json_decode($current_month_data->opthalmological);
                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->school_id]['current_month']['opthalmological'] = $atc_screening[$atc->school_id]['current_month']['opthalmological'] + 1;
                        }
                    }
                }


                $current_years_date = $current_years . '-01-01';
                $report_args = array('from_date' => date('Y-m-d', strtotime($current_years_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'school_id' => $cluster_ids
                );

                $years_screening_data = $this->student_model->get_vision_atc_by_date($report_args);

                foreach ($years_screening_data as $current_year) {


                    $deficiencies = json_decode($current_year->opthalmological);
                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->school_id]['current_year']['opthalmological'] = $atc_screening[$atc->school_id]['current_year']['opthalmological'] + 1;
                        }
                    }
                }


                $args = array('school_id' => $cluster_ids);
                $total_screening_data = $this->student_model->get_vision_atc_by_date($report_args);
                foreach ($total_screening_data as $total_screenings) {

                    $total_skin_condition = json_decode($total_screenings->opthalmological);
                    $childhood_disease_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $total_skin_condition)) {
                            $atc_screening[$atc->school_id]['total_screening']['opthalmological'] = $atc_screening[$atc->school_id]['total_screening']['opthalmological'] + 1;
                        }
                    }
                }
            }

            if ($data['action'] == 'ent_check_if_present') {

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'cluster_id' => $cluster_ids);

                $today_ent_data = $this->student_model->get_ent_atc_by_date($report_args);
                foreach ($today_ent_data as $today_ent) {
                    $birth_defect = json_decode($today_ent->ent_check_if_present);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16');

                    if (is_array($birth_defect)) {

                        if (array_intersect($birth_defect_ids, $birth_defect)) {
                            $atc_screening[$atc->school_id]['ent_check_if_present'] = $atc_screening[$atc->school_id]['ent_check_if_present'] + 1;
                        }
                    }
                }

                $current_month_start_date = $current_years . '-' . $current_months . '-01';

                $report_args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'school_id' => $cluster_ids);

                $current_month_ent_data = $this->student_model->get_ent_atc_by_date($report_args);

                foreach ($current_month_ent_data as $current_month_ent) {

                    $deficiencies = json_decode($current_month_ent->ent_check_if_present);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16');

                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->school_id]['current_month']['ent_check_if_present'] = $atc_screening[$atc->school_id]['current_month']['ent_check_if_present'] + 1;
                        }
                    }
                }


                $current_years_date = $current_years . '-01-01';
                $report_args = array('from_date' => date('Y-m-d', strtotime($current_years_date)),
                    'to_date' => date('Y-m-d', strtotime($current_date)),
                    'school_id' => $cluster_ids
                );

                $years_screening_data = $this->student_model->get_ent_atc_by_date($report_args);

                foreach ($years_screening_data as $current_year) {


                    $deficiencies = json_decode($current_year->ent_check_if_present);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16');
                    if (is_array($deficiencies)) {

                        if (array_intersect($childhood_disease_ids, $deficiencies)) {
                            $atc_screening[$atc->school_id]['current_year']['ent_check_if_present'] = $atc_screening[$atc->school_id]['current_year']['ent_check_if_present'] + 1;
                        }
                    }
                }


                $args = array('school_id' => $cluster_ids);
                $total_screening_data = $this->student_model->get_ent_atc_by_date($report_args);
                foreach ($total_screening_data as $total_screenings) {

                    $total_skin_condition = json_decode($total_screenings->ent_check_if_present);
                    $birth_defect_ids = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16');

                    if (is_array($total_skin_condition)) {

                        if (array_intersect($childhood_disease_ids, $total_skin_condition)) {
                            $atc_screening[$atc->school_id]['total_screening']['ent_check_if_present'] = $atc_screening[$atc->school_id]['total_screening']['ent_check_if_present'] + 1;
                        }
                    }
                }
            }
        }

        $data['atc_screening'] = $atc_screening;

        $this->output->add_to_position($this->load->view('frontend/dash/chronic_condition_status_school_view', $data, true), 'content', true);
    }

    function distance_travel_atc() {
        $data['bread_title'] = "Distance Travelled by Ambulances ";
        $data['bread_title_link'] = "distance_travel_by_amb";
        $data['atc_data'] = $this->dashboard_model->get_atc_list();

        $current_date = date('Y-m-d');
        $current_month = date('m');
        $current_year = date('Y');

        foreach ($data['atc_data'] as $atc) {

            $cluster_id = get_cluster_by_atc($atc->atc_id);
            if (is_array($cluster_id)) {
                $cluster_ids = implode(",", $cluster_id[$atc->atc_id]);
            }

            $atc_screening[$atc->atc_id]['atc_name'] = $atc->atc_name;
            $atc_screening[$atc->atc_id]['atc_id'] = $atc->atc_id;

            $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);


            $report_data = $this->inc_model->get_distance_report_by_date($report_args);

            $today_district_data = array();
            $today_district_data['amb'] = array();
            $today_district_data['total_km'] = 0;
            $today_district_data['inc_ref_id'] = array();

            foreach ($report_data as $report) {

                if (!in_array($report['amb_reg_id'], $today_district_data['amb'])) {
                    $today_district_data['amb'][] = $report['amb_reg_id'];
                }

                if (!in_array($report['inc_ref_id'], $today_district_data['inc_ref_id'])) {
                    if (!empty($report['start_odometer'])) {
                        if ($report['end_odometer'] >= $report['start_odometer']) {

                            $report_odometer = $report['end_odometer'] - $report['start_odometer'];
                            $today_district_data['total_km'] += $report['total_km'];
                        }
                    }
                }
            }
            $atc_screening[$atc->atc_id]['today_distance'] = $today_district_data['total_km'];

            $current_month_start_date = $current_year . '-' . $current_month . '-01';

            $current_month__args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);

            $report_data = $this->inc_model->get_distance_report_by_date($current_month__args);

            $month_district_data = array();
            $month_district_data['total_km'] = 0;
            $month_district_data['inc_ref_id'] = array();
            $month_district_data['amb'] = array();

            foreach ($report_data as $report) {

                if (!in_array($report['amb_reg_id'], $month_district_data['amb'])) {
                    $month_district_data['amb'][] = $report['amb_reg_id'];
                }

                if (!in_array($report['inc_ref_id'], $month_district_data['inc_ref_id'])) {
                    if (!empty($report['start_odometer'])) {
                        if ($report['end_odometer'] >= $report['start_odometer']) {

                            $report_odometer = $report['end_odometer'] - $report['start_odometer'];
                            $month_district_data['total_km'] += $report['total_km'];
                        }
                    }
                }
            }
            $atc_screening[$atc->atc_id]['current_month_distance'] = $month_district_data['total_km'];

            $current_year_start_date = $current_year . '-01-01';
            $current_month__args = array('from_date' => date('Y-m-d', strtotime($current_year_start_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);
            $report_data = $this->inc_model->get_distance_report_by_date($current_month__args);

            $year_district_data = array();
            $year_district_data['total_km'] = 0;
            $year_district_data['inc_ref_id'] = array();
            $year_district_data['amb'] = array();

            foreach ($report_data as $report) {

                if (!in_array($report['amb_reg_id'], $year_district_data['amb'])) {
                    $year_district_data['amb'][] = $report['amb_reg_id'];
                }

                if (!in_array($report['inc_ref_id'], $year_district_data['inc_ref_id'])) {
                    if (!empty($report['start_odometer'])) {
                        if ($report['end_odometer'] >= $report['start_odometer']) {

                            $report_odometer = $report['end_odometer'] - $report['start_odometer'];
                            $year_district_data['total_km'] += $report['total_km'];
                        }
                    }
                }
            }
            $atc_screening[$atc->atc_id]['current_year_distance'] = $year_district_data['total_km'];

            ;
            $total_args['cluster_id'] = $cluster_ids;
            $report_data = $this->inc_model->get_distance_report_by_date($total_args);

            $total_district_data = array();
            $total_district_data['total_km'] = 0;
            $total_district_data['inc_ref_id'] = array();
            $total_district_data['amb'] = array();

            foreach ($report_data as $report) {
                if (!in_array($report['amb_reg_id'], $total_district_data['amb'])) {
                    $total_district_data['amb'][] = $report['amb_reg_id'];
                }
                if (!in_array($report['inc_ref_id'], $total_district_data['inc_ref_id'])) {
                    if (!empty($report['start_odometer'])) {
                        if ($report['end_odometer'] >= $report['start_odometer']) {

                            $report_odometer = $report['end_odometer'] - $report['start_odometer'];
                            $total_district_data['total_km'] += $report['total_km'];
                        }
                    }
                }
            }
            $atc_screening[$atc->atc_id]['total_distance'] = $total_district_data['total_km'];
        }
        //var_dump($atc_screening); die();
        $data['atc_screening'] = $atc_screening;

        $data['atc_po_linke'] = 'distance_travel_po';
        $data['current_date'] = $current_date;

        $this->output->add_to_position($this->load->view('frontend/dash/distance_travel_atc_view', $data, true), 'content', true);
    }

    function distance_travel_po() {

        $data['atc'] = $this->input->post('atc');

        $data['bread_title'] = "Distance Travelled by Ambulances ";
        $data['bread_title_link'] = "distance_travel_by_amb";
        $data['bread_title_link_atc'] = "distance_travel_atc";

        $current_date = date('Y-m-d');
        $current_month = date('m');
        $current_year = date('Y');


        $data['cluster_link_atc'] = "distance_travel_cluster";

        $args = array('atc_id' => $data['atc']);
        $atc_data = $this->dashboard_model->get_atc_list($args);
        $data['atc_name'] = $atc_data[0]->atc_name;

        $data['po_data'] = $this->dashboard_model->get_po_by_atc_id($data['atc']);

        foreach ($data['po_data'] as $atc) {

            $cluster_id = get_cluster_by_po($atc->po_id);

            $cluster_ids = implode(",", $cluster_id[$atc->po_id]);

            $atc_screening[$atc->po_id]['po_name'] = $atc->po_name;
            $atc_screening[$atc->po_id]['atc_id'] = $atc->atc_id;
            $atc_screening[$atc->po_id]['po_id'] = $atc->po_id;


            $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);


            $report_data = $this->inc_model->get_distance_report_by_date($report_args);

            $today_district_data = array();
            $today_district_data['amb'] = array();
            $today_district_data['total_km'] = 0;
            $today_district_data['inc_ref_id'] = array();

            foreach ($report_data as $report) {

                if (!in_array($report['amb_reg_id'], $today_district_data['amb'])) {
                    $today_district_data['amb'][] = $report['amb_reg_id'];
                }

                if (!in_array($report['inc_ref_id'], $today_district_data['inc_ref_id'])) {
                    if (!empty($report['start_odometer'])) {
                        if ($report['end_odometer'] >= $report['start_odometer']) {

                            $report_odometer = $report['end_odometer'] - $report['start_odometer'];
                            $today_district_data['total_km'] += $report['total_km'];
                        }
                    }
                }
            }
            $atc_screening[$atc->po_id]['today_distance'] = $today_district_data['total_km'];

            $current_month_start_date = $current_year . '-' . $current_month . '-01';

            $current_month_args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);

            $report_data = $this->inc_model->get_distance_report_by_date($current_month_args);

            $month_district_data = array();
            $month_district_data['total_km'] = 0;
            $month_district_data['inc_ref_id'] = array();
            $month_district_data['amb'] = array();

            foreach ($report_data as $report) {

                if (!in_array($report['amb_reg_id'], $month_district_data['amb'])) {
                    $month_district_data['amb'][] = $report['amb_reg_id'];
                }

                if (!in_array($report['inc_ref_id'], $month_district_data['inc_ref_id'])) {
                    if (!empty($report['start_odometer'])) {
                        if ($report['end_odometer'] >= $report['start_odometer']) {

                            $report_odometer = $report['end_odometer'] - $report['start_odometer'];
                            $month_district_data['total_km'] += $report['total_km'];
                        }
                    }
                }
            }
            $atc_screening[$atc->po_id]['current_month_distance'] = $month_district_data['total_km'];

            $current_year_start_date = $current_year . '-01-01';
            $current_month__args = array('from_date' => date('Y-m-d', strtotime($current_year_start_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);
            $report_data = $this->inc_model->get_distance_report_by_date($current_month__args);

            $year_district_data = array();
            $year_district_data['total_km'] = 0;
            $year_district_data['inc_ref_id'] = array();
            $year_district_data['amb'] = array();

            foreach ($report_data as $report) {

                if (!in_array($report['amb_reg_id'], $year_district_data['amb'])) {
                    $year_district_data['amb'][] = $report['amb_reg_id'];
                }

                if (!in_array($report['inc_ref_id'], $year_district_data['inc_ref_id'])) {
                    if (!empty($report['start_odometer'])) {
                        if ($report['end_odometer'] >= $report['start_odometer']) {

                            $report_odometer = $report['end_odometer'] - $report['start_odometer'];
                            $year_district_data['total_km'] += $report['total_km'];
                        }
                    }
                }
            }
            $atc_screening[$atc->po_id]['current_year_distance'] = $year_district_data['total_km'];


            $total_args['cluster_id'] = $cluster_ids;
            $report_data = $this->inc_model->get_distance_report_by_date($total_args);

            $total_district_data = array();
            $total_district_data['total_km'] = 0;
            $total_district_data['inc_ref_id'] = array();
            $total_district_data['amb'] = array();

            foreach ($report_data as $report) {
                if (!in_array($report['amb_reg_id'], $total_district_data['amb'])) {
                    $total_district_data['amb'][] = $report['amb_reg_id'];
                }
                if (!in_array($report['inc_ref_id'], $total_district_data['inc_ref_id'])) {
                    if (!empty($report['start_odometer'])) {
                        if ($report['end_odometer'] >= $report['start_odometer']) {

                            $report_odometer = $report['end_odometer'] - $report['start_odometer'];
                            $total_district_data['total_km'] += $report['total_km'];
                        }
                    }
                }
            }
            $atc_screening[$atc->po_id]['total_distance'] = $total_district_data['total_km'];
        }
        $data['atc_screening'] = $atc_screening;
        $data['current_date'] = $current_date;

        $this->output->add_to_position($this->load->view('frontend/dash/distance_travel_po_view', $data, true), 'content', true);
    }

    function distance_travel_cluster() {

        $data['atc'] = $this->input->post('atc');
        $data['po'] = $this->input->post('po');

        $current_date = date('Y-m-d');
        $current_month = date('m');
        $current_year = date('Y');

        $args = array('atc_id' => $data['atc']);
        $atc_data = $this->dashboard_model->get_atc_list($args);
        $data['atc_name'] = $atc_data[0]->atc_name;

        $po_args = array('po_id' => $data['po']);
        $po_data = $this->dashboard_model->get_auto_po_by_atc_id($po_args);
        $data['po_name'] = $po_data[0]->po_name;

        $data['cluter_data'] = $this->dashboard_model->get_cluter_by_po_id($data['po']);
        foreach ($data['cluter_data'] as $atc) {


            $cluster_ids = $atc->cluster_id;

            $atc_screening[$atc->cluster_id]['cluster_name'] = $atc->cluster_name;
            $atc_screening[$atc->cluster_id]['atc_id'] = $atc->atc;
            $atc_screening[$atc->cluster_id]['po_id'] = $atc->po;
            $atc_screening[$atc->cluster_id]['cluster_id'] = $atc->cluster_id;


            $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);


            $report_data = $this->inc_model->get_distance_report_by_date($report_args);

            $today_district_data = array();
            $today_district_data['amb'] = array();
            $today_district_data['total_km'] = 0;
            $today_district_data['inc_ref_id'] = array();

            foreach ($report_data as $report) {

                if (!in_array($report['amb_reg_id'], $today_district_data['amb'])) {
                    $today_district_data['amb'][] = $report['amb_reg_id'];
                }

                if (!in_array($report['inc_ref_id'], $today_district_data['inc_ref_id'])) {
                    if (!empty($report['start_odometer'])) {
                        if ($report['end_odometer'] >= $report['start_odometer']) {

                            $report_odometer = $report['end_odometer'] - $report['start_odometer'];
                            $today_district_data['total_km'] += $report['total_km'];
                        }
                    }
                }
            }
            $atc_screening[$atc->cluster_id]['today_distance'] = $today_district_data['total_km'];

            $current_month_start_date = $current_year . '-' . $current_month . '-01';

            $current_month__args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);

            $report_data = $this->inc_model->get_distance_report_by_date($current_month__args);

            $month_district_data = array();
            $month_district_data['total_km'] = 0;
            $month_district_data['inc_ref_id'] = array();
            $month_district_data['amb'] = array();

            foreach ($report_data as $report) {

                if (!in_array($report['amb_reg_id'], $month_district_data['amb'])) {
                    $month_district_data['amb'][] = $report['amb_reg_id'];
                }

                if (!in_array($report['inc_ref_id'], $month_district_data['inc_ref_id'])) {
                    if (!empty($report['start_odometer'])) {
                        if ($report['end_odometer'] >= $report['start_odometer']) {

                            $report_odometer = $report['end_odometer'] - $report['start_odometer'];
                            $month_district_data['total_km'] += $report['total_km'];
                        }
                    }
                }
            }
            $atc_screening[$atc->cluster_id]['current_month_distance'] = $month_district_data['total_km'];

            $current_year_start_date = $current_year . '-01-01';
            $current_month__args = array('from_date' => date('Y-m-d', strtotime($current_year_start_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);
            $report_data = $this->inc_model->get_distance_report_by_date($current_month__args);

            $year_district_data = array();
            $year_district_data['total_km'] = 0;
            $year_district_data['inc_ref_id'] = array();
            $year_district_data['amb'] = array();

            foreach ($report_data as $report) {

                if (!in_array($report['amb_reg_id'], $year_district_data['amb'])) {
                    $year_district_data['amb'][] = $report['amb_reg_id'];
                }

                if (!in_array($report['inc_ref_id'], $year_district_data['inc_ref_id'])) {
                    if (!empty($report['start_odometer'])) {
                        if ($report['end_odometer'] >= $report['start_odometer']) {

                            $report_odometer = $report['end_odometer'] - $report['start_odometer'];
                            $year_district_data['total_km'] += $report['total_km'];
                        }
                    }
                }
            }
            $atc_screening[$atc->cluster_id]['current_year_distance'] = $year_district_data['total_km'];


            $total_args['cluster_id'] = $cluster_ids;
            $report_data = $this->inc_model->get_distance_report_by_date($total_args);

            $total_district_data = array();
            $total_district_data['total_km'] = 0;
            $total_district_data['inc_ref_id'] = array();
            $total_district_data['amb'] = array();

            foreach ($report_data as $report) {
                if (!in_array($report['amb_reg_id'], $total_district_data['amb'])) {
                    $total_district_data['amb'][] = $report['amb_reg_id'];
                }
                if (!in_array($report['inc_ref_id'], $total_district_data['inc_ref_id'])) {
                    if (!empty($report['start_odometer'])) {
                        if ($report['end_odometer'] >= $report['start_odometer']) {

                            $report_odometer = $report['end_odometer'] - $report['start_odometer'];
                            $total_district_data['total_km'] += $report['total_km'];
                        }
                    }
                }
            }
            $atc_screening[$atc->cluster_id]['total_distance'] = $total_district_data['total_km'];
        }
        $data['atc_screening'] = $atc_screening;



        $data['bread_title'] = "Distance Travelled by Ambulances ";
        $data['bread_title_link'] = "distance_travel_by_amb";
        $data['bread_title_link_atc'] = "distance_travel_atc";
        $data['bread_title_link_po'] = "distance_travel_po";

        $data['school_link'] = "distance_travel_school";
        $data['current_date'] = $current_date;

        $this->output->add_to_position($this->load->view('frontend/dash/distance_travel_cluster_view', $data, true), 'content', true);
    }

    function distance_travel_school() {

        $data['atc'] = $this->input->post('atc');
        $data['po'] = $this->input->post('po');
        $data['cluster_id'] = $this->input->post('cluster_id');

        $args = array('atc_id' => $data['atc']);
        $atc_data = $this->dashboard_model->get_atc_list($args);
        $data['atc_name'] = $atc_data[0]->atc_name;

        $po_args = array('po_id' => $data['po']);
        $po_data = $this->dashboard_model->get_auto_po_by_atc_id($po_args);
        $data['po_name'] = $po_data[0]->po_name;

        $clu_args = array('cluster_id' => $data['cluster_id']);
        $clu_data = $this->cluster_model->get_cluster_data($clu_args);
        $data['cluster_name'] = $clu_data[0]->cluster_name;

        $data['school_data'] = $this->dashboard_model->get_school_by_cluster_id($data['cluster_id']);

        foreach ($data['school_data'] as $atc) {


            $cluster_ids = $atc->cluster_id;

            $atc_screening[$atc->school_id]['school_name'] = $atc->school_name;
            $atc_screening[$atc->school_id]['atc_id'] = $data['atc'];
            $atc_screening[$atc->school_id]['po_id'] = $data['po'];
            $atc_screening[$atc->school_id]['cluster_id'] = $atc->cluster_id;

            $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);


            $report_data = $this->inc_model->get_distance_report_by_date($report_args);

            $today_district_data = array();
            $today_district_data['amb'] = array();
            $today_district_data['total_km'] = 0;
            $today_district_data['inc_ref_id'] = array();

            foreach ($report_data as $report) {

                if (!in_array($report['amb_reg_id'], $today_district_data['amb'])) {
                    $today_district_data['amb'][] = $report['amb_reg_id'];
                }

                if (!in_array($report['inc_ref_id'], $today_district_data['inc_ref_id'])) {
                    if (!empty($report['start_odometer'])) {
                        if ($report['end_odometer'] >= $report['start_odometer']) {

                            $report_odometer = $report['end_odometer'] - $report['start_odometer'];
                            $today_district_data['total_km'] += $report['total_km'];
                        }
                    }
                }
            }
            $atc_screening[$atc->school_id]['today_distance'] = $today_district_data['total_km'];

            $current_month_start_date = $current_year . '-' . $current_month . '-01';

            $current_month__args = array('from_date' => date('Y-m-d', strtotime($current_month_start_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);

            $report_data = $this->inc_model->get_distance_report_by_date($current_month__args);

            $month_district_data = array();
            $month_district_data['total_km'] = 0;
            $month_district_data['inc_ref_id'] = array();
            $month_district_data['amb'] = array();

            foreach ($report_data as $report) {

                if (!in_array($report['amb_reg_id'], $month_district_data['amb'])) {
                    $month_district_data['amb'][] = $report['amb_reg_id'];
                }

                if (!in_array($report['inc_ref_id'], $month_district_data['inc_ref_id'])) {
                    if (!empty($report['start_odometer'])) {
                        if ($report['end_odometer'] >= $report['start_odometer']) {

                            $report_odometer = $report['end_odometer'] - $report['start_odometer'];
                            $month_district_data['total_km'] += $report['total_km'];
                        }
                    }
                }
            }
            $atc_screening[$atc->school_id]['current_month_distance'] = $month_district_data['total_km'];

            $current_year_start_date = $current_year . '-01-01';
            $current_month__args = array('from_date' => date('Y-m-d', strtotime($current_year_start_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);
            $report_data = $this->inc_model->get_distance_report_by_date($current_month__args);

            $year_district_data = array();
            $year_district_data['total_km'] = 0;
            $year_district_data['inc_ref_id'] = array();
            $year_district_data['amb'] = array();

            foreach ($report_data as $report) {

                if (!in_array($report['amb_reg_id'], $year_district_data['amb'])) {
                    $year_district_data['amb'][] = $report['amb_reg_id'];
                }

                if (!in_array($report['inc_ref_id'], $year_district_data['inc_ref_id'])) {
                    if (!empty($report['start_odometer'])) {
                        if ($report['end_odometer'] >= $report['start_odometer']) {

                            $report_odometer = $report['end_odometer'] - $report['start_odometer'];
                            $year_district_data['total_km'] += $report['total_km'];
                        }
                    }
                }
            }
            $atc_screening[$atc->school_id]['current_year_distance'] = $year_district_data['total_km'];


            $total_args['cluster_id'] = $cluster_ids;
            $report_data = $this->inc_model->get_distance_report_by_date($total_args);

            $total_district_data = array();
            $total_district_data['total_km'] = 0;
            $total_district_data['inc_ref_id'] = array();
            $total_district_data['amb'] = array();

            foreach ($report_data as $report) {
                if (!in_array($report['amb_reg_id'], $total_district_data['amb'])) {
                    $total_district_data['amb'][] = $report['amb_reg_id'];
                }
                if (!in_array($report['inc_ref_id'], $total_district_data['inc_ref_id'])) {
                    if (!empty($report['start_odometer'])) {
                        if ($report['end_odometer'] >= $report['start_odometer']) {

                            $report_odometer = $report['end_odometer'] - $report['start_odometer'];
                            $total_district_data['total_km'] += $report['total_km'];
                        }
                    }
                }
            }
            $atc_screening[$atc->school_id]['total_distance'] = $total_district_data['total_km'];
        }

        $data['bread_title'] = "Distance Travelled by Ambulances ";
        $data['bread_title_link'] = "distance_travel_by_amb";
        $data['bread_title_link_atc'] = "distance_travel_atc";
        $data['bread_title_link_po'] = "distance_travel_po";
        $data['link_cluster'] = "distance_travel_cluster";

        $this->output->add_to_position($this->load->view('frontend/dash/distance_travel_school_view', $data, true), 'content', true);
    }

    function total_eme_dispatch() {

        $current_date = date('Y-m-d');
        $current_year = date('Y');

        $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
            'to_date' => date('Y-m-d', strtotime($current_date)));


        $report_data = $this->inc_model->get_active_inc_total($report_args);
        $data['today_inc'] = $report_data[0]->total_calls;

        $current_month = date('m');
        $current_month_date = $current_year . '-' . $current_month . '-01';
        $args = array('from_date' => date('Y-m-d', strtotime($current_month_date)),
            'to_date' => date('Y-m-d', strtotime($current_date)));

        $nov_data = $this->inc_model->get_active_inc_total($args);
        $data['month_inc'] = $nov_data[0]->total_calls;

        $current_month_date = $current_year . '-01-01';

        $years_args = array('from_date' => date('Y-m-d', strtotime($current_month_date)),
            'to_date' => date('Y-m-d', strtotime($current_date)));

        $nov_data = $this->inc_model->get_active_inc_total($args);
        $data['year_inc'] = $nov_data[0]->total_calls;


        $total_data = $this->inc_model->get_active_inc_total();
        $data['total_inc'] = $total_data[0]->total_calls;


        $data['bread_title_link'] = "eme_dispatch_atc";
        $data['current_date'] = $current_date;

        $this->output->add_to_position($this->load->view('frontend/dash/total_eme_dispatch_view', $data, true), 'content', true);
    }

    function eme_dispatch_atc() {
        $data['bread_title'] = "Total Emergency Dispatch ";
        $data['bread_title_link'] = "total_eme_dispatch";
        $data['atc_data'] = $this->dashboard_model->get_atc_list();

        foreach ($data['atc_data'] as $atc) {

            $cluster_id = get_cluster_by_atc($atc->atc_id);

            if (is_array($cluster_id)) {
                $cluster_ids = implode(",", $cluster_id[$atc->atc_id]);
            } else {
                $cluster_ids = '';
            }

            $atc_screening[$atc->atc_id]['atc_name'] = $atc->atc_name;
            $atc_screening[$atc->atc_id]['atc_id'] = $atc->atc_id;

            $current_date = date('Y-m-d');
            $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);

            $today_inc = $this->inc_model->get_active_inc_by_cluster($report_args);
            $atc_screening[$atc->atc_id]['today_inc'] = $today_inc[0]->total_calls;

            $current_month = date('m');
            $current_year = date('Y');
            $current_month_date = $current_year . '-' . $current_month . '-01';
            $month_args = array('from_date' => date('Y-m-d', strtotime($current_month_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);


            $current_month_inc = $this->inc_model->get_active_inc_by_cluster($month_args);
            $atc_screening[$atc->atc_id]['current_month_inc'] = $current_month_inc[0]->total_calls;

            $current_month = date('m');
            $current_year = date('Y');
            $current_month_date = $current_year . '-01-01';

            $year_args = array('from_date' => date('Y-m-d', strtotime($current_month_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);


            $year_total_inc = $this->inc_model->get_active_inc_by_cluster($year_args);
            $atc_screening[$atc->atc_id]['year_total_inc'] = $year_total_inc[0]->total_calls;


            $total_args['cluster_id'] = $cluster_ids;
            $total_inc = $this->inc_model->get_active_inc_by_cluster($total_args);
            $atc_screening[$atc->atc_id]['total_inc'] = $total_inc[0]->total_calls;
        }
        $data['atc_screening'] = $atc_screening;

        $data['atc_po_linke'] = 'eme_dispatch_po';
        $data['current_date'] = $current_date;

        $this->output->add_to_position($this->load->view('frontend/dash/eme_dispatch_atc_view', $data, true), 'content', true);
    }

    function eme_dispatch_po() {

        $data['atc'] = $this->input->post('atc');

        $args = array('atc_id' => $data['atc']);
        $atc_data = $this->dashboard_model->get_atc_list($args);
        $data['atc_name'] = $atc_data[0]->atc_name;

        $data['bread_title'] = "Total Emergency Dispatch ";
        $data['bread_title_link'] = "total_eme_dispatch";
        $data['bread_title_link_atc'] = "eme_dispatch_atc";

        $data['cluster_link_atc'] = "eme_dispatch_cluster";

        $data['po_data'] = $this->dashboard_model->get_po_by_atc_id($data['atc']);

        foreach ($data['po_data'] as $atc) {

            $cluster_id = get_cluster_by_po($atc->po_id);

            $cluster_ids = implode(",", $cluster_id[$atc->po_id]);

            $atc_screening[$atc->po_id]['po_name'] = $atc->po_name;
            $atc_screening[$atc->po_id]['atc_id'] = $atc->atc_id;
            $atc_screening[$atc->po_id]['po_id'] = $atc->po_id;

            $current_date = date('Y-m-d');
            $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);

            $today_inc = $this->inc_model->get_active_inc_by_cluster($report_args);
            $atc_screening[$atc->po_id]['today_inc'] = $today_inc[0]->total_calls;

            $current_month = date('m');
            $current_year = date('Y');
            $current_month_date = $current_year . '-' . $current_month . '-01';
            $month_args = array('from_date' => date('Y-m-d', strtotime($current_month_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);


            $current_month_inc = $this->inc_model->get_active_inc_by_cluster($month_args);
            $atc_screening[$atc->po_id]['current_month_inc'] = $current_month_inc[0]->total_calls;

            $current_month = date('m');
            $current_year = date('Y');
            $current_month_date = $current_year . '-01-01';

            $year_args = array('from_date' => date('Y-m-d', strtotime($current_month_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);


            $year_total_inc = $this->inc_model->get_active_inc_by_cluster($year_args);
            $atc_screening[$atc->po_id]['year_total_inc'] = $year_total_inc[0]->total_calls;


            $total_args['cluster_id'] = $cluster_ids;
            $total_inc = $this->inc_model->get_active_inc_by_cluster($total_args);
            $atc_screening[$atc->po_id]['total_inc'] = $total_inc[0]->total_calls;
        }
        $data['atc_screening'] = $atc_screening;
        $data['current_date'] = $current_date;

        $this->output->add_to_position($this->load->view('frontend/dash/eme_dispatch_po_view', $data, true), 'content', true);
    }

    function eme_dispatch_cluster() {

        $data['atc'] = $this->input->post('atc');

        $data['po'] = $this->input->post('po');

        $data['bread_title'] = "Total Emergency Dispatch ";
        $data['bread_title_link'] = "total_eme_dispatch";
        $data['bread_title_link_atc'] = "eme_dispatch_atc";
        $data['bread_title_link_po'] = "eme_dispatch_po";

        $data['school_link'] = "eme_dispatch_school";

        $args = array('atc_id' => $data['atc']);
        $atc_data = $this->dashboard_model->get_atc_list($args);
        $data['atc_name'] = $atc_data[0]->atc_name;

        $po_args = array('po_id' => $data['po']);
        $po_data = $this->dashboard_model->get_auto_po_by_atc_id($po_args);
        $data['po_name'] = $po_data[0]->po_name;

        $data['cluter_data'] = $this->dashboard_model->get_cluter_by_po_id($data['po']);

        foreach ($data['cluter_data'] as $atc) {


            $cluster_ids = $atc->cluster_id;

            $atc_screening[$atc->cluster_id]['cluster_name'] = $atc->cluster_name;
            $atc_screening[$atc->cluster_id]['atc_id'] = $atc->atc;
            $atc_screening[$atc->cluster_id]['po_id'] = $atc->po;
            $atc_screening[$atc->cluster_id]['cluster_id'] = $atc->cluster_id;

            $current_date = date('Y-m-d');
            $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);

            $today_inc = $this->inc_model->get_active_inc_by_cluster($report_args);
            $atc_screening[$atc->cluster_id]['today_inc'] = $today_inc[0]->total_calls;

            $current_month = date('m');
            $current_year = date('Y');
            $current_month_date = $current_year . '-' . $current_month . '-01';
            $month_args = array('from_date' => date('Y-m-d', strtotime($current_month_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);


            $current_month_inc = $this->inc_model->get_active_inc_by_cluster($month_args);
            $atc_screening[$atc->cluster_id]['current_month_inc'] = $current_month_inc[0]->total_calls;

            $current_month = date('m');
            $current_year = date('Y');
            $current_month_date = $current_year . '-01-01';

            $year_args = array('from_date' => date('Y-m-d', strtotime($current_month_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'cluster_id' => $cluster_ids);


            $year_total_inc = $this->inc_model->get_active_inc_by_cluster($year_args);
            $atc_screening[$atc->cluster_id]['year_total_inc'] = $year_total_inc[0]->total_calls;


            $total_args['cluster_id'] = $cluster_ids;
            $total_inc = $this->inc_model->get_active_inc_by_cluster($total_args);
            $atc_screening[$atc->cluster_id]['total_inc'] = $total_inc[0]->total_calls;
        }
        $data['atc_screening'] = $atc_screening;
        $data['current_date'] = $current_date;

        $this->output->add_to_position($this->load->view('frontend/dash/eme_dispatch_cluster_view', $data, true), 'content', true);
    }

    function eme_dispatch_school() {

        $data['atc'] = $this->input->post('atc');
        $data['po'] = $this->input->post('po');
        $data['cluster_id'] = $this->input->post('cluster_id');

        $data['bread_title'] = "Total Emergency Dispatch ";
        $data['bread_title_link'] = "total_eme_dispatch";
        $data['bread_title_link_atc'] = "eme_dispatch_atc";
        $data['bread_title_link_po'] = "eme_dispatch_po";
        $data['link_cluster'] = "eme_dispatch_cluster";

        $data['school_data'] = $this->dashboard_model->get_school_by_cluster_id($data['cluster_id']);


        $this->output->add_to_position($this->load->view('frontend/dash/school_view', $data, true), 'content', true);
    }

    function amb_inv_status() {

        $args['eqp_type'] = 'amb';
        $args['eqp_ids'] = 'EQP';
        $eqp_total = $this->eqp_model->get_eqp_dash($args);


        $data = array();
        $eqp['total_qty'] = 0;
        $data['avail_qty'] = 0;
        $data['functional_qty'] = 0;
        foreach ($eqp_total as $eqp) {

            $data['total_qty'] = $data['total_qty'] + $eqp->in_stk;
            $available = $eqp->in_stk - $eqp->out_stk;
            $data['avail_qty'] = $data['avail_qty'] + $available;
            $data['functional_qty'] = $data['functional_qty'] + $eqp->out_stk;
        }

        if (mi_empty($this->input->post('cluster'))) {

            foreach ($eqp_total as $item) {

                $args = array('med_id' => $item->eqp_id,
                    'type' => 'EQP',
                    'req_type' => 'amb');

                $item_avail_list = $this->med_model->get_med_out_stock($args);
                $item_min_in_qty = $this->med_model->get_med_in_stock($args);

                $item_min_in_qty = (array) $item_min_in_qty;
                $item_avail_list = (array) $item_avail_list;

                if (!empty($item_min_in_qty)) {
                    $item->in_stk = $item_min_in_qty['in_stk'];
                } else {
                    $item->in_stk = 0;
                }


                $item->out_stk = $item_avail_list['out_stk'];

                if ($item->in_stk > 0) {
                    $available_stock = $item->in_stk - $item->out_stk;
                } else {
                    //$available_stock =  $item->med_base_quantity - $item->out_stk;
                    $available_stock = 0;
                }

                $item->available_stk = $available_stock;
                $item_list_data[] = $item;
            }
        } else {

            $post = $this->input->post('cluster');


            $atc = $post['atc'];
            $po = $post['po'];
            $cluster_id = $post['cluster_id'];
            $data['cluster'] = $post;


            if (!empty($atc)) {
                $atc_args = array('atc_id' => $atc);
                $data['atc_data'] = $this->dashboard_model->get_atc_list($atc_args);
            }

            if (!empty($po)) {
                $po_args = array('po_id' => $po);
                $data['po_data'] = $this->dashboard_model->get_auto_po_by_atc_id($po_args);
            }

            if (!empty($cluster_id)) {
                $cluster_args = array('cluster_id' => $cluster_id);
                $data['cluster_data'] = $this->cluster_model->get_cluster_data($cluster_args);
            }

            $cluster_ids = array();

            if ($cluster_id) {

                $cluster_ids = $cluster_id;
            } else if ($po) {

                $po_cluster_ids = $this->dashboard_model->get_cluter_by_po_id($po);
                foreach ($po_cluster_ids as $po_cluster) {
                    $cluster_ids[] = $po_cluster->cluster_id;
                }
                $cluster_ids = implode(",", $cluster_ids);
            } else if ($atc) {

                $atc_args = array('atc' => $atc);
                $atc_cluster_ids = $this->cluster_model->get_cluster_data($atc_args);
                foreach ($atc_cluster_ids as $po_cluster) {
                    $cluster_ids[] = $po_cluster->cluster_id;
                }
                $cluster_ids = implode(",", $cluster_ids);
            }
            // var_dump($cluster_ids);
            foreach ($eqp_total as $item) {

                $args = array('med_id' => $item->eqp_id,
                    'type' => 'EQP',
                    'req_type' => 'amb');

                if (!empty($cluster_ids)) {
                    $args['cluster_id'] = $cluster_ids;
                }
                //  var_dump($args); die();

                $item_avail_list = $this->med_model->get_med_out_stock_cluster($args);
                $item_min_in_qty = $this->med_model->get_med_in_stock_cluster($args);

                //var_dump($item_min_in_qty);

                $item_min_in_qty = (array) $item_min_in_qty;
                $item_avail_list = (array) $item_avail_list;

                if (!empty($item_min_in_qty)) {
                    $item->in_stk = $item_min_in_qty['in_stk'];
                } else {
                    $item->in_stk = 0;
                }


                $item->out_stk = $item_avail_list['out_stk'];

                if ($item->in_stk > 0) {
                    $available_stock = $item->in_stk - $item->out_stk;
                } else {
                    //$available_stock =  $item->med_base_quantity - $item->out_stk;
                    $available_stock = 0;
                }

                $item->available_stk = $available_stock;
                $item_list_data[] = $item;
            }
        }

        //var_dump($item_list_data);
        $data['item_list'] = $item_list_data;


        $this->output->add_to_position($this->load->view('frontend/dash/amb_inv_status_view', $data, true), 'content', true);
    }

    function amb_inv_status_atc() {
        $data['bread_title'] = "Ambulance Inventory Status - Equipment ";
        $data['bread_title_link'] = "total_amb_inv_status";
        $data['atc_data'] = $this->dashboard_model->get_atc_list();

        $data['atc_po_linke'] = 'amb_inv_status_po';

        $this->output->add_to_position($this->load->view('frontend/dash/amb_inv_status_atc_view', $data, true), 'content', true);
    }

    function amb_inv_status_po() {

        $data['atc'] = $this->input->post('atc');

        $data['bread_title'] = "Ambulance Inventory Status - Equipment ";
        $data['bread_title_link'] = "total_amb_inv_status";
        $data['bread_title_link_atc'] = "amb_inv_status_atc";

        $data['cluster_link_atc'] = "amb_inv_status_cluster";

        $data['po_data'] = $this->dashboard_model->get_po_by_atc_id($data['atc']);
        $this->output->add_to_position($this->load->view('frontend/dash/po_view', $data, true), 'content', true);
    }

    function amb_inv_status_cluster() {

        $data['atc'] = $this->input->post('atc');

        $data['po'] = $this->input->post('po');

        $data['bread_title'] = "Ambulance Inventory Status - Equipment ";
        $data['bread_title_link'] = "total_amb_inv_status";
        $data['bread_title_link_atc'] = "amb_inv_status_atc";
        $data['bread_title_link_po'] = "amb_inv_status_po";

        $data['school_link'] = "amb_inv_status_school";

        $data['cluter_data'] = $this->dashboard_model->get_cluter_by_po_id($data['po']);
        $this->output->add_to_position($this->load->view('frontend/dash/cluster_view', $data, true), 'content', true);
    }

    function amb_inv_status_school() {

        $data['atc'] = $this->input->post('atc');
        $data['po'] = $this->input->post('po');
        $data['cluster_id'] = $this->input->post('cluster_id');

        $data['bread_title'] = "Ambulance Inventory Status - Equipment ";
        $data['bread_title_link'] = "total_amb_inv_status";
        $data['bread_title_link_atc'] = "amb_inv_status_atc";
        $data['bread_title_link_po'] = "amb_inv_status_po";
        $data['link_cluster'] = "amb_inv_status_cluster";

        $data['school_data'] = $this->dashboard_model->get_school_by_cluster_id($data['cluster_id']);


        $this->output->add_to_position($this->load->view('frontend/dash/school_view', $data, true), 'content', true);
    }

    function sick_inv_status_atc() {
        $data['bread_title'] = "Sick Room Inventory Status - Medicines ";
        $data['bread_title_link'] = "total_sick_inv_status";
        $data['atc_data'] = $this->dashboard_model->get_atc_list();

        $data['atc_po_linke'] = 'sick_inv_status_po';

        $this->output->add_to_position($this->load->view('frontend/dash/atc_view', $data, true), 'content', true);
    }

    function sick_inv_status_po() {

        $data['atc'] = $this->input->post('atc');

        $data['bread_title'] = "Sick Room Inventory Status - Medicines ";
        $data['bread_title_link'] = "total_sick_inv_status";
        $data['bread_title_link_atc'] = "sick_inv_status_atc";

        $data['cluster_link_atc'] = "sick_inv_status_cluster";

        $data['po_data'] = $this->dashboard_model->get_po_by_atc_id($data['atc']);
        $this->output->add_to_position($this->load->view('frontend/dash/po_view', $data, true), 'content', true);
    }

    function sick_inv_status_cluster() {

        $data['atc'] = $this->input->post('atc');

        $data['po'] = $this->input->post('po');

        $data['bread_title'] = "Sick Room Inventory Status - Medicines ";
        $data['bread_title_link'] = "total_sick_inv_status";
        $data['bread_title_link_atc'] = "sick_inv_status_atc";
        $data['bread_title_link_po'] = "sick_inv_status_po";

        $data['school_link'] = "sick_inv_status_school";

        $data['cluter_data'] = $this->dashboard_model->get_cluter_by_po_id($data['po']);
        $this->output->add_to_position($this->load->view('frontend/dash/cluster_view', $data, true), 'content', true);
    }

    function sick_inv_status_school() {

        $data['atc'] = $this->input->post('atc');
        $data['po'] = $this->input->post('po');
        $data['cluster_id'] = $this->input->post('cluster_id');

        $data['bread_title'] = "Sick Room Inventory Status - Medicines ";
        $data['bread_title_link'] = "total_sick_inv_status";
        $data['bread_title_link_atc'] = "sick_inv_status_atc";
        $data['bread_title_link_po'] = "sick_inv_status_po";
        $data['link_cluster'] = "sick_inv_status_cluster";

        $data['school_data'] = $this->dashboard_model->get_school_by_cluster_id($data['cluster_id']);


        $this->output->add_to_position($this->load->view('frontend/dash/school_view', $data, true), 'content', true);
    }

    function amb_inv_status_drug() {

        //$data['drugs'] = $this->common_model->get_drugs($$args);


        $args['req_type'] = 'amb';
        $data['item_avail_list'] = $this->inv_model->get_inv_dashboard($args);

        $med_args = array('med_type' => 'amb');
        $item_list = $this->inv_model->get_dashboard_med_name($med_args);
        $item_list_data = array();

        if (mi_empty($this->input->post('cluster'))) {

            foreach ($item_list as $item) {

                $args = array('med_id' => $item->med_id,
                    'type' => 'MED',
                    'req_type' => 'amb');

                $item_avail_list = $this->med_model->get_med_out_stock($args);
                $item_min_in_qty = $this->med_model->get_med_in_stock($args);

                $item_min_in_qty = (array) $item_min_in_qty;
                $item_avail_list = (array) $item_avail_list;

                if (!empty($item_min_in_qty)) {
                    $item->in_stk = $item_min_in_qty['in_stk'];
                } else {
                    $item->in_stk = 0;
                }


                $item->out_stk = $item_avail_list['out_stk'];

                if ($item->in_stk > $item->out_stk) {
                    $available_stock = $item->in_stk - $item->out_stk;
                } else {
                    //$available_stock =  $item->med_base_quantity - $item->out_stk;
                    $available_stock = $item->in_stk;
                }

                $item->available_stk = $available_stock;
                $item_list_data[] = $item;
            }
        } else {

            $post = $this->input->post('cluster');

            $atc = $post['atc'];
            $po = $post['po'];
            $cluster_id = $post['cluster_id'];
            $data['cluster'] = $post;


            if (!empty($atc)) {
                $atc_args = array('atc_id' => $atc);
                $data['atc_data'] = $this->dashboard_model->get_atc_list($atc_args);
            }

            if (!empty($po)) {
                $po_args = array('po_id' => $po);
                $data['po_data'] = $this->dashboard_model->get_auto_po_by_atc_id($po_args);
            }

            if (!empty($cluster_id)) {
                $cluster_args = array('cluster_id' => $cluster_id);
                $data['cluster_data'] = $this->cluster_model->get_cluster_data($cluster_args);
            }

            $cluster_ids = array();

            if ($cluster_id) {

                $cluster_ids = $cluster_id;
            } else if ($po) {
                $po_cluster_ids = $this->dashboard_model->get_cluter_by_po_id($po);
                foreach ($po_cluster_ids as $po_cluster) {
                    $cluster_ids[] = $po_cluster->cluster_id;
                }
                $cluster_ids = implode(",", $cluster_ids);
            } else if ($atc) {
                $atc_args = array('atc' => $atc);
                $atc_cluster_ids = $this->cluster_model->get_cluster_data($atc_args);
                foreach ($atc_cluster_ids as $po_cluster) {
                    $cluster_ids[] = $po_cluster->cluster_id;
                }
                $cluster_ids = implode(",", $cluster_ids);
            }
            //   var_dump($cluster_ids);

            foreach ($item_list as $item) {

                $args = array('med_id' => $item->med_id,
                    'type' => 'MED',
                    'req_type' => 'amb');

                if (!empty($cluster_ids)) {
                    $args['cluster_id'] = $cluster_ids;
                }


                $item_avail_list = $this->med_model->get_med_out_stock_cluster($args);
                $item_min_in_qty = $this->med_model->get_med_in_stock_cluster($args);

                $item_min_in_qty = (array) $item_min_in_qty;
                $item_avail_list = (array) $item_avail_list;

                if (!empty($item_min_in_qty)) {
                    $item->in_stk = $item_min_in_qty['in_stk'];
                } else {
                    $item->in_stk = 0;
                }


                $item->out_stk = $item_avail_list['out_stk'];

                if ($item->in_stk > 0) {
                    $available_stock = $item->in_stk - $item->out_stk;
                } else {
                    //$available_stock =  $item->med_base_quantity - $item->out_stk;
                    $available_stock = 0;
                }

                $item->available_stk = $available_stock;
                $item_list_data[] = $item;
            }
        }

        $data['item_list'] = $item_list_data;

        $this->output->add_to_position($this->load->view('frontend/dash/amb_inv_status_drug_view', $data, true), 'content', true);
    }

    function amb_inv_status_drug_atc() {
        $data['bread_title'] = "Ambulance Inventory Status - Medicines";
        $data['bread_title_link'] = "amb_inv_status_drug";
        $data['atc_data'] = $this->dashboard_model->get_atc_list();


        foreach ($data['atc_data'] as $atc) {

            $cluster_id = get_cluster_by_atc($atc->atc_id);
            $cluster_ids = implode(",", $cluster_id[$atc->atc_id]);


            $atc_screening[$atc->atc_id]['atc_name'] = $atc->atc_name;
            $atc_screening[$atc->atc_id]['atc_id'] = $atc->atc_id;
        }
        $data['atc_screening'] = $atc_screening;

        $data['atc_po_linke'] = 'amb_inv_status_drug_po';

        $this->output->add_to_position($this->load->view('frontend/dash/amb_inv_status_drug_atc_view', $data, true), 'content', true);
    }

    function amb_inv_status_drug_po() {

        $data['atc'] = $this->input->post('atc');

        $args = array('atc_id' => $data['atc']);
        $atc_data = $this->dashboard_model->get_atc_list($args);
        $data['atc_name'] = $atc_data[0]->atc_name;

        $data['po_data'] = $this->dashboard_model->get_po_by_atc_id($data['atc']);

        foreach ($data['po_data'] as $atc) {

            $cluster_id = get_cluster_by_po($atc->po_id);

            $cluster_ids = implode(",", $cluster_id[$atc->po_id]);

            $atc_screening[$atc->po_id]['po_name'] = $atc->po_name;
            $atc_screening[$atc->po_id]['atc_id'] = $atc->atc_id;
            $atc_screening[$atc->po_id]['po_id'] = $atc->po_id;
        }
        $data['atc_screening'] = $atc_screening;


        $data['bread_title'] = "Ambulance Inventory Status - Medicines  ";
        $data['bread_title_link'] = "amb_inv_status_drug";
        $data['bread_title_link_atc'] = "amb_inv_status_drug_atc";

        $data['cluster_link_atc'] = "amb_inv_status_drug_cluster";


        $this->output->add_to_position($this->load->view('frontend/dash/amb_inv_status_drug_po_view', $data, true), 'content', true);
    }

    function amb_inv_status_drug_cluster() {

        $data['atc'] = $this->input->post('atc');

        $data['po'] = $this->input->post('po');

        $data['bread_title'] = "Ambulance Inventory Status - Medicines ";
        $data['bread_title_link'] = "amb_inv_status_drug";
        $data['bread_title_link_atc'] = "amb_inv_status_drug_atc";
        $data['bread_title_link_po'] = "amb_inv_status_drug_po";

        $data['school_link'] = "amb_inv_status_drug_school";

        $data['cluter_data'] = $this->dashboard_model->get_cluter_by_po_id($data['po']);
        $this->output->add_to_position($this->load->view('frontend/dash/amb_inv_status_drug_cluster_view', $data, true), 'content', true);
    }

    function amb_inv_status_drug_school() {

        $data['atc'] = $this->input->post('atc');
        $data['po'] = $this->input->post('po');
        $data['cluster_id'] = $this->input->post('cluster_id');

        $data['bread_title'] = "Ambulance Inventory Status - Medicines ";
        $data['bread_title_link'] = "amb_inv_status_drug";
        $data['bread_title_link_atc'] = "amb_inv_status_drug_atc";
        $data['bread_title_link_po'] = "amb_inv_status_drug_po";
        $data['link_cluster'] = "amb_inv_status_drug_cluster";

        $data['school_data'] = $this->dashboard_model->get_school_by_cluster_id($data['cluster_id']);


        $this->output->add_to_position($this->load->view('frontend/dash/amb_inv_status_drug_school_view', $data, true), 'content', true);
    }

    function sick_room_inv_status() {



        $args['eqp_type'] = 'sickroom';
        $args['eqp_ids'] = 'EQP';
        $eqp_total = $this->eqp_model->get_eqp_dash($args);


        $data = array();
        $eqp['total_qty'] = 0;
        $data['avail_qty'] = 0;
        $data['functional_qty'] = 0;
        foreach ($eqp_total as $eqp) {

            $data['total_qty'] = $data['total_qty'] + $eqp->in_stk;
            $available = $eqp->in_stk - $eqp->out_stk;
            $data['avail_qty'] = $data['avail_qty'] + $available;
            $data['functional_qty'] = $data['functional_qty'] + $eqp->out_stk;
        }

        if (mi_empty($this->input->post('cluster'))) {

            foreach ($eqp_total as $item) {

                $args = array('med_id' => $item->eqp_id,
                    'type' => 'EQP',
                    'req_type' => 'sick_room');

                $item_avail_list = $this->med_model->get_med_out_stock($args);
                $item_min_in_qty = $this->med_model->get_med_in_stock($args);

                $item_min_in_qty = (array) $item_min_in_qty;
                $item_avail_list = (array) $item_avail_list;

                if (!empty($item_min_in_qty)) {
                    $item->in_stk = $item_min_in_qty['in_stk'];
                } else {
                    $item->in_stk = 0;
                }


                $item->out_stk = $item_avail_list['out_stk'];

                if ($item->in_stk > 0) {
                    $available_stock = $item->in_stk - $item->out_stk;
                } else {
                    //$available_stock =  $item->med_base_quantity - $item->out_stk;
                    $available_stock = 0;
                }

                $item->available_stk = $available_stock;
                $item_list_data[] = $item;
            }
        } else {

            $post = $this->input->post('cluster');

            $atc = $post['atc'];
            $po = $post['po'];
            $cluster_id = $post['cluster_id'];
            $data['cluster'] = $post;


            if (!empty($atc)) {
                $atc_args = array('atc_id' => $atc);
                $data['atc_data'] = $this->dashboard_model->get_atc_list($atc_args);
            }

            if (!empty($po)) {
                $po_args = array('po_id' => $po);
                $data['po_data'] = $this->dashboard_model->get_auto_po_by_atc_id($po_args);
            }

            if (!empty($cluster_id)) {
                $cluster_args = array('cluster_id' => $cluster_id);
                $data['cluster_data'] = $this->cluster_model->get_cluster_data($cluster_args);
            }

            $cluster_ids = array();

            if ($cluster_id) {

                $cluster_ids = $cluster_id;
            } else if ($po) {
                $po_cluster_ids = $this->dashboard_model->get_cluter_by_po_id($po);
                foreach ($po_cluster_ids as $po_cluster) {
                    $cluster_ids[] = $po_cluster->cluster_id;
                }
                $cluster_ids = implode(",", $cluster_ids);
            } else if ($atc) {
                $atc_args = array('atc' => $atc);
                $atc_cluster_ids = $this->cluster_model->get_cluster_data($atc_args);
                foreach ($atc_cluster_ids as $po_cluster) {
                    $cluster_ids[] = $po_cluster->cluster_id;
                }
                $cluster_ids = implode(",", $cluster_ids);
            }

            foreach ($eqp_total as $item) {

                $args = array('med_id' => $item->eqp_id,
                    'type' => 'EQP',
                    'req_type' => 'sick_room');

                if (!empty($cluster_ids)) {
                    $args['cluster_id'] = $cluster_ids;
                }

                $item_avail_list = $this->med_model->get_med_sick_out_stock_cluster($args);
                $item_min_in_qty = $this->med_model->get_med_sick_in_stock_cluster($args);

                $item_min_in_qty = (array) $item_min_in_qty;
                $item_avail_list = (array) $item_avail_list;

                if (!empty($item_min_in_qty)) {
                    $item->in_stk = $item_min_in_qty['in_stk'];
                } else {
                    $item->in_stk = 0;
                }


                $item->out_stk = $item_avail_list['out_stk'];

                if ($item->in_stk > 0) {
                    $available_stock = $item->in_stk - $item->out_stk;
                } else {
                    //$available_stock =  $item->med_base_quantity - $item->out_stk;
                    $available_stock = 0;
                }

                $item->available_stk = $available_stock;
                $item_list_data[] = $item;
            }
        }

        //var_dump($item_list_data);
        $data['item_list'] = $item_list_data;


        // $this->output->add_to_position($this->load->view('frontend/dash/amb_inv_status_view', $data, true), 'content', true);


        $this->output->add_to_position($this->load->view('frontend/dash/sick_room_inv_status_view', $data, true), 'content', true);
    }

    function sick_room_inv_status_atc() {
        $data['bread_title'] = "Sick Inventory Status - Medicines";
        $data['bread_title_link'] = "sick_room_inv_status";
        $data['atc_data'] = $this->dashboard_model->get_atc_list();

        $data['atc_po_linke'] = 'sick_room_inv_status_po';

        foreach ($data['atc_data'] as $atc) {

            $cluster_id = get_cluster_by_atc($atc->atc_id);
            $cluster_ids = implode(",", $cluster_id[$atc->atc_id]);


            $atc_screening[$atc->atc_id]['atc_name'] = $atc->atc_name;
            $atc_screening[$atc->atc_id]['atc_id'] = $atc->atc_id;
            $args = array('cluster_id' => $cluster_ids);
        }
        $data['atc_screening'] = $atc_screening;

        $this->output->add_to_position($this->load->view('frontend/dash/sick_room_inv_status_atc_view', $data, true), 'content', true);
    }

    function sick_room_inv_status_po() {

        $data['atc'] = $this->input->post('atc');

        $data['bread_title'] = "Sick Inventory Status - Medicines ";
        $data['bread_title_link'] = "sick_room_inv_status";
        $data['bread_title_link_atc'] = "sick_room_inv_status_atc";

        $data['cluster_link_atc'] = "sick_room_inv_status_cluster";

        $args = array('atc_id' => $data['atc']);
        $atc_data = $this->dashboard_model->get_atc_list($args);
        $data['atc_name'] = $atc_data[0]->atc_name;

        $data['po_data'] = $this->dashboard_model->get_po_by_atc_id($data['atc']);

        foreach ($data['po_data'] as $atc) {

            $cluster_id = get_cluster_by_po($atc->po_id);

            $cluster_ids = implode(",", $cluster_id[$atc->po_id]);

            $atc_screening[$atc->po_id]['po_name'] = $atc->po_name;
            $atc_screening[$atc->po_id]['atc_id'] = $atc->atc_id;
            $atc_screening[$atc->po_id]['po_id'] = $atc->po_id;

            $args = array('cluster_id' => $cluster_ids);
        }
        $data['atc_screening'] = $atc_screening;

        $this->output->add_to_position($this->load->view('frontend/dash/sick_inv_status_po_view', $data, true), 'content', true);
    }

    function sick_room_inv_status_cluster() {

        $data['atc'] = $this->input->post('atc');

        $data['po'] = $this->input->post('po');

        $args = array('atc_id' => $data['atc']);
        $atc_data = $this->dashboard_model->get_atc_list($args);
        $data['atc_name'] = $atc_data[0]->atc_name;

        $po_args = array('po_id' => $data['po']);
        $po_data = $this->dashboard_model->get_auto_po_by_atc_id($po_args);
        $data['po_name'] = $po_data[0]->po_name;

        $data['bread_title'] = "Sick Inventory Status - Medicines";
        $data['bread_title_link'] = "sick_room_inv_status";
        $data['bread_title_link_atc'] = "sick_room_inv_status_atc";
        $data['bread_title_link_po'] = "sick_room_inv_status_po";

        $data['school_link'] = "sick_room_inv_status_school";

        $data['cluter_data'] = $this->dashboard_model->get_cluter_by_po_id($data['po']);

        foreach ($data['cluter_data'] as $atc) {

            $cluster_ids = $atc->cluster_id;

            $atc_screening[$atc->cluster_id]['cluster_name'] = $atc->cluster_name;
            $atc_screening[$atc->cluster_id]['atc_id'] = $atc->atc;
            $atc_screening[$atc->cluster_id]['po_id'] = $atc->po;
            $atc_screening[$atc->cluster_id]['cluster_id'] = $atc->cluster_id;
        }

        $data['atc_screening'] = $atc_screening;


        $this->output->add_to_position($this->load->view('frontend/dash/sick_room_inv_status_cluster_view', $data, true), 'content', true);
    }

    function sick_room_inv_status_school() {

        $data['atc'] = $this->input->post('atc');
        $data['po'] = $this->input->post('po');
        $data['cluster_id'] = $this->input->post('cluster_id');

        $data['bread_title'] = "Sick Inventory Status - Medicines";
        $data['bread_title_link'] = "sick_room_inv_status";
        $data['bread_title_link_atc'] = "sick_room_inv_status_atc";
        $data['bread_title_link_po'] = "sick_room_inv_status_po";
        $data['link_cluster'] = "sick_room_inv_status_cluster";

        $data['school_data'] = $this->dashboard_model->get_school_by_cluster_id($data['cluster_id']);


        $this->output->add_to_position($this->load->view('frontend/dash/school_view', $data, true), 'content', true);
    }

    function get_dash_auto_po() {

        $data['atc_id'] = $this->input->post('atc_id');
        $this->output->add_to_position($this->load->view('frontend/common/dash_auto_po_view', $data, TRUE), 'get_auto_po_by_atc', TRUE);
    }

    function get_dash_auto_po_clg() {

        $data['atc_id'] = $this->input->post('atc_id');
        $this->output->add_to_position($this->load->view('frontend/common/dash_auto_po_clg_view', $data, TRUE), 'get_auto_po_by_atc', TRUE);
    }

    function get_auto_cluster() {

        $data['po_id'] = $this->input->post('po_id');
        $this->output->add_to_position($this->load->view('frontend/common/auto_cluster_po_view', $data, TRUE), 'get_auto_cluster_by_po', TRUE);
    }

    function get_auto_cluster_clg() {

        $data['po_id'] = $this->input->post('po_id');
        //var_dump( $data['po_id'] );
        $this->output->add_to_position($this->load->view('frontend/common/auto_cluster_po_clg_view', $data, TRUE), 'get_auto_cluster_by_po', TRUE);
    }
    
    public function push_closure_validate_data_to_gps(){
        //var_dump('hii');die();
        $data = $this->dashboard_model->get_push_closure_validate_date();
        if(!empty($data)){
            $gpspass = array();
            foreach($data as $data1){
                if($data1['ct_type'] != ''){
                    $chief_complaint = $data1['ct_type'];
                }else{
                    $chief_complaint = $data1['ntr_nature'];
                }
		        $gps = array();
                $veh = implode('',explode('-',$data1['amb_rto_register_no']));
                // if($veh == "TT00MP0000"){
                    // $veh = strtolower(implode('',explode('-',$data1['amb_rto_register_no'])));
                // die;
                $gps['ProjectType'] = '108';
                $gps['EmType'] = $data1['pname'];
                $gps['CallDateTime'] = date('Y-m-d H:i', strtotime($data1['inc_recive_time']));
                $gps['JobNo'] = $data1['inc_ref_id'];
                $gps['AmbulanceNo'] = $veh;
                $gps['DispatchedDateTime'] = date('Y-m-d H:i', strtotime($data1['inc_datetime']));
                $gps['ReachedtosceneDateTime'] = date('Y-m-d H:i', strtotime($data1['dp_on_scene']));
                if($data1['epcr_call_type'] == 2 && $data1['pname'] != "Drop Back"){

                    if($data1['rec_hospital_name'] == 'Other'){
                        $hosp = $data1['other_receiving_host'];
                        $hospType = "NA";
                    }else{
                        $hospTypeName = $this->dashboard_model->getHospitalTypeAndName($data1['rec_hospital_name']);
                        if(!empty($hospTypeName)){
                            $hosp = $hospTypeName[0]['hp_name'];
                            $hospType = $data1[0]['full_name'];
                        }else{
                            $hosp = 'NA';
                            $hospType = 'NA';
                        }
                        
                    }
                    // if($data1['rec_hospital_name'] == 'Other' || $data1['rec_hospital_name'] == '' || $data1['rec_hospital_name'] == null){
                    //     //echo 'lll';die;
                    //     $hosp = $data1['other_receiving_host'];
                    //     $hospType = "NA";
                    // } 
                    // if($data1['rec_hospital_name'] != 'Other' || $data1['rec_hospital_name'] != '' || $data1['rec_hospital_name'] != null){
                    //     $hosp = $data1['hp_name'];
                    //     $hospType = $data1['full_name'];
                    // }
                    // if($data1['rec_hospital_name'] == "" && $data1['other_receiving_host'] == ""){
                    //     $hosp = "NA";
                    //     $hospType = "NA";
                    // }
                    $gps['DropHospital'] = $hosp;
                    $gps['HospitalType'] = $hospType;
                    $gps['DropDateTime'] = date('Y-m-d H:i', strtotime($data1['dp_hosp_time']));
                }else{
                    $gps['DropHospital'] = "NA";
                    $gps['HospitalType'] = "NA";
                    $gps['DropDateTime'] = date('Y-m-d H:i', strtotime($data1['dp_back_to_loc']));
                }
                
                // else if($data1['epcr_call_type'] == 2 && $data1['pname'] == "Drop Back"){
                //     $gps['DropHospital'] = "NA";
                //     $gps['HospitalType'] = "NA";
                //     $gps['DropDateTime'] = date('Y-m-d H:i', strtotime($data1['dp_back_to_loc']));
                // }else if($data1['epcr_call_type'] == 1 || $data1['pname'] == "Drop Back"){
                //     $gps['DropHospital'] = "NA";
                //     $gps['HospitalType'] = "NA";
                //     $gps['DropDateTime'] = date('Y-m-d H:i', strtotime($data1['dp_back_to_loc']));
                // }else if($data1['epcr_call_type'] == 3 || $data1['pname'] == "Drop Back"){
                //     $gps['DropHospital'] = "NA";
                //     $gps['HospitalType'] = "NA";
                //     $gps['DropDateTime'] = date('Y-m-d H:i', strtotime($data1['dp_back_to_loc']));
                // }
                $gps['BacktobaseDatetime'] = date('Y-m-d H:i', strtotime($data1['dp_back_to_loc']));
                $gps['TripDistance'] = $data1['end_odometer'] - $data1['start_odometer'];
                $gps['stateCode'] = "MP";
                $gps['ClosingStatus'] = "closed";
                $gps['EmergencyChiefComplaint'] = $chief_complaint;   //$data1['pro_name'];
                $gps['AyushmanCard'] = isset($data1['ayushman_id']) ? $data1['ayushman_id'] : 'NA';
                if($data1['ayushman_id'] == '' || $data1['ayushman_id'] == 'NA'){
                    $gps['Exemption'] = "no";
                }else{
                    $gps['Exemption'] = "yes";
                }
                
                // $this->dashboard_model->insert_gps_data($gps);
                // die;
                $data_string = array();
                $data_string['AmbulanceTripStatus'] = array($gps);
                $data_string = json_encode($data_string);
                echo $data_string;die;
                $curl = curl_init('http://13.235.213.74:5577');
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json')
                );
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);  // Insert the data
                //curl_setopt($curl, CURLOPT_TIMEOUT, 15 );
                $result = curl_exec($curl);
                $decodedText = html_entity_decode($result);
                $myArray = json_decode($decodedText, true);
                $output = $myArray['status'];
                $gps['addedDateTime'] = date('Y-m-d H:i:s');
                $gps['apiRes'] = $output;
                $gps['apiWholeRes'] = $result;
                $gps['remark'] = 'cron';
//var_dump($output);

                $this->dashboard_model->insert_gps_data($gps);
                if(!empty($data1['inc_ref_id'])){
                    if($output == "SUCCESS"){
                    	$this->dashboard_model->update_inc_pcr_status($data1['inc_ref_id']);
		            }else{
                    	$this->dashboard_model->update_inc_pcr_status_fail($data1['inc_ref_id']);
		            }
                }
                array_push($gpspass,$gps);
                // }
            }
        }
        echo 'sucess';
        //print_r(json_encode($gpspass));
        die();
    }
    public function inc_table_update_gps_rec(){
        $data = $this->dashboard_model->get_inc_table_update_gps_rec();
        foreach($data as $data1){
            $inc = $data1['JobNo'];
            $gpsRec['closure_data_pass_to_gps'] = '1';
            $updaterec = $this->dashboard_model->update_gps_rec_in_inc_table($inc,$gpsRec);
            if($updaterec == 1){
                echo 'sucess';
            }
        }
        die();
    }
    
    public function get_gps_data_and_pass(){
        $data = $this->dashboard_model->get_gps_data_status_three_fail();
        foreach($data as $data1){
            $gps['ProjectType'] = $data1['ProjectType'];
            $gps['EmType'] = $data1['EmType'];
            $gps['CallDateTime'] = $data1['CallDateTime'];
            $gps['JobNo'] = $data1['JobNo'];
            $gps['AmbulanceNo'] = $data1['AmbulanceNo'];
            $gps['DispatchedDateTime'] = $data1['DispatchedDateTime'];
            $gps['ReachedtosceneDateTime'] = $data1['ReachedtosceneDateTime'];
            $gps['DropHospital'] = $data1['DropHospital'];
            $gps['HospitalType'] = $data1['HospitalType'];
            $gps['DropDateTime'] = $data1['DropDateTime'];
            $gps['BacktobaseDatetime'] = $data1['BacktobaseDatetime'];
            $gps['TripDistance'] = $data1['TripDistance'];
            $gps['stateCode'] = $data1['stateCode'];
            $gps['ClosingStatus'] = $data1['ClosingStatus'];
            $gps['EmergencyChiefComplaint'] = $data1['EmergencyChiefComplaint'];
            $gps['AyushmanCard'] = $data1['AyushmanCard'];
            $gps['Exemption'] = $data1['Exemption'];
            $data_string = array();
            $data_string['AmbulanceTripStatus'] = array($gps);
            $data_string = json_encode($data_string);
            //echo $data_string;die;
            $curl = curl_init('http://13.235.213.74:5577');
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json')
            );
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);  // Insert the data
            //curl_setopt($curl, CURLOPT_TIMEOUT, 15 );
            $result = curl_exec($curl);
            $decodedText = html_entity_decode($result);
            $myArray = json_decode($decodedText, true);
            $output = $myArray['status'];
            $gps['addedDateTime'] = date('Y-m-d H:i:s');
            $gps['apiRes'] = $output;
            $gps['apiWholeRes'] = $result;
            $gps['remark'] = 'cron';
            $gps['closure_data_pass_to_gps'] = '4';
            $this->dashboard_model->insert_gps_data($gps);
            $this->dashboard_model->update_gps_data($data1['JobNo']);
            if(!empty($data1['inc_ref_id'])){
                if($output == "SUCCESS"){
                    $this->dashboard_model->update_inc_pcr_status($data1['inc_ref_id']);
                }else{
                    $this->dashboard_model->update_inc_pcr_status_fail($data1['inc_ref_id']);
                }
            }
        }
        die();
    }
    public function update_hosp(){
        $data = $this->dashboard_model->get_hosp_rec();
        foreach($data as $data1){
            if($data1['rec_hospital_name'] == 'Other' || $data1['rec_hospital_name'] == '' || $data1['rec_hospital_name'] == 'Patient_Not_Available'){
                $gps['DropHospital'] = $data1['other_receiving_host'];
                $gps['HospitalType'] = 'NA';
                $jobno = $data1['inc_ref_id'];
            }else{
                $hosp = $this->dashboard_model->get_hosp_name($data1['rec_hospital_name']);
                if(!empty($hosp)){
                    $gps['DropHospital'] = $hosp[0]['hp_name'];
                    $gps['HospitalType'] = $hosp[0]['hosp_type'];
                    $jobno = $data1['inc_ref_id'];
                }
            }
            $this->dashboard_model->update_gps_data_fail($gps,$jobno);
        }
        print_r($data);die;
    }

    function dispatch_data_to_gps(){
        $data = $this->dashboard_model->get_inc_table_update_gps_rec1();
        foreach($data as $data1){
            $inc_id = $data1['JobNo'];
            $LastActivityTime = $data1['LastActivityTime'];
            $Caller_Location = $data1['Caller_Location'];
            $Hospital_Location = $data1['Hospital_Location'];
            $HospitalLatlong = $data1['HospitalLatlong'];
            // $AmbulanceNo = $data1['AmbulanceNo'];
            $AmbulanceNo = $data1['amb_no'];
            $id = $data1['id'];
           $select_amb_API= str_replace('-','',$data1['amb_no']);
        
            $args = array(
                'id' => $id,
                'LastActivityTime' => "$datetime" ,
                'JobStatus' => 'Dispatched' ,
                'onRoadStatus' =>'1' ,
                'Caller_Location' => "$Caller_Location",
                'Hospital_Location' => "$Hospital_Location",
                'JobNo' => "$inc_id",
                'HospitalLatlong' => "$hos_lat".','."$hos_lng",
                'stateCode' => 'MP',
                'AmbulanceNo' =>"$select_amb_API",
                // 'AmbulanceNo' =>"$AmbulanceNo",
                'CallerLatlong' =>"$caller_lat".','."$caller_lng"
            );
            $send_API = send_API_manual($args);
          
            
        }
       // die();
    }

}
