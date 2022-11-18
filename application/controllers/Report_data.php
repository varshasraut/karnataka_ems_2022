<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_data extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->active_module = "M-REPORTS";

        $this->pg_limit = $this->config->item('pagination_limit_clg');

        $this->pg_limits = $this->config->item('report_clg');
        $this->load->model(array('dashboard_model_final_updated','colleagues_model', 'get_city_state_model', 'options_model', 'common_model', 'module_model', 'inc_model', 'amb_model', 'pcr_model', 'hp_model', 'school_model', 'eqp_model', 'inv_model', 'police_model', 'fire_model', 'shiftmanager_model', 'Medadv_model', 'feedback_model', 'grievance_model','call_model','ambmain_model','quality_model','module_model','reports_model','corona_model','hpcl_model_api','maintenance_part_model','fleet_model','biomedical_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date'));
        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules', 'simple_excel/Simple_excel'));

        $this->post['base_month'] = get_base_month();
        $this->site_name = $this->config->item('site_name');
        $this->site = $this->config->item('site');

        $this->clg = $this->session->userdata('current_user');
    }
    function load_report_form() {
        $report_type = $this->input->post('report_type');
        if ($report_type == 'Offroad_Detail_Reports') {
            $data['submit_function'] = "offroad_detail_report";
            $data['report_name'] = "OffRoad Detail Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/offroad_detail_report_filter', $data, TRUE), $output_position, TRUE);
        } 
        elseif ($report_type == 'DM_DC_Login_Report') {
            $data['submit_function'] = "dm_dc_login_report";
            $data['report_name'] = "DM/DC Login Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/dm_dc_report_filter', $data, TRUE), $output_position, TRUE);
        } 
    }
    function offroad_detail_report(){
        $post_reports = $this->input->post();
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;
        $report_args = array(
            'to_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'base_month' => $this->post['base_month']
        );
        //var_dump($report_args);die();
        $general_offroad = $this->ambmain_model->get_detail_onoff_data_only($report_args);//ems_amb_onroad_offroad
        $accidental = $this->ambmain_model->get_detail_accidental_data_only($report_args);//ems_amb_accidental_maintaince
        $preventive = $this->ambmain_model->get_detail_preventive_data_only($report_args);//ems_ambulance_preventive_maintaince
        $tyre = $this->ambmain_model->get_detail_tyre_data_only($report_args);//ems_amb_tyre_maintaince
        $breakdown = $this->ambmain_model->get_detail_breakdown_data_only($report_args);//ems_amb_breakdown_maintaince
        $manpower = $this->ambmain_model->get_detail_manpower_data_only($report_args);//ems_manpower_offroad
        $header = array('Sr.No','Ticket No','Off-Road Date','Ambulance No','Project','Ditrict','Zone','Location','Model','Current Status','Remark','On OffRoad Reason','Sub Type','Offroad Odo reading','OnRoad Odo Reading','OffRoad Date','OnRoad date','Duration');
        if ($post_reports['reports'] == 'view') {

            $data['header'] = $header;
            $data['general_offroad_re'] = $general_offroad;
            $data['accidental_data_re'] = $accidental;
            $data['preventive_data_re'] = $preventive;
            $data['tyre_data_re'] = $tyre;
            $data['breakdown_data_re'] = $breakdown;
            $data['manpower_data_re'] = $manpower;
            $data['report_args'] = $report_args;
            $data['submit_function'] = 'offroad_detail_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/offroad_detail_report_view', $data, TRUE), 'list_table', TRUE);
        }else{
            $filename = "onroad_offroad_report.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $count = 1;
            //var_dump($general_offroad);die();
            foreach ($general_offroad as $row) {
                //var_dump($row);die();
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
                        $duration_test= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S ';
                        $duration_time = $since_start->format('%H:%I:%S');
                        sscanf($duration_time, "%d:%d:%d", $hours, $minutes, $seconds);
                        $time_seconds_min = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                        $time_seconds_hr = strtotime($since_start->days.' day', 0);
                        $duration1 = $time_seconds_min + $time_seconds_hr ;

                        $secs = $duration1 % 60;
                        $hrs = $duration1 / 60;
                        $mins = $hrs % 60;
                        $hrs = $hrs / 60;
                        $duration = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
                    }else{
                        $since_start = $start_date->diff($end_date);
                        $duration_test= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S ';
                    $duration_time = $since_start->format('%H:%I:%S');
                    sscanf($duration_time, "%d:%d:%d", $hours, $minutes, $seconds);
                    $time_seconds_min = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                    $time_seconds_hr = strtotime($since_start->days.' day', 0);
                    $duration1 = $time_seconds_min + $time_seconds_hr ;

                    $secs = $duration1 % 60;
                    $hrs = $duration1 / 60;
                    $mins = $hrs % 60;
                    $hrs = $hrs / 60;
                    $duration = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
                    }
                }else{
                    $duration = '0';
                }
                    $added_by_name = $row->first_name." ".$row->mid_name." ". $row->last_name;
                    if($row->mt_offroad_reason == 'Other')
                    {
                        $mt_offroad_reason=$row->mt_offroad_reason.'-'.$row->mt_other_offroad_reason;
                    }
                    else{
                        $mt_offroad_reason=$row->mt_offroad_reason.'-'.$row->mt_other_offroad_reason;
                    }
                $data = array(
                    'Sr.No' => $count,
                    'mt_onoffroad_id' => $row->mt_onoffroad_id,
                    'mt_offroad_datetime' => $row->mt_offroad_datetime,
                    'mt_amb_no' => $row->mt_amb_no,
                    'amb_type' => $amb_type,
                    'current_district' => $current_district,
                    'div_name' => $row->div_name,
                    'mt_base_loc' => $row->mt_base_loc,
                    'amb_model' => $amb_model,
                    'mt_ambulance_status' => $row->mt_ambulance_status,
                    'mt_remark' => $row->mt_remark,
                    'mt_offroad_reason' => $mt_offroad_reason,
                    'General' => 'General Offroad',
                    'mt_in_odometer' => $row->mt_in_odometer,
                    'mt_end_odometer' => $row->mt_end_odometer,
                    'mt_offroad_datetime1' => $row->mt_offroad_datetime,
                    'mt_onroad_datetime' => $row->mt_onroad_datetime,
                    'duration' => $duration,
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
                    $duration_test= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S ';
                    $duration_time = $since_start->format('%H:%I:%S');
                    sscanf($duration_time, "%d:%d:%d", $hours, $minutes, $seconds);
                    $time_seconds_min = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                    $time_seconds_hr = strtotime($since_start->days.' day', 0);
                    $duration1 = $time_seconds_min + $time_seconds_hr ;

                    $secs = $duration1 % 60;
                    $hrs = $duration1 / 60;
                    $mins = $hrs % 60;
                    $hrs = $hrs / 60;
                    $duration = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
                }else{
                    $since_start = $start_date->diff($end_date);
                    $duration_test= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S ';
                    $duration_time = $since_start->format('%H:%I:%S');
                    sscanf($duration_time, "%d:%d:%d", $hours, $minutes, $seconds);
                    $time_seconds_min = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                    $time_seconds_hr = strtotime($since_start->days.' day', 0);
                    $duration1 = $time_seconds_min + $time_seconds_hr ;

                    $secs = $duration1 % 60;
                    $hrs = $duration1 / 60;
                    $mins = $hrs % 60;
                    $hrs = $hrs / 60;
                    $duration = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
                }}else{
                    $duration = '0';
                }
                $added_by_name = $row->first_name." ".$row->mid_name." ". $row->last_name;
                if($row->mt_offroad_reason == 'Other')
                    {
                        $mt_offroad_reason=$row->mt_offroad_reason.'-'.$row->mt_other_offroad_reason;
                    }
                    else{
                        $mt_offroad_reason=$row->mt_offroad_reason.'-'.$row->mt_other_offroad_reason;
                    }
                $data = array(
                 'Sr.No' => $count,
                 'mt_onoffroad_id' => $row->mt_accidental_id,
                 'mt_offroad_datetime' => $row->mt_offroad_datetime,
                 'mt_amb_no' => $row->mt_amb_no,
                 'amb_type' => $amb_type,
                 'current_district' => $current_district,
                 'div_name' => $row->div_name,
                 'mt_base_loc' => $row->mt_base_loc,
                 'amb_model' => $amb_model,
                 'mt_ambulance_status' => $row->mt_ambulance_status,
                 'mt_remark' => $row->mt_remark,
                 'mt_offroad_reason' => $mt_offroad_reason,
                 'General' => 'Accidental Offroad',
                 'mt_in_odometer' => $row->mt_in_odometer,
                 'mt_end_odometer' => $row->mt_end_odometer,
                 'mt_offroad_datetime1' => $row->mt_offroad_datetime,
                 'mt_onroad_datetime' => $row->mt_onroad_datetime,
                 'duration' => $duration,
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
                        $duration_test= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S ';
                        $duration_time = $since_start->format('%H:%I:%S');
                        sscanf($duration_time, "%d:%d:%d", $hours, $minutes, $seconds);
                        $time_seconds_min = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                        $time_seconds_hr = strtotime($since_start->days.' day', 0);
                        $duration1 = $time_seconds_min + $time_seconds_hr ;
    
                        $secs = $duration1 % 60;
                        $hrs = $duration1 / 60;
                        $mins = $hrs % 60;
                        $hrs = $hrs / 60;
                        $duration = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
                    }else{
                        $since_start = $start_date->diff($end_date);
                        $duration_test= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S ';
                        $duration_time = $since_start->format('%H:%I:%S');
                        sscanf($duration_time, "%d:%d:%d", $hours, $minutes, $seconds);
                        $time_seconds_min = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                        $time_seconds_hr = strtotime($since_start->days.' day', 0);
                        $duration1 = $time_seconds_min + $time_seconds_hr ;
    
                        $secs = $duration1 % 60;
                        $hrs = $duration1 / 60;
                        $mins = $hrs % 60;
                        $hrs = $hrs / 60;
                        $duration = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
                    }}else{
                        $duration = '0';
                    }
                $added_by_name = $row->first_name." ".$row->mid_name." ". $row->last_name;
                if($row->mt_offroad_reason == 'Other')
                    {
                        $mt_offroad_reason=$row->mt_offroad_reason.'-'.$row->mt_other_offroad_reason;
                    }
                    else{
                        $mt_offroad_reason=$row->mt_offroad_reason.'-'.$row->mt_other_offroad_reason;
                    }
                $data = array(
                 'Sr.No' => $count,
                 'mt_onoffroad_id' => $row->mt_preventive_id,
                 'mt_offroad_datetime' => $row->mt_offroad_datetime,
                 'mt_amb_no' => $row->mt_amb_no,
                 'amb_type' => $amb_type,
                 'current_district' => $current_district,
                 'div_name' => $row->div_name,
                 'mt_base_loc' => $row->mt_base_loc,
                 'amb_model' => $amb_model,
                 'mt_ambulance_status' => $row->mt_ambulance_status,
                 'mt_remark' => $row->mt_remark,
                 'mt_offroad_reason' => $mt_offroad_reason,
                 'General' => 'Schedule Offroad',
                 'mt_in_odometer' => $row->mt_in_odometer,
                 'mt_end_odometer' => $row->mt_end_odometer,
                 'mt_offroad_datetime1' => $row->mt_offroad_datetime,
                 'mt_onroad_datetime' => $row->mt_onroad_datetime,
                 'duration' => $duration,
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
                    $duration_test= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S ';
                    $duration_time = $since_start->format('%H:%I:%S');
                    sscanf($duration_time, "%d:%d:%d", $hours, $minutes, $seconds);
                    $time_seconds_min = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                    $time_seconds_hr = strtotime($since_start->days.' day', 0);
                    $duration1 = $time_seconds_min + $time_seconds_hr ;

                    $secs = $duration1 % 60;
                    $hrs = $duration1 / 60;
                    $mins = $hrs % 60;
                    $hrs = $hrs / 60;
                    $duration = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
                }else{
                    $since_start = $start_date->diff($end_date);
                    $duration_test= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S ';
                    $duration_time = $since_start->format('%H:%I:%S');
                    sscanf($duration_time, "%d:%d:%d", $hours, $minutes, $seconds);
                    $time_seconds_min = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                    $time_seconds_hr = strtotime($since_start->days.' day', 0);
                    $duration1 = $time_seconds_min + $time_seconds_hr ;

                    $secs = $duration1 % 60;
                    $hrs = $duration1 / 60;
                    $mins = $hrs % 60;
                    $hrs = $hrs / 60;
                    $duration = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
                }}else{
                    $duration = '0';
                }
                $added_by_name = $row->first_name." ".$row->mid_name." ". $row->last_name;
                if($row->mt_offroad_reason == 'Other')
                    {
                        $mt_offroad_reason=$row->mt_offroad_reason.'-'.$row->mt_other_offroad_reason;
                    }
                    else{
                        $mt_offroad_reason=$row->mt_offroad_reason.'-'.$row->mt_other_offroad_reason;
                    }
                $data = array(
                 'Sr.No' => $count,
                 'mt_onoffroad_id' => $row->mt_tyre_id,
                 'mt_offroad_datetime' => $row->mt_offroad_datetime,
                 'mt_amb_no' => $row->mt_amb_no,
                 'amb_type' => $amb_type,
                 'current_district' => $current_district,
                 'div_name' => $row->div_name,
                 'mt_base_loc' => $row->mt_base_loc,
                 'amb_model' => $amb_model,
                 'mt_ambulance_status' => $row->mt_ambulance_status,
                 'mt_remark' => $row->mt_remark,
                 'mt_offroad_reason' => $mt_offroad_reason,
                 'General' => 'Tyre Offroad',
                 'mt_in_odometer' => $row->mt_in_odometer,
                 'mt_end_odometer' => $row->mt_end_odometer,
                 'mt_offroad_datetime1' => $row->mt_offroad_datetime,
                 'mt_onroad_datetime' => $row->mt_onroad_datetime,
                 'duration' => $duration,
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
                    $duration_test= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S ';
                    $duration_time = $since_start->format('%H:%I:%S');
                    sscanf($duration_time, "%d:%d:%d", $hours, $minutes, $seconds);
                    $time_seconds_min = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                    $time_seconds_hr = strtotime($since_start->days.' day', 0);
                    $duration1 = $time_seconds_min + $time_seconds_hr ;

                    $secs = $duration1 % 60;
                    $hrs = $duration1 / 60;
                    $mins = $hrs % 60;
                    $hrs = $hrs / 60;
                    $duration = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
                }else{
                    $since_start = $start_date->diff($end_date);
                    $duration_test= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S ';
                    $duration_time = $since_start->format('%H:%I:%S');
                    sscanf($duration_time, "%d:%d:%d", $hours, $minutes, $seconds);
                    $time_seconds_min = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                    $time_seconds_hr = strtotime($since_start->days.' day', 0);
                    $duration1 = $time_seconds_min + $time_seconds_hr ;

                    $secs = $duration1 % 60;
                    $hrs = $duration1 / 60;
                    $mins = $hrs % 60;
                    $hrs = $hrs / 60;
                    $duration = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
                }}else{
                    $duration = '0';
                }
                $added_by_name = $row->first_name." ".$row->mid_name." ". $row->last_name;
                if($row->mt_offroad_reason == 'Other')
                    {
                        $mt_offroad_reason=$row->mt_offroad_reason.'-'.$row->mt_other_offroad_reason;
                    }
                    else{
                        $mt_offroad_reason=$row->mt_offroad_reason.'-'.$row->mt_other_offroad_reason;
                    }
                $data = array(
                 'Sr.No' => $count,
                 'mt_onoffroad_id' => $row->mt_breakdown_id,
                 'mt_offroad_datetime' => $row->mt_offroad_datetime,
                 'mt_amb_no' => $row->mt_amb_no,
                 'amb_type' => $amb_type,
                 'current_district' => $current_district,
                 'div_name' => $row->div_name,
                 'mt_base_loc' => $row->mt_base_loc,
                 'amb_model' => $amb_model,
                 'mt_ambulance_status' => $row->mt_ambulance_status,
                 'mt_remark' => $row->mt_remark,
                 'mt_offroad_reason' => $mt_offroad_reason,
                 'General' => 'Breakdown Offroad',
                 'mt_in_odometer' => $row->mt_in_odometer,
                 'mt_end_odometer' => $row->mt_end_odometer,
                 'mt_offroad_datetime1' => $row->mt_offroad_datetime,
                 'mt_onroad_datetime' => $row->mt_onroad_datetime,
                 'duration' => $duration,
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
                    $duration_test= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S ';
                    $duration_time = $since_start->format('%H:%I:%S');
                    sscanf($duration_time, "%d:%d:%d", $hours, $minutes, $seconds);
                    $time_seconds_min = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                    $time_seconds_hr = strtotime($since_start->days.' day', 0);
                    $duration1 = $time_seconds_min + $time_seconds_hr ;

                    $secs = $duration1 % 60;
                    $hrs = $duration1 / 60;
                    $mins = $hrs % 60;
                    $hrs = $hrs / 60;
                    $duration = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
                }else{
                    $since_start = $start_date->diff($end_date);
                    $duration_test= $since_start->days.'D '.$since_start->h.'H '. $since_start->i.'M '.$since_start->s.'S ';
                    $duration_time = $since_start->format('%H:%I:%S');
                    sscanf($duration_time, "%d:%d:%d", $hours, $minutes, $seconds);
                    $time_seconds_min = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                    $time_seconds_hr = strtotime($since_start->days.' day', 0);
                    $duration1 = $time_seconds_min + $time_seconds_hr ;

                    $secs = $duration1 % 60;
                    $hrs = $duration1 / 60;
                    $mins = $hrs % 60;
                    $hrs = $hrs / 60;
                    $duration = ((int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
                }}else{
                    $duration = '0';
                }
                $added_by_name = $row->first_name." ".$row->mid_name." ". $row->last_name;
                if($row->mt_offroad_reason == 'Other')
                    {
                        $mt_offroad_reason=$row->mt_offroad_reason.'-'.$row->mt_other_offroad_reason;
                    }
                    else{
                        $mt_offroad_reason=$row->mt_offroad_reason.'-'.$row->mt_other_offroad_reason;
                    }
                $data = array(
                 'Sr.No' => $count,
                 'mt_onoffroad_id' => $row->mt_manpower_id,
                 'mt_offroad_datetime' => $row->mt_offroad_date,
                 'mt_amb_no' => $row->mt_amb_no,
                 'amb_type' => $amb_type,
                 'current_district' => $current_district,
                 'div_name' => $row->div_name,
                 'mt_base_loc' => $row->mt_base_loc,
                 'amb_model' => $amb_model,
                 'mt_ambulance_status' => $row->mt_ambulance_status,
                 'mt_remark' => $row->mt_remark,
                 'mt_offroad_reason' => $mt_offroad_reason,
                 'General' => 'Manpower Offroad',
                 'mt_in_odometer' => $row->mt_in_odometer,
                 'mt_end_odometer' => $row->mt_end_odometer,
                 'mt_offroad_datetime1' => $row->mt_offroad_date,
                 'mt_onroad_datetime' => $row->mt_ex_onroad_datetime,
                 'duration' => $duration,
                
                );
                fputcsv($fp, $data);
                $count++;
            }

            fclose($fp);
            exit; 
            
        }
           
    }

    function dm_dc_login_report(){
        $post_reports = $this->input->post();
        $clg = $this->session->userdata('current_user');

        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $to_date = date('Y-m-d', strtotime($post_reports['to_date']));
        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        if($this->clg->clg_group ==  'UG-ZM'){

                $district_id =  $clg->clg_district_id;
                $district_id = json_decode($district_id);
                // if (is_array($district_id)) {
                //     $district_id = implode("','", $district_id);
                // }
                $dis = $district_id;

        }
        else if($this->clg->clg_group ==  'UG-DM'){
            
            $district_id =  $clg->clg_district_id;
            $district_id = json_decode($district_id);
            $dist = $district_id;

        }
        else{
            $dis = "";
            $dist = "";
            
        }

        //var_dump($report_args);die();
        $dm_detail = $this->inc_model->get_dm_dc_info($dis,$dist);
        function RemoveSpecialChar($string){
            $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
         
            return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
         }
        $report_data=[];
        // print_r($dm_detail);die();
        foreach($dm_detail as $dc_detail)
        {
            $dist = array(
                'dist' => RemoveSpecialChar($dc_detail->clg_district_id),
            );
            // echo RemoveSpecialChar($dc_detail->clg_district_id);die();
            $dist_detail = $this->inc_model->get_amb_count($dist);
            $dist_detail = (array)$dist_detail[0];
            $report_args = array(
                'from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                // 'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'clg_ref_id' => $dc_detail->clg_ref_id,
                'base_month' => $this->post['base_month']
            );
            $login_data = $this->inc_model->get_dm_dc_login_report($report_args);
            $login_data = (array)$login_data[0];
            $name = $dc_detail->clg_first_name .' '.$dc_detail->clg_mid_name.' '.$dc_detail->clg_last_name;
            $arr = [
                "dist"=>$dist_detail['dst_name'],
                "zone"=>$dist_detail['div_name'],
                "amb_count"=>$dist_detail['amb_count'],
                "id"=>$dc_detail->clg_ref_id,
                "name"=>$name,
                "login"=>$login_data['clg_login_time'],
                "logout"=>$login_data['clg_logout_time'],
            ];
            array_push($report_data,$arr);
        }
        // print_r($report_data);die();
        // $report_data = $this->inc_model->get_dm_dc_login_report($report_args);//ems_amb_onroad_offroad
       
        $header = array('Sr.No','District Name','Zone Name','No of Ambulance','ID','DM Name','Login Time','Logout Time');
        if ($post_reports['reports'] == 'view') {

            $data['header'] = $header;
            $data['report_args'] = $report_args;
            $data['inc_data'] = $report_data;
            $data['submit_function'] = 'dm_dc_login_report';
            $this->output->add_to_position($this->load->view('frontend/erc_reports/dm_dc_login_report_view', $data, TRUE), 'list_table', TRUE);
        }else{
            $filename = "dm_dc_login_report.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);

            $count = 1;
            //var_dump($general_offroad);die();
            
            foreach ($report_data as $row) {
                if($row['login']){$login=$row['login'];}else{$login='-';}
                if($row['logout']){$logout=$row['logout'];}else{$logout='-';}
                $data = array(
                 'Sr.No' => $count,
                 "dist"=>$row['dist'],
                "zone"=>$row['zone'],
                "amb_count"=>$row['amb_count'],
                "id"=>$row['id'],
                "name"=>$row['name'],
                "login"=>$login,
                "logout"=>$logout,
                
                );
                fputcsv($fp, $data);
                $count++;
            }

            fclose($fp);
            exit; 
            
        }
           
    }
}
   
       