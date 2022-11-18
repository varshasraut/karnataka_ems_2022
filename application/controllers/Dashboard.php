<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends EMS_Controller {

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

    public function nhm()
	{	
        $data['district_names']=$this->Dashboard_model_final->get_districts_names();
        $data['nhm']=$this->Dashboard_model_final->get_nhm_data();
        //var_dump($data['nhm']); die;
		$this->load->view('templates/header_wtout_menu');
		$this->load->view('dashboard/nhm_dashboard1', ['data'=>$data]);
		$this->load->view('templates/footer');
		$this->output->template = ('blank');
    }

    public function dash()
	{	
        $data['district_names']=$this->Dashboard_model_final->get_districts_names1();
        $data['nhm']=$this->Dashboard_model_final->get_nhm_data();
       // var_dump($data); die;
		$this->load->view('templates/header_dash');
		$this->load->view('dashboard/Dashboard1', ['data'=>$data]);
		$this->load->view('templates/footer_dash');
		$this->output->template = ('blank');
    }

    public function nhm_data(){
        $data=$this->Dashboard_model_final->get_nhm_data();
         echo json_encode($data);

		die();
    }

    public function dash_data(){
        $data=$this->Dashboard_model_final->get_nhm_data();
        //var_dump($data); die;
        echo json_encode($data);

		die();
    }
    
    public function update_nhm_data()
    {
        //die();
        $data['district_names']=$this->Dashboard_model_final->get_districts_names();
        foreach($data['district_names'] as $result){
            $res['dispatch_today_108']= districtwise_dispatches($result->dst_code, 'today', '108');
            $current_date = date('Y-m-d');
            $closure_date_to = date('Y-m-d', strtotime($current_date)).' 23:59:59';
            $res['patient_served_today']= districtwise_emergency_patients_served($result->dst_code, 'today', '108',$closure_date_to);
            $res['patient_served_tm']= districtwise_emergency_patients_served($result->dst_code, 'thismonth', '108',$closure_date_to); 
            $res['patient_served_td']= districtwise_emergency_patients_served($result->dst_code, 'tillDate', '108',$closure_date_to); 
            $res['patient_servedold1_td']= districtwise_emergency_patients_served($result->dst_code, 'tillDate_old1', '108',$closure_date_to); 
            $this->Dashboard_model_final->update_nhm_data($result->dst_code, $res);
        }
        $data['amb_no']=$this->Dashboard_model_final->get_amb_data();
        $res_new= array();
        foreach($data['amb_no'] as $result){
            $res_new['patient_served_today'] = ambwise_emergency_patients($result->amb_rto_register_no,'today', "108");
            $res_new['patient_served_tm'] = ambwise_emergency_patients($result->amb_rto_register_no,'thismonth', "108");
            $res_new['patient_served_td'] = ambwise_emergency_patients($result->amb_rto_register_no,'tillDate', "108");
            $res_new['patient_servedold1_td']= ambwise_emergency_patients($result->amb_rto_register_no,'tillDate_old1','108'); 
            $this->Dashboard_model_final->update_amb_nhm_data($result->amb_rto_register_no, $res_new);
        }
		die();
    }
    public function graph()
	{	
		$this->load->view('templates/header');
		$this->load->view('dashboard/graph_view');
		$this->load->view('templates/footer');
		$this->output->template = ('blank');
    }

	   function logout() {

        $this->session->unset_userdata('current_user');

        $this->session->unset_userdata('user_logged_in');

        redirect(base_url()."clg/login");
    }
    
    public function live_calls()
    {	
        $data['emps_td'] = $this->Dashboard_model_final->get_total_calls_emps_td();
        $data['emps_tm'] = $this->Dashboard_model_final->get_total_calls_emps_tm();
        $data['emps_to'] = $this->Dashboard_model_final->get_total_calls_emps_to();
        $this->load->view('templates/header');
        $this->load->view('dashboard/dispatch_report', $data);
        $this->load->view('templates/footer');
        $this->output->template = ('blank');
    	
    }
    public function live_calls_dash()
    {	
        $data['emps_td'] = $this->Dashboard_model_final->get_total_calls_emps_td();
        $data['emps_tm'] = $this->Dashboard_model_final->get_total_calls_emps_tm();
        $data['emps_to'] = $this->Dashboard_model_final->get_total_calls_emps_to();
        $this->load->view('templates/header_dash');
        $this->load->view('dashboard/live_call_view1', $data);
        $this->load->view('templates/footer_dash');
        $this->output->template = ('blank');
    	
    }
    public function test_dashboard(){
        $this->load->view('templates/header');
        $this->load->view('dashboard/test_dashboard_tdd1');
        $this->load->view('templates/footer');
        $this->output->template = ('blank');
    }   
    public function ambulance_reponse_time(){
        $this->load->view('templates/header');
        $this->load->view('dashboard/response_time');
        $this->load->view('templates/footer');
        $this->output->template = ('blank');
    }   
    public function date_report()
{
        $from=$this->input->post('from');
        $to=$this->input->post('to');
        $data['emmergency_calls'] = $this->Dashboard_model_final->date_reports_eme_calls($from,$to);
        $data['emmergency_patients'] = $this->Dashboard_model_final->date_reports_eme_patients($from,$to);
        echo json_encode($data);
    exit;
    }
    public function type_of_emergency_served()
    {	
    	$data['compalint_type']=$this->Dashboard_model_final->get_complaint_types();
    	$data['accident_names']=$this->Dashboard_model_final->get_accident_names();
    	$data['attack']=$this->Dashboard_model_final->attack();
    	$data['burn']=$this->Dashboard_model_final->burn();
    	$data['cardiac']=$this->Dashboard_model_final->cardiac();
    	$data['fall']=$this->Dashboard_model_final->fall();
    	$data['poisoning']=$this->Dashboard_model_final->poisoning();
    	$data['pregnancy']=$this->Dashboard_model_final->pregnancy();
        $data['child_birth']=$this->Dashboard_model_final->child_birth();
    	$data['mass_casualty']=$this->Dashboard_model_final->mass_casualty();
    	$data['trauma']=$this->Dashboard_model_final->trauma();
    	$data['medical']=$this->Dashboard_model_final->medical();
    	$data['other']=$this->Dashboard_model_final->other();
        $this->load->view('templates/header');
        $this->load->view('dashboard/type_of_emergency_served', ['data'=>$data]);
        $this->load->view('templates/footer');
        $this->output->template = ('blank');
    	return json_encode($data);

    }

    public function type_of_emergency_served_dash()
    {	
    	$data['compalint_type']=$this->Dashboard_model_final->get_complaint_types();
    	$data['accident_names']=$this->Dashboard_model_final->get_accident_names();
    	$data['attack']=$this->Dashboard_model_final->attack();
    	$data['burn']=$this->Dashboard_model_final->burn();
    	$data['cardiac']=$this->Dashboard_model_final->cardiac();
    	$data['fall']=$this->Dashboard_model_final->fall();
    	$data['poisoning']=$this->Dashboard_model_final->poisoning();
    	$data['pregnancy']=$this->Dashboard_model_final->pregnancy();
        $data['child_birth']=$this->Dashboard_model_final->child_birth();
    	$data['mass_casualty']=$this->Dashboard_model_final->mass_casualty();
    	$data['trauma']=$this->Dashboard_model_final->trauma();
    	$data['medical']=$this->Dashboard_model_final->medical();
    	$data['other']=$this->Dashboard_model_final->other();
        $this->load->view('templates/header_dash');
        $this->load->view('dashboard/type_of_em_patient_served_view', ['data'=>$data]);
        $this->load->view('templates/footer_dash');
        $this->output->template = ('blank');
    	return json_encode($data);

    }
    public function districtwise_emergency_patients_served()
    {   
        $data['district_names']=$this->Dashboard_model_final->get_districts_names();
        $this->load->view('templates/header');
        $this->load->view('dashboard/districtwise_emergency_patients_served', ['data'=>$data]);
        $this->load->view('templates/footer');
        $this->output->template = ('blank');
    }
    public function districtwise_emergency_patients_served_dash()
    {   
        $data['state_names']=$this->Dashboard_model_final->get_state_names();
        $data['district_names']=$this->Dashboard_model_final->get_districts_names($div="");
        $data['district_jammu']=$this->Dashboard_model_final->get_districts_names($div="1");
        $data['district_kashmir']=$this->Dashboard_model_final->get_districts_names($div="2");
        $data['district_leh']=$this->Dashboard_model_final->get_districts_names($div="3");
        $data['div_names'] = $this->Dashboard_model_final->get_division_names();
        foreach($data['district_names'] as $amb){
        $args = array('amb_district'=> $amb->dst_code);
        
    
        $data['amb_names'][$amb->dst_code] = $this->Dashboard_model_final->get_ambulance($args);
        
        }
        //var_dump($data['amb_names']); die;

        
        $this->load->view('templates/header_dash');
        $this->load->view('dashboard/dist_patient_served_view', ['data'=>$data]);
        $this->load->view('templates/footer_dash');
        $this->output->template = ('blank');
    }
    public function total_distance_travelled_by_ambulance()
    {
        $data['district_names']=$this->Dashboard_model_final->get_districts_names();
        $this->load->view('templates/header');
        $this->load->view('dashboard/total_distance_travelled_ambulance', ['data'=>$data]);
        $this->load->view('templates/footer');
        $this->output->template = ('blank');
    }
    public function total_distance_travelled_by_ambulance_dash()
    {
        $data['district_names']=$this->Dashboard_model_final->get_districts_names1();
        $this->load->view('templates/header_dash');
        $this->load->view('dashboard/total_dist_travel_view', ['data'=>$data]);
        $this->load->view('templates/footer_dash');
        $this->output->template = ('blank');
    }
	public function view()
	{	
    
        
            $data =array();
            $dashboard_count = $this->Dashboard_model_final->get_total_calls_frm_dashboard_tbl();
            $today_calls = $this->Dashboard_model_final->get_total_calls_today();
            
            $to_date = date('Y-m-d').' 23:59:59';
            $from_date = date('Y-m-d').' 00:00:00';
            
            $arg_today_eme = array('date_type'=>'tm','to_date'=>$to_date,'from_date'=>$from_date,'type'=>'eme');
            $today_eme = $this->Dashboard_model_final->get_total_call_type($arg_today_eme);
            
            $arg_today_noneme = array('date_type'=>'tm','to_date'=>$to_date,'from_date'=>$from_date,'type'=>'non-eme');
            $today_non_eme = $this->Dashboard_model_final->get_total_call_type($arg_today_noneme);
        
            $closure_today = $this->Dashboard_model_final->get_total_closed_calls_today();
            
            $data['total_calls_td']  = $dashboard_count[0]['count_till_date']+$today_calls+22241019;
            $data['total_calls_tm'] = $dashboard_count[0]['count_till_month']+$today_calls;
            $data['total_calls_to_108']=$today_calls;
            
            $data['eme_calls_td'] = $dashboard_count[0]['eme_count_till_date']+$today_eme+3602556;
            $data['eme_calls_tm'] = $dashboard_count[0]['eme_count_till_month']+$today_eme;
            
            $data['non_eme_td'] = $dashboard_count[0]['noneme_count_till_date']+$today_non_eme+18638463;
            $data['non_eme_tm'] = $dashboard_count[0]['noneme_count_till_month']+$today_non_eme;
            $data['non_eme_to'] = $today_non_eme;
            
            $data['eme_calls_td'] = $dashboard_count[0]['eme_count_till_date']+$today_calls+3602556;
            $data['eme_calls_tm'] = $dashboard_count[0]['eme_count_till_month']+$today_eme;
            $data['eme_calls_to']= $today_eme;
            
            $data['total_dispatch_all'] =  $data['eme_calls_td'];
            $data['total_dispatch_tm'] =  $data['eme_calls_tm'];

            $data['total_calls_emps_td'] = $dashboard_count[0]['closure_till_date']+$closure_today+6176511;
            $data['total_calls_emps_tm'] = $dashboard_count[0]['closure_till_month']+$closure_today;
            
            $Accident_data_tm = $this->Dashboard_model_final->get_b12_report_tm('Accident_Vehicle');
            $assault_data_tm = $this->Dashboard_model_final->get_b12_report_tm('Assault');
            $burn_data_tm = $this->Dashboard_model_final->get_b12_report_tm('Burns');
            $attack_data_tm = $this->Dashboard_model_final->get_b12_report_tm('Cardiac');
            $fall_data_tm = $this->Dashboard_model_final->get_b12_report_tm('Fall');
            $poision_data_tm = $this->Dashboard_model_final->get_b12_report_tm('Intoxication_Poisoning');
            $labour_data_tm = $this->Dashboard_model_final->get_b12_report_tm('Labour_Pregnancy');
            $light_data_tm = $this->Dashboard_model_final->get_b12_report_tm('Lighting_Electrocution');
            $mass_data_tm = $this->Dashboard_model_final->get_b12_report_tm('Mass_casualty');
            $report_data_tm = $this->Dashboard_model_final->get_b12_report_tm('Medical');
            $trauma_data_tm = $this->Dashboard_model_final->get_b12_report_tm('Poly_Trauma');
            $suicide_data_tm = $this->Dashboard_model_final->get_b12_report_tm('Suicide_Self_Inflicted_Injury');
            $delivery_in_amb_data_tm= $this->Dashboard_model_final->get_b12_report_tm('Deliveries_in_Ambulance');
            $pt_manage_on_veti_data_tm = $this->Dashboard_model_final->get_b12_report_tm('Patient_Manage_on_Ventilator');
            $unavail_call_data_tm = $this->Dashboard_model_final->get_b12_report_tm('Unavailed_Call');
            $other_data_tm= $this->Dashboard_model_final->get_b12_report_tm('Others');

            $Accident_data_td = $this->Dashboard_model_final->get_b12_report('Accident_Vehicle')+424982;
            $assault_data_td = $this->Dashboard_model_final->get_b12_report('Assault')+61567;
            $burn_data_td = $this->Dashboard_model_final->get_b12_report('Burns')+23024;
            $attack_data_td = $this->Dashboard_model_final->get_b12_report('Cardiac')+13431;
            $fall_data_td = $this->Dashboard_model_final->get_b12_report('Fall')+138025;
            $poision_data_td = $this->Dashboard_model_final->get_b12_report('Intoxication_Poisoning')+165926;
            $labour_data_td = $this->Dashboard_model_final->get_b12_report('Labour_Pregnancy')+1216628;
            $light_data_td = $this->Dashboard_model_final->get_b12_report('Lighting_Electrocution')+5872;
            $mass_data_td = $this->Dashboard_model_final->get_b12_report('Mass_casualty')+22952;
            $report_data_td = $this->Dashboard_model_final->get_b12_report('Medical')+3346572;
            $trauma_data_td = $this->Dashboard_model_final->get_b12_report('Poly_Trauma')+8601;
            $suicide_data_td = $this->Dashboard_model_final->get_b12_report('Suicide_Self_Inflicted_Injury')+5065;
            $delivery_in_amb_data_td= $this->Dashboard_model_final->get_b12_report('Deliveries_in_Ambulance')+36647;
            $pt_manage_on_veti_data_td = $this->Dashboard_model_final->get_b12_report('Patient_Manage_on_Ventilator')+3755;
            $unavail_call_data_td = $this->Dashboard_model_final->get_b12_report('Unavailed_Call');
            $other_data_td= $this->Dashboard_model_final->get_b12_report('Others')+742866;
            //$data['total_closure_tm'] = $Accident_data_tm + $assault_data_tm + $burn_data_tm + $attack_data_tm + $fall_data_tm + $poision_data_tm + $labour_data_tm + $light_data_tm + $mass_data_tm + $report_data_tm + $other_data_tm + $trauma_data_tm + $suicide_data_tm;
            //  $data['total_closure_td'] = $Accident_data_td + $assault_data_td + $burn_data_td + $attack_data_td + $fall_data_td + $poision_data_td + $labour_data_td + $light_data_td + $mass_data_td + $report_data_td + $other_data_td + $trauma_data_td + $suicide_data_td + 74;
            $data['total_closure_td']=7302199;
            $data['total_closure_tm']=75970;
            //$data['total_closure_td'] = $dashboard_count[0]['closure_till_date']+$closure_today+6176511;
            //$data['total_closure_tm'] = $dashboard_count[0]['closure_till_month']+$closure_today;
            
            $data['agents_available'] = $this->Dashboard_model_final->get_agents_available();
            $data['agents_available_108'] = $this->Dashboard_model_final->get_agents_available_108($cond='108');
            $data['agents_available_102'] = $this->Dashboard_model_final->get_agents_available_102($cond='102');
             $data['available_agents'] = $this->Dashboard_model_final->get_agent_status($cond="avail");
            $data['oncall_agents'] = $this->Dashboard_model_final->get_agent_status($cond="oncall");
            $data['break_agents'] = $this->Dashboard_model_final->get_agent_status($cond="break");

             $data['all_amb'] = $this->Dashboard_model_final->get_amb_all_status($cond="all");
             $data['all_amb'] = 937;
            $data['busy_amb'] = $this->Dashboard_model_final->get_amb_all_status($cond="busy");
            $data['avail_amb'] = $this->Dashboard_model_final->get_amb_all_status($cond="avail");
      
		echo json_encode($data);
        exit;

	}
	public function chartdata()
	{	
		//$data['chart'] = $this->Dashboard_model_final->get_data();//->result();
		//echo json_encode($data);
		die();
        
	}
	function all_amb() {

        $args = array('base_month' => $this->post['base_month']);

        $data['amb_data'] = $this->amb_model->get_gps_amb_data($args);
       
        
         $this->load->view('templates/header');
         $this->load->view('dashboard/amb_view', $data);
         $this->load->view('templates/footer');
         $this->output->template = ('blank');
        //die;
    }
    function get_performer(){
        $this->load->view('templates/header');
        $this->load->view('dashboard/performer_view');
        $this->load->view('templates/footer');
        $this->output->template = ('blank');

    }
    function get_performer_tl(){
        $this->load->view('templates/header');
        $this->load->view('dashboard/performer_view_tl');
        $this->load->view('templates/footer');
        $this->output->template = ('blank');

    }
    function get_performer_bike(){
        $this->load->view('templates/header');
        $this->load->view('dashboard/performer_viewbike');
        $this->load->view('templates/footer');
        $this->output->template = ('blank');

    }
    function get_performer_pda(){
        $this->load->view('templates/header');
        $this->load->view('dashboard/performer_viewpda');
        $this->load->view('templates/footer');
        $this->output->template = ('blank');

    }
    
    function all_amb_dash() {

        $args = array('base_month' => $this->post['base_month']);

        $data['amb_data'] = $this->amb_model->get_gps_amb_data($args);
         $this->load->view('templates/header_dash');
         $this->load->view('dashboard/amb_view', $data);
         $this->load->view('templates/footer_dash');
         $this->output->template = ('blank');
        //die;
    }
    // function all_dash_amb() {

    //     $args = array('base_month' => $this->post['base_month']);

    //     $data['amb_data'] = $this->amb_model->get_gps_amb_data($args);
    //     $this->load->view('templates/header');
    //     $this->load->view('frontend/amb/all_amb_loc_view', $data);
    //     $this->load->view('templates/footer');
    //     $this->output->template = ('blank');
    //     //die();
        
    // }
//     function all() {

//         $args = array('base_month' => $this->post['base_month']);

        
//         $data['amb_data'] = $this->amb_model->get_gps_amb_data($args);

// //This code for show all ambulance some of them not having incident
        
//         $data['amb_data'] = array();
//         $tdd_amb = $this->amb_model->get_tdd_amb();
        
       
       
//             foreach( $tdd_amb as $amb){
//                 $args = array('amb_rto_register'=>$tdd->amb_rto_register_no);
//                 $amb_data = $this->amb_model->get_gps_amb_data($args);
               
//                 if($amb_data){
//                     $amb_result = $amb_data;
//                 }else{
//                     $amb_result = $amb;
//                 }
                
//             }
//             $data['amb_data'] = $amb_result;
//             //$this->load->view('templates/header');
//             $this->output->add_to_position($this->load->view('frontend/amb/all_amb_loc_view', $data, TRUE), 'content', TRUE);
//             //$this->load->view('frontend/amb/all_amb_loc_view', $data);
            
//             //$this->load->view('templates/footer');
//             $this->output->template = "amb_loc_map_for_dashboard";
//             //$this->output->template = "blank";

//     }
    function all_login_agents() {
       // $data = $this->Dashboard_model_final->get_agents_available_list($grp="");
        //print_r($data); die;
        $this->load->view('templates/header');
        $this->load->view('dashboard/current_login_agents_view', ['data'=>$data]);
        $this->load->view('templates/footer');
        $this->output->template = ('blank');

    }
    function ambulance_status_realtime()
    {
       
        $data['amb_data'] = $this->common_model->get_district_wise_offroad();
        $this->output->add_to_position($this->load->view('dashboard/amb_realtime_status', $data, TRUE), 'content', TRUE);
        $this->output->template = "nhm_blank";
    }


    function realtime_offroad_status(){
        $data['amb_data'] = $this->common_model->get_realtime_offroad();
        $this->output->add_to_position($this->load->view('dashboard/amb_realtime_offroad', $data, TRUE), 'content', TRUE);
        $this->output->template = "nhm_blank";
    }
    function ambulance_status(){
        $current_date = date('Y-m-d');
        $data['current_date']=$current_date;
        $select_time = get_current_select_time(date('H'));
         
        $data['select_time_name'] = get_current_select_name($select_time);
       
        
        
        $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),'select_time'=>$select_time );
        $data['amb_data'] = $this->common_model->get_district_wise_offroad($report_args);
        if(empty($data['amb_data'])){
            
           $data['amb_data'] = $this->common_model->get_district_wise_offroad_last();
           
            
        //$data['current_date']=date('Y-m-d', strtotime('-1 day', strtotime($current_date)));
        //$report_args = array('from_date'=>date('Y-m-d', strtotime('-1 day', strtotime($current_date))),'select_time'=>$select_time);
        
       // $data['amb_data'] = $this->common_model->get_district_wise_offroad($report_args);
        }


     $this->output->add_to_position($this->load->view('dashboard/ambulance_status_report_view', $data, TRUE), 'content', TRUE);
      $this->output->template = "nhm_blank"; 
  }
  function ambulance_status_date(){
    $from_date =  date('Y-m-d',strtotime($this->input->post('select_date')));
    $select_time =  $this->input->post('select_time');
    $data['current_date']=$from_date;
    $data['select_time_name']=get_current_select_name($select_time);
    $report_args = array('from_date' => $from_date, 'select_time'=>$select_time);
    $data['report_args'] = $this->input->post();
    $data['amb_data'] = $this->common_model->get_district_wise_offroad($report_args);
    $this->output->add_to_position($this->load->view('dashboard/ambulance_status_report_view', $data, TRUE), 'filter_date_view', TRUE);
    $this->output->template = "nhm_blank"; 
}  
function dashboard_data_datewise(){
    $from_date =  date('Y-m-d',strtotime($this->input->post('select_date')));
    $from_date1 =  date('d-m-Y',strtotime($this->input->post('select_date')));
    $data['current_date']=$from_date1;
    $report_args = array('from_date' => $from_date ,'select_time'=>'1');
    $data['dash_data'] = $this->common_model->get_main_dash_data($report_args);
// var_dump($dash_data->count_till_date);die();
   // var_dump($data['dash_data']);
   $data['total'] = 937;
   $data['time'] = '10:00 AM';
   $data['on_data'] = $this->common_model->get_onroad_count($report_args);
   $data['off_data'] = $this->common_model->get_offroad_count($report_args);
//var_dump($on_data['count']);
    // $this->output->add_to_position($this->load->view('dashboard/dashboard_report_view', $data, TRUE)) ;
    $this->output->add_to_position($this->load->view('dashboard/dashboard_report_view', $data, TRUE), 'report_data_view_details', TRUE);
    $this->output->template = "nhm_blank"; 
    
}
function dashboard_data_datewise_view(){
        $from_date =  date('Y-m-d',strtotime($this->input->post('select_date')));
    $from_date1 =  date('d-m-Y',strtotime($this->input->post('select_date')));
    $data['current_date']=$from_date1;
    $report_args = array('from_date' => $from_date,'select_time'=>'1' );
    $data['dash_data'] = $this->common_model->get_main_dash_data($report_args);
// var_dump($dash_data->count_till_date);die();
   // var_dump($data['dash_data']);
   $data['total'] = 937;
   $data['time'] = '10:00 AM';
   $data['on_data'] = $this->common_model->get_onroad_count($report_args);
   $data['off_data'] = $this->common_model->get_offroad_count($report_args);
//var_dump($on_data['count']);
    // $this->output->add_to_position($this->load->view('dashboard/dashboard_report_view', $data, TRUE)) ;
    $this->output->add_to_position($this->load->view('dashboard/dashboard_data_report_view', $data, TRUE), 'report_data_view_details', TRUE);
    $this->output->template = "nhm_blank"; 
}
function ambulance_status_popup_datefilter(){
    $from_date =  date('Y-m-d',strtotime($this->input->post('select_date')));
    $data['current_date']=$from_date;
    $report_args = array('from_date' => $from_date );
    if($this->input->post('select_time') != ''){
        $report_args['select_time']=$this->input->post('select_time');
    }
     $report_args['select_time']=$this->input->post('select_time');
     $report_args['select_date']=$from_date;
    $data['report_args'] = $report_args;
        $data['select_time_name'] = get_current_select_name($report_args['select_time']);
    $data['amb_data'] = $this->common_model->get_offroad_details($report_args);
    $this->output->add_to_position($this->load->view('dashboard/ambulance_status_report_view_popup', $data, TRUE), 'content', TRUE);
    $this->output->template = "nhm_blank"; 
}  
  function ambulance_status_popup(){
    $current_date = date('Y-m-d');
    $select_time = get_current_select_time(date('H'));
    $data['select_time_name'] = get_current_select_name($select_time);
        
        $data['current_date']=$current_date;
        $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)) ,'select_time'=>$select_time);
        $data['amb_data'] = $this->common_model->get_offroad_details($report_args);
        if(empty($data['amb_data'])){
        $data['current_date']=date('Y-m-d', strtotime('-1 day', strtotime($current_date)));
        $report_args = array('from_date'=>date('Y-m-d', strtotime('-1 day', strtotime($current_date))),'select_time'=>$select_time);
        $data['amb_data'] = $this->common_model->get_offroad_details($report_args);
        }
   // $data['amb_data'] = $this->common_model->get_offroad_details();
          $report_args1 = array('select_date' => date('Y-m-d', strtotime($current_date)),'select_time'=>$select_time );
        $data['report_args']=$report_args1;

   $this->output->add_to_position($this->load->view('dashboard/ambulance_status_report_view_popup', $data, TRUE), 'content', TRUE);
   $this->output->template = "nhm_blank"; 
}
function ambulance_onroad_popup_datefilter(){
    $from_date =  date('Y-m-d',strtotime($this->input->post('select_date')));
    $data['current_date']=$from_date;
    $select_time =  $this->input->post('select_time');
    $report_args = array('from_date' => $from_date, 'select_time'=>$select_time );
    $data['amb_data'] = $this->common_model->get_onroad_details($report_args);
    $data['report_args'] = $this->input->post();
    
    $report_args1 = array('select_date' => date('Y-m-d', strtotime($current_date)),'select_time'=>$select_time );
    $data['select_time_name'] = get_current_select_name($select_time);
        $data['report_args']=$report_args1;
    
    $this->output->add_to_position($this->load->view('dashboard/ambulance_status_onroad_view_popup', $data, TRUE), 'content', TRUE);
    $this->output->template = "nhm_blank"; 
}
function ambulance_onroad_popup(){
        $current_date = date('Y-m-d');
        $data['current_date']=$current_date;
        $select_time = get_current_select_time(date('H'));
         
        $data['select_time_name'] = get_current_select_name($select_time);
        $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),'select_time'=>$select_time );
        $data['amb_data'] = $this->common_model->get_onroad_details($report_args);
        if(empty($data['amb_data'])){
        $data['current_date']=date('Y-m-d', strtotime('-1 day', strtotime($current_date)));
        $report_args = array('from_date'=>date('Y-m-d', strtotime('-1 day', strtotime($current_date))),'select_time'=>$select_time);
        $data['amb_data'] = $this->common_model->get_onroad_details($report_args);
        }
    //$data['amb_data'] = $this->common_model->get_onroad_details();
        $report_args1 = array('select_date' => date('Y-m-d', strtotime($current_date)),'select_time'=>$select_time );
        $data['report_args']=$report_args1;

   $this->output->add_to_position($this->load->view('dashboard/ambulance_status_onroad_view_popup', $data, TRUE), 'content', TRUE);
  $this->output->template = "nhm_blank"; 
}

function ambulance_nonnetwork_popup(){
   
        $data['amb_data'] = $this->common_model->get_nonnetwork_details();
    //$data['amb_data'] = $this->common_model->get_onroad_details();

   $this->output->add_to_position($this->load->view('dashboard/non_network_amb_view', $data, TRUE), 'content', TRUE);
  $this->output->template = "nhm_blank"; 
}
function biomedical_popup(){

    $data['amb_data'] = $this->common_model->get_biodata_critical();
   $this->output->add_to_position($this->load->view('frontend/dash/biomedical_view_popup', $data, TRUE), 'content', TRUE);
  $this->output->template = "nhm_blank"; 
}
function biomedical_major_popup(){

    $data['amb_data'] = $this->common_model->get_biodata_major();
   $this->output->add_to_position($this->load->view('frontend/dash/biomedical_data_major_view', $data, TRUE), 'content', TRUE);
  $this->output->template = "nhm_blank"; 
}
function biomedical_minor_popup(){

    $data['amb_data'] = $this->common_model->get_biodata_minor();
   $this->output->add_to_position($this->load->view('frontend/dash/biomedical_data_minor_view', $data, TRUE), 'content', TRUE);
  $this->output->template = "nhm_blank"; 
}
  function B12_datatype(){
    $data['B12_data'] = $this->common_model->get_B12_data();

    $this->output->add_to_position($this->load->view('dashboard/B12_data_report_view', $data, TRUE), 'content', TRUE);
    $this->output->template = "nhm_blank"; 
}
    public function update_total_count_for_cron(){
        die();
        $args['from_date'] = '2019-11-12 11:45:34';
        $args['live_from_date'] = '2020-03-23 23:59:59';
        $args['to_date'] = date('Y-m-d', strtotime('last day of previous month')).' 23:59:59';
      
        
        
        $args_108['from_date'] = '2019-11-12 11:45:34';
        $args_108['live_from_date'] = '2020-03-23 23:59:59';
        $args_108['to_date'] = date('Y-m-d', strtotime('last day of previous month')).' 23:59:59';
        $args_108['system_type'] = '108';
        
        $result['count_till_date'] = $this->Dashboard_model_final->count_till_date($args);
       //$result['count_till_date_102'] = $this->Dashboard_model_final->count_till_date($args_102);
        $result['eme_count_till_date'] = $this->Dashboard_model_final->eme_count_till_date($args);
       // $result['eme_count_till_date_102'] = $this->Dashboard_model_final->eme_count_till_date($args_102);
        $result['noneme_count_till_date'] = $this->Dashboard_model_final->noneme_count_till_date($args);
       // $result['noneme_count_till_date_102'] = $this->Dashboard_model_final->noneme_count_till_date($args_102);
        $result['dispatch_till_date'] = $this->Dashboard_model_final->dispatch_till_date($args);
        //$result['dispatch_till_date_102'] = $this->Dashboard_model_final->dispatch_till_date($args_102);
        $result['closure_till_date'] = $this->Dashboard_model_final->closure_till_date($args);
       //  $result['closure_till_date_102'] = $this->Dashboard_model_final->closure_till_date($args_102);
         
         
        $result['count_till_date_108'] = $this->Dashboard_model_final->count_till_date($args_108);
        $result['eme_count_till_date_108'] = $this->Dashboard_model_final->eme_count_till_date($args_108);
        $result['noneme_count_till_date_108'] = $this->Dashboard_model_final->noneme_count_till_date($args_108);
        $result['dispatch_till_date_108'] = $this->Dashboard_model_final->dispatch_till_date($args_108);
        $result['closure_till_date_108'] = $this->Dashboard_model_final->closure_till_date($args_108);
        
        
        $result['from_date'] = $args['from_date'];
        $result['live_from_date'] = $args['live_from_date'];
        $result['to_date'] = $args['to_date'];
        $rec_id='1';
        //var_dump($result); die;
        $this->Dashboard_model_final->update_data($rec_id, $result);
        }

        function nhm_dashboard(){
            $user_group=$this->clg->clg_group;  
            if ( $user_group == 'UG-DASHBOARD-NHM' || $user_group == 'UG-NHM-DASH' ) {
            $header = array('Type of Emergency',
        'Today',
        'Till Date',
        
    );
    $start_date = '2020-03-24' ;
   $today_date =  date("Y/m/d");
   $report_args1 = array('from_date' => date('Y-m-d', strtotime($today_date)),
                'to_date' => date('Y-m-t', strtotime($today_date))
            );
            $report_args2 = array('from_date' => date('Y-m-d', strtotime($start_date)),
            'to_date' => date('Y-m-t', strtotime($today_date))
        );
   // 2020-06-01
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

       $report_data_till = $this->inc_model->get_medical_b12_report($report_args2);
       $other_data_till = $this->inc_model->get_other_b12_report($report_args2);
       $assault_data_till = $this->inc_model->get_assault_b12_report($report_args2);
       $labour_data_till = $this->inc_model->get_labour_b12_report($report_args2);
       $poision_data_till = $this->inc_model->get_poision_b12_report($report_args2);
       $trauma_data_till = $this->inc_model->get_trauma_b12_report($report_args2);
       $traumanon_data_till = $this->inc_model->get_traumanon_b12_report($report_args2);
       $attack_data_till = $this->inc_model->get_attack_b12_report($report_args2);
       $suicide_data_till = $this->inc_model->get_suicide_b12_report($report_args2);
       $burn_data_till = $this->inc_model->get_burn_b12_report($report_args2);
       $mass_data_till = $this->inc_model->get_mass_b12_report($report_args2);
       $light_data_till = $this->inc_model->get_light_b12_report($report_args2);


       $inc_data[]=array(
                        'medical' => $report_data[0]->total_count,
                        'other' => $other_data[0]->total_count,
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

                        'medical_till' => $report_data_till[0]->total_count,
                        'other_till' => $other_data_till[0]->total_count,
                        'assault_till' => $assault_data_till[0]->total_count,
                        'labour_till' => $labour_data_till[0]->total_count,
                        'trauma_till' => $trauma_data_till[0]->total_count,
                        'traumanon_till' => $traumanon_data_till[0]->total_count,
                        'suicide_till' => $suicide_data_till[0]->total_count,
                        'burn_till' => $burn_data_till[0]->total_count,
                        'mass_till' => $mass_data_till[0]->total_count,
                        'light_till' => $light_data_till[0]->total_count,
                        'poision_till' => $poision_data_till[0]->total_count,
                        'attack_till' => $attack_data_till[0]->total_count,

                        );
        $data['header'] = $header;
        $data['inc_data'] = $inc_data;
        $data['amb_data'] = $this->amb_model->get_gps_amb_data($args);
        $this->output->add_to_position($this->load->view('frontend/dash/NHM_dashboard', $data, TRUE), 'content', TRUE);
        $this->output->template = "calls_nhm";
        }else{
              dashboard_redirect($user_group,$this->base_url );
        }
        }
        function nhm_dashboard_view_new(){
            $user_group = $this->clg->clg_group;
        
            if ( $user_group == 'UG-Dashboard-view') {
            $data['clg_group'] = $this->clg->clg_group;
            $thirdparty = $this->clg->thirdparty;
            $amb_arg = array('thirdparty' => $thirdparty,'district_id'=> '518');
            $data['amb_data'] = $this->amb_model->get_nhm_amb_data($amb_arg);
            // $data['total_mdt'] = count($this->amb_model->get_total_mdt()); 
           // var_dump(  $data['total_mdt']);die();

            $data['dist'] = $this->common_model->get_district(array('st_id' => 'MP'));
            $data['visitors_count'] = $this->Dashboard_model_final->get_visitors_data();
            // $data['visitors_count_mb'] = $this->Dashboard_model_final->get_visitors_data();

            $current_date = date('Y-m-d');
            $data['current_date']=$current_date;
            $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),'district_name'=>'total' );
            $data['total_amb_data'] = $this->common_model->get_district_wise_offroad_mapcount($report_args);
            if(empty($data['total_amb_data'])){
            $data['current_date']=date('Y-m-d', strtotime('-1 day', strtotime($current_date)));
            $report_args = array('from_date'=>date('Y-m-d', strtotime('-1 day', strtotime($current_date))),'district_name'=>'total');
            $data['total_amb_data'] = $this->common_model->get_district_wise_offroad_mapcount($report_args);
            }
            $this->output->add_to_position($this->load->view('frontend/dash/NHM_dashboard_view', $data, TRUE), 'content', TRUE);
            $this->output->template = "calls_nhm";
            }else{
                 dashboard_redirect($user_group,$this->base_url );
            }
        }
        function nhm_dashboard_view(){

            
            $data =array();
            $dashboard_count = $this->Dashboard_model_final->get_total_calls_frm_dashboard_tbl();
            $today_calls = $this->Dashboard_model_final->get_total_calls_today();
            
            $to_date = date('Y-m-d').' 23:59:59';
            $from_date = date('Y-m-d').' 00:00:00';
            
            $arg_today_eme = array('date_type'=>'tm','to_date'=>$to_date,'from_date'=>$from_date,'type'=>'eme');
            $today_eme = $this->Dashboard_model_final->get_total_call_type($arg_today_eme);
            
            
            $arg_today_noneme = array('date_type'=>'tm','to_date'=>$to_date,'from_date'=>$from_date,'type'=>'non-eme');
            $today_non_eme = $this->Dashboard_model_final->get_total_call_type($arg_today_noneme);
            
      
            $closure_today = $this->Dashboard_model_final->get_total_validated_closed_calls_today();
            

            //$data['total_calls_td'] = $dashboard_count[0]['eme_count_till_date']+$dashboard_count[0]['noneme_count_till_date']+$today_calls+22241019;
            $data['total_calls_tm'] = $dashboard_count[0]['count_till_month']+$today_calls;
            $data['total_calls_today'] = $today_calls;
            
            $data['eme_calls_td'] = $dashboard_count[0]['eme_count_till_date']+$today_eme+3602556;
            $data['eme_calls_tm'] = $dashboard_count[0]['eme_count_till_month']+$today_eme;
             $data['eme_calls_to'] = $today_eme;
            
            $data['non_eme_td'] = $dashboard_count[0]['noneme_count_till_date']+$today_non_eme+18638463;
            $data['non_eme_tm'] = $dashboard_count[0]['noneme_count_till_month']+$today_non_eme;
            $data['non_eme_to'] = $today_non_eme;
            
             $data['total_calls_td'] = $data['eme_calls_td'] + $data['non_eme_td'];
            
        
            $data['total_dispatch_all'] =  $data['eme_calls_td'];
            $data['total_dispatch_tm'] =  $data['eme_calls_tm'];
            
            

            $data['total_calls_emps_td'] = $dashboard_count[0]['closure_till_date']+$closure_today+6176511;
            $data['total_calls_emps_tm'] = $dashboard_count[0]['closure_till_month']+$closure_today;
            
            $current_date = date('Y-m-d');

          $report_today = array('from_date' => date('Y-m-d', strtotime($current_date)),
                      'to_date' => date('Y-m-d', strtotime($current_date))
          );

          $current_date = date('Y-m-d');
          $report_today = array(
                          'from_date' => date('Y-m-d', strtotime($current_date)),
                          'to_date' => date('Y-m-d', strtotime($current_date)),
                          'system_type' => '108'
                          );
          //Today Data
          $Accident_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('15','58'));
          $assault_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('6'));
          $burn_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('14'));
          $attack_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('8','9','10'));
          $fall_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('54'));
          $poision_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('13','23','50'));
          $labour_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('24','34'));
          $light_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('55'));
          $mass_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('56'));
          $report_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('1','3','4','5','7','16','17','18','19','20','22','25','26','27','28','29','30','31','32','37','38','39','47','48','49','51','52','53'));
          $other_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('2','21','35','36','45','46'));
          $trauma_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('33'));
          $suicide_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('40'));
          $delivery_in_amb_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('11','12'));
          $pt_manage_on_veti_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('57'));
          $unavail_call_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('41','42','43','44'));
  
            $Accident_data_today = $Accident_data_today[0]->total_count;
            $assault_data_today = $assault_data_today[0]->total_count;
            $burn_data_today = $burn_data_today[0]->total_count;
            $attack_data_today = $attack_data_today[0]->total_count;
            $fall_data_today = $fall_data_today[0]->total_count;
            $poision_data_today = $poision_data_today[0]->total_count;
            $labour_data_today = $labour_data_today[0]->total_count;
            $light_data_today = $light_data_today[0]->total_count;
            $mass_data_today = $mass_data_today[0]->total_count;
            $report_data_today = $report_data_today[0]->total_count;
            $other_data_today = $other_data_today[0]->total_count;
            $trauma_data_today = $trauma_data_today[0]->total_count;
            $suicide_data_today=$suicide_data_today[0]->total_count;
            $delivery_in_amb_data_today = $delivery_in_amb_data_today[0]->total_count;
            $pt_manage_on_veti_data_today = $pt_manage_on_veti_data_today[0]->total_count;
            $unavail_call_data_today=$unavail_call_data_today[0]->total_count;
            
            //Till Month
        $From_date = date('Y-m-01');
        $to_date = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") - 1, date("Y")));
        $report_args_till_month = array(
            'from_date' => date('Y-m-d', strtotime($From_date)),
            'to_date' => date('Y-m-d', strtotime($to_date)),
            'system_type' => '108'
            );
        $Accident_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('15','58'));
        $assault_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('6'));
        $burn_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('14'));
        $attack_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('8','9','10'));
        $fall_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('54'));
        $poision_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('13','23','50'));
        $labour_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('24','34'));
        $light_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('55'));
        $mass_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('56'));
        $report_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('1','3','4','5','7','16','17','18','19','20','22','25','26','27','28','29','30','31','32','37','38','39','47','48','49','51','52','53'));
        $other_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('2','21','35','36','45','46'));
        $trauma_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('33'));
        $suicide_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('40'));
        $delivery_in_amb_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('11','12'));
        $pt_manage_on_veti_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('57'));
        $unavail_call_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('41','42','43','44'));
            
        $Accident_data_tm = $Accident_data_tm[0]->total_count;
            $assault_data_tm = $assault_data_tm[0]->total_count;
            $burn_data_tm = $burn_data_tm[0]->total_count;
            $attack_data_tm = $attack_data_tm[0]->total_count;
            $fall_data_tm = $fall_data_tm[0]->total_count;
            $poision_data_tm = $poision_data_tm[0]->total_count;
            $labour_data_tm = $labour_data_tm[0]->total_count;
            $light_data_tm = $light_data_tm[0]->total_count;
            $mass_data_tm = $mass_data_tm[0]->total_count;
            $report_data_tm = $report_data_tm[0]->total_count;
            $trauma_data_tm = $trauma_data_tm[0]->total_count;
            $suicide_data_tm = $suicide_data_tm[0]->total_count;
            $delivery_in_amb_data_tm= $delivery_in_amb_data_tm[0]->total_count;
            $pt_manage_on_veti_data_tm = $pt_manage_on_veti_data_tm[0]->total_count;
            $unavail_call_data_tm = $unavail_call_data_tm[0]->total_count;
            $other_data_tm= $other_data_tm[0]->total_count;
            
        /*$Accident_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Accident_Vehicle');
            $assault_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Assault');
            $burn_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Burns');
            $attack_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Cardiac');
            $fall_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Fall');
            $poision_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Intoxication_Poisoning');
            $labour_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Labour_Pregnancy');
            $light_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Lighting_Electrocution');
            $mass_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Mass_casualty');
            $report_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Medical');
            $trauma_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Poly_Trauma');
            $suicide_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Suicide_Self_Inflicted_Injury');
            $delivery_in_amb_data_tm= $this->Dashboard_model_final->get_b12_report_tm_new('Deliveries_in_Ambulance');
            $pt_manage_on_veti_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Patient_Manage_on_Ventilator');
            $unavail_call_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Unavailed_Call');
            $other_data_tm= $this->Dashboard_model_final->get_b12_report_tm_new('Others');
            */
            $Accident_data_td = $this->Dashboard_model_final->get_b12_report_new('Accident_Vehicle')+424982;
            $assault_data_td = $this->Dashboard_model_final->get_b12_report_new('Assault')+61567;
            $burn_data_td = $this->Dashboard_model_final->get_b12_report_new('Burns')+23024;
            $attack_data_td = $this->Dashboard_model_final->get_b12_report_new('Cardiac')+13431;
            $fall_data_td = $this->Dashboard_model_final->get_b12_report_new('Fall')+138025;
            $poision_data_td = $this->Dashboard_model_final->get_b12_report_new('Intoxication_Poisoning')+165926;
            $labour_data_td = $this->Dashboard_model_final->get_b12_report_new('Labour_Pregnancy')+1216628;
            $light_data_td = $this->Dashboard_model_final->get_b12_report_new('Lighting_Electrocution')+5872;
            $mass_data_td = $this->Dashboard_model_final->get_b12_report_new('Mass_casualty')+22952;
            $report_data_td = $this->Dashboard_model_final->get_b12_report_new('Medical')+3346572;
            $trauma_data_td = $this->Dashboard_model_final->get_b12_report_new('Poly_Trauma')+8601;
            $suicide_data_td = $this->Dashboard_model_final->get_b12_report_new('Suicide_Self_Inflicted_Injury')+5065;
            $delivery_in_amb_data_td= $this->Dashboard_model_final->get_b12_report_new('Deliveries_in_Ambulance')+36647;
            $pt_manage_on_veti_data_td = $this->Dashboard_model_final->get_b12_report_new('Patient_Manage_on_Ventilator')+3755;
            $unavail_call_data_td = $this->Dashboard_model_final->get_b12_report_new('Unavailed_Call');
            $other_data_td= $this->Dashboard_model_final->get_b12_report_new('Others')+742866;
            
           // var_dump($Accident_data_today);die();
            $today_closue = $Accident_data_today + $assault_data_today + $burn_data_today + $attack_data_today + $fall_data_today + $poision_data_today + $labour_data_today + $light_data_today + $mass_data_today + $report_data_today + $other_data_today + $trauma_data_today + $suicide_data_today+$delivery_in_amb_data_today+$pt_manage_on_veti_data_today;
            $data['total_closure_tm'] = $today_closue + $Accident_data_tm + $assault_data_tm + $burn_data_tm + $attack_data_tm + $fall_data_tm + $poision_data_tm + $labour_data_tm + $light_data_tm + $mass_data_tm + $report_data_tm + $other_data_tm + $trauma_data_tm + $suicide_data_tm + $pt_manage_on_veti_data_tm + $delivery_in_amb_data_tm;
            $data['total_closure_td'] = $today_closue + $Accident_data_td + $assault_data_td + $burn_data_td + $attack_data_td + $fall_data_td + $poision_data_td + $labour_data_td + $light_data_td + $mass_data_td + $report_data_td + $other_data_td + $trauma_data_td + $suicide_data_td + $pt_manage_on_veti_data_td + $delivery_in_amb_data_td;
            //$data['total_closure_td'] = $dashboard_count[0]['closure_till_date']+$closure_today+6176511;
            //$data['total_closure_tm'] = $dashboard_count[0]['closure_till_month']+$closure_today;
            //$data['total_closure_to'] = $closure_today;
            $dispatch_pt_count = $this->Dashboard_model_final->get_total_dispatch_patient();
            $data['total_closure_to'] = $dispatch_pt_count[0]['pt_count'];

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
            //var_dump($data['total_amb_data']);die();
            
            $this->output->add_to_position($this->load->view('frontend/dash/NHM_dashboard_view', $data, TRUE), 'content', TRUE);
            $this->output->template = "calls_nhm";
        }
        public function update_total_km_cron(){
            $district_names=$this->Dashboard_model_final->get_districts_names1();
            foreach ($district_names as $result){
                $dst_code = $result->dst_code;
                $dst_name = $result->dst_name;
                //Ambulance Count
                $amb_als = districtwise_ambulance_count($result->dst_code, 'ALS');
                $amb_bls = districtwise_ambulance_count($result->dst_code, 'BLS');
                $current_date = date('Y-m-d',strtotime("-1 days"));
                //Today
                $report_today = array('from_date' => date('Y-m-d', strtotime($current_date)),
                'to_date' => date('Y-m-d', strtotime($current_date)),
                'dst_code' => $dst_code
                );
                //$result_today = $this->Dashboard_model_final->total_km_today($report_today);
                //This Month
                $start_date_month = date('Y-m-01').' 00:00:00'; ;
                $previous_day = date('Y-m-d', strtotime($current_date)).' 23:59:59';
                 
                $report_args_tm = array(//'from_date' => date('Y-m-01'),
                    'from_date' =>$start_date_month,
                    'to_date' =>$previous_day,
                    'dst_code' => $dst_code
                );
               $result_month = $this->Dashboard_model_final->total_km_tillmonth($report_args_tm);
               $total_month_km = 0;
               foreach($result_month as $month){
                 
                  
                   $month_start_odometer = $month->start_odmeter;
                   $month_end_odometer = $month->end_odmeter;
                   $diff = 0;
                   $diff = (int)$month_end_odometer-(int)$month_start_odometer;
                   $total_month_km = $total_month_km+$diff;
                   
             
               }
                 
              
                //Till Date
                $start_date_month = '2021-12-01' ;
                $start_date_month =  date('Y-m-01');
                $previous_day = date('Y-m-d', strtotime('-1 day', strtotime($current_date))).' 23:59:59';
                $report_args_till_date = array(//'from_date' => date('Y-m-01'),
                    'from_date' =>$start_date_month,
                    'to_date' =>$previous_day,
                    'dst_code' => $dst_code
                );
                $result_tilldate = $this->Dashboard_model_final->total_km_tillmonth($report_args_till_date);
                 $total_tilldate_km = 0;
               foreach($result_tilldate as $tilldate){
                   $tilldate_start_odometer = $tilldate->start_odmeter;
                   $tilldate_end_odometer = $tilldate->end_odmeter;
                   $diff_till = 0;
                   $diff_till = (int)$tilldate_end_odometer-(int)$tilldate_start_odometer;
                   $total_tilldate_km = $total_tilldate_km+$diff_till;
                   
             
               }

                $km_info_dist = array(

                        'dst_code' => $dst_code,
                        'dst_name' => $dst_name,
                        'amb_als' => $amb_als,
                        'amb_bls' => $amb_bls,
                        'today_km' => $result_today,
                        'this_month_km' => $total_month_km,
                        'till_date_km' => $total_tilldate_km
                );
               $update_info = $this->Dashboard_model_final->update_total_km_data($km_info_dist);
             // $update_info = $this->Dashboard_model_final->insert_total_km_data($km_info_dist);
               
            }
            die();
           
        }
        function nhm_dashabord_cron_for_report(){
            
            $avaya = array('date_time'=>date("Y-m-d H:i:s"));
            $avaya_resp = json_encode($avaya);
              // file_put_contents('./logs/cron/'.date("Y-m-d").'nhm_dashabord_cron.log', $avaya_resp.",\r\n", FILE_APPEND); 
              
//            $division_data=$this->Dashboard_model_final->get_div_data();  
//        foreach($division_data as $division){
//            $args = array('division_code'=> $division->div_code);
//            
//            $division_total_data =$this->Dashboard_model_final->get_total_division_data($args);
//            foreach($division_total_data as $div){
//                $patient_served_tm = $div->patient_served_tm;
//                $patient_served_td = $div->patient_served_td;
//            }
//            $div_data = array('division_name'=>$division->div_name,
//                                                    'division_code'=>$division->div_code,
//                                                    'patient_served_tm'=>$patient_served_tm?$patient_served_tm:0,
//                                                    'patient_served_td'=>$patient_served_td?$patient_served_td:0,
//                                                    
//                                                );
//           
//             $this->Dashboard_model_final->update_division_calls($div_data);

//        }
         $from_date_live = '2021-07-01 00:00:00';
         $current_date = date('Y-m-d');
         
         $arg_till_date = array('current_date'=>date('Y-m-d', strtotime('-1 day', strtotime($current_date))),'from_date_live'=>date('Y-m-d H:m:s',strtotime($from_date_live)));
         $data_update['count_till_date'] = $this->Dashboard_model_final->get_call_count($arg_till_date);
         //echo "count_till_date<br>";
         
         $from_date = date('Y-m-01').' 00:00:00';
         $to_date = $current_date.' 23:59:59';
         $previous_day = date('Y-m-d', strtotime('-1 day', strtotime($current_date))).' 23:59:59';
         
         
        // if(date('Y-m-01') == $current_date){
         //     $data_update['count_till_month'] =0;
             
         
        // }else{
             
            $data_update['count_till_month'] = $this->Dashboard_model_final->date_reports_eme_calls($from_date,$previous_day);
          //  echo "count_till_month<br>";
         //}
      
         
         $args_tm['live_from_date'] = date('Y-m-01').' 00:00:00';
         $args_tm['to_date'] = $previous_day;
         $data_update['closure_till_month'] = $this->Dashboard_model_final->closure_till_date($args_tm);
        // echo "closure_till_month<br>";
      
         
         $args_tm1['to_date'] = $previous_day;
         $args_tm1['live_from_date'] = $from_date_live;
         $data_update['closure_till_date'] = $this->Dashboard_model_final->closure_till_date($args_tm1);
          //echo "closure_till_date<br>";
         
         
         $arg_till_date = array('date_type'=>'td','to_date'=>date('Y-m-d', strtotime('-1 day', strtotime($current_date))),'from_date_live'=>$from_date_live,'type'=>'eme');
        $data_update['eme_count_till_date']  = $this->Dashboard_model_final->get_total_call_type($arg_till_date);
        // echo "eme_count_till_date<br>";
        $data_update['dispatch_till_date']  =   $data_update['eme_count_till_date'];
         
          $arg_till_month = array('date_type'=>'tm','to_date'=>$previous_day,'from_date'=>$from_date,'type'=>'eme');
         $data_update['eme_count_till_month'] = $this->Dashboard_model_final->get_total_call_type($arg_till_month);
         //echo "eme_count_till_month<br>";
         
         $arg_till_date = array('date_type'=>'td','to_date'=>date('Y-m-d', strtotime('-1 day', strtotime($current_date))),'from_date_live'=>$from_date_live,'type'=>'non-eme');
        $data_update['noneme_count_till_date ']  = $this->Dashboard_model_final->get_total_call_type($arg_till_date);
         //echo "noneme_count_till_date<br>";
         
          $arg_till_month = array('date_type'=>'tm','to_date'=>$previous_day,'from_date'=>$from_date,'type'=>'non-eme');
         $data_update['noneme_count_till_month'] = $this->Dashboard_model_final->get_total_call_type($arg_till_month);
          //echo "noneme_count_till_date<br>";
         


          //$today_calls = $this->Dashboard_model_final->get_total_calls_today();
          
          $to_date = date('Y-m-d').' 23:59:59';
          $from_date = date('Y-m-d', strtotime('-1 day', strtotime($current_date))).' 23:59:59';
          
          $arg_today_eme = array('date_type'=>'to','type'=>'eme');
          $data_update['today_eme'] = $this->Dashboard_model_final->get_total_call_type($arg_today_eme);
          $arg_today_noneme = array('date_type'=>'to','type'=>'non-eme');
          $data_update['today_non_eme'] = $this->Dashboard_model_final->get_total_call_type($arg_today_noneme);
          
          
          $data_update['total_calls_today']=$data_update['today_eme']+$data_update['today_non_eme'];

          
          $data_update['closure_today'] = $this->Dashboard_model_final->get_total_closed_calls_today();




         $data_update['updated_date']=date('Y-m-d H:i:s');
        // var_dump($data_update);
        // die();
         
         //die();
         
         //$data_update = array('count_till_date' =>$total_calls_td,'closure_till_month'=>$total_calls_emps_tm,'closure_till_date'=>$total_calls_emps_td,'count_till_month'=>$total_calls_tm,'eme_count_till_date'=>$total_calls_em,);
        //  $total_calls_td = $this->Dashboard_model_final->update_data('1',$data_update);
         $total_data = $this->Dashboard_model_final->dash_insert_data($data_update);
 //B12 Report
 //1. Till Date B12 data   
     $start_date = '2021-07-01' ;
     $closure_date_to = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") - 1, date("Y"))) ;
    /// $closure_date= $this->Dashboard_model_final->get_closure_last_date();
    // $closure_date_to = date('Y-m-d', strtotime($closure_date[0]['inc_datetime']));
     $report_args2 = array('from_date' => date('Y-m-d', strtotime($start_date)),
                     'to_date' =>$closure_date_to
                     //'to_date' =>date('Y-m-d', strtotime('-1 day', strtotime($current_date)))
                     );
         $Accident_data_till = $this->inc_model->get_Accident_b12_report($report_args2);
         $assault_data_till = $this->inc_model->get_assault_b12_report($report_args2);
         $burn_data_till = $this->inc_model->get_burn_b12_report($report_args2);
         $attack_data_till = $this->inc_model->get_attack_b12_report($report_args2);
         $fall_data_till = $this->inc_model->get_fall_b12_report($report_args2);
         $poision_data_till = $this->inc_model->get_poision_b12_report($report_args2);
         $labour_data_till = $this->inc_model->get_labour_b12_report($report_args2);
         $light_data_till = $this->inc_model->get_light_b12_report($report_args2);
         $mass_data_till = $this->inc_model->get_mass_b12_report($report_args2);
         $report_data_till = $this->inc_model->get_medical_b12_report($report_args2);
         $other_data_till = $this->inc_model->get_other_b12_report($report_args2);
         $trauma_data_till = $this->inc_model->get_trauma_b12_report($report_args2);
         $suicide_data_till = $this->inc_model->get_suicide_b12_report($report_args2);
         $delivery_in_amb_data_till = $this->inc_model->get_delivery_in_amb_b12_report($report_args2);
         $pt_manage_on_veti_data_till = $this->inc_model->get_pt_manage_on_veti_b12_report($report_args2);
         $unavail_call_data_till = $this->inc_model->get_pt_manage_on_unavail_report($report_args2); 
 //2. This Month B12 data
 $closure_complete = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") - 1, date("Y")));
 // var_dump($closure_complete);die;
 $start_date_month = '2021-12-01' ;
  $start_date_month =  date('Y-m-01');
     $report_args_tm = array(//'from_date' => date('Y-m-01'),
         'from_date' =>$start_date_month,
         'to_date' =>date('Y-m-d')
     );
     
         $Accident_data_tm = $this->inc_model->get_Accident_b12_report($report_args_tm);
         $assault_data_tm = $this->inc_model->get_assault_b12_report($report_args_tm);
         $burn_data_tm = $this->inc_model->get_burn_b12_report($report_args_tm);
         $attack_data_tm = $this->inc_model->get_attack_b12_report($report_args_tm);
         $fall_data_tm = $this->inc_model->get_fall_b12_report($report_args_tm);
         $poision_data_tm = $this->inc_model->get_poision_b12_report($report_args_tm);
         $labour_data_tm = $this->inc_model->get_labour_b12_report($report_args_tm);
         $light_data_tm = $this->inc_model->get_light_b12_report($report_args_tm);
         $mass_data_tm = $this->inc_model->get_mass_b12_report($report_args_tm);
         $report_data_tm = $this->inc_model->get_medical_b12_report($report_args_tm);
         $other_data_tm = $this->inc_model->get_other_b12_report($report_args_tm);
         $trauma_data_tm = $this->inc_model->get_trauma_b12_report($report_args_tm);
         $suicide_data_tm = $this->inc_model->get_suicide_b12_report($report_args_tm);
         $delivery_in_amb_data_tm = $this->inc_model->get_delivery_in_amb_b12_report($report_args_tm);
         $pt_manage_on_veti_data_tm = $this->inc_model->get_pt_manage_on_veti_b12_report($report_args_tm);
         $unavail_call_data_tm = $this->inc_model->get_pt_manage_on_unavail_report($report_args_tm); 

        $b12_data = array('Accident_Vehicle' => $Accident_data_till[0]->total_count,
                         'Assault' => $assault_data_till[0]->total_count,
                         'Burns' => $burn_data_till[0]->total_count,
                         'Cardiac' => $attack_data_till[0]->total_count,
                         'Fall' => $fall_data_till[0]->total_count,
                         'Intoxication_Poisoning' => $poision_data_till[0]->total_count,
                         'Labour_Pregnancy' => $labour_data_till[0]->total_count,
                         'Lighting_Electrocution' => $light_data_till[0]->total_count,
                         'Mass_casualty' => $mass_data_till[0]->total_count,
                         'Medical' => $report_data_till[0]->total_count,
                         'Poly_Trauma' => $trauma_data_till[0]->total_count,
                         'Suicide_Self_Inflicted_Injury' => $suicide_data_till[0]->total_count,
                         'Deliveries_in_Ambulance' => $delivery_in_amb_data_till[0]->total_count,
                         'Patient_Manage_on_Ventilator' => $pt_manage_on_veti_data_till[0]->total_count,
                         'Unavailed_Call' => $unavail_call_data_till[0]->total_count,
                         'Others' => $other_data_till[0]->total_count,
                     );
                     foreach($b12_data as $key=>$b12){
                         $this->Dashboard_model_final->insert_b12_report_new($key,$b12);
                         $this->Dashboard_model_final->insert_b12_report($key,$b12);
                     }
         $B12_data_tm = array('Accident_Vehicle' => $Accident_data_tm[0]->total_count,
                             'Assault' => $assault_data_tm[0]->total_count,
                             'Burns' => $burn_data_tm[0]->total_count,
                             'Cardiac' => $attack_data_tm[0]->total_count,
                             'Fall' => $fall_data_tm[0]->total_count,
                             'Intoxication_Poisoning' => $poision_data_tm[0]->total_count,
                             'Labour_Pregnancy' => $labour_data_tm[0]->total_count,
                             'Lighting_Electrocution' => $light_data_tm[0]->total_count,
                             'Mass_casualty' => $mass_data_tm[0]->total_count,
                             'Medical' => $report_data_tm[0]->total_count,
                             'Poly_Trauma' => $trauma_data_tm[0]->total_count,
                             'Suicide_Self_Inflicted_Injury' => $suicide_data_tm[0]->total_count,
                             'Deliveries_in_Ambulance' => $delivery_in_amb_data_tm[0]->total_count,
                             'Patient_Manage_on_Ventilator' => $pt_manage_on_veti_data_tm[0]->total_count,
                             'Unavailed_Call' => $unavail_call_data_tm[0]->total_count,
                             'Others' => $other_data_tm[0]->total_count,
                     );
                     foreach($B12_data_tm as $key=>$b12_tm){
                         $this->Dashboard_model_final->insert_b12_report_tm_new($key,$b12_tm);
                         $this->Dashboard_model_final->insert_b12_report_tm($key,$b12_tm);
                     }
        // echo 'done';  
         die();
          
     }
        function nhm_dashabord_cron(){
            
               $avaya = array('date_time'=>date("Y-m-d H:i:s"));
               $avaya_resp = json_encode($avaya);
                 // file_put_contents('./logs/cron/'.date("Y-m-d").'nhm_dashabord_cron.log', $avaya_resp.",\r\n", FILE_APPEND); 
                 
//            $division_data=$this->Dashboard_model_final->get_div_data();  
//        foreach($division_data as $division){
//            $args = array('division_code'=> $division->div_code);
//            
//            $division_total_data =$this->Dashboard_model_final->get_total_division_data($args);
//            foreach($division_total_data as $div){
//                $patient_served_tm = $div->patient_served_tm;
//                $patient_served_td = $div->patient_served_td;
//            }
//            $div_data = array('division_name'=>$division->div_name,
//                                                    'division_code'=>$division->div_code,
//                                                    'patient_served_tm'=>$patient_served_tm?$patient_served_tm:0,
//                                                    'patient_served_td'=>$patient_served_td?$patient_served_td:0,
//                                                    
//                                                );
//           
//             $this->Dashboard_model_final->update_division_calls($div_data);

//        }
            $from_date_live = '2021-07-01 00:00:00';
            $current_date = date('Y-m-d');
            
            $arg_till_date = array('current_date'=>date('Y-m-d', strtotime('-1 day', strtotime($current_date))),'from_date_live'=>date('Y-m-d H:m:s',strtotime($from_date_live)));
            $data_update['count_till_date'] = $this->Dashboard_model_final->get_call_count($arg_till_date);
            //echo "count_till_date<br>";
            
            $from_date = date('Y-m-01').' 00:00:00';
            $to_date = $current_date.' 23:59:59';
            $previous_day = date('Y-m-d', strtotime('-1 day', strtotime($current_date))).' 23:59:59';
            
            
           // if(date('Y-m-01') == $current_date){
            //     $data_update['count_till_month'] =0;
                
            
           // }else{
                
               $data_update['count_till_month'] = $this->Dashboard_model_final->date_reports_eme_calls($from_date,$previous_day);
             //  echo "count_till_month<br>";
            //}
         
            
            $args_tm['live_from_date'] = date('Y-m-01').' 00:00:00';
            $args_tm['to_date'] = $previous_day;
            $data_update['closure_till_month'] = $this->Dashboard_model_final->closure_till_date($args_tm);
           // echo "closure_till_month<br>";
         
            
            $args_tm1['to_date'] = $previous_day;
            $args_tm1['live_from_date'] = $from_date_live;
            $data_update['closure_till_date'] = $this->Dashboard_model_final->closure_till_date($args_tm1);
             //echo "closure_till_date<br>";
            
            
            $arg_till_date = array('date_type'=>'td','to_date'=>date('Y-m-d', strtotime('-1 day', strtotime($current_date))),'from_date_live'=>$from_date_live,'type'=>'eme');
           $data_update['eme_count_till_date']  = $this->Dashboard_model_final->get_total_call_type($arg_till_date);
           // echo "eme_count_till_date<br>";
           $data_update['dispatch_till_date']  =   $data_update['eme_count_till_date'];
            
             $arg_till_month = array('date_type'=>'tm','to_date'=>$previous_day,'from_date'=>$from_date,'type'=>'eme');
            $data_update['eme_count_till_month'] = $this->Dashboard_model_final->get_total_call_type($arg_till_month);
            //echo "eme_count_till_month<br>";
            
            $arg_till_date = array('date_type'=>'td','to_date'=>date('Y-m-d', strtotime('-1 day', strtotime($current_date))),'from_date_live'=>$from_date_live,'type'=>'non-eme');
           $data_update['noneme_count_till_date ']  = $this->Dashboard_model_final->get_total_call_type($arg_till_date);
            //echo "noneme_count_till_date<br>";
            
             $arg_till_month = array('date_type'=>'tm','to_date'=>$previous_day,'from_date'=>$from_date,'type'=>'non-eme');
            $data_update['noneme_count_till_month'] = $this->Dashboard_model_final->get_total_call_type($arg_till_month);
             //echo "noneme_count_till_date<br>";
             
            $data_update['updated_date']=date('Y-m-d H:i:s');
           // var_dump($data_update);
           // die();
            
            //die();
            
            //$data_update = array('count_till_date' =>$total_calls_td,'closure_till_month'=>$total_calls_emps_tm,'closure_till_date'=>$total_calls_emps_td,'count_till_month'=>$total_calls_tm,'eme_count_till_date'=>$total_calls_em,);
            $total_calls_td = $this->Dashboard_model_final->update_data('1',$data_update);
            // $total_data = $this->Dashboard_model_final->dash_insert_data($data_update);
    //B12 Report
    //1. Till Date B12 data   



        $start_date = '2021-07-01' ;
        $closure_date_to = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") - 1, date("Y"))) ;
       /// $closure_date= $this->Dashboard_model_final->get_closure_last_date();
       // $closure_date_to = date('Y-m-d', strtotime($closure_date[0]['inc_datetime']));
       
        $report_args2 = array('from_date' => date('Y-m-d', strtotime($start_date)),
                        'to_date' =>$closure_date_to
                        //'to_date' =>date('Y-m-d', strtotime('-1 day', strtotime($current_date)))
                        );
            $Accident_data_till = $this->inc_model->get_Accident_b12_report($report_args2);
            $assault_data_till = $this->inc_model->get_assault_b12_report($report_args2);
            $burn_data_till = $this->inc_model->get_burn_b12_report($report_args2);
            $attack_data_till = $this->inc_model->get_attack_b12_report($report_args2);
            $fall_data_till = $this->inc_model->get_fall_b12_report($report_args2);
            $poision_data_till = $this->inc_model->get_poision_b12_report($report_args2);
            $labour_data_till = $this->inc_model->get_labour_b12_report($report_args2);
            $light_data_till = $this->inc_model->get_light_b12_report($report_args2);
            $mass_data_till = $this->inc_model->get_mass_b12_report($report_args2);
            $report_data_till = $this->inc_model->get_medical_b12_report($report_args2);
            $other_data_till = $this->inc_model->get_other_b12_report($report_args2);
            $trauma_data_till = $this->inc_model->get_trauma_b12_report($report_args2);
            $suicide_data_till = $this->inc_model->get_suicide_b12_report($report_args2);
            $delivery_in_amb_data_till = $this->inc_model->get_delivery_in_amb_b12_report($report_args2);
            $pt_manage_on_veti_data_till = $this->inc_model->get_pt_manage_on_veti_b12_report($report_args2);
            $unavail_call_data_till = $this->inc_model->get_pt_manage_on_unavail_report($report_args2); 
    //2. This Month B12 data
    $closure_complete = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") - 1, date("Y")));
    // var_dump($closure_complete);die;
    $start_date_month = '2021-12-01' ;
     $start_date_month =  date('Y-m-01');
        $report_args_tm = array(//'from_date' => date('Y-m-01'),
            'from_date' =>$start_date_month,
            'to_date' =>$closure_complete
        );
       
        
            $Accident_data_tm = $this->inc_model->get_Accident_b12_report($report_args_tm);
            $assault_data_tm = $this->inc_model->get_assault_b12_report($report_args_tm);
            $burn_data_tm = $this->inc_model->get_burn_b12_report($report_args_tm);
            $attack_data_tm = $this->inc_model->get_attack_b12_report($report_args_tm);
            $fall_data_tm = $this->inc_model->get_fall_b12_report($report_args_tm);
            $poision_data_tm = $this->inc_model->get_poision_b12_report($report_args_tm);
            $labour_data_tm = $this->inc_model->get_labour_b12_report($report_args_tm);
            $light_data_tm = $this->inc_model->get_light_b12_report($report_args_tm);
            $mass_data_tm = $this->inc_model->get_mass_b12_report($report_args_tm);
            $report_data_tm = $this->inc_model->get_medical_b12_report($report_args_tm);
            $other_data_tm = $this->inc_model->get_other_b12_report($report_args_tm);
            $trauma_data_tm = $this->inc_model->get_trauma_b12_report($report_args_tm);
            $suicide_data_tm = $this->inc_model->get_suicide_b12_report($report_args_tm);
            $delivery_in_amb_data_tm = $this->inc_model->get_delivery_in_amb_b12_report($report_args_tm);
            $pt_manage_on_veti_data_tm = $this->inc_model->get_pt_manage_on_veti_b12_report($report_args_tm);
            $unavail_call_data_tm = $this->inc_model->get_pt_manage_on_unavail_report($report_args_tm); 

        //2day previous
        $start_date = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") - 2, date("Y"))) ;
          $report_args_pre2day = array('from_date' => date('Y-m-d', strtotime($start_date)),
                      'to_date' => date('Y-m-d', strtotime($start_date))
          );
                $Accident_data_pre2day = $this->inc_model->get_Accident_b12_report($report_args_pre2day);
                $assault_data_pre2day = $this->inc_model->get_assault_b12_report($report_args_pre2day);
                $burn_data_pre2day = $this->inc_model->get_burn_b12_report($report_args_pre2day);
                $attack_data_pre2day = $this->inc_model->get_attack_b12_report($report_args_pre2day);
                $fall_data_pre2day = $this->inc_model->get_fall_b12_report($report_args_pre2day);
                $poision_data_pre2day = $this->inc_model->get_poision_b12_report($report_args_pre2day);
                $labour_data_pre2day = $this->inc_model->get_labour_b12_report($report_args_pre2day);
                $light_data_pre2day = $this->inc_model->get_light_b12_report($report_args_pre2day);
                $mass_data_pre2day = $this->inc_model->get_mass_b12_report($report_args_pre2day);
                $report_data_pre2day = $this->inc_model->get_medical_b12_report($report_args_pre2day);
                $other_data_pre2day = $this->inc_model->get_other_b12_report($report_args_pre2day);
                $trauma_data_pre2day = $this->inc_model->get_trauma_b12_report($report_args_pre2day);
                $suicide_data_pre2day = $this->inc_model->get_suicide_b12_report($report_args_pre2day);
                $delivery_in_amb_data_pre2day = $this->inc_model->get_delivery_in_amb_b12_report($report_args_pre2day);
                $pt_manage_on_veti_data_pre2day = $this->inc_model->get_pt_manage_on_veti_b12_report($report_args_pre2day);
                $unavail_call_data_pre2day = $this->inc_model->get_pt_manage_on_unavail_report($report_args_pre2day); 
        /****** */
           $b12_data = array('Accident_Vehicle' => $Accident_data_till[0]->total_count,
                            'Assault' => $assault_data_till[0]->total_count,
                            'Burns' => $burn_data_till[0]->total_count,
                            'Cardiac' => $attack_data_till[0]->total_count,
                            'Fall' => $fall_data_till[0]->total_count,
                            'Intoxication_Poisoning' => $poision_data_till[0]->total_count,
                            'Labour_Pregnancy' => $labour_data_till[0]->total_count,
                            'Lighting_Electrocution' => $light_data_till[0]->total_count,
                            'Mass_casualty' => $mass_data_till[0]->total_count,
                            'Medical' => $report_data_till[0]->total_count,
                            'Poly_Trauma' => $trauma_data_till[0]->total_count,
                            'Suicide_Self_Inflicted_Injury' => $suicide_data_till[0]->total_count,
                            'Deliveries_in_Ambulance' => $delivery_in_amb_data_till[0]->total_count,
                            'Patient_Manage_on_Ventilator' => $pt_manage_on_veti_data_till[0]->total_count,
                            'Unavailed_Call' => $unavail_call_data_till[0]->total_count,
                            'Others' => $other_data_till[0]->total_count,
                        );
                        foreach($b12_data as $key=>$b12){
                            $this->Dashboard_model_final->insert_b12_report($key,$b12);
                        }
            $B12_data_tm = array('Accident_Vehicle' => $Accident_data_tm[0]->total_count,
                                'Assault' => $assault_data_tm[0]->total_count,
                                'Burns' => $burn_data_tm[0]->total_count,
                                'Cardiac' => $attack_data_tm[0]->total_count,
                                'Fall' => $fall_data_tm[0]->total_count,
                                'Intoxication_Poisoning' => $poision_data_tm[0]->total_count,
                                'Labour_Pregnancy' => $labour_data_tm[0]->total_count,
                                'Lighting_Electrocution' => $light_data_tm[0]->total_count,
                                'Mass_casualty' => $mass_data_tm[0]->total_count,
                                'Medical' => $report_data_tm[0]->total_count,
                                'Poly_Trauma' => $trauma_data_tm[0]->total_count,
                                'Suicide_Self_Inflicted_Injury' => $suicide_data_tm[0]->total_count,
                                'Deliveries_in_Ambulance' => $delivery_in_amb_data_tm[0]->total_count,
                                'Patient_Manage_on_Ventilator' => $pt_manage_on_veti_data_tm[0]->total_count,
                                'Unavailed_Call' => $unavail_call_data_tm[0]->total_count,
                                'Others' => $other_data_tm[0]->total_count,
                        );
                        foreach($B12_data_tm as $key=>$b12_tm){
                            $this->Dashboard_model_final->insert_b12_report_tm($key,$b12_tm);
                        }

                $B12_data_pre2day = array('Accident_Vehicle' => $Accident_data_pre2day[0]->total_count,
                        'Assault' => $assault_data_pre2day[0]->total_count,
                        'Burns' => $burn_data_pre2day[0]->total_count,
                        'Cardiac' => $attack_data_pre2day[0]->total_count,
                        'Fall' => $fall_data_pre2day[0]->total_count,
                        'Intoxication_Poisoning' => $poision_data_pre2day[0]->total_count,
                        'Labour_Pregnancy' => $labour_data_pre2day[0]->total_count,
                        'Lighting_Electrocution' => $light_data_pre2day[0]->total_count,
                        'Mass_casualty' => $mass_data_pre2day[0]->total_count,
                        'Medical' => $report_data_pre2day[0]->total_count,
                        'Poly_Trauma' => $trauma_data_pre2day[0]->total_count,
                        'Suicide_Self_Inflicted_Injury' => $suicide_data_pre2day[0]->total_count,
                        'Deliveries_in_Ambulance' => $delivery_in_amb_data_pre2day[0]->total_count,
                        'Patient_Manage_on_Ventilator' => $pt_manage_on_veti_data_pre2day[0]->total_count,
                        'Unavailed_Call' => $unavail_call_data_pre2day[0]->total_count,
                        'Others' => $other_data_pre2day[0]->total_count,
                );
                foreach($B12_data_pre2day as $key=>$b12_pre2day){
                    $this->Dashboard_model_final->insert_b12_report_pre2day($key,$b12_pre2day);
                }
            
           // echo 'done';  
            die();
             
        }
        function nhm108_division_view(){
        $division_data=$this->Dashboard_model_final->get_div_data();  
        foreach($division_data as $division){
            $args = array('division_code'=> $division->div_code);
            
            $division_total_data =$this->Dashboard_model_final->get_total_division_data($args);
            foreach($division_total_data as $div){
                $dispatch_today_108 = $div->dispatch_today_108;
                $patient_served_tm = $div->patient_served_tm;
                $patient_served_td = $div->patient_served_td+$div->patient_servedold_td;
                //$dispatch_today_102 = $div->dispatch_today_102;
                //$dispatch_tm = $div->dispatch_tm;
                //$dispatch_td = $div->dispatch_td;
            }
            $div_data[$division->div_code] = array('div_name'=>$division->div_name,
                                                    'div_code'=>$division->div_code,
                                                    'dispatch_today_108'=>$dispatch_today_108,
                                                    'patient_served_tm'=>$patient_served_tm,
                                                    'patient_served_td'=>$patient_served_td,
                                                    
                                                );
            $data['div_data'] = $div_data;
        }
        $this->output->add_to_position($this->load->view('frontend/dash/NHM108_division_view', $data, TRUE), 'division108_view', TRUE);
        }
        function nhm102_division_view(){
            $division_data=$this->Dashboard_model_final->get_div_data();  
            foreach($division_data as $division){
            $args = array('division_code'=> $division->div_code);
            $division_total_data =$this->Dashboard_model_final->get_total_division_data($args);
            foreach($division_total_data as $div){
                $dispatch_today_102 = $div->dispatch_today_102;
                $dispatch_tm = $div->dispatch_tm;
                $dispatch_td = $div->dispatch_td;
            }
            $div_data[$division->div_code] = array('div_name'=>$division->div_name,
                                                    'div_code'=>$division->div_code,
                                                    'dispatch_today_102'=>$dispatch_today_102,
                                                    'dispatch_tm'=>$dispatch_tm,
                                                    'dispatch_td'=>$dispatch_td,
                                                    
                                                );
            $data['div_data'] = $div_data;
            }
            $this->output->add_to_position($this->load->view('frontend/dash/NHM102_division_view', $data, TRUE), 'division102_view', TRUE);
           
        }
        function nhm108_district_view(){
            //$div_code = $this->input->post('div_code');
            $dst_state = $this->input->post('dst_state');
            
            $args = array('dst_state'=> $dst_state);
            $district_data=$this->Dashboard_model_final->get_dis_data_new($args);  
            foreach($district_data as $dis){
                $args = array('dst_code' =>$dis->dst_code );
                $district_total_data =$this->Dashboard_model_final->get_total_district_data($args);
                foreach($district_total_data as $district){
                    $dispatch_today_108 = $district->dispatch_today_108;
                    $patient_served_tm = $district->patient_served_tm;
                    $patient_served_td = $district->patient_served_td+$district->patient_servedold_td;
                }

                $dis_data[$dis->dst_code] = array('dst_name'=>$dis->dst_name,
                                                  'dst_code'=>$dis->dst_code,
                                                  'dispatch_today_108'=>$dispatch_today_108,
                                                  'patient_served_tm'=>$patient_served_tm,
                                                  'patient_served_td'=>$patient_served_td,
                                                    
                                                );
                $data['dis_data'] = $dis_data;
            }
            $this->output->add_to_position($this->load->view('frontend/dash/NHM108_district_view', $data, TRUE), 'district108_view', TRUE);

        }
        function nhm102_district_view(){
            $div_code = $this->input->post('div_code');
            $args = array('division_code'=> $div_code);
            $district_data=$this->Dashboard_model_final->get_dis_data($args);  
            foreach($district_data as $dis){
                $args = array('div_code'=> $div_code,'dst_code' =>$dis->dst_code );
                $district_total_data =$this->Dashboard_model_final->get_total_district_data($args);
                foreach($district_total_data as $district_nhm){
                    $dispatch_today_102 = $district_nhm->dispatch_today_102;
                    $dispatch_tm = $district_nhm->dispatch_tm;
                    $dispatch_td = $district_nhm->dispatch_td;
                }

                $dis_data[$dis->dst_code] = array('dst_name'=>$dis->dst_name,
                                                  'dst_code'=>$dis->dst_code,
                                                  'dispatch_today_102'=>$dispatch_today_102,
                                                  'dispatch_tm'=>$dispatch_tm,
                                                    'dispatch_td'=>$dispatch_td,
                                                    
                                                );
                $data['dis_data'] = $dis_data;
            }
            //var_dump($data);die();
            $this->output->add_to_position($this->load->view('frontend/dash/NHM102_district_view', $data, TRUE), 'district102_view', TRUE);

        }
        function nhm_map(){
            $data['amb_data'] = $this->amb_model->get_gps_amb_data($args);
            $this->output->add_to_position($this->load->view('frontend/dash/nhm_all_amb_loc_view_new', $data, TRUE), 'content', TRUE);
            $this->output->template = "nhm_blank";
        }
        function load_ambulance_typewise(){
            $amb_type = $this->input->post('amb_type');
            $thirdparty = $this->clg->thirdparty;
            $args = array('amb_type' => $amb_type,'thirdparty' => $thirdparty);
            //var_dump($args);die();
            $data['amb_data'] = $this->common_model->get_ambulance($args);
            $this->output->add_to_position($this->load->view('dashboard/ambulance_dropdown_view', $data, TRUE), 'amb_view', TRUE);
        }
        function load_amb_typewise()
    {
        
            $amb_id = $this->input->post('amb_id');
           $amb_district = $this->input->post('amb_district');
           
            if($amb_id=='all'){
                $args = array('all_amb' => $amb_id);
                $amb_busy = array('system_type' => array('108','102'),'status' => '1');
                $data['amb_available'] = $this->Dashboard_model_final_updated->get_amb_count($amb_busy);

                $amb_busy = array('system_type' => array('108','102'),'status' => '2');
                $data['amb_busy'] = $this->Dashboard_model_final_updated->get_amb_count($amb_busy);

                $amb_all = array('system_type' => array('108','102'),'status' => '7');
                $data['amb_maintainance'] = $this->Dashboard_model_final_updated->get_amb_count($amb_all);
            }else if($amb_id=='108amb'){
                $args = array('108amb' => $amb_id);
                $amb_busy = array('system_type' => array('108'),'status' => '1');
                $data['amb_available'] = $this->Dashboard_model_final_updated->get_amb_count($amb_busy);

                $amb_busy = array('system_type' => array('108'),'status' => '2');
                $data['amb_busy'] = $this->Dashboard_model_final_updated->get_amb_count($amb_busy);

                $amb_all = array('system_type' => array('108'),'status' => '7');
                $data['amb_maintainance'] = $this->Dashboard_model_final_updated->get_amb_count($amb_all);
            
            }else if($amb_id=='102amb'){
                $args = array('102amb' => $amb_id);
                $amb_busy = array('system_type' => array('102'),'status' => '1');
                $data['amb_available'] = $this->Dashboard_model_final_updated->get_amb_count($amb_busy);

                $amb_busy = array('system_type' => array('102'),'status' => '2');
                $data['amb_busy'] = $this->Dashboard_model_final_updated->get_amb_count($amb_busy);

                $amb_all = array('system_type' => array('102'),'status' => '7');
                $data['amb_maintainance'] = $this->Dashboard_model_final_updated->get_amb_count($amb_all);
            
            }else{
                $args = array('amb_rto_register' => $amb_id);
                $amb_busy = array('system_type' => array('108','102'),'status' => '1');
                $data['amb_available'] = $this->Dashboard_model_final_updated->get_amb_count($amb_busy);

                $amb_busy = array('system_type' => array('108','102'),'status' => '2');
                $data['amb_busy'] = $this->Dashboard_model_final_updated->get_amb_count($amb_busy);

                $amb_all = array('system_type' => array('108','102'),'status' => '7');
                $data['amb_maintainance'] = $this->Dashboard_model_final_updated->get_amb_count($amb_all);
            
            }
               
              	
           /* $current_date = date('Y-m-d');
            $data['current_date']=$current_date;
            $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),'district_name'=>'total' );
            $data['total_amb_data'] = $this->common_model->get_district_wise_offroad_mapcount($report_args);
            if(empty($data['total_amb_data'])){
            $data['current_date']=date('Y-m-d', strtotime('-1 day', strtotime($current_date)));
            $report_args = array('from_date'=>date('Y-m-d', strtotime('-1 day', strtotime($current_date))),'district_name'=>'total');
            $data['total_amb_data'] = $this->common_model->get_district_wise_offroad_mapcount($report_args);
            }*/
           
            
           
            

                //$args['amb_type_not'] = array('1');
            $data['amb_id'] = $amb_id;
            $data['amb_rto_register']=$amb_district;
            $args['district_id'] =$data['district_id'] = $amb_district;
            $data['amb_data'] = $this->amb_model->get_gps_amb_data($args);
            $data['amb_rto_register']=$amb_id;
            $data['dist'] = $this->common_model->get_district(array('st_id' => 'MP'));
            
            
            $this->output->add_to_position($this->load->view('frontend/dash/nhm_all_amb_loc_view', $data, TRUE), 'tabs-2', TRUE);
            $this->output->template = "nhm_blank";
        
    }
    function load_single_amb_dash(){
        $amb_reg_id = $this->input->post('amb_id');
        $args = array('amb_rto_register' => $amb_reg_id);
       
        $data['amb_id_red'] = $amb_reg_id;
        $data['amb_rto_register'] = 'single_amb';
       
        $data['amb_data'] = $this->amb_model->get_gps_amb_data($args);
        $clg_group =  $this->clg->clg_group;
        $args['amb_type_not'] = array('1');
          $data['dist'] = $this->common_model->get_district(array('st_id' => 'MP'));
          $current_date = date('Y-m-d');
        /*  $data['current_date']=$current_date;
          $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),'district_name'=>'total' );
          $data['total_amb_data'] = $this->common_model->get_district_wise_offroad_mapcount($report_args);
          if(empty($data['total_amb_data'])){
          $data['current_date']=date('Y-m-d', strtotime('-1 day', strtotime($current_date)));
          $report_args = array('from_date'=>date('Y-m-d', strtotime('-1 day', strtotime($current_date))),'district_name'=>'total');
          $data['total_amb_data'] = $this->common_model->get_district_wise_offroad_mapcount($report_args);
          }  
          */
           $amb_all = array('system_type' => array('108','102'),'status' => '7');
            $data['amb_maintainance'] = $this->Dashboard_model_final_updated->get_amb_count($amb_all);
            
            $amb_available = array('system_type' => array('108','102'),'status' => '1');
            $data['amb_available'] = $this->Dashboard_model_final_updated->get_amb_count($amb_available);
            
            $amb_busy = array('system_type' => array('108','102'),'status' => '2');
            $data['amb_busy'] = $this->Dashboard_model_final_updated->get_amb_count($amb_busy);
        if($clg_group == 'UG-SuperAdmin' || $clg_group == 'UG-OperationHR'){
             $this->output->add_to_position($this->load->view('frontend/amb/amb_loc_view', $data, TRUE), 'content', TRUE);
            $this->output->template = "amb_loc_map";
        }else{
        $this->output->add_to_position($this->load->view('frontend/dash/nhm_all_amb_loc_view', $data, TRUE), 'tabs-2', TRUE);
      
       $this->output->template = "nhm_blank";
        }
    }
     function link(){
        $this->output->template = "blank";
     }   
     function Historical_dash(){
        $this->output->template = "blank"; 
     }
     function gio_dash_data(){
        $this->output->template = "blank"; 
     }
     function B12_data(){
        

        /*  $start_date = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") - 2, date("Y"))) ;
          $report_args2 = array('from_date' => date('Y-m-d', strtotime($start_date)),
                      'to_date' => date('Y-m-d', strtotime($start_date))
          );*/
          $current_date = date('Y-m-d');

          $report_today = array('from_date' => date('Y-m-d', strtotime($current_date)),
                      'to_date' => date('Y-m-d', strtotime($current_date))
          );
          //today
          // 2020-06-01
          $Accident_data_today = $this->inc_model->get_Accident_b12_report($report_today);
          $assault_data_today = $this->inc_model->get_assault_b12_report($report_today);
          $burn_data_today = $this->inc_model->get_burn_b12_report($report_today);
          $attack_data_today = $this->inc_model->get_attack_b12_report($report_today);
          $fall_data_today = $this->inc_model->get_fall_b12_report($report_today);
          $poision_data_today = $this->inc_model->get_poision_b12_report($report_today);
          $labour_data_today = $this->inc_model->get_labour_b12_report($report_today);
          $light_data_today = $this->inc_model->get_light_b12_report($report_today);
          $mass_data_today = $this->inc_model->get_mass_b12_report($report_today);
          $report_data_today = $this->inc_model->get_medical_b12_report($report_today);
          $other_data_today = $this->inc_model->get_other_b12_report($report_today);
          $trauma_data_today = $this->inc_model->get_trauma_b12_report($report_today);
          $suicide_data_today = $this->inc_model->get_suicide_b12_report($report_today);
          $delivery_in_amb_data_today = $this->inc_model->get_delivery_in_amb_b12_report($report_today);
          $pt_manage_on_veti_data_today = $this->inc_model->get_pt_manage_on_veti_b12_report($report_today);
          $unavail_call_data_today = $this->inc_model->get_pt_manage_on_unavail_report($report_today);
          // 2020-06-01
          /*$Accident_data = $this->inc_model->get_Accident_b12_report($report_args2);
          $assault_data = $this->inc_model->get_assault_b12_report($report_args2);
          $burn_data = $this->inc_model->get_burn_b12_report($report_args2);
          $attack_data = $this->inc_model->get_attack_b12_report($report_args2);
          $fall_data = $this->inc_model->get_fall_b12_report($report_args2);
          $poision_data = $this->inc_model->get_poision_b12_report($report_args2);
          $labour_data = $this->inc_model->get_labour_b12_report($report_args2);
          $light_data = $this->inc_model->get_light_b12_report($report_args2);
          $mass_data = $this->inc_model->get_mass_b12_report($report_args2);
          $report_data = $this->inc_model->get_medical_b12_report($report_args2);
          $other_data = $this->inc_model->get_other_b12_report($report_args2);
          $trauma_data = $this->inc_model->get_trauma_b12_report($report_args2);
          $suicide_data = $this->inc_model->get_suicide_b12_report($report_args2);
          $delivery_in_amb_data = $this->inc_model->get_delivery_in_amb_b12_report($report_args2);
          $pt_manage_on_veti_data = $this->inc_model->get_pt_manage_on_veti_b12_report($report_args2);
          $unavail_call_data = $this->inc_model->get_pt_manage_on_unavail_report($report_args2);
          */   
          $start_date = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") - 2, date("Y"))) ;
          $report_args_pre2day = array(
            'from_date' => date('Y-m-d', strtotime($start_date)),
            'to_date' => date('Y-m-d', strtotime($start_date)),
            'system_type' => '108'
            );

        
        //2 days previous data Data
        $Accident_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('15','58'));
        $assault_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('6'));
        $burn_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('14'));
        $attack_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('8','9','10'));
        $fall_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('54'));
        $poision_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('13','23','50'));
        $labour_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('24','34'));
        $light_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('55'));
        $mass_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('56'));
        $report_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('1','3','4','5','7','16','17','18','19','20','22','25','26','27','28','29','30','31','32','37','38','39','47','48','49','51','52','53'));
        $other_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('2','21','35','36','45','46'));
        $trauma_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('33'));
        $suicide_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('40'));
        $delivery_in_amb_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('11','12'));
        $pt_manage_on_veti_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('57'));
        $unavail_call_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('41','42','43','44'));

             $inc_data[]=array(
  
                              'Accident_data_today' => $Accident_data_today[0]->total_count,
                              'assault_data_today' => $assault_data_today[0]->total_count,
                              'burn_data_today' => $burn_data_today[0]->total_count,
                              'attack_data_today' => $attack_data_today[0]->total_count,
                              'fall_data_today' => $fall_data_today[0]->total_count,
                              'poision_data_today' => $poision_data_today[0]->total_count,
                              'labour_data_today' => $labour_data_today[0]->total_count,
                              'light_data_today' => $light_data_today[0]->total_count,
                              'mass_data_today' => $mass_data_today[0]->total_count,
                              'report_data_today' => $report_data_today[0]->total_count,
                              'other_data_today' => $other_data_today[0]->total_count,
                              'trauma_data_today' => $trauma_data_today[0]->total_count,
                              'suicide_data_today'=>$suicide_data_today[0]->total_count,
                              'delivery_in_amb_data_today' => $delivery_in_amb_data_today[0]->total_count,
                              'pt_manage_on_veti_data_today' => $pt_manage_on_veti_data_today[0]->total_count,
                              'unavail_call_data_today'=>$unavail_call_data_today[0]->total_count,
  
                            /*
                              'Accident_data' => $this->Dashboard_model_final->get_b12_report_pre2day('Accident_Vehicle'),
                              'assault_data' => $this->Dashboard_model_final->get_b12_report_pre2day('Assault'),
                              'burn_data' => $this->Dashboard_model_final->get_b12_report_pre2day('Burns'),
                              'attack_data' => $this->Dashboard_model_final->get_b12_report_pre2day('Cardiac'),
                              'fall_data' => $this->Dashboard_model_final->get_b12_report_pre2day('Fall'),
                              'poision_data' => $this->Dashboard_model_final->get_b12_report_pre2day('Intoxication_Poisoning'),
                              'labour_data' => $this->Dashboard_model_final->get_b12_report_pre2day('Labour_Pregnancy'),
                              'light_data' => $this->Dashboard_model_final->get_b12_report_pre2day('Lighting_Electrocution'),
                              'mass_data' => $this->Dashboard_model_final->get_b12_report_pre2day('Mass_casualty'),
                              'report_data' => $this->Dashboard_model_final->get_b12_report_pre2day('Medical'),
                              'other_data' => $this->Dashboard_model_final->get_b12_report_pre2day('Others'),
                              'trauma_data' => $this->Dashboard_model_final->get_b12_report_pre2day('Poly_Trauma'),
                              'suicide_data'=> $this->Dashboard_model_final->get_b12_report_pre2day('Suicide_Self_Inflicted_Injury'),
                              'delivery_in_amb_data' => $this->Dashboard_model_final->get_b12_report_pre2day('Deliveries_in_Ambulance'),
                              'pt_manage_on_veti_data' => $this->Dashboard_model_final->get_b12_report_pre2day('Patient_Manage_on_Ventilator'),
                              'unavail_call_data'=>$this->Dashboard_model_final->get_b12_report_pre2day('Unavailed_Call'),
                            */
                            'Accident_data' => $Accident_data_pre2day[0]->total_count,
                            'assault_data' => $assault_data_pre2day[0]->total_count,
                            'burn_data' => $burn_data_pre2day[0]->total_count,
                            'attack_data' => $attack_data_pre2day[0]->total_count,
                            'fall_data' => $fall_data_pre2day[0]->total_count,
                            'poision_data' => $poision_data_pre2day[0]->total_count,
                            'labour_data' => $labour_data_pre2day[0]->total_count,
                            'light_data' => $light_data_pre2day[0]->total_count,
                            'mass_data' => $mass_data_pre2day[0]->total_count,
                            'report_data' => $report_data_pre2day[0]->total_count,
                            'trauma_data' => $trauma_data_pre2day[0]->total_count,
                            'suicide_data'=> $suicide_data_pre2day[0]->total_count,
                            'delivery_in_amb_data' => $delivery_in_amb_data_pre2day[0]->total_count,
                            'pt_manage_on_veti_data' => $pt_manage_on_veti_data_pre2day[0]->total_count,
                            'unavail_call_data'=>$unavail_call_data_pre2day[0]->total_count,
                            'other_data' => $other_data_pre2day[0]->total_count,

                              'Accident_data_tm' => $this->Dashboard_model_final->get_b12_report_tm('Accident_Vehicle'),
                              'assault_data_tm' => $this->Dashboard_model_final->get_b12_report_tm('Assault'),
                              'burn_data_tm' => $this->Dashboard_model_final->get_b12_report_tm('Burns'),
                              'attack_data_tm' => $this->Dashboard_model_final->get_b12_report_tm('Cardiac'),
                              'fall_data_tm' => $this->Dashboard_model_final->get_b12_report_tm('Fall'),
                              'poision_data_tm' => $this->Dashboard_model_final->get_b12_report_tm('Intoxication_Poisoning'),
                              'labour_data_tm' => $this->Dashboard_model_final->get_b12_report_tm('Labour_Pregnancy'),
                              'light_data_tm' => $this->Dashboard_model_final->get_b12_report_tm('Lighting_Electrocution'),
                              'mass_data_tm' => $this->Dashboard_model_final->get_b12_report_tm('Mass_casualty'),
                              'report_data_tm' => $this->Dashboard_model_final->get_b12_report_tm('Medical'),
                              'trauma_data_tm' => $this->Dashboard_model_final->get_b12_report_tm('Poly_Trauma'),
                              'suicide_data_tm' => $this->Dashboard_model_final->get_b12_report_tm('Suicide_Self_Inflicted_Injury'),
                              'delivery_in_amb_data_tm'=> $this->Dashboard_model_final->get_b12_report_tm('Deliveries_in_Ambulance'),
                              'pt_manage_on_veti_data_tm' => $this->Dashboard_model_final->get_b12_report_tm('Patient_Manage_on_Ventilator'),
                              'unavail_call_data_tm' => $this->Dashboard_model_final->get_b12_report_tm('Unavailed_Call'),
                              'other_data_tm'=> $this->Dashboard_model_final->get_b12_report_tm('Others'),
             
                              'Accident_data_td' => $this->Dashboard_model_final->get_b12_report('Accident_Vehicle')+424982,
                              'assault_data_td' => $this->Dashboard_model_final->get_b12_report('Assault')+61567,
                              'burn_data_td' => $this->Dashboard_model_final->get_b12_report('Burns')+23024,
                              'attack_data_td' => $this->Dashboard_model_final->get_b12_report('Cardiac')+13431,
                              'fall_data_td' => $this->Dashboard_model_final->get_b12_report('Fall')+138025,
                              'poision_data_td' => $this->Dashboard_model_final->get_b12_report('Intoxication_Poisoning')+165926,
                              'labour_data_td' => $this->Dashboard_model_final->get_b12_report('Labour_Pregnancy')+1216628,
                              'light_data_td' => $this->Dashboard_model_final->get_b12_report('Lighting_Electrocution')+5872,
                              'mass_data_td' => $this->Dashboard_model_final->get_b12_report('Mass_casualty')+22952,
                              'report_data_td' => $this->Dashboard_model_final->get_b12_report('Medical')+3346572,
                              'trauma_data_td' => $this->Dashboard_model_final->get_b12_report('Poly_Trauma')+8601,
                              'suicide_data_td' => $this->Dashboard_model_final->get_b12_report('Suicide_Self_Inflicted_Injury')+5065,
                              'delivery_in_amb_data_td'=> $this->Dashboard_model_final->get_b12_report('Deliveries_in_Ambulance')+36647,
                              'pt_manage_on_veti_data_td' => $this->Dashboard_model_final->get_b12_report('Patient_Manage_on_Ventilator')+3755,
                              'unavail_call_data_td' => $this->Dashboard_model_final->get_b12_report('Unavailed_Call'),
                              'other_data_td'=> $this->Dashboard_model_final->get_b12_report('Others')+742866,
                              );
                              //var_dump($inc_data);die();
             // $data['header'] = $header;
             if($this->input->post('to_date') != '' && $this->input->post('from_date') != ''){
                $from_date=$this->input->post('from_date');
                $to_date=$this->input->post('to_date');
                // $closure_date_to = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") - 1, date("Y"))) ;
                $data['to_date'] = $this->input->post('to_date');
                $data['from_date'] = $this->input->post('from_date');
              
                
                 $report_args2 = array('from_date' => date('Y-m-d', strtotime($from_date)),
                                 'to_date' => date('Y-m-d', strtotime($to_date)) );
                

                              
                     $Accident_data_till = $this->inc_model->get_Accident_b12_report($report_args2);
                        
                     $assault_data_till = $this->inc_model->get_assault_b12_report($report_args2);
                     $burn_data_till = $this->inc_model->get_burn_b12_report($report_args2);
                     $attack_data_till = $this->inc_model->get_attack_b12_report($report_args2);
                     $fall_data_till = $this->inc_model->get_fall_b12_report($report_args2);
                     $poision_data_till = $this->inc_model->get_poision_b12_report($report_args2);
                     $labour_data_till = $this->inc_model->get_labour_b12_report($report_args2);
                     $light_data_till = $this->inc_model->get_light_b12_report($report_args2);
                     $mass_data_till = $this->inc_model->get_mass_b12_report($report_args2);
                     $report_data_till = $this->inc_model->get_medical_b12_report($report_args2);
                     $other_data_till = $this->inc_model->get_other_b12_report($report_args2);
                     $trauma_data_till = $this->inc_model->get_trauma_b12_report($report_args2);
                     $suicide_data_till = $this->inc_model->get_suicide_b12_report($report_args2);
                     $delivery_in_amb_data_till = $this->inc_model->get_delivery_in_amb_b12_report($report_args2);
                     $pt_manage_on_veti_data_till = $this->inc_model->get_pt_manage_on_veti_b12_report($report_args2);
                     $unavail_call_data_till = $this->inc_model->get_pt_manage_on_unavail_report($report_args2); 
            
                     $inc_data[0]['Accident_data'] = $Accident_data_till[0]->total_count;
                     $inc_data[0]['assault_data'] = $assault_data_till[0]->total_count;
                     $inc_data[0]['burn_data'] = $burn_data_till[0]->total_count;
                     $inc_data[0]['attack_data'] = $attack_data_till[0]->total_count;
                     $inc_data[0]['fall_data'] = $fall_data_till[0]->total_count;
                     $inc_data[0]['poision_data'] = $poision_data_till[0]->total_count;
                     $inc_data[0]['labour_data'] = $labour_data_till[0]->total_count;
                     $inc_data[0]['light_data'] = $light_data_till[0]->total_count;
                     $inc_data[0]['mass_data'] = $mass_data_till[0]->total_count;
                     $inc_data[0]['report_data'] = $report_data_till[0]->total_count;
                     $inc_data[0]['other_data'] = $other_data_till[0]->total_count;
                     $inc_data[0]['trauma_data'] = $trauma_data_till[0]->total_count;
                     $inc_data[0]['suicide_data'] = $suicide_data_till[0]->total_count;
                     $inc_data[0]['delivery_in_amb_data'] = $delivery_in_amb_data_till[0]->total_count;
                     $inc_data[0]['pt_manage_on_veti_data'] = $pt_manage_on_veti_data_till[0]->total_count;
                     $inc_data[0]['unavail_call_data'] = $unavail_call_data_till[0]->total_count;
             }
          
              $data['inc_data'] = $inc_data;
              
              $data['clg_ref_id'] = $this->clg->clg_ref_id;
               if($this->input->post('to_date') != '' && $this->input->post('from_date') != ''){
                    $this->output->add_to_position($this->load->view('frontend/dash/nhm_b12_reports_view', $data, TRUE), 'b12_data_block', TRUE); 
               }else{
              $this->output->add_to_position($this->load->view('frontend/dash/nhm_b12_reports_view', $data, TRUE), 'content', TRUE);
               }
             $this->output->template = "nhm_blank";
         }
        public function nhm_live_calls_dash(){	

            $data =array();
            $to_date = date('Y-m-d').' 23:59:59';
            $from_date = date('Y-m-d').' 00:00:00';
            $arg_today_noneme = array('date_type'=>'tm','to_date'=>$to_date,'from_date'=>$from_date,'type'=>'eme');
            $data['today_non_eme'] = $this->Dashboard_model_final->get_total_call_type($arg_today_noneme);
            
            /*$dashboard_count = $this->Dashboard_model_final->get_total_calls_frm_dashboard_tbl();
            $closure_today = $this->Dashboard_model_final->get_total_closed_calls_today();
            $data['total_closure_td'] = $dashboard_count[0]['closure_till_date']+$closure_today+6167466;
            $data['total_closure_tm'] = $dashboard_count[0]['closure_till_month']+$closure_today;
            */
            $data['total_nhm_data'] = $this->Dashboard_model_final->get_total_data();
           // var_dump($dashboard_count);die();
            //$data['total_closure_td'] = $dashboard_count['b12_key_till_date']+6176511;
            //$data['total_closure_tm'] = $dashboard_count['b12_key_till_month'];
            
             
            $this->output->add_to_position($this->load->view('frontend/dash/NHM_dash_view', $data, TRUE), 'content', TRUE);
            $this->output->template = "nhm_blank";
    	}
    public function nhm_districtwise_emergency_patients_served_dash()
    {   


         //Till Month
         $From_date = date('Y-m-01');
         $to_date = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") - 1, date("Y")));
         $report_args_till_month = array(
             'from_date' => date('Y-m-d', strtotime($From_date)),
             'to_date' => date('Y-m-d', strtotime($to_date)),
             'system_type' => '108'
             );
         $Accident_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('15','58'));
         $assault_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('6'));
         $burn_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('14'));
         $attack_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('8','9','10'));
         $fall_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('54'));
         $poision_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('13','23','50'));
         $labour_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('24','34'));
         $light_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('55'));
         $mass_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('56'));
         $report_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('1','3','4','5','7','16','17','18','19','20','22','25','26','27','28','29','30','31','32','37','38','39','47','48','49','51','52','53'));
         $other_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('2','21','35','36','45','46'));
         $trauma_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('33'));
         $suicide_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('40'));
         $delivery_in_amb_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('11','12'));
         $pt_manage_on_veti_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('57'));
         $unavail_call_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('41','42','43','44'));
             
         $Accident_data_tm = $Accident_data_tm[0]->total_count;
             $assault_data_tm = $assault_data_tm[0]->total_count;
             $burn_data_tm = $burn_data_tm[0]->total_count;
             $attack_data_tm = $attack_data_tm[0]->total_count;
             $fall_data_tm = $fall_data_tm[0]->total_count;
             $poision_data_tm = $poision_data_tm[0]->total_count;
             $labour_data_tm = $labour_data_tm[0]->total_count;
             $light_data_tm = $light_data_tm[0]->total_count;
             $mass_data_tm = $mass_data_tm[0]->total_count;
             $report_data_tm = $report_data_tm[0]->total_count;
             $trauma_data_tm = $trauma_data_tm[0]->total_count;
             $suicide_data_tm = $suicide_data_tm[0]->total_count;
             $delivery_in_amb_data_tm= $delivery_in_amb_data_tm[0]->total_count;
             $pt_manage_on_veti_data_tm = $pt_manage_on_veti_data_tm[0]->total_count;
             $unavail_call_data_tm = $unavail_call_data_tm[0]->total_count;
             $other_data_tm= $other_data_tm[0]->total_count;

             $data['total_dist_closure_tm'] = $Accident_data_tm + $assault_data_tm + $burn_data_tm + $attack_data_tm + $fall_data_tm + $poision_data_tm + $labour_data_tm + $light_data_tm + $mass_data_tm + $report_data_tm + $other_data_tm + $trauma_data_tm + $suicide_data_tm + $delivery_in_amb_data_tm + $pt_manage_on_veti_data_tm;
            // var_dump($data['total_dist_closure_tm']);die;
        $data['total_nhm_data']=$this->Dashboard_model_final->get_total_data();
        $dispatch_pt_count = $this->Dashboard_model_final->get_total_dispatch_patient();
        $data['today_dispatch_patient_ct'] = $dispatch_pt_count[0]['pt_count'];
        $this->output->add_to_position($this->load->view('frontend/dash/nhm_dist_patient_served_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "nhm_blank";
    }
     public function nhm_live_calls_dash_vew(){	
            die();
            $data['total_calls_td'] = $this->Dashboard_model_final->get_total_calls_108();
            $data['total_calls_td_102'] = $this->Dashboard_model_final->get_total_calls_102();

            $data['total_calls_tm'] = $this->Dashboard_model_final->get_total_calls_curr_month_108();
            $data['total_calls_tm_102'] = $this->Dashboard_model_final->get_total_calls_curr_month_102();

            $data['non_eme_td'] = $this->Dashboard_model_final->get_total_type_calls_today($cond='non-eme', $duration="td","108");
            $data['non_eme_td_102'] = $this->Dashboard_model_final->get_total_type_calls_today($cond='non-eme', $duration="td","102");

            $data['non_eme_tm'] = $this->Dashboard_model_final->get_total_type_calls_today($cond='non-eme', $duration="tm","108");
            $data['non_eme_tm_102'] = $this->Dashboard_model_final->get_total_type_calls_today($cond='non-eme', $duration="tm","102");

            $data['eme_calls_td'] = $this->Dashboard_model_final->get_total_type_calls_today($cond='eme', $duration="td","108");
            $data['eme_calls_td_102'] = $this->Dashboard_model_final->get_total_type_calls_today($cond='eme', $duration="td","102");

            $data['eme_calls_tm'] = $this->Dashboard_model_final->get_total_type_calls_today($cond='eme', $duration="tm","108");
            $data['eme_calls_tm_102'] = $this->Dashboard_model_final->get_total_type_calls_today($cond='eme', $duration="tm","102");

            $data['total_dispatch_all']=$data['eme_calls_td'];
            $data['total_dispatch_tm']=$data['eme_calls_tm'];

            $data['total_dispatch_all_102']=$data['eme_calls_td_102'];
            $data['total_dispatch_tm_102']=$data['eme_calls_tm_102'];
          
            $args['from_date'] = '2019-11-12 11:45:34';
            $args['live_from_date'] = '2020-03-23 23:59:59';
            $args['to_date'] = date('Y-m-d').' 23:59:59';
            $args['system_type'] = '108';
            
            $args_102['from_date'] = '2019-11-12 11:45:34';
            $args_102['live_from_date'] = '2020-03-23 23:59:59';
            $args_102['to_date'] = date('Y-m-d').' 23:59:59';
            $args_102['system_type'] = '102';

            //$data['total_calls_emps_td'] = $this->Dashboard_model_final->closure_till_date($args);
            //$data['total_calls_emps_td_102'] = $this->Dashboard_model_final->closure_till_date($args_102);
            
            $args_tm['live_from_date'] = date('Y-m-01').' 23:59:59';
            $args_tm['to_date'] = date('Y-m-d').' 23:59:59';
            $args_tm['system_type'] = '108';
            
            $args_tm_102['live_from_date'] = date('Y-m-01').' 23:59:59';
            $args_tm_102['to_date'] = date('Y-m-d').' 23:59:59';
            $args_tm_102['system_type'] = '102';

            //$data['total_calls_emps_tm'] = $this->Dashboard_model_final->closure_till_date($args_tm);
            //$data['total_calls_emps_tm_102'] = $this->Dashboard_model_final->closure_till_date($args_tm_102);
            
            $data['total_calls_emps_tm']= districtwise_emergency_patients('', 'thismonth', '108'); 
            $data['total_calls_emps_td']= districtwise_emergency_patients('', 'tillDate', '108'); 
            
            $data['total_calls_emps_tm_102']= districtwise_emergency_patients('', 'thismonth', '102'); 
            $data['total_calls_emps_td_102']= districtwise_emergency_patients('', 'tillDate', '102'); 
            
            $data['total_calls_ptn_served_tm']= districtwise_emergency_patients_served('', 'thismonth', '108'); 
            $data['total_calls_ptn_served_td']= districtwise_emergency_patients_served('', 'tillDate', '108'); 
            
            $data['total_calls_ptn_served_tm_102']= districtwise_emergency_patients_served('', 'thismonth', '102'); 
            $data['total_calls_ptn_served_td_102']= districtwise_emergency_patients_served('', 'tillDate', '102'); 
             
              
            echo json_encode($data);
            exit;
      
    	}
    function nhm_division_view(){
        $division_data=$this->Dashboard_model_final->get_div_data();  
            foreach($division_data as $division){
            $args = array('division_code'=> $division->div_code);
            $division_total_data =$this->Dashboard_model_final->get_total_division_data($args);
            foreach($division_total_data as $div){
                $dispatch_today_108 = $div->dispatch_today_108;
                $patient_served_tm = $div->patient_served_tm;
                $patient_served_td = $div->patient_served_td + $div->patient_servedold_td;
                $patient_served_today = $div->patient_served_today;
            }
            $div_data[$division->div_code] = array('div_name'=>$division->div_name,
                                                    'div_code'=>$division->div_code,
                                                    'dispatch_today_108'=>$dispatch_today_108,
                                                    'patient_served_tm'=>$patient_served_tm,
                                                    'patient_served_td'=>$patient_served_td,
                                                    'patient_served_today'=>$patient_served_today,
                                                    
                                                );
            $data['div_data'] = $div_data;
            }
       // var_dump($data);die();
        $this->output->add_to_position($this->load->view('frontend/dash/NHM_division_view', $data, TRUE), 'division_view', TRUE);
    }
    function nhm_district_view(){
        //$div_code = $this->input->post('div_code');
        $dst_state = $this->input->post('dst_state');
        $args = array('dst_state'=> $dst_state);
       // $args = array('division_code'=> $div_code);
        $district_data=$this->Dashboard_model_final->get_dis_data_new($args);  
        foreach($district_data as $dis){
            $args = array('dst_code' =>$dis->dst_code );
            $args2 = array('district_id' =>$dis->dst_code );

            $district_total_data =$this->Dashboard_model_final->get_total_district_data($args);
            foreach($district_total_data as $district){
                $dispatch_today_108 = $district->dispatch_today_108;
                // $patient_served_tm = $district->patient_served_tm;
                $patient_served_td = $district->patient_served_td+$district->patient_servedold_td + $district->patient_servedold1_td;
                //$patient_served_today = $district->patient_served_today;
            }

            $district_wise_total_data =$this->inc_model->get_total_district_data_validate($args2);
            foreach($district_wise_total_data as $district_wise){
                $patient_served_tm = $district_wise->total_count ;
            }
            $dispatch_pt_count = $this->Dashboard_model_final->get_total_dispatch_patient_dist($args);
            $patient_served_today = $dispatch_pt_count[0]['pt_count'];

            $dis_data[$dis->dst_code] = array('dst_name'=>$dis->dst_name,
                                              'dst_code'=>$dis->dst_code,
                                              'dispatch_today_108'=>$dispatch_today_108,
                                              'patient_served_tm'=>$patient_served_tm,
                                              'patient_served_td'=>$patient_served_td,
                                              'patient_served_today'=>$patient_served_today,
                                            );
            $data['dis_data'] = $dis_data;
            $patient_served_today=0;

        }
        $this->output->add_to_position($this->load->view('frontend/dash/NHM_district_view', $data, TRUE), 'district_view', TRUE);
    }
    function nhm_ambulance_view(){
        $dst_code = $this->input->post('dst_code');
        $args = array('dst_code'=> $dst_code);
        $amb_data=$this->Dashboard_model_final->get_ambulance_data($args);  
        foreach($amb_data as $amb){
            $args = array('div_code'=> $div_code,'dst_code' =>$amb->dst_code,'amb_rto_register_no'=>$amb->amb_rto_register_no );

            $amb_total_data =$this->Dashboard_model_final->get_total_amb_data($args);
            
            $patient_served_today = 0;
                $patient_served_tm =0;
                $patient_served_td = 0;

            foreach($amb_total_data as $total_data_new){
                $patient_served_today=0;
               $patient_served_today = $total_data_new->patient_served_today;
                $patient_served_tm = $total_data_new->patient_served_tm;
                $patient_served_td = $total_data_new->patient_served_td;
            }
            
           $amb = array('amb_rto_register_no'=>$amb->amb_rto_register_no,
                                             'hp_name'=>$amb->hp_name,
                                             'amb_id'=>$amb->amb_id,
                                             'dst_code'=>$dst_code,
                                              'patient_served_today'=>$patient_served_today,
                                              'patient_served_tm'=>$patient_served_tm,
                                              'patient_served_td'=>$patient_served_td,
                                                
                                            );
            $data['amb_data'][] = $amb;
        }
       
          
        $this->output->add_to_position($this->load->view('frontend/dash/NHM_ambulance_view', $data, TRUE), 'ambulance_view', TRUE);
    }
    public function nhm_total_dist_travelled_by_amb(){
        $data['amb_data']=$this->Dashboard_model_final->get_dist_travel_data();
        $this->output->add_to_position($this->load->view('frontend/dash/nhm_total_dist_travel_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "nhm_blank";
    }
    public function nhm_total_distance_travelled_by_ambulance_dash()
    {
        $data['district_names']=$this->Dashboard_model_final->get_districts_names1();
        $this->output->add_to_position($this->load->view('frontend/dash/nhm_total_dist_travel_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "nhm_blank";
    }
        function nhm_division(){

            // $clg_group =  $this->clg->clg_group;
            // if( $clg_group == 'UG-Dashboard1')
            // {
            //    $division='';
            // }
            // else{
            //     $division = $this->clg->clg_zone;
            //     $district_id = $this->clg->clg_district_id;
            // }
            // $district_id = explode( ",", $district_id);
            // $regex = "([\[|\]|^\"|\"$])"; 
            //  $replaceWith = ""; 
            // $district_id = preg_replace($regex, $replaceWith, $district_id);
            // if(is_array($district_id)){
            //     $district_id = implode("','",$district_id);
            // }
         
            $args = array('st_code'=>'MP','div_code'=>$division,'district_id'=>$district_id);
           $district_data = $this->Dashboard_model_final->get_division($args);
           // var_dump($district_data);die();
            $total_beds =0;
                $c19_total_bed =0;
                $C19_Occupied=0;
                $C19_Vacant =0;
    
                $non_c19_total_bed =0;
                $NonC19_Occupied=0;
                $NonC19_Vacant=0;
            foreach($district_data as $district){
    
                if( $clg_group == 'UG-Dashboard1')
                {
                    $args_bed = array('district_id'=>$district->dst_code, 'division_id'=> $district->div_code);
                    //var_dump($args_bed);die();
                }
                
               // var_dump($district_id);
                //$district_total_bed =$this->bed_model->get_total_bed_division($args_bed);
                
                                
                $total_beds =0;
                $c19_total_bed =0;
                $C19_Occupied=0;
                $C19_Vacant =0;
    
                $non_c19_total_bed =0;
                $NonC19_Occupied=0;
                $NonC19_Vacant=0;
            
                // foreach($district_total_bed as $bed){
    
                    
                //     $total_beds =$total_beds + $bed->C19_Total_Beds + $bed->NonC19_Total_Beds;
    
                //     $c19_total_bed = $c19_total_bed + $bed->C19_Total_Beds;
                //     $C19_Occupied= $C19_Occupied + $bed->C19_Occupied;
                //     $C19_Vacant= $C19_Vacant + $bed->C19_Vacant;
    
                //     $non_c19_total_bed = $non_c19_total_bed + $bed->NonC19_Total_Beds;
                //     $NonC19_Occupied = $NonC19_Occupied + $bed->NonC19_Occupied;
                //     $NonC19_Vacant = $NonC19_Vacant + $bed->NonC19_Vacant;
    
                    
                // }
                
                    $district_bed[$district->div_code] = array('div_name'=>$district->div_name,
                    'div_code'=>$district->div_code
                    // 'total_beds'=>$total_beds,
                    // 'c19_total_bed'=>$c19_total_bed,
                    // 'C19_Occupied'=>$C19_Occupied,
                    // 'C19_Vacant'=>$C19_Vacant,
                    
                    // 'non_c19_total_bed'=>$non_c19_total_bed,
                    // 'NonC19_Occupied'=>$NonC19_Occupied,
                    // 'NonC19_Vacant'=>$NonC19_Vacant,
                
                    
                ); 
            }
             $data['district_bed'] = $district_bed;
            $this->output->add_to_position($this->load->view('dashboard/division_view', $data, TRUE), 'content', TRUE);
           //echo "hi";die;
        }
    function responce_time(){
            
             $this->output->add_to_position($this->load->view('frontend/dash/responce_time_view', $data, TRUE), 'content', TRUE);
             $this->output->template = "nhm_blank";
        }
        function biomedical_data(){
            
            $this->output->add_to_position($this->load->view('frontend/dash/biomedical_data_view', $data, TRUE), 'content', TRUE);
            $this->output->template = "nhm_blank";
       }
         function show_responce_time(){
            $from_date =  date('Y-m-d',strtotime($this->input->post('rtd_date')));
            
            $args = array('from_date'=>$from_date);
            $data['rtd_data'] = $this->rtd_model->get_rtd_data($args);
            
             $this->output->add_to_position($this->load->view('frontend/dash/show_responce_time_view', $data, TRUE), 'list_table', TRUE);
             $this->output->template = "nhm_blank";
        }
        
        function ambulance_tracking(){
            $thirdparty = $this->clg->thirdparty;
            $clg_group = $this->clg->clg_group;
            $district = $this->clg->clg_district_id;
            $clg_district_id = json_decode($district);
            if(is_array($clg_district_id)){
                $clgdistrict_id = implode("','",$clg_district_id);
            }
            $data['amb_type'] = $this->common_model->get_ambulance_type();
            $args = array('district_id'=>'518');
            $data['live_amb'] = $this->Dashboard_model->get_amb_tracking_data();
            $data['thirdparty']=$thirdparty;
            $data['clg_group'] = $clg_group;
            $data['clgdistrict_id']=$clgdistrict_id;

            $amb_type =  'all';
            $args = array('amb_type' => $amb_type,'thirdparty'=>$this->clg->thirdparty);
            $data['amb_data'] = $this->amb_model->get_amb_data1($args);
            $this->output->add_to_position('', 'call_detail', TRUE);
            $data['dist'] = $this->common_model->get_district(array('st_id' => 'MP'));
            
            $this->output->add_to_position($this->load->view('frontend/dash/ambulance_tracking_view', $data, TRUE), 'content', TRUE);
            $this->output->template = "nhm_blank";
        }
        function show_ambulance_tracking(){
            
            $system =  $this->input->post('system');
            $dist =  $this->input->post('amb_district');
            
            $args = array('amb_user' => $system,'amb_district'=>$dist);
            
            $data['amb_data'] = $this->amb_model->get_amb_data($args);
          

            $this->output->add_to_position($this->load->view('frontend/dash/show_ambulance_tracking_view', $data, TRUE), 'list_table_amb', TRUE);
             $this->output->template = "nhm_blank";
        }
        function track_amb(){
            $data['amb_reg'] =  $this->input->post('amb_reg');
            $this->output->add_to_position($this->load->view('frontend/dash/track_amb_view', $data, TRUE), 'popup_div', TRUE);
        }     
        public function amb_tracking(){
            $data['dist'] = $this->common_model->get_district(array('st_id' => 'MP'));
            $args = array('district_id'=>'518');
            $data['live_amb'] = $this->Dashboard_model->get_amb_tracking_data();
            $this->load->view('templates/header');
            $this->load->view('dashboard/amb_tracking_view',$data);
            $this->load->view('templates/footer');
            $this->output->template = "nhm_blank";
        }
        public function nhm_amb_tracking_remote(){
            
            $thirdparty = $this->clg->thirdparty;
            $clg_group = $this->clg->clg_group;
            $district = $this->clg->clg_district_id;
            $clg_district_id = json_decode($district);
            if(is_array($clg_district_id)){
                $clgdistrict_id = implode("','",$clg_district_id);
            }
            $data['amb_type'] = $this->common_model->get_ambulance_type();
            $args = array('district_id'=>'518');
            $data['live_amb'] = $this->Dashboard_model->get_amb_tracking_data();
            $data['thirdparty']=$thirdparty;
            $data['clg_group'] = $clg_group;
            $data['clgdistrict_id']=$clgdistrict_id;

            $amb_type =  'all';
            $args = array('amb_type' => $amb_type,'thirdparty'=>$this->clg->thirdparty);
            $data['district_data'] = $this->common_model->get_district(array('st_id' => 'MP'));
            // $data['amb_data'] = $this->amb_model->get_amb_data1($args);
            // print_r($data['amb_data']);die;
            $this->output->add_to_position('', 'call_detail', TRUE);
            $this->output->add_to_position($this->load->view('dashboard/amb_tracking_remote_dash', $data, TRUE), 'content', TRUE);
            $this->output->template = "blank";
        }
        function nhm_amb_report_dash(){
            $thirdparty = $this->clg->thirdparty;
            $amb_arg = array('thirdparty' => $thirdparty,'district_id'=> '518');
           // $data['amb_data'] = $this->amb_model->get_nhm_amb_data($amb_arg);
            // $data['total_mdt'] = count($this->amb_model->get_total_mdt()); 
           // var_dump(  $data['total_mdt']);die();
            $data['dist'] = $this->common_model->get_district(array('st_id' => 'MP'));
            // var_dump( $data['dist']);die();
                        $total_mdt = count($this->amb_model->get_total_mdt());

            $current_date = date('Y-m-d');
            $data['current_date']=$current_date;
            $select_time = get_current_select_time(date('H'));
            $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)) ,'select_time'=>$select_time);
            $data['amb_data_offroad'] = $this->amb_model->total_offroad($report_args);
            $data['amb_data_onroad'] = $this->amb_model->total_onroad($report_args);
            if(empty($data['amb_data_onroad'])){
            $data['current_date']=date('Y-m-d', strtotime('-1 day', strtotime($current_date)));
            $current_date = $data['current_date'];
            $report_args = array('from_date'=>date('Y-m-d', strtotime('-1 day', strtotime($current_date))) ,'select_time'=>$select_time);
            
            $total_offroad = $this->amb_model->total_offroad($report_args);
            $total_offroad_new = $total_offroad[0]->total_offroad;
            
            $total_onroad = $this->amb_model->total_onroad($report_args);
            $total_onroad_new = $total_onroad[0]->total_onroad;

            }

            $total_offroad = $this->amb_model->total_offroad($report_args);
            $total_offroad_new = $total_offroad[0]->total_offroad;
            
            $total_onroad = $this->amb_model->total_onroad($report_args);
            $total_onroad_new = $total_onroad[0]->total_onroad;
            

            // var_dump($total_onroad_new);die();
                $data['total_record'] = array('total_mdt'=>$total_mdt,
                                              'total_amb' => $total_offroad_new+$total_onroad_new,
                                              'total_offroad_new' => $total_offroad_new,
                                              //'total_onroad'=>$total_onroad,
                                              'total_onroad_new'=>$total_onroad_new);
               

            $this->load->view('dashboard/nhm_amb_report_view',$data);
            $this->output->template = "nhm_blank"; 

        }
        public function nhm_amb_report_remote_download(){
            $report_args =  $this->input->post();
             // var_dump($this->input->post());die();
              if(!empty($report_args)){
              $from_date =  date('Y-m-d', strtotime($this->input->post('from_date_download')));
              $to_date =  date('Y-m-d', strtotime($this->input->post('to_date_download')));
            }
           
            $thirdparty = $this->clg->thirdparty;
              $amb_arg = array(
                 'thirdparty' => $thirdparty,'district_id'=> '518',
                 'from_date' => $from_date,
                 'to_date' => $to_date
              );
              
            $amb_data = $this->amb_model->get_nhm_amb_data($amb_arg);
            $filename = "Ambulance_Report.csv";
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            $header = array('Ambulance No','Base Location','Pilot Name','Current Status','Pilot Login Time','Pilot Logout Time');
            fputcsv($fp, $header);
            foreach ($amb_data as $amb){
                $clg_data_p =  get_emso_name($amb->amb_rto_register_no,'P');
                $clg_data_d =  get_emso_name($amb->amb_rto_register_no,'D');

                if($clg_data_p[0]->status==2){
                $Login_status_p = 'Logout';
                }else if($clg_data_p[0]->status==1){
                $Login_status_p = 'Login';
                }
                if($clg_data_d[0]->status==2){
                $Login_status_d = 'Logout';
                }else if($clg_data_d[0]->status==1){
                $Login_status_d = 'Login';
                }
                if($amb->amb_status == 2 ){ 
                    $data = array(
                        'Ambulance No' => $amb->amb_rto_register_no,
                        'Base Location' => $amb->baselocation,
                        'Pilot Name' => $clg_data_d[0]->clg_first_name.' '.$clg_data_d[0]->clg_last_name,
                        'Current Status' => $Login_status_d,
                        'Pilot Login Time' => $clg_data_d[0]->login_time,
                        'Pilot Logout Time' => $clg_data_d[0]->logout_time
                    );
                    fputcsv($fp, $data);
                }else{
                    $data = array(
                        'Ambulance No' => $amb->amb_rto_register_no,
                        'Base Location' => $amb->baselocation,
                        'Pilot Name' => $clg_data_d[0]->clg_first_name.' '.$clg_data_d[0]->clg_last_name,
                        'Current Status' => $Login_status_d,
                        'Pilot Login Time' => $clg_data_d[0]->login_time,
                        'Pilot Logout Time' => $clg_data_d[0]->logout_time
                    );
                    fputcsv($fp, $data);
                }
            }
            fclose($fp);
            exit;
        }
        public function nhm_amb_report_remote1(){
            
            /* $district = $this->clg->clg_district_id;
              $clg_district_id = json_decode($district);
              if(is_array($clg_district_id)){
                  $district_id = implode("','",$clg_district_id);
              }*/
              $report_args =  $this->input->post();
             // var_dump($this->input->post());die();
              if(!empty($report_args)){
              $from_date =  date('Y-m-d', strtotime($this->input->post('amb_report_from_date')));
              $to_date =  date('Y-m-d', strtotime($this->input->post('amb_report_to_date')));
              
            }
            
                  $thirdparty = $this->clg->thirdparty;
              $amb_arg = array(
                 'thirdparty' => $thirdparty,'district_id'=> '518',
                 'from_date' => $from_date,
                 'to_date' => $to_date
              );
              
              $data['amb_data'] = $this->amb_model->get_nhm_amb_data($amb_arg);
             // var_dump( $data['amb_data']);
             // die();
              //$this->output->add_to_position('', 'call_detail', TRUE);
              $data['from_date']=$from_date;
              $data['to_date']=$to_date;
              $this->output->add_to_position($this->load->view('dashboard/nhm_remote_amb_report_view1', $data, TRUE), 'list_table_amb_div1', TRUE);
              $this->output->template = "blank";
              
          }
        public function nhm_amb_report_remote(){
          
            $report_args =  $this->input->post();
            if(!empty($report_args)){
            $from_date =  date('Y-m-d', strtotime($this->input->post('amb_report_from_date')));
            $to_date =  date('Y-m-d', strtotime($this->input->post('amb_report_to_date')));
            }
            $thirdparty = $this->clg->thirdparty;
            $amb_arg = array(
               'thirdparty' => $thirdparty,'district_id'=> '518',
               'from_date' => $from_date,
               'to_date' => $to_date
            );
           $data['amb_data'] = $this->amb_model->get_nhm_amb_data($amb_arg);
           $this->output->add_to_position($this->load->view('dashboard/nhm_remote_amb_report_view', $data, TRUE), 'content', TRUE);
            $this->output->template = "blank";
        }
        public function nhm_amb_tracking(){
            $data['dist'] = $this->common_model->get_district(array('st_id' => 'MP'));
            $args = array('district_id'=>'518');
            $data['live_amb'] = $this->Dashboard_model->get_amb_tracking_data();
            $this->load->view('templates/header_dash');
            $this->load->view('dashboard/amb_tracking_view',$data);
            $this->load->view('templates/footer');
            $this->output->template = "nhm_blank";
        }
        function nhm_amb_report(){
            /*$data['dist'] = $this->common_model->get_district(array('st_id' => 'MP'));
            $args = array('district_id'=>'518');
            $data['live_amb'] = $this->Dashboard_model->get_amb_tracking_data();

            
            //Report View
            $thirdparty = $this->clg->thirdparty;
            $amb_type = $this->input->post('amb_type');
            $amb_reg = $this->input->post('amb_reg');

            $district = $this->clg->clg_district_id;
            $clg_district_id = json_decode($district);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
            if($amb_reg != ''){
                $amb_arg['amb_rto_register']=$amb_reg;
            }
            $amb_arg = array('thirdparty' => $thirdparty,'district_id'=>$district_id);
            $data['amb_data'] = $this->amb_model->get_tracking_amb_data($amb_arg);
            
            $amb_arg_login = array('thirdparty' => $thirdparty,'status'=>1,'get_count'=>TRUE);
            if($amb_type != ''){
                $amb_arg_login['amb_type']=$amb_type;
            }
            if($amb_reg != ''){
                $amb_arg_login['amb_rto_register']=$amb_reg;
            }
            $data['login_count'] = $this->amb_model->get_amb_login_status_dist_wise($amb_arg_login);
            $amb_arg = array('thirdparty' => $thirdparty,'status'=>2,'get_count'=>TRUE);
            if($amb_type != ''){
                $amb_arg['amb_type']=$amb_type;
            }
            if($amb_reg != ''){
                $amb_arg['amb_rto_register']=$amb_reg;
            }
            $data['logout_count'] = $this->amb_model->get_amb_login_status_dist_wise($amb_arg);
            
            $thirdparty=$this->clg->thirdparty;
            $data['amb_list'] = $this->common_model->get_ambulance(array('thirdparty'=> $thirdparty));
          
            $header = array('Ambulance No','Ambulance Type','Ambulance Status','Login Details','Incident ID','Time'); 
            $data['header'] = $header;
           
            $this->output->add_to_position($this->load->view('frontend/bed/nhm_remote_vehical_status', $data, TRUE), $output_position , TRUE);
            $this->output->template = "nhm_blank"; 
            */
           // $amb_arg = array('district_id'=>'518');
           $thirdparty = $this->clg->thirdparty;
          /* $district = $this->clg->clg_district_id;
            $clg_district_id = json_decode($district);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }*/
           $amb_arg = array('thirdparty' => $thirdparty,'district_id'=> '518');
            $data['amb_data'] = $this->amb_model->get_nhm_amb_data($amb_arg);
            $data['dist'] = $this->common_model->get_district(array('st_id' => 'MP'));
            $this->load->view('templates/header_dash');
            $this->load->view('dashboard/nhm_amb_report_view',$data);
            $this->load->view('templates/footer');
            $this->output->template = "nhm_blank";  
        }
        function nhm_amb_report1(){
            //var_dump( $this->input->post());die();
            // $amb_report_from_date =  $this->input->post('amb_report_from_date');
            // $amb_report_to_date =  $this->input->post('amb_report_to_date');
            $amb_district =  $this->input->post('amb_district');
            // $args['district_id'] =$data['district_id'] = $amb_district;
            $total_mdt = count($this->amb_model->get_total_mdt());

            $current_date = date('Y-m-d');
            $data['current_date']=$current_date;
            $select_time = get_current_select_time(date('H'));
            $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)) ,'select_time'=>$select_time);
            $data['amb_data_offroad'] = $this->amb_model->total_offroad($report_args);
            $data['amb_data_onroad'] = $this->amb_model->total_onroad($report_args);
            if(empty($data['amb_data_onroad'])){
            $data['current_date']=date('Y-m-d', strtotime('-1 day', strtotime($current_date)));
            $current_date = $data['current_date'];
            $report_args = array('from_date'=>date('Y-m-d', strtotime('-1 day', strtotime($current_date))) ,'select_time'=>$select_time);
            
            $total_offroad = $this->amb_model->total_offroad($report_args);
            $total_offroad_new = $total_offroad[0]->total_offroad;
            
            $total_onroad = $this->amb_model->total_onroad($report_args);
            $total_onroad_new = $total_onroad[0]->total_onroad;

            }

            $total_offroad = $this->amb_model->total_offroad($report_args);
            $total_offroad_new = $total_offroad[0]->total_offroad;
            
            $total_onroad = $this->amb_model->total_onroad($report_args);
            $total_onroad_new = $total_onroad[0]->total_onroad;
            

            // var_dump($total_onroad_new);die();
                $data['total_record'] = array('total_mdt'=>$total_mdt,
                                              'total_amb' => $total_offroad_new+$total_onroad_new,
                                              'total_offroad_new' => $total_offroad_new,
                                              //'total_onroad'=>$total_onroad,
                                              'total_onroad_new'=>$total_onroad_new);
               

             $thirdparty = $this->clg->thirdparty;

            $args = array('district_id' => $amb_district,'thirdparty'=>$this->clg->thirdparty );
            //$args = array('district_id' => $amb_district );
            $data['amb_data'] = $this->amb_model->get_nhm_amb_data($args);
            $amb_data=$data['amb_data'] ;
           // $new_data['total_mdt'] = $total_mdt;
            $mdt_cnt=0;
            $data['both_login_amb'] = array();
            $data['one_login_amb'] = array();
            $data['single_login_amb'] = array();
            foreach($amb_data as $am_data) {
                $amb_no = $am_data->amb_rto_register_no;
                
                $clg_pilot = get_emso_name($amb_no,'P');
                $clg_driver = get_emso_name($amb_no,'D');
                
                if($clg_pilot){
                    $am_data->clg_data_p = $clg_pilot[0]->clg_first_name.' '.$clg_pilot[0]->clg_last_name;
                    $am_data->clg_datamobno_p = $clg_pilot[0]->clg_mobile_no;
                    $am_data->clg_data_p_status = $clg_pilot[0]->status;
                    $am_data->clg_data_p_login_time = date("Y-m-d g:iA", strtotime($clg_pilot[0]->login_time));
                   // $am_data->clg_data_p_login_time = $clg_pilot[0]->login_time;
                    $am_data->clg_data_p_logout_time = $clg_pilot[0]->logout_time;
                }else{
                    $am_data->clg_data_p = '';
                    $am_data->clg_datamobno_p = '';
                    $am_data->clg_data_p_status = '';
                    $am_data->clg_data_p_login_time = '';
                    $am_data->clg_data_p_logout_time = '';

                }
                if($clg_driver){
                    $am_data->clg_data_d= $clg_driver[0]->clg_first_name.' '.$clg_driver[0]->clg_last_name;
                    $am_data->clg_datamobno_d= $clg_driver[0]->clg_mobile_no;
                    $am_data->clg_data_d_status = $clg_driver[0]->status;
                    $am_data->clg_data_d_login_time = date("Y-m-d g:iA", strtotime($clg_driver[0]->login_time));
                    $am_data->clg_data_d_logout_time = $clg_driver[0]->logout_time;
                }else{
                    $am_data->clg_data_d= '';
                    $am_data->clg_datamobno_d= '';
                    $am_data->clg_data_d_status = '';
                    $am_data->clg_data_d_login_time = '';
                    $am_data->clg_data_d_logout_time = '';

                }

                //if($clg_pilot[0]->status == '1' && $clg_driver[0]->status == '1' ){
                   
                    $data['both_login_amb'][] = $am_data;
                    
                /*}else if($clg_pilot[0]->status == '2' && $clg_driver[0]->status == '2' ){
                  
                    $data['no_login_amb'][] = $am_data;
                  
                }else{
                    $data['single_login_amb'][] = $am_data;
                }*/
            }
           // array_push($b,$a);
          //  $new_data = array('')
            $this->output->add_to_position($this->load->view('dashboard/mdt_amb_report_view', $data, TRUE), 'live_tracking_view', TRUE);
            $this->output->template = "nhm_blank";
            //var_dump($new_data);
            //echo json_encode($new_data);
           // die();
        }
        
        function show_ambulance_tracking_remote(){
            $amb_type =  $this->input->post('amb_type');
            $amb_reg_id =  $this->input->post('amb_reg_id');
            $args = array('amb_type' => $amb_type,'amb_id'=>$amb_reg_id,'thirdparty'=>$this->clg->thirdparty);
            $data['amb_data'] = $this->amb_model->get_amb_data1($args);
            // print_r($data['amb_data']);die;
            echo json_encode($data['amb_data']);
            die();
        }
        function show_ambulance_tracking1(){
            
            $system =  $this->input->post('system');
            $dist =  $this->input->post('amb_district');
            if($dist == ''){
                $dist = '518';
            }
            $args = array('amb_user' => $system,'amb_district'=>$dist,'thirdparty'=>$this->clg->thirdparty);
            
            $data['amb_data'] = $this->amb_model->get_amb_data1($args);
            echo json_encode($data['amb_data']);
            die();
    
            // $this->output->add_to_position($this->load->view('frontend/dash/show_ambulance_tracking_view', $data, TRUE), 'list_table_amb', TRUE);
            // $this->output->template = "nhm_blank";
        }
        function get_app_login_user(){
            $amb_id =  $this->input->post('amb_id');
            $data['usr_login_data'] = $this->amb_model->get_app_login_user($amb_id);
            echo json_encode($data['usr_login_data']);
            die();
        }
        function get_app_login_user_remote(){
            $amb_id =  $this->input->post('amb_id');
            $data['usr_login_data'] = $this->amb_model->get_app_login_user_remote($amb_id);
            echo json_encode($data['usr_login_data']);
            die();
        }
        function get_amb_no(){
            $amb_id =  $this->input->post('amb_id');
            $space =  $this->input->post('space');
            $data = $this->amb_model->get_amb_no($amb_id);
            if($space == 0){
                $string = str_replace(' ', '', $data);
                $string1 = str_replace('"', '', $string);
            }else{
                $string1 = str_replace('"', '', $data);
            }
            // $this->session->set_flashdata('amb',$data);
            // $data1 =  json_encode($string1);
            echo $string1;
            die();
        }

        function mdt_dtl(){
            $amb_district =  $this->input->post('amb_district');
            $amb_type = $this->input->post('amb_type');
            $clg_group = $this->clg->clg_group;
            // var_dump($amb_type);die;
            if($clg_group == 'UG-BIKE-SUPERVISOR'){
                $system = 'bike';
            }else if($clg_group == 'UG-ERO-SUPERVISOR'){
                 $system = '108';
            }
            $args = array('district_id' => $amb_district,'thirdparty'=>$this->clg->thirdparty,'amb_type'=>$amb_type,'system'=> $system);
           // var_dump($args);
          
            $data['amb_data'] = $this->amb_model->get_mdt_amb_data($args);
            $amb_data = $data['amb_data'];
            // print_r($clg_pilot);die;
            foreach($amb_data as $data) {
                $amb_no = $data->amb_rto_register_no;
                $clg_pilot = get_emso_name($amb_no,'P');
                $clg_driver = get_emso_name($amb_no,'D');
                // print_r($clg_driver);die;
                if($clg_pilot){
                    $data->clg_data_p = $clg_pilot[0]->clg_first_name.' '.$clg_pilot[0]->clg_last_name;
                    $data->clg_datamobno_p = $clg_pilot[0]->clg_mobile_no;
                    if($clg_pilot[0]->status != ''){
                    $data->clg_data_p_status = $clg_pilot[0]->status;
                    }else{
                        $data->clg_data_p_status = "-";
                    }
                    if($clg_pilot[0]->status != ''){
                    $data->clg_amb_status = $clg_pilot[0]->ambs_name;
                    }else{
                        $data->clg_amb_status = "-";
                    }
                    $data->clg_p_login_time = date("H:i:s", strtotime($clg_pilot[0]->login_time));
                    $data->clg_data_p_login_time = $clg_pilot[0]->login_time;
                    $data->clg_data_p_logout_time = $clg_pilot[0]->logout_time;
                    $data->clg_data_remark = $clg_pilot[0]->remark;
                    $clg_pilot[0]->login_time = date('Y-m-d H:i:s', strtotime($clg_pilot[0]->login_time));
                    $current_time = date('Y-m-d H:i:s');
                    // print_r($data->clg_data_p_logout_time);die;
                    $data->clg_data_als_p = $als_p;
                    // $difference = ($current_time - $p_login_time);
                    if($data->clg_data_p_status == 1 && $data->clg_data_p_logout_time == '0000-00-00 00:00:00'){
                    $datetime1 = new DateTime($clg_pilot[0]->login_time);
                    $datetime2 = new DateTime($current_time);
                    $interval = $datetime2->diff($datetime1);
                    // $hours = $interval->h;
                    // $hours = $hours + ($interval->days*24);
                    // print_r($interval);
                    // print_r($clg_pilot[0]->clg_mobile_no);
                    // print_r($data->amb_rto_register_no);die;
                    $data->clg_data_total_hrs = ($interval->format("%a")* 24) + $interval->format("%h"). " hours". $interval->format(" %i minutes ");  
                    }else{
                        $datetime1 = new DateTime($clg_pilot[0]->login_time);
                        $datetime2 = new DateTime($clg_pilot[0]->logout_time);
                        $interval = $datetime2->diff($datetime1);
                        // $hours = $interval->h;
                        // $hours = $hours + ($interval->days*24);
                        // print_r($amb_no);die;
                        // print_r($data->amb_rto_register_no);
                        $data->clg_data_total_hrs = ($interval->format("%a") * 24) + $interval->format("%h"). " hours". $interval->format(" %i minutes ");
                        // ($interval->format("%a") * 24) + $interval->format("%h"). " hours". $interval->format(" %i minutes ");  
                    }
                    // ($interval->days * 24) + $interval->h;
                    // 
                    // round((strtotime($datetime2) - strtotime($datetime1))/3600, 1);
                    // round(abs($datetime2 - $datetime1) / 60,2). " minute";
                    // print_r($data->clg_data_total_hrs);die;
                }else{
                    $data->clg_data_p = '-';
                    $data->clg_datamobno_p = '-';
                    $data->clg_data_p_status = '-';
                    $data->clg_data_p_status = '-';
                    $data->clg_p_login_time = '-';
                    $data->clg_data_p_logout_time = '-';
                    $data->clg_data_total_hrs = '-';
                    $data->clg_amb_status = '-';
                    $data->clg_data_als_p = '-';
                }
                // print_r($data);die;
                if($clg_driver){
                    $data->clg_data_d= $clg_driver[0]->clg_first_name.' '.$clg_driver[0]->clg_last_name;
                    $data->clg_datamobno_d= $clg_driver[0]->clg_mobile_no;
                    $data->clg_data_d_status = $clg_driver[0]->status;
                        if($clg_driver[0]->ambs_name != ''){
                            $data->clg_amb_status = $clg_driver[0]->ambs_name;
                        }else{
                            $data->clg_amb_status = "-";
                        }
                        if($clg_driver[0]->login_time != ''){
                            $data->clg_data_d_login_time = date("Y-m-d g:iA", strtotime($clg_driver[0]->login_time));
                        }else{
                            $data->clg_data_d_login_time = "-";
                        }
                    $data->clg_data_d_logout_time = $clg_driver[0]->logout_time;
                    $data->clg_data_remark = $clg_pilot[0]->remark;
                    $clg_driver[0]->login_time = date('Y-m-d H:i:s', strtotime($clg_driver[0]->login_time));
                    $current_time = date('Y-m-d H:i:s');
                    $data->clg_data_als_d = $als_d;
                    // $difference = ($current_time - $p_login_time);
                    if($data->clg_data_d_status == 1 && $data->clg_data_d_logout_time == '0000-00-00 00:00:00'){
                        $datetime1 = new DateTime($clg_driver[0]->login_time);
                        $datetime2 = new DateTime($current_time);
                        $interval = $datetime2->diff($datetime1);
                        // $hours = $interval->h;
                        // $hours = $hours + ($interval->days*24);
                        // print_r($interval);
                        // print_r($clg_pilot[0]->clg_mobile_no);
                        // print_r($data->amb_rto_register_no);die;
                        $data->clg_data_total_hrs = ($interval->format("%a")* 24) + $interval->format("%h"). " hours". $interval->format(" %i minutes ");  
                        }else{
                            $datetime1 = new DateTime($clg_driver[0]->login_time);
                            $datetime2 = new DateTime($clg_driver[0]->logout_time);
                            $interval = $datetime2->diff($datetime1);
                            // $hours = $interval->h;
                            // $hours = $hours + ($interval->days*24);
                            // print_r($amb_no);die;
                            // print_r($data->amb_rto_register_no);
                            $data->clg_data_total_hrs = ($interval->format("%a") * 24) + $interval->format("%h"). " hours". $interval->format(" %i minutes ");
                            // ($interval->format("%a") * 24) + $interval->format("%h"). " hours". $interval->format(" %i minutes ");  
                        }
                }else{
                    $data->clg_data_d= '';
                    $data->clg_datamobno_d= '';
                    $data->clg_data_d_status = '';
                    $data->clg_d_login_time = '';
                    $data->clg_data_d_login_time = '';
                    $data->clg_data_d_logout_time = '';
                    // $data->clg_data_total_hrs = '';
                    $data->clg_amb_status = '';
                    $data->clg_data_als_d = '';
                }

                $data->clg_data_p_status = $clg_pilot[0]->status;
                $data->clg_data_d_status = $clg_driver[0]->status;
                $data->clg_data_p_app_status = $clg_pilot[0]->app_status;
                $data->clg_data_d_app_status = $clg_driver[0]->app_status;
                
                $new_data[] = $data;
                // print_r($new_data);die;
            }

            echo json_encode($new_data);
            
            die();
        }
        function count_of(){
            $amb_district =  $this->input->post('amb_district');
            $amb_type = $this->input->post('amb_type');
            $clg_group = $this->clg->clg_group;
            // var_dump($amb_district);die;
            $args = array('amb_district' => $amb_district);
            //  var_dump($amb_district);die;
            $data['als_p'] = $this->amb_model->als_p_count($args);
            $data['als_d'] = $this->amb_model->als_d_count($args);
            $data['bls_p'] = $this->amb_model->bls_p_count($args);
            $data['bls_d'] = $this->amb_model->bls_d_count($args);
            $data['je_d'] = $this->amb_model->je_count($args);
            $data['off'] = $this->amb_model->off_road_count($args);
            // print_r($data);die;
            $count = json_encode($data);
            echo $count;die;
            // $count = cou$data['p_count']);
            // $data['als_d'] = $data['als_d'][0]->count;
            // $data['als_p'] = $data['als_p'][0]->count;
            // print_r($data['count']);die;
        }
        function mdt_login_details(){
            $district_id = $this->clg->clg_district_id;
            $clg_group = $this->clg->clg_group;
            $district_id = explode( ",", $district_id);
                $regex = "([\[|\]|^\"|\"$])"; 
                $replaceWith = ""; 
                $district_id = preg_replace($regex, $replaceWith, $district_id);
                
                if(is_array($district_id)){
                    $district_id = implode("','",$district_id);
                }

            if($this->clg->clg_group ==  'UG-DM' || $this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER'){
            
                $district_code= $this->clg->clg_district_id;
                $clg_district_id = json_decode($district_code);
                if(is_array($clg_district_id)){
                    $district_id = implode("','",$clg_district_id);
                }
                $data['district_id'] = $district_id;
                
            }

            $data['dist'] = $this->common_model->get_district(array('st_id' => 'MP','district_id' =>$data['district_id']));
                // var_dump($data['dist']);die();
           $this->output->add_to_position($this->load->view('dashboard/mdt_report_view', $data, TRUE), 'content', TRUE);
           
           
        }
        function mdt_otp_details(){

            $data['mob_no'] = $this->common_model->get_opt_details();

           $this->output->add_to_position($this->load->view('dashboard/mdt_otp_view', $data, TRUE), 'content', TRUE);
           
           
        }
        function show_otp_user(){
            $clg_mobile_no =  $this->input->post('clg_mobile_no');
            $args = array('clg_mobile_no' => $clg_mobile_no);
            $data['amb_data'] = $this->common_model->get_data_bynumber($args);
            $amb_data=$data['amb_data'];
            // var_dump($amb_data);die;
            foreach($amb_data as $data) {
            //var+
            $new_data[] = $data;
        }
            echo json_encode($new_data);
            die();
        }
        public function memsdashboard()
        {	
            $user_group=$this->clg->clg_group;  
            if ($user_group == 'UG-MemsDashboard') {
            // var_dump('hi');die();
            $data['district_names']=$this->Dashboard_model_final->get_districts_names1();
            $data['nhm']=$this->Dashboard_model_final->get_nhm_data();
           // var_dump($data); die;
           // $data="";
            $this->load->view('templates/header_dash');
            $this->load->view('dashboard/mems_dashboard_view', ['data'=>$data]);
            $this->load->view('templates/footer_dash');
            $this->output->template = ('blank');
            }else{
                dashboard_redirect($user_group,$this->base_url );
            }
        }

    public function mems_dash()
    {	
            
            $data =array();
            $dashboard_count = $this->Dashboard_model_final->get_total_calls_frm_dashboard_tbl();
            $today_calls = $this->Dashboard_model_final->get_total_calls_today();
            
            $to_date = date('Y-m-d').' 23:59:59';
            $from_date = date('Y-m-d').' 00:00:00';
            
            $arg_today_eme = array('date_type'=>'tm','to_date'=>$to_date,'from_date'=>$from_date,'type'=>'eme');
            $today_eme = $this->Dashboard_model_final->get_total_call_type($arg_today_eme);
            
            
            $data['total_calls_today']=$today_calls;
            $arg_today_noneme = array('date_type'=>'tm','to_date'=>$to_date,'from_date'=>$from_date,'type'=>'non-eme');
            $today_non_eme = $this->Dashboard_model_final->get_total_call_type($arg_today_noneme);
            
      
            $closure_today = $this->Dashboard_model_final->get_total_validated_closed_calls_today();
           
    
            $total_back_to_base_array = $this->Dashboard_model_final->total_back_to_base_count();

        $total_back_to_base_count = count($total_back_to_base_array );

        $current_date = date('Y-m-d');
        $data['current_date']=$current_date;
        $current_time = date('H');
        
        $select_time = get_current_select_time($current_time);
        $report_args = array('from_date' => date('Y-m-d', strtotime($current_date)),'select_time'=>$select_time );
       
       // $data['amb_data'] = $this->common_model->get_district_wise_offroad($report_args);
       $data['amb_data'] = $this->Dashboard_model_final->total_amb_status($report_args);
      // var_dump($data['amb_data']);die();
       if($data['amb_data'][0]->total_amb_count == NULL){
        $data['current_date']=date('Y-m-d', strtotime('-1 day', strtotime($current_date)));
        $report_args = array('from_date'=>date('Y-m-d', strtotime('-1 day', strtotime($current_date))),'select_time'=>$select_time);
        $data['amb_data'] = $this->Dashboard_model_final->total_amb_status($report_args);
        }
        //die();
        $total_amb_status =  $data['amb_data'];
        
            
        //    var_dump(  $total_back_to_base_count);die();
            
            $data['total_dispatch_tod'] =  $data['total_calls_today'];

           // total_dispatch_to
        $data['total_amb_count'] = $total_amb_status[0]->total_amb_count;
        // $data['total_amb_count'] = $total_amb_status[0]->total_amb_count;
        $data['total_off_road_doctor'] = $total_amb_status[0]->total_off_road_doctor;
        $data['total_total_offroad'] = $total_amb_status[0]->total_total_offroad;
        $data['total_amb_onroad'] = $data['total_amb_count']-$data['total_total_offroad'];
        $data['total_login_emso'] = $data['total_amb_onroad'];
        $data['total_login_pilot'] = $data['total_amb_onroad'];
    
      //  var_dump( $total_amb_status[0]->total_amb_count);die();
    
            //$data['total_calls_td']  = $dashboard_count[0]['count_till_date']+$today_calls+22241019;
            $data['total_calls_to_108']=$today_non_eme+$today_eme;
            $data['total_calls_td'] = $dashboard_count[0]['eme_count_till_date'] + $dashboard_count[0]['noneme_count_till_date'] + $data['total_calls_to_108'] + 22241019;
            $data['total_calls_tm'] = $dashboard_count[0]['count_till_month']+$data['total_calls_to_108'];
            
            // total_dispatch_all
            $data['eme_calls_td'] = $dashboard_count[0]['eme_count_till_date']+$today_eme+3602556;
            $data['eme_calls_tm'] = $dashboard_count[0]['eme_count_till_month']+$today_eme;
            
            $data['non_eme_td'] = $dashboard_count[0]['noneme_count_till_date']+$today_non_eme+18638463;
            $data['non_eme_tm'] = $dashboard_count[0]['noneme_count_till_month']+$today_non_eme;
            $data['non_eme_to'] = $today_non_eme;
            
            $data['eme_calls_td'] = $dashboard_count[0]['eme_count_till_date']+$today_calls+3602556;
            $data['eme_calls_tm'] = $dashboard_count[0]['eme_count_till_month']+$today_eme;
            $data['eme_calls_to']= $today_eme;
            
             $data['total_calls_td'] = $data['eme_calls_td'] + $data['non_eme_td'];
            
            
            
            $data['total_dispatch_all'] =  $data['eme_calls_td'];
            $data['total_dispatch_tm'] =  $data['eme_calls_tm'];
            $data['total_dispatch_to'] =  $data['eme_calls_to'];
    
            $data['total_calls_emps_td'] = $dashboard_count[0]['closure_till_date']+$closure_today+6176511;
            $data['total_calls_emps_tm'] = $dashboard_count[0]['closure_till_month']+$closure_today;
            
            $current_date = date('Y-m-d');
            $report_today = array(
                            'from_date' => date('Y-m-d', strtotime($current_date)),
                            'to_date' => date('Y-m-d', strtotime($current_date)),
                            'system_type' => '108'
                            );
            //Today Data
            $Accident_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('15','58'));
            $assault_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('6'));
            $burn_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('14'));
            $attack_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('8','9','10'));
            $fall_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('54'));
            $poision_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('13','23','50'));
            $labour_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('24','34'));
            $light_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('55'));
            $mass_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('56'));
            $report_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('1','3','4','5','7','16','17','18','19','20','22','25','26','27','28','29','30','31','32','37','38','39','47','48','49','51','52','53'));
            $other_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('2','21','35','36','45','46'));
            $trauma_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('33'));
            $suicide_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('40'));
            $delivery_in_amb_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('11','12'));
            $pt_manage_on_veti_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('57'));
            $unavail_call_data_today = $this->inc_model->get_b12_data_dashord_validate($report_today,array('41','42','43','44'));
    
              $Accident_data_today = $Accident_data_today[0]->total_count;
              $assault_data_today = $assault_data_today[0]->total_count;
              $burn_data_today = $burn_data_today[0]->total_count;
              $attack_data_today = $attack_data_today[0]->total_count;
              $fall_data_today = $fall_data_today[0]->total_count;
              $poision_data_today = $poision_data_today[0]->total_count;
              $labour_data_today = $labour_data_today[0]->total_count;
              $light_data_today = $light_data_today[0]->total_count;
              $mass_data_today = $mass_data_today[0]->total_count;
              $report_data_today = $report_data_today[0]->total_count;
              $other_data_today = $other_data_today[0]->total_count;
              $trauma_data_today = $trauma_data_today[0]->total_count;
              $suicide_data_today=$suicide_data_today[0]->total_count;
              $delivery_in_amb_data_today = $delivery_in_amb_data_today[0]->total_count;
              $pt_manage_on_veti_data_today = $pt_manage_on_veti_data_today[0]->total_count;
              $unavail_call_data_today=$unavail_call_data_today[0]->total_count;
             //Till Month
        $From_date = date('Y-m-01');
        $to_date = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") - 1, date("Y")));
        $report_args_till_month = array(
            'from_date' => date('Y-m-d', strtotime($From_date)),
            'to_date' => date('Y-m-d', strtotime($to_date)),
            'system_type' => '108'
            );
        $Accident_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('15','58'));
        $assault_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('6'));
        $burn_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('14'));
        $attack_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('8','9','10'));
        $fall_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('54'));
        $poision_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('13','23','50'));
        $labour_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('24','34'));
        $light_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('55'));
        $mass_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('56'));
        $report_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('1','3','4','5','7','16','17','18','19','20','22','25','26','27','28','29','30','31','32','37','38','39','47','48','49','51','52','53'));
        $other_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('2','21','35','36','45','46'));
        $trauma_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('33'));
        $suicide_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('40'));
        $delivery_in_amb_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('11','12'));
        $pt_manage_on_veti_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('57'));
        $unavail_call_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('41','42','43','44'));
            
        $Accident_data_tm = $Accident_data_tm[0]->total_count;
            $assault_data_tm = $assault_data_tm[0]->total_count;
            $burn_data_tm = $burn_data_tm[0]->total_count;
            $attack_data_tm = $attack_data_tm[0]->total_count;
            $fall_data_tm = $fall_data_tm[0]->total_count;
            $poision_data_tm = $poision_data_tm[0]->total_count;
            $labour_data_tm = $labour_data_tm[0]->total_count;
            $light_data_tm = $light_data_tm[0]->total_count;
            $mass_data_tm = $mass_data_tm[0]->total_count;
            $report_data_tm = $report_data_tm[0]->total_count;
            $trauma_data_tm = $trauma_data_tm[0]->total_count;
            $suicide_data_tm = $suicide_data_tm[0]->total_count;
            $delivery_in_amb_data_tm= $delivery_in_amb_data_tm[0]->total_count;
            $pt_manage_on_veti_data_tm = $pt_manage_on_veti_data_tm[0]->total_count;
            $unavail_call_data_tm = $unavail_call_data_tm[0]->total_count;
            $other_data_tm= $other_data_tm[0]->total_count;
            /*$Accident_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Accident_Vehicle');
            $assault_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Assault');
            $burn_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Burns');
            $attack_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Cardiac');
            $fall_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Fall');
            $poision_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Intoxication_Poisoning');
            $labour_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Labour_Pregnancy');
            $light_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Lighting_Electrocution');
            $mass_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Mass_casualty');
            $report_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Medical');
            $trauma_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Poly_Trauma');
            $suicide_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Suicide_Self_Inflicted_Injury');
            $delivery_in_amb_data_tm= $this->Dashboard_model_final->get_b12_report_tm_new('Deliveries_in_Ambulance');
            $pt_manage_on_veti_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Patient_Manage_on_Ventilator');
            $unavail_call_data_tm = $this->Dashboard_model_final->get_b12_report_tm_new('Unavailed_Call');
            $other_data_tm= $this->Dashboard_model_final->get_b12_report_tm_new('Others');
            */
            $Accident_data_td = $this->Dashboard_model_final->get_b12_report_new('Accident_Vehicle')+424982;
            $assault_data_td = $this->Dashboard_model_final->get_b12_report_new('Assault')+61567;
            $burn_data_td = $this->Dashboard_model_final->get_b12_report_new('Burns')+23024;
            $attack_data_td = $this->Dashboard_model_final->get_b12_report_new('Cardiac')+13431;
            $fall_data_td = $this->Dashboard_model_final->get_b12_report_new('Fall')+138025;
            $poision_data_td = $this->Dashboard_model_final->get_b12_report_new('Intoxication_Poisoning')+165926;
            $labour_data_td = $this->Dashboard_model_final->get_b12_report_new('Labour_Pregnancy')+1216628;
            $light_data_td = $this->Dashboard_model_final->get_b12_report_new('Lighting_Electrocution')+5872;
            $mass_data_td = $this->Dashboard_model_final->get_b12_report_new('Mass_casualty')+22952;
            $report_data_td = $this->Dashboard_model_final->get_b12_report_new('Medical')+3346572;
            $trauma_data_td = $this->Dashboard_model_final->get_b12_report_new('Poly_Trauma')+8601;
            $suicide_data_td = $this->Dashboard_model_final->get_b12_report_new('Suicide_Self_Inflicted_Injury')+5065;
            $delivery_in_amb_data_td= $this->Dashboard_model_final->get_b12_report_new('Deliveries_in_Ambulance')+36647;
            $pt_manage_on_veti_data_td = $this->Dashboard_model_final->get_b12_report_new('Patient_Manage_on_Ventilator')+3755;
            $unavail_call_data_td = $this->Dashboard_model_final->get_b12_report_new('Unavailed_Call');
            $other_data_td= $this->Dashboard_model_final->get_b12_report_new('Others')+742866;
            
            $today_closue = $Accident_data_today + $assault_data_today + $burn_data_today + $attack_data_today + $fall_data_today + $poision_data_today + $labour_data_today + $light_data_today + $mass_data_today + $report_data_today + $other_data_today + $trauma_data_today + $suicide_data_today + $delivery_in_amb_data_today + $pt_manage_on_veti_data_today;
            $data['total_closure_tm'] = $today_closue + $Accident_data_tm + $assault_data_tm + $burn_data_tm + $attack_data_tm + $fall_data_tm + $poision_data_tm + $labour_data_tm + $light_data_tm + $mass_data_tm + $report_data_tm + $other_data_tm + $trauma_data_tm + $suicide_data_tm + $delivery_in_amb_data_tm + $pt_manage_on_veti_data_tm;
            $data['total_closure_td'] = $today_closue + $Accident_data_td + $assault_data_td + $burn_data_td + $attack_data_td + $fall_data_td + $poision_data_td + $labour_data_td + $light_data_td + $mass_data_td + $report_data_td + $other_data_td + $trauma_data_td + $suicide_data_td+$delivery_in_amb_data_td+$pt_manage_on_veti_data_td;
            $data['total_calls_emps_tm'] = $today_closue + $Accident_data_tm + $assault_data_tm + $burn_data_tm + $attack_data_tm + $fall_data_tm + $poision_data_tm + $labour_data_tm + $light_data_tm + $mass_data_tm + $report_data_tm + $other_data_tm + $trauma_data_tm + $suicide_data_tm + $delivery_in_amb_data_tm + $pt_manage_on_veti_data_tm;
            $data['total_calls_emps_td'] = $today_closue + $Accident_data_td + $assault_data_td + $burn_data_td + $attack_data_td + $fall_data_td + $poision_data_td + $labour_data_td + $light_data_td + $mass_data_td + $report_data_td + $other_data_td + $trauma_data_td + $suicide_data_td+$delivery_in_amb_data_td+$pt_manage_on_veti_data_td;
            //$data['total_closure_td']=7302199;
            //$data['total_closure_tm']=75970;
            
            //$data['total_closure_td'] = $dashboard_count[0]['closure_till_date']+$closure_today+6176511;
           // $data['total_closure_tm'] = $dashboard_count[0]['closure_till_month']+$closure_today;
            //$data['total_closure_to'] = $closure_today;
            $dispatch_pt_count = $this->Dashboard_model_final->get_total_dispatch_patient();
            $data['total_closure_to'] = $dispatch_pt_count[0]['pt_count'];

            
            $data['agents_available'] = $this->Dashboard_model_final->get_agents_available();
            $data['agents_available_108'] = $this->Dashboard_model_final->get_agents_available_108($cond='108');
            $data['agents_available_102'] = $this->Dashboard_model_final->get_agents_available_102($cond='102');
            $data['available_agents'] = $this->Dashboard_model_final->get_agent_status($cond="avail");
            $data['oncall_agents'] = $this->Dashboard_model_final->get_agent_status($cond="oncall");
            $data['break_agents'] = $this->Dashboard_model_final->get_agent_status($cond="break");
    
            $data['all_amb'] = $this->Dashboard_model_final->get_amb_all_status($cond="all");
            $data['busy_amb'] = $this->Dashboard_model_final->get_amb_all_status($cond="busy");
            $data['avail_amb'] = $this->Dashboard_model_final->get_amb_all_status($cond="avail");

            $data['visitors_count'] = $this->Dashboard_model_final->get_visitors_data();
            // var_dump($data['visitors_count']);die();
        
            $total_dispatch_status = $this->Dashboard_model_final->total_dispatch_status();
           
            $start_from_base_count= 0;
    
            $at_scene_count= 0;
            $at_scene_count= 0;
            $from_scene_count= 0;
            $at_hospital_count= 0;
            $handover_count= 0;
            $back_to_base_count = 0;
            
            
            foreach( $total_dispatch_status as  $para)
            {  
                // var_dump( $para->parameter_count);die();
               if( $para->parameter_count=="")
               {
               // var_dump( $para->parameter_count,"hi");die();
                $start_from_base_count =  $start_from_base_count + 1;
               }
                if(empty($para)){
                  
                    $paraCount = 0;
                    $msg = "Not Started";
                    $outOfSych = 'true';
                    
                }else if($para->parameter_count == 2){
                    $start_from_base_count =  $start_from_base_count + 1;
                    // $msg = "Already Start to base";
                    // $outOfSych = 'false';
                }else if($para->parameter_count == 3){
                    $at_scene_count = $at_scene_count+1;
                   // var_dump(  $at_scene_count);die();
                    // $msg = "Already At Scene";
                    // $outOfSych = 'false';
                }else if($para->parameter_count == 4){
                    $from_scene_count =  $from_scene_count+1;
                    // $msg = "Already From Scene";
                    // $outOfSych = 'false';
                }else if($para->parameter_count == 5){
                    $at_hospital_count = $at_hospital_count+1;
                    // $msg = "Already At hospital";
                    // $outOfSych = 'false';
                }else if($para->parameter_count == 6){
                    $handover_count = $handover_count+1;
                    // $msg = "Already Patient handover";
                    // $outOfSych = 'false';
                }else if($para->parameter_count == 7){
                    $back_to_base_count = $back_to_base_count+1;
                    // $msg = "Already back to base";
                    // $outOfSych = 'false';
                }
            }

           // var_dump($data['total_dispatch_to'] , $total_back_to_base_count);die();
            // $data['total_dispatch_today'] = $data['total_dispatch_to'] - $total_back_to_base_count ;
             $data['total_dispatch_today'] = $data['total_dispatch_to'] ;
            //  start_from_base_count
            // $data['total_dispatch_today'] = $data['total_dispatch_to']- $total_back_to_base_count ;
            // total_dispatch_today
            // 
            // total_dispatch_today
            // total_back_to_base_count

            $data['start_from_base_count1'] =   $data['total_dispatch_today']  - $total_back_to_base_count - ($at_scene_count + $from_scene_count + $back_to_base_count) ;

        if ($data['start_from_base_count1']<0){

            $data['start_from_base_count1'] =   $data['total_dispatch_today']+200  - $total_back_to_base_count - ($at_scene_count + $from_scene_count + $back_to_base_count) ;

            $data['start_from_base_count'] =  $data['start_from_base_count1'] ;
        }
        else{
            $data['start_from_base_count'] =  $data['start_from_base_count1'] ;

        }
        
            //  var_dump( $data['start_from_base_count']);die();  $data['at_scene_count'] = $at_scene_count;
            $data['at_scene_count'] = $at_scene_count;
            $data['from_scene_count'] = $from_scene_count;
            $data['at_hospital_count'] = $at_hospital_count;
            $data['handover_count'] = $handover_count;
            $data['back_to_base_count'] = $back_to_base_count + $total_back_to_base_count;
            //$total_amb_status = $this->Dashboard_model_final->total_amb_status();
      
        echo json_encode($data);
        exit;
    
    }
    function get_dashnew(){
        $this->output->add_to_position($this->load->view('frontend/all_dashboard/onroad_offroad_view', $data, TRUE), $this->post['output_position'], TRUE);

        $this->output->template = ('blank');
 

    }
    function get_manpower_dashnew(){
        $this->output->add_to_position($this->load->view('frontend/all_dashboard/manpower_view', $data, TRUE), $this->post['output_position'], TRUE);

        $this->output->template = ('blank');
    }
    function get_feedback_dashnew(){
        $this->output->add_to_position($this->load->view('frontend/all_dashboard/feedback_view', $data, TRUE), $this->post['output_position'], TRUE);

        $this->output->template = ('blank');
    }
    function get_case_handling_dashnew(){
        $this->output->add_to_position($this->load->view('frontend/all_dashboard/case_handling_view', $data, TRUE), $this->post['output_position'], TRUE);

        $this->output->template = ('blank');
    }
    function get_mdt_status_dashnew(){
        $this->output->add_to_position($this->load->view('frontend/all_dashboard/mdt_status_view', $data, TRUE), $this->post['output_position'], TRUE);

        $this->output->template = ('blank');
 
    }
    function get_emso_pilot_dashnew(){
        $data['dist'] = $this->common_model->get_district(array('st_id' => 'MP'));
        $this->output->add_to_position($this->load->view('frontend/all_dashboard/emso_pilot_login_view', $data, TRUE), $this->post['output_position'], TRUE);

        $this->output->template = ('blank');
 
    }
    function get_attendance_sheet_dashnew(){
        $post_data = $this->input->post();
        if($post_data['to_date'] != '' && $post_data['from_date'] != ''){
            $data['to_date'] = date('Y-m-d', strtotime($post_data['to_date']));
             $data['from_date'] = date('Y-m-d', strtotime($post_data['from_date']));
        }else{
            $data['to_date'] = date('Y-m-d');
            $data['from_date'] = date('Y-m-d', strtotime("-15 days"));
        }
        $data['dist'] = $this->common_model->get_district(array('st_id' => 'MP'));
        $this->output->add_to_position($this->load->view('frontend/all_dashboard/attendance_sheet_view', $data, TRUE), $this->post['output_position'], TRUE);

        $this->output->template = ('blank');
 
    }


function save_remark_data()
	{
	
		$data['remark']=$this->input->post('remark');
		$data['amb_id']=$this->input->post('amb_id');
		// $data['clg_id']=$this->input->post('clg_id');
		$data['added_date']=date('Y-m-d H:i:s');
		$data['added_by']=$this->clg->clg_ref_id;
		// var_dump($data);die; 
		$rem = $this->Dashboard_model->saveremarks($data);
        if($rem == 1){
            echo json_encode("Remark Saved Successfully");
        }		
	
	}
    function save_other_remark_data()
	{
	
		$data['remark']=$this->input->post('remark');
		$data['amb_id']='';
		$data['clg_id']=$this->input->post('clg_id');
		$data['added_date']=date('Y-m-d H:i:s');
		$data['added_by']=$this->clg->clg_ref_id;
		// var_dump($data);die; 
		$rem = $this->Dashboard_model->saveremarks($data);
        if($rem == 1){
            echo json_encode("Remark Saved Successfully");
        }		
	
	}
    function show_remark_data()
	{
        $amb_id=$this->input->post("amb_id");
        $data = $this->Dashboard_model->showremarks($amb_id);
        $ramark_data = array('remark' => $data[0]->remark,
             'added_date'=>$data[0]->added_date,
             'clg_first_name'=>$data[0]->clg_first_name,
             'clg_mid_name'=>$data[0]->clg_mid_name,
             'clg_last_name'=>$data[0]->clg_last_name,);
          // $data = array('remark'=>);
        //  print_r($data);
        echo json_encode($ramark_data);
        die();
	}
    function show_other_remark_data()
	{
        $clg_id=$this->input->post("clg_id");
        $data = $this->Dashboard_model->show_other_remarks($clg_id);
        $ramark_data = array('remark' => $data[0]->remark,
             'added_date'=>$data[0]->added_date,
             'clg_first_name'=>$data[0]->clg_first_name,
             'clg_mid_name'=>$data[0]->clg_mid_name,
             'clg_last_name'=>$data[0]->clg_last_name,);
          // $data = array('remark'=>);
        //  print_r($data);
        echo json_encode($ramark_data);
        die();
	}



    function mdt_other_login(){
        $data['dist'] = $this->common_model->get_district(array('st_id' => 'MP'));

       $this->output->add_to_position($this->load->view('dashboard/mdt_other_report_view', $data, TRUE), 'content', TRUE);

    }


    function mdt_other_dtl(){

        $clg_district_id =  $this->input->post('clg_district_id');

        $args = array('district_id' => $clg_district_id);
        $data['amb_data'] = $this->amb_model->get_mdt_other_data($args);
        $amb_data=$data['amb_data'];
        /*foreach($amb_data as $data) {
            $clg_id = $data->clg_id;

           // $clg_data = $clg_id;
            $new_data[] = $data;
            
                $data->clg_data_name = $clg_data[0]->clg_first_name.' '.$clg_data[0]->clg_mid_name.' '.$clg_data[0]->clg_last_name;
                $data->clg_data_mobno = $clg_data[0]->clg_mobile_no;
                $data->clg_data_des = $clg_data[0]->clg_designation;
                $data->clg_data_mail = $clg_data[0]->clg_email;
                $data->clg_data_status = $clg_data[0]->status;
                $data->clg_data_login_time = $clg_data[0]->login_time;
                $data->clg_data_logout_time = $clg_data[0]->logout_time;
            
           
        }*/
        // var_dump($amb_data);
        foreach($amb_data as $data) {
            //var+
        $new_data[] = $data;
        }
        echo json_encode($new_data);
        die();
    }
    function get_dash_report(){
        //  $data['amb_data'] = $this->common_model->get_main_dash_data($report_args);
        $this->output->add_to_position($this->load->view('dashboard/dashboard_report_view', $data, TRUE));
        if($this->clg->clg_group == 'UG-Dashboard-view'){
            $this->output->template = "blank"; 
        }else{
            $this->output->template = "nhm_blank"; 
        }
    }
    function mdt_logout(){

            $data['dist'] = $this->common_model->get_district(array('st_id' => 'MP'));
            $amb_district =  $this->input->post('amb_district');
            $args = array('district_id' => $amb_district,'thirdparty'=>$this->clg->thirdparty );
            $data['amb_data'] = $this->amb_model->get_forcefully_mdt_login_user($args);
           $this->output->add_to_position($this->load->view('dashboard/mdt_logout_view', $data, TRUE), 'content', TRUE);
           
           
    }
    function force_logout(){
        
        //$this->output->add_to_position($this->load->view('frontend/clg/clg_forcefully_view', $data, true), $this->post['output_position'], true);
       
        $data['id'] = base64_decode($this->input->post('id'));
        $data['ref_id'] = $this->input->post('ref_id');
        
        $this->output->add_to_popup($this->load->view('dashboard/mdt_forcefully_view', $data, TRUE), '1000', '500');
        
    }
    
    function save_force_logout(){
        
        $force_data = $this->input->post();
        $force_data['id']= $force_data['id'];
       
        $data_insert = array('logout_remark'=>$force_data['logout_remark'],
                            'logout_ref_id'=> $force_data['ref_id'],
                            'added_by'=>$this->clg->clg_ref_id,
                            'added_date'=>date('Y-m-d H:i:s'));
        
        $state = $this->colleagues_model->insert_mdt_forcefully_logout($data_insert);
  
       
        
        $result = $this->amb_model->update_amb_login_status($force_data['id'], array( 'status'=>'2','logout_time'=>date('Y-m-d H:i:s')));
        
        
        $result = $this->colleagues_model->update_clg_field($force_data['ref_id'], 'clg_break_type', 'LO');
        $result1 = $this->colleagues_model->update_clg_field($force_data['ref_id'], 'clg_is_login', 'no');
        $current_user_data = $this->call_model->is_ero_free_user_exists($force_data['ref_id']);
        $this->output->message = "<div class='success'>Forcefully Logout Successfully!</div>";
        $this->mdt_logout();
        
    }
    function ems_incidance_analytics_data(){
       $get_inc_data = $this->inc_model->get_inc_analytics_data();

            if($get_inc_data){
                foreach ($get_inc_data as $data) {
                    
                    $call_type = '';
                    if($data->inc_type != ''){
                        $call_type = get_purpose_of_call($data->inc_type);
                    }
                
                    if($data->inc_lat == '' && $data->inc_long == ''){
                        if($data->inc_tahshil_id != '' && $data->thl_lat != ''){
                            $data->inc_lat  =  $data->thl_lat;
                            $data->inc_long = $data->thl_lng;
                        }else if($data->inc_district_id != ''){
                             $data->inc_lat  =  $data->dst_lat;
                            $data->inc_long = $data->dst_lang;
                        }

                    }

                    $get_inc_data = $this->inc_model->get_inc_epcr_data(array('inc_ref_id' => $data->inc_ref_id));
                   // var_dump($get_inc_data);
                    $total_pt = $get_inc_data[0]->total_patient;
                    $patient_name =  $get_inc_data[0]->ptn_fname.' '.$get_inc_data[0]->ptn_lname;;
                    $pro_name = $get_inc_data[0]->pro_name;
                    $pro_id = $get_inc_data[0]->provider_impressions;
                    $ptn_gender = $get_inc_data[0]->ptn_gender;
                    $ptn_age = $get_inc_data[0]->ptn_age;
                    $b12_type = $get_inc_data[0]->b12_type;

                    if($get_inc_data[0]->is_validate == 0){
                        $inc_pcr_status = '0';
                    }else{
                         $inc_pcr_status = '1';
                    }
                
                    if($data->amb_type == '1'){
                        $system_type = 'JE';
                    }else{
                         $system_type = '108';
                    }
                
 

                     $arr = array(
                    'inc_ref_id' => $data->inc_ref_id,
                    'dst_id'=> $data->inc_district_id,
                    'div_id'=> $data->div_id,
                    'thl_id'=> $data->inc_tahshil_id,
                    'inc_lat' => $data->inc_lat,
                    'inc_long' => $data->inc_long	,
                    'inc_complaint' => $data->ct_type,
                    'ntr_nature' => $data->ntr_nature,
                    'amb_rto_register_no' => $data->amb_rto_register_no,
                    'dst_name' => $data->dst_name,
                    'div_name' => $data->div_name,
                    'thl_name' => $data->thl_name,
                    'cty_name' => $data->cty_name,
                    'inc_address' => $data->inc_address,
                    'amb_lat'=> $data->amb_lat,
                    'amb_log'=> $data->amb_log,
                    'inc_system_type' => $system_type,
                    'inc_datetime' => $data->inc_datetime,
                    'inc_pcr_status' => $inc_pcr_status,
                    'total_pt' => $total_pt?$total_pt:0,
                    'patient_name' => $patient_name,
                    'pro_name' => $pro_name,
                    'pro_id' => $pro_id,
                    'ptn_gender' => $ptn_gender,
                    'ptn_age' => $ptn_age,
                    'b12_type' => $b12_type,
                    'call_type' => $call_type
                );
                    $emt_name = $this->inc_model->insert_inc_analytics_data($arr);
                    
                }
            }
            
            $get_inc_data = $this->inc_model->get_analytics_epcr_data();
            if($get_inc_data){
                foreach ($get_inc_data as $data) {
                    $get_inc_data = $this->inc_model->get_inc_epcr_analytic_data(array('inc_ref_id' => $data->inc_ref_id));
                    $total_pt = $get_inc_data[0]->total_patient;
                    $patient_name = $get_inc_data[0]->ptn_fname.' '.$get_inc_data[0]->ptn_lname;
                    $pro_name = $get_inc_data[0]->pro_name;
                    $pro_id = $get_inc_data[0]->provider_impressions;
                    $ptn_gender = $get_inc_data[0]->ptn_gender;
                    $ptn_age = $get_inc_data[0]->ptn_age;
                    $b12_type = $get_inc_data[0]->b12_type;
                    if($get_inc_data[0]->is_validate == 0){
                        $inc_pcr_status1 = '0';
                    }else{
                         $inc_pcr_status1 = '1';
                    }

                    $arr = array(
                        'inc_ref_id' => $data->inc_ref_id,
                        'total_pt' => $total_pt,
                        'patient_name' => $patient_name,
                        'pro_name' => $pro_name,
                        'pro_id' => $pro_id,
                        'ptn_gender' => $ptn_gender,
                        'ptn_age' => $ptn_age,
                        'b12_type' => $b12_type,
                        'inc_pcr_status' =>$inc_pcr_status1
                    );
                    $emt_name = $this->inc_model->update_analytics_data($arr);
                }
            }
            echo "done";
            die();
    }
            public function update_analytic_data(){
                        
            $get_inc_data = $this->inc_model->get_analytics_epcr_data();
          

       
            foreach ($get_inc_data as $data) {
                
                $get_inc_data = $this->inc_model->get_inc_analytics_data(array('inc_ref_id' => $data->inc_ref_id));
            
                if($data->inc_lat == '' && $data->inc_long == ''){
                  
                    if($get_inc_data[0]->thl_lat != '' && $get_inc_data[0]->thl_lng != ''){
                         
                        $data->inc_lat  =  $get_inc_data[0]->thl_lat;
                        $data->inc_long = $get_inc_data[0]->thl_lng;
                          
                    }else if($get_inc_data[0]->inc_district_id != ''){
                         $data->inc_lat  =  $get_inc_data[0]->dst_lat;
                        $data->inc_long = $get_inc_data[0]->dst_lang;
                    }
           
                }
               
                  //var_dump( $data);
                 $arr = array(
                'inc_ref_id' => $data->inc_ref_id,
                'inc_lat' => $data->inc_lat,
                'inc_long' => $data->inc_long);
                 
                  $emt_name = $this->inc_model->update_analytics_data($arr);
                     
            }
        }
        public function update_analytic_epcr_data(){
                        
            $get_inc_details = $this->inc_model->get_analytics_epcr_data();
            foreach ($get_inc_details as $data) {
                $get_inc_data = $this->inc_model->get_inc_epcr_analytic_data(array('inc_ref_id' => $data->inc_ref_id));
                if($get_inc_data){
                    $total_pt = $get_inc_data[0]->total_patient;
                    $patient_name = $get_inc_data[0]->ptn_fname.' '.$get_inc_data[0]->ptn_lname;
                    $pro_name = $get_inc_data[0]->pro_name;
                    $pro_id = $get_inc_data[0]->provider_impressions;
                    $ptn_gender = $get_inc_data[0]->ptn_gender;
                    $ptn_age = $get_inc_data[0]->ptn_age;
                    $b12_type = $get_inc_data[0]->b12_type;
                    if($get_inc_data[0]->is_validate == 0){
                        $inc_pcr_status1 = '0';
                    }else{
                         $inc_pcr_status1 = '1';
                    }

                    $arr = array(
                        'inc_ref_id' => $data->inc_ref_id,
                        'total_pt' => $total_pt,
                        'patient_name' => $patient_name,
                        'pro_name' => $pro_name,
                        'pro_id' => $pro_id,
                        'ptn_gender' => $ptn_gender,
                        'ptn_age' => $ptn_age,
                        'b12_type' => $b12_type,
                        'inc_pcr_status' =>$inc_pcr_status1
                    );
                    $emt_name = $this->inc_model->update_analytics_data($arr);
                }
            }
        }
        public function update_analytic_epcr_data_by_date(){
                    $to_date = str_replace('_', '-', $_GET['to_date']);
                    $from_date= str_replace('_', '-', $_GET['from_date']);
                   
                        
            $get_inc_data = $this->inc_model->get_analytics_epcr_data_by_date(array('to_date'=>$to_date,'from_date'=>$from_date));
            
            if($get_inc_data){
            foreach ($get_inc_data as $data) {
                // var_dump($get_inc_data);
                $get_inc_pcr_data = $this->inc_model->get_inc_epcr_analytic_data(array('inc_ref_id' => $data->inc_ref_id));
               
                if($get_inc_pcr_data){
                    $total_pt = $get_inc_pcr_data[0]->total_patient;
                    $patient_name = $get_inc_pcr_data[0]->ptn_fname.' '.$get_inc_pcr_data[0]->ptn_lname;
                    $pro_name = $get_inc_pcr_data[0]->pro_name;
                    $pro_id = $get_inc_pcr_data[0]->provider_impressions;
                    $ptn_gender = $get_inc_pcr_data[0]->ptn_gender;
                    $ptn_age = $get_inc_pcr_data[0]->ptn_age;
                    $b12_type = $get_inc_pcr_data[0]->b12_type;

                    $arr = array(
                        'inc_ref_id' => $data->inc_ref_id,
                        'total_pt' => $total_pt,
                        'patient_name' => $patient_name,
                        'pro_name' => $pro_name,
                        'pro_id' => $pro_id,
                        'ptn_gender' => $ptn_gender,
                        'ptn_age' => $ptn_age,
                        'b12_type' => $b12_type,
                        'inc_pcr_status' =>'1'
                    );
                    $emt_name = $this->inc_model->update_analytics_data($arr);
                }
            }
            }
            echo "done";
            die();
        }
function nhm_dashabord_b12data_cron_for_report(){
//1. Till Date B12 data   
    $start_date = '2022-03-01' ;
    $closure_date_to = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") - 1, date("Y"))) ;
    // $closure_date= $this->Dashboard_model_final->get_closure_last_date();
    // $closure_date_to = date('Y-m-d', strtotime($closure_date[0]['inc_datetime']));
    $report_args2 = array('from_date' => date('Y-m-d', strtotime($start_date)),
                 'to_date' =>$closure_date_to,
                 'system_type' => '108'
                 );
    $Accident_data_till = $this->inc_model->get_b12_data_dashord($report_args2,array('15','58'));
    $assault_data_till = $this->inc_model->get_b12_data_dashord($report_args2,array('6'));
    $burn_data_till = $this->inc_model->get_b12_data_dashord($report_args2,array('14'));
    $attack_data_till = $this->inc_model->get_b12_data_dashord($report_args2,array('8','9','10'));
    $fall_data_till = $this->inc_model->get_b12_data_dashord($report_args2,array('54'));
    $poision_data_till = $this->inc_model->get_b12_data_dashord($report_args2,array('13','23','50'));
    $labour_data_till = $this->inc_model->get_b12_data_dashord($report_args2,array('24','34'));
    $light_data_till = $this->inc_model->get_b12_data_dashord($report_args2,array('55'));
    $mass_data_till = $this->inc_model->get_b12_data_dashord($report_args2,array('56'));
    $report_data_till = $this->inc_model->get_b12_data_dashord($report_args2,array('1','3','4','5','7','16','17','18','19','20','22','25','26','27','28','29','30','31','32','37','38','39','47','48','49','51','52','53'));
    $other_data_till = $this->inc_model->get_b12_data_dashord($report_args2,array('2','21','35','36','45','46'));
    $trauma_data_till = $this->inc_model->get_b12_data_dashord($report_args2,array('33'));
    $suicide_data_till = $this->inc_model->get_b12_data_dashord($report_args2,array('40'));
    $delivery_in_amb_data_till = $this->inc_model->get_b12_data_dashord($report_args2,array('11','12'));
    $pt_manage_on_veti_data_till = $this->inc_model->get_b12_data_dashord($report_args2,array('57'));
    $unavail_call_data_till = $this->inc_model->get_b12_data_dashord($report_args2,array('41','42','43','44')); 
//2. This Month B12 data
    $closure_complete = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") - 1, date("Y")));
    // var_dump($closure_complete);die;
    $start_date_month =  date('Y-m-01');
    $report_args_tm = array(//'from_date' => date('Y-m-01'),
        'from_date' =>$start_date_month,
        'to_date' =>$closure_complete,
        'system_type' => '108'
    );
 
    $Accident_data_tm = $this->inc_model->get_b12_data_dashord($report_args_tm,array('15','58'));
    $assault_data_tm = $this->inc_model->get_b12_data_dashord($report_args_tm,array('6'));
    $burn_data_tm = $this->inc_model->get_b12_data_dashord($report_args_tm,array('14'));
    $attack_data_tm = $this->inc_model->get_b12_data_dashord($report_args_tm,array('8','9','10'));
    $fall_data_tm = $this->inc_model->get_b12_data_dashord($report_args_tm,array('54'));
    $poision_data_tm = $this->inc_model->get_b12_data_dashord($report_args_tm,array('13','23','50'));
    $labour_data_tm = $this->inc_model->get_b12_data_dashord($report_args_tm,array('24','34'));
    $light_data_tm = $this->inc_model->get_b12_data_dashord($report_args_tm,array('55'));
    $mass_data_tm = $this->inc_model->get_b12_data_dashord($report_args_tm,array('56'));
    $report_data_tm = $this->inc_model->get_b12_data_dashord($report_args_tm,array('1','3','4','5','7','16','17','18','19','20','22','25','26','27','28','29','30','31','32','37','38','39','47','48','49','51','52','53'));
    $other_data_tm = $this->inc_model->get_b12_data_dashord($report_args_tm,array('2','21','35','36','45','46'));
    $trauma_data_tm = $this->inc_model->get_b12_data_dashord($report_args_tm,array('33'));
    $suicide_data_tm = $this->inc_model->get_b12_data_dashord($report_args_tm,array('40'));
    $delivery_in_amb_data_tm = $this->inc_model->get_b12_data_dashord($report_args_tm,array('11','12'));
    $pt_manage_on_veti_data_tm = $this->inc_model->get_b12_data_dashord($report_args_tm,array('57'));
    $unavail_call_data_tm = $this->inc_model->get_b12_data_dashord($report_args_tm,array('41','42','43','44')); 
    
         $B12_data_tm = array('Accident_Vehicle' => $Accident_data_tm[0]->total_count,
                         'Assault' => $assault_data_tm[0]->total_count,
                         'Burns' => $burn_data_tm[0]->total_count,
                         'Cardiac' => $attack_data_tm[0]->total_count,
                         'Fall' => $fall_data_tm[0]->total_count,
                         'Intoxication_Poisoning' => $poision_data_tm[0]->total_count,
                         'Labour_Pregnancy' => $labour_data_tm[0]->total_count,
                         'Lighting_Electrocution' => $light_data_tm[0]->total_count,
                         'Mass_casualty' => $mass_data_tm[0]->total_count,
                         'Medical' => $report_data_tm[0]->total_count,
                         'Poly_Trauma' => $trauma_data_tm[0]->total_count,
                         'Suicide_Self_Inflicted_Injury' => $suicide_data_tm[0]->total_count,
                         'Deliveries_in_Ambulance' => $delivery_in_amb_data_tm[0]->total_count,
                         'Patient_Manage_on_Ventilator' => $pt_manage_on_veti_data_tm[0]->total_count,
                         'Unavailed_Call' => $unavail_call_data_tm[0]->total_count,
                         'Others' => $other_data_tm[0]->total_count,
                 );
                 foreach($B12_data_tm as $key=>$b12_tm){
                     $this->Dashboard_model_final->insert_b12data_dash_report_tm($key,$b12_tm);
                 }

 //2day previous
    $start_date = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") - 2, date("Y"))) ;
    $report_args_pre2day = array('from_date' => date('Y-m-d', strtotime($start_date)),
                'to_date' => date('Y-m-d', strtotime($start_date)),
                'system_type' => '108'
    );
        $Accident_data_pre2day = $this->inc_model->get_b12_data_dashord($report_args_pre2day,array('15','58'));
        $assault_data_pre2day = $this->inc_model->get_b12_data_dashord($report_args_pre2day,array('6'));
        $burn_data_pre2day = $this->inc_model->get_b12_data_dashord($report_args_pre2day,array('14'));
        $attack_data_pre2day = $this->inc_model->get_b12_data_dashord($report_args_pre2day,array('8','9','10'));
        $fall_data_pre2day = $this->inc_model->get_b12_data_dashord($report_args_pre2day,array('54'));
        $poision_data_pre2day = $this->inc_model->get_b12_data_dashord($report_args_pre2day,array('13','23','50'));
        $labour_data_pre2day = $this->inc_model->get_b12_data_dashord($report_args_pre2day,array('24','34'));
        $light_data_pre2day = $this->inc_model->get_b12_data_dashord($report_args_pre2day,array('55'));
        $mass_data_pre2day = $this->inc_model->get_b12_data_dashord($report_args_pre2day,array('56'));
        $report_data_pre2day = $this->inc_model->get_b12_data_dashord($report_args_pre2day,array('1','3','4','5','7','16','17','18','19','20','22','25','26','27','28','29','30','31','32','37','38','39','47','48','49','51','52','53'));
        $other_data_pre2day = $this->inc_model->get_b12_data_dashord($report_args_pre2day,array('2','21','35','36','45','46'));
        $trauma_data_pre2day = $this->inc_model->get_b12_data_dashord($report_args_pre2day,array('33'));
        $suicide_data_pre2day = $this->inc_model->get_b12_data_dashord($report_args_pre2day,array('40'));
        $delivery_in_amb_data_pre2day = $this->inc_model->get_b12_data_dashord($report_args_pre2day,array('11','12'));
        $pt_manage_on_veti_data_pre2day = $this->inc_model->get_b12_data_dashord($report_args_pre2day,array('57'));
        $unavail_call_data_pre2day = $this->inc_model->get_b12_data_dashord($report_args_pre2day,array('41','42','43','44')); 
 /****** */
    $b12_data = array('Accident_Vehicle' => $Accident_data_till[0]->total_count,
                     'Assault' => $assault_data_till[0]->total_count,
                     'Burns' => $burn_data_till[0]->total_count,
                     'Cardiac' => $attack_data_till[0]->total_count,
                     'Fall' => $fall_data_till[0]->total_count,
                     'Intoxication_Poisoning' => $poision_data_till[0]->total_count,
                     'Labour_Pregnancy' => $labour_data_till[0]->total_count,
                     'Lighting_Electrocution' => $light_data_till[0]->total_count,
                     'Mass_casualty' => $mass_data_till[0]->total_count,
                     'Medical' => $report_data_till[0]->total_count,
                     'Poly_Trauma' => $trauma_data_till[0]->total_count,
                     'Suicide_Self_Inflicted_Injury' => $suicide_data_till[0]->total_count,
                     'Deliveries_in_Ambulance' => $delivery_in_amb_data_till[0]->total_count,
                     'Patient_Manage_on_Ventilator' => $pt_manage_on_veti_data_till[0]->total_count,
                     'Unavailed_Call' => $unavail_call_data_till[0]->total_count,
                     'Others' => $other_data_till[0]->total_count,
                 );
                 foreach($b12_data as $key=>$b12){
                     $this->Dashboard_model_final->insert_b12data_dash_report($key,$b12);
                 }


         $B12_data_pre2day = array('Accident_Vehicle' => $Accident_data_pre2day[0]->total_count,
                 'Assault' => $assault_data_pre2day[0]->total_count,
                 'Burns' => $burn_data_pre2day[0]->total_count,
                 'Cardiac' => $attack_data_pre2day[0]->total_count,
                 'Fall' => $fall_data_pre2day[0]->total_count,
                 'Intoxication_Poisoning' => $poision_data_pre2day[0]->total_count,
                 'Labour_Pregnancy' => $labour_data_pre2day[0]->total_count,
                 'Lighting_Electrocution' => $light_data_pre2day[0]->total_count,
                 'Mass_casualty' => $mass_data_pre2day[0]->total_count,
                 'Medical' => $report_data_pre2day[0]->total_count,
                 'Poly_Trauma' => $trauma_data_pre2day[0]->total_count,
                 'Suicide_Self_Inflicted_Injury' => $suicide_data_pre2day[0]->total_count,
                 'Deliveries_in_Ambulance' => $delivery_in_amb_data_pre2day[0]->total_count,
                 'Patient_Manage_on_Ventilator' => $pt_manage_on_veti_data_pre2day[0]->total_count,
                 'Unavailed_Call' => $unavail_call_data_pre2day[0]->total_count,
                 'Others' => $other_data_pre2day[0]->total_count,
         );
         foreach($B12_data_pre2day as $key=>$b12_pre2day){
             $this->Dashboard_model_final->insert_b12data_dash_report_pre2day($key,$b12_pre2day);
         }
     
    // echo 'done';  
     die();
      
 }
    function B12_data_New(){
        $current_date = date('Y-m-d');
        $report_today = array(
                        'from_date' => date('Y-m-d', strtotime($current_date)),
                        'to_date' => date('Y-m-d', strtotime($current_date)),
                        'system_type' => '108'
                        );
                        $current_date = date('Y-m-d');

                        $report_today = array('from_date' => date('Y-m-d', strtotime($current_date)),
                                    'to_date' => date('Y-m-d', strtotime($current_date))
                        );
                        //today
                        // 2020-06-01
        $Accident_data_today = $this->inc_model->get_Accident_b12_report($report_today);
        $assault_data_today = $this->inc_model->get_assault_b12_report($report_today);
        $burn_data_today = $this->inc_model->get_burn_b12_report($report_today);
        $attack_data_today = $this->inc_model->get_attack_b12_report($report_today);
        $fall_data_today = $this->inc_model->get_fall_b12_report($report_today);
        $poision_data_today = $this->inc_model->get_poision_b12_report($report_today);
        $labour_data_today = $this->inc_model->get_labour_b12_report($report_today);
        $light_data_today = $this->inc_model->get_light_b12_report($report_today);
        $mass_data_today = $this->inc_model->get_mass_b12_report($report_today);
        $report_data_today = $this->inc_model->get_medical_b12_report($report_today);
        $other_data_today = $this->inc_model->get_other_b12_report($report_today);
        $trauma_data_today = $this->inc_model->get_trauma_b12_report($report_today);
        $suicide_data_today = $this->inc_model->get_suicide_b12_report($report_today);
        $delivery_in_amb_data_today = $this->inc_model->get_delivery_in_amb_b12_report($report_today);
        $pt_manage_on_veti_data_today = $this->inc_model->get_pt_manage_on_veti_b12_report($report_today);
        $unavail_call_data_today = $this->inc_model->get_pt_manage_on_unavail_report($report_today);
        
        //Today Data
        $Accident_data_today1 = $this->inc_model->get_b12_data_dashord_validate($report_today,array('15','58'));
        $assault_data_today1 = $this->inc_model->get_b12_data_dashord_validate($report_today,array('6'));
        $burn_data_today1 = $this->inc_model->get_b12_data_dashord_validate($report_today,array('14'));
        $attack_data_today1 = $this->inc_model->get_b12_data_dashord_validate($report_today,array('8','9','10'));
        $fall_data_today1 = $this->inc_model->get_b12_data_dashord_validate($report_today,array('54'));
        $poision_data_today1 = $this->inc_model->get_b12_data_dashord_validate($report_today,array('13','23','50'));
        $labour_data_today1 = $this->inc_model->get_b12_data_dashord_validate($report_today,array('24','34'));
        $light_data_today1 = $this->inc_model->get_b12_data_dashord_validate($report_today,array('55'));
        $mass_data_today1 = $this->inc_model->get_b12_data_dashord_validate($report_today,array('56'));
        $report_data_today1 = $this->inc_model->get_b12_data_dashord_validate($report_today,array('1','3','4','5','7','16','17','18','19','20','22','25','26','27','28','29','30','31','32','37','38','39','47','48','49','51','52','53'));
        $other_data_today1 = $this->inc_model->get_b12_data_dashord_validate($report_today,array('2','21','35','36','45','46'));
        $trauma_data_today1 = $this->inc_model->get_b12_data_dashord_validate($report_today,array('33'));
        $suicide_data_today1 = $this->inc_model->get_b12_data_dashord_validate($report_today,array('40'));
        $delivery_in_amb_data_today1 = $this->inc_model->get_b12_data_dashord_validate($report_today,array('11','12'));
        $pt_manage_on_veti_data_today1 = $this->inc_model->get_b12_data_dashord_validate($report_today,array('57'));
        $unavail_call_data_today1 = $this->inc_model->get_b12_data_dashord_validate($report_today,array('41','42','43','44'));
      
        $start_date = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") - 2, date("Y"))) ;
        
        $report_args_pre2day = array(
            'from_date' => date('Y-m-d', strtotime($start_date)),
            'to_date' => date('Y-m-d', strtotime($start_date)),
            'system_type' => '108'
            );

        
        //2 days previous data Data
        $Accident_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('15','58'));
        $assault_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('6'));
        $burn_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('14'));
        $attack_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('8','9','10'));
        $fall_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('54'));
        $poision_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('13','23','50'));
        $labour_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('24','34'));
        $light_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('55'));
        $mass_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('56'));
        $report_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('1','3','4','5','7','16','17','18','19','20','22','25','26','27','28','29','30','31','32','37','38','39','47','48','49','51','52','53'));
        $other_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('2','21','35','36','45','46'));
        $trauma_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('33'));
        $suicide_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('40'));
        $delivery_in_amb_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('11','12'));
        $pt_manage_on_veti_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('57'));
        $unavail_call_data_pre2day = $this->inc_model->get_b12_data_dashord_validate($report_args_pre2day,array('41','42','43','44'));

        //Till Month
        $From_date = date('Y-m-01');
        $to_date = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") - 1, date("Y")));
        $report_args_till_month = array(
            'from_date' => date('Y-m-d', strtotime($From_date)),
            'to_date' => date('Y-m-d', strtotime($to_date)),
            'system_type' => '108'
            );
        $Accident_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('15','58'));
        $assault_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('6'));
        $burn_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('14'));
        $attack_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('8','9','10'));
        $fall_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('54'));
        $poision_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('13','23','50'));
        $labour_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('24','34'));
        $light_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('55'));
        $mass_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('56'));
        $report_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('1','3','4','5','7','16','17','18','19','20','22','25','26','27','28','29','30','31','32','37','38','39','47','48','49','51','52','53'));
        $other_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('2','21','35','36','45','46'));
        $trauma_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('33'));
        $suicide_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('40'));
        $delivery_in_amb_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('11','12'));
        $pt_manage_on_veti_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('57'));
        $unavail_call_data_tm = $this->inc_model->get_b12_data_dashord_validate($report_args_till_month,array('41','42','43','44'));


        $inc_data[]=array(
                        //Without validation  
                        'Accident_data_today' => $Accident_data_today[0]->total_count,
                        'assault_data_today' => $assault_data_today[0]->total_count,
                        'burn_data_today' => $burn_data_today[0]->total_count,
                        'attack_data_today' => $attack_data_today[0]->total_count,
                        'fall_data_today' => $fall_data_today[0]->total_count,
                        'poision_data_today' => $poision_data_today[0]->total_count,
                        'labour_data_today' => $labour_data_today[0]->total_count,
                        'light_data_today' => $light_data_today[0]->total_count,
                        'mass_data_today' => $mass_data_today[0]->total_count,
                        'report_data_today' => $report_data_today[0]->total_count,
                        'other_data_today' => $other_data_today[0]->total_count,
                        'trauma_data_today' => $trauma_data_today[0]->total_count,
                        'suicide_data_today'=>$suicide_data_today[0]->total_count,
                        'delivery_in_amb_data_today' => $delivery_in_amb_data_today[0]->total_count,
                        'pt_manage_on_veti_data_today' => $pt_manage_on_veti_data_today[0]->total_count,
                        'unavail_call_data_today'=>$unavail_call_data_today[0]->total_count,
                        //with validation
                        'Accident_data_today1' => $Accident_data_today1[0]->total_count,
                        'assault_data_today1' => $assault_data_today1[0]->total_count,
                        'burn_data_today1' => $burn_data_today1[0]->total_count,
                        'attack_data_today1' => $attack_data_today1[0]->total_count,
                        'fall_data_today1' => $fall_data_today1[0]->total_count,
                        'poision_data_today1' => $poision_data_today1[0]->total_count,
                        'labour_data_today1' => $labour_data_today1[0]->total_count,
                        'light_data_today1' => $light_data_today1[0]->total_count,
                        'mass_data_today1' => $mass_data_today1[0]->total_count,
                        'report_data_today1' => $report_data_today1[0]->total_count,
                        'other_data_today1' => $other_data_today1[0]->total_count,
                        'trauma_data_today1' => $trauma_data_today1[0]->total_count,
                        'suicide_data_today1'=>$suicide_data_today1[0]->total_count,
                        'delivery_in_amb_data_today1' => $delivery_in_amb_data_today1[0]->total_count,
                        'pt_manage_on_veti_data_today1' => $pt_manage_on_veti_data_today1[0]->total_count,
                        'unavail_call_data_today1'=>$unavail_call_data_today1[0]->total_count,

                        'Accident_data' => $Accident_data_pre2day[0]->total_count,
                        'assault_data' => $assault_data_pre2day[0]->total_count,
                        'burn_data' => $burn_data_pre2day[0]->total_count,
                        'attack_data' => $attack_data_pre2day[0]->total_count,
                        'fall_data' => $fall_data_pre2day[0]->total_count,
                        'poision_data' => $poision_data_pre2day[0]->total_count,
                        'labour_data' => $labour_data_pre2day[0]->total_count,
                        'light_data' => $light_data_pre2day[0]->total_count,
                        'mass_data' => $mass_data_pre2day[0]->total_count,
                        'report_data' => $report_data_pre2day[0]->total_count,
                        'trauma_data' => $trauma_data_pre2day[0]->total_count,
                        'suicide_data'=> $suicide_data_pre2day[0]->total_count,
                        'delivery_in_amb_data' => $delivery_in_amb_data_pre2day[0]->total_count,
                        'pt_manage_on_veti_data' => $pt_manage_on_veti_data_pre2day[0]->total_count,
                        'unavail_call_data'=>$unavail_call_data_pre2day[0]->total_count,
                        'other_data' => $other_data_pre2day[0]->total_count,
                        
                        'Accident_data_tm' => $Accident_data_tm[0]->total_count,
                        'assault_data_tm' => $assault_data_tm[0]->total_count,
                        'burn_data_tm' => $burn_data_tm[0]->total_count,
                        'attack_data_tm' => $attack_data_tm[0]->total_count,
                        'fall_data_tm' => $fall_data_tm[0]->total_count,
                        'poision_data_tm' => $poision_data_tm[0]->total_count,
                        'labour_data_tm' => $labour_data_tm[0]->total_count,
                        'light_data_tm' => $light_data_tm[0]->total_count,
                        'mass_data_tm' => $mass_data_tm[0]->total_count,
                        'report_data_tm' => $report_data_tm[0]->total_count,
                        'trauma_data_tm' => $trauma_data_tm[0]->total_count,
                        'suicide_data_tm' => $suicide_data_tm[0]->total_count,
                        'delivery_in_amb_data_tm'=> $delivery_in_amb_data_tm[0]->total_count,
                        'pt_manage_on_veti_data_tm' => $pt_manage_on_veti_data_tm[0]->total_count,
                        'unavail_call_data_tm' => $unavail_call_data_tm[0]->total_count,
                        'other_data_tm'=> $other_data_tm[0]->total_count,
                            
                        /*'Accident_data' => $this->Dashboard_model_final->get_b12_report_pre2day_new('Accident_Vehicle'),
                        'assault_data' => $this->Dashboard_model_final->get_b12_report_pre2day_new('Assault'),
                        'burn_data' => $this->Dashboard_model_final->get_b12_report_pre2day_new('Burns'),
                        'attack_data' => $this->Dashboard_model_final->get_b12_report_pre2day_new('Cardiac'),
                        'fall_data' => $this->Dashboard_model_final->get_b12_report_pre2day_new('Fall'),
                        'poision_data' => $this->Dashboard_model_final->get_b12_report_pre2day_new('Intoxication_Poisoning'),
                        'labour_data' => $this->Dashboard_model_final->get_b12_report_pre2day_new('Labour_Pregnancy'),
                        'light_data' => $this->Dashboard_model_final->get_b12_report_pre2day_new('Lighting_Electrocution'),
                        'mass_data' => $this->Dashboard_model_final->get_b12_report_pre2day_new('Mass_casualty'),
                        'report_data' => $this->Dashboard_model_final->get_b12_report_pre2day_new('Medical'),
                        'trauma_data' => $this->Dashboard_model_final->get_b12_report_pre2day_new('Poly_Trauma'),
                        'suicide_data'=> $this->Dashboard_model_final->get_b12_report_pre2day_new('Suicide_Self_Inflicted_Injury'),
                        'delivery_in_amb_data' => $this->Dashboard_model_final->get_b12_report_pre2day_new('Deliveries_in_Ambulance'),
                        'pt_manage_on_veti_data' => $this->Dashboard_model_final->get_b12_report_pre2day_new('Patient_Manage_on_Ventilator'),
                        'unavail_call_data'=>$this->Dashboard_model_final->get_b12_report_pre2day_new('Unavailed_Call'),
                        'other_data' => $this->Dashboard_model_final->get_b12_report_pre2day_new('Others'),
                        
                        'Accident_data_tm' => $this->Dashboard_model_final->get_b12_report_tm_new('Accident_Vehicle'),
                        'assault_data_tm' => $this->Dashboard_model_final->get_b12_report_tm_new('Assault'),
                        'burn_data_tm' => $this->Dashboard_model_final->get_b12_report_tm_new('Burns'),
                        'attack_data_tm' => $this->Dashboard_model_final->get_b12_report_tm_new('Cardiac'),
                        'fall_data_tm' => $this->Dashboard_model_final->get_b12_report_tm_new('Fall'),
                        'poision_data_tm' => $this->Dashboard_model_final->get_b12_report_tm_new('Intoxication_Poisoning'),
                        'labour_data_tm' => $this->Dashboard_model_final->get_b12_report_tm_new('Labour_Pregnancy'),
                        'light_data_tm' => $this->Dashboard_model_final->get_b12_report_tm_new('Lighting_Electrocution'),
                        'mass_data_tm' => $this->Dashboard_model_final->get_b12_report_tm_new('Mass_casualty'),
                        'report_data_tm' => $this->Dashboard_model_final->get_b12_report_tm_new('Medical'),
                        'trauma_data_tm' => $this->Dashboard_model_final->get_b12_report_tm_new('Poly_Trauma'),
                        'suicide_data_tm' => $this->Dashboard_model_final->get_b12_report_tm_new('Suicide_Self_Inflicted_Injury'),
                        'delivery_in_amb_data_tm'=> $this->Dashboard_model_final->get_b12_report_tm_new('Deliveries_in_Ambulance'),
                        'pt_manage_on_veti_data_tm' => $this->Dashboard_model_final->get_b12_report_tm_new('Patient_Manage_on_Ventilator'),
                        'unavail_call_data_tm' => $this->Dashboard_model_final->get_b12_report_tm_new('Unavailed_Call'),
                        'other_data_tm'=> $this->Dashboard_model_final->get_b12_report_tm_new('Others'),
                            */
                        'Accident_data_td' => $this->Dashboard_model_final->get_b12_report_new('Accident_Vehicle')+424982,
                        'assault_data_td' => $this->Dashboard_model_final->get_b12_report_new('Assault')+61567,
                        'burn_data_td' => $this->Dashboard_model_final->get_b12_report_new('Burns')+23024,
                        'attack_data_td' => $this->Dashboard_model_final->get_b12_report_new('Cardiac')+13431,
                        'fall_data_td' => $this->Dashboard_model_final->get_b12_report_new('Fall')+138025,
                        'poision_data_td' => $this->Dashboard_model_final->get_b12_report_new('Intoxication_Poisoning')+165926,
                        'labour_data_td' => $this->Dashboard_model_final->get_b12_report_new('Labour_Pregnancy')+1216628,
                        'light_data_td' => $this->Dashboard_model_final->get_b12_report_new('Lighting_Electrocution')+5872,
                        'mass_data_td' => $this->Dashboard_model_final->get_b12_report_new('Mass_casualty')+22952,
                        'report_data_td' => $this->Dashboard_model_final->get_b12_report_new('Medical')+3346572,
                        'trauma_data_td' => $this->Dashboard_model_final->get_b12_report_new('Poly_Trauma')+8601,
                        'suicide_data_td' => $this->Dashboard_model_final->get_b12_report_new('Suicide_Self_Inflicted_Injury')+5065,
                        'delivery_in_amb_data_td'=> $this->Dashboard_model_final->get_b12_report_new('Deliveries_in_Ambulance')+36647,
                        'pt_manage_on_veti_data_td' => $this->Dashboard_model_final->get_b12_report_new('Patient_Manage_on_Ventilator')+3755,
                        'unavail_call_data_td' => $this->Dashboard_model_final->get_b12_report_new('Unavailed_Call'),
                        'other_data_td'=> $this->Dashboard_model_final->get_b12_report_new('Others')+742866,
                    );
                if($this->input->post('to_date') != '' && $this->input->post('from_date') != ''){
                $from_date=$this->input->post('from_date');
                $to_date=$this->input->post('to_date');
                
                $data['to_date'] = $this->input->post('to_date');
                $data['from_date'] = $this->input->post('from_date');
              
                
                $report_args2 = array('from_date' => date('Y-m-d', strtotime($from_date)),
                                 'to_date' => date('Y-m-d', strtotime($to_date)),
                                 'system_type' => '108'
                                 );
                
                $Accident_data_till = $this->inc_model->get_b12_data_dashord_validate($report_args2,array('15','58'));
                $assault_data_till = $this->inc_model->get_b12_data_dashord_validate($report_args2,array('6'));
                $burn_data_till = $this->inc_model->get_b12_data_dashord_validate($report_args2,array('14'));
                $attack_data_till = $this->inc_model->get_b12_data_dashord_validate($report_args2,array('8','9','10'));
                $fall_data_till = $this->inc_model->get_b12_data_dashord_validate($report_args2,array('54'));
                $poision_data_till = $this->inc_model->get_b12_data_dashord_validate($report_args2,array('13','23','50'));
                $labour_data_till = $this->inc_model->get_b12_data_dashord_validate($report_args2,array('24','34'));
                $light_data_till = $this->inc_model->get_b12_data_dashord_validate($report_args2,array('55'));
                $mass_data_till = $this->inc_model->get_b12_data_dashord_validate($report_args2,array('56'));
                $report_data_till = $this->inc_model->get_b12_data_dashord_validate($report_args2,array('1','3','4','5','7','16','17','18','19','20','22','25','26','27','28','29','30','31','32','37','38','39','47','48','49','51','52','53'));
                $other_data_till = $this->inc_model->get_b12_data_dashord_validate($report_args2,array('2','21','35','36','45','46'));
                $trauma_data_till = $this->inc_model->get_b12_data_dashord_validate($report_args2,array('33'));
                $suicide_data_till = $this->inc_model->get_b12_data_dashord_validate($report_args2,array('40'));
                $delivery_in_amb_data_till = $this->inc_model->get_b12_data_dashord_validate($report_args2,array('11','12'));
                $pt_manage_on_veti_data_till = $this->inc_model->get_b12_data_dashord_validate($report_args2,array('57'));
                $unavail_call_data_till = $this->inc_model->get_b12_data_dashord_validate($report_args2,array('41','42','43','44'));
            
                $inc_data[0]['Accident_data'] = $Accident_data_till[0]->total_count;
                $inc_data[0]['assault_data'] = $assault_data_till[0]->total_count;
                $inc_data[0]['burn_data'] = $burn_data_till[0]->total_count;
                $inc_data[0]['attack_data'] = $attack_data_till[0]->total_count;
                $inc_data[0]['fall_data'] = $fall_data_till[0]->total_count;
                $inc_data[0]['poision_data'] = $poision_data_till[0]->total_count;
                $inc_data[0]['labour_data'] = $labour_data_till[0]->total_count;
                $inc_data[0]['light_data'] = $light_data_till[0]->total_count;
                $inc_data[0]['mass_data'] = $mass_data_till[0]->total_count;
                $inc_data[0]['report_data'] = $report_data_till[0]->total_count;
                $inc_data[0]['other_data'] = $other_data_till[0]->total_count;
                $inc_data[0]['trauma_data'] = $trauma_data_till[0]->total_count;
                $inc_data[0]['suicide_data'] = $suicide_data_till[0]->total_count;
                $inc_data[0]['delivery_in_amb_data'] = $delivery_in_amb_data_till[0]->total_count;
                $inc_data[0]['pt_manage_on_veti_data'] = $pt_manage_on_veti_data_till[0]->total_count;
                $inc_data[0]['unavail_call_data'] = $unavail_call_data_till[0]->total_count;
            }
            $data['inc_data'] = $inc_data;
            $data['clg_ref_id'] = $this->clg->clg_ref_id;
            if($this->input->post('to_date') != '' && $this->input->post('from_date') != ''){
                $this->output->add_to_position($this->load->view('frontend/dash/nhm_b12_reports_view_new', $data, TRUE), 'b12_data_block', TRUE); 
            }else{
              $this->output->add_to_position($this->load->view('frontend/dash/nhm_b12_reports_view_new', $data, TRUE), 'content', TRUE);
            }
            $this->output->template = "nhm_blank"; 
    }
}
