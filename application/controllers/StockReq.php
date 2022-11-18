<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class StockReq extends EMS_Controller {

    
    function __construct() {

        parent::__construct();

        $this->active_module = "M-AMBU";   

        $this->load->model(array('common_model','inv_model','manufacture_model','stock_req_model'));
 
        $this->load->helper(array('url','comman_helper'));

        $this->load->library(array( 'session' , 'modules'));
        
        $this->post=$this->input->get_post(NULL);
     
        
    }

    function index($generated = false) {

        echo "This is Inventory controller";

    }

    
    
    //// Created by MI42 ////////////////////
    // 
    // Purpose : To add stock reqest.
    // 
    /////////////////////////////////////////
    
    function add_stock_req(){
        
        if($this->post['submit_req']){
            
            $today=date('Y-m-d H:i:s');
            
            $item_key=array('CA','NCA','MED','EQP');
            
             foreach ($item_key as $key){
          
                 foreach($this->post['item'][$key] as $dt){
                 
                    if(!empty($dt['id'])){ 
                     
                        $ind_data=array(
                                        'ind_item_id'=>$dt['id'],
                                        'ind_quantity'=>$dt['qty'],
                                        'ind_item_type'=>$key,
                                        'ind_req_id'=>'1',
                                        'ind_date'=>$today

                                        );
                 
                               
                 
                        $result = $this->stock_req_model->insert_ind($ind_data);
                        
                    }
            
                 }
             }
            
            
            
            
        }else{
        
            $this->output->add_to_position($this->load->view('frontend/amb/StockReq/add_sreq_view',$data,TRUE),'',TRUE);
        
            
        }
        
    }
    
}