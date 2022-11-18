<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_report extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->active_module = "M-REPORTS";

        $this->pg_limit = $this->config->item('pagination_limit_clg');

        $this->pg_limits = $this->config->item('report_clg');
        $this->load->model(array('inspection_model','colleagues_model', 'get_city_state_model', 'options_model', 'common_model', 'module_model', 'inc_model', 'amb_model', 'pcr_model', 'hp_model', 'school_model', 'eqp_model', 'inv_model', 'police_model', 'fire_model', 'shiftmanager_model', 'Medadv_model', 'feedback_model', 'grievance_model','call_model','ambmain_model','quality_model','module_model','reports_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date'));
        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules', 'simple_excel/Simple_excel'));

        $this->post['base_month'] = get_base_month();
        $this->site_name = $this->config->item('site_name');
        $this->site = $this->config->item('site');

        $this->clg = $this->session->userdata('current_user');
    }
    function view_master_report(){
        $post_reports = $this->input->post();
      // var_dump($post_reports);die;
        $base_today = date('Y-m-d', strtotime($post_reports['to_date']));
        $base_month = $this->common_model->get_base_month($base_today);

        $base_month = $base_month[0]->months;
        if (strstr($post_reports['team_type'], 'ERO-102')) {
            $team_type= '102';
        } elseif((strstr($post_reports['team_type'], '-ERO'))){
            $team_type = '108';
         }
         else{
            $team_type = 'all';  
         }
         $thirdparty = $this->clg->thirdparty;
        $district = $this->clg->clg_district_id;
        $clg_district_id = json_decode($district);
        if(is_array($clg_district_id)){
            $district_id = implode("','",$clg_district_id);
        }
        $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month'],
                'inc_added_by'=> $post_reports['user_id'],
                'team_type'=> $team_type,
                'thirdparty' => $thirdparty,
                'clg_district_id' => $district_id,
                'inc_type'=>$post_reports['call_purpose'],
                'base_month'=>$base_month
            );
           
            // if($this->post['team_type'] != ''){
            //     $team_type =$args_dash['team_type'] = $data['team_type']= $this->post['team_type'];
            // }
               
            //$report_args['team_type']=$this->input->post('team_type');
      // var_dump($report_args);die;
        $report_data = $this->inc_model->get_master_report($report_args);
      //var_dump($report_args);
        
        //    $header = array('Month', 'Date','Time','Incident Id','ERO Name','Call Start Time','Call End Time','Total Duration of call','Call Purpose','Call Type','Chief Complaint','Caller Number', 'Caller Name','Relation with Patient','Patient Name','Gender','Age','Incident Address','District','Current District','Current Facility','Reporting Doctor','Facility Mobile Number','New District', 'New Facility', 'Reporting Doctor', 'Mobile Number', 'Base Location','Ward Name','Type of Ambulance','Ambulance Number','Ambulance Category','ERO Standerd Remark','ERO Remark','Assign Time','Start From Base','At scene','From Scene','At Hospital/ Ambulance','Hand over','Back to base','Name of Receiving Hospital','Other-Receiving Hospital','Previous Odometer','Start Odometer','Scene Odometer','Hospital Odometer','End Odometer','DCO Remark','EMT ID','EMT Name','EMT Mob','Pilot ID','Pilot Name','Pilot Other','Pilot Mob','Case Type','Provider Impressions','Other-Provider Impression','Case Closure Date','ERCP Advice','ERCP Doctor','DCO','DCO Name'); 
           $header = array('Month', 'Date','Time','Incident Id','ERO Name','Call Start Time','Call End Time','Total Duration of call','Call Purpose','Call Type','Chief Complaint','Caller Number', 'Caller Name','Relation with Patient','Patient Name','Gender','Age', 'Patient Condition', 'Incident Address','District','Current District','Current Facility','Reporting Doctor','Facility Mobile Number','New District', 'New Facility', 'Reporting Doctor', 'Mobile Number', 'Base Location','Type of Ambulance','Ambulance Number','Ambulance Area','ERO Standard Remark','ERO Remark','Assign Time','Start From Base','At scene','From Scene','At Hospital/ Ambulance','Hand over','Back to base','Name of Receiving Hospital','Other-Receiving Hospital','Previous Odometer','Start Odometer','Scene Odometer','Hospital Odometer','End Odometer','DCO Remark','EMT ID','EMT Name','EMT Mob','Pilot ID','Pilot Name','Pilot Mob','Case Type','Provider Impressions','Other-Provider Impression','Case Closure Date','Case Closure Time','ERCP Advice','ERCP Doctor','DCO','DCO Name'); 

        if ($post_reports['reports'] == 'view') {       
            $data['header'] = $header;
            $data['inc_data'] = $report_data;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/main_master_report_view', $data, TRUE), 'list_table', TRUE);
            
        }else{
            
            $filename = "master_report.csv";
            $fp = fopen('php://output', 'w');

            //header('Content-type: application/csv; charset=UTF-8');
            //header('Content-Disposition: attachment; filename=' . $filename);
            
            header('Content-Encoding: UTF-8');
            header('Content-type: text/csv; charset=UTF-8');
            header('Content-Disposition: attachment; filename=' . $filename);
            echo "\xEF\xBB\xBF"; // UTF-8 BOM
            fputcsv($fp, $header);
            //var_dump($report_data);die();  
            foreach($report_data as $inc){
                
                
                if($inc->inc_added_by != ''){ 
                    
                    $ero = get_clg_data_by_ref_id($inc->inc_added_by);
                
                $ero_name = ucwords($ero[0]->clg_first_name.' '.$ero[0]->clg_mid_name.' '.$ero[0]->clg_last_name);
            } 
            /* if($inc->amb_emt_id != ''){
                $emt = get_clg_data_by_ref_id($inc->amb_emt_id);
                $amb_emt_name = ucwords($emt[0]->clg_first_name.' '.$emt[0]->clg_mid_name.' '.$emt[0]->clg_last_name);
             }else{
                 $amb_emt_name = "";
                }
             
                if($inc->amb_pilot_id != ''){
                $pilot = get_clg_data_by_ref_id($inc->amb_pilot_id); 
                $amb_pilot_name = ucwords($pilot[0]->clg_first_name.' '.$pilot[0]->clg_mid_name.' '.$pilot[0]->clg_last_name);
            }else{
                $amb_pilot_name='';
            }*/
            
            if($inc->ercp_advice_Taken != ''){
                
                $ercp_advice = get_clg_data_by_ref_id($inc->ercp_advice_Taken); 
                $ercp_advice_Taken_name = ucwords($ercp_advice[0]->clg_first_name.' '.$ercp_advice[0]->clg_mid_name.' '.$ercp_advice[0]->clg_last_name);
                
            }else{
                
                $ercp_advice_Taken_name="";
            }
            
            if($inc->operate_by != ''){
                $operate_by = explode(',',$inc->operate_by);
                $dco_name_array = array();
                if(is_array($operate_by)){
                    
                    foreach($operate_by as $operate){
                        
                    $dco = get_clg_data_by_ref_id($operate); 
                    $dco_name_array[] = ucwords($dco[0]->clg_first_name.' '.$dco[0]->clg_mid_name.' '.$dco[0]->clg_last_name);
                    }
                    $dco_name = implode(',',$dco_name_array);
                    
                }else{
                    $dco = get_clg_data_by_ref_id($inc->operate_by); 
                    $dco_name = ucwords($dco[0]->clg_first_name.' '.$dco[0]->clg_mid_name.' '.$dco[0]->clg_last_name);
                }
            }else{
                
                $dco_name="";
            }
            $inc_type = '';
            if($inc->inc_type != ''){
            $inc_type = get_purpose_of_call($inc->inc_type);
            }
            $cl_purpose = '';
             if($inc->inc_type != ''){
            $cl_purpose = get_parent_purpose_of_call($inc->inc_type);
             }
            if($inc->inc_complaint != 0){
                $inc_complaint = get_cheif_complaint($inc->inc_complaint);
                if($inc_complaint == 'Other')
                {
                    $inc_complaint=$inc_complaint.'-'.$inc->inc_complaint_other; 
                }else{ 
                    $inc_complaint=$inc_complaint; 
                } 
            }else{
                  $inc_complaint = get_mci_nature_service($inc->inc_mci_nature);
            }
            $clr_ralation ='';
            if($inc->clr_ralation != ''){
                $clr_ralation  = get_relation_by_id($inc->clr_ralation);
            }
            $district_id = "";
            if($inc->inc_district_id != 0 && !empty($inc->inc_district_id)){
                $district_id = get_district_by_id($inc->inc_district_id); 
                
            }
     //var_dump($inc->current_district);die;
    if($inc->current_district != 0 && $inc->current_district != ''){
        $current_district = get_district_by_id($inc->current_district); }  else{
        $current_district = "";
    }   
    
if($inc->new_district != '0' && !empty($inc->new_district)){ $new_district = get_district_by_id($inc->new_district); } else{ $new_district = "";}  

          /*  if($inc->amb_base_location != '' || $inc->amb_base_location != 0 ){ 
                $amb_base_location1 = get_base_location_by_id($inc->amb_base_location);
                $amb_base_location = $amb_base_location1[0]->hp_name;
           
            }else{
                $amb_base_location = "";
            }*/
            $rec_hospital_name = "";
           /* if($inc->rec_hospital_name != '' || $inc->rec_hospital_name != 0 ){ 
              $rec_hospital = get_hospital_by_id($inc->rec_hospital_name);
              $rec_hospital_name = $rec_hospital[0]->hp_name;
              
            }else{
                $rec_hospital_name = "Other";
            }*/
            if ($inc->rec_hospital_name == 'Other'  ) {
                $rec_hospital_name = 'Other';
            } else if ($inc->rec_hospital_name == 'on_scene_care'){
                $rec_hospital_name = 'On Scene Care';
            } else if ($inc->rec_hospital_name == 'at_scene_care'){
                $rec_hospital_name = 'At Scene Care';
            }else if ($inc->rec_hospital_name == '' || $inc->rec_hospital_name == '0'){
                $rec_hospital_name = '';
            }else if ($inc->rec_hospital_name == 'Patient_Not_Available'){
                $rec_hospital_name = 'Patient Not Available';
            }else {
                $rec_hospital = get_hospital_by_id($inc->rec_hospital_name);
                $rec_hospital_name = $rec_hospital[0]->hp_name;
                //$rec_hospital_name = $row['hp_name'];
            } 
            if($inc->facility != NULL && $inc->facility != '0' ){
                $facility = get_hospital_by_id($inc->facility);
                $facility_name = $facility[0]->hp_name;
             
              }else{
                  $facility_name = "";
              }
              if($inc->new_facility != NULL && $inc->new_facility != '0' ){
                $new_facility = get_hospital_by_id($inc->new_facility);
                $new_facility_name = $new_facility[0]->hp_name;
             
              }else{
                  $new_facility_name = "";
                }
                
            if($inc->amb_type != '' || $inc->amb_type != 0 ){ 
               $amb_type =  show_amb_type_name($inc->amb_type);
            }else{
                $amb_type = "";
            }
             if($inc->provider_impressions != ''){ $provider_impressions = get_provider_impression($inc->provider_impressions); }else{ $provider_impressions = ""; }
             
            if($inc->amb_working_area != ""){  $amb_working_area =   show_area_type_name($inc->amb_working_area); }else{ $amb_working_area =  ""; }
            
            $date_a = new DateTime($inc->inc_recive_time);
            $date_b = new DateTime($inc->inc_datetime);

            $interval = date_diff($date_a,$date_b);
            
            $call_duration = $interval->format('%h:%i:%s');
            $start_date1=date("Y-m-d", strtotime($inc->inc_recive_time));
            $start_date2=date("H:i:s", strtotime($inc->inc_recive_time));
            $end_date1=date("Y-m-d", strtotime($inc->inc_datetime));
            $end_date2=date("H:i:s", strtotime($inc->inc_datetime));
            $interval=$interval;
            
            $inc_dispatch_time=date("Y-m-d", strtotime($inc->inc_dispatch_time));
            $start_from_base=date("Y-m-d", strtotime($inc->start_from_base));
            $dp_on_scene=date("Y-m-d", strtotime($inc->dp_on_scene));
            $dp_reach_on_scene=date("Y-m-d", strtotime($inc->dp_reach_on_scene));
            $dp_hosp_time=date("Y-m-d", strtotime($inc->dp_hosp_time));
            $dp_hand_time=date("Y-m-d", strtotime($inc->dp_hand_time));
            $dp_back_to_loc=date("Y-m-d", strtotime($inc->dp_back_to_loc));

            $inc_dispatch_time1=date("H:i:s", strtotime($inc->inc_dispatch_time1));
            $start_from_base1=date("H:i:s", strtotime($inc->start_from_base1));
            $dp_on_scene1=date("H:i:s", strtotime($inc->dp_on_scene1));
            $dp_reach_on_scene1=date("H:i:s", strtotime($inc->dp_reach_on_scene1));
            $dp_hosp_time1=date("H:i:s", strtotime($inc->dp_hosp_time1));
            $dp_hand_time1=date("H:i:s", strtotime($inc->dp_hand_time1));
            $dp_back_to_loc1=date("H:i:s", strtotime($inc->dp_back_to_loc1));
            $closure_date = '';
            if($inc->date != ''){ 
                $closure_date = date('Y-m-d',strtotime($inc->date)); 
                // $closure_date = $inc->date;
            }
            $closure_time = '';
            if($inc->time != ''){ 
                $closure_time = date("H:i:s",strtotime($inc->time)); 
                // $closure_date = $inc->date;
            }
            if(!empty($inc->start_from_base) && $inc->start_from_base != NULL){
                //var_dump($inc->start_from_base);
                $start_from_base = date("Y-m-d H:i:s", strtotime($inc->start_from_base)); 
            }else{
                $start_from_base="";
            }
           //  var_dump($start_from_base);
            if($inc->ercp_advice=='advice_Yes'){ $ercp_advice = 'YES'; } else { $ercp_advice='NO'; }
            if($inc->ptn_gender=='F'){ $gender = 'Female'; }elseif($inc->ptn_gender=='M'){ $gender = 'Male'; }elseif($inc->ptn_gender=='O'){ $gender = 'Transgender'; }else{ $gender = '-'; }
            
            $data = array ('month' => date("F, Y", strtotime($report_args['to_date'])),
            'date'=> date("Y-m-d", strtotime($inc->inc_datetime)),
            'time'=>date("H:i:s", strtotime($inc->inc_datetime)),
            'inc_ref_id'=>$inc->inc_ref_id,
            'ero_name'=>$ero_name, 
           // 'clg_avaya_id'=>$ero[0]->clg_avaya_id, 
            'call_start_date'=>$start_date1.' '.$start_date2,
            'call_end_date'=>$end_date1.' '.$end_date2,
            'interval'=>$interval->format('%h:%i:%s'),
            //'inc_inc_dispatch_time'=>$inc->inc_dispatch_time,
            'call_purpose'=> ucwords($cl_purpose),
            'call_type'=> ucwords($inc_type),
            'inc_complaint'=> $inc_complaint,
            'clr_mobile'=> $inc->clr_mobile,
            // 'clr_name' => ucwords($inc->clr_fname).' '.ucwords($inc->clr_lname),
            'clr_name' => ucwords(strtolower($inc->clr_fname)).' '.ucwords(strtolower($inc->clr_lname)),
            'clr_ralation' =>  $clr_ralation,
            'ptn_fname' =>  ucwords(strtolower($inc->ptn_fname)).' '.ucwords(strtolower($inc->ptn_lname)), 
            'ptn_gender' =>  $gender, 
            'ptn_age' =>  $inc->ptn_age,
            'ptn_condition' =>  $inc->ptn_condition,
// Try 
            // 'ptn_age' =>  $inc->ptn_age.' '.$inc->ptn_age_type,
            // 'ptn_age' =>  preg_replace('/[^0-9]/', '',$inc->ptn_age).' '.preg_replace('/[^0-9]/', '',$inc->ptn_age_type),
// 
            'Incident Address' =>  $inc->inc_address,
            'inc_district_id' =>  $district_id,
            'curent_district_id' => $current_district,
            'facility' =>  $facility_name, 
            'rpt_doc' =>  ucwords(strtolower($inc->rpt_doc)), 
            'mo_no' =>  $inc->mo_no,
            'new_district' => $new_district,
            'clr_new_facility' => $new_facility_name,
            'new_rpt_doc' =>  ucwords(strtolower($inc->new_rpt_doc)),
            'new_mo_no' =>  $inc->new_mo_no,
            'amb_base_location' =>$inc->base_location_name, 

// Ashok Sir Told Remove this Fild
            // 'Ward_name' =>$inc->ward_name, 
// 
            'amb_type' =>  $amb_type,
            'amb_rto_register_no' =>  $inc->amb_rto_register_no, 
            'amb_working_area' =>  $amb_working_area,  #
            'ERO Standerd Summary' => ucwords($inc->re_name)    , 
            'ERO Summary' =>  ucwords($inc->inc_ero_summary), 
            'inc_dispatch_time' =>  $inc->inc_datetime, 
            'start_from_base' =>  $start_from_base,
            'dp_on_scene' =>  $inc->dp_on_scene, 
            'dp_reach_on_scene' =>  $inc->dp_reach_on_scene, 
            'dp_hosp_time' =>  $inc->dp_hosp_time, 
            'dp_hand_time' =>  $inc->dp_hand_time, 
            'dp_back_to_loc' =>  $inc->dp_back_to_loc, 
            'rec_hospital_name' =>  $rec_hospital_name,
            'other_receiving_host' => ucwords(strtolower($inc->other_receiving_host)),
            'previos_odometer' =>  $inc->start_odometer,
            'start_odometer' =>  $inc->start_odometer,
            //'call_duration'=>$call_duration,
            'scene_odometer' =>  $inc->scene_odo,
            'hospital_odometer' =>  $inc->hospital_odo,
            'end_odometer' =>  $inc->end_odometer, 
            'remark' =>  $inc->remark,
            /*'amb_emt_id' =>  $inc->amb_emt_id,
            'amb_emt_name'=>$amb_emt_name,
            'amb_pilot_id'=> $inc->amb_pilot_id,
            'amb_pilot_name'=>$amb_pilot_name,*/
            'emt_id' =>  $inc->emso_id,
            'emt_name'=>$inc->emt_name,
            // 'emt_other'=>$inc->emt_id_other,
            'amb_default_mobile'=>$inc->amb_default_mobile,
            'pilot_id'=> $inc->pilot_id,
            'pilot_name'=>$inc->pilot_name,
            // 'pilot_other'=> $inc->pilot_id_other,
            'amb_pilot_mobile'=>$inc->amb_pilot_mobile,
            'casetype'=>$inc->case_type,
            'provider_impressions'=> $provider_impressions,
            'other_provider_impressions' => $inc->other_provider_img,
            'provider_date'=>$closure_date,
            'provider_time'=>$closure_time,
            
            //'current_district' =>  $current_district,
            'ERCP Advice'=> $ercp_advice,
            'ERCP Advice Doctor'=> $ercp_advice_Taken_name,
            'operate_by'=>strtoupper($inc->operate_by),
            'dco_name'=>$dco_name);
            
            fputcsv($fp, $data);
            $count++;
            $inc_complaint='';
            }
            fclose($fp);
            exit;
                 
        }
        //var_dump($post_reports);die;
        if($post_reports['flt'] == 'reset'){
            $data=array();
            $data['submit_function'] = "load_erc_report_form";
            $data['title'] = "Master Report";
            
            $this->output->add_to_position($this->load->view('frontend/erc_reports/master_reports_view', $data, TRUE), $output_position, TRUE);
           
           // $this->output->add_to_position('', 'Sub_date_report_block_fields', TRUE);
            $this->output->add_to_position('', $output_position, TRUE);
        }
    }

    function view_pending_closure_report(){
        $post_reports = $this->input->post();
        $clg = $this->session->userdata('current_user');
    
      // var_dump($post_reports);die;
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
            'district'=> $dis
          
                );
            }
        
        else{
        $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
            );
        }
            
        $report_data = $this->inc_model->get_pending_closure_report($report_args);
      
           $header = array('Sr No.','Incident ID','Incident Date & Time', 'Ambulance Registration Number','Ambulance CUG No','Zone','District','Base Location','Ambulance Type'); 

        if ($post_reports['reports'] == 'view') {       
            $data['header'] = $header;
            $data['inc_data'] = $report_data;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/pending_closure_download_view', $data, TRUE), 'list_table', TRUE);
            
        }else{
            
            $filename = "pending_for_closure_report.csv";
            $fp = fopen('php://output', 'w');
            $count=1;
            //header('Content-type: application/csv; charset=UTF-8');
            //header('Content-Disposition: attachment; filename=' . $filename);
            
            header('Content-Encoding: UTF-8');
            header('Content-type: text/csv; charset=UTF-8');
            header('Content-Disposition: attachment; filename=' . $filename);
            echo "\xEF\xBB\xBF"; // UTF-8 BOM
            fputcsv($fp, $header);
            //var_dump($report_data);die();  
            foreach($report_data as $inc){
                
                if($inc->amb_type == '1'){
                    $amb_type= 'JE';
                   }elseif($inc->amb_type == '2'){
                        $amb_type= 'BLS';
                       }
                       else if($inc->amb_type == '3'){
                        $amb_type= 'ALS';
                       }
                
            $data = array (
            'sr.no'=>$count,
            'inc_ref_id'=>$inc->inc_ref_id,
            'inc_datetime'=>$inc->inc_datetime,
            'amb_rto_register_no'=>$inc->amb_rto_register_no,
            'amb_default_mobile'=>$inc->amb_default_mobile,
            'zone'=>$inc->zone_name,
            'dst_name'=>$inc->dst_name,
            'hp_name'=>$inc->hp_name,
            'amb_type' =>$amb_type,
            );
            
            fputcsv($fp, $data);
            $count++;
            $inc_complaint='';
            }
            fclose($fp);
            exit;
                 
        }
        //var_dump($post_reports);die;
        if($post_reports['flt'] == 'reset'){
            $data=array();
            $data['submit_function'] = "load_erc_report_form";
            
            $this->output->add_to_position($this->load->view('frontend/erc_reports/view_pending_closure_report', $data, TRUE), $output_position, TRUE);
           
           // $this->output->add_to_position('', 'Sub_date_report_block_fields', TRUE);
            $this->output->add_to_position('', $output_position, TRUE);
        }
    }

    function mdt_login_report_view(){
        $post_reports = $this->input->post();
        $clg = $this->session->userdata('current_user');
      // var_dump($post_reports);die;
        $zone=$this->input->post('mdt_login');
        // $base_today = date('Y-m-d', strtotime($post_reports['to_date']));
        // $base_month = $this->common_model->get_base_month($base_today);

        // $base_month = $base_month[0]->months;
        
        // $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
        //         'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
        //     );
        if($this->clg->clg_group ==  'UG-DM' || $this->clg->clg_group ==  'UG-ZM'){
            // print_r($clg);die;

                $dis =  $clg->clg_district_id;
                $dis = json_decode($dis);
                
                $report_args = array('login_type' => $post_reports['login_type'],
                'district'=> $dis
            );
        }
        else{
        $report_args = array('login_type' => $post_reports['login_type'],
                            'zone'=>$zone  );
        }
        $report_data = $this->inc_model->get_mdt_login_report($report_args);
      
           $header = array('Sr No.','Ambulance No','CUG No','Base Location','Ambulance Type','District','Zone','Login Time', 'Login Type','Status'); 

        if ($post_reports['reports'] == 'view') {       
            $data['header'] = $header;
            $data['inc_data'] = $report_data;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/mdt_login_download_view', $data, TRUE), 'list_table', TRUE);
            
        }else{
            
            $filename = "mdt_login_report.csv";
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
            foreach($report_data as $log){

                if($log->login_type == 'P'){
                    $login_type= 'EMT';
                   }elseif($log->login_type == 'D'){
                        $login_type= 'PILOT';
                       }
                       else {
                        $login_type= '';
                       }
                       if($log->status == '1'){
                        $status= 'Login';
                       }
            $data = array (
            'sr.no'=>$count,
            'vehicle_no'=>$log->vehicle_no,
            'amb_default_mobile'=>$log->amb_default_mobile,
            'hp_name'=>$log->hp_name,
            'ambt_name'=>$log->ambt_name,
            'dst_name'=>$log->dst_name,
            'div_name'=>$log->div_name,
            'login_time'=>$log->login_time,
            'login_type'=>$login_type,
            'status'=>$status,
            );
            
            fputcsv($fp, $data);
            $count++;
            }
            fclose($fp);
            exit;
                 
        }     
    }


    function view_pending_validation_report(){
        $post_reports = $this->input->post();
        $clg = $this->session->userdata('current_user');
      // var_dump($post_reports);die;
        $base_today = date('Y-m-d H:i:00', strtotime($post_reports['to_date']));
        $base_month = $this->common_model->get_base_month($base_today);

        $base_month = $base_month[0]->months; 

        if($this->clg->clg_group ==  'UG-DM' || $this->clg->clg_group ==  'UG-ZM'){
            // print_r($clg);die;
            // $report_args = $post_reports['div_name'];
                $dis =  $clg->clg_district_id;
                $dis = json_decode($dis);

                $report_args = array('from_date' => date('Y-m-d H:i:00', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d H:i:00', strtotime($post_reports['to_date'])),
                'district'=> $dis
            );
        }       
        
       else{ 
            $report_args = array('from_date' => date('Y-m-d H:i:00', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d H:i:00', strtotime($post_reports['to_date'])),
            );
           
        }
        $report_data = $this->inc_model->get_pending_validation_report($report_args);
      
           $header = array('Sr No.','Incident ID','Incident Date & Time','Closing Date','Closing Time', 'Ambulance Registration Number','Ambulance CUG No','Ambulance Type','Base Location','Zone Name','District Name','Closed By','Closed By Name','Assigned By','Assigned By Name','Validation Status'); 

        if ($post_reports['reports'] == 'view') {       
            $data['header'] = $header;
            $data['inc_data'] = $report_data;
            $data['report_args'] = $report_args;
            $this->output->add_to_position($this->load->view('frontend/erc_reports/pending_closure_download_view', $data, TRUE), 'list_table', TRUE);
            
        }else{
            
            $filename = "pending_for_validation_report.csv";
            $fp = fopen('php://output', 'w');
            $count=1;
            //header('Content-type: application/csv; charset=UTF-8');
            //header('Content-Disposition: attachment; filename=' . $filename);
            
            header('Content-Encoding: UTF-8');
            header('Content-type: text/csv; charset=UTF-8');
            header('Content-Disposition: attachment; filename=' . $filename);
            echo "\xEF\xBB\xBF"; // UTF-8 BOM
            fputcsv($fp, $header);
            //var_dump($report_data);die();  
            foreach($report_data as $inc){
                
                if($inc->amb_type == '1'){
                    $amb_type= 'JE';
                   }elseif($inc->amb_type == '2'){
                        $amb_type= 'BLS';
                       }
                       else if($inc->amb_type == '3'){
                        $amb_type= 'ALS';
                       }
                if($inc->is_validate == '0'){
                    $is_validate = 'Pending';
                }
                else{
                    $is_validate = 'Validated';
                } 

                if($inc->operate_by != ''){
                    $operate_by = explode(',',$inc->operate_by);
                    $operate_name_array = array();
                    if(is_array($operate_by)){
                        
                        foreach($operate_by as $operate){
                            
                        $operatebyname = get_clg_data_by_ref_id($operate); 
                        $operate_name_array[] = ucwords($operatebyname[0]->clg_first_name.' '.$operatebyname[0]->clg_mid_name.' '.$operatebyname[0]->clg_last_name);
                        }
                        $operateby_name = implode(',',$operate_name_array);
                        
                    }else{
                        $operatebyname = get_clg_data_by_ref_id($inc->operate_by); 
                        $operateby_name = ucwords($operatebyname[0]->clg_first_name.' '.$operatebyname[0]->clg_mid_name.' '.$operatebyname[0]->clg_last_name);
                    }
                }else{
                    
                    $operateby_name="";
                }
                
            $data = array (
            'sr.no'=>$count,
            'inc_ref_id'=>$inc->inc_ref_id,
            'inc_datetime'=>$inc->inc_datetime,
            'epcr_date'=> $inc->epcr_date,
            'epcr_time'=> $inc->epcr_time,
            'amb_rto_register_no'=>$inc->amb_rto_register_no,
            'amb_default_mobile'=>$inc->amb_default_mobile,
            'amb_type' =>$amb_type,
            'hp_name'=>$inc->hp_name,
            'div_name'=>$inc->div_name,
            'dst_name'=>$inc->dst_name,
            'operate_by' =>strtoupper($inc->operate_by),
            'operateby_full_name' =>$operateby_name,
            'inc_added_by'=>strtoupper($inc->inc_added_by),
            'assignby_full_name'=>ucwords($inc->assignby_full_name),
            'is_validate'=>$is_validate
            
            );
            
            fputcsv($fp, $data);
            $count++;
            }
            fclose($fp);
            exit;
                 
        }
        //var_dump($post_reports);die;
        if($post_reports['flt'] == 'reset'){
            $data=array();
            $data['submit_function'] = "load_erc_report_form";
            
            $this->output->add_to_position($this->load->view('frontend/erc_reports/view_pending_validation_report', $data, TRUE), $output_position, TRUE);
           
           // $this->output->add_to_position('', 'Sub_date_report_block_fields', TRUE);
            $this->output->add_to_position('', $output_position, TRUE);
        }
    }

    function inspection_audit_report(){
        $post_reports = $this->input->post();
        $data['clg_group'] = $this->clg->clg_group;
        
        $report_args = array('from_date' => date('Y-m-d H:i:00', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
        );
            // print_r($report_args);die;
        $report_data = $this->inc_model->get_inspection_details($report_args);
        $header = array('Sr.No.','Ambulance Number','Ambulance Type','Ambulance Location Name','Auditor Name','DM Name','EMT Status','Pilot Status','Audit Date','District Name','Current ODO','CUG Number','MDT Number','MDT ID','Chassis No','GPS device','Overall Observation related Primary Issue','Forward To Grievance','Grievance Complete Status','Ambulance Status','Added From','Maintainance of Vehicle','Maintainance of Vehicle Present Status','Maintainance of Vehicle Remark','Cleanliness of Ambulance Present Status','Cleanliness of Ambulance Remark','Ambulance part - AC Status','Ambulance part - AC Remark','Ambulance part - Siren Status','Ambulance part - Siren Remark','Ambulance part - Inverter Status','Ambulance part - Inverter Remark','Ambulance part - Battery Status','Ambulance part - Battery Remark','Ambulance part - Tyre Status','Ambulance part - Tyre Remark','Ambulance part - GPS Status','Ambulance part - GPS Remark','PCR Register Present Status','PCR Register Present Remark','Attendance Sheet Maintained or not','Attendance Sheet Present Status','Attendance Sheet Remark');
        //$header = array('Sr.No.','Timestamp','Username','Ambulance Number','Ambulance Location Name','Auditor Name','Type of Audit','DM Name','EMT Status','Pilot Status','EMT Name','EMT ID','Pilot Name','Pilot ID','Audit Date','District Name','Current ODO','CUG Number','MDT Number','MDT ID','Chassis No','Engine No.','Inverter With Charging Cable','Battery Sr No Vehicle.','Battery Sr No. Inverter.','Registration certificate','Insurance certificate','Pollution certificate','Last Service Date','Last Service ODO','Current KMPL','EMT uniform','Pilot  uniform','License of the pilot','ID card of the EMT','ID card of the Pilot','Mobile phone &Charger','M D T device','Overall Observation related Primary Issue');
   
        $equipment = $this->inspection_model->get_equipment_list(); 
        foreach ($equipment as $key => $equipment_list){
            //var_dump($equipment_list->eqp_name);
            array_push($header,$equipment_list->eqp_name);
        }
        $medicine= $this->inspection_model->get_ins_medicine_list();
        foreach($medicine as $key=> $medicine_list){
            array_push($header,$medicine_list->med_title);
        }

       
       
        $filename = "Inspection_Audit_Report.csv";
        $fp = fopen('php://output', 'w');
        $count=1;

           header('Content-Encoding: UTF-8');
           header('Content-type: text/csv; charset=UTF-8');
           header('Content-Disposition: attachment; filename=' . $filename);
           echo "\xEF\xBB\xBF"; // UTF-8 BOM
           fputcsv($fp, $header);
        //    var_dump($report_data);die();  
           foreach($report_data as $inc){
               
               $dm_args = array('clg_group'=>'UG-DM','district_id_clg'=>$inc->ins_dist);
               $dm = $this->colleagues_model->get_all_colleagues($dm_args);
               $ins_amb_type = '';
              $ins_amb_type = show_amb_type_name($inc->ins_amb_type);  


            if($inc->Forward_to_Grievance == 2){
                $inc->Forward_to_Grievance = "Yes";
            }else{
                $inc->Forward_to_Grievance = "No";
            }

            if($inc->Grievance_Status == 1){
                $inc->Grievance_Status = "Yes";
            }else{
                $inc->Grievance_Status = "No";
            }

            if($inc->Ambulance_Status == "amb_onroad"){
                $inc->Ambulance_Status = "Ambulance OnRoad";
            }else{
                $inc->Ambulance_Status = "Ambulance OffRoad";
            }

           $data = array (
                'sr.no'=>$count,
               // 'added_date'=>$inc->added_date,
                //'Username'=>'-',
                'Ambulance_Number'=>$inc->ins_amb_no,
                'Ambulance_type'=>$ins_amb_type,
                'Ambulance_Location_Name'=>$inc->ins_baselocation,
                // 'Auditor_Name'=>$inc->first_name.' '.$inc->last_name,
                'Auditor_Name' =>$inc->added_by,
                //'Type_of_Audit'=>'-',
                'DM Name'=>$dm[0]->clg_first_name.' '.$dm[0]->clg_last_name,
                'EMT_status'=>$inc->ins_emso,
                'PILOT_status'=>$inc->ins_pilot,
                //'EMT_Name'=>'-',
                //'EMT_ID'=>'-',
                //'Pilot Name'=>'-',
                //'Pilot ID'=>'-',
                'Audit Date'=>$inc->added_date,
                'District_Name'=>$inc->District_Name,
                'Current_ODO'=>$inc->ins_odometer,
                'CUG_Number' => $inc->CUG_Number,
                'MDT_Number' => $inc->MDT_Number,
                'MDT_ID' => $inc->MDT_ID,
                'Chassis_No' => $inc->Chassis_No,
                //'Engine_No' => '-',
                //'Inverter_With_Charging_Cable' => '-',
                //'Battery_Sr_No_Vehicle. ' => '-',
                //'Registration_certificate . ' => '-',
                //'Insurance_certificate' => '-',
                //'Pollution_certificate . ' => '-',
                //'Last_Service_Date ' => '-',
                //'Last_Service_ODO' => '-',
                //'Current_KMPL. ' => '-',
                //'EMT_uniform' => '-',
                //'Pilot_uniform' => '-',
                //'ID_card_of_the_EMT ' => '-',
                //'ID_card_of_the_Pilot' => '-',
                //'Mobile_phone_Charger ' => '-',
                'GPS_Device' => $inc->GPS_Device,
                //'MDT device' => '-',
                'OverallObservationrelated_Primary_Issue' => $inc->Overall_Observation_related_Primary_Issue,
                'Forward_to_Grievance' => $inc->Forward_to_Grievance,
                'Grievance_Status' => $inc->Grievance_Status,
                'Ambulance_Status' => $inc->Ambulance_Status,
                'added_from' => $inc->added_from,
                'Maintainance_of_Vehicle' => $inc->Maintainance_of_Vehicle,
                'Vehicle_Present_Status' => $inc->Vehicle_Present_Status,
                'Maintainance_of_Vehicle_Remark' => $inc->Maintainance_of_Vehicle_Remark,
                'Cleanliness_of_Ambulance_Present_Status' => $inc->Cleanliness_of_Ambulance_Present_Status,
                'Cleanliness_of_Ambulance_Remark' => $inc->Cleanliness_of_Ambulance_Remark,
                'Ambulance_AC_Status' => $inc->Ambulance_AC_Status,
                'Ambulance_AC_Remark' => $inc->Ambulance_AC_Remark,
                'Ambulance_Siren_Status' => $inc->Ambulance_Siren_Status,
                'Ambulance_Siren_Remark' => $inc->Ambulance_Siren_Remark,
                'Ambulance_Inverter_Status' => $inc->Ambulance_Inverter_Status,
                'Ambulance_Inverter_Remark' => $inc->Ambulance_Inverter_Remark,
                'Ambulance_Battery_Status' => $inc->Ambulance_Battery_Status,
                'Ambulance_Battery_Remark' => $inc->Ambulance_Battery_Remark,
                'Ambulance_Tyre_Status' => $inc->Ambulance_Tyre_Status,
                'Ambulance_Tyre_Remark' => $inc->Ambulance_Tyre_Remark,
                'GPS_Status' => $inc->GPS_Status,
                'GPS_Remark' => $inc->GPS_Remark,
                'PCR_Register_Present_Status' => $inc->PCR_Register_Present_Status,
                'PCR_Register_Present_Remark' => $inc->PCR_Register_Present_Remark,
                'Attendance_Sheet_Maintained' => $inc->Attendance_Sheet_Maintained,
                'Attendance_Sheet_Present_Status' => $inc->Attendance_Sheet_Present_Status,
                'Attendance_Sheet_Remark' => $inc->Attendance_Sheet_Remark,

            );
            // print_r($data);die;
           
         

          // $equipment = $this->inspection_model->get_equipment_list(); 
           
           $equipment_ins = $this->inc_model->get_inspection_equipment(array('ins_id'=>$inc->id));
           $equipment_ins = array_combine(array_column($equipment_ins,'eqp_id'),$equipment_ins);
           
         
           foreach ($equipment as $key => $equipment_list){
              
                if(isset($equipment_ins[$equipment_list->eqp_id])){
                    array_push($data,$equipment_ins[$equipment_list->eqp_id]->status);
                }else{
                    array_push($data,'--');
                }
           }

           
            $medicine_ins = $this->inc_model->get_inspection_medicine(array('ins_id'=>$inc->id)); 
            $medicine_ins = array_combine(array_column($medicine_ins,'med_id'),$medicine_ins);
           
           
            foreach($medicine as $key =>$med){
                
                
                if(isset($medicine_ins[$med->med_id])){
                    array_push($data,$medicine_ins[$med->med_id]->med_status);
                }else{
                    array_push($data,'--');
                }

            }
        
       
           fputcsv($fp, $data);
           $count++;
           }
           fclose($fp);
           exit;
    }
    function gps_odo_report(){
        $post_reports = $this->input->post();
        $data['clg_group'] = $this->clg->clg_group;
        //var_dump($data['clg_group']);die();
        // print_r($post_reports);die;
        if($data['clg_group'] == 'UG-NHM'){
            $report_args = array('from_date' => date('Y-m-d H:i:00', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
            );
            // print_r($report_args);die;
            $report_data = $this->inc_model->get_gps_odometer_report_nhm($report_args);
            
           $header = array('Sr No.','Incident ID','Ambulance Registration Number','Base Location','Zone','District','GPS KM','Total KM','EMT Name','EMT ID','Pilot Name','Pilot ID','Pilot ID Other','Incident Datetime','Validtion Datetime');

           $filename = "MDT_Distance_Travelled_Report.csv";
           $fp = fopen('php://output', 'w');
           $count=1;

           header('Content-Encoding: UTF-8');
           header('Content-type: text/csv; charset=UTF-8');
           header('Content-Disposition: attachment; filename=' . $filename);
           echo "\xEF\xBB\xBF"; // UTF-8 BOM
           fputcsv($fp, $header);
        //    var_dump($report_data);die();  
           foreach($report_data as $inc){
               $start_odometer=$inc->start_odometer;
               $scene_odometer = $inc->scene_odometer;
               $from_scene_odometer = $inc->from_scene_odometer;
               $handover_odometer = $inc->handover_odometer;
               $hospital_odometer = $inc->hospital_odometer;
               $end_odometer = $inc->end_odometer;
               $gps_odometer = $inc->gps_odometer;
               $emt_name = $inc->emt_name;
               $emso_id = $inc->emso_id;
               $pilot_name = $inc->pilot_name;
               $pilot_id = $inc->pilot_id;
               $pilot_id_other = $inc->pilot_id_other;

               if( $start_odometer == '' || $start_odometer == null){ $start_odometer = ' - '; }
              
               if( $scene_odometer == '' || $scene_odometer == null){ $scene_odometer = ' - '; }

               if( $from_scene_odometer == '' || $from_scene_odometer == null){ $from_scene_odometer = ' - '; }
               
               if( $handover_odometer == '' || $handover_odometer == null){ $handover_odometer = ' - '; }

               if( $hospital_odometer == '' || $hospital_odometer == null){ $hospital_odometer = ' - '; }

               if( $end_odometer == '' || $end_odometer == null){ $end_odometer = ' - '; }

               if( $gps_odometer == '' || $gps_odometer == null){ $gps_odometer = ' - '; }

               if( $emt_name == '' || $emt_name == null){ $emt_name = ' - '; }

               if( $emso_id == '' || $emso_id == null){ $emso_id = ' - '; }

               if( $pilot_name == '' || $pilot_name == null){ $pilot_name = ' - '; }

               if( $pilot_id == '' || $pilot_id == null){ $pilot_id = ' - '; }

               if( $pilot_id_other == '' || $pilot_id_other == null){ $pilot_id_other = ' - '; }

               
           $data = array (
           'sr.no'=>$count,
           'inc_ref_id'=>$inc->inc_ref_id,
           'amb_reg_id'=>$inc->amb_reg_id,
           'hp_name'=>$inc->hp_name,
           'zone'=>$inc->div_name,
           'dst_name'=>$inc->dst_name,
           //'start_odometer'=>$start_odometer,
           //'scene_odometer'=>$scene_odometer,
           //'from_scene_odometer'=>$from_scene_odometer,
           //'handover_odometer'=>$handover_odometer,
           //'hospital_odometer'=>$hospital_odometer,
           //'end_odometer'=>$end_odometer,
           'gps_odometer'=>$gps_odometer,
           'total_km'=>$inc->total_km,
           'emt_name'=>ucwords($emt_name),
           'emso_id'=>strtoupper($emso_id),
           'pilot_name'=>ucwords($pilot_name),
           'pilot_id'=>strtoupper($pilot_id),
           'pilot_id_other'=>strtoupper($pilot_id_other),
           'inc_datetime'=>$inc->inc_datetime,
           'validate_date'=>$inc->validate_date

           );
           
           fputcsv($fp, $data);
           $count++;
           }
           fclose($fp);
           exit;
        }else{
            $report_args = array('from_date' => date('Y-m-d H:i:00', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
            );
            // print_r($report_args);die;
            $report_data = $this->inc_model->get_gps_odometer_report($report_args);
            
           $header = array('Sr No.','Incident ID','Ambulance Registration Number','Base Location','Zone','District','Start Odometer','Scene Odometer','From Scene Odometer','Handover Odometer','Hospital Odometer','End Odometer','GPS Odometer','Total KM','EMT Name','EMT ID','Pilot Name','Pilot ID','Pilot ID Other','Incident Datetime','Validtion Datetime');

           $filename = "mdt_odometer_report.csv";
           $fp = fopen('php://output', 'w');
           $count=1;

           header('Content-Encoding: UTF-8');
           header('Content-type: text/csv; charset=UTF-8');
           header('Content-Disposition: attachment; filename=' . $filename);
           echo "\xEF\xBB\xBF"; // UTF-8 BOM
           fputcsv($fp, $header);
        //    var_dump($report_data);die();  
           foreach($report_data as $inc){
               $start_odometer=$inc->start_odometer;
               $scene_odometer = $inc->scene_odometer;
               $from_scene_odometer = $inc->from_scene_odometer;
               $handover_odometer = $inc->handover_odometer;
               $hospital_odometer = $inc->hospital_odometer;
               $end_odometer = $inc->end_odometer;
               $gps_odometer = $inc->gps_odometer;
               $emt_name = $inc->emt_name;
               $emso_id = $inc->emso_id;
               $pilot_name = $inc->pilot_name;
               $pilot_id = $inc->pilot_id;
               $pilot_id_other = $inc->pilot_id_other;

               if( $start_odometer == '' || $start_odometer == null){ $start_odometer = ' - '; }
              
               if( $scene_odometer == '' || $scene_odometer == null){ $scene_odometer = ' - '; }

               if( $from_scene_odometer == '' || $from_scene_odometer == null){ $from_scene_odometer = ' - '; }
               
               if( $handover_odometer == '' || $handover_odometer == null){ $handover_odometer = ' - '; }

               if( $hospital_odometer == '' || $hospital_odometer == null){ $hospital_odometer = ' - '; }

               if( $end_odometer == '' || $end_odometer == null){ $end_odometer = ' - '; }

               if( $gps_odometer == '' || $gps_odometer == null){ $gps_odometer = ' - '; }

               if( $emt_name == '' || $emt_name == null){ $emt_name = ' - '; }

               if( $emso_id == '' || $emso_id == null){ $emso_id = ' - '; }

               if( $pilot_name == '' || $pilot_name == null){ $pilot_name = ' - '; }

               if( $pilot_id == '' || $pilot_id == null){ $pilot_id = ' - '; }

               if( $pilot_id_other == '' || $pilot_id_other == null){ $pilot_id_other = ' - '; }

               
           $data = array (
           'sr.no'=>$count,
           'inc_ref_id'=>$inc->inc_ref_id,
           'amb_reg_id'=>$inc->amb_reg_id,
           'hp_name'=>$inc->hp_name,
           'zone'=>$inc->div_name,
           'dst_name'=>$inc->dst_name,
           'start_odometer'=>$start_odometer,
           'scene_odometer'=>$scene_odometer,
           'from_scene_odometer'=>$from_scene_odometer,
           'handover_odometer'=>$handover_odometer,
           'hospital_odometer'=>$hospital_odometer,
           'end_odometer'=>$end_odometer,
           'gps_odometer'=>$gps_odometer,
           'total_km'=>$inc->total_km,
           'emt_name'=>ucwords($emt_name),
           'emso_id'=>strtoupper($emso_id),
           'pilot_name'=>ucwords($pilot_name),
           'pilot_id'=>strtoupper($pilot_id),
           'pilot_id_other'=>strtoupper($pilot_id_other),
           'inc_datetime'=>$inc->inc_datetime,
           'validate_date'=>$inc->validate_date

           );
           
           fputcsv($fp, $data);
           $count++;
           }
           fclose($fp);
           exit;
        }
        
    }
    function ambulance_dist_travel_filter(){
        $post_reports = $this->input->post();
        $from_date = date('Y-m-d', strtotime($post_reports['from_date']));

        $base_month = $this->common_model->get_base_month($from_date);
        $this->post['base_month'] = $base_month[0]->months;

        $report_args = array('from_date' => date('Y-m-d', strtotime($post_reports['from_date'])),
                'to_date' => date('Y-m-d', strtotime($post_reports['to_date'])),
                'base_month' => $this->post['base_month']
            );
                $system=$this->input->post('system');
        
        $amb_odometer = array();
        $count=1;

        $tdd_amb = $this->reports_model->get_tdd_amb(array('system'=>$system));
    //    print_r($tdd_amb);die;
        foreach ($tdd_amb as $tdd) {
            
            $amb_odometer[$tdd->amb_rto_register_no]['count'] = $count++;
            $amb_odometer[$tdd->amb_rto_register_no]['amb_rto_register_no'] = $tdd->amb_rto_register_no;
            $amb_odometer[$tdd->amb_rto_register_no]['amb_category'] = $tdd->amb_category;
            $amb_odometer[$tdd->amb_rto_register_no]['vendor_name'] = $tdd->vendor_name;
            $amb_odometer[$tdd->amb_rto_register_no]['ambt_name'] = $tdd->ambt_name;
            $amb_odometer[$tdd->amb_rto_register_no]['ar_name'] = $tdd->ar_name;
            $amb_odometer[$tdd->amb_rto_register_no]['chases_no'] = $tdd->chases_no;
            $amb_odometer[$tdd->amb_rto_register_no]['total_km'] = 0;
            $amb_odometer[$tdd->amb_rto_register_no]['rate'] = 13.5;
            $amb_odometer[$tdd->amb_rto_register_no]['total_amount'] = ($amb_odometer[$tdd->amb_rto_register_no]['total_km'] * $amb_odometer[$tdd->amb_rto_register_no]['rate']) ;
            $amb_odometer[$tdd->amb_rto_register_no]['avg_km'][] = 0;

            $report_args['amb_reg_no'] = $tdd->amb_rto_register_no;
 
            $min_odometer = $this->inc_model->get_ambulance_min_odometer($report_args);
            

            $amb_odometer[$tdd->amb_rto_register_no]['min_odometer'] = $min_odometer[0]['start_odmeter'] ? $min_odometer[0]['start_odmeter'] : 0;
            

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
            $header = array('Sr.No','Ambulance Category', 'Chases No','Vendor Name' ,'Ambulance Type', 'Area','Ambulance No','Total KM','Rate','Total Amount');
        

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
            // print_r($inc_data);die; 
            $data['header'] = $header;
                   
            $data['inc_data'] = $inc_data;
            $data['report_args'] = $report_args;

            $this->output->add_to_position($this->load->view('frontend/erc_reports/ambulance_distance_travel_view', $data, TRUE), 'list_table', TRUE);
    }
    else {

        $filename = "ambulance_distance_travelled_report.csv";
        $fp = fopen('php://output', 'w');


        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        fputcsv($fp, $header);
        $count=1;
        $data = array();
        foreach ($amb_odometer as $row) {
            $row1['count'] = $count++;
            $row1['amb_category'] = 'Category '.$row['amb_category'];
            $row1['chases_no'] = $row['chases_no'];
            $row1['vendor_name'] = $row['vendor_name'];
            $row1['ambt_name'] = $row['ambt_name'];
            $row1['ar_name'] = $row['ar_name'];
            $row1['amb_rto_register_no'] = $row['amb_rto_register_no'];
            $row1['total_km'] = $row['max_odometer'] - $row1['min_odometer'];
            $row1['rate'] = $row['rate'];
            $row1['total_amount'] = $row['total_amount'];
           
            fputcsv($fp, $row1);
        }

        fclose($fp);
        exit;
    }
}
}