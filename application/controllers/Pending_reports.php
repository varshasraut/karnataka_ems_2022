<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pending_reports extends EMS_Controller {

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
    public function index($generated = false) {

        $mcode = 'M-ERC-REPORTS';
        $data['tool_data'] = $this->module_model->get_tools_by_mcode($mcode);
        $this->output->add_to_position($this->load->view('frontend/erc_reports/erc_reports_list_view', $data, TRUE), $this->post['output_position'], TRUE);
    }
    function load_erc_report_form() {
        // echo 'kkk';die;
        $report_type = $this->input->post('report_type');

        if ($report_type == 'all_cases_report') {
            $data['report_name'] = "Assigned Closed and Pending for Closure Report";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/all_assigned_cases_filter_view', $data, TRUE), $output_position, TRUE);
        }
    }    
    function load_all_cases_filter_form(){
        $report_type = $this->input->post('emp_report_type');

        if ($report_type === '1') {
            $data['submit_function'] = "zone_wise_cases";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/all_cases_date_filter_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_employee_report_block_fields', TRUE);
             $this->output->add_to_position('', 'user_employee_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
        elseif ($report_type === '2') {
            $data['submit_function'] = "dist_wise_cases";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/all_cases_date_filter_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_employee_report_block_fields', TRUE);
             $this->output->add_to_position('', 'user_employee_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
        elseif ($report_type === '3') {
            $data['submit_function'] = "amb_wise_cases";
            $this->output->add_to_position($this->load->view('frontend/erc_reports/all_cases_date_filter_view', $data, TRUE), 'Sub_report_block_fields', TRUE);
            $this->output->add_to_position('', 'Sub_employee_report_block_fields', TRUE);
             $this->output->add_to_position('', 'user_employee_report_block_fields', TRUE);
            $this->output->add_to_position('', 'list_table', TRUE);
        }
        
    }
    function zone_wise_cases(){
        $post_reports = $this->input->post();
        $clg = $this->session->userdata('current_user');

        $base_today = date('Y-m-d', strtotime($post_reports['to_date']));
        $base_month = $this->common_model->get_base_month($base_today);

        $base_month = $base_month[0]->months;
        if($this->clg->clg_group ==  'UG-DM' || $this->clg->clg_group ==  'UG-ZM'){
        // print_r($clg);die;
        // $report_args = $post_reports['div_name'];
        $dis =  $clg->clg_district_id;
            $dis = json_decode($dis);
        $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
        'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
        'zone'=> $clg->clg_zone,
        'district'=> $dis
      
            );
        }
        else{
            $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
            'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
        );
        }
        // print_r($report_args);die;
            $report_data = [];
            $assing = $this->inc_model->get_assigned_cases_report_zone($report_args);
            $closed = $this->inc_model->get_closed_cases_report_zone($report_args);
            $pendclose= $this->inc_model->get_pending_colsure_cases_report_zone($report_args);
            for($i=0;$i<count($assing);$i++){
                if($closed[$i]->closed == null)
                {
                    $closed1 = 0;
                }
                else{$closed1 = $closed[$i]->closed;}
                if($pendclose[$i]->pendclose == null)
                {
                    $pendclose1 = 0;
                }
                else{$pendclose1 = $pendclose[$i]->pendclose;}
                $pen = (float)$pendclose[$i]->pendclose;
                $assign = (float)$assing[$i]->assing;
                $per = ($pen/$assign)*100;
                $per = number_format((float)$per, 2, '.', '');
                    $arr= array(
                        'Sr_No'=> $i+1,
                        'zone'=>$assing[$i]->div_name,
                        'assign'=>$assing[$i]->assing,
                        'closed'=>$closed1,
                        'pendclose'=>$pendclose1,
                        'perc'=>$per
                        
                    );
                    array_push($report_data,$arr);
            }
            
      
           $header = array('Sr No.','Zone','Assigned Cases','Closed Cases','Pending for Closure', 'Pending for Closure %');

           if ($post_reports['reports'] == 'view') {       
            $data['header'] = $header;
            $data['inc_data'] = $report_data;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/all_cases_assigned_download_view', $data, TRUE), 'list_table', TRUE);
            
        }else{
            
            $filename = "zone_wise_case_report.csv";
            $fp = fopen('php://output', 'w');
            $count=1;
            //header('Content-type: application/csv; charset=UTF-8');
            //header('Content-Disposition: attachment; filename=' . $filename);
            
            header('Content-Encoding: UTF-8');
            header('Content-type: text/csv; charset=UTF-8');
            header('Content-Disposition: attachment; filename=' . $filename);
            echo "\xEF\xBB\xBF"; // UTF-8 BOM
            fputcsv($fp, $header);
            // var_dump($report_data);die();  
            foreach($report_data as $inc){
                
               
                
            $data = array (
            'sr.no'=>$count,
            'zone'=>$inc['zone'],
            'assign'=>$inc['assign'],
            'closed'=>$inc['closed'],
            'pendclose'=>$inc['pendclose'],
            'perc'=>$inc['perc']." %",
            
            
            );
            
            fputcsv($fp, $data);
            $count++;
            }
            fclose($fp);
            exit;
                 
        }
    }

    function dist_wise_cases(){
        $post_reports = $this->input->post();
        $clg = $this->session->userdata('current_user');
        // $report_args = $post_reports['div_name'];
        $base_today = date('Y-m-d', strtotime($post_reports['to_date']));
        $base_month = $this->common_model->get_base_month($base_today);

        $base_month = $base_month[0]->months;
        
        // $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
        //         'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
        //     );

            $report_data = [];
        //     $assing = $this->inc_model->get_assigned_cases_report_dis($report_args);
        //     $closed = $this->inc_model->get_closed_cases_report_dis($report_args);
        //     $pendclose= $this->inc_model->get_pending_colsure_cases_report_dis($report_args);
        //     for($i=0;$i<count($assing);$i++){
        //         if($closed[$i]->closed == null)
        //         {
        //             $closed1 = 0;
        //         }
        //         else{$closed1 = $closed[$i]->closed;}
        //         if($pendclose[$i]->pendclose == null)
        //         {
        //             $pendclose1 = 0;
        //         }
        //         else{$pendclose1 = $pendclose[$i]->pendclose;}
        //         $pen = (float)$pendclose[$i]->pendclose;
        //         $assign = (float)$assing[$i]->assing;
        //         $per = ($pen/$assign)*100;
        //         $per = number_format((float)$per, 2, '.', '');
        //             $arr= array(
        //                 'Sr_No'=> $i+1,
        //                 'district'=>$assing[$i]->dst_name,
        //                 'assign'=>$assing[$i]->assing,
        //                 'closed'=>$closed1,
        //                 'pendclose'=>$pendclose1,
        //                 'perc'=>$per
                        
        //             );
        //             array_push($report_data,$arr);
        //     }

        if($this->clg->clg_group ==  'UG-DM' || $this->clg->clg_group ==  'UG-ZM'){
            // print_r($clg);die;
            // $report_args = $post_reports['div_name'];
            
            $dis =  $clg->clg_district_id;
            // print_r($dis);die;
            $dis = json_decode($dis);
            // print_r($dis);die;
            foreach($dis as $dist){
        
                // $dist = (array)$dist;
                // print_r($dist);die();
                $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                        'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                        'dst_id' => $dist
                        // 'amb_no' => 'CG-04-NR-7765'
                    );
        
                    // print_r($report_args);die();
                    
                    $assing = $this->inc_model->get_assigned_cases_report_dis($report_args);
                    $assing = (array)$assing;
                    $closed = $this->inc_model->get_closed_cases_report_dis($report_args);
                    $closed = (array)$closed;
                    $pendclose= $this->inc_model->get_pending_colsure_cases_report_dis($report_args);
                    $pendclose = (array)$pendclose;
                    // print_r($assing);die();
                    // print_r($closed);die();
                    // print_r($pendclose);die();
                    for($i=0;$i<count($assing);$i++){
                        if($closed[$i]->closed == null)
                        {
                            $closed1 = 0;
                        }
                        else{$closed1 = $closed[$i]->closed;}
                        if($pendclose[$i]->pendclose == null)
                        {
                            $pendclose1 = 0;
                        }
                        else{$pendclose1 = $pendclose[$i]->pendclose;}
                        
                        if($assing[$i]->assing == 0)
                        {
                            $per = 0;
                        }
                        else{
                            $pen = (float)$pendclose[$i]->pendclose;
                            $assign = (float)$assing[$i]->assing;
                            $per = ($pen/$assign)*100;
                        }
                        $per = number_format((float)$per, 2, '.', '');
                            $arr= array(
                                'Sr_No'=> $i+1,
                                'district'=>$assing[$i]->dst_name,
                                'assign'=>$assing[$i]->assing,
                                'closed'=>$closed1,
                                'pendclose'=>$pendclose1,
                                'perc'=>$per
                                
                            );
                            array_push($report_data,$arr);
                    }
                    // print_r($report_data);die();
                }
            }
            else{
                $dis =  $this->inc_model->get_dist();

                foreach($dis as $dist){
        
                    $dist = (array)$dist;
                    // print_r($dist);die();
                    $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                            'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                            'dst_id' => $dist['dst_id']
                            // 'amb_no' => 'CG-04-NR-7765'
                        );
            
                        // print_r($report_args);die();
                        
                        $assing = $this->inc_model->get_assigned_cases_report_dis($report_args);
                        $assing = (array)$assing;
                        $closed = $this->inc_model->get_closed_cases_report_dis($report_args);
                        $closed = (array)$closed;
                        $pendclose= $this->inc_model->get_pending_colsure_cases_report_dis($report_args);
                        $pendclose = (array)$pendclose;
                        // print_r($assing);die();
                        // print_r($closed);die();
                        // print_r($pendclose);die();
                        for($i=0;$i<count($assing);$i++){
                            if($closed[$i]->closed == null)
                            {
                                $closed1 = 0;
                            }
                            else{$closed1 = $closed[$i]->closed;}
                            if($pendclose[$i]->pendclose == null)
                            {
                                $pendclose1 = 0;
                            }
                            else{$pendclose1 = $pendclose[$i]->pendclose;}
                            
                            if($assing[$i]->assing == 0)
                            {
                                $per = 0;
                            }
                            else{
                                $pen = (float)$pendclose[$i]->pendclose;
                                $assign = (float)$assing[$i]->assing;
                                $per = ($pen/$assign)*100;
                            }
                            $per = number_format((float)$per, 2, '.', '');
                                $arr= array(
                                    'Sr_No'=> $i+1,
                                    'district'=>$dist['dst_name'],
                                    'assign'=>$assing[$i]->assing,
                                    'closed'=>$closed1,
                                    'pendclose'=>$pendclose1,
                                    'perc'=>$per
                                    
                                );
                                array_push($report_data,$arr);
                        }
                        // print_r($report_data);die();
                    }
                       
            }
        
        // print_r($dis);die();
        
      
           $header = array('Sr No.','District Name','Assigned Cases','Closed Cases','Pending for Closure', 'Pending for Closure %');

           if ($post_reports['reports'] == 'view') {       
            $data['header'] = $header;
            $data['inc_data'] = $report_data;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/all_cases_assigned_download_view_dist', $data, TRUE), 'list_table', TRUE);
            
        }else{
            
            $filename = "district_wise_case_report.csv";
            $fp = fopen('php://output', 'w');
            $count=1;
            //header('Content-type: application/csv; charset=UTF-8');
            //header('Content-Disposition: attachment; filename=' . $filename);
            
            header('Content-Encoding: UTF-8');
            header('Content-type: text/csv; charset=UTF-8');
            header('Content-Disposition: attachment; filename=' . $filename);
            echo "\xEF\xBB\xBF"; // UTF-8 BOM
            fputcsv($fp, $header);
            // var_dump($report_data);die();  
            foreach($report_data as $inc){
                
               
                
            $data = array (
            'sr.no'=>$count,
            'district'=>$inc['district'],
            'assign'=>$inc['assign'],
            'closed'=>$inc['closed'],
            'pendclose'=>$inc['pendclose'],
            'perc'=>$inc['perc']." %",
            
            
            );
            
            fputcsv($fp, $data);
            $count++;
            }
            fclose($fp);
            exit;
                 
        }
    }
    function amb_wise_cases(){
        $post_reports = $this->input->post();
        $clg = $this->session->userdata('current_user');
        // $report_args = $post_reports['div_name'];
        $base_today = date('Y-m-d', strtotime($post_reports['to_date']));
        $base_month = $this->common_model->get_base_month($base_today);

        $base_month = $base_month[0]->months;
        if($this->clg->clg_group ==  'UG-DM' || $this->clg->clg_group ==  'UG-ZM'){
            $report_data = [];
            $dis =  $clg->clg_district_id;
            $dis = json_decode($dis);
            
            $amb =  $this->common_model->get_ambulance();
        // print_r($amb);die();
        foreach($amb as $ambs){
        
        $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'amb_no' => $ambs->amb_rto_register_no,
                'dst_id' => $dis
                // 'amb_no' => 'CG-04-NR-7765'
            );
            
            $assing = $this->inc_model->get_assigned_cases_report_amb($report_args);
            
            $closed = $this->inc_model->get_closed_cases_report_amb($report_args);
            $pendclose= $this->inc_model->get_pending_colsure_cases_report_amb($report_args);
            // print_r($assing);die();
            for($i=0;$i<count($assing);$i++){
                if($closed[$i]->closed == null)
                {
                    $closed1 = 0;
                }
                else{$closed1 = $closed[$i]->closed;}
                if($pendclose[$i]->pendclose == null)
                {
                    $pendclose1 = 0;
                }
                else{$pendclose1 = $pendclose[$i]->pendclose;}
                $pen = (float)$pendclose[$i]->pendclose;
                $assign = (float)$assing[$i]->assing;
                $per = ($pen/$assign)*100;
                $per = number_format((float)$per, 2, '.', '');
                    $arr= array(
                        'Sr_No'=> $i+1,
                        'district'=>$assing[$i]->amb_rto_register_no,
                        'amb_default_mobile'=>$assing[$i]->amb_default_mobile,
                        'hp_name'=>$assing[$i]->hp_name,
                        'dst_name'=>$assing[$i]->dst_name,
                        'div_name'=>$assing[$i]->div_name,
                        'ambt_name'=>$assing[$i]->ambt_name,
                        'assign'=>$assing[$i]->assing,
                        'closed'=>$closed1,
                        'pendclose'=>$pendclose1,
                        'perc'=>$per
                        
                    );
                    array_push($report_data,$arr);
            }
            // print_r($report_data);die();
        
        }
    }
      else{  
        $report_data = [];

        $amb =  $this->common_model->get_ambulance();
        // print_r($amb);die();
        foreach($amb as $ambs){
        
        $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'amb_no' => $ambs->amb_rto_register_no
                // 'amb_no' => 'CG-04-NR-7765'
            );
        
            // print_r($report_args);die();
            
            $assing = $this->inc_model->get_assigned_cases_report_amb($report_args);
            
            $closed = $this->inc_model->get_closed_cases_report_amb($report_args);
            $pendclose= $this->inc_model->get_pending_colsure_cases_report_amb($report_args);
            // print_r($assing);die();
            for($i=0;$i<count($assing);$i++){
                if($closed[$i]->closed == null)
                {
                    $closed1 = 0;
                }
                else{$closed1 = $closed[$i]->closed;}
                if($pendclose[$i]->pendclose == null)
                {
                    $pendclose1 = 0;
                }
                else{$pendclose1 = $pendclose[$i]->pendclose;}
                $pen = (float)$pendclose[$i]->pendclose;
                $assign = (float)$assing[$i]->assing;
                $per = ($pen/$assign)*100;
                $per = number_format((float)$per, 2, '.', '');
                    $arr= array(
                        'Sr_No'=> $i+1,
                        'district'=>$assing[$i]->amb_rto_register_no,
                        'amb_default_mobile'=>$assing[$i]->amb_default_mobile,
                        'hp_name'=>$assing[$i]->hp_name,
                        'dst_name'=>$assing[$i]->dst_name,
                        'div_name'=>$assing[$i]->div_name,
                        'ambt_name'=>$assing[$i]->ambt_name,
                        'assign'=>$assing[$i]->assing,
                        'closed'=>$closed1,
                        'pendclose'=>$pendclose1,
                        'perc'=>$per
                        
                    );
                    array_push($report_data,$arr);
            }
            // print_r($report_data);die();
        }
    }
      
           $header = array('Sr No.','Ambulance Name','CUG Number','Base Location','District','Zone','Ambulance Type','Assigned Cases','Closed Cases','Pending for Closure', 'Pending for Closure %');

           if ($post_reports['reports'] == 'view') {       
            $data['header'] = $header;
            $data['inc_data'] = $report_data;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/all_cases_assigned_download_view_amb', $data, TRUE), 'list_table', TRUE);
            
        }else{
            
            $filename = "ambulance_wise_case_report.csv";
            $fp = fopen('php://output', 'w');
            $count=1;
            //header('Content-type: application/csv; charset=UTF-8');
            //header('Content-Disposition: attachment; filename=' . $filename);
            
            header('Content-Encoding: UTF-8');
            header('Content-type: text/csv; charset=UTF-8');
            header('Content-Disposition: attachment; filename=' . $filename);
            echo "\xEF\xBB\xBF"; // UTF-8 BOM
            fputcsv($fp, $header);
            // var_dump($report_data);die();  
            foreach($report_data as $inc){
                
               
                
            $data = array (
            'sr.no'=>$count,
            'district'=>$inc['district'],
            'amb_default_mobile'=>$inc['amb_default_mobile'],
            'hp_name'=>$inc['hp_name'],
            'dst_name'=>$inc['dst_name'],
            'div_name'=>$inc['div_name'],
            'ambt_name'=>$inc['ambt_name'],
            'assign'=>$inc['assign'],
            'closed'=>$inc['closed'],
            'pendclose'=>$inc['pendclose'],
            'perc'=>$inc['perc']." %",
            
            
            );
            
            fputcsv($fp, $data);
            $count++;
            }
            fclose($fp);
            exit;
                 
        }
    }
}