<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Erc_dashboards extends EMS_Controller {

	public function __construct(){
        parent::__construct();
        $this->active_module = "M-JAES-DASH";
        $this->active_module = "M-JAES-NHM";

        $this->load->helper(array('dash_helper','comman_helper','url','html','form', 'cookie', 'string', 'date'));
        $this->load->model(array('Dashboard_model_final_updated','Dashboard_model_final','amb_model','inc_model','Common_model','rtd_model','Dashboard_model','colleagues_model','call_model','kpi_dashboard_model'));
        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules', 'simple_excel/Simple_excel'));
        $this->clg = $this->session->userdata('current_user');
        $this->post['base_month'] = get_base_month();
        $this->site_name = $this->config->item('site_name');
        $this->site = $this->config->item('site');

      }
	
      public function index()
	{	
        echo "Welcome";
    }
    public function erc_live_calls_dash_view(){
        
        //var_dump('hi');die();
        $user_group=$this->clg->clg_group;  
        if ($user_group == 'UG-JAES-DASHBOARD') {
            $data =array();
            $data = $this->Dashboard_model_final_updated->get_total_calls_frm_dashboard_tbl();
            $current_date = date('Y-m-d');
            $from_date = date('Y-m-d', strtotime($current_date)).' 00:00:00';
            $to_date = date('Y-m-d', strtotime($current_date)).' 23:59:59';
            $databoard_data['tbl_data']=$data;
            //echo "resourse Total<br>";
            $databoard_data = array();

            //$databoard_data['resourse_available'] = $this->Dashboard_model_final_updated->get_total_resourse_count();

            //echo "resourse Login Today<br>";
            //$arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'));
            //$databoard_data['resourse_count'] = $this->Dashboard_model_final_updated->get_total_login_count($arg_month_date);
           //var_dump('hi');
            //echo "ERO free Login Status<br>";
            $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'),'call_status' => 'free');
            $databoard_data['ero_free'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_ero_login_count($arg_month_date));
            //echo "ERO On Call Login Status<br>";
            //var_dump('hi');
            $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'),'call_status' => 'atnd');
            $databoard_data['ero_atend'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_ero_login_count($arg_month_date));
            //echo "ERO Break Login Status<br>";
            $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'),'call_status' => 'break');
            $databoard_data['ero_break'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_ero_login_count($arg_month_date));
            
            //echo "total_count_today_date<br>";
            $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'));
            $databoard_data['count_today'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_call_count($arg_month_date));
            
            //Closure count Today
            $closure_report = array('to_date' => $to_date,'from_date' => $from_date,'system_type' => array('108','102'));
            $databoard_data['closure_today'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->Total_closure_data($closure_report,array('21','41','42','43','44')));
            
            // echo "eme_count_today_date<br>";
            $arg_till_date = array('date_type'=>'to','type'=>'eme','system_type' => array('108','102'));
            $databoard_data['eme_count_today_date']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_call_type($arg_till_date));
            
            //echo "noneme_count_today_date<br>";
            $arg_till_date = array('date_type'=>'to','type'=>'non-eme','system_type' => array('108','102'));
            $databoard_data['noneme_count_today_date']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_call_type($arg_till_date));
        
            //ERCP Advice Taken today
            $arg_closed_mdt_last_month = array('date_type'=>'to','system_type' => array('108','102'));
            $databoard_data['ercp_advice_taken_to'] = $this->Dashboard_model_final_updated->get_ercp_advice_taken_count($arg_closed_mdt_last_month);
            //Feedback today
            $arg_closed_mdt_last_month = array('date_type'=>'to','system_type' => array('108','102'));
            $databoard_data['ercp_feedback_to'] = $this->Dashboard_model_final_updated->get_feedback_count($arg_closed_mdt_last_month);
            //Grievance today
            $arg_closed_mdt_last_month = array('date_type'=>'to','system_type' => array('108','102'));
            $databoard_data['ercp_grievance_to'] = $this->Dashboard_model_final_updated->get_grievance_count($arg_closed_mdt_last_month);

            //Total Ambulances
            $amb_all = array('system_type' => array('108','102'),'status' => 'all');
            $databoard_data['amb_total'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count($amb_all));
            
            $amb_available = array('system_type' => array('108','102'),'status' => '1');
            $databoard_data['amb_available'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count($amb_available));
            
            $amb_busy = array('system_type' => array('108','102'),'status' => '2');
            $databoard_data['amb_busy'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count($amb_busy));

            $amb_je = array('system_type' => array('108','102'),'type' => '1','amb_status' => array('1','2'));
            $databoard_data['amb_je'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count_typewise($amb_je));

            $amb_je = array('system_type' => array('108','102'),'type' =>'3','amb_status' => array('1','2'));
            $databoard_data['amb_als'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count_typewise($amb_je));

            $amb_je = array('system_type' => array('108','102'),'type' => '2','amb_status' => array('1','2'));
            $databoard_data['amb_bls'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count_typewise($amb_je));
            
           // $data['amb_busy'] = $amb_busy[];
           // var_dump($data);
            $databoard_data['count_till_date'] = $this->moneyFormatIndia($data[0]['count_till_date'] + 1526531 + $databoard_data['count_today']);
            $databoard_data['count_till_month'] = $this->moneyFormatIndia($data[0]['count_till_month'] + $databoard_data['count_today']);

            $databoard_data['eme_count_till_date'] = $this->moneyFormatIndia($data[0]['eme_count_till_date'] + 355526 +$databoard_data['eme_count_today_date']);
            $databoard_data['eme_count_till_month'] = $this->moneyFormatIndia($data[0]['eme_count_till_month'] + $databoard_data['eme_count_today_date']);

            $databoard_data['noneme_count_till_date'] = $this->moneyFormatIndia($data[0]['noneme_count_till_date'] + 1171005 + $databoard_data['noneme_count_today_date']);
            $databoard_data['noneme_count_till_month'] = $this->moneyFormatIndia($data[0]['noneme_count_till_month'] + $databoard_data['noneme_count_today_date']);
            
            $databoard_data['dispatch_till_date'] = $this->moneyFormatIndia($data[0]['eme_count_till_date'] + 355526 + $databoard_data['eme_count_today_date']) ;
            $databoard_data['dispatch_till_month'] = $this->moneyFormatIndia($data[0]['eme_count_till_month'] + $databoard_data['eme_count_today_date']) ;
            
            $databoard_data['closure_till_date'] = $this->moneyFormatIndia($data[0]['closure_till_date'] + $databoard_data['closure_today']) ;
            $databoard_data['closure_till_month'] = $this->moneyFormatIndia($data[0]['closure_till_month'] + $databoard_data['closure_today']) ;
         
            $databoard_data['eme_count_lm'] = $this->moneyFormatIndia($data[0]['eme_count_lm']);
            $databoard_data['closed_mdt_count_lm'] = $this->moneyFormatIndia($data[0]['closed_mdt_count_lm']);
            $databoard_data['closed_dco_count_lm'] = $this->moneyFormatIndia($data[0]['closed_dco_count_lm']);
            $databoard_data['closed_validated_count_lm'] = $this->moneyFormatIndia($data[0]['closed_validated_count_lm']);
            $databoard_data['ercp_advice_taken_lm'] = $this->moneyFormatIndia($data[0]['ercp_advice_taken_lm']);
            $databoard_data['ercp_feedback_lm'] = $this->moneyFormatIndia($data[0]['ercp_feedback_lm']);
            $databoard_data['ercp_grievance_lm'] = $this->moneyFormatIndia($data[0]['ercp_grievance_lm']);
            $databoard_data['complaint_lm'] = $this->moneyFormatIndia($data[0]['104_comp_lm']);
            $databoard_data['all_call_count_lm'] = $this->moneyFormatIndia($data[0]['104All_count_lm']);

            $databoard_data['closed_mdt_count_tm'] = $this->moneyFormatIndia($data[0]['closed_mdt_count_tm']);
            $databoard_data['closed_dco_count_tm'] = $this->moneyFormatIndia($data[0]['closed_dco_count_tm']);
            $databoard_data['closed_validated_count_tm'] = $this->moneyFormatIndia($data[0]['closed_validated_count_tm']);
            $databoard_data['ercp_advice_taken_tm'] = $this->moneyFormatIndia($data[0]['ercp_advice_taken_tm']);
            $databoard_data['ercp_feedback_tm'] = $this->moneyFormatIndia($data[0]['ercp_feedback_tm']);
            $databoard_data['ercp_grievance_tm'] = $this->moneyFormatIndia($data[0]['ercp_grievance_tm']);
            $databoard_data['complaint_tm'] = $this->moneyFormatIndia($data[0]['104_comp_tm']);
            $databoard_data['all_call_count_tm'] = $this->moneyFormatIndia($data[0]['104All_count_tm']);

            $databoard_data['closed_mdt_count_td'] = $this->moneyFormatIndia($data[0]['closed_mdt_count_td']);
            $databoard_data['closed_dco_count_td'] = $this->moneyFormatIndia($data[0]['closed_dco_count_td']);
            $databoard_data['closed_validated_count_td'] = $this->moneyFormatIndia($data[0]['closed_validated_count_td']);
            $databoard_data['ercp_advice_taken_td'] = $this->moneyFormatIndia($data[0]['ercp_advice_taken_td']);
            $databoard_data['ercp_feedback_td'] = $this->moneyFormatIndia($data[0]['ercp_feedback_td']);
            $databoard_data['ercp_grievance_td'] = $this->moneyFormatIndia($data[0]['ercp_grievance_td']);
            $databoard_data['complaint_td'] = $this->moneyFormatIndia($data[0]['104_comp_td']);
            // var_dump($databoard_data['complaint_td']);die();
            $databoard_data['all_call_count_td'] = $this->moneyFormatIndia($data[0]['104All_count_td']);

            $from_date_live = '2022-08-01 00:00:00';
            //Till date 
            $previous_day = date('Y-m-d', strtotime('-1 day', strtotime($current_date))).' 23:59:59';
            $from_date = $from_date_live;
            //echo "closed count mdt Today<br>";
            $arg_closed_mdt_last_month = array('date_type'=>'to','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('108','102'));
            $databoard_data['closed_mdt_count_to'] = $this->Dashboard_model_final_updated->get_mdt_closed_count($arg_closed_mdt_last_month);
            
            //echo "closed count closed by DCO last month<br>";
            $arg_closed_mdt_last_month = array('date_type'=>'to','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('108','102'));
            $databoard_data['closed_dco_count_to'] = $this->Dashboard_model_final_updated->get_dco_closed_count($arg_closed_mdt_last_month);
            //echo "closed validated by DCO last month<br>";            
            $arg_closed_mdt_last_month = array('date_type'=>'to','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('108','102'));
            $databoard_data['closed_validated_count_to'] = $this->Dashboard_model_final_updated->get_dcovalidated_closed_count($arg_closed_mdt_last_month);
            //echo "ERCP Advice Taken last month<br>";
            $arg_closed_mdt_last_month = array('date_type'=>'to','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('108','102'));
            $databoard_data['ercp_advice_taken_to'] = $this->Dashboard_model_final_updated->get_ercp_advice_taken_count($arg_closed_mdt_last_month);
            //echo "feedback Taken last month<br>";
            $arg_closed_mdt_last_month = array('date_type'=>'to','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('108','102'));
            $databoard_data['ercp_feedback_to'] = $this->Dashboard_model_final_updated->get_feedback_count($arg_closed_mdt_last_month);
            //echo "grievance last month<br>";
            $arg_closed_mdt_last_month = array('date_type'=>'to','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('108','102'));
            $databoard_data['ercp_grievance_to'] = $this->Dashboard_model_final_updated->get_grievance_count($arg_closed_mdt_last_month);
             //echo "104complaint_last_month<br>";    
            $arg_last_month = array('date_type'=>'to','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('104'));
            $databoard_data['complaint_to1'] = $this->Dashboard_model_final_updated->get_total_104Comp_call_type($arg_last_month);
            $databoard_data['complaint_to']= (int)$databoard_data['complaint_to1'];
             //echo "104All_Calls_last_month<br>";    
             $arg_last_month = array('date_type'=>'to','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('104'));
             $databoard_data['all_call_count_to1'] = $this->Dashboard_model_final_updated->get_total_104ALLcall_type($arg_last_month);
             $databoard_data['complaint_to']= (int)$databoard_data['all_call_count_to1'];

           
            // Total Calls Dispatched
            $databoard_data['dispatch_last_month_lm'] = $this->moneyFormatIndia($data[0]['eme_count_lm']);
            $databoard_data['dispatch_till_date_td'] = $this->moneyFormatIndia($data[0]['eme_count_till_date'] + 355526 + $databoard_data['eme_count_today_date']) ;
            $databoard_data['dispatch_this_month_tm'] = $this->moneyFormatIndia($data[0]['eme_count_till_month'] + $databoard_data['eme_count_today_date']);
           
            $this_month=0;
           $last_month=0;
           $till_date=0;
           $today=0;
           if((int)$data[0]['eme_count_till_month']!=0)
           {
               $this_month = (int)$data[0]['closed_validated_count_tm'] ;
               $this_month_total = ($this_month / (int)$data[0]['eme_count_till_month']) *100;
           }
           if((int)$data[0]['eme_count_lm']!=0)
           {
               $last_month = (int)$data[0]['closed_validated_count_lm'];
               $last_month_total = ($last_month / (int)$data[0]['eme_count_lm']) * 100;
           }
            if((int)$data[0]['eme_count_till_date']!=0)
           {
               $till_date = (int)$data[0]['closed_validated_count_td'] ;
               $till_date_total = ($till_date / (int)$data[0]['eme_count_till_date']) * 100;
           }
           if((int)$data[0]['dispatch_eme_count_today_date']!=0)
           {
               $today = (int)$data[0]['closed_validated_count_to'] ;
               $today_total = ($today / (int)$data[0]['dispatch_eme_count_today_date']) * 100;
           }

            
            $databoard_data['this_month_complete_closure']=round($this_month_total,2);
            $databoard_data['last_month_complete_closure']=round($last_month_total,2);
            $databoard_data['till_date_complete_closure']=round($till_date_total,2);

            echo json_encode($databoard_data);
            exit;
        }else{
             dashboard_redirect($user_group,$this->base_url );
        }
    }
    
	public function erc_dash()
	{	
        
        $user_group=$this->clg->clg_group;  
        if ($user_group == 'UG-JAES-DASHBOARD') {
            $data =array();
            $data = $this->Dashboard_model_final_updated->get_total_calls_frm_dashboard_tbl();
            $current_date = date('Y-m-d');
            $from_date = date('Y-m-d', strtotime($current_date)).' 00:00:00';
            $to_date = date('Y-m-d', strtotime($current_date)).' 23:59:59';

            $databoard_data = array();
            //echo "resourse Total<br>";
          //  $databoard_data['resourse_available'] = $this->Dashboard_model_final_updated->get_total_resourse_count();

            //echo "resourse Login Today<br>";
           // $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'));
           // $databoard_data['resourse_count'] = $this->Dashboard_model_final_updated->get_total_login_count($arg_month_date);
           //var_dump('hi');
            //echo "ERO free Login Status<br>";
            $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'),'call_status' => 'free');
            $databoard_data['ero_free'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_ero_login_count($arg_month_date));
            //echo "ERO On Call Login Status<br>";
            //var_dump('hi');
            $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'),'call_status' => 'atnd');
            $databoard_data['ero_atend'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_ero_login_count($arg_month_date));
            //echo "ERO Break Login Status<br>";
            $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'),'call_status' => 'break');
            $databoard_data['ero_break'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_ero_login_count($arg_month_date));
            
            //echo "total_count_today_date<br>";
            $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'));
            $databoard_data['count_today'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_call_count($arg_month_date));
            
            //Closure count Today
            $closure_report = array('to_date' => $to_date,'from_date' => $from_date,'system_type' => array('108','102'));
            $databoard_data['closure_today'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->Total_closure_data($closure_report,array('21','41','42','43','44')));
            
            // echo "eme_count_today_date<br>";
            $arg_till_date = array('date_type'=>'to','type'=>'eme','system_type' => array('108','102'));
            $databoard_data['eme_count_today_date']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_call_type($arg_till_date));
            
            //echo "noneme_count_today_date<br>";
            $arg_till_date = array('date_type'=>'to','type'=>'non-eme','system_type' => array('108','102'));
            $databoard_data['noneme_count_today_date']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_call_type($arg_till_date));
        
            //Total Ambulances
            $amb_all = array('system_type' => array('108','102'),'status' => 'all');
            $databoard_data['amb_total'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count($amb_all));
            
            //ERCP Advice Taken today
            $arg_closed_mdt_last_month = array('date_type'=>'to','system_type' => array('108','102'));
            $databoard_data['ercp_advice_taken_to'] = $this->Dashboard_model_final_updated->get_ercp_advice_taken_count($arg_closed_mdt_last_month);
            //Feedback today
            $arg_closed_mdt_last_month = array('date_type'=>'to','system_type' => array('108','102'));
            $databoard_data['ercp_feedback_to'] = $this->Dashboard_model_final_updated->get_feedback_count($arg_closed_mdt_last_month);
            //Grievance today
            $arg_closed_mdt_last_month = array('date_type'=>'to','system_type' => array('108','102'));
            $databoard_data['ercp_grievance_to'] = $this->Dashboard_model_final_updated->get_grievance_count($arg_closed_mdt_last_month);

            $amb_available = array('system_type' => array('108','102'),'status' => '1');
            $databoard_data['amb_available'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count($amb_available));
            
            $amb_busy = array('system_type' => array('108','102'),'status' => '2');
            $databoard_data['amb_busy'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count($amb_busy));
            
            $amb_je = array('system_type' => array('108','102'),'type' => '1','amb_status' => array('1','2'));
            $databoard_data['amb_je'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count_typewise($amb_je));

            $amb_je = array('system_type' => array('108','102'),'type' =>'3','amb_status' => array('1','2'));
            $databoard_data['amb_als'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count_typewise($amb_je));

            $amb_je = array('system_type' => array('108','102'),'type' => '2','amb_status' => array('1','2'));
            $databoard_data['amb_bls'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count_typewise($amb_je));
            
            $databoard_data['count_till_date'] = $this->moneyFormatIndia($data[0]['count_till_date'] + 1526531 + $databoard_data['count_today']);
            $databoard_data['count_till_month'] = $this->moneyFormatIndia($data[0]['count_till_month'] + $databoard_data['count_today']);

            $databoard_data['eme_count_till_date'] = $this->moneyFormatIndia($data[0]['eme_count_till_date'] + 355526 + $databoard_data['eme_count_today_date']) ;
            $databoard_data['eme_count_till_month'] = $this->moneyFormatIndia($data[0]['eme_count_till_month'] + $databoard_data['eme_count_today_date']);

            $databoard_data['noneme_count_till_date'] = $this->moneyFormatIndia($data[0]['noneme_count_till_date'] + 1171005 + $databoard_data['noneme_count_today_date']);
            $databoard_data['noneme_count_till_month'] = $this->moneyFormatIndia($data[0]['noneme_count_till_month'] + $databoard_data['noneme_count_today_date']);
            
            $databoard_data['dispatch_till_date'] = $this->moneyFormatIndia($data[0]['eme_count_till_date'] + 355526 + $databoard_data['eme_count_today_date']) ;
            $databoard_data['dispatch_till_month'] = $this->moneyFormatIndia($data[0]['eme_count_till_month'] + $databoard_data['eme_count_today_date']);
            
            $databoard_data['closure_till_date'] = $this->moneyFormatIndia($data[0]['closure_till_date'] + $databoard_data['closure_today']) ;
            $databoard_data['closure_till_month'] = $this->moneyFormatIndia($data[0]['closure_till_month'] + $databoard_data['closure_today']) ;
            
            $dco_args = array('group' => 'UG-DCO');
            $databoard_data['dco_count'] = $this->Dashboard_model_final_updated->get_total_call_count6($dco_args);

            $databoard_data['pda_count'] = $this->Dashboard_model_final_updated->get_total_call_count6(array('group'=>'UG-PDA'));
            
            $databoard_data['ero_count'] = $this->Dashboard_model_final_updated->get_total_call_count6(array('group'=>'UG-ERO'));

            $databoard_data['ercp_count'] = $this->Dashboard_model_final_updated->get_total_call_count6(array('group'=>'UG-ERCP'));

            $databoard_data['grievance_count'] = $this->Dashboard_model_final_updated->get_total_call_count6(array('group'=>'UG-Grievance'));

            $databoard_data['feedback_count'] = $this->Dashboard_model_final_updated->get_total_call_count6(array('group'=>'UG-Feedback'));

            $databoard_data['quality_count'] = $this->Dashboard_model_final_updated->get_total_call_count6(array('group'=>'UG-Quality'));

            $databoard_data['dco_Tl_count'] = $this->Dashboard_model_final_updated->get_total_call_count6(array('group'=>'UG-DCOSupervisor'));

            $databoard_data['ero_Tl_count'] = $this->Dashboard_model_final_updated->get_total_call_count6(array('group'=>'UG-EROSupervisor'));

            $databoard_data['SM_count'] = $this->Dashboard_model_final_updated->get_total_call_count6(array('group'=>'UG-ShiftManager'));

            $databoard_data['ero104_count'] = $this->Dashboard_model_final_updated->get_total_call_count6(array('group'=>'UG-ERO-104'));
            
            $databoard_data['ercp_104_count'] = $this->Dashboard_model_final_updated->get_total_call_count6(array('group'=>'UG-ERCP-104'));
           
                       // $data['amb_busy'] = $amb_busy[];
           // var_dump($data);
           $databoard_data['count_till_date'] = $this->moneyFormatIndia($data[0]['count_till_date'] + 1526531 + $databoard_data['count_today']);
           $databoard_data['count_till_month'] = $this->moneyFormatIndia($data[0]['count_till_month'] + $databoard_data['count_today']);

           $databoard_data['eme_count_till_date'] = $this->moneyFormatIndia($data[0]['eme_count_till_date'] + 355526 +$databoard_data['eme_count_today_date']);
           $databoard_data['eme_count_till_month'] = $this->moneyFormatIndia($data[0]['eme_count_till_month'] + $databoard_data['eme_count_today_date']);

           $databoard_data['noneme_count_till_date'] = $this->moneyFormatIndia($data[0]['noneme_count_till_date'] + 1171005 + $databoard_data['noneme_count_today_date']);
           $databoard_data['noneme_count_till_month'] = $this->moneyFormatIndia($data[0]['noneme_count_till_month'] + $databoard_data['noneme_count_today_date']);
           
           $databoard_data['dispatch_till_date'] = $this->moneyFormatIndia($data[0]['eme_count_till_date'] + 355526 + $databoard_data['eme_count_today_date']) ;
           $databoard_data['dispatch_till_month'] = $this->moneyFormatIndia($data[0]['eme_count_till_month'] + $databoard_data['eme_count_today_date']) ;
           
           $databoard_data['closure_till_date'] = $this->moneyFormatIndia($data[0]['closure_till_date'] + $databoard_data['closure_today']) ;
           $databoard_data['closure_till_month'] = $this->moneyFormatIndia($data[0]['closure_till_month'] + $databoard_data['closure_today']) ;
        
           $databoard_data['eme_count_lm'] = $this->moneyFormatIndia($data[0]['eme_count_lm']);
           $databoard_data['closed_mdt_count_lm'] = $this->moneyFormatIndia($data[0]['closed_mdt_count_lm']);
           $databoard_data['closed_dco_count_lm'] = $this->moneyFormatIndia($data[0]['closed_dco_count_lm']);
           $databoard_data['closed_validated_count_lm'] = $this->moneyFormatIndia($data[0]['closed_validated_count_lm']);
           $databoard_data['ercp_advice_taken_lm'] = $this->moneyFormatIndia($data[0]['ercp_advice_taken_lm']);
           $databoard_data['ercp_feedback_lm'] = $this->moneyFormatIndia($data[0]['ercp_feedback_lm']);
           $databoard_data['ercp_grievance_lm'] = $this->moneyFormatIndia($data[0]['ercp_grievance_lm']);
           $databoard_data['complaint_lm'] = $this->moneyFormatIndia($data[0]['104_comp_lm']);
           $databoard_data['all_call_count_lm'] = $this->moneyFormatIndia($data[0]['104All_count_lm']);

           $databoard_data['closed_mdt_count_tm'] = $this->moneyFormatIndia($data[0]['closed_mdt_count_tm']);
           $databoard_data['closed_dco_count_tm'] = $this->moneyFormatIndia($data[0]['closed_dco_count_tm']);
           $databoard_data['closed_validated_count_tm'] = $this->moneyFormatIndia($data[0]['closed_validated_count_tm']);
           $databoard_data['ercp_advice_taken_tm'] = $this->moneyFormatIndia($data[0]['ercp_advice_taken_tm']);
           $databoard_data['ercp_feedback_tm'] = $this->moneyFormatIndia($data[0]['ercp_feedback_tm']);
           $databoard_data['ercp_grievance_tm'] = $this->moneyFormatIndia($data[0]['ercp_grievance_tm']);
           $databoard_data['complaint_tm'] = $this->moneyFormatIndia($data[0]['104_comp_tm']);
           $databoard_data['all_call_count_tm'] = $this->moneyFormatIndia($data[0]['104All_count_tm']);

           $databoard_data['closed_mdt_count_td'] = $this->moneyFormatIndia($data[0]['closed_mdt_count_td']);
           $databoard_data['closed_dco_count_td'] = $this->moneyFormatIndia($data[0]['closed_dco_count_td']);
           $databoard_data['closed_validated_count_td'] = $this->moneyFormatIndia($data[0]['closed_validated_count_td']);
           $databoard_data['ercp_advice_taken_td'] = $this->moneyFormatIndia($data[0]['ercp_advice_taken_td']);
           $databoard_data['ercp_feedback_td'] = $this->moneyFormatIndia($data[0]['ercp_feedback_td']);
           $databoard_data['ercp_grievance_td'] = $this->moneyFormatIndia($data[0]['ercp_grievance_td']);
           $databoard_data['complaint_td'] = $this->moneyFormatIndia($data[0]['104_comp_td']);
           $databoard_data['all_call_count_td'] = $this->moneyFormatIndia($data[0]['104All_count_td']);
           //var_dump($databoard_data['all_call_count_td']);die();

           $from_date_live = '2022-08-01 00:00:00';
           //Till date 
           $previous_day = date('Y-m-d', strtotime('-1 day', strtotime($current_date))).' 23:59:59';
           $from_date = $from_date_live;
           //echo "closed count mdt Today<br>";
           $arg_closed_mdt_last_month = array('date_type'=>'to','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('108','102'));
           $databoard_data['closed_mdt_count_to'] = $this->Dashboard_model_final_updated->get_mdt_closed_count($arg_closed_mdt_last_month);
           
           //echo "closed count closed by DCO last month<br>";
           $arg_closed_mdt_last_month = array('date_type'=>'to','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('108','102'));
           $databoard_data['closed_dco_count_to'] = $this->Dashboard_model_final_updated->get_dco_closed_count($arg_closed_mdt_last_month);
           //echo "closed validated by DCO last month<br>";
           $arg_closed_mdt_last_month = array('date_type'=>'to','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('108','102'));
           $databoard_data['closed_validated_count_to'] = $this->Dashboard_model_final_updated->get_dcovalidated_closed_count($arg_closed_mdt_last_month);
           //echo "ERCP Advice Taken last month<br>";
           $arg_closed_mdt_last_month = array('date_type'=>'to','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('108','102'));
           $databoard_data['ercp_advice_taken_to'] = $this->Dashboard_model_final_updated->get_ercp_advice_taken_count($arg_closed_mdt_last_month);
           //echo "feedback Taken last month<br>";
            $arg_closed_mdt_last_month = array('date_type'=>'to','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('108','102'));
            $databoard_data['ercp_feedback_to'] = $this->Dashboard_model_final_updated->get_feedback_count($arg_closed_mdt_last_month);
           //echo "grievance last month<br>";
           $arg_closed_mdt_last_month = array('date_type'=>'to','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('108','102'));
           $databoard_data['ercp_grievance_to'] = $this->Dashboard_model_final_updated->get_grievance_count($arg_closed_mdt_last_month);
            //echo "104complaint_last_month<br>";    
           $arg_last_month = array('date_type'=>'to','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('104'));
           $databoard_data['complaint_to1'] = $this->Dashboard_model_final_updated->get_total_104Comp_call_type($arg_last_month);
           $databoard_data['complaint_to']= (int)$databoard_data['complaint_to1'];
            //echo "104All_Calls_last_month<br>";    
            $arg_last_month = array('date_type'=>'to','to_date'=>$previous_day,'from_date'=>$from_date,'system_type' => array('104'));
            $databoard_data['all_call_count_to1'] = $this->Dashboard_model_final_updated->get_total_104ALLcall_type($arg_last_month);
            $databoard_data['complaint_to']= (int)$databoard_data['all_call_count_to1'];
          
           // Total Calls Dispatched
           $databoard_data['dispatch_last_month_lm'] = $this->moneyFormatIndia($data[0]['eme_count_lm']);
           $databoard_data['dispatch_till_date_td'] = $this->moneyFormatIndia($data[0]['eme_count_till_date'] + 355526 + $databoard_data['eme_count_today_date']) ;
           $databoard_data['dispatch_this_month_tm'] = $this->moneyFormatIndia($data[0]['eme_count_till_month'] + $databoard_data['eme_count_today_date']);
           $databoard_data['dispatch_eme_count_today_date']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_call_type($arg_till_date));
          //Todays Count
           $this_month=0;
           $last_month=0;
           $till_date=0;
           $today=0;
           if((int)$data[0]['eme_count_till_month']!=0)
           {
               $this_month = (int)$data[0]['closed_validated_count_tm'] ;
               $this_month_total = ($this_month / (int)$data[0]['eme_count_till_month']) *100;
           }
           if((int)$data[0]['eme_count_lm']!=0)
           {
               $last_month = (int)$data[0]['closed_validated_count_lm'];
               $last_month_total = ($last_month / (int)$data[0]['eme_count_lm']) * 100;
           }
            if((int)$data[0]['eme_count_till_date']!=0)
           {
               $till_date = (int)$data[0]['closed_validated_count_td'] ;
               $till_date_total = ($till_date / (int)$data[0]['eme_count_till_date']) * 100;
           }
           if((int)$data[0]['dispatch_eme_count_today_date']!=0)
           {
               $today = (int)$data[0]['closed_validated_count_to'] ;
               $today_total = ($today / (int)$data[0]['dispatch_eme_count_today_date']) * 100;
           }
           
           
           $databoard_data['this_month_complete_closure']=round($this_month_total,2);
           $databoard_data['last_month_complete_closure']=round($last_month_total,2);
           $databoard_data['till_date_complete_closure']=round($till_date_total,2);
           $databoard_data['today_complete_closure']=round($today_total,2);

            $this->load->view('erc_dashboard/erc_dash_tab_view' , ['data'=>$databoard_data]);
            $this->output->template = ('calls_nhm');
        }else{
             dashboard_redirect($user_group,$this->base_url );
        }
    }
    public function nhm_live_calls_dash_view(){
        $user_group=$this->clg->clg_group;  
        if ($user_group == 'UG-JAES-NHM-DASHBOARD') {
            $data =array();
            $data = $this->Dashboard_model_final_updated->get_total_calls_frm_dashboard_tbl();
            $current_date = date('Y-m-d');
            $from_date = date('Y-m-d', strtotime($current_date)).' 00:00:00';
            $to_date = date('Y-m-d', strtotime($current_date)).' 23:59:59';

            $to_date = date('Y-m-d', strtotime($current_date)).' 23:59:59';
            $databoard_data['tbl_data']=$data;
            //echo "resourse Total<br>";
            $databoard_data = array();
            
            $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'));
            $databoard_data['count_today'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_call_count($arg_month_date));
            
            //Closure count Today
            $closure_report = array('to_date' => $to_date,'from_date' => $from_date,'system_type' => array('108','102'));
            $databoard_data['closure_today'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->Total_closure_data($closure_report,array('21','41','42','43','44')));
            
            //Total today inc cases closed
            $closure_report_td = array('to_date' => $to_date,'from_date' => $from_date,'system_type' => array('108','102'));
            $databoard_data['today_cases_closed'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->Total_closure_data_today($closure_report_td,array('21','41','42','43','44')));

            // echo "eme_count_today_date<br>";
            $arg_till_date = array('date_type'=>'to','type'=>'eme','system_type' => array('108','102'));
            $databoard_data['eme_count_today_date']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_call_type($arg_till_date));
            $databoard_data['count_today_dispatch'] = $databoard_data['eme_count_today_date'];
            //echo "noneme_count_today_date<br>";
            $arg_till_date = array('date_type'=>'to','type'=>'non-eme','system_type' => array('108','102'));
            $databoard_data['noneme_count_today_date']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_call_type($arg_till_date));
        
            //Total Ambulances
            $amb_all = array('system_type' => array('108','102'),'status' => 'all');
            $databoard_data['amb_total'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count($amb_all));
            
            $amb_available = array('system_type' => array('108','102'),'status' => '1');
            $databoard_data['amb_available'] = $this->Dashboard_model_final_updated->get_amb_count($amb_available);
            
            $amb_busy = array('system_type' => array('108','102'),'status' => '2');
            $databoard_data['amb_busy'] = $this->Dashboard_model_final_updated->get_amb_count($amb_busy);
            
            $databoard_data['amb_on_road'] =  $databoard_data['amb_busy'] + $databoard_data['amb_available'];
            $amb_maintainance = array('system_type' => array('108','102'),'status' => '7');
            $databoard_data['amb_maintainance'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count($amb_maintainance));
            //Ambulance Type
                
            $amb_je = array('system_type' => array('108','102'),'type' => '1','amb_status' => array('1','2'));
            $databoard_data['amb_je'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count_typewise($amb_je));

            $amb_je = array('system_type' => array('108','102'),'type' =>'3','amb_status' => array('1','2'));
            $databoard_data['amb_als'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count_typewise($amb_je));

            $amb_je = array('system_type' => array('108','102'),'type' => '2','amb_status' => array('1','2'));
            $databoard_data['amb_bls'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count_typewise($amb_je));

            
            //Ambulance Status parameter
            $databoard_data['start_frm_base']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_start_frm_base($arg_till_date));
            $databoard_data['at_scene']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_at_scene($arg_till_date));
            $databoard_data['at_destination']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_at_destination($arg_till_date));
            $databoard_data['back_to_base']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_back_to_base($arg_till_date));
            //EMT Pilot Data
            $databoard_data['emt_present']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_emt_present($arg_till_date));
            $databoard_data['pilot_present']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_pilot_present($arg_till_date));
            //var_dump($databoard_data);die();
            
            $databoard_data['count_till_date'] = $this->moneyFormatIndia($data[0]['count_till_date']+1526531+ $databoard_data['count_today']);
            $databoard_data['count_till_month'] = $this->moneyFormatIndia($data[0]['count_till_month']+ $databoard_data['count_today']);
            $databoard_data['eme_count_till_date'] = $this->moneyFormatIndia($data[0]['eme_count_till_date']+355526+$databoard_data['eme_count_today_date']);
            $databoard_data['eme_count_till_month'] = $this->moneyFormatIndia($data[0]['eme_count_till_month']+$databoard_data['eme_count_today_date']) ;
            $databoard_data['noneme_count_till_date'] = $this->moneyFormatIndia($data[0]['noneme_count_till_date']+1171005+$databoard_data['noneme_count_today_date']);
            $databoard_data['noneme_count_till_month'] = $this->moneyFormatIndia($data[0]['noneme_count_till_month']+$databoard_data['noneme_count_today_date']);
            
            $databoard_data['dispatch_till_date'] = $this->moneyFormatIndia($data[0]['dispatch_till_date']+355526+$databoard_data['count_today']);

            $databoard_data['closure_till_date'] = $this->moneyFormatIndia($data[0]['closure_till_date']+ $databoard_data['closure_today']);
            $databoard_data['closure_till_month'] = $this->moneyFormatIndia($data[0]['closure_till_month']+ $databoard_data['closure_today']);

            $arg_till_date = array('date_type'=>'to','type'=>'non-eme','system_type' => array('108','102'));
            $databoard_data['pei_chart_non_eme_today']  = $this->Dashboard_model_final_updated->get_total_call_type($arg_till_date);
        
            $arg_till_date = array('date_type'=>'to','type'=>'eme','system_type' => array('108','102'));
            $databoard_data['pei_chart_eme_today']  = $this->Dashboard_model_final_updated->get_total_call_type($arg_till_date);
           
            $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'));
            $databoard_data['pei_chart_total_today'] = $this->Dashboard_model_final_updated->get_total_call_count($arg_month_date);
            
            $databoard_data['pei_chart_non_eme_till_date'] = $data[0]['noneme_count_till_date']+1171005+$databoard_data['pei_chart_non_eme_today'];
            $databoard_data['pei_chart_eme_till_date'] = $data[0]['eme_count_till_date']+355526+$databoard_data['pei_chart_eme_today'] ;   
            
            $databoard_data['pei_chart_total_till_date'] = $data[0]['count_till_date']+1526531+ $databoard_data['pei_chart_total_today'];
            $databoard_data['pei_chart_non_eme_till_month'] = $data[0]['noneme_count_till_month']+$databoard_data['pei_chart_non_eme_today'];

            $databoard_data['pei_chart_eme_today_till_month'] = $data[0]['eme_count_till_month']+$databoard_data['pei_chart_eme_today'] ;
            $databoard_data['pei_chart_total_today_till_month'] = $data[0]['count_till_month']+ $databoard_data['pei_chart_total_today'];     
            
          
            echo json_encode($databoard_data);
            exit;
            
        }else{
             dashboard_redirect($user_group,$this->base_url );
        }
    }
    public function kpi_dash(){
        $user_group=$this->clg->clg_group; 
        if ($user_group == 'UG-KPI-DASHBOARD') {
            $databoard_data = array();
            $this->load->view('kpi_dashboard/KPI_Dash1' , ['data'=>$databoard_data]);
            $this->output->template = ('erc_blank');
        }

    }
    public function integrated_call_center(){
        $user_group=$this->clg->clg_group;

        if ($user_group == 'UG-KPI-DASHBOARD') {
            $kpi_data = $this->kpi_dashboard_model->get_kpi_data();
            foreach($kpi_data as $key => $value){
                // print_r($value);die;          
            $databoard_data = array(
                'cc_kpi1_tcaa' => $this->moneyFormatIndia($value->cc_kpi1_tcaa),
                'cc_kpi1_caa_less_12_sec' => $this->moneyFormatIndia($value->cc_kpi1_caa_less_12_sec),
                'cc_kpi1_caa_more_12_sec' => $this->moneyFormatIndia($value->cc_kpi1_caa_more_12_sec),
                'cc_kpi2_tco' => $this->moneyFormatIndia($value->cc_kpi2_tco),
                'cc_kpi2_tca' => $this->moneyFormatIndia($value->cc_kpi2_tca),
                'cc_kpi3_total_hrs' => $value->cc_kpi3_total_hrs,
                'cc_kpi3_erc_up' => $value->cc_kpi3_erc_up,
                'cc_kpi3_erc_down' => $value->cc_kpi3_erc_down,
            );
            // print_r($databoard_data);die;
        }      
        $this->load->view('kpi_dashboard/KPI_Dash_Call_Center' , ['data'=>$databoard_data]);
        $this->output->template = ('erc_blank');
    } 
    }
    public function sanjeevani_service(){
        $user_group=$this->clg->clg_group; 
        if ($user_group == 'UG-KPI-DASHBOARD') {
            $kpi_data = $this->kpi_dashboard_model->get_kpi_data();
            foreach($kpi_data as $key => $value){
                // print_r($value);die;  
            $databoard_data = array(
                'sj_kpi1_cb' => $value->sj_kpi1_cb,
                'sj_kpi1_date' => date("d-M-Y", strtotime($value->sj_kpi1_date)),
                'sj_kpi1_month' => ucwords($value->sj_kpi1_month),
                'sj_kpi1_als_deploy_rfp' => $this->moneyFormatIndia($value->sj_kpi1_als_deploy_rfp),
                'sj_kpi1_bls_deploy_rfp' => $this->moneyFormatIndia($value->sj_kpi1_bls_deploy_rfp),
                'sj_kpi1_als_deployed' => $this->moneyFormatIndia($value->sj_kpi1_als_deployed),
                'sj_kpi1_bls_deployed' => $this->moneyFormatIndia($value->sj_kpi1_bls_deployed),
                'sj_kpi2_cb' => $value->sj_kpi2_cb,
                'sj_kpi2_tcs_urban' => $this->moneyFormatIndia($value->sj_kpi2_tcs_urban),
                'sj_kpi2_tcs_rural' => $this->moneyFormatIndia($value->sj_kpi2_tcs_rural),
                'sj_kpi2_res_time_urban' => $value->sj_kpi2_res_time_urban,
                'sj_kpi2_res_time_rural' => $value->sj_kpi2_res_time_rural,
                'sj_kpi3_cb' => $value->sj_kpi3_cb,
                'sj_kpi3_ta_A' => $this->moneyFormatIndia($value->sj_kpi3_ta_A),
                'sj_kpi3_ta_A_perc' => $value->sj_kpi3_ta_A_perc,
                'sj_kpi3_ta_onroad_B' => $this->moneyFormatIndia($value->sj_kpi3_ta_onroad_B),
                'sj_kpi3_ta_onroad_B_perc' => $value->sj_kpi3_ta_onroad_B_perc,
                'sj_kpi3_ta_offroad_more_24hrs_C' => $this->moneyFormatIndia($value->sj_kpi3_ta_offroad_more_24hrs_C),
                'sj_kpi3_ta_offroad_more_24hrs_C_perc' => $value->sj_kpi3_ta_offroad_more_24hrs_C_perc,
                'sj_kpi3_ta_offroad' => $this->moneyFormatIndia($value->sj_kpi3_ta_offroad),
                'sj_kpi3_ta_offroad_perc' => $value->sj_kpi3_ta_offroad_perc,
                'sj_kpi4_cb' => ucfirst($value->sj_kpi4_cb),
                'sj_kpi4_ta_A' => $this->moneyFormatIndia($value->sj_kpi4_ta_A),
                'sj_kpi4_ta_A_perc' => $value->sj_kpi4_ta_A_perc,
                'sj_kpi4_ta_onroad_B' => $this->moneyFormatIndia($value->sj_kpi4_ta_onroad_B),
                'sj_kpi4_ta_onroad_B_perc' => $value->sj_kpi4_ta_onroad_B_perc,
                'sj_kpi4_ta_offroad_more_60hrs_C' => $this->moneyFormatIndia($value->sj_kpi4_ta_offroad_more_60hrs_C),
                'sj_kpi4_ta_offroad_more_60hrs_C_perc' => $value->sj_kpi4_ta_offroad_more_60hrs_C_perc,
                'sj_kpi4_ta_D' => $this->moneyFormatIndia($value->sj_kpi4_ta_D),
                'sj_kpi4_ta_D_perc' => $value->sj_kpi4_ta_D_perc,
                'sj_kpi5_cb' => $value->sj_kpi5_cb,
                'sj_kpi5_ta_gps_device_A' => $this->moneyFormatIndia($value->sj_kpi5_ta_gps_device_A),
                'sj_kpi5_ta_gps_functn_B' => $this->moneyFormatIndia($value->sj_kpi5_ta_gps_functn_B),
                'sj_kpi5_ta_gps_device_non_functn_C' => $this->moneyFormatIndia($value->sj_kpi5_ta_gps_device_non_functn_C),
                'sj_kpi5_1_cb' => $value->sj_kpi5_1_cb,
                'sj_kpi5_1_ta_mdt_device_A' => $this->moneyFormatIndia($value->sj_kpi5_1_ta_mdt_device_A),
                'sj_kpi5_1_ta_mdt_functn_B' => $this->moneyFormatIndia($value->sj_kpi5_1_ta_mdt_functn_B),
                'sj_kpi5_1_ta_mdt_device_non_functn_C' => $this->moneyFormatIndia($value->sj_kpi5_1_ta_mdt_device_non_functn_C),
                'sj_kpi6_cb' => $value->sj_kpi6_cb,
                'sj_kpi6_ta_inspect_A' => $this->moneyFormatIndia($value->sj_kpi6_ta_inspect_A),
                'sj_kpi6_ta_audit_B' => $this->moneyFormatIndia($value->sj_kpi6_ta_audit_B),
                'sj_kpi7_cb' => $value->sj_kpi7_cb,
                'sj_kpi7_tnac_A_rural' => $this->moneyFormatIndia($value->sj_kpi7_tnac_A_rural),
                'sj_kpi7_tnac_A_urban' => $this->moneyFormatIndia($value->sj_kpi7_tnac_A_urban),
                'sj_kpi7_tnac_less_res_time_B_rural' => $this->moneyFormatIndia($value->sj_kpi7_tnac_less_res_time_B_rural),
                'sj_kpi7_tnac_less_res_time_B_urban' => $this->moneyFormatIndia($value->sj_kpi7_tnac_less_res_time_B_urban),
                'sj_kpi7_tnac_more_res_time_C_rural' => $this->moneyFormatIndia($value->sj_kpi7_tnac_more_res_time_C_rural),
                'sj_kpi7_tnac_more_res_time_C_urban' => $this->moneyFormatIndia($value->sj_kpi7_tnac_more_res_time_C_urban),
                'sj_kpi8_cb' => $value->sj_kpi8_cb,
                'sj_kpi8_tc_amb_equip_A' => $this->moneyFormatIndia($value->sj_kpi8_tc_amb_equip_A),
                'sj_kpi8_tc_amb_equip_avail_B' => $this->moneyFormatIndia($value->sj_kpi8_tc_amb_equip_avail_B),
                'sj_kpi8_tc_amb_equip_not_avail_C' => $this->moneyFormatIndia($value->sj_kpi8_tc_amb_equip_not_avail_C),
                'sj_kpi8_tn_days_amb_equip_not_avail_D' => $this->moneyFormatIndia($value->sj_kpi8_tn_days_amb_equip_not_avail_D),
            );
            }
            $this->load->view('kpi_dashboard/KPI_Dash_Sanjeevani' , ['data'=>$databoard_data]);
            $this->output->template = ('erc_blank');
        } 
    }
    public function janani_express_service(){
        $user_group=$this->clg->clg_group; 
        if ($user_group == 'UG-KPI-DASHBOARD') {
            $kpi_data = $this->kpi_dashboard_model->get_kpi_data();
            foreach($kpi_data as $key => $value){
                // print_r($value);die;  
            $databoard_data = array(
                'je_kpi1_cb' => $value->je_kpi1_cb,
                'je_kpi1_month' => ucwords($value->je_kpi1_month),
                'je_kpi1_jssk_deployed_prf' => $this->moneyFormatIndia($value->je_kpi1_jssk_deployed_prf),
                'je_kpi1_jssk_deployed' => $this->moneyFormatIndia($value->je_kpi1_jssk_deployed),
                'je_kpi1_remark' => ucfirst($value->je_kpi1_remark),
                'je_kpi2_cb' => $value->je_kpi2_cb,
                'je_kpi2_tcs_urban' => $this->moneyFormatIndia($value->je_kpi2_tcs_urban),
                'je_kpi2_tcs_rural' => $this->moneyFormatIndia($value->je_kpi2_tcs_rural),
                'je_kpi2_res_time_urban' => $value->je_kpi2_res_time_urban,
                'je_kpi2_res_time_rural' => $value->je_kpi2_res_time_rural,
                'je_kpi3_cb' => $value->je_kpi3_cb,
                'je_kpi3_ta_A' => $this->moneyFormatIndia($value->je_kpi3_ta_A),
                'je_kpi3_ta_A_perc' => $value->je_kpi3_ta_A_perc,
                'je_kpi3_ta_onroad_B' => $this->moneyFormatIndia($value->je_kpi3_ta_onroad_B),
                'je_kpi3_ta_onroad_B_perc' => $value->je_kpi3_ta_onroad_B_perc,
                'je_kpi3_ta_offroad_more_24hrs_C' => $this->moneyFormatIndia($value->je_kpi3_ta_offroad_more_24hrs_C),
                'je_kpi3_ta_offroad_more_24hrs_C_perc' => $value->je_kpi3_ta_offroad_more_24hrs_C_perc,
                'je_kpi3_ta_offroad' => $this->moneyFormatIndia($value->je_kpi3_ta_offroad),
                'je_kpi3_ta_offroad_perc' => $value->je_kpi3_ta_offroad_perc,
                'je_kpi4_cb' => ucfirst($value->je_kpi4_cb),
                'je_kpi4_ta_A' => $this->moneyFormatIndia($value->je_kpi4_ta_A),
                'je_kpi4_ta_A_perc' => $value->je_kpi4_ta_A_perc,
                'je_kpi4_ta_onroad_B' => $this->moneyFormatIndia($value->je_kpi4_ta_onroad_B),
                'je_kpi4_ta_onroad_B_perc' => $value->je_kpi4_ta_onroad_B_perc,
                'je_kpi4_ta_offroad_more_60hrs_C' => $this->moneyFormatIndia($value->je_kpi4_ta_offroad_more_60hrs_C),
                'je_kpi4_ta_offroad_more_60hrs_C_perc' => $value->je_kpi4_ta_offroad_more_60hrs_C_perc,
                'je_kpi4_ta_D' => $this->moneyFormatIndia($value->je_kpi4_ta_D),
                'je_kpi4_ta_D_perc' => $value->je_kpi4_ta_D_perc,
                'je_kpi5_cb' => $value->je_kpi5_cb,
                'je_kpi5_ta_gps_device_A' => $this->moneyFormatIndia($value->je_kpi5_ta_gps_device_A),
                'je_kpi5_ta_gps_functn_B' => $this->moneyFormatIndia($value->je_kpi5_ta_gps_functn_B),
                'je_kpi5_ta_gps_device_non_functn_C' => $this->moneyFormatIndia($value->je_kpi5_ta_gps_device_non_functn_C),
                'je_kpi5_1_cb' => $value->je_kpi5_1_cb,
                'je_kpi5_1_ta_mdt_device_A' => $this->moneyFormatIndia($value->je_kpi5_1_ta_mdt_device_A),
                'je_kpi5_1_ta_mdt_functn_B' => $this->moneyFormatIndia($value->je_kpi5_1_ta_mdt_functn_B),
                'je_kpi5_1_ta_mdt_device_non_functn_C' => $this->moneyFormatIndia($value->je_kpi5_1_ta_mdt_device_non_functn_C),
                'je_kpi6_cb' => $value->je_kpi6_cb,
                'je_kpi6_ta_inspect_A' => $this->moneyFormatIndia($value->je_kpi6_ta_inspect_A),
                'je_kpi6_ta_audit_B' => $this->moneyFormatIndia($value->je_kpi6_ta_audit_B),
                'je_kpi7_cb' => $value->je_kpi7_cb,
                'je_kpi7_tnac_A_rural' => $this->moneyFormatIndia($value->je_kpi7_tnac_A_rural),
                'je_kpi7_tnac_A_urban' => $this->moneyFormatIndia($value->je_kpi7_tnac_A_urban),
                'je_kpi7_tnac_less_res_time_B_rural' => $this->moneyFormatIndia($value->je_kpi7_tnac_less_res_time_B_rural),
                'je_kpi7_tnac_less_res_time_B_urban' => $this->moneyFormatIndia($value->je_kpi7_tnac_less_res_time_B_urban),
                'je_kpi7_tnac_more_res_time_C_rural' => $this->moneyFormatIndia($value->je_kpi7_tnac_more_res_time_C_rural),
                'je_kpi7_tnac_more_res_time_C_urban' => $this->moneyFormatIndia($value->je_kpi7_tnac_more_res_time_C_urban),
            );
            }
            $this->load->view('kpi_dashboard/KPI_Dash_Janani_Express' , ['data'=>$databoard_data]);
            $this->output->template = ('erc_blank');
        } 
    }
    public function helpline_service(){
        $user_group=$this->clg->clg_group; 
        if ($user_group == 'UG-KPI-DASHBOARD') {
            $kpi_data = $this->kpi_dashboard_model->get_kpi_data();
            foreach($kpi_data as $key => $value){
                // print_r($value);die; 
            $databoard_data = array(
                'hh_104_kpi1_cb' => $value->hh_104_kpi1_cb,
                'hh_104_kpi1_ta_A' => $this->moneyFormatIndia($value->hh_104_kpi1_ta_A),
                'hh_104_kpi1_ta_A_perc' => $value->hh_104_kpi1_ta_A_perc,
                'hh_104_kpi1_caa_less_12_sec' => $this->moneyFormatIndia($value->hh_104_kpi1_caa_less_12_sec),
                'hh_104_kpi1_caa_less_12_sec_perc' => $value->hh_104_kpi1_caa_less_12_sec_perc,
                'hh_104_kpi1_caa_more_12_sec' => $this->moneyFormatIndia($value->hh_104_kpi1_caa_more_12_sec),
                'hh_104_kpi1_caa_more_12_sec_perc' => $value->hh_104_kpi1_caa_more_12_sec_perc,
                'hh_104_kpi2_cb' => $value->hh_104_kpi2_cb,
                'hh_104_kpi2_tco' => $this->moneyFormatIndia($value->hh_104_kpi2_tco),
                'hh_104_kpi2_tco_perc' => $value->hh_104_kpi2_tco_perc,
                'hh_104_kpi2_tca' => $this->moneyFormatIndia($value->hh_104_kpi2_tca),
                'hh_104_kpi2_tca_perc' => $value->hh_104_kpi2_tca_perc,
                'hh_104_kpi3_cb' => $value->hh_104_kpi3_cb,
                'hh_104_kpi3_total_hrs' => ucfirst($value->hh_104_kpi3_total_hrs),
                'hh_104_kpi3_erc_uptime' => $this->moneyFormatIndia($value->hh_104_kpi3_erc_uptime),
                'hh_104_kpi3_erc_downtime' => $this->moneyFormatIndia($value->hh_104_kpi3_erc_downtime),
                'hh_104_kpi4_cb' => $value->hh_104_kpi4_cb, 
                'hh_104_kpi4_nhm_tl' => $this->moneyFormatIndia($value->hh_104_kpi4_nhm_tl),
                'hh_104_kpi4_nhm_doc' => $this->moneyFormatIndia($value->hh_104_kpi4_nhm_doc),
                'hh_104_kpi4_nhm_cp' => $this->moneyFormatIndia($value->hh_104_kpi4_nhm_cp),
                'hh_104_kpi4_nhm_paramedic' => $this->moneyFormatIndia($value->hh_104_kpi4_nhm_paramedic),
                'hh_104_kpi4_nhm_total' => $this->moneyFormatIndia($value->hh_104_kpi4_nhm_total),
                'hh_104_kpi4_jaes_tl' => $this->moneyFormatIndia($value->hh_104_kpi4_jaes_tl),
                'hh_104_kpi4_jaes_doc' => $this->moneyFormatIndia($value->hh_104_kpi4_jaes_doc),
                'hh_104_kpi4_jaes_cp' => $this->moneyFormatIndia($value->hh_104_kpi4_jaes_cp),
                'hh_104_kpi4_jaes_paramedic' => $this->moneyFormatIndia($value->hh_104_kpi4_jaes_paramedic),
                'hh_104_kpi4_jaes_total' => $this->moneyFormatIndia($value->hh_104_kpi4_jaes_total),
            );
            }
            $this->load->view('kpi_dashboard/KPI_Dash_104_Health_Helpline' , ['data'=>$databoard_data]);
            $this->output->template = ('erc_blank');
        } 
    }
   
    public function nhm_dash()
	{	
        $user_group=$this->clg->clg_group;  
        if ($user_group == 'UG-JAES-NHM-DASHBOARD') {
            $data =array();
            $data = $this->Dashboard_model_final_updated->get_total_calls_frm_dashboard_tbl();
            $current_date = date('Y-m-d');
            $from_date = date('Y-m-d', strtotime($current_date)).' 00:00:00';
            $to_date = date('Y-m-d', strtotime($current_date)).' 23:59:59';
           
            $databoard_data = array();
            
            //echo "total_count_today_date<br>";
            $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'));
            $databoard_data['count_today'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_call_count($arg_month_date));
           //Closure count Today
            $closure_report = array('to_date' => $to_date,'from_date' => $from_date,'system_type' => array('108','102'));
            $databoard_data['closure_today'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->Total_closure_data($closure_report,array('21','41','42','43','44')));
            
            //Total today inc cases closed
            $closure_report_td = array('to_date' => $to_date,'from_date' => $from_date,'system_type' => array('108','102'));
            $databoard_data['today_cases_closed'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->Total_closure_data_today($closure_report_td,array('21','41','42','43','44')));

            // echo "eme_count_today_date<br>";
            $arg_till_date = array('date_type'=>'to','type'=>'eme','system_type' => array('108','102'));
            $databoard_data['eme_count_today_date']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_call_type($arg_till_date));
            $databoard_data['count_today_dispatch'] = $databoard_data['eme_count_today_date'];
            //var_dump($dashboard_data['count_today_dispatch']);die();
            //echo "noneme_count_today_date<br>";
            $arg_till_date = array('date_type'=>'to','type'=>'non-eme','system_type' => array('108','102'));
            $databoard_data['noneme_count_today_date']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_call_type($arg_till_date));
            //Ambulance Type
            $amb_je = array('system_type' => array('108','102'),'type' => '1','amb_status' => array('1','2'));
            $databoard_data['amb_je'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count_typewise($amb_je));

            $amb_je = array('system_type' => array('108','102'),'type' =>'3','amb_status' => array('1','2'));
            $databoard_data['amb_als'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count_typewise($amb_je));

            $amb_je = array('system_type' => array('108','102'),'type' => '2','amb_status' => array('1','2'));
            $databoard_data['amb_bls'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count_typewise($amb_je));

            //Total Ambulances
            $amb_all = array('system_type' => array('108','102'),'status' => 'all');
            $databoard_data['amb_total'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count($amb_all));
            
            $amb_available = array('system_type' => array('108','102'),'status' => '1');
            $databoard_data['amb_available'] = $this->Dashboard_model_final_updated->get_amb_count($amb_available);
            
            $amb_busy = array('system_type' => array('108','102'),'status' => '2');
            $databoard_data['amb_busy'] = $this->Dashboard_model_final_updated->get_amb_count($amb_busy);
            $databoard_data['amb_on_road'] =  $databoard_data['amb_busy'] + $databoard_data['amb_available'];
            $amb_maintainance = array('system_type' => array('108','102'),'status' => '7');
            $databoard_data['amb_maintainance'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count($amb_maintainance));
            //Ambulance Status parameter
            $databoard_data['start_frm_base']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_start_frm_base($arg_till_date));
            $databoard_data['at_scene']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_at_scene($arg_till_date));
            $databoard_data['at_destination']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_at_destination($arg_till_date));
            $databoard_data['back_to_base']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_back_to_base($arg_till_date));
            //EMT Pilot Data
            $databoard_data['emt_present']  =$this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_emt_present($arg_till_date));
            $databoard_data['pilot_present']  =$this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_pilot_present($arg_till_date));
            
           // setlocale(LC_MONETARY, 'en_IN');
            
            $databoard_data['count_till_date'] = $this->moneyFormatIndia($data[0]['count_till_date']+1526531+ $databoard_data['count_today']);
            $databoard_data['count_till_month'] = $this->moneyFormatIndia($data[0]['count_till_month']+ $databoard_data['count_today']);
            $databoard_data['eme_count_till_date'] = $this->moneyFormatIndia($data[0]['eme_count_till_date']+355526+$databoard_data['eme_count_today_date']);
            $databoard_data['eme_count_till_month'] = $this->moneyFormatIndia($data[0]['eme_count_till_month']+$databoard_data['eme_count_today_date']);
            $databoard_data['noneme_count_till_date'] = $this->moneyFormatIndia($data[0]['noneme_count_till_date']+1171005+$databoard_data['noneme_count_today_date']);
            $databoard_data['noneme_count_till_month'] = $this->moneyFormatIndia($data[0]['noneme_count_till_month']+$databoard_data['noneme_count_today_date']);
            
            $databoard_data['dispatch_till_date'] = $this->moneyFormatIndia($data[0]['dispatch_till_date']+355526+$databoard_data['count_today']);

            $databoard_data['closure_till_date'] = $this->moneyFormatIndia($data[0]['closure_till_date']+ $databoard_data['closure_today']);
            $databoard_data['closure_till_month'] = $this->moneyFormatIndia($data[0]['closure_till_month']+ $databoard_data['closure_today']);
            

            $arg_till_date = array('date_type'=>'to','type'=>'non-eme','system_type' => array('108','102'));
            $databoard_data['pei_chart_non_eme_today']  = $this->Dashboard_model_final_updated->get_total_call_type($arg_till_date);
        
            $arg_till_date = array('date_type'=>'to','type'=>'eme','system_type' => array('108','102'));
            $databoard_data['pei_chart_eme_today']  = $this->Dashboard_model_final_updated->get_total_call_type($arg_till_date);
           
            $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'));
            $databoard_data['pei_chart_total_today'] = $this->Dashboard_model_final_updated->get_total_call_count($arg_month_date);
            
            $databoard_data['pei_chart_non_eme_till_date'] = $data[0]['noneme_count_till_date']+1171005+$databoard_data['pei_chart_non_eme_today'];
            $databoard_data['pei_chart_eme_till_date'] = $data[0]['eme_count_till_date']+355526+$databoard_data['pei_chart_eme_today'] ;   
            
            $databoard_data['pei_chart_total_till_date'] = $data[0]['count_till_date']+1526531+ $databoard_data['pei_chart_total_today'];
            $databoard_data['pei_chart_non_eme_till_month'] = $data[0]['noneme_count_till_month']+$databoard_data['pei_chart_non_eme_today'];

            $databoard_data['pei_chart_eme_today_till_month'] = $data[0]['eme_count_till_month']+$databoard_data['pei_chart_eme_today'] ;
            $databoard_data['pei_chart_total_today_till_month'] = $data[0]['count_till_month']+ $databoard_data['pei_chart_total_today'];     
            
            
            $this->load->view('erc_dashboard/erc_dash2' , ['data'=>$databoard_data]);
            $this->output->template = ('erc_blank');
            
        }else{
             dashboard_redirect($user_group,$this->base_url );
        }
    }
 // function CM_dash(){
    //     $user_group=$this->clg->clg_group;  
    //     if ($user_group == 'UG-CM') {
    //         $databoard_data = array();
    //         $this->load->view('erc_dashboard/CM' , ['data'=>$databoard_data]);
    //         $this->output->template = ('erc_blank');
    //     }
    // }
    function cm_live_calls_dash_view(){
        $user_group=$this->clg->clg_group;  
        if ($user_group == 'UG-CM') {
            $data =array();
            $data = $this->Dashboard_model_final_updated->get_total_calls_frm_dashboard_tbl();
            $current_date = date('Y-m-d');
            $from_date = date('Y-m-d', strtotime($current_date)).' 00:00:00';
            $to_date = date('Y-m-d', strtotime($current_date)).' 23:59:59';
           
            $databoard_data = array();
            
            //echo "total_count_today_date<br>";
            $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'));
            $databoard_data['count_today'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_call_count($arg_month_date));
           //Closure count Today
            $closure_report = array('to_date' => $to_date,'from_date' => $from_date,'system_type' => array('108','102'));
            $databoard_data['closure_today'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->Total_closure_data($closure_report,array('21','41','42','43','44')));
            
            //Total today inc cases closed
            $closure_report_td = array('to_date' => $to_date,'from_date' => $from_date,'system_type' => array('108','102'));
            $databoard_data['today_cases_closed'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->Total_closure_data_today($closure_report_td,array('21','41','42','43','44')));

            // echo "eme_count_today_date<br>";
            $arg_till_date = array('date_type'=>'to','type'=>'eme','system_type' => array('108','102'));
            $databoard_data['eme_count_today_date']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_call_type($arg_till_date));
            $databoard_data['count_today_dispatch'] = $databoard_data['eme_count_today_date'];
            //var_dump($dashboard_data['count_today_dispatch']);die();
            //echo "noneme_count_today_date<br>";
            $arg_till_date = array('date_type'=>'to','type'=>'non-eme','system_type' => array('108','102'));
            $databoard_data['noneme_count_today_date']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_call_type($arg_till_date));
            //Ambulance Type
            $amb_je = array('system_type' => array('108','102'),'type' => '1','amb_status' => array('1','2'));
            $databoard_data['amb_je'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count_typewise($amb_je));

            $amb_je = array('system_type' => array('108','102'),'type' =>'3','amb_status' => array('1','2'));
            $databoard_data['amb_als'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count_typewise($amb_je));

            $amb_je = array('system_type' => array('108','102'),'type' => '2','amb_status' => array('1','2'));
            $databoard_data['amb_bls'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count_typewise($amb_je));

            //Total Ambulances
            $amb_all = array('system_type' => array('108','102'),'status' => 'all');
            $databoard_data['amb_total'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count($amb_all));
            
            // Avalable Ambulance
            $amb_available = array('system_type' => array('108','102'),'status' => '1');
            $databoard_data['amb_available'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count($amb_available));
                

            $amb_available = array('system_type' => array('108','102'),'status' => '1');
            $databoard_data['amb_available'] = $this->Dashboard_model_final_updated->get_amb_count($amb_available);
            
            $amb_busy = array('system_type' => array('108','102'),'status' => '2');
            $databoard_data['amb_busy'] = $this->Dashboard_model_final_updated->get_amb_count($amb_busy);
            $databoard_data['amb_on_road'] =  $databoard_data['amb_busy'] + $databoard_data['amb_available'];
            $amb_maintainance = array('system_type' => array('108','102'),'status' => '7');
            $databoard_data['amb_maintainance'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count($amb_maintainance));
            //Ambulance Status parameter
            $databoard_data['start_frm_base']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_start_frm_base($arg_till_date));
            $databoard_data['at_scene']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_at_scene($arg_till_date));
            $databoard_data['at_destination']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_at_destination($arg_till_date));
            $databoard_data['back_to_base']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_back_to_base($arg_till_date));
            //EMT Pilot Data
            $databoard_data['emt_present']  =$this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_emt_present($arg_till_date));
            $databoard_data['pilot_present']  =$this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_pilot_present($arg_till_date));
            
           // setlocale(LC_MONETARY, 'en_IN');
            
            $databoard_data['count_till_date'] = $this->moneyFormatIndia($data[0]['count_till_date']+1526531+ $databoard_data['count_today']);
            $databoard_data['count_till_month'] = $this->moneyFormatIndia($data[0]['count_till_month']+ $databoard_data['count_today']);
            $databoard_data['eme_count_till_date'] = $this->moneyFormatIndia($data[0]['eme_count_till_date']+355526+$databoard_data['eme_count_today_date']);
            $databoard_data['eme_count_till_month'] = $this->moneyFormatIndia($data[0]['eme_count_till_month']+$databoard_data['eme_count_today_date']);
            $databoard_data['noneme_count_till_date'] = $this->moneyFormatIndia($data[0]['noneme_count_till_date']+1171005+$databoard_data['noneme_count_today_date']);
            $databoard_data['noneme_count_till_month'] = $this->moneyFormatIndia($data[0]['noneme_count_till_month']+$databoard_data['noneme_count_today_date']);
            
            $databoard_data['dispatch_till_date'] = $this->moneyFormatIndia($data[0]['dispatch_till_date']+355526+$databoard_data['count_today']);

            $databoard_data['closure_till_date'] = $this->moneyFormatIndia($data[0]['closure_till_date']+ $databoard_data['closure_today']);
            $databoard_data['closure_till_month'] = $this->moneyFormatIndia($data[0]['closure_till_month']+ $databoard_data['closure_today']);
            

            $arg_till_date = array('date_type'=>'to','type'=>'non-eme','system_type' => array('108','102'));
            $databoard_data['pei_chart_non_eme_today']  = $this->Dashboard_model_final_updated->get_total_call_type($arg_till_date);
        
            $arg_till_date = array('date_type'=>'to','type'=>'eme','system_type' => array('108','102'));
            $databoard_data['pei_chart_eme_today']  = $this->Dashboard_model_final_updated->get_total_call_type($arg_till_date);
           
            $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'));
            $databoard_data['pei_chart_total_today'] = $this->Dashboard_model_final_updated->get_total_call_count($arg_month_date);
            
            $databoard_data['pei_chart_non_eme_till_date'] = $data[0]['noneme_count_till_date']+1171005+$databoard_data['pei_chart_non_eme_today'];
            $databoard_data['pei_chart_eme_till_date'] = $data[0]['eme_count_till_date']+355526+$databoard_data['pei_chart_eme_today'] ;   
            
            $databoard_data['pei_chart_total_till_date'] = $data[0]['count_till_date']+1526531+ $databoard_data['pei_chart_total_today'];
            $databoard_data['pei_chart_non_eme_till_month'] = $data[0]['noneme_count_till_month']+$databoard_data['pei_chart_non_eme_today'];

            $databoard_data['pei_chart_eme_today_till_month'] = $data[0]['eme_count_till_month']+$databoard_data['pei_chart_eme_today'] ;
            $databoard_data['pei_chart_total_today_till_month'] = $data[0]['count_till_month']+ $databoard_data['pei_chart_total_today'];     
            
            echo json_encode($databoard_data);
            exit;
           // $this->load->view('erc_dashboard/CM' , ['data'=>$databoard_data]);
           // $this->output->template = ('erc_blank');
            
        }else{
             dashboard_redirect($user_group,$this->base_url );
        }
    }
    public function CM_dash()
	{	
        $user_group=$this->clg->clg_group;  
        if ($user_group == 'UG-CM') {
            $data =array();
            $data = $this->Dashboard_model_final_updated->get_total_calls_frm_dashboard_tbl();
            $current_date = date('Y-m-d');
            $from_date = date('Y-m-d', strtotime($current_date)).' 00:00:00';
            $to_date = date('Y-m-d', strtotime($current_date)).' 23:59:59';
           
            $databoard_data = array();
            
            //echo "total_count_today_date<br>";
            $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'));
            $databoard_data['count_today'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_call_count($arg_month_date));
           //Closure count Today
            $closure_report = array('to_date' => $to_date,'from_date' => $from_date,'system_type' => array('108','102'));
            $databoard_data['closure_today'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->Total_closure_data($closure_report,array('21','41','42','43','44')));
            
            //Total today inc cases closed
            $closure_report_td = array('to_date' => $to_date,'from_date' => $from_date,'system_type' => array('108','102'));
            $databoard_data['today_cases_closed'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->Total_closure_data_today($closure_report_td,array('21','41','42','43','44')));

            // echo "eme_count_today_date<br>";
            $arg_till_date = array('date_type'=>'to','type'=>'eme','system_type' => array('108','102'));
            $databoard_data['eme_count_today_date']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_call_type($arg_till_date));
            $databoard_data['count_today_dispatch'] = $databoard_data['eme_count_today_date'];
            //var_dump($dashboard_data['count_today_dispatch']);die();
            //echo "noneme_count_today_date<br>";
            $arg_till_date = array('date_type'=>'to','type'=>'non-eme','system_type' => array('108','102'));
            $databoard_data['noneme_count_today_date']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_call_type($arg_till_date));
            //Ambulance Type
            $amb_je = array('system_type' => array('108','102'),'type' => '1','amb_status' => array('1','2'));
            $databoard_data['amb_je'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count_typewise($amb_je));

            $amb_je = array('system_type' => array('108','102'),'type' =>'3','amb_status' => array('1','2'));
            $databoard_data['amb_als'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count_typewise($amb_je));

            $amb_je = array('system_type' => array('108','102'),'type' => '2','amb_status' => array('1','2'));
            $databoard_data['amb_bls'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count_typewise($amb_je));

            //Total Ambulances
            $amb_all = array('system_type' => array('108','102'),'status' => 'all');
            $databoard_data['amb_total'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count($amb_all));
            
            // Avalable Ambulance
            $amb_available = array('system_type' => array('108','102'),'status' => '1');
            $databoard_data['amb_available'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count($amb_available));
                

            $amb_available = array('system_type' => array('108','102'),'status' => '1');
            $databoard_data['amb_available'] = $this->Dashboard_model_final_updated->get_amb_count($amb_available);
            
            $amb_busy = array('system_type' => array('108','102'),'status' => '2');
            $databoard_data['amb_busy'] = $this->Dashboard_model_final_updated->get_amb_count($amb_busy);
            $databoard_data['amb_on_road'] =  $databoard_data['amb_busy'] + $databoard_data['amb_available'];
            $amb_maintainance = array('system_type' => array('108','102'),'status' => '7');
            $databoard_data['amb_maintainance'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count($amb_maintainance));
            //Ambulance Status parameter
            $databoard_data['start_frm_base']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_start_frm_base($arg_till_date));
            $databoard_data['at_scene']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_at_scene($arg_till_date));
            $databoard_data['at_destination']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_at_destination($arg_till_date));
            $databoard_data['back_to_base']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_back_to_base($arg_till_date));
            //EMT Pilot Data
            $databoard_data['emt_present']  =$this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_emt_present($arg_till_date));
            $databoard_data['pilot_present']  =$this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_pilot_present($arg_till_date));
            
           // setlocale(LC_MONETARY, 'en_IN');
            
            $databoard_data['count_till_date'] = $this->moneyFormatIndia($data[0]['count_till_date']+1526531+ $databoard_data['count_today']);
            $databoard_data['count_till_month'] = $this->moneyFormatIndia($data[0]['count_till_month']+ $databoard_data['count_today']);
            $databoard_data['eme_count_till_date'] = $this->moneyFormatIndia($data[0]['eme_count_till_date']+355526+$databoard_data['eme_count_today_date']);
            $databoard_data['eme_count_till_month'] = $this->moneyFormatIndia($data[0]['eme_count_till_month']+$databoard_data['eme_count_today_date']);
            $databoard_data['noneme_count_till_date'] = $this->moneyFormatIndia($data[0]['noneme_count_till_date']+1171005+$databoard_data['noneme_count_today_date']);
            $databoard_data['noneme_count_till_month'] = $this->moneyFormatIndia($data[0]['noneme_count_till_month']+$databoard_data['noneme_count_today_date']);
            
            $databoard_data['dispatch_till_date'] = $this->moneyFormatIndia($data[0]['dispatch_till_date']+355526+$databoard_data['count_today']);

            $databoard_data['closure_till_date'] = $this->moneyFormatIndia($data[0]['closure_till_date']+ $databoard_data['closure_today']);
            $databoard_data['closure_till_month'] = $this->moneyFormatIndia($data[0]['closure_till_month']+ $databoard_data['closure_today']);
            

            $arg_till_date = array('date_type'=>'to','type'=>'non-eme','system_type' => array('108','102'));
            $databoard_data['pei_chart_non_eme_today']  = $this->Dashboard_model_final_updated->get_total_call_type($arg_till_date);
        
            $arg_till_date = array('date_type'=>'to','type'=>'eme','system_type' => array('108','102'));
            $databoard_data['pei_chart_eme_today']  = $this->Dashboard_model_final_updated->get_total_call_type($arg_till_date);
           
            $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'));
            $databoard_data['pei_chart_total_today'] = $this->Dashboard_model_final_updated->get_total_call_count($arg_month_date);
            
            $databoard_data['pei_chart_non_eme_till_date'] = $data[0]['noneme_count_till_date']+1171005+$databoard_data['pei_chart_non_eme_today'];
            $databoard_data['pei_chart_eme_till_date'] = $data[0]['eme_count_till_date']+355526+$databoard_data['pei_chart_eme_today'] ;   
            
            $databoard_data['pei_chart_total_till_date'] = $data[0]['count_till_date']+1526531+ $databoard_data['pei_chart_total_today'];
            $databoard_data['pei_chart_non_eme_till_month'] = $data[0]['noneme_count_till_month']+$databoard_data['pei_chart_non_eme_today'];

            $databoard_data['pei_chart_eme_today_till_month'] = $data[0]['eme_count_till_month']+$databoard_data['pei_chart_eme_today'] ;
            $databoard_data['pei_chart_total_today_till_month'] = $data[0]['count_till_month']+ $databoard_data['pei_chart_total_today'];     
            
            
            $this->load->view('erc_dashboard/CM' , ['data'=>$databoard_data]);
            $this->output->template = ('erc_blank');
            
        }else{
             dashboard_redirect($user_group,$this->base_url );
        }
    }
    
    function moneyFormatIndia($num) {
        $explrestunits = "" ;
        if(strlen($num)>3) {
            $lastthree = substr($num, strlen($num)-3, strlen($num));
            $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
            $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
            $expunit = str_split($restunits, 2);
            for($i=0; $i<sizeof($expunit); $i++) {
                // creates each of the 2's group and adds a comma to the end
                if($i==0) {
                    $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
                } else {
                    $explrestunits .= $expunit[$i].",";
                }
            }
            $thecash = $explrestunits.$lastthree;
        } else {
            $thecash = $num;
        }
        return $thecash; // writes the final format where $currency is the currency symbol.
    }
    function map_amb_all(){
        $args = array('base_month' => $this->post['base_month']);
        $data['amb_data'] = $this->amb_model->get_map_amb_data($args);
            $data['amb_data'] =  $data['amb_data'] ;
      
        $this->output->add_to_position($this->load->view('erc_dashboard/map_amb_all_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "amb_loc_map";
    }
    function map_amb_je(){
        $args = array('base_month' => $this->post['base_month'],'amb_type'=>'1');
        $data['amb_data'] = $this->amb_model->get_map_amb_data($args);
            $data['amb_data'] =  $data['amb_data'] ;
      
        $this->output->add_to_position($this->load->view('erc_dashboard/map_amb_je_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "amb_loc_map";
    }
    function map_amb_als(){
        $args = array('base_month' => $this->post['base_month'],'amb_type'=>'3');
        $data['amb_data'] = $this->amb_model->get_map_amb_data($args);
            $data['amb_data'] =  $data['amb_data'] ;
      
        $this->output->add_to_position($this->load->view('erc_dashboard/map_amb_als_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "amb_loc_map";
    }
    function map_amb_bls(){
        $args = array('base_month' => $this->post['base_month'],'amb_type'=>'2');
        $data['amb_data'] = $this->amb_model->get_map_amb_data($args);
            $data['amb_data'] =  $data['amb_data'] ;
      
        $this->output->add_to_position($this->load->view('erc_dashboard/map_amb_bls_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "amb_loc_map";
    }

    // public function (){
        
    //     $user_group=$this->clg->clg_group; 
    //     if ($user_group == 'UG-JAES-DASHBOARD') {
    //         $databoard_data = array();
    //         $data = $this->load->view('erc_dashboard/EMS' , ['data'=>$databoard_data]);
    //         $this->output->template = ('erc_blank');
    //         return $data;
    //     }

    // }

    public function EMS_dash()
	{	
        $user_group=$this->clg->clg_group;  
        if ($user_group == 'UG-JAES-DASHBOARD') {
            $data =array();
            $data = $this->Dashboard_model_final_updated->get_total_calls_frm_dashboard_tbl();
            $current_date = date('Y-m-d');
            $from_date = date('Y-m-d', strtotime($current_date)).' 00:00:00';
            $to_date = date('Y-m-d', strtotime($current_date)).' 23:59:59';

            $databoard_data = array();
            //echo "resourse Total<br>";
          //  $databoard_data['resourse_available'] = $this->Dashboard_model_final_updated->get_total_resourse_count();

            //echo "resourse Login Today<br>";
           // $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'));
           // $databoard_data['resourse_count'] = $this->Dashboard_model_final_updated->get_total_login_count($arg_month_date);
           //var_dump('hi');
            //echo "ERO free Login Status<br>";
            $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'),'call_status' => 'free');
            $databoard_data['ero_free'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_ero_login_count($arg_month_date));
            //echo "ERO On Call Login Status<br>";
            //var_dump('hi');
            $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'),'call_status' => 'atnd');
            $databoard_data['ero_atend'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_ero_login_count($arg_month_date));
            //echo "ERO Break Login Status<br>";
            $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'),'call_status' => 'break');
            $databoard_data['ero_break'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_ero_login_count($arg_month_date));
            
            //echo "total_count_today_date<br>";
            $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'));
            $databoard_data['count_today'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_call_count($arg_month_date));
            
            

            //Closure count Today
            $closure_report = array('to_date' => $to_date,'from_date' => $from_date,'system_type' => array('108','102'));
            $databoard_data['closure_today'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->Total_closure_data($closure_report,array('21','41','42','43','44')));
            
            // echo "eme_count_today_date<br>";
            $arg_till_date = array('date_type'=>'to','type'=>'eme','system_type' => array('108','102'));
            $databoard_data['eme_count_today_date']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_call_type($arg_till_date));
            
            //echo "noneme_count_today_date<br>";
            $arg_till_date = array('date_type'=>'to','type'=>'non-eme','system_type' => array('108','102'));
            $databoard_data['noneme_count_today_date']  = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_total_call_type($arg_till_date));
        
            //Total Ambulances
            $amb_all = array('system_type' => array('108','102'),'status' => 'all');
            $databoard_data['amb_total'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count($amb_all));
            
            $amb_available = array('system_type' => array('108','102'),'status' => '1');
            $databoard_data['amb_available'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count($amb_available));
            
            $amb_busy = array('system_type' => array('108','102'),'status' => '2');
            $databoard_data['amb_busy'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count($amb_busy));
            
            $amb_je = array('system_type' => array('108','102'),'type' => '1','amb_status' => array('1','2'));
            $databoard_data['amb_je'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count_typewise($amb_je));

            $amb_je = array('system_type' => array('108','102'),'type' =>'3','amb_status' => array('1','2'));
            $databoard_data['amb_als'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count_typewise($amb_je));

            $amb_je = array('system_type' => array('108','102'),'type' => '2','amb_status' => array('1','2'));
            $databoard_data['amb_bls'] = $this->moneyFormatIndia($this->Dashboard_model_final_updated->get_amb_count_typewise($amb_je));
            
         
            $databoard_data['count_till_date'] = $this->moneyFormatIndia($data[0]['count_till_date'] + 1526531 + $databoard_data['count_today']);
            $databoard_data['count_till_month'] = $this->moneyFormatIndia($data[0]['count_till_month'] + $databoard_data['count_today']);

            $databoard_data['eme_count_till_date'] = $this->moneyFormatIndia($data[0]['eme_count_till_date'] + 355526 + $databoard_data['eme_count_today_date']) ;
            $databoard_data['eme_count_till_month'] = $this->moneyFormatIndia($data[0]['eme_count_till_month'] + $databoard_data['eme_count_today_date']);

            $databoard_data['noneme_count_till_date'] = $this->moneyFormatIndia($data[0]['noneme_count_till_date'] + 1171005 + $databoard_data['noneme_count_today_date']);
            $databoard_data['noneme_count_till_month'] = $this->moneyFormatIndia($data[0]['noneme_count_till_month'] + $databoard_data['noneme_count_today_date']);
            
            $databoard_data['dispatch_till_date'] = $this->moneyFormatIndia($data[0]['eme_count_till_date'] + 355526 + $databoard_data['eme_count_today_date']) ;
            $databoard_data['dispatch_till_month'] = $this->moneyFormatIndia($data[0]['eme_count_till_month'] + $databoard_data['eme_count_today_date']);
            
            $databoard_data['closure_till_date'] = $this->moneyFormatIndia($data[0]['closure_till_date'] + $databoard_data['closure_today']) ;
            $databoard_data['closure_till_month'] = $this->moneyFormatIndia($data[0]['closure_till_month'] + $databoard_data['closure_today']) ;
            
            $dco_args = array('group' => 'UG-DCO');
            $databoard_data['dco_count'] = $this->Dashboard_model_final_updated->get_total_call_count6($dco_args);

            $databoard_data['pda_count'] = $this->Dashboard_model_final_updated->get_total_call_count6(array('group'=>'UG-PDA'));
            
            $databoard_data['ero_count'] = $this->Dashboard_model_final_updated->get_total_call_count6(array('group'=>'UG-ERO'));

            $databoard_data['ercp_count'] = $this->Dashboard_model_final_updated->get_total_call_count6(array('group'=>'UG-ERCP'));

            $databoard_data['grievance_count'] = $this->Dashboard_model_final_updated->get_total_call_count6(array('group'=>'UG-Grievance'));

            $databoard_data['feedback_count'] = $this->Dashboard_model_final_updated->get_total_call_count6(array('group'=>'UG-Feedback'));

            $databoard_data['quality_count'] = $this->Dashboard_model_final_updated->get_total_call_count6(array('group'=>'UG-Quality'));

            $databoard_data['dco_Tl_count'] = $this->Dashboard_model_final_updated->get_total_call_count6(array('group'=>'UG-DCOSupervisor'));

            $databoard_data['ero_Tl_count'] = $this->Dashboard_model_final_updated->get_total_call_count6(array('group'=>'UG-EROSupervisor'));

            $databoard_data['SM_count'] = $this->Dashboard_model_final_updated->get_total_call_count6(array('group'=>'UG-ShiftManager'));

            $databoard_data['ero104_count'] = $this->Dashboard_model_final_updated->get_total_call_count6(array('group'=>'UG-ERO-104'));
            
            $databoard_data['ercp_104_count'] = $this->Dashboard_model_final_updated->get_total_call_count6(array('group'=>'UG-ERCP-104'));

           
            $databoard_data['dispatch_till_date'] = $this->moneyFormatIndia($data[0]['eme_count_till_date'] + 355526 + $databoard_data['eme_count_today_date']) ;
            $databoard_data['dispatch_till_month'] = $this->moneyFormatIndia($data[0]['eme_count_till_month'] + $databoard_data['eme_count_today_date']) ;
          
          
            

            $this->load->view('erc_dashboard/EMS' , ['data'=>$databoard_data]);
            $this->output->template = ('calls_nhm');
        }else{
             dashboard_redirect($user_group,$this->base_url );
        }
    }
    public function centralized_dash(){
        $user_group=$this->clg->clg_group; 
        if ($user_group == 'UG-CENTERDASH') {
            $this->load->view('centralized_dashboard/centralized_dashboard' , ['data'=>$databoard_data]);
            $this->output->template = ('erc_blank');
        }
    }
}
