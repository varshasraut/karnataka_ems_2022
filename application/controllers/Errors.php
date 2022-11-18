<?php defined('BASEPATH') OR exit('No direct script access allowed');

 

class Errors extends EMS_Controller

{

       public function __construct() 

    {

        parent::__construct(); 

    } 



    public function index() 

    { 

        $this->output->set_status_header('404'); 

		$this->output->add_to_position($this->load->view('errors/html/error_404',$data,true));	

        $this->output->template = "blank";

    } 

} 

?>