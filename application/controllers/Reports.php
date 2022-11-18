<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends EMS_Controller
{

    function __construct()
    {

        parent::__construct();

        $this->active_module = "M-REPORTS";

        $this->pg_limit = $this->config->item('pagination_limit_clg');

        $this->pg_limits = $this->config->item('report_clg');
        $this->load->model(array('colleagues_model', 'get_city_state_model', 'options_model', 'common_model', 'module_model', 'inc_model', 'amb_model', 'pcr_model', 'hp_model', 'school_model', 'eqp_model', 'inv_model', 'reports_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date'));
        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules', 'simple_excel/Simple_excel'));

        $this->post['base_month'] = get_base_month();
        $this->site_name = $this->config->item('site_name');
        $this->site = $this->config->item('site');

        $this->clg = $this->session->userdata('current_user');
    }

    public function index($generated = false)
    {

        $this->output->add_to_position($this->load->view('frontend/reports/reports_list_view', $data, TRUE), $this->post['output_position'], TRUE);
    }

    function load_report_form()
    {
        $report_type = $this->input->post('report_type');


        if ($report_type == 'Incident_Reports') {

            $data['submit_function'] = "save_export_inc";
            $this->output->add_to_position($this->load->view('frontend/reports/export_inc_reports_view', $data, TRUE), $output_position, TRUE);

            //            $this->output->add_to_position($this->load->view('frontend/reports/export_inc_reports_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'Patient_Reports') {
            $data['submit_function'] = "save_export_patient";
            $this->output->add_to_position($this->load->view('frontend/reports/export_inc_reports_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'ambulance_distance_Reports') {
            $data['submit_function'] = "save_export_dist_travel";
            $data['report_name'] = "Annex E-1 Patient Transport Report";
            $this->output->add_to_position($this->load->view('frontend/reports/export_amb_reports_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'Patient_Transport_Reports') {
            $data['submit_function'] = "save_export_tans_patient";
            $data['report_name'] = "Annex E-1 Patient Transport Report";
            $this->output->add_to_position($this->load->view('frontend/reports/month_filter_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'employee_report') {

            $data['submit_function'] = "export_emp_report";
            $this->output->add_to_position($this->load->view('frontend/reports/export_emp_reports_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'monthly_distance_Reports') {
            $data['report_name'] = "Annex E-2 Distance Travelled Report";
            $data['submit_function'] = "save_month_export_dist_travel";
            $this->output->add_to_position($this->load->view('frontend/reports/month_filter_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'district_distance') {
            $data['submit_function'] = "export_district_wise";
            $data['district_data'] = $this->common_model->get_district();
            $this->output->add_to_position($this->load->view('frontend/reports/district_wise_reports_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'epcr_report') {
            $data['submit_function'] = "export_epcr_report";
            $data['report_name'] = "EPCR Report";
            // $this->output->add_to_position($this->load->view('frontend/reports/export_amb_reports_view',$data, TRUE),'report_block_fields',TRUE); 
            $this->output->add_to_position($this->load->view('frontend/reports/export_inc_reports_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'incident_daily_hourly_report') {
            $data['submit_function'] = "incident_daily_hourly_report";
            $this->output->add_to_position($this->load->view('frontend/reports/daily_hourly_report_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'amb_onroad_offroad_report') {
            $data['submit_function'] = "amb_onroad_offroad_report";
            $this->output->add_to_position($this->load->view('frontend/reports/month_filter_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'b12_type_report') {
            $data['submit_function'] = "b12_type_report";
            $this->output->add_to_position($this->load->view('frontend/reports/export_inc_reports_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'monthly_screening_report') {
            $data['submit_function'] = "monthly_screening_report";
            $this->output->add_to_position($this->load->view('frontend/reports/export_inc_reports_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'ambulance_stock_report') {
            $data['submit_function'] = "ambulance_stock_report";
            $arg_amb = array('amb_user_type' => 'tdd');
            $data['amb_list'] = $this->amb_model->get_amb_data($arg_amb);
            $this->output->add_to_position($this->load->view('frontend/reports/export_ambulance_stock_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'annex_biii_patient_details') {

            $data['submit_function'] = "annex_biii_patient_details";
            $this->output->add_to_position($this->load->view('frontend/reports/export_inc_reports_view', $data, TRUE), $output_position, TRUE);
        }
    }

    function annex_biii_patient_details()
    {
        //public function save_export_patient(){        
        $post_reports = $this->input->post();

        $base_month = get_base_month_by_date(date('Y-m-d', strtotime($post_reports['from_date'])));

        $report_args = array(
            'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
            'system' => '108',
            'base_month' => $base_month
        );



        $report_data = $this->inc_model->get_patient_report_by_date($report_args);


        $header = array('Incident ID', 'Caller Number', 'Call Disconnected Time', 'Time at which ambulance reach at scene', 'Response Time', 'Ambulance Registration No', ' Ambulance Base Location ', 'Incident Location', 'Hospital In which the patient was admitted', 'Type of Ambulance Dispatched');

        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            foreach ($report_data as $row) {

                $call_recived_time = date('H:i:s', strtotime($row['inc_datetime']));
                $call_recived_date = date('Y-m-d', strtotime($row['inc_datetime']));

                $driver_data = $this->pcr_model->get_driver(array('dp_pcr_id' => $row['epcr_id']));

                $base_loc_time = $call_recived_date . ' ' . $driver_data[0]->dp_started_base_loc;

                $resonse_time = '';

                //                if ($driver_data[0]->responce_time == '' || $driver_data[0]->responce_time == "NaN:NaN:NaN") {
                //
                //                    $resonse_time = '00:00:00';
                //                } else {
                //                    $resonse_time = $driver_data[0]->responce_time;
                //                }

                //if ($resonse_time == '00:00:00') {

                // if (($driver_data[0]->dp_on_scene != '0000-00-00 00:00:00') && strtotime($driver_data[0]->dp_on_scene) > strtotime($row['inc_datetime'])) {
                $d_start = new DateTime($row['inc_datetime']);
                $d_end = new DateTime($driver_data[0]->dp_on_scene);

                $resonse_time = $d_start->diff($d_end);
                //  $resonse_time = date_diff( $epcr_info['at_scene'] , $epcr_info['inc_datetime']);

                $resonse_time = $resonse_time->h . ':' . $resonse_time->i . ':' . $resonse_time->s;
                //  }
                // }
                //   var_dump($resonse_time);
                //   die(0);

                $args = array('inc_ref_id' => $row['inc_ref_id']);

                $amb = $this->inc_model->get_inc_ambulance($args);
                //var_dump($amb);die;
                foreach ($amb as $amb_data) {

                    $transport_respond_base = $amb_data->hp_name;
                    $transport_respond_amb_no = $amb_data->amb_rto_register_no;
                    $amb_type = $amb_data->amb_type;
                }
                $hp_args = array('hp_id' => $row['rec_hospital_name']);
                $hp_data = $this->hp_model->get_report_hospital_data($hp_args);
                // var_dump($hp_data);die;
                if ($row['rec_hospital_name'] == 'Other' || $row['rec_hospital_name'] == '0' || $row['rec_hospital_name'] == '') {
                    $hp_name = 'Other - ' . $row['other_receiving_host'];
                } else if ($row['rec_hospital_name'] == 'on_scene_care') {
                    $hp_name = 'On Scene Care';
                } else if ($row['rec_hospital_name'] == 'at_scene_care') {
                    $hp_name = 'At Scene Care';
                } else {
                    $hp_name = $hp_data[0]->hp_name;
                }

                if ($amb_type == '1') {
                    $amb_type = 'JE';
                } else if ($amb_type == '2') {
                    $amb_type = 'BLS';
                } else if ($amb_type == '3') {
                    $amb_type = 'ALS';
                }

                $inc_data[] = array(
                    'inc_ref_id' => $row['inc_ref_id'],
                    'clr_mobile' => $row['clr_mobile'],
                    'call_dis_time' => $call_recived_time,
                    'amb_reach_time' => date('H:i:s', strtotime($driver_data[0]->dp_on_scene)),
                    'responce_time' => $resonse_time,
                    'respond_amb_no' => $transport_respond_amb_no,
                    'respond_amb_base' => $transport_respond_base,
                    'inc_address' => $row['inc_address'],
                    'hospital' => $hp_name,
                    'amb_type' => $amb_type,
                );
            }

            //var_dump($inc_data);die();
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['function_name'] = 'annex_biii_patient_details';
            $this->output->add_to_position($this->load->view('frontend/reports/ptn_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "patient_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);
            $data = array();


            foreach ($report_data as $row) {

                $call_recived_time = date('H:i:s', strtotime($row['inc_datetime']));


                $args = array('inc_ref_id' => $row['inc_ref_id']);
                $amb = $this->inc_model->get_inc_ambulance($args);
                foreach ($amb as $amb_data) {

                    $transport_respond_base = $amb_data->hp_name;
                    $transport_respond_amb_no = $amb_data->amb_rto_register_no;
                    $amb_type = $amb_data->amb_type;
                }

                $hp_args = array('hp_id' => $row['rec_hospital_name']);
                $hp_data = $this->hp_model->get_report_hospital_data($hp_args);

                //                if ($row['rec_hospital_name'] == '0') {
                //                    $hp_name = 'On scene care';
                //                } else if ($row['rec_hospital_name'] == 'Other') {
                //                    $hp_name = 'Other';
                //                } else {
                //                    $hp_name = $hp_data[0]->hp_name;
                //                }

                if ($row['rec_hospital_name'] == 'Other' || $row['rec_hospital_name'] == '0' || $row['rec_hospital_name'] == '') {
                    $hp_name = 'Other - ' . $row['other_receiving_host'];
                } else if ($row['rec_hospital_name'] == 'on_scene_care') {
                    $hp_name = 'On Scene Care';
                } else if ($row['rec_hospital_name'] == 'at_scene_care') {
                    $hp_name = 'At Scene Care';
                } else {
                    $hp_name = $hp_data[0]->hp_name;
                }

                if ($amb_type == '1') {
                    $amb_type = 'Two wheeler';
                } else if ($amb_type == '2') {
                    $amb_type = 'PTA (102)';
                } else if ($amb_type == '3') {
                    $amb_type = 'BLS';
                } else if ($amb_type == '4') {
                    $amb_type = 'ALS';
                } else if ($amb_type == '5') {
                    $amb_type = 'CC';
                } else if ($amb_type == '6') {
                    $amb_type = 'AIR';
                }


                $call_recived_time = date('H:i:s', strtotime($row['inc_datetime']));
                $call_recived_date = date('Y-m-d', strtotime($row['inc_datetime']));

                $driver_data = $this->pcr_model->get_driver(array('dp_pcr_id' => $row['epcr_id']));

                $base_loc_time = $call_recived_date . ' ' . $driver_data[0]->dp_started_base_loc;

                //                if ($driver_data[0]->responce_time == '' || $driver_data[0]->responce_time == "NaN:NaN:NaN") {
                //
                //                    $resonse_time = '00:00:00';
                //                } else {
                //                    $resonse_time = $driver_data[0]->responce_time;
                //                }


                if (($driver_data[0]->dp_on_scene != '0000-00-00 00:00:00') && strtotime($driver_data[0]->dp_on_scene) > strtotime($row['inc_datetime'])) {
                    $d_start = new DateTime($row['inc_datetime']);
                    $d_end = new DateTime($driver_data[0]->dp_on_scene);

                    $resonse_time = $d_start->diff($d_end);


                    $resonse_time = $resonse_time->h . ':' . $resonse_time->i . ':' . $resonse_time->s;
                }


                $inc_data = array(
                    'inc_ref_id' => $row['inc_ref_id'],
                    'clr_mobile' => $row['clr_mobile'],
                    'call_dis_time' => $call_recived_time,
                    'amb_reach_time' => date('H:i:s', strtotime($driver_data[0]->dp_on_scene)),
                    'responce_time' =>  date('H:i:s', strtotime($resonse_time)),
                    'respond_amb_no' => $transport_respond_amb_no,
                    'respond_amb_base' => $transport_respond_base,
                    'inc_address' => $row['inc_address'],
                    'hospital' => $hp_name,
                    //'code_no_hos'        => $hp_data[0]->hp_register_no,
                    'amb_type' => $amb_type,
                );
                // var_dump($inc_data);
                fputcsv($fp, $inc_data);
            }
            fclose($fp);
            exit;
        }

        //}
    }

    public function save_export_inc()
    {


        $post_reports = $this->input->post();

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;


        $report_args = array(
            'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
            'base_month' => $this->post['base_month']
        );


        // $report_data = $this->inc_model->get_inc_report_by_date($report_args);

        $report_data = $this->inc_model->get_inc_all_report_by_date($report_args);

        $header = array('Incident Id', 'Caller Number', 'Transport Ambulance Dispatched', 'Transport Ambulance Number', 'Patient Name', 'Patient Age', 'Chief Complaint', 'Summary', 'Operate by', 'Status');


        $inc_file_name = strtotime($post_reports['from_date']);
        $filename = "incident_" . $inc_file_name . ".csv";
        if ($post_reports['reports'] == 'view') {

            $data['header'] = $header;
            $data['inc_data'] = $report_data;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/reports/inc_report_view', $data, TRUE), 'list_table', TRUE);
        } else {


            $filename = "incident.csv";
            $fp = fopen('php://output', 'w');


            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);


            $data = array();
            foreach ($report_data as $row) {

                if ($row['incis_deleted'] == '0') {
                    $status = 'Active';
                } else if ($row['incis_deleted'] == '1') {
                    $status = 'Deleted';
                } else if ($row['incis_deleted'] == '2') {
                    $status = 'Terminated';
                }

                $data = array(
                    'inc_id' => $row['inc_id'],
                    'clr_mobile' => $row["clr_mobile"],
                    'transport_amb' => $row["transport_amb"],
                    'transport_amb_no' => $row["transport_amb_no"],
                    'patient_name' => $row['ptn_fullname'],
                    'patient_age' => $row['ptn_age'],
                    'ct_type' => $row['ct_type'],
                    'summary' => $row['inc_ero_summary'],
                    'operator_id' => $row['operator_id'],
                    'Status' => $status,
                );
                fputcsv($fp, $data);
            }

            fclose($fp);
            exit;
        }
    }

    public function export_patient()
    {

        $data['report_name'] = "Patient";
        $data['submit_function'] = "save_export_patient";

        $this->output->add_to_popup($this->load->view('frontend/reports/export_inc_reports_view', $data, TRUE), '500', '300');
    }

    public function save_export_patient()
    {

        $post_reports = $this->input->post();

        $report_args = array(
            'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-d', strtotime($post_reports['to_date']))
        );

        $report_data = $this->inc_model->get_patient_report_by_date($report_args);


        $header = array('Caller Number', 'Caller Disconnected Time', 'Time at which ambulance reach at site', 'Response Time', 'Registration No Of Ambulance', 'Base Location of Ambulance', 'Location of the Incident', 'Hospital In which the patient was admited', 'Type of Ambulance Dispatched');

        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            foreach ($report_data as $row) {

                //  var_dump($row);
                //  die();
                $call_recived_time = date('H:i:s', strtotime($row['inc_datetime']));
                $call_recived_date = date('Y-m-d', strtotime($row['inc_datetime']));

                $driver_data = $this->pcr_model->get_driver(array('dp_pcr_id' => $row['epcr_id']));

                $base_loc_time = $call_recived_date . ' ' . $driver_data[0]->dp_started_base_loc;

                $resonse_time = '';

                $resonse_time = $driver_data[0]->responce_time;

                $args = array('inc_ref_id' => $row['inc_ref_id']);

                $amb = $this->inc_model->get_inc_ambulance($args);
                foreach ($amb as $amb_data) {
                    $transport_respond_base = $amb_data->hp_name;
                    $transport_respond_amb_no = $amb_data->amb_rto_register_no;
                }
                $hp_args = array('hp_id' => $row['rec_hospital_name']);
                $hp_data = $this->hp_model->get_hp_data($hp_args);

                if ($row['rec_hospital_name'] == '0') {
                    $hp_name = 'On scene care';
                } else if ($row['rec_hospital_name'] == 'Other') {
                    $hp_name = 'Other';
                } else {
                    $hp_name = $hp_data[0]->hp_name;
                }

                if ($hp_data[0]->hp_type == '1') {
                    $hp_type = 'Rural';
                } else if ($hp_data[0]->hp_type == '2') {
                    $hp_type = 'Urban';
                } else if ($hp_data[0]->hp_type == '3') {
                    $hp_type = 'Metro';
                } else if ($hp_data[0]->hp_type == '4') {
                    $hp_type = 'Tribal';
                }

                $inc_data[] = array(
                    'clr_mobile' => $row['clr_mobile'],
                    'call_dis_time' => $call_recived_time,
                    'amb_reach_time' => $driver_data[0]->dp_started_base_loc,
                    'responce_time' => $resonse_time,
                    'respond_amb_no' => $transport_respond_amb_no,
                    'respond_amb_base' => $transport_respond_base,
                    'inc_address' => $row['inc_address'],
                    'hospital' => $hp_name,
                    //'code_no_hos'        => $hp_data[0]->hp_register_no,
                    'urban' => $hp_type,
                );
            }


            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/reports/ptn_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "bvg_patient_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);
            $data = array();
            foreach ($report_data as $row) {

                $call_recived_time = date('H:i:s', strtotime($row['inc_datetime']));


                $args = array('inc_ref_id' => $row['inc_ref_id']);
                $amb = $this->inc_model->get_inc_ambulance($args);
                foreach ($amb as $amb_data) {

                    $transport_respond_base = $amb_data->hp_name;
                    $transport_respond_amb_no = $amb_data->amb_rto_register_no;
                }

                $hp_args = array('hp_id' => $row['rec_hospital_name']);
                $hp_data = $this->hp_model->get_hp_data($hp_args);

                if ($row['rec_hospital_name'] == '0') {
                    $hp_name = 'On scene care';
                } else if ($row['rec_hospital_name'] == 'Other') {
                    $hp_name = 'Other';
                } else {
                    $hp_name = $hp_data[0]->hp_name;
                }

                if ($hp_data[0]->hp_type == '1') {
                    $hp_type = 'Rural';
                } else if ($hp_data[0]->hp_type == '2') {
                    $hp_type = 'Urban';
                } else if ($hp_data[0]->hp_type == '3') {
                    $hp_type = 'Metro';
                } else if ($hp_data[0]->hp_type == '4') {
                    $hp_type = 'Tribal';
                }


                $call_recived_time = date('H:i:s', strtotime($row['inc_datetime']));
                $call_recived_date = date('Y-m-d', strtotime($row['inc_datetime']));

                $driver_data = $this->pcr_model->get_driver(array('dp_pcr_id' => $row['epcr_id']));

                $base_loc_time = $call_recived_date . ' ' . $driver_data[0]->dp_started_base_loc;

                $resonse_time = '';

                $resonse_time = $driver_data[0]->responce_time;
                $data = array(
                    'clr_mobile' => $row['clr_mobile'],
                    'call_dis_time' => $call_recived_time,
                    'amb_reach_time' => $driver_data[0]->dp_started_base_loc,
                    'responce_time' => $resonse_time,
                    'respond_amb_no' => $transport_respond_amb_no,
                    'respond_amb_base' => $transport_respond_base,
                    'inc_address' => $row['inc_address'],
                    'hospital' => $hp_name,
                    'code_no_hos' => $hp_data[0]->hp_register_no,
                    'urban' => $hp_type
                );
                fputcsv($fp, $data);
            }
            fclose($fp);
            exit;
        }
    }

    public function export_tans_patient()
    {

        $data['report_name'] = "Patient Transport Report";
        $data['submit_function'] = "save_export_tans_patient";

        $this->output->add_to_popup($this->load->view('frontend/reports/export_amb_reports_view', $data, TRUE), '500', '300');
    }

    public function save_export_tans_patient()
    {

        $post_reports = $this->input->post();

        $to_data = date('Y-m-t', strtotime($post_reports['from_date']));
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $report_args = array(
            'from_date' => $from_date,
            'to_date' => $to_data
        );


        $report_args_epcr = array(
            'from_date' => date('n/d/Y', strtotime($post_reports['from_date'])),
            'to_date' => date('n/t/Y', strtotime($post_reports['from_date'])),
            'base_month' => $this->post['base_month']
        );

        $report_data = $this->inc_model->get_patient_epcr_report_by_date($report_args);

        $total_inc = $this->inc_model->get_inc_total($report_args);
        $total_calls = $total_inc[0]->total_calls;

        $report_args_attends = array(
            'from_date' => $from_date,
            'to_date' => $to_data,
            'incis_deleted' => '0'
        );

        $total_inc_attend = $this->inc_model->get_inc_total($report_args_attends);

        $total_attended = $total_inc_attend[0]->total_calls;

        $amb_args['get_count'] = TRUE;
        $total_amb = $this->amb_model->get_tdd_total_amb();



        $report_args['get_count'] = TRUE;
        //$total_ptn= $this->inc_model->get_total_patient_count_by_month($report_args_attends);
        //        $total_ptn_count = 0;
        //        foreach($total_inc_attend as $ptn){
        //            var_dump($ptn);
        //            $total_ptn_count += $ptn->pnt_count;
        //
        //        }
        //        
        //        var_dump($total_ptn_count);



        $header = array('Month', 'No of ambulance (cumulative)', 'Total Calls', 'Total Emergencies Calls', 'Total Emergencies Attended', 'Total Trauma/Accident', 'Total Labour Emergencies', 'Total Cardiac Emergencies', 'Other');

        $patient_data = array();

        $patient_data['total_truama_emergecy'] = 0;
        $patient_data['total_labour_emergecy'] = 0;
        $patient_data['total_cardiac_emergecy'] = 0;
        $patient_data['other'] = 0;
        $pro_imp_avail = array('41,42,43');

        foreach ($report_data as $report) {

            $patient_data['month'] = date('M Y', strtotime($post_reports['from_date']));



            if ($report['provider_impressions'] != '') {

                if (!in_array($report['provider_impressions'], $pro_imp_avail)) {
                    if ($report['provider_impressions'] == 8 || $report['provider_impressions'] == 9 || $report['provider_impressions'] == 10) {
                        $patient_data['total_cardiac_emergecy'] += 1;
                    } else if ($report['provider_impressions'] == 11 || $report['provider_impressions'] == 12 || $report['provider_impressions'] == 24) {
                        $patient_data['total_labour_emergecy'] += 1;
                    } else if ($report['provider_impressions'] == 33) {
                        $patient_data['total_truama_emergecy'] += 1;
                    } else {
                        $patient_data['other'] += 1;
                    }
                    //             if($report['provider_impressions'] == 36){
                    //                  $patient_data['other'] += 1;
                    //             }
                }
            }
        }


        if ($post_reports['reports'] == 'view') {

            $row['month'] = $patient_data['month'];
            $row['no_amb'] = $total_amb;
            $row['total_calls'] = $total_calls;
            $row['total_emergency_calls'] = $total_attended;
            $row['attend_calls'] = $total_attended;
            $row['total_trauma'] = $patient_data['total_truama_emergecy'];
            $row['labour_emegencies'] = $patient_data['total_labour_emergecy'];
            $row['cardiac_emegencies'] = $patient_data['total_cardiac_emergecy'];
            $row['other'] = $patient_data['other'];

            $data['header'] = $header;
            $data['inc_data'] = $row;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/reports/ptn_trans_report_view', $data, TRUE), 'list_table', TRUE);
        } else {

            $filename = "bvg_patient_trans_report.csv";
            $fp = fopen('php://output', 'w');




            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);


            $row['month'] = $patient_data['month'];
            $row['no_amb'] = $total_amb;
            $row['total_calls'] = $total_calls;
            $row['total_emergency_calls'] = $total_attended;
            $row['attend_calls'] = $total_attended;
            $row['total_trauma'] = $patient_data['total_truama_emergecy'];
            $row['labour_emegencies'] = $patient_data['total_labour_emergecy'];
            $row['cardiac_emegencies'] = $patient_data['total_cardiac_emergecy'];
            $row['other'] = $patient_data['other'];

            fputcsv($fp, $row);



            fclose($fp);
            exit;
        }
    }

    public function save_export_dist_travel()
    {

        $post_reports = $this->input->post();

        $report_args = array(
            'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-t', strtotime($post_reports['from_date']))
        );

        $amb_odometer = array();


        $tdd_amb = $this->amb_model->get_tdd_amb();


        foreach ($tdd_amb as $tdd) {

            $amb_odometer[$tdd->amb_rto_register_no]['month'] = date('M Y', strtotime($post_reports['from_date']));
            $amb_odometer[$tdd->amb_rto_register_no]['amb_rto_register_no'] = $tdd->amb_rto_register_no;

            $amb_odometer[$tdd->amb_rto_register_no]['total_km'] = 0;
            $amb_odometer[$tdd->amb_rto_register_no]['avg_km'][] = 0;

            $report_args['amb_reg_no'] = $tdd->amb_rto_register_no;
            $min_odometer = $this->inc_model->get_ambulance_min_odometer($report_args);
            //var_dump($min_odometer);

            $amb_odometer[$tdd->amb_rto_register_no]['min_odometer'] = $min_odometer[0]['start_odmeter'] ? $min_odometer[0]['start_odmeter'] : 0;

            $max_odometer = $this->inc_model->get_ambulance_max_odometer($report_args);
            $amb_odometer[$tdd->amb_rto_register_no]['max_odometer'] = $max_odometer[0]['end_odmeter'] ? $max_odometer[0]['end_odmeter'] : 0;



            $report_data = $this->inc_model->get_distance_report_by_date($report_args);





            foreach ($report_data as $report) {




                if ($report['end_odmeter'] < $report['start_odmeter']) {
                    continue;
                }

                $report_odometer = (int)$report['end_odometer'] - (int)$report['start_odometer'];
                //                    echo "start";
                //                    var_dump($report['amb_reg_id']);
                //                    var_dump($report['end_odometer']);
                //                    var_dump($report['start_odometer']);
                //                    var_dump($report_odometer);
                //                     echo "end";


                if (isset($report['amb_reg_id'])) {

                    if (!in_array($report['inc_ref_id'], (array) $amb_odometer[$report['amb_reg_id']]['inc_ref_id'])) {

                        // var_dump($report_odometer);
                        $amb_odometer[$report['amb_reg_id']]['inc_ref_id'][] = $report['inc_ref_id'];
                        $amb_odometer[$report['amb_reg_id']]['total_km'] += $report_odometer;
                    }
                }

                $amb_odometer[$report['amb_reg_id']]['avg_km'][] = $report_odometer;
            }
        }
        // var_dump($amb_odometer);



        $header = array('Month', 'Ambulance Reg No', 'Opening Odometer (First day of the Month)', 'Ending Odometer (Last day of the Month)', 'Total Distance Travelled by Ambulance', 'Average distance travel per Ambulance');

        if ($post_reports['reports'] == 'view') {


            $inc_data = array();
            foreach ($amb_odometer as $row) {

                if (count($row['avg_km']) > 0) {
                    $total_odometer = $row['max_odometer'] - $row['min_odometer'];
                    $row['avg_km'] = number_format($row['total_km'] / count($row['avg_km']), 2);
                    //$row['avg_km'] = number_format($row['total_km']/count($row['avg_km']),2); 
                }
                $inc_data[] = $row;
            }

            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;

            $this->output->add_to_position($this->load->view('frontend/reports/month_export_dist_travel_view', $data, TRUE), 'list_table', TRUE);
        } else {

            $filename = "ambulance_wise_distance_travelled_report.csv";
            $fp = fopen('php://output', 'w');


            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $data = array();
            foreach ($amb_odometer as $row) {
                $row1['month'] = $row['month'];
                $row1['amb_rto_register_no'] = $row['amb_rto_register_no'];
                $row1['min_odometer'] = $row['min_odometer'];
                $row1['max_odometer'] = $row['max_odometer'];
                //$row1['total_km'] = $row['total_km'];
                $row1['total_km'] = $row['max_odometer'] - $row1['min_odometer'];
                if (count($row['avg_km']) > 0) {
                    $row1['avg_km'] = number_format($row['total_km'] / count($row['avg_km']), 2);
                }
                fputcsv($fp, $row1);
            }

            fclose($fp);
            exit;
        }
    }

    public function save_export_total_dist_travel()
    {

        $post_reports = $this->input->post();

        $report_args = array(
            'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
            'system' => $post_reports['system'],
        );
        //var_dump($report_args);die;
        $amb_odometer = array();


        $tdd_amb = $this->amb_model->get_tdd_amb($report_args);
        // var_dump($tdd_amb);die;

        foreach ($tdd_amb as $tdd) {

            $amb_odometer[$tdd->amb_rto_register_no]['month'] = date('M Y', strtotime($post_reports['from_date']));
            $amb_odometer[$tdd->amb_rto_register_no]['amb_user'] = $tdd->amb_user;
            $amb_odometer[$tdd->amb_rto_register_no]['amb_rto_register_no'] = $tdd->amb_rto_register_no;

            $amb_odometer[$tdd->amb_rto_register_no]['total_km'] = 0;
            $amb_odometer[$tdd->amb_rto_register_no]['avg_km'] = 0;
            //     $report_args = array('amb_reg_no' =>  $tdd->amb_rto_register_no,
            //    'system' =>$tdd->amb_user,
            // );
            $report_args['amb_reg_no'] = $tdd->amb_rto_register_no;
            $min_odometer = $this->inc_model->get_ambulance_min_odometer($report_args);
            // var_dump($min_odometer);die;

            $amb_odometer[$tdd->amb_rto_register_no]['min_odometer'] = $min_odometer[0]['start_odmeter'] ? $min_odometer[0]['start_odmeter'] : 0;

            $max_odometer = $this->inc_model->get_ambulance_max_odometer($report_args);
            $amb_odometer[$tdd->amb_rto_register_no]['max_odometer'] = $max_odometer[0]['end_odmeter'] ? $max_odometer[0]['end_odmeter'] : 0;
            if (is_numeric($amb_odometer[$tdd->amb_rto_register_no]['max_odometer']) && is_numeric($amb_odometer[$tdd->amb_rto_register_no]['min_odometer'])) {
                $amb_odometer[$tdd->amb_rto_register_no]['total_km'] = $amb_odometer[$tdd->amb_rto_register_no]['max_odometer'] - $amb_odometer[$tdd->amb_rto_register_no]['min_odometer'];
            }
            $odometer_count = $this->inc_model->get_ambulance_odometer_count($report_args);
            $amb_odometer[$tdd->amb_rto_register_no]['odometer_count'] = $odometer_count;
            if ($odometer_count > 0) {
                $amb_odometer[$tdd->amb_rto_register_no]['avg_km'] = number_format(($amb_odometer[$tdd->amb_rto_register_no]['total_km'] / $odometer_count), 2);
            }




            $report_data = $this->inc_model->get_distance_report_by_date($report_args);
        }




        $header = array('Month', 'Ambulance Reg No', 'Opening Odometer (First day of the Month)', 'Ending Odometer (Last day of the Month)', 'Total Distance Travelled by Ambulance', 'Average distance travel per Ambulance');

        if ($post_reports['reports'] == 'view') {

            $data['header'] = $header;
            $data['inc_data'] = $amb_odometer;
            $data['report_args'] = $report_args;
            // var_dump($data['inc_data']);die;
            $this->output->add_to_position($this->load->view('frontend/reports/summary_dist_amb_view', $data, TRUE), 'list_table', TRUE);
        } else {

            $filename = "ambulance_wise_distance_travelled_report.csv";
            $fp = fopen('php://output', 'w');


            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $row1 = array();
            foreach ($amb_odometer as $row) {
                //var_dump($report_args);
                if ($row['odometer_count'] > 0) {
                    $avg_km = number_format(($row['total_km'] / $row['odometer_count']), 2);
                } else {
                    $avg_km = '0';
                }
                $row1['month'] = $row['month'];
                $row1['amb_rto_register_no'] = $row['amb_rto_register_no'];
                $row1['min_odometer'] = $row['min_odometer'];
                $row1['max_odometer'] = $row['max_odometer'];
                //$row1['total_km'] = $row['total_km'];
                $row1['total_km'] = $row['max_odometer'] - $row['min_odometer'];
                $row1['avg_km'] = $avg_km;

                fputcsv($fp, $row1);
            }

            fclose($fp);
            exit;
        }
    }

    function export_emp_report()
    {
        $post_reports = $this->input->post();
        //var_dump($post_reports);die;
        $data['team_type'] = $post_reports['team_type'];
        $report_data = $data['total_count'] = $this->colleagues_model->get_all_colleagues($data);

        // var_dump($report_data);die;

        //$report_data = $this->colleagues_model->get_all_colleagues();


        $header = array(
            'Employee ID',
            'Employee Name',
            'Designation',
            'Department',
            'Position',
            'Avaya ID',
            'Date of Joining',
            'Experience',
            'Qualificaton',
            'Age'
        );

        if ($post_reports['reports'] == 'view') {

            $emp_data = array();
            if (is_array($report_data)) {
                foreach ($report_data as $row) {

                    //$diff = date_diff(date('Y-m-d'),  strtotime($row->clg_joining_date, 'Y-m-d'));
                    $emp_data[] = array(
                        'Employee_ID' => $row->clg_ref_id,
                        'Employee_Name' => $row->clg_first_name . ' ' . $row->clg_mid_name . ' ' . $row->clg_last_name,
                        'Designation' => $row->ugname,
                        'Department' => $row->ugname . ' Department',
                        'Position' => $row->ugname,
                        'Date_of_Joining' => $row->clg_joining_date,
                        'Experience' => '',
                        'Qualificaton' => $row->clg_degree,
                        'Age' => '',
                        'avaya_id' => $row->clg_avaya_id
                    );
                }
            }

            $data['header'] = $header;
            $data['inc_data'] = $emp_data;
            $data['total_count'] = $report_data;
            $data['submit_funtion'] = 'export_emp_report';

            //var_dump($data);die;

            $this->output->add_to_position($this->load->view('frontend/reports/export_emp_list_reports_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "employee_report.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv; charset=UTF-8');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $emp_data = array();
            foreach ($report_data as $row) {
                if ($row->clg_avaya_id != NULL) {
                    $avaya_id = $row->clg_avaya_id;
                } else {
                    $avaya_id = "NA";
                }
                $fullname = $row->clg_first_name . ' ' . $row->clg_mid_name . ' ' . $row->clg_last_name;
                //$diff = date_diff(date('Y-m-d'),  strtotime($row->clg_joining_date, 'Y-m-d'));
                $emp_data = array(
                    'Employee_ID' => ucwords($row->clg_ref_id),
                    'Employee_Name' => $fullname,
                    'Designation' => $row->ugname,
                    'Department' => $row->ugname . ' Department',
                    'Position' => $row->ugname,
                    'avaya_id' =>  $avaya_id,
                    'Date of Joining' => $row->clg_joining_date,
                    'Experience' => '',
                    'Qualificaton' => $row->clg_degree,
                    'Age' => ''
                );
                fputcsv($fp, $emp_data);
            }
            //
            fclose($fp);
            exit;
        }
    }

    function export_district_wise()
    {

        $post_reports = $this->input->post();

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $to_data = date('Y-m-t', strtotime($post_reports['from_date']));


        $report_args = array(
            'from_date' => $from_date,
            'to_date' => $to_data,
            'district' => $post_reports['incient_district']
        );

        $report_data = $this->inc_model->get_district_amb_details($report_args);
        /// var_dump($report_data);die;

        $district_data = array();


        foreach ($report_data as $report) {

            $district = $report['amb_district'];
            //var_dump($district);die;
            $incient_district = $this->inc_model->get_district_by_id($district);

            $dst_name = $incient_district->dst_name;

            if (isset($district_data[$dst_name])) {
                // print_r($district_data[$dst_name]);die;
                if (!in_array($report['amb_rto_register_no'], $district_data[$dst_name]['amb'])) {

                    $district_data[$dst_name]['amb'][] = $report['amb_rto_register_no'];
                    // var_dump($report['amb_rto_register_no']);die;
                }

                if ($post_reports['from_date'] == "2018-07-01") {
                    //if(!in_array($report['inc_ref_id'], (array)$district_data[$dst_name]['inc_ref_id'])){

                    $district_data[$dst_name]['inc_ref_id'][] = $report['inc_ref_id'];

                    if ($report['end_odometer'] >= $report['start_odometer']) {
                        $report_odometer = (int)$report['end_odometer'] - (int)$report['start_odometer'];
                        $district_data[$dst_name]['total_km'] += $report_odometer;
                        if ($report_odometer > 0) {
                            $district_data[$dst_name]['trips'][] = $report_odometer;
                        }
                    }
                    //  }
                } else {
                    if (!in_array($report['inc_ref_id'], (array) $district_data[$dst_name]['inc_ref_id'])) {

                        $district_data[$dst_name]['inc_ref_id'][] = $report['inc_ref_id'];

                        if ($report['end_odometer'] >= $report['start_odometer']) {
                            $report_odometer = $report['end_odometer'] - $report['start_odometer'];
                            $district_data[$dst_name]['total_km'] += $report_odometer;
                            if ($report_odometer > 0) {
                                $district_data[$dst_name]['trips'][] = $report_odometer;
                            }
                        }
                    }
                }
            } else {

                $district_data[$dst_name]['amb'] = array();

                if (!in_array($report['amb_rto_register_no'], $district_data[$dst_name]['amb'])) {
                    $district_data[$dst_name]['amb'][] = $report['amb_rto_register_no'];
                }

                if (!in_array($report['inc_ref_id'], (array) $district_data[$dst_name]['inc_ref_id'])) {

                    $district_data[$dst_name]['inc_ref_id'][] = $report['inc_ref_id'];

                    if ($report['end_odometer'] >= $report['start_odometer']) {

                        $report_odometer = $report['end_odometer'] - $report['start_odometer'];
                        $district_data[$dst_name]['total_km'] += $report_odometer;
                        if ($report_odometer > 0) {
                            $district_data[$dst_name]['trips'][] = $report_odometer;
                        }
                    }
                }
            }
        }
        //var_dump($district_data);
        $row = array();

        foreach ($district_data as $key => $district) {
            //var_dump($district_data);die;
            if (isset($district['trips'])) {
                $total_trips = count($district['trips']);
            } else {
                $total_trips = 0;
            }


            $avg_km_amb = "";
            if ((count($district['amb'])) != '') {
                $avg_km_amb = number_format($district['total_km'] / count($district['amb']), 2);
            }

            $avg_km = 0;
            if ($district['trips'] != '') {
                $avg_km = number_format($avg_km_amb / count($district['trips']), 2);
            }
            $avg_veh_km = 0;

            if ($district['trips'] != '') {
                $avg_veh_km = $total_trips / count($district['amb']);
                // $avg = $avg_veh_km;
                $avg = number_format((float)$avg_veh_km, 2, '.', '');
            }


            $row[] = array(
                'district' => $key,
                'no_amb' => count($district['amb']),
                'total_km' => $district['total_km'],
                'avg_km_amb' => $avg_km_amb,
                'trips' => $total_trips,
                'avg_km' => $avg_km,
                'avg_veh_km' => $avg
            );
        }
        // var_dump($row);
        $header = array(
            'District',
            'No of Ambulance',
            'Total Kms',
            'Avg KMS/ Ambulance',
            'Total Trips',
            'Average Km/trip',
            'Average Trip/vehicle'
        );

        if ($post_reports['reports'] == 'view') {



            $data['header'] = $header;
            $data['inc_data'] = $row;
            $data['report_args'] = $report_args;
            $data['submit_funtion'] = 'export_district_wise';
            // var_dump($data);die;
            $this->output->add_to_position($this->load->view('frontend/reports/district_wise_list_report_view', $data, TRUE), 'list_table', TRUE);
        } else {

            $filename = "bvg_district_wise_distance_covered_by_ambulance.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);


            foreach ($row as $row) {
                fputcsv($fp, $row);
            }



            fclose($fp);
            exit;
        }
    }

    public function save_month_export_dist_travel()
    {

        $post_reports = $this->input->post();
        $to_data = date('Y-m-t', strtotime($post_reports['from_date']));
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $report_args = array(
            'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-t', strtotime($post_reports['from_date']))
        );


        $report_data = $this->inc_model->get_distance_report_by_date($report_args);

        $district_data = array();

        $district_data['amb'] = array();
        $district_data['inc_ref_id'] = array();
        $district_data['total_km'] = 0;
        foreach ($report_data as $report) {

            $district_data['month'] = date('M Y', strtotime($post_reports['from_date']));

            if (!in_array($report['amb_reg_id'], $district_data['amb'])) {
                $district_data['amb'][] = $report['amb_reg_id'];
            }


            if (!in_array($report['inc_ref_id'], $district_data['inc_ref_id'])) {

                $district_data['inc_ref_id'][] = $report['inc_ref_id'];

                if (!empty($report['start_odometer'])) {

                    if ($report['end_odometer'] >= $report['start_odometer']) {

                        $report_odometer = $report['end_odometer'] - $report['start_odometer'];
                        // $district_data['total_km']  +=  $report_odometer;
                        $district_data['total_km'] += $report['total_km'];
                    }

                    $district_data['trips'][] = $report_odometer;
                }
            }
        }



        $header = array('Month', 'No of ambulance (cumulative)', 'Total Distance Travelled by Ambulances', 'Average distance travel per Ambulance');

        if ($post_reports['reports'] == 'view') {

            $row['month'] = $district_data['month'];
            $row['no_amb'] = $this->amb_model->get_tdd_total_amb();


            $row['total_km'] = $district_data['total_km'];

            //$row['avg_veh_km'] = $row['total_km'] / count($district_data['amb']);
            $row['avg_veh_km'] = $row['total_km'] / $row['no_amb'];
            if (strpos($row['avg_veh_km'], '.') == TRUE) {
                $row['avg_veh_km'] = number_format((float)$row['avg_veh_km'], 2, '.', '');;
            } else {
                $row['avg_veh_km'] = $row['avg_veh_km'];
            }

            $data['header'] = $header;
            $data['inc_data'] = $row;

            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/reports/save_month_export_dist_travel', $data, TRUE), 'list_table', TRUE);
        } else {

            $filename = "bvg_monthly_distance_travelled_reports.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);


            $row['month'] = $district_data['month'];
            $row['no_amb'] = count($district_data['amb']);
            $row['no_amb'] = $this->amb_model->get_tdd_total_amb();
            $row['total_km'] = $district_data['total_km'];

            //$row['avg_veh_km'] = $row['total_km'] / count($district_data['amb']);
            $row['avg_veh_km'] = $row['total_km'] / $row['no_amb'];

            fputcsv($fp, $row);



            fclose($fp);
            exit;
        }
    }

    public function save_month_export_dist_travel_old()
    {

        $post_reports = $this->input->post();
        $to_data = date('Y-m-t', strtotime($post_reports['from_date']));
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $report_args = array(
            'from_date' => $from_date,
            'to_date' => $to_data
        );;
        $report_data = $this->inc_model->get_distance_report_by_date($report_args);

        $district_data = array();

        $district_data['amb'] = array();
        $district_data['total_km'] = 0;

        foreach ($report_data as $report) {

            $district_data['month'] = date('M Y', strtotime($post_reports['from_date']));

            if (!in_array($report['amb_rto_register_no'], $district_data['amb'])) {
                $district_data['amb'][] = $report['amb_rto_register_no'];
            }

            if (!empty($report['start_odmeter'])) {

                if ($report['end_odmeter'] >= $report['start_odmeter']) {
                    $report_odometer = $report['end_odmeter'] - $report['start_odmeter'];
                    $district_data['total_km'] += $report_odometer;
                }

                $district_data['trips'][] = $report_odometer;
            }
        }


        $header = array('Month', 'No of ambulance (cumulative)', 'Total Distance Travelled by Ambulances', 'Average distance travel per Ambulance');

        if ($post_reports['reports'] == 'view') {

            $row['month'] = $district_data['month'];
            $row['no_amb'] = $this->amb_model->get_tdd_total_amb();

            $row['total_km'] = $district_data['total_km'];

            //$row['avg_veh_km'] = $row['total_km'] / count($district_data['amb']);
            $row['avg_veh_km'] = $row['total_km'] / $row['no_amb'];

            $data['header'] = $header;
            $data['inc_data'] = $row;

            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/reports/save_month_export_dist_travel', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "bvg_monthly_distance_travelled_reports.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);


            $row['month'] = $district_data['month'];
            $row['no_amb'] = $this->amb_model->get_tdd_total_amb();;
            //$row['no_amb']   = '25';

            $row['total_km'] = $district_data['total_km'];

            //$row['avg_veh_km'] = $row['total_km'] / count($district_data['amb']);
            $row['avg_veh_km'] = $row['total_km'] / $row['no_amb'];

            fputcsv($fp, $row);



            fclose($fp);
            exit;
        }
    }

    function export_epcr_report()
    {


        $post_reports = $this->input->post();

        $report_args = array(
            'from_date' => date('n/d/Y', strtotime($post_reports['from_date'])),
            'to_date' => date('n/d/Y', strtotime($post_reports['to_date'])),
            'base_month' => $this->post['base_month']
        );

        $report_args = array(
            'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
            'base_month' => $this->post['base_month']
        );

        $report_data = $this->inc_model->get_epcr_by_month($report_args);


        $header = array(
            'Date',
            'Inc Ref ID',
            'Response Time',
            'Amb Reg No',
            'Patient Name',
            'District',
            'City',
            'locality',
            'Provider Improssion',
            'Reciving Hospital Name',
            'Base Location',
            'Operate by',
            'Start Odometer',
            'End Odometer',
            'Remark',
            'Total Km'
        );

        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            foreach ($report_data as $row) {
                // var_dump($report_data);die;
                $incient_district = $this->inc_model->get_district_by_id($row['district_id']);
                $dst_name = $incient_district->dst_name;

                $city_id = $this->inc_model->get_city_by_id($row['city_id'], $row['district_id']);
                $cty_name = $city_id->cty_name;


                $transport_respond_amb_no = $row['amb_rto_register_no'];


                $call_recived_date = date('Y-m-d', strtotime($row['inc_date']));
                $inc_time = explode(" ", $row['inc_date']);

                $driver_data = $this->pcr_model->get_driver($row['dp_pcr_id']);
                // var_dump( $driver_data);die;
                $base_loc_time = $call_recived_date . ' ' . $driver_data[0]->dp_started_base_loc;

                $time1 = $driver_data[0]->dp_reach_on_scene;

                $time2 = $driver_data[0]->dp_started_base_loc;
                $array1 = explode(':', $time1);

                $array2 = explode(':', $time2);
                if (is_array($minutes1)) {
                    $minutes1 = ($array1[0] * 60.0 + $array1[1]);
                    $minutes2 = ($array2[0] * 60.0 + $array2[1]);

                    $diff = $minutes1 - $minutes2;
                    $resonse_time = '';


                    if ($driver_data[0]->dp_started_base_loc != '00:00:00') {

                        $base_loc_time = new DateTime(date('Y-m-d H:i:s', strtotime($base_loc_time)));
                        $inc_datetime = new DateTime(date('Y-m-d H:i:s', strtotime($row['inc_date'])));
                        $resonse_time = date_diff($base_loc_time, $inc_datetime);
                        $resonse_time = $resonse_time->h . ':' . $resonse_time->i . ':' . $resonse_time->s;
                    }
                }
                if ($diff > 0) {
                    $resonse_time = $diff . ' Minutes';
                } else {
                    $resonse_time = '0 Minutes';
                }

                $amb_arg = array('rg_no' => $row['amb_reg_id']);
                $amb_data = $this->amb_model->get_amb_data($amb_arg);
                $amb_base_location = $amb_data[0]->hp_name;


                //  $resonse_time = '';   
                // var_dump($resonse_time);
                if ($row['rec_hospital_name'] == '0') {
                    $hp_name = 'On scene care';
                } else if ($row['rec_hospital_name'] == 'Other') {
                    $hp_name = 'Other';
                } else {
                    $hp_name = $row['hp_name'];
                }

                if ($row['ptn_fullname'] != NULL) {
                    $ptn_fullname = $row['ptn_fullname'];
                } else {
                    $ptn_fullname = $row['ptn_fname'] . ' ' . $row['ptn_lname'];
                }
                $inc_data[] = array(
                    'date' => $row['date'],
                    'inc_ref_id' => $row['inc_ref_id'],
                    'response_time' => $row['responce_time'],
                    'amb_rto_register_no' => $row['amb_reg_id'],
                    'patient_name' => $ptn_fullname,
                    'district' => $dst_name,
                    'cty_name' => $cty_name,
                    'locality' => $row['locality'],
                    'provier_img' => $row['pro_name'],
                    'base_location' => $hp_name,
                    'amb_base_location' => $amb_base_location,
                    'operate_by' => $row['operate_by'],
                    'start_odo' => $row['start_odometer'],
                    'end_odo' => $row['end_odometer'],
                    'remark' => $row['remark'],
                    'total_km' => $row['total_km'],
                );
            }


            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/reports/epcr_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "bvg_epcr_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            foreach ($report_data as $row) {

                $incient_district = $this->inc_model->get_district_by_id($row['district_id']);
                $dst_name = $incient_district->dst_name;

                $city_id = $this->inc_model->get_city_by_id($row['city_id'], $row['district_id']);
                $cty_name = $city_id->cty_name;

                $transport_respond_amb_no = $row['amb_rto_register_no'];

                $call_recived_date = date('Y-m-d', strtotime($row['inc_datetime']));

                $driver_data = $this->pcr_model->get_driver(array('dp_pcr_id' => $row['id']));

                $base_loc_time = $call_recived_date . ' ' . $driver_data[0]->dp_started_base_loc;

                $inc_time = explode(' ', $row['inc_datetime']);

                $time1 = $driver_data[0]->dp_reach_on_scene;
                $time2 = $driver_data[0]->dp_started_base_loc;

                $array1 = explode(':', $time1);
                $array2 = explode(':', $time2);
                if (is_array($minutes1)) {
                    $minutes1 = ($array1[0] * 60.0 + $array1[1]);
                    $minutes2 = ($array2[0] * 60.0 + $array2[1]);

                    $diff = $minutes1 - $minutes2;

                    $resonse_time = '';

                    if (($driver_data[0]->dp_started_base_loc != '00:00:00')) {

                        $base_loc_time = new DateTime(date('Y-m-d H:i:s', strtotime($base_loc_time)));
                        $inc_datetime = new DateTime(date('Y-m-d H:i:s', strtotime($row['inc_datetime'])));
                        $resonse_time = date_diff($base_loc_time, $inc_datetime);
                        $resonse_time = $resonse_time->h . ':' . $resonse_time->i . ':' . $resonse_time->s;
                    }
                    if ($diff > 0) {
                        $resonse_time = $diff . ' Minutes';
                    } else {
                        $resonse_time = '0 Minutes';
                    }
                }
                $amb_arg = array('rg_no' => $row['amb_reg_id']);
                $amb_data = $this->amb_model->get_amb_data($amb_arg);
                $amb_base_location = $amb_data[0]->hp_name;
                // $resonse_time = '';  

                if ($row['rec_hospital_name'] == '0') {
                    $hp_name = 'On scene care';
                } else if ($row['rec_hospital_name'] == 'Other') {
                    $hp_name = 'Other';
                } else {
                    $hp_name = $row['hp_name'];
                }
                if ($row['ptn_fullname'] != NULL) {
                    $ptn_fullname = $row['ptn_fullname'];
                } else {
                    $ptn_fullname = $row['ptn_fname'] . ' ' . $row['ptn_lname'];
                }

                $inc_data = array(
                    'date' => $row['date'],
                    'inc_ref_id' => $row['inc_ref_id'],
                    'response_time' => $row['responce_time'],
                    'amb_rto_register_no' => $row['amb_reg_id'],
                    'patient_name' => ucwords($ptn_fullname),
                    'district' => $dst_name,
                    'cty_name' => $cty_name,
                    'locality' => $row['locality'],
                    'provier_img' => $row['pro_name'],
                    'base_location' => $hp_name,
                    'amb_base_location' => $amb_base_location,
                    'operate_by' => ucwords($row['operate_by']),
                    'start_odo' => $row['start_odometer'],
                    'end_odo' => $row['end_odometer'],
                    'remark' => $row['remark'],
                    'total_km' => $row['total_km'],
                );

                fputcsv($fp, $inc_data);
            }
            fclose($fp);
            exit;
        }
    }

    function NHM_report()
    {
        $report_type = $this->input->post('report_type');

        $this->output->add_to_position($this->load->view('frontend/nhm_reports/NHM_Report_View', $data, TRUE), 'content', TRUE);
        $group = $this->clg->clg_group;
        if ($group == 'UG-Dashboard') {
            $this->output->template = "amb_loc_map_for_dashboard";
        }
    }

    function load_NHMAll_subreport_form()
    {
        $report_type = $this->input->post('report_type');
        if ($report_type == '1') {
            $data['submit_function'] = "NHMIISUB_Stockposition";
            $this->output->add_to_position($this->load->view('frontend/reports/export_amb_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }
        if ($report_type == '2') {
            $data['submit_function'] = "NHMIISUBII_Stockposition";
            $this->output->add_to_position($this->load->view('frontend/reports/export_amb_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }
        if ($report_type == '3') {
            $data['submit_function'] = "NHMIISUBII_Stockposition";
            $this->output->add_to_position($this->load->view('frontend/reports/export_amb_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }
        if ($report_type == '4') {
            $data['submit_function'] = "NHMIV_PatientReport";
            $this->output->add_to_position($this->load->view('frontend/reports/export_amb_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }
    }

    function load_NHM8_summeryreport()
    {
        $report_type = $this->input->post('report_type');
        if ($report_type == '1') {
            $data['submit_function'] = "save_export_dist_travel";
            $data['submit_function'] = "save_export_total_dist_travel";
            $this->output->add_to_position($this->load->view('frontend/nhm_reports/system_month_filter_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }
        if ($report_type == '2') {
            $data['submit_function'] = "NHM8_SubreportII";
            $this->output->add_to_position($this->load->view('frontend/nhm_reports/export_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }

        if ($report_type == '7') {
            $data['submit_function'] = "NHM7_EMT_Staff_data";
            $this->output->add_to_position($this->load->view('frontend/nhm_reports/export_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }

        if ($report_type == '6') {
            $data['submit_function'] = "amb_onroad_offroad_report";
            $this->output->add_to_position($this->load->view('frontend/nhm_reports/export_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }
    }

    function load_NHM_report_form()
    {

        $report_type = $this->input->post('report_type');
        $data['report_name'] = 'Report';
        if ($report_type == '1') {
            $data['report_name'] = 'Annex B-III Patient Details';
            $data['submit_function'] = "annex_biii_patient_details";
            $this->output->add_to_position($this->load->view('frontend/nhm_reports/export_inc_reports_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == '2') {
            $data['report_name'] = 'Annexure A -II';
            //$data['submit_function'] = "save_export_tans_patient"; 
            $this->output->add_to_position($this->load->view('frontend/nhm_reports/NHMAII_SubReport_bike.php', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == '3') {
            $data['report_name'] = 'Annexure A-I';
            $data['submit_function'] = "NHM3_Distance_report";
            $this->output->add_to_position($this->load->view('frontend/nhm_reports/export_amb_reports_view.php', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == '4') {
            $data['report_name'] = 'Annexure B-I Distance Running Statement';
            $data['submit_function'] = "NHM4_Distance_report";
            $this->output->add_to_position($this->load->view('frontend/nhm_reports/export_amb_reports_view.php', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == '5') {
            $data['report_name'] = 'Annexure B-II-A (Emergency Call Details)';
            $data['submit_function'] = "NHM5_incident_report";
            $this->output->add_to_position($this->load->view('frontend/nhm_reports/export_inc_reports_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == '6') {
            $data['report_name'] = 'Annexure B-II-B (Non-Emergency)';
            $data['submit_function'] = "NHM6_incident_report";
            $this->output->add_to_position($this->load->view('frontend/nhm_reports/export_inc_reports_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == '7') {
            $data['report_name'] = 'Annexure B-V Ambulance staff performance Reports';
            $data['submit_function'] = "NHM7_EMT_Staff_data";
            $this->output->add_to_position($this->load->view('frontend/nhm_reports/export_emt_permormance_report', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == '8') {
            $data['report_name'] = 'Annexure B-VII Vehicle Status Info Report';
            $data['submit_function'] = "NHM8_Onroadoffroad";
            $this->output->add_to_position($this->load->view('frontend/nhm_reports/export_inc_reports_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == '9') {
            $data['report_name'] = 'Summary Report';
            //$data['submit_function'] = "save_export_tans_patient"; 
            $this->output->add_to_position($this->load->view('frontend/nhm_reports/NHM8_Summery_reportlist.php', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'vahicle_status_report') {
            $data['report_name'] = 'Annexure B-VII Vehicle Status Info Report';
            $data['submit_function'] = "NHM8_Onroadoffroad";
            $this->output->add_to_position($this->load->view('frontend/nhm_reports/export_inc_reports_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'erc_staff') {
            $data['report_name'] = 'C - II ERC Staff, EMT & EA attendacne';
            $data['submit_function'] = "erc_staff";
            $this->output->add_to_position($this->load->view('frontend/nhm_reports/export_emt_permormance_report', $data, TRUE), $output_position, TRUE);
        }
    }

    //NHM 1st Report
    public function NHM1_PatientReport()
    {
        $post_reports = $this->input->post();
        $report_args = array(
            'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-d', strtotime($post_reports['to_date']))
        );
        $report_data = $this->inc_model->get_inc_report_by_date($report_args);


        $report_data = $this->inc_model->NHM1_get_patient_report_by_date($report_args);
        $header = array(
            'Icident No',
            'Call Disconnected Time',
            'Reach at scene',
            'Response Time',
            'Amb Reg No',
            'base location',
            'Incident Location',
            'hospital',
            'Urban / Rural'
        );

        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            foreach ($report_data as $row) {

                $incient_district = $this->inc_model->get_district_by_id($row['district_id']);
                $dst_name = $incient_district->dst_name;

                $city_id = $this->inc_model->get_city_by_id($row['city_id'], $row['district_id']);
                $cty_name = $city_id->cty_name;


                $transport_respond_amb_no = $row['amb_rto_register_no'];


                $call_recived_date = date('Y-m-d', strtotime($row['inc_date']));
                $inc_time = explode(" ", $row['inc_date']);

                $driver_data = $this->pcr_model->get_driver(array('dp_pcr_id' => $row['id']));

                $base_loc_time = $call_recived_date . ' ' . $driver_data[0]->dp_started_base_loc;

                $time1 = $driver_data[0]->dp_reach_on_scene;

                $time2 = $driver_data[0]->dp_started_base_loc;

                $array1 = explode(':', $time1);
                $array2 = explode(':', $time2);

                $minutes1 = ($array1[0] * 60.0 + $array1[1]);
                $minutes2 = ($array2[0] * 60.0 + $array2[1]);

                $diff = $minutes1 - $minutes2;
                $resonse_time = '';


                if ($driver_data[0]->dp_started_base_loc != '00:00:00') {

                    $base_loc_time = new DateTime(date('Y-m-d H:i:s', strtotime($base_loc_time)));
                    $inc_datetime = new DateTime(date('Y-m-d H:i:s', strtotime($row['inc_date'])));
                    $resonse_time = date_diff($base_loc_time, $inc_datetime);
                    $resonse_time = $resonse_time->h . ':' . $resonse_time->i . ':' . $resonse_time->s;
                }
                if ($diff > 0) {
                    $resonse_time = $diff . ' Minutes';
                } else {
                    $resonse_time = '0 Minutes';
                }

                $amb_arg = array('rg_no' => $row['amb_reg_id']);
                $amb_data = $this->amb_model->get_amb_data($amb_arg);
                $amb_base_location = $amb_data[0]->hp_name;
                $amb_working_area = $amb_data[0]->amb_working_area;

                $ambarea_arg = array('amb_working_area' => $amb_working_area);
                $ambarea_data = $this->amb_model->get_ambarea_data($ambarea_arg);
                $ambarea_name = $ambarea_data[0]->ar_name;
                //  $resonse_time = '';   
                // var_dump($resonse_time);
                if ($row['rec_hospital_name'] == '0') {
                    $hp_name = 'On scene care';
                } else if ($row['rec_hospital_name'] == 'Other') {
                    $hp_name = 'Other';
                } else {
                    $hp_name = $row['hp_name'];
                }

                $inc_data[] = array(
                    // 'date'         => $row['date'], 
                    'inc_ref_id' => $row['inc_ref_id'],
                    'Disconnected_Time' => $time2,
                    'Amb_reach_at_scene' => $time1,
                    'response_time' => $resonse_time,
                    'amb_rto_register_no' => $row['amb_reg_id'],
                    'amb_base_location' => $amb_base_location,
                    'locality' => $row['locality'],
                    'hp_name' => $hp_name,
                    'amb_working_area' => $ambarea_name,
                );
            }


            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/reports/NHM_Ptient_Report', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "bvg_epcr_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            foreach ($report_data as $row) {

                $incient_district = $this->inc_model->get_district_by_id($row['district_id']);
                $dst_name = $incient_district->dst_name;

                $city_id = $this->inc_model->get_city_by_id($row['city_id'], $row['district_id']);
                $cty_name = $city_id->cty_name;

                $transport_respond_amb_no = $row['amb_rto_register_no'];

                $call_recived_date = date('Y-m-d', strtotime($row['inc_datetime']));

                $driver_data = $this->pcr_model->get_driver(array('dp_pcr_id' => $row['id']));

                $base_loc_time = $call_recived_date . ' ' . $driver_data[0]->dp_started_base_loc;

                $inc_time = explode(' ', $row['inc_datetime']);

                $time1 = $driver_data[0]->dp_reach_on_scene;
                $time2 = $driver_data[0]->dp_started_base_loc;

                $array1 = explode(':', $time1);
                $array2 = explode(':', $time2);

                $minutes1 = ($array1[0] * 60.0 + $array1[1]);
                $minutes2 = ($array2[0] * 60.0 + $array2[1]);

                $diff = $minutes1 - $minutes2;

                $resonse_time = '';

                if (($driver_data[0]->dp_started_base_loc != '00:00:00')) {

                    $base_loc_time = new DateTime(date('Y-m-d H:i:s', strtotime($base_loc_time)));
                    $inc_datetime = new DateTime(date('Y-m-d H:i:s', strtotime($row['inc_datetime'])));
                    $resonse_time = date_diff($base_loc_time, $inc_datetime);
                    $resonse_time = $resonse_time->h . ':' . $resonse_time->i . ':' . $resonse_time->s;
                }
                if ($diff > 0) {
                    $resonse_time = $diff . ' Minutes';
                } else {
                    $resonse_time = '0 Minutes';
                }

                $amb_arg = array('rg_no' => $row['amb_reg_id']);
                $amb_data = $this->amb_model->get_amb_data($amb_arg);
                $amb_base_location = $amb_data[0]->hp_name;
                $amb_working_area = $amb_data[0]->amb_working_area;

                $ambarea_arg = array('amb_working_area' => $amb_working_area);
                $ambarea_data = $this->amb_model->get_ambarea_data($ambarea_arg);
                $ambarea_name = $ambarea_data[0]->ar_name;
                // $resonse_time = '';  

                if ($row['rec_hospital_name'] == '0') {
                    $hp_name = 'On scene care';
                } else if ($row['rec_hospital_name'] == 'Other') {
                    $hp_name = 'Other';
                } else {
                    $hp_name = $row['hp_name'];
                }

                $inc_data = array(
                    'inc_ref_id' => $row['inc_ref_id'],
                    'Disconnected_Time' => $time2,
                    'Amb_reach_at_scene' => $time1,
                    'response_time' => $resonse_time,
                    'amb_rto_register_no' => $row['amb_reg_id'],
                    'amb_base_location' => $amb_base_location,
                    'locality' => $row['locality'],
                    'hp_name' => $hp_name,
                    'amb_working_area' => $ambarea_name,
                );

                fputcsv($fp, $inc_data);
            }
            fclose($fp);
            exit;
        }
    }

    //NHM 3rd Report
    public function NHM3_Distance_report()
    {

        $post_reports = $this->input->post();
        $report_args = array(
            'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
            'system' => '108'
        );

        $Start_date = date('d-m-Y', strtotime($post_reports['from_date']));
        $END_day_first = date("Y-m-t", strtotime($Start_date));
        $END_day = date('d-m-Y', strtotime($END_day_first));

        $start_date_amb = date('Y-m-d', strtotime($post_reports['from_date']));
        $end_date_amb = date('Y-m-t', strtotime($post_reports['from_date']));
        $report_data = $this->inc_model->get_ambulance_list();

        $amb_odometer = array();

        foreach ($report_data as $report) {
            $count = 1;

            $amb_odometer[$report['amb_rto_register_no']]['month'] = date('M Y', strtotime($post_reports['from_date']));
            $amb_odometer[$report['amb_rto_register_no']]['amb_rto_register_no'] = $report['amb_rto_register_no'];

            $amb_odo_args  = array(
                'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'system' => '108',
                'amb_reg_no' => $report['amb_rto_register_no']
            );
            $start_odo_data = $this->inc_model->get_ambulance_min_odometer($amb_odo_args);
            //var_dump($start_odo_data[0]["start_odmeter"]);

            $end_odo_data = $this->inc_model->get_ambulance_max_odometer($amb_odo_args);
            // var_dump($end_odo_data[0]["end_odmeter"]);
            $report_odometer = 0;
            if (is_numeric($end_odo_data[0]["end_odmeter"]) && is_numeric($start_odo_data[0]["start_odmeter"])) {
                if ($end_odo_data[0]["end_odmeter"] < $start_odo_data[0]["start_odmeter"]) {
                    continue;
                }

                $report_odometer = (int)$end_odo_data[0]["end_odmeter"] - (int)$start_odo_data[0]["start_odmeter"];
            }
            if ($count == 1) {
                $end_odometer = $end_odo_data[0]["end_odmeter"];
                //$start_odometer =  $start_odo_data[0]["start_odmeter"] ; 
            } else {
                $end_odometer = $end_odo_data[0]["end_odmeter"];
                $start_odometer = $start_odo_data[0]["start_odmeter"];
            }
            $amb_odometer[$report['amb_rto_register_no']]['avg_km'][] = $report_odometer;
            $amb_odometer[$report['amb_rto_register_no']]['start_odometer'][] = $start_odometer;
            $amb_odometer[$report['amb_rto_register_no']]['end_odometer'][] = $end_odometer;
            $amb_odometer[$report['amb_rto_register_no']]['total_km'] = $report_odometer;
            $count++;
        }

        $header = array('Sr.no', 'Ambulance Reg No', 'Location', 'Opening Odometer (First Day of the Month)', 'Closing Odometer (Last Day of the Month)', 'KM Running during the month', 'No of patients', 'Remark');
        if ($post_reports['reports'] == 'view') {


            $inc_data = array();
            foreach ($amb_odometer as $row) {
                // var_dump($row['end_odometer']);die();
                $amb_arg = array('rg_no' => $row['amb_rto_register_no']);
                $amb_data = $this->amb_model->get_amb_base_location($amb_arg);
                $row['amb_base_location'] = $amb_data[0]->hp_name;

                $amb_arg1 = array('rg_no' => $row['amb_rto_register_no'], 'start_date' => $start_date_amb, 'end_date' => $end_date_amb);
                //var_dump($amb_arg1);die;
                $total_calls = $this->pcr_model->get_patient_count($amb_arg1);

                $row['total_calls'] = $total_calls[0]->pt_cn;
                $start = (int)$row['end_odometer'][0] -  (int)$row['total_km'];
                $row['amb_rto_register_no'] = $row['amb_rto_register_no'];
                $row['Start_date'] = $start;
                $row['END_day'] = $row['end_odometer'][0];
                $row['total_km'] = $row['total_km'];

                $inc_data[] = $row;
            }

            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;

            $this->output->add_to_position($this->load->view('frontend/reports/NHMIII_distanceReport', $data, TRUE), 'list_table', TRUE);
        } else {

            $filename = "Annexure_A_I_report.csv";
            $fp = fopen('php://output', 'w');


            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $data = array();

            $count = 1;
            foreach ($amb_odometer as $row) {

                $amb_arg = array('rg_no' => $row['amb_rto_register_no']);
                $amb_data = $this->amb_model->get_amb_base_location($amb_arg);


                $amb_arg1 = array('rg_no' => $row['amb_rto_register_no'], 'start_date' => $start_date_amb, 'end_date' => $end_date_amb);
                $total_calls = $this->pcr_model->get_patient_count($amb_arg1);
                $start = (int)$row['end_odometer'][0] -  (int)$row['total_km'];
                $row1['sr.no'] = $count;
                $row1['amb_rto_register_no'] = $row['amb_rto_register_no'];
                $row1['amb_base_location'] = $amb_data[0]->hp_name;
                $row1['Start_date'] = $start;
                $row1['END_day'] = $row['end_odometer'][0];
                $row1['total_km'] = $row['total_km'];
                $row1['total_calls'] = $total_calls[0]->pt_cn;
                $count++;
                fputcsv($fp, $row1);
            }

            fclose($fp);
            exit;
        }
    }

    //NHM 4thr report

    public function NHM4_Distance_report()
    {

        $post_reports = $this->input->post();

        // var_dump($post_reports);
        // die();
        $report_args = array(
            'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
            'system' => '108'
        );

        $Start_date = date('d-m-Y', strtotime($post_reports['from_date']));
        $END_day_first = date("Y-m-t", strtotime($Start_date));
        $END_day = date('d-m-Y', strtotime($END_day_first));

        $start_date_amb = date('Y-m-d', strtotime($post_reports['from_date']));
        $end_date_amb = date('Y-m-t', strtotime($post_reports['from_date']));
        //$report_data = $this->inc_model->get_distance_report_by_date($report_args);
        $report_data = $this->inc_model->get_ambulance_list();

        $amb_odometer = array();

        foreach ($report_data as $report) {

            $amb_odometer[$report['amb_rto_register_no']]['month'] = date('M Y', strtotime($post_reports['from_date']));
            $amb_odometer[$report['amb_rto_register_no']]['amb_rto_register_no'] = $report['amb_rto_register_no'];

            $amb_odo_args  = array(
                'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'system' => '108',
                'amb_reg_no' => $report['amb_rto_register_no']
            );
            $start_odo_data = $this->inc_model->get_ambulance_min_odometer($amb_odo_args);
            //var_dump($start_odo_data[0]["start_odmeter"]);

            $end_odo_data = $this->inc_model->get_ambulance_max_odometer($amb_odo_args);
            // var_dump($end_odo_data[0]["end_odmeter"]);
            $report_odometer = 0;
            if (is_numeric($end_odo_data[0]["end_odmeter"]) && is_numeric($start_odo_data[0]["start_odmeter"])) {
                if ($end_odo_data[0]["end_odmeter"] < $start_odo_data[0]["start_odmeter"]) {
                    continue;
                }

                $report_odometer = (int)$end_odo_data[0]["end_odmeter"] - (int)$start_odo_data[0]["start_odmeter"];
                $amb_odometer[$report['amb_rto_register_no']]['total_km'] = $report_odometer;
            }


            $amb_odometer[$report['amb_rto_register_no']]['avg_km'][] = $report_odometer;
        }

        $header = array('Sr.no', 'Ambulance Reg No', 'Location', 'KM Running during the month', 'No of patients', 'Remark');
        if ($post_reports['reports'] == 'view') {


            $inc_data = array();
            foreach ($amb_odometer as $row) {

                $amb_arg = array('rg_no' => $row['amb_rto_register_no']);
                $amb_data = $this->amb_model->get_amb_base_location($amb_arg);
                $row['amb_base_location'] = $amb_data[0]->hp_name;

                $amb_arg1 = array('rg_no' => $row['amb_rto_register_no'], 'start_date' => $start_date_amb, 'end_date' => $end_date_amb);
                $total_calls  = array();
                $total_calls = $this->pcr_model->get_patient_count($amb_arg1);
                // var_dump($total_calls);die;
                $row['total_calls'] = $total_calls[0]->pt_cn;
                $row['amb_rto_register_no'] = $row['amb_rto_register_no'];
                $row['Start_date'] = $Start_date;
                $row['END_day'] = $END_day;
                $row['total_km'] = $row['total_km'];
                //var_dump($row);die;
                $inc_data[] = $row;
            }

            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;

            $this->output->add_to_position($this->load->view('frontend/reports/NHMIV_distanceReport', $data, TRUE), 'list_table', TRUE);
        } else {

            $filename = "Annexure_B_I_distance_report.csv";
            $fp = fopen('php://output', 'w');


            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $count = 1;

            foreach ($amb_odometer as $row) {

                $amb_arg = array('rg_no' => $row['amb_rto_register_no']);
                $amb_data = $this->amb_model->get_amb_base_location($amb_arg);
                $amb_arg1 = array('rg_no' => $row['amb_rto_register_no'], 'start_date' => $start_date_amb, 'end_date' => $end_date_amb);
                $total_calls = $this->pcr_model->get_patient_count($amb_arg1);
                $row1['count'] = $count;
                $row1['amb_rto_register_no'] = $row['amb_rto_register_no'];
                $row1['amb_base_location'] = $amb_data[0]->hp_name;
                //$row1['Start_date'] = $Start_date;
                // $row1['END_day'] = $END_day;
                $row1['total_km'] = $row['total_km'];
                $row1['total_calls'] = $total_calls[0]->pt_cn;
                $count++;
                fputcsv($fp, $row1);
            }

            fclose($fp);
            exit;
        }
    }
    function NHM5_incident_report()
    {

        $post_reports = $this->input->post();

        $report_args = array(
            'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
            'inc_system_type' => '108'
        );


        $report_data = $this->inc_model->get_eme_inc_report_NHM5($report_args);


        $header = array('Incident Id', 'Caller Number', 'Call picked within 5 rings', 'Call picked after 5 rings', 'Unanswered Call(Call was not picked at all)', 'Whether any Ambulance was Assigned', 'Whether any Patient was Attended', 'Whether the call was about medico Legal Case', 'Whether the call was about Fire Incident');


        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            foreach ($report_data as $row) {

                $args_epcr = array('inc_ref_id' => $row['inc_ref_id']);
                $epcr_data = $this->inc_model->get_patient_epcr_report_by_date($args_epcr);


                $dispatch = $row['incis_deleted'];
                $dispatch_result = '';
                $patient_array = array('41', '42', '43', '21');
                if (!in_array($epcr_data[0]["provider_impressions"], $patient_array)) {
                    $dispatch_result = 'True';
                } else {
                    $dispatch_result = 'False';
                }



                $inc_data[] = array(
                    'inc_id' => $row['inc_ref_id'],
                    'clr_mobile' => $row['clr_mobile'],
                    'services' => $row['inc_service'],
                    'incis_deleted' => $dispatch_result,
                );
            }

            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/reports/NHMV_incident_report', $data, TRUE), 'list_table', TRUE);
        } else {


            $filename = "Annexure_B-II-A.csv";
            $fp = fopen('php://output', 'w');




            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);



            $data = array();
            foreach ($report_data as $row) {

                $args_epcr = array('inc_ref_id' => $row['inc_ref_id']);
                $epcr_data = $this->inc_model->get_patient_epcr_report_by_date($args_epcr);

                $dispatch = $row['incis_deleted'];
                $dispatch_result = '';
                $patient_array = array('41', '42', '43', '21');
                if (!in_array($epcr_data[0]["provider_impressions"], $patient_array)) {
                    $dispatch_result = 'True';
                } else {
                    $dispatch_result = 'False';
                }


                $services = unserialize($row['inc_service']);
                if ($services) {
                    if (in_array(2, $services)) {
                        $ser = "True";
                    } else {
                        $ser = "False";
                    }
                } else {
                    $ser = "False";
                }
                if ($services) {
                    if (in_array(3, $services)) {
                        $fire = "True";
                    } else {
                        $fire = "False";
                    }
                } else {
                    $fire = "False";
                }


                $inc_data = array(
                    'inc_id' => $row['inc_ref_id'],
                    'clr_mobile' => $row['clr_mobile'],
                    'call_picked_within_5' => 'TRUE',
                    'call_atfer_5' => 'FALSE',
                    'unanswerd' => 'FALSE',
                    'assigned' => 'TRUE',
                    'incis_deleted' => $dispatch_result,
                    'services' => $ser,
                    'ser' => $fire,
                );
                // var_dump($ser);
                fputcsv($fp, $inc_data);
            }
            $header = array('Incident Id', 'Caller Number', 'Call picked within 5 rings', 'Call picked after 5 rings', 'Unanswered Call(Call was not picked at all)', 'Whether any Ambulance was Assigned', 'Whether any Patient was Attended', 'Whether the call was about medico Legal Case', 'Whether the call was about Fire Incident');
            fclose($fp);
            exit;
        }
    }

    function NHM6_incident_report()
    {

        $post_reports = $this->input->post();

        $report_args = array(
            'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
            'inc_system_type' => '108'
        );


        $report_data = $this->inc_model->get_noneme_inc_report_NHM6($report_args);


        $header = array('Incident Id', 'Caller Number', 'Whether the Call Was Disconnected', 'Whether any Counselling was done', 'Whether it Was a Prank Call', 'Whether the call was meant for any city  corporation disaster cell', 'Whether it was diverted to concerned city corporation disaster cell');


        if ($post_reports['reports'] == 'view') {


            $data['header'] = $header;
            $data['inc_data'] = $report_data;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/reports/NHMVI_incident_report', $data, TRUE), 'list_table', TRUE);
        } else {


            $filename = "annexure_B_II_B_non_emergency.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);



            foreach ($report_data as $row) {

                $args = array('inc_ref_id' => $row['inc_ref_id']);


                if ($row['inc_type'] == 'DISS_CON_CALL') {
                    $call_disconnected =  'TRUE';
                } else {
                    $call_disconnected = 'FALSE';
                }

                if ($row['inc_type'] == 'NUS_CALL' || $row['inc_type'] == 'ABUSED_CALL') {
                    $counselling_done =  'TRUE';
                } else {
                    $counselling_done = 'FALSE';
                }
                $inc_data = array(
                    'inc_id' => $row['inc_ref_id'],
                    // 'inc_type' => $row['inc_type'],
                    'clr_mobile' => $row['clr_mobile'],
                    'call_disconnected' => $call_disconnected,
                    'counselling_done' => $counselling_done,
                    'prank_call' => $counselling_done,
                    'meant_for_cor_dis_cell' => 'FALSE',
                    'diverted_for_cor_dis_cell' => 'FALSE',
                );

                fputcsv($fp, $inc_data);
            }

            fclose($fp);
            exit;
        }
    }

    function NHMIISUB_Stockposition()
    {
        $post_reports = $this->input->post();
        $report_args = array(
            'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-t', strtotime($post_reports['from_date']))
        );

        $Start_date = date('d-m-Y', strtotime($post_reports['from_date']));
        $END_day_first = date("Y-m-t", strtotime($Start_date));
        $END_day = date('d-m-Y', strtotime($END_day_first));

        $start_date_amb = date('Y-m-d', strtotime($post_reports['from_date']));
        $end_date_amb = date('Y-m-t', strtotime($post_reports['from_date']));

        $consumable_list = $this->inc_model->get_consumable_list();
        $report_args = array(
            'from_date' => $start_date_amb,
            'to_date' => $end_date_amb
        );


        $consumable = array();
        foreach ($consumable_list as $ConsumableList) {

            $stock_arg = array(
                'inv_id' => $ConsumableList['inv_id'],
                'start_date' => $start_date_amb,
                'end_date' => $end_date_amb
            );

            $amb_args = array(
                'inv_type' => $ConsumableList['inv_type'],
                'inv_id' => $ConsumableList['inv_id'],
                'inv_to_date' => $end_date_amb
            );


            $item_list = get_inv_stock_by_id($amb_args);
            // var_dump($item_list);
            $opening_stock = $item_list[0]->in_stk - $item_list[0]->out_stk;

            $cons_args = array(
                'inv_type' => $ConsumableList['inv_type'],
                'inv_id' => $ConsumableList['inv_id'],
                'from_date' => $start_date_amb,
                'to_date' => $end_date_amb,
            );


            $cons_stock = get_inv_stock_by_id($cons_args);
            // die();
            //var_dump($cons_stock);

            $consumed_stock = $cons_stock[0]->out_stk;
            $replenishment_stock = $cons_stock[0]->in_stk;
            $balanced_stock = $opening_stock - $consumed_stock;

            $data_cons = array(
                'inv_title' => $ConsumableList['inv_title'],
                'inv_id' => $ConsumableList['inv_id'],
                'inv_base_quantity' => $ConsumableList['inv_base_quantity'],
                'opening_stock' => $opening_stock,
                'consume_during_month' => $consumed_stock ? $consumed_stock : 0,
                'replenishment' => $replenishment_stock ? $replenishment_stock : 0,
                'closing_stock' => $balanced_stock ? $balanced_stock : 0,
            );

            $consumable_name[] = $data_cons;
        }



        $header = array('Stk ID', 'Name of Medicines/Consumables', 'Expected Stock as per Agreement', 'Opening Stock-10 Ambulances', 'Consumed During The Month', 'Replenishment During the Month', 'Closing Stock', 'Deficiency as against Requirement');
        if ($post_reports['reports'] == 'view') {
            $inc_data = array();
            foreach ($consumable_name as $row1) {
                $row['inv_id'] = $row1['inv_id'];
                $row['inv_title'] = $row1['inv_title'];
                $row['opening_stock'] = $row1['opening_stock'];
                $row['inv_base_quantity'] = $row1['inv_base_quantity'];
                $row['consume_during_month'] = $row1['consume_during_month'];
                $row['replenishment'] = $row1['replenishment'];
                $row['closing_stock'] = $row1['closing_stock'];
                $inc_data[] = $row;
            }
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/nhm_reports/NHMIISub_stock', $data, TRUE), 'list_table', TRUE);
        } else {

            $filename = "ambulance_wise_distance_travelled_report.csv";
            $fp = fopen('php://output', 'w');


            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $row = array();

            foreach ($consumable_name as $row1) {
                $row['inv_id'] = $row1['inv_id'];
                $row['inv_title'] = $row1['inv_title'];
                $row['inv_base_quantity'] = $row1['inv_base_quantity'];
                $row['opening_stock'] = $row1['inv_base_quantity'];
                $row['consume_during_month'] = $row1['consume_during_month'];
                $row['replenishment'] = $row1['replenishment'];
                $row['closing_stock'] = $row1['closing_stock'];
                fputcsv($fp, $row);
            }
            fclose($fp);
            exit;
        }
    }

    function NHMIISUBII_Stockposition()
    {
        $post_reports = $this->input->post();
        $report_args = array(
            'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-t', strtotime($post_reports['from_date']))
        );

        $Start_date = date('d-m-Y', strtotime($post_reports['from_date']));
        $END_day_first = date("Y-m-t", strtotime($Start_date));
        $END_day = date('d-m-Y', strtotime($END_day_first));

        $start_date_amb = date('Y-m-d', strtotime($post_reports['from_date']));
        $end_date_amb = date('Y-m-t', strtotime($post_reports['from_date']));

        $ambstock_arg = array('start_date' => $start_date_amb, 'end_date' => $end_date_amb, 'amb_user_type' => '108');
        $ambstk_data = $this->amb_model->get_ambstk_case($ambstock_arg);

        $inc_data = array();
        foreach ($ambstk_data as $ambstk) {

            $amb_arg = array('rg_no' => $ambstk->amb_reg_id);
            $amb_data = $this->amb_model->get_amb_base_location($amb_arg);

            $ambdis_arg = array('amb_district' => $ambstk->district_id);
            $ambdis_data = $this->amb_model->get_amb_disctrict($ambdis_arg);


            $row['hp_name'] = $amb_data[0]->hp_name;

            $row['amb_rto_register_no'] = $ambstk->amb_reg_id;
            $row['amb_district'] = $ambdis_data[0]->dst_name;

            $item_type = array(
                'CA' => 'Consumables',
                'NCA' => 'Non Consumables',
                'MED' => 'Medicine',
                'INT' => 'Intervention',
                'INJ' => 'Injury'
            );

            if ($ambstk->as_item_type == 'CA' || $ambstk->as_item_type == 'NCA') {
                $row['inv_title'] = $ambstk->inv_title;
            } else if ($ambstk->as_item_type == 'MED') {
                $row['inv_title'] = $ambstk->med_title;
            } else if ($ambstk->as_item_type == 'INT') {
                $row['inv_title'] = $ambstk->int_name;
            } else if ($ambstk->as_item_type == 'INJ') {
                $row['inv_title'] = $ambstk->inj_name;
            }
            $row['inv_type'] = $item_type[$ambstk->as_item_type];

            $row['inc_ref_id'] = $ambstk->inc_ref_id;
            $row['as_item_type'] = $ambstk->as_item_type;
            $row['total_qty'] = $ambstk->total_qty;
            $row['as_date'] = $ambstk->as_date;
            $inc_data[] = $row;
        }



        //var_dump($ambulance_name);
        $header = array('Sr.No', 'Disctrict', 'Base Location', 'Ambulance No', 'Incident ID', 'Item Name', 'Item Type', 'Consumed & supplied qty', 'Date');
        if ($post_reports['reports'] == 'view') {

            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/reports/NHMIISubII_stock_amb', $data, TRUE), 'list_table', TRUE);
        } else {

            $filename = "vehicle_wise_inv_consum_report.csv";
            $fp = fopen('php://output', 'w');


            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);
            $count = 1;
            $row = array();
            foreach ($inc_data as $key => $row_amb) {


                $row['sr_no'] = $key + 1;
                $row['amb_district'] = $row_amb['amb_district'];
                $row['hp_name'] = $row_amb['hp_name'];
                $row['amb_rto_register_no'] = $row_amb['amb_rto_register_no'];
                $row['inc_ref_id'] = $row_amb['inc_ref_id'];
                $row['title'] = $row_amb['inv_title'];
                $row['as_item_type'] = $row_amb['inv_type'];
                $row['total_qty'] = $row_amb['total_qty'];
                $row['as_date'] =  $row_amb['as_date'];

                $count++;
                fputcsv($fp, $row);
            }


            fclose($fp);
            exit;
        }
    }

    function NHMIV_PatientReport()
    {

        $post_reports = $this->input->post();
        $report_args = array(
            'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-t', strtotime($post_reports['from_date']))
        );

        $Start_date = date('d-m-Y', strtotime($post_reports['from_date']));
        $END_day_first = date("Y-m-t", strtotime($Start_date));
        $END_day = date('d-m-Y', strtotime($END_day_first));

        $start_date_amb = date('Y-m-d', strtotime($post_reports['from_date']));
        $end_date_amb = date('Y-m-t', strtotime($post_reports['from_date']));


        $ambulance_list = $this->inc_model->get_ambulance_list();
        $ambulance = array();
        foreach ($ambulance_list as $ambulanceList) {
            $amb_arg = array('rg_no' => $ambulanceList['amb_rto_register_no']);
            $amb_data = $this->amb_model->get_amb_base_location($amb_arg);

            $ambdis_arg = array('amb_district' => $ambulanceList['amb_district']);
            $ambdis_data = $this->amb_model->get_amb_disctrict($ambdis_arg);

            $ambt_arg = array('amb_type' => $ambulanceList['amb_type']);
            $ambt_data = $this->amb_model->get_amb_type1($ambt_arg);
            // var_dump($ambt_data);die;

            $data_cons = array(
                'amb_id' => $ambulanceList['amb_id'],
                'amb_rto_register_no' => $ambulanceList['amb_rto_register_no'],
                'amb_district' => $ambulanceList['amb_district'],
                'hp_name' => $amb_data[0]->hp_name,
                'dst_name' => $ambdis_data[0]->dst_name,
                'amb_type' => $ambulanceList['amb_type'],
                'ambt_name' => $ambt_data[0]->ambt_name
            );

            $ambulance_name[] = $data_cons;
        }
        //var_dump($ambulance_name);
        $header = array('Sr.No', 'District', 'Base Location', 'Ambulance No', 'Ambulance Type');
        if ($post_reports['reports'] == 'view') {
            $inc_data = array();
            foreach ($ambulance_name as $row_amb) {
                $row['hp_name'] = $row_amb['hp_name'];
                $row['amb_rto_register_no'] = $row_amb['amb_rto_register_no'];
                $row['amb_district'] = $row_amb['dst_name'];
                $row['amb_type'] = $row_amb['ambt_name'];

                // var_dump($row_amb);die;
                $inc_data[] = $row;
            }
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/reports/NHMIISubIV_stock_amb', $data, TRUE), 'list_table', TRUE);
        } else {

            $filename = "Vehicle_list_report.csv";
            $fp = fopen('php://output', 'w');


            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $data = array();
            $count = 1;

            foreach ($ambulance_name as $row_amb) {
                $row['Sr.No'] = $count;
                $row['amb_district'] = $row_amb['dst_name'];
                $row['hp_name'] = $row_amb['hp_name'];
                $row['amb_rto_register_no'] = $row_amb['amb_rto_register_no'];
                $row['ambt_name'] = $row_amb['ambt_name'];

                $count++;
                fputcsv($fp, $row);
            }

            fclose($fp);
            exit;
        }
    }

    //NHM Report 7th
    function NHM7_EMT_Staff_data()
    {

        $post_reports = $this->input->post();

        $report_args = array(
            'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-d', strtotime($post_reports['from_date']))
        );
        $start_date_amb = date('Y-m-d', strtotime($post_reports['from_date']));
        $end_date_amb = date('Y-m-t', strtotime($post_reports['from_date']));

        $report_data = $this->inc_model->get_EMT_Data();
        // var_dump($report_data);die;
        $consumable = array();
        foreach ($report_data as $EMT_List) {

            $EMT_Patient_data = array('clg_ref_id' => $EMT_List['clg_ref_id'], 'start_date' => $start_date_amb, 'end_date' => $end_date_amb);
            // $EMT_Patient_data1 = array('clg_ref_id' => $EMT_List['clg_ref_id'],'amb_reg_id' => $EMT_List['amb_reg_id'], 'start_date' => $start_date_amb, 'end_date' => $end_date_amb);

            $patient_data = $this->amb_model->get_patient_information($EMT_Patient_data);
            $emt_dist = $this->amb_model->get_emt_district($EMT_Patient_data);


            $data_cons = array(
                'clg_emso_id' => $EMT_List['clg_emso_id'],
                'clg_first_name' => $EMT_List['clg_first_name'],
                'clg_mid_name' => $EMT_List['clg_mid_name'],
                'clg_last_name' => $EMT_List['clg_last_name'],
                // 'clg_district_id' => $EMT_List['clg_district_id'],
                'dst_name' => $emt_dist[0]->dst_name,
                'patient_count' => $patient_data[0]->patient_count
            );
            //var_dump($data_cons);die;
            $EMT_name[] = $data_cons;
        }

        $header = array('Sr.No', 'District', 'EMT Name', 'EMT ID', 'No Of patients');
        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            foreach ($EMT_name as $row1) {
                $row['clg_emso_id'] = $row1['clg_emso_id'];
                $row['clg_first_name'] = $row1['clg_first_name'];
                $row['clg_mid_name'] = $row1['clg_mid_name'];
                $row['clg_last_name'] = $row1['clg_last_name'];
                $row['amb_district'] = $row1['amb_district'];
                $row['dst_name'] = $row1['dst_name'];
                $row['patient_count'] = $row1['patient_count'];
                $inc_data[] = $row;
            }
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/reports/NHMVII_EMT_Data', $data, TRUE), 'list_table', TRUE);
        } else {


            $filename = "ambulance_staff_performance_report.csv";
            $fp = fopen('php://output', 'w');




            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $count = 1;
            foreach ($EMT_name as $row1) {
                $row['Sr_no'] = $count;
                $row['dst_name'] = $row1['dst_name'];
                $row['clg_first_name'] = $row1['clg_first_name'] . '' . $row1['clg_mid_name'] . '' . $row1['clg_last_name'];
                $row['clg_emso_id'] = $row1['clg_emso_id'];
                $row['patient_count'] = $row1['patient_count'];
                $count++;
                fputcsv($fp, $row);
            }

            fclose($fp);
            exit;
        }
    }

    //NHM 8th report
    function NHM8_Onroadoffroad()
    {
        $post_reports = $this->input->post();
        $report_args = array(
            'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
            'amb_status' => '6,7',
            'amb_emso_status' => '1,9',
            'system' => '108'
        );


        $header = array('Ambulance  Reg.No.', 'Base location', 'No.of on-road hrs during month', 'No.of off-road hrs during month', 'No.of off-road hrs due to breakdown And Others', 'Total Hours');
        $report_data = $this->inc_model->get_amb_status_summary_date($report_args);


        $amb_off_road_data = array();

        $seconds_in_month = strtotime($report_args['to_date'] . ' 24:00:00') - strtotime($report_args['from_date'] . ' 00:00:00');
        // echo $report_args['to_date'].' 00:00:00';
        //$seconds_in_month =  strtotime($report_args['from_date'].' 24:00:00') - strtotime($report_args['to_date'].' 00:00:00') ;
        //var_dump($seconds_in_month); die();

        $H = floor($seconds_in_month / 3600);
        $i = ($seconds_in_month / 60) % 60;
        $s = $seconds_in_month % 60;
        $totol_hour_in_month = sprintf("%02d:%02d:%02d", $H, $i, $s);


        foreach ($report_data as $report) {

            $amb_off_road_data[$report['amb_rto_register_no']]['total_hour'] = $totol_hour_in_month;

            $off_road_date = $report['off_road_date'];
            $off_road_time = $report['off_road_time'];

            $on_road_date = $report['on_road_date'];
            $on_road_time = $report['on_road_time'];

            $off_road = strtotime($off_road_date . ' ' . $off_road_time);

            $on_road = strtotime($on_road_date . ' ' . $on_road_time);
            $time_diff = $on_road - $off_road;
            if ($time_diff > 0) {

                $amb_off_road_data[$report['amb_rto_register_no']]['off_road'] += $time_diff;
            }
            $amb_off_road_data[$report['amb_rto_register_no']]['on_road'] = $seconds_in_month - $amb_off_road_data[$report['amb_rto_register_no']]['off_road'];
            $amb_off_road_data[$report['amb_rto_register_no']]['total_hour_second'] = $seconds_in_month;
            $amb_off_road_data[$report['amb_rto_register_no']]['hp_name'] = $report['hp_name'];
        }


        if ($post_reports['reports'] == 'view') {



            $data['header'] = $header;
            $data['inc_data'] = $amb_off_road_data;
            $data['report_args'] = $report_args;



            $this->output->add_to_position($this->load->view('frontend/reports/onroad_ofroad_view', $data, TRUE), 'list_table', TRUE);
            //$this->output->add_to_position($this->load->view('frontend/reports/NHMVIII_EMT_Data', $data, TRUE), 'list_table', TRUE);
        } else {

            // var_dump($post_reports );
            $filename = "NHM8_Onroadoffroad.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $data = array();
            foreach ($amb_off_road_data as $key => $amb_data) {

                $row['amb_rto_register_no'] = $key;
                $row['base_location'] = $amb_data['hp_name'];


                $on_road_seconds = $amb_data['on_road'];
                $on_H = floor($on_road_seconds / 3600);
                $on_i = ($on_road_seconds / 60) % 60;
                $on_s = $on_road_seconds % 60;
                $on_road = sprintf("%02d:%02d:%02d", $on_H, $on_i, $on_s);
                $row['on_road'] = $on_road;

                $off_road_seconds = $amb_data['off_road'];
                $H = floor($off_road_seconds / 3600);
                $i = ($off_road_seconds / 60) % 60;
                $s = $off_road_seconds % 60;
                $off_road = sprintf("%02d:%02d:%02d", $H, $i, $s);
                $row['off_road'] = $off_road;



                $on_road_seconds = $amb_data['off_road'];
                $on_H = floor($on_road_seconds / 3600);
                $on_i = ($on_road_seconds / 60) % 60;
                $on_s = $on_road_seconds % 60;
                $break_down = sprintf("%02d:%02d:%02d", $on_H, $on_i, $on_s);
                $row['break_down'] = $break_down;
                $row['total'] = $amb_data['total_hour'];
                fputcsv($fp, $row);
            }
            fclose($fp);
            exit;
        }
    }

    public function NHM8_SubreportI()
    {
        $post_reports = $this->input->post();
        $to_data = date('Y-m-t', strtotime($post_reports['from_date']));
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $report_args = array(
            'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-t', strtotime($post_reports['from_date']))
        );


        $report_data = $this->inc_model->get_distance_report_by_date($report_args);

        $district_data = array();

        $district_data['amb'] = array();
        $district_data['inc_ref_id'] = array();
        $district_data['total_km'] = 0;

        foreach ($report_data as $report) {

            $district_data['month'] = date('M Y', strtotime($post_reports['from_date']));

            if (!in_array($report['amb_reg_id'], $district_data['amb'])) {
                $district_data['amb'][] = $report['amb_reg_id'];
            }


            if (!in_array($report['inc_ref_id'], $district_data['inc_ref_id'])) {

                $district_data['inc_ref_id'][] = $report['inc_ref_id'];

                if (!empty($report['start_odometer'])) {

                    if ($report['end_odometer'] >= $report['start_odometer']) {

                        $report_odometer = (int)$report['end_odometer'] - (int)$report['start_odometer'];
                        // $district_data['total_km']  +=  $report_odometer;
                        $district_data['total_km'] += $report['total_km'];
                    }

                    $district_data['trips'][] = $report_odometer;
                }
            }
        }



        $header = array('Month', 'No of ambulance (cumulative)', 'Total Distance Travelled by Ambulances', 'Average distance travel per Ambulance');

        if ($post_reports['reports'] == 'view') {

            $row['month'] = $district_data['month'];
            $row['no_amb'] = count($district_data['amb']);

            if ($row['month'] == 'Jul 2018') {
                $row['no_amb'] = '25';
            } else {
                $row['no_amb'] = '30';
            }
            $row['total_km'] = $district_data['total_km'];

            //$row['avg_veh_km'] = $row['total_km'] / count($district_data['amb']);
            $row['avg_veh_km'] = $row['total_km'] / $row['no_amb'];

            $data['header'] = $header;
            $data['inc_data'] = $row;

            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/reports/save_month_export_dist_travel', $data, TRUE), 'list_table', TRUE);
        } else {

            $filename = "bvg_monthly_distance_travelled_reports.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);


            $row['month'] = $district_data['month'];
            $row['no_amb'] = count($district_data['amb']);
            $row['no_amb'] = '30';
            $row['total_km'] = $district_data['total_km'];

            //$row['avg_veh_km'] = $row['total_km'] / count($district_data['amb']);
            $row['avg_veh_km'] = $row['total_km'] / $row['no_amb'];

            fputcsv($fp, $row);



            fclose($fp);
            exit;
        }
    }

    function NHM8_SubreportII()
    {
        $post_reports = $this->input->post();
        $to_data = date('Y-m-t', strtotime($post_reports['from_date']));
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $report_args = array(
            'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-t', strtotime($post_reports['from_date']))
        );


        $report_data = $this->inc_model->get_distance_report_by_date($report_args);

        $district_data = array();

        $district_data['amb'] = array();
        $district_data['inc_ref_id'] = array();
        $district_data['total_km'] = 0;

        foreach ($report_data as $report) {

            $district_data['month'] = date('M Y', strtotime($post_reports['from_date']));




            if (!in_array($report['amb_reg_id'], $district_data['amb'])) {
                $district_data['amb'][] = $report['amb_reg_id'];
            }


            if (!in_array($report['inc_ref_id'], $district_data['inc_ref_id'])) {

                $district_data['inc_ref_id'][] = $report['inc_ref_id'];

                if (!empty($report['start_odometer'])) {

                    if ($report['end_odometer'] >= $report['start_odometer']) {

                        $report_odometer = (int)$report['end_odometer'] - (int)$report['start_odometer'];

                        $district_data['total_km'] += $report['total_km'];
                    }

                    $district_data['trips'][] = $report_odometer;
                }
            }
            $emt_data = $this->amb_model->get_emso_count();
        }



        $header = array('Month', 'EMT Count');

        if ($post_reports['reports'] == 'view') {

            $count = $emt_data[0]['total_count'];
            $row['month'] = $district_data['month'];
            $row['count'] = $count;
            $data['header'] = $header;
            $data['inc_data'] = $row;

            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/reports/NHM9_SubreportII', $data, TRUE), 'list_table', TRUE);
        } else {

            $filename = "NHM8_SubreportII.csv";
            $fp = fopen('php://output', 'w');


            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);


            $count = $emt_data[0]['total_count'];
            $row['month'] = $district_data['month'];
            $row['count'] = $count;


            fputcsv($fp, $row);



            fclose($fp);
            exit;
        }
    }

    function incident_daily_hourly_report()
    {

        $post_reports = $this->input->post();

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $report_args = array(
            'from_date' => $from_date . ' 00:00:01',
            'to_date' => date('Y-m-d', strtotime($post_reports['from_date']))
        );
        $report_data = $this->inc_model->get_inc_total_by_month($report_args);

        $epcr_report_args = array(
            'from_date' => $from_date,
            'to_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'base_month' => $this->post['base_month']
        );
        $epcr_report_data = $this->inc_model->get_epcr_by_hourly($epcr_report_args);

        $header = array('Hour', 'Total call', 'Total Dispatch', 'Total Closure');

        $daily_report_array = array();
        $hours_key_array = array(
            '0' => '00:00 AM To 01:00  AM ',
            '1' => '01:00 AM To 02:00  AM ',
            '2' => '02:00 AM To 03:00  AM ',
            '3' => '03:00 AM To 04:00  AM ',
            '4' => '04:00 AM To 05:00  AM ',
            '5' => '05:00 AM To 06:00  AM ',
            '6' => '06:00 AM To 07:00  AM ',
            '7' => '07:00 AM To 08:00  AM ',
            '8' => '08:00 AM To 09:00  AM ',
            '9' => '09:00 AM To 10:00  AM ',
            '10' => '10:00 AM To 11:00  AM ',
            '11' => '11:00 AM To 12:00  AM ',
            '12' => '12:00 PM To 13:00  PM ',
            '13' => '13:00 PM To 14:00  PM ',
            '14' => '14:00 PM To 15:00  PM ',
            '15' => '15:00 PM To 16:00  PM ',
            '16' => '16:00 PM To 17:00  PM ',
            '17' => '17:00 PM To 18:00  PM ',
            '18' => '18:00 PM To 19:00  PM ',
            '19' => '19:00 PM To 20:00  PM ',
            '20' => '20:00 PM To 21:00  PM ',
            '21' => '21:00 PM To 22:00  PM ',
            '22' => '22:00 PM To 23:00  PM ',
            '23' => '23:00 PM To 00.00  AM'
        );


        foreach ($report_data as $report) {
            $hour = date('G', strtotime($report['inc_datetime']));
            $daily_report_array[$hour]['total_inc'][] = $report['inc_ref_id'];
            if ($report['incis_deleted'] == 0) {
                $daily_report_array[$hour]['dispatch_inc'][] = $report['inc_ref_id'];
            }
        }

        foreach ($epcr_report_data as $epcr_report) {

            $hour = date('G', strtotime($epcr_report['time']));
            $daily_report_array[$hour]['epcr_inc'][] = $epcr_report['inc_ref_id'];
        }
        // var_dump($daily_report_array); 
        ksort($daily_report_array);

        if ($post_reports['reports'] == 'view') {


            $inc_data = array();

            $data['header'] = $header;
            //$daily_report_array = ksort($daily_report_array);
            //var_dump($daily_report_array);
            $data['hours_key_array'] = $hours_key_array;
            $data['daily_report_array'] = $daily_report_array;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/reports/incident_daily_hourly_report_view', $data, TRUE), 'list_table', TRUE);
        } else {


            $filename = "incident_daily_hourly_report.csv";
            $fp = fopen('php://output', 'w');




            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);



            $data = array();

            for ($hh = 0; $hh < 24; $hh++) {
                //foreach($daily_report_array as $key=>$daily_report){
                $total_call = 0;
                $epcr_inc = 0;
                $dispatch_inc = 0;

                if (!empty($daily_report_array[$hh]['total_inc'])) {
                    $total_call = count($daily_report_array[$hh]['total_inc']);
                }
                if (!empty($daily_report_array[$hh]['epcr_inc'])) {
                    $epcr_inc = count($daily_report_array[$hh]['epcr_inc']);
                }
                if (!empty($daily_report_array[$hh]['dispatch_inc'])) {
                    $dispatch_inc = count($daily_report_array[$hh]['dispatch_inc']);
                }


                $inc_data = array(
                    'Hour' => $hours_key_array[$hh],
                    'total_call' => $total_call,
                    'total_dispatch' => $dispatch_inc,
                    'total_closer' => $epcr_inc,
                );


                fputcsv($fp, $inc_data);
            }




            fclose($fp);
            exit;
        }
    }

    function amb_onroad_offroad_report()
    {
        $post_reports = $this->input->post();


        $report_args = array(
            'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
            'amb_status' => '6,7',
            'amb_emso_status' => '1,9'
        );


        $header = array('Ambulance  Reg.No.', 'No.of on-road hrs during month', '% of Ambulance on-road time', 'No.of off-road hrs during month', '% ambulance off-road time');
        $report_data = $this->inc_model->get_amb_status_summary_date($report_args);


        $amb_off_road_data = array();

        $seconds_in_month = strtotime($report_args['to_date'] . ' 24:00:00') - strtotime($report_args['from_date'] . ' 00:00:00');
        // echo $report_args['to_date'].' 00:00:00';
        //$seconds_in_month =  strtotime($report_args['from_date'].' 24:00:00') - strtotime($report_args['to_date'].' 00:00:00') ;
        //var_dump($seconds_in_month); die();

        $H = floor($seconds_in_month / 3600);
        $i = ($seconds_in_month / 60) % 60;
        $s = $seconds_in_month % 60;
        $totol_hour_in_month = sprintf("%02d:%02d:%02d", $H, $i, $s);


        foreach ($report_data as $report) {

            $amb_off_road_data[$report['amb_rto_register_no']]['total_hour'] = $totol_hour_in_month;

            $off_road_date = $report['off_road_date'];
            $off_road_time = $report['off_road_time'];

            $on_road_date = $report['on_road_date'];
            $on_road_time = $report['on_road_time'];

            $off_road = strtotime($off_road_date . ' ' . $off_road_time);

            $on_road = strtotime($on_road_date . ' ' . $on_road_time);
            $time_diff = $on_road - $off_road;
            if ($time_diff > 0) {

                $amb_off_road_data[$report['amb_rto_register_no']]['off_road'] += $time_diff;
            }
            $amb_off_road_data[$report['amb_rto_register_no']]['on_road'] = $seconds_in_month - $amb_off_road_data[$report['amb_rto_register_no']]['off_road'];
            $amb_off_road_data[$report['amb_rto_register_no']]['total_hour_second'] = $seconds_in_month;
            $amb_off_road_data[$report['amb_rto_register_no']]['hp_name'] = $report['hp_name'];
        }


        if ($post_reports['reports'] == 'view') {



            $data['header'] = $header;
            $data['inc_data'] = $amb_off_road_data;
            $data['report_args'] = $report_args;

            $this->output->add_to_position($this->load->view('frontend/reports/NHMVIII_EMT_Data', $data, TRUE), 'list_table', TRUE);
        } else {

            $filename = "Annexure_B-VII-Vehicle_Status_Information_Report.csv";
            $fp = fopen('php://output', 'w');


            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $data = array();
            foreach ($amb_off_road_data as $key => $amb_data) {

                $row['amb_rto_register_no'] = $key;
                // $row['base_location'] = $amb_data['hp_name'];


                $on_road_seconds = $amb_data['on_road'];
                $on_H = floor($on_road_seconds / 3600);
                $on_i = ($on_road_seconds / 60) % 60;
                $on_s = $on_road_seconds % 60;
                $on_road = sprintf("%02d:%02d:%02d", $on_H, $on_i, $on_s);
                $row['on_road'] = $on_road;

                $seconds_in_month = strtotime($report_args['to_date'] . ' 24:00:00') - strtotime($report_args['from_date'] . ' 00:00:00');

                $H = floor($seconds_in_month / 3600);
                $i = ($seconds_in_month / 60) % 60;
                $s = $seconds_in_month % 60;
                $totol_hour_in_month = sprintf("%02d:%02d:%02d", $H, $i, $s);
                $on_per = ($on_road / $totol_hour_in_month) * 100;
                if (strpos($on_per, '.') == TRUE) {
                    $row['break_down'] = number_format((float)$on_per, 2, '.', '');;
                } else {
                    $row['break_down'] = $on_per;
                }

                $off_road_seconds = $amb_data['off_road'];
                $H = floor($off_road_seconds / 3600);
                $i = ($off_road_seconds / 60) % 60;
                $s = $off_road_seconds % 60;
                $off_road = sprintf("%02d:%02d:%02d", $H, $i, $s);
                $row['off_road'] = $off_road;

                $seconds_in_month = strtotime($report_args['to_date'] . ' 24:00:00') - strtotime($report_args['from_date'] . ' 00:00:00');

                $H = floor($seconds_in_month / 3600);
                $i = ($seconds_in_month / 60) % 60;
                $s = $seconds_in_month % 60;
                $totol_hour_in_month = sprintf("%02d:%02d:%02d", $H, $i, $s);
                $off_per = ($off_road / $totol_hour_in_month) * 100;
                if (strpos($off_per, '.') == TRUE) {
                    $row['total'] = number_format((float)$off_per, 2, '.', '');;
                } else {
                    $row['total'] = $off_per;
                }
                // $on_road_seconds = $amb_data['off_road'];
                // $on_H = floor($on_road_seconds / 3600);
                // $on_i = ($on_road_seconds / 60) % 60;
                // $on_s = $on_road_seconds % 60;
                // $break_down = sprintf("%02d:%02d:%02d", $on_H, $on_i, $on_s);
                // $row['break_down'] = $break_down;
                // $row['total'] = $amb_data['total_hour'];
                fputcsv($fp, $row);
            }

            fclose($fp);
            exit;
        }
    }

    function b12_type_report()
    {

        $post_reports = $this->input->post();

        $report_args = array(
            'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
            'base_month' => $this->post['base_month'],
            'district' => 'other'
        );


        $header = array('Type of Emergency', 'Amravati', 'Gadchiroli', 'Mumbai', 'Palghar', 'Solapur', 'Grand Total');

        $report_data = $this->inc_model->get_epcr_by_month($report_args);

        $amb_off_road_data = array();
        $b12_type = array();

        $type_of_emergency = array(
            '0' => 'Accident(Vehicle)',
            '1' => 'Assault',
            '2' => 'Burns',
            '3' => 'Cardiac',
            '5' => 'Intoxication/Poisoning',
            '6' => 'Labour/ Pregnancy',
            '7' => 'Lighting/Electrocution',
            '9' => 'Medical',
            '10' => 'Poly Trauma',
            '11' => 'Suicide/Self Inflicted Injury',
            '12' => 'Others',
            '13' => 'Unavailed Call',
            '14' => 'Patient already shifted by 108',
            '15' => 'Patient already shifted other vehicle'
        );

        foreach ($report_data as $report) {


            $district = $report['district_id'];
            $incient_district = $this->inc_model->get_district_by_id($district);
            $dst_name = $incient_district->dst_name;

            $medicle_array = array(3, 4, 5, 16, 17, 18, 19, 20, 25, 26, 27, 28, 31, 32, 38, 39);
            $poly_truama = array(2, 6, 15, 33);
            $labour_pregnancy = array(11, 12, 24, 34);
            $other = array(21, 35, 36, 37, 45);
            $cardiac = array(8, 9, 10);
            $lighting = array(14);
            $intoxication = array(23);
            $suicide = array(40);
            $assault = array(6);
            $unavailed_call = array(41);
            $patient_108 = array(43);
            $patient_vahicle = array(44);

            if (isset($b12_type[$dst_name])) {

                if (in_array($report['provider_impressions'], $medicle_array)) {

                    $b12_type[$dst_name]['medical'] = $b12_type[$dst_name]['medical'] + 1;
                } else if (in_array($report['provider_impressions'], $poly_truama)) {

                    $b12_type[$dst_name]['poly_truama'] = $b12_type[$dst_name]['poly_truama'] + 1;
                } else if (in_array($report['provider_impressions'], $labour_pregnancy)) {

                    $b12_type[$dst_name]['labour_pregnancy'] = $b12_type[$dst_name]['labour_pregnancy'] + 1;
                } else if (in_array($report['provider_impressions'], $cardiac)) {

                    $b12_type[$dst_name]['cardiac'] = $b12_type[$dst_name]['cardiac'] + 1;
                } else if (in_array($report['provider_impressions'], $lighting)) {

                    $b12_type[$dst_name]['lighting'] = $b12_type[$dst_name]['lighting'] + 1;
                } else if (in_array($report['provider_impressions'], $intoxication)) {

                    $b12_type[$dst_name]['intoxication'] = $b12_type[$dst_name]['intoxication'] + 1;
                } else if (in_array($report['provider_impressions'], $suicide)) {

                    $b12_type[$dst_name]['suicide'] = $b12_type[$dst_name]['suicide'] + 1;
                } else if (in_array($report['provider_impressions'], $assault)) {

                    $b12_type[$dst_name]['assault'] = $b12_type[$dst_name]['assault'] + 1;
                } else if (in_array($report['provider_impressions'], $unavailed_call)) {

                    $b12_type[$dst_name]['unavailed_call'] = $b12_type[$dst_name]['unavailed_call'] + 1;
                } else if (in_array($report['provider_impressions'], $patient_108)) {

                    $b12_type[$dst_name]['patient_108'] = $b12_type[$dst_name]['patient_108'] + 1;
                } else if (in_array($report['provider_impressions'], $patient_vahicle)) {

                    $b12_type[$dst_name]['patient_vahicle'] = $b12_type[$dst_name]['patient_vahicle'] + 1;
                } else if (in_array($report['provider_impressions'], $other)) {

                    $b12_type[$dst_name]['other'] = $b12_type[$dst_name]['other'] + 1;
                }
            } else {

                $b12_type[$dst_name]['medical'] = 0;
                $b12_type[$dst_name]['poly_truama'] = 0;
                $b12_type[$dst_name]['labour_pregnancy'] = 0;
                $b12_type[$dst_name]['other'] = 0;
                $b12_type[$dst_name]['cardiac'] = 0;
                $b12_type[$dst_name]['lighting'] = 0;
                $b12_type[$dst_name]['intoxication'] = 0;
                $b12_type[$dst_name]['suicide'] = 0;
                $b12_type[$dst_name]['assault'] = 0;
                $b12_type[$dst_name]['unavailed_call'] = 0;
                $b12_type[$dst_name]['patient_108'] = 0;
                $b12_type[$dst_name]['patient_vahicle'] = 0;

                if (in_array($report['provider_impressions'], $medicle_array)) {

                    $b12_type[$dst_name]['medical'] = $b12_type[$dst_name]['medical'] + 1;
                } else if (in_array($report['provider_impressions'], $poly_truama)) {

                    $b12_type[$dst_name]['poly_truama'] = $b12_type[$dst_name]['poly_truama'] + 1;
                } else if (in_array($report['provider_impressions'], $labour_pregnancy)) {

                    $b12_type[$dst_name]['labour_pregnancy'] = $b12_type[$dst_name]['labour_pregnancy'] + 1;
                } else if (in_array($report['provider_impressions'], $cardiac)) {

                    $b12_type[$dst_name]['cardiac'] = $b12_type[$dst_name]['cardiac'] + 1;
                } else if (in_array($report['provider_impressions'], $lighting)) {

                    $b12_type[$dst_name]['lighting'] = $b12_type[$dst_name]['lighting'] + 1;
                } else if (in_array($report['provider_impressions'], $intoxication)) {

                    $b12_type[$dst_name]['intoxication'] = $b12_type[$dst_name]['intoxication'] + 1;
                } else if (in_array($report['provider_impressions'], $suicide)) {

                    $b12_type[$dst_name]['suicide'] = $b12_type[$dst_name]['suicide'] + 1;
                } else if (in_array($report['provider_impressions'], $assault)) {

                    $b12_type[$dst_name]['assault'] = $b12_type[$dst_name]['assault'] + 1;
                } else if (in_array($report['provider_impressions'], $unavailed_call)) {

                    $b12_type[$dst_name]['unavailed_call'] = $b12_type[$dst_name]['unavailed_call'] + 1;
                } else if (in_array($report['provider_impressions'], $patient_108)) {

                    $b12_type[$dst_name]['patient_108'] = $b12_type[$dst_name]['patient_108'] + 1;
                } else if (in_array($report['provider_impressions'], $patient_vahicle)) {

                    $b12_type[$dst_name]['patient_vahicle'] = $b12_type[$dst_name]['patient_vahicle'] + 1;
                } else if (in_array($report['provider_impressions'], $other)) {

                    $b12_type[$dst_name]['other'] = $b12_type[$dst_name]['other'] + 1;
                }
            }
        }

        if ($post_reports['reports'] == 'view') {



            $data['header'] = $header;
            $data['inc_data'] = $b12_type;
            $data['report_args'] = $report_args;


            $this->output->add_to_position($this->load->view('frontend/reports/b12_report_view', $data, TRUE), 'list_table', TRUE);
        } else {

            $filename = "b12_reports.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $type_of_emergency = array(
                '0' => 'Assault',
                '1' => 'Medical',
                '2' => 'Poly Trauma',
                '3' => 'Labour/ Pregnancy',
                '4' => 'Others',
                '5' => 'Cardiac',
                '6' => 'Lighting/Electrocution',
                '7' => 'Intoxication/Poisoning',
                '8' => 'Suicide/Self Inflicted Injury',
                '9' => 'Unavailed Call',
                '10' => 'Patient already shifted by 108',
                '11' => 'Patient already shifted other vehicle'
            );

            $pro_imp = array(
                '0' => 'assault',
                '1' => 'medical',
                '2' => 'poly_truama',
                '3' => 'labour_pregnancy',
                '4' => 'other',
                '5' => 'cardiac',
                '6' => 'lighting',
                '7' => 'intoxication',
                '8' => 'suicide',
                '9' => 'unavailed_call',
                '10' => 'patient_108',
                '11' => 'patient_vahicle'
            );

            for ($r = 0; $r < count($type_of_emergency); $r++) {

                $pro_name = $pro_imp[$r];


                $row['eme_type'] = $type_of_emergency[$r];
                $row['Amravati'] = $b12_type['Amravati'][$pro_name];
                $row['Gadchiroli'] = $b12_type['Gadchiroli'][$pro_name];
                $row['Mumbai'] = $b12_type['Mumbai'][$pro_name];
                $row['Palghar'] = $b12_type['Palghar'][$pro_name];
                $row['Solapur'] = $b12_type['Solapur'][$pro_name];
                $total = $b12_type['Solapur'][$pro_name] + $b12_type['Palghar'][$pro_name] + $b12_type['Mumbai'][$pro_name] + $b12_type['Gadchiroli'][$pro_name] + $b12_type['Amravati'][$pro_name];
                $row['total'] = $total;

                fputcsv($fp, $row);
            }

            fclose($fp);
            exit;
        }
    }

    /* tdd new reports */

    function monthly_screening_report()
    {
        $post_reports = $this->input->post();

        $cluster_id = $this->clg->cluster_id;


        $school_args = array('cluster_id' => $cluster_id);
        $report_data = $this->school_model->get_school_data_report($school_args);


        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $to_date = date('Y-m-d', strtotime($post_reports['to_date']));



        $report_args = array(
            'from_date' => $from_date . ' 00:00:01',
            'to_date' => $to_date . ' 23:59:59'
        );

        $school_data = array();
        foreach ($report_data as $report) {
            $report_args['school_id'] = $report->school_id;
            $total_screening = $this->school_model->get_school_student_screening($report_args);

            $report->screen_count = $total_screening;
            $school_data[] = $report;
        }


        $header = array('Sr No', 'Name of Ashram School', 'Name of ATC', 'Name of PO', 'Total Numbers of Screened Students');

        if ($post_reports['reports'] == 'view') {


            $inc_data = array();

            $data['header'] = $header;
            $data['report_args'] = $report_args;
            $data['school_data'] = $school_data;
            $this->output->add_to_position($this->load->view('frontend/reports/monthly_screening_report_view', $data, TRUE), 'list_table', TRUE);
        } else {


            $filename = "monthly_screening_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);



            $data = array();

            foreach ($school_data as $key => $school) {

                $sc_data = array(
                    'sr_no' => $key + 1,
                    'school_name' => $school->school_name,
                    'atc_name' => $school->atc_name,
                    'po_name' => $school->po_name,
                    'screen_count' => $school->screen_count,
                );

                fputcsv($fp, $sc_data);
            }


            fclose($fp);
            exit;
        }
    }

    function ambulance_stock_report()
    {
        $post_reports = $this->input->post();

        //        var_dump($post_reports);
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $to_date = date('Y-m-d', strtotime($post_reports['to_date']));
        $report_args = array(
            'from_date' => $from_date . ' 00:00:01',
            'to_date' => $to_date . ' 23:59:59'
        );

        $report_args['inv_type'] = ($post_reports['inv_type']) ? trim($post_reports['inv_type']) : '';
        $report_args['inv_amb'] = (isset($post_reports['amb_reg_id'])) ? trim($post_reports['amb_reg_id']) : '';

        if ($post_reports['reports'] == 'view') {

            if ($report_args['inv_type'] == 'CA' || $report_args['inv_type'] === 'NCA') {

                $data['item_list'] = $this->inv_model->get_inv($report_args);
                $this->output->add_to_position($this->load->view('frontend/reports/amb_stock_view', $data, TRUE), $this->post['output_position'], TRUE);
            } else if ($report_args['inv_type'] == 'EQP') {

                $report_args['eqp_amb'] = $report_args['inv_amb'];
                $data['eqp_list'] = $this->eqp_model->get_eqp($report_args);
                $this->output->add_to_position($this->load->view('frontend/reports/amb_eqp_stock_view', $data, TRUE), $this->post['output_position'], TRUE);
            } else if ($report_args['inv_type'] == 'MED') {

                $report_args['med_amb'] = $report_args['inv_amb'];
                $data['eqp_list'] = $this->eqp_model->get_eqp($report_args);
                $this->output->add_to_position($this->load->view('frontend/reports/amb_med_stock_view', $data, TRUE), $this->post['output_position'], TRUE);
            }
        } else {

            $filename = "ambulance_stock_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);

            if ($report_args['inv_type'] == 'CA' || $report_args['inv_type'] === 'NCA') {

                $item_list = $this->inv_model->get_inv($report_args);

                fputcsv($fp, $header);

                $data = array();

                if (!empty($item_list)) {
                    foreach ($item_list as $item) {


                        $bal = 0;

                        $stock = $item->in_stk - $item->out_stk;

                        if ($stock > 0) {
                            $bal = $stock;
                        } else if ($item->in_stk > 0) {
                            $bal = $item->in_stk;
                        }
                        $sc_data = array(
                            'inv_title' => stripslashes($item->inv_title),
                            'balance' => $bal,
                            'unt_title' => $item->unt_title,
                            'man_name' => ($item->man_name) ? $item->man_name : '-',
                        );

                        fputcsv($fp, $sc_data);
                    }
                }

                fputcsv($fp, $sc_data);
            }
            fclose($fp);
            exit;
        }
    }

    function response_time_report()
    {
        $report_type = $this->input->post('report_type');
        $data['report_name'] = "Response Time Report";
        $data['submit_function'] = "res_report";
        $this->output->add_to_position($this->load->view('frontend/nhm_reports/response_time_report_view', $data, TRUE), 'content', TRUE);
    }
    function res_report()
    {

        $post_reports = $this->input->post();

        $post_reports['from_date'] = $post_reports['from_date'];
        $post_reports['to_date'] = date('Y-m-t', strtotime($post_reports['from_date']));
        $urban = '2';
        $rural = '1';
        $als = '3';
        $bls = '2';
        $report_data['amb_count_als'] = $this->amb_model->get_amb_res_report_typewise_count($post_reports, $als);
        $report_data['amb_count_bls'] = $this->amb_model->get_amb_res_report_typewise_count($post_reports, $bls);

        $report_data['call_to_scene_time_urban_als'] = $this->amb_model->call_to_scene_time($post_reports, $urban, $als);
        $report_data['call_to_scene_time_urban_bls'] = $this->amb_model->call_to_scene_time($post_reports, $urban, $bls);
        $report_data['call_to_hosp_time_urban_als'] = $this->amb_model->call_to_hosp_time($post_reports, $urban, $als);
        $report_data['call_to_hosp_time_urban_bls'] = $this->amb_model->call_to_hosp_time($post_reports, $urban, $bls);
        $report_data['call_to_scene_time_rural_als'] = $this->amb_model->call_to_scene_time($post_reports, $rural, $als);
        $report_data['call_to_scene_time_rural_bls'] = $this->amb_model->call_to_scene_time($post_reports, $rural, $bls);
        $report_data['call_to_hosp_time_rural_als'] = $this->amb_model->call_to_hosp_time($post_reports, $rural, $als);
        $report_data['call_to_hosp_time_rural_bls'] = $this->amb_model->call_to_hosp_time($post_reports, $rural, $bls);
        $report_data['amb_unavailability_percentage_als'] = $this->amb_model->amb_unavailability_percentage($post_reports, $als);
        $report_data['amb_unavailability_percentage_bls'] = $this->amb_model->amb_unavailability_percentage($post_reports, $bls);
        $report_data['month'] = date("F Y", strtotime($post_reports['from_date']));
        //var_dump($report_data); die;
        //$report_data = $this->amb_model->get_amb_res_report($report_args);
        $filename = "Response_time_report.csv";
        $header = array('Month', 'No. of Ambulances Operational under dial 108', 'Call To Scene Time(Min.Sec) (Urban)', 'Call To Hospital Time(Min.Sec) (Urban)', 'Call To Scene Time(Min.Sec) (Rural)', 'Call To Hospital Time(Min.Sec) (Rural)', 'Percentage of calls denied due to shortage/unavaibility of Ambulances', 'No. of Ambulances Operational under dial 108', 'Call To Scene Time(Min.Sec) (Urban)', 'Call To Hospital Time(Min.Sec) (Urban)', 'Call To Scene Time(Min.Sec) (Rural)', 'Call To Hospital Time(Min.Sec) (Rural)', 'Percentage of calls denied due to shortage/unavaibility of Ambulances');

        if ($post_reports['reports'] == 'view') {

            $data['header'] = $header;
            $data['inc_data'] = $report_data;
            $data['report_args'] = $post_reports;
            $data['submit_function'] = 'res_report';
            $this->output->add_to_position($this->load->view('frontend/reports/res_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "Response_time_report.csv";
            $fp = fopen('php://output', 'w');
            // fputcsv($fp, [
            //     'Month',
            //     'No. of Ambulances Operational under dial 108',
            //     'Call To Scene Time(Min.Sec) (Urban)',
            //     'Call To Hospital Time(Min.Sec) (Urban)',
            //     'Call To Scene Time(Min.Sec) (Rural)',
            //     'Call To Hospital Time(Min.Sec) (Rural)',
            //     'Percentage of calls denied due to shortage/unavaibility of Ambulances',
            //     'No. of Ambulances Operational under dial 108',
            //     'Call To Scene Time(Min.Sec) (Urban)',
            //     'Call To Hospital Time(Min.Sec) (Urban)',
            //     'Call To Scene Time(Min.Sec) (Rural)',
            //     'Call To Hospital Time(Min.Sec) (Rural)',
            //     'Percentage of calls denied due to shortage/unavaibility of Ambulances'
            //   ]);
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);


            $data = array();


            $sc_data = array(
                array('bls' => 'Basic Life Support (BLS)'),
                array('head1' => 'MP IRTS', 'month' => $report_data['month']),
                array('head1' => 'No. of Ambulances Operational under dial EMS', 'amb_count_bls' => $report_data['amb_count_bls'][0]->amb),
                array('bls' => 'Average Response Time - Urban'),
                array('head1' => 'Call To Scene Time(Min.Sec)', 'call_to_scene_time_urban_bls' => abs($report_data['call_to_scene_time_urban_bls'])),
                array('head1' => 'Call To Hospital Time(Min.Sec)', 'call_to_hosp_time_urban_bls' => abs($report_data['call_to_hosp_time_urban_bls'])),
                array('bls' => 'Average Response Time - Rural'),
                array('head1' => 'Call To Scene Time(Min.Sec)', 'call_to_scene_time_rural_bls' => abs($report_data['call_to_scene_time_rural_bls'])),
                array('head1' => 'Call To Hospital Time(Min.Sec)', 'call_to_hosp_time_rural_bls' => abs($report_data['call_to_hosp_time_rural_bls'])),
                array('head1' => 'Percentage of calls denied due to shortage/unavaibility of Ambulances', 'amb_unavailability_percentage_bls' => $report_data['amb_unavailability_percentage_bls']),
                array('head1' => 'No. of Ambulances Operational under dial EMS', 'amb_count_als' => $report_data['amb_count_als'][0]->amb),
                array('bls' => 'Average Response Time - Urban'),
                array('head1' => 'Call To Scene Time(Min.Sec)', 'call_to_scene_time_urban_als' => abs($report_data['call_to_scene_time_urban_als'])),
                array('head1' => 'Call To Hospital Time(Min.Sec)', 'call_to_hosp_time_urban_als' => abs($report_data['call_to_hosp_time_urban_als'])),
                array('bls' => 'Average Response Time - Rural'),
                array('head1' => 'Call To Scene Time(Min.Sec)', 'call_to_scene_time_rural_als' => abs($report_data['call_to_scene_time_rural_als'])),
                array('head1' => 'Call To Hospital Time(Min.Sec)', 'call_to_hosp_time_rural_als' => abs($report_data['call_to_hosp_time_rural_als'])),
                array('head1' => 'Percentage of calls denied due to shortage/unavaibility of Ambulances', 'amb_unavailability_percentage_als' => $report_data['amb_unavailability_percentage_als'])
            );
            // $row_data = array();
            foreach ($sc_data as $val => $key) {

                fputcsv($fp, $key);
            }
            //var_dump($row_data);
            //fclose($handle);

            fclose($fp);
            exit;
        }
    }

    function erc_staff()
    {
        $post_reports = $this->input->post();

        $report_args = array(
            'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-d', strtotime($post_reports['from_date']))
        );
        $start_date_amb = date('Y-m-d', strtotime($post_reports['from_date']));
        $end_date_amb = date('Y-m-t', strtotime($post_reports['from_date']));

        $report_data = $this->inc_model->get_EMT_Data();
        // var_dump($report_data);die;
        $consumable = array();
        foreach ($report_data as $EMT_List) {

            $EMT_Patient_data = array('clg_ref_id' => $EMT_List['clg_ref_id'], 'start_date' => $start_date_amb, 'end_date' => $end_date_amb);
            // $EMT_Patient_data1 = array('clg_ref_id' => $EMT_List['clg_ref_id'],'amb_reg_id' => $EMT_List['amb_reg_id'], 'start_date' => $start_date_amb, 'end_date' => $end_date_amb);

            $patient_data = $this->amb_model->get_patient_information($EMT_Patient_data);
            $emt_dist = $this->amb_model->get_emt_district($EMT_Patient_data);


            $data_cons = array(
                'clg_emso_id' => $EMT_List['clg_emso_id'],
                'clg_first_name' => $EMT_List['clg_first_name'],
                'clg_mid_name' => $EMT_List['clg_mid_name'],
                'clg_last_name' => $EMT_List['clg_last_name'],
                // 'clg_district_id' => $EMT_List['clg_district_id'],
                'dst_name' => $emt_dist[0]->dst_name,
                'patient_count' => $patient_data[0]->patient_count
            );
            //var_dump($data_cons);die;
            $EMT_name[] = $data_cons;
        }

        $header = array('Month', 'No of EROs (Call taker) & Other Staff', 'No of ERCP (Consultant)', 'No of EMSOs 
(Dr in Ambulance As per Clouser)', 'No of EA (Driver As per Clouser)');
        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            foreach ($EMT_name as $row1) {
                $row['clg_emso_id'] = $row1['clg_emso_id'];
                $row['clg_first_name'] = $row1['clg_first_name'];
                $row['clg_mid_name'] = $row1['clg_mid_name'];
                $row['clg_last_name'] = $row1['clg_last_name'];
                $row['amb_district'] = $row1['amb_district'];
                $row['dst_name'] = $row1['dst_name'];
                $row['patient_count'] = $row1['patient_count'];
                $inc_data[] = $row;
            }
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/reports/erc_staff_data', $data, TRUE), 'list_table', TRUE);
        } else {


            $filename = "erc_staff_performance_report.csv";
            $fp = fopen('php://output', 'w');




            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $count = 1;
            foreach ($EMT_name as $row1) {
                $row['Sr_no'] = $count;
                $row['dst_name'] = $row1['dst_name'];
                $row['clg_first_name'] = $row1['clg_first_name'] . '' . $row1['clg_mid_name'] . '' . $row1['clg_last_name'];
                $row['clg_emso_id'] = $row1['clg_emso_id'];
                $row['patient_count'] = $row1['patient_count'];
                $count++;
                fputcsv($fp, $row);
            }

            fclose($fp);
            exit;
        }
    }
    function load_nhm_report()
    {
        $this->output->add_to_position($this->load->view('frontend/nhm_reports/nhm_file_report_view', $data, TRUE), 'content', TRUE);
    }
}
