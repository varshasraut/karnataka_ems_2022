<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_updated extends EMS_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){
        parent::__construct();
        $this->active_module = "M-REPORTS";
        $this->active_module = "M-DASH";
        $this->active_module = "M-DASH-REPORT";

        $this->pg_limit = $this->config->item('pagination_limit_clg');

        $this->pg_limits = $this->config->item('report_clg');

        $this->load->helper(array('dash_helper','comman_helper','url','html','form', 'cookie', 'string', 'date'));
        $this->load->model(array('Dashboard_model_final_updated','Dashboard_model_final','amb_model','inc_model','Common_model','rtd_model','Dashboard_model','colleagues_model','call_model'));
        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules', 'simple_excel/Simple_excel'));
        $this->clg = $this->session->userdata('current_user');
        $this->post['base_month'] = get_base_month();
        $this->site_name = $this->config->item('site_name');
        $this->site = $this->config->item('site');
    }
	public function index()
	{	
        $user_group=$this->clg->clg_group;  
        if ($user_group == 'UG-Dashboard') {
            $this->load->view('templates/header');
            $this->load->view('dashboard/dashboard', ['data'=>$data]);
            $this->load->view('templates/footer');
            $this->output->template = ('blank');
        }else{
             dashboard_redirect($user_group,$this->base_url );
        }
    }
    function nhm_dashabord_cron()
    {
        //Count Till Date
        $from_date_live = '2022-08-01 00:00:00';
        $current_date = date('Y-m-d');
        $previous_day = date('Y-m-d', strtotime('-1 day', strtotime($current_date))).' 23:59:59';
       
        $arg_till_date = array('To_date'=>$previous_day,'from_date'=>$from_date_live,'system_type' => array('108','102'));
        $data_update['count_till_date'] = $this->Dashboard_model_final_updated->get_total_call_count($arg_till_date);
        //Count This Month 
        $from_date = date('Y-m-01').' 00:00:00';
        $arg_month_date = array('To_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('108','102'));
        $data_update['count_till_month'] = $this->Dashboard_model_final_updated->get_total_call_count($arg_month_date);
        
        //Closure Till date
        $closure_report = array('to_date' => $previous_day,'from_date' => $from_date_live,'system_type' => array('108','102'));
        $data_update['closure_till_date'] = $this->Dashboard_model_final_updated->Total_closure_data($closure_report,array('21','41','42','43','44'));
        $data_update['closure_till_date'] = $data_update['closure_till_date'];
        //Closure this month
        $closure_report = array('to_date' => $previous_day,'from_date' => $from_date,'system_type' => array('108','102'));
        $data_update['closure_till_month'] = $this->Dashboard_model_final_updated->Total_closure_data($closure_report,array('21','41','42','43','44'));
        
        //Agents data
        //Agent Count This Date 
        //$arg_till_date = array('To_date'=>$previous_day,'from_date'=>$from_date_live,'system_type' => '108,102');
        //$data_update['agent_count_till_date'] = $this->Dashboard_model_final_updated->get_total_agent_count($arg_till_date);
        //Agent Count This Month 
        //$arg_month_date = array('To_date'=>$previous_day,'from_date'=>$from_date,'system_type' => '108,102');
        //$data_update['agent_count_till_month'] = $this->Dashboard_model_final_updated->get_total_agent_count($arg_month_date);
        
        // echo "eme_count_till_date<br>";
        $arg_till_date = array('date_type'=>'td','to_date'=>$previous_day,'from_date_live'=>$from_date_live,'type'=>'eme','system_type' => array('108','102'));
        $data_update['eme_count_till_date']  = $this->Dashboard_model_final_updated->get_total_call_type($arg_till_date);
        $data_update['dispatch_till_date']  =   $data_update['eme_count_till_date'];
        //echo "eme_count_till_month<br>";
        $arg_till_month = array('date_type'=>'tm','to_date'=>$previous_day,'from_date'=>$from_date,'type'=>'eme','system_type' => array('108','102'));
        $data_update['eme_count_till_month'] = $this->Dashboard_model_final_updated->get_total_call_type($arg_till_month);
        
        //echo "noneme_count_till_date<br>";
        $arg_till_date = array('date_type'=>'td','to_date'=>$previous_day,'from_date_live'=>$from_date_live,'type'=>'non-eme','system_type' => array('108','102'));
        $data_update['noneme_count_till_date ']  = $this->Dashboard_model_final_updated->get_total_call_type($arg_till_date);
        //echo "noneme_count_till_month<br>";
        $arg_till_month = array('date_type'=>'tm','to_date'=>$previous_day,'from_date'=>$from_date,'type'=>'non-eme','system_type' => array('108','102'));
        $data_update['noneme_count_till_month'] = $this->Dashboard_model_final_updated->get_total_call_type($arg_till_month);
        
        //Last Month
            $month_ini = new DateTime("first day of last month");
            $month_end = new DateTime("last day of last month");
            $last_month_fdate = $month_ini->format('Y-m-d 00:00:00'); 
            $last_month_edate = $month_end->format('Y-m-d 23:59:59'); 
            //echo "eme_count_last_eme_month<br>";    
            $arg_last_month = array('date_type'=>'lm','to_date'=>$last_month_edate,'from_date'=>$last_month_fdate,'type'=>'eme','system_type' => array('108','102'));
            $data_update['eme_count_lm'] = $this->Dashboard_model_final_updated->get_total_call_type($arg_last_month);
            //echo "closed count mdt last month<br>";
            $arg_closed_mdt_last_month = array('date_type'=>'lm','to_date'=>$last_month_edate,'from_date'=>$last_month_fdate,'system_type' => array('108','102'));
            $data_update['closed_mdt_count_lm'] = $this->Dashboard_model_final_updated->get_mdt_closed_count($arg_closed_mdt_last_month);
            //echo "closed count closed by DCO last month<br>";
            $arg_closed_mdt_last_month = array('date_type'=>'lm','to_date'=>$last_month_edate,'from_date'=>$last_month_fdate,'system_type' => array('108','102'));
            $data_update['closed_dco_count_lm'] = $this->Dashboard_model_final_updated->get_dco_closed_count($arg_closed_mdt_last_month);
            //echo "closed validated by DCO last month<br>";
            $arg_closed_mdt_last_month = array('date_type'=>'lm','to_date'=>$last_month_edate,'from_date'=>$last_month_fdate,'system_type' => array('108','102'));
            $data_update['closed_validated_count_lm'] = $this->Dashboard_model_final_updated->get_dcovalidated_closed_count($arg_closed_mdt_last_month);
            //echo "ERCP Advice Taken last month<br>";
            $arg_closed_mdt_last_month = array('date_type'=>'lm','to_date'=>$last_month_edate,'from_date'=>$last_month_fdate,'system_type' => array('108','102'));
            $data_update['ercp_advice_taken_lm'] = $this->Dashboard_model_final_updated->get_ercp_advice_taken_count($arg_closed_mdt_last_month);
            //echo "feedback Taken last month<br>";
             $arg_closed_mdt_last_month = array('date_type'=>'lm','to_date'=>$last_month_edate,'from_date'=>$last_month_fdate,'system_type' => array('108','102'));
             $data_update['ercp_feedback_lm'] = $this->Dashboard_model_final_updated->get_feedback_count($arg_closed_mdt_last_month);
            //echo "grievance last month<br>";
            $arg_closed_mdt_last_month = array('date_type'=>'lm','to_date'=>$last_month_edate,'from_date'=>$last_month_fdate,'system_type' => array('108','102'));
            $data_update['ercp_grievance_lm'] = $this->Dashboard_model_final_updated->get_grievance_count($arg_closed_mdt_last_month);
            //echo "104complaint_last_month<br>";    
            $arg_last_month = array('date_type'=>'lm','to_date'=>$last_month_edate,'from_date'=>$last_month_fdate,'system_type' => array('104'));
            $data_update['104_comp_lm'] = $this->Dashboard_model_final_updated->get_total_104Comp_call_type($arg_last_month);
             //echo "104All_Calls_last_month<br>";    
             $arg_last_month = array('date_type'=>'lm','to_date'=>$last_month_edate,'from_date'=>$last_month_fdate,'system_type' => array('104'));
            $data_update['104All_count_lm'] = $this->Dashboard_model_final_updated->get_total_104ALLcall_type($arg_last_month);
             
        //This month 
        $previous_day = date('Y-m-d', strtotime('-1 day', strtotime($current_date))).' 23:59:59';
        $from_date = date('Y-m-01').' 00:00:00';
            //echo "closed count mdt this month<br>";
            $arg_closed_mdt_last_month = array('date_type'=>'tm','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('108','102'));
            $data_update['closed_mdt_count_tm'] = $this->Dashboard_model_final_updated->get_mdt_closed_count($arg_closed_mdt_last_month);
            //echo "closed count closed by DCO this month<br>";
            $arg_closed_mdt_last_month = array('date_type'=>'tm','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('108','102'));
            $data_update['closed_dco_count_tm'] = $this->Dashboard_model_final_updated->get_dco_closed_count($arg_closed_mdt_last_month);
            //echo "closed validated by DCO this month<br>";
            $arg_closed_mdt_last_month = array('date_type'=>'tm','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('108','102'));
            $data_update['closed_validated_count_tm'] = $this->Dashboard_model_final_updated->get_dcovalidated_closed_count($arg_closed_mdt_last_month);
            //echo "ERCP Advice Taken lthis month<br>";
            $arg_closed_mdt_last_month = array('date_type'=>'tm','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('108','102'));
            $data_update['ercp_advice_taken_tm'] = $this->Dashboard_model_final_updated->get_ercp_advice_taken_count($arg_closed_mdt_last_month);
            //echo "feedback Taken this month<br>";
             $arg_closed_mdt_last_month = array('date_type'=>'tm','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('108','102'));
             $data_update['ercp_feedback_tm'] = $this->Dashboard_model_final_updated->get_feedback_count($arg_closed_mdt_last_month);
            //echo "grievance this month<br>";
            $arg_closed_mdt_last_month = array('date_type'=>'tm','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('108','102'));
            $data_update['ercp_grievance_tm'] = $this->Dashboard_model_final_updated->get_grievance_count($arg_closed_mdt_last_month);
             //echo "104complaint_this_month<br>";    
            $arg_last_month = array('date_type'=>'tm','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('104'));
            $data_update['104_comp_tm'] = $this->Dashboard_model_final_updated->get_total_104Comp_call_type($arg_last_month);
             //echo "104All_Calls_this_month<br>";    
             $arg_last_month = array('date_type'=>'tm','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('104'));
            $data_update['104All_count_tm'] = $this->Dashboard_model_final_updated->get_total_104ALLcall_type($arg_last_month);
             
        //Till date 
        $previous_day = date('Y-m-d', strtotime('-1 day', strtotime($current_date))).' 23:59:59';
        $from_date = $from_date_live;
        
            //echo "closed count mdt last month<br>";
            $arg_closed_mdt_last_month = array('date_type'=>'td','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('108','102'));
            $data_update['closed_mdt_count_td'] = $this->Dashboard_model_final_updated->get_mdt_closed_count($arg_closed_mdt_last_month);
            //echo "closed count closed by DCO last month<br>";
           $arg_closed_mdt_last_month = array('date_type'=>'td','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('108','102'));
            $data_update['closed_dco_count_td'] = $this->Dashboard_model_final_updated->get_dco_closed_count($arg_closed_mdt_last_month);
            //echo "closed validated by DCO last month<br>";
            $arg_closed_mdt_last_month = array('date_type'=>'td','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('108','102'));
            $data_update['closed_validated_count_td'] = $this->Dashboard_model_final_updated->get_dcovalidated_closed_count($arg_closed_mdt_last_month);
            //echo "ERCP Advice Taken last month<br>";
            $arg_closed_mdt_last_month = array('date_type'=>'td','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('108','102'));
            $data_update['ercp_advice_taken_td'] = $this->Dashboard_model_final_updated->get_ercp_advice_taken_count($arg_closed_mdt_last_month);
            //echo "feedback Taken last month<br>";
             $arg_closed_mdt_last_month = array('date_type'=>'td','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('108','102'));
             $data_update['ercp_feedback_td'] = $this->Dashboard_model_final_updated->get_feedback_count($arg_closed_mdt_last_month);
            //echo "grievance last month<br>";
            $arg_closed_mdt_last_month = array('date_type'=>'td','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('108','102'));
            $data_update['ercp_grievance_td'] = $this->Dashboard_model_final_updated->get_grievance_count($arg_closed_mdt_last_month);
             //echo "104complaint_last_month<br>";    
            $arg_last_month = array('date_type'=>'td','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('104'));
            $data_update['104_comp_td'] = $this->Dashboard_model_final_updated->get_total_104Comp_call_type($arg_last_month);
             //echo "104All_Calls_last_month<br>";    
             $arg_last_month = array('date_type'=>'td','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('104'));
             $data_update['104All_count_td'] = $this->Dashboard_model_final_updated->get_total_104ALLcall_type($arg_last_month);
        
             $data_update['Added_date']=date('Y-m-d H:i:s');
             //var_dump($data_update);die();
            $total_calls_td = $this->Dashboard_model_final_updated->insert_data($data_update);

    echo 'done';  
    die();
    }
    function nhm_dashboard_view(){
        $data =array();
        $dashboard_count = $this->Dashboard_model_final_updated->get_total_calls_frm_dashboard_tbl();

        $to_date = date('Y-m-d').' 23:59:59';
        $from_date = date('Y-m-d').' 00:00:00';
        $arg_till_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => '108');
        $dt['today_total_count'] = $this->Dashboard_model_final_updated->get_total_call_count($arg_till_date);
        
        $arg_today_eme = array('date_type'=>'tm','to_date'=>$to_date,'from_date'=>$from_date,'type'=>'eme','system_type' => '108','102');
        $dt['today_emergency']  = $this->Dashboard_model_final->get_total_call_type($arg_today_eme);
            
            
        $arg_today_noneme = array('date_type'=>'tm','to_date'=>$to_date,'from_date'=>$from_date,'type'=>'non-eme','system_type' => '108','102');
        $dt['today_non_emergency']  = $this->Dashboard_model_final->get_total_call_type($arg_today_noneme);

        $closure_report_today = array('to_date' => $to_date,'from_date' => $from_date,'system_type' => '108');
        $dt['today_closure'] = $this->Dashboard_model_final_updated->Total_closure_data($closure_report_today,array('21','41','42','43','44'));
       
        $data['total_calls_tm'] = $dashboard_count[0]['count_till_month'];
        $data['total_calls_today'] = $dt['today_total_count'];
         
        //Emergecny Call
        $data['eme_calls_td'] = $dashboard_count[0]['eme_count_till_date']+3602556;
        $data['eme_calls_tm'] = $dashboard_count[0]['eme_count_till_month'];
        $data['eme_calls_to'] = $dt['today_emergency'];

        $data['non_eme_td'] = $dashboard_count[0]['noneme_count_till_date']+18638463;
        $data['non_eme_tm'] = $dashboard_count[0]['noneme_count_till_month'];
        $data['non_eme_to'] = $dt['today_non_emergency'];
            
        $data['total_calls_td'] = $data['eme_calls_td'] + $data['non_eme_td'];

        $data['total_dispatch_all'] =  $data['eme_calls_td'];
        $data['total_dispatch_tm'] =  $data['eme_calls_tm'];

        $data['total_calls_emps_td'] = $dashboard_count[0]['closure_till_date']+6176511;
        $data['total_calls_emps_tm'] = $dashboard_count[0]['closure_till_month'];
            
        $data['total_closure_td'] = $dashboard_count[0]['closure_till_date']+6176511;
        $data['total_closure_tm'] = $dashboard_count[0]['closure_till_month'];
        $data['total_closure_to'] = $dt['today_closure'];

        $args = array('amb_type_not'=>array('1'));
        $data['amb_data'] = $this->amb_model->get_gps_amb_data($args);
        $data['clg_ref_id'] = $this->clg->clg_ref_id;
        $data['dist'] = $this->common_model->get_district(array('st_id' => 'MP'));

        $current_date = date('Y-m-d');
        $data['current_date']=$current_date;
        $select_time = get_current_select_time(date('H'));
        //var_dump($select_time);
        $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),'district_name'=>'total','select_time'=>$select_time  );
        $data['total_amb_data'] = $this->common_model->get_district_wise_offroad_mapcount($report_args);
        if(empty($data['total_amb_data'])){
            $data['current_date']=date('Y-m-d', strtotime('-1 day', strtotime($current_date)));
            $report_args = array('from_date'=>date('Y-m-d', strtotime('-1 day', strtotime($current_date))),'district_name'=>'total','select_time'=>$select_time );
            $data['total_amb_data'] = $this->common_model->get_district_wise_offroad_mapcount($report_args);
        }
        $this->output->add_to_position($this->load->view('frontend/dash/NHM_dashboard_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "calls_nhm";
    }
}
