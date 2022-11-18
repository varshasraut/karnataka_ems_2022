<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_job extends EMS_Controller {	
    
     function __construct() {

        parent::__construct();

        $this->pg_limit = $this->config->item('pagination_limit');

        $this->pg_limits = $this->config->item('report_clg');

        $this->load->model(array('pet_model','call_model', 'get_city_state_model', 'options_model', 'module_model', 'common_model', 'Pet_model', 'Ercp_model', 'amb_model', 'inc_model', 'colleagues_model', 'pcr_model', 'cluster_model', 'medadv_model', 'enquiry_model', 'module_model', 'feedback_model', 'quality_model', 'grievance_model', 'police_model','fire_model','problem_reporting_model','hp_model','shiftmanager_model','biomedical_model'));

        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper', 'language_helper','cct_helper','dash_helper','coral_helper'));
        
        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));
        
        $this->site_name = $this->config->item('site_name');
         $this->post = $this->input->get_post(NULL);
        $this->post['base_month'] = get_base_month();
        $this->site = $this->config->item('site');
         $this->sess_expiration = $this->config->item('sess_expiration');
        $this->clg = $this->session->userdata('current_user');
        $this->default_state = $this->config->item('default_state');
        //$this->post['base_month'] = get_base_month();
        $this->clg = $this->session->userdata('current_user');
        $this->today = date('Y-m-d H:i:s');
   
    }
    
    public function index()	{		   
        $data = array();                                           
        $this->output->add_to_position($this->load->view('frontend/result2_view',$data,TRUE));      
        $this->output->template = "cell";	
    }   
   
    function update_ambulance_status_cron(){
        
        $args_dash = array(
                'inc_date' => date('Y-m-d', strtotime("-1 days")),
                
            );
        
        $incidence = $this->pcr_model->get_inc_by_max_assign($args_dash);
        
      
        if($incidence){
            foreach($incidence as $inc){

                if( $inc->assigned_time < date('Y-m-d')){
                   
                    $amb_args = array('amb_rto_register_no' => $inc->amb_rto_register_no);
                    $amb_data = $this->amb_model->get_amb_data_listing($amb_args);
                   
                   
                    if($amb_data[0]->amb_status == 2 ){
                        
                        $upadate_amb_data = array('amb_rto_register_no' => $inc->amb_rto_register_no,'amb_status' => 1);
                        $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
                    }

                }

            }
        }
       die();

    }
    function wrap_out_cron(){
    
        
        $wrap_data = $this->call_model->get_wrap_status();
        
      
        if($wrap_data){
            foreach($wrap_data as $wrap){
               

                if( strtotime($wrap->wrap_time) < strtotime("-35 seconds")){
                   
                    $avaya_server_url = $this->avaya_server_url . '/SetAgentAction';

                    $unique_id = $ext_no . '_' . time();
                    $avaya_args = array('ActionID' => $unique_id,
                        'AgentID' => $wrap->agent_id,
                        'AgentExtension' => $wrap->extension_no,
                        'AgentCampaign' => 201,
                        'AgentAction' => 'WO',
                        'AgentActionParam' =>  $wrap->agent_id);

                    $avaya_data = json_encode($avaya_args);

                    if ($wrap->extension_no != '' || $wrap->extension_no != null) {
                        $avaya_res = cct_agent_action($avaya_server_url, $avaya_data, $unique_id);
                           file_put_contents('./logs/'.date("Y-m-d").'/'.date("Y-m-d").'avaya_wrapout_log.log', $avaya_data.",\r\n", FILE_APPEND);
                           
                           $this->call_model->delete_wrap_status(array('extension_no'=>$wrap->extension_no,'agent_id'=> $wrap->agent_id));
                    }
                }
            }
            
        }
        
        
    }
    
    function store_lat_lng_table(){
        $dbhost   = "localhost";
        $dbuser   = "admin";
        $dbpwd    = "Mems@123$";   
        $dbname   = "mhems_2020";
 
        $dumpfile = "/var/www/html/mhems/backup/db_backup/ems_mas_amb_latlong.sql";      
        system("mysqldump --opt --host=$dbhost --user=$dbuser --password='$dbpwd'  --no-create-info $dbname ems_mas_amb_latlong  > $dumpfile");      
        die();
    }
    
    function delete_lat_lng_table(){
       $hours = date('H');
       $minutes = date('i');
       $args_dash = array(
                'to_date' => date('Y-m-d', strtotime("-3 days")),
                
            );
       
      // if($hours == '01' && $minutes < '25'){
           $delete_data = $this->amb_model->get_amb_lat_lng_delete($args_dash);
      // }
    }
    
    
    
}