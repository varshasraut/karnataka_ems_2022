<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Module extends EMS_Controller
{
 
  function __construct(){
    parent::__construct();
	
     $this->load->database();
     $this->load->model('module_model');
	 $this->active_menu = "users";
	
  }
 
    public function index(){

        $data = array();
        $this->output->add_to_position("User controller loaded");	
      
	
    }
    function login(){
        $data = array();
        $this->output->add_to_position($this->load->view('ms-admin/login_view',$data,true));
        $this->output->template = "cell";
    }
     function register(){
        $data = array();
        $this->output->add_to_position($this->load->view('ms-admin/register_view',$data,true));
    }
	
  public function permission(){
	
	$data = array();
	$modules = array();
	$user_gcode = "";
	$modules_data = "";
	$user_code = "UG-ADMIN";
	$res_permission = "";

	    if($this->input->post('modules')) {
                  
				$user_gcode = $this->input->post('user_group');
				$modules = $this->input->post('modules');
				$modules_data = serialize($modules);
				
				$res_permission = $this->module_model->add_group_permissions($user_gcode,$modules_data);
				if($res_permission)
				{    
					$this->output->status = 1;
					$this->output->message =  "<div class='success'>Permission Settting  Successfully!</div>"; 
					
				}else{
					
					$this->output->message =  "<div class='error'>Error Occur</div>"; 
				}
				
	 }
	     
	 $data['user_code'] = $user_code;
	 $ug = $this->input->post('user_group');
	 if(!empty($ug)) {  $data['user_code'] = $ug; 	 }

	 $data['group_permissions'] = $this->module_model->get_modules_and_tools($data['user_code']); 
    

     $data['users'] =  $this->module_model->get_users_groups();
    
	 $this->output->add_to_position($this->load->view('ems-admin/permission_view',$data,true));
 
  }
  
 
}