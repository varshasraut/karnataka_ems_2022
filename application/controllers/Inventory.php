<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends EMS_Controller {

    function __construct() {

        parent::__construct();
        
        $this->active_module = "M-INVENT";   

        $this->pg_limit =$this->config->item('pagination_limit_clg');
        
        $this->pg_limits =$this->config->item('report_clg');

        $this->load->model(array('colleagues_model','options_model','module_model'));
 
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date'));

        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));

        $this->active_module = "M-INVENT";
        
        $this->site_name=$this->config->item('site_name');
        
        $this->site=$this->config->item('site');

    }

public function index($generated = false) {
    echo "This is Inventory controller";
}

}