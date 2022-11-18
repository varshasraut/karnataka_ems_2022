<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tdd_reports extends EMS_Controller {

    function __construct() {

        parent::__construct();
        
        $this->active_module = "M-REPORTS";   

        $this->pg_limit =$this->config->item('pagination_limit_clg');
        
        $this->pg_limits =$this->config->item('report_clg');

        $this->load->model(array('colleagues_model','get_city_state_model','options_model','module_model','inc_model','amb_model','pcr_model','hp_model','school_model','eqp_model','inv_model'));
 
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date'));

        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules','simple_excel/Simple_excel'));

        $this->post['base_month'] = get_base_month();
        $this->site_name=$this->config->item('site_name');
        $this->site=$this->config->item('site');
        
        $this->clg = $this->session->userdata('current_user');

    }

    public function index($generated = false) {
      
         $this->output->add_to_position($this->load->view('frontend/reports/tdd_reports_list_view',$data,TRUE),$this->post['output_position'],TRUE);
    }
    function load_report_form(){
        $report_type = $this->input->post('report_type');
        
        if($report_type == 'monthly_screening_report'){
            $data['submit_function'] = "monthly_screening_report";
            $this->output->add_to_position($this->load->view('frontend/reports/export_inc_reports_view',$data, TRUE),'report_block_fields',TRUE); 
        }else if($report_type == 'ambulance_stock_report'){
            $data['submit_function'] = "ambulance_stock_report";
            $arg_amb = array('amb_user_type'=>'tdd');
            $data['amb_list'] = $this->amb_model->get_amb_data($arg_amb);
            $this->output->add_to_position($this->load->view('frontend/reports/export_ambulance_stock_view',$data, TRUE),'report_block_fields',TRUE); 
        }else if($report_type == 'ambulance_equipment_report'){
            $data['submit_function'] = "ambulance_equipment_report";
            $arg_amb = array('amb_user_type'=>'tdd');
            $data['amb_list'] = $this->amb_model->get_amb_data($arg_amb);
            $this->output->add_to_position($this->load->view('frontend/reports/export_ambulance_stock_view',$data, TRUE),'report_block_fields',TRUE); 
        }else if( $report_type  == 'sickroom_stock_report'){
            $data['submit_function'] = "sickroom_stock_report";
            $data['cluster_id'] = $cluster_id = $this->clg->cluster_id;
           // var_dump( $this->clg->cluster_id);
            $this->output->add_to_position($this->load->view('frontend/reports/export_sickroom_stock_view',$data, TRUE),'report_block_fields',TRUE); 
        }else if( $report_type  == 'sickroom_equipment_report'){
            $data['submit_function'] = "sickroom_equipment_report";
            $data['cluster_id'] = $cluster_id = $this->clg->cluster_id;
           // var_dump( $this->clg->cluster_id);
            $this->output->add_to_position($this->load->view('frontend/reports/export_sickroom_stock_view',$data, TRUE),'report_block_fields',TRUE); 
        }else if($report_type == 'ambulance_distance_Reports'){
            $data['submit_function'] = "save_export_dist_travel";
            $this->output->add_to_position($this->load->view('frontend/reports/export_amb_reports_view',$data, TRUE),'report_block_fields',TRUE); 
            
        }else if($report_type == 'amb_onroad_offroad_report'){
             $data['submit_function'] = "amb_onroad_offroad_report";
            $this->output->add_to_position($this->load->view('frontend/reports/export_amb_reports_view',$data, TRUE),'report_block_fields',TRUE); 
        }else if($report_type == 'Patient_Reports'){
            $data['submit_function'] = "save_export_patient";
            $this->output->add_to_position($this->load->view('frontend/reports/export_inc_reports_view',$data, TRUE),'report_block_fields',TRUE); 
            
        }else  if($report_type == 'Incident_Reports'){
            $data['submit_function'] = "save_export_inc";
            $this->output->add_to_position($this->load->view('frontend/reports/export_inc_reports_view', $data, TRUE), 'report_block_fields', TRUE);
            
        }
        
        
         
    }
 
   
    /*tdd new reports*/
    function monthly_screening_report(){
        $post_reports = $this->input->post();
        
        $cluster_id = $this->clg->cluster_id;
        
         
        $school_args = array('cluster_id'=>$cluster_id);
        $report_data = $this->school_model->get_school_data_report($school_args);
       

        $from_date =  date('Y-m-d',strtotime($post_reports['from_date']));
        $to_date =  date('Y-m-d',strtotime($post_reports['to_date']));
        
        
        
        $report_args =  array('from_date' => $from_date.' 00:00:01',
                              'to_date' => $to_date.' 23:59:59');
        
        $school_data = array();
        foreach($report_data as $report){
            $report_args['school_id'] = $report->school_id;
            $total_screening = $this->school_model->get_school_student_screening($report_args);
           
            $report->screen_count = $total_screening;
            $school_data[] = $report;
            
        }
       
        
        $header = array('Sr No','Name of Ashram School','Name of ATC','Name of PO','Total Numbers of Screened Students');
            
        if($post_reports['reports'] == 'view'){
           

            $inc_data = array();

            $data['header'] = $header;
            $data['report_args'] = $report_args;
            $data['school_data'] = $school_data;
            $this->output->add_to_position($this->load->view('frontend/reports/monthly_screening_report_view',$data, TRUE),'list_table',TRUE); 
            
        }else{
     
        
        $filename = "monthly_screening_report.csv";
        $fp = fopen('php://output', 'w');

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename='.$filename);
        fputcsv($fp, $header);
        
        

        $data = array();
       
            foreach($school_data as $key=>$school){

                       $sc_data = array(   
                              'sr_no'            => $key+1,
                              'school_name'      => $school->school_name, 
                              'atc_name'         => $school->atc_name, 
                              'po_name'   => $school->po_name,
                              'screen_count'     => $school->screen_count, 
                );
      
              fputcsv($fp, $sc_data);
            }
            

        fclose($fp);
        exit;
        }
    }
    function ambulance_stock_report() {
        $post_reports = $this->input->post();
     
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $to_date = date('Y-m-d', strtotime($post_reports['to_date']));
        $report_args = array('from_date' => $from_date . ' 00:00:01',
            'to_date' => $to_date . ' 23:59:59');

        $report_args['inv_type'] = 'CA';
        $report_args['inv_amb'] = (isset($post_reports['amb_reg_id'])) ? trim($post_reports['amb_reg_id']) : '';

        if ($post_reports['reports'] == 'view') {

            $data['report_args'] = $report_args;
         
            $data['item_list'] = $this->inv_model->get_inv($report_args);
            $this->output->add_to_position($this->load->view('frontend/reports/amb_stock_view', $data, TRUE), $this->post['output_position'], TRUE);
        } else {

            $filename = "ambulance_stock_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            $header = array('Name of Consumables', 'Expected Stock', 'Opening stock-48 Ambulances', 'Consumed During the month', 'Replenishment During the Month', 'Closing Stock');

     

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
                            'expected_stock' => $item->inv_base_quantity,
                            'opening_stock' => $item->inv_base_quantity,
                            'consume_during_month' => $item->out_stk,
                            'replenishment' => $stock,
                            'closing_stock' => $bal,
                        );

                        fputcsv($fp, $sc_data);
                    }
                }
                fclose($fp);
                exit;
            }
      
        
    }
    function ambulance_equipment_report(){
        $post_reports = $this->input->post();
        //var_dump($post_reports);
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $to_date = date('Y-m-d', strtotime($post_reports['to_date']));
        $report_args = array('from_date' => $from_date . ' 00:00:01',
            'to_date' => $to_date . ' 23:59:59');

        $report_args['inv_type'] = 'EQP';
        $report_args['eqp_amb'] = (isset($post_reports['amb_reg_id'])) ? trim($post_reports['amb_reg_id']) : '';

        if ($post_reports['reports'] == 'view') {

            $data['report_args'] = $report_args;
            $data['eqp_list'] = $this->eqp_model->get_eqp($report_args);
            $this->output->add_to_position($this->load->view('frontend/reports/amb_eqp_stock_view', $data, TRUE), $this->post['output_position'], TRUE);
        } else {

            $filename = "ambulance_equipment_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
           $header = array('Name of Equipment', 'Total numbers of equipment’s', 'Total numbers of available equipment’s', 'Total numbers of functional equipment’s', 'Remarks');

     

                $eqp_list = $this->eqp_model->get_eqp($report_args);

                fputcsv($fp, $header);

                $data = array();

                if (!empty($eqp_list)) {
                    foreach ($eqp_list as $eqp) {


                         $bal = 0;

                            $stock = $eqp->in_stk - $eqp->out_stk;

                            if ($stock > 0) {
                                $bal = $stock;
                            } else if ($eqp->in_stk > 0) {
                                $bal = $eqp->in_stk;
                            }
                        $sc_data = array(
                            'inv_title' => stripslashes($eqp->eqp_name),
                            'no_of_quipmens' => $eqp->in_stk,
                            'avail_eqp' => $bal,
                            'fun_eqp' => $eqp->eqp_base_quantity,
                            'remars' => ''
                        );

                        fputcsv($fp, $sc_data);
                    }
                }
                fclose($fp);
                exit;
            }
      
    }
    function sickroom_stock_report() {
        $post_reports = $this->input->post();
        //var_dump($post_reports);
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $to_date = date('Y-m-d', strtotime($post_reports['to_date']));
        $report_args = array('from_date' => $from_date . ' 00:00:01',
            'to_date' => $to_date . ' 23:59:59');

        $report_args['inv_type'] = 'CA';
        $report_args['inv_amb'] = (isset($post_reports['school_id'])) ? trim($post_reports['school_id']) : '';

        if ($post_reports['reports'] == 'view') {

            $data['report_args'] = $report_args;
            $data['item_list'] = $this->inv_model->get_inv($report_args);
            $this->output->add_to_position($this->load->view('frontend/reports/sickroom_stock_view', $data, TRUE), $this->post['output_position'], TRUE);
            
        } else {

            $filename = "sickroom_stock_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            $header = array('Name of Consumables', 'Expected Stock', 'Opening Stock 53 Sick Room', 'Consumed During the month', 'Replenishment During the Month', 'Closing Stock');

     

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
                            'expected_stock' => $item->inv_base_quantity,
                            'opening_stock' => $item->inv_base_quantity,
                            'consume_during_month' => $item->out_stk,
                            'replenishment' => $stock,
                            'closing_stock' => $bal,
                        );

                        fputcsv($fp, $sc_data);
                    }
                }
                fclose($fp);
                exit;
            }
      
        
    }
    function sickroom_equipment_report(){
        $post_reports = $this->input->post();
        //var_dump($post_reports);
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));
        $to_date = date('Y-m-d', strtotime($post_reports['to_date']));
        $report_args = array('from_date' => $from_date . ' 00:00:01',
            'to_date' => $to_date . ' 23:59:59');

        $report_args['inv_type'] = 'EQP';
        $report_args['eqp_amb'] = (isset($post_reports['school_id'])) ? trim($post_reports['school_id']) : '';

        if ($post_reports['reports'] == 'view') {

            $data['report_args'] = $report_args;
            $data['eqp_list'] = $this->eqp_model->get_eqp($report_args);
            $this->output->add_to_position($this->load->view('frontend/reports/sick_eqp_stock_view', $data, TRUE), $this->post['output_position'], TRUE);
        } else {

            $filename = "sickroom_equipment_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
           $header = array('Name of Equipment', 'Total numbers of equipment’s', 'Total numbers of available equipment’s', 'Total numbers of functional equipment’s', 'Remarks');

     

                $eqp_list = $this->eqp_model->get_eqp($report_args);

                fputcsv($fp, $header);

                $data = array();

                if (!empty($eqp_list)) {
                    foreach ($eqp_list as $eqp) {


                         $bal = 0;

                            $stock = $eqp->in_stk - $eqp->out_stk;

                            if ($stock > 0) {
                                $bal = $stock;
                            } else if ($eqp->in_stk > 0) {
                                $bal = $eqp->in_stk;
                            }
                        $sc_data = array(
                            'inv_title' => stripslashes($eqp->eqp_name),
                            'no_of_quipmens' => $eqp->in_stk,
                            'avail_eqp' => $bal,
                            'fun_eqp' => $eqp->eqp_base_quantity,
                            'remars' => ''
                        );

                        fputcsv($fp, $sc_data);
                    }
                }
                fclose($fp);
                exit;
            }
      
    }
    public function save_export_dist_travel(){
        
        $post_reports = $this->input->post();
        
        

        
        $report_args =  array('from_date' => date('Y-m-d',strtotime($post_reports['from_date'])),
                             'to_date' => date('Y-m-t',strtotime($post_reports['from_date'])));
        
        
        $amb_odometer = array();     
        
        
        $tdd_amb = $this->amb_model->get_tdd_amb();
  
        
        foreach($tdd_amb as $tdd){
           
            $amb_odometer[$tdd->amb_rto_register_no]['month'] = date('M Y',strtotime($post_reports['from_date']));
            $amb_odometer[$tdd->amb_rto_register_no]['amb_rto_register_no'] = $tdd->amb_rto_register_no;
            
            $amb_odometer[$tdd->amb_rto_register_no]['total_km']  =  0;
            $amb_odometer[$tdd->amb_rto_register_no]['avg_km'][]  = 0;
            
            $report_args['amb_reg_no'] =  $tdd->amb_rto_register_no;
            
            $min_odometer = $this->inc_model->get_ambulance_min_odometer($report_args);
            
            $amb_odometer[$tdd->amb_rto_register_no]['min_odometer']  = $min_odometer[0]['start_odmeter']?$min_odometer[0]['start_odmeter']:0;
            
            $max_odometer = $this->inc_model->get_ambulance_max_odometer($report_args);
            $amb_odometer[$tdd->amb_rto_register_no]['max_odometer']  = $max_odometer[0]['end_odmeter']?$max_odometer[0]['end_odmeter']:0;
            
            $report_data = $this->inc_model->get_distance_report_by_date($report_args);
           
            
            
            foreach($report_data as $report){
                
             

                if($report['end_odmeter'] < $report['start_odmeter']){
                    continue;
                }

                $report_odometer = $report['end_odometer'] - $report['start_odometer'];

                if(isset($report['amb_reg_id'])){

                    if(!in_array($report['inc_ref_id'], (array)$amb_odometer[$report['amb_reg_id']]['inc_ref_id'])){ 

                        $amb_odometer[$report['amb_reg_id']]['inc_ref_id'][] = $report['inc_ref_id'];
                        $amb_odometer[$report['amb_reg_id']]['total_km']  +=  $report['total_km'];

                    }


                }

                $amb_odometer[$report['amb_reg_id']]['avg_km'][]  = $report_odometer;


            }
        }
   
    

        $header = array('Month','Ambulance Reg No','Opening Odometer (First day of the Month)','Opening Odometer (First day of the Month)','Total Distance Travelled by Ambulance','Average distance travel per Ambulance');
        
        if($post_reports['reports'] == 'view'){
            
            
            $inc_data = array();
            foreach($amb_odometer as $row) { 

                if(count($row['avg_km']) > 0){
                    $row['avg_km'] = number_format($row['total_km']/count($row['avg_km']),2); 
                }
                $inc_data[] = $row;
            }
    
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            
            $this->output->add_to_position($this->load->view('frontend/reports/month_export_dist_travel_view',$data, TRUE),'list_table',TRUE); 
            
        }else{
            
            $filename = "ambulance_wise_distance_travelled_report.csv";
            $fp = fopen('php://output', 'w');


            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename='.$filename);
            fputcsv($fp, $header);

            $data = array();
            foreach($amb_odometer as $row) {
                $row1['month'] = $row['month'];
                $row1['amb_rto_register_no'] = $row['amb_rto_register_no'];
                $row1['min_odometer'] = $row['min_odometer'];
                $row1['max_odometer'] = $row['max_odometer'];
                $row1['total_km'] = $row['total_km'];
                if(count($row['avg_km']) > 0){
                    $row1['avg_km'] = number_format($row['total_km']/count($row['avg_km']),2); 
                }
                fputcsv($fp, $row1);

            }

            fclose($fp);
            exit;
        }

    }
    public function save_export_inc(){
        
        $post_reports = $this->input->post();

        $report_args =  array('from_date' => date('Y-m-d',strtotime($post_reports['from_date'])),
                              'to_date' => date('Y-m-d',strtotime($post_reports['to_date'])));
        

        $report_data = $this->inc_model->get_inc_report_by_date($report_args);
        
       $header = array('Incident Id','Caller Number','Caller Name','District','SHP ID','Transport Ambulance Dspatched','Transport Ambulance Number','Patient Name','Patient Age','Chief Complaint','Patient Count','Case study','Summary');
       
        
        if($post_reports['reports'] == 'view'){
            
            
        $inc_data = array();
        foreach($report_data as $row) {
            
            $args = array('inc_ref_id'=>$row['inc_ref_id']);
            
            
            $patient_info = $this->pcr_model->get_pat_by_inc($args);
            $ptn_count = count($patient_info);
            
            $amb = $this->inc_model->get_inc_ambulance_for_report($args);
            
            
       
            $clg_emso_id = $row['emt_emso_id'];
            
            foreach($amb as $amb_data){
                   $transport_amb  = $amb_data->hp_name;
                   $transport_respond_amb_no  = $amb_data->amb_rto_register_no;
                    

            }
            
            
            $inc_data[] = array('inc_id'=> $row['inc_ref_id'],
                              'clr_mobile' => $row['clr_mobile'],
                              'clr_fullname' => $row['clr_fullname'],
                              'dst_name'     => $row['dst_name'],
                              'emso_id'                => $clg_emso_id,
                              'transport_amb' =>    $transport_amb,
                              'transport_amb_no'     => $transport_respond_amb_no,
                              'patient_name'     => $row['ptn_fullname'],
                              'patient_age'     => $row['ptn_age'],
                              'ct_type'     => $row['ct_type'],
                              'inc_patient_cnt'     => $ptn_count,   
                              'case_stury'       => '',
                              'summary'          => $row['inc_ero_summary']
                );
            }
            $data['header'] = $header;
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/reports/inc_report_view',$data, TRUE),'list_table',TRUE); 
        }else{
     
        
        $filename = "incident.csv";
        $fp = fopen('php://output', 'w');


        
        
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename='.$filename);
        fputcsv($fp, $header);
        

        $data = array();
        foreach($report_data as $row) {
            
            $args = array('inc_ref_id'=>$row['inc_ref_id']);
            
            $patient_info = $this->pcr_model->get_pat_by_inc($args);
            $ptn_count = count($patient_info);
            
            $amb = $this->inc_model->get_inc_ambulance($args);
            
             $clg_emso_id = $row['emt_emso_id'];
            foreach($amb as $amb_data){
                    $transport_amb  = $amb_data->hp_name;
                    $transport_respond_amb_no  = $amb_data->amb_rto_register_no;
            
            }
            
            
            $data = array('inc_id'=> $row['inc_ref_id'],
                              'clr_mobile' => $row['clr_mobile'],
                              'clr_fullname' => $row['clr_fullname'],
                              'dst_name'     => $row['dst_name'],
                              'emso_id'                => $clg_emso_id,
                              'transport_amb' =>    $transport_amb,
                              'transport_amb_no'     => $transport_respond_amb_no,
                              'patient_name'     => $row['ptn_fullname'],
                              'patient_age'     => $row['ptn_age'],
                              'ct_type'     => $row['ct_type'],
                              'inc_patient_cnt'     => $ptn_count,   
                              'case_stury'       => '',
                              'summary'          => $row['inc_ero_summary']
                );
            fputcsv($fp, $data);
        }

        fclose($fp);
        exit;
        }
        
    }
    
    function amb_onroad_offroad_report(){
        $post_reports = $this->input->post();
       
        
        $report_args =  array('from_date' => date('Y-m-d',strtotime($post_reports['from_date'])),
                             'to_date' => date('Y-m-t',strtotime($post_reports['from_date'])),
                              'amb_status'=> '7,8');
        
        $header = array('Ambulance  Reg.No.','Base location','No.of on-road hrs during month','No.of off-road hrs during month','No.of off-road hrs due to breakdown And Others');
        $report_data = $this->inc_model->get_amb_status_summary_date($report_args);
        $amb_off_road_data = array();     
        
        $seconds_in_month = strtotime($report_args['to_date'].' 00:00:01') - strtotime($report_args['from_date'].' 23:59:59');
        
        $H = floor($seconds_in_month / 3600);
        $i = ($seconds_in_month / 60) % 60;
        $s = $seconds_in_month % 60;
        $totol_hour_in_month = sprintf("%02d:%02d:%02d", $H, $i, $s);

   
        foreach($report_data as $report){
            
           $amb_off_road_data[$report['amb_rto_register_no']]['total_hour'] = $totol_hour_in_month;
               
           $off_road_date = $report['off_road_date'];
           $off_road_time = $report['off_road_time'];
           
           $on_road_date = $report['on_road_date'];
           $on_road_time = $report['on_road_time'];
           
           $off_road = strtotime($off_road_date.' '.$off_road_time);
           
           $on_road = strtotime($on_road_date.' '.$on_road_time);
            $time_diff = $on_road - $off_road;
            if($time_diff > 0){
              
                $amb_off_road_data[$report['amb_rto_register_no']]['off_road']  +=  $time_diff;
            }
            $amb_off_road_data[$report['amb_rto_register_no']]['on_road']  =  $seconds_in_month - $time_diff ;
            $amb_off_road_data[$report['amb_rto_register_no']]['total_hour_second']  =  $seconds_in_month ;
            $amb_off_road_data[$report['amb_rto_register_no']]['hp_name']  =  $report['hp_name'] ;

        }
        
       
        if($post_reports['reports'] == 'view'){
            
           
    
            $data['header'] = $header;
            $data['inc_data'] = $amb_off_road_data;
            $data['report_args'] = $report_args;
            
            $this->output->add_to_position($this->load->view('frontend/reports/onroad_ofroad_view',$data, TRUE),'list_table',TRUE); 
            
        }else{
            
            $filename = "Annexure_B-VII-Vehicle_Status_Information_Report.csv";
            $fp = fopen('php://output', 'w');


            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename='.$filename);
            fputcsv($fp, $header);

            $data = array();
            foreach($amb_off_road_data as $key=>$amb_data) {
              
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
                $break_down= sprintf("%02d:%02d:%02d", $on_H, $on_i, $on_s);
                $row['break_down'] = $break_down;
               
                fputcsv($fp, $row);

            }

            fclose($fp);
            exit;
        }
     

      
    }
    public function save_export_patient(){
        
        $post_reports = $this->input->post();
        
        $report_args =  array('from_date' => date('Y-m-d',strtotime($post_reports['from_date'])),
                              'to_date' => date('Y-m-d',strtotime($post_reports['to_date'])));
        
        $report_data = $this->inc_model->get_patient_report_by_date($report_args);
  
        
        $header = array('Caller Number','Caller Disconnected Time','Time at which ambulance reach at site','Response Time','Registration No Of Ambulance','Base Location of Ambulance','Location of the Incident','Hospital In which the patient was admited','Code no of hospital','Urban/Rural');
        
      if($post_reports['reports'] == 'view'){
          
       $inc_data = array();
       foreach($report_data as $row) {
           
      //  var_dump($row);
      //  die();
        $call_recived_time = date('H:i:s',strtotime($row['inc_datetime']));
        $call_recived_date = date('Y-m-d',strtotime($row['inc_datetime']));
         
        $driver_data = $this->pcr_model->get_driver(array('dp_pcr_id' => $row['epcr_id']));

        $base_loc_time =  $call_recived_date.' '.$driver_data[0]->dp_started_base_loc;
        
        $resonse_time = '';

        $resonse_time = $driver_data[0]->responce_time;
        
        $args = array('inc_ref_id'=>$row['inc_ref_id']);
        
            $amb = $this->inc_model->get_inc_ambulance($args);
            foreach($amb as $amb_data){
                $transport_respond_base  = $amb_data->hp_name;
                $transport_respond_amb_no  = $amb_data->amb_rto_register_no;
                
            }
            $hp_args = array('hp_id' => $row['rec_hospital_name']);
            $hp_data = $this->hp_model->get_hp_data($hp_args);
          
            if($row['rec_hospital_name'] == '0'){
                $hp_name = 'On scene care';
            }else if($row['rec_hospital_name'] == 'Other'){
                $hp_name = 'Other';
            }else{
                $hp_name = $hp_data[0]->hp_name;
            }
            
            if($hp_data[0]->hp_type == '1'){
                $hp_type = 'Rural';
            }else if($hp_data[0]->hp_type  == '2'){
                $hp_type = 'Urban';
            }else if($hp_data[0]->hp_type  == '3'){
                $hp_type = 'Metro';
            }else if($hp_data[0]->hp_type  == '4'){
                $hp_type = 'Tribal';
            }
            
            $inc_data[] = array(   
                              'clr_mobile'         => $row['clr_mobile'], 
                              'call_dis_time'      => $call_recived_time, 
                              'amb_reach_time'     => $driver_data[0]->dp_started_base_loc, 
                              'responce_time'      => $resonse_time,
                              'respond_amb_no'     => $transport_respond_amb_no,
                              'respond_amb_base'   => $transport_respond_base,
                              'inc_address'        => $row['inc_address'],
                              'hospital'           => $hp_name,
                              'code_no_hos'        => $hp_data[0]->hp_register_no,
                              'urban'              => $hp_type,

                );
             
             
        }
       
        
        $data['header'] = $header;
        $data['inc_data'] = $inc_data;
        $data['report_args'] = $report_args;
        $this->output->add_to_position($this->load->view('frontend/reports/ptn_report_view',$data, TRUE),'list_table',TRUE); 
          
      }else{
        $filename = "patient_report.csv";
        $fp = fopen('php://output', 'w');

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename='.$filename);
        fputcsv($fp, $header);
            $data = array();
        foreach($report_data as $row) {
            
        $call_recived_time = date('H:i:s',strtotime($row['inc_datetime']));
        
        
        $args = array('inc_ref_id'=>$row['inc_ref_id']);
            $amb = $this->inc_model->get_inc_ambulance($args);
            foreach($amb as $amb_data){
               
                    $transport_respond_base  = $amb_data->hp_name;
                    $transport_respond_amb_no  = $amb_data->amb_rto_register_no;
                
            }
            
            $hp_args = array('hp_id' => $row['rec_hospital_name']);
            $hp_data = $this->hp_model->get_hp_data($hp_args);
          
            if($row['rec_hospital_name'] == '0'){
                $hp_name = 'On scene care';
            }else if($row['rec_hospital_name'] == 'Other'){
                $hp_name = 'Other';
            }else{
                $hp_name = $hp_data[0]->hp_name;
            }
            
            if($hp_data[0]->hp_type == '1'){
                $hp_type = 'Rural';
            }else if($hp_data[0]->hp_type  == '2'){
                $hp_type = 'Urban';
            }else if($hp_data[0]->hp_type  == '3'){
                $hp_type = 'Metro';
            }else if($hp_data[0]->hp_type  == '4'){
                $hp_type = 'Tribal';
            }
            
            
            $call_recived_time = date('H:i:s',strtotime($row['inc_datetime']));
            $call_recived_date = date('Y-m-d',strtotime($row['inc_datetime']));

            $driver_data = $this->pcr_model->get_driver(array('dp_pcr_id' => $row['epcr_id']));

            $base_loc_time =  $call_recived_date.' '.$driver_data[0]->dp_started_base_loc;

            $resonse_time = '';

            $resonse_time = $driver_data[0]->responce_time;
            $data = array(   
                              'clr_mobile'         => $row['clr_mobile'], 
                              'call_dis_time'      => $call_recived_time, 
                              'amb_reach_time'     => $driver_data[0]->dp_started_base_loc, 
                              'responce_time'      => $resonse_time,
                              'respond_amb_no'     => $transport_respond_amb_no,
                              'respond_amb_base'   => $transport_respond_base,
                              'inc_address'        => $row['inc_address'],
                              'hospital'           => $hp_name,
                              'code_no_hos'        => $hp_data[0]->hp_register_no,
                              'urban'              => $hp_type

                );
             fputcsv($fp, $data);
             
        }
        fclose($fp);
        exit;
      }
        
    }
}