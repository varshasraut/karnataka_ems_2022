<?php
Class Screendashboard2 extends EMS_Controller{
    
        function __construct() {

        parent::__construct();

      $this->active_module = "M-SCR-DSB";

        $this->load->model(array('inc_model','student_model'));

        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper', 'language_helper'));

        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));


        $this->site_name=$this->config->item('site_name');


        $this->post['base_month'] = get_base_month();
        $this->clg = $this->session->userdata('current_user');
        
    }
    function index() {
       
        $current_date =  date('Y-m-d');
        $report_args =  array('from_date' => date('Y-m-d',strtotime($current_date)),
                              'to_date' => date('Y-m-d',strtotime($current_date)));
        

        
        $report_data = $this->inc_model->get_active_inc_total($report_args);
        $data['today_inc'] = $report_data[0]->total_calls;
        
        $current_month = date('m');
        $current_year = date('Y');
        $current_month_date =  $current_year.'-'.$current_month.'-01';
        $args =  array('from_date' => date('Y-m-d',strtotime($current_month_date)),
                       'to_date' => date('Y-m-d',strtotime($current_date)));

        
        $nov_data = $this->inc_model->get_active_inc_total($args);
        $data['nov_today_inc'] = $nov_data[0]->total_calls;
        
        $total_data = $this->inc_model->get_active_inc_total();
        $data['total_inc'] = $total_data[0]->total_calls;
        
        $report_args['get_count'] = 'true';
        $today_screening = $this->inc_model->get_epcr_by_date_group_inc($report_args);
        $data['today_screening']=count($today_screening);

        $current_year = date('Y');
        $current_month = date('m');
        $current_month_date =  $current_year.'-'.$current_month.'-01';
        $args =  array('from_date' => date('Y-m-d',strtotime($current_month_date)),
                       'to_date' => date('Y-m-d',strtotime($current_date)));
        $args['get_count'] = 'true';
        
        $nov_screening = $this->inc_model->get_epcr_by_date_group_inc($args);
        $data['nov_screening']=count($nov_screening);
        
        $total_args['get_count'] = 'true';
        $total_screening = $this->inc_model->get_epcr_by_date_group_inc($total_args);
       
        $data['total_screening']=count($total_screening);
        
        
        $this->output->add_to_position($this->load->view('frontend/dash/screendashboard_calls', $data, TRUE), 'content', TRUE);
        $this->output->template = "blank";
    }

    
}	