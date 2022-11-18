<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Erc_reports extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->active_module = "M-REPORTS";

        $this->pg_limit = $this->config->item('pagination_limit_clg');

        $this->pg_limits = $this->config->item('report_clg');
        $this->load->model(array('dashboard_model_final_updated','colleagues_model', 'get_city_state_model', 'options_model', 'common_model', 'module_model', 'inc_model', 'amb_model', 'pcr_model', 'hp_model', 'school_model', 'eqp_model', 'inv_model', 'police_model', 'fire_model', 'shiftmanager_model', 'Medadv_model', 'feedback_model', 'grievance_model','call_model','ambmain_model','quality_model','module_model','reports_model','corona_model','hpcl_model_api','maintenance_part_model','fleet_model','biomedical_model','inspection_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date'));
        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules', 'simple_excel/Simple_excel'));

        $this->post['base_month'] = get_base_month();
        $this->site_name = $this->config->item('site_name');
        $this->site = $this->config->item('site');

        $this->clg = $this->session->userdata('current_user');
    }

    public function index($generated = false) {

        $mcode = 'M-ERC-REPORTS';
        $data['tool_data'] = $this->module_model->get_tools_by_mcode($mcode);
        $this->output->add_to_position($this->load->view('frontend/erc_reports/erc_reports_list_view', $data, TRUE), $this->post['output_position'], TRUE);
    }

    function load_erc_report_form() {

        $report_type = $this->input->post('report_type');
        

        if ($report_type == 'Incident_Reports') {
            $data['submit_function'] = "dispatch_incident_report";
            $data['report_name'] = "Incident Report";
            $data['clg_group'] = $this->clg->clg_group;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/incident_report_view', $data, TRUE), $output_position, TRUE);
        }
        else if ($report_type == 'Incident_Pvt_Hos_Reports') {
            $data['submit_function'] = "dispatch_incident_pvt_hos_report";
            $data['report_name'] = "Incident Report - Pvt Hospital";
            $data['clg_group'] = $this->clg->clg_group;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/incident_pvt_hos_report_view', $data, TRUE), $output_position, TRUE);
        }
        else if ($report_type == 'Closure_Reports') {
            $data['submit_function'] = "save_export_patient";
            $data['report_name'] = "Closure Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/closure_report_view', $data, TRUE), $output_position, TRUE);
        }else if ($report_type == 'Closure_lat_long_Reports') {
            $data['submit_function'] = "save_export_patient";
            $data['report_name'] = "Closure Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/closure_lat_long_report_view', $data, TRUE), $output_position, TRUE);
        }else if ($report_type == 'Closure_Validation_Reports') {
            $data['submit_function'] = "closure_validation_dco_report";
            $data['report_name'] = "Closure Validation Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/closure_validation_report_view', $data, TRUE), $output_position, TRUE);
        }  else if ($report_type == 'pda_report') {
            $data['submit_function'] = "save_export_dist_travel";
            $data['report_name'] = "PDA Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/pda_reports_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'fda_report') {
            $data['submit_function'] = "save_export_tans_patient";
            $data['report_name'] = "FDA Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/fda_reports_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'employee_report') {
            $data['submit_function'] = "export_emp_report";
            $data['report_name'] = "Employee Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/login_employee_reports_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'ambulance_report') {
            $data['submit_function'] = "export_emp_report";
            $data['report_name'] = "Ambulance Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_reports_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'ambulance_listing_report') {
            $data['submit_function'] = "export_emp_report";
            $data['report_name'] = "Ambulance Listing Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_listing_reports_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'ambulance_master_report') {
            $data['submit_function'] = "export_emp_report";
            $data['report_name'] = "All Ambulance Master Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/all_ambulance_master_reports_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'ambulance_logout_report') {
            $data['submit_function'] = "export_emp_report";
            $data['report_name'] = "MDT Logout Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_logout_reports_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'nhm_104_report') {
            $data['submit_function'] = "export_emp_report";
            $data['report_name'] = "104 Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/nhm_104_reports_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'Patient_Transport_Reports') {
            $data['submit_function'] = "patient_transport_reports_view";
            $data['report_name'] = "Patient Transport Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/patient_transport_reports_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'daily_report') {
            $data['submit_function'] = "incident_daily_hourly_report";
            $data['report_name'] = "Hourly Data (Daily Report)";
            $data['all_purpose_of_calls'] = $this->call_model->get_all_child_purpose_of_calls();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/daily_date_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'onroad_offroad_report') {
            $data['submit_function'] = "incident_daily_hourly_report";
            $data['report_name'] = "On-road / Off-road Data Report";
            $data['clg_group'] = $this->clg->clg_group;
            $data['zones'] = $this->common_model->get_divisions();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/onroad_offroad_report_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'inspection_details_report') {
            $data['submit_function'] = "incident_daily_hourly_report";
            $data['report_name'] = "Inspection Details Report";
            $data['zones'] = $this->common_model->get_divisions();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/inspection_details_report_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'ercp_report') {
            $data['submit_function'] = "incident_daily_hourly_report";
            $data['report_name'] = "ERCP Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ercp_reports_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'b12_report') { 
            $data['district_data'] = $this->common_model->get_district();
            $data['submit_function'] = "incident_daily_hourly_report";
            $data['report_name'] = "B12 Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/b12_reports_view', $data, TRUE), $output_position, TRUE);
        }else if ($report_type == 'b12_report_new') { 
           // $data['district_data'] = $this->common_model->get_district();
            $data['submit_function'] = "b12_type_report_new_format";
            $data['report_name'] = "B12 Report New";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/b12_reports_view_new', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'feedback_report') {
            $data['submit_function'] = "incident_daily_hourly_report";
            $data['report_name'] = "Feedback Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/feedback_reports_view', $data, TRUE), $output_position, TRUE);
        }else if ($report_type == 'base_location_report') {
            $data['submit_function'] = "base_location_report";
            $data['report_name'] = "Base Location Report";
            $this->output->add_to_position($this->load->view('frontend/reports/base_location_report_view', $data, TRUE), $output_position, TRUE);
        } else if ($report_type == 'grieviance_report') {
            $data['report_name'] = "Grievance Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/grievance_reports_view', $data, TRUE), $output_position, TRUE);
        }else if ($report_type == 'master_report') {
            $data['report_name'] = "Master Report";
           // $data['submit_function'] = "view_master_report";
            $data['all_purpose_of_calls'] = $this->call_model->get_all_child_purpose_of_calls();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/master_reports_view', $data, TRUE), $output_position, TRUE);
        }else if ($report_type == 'quality_master_report') {
            $data['report_name'] = "Quality Master Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/quality_master_reports_view', $data, TRUE), $output_position, TRUE);
        }else if ($report_type == 'call_count_aht_report') {
            $data['submit_function'] = "call_count_aht_report";
            $data['report_name'] = "Call Count/AHT Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/aht_count_filters_report_view', $data, TRUE), $output_position, TRUE);
            
        }else if ($report_type == 'district_wise_patient_served') {
            
            $data['submit_function'] = "district_wise_patient_served";
            $data['report_name'] = "District wise Emergency Patient Served";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_district_patient_reports_view', $data, TRUE), $output_position, TRUE);
            
        }else if($report_type == 'fuel_filling_report'){
            $data['submit_function'] = "fuel_filling";
            $data['report_name'] = "Fuel Filling Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/fuel_filling_reports_view', $data, TRUE), $output_position, TRUE);
          
        }else if ($report_type == 'patient_serverd_count_report') {
            
            $data['submit_function'] = "load_patient_served_sub_option_report_form_new";
            $data['report_name'] = "Patient Served Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/patient_serverd_count_ambulancewise_view', $data, TRUE), $output_position, TRUE);
            
        }else if($report_type == 'unable_to_dispatch_report'){
            $data['submit_function'] = "unable_to_dispatch_report";
            $data['report_name'] = "Unable To Dispatch Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/unable_to_dispatch_report', $data, TRUE), $output_position, TRUE);
          
        }else if($report_type == 'daily_dist_report'){
            $data['submit_function'] = "daily_dist_wise_report";
            $data['report_name'] = "Daily District wise Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/daily_dist_wise_report_type', $data, TRUE), $output_position, TRUE);
          
        }else if($report_type == 'ambulance_wise_cons_report'){
            $data['submit_function'] = "ambulance_wise_cons_report";
            $data['report_name'] = "Ambulance wise Consumable Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_wise_cons_report', $data, TRUE), $output_position, TRUE); 
        }
        /*else if ($report_type == 'patient_serverd_count_report') {
            
            $data['submit_function'] = "patient_serverd_count_ambulancewise";
            $data['report_name'] = "Patient Served Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/patient_serverd_count_ambulancewise_view', $data, TRUE), $output_position, TRUE);
            
        }*/
        else if ($report_type == 'daily_report_mcgm') {
            
            $data['submit_function'] = "save_export_patient";
            $data['report_name'] = "Daily Report - MCGM";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/daily_report_mcgm_report_view', $data, TRUE), $output_position, TRUE);
           
        }
        else if ($report_type == 'ambulance_availability_report') {
            
            $data['submit_function'] = "availability_hourly_report_form";
            $data['report_name'] = "Ambulance Availability Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_availability_report_view', $data, TRUE), $output_position, TRUE);
            
        }
        else if ($report_type == 'pta_summery_report') {
            
            // $data['submit_function'] = "dispatch_incident_report";
             $data['report_name'] = "Summary Report";
             $this->output->add_to_position($this->load->view('frontend/erc_reports/Summary_report_view', $data, TRUE), $output_position, TRUE);
          }
         else if ($report_type == 'ambulance_login_report'){
             $thirdparty = $this->clg->thirdparty;
 
             $district = $this->clg->clg_district_id;
             $clg_district_id = json_decode($district);
             if(is_array($clg_district_id)){
                 $district_id = implode("','",$clg_district_id);
             }
             $amb_arg = array('thirdparty' => $thirdparty,'district_id'=>$district_id);
             $report_data = $this->amb_model->get_amb_login_data($amb_arg);
             $count=1;
             foreach ($report_data as $row) {
                 $amb_arg1 = array('amb_rto_register_no' => $row->amb_rto_register_no);
                 $login_data = $this->amb_model->get_amb_login_status($amb_arg1);
                // var_dump($login_data);
                 $inc_data[] = array(
                    'Ambulance_no'=> $row->amb_rto_register_no,
                    'status'=> $login_data[0]->status,
                    'third_party' => $row->thirdparty
                 );
                 $count++;
             }
             //var_dump($inc_data);
             $header = array('Sr.No', 'Ambulance No','Status','Third Party'); 
             $data['header'] = $header;
             $data['inc_data'] = $inc_data;
             $data['report_name'] = "Ambulance Login Report";
             $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_login_report_view', $data, TRUE), $output_position , TRUE);
         }else if($report_type == 'provide_imp_dist_report'){
            $data['submit_function'] = "provide_imp_filter_report_type";
            $data['report_name'] = "Provider Impressions Districtwise Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/provide_imp_report_view', $data, TRUE), $output_position, TRUE); 
        }else if($report_type == 'reports_response_time_108'){
            $data['submit_function'] = "response_time_reports_108";
            $data['report_name'] = "Response time report for 108";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/reports_response_time_108_view', $data, TRUE), $output_position, TRUE); 
        }else if ($report_type == 'hpcl_ambulance_report') {
            //$data['submit_function'] = "export_emp_report";
            $data['report_name'] = "HPCL Ambulance Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/hpcl_ambulance_reports_view', $data, TRUE), $output_position, TRUE);
        }else if ($report_type == 'cons_ambulance_report') {
            //$data['submit_function'] = "export_emp_report";
            $data['report_name'] = "Ambulance Consumption Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/cons_ambulance_reports_view', $data, TRUE), $output_position, TRUE);
        }else if ($report_type == 'fuel_report') {
            $data['submit_function'] = "fuel_report";
            $data['report_name'] = "Fuel Consumption Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/reports_response_time_108_view', $data, TRUE), $output_position, TRUE);
        }else if ($report_type == 'vahicle_fuel_report') {
            $data['submit_function'] = "vahicle_fuel_report";
            $data['report_name'] = "Vehicle Wise Fuel Consumption Data";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/reports_response_time_108_view', $data, TRUE), $output_position, TRUE);
        }else if ($report_type == 'dco_validation_report') {
            $data['submit_function'] = "dco_validation_report";
            $data['report_name'] = "DCO Validation Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/reports_dco_validation_report_view', $data, TRUE), $output_position, TRUE);
        }else if ($report_type == 'denial_report') {
            // $data['submit_function'] = "denial_report";
            if ($this->clg->clg_group ==  'UG-DM' || $this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER') {

                $district_code = $this->clg->clg_district_id;
                $clg_district_id = json_decode($district_code);
                if (is_array($clg_district_id)) {
                    $district_id = implode("','", $clg_district_id);
                }
                $data['amb_district'] = $district_id;
                $data['district_data'] = $this->common_model->get_district(array('st_id' => 'MP', 'district_id' => $district_id));
            } else {
    
                $data['district_data'] = $this->common_model->get_district(array('st_id' => 'MP'));
            }
            $data['report_name'] = "Ambulance Denial Report";
            $this->output->add_to_position($this->load->view('frontend/amb/amb_denial_report_view', $data, TRUE), $output_position, TRUE);
        }else if($report_type == 'indent_dispatch_receive_report') {
            $data['submit_function'] = "indent_dispatch_receive";
            $data['report_name'] = "Indent Request dispatch and receive Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/reports_response_time_108_view', $data, TRUE), $output_position, TRUE);
        }else if($report_type == 'amb_boi_audit_summary_report') {
            $data['submit_function'] = "amb_boi_audit_summary_report";
            $data['report_name'] = "Ambulance Biomedical Audit Summary report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/boi_audit_summary', $data, TRUE), $output_position, TRUE);
        }else if($report_type == 'bpcl_report') {
           // $data['submit_function'] = "bpcl_report";
            $data['report_name'] = "BPCL Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/bpcl_report_view', $data, TRUE), $output_position, TRUE);
        }
        
        else if ($report_type == 'employee_details_report') {
            $data['submit_function'] = "employee_details_report";
            $data['report_name'] = "Employee Details Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/employee_details_select_view', $data, TRUE), $output_position, TRUE);
        }

        else if ($report_type == 'nhm_mis_report') {
            $data['submit_function'] = "nhm_mis_report_table";
            $data['report_name'] = "NHM MIS Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/MIS_report_view', $data, TRUE), $output_position, TRUE);
            
        }

        else if ($report_type == 'amb_case_report') {
            $data['submit_function'] = "load_case_report_form";
            $data['report_name'] = "Case Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/case_filter_details_view', $data, TRUE), $output_position, TRUE);
        }
// 
        else if ($report_type == 'amb_distance_report') {
            
            $data['submit_function'] = "load_distance_report_form";
            $data['report_name'] = "Ambulance Distance Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/distance_travel_report_filter', $data, TRUE), $output_position, TRUE);
        }
// 
        else if ($report_type == 'all_call_format') {
            //$data['submit_function'] = "employee_details_report";
            $data['report_name'] = "All Call Format";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/all_call_format_view', $data, TRUE), $output_position, TRUE);
        }
        else if ($report_type == 'Offroad_Sum_Reports') {
            // $data['submit_function'] = "save_export_patient";
            $data['report_name'] = "Offroad Summary Report";
            $data['clg_group'] = $this->clg->clg_group;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/offroad_sum_view', $data, TRUE), $output_position, TRUE);
        }else if ($report_type == 'response_time_Sum_Reports') {
            $data['submit_function'] = "load_response_time_report_form";
            $data['report_name'] = "Response Time Summary Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/response_time_report_filter', $data, TRUE), $output_position, TRUE);
        }

        else if ($report_type == 'pending_closure_report') {
            // $data['submit_function'] = "pending_closure_report";
            $data['report_name'] = "Pending For Closure Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/pending_for_closure_view', $data, TRUE), $output_position, TRUE);
        }

        else if ($report_type == 'pending_validation_report') {
            // $data['submit_function'] = "pending_closure_report";
            $data['report_name'] = "Pending Validation Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/pending_validation_filter_view', $data, TRUE), $output_position, TRUE);
        }
        else if ($report_type == 'mdt_login_report') {
            // $data['submit_function'] = "mdt_login_report";
            $data['zones'] = $this->common_model->get_divisions();
            $data['report_name'] = "MDT Login Report";
            $data['clg_group'] = $this->clg->clg_group;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/mdt_login_view', $data, TRUE), $output_position, TRUE);
        }
        else if ($report_type == 'dispatch_closure_summary') {
            $data['report_name'] = "Dispatch/Closure Summary Report";
            $data['zones'] = $this->common_model->get_divisions();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/dispatch_closure_report_filter_view', $data, TRUE), $output_position, TRUE);
        }
        else if ($report_type == 'gps_report') {
            $data['report_name'] = "MDT Distance Travelled Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/gps_odo_report_view', $data, TRUE), $output_position, TRUE);
        }
        else if($report_type == 'ins_audit_report'){
            $data['report_name'] = "Inspection Audit Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/inspection_audit_report', $data, TRUE), $output_position, TRUE);
        
        }
        else if($report_type == 'amb_distance_travel_report'){
            $data['report_name'] = "Ambulance Distance Travel Report";
            $data['submit_function'] = "ambulance_dist_travel_filter";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_distance_travel_report_filter_view', $data, TRUE), $output_position, TRUE);
        }
    }

    /************************************** */
    function get_district_list(){
        $dist = $this->input->post('dist');
        // print_r($dist);die;
        $data = $this->common_model->get_dist_lists($dist);
        // var_dump($data);
        echo json_encode($data);die;
        // echo $sdata;
        // echo 1;
    }
    // function on_offreport(){
    //     $report_type = $this->input->post('onroad_report_type_report');
    //     $dist = $this->input->post('onroad_report_type_dist');
    //     $divs = $this->input->post('onroad_report_type_divs');
    //     if ($report_type === '1') {
    //         $data['submit_function'] = "load_employee_report1";
    //         $this->output->add_to_position($this->load->view('frontend/erc_reports/employee_group_wise_details_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
    //         $this->output->add_to_position('', 'Sub_employee_report_block_fields', TRUE);
    //          $this->output->add_to_position('', 'user_employee_report_block_fields', TRUE);
    //         $this->output->add_to_position('', 'list_table', TRUE);
    //     }
    //     // echo $divs;die;
    // }
    function load_employee_group_wise_details_form(){
        $report_type = $this->input->post('emp_report_type');

        if ($report_type === '1') {
            $data['submit_function'] = "load_employee_report1";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/employee_group_wise_details_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_employee_report_block_fields', TRUE);
             $this->output->add_to_position('', 'user_employee_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
    }
    function load_employee_report1() {
        $post_reports = $this->input->post();
        $report_args = $post_reports['department_name'];
        $report_data= $this->colleagues_model->get_clg_all_data($report_args);
        $clg_status = array('0' => 'Inactive', '1' => 'Active', '2' => 'Deleted');
        $row = array();
        $rows =array();
        
        foreach ($report_data as $key => $row) { 
            $rows[] =
            array('clg_id' => $row->clg_id,
            'clg_ref_id' => strtoupper($row->clg_ref_id),
            'clg_jaesemp_id' => $row->clg_jaesemp_id,
            'clg_group' => strtoupper($row->clg_group),
            'clg_designation' => $row->clg_designation,
            'clg_first_name' => $row->clg_first_name. ' '.$row->clg_mid_name. ' '.$row->clg_last_name,
            'clg_mobile_no' => $row->clg_mobile_no,
            'clg_gender' => ucfirst($row->clg_gender),
            'clg_marital_status' => ucfirst($row->clg_marital_status),
            'clg_dob' => $row->clg_dob=="0000-00-00"?"-":date("d-M-Y",strtotime($row->clg_dob)),
            'clg_joining_date' => $row->clg_joining_date=="0000-00-00"?"-":date("d-M-Y",strtotime($row->clg_joining_date)),
            'clg_senior' => ucfirst($row->clg_senior),
            'clg_user_type' => $row->clg_user_type,
            'clg_avaya_agentid' => $row->clg_avaya_agentid,
            'clg_address' => ucfirst($row->clg_address),
            'clg_district_id' =>  get_district_by_id($row->clg_district_id),
            'clg_city' => ucfirst($row->clg_city),
            'clg_is_active' => $row->clg_is_active==1?"Active":"Inactive",
            'clg_thirdparty' => $row->clg_thirdparty
        );
                                    
        }
    
        $header = array('Sr No.',
        'Application ID',
        'Jaes Employee ID',
        'Group',
        'Designation',
        'Full Name',
        'Mobile No',
        'Gender',
        'Marital Status',
        'DOB',
        'Joining Date',
        'Senior',
        'User Type',
        'Avaya Agent ID',
        'Address',
        'District',
        'City',
        'Status',
        'Third Party'
        );

        if ($post_reports['reports'] == 'view') {
            $data['header'] = $header;
            $data['inc_data'] = $rows;
            $data['report_args'] = $report_args;
            $data['submit_funtion'] = 'load_employee_report1';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/employee_details_view', $data, TRUE,'list_table', TRUE));  
        } else {
           
            $filename = "employee_details_reports.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);
            foreach ($rows as $r) {
               
                fputcsv($fp, $r);
            }
            fclose($fp);
            exit;
        }
    }
    
    function load_employee_report2() {
        $post_reports = $this->input->post();
        $group = $post_reports['department_name'];
        $data['report_data'] = $this->colleagues_model->get_clg_all_data($group);
        // print_r($data['report_data']);die;
        $header = array('Sr No.',
                'Application ID',
                'Jaes Employee ID',
                'Group',
                'Designation',
                'Full Name',
                'Gender',
                'Marital Status',
                'DOB',
                'Joining Date',
                'Senior',
                'User Type',
                'Avaya Agent ID',
                'Address',
                'District',
                'City',
                'Status',
                'Third Party'
                );
                
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
           // $data['report_args'] = $report_args;
            // $data['submit_funtion'] = 'load_employee_report1';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/employee_details_view', $data, TRUE));
        } 

        function load_case_report_form(){
            $post_reports = $this->input->post();
            $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
            $yesterday = date( 'Y-m-d', strtotime( $from_date . ' -1 day' ) );
            $base_month = $this->common_model->get_base_month($from_date);
            $this->post['base_month'] = $base_month[0]->months;

            if ($post_reports['to_date'] != '') {
                $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                    'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                    'base_month' => $this->post['base_month']);
            } else {
                $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                    'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                    'base_month' => $this->post['base_month']);
            }
            $get_district = $this->inc_model->get_district_name();
            // print_r($get_district);die;
            $report_data=array();
            foreach($get_district as $district){
                $fromdate = date('Y-m-d ',strtotime($post_reports['from_date']));
                $todate = date('Y-m-d ',strtotime($post_reports['to_date']));
                $today_args = array('from_date' => $fromdate,
                'to_date' => $todate,
                'district_id'=>$district->dst_code,
                'system' => '108'
                );
               
                $get_cl_count = $this->dashboard_model_final_updated->get_total_call_type1($today_args);
            }
           
            $header = array('Sr No.',
            'District',
            'Zone',
            'Total Dispatched Cases',
            'Case Closed By MDT',
            'Case Validation By DCO',
            'Pending for Closure',
            'Pending for Validation'
            );
            foreach($get_district as $district){
            $report_data[] =array(
                'dist_name' => $district->dst_name,
                'get_cl_count' => $get_cl_count[0]->incis_deleted,
            );  
        }
           // if ($post_reports['reports'] == 'view') {
                $data['header'] = $header;
                $data['inc_data'] = $report_data;
                $data['report_args'] = $report_args;
                $this->output->add_to_position($this->load->view('frontend/erc_reports/case_details_view', $data, TRUE));
        //}
    }

 
    function corona_call_summary(){
        $data['submit_function'] = "show_corona_call_summary";
        $this->output->add_to_position($this->load->view('frontend/erc_reports/corona_call_summary_view', $data, TRUE), $output_position, TRUE);
    }
    function show_corona_call_summary(){
        $report_args =  $this->input->post();
        $from_date =  date('Y-m-d', strtotime($this->input->post('from_date')));
        
        $header = array('Date','Number of Out call done','Connected Calls','Not Connected Calls','Symptomatic Count','Asymptomatic');

       $main_file_name = strtotime($post_reports['from_date']);
       $filename = "corona_call_summary" . $main_file_name . ".csv";
       
       $args = array('from_date'=>$from_date,'get_count'=>TRUE);
       
       $out_calls = $this->corona_model->corona_out_calls($args);
       
       $args['is_phone_connected'] = 'Call Answered';
       $connected_calls = $this->corona_model->corona_connected_calls($args);
       
       $not_connected_calls = $out_calls-$connected_calls;
       
       $args['symptomatic'] = 'symptomatic';
       $symptomatic = $this->corona_model->corona_symptomatic_calls($args);
       
       $args['symptomatic'] = 'asymptomatic';
       $asymptomatic = $this->corona_model->corona_symptomatic_calls($args);

        
        $report_data= array('corona_date' => $from_date,
                            'out_calls' => $out_calls,
                            'connected_calls'=> $connected_calls, 
                            'not_connected_calls'=> $not_connected_calls,
                            'symptomatic_count'=>$symptomatic,
                            'asymptomatic'=>$asymptomatic);
        
    
      
       if ($report_args['reports'] == 'view') {

          $data['header'] = $header;
          $data['data'] = $report_data;
          $data['report_args'] = $report_args;
          $this->output->add_to_position($this->load->view('frontend/erc_reports/show_corona_call_summary_view', $data, TRUE), 'list_table', TRUE);
      } else {
          //var_dump("hii");die();
          $filename = "corona_call_summary_report.csv";
          $fp = fopen('php://output', 'w');
          header('Content-type: application/csv');
          header('Content-Disposition: attachment; filename=' . $filename);
          fputcsv($fp, $header);

           fputcsv($fp, $report_data);
            $count++;
         

          fclose($fp);
          exit;
      }
      
    }
   function corona_call_details(){
        $data['submit_function'] = "show_corona_call_details";
        $this->output->add_to_position($this->load->view('frontend/erc_reports/corona_call_summary_view', $data, TRUE), $output_position, TRUE);
    }
    function show_corona_call_details(){
        $report_args =  $this->input->post();
        $from_date =  date('Y-m-d', strtotime($this->input->post('from_date')));
        
        $header = array('Incident id','Corona Test Date','Follow up date','Patient Name','Patient Contact Number','Gender',	'Age','District','Address',	'Follow up count','Call Status','Fever','Cough','Diarrhoea','Abdominal pain','Breathlessness','Nausea',	'Vomiting','Chest Pain','Sputum','Nasal Discharge','Pulse Oxymeter Status',	'Oxygen Saturation','Travel History','Current Place','ERO Advise','ERO Summary');

       
       $args = array('from_date'=>$from_date);
       
       $calls_details = $this->corona_model->get_corona_calls_details($args);
      
      
       if ($report_args['reports'] == 'view') {

          $data['header'] = $header;
          $data['data'] = $calls_details;
          $data['report_args'] = $report_args;
          $this->output->add_to_position($this->load->view('frontend/erc_reports/show_corona_call_details_view', $data, TRUE), 'list_table', TRUE);
          
      } else {
          //var_dump("hii");die();
          $filename = "corona_call_summary" . $main_file_name . ".csv";
          $fp = fopen('php://output', 'w');
          header('Content-type: application/csv');
          header('Content-Disposition: attachment; filename=' . $filename);
          fputcsv($fp, $header);
          foreach ($calls_details as $inc) {
               // var_dump($month_args);
              if($inc->is_case_close == 0){ $is_case_close = "Call Not Close"; }else{  $is_case_close = "Call Close"; };
                $data = array (
                    'inc_ref_id'=>$inc->inc_ref_id, 
                'carona_test_date'=>$inc->carona_test_date, 
                'follow_up_date'=>$inc->follow_up_date,
                'patient_name'=>$inc->patient_name,
                'mobile_no'=>$inc->mobile_no,
                'patient_gender'=>$inc->patient_gender,
                'patient_age'=>$inc->patient_age,
                'district_id'=>get_district_by_id($inc->district_id),
                'address'=>$inc->address,
                'call_count'=> follow_up_count_corona($inc->corona_id),
                'is_case_close'=>$inc->is_phone_connected,
                'fever'=> ucfirst($inc->fever),
                'cough'=>ucfirst($inc->cough), 
                'diarrhoea'=>ucfirst($inc->diarrhoea),
                'abdominal_pain'=>ucfirst($inc->abdominal_pain),
                'breathlessness'=>ucfirst($inc->breathlessness),
                'nausea'=>ucfirst($inc->nausea),
                'vomiting'=>ucfirst($inc->vomiting),
                'chest_pain'=>ucfirst($inc->chest_pain),
                'sputum'=>ucfirst($inc->sputum),
                'nasal_discharge'=>ucfirst($inc->nasal_discharge),
                'pulse_oxymeter'=>ucfirst($inc->pulse_oxymeter),
                'oxygen_saturation_value'=>$inc->oxygen_saturation_value,
                'travel_history'=>$inc->travel_history,
                'current_place'=>$inc->current_place,
                'ero_summary'=>$inc->ero_summary,
                'ero_note'=>$inc->ero_note,
                );

                fputcsv($fp,$data);
                
               
            }

          // fputcsv($fp, $report_data);
            $count++;
         

          fclose($fp);
          exit;
      }
      
    }
    function corona_call_responce_type_report(){
        $data['submit_function'] = "show_corona_call_responce_type_report";
        $this->output->add_to_position($this->load->view('frontend/erc_reports/corona_call_summary_view', $data, TRUE), $output_position, TRUE);
    }
    function pre_maintaince_details_report(){
        $data['submit_function'] = "show_pre_maintaince_details_report";
        $this->output->add_to_position($this->load->view('frontend/erc_reports/pre_maintaince_details_view', $data, TRUE), $output_position, TRUE);
    }
    
    function show_pre_maintaince_details_report(){
        $report_args =  $this->input->post();
        $from_date =  date('Y-m-d', strtotime($this->input->post('from_date')));
        $report_args_till_month = array('from_date' => date('Y-m-d', strtotime($from_date)),
              'to_date' => date('Y-m-t', strtotime($from_date)),
              'get_count'=>TRUE);
        
        $report_args_till_date = array('from_date' => date('Y-m-d'),
              'to_date' => date('Y-m-d'),
              'get_count'=>TRUE);
        
        
        $date_array = getdate (time());
        $numdays = $date_array["wday"];

        $startdate = date("Y-m-d", time() - ($numdays * 24*60*60));
        $enddate = date("Y-m-d", time() + ((7 - $numdays) * 24*60*60));

        $report_args_till_week = array('from_date' => date('Y-m-d', strtotime($startdate)),
                'to_date' => date('Y-m-d', strtotime($enddate)),
                'get_count'=>TRUE);
        
        $till_date_schedule = $this->ambmain_model->preventive_maintenance_report($report_args_till_date);
        $till_week_schedule  = $this->ambmain_model->preventive_maintenance_report($report_args_till_week);
        $till_month_schedule  = $this->ambmain_model->preventive_maintenance_report($report_args_till_month);
       // die();
     
        
        $completed_args_till_month = array('from_date' => date('Y-m-d', strtotime($from_date)),
              'to_date' => date('Y-m-t', strtotime($from_date)),
              'mt_isupdated'=>'1',
              'get_count'=>TRUE);
        
        $completed_args_till_date = array('from_date' => date('Y-m-d'),
              'to_date' => date('Y-m-d'),
              'mt_isupdated'=>'1',
              'get_count'=>TRUE);
        $completed_args_till_week = array('from_date' => date('Y-m-d', strtotime($startdate)),
                'to_date' => date('Y-m-d', strtotime($enddate)),
                'mt_isupdated'=>'1',
                'get_count'=>TRUE);
        $till_date_completed = $this->ambmain_model->preventive_maintenance_report($completed_args_till_date);
        $till_week_completed  = $this->ambmain_model->preventive_maintenance_report($completed_args_till_week);
        $till_month_completed  = $this->ambmain_model->preventive_maintenance_report($completed_args_till_month);
        
        $pending_args_till_month = array('from_date' => date('Y-m-d', strtotime($from_date)),
              'to_date' => date('Y-m-t', strtotime($from_date)),
              'mt_approval'=>'0',
              'get_count'=>TRUE);
        
        $pending_args_till_date = array('from_date' => date('Y-m-d'),
              'to_date' => date('Y-m-d'),
              'mt_approval'=>'0',
              'get_count'=>TRUE);
        $pending_args_till_week = array('from_date' => date('Y-m-d', strtotime($startdate)),
                'to_date' => date('Y-m-d', strtotime($enddate)),
                'mt_approval'=>'0',
                'get_count'=>TRUE);
        
        $till_date_pending = $this->ambmain_model->preventive_maintenance_report($pending_args_till_date);
        $till_week_pending  = $this->ambmain_model->preventive_maintenance_report($pending_args_till_week);
        $till_month_pending = $this->ambmain_model->preventive_maintenance_report($pending_args_till_month);
        $data_report= array('till_date_schedule'=>$till_date_schedule,
                            'till_week_schedule'=>$till_week_schedule,
                            'till_month_schedule'=>$till_month_schedule,
                            'till_date_completed'=>$till_date_completed,
                            'till_week_completed'=>$till_week_completed,
                            'till_month_completed'=>$till_month_completed,
                            'till_date_pending'=>$till_date_pending,
                            'till_week_pending'=>$till_week_pending,
                            'till_month_pending'=>$till_month_pending);
        
        $data['data_report'] = $data_report;

         $header = array('Parameter','Today','Week Till Date','Month Till Date');

         
        if ($report_args['reports'] == 'view') {

          $data['header'] = $header;
          $data['data'] = $report_data;
          $data['report_args'] = $report_args;
          $this->output->add_to_position($this->load->view('frontend/erc_reports/show_pre_maintaince_details_report_view', $data, TRUE), 'list_table', TRUE);
      } else {
          //var_dump("hii");die();
           $filename = "corona_call_summary_report.csv";
           $fp = fopen('php://output', 'w');
           header('Content-type: application/csv');
           header('Content-Disposition: attachment; filename=' . $filename);
           fputcsv($fp, $header);
           
           fputcsv($fp,array('Total Ambulances Scheduled For Preventive Maintenance',$till_date_schedule,$till_week_schedule,$till_month_schedule));
           fputcsv($fp,array('Total Ambulances Preventive Maintenance Completed',$till_date_completed,$till_week_completed,$till_month_completed));
           fputcsv($fp,array('Total Ambulances Pending For Preventive Maintenance',$till_date_pending,$till_week_pending,$till_month_pending));

          fclose($fp);
          exit;
      }

    }
    
    function show_corona_call_responce_type_report(){
        $report_args =  $this->input->post();
        $from_date =  date('Y-m-d', strtotime($this->input->post('from_date')));
        
        $header = array('Call Answered','Call Not Answered','Incoming Not Available','Not Connected Calls','Not Reachable','Switch Off','Wrong No','Grand Total');

       $main_file_name = strtotime($post_reports['from_date']);
       $filename = "corona_call_summary" . $main_file_name . ".csv";
       
       $args = array('from_date'=>$from_date,'get_count'=>TRUE);
       
       $out_calls = $this->corona_model->corona_out_calls($args);
       
       $args['is_phone_connected'] = 'Call Answered';
       $connected_calls = $this->corona_model->corona_connected_calls($args);
       
       $args['is_phone_connected'] = 'Call Not Answered';
       $call_not_answered = $this->corona_model->corona_connected_calls($args);
       
       $args['is_phone_connected'] = 'Incoming Not Available';
       $incoming_not_available = $this->corona_model->corona_connected_calls($args);
       
        $args['is_phone_connected'] = 'Not Connected Calls';
       $not_connected_calls = $this->corona_model->corona_connected_calls($args);
       
        $args['is_phone_connected'] = 'Wrong Number';
        $wrong_no = $this->corona_model->corona_connected_calls($args);
       
        $args['is_phone_connected'] = 'Not Reachable';
        $not_reachable = $this->corona_model->corona_connected_calls($args);
        
        $args['is_phone_connected'] = 'Switched Off';
        $switch_off = $this->corona_model->corona_connected_calls($args);

        
        $report_data= array('call_answered' => $connected_calls,
                            'call_not_answered' => $call_not_answered,
                            'incoming_not_available'=> $incoming_not_available, 
                            'not_connected_calls'=> $not_connected_calls,
                            'not_reachable'=>$not_reachable,
                            'switch_off'=>$switch_off,
                            'wrong_no'=>$wrong_no,
                            'grand_total'=>$out_calls);
        
    
      
       if ($report_args['reports'] == 'view') {

          $data['header'] = $header;
          $data['data'] = $report_data;
          $data['report_args'] = $report_args;
          $this->output->add_to_position($this->load->view('frontend/erc_reports/show_corona_responce_type_report_view', $data, TRUE), 'list_table', TRUE);
      } else {
          //var_dump("hii");die();
          $filename = "corona_call_summary_report.csv";
          $fp = fopen('php://output', 'w');
          header('Content-type: application/csv');
          header('Content-Disposition: attachment; filename=' . $filename);
          fputcsv($fp, $header);

           fputcsv($fp, $report_data);
            $count++;
         

          fclose($fp);
          exit;
      }
      
    }
    function provide_imp_filter_report_type() {
        $report_type = $this->input->post('report_type1');
      //  var_dump($report_type);die;
        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "all_provider_imp_date_filter";
            $data['all_provide_imp'] = $this->call_model->get_all_provide_imp();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/provider_imp_filter_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }       
        if ($report_type === '2') {
            $data['submit_function'] = "unavail_provider_imp_date_filter";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/provider_imp_filter_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }
    }
    function unavail_provider_imp_date_filter(){
        $report_type = $this->input->post('report_type');
        //  var_dump($report_type);die;
          $data = array();
          if ($report_type === '1') {
              $data['submit_function'] = "unavailed_dipatch_imp_filter_report";
             $data['all_provide_imp'] = $this->call_model->get_unavail_provide_imp();
              $this->output->add_to_position($this->load->view('frontend/erc_reports/date_filter_provide_imp_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
          }
  
          if ($report_type === '2') {
              $data['submit_function'] = "unavailed_dipatch_imp_filter_report";
              $data['all_provide_imp'] = $this->call_model->get_unavail_provide_imp();
              $this->output->add_to_position($this->load->view('frontend/erc_reports/month_filter_provide_imp_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
          }
     }

    function all_provider_imp_filter_report(){
        
        $post_reports = $this->input->post();
        //var_dump($post_reports);
        //die;

            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
                 'system_type' => $post_reports['system_type'],
                'provider_imp' => $post_reports['provide_imp'] 
            );
       

        $get_district = $this->inc_model->get_district_name();
 
          foreach($get_district as $district)
          {
            $fromdate = date('Y-m-d',strtotime($post_reports['from_date']));
            $todate = date('Y-m-d',strtotime($post_reports['to_date']));
            
                $today_args = array('from_date' => $fromdate,
                'to_date' => $todate,
                'district_id'=>$district->dst_code,
                'system' => $post_reports['system_type'],
                'provider_imp' => $post_reports['provide_imp'] );

            
          //var_dump($today_args);die;
         $report_data = $this->pcr_model->get_dist_provide_imp_served($today_args);

        $header = array('Sr No', 'District', 'Today', 'This Month', 'Till Date');

          $years = date('Y', strtotime($post_reports['from_date']));
          $month= date('m', strtotime($post_reports['from_date']));
          $current_date =  $years.'-'.$month.'-'.'01';

              
              $month_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
              'to_date' =>  date('Y-m-t ',strtotime($post_reports['to_date'])),
              'district_id'=>$district->dst_code,
              'system' => $post_reports['system_type'],
              'provider_imp' => $post_reports['provide_imp']
          );
              
       
          //var_dump($month_args);die;
          $get_month_patient = $this->pcr_model->get_dist_provide_imp_served($month_args);
         // var_dump($get_month_patient);die;
       
          $total_args = array(
              'district_id'=>$district->dst_code,
              'system' => $post_reports['system_type'],
              'provider_imp' => $post_reports['provide_imp']
          );
          
          
          //var_dump($total_args);die;

          $get_total_patient = $this->pcr_model->get_dist_provide_imp_served($total_args);

  
     $inc_data[] = array(
         'district' => $district->dst_name,
        'total_patient' => $report_data[0]->total_patient,
        'total_month' => $get_month_patient[0]->total_patient,
        'total_till_date' => $get_total_patient[0]->total_patient

   );
   //var_dump($inc_data);die;
}
        if ($post_reports['reports'] == 'view') {

            $patient_data = array();
            // foreach ($report_data as $row) {
            
                // $patient_data[] = array(
                //      'total_patient' => $inc_data[0]->total_patient
                // );
           // }
       // var_dump($patient_data);die;
           
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['month_args'] = $month_args;
            $data['today_args'] = $today_args;
            $data['total_args'] = $total_args;
            $data['submit_funtion'] = 'all_provider_imp_filter_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/all_provider_impression_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "provide_impressions_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

           // $data = array();
              $count=1;
              $total_patient=0;
              $total_month=0;
              $total_till_date=0;
//var_dump($report_args);
            foreach ($inc_data as $inc) {
               // var_dump($month_args);
                $data = array ('Sr_no' => $count,
                    'dst_name'=>$inc['district'], 
                'total_patient'=>$inc['total_patient'], 
                'total_month'=>$inc['total_month'], 
                'total_till_date'=>$inc['total_till_date']
                );
                
                $total_patient= $total_patient + $inc['total_patient'];
                $total_month= $total_month + $inc['total_month'];
                $total_till_date= $total_till_date + $inc['total_till_date']; 
                
    
                fputcsv($fp,$data);
                $count++;
                
               
            }

            $total_count = array('Total','',$total_patient,$total_month,$total_till_date);
            fputcsv($fp, $total_count);
                
            fclose($fp);
            exit;
        }  
    }
    function unavailed_dipatch_imp_filter_report(){
        $post_reports = $this->input->post();
        // var_dump($post_reports);
       //  die;

      if ($post_reports['to_date'] != '') {
          $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
              'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
              'base_month' => $this->post['base_month']
          );
      } else {
          $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
              'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
              'base_month' => $this->post['base_month']
          );
      }

      $get_district = $this->inc_model->get_district_name();

        foreach($get_district as $district)
        {
          $fromdate = date('Y-m-d ',strtotime($post_reports['from_date']));
          $todate = date('Y-m-d ',strtotime($post_reports['to_date']));
          if ($post_reports['to_date'] != '') {
          $today_args = array('from_date' => $fromdate,
          'to_date' => $todate,
          'district_id'=>$district->dst_code,
          'system' => $post_reports['system_type'],
          'provider_imp' => $post_reports['provide_imp']
        );
      
  } else {
      $today_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
          'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
          'district_id'=>$district->dst_code,
          'system' => $post_reports['system_type'],
          'provider_imp' => $post_reports['provide_imp']
      );
  }
        //var_dump($today_args);die;
      $report_data = $this->pcr_model->get_dist_unavail_provide_imp_served($today_args);
      $report_data1 = $this->pcr_model->get_dist_provide_imp_km_served($today_args);


      $header = array('Sr No', 'District', 'Today(Dispatch Count)','Today(Distance Travelled)','This Month(Dispatch Count)','This Month(Distance Travelled)','Till Date(Dispatch Count)' ,'Till Date(Distance Travelled)');

    // var_dump($report_data);die;

    

 $years = date('Y', strtotime($post_reports['from_date']));
        $month= date('m', strtotime($post_reports['from_date']));
        $current_date =  $years.'-'.$month.'-'.'01';

        if ($post_reports['to_date'] != '') {
            $month_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
            'to_date' =>  date('Y-m-t ',strtotime($post_reports['to_date'])),
            'district_id'=>$district->dst_code,
            'system' => $post_reports['system_type'],
            'provider_imp' => $post_reports['provide_imp']
        );
      }else{
      $month_args = array('from_date' => date('Y-m-d', strtotime($current_date)),
              'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
              'district_id'=>$district->dst_code,
              'system' => $post_reports['system_type'],
              'provider_imp' => $post_reports['provide_imp']  );
      }
       // var_dump($month_args);die;
       $get_month_patient = $this->pcr_model->get_dist_unavail_provide_imp_served($month_args);
       $get_month_patient1 = $this->pcr_model->get_dist_provide_imp_km_served($month_args);

        
        if ($post_reports['to_date'] != '') {
            
        $total_args = array(
            'from_date' => date('Y-m-d', strtotime('2020-03-24')),
             'to_date' => date('Y-m-d ',strtotime($post_reports['to_date'])),
            'district_id'=>$district->dst_code,
            'system' => $post_reports['system_type'],
            'provider_imp' => $post_reports['provide_imp']
        );
        }
        else{
          $total_args = array('from_date' => date('Y-m-d', strtotime('2020-03-24')),
          'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
          'district_id'=>$district->dst_code,
          'system' => $post_reports['system_type'],
          'provider_imp' => $post_reports['provide_imp']
      );
  
        }
    //var_dump($total_args);die;

        $get_total_patient = $this->pcr_model->get_dist_unavail_provide_imp_served($total_args);
        $get_total_patient1 = $this->pcr_model->get_dist_provide_imp_km_served($total_args);




   $inc_data[] = array(
       'district' => $district->dst_name,
      'total_patient' => $report_data[0]->total_patient,
      'total_month' => $get_month_patient[0]->total_patient,
      'total_till_date' => $get_total_patient[0]->total_patient,
      'total_km' => $report_data1[0]->km,
      'total_km_month' => $get_month_patient1[0]->km,
      'total_km_date' => $get_total_patient1[0]->km,


 );
 //var_dump($inc_data);die;
}
      if ($post_reports['reports'] == 'view') {

          $patient_data = array();
          // foreach ($report_data as $row) {
          
              // $patient_data[] = array(
              //      'total_patient' => $inc_data[0]->total_patient
              // );
         // }
     // var_dump($patient_data);die;
         
          $data['header'] = $header;
          $data['inc_data'] = $inc_data;
          $data['report_args'] = $report_args;
          $data['month_args'] = $month_args;
            $data['today_args'] = $today_args;
            $data['total_args'] = $total_args;
          $data['submit_funtion'] = 'unavailed_dipatch_imp_filter_report';
          $this->output->add_to_position($this->load->view('frontend/erc_reports/unavail_provide_imp_view', $data, TRUE), 'list_table', TRUE);
      } else {
          $filename = "unabled_sipatch_report.csv";
          $fp = fopen('php://output', 'w');

          header('Content-type: application/csv');
          header('Content-Disposition: attachment; filename=' . $filename);
          fputcsv($fp, $header);

          $count=1;
              $total_patient=0;
              $total_month=0;
              $total_till_date=0;
              
            foreach ($inc_data as $inc) {
               // var_dump($total_args);
               if($inc['total_km']== NULL){
                   $totalkm='0';
               }
               else{
                $totalkm=$inc['total_km'];
               }
               if($inc['total_km_month']== NULL){
                $totalkmmonth='0';
            }
            else{
             $totalkmmonth=$inc['total_km_month'];
            }
            if($inc['total_km_date']== NULL){
                $totalkmdate='0';
            }
            else{
             $totalkmdate=$inc['total_km_date'];
            }
                $data = array ('Sr_no' => $count,
                    'dst_name'=>$inc['district'], 
                'total_patient'=>$inc['total_patient'], 
                'total_km' =>$totalkm,
                'total_month'=>$inc['total_month'], 
                'total_km_month' =>$totalkmmonth,
                'total_till_date'=>$inc['total_till_date'],
                'total_km_date' =>$totalkmdate
                );
                
                $total_patient= $total_patient + $inc['total_patient'];
                $total_month= $total_month + $inc['total_month'];
                $total_till_date= $total_till_date + $inc['total_till_date']; 
                $total_km= $total_km + $totalkm; 
                $total_km_month= $total_km_month + $totalkmmonth; 
                $total_km_date= $total_km_date + $totalkmdate; 

    
                fputcsv($fp,$data);
                $count++;
                
               
            }

            $total_count = array('Total','',$total_patient,$total_km,$total_month,$total_km_month,$total_till_date,$total_km_date);
            fputcsv($fp, $total_count);
                
            fclose($fp);
            exit;
      }  
    }
    function amb_avail_hourly_report()
    {

        $post_reports = $this->input->post();

         $data['single_date'] = $post_reports['single_date'];

        $from_date = date('Y-m-d', strtotime($post_reports['single_date']));
        $report_args = array('from_date' => $from_date);
        
        $report_data = $this->inc_model->get_amb_details_single_date($report_args);

        $header = array('Hour', 'Total Ambulance Available', 'Total Busy Ambulance', 'Total Inactive Ambulance');

        $daily_report_array = array();
        $hours_key_array = array(
            '0' => '00:00-01:00',
            '1' => '01:00-02:00',
            '2' => '02:00-03.00',
            '3' => '03.00-04.00',
            '4' => '04.00-05.00',
            '5' => '05.00-06.00',
            '6' => '06.00-07.00',
            '7' => '07.00-08.00',
            '8' => '08.00-09.00',
            '9' => '09.00-10.00',
            '10' => '10.00-11.00',
            '11' => '11.00-12.00',
            '12' => '12.00-13.00',
            '13' => '13.00-14.00',
            '14' => '14.00-15.00',
            '15' => '15.00-16.00',
            '16' => '16.00-17.00',
            '17' => '17.00-18.00',
            '18' => '18.00-19.00',
            '19' => '19.00-20.00',
            '20' => '20.00-21.00',
            '21' => '21.00-22.00',
            '22' => '22.00-23.00',
            '23' => '23.00-24.00');

            if($report_data)
            {
                foreach ($report_data as $report)
                {
                    $hour = date('G', strtotime($report->date_time));
                    $daily_report_array[$hour]['available_count'][] = $report->available_count;
                            $daily_report_array[$hour]['busy_count'][] = $report->busy_count;
                       
                            $daily_report_array[$hour]['inactive_count'][] = $report->inactive_count;  
        
                }
            }
    
        if ($post_reports['reports'] == 'view') 
        {  
            $data['header'] = $header;
            $data['hours_key_array'] = $hours_key_array;
            $data['daily_report_array'] = $daily_report_array;
      
            $value = $this->output->add_to_position($this->load->view('frontend/reports/amb_avail_hourly_report_view', $data, TRUE), 'list_table', TRUE);

        } 
        else 
        { 
            $from_data = date('Y-m-d', strtotime($post_reports['single_date']));
        
            $filename = "ambulance_availibility_hourly_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);
     
                $data = array();

                for ($hh = 0; $hh < 24; $hh++) {
              
                    $available_count= 0;
                    $busy_count= 0;
                    $inactive_count= 0;
        
                    if( !empty($daily_report_array[$hh]['available_count'])){
                        $available_count = $daily_report_array[$hh]['available_count'][0];
                      
                    } else { 
                        echo '0'; 
       
                   } 
                    
                    if( !empty($daily_report_array[$hh]['busy_count'])){
                        $busy = $daily_report_array[$hh]['busy_count'];
                        $busy_count = $busy[0] ; 

                    } else { 
                        echo '0'; 
       
                   } 
                    
                  
                    if( !empty($daily_report_array[$hh]['inactive_count'])){
                        $inactive = $daily_report_array[$hh]['inactive_count'];
                        $inactive_count = $inactive[0] ;
                  
                    } else { 
                        echo '0'; 

                   } 
                    

               $inc_data = array(
                    'Hour' => $hours_key_array[$hh],
                    'available_count' =>  $available_count,
                    'busy_count' => $busy_count,
                    'inactive_count' => $inactive_count
                );
    
                fputcsv($fp, $inc_data);         
            }
      
            fclose($fp);
            exit;
        }
    }
    function load_closure_subreport_form_mcgm() {
        $report_type = $this->input->post('closure_report_type');
        //var_dump($report_type);die();
        if ($report_type === '1') {
            $data['submit_function'] = "load_closure_report_mcgm";
        }
        elseif ($report_type === '2') {
            $data['submit_function'] = "load_response_time_report_mcgm";
        }
        $this->output->add_to_position($this->load->view('frontend/erc_reports/closure_sub_report_view_mcgm', $data, TRUE), 'Sub_report_closure_block_fields', TRUE);
        $this->output->add_to_position('', 'Sub_date_report_block_fields', TRUE);
        $this->output->add_to_position('', 'list_table', TRUE);
    

    }
    function load_response_time_report_mcgm(){
        $report_type = $this->input->post('date_report_type');
        if ($report_type == '1') {
            $data['submit_function'] = "closure_response_time_report_mcgm";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view_mcgm', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        if ($report_type == '2') {
            $data['submit_function'] = "closure_response_time_report_mcgm";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view_mcgm', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
    }
    function load_closure_report_mcgm(){
        $report_type = $this->input->post('date_report_type');
        if ($report_type == '1') {
            $data['submit_function'] = "closure_dco_report_mcgm";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view_mcgm', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        if ($report_type == '2') {
            $data['submit_function'] = "closure_dco_report_mcgm";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view_mcgm', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
    }
    function closure_dco_report_mcgm() {

        $post_reports = $this->input->post();

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month']);
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month']);
        }

        
         $report_data = $this->inc_model->get_epcr_by_month_mcgm_responsetime($report_args);
      // $report_data = $this->inc_model->get_epcr_by_month($report_args);
       
        $header = array('Event ID',
            'Incident Date /Time',
            'Caller Mobile',
            'Caller Name',
            'Patient Name',
            'Gender',
            'Age',
            'Ambulance No',
            'Base Location',
            'Ward Name',
            'Parameter',
            'Call Type',
            'Destination Hospital',
            'Call Disconnected Time',
            'Scene Time',
            'Response Time'
        );
        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            foreach ($report_data as $row) {
                
              
             

                $amb_arg = array('rg_no' => $row['amb_reg_id']);
               /* $amb_data = $this->amb_model->get_amb_data($amb_arg);
                $amb_base_location = $amb_data[0]->hp_name;

                if($amb_base_location == ''){ $amb_base_location = $amb_data[0]->ward_name; }else{ $amb_base_location = $amb_data[0]->hp_name; }
                */
                if ($row['rec_hospital_name'] == '0') {
                    $hos_name = 'On scene care';
                } else if ($row['rec_hospital_name'] == 'Other') {
                    $hos_name = 'Other';
                } else {
                    $hos_name = $row['hp_name'];
                }
                $parameter='Medical';
                $inc_data[] = array(
                    'inc_datetime' => $row['inc_date_time'],
                    'inc_date' => $row['dp_date'],
                    'inc_purpose' => $row['pname'],
                    'parameter' => $parameter,
                    'inc_ref_id' => $row['inc_ref_id'],
                    'response_time' => $resonse_time,
                    'amb_rto_register_no' => $row['amb_reg_id'],
                    'patient_id' => $row['ptn_id'],
                    'patient_name' => $row['ptn_fname']." ".$row['ptn_lname'],
                    'caller_name' => $row['clr_fname']." ".$row['clr_lname'],
                    'caller_mobile' => $row['clr_mobile'],
                    'ptn_age' => $row['ptn_age'],
                    'ptn_gender' => $row['ptn_gender'],
                    'district' => $dst_name,
                    'cty_name' => $cty_name,
                    'locality' => $row['locality'],
                    'level_type' => $row['level_type'],
                    'provier_img' => $row['pro_name'],
                    'base_location' => $hos_name,
                    'other_receiving_hos' => $row['other_receiving_host'],
                    'amb_base_location' => $row['base_location_name'],
                    'wrd_location' => $row['wrd_location'],
                    'operate_by' => $row['operate_by'],
                    'start_odo' => $row['start_odometer'],
                    'end_odo' => $row['end_odometer'],
                    'total_km' => $row['total_km'],
                    'inc_datetime' => $row['inc_datetime'],
                    'dp_on_scene' => $row['dp_on_scene'],
                    'responce_time' => $row['responce_time'],
                    'remark' => $row['remark'],
                );
            }

            
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;


            $this->output->add_to_position($this->load->view('frontend/erc_reports/inc_closure_report_view_mcgm', $data, TRUE), 'list_table', TRUE);
        } else {
           // var_dump($report_data);die();
            $filename = "Report1.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            foreach ($report_data as $row) {

                $amb_arg = array('rg_no' => $row['amb_reg_id']);
                $amb_data = $this->amb_model->get_amb_data($amb_arg);
                $amb_base_location = $amb_data[0]->hp_name;
                if($amb_base_location == ''){ $amb_base_location = $amb_data[0]->ward_name; }else{ $amb_base_location = $amb_data[0]->hp_name; }
                if ($row['rec_hospital_name'] == '0') {
                    $hos_name = 'On scene care';
                } else if ($row['rec_hospital_name'] == 'Other') {
                    $hos_name = 'Other';
                } else {
                    $hos_name = $row['hp_name'];
                }
                $parameter='Medical';
                $inc_data = array(
                    'inc_ref_id' => $row['inc_ref_id'],
                    'inc_date' => $row['inc_date_time'],
                    'caller_mobile' => $row['clr_mobile'],
                    'caller_name' => $row['clr_fname']." ".$row['clr_lname'],
                    'patient_name' => $row['ptn_fname']." ".$row['ptn_lname'],
                    'ptn_gender' => $row['ptn_gender'],
                    'ptn_age' => $row['ptn_age'],
                    'amb_rto_register_no' => $row['amb_reg_id'],
                    'amb_base_location' => $row['base_location_name'],
                    'wrd_location' => $row['wrd_location'],
                    'parameter' => $parameter,
                    'call_type' => $row['pname'],
                    'base_location' => $hos_name,
                    'inc_datetime' => $row['inc_datetime'],
                    'dp_on_scene' => $row['dp_on_scene'],
                    'responce_time' => $row['responce_time'],
                );

                fputcsv($fp, $inc_data);
            }
            fclose($fp);
            exit;
        }
    }
    function closure_response_time_report_mcgm() {

        $post_reports = $this->input->post();

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month']);
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month']);
        }


        $report_data = $this->inc_model->get_epcr_by_month_mcgm_responsetime($report_args);
       
        $header = array('Event ID',
            'Incident Date /Time',
            'Caller Mobile',
            'Caller Name',
            'Total Patient Count',
            'Male',
            'Female',
            'Ambulance No',
            'Base Location',
            'Ward Location',
            'Parameter',
            'Call Type',
            'Destination Hospital',
            'Call Disconnected Time',
            'Scene Time',
            'Response Time'
        );
        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            
            foreach ($report_data as $row) {
                
               $amb_arg = array('rg_no' => $row['amb_reg_id']);
                $amb_data = $this->amb_model->get_amb_data($amb_arg);
                $amb_base_location = $amb_data[0]->hp_name;
                if($amb_base_location == ''){ $amb_base_location = $amb_data[0]->ward_name; }else{ $amb_base_location = $amb_data[0]->hp_name; }
                 if ($row['rec_hospital_name'] == '0') {
                    $hp_name = 'On scene care';
                } else if ($row['rec_hospital_name'] == 'Other') {
                    $hp_name = 'Other';
                } else {
                    $hp_name = $row['hp_name'];
                }
                $parameter='Medical';

              
                $inc_data[] = array(
                    'inc_ref_id' => $row['inc_ref_id'],
                    'inc_datetime' => $row['inc_datetime'],
                    'caller_mobile' => $row['clr_mobile'],
                    'caller_name' => $row['clr_fname']." ".$row['clr_lname'],
                    'total_patient' => $row['total_patient'],
                    'amb_rto_register_no' => $row['amb_reg_id'],
                    'amb_base_location' => $row['base_location_name'],
                    'wrd_location' => $row['wrd_location'],
                    'parameter' => $parameter,
                    'inc_purpose' => $row['pname'],
                    'base_location' => $hp_name,
                    'dp_on_scene' => $row['dp_on_scene'],
                    'responce_time' => $row['responce_time'],

                   /* 'inc_date' => $row['dp_date'],
                    'response_time' => $resonse_time,
                    'patient_id' => $row['ptn_id'],
                    'patient_name' => $row['ptn_fname']." ".$row['ptn_lname'],
                    
                    'ptn_age' => $row['ptn_age'],
                    'ptn_gender' => $row['ptn_gender'],
                    'district' => $dst_name,
                    'cty_name' => $cty_name,
                    'locality' => $row['locality'],
                    'level_type' => $row['level_type'],
                    'provier_img' => $row['pro_name'],
                   'other_receiving_hos' => $row['other_receiving_host'],
                    'operate_by' => $row['operate_by'],
                    'start_odo' => $row['start_odometer'],
                   'end_odo' => $row['end_odometer'],
                    'total_km' => $row['total_km'],
                    'inc_datetime' => $row['inc_datetime'],
                   'remark' => $row['remark'],*/
                );
            }

            
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;


            $this->output->add_to_position($this->load->view('frontend/erc_reports/inc_response_report_view_mcgm', $data, TRUE), 'list_table', TRUE);
        } else {
           // var_dump($report_data);die();
            $filename = "Report2.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            foreach ($report_data as $row) {

              
                $amb_arg = array('rg_no' => $row['amb_reg_id']);
               /* $amb_data = $this->amb_model->get_amb_data($amb_arg);
                $amb_base_location = $amb_data[0]->hp_name;
                if($amb_base_location == ''){ $amb_base_location = $amb_data[0]->ward_name; }else{ $amb_base_location = $amb_data[0]->hp_name; }
               */ if ($row['rec_hospital_name'] == '0') {
                    $hos_name = 'On scene care';
                } else if ($row['rec_hospital_name'] == 'Other') {
                    $hos_name = 'Other';
                } else {
                    $hos_name = $row['hp_name'];
                }
                $parameter='Medical';
                //ptn_count_gender($inc['inc_ref_id'],'M');
                $inc_data = array(
                    'inc_ref_id' => $row['inc_ref_id'],
                    'inc_date' => $row['inc_datetime'],
                    'caller_mobile' => $row['clr_mobile'],
                    'caller_name' => $row['clr_fname']." ".$row['clr_lname'],
                    'male' => ptn_count_gender($row['inc_ref_id'],'M'),
                    'female' => ptn_count_gender($row['inc_ref_id'],'F'),
                    'amb_rto_register_no' => $row['amb_reg_id'],
                    'amb_base_location' => $row['base_location_name'],
                    'wrd_location' => $row['wrd_location'],
                    'parameter' => $parameter,
                    'call_type' => $row['pname'],
                    'base_location' => $hos_name,
                    'Call Disconnected Time' => $row['inc_datetime'],
                    'Scene Time' => $row['dp_on_scene'],
                    'Response Time' => $row['responce_time'],
                    
                  
                );

                fputcsv($fp, $inc_data);
            }
            fclose($fp);
            exit;
        }
    }
    function ambulance_wise_cons_report(){
        
        $report_args = $this->input->post();
        $post_reports = $this->input->post();
        
        $item_args = array();
        
        if($report_args['report_type'] == 1){
            $item_args['inv_type'] = 'MED';
            $item_total = $this->med_model->get_med_list($data);
        }else if($report_args['report_type'] == 2){
            $item_args['inv_type'] = 'CA';
            $item_total = $this->inv_model->get_inv_list($data);
        }else if($report_args['report_type'] == 3){
            $item_args['inv_type'] = 'NCA';
            $item_total = $this->inv_model->get_inv_list($data);
        }

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $to_date = date('Y-m-t', strtotime($post_reports['from_date']));



        $header = array('Item Name',
            'Expected Stock',
            'Opening Stock in Month',
            'Consumed During The Month',
            'Balalnce / Closing Stock',
        );
        
        $inc_data = array();
            foreach ($item_total as $row) {
                //var_dump($row);
                $consumed_stock =0;
                $opening_stock =0;
                $balanced_stock=0;
                $base_quantity=0;
                
                if($report_args['report_type'] == 1){
                    $item_title = $row->med_title;
                    $base_quantity = $row->med_base_quantity;

                    
                    $amb_args = array(
                        'inv_type' => 'MED',
                        'inv_id'=>$row->med_id,
                        'inv_amb'=>$post_reports['amb_reg_id'],
                        'inv_to_date'=>$to_date,
                    );
                    
                    $amb_stock=get_inv_stock_by_id($amb_args);
                    //var_dump($amb_stock);
                    
                    $opening_stock = $amb_stock[0]->in_stk - $amb_stock[0]->out_stk;
                    
                    $cons_args = array(
                        'inv_type' => 'MED',
                        'inv_id' => $row->med_id,
                        'inv_amb' => $post_reports['amb_reg_id'],
                        'from_date'=>$from_date,
                        'to_date'=>$to_date,
                    );
                    
                    $cons_stock=get_inv_stock_by_id($cons_args);
                    $consumed_stock = $cons_stock[0]->out_stk;
                    
                    $balanced_stock = $opening_stock - $consumed_stock;
                    
                    //var_dump($amb_stock);
                }else if($report_args['report_type'] == 2){
                    $item_title = $row->inv_title;
                    $base_quantity = $row->inv_base_quantity;
                    
                      $amb_args = array(
                        'inv_type' => 'CA',
                        'inv_id'=>$row->inv_id,
                        'inv_amb'=>$post_reports['amb_reg_id'],
                        'inv_to_date'=>$to_date,
                    );
                    
                    $amb_stock=get_inv_stock_by_id($amb_args);
                    //var_dump($amb_stock);
                    
                    $opening_stock = $amb_stock[0]->in_stk - $amb_stock[0]->out_stk;
                    
                    $cons_args = array(
                        'inv_type' => 'CA',
                        'inv_id' => $row->inv_id,
                        'inv_amb' => $post_reports['amb_reg_id'],
                        'from_date'=>$from_date,
                        'to_date'=>$to_date,
                    );
                    
                    $cons_stock=get_inv_stock_by_id($cons_args);
                    $consumed_stock = $cons_stock[0]->out_stk;
                    
                    $balanced_stock = $opening_stock - $consumed_stock;

                }else if($report_args['report_type'] == 3){
                    
                    $item_title = $row->inv_title;
                    $base_quantity = $row->inv_base_quantity;
                    
                      $amb_args = array(
                        'inv_type' => 'NCA',
                       'inv_id'=>$row->inv_id,
                        'inv_amb'=>$post_reports['amb_reg_id'],
                        'inv_to_date'=>$to_date,
                    );
                    
                    $amb_stock=get_inv_stock_by_id($amb_args);
                    //var_dump($amb_stock);
                    
                    $opening_stock = $amb_stock[0]->in_stk - $amb_stock[0]->out_stk;
                    
                    $cons_args = array(
                        'inv_type' => 'NCA',
                        'inv_id' => $row->inv_id,
                        'inv_amb' => $post_reports['amb_reg_id'],
                        'from_date'=>$from_date,
                        'to_date'=>$to_date,
                    );
                    
                    $cons_stock=get_inv_stock_by_id($cons_args);
                    $consumed_stock = $cons_stock[0]->out_stk;
                    
                    $balanced_stock = $opening_stock - $consumed_stock; 
                }



                $inc_data[] = array(
                    'item_title' => $item_title,
                    'base_quantity'=>$base_quantity,
                    'opening_stock'=>$opening_stock,
                    'consumed_stock'=>$consumed_stock,
                    'balanced_stock'=>$balanced_stock,
                );
            }
            //var_dump($inc_data);

        if ($post_reports['reports'] == 'view') {

            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/consumable_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "closure_consumable_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            foreach ($inc_data as $row) {

                $items_data = array(
                    'item_title' => $row['item_title'],
                    'base_quantity' => $row['base_quantity']?$row['base_quantity']:0,
                    'opening_stock' => $row['opening_stock']?$row['opening_stock']:0,
                    'consumed_stock' => $row['consumed_stock']?$row['consumed_stock']:0,
                    'balanced_stock' => $row['balanced_stock']?$row['balanced_stock']:0);

                fputcsv($fp, $items_data);
            }
            fclose($fp);
            exit;
        }
    }
    function load_patient_served_sub_option_report_form_new()
    {
        $report_type_new = $this->input->post('report_type_new');
        //var_dump($report_type_new);die();
        $data = array();
        if ($report_type_new == '1') {
            //$data['submit_function'] = "patientserved_report_view";
            $data['report_type_new'] = $report_type_new;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/patient_serverd_count_ambulancewise_view_new', $data, TRUE), 'report_block_fields', TRUE);
        }
        if ($report_type_new == '2') {
            //$data['submit_function'] = "patientserved_report_view";
            $data['report_type_new'] = $report_type_new;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/patient_serverd_count_ambulancewise_view_new', $data, TRUE), 'report_block_fields', TRUE);
        }
        if ($report_type_new == '3') {
            //$data['submit_function'] = "patientserved_report_view";
            $data['report_type_new'] = $report_type_new;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/patient_serverd_count_ambulancewise_view_new', $data, TRUE), 'report_block_fields', TRUE);
        }
    }
    function load_patient_served_sub_option_report_form()
    {
        $report_type = $this->input->post('report_type');
        $report_type_new = $this->input->post('report_type_new');
        $dist = $this->common_model->get_district();
        // print_r($dist);die();
        // var_dump($report_type_new);die();
        $data = array();
        if ($report_type == '1') {
            $data['submit_function'] = "patientserved_report_view";
            $data['report_type_new'] = $report_type_new;
            $data['district_data'] = $dist;
            $this->output->add_to_position($this->load->view('frontend/reports/export_patientserved_date_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        if ($report_type == '2') {
            $data['submit_function'] = "patientserved_report_view";
            $data['report_type_new'] = $report_type_new;
            $data['district_data'] = $this->common_model->get_district();
            $this->output->add_to_position($this->load->view('frontend/reports/export_patientserved_month_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        if ($report_type == '3') {
            $data['submit_function'] = "patientserved_report_view";
            $data['report_type_new'] =$report_type_new;
            $data['district_data'] = $this->common_model->get_district();
            $this->output->add_to_position($this->load->view('frontend/reports/export_patientserved_daily_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        if ($report_type == '4') {
            $data['submit_function'] = "patient_served_report_days";
            $data['report_type_new'] = $report_type_new;
            $data['district_data'] = $this->common_model->get_district();
            $this->output->add_to_position($this->load->view('frontend/reports/export_patientserved_date_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        
    }
   //patient served Report
   function patientserved_report_view(){
    //var_dump('hii');die();
    $post_reports = $this->input->post();
    $report_type_new = $this->input->post('report_type_new');
   //var_dump($post_reports);die();
    if($report_type_new=='2')
    {
       // var_dump('hii');die();
     $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
     $base_month = $this->common_model->get_base_month($from_date);
     $base_month =$base_month[0]->months;

     if ($post_reports['to_date'] != '') {

         $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
             'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
             'base_month' => $base_month,
             'dist' => $post_reports['dist'],
           );
           
     } else if($post_reports['to_date'] != '' && $post_reports['from_date'] != '') {

         $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
             'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
             'base_month' => $base_month,
             'dist' => $post_reports['dist'],
            );
         
     }else{

         $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
             'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
             'base_month' => $base_month,
             'dist' => $post_reports['dist'],
             );
     }
     
    
     $query=$this->ambmain_model->get_ambulance1($report_args);
    //  $query=$this->ambmain_model->get_ambulance($report_args);
     //var_dump($report_args);die();
     foreach($query as $inc_amb)
     {
         $data = array(
             'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
             'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
            // 'base_month' => $base_month,
             'amb_rto_register_no'=>$inc_amb->amb_rto_register_no
         );
         $report_data[$inc_amb->amb_rto_register_no]= $this->ambmain_model->get_total_call_count($data);
        //  $report_data['dst_name']=$inc_amb->dst_name;
        // var_dump($report_data);die;
     }
     
    //  var_dump($report_data);die();
    $header = array('Sr.No','District','Base Location','Ambulance Type','Ambulance No','Call Assign Count');

      $main_file_name = strtotime($post_reports['from_date']);
      $filename = "Patientserved_" . $main_file_name . ".csv";
      $this->output->set_focus_to = "inc_ref_id";
      if ($post_reports['reports'] == 'view') {

          $data['header'] = $header;
          $data['data'] = $report_data;
          $data['report_args'] = $report_args;
          $data['submit_function'] = 'patientserved_report_view';
          $data['report_type_new'] = $report_type_new;
          $this->output->add_to_position($this->load->view('frontend/erc_reports/patientserved_report_view', $data, TRUE), 'list_table', TRUE);
      } else {
          //var_dump("hii");die();
          $filename = "ambulance_patinetserved_report.csv";
          $fp = fopen('php://output', 'w');
          header('Content-type: application/csv');
          header('Content-Disposition: attachment; filename=' . $filename);
          fputcsv($fp, $header);

          $count = 1;
         
          foreach ($report_data as $key=>$row) {
              $data = array(
                'Sr.No' => $count,
                'District' => $row->dst_name,
                'Base Location'=> $row->hp_name,
                'Ambulance Type'=> $amb_type,
                'Ambulance No' => $key,
                 'Assign count' => $row->total_count,
                  
                  
              );
              fputcsv($fp, $data);
              $count++;
          }

          fclose($fp);
          exit;
      }
    }
    else if($report_type_new=='1'){
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $base_month = $this->common_model->get_base_month($from_date);
        $base_month =$base_month[0]->months;
   
        if ($post_reports['to_date'] != '') {
   
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $base_month,
                'dist' => $post_reports['dist'],
              );
              
        } else if($post_reports['to_date'] != '' && $post_reports['from_date'] != '') {
   
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $base_month,
                'dist' => $post_reports['dist'],
               );
            
        }else{
   
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $base_month,
                'dist' => $post_reports['dist'],
                );
        }
        //var_dump($report_args);die();
       
        $query=$this->ambmain_model->get_ambulance1($report_args);
       //  $query=$this->ambmain_model->get_ambulance($report_args);
        //var_dump($report_args);die();
        foreach($query as $inc_amb)
        {
            $data = array(
                'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
               // 'base_month' => $base_month,
                'amb_rto_register_no'=>$inc_amb->amb_rto_register_no
            );
            $report_data[$inc_amb->amb_rto_register_no]= $this->ambmain_model->get_total_call_count($data);
            // $report_data['dst_name']=$inc_amb->dst_name;
        //    var_dump($report_data);die;
        }
        
        //var_dump($report_data);die();
     $header = array('Sr.No','District','Base Location','Ambulance Type','Ambulance No','Total Patient served Count');

      $main_file_name = strtotime($post_reports['from_date']);
      $filename = "Patientserved_" . $main_file_name . ".csv";
      $this->output->set_focus_to = "inc_ref_id";
      if ($post_reports['reports'] == 'view') {

          $data['header'] = $header;
          $data['data'] = $report_data;
          $data['report_args'] = $report_args;
          $data['report_type_new'] = $report_type_new;
          $data['submit_function'] = 'patientserved_report_view';
          $this->output->add_to_position($this->load->view('frontend/erc_reports/patientserved_report_view', $data, TRUE), 'list_table', TRUE);
      } else {
          //var_dump("hii");die();
          $filename = "ambulance_patinetserved_report.csv";
          $fp = fopen('php://output', 'w');
          header('Content-type: application/csv');
          header('Content-Disposition: attachment; filename=' . $filename);
          fputcsv($fp, $header);

          $count = 1;

          foreach ($report_data as $key=>$row) {
            $amb_type = $row->amb_type;
            if($amb_type == '1')
            {
                $amb_type = 'JE';
            }
            elseif($amb_type == '2')
            {
                $amb_type = 'BLS';
            }
            elseif($amb_type == '3')
            {
                $amb_type = 'ALS';
            }
             $data = array(
                 'Sr.No' => $count,
                 'District' => $row->dst_name,
                 'Base Location'=> $row->hp_name,
                 'Ambulance Type'=> $amb_type,
                 'Ambulance No' => $key,
                  'Assign count' => $row->total_count,
                  
                  
              );
              fputcsv($fp, $data);
              $count++;
          }

          fclose($fp);
          exit;
      }
    }
    else{
         
    }
   // var_dump($report_type_new);die();
    
 }
 
 function patient_served_report_days(){
    $post_reports = $this->input->post();
    
    $data['report_type_new']=$report_type_new = $this->input->post('report_type_new');
    $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
    $to_date = date('Y-m-d', strtotime($post_reports['to_date']));
    $base_month = $this->common_model->get_base_month($from_date);
    $base_month =$base_month[0]->months;

    if ($post_reports['to_date'] != '') {

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $to_date = date('Y-m-d', strtotime($post_reports['to_date']));
        $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
            'base_month' => $base_month);
          
    } else  {

        $to_date = date('Y-m-d', strtotime($post_reports['to_date']));
        $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
            'base_month' => $base_month);
        
    }
   
    $date_range = $this->createdateRange( $from_date,$to_date);
   // var_dump($date_range);die;
    
    $header = array('Sr.No','Ambulance No');
    
    $ambulance_patient_servered = array();
    $ambulance_data = $this->ambmain_model->get_ambulance($report_args);
    
    //var_dump($ambulance_data);
    
    foreach($date_range as $range){           
        $header[] = $range;
       
       // var_dump($range);die();
    }
    //var_dump($report_type_new);die();
    if($report_type_new == '1') {
        foreach($ambulance_data as $ambu){
            foreach($date_range as $range){           

                $args = array('from_date' => date('Y-m-d', strtotime($range)),
                    'to_date' => date('Y-m-d', strtotime($range)),
                    'amb_rto_register_no'=>$ambu->amb_rto_register_no,
                    'base_month' => $base_month);
                    
                $report_data = $this->ambmain_model->get_Patient_served_count_ambulancewise($args);
                //var_dump($report_data);die;
                
                if(!empty($report_data)){
                        $ambulance_patient_servered[$ambu->amb_rto_register_no][$range]=$report_data->total_count;
                }else{
                    $ambulance_patient_servered[$ambu->amb_rto_register_no][$range]=0;
                }


            }
        }


         $main_file_name = strtotime($post_reports['from_date']);
         $filename = "Patientserved_day" . $main_file_name . ".csv";
         $this->output->set_focus_to = "inc_ref_id";
         if ($post_reports['reports'] == 'view') {

             $data['header'] = $header;
             $data['data'] = $report_data;
             $data['patient_servered'] =$ambulance_patient_servered;
             $data['report_args'] = $report_args;
             $data['submit_function'] = 'patient_served_report_days';
             $this->output->add_to_position($this->load->view('frontend/erc_reports/patientserved_days_report_view', $data, TRUE), 'list_table', TRUE);
         } else {

             $filename = "ambulance_patinetserved_report.csv";
             $fp = fopen('php://output', 'w');
             header('Content-type: application/csv');
             header('Content-Disposition: attachment; filename=' . $filename);
             fputcsv($fp, $header);

             $count = 1;

            foreach ($ambulance_patient_servered as $key=>$reportdata){ 

                $data = array(
                     'Sr.No' => $count,
                     'Ambulance No' => $key  
                );
                foreach($reportdata as $key_d=>$report){
                    $data[$key_d] = $report;
                }


                 fputcsv($fp, $data);
                 $count++;

            }

//             foreach ($report_data as $row) {
//                 
//                 $data = array(
//                     'Sr.No' => $count,
//                     'Ambulance No' => $row->amb_rto_register_no,
//                     'Assign count' => $row->total_count
//                     
//                 );
//                 fputcsv($fp, $data);
//                 $count++;
//             }

             fclose($fp);
             exit;
         }
    }
    else{
        
     foreach($ambulance_data as $ambu){
        foreach($date_range as $range){           

            $args = array('from_date' => date('Y-m-d', strtotime($range)),
                'to_date' => date('Y-m-d', strtotime($range)),
                'amb_rto_register_no'=>$ambu->amb_rto_register_no,
                'base_month' => $base_month);
//var_dump($args);die;
           // $report_data = $this->ambmain_model->get_Patient_served_count_ambulancewise($args);
            $report_data= $this->ambmain_model->get_total_call_count($args);
            //var_dump($report_data);die();
            if(!empty($report_data)){
                    $ambulance_patient_servered[$ambu->amb_rto_register_no][$range]=$report_data->total_count;
            }else{
                $ambulance_patient_servered[$ambu->amb_rto_register_no][$range]=0;
            }

        
        }
    }
   //var_dump($ambulance_patient_servered);

     $main_file_name = strtotime($post_reports['from_date']);
     $filename = "Patient_assign_day" . $main_file_name . ".csv";
     $this->output->set_focus_to = "inc_ref_id";
     if ($post_reports['reports'] == 'view') {

         $data['header'] = $header;
         $data['data'] = $report_data;
         $data['patient_servered'] =$ambulance_patient_servered;
         $data['report_args'] = $report_args;
         $data['submit_function'] = 'patient_served_report_days';
         $this->output->add_to_position($this->load->view('frontend/erc_reports/patientserved_days_report_view', $data, TRUE), 'list_table', TRUE);
     } else {
        
         $filename = "ambulance_patinetserved_report.csv";
         $fp = fopen('php://output', 'w');
         header('Content-type: application/csv');
         header('Content-Disposition: attachment; filename=' . $filename);
         fputcsv($fp, $header);

         $count = 1;
         
        foreach ($ambulance_patient_servered as $key=>$reportdata){ 
            
            $data = array(
                 'Sr.No' => $count,
                 'Ambulance No' => $key  
            );
            foreach($reportdata as $key_d=>$report){
                $data[$key_d] = $report;
            }
            
             fputcsv($fp, $data);
             $count++;
              
        }

//             foreach ($report_data as $row) {
//                 
//                 $data = array(
//                     'Sr.No' => $count,
//                     'Ambulance No' => $row->amb_rto_register_no,
//                     'Assign count' => $row->total_count
//                     
//                 );
//                 fputcsv($fp, $data);
//                 $count++;
//             }

         fclose($fp);
         exit;
        }
        
    }
}
function load_datafilter_disclo_summary(){
    //$post_reports = $this->input->post();
    $report_type = $this->input->post('disclo_summary_report_type');

    $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "save_export_tans_patient";
            $data['dist'] = $this->input->post('disclo_report_type_dist');
    $data['divs'] = $this->input->post('disclo_report_type_divs');
            //var_dump($data);die();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/disclo_summary_report', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }else{
            $this->output->add_to_position('', 'Sub_report_block_fields', TRUE);
            
        }
        /*if ($report_type === '2') {
            $data['submit_function'] = "save_export_tans_patient";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_onroad_offroad_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }
        if ($report_type === '3') {
            $data['submit_function'] = "save_export_tans_patient";
            //$this->output->add_to_position($this->load->view('frontend/erc_reports/amb_onroad_offroad_view1', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position($this->load->view('frontend/erc_reports/amb_onroad_offroad_view1_new', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }*/
}
function load_onroad_offroad_form() {
        $data['dist'] = $this->input->post('onroad_report_type_dist');
        $data['divs'] = $this->input->post('onroad_report_type_divs');
        $report_type = $this->input->post('onroad_report_type');
        
        $data = array();
        if ($report_type === '1') {
            //var_dump($data['dist']);die();
            $data['submit_function'] = "save_export_tans_patient";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_onroad_offroad_details_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }
        if ($report_type === '2') {
            $data['submit_function'] = "save_export_tans_patient";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_onroad_offroad_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }
        if ($report_type === '3') {
            $data['submit_function'] = "save_export_tans_patient";
            //$this->output->add_to_position($this->load->view('frontend/erc_reports/amb_onroad_offroad_view1', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position($this->load->view('frontend/erc_reports/amb_onroad_offroad_view1_new', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }
    }

     function load_inspection_details() {
        $data['dist'] = $this->input->post('onroad_report_type_dist');
        $data['divs'] = $this->input->post('onroad_report_type_divs');
        $report_type = $this->input->post('onroad_report_type');
        
        $data = array();
        if ($report_type === '1') {
            // var_dump($data['dist']);die();
            $data['submit_function'] = "save_export_tans_patient";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/insp_details_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }
        if ($report_type === '2') {
            $data['submit_function'] = "save_export_tans_patient";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/griv_details_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }
    }

    function insp_details_report_form(){
        $report_type = $this->input->post('offroad_report_type');
        
        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "save_export_inspection_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_insp_details_report_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "save_export_grivience_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_insp_details_report_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        
        // if ($report_type === '3') {
        //     $data['submit_function'] = "save_export_onroad_offroad";
        //     $data['district_data'] = $this->common_model->get_district();
        //     $this->output->add_to_position($this->load->view('frontend/erc_reports/district_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        // }
    }

    function griv_details_report_form(){
        $report_type = $this->input->post('offroad_report_type');
        
        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "save_export_grivience_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_griev_details_report_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "save_export_grivience_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_griev_details_report_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        
        // if ($report_type === '3') {
        //     $data['submit_function'] = "save_export_onroad_offroad";
        //     $data['district_data'] = $this->common_model->get_district();
        //     $this->output->add_to_position($this->load->view('frontend/erc_reports/district_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        // }
    }


    function save_export_onroad_offroad_new(){
        $post_reports = $this->input->post();
        $data['dist'] = $this->input->post('onroad_report_type_dist');
        $data['divs'] = $this->input->post('onroad_report_type_divs');
        $report_type = $this->input->post('onroad_report_type');
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        //var_dump($post_reports['from_date']);die();
        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;
        $report_args = array(
                //'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $post_reports['base_month'],
               // 'system' => $post_reports['system'],
                'dist' => $post_reports['onroad_report_type_dist'],
                'zone' => $post_reports['onroad_report_type_divs'],
                'report_type' => $post_reports['onroad_report_type'],
                'datewise' => $post_reports['offroad_report_type']
            );
        $general_offroad = $this->ambmain_model->get_onoff_data_only($report_args);//ems_amb_onroad_offroad
        $accidental = $this->ambmain_model->get_accidental_data_only($report_args);//ems_amb_accidental_maintaince
        $preventive = $this->ambmain_model->get_preventive_data_only($report_args);//ems_ambulance_preventive_maintaince
        $tyre = $this->ambmain_model->get_tyre_data_only($report_args);//ems_amb_tyre_maintaince
        $breakdown = $this->ambmain_model->get_breakdown_data_only($report_args);//ems_amb_breakdown_maintaince
        $manpower = $this->ambmain_model->get_manpower_data_only($report_args);//ems_manpower_offroad
       
        $header = array('Sr.No','Request ID','Zone','District','Base Location', 'Ambulance Number','Ambulance Model' , 'Ambulance Type','Off Road DateTime', 'Exp. On-Road Date','Ambulance Offroad Day','Request Status','Off Road Type','Off-Road Remark','General Offroad Reason','On OffRoad Reason','On road Datetime','On road Remark','Added By','Ambulance Status','Fleet remark if any');

        $main_file_name = strtotime($post_reports['from_date']);
        $filename = "maintenance_" . $main_file_name . ".csv";
        $this->output->set_focus_to = "inc_ref_id";
        if ($post_reports['reports'] == 'view') {

            $data['header'] = $header;
            $data['general_offroad_re'] = $general_offroad;
            $data['accidental_data_re'] = $accidental;
            $data['preventive_data_re'] = $preventive;
            $data['tyre_data_re'] = $tyre;
            $data['breakdown_data_re'] = $breakdown;
            $data['manpower_data_re'] = $manpower;
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'save_export_onroad_offroad';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_onroad_offroad_view', $data, TRUE), 'list_table', TRUE);
        } else {
            //var_dump("hii");die();
            $filename = "onroad_offroad_report_form.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $count = 1;

            foreach ($general_offroad as $row) {
                if($row->mt_district_id!= ' '){
                    $current_district = get_district_by_id($row->mt_district_id);
                }
                if($row->amb_type != '' || $row->amb_type != 0 ){ 
                    $amb_type =  show_amb_type_name($row->amb_type);
                }
                $amb_model =  show_amb_model_name($row->mt_amb_no);
                //$amb_status =  show_amb_staus($main_data->mt_amb_no);
                if($row->amb_status == '1' || $row->amb_status=='2'){
                    $amb_status = 'On-Road';
                }else{
                    $amb_status = 'Off-Road';
                }
                $start_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->mt_offroad_datetime)));  
                if($row->mt_offroad_datetime!='' && $row->mt_offroad_datetime != '1970-01-01 05:30:00' && $row->mt_offroad_datetime != '0000-00-00 00:00:00'){
                if($row->mt_onroad_datetime != '' && $row->mt_onroad_datetime != '1970-01-01 05:30:00' && $row->mt_onroad_datetime != '0000-00-00 00:00:00'){
                    $end_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->mt_onroad_datetime))); 
                }else{
                    $end_date = new DateTime(date('Y-m-d H:i:s')); 
                }
                $duration = '0';
                if(strtotime($row->mt_offroad_datetime) < strtotime($row->mt_onroad_datetime)){
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }else{
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }
            }else{
                $duration = '0';
            }
            
                $added_by_name = $row->first_name." ".$row->mid_name." ". $row->last_name;
                $data = array(
                    'Sr.No' => $count,
                    'mt_onoffroad_id' => $row->mt_onoffroad_id,
                    'div_name' => $row->div_name,
                    'current_district' => $current_district,
                    'mt_base_loc' => $row->mt_base_loc,
                    'mt_amb_no' => $row->mt_amb_no,
                    'amb_model' => $amb_model,
                    'amb_type' => $amb_type,
                    'mt_offroad_datetime' => $row->mt_offroad_datetime,
                    'mt_ex_onroad_datetime' => $row->mt_ex_onroad_datetime,
                    'duration' => $duration,
                    'mt_ambulance_status' => $row->mt_ambulance_status,
                    'General' => 'General Offroad',
                    'mt_remark' => $row->mt_remark,
                    'mt_offroad_reason' => $row->mt_offroad_reason,
                    'mt_other_offroad_reason' => $row->mt_other_offroad_reason,
                    'mt_onroad_datetime' => $row->mt_onroad_datetime,
                    'mt_on_remark' => $row->mt_on_remark,
                    'added_by_name' => $added_by_name,
                    'amb_status' => $amb_status,
                    // 'mt_stnd_remark' => $row->mt_stnd_remark,
                    'mt_stnd_remark' => $row->remark_after_approval,
                );
                fputcsv($fp, $data);
                $count++;
            }
            foreach ($accidental as $row) {
                if($row->mt_district_id!= ' '){
                    $current_district = get_district_by_id($row->mt_district_id);
                }
                if($row->amb_type != '' || $row->amb_type != 0 ){ 
                    $amb_type =  show_amb_type_name($row->amb_type);
                }
                $amb_model =  show_amb_model_name($row->mt_amb_no);
                //$amb_status =  show_amb_staus($main_data->mt_amb_no);
                if($row->amb_status == '1' || $row->amb_status=='2'){
                    $amb_status = 'On-Road';
                }else{
                    $amb_status = 'Off-Road';
                }
                if($row->mt_offroad_datetime!='' && $row->mt_offroad_datetime != '1970-01-01 05:30:00' && $row->mt_offroad_datetime != '0000-00-00 00:00:00'){
                $start_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->mt_offroad_datetime)));  
                if($row->mt_onroad_datetime != '' && $row->mt_onroad_datetime != '1970-01-01 05:30:00' && $row->mt_onroad_datetime != '0000-00-00 00:00:00'){
                    $end_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->mt_onroad_datetime))); 
                }else{
                    $end_date = new DateTime(date('Y-m-d H:i:s')); 
                }
                $duration = '0';
                if(strtotime($row->mt_offroad_datetime) < strtotime($row->mt_onroad_datetime)){
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }else{
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }}else{
                    $duration = '0';
                }
                $mt_other_offroad_reason="";
                $added_by_name = $row->first_name." ".$row->mid_name." ". $row->last_name;
                $data = array(
                    'Sr.No' => $count,
                    'mt_onoffroad_id' => $row->mt_accidental_id,
                    'div_name' => $row->div_name,
                    'current_district' => $current_district,
                    'mt_base_loc' => $row->mt_base_loc,
                    'mt_amb_no' => $row->mt_amb_no,
                    'amb_model' => $amb_model,
                    'amb_type' => $amb_type,
                    'mt_offroad_datetime' => $row->mt_offroad_datetime,
                    'mt_ex_onroad_datetime' => $row->mt_ex_onroad_datetime,
                    'duration' => $duration,
                    'mt_ambulance_status' => $row->mt_ambulance_status,
                    'General' => 'Accidental Offroad',
                    'mt_remark' => $row->mt_remark,
                    'mt_offroad_reason' => $row->mt_offroad_reason,
                    'mt_other_offroad_reason' => $mt_other_offroad_reason,
                    'mt_onroad_datetime' => $row->mt_onroad_datetime,
                    'mt_on_remark' => $row->mt_on_remark,
                    'added_by_name' => $added_by_name,
                    'amb_status' => $amb_status,
                    // 'mt_stnd_remark' => $row->mt_stnd_remark,
                    'mt_stnd_remark' => $row->remark_after_approval,

                );
                fputcsv($fp, $data);
                $count++;
            }
            foreach ($preventive as $row) {
                if($row->mt_district_id!= ' '){
                    $current_district = get_district_by_id($row->mt_district_id);
                }
                if($row->amb_type != '' || $row->amb_type != 0 ){ 
                    $amb_type =  show_amb_type_name($row->amb_type);
                }
                $amb_model =  show_amb_model_name($row->mt_amb_no);
                //$amb_status =  show_amb_staus($main_data->mt_amb_no);
                if($row->amb_status == '1' || $row->amb_status=='2'){
                    $amb_status = 'On-Road';
                }else{
                    $amb_status = 'Off-Road';
                }
                $start_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->mt_offroad_datetime)));  
                if($row->mt_offroad_datetime!='' && $main_drowata->mt_offroad_datetime != '1970-01-01 05:30:00' && $row->mt_offroad_datetime != '0000-00-00 00:00:00'){
                if($row->mt_onroad_datetime != '' && $row->mt_onroad_datetime != '1970-01-01 05:30:00' && $row->mt_onroad_datetime != '0000-00-00 00:00:00'){
                    $end_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->mt_onroad_datetime))); 
                }else{
                    $end_date = new DateTime(date('Y-m-d H:i:s')); 
                }
                $duration = '0';
                if(strtotime($row->mt_offroad_datetime) < strtotime($row->mt_onroad_datetime)){
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }else{
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }}else{
                    $duration = '0';
                }
                $mt_other_offroad_reason="";
                $added_by_name = $row->first_name." ".$row->mid_name." ". $row->last_name;
                $data = array(
                    'Sr.No' => $count,
                    'mt_onoffroad_id' => $row->mt_preventive_id,
                    'div_name' => $row->div_name,
                    'current_district' => $current_district,
                    'mt_base_loc' => $row->mt_base_loc,
                    'mt_amb_no' => $row->mt_amb_no,
                    'amb_model' => $amb_model,
                    'amb_type' => $amb_type,
                    'mt_offroad_datetime' => $row->mt_offroad_datetime,
                    'mt_ex_onroad_datetime' => $row->mt_ex_onroad_datetime,
                    'duration' => $duration,
                    'mt_ambulance_status' => $row->mt_ambulance_status,
                    'General' => 'Schedule Offroad',
                    'mt_remark' => $row->mt_remark,
                    'mt_offroad_reason' => $row->mt_offroad_reason,
                    'mt_other_offroad_reason' => $mt_other_offroad_reason,
                    'mt_onroad_datetime' => $row->mt_onroad_datetime,
                    'mt_on_remark' => $row->mt_on_remark,
                    'added_by_name' => $added_by_name,
                    'amb_status' => $amb_status,
                    // 'mt_stnd_remark' => $row->mt_stnd_remark,
                    'mt_stnd_remark' => $row->remark_after_approval,

                );
                fputcsv($fp, $data);
                $count++;
            }
            foreach ($tyre as $row) {
                if($row->mt_district_id!= ' '){
                    $current_district = get_district_by_id($row->mt_district_id);
                }
                if($row->amb_type != '' || $row->amb_type != 0 ){ 
                    $amb_type =  show_amb_type_name($row->amb_type);
                }
                $amb_model =  show_amb_model_name($row->mt_amb_no);
                //$amb_status =  show_amb_staus($main_data->mt_amb_no);
                if($row->amb_status == '1' || $row->amb_status=='2'){
                    $amb_status = 'On-Road';
                }else{
                    $amb_status = 'Off-Road';
                }
                $start_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->mt_offroad_datetime)));  
                if($row->mt_offroad_datetime!='' && $row->mt_offroad_datetime != '1970-01-01 05:30:00' && $row->mt_offroad_datetime != '0000-00-00 00:00:00'){
                if($row->mt_onroad_datetime != '' && $row->mt_onroad_datetime != '1970-01-01 05:30:00' && $row->mt_onroad_datetime != '0000-00-00 00:00:00'){
                    $end_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->mt_onroad_datetime))); 
                }else{
                    $end_date = new DateTime(date('Y-m-d H:i:s')); 
                }
                $duration = '0';
                if(strtotime($row->mt_offroad_datetime) < strtotime($row->mt_onroad_datetime)){
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }else{
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }}else{
                    $duration = '0';
                }
                $mt_other_offroad_reason="";
                $added_by_name = $row->first_name." ".$row->mid_name." ". $row->last_name;
                $data = array(
                    'Sr.No' => $count,
                    'mt_onoffroad_id' => $row->mt_tyre_id,
                    'div_name' => $row->div_name,
                    'current_district' => $current_district,
                    'mt_base_loc' => $row->mt_base_loc,
                    'mt_amb_no' => $row->mt_amb_no,
                    'amb_model' => $amb_model,
                    'amb_type' => $amb_type,
                    'mt_offroad_datetime' => $row->mt_offroad_datetime,
                    'mt_ex_onroad_datetime' => $row->mt_ex_onroad_datetime,
                    'duration' => $duration,
                    'mt_ambulance_status' => $row->mt_ambulance_status,
                    'General' => 'Tyre Offroad',
                    'mt_remark' => $row->mt_remark,
                    'mt_offroad_reason' => $row->mt_offroad_reason,
                    'mt_other_offroad_reason' => $mt_other_offroad_reason,
                    'mt_onroad_datetime' => $row->mt_onroad_datetime,
                    'mt_on_remark' => $row->mt_on_remark,
                    'added_by_name' => $added_by_name,
                    'amb_status' => $amb_status,
                    // 'mt_stnd_remark' => $row->mt_stnd_remark,
                    'mt_stnd_remark' => $row->remark_after_approval,

                );
                fputcsv($fp, $data);
                $count++;
            }
            foreach ($breakdown as $row) {
                if($row->mt_district_id!= ' '){
                    $current_district = get_district_by_id($row->mt_district_id);
                }
                if($row->amb_type != '' || $row->amb_type != 0 ){ 
                    $amb_type =  show_amb_type_name($row->amb_type);
                }
                $amb_model =  show_amb_model_name($row->mt_amb_no);
                //$amb_status =  show_amb_staus($main_data->mt_amb_no);
                if($row->amb_status == '1' || $row->amb_status=='2'){
                    $amb_status = 'On-Road';
                }else{
                    $amb_status = 'Off-Road';
                }
                $start_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->mt_offroad_datetime)));  
                if($row->mt_offroad_datetime!='' && $row->mt_offroad_datetime != '1970-01-01 05:30:00' && $row->mt_offroad_datetime != '0000-00-00 00:00:00'){
                if($row->mt_onroad_datetime != '' && $row->mt_onroad_datetime != '1970-01-01 05:30:00' && $row->mt_onroad_datetime != '0000-00-00 00:00:00'){
                    $end_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->mt_onroad_datetime))); 
                }else{
                    $end_date = new DateTime(date('Y-m-d H:i:s')); 
                }
                $duration = '0';
                if(strtotime($row->mt_offroad_datetime) < strtotime($row->mt_onroad_datetime)){
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }else{
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }}else{
                    $duration = '0';
                }
                $mt_other_offroad_reason="";
                $added_by_name = $row->first_name." ".$row->mid_name." ". $row->last_name;
                $data = array(
                    'Sr.No' => $count,
                    'mt_onoffroad_id' => $row->mt_breakdown_id,
                    'div_name' => $row->div_name,
                    'current_district' => $current_district,
                    'mt_base_loc' => $row->mt_base_loc,
                    'mt_amb_no' => $row->mt_amb_no,
                    'amb_model' => $amb_model,
                    'amb_type' => $amb_type,
                    'mt_offroad_datetime' => $row->mt_offroad_datetime,
                    'mt_ex_onroad_datetime' => $row->mt_ex_onroad_datetime,
                    'duration' => $duration,
                    'mt_ambulance_status' => $row->mt_ambulance_status,
                    'General' => 'Breakdown Offroad',
                    'mt_remark' => $row->mt_remark,
                    'mt_offroad_reason' => $row->mt_offroad_reason,
                    'mt_other_offroad_reason' => $mt_other_offroad_reason,
                    'mt_onroad_datetime' => $row->mt_onroad_datetime,
                    'mt_on_remark' => $row->mt_on_remark,
                    'added_by_name' => $added_by_name,
                    'amb_status' => $amb_status,
                    // 'mt_stnd_remark' => $row->mt_stnd_remark,
                    'mt_stnd_remark' => $row->remark_after_approval,

                );
                fputcsv($fp, $data);
                $count++;
            }
            foreach ($manpower as $row) {
                if($row->mt_district_id!= ' '){
                    $current_district = get_district_by_id($row->mt_district_id);
                }
                if($row->amb_type != '' || $row->amb_type != 0 ){ 
                    $amb_type =  show_amb_type_name($row->amb_type);
                }
                $amb_model =  show_amb_model_name($row->mt_amb_no);
                //$amb_status =  show_amb_staus($main_data->mt_amb_no);
                if($row->amb_status == '1' || $row->amb_status=='2'){
                    $amb_status = 'On-Road';
                }else{
                    $amb_status = 'Off-Road';
                }
                $start_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->mt_offroad_date)));  
                if($row->mt_offroad_date!='' && $row->mt_offroad_date != '1970-01-01 05:30:00' && $row->mt_offroad_date != '0000-00-00 00:00:00'){
                if($row->mt_ex_onroad_datetime != '' && $row->mt_ex_onroad_datetime != '1970-01-01 05:30:00' && $row->mt_ex_onroad_datetime != '0000-00-00 00:00:00'){
                    $end_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->mt_ex_onroad_datetime))); 
                }else{
                    $end_date = new DateTime(date('Y-m-d H:i:s')); 
                }
                $duration = '0';
                if(strtotime($row->mt_offroad_date) < strtotime($row->mt_ex_onroad_datetime)){
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }else{
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }}else{
                    $duration = '0';
                }
                $mt_other_offroad_reason="";
                $added_by_name = $row->first_name." ".$row->mid_name." ". $row->last_name;
                $data = array(
                    'Sr.No' => $count,
                    'mt_onoffroad_id' => $row->mt_manpower_id,
                    'div_name' => $row->div_name,
                    'current_district' => $current_district,
                    'mt_base_loc' => $row->mt_base_loc,
                    'mt_amb_no' => $row->mt_amb_no,
                    'amb_model' => $amb_model,
                    'amb_type' => $amb_type,
                    'mt_offroad_datetime' => $row->mt_offroad_date,
                    'mt_ex_onroad_datetime' => $row->mt_ontime_onroad_date,
                    'duration' => $duration,
                    'mt_ambulance_status' => $row->mt_ambulance_status,
                    'General' => 'Manpower offroad',
                    'mt_remark' => $row->mt_remark,
                    'mt_offroad_reason' => $row->mt_offroad_reason,
                    'mt_other_offroad_reason' => '',
                    'mt_onroad_datetime' => $row->mt_ex_onroad_datetime,
                    'mt_on_remark' => $row->mt_on_remark,
                    'added_by_name' => $added_by_name,
                    'amb_status' => $amb_status,
                    // 'mt_stnd_remark' => $row->mt_stnd_remark,
                    'mt_stnd_remark' => $row->remark_after_approval,

                );
                fputcsv($fp, $data);
                $count++;
            }

            fclose($fp);
            exit; 
        }
    }

    function save_export_inspection_report(){
        $post_reports = $this->input->post();
        $data['dist'] = $this->input->post('onroad_report_type_dist');
        $data['divs'] = $this->input->post('onroad_report_type_divs');
        $report_type = $this->input->post('onroad_report_type');
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        //var_dump($post_reports['from_date']);die();
        $report_args = array(
                'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $post_reports['base_month'],
                'dist' => $post_reports['onroad_report_type_dist'],
                'zone' => $post_reports['onroad_report_type_divs'],
                'report_type' => $post_reports['onroad_report_type'],
                'datewise' => $post_reports['offroad_report_type']
            );
        // $general_offroad = $this->ambmain_model->get_onoff_data_only($report_args);//ems_amb_onroad_offroad
        $general_offroad = $this->inspection_model->get_inspection_data($report_args);//ems_amb_onroad_offroad
        $critical_list = $this->inspection_model->get_critical_type($report_args);
        $major_list = $this->inspection_model->get_major_type($report_args);
        $minor_list = $this->inspection_model->get_minor_type($report_args);
        // print_r($general_offroad);die;
        // echo"<pre>";print_r($general_offroad);die();

        $header = array('Sr.No.',
        'Zone',
        'District',
        'Base Location', 
        'Ambulance Number',
        'Ambulance Model' , 
        'Ambulance Type',
        'Vehicle Current Status', 
        'GPS Device Working',
        'Pilot',
        'EMT',
        'Kilometer Reading (Odometer)',
        'Vehicle Maintenance Date',
        'Maintenance Done on due Date or not',
        'Maintenance Present Status',
        'Maintenance Remark',
        'Amb Cleanliness Maintenance Date',
        'Cleanliness Present Status',
        'Cleanliness Remark',
        'AC Working Status',
        'Not Working From (Date)',
        'AC Maintenance Remark',
        'Tyre Working Status',
        'Not Working From (Date)',
        'Tyre Maintenance Remark',
        'Working Status of Siren',
        'Not Working From (Date)',
        'Siren Maintenance Remark',
        'Inventor Working Status',
        'Not Working From (Date)',
        'Inventor Maintenance Remark',
        'Battery Working Status',
        'Not Working From (Date)',
        'Battery Maintenance Remark',
        'GPS Working Status',
        'Not Working From (Date)',
        'GPS Maintenance Remark',
        'PCR Register Maintenance(Date)',
        'PCR Register Present Status',
        'PCR Register Remark',
        'Attendance Sheet Signature(Date)',
        'Is Attendance Sheet Maintained',
        'Attendance Sheet Present Status',
        'Attendance Sheet Remark',

        'Medicine List',
        'Medicine Stock',
        'Medicine Status',
        'Medicine Available Stock',
        'Medicine Remark',

        // 'Equipment List',
        // 'Equipment Availability Status',
        // 'Equipment Functional Status',
        // 'Equipment Date',
        // 'Equipment Remark',

        'Critical Equipment List',
        'Critical Eqp Availability Status',
        'Critical Eqp Functional Status',
        'Critical Equipment Date',
        'Critical Equipment Remark',

        'Major Equipment List',
        'Major Eqp Availability Status',
        'Major Eqp Functional Status',
        'Major Equipment Date',
        'Major Equipment Remark',

        'Minor Equipment List',
        'Minor Eqp Availability Status',
        'Minor Eqp Functional Status',
        'Minor Equipment Date',
        'Minor Equipment Remark',

        'Added Date Of Inspection',
        'Added by Inspection',

        'Grievance Type',
        'Grievance Related To',
        'Preliminary Inform To', 
        'Details Of Grievance',
        'Added Date Of Grievance',
        'Added by Grievance',
    );

        $main_file_name = strtotime($post_reports['from_date']);
        $filename = "maintenance_" . $main_file_name . ".csv";
        $this->output->set_focus_to = "inc_ref_id";
        if ($post_reports['reports'] == 'view') {

            $data['header'] = $header;
            $data['general_offroad_re'] = $general_offroad;
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'save_export_inspection_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_insp_details_view', $data, TRUE), 'list_table', TRUE);
        } else {
        
            $filename = "export_inspection_report.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);
            // print_r($critical_list);die;

            $count = 1;
            
            foreach ($general_offroad as $row) {
                // print_r($row);die;
                // print_r($critical_list['eqp_name']);die;
                if($row->prilimnari_inform =='1'){
                    $prilimnari_inform = 'Manager';
                }  
                // if($row->ins_amb_current_status == '1' || $row->ins_amb_current_status == '2'){
                //     $ins_amb_current_status = 'On-Road';
                // }else{
                //     $ins_amb_current_status = 'Off-Road';
                // }
                if($row->status == 'Available' || $row->status == 'Not_Available'){
                    $status = 'Available';
                }else{
                    $status = 'Not Available';
                }
               
                $start_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->added_date)));  
                if($row->added_date!='' && $row->added_date != '1970-01-01 05:30:00' && $row->added_date != '0000-00-00 00:00:00'){
                if($row->added_date != '' && $row->added_date != '1970-01-01 05:30:00' && $row->added_date != '0000-00-00 00:00:00'){
                    $end_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->added_date))); 
                }else{
                    $end_date = new DateTime(date('Y-m-d H:i:s')); 
                }
                $duration = '0';

                if(strtotime($row->added_date) < strtotime($row->added_date)){
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }else{
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }
            }else{
                $duration = '0';
            }
            if($row->ins_main_date == "0000-00-00 00:00:00"){
                $insdate="-";
            }else{
                $insdate=$row->ins_main_date;
            }
            if($row->ins_clean_date == "0000-00-00 00:00:00"){
                $cleandate="-";
            }else{
                $cleandate=$row->ins_clean_date;
            }
            if($row->ac_working_date == "0000-00-00 00:00:00"){
                $acdate="-";
            }else{
                $acdate=$row->ac_working_date;
            }
            if($row->tyre_working_date == "0000-00-00 00:00:00"){
                $tyredate="-";
            }else{
                $tyredate=$row->tyre_working_date;
            }
            if($row->siren_working_date == "0000-00-00 00:00:00"){
                $sirendate="-";
            }else{
                $sirendate=$row->siren_working_date;
            }
            if($row->inv_working_date == "0000-00-00 00:00:00"){
                $invdate="-";
            }else{
                $invdate=$row->inv_working_date;
            }
            if($row->batt_working_date == "0000-00-00 00:00:00"){
                $batdate="-";
            }else{
                $batdate=$row->batt_working_date;
            }
            if($row->gps_working_date == "0000-00-00 00:00:00"){
                $gpsdate="-";
            }else{
                $gpsdate=$row->gps_working_date;
            }
            if($row->ins_pcs_stock_date == "0000-00-00"){
                $pcrdate="-";
            }else{
                $pcrdate=$row->ins_pcs_stock_date;
            }
            if($row->ins_sign_attnd_date == "0000-00-00"){
                $sindate="-";
            }else{
                $sindate=$row->ins_sign_attnd_date;
            }
           
            if($critical_list->date_from == "0000-00-00"){
                $cridate="-";
            }else{
                $cridate=$critical_list->date_from;
            }
            if($major_list->date_from == "0000-00-00"){
                $majdate="-";
            }else{
                $majdate=$major_list->date_from;
            }
            if($minor_list->date_from == "0000-00-00"){
                $mindate="-";
            }else{
                $mindate=$minor_list->date_from;
            }
            $added_by_inspection = $row->ins_first_name." ".$row->ins_mid_name." ". $row->ins_last_name;
            $added_by_grievance = $row->gri_first_name." ".$row->gri_mid_name." ". $row->gri_last_name;
            
            // $cri_data = array();
            // foreach ($critical_list as $key=>$row1) { 
            //     $critical = array(
            //     'cri_eqp_name'=> $row1->eqp_name,
            //     'cri_status'=> $row1->status,
            //     'cri_oprational'=> $row1->oprational,
            //     'cri_date_from'=> $row1->date_from,
            //     'cri_remark'=> $row1->eqp_critical_remark
            //     );
            //     array_push($cri_data,$critical);
            // }
            // $critical = json_encode($cri_data);
          
            // $cri_data = array();
            // for ( $i=0;$i<=5;$i++) { 
            //     print_r($critical_list[$i]);die;
            //   }
            //     $cri_data[] = $row1;
            //    }
              
                $data = array(
                    'Sr.No' => $count,
                    'div_name' => $row->div_name,
                    'dst_name' => $row->dst_name,
                    'ins_baselocation' => $row->ins_baselocation,
                    'ins_amb_no' => $row->ins_amb_no,
                    'ins_amb_model' => $row->ins_amb_model,
                    'amb_type_on' => $row->amb_type_on,
                    'ins_amb_current_status' => $row->ins_amb_current_status,
                    'ins_gps_status' => $row->ins_gps_status,
                    'ins_pilot' => $row->ins_pilot,
                    'ins_emso' => $row->ins_emso,
                    'ins_odometer' => $row->ins_odometer,
                    'ins_main_date'=> $insdate,
                    'ins_main_due_status'=> $row->ins_main_due_status,
                    'ins_main_status'=> $row->ins_main_status,
                    'ins_main_remark'=> $row->ins_main_remark,
                    'ins_clean_date'=> $cleandate,
                    'ins_clean_status'=> $row->ins_clean_status,
                    'ins_clean_remark'=> $row->ins_clean_remark,
                    'ac_status'=> $row->ac_status,
                    'ac_working_date'=> $acdate,
                    'ac_remark'=> $row->ac_remark,

                    'tyre_status'=> $row->tyre_status,
                    'tyre_working_date'=> $tyredate,
                    'tyre_remark'=> $row->tyre_remark,

                    'siren_status'=> $row->siren_status,
                    'siren_working_date'=> $sirendate,
                    'siren_remark'=> $row->siren_remark,
                    'siren_status'=> $row->siren_status,
                    
                    'inv_status'=> $row->inv_status,
                    'inv_working_date'=> $invdate,
                    'inv_remark'=> $row->inv_remark,

                    'batt_status'=> $row->batt_status,
                    'batt_working_date'=> $batdate,
                    'batt_remark'=> $row->batt_remark,

                    'gps_status'=> $row->gps_status,
                    'gps_working_date'=> $gpsdate,
                    'gps_remark'=> $row->gps_remark,

                    'ins_pcs_stock_date'=> $pcrdate,
                    'ins_pcs_stock_status'=> $row->ins_pcs_stock_status,
                    'ins_pcs_stock_remark'=> $row->ins_pcs_stock_remark,

                    'ins_sign_attnd_date'=> $sindate,
                    'ins_sign_attnd_due_status'=> $row->ins_sign_attnd_due_status,
                    'ins_sign_attnd_status'=> $row->ins_sign_attnd_status,
                    'ins_sign_attnd_remark'=> $row->ins_sign_attnd_remark,

                    'med_title'=> $row->med_title,              
                    'exp_stock'=> $row->exp_stock,
                    'med_status'=> $row->med_status,
                    'med_qty'=> $row->med_qty,
                    'med_Remark'=> $row->med_Remark, 

                    // 'critical_equp' => $critical,
                    'cri_eqp_name'=> $critical_list[0]->eqp_name,
                    'cri_status'=> $critical_list[0]->status,
                    'cri_oprational'=> $critical_list[0]->oprational,
                    'cri_date_from'=> $critical_list[0]->cridate,
                    'cri_remark'=> $row->eqp_critical_remark, 

                    'maj_eqp_name'=> $major_list[0]->eqp_name,
                    'maj_status'=> $major_list[0]->status,
                    'maj_oprational'=> $major_list[0]->oprational,
                    'maj_date_from'=>$major_list[0]->majdate,
                    'maj_remark'=> $row->eqp_major_remark, 

                    'min_eqp_name'=>$minor_list[0]->eqp_name,
                    'min_status'=>$minor_list[0]->status,
                    'min_oprational'=>$minor_list[0]->oprational,
                    'min_date_from'=>$minor_list[0]->mindate,
                    'min_remark'=> $row->eqp_major_remark, 

                    'added_date'=> $row->added_date, 
                    'added_by_inspection'=> $added_by_inspection,

                    'griv_name ' => $row->griv_name ,
                    'gri_sub_type' => $row->gri_sub_type,
                    'prilimnari_inform' => $prilimnari_inform,  
                    'griv_remark' => $row->griv_remark,  
                    'griv_date' => $row->griv_date,  
                    'added_by_grievance' => $added_by_grievance,  
                );
                
                fputcsv($fp, $data);
                $count++;
            // }
            }
            fclose($fp);
            exit; 
        }
    }

    function save_export_grivience_report(){
        $post_reports = $this->input->post();
        $data['dist'] = $this->input->post('onroad_report_type_dist');
        $data['divs'] = $this->input->post('onroad_report_type_divs');
        $report_type = $this->input->post('onroad_report_type');
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        //var_dump($post_reports['from_date']);die();
        // $base_month = $this->common_model->get_base_month($from_date);
        // $this->post['base_month'] = $base_month[0]->months;
        $report_args = array(
                'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                // 'base_month' => $this->post['base_month'],
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $post_reports['base_month'],
               // 'system' => $post_reports['system'],
                'dist' => $post_reports['onroad_report_type_dist'],
                'zone' => $post_reports['onroad_report_type_divs'],
                'report_type' => $post_reports['onroad_report_type'],
                'datewise' => $post_reports['offroad_report_type']
            );
        // $general_offroad = $this->ambmain_model->get_onoff_data_only($report_args);//ems_amb_onroad_offroad
        $general_offroad = $this->grievance_model->get_grivience_data($report_args);//ems_amb_onroad_offroad
        // echo"<pre>";print_r($general_offroad);die();
        $header = array('Sr.No',
        'Grievance Type',
        'Grievance Related To',
        'Preliminary Inform To', 
        'Details Of Grievance',
        'Added Date',
        'Added By',
    );

        $main_file_name = strtotime($post_reports['from_date']);
        $filename = "maintenance_" . $main_file_name . ".csv";
        $this->output->set_focus_to = "inc_ref_id";
        if ($post_reports['reports'] == 'view') {

            $data['header'] = $header;
            $data['general_offroad_re'] = $general_offroad;
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'save_export_grivience_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_griv_details_view', $data, TRUE), 'list_table', TRUE);
        } else {
            // var_dump("hii");die();
            $filename = "export_Grievance_report.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $count = 1;

            foreach ($general_offroad as $row) {
                if($row->prilimnari_inform =='1'){
                    $prilimnari_inform = 'Manager';
                }          
                $start_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->added_date)));  
                if($row->added_date!='' && $row->added_date != '1970-01-01 05:30:00' && $row->added_date != '0000-00-00 00:00:00'){
                if($row->added_date != '' && $row->added_date != '1970-01-01 05:30:00' && $row->added_date != '0000-00-00 00:00:00'){
                    $end_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->added_date))); 
                }else{
                    $end_date = new DateTime(date('Y-m-d H:i:s')); 
                }
                $duration = '0';

                if(strtotime($row->mt_offroad_datetime) < strtotime($row->added_date)){
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }else{
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }
            }else{
                $duration = '0';
            }

                $data = array(
                    'Sr.No' => $count,
                    'griv_name ' => $row->griv_name ,
                    'gri_sub_type' => $row->gri_sub_type,
                    'prilimnari_inform' => $prilimnari_inform,  
                    'remark' => $row->remark,  
                    'added_date' => $row->added_date,
                    'full_clg_name' => $row->clg_first_name. ' '.$row->clg_mid_name. ' '.$row->clg_last_name,
                   
                );
                fputcsv($fp, $data);
                $count++;
            }
            fclose($fp);
            exit; 
        }
    }

    function amb_onroad_report_form1_new(){
        $report_type = $this->input->post('offroad_report_type');
        
        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "save_export_onroad_offroad_new";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view_new', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "save_export_onroad_offroad";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        
        if ($report_type === '3') {
            $data['submit_function'] = "save_export_onroad_offroad";
            $data['district_data'] = $this->common_model->get_district();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/district_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
    }
    function amb_onroad_report_form() {
        

        $report_type = $this->input->post('offroad_report_type');

        
        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "amb_district_onroad_offroad_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "amb_district_onroad_offroad_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        
        if ($report_type === '3') {
            $data['submit_function'] = "amb_district_onroad_offroad_report";
            $data['district_data'] = $this->common_model->get_district();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/district_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
    }

    function amb_onroad_report_form1() {
        

        $report_type = $this->input->post('offroad_report_type');
        
        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "save_export_onroad_offroad";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "save_export_onroad_offroad";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        
        if ($report_type === '3') {
            $data['submit_function'] = "save_export_onroad_offroad";
            $data['district_data'] = $this->common_model->get_district();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/district_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
    }
    function details_summary_report_form(){
        $report_type = $this->input->post('details_report_type');
        $data = array();
        if ($report_type === '1') {
            //$data['submit_function'] = "details_amb_onroad_offroad_report";
            $data['submit_function'] = "details_disclo_summary_report";
            $data['divs'] = $this->input->post('divs');
            $data['dist'] = $this->input->post('dist');
            $this->output->add_to_position($this->load->view('frontend/erc_reports/date_filter_disclo_summary_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }else{
            $this->output->add_to_position('', 'Sub_date_report_block_fields', TRUE);
        }
       /* if ($report_type === '2') {
            $data['submit_function'] = "details_amb_onroad_offroad_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
    
        if ($report_type === '3') {
            $data['submit_function'] = "details_amb_onroad_offroad_report";
            $data['district_data'] = $this->common_model->get_district();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/district_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }*/
    }
    function details_amb_onroad_report_form() {

        $report_type = $this->input->post('details_report_type');
        // var_dump($report_type);die;
        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "details_amb_onroad_offroad_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        
        if ($report_type === '2') {
            $data['submit_function'] = "details_amb_onroad_offroad_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        
        if ($report_type === '3') {
            $data['submit_function'] = "details_amb_onroad_offroad_report";
            $data['district_data'] = $this->common_model->get_district();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/district_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
    }

    function patient_report_form() {
        $report_type = $this->input->post('ptn_report_type');


        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "save_export_tans_patient";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "save_export_tans_patient";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }
    }

    function ercp_report_form() {

        $report_type = $this->input->post('ercp_report_type');

        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "save_export_ercp_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "save_export_ercp_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }
    }
        function availability_hourly_report_form() {

        // $report_type = $this->input->post('ercp_report_type');
 
         $data = array();
        
             $data['submit_function'] = "amb_avail_hourly_report";
             $this->output->add_to_position($this->load->view('frontend/erc_reports/amb_availbility_single_date_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
         
 
     }
    function hourly_report_form() {

        $report_type = $this->input->post('ercp_report_type');

        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "incident_daily_hourly_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/single_date_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "incident_weekly_hourly_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }
    }
    function load_summary_subreport_form() {
    $report_type = $this->input->post('report_type');

   if ($report_type == '1') {
       // $data['submit_function'] = "load_incident_sub_date_report_form";
        $this->output->add_to_position($this->load->view('frontend/erc_reports/summary_sub_report_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        $this->output->add_to_position('', 'Sub_date_report_block_fields', TRUE);
       // $this->output->add_to_position('', 'list_table', TRUE);
    }
    if ($report_type == '2') {
        $data['submit_function'] = "load_date_report_form";
        $this->output->add_to_position($this->load->view('frontend/erc_reports/incident_sub_other_report_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        $this->output->add_to_position('', 'Sub_date_report_block_fields', TRUE);
        $this->output->add_to_position('', 'list_table', TRUE);
    }
  
}
function load_date_report_form(){
    $report_type = $this->input->post('report_type');
    if ($report_type == '1') {
        $data['submit_function'] = "summary_report_details";
        $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view', $data, TRUE), 'Sub_report_block_fields_new', TRUE);
    }
    if ($report_type == '2') {
        $data['submit_function'] = "summary_report_details";
        $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_report_block_fields_new', TRUE);
    }
}
function summary_report_form() {
    $report_type = $this->input->post('date_month');
   // $thirdparty_type = $this->input->post('thirdparty_type');
   // var_dump('hi');die();
    $data = array();
    if ($report_type === '1') {
        $data['submit_function'] = "summary_report";
        $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view', $data, TRUE), 'Sub_report_block_fields_new', TRUE);
        $this->output->add_to_position('', 'list_table', TRUE);
    }
    if ($report_type === '2') {
        $data['submit_function'] = "summary_report";
        $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_report_block_fields_new', TRUE);
        $this->output->add_to_position('', 'list_table', TRUE);
    }
}
function b12_report_form_new(){
    $report_type = $this->input->post('b12_report_type');

        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "b12_type_report_new_format";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "b12_type_report_new_format";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
}
    function b12_report_form() {

        $report_type = $this->input->post('b12_report_type');

        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "b12_type_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "b12_type_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
    }

    function nhm_104_report_form() {

        $report_type = $this->input->post('amb_report_type');
        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "load_nhm_104_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/nhm_104_datewise_all_call_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "load_nhm_104_report_medical";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/nhm_104_datewise_medical_call_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }
    }

    function feedback_report_form() {

        $report_type = $this->input->post('feedback_report_type');

        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "feedback_type_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "feedback_type_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
    }

    function grievance_report_form() {

        $report_type = $this->input->post('grievance_report_type');

        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "grievance_type_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "grievance_type_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
    }
    function load_maintenance_sub_report_form(){
        $report_type = $this->input->post('maintenance_type'); 
        $data['maintenance_type']= $report_type;
       $data['submit_function'] = "load_incident_sub_date_report_form";
        $this->output->add_to_position($this->load->view('frontend/reports/maintenance_sub_report_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        $this->output->add_to_position('', 'Sub_date_report_block_fields', TRUE);
        $this->output->add_to_position('', 'list_table', TRUE);
      
        
    }
    function load_incident_pvt_hos_subreport_form(){
        $report_type = $this->input->post('report_type_name');

        if ($report_type == '1') {
            $data['submit_function'] = "load_incident_pvt_hos_sub_date_report_form";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/incident_sub_report_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_date_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
    }
    function load_incident_subreport_form() {
        $report_type = $this->input->post('report_type_name');

        if ($report_type == '1') {
            $data['submit_function'] = "load_incident_sub_date_report_form";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/incident_sub_report_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_date_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
        if ($report_type == '2') {
            $data['submit_function'] = "load_other_incident_date_report_form";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/incident_sub_other_report_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_date_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
        if ($report_type == '3') {
            $data['submit_function'] = "load_incident_question_answer_report_form";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/incident_sub_report_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_date_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
    }

    /***************************/

    function load_incident_subreport_form1() {
        $report_type = $this->input->post('report_type_name');
        if ($report_type == '1') {
            $data['submit_function'] = "nhm_mis_report_table";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/nhm_mis_report', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        
    }
    function mis_load_incident_subreport_form() {
        $report_type = $this->input->post('report_type_name');
        if ($report_type == '1') {
            $data['submit_function'] = "nhm_mis_report_table";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/nhm_mis_report', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        
    }
    

    /***************** All call format****************/

    function load_incident_subreport_form2() {
        $report_type = $this->input->post('report_type_name');
        if ($report_type == '1') {
            $data['submit_function'] = "all_call_format_table";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/all_call_report', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        
    }


    /****************** Offroad Summary Report ******************/

    function load_offroad_summary_form() {
        $report_type = $this->input->post('report_type_name');
        if ($report_type == '1') {
            $data['submit_function'] = "offroad_summary_report_reasonwise";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/offroad_summary_report', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        if ($report_type == '2') {
            $data['submit_function'] = "offroad_summary_report_zonewise";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/offroad_summary_report', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        if ($report_type == '3') {
            $data['submit_function'] = "offroad_summary_report_districtwise";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/offroad_summary_report', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        if ($report_type == '4') {
            $data['submit_function'] = "offroad_summary_report_total";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/offroad_summary_report', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        
    }

    function load_shift_roster_sub_option_report_form()
    {
        $report_type = $this->input->post('report_type');
        //var_dump($report_type);die;
        if ($report_type == '1') {
            $data['submit_function'] = "shift_roster_report_view";
            $this->output->add_to_position($this->load->view('frontend/reports/export_shiftroster_date_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        if ($report_type == '2') {
            $data['submit_function'] = "shift_roster_report_view";
            $this->output->add_to_position($this->load->view('frontend/reports/export_shiftroster_month_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        if ($report_type == '3') {
            $data['submit_function'] = "shift_roster_report_view";
            $this->output->add_to_position($this->load->view('frontend/reports/export_shiftroster_daily_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
            //$this->output->add_to_position('', 'Sub_date_report_block_fields', TRUE);
           // $this->output->add_to_position('', 'list_table', TRUE);
        }
        
    }
    function load_closure_lat_long_subreport_form(){
        $report_type = $this->input->post('closure_report_type');

        if ($report_type === '1') {
            $data['submit_function'] = "load_closure_lat_long_report";
        }
        $this->output->add_to_position($this->load->view('frontend/erc_reports/closure_sub_report_view', $data, TRUE), 'Sub_report_closure_block_fields', TRUE);
        $this->output->add_to_position('', 'Sub_date_report_block_fields', TRUE);
        $this->output->add_to_position('', 'list_table', TRUE);
    }
    function load_closure_subreport_form() {

        $report_type = $this->input->post('closure_report_type');

        if ($report_type === '1') {
            $data['submit_function'] = "load_closure_report";
        }

        if ($report_type === '2') {
            $data['submit_function'] = "load_response_time_report";
        }

        if ($report_type === '3') {
            $data['submit_function'] = "load_consumable_report";
        }
        if ($report_type === '4') {
            $data['submit_function'] = "load_unavailed_closure_report";
        }
        if ($report_type === '5') {
            $data['submit_function'] = "load_closure_datewise_report";
        }
        if ($report_type === '6') {
            $data['submit_function'] = "load_response_time_closure_datewise_report";
        }
        if ($report_type === '7') {
            $data['submit_function'] = "load_consumable_report_new";
        }
        $this->output->add_to_position($this->load->view('frontend/erc_reports/closure_sub_report_view', $data, TRUE), 'Sub_report_closure_block_fields', TRUE);
        $this->output->add_to_position('', 'Sub_date_report_block_fields', TRUE);
        $this->output->add_to_position('', 'list_table', TRUE);
    }
    function load_response_time_closure_datewise_report(){
        $report_type = $this->input->post('date_report_type');
       // var_dump($report_type);die();
        if ($report_type == '1') {
            $data['submit_function'] = "closure_datewise_response_time_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        if ($report_type == '2') {
            $data['submit_function'] = "closure_datewise_response_time_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
    }
    function closure_datewise_response_time_report(){
       
        $post_reports = $this->input->post();
        
        $track_args = array('trk_report_name'=>'Response Time Report Closure datewise','trk_download_by'=>$this->clg->clg_ref_id);
        track_report_download($track_args);

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        $thirdparty = $this->clg->thirdparty;
        $district = $this->clg->clg_district_id;
        $clg_district_id = json_decode($district);
        if(is_array($clg_district_id)){
            $district_id = implode("','",$clg_district_id);
        }

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
                'thirdparty' => $thirdparty,
                'system' => $post_reports['system'],
                'district' => $district_id );
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                'thirdparty' => $thirdparty,
                'system' => $post_reports['system'],
                'district' => $district_id );
        }


        $report_data = $this->inc_model->get_responsetime_closuredatewise_by_month($report_args);



        $header = array('Incident ID',
        'Incident Date / Time',
        'Closure Date / Time',
        'Ambulance No',
        'Base Location',
        'Call Type',
        'Patient ID',
        'Patient Name',
        'Call Receiving Date / Time',
        'Disconnected Date / Time',
        'Start From Base Date / Time',
        'At Scene',
        'From Scene',
        'At Hospital',
        'Handover Time',
        'Back To Base',
        'Response Time',
        'Response Time Remark',
        'Odometer Difference Remark',
        'Inc. Area Type',
        'Third Party',
        'Operate by',
        'Operate by Name',
        'Added by',
        'Added by Name',
        'Validate by',
        'Validate by Name'

            );

        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            if(is_array($report_data)){
            foreach ($report_data as $row) {
                $inc_data[] = array(
                    'inc_date' => $row['inc_date_time'],
                    'closer_date' => $row['added_date'],
                    'inc_ref_id' => $row['incident_id'],
                    'response_time' => $row['responce_time'],
                    'amb_rto_register_no' => $row['amb_reg_id'],
                    'ptn_id' => $row['ptn_id'],
                    'patient_name' => $row['ptn_fname']." ".$row['ptn_lname'],
                    'operate_by' => $row['operate_by'],
                    'dp_started_base_loc' => $row['dp_started_base_loc'],
                    'dp_on_scene' => $row['dp_on_scene'],
                    'dp_hosp_time' => $row['dp_hosp_time'],
                    'start_from_base' => $row['start_from_base'],
                    'responce_time' => $row['responce_time'],
                    'remark_title' => $row['remark_title'],
                    'dp_hand_time' => $row['dp_hand_time'],
                    'dp_back_to_loc' => $row['dp_back_to_loc'],
                    'dp_cl_from_desk' => $row['dp_cl_from_desk'],
                    'dp_reach_on_scene' => $row['dp_reach_on_scene'],
                    'inc_datetime'=>$row['inc_datetime'],
                    'inc_recive_time'=>$row['inc_recive_time'],
                    'thirdparty'=> $row['thirdparty_name'],
                   
                );
            }
        }
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['submit_function']='closure_datewise_response_time_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/inc_response_time_report_closurewise_view', $data, TRUE), 'list_table', TRUE);
        } else {
           // var_dump($report_data);die();
            $filename = "closure_response_time_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            foreach ($report_data as $row) {
                
               $dp_cl_from_desk= date("H:i:s", strtotime($row['inc_recive_time']));
               $inc_datetime= date("H:i:s", strtotime($row['inc_datetime']));
              
               if($row['inc_date_time'] != NULL){
                $add_date = date('Y-m-d', strtotime($row['inc_date_time']));
                 $add_time = date('H:i:s', strtotime($row['inc_date_time']));
                 $final_date= $add_date.'-'.$add_time;
                             }
                             else{
                                 $final_date= '';
                             }
                 
                 if($row['dp_date'] != NULL){
                $add_date = date('Y-m-d', strtotime($row['dp_date']));
                 $add_time = date('H:i:s', strtotime($row['dp_date']));
                 $clousre_date= $add_date.'-'.$add_time;
                             }
                             else{
                                 $clousre_date= '';
                             }  
                
                             $duration = date('H:i:s', strtotime($row['responce_time']));
                             $start_base = date('H:i:s', strtotime($row['start_from_base']));
                             
                
                $inc_data = array(
                    'inc_ref_id' => $row['incident_id'],
                    'inc_date' => $final_date,
                    'closer_date' => $row['added_date'],
                    'amb_rto_register_no' => $row['amb_reg_id'],
                    'amb_base_location' => $row['base_location_name'],
                    'ambt_name'=>$row['ambt_name'],
                    'ptn_id' => $row['ptn_id'],
                    'patient_name' => $row['ptn_fname']." ".$row['ptn_lname'],
                    'dp_cl_from_desk' => $dp_cl_from_desk,
                    'disconnectted time' => $inc_datetime,
                    'start_from_base' => $start_base ,
                    'dp_on_scene' => date("H:i:s", strtotime($row['dp_on_scene'])),
                    'dp_reach_on_scene' => date("H:i:s", strtotime($row['dp_reach_on_scene'])),
                    'dp_hosp_time' => date("H:i:s", strtotime($row['dp_hosp_time'])),
                    'dp_hand_time' => date("H:i:s", strtotime($row['dp_hand_time'])),
                    'dp_back_to_loc' => date("H:i:s", strtotime($row['dp_back_to_loc'])),
                    'responce_time' => $duration,
                    'remark_title' => $row['remark_title'],
                    'odo_remark'=>$end_odometer_remark,
                    'inc_area_type' => strtoupper($row['ar_name']),
                    'thirdparty' => $row['thirdparty_name'],
                    'operate_by' => ucwords($row['operate_by']),
                   /// 'added_by' => ucwords($row['inc_added_by']),
                    'epcr_operate_by_Name' => $epcr_operate_by_Name,
                    'added_by' => strtoupper($row['inc_added_by']),
                    'inc_added_by_Name' => ucwords($row['inc_clg_first_name'])." ".ucwords($row['inc_clg_last_name']),
                    'validate_by' => strtoupper($row['validate_by']),
                    'epcr_validate_by_Name' => ucwords($row['epcr_validate_clg_first_name'])." ".ucwords($row['epcr_validate_clg_last_name']),
                );

                fputcsv($fp, $inc_data);
            }
            fclose($fp);
            exit;
        } 
    }
    function load_login_employee_report_form() {

        $report_type = $this->input->post('emp_report_type');

        if ($report_type === '1') {
            $data['submit_function'] = "load_employee_report_form";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/employee_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_employee_report_block_fields', TRUE);
             $this->output->add_to_position('', 'user_employee_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "load_employee_login_logout_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/employee_login_logout_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_employee_report_block_fields', TRUE);
             $this->output->add_to_position('', 'user_employee_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }

        if ($report_type === '3') {
            $data['submit_function'] = "load_employee_break_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/employee_breaks_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_employee_report_block_fields', TRUE);
             $this->output->add_to_position('', 'user_employee_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }

        if ($report_type === '4') {
            $data['submit_function'] = "load_employee_calls_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/system_filter_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_employee_report_block_fields', TRUE);
             $this->output->add_to_position('', 'user_employee_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
    }

    function ambulance_report_form() {

        $report_type = $this->input->post('amb_report_type');

        if ($report_type === '1') {
            $data['submit_function'] = "load_ambulance_district_report_form";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_sub_report_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_ambulance_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "load_ambulance_report_form";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_sub_report_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_ambulance_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }

        if ($report_type === '3') {
            $data['submit_function'] = "load_ambulance_distance_travel_report_form";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_sub_report_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_ambulance_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
    }

    function ambulance_listing_report_form() {
       
        $report_type = $this->input->post('amb_report_type');

        if ($report_type === '1') {
            $data['submit_function'] = "ambulance_listing_district_wise";
            
            $data['district_data'] = $this->common_model->get_district(array('st_id'=>'MP'));
            $this->output->add_to_position($this->load->view('frontend/erc_reports/district_filter_view', $data, TRUE), 'Sub_ambulance_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "ambulance_listing_district_report_form";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_listing_sub_report_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_ambulance_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }

        if ($report_type === '3') {
            $data['submit_function'] = "load_ambulance_distance_travel_report_form";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_listing_sub_report_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_ambulance_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
    }

    function ambulance_master_report_form() {
       
        $report_type = $this->input->post('amb_report_type');

        if ($report_type === '1') {
            $data['submit_function'] = "ambulance_master_district_wise";
            
            $data['district_data'] = $this->common_model->get_district(array('st_id'=>'MP'));
            $this->output->add_to_position($this->load->view('frontend/erc_reports/district_filter_view', $data, TRUE), 'Sub_ambulance_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "ambulance_listing_district_report_form";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_listing_sub_report_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_ambulance_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }

        if ($report_type === '3') {
            $data['submit_function'] = "load_ambulance_distance_travel_report_form";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_listing_sub_report_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_ambulance_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
    }

    function ambulance_logout_report_form() {
       
        $report_type = $this->input->post('amb_report_type');

        if ($report_type === '1') {
            $data['submit_function'] = "ambulance_logout_district_wise";
            
            $data['district_data'] = $this->common_model->get_district(array('st_id'=>'MP'));
            $this->output->add_to_position($this->load->view('frontend/erc_reports/district_filter_view', $data, TRUE), 'Sub_ambulance_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "ambulance_listing_district_report_form";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_listing_sub_report_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_ambulance_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }

        if ($report_type === '3') {
            $data['submit_function'] = "load_ambulance_distance_travel_report_form";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_listing_sub_report_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_ambulance_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
    }

    function hpcl_ambulance_report_form() {
        $report_type = $this->input->post('report_type');

        if ($report_type === '1') {
            $data['submit_function'] = "load_hpcl_ambulance_report_form";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_sub_report_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_ambulance_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "load_hpcl_amb_report_form";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_sub_report_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_ambulance_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
    }

    function load_ambulance_report_form() {

        $report_type = $this->input->post('amb_type');
        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "ambulance_report_form_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view', $data, TRUE), 'Sub_ambulance_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "ambulance_report_form_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_ambulance_report_block_fields', TRUE);
        }
    }

    function load_ambulance_distance_travel_report_form() {

        $report_type = $this->input->post('amb_type');
        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "ambulance_distance_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_distance_report', $data, TRUE), 'Sub_ambulance_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "ambulance_distance_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_ambulance_report_block_fields', TRUE);
        }
    }

    function load_ambulance_district_report_form() {

        $report_type = $this->input->post('amb_type');
        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "export_district_wise";
            
            $data['district_data'] = $this->common_model->get_district(array('st_id'=>'MP'));
            $this->output->add_to_position($this->load->view('frontend/erc_reports/district_filter_view', $data, TRUE), 'Sub_ambulance_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "export_district_wise";
            $data['district_data'] = $this->common_model->get_district(array('st_id'=>'MP'));
            $this->output->add_to_position($this->load->view('frontend/erc_reports/district_month_filter_view', $data, TRUE), 'Sub_ambulance_report_block_fields', TRUE);
        }
    }
    
    function ambulance_listing_district_report_form() {

        $report_type = $this->input->post('amb_type');
        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "ambulance_listing_district_wise";
            
            $data['district_data'] = $this->common_model->get_district(array('st_id'=>'MP'));
            $this->output->add_to_position($this->load->view('frontend/erc_reports/district_filter_view', $data, TRUE), 'Sub_ambulance_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "ambulance_listing_district_wise";
            $data['district_data'] = $this->common_model->get_district(array('st_id'=>'MP'));
            $this->output->add_to_position($this->load->view('frontend/erc_reports/district_month_filter_view', $data, TRUE), 'Sub_ambulance_report_block_fields', TRUE);
        }
    }

    function nhm_104_datewise_report_form() {

        // $report_type = $this->input->post('amb_type');
        // $data = array();
        // if ($report_type === '1') {
        //     $data['submit_function'] = "ambulance_listing_district_wise";
            
        //     $data['district_data'] = $this->common_model->get_district(array('st_id'=>'MP'));
        //     $this->output->add_to_position($this->load->view('frontend/erc_reports/district_filter_view', $data, TRUE), 'Sub_ambulance_report_block_fields', TRUE);
        // }

        // if ($report_type === '2') {
        //     $data['submit_function'] = "ambulance_listing_district_wise";
        //     $data['district_data'] = $this->common_model->get_district(array('st_id'=>'MP'));
        //     $this->output->add_to_position($this->load->view('frontend/erc_reports/district_month_filter_view', $data, TRUE), 'Sub_ambulance_report_block_fields', TRUE);
        // }
        $report_type = $this->input->post('date_report_type');
        if ($report_type == '1') {
            $data['submit_function'] = "closure_dco_datewise_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        if ($report_type == '2') {
            $data['submit_function'] = "closure_dco_datewise_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }

    }

    function load_hpcl_ambulance_report_form() {

        $report_type = $this->input->post('amb_type');
        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "hpcl_export_date_wise";
            //$data['district_data'] = $this->common_model->get_district();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/hpcl_date_filter_view', $data, TRUE), 'Sub_ambulance_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "hpcl_export_date_wise";
           // $data['district_data'] = $this->common_model->get_district();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/hpcl_month_filter_view', $data, TRUE), 'Sub_ambulance_report_block_fields', TRUE);
        }
    }
    function load_hpcl_amb_report_form(){
        $report_type = $this->input->post('amb_type');
        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "amb_hpcl_export_date_wise";
            $data['amb_data'] = $this->common_model->get_ambulance();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/hpcl_amb_date_filter_view', $data, TRUE), 'Sub_ambulance_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "amb_hpcl_export_date_wise";
            $data['amb_data'] = $this->common_model->get_ambulance();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/hpcl_amb_month_filter_view', $data, TRUE), 'Sub_ambulance_report_block_fields', TRUE);
        }
    }
    function load_employee_report_form() {

        $report_type = $this->input->post('employee_report_type');
         $data = array();
        $data['report_type'] =$report_type;
        if ($report_type === '1') {
            $data['submit_function'] = "load_employee_department_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/department_reports_view', $data, TRUE), 'Sub_employee_report_block_fields', TRUE);
        }
    }
    function load_employee_wise_report_form() {

        $report_type = $this->input->post('employee_report_type');
        $data = array();
        $data['department_name'] = $this->input->post('department_name');
        $data['report_type'] =$report_type;
        //var_dump($data);
        $data['tl_data'] = $this->colleagues_model->get_all_eros(array('team_type' => $data['department_name']));

        if ($report_type === '1') {
            $data['submit_function'] = "load_employee_department_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/user_department_reports_view', $data, TRUE), 'user_employee_report_block_fields', TRUE);
        }
        if ($report_type === '2') {
            $data['submit_function'] = "login_logout_single_date_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/user_department_reports_view', $data, TRUE), 'user_employee_report_block_fields', TRUE);
        }
         if ($report_type === '3') {
            $data['submit_function'] = "break_single_date_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/user_department_reports_view', $data, TRUE), 'user_employee_report_block_fields', TRUE);
        }
    }

    function load_employee_login_logout_report() {

        $report_type = $this->input->post('log_emp_report_type');
       
        $data = array();
        
        if ($report_type === '1') {
            //$report_type = $this->input->post('employee_report_type');
            $data['report_type'] ='2';
            $data['submit_function'] = "login_logout_single_date_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/department_reports_view', $data, TRUE), 'Sub_employee_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "login_logout_single_date_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/single_date_view', $data, TRUE), 'Sub_employee_report_block_fields', TRUE);
        }
    }

    function load_employee_calls_report() {
       $data = array();
       $data['system'] = $this->input->post('system');
       $report_type=$this->input->post('report_type');
       $data['submit_function'] = "calls_date_report";
       $data['tl_data'] = $this->colleagues_model->get_all_eros(array('system' => $data['system'])); 
       $data['all_clg'] = $this->colleagues_model->get_all_ero($args);
        $this->output->add_to_position($this->load->view('frontend/erc_reports/ero_name_view', $data, TRUE), 'user_employee_report_block_fields', TRUE);
          }

    function calls_date_report() {
   
        $post_reports = $this->input->post();
       //var_dump($post_reports);die;
        $thirdparty = $this->clg->thirdparty;
      // var_dump($thirdparty);die;
       $district = $this->clg->clg_district_id;
       $clg_district_id = json_decode($district);
       if(is_array($clg_district_id)){
           $district_id = implode("','",$clg_district_id);
       }

        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month']
            );
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month']
            );
        }



        $header = array('No','Call Type','Total Counts','Third Party');

        $report_data =$this->call_model->get_all_child_purpose_of_calls();
        
        $data['report_args'] = $report_args;
        $user_id= $data['user_id'] = $post_reports['user_id'];
        $system= $data['system'] = $post_reports['system'];

        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            if(isset($report_data)){
            foreach ($report_data as $row) {

                $inc_data[] = array(
                   'pcode'=>$row->pcode,
                    'pname' => ucwords($row->pname),
                    'clg_third_party' => $thirdparty
                    
                );
            }}
          

            $data['header'] = $header;
           $data['inc_data'] = $inc_data;

        //var_dump($system);die;
            $data['submit_funtion'] = 'calls_date_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/emp_call_list_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "call_status_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
           
        //    echo $calls_total;die;
        
            $count = 1;
            $calls_total1= 0;
            
            foreach ($report_data as $row) { 
                $thirdparty = '';
                if($inc['clg_third_party'] != ''){
                    $thirdparty = get_third_party_name($inc['clg_third_party']);
                }


                
                $user_id =$post_reports['ref_id']; 
//                if($post_reports['system_type'] == 'UG-ERO-102'){
//                   $system = '102';
//                }else if($post_reports['system_type'] == 'UG-ERO-102'){
//                   $system = '108'; 
//                }else{
//                    $system = 'all_clg';
//                }
                
                $calls_total= get_total_by_call_type($user_id,$row->pcode,$dur="ft",$report_args['from_date'],$report_args['to_date'],$system);
              
                if($calls_total != '' && $calls_total != null){
                    $calls_total1 =$calls_total;
                    
                }else{
                    $calls_total1 = "0";
                }
                $call_total =$call_total+$calls_total1;
                
                $inc_data = array(
                    'Sr.No' => $count,
                    'Call Type' => ucwords($row->pname) ,
                    'Total Counts' =>$calls_total1,
                    'clg_third_party'=> $third_party
                );
                
                fputcsv($fp, $inc_data);
                $count++;
            }
            $post_reports = $this->input->post();
            $user_id= $data['user_id'] = $post_reports['user_id'];
            $system= $data['system'] = $post_reports['system'];
            if ($post_reports['to_date'] != '') {
                $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                    'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                    'base_month' => $this->post['base_month']
                );
            } else {
                $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                    'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                    'base_month' => $this->post['base_month']
                );
            }
            
            //var_dump($calls_total);die;
            $calls_total= get_total_by_call_type($user_id,$row->pcode="",$dur="ft",$report_args['from_date'],$report_args['to_date'],$system);
            $total = array('','Total',$calls_total);
           //var_dump($calls_total);die;
            fputcsv($fp,$total);
           fclose($fp);
            exit;
        }
    }

    function calls_date_filter_report() {

        $report_type = $this->input->post('user_id');
       
        
        if ($report_type == '1') {
            $data['submit_function'] = "load_incident_sub_date_report_form";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/incident_sub_report_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_date_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
        if ($report_type == '2') {
            $data['submit_function'] = "load_other_incident_date_report_form";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/incident_sub_other_report_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_date_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
    }
    
    function load_employee_breaks_report() {

        $report_type = $this->input->post('log_emp_report_type');
        $data['user_id'] = $this->input->post('user_id');
        $data['report_type'] =$report_type;
        $data = array();
        if ($report_type === '1') {
            $data['report_type'] ='3';
            $data['submit_function'] = "break_single_date_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/department_reports_view', $data, TRUE), 'Sub_employee_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "break_single_date_report";
            
            $this->output->add_to_position('', 'Sub_employee_report_block_fields', TRUE);
            $this->output->add_to_position('', 'user_employee_report_block_fields', TRUE);
            $this->output->add_to_position($this->load->view('frontend/erc_reports/break_single_date_view', $data, TRUE), 'Sub_employee_report_block_fields', TRUE);
        }
    }
    function fuel_filling()
    {
        $report_type = $this->input->post('report_type');
        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "load_fuel_filling_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "load_fuel_filling_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }
    }
    function unable_to_dispatch() {
        $report_type = $this->input->post('report_type');
        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "unable_to_dispatch_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "unable_to_dispatch_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }
    }
    function load_pda_report_form() {

        $report_type = $this->input->post('police_report_type');
        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "load_pda_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "load_pda_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }

        if ($report_type === '3') {
            $data['submit_function'] = "load_pda_district_report";
            $data['district_data'] = $this->common_model->get_district();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/district_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }
    }

    function load_fire_report_form() {

        $report_type = $this->input->post('fire_report_type');
        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "load_fire_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "load_fire_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }

        if ($report_type === '3') {
            $data['submit_function'] = "load_fire_district_report";
            $data['district_data'] = $this->common_model->get_district();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/district_reports_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        }
    }
    function load_closure_lat_long_report(){
        $report_type = $this->input->post('date_report_type');
        if ($report_type == '1') {
            $data['submit_function'] = "closure_lat_long_dco_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        if ($report_type == '2') {
            $data['submit_function'] = "closure_lat_long_dco_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
    }
    function load_closure_report() {
        $report_type = $this->input->post('date_report_type');
        if ($report_type == '1') {
            $data['submit_function'] = "closure_dco_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        if ($report_type == '2') {
            $data['submit_function'] = "closure_dco_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
    }
    function load_closure_datewise_report() {
        $report_type = $this->input->post('date_report_type');
        if ($report_type == '1') {
            $data['submit_function'] = "closure_dco_datewise_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        if ($report_type == '2') {
            $data['submit_function'] = "closure_dco_datewise_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
    }
     function load_unavailed_closure_report() {
        $report_type = $this->input->post('date_report_type');
        if ($report_type == '1') {
            $data['submit_function'] = "unavailed_closure_dco_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        if ($report_type == '2') {
            $data['submit_function'] = "unavailed_closure_dco_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
    }

    
    function load_response_time_report() {
        $report_type = $this->input->post('date_report_type');
        if ($report_type == '1') {
            $data['submit_function'] = "closure_response_time_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        if ($report_type == '2') {
            $data['submit_function'] = "closure_response_time_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
    }
    function load_consumable_report_new(){
        $report_type = $this->input->post('date_report_type');
        if ($report_type == '1') {
            $data['submit_function'] = "closure_consumable_report_new";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        if ($report_type == '2') {
            $data['submit_function'] = "closure_consumable_report_new";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
    }
    function load_consumable_report() {
        $report_type = $this->input->post('date_report_type');
        if ($report_type == '1') {
            $data['submit_function'] = "closure_consumable_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        if ($report_type == '2') {
            $data['submit_function'] = "closure_consumable_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
    }
    function load_maintenance_sub_date_report_form()
    {
        $report_type = $this->input->post('report_type');
        $maintenance_type = $this->input->post('maintenance_type');
        
        if($maintenance_type == 'preventive_maintenance'){
            $data['submit_function'] = "ambulance_maintenance_report";
        }else if($maintenance_type == 'onroad_offroad_maintenance'){
             $data['submit_function'] = "onroad_offroad_maintenance_report";
        }else if($maintenance_type == 'breakdown_maintenance'){
             $data['submit_function'] = "breakdown_maintenance_report";
        }else if($maintenance_type == 'tyre_life_maintenance'){
             $data['submit_function'] = "tyre_life_maintenance_report";
        }else if($maintenance_type == 'accidental_maintenance'){
             $data['submit_function'] = "accidental_maintenance_report";
        }
        
        if ($report_type == '1') {
           // $data['submit_function'] = "ambulance_maintenance_report";
            $data['maintenance_type'] = $maintenance_type;
            $this->output->add_to_position($this->load->view('frontend/reports/export_maintenance_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        if ($report_type == '2') {
           // $data['submit_function'] = "ambulance_maintenance_report";
            $data['maintenance_type'] = $maintenance_type;
            $this->output->add_to_position($this->load->view('frontend/reports/export_main_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        
    }
    function load_incident_pvt_hos_sub_date_report_form(){
        $report_type = $this->input->post('report_type');
        if ($report_type == '1') {
            $data['submit_function'] = "dispatch_incident_pvt_hos_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_date_system_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        if ($report_type == '2') {
            $data['submit_function'] = "dispatch_incident_pvt_hos_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/report_month_system_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
    }
    function load_incident_sub_date_report_form() {
        $report_type = $this->input->post('report_type');
        if ($report_type == '1') {
            $data['submit_function'] = "dispatch_incident_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_date_system_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        if ($report_type == '2') {
            $data['submit_function'] = "dispatch_incident_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/report_month_system_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
    }
    function load_incident_question_answer_report_form() {
        $report_type = $this->input->post('report_type');
        if ($report_type == '1') {
            $data['submit_function'] = "question_answer_incident_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_inc_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        if ($report_type == '2') {
            $data['submit_function'] = "question_answer_incident_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_amb_reports_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
    }
    function load_other_incident_date_report_form() {
        $report_type = $this->input->post('report_type');
        if ($report_type == '1') {
            $data['submit_function'] = "other_incident_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_date_system_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
        if ($report_type == '2') {
            $data['submit_function'] = "other_incident_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/report_month_system_view', $data, TRUE), 'Sub_date_report_block_fields', TRUE);
        }
    }

    function incident_daily_hourly_report() {

        $post_reports = $this->input->post();
        // var_dump($post_reports);die;

        $from_date = date('Y-m-d', strtotime($post_reports['single_date']));
        $data['single_date'] = $post_reports['single_date'];

        $report_args = array('from_date' => $from_date,
            'to_date' => date('Y-m-d', strtotime($post_reports['single_date'])),
            'system'=>$post_reports['system'],
            'inc_type'=> $post_reports['call_purpose']);

        $report_data = $this->inc_model->get_inc_call_details_ref_id($report_args);
        //var_dump($report_data);
       // die();

        $epcr_report_args = array('from_date' => $from_date,
            'to_date' => date('Y-m-d', strtotime($post_reports['single_date'])),
            'base_month' => $this->post['base_month'],
            'inc_type'=> $post_reports['call_purpose']
            );

        //$epcr_report_data = $this->inc_model->get_epcr_by_hourly($epcr_report_args);

        //$header = array('Hour', 'Total call', 'Total Dispatch', 'Total Closure');
        $header = array('Hour', 'Total Call Count', 'EM Call Count', 'Non EM Call Count');

        $daily_report_array = array();
     $hours_key_array = array('0' => '00:00-01:00',
            '1' => '01:00-02:00',
            '2' => '02:00-03.00',
            '3' => '03.00-04.00',
            '4' => '04.00-05.00',
            '5' => '05.00-06.00',
            '6' => '06.00-07.00',
            '7' => '07.00-08.00',
            '8' => '08.00-09.00',
            '9' => '09.00-10.00',
            '10' => '10.00-11.00',
            '11' => '11.00-12.00',
            '12' => '12.00-13.00',
            '13' => '13.00-14.00',
            '14' => '14.00-15.00',
            '15' => '15.00-16.00',
            '16' => '16.00-17.00',
            '17' => '17.00-18.00',
            '18' => '18.00-19.00',
            '19' => '19.00-20.00',
            '20' => '20.00-21.00',
            '21' => '21.00-22.00',
            '22' => '22.00-23.00',
            '23' => '23.00-24.00');

        $eme_type = array('inter-hos','EMG_PVT_HOS','NON_MCI','AD_SUP_REQ','DROP_BACK','IN_HO_P_TR','MCI','EMT_MED_AD','PREGANCY_CALL','PREGANCY_CARE_CALL','VIP_CALL','Child_CARE_CALL','on_scene_care','PICK_UP');
        if($report_data){
            foreach ($report_data as $report) {
                $hour = date('G', strtotime($report->inc_datetime));
                $daily_report_array[$hour]['total_inc'][] = $report->inc_ref_id;
                if ($report->incis_deleted == 0) {
                
                    if (in_array($report->inc_type, $eme_type)){
                        $daily_report_array[$hour]['dispatch_inc'][] = $report->inc_ref_id;
                    }else{
                        $daily_report_array[$hour]['epcr_inc'][] = $report->inc_ref_id;
                    }
                    
                    
                }
            }
        }
        

//        if($epcr_report_data){
//            foreach ($epcr_report_data as $epcr_report) {
//
//    //            var_dump($epcr_report);
//
//                $hour = date('G', strtotime($epcr_report['time']));
//                $daily_report_array[$hour]['epcr_inc'][] = $epcr_report['inc_ref_id'];
//            }
//        }
//        // var_dump($daily_report_array); 
//        ksort($daily_report_array);
        
        $data['daily_function']="incident_daily_hourly_report";

        if ($post_reports['reports'] == 'view') {


            $inc_data = array();

            $data['header'] = $header;
            //$daily_report_array = ksort($daily_report_array);
            //var_dump($daily_report_array);
            $data['hours_key_array'] = $hours_key_array;
            $data['daily_report_array'] = $daily_report_array;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/reports/incident_daily_hourly_report_view', $data, TRUE), 'list_table1', TRUE);
        } else {

            $filename = "incident_daily_hourly_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $data = array();
            $total_inc= 0;
            $epcr_inc_total= 0;
             $dispatch_inc_total= 0;

            for ($hh = 0; $hh < 24; $hh++) {
                //foreach($daily_report_array as $key=>$daily_report){
                
                $total_call= 0;
                $epcr_inc= 0;
                $dispatch_inc= 0;

                if( !empty($daily_report_array[$hh]['total_inc'])){
                    $total_call= count($daily_report_array[$hh]['total_inc']);
                    $total_inc = $total_inc + $total_call;
                }
                if( !empty($daily_report_array[$hh]['epcr_inc'])){
                    $epcr_inc= count($daily_report_array[$hh]['epcr_inc']);
                    $epcr_inc_total = $epcr_inc_total + $epcr_inc;
                }
                if( !empty($daily_report_array[$hh]['dispatch_inc'])){
                    $dispatch_inc= count($daily_report_array[$hh]['dispatch_inc']);
                    $dispatch_inc_total = $dispatch_inc_total + $dispatch_inc;
                }
                
                $inc_data = array(
                    'Hour' => $hours_key_array[$hh],
                    'total_call' => $total_call,
                    'total_dispatch' => $dispatch_inc,
                    'total_closer' => $epcr_inc,
                );

                fputcsv($fp, $inc_data);
            }
            $total = array('Total', $total_inc,$dispatch_inc_total,$epcr_inc_total);
            fputcsv($fp, $total);

            fclose($fp);
            exit;
        }
         if($post_reports['flt'] == 'reset'){
            $data = array();
            $data['submit_function'] = "incident_daily_hourly_report";
            $data['report_name'] = "Hourly Data (Daily Report)";
            $data['all_purpose_of_calls'] = $this->call_model->get_all_child_purpose_of_calls();
            $data['hours_key_array'] = array();
            $data['daily_report_array'] = array();
            $data['report_args'] = array();
            $data['days'] = $days;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/daily_date_view', $data, TRUE), 'popup_div', TRUE);
            //$this->output->add_to_position('', 'list_table', TRUE);
          //  return;
        }
    }
    
    /*
    function amb_avail_hourly_report()
    {

        $post_reports = $this->input->post();

         $data['single_date'] = $post_reports['single_date'];

        $from_date = date('Y-m-d', strtotime($post_reports['single_date']));
        $report_args = array('from_date' => $from_date);
        
        $report_data = $this->inc_model->get_amb_details_single_date($report_args);

        $header = array('Hour', 'Total Ambulance Available', 'Total Busy Ambulance', 'Total Inactive Ambulance');

        $daily_report_array = array();
        $hours_key_array = array(
            '0' => '00:00-01:00',
            '1' => '01:00-02:00',
            '2' => '02:00-03.00',
            '3' => '03.00-04.00',
            '4' => '04.00-05.00',
            '5' => '05.00-06.00',
            '6' => '06.00-07.00',
            '7' => '07.00-08.00',
            '8' => '08.00-09.00',
            '9' => '09.00-10.00',
            '10' => '10.00-11.00',
            '11' => '11.00-12.00',
            '12' => '12.00-13.00',
            '13' => '13.00-14.00',
            '14' => '14.00-15.00',
            '15' => '15.00-16.00',
            '16' => '16.00-17.00',
            '17' => '17.00-18.00',
            '18' => '18.00-19.00',
            '19' => '19.00-20.00',
            '20' => '20.00-21.00',
            '21' => '21.00-22.00',
            '22' => '22.00-23.00',
            '23' => '23.00-24.00');

            if($report_data)
            {
                foreach ($report_data as $report)
                {
                    $hour = date('G', strtotime($report->date_time));
                    $daily_report_array[$hour]['available_count'][] = $report->available_count;
                            $daily_report_array[$hour]['busy_count'][] = $report->busy_count;
                       
                            $daily_report_array[$hour]['inactive_count'][] = $report->inactive_count;  
                            $daily_report_array[$hour]['third_party'][] = $report->inactive_count;  

        
                }
            }
    
        if ($post_reports['reports'] == 'view') 
        {  
            $data['header'] = $header;
            $data['hours_key_array'] = $hours_key_array;
            $data['daily_report_array'] = $daily_report_array;
      
            $value = $this->output->add_to_position($this->load->view('frontend/reports/amb_avail_hourly_report_view', $data, TRUE), 'list_table', TRUE);

        } 
        else 
        { 
            $from_data = date('Y-m-d', strtotime($post_reports['single_date']));
        
            $filename = "ambulance_availibility_hourly_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);
     
                $data = array();

                for ($hh = 0; $hh < 24; $hh++) {
              
                    $available_count= 0;
                    $busy_count= 0;
                    $inactive_count= 0;
        
                    if( !empty($daily_report_array[$hh]['available_count'])){
                        $available_count = $daily_report_array[$hh]['available_count'][0];
                      
                    } else { 
                        echo '0'; 
       
                   } 
                    
                    if( !empty($daily_report_array[$hh]['busy_count'])){
                        $busy = $daily_report_array[$hh]['busy_count'];
                        $busy_count = $busy[0] ; 

                    } else { 
                        echo '0'; 
       
                   } 
                    
                  
                    if( !empty($daily_report_array[$hh]['inactive_count'])){
                        $inactive = $daily_report_array[$hh]['inactive_count'];
                        $inactive_count = $inactive[0] ;
                  
                    } else { 
                        echo '0'; 

                   } 
                    

               $inc_data = array(
                    'Hour' => $hours_key_array[$hh],
                    'available_count' =>  $available_count,
                    'busy_count' => $busy_count,
                    'inactive_count' => $inactive_count
                );
    
                fputcsv($fp, $inc_data);         
            }
      
            fclose($fp);
            exit;
        }
    }*/
    function incident_weekly_hourly_report() {

        $post_reports = $this->input->post();
        // var_dump($post_reports);die;

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $to_date = date('Y-m-d', strtotime($post_reports['to_date']));
        
        $date1= new DateTime($from_date);
        $date2= new DateTime($to_date);
        $diff=date_diff($date1,$date2);
        $days= $diff->format("%a");
        

        $report_args = array('from_date' => $from_date,
            'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
            'inc_type'=> $post_reports['call_purpose'],
            'system'=> $post_reports['system'],
        );




        $report_data = $this->inc_model->get_inc_call_details_ref_id($report_args);

        $epcr_report_args = array('from_date' => $from_date,
            'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
            'base_month' => $this->post['base_month'],
            'inc_type'=> $post_reports['call_purpose']
            );



        //$epcr_report_data = $this->inc_model->get_epcr_by_hourly($epcr_report_args);



        $header = array('Hour', 'Total Call Count', 'EM Call Count', 'Non EM Call Count');

        $daily_report_array = array();
        $hours_key_array = array('0' => '00:00-01:00',
            '1' => '01:00-02:00',
            '2' => '02:00-03.00',
            '3' => '03.00-04.00',
            '4' => '04.00-05.00',
            '5' => '05.00-06.00',
            '6' => '06.00-07.00',
            '7' => '07.00-08.00',
            '8' => '08.00-09.00',
            '9' => '09.00-10.00',
            '10' => '10.00-11.00',
            '11' => '11.00-12.00',
            '12' => '12.00-13.00',
            '13' => '13.00-14.00',
            '14' => '14.00-15.00',
            '15' => '15.00-16.00',
            '16' => '16.00-17.00',
            '17' => '17.00-18.00',
            '18' => '18.00-19.00',
            '19' => '19.00-20.00',
            '20' => '20.00-21.00',
            '21' => '21.00-22.00',
            '22' => '22.00-23.00',
            '23' => '23.00-24.00');

        $eme_type = array('inter-hos','EMG_PVT_HOS','NON_MCI','AD_SUP_REQ','DROP_BACK','IN_HO_P_TR','MCI','EMT_MED_AD','PREGANCY_CALL','PREGANCY_CARE_CALL','VIP_CALL','Child_CARE_CALL','on_scene_care','PICK_UP');
        if($report_data){
            foreach ($report_data as $report) {
                $hour = date('G', strtotime($report->inc_datetime));
                $daily_report_array[$hour]['total_inc'][] = $report->inc_ref_id;
                if ($report->incis_deleted == 0) {
                
                    if (in_array($report->inc_type, $eme_type)){
                        $daily_report_array[$hour]['dispatch_inc'][] = $report->inc_ref_id;
                    }else{
                        $daily_report_array[$hour]['epcr_inc'][] = $epcr_report->inc_ref_id;
                    }
                    
                }
            }
        }

//        if($epcr_report_data){
//            foreach ($epcr_report_data as $epcr_report) {
//
//    //            var_dump($epcr_report);
//
//                $hour = date('G', strtotime($epcr_report['time']));
//                $daily_report_array[$hour]['epcr_inc'][] = $epcr_report['inc_ref_id'];
//            }
//        }
         //var_dump($daily_report_array); 
      //  ksort($daily_report_array);
      $data['weekly_function']="incident_weekly_hourly_report";

        if ($post_reports['reports'] == 'view') {


            $inc_data = array();

            $data['header'] = $header;
            //$daily_report_array = ksort($daily_report_array);
            //var_dump($daily_report_array);
            $data['hours_key_array'] = $hours_key_array;
            $data['daily_report_array'] = $daily_report_array;
            $data['report_args'] = $report_args;
            $data['days'] = $days;
                // var_dump($days);
            

            $this->output->add_to_position($this->load->view('frontend/reports/incident_daily_weekly_report_view', $data, TRUE), 'list_table1', TRUE);
            
        } else {


            $filename = "incident_daily_weekly_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $data = array();
            
            $total_inc= 0;
            $epcr_inc_total= 0;
             $dispatch_inc_total= 0;

            for ($hh = 0; $hh < 24; $hh++) {
                //foreach($daily_report_array as $key=>$daily_report){
                
                $total_call= 0;
                $epcr_inc= 0;
                $dispatch_inc= 0;
                $total_call_avg= 0;
                $epcr_inc_avg= 0;
                $dispatch_inc_avg= 0;

                if( !empty($daily_report_array[$hh]['total_inc'])){
                    $total_call= count($daily_report_array[$hh]['total_inc']);
                    if($days > 0){
                    $total_call_avg = round(((int)$total_call/(int)$days),2);
                    }else{
                        $total_call_avg = 0;
                    }
                    $total_inc = $total_inc + $total_call;
                }
                if( !empty($daily_report_array[$hh]['epcr_inc'])){
                    $epcr_inc= count($daily_report_array[$hh]['epcr_inc']);
                    // $epcr_inc_avg = round(((int)$epcr_inc/(int)$days),2);
                    $epcr_inc_total = $epcr_inc_total + $epcr_inc;
                }
                if( !empty($daily_report_array[$hh]['dispatch_inc'])){
                    $dispatch_inc= count($daily_report_array[$hh]['dispatch_inc']);
                    // $dispatch_inc_avg = round(((int)$dispatch_inc/(int)$days),2);
                    $dispatch_inc_total = $dispatch_inc_total + $dispatch_inc;
                }
                

//                $inc_data = array(
//                    'Hour' => $hours_key_array[$hh],
//                    'total_call' =>$total_call,
//                    'total_dispatch' => $dispatch_inc,
//                    'total_closer' => $epcr_inc,
//                );
                     $inc_data = array(
                    'Hour' => $hours_key_array[$hh],
                    'total_call' => $total_call,
                    'total_dispatch' => $dispatch_inc,
                    'total_closer' => $epcr_inc,
                );

                fputcsv($fp, $inc_data);
            }
//            $total_inc =round(((int)$total_inc/(int)$days),2);
//            $dispatch_inc_total =round(((int)$dispatch_inc_total/(int)$days),2);
//            $epcr_inc_total =round(((int)$epcr_inc_total/(int)$days),2);
            $total = array('Total', $total_inc,$dispatch_inc_total,$epcr_inc_total);
            fputcsv($fp, $total);
            fclose($fp);
            exit;
        }
         
        if($post_reports['flt'] == 'reset'){
            $data = array();
            $data['submit_function'] = "incident_weekly_hourly_report";
            $data['report_name'] = "Hourly Data (Daily Report)";
            $data['all_purpose_of_calls'] = $this->call_model->get_all_child_purpose_of_calls();
            $data['hours_key_array'] = array();
            $data['daily_report_array'] = array();
            $data['report_args'] = array();
            $data['days'] = $days;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/daily_date_view', $data, TRUE), 'popup_div', TRUE);
            //$this->output->add_to_position('', 'list_table', TRUE);
          //  return;
        }
    }
    function feedback_type_report() {

        $post_reports = $this->input->post();

        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month']
            );
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month']
            );
        }



        $header = array('Sr.No','Incident Id', 'Incident Date/Time', 'Caller No.', 'Caller Name', 'Call Type', 'Feedback Type','How is the patient condition?','Have you receive service?','How was the treatment provided by the doctor?','How did you come to know about service?', 'Standard Remark', 'Employee Remark','Feedback done by','Feedback Date/time');

        $report_data = $this->feedback_model->get_feedback_reports($report_args);
      // var_dump($report_args);die;
        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            foreach ($report_data as $row) {
                
                $stanadard_remark ='';
                if (!empty($row->fc_standard_type)) {
                    $standard = json_decode($row->fc_standard_type);
                    $stanadard_remarks = array();
                    foreach ($standard as $remark) {
                        if($remark != ''){
                            $st_args = array('fdsr_id' => $remark);
                            $report_data = $this->call_model->get_feedback_stand_remark($st_args);
                            $stanadard_remarks[] = $report_data[0]->fdsr_type;
                        }
                    }
                    $stanadard_remark = implode(', ', $stanadard_remarks);
                }
                $ques1 = array('inc_id' => $row->inc_ref_id,'ques_id'=> '244');
                $report_data1 = $this->common_model->get_feedback_ques_ans($ques1);
                $sum_que_ans1 = $report_data1[0]->sum_que_ans;

                $ques2 = array('inc_id' => $row->inc_ref_id,'ques_id'=> '245');
                $report_data2 = $this->common_model->get_feedback_ques_ans($ques2);
                $sum_que_ans2 = $report_data2[0]->sum_que_ans;
                
                $ques3 = array('inc_id' => $row->inc_ref_id,'ques_id'=> '246');
                $report_data3 = $this->common_model->get_feedback_ques_ans($ques3);
                $sum_que_ans3 = $report_data3[0]->sum_que_ans;

                $ques4 = array('inc_id' => $row->inc_ref_id,'ques_id'=> '247');
                $report_data4 = $this->common_model->get_feedback_ques_ans($ques4);
                $sum_que_ans4 = $report_data4[0]->sum_que_ans;
               // var_dump($sum_que_ans1);die();
                //var_dump($sum_que_ans2);var_dump($sum_que_ans3);var_dump($sum_que_ans4);die();
                $inc_data[] = array(
                    'inc_ref_id' => $row->inc_ref_id,
                    'fc_call_type' => ucwords($row->fc_call_type),
                    'ptn_gender' => $row->fc_ptn_gender,
                    'fc_feedback_type' => $row->fc_feedback_type,
                    'fc_standard_type' => $stanadard_remark,
                    'fc_employee_remark' => $row->fc_employee_remark,
                    'clr_mobile' => $row->fc_caller_number,
                    'clr_fullname' => ucwords($row->fc_caller_name),
                    'inc_datetime' => $row->inc_datetime,
                    'fdsr_type' => $row->fdsr_type[0],
                    'fdsr_added_by' => $row->fc_added_by,
                    'fdsr_datetime' => $row->fc_added_date,
                    'sum_que_ans1' => $sum_que_ans1,
                    'sum_que_ans2' => $sum_que_ans2,
                    'sum_que_ans3' => $sum_que_ans3,
                    'sum_que_ans4' => $sum_que_ans4
                );
            }

          // var_dump($inc_data);die;
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['submit_funtion'] = 'feedback_type_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/feedback_inc_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "feedback_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            $srno = 1;
            foreach ($report_data as $row) {

                if ($row->fc_feedback_type == 'negative_feedback') {
                    $type = 'Negative Feedback';
                } else {
                    $type = 'Positive Feedback';
                }
                  $stanadard_remark ='';
                if (!empty($row->fc_standard_type)) {
                    $standard = json_decode($row->fc_standard_type);
                    $stanadard_remarks = array();
                    foreach ($standard as $remark) {

                        $st_args = array('fdsr_id' => $remark);
                        $report_data = $this->call_model->get_feedback_stand_remark($st_args);
                        $stanadard_remarks[] = $report_data[0]->fdsr_type;
                    }
                    $stanadard_remark = implode(', ', $stanadard_remarks);
                }

                $ques1 = array('inc_id' => $row->inc_ref_id,'ques_id'=> '244');
                $report_data1 = $this->common_model->get_feedback_ques_ans($ques1);
                $sum_que_ans1 = $report_data1[0]->sum_que_ans;

                $ques2 = array('inc_id' => $row->inc_ref_id,'ques_id'=> '245');
                $report_data2 = $this->common_model->get_feedback_ques_ans($ques2);
                $sum_que_ans2 = $report_data2[0]->sum_que_ans;
                
                $ques3 = array('inc_id' => $row->inc_ref_id,'ques_id'=> '246');
                $report_data3 = $this->common_model->get_feedback_ques_ans($ques3);
                $sum_que_ans3 = $report_data3[0]->sum_que_ans;

                $ques4 = array('inc_id' => $row->inc_ref_id,'ques_id'=> '247');
                $report_data4 = $this->common_model->get_feedback_ques_ans($ques4);
                $sum_que_ans4 = $report_data4[0]->sum_que_ans;

                $inc_data = array(
                    'Sr.No' => $srno,
                    'inc_ref_id' => $row->inc_ref_id,
                    'inc_datetime' => $row->inc_datetime,
                    'clr_mobile' => $row->fc_caller_number,
                    'clr_fullname' => ucwords($row->fc_caller_name),
                    'fc_call_type' => ucwords($row->fc_call_type),
                    'fc_feedback_type' => $type,    
                    'sum_que_ans1' => $sum_que_ans1,
                    'sum_que_ans2' => $sum_que_ans2,
                    'sum_que_ans3' => $sum_que_ans3,
                    'sum_que_ans4' => $sum_que_ans4,            
                    'fc_standard_type' => $stanadard_remark,
                    'fc_employee_remark' => $row->fc_employee_remark,
                    'fdsr_added_by' => $row->fc_added_by,
                    'fdsr_datetime' => $row->fc_added_date
                );
                fputcsv($fp, $inc_data);
                $srno++;
            }

            fclose($fp);
            exit;
        }
    }

    function grievance_type_report() {

        $post_reports = $this->input->post();

        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month']
            );
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month']
            );
        }



        $header = array('Date & Time', 'Complaint Register No', 'Complaint type', 'Status', 'Complaint close date', 'Complaint added by', 'Complaint close by');

        $report_data = $this->grievance_model->get_inc_by_grievance($report_args);

//        var_dump($report_data);
//        die();

        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            foreach ($report_data as $row) {

                $inc_data[] = array(
                    'gc_date_time' => $row->gc_date_time,
                    'gc_inc_ref_id' => $row->gc_inc_ref_id,
                    'gc_caller_number' => $row->gc_caller_number,
                    'dst_name' => $row->dst_name,
                    'gc_complaint_type' => $row->gc_complaint_type,
                    'gc_closure_status' => $row->gc_closure_status,
                    'gc_added_by' => $row->gc_added_by,
                    'gc_close_by' => $row->gc_close_by,
                    'gc_closed_date' => $row->gc_closed_date,
                );
            }


            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['submit_funtion'] = 'grievance_type_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/grievance_inc_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "grievance_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();

            foreach ($report_data as $row) {

                if ($row->gc_complaint_type == 'e-complaint') {
                    $comp_type = "E Complaint";
                } else if ($row->gc_complaint_type == 'negative_news') {
                    $comp_type = "Negative News";
                } else if ($row->gc_complaint_type == 'external') {
                    $comp_type = "External";
                } else if ($row->gc_complaint_type == 'internal') {
                    $comp_type = "Internal";
                }

                if ($row->gc_closure_status == 'complaint_pending') {
                    $status = "Complaint Pending";
                } else if ($row->gc_closure_status == 'complaint_close') {
                    $status = "Complaint Close";
                } else if ($row->gc_closure_status == 'complaint_open') {
                    $status = "Complaint Open";
                }

                if ($row->gc_closed_date == '' || $row->gc_closed_date == '0000-00-00 00:00:00') {
                    $date = "-";
                } else {
                    $date = $row->gc_closed_date;
                }
                if ($row->gc_close_by == '') {
                    $close = "-";
                } else {
                    $close = $row->gc_close_by;
                }

                $inc_data = array(
                    'gc_date_time' => $row->gc_date_time,
                    'gc_inc_ref_id' => $row->gc_inc_ref_id,
                    'gc_complaint_type' => $comp_type,
                    'gc_closure_status' => $status,
                    'gc_closed_date' => $date,
                    'gc_added_by' => $row->gc_added_by,
                    'gc_close_by' => $close
                );

                fputcsv($fp, $inc_data);
            }

            fclose($fp);
            exit;
        }
    }
    function summary_report_details(){
        $post_reports = $this->input->post();
        $district_id = $this->clg->clg_district_id;
        $district_id = explode( ",", $district_id);
        $regex = "([\[|\]|^\"|\"$])"; 
        $replaceWith = ""; 
        $district_id = preg_replace($regex, $replaceWith, $district_id);
        if(is_array($district_id)){
            $district_id = implode("','",$district_id);
        }
        $thirdparty = $this->clg->thirdparty;
        $header = array('Sr.No', 'District','Third-Party','Total Case Dispatch','Total_patient_served','Total_ambulance_onboard'); 
        if($thirdparty != 1){
        $args = array('district_id' => $district_id,'third_party' => $thirdparty);
        }
        $get_district = $this->inc_model->get_district_name_Summary($args);

        if ($post_reports['reports'] == 'view') {
        $inc_data = array();
        foreach($get_district as $district){
           // $report_args = $district->dst_code;
           if($district->third_party == '1'){
                $third_party = 'BVG';
           }elseif($district->third_party=='2'){
                $third_party = 'Private';
           }elseif($district->third_party=='3'){
                $third_party = 'PCMC';
           }elseif($district->third_party=='4'){
                $third_party = 'PMC';
           }elseif($district->third_party=='6'){
                $third_party = 'Pune ruler';
           }
           
           $report_args_new = array('thirdparty_type' => $district->third_party,'district' => $district->dst_code);
           $report_data_new = $this->inc_model->get_amb_data($report_args_new);

           if ($post_reports['to_date'] != '') {
            $report_args_patient = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
                'thirdparty_type' => $district->third_party,
                'district' => $district->dst_code
            );
            } else {
            $report_args_patient = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                'thirdparty_type' => $district->third_party,
                'district' => $district->dst_code
            );
            }
           // = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),'thirdparty_type' => $district->third_party,'district' => $district->dst_code);
           $report_data_dispatch = $this->inc_model->get_ambulance_dispatch_data($report_args_patient);

           $report_data_patient = $this->inc_model->get_patient_data($report_args_patient);
            $inc_data[]=array(
                            'dist_name'=> $district->dst_name,
                            'third_party' => $third_party,
                            'amb_count'=> $report_data_new[0]->amb_count,
                            'patient_count' =>$report_data_patient[0]->inc_ref_id,
                            'dispatch_count' =>$report_data_dispatch[0]->dispatch_count
                            ); 
        }
        
       
        $data['header'] = $header;
        $data['inc_data'] = $inc_data;
         $data['submit_funtion'] = 'summary_report_details';
        $this->output->add_to_position($this->load->view('frontend/erc_reports/Summary_report_details', $data, TRUE), $output_position , TRUE);
        }else{
            $filename = "Summary_Report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();

            foreach ($get_district as $district){
                if($district->third_party == '1'){
                    $third_party = 'BVG';
               }elseif($district->third_party=='2'){
                    $third_party = 'Private';
               }elseif($district->third_party=='3'){
                    $third_party = 'PCMC';
               }elseif($district->third_party=='4'){
                    $third_party = 'PMC';
               }
               $report_args_new = array('thirdparty_type' => $district->third_party,'district' => $district->dst_code);
               $report_data_new = $this->inc_model->get_amb_data($report_args_new);
    
               if ($post_reports['to_date'] != '') {
                $report_args_patient = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                    'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                    'base_month' => $this->post['base_month'],
                    'thirdparty_type' => $district->third_party,
                    'district' => $district->dst_code
                );
                } else {
                $report_args_patient = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                    'to_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                    'base_month' => $this->post['base_month'],
                    'thirdparty_type' => $district->third_party,
                    'district' => $district->dst_code
                );
                }
               // = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),'thirdparty_type' => $district->third_party,'district' => $district->dst_code);
               $report_data_dispatch = $this->inc_model->get_ambulance_dispatch_data($report_args_patient);
    
               $report_data_patient = $this->inc_model->get_patient_data($report_args_patient);
               $count=1;
                $inc_data =array(
                                'Sr.no' => $count,
                                'dist_name'=> $district->dst_name,
                                'third_party' => $third_party,
                                'dispatch_count' =>$report_data_dispatch[0]->dispatch_count,
                                'patient_count' =>$report_data_patient[0]->inc_ref_id,
                                'amb_count'=> $report_data_new[0]->amb_count
                                ); 
                fputcsv($fp, $inc_data);
            }
            $count++;
            fclose($fp);
            exit;
        }
    }
    function summary_report(){
    $post_reports = $this->input->post();
    //var_dump($post_reports);die();
        $district_id = $this->clg->clg_district_id;
        $district_id = explode( ",", $district_id);
        $regex = "([\[|\]|^\"|\"$])"; 
        $replaceWith = ""; 
        $district_id = preg_replace($regex, $replaceWith, $district_id);
        
        if(is_array($district_id)){
            $district_id = implode("','",$district_id);
        }
        $thirdparty = $this->clg->thirdparty;
        if($thirdparty != '1'){

            if($district_id == $post_reports['district'] || $thirdparty == $post_reports['thirdparty_type'])
            {
                $report_data = $this->inc_model->get_amb_type_new();
        foreach ($report_data as $row) {
            
            if ($post_reports['to_date'] != '') {
                $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                    'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                    'base_month' => $this->post['base_month'],
                    'thirdparty_type' => $post_reports['thirdparty_type'],
                    'amb_type_id' => $row->ambt_id,
                    'district' => $post_reports['district']);
            } else {
                $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                    'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                    'base_month' => $this->post['base_month'],
                    'thirdparty_type' => $post_reports['thirdparty_type'],
                    'district' => $post_reports['district'],
                    'amb_type_id' => $row->ambt_id
                );
            }

            $report_data_new = $this->inc_model->get_amb_data($report_args);
            $amb_data_new = $this->inc_model->get_amb_all_data($report_args);

            $report_data_dispatch = $this->inc_model->get_ambulance_dispatch_data($report_args);
            $report_data_patient = $this->inc_model->get_patient_data($report_args);
             $inc_data[] = array(
               'ambt_name'=> $row->ambt_name,
               'amb_count_active'=> $report_data_new[0]->amb_count,
               'patient_count' =>$report_data_patient[0]->inc_ref_id,
               'dispatch_count' =>$report_data_dispatch[0]->dispatch_count,
               'amb_count'=> $amb_data_new[0]->amb_count
            );
            $count++;
        }
        
            $header = array('Sr.No', 'Type of Ambulance','Count Type of ambulance','Total Case Dispatch','Patient serverd','Total Ambulance On Board'); 
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/amb_summary_report_view', $data, TRUE), $output_position , TRUE);

        }
        else{

            $header = array('District & Category Not Match'); 
            $data['header'] = $header;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/amb_summary_report_view', $data, TRUE), $output_position , TRUE);
        }

        }else{
            $report_data = $this->inc_model->get_amb_type_new();
        foreach ($report_data as $row) {
            
            if ($post_reports['to_date'] != '') {
                $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                    'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                    'base_month' => $this->post['base_month'],
                    'thirdparty_type' => $post_reports['thirdparty_type'],
                    'amb_type_id' => $row->ambt_id,
                    'district' => $post_reports['district']);
            } else {
                $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                    'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                    'base_month' => $this->post['base_month'],
                    'thirdparty_type' => $post_reports['thirdparty_type'],
                    'district' => $post_reports['district'],
                    'amb_type_id' => $row->ambt_id
                );
            }

            $report_data_new = $this->inc_model->get_amb_data($report_args);
            $amb_data_new = $this->inc_model->get_amb_all_data($report_args);

            $report_data_dispatch = $this->inc_model->get_ambulance_dispatch_data($report_args);
            $report_data_patient = $this->inc_model->get_patient_data($report_args);
             $inc_data[] = array(
               'ambt_name'=> $row->ambt_name,
               'amb_count_active'=> $report_data_new[0]->amb_count,
               'patient_count' =>$report_data_patient[0]->inc_ref_id,
               'dispatch_count' =>$report_data_dispatch[0]->dispatch_count,
               'amb_count'=> $amb_data_new[0]->amb_count
            );
            $count++;
        }
        
        $header = array('Sr.No', 'Type of Ambulance','Count Type of ambulance','Total Case Dispatch','Patient serverd','Total Ambulance On Board'); 
        $data['header'] = $header;
        $data['inc_data'] = $inc_data;
        $this->output->add_to_position($this->load->view('frontend/erc_reports/amb_summary_report_view', $data, TRUE), $output_position , TRUE);

        }
    }
    function b12_type_report() {
        $post_reports = $this->input->post();
        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month']
               
            );
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month']
               
            );
        }
       // $incient_district = $this->inc_model->get_dst($report_args);
       // foreach($incient_district as $inc)
        // {
            if ($post_reports['to_date'] != ''   ) {
                $report_args1 = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                    'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                    'base_month' => $this->post['base_month'],
                    'district' =>  $inc->dst_code
                   
                );
            } else {
                $report_args1 = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                    'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                    'base_month' => $this->post['base_month'],
                    'district' => $inc->dst_code
                  
                );
            }
            //$Accident_Data = $this->inc_model->get_b12_data_report($report_args1,array('Accident'));
            $Assault = $this->inc_model->get_b12_data_report_108($report_args1,array('Assault'));
            $Burns = $this->inc_model->get_b12_data_report_108($report_args1,array('Burn'));
            $Cardiac = $this->inc_model->get_b12_data_report_108($report_args1,array('Cardiac'));
            $Fall = $this->inc_model->get_b12_data_report_108($report_args1,array('Fall'));
            $Intoxication_Poisoning = $this->inc_model->get_b12_data_report_108($report_args1,array('Intoxication / Poisoning'));
            $Labour_Pregnancy = $this->inc_model->get_b12_data_report_108($report_args1,array('Labour / Pregnancy'));
            $Lighting_Electrocution = $this->inc_model->get_b12_data_report_108($report_args1,array('Lighting / Electrocution'));
            $Mass_casualty = $this->inc_model->get_b12_data_report_108($report_args1,array('Mass_casualty'));
            $Medical = $this->inc_model->get_b12_data_report_108($report_args1,array('Medical','Animal Attack'));
            $Poly_Trauma = $this->inc_model->get_b12_data_report_108($report_args1,array('Trauma (Vehicle)','Trauma (Non-Vehicle)'));
            $Suicide_Self_Inflicted_Injury = $this->inc_model->get_b12_data_report_108($report_args1,array('Suicide / Self Inflicted Injury'));
            $DropCall = $this->inc_model->get_b12_data_report_108($report_args1,array('DropCall'));
            $Unavail_Calls = $this->inc_model->get_b12_data_report_108($report_args1,array('Unavail_Calls'));
            $Others = $this->inc_model->get_b12_data_report_108($report_args1,array('Other'));
            
          
            $header = array('B12 Type','Assault','Burns','Cardiac','Fall','Intoxication/Poisoning','Labour/Pregnancy','Lighting/Electrocution','Mass Casualty','Medical','Poly Trauma','Suicide/Self Inflicted Injury','Others','DropCall','Unavail Call Data','Total');    
            $inc_data[]=array(
                            'dist_name'=>'Total Count',
                            //'Accident_Data' => $Accident_Data[0]->total_count,
                            'Assault' => $Assault[0]->total_count,
                            'Burns' => $Burns[0]->total_count,
                            'Cardiac' => $Cardiac[0]->total_count,
                            'Fall' => $Fall[0]->total_count,
                            'Intoxication_Poisoning' => $Intoxication_Poisoning[0]->total_count,
                            'Labour_Pregnancy' => $Labour_Pregnancy[0]->total_count,
                            'Lighting_Electrocution' => $Lighting_Electrocution[0]->total_count,
                            'Mass_casualty' => $Mass_casualty[0]->total_count,
                            'Medical' => $Medical[0]->total_count,
                            'Poly_Trauma' => $Poly_Trauma[0]->total_count,
                            'Suicide_Self_Inflicted_Injury' => $Suicide_Self_Inflicted_Injury[0]->total_count,
                            'Others'=>$Others[0]->total_count,
                            'DropCall'=>$DropCall[0]->total_count,
                            'Unavail_Calls' => $Unavail_Calls[0]->total_count,
                            
            );
            
       // }
        //var_dump($inc_data);die();
        if ($post_reports['reports'] == 'view') {



            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
         
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'b12_type_report';
         //var_dump($data['inc_data']);die;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/b12_reports_view1', $data, TRUE), 'list_table', TRUE);
        }else{
            $filename = "b12_reports.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);
            //$Accident_Data = 0;
            $Assault = 0;
            $Burns = 0;
            $Cardiac = 0;
            $Fall = 0;
            $Intoxication_Poisoning = 0;
            $Labour_Pregnancy = 0;
            $Lighting_Electrocution = 0;
            $Mass_casualty = 0;
            $Medical = 0;
            $Poly_Trauma = 0;
            $Suicide_Self_Inflicted_Injury = 0;
            $Others = 0;
            $Unavail_Calls = 0;
            $DropCall = 0;
            $count =1;
                foreach($inc_data as $inc){
                    //$Accident_Data = $Accident_Data + $inc['Accident_Data']; 
                    $Assault = $Assault + $inc['Assault']; 
                    $Burns = $Burns + $inc['Burns']; 
                    $Cardiac = $Cardiac + $inc['Cardiac']; 
                    $Fall = $Fall + $inc['Fall']; 
                    $Intoxication_Poisoning = $Intoxication_Poisoning + $inc['Intoxication_Poisoning']; 
                    $Labour_Pregnancy = $Labour_Pregnancy + $inc['Labour_Pregnancy']; 
                    $Lighting_Electrocution = $Lighting_Electrocution + $inc['Lighting_Electrocution']; 
                    $Mass_casualty = $Mass_casualty + $inc['Mass_casualty']; 
                    $Medical = $Medical + $inc['Medical']; 
                    $Poly_Trauma = $Poly_Trauma + $inc['Poly_Trauma']; 
                    $Suicide_Self_Inflicted_Injury = $Suicide_Self_Inflicted_Injury + $inc['Suicide_Self_Inflicted_Injury']; 
                    $Others = $Others + $inc['Others']; 
                    $DropCall = $DropCall + $inc['DropCall'];
                    $Unavail_Calls = $Unavail_Calls + $inc['Unavail_Calls']; 
                    $total = $Assault+$Burns+$Cardiac+$Fall+$Intoxication_Poisoning+$Labour_Pregnancy+$Lighting_Electrocution+$Mass_casualty+$Medical+$Poly_Trauma+$Suicide_Self_Inflicted_Injury+$Others+$DropCall+$Unavail_Calls; 
                    $data = array (
                    'total_count'=>'Total Count',
                   // 'Accident_data' => $inc['Accident_Data'],
                    'assault_data' =>$inc['Assault'],
                    'burn_data' => $inc['Burns'],
                    'attack_data' => $inc['Cardiac'],
                    'fall_data' => $inc['Fall'],
                    'poision_data' => $inc['Intoxication_Poisoning'],
                    'labour_data' => $inc['Labour_Pregnancy'],
                    'light_data' =>$inc['Lighting_Electrocution'],
                    'mass_data' => $inc['Mass_casualty'],
                    'report_data' => $inc['Medical'],
                    'trauma_data' => $inc['Poly_Trauma'],
                    'suicide_data' => $inc['Suicide_Self_Inflicted_Injury'],
                    'other_data' => $inc['Others'],
                    'DropCall' => $inc['DropCall'],
                    'unavail_call_data' => $inc['Unavail_Calls'],
                    'Total' => $total
                    );
                    
                    
                    
                    fputcsv($fp, $data);
                    $count++;
               
                }
                //var_dump($total_args);
    
                //$total_count = array($Accident_Data,$Assault,$Burns, $Cardiac ,$Fall, $Intoxication_Poisoning,$Labour_Pregnancy,$Lighting_Electrocution,$Mass_casualty,$Medical,$Poly_Trauma,$Suicide_Self_Inflicted_Injury,$Others,$DropCall,$Unavail_Calls);
                //fputcsv($fp, $total_count);
                    
                fclose($fp);
                exit;
        }
    }
    function b12_type_report_new_format() {
        $post_reports = $this->input->post();
        if ($post_reports['to_date'] != ''   ) {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                                'base_month' => $this->post['base_month'],
                                'sys_type' =>  '108'
                                );
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                                'base_month' => $this->post['base_month'],
                                'sys_type' => '108'
                  
                                );
        }
        $pro_data = $this->inc_model->get_b12_data_report_108($report_args);
        $drop_108 = $this->inc_model->get_drop108_data_report($report_args);
        $pick_108 = $this->inc_model->get_pickup108_data_report($report_args);
        $header = array('Sanjeevani','Count');  
        $janani_pro_im = array('11','12','24','39','45','46','65','72','73','74','75','78','79');
        $other_count =0 ;  
        $count=0;
        foreach($pro_data as $data){
            if($count<10 && $data->pro_name != 'Other' && !in_array($data->provider_impressions,$janani_pro_im)){
                    $inc_data[] =array(
                    'pro_name' => $data->pro_name,
                    'total_count' => $data->total_count
                    );
                $count++;
            }
            else{
                $other_count += $data->total_count;
                $inc_other_data[] =array(
                    'Other' => $data->Other,
                    'Other_total_count' => $other_count
                    ); 
            }
            
        }
        $IFT108_data = $this->inc_model->get_IFT_data_report($report_args);
        if ($post_reports['to_date'] != '') {
            $report_args1 = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                                'base_month' => $this->post['base_month'],
                                'sys_type' =>  '102'
                                );
        }else{
            $report_args1 = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                                'base_month' => $this->post['base_month'],
                                'sys_type' => '102'
                  
                                );
        }
        $header1 = array('JE(JANANI)','Count');
        $janani_108 = $this->inc_model->get_janani_other_data_report($report_args1);
        $IFT102_data = $this->inc_model->get_IFT_data_report($report_args1);
        $drop_data = $this->inc_model->get_Janani_data_report_drop($report_args1);
        $drop_other_count=0;
        $drop_count=0;
        foreach($drop_data as $drop_data1){
            if(in_array($drop_data1->provider_impressions,$janani_pro_im)){
                $drop_count += $drop_data1->total_count;
                $inc_drop_data[] =array(
                    'pro_name' => $drop_data1->provider_impressions,
                    'drop_count' => $drop_count
                );
            }
            else{
                $drop_other_count += $drop_data1->total_count;
                $inc_drop_other_data[] =array(
                    'Other' => 'Other',
                    'drop_other_count' => $drop_other_count
                ); 
            }
        }
        $pickup_data = $this->inc_model->get_Janani_data_report_pickup($report_args1);
        $pick_other_count=0;
        $pick_count=0;
        foreach($pickup_data as $pick_data1){
            if(in_array($pick_data1->provider_impressions,$janani_pro_im)){
                $pick_count += $pick_data1->total_count;
                $inc_drop_data[] =array(
                    'pro_name' => $pick_data1->provider_impressions,
                    'pick_count' => $pick_count
                );
            }
            else{
                $pick_other_count += $pick_data1->total_count;
                $inc_drop_other_data[] =array(
                    'Other' => 'Other',
                    'pick_other_count' => $pick_other_count
                ); 
            }
        
    }
    if($post_reports['reports'] == 'view'){
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'b12_type_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/b12_reports_view1', $data, TRUE), 'list_table', TRUE);
    }else{
        $filename = "b12_reports_new.csv";
        $fp = fopen('php://output', 'w');

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        fputcsv($fp, $header);
        
        foreach($inc_data as $inc){
            //var_dump($inc['pro_name']);
            $data = array (
                'Pro_Name' => $inc['pro_name'],
                'Count' => $inc['total_count']
            );      
            fputcsv($fp, $data);
        }
        $data_other = array (
                'Pro_Name' => 'Other',
                'Count' => $other_count + $drop_108[0]->total_count + $pick_108[0]->total_count
        );      
        fputcsv($fp, $data_other);
        
        $data_IFT_108 = array (
            'IFT108' => 'IFT108',
            'Count' => $IFT108_data[0]->total_count
        );      
        fputcsv($fp, $data_IFT_108);
        $blank = array (
            'IFT108' => '',
            'Count' => ''
        ); 
        fputcsv($fp, $blank);
        fputcsv($fp, $header1);
        $data_pick_count = array (
            'pick_count' => 'Pickup Call',
            'Count' => $pick_count
        );      
        fputcsv($fp, $data_pick_count);
        $data_drop_count= array (
            'drop_count' => 'Drop Call',
            'Count' => $drop_count
        );      
        fputcsv($fp, $data_drop_count);

        $data_other_janani_count= array (
            'Other102' => 'Other',
            'Count' => $drop_other_count + $pick_other_count + $janani_108[0]->total_count
        );      
        fputcsv($fp, $data_other_janani_count);

        $data_IFT_102 = array (
            'IFT102' => 'IFT102',
            'Count' => $IFT102_data[0]->total_count 
        );      
        fputcsv($fp, $data_IFT_102);
        fclose($fp);
        exit;
    }
}
    function b12_type_report_old() {

        $post_reports = $this->input->post();
    
        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month']
               
            );
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month']
               
            );
        }
        $incient_district = $this->inc_model->get_dst($report_args);
       
        //var_dump($imp);die;
         foreach($incient_district as $inc)
         {

            if ($post_reports['to_date'] != ''   ) {
            $report_args1 = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
                'district' =>  $inc->dst_code
               
            );
        } else {
            $report_args1 = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                'district' => $inc->dst_code
              
            );
        }
        if($post_reports['system'] != ''){
            $report_args1['system_type']=$post_reports['system'];
        }
       
       $report_data = $this->inc_model->get_medical_b12_report($report_args1);
       $other_data = $this->inc_model->get_other_b12_report($report_args1);
       $assault_data = $this->inc_model->get_assault_b12_report($report_args1);
       $labour_data = $this->inc_model->get_labour_b12_report($report_args1);
       $poision_data = $this->inc_model->get_poision_b12_report($report_args1);
       $trauma_data = $this->inc_model->get_trauma_b12_report($report_args1);
       $traumanon_data = $this->inc_model->get_traumanon_b12_report($report_args1);
       $attack_data = $this->inc_model->get_attack_b12_report($report_args1);
       $suicide_data = $this->inc_model->get_suicide_b12_report($report_args1);
       $burn_data = $this->inc_model->get_burn_b12_report($report_args1);
       $mass_data = $this->inc_model->get_mass_b12_report($report_args1);
       $light_data = $this->inc_model->get_light_b12_report($report_args1);
    // var_dump($report_data);die;
           // }
     //if ( in_array($_GET['id'], array(1, 3, 4, 5)) )
         $amb_off_road_data = array();
        $b12_type = array();
        
    //    // $incient_district = $this->inc_model->get_district_by_id($district);
        $type_of_emergency = array('0' => 'Medical',
        '1' => 'Other',
            '2' => 'Â Assault',
       
            '3' => 'Â Labour/ Pregnancy',
            '4' => 'Intoxication/Poisoning',
            '5' => 'Lightning/Electrocution',
            '6' => 'Trauma (Vehicle)',
            '7' => 'Trauma ( Non-Vehicle)',
            '8' => 'Animal Attack',
            '9' => 'Suicide/Self Inflicted Injury',
            '10' => 'Â Burns',
            '11' => 'Mass casualty',
            );
            $header = array('District','Medical','Other','Assault','Labour/ Pregnancy','Intoxication/Poisoning','Lighting/Electrocution','Trauma (Vehicle)','Trauma (Non-Vehicle)','Animal Attack','Suicide/Self Inflicted Injury','Burns','Mass casualty');    
    
    $inc_data[]=array('dist_name'=>$inc->dst_name,
                      'medical' => $report_data[0]->total_count,
                      'other' =>$other_data[0]->total_count,
                      'assault' => $assault_data[0]->total_count,
                      'labour' => $labour_data[0]->total_count,
                      'trauma' => $trauma_data[0]->total_count,
                      'traumanon' => $traumanon_data[0]->total_count,
                      'suicide' => $suicide_data[0]->total_count,
                      'burn' => $burn_data[0]->total_count,
                      'mass' => $mass_data[0]->total_count,
                      'light' => $light_data[0]->total_count,
                      'poision' => $poision_data[0]->total_count,
                      'attack' => $attack_data[0]->total_count,
                      
);                  
  // var_dump($inc_data);die;
        }
   //  }
    
         if ($post_reports['reports'] == 'view') {



            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
         
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'b12_type_report';
         //var_dump($data['inc_data']);die;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/b12_reports_view1', $data, TRUE), 'list_table', TRUE);
        } else {

            $filename = "b12_reports.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);
            $medical =0;
            $other =0;
            $assault =0;
            $poision =0;
            $light=0;
            $trauma =0;
            $traumanon =0;
            $attack =0;
            $suicide =0;
            $burn =0;
            $mass =0;
            $labour =0;
                foreach($inc_data as $inc){
                        //var_dump($inc);
                        
                    $data = array ('dist_name'=>$inc['dist_name'],
                    'medical' => $inc['medical'],
                    'other' =>$inc['other'],
                    'assault' => $inc['assault'],
                    'labour' => $inc['labour'],
                    'poision' => $inc['poision'],
                    'light' => $inc['light'],
                    'trauma' => $inc['trauma'],
                    'traumanon' =>$inc['traumanon'],
                    'attack' => $inc['attack'],
                    'suicide' => $inc['suicide'],
                    'burn' => $inc['burn'],
                    'mass' => $inc['mass']
                    );
                    
                    $medical = $medical + $inc['medical']; 
                    $other= $other + $inc['other']; 
                    $assault = $assault + $inc['assault'];
                    $labour = $labour + $inc['labour'];
                    $poision = $poision + $inc['poision'];
                    $light = $light + $inc['light'];
                    $trauma = $trauma + $inc['trauma'];
                    $traumanon = $traumanon + $inc['traumanon'];
                    $attack = $attack + $inc['attack']; 
                    $suicide = $suicide + $inc['suicide']; 
                    $burn = $burn + $inc['burn'];
                    $mass = $mass + $inc['mass'];
                    fputcsv($fp, $data);
                    $count++;
               
                }
    //var_dump($total_args);
    
                $total_count = array('Total',$medical,$other,$assault, $labour ,$poision, $light,$trauma,$traumanon,$attack,$suicide,$burn,$mass);
                fputcsv($fp, $total_count);
                    
                fclose($fp);
                exit;
            }
        }
            
    function details_disclo_summary_report(){
        $post_reports = $this->input->post();
        $data['dist'] = $post_reports['dist'];
        $data['divs'] = $post_reports['divs'];
        //var_dump($post_reports);
        //var_dump($data['dist']);
        if($data['divs']=='All')
        {
            if($data['dist'] == 'All'){
                $zone = '';
                $dist ='';
            }
            else{
                $zone = '';
                $dist = $data['dist'];
            }
        }else{
            $zone = $data['divs'];
            if($data['dist'] == 'All'){
                $data = $this->common_model->get_dist_lists($zone);
                foreach($data as $row){
                   $dist_array[] = $row['dst_code'];;
                }
                //$dist = implode(',',$dist_code);
                //var_dump($dist_code_list);
            }else{
                $dist = $data['dist'];
            }
        }
        
        $report_type = $this->input->post('disclo_summary_report_type');
        $from_date = date('Y-m-d 00:00:00', strtotime($post_reports['from_date']));
        $to_date = date('Y-m-d 23:59:59', strtotime($post_reports['to_date']));
        $period = new DatePeriod(
            new DateTime($from_date),
            new DateInterval('P1D'),
            new DateTime($to_date)
        );
        
        foreach ($period as $key => $value) {
            $date = $value->format('Y-m-d') ; 
            
            $report_args = array(
                'date' => date('Y-m-d', strtotime($date)),
                'div' => $zone,
                'dist' => $dist,
                'dist_array'=> $dist_array
            );
            $total_dispatch = $this->dashboard_model_final_updated->get_dispatch_closure_summary_data($report_args);
            $closed_by_mdt = $this->dashboard_model_final_updated->get_closed_by_mdt_summary_data($report_args);
            $closed_by_dco = $this->dashboard_model_final_updated->get_closed_by_dco_summary_data($report_args);
            $validate_by_dco = $this->dashboard_model_final_updated->get_validate_by_dco_summary_data($report_args);
            $Pending_calls = $this->dashboard_model_final_updated->get_pending_closure_summary_data($report_args);
           if($total_dispatch != 0){
            //$percentage = (($closed_by_mdt+$closed_by_dco)/$total_dispatch)*100;
            $percentage = (($validate_by_dco)/$total_dispatch)*100;
            $percentage = round($percentage,2);
           }else{
            $percentage =0;
           }
            $data1[] =array(
                'date' => date('Y-m-d', strtotime($date)),
                'Total_Dispatch' => $total_dispatch,
                'Closed_By_MDT' => $closed_by_mdt,
                'Closed_By_DCO' => $closed_by_dco,
                'validate_By_DCO' => $validate_by_dco,
                'Pending_calls' => $Pending_calls,
                'Percentage' => $percentage
            );
        }
        $header = array('Sr.No','Date','Total Dispatch', 'Closed By MDT', 'Closed By DCO', 'Validate By DCO', 'Pending Calls', 'Percentage');
        
        $filename = "Dispatch_closure_summary_report.csv";
        $fp = fopen('php://output', 'w');

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        fputcsv($fp, $header);
        $count=1;
        foreach($data1 as $inc){
            $data = array (
                'Sr.No' => $count,
                'date' => $inc['date'],
                'Total_Dispatch' => $inc['Total_Dispatch'],
                'Closed_By_MDT' => $inc['Closed_By_MDT'],
                'Closed_By_DCO' => $inc['Closed_By_DCO'],
                'validate_By_DCO' => $inc['validate_By_DCO'],
                'Pending_calls' => $inc['Pending_calls'],
                'Percentage' => $inc['Percentage'],
            );      
            fputcsv($fp, $data);
            $count++;
        }
        fclose($fp);
        exit;
    }

    function details_amb_onroad_offroad_report() {
        $post_reports = $this->input->post();

        $data['dist'] = $this->input->post('onroad_report_type_dist');
        $data['divs'] = $this->input->post('onroad_report_type_divs');
        $report_type = $this->input->post('onroad_report_type');
        // if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
            'base_month' => $post_reports['from_datess'],
            'system' => $post_reports['system'],
            'dist' => $post_reports['onroad_report_type_dist'],
            'zone' => $post_reports['onroad_report_type_divs'],
            'report_type' => $post_reports['onroad_report_type'],
            'datewise' => $post_reports['offroad_report_type'],
            'base_month' => $this->post['base_month'],
            'amb_status' => '7,8',
            'amb_emso_status' => '1,9');
            // print_r($report_args);die;
        // } else {
            // $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            //     'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
            //     'base_month' => $this->post['base_month'],
            //     'amb_status' => '7,8',
            //     'amb_emso_status' => '1,9');
        // }


        // if ($post_reports['incient_district'] != '') {
            
        //     $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
        //         'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
        //         'district_code' => $post_reports['incient_district'],
        //         'base_month' => $this->post['base_month'],
        //         'amb_status' => '7,8',
        //         'amb_emso_status' => '1,9');
            
        // }
       
        // print_r($report_args); 
        // die();
        $header = array('Sr.No','Zone', 'District', 'Ambulance No', 'Type', 'Off-road Remark', 'Off-road Date','Off-road Time', 'On-road Remark', 'On-road Date','On-road Time', 'Remark', 'System Added Date', 'System Update date');
     
        $report_data = $this->ambmain_model->get_ambulance_onroad_offroad_report($report_args);
     

        if ($post_reports['reports'] == 'view') {

            $data['header'] = $header;
            $data['inc_data'] = $report_data;
            $data['report_args'] = $report_args;

            $this->output->add_to_position($this->load->view('frontend/erc_reports/details_report_onroad_ofroad_view', $data, TRUE), 'list_table', TRUE);
        } else {

            $filename = "Ambulance_onroad_offroad_Report.csv";
            $fp = fopen('php://output', 'w');


            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $data = array();
            $count = 1;
            foreach($report_data as $key => $amb_data) {
                
                if($amb_data->mt_on_stnd_remark == 'ambulance_onroad'){
                    $on_road_remark = 'Ambulance On-road';
                }else{
                    $on_road_remark=$amb_data->mt_on_stnd_remark;
                }
                if($amb_data->mt_stnd_remark == 'Ambulance_offroad'){
                    $off_road_remark = 'Ambulance Off-road';
                }else{
                    $off_road_remark=$amb_data->mt_stnd_remark;
                }
         
                $row['count'] = $count;
                $row['div_name'] = $amb_data->div_name;
                $row['dst_name'] = $amb_data->dst_name;
                $row['amb_rto_register_no'] = $amb_data->mt_amb_no;
                $row['type'] = $amb_data->ambt_name;
                $row['off_road_remark'] = $off_road_remark;
                $row['off_road_date_date'] = date('Y-m-d',strtotime($amb_data->mt_offroad_datetime));
                $row['off_road_date_time'] = date('H:i:s',strtotime($amb_data->mt_offroad_datetime));
                $row['on_road_remark'] = $on_road_remark;
                $row['on_road_date_date'] = date('Y-m-d',strtotime($amb_data->mt_onroad_datetime));
                $row['on_road_date_time'] = date('H:i:s',strtotime($amb_data->mt_onroad_datetime));
                $row['remark'] =  $amb_data->mt_remark;
                $row['added_date'] = $amb_data->mt_added_date;
                $row['modify_date'] = $amb_data->mt_modify_date;
                $count++;
                fputcsv($fp, $row);
            }

            fclose($fp);
            exit;
        }
    }

    function amb_onroad_offroad_report() {
        $post_reports = $this->input->post();

        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
                'amb_status' => '7,8',
                'amb_emso_status' => '1,9');
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                'amb_status' => '7,8',
                'amb_emso_status' => '1,9');
        }


        if ($post_reports['incient_district'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'district_code' => $post_reports['incient_district'],
                'base_month' => $this->post['base_month'],
                'amb_status' => '7,8',
                'amb_emso_status' => '1,9');
        }


        $header = array('Sr.No', 'Ambulance No','Type', 'District','Off-road date','Off-road time','On-road date','On-road time','System added date','System Updated date','Remark', 'Total Hour in Month', 'No of Off-road hour during Month', 'No of On-road hour during Month');
        $report_data = $this->inc_model->get_amb_status_summary_date($report_args);


        $amb_off_road_data = array();

        $seconds_in_month = strtotime($report_args['to_date'] . ' 24:00:00') - strtotime($report_args['from_date'] . ' 00:00:00');

        $H = floor($seconds_in_month / 3600);
        $i = ($seconds_in_month / 60) % 60;
        $s = $seconds_in_month % 60;
        $totol_hour_in_month = sprintf("%02d:%02d:%02d", $H, $i, $s);


        foreach ($report_data as $report) {

            $amb_off_road_data[$report['amb_rto_register_no']]['total_hour'] = $totol_hour_in_month;
            $amb_off_road_data[$report['amb_rto_register_no']]['dst_name']=$report['dst_name'];
            $amb_off_road_data[$report['amb_rto_register_no']]['hp_name']=$report['hp_name'];
            $amb_off_road_data[$report['amb_rto_register_no']]['ambt_name']=$report['ambt_name'];

            $off_road_date = $report['off_road_date'];
            $off_road_time = $report['off_road_time'];

            $on_road_date = $report['on_road_date'];
            $on_road_time = $report['on_road_time'];
            
            //$off_road = $report['mt_offroad_datetime'];
            //$on_road = $report['mt_onroad_datetime'];

            $off_road = strtotime($off_road_date . ' ' . $off_road_time);

            $on_road = strtotime($on_road_date . ' ' . $on_road_time);
            $time_diff = $on_road - $off_road;
            if ($time_diff > 0) {

                $amb_off_road_data[$report['amb_rto_register_no']]['off_road'] += $time_diff;
            }
            $amb_off_road_data[$report['amb_rto_register_no']]['on_road'] = $seconds_in_month - $amb_off_road_data[$report['amb_rto_register_no']]['off_road'];
            $amb_off_road_data[$report['amb_rto_register_no']]['total_hour_second'] = $seconds_in_month;
            $amb_off_road_data[$report['amb_rto_register_no']]['dst_name'] = $report['dst_name'];
        }


        if ($post_reports['reports'] == 'view') {



            $data['header'] = $header;
            $data['inc_data'] = $report_data;
            $data['report_args'] = $report_args;

            $this->output->add_to_position($this->load->view('frontend/erc_reports/onroad_ofroad_view', $data, TRUE), 'list_table', TRUE);
        } else {

            $filename = "Ambulance_onroad_offroad_Report.csv";
            $fp = fopen('php://output', 'w');


            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $data = array();
            $count = 1;
            foreach ($amb_off_road_data as $key => $amb_data) {
                $row['count'] = $count;
                $row['amb_rto_register_no'] = $key;
                $row['base_location'] = $amb_data['dst_name'];
                $row['total_hour'] = $amb_data['total_hour'];
                $off_road_seconds = $amb_data['off_road'];
                $H = floor($off_road_seconds / 3600);
                $i = ($off_road_seconds / 60) % 60;
                $s = $off_road_seconds % 60;
                $off_road = sprintf("%02d:%02d:%02d", $H, $i, $s);
                $row['off_road'] = $off_road;

                $on_road_seconds = $amb_data['on_road'];
                $on_H = floor($on_road_seconds / 3600);
                $on_i = ($on_road_seconds / 60) % 60;
                $on_s = $on_road_seconds % 60;
                $on_road = sprintf("%02d:%02d:%02d", $on_H, $on_i, $on_s);
                $row['on_road'] = $on_road;
                

//                $on_road_seconds = $amb_data['off_road'];
//                $on_H = floor($on_road_seconds / 3600);
//                $on_i = ($on_road_seconds / 60) % 60;
//                $on_s = $on_road_seconds % 60;
//                $break_down = sprintf("%02d:%02d:%02d", $on_H, $on_i, $on_s);
//                $row['break_down'] = $break_down;

                fputcsv($fp, $row);
            }

            fclose($fp);
            exit;
        }
    }
    
    function amb_district_onroad_offroad_report() {
        $post_reports = $this->input->post();
        $data['dist'] = $this->input->post('onroad_report_type_dist');
        $data['divs'] = $this->input->post('onroad_report_type_divs');
        $report_type = $this->input->post('onroad_report_type');
        // print_r($post_reports['to_date']);die;
        // if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $post_reports['base_month'],
                'system' => $post_reports['system'],
                'dist' => $post_reports['onroad_report_type_dist'],
                'zone' => $post_reports['onroad_report_type_divs'],
                'report_type' => $post_reports['onroad_report_type'],
                'datewise' => $post_reports['offroad_report_type'],
                'amb_status' => '7,8',
                'amb_emso_status' => '1,9');
                // print_r($report_args);die;
        // } else {
        //     $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
        //         'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
        //         'base_month' => $this->post['base_month'],
        //         'amb_status' => '7,8',
        //         'amb_emso_status' => '1,9');
        // }


        // if ($post_reports['incient_district'] != '') {
        //     $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
        //         'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
        //         'district_code' => $post_reports['incient_district'],
        //         'base_month' => $this->post['base_month'],
        //         'amb_status' => '7,8',
        //         'amb_emso_status' => '1,9');
        // }


        $header = array('Sr.No','Zone','District','Base location','Ambulance No','Type','Total Hour in month','No of off-road hour during month','No of On-road hour during month','Total uptime in month');
        
        $report_data = $this->ambmain_model->get_ambulance_onroad_offroad_report($report_args);

        $amb_off_road_data = array();

        $seconds_in_month = strtotime($report_args['to_date'] . ' 24:00:00') - strtotime($report_args['from_date'] . ' 00:00:00');

        $H = floor($seconds_in_month / 3600);
        $i = ($seconds_in_month / 60) % 60;
        $s = $seconds_in_month % 60;
        $totol_hour_in_month = sprintf("%02d:%02d:%02d", $H, $i, $s);


        foreach ($report_data as $report) {
            // print_r($report);die;
            $amb_off_road_data[$report->mt_amb_no]['div_name']=$report->div_name;
            $amb_off_road_data[$report->mt_amb_no]['dst_name']=$report->dst_name;
            $amb_off_road_data[$report->mt_amb_no]['hp_name']=$report->hp_name;
            $amb_off_road_data[$report->mt_amb_no]['ambt_name']=$report->ambt_name;
            $amb_off_road_data[$report->mt_amb_no]['total_hour'] = $totol_hour_in_month;

            $off_road_date = $report->off_road_date;
            $off_road_time = $report->off_road_time;

            $on_road_date = $report->on_road_date;
            $on_road_time = $report->on_road_time;
            
            $off_road = strtotime($report->mt_offroad_datetime);
            $on_road = strtotime($report->mt_onroad_datetime);

            //$off_road = strtotime($off_road_date . ' ' . $off_road_time);

           // $on_road = strtotime($on_road_date . ' ' . $on_road_time);
            $time_diff = $on_road - $off_road;
            if ($time_diff > 0) {

                $amb_off_road_data[$report->mt_amb_no]['off_road'] += $time_diff;
            }
            $amb_off_road_data[$report->mt_amb_no]['on_road'] = $seconds_in_month - $amb_off_road_data[$report->mt_amb_no]['off_road'];
            $amb_off_road_data[$report->mt_amb_no]['total_hour_second'] = $seconds_in_month;
            
            if( $amb_off_road_data[$report->mt_amb_no]['on_road'] >0){  
                    $up_time = ( $amb_off_road_data[$report->mt_amb_no]['on_road']/$seconds_in_month)*100;       
            }
            $amb_off_road_data[$report->mt_amb_no]['up_time'] = $up_time;
        }
      // var_dump($amb_off_road_data);die();
  
        if ($post_reports['reports'] == 'view') {
            $data['header'] = $header;
            $data['inc_data'] = $amb_off_road_data;
            $data['report_args'] = $report_args;
            // print_r($data);die;            
            $this->output->add_to_position($this->load->view('frontend/erc_reports/district_onroad_ofroad_view', $data, TRUE), 'list_table', TRUE);
        } else {

            $filename = "Ambulance_onroad_offroad_Report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $data = array();
            $count = 1;
            foreach ($amb_off_road_data as $key => $amb_data) {
               
                $row['count'] = $count++;
                $row['div_name'] = $amb_data['div_name'];
                $row['dst_name'] = $amb_data['dst_name'];
                $row['base_location'] = $amb_data['hp_name'];
                $row['amb_rto_register_no'] = $key;
                $row['ambt_name'] = $amb_data['ambt_name'];
                
                $row['total_hour'] = $amb_data['total_hour'];
                $off_road_seconds = $amb_data['off_road'];
                $H = floor($off_road_seconds / 3600);
                $i = ($off_road_seconds / 60) % 60;
                $s = $off_road_seconds % 60;
                $off_road = sprintf("%02d:%02d:%02d", $H, $i, $s);
                $row['off_road'] = $off_road;

                $on_road_seconds = $amb_data['on_road'];
                $on_H = floor($on_road_seconds / 3600);
                $on_i = ($on_road_seconds / 60) % 60;
                $on_s = $on_road_seconds % 60;
                $on_road = sprintf("%02d:%02d:%02d", $on_H, $on_i, $on_s);
                $row['on_road'] = $on_road;
                if($amb_data['on_road'] > 0 ){  
                    $up_time = ($amb_data['on_road']/$seconds_in_month)*100; 
                    $up_H = floor($up_time / 3600);
                    $up_i = ($up_time / 60) % 60;
                    $up_s = $up_time % 60;
                    $on_up_time = sprintf("%02d:%02d:%02d", $up_H, $up_i, $up_s);
                
                }
                $row['up_time'] = round($up_time,2);

//                $on_road_seconds = $amb_data['off_road'];
//                $on_H = floor($on_road_seconds / 3600);
//                $on_i = ($on_road_seconds / 60) % 60;
//                $on_s = $on_road_seconds % 60;
//                $break_down = sprintf("%02d:%02d:%02d", $on_H, $on_i, $on_s);
//                $row['break_down'] = $break_down;

                fputcsv($fp, $row);
            }

            fclose($fp);
            exit;
        }
    }

    public function save_export_ercp_report() {

        $post_reports = $this->input->post();

        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
                'inc_system_type' => $post_reports['system']
            );
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                'inc_system_type' => $post_reports['system']
            );
        }

        $report_data = $this->Medadv_model->get_inc_report_by_ercp($report_args);
        //var_dump($report_data);die;

        $header = array(
            'Sr.No',
            'Incident ID',
            'Patient Name',
            'Age',
            'Gender',
            'Call Type',
            'LOC',
            'GCS',
            'Pupils Left',
            'Pupils Right',
            'Pulse',
            'BP Sys',
            'BP Dia',
            'RR',
            'O2Sat',
            'Temp',
            'BSL',
            'Pro Dia',
            //'Medical Adv. Question',
            'ERCP Additional Info',
            'ERCP ID',
            'Closure Status',
            'Inc DateTime',
            'Added By Name',
            'Added Date'
        );

        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            foreach ($report_data as $row) {
                //if($row->atnd_date != NULL){
                  /*  $duration = "";
                    if($row->atnd_date != '' ){
                    $d1= new DateTime($row->atnd_date);
                $d2=new DateTime($row->adv_cl_date);
                $duration=$d2->diff($d1);
                //var_dump($duration);die;
                    }
                   if($duration != NULL){
                   $duration = $duration->h . ':' . $duration->i . ':' . $duration->s;
                   }
                   else{
                       $duration= "00:00:00";
                   } */
                   if($row->ptn_fullname == NUll){
                         $name=$row->ptn_fname.' '.$row->ptn_lname;
                   }
                   else{
                       $name= $row->ptn_fullname;
                   }
                
                $inc_data[] = array(
                    'adv_inc_ref_id' => $row->adv_inc_ref_id,
                    'ptn_fullname' => $name,
                    'ptn_age' => $row->ptn_age,
                    'ptn_gender' => $row->ptn_gender,
                    'inc_type' => ucwords($row->inc_type),
                    'ct_type' => $row->que_question,
                    'atnd_date' => $row->atnd_date,
                    'clr_mobile' => $row->clr_mobile,
                    'dst_name' => $row->dst_name,
                    'adv_emt' => $row->adv_emt,
                    'adv_cl_date' => $row->adv_cl_date,
                    'adv_cl_ercp_addinfo' => $row->adv_cl_ercp_addinfo,
                    'inc_pcr_status' => $row->inc_pcr_status
                );
            }

        
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['submit_funtion'] = 'save_export_ercp_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ercp_inc_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "ercp_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            $count=1;
            foreach ($report_data as $row) {

                if($row->inc_pcr_status == '1'){
                    $status = "Closed";
                } 
                else{
                    $status = "Pending"; 
                }
                $inc_datetime = date('Y-m-d H:i:s',strtotime($row->inc_datetime));
                //$inc_time = date('H:i:s',strtotime($row->adv_cl_date));
               /* if($row->atnd_date != NULL){
                    $inc_receive_date = date('Y-m-d',strtotime($row->atnd_date));
                    $inc_receive_time = date('H:i:s',strtotime($row->atnd_date));
                    $final_date = $inc_receive_date.'-'.$inc_receive_time;
                }
                else{
                        $final_date="";
                        
                }
                if($row->atnd_date != NULL){
                        $d1= new DateTime($row->atnd_date);
                        
    
                    $d2=new DateTime($row->adv_cl_date);
                    $duration=$d2->diff($d1);
               // var_dump($atnd_date);
                        
                       //if($duration != NULL){
                       $duration = $duration->h . ':' . $duration->i . ':' . $duration->s;
                       }
                       else{
                        $duration = '00:00:00';
                       }
                       */
                       if($row->ptn_fullname == NUll){
                        $name=$row->ptn_fname.' '.$row->ptn_lname;
                  }
                  else{
                      $name= $row->ptn_fullname;
                  }
                  if($row->adv_cl_loc_level != '')
                  {
                    $LOC = get_loc_level($row->adv_cl_loc_level);
                  }else{
                    $LOC = '';
                  }
                  if($row->adv_cl_pup_left != ''){
                    $pup_left = get_pupil_name($row->adv_cl_pup_left);
                  }else{
                    $pup_left = '';
                  }
                  if($row->adv_cl_pup_right != ''){
                    $pup_right = get_pupil_name($row->adv_cl_pup_right);
                  }else{
                    $pup_right = '';
                  }
                  if($row->ptn_gender == 'M')
                  {
                    $gender = 'Male';
                  }if($row->ptn_gender == 'F'){
                    $gender = 'Female';
                  }else{
                    $gender = 'Transgender';
                  }
                //var_dump($duration);
                $inc_data = array(
                    'Sr_NO' => $count,
                    'inc_ref_id' => $row->adv_inc_ref_id,
                    'ptn_fullname' => $name,
                    'ptn_age' => $row->ptn_age,
                    'ptn_gender' => $gender,
                    'inc_type' => get_purpose_of_call($row->inc_type),
                    'adv_cl_loc_level' => $LOC,
                    'GCS' => $row->adv_cl_gcs_score,
                    'Pupils_Left' => $pup_left,
                    'Pupils_Right' => $pup_right,
                    'Pulse' => $row->adv_cl_pulse,
                    'BP_Sys' => $row->adv_cl_bp_sy,
                    'BP_Dia' => $row->adv_cl_bp_dia,
                    'RR' => $row->adv_cl_rr,
                    'O2Sat' => $row->adv_cl_o2sats,
                    'Temp' => $row->adv_cl_temp,
                    'BSL' => $row->adv_cl_bslr,
                    'Pro_Dia' => $row->adv_cl_pro_dia,
                   // 'Medical_Adv_Question' => $row->adv_cl_madv_que,
                    'ERCP_Additional_Info' => $row->adv_cl_ercp_addinfo,
                    'ERCP_Advice' => $row->adv_emt,
                    'Closure Status' => $status,
                    'Inc added Date' => $inc_datetime,
                    'Added By Name' => get_clg_name_by_ref_id($row->adv_cl_added_by) ,
                    'Added Date' => $row->atnd_date
                );
                $count++;
                fputcsv($fp, $inc_data);
            }
           // var_dump($inc_data);die();
            fclose($fp);
            exit;
        }
    }

    public function save_export_tans_patient() {

        $post_reports = $this->input->post();
        
        $report_type = $this->input->post('ptn_report_type');
        $data['ptn_report_type'] = $report_type;
        

        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'system' =>$post_reports['system'],
                'base_month' => $this->post['base_month']);
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'system' =>$post_reports['system'],
                'base_month' => $this->post['base_month']);
        }


        //$report_data = $this->inc_model->get_patient_epcr_report_by_date($report_args);
        
        $patient_data = $this->inc_model->get_patient_by_provider_impression($report_args);

        $total_inc = $this->inc_model->get_inc_total($report_args);
        $total_calls = $total_inc[0]->total_calls;
        
        
        $arg_data = array('inc_added_by'=>$erodata->clg_ref_id,
             'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
            'system' =>$post_reports['system'],
                 'inc_type'=>"NON_MCI','AD_SUP_REQ','DROP_BACK','IN_HO_P_TR','MCI','EMT_MED_AD','PREGANCY_CALL','VIP_CALL','Child_CARE_CALL','on_scene_care','PICK_UP");

        
        $total_count_eme = get_inc_total_by_user($arg_data);

        $amb_args['get_count'] = TRUE;
        $total_amb = $this->amb_model->get_tdd_total_amb();

        $report_args['get_count'] = TRUE;

         if($report_type == '2'){
            $header = array('Month', 'No $total_count_eme of ambulance', 'Total Calls', 'Total Emergencies Calls', 'Total Emergencies Attended');
         }else{
             $header = array('No of ambulance', 'Total Calls', 'Total Emergencies Calls', 'Total Emergencies Attended');
         }
         
        $row = array();
        if($report_type == '2'){
            $row['month'] = $patient_data['month'];
        }
        $row['no_amb'] = $total_amb;
        $row['total_calls'] = $total_calls;
        $row['total_emergency_calls'] = $total_count_eme?$total_count_eme:0; 
        $row['attend_calls'] = $total_count_eme?$total_count_eme:0;
            
             
        foreach($patient_data as $patient){
            $header[] = $patient->pro_name;
            $row[$patient->pro_name] = $patient->total_imp;
        }
        


        if ($post_reports['reports'] == 'view') {
            
            $data['header'] = $header;
            $data['inc_data'] = $row;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ptn_trans_report_view', $data, TRUE), 'list_table', TRUE);
            
        } else {

            $filename = "patient_trans_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            fputcsv($fp, $row);
            fclose($fp);
            exit;
        }
    }
    function save_export_onroad_offroad()
    {
        $post_reports = $this->input->post();
        // print_r($post_reports);die();
        // $maintenance_type = $this->input->post('maintenance_type');
        $data['dist'] = $this->input->post('onroad_report_type_dist');
        $data['divs'] = $this->input->post('onroad_report_type_divs');
        $report_type = $this->input->post('onroad_report_type');
        // print_r($post_reports['output_position']);die;
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        // if ($post_reports['to_date'] != '') {

            $report_args = array(
                'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $post_reports['base_month'],
                'system' => $post_reports['system'],
                'dist' => $post_reports['onroad_report_type_dist'],
                'zone' => $post_reports['onroad_report_type_divs'],
                'report_type' => $post_reports['onroad_report_type'],
                'datewise' => $post_reports['offroad_report_type']
            );
        // } else {

            // $report_args = array(
            //     'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            //     'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
            //     'base_month' => $this->post['base_month']
            // );
        // }
        //$report_data = $this->ambmain_model->get_onoff_data_only($report_args);
        $general_offroad = $this->ambmain_model->get_onoff_data_only($report_args);//ems_amb_onroad_offroad
        $accidental = $this->ambmain_model->get_accidental_data_only($report_args);//ems_amb_accidental_maintaince
        $preventive = $this->ambmain_model->get_preventive_data_only($report_args);//ems_ambulance_preventive_maintaince
        $tyre = $this->ambmain_model->get_tyre_data_only($report_args);//ems_amb_tyre_maintaince
        $breakdown = $this->ambmain_model->get_breakdown_data_only($report_args);//ems_amb_breakdown_maintaince
        $manpower = $this->ambmain_model->get_manpower_data_only($report_args);//ems_manpower_offroad
        /*foreach($general_offroad as $general_offroad_data)
        {
            $general_offroad_re = array( 
                                    'offroad_maintance_ID' => $general_offroad_data->mt_onoffroad_id,
                                    'offroad_no' => $general_offroad_data->mt_amb_no,
                                    'offroad_type' => 'General Offroad Maintenance'
                                );
        }
        foreach($accidental as $accidental_data)
        {
            $accidental_data_re = array( 
                                    'accidental_maintance_ID' => $accidental_data->mt_accidental_id,
                                    'accidental_no' => $accidental_data->mt_amb_no,
                                    'accidental_type' => 'Accidental Maintenance'
                                );
        }
        foreach($preventive as $preventive_data)
        {
            $preventive_data_re = array( 
                                    'preventive_maintance_ID' => $preventive_data->mt_preventive_id,
                                    'preventive_amb_no' => $preventive_data->mt_amb_no,
                                    'preventive_type' => 'Schedule Maintenance'
                                );
        }
        foreach($tyre as $tyre_data)
        {
            $tyre_data_re = array( 
                                    'tyre_maintance_ID' => $tyre_data->mt_tyre_id,
                                    'tyre__amb_no' => $tyre_data->mt_amb_no,
                                    'tyre_type' => 'Tyre Maintenance'
                                );
        }
        foreach($breakdown as $breakdown_data)
        {
            $breakdown_data_re = array( 
                                    'breakdown_maintance_ID' => $breakdown_data->mt_breakdown_id,
                                    'breakdown_amb_no' => $breakdown_data->mt_amb_no,
                                    'breakdown_type' => 'Breakdown Maintenance'
                                );
        }
        foreach($manpower as $manpower_data)
        {
            $manpower_data_re = array( 
                                    'manpower_maintance_ID' => $manpower_data->mt_manpower_id,
                                    'manpower_amb_no' => $manpower_data->mt_amb_no,
                                    'manpower_type' => 'Manpower Maintenance'
                                );
        }*/
        //if (!$general_offroad_re && !$accidental_data_re && !$preventive_data_re && !$tyre_data_re && !$breakdown_data_re && !$manpower_data_re) {
        //$maintaince_data = array_merge($general_offroad_re,$accidental_data_re,$preventive_data_re,$tyre_data_re,$breakdown_data_re,$manpower_data_re);
       // } 
        $header = array('Sr.No','Request ID','Zone','District','Base Location', 'Ambulance Number','Ambulance Model' , 'Ambulance Type','Off Road DateTime', 'Exp. On-Road Date','Ambulance Offroad Day','Request Status','Off Road Type','Off-Road Remark','General Offroad Reason','On Offroad Reason','On road Datetime','On road Remark','Added By','Ambulance Status','Fleet remark if any');

        $main_file_name = strtotime($post_reports['from_date']);
        $filename = "maintenance_" . $main_file_name . ".csv";
        $this->output->set_focus_to = "inc_ref_id";
        if ($post_reports['reports'] == 'view') {

            $data['header'] = $header;
            $data['general_offroad_re'] = $general_offroad;
            $data['accidental_data_re'] = $accidental;
            $data['preventive_data_re'] = $preventive;
            $data['tyre_data_re'] = $tyre;
            $data['breakdown_data_re'] = $breakdown;
            $data['manpower_data_re'] = $manpower;
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'save_export_onroad_offroad';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/export_onroad_offroad_view', $data, TRUE), 'list_table', TRUE);
        } else {
            //var_dump("hii");die();
            $filename = "export_onroad_offroad_report.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $count = 1;

            foreach ($general_offroad as $row) {
                if($row->mt_district_id!= ' '){
                    $current_district = get_district_by_id($row->mt_district_id);
                }
                if($row->amb_type != '' || $row->amb_type != 0 ){ 
                    $amb_type =  show_amb_type_name($row->amb_type);
                }
                $amb_model =  show_amb_model_name($row->mt_amb_no);
                //$amb_status =  show_amb_staus($main_data->mt_amb_no);
                if($row->amb_status == '1' || $row->amb_status=='2'){
                    $amb_status = 'On-Road';
                }else{
                    $amb_status = 'Off-Road';
                }
                $start_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->mt_offroad_datetime)));  
                if($row->mt_offroad_datetime!='' && $row->mt_offroad_datetime != '1970-01-01 05:30:00' && $row->mt_offroad_datetime != '0000-00-00 00:00:00'){
                if($row->mt_onroad_datetime != '' && $row->mt_onroad_datetime != '1970-01-01 05:30:00' && $row->mt_onroad_datetime != '0000-00-00 00:00:00'){
                    $end_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->mt_onroad_datetime))); 
                }else{
                    $end_date = new DateTime(date('Y-m-d H:i:s')); 
                }
                $duration = '0';
                if(strtotime($row->mt_offroad_datetime) < strtotime($row->mt_onroad_datetime)){
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }else{
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }
            }else{
                $duration = '0';
            }
                $added_by_name = $row->first_name." ".$row->mid_name." ". $row->last_name;
                $data = array(
                    'Sr.No' => $count,
                    'mt_onoffroad_id' => $row->mt_onoffroad_id,
                    'div_name' => $row->div_name,
                    'current_district' => $current_district,
                    'mt_base_loc' => $row->mt_base_loc,
                    'mt_amb_no' => $row->mt_amb_no,
                    'amb_model' => $amb_model,
                    'amb_type' => $amb_type,
                    'mt_offroad_datetime' => $row->mt_offroad_datetime,
                    'mt_ex_onroad_datetime' => $row->mt_ex_onroad_datetime,
                    'duration' => $duration,
                    'mt_ambulance_status' => $row->mt_ambulance_status,
                    'General' => 'General Offroad',
                    'mt_remark' => $row->mt_remark,
                    'mt_offroad_reason' => $row->mt_offroad_reason,
                    'mt_other_offroad_reason' => $row->mt_other_offroad_reason,
                    'mt_onroad_datetime' => $row->mt_onroad_datetime,
                    'mt_on_remark' => $row->mt_on_remark,
                    'added_by_name' => $added_by_name,
                    'amb_status' => $amb_status,
                    // 'mt_stnd_remark' => $row->mt_stnd_remark,
                    'mt_stnd_remark' => $row->remark_after_approval,

                );
                fputcsv($fp, $data);
                $count++;
            }
            foreach ($accidental as $row) {
                if($row->mt_district_id!= ' '){
                    $current_district = get_district_by_id($row->mt_district_id);
                }
                if($row->amb_type != '' || $row->amb_type != 0 ){ 
                    $amb_type =  show_amb_type_name($row->amb_type);
                }
                $amb_model =  show_amb_model_name($row->mt_amb_no);
                //$amb_status =  show_amb_staus($main_data->mt_amb_no);
                if($row->amb_status == '1' || $row->amb_status=='2'){
                    $amb_status = 'On-Road';
                }else{
                    $amb_status = 'Off-Road';
                }
                if($row->mt_offroad_datetime!='' && $row->mt_offroad_datetime != '1970-01-01 05:30:00' && $row->mt_offroad_datetime != '0000-00-00 00:00:00'){
                $start_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->mt_offroad_datetime)));  
                if($row->mt_onroad_datetime != '' && $row->mt_onroad_datetime != '1970-01-01 05:30:00' && $row->mt_onroad_datetime != '0000-00-00 00:00:00'){
                    $end_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->mt_onroad_datetime))); 
                }else{
                    $end_date = new DateTime(date('Y-m-d H:i:s')); 
                }
                $duration = '0';
                if(strtotime($row->mt_offroad_datetime) < strtotime($row->mt_onroad_datetime)){
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }else{
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }}else{
                    $duration = '0';
                }
                $mt_other_offroad_reason = "";
                $added_by_name = $row->first_name." ".$row->mid_name." ". $row->last_name;
                $data = array(
                    'Sr.No' => $count,
                    'mt_onoffroad_id' => $row->mt_accidental_id,
                    'div_name' => $row->div_name,
                    'current_district' => $current_district,
                    'mt_base_loc' => $row->mt_base_loc,
                    'mt_amb_no' => $row->mt_amb_no,
                    'amb_model' => $amb_model,
                    'amb_type' => $amb_type,
                    'mt_offroad_datetime' => $row->mt_offroad_datetime,
                    'mt_ex_onroad_datetime' => $row->mt_ex_onroad_datetime,
                    'duration' => $duration,
                    'mt_ambulance_status' => $row->mt_ambulance_status,
                    'General' => 'Accidental Offroad',
                    'mt_remark' => $row->mt_remark,
                    'mt_offroad_reason' => $row->mt_offroad_reason,
                    'mt_other_offroad_reason' => $mt_other_offroad_reason,
                    'mt_onroad_datetime' => $row->mt_onroad_datetime,
                    'mt_on_remark' => $row->mt_on_remark,
                    'added_by_name' => $added_by_name,
                    'amb_status' => $amb_status,
                    // 'mt_stnd_remark' => $row->mt_stnd_remark,
                    'mt_stnd_remark' => $row->remark_after_approval,

                );
                fputcsv($fp, $data);
                $count++;
            }
            foreach ($preventive as $row) {
                if($row->mt_district_id!= ' '){
                    $current_district = get_district_by_id($row->mt_district_id);
                }
                if($row->amb_type != '' || $row->amb_type != 0 ){ 
                    $amb_type =  show_amb_type_name($row->amb_type);
                }
                $amb_model =  show_amb_model_name($row->mt_amb_no);
                //$amb_status =  show_amb_staus($main_data->mt_amb_no);
                if($row->amb_status == '1' || $row->amb_status=='2'){
                    $amb_status = 'On-Road';
                }else{
                    $amb_status = 'Off-Road';
                }
                $start_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->mt_offroad_datetime)));  
                if($row->mt_offroad_datetime!='' && $main_drowata->mt_offroad_datetime != '1970-01-01 05:30:00' && $row->mt_offroad_datetime != '0000-00-00 00:00:00'){
                if($row->mt_onroad_datetime != '' && $row->mt_onroad_datetime != '1970-01-01 05:30:00' && $row->mt_onroad_datetime != '0000-00-00 00:00:00'){
                    $end_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->mt_onroad_datetime))); 
                }else{
                    $end_date = new DateTime(date('Y-m-d H:i:s')); 
                }
                $duration = '0';
                if(strtotime($row->mt_offroad_datetime) < strtotime($row->mt_onroad_datetime)){
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }else{
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }}else{
                    $duration = '0';
                }
                $mt_other_offroad_reason = "";
                $added_by_name = $row->first_name." ".$row->mid_name." ". $row->last_name;
                $data = array(
                    'Sr.No' => $count,
                    'mt_onoffroad_id' => $row->mt_preventive_id,
                    'div_name' => $row->div_name,
                    'current_district' => $current_district,
                    'mt_base_loc' => $row->mt_base_loc,
                    'mt_amb_no' => $row->mt_amb_no,
                    'amb_model' => $amb_model,
                    'amb_type' => $amb_type,
                    'mt_offroad_datetime' => $row->mt_offroad_datetime,
                    'mt_ex_onroad_datetime' => $row->mt_ex_onroad_datetime,
                    'duration' => $duration,
                    'mt_ambulance_status' => $row->mt_ambulance_status,
                    'General' => 'Schedule Offroad',
                    'mt_remark' => $row->mt_remark,
                    'mt_offroad_reason' => $row->mt_offroad_reason,
                    'mt_other_offroad_reason' => $mt_other_offroad_reason,
                    'mt_onroad_datetime' => $row->mt_onroad_datetime,
                    'mt_on_remark' => $row->mt_on_remark,
                    'added_by_name' => $added_by_name,
                    'amb_status' => $amb_status,
                    // 'mt_stnd_remark' => $row->mt_stnd_remark,
                    'mt_stnd_remark' => $row->remark_after_approval,

                );
                fputcsv($fp, $data);
                $count++;
            }
            foreach ($tyre as $row) {
                if($row->mt_district_id!= ' '){
                    $current_district = get_district_by_id($row->mt_district_id);
                }
                if($row->amb_type != '' || $row->amb_type != 0 ){ 
                    $amb_type =  show_amb_type_name($row->amb_type);
                }
                $amb_model =  show_amb_model_name($row->mt_amb_no);
                //$amb_status =  show_amb_staus($main_data->mt_amb_no);
                if($row->amb_status == '1' || $row->amb_status=='2'){
                    $amb_status = 'On-Road';
                }else{
                    $amb_status = 'Off-Road';
                }
                $start_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->mt_offroad_datetime)));  
                if($row->mt_offroad_datetime!='' && $row->mt_offroad_datetime != '1970-01-01 05:30:00' && $row->mt_offroad_datetime != '0000-00-00 00:00:00'){
                if($row->mt_onroad_datetime != '' && $row->mt_onroad_datetime != '1970-01-01 05:30:00' && $row->mt_onroad_datetime != '0000-00-00 00:00:00'){
                    $end_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->mt_onroad_datetime))); 
                }else{
                    $end_date = new DateTime(date('Y-m-d H:i:s')); 
                }
                $duration = '0';
                if(strtotime($row->mt_offroad_datetime) < strtotime($row->mt_onroad_datetime)){
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }else{
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }}else{
                    $duration = '0';
                }
                $mt_other_offroad_reason = "";
                $added_by_name = $row->first_name." ".$row->mid_name." ". $row->last_name;
                $data = array(
                    'Sr.No' => $count,
                    'mt_onoffroad_id' => $row->mt_tyre_id,
                    'div_name' => $row->div_name,
                    'current_district' => $current_district,
                    'mt_base_loc' => $row->mt_base_loc,
                    'mt_amb_no' => $row->mt_amb_no,
                    'amb_model' => $amb_model,
                    'amb_type' => $amb_type,
                    'mt_offroad_datetime' => $row->mt_offroad_datetime,
                    'mt_ex_onroad_datetime' => $row->mt_ex_onroad_datetime,
                    'duration' => $duration,
                    'mt_ambulance_status' => $row->mt_ambulance_status,
                    'General' => 'Tyre Offroad',
                    'mt_remark' => $row->mt_remark,
                    'mt_offroad_reason' => $row->mt_offroad_reason,
                    'mt_other_offroad_reason' => $mt_other_offroad_reason,
                    'mt_onroad_datetime' => $row->mt_onroad_datetime,
                    'mt_on_remark' => $row->mt_on_remark,
                    'added_by_name' => $added_by_name,
                    'amb_status' => $amb_status,
                    // 'mt_stnd_remark' => $row->mt_stnd_remark,
                    'mt_stnd_remark' => $row->remark_after_approval,

                );
                fputcsv($fp, $data);
                $count++;
            }
            foreach ($breakdown as $row) {
                if($row->mt_district_id!= ' '){
                    $current_district = get_district_by_id($row->mt_district_id);
                }
                if($row->amb_type != '' || $row->amb_type != 0 ){ 
                    $amb_type =  show_amb_type_name($row->amb_type);
                }
                $amb_model =  show_amb_model_name($row->mt_amb_no);
                //$amb_status =  show_amb_staus($main_data->mt_amb_no);
                if($row->amb_status == '1' || $row->amb_status=='2'){
                    $amb_status = 'On-Road';
                }else{
                    $amb_status = 'Off-Road';
                }
                $start_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->mt_offroad_datetime)));  
                if($row->mt_offroad_datetime!='' && $row->mt_offroad_datetime != '1970-01-01 05:30:00' && $row->mt_offroad_datetime != '0000-00-00 00:00:00'){
                if($row->mt_onroad_datetime != '' && $row->mt_onroad_datetime != '1970-01-01 05:30:00' && $row->mt_onroad_datetime != '0000-00-00 00:00:00'){
                    $end_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->mt_onroad_datetime))); 
                }else{
                    $end_date = new DateTime(date('Y-m-d H:i:s')); 
                }
                $duration = '0';
                if(strtotime($row->mt_offroad_datetime) < strtotime($row->mt_onroad_datetime)){
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }else{
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }}else{
                    $duration = '0';
                }
                $mt_other_offroad_reason = "";
                $added_by_name = $row->first_name." ".$row->mid_name." ". $row->last_name;
                $data = array(
                    'Sr.No' => $count,
                    'mt_onoffroad_id' => $row->mt_breakdown_id,
                    'div_name' => $row->div_name,
                    'current_district' => $current_district,
                    'mt_base_loc' => $row->mt_base_loc,
                    'mt_amb_no' => $row->mt_amb_no,
                    'amb_model' => $amb_model,
                    'amb_type' => $amb_type,
                    'mt_offroad_datetime' => $row->mt_offroad_datetime,
                    'mt_ex_onroad_datetime' => $row->mt_ex_onroad_datetime,
                    'duration' => $duration,
                    'mt_ambulance_status' => $row->mt_ambulance_status,
                    'General' => 'Breakdown Offroad',
                    'mt_remark' => $row->mt_remark,
                    'mt_offroad_reason' => $row->mt_offroad_reason,
                    'mt_other_offroad_reason' => $mt_other_offroad_reason,
                    'mt_onroad_datetime' => $row->mt_onroad_datetime,
                    'mt_on_remark' => $row->mt_on_remark,
                    'added_by_name' => $added_by_name,
                    'amb_status' => $amb_status,
                    // 'mt_stnd_remark' => $row->mt_stnd_remark,
                    'mt_stnd_remark' => $row->remark_after_approval,

                );
                fputcsv($fp, $data);
                $count++;
            }
            foreach ($manpower as $row) {
                if($row->mt_district_id!= ' '){
                    $current_district = get_district_by_id($row->mt_district_id);
                }
                if($row->amb_type != '' || $row->amb_type != 0 ){ 
                    $amb_type =  show_amb_type_name($row->amb_type);
                }
                $amb_model =  show_amb_model_name($row->mt_amb_no);
                //$amb_status =  show_amb_staus($main_data->mt_amb_no);
                if($row->amb_status == '1' || $row->amb_status=='2'){
                    $amb_status = 'On-Road';
                }else{
                    $amb_status = 'Off-Road';
                }
                $start_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->mt_offroad_date)));  
                if($row->mt_offroad_date!='' && $row->mt_offroad_date != '1970-01-01 05:30:00' && $row->mt_offroad_date != '0000-00-00 00:00:00'){
                if($row->mt_ex_onroad_datetime != '' && $row->mt_ex_onroad_datetime != '1970-01-01 05:30:00' && $row->mt_ex_onroad_datetime != '0000-00-00 00:00:00'){
                    $end_date = new DateTime(date('Y-m-d H:i:s',strtotime($row->mt_ex_onroad_datetime))); 
                }else{
                    $end_date = new DateTime(date('Y-m-d H:i:s')); 
                }
                $duration = '0';
                if(strtotime($row->mt_offroad_date) < strtotime($row->mt_ex_onroad_datetime)){
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }else{
                    $since_start = $start_date->diff($end_date);
                    $duration= $since_start->days;
                }}else{
                    $duration = '0';
                }
                $mt_other_offroad_reason = "";
                $added_by_name = $row->first_name." ".$row->mid_name." ". $row->last_name;
                $data = array(
                    'Sr.No' => $count,
                    'mt_onoffroad_id' => $row->mt_manpower_id,
                    'div_name' => $row->div_name,
                    'current_district' => $current_district,
                    'mt_base_loc' => $row->mt_base_loc,
                    'mt_amb_no' => $row->mt_amb_no,
                    'amb_model' => $amb_model,
                    'amb_type' => $amb_type,
                    'mt_offroad_datetime' => $row->mt_offroad_date,
                    'mt_ex_onroad_datetime' => $row->mt_ontime_onroad_date,
                    'duration' => $duration,
                    'mt_ambulance_status' => $row->mt_ambulance_status,
                    'General' => 'Manpower offroad',
                    'mt_remark' => $row->mt_remark,
                    'mt_offroad_reason' => $row->mt_offroad_reason,
                    'mt_other_offroad_reason' => $mt_other_offroad_reason,
                    'mt_onroad_datetime' => $row->mt_ex_onroad_datetime,
                    'mt_on_remark' => $row->mt_on_remark,
                    'added_by_name' => $added_by_name,
                    'amb_status' => $amb_status,
                    // 'mt_stnd_remark' => $row->mt_stnd_remark,
                    'mt_stnd_remark' => $row->remark_after_approval,

                );
                fputcsv($fp, $data);
                $count++;
            }

            fclose($fp);
            exit; 
        }
    }
// function save_export_onroad_offroad() {
//     $post_reports = $this->input->post();
//             //var_dump($post_reports);die();
//         // $maintenance_type = $this->input->post('maintenance_type');
//     $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
//     $base_month = $this->common_model->get_base_month($from_date);
//     $this->post['base_month'] = $base_month[0]->months;
    
//     if ($post_reports['to_date'] != '') {

//         $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
//             'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
//             'base_month' => $this->post['base_month']);
//     } else {

//         $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
//             'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
//             'base_month' => $this->post['base_month']);
//     }
//     $report_data = $this->ambmain_model->get_ambulance_onoff_data($report_args);
//         //var_dump($report_args);die;
//     $header = array('Sr.No','Ambulance No','Base Location','District','Ambulance Type','Maintenance Type', 'Off-Road Date', ' Off-Road Remark','Ambulance Status','Added Date', 'On-Road Date','On road Remark','Total Off-Road Time');

//     $main_file_name = strtotime($post_reports['from_date']);
//     $filename = "maintenance_" . $main_file_name . ".csv";
//     $this->output->set_focus_to = "inc_ref_id";
//     if ($post_reports['reports'] == 'view') {

//         $data['header'] = $header;
//          $data['maintenance_data'] = $report_data;
//         // $data['maintenance_type'] = $maintenance_type;
//         $data['report_args'] = $report_args;
//          $data['submit_function'] = 'save_export_onroad_offroad';
//         $this->output->add_to_position($this->load->view('frontend/erc_reports/maintenance_report_view', $data, TRUE), 'list_table', TRUE);
//     } else {
//         //var_dump("hii");die();
//         $filename = "onroad_offroad_report.csv";
//         $fp = fopen('php://output', 'w');
//         header('Content-type: application/csv');
//         header('Content-Disposition: attachment; filename=' . $filename);
//         fputcsv($fp, $header);

//         $count = 1;

//         foreach ($report_data as $row) {
//             if($row->amb_type != '' || $row->amb_type != 0 ){ 
//                 $amb_type =  show_amb_type_name($row->amb_type);
//                // var_dump($amb_type);
//                }
//                $start_date = new DateTime(date('Y-m-d h:i:s',strtotime($row->mt_offroad_datetime)));                         
//                if($row->mt_onroad_datetime != '' && $row->mt_onroad_datetime != '1970-01-01 05:30:00' && $row->mt_onroad_datetime != '0000-00-00 00:00:00'){
                    
//                      $end_date = new DateTime(date('Y-m-d h:i:s',strtotime($row->mt_onroad_datetime))); 
//                 }else{
//                     $end_date = new DateTime(date('Y-m-d h:i:s')); 
//                 }
//                 $since_start = $start_date->diff($end_date);
//                 $duration= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S';
//                 if($row->mt_type=='accidental'){
//                     $main_type="Accidental Maintenance";
//                 }
//                 elseif($row->mt_type=='breakdown'){
//                     $main_type="Breakdown Maintenance";
//                 }
//                 elseif($row->mt_type=='preventive'){
//                     $main_type="Preventive Maintenance";
//                 }
//                 elseif($row->mt_type=='tyre'){
//                     $main_type="Tyre Maintenance";
//                 }
//                 elseif($row->mt_type=='onroad_offroad'){
//                     $main_type="Onroad/offroadMaintenance";
//                 }
//                 if($main_data->mt_district_id!= ' '){
//                 $current_district = get_district_by_id($row->mt_district_id);
//                 }
//                 $data = array(
//                 'Sr.No' => $count,
//                 'Ambulance No' => $row->mt_amb_no,
//                 'Base Location' => $row->mt_base_loc,
//                 'District' => $current_district,
//                 'amb_type' => $amb_type,
//                 'Maintenance Type' => $main_type,
//                 'OffRoad Date' => $row->mt_offroad_datetime,
//                 'Remark' => $row->mt_remark,
//                 'Ambulance Status' => $row->mt_ambulance_status,
//                 'Added Date' => $row->added_date,
//                 'Onroad Date' => $row->mt_onroad_datetime,
//                 'on_road-remark'=>$row->mt_on_remark,
//                 'total_off_road_time'=> $duration
//             );
//             fputcsv($fp, $data);
//             $count++;
//         }

//         fclose($fp);
//         exit;
//     }
        
//     }

    public function save_export_tans_patient_new(){
        $post_reports = $this->input->post();
        
        $report_type = $this->input->post('ptn_report_type');
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $to_date = date('Y-m-d', strtotime($post_reports['to_date']));
        $header = array('Call Type', 'Call Count on '.$from_date.' to '.$to_date);
        
        $report_args_attends = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
                'system' =>$post_reports['system'],
                'incis_deleted' => '0');


        $total_inc_attend = $this->inc_model->get_inc_call_type_total($report_args_attends);
        
        
          if ($post_reports['reports'] == 'view') {

            $row['total_calls'] = $total_calls;

            $data['header'] = $header;
            $data['inc_data'] = $total_inc_attend;
            $data['report_args'] = $report_args_attends;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ptn_trans_report_new_view', $data, TRUE), 'list_table', TRUE);
        } else {

            $filename = "patient_trans_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);
            foreach($total_inc_attend as $total_inc){
                 $row = array('inc_name' => $total_inc->call_purpose,
                              'inc_total'=> $total_inc->total_call);
                 $grand_total = $grand_total+$total_inc->total_call;
                  fputcsv($fp, $row);
            }
            $total_calls = array('Grand Total',$grand_total);
            fputcsv($fp, $total_calls);



            fclose($fp);
            exit;
        }
    }

    function ambulance_distance_report() {

        $post_reports = $this->input->post();
        $to_data = date('Y-m-t', strtotime($post_reports['from_date']));
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $report_type = $this->input->post('amb_type');
        $data['amb_type'] = $report_type;
       // var_dump($post_reports);

        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month']);
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month']);
             $district_data['month'] = date('M Y', strtotime($post_reports['from_date']));  
        }
        $report_args['system']=$post_reports['system'];



        $report_data = $this->inc_model->get_distance_report_by_date($report_args);
       

        $district_data = array();

        $district_data['amb'] = array();
        $district_data['inc_ref_id'] = array();
        $district_data['total_km'] = 0;
         $district_data['month'] =date('M Y', strtotime($post_reports['from_date']));
        
        foreach ($report_data as $report) {
            
            

            $district_data['month'] = date('M Y', strtotime($post_reports['from_date']));


            if (!in_array($report['amb_reg_id'], $district_data['amb'])) {
                $district_data['amb'][] = $report['amb_reg_id'];
            }


            if (!in_array($report['inc_ref_id'], $district_data['inc_ref_id'])) {
              //  var_dump($report['total_km']);

                $district_data['inc_ref_id'][] = $report['inc_ref_id'];

               // if (!empty($report['start_odometer'])) {

                //    if ($report['end_odometer'] >= $report['start_odometer']) {
                    if(is_numeric($report['end_odometer'] ) &&  is_numeric($report['start_odometer'])){

                        $report_odometer = (int)$report['end_odometer'] - (int)$report['start_odometer'];
                        // $district_data['total_km']  +=  $report_odometer;
                        $district_data['total_km'] += $report['total_km'];
                //    }

                    $district_data['trips'][] = $report_odometer;
               // }
            }
        }
    }

        if($report_type == '1'){
            $header = array('No of ambulance', 'Total Distance travel by Ambulance', 'Average distance travel per Ambulance');
        }else{
             $header = array('Month', 'No of ambulance', 'Total Distance travell by Ambulance', 'Average distance travel per Ambulance');
        }
        $header = array('Month', 'No of ambulance', 'Total Distance travell by Ambulance', 'Average distance travel per Ambulance');

        if ($post_reports['reports'] == 'view') {

            if($report_type == '2'){
                $row['month'] = $district_data['month'];
            }
            $row['month'] = $district_data['month'];
            $row['no_amb'] = $this->amb_model->get_tdd_total_amb();


            $row['total_km'] = $district_data['total_km'];

            //$row['avg_veh_km'] = $row['total_km'] / count($district_data['amb']);
            $avg_veh_km = $row['total_km'] / $row['no_amb'];
            $row['avg_veh_km1'] = number_format($avg_veh_km, 2);
            $data['header'] = $header;
            $data['inc_data'] = $row;

            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/amb_dist_travel_view', $data, TRUE), 'list_table', TRUE);
        } else {

            $filename = "bvg_monthly_distance_travelled_reports.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);


            
            if($report_type == '2'){
                $row['month'] = $district_data['month'];
            }
            $row['no_amb'] = count($district_data['amb']);
            $row['no_amb'] = $this->amb_model->get_tdd_total_amb();
            $row['total_km'] = $district_data['total_km'];

            //$row['avg_veh_km'] = $row['total_km'] / count($district_data['amb']);
           // $row['avg_veh_km'] = $row['total_km'] / $row['no_amb'];
           $avg_veh_km = $row['total_km'] / $row['no_amb'];
           $row['avg_veh_km1'] = number_format($avg_veh_km, 2);
            fputcsv($fp, $row);



            fclose($fp);
            exit;
        }
    }
    function amb_hpcl_export_date_wise(){
        $post_reports = $this->input->post();
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $to_data = date('Y-m-d', strtotime($post_reports['from_date']));
        $hpcl_amb = $post_reports['hpcl_amb'];
        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
                'hpcl_amb' => $hpcl_amb
            );
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                'hpcl_amb' => $hpcl_amb
            );
        }
        //var_dump($report_args);die();
        $report_data = $this->hpcl_model_api->get_hpcl_amb_details($report_args);
        foreach ($report_data as $report) {
            //var_dump($report);
           $row[] = array(
                'hpcl_id' => $report['hpcl_id'],
                'TerminalID' => $report['TerminalID'],
                'MerchantName' => $report['MerchantName'],
                'MerchantID' => $report['MerchantID'],
                'Location' => $report['Location'],
                'CustomerID' => $report['CustomerID'],
                'BatchIDROC' => $report['BatchIDROC'],
                'AccountNumber' => $report['AccountNumber'],
                'VehicleNoUserName' => $report['VehicleNoUserName'],
                'TransactionDate' => $report['TransactionDate'],
                'TransactionType' => $report['TransactionType'],
                'Product' => $report['Product'],
                'Price' => $report['AccountNumber'],
                'Volume' => $report['Volume'],
                'Currency' => $report['Currency'],
                'ServiceCharge' => $report['ServiceCharge'],
                'Amount' => $report['Amount'],
                'Balance' => $report['Balance'],
                'OdometerReading' => $report['OdometerReading'],
                'Drivestars' => $report['Drivestars'],
                'RewardType' => $report['RewardType'],
                'Status' => $report['Status'],
                'UniqueTransactionID' => $report['UniqueTransactionID'],
                'ResponseMessage' => $report['ResponseMessage'],
                'ResponseCode' => $report['ResponseCode'],
                'added_date' => $report['added_date'],
            );
        }

        $header = array(
            'Hpcl Id',
          //  'TerminalID',
          //  'MerchantName',
           // 'MerchantID',
          //  'Location',
           // 'CustomerID',
          //  'BatchIDROC',
            'AccountNumber',
            'VehicleNoUserName',
            'TransactionDate',
         //   'TransactionType',
            'Product',
            'Price',
            'Volume',
          //  'Currency',
          //  'ServiceCharge',
            'Amount',
          //  'Balance',
            'OdometerReading',
          //  'Drivestars',
          //  'RewardType',
         //   'Status',
        //    'UniqueTransactionID',
        //    'ResponseMessage',
         //   'ResponseCode',
            'Added Date'
        );
        if ($post_reports['reports'] == 'view') {
            $data['header'] = $header;
            $data['hpcl_data'] = $row;
            $data['submit_function']='amb_hpcl_export_date_wise';
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/hpcl_list_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "Hpcl_Report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

           // $inc_data = array();
           if($report_data){
            foreach ($report_data as $report) {
                

                $inc_data = array(
                    'hpcl_id' => $report['hpcl_id'],
               // 'TerminalID' => $report['TerminalID'],
               // 'MerchantName' => $report['MerchantName'],
               // 'MerchantID' => $report['MerchantID'],
               // 'Location' => $report['Location'],
               // 'CustomerID' => $report['CustomerID'],
               // 'BatchIDROC' => $report['BatchIDROC'],
                'AccountNumber' => $report['AccountNumber'],
                'VehicleNoUserName' => $report['VehicleNoUserName'],
                'TransactionDate' => $report['TransactionDate'],
               // 'TransactionType' => $report['TransactionType'],
                'Product' => $report['Product'],
                'Price' => $report['AccountNumber'],
                'Volume' => $report['Volume'],
               // 'Currency' => $report['Currency'],
              //  'ServiceCharge' => $report['ServiceCharge'],
                'Amount' => $report['Amount'],
               // 'Balance' => $report['Balance'],
                'OdometerReading' => $report['OdometerReading'],
              //  'Drivestars' => $report['Drivestars'],
              //  'RewardType' => $report['RewardType'],
               // 'Status' => $report['Status'],
              //  'UniqueTransactionID' => $report['UniqueTransactionID'],
              //  'ResponseMessage' => $report['ResponseMessage'],
              //  'ResponseCode' => $report['ResponseCode'],
                'Added Date' => $report['added_date']
                );
              //  var_dump($inc_data);
             //   die();

                fputcsv($fp, $inc_data);
            }
        }else{

            }
            fclose($fp);
            exit;
        }
    }
    function hpcl_export_date_wise(){
        $post_reports = $this->input->post();
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $to_data = date('Y-m-t', strtotime($post_reports['from_date']));
       // var_dump($to_data);die();
        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month']
            );
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month']
            );
        }
        $report_data = $this->hpcl_model_api->get_hpcl_amb_details($report_args);
        foreach ($report_data as $report) {
            
           $row[] = array(
                'hpcl_id' => $report['hpcl_id'],
                'TerminalID' => $report['TerminalID'],
                'MerchantName' => $report['MerchantName'],
                'MerchantID' => $report['MerchantID'],
                'Location' => $report['Location'],
                'CustomerID' => $report['CustomerID'],
                'BatchIDROC' => $report['BatchIDROC'],
                'AccountNumber' => $report['AccountNumber'],
                'VehicleNoUserName' => $report['VehicleNoUserName'],
                'TransactionDate' => $report['TransactionDate'],
                'TransactionType' => $report['TransactionType'],
                'Product' => $report['Product'],
                'Price' => $report['Price'],
                'Volume' => $report['Volume'],
                'Currency' => $report['Currency'],
                'ServiceCharge' => $report['ServiceCharge'],
                'Amount' => $report['Amount'],
                'Balance' => $report['Balance'],
                'OdometerReading' => $report['OdometerReading'],
                'Drivestars' => $report['Drivestars'],
                'RewardType' => $report['RewardType'],
                'Status' => $report['Status'],
                'UniqueTransactionID' => $report['UniqueTransactionID'],
                'ResponseMessage' => $report['ResponseMessage'],
                'ResponseCode' => $report['ResponseCode'],
                'added_date' => $report['added_date'],
            );
        }

        $header = array(
            'hpcl_id',
            //'TerminalID',
            //'MerchantName',
           // 'MerchantID',
           // 'Location',
          //  'CustomerID',
          //  'BatchIDROC',
            'AccountNumber',
            'VehicleNoUserName',
            'TransactionDate',
           // 'TransactionType',
            'Product',
            'Price',
            'Volume',
          //  'Currency',
           // 'ServiceCharge',
            'Amount',
          //  'Balance',
            'OdometerReading',
           // 'Drivestars',
          //  'RewardType',
          //  'Status',
          //  'UniqueTransactionID',
           // 'ResponseMessage',
          //  'ResponseCode',
            'Added Date'
        );
        if ($post_reports['reports'] == 'view') {
            $data['header'] = $header;
            $data['hpcl_data'] = $row;
            $data['report_args'] = $report_args;
            $data['submit_function']='hpcl_export_date_wise';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/hpcl_list_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "Hpcl_Report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            if($report_data){
            foreach ($report_data as $report) {
                

                $inc_data = array(
                    'hpcl_id' => $report['hpcl_id'],
               // 'TerminalID' => $report['TerminalID'],
              //  'MerchantName' => $report['MerchantName'],
               // 'MerchantID' => $report['MerchantID'],
               // 'Location' => $report['Location'],
               // 'CustomerID' => $report['CustomerID'],
                //'BatchIDROC' => $report['BatchIDROC'],
                'AccountNumber' => "'".$report['AccountNumber'],
                'VehicleNoUserName' => $report['VehicleNoUserName'],
                'TransactionDate' => $report['TransactionDate'],
               // 'TransactionType' => $report['TransactionType'],
                'Product' => $report['Product'],
                'Price' => $report['Price'],
                'Volume' => $report['Volume'],
               // 'Currency' => $report['Currency'],
               // 'ServiceCharge' => $report['ServiceCharge'],
                'Amount' => $report['Amount'],
               // 'Balance' => $report['Balance'],
                'OdometerReading' => $report['OdometerReading'],
               // 'Drivestars' => $report['Drivestars'],
               // 'RewardType' => $report['RewardType'],
               // 'Status' => $report['Status'],
               // 'UniqueTransactionID' => $report['UniqueTransactionID'],
               // 'ResponseMessage' => $report['ResponseMessage'],
               // 'ResponseCode' => $report['ResponseCode'],
                'Added Date' => $report['added_date']
                );
                fputcsv($fp, $inc_data);
               
            }
        }else{

            }
            
            fclose($fp);
            exit;
        }
    }
    function export_district_wise() {

        $post_reports = $this->input->post();
        // var_dump($post_reports);die;
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $to_data = date('Y-m-t', strtotime($post_reports['from_date']));


            //        $report_args = array('from_date' => $from_date,
            //            'to_date' => $to_data,
            //            'district' => $post_reports['incient_district']);
            //        
        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
             "incient_district" => $post_reports['incient_district'],
             "system" => $post_reports['system']
             );
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                "incient_district" => $post_reports['incient_district'],
                "system" => $post_reports['system']
            );
        }



        $report_data = $this->inc_model->get_district_amb_details($report_args);


        $district_data = array();


        foreach ($report_data as $report) {

            $district = $report['amb_district'];

            $incient_district = $this->inc_model->get_district_by_id($district);
            $dst_name = $incient_district->dst_name;
//var_dump( $dst_name);die;
            if (isset($district_data[$dst_name])) {

                if (!in_array($report['amb_rto_register_no'], $district_data[$dst_name]['amb'])) {

                    $district_data[$dst_name]['amb'][] = $report['amb_rto_register_no'];
                }

                if ($post_reports['from_date'] == "2018-07-01") {
                    //if(!in_array($report['inc_ref_id'], (array)$district_data[$dst_name]['inc_ref_id'])){

                    $district_data[$dst_name]['inc_ref_id'][] = $report['inc_ref_id'];

                    if ($report['end_odometer'] >= $report['start_odometer']) {
                        $report_odometer = $report['end_odometer'] - $report['start_odometer'];
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
        //var_dump($district['amb']);die;
        $row = array();

        foreach ($district_data as $key => $district) {
               
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
            if ((count($district['trips'])) != '') {
                $avg_km = number_format($avg_km_amb / count($district['trips']), 2);
            }
            $avg_veh_km = 0;

            if ((count($district['trips'])) != '') {
                $avg_veh_km = $total_trips / count($district['amb']);
            }

            $row[] = array('district' => $dst_name,
                'no_amb' => count($district['amb']),
                'total_km' => $district['total_km'],
                'avg_km_amb' => $avg_km_amb,
                'trips' => $total_trips,
                'avg_km' => $avg_km,
                'avg_veh_km' => $avg_veh_km);
        }
    //var_dump($row);die;
        $header = array('District',
            'No of Ambulance',
            'Total Kms',
            'Avg KMS/ Ambulance',
            'Total Trips',
            'Average Km/trip',
            'Average Trip/vehicle');

        if ($post_reports['reports'] == 'view') {



            $data['header'] = $header;
            $data['inc_data'] = $row;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/district_wise_list_report_view', $data, TRUE), 'list_table', TRUE);
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

     ////////////////Ambulance Listing Report///////////

     function ambulance_listing_district_wise() {
        $post_reports = $this->input->post();
        // var_dump($post_reports);die;
        // print_r("hi");die;
        $amb_report_type =  $this->input->post('amb_report_type');
        $amb_type = $this->input->post('amb_type');
        
        // $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        // $to_data = date('Y-m-t', strtotime($post_reports['from_date']));

       
        // if ($post_reports['to_date'] != '') {
        //     $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
        //         'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
        //         'base_month' => $this->post['base_month'],
        //      "incient_district" => $post_reports['incient_district'],
        //      "system" => $post_reports['system']
        //      );
        // } else {
        //     $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
        //         'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
        //         'base_month' => $this->post['base_month'],
        //         "incient_district" => $post_reports['incient_district'],
        //         "system" => $post_reports['system']
        //     );
        // }
        $report_args = array(
                'base_month' => $this->post['base_month'],
                "incient_district" => $post_reports['incient_district'],
            );
            $args = array('district_id' => $district);

        $report_data = $this->inc_model->get_amb_listing($report_args);
        // print_r($report_data);die;
        $district_data = array();
        foreach ($report_data as $report) {
            $district = $report['amb_district'];
            $incient_district = $this->inc_model->get_district_by_id($district);
            $dst_name = $incient_district->dst_name;
            $base_loc = $report['amb_base_location'];
            $incient_loc = $this->inc_model->get_base_location_by_id($base_loc);
            $hp_name = $incient_loc->hp_name;
            // print_r($hp_name);die;
            //var_dump( $dst_name);die;
           
        }
        //var_dump($district['amb']);die;
        $row = array();

        foreach ($report_data as $key => $report1) { 
           
            $row[] = array(
                'sr_no' => $key+1,
                'reg_no' => $report1['amb_rto_register_no'],
                'mb_no' => $report1['amb_default_mobile'],
                // 'pilot_nm' => $report1['pilot_nm'],
                // 'pilot_mb_no' => $report1['amb_pilot_mobile'],
                'vehical_make' => $report1['vehical_make'],
                'division' => $report1['div_name'],
                'district' => $report1['dst_name'],
                'tehsil' => $report1['thl_name'],
                // 'vehicle_type' => $report1['vehical_make_type'],
                'model' => $report1['vehical_model'],
                // 'owner' => $report1['amb_owner'],
                'imei_no' => $report1['amb_gps_imei_no'],
                'sim_no' => $report1['amb_gps_sim_no'],
                'srn_no' => $report1['amb_mdt_srn_no'],
                'mdt_imei_no' => $report1['amb_mdt_imei_no'],
                'simcnt_no' => $report1['amb_mdt_simcnt_no'],
                
                // 'amb_supervisor' => $report1['amb_supervisor'],
                'ambulance_type' => $report1['ambt_name'],
                'amb_category' => $report1['amb_category'],
                'chases_new' => $report1['chases_no'],
                // 'ambis_backup' => $report1['ambis_backup'],
                'party' => $report1['vendor_name'],
                'base_location' => $report1['hp_name'],
                // 'address' => $report1['amb_google_address'],
                // 'state' => $report1['amb_state'],
                
                // 'city' => $report1['amb_city'],
                // 'lat' => $report1['gps_amb_lat'],
                // 'long' => $report1['gps_amb_log'],
                'lat' => $lat = number_format((float)$report1['gps_amb_lat'], 4, '.', ''),
                'long' => $lat = number_format((float)$report1['gps_amb_log'], 4, '.', ''),
                'area' => $report1['ar_name'],
                'status' => $report1['ambs_name'],
                'added_by' => $report1['clg_first_name']." ".$report1['clg_last_name'],
                'added_date' => $report1['amb_added_date'],
            );
        }
    // var_dump($row);die;
        $header = array(
            'Sr No.',
            'Registration No.',
            'Ambulance CUG No.',
            // 'Pilot Name',
            // 'Pilot Mobile No.',
            'Vehicle Make',
            'Zone',
            'District',
            'Tehsil',
            // 'Vehicle Type',
            'Model',
            // 'Ambulance Owner',
            'GPS IMEI No.',
            'GPS SIM No.',
            'MDT Serial No.',
            'MDT IMEI No.',
            'MDT SIM Contact No.',
           
            // 'Ambulance Supervisor',
            'Ambulance Type',
            'Ambulance Category',
            'Chases No.',
            // 'Backup Ambulance',
            'Ambulance Vendor',
            'Base Location',
            // 'Address',
            // 'State',
         
            // 'City',
            // 'Locality',
            'Ambulance Latitude',
            'Ambulance Longitude',
            'Working Area',
            'Ambulance Status',
            'Ambulance Added by',
            'Ambulance Added Date'
        );

        if ($post_reports['reports'] == 'view') {
            $data['header'] = $header;
            $data['inc_data'] = $row;
            // print_r($data['inc_data']);die;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/amb_listing_district_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "district_wise_distance_covered_by_ambulance_listing.csv";
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

    function ambulance_master_district_wise() {
        $post_reports = $this->input->post();
        // var_dump($post_reports);die;
        // print_r("hi");die;
        $amb_report_type =  $this->input->post('amb_report_type');
        $amb_type = $this->input->post('amb_type');
        
        $report_args = array(
                'base_month' => $this->post['base_month'],
                "incient_district" => $post_reports['incient_district'],
            );
            $args = array('district_id' => $district);

        $report_data = $this->inc_model->get_amb_master($report_args);
        // print_r($report_data);die;
        $district_data = array();
        foreach ($report_data as $report) {
            $district = $report['amb_district'];
            $incient_district = $this->inc_model->get_district_by_id($district);
            $dst_name = $incient_district->dst_name;
            $base_loc = $report['amb_base_location'];
            $incient_loc = $this->inc_model->get_base_location_by_id($base_loc);
            $hp_name = $incient_loc->hp_name;
            // print_r($hp_name);die;
            //var_dump( $dst_name);die;
           
        }
        //var_dump($district['amb']);die;
        $row = array();

        foreach ($report_data as $key => $report1) { 
            if($report1['amb_user'] == '102'){
                $amb_user = 'Janani';
            }elseif($report1['amb_user'] == '108'){
                $amb_user = 'Sanjeevani';
            }
            if($report1['ambis_deleted'] == '0'){
                $ambis_deleted = 'Available';
            }elseif($report1['ambis_deleted'] == '1'){
                $ambis_deleted = 'Removed';
            }
            $row[] = array(
                'sr_no' => $key+1,
                'reg_no' => $report1['amb_rto_register_no'],
                'mb_no' => $report1['amb_default_mobile'],
                'chs_num' => $report1['chases_no'],
                // 'pilot_nm' => $report1['pilot_nm'],
                'pilot_mb_no' => $report1['amb_pilot_mobile'],
                'base_location' => $report1['hp_name'],
                'ambulance_type' => $report1['ambt_name'],
                'area' => $report1['ar_name'],
                'vehical_make' => $report1['vehical_make'],
                'vehical_type' => $report1['vehical_make_type'],
                'model' => $report1['vehical_model'],
                'amb_category' => $report1['amb_category'],
                'owner' => $report1['amb_owner'],
                'imei_no' => $report1['amb_gps_imei_no'],
                'sim_no' => $report1['amb_gps_sim_no'],
                'srn_no' => $report1['amb_mdt_srn_no'],
                'mdt_imei_no' => $report1['amb_mdt_imei_no'],
                'simcnt_no' => $report1['amb_mdt_simcnt_no'],
                'state' => $report1['amb_state'],
                'division' => $report1['div_name'],
                'district' => $report1['dst_name'],
                'party' => $report1['vendor_name'],
                // 'tehsil' => $report1['thl_name'],
                // 'amb_supervisor' => $report1['amb_supervisor'], 
                // 'ambis_backup' => $report1['ambis_backup'], 
                // 'address' => $report1['amb_google_address'],
                'user' => $amb_user,
                // 'city' => $report1['amb_city'],
                // 'lat' => $report1['gps_amb_lat'],
                // 'long' => $report1['gps_amb_log'],
                'lat' => $lat = number_format((float)$report1['gps_amb_lat'], 4, '.', ''),
                'long' => $lat = number_format((float)$report1['gps_amb_log'], 4, '.', ''),
                'status' => $report1['ambs_name'],
                // 'added_by' => $report1['clg_first_name']." ".$report1['clg_last_name'],
                'added_date' => $report1['amb_added_date'],
                'modify_date' => $report1['amb_modify_date'],
                'dlt_status' => $ambis_deleted,
            );
        }
    // var_dump($row);die;
        $header = array(
            'Sr No.',
            'Ambulance Reg. Number',
            'CUG Number',
            'Chases No.',
            // 'Pilot Name',
            'Pilot Contact Number',
            'Base Location',
            'Ambulance Type',
            'Amb Working Area',
            'Vehicle Make',
            'Vehicle Make Type',
            'Vehicle Model (Year)',
            'Amb Category',
            'Amb Owner',
            'Amb Gps Imei No',
            'Amb Gps Sim No',
            'Amb Mdt Srn No',
            'Amb Mdt Imei No',
            'Amb Mdt Simcnt No',
            'Amb State',  
            'Amb Div Code',
            'Amb District',
            'Amb Vendor',
            'User',
            // 'Tehsil',
            // 'Ambulance Supervisor',        
            // 'Backup Ambulance', 
            // 'Address',   
            // 'City',
            // 'Locality',
            'Ambulance Latitude',
            'Ambulance Longitude',  
            'Ambulance Status',
            // 'Ambulance Added by',
            'Ambulance Added Date',
            'Ambulance Modify Date',
            'Delete Status',
        );

        if ($post_reports['reports'] == 'view') {
            $data['header'] = $header;
            $data['inc_data'] = $row;
            // print_r($data['inc_data']);die;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/amb_master_district_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "district_wise_all_ambulance_master_report.csv";
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

     ////Ambulance Logout Report////

     function ambulance_logout_district_wise() {
        $post_reports = $this->input->post();
        $amb_report_type =  $this->input->post('amb_report_type');
        $amb_type = $this->input->post('amb_type');
        
        $report_args = array(
                'base_month' => $this->post['base_month'],
                "incient_district" => $post_reports['incient_district'],
            );
            $args = array('district_id' => $district);

        $report_data = $this->inc_model->get_amb_logout($report_args);
        // print_r($report_data);die;
        $district_data = array();
        // foreach ($report_data as $report) {
        //     $district = $report['amb_district'];
        //     $incient_district = $this->inc_model->get_district_by_id($district);
        //     $dst_name = $incient_district->dst_name;
        //     $base_loc = $report['amb_base_location'];
        //     $incient_loc = $this->inc_model->get_base_location_by_id($base_loc);
        //     $hp_name = $incient_loc->hp_name;
        // }
        //var_dump($district['amb']);die;
        $row = array();

        foreach ($report_data as $key => $report1) { 
            if($report1['status'] == '2'){
                $status= 'Logout';
               }

            $row[] = array(
                'sr_no' => $key+1,
                'reg_no' => $report1['vehicle_no'],
                'mb_no' => $report1['amb_default_mobile'],
                'ambulance_type' => $report1['ambt_name'],
                'base_location' => $report1['hp_name'],
                'division' => $report1['div_name'],
                'district' => $report1['dst_name'],
                'status' => $status,

            );
        }
    // var_dump($row);die;
        $header = array(
            'Sr No.',
            'Ambulance Number',
            'CUG Number',
            'Ambulance Type',
            'Base Location',
            'Division',
            'District',
            'Status', 
        );

        if ($post_reports['reports'] == 'view') {
            $data['header'] = $header;
            $data['inc_data'] = $row;
            // print_r($data['inc_data']);die;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/amb_logout_district_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "district_wise_ambulance_logout_report.csv";
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


    function ambulance_report_form_report() {

        $post_reports = $this->input->post();


        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month']);
        }else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month']);
        }
        $system=$this->input->post('system');
        $report_type = $this->input->post('amb_type');
        $data['amb_type'] = $report_type;

        
        $amb_odometer = array();


        $tdd_amb = $this->amb_model->get_tdd_amb(array('system'=>$system));


        foreach ($tdd_amb as $tdd) {
            
            if($report_type == '2'){
                $amb_odometer[$tdd->amb_rto_register_no]['month'] = date('M Y', strtotime($post_reports['from_date']));
            }
            $amb_odometer[$tdd->amb_rto_register_no]['amb_rto_register_no'] = $tdd->amb_rto_register_no;

            $amb_odometer[$tdd->amb_rto_register_no]['total_km'] = 0;
            $amb_odometer[$tdd->amb_rto_register_no]['avg_km'][] = 0;

            $report_args['amb_reg_no'] = $tdd->amb_rto_register_no;
            
//            var_dump($report_args);
//            die();
            
            $min_odometer = $this->inc_model->get_ambulance_min_odometer($report_args);
          

            $amb_odometer[$tdd->amb_rto_register_no]['min_odometer'] = $min_odometer[0]['start_odmeter'] ? $min_odometer[0]['start_odmeter'] : 0;

//            if ($amb_odometer[$tdd->amb_rto_register_no]['min_odometer'] == 0) {
//                $report_args_dt = array('to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
//                    'amb_reg_no' => $tdd->amb_rto_register_no);
//
//                $min_odometer1 = $this->inc_model->get_ambulance_max_odometer($report_args_dt);
//                $amb_odometer[$tdd->amb_rto_register_no]['min_odometer'] = $min_odometer1[0]['end_odmeter'] ? $min_odometer1[0]['end_odmeter'] : 0;
//                //var_dump($min_odometer);die();
//            }

            $max_odometer = $this->inc_model->get_ambulance_max_odometer($report_args);
            $amb_odometer[$tdd->amb_rto_register_no]['max_odometer'] = $max_odometer[0]['end_odmeter'] ? $max_odometer[0]['end_odmeter'] : 0;

            $report_data = $this->inc_model->get_distance_report_by_date($report_args);


            foreach ($report_data as $report) {


                if ($report['end_odmeter'] < $report['start_odmeter']) {
                    continue;
                }
                if(is_numeric($report['end_odometer'] )&&  is_numeric($report['start_odometer'])){
                
                $report_odometer = $report['end_odometer'] - $report['start_odometer'];

                if (isset($report['amb_reg_id'])) {

                    if (!in_array($report['inc_ref_id'], (array) $amb_odometer[$report['amb_reg_id']]['inc_ref_id'])) {

                        $amb_odometer[$report['amb_reg_id']]['inc_ref_id'][] = $report['inc_ref_id'];
                        $amb_odometer[$report['amb_reg_id']]['total_km'] += $report['total_km'];
                    }
                }

                $amb_odometer[$report['amb_reg_id']]['avg_km'][] = $report_odometer;
            }
        }
    }

        if($report_type == '2'){
            $header = array('Month', 'Ambulance No', 'Opening Odometer', 'Closing Odometer', 'Total KM', 'Average KM');
        }else{
            $header = array('Ambulance No', 'Opening Odometer', 'Closing Odometer', 'Total KM', 'Average KM');
        }

        if ($post_reports['reports'] == 'view') {


            $inc_data = array();
            foreach ($amb_odometer as $row) {
               if(is_numeric($row['max_odometer']) &&  is_numeric($row['min_odometer']))
                {
                if (count($row['avg_km']) > 0) {
                    $total_odometer = $row['max_odometer'] - $row['min_odometer'];
                    $row['avg_km'] = number_format($row['total_km'] / count($row['avg_km']), 2);
                }}
                $inc_data[] = $row;
            }



            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;

            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_wise_reports', $data, TRUE), 'list_table', TRUE);
        } else {

            $filename = "ambulance_wise_distance_travelled_report.csv";
            $fp = fopen('php://output', 'w');


            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $data = array();
            foreach ($amb_odometer as $row) {
                if($report_type == '2'){
                    $row1['month'] = $row['month'];
                }
                $row1['amb_rto_register_no'] = $row['amb_rto_register_no'];
                $row1['min_odometer'] = $row['min_odometer'];
                $row1['max_odometer'] = $row['max_odometer'];
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

    function break_single_date_report() {

        $post_reports = $this->input->post();
        $thirdparty = $this->clg->thirdparty;
        $district_id = $this->clg->clg_district_id;
       
       /* $clg_district_id = json_decode($district);
        if(is_array($clg_district_id)){
            $district_id = implode("','",$clg_district_id);
        }*/
        if ($post_reports['department_name'] != '') {
            $report_args = array(
                'clg_group' => $post_reports['department_name'],
                'clg_ref_id' => $post_reports['user_id'],
                'base_month' => $this->post['base_month'],
                'thirdparty' => $thirdparty,
                'clg_district_id' => $district_id,
                'single_date' => date('Y-m-d', strtotime($post_reports['single_date'])),
            );
        } else {
            $report_args = array(
                'single_date' => date('Y-m-d', strtotime($post_reports['single_date'])),
                'base_month' => $this->post['base_month'],
            
                'thirdparty' => $thirdparty,
                'clg_district_id' => $district_id
                 //'clg_ref_id' => $post_reports['user_id'],
           );
        }
        $report_data = $this->shiftmanager_model->get_break_details_by_user($report_args);
        $header = array('Date',
            'Time',
            'ERO Name',
            'Break Name',
            'Break time',
            'Back to Break Time',
            'Break Duration',
            'Third Party'
        );

        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            foreach ($report_data as $row) {
                $duration = "";
                if($row->clg_break_time != '' ){
                $d1= new DateTime($row->clg_break_time);
                

            $d2=new DateTime($row->clg_back_to_break_time);
            $duration=$d2->diff($d1);
            //var_dump($duration);die;
                }
               if($duration != NULL){
               $duration = $duration->h . ':' . $duration->i . ':' . $duration->s;
               $duration =date('H:i:s', strtotime($duration));
               }
               else{
                   $duration= "00:00:00";
               }
                $inc_data[] = array(
                    'clg_ref_id' => $row->clg_ref_id,
                    'clg_break_time' => date('Y-m-d', strtotime($row->clg_break_time)),
                    'clg_first_name' => ucwords($row->clg_first_name),
                    'clg_mid_name' => ucwords($row->clg_mid_name),
                    'clg_last_name' => ucwords($row->clg_last_name),
                    'clg_break_time' => $row->clg_break_time,
                    'break_name' => $row->break_name,
                    'clg_back_to_break_time' => $row->clg_back_to_break_time,
                    'break_time' => $duration,
                    'clg_third_party' => $row->thirdparty
                );
            }
//var_dump( $inc_data);die;

            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['submit_funtion'] = 'break_single_date_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/employee_break_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "employee_break_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            foreach ($report_data as $row) {
                if($inc['clg_third_party'] == '1') { $thirdparty = 'BVG'; }
                elseif($inc['clg_third_party'] == '2'){ $thirdparty = 'Private'; } 
                elseif($inc['clg_third_party'] == '3'){ $thirdparty = 'PCMC'; } 
                elseif($inc['clg_third_party'] == '4'){ $thirdparty = 'PMC'; } 
               
                $duration = "";
                if($row->clg_break_time != '' ){
                $d1= new DateTime($row->clg_break_time);
                

            $d2=new DateTime($row->clg_back_to_break_time);
            $duration=$d2->diff($d1);
            //var_dump($duration);die;
                }
               if($duration != NULL){
               $duration = $duration->h . ':' . $duration->i . ':' . $duration->s;
               $duration =date('H:i:s', strtotime($duration));
               }
               else{
                   $duration= "00:00:00";
               }

                $inc_data = array(
                    'clg_break_date' => date('Y-m-d', strtotime($row->clg_break_time)),
                    'clg_break_time' => date('H:i:s', strtotime($row->clg_break_time)),
                    'clg_first_name' => ucwords($row->clg_first_name . ' ' . $row->clg_mid_name . ' ' . $row->clg_last_name),
                    'break_name' => $row->break_name,
                    'clg_login_time' => $row->clg_break_time,
                    'clg_logout_time' => $row->clg_back_to_break_time,
                    'break_time' => $duration,
                    'clg_third_party' => $thirdparty

                

                );

                fputcsv($fp, $inc_data);
            }
            fclose($fp);
            exit;
        }
    }

    function login_logout_single_date_report() {


        $post_reports = $this->input->post();
        
        $thirdparty = $this->clg->thirdparty;
        $district_id = $this->clg->clg_district_id;
      /*  $clg_district_id = json_decode($district);
        if(is_array($clg_district_id)){
            $district_id = implode("','",$clg_district_id);
        }*/

        if ($post_reports['department_name'] != '') {
            $report_args = array(
                'clg_group' => $post_reports['department_name'],
                'clg_ref_id' => $post_reports['user_id'],
                'base_month' => $this->post['base_month'],
                'thirdparty_report' => $thirdparty,
                'clg_district_id' => $district_id
            );
        } else {
            $report_args = array(
                'single_date' => date('Y-m-d', strtotime($post_reports['single_date'])),
                'base_month' => $this->post['base_month'],
                'thirdparty_report' => $thirdparty,
                'clg_district_id' => $district_id
            );
        }

           //var_dump($report_args);die;
        $report_data = $this->shiftmanager_model->get_login_details($report_args);
         $header = array('Date',
            'Name',
            'Login time',
            'Logout Time',
            'Login Duration',
             'Third Party'
        );

        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            foreach ($report_data as $row) {
                $d_start = new DateTime($row->clg_login_time);
                $d_end = new DateTime($row->clg_logout_time);
                $resonse_time = $d_start->diff($d_end);
                
                $resonse_time = $resonse_time->h . ':' . $resonse_time->i . ':' . $resonse_time->s;
                $inc_data[] = array(
                    'clg_login_time' => date('Y-m-d', strtotime($row->clg_login_time)),
                    'clg_first_name' => ucwords($row->clg_first_name),
                    'clg_mid_name' => ucwords($row->clg_mid_name),
                    'clg_last_name' => ucwords($row->clg_last_name),
                    'clg_login_time' => $row->clg_login_time,
                    'clg_logout_time' => $row->clg_logout_time,
                     'clg_third_party' => $row->thirdparty
                    
               );
            }
           

            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['submit_funtion'] = 'login_logout_single_date_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/employee_login_list_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $post_reports = $this->input->post();
            $filename = "employee_login_logout_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            foreach ($report_data as $row) {
               // $login_duration=date_diff($row->clg_login_time,$row->clg_logout_time);  
                 $logout_time=$row->clg_logout_time;
               if($row->clg_logout_time == "0000-00-00 00:00:00"){
                $logout_time= "Currently Login";
               }
               else{
                   $logout_time=$row->clg_logout_time;
               }
               $d_start = new DateTime($row->clg_login_time);
                $d_end = new DateTime($row->clg_logout_time);
                $resonse_time = $d_start->diff($d_end);
                
                $resonse_time = $resonse_time->h . ':' . $resonse_time->i . ':' . $resonse_time->s;
                //var_dump($resonse_time);die;
                if($row->thirdparty == '1') { $thirdparty = 'BVG'; }
                elseif($row->thirdparty == '2'){ $thirdparty = 'Private'; } 
                elseif($row->thirdparty == '3'){ $thirdparty = 'PCMC'; } 
                elseif($row->thirdparty == '4'){ $thirdparty = 'PMC'; } 
                
                
                $inc_data = array(
                    'clg_time' => date('Y-m-d', strtotime($row->clg_login_time)),
                    'clg_first_name' => ucwords($row->clg_first_name . ' ' . $row->clg_mid_name . ' ' . $row->clg_last_name),
                    'clg_login_time' => $row->clg_login_time,
                    'clg_logout_time' => $logout_time,
                    'clg_duration' => $resonse_time,
                    'clg_third_party' => $thirdparty
                );
                //var_dump($inc_data);die;
                fputcsv($fp, $inc_data);
            }
            fclose($fp);
            exit;
        }
    }

    function load_employee_department_report() {

        $post_reports = $this->input->post();
        $thirdparty = $this->clg->thirdparty;
        $district_id = $this->clg->clg_district_id;
       /* $district_id = explode( ",", $district_id);
        $regex = "([\[|\]|^\"|\"$])"; 
        $replaceWith = ""; 
        $district_id = preg_replace($regex, $replaceWith, $district_id);
        
        if(is_array($district_id)){
            $district_id = implode("','",$district_id);
        }
*/
        $report_args = array(
            'clg_group' => $post_reports['department_name'],
            'clg_ref_id'=> $post_reports['user_id'],
            'thirdparty_report' => $thirdparty,
            'clg_district_id' => $district_id
                 //'base_month' => $this->post['base_month']
            );

        $report_data = $this->colleagues_model->get_clg_data($report_args);
        

        $header = array('Employee Id',
            'User Name',
            'Gender',
            'Mobile No',
            'Ameyo ID',
            'Designation',
            'Joining Date',
            'Address',
            'Third Party'
        );

        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            foreach ($report_data as $row) {

                $inc_data[] = array(
                    'clg_ref_id' => ucfirst($row->clg_ref_id),
                    'clg_first_name' => ucfirst($row->clg_first_name),
                    'clg_mid_name' => ucfirst($row->clg_mid_name),
                    'clg_last_name' => ucfirst($row->clg_last_name),
                    'clg_gender' => ucwords($row->clg_gender),
                    'clg_avaya_id' => $row->clg_avaya_id,
                    'clg_designation' => $row->clg_designation,
                    'clg_joining_date' => $row->clg_joining_date,
                    'clg_address' => $row->clg_address,
                    'clg_mobile_no' => $row->clg_mobile_no,
                    'clg_third_party' => $row->thirdparty
                );
            }


            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['submit_funtion'] = 'load_employee_department_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/employee_list_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "employee_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            foreach ($report_data as $row) {
                  
                
            $thirdparty = '';
            if($row->thirdparty  != ''){
                $thirdparty = get_third_party_name($row->thirdparty);
            }
           

                
                $inc_data = array(
//                    'clg_ref_id' => $row->clg_ref_id,
//                    'clg_first_name' => $row->clg_first_name . ' ' . $row->clg_mid_name . ' ' . $row->clg_last_name,
//                    'clg_gender' => $row->clg_gender,
//                    'clg_mobile_no' => $row->clg_mobile_no,
//                    'clg_avaya_id' => $row->clg_avaya_id,
//                    'clg_degree' => $row->clg_degree,
//                    'clg_joining_date' => $row->clg_joining_date,
//                    'clg_address' => $row->clg_address,
                      'clg_ref_id' => strtoupper($row->clg_ref_id),
                    'clg_first_name' => ucwords($row->clg_first_name . ' ' . $row->clg_mid_name . ' ' . $row->clg_last_name),
                    'clg_gender' => ucwords($row->clg_gender),
                    'clg_mobile_no' => $row->clg_mobile_no,
                    
                    'clg_avaya_id' => $row->clg_avaya_id,
                    'clg_designation' => $row->clg_designation,
                    'clg_joining_date' => $row->clg_joining_date,
                    'clg_address' => $row->clg_address,
                    'clg_mobile_no' => $row->clg_mobile_no,
                    'clg_third_party' => $thirdparty
                
                );

                fputcsv($fp, $inc_data);
            }
            fclose($fp);
            exit;
        }
    }

    function load_pda_district_report() {

        $post_reports = $this->input->post();

        $report_args = array(
            'district_code' => $post_reports['incient_district'],
            'base_month' => $this->post['base_month']
        );



        $report_data = $this->police_model->get_inc_by_police($report_args);


        $header = array('Incident ID',
            'Call Assign Time',
            'Caller Mobile No',
            'Caller Name',
            'District Name',
            'Chief Complaint',
            'Police Chief Complaint',
            'Police Station Name',
            'Mobile No',
            'Call Reciver Name',
            'Call Assign time to Police station',
            'Duration',
        );

        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            foreach ($report_data as $row) {



                $inc_data[] = array(
                    'inc_ref_id' => $row->pc_pre_inc_ref_id,
                    'pc_assign_time' => $row->pc_assign_time,
                    'clr_mobile' => $row->clr_mobile,
                    'clr_fullname' => $row->clr_fullname,
                    'po_ct_name' => $row->po_ct_name,
                    'dst_name' => $row->dst_name,
                    'police_station_name' => $row->police_station_name,
                    'p_station_mobile_no' => $row->p_station_mobile_no,
                    'pc_call_receiver_name' => $row->pc_call_receiver_name,
                    'pc_assign_call' => $row->pc_assign_call,
                    'inc_dispatch_time' => $row->inc_dispatch_time,
                    'inc_complaint' => $row->inc_complaint,
                );
            }


            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['submit_funtion'] = 'load_pda_district_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/inc_pda_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "pda_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            foreach ($report_data as $row) {

                $inc_data = array(
                    'inc_ref_id' => $row->pc_pre_inc_ref_id,
                    'pc_assign_time' => $row->pc_assign_time,
                    'clr_mobile' => $row->clr_mobile,
                    'clr_fullname' => $row->clr_fullname,
                    'dst_name' => $row->dst_name,
                    'chief' => get_cheif_complaint($row->inc_complaint),
                    'po_ct_name' => $row->po_ct_name,
                    'police_station_name' => $row->police_station_name,
                    'p_station_mobile_no' => $row->p_station_mobile_no,
                    'pc_call_receiver_name' => $row->pc_call_receiver_name,
                    'pc_assign_call' => $row->pc_assign_call,
                    'inc_dispatch_time' => $row->inc_dispatch_time,
                );

                fputcsv($fp, $inc_data);
            }
            fclose($fp);
            exit;
        }
    }

    function load_fire_district_report() {


        $post_reports = $this->input->post();

        $report_args = array(
            'district_code' => $post_reports['incient_district'],
            'base_month' => $this->post['base_month']
        );



        $report_data = $this->fire_model->get_inc_by_fire($report_args);


        $header = array('Incident ID',
            'Call Assign Time',
            'Caller Mobile No',
            'Caller Name',
            'District Name',
            'Chief Complaint',
            'Fire Chief Complaint',
            'Fire Station Name',
            'Mobile No',
            'Call Reciver Name',
            'Call Assign time to Fire station',
            'Duration',
        );

        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            foreach ($report_data as $row) {


                $inc_data[] = array(
                    'inc_ref_id' => $row->fc_pre_inc_ref_id,
                    'fc_assign_time' => $row->fc_assign_time,
                    'clr_mobile' => $row->clr_mobile,
                    'clr_fullname' => $row->clr_fullname,
                    'fi_ct_name' => $row->fi_ct_name,
                    'dst_name' => $row->dst_name,
                    'fire_station_name' => $row->fire_station_name,
                    'f_station_mobile_no' => $row->f_station_mobile_no,
                    'fc_call_receiver_name' => $row->fc_call_receiver_name,
                    'fc_assign_call' => $row->fc_assign_call,
                    'inc_dispatch_time' => $row->inc_dispatch_time,
                    'inc_complaint' => $row->inc_complaint,
                );
            }


            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['submit_funtion'] = 'load_fire_district_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/inc_fda_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "fda_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            foreach ($report_data as $row) {

                $inc_data = array(
                    'inc_ref_id' => $row->fc_pre_inc_ref_id,
                    'pc_assign_time' => $row->fc_assign_time,
                    'clr_mobile' => $row->clr_mobile,
                    'clr_fullname' => $row->clr_fullname,
                    'dst_name' => $row->dst_name,
                    'chief' => get_cheif_complaint($row->inc_complaint),
                    'fi_ct_name' => $row->fi_ct_name,
                    'fire_station_name' => $row->fire_station_name,
                    'f_station_mobile_no' => $row->f_station_mobile_no,
                    'fc_call_receiver_name' => $row->fc_call_receiver_name,
                    'fc_assign_call' => $row->fc_assign_call,
                    'inc_dispatch_time' => $row->inc_dispatch_time,
                );

                fputcsv($fp, $inc_data);
            }
            fclose($fp);
            exit;
        }
    }
    function load_fuel_filling_report()
    {
        $post_reports = $this->input->post();
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month']);
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month']);
        }
        $report_data = $this->ambmain_model->get_fuel_filling_data($report_args);
        $header = array('Sr.No',
            'Ticket Id',
            'Zone',
            'District',
            'Ambulance No',
            'Ambulance CUG No',
            'Ambulance Type',
            'Fuel Filling Type',
            'Base Location',
            'Filling Date & Time',
            'Pilot ID',
            'Pilot Name',
            'Pilot Number',
            'Fuel Station Name',
            'Other Fuel Station Name',
            'Fuel Station Mobile No',
            'Fuel Filling Previous Odometer',
            'Previous Odometer',
            'Current Refueling Odometer',
            'End Odometer After fueling',
            'Total KM Run',
            'Fuel filling[LTR]',
            'KMPL',
            'Fuel Rate',
            'Fuel Amount',
            'Payment Mode',
            'Bill No',
            'Standard Remark',
            'Other Standard Remark',
            'Update Remark',
            'Case Type Remark',
            'Added By ID',
            'Added By Name',
            'Added Date/Time',
        );
        if ($post_reports['reports'] == 'view') 
        {
            $inc_data = array();
            foreach ($report_data as $row) 
            {
                
                  $fuel_rate =0;
                if($row->ff_fuel_quantity >0){
                   $fuel_rate = number_format((float)((int)$row->ff_amount / (int)$row->ff_fuel_quantity), 2, '.', '');
                }

                $ff_payment='';
                if($row->ff_payment_mode  == 'fleet_card_payment'){
                    $ff_payment ='Fleet Card Payment';
                }
                else if($row->ff_payment_mode == 'voucher_payment'){
                     $ff_payment ='Voucher Payment';
                }
                else if($row->ff_payment_mode == 'Other'){
                     $ff_payment ='Other';
                }
                
                $filling_case ='';
                if($row->fuel_filling_case  == 'fuel_filling_during_case'){
                    $filling_case ='Fuel Filling During Case';
                }
                else if($row->fuel_filling_case == 'fuel_filling_without_case'){
                     $filling_case ='Fuel Filling Without Case';
                }
                $added_by_name = $row->clg_first_name." ".$row->clg_mid_name." ". $row->clg_last_name;
                if($row->ff_standard_remark  == 'ambulance_fuel_filling'){
                    $std_remark ='Ambulance Fuel Filling';
                }
                else if($row->ff_standard_remark == 'Other'){
                     $std_remark ='Fuel Filling Without Case';
                }

                if($row->f_station_name  == ''){
                    $row->f_station_name ='Other';
                }else
                {
                    $row->f_station_name = $row->f_station_name;
                }
                   $amount = $row->ff_amount;
                     $amount_in_digit = round($amount, 4);
                $inc_data[] = array(
                    'ff_gen_id' => $row->ff_gen_id,
                    'div_name' =>  $row->div_name,
                    'District' => $row->dst_name,
                    'ff_Ambulance_No' => $row->ff_amb_ref_no,
                    'amb_default_mobile' => $row->amb_default_mobile,
                    'amb_by_type' => $row->ambt_name,
                    'filling_case' => $filling_case,
                    'base_location' => $row->ff_base_location,
                    'filling_date_time' => $row->ff_fuel_date_time,
                    'pilot_id' => $row->ff_pilot_id,
                    'pilot_name' => $row->ff_pilot_name,
                    'pilot_number' => $row->clg_mobile_no,
                    'fuel_station_name' => $row->f_station_name,
                    'ff_other_fuel_station' => $row->ff_other_fuel_station,
                    'ff_fuel_mobile_no' => $row->ff_fuel_mobile_no,
                    'previous_odometer_filling' => $row->ff_fuel_previous_odometer,
                    'previous_odometer' => $row->ff_previous_odometer,
                    'refueling_odometer' => $row->ff_current_odometer,
                    'end_odometer_after_fueling' => $row->ff_end_odometer,
                    'total_KM_run' => $row->distance_travelled,
                    'fuel_filling_LTR' => $row->ff_fuel_quantity,
                    'KMPL' => $row->kmpl,
                    'fuel_rate' => $row->ff_rate,
                    'fuel_mount' => $amount_in_digit,
                    'payment_mode' => $ff_payment,
                    'voucher_Card_No' => $row->ff_voucher_no,
                    'update_remark' => $row->mt_on_remark,
                    'ff_standard_remark' => $std_remark,
                    'ff_other_remark' => $row->ff_other_remark,
                    'ff_case_type_remark' => $row->ff_case_type_remark,
                    'infromed_to' => '',
                    'enter_by' => $row->ff_added_by,
                    'enter_by_name' => $added_by_name,
                    'update_date_time' => $row->ff_added_date,
                );
            }
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['submit_funtion'] = 'load_fuel_filling_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/fuel_filling_data_report_view', $data, TRUE), 'list_table', TRUE);
        
        }else {
            $filename = "fuel_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            $count=1;
            foreach ($report_data as $row) {
                if($row->ff_fuel_date_time != NULL){
                    $add_date = date('Y-m-d', strtotime($row->ff_fuel_date_time));
                     $add_time = date('H:i:s', strtotime($row->ff_fuel_date_time));
                     $final_date= $add_date.'-'.$add_time;
                                 }
                                 else{
                                     $final_date= '';
                                 }
                    if($row->ff_added_date != NULL){
                    $add_date = date('Y-m-d', strtotime($row->ff_added_date));
                     $add_time = date('H:i:s', strtotime($row->ff_added_date));
                     $final_date1= $add_date.'-'.$add_time;
                                 }
                                 else{
                                     $final_date1= '';
                                 }
                $fuel_rate =0;
                if($row->ff_fuel_quantity >0){
                   $fuel_rate = number_format((float)((int)$row->ff_amount / (int)$row->ff_fuel_quantity), 2, '.', '');
               }
               $ff_payment='';
                if($row->ff_payment_mode == 'fleet_card_payment'){
                    $ff_payment ='Fleet Card Payment';
                }
                else if($row->ff_payment_mode == 'voucher_payment'){
                    $ff_payment ='Voucher Payment';
                }
                else if($row->ff_payment_mode == 'Other'){
                    $ff_payment ='Other';
                }

                $filling_case ='';
                if($row->fuel_filling_case  == 'fuel_filling_during_case'){
                    $filling_case ='Fuel Filling During Case';
                }
                else if($row->fuel_filling_case == 'fuel_filling_without_case'){
                     $filling_case ='Fuel Filling Without Case';
                }
                $added_by_name = $row->clg_first_name." ".$row->clg_mid_name." ". $row->clg_last_name;
                if($row->ff_standard_remark  == 'ambulance_fuel_filling'){
                    $std_remark ='Ambulance Fuel Filling';
                }
                else if($row->ff_standard_remark == 'Other'){
                     $std_remark ='Fuel Filling Without Case';
                }
                if($row->f_station_name  == ''){
                    $row->f_station_name ='Other';
                }else
                {
                    $row->f_station_name = $row->f_station_name;
                }
                $amount = $row->ff_amount;
                $amount_in_digit = round($amount, 4);
                $inc_data = array(
                    'Count' => $count,
                    'ff_gen_id' => $row->ff_gen_id,
                    'div_name' =>  $row->div_name,
                    'District' => $row->dst_name,
                    'ff_Ambulance_No' => $row->ff_amb_ref_no,
                    'amb_default_mobile' => $row->amb_default_mobile,
                    'amb_by_type' => $row->ambt_name,
                    'filling_case' => $filling_case,
                    'base_location' => $row->ff_base_location,
                    'filling_date_time' => $final_date,
                    'pilot_id' => $row->ff_pilot_id,
                    'pilot_name' => $row->ff_pilot_name,
                    'pilot_number' => $row->clg_mobile_no,
                    'fuel_station_name' => $row->f_station_name,
                    'ff_other_fuel_station' => $row->ff_other_fuel_station,
                    'ff_fuel_mobile_no' => $row->ff_fuel_mobile_no,
                    'previous_odometer_filling' => $row->ff_fuel_previous_odometer,
                    'previous_odometer' => $row->ff_previous_odometer,
                    'refueling_odometer' => $row->ff_current_odometer,
                    'end_odometer_after_fueling' => $row->ff_end_odometer,
                    'total_KM_run' => $row->distance_travelled,
                    'fuel_filling_LTR' => $row->ff_fuel_quantity,
                    'KMPL' => $row->kmpl,
                    'fuel_rate' =>  $row->ff_rate,
                    'fuel_mount' => $amount_in_digit,
                    'payment_mode' => $ff_payment,
                    'voucher_Card_No' => $row->ff_voucher_no,
                    'ff_standard_remark' => $row->ff_standard_remark,
                    'ff_other_remark' => $row->ff_other_remark,
                    'update_remark' => $row->mt_on_remark,
                    'ff_case_type_remark' => $row->ff_case_type_remark,
                    'enter_by' => ucwords($row->ff_added_by),
                    'enter_by_name' => $added_by_name,
                    'update_date_time' => $final_date1,
                );
                $count++;
                fputcsv($fp, $inc_data);
            }
            fclose($fp);
            exit;
        }
        
    }
    function load_pda_report() {

        $post_reports = $this->input->post();

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month']);
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month']);
        }


        $report_data = $this->police_model->get_inc_by_police($report_args);


        $header = array('Incident ID',
            'Call Assign Time',
            'Caller Mobile No',
            'Caller Name',
            'District Name',
            'Chief Complaint',
            'Police Chief Complaint',
            'Police Station Name',
            'Mobile No',
            'Call Receiver Name',
            'Call Assign time to Police station',
            'Duration',
            'Standard Remark',
            'Call Done By',
        );

        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            foreach ($report_data as $row) {
                $clg_id = array();
                if($row->pc_added_by != ''){
                    $clg_id = get_clg_data_by_ref_id($row->pc_added_by);
                }
               
                $inc_data[] = array(
                    'inc_ref_id' => $row->pc_pre_inc_ref_id,
                    'pc_assign_time' => $row->pc_assign_time,
                    'clr_mobile' => $row->clr_mobile,
                    'clr_fullname' => ucwords($row->clr_fname).' '.ucwords($row->clr_lname),
                    'po_ct_name' => $row->po_ct_name,
                    'dst_name' => $row->dst_name,
                    'police_station_name' => $row->police_station_name,
                    'p_station_mobile_no' => $row->p_station_mobile_no,
                    'pc_call_receiver_name' => $row->pc_call_receiver_name,
                    'pc_assign_call' => $row->pc_assign_call,
                    'inc_dispatch_time' => $row->inc_dispatch_time,
                    'inc_complaint' => $row->inc_complaint,
                    'pda_remark' => $row->pda_remark,
                    'pda_done_by' => $clg_id[0]->clg_first_name.' '.$clg_id[0]->clg_last_name,
                );
            }


            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['submit_funtion'] = 'load_pda_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/inc_pda_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "pda_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            foreach ($report_data as $row) {
                 $clg_id = array();
                if($row->pc_added_by != ''){
                    $clg_id = get_clg_data_by_ref_id($row->pc_added_by);
                }
                $inc_data = array(
                    'inc_ref_id' => $row->pc_pre_inc_ref_id,
                    'pc_assign_time' => $row->pc_assign_time,
                    'clr_mobile' => $row->clr_mobile,
                    'clr_fullname' => ucwords($row->clr_fname).' '.ucwords($row->clr_lname),
                    'dst_name' => $row->dst_name,
                    'chief' => get_cheif_complaint($row->inc_complaint),
                    'po_ct_name' => $row->po_ct_name,
                    'police_station_name' => $row->police_station_name,
                    'p_station_mobile_no' => $row->p_station_mobile_no,
                    'pc_call_receiver_name' => $row->pc_call_receiver_name,
                    'pc_assign_call' => $row->pc_assign_call,
                    'inc_dispatch_time' => $row->inc_dispatch_time,
                    'pda_remark' => $row->pda_remark,
                    'pda_done_by' => $clg_id[0]->clg_first_name.' '.$clg_id[0]->clg_last_name,
                );

                fputcsv($fp, $inc_data);
            }
            fclose($fp);
            exit;
        }
    }

    function load_nhm_104_report() {

        $post_reports = $this->input->post();
        // print_r($post_reports);die;

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month']);
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month']);
        }
        $report_data = $this->inc_model->get_nhm_104_all_call_by_date($report_args);
        // print_r($report_data);die;

        $header = array('Sr No',
            'Incident ID',
            'Call Receive Time',
            'Call End Date & Time',
            'Call Duration',
            'ERO Summary',
            'Standard Remark',
            'Call Type',
            'Call Purpose',
            'Complaint Name',
            'ERO Name',
            'ERO ID',
            'Caller Mobile Number',
            'Caller Name',
            'Patient Name',
            'Age',
            'Mobile Number',
            'Ayushman ID',
            'Blood Group',
            'Gender',
            'District',
            'Tehsil',
            'Area',
        );

        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            $count=1;
            foreach ($report_data as $row) {        
                $inc_data[] = array(
                    'sr_no' => $count++,
                    'inc_ref_id' => $row['inc_ref_id'],
                    'recieve_time' => $row['inc_recive_time'],
                    'end_time' => $row['inc_datetime'],
                    'call_time' => $row['inc_dispatch_time'],
                    'ero_summary' => $row['inc_ero_summary'],
                    'std_remark' => $row['re_name'],
                    'call_typ' => $row['call_type_name'],
                    'call_prps' => $row['cl_pur_name'],
                    'cmp_name' => $row['cmp_name'],
                    'ero_fullname' => ucwords($row['clg_first_name']).' '.ucwords($row['clg_mid_name']).' '.ucwords($row['clg_last_name']),
                    'ero_id' => $row['inc_added_by'],
                    'clr_no' => $row['clr_mobile'],
                    'clr_fullname' => ucwords($row['clr_fname']).' '.ucwords($row['clr_lname']),
                    'patient_fullname' => ucwords($row['ptn_fname']).' '.ucwords($row['ptn_mname']).' '.ucwords($row['ptn_lname']),
                    'age' => $row['ptn_age'],
                    'mob_no' => $row['ptn_mob_no'],
                    'ayu_id' => $row['ayushman_id'],
                    'blood_grp' => $row['bldgrp_name'],
                    'gen' => $row['ptn_gender'],
                    'dist' => $row['dst_name'],
                    'tah' => $row['thl_name'],
                    'area' => $row['inc_area'],
                    // 'inc_complaint' => $row->inc_complaint,
                    // 'pda_remark' => $row->pda_remark,
                    // 'pda_done_by' => $clg_id[0]->clg_first_name.' '.$clg_id[0]->clg_last_name,
                );
            }
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['submit_funtion'] = 'load_nhm_104_report';
            // print_r($data['inc_data']);die;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/nhm_104_final_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "104_all_call_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            $count=1;
            foreach ($report_data as $row) {
                $inc_data = array(
                    'sr_no' => $count,
                    'inc_ref_id' => $row['inc_ref_id'],
                    'recieve_time' => $row['inc_recive_time'],
                    'end_time' => $row['inc_datetime'],
                    'call_time' => $row['inc_dispatch_time'],
                    'ero_summary' => $row['inc_ero_summary'],
                    'std_remark' => $row['re_name'],
                    'call_typ' => $row['call_type_name'],
                    'call_prps' => $row['cl_pur_name'],
                    'cmp_name' => $row['cmp_name'],
                    'ero_fullname' => ucwords($row['clg_first_name']).' '.ucwords($row['clg_mid_name']).' '.ucwords($row['clg_last_name']),
                    'ero_id' => $row['inc_added_by'],
                    'clr_no' => $row['clr_mobile'],
                    'clr_fullname' => ucwords($row['clr_fname']).' '.ucwords($row['clr_lname']),
                    'patient_fullname' => ucwords($row['ptn_fname']).' '.ucwords($row['ptn_mname']).' '.ucwords($row['ptn_lname']),
                    'age' => $row['ptn_age'],
                    'mob_no' => $row['ptn_mob_no'],
                    'ayu_id' => $row['ayushman_id'],
                    'blood_grp' => $row['bldgrp_name'],
                    'gen' => $row['ptn_gender'],
                    'dist' => $row['dst_name'],
                    'tah' => $row['thl_name'],
                    'area' => $row['inc_area'],
                );
                $count++;
                fputcsv($fp, $inc_data);
            }
            fclose($fp);
            exit;
        }
    }

    function load_nhm_104_report_medical() {

        $post_reports = $this->input->post();
        // print_r($post_reports);die;

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month']);
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month']);
        }
        $report_data = $this->inc_model->get_nhm_104_medical_call_by_date($report_args);
        // print_r($report_data);die;

        $header = array('Sr No',
            'Incident ID',
            'Call Receive Time',
            'Incident Date and Time',
            'Call Duration',
            'ERO Summary',
            'Standard Remarks',
            'Call Type',
            'Chief Complaint',
            'ERO Name',
            'Added By',
            'Caller Mobile Number',
            'Caller Name',
            'Additional Information',
            'Impression',
            'Remark',
            'ERCP Chief Complaint',
            'ERCP Name',
            'Added By ERCP Name',
            'Patient Name',
            'Age',
            'Mobile Number',
            'Ayushman ID',
            'Blood Group',
            'Gender',
            'District',
            'Tehsil',
            'Area',
        );

        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            $count=1;
            foreach ($report_data as $row) {        
                $inc_data[] = array(
                    'sr_no' => $count++,
                    'inc_ref_id' => $row['inc_ref_id'],
                    'recieve_time' => $row['inc_recive_time'],
                    'end_time' => $row['inc_datetime'],
                    'call_time' => $row['inc_dispatch_time'],
                    'ero_summary' => $row['inc_ero_summary'],
                    'std_remark' => $row['re_name'],
                    'call_typ' => $row['pname'],
                    'cheif_cmp' => $row['cheif_comp'],
                    'ero_fullname' => ucwords($row['ero_first_name']).' '.ucwords($row['ero_mid_name']).' '.ucwords($row['ero_last_name']),
                    'added' => $row['inc_added_by'],
                    'clr_no' => $row['clr_mobile'],
                    'clr_fullname' => ucwords($row['clr_fname']).' '.ucwords($row['clr_lname']),
                    'additional_info' => $row['adv_cl_addinfo'],
                    'impression' => $row['adv_cl_pro_dia'],
                    'remark' => $row['adv_cl_ercp_addinfo'],
                    'ercp_cmp' => $row['epcr_comp'],
                    'ercp_name' => ucwords($row['ercp_first_name']).' '.ucwords($row['ercp_mid_name']).' '.ucwords($row['ercp_last_name']),
                    'added_by_ercp' => $row['adv_cl_added_by'],
                    'patient_fullname' => ucwords($row['ptn_fname']).' '.ucwords($row['ptn_mname']).' '.ucwords($row['ptn_lname']),
                    'age' => $row['ptn_age'],
                    'mob_no' => $row['ptn_mob_no'],
                    'ayu_id' => $row['ayushman_id'],
                    'blood_grp' => $row['bldgrp_name'],
                    'gen' => $row['ptn_gender'],
                    'dist' => $row['dst_name'],
                    'tah' => $row['thl_name'],
                    'area' => $row['inc_area'],
                );
            }
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['submit_funtion'] = 'load_nhm_104_report_medical';
            // print_r($data['inc_data']);die;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/nhm_104_medical_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "104_medical_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            $count=1;
            foreach ($report_data as $row) {
                $inc_data = array(
                    'sr_no' => $count,
                    'inc_ref_id' => $row['inc_ref_id'],
                    'recieve_time' => $row['inc_recive_time'],
                    'end_time' => $row['inc_datetime'],
                    'call_time' => $row['inc_dispatch_time'],
                    'ero_summary' => $row['inc_ero_summary'],
                    'std_remark' => $row['re_name'],
                    'call_typ' => $row['pname'],
                    'cheif_cmp' => $row['cheif_comp'],
                    'ero_fullname' => ucwords($row['ero_first_name']).' '.ucwords($row['ero_mid_name']).' '.ucwords($row['ero_last_name']),
                    'added' => $row['inc_added_by'],
                    'clr_no' => $row['clr_mobile'],
                    'clr_fullname' => ucwords($row['clr_fname']).' '.ucwords($row['clr_lname']),
                    'additional_info' => $row['adv_cl_addinfo'],
                    'impression' => $row['adv_cl_pro_dia'],
                    'remark' => $row['adv_cl_ercp_addinfo'],
                    'ercp_cmp' => $row['epcr_comp'],
                    'ercp_name' => ucwords($row['ercp_first_name']).' '.ucwords($row['ercp_mid_name']).' '.ucwords($row['ercp_last_name']),
                    'added_by_ercp' => $row['adv_cl_added_by'],  
                    'patient_fullname' => ucwords($row['ptn_fname']).' '.ucwords($row['ptn_mname']).' '.ucwords($row['ptn_lname']),
                    'age' => $row['ptn_age'],
                    'mob_no' => $row['ptn_mob_no'],
                    'ayu_id' => $row['ayushman_id'],
                    'blood_grp' => $row['bldgrp_name'],
                    'gen' => $row['ptn_gender'],
                    'dist' => $row['dst_name'],
                    'tah' => $row['thl_name'],
                    'area' => $row['inc_area'],           
                );
                $count++;
                fputcsv($fp, $inc_data);
            }
            fclose($fp);
            exit;
        }
    }

    function load_fire_report() {

        $post_reports = $this->input->post();

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
                'inc_system_type'=>$post_reports['system']);
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                'inc_system_type'=>$post_reports['system']);
        }


        $report_data = $this->fire_model->get_inc_by_fire($report_args);

        $header = array('Incident ID',
            'Call Assign Time',
            'Caller Mobile No',
            'Caller Name',
            'District Name',
            'Chief Complaint',
            'Fire Chief Complaint',
            'Fire Station Name',
            'Mobile No',
            'Call Reciver Name',
            'Call Assign time to Fire station',
            'Duration',
        );

        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            foreach ($report_data as $row) {



                $inc_data[] = array(
                    'inc_ref_id' => $row->fc_pre_inc_ref_id,
                    'fc_assign_time' => $row->fc_assign_time,
                    'clr_mobile' => $row->clr_mobile,
                    'clr_fullname' => $row->clr_fullname,
                    'fi_ct_name' => $row->fi_ct_name,
                    'dst_name' => $row->dst_name,
                    'fire_station_name' => $row->fire_station_name,
                    'f_station_mobile_no' => $row->f_station_mobile_no,
                    'fc_call_receiver_name' => $row->fc_call_receiver_name,
                    'fc_assign_call' => $row->fc_assign_call,
                    'inc_dispatch_time' => $row->inc_dispatch_time,
                    'inc_complaint' => $row->inc_complaint,
                );
            }


            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['submit_funtion'] = 'load_fire_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/inc_fda_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "fire_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            foreach ($report_data as $row) {

                $inc_data = array(
                    'inc_ref_id' => $row->fc_pre_inc_ref_id,
                    'fc_assign_time' => $row->fc_assign_time,
                    'clr_mobile' => $row->clr_mobile,
                    'clr_fullname' => $row->clr_fullname,
                    'dst_name' => $row->dst_name,
                    'chief' => get_cheif_complaint($row->inc_complaint),
                    'fi_ct_name' => $row->fi_ct_name,
                    'fire_station_name' => $row->fire_station_name,
                    'f_station_mobile_no' => $row->f_station_mobile_no,
                    'fc_call_receiver_name' => $row->fc_call_receiver_name,
                    'fc_assign_call' => $row->fc_assign_call,
                    'inc_dispatch_time' => $row->inc_dispatch_time,
                );

                fputcsv($fp, $inc_data);
            }
            fclose($fp);
            exit;
        }
    }
    function closure_dco_datewise_report() {

        $post_reports = $this->input->post();
        
        $track_args = array('trk_report_name'=>'Closure Report closure datewise','trk_download_by'=>$this->clg->clg_ref_id);
        track_report_download($track_args);
        

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;
        $thirdparty = $this->clg->thirdparty;
        $district = $this->clg->clg_district_id;
        $clg_district_id = json_decode($district);
        if(is_array($clg_district_id)){
            $district_id = implode("','",$clg_district_id);
        }
     


        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
                'thirdparty' => $thirdparty,
                'system' => $post_reports['system'],
                'clg_district_id' => $district_id );
        } else {
            
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                'thirdparty' => $thirdparty,
                'system' => $post_reports['system'],
                'clg_district_id' => $district_id );
        }
        $report_args['system']=$post_reports['system'];

        $report_data = $this->inc_model->get_epcr_by_month_closure_datewise($report_args);
       

      $header = array(
            'Sr.No',
            'Incident ID',
            'Incident Date /Time',
            'Closure Date / Time',
            'Call Type',
            // 'Parameter',
            'Ambulance No',
            'Ambulance Type',
            'Base Location',
            // 'Ward Name',
            'Victim ID',
            'Ambulance District',
            'Patient ID',
            'Patient Name',
            'Age',
            'Gender',
            'Caller Name',
            'caller Mobile',
            'Incident District',
            'Address',
            'Inc. Area Type',
            'EMT ID',
            'EMT Name',
            'PILOT ID',
            'PILOT Name',
            'LOC',
            'ERCP Advice',
            'ERCP Name',
            // 'Case Type',
            'Provider Impression',
            'Provider Impression Other',
            'Receiving Hospital District',
            'Receiving Hospital Name',
            'Hospital Code',
            'Other-Receiving Hospital',
            'Previous Odometer',
            'Start Odometer',
            'Scene Odometer',
            'From Scene Odometer',
            'Handover Odometer',
            'Hospital Odometer',
            'End Odometer',
            'Total Distance Travel',
            // 'Response Time Remark',
            // 'Odometer Difference Remark',
            'Remark',
            'Patinent Availability status',
            // 'DCO ID',
            'Operate By',
            'Assign By',
            // 'Third Party',
            'B12 Type',
            'Validation Done by','Validation Status','Validation Remark','Validation Date time'
   );

        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
           // var_dump($report_data);die;
             
            foreach($report_data as $row) {
                
               
                $incient_district = $this->inc_model->get_district_by_id($row['district_id']);
                $dst_name = $incient_district->dst_name;
                
                $hp_dst_name = "";
              
                if($row['hp_district'] != '' && $row['hp_district'] != 0  && $row['hp_district'] != NULL){
                    $incient_district = $this->inc_model->get_district_by_id($row['hp_district']);
                    $hp_dst_name = $incient_district->dst_name;
                }
                  

                $city_id = $this->inc_model->get_city_by_id($row['city_id'], $row['district_id']);
                $cty_name = $city_id->cty_name;
              
                 $amb_dist = '';
                if($row['amb_district'] != ''){
                $amb_district = $this->inc_model->get_district_by_id($row['amb_district']);
                $amb_dist = $amb_district->dst_name;
                }

                $amb_type_id1 = $this->inc_model->get_amb_type($row['amb_reg_id']);
               
                $amb_type_id = $amb_type_id1->amb_type;
                
                $amb_type= show_amb_type_name($amb_type_id);
               //var_dump($amb_type_id1);die;
                $transport_respond_amb_no = $row['amb_rto_register_no'];


                $call_recived_date = date('Y-m-d', strtotime($row['inc_date']));
                $inc_time = explode(" ", $row['inc_date']);

                $driver_data = $this->pcr_model->get_driver(array('dp_pcr_id' => $row['epcr_id']));
               // var_dump($driver_data);

                $base_loc_time = $call_recived_date . ' ' . $driver_data[0]->dp_started_base_loc;

                $time1 = $driver_data[0]->dp_reach_on_scene;

                $time2 = $driver_data[0]->dp_started_base_loc;

                $time1 = explode(' ', $time1);
                $time2 = explode(' ', $time2);
                
                $time1 = new DateTime(date('Y-m-d H:i:s', strtotime( $driver_data[0]->dp_reach_on_scene)));
                $time2 = new DateTime(date('Y-m-d H:i:s', strtotime($driver_data[0]->dp_started_base_loc)));
                

                
//                $minutes1 = ($array1[0] * 60 + $array1[1]);
//                $minutes2 = ($array2[0] * 60 + $array2[1]);

                //$diff = $minutes1 - $minutes2;
               // $diff = date_diff($time2, $time1);
               // $resonse_time = '';


                if ($driver_data[0]->dp_started_base_loc != '00:00:00') {

                    $base_loc_time = new DateTime(date('Y-m-d H:i:s', strtotime($base_loc_time)));
                    $inc_datetime = new DateTime(date('Y-m-d H:i:s', strtotime($row['inc_date'])));
                    $resonse_time = date_diff($base_loc_time, $inc_datetime);
                    $resonse_time = $resonse_time->h . ':' . $resonse_time->i . ':' . $resonse_time->s;
                }
//                if ($diff > 0) {
//                    $resonse_time = $diff . ' Minutes';
//                } else {
//                    $resonse_time = '0 Minutes';
//                }

                $amb_arg = array('rg_no' => $row['amb_reg_id']);
              /*  $amb_data = $this->amb_model->get_amb_data($amb_arg);
                $amb_base_location = $amb_data[0]->hp_name;

                 if($amb_base_location == ''){ $amb_base_location = $amb_data[0]->ward_name; }else{ $amb_base_location = $amb_data[0]->hp_name; }
                //  $resonse_time = '';   
                // var_dump($resonse_time);*/
                /*if ($row['rec_hospital_name'] == '0') {
                    $hp_name = 'Other';
                } else if ($row['rec_hospital_name'] == 'Other') {
                    $hp_name = 'Other';
                } else {
                    $hp_name = $row['hp_name'];
                }
                if($row['ptn_gender']=='M')
                {
                    $gender='Male';
                }else if($row['ptn_gender']=='F'){
                    $gender='Female';
                }else{
                    $gender='Other';
                }*/
                if ($row['rec_hospital_name'] == 'Other' || $row['rec_hospital_name'] == '0' || $row['rec_hospital_name'] == '') {
                    $hp_name = 'Other';
                    $hos_code = '';
                } else if ($row['rec_hospital_name'] == 'on_scene_care'){
                    $hp_name = 'On Scene Care';
                    $hos_code = '';
                } else if ($row['rec_hospital_name'] == 'at_scene_care'){
                    $hp_name = 'At Scene Care';
                    $hos_code = '';
                }else {
                    $hp_name = $row['hp_name'];
                    $hos_code = $row['hp_code'];
                } 
                if($row['ptn_gender']=='M')
                {
                    $gender='Male';
                }else if($row['ptn_gender']=='F'){
                    $gender='Female';
                }else if($row['ptn_gender']=='O'){
                    $gender='Transgender';
                }else{
                    $gender='-';
                }
                
                $responce_time= '';
                $end_odometer_remark= '';
//                if($_SERVER['REMOTE_ADDR'] == '157.47.20.53'){
//                    var_dump($driver_data);
//                }
                
               // var_dump($driver_data[0]->responce_time_remark);
                 if($driver_data[0]->responce_time_remark != ""){
                    $responce_time=get_responce_time_remark($driver_data[0]->responce_time_remark);
                }
                if($row['end_odometer_remark'] != ""){
                    $end_odometer_remark=get_end_odo_remark($row['end_odometer_remark']);
                }

                $ercp_advice = "";
                if($row['ercp_advice'] == 'advice_No'){
                    $ercp_advice = "No";
                }else if($row['ercp_advice'] == 'advice_Yes'){
                    $ercp_advice = "Yes";
                }
                if($row['emso_id'] == ''){
                    $row['emt_name']="";
                }
                $b12_name = '';
                $accident  = array('15','58');
                $assault  = array('6');
                $burns  = array('14');
                $cardiac = array('8','9','10');
                $fall = array('54');
                $poision_data = array('13','23','50');
                $pregnancy = array('24','34');
                $Lighting = array('55');
                $mass = array('56');
                $medical = array('1','3','4','5','7','16','17','18','19','20','22','25','26','27','28','29','30','31','32','37','38','39','47','48','49','51','52','53');
                $others = array('21','35','36','45','46');
                $trauma = array('2','33');
                $suicide = array('40');
                $delivery = array('11','12');
                $manage_veti = array('57');
                $unavail = array('41','42','43','44');
                
                if(in_array($row['provider_impressions'],$accident)){
                    $b12_name = 'Accident Vehicle'; 
                }else if(in_array($row['provider_impressions'],$assault)){
                    $b12_name = 'Assault'; 
                }else if(in_array($row['provider_impressions'],$burns)){
                    $b12_name = 'Burns'; 
                }else if(in_array($row['provider_impressions'],$cardiac)){
                    $b12_name = 'Cardiac'; 
                }else if(in_array($row['provider_impressions'],$fall)){
                    $b12_name = 'Fall'; 
                }else if(in_array($row['provider_impressions'],$poision_data)){
                    $b12_name = 'Intoxication_Poisoning'; 
                }else if(in_array($row['provider_impressions'],$pregnancy)){
                    $b12_name = 'Labour/Pregnancy'; 
                }else if(in_array($row['provider_impressions'],$Lighting)){
                    $b12_name = 'Lighting/Electrocution'; 
                }else if(in_array($row['provider_impressions'],$mass)){
                    $b12_name = 'Mass Casualty'; 
                }else if(in_array($row['provider_impressions'],$medical)){
                    $b12_name = 'Medical'; 
                }else if(in_array($row['provider_impressions'],$others)){
                    $b12_name = 'Others'; 
                }else if(in_array($row['provider_impressions'],$trauma)){
                    $b12_name = 'Poly Trauma'; 
                }else if(in_array($row['provider_impressions'],$suicide)){
                    $b12_name = 'Suicide/Self Inflicted Injury'; 
                }else if(in_array($row['provider_impressions'],$delivery)){
                    $b12_name = 'Delivery In Ambulance'; 
                }else if(in_array($row['provider_impressions'],$manage_veti)){
                    $b12_name = 'Manage veti data'; 
                }else if(in_array($row['provider_impressions'],$unavail)){
                    $b12_name = 'Unavail call data'; 
                }
                
                $jobclosuredate=date('Y-m-d', strtotime($row['closure_date'])).' '.date('H:i:s', strtotime($row['jctime']));
                if($row['is_validate'] == 1){
                    $is_validate = "Validation Done";
                }else{
                    $is_validate = "Validation Pending";
                }
               
                if($row['epcr_call_type'] == '' || $row['epcr_call_type'] == NULL){                  
                    if($row['patient_ava_or_not'] == 'yes'){
                        $epcr_call_type = '2';
                    }else if($row['patient_ava_or_not']  == 'no'){
                        $epcr_call_type = '1';
                    }else if($row['patient_ava_or_not']  == '' && $row['patient_ava_or_not']  == NULL){
                        $epcr_call_type = '3';
                    }               
                }else{
                    $epcr_call_type = $row['epcr_call_type'] ;
                }
                $patinent_availability_status = "-";
                if($epcr_call_type != ''){
                    $call_type = $this->pcr_model->get_calltype_epcr(array('id' => $epcr_call_type));
                    $patinent_availability_status = $call_type[0]->call_type;
                }
                
                $inc_data[] = array(
                    'inc_datetime' => $row['inc_date'],
                    'inc_date' =>  $row['added_date'],
                    'inc_ref_id' => $row['inc_reference_id'],
                    'inc_purpose'=> $row['inc_purpose'],
                    'response_time' => $resonse_time,
                    'amb_rto_register_no' => $row['amb_reg_id'],
                    'amb_type' => $amb_type,
                    'parameter'=>'Medical',
                    'patient_id' => $row['ptn_id'],
                    'patient_name' => $row['ptn_fname']." ".$row['ptn_lname'],
                    'ptn_age' => $row['ptn_age']." ".$row['ptn_age_type'],
                    'ptn_gender' => $gender,
                    'caller_name' => $row['clr_fname']." ".$row['clr_lname'],
                    'caller_mobile' => $row['clr_mobile'],
                    'district' => $dst_name,
                    'hos_district' => $hp_dst_name,
                    'cty_name' => $cty_name,
                    'locality' => $row['locality'],
                    'inc_area_type' => $row['inc_area_type'],
                    'emt_id' => $row['emso_id'],
                    'emt_name' => $row['emt_name'],
                    'pilot_id' => $row['pilot_id'],
                    'pilot_name' => $row['pilot_name'],
                    'level_type' => $row['level_type'],
                    'ercp_advice' => $ercp_advice,
                    'ercp_advice_Taken' => $row['ercp_advice_Taken'],
                    'case_name' => $row['case_name'],
                    'provier_img' => $row['pro_name'],
                    'other_provider_img' => $row['other_provider_img'],
                    'amb_district' => $amb_dist,
                    'base_location' => $hp_name,
                    'hospital_code'=>$hos_code,
                    'other_receiving_host' => $row['other_receiving_host'],
                    'amb_base_location' => $row['inc_base_location_name'],
                    'wrd_location' => $row['inc_ward_name'],
                    'operate_by' => $row['operate_by'],
                    'start_odo' => $row['start_odometer'],
                    'scene_odometer' => $row['scene_odo'],
                    'from_scene_odometer' => $row['from_scene_odo'],
                    'handover_odometer' => $row['handover_odo'],
                    'hospital_odometer' => $row['hospital_odo'],
                    'end_odo' => $row['end_odometer'],
                    'total_km' => $row['total_km'],
                    'responce_time_remark' => $responce_time,
                    'odo_remark' => $end_odometer_remark,
                    'remark' => $row['remark'],
                    'patinent_availability_status'=>$patinent_availability_status,
                    'dco_id' => get_clg_name_by_ref_id($row['operate_by']),
                    'ero_id' => get_clg_name_by_ref_id($row['inc_added_by']),
                    'Thirdparty' => $row['thirdparty_name'],
                    'b12_type' => $b12_name,
                    'validation_done'=>$row['validate_by'],
                    'is_validate'=>$is_validate,
                    'valid_remark'=>$row['valid_remark'],
                    'validate_date'=>$row['validate_date'],
                    
                );
            }
        
        
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['submit_function'] ='closure_dco_datewise_report';

            $this->output->add_to_position($this->load->view('frontend/erc_reports/inc_closure_report_view', $data, TRUE), 'list_table', TRUE);
      } else {
            $filename = "closure_report_closure_datewise.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            $count=1;
            foreach ($report_data as $row) {
                
                
                
                $incient_district = $this->inc_model->get_district_by_id($row['district_id']);
                $dst_name = $incient_district->dst_name;
                
                $hp_dst_name = '';
                if($row['hp_district'] != '' && $row['hp_district'] != 0  && $row['hp_district'] != NULL){
                    $hops_district = $this->inc_model->get_district_by_id($row['hp_district']);
                    $hp_dst_name = $hops_district->dst_name;
                }


                $city_id = $this->inc_model->get_city_by_id($row['city_id'], $row['district_id']);
                $cty_name = $city_id->cty_name;


                $transport_respond_amb_no = $row['amb_rto_register_no'];


                $call_recived_date = date('Y-m-d', strtotime($row['inc_date']));
                $inc_time = explode(" ", $row['inc_date']);
                $driver_data = $this->pcr_model->get_driver(array('dp_pcr_id' => $row['epcr_id']));



                $amb_arg = array('rg_no' => $row['amb_reg_id']);
               /* $amb_data = $this->amb_model->get_amb_data($amb_arg);
                $amb_base_location = $amb_data[0]->hp_name;
                if($amb_base_location == ''){ $amb_base_location = $amb_data[0]->ward_name; }else{ $amb_base_location = $amb_data[0]->hp_name; }
                */
              /*  if ($row['rec_hospital_name'] == '0') {
                    $hp_name = 'Other';
                } else if ($row['rec_hospital_name'] == 'Other') {
                    $hp_name = 'Other';
                } else {
                    $hp_name = $row['hp_name'];
                }
                if($row['ptn_gender']=='M')
                {
                    $gender='Male';
                }else if($row['ptn_gender']=='F'){
                    $gender='Female';
                }else{
                    $gender='Other';
                }*/
                if ($row['rec_hospital_name'] == 'Other' || $row['rec_hospital_name'] == '0' || $row['rec_hospital_name'] == '') {
                    $hp_name = 'Other';
                    $hos_code = '';
                } else if ($row['rec_hospital_name'] == 'on_scene_care'){
                    $hp_name = 'On Scene Care';
                    $hos_code = '';
                } else if ($row['rec_hospital_name'] == 'at_scene_care'){
                    $hp_name = 'At Scene Care';
                    $hos_code = '';
                }else {
                    $hp_name = $row['hp_name'];
                    $hos_code = $row['hp_code'];
                } 
                if($row['ptn_gender']=='M')
                {
                    $gender='Male';
                }else if($row['ptn_gender']=='F'){
                    $gender='Female';
                }else if($row['ptn_gender']=='O'){
                    $gender='Transgender';
                }else{
                    $gender='-';
                }
                if($row['inc_date_time'] != NULL){
                    $add_date = date('Y-m-d', strtotime($row['inc_date_time']));
                     $add_time = date('H:i:s', strtotime($row['inc_date_time']));
                     $final_date= $add_date.'-'.$add_time;
                                 }
                                 else{
                                     $final_date= '';
                                 }
                   
                                 if($row['dp_date'] != NULL){
                    $add_date = date('Y-m-d', strtotime($row['dp_date']));
                     $add_time = date('H:i:s', strtotime($row['dp_date']));
                     $final_date1= $add_date.'-'.$add_time;
                                 }
                                 else{
                                     $final_date1= '';
                                 }

                $responce_time= '';
                $end_odometer_remark= '';
                if($driver_data[0]->responce_time_remark != ""){
                    $responce_time=get_responce_time_remark($driver_data[0]->responce_time_remark);
                }
                if($row['end_odometer_remark'] != ""){
                    $end_odometer_remark=get_end_odo_remark($row['end_odometer_remark']);
                }
                $amb_district = $this->inc_model->get_district_by_id($row['amb_district']);
                $amb_dist = $amb_district->dst_name;

                $amb_type_id1 = $this->inc_model->get_amb_type($row['amb_reg_id']);
               
                $amb_type_id = $amb_type_id1->amb_type;
                if($amb_type_id =='1')
                {
                    $amb_type= 'JE';
                }
                elseif($amb_type_id =='2')
                {
                    $amb_type= 'BLS'; 
                }
                else{
                    $amb_type= 'ALS';
                }
                 $ercp_advice = "";
                if($row['ercp_advice'] == 'advice_No'){
                    $ercp_advice = "No";
                }else if($row['ercp_advice'] == 'advice_Yes'){
                    $ercp_advice = "Yes";
                }
                $parameter='Medical';
                                $b12_name = '';
                $accident  = array('15','58');
                $assault  = array('6');
                $burns  = array('14');
                $cardiac = array('8','9','10');
                $fall = array('54');
                $poision_data = array('13','23','50');
                $pregnancy = array('24','34');
                $Lighting = array('55');
                $mass = array('56');
                $medical = array('1','3','4','5','7','16','17','18','19','20','22','25','26','27','28','29','30','31','32','37','38','39','47','48','49','51','52','53');
                $others = array('21','35','36','45','46');
                $trauma = array('2','33');
                $suicide = array('40');
                $delivery = array('11','12');
                $manage_veti = array('57');
                $unavail = array('41','42','43','44');
                
                if(in_array($row['provider_impressions'],$accident)){
                    $b12_name = 'Accident Vehicle'; 
                }else if(in_array($row['provider_impressions'],$assault)){
                    $b12_name = 'Assault'; 
                }else if(in_array($row['provider_impressions'],$burns)){
                    $b12_name = 'Burns'; 
                }else if(in_array($row['provider_impressions'],$cardiac)){
                    $b12_name = 'Cardiac'; 
                }else if(in_array($row['provider_impressions'],$fall)){
                    $b12_name = 'Fall'; 
                }else if(in_array($row['provider_impressions'],$poision_data)){
                    $b12_name = 'Intoxication_Poisoning'; 
                }else if(in_array($row['provider_impressions'],$pregnancy)){
                    $b12_name = 'Labour/Pregnancy'; 
                }else if(in_array($row['provider_impressions'],$Lighting)){
                    $b12_name = 'Lighting/Electrocution'; 
                }else if(in_array($row['provider_impressions'],$mass)){
                    $b12_name = 'Mass Casualty'; 
                }else if(in_array($row['provider_impressions'],$medical)){
                    $b12_name = 'Medical'; 
                }else if(in_array($row['provider_impressions'],$others)){
                    $b12_name = 'Others'; 
                }else if(in_array($row['provider_impressions'],$trauma)){
                    $b12_name = 'Poly Trauma'; 
                }else if(in_array($row['provider_impressions'],$suicide)){
                    $b12_name = 'Suicide/Self Inflicted Injury'; 
                }else if(in_array($row['provider_impressions'],$delivery)){
                    $b12_name = 'Delivery In Ambulance'; 
                }else if(in_array($row['provider_impressions'],$manage_veti)){
                    $b12_name = 'Manage veti data'; 
                }else if(in_array($row['provider_impressions'],$unavail)){
                    $b12_name = 'Unavail call data'; 
                }
                 if($row['epcr_call_type'] == '' || $row['epcr_call_type'] == NULL){                  
                    if($row['patient_ava_or_not'] == 'yes'){
                        $epcr_call_type = '2';
                    }else if($row['patient_ava_or_not']  == 'no'){
                        $epcr_call_type = '1';
                    }else if($row['patient_ava_or_not']  == '' && $row['patient_ava_or_not']  == NULL){
                        $epcr_call_type = '3';
                    }               
                }else{
                    $epcr_call_type = $row['epcr_call_type'] ;
                }
                $patinent_availability_status = "-";
                if($epcr_call_type != ''){
                    $call_type = $this->pcr_model->get_calltype_epcr(array('id' => $epcr_call_type));
                    $patinent_availability_status = $call_type[0]->call_type;
                }
                if($row['is_validate'] == 1){
                    $is_validate = "Validation Done";
                }else{
                    $is_validate = "Validation Pending";
                }
                $jobclosuredate=date('Y-m-d', strtotime($row['closure_date'])).' '.date('H:i:s', strtotime($row['jctime']));
                $inc_data = array(
                    'sr_no' => $count,
                    'inc_ref_id' => $row['inc_reference_id'],
                    'inc_datetime' => $row['inc_date'],
                    'inc_date' => $row['added_date'],
                    'call_type' => $row['pname'],
                    // 'parameter' => $parameter,
                    'amb_rto_register_no' => $row['amb_reg_id'],
                    'amb_type' => $amb_type,       
                    'amb_base_location' => $row['inc_base_location_name'],
                    // 'wrd_location' => $row['inc_ward_name'],
                    'Victim_id' => $row['inc_reference_id']." ".$row['patient_id'],
                    'amb_district' => $amb_dist,
                    'patient_id' => $row['ptn_id'],
                    'patient_name' => $row['ptn_fname']." ".$row['ptn_lname'],
                    'ptn_age' => $row['ptn_age'],
                    'ptn_gender' => $gender,
                    'caller_name' => $row['clr_fname']." ".$row['clr_lname'],
                    'caller_mobile' => $row['clr_mobile'],
                    'district' => $dst_name,
                    'locality' => $row['locality'],
                    'inc_area_type'=>$row['inc_area_type'],
                    'emt_id' => $row['emso_id'],
                    'emt_name' => $row['emt_name'],
                    'pilot_id' => $row['pilot_id'],
                    'pilot_name' => $row['pilot_name'],
                    'level_type' => $row['level_type'],
                    'ercp_advice' => $ercp_advice,
                    'ercp_advice_Taken' => $row['ercp_advice_Taken'],
                    // 'case_name' => $row['case_name'],
                    'provier_img' => $row['pro_name'],
                    'other_provider_img' => $row['other_provider_img'],
                    'hos_district' => $hp_dst_name,
                    'base_location' => $hp_name,
                    'hospital_code' =>$hos_code,
                    'Other_receiving_hos' => $row['other_receiving_host'],
                    'start_odo' => $row['start_odometer'],
                    'start_odo1' => $row['start_odometer'],
                    'scene_odometer' => $row['scene_odo'],
                    'from_scene_odometer' => $row['from_scene_odo'],
                    'handover_odometer' => $row['handover_odo'],
                    'hospital_odometer' => $row['hospital_odo'],
                    'end_odo' => $row['end_odometer'],
                    'total_km' => $row['total_km'],
                    // 'responce_time_remark' => $responce_time,
                    // 'odo_remark' => $end_odometer_remark,
                    'remark' => $row['remark'],
                    'patinent_availability_status'=>$patinent_availability_status,
                    'dco_id' => get_clg_name_by_ref_id($row['operate_by']),
                    'ero_id' => get_clg_name_by_ref_id($row['inc_added_by']),
                    // 'third' => $row['thirdparty_name'],
                    'b12_name' => $b12_name,
                    'validation_done'=>$row['clg_first_name'].' '.$row['clg_last_name'],
                    'is_validate'=>$is_validate,
                    'valid_remark'=>$row['valid_remark'],
                    'validate_date'=>$row['validate_date'],
                );

                fputcsv($fp, $inc_data);
                $count++;
            }
            fclose($fp);
            exit;
        }
    }
    function closure_lat_long_dco_report(){
        $post_reports = $this->input->post();
        
        $track_args = array('trk_report_name'=>'Closure Report Incident datewise','trk_download_by'=>$this->clg->clg_ref_id);
        track_report_download($track_args);

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        $thirdparty = $this->clg->thirdparty;
        $district = $this->clg->clg_district_id;
        $clg_district_id = json_decode($district);
        if(is_array($clg_district_id)){
            $district_id = implode("','",$clg_district_id);
        }


        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
                // 'thirdparty' => $thirdparty,
                'system' => $post_reports['system'],
                //'clg_district_id' => $district_id 
            );
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                // 'thirdparty' => $thirdparty,
                'system' => $post_reports['system'],
                //'clg_district_id' => $district_id 
            );
        }

        //var_dump($report_args);die();
        $report_data = $this->inc_model->get_epcr_lat_long_by_month($report_args);
    //   var_dump($report_data);
    //    die();

       
        $header = array('Sr.No',
            'Incident ID',
            'Incident Date /Time',
            'Closure Date / Time',
            'Call Type',
            'Ambulance No',
            'Ambulance Type',
            'Base Location',
            //'Victim ID',
            'Ambulance District',
            'Patient ID',
            'Patient Name',
            'Age',
            'Gender',
            'caller Name',
            'caller Mobile ',
            'Incident District',
            'Address',
            'Inc. Area Type',
            'EMT ID',
            'EMT Name',
            'PILOT ID',
            'PILOT Name',
            'LOC',
            'ERCP Advice',
            'ERCP Name',
            'Provider Impression',
            'Provider Impression Other',
            'Receiving Hospital District',
            'Receiving Hospital Name',
            'Receiving Hospital Code',
            'Other-Receiving Hospital',
            'Previous Odometer',
            'Start Odometer',
            'Scene Odometer',
            'From Scene Odometer',
            'Handover Odometer',
            'Hospital Odometer',
            'End Odometer',
            'Total Distance Travel',
            'Scene Lat',
            'Scene Long',
            'Back To Base Lat',
            'Back To Base Long',
           // 'Response Time Remark',
           // 'Odometer Difference Remark',
            'Remark',
            'Patinent Availability status',
            'Operate By',
            'Assign By',
            'B12 type',
            'Validation Done by','Validation Status','Validation Remark','Validation Date time');

        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            foreach ($report_data as $row) {
                
                $dst_name = '';
                if($row['district_id'] != ''){
                    $incient_district = $this->inc_model->get_district_by_id($row['district_id']);
                    $dst_name = $incient_district->dst_name;
                }

                if($row['amb_district'] != ''){
                    $amb_district = $this->inc_model->get_district_by_id($row['amb_district']);
                    $amb_dist = $amb_district->dst_name;
                }
                $amb_type_id1 = $this->inc_model->get_amb_type($row['amb_reg_id']);
                $amb_type = $amb_type_id1->ambt_name;
                
                if ($row['rec_hospital_name'] == 'Other' || $row['rec_hospital_name'] == '0' || $row['rec_hospital_name'] == '') {
                    $hos_name = 'Other';
                    $hos_code = '';
                } else if ($row['rec_hospital_name'] == 'on_scene_care'){
                    $hos_name = 'On Scene Care';
                    $hos_code = '';
                } else if ($row['rec_hospital_name'] == 'at_scene_care'){
                    $hos_name = 'At Scene Care';
                    $hos_code = '';
                }else {
                    $hos_name = $row['hp_name'];
                    $hos_code = $row['hp_code'];
                } 

                if($row['ptn_gender']=='M')
                {
                    $gender='Male';
                }else if($row['ptn_gender']=='F'){
                    $gender='Female';
                }else if($row['ptn_gender']=='O'){
                    $gender='Transgender';
                }else{
                    $gender='-';
                }
             
                  $hp_dst_name = "";
               
                if($row['hp_district'] != '' && $row['hp_district'] != 0 && $row['hp_district'] != NULL){
                    $incient_district = $this->inc_model->get_district_by_id($row['hp_district']);
                    $hp_dst_name = $incient_district->dst_name;
                }
                
                if($row['is_validate'] == 1){
                    $is_validate = "Validation Done";
                }else{
                    $is_validate = "Validation Pending";
                }
              
                $inc_date = date("d-m-Y H:i:s", strtotime($row['inc_datetime']));
                $date = date("d-m-Y", strtotime($row['date']));
                
                if($row['epcr_call_type'] == '' || $row['epcr_call_type'] == NULL){                  
                    if($row['patient_ava_or_not'] == 'yes'){
                        $epcr_call_type = '2';
                    }else if($row['patient_ava_or_not']  == 'no'){
                        $epcr_call_type = '1';
                    }else if($row['patient_ava_or_not']  == '' && $row['patient_ava_or_not']  == NULL){
                        $epcr_call_type = '3';
                    }               
                }else{
                    $epcr_call_type = $row['epcr_call_type'] ;
                }
                $patinent_availability_status = "-";
                if($epcr_call_type != ''){
                    $call_type = $this->pcr_model->get_calltype_epcr(array('id' => $epcr_call_type));
                    $patinent_availability_status = $call_type[0]->call_type;
                }
                $ercp_name = ucwords(strtolower($row['clg_first_name'].' '.$row['clg_mid_name'].' '.$row['clg_last_name']));

                $inc_data[] = array(
                    'inc_datetime' => $inc_date,
                    'inc_date' => $row['added_date'],
                    'inc_purpose' => $row['pname'],
                    'inc_ref_id' => $row['incident_id'],
                    'amb_rto_register_no' => $row['amb_reg_id'],
                    'amb_type' => $amb_type,
                    'amb_district' => $amb_dist,
                    'patient_id' => $row['ptn_id'],
                    'patient_name' => ucwords(strtolower($row['ptn_fname']." ".$row['ptn_lname'])),
                    'caller_name' => ucwords(strtolower($row['clr_fname']." ".$row['clr_lname'])),
                    'caller_mobile' => $row['clr_mobile'],
                    'ptn_age' => $row['ptn_age']." ".$row['ptn_age_type'],
                    'ptn_gender' => $gender,
                    'district' => $dst_name,
                    'inc_address' => $row['inc_address'],
                    'inc_area_type'=>$row['inc_area_type'],
                    'emt_id' => $row['emso_id'],
                    'emt_name' => ucwords(strtolower($row['emt_name'])),
                    'pilot_id' => $row['pilot_id'],
                    'pilot_name' => ucwords(strtolower($row['pilot_name'])),
                    'level_type' => $row['level_type'],
                    'provier_img' => $row['pro_name'],
                    'other_provider_img' => $row['other_provider_img'],
                    'hos_district' => $hp_dst_name,
                    'hospitalName' => $hos_name,
                    'hospital_code' =>$hos_code,
                    'other_receiving_hos' => $row['other_receiving_host'],
                    'amb_base_location' => $row['inc_base_location_name'],
                   // 'wrd_location' => $row['inc_ward_name'],
                    'start_odo' => $row['start_odometer'],
                    'start_odo1' => $row['start_odometer'],
                    'scene_odometer' => $row['scene_odometer'],
                    'from_scene_odometer' => $row['from_scene_odo'],
                    'handover_odometer' => $row['handover_odo'],
                    'hospital_odometer' => $row['hospital_odometer'],
                    'end_odo' => $row['end_odometer'],
                    'total_km' => $row['total_km'],
                  //  'thirdparty_name' => $row['thirdparty_name'],
                   // 'responce_time_remark' => $row['responce_time_remark'],
                   // 'odo_remark' => $row['odo_remark'],
                    'remark' => $row['remark'],
                    'patinent_availability_status'=>$patinent_availability_status,
                    'dco_id' => get_clg_name_by_ref_id($row['operate_by']),
                    'ero_id' => get_clg_name_by_ref_id($row['inc_added_by']),
                    'b12_type'=>$row['b12_type'],
                    'validation_done'=>$row['validate_by'],
                    'is_validate'=>$is_validate,
                    'valid_remark'=>$row['valid_remark'],
                    'validate_date'=>$row['validate_date'],     
                );
            }

            
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'closure_dco_report';

            $this->output->add_to_position($this->load->view('frontend/erc_reports/inc_closure_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
           // var_dump($report_data);die();
            $filename = "closure_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            $count=1;
            foreach ($report_data as $row) {
               
                
                $dst_name = '';
                if($row['district_id'] != ''){
                    $incient_district = $this->inc_model->get_district_by_id($row['district_id']);
                    $dst_name = $incient_district->dst_name;
                }
                
                $amb_dist = '';
                if($row['amb_district'] != ''){
                    $amb_district = $this->inc_model->get_district_by_id($row['amb_district']);
                    $amb_dist = $amb_district->dst_name;
                }

                $amb_type_id1 = $this->inc_model->get_amb_type($row['amb_reg_id']);
                $amb_type = $amb_type_id1->ambt_name;
                $amb_area = $amb_type_id1->ar_name;
                
              
                if ($row['rec_hospital_name'] == 'Other' || $row['rec_hospital_name'] == '0' || $row['rec_hospital_name'] == '') {
                    $hos_name = 'Other';
                    $hos_code = '';
                } else if ($row['rec_hospital_name'] == 'on_scene_care'){
                    $hos_name = 'On Scene Care';
                    $hos_code = '';
                } else if ($row['rec_hospital_name'] == 'Patient_Not_Available'){
                    $hos_name = 'Patient Not Available';
                    $hos_code = '';
                }else {
                    $hos_name = $row['hp_name'];
                    $hos_code = $row['hp_code'];
                } 

                if($row['ptn_gender']=='M')
                {
                    $gender='Male';
                }else if($row['ptn_gender']=='F'){
                    $gender='Female';
                }else if($row['ptn_gender']=='O'){
                    $gender='Transgender';
                }else{
                    $gender='-';
                }
                if($row['inc_datetime'] != NULL){
                    $add_date = date('Y-m-d', strtotime($row['inc_datetime']));
                    $add_time = date('H:i:s', strtotime($row['inc_datetime']));
                    $final_date= $add_date.' '.$add_time;
                   
                }
                else{
                    $final_date= '';
                }
                $hp_dst_name = "";
                if($row['hp_district'] != '' && $row['hp_district'] != 0 && $row['hp_district'] != NULL){
                    $incient_district = $this->inc_model->get_district_by_id($row['hp_district']);
                    $hp_dst_name = $incient_district->dst_name;
                }
                $date = date("d-m-Y", strtotime($row['date']));
                 if($row['is_validate'] == 1){
                    $is_validate = "Validation Done";
                }else{
                    $is_validate = "Validation Pending";
                }
                if($row['epcr_call_type'] == '' || $row['epcr_call_type'] == NULL){                  
                    if($row['patient_ava_or_not'] == 'yes'){
                        $epcr_call_type = '2';
                    }else if($row['patient_ava_or_not']  == 'no'){
                        $epcr_call_type = '1';
                    }else if($row['patient_ava_or_not']  == '' && $row['patient_ava_or_not']  == NULL){
                        $epcr_call_type = '3';
                    }               
                }else{
                    $epcr_call_type = $row['epcr_call_type'] ;
                }
                $patinent_availability_status = "-";
                if($epcr_call_type != ''){
                    $call_type = $this->pcr_model->get_calltype_epcr(array('id' => $epcr_call_type));
                    $patinent_availability_status = $call_type[0]->call_type;
                }
                $ercp_advice = "";
                if($row['ercp_advice'] == 'advice_No'){
                    $ercp_advice = "No";
                }else if($row['ercp_advice'] == 'advice_Yes'){
                    $ercp_advice = "Yes";
                }else{
                    $ercp_advice = "No";
                }

                $ercp_name = ucwords(strtolower($row['clg_first_name'].' '.$row['clg_mid_name'].' '.$row['clg_last_name']));
               $clg_name_data =array();
               $epcr_operate_by_Name = "";
               if($row['epcr_clg_first_name'] == '' && $row['epcr_clg_last_name'] == '' ){
                   $epcr_operate_by_Name='';
                   $myArray = array();
                   $myArray = explode(',', $row['operate_by']);
                   
                   foreach($myArray as $clg_id1){
                       if($clg_id1 != ''){
                         $clg_data = get_clg_data_by_ref_id_response($clg_id1);
                         if(!empty( $clg_data)){
                            $clg_name_data[]=$clg_data[0]->clg_first_name.' '.$clg_data[0]->clg_last_name;
                         }
                       }
                   }
                   $epcr_operate_by_Name = implode(",",$clg_name_data);
                   //$epcr_operate_by_Name = '';
               }else
               {
                   $epcr_operate_by_Name = ucwords($row['epcr_clg_first_name'])." ".ucwords($row['epcr_clg_last_name']);
               }  
                $inc_data = array(
                    'sr_no' =>$count,
                    'inc_ref_id' => $row['incident_id'],
                    'inc_date' => $final_date,
                    'Closure_date' => $row['added_date'],
                    'call_type' => $row['pname'],
                    'amb_rto_register_no' => $row['amb_reg_id'],
                    'amb_type' => $amb_type,
                    'amb_base_location' => $row['inc_base_location_name'],
                   // 'Victim_id' => $row['inc_ref_id']." ".$row['patient_id'],
                    'amb_district' => $amb_dist,
                    'ptn_id'=>$row['ptn_id'],
                    'patient_name' => ucwords(strtolower($row['ptn_fname']." ".$row['ptn_lname'])),
                    'ptn_age' => $row['ptn_age'],
                    'ptn_gender' => $gender,
                    'caller_name' => ucwords(strtolower($row['clr_fname']." ".$row['clr_lname'])),
                    'caller_mobile' => $row['clr_mobile'],
                    'district' => $dst_name,
                    'address' => $row['inc_address'],
                    //'inc_area_type'=>$row['inc_area_type'],
                    'amb_area_type'=>$amb_area,
                    'emt_id' => $row['emso_id'],
                    'emt_name' => ucwords(strtolower($row['emt_name'])),
                    'pilot_id' => $row['pilot_id'],
                    'pilot_name' => ucwords(strtolower($row['pilot_name'])),
                    'level_type' => $row['level_type'],
                    'ercp_advice' => $ercp_advice,
                    'ercp_advice_Taken' => $ercp_name,
                   // 'case_name' => $row['case_name'],
                    'provier_img' => $row['pro_name'],
                    'other_provider_img' => $row['other_provider_img'],
                    'hos_district' => $hp_dst_name,
                    'hos_name' => $hos_name,
                    'hospital_code'=> $hos_code,
                    'Other_receiving_hos' => $row['other_receiving_host'],
                    'start_odo' => $row['start_odometer'],
                    'start_odo1' => $row['start_odometer'],
                    'scene_odometer' => $row['scene_odo'],
                    'from_scene_odometer' => $row['from_scene_odo'],
                    'handover_odometer' => $row['handover_odo'],
                    'hospital_odometer' => $row['hospital_odo'],
                    'end_odo' => $row['end_odometer'],
                    'total_km' => $row['total_km'],
                    'at_scene_lat' => $row['at_scene_lat'],
                    'at_scene_lng' => $row['at_scene_lng'],
                    'back_to_bs_loc_lat' => $row['back_to_bs_loc_lat'],
                    'back_to_bs_loc_lng' => $row['back_to_bs_loc_lng'],
                    'total_km' => $row['total_km'],
                    //'responce_time_remark' => $row['responce_time_remark'],
                    //'odo_remark' => $row['odo_remark'],
                    'remark' => $row['remark'],
                    'patinent_availability_status'=>$patinent_availability_status,
                    'dco_id' => $epcr_operate_by_Name,
                    'ero_id' => get_clg_name_by_ref_id($row['inc_added_by']),
                    'b12_type'=>$row['b12_type'],
                    'validation_done'=>get_validate_clg_name_by_ref_id($row['validate_by']),
                    'is_validate'=>$is_validate,
                    'valid_remark'=>$row['valid_remark'],
                    'validate_date'=>$row['validate_date'],     
                );

                fputcsv($fp, $inc_data);
                $count++;
            }
            fclose($fp);
            exit;
        }
    }
    function closure_dco_report() {

        $post_reports = $this->input->post();
        
        $track_args = array('trk_report_name'=>'Closure Report Incident datewise','trk_download_by'=>$this->clg->clg_ref_id);
        track_report_download($track_args);

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        $thirdparty = $this->clg->thirdparty;
        $district = $this->clg->clg_district_id;
        $clg_district_id = json_decode($district);
        if(is_array($clg_district_id)){
            $district_id = implode("','",$clg_district_id);
        }


        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
                // 'thirdparty' => $thirdparty,
                'system' => $post_reports['system'],
                //'clg_district_id' => $district_id 
            );
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                // 'thirdparty' => $thirdparty,
                'system' => $post_reports['system'],
                //'clg_district_id' => $district_id 
            );
        }

        //var_dump($report_args);die();
        $report_data = $this->inc_model->get_epcr_by_month($report_args);
    //   var_dump($report_data);
    //    die();

       
        $header = array('Sr.No',
            'Incident ID',
            'Incident Date /Time',
            'Closure Date / Time',
            'Call Type',
            'Ambulance No',
            'Ambulance Type',
            'Base Location',
            'Victim ID',
            'Ambulance District',
            'Patient ID',
            'Patient Name',
            'Age',
            'Gender',
            'caller Name',
            'caller Mobile ',
            'Incident District',
            'Address',
            'Inc. Area Type',
            'EMT ID',
            'EMT Name',
            'PILOT ID',
            'PILOT Name',
            'LOC',
            'ERCP Advice',
            'ERCP Name',
            'Provider Impression',
            'Provider Impression Other',
            'Receiving Hospital District',
            'Receiving Hospital Name',
            'Receiving Hospital Code',
            'Other-Receiving Hospital',
            'Previous Odometer',
            'Start Odometer',
            'Scene Odometer',
            'From Scene Odometer',
            'Handover Odometer',
            'Hospital Odometer',
            'End Odometer',
            'Total Distance Travel',
           // 'Response Time Remark',
           // 'Odometer Difference Remark',
            'Remark',
            'Patinent Availability status',
            'Operate By',
            'Assign By',
            'B12 type',
            'Validation Done by','Validation Status','Validation Remark','Validation Date time');

        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            foreach ($report_data as $row) {
                
                $dst_name = '';
                if($row['district_id'] != ''){
                    $incient_district = $this->inc_model->get_district_by_id($row['district_id']);
                    $dst_name = $incient_district->dst_name;
                }

                if($row['amb_district'] != ''){
                    $amb_district = $this->inc_model->get_district_by_id($row['amb_district']);
                    $amb_dist = $amb_district->dst_name;
                }
                $amb_type_id1 = $this->inc_model->get_amb_type($row['amb_reg_id']);
                $amb_type = $amb_type_id1->ambt_name;
                
                if ($row['rec_hospital_name'] == 'Other' || $row['rec_hospital_name'] == '0' || $row['rec_hospital_name'] == '') {
                    $hos_name = 'Other';
                    $hos_code = '';
                } else if ($row['rec_hospital_name'] == 'on_scene_care'){
                    $hos_name = 'On Scene Care';
                    $hos_code = '';
                } else if ($row['rec_hospital_name'] == 'at_scene_care'){
                    $hos_name = 'At Scene Care';
                    $hos_code = '';
                }else {
                    $hos_name = $row['hp_name'];
                    $hos_code = $row['hp_code'];
                } 

                if($row['ptn_gender']=='M')
                {
                    $gender='Male';
                }else if($row['ptn_gender']=='F'){
                    $gender='Female';
                }else if($row['ptn_gender']=='O'){
                    $gender='Transgender';
                }else{
                    $gender='-';
                }
             
                  $hp_dst_name = "";
               
                if($row['hp_district'] != '' && $row['hp_district'] != 0 && $row['hp_district'] != NULL){
                    $incient_district = $this->inc_model->get_district_by_id($row['hp_district']);
                    $hp_dst_name = $incient_district->dst_name;
                }
                
                if($row['is_validate'] == 1){
                    $is_validate = "Validation Done";
                }else{
                    $is_validate = "Validation Pending";
                }
              
                $inc_date = date("d-m-Y H:i:s", strtotime($row['inc_datetime']));
                $date = date("d-m-Y", strtotime($row['date']));
                
                if($row['epcr_call_type'] == '' || $row['epcr_call_type'] == NULL){                  
                    if($row['patient_ava_or_not'] == 'yes'){
                        $epcr_call_type = '2';
                    }else if($row['patient_ava_or_not']  == 'no'){
                        $epcr_call_type = '1';
                    }else if($row['patient_ava_or_not']  == '' && $row['patient_ava_or_not']  == NULL){
                        $epcr_call_type = '3';
                    }               
                }else{
                    $epcr_call_type = $row['epcr_call_type'] ;
                }
                $patinent_availability_status = "-";
                if($epcr_call_type != ''){
                    $call_type = $this->pcr_model->get_calltype_epcr(array('id' => $epcr_call_type));
                    $patinent_availability_status = $call_type[0]->call_type;
                }
                $ercp_name = ucwords(strtolower($row['clg_first_name'].' '.$row['clg_mid_name'].' '.$row['clg_last_name']));

                $inc_data[] = array(
                    'inc_datetime' => $inc_date,
                    'inc_date' => $row['added_date'],
                    'inc_purpose' => $row['pname'],
                    'inc_ref_id' => $row['incident_id'],
                    'amb_rto_register_no' => $row['amb_reg_id'],
                    'amb_type' => $amb_type,
                    'amb_district' => $amb_dist,
                    'patient_id' => $row['ptn_id'],
                    'patient_name' => ucwords(strtolower($row['ptn_fname']." ".$row['ptn_lname'])),
                    'caller_name' => ucwords(strtolower($row['clr_fname']." ".$row['clr_lname'])),
                    'caller_mobile' => $row['clr_mobile'],
                    'ptn_age' => $row['ptn_age']." ".$row['ptn_age_type'],
                    'ptn_gender' => $gender,
                    'district' => $dst_name,
                    'inc_address' => $row['inc_address'],
                    'inc_area_type'=>$row['inc_area_type'],
                    'emt_id' => $row['emso_id'],
                    'emt_name' => ucwords(strtolower($row['emt_name'])),
                    'pilot_id' => $row['pilot_id'],
                    'pilot_name' => ucwords(strtolower($row['pilot_name'])),
                    'level_type' => $row['level_type'],
                    'provier_img' => $row['pro_name'],
                    'other_provider_img' => $row['other_provider_img'],
                    'hos_district' => $hp_dst_name,
                    'hospitalName' => $hos_name,
                    'hospital_code' =>$hos_code,
                    'other_receiving_hos' => $row['other_receiving_host'],
                    'amb_base_location' => $row['inc_base_location_name'],
                   // 'wrd_location' => $row['inc_ward_name'],
                    'start_odo' => $row['start_odometer'],
                    'start_odo1' => $row['start_odometer'],
                    'scene_odometer' => $row['scene_odometer'],
                    'from_scene_odometer' => $row['from_scene_odo'],
                    'handover_odometer' => $row['handover_odo'],
                    'hospital_odometer' => $row['hospital_odometer'],
                    'end_odo' => $row['end_odometer'],
                    'total_km' => $row['total_km'],
                  //  'thirdparty_name' => $row['thirdparty_name'],
                   // 'responce_time_remark' => $row['responce_time_remark'],
                   // 'odo_remark' => $row['odo_remark'],
                    'remark' => $row['remark'],
                    'patinent_availability_status'=>$patinent_availability_status,
                    'dco_id' => get_clg_name_by_ref_id($row['operate_by']),
                    'ero_id' => get_clg_name_by_ref_id($row['inc_added_by']),
                    'b12_type'=>$row['b12_type'],
                    'validation_done'=>$row['validate_by'],
                    'is_validate'=>$is_validate,
                    'valid_remark'=>$row['valid_remark'],
                    'validate_date'=>$row['validate_date'],     
                );
            }

            
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'closure_dco_report';

            $this->output->add_to_position($this->load->view('frontend/erc_reports/inc_closure_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
           // var_dump($report_data);die();
            $filename = "closure_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            $count=1;
            foreach ($report_data as $row) {
               
                
                $dst_name = '';
                if($row['district_id'] != ''){
                    $incient_district = $this->inc_model->get_district_by_id($row['district_id']);
                    $dst_name = $incient_district->dst_name;
                }
                
                $amb_dist = '';
                if($row['amb_district'] != ''){
                    $amb_district = $this->inc_model->get_district_by_id($row['amb_district']);
                    $amb_dist = $amb_district->dst_name;
                }

                $amb_type_id1 = $this->inc_model->get_amb_type($row['amb_reg_id']);
                $amb_type = $amb_type_id1->ambt_name;
                $amb_area = $amb_type_id1->ar_name;
                
              
                if ($row['rec_hospital_name'] == 'Other' || $row['rec_hospital_name'] == '0' || $row['rec_hospital_name'] == '') {
                    $hos_name = 'Other';
                    $hos_code = '';
                } else if ($row['rec_hospital_name'] == 'on_scene_care'){
                    $hos_name = 'On Scene Care';
                    $hos_code = '';
                } else if ($row['rec_hospital_name'] == 'Patient_Not_Available'){
                    $hos_name = 'Patient Not Available';
                    $hos_code = '';
                }else {
                    $hos_name = $row['hp_name'];
                    $hos_code = $row['hp_code'];
                } 

                if($row['ptn_gender']=='M')
                {
                    $gender='Male';
                }else if($row['ptn_gender']=='F'){
                    $gender='Female';
                }else if($row['ptn_gender']=='O'){
                    $gender='Transgender';
                }else{
                    $gender='-';
                }
                if($row['inc_datetime'] != NULL){
                    $add_date = date('Y-m-d', strtotime($row['inc_datetime']));
                    $add_time = date('H:i:s', strtotime($row['inc_datetime']));
                    $final_date= $add_date.' '.$add_time;
                   
                }
                else{
                    $final_date= '';
                }
                $hp_dst_name = "";
                if($row['hp_district'] != '' && $row['hp_district'] != 0 && $row['hp_district'] != NULL){
                    $incient_district = $this->inc_model->get_district_by_id($row['hp_district']);
                    $hp_dst_name = $incient_district->dst_name;
                }
                $date = date("d-m-Y", strtotime($row['date']));
                 if($row['is_validate'] == 1){
                    $is_validate = "Validation Done";
                }else{
                    $is_validate = "Validation Pending";
                }
                if($row['epcr_call_type'] == '' || $row['epcr_call_type'] == NULL){                  
                    if($row['patient_ava_or_not'] == 'yes'){
                        $epcr_call_type = '2';
                    }else if($row['patient_ava_or_not']  == 'no'){
                        $epcr_call_type = '1';
                    }else if($row['patient_ava_or_not']  == '' && $row['patient_ava_or_not']  == NULL){
                        $epcr_call_type = '3';
                    }               
                }else{
                    $epcr_call_type = $row['epcr_call_type'] ;
                }
                $patinent_availability_status = "-";
                if($epcr_call_type != ''){
                    $call_type = $this->pcr_model->get_calltype_epcr(array('id' => $epcr_call_type));
                    $patinent_availability_status = $call_type[0]->call_type;
                }
                $ercp_advice = "";
                if($row['ercp_advice'] == 'advice_No'){
                    $ercp_advice = "No";
                }else if($row['ercp_advice'] == 'advice_Yes'){
                    $ercp_advice = "Yes";
                }else{
                    $ercp_advice = "No";
                }

                $ercp_name = ucwords(strtolower($row['clg_first_name'].' '.$row['clg_mid_name'].' '.$row['clg_last_name']));
               $clg_name_data =array();
               $epcr_operate_by_Name = "";
               if($row['epcr_clg_first_name'] == '' && $row['epcr_clg_last_name'] == '' ){
                   $epcr_operate_by_Name='';
                   $myArray = array();
                   $myArray = explode(',', $row['operate_by']);
                   
                   foreach($myArray as $clg_id1){
                       if($clg_id1 != ''){
                         $clg_data = get_clg_data_by_ref_id_response($clg_id1);
                         if(!empty( $clg_data)){
                            $clg_name_data[]=$clg_data[0]->clg_first_name.' '.$clg_data[0]->clg_last_name;
                         }
                       }
                   }
                   $epcr_operate_by_Name = implode(",",$clg_name_data);
                   //$epcr_operate_by_Name = '';
               }else
               {
                   $epcr_operate_by_Name = ucwords($row['epcr_clg_first_name'])." ".ucwords($row['epcr_clg_last_name']);
               }  
                $inc_data = array(
                    'sr_no' =>$count,
                    'inc_ref_id' => $row['incident_id'],
                    'inc_date' => $final_date,
                    'Closure_date' => $row['added_date'],
                    'call_type' => $row['pname'],
                    'amb_rto_register_no' => $row['amb_reg_id'],
                    'amb_type' => $amb_type,
                    'amb_base_location' => $row['inc_base_location_name'],
                    'Victim_id' => $row['inc_ref_id']." ".$row['patient_id'],
                    'amb_district' => $amb_dist,
                    'ptn_id'=>$row['ptn_id'],
                    'patient_name' => ucwords(strtolower($row['ptn_fname']." ".$row['ptn_lname'])),
                    'ptn_age' => $row['ptn_age'],
                    'ptn_gender' => $gender,
                    'caller_name' => ucwords(strtolower($row['clr_fname']." ".$row['clr_lname'])),
                    'caller_mobile' => $row['clr_mobile'],
                    'district' => $dst_name,
                    'address' => $row['inc_address'],
                    //'inc_area_type'=>$row['inc_area_type'],
                    'amb_area_type'=>$amb_area,
                    'emt_id' => $row['emso_id'],
                    'emt_name' => ucwords(strtolower($row['emt_name'])),
                    'pilot_id' => $row['pilot_id'],
                    'pilot_name' => ucwords(strtolower($row['pilot_name'])),
                    'level_type' => $row['level_type'],
                    'ercp_advice' => $ercp_advice,
                    'ercp_advice_Taken' => $ercp_name,
                   // 'case_name' => $row['case_name'],
                    'provier_img' => $row['pro_name'],
                    'other_provider_img' => $row['other_provider_img'],
                    'hos_district' => $hp_dst_name,
                    'hos_name' => $hos_name,
                    'hospital_code'=> $hos_code,
                    'Other_receiving_hos' => $row['other_receiving_host'],
                    'start_odo' => $row['start_odometer'],
                    'start_odo1' => $row['start_odometer'],
                    'scene_odometer' => $row['scene_odo'],
                    'from_scene_odometer' => $row['from_scene_odo'],
                    'handover_odometer' => $row['handover_odo'],
                    'hospital_odometer' => $row['hospital_odo'],
                    'end_odo' => $row['end_odometer'],
                    'total_km' => $row['total_km'],
                    //'responce_time_remark' => $row['responce_time_remark'],
                    //'odo_remark' => $row['odo_remark'],
                    'remark' => $row['remark'],
                    'patinent_availability_status'=>$patinent_availability_status,
                    'dco_id' => $epcr_operate_by_Name,
                    'ero_id' => get_clg_name_by_ref_id($row['inc_added_by']),
                    'b12_type'=>$row['b12_type'],
                    'validation_done'=>get_validate_clg_name_by_ref_id($row['validate_by']),
                    'is_validate'=>$is_validate,
                    'valid_remark'=>$row['valid_remark'],
                    'validate_date'=>$row['validate_date'],     
                );

                fputcsv($fp, $inc_data);
                $count++;
            }
            fclose($fp);
            exit;
        }
    }


    function nhm_mis_report_table() {
        
        set_time_limit(0);

        $post_reports = $this->input->post();
        
        // $track_args = array('trk_report_name'=>'Closure Report Incident datewise','trk_download_by'=>$this->clg->clg_ref_id);
        // track_report_download($track_args);

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        $thirdparty = $this->clg->thirdparty;
        $district = $this->clg->clg_district_id;
        $clg_district_id = json_decode($district);
        if(is_array($clg_district_id)){
            $district_id = implode("','",$clg_district_id);
        }


        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
                // 'thirdparty' => $thirdparty,
                'system' => $post_reports['system'],
                //'clg_district_id' => $district_id 
            );
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                // 'thirdparty' => $thirdparty,
                'system' => $post_reports['system'],
                //'clg_district_id' => $district_id 
            );
        }


        $report_data = $this->inc_model->get_nhm_mis_by_month($report_args);
        

    //   var_dump($report_data);
    //    die();

       
        $header = array('Sr.No',
            'Incident Date',
            'Call Purpose',
            'Call Type',
            'Chief Complaint',
            'Chief Complaint Other',
            'MCI Nature',
            'Incident ID',
            'Closing Status',
            'Cancel/Not Availed Reason',
            'Area',
            'Vehicle No',
            'Vehicle TYPE',
            'Vehicle Category',
            'Vehicle District',
            
            'Base Location',
            'Base Location District',
            'Base Location Tehsil',
            'Driver Name',
            'Driver Name Other',
            'EMT Name',
            'EMT Name Other',
            'GPS ID',
            'MDT ID',
            'Zone',

            'Call Receive Date Time',
            'Call End Date Time',
            // 'Call End Time',
            'Call Taker ERO Name',
            'Call Taker ERO ID',
            'Dispatched Shift',
            'Dispatch Date Time',
            // 'Diff',
            'Call To Dispatch AHT',
            // 'Previous case ODO',
            'Start ODO',
            'Scene Arrival Date Time',
            'Scene ODO',
            'Scene Latitude',
            'Scene Longitude',
            'B2S KMs',
            'B2S Time',
            'Call To Scene Time',

            'At Hosp Date Time',
            'At Hosp ODO',

            'S2H KMs',
            'S2H TIME',

            // 'Hosp Handover Date Time',
            // 'Hosp Handover ODO',

             // 'Scene To Hospital',
            // 'Scene To Hospital',
            'Back To Base Time',
            'Back To Base ODO',

            'Back to Base Latitude',
            'Back to Base Longitude',
            'H2B KMs',
            'H2B TIME',
            'B2B KMs',
            // 'Total Trip KM ',
            'B2B Time',
            'Case Closed Date Time',
            'DCO',
            'Caller Name',
            'Caller Phone No',
            'Caller Relation',
            'Inc District',
            'Inc Tehsil',
            'Inc Location City/Village/Colony',
            'Pickup Hospital',
            'Other Pickup Hospital',
            'Hospital Type',
            'Reason For IFT',
            'No Of Patient',
            'Patient Name',
            'Gender',
            'Patient Phone No',
            'Patient Age',
            'Patient District',
            'Patient Tehsil/Block',
            'Patient Address',
            // 'ERO Standard Remark',
            'ERO Remark',
            'DCO Remark',
            'Response Time Remark',
            'Response Time Remark Other',
            'Delivery In Ambulance',

            'Ayushman Card No (if Any)',
            'Drop Hospital District',
            'Dropoff Hospital',
            'Dropoff Hospital Other',
            'Dropoff Hospital Type',

            'Source Hospital',
            'Source Hospital Other',
            'Source Hospital Type',

            'Destination Hospital',
            'Destination Hospital Other',
            'Destination Hospital Type',

            'Drop Back Case Home Address',
            'Drop Back Case District',
            'Reason',
            'IPD No',
            'OPD No',
            'PCF Number',
            'Paid Amount (In Case of Pvt Hospital)',
            'Provider Impressions');

        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            foreach ($report_data as $row) {
                
                $dst_name = '';
                if($row['inc_district_id'] != ''){
                    $incient_district = $this->inc_model->get_district_by_id($row['inc_district_id']);
                    $dst_name = $incient_district->dst_name;
                }

                if($row['amb_district'] != ''){
                    $amb_district = $this->inc_model->get_district_by_id($row['amb_district']);
                    $amb_dist = $amb_district->dst_name;
                }

                $amb_type_id1 = $this->inc_model->get_amb_type($row['amb_reg_id']);
                $dco = $this->inc_model->get_dco($row['dp_operated_by']);
               
                // $amb_type_id = $amb_type_id1->amb_type;
                // if($amb_type_id =='1')
                // {
                //     $amb_type= 'JE';
                // }
                // elseif($amb_type_id =='2')
                // {
                //     $amb_type= 'BLS'; 
                // }
                // else{
                //     $amb_type= 'ALS';
                // }
                $amb_type=  show_amb_type_name($amb_type_id1->amb_type);
                /*if ($row['rec_hospital_name'] == '0') {
                    $hos_name = 'On scene care';
                } else 
                */
                if ($row['rec_hospital_name'] == 'Other' || $row['rec_hospital_name'] == '0' || $row['rec_hospital_name'] == '') {
                    $hos_name = 'Other';
                    $hos_code = '';
                } else if ($row['rec_hospital_name'] == 'on_scene_care'){
                    $hos_name = 'On Scene Care';
                    $hos_code = '';
                } else if ($row['rec_hospital_name'] == 'at_scene_care'){
                    $hos_name = 'At Scene Care';
                    $hos_code = '';
                }else {
                    $hos_name = $row['hp_name'];
                    $hos_code = $row['hp_code'];
                } 

                if($row['ptn_gender']=='M')
                {
                    $gender='Male';
                }else if($row['ptn_gender']=='F'){
                    $gender='Female';
                }else if($row['ptn_gender']=='O'){
                    $gender='Transgender';
                }else{
                    $gender='-';
                }
             
                  $hp_dst_name = "";
               
                if($row['hp_district'] != '' && $row['hp_district'] != 0 && $row['hp_district'] != NULL){
                    $incient_district = $this->inc_model->get_district_by_id($row['hp_district']);
                    $hp_dst_name = $incient_district->dst_name;
                }
                $b12_name = '';
                
                if($row['is_validate'] == 1){
                    $is_validate = "Validation Done";
                }else{
                    $is_validate = "Validation Pending";
                }
              
                $inc_date = date("d-m-Y H:i:s", strtotime($row['inc_datetime']));
                $date = date("d-m-Y", strtotime($row['date']));
                
                if($row['epcr_call_type'] == '' || $row['epcr_call_type'] == NULL){                  
                    if($row['patient_ava_or_not'] == 'yes'){
                        $epcr_call_type = '2';
                    }else if($row['patient_ava_or_not']  == 'no'){
                        $epcr_call_type = '1';
                    }else if($row['patient_ava_or_not']  == '' && $row['patient_ava_or_not']  == NULL){
                        $epcr_call_type = '3';
                    }               
                }else{
                    $epcr_call_type = $row['epcr_call_type'] ;
                }
                $patinent_availability_status = "-";
                if($epcr_call_type != ''){
                    $call_type = $this->pcr_model->get_calltype_epcr(array('id' => $epcr_call_type));
                    $patinent_availability_status = $call_type[0]->call_type;
                }
                if($row['rec_hospital_name'] == 'Patient_Not_Available'){ $pcr1 = 'Not Availed';}else{ $pcr1 = 'Availed';}

                $dco_name= $row['dco_fname'].' '.$row['dco_midname'].' '.$row['dco_lname'];
                $close_time = $row['date'].' '.$row['time'];
                if($row['provider_impressions']==12){$provider_impressions='Yes';}else{$provider_impressions='No';}
                $inc_data[] = array(
                    'inc_datetime' => $inc_date,
                    'inc_date' => $row['added_date'],
                    'inc_purpose' => $row['pname'],
                    'inc_ref_id' => $row['incident_id'],
                    'amb_rto_register_no' => $row['amb_reg_id'],
                    'inc_complaint_other' => $row['inc_complaint_other'],
                    'amb_type' => $amb_type,
                    'amb_district' => $amb_dist,
                    'patient_id' => $row['ptn_id'],
                    'patient_name' => ucwords($row['ptn_fname'])." ".ucwords($row['ptn_lname']),
                    'caller_name' => ucwords($row['clr_fname'])." ".ucwords($row['clr_lname']),
                    'caller_mobile' => $row['clr_mobile'],
                    'ptn_age' => $row['ptn_age']." ".$row['ptn_age_type'],
                    'ptn_gender' => $gender,
                    'district' => $dst_name,
                    'closing_sts_dco' => $pcr1,
                    'locality' => $row['inc_address'],
                    'inc_area_type'=>$row['area_type_amb'],
                    'emt_id' => $row['emso_id'],
                    'emt_name' => $row['emt_name'],
                    'emt_name_other' => $row['emt_id_other'],
                    // 'pilot_id' => $row['pilot_id'],
                    'pilot_name' => ucwords($row['pilot_name']),
                    'pilot_name_other' => $row['pilot_id_other'],

                    'level_type' => $row['level_type'],
                    'provier_img' => $row['pro_name'],
                    'other_provider_img' => $row['other_provider_img'],
                    'hos_district' => $hp_dst_name,
                    'base_location' => $hos_name,
                    'hospital_code' =>$hos_code,
                    'other_receiving_hos' => $row['other_receiving_host'],
                    'amb_base_location' => $row['hp_name'],
                   // 'wrd_location' => $row['inc_ward_name'],
                    'start_odo' => $row['start_odometer'],
                    'end_odo' => $row['end_odometer'],
                    'total_km' => $row['total_km'],
                  //  'thirdparty_name' => $row['thirdparty_name'],
                    'remark' => $row['remark'],
                    'patinent_availability_status'=>$patinent_availability_status,
                    'dco_id' => get_clg_name_by_ref_id($row['operate_by']),
                    'ero_id' => get_clg_name_by_ref_id($row['inc_added_by']),
                    'b12_type'=>$row['b12_type'],
                    'validation_done'=>$row['validate_by'],
                    'is_validate'=>$is_validate,
                    'valid_remark'=>$row['valid_remark'],
                    'validate_date'=>$row['validate_date'],
                    'amb_dis'=>$row['amb_dis'],
                    'inc_recive_time'=> $row['inc_recive_time'],
                    'inc_datetime'=> $row['inc_datetime'],
                    'inc_dispatch_time'=> $row['inc_dispatch_time'],
                    // 'ero_name'=> $row['ero_name'],
                    // 'ero_name'=> 'test',
                    'inc_added_by'=> $row['inc_added_by'],
                    'inc_pcr_status'=> $row['inc_pcr_status'],
                    'inc_lat'=> $row['inc_lat'],
                    'inc_long'=> $row['inc_long'],
                    'inc_district_id'=> $row['inc_district_id'],
                    'inc_tahsil_id'=> $row['inc_tahshil_id'],
                    'clg_first_name'=> ucwords($row['clg_first_name']),
                    'clg_mid_name'=> ucwords($row['clg_mid_name']),
                    'clg_last_name'=> ucwords($row['clg_last_name']),
                    'inc_address'=> $row['inc_address'],
                    'amb_gps_imei_no'=> $row['amb_gps_imei_no'],
                    'amb_mdt_srn_no'=> $row['amb_mdt_srn_no'],
                    'scene_odometer'=> $row['scene_odo'],
                    'dp_started_base_loc'=> $row['dp_started_base_loc'],
                    'dp_back_to_loc'=> $row['dp_back_to_loc'],
                    'inc_patient_cnt'=> $row['inc_patient_cnt'],
                    'ptn_district'=> $row['ptn_district'],
                    'ptn_tahsil'=> $row['ptn_tahsil'],
                    'drop_district'=> $row['drop_district'],
                    'drop_home_address'=> $row['drop_home_address'],
                    'ptn_mob_no'=> $row['ptn_mob_no'],
                    'hospital_odometer'=> $row['hospital_odometer'],
                    'ayushman_id'=> $row['ayushman_id'],
                    'dp_reach_on_scene_km'=> $row['dp_reach_on_scene_km'],
                    'dp_reach_on_scene'=> $row['dp_reach_on_scene'],
                    'dp_back_to_loc_km'=> $row['dp_back_to_loc_km'],
                    'dp_back_to_loc'=> $row['dp_back_to_loc'],
                    'dp_hosp_time'=> $row['dp_hosp_time'],
                    'dp_hosp_time_km'=> $row['dp_hosp_time_km'],
                    'end_odometer'=> $row['end_odometer'],
                    'pat_com_to_hosp_reason'=> $row['pat_com_to_hosp_reason'],
                    'hospital_name'=> $row['hospital_name'],
                    'hospital_type'=> $row['hosp_type'],
                    'opd_no_txt'=> $row['opd_no_txt'],
                    'inc_back_home_address'=> $row['inc_back_home_address'],
                    'dp_operated_by'=> $row['dp_operated_by'],
                    'dp_on_scene' => $row['dp_on_scene'],
                    'remark'=> $row['remark'],
                    'inc_district_id'=> $row['inc_district_id'],
                    'inc_complaint'=> $row['inc_complaint'],
                    'close_time'=>$close_time,
                    'provider_impressions' => $provider_impressions,
                    'patient_ava_or_not_other_reason'=> $row['patient_ava_or_not_other_reason'],
                    'at_scene_lat'=> $row['at_scene_lat'],
                    'at_scene_lng'=> $row['at_scene_lng'],
                    'back_to_bs_loc_lat'=> $row['back_to_bs_loc_lat'],
                    'back_to_bs_loc_lng'=> $row['back_to_bs_loc_lng'],
                    'dco_name'=> $dco_name,
                    'ar_name'=>$row['ar_name'],
                    'pr_total_amount'=>$row['pr_total_amount'],
                    'inc_div_id'=>$row['inc_div_id'],
                    // 'hos_type1'=>$row['hos_type1'],
                );
                // print_r($inc_data);die();
            }

            
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'nhm_mis_report_table';

            $this->output->add_to_position($this->load->view('frontend/erc_reports/nhm_mis_table', $data, TRUE), 'list_table', TRUE);
        } else {
           // var_dump($report_data);die();
            $filename = "nhm_mis_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            $count=1;
            foreach ($report_data as $row) {
               
                
                $dst_name = '';
                if($row['district_id'] != ''){
                    $incient_district = $this->inc_model->get_district_by_id($row['district_id']);
                    $dst_name = $incient_district->dst_name;
                }
                $inc_dst_name = '';
                if($row['inc_district_id'] != ''){
                    $incient_district_data = $this->inc_model->get_district_by_id($row['inc_district_id']);
                    $inc_dst_name = $incient_district_data->dst_name;
                }
                
               

                if($row['inc_ref_id'] != ''){
                    $ptn_cnt = $this->inc_model->get_patient_count_epcr($row['inc_ref_id']);
                    $ptn_cnt = $ptn_cnt[0]->total_count;
                }
                $incient_district = $this->inc_model->get_district_by_id($row['district_id']);

                $amb_dist = '';
                if($row['amb_district'] != ''){
                    $amb_district = $this->inc_model->get_district_by_id($row['amb_district']);
                    $amb_dist = $amb_district->dst_name;
                }

                $amb_type_id1 = $this->inc_model->get_amb_type($row['amb_reg_id']);
               
                $amb_type=  show_amb_type_name($amb_type_id1->amb_type);
              
                if ($row['rec_hospital_name'] == 'Other' || $row['rec_hospital_name'] == '0' || $row['rec_hospital_name'] == '') {
                    $hos_name = 'Other';
                    $hos_code = '';
                } else if ($row['rec_hospital_name'] == 'on_scene_care'){
                    $hos_name = 'On Scene Care';
                    $hos_code = '';
                } else if ($row['rec_hospital_name'] == 'at_scene_care'){
                    $hos_name = 'At Scene Care';
                    $hos_code = '';
                }else {
                    $hos_name = $row['hp_name'];
                    $hos_code = $row['hp_code'];
                } 
                if($row['inc_datetime'] != NULL){
                    $add_date = date('Y-m-d', strtotime($row['inc_datetime']));
                    $add_time = date('H:i:s', strtotime($row['inc_datetime']));
                    $final_date= $add_date.' '.$add_time;
                   
                }
                else{
                    $final_date= '';
                }
                $hp_dst_name = "";
                if($row['hp_district'] != '' && $row['hp_district'] != 0 && $row['hp_district'] != NULL){
                    $incient_district = $this->inc_model->get_district_by_id($row['hp_district']);
                    $hp_dst_name = $incient_district->dst_name;
                }
                $date = date("d-m-Y", strtotime($row['date']));
                 if($row['is_validate'] == 1){
                    $is_validate = "Validation Done";
                }else{
                    $is_validate = "Validation Pending";
                }
                if($row['epcr_call_type'] == '' || $row['epcr_call_type'] == NULL){                  
                    if($row['patient_ava_or_not'] == 'yes'){
                        $epcr_call_type = '2';
                    }else if($row['patient_ava_or_not']  == 'no'){
                        $epcr_call_type = '1';
                    }else if($row['patient_ava_or_not']  == '' && $row['patient_ava_or_not']  == NULL){
                        $epcr_call_type = '3';
                    }               
                }else{
                    $epcr_call_type = $row['epcr_call_type'] ;
                }
                $patinent_availability_status = "-";
                if($epcr_call_type != ''){
                    $call_type = $this->pcr_model->get_calltype_epcr(array('id' => $epcr_call_type));
                    $patinent_availability_status = $call_type[0]->call_type;
                }
                

                if($row['ptn_gender']=='M')
                {
                    $gender='Male';
                }else if($row['ptn_gender']=='F'){
                    $gender='Female';
                }else if($row['ptn_gender']=='O'){
                    $gender='Transgender';
                }else{
                    $gender='-';
                }

                    $time2 =  date_create(date($row['inc_recive_time']));
                    
                    $time1 = date_create(date($row['inc_datetime']));
                    $diff=date_diff($time2,$time1);
                    $diff = $diff->format("%h:%i:%s");

                    $time3 =  date_create(date($row['dp_on_scene']));
            
                    $B2STime =date_diff($time3,$time1);
                    //$B2STime =  date('H:i:s', strtotime($B2STime->format("%h:%i:%s")));
                    $B2STime = ($B2STime->format("%a") * 24) + $B2STime->format("%h").":". $B2STime->format("%i").":". $B2STime->format("%s");

                     $B2S_call_Time =date_diff($time3,$time2);
                     $B2S_call_Time = ($B2S_call_Time->format("%a") * 24) + $B2S_call_Time->format("%h").":". $B2S_call_Time->format("%i").":". $B2S_call_Time->format("%s");

    
                    if($row['scene_odometer']=='' || $row['scene_odometer']==null){
                         $scene_odo = 0;
                        }
                    else{ $scene_odo = (int)$row['scene_odometer'];}
    
                    if($row['rec_hospital_name'] == 'Patient_Not_Available'){
                        $pcr1 = 'Not Availed';
                        $hosp_time_dash ='-';
                        $hosp_odo_dash ='-';
                        $S2HTime ='-';
                        $H2BTime ='-';
                        $S2Hkm ='-';
                        $H2Bkm ='-';
                       }else{
                            $pcr1 = 'Availed';
                            $hosp_time_dash = $row['dp_hosp_time'];
                            $hosp_odo_dash = $row['hospital_odometer'];

                            $time4 =  date_create(date($row['dp_hosp_time']));
                            $S2HTime = date_diff($time4,$time3);
                            $S2HTime = ($S2HTime->format("%a") * 24) + $S2HTime->format("%h").":". $S2HTime->format("%i").":". $S2HTime->format("%s");
                            
                            $time5  =  date_create(date($row['dp_back_to_loc']));
                            $H2BTime = date_diff($time5,$time4);
                            $H2BTime = ($H2BTime->format("%a") * 24) + $H2BTime->format("%h").":". $H2BTime->format("%i").":". $H2BTime->format("%s");

                            if($row['hospital_odometer'] =='' || $row['hospital_odometer']==null){ 
                                $hos_odo = '0';
                            }
                            else{
                                 $hos_odo = (int)$row['hospital_odometer'];
                            }
                            if ($hos_odo == '0'){
                                $S2Hkm = '0';
                            }else{
                                $S2Hkm = $hos_odo - $scene_odo;
                            }

                            $H2Bkm = (int)$row['end_odometer'] - (int)$row['hospital_odometer'];
                       }

            $close_time = $row['date'].' '.$row['time'];
            $time6  =  date_create(date($close_time));

            $time9 =  date_create(date($row['dp_back_to_loc']));
            $B2BTime = date_diff($time9,$time1);
            // $B2BTime =  date('H:i:s', strtotime($B2BTime->format("%h:%i:%s")));
            $B2BTime = ($B2BTime->format("%a") * 24) + $B2BTime->format("%h").":". $B2BTime->format("%i").":". $B2BTime->format("%s");


                $B2Skm = (int)$row['scene_odometer'] - (int)$row['start_odometer'];

                $B2Bkm = (int)$row['end_odometer'] - (int)$row['start_odometer'];

                $name1 = ucfirst($row['clg_first_name']).' '.ucfirst($row['clg_mid_name']).' '.ucfirst($row['clg_last_name']);
                $callername= ucfirst($row['clr_fname'])." ".ucfirst($row['clr_lname']);
                $patname = ucfirst($row['ptn_fname'])." ".ucfirst($row['ptn_lname']);

                $close_time = $row['date'].' '.$row['time'];
                $dco = $this->inc_model->get_dco($row['dp_operated_by']);

                   


                    if($row['ero_drop'] !='0' || $row['ero_drop'] != ' ' || $row['ero_drop'] != NULL ){
                            $ero_drop = $row['ero_drop'];
                    }else if($row['ero_drop_two'] !='0' || $row['ero_drop_two'] != ' ' || $row['ero_drop_two'] != NULL){
                            $ero_drop = $row['ero_drop_two'];
                    }else {
                        $ero_drop = " ";
                    }

                   
                    
                    if($row['inc_type'] == 'IN_HO_P_TR'){
                        if($row['facility'] == 'Other'){
                        $pick_up_hp = 'Other';
                        $ift_hosp_type = '';
                        }else{
                            $pick_up_hp = $row['ift_main_name'];
                            $ift_hosp_type = $row['ift_main_type'];
                            $src_rec_hosp = '';
                        }
                        
                        if($row['back_hospital'] == ''){
                            $ero_drop = '';
                            $ero_drop_type = '';
                        }else{
                            $ero_drop = $row['back_hospital'];
                            $dst_rec_hosp = $row['other_receiving_host'];
                            $ero_drop_type =  $row['back_hp_type'];
                        }

                        
                    }
                    else if($row['inc_type'] == 'DROP_BACK'){
                        if($row['back_hospital'] == ''){
                            $pick_up_hp = ''; 
                            $ift_hosp_type = ''; 
                            $ero_drop = ''; 
                            $ero_drop_type = ''; 
                        }else{
                            $pick_up_hp = $row['back_hospital']; 
                            $ift_hosp_type = $row['back_hp_type']; 
                            $src_rec_hosp = $row['other_receiving_host'];
                            $ero_drop = ''; 
                            $dst_rec_hosp ='';
                            $ero_drop_type = ''; 
                        }
                    }else if($row['inc_type'] == 'PICK_UP'){
                        if($row['back_hospital'] == ''){
                            $pick_up_hp = ''; 
                            $ift_hosp_type = ''; 
                            $ero_drop = ''; 
                            $ero_drop_type = ''; 
                        }else{
                            $pick_up_hp = ''; 
                            $ift_hosp_type = '';
                            $src_rec_hosp =''; 
                            $ero_drop = $row['back_hospital'];
                            $dst_rec_hosp = $row['other_receiving_host'];
                            $ero_drop_type = $row['back_hp_type'];
                        } 
                    }
                    else{

                        if($row['ero_drop'] !='0' || $row['ero_drop'] != "" || $row['ero_drop'] != NULL ){
                                $ero_drop = $row['ero_drop'];
                        }else {
                                $ero_drop = '';
                        }

                        if($row['ero_type_one'] != "" || $row['ero_type_one'] != "0" || $row['ero_type_one'] != NULL){
                            $ero_drop_type = $row['ero_type_one'];
                        }else{
                            $ero_drop_type = "";
                        }
                        $dst_rec_hosp = $row['other_receiving_host'];
                        $pick_up_hp = ''; 
                        $ift_hosp_type = ''; 
                        $src_rec_hosp ='';

                    }

                    if($row['inc_type'] == 'MCI'){
                        $chief_complaint = $row['ntr_nature'];
                    }else{
                        $chief_complaint = $row['inc_complaint'];                
                    }

                    if($row['dp_on_scene']=="0000-00-00 00:00:00"){
                        $B2STime = "-";
                        $B2S_call_Time = "-";
                    }
                    if($row['dp_back_to_loc']=="0000-00-00 00:00:00"){
                        $B2BTime = "-";
                    }
                    $added_date_time = date('Y-m-d', strtotime($row['inc_recive_time']));
                    
                    $rcv_inc =  date_create(date($row['inc_recive_time']));
                    $disp_inc =  date_create(date($row['inc_datetime']));
                    $disp_diff = date_diff($disp_inc,$rcv_inc);
                    $disp_diff_tl = ($disp_diff->format("%a") * 24) + $disp_diff->format("%h").":". $disp_diff->format("%i").":". $disp_diff->format("%s");

                $dco_name= $row['dco_fname'].' '.$row['dco_midname'].' '.$row['dco_lname'];
                if($row['provider_impressions']==12){$provider_impressions='Yes';}else{$provider_impressions='No';}
                $inc_data = array(
                    'sr_no'=> $count,
                    'inc_datetime'=> $added_date_time,
                    'inc_call_pur' => 'Emergency',
                    'inc_call_type' => $row['pname'],
                    'inc_complaint'=> $chief_complaint,
                    'inc_complaint_other '=> $row['inc_complaint_other'],
                    'mci_nature '=> $row['ntr_nature'],
                    'inc_ref_id' => $row['incident_id'],
                    'inc_pcr_status'=> $pcr1,
                    'patient_ava_or_not_other_reason'=> $row['patient_ava_or_not_other_reason'],
                    // 'ar_name'=>$row['ar_name'],
                    'inc_area_type'=>$row['area_type_amb'],
                    'amb_rto_register_no' => $row['amb_reg_id'],
                    'amb_type' => $amb_type,
                    'amb_category' => $row['amb_category'],
                    'amb_district' => $amb_dist,
                    'amb_base_location' => $row['base_location_name'],
                    'amb_base_district' => $row['pre_base_dist'],
                    'amb_base_tehsil' => $row['pre_base_teh'],
                    'pilot_name' => ucwords($row['pilot_name']),
                    'other_pilot_name' => $row['pilot_id_other'],
                    'emt_name' => $row['emt_name'],
                    'other_emt_name' => $row['emt_id_other'],
                    'amb_gps_imei_no'=> $row['amb_gps_imei_no'],
                    'amb_mdt_srn_no'=> $row['amb_mdt_srn_no'],
                    'inc_div_id'=>$row['amb_div'],
                    'inc_datetime1'=> $row['inc_recive_time'],
                    'inc_recive_time2'=> $row['inc_datetime'],
                    // 'inc_dispatch_time'=> $row['inc_dispatch_time'],
                    'ero1'=>$name1,
                    'inc_added_by'=> $row['inc_added_by'],
                    'shift'=>'-',
                    'assign_time'=>$row['inc_datetime'],
                    'assign_time_diff'=>$disp_diff_tl,
                    'start_odo' => $row['start_odometer'],
                    // 'start_odo1' => $row['start_odometer'],
                    'scene_arrive_time'=>$row['dp_on_scene'],
                    'scene_odo'=>$row['scene_odometer'],
                    'at_scene_lat'=> $row['at_scene_lat'],
                    'at_scene_lng'=> $row['at_scene_lng'],
                    'B2Skm'=>$B2Skm,
                    'dp_started_base_loc'=> $B2STime,
                    'dp_started_base_loc1'=> $B2S_call_Time,

                    'dp_hosp_time'=> $hosp_time_dash,
                    'hospital_odometer1'=> $hosp_odo_dash,

                    'dp_hosp_time_km'=> $S2Hkm,
                    'dp_hosp_time1'=> $S2HTime,

                    // 'dp_hand_time'=> $hosp_hand_dash,
                    // 'dp_hand_odo_time'=> $row['hospital_odometer'],

                    // 'dp_hosp_time2'=> $hosp_time_dash,
                    'dp_back_to_loc'=> $row['dp_back_to_loc'],
                    'end_odometer'=> $row['end_odometer'],
                    'back_to_bs_loc_lat'=> $row['back_to_bs_loc_lat'],
                    'back_to_bs_loc_lng'=> $row['back_to_bs_loc_lng'],
                    'dp_reach_on_scene_km'=> $H2Bkm,
                    'dp_reach_on_scene'=> $H2BTime,
                    'dp_back_to_loc_km'=> $B2Bkm,
                    // 'total_km' => $B2Bkm,
                    'dp_back_to_loc1'=> $B2BTime,
                    'dp_back_to_loc2'=> $close_time,
                    'dco_name'=> $dco_name,
                    'caller_name' => $callername,
                    'caller_mobile' => $row['clr_mobile'],
                    'caller_relation' => $row['rel_name'],
                    'inc_district_id1'=> $inc_dst_name,
                    'inc_tahsil_id'=> $row['inc_tah_name'],
                    'inc_address'=> $row['inc_address'],
                    'hospital_name'=> $pick_up_hp,
                    'other_pick_hp' => $row['other_receiving_host'],
                    'ift_hosp_type'=> $ift_hosp_type,
                    // 'hospital_type'=> $row['back_hp_type'],
                    'pat_com_to_hosp_reason'=> $row['pat_com_to_hosp_reason'],
                    'inc_patient_cnt'=> $ptn_cnt,
                    'patient_name' => ucwords($patname) ,
                    'ptn_gender' => $gender,
                    'ptn_mob_no'=> $row['ptn_mob_no'],
                    'ptn_age' => $row['ptn_age']." ".$row['ptn_age_type'],
                    'ptn_district'=> $inc_dst_name,
                    'ptn_tahsil'=> $row['inc_tah_name'],
                    'ptn_add'=> $row['inc_address'],
                    // 'ero_stand_remark'=> $row['ero_standard_rem'],
                    'ero_remark'=> $row['inc_ero_summary'],
                    'dco_remark'=> $row['remark'],
                    'responce_time_remark'=> $row['remark_title'],
                    'res_rem_other'=> $row['responce_time_remark_other'],
                    'provider_impressions' => $provider_impressions,

                    'ayushman_id'=> $row['ayushman_id'],
                    'drop_district1'=> $row['one_dist_name'],
                    //'drop_home_address1'=> $row['drop_home_address'],
                 
                    'ero_dest_hosp' => $ero_drop,
                    // 'ero_dest_hosp_two' => $row['ero_drop_two'],
                    'other_dest_hosp' => $row['other_receiving_host'],
                    
                    'ero_type_one'=> $ero_drop_type,

                    'src_hosp_name'=> $pick_up_hp,
                   
                    'src_other_pick_hp' => $src_rec_hosp,
                    'src_hosp_type'=> $ift_hosp_type,

                    'des_dest_hosp' => $ero_drop,
                    'des_other_hosp' => $dst_rec_hosp,
                    'des_type_one'=> $ero_drop_type,


                    'inc_back_home_address'=> $row['drop_home_address'],
                    'add_drop_district'=> $row['drop_district'],
                    'reason'=> $row['ero_standard_rem'],
                    'ipd'=> '-',
                    'opd_no_txt'=> $row['opd_no_txt'],
                    'pcf'=>$row['ptn_pcf_no'],
                    'pr_total_amount'=>$row['pr_total_amount'],
                    'pro_name'=>$row['pro_name'],
                    

                );

                fputcsv($fp, $inc_data);
                $count++;
            }
            fclose($fp);
            exit;
        }
    }


    /*********************** Offroad Summary Report *************************/


    

    /***************/

    function offroad_summary_report_reasonwise() {

        $post_reports = $this->input->post();
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        $thirdparty = $this->clg->thirdparty;
        $district = $this->clg->clg_district_id;
        $clg_district_id = json_decode($district);
        if(is_array($clg_district_id)){
            $district_id = implode("','",$clg_district_id);
        }
        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                'system' => $post_reports['system'],
                
            );
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                'system' => $post_reports['system'],
                
            );
        }
        $header = array(
            'Fleet Remark',
            'ALS',
            'BLS',
            'JE',
            'Grand Total'
              );


              $acc_als=0;$acc_bls=0;$acc_je=0;
              $accidental = $this->inc_model->get_accidental_count($report_args);
              if($accidental){
              foreach ($accidental as $acc) {
                if($acc['amb_type']=='3')
                {
                    $acc_als = $acc['count'];
                }
                elseif($acc['amb_type']=='2')
                {
                    $acc_bls = $acc['count'];
                }
                elseif($acc['amb_type']=='1')
                {
                    $acc_je = $acc['count'];
                }
              }
            }
              $acc_total = (int)$acc_als + (int)$acc_bls + (int)$acc_je;
             
            $pre_als=0;$pre_bls=0;$pre_je=0;
              $Preventive = $this->inc_model->get_preventive_count($report_args);
              if($Preventive){
              foreach ($Preventive as $pre) {
                if($pre['amb_type']=='3')
                {
                    $pre_als = $pre['count'];
                }
                elseif($pre['amb_type']=='2')
                {
                    $pre_bls = $pre['count'];
                }
                elseif($pre['amb_type']=='1')
                {
                    $pre_je = $pre['count'];
                }
              }
            }
              $pre_total = (int)$pre_als + (int)$pre_bls + (int)$pre_je;
              
              $man_als=0;$man_bls=0;$man_je=0;
              $Manpower = $this->inc_model->get_manpower_count($report_args);
              if($Manpower){
              foreach ($Manpower as $man) {
                if($man['amb_type']=='3')
                {
                    $man_als = $man['count'];
                }
                elseif($man['amb_type']=='2')
                {
                    $man_bls = $man['count'];
                }
                elseif($man['amb_type']=='1')
                {
                    $man_je = $man['count'];
                }
              }}
              $man_total = (int)$man_als + (int)$man_bls + (int)$man_je;
              
              $Scrap_als=0;$Scrap_bls=0;$Scrap_je=0;
              $Scrap = $this->inc_model->get_scrap_count($report_args);
              if($Scrap){
              foreach ($Scrap as $scr) {
                if($scr['amb_type']=='3')
                {
                    $Scrap_als = $scr['count'];
                }
                elseif($scr['amb_type']=='2')
                {
                    $Scrap_bls = $scr['count'];
                }
                elseif($scr['amb_type']=='1')
                {
                    $Scrap_je = $scr['count'];
                }
              }}
              $Scrap_total = (int)$Scrap_als + (int)$Scrap_bls + (int)$Scrap_je;
              

              $Tyre_als=0;$Tyre_bls=0;$Tyre_je=0;
              $Tyre = $this->inc_model->get_tyre_count($report_args);
              if($Tyre){
              foreach ($Tyre as $tyre) {
                if($tyre['amb_type']=='3')
                {
                    $Tyre_als = $tyre['count'];
                }
                elseif($tyre['amb_type']=='2')
                {
                    $Tyre_bls = $tyre['count'];
                }
                elseif($tyre['amb_type']=='1')
                {
                    $Tyre_je = $tyre['count'];
                }
              }
            }
              $Tyre_total = (int)$Tyre_als + (int)$Tyre_bls + (int)$Tyre_je;
             
              $brk_als=0;$brk_bls=0;$brk_je=0;
              $Breakdown = $this->inc_model->get_brk_count($report_args);
              if($Breakdown){
              foreach ($Breakdown as $brk) {
                if($brk['amb_type']=='3')
                {
                    $brk_als = $brk['count'];
                }
                elseif($brk['amb_type']=='2')
                {
                    $brk_bls = $brk['count'];
                }
                elseif($brk['amb_type']=='1')
                {
                    $brk_je = $brk['count'];
                }
              }}
              $brk_total = (int)$brk_als + (int)$brk_bls + (int)$brk_je;

              $gen_als=0;$gen_bls=0;$gen_je=0;
              $General = $this->inc_model->get_gen_count($report_args);
              if($General){
              foreach ($General as $gen) {
                if($gen['amb_type']=='3')
                {
                    $gen_als = $gen['count'];
                }
                elseif($gen['amb_type']=='2')
                {
                    $gen_bls = $gen['count'];
                }
                elseif($gen['amb_type']=='1')
                {
                    $gen_je = $gen['count'];
                }
              }
                }
              $gen_total = (int)$gen_als + (int)$gen_bls + (int)$gen_je;

             $grand_total =  (int)$acc_total + (int)$pre_total + (int)$man_total + (int)$Scrap_total + (int)$Tyre_total + (int)$brk_total + (int)$gen_total;
              
        if ($post_reports['reports'] == 'view') {

            
            $inc_data = array(
                
                ['name'  => 'Accidental',
                'als'   => $acc_als,
                'bls'   => $acc_bls,
                'je'    => $acc_je,
                'total' => $acc_total],

                ['name'  => 'Schedule Service',
                'als'   => $pre_als,
                'bls'   => $pre_bls,
                'je'    => $pre_je,
                'total' => $pre_total],
            
                ['name'  => 'Manpower Issue',
                'als'   => $man_als,
                'bls'   => $man_bls,
                'je'    => $man_je,
                'total' => $man_total],
            
                ['name'  => 'Scrap Vehicle',
                'als'   => '0',
                'bls'   => '0',
                'je'    => '0',
                'total' => '0'],

                ['name'  => 'Tyre Issue',
                'als'   => $Tyre_als,
                'bls'   => $Tyre_bls,
                'je'    => $Tyre_je,
                'total' => $Tyre_total],

                ['name'  => 'Breakdown',
                'als'   => $brk_als,
                'bls'   => $brk_bls,
                'je'    => $brk_je,
                'total' => $brk_total],
                
                ['name'  => 'General Off-Road',
                'als'   => $gen_als,
                'bls'   => $gen_bls,
                'je'    => $gen_je,
                'total' => $gen_total],

                // 'grand_total' => $grand_total

        );


            
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'offroad_summary_report_reasonwise';

            $this->output->add_to_position($this->load->view('frontend/erc_reports/offroad_summary_table', $data, TRUE), 'list_table', TRUE);
        }
         else {
           // var_dump($report_data);die();
            $filename = "offroad_summary_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            
            $acc_als=0;$acc_bls=0;$acc_je=0;
            $accidental = $this->inc_model->get_accidental_count($report_args);
            if($accidental){
            foreach ($accidental as $acc) {
              if($acc['amb_type']=='3')
              {
                  $acc_als = $acc['count'];
              }
              elseif($acc['amb_type']=='2')
              {
                  $acc_bls = $acc['count'];
              }
              elseif($acc['amb_type']=='1')
              {
                  $acc_je = $acc['count'];
              }
            }}
            $acc_total = (int)$acc_als + (int)$acc_bls + (int)$acc_je;

            $acc_als=0;$acc_bls=0;$acc_je=0;
            $accidental = $this->inc_model->get_accidental_count($report_args);
            if($accidental){
            foreach ($accidental as $acc) {
              if($acc['amb_type']=='3')
              {
                  $acc_als = $acc['count'];
              }
              elseif($acc['amb_type']=='2')
              {
                  $acc_bls = $acc['count'];
              }
              elseif($acc['amb_type']=='1')
              {
                  $acc_je = $acc['count'];
              }
            }}
            $acc_total = (int)$acc_als + (int)$acc_bls + (int)$acc_je;

            $acc_als=0;$acc_bls=0;$acc_je=0;
            $accidental = $this->inc_model->get_accidental_count($report_args);
            if($accidental){
            foreach ($accidental as $acc) {
              if($acc['amb_type']=='3')
              {
                  $acc_als = $acc['count'];
              }
              elseif($acc['amb_type']=='2')
              {
                  $acc_bls = $acc['count'];
              }
              elseif($acc['amb_type']=='1')
              {
                  $acc_je = $acc['count'];
              }
            }
            }
            $acc_total = (int)$acc_als + (int)$acc_bls + (int)$acc_je;

            $pre_als=0;$pre_bls=0;$pre_je=0;
            $Preventive = $this->inc_model->get_preventive_count($report_args);
            if($Preventive){
            foreach ($Preventive as $pre) {
              if($pre['amb_type']=='3')
              {
                  $pre_als = $pre['count'];
              }
              elseif($pre['amb_type']=='2')
              {
                  $pre_bls = $pre['count'];
              }
              elseif($pre['amb_type']=='1')
              {
                  $pre_je = $pre['count'];
              }
            }}
            $pre_total = (int)$pre_als + (int)$pre_bls + (int)$pre_je;

            $man_als=0;$man_bls=0;$man_je=0;
            $Manpower = $this->inc_model->get_manpower_count($report_args);
            if($Manpower){
            foreach ($Manpower as $man) {
              if($man['amb_type']=='3')
              {
                  $man_als = $man['count'];
              }
              elseif($man['amb_type']=='2')
              {
                  $man_bls = $man['count'];
              }
              elseif($man['amb_type']=='1')
              {
                  $man_je = $man['count'];
              }
            }}
            $man_total = (int)$man_als + (int)$man_bls + (int)$man_je;

            $Scrap_als=0;$Scrap_bls=0;$Scrap_je=0;
            $Scrap = $this->inc_model->get_scrap_count($report_args);
            if($Scrap){
            foreach ($Scrap as $scr) {
              if($scr['amb_type']=='3')
              {
                  $Scrap_als = $scr['count'];
              }
              elseif($scr['amb_type']=='2')
              {
                  $Scrap_bls = $scr['count'];
              }
              elseif($scr['amb_type']=='1')
              {
                  $Scrap_je = $scr['count'];
              }
            }
        }
            $Scrap_total = (int)$Scrap_als + (int)$Scrap_bls + (int)$Scrap_je;


            $Tyre_als=0;$Tyre_bls=0;$Tyre_je=0;
            $Tyre = $this->inc_model->get_tyre_count($report_args);
            if($Tyre){
            foreach ($Tyre as $tyre) {
              if($tyre['amb_type']=='3')
              {
                  $Tyre_als = $tyre['count'];
              }
              elseif($tyre['amb_type']=='2')
              {
                  $Tyre_bls = $tyre['count'];
              }
              elseif($tyre['amb_type']=='1')
              {
                  $Tyre_je = $tyre['count'];
              }
            }}
            $Tyre_total = (int)$Tyre_als + (int)$Tyre_bls + (int)$Tyre_je;

            $brk_als=0;$brk_bls=0;$brk_je=0;
            $Breakdown = $this->inc_model->get_brk_count($report_args);
            if($Breakdown){
            foreach ($Breakdown as $brk) {
              if($brk['amb_type']=='3')
              {
                  $brk_als = $brk['count'];
              }
              elseif($brk['amb_type']=='2')
              {
                  $brk_bls = $brk['count'];
              }
              elseif($brk['amb_type']=='1')
              {
                  $brk_je = $brk['count'];
              }
            }}
            $brk_total = (int)$brk_als + (int)$brk_bls + (int)$brk_je;


            $gen_als=0;$gen_bls=0;$gen_je=0;
            $General = $this->inc_model->get_gen_count($report_args);
            if($General){
            foreach($General as $gen) {
              if($gen['amb_type']=='3')
              {
                  $gen_als = $gen['count'];
              }
              elseif($gen['amb_type']=='2')
              {
                  $gen_bls = $gen['count'];
              }
              elseif($gen['amb_type']=='1')
              {
                  $gen_je = $gen['count'];
              }
            }
        }
            $gen_total = (int)$gen_als + (int)$gen_bls + (int)$gen_je;

            $als = (int)$acc_als + (int)$pre_als + (int)$man_als + (int)$Scrap_als + (int)$Tyre_als+ (int)$brk_als+ (int)$gen_als;
            $bls = (int)$acc_bls + (int)$pre_bls + (int)$man_bls + (int)$Scrap_bls + (int)$Tyre_bls+ (int)$brk_bls+ (int)$gen_bls;
            $je = (int)$acc_je + (int)$pre_je + (int)$man_je + (int)$Scrap_je + (int)$Tyre_je+ (int)$brk_je+ (int)$gen_je;
           $grand_total =  (int)$acc_total + (int)$pre_total + (int)$man_total + (int)$Scrap_total + (int)$Tyre_total + (int)$brk_total + (int)$gen_total;
           
       

        $report_data = array(
                
            ['name'  => 'Accidental',
            'als'   => $acc_als,
            'bls'   => $acc_bls,
            'je'    => $acc_je,
            'total' => $acc_total],

            ['name'  => 'Schedule Service (Preventive)',
            'als'   => $pre_als,
            'bls'   => $pre_bls,
            'je'    => $pre_je,
            'total' => $pre_total],
        
            ['name'  => 'Manpower Issue',
            'als'   => $man_als,
            'bls'   => $man_bls,
            'je'    => $man_je,
            'total' => $man_total],
        
            ['name'  => 'Scrap Vehicle',
            'als'   => '0',
            'bls'   => '0',
            'je'    => '0',
            'total' => '0'],

            ['name'  => 'Tyre Issue',
            'als'   => $Tyre_als,
            'bls'   => $Tyre_bls,
            'je'    => $Tyre_je,
            'total' => $Tyre_total],

            ['name'  => 'Breakdown',
            'als'   => $brk_als,
            'bls'   => $brk_bls,
            'je'    => $brk_je,
            'total' => $brk_total],
            
            ['name'  => 'General',
            'als'   => $gen_als,
            'bls'   => $gen_bls,
            'je'    => $gen_je,
            'total' => $gen_total],

            ['name'  => 'Grand Total',
            'als'   => $als,
            'bls'   => $bls,
            'je'    => $je,
            'total' => $grand_total]

            // 'grand_total' => $grand_total

    );
    foreach ($report_data as $row) {
               
                
        $inc_data = array(
            
            'name'  => $row['name'],
            'als'   => $row['als'],
            'bls'   => $row['bls'],
            'je'    => $row['je'],
            'total' => $row['total']

        );

        fputcsv($fp, $inc_data);
        $count++;
    }

            //    fputcsv($fp, $inc_data);
             
            fclose($fp);
            exit;
        }
    }
/************* */


    function offroad_summary_report_zonewise() {

        $post_reports = $this->input->post();
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        $zone_dtl = $this->inc_model->get_zonewise_dtl($report_args);
        $grand_total=0;$als=0;$bls=0;$je=0;
        $zone_array=[];
        
        foreach ($zone_dtl as $zone) {
            $gen_als=0;$gen_bls=0;$gen_je=0;
        $brk_als=0;$brk_bls=0;$brk_je=0;
        $acc_als=0;$acc_bls=0;$acc_je=0;
        $pre_als=0;$pre_bls=0;$pre_je=0;
        $man_als=0;$man_bls=0;$man_je=0;
        $Scrap_als=0;$Scrap_bls=0;$Scrap_je=0;
        $Tyre_als=0;$Tyre_bls=0;$Tyre_je=0;
              $gen_total_final =0;
              $pre_total_final=0; 
              $man_total_final =0;
              $Tyre_total_final =0;
              $brk_total_final =0;
              $acc_total_final =0;
              
              $brk_als_final =0;
              $Tyre_als_final =0;
              $man_als_final =0;
              $pre_als_final =0;
              $acc_als_final =0;
              $gen_als_final =0;

              $brk_bls_final =0;
              $Tyre_bls_final =0;
              $man_bls_final =0;
              $pre_bls_final =0;
              $acc_bls_final =0;
              $gen_bls_final =0;

              $brk_je_final =0;
              $Tyre_je_final =0;
              $man_je_final =0;
              $pre_je_final =0;
              $acc_je_final =0;
              $gen_je_final =0;
        if ($post_reports['from_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                'system' => $post_reports['system'],
                'zone' => $zone['div_code'] 
            );
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                'system' => $post_reports['system'],
                'zone' => $zone['div_code']  
            );
        }
        
            $General = $this->inc_model->get_zonewise_count_gen($report_args);
            if($General){
            foreach ($General as $gen) {
              if($gen['amb_type']=='3')
              {
                  $gen_als = $gen['count'];
              }
              elseif($gen['amb_type']=='2')
              {
                  $gen_bls = $gen['count'];
              }
              elseif($gen['amb_type']=='1')
              {
                  $gen_je = $gen['count'];
              }
            }}
            $gen_total = (int)$gen_als + (int)$gen_bls + (int)$gen_je;
            $accidental = $this->inc_model->get_zonewise_count_accidental($report_args);

            if($accidental){
            foreach ($accidental as $acc) {
              if($acc['amb_type']=='3')
              {
                  $acc_als = $acc['count'];
              }
              elseif($acc['amb_type']=='2')
              {
                  $acc_bls = $acc['count'];
              }
              elseif($acc['amb_type']=='1')
              {
                  $acc_je = $acc['count'];
              }
            }
        }
            $acc_total = (int)$acc_als + (int)$acc_bls + (int)$acc_je;
            
            
              $Preventive = $this->inc_model->get_zonewise_count_preventive($report_args);
              if($Preventive){
              foreach ($Preventive as $pre) {
                if($pre['amb_type']=='3')
                {
                    $pre_als = $pre['count'];
                }
                elseif($pre['amb_type']=='2')
                {
                    $pre_bls = $pre['count'];
                }
                elseif($pre['amb_type']=='1')
                {
                    $pre_je = $pre['count'];
                }
              }
            }
            $pre_total = (int)$pre_als + (int)$pre_bls + (int)$pre_je;

            
              $Manpower = $this->inc_model->get_zonewise_count_manpower($report_args);
              if($Manpower){
              foreach ($Manpower as $man) {
                if($man['amb_type']=='3')
                {
                    $man_als = $man['count'];
                }
                elseif($man['amb_type']=='2')
                {
                    $man_bls = $man['count'];
                }
                elseif($man['amb_type']=='1')
                {
                    $man_je = $man['count'];
                }
              }}
              $man_total = (int)$man_als + (int)$man_bls + (int)$man_je;

             
              $Scrap = $this->inc_model->get_zonewise_count_scrap($report_args);
              if($Scrap){
              foreach ($Scrap as $scr) {
                if($scr['amb_type']=='3')
                {
                    $Scrap_als = $scr['count'];
                }
                elseif($scr['amb_type']=='2')
                {
                    $Scrap_bls = $scr['count'];
                }
                elseif($scr['amb_type']=='1')
                {
                    $Scrap_je = $scr['count'];
                }
              }}
              $Scrap_total = (int)$Scrap_als + (int)$Scrap_bls + (int)$Scrap_je;

              
              $Tyre = $this->inc_model->get_zonewise_count_tyre($report_args);
              if($Tyre){
              foreach ($Tyre as $tyre) {
                if($tyre['amb_type']=='3')
                {
                    $Tyre_als = $tyre['count'];
                }
                elseif($tyre['amb_type']=='2')
                {
                    $Tyre_bls = $tyre['count'];
                }
                elseif($tyre['amb_type']=='1')
                {
                    $Tyre_je = $tyre['count'];
                }
              }
            }
              $Tyre_total = (int)$Tyre_als + (int)$Tyre_bls + (int)$Tyre_je;

              
              $Breakdown = $this->inc_model->get_zonewise_count_brk($report_args);
              if($Breakdown){
              foreach ($Breakdown as $brk) {
                if($brk['amb_type']=='3')
                {
                    $brk_als = $brk['count'];
                }
                elseif($brk['amb_type']=='2')
                {
                    $brk_bls = $brk['count'];
                }
                elseif($brk['amb_type']=='1')
                {
                    $brk_je = $brk['count'];
                }
              }}
              $brk_total = (int)$brk_als + (int)$brk_bls + (int)$brk_je;
              

              $gen_total_final += $gen_total;
              $pre_total_final += $pre_total;
              $man_total_final += $man_total;
              $Tyre_total_final += $Tyre_total;
              $brk_total_final += $brk_total;
              $acc_total_final += $acc_total;
              
              $brk_als_final += $brk_als;
              $Tyre_als_final += $Tyre_als;
              $man_als_final += $man_als;
              $pre_als_final += $pre_als;
              $acc_als_final += $acc_als;
              $gen_als_final += $gen_als;

              $brk_bls_final += $brk_bls;
              $Tyre_bls_final += $Tyre_bls;
              $man_bls_final += $man_bls;
              $pre_bls_final += $pre_bls;
              $acc_bls_final += $acc_bls;
              $gen_bls_final += $gen_bls;

              $brk_je_final += $brk_je;
              $Tyre_je_final += $Tyre_je;
              $man_je_final += $man_je;
              $pre_je_final += $pre_je;
              $acc_je_final += $acc_je;
              $gen_je_final += $gen_je;

              $grand_total =  (int)$acc_total_final + (int)$pre_total_final + (int)$man_total_final + (int)$Tyre_total_final + (int)$brk_total_final + (int)$gen_total_final;
              $als_total = $brk_als_final + $Tyre_als_final +  $man_als_final + $pre_als_final + $acc_als_final + $gen_als_final;
              $bls_total = $brk_bls_final + $Tyre_bls_final +  $man_bls_final + $pre_bls_final + $acc_bls_final + $gen_bls_final;
              $je_total = $brk_je_final + $Tyre_je_final  + $man_je_final + $pre_je_final + $acc_je_final + $gen_je_final;
           
            $zone_arr = ['name'  => $zone['div_name'],
            'als'   => $als_total,
            'bls'   => $bls_total,
            'je'    => $je_total,
            'total' => $grand_total];
            array_push($zone_array,$zone_arr);
           // print_r($zone_arr);die();
        }
        

        $header = array(
            'Zone',
            'ALS',
            'BLS',
            'JE',
            'Grand Total'
              );

        if ($post_reports['reports'] == 'view') {

            $inc_data = $zone_array;
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'offroad_summary_report_zonewise';

            $this->output->add_to_position($this->load->view('frontend/erc_reports/offroad_summary_zonewise', $data, TRUE), 'list_table', TRUE);
        }
         else {
           // var_dump($report_data);die();
            $filename = "offroad_summary_report_zonewise.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            $count=1;
            $zone_arr = ['name'  => ' Total',
            'als'   => $als_total,
            'bls'   => $bls_total,
            'je'    => $je_total,
            'total' => $grand_total];
           // array_push($zone_array,$zone_arr);
            foreach ($zone_array as $row) {
               
                
                $inc_data = array(
            
                    'name'  => $row['name'],
                    'als'   => $row['als'],
                    'bls'   => $row['bls'],
                    'je'    => $row['je'],
                    'total' => $row['total']
        
                );

                fputcsv($fp, $inc_data);
                $count++;

                $als += (int)$row['als'];
                $bls += (int)$row['bls'];
                $je += (int)$row['je'];
                $total += (int)$row['total'];
            }
            $inc_data2 = array(
            
                'Total'  => 'Total',
                'als'   => $als,
                'bls'   => $bls,
                'je'    => $je,
                'total' => $total
    
            );
            fputcsv($fp, $inc_data2);
            

            fclose($fp);
            exit;
        }
    }

    /********************** */



    function offroad_summary_report_districtwise() {

        $post_reports = $this->input->post();
        
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        $thirdparty = $this->clg->thirdparty;
        $district = $this->clg->clg_district_id;
        $clg_district_id = json_decode($district);
        if(is_array($clg_district_id)){
            $district_id = implode("','",$clg_district_id);
        }


        if ($post_reports['from_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                // 'thirdparty' => $thirdparty,
                'system' => $post_reports['system'],
                //'clg_district_id' => $district_id 
            );
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                // 'thirdparty' => $thirdparty,
                'system' => $post_reports['system'],
                //'clg_district_id' => $district_id 
            );
        }


        $zone_dtl = $this->inc_model->get_district_wise_dtl($report_args);
        $grand_total=0;
            $zone_array=[];
            $count=1;
        foreach ($zone_dtl as $zone) {
            $gen_total_final =0;
              $pre_total_final=0; 
              $man_total_final =0;
              $Tyre_total_final =0;
              $brk_total_final =0;
              $acc_total_final =0;
              
              $brk_als_final =0;
              $Tyre_als_final =0;
              $man_als_final =0;
              $pre_als_final =0;
              $acc_als_final =0;
              $gen_als_final =0;

              $brk_bls_final =0;
              $Tyre_bls_final =0;
              $man_bls_final =0;
              $pre_bls_final =0;
              $acc_bls_final =0;
              $gen_bls_final =0;

              $brk_je_final =0;
              $Tyre_je_final =0;
              $man_je_final =0;
              $pre_je_final =0;
              $acc_je_final =0;
              $gen_je_final =0;
        if ($post_reports['from_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
               // 'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
                // 'thirdparty' => $thirdparty,
                'system' => $post_reports['system'],
                'district' => $zone['dst_code'] 
            );
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                //'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                // 'thirdparty' => $thirdparty,
                'system' => $post_reports['system'],
                'district' => $zone['dst_code']  
            );
        }
        $gen_als=0;$gen_bls=0;$gen_je=0;
            $General = $this->inc_model->get_district_wise_general_offroad($report_args);
            foreach ($General as $gen) {
              if($gen['amb_type']=='3')
              {
                  $gen_als = $gen['count'];
              }
              elseif($gen['amb_type']=='2')
              {
                  $gen_bls = $gen['count'];
              }
              elseif($gen['amb_type']=='1')
              {
                  $gen_je = $gen['count'];
              }
            }
            $gen_total = (int)$gen_als + (int)$gen_bls + (int)$gen_je;
            $acc_als=0;$acc_bls=0;$acc_je=0;
            $accidental = $this->inc_model->get_district_wise_accidental($report_args);

            if($accidental){
            foreach ($accidental as $acc) {
              if($acc['amb_type']=='3')
              {
                  $acc_als = $acc['count'];
              }
              elseif($acc['amb_type']=='2')
              {
                  $acc_bls = $acc['count'];
              }
              elseif($acc['amb_type']=='1')
              {
                  $acc_je = $acc['count'];
              }
            }}
            $acc_total = (int)$acc_als + (int)$acc_bls + (int)$acc_je;

            $pre_als=0;$pre_bls=0;$pre_je=0;
              $Preventive = $this->inc_model->get_district_wise_preventive($report_args);
              if($Preventive){
              foreach ($Preventive as $pre) {
                if($pre['amb_type']=='3')
                {
                    $pre_als = $pre['count'];
                }
                elseif($pre['amb_type']=='2')
                {
                    $pre_bls = $pre['count'];
                }
                elseif($pre['amb_type']=='1')
                {
                    $pre_je = $pre['count'];
                }
              }
            }
            $pre_total = (int)$pre_als + (int)$pre_bls + (int)$pre_je;

            $man_als=0;$man_bls=0;$man_je=0;
              $Manpower = $this->inc_model->get_district_wise_manpower($report_args);
              if($Manpower){
              foreach ($Manpower as $man) {
                if($man['amb_type']=='3')
                {
                    $man_als = $man['count'];
                }
                elseif($man['amb_type']=='2')
                {
                    $man_bls = $man['count'];
                }
                elseif($man['amb_type']=='1')
                {
                    $man_je = $man['count'];
                }
              }}
              $man_total = (int)$man_als + (int)$man_bls + (int)$man_je;

              $Scrap_als=0;$Scrap_bls=0;$Scrap_je=0;
              $Scrap = $this->inc_model->get_district_wise_scrap($report_args);
              if($Scrap){
              foreach ($Scrap as $scr) {
                if($scr['amb_type']=='3')
                {
                    $Scrap_als = $scr['count'];
                }
                elseif($scr['amb_type']=='2')
                {
                    $Scrap_bls = $scr['count'];
                }
                elseif($scr['amb_type']=='1')
                {
                    $Scrap_je = $scr['count'];
                }
              }}
              $Scrap_total = (int)$Scrap_als + (int)$Scrap_bls + (int)$Scrap_je;

              $Tyre_als=0;$Tyre_bls=0;$Tyre_je=0;
              $Tyre = $this->inc_model->get_district_wise_tyre($report_args);
              if($Tyre){
              foreach ($Tyre as $tyre) {
                if($tyre['amb_type']=='3')
                {
                    $Tyre_als = $tyre['count'];
                }
                elseif($tyre['amb_type']=='2')
                {
                    $Tyre_bls = $tyre['count'];
                }
                elseif($tyre['amb_type']=='1')
                {
                    $Tyre_je = $tyre['count'];
                }
              }
            }
              $Tyre_total = (int)$Tyre_als + (int)$Tyre_bls + (int)$Tyre_je;

              $brk_als=0;$brk_bls=0;$brk_je=0;
              $Breakdown = $this->inc_model->get_district_wise_breakdown($report_args);
              if($Breakdown){
              foreach ($Breakdown as $brk) {
                if($brk['amb_type']=='3')
                {
                    $brk_als = $brk['count'];
                }
                elseif($brk['amb_type']=='2')
                {
                    $brk_bls = $brk['count'];
                }
                elseif($brk['amb_type']=='1')
                {
                    $brk_je = $brk['count'];
                }
              }}
              $brk_total = (int)$brk_als + (int)$brk_bls + (int)$brk_je;

              $gen_total_final += $gen_total;
              $pre_total_final += $pre_total;
              $man_total_final += $man_total;
              $Tyre_total_final += $Tyre_total;
              $brk_total_final += $brk_total;
              $acc_total_final += $acc_total;
              
              $brk_als_final += $brk_als;
              $Tyre_als_final += $Tyre_als;
              $man_als_final += $man_als;
              $pre_als_final += $pre_als;
              $acc_als_final += $acc_als;
              $gen_als_final += $gen_als;

              $brk_bls_final += $brk_bls;
              $Tyre_bls_final += $Tyre_bls;
              $man_bls_final += $man_bls;
              $pre_bls_final += $pre_bls;
              $acc_bls_final += $acc_bls;
              $gen_bls_final += $gen_bls;

              $brk_je_final += $brk_je;
              $Tyre_je_final += $Tyre_je;
              $man_je_final += $man_je;
              $pre_je_final += $pre_je;
              $acc_je_final += $acc_je;
              $gen_je_final += $gen_je;

              $grand_total =  (int)$acc_total_final + (int)$pre_total_final + (int)$man_total_final + (int)$Tyre_total_final + (int)$brk_total_final + (int)$gen_total_final;
              $als_total = $brk_als_final + $Tyre_als_final +  $man_als_final + $pre_als_final + $acc_als_final + $gen_als_final;
              $bls_total = $brk_bls_final + $Tyre_bls_final +  $man_bls_final + $pre_bls_final + $acc_bls_final + $gen_bls_final;
              $je_total = $brk_je_final + $Tyre_je_final  + $man_je_final + $pre_je_final + $acc_je_final + $gen_je_final;
            

            //$grand_total +=(int)$grand_total;
            $zone_arr = [
            'count' => $count,
            'div_name'  => $zone['div_name'],
            'name'  => $zone['dst_name'],
            'als'   => $als_total,
            'bls'   => $bls_total,
            'je'    => $je_total,
            'total' => $grand_total];
            array_push($zone_array,$zone_arr);
            $count++;
        }
        $header = array(
            'Sr.NO',
            'Zone',
            'District',
            'ALS',
            'BLS',
            'JE',
            'Grand Total'
              );

        if ($post_reports['reports'] == 'view') {

            $inc_data = $zone_array;
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'offroad_summary_report_districtwise';

            $this->output->add_to_position($this->load->view('frontend/erc_reports/off_road_summary_districtwise', $data, TRUE), 'list_table', TRUE);
        }
         else {
           // var_dump($report_data);die();
            $filename = "offroad_summary_report_districtwise.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);
            
            $inc_data = array();
            $count=1;
            $zone_arr = ['name'  => 'Grand Total',
            'als'   => $als_total,
            'bls'   => $bls_total,
            'je'    => $je_total,
            'total' => $grand_total];
            //array_push($zone_array,$zone_arr);
            foreach ($zone_array as $row) {
               
                
                $inc_data = array(
                    'count'  => $count,
                    'div_name'  => $row['div_name'],
                    'name'  => $row['name'],
                    'als'   => $row['als'],
                    'bls'   => $row['bls'],
                    'je'    => $row['je'],
                    'total' => $row['total']
                    
                );
                $als += (int)$row['als'];
                $bls += (int)$row['bls'];
                $je += (int)$row['je'];
                $total += (int)$row['total'];
                fputcsv($fp, $inc_data);
                $count++;
            }
            $inc_data1 = array(
                'count'  => '',
                'Total'  => 'Total',
                'name'  => '',
                'als'   => $als,
                'bls'   => $bls,
                'je'    => $je,
                'total' => $total
                
            );
            fputcsv($fp, $inc_data1);
            $count++;
            fclose($fp);
            exit;
        }
    }

/************* */

    function offroad_summary_report_total() {

        $post_reports = $this->input->post();
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        $thirdparty = $this->clg->thirdparty;
        $district = $this->clg->clg_district_id;
        $clg_district_id = json_decode($district);
        if(is_array($clg_district_id)){
            $district_id = implode("','",$clg_district_id);
        }


        if ($post_reports['from_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                //'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
                // 'thirdparty' => $thirdparty,
                'system' => $post_reports['system'],
                //'clg_district_id' => $district_id 
            );
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                //'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                // 'thirdparty' => $thirdparty,
                'system' => $post_reports['system'],
                //'clg_district_id' => $district_id 
            );
        }

            $Total_on = $this->inc_model->total_ambulance_data();
              $Total_on_als = $this->inc_model->total_als_ambulance_data();
              $Total_on_bls = $this->inc_model->total_bls_ambulance_data();
              $Total_on_je = $this->inc_model->total_je_ambulance_data();

              

            $gen_als=0;$gen_bls=0;$gen_je=0;
              $General = $this->inc_model->get_gen_count($report_args);
              foreach ($General as $gen) {
                if($gen['amb_type']=='3')
                {
                    $gen_als = $gen['count'];
                }
                elseif($gen['amb_type']=='2')
                {
                    $gen_bls = $gen['count'];
                }
                elseif($gen['amb_type']=='1')
                {
                    $gen_je = $gen['count'];
                }
              }
              $gen_total = (int)$gen_als + (int)$gen_bls + (int)$gen_je;

              $acc_als=0;$acc_bls=0;$acc_je=0;
              $accidental = $this->inc_model->get_accidental_count($report_args);
              if($accidental){
              foreach ($accidental as $acc) {
                if($acc['amb_type']=='1')
                {
                    $acc_als = $acc['count'];
                }
                elseif($acc['amb_type']=='2')
                {
                    $acc_bls = $acc['count'];
                }
                elseif($acc['amb_type']=='3')
                {
                    $acc_je = $acc['count'];
                }
              }
            }
              $acc_total = (int)$acc_als + (int)$acc_bls + (int)$acc_je;

              $pre_als=0;$pre_bls=0;$pre_je=0;
              $Preventive = $this->inc_model->get_preventive_count($report_args);
              if($Preventive){
              foreach ($Preventive as $pre) {
                if($pre['amb_type']=='1')
                {
                    $pre_als = $pre['count'];
                }
                elseif($pre['amb_type']=='2')
                {
                    $pre_bls = $pre['count'];
                }
                elseif($pre['amb_type']=='3')
                {
                    $pre_je = $pre['count'];
                }
              }
            }
              $pre_total = (int)$pre_als + (int)$pre_bls + (int)$pre_je;

              $man_als=0;$man_bls=0;$man_je=0;
              $Manpower = $this->inc_model->get_manpower_count($report_args);
              if($Manpower){
              foreach ($Manpower as $man) {
                if($man['amb_type']=='1')
                {
                    $man_als = $man['count'];
                }
                elseif($man['amb_type']=='2')
                {
                    $man_bls = $man['count'];
                }
                elseif($man['amb_type']=='3')
                {
                    $man_je = $man['count'];
                }
              }}
              $man_total = (int)$man_als + (int)$man_bls + (int)$man_je;

              $Scrap_als=0;$Scrap_bls=0;$Scrap_je=0;
              $Scrap = $this->inc_model->get_scrap_count($report_args);
              if($Scrap){
              foreach ($Scrap as $scr) {
                if($scr['amb_type']=='1')
                {
                    $Scrap_als = $scr['count'];
                }
                elseif($scr['amb_type']=='2')
                {
                    $Scrap_bls = $scr['count'];
                }
                elseif($scr['amb_type']=='3')
                {
                    $Scrap_je = $scr['count'];
                }
              }}
              $Scrap_total = (int)$Scrap_als + (int)$Scrap_bls + (int)$Scrap_je;

              $Tyre_als=0;$Tyre_bls=0;$Tyre_je=0;
              $Tyre = $this->inc_model->get_tyre_count($report_args);
              if($Tyre){
              foreach ($Tyre as $tyre) {
                if($tyre['amb_type']=='1')
                {
                    $Tyre_als = $tyre['count'];
                }
                elseif($tyre['amb_type']=='2')
                {
                    $Tyre_bls = $tyre['count'];
                }
                elseif($tyre['amb_type']=='3')
                {
                    $Tyre_je = $tyre['count'];
                }
              }
            }
              $Tyre_total = (int)$Tyre_als + (int)$Tyre_bls + (int)$Tyre_je;

              $brk_als=0;$brk_bls=0;$brk_je=0;
              $Breakdown = $this->inc_model->get_brk_count($report_args);
              if($Breakdown){
              foreach ($Breakdown as $brk) {
                if($brk['amb_type']=='1')
                {
                    $brk_als = $brk['count'];
                }
                elseif($brk['amb_type']=='2')
                {
                    $brk_bls = $brk['count'];
                }
                elseif($brk['amb_type']=='3')
                {
                    $brk_je = $brk['count'];
                }
              }}
              $brk_total = (int)$brk_als + (int)$brk_bls + (int)$brk_je;

              $grand_total =  (int)$acc_total + (int)$pre_total + (int)$man_total  + (int)$Tyre_total + (int)$brk_total + (int)$gen_total;
              $als_total = $brk_als + $Tyre_als +  $man_als + $pre_als + $acc_als + $gen_als;
              $bls_total = $brk_bls + $Tyre_bls +  $man_bls + $pre_bls + $acc_bls + $gen_bls;
              $je_total = $brk_je + $Tyre_je  + $man_je + $pre_je + $acc_je + $gen_je;

              $Total_als = $als_total + $Total_on_als;
              $Total_bls = $bls_total + $Total_on_bls;
              $Total_je = $je_total + $Total_on_je;
              $Total = $grand_total + $Total_on;

              $Gen_array = ['name'  => 'Total Ambulance',
              'als'   => $Total_als,
              'bls'   => $Total_bls,
              'je'    => $Total_je,
              'total' => $Total];

              $Gen_off_array = ['name'  => 'Total Off Road Ambulance Count',
              'als'   => $als_total,
              'bls'   => $bls_total,
              'je'    => $je_total,
              'total' => $grand_total];

              $Gen_on_array = ['name'  => 'Total ON Road Ambulance Count',
              'als'   => $Total_on_als,
              'bls'   => $Total_on_bls,
              'je'    => $Total_on_je,
              'total' => $Total_on];

             

       
        $header = array(
            'Ambulance',
            'ALS',
            'BLS',
            'JE',
            'Grand Total'
              );

        if ($post_reports['reports'] == 'view') {

            $inc_data = array($Gen_array,$Gen_off_array,$Gen_on_array);
           
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'offroad_summary_report_total';

            $this->output->add_to_position($this->load->view('frontend/erc_reports/offroad_summary_total', $data, TRUE), 'list_table', TRUE);
        }
         else {
           // var_dump($report_data);die();
            $filename = "offroad_summary_report_total.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            $count=1;
            $report_data = array($Gen_array,$Gen_off_array,$Gen_on_array); 
            foreach ($report_data as $row) {
               
                
                $inc_data = array(
                    
                    'name'  => $row['name'],
                    'als'   => $row['als'],
                    'bls'   => $row['bls'],
                    'je'    => $row['je'],
                    'total' => $row['total']

                );

                fputcsv($fp, $inc_data);
                $count++;
            }
            fclose($fp);
            exit;
        }
    }

    /************************************************************************/
    function all_call_format_table() {

        $post_reports = $this->input->post();
        
        // $track_args = array('trk_report_name'=>'Closure Report Incident datewise','trk_download_by'=>$this->clg->clg_ref_id);
        // track_report_download($track_args);

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        $thirdparty = $this->clg->thirdparty;
        $district = $this->clg->clg_district_id;
        $clg_district_id = json_decode($district);
        if(is_array($clg_district_id)){
            $district_id = implode("','",$clg_district_id);
        }


        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
                // 'thirdparty' => $thirdparty,
                'system' => $post_reports['system'],
                //'clg_district_id' => $district_id 
            );
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                // 'thirdparty' => $thirdparty,
                'system' => $post_reports['system'],
                //'clg_district_id' => $district_id 
            );
        }


        $report_data = $this->inc_model->get_nhm_mis_by_month($report_args);
    //   var_dump($report_data);
    //    die();

       
        $header = array('Sr.No',
              'Event ID',
            'Call Type',
            'Event Date',
            'Incident ID',
            'Closing Status',
            'Cancel/Not Availed Reason',
            'Area',
            'Vehicle No',
            'Vehicle TYPE',
            'Base Location',
            'Vehicle District',
            'Driver Name',
            'EMT Name',
            'GPS ID',
            'MDT ID',
            'Zone',
            'Inc call date & Time',
            'Call Receive Date Time',
            'Call End Date Time',
            'Call Taker ERO Name',
            'Call Taker ERO ID',
            'Dispatched Shift',
            'Assign time & Date',
            'Difference',
            'Previous case ODO',
            'Start ODO',
            'Scene Arrival Date Time',
            'Scene ODO',
            'Scene Latitude',
            'Scene Longitude',
            'B2S KMs',
            'B2S Time',
            'Call To Scene Time',
            'Hosp Drop Date Time',
            'Hosp Drop ODO',
            'S2H KMs',
            'S2H TIME',
            'Scene To Hospital',
            'Back To Base Time',
            'Back To Base ODO',
            'Back to Base Latitude',
            'Back to Base Longitude',
            'H2B KMs',
            'H2B TIME',
            'B2B KMs',
            'Total Trip KM ',
            'B2B Time',
            'Case Closed Date Time',
            'DCO Name',
            'Caller Name',
            'Caller Phone No',
            'Caller Category',
            'Inc District',
            'Inc Tehsil',
            'Inc Location  City/Village/Colony',
            'Pickup Hospital',
            'Hospital Type',
            'Reason For IFT',
            'No Of Patient',
            'Patient Name',
            'Gender',
            'Patient Phone No',
            'Patient Age',
            'Patient District',
            'Patient Tehsil/Block',
            'Patient Address',
            'Patient Remarks',
            'Delivery In Ambulance',
            'Ayushman Card No (if Any)',
            'Drop District',
            'Drop Tehsil',
            'Drop City',
            'Dropoff Hospital',
            'Drop Location City/Village',
            'Hospital Type GOVT/Private',
            'Reason',
            'IPD No',
            'OPD No',
            'PCF Number',
            'Paid Amount (In Case of Pvt Hospital)');

        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            foreach ($report_data as $row) {
                
                $dst_name = '';
                if($row['district_id'] != ''){
                    $incient_district = $this->inc_model->get_district_by_id($row['district_id']);
                    $dst_name = $incient_district->dst_name;
                }

                if($row['amb_district'] != ''){
                    $amb_district = $this->inc_model->get_district_by_id($row['amb_district']);
                    $amb_dist = $amb_district->dst_name;
                }

                $amb_type_id1 = $this->inc_model->get_amb_type($row['amb_reg_id']);
               
                $amb_type_id = $amb_type_id1->amb_type;
                if($amb_type_id =='1')
                {
                    $amb_type= 'JE';
                }
                elseif($amb_type_id =='2')
                {
                    $amb_type= 'BLS'; 
                }
                else{
                    $amb_type= 'ALS';
                }
                /*if ($row['rec_hospital_name'] == '0') {
                    $hos_name = 'On scene care';
                } else 
                */
                if ($row['rec_hospital_name'] == 'Other' || $row['rec_hospital_name'] == '0' || $row['rec_hospital_name'] == '') {
                    $hos_name = 'Other';
                    $hos_code = '';
                } else if ($row['rec_hospital_name'] == 'on_scene_care'){
                    $hos_name = 'On Scene Care';
                    $hos_code = '';
                } else if ($row['rec_hospital_name'] == 'at_scene_care'){
                    $hos_name = 'At Scene Care';
                    $hos_code = '';
                }else {
                    $hos_name = $row['hp_name'];
                    $hos_code = $row['hp_code'];
                } 

                if($row['ptn_gender']=='M')
                {
                    $gender='Male';
                }else if($row['ptn_gender']=='F'){
                    $gender='Female';
                }else if($row['ptn_gender']=='O'){
                    $gender='Transgender';
                }else{
                    $gender='-';
                }
             
                  $hp_dst_name = "";
               
                if($row['hp_district'] != '' && $row['hp_district'] != 0 && $row['hp_district'] != NULL){
                    $incient_district = $this->inc_model->get_district_by_id($row['hp_district']);
                    $hp_dst_name = $incient_district->dst_name;
                }
                $b12_name = '';
                
                
                if($row['is_validate'] == 1){
                    $is_validate = "Validation Done";
                }else{
                    $is_validate = "Validation Pending";
                }
              
                $inc_date = date("d-m-Y H:i:s", strtotime($row['inc_datetime']));
                $date = date("d-m-Y", strtotime($row['date']));
                
                if($row['epcr_call_type'] == '' || $row['epcr_call_type'] == NULL){                  
                    if($row['patient_ava_or_not'] == 'yes'){
                        $epcr_call_type = '2';
                    }else if($row['patient_ava_or_not']  == 'no'){
                        $epcr_call_type = '1';
                    }else if($row['patient_ava_or_not']  == '' && $row['patient_ava_or_not']  == NULL){
                        $epcr_call_type = '3';
                    }               
                }else{
                    $epcr_call_type = $row['epcr_call_type'] ;
                }
                $patinent_availability_status = "-";
                if($epcr_call_type != ''){
                    $call_type = $this->pcr_model->get_calltype_epcr(array('id' => $epcr_call_type));
                    $patinent_availability_status = $call_type[0]->call_type;
                }
                
                $inc_data[] = array(
                    'inc_datetime' => $inc_date,
                    'inc_date' => $row['added_date'],
                    'inc_purpose' => $row['pname'],
                    'inc_ref_id' => $row['incident_id'],
                    'amb_rto_register_no' => $row['amb_reg_id'],
                    'amb_type' => $amb_type,
                    'amb_district' => $amb_dist,
                    'patient_id' => $row['ptn_id'],
                    'patient_name' => $row['ptn_fname']." ".$row['ptn_lname'],
                    'caller_name' => $row['clr_fname']." ".$row['clr_lname'],
                    'caller_mobile' => $row['clr_mobile'],
                    'ptn_age' => $row['ptn_age']." ".$row['ptn_age_type'],
                    'ptn_gender' => $gender,
                    'district' => $dst_name,
                    'locality' => $row['inc_address'],
                    'inc_area_type'=>$row['inc_area_type'],
                    'emt_id' => $row['emso_id'],
                    'emt_name' => $row['emt_name'],
                    'pilot_id' => $row['pilot_id'],
                    'pilot_name' => $row['pilot_name'],
                    'level_type' => $row['level_type'],
                    'provier_img' => $row['pro_name'],
                    'other_provider_img' => $row['other_provider_img'],
                    'hos_district' => $hp_dst_name,
                    'base_location' => $hos_name,
                    'hospital_code' =>$hos_code,
                    'other_receiving_hos' => $row['other_receiving_host'],
                    'amb_base_location' => $row['inc_base_location_name'],
                   // 'wrd_location' => $row['inc_ward_name'],
                    'start_odo' => $row['start_odometer'],
                    'end_odo' => $row['end_odometer'],
                    'total_km' => $row['total_km'],
                  //  'thirdparty_name' => $row['thirdparty_name'],
                    'remark' => $row['remark'],
                    'patinent_availability_status'=>$patinent_availability_status,
                    'dco_id' => get_clg_name_by_ref_id($row['operate_by']),
                    'ero_id' => get_clg_name_by_ref_id($row['inc_added_by']),
                    'b12_type'=>$row['b12_type'],
                    'validation_done'=>$row['validate_by'],
                    'is_validate'=>$is_validate,
                    'valid_remark'=>$row['valid_remark'],
                    'validate_date'=>$row['validate_date'],
                    'amb_dis'=>$row['amb_dis'],
                    'inc_recive_time'=> $row['inc_recive_time'],
                    'inc_datetime'=> $row['inc_datetime'],
                    'inc_dispatch_time'=> $row['inc_dispatch_time'],
                    // 'ero_name'=> $row['ero_name'],
                    // 'ero_name'=> 'test',
                    'inc_added_by'=> $row['inc_added_by'],
                    'inc_pcr_status'=> $row['inc_pcr_status'],
                    'inc_lat'=> $row['inc_lat'],
                    'inc_long'=> $row['inc_long'],
                    'inc_district_id'=> $row['inc_district_id'],
                    'inc_tahsil_id'=> $row['inc_tahshil_id'],
                    'clg_first_name'=> $row['clg_first_name'],
                    'clg_mid_name'=> $row['clg_mid_name'],
                    'clg_last_name'=> $row['clg_last_name'],
                    'inc_address'=> $row['inc_address'],
                    'amb_gps_lat'=> $row['gps_amb_lat'],
                    'amb_gps_long'=> $row['gps_amb_log'],
                    'scene_odometer'=> $row['scene_odo'],
                    'dp_started_base_loc'=> $row['dp_started_base_loc'],
                    'dp_back_to_loc'=> $row['dp_back_to_loc'],
                    'inc_patient_cnt'=> $row['inc_patient_cnt'],
                    'ptn_district'=> $row['ptn_district'],
                    'ptn_tahsil'=> $row['ptn_tahsil'],
                    'drop_district'=> $row['drop_district'],
                    'drop_home_address'=> $row['drop_home_address'],
                    'ptn_mob_no'=> $row['ptn_mob_no'],
                    'hospital_odometer'=> $row['hospital_odometer'],
                    'ayushman_id'=> $row['ayushman_id'],
                    'dp_reach_on_scene_km'=> $row['dp_reach_on_scene_km'],
                    'dp_reach_on_scene'=> $row['dp_reach_on_scene'],
                    'dp_back_to_loc_km'=> $row['dp_back_to_loc_km'],
                    'dp_back_to_loc'=> $row['dp_back_to_loc'],
                    'dp_hosp_time'=> $row['dp_hosp_time'],
                    'dp_hosp_time_km'=> $row['dp_hosp_time_km'],
                    'end_odometer'=> $row['end_odometer'],
                    'pat_com_to_hosp_reason'=> $row['pat_com_to_hosp_reason'],
                    'hospital_name'=> $row['hospital_name'],
                    'hospital_type'=> $row['hospital_type'],
                    'opd_no_txt'=> $row['opd_no_txt'],
                    'inc_back_home_address'=> $row['inc_back_home_address'],
                    'dp_operated_by'=> $row['dp_operated_by'],
                    'remark'=> $row['remark'],
                    'inc_district_id'=> $row['inc_district_id'],
                    'inc_complaint'=> $row['inc_complaint'],
                );
                // print_r($inc_data);die();
            }

            
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'closure_dco_report';

            $this->output->add_to_position($this->load->view('frontend/erc_reports/nhm_mis_table', $data, TRUE), 'list_table', TRUE);
        } else {
           // var_dump($report_data);die();
            $filename = "nhm_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            $count=1;
            foreach ($report_data as $row) {
               
                
                $dst_name = '';
                if($row['district_id'] != ''){
                    $incient_district = $this->inc_model->get_district_by_id($row['district_id']);
                    $dst_name = $incient_district->dst_name;
                }
                
                $amb_dist = '';
                if($row['amb_district'] != ''){
                    $amb_district = $this->inc_model->get_district_by_id($row['amb_district']);
                    $amb_dist = $amb_district->dst_name;
                }

                $amb_type_id1 = $this->inc_model->get_amb_type($row['amb_reg_id']);
               
                $amb_type_id = $amb_type_id1->amb_type;
                if($amb_type_id =='1')
                {
                    $amb_type= 'JE';
                }
                elseif($amb_type_id =='2')
                {
                    $amb_type= 'BLS'; 
                }
                else{
                    $amb_type= 'ALS';
                }
              
                if ($row['rec_hospital_name'] == 'Other' || $row['rec_hospital_name'] == '0' || $row['rec_hospital_name'] == '') {
                    $hos_name = 'Other';
                    $hos_code = '';
                } else if ($row['rec_hospital_name'] == 'on_scene_care'){
                    $hos_name = 'On Scene Care';
                    $hos_code = '';
                } else if ($row['rec_hospital_name'] == 'at_scene_care'){
                    $hos_name = 'At Scene Care';
                    $hos_code = '';
                }else {
                    $hos_name = $row['hp_name'];
                    $hos_code = $row['hp_code'];
                } 

                if($row['ptn_gender']=='M')
                {
                    $gender='Male';
                }else if($row['ptn_gender']=='F'){
                    $gender='Female';
                }else if($row['ptn_gender']=='O'){
                    $gender='Transgender';
                }else{
                    $gender='-';
                }
                if($row['inc_datetime'] != NULL){
                    $add_date = date('Y-m-d', strtotime($row['inc_datetime']));
                    $add_time = date('H:i:s', strtotime($row['inc_datetime']));
                    $final_date= $add_date.' '.$add_time;
                   
                }
                else{
                    $final_date= '';
                }
                $hp_dst_name = "";
                if($row['hp_district'] != '' && $row['hp_district'] != 0 && $row['hp_district'] != NULL){
                    $incient_district = $this->inc_model->get_district_by_id($row['hp_district']);
                    $hp_dst_name = $incient_district->dst_name;
                }
                $date = date("d-m-Y", strtotime($row['date']));
                 if($row['is_validate'] == 1){
                    $is_validate = "Validation Done";
                }else{
                    $is_validate = "Validation Pending";
                }
                if($row['epcr_call_type'] == '' || $row['epcr_call_type'] == NULL){                  
                    if($row['patient_ava_or_not'] == 'yes'){
                        $epcr_call_type = '2';
                    }else if($row['patient_ava_or_not']  == 'no'){
                        $epcr_call_type = '1';
                    }else if($row['patient_ava_or_not']  == '' && $row['patient_ava_or_not']  == NULL){
                        $epcr_call_type = '3';
                    }               
                }else{
                    $epcr_call_type = $row['epcr_call_type'] ;
                }
                $patinent_availability_status = "-";
                if($epcr_call_type != ''){
                    $call_type = $this->pcr_model->get_calltype_epcr(array('id' => $epcr_call_type));
                    $patinent_availability_status = $call_type[0]->call_type;
                }
                $inc_data = array(
                    'sr_no'=> $count,
                    'inc_datetime' => $inc_date,
                    'inc_date' => $row['added_date'],
                    'inc_purpose' => $row['pname'],
                    'inc_ref_id' => $row['incident_id'],
                    'amb_rto_register_no' => $row['amb_reg_id'],
                    'amb_type' => $amb_type,
                    'amb_district' => $amb_dist,
                    'patient_id' => $row['ptn_id'],
                    'patient_name' => $row['ptn_fname']." ".$row['ptn_lname'],
                    'caller_name' => $row['clr_fname']." ".$row['clr_lname'],
                    'caller_mobile' => $row['clr_mobile'],
                    'ptn_age' => $row['ptn_age']." ".$row['ptn_age_type'],
                    'ptn_gender' => $gender,
                    'district' => $dst_name,
                    'locality' => $row['inc_address'],
                    'inc_area_type'=>$row['inc_area_type'],
                    'emt_id' => $row['emso_id'],
                    'emt_name' => $row['emt_name'],
                    'pilot_id' => $row['pilot_id'],
                    'pilot_name' => $row['pilot_name'],
                    'level_type' => $row['level_type'],
                    'provier_img' => $row['pro_name'],
                    'other_provider_img' => $row['other_provider_img'],
                    'hos_district' => $hp_dst_name,
                    'base_location' => $hos_name,
                    'hospital_code' =>$hos_code,
                    'other_receiving_hos' => $row['other_receiving_host'],
                    'amb_base_location' => $row['inc_base_location_name'],
                   // 'wrd_location' => $row['inc_ward_name'],
                    'start_odo' => $row['start_odometer'],
                    'end_odo' => $row['end_odometer'],
                    'total_km' => $row['total_km'],
                  //  'thirdparty_name' => $row['thirdparty_name'],
                    'remark' => $row['remark'],
                    'patinent_availability_status'=>$patinent_availability_status,
                    'dco_id' => get_clg_name_by_ref_id($row['operate_by']),
                    'ero_id' => get_clg_name_by_ref_id($row['inc_added_by']),
                    'b12_type'=>$row['b12_type'],
                    'validation_done'=>$row['validate_by'],
                    'is_validate'=>$is_validate,
                    'valid_remark'=>$row['valid_remark'],
                    'validate_date'=>$row['validate_date'],
                    'amb_dis'=>$row['amb_dis'],
                    'inc_recive_time'=> $row['inc_recive_time'],
                    'inc_datetime'=> $row['inc_datetime'],
                    'inc_dispatch_time'=> $row['inc_dispatch_time'],
                    // 'ero_name'=> $row['ero_name'],
                    // 'ero_name'=> 'test',
                    'inc_added_by'=> $row['inc_added_by'],
                    'inc_pcr_status'=> $row['inc_pcr_status'],
                    'inc_lat'=> $row['inc_lat'],
                    'inc_long'=> $row['inc_long'],
                    'inc_district_id'=> $row['inc_district_id'],
                    'inc_tahsil_id'=> $row['inc_tahshil_id'],
                    'clg_first_name'=> $row['clg_first_name'],
                    'clg_mid_name'=> $row['clg_mid_name'],
                    'clg_last_name'=> $row['clg_last_name'],
                    'inc_address'=> $row['inc_address'],
                    'amb_gps_lat'=> $row['gps_amb_lat'],
                    'amb_gps_long'=> $row['gps_amb_log'],
                    'scene_odometer'=> $row['scene_odo'],
                    'dp_started_base_loc'=> $row['dp_started_base_loc'],
                    'dp_back_to_loc'=> $row['dp_back_to_loc'],
                    'inc_patient_cnt'=> $row['inc_patient_cnt'],
                    'ptn_district'=> $row['ptn_district'],
                    'ptn_tahsil'=> $row['ptn_tahsil'],
                    'drop_district'=> $row['drop_district'],
                    'drop_home_address'=> $row['drop_home_address'],
                    'ptn_mob_no'=> $row['ptn_mob_no'],
                    'hospital_odometer'=> $row['hospital_odometer'],
                    'ayushman_id'=> $row['ayushman_id'],
                    'dp_reach_on_scene_km'=> $row['dp_reach_on_scene_km'],
                    'dp_reach_on_scene'=> $row['dp_reach_on_scene'],
                    'dp_back_to_loc_km'=> $row['dp_back_to_loc_km'],
                    'dp_back_to_loc'=> $row['dp_back_to_loc'],
                    'dp_hosp_time'=> $row['dp_hosp_time'],
                    'dp_hosp_time_km'=> $row['dp_hosp_time_km'],
                    'end_odometer'=> $row['end_odometer'],
                    'pat_com_to_hosp_reason'=> $row['pat_com_to_hosp_reason'],
                    'hospital_name'=> $row['hospital_name'],
                    'hospital_type'=> $row['hospital_type'],
                    'opd_no_txt'=> $row['opd_no_txt'],
                    'inc_back_home_address'=> $row['inc_back_home_address'],
                    'dp_operated_by'=> $row['dp_operated_by'],
                    'remark'=> $row['remark'],
                    'inc_district_id'=> $row['inc_district_id'],
                    'inc_complaint'=> $row['inc_complaint'],    
                );

                fputcsv($fp, $inc_data);
                $count++;
            }
            fclose($fp);
            exit;
        }
    }
    
    function unavailed_closure_dco_report() {

        $post_reports = $this->input->post();
        
        $track_args = array('trk_report_name'=>'Unavailed Closure Report','trk_download_by'=>$this->clg->clg_ref_id);
        track_report_download($track_args);

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month']);
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month']);
        }
        $report_args['system']=$post_reports['system'];


        $report_data = $this->inc_model->get_unavailed_epcr_by_month($report_args);
        //var_dump($report_data);
      // die();

      $header = array('Sr.No',
          'Incident ID',
            'Incident Date /Time',
            'Closure Date / Time',
            'Ambulance No',
            'Base Location',
            'Patient ID',
            'Patient Name',
            'Age',
            'Gender',
            'District',
            'Address',
            'Inc. Area Type',
            'LOC',
            'EMT',
            'PILOT',
            'Provider Impression',
            'Provider Impression Other',
            'Receiving Hospital Name',
            'Other-Receiving Hospital',
            'Previous Odometer',
            'Start Odometer',
            'Scene Odometer',
            'Hospital Odometer',
            'End Odometer',
            'Total Distance Travel',
            'Call Receiving Date / Time',
            'Disconnected Date / Time',
            'Start From Base Date / Time',
            'At Scene',
            'From Scene',
            'At Hospital',
            'Handover Time',
            'Back To Base',
            'Response Time',
            'Response Time Remark',
            'Odometer Difference Remark',
            'Remark',
            'DCO ID'
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

                $driver_data = $this->pcr_model->get_driver(array('dp_pcr_id' => $row['epcr_id']));

                $base_loc_time = $call_recived_date . ' ' . $driver_data[0]->dp_started_base_loc;

                $time1 = $driver_data[0]->dp_reach_on_scene;

                $time2 = $driver_data[0]->dp_started_base_loc;

                $time1 = explode(' ', $time1);
                $time2 = explode(' ', $time2);
                
                $time1 = new DateTime(date('Y-m-d H:i:s', strtotime( $driver_data[0]->dp_reach_on_scene)));
                $time2 = new DateTime(date('Y-m-d H:i:s', strtotime($driver_data[0]->dp_started_base_loc)));
                

                
//                $minutes1 = ($array1[0] * 60 + $array1[1]);
//                $minutes2 = ($array2[0] * 60 + $array2[1]);

                //$diff = $minutes1 - $minutes2;
               // $diff = date_diff($time2, $time1);
               // $resonse_time = '';


                if ($driver_data[0]->dp_started_base_loc != '00:00:00') {

                    $base_loc_time = new DateTime(date('Y-m-d H:i:s', strtotime($base_loc_time)));
                    $inc_datetime = new DateTime(date('Y-m-d H:i:s', strtotime($row['inc_date'])));
                    $resonse_time = date_diff($base_loc_time, $inc_datetime);
                    $resonse_time = $resonse_time->h . ':' . $resonse_time->i . ':' . $resonse_time->s;
                }
//                if ($diff > 0) {
//                    $resonse_time = $diff . ' Minutes';
//                } else {
//                    $resonse_time = '0 Minutes';
//                }

                $amb_arg = array('rg_no' => $row['amb_reg_id']);
                $amb_data = $this->amb_model->get_amb_data($amb_arg);
                $amb_base_location = $amb_data[0]->hp_name;


                //  $resonse_time = '';   
                // var_dump($resonse_time);
                if ($row['rec_hospital_name'] == '0') {
                    $hp_name = 'Other';
                } else if ($row['rec_hospital_name'] == 'Other') {
                    $hp_name = 'Other';
                } else {
                    $hp_name = $row['rec_hospital_name'];
                }
                $responce_time= '';
                $end_odometer_remark= '';
//                if($_SERVER['REMOTE_ADDR'] == '157.47.20.53'){
//                    var_dump($driver_data);
//                }
                
               // var_dump($driver_data[0]->responce_time_remark);
                 if($driver_data[0]->responce_time_remark != ""){
                    $responce_time=get_responce_time_remark($driver_data[0]->responce_time_remark);
                }
                if($row['end_odometer_remark'] != ""){
                    $end_odometer_remark=get_end_odo_remark($row['end_odometer_remark']);
                }
                if($row['ptn_gender'] == 'F'){
                    $gender1="Female";
                }else if($row['ptn_gender'] == 'M'){
                    $gender1="Male";
                }else{
                    $gender1="Transgender";
                }

                if ($row['start_from_base'] != '' && $row['start_from_base'] != '0000-00-00 00:00:00'){
                    $start_base = date('Y-m-d H:i:s', strtotime($row['start_from_base']));
                }else{
                    $start_base = '';
                }  
                if ($row['start_from_base'] != '' && $row['start_from_base'] != '0000-00-00 00:00:00'){
                    $start_base = date('Y-m-d H:i:s', strtotime($row['start_from_base']));
                }else{
                    $start_base = '';
                }  
                if ($row['dp_on_scene'] != '' && $row['dp_on_scene'] != '0000-00-00 00:00:00'){
                    $dp_on_scene = date('Y-m-d H:i:s', strtotime($row['dp_on_scene']));
                }else{
                    $dp_on_scene = '';
                }  
                if ($row['dp_reach_on_scene'] != '' && $row['dp_reach_on_scene'] != '0000-00-00 00:00:00'){
                    $dp_reach_on_scene = date('Y-m-d H:i:s', strtotime($row['dp_reach_on_scene']));
                }else{
                    $dp_reach_on_scene = '';
                }  
                if ($row['dp_hosp_time'] != '' && $row['dp_hosp_time'] != '0000-00-00 00:00:00'){
                    $dp_hosp_time = date('Y-m-d H:i:s', strtotime($row['dp_hosp_time']));
                }else{
                    $dp_hosp_time = '';
                }  
                if ($row['dp_hand_time'] != '' && $row['dp_hand_time'] != '0000-00-00 00:00:00'){
                    $dp_hand_time = date('Y-m-d H:i:s', strtotime($row['dp_hand_time']));
                }else{
                    $dp_hand_time = '';
                }  
                if ($row['dp_back_to_loc'] != '' && $row['dp_back_to_loc'] != '0000-00-00 00:00:00'){
                    $dp_back_to_loc = date('Y-m-d H:i:s', strtotime($row['dp_back_to_loc']));
                }else{
                    $dp_back_to_loc = '';
                } 
                $dp_cl_from_desk= date("Y-m-d H:i:s", strtotime($row['inc_recive_time']));
                $duration = date('H:i:s', strtotime($row['responce_time']));
                $inc_datetime= date("Y-m-d H:i:s", strtotime($row['inc_datetime']));
                $inc_data[] = array(
                   
                    'inc_datetime' => $row['inc_date_time'],
                    'inc_date' => $row['dp_date'],
                    'inc_ref_id' => $row['inc_ref_id'],
                    'response_time' => $resonse_time,
                    'amb_rto_register_no' => $row['amb_reg_id'],
                    'ptn_id' => $row['ptn_id'],
                    'patient_name' => ucwords(strtolower($row['ptn_fname']." ".$row['ptn_lname'])),
                    'ptn_age' => $row['ptn_age'],
                    'ptn_gender' =>  $gender1,
                    'district' => $dst_name,
                    'cty_name' => $cty_name,
                    'locality' => $row['inc_address'],
                    'inc_area_type' => $row['inc_area_type'],
                    'level_type' => $row['level_type'],
                    'emso' => $row['emt_name'],
                    'pilot' => $row['pilot_name'],
                    'provier_img' => $row['pro_name'],
                    'other_provider_img' => $row['other_provider_img'],
                    'base_location' => $hp_name,
                    'other_receiving_host' => $row['other_receiving_host'],
                    'amb_base_location' => $amb_base_location,
                    'operate_by' => $row['operate_by'],
                    'start_odo' => $row['start_odometer'],
                    'scene_odometer' => $row['scene_odo'],
                    'hospital_odometer' => $row['hospital_odo'],
                    'end_odo' => $row['end_odometer'],
                    'total_km' => $row['total_km'],
                    'dp_cl_from_desk' => $dp_cl_from_desk,
                    'disconnectted time' => $inc_datetime,
                    'start_from_base' => $start_base ,
                    'dp_on_scene' => $dp_on_scene,
                    'dp_reach_on_scene' => $dp_reach_on_scene,
                    'dp_hosp_time' => $dp_hosp_time,
                    'dp_hand_time' => $dp_hand_time,
                    'dp_back_to_loc' => $dp_back_to_loc,
                    'responce_time' => $duration,
                    'responce_time_remark' => $responce_time,
                    'odo_remark' => $end_odometer_remark,
                    'remark' =>  ucfirst(strtolower($row['remark'])),
                    'dco_id' => strtoupper($row['operate_by'])
                );
            }


            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
           // var_dump($inc_data);die;

            $this->output->add_to_position($this->load->view('frontend/erc_reports/inc_una_closure_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "unavail_call_closure_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            $count=1;
            foreach ($report_data as $row) {

                $incient_district = $this->inc_model->get_district_by_id($row['district_id']);
                $dst_name = $incient_district->dst_name;

                $city_id = $this->inc_model->get_city_by_id($row['city_id'], $row['district_id']);
                $cty_name = $city_id->cty_name;


                $transport_respond_amb_no = $row['amb_rto_register_no'];


                $call_recived_date = date('Y-m-d', strtotime($row['inc_date']));
                $inc_time = explode(" ", $row['inc_date']);
                $driver_data = $this->pcr_model->get_driver(array('dp_pcr_id' => $row['epcr_id']));



                $amb_arg = array('rg_no' => $row['amb_reg_id']);
                $amb_data = $this->amb_model->get_amb_data($amb_arg);
                $amb_base_location = $amb_data[0]->hp_name;

                if ($row['rec_hospital_name'] == '0') {
                    $hp_name = 'Other';
                } else if ($row['rec_hospital_name'] == 'Other') {
                    $hp_name = 'Other';
                } else {
                    $hp_name = $row['rec_hospital_name'];
                }
                if($row['inc_date_time'] != NULL){
                    $add_date = date('Y-m-d', strtotime($row['inc_date_time']));
                     $add_time = date('H:i:s', strtotime($row['inc_date_time']));
                     $final_date= $add_date.' '.$add_time;
                    // $text = substr($f_date,0,10);
                     //var_dump($text);
                    // $text = strtolower($text);
                    // $text = str_replace('-', ' ', $text);
                     //$final_date = str_replace('-', ' ', $text);
                                 }
                                 else{
                                     $final_date= '';
                                 }
                                 if($row['dp_date'] != NULL){
                    $add_date = date('Y-m-d', strtotime($row['dp_date']));
                     $add_time = date('H:i:s', strtotime($row['dp_date']));
                     $final_date1= $add_date.' '.$add_time;
                    // $final_date1 = str_replace('--', ' ', $f_date);
                                 }
                                 else{
                                     $final_date1= '';
                                 }

                $responce_time= '';
                $end_odometer_remark= '';
                if($driver_data[0]->responce_time_remark != ""){
                    $responce_time=get_responce_time_remark($driver_data[0]->responce_time_remark);
                }
                if($row['end_odometer_remark'] != ""){
                    $end_odometer_remark=get_end_odo_remark($row['end_odometer_remark']);
                }
                if($row['ptn_gender'] == 'F'){
                    $gender1="Female";
                }else if($row['ptn_gender'] == 'M'){
                    $gender1="Male";
                }else{
                    $gender1="Transgender";
                }
                if ($row['start_from_base'] != '' && $row['start_from_base'] != '0000-00-00 00:00:00'){
                    $start_base = date('Y-m-d H:i:s', strtotime($row['start_from_base']));
                }else{
                    $start_base = '';
                }  
                if ($row['start_from_base'] != '' && $row['start_from_base'] != '0000-00-00 00:00:00'){
                    $start_base = date('Y-m-d H:i:s', strtotime($row['start_from_base']));
                }else{
                    $start_base = '';
                }  
                if ($row['dp_on_scene'] != '' && $row['dp_on_scene'] != '0000-00-00 00:00:00'){
                    $dp_on_scene = date('Y-m-d H:i:s', strtotime($row['dp_on_scene']));
                }else{
                    $dp_on_scene = '';
                }  
                if ($row['dp_reach_on_scene'] != '' && $row['dp_reach_on_scene'] != '0000-00-00 00:00:00'){
                    $dp_reach_on_scene = date('Y-m-d H:i:s', strtotime($row['dp_reach_on_scene']));
                }else{
                    $dp_reach_on_scene = '';
                }  
                if ($row['dp_hosp_time'] != '' && $row['dp_hosp_time'] != '0000-00-00 00:00:00'){
                    $dp_hosp_time = date('Y-m-d H:i:s', strtotime($row['dp_hosp_time']));
                }else{
                    $dp_hosp_time = '';
                }  
                if ($row['dp_hand_time'] != '' && $row['dp_hand_time'] != '0000-00-00 00:00:00'){
                    $dp_hand_time = date('Y-m-d H:i:s', strtotime($row['dp_hand_time']));
                }else{
                    $dp_hand_time = '';
                }  
                if ($row['dp_back_to_loc'] != '' && $row['dp_back_to_loc'] != '0000-00-00 00:00:00'){
                    $dp_back_to_loc = date('Y-m-d H:i:s', strtotime($row['dp_back_to_loc']));
                }else{
                    $dp_back_to_loc = '';
                } 
				$inc_datetime= date("Y-m-d H:i:s", strtotime($row['inc_datetime']));
				$dp_cl_from_desk= date("Y-m-d H:i:s", strtotime($row['inc_recive_time']));
				 $duration = date('H:i:s', strtotime($row['responce_time'])); 
                $inc_data = array(
                    'sr_no' => $count,
                    'inc_ref_id' => $row['inc_ref_id'],
                    'inc_date' => $final_date,
                    'inc_date1' => $final_date1,
                    'amb_rto_register_no' => $row['amb_reg_id'],
                    'amb_base_location' => $amb_base_location,
                    'ptn_id'=>$row['ptn_id'],
                    'patient_name' => ucwords(strtolower($row['ptn_fname']." ".$row['ptn_lname'])),
                    'ptn_age' => $row['ptn_age'],
                    'ptn_gender' => $gender1,
                    'district' => $dst_name,
                    'locality' => $row['inc_address'],
                    'inc_area_type'=>$row['inc_area_type'],
                    'level_type' => $row['level_type'],
                    'emso' => $row['emt_name'],
                    'pilot' => $row['pilot_name'],
                    'provier_img' => $row['pro_name'],
                    'other_provider_img' => $row['other_provider_img'],
                    'base_location' => $hp_name,
                    'other_receiving_host' => $row['other_receiving_host'],
                    'start_odo' => $row['start_odometer'],
                    'start_odo1' => $row['start_odometer'],
                    'scene_odometer' => $row['scene_odo'],
                    'hospital_odometer' => $row['hospital_odo'],
                    'end_odo' => $row['end_odometer'],
                    'total_km' => $row['total_km'],
                    'dp_cl_from_desk' => $dp_cl_from_desk,
                    'disconnectted time' => $inc_datetime,
                    'start_from_base' => $start_base ,
                    'dp_on_scene' => $dp_on_scene,
                    'dp_reach_on_scene' => $dp_reach_on_scene,
                    'dp_hosp_time' => $dp_hosp_time,
                    'dp_hand_time' => $dp_hand_time,
                    'dp_back_to_loc' => $dp_back_to_loc,
                    'responce_time' => $duration,
                    'responce_time_remark' => $responce_time,
                    'odo_remark' => $end_odometer_remark,
                    'remark' => ucfirst(strtolower($row['remark'])),
                    'dco_id' => strtoupper($row['operate_by'])
                );

                fputcsv($fp, $inc_data);
                $count++;
            }
            fclose($fp);
            exit;
        }
    }

    function closure_response_time_report() {

        $post_reports = $this->input->post();
        
        $track_args = array('trk_report_name'=>'Response Time Report Incident datewise','trk_download_by'=>$this->clg->clg_ref_id);
        track_report_download($track_args);

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;
        $thirdparty = $this->clg->thirdparty;
        $district = $this->clg->clg_district_id;
        $clg_district_id = json_decode($district);
        if(is_array($clg_district_id)){
            $district_id = implode("','",$clg_district_id);
        }

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        
       if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
                //'thirdparty' => $thirdparty,
                //'system' => $post_reports['system'],
                //'clg_district_id' => $district_id 
            );
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                //'thirdparty' => $thirdparty,
                //'system' => $post_reports['system'],
               // 'clg_district_id' => $district_id 
            );
        }
        $report_args['system'] = $post_reports['system'];


        $report_data = $this->inc_model->get_closure_responce_report($report_args);



        $header = array('Sr.No',
        'Incident ID',
        'Incident Date /Time',
        'Closure Date / Time',
        'Ambulance No',
        'Base Location',
        'Type',
        'Patient ID',
        'Patient Name',
        'Call Receiving Date / Time',
        'Disconnected Date / Time',
        'Start From Base Date / Time',
        'At Scene',
        'From Scene',
        'At Hospital',
        'Handover Time',
        'Back To Base',
        'Response Time',
        'Response Time Remark',
        'Odometer Difference Remark',    
        'Inc. Area Type',
        'Third Party',
        'Operate by',
        'Operate by Name',
        'Added by',
        'Added by Name',
        'Validate By',
        'Validate By Name'
        );

        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            foreach ($report_data as $row) {

//                var_dump($row);
                $incient_district = $this->inc_model->get_district_by_id($row['district_id']);
                $dst_name = $incient_district->dst_name;

                $city_id = $this->inc_model->get_city_by_id($row['city_id'], $row['district_id']);
                $cty_name = $city_id->cty_name;


                $transport_respond_amb_no = $row['amb_rto_register_no'];


                $amb_arg = array('rg_no' => $row['amb_reg_id']);
               // $amb_data = $this->amb_model->get_amb_data($amb_arg);
               // $amb_base_location = $amb_data[0]->hp_name;



                if ($row['rec_hospital_name'] == 'Other' || $row['rec_hospital_name'] == '0' || $row['rec_hospital_name'] == '') {
                    $hp_name = 'Other';
                } else if ($row['rec_hospital_name'] == 'on_scene_care'){
                    $hp_name = 'On Scene Care';
                } else if ($row['rec_hospital_name'] == 'at_scene_care'){
                    $hp_name = 'At Scene Care';
                }else {
                    $hp_name = $row['hp_name'];
                } 
                $end_odometer_remark = '';
                if($row['end_odometer_remark'] != ""){
                    $end_odometer_remark=get_end_odo_remark($row['end_odometer_remark']);
                }
                
                
                $response_time_remark ='';
                if( $row['responce_time_remark'] != ''){
                    $response_time_remark = get_responce_time_remark($row['responce_time_remark']);
                }
                $clg_name_data =array();
                $epcr_operate_by_Name = "";
                if($row['epcr_clg_first_name'] == '' && $row['epcr_clg_last_name'] == '' ){
                    $epcr_operate_by_Name='';
                    $myArray = array();
                    $myArray = explode(',', $row['operate_by']);
                    
                    foreach($myArray as $clg_id1){
                        if($clg_id1 != ''){
                          $clg_data = get_clg_data_by_ref_id_response($clg_id1);
                          if(!empty( $clg_data)){
                             $clg_name_data[]=$clg_data[0]->clg_first_name.' '.$clg_data[0]->clg_last_name;
                          }
                        }
                    }
                    $epcr_operate_by_Name = implode(",",$clg_name_data);
                    //$epcr_operate_by_Name = '';
                }else
                {
                    $epcr_operate_by_Name = ucwords($row['epcr_clg_first_name'])." ".ucwords($row['epcr_clg_last_name']);
                }    
                $inc_data[] = array(
                    'inc_date' => $row['inc_date_time'],
                    'closer_date' => $row['added_date'],
                    'inc_ref_id' => $row['incident_id'],
                    'response_time' => $row['responce_time'],
                    'amb_rto_register_no' => $row['amb_reg_id'],
                    'base_location_name'=>$row['base_location_name'],
                    'ambt_name'=>$row['ambt_name'],
                    'ptn_id' => $row['ptn_id'],
                    'patient_name' => strtoupper($row['ptn_fname'])." ".strtoupper($row['ptn_lname']),
                    'ptn_age' => $row['ptn_age'],
                    'ptn_gender' => $row['ptn_gender'],
                    'district' => $dst_name,
                    'cty_name' => $cty_name,
                    'locality' => $row['locality'],
                    'level_type' => $row['level_type'],
                    'inc_area_type' => $row['inc_area_type'],
                    'provier_img' => $row['pro_name'],
                    'base_location' => $hp_name,
                    'amb_base_location' => $row['base_location_name'],
                    'operate_by' => $row['operate_by'],
                    'start_odo' => $row['start_odometer'],
                    'end_odo' => $row['end_odometer'],
                    'remark' => $response_time_remark,
                    'total_km' => $row['total_km'],
                    'dp_started_base_loc' => $row['dp_started_base_loc'],
                    'dp_on_scene' => $row['dp_on_scene'],
                    'dp_hosp_time' => $row['dp_hosp_time'],
                    'start_from_base' => $row['start_from_base'],
                    'responce_time' => $row['responce_time'],
                    'remark_title' => $row['remark_title'],
                    'dp_hand_time' => $row['dp_hand_time'],
                    'dp_back_to_loc' => $row['dp_back_to_loc'],
                    'dp_cl_from_desk' => $row['dp_cl_from_desk'],
                    'dp_reach_on_scene' => $row['dp_reach_on_scene'],
                    'inc_datetime'=>$row['inc_datetime'],
                    'odo_remark'=> $end_odometer_remark,
                    'inc_recive_time'=>$row['inc_recive_time'],
                    'thirdparty'=> $row['thirdparty_name'],
                    'inc_added_by' => $row['inc_added_by'],
                    'amb_area_name' => $row['ar_name'],
                    'inc_added_by_Name' => ucwords($row['inc_clg_first_name'])." ".ucwords($row['inc_clg_last_name']),
                    'epcr_operate_by_Name' => $epcr_operate_by_Name,
                    'epcr_validate_by_Name' => ucwords($row['epcr_validate_clg_first_name'])." ".ucwords($row['epcr_validate_clg_last_name']),
                    'validate_by' => $row['validate_by'],
                    
                );
                $epcr_operate_by_Name='';      
            }

           
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'closure_response_time_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/inc_response_time_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
           // var_dump($report_data);die();
            $filename = "closure_response_time_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            $count=1;
            foreach ($report_data as $row) {
                $epcr_operate_by_Name='';
                
                
                $incient_district = $this->inc_model->get_district_by_id($row['district_id']);
                $dst_name = $incient_district->dst_name;

                $city_id = $this->inc_model->get_city_by_id($row['city_id'], $row['district_id']);
                $cty_name = $city_id->cty_name;


                $transport_respond_amb_no = $row['amb_rto_register_no'];


                $amb_arg = array('rg_no' => $row['amb_reg_id']);
               // $amb_data = $this->amb_model->get_amb_data($amb_arg);
               // $amb_base_location = $amb_data[0]->hp_name;


                //  $resonse_time = '';   
                // var_dump($resonse_time);
               /* if ($row['rec_hospital_name'] == '0') {
                    $hp_name = 'Other';
                } else if ($row['rec_hospital_name'] == 'Other') {
                    $hp_name = 'Other';
                } else {
                    $hp_name = $row['hp_name'];
                } */
                if ($row['rec_hospital_name'] == 'Other' || $row['rec_hospital_name'] == '0' || $row['rec_hospital_name'] == '') {
                    $hp_name = 'Other';
                } else if ($row['rec_hospital_name'] == 'on_scene_care'){
                    $hp_name = 'On Scene Care';
                } else if ($row['rec_hospital_name'] == 'at_scene_care'){
                    $hp_name = 'At Scene Care';
                }else {
                    $hp_name = $row['hp_name'];
                } 
               $dp_cl_from_desk= date("Y-m-d H:i:s", strtotime($row['inc_recive_time']));
               $inc_datetime= date("Y-m-d H:i:s", strtotime($row['inc_datetime']));
              
               if($row['inc_date_time'] != NULL){
                $add_date = date('Y-m-d', strtotime($row['inc_date_time']));
                 $add_time = date('H:i:s', strtotime($row['inc_date_time']));
                 $final_date= $add_date.'-'.$add_time;
                             }
                             else{
                                 $final_date= '';
                             }
                 
                 if($row['closure_datetime'] != NULL){
                $add_date = date('Y-m-d', strtotime($row['closure_datetime']));
                 $add_time = date('H:i:s', strtotime($row['closure_datetime']));
                 $clousre_date= $add_date.'-'.$add_time;
                             }
                             else{
                                 $clousre_date= '';
                             }  
                
                             $duration = date('H:i:s', strtotime($row['responce_time']));
                             $start_base = date('Y-m-d H:i:s', strtotime($row['start_from_base']));
                             
                $end_odometer_remark = '';
                if($row['end_odometer_remark'] != ""){
                    $end_odometer_remark=get_end_odo_remark($row['end_odometer_remark']);
                }
                
                $response_time_remark ='';
                if( $row['responce_time_remark'] != ''){
                    $response_time_remark = get_responce_time_remark($row['responce_time_remark']);
                }
                
                 $clg_name_data =array();
                $epcr_operate_by_Name = "";
                if($row['epcr_clg_first_name'] == '' && $row['epcr_clg_last_name'] == '' ){
                    $epcr_operate_by_Name='';
                    $myArray = array();
                    $myArray = explode(',', $row['operate_by']);
                    
                    foreach($myArray as $clg_id1){
                        if($clg_id1 != ''){
                          $clg_data = get_clg_data_by_ref_id_response($clg_id1);
                          if(!empty( $clg_data)){
                             $clg_name_data[]=$clg_data[0]->clg_first_name.' '.$clg_data[0]->clg_last_name;
                          }
                        }
                    }
                    $epcr_operate_by_Name = implode(",",$clg_name_data);
                    //$epcr_operate_by_Name = '';
                }else
                {
                    $epcr_operate_by_Name = ucwords($row['epcr_clg_first_name'])." ".ucwords($row['epcr_clg_last_name']);
                } 
                if ($row['start_from_base'] != '' && $row['start_from_base'] != '0000-00-00 00:00:00'){
                    $start_base = date('Y-m-d H:i:s', strtotime($row['start_from_base']));
                }else{
                    $start_base = '';
                }  
                if ($row['start_from_base'] != '' && $row['start_from_base'] != '0000-00-00 00:00:00'){
                    $start_base = date('Y-m-d H:i:s', strtotime($row['start_from_base']));
                }else{
                    $start_base = '';
                }  
                if ($row['dp_on_scene'] != '' && $row['dp_on_scene'] != '0000-00-00 00:00:00'){
                    $dp_on_scene = date('Y-m-d H:i:s', strtotime($row['dp_on_scene']));
                }else{
                    $dp_on_scene = '';
                }  
                if ($row['dp_reach_on_scene'] != '' && $row['dp_reach_on_scene'] != '0000-00-00 00:00:00'){
                    $dp_reach_on_scene = date('Y-m-d H:i:s', strtotime($row['dp_reach_on_scene']));
                }else{
                    $dp_reach_on_scene = '';
                }  
                if ($row['dp_hosp_time'] != '' && $row['dp_hosp_time'] != '0000-00-00 00:00:00'){
                    $dp_hosp_time = date('Y-m-d H:i:s', strtotime($row['dp_hosp_time']));
                }else{
                    $dp_hosp_time = '';
                }  
                if ($row['dp_hand_time'] != '' && $row['dp_hand_time'] != '0000-00-00 00:00:00'){
                    $dp_hand_time = date('Y-m-d H:i:s', strtotime($row['dp_hand_time']));
                }else{
                    $dp_hand_time = '';
                }  
                if ($row['dp_back_to_loc'] != '' && $row['dp_back_to_loc'] != '0000-00-00 00:00:00'){
                    $dp_back_to_loc = date('Y-m-d H:i:s', strtotime($row['dp_back_to_loc']));
                }else{
                    $dp_back_to_loc = '';
                }  
               $inc_data = array(
                    'sr_no' => $count,
                    'inc_ref_id' => $row['inc_ref_id'],
                    'inc_date' => $final_date,
                    'closer_date' => $row['added_date'],
                    'amb_rto_register_no' => $row['amb_reg_id'],
                    'amb_base_location' => $row['base_location_name'],
                    'ambt_name'=>$row['ambt_name'],
                    'patient_id' => $row['ptn_id'],
                    'patient_name' => strtoupper($row['ptn_fname'])." ".strtoupper($row['ptn_lname']),
                    'dp_cl_from_desk' => $dp_cl_from_desk,
                    'disconnectted time' => $inc_datetime,
                    'start_from_base' => $start_base ,
                    'dp_on_scene' => $dp_on_scene,
                    'dp_reach_on_scene' => $dp_reach_on_scene,
                    'dp_hosp_time' => $dp_hosp_time,
                    'dp_hand_time' => $dp_hand_time,
                    'dp_back_to_loc' => $dp_back_to_loc,
                    'responce_time' => $duration,
                    'remark_title' => $response_time_remark,
                    'odo_remark'=>$end_odometer_remark,
                    'inc_area_type' => strtoupper($row['ar_name']),
                    'thirdparty' => $row['thirdparty_name'],
                    'operate_by' => strtoupper($row['operate_by']),
                    'epcr_operate_by_Name' => $epcr_operate_by_Name,
                    'added_by' => strtoupper($row['inc_added_by']),
                    'inc_added_by_Name' => ucwords($row['inc_clg_first_name'])." ".ucwords($row['inc_clg_last_name']),
                    'validate_by' => strtoupper($row['validate_by']),
                    'epcr_validate_by_Name' => ucwords($row['epcr_validate_clg_first_name'])." ".ucwords($row['epcr_validate_clg_last_name']),
                    
                );

                fputcsv($fp, $inc_data);
                $count++;
            }
            fclose($fp);
            exit;
        }
    }
    function closure_consumable_report_new(){
        $track_args = array('trk_report_name'=>'Consumable Report','trk_download_by'=>$this->clg->clg_ref_id);
        track_report_download($track_args);
        $post_reports = $this->input->post();
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
                'thirdparty' => $thirdparty,
                'system' => $post_reports['system'],
                'clg_district_id' => $district_id );
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                'thirdparty' => $thirdparty,
                'system' => $post_reports['system'],
                'clg_district_id' => $district_id );
        }
        $report_args['system']=$post_reports['system'];
        $report_data = $this->inc_model->get_consumable_data_new($report_args);
      //  var_dump($report_data);die();
        $header = array('Ambulance No',
            'Type[Consumable/Nonconsumable/Medicaine]',
            'Item Name',
            'Quantity',
            'Added Date'
        );
        if ($post_reports['reports'] == 'view') {
            foreach ($report_data as $row) {

//                if($row['as_item_type'] == 'CA'){
//                    $amb_stock=get_inv_stock_by_id($amb_args);
//                }elseif($row['as_item_type'] == 'NCA'){
//                    $amb_stock=get_inv_stock_by_id($amb_args);
//                }elseif($row['as_item_type'] == 'MED'){
//                    $amb_stock=get_inv_stock_by_id($amb_args);
//                }
             
                $inc_data[] = array(
                    'amb_rto_register_no' => $row['amb_rto_register_no'],
                    'as_item_type' => $row['as_item_type'],
                    'as_item_id' => $row['as_item_id'],
                    'as_item_qty' => $row['as_item_qty'],
                    'as_date'=> $row['as_date'],
                 );
            } 
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            
            $this->output->add_to_position($this->load->view('frontend/erc_reports/inc_consumable_report_view_new', $data, TRUE), 'list_table', TRUE);
        }else{
            $filename = "closure_consumable_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            foreach ($report_data as $row) {
                
                   $args = array('inv_type'=>$row['as_item_type'],'inv_id'=>$row['as_item_id']);
            $item_name = get_inv_name_by_id($args);
                $inc_data = array(
                    'amb_rto_register_no' => $row['amb_rto_register_no'],
                    'as_item_type' => $row['as_item_type'],
                    'as_item_id' => $item_name,
                    'as_item_qty' => $row['as_item_qty'],
                    'as_date' => $row['as_date']
                );

                fputcsv($fp, $inc_data);
            }
            fclose($fp);
            exit;
        }
    }
    function closure_consumable_report() {

        $post_reports = $this->input->post();
        
           $track_args = array('trk_report_name'=>'Consumable Report','trk_download_by'=>$this->clg->clg_ref_id);
        track_report_download($track_args);

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;
        $thirdparty = $this->clg->thirdparty;
        $district = $this->clg->clg_district_id;
        $clg_district_id = json_decode($district);
        if(is_array($clg_district_id)){
            $district_id = implode("','",$clg_district_id);
        }
        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
                'thirdparty' => $thirdparty,
                'system' => $post_reports['system'],
                'clg_district_id' => $district_id );
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                'thirdparty' => $thirdparty,
                'system' => $post_reports['system'],
                'clg_district_id' => $district_id );
        }
        $report_args['system']=$post_reports['system'];


        $report_data = $this->inc_model->get_epcr_by_month($report_args);


        $header = array('Incident ID',
            'Incident Date /Time',
            'Closure Date / Time',
            'Ambulance No',
            'Base Location',
            'District',
            'Patient ID',
            'Patient Name',
            'Provider Impression',
            'Consumable-Quantity',
            'Unit',
            'Non-Consumable - Quantity',
            'Non-Unit',
            'Medicine-Quantity',
            'Third Party',
            'Operate by'
        );

        if ($post_reports['reports'] == 'view') {

            //$inc_data = array();
            foreach ($report_data as $row) {
                
                
               //var_dump($report_data);die;
                $cons_args = array(
                    'as_sub_id' => $row['epcr_id'],
                    'as_item_type' => 'CA',
                );
                $consumable_data = $this->inc_model->get_consumable_data($cons_args);
                // var_dump($consumable_data);die;

                $cons_args = array(
                    'as_sub_id' => $row['epcr_id'],
                    'as_item_type' => 'NCA',
                );
                $non_consumable_data = $this->inc_model->get_consumable_data($cons_args);
               // var_dump($non_consumable_data);die;
                $cons_args = array(
                    'as_sub_id' => $row['epcr_id'],
                    'as_item_type' => 'MED',
                );
                $med_consumable_data = $this->inc_model->get_consumable_data($cons_args);
                //var_dump($med_consumable_data);die;  



                $incient_district = $this->inc_model->get_district_by_id($row['district_id']);
                $dst_name = $incient_district->dst_name;

                $city_id = $this->inc_model->get_city_by_id($row['city_id'], $row['district_id']);
                $cty_name = $city_id->cty_name;


                $transport_respond_amb_no = $row['amb_rto_register_no'];

                $amb_arg = array('rg_no' => $row['amb_reg_id']);
                $amb_data = $this->amb_model->get_amb_data($amb_arg);
                $amb_base_location = $amb_data[0]->hp_name;

                if ($row['rec_hospital_name'] == 'Other' || $row['rec_hospital_name'] == '0' || $row['rec_hospital_name'] == '') {
                    $hp_name = 'Other';
                } else if ($row['rec_hospital_name'] == 'on_scene_care'){
                    $hp_name = 'On Scene Care';
                } else if ($row['rec_hospital_name'] == 'at_scene_care'){
                    $hp_name = 'At Scene Care';
                }else {
                    $hp_name = $row['hp_name'];
                } 
                if($row['third_party'] == '1') { $thirdparty = 'BVG'; }
                elseif($row['third_party'] == '2'){ $thirdparty = 'Private'; } 
                elseif($row['third_party'] == '3'){ $thirdparty = 'PCMC'; } 
                elseif($row['third_party'] == '4'){ $thirdparty = 'PMC'; } 
                else{ $thirdparty = ''; }
                  if($row['inc_date_time'] != NULL){
                    $add_date = date('Y-m-d', strtotime($row['inc_date_time']));
                     $add_time = date('H:i:s', strtotime($row['inc_date_time']));
                     $final_date= $add_date.'-'.$add_time;
                                 }
                                 else{
                                     $final_date= '';
                                 }
                                 
                $inc_data[] = array(
                    'inc_ref_id' => $row['inc_ref_id'],
                    'inc_date' => $final_date,
                    'closer_date' => $row['date'],
                    'amb_rto_register_no' => $row['amb_reg_id'],
                    'dst_name' => $row['dst_name'],
                    'baselocation' => $row['baselocation'],
                    'ptn_id' => $row['ptn_id'],
                    'patient_name' => $row['ptn_fname'].' '.$row['ptn_lname'],
                    'provier_img' => $row['pro_name'],
                    'consumable_quantity' => $consumable_data[0]['count'],
                    'other_units' => $row['other_units'],
                    'non_consumable_quantity' => $non_consumable_data[0]['count'],
                    'other_non_units' => $row['other_non_units'],
                    'medicine_quantity' => $med_consumable_data[0]['count'],
                    'thirdparty' => $thirdparty,
                    'operate_by' => ucwords($row['operate_by']),
                );
            }


            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/inc_consumable_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "closure_consumable_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            foreach ($report_data as $row) {
                $cons_args = array(
                    'as_sub_id' => $row['epcr_id'],
                    'as_item_type' => 'CA',
                );
                $consumable_data = $this->inc_model->get_consumable_data($cons_args);


                $cons_args = array(
                    'as_sub_id' => $row['epcr_id'],
                    'as_item_type' => 'NCA',
                );
                $non_consumable_data = $this->inc_model->get_consumable_data($cons_args);

                $cons_args = array(
                    'as_sub_id' => $row['epcr_id'],
                    'as_item_type' => 'MED',
                );
                $med_consumable_data = $this->inc_model->get_consumable_data($cons_args);




                $incient_district = $this->inc_model->get_district_by_id($row['district_id']);
                $dst_name = $incient_district->dst_name;

                $city_id = $this->inc_model->get_city_by_id($row['city_id'], $row['district_id']);
                $cty_name = $city_id->cty_name;


                $transport_respond_amb_no = $row['amb_rto_register_no'];

                $amb_arg = array('rg_no' => $row['amb_reg_id']);
                $amb_data = $this->amb_model->get_amb_data($amb_arg);
                $amb_base_location = $amb_data[0]->hp_name;

               /* if ($row['rec_hospital_name'] == '0') {
                    $hp_name = 'On scene care';
                } else if ($row['rec_hospital_name'] == 'Other') {
                    $hp_name = 'Other';
                } else {
                    $hp_name = $row['hp_name'];
                }*/
                if ($row['rec_hospital_name'] == 'Other' || $row['rec_hospital_name'] == '0' || $row['rec_hospital_name'] == '') {
                    $hp_name = 'Other';
                } else if ($row['rec_hospital_name'] == 'on_scene_care'){
                    $hp_name = 'On Scene Care';
                } else if ($row['rec_hospital_name'] == 'at_scene_care'){
                    $hp_name = 'At Scene Care';
                }else {
                    $hp_name = $row['hp_name'];
                } 
                if($row['third_party'] == '1') { $thirdparty = 'BVG'; }
                elseif($row['third_party'] == '2'){ $thirdparty = 'Private'; } 
                elseif($row['third_party'] == '3'){ $thirdparty = 'PCMC'; } 
                elseif($row['third_party'] == '4'){ $thirdparty = 'PMC'; } 
                else{ $thirdparty = ''; }
                if($row['inc_date_time'] != NULL){
                    $add_date = date('Y-m-d', strtotime($row['inc_date_time']));
                     $add_time = date('H:i:s', strtotime($row['inc_date_time']));
                     $final_date= $add_date.'-'.$add_time;
                                 }
                                 else{
                                     $final_date= '';
                                 }
                
                 if($row['dp_date'] != NULL){
                    $add_date = date('Y-m-d', strtotime($row['dp_date']));
                     $add_time = date('H:i:s', strtotime($row['dp_date']));
                     $clousre_date= $add_date.'-'.$add_time;
                                 }
                                 else{
                                     $clousre_date= '';
                                 }

                $inc_data = array(
                    'inc_ref_id' => $row['inc_ref_id'],
                    'inc_date' => $final_date,
                    'closer_date' => $clousre_date,
                    'amb_rto_register_no' => $row['amb_reg_id'],
                    'baselocation' => $row['baselocation'],
                    'dst_name'=> $row['dst_name'],
                    'ptn_id' => $row['ptn_id'],
                    'patient_name' => $row['ptn_fname'].' '.$row['ptn_lname'],
                    'provier_img' => $row['pro_name'],
                    'consumable_quantity' => $consumable_data[0]['count'],
                    'other_units' => $row['other_units'],
                    'non_consumable_quantity' => $non_consumable_data[0]['count'],
                    'other_non_units' => $row['other_non_units'],
                    'medicine_quantity' => $med_consumable_data[0]['count'],
                    'thirdparty' => $thirdparty,
                    'operate_by' => ucwords($row['operate_by']),
                );

                fputcsv($fp, $inc_data);
            }
            fclose($fp);
            exit;
        }
    }
    //Shift Roster Report
    function shift_roster_report_view()
    {
        //var_dump('hii');die();
        $post_reports = $this->input->post();
        
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $base_month = $this->common_model->get_base_month($from_date);
        $base_month =$base_month[0]->months;

        if ($post_reports['to_date'] != '') {

            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $base_month
              );
              
        } else if($post_reports['to_date'] != '' && $post_reports['from_date'] != '') {

            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $base_month
               );
            
        }else{

            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $base_month
                );
        }
        
        if($post_reports['time'] != '' ){
            if($post_reports['time'] == '1'){
                $to_time = "00:00:00";
                $from_time = "01:00:00";
            }else if($post_reports['time'] == '2'){
                $to_time = "01:00:01";
                $from_time = "02:00:00";
            }else if($post_reports['time'] == '3'){
                $to_time = "02:00:01";
                $from_time = "03:00:00";
            }else if($post_reports['time'] == '4'){
                $to_time = "03:00:01";
                $from_time = "04:00:00";
            }else if($post_reports['time'] == '5'){
                $to_time = "04:00:01";
                $from_time = "05:00:00";
            }else if($post_reports['time'] == '6'){
                $to_time = "05:00:01";
                $from_time = "06:00:00";
            }else if($post_reports['time'] == '7'){
                $to_time = "06:00:01";
                $from_time = "07:00:00";
            }else if($post_reports['time'] == '8'){
                $to_time = "07:00:01";
                $from_time = "08:00:00";
            }else if($post_reports['time'] == '9'){
                $to_time = "08:00:01";
                $from_time = "09:00:00";
            }else if($post_reports['time'] == '10'){
                $to_time = "09:00:01";
                $from_time = "10:00:00";
            }else if($post_reports['time'] == '11'){
                $to_time = "10:00:01";
                $from_time = "11:00:00";
            }else if($post_reports['time'] == '12'){
                $to_time = "11:00:01";
                $from_time = "12:00:00";
            }else if($post_reports['time'] == '13'){
                $to_time = "12:00:01";
                $from_time = "13:00:00";
            }else if($post_reports['time'] == '14'){
                $to_time = "13:00:01";
                $from_time = "14:00:00";
            }else if($post_reports['time'] == '15'){
                $to_time = "14:00:01";
                $from_time = "15:00:00";
            }else if($post_reports['time'] == '16'){
                $to_time = "15:00:01";
                $from_time = "16:00:00";
            }else if($post_reports['time'] == '17'){
                $to_time = "16:00:01";
                $from_time = "17:00:00";
            }else if($post_reports['time'] == '18'){
                $to_time = "17:00:01";
                $from_time = "18:00:00";
            }else if($post_reports['time'] == '19'){
                $to_time = "18:00:01";
                $from_time = "19:00:00";
            }else if($post_reports['time'] == '20'){
                $to_time = "19:00:01";
                $from_time = "20:00:00";
            }else if($post_reports['time'] == '21'){
                $to_time = "21:00:01";
                $from_time = "22:00:00";
            }else if($post_reports['time'] == '22'){
                $to_time = "22:00:01";
                $from_time = "23:00:00";
            }else if($post_reports['time'] == '23'){
                $to_time = "23:00:01";
                $from_time = "23:59:59";
            }
            $from_date = $post_reports['from_date']." ".$to_time;
            $to_date = $post_reports['from_date']." ".$from_time;
            
               $report_args = array('from_datetime' => date('Y-m-d H:i:s', strtotime($from_date)),
                'to_datetime' => date('Y-m-d H:i:s', strtotime($to_date)),
                'time'=>$post_reports['time'],
                'base_month' => $base_month
                );
                $report_args['from_date'] = $post_reports['from_date'];
        }


        $incident_data = $this->ambmain_model->get_incident_data($report_args);
        $EM=array('NON_MCI','AD_SUP_REQ','DROP_BACK','IN_HO_P_TR','MCI','EMT_MED_AD','PREGANCY_CALL','VIP_CALL','Child_CARE_CALL','on_scene_care','PICK_UP');
        $Non_EM=array('ABUSED_CALL','APP_CALL','AMB_NOT_AVA','CHILD_CALL','DEMO_CALL','DISS_CON_CALL','DUP_CALL','AMB_TO_ERC','ENQ_CALL','ESCALATION_CALL','FOLL_CALL','GEN_ENQ','MISS_CALL','NO_RES_CALL','NUS_CALL','SERVICE_NOT_REQUIRED','SLI_CALL','SUGG_CALL','TEST_CALL','UNATT_CALL','WRONG_CALL','TRANS_CALL_108','CALL_TRANS_102');
        $trans_call = array('TRANS_PDA','TRANS_FDA');
        if($incident_data){
            $emergency=0;
            $non_emergency=0;
            $transcall = 0;
            $total_calls = 0;
            foreach ($incident_data as $report) 
            {
                
                $user_id = strtolower($report->inc_added_by);
                $roaster_data[$user_id]['brk_resonse_time'] =0;
                $roaster_data[$user_id]['user_id'] = $user_id;
                $quality_args = array(
                    'base_month' =>$base_month,
                    'user_type' => 'ERO',
                   // 'from_date' =>  date('Y-m-d', strtotime($from_date)), 
                   // 'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                    'qa_ad_user_ref_id' => $user_id);
                
                if($post_reports['time'] != '' ){
                    $quality_args['from_datetime']= date('Y-m-d', strtotime($post_reports['from_date'])).' '.$to_time;
                    $quality_args['to_datetime']= date('Y-m-d', strtotime($post_reports['from_date'])).' '.$from_time;
                }else{
                     $quality_args['from_date'] = date('Y-m-d', strtotime($from_date));
                    $quality_args['to_date'] = date('Y-m-d', strtotime($post_reports['to_date']));
                }
              
                    //Audit score
                $audit_details = $this->quality_model->get_quality_audit($quality_args);
                $fetal_count = 0;
                $quality_score =0;
                foreach ($audit_details as $audit) 
                {
                    $quality_score = $quality_score +  $audit->quality_score;
                    if($audit->quality_score == 0)
                    {
                         $fetal_count = $fetal_count+1; 
                        
                    }
                 }
                $roaster_data[$user_id]['quality_score'] = $quality_score;
                $roaster_data[$user_id]['quality_count'] = count($audit_details);
                $roaster_data[$user_id]['fetal_count'] = $fetal_count;
                $break_info = $this->ambmain_model->get_break_details($quality_args);

              //var_dump($break_info);
                $total_brk_time =$break_info[0]->brk_total;

                $brk_hours   = floor($total_brk_time / 3600);
                $brk_minutes = $total_brk_time / 60 % 60;
                $brk_seconds = $total_brk_time % 60;
                
                $hours   = str_pad( $brk_hours,   2, '0', STR_PAD_LEFT);
                $minutes = str_pad( $brk_minutes, 2, '0', STR_PAD_LEFT);
                $seconds = str_pad( $brk_seconds, 2, '0', STR_PAD_LEFT);
                $brk_time = $hours.':'.$minutes.':'.$seconds;
                //$roaster_data[$user_id]['brk_resonse_time'] = $resonse_time;
                $roaster_data[$user_id]['brk_resonse_time'] = $brk_time;
                
                $login_info = $this->ambmain_model->get_login_details($quality_args);
                $total_time=$login_info[0]->login_total;

                $hours   = floor($total_time / 3600);
                $minutes = $total_time / 60 % 60;
                $seconds = $total_time % 60;
                $hours   = str_pad( $hours,   2, '0', STR_PAD_LEFT);
                $minutes = str_pad( $minutes, 2, '0', STR_PAD_LEFT);
                $seconds = str_pad( $seconds, 2, '0', STR_PAD_LEFT);
                $resonse_time = $hours.':'.$minutes.':'.$seconds;
                $roaster_data[$user_id]['total_time'] = $resonse_time;
                
                
               if (isset($report->inc_added_by))
                {
                    if(!in_array(strtolower($report->inc_added_by), (array) $roaster_data[$user_id]['user_id'])) 
                    {
                       // $roaster_data[$report->inc_added_by]['user_id'] = $report->inc_added_by;
                        if (in_array($report->inc_type, $EM))
                        {
                            
                            $roaster_data[$user_id]['Emergency'] = $roaster_data[$user_id]['Emergency']+1;
                            
                        }
                        
                        if(in_array($report->inc_type, $Non_EM)){
                            
                            $roaster_data[$user_id]['Non_Emergency'] = $roaster_data[$user_id]['Non_Emergency']+1;
                       }
                       if(in_array($report->inc_type, $trans_call)){
                            
                        $roaster_data[$user_id]['Transfer_call'] = $roaster_data[$user_id]['Transfer_call']+1;
                   }
                     
                       $roaster_data[$user_id]['total_count'] = $roaster_data[$user_id]['total_count']+1;
                        
                    }else{
                        $roaster_data[$user_id]['user_id'] = strtolower($report->inc_added_by);
                        if (in_array($report->inc_type, $EM)){
                            $roaster_data[$user_id]['Emergency'] = $roaster_data[$user_id]['Emergency']+1;
                            
                        }
                        
                        if(in_array($report->inc_type, $Non_EM)){
                            $roaster_data[$user_id]['Non_Emergency'] = $roaster_data[$user_id]['Non_Emergency']+1;
                       }

                       if(in_array($report->inc_type, $trans_call)){
                        $roaster_data[$user_id]['Transfer_call'] = $roaster_data[$user_id]['Transfer_call']+1;
                   }
                     
                       $roaster_data[$user_id]['total_count'] = $roaster_data[$user_id]['total_count']+1;
                    }
                    
                }   
            }
            
            
        }
      // var_dump($roaster_data);die();
        $header = array('Sr.No','ERO Name','Avaya ID','EM Calls','Non EM Calls','Transfer Call To FDA/PDA' ,'Total Calls', 'Dispatch Count', 'Quality Score','Fatal Count','Login Hours','Break');
        $main_file_name = strtotime($post_reports['from_date']);
        $filename = "shiftroster_" . $main_file_name . ".csv";
        $this->output->set_focus_to = "inc_ref_id";
        if ($post_reports['reports'] == 'view') {
            
            
            $data['header'] = $header;
            $data['shift_roster'] = $roaster_data;
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'shift_roster_report_view';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/shift_roster_report_view', $data, TRUE),'list_table', TRUE);
            
        }else {
            //var_dump($roaster_data);die();
            $filename = "shift_roster_report.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $count = 1;
            $total_quality_score = 0;
            
            foreach ($roaster_data as $row) {
               // var_dump($row['clg_avaya_id']);die();
                
                $clg_data=get_clg_data_by_ref_id($row['user_id']);
                
                $total_eme = $total_eme+$row['Emergency'];
                $total_eme_non = $total_eme_non + $row['Non_Emergency'];
                $total_trans = $total_trans + $row['Transfer_call'];
                $total_calls =  $total_calls + $row['total_count'];
                $fetal_count = $fetal_count+$row['fetal_count'];
                
                if($row['quality_count'] > 0) { 
                    $score_quality =  $row['quality_score']/$row['quality_count']; 
                    $total_quality_score = $total_quality_score + $score_quality;
                }else{
                    $score_quality = 0;
                }
                sscanf($row['total_time'], "%d:%d:%d", $hours, $minutes, $seconds);

                $login_time_seconds = isset($hours) ? $hours * 3600 + $minutes * 60 + $seconds : $minutes * 60 + $seconds;
        $login_time_seconds_total = $login_time_seconds +$login_time_seconds_total;
        
          
        sscanf($row['brk_resonse_time'], "%d:%d:%d", $b_hours, $b_minutes, $b_seconds);

        $break_time_seconds = isset($b_hours) ? $b_hours * 3600 + $b_minutes * 60 + $b_seconds : $b_minutes * 60 + $b_seconds;
        $break_time_seconds_total = $break_time_seconds_total+$break_time_seconds;
              $clg_name=ucwords($clg_data[0]->clg_first_name." ".$clg_data[0]->clg_last_name);  
                $data = array(
                    'Sr.No' => $count,
                    'user_id' => $clg_name,
                    'Avaya ID' => $clg_data[0]->clg_avaya_id,
                    'EM Calls' => $row['Emergency']?$row['Emergency']:0,
                    'Non EM Calls' => $row['Non_Emergency']?$row['Non_Emergency']:0,
                    'Transfer Calls' => $row['Transfer_call']?$row['Transfer_call']:0,
                    'Total Calls' => $row['total_count']?$row['total_count']:0,
                    'Disptach Count' => $row['Emergency']?$row['Emergency']:0,
                    'Quality Score' => $score_quality.'%',
                    'fetal_count' => $row['fetal_count'],
                    'Login Hours' => $row['total_time'],
                    'Break' => $row['brk_resonse_time']
                );
                fputcsv($fp,$data);
                $count++;
            }
                     $login_hours   = floor($login_time_seconds_total / 3600);
                $login_minutes = $login_time_seconds_total / 60 % 60;
                $login_seconds = $login_time_seconds_total % 60;
                $hours   = str_pad( $login_hours,   2, '0', STR_PAD_LEFT);
                $minutes = str_pad( $login_minutes, 2, '0', STR_PAD_LEFT);
                $seconds = str_pad( $login_seconds, 2, '0', STR_PAD_LEFT);
                $resonse_time = $hours.':'.$minutes.':'.$seconds;
                
                $break_hours   = floor($break_time_seconds_total / 3600);
                $break_minutes = $break_time_seconds_total / 60 % 60;
                $break_seconds = $break_time_seconds_total % 60;
                $hours_b   = str_pad( $break_hours,   2, '0', STR_PAD_LEFT);
                $minutes_b = str_pad( $break_minutes, 2, '0', STR_PAD_LEFT);
                $seconds_b = str_pad( $break_seconds, 2, '0', STR_PAD_LEFT);
                $break_resonse_time = $hours_b.':'.$minutes_b.':'.$seconds_b;
                //echo $break_resonse_time;
                
            $total = array('','','Total', $total_eme,$total_eme_non,$total_trans,$total_calls,$total_eme,$total_quality_score,$fetal_count,$resonse_time,$break_resonse_time);
            fputcsv($fp, $total);

            fclose($fp);
            exit;
        }
        if($post_reports['flt'] == 'reset'){
            $data=array();
            $data['submit_function'] = "load_shift_roster_sub_option_report_form";
            $data['title'] = "Shift Roaster Report";
            
            $this->output->add_to_position($this->load->view('frontend/reports/export_shiftroster_daily_reports_view', $data, TRUE), 'popup_div', TRUE);
           // $data['submit_function'] = "view_quality_master_report";
            //$data['sm'] = $this->colleagues_model->get_all_shiftmanager();
            //$data['purpose_calls'] = $this->call_model->get_all_child_purpose_of_calls();

            //$this->output->add_to_position($this->load->view('frontend/quality/quality_filter_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_date_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
    }
    //Ambulance maintenance report
    
    function ambulance_maintenance_report()
    {
         $post_reports = $this->input->post();
        //var_dump($post_reports);die();
        $maintenance_type = $this->input->post('maintenance_type');
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;
        
        if ($post_reports['to_date'] != '') {

            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],'maintenance_type' => $maintenance_type);
        } else {

            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],'maintenance_type' => $maintenance_type);
        }
        $report_data = $this->ambmain_model->get_maintenance_report($report_args);
    
        $header = array('Sr.No','District','Ambulance No','Base Location','Request date','Approval date','Closer  date','Estimate Cost','Informed to','Pilot Name','Pilot Id','Shift Type','Work Shop Name','Current Odometer','Expected On-Road Date/Time','Scheduled Service','Service name','Off Date and Time','Standard Remark', 'Remark', 'Approval','On-Road Date/Time','Remark','Approved Estimate amount','Repairing time','Approved Workshop', 'Bill No.','Cost of Spare Parts','Labour Cost','Total Amount','End Odometer','On Road Date/Time','Standard Remark','Remark');

        $main_file_name = strtotime($post_reports['from_date']);
        $filename = "maintenance_" . $main_file_name . ".csv";
        $this->output->set_focus_to = "inc_ref_id";
        if ($post_reports['reports'] == 'view') {

            $data['header'] = $header;
            $data['maintenance_data'] = $report_data;
            $data['maintenance_type'] = $maintenance_type;
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'ambulance_maintenance_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/maintenance_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            //var_dump("hii");die();
            $filename = "ambulance_maintenance_report.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $count = 1;

            foreach ($report_data as $row) {
                
                    if($row->mt_type=='accidental'){
                        $main_type="Accidental Maintenance";
                    }
                    elseif($row->mt_type=='breakdown'){
                        $main_type="Breakdown Maintenance";
                    }
                    elseif($row->mt_type=='preventive'){
                        $main_type="Preventive Maintenance";
                    }
                    elseif($row->mt_type=='tyre'){
                        $main_type="Tyre Maintenance";
                    }
                    elseif($row->mt_type=='onroad_offroad'){
                        $main_type="Onroad/offroadMaintenance";
                    }
                    if($main_data->mt_district_id!= ' '){
                    $current_district = get_district_by_id($row->mt_district_id);
                    }
                    
                    $informed_to = json_decode($row->informed_to); 
                    if(is_array($informed_to)){
                        $informed = implode(',', $informed_to);
                    }
                    if($row->mt_shift_id != ''){ $shift_id = show_shift_type_by_id($row->mt_shift_id); } 
                    if($row->mt_work_shop != ''){ $work_shop = show_work_shop_by_id($row->mt_work_shop); }
                    
                    if($row->mt_approval == 0){ $mt_approval = "Approval Pending"; }else if($row->mt_approval == 1){ $mt_approval = "Approved"; }else if($row->mt_approval == 2){ $mt_approval = "Not Approve"; }
                    
                    $group_name = array();
                    if(is_array($informed_to)){
                       // echo implode(',', $informed_to);

                        foreach($informed_to as $inform){
                            $group_name[]=get_EMS_title($inform);
                        }

                    }
                    $inform_user = implode(',', $group_name);
        
                    $data = array(
                    'Sr.No' => $count,
                    'District' => $current_district,
                    'Ambulance No' => $row->mt_amb_no,
                    'Base_Location' => $row->mt_base_loc,  
                    'request_date' => $row->added_date,
                    'approval_date' => $row->approved_date,
                    'modify_date' => $row->modify_date, 
                    'mt_Estimatecost' => $row->mt_Estimatecost,
                    'informed' => $inform_user,
                    'mt_pilot_name' => $row->mt_pilot_name,
                    'mt_pilot_id' => $row->mt_pilot_id,
                    'shift_id'=>$shift_id,
                    'work_shop'=>$work_shop,
                    'mt_in_odometer'=> $row->mt_previos_odometer,
                    'mt_ex_onroad_datetime' =>$row->mt_ex_onroad_datetime,
                    'mt_schedule_service'=>$row->mt_schedule_service,
                    'mt_service_name'=>$row->mt_service_name,
                    'mt_offroad_datetime'=>$row->mt_offroad_datetime,
                    'mt_stnd_remark'=>$row->mt_stnd_remark,
                    'mt_remark'=>$row->mt_remark,
                    'mt_approval'=>$row->mt_ambulance_status,
                    'mt_onroad_datetime'=>$row->mt_onroad_datetime,
                    'mt_on_remark' => $row->mt_on_remark,
                    'mt_app_est_amt'=>$row->mt_app_est_amt,
                    'mt_app_rep_time'=>$row->mt_app_rep_time,
                    'mt_app_work_shop'=>$row->mt_app_work_shop, 
                    'bill_number'=>$row->bill_number,
                    'part_cost'=>$row->part_cost, 
                    'labour_cost'=>$row->labour_cost, 
                    'total_cost'=>$row->total_cost,
                    'mt_end_odometer'=>$row->mt_end_odometer, 
                    'mt_onroad_datetime'=>$row->mt_onroad_datetime, 
                    'mt_on_stnd_remark'=>$row->mt_on_stnd_remark,
                    'mt_on_remark'=>$row->mt_on_remark,
                );


                fputcsv($fp, $data);
                $count++;
            }

            fclose($fp);
            exit;
        }
    }
     function question_answer_incident_report(){
    $post_reports = $this->input->post();

        $thirdparty = $this->clg->thirdparty;
        $district = $this->clg->clg_district_id;
        $clg_district_id = json_decode($district);
        if(is_array($clg_district_id)){
            $district_id = implode("','",$clg_district_id);
        }

    $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

    $base_month = $this->common_model->get_base_month($from_date);
    $this->post['base_month'] = $base_month[0]->months;

    if ($post_reports['to_date'] != '') {

        $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
            'base_month' => $this->post['base_month'],
            'thirdparty' => $thirdparty,
            'clg_district_id' => $district_id );
    } else {

        $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
            'base_month' => $this->post['base_month'],
            'thirdparty' => $thirdparty,
            'clg_district_id' => $district_id );
    }

    $report_data = $this->inc_model->get_dispatch_inc_question_by_report($report_args);
    foreach($report_data as $report){
        $inc_args = array('inc_ref_id'=>$report->inc_ref_id);
        $report->inc_ques_data = $this->inc_model->get_inc_summary($inc_args);
        $inc_data[] = $report;
    }
    //var_dump($data);die();
    //$rp_data['questions'] = $report_data
       // $inc_data[] = $report;
    $data['inc_data']= $inc_data;
    $header = array('Sr.No', 'Incident Date/Time', 'Incident Id','Third Party','Question1','Question2','Question3','Question4','Question5','Question6','Question7','Question8',);


    $inc_file_name = strtotime($post_reports['from_date']);
    $filename = "incident_" . $inc_file_name . ".csv";
    if ($post_reports['reports'] == 'view') {

        $data['header'] = $header;
        $data['inc_data'] = $report_data;
        $data['report_args'] = $report_args;
        $data['submit_function'] = 'question_answer_incident_report';
        $this->output->add_to_position($this->load->view('frontend/erc_reports/inc_question_answer_report_view', $data, TRUE), 'list_table', TRUE);
    } else {

        $filename = "inc_question_answer_report_view.csv";
        $fp = fopen('php://output', 'w');
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        fputcsv($fp, $header);

        $count = 1;

        foreach ($report_data as $row) {
            if($row->inc_thirdparty == '1') { $thirdparty = 'BVG'; }
                        elseif($row->inc_thirdparty == '2'){ $thirdparty = 'Private'; } 
                        elseif($row->inc_thirdparty == '3'){ $thirdparty = 'PCMC'; } 
                        elseif($row->inc_thirdparty == '4'){ $thirdparty = 'PMC'; } 
                        else{ $thirdparty=''; }
             $data = array(
                'Sr.No' => $count,
                'inc_datetime' => $row->inc_datetime,
                'inc_ref_id' => $row->inc_ref_id,     
                'third_party' => $thirdparty,      
                //'question' => $ques
            );
            
            foreach($row->inc_ques_data as $key=>$question){
                 
                $ques = "";
                $ques .= $question->que_question; 
                $ques .= " : ";
                if($question->sum_que_ans == "Y" || $question->sum_que_ans == "y" ){
                    $ques .= "YES"; 
                    
                }else{ 
                    $ques .= "NO"; 
                    
                };
                $data['question'.$key] = $ques;
                
            }


            $thirdparty='';

            fputcsv($fp, $data);
            $count++;
        }

        fclose($fp);
        exit;
    }
   }
   function onroad_offroad_maintenance_report()
    {
         $post_reports = $this->input->post();
        //var_dump($post_reports);die();
        $maintenance_type = $this->input->post('maintenance_type');
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;
        
        if ($post_reports['to_date'] != '') {

            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],'maintenance_type' => $maintenance_type);
        } else {

            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],'maintenance_type' => $maintenance_type);
        }
        $report_data = $this->ambmain_model->get_maintenance_report($report_args);
    
        $header = array('Sr.No','State','District','Ambulance No','Base Location','Request date','Approval date','Closer date','Pilot Name','Pilot Id','Estimate Cost','Informed to','Current Odometer','Expected On-Road Date/Time','Standard Remark', 'Remark','Approve By','Approval Date and Time','Approval','On-Road Date/Time','End Odometer','Off-Road Date/Time','Standard Remark','Remark','Off Road Reason','Duration');

        $main_file_name = strtotime($post_reports['from_date']);
        $filename = "maintenance_" . $main_file_name . ".csv";
        $this->output->set_focus_to = "inc_ref_id";
        if ($post_reports['reports'] == 'view') {

            $data['header'] = $header;
            $data['maintenance_data'] = $report_data;
            $data['maintenance_type'] = $maintenance_type;
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'onroad_offroad_maintenance_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/maintenance_onroad_offroad_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            //var_dump("hii");die();
            $filename = "ambulance_maintenance_report.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $count = 1;

            foreach ($report_data as $row) {
                
                    if($row->mt_type=='accidental'){
                        $main_type="Accidental Maintenance";
                    }
                    elseif($row->mt_type=='breakdown'){
                        $main_type="Breakdown Maintenance";
                    }
                    elseif($row->mt_type=='preventive'){
                        $main_type="Preventive Maintenance";
                    }
                    elseif($row->mt_type=='tyre'){
                        $main_type="Tyre Maintenance";
                    }
                    elseif($row->mt_type=='onroad_offroad'){
                        $main_type="Onroad/offroadMaintenance";
                    }
                    if($row->mt_district_id!= ' '){
                    $current_district = get_district_by_id($row->mt_district_id);
                    }
                    
                    $informed_to = json_decode($row->informed_to); 
                    if(is_array($informed_to)){
                        $informed = implode(',', $informed_to);
                    }
                    if($row->mt_shift_id != ''){ $shift_id = show_shift_type_by_id($row->mt_shift_id); } 
                    if($row->mt_work_shop != ''){ $work_shop = show_work_shop_by_id($row->mt_work_shop); }
                    if($row->mt_approval == 0){ $mt_approval = "Approval Pending"; }else if($row->mt_approval == 1){ $mt_approval = "Approved"; }else if($row->mt_approval == 2){ $mt_approval = "Not Approve"; }
                     $group_name = array();
                    if(is_array($informed_to)){
                       // echo implode(',', $informed_to);

                        foreach($informed_to as $inform){
                            $group_name[]=get_EMS_title($inform);
                        }

                    }
                    $inform_user = implode(',', $group_name);
                    
                    
       if($row->mt_offroad_datetime != '0000-00-00 00:00:00'){
      
      $start_date = new DateTime(date('Y-m-d h:i:s',strtotime($row->mt_offroad_datetime)));                         
                               if($row->mt_onroad_datetime != '' && $row->mt_onroad_datetime != '1970-01-01 05:30:00' && $row->mt_onroad_datetime != '0000-00-00 00:00:00'){
                                    
                                     $end_date = new DateTime(date('Y-m-d h:i:s',strtotime($row->mt_onroad_datetime))); 
                                }else{
                                    $end_date = new DateTime(date('Y-m-d h:i:s')); 
                                }
                                $since_start = $start_date->diff($end_date);
                                $duration= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S';
                            
       }
       
                    $data = array(
                    'Sr.No' => $count,
                    'state' => $row->st_name,
                    'District' => $current_district,
                    'Ambulance No' => $row->mt_amb_no,
                    'Base_Location' => $row->mt_base_loc,  
                    'request_date' => $row->added_date,
                    'approval_date' => $row->approved_date,
                    'modify_date' => $row->modify_date,
                    //'mt_Estimatecost' => $row->mt_Estimatecost,
                    //'informed' => $informed,
                    'mt_pilot_name' => $row->mt_pilot_name,
                    'mt_pilot_id' => $row->mt_pilot_id,
                    'mt_Estimatecost' => $row->mt_Estimatecost,
                    'informed' => $inform_user,
                    //'shift_id'=>$shift_id,
                    //'work_shop'=>$work_shop,
                    'mt_in_odometer'=> $row->mt_in_odometer,
                    'mt_ex_onroad_datetime' =>$row->mt_ex_onroad_datetime,
                    //'mt_schedule_service'=>$row->mt_schedule_service,
                    //'mt_service_name'=>$row->mt_service_name,
                    //'mt_offroad_datetime'=>$row->mt_offroad_datetime,
                    'mt_stnd_remark'=>$row->mt_stnd_remark,
                    'mt_remark'=>$row->mt_remark,
                    'approved_by'=>$row->approved_by,
                    'approved_date'=>$row->approved_date,
                    'mt_approval'=>$row->mt_ambulance_status,
                    'mt_onroad_datetime'=>$row->mt_onroad_datetime,
                    //'mt_on_remark' => $row->mt_on_remark,
                    //'mt_app_est_amt'=>$row->mt_app_est_amt,
                   // 'mt_app_rep_time'=>$row->mt_app_rep_time,
                   // 'mt_app_work_shop'=>$row->mt_app_work_shop, 
                    //'bill_number'=>$row->bill_number,
                   // 'part_cost'=>$row->part_cost, 
                    //'labour_cost'=>$row->labour_cost, 
                    //'total_cost'=>$row->total_cost,
                    'mt_end_odometer'=>$row->mt_end_odometer, 
                    'mt_offroad_datetime'=>$row->mt_offroad_datetime, 
                    'mt_on_stnd_remark'=>$row->mt_on_stnd_remark,
                    'mt_on_remark'=>$row->mt_on_remark,
                    'mt_offroad_reason'=>$row->mt_offroad_reason,
                    'duration'=>$duration,
                );


                fputcsv($fp, $data);
                $count++;
            }

            fclose($fp);
            exit;
        }
    }
    
    function breakdown_maintenance_report(){
         $post_reports = $this->input->post();
        //var_dump($post_reports);die();
        $maintenance_type = $this->input->post('maintenance_type');
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;
        
        if ($post_reports['to_date'] != '') {

            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],'maintenance_type' => $maintenance_type);
        } else {

            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],'maintenance_type' => $maintenance_type);
        }
        $report_data = $this->ambmain_model->get_maintenance_report($report_args);
    
        $header = array('Sr.No','District','Ambulance No','Base Location','Request date','Approval date','Closer date','Estimate Cost','Informed to','Shift Type','Work Shop Name','Pilot Name','Pilot Id','Current Odometer','Break Down Severity','Breakdown Type','Standard Remark', 'Remark','Approval Date', 'Approval','On-Road Date/Time','Remark','Approved Estimate amount','Repairing time','Approved Workshop', 'Bill No.','Cost of Spare Parts','Labour Cost','Total Amount','End Odometer','On Road Date/Time','Standard Remark','Remark');

        $main_file_name = strtotime($post_reports['from_date']);
        $filename = "maintenance_" . $main_file_name . ".csv";
        $this->output->set_focus_to = "inc_ref_id";
        if ($post_reports['reports'] == 'view') {

            $data['header'] = $header;
            $data['maintenance_data'] = $report_data;
            $data['maintenance_type'] = $maintenance_type;
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'breakdown_maintenance_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/maintenance_breakdown_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            //var_dump("hii");die();
            $filename = "ambulance_breakdown_maintenance_report.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $count = 1;

            foreach ($report_data as $row) {
                
                    if($row->mt_type=='accidental'){
                        $main_type="Accidental Maintenance";
                    }
                    elseif($row->mt_type=='breakdown'){
                        $main_type="Breakdown Maintenance";
                    }
                    elseif($row->mt_type=='preventive'){
                        $main_type="Preventive Maintenance";
                    }
                    elseif($row->mt_type=='tyre'){
                        $main_type="Tyre Maintenance";
                    }
                    elseif($row->mt_type=='onroad_offroad'){
                        $main_type="Onroad/offroadMaintenance";
                    }
                    if($row->mt_district_id!= ' '){
                    $current_district = get_district_by_id($row->mt_district_id);
                    }
                    
                    $informed_to = json_decode($row->informed_to); 
                    if(is_array($informed_to)){
                        $informed = implode(',', $informed_to);
                    }
                    $shift_id = '';
                    if($row->mt_shift_id != ''){ $shift_id = show_shift_type_by_id($row->mt_shift_id); } 
                    $work_shop = '';
                    if($row->mt_work_shop != ''){ $work_shop = show_work_shop_by_id($row->mt_work_shop); }
                    $app_work_shop = "";
                    if($row->mt_app_work_shop != ''){ $app_work_shop = show_work_shop_by_id($row->mt_app_work_shop); }
                    if($row->mt_approval == 0){ $mt_approval = "Approval Pending"; }else if($row->mt_approval == 1){ $mt_approval = "Approved"; }else if($row->mt_approval == 2){ $mt_approval = "Not Approve"; }
                    
                    $group_name = array();
                    if(is_array($informed_to)){
                       // echo implode(',', $informed_to);

                        foreach($informed_to as $inform){
                            $group_name[]=get_EMS_title($inform);
                        }

                    }
                    $inform_user = implode(',', $group_name);
                    
        
                    $data = array(
                    'Sr.No' => $count,
                    'District' => $current_district,
                    'Ambulance No' => $row->mt_amb_no,
                    'Base_Location' => $row->mt_base_loc, 
                    'request_date' => $row->added_date,
                    'approval_date' => $row->approved_date,
                    'modify_date' => $row->modify_date,    
                    'mt_Estimatecost' => $row->mt_Estimatecost,
                    'informed' => $inform_user,
                    'shift_id'=>$shift_id,
                    'work_shop'=>$work_shop,
                    'mt_pilot_name' => $row->mt_pilot_name,
                    'mt_pilot_id' => $row->mt_pilot_id,
                    'mt_in_odometer'=> $row->mt_in_odometer,
                    'mt_brakdown_severity' => $row->mt_brakdown_severity,
                    'mt_breakdown_type' => $row->mt_breakdown_type,
                    'mt_stnd_remark'=>$row->mt_stnd_remark,
                    'mt_remark'=>$row->mt_remark,
                    'approved_date'=>$row->approved_date,
                    'mt_approval'=>$row->mt_ambulance_status,    
                    'mt_ex_onroad_datetime' =>$row->mt_ex_onroad_datetime,
                    'mt_app_remark' =>$row->mt_app_remark, 
                    //'mt_schedule_service'=>$row->mt_schedule_service,
                   // 'mt_service_name'=>$row->mt_service_name,
                    //'mt_offroad_datetime'=>$row->mt_offroad_datetime,
                    'mt_app_est_amt'=>$row->mt_app_est_amt,
                    'mt_app_rep_time'=>$row->mt_app_rep_time,
                    'mt_app_work_shop'=>$app_work_shop, 
                    'bill_number'=>$row->bill_number,
                    'part_cost'=>$row->part_cost, 
                    'labour_cost'=>$row->labour_cost, 
                    'total_cost'=>$row->total_cost,
                    'mt_end_odometer'=>$row->mt_end_odometer,            
                    'mt_onroad_datetime'=>$row->mt_onroad_datetime,
                    'mt_on_stnd_remark'=>$row->mt_on_stnd_remark,
                    'mt_on_remark'=>$row->mt_on_remark,
                );

                fputcsv($fp, $data);
                $count++;
            }

            fclose($fp);
            exit;
        }
    }
    
    function tyre_life_maintenance_report(){
         $post_reports = $this->input->post();
        //var_dump($post_reports);die();
        $maintenance_type = $this->input->post('maintenance_type');
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;
        
        if ($post_reports['to_date'] != '') {

            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],'maintenance_type' => $maintenance_type);
        } else {

            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],'maintenance_type' => $maintenance_type);
        }
        $report_data = $this->ambmain_model->get_maintenance_report($report_args);
    
        $header = array('Sr.No','State','District','Ambulance No','Base Location','Request date','Approval date','Closer date','Shift Type','Select Tyre Type','UID no.','Tyre Model','Tyre remark','Reported Date','District Manager','Current Odometer','Expected On-Road Date/Time','Estimate Cost','Informed To','Standard Remark', 'Remark','Approval Date and Time','Approve By', 'Approval','On-Road Date/Time','Remark','Bill No.','Cost of Spare Parts','Labour Cost','Total Amount','End Odometer','On Road Date/Time','Standard Remark','Remark');

        $main_file_name = strtotime($post_reports['from_date']);
        $filename = "maintenance_" . $main_file_name . ".csv";
        $this->output->set_focus_to = "inc_ref_id";
        if ($post_reports['reports'] == 'view') {

            $data['header'] = $header;
            $data['maintenance_data'] = $report_data;
            $data['maintenance_type'] = $maintenance_type;
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'tyre_life_maintenance_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/tyre_maintenance_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            //var_dump("hii");die();
            $filename = "ambulance_maintenance_report.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $count = 1;

            foreach ($report_data as $row) {
                
                    if($row->mt_type=='accidental'){
                        $main_type="Accidental Maintenance";
                    }
                    elseif($row->mt_type=='breakdown'){
                        $main_type="Breakdown Maintenance";
                    }
                    elseif($row->mt_type=='preventive'){
                        $main_type="Preventive Maintenance";
                    }
                    elseif($row->mt_type=='tyre'){
                        $main_type="Tyre Maintenance";
                    }
                    elseif($row->mt_type=='onroad_offroad'){
                        $main_type="Onroad/offroadMaintenance";
                    }
                    if($main_data->mt_district_id!= ' '){
                    $current_district = get_district_by_id($row->mt_district_id);
                    }
                    
                    $informed_to = json_decode($row->informed_to); 
                    if(is_array($informed_to)){
                        $informed = implode(',', $informed_to);
                    }
                    if($row->mt_shift_id != ''){ $shift_id = show_shift_type_by_id($row->mt_shift_id); } 
                    if($row->mt_work_shop != ''){ $work_shop = show_work_shop_by_id($row->mt_work_shop); }
                    if($row->mt_approval == 0){ $mt_approval = "Approval Pending"; }else if($row->mt_approval == 1){ $mt_approval = "Approved"; }else if($row->mt_approval == 2){ $mt_approval = "Not Approve"; }
                    
                     $group_name = array();
                    if(is_array($informed_to)){
                       // echo implode(',', $informed_to);

                        foreach($informed_to as $inform){
                            $group_name[]=get_EMS_title($inform);
                        }

                    }
                    $inform_user = implode(',', $group_name);
                    
                    
                     $mt_tyre_type = json_decode($row->mt_tyre_type); 
                    if(is_array($mt_tyre_type)){
                        $tyre_type = implode(',', $mt_tyre_type);
                    }
        
                    $data = array(
                    'Sr.No' => $count,
                    'st_name' => $row->st_name,
                    'District' => $current_district,
                    'Ambulance No' => $row->mt_amb_no,
                    'Base_Location' => $row->mt_base_loc,  
                    'request_date' => $row->added_date,
                    'approval_date' => $row->approved_date,
                    'modify_date' => $row->modify_date,    
                    'shift_id'=>$shift_id,
                    'mt_tyre_type' => $tyre_type,
                    'mt_uid_no' => $row->mt_uid_no,
                    'mt_tyre_model' => $row->mt_tyre_model,
                    'mt_tyre_remark' => $row->mt_tyre_remark,
                    'mt_reported_date' => $row->mt_reported_date,
                    'mt_district_manager' => $row->mt_district_manager,
                    'mt_in_odometer'=> $row->mt_in_odometer,
                    'mt_ex_onroad_datetime' =>$row->mt_ex_onroad_datetime,
                    'mt_Estimatecost' => $row->mt_Estimatecost,
                    'informed' => $inform_user,
                    'mt_stnd_remark'=>$row->mt_stnd_remark,
                    'mt_remark'=>$row->mt_remark,
                    'approved_date'=>$row->approved_date,
                    'approved_by'=>$row->approved_by,
                    
                    'mt_approval'=>$row->mt_ambulance_status,
                    'mt_onroad_datetime'=>$row->mt_onroad_datetime,
                     'mt_app_remark'=>$row->mt_app_remark,
                     'bill_number'=>$row->bill_number,
                    'part_cost'=>$row->part_cost, 
                    'labour_cost'=>$row->labour_cost, 
                    'total_cost'=>$row->total_cost,
                    'mt_end_odometer'=>$row->mt_end_odometer, 
                    'mt_onroad_datetime1'=>$row->mt_onroad_datetime, 
                    'mt_on_stnd_remark'=>$row->mt_on_stnd_remark,
                    'mt_on_remark'=>$row->mt_on_remark,
                );



                fputcsv($fp, $data);
                $count++;
            }

            fclose($fp);
            exit;
        }
    }
    
    function accidental_maintenance_report(){
         $post_reports = $this->input->post();
        //var_dump($post_reports);die();
        $maintenance_type = $this->input->post('maintenance_type');
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;
        
        if ($post_reports['to_date'] != '') {

            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],'maintenance_type' => $maintenance_type);
        } else {

            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],'maintenance_type' => $maintenance_type);
        }
        $report_data = $this->ambmain_model->get_maintenance_report($report_args);
    
        $header = array('Sr.No','District','Ambulance No','Request date','Approval date','Closer date','Accident Date','Estimate Cost','Shift Type','Work Shop Name','Pilot Name','Pilot Id','Last Updated Odometer','Current Odometer','Accidental Severity','Expected On-Road Date/Time','Accidental type','Informed To','Towing Required','Fire On Scene','Standard Remark', 'Remark','Approve By','Approval Date and Time', 'Approval','On-Road Date/Time','Approved Estimate amount','Repairing time','Approved Workshop
', 'Bill No.','Cost of Spare Parts','Labour Cost','Total Amount','End Odometer','Standard Remark','Remark');

        $main_file_name = strtotime($post_reports['from_date']);
        $filename = "maintenance_" . $main_file_name . ".csv";
        $this->output->set_focus_to = "inc_ref_id";
        if ($post_reports['reports'] == 'view') {

            $data['header'] = $header;
            $data['maintenance_data'] = $report_data;
            $data['maintenance_type'] = $maintenance_type;
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'accidental_maintenance_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/accidental_maintenance_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            //var_dump("hii");die();
            $filename = "ambulance_maintenance_report.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $count = 1;

            foreach ($report_data as $row) {
                
                    if($row->mt_type=='accidental'){
                        $main_type="Accidental Maintenance";
                    }
                    elseif($row->mt_type=='breakdown'){
                        $main_type="Breakdown Maintenance";
                    }
                    elseif($row->mt_type=='preventive'){
                        $main_type="Schedule Service";
                    }
                    elseif($row->mt_type=='tyre'){
                        $main_type="Tyre Maintenance";
                    }
                    elseif($row->mt_type=='onroad_offroad'){
                        $main_type="Onroad/offroadMaintenance";
                    }
                    if($main_data->mt_district_id!= ' '){
                    $current_district = get_district_by_id($row->mt_district_id);
                    }
                    
                    $informed_to = json_decode($row->informed_to); 
                    if(is_array($informed_to)){
                        $informed = implode(',', $informed_to);
                    }
                    if($row->mt_shift_id != ''){ $shift_id = show_shift_type_by_id($row->mt_shift_id); } 
                    if($row->mt_work_shop != ''){ $work_shop = show_work_shop_by_id($row->mt_work_shop); }
                    if($row->mt_app_work_shop != ''){ $app_work_shop = show_work_shop_by_id($row->mt_app_work_shop); }
                    if($row->mt_approval == 0){ $mt_approval = "Approval Pending"; }else if($row->mt_approval == 1){ $mt_approval = "Approved"; }else if($row->mt_approval == 2){ $mt_approval = "Not Approve"; }
                    
                    
                    $group_name = array();
                    if(is_array($informed_to)){
                       // echo implode(',', $informed_to);

                        foreach($informed_to as $inform){
                            $group_name[]=get_EMS_title($inform);
                        }

                    }
                    $inform_user = implode(',', $group_name);

        
                    $data = array(
                    'Sr.No' => $count,
                    'District' => $current_district,
                    'Ambulance No' => $row->mt_amb_no,
                    'request_date' => $row->added_date,
                    'approval_date' => $row->approved_date,
                    'modify_date' => $row->modify_date,    
                    'mt_accidentdate' => $row->mt_accidentdate,  
                    'mt_Estimatecost' => $row->mt_Estimatecost,
                    'shift_id'=>$shift_id,
                    'work_shop'=>$work_shop,
                   
                    'mt_pilot_name' => $row->mt_pilot_name,
                    'mt_pilot_id' => $row->mt_pilot_id,
                    
                    'mt_previos_odometer'=> $row->mt_previos_odometer,
                    'mt_in_odometer'=> $row->mt_in_odometer,
                    'mt_accidental_severity'=>$row->mt_accidental_severity,
                    'mt_ex_onroad_datetime'=>$row->mt_ex_onroad_datetime,
                    'mt_accidental_type'=>$row->mt_accidental_type,
                     'informed' => $inform_user,
                    //'mt_ex_onroad_datetime' =>$row->mt_ex_onroad_datetime,
                    'mt_towing_required'=>$row->mt_towing_required,
                    'mt_fire_on_scene'=>$row->mt_fire_on_scene,
                    //'mt_offroad_datetime'=>$row->mt_offroad_datetime,
                    'mt_stnd_remark'=>$row->mt_stnd_remark,
                    'mt_remark'=>$row->mt_remark,
                    'approved_by'=>$row->approved_by,
                    'approved_date'=>$row->approved_date,
                    'mt_approval'=>$row->mt_ambulance_status,
                    'mt_onroad_datetime'=>$row->mt_onroad_datetime,
                   // 'mt_on_remark' => $row->mt_on_remark,
                    'mt_app_est_amt'=>$row->mt_app_est_amt,
                    'mt_app_rep_time'=>$row->mt_app_rep_time,
                    'mt_app_work_shop'=>$app_work_shop, 
                    'bill_number'=>$row->bill_number,
                    'part_cost'=>$row->part_cost, 
                    'labour_cost'=>$row->labour_cost, 
                    'total_cost'=>$row->total_cost,
                    'mt_end_odometer'=>$row->mt_end_odometer, 
                    //'mt_onroad_datetime'=>$row->mt_onroad_datetime, 
                    'mt_on_stnd_remark'=>$row->mt_on_stnd_remark,
                    'mt_on_remark'=>$row->mt_on_remark,
                );


                fputcsv($fp, $data);
                $count++;
            }

            fclose($fp);
            exit;
        }
    }
    function dispatch_incident_pvt_hos_report(){
        $post_reports = $this->input->post();
        //var_dump($post_reports);die;
        $track_args = array('trk_report_name'=>'Dispatch Incident Pvt Hos Report','trk_download_by'=>$this->clg->clg_ref_id);
        track_report_download($track_args);
        
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;
        $thirdparty = $this->clg->thirdparty;
        $district = $this->clg->clg_district_id;
        $clg_district_id = json_decode($district);
        if(is_array($clg_district_id)){
            $district_id = implode("','",$clg_district_id);
        }

        if ($post_reports['to_date'] != '') {

            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
                //'system' => array('108','102'),
                'system' => $post_reports['system']
            );
        } else {

            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                //'system' => array('108','102'),
                'system' => $post_reports['system']
            );
        }
       
        $report_data = $this->inc_model->get_dispatch_inc_pvt_hos_by_report($report_args);

        $header = array('Sr.No', 'call Receive Date/Time', 'Incident Id','Call Type','Call Purpose', 'Caller Number', 'Caller Name', 'No of patients', 'Chief Complaint', 'Patient Name', 'Age', 'Gender', 'ERO Standard Remark', 'ERO Summary', 'Address', 'District', 'Ambulance No','Base Location','Total Distance','Total Amount','Call Disconnected Date/Time', 'Call Duration', 'Operated By ID', 'Operated By Name',  'Closure Status');


        $inc_file_name = strtotime($post_reports['from_date']);
        
        $date1=date_create($report_args['from_date']);
        $date2=date_create($report_args['to_date']);
        $diff=date_diff($date1,$date2);
        $day_count =  $diff->format("%a");
        
        $filename = "incident_" . $inc_file_name . ".csv";
         
        if ($post_reports['reports'] == 'view' && $day_count <= 1) {
          
            $data['header'] = $header;
            $data['inc_data'] = $report_data;
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'dispatch_incident_pvt_hos_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/inc_report_view', $data, TRUE), 'list_table', TRUE);
        } else {

            
            $filename = "dispatch_incident_pvt_hos_report.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $count = 1;

            foreach ($report_data as $row) {

                if($row->inc_recive_time != '' ){
                    $d1= new DateTime($row->inc_recive_time);
                    
                
                $d2=new DateTime($row->inc_datetime);
                $duration=$d2->diff($d1);
                //var_dump($duration);die;
                    }
                   if($duration != NULL){
                   $duration = $duration->h . ':' . $duration->i . ':' . $duration->s;
                   $duration = date('H:i:s', strtotime($duration));
                   }
                   else{
                       $duration= "00:00:00";
                   }
                if ($row->incis_deleted == '0') {
                    $status = 'Active';
                } else if ($row->incis_deleted == '1') {
                    $status = 'Deleted';
                } else if ($row->incis_deleted == '2') {
                    $status = 'Terminated';
                }
               
                if ($row->inc_pcr_status == '0') {
                    $status1 = 'Not Done';
                } else if ($row->inc_pcr_status == '1') {
                    $status1 = 'Done';
                }
                 if($row->hp_name == ''){ 
                    $hp_name = $row->ward_name; 
                }else{ 
                    $hp_name = $row->hp_name;
                 }
                if($row->inc_recive_time != NULL){
                    $add_date = date('Y-m-d', strtotime($row->inc_recive_time));
                     $add_time = date('H:i:s', strtotime($row->inc_recive_time));
                     $final_date= $add_date.'-'.$add_time;
                                 }
                                 else{
                                     $final_date= '';
                                 }
                 if($row->inc_datetime != NULL){
                     $add_date = date('Y-m-d', strtotime($row->inc_datetime));
                     $add_time = date('H:i:s', strtotime($row->inc_datetime));
                    $dis_final_date= $add_date.'-'.$add_time;
                            }
                             else{
                                  $dis_final_date= '';
                                     }
                if($row->ptn_gender=='M'){
                    $gender='Male';
                }else if($row->ptn_gender=='F'){
                    $gender='Female';
                }
                else if($row->ptn_gender=='O'){
                    $gender='Transgender';
                }    
                
                if($row->ct_type !=''){
                    if($row->ct_type == 'Other')
                {
                    $Complaint=$row->ct_type.'-'.$row->inc_complaint_other; 
                }else{ 
                    $Complaint=$row->ct_type; 
                } 
                    
                }else if($row->ntr_nature!=''){
                    $Complaint=$row->ntr_nature;
                }   
                if($row->p_parent == 'EMG')
            {
                $parent = 'Emergency';
            }elseif($row->p_parent == 'COMP'){
                $parent = 'Grievance call';
            }
            elseif($row->p_parent == 'NON_EME'){
                $parent = 'Non Emergency';
            }
            elseif($row->p_parent == 'CALL_TRANS'){
                $parent = 'CALL_TRANS';
            }
            $clg_full_name = $row->clg_first_name . ' ' . $row->clg_mid_name . ' ' . $row->clg_last_name;
            
                $data = array(
                    'Sr.No' => $count,
                    'inc_datetime' => $final_date,
                    'inc_ref_id' => $row->inc_ref_id,
                    'call_type' => $parent,
                    'pname' => $row->pname,
                    'clr_mobile' => $row->clr_mobile,
                    'clr_fullname' => ucfirst($row->clr_fname . ' ' . $row->clr_lname),
                    'inc_patient_cnt' => $row->inc_patient_cnt,
                    'ct_type' => $Complaint,
                    'ptn_fname' => ucfirst($row->ptn_fname.' '.$row->ptn_lname),
                    'ptn_age' => $row->ptn_age.' '.$row->ptn_age_type,
                    'ptn_gender' => $gender,
                    'inc_ero_standard_summary' => $row->re_name,
                    'inc_ero_summary' => $row->inc_ero_summary,
                    'inc_address' => $row->inc_address,
                    'dst_name' => $row->dst_name,
                    'amb_rto_register_no' => $row->amb_rto_register_no,
                    'hp_name' => $row->base_location_name?$row->base_location_name:$row->hp_name,
                    'pr_case_total_distance' => $row->pr_case_total_distance,
                    'pr_total_amount' => $row->pr_total_amount,
                    //'ward_name' => $row->ward_name?$row->ward_name:$row->wrd_name,
                    'disconneted_date_time' => $dis_final_date,
                    'call_duration' => $duration,
                    'operator_id' => ucwords($row->inc_added_by),
                    'full_name' => $clg_full_name,
                   // 'status' => $status,
                   // 'Third Party' => $row->thirdparty_name,
                    'status1' => $status1
                );
                $thirdparty='';
                $Complaint='';
                fputcsv($fp, $data);
                $count++;
            }

            fclose($fp);
            exit;
        }
    }
    //Incidence dispacth report 

    function dispatch_incident_report() {

        $post_reports = $this->input->post();
        //var_dump($post_reports);die;
        $track_args = array('trk_report_name'=>'Dispatch Incident Report','trk_download_by'=>$this->clg->clg_ref_id);
        track_report_download($track_args);
        
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;
        $thirdparty = $this->clg->thirdparty;
        $district = $this->clg->clg_district_id;
        $clg_district_id = json_decode($district);
        if(is_array($clg_district_id)){
            $district_id = implode("','",$clg_district_id);
        }

        if ($post_reports['to_date'] != '') {

            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
                //'system' => array('108','102'),
                'system' => $post_reports['system']
            );
        } else {

            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                //'system' => array('108','102'),
                'system' => $post_reports['system']
            );
        }
       
        $report_data = $this->inc_model->get_dispatch_inc_by_report($report_args);

        $header = array('Sr.No', 'call Receive Date/Time', 'Incident Id','Call Type','Call Purpose', 'Caller Number', 'Caller Name', 'No of patients', 'Chief Complaint', 'Patient Name', 'Age', 'Gender', 'ERO Standard Remark', 'ERO Summary', 'Address', 'District', 'Ambulance No','Base Location','Call Disconnected Date/Time', 'Call Duration', 'Operated By ID', 'Operated By Name',  'Closure Status');


        $inc_file_name = strtotime($post_reports['from_date']);
        
        $date1=date_create($report_args['from_date']);
        $date2=date_create($report_args['to_date']);
        $diff=date_diff($date1,$date2);
        $day_count =  $diff->format("%a");
        
        $filename = "incident_" . $inc_file_name . ".csv";
         
            
        if ($post_reports['reports'] == 'view' && $day_count <= 1) {
          
            $data['header'] = $header;
            $data['inc_data'] = $report_data;
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'dispatch_incident_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/inc_report_view', $data, TRUE), 'list_table', TRUE);
        } else {

            
            $filename = "dispatch_incident_report.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $count = 1;

            foreach ($report_data as $row) {

                if($row->inc_recive_time != '' ){
                    $d1= new DateTime($row->inc_recive_time);
                    
                
                $d2=new DateTime($row->inc_datetime);
                $duration=$d2->diff($d1);
                //var_dump($duration);die;
                    }
                   if($duration != NULL){
                   $duration = $duration->h . ':' . $duration->i . ':' . $duration->s;
                   $duration = date('H:i:s', strtotime($duration));
                   }
                   else{
                       $duration= "00:00:00";
                   }
                if ($row->incis_deleted == '0') {
                    $status = 'Active';
                } else if ($row->incis_deleted == '1') {
                    $status = 'Deleted';
                } else if ($row->incis_deleted == '2') {
                    $status = 'Terminated';
                }
               
                if ($row->inc_pcr_status == '0') {
                    $status1 = 'Not Done';
                } else if ($row->inc_pcr_status == '1') {
                    $status1 = 'Done';
                }
                 if($row->hp_name == ''){ 
                    $hp_name = $row->ward_name; 
                }else{ 
                    $hp_name = $row->hp_name;
                 }
                if($row->inc_recive_time != NULL){
                    $add_date = date('Y-m-d', strtotime($row->inc_recive_time));
                     $add_time = date('H:i:s', strtotime($row->inc_recive_time));
                     $final_date= $add_date.'-'.$add_time;
                                 }
                                 else{
                                     $final_date= '';
                                 }
                 if($row->inc_datetime != NULL){
                     $add_date = date('Y-m-d', strtotime($row->inc_datetime));
                     $add_time = date('H:i:s', strtotime($row->inc_datetime));
                    $dis_final_date= $add_date.'-'.$add_time;
                            }
                             else{
                                  $dis_final_date= '';
                                     }
                if($row->ptn_gender=='M'){
                    $gender='Male';
                }else if($row->ptn_gender=='F'){
                    $gender='Female';
                }
                else if($row->ptn_gender=='O'){
                    $gender='Transgender';
                }    
                
                if($row->ct_type !=''){
                    if($row->ct_type == 'Other')
                {
                    $Complaint=$row->ct_type.'-'.$row->inc_complaint_other; 
                }else{ 
                    $Complaint=$row->ct_type; 
                } 
                    
                }else if($row->ntr_nature!=''){
                    $Complaint=$row->ntr_nature;
                }   
                if($row->p_parent == 'EMG')
            {
                $parent = 'Emergency';
            }elseif($row->p_parent == 'COMP'){
                $parent = 'Grievance call';
            }
            elseif($row->p_parent == 'NON_EME'){
                $parent = 'Non Emergency';
            }
            elseif($row->p_parent == 'CALL_TRANS'){
                $parent = 'CALL_TRANS';
            }
            $clg_full_name = $row->clg_first_name . ' ' . $row->clg_mid_name . ' ' . $row->clg_last_name;
            
                $data = array(
                    'Sr.No' => $count,
                    'inc_datetime' => $final_date,
                    'inc_ref_id' => $row->inc_ref_id,
                    'call_type' => $parent,
                    'pname' => $row->pname,
                    'clr_mobile' => $row->clr_mobile,
                    'clr_fullname' => ucfirst($row->clr_fname . ' ' . $row->clr_lname),
                    'inc_patient_cnt' => $row->inc_patient_cnt,
                    'ct_type' => $Complaint,
                    'ptn_fname' => ucfirst($row->ptn_fname.' '.$row->ptn_lname),
                    'ptn_age' => $row->ptn_age.' '.$row->ptn_age_type,
                    'ptn_gender' => $gender,
                    'inc_ero_standard_summary' => $row->re_name,
                    'inc_ero_summary' => $row->inc_ero_summary,
                    'inc_address' => $row->inc_address,
                    'dst_name' => $row->dst_name,
                    'amb_rto_register_no' => $row->amb_rto_register_no,
                    'hp_name' => $row->base_location_name?$row->base_location_name:$row->hp_name,
                    //'ward_name' => $row->ward_name?$row->ward_name:$row->wrd_name,
                    'disconneted_date_time' => $dis_final_date,
                    'call_duration' => $duration,
                    'operator_id' => ucwords($row->inc_added_by),
                    'full_name' => $clg_full_name,
                   // 'status' => $status,
                   // 'Third Party' => $row->thirdparty_name,
                    'status1' => $status1
                );
                $thirdparty='';
                $Complaint='';
                fputcsv($fp, $data);
                $count++;
            }

            fclose($fp);
            exit;
        }
    }

    //Incident report other Incident report

    function other_incident_report() {

        $post_reports = $this->input->post();
        $track_args = array('trk_report_name'=>'Other Incident Report','trk_download_by'=>$this->clg->clg_ref_id);
        track_report_download($track_args);
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;
         $thirdparty = $this->clg->thirdparty;
        $district = $this->clg->clg_district_id;
        $clg_district_id = json_decode($district);
        if(is_array($clg_district_id)){
            $district_id = implode("','",$clg_district_id);
        }

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
                'system' => $post_reports['system'],
           // 'thirdparty' => $thirdparty,
              //  'clg_district_id' => $district_id 
            );
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                'system' =>  $post_reports['system'],
               // 'thirdparty' => $thirdparty,
               // 'clg_district_id' => $district_id 
            );
        }

        $report_data = $this->inc_model->get_other_inc_by_report($report_args);



        $header = array('Sr.No', 'call Receive Date/Time', 'Incident Id', 'Call Purpose', 'Caller Number', 'Caller Name', 'ERO Standard remark', 'ERO remark', 'Call Disconected Date/Time', 'Call Duration', 'Operate by','Operated By Name');


        $inc_file_name = strtotime($post_reports['from_date']);
        $filename = "incident_" . $inc_file_name . ".csv";
        if ($post_reports['reports'] == 'view') {

            $data['header'] = $header;
            $data['inc_data'] = $report_data;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/other_inc_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "other_incident_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);


            $data = array();
            $count = 1;
            foreach ($report_data as $row) {
                
                if($row->inc_datetime != NULL){
                    $add_date = date('Y-m-d', strtotime($row->inc_datetime));
                     $add_time = date('H:i:s', strtotime($row->inc_datetime));
                     $final_date= $add_date.'-'.$add_time;
                                 }
                                 else{
                                     $final_date= '';
                                 }
                 if($row->inc_recive_time != NULL){
                    $dis_add_date = date('Y-m-d', strtotime($row->inc_recive_time));
                     $dis_add_time = date('H:i:s', strtotime($row->inc_recive_time));
                     $final_date1= $dis_add_date.'-'.$dis_add_time;
                                 }
                                 else{
                                     $final_date1= '';
                                 }
                                
                         if($row->inc_recive_time != '' ){
                            $d1= new DateTime($row->inc_recive_time);
                                    
                                
                                $d2=new DateTime($row->inc_datetime);
                                $duration=$d2->diff($d1);
                                //var_dump($duration);die;
                                    }
                                   if($duration != NULL){
                                   $duration = $duration->h . ':' . $duration->i . ':' . $duration->s;
                                   $duration = date('H:i:s', strtotime($duration));
                                   }
                                   else{
                                       $duration= "00:00:00";
                                   }
                                   $clg_full_name = $row->clg_first_name . ' ' . $row->clg_mid_name . ' ' . $row->clg_last_name;

                $data = array(
                    'Count' => $count,
                    'inc_datetime' => $final_date1,
                    'inc_ref_id' => $row->inc_ref_id,
                    'pname' => ucfirst($row->pname),
                    'clr_mobile' => $row->clr_mobile,
                    'clr_fullname' => ucfirst($row->clr_fname.' '.$row->clr_lname),
                    're_name' => $row->re_name,
                    'inc_ero_summary' => $row->inc_ero_summary,
                    'dis_datetime' => $final_date,
                    'inc_dispatch_time' => $duration,
                    'operator_id' => ucwords($row->inc_added_by),
                    'full_name' => $clg_full_name,
                   // 'third Party' => $row->thirdparty_name,
                );
                
                fputcsv($fp, $data);
                $count++;
            }

            fclose($fp);
            exit;
        }
    }
    function createdateRange($start, $end, $format = 'Y-m-d') {
        $start  = new DateTime($start);
        $end    = new DateTime($end);
        $invert = $start > $end;

        $dates = array();
        $dates[] = $start->format($format);
        while ($start != $end) {
            $start->modify(($invert ? '-' : '+') . '1 day');
            $dates[] = $start->format($format);
        }
        return $dates;
    }
    function district_wise_patient_served(){
        $post_reports = $this->input->post();
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $yesterday = date( 'Y-m-d', strtotime( $from_date . ' -1 day' ) );
        $report_args = array('from_date' => date('Y-m-d', strtotime($from_date)),
                'system'=> $this->input->post('system')
            );
        
        $data['submit_funtion'] = "district_wise_patient_served";
        
        $header = array("District","On $yesterday","Month Total","Since Launch");
        
        $get_district = $this->inc_model->get_district_name();
       // var_dump($get_district);
        $patient_data = array();
        foreach($get_district as $district){  
            
            $today_args = array('from_date' => $yesterday,
                'to_date' => $yesterday,
                'system'=> $this->input->post('system'),
                'district_id'=>$district->dst_code
            );
          //  var_dump($today_args);die;
            $get_today_patient = $this->inc_model->get_district_patient_served($today_args);
            
            $years = date('Y', strtotime($post_reports['from_date']));
            $month= date('m', strtotime($post_reports['from_date']));
            $current_date =  $years.'-'.$month.'-'.'01';
            

            
            $month_args = array('from_date' => $current_date,
                'to_date' =>  date('Y-m-t', strtotime($years.'-'.$month)),
                'system'=> $this->input->post('system'),
                'district_id'=>$district->dst_code
            );
            //var_dump($month_args);die;
            $get_month_patient = $this->inc_model->get_district_patient_served($month_args);
            
            $total_args = array(
                'system'=> $this->input->post('system'),
                'district_id'=>$district->dst_code
            );
            //var_dump($total_args);die;

            $get_total_patient = $this->inc_model->get_district_patient_served($total_args);
            
            $patient_data[]=array('dist_name'=>$district->dst_name,
                                  'today'=>$get_today_patient[0]->total_patient,
                                  'month'=>$get_month_patient[0]->total_patient,
                                  'total'=>$get_total_patient[0]->total_patient); 
                                  //var_dump($patient_data['today']);die;
        }

       if ($post_reports['reports'] == 'view') {       
            $data['header'] = $header;
            $data['patient_data'] = $patient_data;
            $data['report_args'] = $report_args;
            
            $this->output->add_to_position($this->load->view('frontend/erc_reports/district_wise_patient_served', $data, TRUE), 'list_table', TRUE);
            
        }else{
             // var_dump($post_reports); 
            $filename = "district_wise_patient_served.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv; charset=UTF-8');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);
                
            $today =0;
            $month =0;
            $total =0;
            foreach($patient_data as $inc){
                    // var_dump($inc);
                    
                $data = array ('dist_name'=>$inc['dist_name'], 
                'today'=>$inc['today'], 
                'month'=>$inc['month'], 
                'total'=>$inc['total']);
                
                $today=$today+$inc['today'];
                $month=$month+$inc['month'];
                $total=$total+$inc['total'];
    
                fputcsv($fp, $data);
                $count++;
           
            }
//var_dump($total_args);

            $total_count = array('Total',$today,$month,$total);
            fputcsv($fp, $total_count);
                
            fclose($fp);
            exit;
           
        }
            
                 
    }
    function call_count_aht_report(){
         $post_reports = $this->input->post();
         
         
        $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                  
            );
        if($post_reports['clg_group'] != ''){
            $report_args['clg_group'] = $post_reports['clg_group'];
        }else{
            $report_args['user_group'] = 'UG-ERO,UG-ERO-102';
        }
        
        
            //var_dump($this->input->post());die;
        $header = array("ERO Name","Avaya ID","Process 102/108","EM Call Count","EM Call AHT","Hospital to hospital Call Count","Hospital to hospital Call AHT","Non EM Call Count","Non EM Call AHT");
        
        //$get_district = $this->inc_model->get_district_name();
        $get_eros_data = $this->colleagues_model->get_clg_data($report_args);
        

//var_dump($get_eros_data);die;
    $ero_data = array();
   // $inc_data = array();
    foreach($get_eros_data as $erodata){
         
        $ero_name = $erodata->clg_first_name." ".$erodata->clg_mid_name." ".$erodata->clg_last_name;
         
        if($erodata->clg_group == 'UG-ERO'){ $system = '108';}else { $system =  '102';}
         
        $arg_data = array('inc_added_by'=>$erodata->clg_ref_id,
             'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                 'inc_type'=>"NON_MCI','AD_SUP_REQ','DROP_BACK','MCI','EMT_MED_AD','PREGANCY_CALL','VIP_CALL','Child_CARE_CALL");
        
        $hosp_data = array('inc_added_by'=>$erodata->clg_ref_id,
             'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                 'inc_type'=>'IN_HO_P_TR');
        
        $arg_nem_data = array('inc_added_by'=>$erodata->clg_ref_id,
                'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])));
        
        
        
        $em_call_res = $this->inc_model->get_total_by_call_type_inc($arg_data);
        
        $hosp_count = $this->inc_model->get_total_by_call_type_inc($hosp_data);

        $nem_call_res = $this->inc_model->get_total_noneme_calls($arg_nem_data);
        
        $total_count_eme = get_inc_total_by_user($arg_data);
        $total_count_hosp = get_inc_total_by_user($hosp_data);
        $total_count_nem = get_nonems_total_by_user($arg_nem_data);
        //var_dump($hosp_count);
        
        $em_call_total = "0";
        foreach($em_call_res as $em_call){
            $inc_recive_time='0';
            $time_diff='0';
            if($em_call->inc_recive_time != '0000-00-00 00:00:00'){
                $inc_recive_time = strtotime($em_call->inc_recive_time);
            }
            $inc_datetime = strtotime($em_call->inc_datetime);
            
            if($em_call->inc_recive_time != '0000-00-00 00:00:00'){
                $time_diff = $inc_datetime - $inc_recive_time;
            }
            if ($time_diff > 0) {
                $em_call_total += $time_diff;
            }
        }
        if($total_count_eme > 0){
            $em_call_total = $em_call_total/$total_count_eme;
        }
        
        $e_H = floor($em_call_total / 3600);
        $e_i = ($em_call_total / 60) % 60;
        $e_s = $em_call_total % 60;
        $em_time = sprintf("%02d:%02d:%02d", $e_H, $e_i, $e_s);
        $em_total_time = $em_time;
        
        $hosp_time_diff = "0";
        //var_dump($hosp_count);
        foreach($hosp_count as $hosp){
            $hosp_recive_time='0';
            if($hosp->inc_recive_time != '0000-00-00 00:00:00'){
                $hosp_recive_time = strtotime($hosp->inc_recive_time);
            }
            $hosp_datetime = strtotime($hosp->inc_datetime);
            $hosp_time_res = $hosp_datetime - $hosp_recive_time;
            //var_dump($hosp_time_res);
            if ($hosp_time_res > 0) {
                $hosp_time_diff += $hosp_time_res;
            }
            
        }
        if($hosp_time_diff > 0){
            $hosp_time_diff = $hosp_time_diff/$total_count_hosp;
        }
      //  var_dump($hosp_time_diff);
        
        $h_H = floor($hosp_time_diff / 3600);
        $h_i = ($hosp_time_diff / 60) % 60;
        $h_s = $hosp_time_diff % 60;
        $hosp_time = sprintf("%02d:%02d:%02d", $h_H, $h_i, $h_s);
        $hosp_total_time = $hosp_time;
        
        
        $nem_time_diff = "0";
        foreach($nem_call_res as $nem_call){
            $nem_recive_time='0';
            if($em_call->inc_recive_time != '0000-00-00 00:00:00'){
                $nem_recive_time = strtotime($nem_call->inc_recive_time);
            }
            $nem_datetime = strtotime($nem_call->inc_datetime);
            $nem_diff = $nem_datetime - $nem_recive_time;
            if ($nem_diff > 0) {
                $nem_time_diff += $nem_diff;
            }
        }
        if($total_count_nem > 0 ){
            $nem_time_diff = $nem_time_diff/$total_count_nem;
        }

        $H = floor($nem_time_diff / 3600);
        $i = ($nem_time_diff / 60) % 60;
        $s = $nem_time_diff % 60;
        $nem_time = sprintf("%02d:%02d:%02d", $H, $i, $s);
        $nem_total_time = $nem_time;
        
        $ero_data[] = array('ero_name'=>$ero_name,
                            'clg_avaya_id' => $erodata->clg_avaya_id ,
                            'clg_group' => $system,
                            'em_call_count'=>$total_count_eme,
                            'em_call_total'=>$em_total_time,
                            'hosp_count'=>$total_count_hosp,
                            'hosp_time_diff'=>$hosp_total_time,
                            'nem_call_count'=>$total_count_nem,
                            'nem_time_diff'=>$nem_total_time
                             );                   
    }
     

       if ($post_reports['reports'] == 'view') {       
            $data['header'] = $header;
            $data['patient_data'] = $ero_data;
            $data['report_args'] = $report_args;
            $data['submit_funtion'] = "call_count_aht_report";

            $this->output->add_to_position($this->load->view('frontend/erc_reports/aht_report_view', $data, TRUE), 'list_table', TRUE);
            
        }else{
            
            $filename = "call_count_aht_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv; charset=UTF-8');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);
                

            foreach($ero_data as $inc){
                
                $data = array ('dist_name'=>ucwords($inc['ero_name']), 
                                'clg_avaya_id'=>$inc['clg_avaya_id'], 
                                'clg_group'=>$inc['clg_group'], 
                                'em_call_count'=>$inc['em_call_count'],
                                'em_call_total'=>$inc['em_call_total']?$inc['em_call_total']:0,
                                'hosp_count'=>$inc['hosp_count'],
                                'hosp_time_diff'=>$inc['hosp_time_diff']?$inc['hosp_time_diff']:0,
                                'nem_call_count'=>$inc['nem_call_count'],
                                'nem_time_diff'=>$inc['nem_time_diff']?$inc['nem_time_diff']:0,
                    
                    );
                
    
                fputcsv($fp, $data);
                $count++;
           
            }
                
            fclose($fp);
            exit;
           
        } 
    }
    
    function unable_to_dispatch_report(){
         $post_reports = $this->input->post();
        //var_dump($post_reports);die;
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        if ($post_reports['to_date'] != '') {

            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month']);
        } else {

            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month']);
        }

        $report_data = $this->inc_model->get_unable_to_dispatch_report($report_args);

        $header = array('Incident ID','Call Receive Date /Time','Call End Date / Time','Call Duration','Caller Name','Caller Number','Current District','Current Tehsil','Current Hospital','Home District','ERO Summary','ERO Note','Ambulance-1 No','Ambulance-1 Base Location','Ambulance-1 Remark','Ambulance-2  No','Ambulance-2 Base Location','Ambulance-2 Remark','Ambulance-3  No','Ambulance-3 Base Location','Ambulance-3 Remark','Handled by ERO','ERO Name');


        $inc_file_name = strtotime($post_reports['from_date']);
        $filename = "incident_" . $inc_file_name . ".csv";
        if ($post_reports['reports'] == 'view') {

            $data['header'] = $header;
            $data['inc_data'] = $report_data;
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'unable_to_dispatch_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/unable_to_dispatch_report_report_view', $data, TRUE), 'list_table', TRUE);
            
        } else {

            $filename = "unable_to_dispatch_report.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $count = 1;

            foreach ($report_data as $row) {
                
                if($row->inc_recive_time != '' ){
            $d1= new DateTime($row->inc_recive_time);
            
        
        $d2=new DateTime($row->inc_datetime);
        $duration=$d2->diff($d1);
        //var_dump($duration);die;
            }

                if($duration != NULL){
                $duration = $duration->h . ':' . $duration->i . ':' . $duration->s;
                $duration = date('H:i:s', strtotime($duration));
                }
                else{
                    $duration= "00:00:00";
                }
                $unable_to_dispatch_amb = get_unable_to_dispatch_amb($row->inc_ref_id);
                $amb[0] = "";
                $hp_name[0]= "";
                $enable_remark[0]= "";
                $amb[1]= "";
                $hp_name[1]= "";
                $enable_remark[1]= "";
                $amb[2]= "";
                $hp_name[2]= "";
                $enable_remark[2]= "";
                foreach($unable_to_dispatch_amb as $key=>$unable){
                    $amb[$key] = $unable->amb_reg_no;
                    $hp_name[$key] =$unable->hp_name; 
                    $enable_remark[$key] =get_ero_remark($unable->enable_remark); 
                 } 

                $current_district = "";
                if($row->current_district  != ''){ 
                    $current_district = get_district_by_id($row->current_district);   
                }
                if($row->inc_tahshil_id  != ''){ $tahshil_id = get_tehsil_by_id($row->inc_tahshil_id); }
                $back_hospital = "";       
                if($row->inc_back_hospital != ''){
                    $hospital = get_hospital_by_id($row->inc_back_hospital);
                    $back_hospital=  $hospital[0]->hp_name;
                }
                $home_district_id = "";
                if($row->home_district_id  != ''){ $home_district_id = get_district_by_id($row->home_district_id); }
                $inc_ero_standard_summary ="";
                if($row->inc_ero_standard_summary != ''){
                    $inc_ero_standard_summary = get_ero_remark($row->inc_ero_standard_summary);  
                }
                $clg_id = get_clg_data_by_ref_id($row->inc_added_by);
                                 
                $data = array(
                   // 'Sr.No' => $count,
                    'inc_ref_id' => $row->inc_ref_id,
                    'inc_recive_time' => $row->inc_recive_time,
                    'inc_datetime' => $row->inc_datetime,
                    'duration' => $duration,
                    'clr_fullname' => $row->clr_fname . ' ' . $row->clr_lname,
                    'clr_mobile' => $row->clr_mobile,
                    'clr_mobile' => $row->clr_mobile,
                    'current_district'=>$current_district,
                    'tahshil_id'=>$tahshil_id,
                    'back_hospital'=>$back_hospital,
                    'home_district_id'=>$home_district_id,
                    'inc_ero_standard_summary'=>$inc_ero_standard_summary,
                    'inc_ero_summary'=>$row->inc_ero_summary,
                    'amb1' => $amb[0],
                    'hp_name1' => $hp_name[0],
                    'enable_remark1' => $enable_remark[0],
                    'amb2' => $amb[1],
                    'hp_name2' => $hp_name[1],
                    'enable_remark2' => $enable_remark[1],
                    'amb3' => $amb[2],
                    'hp_name3' => $hp_name[2],
                    'enable_remark3' => $enable_remark[2],
                    'inc_ero_summary' => $row->inc_ero_summary,
                    'operator_id' => ucwords($row->inc_added_by),
                    'operator_name'=>$clg_id[0]->clg_first_name.' '.$clg_id[0]->clg_last_name
                );
                fputcsv($fp, $data);
                $count++;
            }

            fclose($fp);
            exit;
        }
    }
    function daily_dist_report_form() {

        $report_type = $this->input->post('dist_report_type');

        if ($report_type === '1') {
            $data['submit_function'] = "dist_amb_type_patient_served_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/date_filter_daily_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_ambulance_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "hosp_cl_type_dist_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/date_filter_daily_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_ambulance_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }

        // if ($report_type === '3') {
        //     $data['submit_function'] = "load_ambulance_distance_travel_report_form";
        //     $this->output->add_to_position($this->load->view('frontend/erc_reports/date_filter_daily_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
        //     $this->output->add_to_position('', 'Sub_ambulance_report_block_fields', TRUE);
        //     $this->output->add_to_position('', 'list_table', TRUE);
        // }
        if ($report_type === '4') {
            $data['submit_function'] = "drop_back_dist_report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/date_filter_daily_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_ambulance_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
    }
function dist_amb_type_patient_served_report(){
    $post_reports = $this->input->post();

    $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

    $base_month = $this->common_model->get_base_month($from_date);
    $this->post['base_month'] = $base_month[0]->months;

    if ($post_reports['to_date'] != '') {
        $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
            'base_month' => $this->post['base_month']);
    } else {
        $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
            'base_month' => $this->post['base_month']);
    }
    $get_district = $this->inc_model->get_district_name();
    //$data1=$this->inc_model->get_dist_amb_type();
    //var_dump($data);die; 
   // var_dump($data1['ambt_id']);die;
    $report_data=array();
    foreach( $get_district as $district){
        $fromdate = date('Y-m-d ',strtotime($post_reports['from_date']));
        $todate = date('Y-m-d ',strtotime($post_reports['to_date']));
        $today_args = array('from_date' => $fromdate,
        'to_date' => $todate,
        //'system'=> $this->input->post('system'),
        'district_id'=>$district->dst_code
    );
   //var_dump($today_args);die;
    $get_pta_patient = $this->inc_model->get_dist_pta_patient_served($today_args);
    $get_bls_patient = $this->inc_model->get_dist_bls_patient_served($today_args);
    $get_als_patient = $this->inc_model->get_dist_als_patient_served($today_args);

    
    //var_dump($get_pta_patient);die;
   $report_data[] =array(
       'dist_name' => $district->dst_name,
       'pta_type' => $get_pta_patient[0]->total_patient,
       'bls_type' => $get_bls_patient[0]->total_patient,
       'als_type' => $get_als_patient[0]->total_patient
   );


    }
    
    // var_dump($report_data);die;
        $header = array('District', 'PTA (102)', 'BLS', 'ALS', 'Total');
    

    if ($post_reports['reports'] == 'view') {


      
        $data['header'] = $header;
        $data['inc_data'] = $report_data;
        $data['report_args'] = $report_args;
    $this->output->add_to_position($this->load->view('frontend/erc_reports/dist_amb_type_patient_served_view', $data, TRUE), 'list_table', TRUE);
    }
    else{
        $filename = "daily_patient_served_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);
        $pta=0;
     $bls=0;
     $als=0;
     $grand_total=0;
    // var_dump($report_data); 
     if(isset($report_data)){
        foreach($report_data as $inc){
            //var_dump($report_data);  
             $total = $inc['pta_type'] + $inc['bls_type']+$inc['als_type'];
            $data = array ('dist_name'=>$inc['dist_name'], 
            'pta'=>$inc['pta_type'], 
            'bls'=>$inc['bls_type'], 
            'als'=>$inc['als_type'],
            'total'=>$total );
            
            $pta=$pta+$inc['pta_type'];
            $bls=$bls+$inc['bls_type'];
            $als=$als+$inc['als_type'];
            $total1=$total1+$total;

            fputcsv($fp,$data);
            $count++;
       
        }
    } 
//var_dump($total_args);
//$hi="hi";
      $total_count = array('Total',$pta,$bls,$als,$total1);
        fputcsv($fp, $total_count);
            
        fclose($fp);
        exit;
       
    
        
             
    }
}
 
function hosp_cl_type_dist_report(){
    $post_reports = $this->input->post();

    $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
    $yesterday = date( 'Y-m-d', strtotime( $post_reports['to_date'] ) );
    $base_month = $this->common_model->get_base_month($from_date);
    $this->post['base_month'] = $base_month[0]->months;

    if ($post_reports['to_date'] != '') {
        $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
            'base_month' => $this->post['base_month']);
    } else {
        $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
            'base_month' => $this->post['base_month']);
    }
    $get_district = $this->inc_model->get_district_name();
    
    $report_data=array();
    foreach( $get_district as $district){
        $fromdate = date('Y-m-d ',strtotime($post_reports['from_date']));
        $todate = date('Y-m-d ',strtotime($post_reports['to_date']));
        $today_args = array('from_date' => $fromdate,
        'to_date' => $todate,
        'district_id'=>$district->dst_code,
        'system' => '108'
    );
   //var_dump($today_args);die;
    $get_hosp_patient = $this->inc_model->get_dist_hosp_patient_served($today_args);
    $get_patient = $this->inc_model->get_district_patient_served($today_args);
     $years = date('Y', strtotime($post_reports['from_date']));
            $month= date('m', strtotime($post_reports['from_date']));
            $current_date =  $years.'-'.$month.'-'.'01';
            
    $month_args = array('from_date' => $current_date,
                'to_date' =>  date('Y-m-d',strtotime($post_reports['to_date'])),
                'district_id'=>$district->dst_code,
                'system' => '108'
            );
           // var_dump($month_args);die;
         $get_month_patient = $this->inc_model->get_district_patient_served($month_args);
            
            $total_args = array('to_date' =>  date('Y-m-d',strtotime($post_reports['to_date'])),
                'district_id'=>$district->dst_code,
                'system' => '108'
            );
        //var_dump($total_args);die;

            $get_total_patient = $this->inc_model->get_district_patient_served($total_args);

    
    //var_dump($get_pta_patient);die;
   $report_data[] =array(
       'dist_name' => $district->dst_name,
       'hosp_patient' => $get_hosp_patient[0]->total_patient,
       'patient' => $get_patient[0]->total_patient,
       'month_patient' => $get_month_patient[0]->total_patient,
       'total_patient' => $get_total_patient[0]->total_patient
   );


    }
    
    // var_dump($report_data);die;
    $header = array("District","Hospital To Hospital Patient Served ","Total Patient Served","Month Total","Since Launch");
     
    

    if ($post_reports['reports'] == 'view') {
        $data['header'] = $header;
        $data['inc_data'] = $report_data;
        $data['report_args'] = $report_args;
    $this->output->add_to_position($this->load->view('frontend/erc_reports/hosp_to_hosp_report_view', $data, TRUE), 'list_table', TRUE);
    }
    else{
        $filename = "daily_patient_served_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);
            $hosp_patient =0;
            $patient=0;
            $month=0;
            $total=0;
    // var_dump($report_data); 
     if(isset($report_data)){
        foreach($report_data as $inc){
            //var_dump($report_data);  
             
            $data = array ('dist_name'=>$inc['dist_name'], 
            'hosp_patient'=>$inc['hosp_patient'], 
            'patient'=>$inc['patient'], 
            'month_patient'=>$inc['month_patient'],
            'total_patient'=>$inc['total_patient'] );
            
            $hosp_patient= $hosp_patient + $inc['hosp_patient'];
            $patient= $patient + $inc['patient'];
            $month= $month + $inc['month_patient']; 
            $total= $total + $inc['total_patient'];

            fputcsv($fp,$data);
            $count++;
       
        }
    } 
//var_dump($total_args);
//$hi="hi";
      $total_count = array('Total',$hosp_patient,$patient,$month,$total);
        fputcsv($fp, $total_count);
            
        fclose($fp);
        exit;
            
    }
}
function drop_back_dist_report(){
    $post_reports = $this->input->post();

    $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
    $yesterday = date( 'Y-m-d', strtotime( $from_date . ' -1 day' ) );
    $base_month = $this->common_model->get_base_month($from_date);
    $this->post['base_month'] = $base_month[0]->months;

    if ($post_reports['to_date'] != '') {
        $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
            'base_month' => $this->post['base_month']);
    } else {
        $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
            'base_month' => $this->post['base_month']);
    }
    $get_district = $this->inc_model->get_district_name();
    
    $report_data=array();
    foreach( $get_district as $district){
        $fromdate = date('Y-m-d ',strtotime($post_reports['from_date']));
        $todate = date('Y-m-d ',strtotime($post_reports['to_date']));
        $today_args = array('from_date' => $fromdate,
        'to_date' => $todate,
        'district_id'=>$district->dst_code,
        'system' => '102'
    );
  // var_dump($today_args);die;
    $get_cl_count = $this->inc_model->get_dist_drop_back_cl_received($today_args);
    $get_patient = $this->inc_model->get_dist_drop_back_patient_served($today_args);

    
     $years = date('Y', strtotime($post_reports['from_date']));
            $month= date('m', strtotime($post_reports['from_date']));
            $current_date =  $years.'-'.$month.'-'.'01';
            
    $month_args = array('from_date' => $current_date,
                'to_date' =>  date('Y-m-d ',strtotime($post_reports['to_date'])),
                'district_id'=>$district->dst_code,
                'system' => '102'
            );
            //var_dump($month_args);die;
            $get_month_patient = $this->inc_model->get_dist_drop_back_patient_served($month_args);
            
            $total_args = array('to_date' => date('Y-m-d ',strtotime($post_reports['to_date'])),
                'district_id'=>$district->dst_code,
                'system' => '102'
            );
            //var_dump($total_args);die;

            $get_total_patient = $this->inc_model->get_dist_drop_back_patient_served($total_args);

    
    //var_dump($get_pta_patient);die;
   $report_data[] =array(
       'dist_name' => $district->dst_name,
       'get_cl_count' => $get_cl_count[0]->total_patient,
       'patient' => $get_patient[0]->total_patient,
       'month_patient' => $get_month_patient[0]->total_patient,
       'total_patient' => $get_total_patient[0]->total_patient
   );


    }
    
    // var_dump($report_data);die;
    $header = array("District","Call Received at 102","Drop Back Provided","Month Total","Since Launch");
     
    

    if ($post_reports['reports'] == 'view') {
        $data['header'] = $header;
        $data['inc_data'] = $report_data;
        $data['report_args'] = $report_args;
    $this->output->add_to_position($this->load->view('frontend/erc_reports/drop_back_report_view', $data, TRUE), 'list_table', TRUE);
    }
    else{
        $filename = "daily_patient_served_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);
            $get_cl_count =0;
            $patient=0;
            $month=0;
            $total=0;
    // var_dump($report_data); 
     if(isset($report_data)){
        foreach($report_data as $inc){
            //var_dump($report_data);  
             
            $data = array ('dist_name'=>$inc['dist_name'], 
            'get_cl_count'=>$inc['get_cl_count'], 
            'patient'=>$inc['patient'], 
            'month_patient'=>$inc['month_patient'],
            'total_patient'=>$inc['total_patient'] );
            
            $get_cl_count= $get_cl_count + $inc['get_cl_count'];
            $patient= $patient + $inc['patient'];
            $month= $month + $inc['month_patient']; 
            $total= $total + $inc['total_patient'];

            fputcsv($fp,$data);
            $count++;
       
        }
    } 
//var_dump($total_args);
//$hi="hi";
      $total_count = array('Total',$get_cl_count,$patient,$month,$total);
        fputcsv($fp, $total_count);
            
        fclose($fp);
        exit;
            
    }
}


    
    function response_time_reports_108(){

        $post_reports = $this->input->post();

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month']);
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month']);
        }
        $report_args['system'] = $post_reports['system'];
        


        $report_data = $this->reports_model->get_response_time($report_args);



        $header = array('Sr.No.','Incident ID','EM TYPE','Incident Date /Time','Incident Place','Incident district','Closure Date / Time','Ambulance No','Base Location','Ambulance District','Caller Name','Patient Name','Chief Complaint','Destination Hospital','Hospital District','Call Receiving Time','Disconnected Time','Start From Base','At Scene','From Scene','At Hospital','Handover Time',	'Back To Base','Response Time','Division','Area by DCO','Ambulance Area','KM','Response Time Remark','Odometer Remark');
        

        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            foreach ($report_data as $row) {

//                var_dump($row);
                if($row['inc_district_id'] != 0){
                    $incient_district = $this->inc_model->get_district_by_id($row['inc_district_id']);
                    $dst_name = $incient_district->dst_name;
                    
                    $division = get_division_district_by_id($row['inc_district_id']);
                   // var_dump($division);
                }

                $city_id = $this->inc_model->get_city_by_id($row['city_id'], $row['district_id']);
                $cty_name = $city_id->cty_name;


                $transport_respond_amb_no = $row['amb_rto_register_no'];


                $amb_arg = array('rg_no' => $row['amb_rto_register_no']);
                $amb_data = $this->amb_model->get_amb_data($amb_arg);
                //var_dump($amb_data[0]->amb_working_area);
                $amb_base_location = $amb_data[0]->hp_name;
                
                if($amb_data[0]->amb_district != 0){
                    $amb_district = $this->inc_model->get_district_by_id($amb_data[0]->amb_district);
                    $amb_dst_name = $amb_district->dst_name;
                }
                $amb_working_area = '';
                // var_dump($amb_data[0]->amb_working_area);
                if($amb_data[0]->amb_working_area != 0){
                    $amb_working_area = show_area_type_name($amb_data[0]->amb_working_area);
                    //var_dump($amb_working_area);
                }
                
                if($row['hospital_district'] != 0){
                    $hp_district = $this->inc_model->get_district_by_id($row['hospital_district']);
                    $hp_dst_name = $hp_district->dst_name;
                }
  


                //  $resonse_time = '';   
                // var_dump($resonse_time);
                if ($row['rec_hospital_name'] == '0') {
                    $hp_name = 'Other';
                } else if ($row['rec_hospital_name'] == 'Other') {
                    $hp_name = 'Other';
                } else {
                    $rec_hp_name = get_hospital_by_id($row['rec_hospital_name']);
                    $hp_name = $rec_hp_name[0]->hp_name;
                }
                $end_odometer_remark = '';
                if($row['end_odometer_remark'] != ""){
                    $end_odometer_remark=get_end_odo_remark($row['end_odometer_remark']);
                }
                $closer_date = "";
                if($row['date'] != ''){
                    $closer_date = date('Y-m-d', strtotime($row['date'])).' '.$row['time'];
                }
               
                 //var_dump($row['inc_complaint']);
                if($row['inc_complaint'] != '' && $row['inc_complaint'] != 0 && $row['inc_complaint'] != '0' ){
                    // var_dump($row['inc_mci_nature'].'hi');
                    $inc_complaint = get_cheif_complaint($row['inc_complaint']);
                }else{
                   
                    $inc_complaint = get_mci_nature_service($row['inc_mci_nature']);
                     //var_dump($inc_complaint);
                }
                if($row['end_odometer_remark'] != ''){
                    $end_odometer_remark = get_end_odo_remark($row['end_odometer_remark']);
                }
                $responce_time_remark="";
                if($row['responce_time_remark'] != '' || $row['responce_time_remark'] != Null){
                    $responce_time_remark = get_responce_time_remark($row['responce_time_remark']);
                }
                $inc_type="";
                if($row['inc_type'] != ''){
                    $inc_type= get_purpose_of_call($row['inc_type']);
                }
                

                $inc_data[] = array(
                    'inc_ref_id' => $row['inc_ref_id'],
                    'inc_type'=>$inc_type,
                    'inc_date' => $row['inc_datetime'],
                    'inc_place' =>  $row['inc_address'].' '.$row['inc_area'].' '.$row['inc_landmark'],
                    'inc_district' => $dst_name,
                    'closer_date' => $closer_date,
                    'amb_rto_register_no' => $row['amb_rto_register_no'],
                    'amb_base_location' => $amb_base_location,
                    'amb_district'=>$amb_dst_name,
                    'caller_name' => $row['clr_fname'].' '.$row['clr_lname'],
                    'patient_name' => $row['ptn_fname']." ".$row['ptn_lname'],
                    'inc_complaint' => $inc_complaint,
                    'base_location' => $hp_name,
                    'hp_district' => $hp_dst_name,
                    'inc_recive_date'=>$row['inc_recive_time'],
                    'inc_disconect_date'=>$row['inc_datetime'],
                    'start_from_base' => $row['start_from_base'],
                    'dp_on_scene' => $row['dp_on_scene'],
                    'dp_reach_on_scene' => $row['dp_reach_on_scene'],
                    'dp_hosp_time' => $row['dp_hosp_time'],
                    //'dp_started_base_loc' => $row['dp_started_base_loc'],
                    'dp_hand_time' => $row['dp_hand_time'],
                    'dp_back_to_loc' => $row['dp_back_to_loc'],
                    'responce_time' => $row['responce_time'],
                    'division'=>$division,
                    'inc_area_type'=>$row['inc_area_type'],
                    'amb_working_area'=>$amb_working_area,
                    'total_km'=>$row['total_km'],
                    'responce_time_remark' => $responce_time_remark,
                    'end_odometer_remark' => $end_odometer_remark,
                );
            }

            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/inc_108_response_time_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
           // var_dump($report_data);die();
            $filename = "closure_response_time_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            foreach ($report_data as $key=>$row) {

                $dst_name="";
                $division="";
                if($row['inc_district_id'] != 0){
                    $incient_district = $this->inc_model->get_district_by_id($row['inc_district_id']);
                    $dst_name = $incient_district->dst_name;
                    
                    $division = get_division_district_by_id($row['inc_district_id']);
                   // var_dump($division);
                }

                $city_id = $this->inc_model->get_city_by_id($row['city_id'], $row['district_id']);
                $cty_name = $city_id->cty_name;


                $transport_respond_amb_no = $row['amb_rto_register_no'];


                $amb_arg = array('rg_no' => $row['amb_rto_register_no']);
                $amb_data = $this->amb_model->get_amb_data($amb_arg);
               
                $amb_base_location = $amb_data[0]->hp_name;
                
                $amb_dst_name="";
                if($amb_data[0]->amb_district != 0){
                    $amb_district = $this->inc_model->get_district_by_id($amb_data[0]->amb_district);
                    $amb_dst_name = $amb_district->dst_name;
                }
                $amb_working_area="";
                if($amb_data[0]->amb_working_area != 0){
                    $amb_working_area = show_area_type_name($amb_data[0]->amb_working_area);
                }
                $hp_dst_name="";
                if($row['hospital_district'] != 0){
                    $hp_district = $this->inc_model->get_district_by_id($row['hospital_district']);
                    $hp_dst_name = $hp_district->dst_name;
                }
  


                //  $resonse_time = '';   
                // var_dump($resonse_time);
                if ($row['rec_hospital_name'] == '0') {
                    $hp_name = 'Other';
                } else if ($row['rec_hospital_name'] == 'Other') {
                    $hp_name = 'Other';
                } else {
                    $rec_hp_name = get_hospital_by_id($row['rec_hospital_name']);
                    $hp_name = $rec_hp_name[0]->hp_name;
                }
                $end_odometer_remark = '';
                if($row['end_odometer_remark'] != ""){
                    $end_odometer_remark=get_end_odo_remark($row['end_odometer_remark']);
                }
                $closer_date = "";
                if($row['date'] != ''){
                    $closer_date = date('Y-m-d', strtotime($row['date'])).' '.$row['time'];
                }
               
                 //var_dump($row['inc_complaint']);
                $inc_complaint = "";
                if($row['inc_complaint'] != '' && $row['inc_complaint'] != 0 && $row['inc_complaint'] != '0' ){
                    // var_dump($row['inc_mci_nature'].'hi');
                    $inc_complaint = get_cheif_complaint($row['inc_complaint']);
                }else{
                   
                    $inc_complaint = get_mci_nature_service($row['inc_mci_nature']);
                     //var_dump($inc_complaint);
                }
                $end_odometer_remark ="";
                if($row['end_odometer_remark'] != ''){
                    $end_odometer_remark = get_end_odo_remark($row['end_odometer_remark']);
                }
                $responce_time_remark = "";
                if($row['responce_time_remark'] != ''  || $row['responce_time_remark'] != Null){
                    $responce_time_remark = get_responce_time_remark($row['responce_time_remark']);
                }
                $inc_type = '';
                if($row['inc_type'] != ''){
                    $inc_type= get_purpose_of_call($row['inc_type']);
                }
                

                $inc_data = array(
                    'sr_no'=>$key+1,
                    'inc_ref_id' => $row['inc_ref_id'],
                    'inc_type'=>$inc_type,
                    'inc_date' => $row['inc_datetime'],
                    'inc_place' =>  $row['inc_address'].' '.$row['inc_area'].' '.$row['inc_landmark'],
                    'inc_district' => $dst_name,
                    'closer_date' => $closer_date,
                    'amb_rto_register_no' => $row['amb_rto_register_no'],
                    'amb_base_location' => $amb_base_location,
                    'amb_district'=>$amb_dst_name,
                    'caller_name' => $row['clr_fname'].' '.$row['clr_lname'],
                    'patient_name' => $row['ptn_fname']." ".$row['ptn_lname'],
                    'inc_complaint' => $inc_complaint,
                    'base_location' => $hp_name,
                    'hp_district' => $hp_dst_name,
                    'inc_recive_date'=>$row['inc_recive_time'],
                    'inc_disconect_date'=>$row['inc_datetime'],
                    'start_from_base' => $row['start_from_base'],
                    'dp_on_scene' => $row['dp_on_scene'],
                    'dp_reach_on_scene' => $row['dp_reach_on_scene'],
                    'dp_hosp_time' => $row['dp_hosp_time'],
                    //'dp_started_base_loc' => $row['dp_started_base_loc'],
                    'dp_hand_time' => $row['dp_hand_time'],
                    'dp_back_to_loc' => $row['dp_back_to_loc'],
                    'responce_time' => $row['responce_time'],
                    'division'=>$division,
                    'inc_area_type'=>$row['inc_area_type'],
                    'amb_working_area'=>$amb_working_area,
                    'total_km'=>$row['total_km'],
                    'responce_time_remark' => $responce_time_remark,
                    'end_odometer_remark' => $end_odometer_remark,
                );

                fputcsv($fp, $inc_data);
            }
            fclose($fp);
            exit;
        }
    }
    function consm_ambulance_report_form() {
        $report_type = $this->input->post('report_type');

        if ($report_type === '1') {
            $data['submit_function'] = "load_cons_ambulance_report_form";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_sub_report_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_ambulance_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "load_cons_amb_report_form";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_sub_report_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_ambulance_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
        if ($report_type === '3') {
            $data['submit_function'] = "load_cons_dis_report_form";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_sub_report_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_ambulance_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
    }
    
    function load_cons_ambulance_report_form() {

        $report_type = $this->input->post('amb_type');
        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "cons_export_date_wise";
            //$data['district_data'] = $this->common_model->get_district();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/hpcl_date_filter_view', $data, TRUE), 'Sub_ambulance_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "cons_export_date_wise";
           // $data['district_data'] = $this->common_model->get_district();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/hpcl_month_filter_view', $data, TRUE), 'Sub_ambulance_report_block_fields', TRUE);
        }
    }
    function load_cons_amb_report_form(){
        $report_type = $this->input->post('amb_type');
        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "amb_cons_export_date_wise";
            $data['amb_data'] = $this->common_model->get_ambulance();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/hpcl_amb_date_filter_view', $data, TRUE), 'Sub_ambulance_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "amb_cons_export_date_wise";
            $data['amb_data'] = $this->common_model->get_ambulance();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/hpcl_amb_month_filter_view', $data, TRUE), 'Sub_ambulance_report_block_fields', TRUE);
        }
    }
    function load_cons_dis_report_form(){
        $report_type = $this->input->post('amb_type');
        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "amb_cons_export_district_wise";
            $data['amb_data'] = $this->common_model->get_ambulance();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/district_cons_date_filter_view', $data, TRUE), 'Sub_ambulance_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "amb_cons_export_district_wise";
            $data['amb_data'] = $this->common_model->get_ambulance();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/district_cons_month_filter_view', $data, TRUE), 'Sub_ambulance_report_block_fields', TRUE);
        }
    }
    function cons_export_date_wise(){
        $report_args = $this->input->post();
        $post_reports = $this->input->post();
        
        $item_args = array();
        

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $to_date = date('Y-m-d', strtotime($post_reports['to_date']));
        //$to_date = date('Y-m-t', strtotime($post_reports['from_date']));
        
        $non_args = array('inv_type' => $data['preventive'][0]->mt_make,'mt_maintanance_type'=>'1');
        $invitem = $this->maintenance_part_model->get_maintenance_part_list($non_args,0,400);



        $header = array('Item Code',
            'Item Description',
           
            'Total Consuption',
           );
        
        $inc_data = array();
            foreach ($invitem as $row) {
                //var_dump($row);
                $consumed_stock =0;
                $opening_stock =0;
                $balanced_stock=0;
                $base_quantity=0;
                
                $Item_Code = $row->Item_Code;
                $item_title = $row->mt_part_title;
                $base_quantity = $row->mt_part_base_quantity;


                $cons_args = array(
                    'inv_id' => $row->mt_part_id,
                    //'inv_amb' => $post_reports['amb_reg_id'],
                    'from_date'=>$from_date,
                    'to_date'=>$to_date,
                );

                $cons_stock=get_maintance_part_stock_by_id($cons_args);
                $consumed_stock = $cons_stock[0]->out_stk;
                 $opening_stock = $cons_stock[0]->in_stk;

                $balanced_stock = $opening_stock - $consumed_stock;
                    
                    //var_dump($amb_stock);
               



                $inc_data[] = array(
                    'Item_Code' => $Item_Code,
                    'item_title' => $item_title,
                  //  'base_quantity'=>$base_quantity,
                 //   'opening_stock'=>$opening_stock,
                    'consumed_stock'=>$consumed_stock,
                 //   'balanced_stock'=>$balanced_stock,
                );
            }
            //var_dump($inc_data);

        if ($post_reports['reports'] == 'view') {

            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['function_name'] = 'cons_export_date_wise';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/amb_consumable_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "amb_consumable_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            foreach ($inc_data as $row) {

                  $items_data = array(
                    'Item_Code' => $row['Item_Code'],
                    'item_title' => $row['item_title'],
                    //'base_quantity' => $row['base_quantity']?$row['base_quantity']:0,
                   // 'opening_stock' => $row['opening_stock']?$row['opening_stock']:0,
                    'consumed_stock' => $row['consumed_stock']?$row['consumed_stock']:0,
                   // 'balanced_stock' => $row['balanced_stock']?$row['balanced_stock']:0
                   );

                fputcsv($fp, $items_data);
            }
            fclose($fp);
            exit;
        }
    }
    function amb_cons_export_date_wise(){
        $report_args = $this->input->post();
        $post_reports = $this->input->post();
        
        $item_args = array();
        

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $to_date = date('Y-m-t', strtotime($post_reports['from_date']));
        
        $non_args = array('inv_type' => $data['preventive'][0]->mt_make,'mt_maintanance_type'=>'1');
        $invitem = $this->maintenance_part_model->get_maintenance_part_list($non_args,0,400);



        $header = array('Item Code',
            'Item Description',
            'Total Consuption',
           );
        
        $inc_data = array();
            foreach ($invitem as $row) {
                //var_dump($row);
                $consumed_stock =0;
                $opening_stock =0;
                $balanced_stock=0;
                $base_quantity=0;
                
                $Item_Code = $row->Item_Code;
                $item_title = $row->mt_part_title;
                $base_quantity = $row->mt_part_base_quantity;


                $cons_args = array(
                    'inv_id' => $row->mt_part_id,
                    'inv_amb' => $post_reports['hpcl_amb'],
                    'from_date'=>$from_date,
                    'to_date'=>$to_date,
                );

               //  var_dump($cons_args);
                $cons_stock=get_maintance_part_stock_by_id($cons_args);
                 //var_dump($cons_stock);
                 // die();
                $consumed_stock = $cons_stock[0]->out_stk;
                 $opening_stock = $cons_stock[0]->in_stk;

                $balanced_stock = $opening_stock - $consumed_stock;
                    
                    //var_dump($amb_stock);
               



                $inc_data[] = array(
                    'Item_Code' => $Item_Code,
                    'item_title' => $item_title,
                  //  'base_quantity'=>$base_quantity,
                 //   'opening_stock'=>$opening_stock,
                    'consumed_stock'=>$consumed_stock,
                 //   'balanced_stock'=>$balanced_stock,
                );
            }
            //var_dump($inc_data);

        if ($post_reports['reports'] == 'view') {

            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['function_name'] = 'amb_cons_export_date_wise';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/amb_consumable_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "ambulance_consumable_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            foreach ($inc_data as $row) {

                $items_data = array(
                    'Item_Code' => $row['Item_Code'],
                    'item_title' => $row['item_title'],
                    //'base_quantity' => $row['base_quantity']?$row['base_quantity']:0,
                   // 'opening_stock' => $row['opening_stock']?$row['opening_stock']:0,
                    'consumed_stock' => $row['consumed_stock']?$row['consumed_stock']:0,
                   // 'balanced_stock' => $row['balanced_stock']?$row['balanced_stock']:0
                   );
     

                fputcsv($fp, $items_data);
            }
            fclose($fp);
            exit;
        }
    }
    function amb_cons_export_district_wise(){
        $report_args = $this->input->post();
        $post_reports = $this->input->post();
        
        $item_args = array();
        

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $to_date = date('Y-m-t', strtotime($post_reports['from_date']));
        
        $non_args = array('inv_type' => $data['preventive'][0]->mt_make,'mt_maintanance_type'=>'1');
        $invitem = $this->maintenance_part_model->get_maintenance_part_list($non_args,0,400);



        $header = array('Item Code',
            'Item Description',
            'Total Consuption',
           );
        
        $inc_data = array();
            foreach ($invitem as $row) {
                //var_dump($row);
                $consumed_stock =0;
                $opening_stock =0;
                $balanced_stock=0;
                $base_quantity=0;
                
                $Item_Code = $row->Item_Code;
                $item_title = $row->mt_part_title;
                $base_quantity = $row->mt_part_base_quantity;


                $cons_args = array(
                    'inv_id' => $row->mt_part_id,
                    'inv_district_id' => $post_reports['cons_dis'],
                    'from_date'=>$from_date,
                    'to_date'=>$to_date,
                );

               //  var_dump($cons_args);
                $cons_stock=get_maintance_part_stock_by_id($cons_args);
                 //var_dump($cons_stock);
                 // die();
                $consumed_stock = $cons_stock[0]->out_stk;
                 $opening_stock = $cons_stock[0]->in_stk;

                $balanced_stock = $opening_stock - $consumed_stock;
                    
                    //var_dump($amb_stock);
               



                $inc_data[] = array(
                    'Item_Code' => $Item_Code,
                    'item_title' => $item_title,
                  //  'base_quantity'=>$base_quantity,
                 //   'opening_stock'=>$opening_stock,
                    'consumed_stock'=>$consumed_stock,
                 //   'balanced_stock'=>$balanced_stock,
                );
            }
            //var_dump($inc_data);

        if ($post_reports['reports'] == 'view') {

            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['function_name'] = 'amb_cons_export_date_wise';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/amb_consumable_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "ambulance_consumable_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            foreach ($inc_data as $row) {

                $items_data = array(
                    'Item_Code' => $row['Item_Code'],
                    'item_title' => $row['item_title'],
                    //'base_quantity' => $row['base_quantity']?$row['base_quantity']:0,
                   // 'opening_stock' => $row['opening_stock']?$row['opening_stock']:0,
                    'consumed_stock' => $row['consumed_stock']?$row['consumed_stock']:0,
                   // 'balanced_stock' => $row['balanced_stock']?$row['balanced_stock']:0
                   );
     

                fputcsv($fp, $items_data);
            }
            fclose($fp);
            exit;
        }
    }
        function fuel_report(){
        $post_reports = $this->input->post();
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $to_data = date('Y-m-d', strtotime($post_reports['to_date']));
        $system = $post_reports['system'];
        
         $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'system' => $system
            );
        
        $report_data = $this->amb_model->fuel_report($report_args);

        if($report_data){
        foreach ($report_data as $key=>$report) {
            $sr_no = $key+1;
          
            $fuel_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'amb_rto' => $report->amb_rto_register_no
            );
            
            $report_fuel_data = $this->amb_model->get_fuel_odometer($fuel_args);
            
           
            
            $fuel_fillling = $this->amb_model->get_fuel_filling($fuel_args);
            
            $hpcl_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'amb_rto' => $report->bvg_series
            );
            $hpcl_data = $this->amb_model->get_fuel_hpcl_data($hpcl_args);
            
            
            $base_location_name = "";
                if($report->amb_base_location != ''){
                $base_location = get_base_location_by_id($report->amb_base_location);
                $base_location_name = $base_location[0]->hp_name;
                }
                 $dist_name = "";
                if($report->amb_district != ''){
                    $dist_name = get_district_by_id($report->amb_district);
                    $div_name = get_division_district_by_id($report->amb_district);
                }
                
                
                $total_km = (int)$report_fuel_data[0]->end_odmeter - (int)$report_fuel_data[0]->start_odmeter;
                $fuel_rate =0;
                $kmpl=0;
                if($fuel_fillling[0]->ff_fuel_quantity > 0){
                    $fuel_rate = ((int)$fuel_fillling[0]->ff_amount)/((int)$fuel_fillling[0]->ff_fuel_quantity);
                    $kmpl = $total_km/((int)$fuel_fillling[0]->ff_fuel_quantity);
                }
                
                //$kmpl = $total_km/((int)$fuel_fillling[0]->ff_fuel_quantity);
                $differencet=(int)$hpcl_data[0]->hpcl_amount-(int)$fuel_fillling[0]->ff_amount;
                
           $row[] = array(
                'sr_no' => $sr_no,
                'card_no' => $report->bvg_series,
                'state' =>$report->amb_rto_register_no,
                'division' =>$div_name,
                'district' => $dist_name,
                'base_location_name' => $base_location_name,
                'vahicle_make' => $report->vahicle_make,
                'start_odmeter' => $report_fuel_data[0]->start_odmeter?$report_fuel_data[0]->start_odmeter:0,
                'end_odmeter' => $report_fuel_data[0]->end_odmeter?$report_fuel_data[0]->end_odmeter:0,
                'total_km' =>$total_km,
                'ff_fuel_quantity' => $fuel_fillling[0]->ff_fuel_quantity?round($fuel_fillling[0]->ff_fuel_quantity,2):0,
                'fuel_rate' => round($fuel_rate,2),
                'ff_amount' => $fuel_fillling[0]->ff_amount?$fuel_fillling[0]->ff_amount:0,
                'kmpl' => round($kmpl,2),
                'aom' => $report->aom_name,
                'hpcl' => $hpcl_data[0]->hpcl_amount?$hpcl_data[0]->hpcl_amount:0,
                'difference'=> $differencet
               
            );
        }
        }
       

        $header = array('Sr No','Card No.','Ambulance No','Division','District','Base Location','Vehicle Make','Start Odometer',  'End Odometer','Total Km','Fuel Consumption Ltr','Fuel Rate','Amount','KMPL',	'AOM','HPCL','Difference');

        if ($post_reports['reports'] == 'view') {
            $data['header'] = $header;
            $data['hpcl_data'] = $row;
            $data['report_args'] = $report_args;
            $data['submit_function']='fuel_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/fuel_report', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "fuel_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
          
            if($row){
            foreach ($row as $key=>$report) {
                 
           $inc_data = array(
                'sr_no' => $report['sr_no'],
                'card_no' => $report['card_no'],
                'state' =>$report['state'],
                'division' =>$report['division'],
                'district' => $report['district'],
                'base_location_name' => $report['base_location_name'],
                'vahicle_make' => $report['vahicle_make'],
                'start_odmeter' => $report['start_odmeter'],
                'end_odmeter' => $report['end_odmeter'],
                'total_km' =>$report['total_km'],
                'ff_fuel_quantity' => $report['ff_fuel_quantity'],
                'fuel_rate' => $report['fuel_rate'],
                'ff_amount' => $report['ff_amount'],
                'kmpl' => $report['kmpl'],
                'aom' => $report['aom'],
                'hpcl' => $report['hpcl'],
                'difference' => $report['difference'],
            );
                fputcsv($fp, $inc_data);
               
            }
            
          
        }
            
            fclose($fp);
            exit;
        }
    }
    function vahicle_fuel_report(){
        $post_reports = $this->input->post();
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $to_data = date('Y-m-d', strtotime($post_reports['to_date']));
        $system = $post_reports['system'];
        
         $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'system' => $system
            );
        $date_range = $this->getDatesFromRange($from_date, $to_data, $format = 'Y-m-d');
        $report_data = $this->amb_model->fuel_report($report_args);

        foreach ($report_data as $key=>$report) {
            $sr_no = $key+1;
          

            
            $base_location_name = "";
                if($report->amb_base_location != ''){
                $base_location = get_base_location_by_id($report->amb_base_location);
                $base_location_name = $base_location[0]->hp_name;
                }
                 $dist_name = "";
                if($report->amb_district != ''){
                    $dist_name = get_district_by_id($report->amb_district);
                    $div_name = get_division_district_by_id($report->amb_district);
                }
                
                
                $total_km = (int)$report_fuel_data[0]->end_odmeter - (int)$report_fuel_data[0]->start_odmeter;
                $fuel_rate =0;
                $kmpl=0;
                if($fuel_fillling[0]->ff_fuel_quantity > 0){
                    $fuel_rate = ((int)$fuel_fillling[0]->ff_amount)/((int)$fuel_fillling[0]->ff_fuel_quantity);
                    $kmpl = $total_km/((int)$fuel_fillling[0]->ff_fuel_quantity);
                }
                
                //$kmpl = $total_km/((int)$fuel_fillling[0]->ff_fuel_quantity);
                $differencet=(int)$hpcl_data[0]->hpcl_amount-(int)$fuel_fillling[0]->ff_amount;
                
           $data = array(
                'sr_no' => $sr_no,
                'card_no' => $report->bvg_series,
                'state' =>$report->amb_rto_register_no,
                'division' =>$div_name,
                'district' => $dist_name,
                'base_location_name' => $base_location_name,
                'vahicle_make' => $report->vahicle_make,
            );
           $sum_fcr = 0;
           foreach($date_range as $range_d){
            $fuel_args = array('from_date' => date('Y-m-d', strtotime($range_d)),
                'to_date' => date('Y-m-d', strtotime($range_d)),
                'amb_rto' => $report->amb_rto_register_no
            );
            
            $fuel_fillling = $this->amb_model->get_fuel_filling($fuel_args);
            $data[$range_d.'_fcr']=((int)$fuel_fillling[0]->ff_amount);
            $sum_fcr = $sum_fcr+((int)$fuel_fillling[0]->ff_amount);
                    
            
//            $hpcl_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
//                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
//                'amb_rto' => $report->bvg_series
//            );
//            $hpcl_data = $this->amb_model->get_fuel_hpcl_data($hpcl_args);
            
            }
            $data['sum_fcr']=$sum_fcr;
            
            $sum_hpcl = 0;
            foreach($date_range as $range_d){

                $hpcl_args = array('from_date' => date('Y-m-d', strtotime($range_d)),
                    'to_date' => date('Y-m-d', strtotime($range_d)),
                    'amb_rto' => $report->bvg_series
                );
                $hpcl_data = $this->amb_model->get_fuel_hpcl_data($hpcl_args);
                $data[$range_d.'_hpcl']=((int)$hpcl_data[0]->hpcl_amount);
                $sum_hpcl = $sum_hpcl+((int)$hpcl_data[0]->hpcl_amount);
            
            }
            $data['sum_hpcl']=$sum_hpcl;
            $data['difference']=$sum_hpcl-$sum_fcr;
            
           $row[] = $data;
        }
       

        $header = array('Sr No','Card No.','Ambulance No','Division','District','Base Location','Vehicle Make');

      
        foreach( $date_range as $range){
            $header[]=$range.' FCR';
        }
        $header[]= 'Sum Of FCR';
        foreach( $date_range as $range){
            $header[]=$range.' HPCL';
        }
        $header[]= 'Sum Of HPCL';
        $header[]= 'Difference';
          
       
        
        if ($post_reports['reports'] == 'view') {
            $data['header'] = $header;
            $data['hpcl_data'] = $row;
            $data['report_args'] = $report_args;
            $data['date_range'] = $date_range;
            $data['submit_function']='vahicle_fuel_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/vahicle_fuel_report', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "fuel_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
          
            if($row){
            foreach ($row as $key=>$report) {
                 
           $inc_data = array(
                'sr_no' => $report['sr_no'],
                'card_no' => $report['card_no'],
                'state' =>$report['state'],
                'division' =>$report['division'],
                'district' => $report['district'],
                'base_location_name' => $report['base_location_name'],
                'vahicle_make' => $report['vahicle_make'],
            );
            foreach($date_range as $range_d){ 
             $inc_data[$range_d.'_fcr'] = $report[$range_d.'_fcr'];
            }
            $inc_data['sum_fcr'] =$report['sum_fcr'];
            foreach($date_range as $range_d){
             $inc_data[$range_d.'_hpcl']= $report[$range_d.'_hpcl'];
            } 
            $inc_data['sum_hpcl'] = $report['sum_hpcl']; 
            $inc_data['difference'] = $report['difference']; 
            fputcsv($fp, $inc_data);
               
            }
            
          
        }
            
            fclose($fp);
            exit;
        }
    }
    function getDatesFromRange($start, $end, $format = 'Y-m-d') {
      
        // Declare an empty array
        $array = array();

        // Variable that store the date interval
        // of period 1 day
        $interval = new DateInterval('P1D');

        $realEnd = new DateTime($end);
        $realEnd->add($interval);

        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

        // Use loop to store date into array
        foreach($period as $date) {                 
            $array[] = $date->format($format); 
        }

        // Return the array elements
        return $array;
    }
    function dco_validation_report(){
                $post_reports = $this->input->post();
        $from_date = date('Y-m-d  H:i:00', strtotime($post_reports['from_date']));
        $to_data = date('Y-m-d  H:i:00', strtotime($post_reports['to_date']));
        $system = $post_reports['system'];
        
         $report_args = array('from_date' => date('Y-m-d  H:i:00', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d  H:i:00', strtotime($to_data)),
                'system' => $system
            );
        $date_range = $this->getDatesFromRange($from_date, $to_data, $format = 'Y-m-d');
        $report_data = $this->pcr_model->dco_validation_report($report_args);
      
        $validate_count = array();
        foreach ($report_data as $key=>$report) {
            if(isset($validate_count[$report->clg_ref_id])){
                $validate_count[$report->clg_ref_id] ++;
            }else{
                $validate_count[$report->clg_ref_id] =1;
            }
            
            

           $report_dco_vali[$report->clg_ref_id] = array('dco_name'=> $report->clg_first_name.' '.$report->clg_last_name,'clg_ref_id'=>$report->clg_ref_id,'validation_count'=>$validate_count[$report->clg_ref_id]);
           
  
        }
      
        
     

        $header = array('DCO Name',	date('d-m-Y H:i:00', strtotime($post_reports['from_date'])).' To '.	date('d-m-Y  H:i:00', strtotime($post_reports['to_date'])),'Grand Total');

        if ($post_reports['reports'] == 'view') {
            $data['header'] = $header;
            $data['hpcl_data'] = $report_dco_vali;
            $data['report_args'] = $report_args;
            $data['date_range'] = $date_range;
            $data['submit_function']='dco_validation_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/dco_validation_report', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "dco_validation_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
          
            if($report_dco_vali){
            foreach ($report_dco_vali as $key=>$report) {
                 
           $inc_data = array(
                'dco_name' => $report['dco_name'],
                'validation_count' =>$report['validation_count'],
                'validation_grand' =>$report['validation_count'],
            );
            fputcsv($fp, $inc_data);
               
            }
            
          
        }
            
            fclose($fp);
            exit;
        }
    }
  
        function load_amb_audit_date(){
        $post_reports = $this->input->post();
        $args = array('ambulance_no'=>$post_reports['amb_no']);
       
        $data['ambulance'] = $this->biomedical_model->get_equipment_audit($args);
         $this->output->add_to_position($this->load->view('frontend/erc_reports/audit_date_outer', $data, TRUE), 'audit_date_outer', TRUE);
    }
        function indent_dispatch_receive(){
        
        $post_reports = $this->input->post();
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $to_data = date('Y-m-d', strtotime($post_reports['to_date']));
        $system = $post_reports['system'];
      
        
        $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'system' => $system,
                'item_type'=>$post_reports['item_type']
            );
        $header = array('S.No.','Req. By Ambulance No','Req. By Base Location','District','Item Type','Item name','Req. Quantity','Request Date','Dispatch Quantity','Dispatch date','Receive Quantity','Receive date');
        
        $indent_data = $this->fleet_model->get_report_indent_item_data($report_args);
       
        
        
          if ($post_reports['reports'] == 'view') {
              
            $data['header'] = $header;
            $data['hpcl_data'] = $indent_data;
            $data['report_args'] = $report_args;
            $data['submit_function']='indent_dispatch_receive';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/indent_dispatch_receive_view', $data, TRUE), 'list_table', TRUE);
            
        } else {
              $filename = "Indent_Request_dispatch_and_receive_Report .csv";
              $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
                        
            if($indent_data){

            foreach ($indent_data as $key=>$report) {

                
                $item_name = get_inv_name(array('inv_id'=>$report->ind_item_id,'inv_type'=>$report->ind_item_type));
                $inc_data = array(
                     'sr_no' => $key+1,
                     'req_amb_reg_no' =>$report->req_amb_reg_no,
                     'hp_name' => $report->hp_name,
                     'dst_name' =>$report->dst_name,
                    'ind_item_type' =>$report->ind_item_type,
                    'item_name' =>$item_name,
                    'ind_quantity' =>$report->ind_quantity,
                    
                    'req_date' =>$report->req_date,
                    'ind_dis_qty' =>$report->ind_dis_qty,
                    'req_dis_date' =>$report->req_dis_date,
                    'ind_rec_qty' =>$report->ind_rec_qty,
                    'req_rec_date' =>$report->req_rec_date,
                );
           
               fputcsv($fp, $inc_data);
               
            }
          
            
          
        }
            
            fclose($fp);
            exit;
        }
        
    }
    function amb_biomedical_audit(){
        $data['ambulance'] = $this->biomedical_model->get_equipment_audit_amb($data);
           
        $data['submit_function'] = "boimedical_audit_report";
        $data['report_name'] = "Ambulance Biomedical Audit report";
           
        $this->output->add_to_position($this->load->view('frontend/erc_reports/amb_biomedical_audit_view', $data, TRUE), $output_position, TRUE);
    }
    function boimedical_audit_report(){
        $post_reports = $this->input->post();
        $data['report_args'] = $post_reports;
        $args = array('ambulance_no'=>$post_reports['amb_no'],'current_audit_date'=>$post_reports['audit_date']);
      //  var_dump($args);
        $data['ambulance'] = $ambulance = $this->biomedical_model->get_equipment_audit($args)[0];
        $args_item = array('req_id'=>$data['ambulance']->id);
        $data['audit_item'] = $audit_item= $this->biomedical_model->get_equipment_audit_item($args_item);
        $data['header'] =$header = array('Audited By','Ambulance Number','Audit Date','District','Base Location','Ambulance Type','EMT Name','Pilot Name');
        
        $data['second_header']= $second_header = array('Sr.No.','Item Name','Availability','Working Status','Damage Broken','Not Working Reason','Damage Reason','Other Remark');

         
       
        
         if ($post_reports['reports'] == 'view') {
              
    
            $data['report_args'] = $report_args;
            $data['submit_function']='boimedical_audit_report';
             $this->output->add_to_position($this->load->view('frontend/erc_reports/amb_biomedical_audit_report_view', $data, TRUE), 'list_table', TRUE);
            
        } else {
              $filename = "Ambulance_Biomedical_Audit_report .csv";
              $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);
            
            $header_result = array(get_clg_name_by_ref_id($ambulance->added_by),$ambulance->ambulance_no,$ambulance->current_audit_date,get_district_by_id($ambulance->district_id),$ambulance->base_location,show_amb_type_name($ambulance->ambulance_type),$ambulance->emt_name,$ambulance->pilot_name);
            
            fputcsv($fp, $header_result);
            fputcsv($fp, $second_header);

            $inc_data = array();
                        
            if($audit_item){

            foreach ($audit_item as $key=>$report) {
                $inc_data = array(
                    'sr_no' => $key+1,
                    'item_name' => $report->item_name,
                    'availability' => $report->availability,
                    'working_status' =>$report->working_status,
                    'damage_broken' =>$report->damage_broken,
                    'not_working_reason' =>$report->not_working_reason,
                    'damage_reason' =>$report->damage_reason,
                    'other_remark' =>$report->other_remark,
                    
                );
 
               fputcsv($fp, $inc_data);
               
            }
          
            
          
        }
            
            fclose($fp);
            exit;
        }
        
    }
    function load_boi_summary_type(){
        $post_reports = $this->input->post();
        $report_type=$post_reports['boi_summary_type'];
         $data['report_name'] = "Ambulance Biomedical Audit Summary report";
         $data = array();
          if ($report_type === 'district_wise') {
               $data['submit_function'] = "amb_boi_audit_district_report";
               $data['district_data'] = $this->common_model->get_district(array('st_id'=>'MP'));
               $this->output->add_to_position($this->load->view('frontend/erc_reports/hpcl_month_filter_view', $data, TRUE), 'boi_summary_type', TRUE);
          }
  
          if ($report_type === 'month_wise') {
              $data['submit_function'] = "amb_boi_audit_month_report";
              $data['all_provide_imp'] = $this->call_model->get_all_provide_imp();
              $this->output->add_to_position($this->load->view('frontend/erc_reports/hpcl_month_filter_view', $data, TRUE), 'boi_summary_type', TRUE);
          }
        
    }
    
    function amb_boi_audit_month_report(){
        $post_reports = $this->input->post();
        
      
        $data['report_args'] = $post_reports;
        $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'get_count' =>true
            );
        $data['ambulance'] = $ambulance = $this->biomedical_model->get_equipment_audit($report_args);
      
      
        $data['header'] =$header = array('Month','Count of Ambulance Audit updated in application');
        
        $data['data_value'] =date('F', strtotime($report_args['from_date'])).'-'.date('Y', strtotime($report_args['from_date']));

        if ($post_reports['reports'] == 'view') {
              
    
            $data['report_args'] = $report_args;
            $data['submit_function']='amb_boi_audit_month_report';
             $this->output->add_to_position($this->load->view('frontend/erc_reports/amb_biomedical_audit_summary_report_view', $data, TRUE), 'list_table', TRUE);
            
        } else {
              $filename = "Ambulance_Biomedical_Audit_Month_Summary_report .csv";
              $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);
            
            $inc_data = array();
                        
            
                $inc_data = array(
                    'sr_no' => date('F', strtotime($report_args['from_date'])).'-'.date('Y', strtotime($report_args['from_date'])),
                    'item_name' => $data['ambulance'] ,
                    
                    
                );
 
               fputcsv($fp, $inc_data);
               
           
            
            fclose($fp);
            exit;
        }
    }
    
    function amb_boi_audit_district_report(){
        
        $post_reports = $this->input->post();
        
        $track_args = array('trk_report_name'=>'Ambulance Biomedical Audit Summary report District wise','trk_download_by'=>$this->clg->clg_ref_id);
        track_report_download($track_args);
        
      
        $data['report_args'] = $post_reports;
        
        $district_data = $this->common_model->get_district();
        
        $data['header'] = $header = array('District','Count of Ambulance Audit updated in application');
        
        foreach($district_data as $district){
           
        
        $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'get_count' =>true,
                'district'=>$district->dst_code
            );
        $ambulance = $this->biomedical_model->get_equipment_audit($report_args);
    

        $district_name =$district->dst_name;
        
        
        $inc_data[] = array(
            'district_name'=>$district_name,
            'count'=>$ambulance);
        
        
        }
    
        
        if ($post_reports['reports'] == 'view') {
              
    
            $data['report_args'] = $report_args;
            $data['submit_function']='amb_boi_audit_district_report';
            $data['inc_data'] = $inc_data;
             $this->output->add_to_position($this->load->view('frontend/erc_reports/amb_biomedical_audit_dis_summary_report_view', $data, TRUE), 'list_table', TRUE);
            
        } else {
              $filename = "Ambulance_Biomedical_Audit_District_Summary_report .csv";
              $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);
            
            $total = 0;
            foreach($inc_data as $inc){
                        
            
                $inc_data = array(
                    'district_name' => $inc['district_name'],
                    'count' => $inc['count'] 
                );
                $total = $total+$inc['count'];
 
               fputcsv($fp, $inc_data);
            }
            
            $total_data = array('Total',$total);
             fputcsv($fp, $total_data);
               
           
            
            fclose($fp);
            exit;
        }
    }
     function closure_validation_dco_report() {

        $post_reports = $this->input->post();
        
        $track_args = array('trk_report_name'=>'Closure Validation Report Incident datewise','trk_download_by'=>$this->clg->clg_ref_id);
        track_report_download($track_args);

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        // $to_date = date('Y-m-d H:i:00', strtotime($post_reports['to_date']));


        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        $thirdparty = $this->clg->thirdparty;
        $district = $this->clg->clg_district_id;
        $clg_district_id = json_decode($district);
        if(is_array($clg_district_id)){
            $district_id = implode("','",$clg_district_id);
        }


        if ($post_reports['to_date'] != '') {
            $report_args = array('validation_from_date' => date('Y-m-d H:i:s', strtotime($post_reports['from_date'])),
                'validation_to_date' => date('Y-m-d H:i:s', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
                'thirdparty' => $thirdparty,
                'system' => $post_reports['system'],
                'clg_district_id' => $district_id );
        } else {
            $report_args = array('validation_from_date' => date('Y-m-d H:i:s', strtotime($post_reports['from_date'])),
                'validation_to_date' => date('Y-m-d H:i:s', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                'thirdparty' => $thirdparty,
                'system' => $post_reports['system'],
                'clg_district_id' => $district_id );
        }


        $report_data = $this->inc_model->get_validation_report($report_args);
        
        
      // var_dump($report_data);
       //die();

       
        $header = array('Sr.No',
              'Incident ID',
            'Validation Done by','Validation Date time');

        if ($post_reports['reports'] == 'view') {

            $inc_data = array();
            foreach ($report_data as $row) {


                $inc_data[] = array(
                    'inc_ref_id' => $row->inc_ref_id,
                    'validation_done'=>$row->clg_first_name.' '.$row->clg_last_name,
                    'validate_date'=>$row->validate_date,     
                );
            }

            
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'closure_validation_dco_report';

            $this->output->add_to_position($this->load->view('frontend/erc_reports/inc_closure_validation_report_view', $data, TRUE), 'list_table', TRUE);
        } else {
           // var_dump($report_data);die();
            $filename = "closure_validation_dco_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            $count=1;
            foreach ($report_data as $row) {
                
           
                $inc_data = array(
                    'sr_no' =>$count,
                    'inc_ref_id' => $row->inc_ref_id,
                    'validation_done'=>$row->clg_first_name.' '.$row->clg_last_name,
                    'validate_date'=>$row->validate_date,     
                );

                fputcsv($fp, $inc_data);
                $count++;
            }
            fclose($fp);
            exit;
        }
    }
        function bpcl_ambulance_report_form() {
        $report_type = $this->input->post('report_type');

        if ($report_type === '1') {
            $data['submit_function'] = "load_bpcl_ambulance_report_form";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_sub_report_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_ambulance_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "load_bpcl_amb_report_form";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_sub_report_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_ambulance_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
    }
    function load_bpcl_ambulance_report_form() {

        $report_type = $this->input->post('amb_type');
        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "bpcl_export_date_wise";
            //$data['district_data'] = $this->common_model->get_district();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/bpcl_date_filter_view', $data, TRUE), 'Sub_ambulance_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "bpcl_export_date_wise";
           // $data['district_data'] = $this->common_model->get_district();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/bpcl_month_filter_view', $data, TRUE), 'Sub_ambulance_report_block_fields', TRUE);
        }
    }
    function load_bpcl_amb_report_form(){
        $report_type = $this->input->post('amb_type');
        $data = array();
        if ($report_type === '1') {
            $data['submit_function'] = "amb_bpcl_export_date_wise";
            $data['amb_data'] = $this->common_model->get_ambulance();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/bpcl_amb_date_filter_view', $data, TRUE), 'Sub_ambulance_report_block_fields', TRUE);
        }

        if ($report_type === '2') {
            $data['submit_function'] = "amb_bpcl_export_date_wise";
            $data['amb_data'] = $this->common_model->get_ambulance();
            $this->output->add_to_position($this->load->view('frontend/erc_reports/bpcl_amb_month_filter_view', $data, TRUE), 'Sub_ambulance_report_block_fields', TRUE);
        }
    }
    function amb_bpcl_export_date_wise(){
        $post_reports = $this->input->post();
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $to_data = date('Y-m-d', strtotime($post_reports['from_date']));
        $hpcl_amb = $post_reports['hpcl_amb'];
        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
                'hpcl_amb' => $hpcl_amb
            );
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month'],
                'hpcl_amb' => $hpcl_amb
            );
        }
        //var_dump($report_args);die();
        $report_data = $this->bpcl_model->get_bpcl_amb_details($report_args);
        
        foreach ($report_data as $report) {
            //var_dump($report);
             $base_location_name = "";
                if($report['amb_base_location'] != ''){
                $base_location = get_base_location_by_id($report['amb_base_location']);
                $base_location_name = $base_location[0]->hp_name;
                }
                 $dist_name = "";
                if($report['amb_district'] != ''){
                $dist_name = get_district_by_id($report['amb_district']);
                
                }
           $row[] = array(
                     'bpcl_id' => $report['bpcl_id'],
                    'amb_rto_register_no' => $report['amb_rto_register_no'],
                    'base_location_name' => $base_location_name,
                    'dist_name' => $dist_name,
                    'cardId' => $report['cardId'],
                    'cardName' => $report['cardName'],
                    'roName' => $report['roName'],
                    'createdDT' => $report['createdDT'],
                    'product' => $report['product'],     
                    'rate' => $report['rate'],
                    'volume' => $report['volume'],
                    'amount' => $report['amount'],
                    'odometer_reading' => '-',
                    'added_date' => $report['added_date'],
                    
                );
        }

//    $header = array(
//            'bpcl_id',
//            'Ambulance Reg. Number',
//            'Base Location',
//            'District',
//            "accountEntry","amount","createdDT","product","closingBalance","walletName","employeeId","mobileNumber","paymentIPS","petromilesEarned","rate","roContact","roLocation","transactionId","unit","vehicleNumber","transactionType","volume","walletType","cardId","cardName","roCity","roName");
    
        $header = array('bpcl_id','Ambulance Reg. Number','Base Location','District','Card Number','Card Name','RO Name','Created Date','Product','Rate','Volume','Amount','Odometer Reading','Added Date');
        if ($post_reports['reports'] == 'view') {
            $data['header'] = $header;
            $data['result'] = $row;
            $data['submit_function']='amb_bpcl_export_date_wise';
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/bpcl_report_detail_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "Bpcl_Report_Ambulance_wise.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

           // $inc_data = array();
           if($report_data){
               $volume = 0;
               $Amount = 0;
               
            foreach ($report_data as $report) {
                

                $volume =$volume+$report['volume'];
                $Amount =$Amount+$report['amount'];
                $inc_data =array(
                    'bpcl_id' => $report['bpcl_id'],
                    'amb_rto_register_no' => $report['amb_rto_register_no'],
                    'base_location_name' => $base_location_name,
                    'dist_name' => $dist_name,
                    'cardId' => $report['cardId'],
                    'cardName' => $report['cardName'],
                    'roName' => $report['roName'],
                    'createdDT' => $report['createdDT'],
                    'product' => $report['product'],     
                    'rate' => $report['rate'],
                    'volume' => $report['volume'],
                    'amount' => $report['amount'],
                    'odometer_reading' => '-',
                    'added_date' => $report['added_date'],
                );

                fputcsv($fp, $inc_data);
            }
            
             $total = array('','','','','','','','','','Total',$volume,$Amount,'','');
             fputcsv($fp, $total);
           
            
        }else{

            }
            fclose($fp);
            exit;
        }
    }
    function bpcl_export_date_wise(){
        $post_reports = $this->input->post();
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $to_data = date('Y-m-t', strtotime($post_reports['from_date']));
       // var_dump($to_data);die();
        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month']
            );
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month']
            );
        }
        $report_data = $this->bpcl_model->get_bpcl_amb_details($report_args);
        foreach ($report_data as $report) {
             
            $base_location_name = "";
                if($report['amb_base_location'] != ''){
                $base_location = get_base_location_by_id($report['amb_base_location']);
                $base_location_name = $base_location[0]->hp_name;
                }
                 $dist_name = "";
                if($report['amb_district'] != ''){
                $dist_name = get_district_by_id($report['amb_district']);
                
                }
           $row[] = array(
                    'bpcl_id' => $report['bpcl_id'],
                    'amb_rto_register_no' => $report['amb_rto_register_no'],
                    'base_location_name' => $base_location_name,
                    'dist_name' => $dist_name,
                    'cardId' => $report['cardId'],
                    'cardName' => $report['cardName'],
                    'roName' => $report['roName'],
                    'createdDT' => $report['createdDT'],
                    'product' => $report['product'],     
                    'rate' => $report['rate'],
                    'volume' => $report['volume'],
                    'amount' => $report['amount'],
                    'odometer_reading' => '-',
                    'added_date' => $report['added_date'],
                    
                );
        }

       $header = array('bpcl_id','Ambulance Reg. Number','Base Location','District','Card Number','Card Name','RO Name','Created Date','Product','Rate','Volume','Amount','Odometer Reading','Added Date');
        
        
        if ($post_reports['reports'] == 'view') {
            $data['header'] = $header;
            $data['result'] = $row;
            $data['report_args'] = $report_args;
            $data['submit_function']='bpcl_export_date_wise';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/bpcl_report_detail_view', $data, TRUE), 'list_table', TRUE);
        } else {
            $filename = "Bpcl_Report_date_wise.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $inc_data = array();
            if($report_data){
                $volume = 0;
                $Amount= 0;
                $Price = 0;
            foreach ($report_data as $report) {
                  $volume =$volume+$report['volume'];
                $Amount =$Amount+$report['amount'];
                $base_location_name = "";
                if($report['amb_base_location'] != ''){
                $base_location = get_base_location_by_id($report['amb_base_location']);
                $base_location_name = $base_location[0]->hp_name;
                }
                 $dist_name = "";
                if($report['amb_district'] != ''){
                $dist_name = get_district_by_id($report['amb_district']);
                
                }
                
                 
                 
                $inc_data = array(
                    'bpcl_id' => $report['bpcl_id'],
                    'amb_rto_register_no' => $report['amb_rto_register_no'],
                    'base_location_name' => $base_location_name,
                    'dist_name' => $dist_name,
                    'cardId' => $report['cardId'],
                    'cardName' => $report['cardName'],
                    'roName' => $report['roName'],
                    'createdDT' => $report['createdDT'],
                    'product' => $report['product'],     
                    'rate' => $report['rate'],
                    'volume' => $report['volume'],
                    'amount' => $report['amount'],
                    'odometer_reading' => '-',
                    'added_date' => $report['added_date'],
                    
                );
                fputcsv($fp, $inc_data);
               
            }
               $total = array('','','','','','','','','','Total',$volume,$Amount,'','');
             fputcsv($fp, $total);
            
     
        }else{

            }
            
            fclose($fp);
            exit;
        }
    }
    function base_location_report()
    {
        $data['dist'] = $this->common_model->get_district(array('st_id' => 'MP'));
        // $data['basedata'] = $this->reports_model->   ();
        $this->output->add_to_position($this->load->view('frontend/reports/base_location_report_view', $data, TRUE), $output_position, TRUE);
    }
    function base_loc()
    {
        // $post_reports = $this->input->post();
        $amb_district =  $this->input->post('amb_district');
        // $system =  $this->input->post('system');
        $args = array('district_id' => $amb_district);

        $data['basedata'] = $this->reports_model->get_base_loc_data($args);

        $new_data = $data['basedata'];
        echo json_encode($new_data);
        die();
    }

    function base_location_report_download()
    {

        $amb_district =  $this->input->post('getdist');
        $system =  $this->input->post('getsys');

        // var_dump($amb_district);die();  
        $args = array('district_id' => $amb_district, 'system' => $system);

        $report_data = $this->reports_model->get_base_loc_data($args);

        $header = array('Sr.No','Base Location Name', 'Mobile Number', 'Working Area', 'Base Location Type', 'System Type', 'GeoFence Area', 'Base Location Category', 'Address', 'State', 'District', 'Tehshil', 'City', 'Area/Locality', 'Landmark', 'Lane/Street', 'Pin Code', 'Latitude', 'Longitude', 'Contact Person Name', 'Contact Person Mobile Number', 'Email ID', 'DM Name', 'Added By', 'Added Date');


        $filename = "base_location_report.csv";
        $fp = fopen('php://output', 'w');
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        fputcsv($fp, $header);

        $count = 1;

        foreach ($report_data as $row) {


            $data = array(
                'Sr.No'  =>$count,
                'dhp_name' => $row->hp_name,
                'dhp_mobile' => $row->hp_mobile,
                'dar_name' => $row->ar_name,
                'dfull_name' => $row->full_name,
                'dhp_system' => $row->hp_system,
                'dgeo_fence' => $row->geo_fence,
                'dhp_register_no' => $row->hp_register_no,
                'dhp_address' => $row->hp_address,
                'dst_name' => $row->st_name,
                'ddst_name' => $row->dst_name,
                'dthl_name' => $row->thl_name,
                'dcty_name' => $row->cty_name,
                'dhp_area' => $row->hp_area,
                'dhp_lmark' => $row->hp_lmark,
                'dhp_lane_street' => $row->hp_lane_street,
                'dhp_pincode' => $row->hp_pincode,
                'dhp_lat' => $row->hp_lat,
                'dhp_long' => $row->hp_long,
                'dhp_contact_person' => $row->hp_contact_person,
                'dhp_contact_mobile' => $row->hp_contact_mobile,
                'dhp_email' => $row->hp_email,
                'dhp_adm' => $row->hp_adm,
                'dhp_added_by' => $row->base_added_by,
                'dhp_added_date' => $row->base_added_date
            );

            fputcsv($fp, $data);
            $count++;
        }

        fclose($fp);
        exit;
    }
    function load_response_time_report_form(){
        $post_reports = $this->input->post();
        $to_data = date('Y-m-t', strtotime($post_reports['from_date']));
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
       
        if ($post_reports['to_date'] != '' && $post_reports['from_date'] !='') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month']);
        }
        if ($post_reports['to_date'] != '' && $post_reports['from_date'] !='') {
            $report_args1 = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'amb_type' => '3',
                'base_month' => $this->post['base_month']);
        }
        if ($post_reports['to_date'] != '' && $post_reports['from_date'] !='') {
            $report_args2 = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'amb_type' => '2',
                'base_month' => $this->post['base_month']);
        }
        if ($post_reports['to_date'] != '' && $post_reports['from_date'] !='') {
            $report_args3 = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'amb_type' => '1',
                'base_month' => $this->post['base_month']);
        }
        $header = array('Type','Urban','Rural');
        $als = $this->inc_model->get_response_time_als($report_args1);
        if($als){
            $als_rural_res_time='00:00:00';
            $als_urban_res_time ='00:00:00';
            $als_rural_record = 0;
            $als_urban_record = 0;
            foreach ($als as $als_res){
                if($als_res['amb_working_area'] == '1'){
                    $duration = date('H:i:s', strtotime($als_res['responce_time']));
                    $str_time = $duration;
                    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                    $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                    $als_rural_res_time += $time_seconds;
                    $als_rural_record++;
                }
                if($als_res['amb_working_area'] == '2'){
                    $duration = date('H:i:s', strtotime($als_res['responce_time']));
                    $str_time = $duration;
                    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                    $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                    $als_urban_res_time += $time_seconds;
                    $als_urban_record++;
                }
            }
            if($als_rural_record != 0){
            $als_rural_res_time = $als_rural_res_time / $als_rural_record;
            }
            if($als_urban_record != 0){
            $als_urban_res_time = $als_urban_res_time / $als_urban_record;
            }
            $secs = $als_rural_res_time % 60;
            $hrs = $als_rural_res_time / 60;
            $mins = $hrs % 60;
            $hrs = $hrs / 60;
            $als_rural_res_time = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
            
            $secs = $als_urban_res_time % 60;
            $hrs = $als_urban_res_time / 60;
            $mins = $hrs % 60;
            $hrs = $hrs / 60;
            $als_urban_res_time = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
            
        }
        $bls = $this->inc_model->get_response_time_bls($report_args2);
        if($bls){
            $bls_rural_res_time='00:00:00';
            $bls_urban_res_time ='00:00:00';
            $bls_rural_record = 0;
            $bls_urban_record = 0;
            foreach ($bls as $bls_res){
                if($bls_res['amb_working_area'] == '1'){
                    $duration = date('H:i:s', strtotime($bls_res['responce_time']));
                    $str_time = $duration;
                    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                    $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                    $bls_rural_res_time += $time_seconds;
                    $bls_rural_record++;
                }
                if($bls_res['amb_working_area'] == '2'){
                    $duration = date('H:i:s', strtotime($bls_res['responce_time']));
                    $str_time = $duration;
                    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                    $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                    $bls_urban_res_time += $time_seconds;
                    $bls_urban_record++;
                }
          }
            if($bls_rural_record != 0){
            $bls_rural_res_time = $bls_rural_res_time / $bls_rural_record;
            }
            if($bls_urban_record != 0){
            $bls_urban_res_time = $bls_urban_res_time / $bls_urban_record;
            }
            $secs = $bls_rural_res_time % 60;
            $hrs = $bls_rural_res_time / 60;
            $mins = $hrs % 60;
            $hrs = $hrs / 60;
            $bls_rural_res_time = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);

            $secs = $bls_urban_res_time % 60;
            $hrs = $bls_urban_res_time / 60;
            $mins = $hrs % 60;
            $hrs = $hrs / 60;
            $bls_urban_res_time = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
        }
        $je = $this->inc_model->get_response_time_als($report_args3);
        if($je){
            $je_rural_res_time='00:00:00';
            $je_urban_res_time ='00:00:00';
            $je_rural_record = 0;
            $je_urban_record = 0;
            foreach ($je as $je_res){
                if($je_res['amb_working_area'] == '1'){
                    $duration = date('H:i:s', strtotime($je_res['responce_time']));
                    $str_time = $duration;
                    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                    $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                    $je_rural_res_time += $time_seconds;
                    $je_rural_record++;
                }
                if($je_res['amb_working_area'] == '2'){
                    $duration = date('H:i:s', strtotime($je_res['responce_time']));
                    $str_time = $duration;
                    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                    $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                    $je_urban_res_time += $time_seconds;
                    $je_urban_record++;
                }
            }
            if($je_rural_record != 0){
            $je_rural_res_time = $je_rural_res_time / $je_rural_record;
            }
            if($je_urban_record != 0){
            $je_urban_res_time = $je_urban_res_time / $je_urban_record;
            }
            $secs = $je_rural_res_time % 60;
            $hrs = $je_rural_res_time / 60;
            $mins = $hrs % 60;
            $hrs = $hrs / 60;
            $je_rural_res_time = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);

            $secs = $je_urban_res_time % 60;
            $hrs = $je_urban_res_time / 60;
            $mins = $hrs % 60;
            $hrs = $hrs / 60;
            $je_urban_res_time = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
        } 

        $inc_data1 = array(
                
            ['name'  => 'ALS',
            'urban'   => $als_urban_res_time,
            'rural' => $als_rural_res_time],

            ['name'  => 'BLS',
            'urban'   => $bls_urban_res_time,
            'rural'   => $bls_rural_res_time],
        
           ['name'  => 'JE',
            'urban'   => $je_urban_res_time,
            'rural' => $je_rural_res_time]
        
        );
        if ($post_reports['reports'] == 'view') {
            $data['header'] = $header;
            $data['inc_data'] = $inc_data1;
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'load_response_time_report_form';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/response_time_summary_report', $data, TRUE), 'list_table', TRUE);
        }else{
             $filename = "ResponseTime_Summary_Report.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);
            // $data1 = array();
           
            foreach ($inc_data1 as $inc) {
               $data = array(
                    'name'  => $inc['name'],
                    'urban'  => $inc['urban'],
                    'rural'   => $inc['rural']
                );
                //print_r($inc);
                // array_push($data1,$data);
                fputcsv($fp, $data);
                
            }
            
            fclose($fp);
            exit;

        }
    }
    function load_distance_report_form(){
        $post_reports = $this->input->post();
        // $amb_category = $post_reports['amb_category'];
        $to_data = date('Y-m-t', strtotime($post_reports['from_date']));
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        if ($post_reports['to_date'] != '') {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month']);
        } else {
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-t', strtotime($post_reports['from_date'])),
                'base_month' => $this->post['base_month']);
             $district_data['month'] = date('M Y', strtotime($post_reports['from_date']));  
        }
             
            $report_data = $this->dashboard_model_final_updated->get_total_ambulance_distance_type($report_args);
        

            $district_data = array();
    
            $district_data['amb'] = array();
            $district_data['inc_ref_id'] = array();
            $district_data['total_km'] = 0;
            $district_data['month'] =date('M Y', strtotime($post_reports['from_date']));
            
            foreach ($report_data as $report) {
            
            

                $district_data['month'] = date('M Y', strtotime($post_reports['from_date']));
    
    
                if (!in_array($report['amb_reg_id'], $district_data['amb'])) {
                    $district_data['amb'][] = $report['amb_reg_id'];
                }
    
    
                if (!in_array($report['inc_ref_id'], $district_data['inc_ref_id'])) {
                  //  var_dump($report['total_km']);
    
                    $district_data['inc_ref_id'][] = $report['inc_ref_id'];
    
                   // if (!empty($report['start_odometer'])) {
    
                    //    if ($report['end_odometer'] >= $report['start_odometer']) {
                        if(is_numeric($report['end_odometer'] ) &&  is_numeric($report['start_odometer'])){
    
                            $report_odometer = (int)$report['end_odometer'] - (int)$report['start_odometer'];
                            // $district_data['total_km']  +=  $report_odometer;
                            $district_data['total_km'] += $report['total_km'];
                    //    }
    
                        $district_data['trips'][] = $report_odometer;
                   // }
                }
            }
        }
           
                    $header = array(
                    'Description Of Services',
                    'Company',
                    'Type',
                    'No.Of Ambulance',
                    'KM Running',
                    'Rate',
                    'Amount (RS.)',
                    );
                    // print_r($report_data);die;
// 1
    $row['cat_a'] = 'Category A';  
    $row['Company'] = 'NHM';
    $row['Type'] = 'ALS';
    $row['no_amb'] = $this->dashboard_model_final_updated->get_total_amb_cat_a(3);

    // $row['total_km'] = $report_data['total_km'];
    $km_sum = $this->dashboard_model_final_updated->get_total_amb_cat_a_NHM_km(3);
    $km1=$km_sum[0]['tosum'];
    $row['total_km'] =  $km1;

    $rat=$this->dashboard_model_final_updated->get_rate_A_ALS3();
    $rat1=$rat[0]['prc_price']; 
    $row['rate']= $rat1;

    $row['amount'] =  $row['total_km']*$row['rate'];   
// 
//2
    $row1['cat_a'] = 'Category A';  
    $row1['Company'] = 'NHM';
    $row1['Type'] = 'BLS';
    $row1['no_amb'] = $this->dashboard_model_final_updated->get_total_amb_cat_a(2);
    // $row['total_km'] = $report_data['total_km'];       

    $km_sum1 = $this->dashboard_model_final_updated->get_total_amb_cat_a_NHM_km(2);
    $km2=$km_sum1[0]['tosum'];
    $row1['total_km'] =  $km2;   

    $rata=$this->dashboard_model_final_updated->get_rate_A_BLS2();
    $rat2=$rata[0]['prc_price'];
    $row1['rate']= $rat2;

    $row1['amount'] =  $row1['total_km']*$row1['rate'];
// 

// 3
    $row2['cat_a'] = 'Category B';  
    $row2['Company'] = 'JAES';
    $row2['Type'] = 'ALS';
    $row2['no_amb_b'] = $this->dashboard_model_final_updated->get_total_amb_cat_b(3);

    $km_sum2 = $this->dashboard_model_final_updated->get_total_amb_cat_a_JAES_km(3);
    $km3=$km_sum2[0]['tosum'];
    $row2['total_km'] =  $km3;    

    $rataa=$this->dashboard_model_final_updated->get_rate_B_ALS3();
    $rat3=$rataa[0]['prc_price'];
    $row2['rate']= $rat3;

    $row2['amount'] =  $row2['total_km']*$row2['rate'];
// 
// 4
    $row3['cat_a'] = 'Category B';  
    $row3['Company'] = 'JAES';
    $row3['Type'] = 'BLS';
    $row3['no_amb_b'] = $this->dashboard_model_final_updated->get_total_amb_cat_b(2);

    $km_sum3 = $this->dashboard_model_final_updated->get_total_amb_cat_a_JAES_km(2);
    $km4=$km_sum3[0]['tosum'];
    $row3['total_km'] =  $km4;  

    $rataaa=$this->dashboard_model_final_updated->get_rate_B_BLS3();
    $rat3=$rataaa[0]['prc_price'];
    $row3['rate']= $rat3;
    
    $row3['amount'] =  $row3['total_km']*$row3['rate'];
// 
// 5
    $row4['cat_a'] = 'Category C';  
    $row4['Company'] = 'NHM';
    $row4['Type'] = 'JE';
    $row4['no_amb_c'] = $this->dashboard_model_final_updated->get_total_amb_cat_c(1);    

    $km_sum4 = $this->dashboard_model_final_updated->get_total_amb_cat_a_JAES_C_km(1);
    $km5=$km_sum4[0]['tosum'];
    $row4['total_km'] =  $km5;    

    $rataaaa=$this->dashboard_model_final_updated->get_rate_C_JE1();
    $rat3=$rataaaa[0]['prc_price'];
    $row4['rate']= $rat3;

    $row4['amount'] =  $row4['total_km']*$row4['rate'];
// 
// 6
    $row5['cat_a'] = 'Category D';  
    $row5['Company'] = 'JAES';
    $row5['Type'] = 'JE';
    $row5['no_amb_d'] = $this->dashboard_model_final_updated->get_total_amb_cat_d(1); 

    $km_sum5 = $this->dashboard_model_final_updated->get_total_amb_cat_a_JAES_D_km(1);
    $km6=$km_sum5[0]['tosum'];
    $row5['total_km'] =  $km6; 

    $rataaaaa=$this->dashboard_model_final_updated->get_rate_D_JE1();
    $rat3=$rataaaaa[0]['prc_price'];
    $row5['rate']= $rat3;

    $row5['amount'] =  $row5['total_km']*$row5['rate'];
// 
        if ($post_reports['reports'] == 'view') {
            //$row['cat_a'] = 'Category A';
            $data['header'] = $header;
            
            $data['inc_data'] = $row;
            $data['inc_data1'] = $row1;           
            $data['inc_data2'] = $row2;            
            $data['inc_data3'] = $row3;
            $data['inc_data4'] = $row4;
            $data['inc_data5'] = $row5;




            
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_distance_travelld_details_view', $data, TRUE));
    }else {
        
        $filename = "distance_travelled_reports.csv";
        $fp = fopen('php://output', 'w');

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        fputcsv($fp, $header);

        // $row['cat_a'] = 'Category A';        
        $row['Company'] = 'NHM';
        $row['Type'] = 'ALS';
        $row['no_amb'] = $this->dashboard_model_final_updated->get_total_amb_cat_a(3);
            
        // $row['total_km'] = $report_data['total_km'];
        $km_sum = $this->dashboard_model_final_updated->get_total_amb_cat_a_NHM_km(3);
        $km1=$km_sum[0]['tosum'];
        $row['total_km'] =  $km1;
    
        $rat=$this->dashboard_model_final_updated->get_rate_A_ALS3();
        $rat1=$rat[0]['prc_price']; 
        $row['rate']= $rat1;
    
        $row['amount'] =  $row['total_km']*$row['rate'];   
        // print_r($row);die();
    // 

        // $row1['cat_a'] = 'Category A';
        $row1['Company'] = 'NHM';
        $row1['Type'] = 'BLS';
        $row1['no_amb'] = $this->dashboard_model_final_updated->get_total_amb_cat_a(2);
        // $row['total_km'] = $report_data['total_km'];       
    
        $km_sum1 = $this->dashboard_model_final_updated->get_total_amb_cat_a_NHM_km(2);
        $km2=$km_sum1[0]['tosum'];
        $row1['total_km'] =  $km2;   
    
        $rata=$this->dashboard_model_final_updated->get_rate_A_BLS2();
        $rat2=$rata[0]['prc_price'];
        $row1['rate']= $rat2;
    
        $row1['amount'] =  $row1['total_km']*$row1['rate'];
    // 

        // $row2['cat_a'] = 'Category B';
        $row2['Company'] = 'JAES';
        $row2['Type'] = 'ALS';
        $row2['no_amb_b'] = $this->dashboard_model_final_updated->get_total_amb_cat_b(3);

        $km_sum2 = $this->dashboard_model_final_updated->get_total_amb_cat_a_JAES_km(3);
        $km3=$km_sum2[0]['tosum'];
        $row2['total_km'] =  $km3;    

        $rataa=$this->dashboard_model_final_updated->get_rate_B_ALS3();
        $rat3=$rataa[0]['prc_price'];
        $row2['rate']= $rat3;

        $row2['amount'] =  $row2['total_km']*$row2['rate'];
// 

        // $row3['cat_a'] = 'Category B';
        $row3['Company'] = 'JAES';
        $row3['Type'] = 'BLS';
        $row3['no_amb_b'] = $this->dashboard_model_final_updated->get_total_amb_cat_b(2);

        $km_sum3 = $this->dashboard_model_final_updated->get_total_amb_cat_a_JAES_km(2);
        $km4=$km_sum3[0]['tosum'];
        $row3['total_km'] =  $km4;  

        $rataaa=$this->dashboard_model_final_updated->get_rate_B_BLS3();
        $rat3=$rataaa[0]['prc_price'];
        $row3['rate']= $rat3;
        
        $row3['amount'] =  $row3['total_km']*$row3['rate'];
// // 
//         $row4['cat_a'] = 'Category C';
        $row4['Company'] = 'NHM';
        $row4['Type'] = 'JE';
        $row4['no_amb_c'] = $this->dashboard_model_final_updated->get_total_amb_cat_c(1);    

        $km_sum4 = $this->dashboard_model_final_updated->get_total_amb_cat_a_JAES_C_km(1);
        $km5=$km_sum4[0]['tosum'];
        $row4['total_km'] =  $km5;    

        $rataaaa=$this->dashboard_model_final_updated->get_rate_C_JE1();
        $rat3=$rataaaa[0]['prc_price'];
        $row4['rate']= $rat3;

        $row4['amount'] =  $row4['total_km']*$row4['rate'];
// 
    // <!-- $row5['cat_a'] = 'Category D'; -->
    $row5['Company'] = 'JAES';
    $row5['Type'] = 'JE';
    $row5['no_amb_d'] = $this->dashboard_model_final_updated->get_total_amb_cat_d(1); 

    $km_sum5 = $this->dashboard_model_final_updated->get_total_amb_cat_a_JAES_D_km(1);
    $km6=$km_sum5[0]['tosum'];
    $row5['total_km'] =  $km6; 

    $rataaaaa=$this->dashboard_model_final_updated->get_rate_D_JE1();
    $rat3=$rataaaaa[0]['prc_price'];
    $row5['rate']= $rat3;

    $row5['amount'] =  $row5['total_km']*$row5['rate'];
// 
        
        fputcsv($fp, $row);
        fputcsv($fp, $row1);
        fputcsv($fp, $row2);
        fputcsv($fp, $row3);
        fputcsv($fp, $row4);
        fputcsv($fp, $row5);


        fclose($fp);
        exit;
    }

}
}