<?php
Class Screendashboard extends EMS_Controller{
    
        function __construct() {

        parent::__construct();

      $this->active_module = "M-SCR-DSB";

        $this->load->model(array('inc_model','student_model','Dashboard_model_final'));

        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper', 'language_helper'));

        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));


        $this->site_name=$this->config->item('site_name');


        $this->post['base_month'] = get_base_month();
        $this->clg = $this->session->userdata('current_user');
        
    }
    function index() {
       

        $data['count'] = $this->Dashboard_model_final->get_total_calls_frm_dashboard_tbl();
        
        
        $data['total_calls_td'] = $this->Dashboard_model_final->get_total_calls_td("td")+22241019;
        //$data['total_calls_td_108'] = $this->Dashboard_model_final->get_total_calls_108();
        //$data['total_calls_td_102'] = $this->Dashboard_model_final->get_total_calls_102();
        
        $data['total_dispatch_108'] = $this->Dashboard_model_final->get_total_type_calls_today($cond='eme', $duration="td","108")+3602556;
        $data['total_dispatch_102'] = $this->Dashboard_model_final->get_total_type_calls_today($cond='eme', $duration="td","102");
        
        $data['today_call_108'] = $this->Dashboard_model_final->get_total_type_calls_today($cond='', $duration="to","108");
        $data['today_call_102'] = $this->Dashboard_model_final->get_total_type_calls_today($cond='', $duration="to","102");
        
        $data['today_dispatch_108'] = $this->Dashboard_model_final->get_total_type_calls_today($cond='eme', $duration="to","108");
        $data['today_noneme_108'] = $this->Dashboard_model_final->get_total_type_calls_today($cond='non-eme', $duration="to","108");
        //$data['today_dispatch_102'] = $this->Dashboard_model_final->get_total_type_calls_today($cond='eme', $duration="to","102");
        
        $data['corona_calls'] = $this->Dashboard_model_final->get_corona_calls();
        $data['preganancy_calls'] = $this->Dashboard_model_final->get_preganancy_calls();
        $data['assists_calls'] = $this->Dashboard_model_final->get_assists_calls();
        
        $data['rta_calls'] = $this->Dashboard_model_final->get_rta();
        $data['non_vahicular_calls'] = $this->Dashboard_model_final->get_non_vahicular();
        $data['call_per_minute'] = $this->inc_model->avarage_call_per_minute();
        
        $report_args =  array('from_date' => date('Y-m-d H:i:s'),
                              'to_date' => date('Y-m-d H:i:s',strtotime('-30 Min')));

        $report_data = $this->Dashboard_model_final->get_rta_inc($report_args);
        $data['current_accident'] = $report_data[0]->total_calls;
        
        $this->output->add_to_position($this->load->view('frontend/dash/ScreenDashboard', $data, TRUE), 'content', TRUE);
        $this->output->template = "blank";
    }

    
}	