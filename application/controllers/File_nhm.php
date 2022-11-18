<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;




class File_nhm extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->active_module = "M-REPORTS";

        $this->pg_limit = $this->config->item('pagination_limit_clg');
        

        $this->pg_limits = $this->config->item('report_clg');
        $this->load->model(array('reports_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date'));
        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules', 'simple_excel/Simple_excel'));

        $this->post['base_month'] = get_base_month();
        $this->site_name = $this->config->item('site_name');
        $this->site = $this->config->item('site');

        $this->clg = $this->session->userdata('current_user');
    }

    public function index($generated = false) {

        $this->output->add_to_position($this->load->view('frontend/nhm_file/reports_list_view', $data, TRUE), $this->post['output_position'], TRUE);
    }


    function file_nhm_report(){
        $data['submit_function']='download_report';      
        $this->output->add_to_position($this->load->view('frontend/nhm_file/nhm_file_report_view', $data, TRUE), 'content', TRUE);
        if($this->clg->clg_group == 'UG-Dashboard-view'){
            $this->output->template = "blank"; 
        }else{
            $this->output->template = "nhm_blank"; 
        }
        
    }
        function table_file_nhm_report(){

            $args = array('type'=>'report');
            $data['report_info'] = $this->reports_model->get_nhm_report($args);

           $files = json_decode($files_data,true);
           $data['file_listing'] = $files['dir'][$year]['dir'][$month];
        
           $this->output->add_to_position($this->load->view('frontend/nhm_file/table_nhm_file_listing_view', $data, TRUE), 'content', TRUE);
        
    }
    function download_report(){
           $post_reports = $this->input->post();
           $year =$data['year'] = $post_reports['from_year'];
           $month= $data['month'] = $post_reports['from_date'];
           
           //$files_data = file_get_contents('http://210.212.165.116/NHM_Report/reports.php');
           $files_data = file_get_contents('http://10.108.1.50/NHM_Report/reports.php');
           
           $files = json_decode($files_data,true);
           $data['file_listing'] = $files['dir'][$year]['dir'][$month];
        
           $this->output->add_to_position($this->load->view('frontend/nhm_file/nhm_file_listing_view', $data, TRUE), 'report_listing', TRUE);

    }
    function table_download_report(){
           $post_reports = $this->input->post();
           $year =$data['year'] = $post_reports['from_year'];
           $month= $data['month'] = $post_reports['from_date'];
           $args = array('type'=>'report');
           
           $data['report_info'] = $this->reports_model->get_nhm_report($args);

           $files = json_decode($files_data,true);
           $data['file_listing'] = $files['dir'][$year]['dir'][$month];
        
           $this->output->add_to_position($this->load->view('frontend/nhm_file/table_nhm_file_listing_view', $data, TRUE), 'report_listing', TRUE);

    }

    function load_report_form(){
        set_time_limit(0);
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
       // $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        
        $post_reports = $this->input->post();
        $files = $post_reports['report_type'];
       // $files = './2015/January/Annex A-I_Jan_2015.xlsx';
        $files = explode("./",$files);
        $file = str_replace(' ', '%20', $files[1]);
      
             
        
        $files_data = file_get_contents('http://10.108.1.50/NHM_Report/'.$file);
        //$files_data = file_get_contents('http://210.212.165.116/NHM_Report/'.$file);
        $temp_file = time().'.xlsx';
       // $temp_file ='1626526058.xlsx';
        
         file_put_contents('./temp/'.$temp_file, $files_data);
         
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load(FCPATH.'/temp/'.$temp_file);
       // $d=$spreadsheet->getSheet(0)->toArray();
        $no_of_sheet = $spreadsheet->getSheetCount();
        $result_data=array();
        $sheet_names = $spreadsheet->getSheetNames();
        for($ii=0;$ii<$no_of_sheet;$ii++){         
            $result_data[$ii]=$spreadsheet->getSheet($ii)->toArray(null, true, true, true);
   
        }

       $data['result_data'] = $result_data;
       $data['sheet_names'] = $sheet_names;
        $this->output->add_to_position($this->load->view('frontend/nhm_file/load_result_view', $data, TRUE), 'popup_div', TRUE);
         $this->output->template = "nhm_blank"; 
      
    }
    function load_file_report_form(){
       $post_reports = $this->input->post();
        $data['submit_function']='result_load_file_report_form';
        $data['report_type'] =$post_reports['report_type'];
        $args = array('type'=>'report','report_code'=>$post_reports['report_type']);
           
        $report_info= $this->reports_model->get_nhm_report($args);
        $data['report_name'] =$report_info[0]['report_name'];
          
         
        $this->output->add_to_position($this->load->view('frontend/nhm_file/search_load_result_view', $data, TRUE), 'popup_div', TRUE);
         
    }

    function result_load_file_report_form(){
      
        $post_reports = $this->input->post();
        
        $name = $this->input->post('report_type');
      
        $year  = $data['year'] = $post_reports['from_year'];
        $month = $data['month'] = $post_reports['from_date'];
        $report_type= $data['report_type'] = $post_reports['report_type'];
        
        $month_array = array('January'=>'01','February'=>'02','March'=>'03','April'=>'04','May'=>'05','June'=>'06','July'=>'07','August'=>'08','September'=>'09','October'=>'10','November'=>'11','December'=>'12');
         
        $args['from_date']=$from_date=$data['from_date'] = $year.'-'.$month_array[$month].'-01';
          
        $args['to_date']=$to_date =$data['to_date']= date("Y-m-t", strtotime( $args['from_date']));
       
        $report_name = array('B_II_A'=>'Annexure-B II-A');
        
        $this->pg_limit = 5000;
        
        $page_no = 1;
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }

        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        
        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $args['page_no'] = $page_no;

        $data['get_count'] = TRUE;



        $data['per_page'] = $args['per_page'] = $limit;
        $data['inc_offset'] = $args['inc_offset'] = $offset;
        
     
        if($name == 'B_II_A' ){
            $data['submit_function'] = 'b_ii_a';
            $data['report_name'] = 'Annexure-B II-A';
           // $data['report_info'] = $this->reports_model->get_nhm_b_ii_a($args);
            
             $args['get_count'] = TRUE;
            $data['total_count'] = $total_cnt = $this->reports_model->get_nhm_b_ii_a($args);
            unset($args['get_count']);
            $data['report_info'] = $this->reports_model->get_nhm_b_ii_a($args, $offset, $limit);
            $data['per_page'] = $limit;

            $pgconf = array(
                'url' => base_url("file_nhm/result_load_file_report_form"),
                'total_rows' => $total_cnt,
                'per_page' => $limit,
                'cur_page' => $page_no,
                'uri_segment' => 2,
                'use_page_numbers' => TRUE,
                'attributes' => array('class' => 'click-xhttp-request', 'data-qr' => "output_position=content&amp;pglnk=true&amp;report_type=B_II_A&from_year=$year&from_date=$month")
            );
       

            $config = get_pagination($pgconf);
            $data['pagination'] = get_pagination($pgconf);
            
             $this->output->add_to_position($this->load->view('frontend/nhm_file/table_load_result_view', $data, TRUE), 'report_listing', TRUE);
        }else if($name == 'B-VII'){
            
            $data['submit_function'] = 'B_VII';
            $data['report_name'] = 'Annexure-B VII';
            $data['report_info'] = $this->reports_model->get_nhm_b_vii($args);
            $this->output->add_to_position($this->load->view('frontend/nhm_file/B_VII_result_view', $data, TRUE), 'report_listing', TRUE);
        }else if($name == 'B_VI'){
            
            $data['submit_function'] = 'B_VI';
             $data['report_name'] = 'Annexure B-VI Ambulance staff performance Reports';
            $data['report_info'] = $this->reports_model->get_nhm_b_vi($args);
             $this->output->add_to_position($this->load->view('frontend/nhm_file/B_VI_result_view', $data, TRUE), 'report_listing', TRUE);
        }else if($name == 'B_V'){
            
            $data['submit_function'] = 'B_V';
             $data['report_name'] = 'Annexure B-V Ambulance staff performance Reports';
            $data['report_info'] = $this->reports_model->get_nhm_b_v($args);
           
             $this->output->add_to_position($this->load->view('frontend/nhm_file/B_V_result_view', $data, TRUE), 'report_listing', TRUE);
        }else if($name == 'A_II'){
            
            $data['submit_function'] = 'A_II';
             $data['report_name'] = 'Annexure B-V Ambulance staff performance Reports';
            $data['report_info'] = $this->reports_model->get_nhm_a_ii($args);
             $this->output->add_to_position($this->load->view('frontend/nhm_file/A_II_result_view', $data, TRUE), 'report_listing', TRUE);
        }else if($name == 'A_I'){
            
            $data['submit_function'] = 'A_I';
             $data['report_name'] = ' 	Annex A-I';
            $data['report_info'] = $this->reports_model->get_nhm_a_i($args);
             $this->output->add_to_position($this->load->view('frontend/nhm_file/A_I_result_view', $data, TRUE), 'report_listing', TRUE);
        }else if($name == 'B_I'){
            
            $data['submit_function'] = 'B_I';
            $data['report_name'] = 'Annex B-I';
           // $data['report_info'] = $this->reports_model->get_nhm_b_i($args);
            
            $args['get_count'] = TRUE;
            $data['total_count'] = $total_cnt = $this->reports_model->get_nhm_b_i($args);
            unset($args['get_count']);
            $data['report_info'] = $this->reports_model->get_nhm_b_i($args, $offset, $limit);
            $data['per_page'] = $limit;

            $pgconf = array(
                'url' => base_url("file_nhm/result_load_file_report_form"),
                'total_rows' => $total_cnt,
                'per_page' => $limit,
                'cur_page' => $page_no,
                'uri_segment' => 2,
                'use_page_numbers' => TRUE,
                'attributes' => array('class' => 'click-xhttp-request', 'data-qr' => "output_position=content&amp;pglnk=true&amp;report_type=B_I&from_year=$year&from_date=$month")
            );
       

            $config = get_pagination($pgconf);
            $data['pagination'] = get_pagination($pgconf);
            
             $this->output->add_to_position($this->load->view('frontend/nhm_file/B_I_result_view', $data, TRUE), 'report_listing', TRUE);
        }else if($name == 'B_III'){
                      
            $data['submit_function'] = 'B_III';
            $data['report_name'] = 'Annex B-III';
             
            $args['get_count'] = TRUE;
            $data['total_count'] = $total_cnt = $this->reports_model->get_nhm_b_iii($args);
            unset($args['get_count']);
            $data['report_info'] = $this->reports_model->get_nhm_b_iii($args, $offset, $limit);
            $data['per_page'] = $limit;

            $pgconf = array(
                'url' => base_url("file_nhm/result_load_file_report_form"),
                'total_rows' => $total_cnt,
                'per_page' => $limit,
                'cur_page' => $page_no,
                'uri_segment' => 2,
                'use_page_numbers' => TRUE,
                'attributes' => array('class' => 'click-xhttp-request', 'data-qr' => "output_position=content&amp;pglnk=true&amp;report_type=B_III&from_year=$year&from_date=$month")
            );
       

            $config = get_pagination($pgconf);
            $data['pagination'] = get_pagination($pgconf);

           //$this->output->add_to_position($this->load->view('frontend/nhm_file/B_I_result_view', $data, TRUE), 'report_listing', TRUE);
            $this->output->add_to_position($this->load->view('frontend/nhm_file/B_III_result_view', $data, TRUE), 'report_listing', TRUE);
        }else if($name == 'B_II_B'){
            
            $data['submit_function'] = 'B_II_B';
             $data['report_name'] = ' 	Annex B-II B';
           
            
            $args['get_count'] = TRUE;
            $data['total_count'] = $total_cnt = $this->reports_model->get_nhm_b_ii_b($args);;
            unset($args['get_count']);
            $data['report_info'] = $this->reports_model->get_nhm_b_ii_b($args, $offset, $limit);
            $data['per_page'] = $limit;

            $pgconf = array(
                'url' => base_url("file_nhm/result_load_file_report_form"),
                'total_rows' => $total_cnt,
                'per_page' => $limit,
                'cur_page' => $page_no,
                'uri_segment' => 2,
                'use_page_numbers' => TRUE,
                'attributes' => array('class' => 'click-xhttp-request', 'data-qr' => "output_position=content&amp;pglnk=true&amp;report_type=B_II_B&from_year=$year&from_date=$month")
            );
       

            $config = get_pagination($pgconf);
            $data['pagination'] = get_pagination($pgconf);
           //$this->output->add_to_position($this->load->view('frontend/nhm_file/B_I_result_view', $data, TRUE), 'report_listing', TRUE);
             $this->output->add_to_position($this->load->view('frontend/nhm_file/B_II_B_result_view', $data, TRUE), 'report_listing', TRUE);
        }
       
       
       // $this->output->template = "nhm_blank"; 
      
        
    }   
    function b_ii_a(){
        
        $post_reports = $this->input->post();
        $name = $this->input->post('report_type');
      
        $year  = $data['year'] = $post_reports['year'];
        $month = $data['month'] = $post_reports['month'];
        $report_type= $data['report_type'] = $post_reports['report_type'];
        

        $args['from_date'] = $post_reports['from_date'] ;
        $args['to_date'] = $post_reports['to_date'];
       
        $report_name = array('B_II_A'=>'Annexure-B II-A');
        
        
        if($name == 'B_II_A' ){
            $data['submit_function'] = 'b_ii_a';
            $calls_details = $this->reports_model->get_nhm_b_ii_a($args);
            //var_dump($calls_details);die();
            $filename = "b_ii_a.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            $header = array('Sr.no','Incident Id','Caller No','Caller No','Call picked within 5 Rings','Call Picked After 5 Rings','Unanswered Call(Call was not picked at all)','Whether any Ambulance was Assigned','Whether any Patient was Attended','Whether the call was about Fire Incident');
            fputcsv($fp, $header);
            foreach ($calls_details as $key=>$inc) {
                  
                
                  $data = array (
                      'sr'=>$key+1,
                      'inc_id'=>$inc['inc_id'], 
                  'Caller_no'=>$inc['Caller_no'], 
                  'within_five_rings'=>$inc['within_five_rings'],
                  'After_five_rings'=>$inc['After_five_rings'],
                  'unanswered_call'=>$inc['unanswered_call'],
                  'amb_dispatched'=>$inc['amb_dispatched'],
                  'patient_attended'=>$inc['patient_attended'],
                  'medico_legal'=>$inc['medico_legal'],
                  'fire_inc'=>$inc['fire_inc']);

                  fputcsv($fp,$data);
                
               
            }

          // fputcsv($fp, $report_data);
            $count++;
         

          fclose($fp);
          exit;
        }
        
    }
    function B_VII(){
                $post_reports = $this->input->post();
        $name = $this->input->post('report_type');
      
        $year  = $data['year'] = $post_reports['year'];
        $month = $data['month'] = $post_reports['month'];
        $report_type= $data['report_type'] = $post_reports['report_type'];
        

        $args['from_date'] = $post_reports['from_date'] ;
        $args['to_date'] = $post_reports['to_date'];
       
        $report_name = array('B_VII'=>'Annexure B-VII');
        
        
        if($name == 'B-VII' ){
            $data['submit_function'] = 'B_VII';
            $calls_details = $this->reports_model->get_nhm_b_vii($args);
           
            $filename = "B_VII.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            $header = array('Sr.no','Ambulance  Reg.No.','Location','No.of on-road hrs during month','No.of off-road hrs during month');
            fputcsv($fp, $header);
            foreach ($calls_details as $key=>$inc) {

                $data = array (
                    'sr'=>$key+1,
                    'amb_no'=>$inc['amb_no'], 
                  'location'=>$inc['location'], 
                  'on_road_hrs'=>$inc['on_road_hrs'],
                  'off_road_hrs'=>$inc['off_road_hrs'],
                 // 'remark'=>$inc['remark']
                        );
                  fputcsv($fp,$data);

            }

          // fputcsv($fp, $report_data);
            $count++;
         

          fclose($fp);
          exit;
        }
    }
    function B_V(){
                $post_reports = $this->input->post();
        $name = $this->input->post('report_type');
      

        $report_type= $data['report_type'] = $post_reports['report_type'];
        

        $args['from_date']= $data['year'] = $post_reports['from_date'] ;
        $args['to_date'] = $data['month'] =$post_reports['to_date'];
       
        $report_name = array('B_V'=>'Annexure B-V');
       
        
        
        if($name == 'B_V' ){
            $data['submit_function'] = 'B_V';
            $calls_details = $this->reports_model->get_nhm_b_v($args);
           
            $filename = "B_V.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            $header = array('Sr.no','Name of EMT','Employee ID','No. of Patients attended during the month');
            fputcsv($fp, $header);
            foreach ($calls_details as $key=>$inc) {
                

                $data = array (
                    'sr'=>$key+1,
                    'emso_name'=>$inc['emso_name'], 
                    'emso_id'=>$inc['emso_id'], 
                    'no_patients'=>$inc['no_patients']);
                  fputcsv($fp,$data);

            }

          // fputcsv($fp, $report_data);
            $count++;
         

          fclose($fp);
          exit;
        }
    }
    function B_VI(){
                $post_reports = $this->input->post();
        $name = $this->input->post('report_type');
      

        $report_type= $data['report_type'] = $post_reports['report_type'];
        

        $args['from_date']= $data['year'] = $post_reports['from_date'] ;
        $args['to_date'] = $data['month'] =$post_reports['to_date'];
       
        $report_name = array('B_VI'=>'Annexure B-VI');
       
        
        
        if($name == 'B_VI' ){
            $data['submit_function'] = 'B_VI';
            $calls_details = $this->reports_model->get_nhm_b_vi($args);
           
            $filename = "B_VI.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            $header = array('Sr.no','Name of EA','Employee ID','No. of Patients attended during the month');
            fputcsv($fp, $header);
            foreach ($calls_details as $key=>$inc) {
                

                $data = array (
                    'sr'=>$key+1,
                    'emso_name'=>$inc['pilot_name'], 
                    'emso_id'=>$inc['pilot_id'], 
                    'no_patients'=>$inc['no_patients']);
                  fputcsv($fp,$data);

            }

          // fputcsv($fp, $report_data);
            $count++;
         

          fclose($fp);
          exit;
        }
    }
    function a_ii(){
                $post_reports = $this->input->post();
        $name = $this->input->post('report_type');
      

        $report_type= $data['report_type'] = $post_reports['report_type'];
        

        $args['from_date']= $data['year'] = $post_reports['from_date'] ;
        $args['to_date'] = $data['month'] =$post_reports['to_date'];
       
        $report_name = array('A_II'=>'Annexure A_II');
       
        
        
        if($name == 'A_II' ){
            $data['submit_function'] = 'A_II';
            $calls_details = $this->reports_model->get_nhm_a_ii($args);
           
            $filename = "A_II.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            $header = array('Sr.no','Name of Medicines/Consumables','Expected Stock as per Agreement','Opening Stock-937 Ambulances','Consumed During The Month','Replenishment During the Month','Closing Stock','Deficiency as against Requirement');
                    
          
            fputcsv($fp, $header);
            foreach ($calls_details as $key=>$inc) {
                

                $data = array (
                    'sr'=>$key+1,
                    'indent'=>$inc['indent'], 
                    'min_stock'=>$inc['min_stock'], 
                    'opening_stock'=>$inc['opening_stock'],
                     'Consumed_stock'=>$inc['Consumed_stock'],
                     'Replenishment'=>$inc['Replenishment'],
                     'Closing_stock'=>$inc['Closing_stock'],
                    'Deficiency'=>$inc['Deficiency'],
                    
                    );
                  fputcsv($fp,$data);

            }

          // fputcsv($fp, $report_data);
            $count++;
         

          fclose($fp);
          exit;
        }
    }
    function a_i(){
                $post_reports = $this->input->post();
        $name = $this->input->post('report_type');
      

        $report_type= $data['report_type'] = $post_reports['report_type'];
        

        $args['from_date']= $data['year'] = $post_reports['from_date'] ;
        $args['to_date'] = $data['month'] =$post_reports['to_date'];
       
        $report_name = array('A_I'=>'Annexure A_I');
       
        
        
        if($name == 'A_I' ){
            $data['submit_function'] = 'A_I';
            $calls_details = $this->reports_model->get_nhm_a_i($args);
           
            $filename = "A_I.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            $header = array('Sr.no','Registration Number of the Ambulance','Location','Opening (First day of the Month)','Closing (Last day of the Month)','KM Run During the Month','No of Patients/calls Attended');
                    
          
            fputcsv($fp, $header);
            foreach ($calls_details as $key=>$inc) {
                

                $data = array (
                    'sr'=>$key+1,
                    'amb_rto_register_no'=>$inc['amb_rto_register_no'], 
                    'Base_location'=>$inc['Base_location'], 
                    'Opening_odo'=>$inc['Opening_odo'],
                     'Start_odo'=>$inc['Start_odo'],
                     'Total_Km'=>$inc['Total_Km'],
                     'Total_patient'=>$inc['Total_patient'],
                    //'Remark'=>$inc['Remark'],
                    
                    );
                  fputcsv($fp,$data);

            }

          // fputcsv($fp, $report_data);
            $count++;
         

          fclose($fp);
          exit;
        }
    }
    function b_i(){
                $post_reports = $this->input->post();
        $name = $this->input->post('report_type');
      

        $report_type= $data['report_type'] = $post_reports['report_type'];
        

        $args['from_date']= $data['year'] = $post_reports['from_date'] ;
        $args['to_date'] = $data['month'] =$post_reports['to_date'];
       
        $report_name = array('B_I'=>'Annexure B_I');
       
        
        
        if($name == 'B_I' ){
            $data['submit_function'] = 'B_I';
            $calls_details = $this->reports_model->get_nhm_b_i($args);
           
            $filename = "B_I.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            $header = array('Sr.no','Registration Number of the Ambulance','Location','KM Run During the Month','No of Patients/calls Attended');
                    
          
            fputcsv($fp, $header);
            foreach ($calls_details as $key=>$inc) {
                

                $data = array (
                    'sr'=>$key+1,
                    'amb_rto_register_no'=>$inc['Ambulance_no'], 
                    'Base_location'=>$inc['Base_location'], 
                    'Total_KM'=>$inc['Total_KM'],
                    'Total_patient'=>$inc['Total_patient'],
                   // 'Odo_remark'=>$inc['Odo_remark'],
                   // 'Remark'=>$inc['Remark'],
                    
                    );
                  fputcsv($fp,$data);

            }

          // fputcsv($fp, $report_data);
            $count++;
         

          fclose($fp);
          exit;
        }
    }
    function b_iii(){
                $post_reports = $this->input->post();
        $name = $this->input->post('report_type');
      

        $report_type= $data['report_type'] = $post_reports['report_type'];
        

        $args['from_date']= $data['year'] = $post_reports['from_date'] ;
        $args['to_date'] = $data['month'] =$post_reports['to_date'];
       
        $report_name = array('B_III'=>'Annexure B_III');
       
        
        
        if($name == 'B_III' ){
            $data['submit_function'] = 'B_I';
            $calls_details = $this->reports_model->get_nhm_b_iii($args);
           
            $filename = "B_III.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            $header = array('Sr.no','Caller No.','Call Disconnected Time','Time at which ambulance reached the site','Response Time','Registration number of the ambulance to which call was assigned','Base location of the said ambulance','Location of the incident','Hospital in which the patient was admitted','Code No. of hospital','Urban /Rural');
                    
          
            fputcsv($fp, $header);
            foreach ($calls_details as $key=>$inc) {
                

                $data = array (
                    'sr'=>$key+1,
                    'Caller_no'=>$inc['Caller_no'], 
                    'Call_disconnected'=>$inc['Call_disconnected'], 
                    'At_scene'=>$inc['At_scene'],
                    'Response_time'=>$inc['Response_time'],
                    'Ambulance_no'=>$inc['Ambulance_no'],
                    'Base_location'=>$inc['Base_location'],
                    'inc_address'=>$inc['inc_address'],
                    'Hospital_name'=>$inc['Hospital_name'],
                    'Hospital_code'=>$inc['Hospital_code'],
                    'Area'=>$inc['Area'],
                    
                    );
                  fputcsv($fp,$data);

            }

          // fputcsv($fp, $report_data);
            $count++;
         

          fclose($fp);
          exit;
        }
    }
     function b_ii_b(){
        
        $post_reports = $this->input->post();
        $name = $this->input->post('report_type');
      
        $year  = $data['year'] = $post_reports['year'];
        $month = $data['month'] = $post_reports['month'];
        $report_type= $data['report_type'] = $post_reports['report_type'];
        

        $args['from_date'] = $post_reports['from_date'] ;
        $args['to_date'] = $post_reports['to_date'];
       
        $report_name = array('B_II_B'=>'Annexure-B II-B');
        
        
        if($name == 'B_II_B' ){
            $data['submit_function'] = 'b_ii_a';
            $calls_details = $this->reports_model->get_nhm_b_ii_b($args);
            //var_dump($calls_details);die();
            $filename = "B_II_B.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            $header = array('Sr.no','Event id','Caller Number','Whether the Call Was Disconnected','Whether any Counselling was done','Whether it Was a Prank Call','Whether the call was meant for any city  corporation disaster cell','Whether it was diverted to concerned city corporation disaster cell');
            
            fputcsv($fp, $header);
            foreach ($calls_details as $key=>$inc) {
                  
                
                  $data = array (
                      'sr'=>$key+1,
                      'inc_ref_id'=>$inc['inc_id'], 
                  'caller_number'=>$inc['caller_no'], 
                  'disconnected'=>$inc['disconnected'],
                  'counselling'=>$inc['counselling'],
                  'prank_call'=>$inc['prank_call'],
                  'disaster'=>$inc['disaster'],
                  'transfer'=>$inc['transfer'],
                );

                  fputcsv($fp,$data);
                
               
            }

          // fputcsv($fp, $report_data);
            $count++;
         

          fclose($fp);
          exit;
        }
        
    }
}