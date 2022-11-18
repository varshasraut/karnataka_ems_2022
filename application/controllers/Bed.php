<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bed extends EMS_Controller {

    function __construct() {

        parent::__construct();


        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));
        $this->load->model(array('bed_model','inc_model','amb_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper', 'language_helper'));


        $this->post = $this->input->get_post(NULL);
        $this->post['base_month'] = get_base_month();
        $this->clg = $this->session->userdata('current_user');

        $this->pg_limit = $this->config->item('pagination_limit_clg');
        $this->pg_limits = $this->config->item('report_clg');
        $this->default_state = $this->config->item('default_state');

        if ($this->post['filters'] == 'reset') {
            $this->session->unset_userdata('epcr_filter');
         
        }

        if ($this->session->userdata('epcr_filter')) {
            $this->fdata = $this->session->userdata('epcr_filter');
        }

        $this->today = date('Y-m-d H:i:s');
    }
    function dashboard(){
        $district= $this->clg->clg_district_id;
        $clg_district_id = json_decode($district);
        if(is_array($clg_district_id)){
            $district_id = implode("','",$clg_district_id);
        }
        $args_bed = array('district_id'=>$district_id);
        $data['total_bed'] =$this->bed_model->get_total_bed($args_bed);
        $this->output->add_to_position($this->load->view('frontend/bed/bed_dashboard_view', $data, TRUE), 'content', TRUE);
    }
    function remote_dashboard(){
      
        $district_id = $this->clg->clg_district_id;
            //var_dump($district_id);
            $district_id = explode( ",", $district_id);
            $regex = "([\[|\]|^\"|\"$])"; 
            $replaceWith = ""; 
            $district_id = preg_replace($regex, $replaceWith, $district_id);
            
            if(is_array($district_id)){
                $district_id = implode("','",$district_id);
            }
            $div_code = $this->input->post('div_code');
           
            $args_bed = array('div_code'=>$div_code,'district_id'=>$district_id);
            $district_data = $this->inc_model->get_district_name($args_bed);
            //$div_data = $this->common_model->get_division($args);
            foreach($district_data as $district){
    
                $args_bed = array('district_id'=>$district->dst_code, 'division_id'=> $district->div_code);
                $district_total_bed =$this->bed_model->get_total_bed_division($args_bed);
                $total_beds =0;
                $c19_total_bed =0;
                $C19_Occupied=0;
                $C19_Vacant =0;
    
                $non_c19_total_bed =0;
                $NonC19_Occupied=0;
                $NonC19_Vacant=0;
    
                foreach($district_total_bed as $bed){
                    $total_beds =$total_beds + $bed->C19_Total_Beds + $bed->NonC19_Total_Beds;
    
                    $c19_total_bed = $c19_total_bed + $bed->C19_Total_Beds;
                    $C19_Occupied= $C19_Occupied + $bed->C19_Occupied;
                    $C19_Vacant= $C19_Vacant + $bed->C19_Vacant;
    
                    $non_c19_total_bed = $non_c19_total_bed + $bed->NonC19_Total_Beds;
                    $NonC19_Occupied = $NonC19_Occupied + $bed->NonC19_Occupied;
                    $NonC19_Vacant = $NonC19_Vacant + $bed->NonC19_Vacant;
    
    
                }
                $district_bed[] = array('district_name'=>$district->dst_name,
                    'district_id'=>$district->dst_code,
                    'total_beds'=>$total_beds,
                    'c19_total_bed'=>$c19_total_bed,
                    'C19_Occupied'=>$C19_Occupied,
                    'C19_Vacant'=>$C19_Vacant,
                    
                    'non_c19_total_bed'=>$non_c19_total_bed,
                    'NonC19_Occupied'=>$NonC19_Occupied,
                    'NonC19_Vacant'=>$NonC19_Vacant,
                        
                ); 
    
            }
                $data['district_bed'] = $district_bed;
                $args = array('district_id'=>$district_id,'base_month' => $this->post['base_month']);
                //var_dump($this->clg->thirdparty);
                
                if($this->clg->thirdparty == '4'){
                   $args['thirdparty']=$this->clg->thirdparty;
                    
                }else if($this->clg->thirdparty == '3'){
                    $args['thirdparty']=$this->clg->thirdparty;
                    
                }
               // var_dump($args);
        $data['amb_data'] = $this->amb_model->get_gps_amb_data($args);
        $data['clg_group'] = $clg_group;
        $this->output->add_to_position('', 'call_detail', TRUE);
        $this->output->add_to_position($this->load->view('frontend/bed/remote_dashboard', $data, TRUE), 'content', TRUE);
    }
    function nhm_dashboard(){
        
        $user_group=$this->clg->clg_group;  
        if ($user_group == 'UG-NHM-AMB-TRACKING-DASHBOARD') {
        $args_bed = array('st_code'=>"MP");
        $data['total_bed'] =$this->bed_model->get_total_bed($args_bed);
       // var_dump($this->post['base_month']); die();
       $clg_group =  $this->clg->clg_group;
        if( $clg_group == 'UG-NHM-DASHBOARD')
        {
            $args = array('div_code'=>$this->clg->clg_zone,'district_id'=>$district_id,'base_month' => $this->post['base_month'],'thirdparty' =>"1','2");
            $args_pcmc = array('div_code'=>$this->clg->clg_zone,'district_id'=>$district_id,'base_month' => $this->post['base_month'],'thirdparty' =>'3');
            $args_pmc = array('div_code'=>$this->clg->clg_zone,'district_id'=>$district_id,'base_month' => $this->post['base_month'],'thirdparty' =>'4');
        }
        
        elseif($clg_group == 'UG-DIVISIONAL-OPERATION-HEAD')
        {
            $division = $this->clg->clg_zone;
            $district_id = explode( ",", $district_id);
            $regex = "([\[|\]|^\"|\"$])"; 
             $replaceWith = ""; 
            $district_id = preg_replace($regex, $replaceWith, $district_id);
            if(is_array($district_id)){
                $district_id = implode("','",$district_id);
            }
         
            $args = array('st_code'=>'MP','div_code'=>$division,'district_id'=>$district_id);
            $district_data = $this->common_model->get_division($args);
            //var_dump($district_data);die();
            $total_beds =0;
                $c19_total_bed =0;
                $C19_Occupied=0;
                $C19_Vacant =0;
    
                $non_c19_total_bed =0;
                $NonC19_Occupied=0;
                $NonC19_Vacant=0;
            foreach($district_data as $district){
    
                $args_bed = array('division_id'=> $district->div_code);
              
                
                $district_total_bed =$this->bed_model->get_total_bed_division($args_bed);
                
                                
                $total_beds =0;
                $c19_total_bed =0;
                $C19_Occupied=0;
                $C19_Vacant =0;
    
                $non_c19_total_bed =0;
                $NonC19_Occupied=0;
                $NonC19_Vacant=0;
    
                foreach($district_total_bed as $bed){
    
                    
                    $total_beds =$total_beds + $bed->C19_Total_Beds + $bed->NonC19_Total_Beds;
    
                    $c19_total_bed = $c19_total_bed + $bed->C19_Total_Beds;
                    $C19_Occupied= $C19_Occupied + $bed->C19_Occupied;
                    $C19_Vacant= $C19_Vacant + $bed->C19_Vacant;
    
                    $non_c19_total_bed = $non_c19_total_bed + $bed->NonC19_Total_Beds;
                    $NonC19_Occupied = $NonC19_Occupied + $bed->NonC19_Occupied;
                    $NonC19_Vacant = $NonC19_Vacant + $bed->NonC19_Vacant;
    
                    
                }
                
                    $district_bed[$district->div_code] = array('div_name'=>$district->div_name,
                    'div_code'=>$district->div_code,
                    'total_beds'=>$total_beds,
                    'c19_total_bed'=>$c19_total_bed,
                    'C19_Occupied'=>$C19_Occupied,
                    'C19_Vacant'=>$C19_Vacant,
                    
                    'non_c19_total_bed'=>$non_c19_total_bed,
                    'NonC19_Occupied'=>$NonC19_Occupied,
                    'NonC19_Vacant'=>$NonC19_Vacant,
                
                    
                ); 
            }
             $data['district_bed'] = $district_bed;
             $args = array('div_code'=>$this->clg->clg_zone,'base_month' => $this->post['base_month'],'thirdparty' =>"1','2");
             $args_pcmc = array('div_code'=>$this->clg->clg_zone,'district_id'=>$district_id,'base_month' => $this->post['base_month'],'thirdparty' =>'3');
            $args_pmc = array('div_code'=>$this->clg->clg_zone,'district_id'=>$district_id,'base_month' => $this->post['base_month'],'thirdparty' =>'4');
        
        }
        elseif($clg_group == 'UG-DISTRICT-OPERATIONAL-HEAD'){
         
            $district_id = $this->clg->clg_district_id;
            //var_dump($district_id);
            $district_id = explode( ",", $district_id);
            $regex = "([\[|\]|^\"|\"$])"; 
            $replaceWith = ""; 
            $district_id = preg_replace($regex, $replaceWith, $district_id);
            
            if(is_array($district_id)){
                $district_id = implode("','",$district_id);
            }
            $div_code = $this->input->post('div_code');
           
            $args_bed = array('div_code'=>$div_code,'district_id'=>$district_id);
            $district_data = $this->inc_model->get_district_name($args_bed);
            //$div_data = $this->common_model->get_division($args);
            foreach($district_data as $district){
    
                $args_bed = array('district_id'=>$district->dst_code, 'division_id'=> $district->div_code);
                $district_total_bed =$this->bed_model->get_total_bed_division($args_bed);
                $total_beds =0;
                $c19_total_bed =0;
                $C19_Occupied=0;
                $C19_Vacant =0;
    
                $non_c19_total_bed =0;
                $NonC19_Occupied=0;
                $NonC19_Vacant=0;
    
                foreach($district_total_bed as $bed){
                    $total_beds =$total_beds + $bed->C19_Total_Beds + $bed->NonC19_Total_Beds;
    
                    $c19_total_bed = $c19_total_bed + $bed->C19_Total_Beds;
                    $C19_Occupied= $C19_Occupied + $bed->C19_Occupied;
                    $C19_Vacant= $C19_Vacant + $bed->C19_Vacant;
    
                    $non_c19_total_bed = $non_c19_total_bed + $bed->NonC19_Total_Beds;
                    $NonC19_Occupied = $NonC19_Occupied + $bed->NonC19_Occupied;
                    $NonC19_Vacant = $NonC19_Vacant + $bed->NonC19_Vacant;
    
    
                }
                $district_bed[] = array('district_name'=>$district->dst_name,
                    'district_id'=>$district->dst_code,
                    'total_beds'=>$total_beds,
                    'c19_total_bed'=>$c19_total_bed,
                    'C19_Occupied'=>$C19_Occupied,
                    'C19_Vacant'=>$C19_Vacant,
                    
                    'non_c19_total_bed'=>$non_c19_total_bed,
                    'NonC19_Occupied'=>$NonC19_Occupied,
                    'NonC19_Vacant'=>$NonC19_Vacant,
                        
                ); 
    
            }
                $data['district_bed'] = $district_bed;
                $args = array('district_id'=>$district_id,'base_month' => $this->post['base_month'],'thirdparty' =>"1','2");
                $args_pcmc = array('div_code'=>$this->clg->clg_zone,'district_id'=>$district_id,'base_month' => $this->post['base_month'],'thirdparty' =>'3');
                $args_pmc = array('div_code'=>$this->clg->clg_zone,'district_id'=>$district_id,'base_month' => $this->post['base_month'],'thirdparty' =>'4');
        
            
        }
       // $args = array('district_id'=>$district_id,'base_month' => $this->post['base_month'],'thirdparty' =>"1','2");
        //$args_pcmc = array('div_code'=>$this->clg->clg_zone,'district_id'=>$district_id,'base_month' => $this->post['base_month'],'thirdparty' =>'3');
        //$args_pmc = array('div_code'=>$this->clg->clg_zone,'district_id'=>$district_id,'base_month' => $this->post['base_month'],'thirdparty' =>'4');
        
        $data['amb_data'] = $this->amb_model->get_gps_amb_data($args);

        $data['pcmc_amb_data'] = $this->amb_model->get_gps_amb_data($args_pcmc);

       $data['pmc_amb_data'] = $this->amb_model->get_gps_amb_data($args_pmc);
        
        $data['clg_group'] = $clg_group;
       
        $this->output->add_to_position($this->load->view('frontend/bed/NHM_dashboard', $data, TRUE), 'content', TRUE);
        $this->output->template = "calls_nhm";
       
        //nhm_bed_dashboard_view
    }else{
         dashboard_redirect($user_group,$this->base_url );
    }
    }
    function nhm_bed_dash(){
        $args_bed = array('st_code'=>"MP");
        $data['total_bed'] =$this->bed_model->get_total_bed($args_bed);
        $this->output->add_to_position($this->load->view('frontend/bed/nhm_bed_dashboard_view', $data, TRUE), 'bed_data', TRUE);
        $this->output->template = "calls_nhm";
        //nhm_bed_dashboard_view

    }
    function nhm_dashboard_old(){
        $district_id ='518';
        
            $args_bed = array('district_id'=>$district_id);
            $district_total_bed =$this->bed_model->get_total_bed_district($args_bed);
            
            
            foreach($district_total_bed as $bed){
                $NonC19_Total_Beds =0;
                $c19_total_bed =0;
                $non_c19_total_bed =0;
                $C19_Occupied=0;
                $C19_Vacant=0;
                $NonC19_Occupied=0;
                $NonC19_Vacant=0;

                
                $NonC19_Total_Beds =$NonC19_Total_Beds +  $bed->NonC19_Total_Beds;
                $c19_total_bed =$c19_total_bed + $bed->C19_Total_Beds;
                $non_c19_total_bed =$non_c19_total_bed + $bed->NonC19_Total_Beds;

                $C19_Occupied =$C19_Occupied + $bed->C19_Occupied;
                $C19_Vacant =$C19_Vacant + $bed->C19_Vacant;
                $NonC19_Occupied =$NonC19_Occupied + $bed->NonC19_Occupied;
                $NonC19_Vacant =$NonC19_Vacant + $bed->NonC19_Vacant;
                
                $district_bed[] = array('hp_name'=>$bed->hp_name,
                    'hp_id'=>$bed->hp_id,
                    'NonC19_Total_Beds'=>$NonC19_Total_Beds,
                    'c19_total_bed'=>$c19_total_bed,
                    'non_c19_total_bed'=>$non_c19_total_bed,
                    'C19_Occupied'=>$C19_Occupied,
                    'C19_Vacant'=>$C19_Vacant,
                    'NonC19_Occupied'=>$NonC19_Occupied,
                    'NonC19_Vacant'=>$NonC19_Vacant,

                ); 
            }
        $data['district_bed'] = $district_bed;
        $this->output->add_to_position($this->load->view('frontend/bed/nhm_dashboard_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "calls_nhm";
    }
    function nhm_district_bed(){
       
        $district_code= $this->clg->clg_district_id;
        $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
        $district_id = $this->input->post('district_id');
        $args = array('st_code'=>'MP','div_id'=>$district_id);
      
        $district_data = $this->inc_model->get_district_name($args);
        
        foreach($district_data as $district){
            $args_bed = array('district_id'=>$district->dst_code);
            $district_total_bed =$this->bed_model->get_total_bed_district($args_bed);
            
            $total_beds =0;
            $c19_total_bed =0;
            $non_c19_total_bed =0;
            foreach($district_total_bed as $bed){
                
                 $total_beds =$total_beds + $bed->C19_Total_Beds + $bed->NonC19_Total_Beds;

                $c19_total_bed = $c19_total_bed + $bed->C19_Total_Beds;
                $C19_Occupied= $C19_Occupied + $bed->C19_Occupied;
                $C19_Vacant= $C19_Vacant + $bed->C19_Vacant;

                $non_c19_total_bed = $non_c19_total_bed + $bed->NonC19_Total_Beds;
                $NonC19_Occupied = $NonC19_Occupied + $bed->NonC19_Occupied;
                $NonC19_Vacant = $NonC19_Vacant + $bed->NonC19_Vacant;
                
            }
            $district_bed[] = array('district_name'=>$district->dst_name,
                'district_id'=>$district->dst_code,
                'total_beds'=>$total_beds,
                'c19_total_bed'=>$c19_total_bed,
                'C19_Occupied'=>$C19_Occupied,
                'C19_Vacant'=>$C19_Vacant,
                
                'non_c19_total_bed'=>$non_c19_total_bed,
                'NonC19_Occupied'=>$NonC19_Occupied,
                'NonC19_Vacant'=>$NonC19_Vacant,
               
                
            ); 
            
            
        }
        $data['district_bed'] = $district_bed;
       $this->output->add_to_position($this->load->view('frontend/bed/nhm_bed_district_dashboard_view', $data, TRUE), 'district_data', TRUE);
        $this->output->template = "calls_nhm";
    }
    function nhm_district_bed_blank(){
        $this->output->add_to_position('', 'district_data', TRUE);
        $this->output->add_to_position('', 'division_data', TRUE);
        $this->output->template = "calls_nhm";
    }
    function division_bed(){
        $division = $this->clg->clg_zone;

        $args = array('st_code'=>'MP','div_code'=>$division);
        $district_data = $this->common_model->get_division($args);
        
        //var_dump($district_data);
        foreach($district_data as $district){
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
            $args_bed = array('district_id'=>$district_id);
            $district_total_bed =$this->bed_model->get_total_bed_district($args_bed);
            
            $total_beds =0;
            $c19_total_bed =0;
            $non_c19_total_bed =0;
            foreach($district_total_bed as $bed){
                 
               $total_beds =$total_beds + $bed->C19_Total_Beds + $bed->NonC19_Total_Beds;
                $c19_total_bed =$c19_total_bed + $bed->C19_Total_Beds;
                $non_c19_total_bed =$non_c19_total_bed + $bed->NonC19_Total_Beds;
                
            }
            $district_bed[] = array('district_name'=>$district->div_name,
                'district_id'=>$district->div_code,
                'total_beds'=>$total_beds,
                'c19_total_bed'=>$c19_total_bed,
                'non_c19_total_bed'=>$non_c19_total_bed,
                
            ); 
            
            
        }
        $data['district_bed'] = $district_bed;
        $this->output->add_to_position($this->load->view('frontend/bed/bed_division_dashboard_view', $data, TRUE), 'content', TRUE);
    }
    function nhm_division_bed(){

        $clg_group =  $this->clg->clg_group;
        if( $clg_group == 'UG-NHM-DASHBOARD')
        {
           $division='';
        }
        elseif($clg_group == 'UG-DIVISIONAL-OPERATION-HEAD')
        {
            $division = $this->clg->clg_zone;
           // $district_id = $this->clg->clg_district_id;
        }
        else{
            $division = $this->clg->clg_zone;
            $district_id = $this->clg->clg_district_id;
        }
        $district_id = explode( ",", $district_id);
        $regex = "([\[|\]|^\"|\"$])"; 
         $replaceWith = ""; 
        $district_id = preg_replace($regex, $replaceWith, $district_id);
        if(is_array($district_id)){
            $district_id = implode("','",$district_id);
        }
     
        $args = array('st_code'=>'MP','div_code'=>$division,'district_id'=>$district_id);
        $district_data = $this->common_model->get_division($args);
        //var_dump($district_data);die();
        $total_beds =0;
            $c19_total_bed =0;
            $C19_Occupied=0;
            $C19_Vacant =0;

            $non_c19_total_bed =0;
            $NonC19_Occupied=0;
            $NonC19_Vacant=0;
        foreach($district_data as $district){

            if( $clg_group == 'UG-NHM-DASHBOARD')
            {
                $args_bed = array('district_id'=>$district->dst_code, 'division_id'=> $district->div_code);
                //var_dump($args_bed);die();
            }
            elseif($clg_group == 'UG-DIVISIONAL-OPERATION-HEAD')
             {
                $args_bed = array('division_id'=> $district->div_code);
           // $district_id = $this->clg->clg_district_id;
             }
            else{
                $division = $this->clg->clg_zone;
                $district_id = $this->clg->clg_district_id;
                $district_id = explode( ",", $district_id);
                $regex = "([\[|\]|^\"|\"$])"; 
                 $replaceWith = ""; 
                $district_id = preg_replace($regex, $replaceWith, $district_id);
                if(is_array($district_id)){
                    $district_id = implode("','",$district_id);
                }
                $args_bed = array('district_id'=>$district_id);
            }
            
           // var_dump($district_id);
            $district_total_bed =$this->bed_model->get_total_bed_division($args_bed);
            
                            
            $total_beds =0;
            $c19_total_bed =0;
            $C19_Occupied=0;
            $C19_Vacant =0;

            $non_c19_total_bed =0;
            $NonC19_Occupied=0;
            $NonC19_Vacant=0;

            foreach($district_total_bed as $bed){

                
                $total_beds =$total_beds + $bed->C19_Total_Beds + $bed->NonC19_Total_Beds;

                $c19_total_bed = $c19_total_bed + $bed->C19_Total_Beds;
                $C19_Occupied= $C19_Occupied + $bed->C19_Occupied;
                $C19_Vacant= $C19_Vacant + $bed->C19_Vacant;

                $non_c19_total_bed = $non_c19_total_bed + $bed->NonC19_Total_Beds;
                $NonC19_Occupied = $NonC19_Occupied + $bed->NonC19_Occupied;
                $NonC19_Vacant = $NonC19_Vacant + $bed->NonC19_Vacant;

                
            }
            
                $district_bed[$district->div_code] = array('div_name'=>$district->div_name,
                'div_code'=>$district->div_code,
                'total_beds'=>$total_beds,
                'c19_total_bed'=>$c19_total_bed,
                'C19_Occupied'=>$C19_Occupied,
                'C19_Vacant'=>$C19_Vacant,
                
                'non_c19_total_bed'=>$non_c19_total_bed,
                'NonC19_Occupied'=>$NonC19_Occupied,
                'NonC19_Vacant'=>$NonC19_Vacant,
            
                
            ); 
        }
         $data['district_bed'] = $district_bed;
        $this->output->add_to_position($this->load->view('frontend/bed/nhm_bed_division_dashboard_view', $data, TRUE), 'division_data', TRUE);
        
    }
    
    
    function district_bed(){

        $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
        $args_bed = array('district_id'=>$district_id);
        $args = array('st_code'=>'MP','district_id'=>$district_id);
        $district_data = $this->inc_model->get_district_name($args);
        foreach($district_data as $district){
            $args_bed = array('district_id'=>$district->dst_code);
            $district_total_bed =$this->bed_model->get_total_bed_district($args_bed);
            
            $total_beds =0;
            $c19_total_bed =0;
            $non_c19_total_bed =0;
            foreach($district_total_bed as $bed){
                
                $total_beds =$total_beds + $bed->C19_Total_Beds + $bed->NonC19_Total_Beds;
                $c19_total_bed =$c19_total_bed + $bed->C19_Total_Beds;
                $non_c19_total_bed =$non_c19_total_bed + $bed->NonC19_Total_Beds;
                
            }
            $district_bed[] = array('district_name'=>$district->dst_name,
                'district_id'=>$district->dst_code,
                'total_beds'=>$total_beds,
                'c19_total_bed'=>$c19_total_bed,
                'non_c19_total_bed'=>$non_c19_total_bed,
                
            ); 
            
            
        }
        $data['district_bed'] = $district_bed;
        $this->output->add_to_position($this->load->view('frontend/bed/bed_district_dashboard_view', $data, TRUE), 'content', TRUE);
        
    }
    function nhm_division_bed_district(){

        $clg_group =  $this->clg->clg_group;
        if( $clg_group == 'UG-NHM-DASHBOARD')
        {
           $division='';
        }
        
        elseif($clg_group == 'UG-DIVISIONAL-OPERATION-HEAD')
        {
            $division = $this->clg->clg_zone;
           // $district_id = $this->clg->clg_district_id;
        }
        else{
            $division = $this->clg->clg_zone;
            $district_id = $this->clg->clg_district_id;
        }
       // var_dump($district_id);
        $district_id = explode( ",", $district_id);
        $regex = "([\[|\]|^\"|\"$])"; 
         $replaceWith = ""; 
        $district_id = preg_replace($regex, $replaceWith, $district_id);
        if(is_array($district_id)){
            $district_id = implode("','",$district_id);
        }
        $div_code = $this->input->post('div_code');
        //var_dump($district_id);
        $args_bed = array('div_code'=>$div_code,'district_id'=>$district_id);
        $district_data = $this->inc_model->get_district_name($args_bed);
        //$div_data = $this->common_model->get_division($args);
        foreach($district_data as $district){

            $args_bed = array('district_id'=>$district->dst_code, 'division_id'=> $district->div_code);
            $district_total_bed =$this->bed_model->get_total_bed_division($args_bed);
            $total_beds =0;
            $c19_total_bed =0;
            $C19_Occupied=0;
            $C19_Vacant =0;

            $non_c19_total_bed =0;
            $NonC19_Occupied=0;
            $NonC19_Vacant=0;

            foreach($district_total_bed as $bed){
                $total_beds =$total_beds + $bed->C19_Total_Beds + $bed->NonC19_Total_Beds;

                $c19_total_bed = $c19_total_bed + $bed->C19_Total_Beds;
                $C19_Occupied= $C19_Occupied + $bed->C19_Occupied;
                $C19_Vacant= $C19_Vacant + $bed->C19_Vacant;

                $non_c19_total_bed = $non_c19_total_bed + $bed->NonC19_Total_Beds;
                $NonC19_Occupied = $NonC19_Occupied + $bed->NonC19_Occupied;
                $NonC19_Vacant = $NonC19_Vacant + $bed->NonC19_Vacant;


            }
            $district_bed[] = array('district_name'=>$district->dst_name,
                'district_id'=>$district->dst_code,
                'total_beds'=>$total_beds,
                'c19_total_bed'=>$c19_total_bed,
                'C19_Occupied'=>$C19_Occupied,
                'C19_Vacant'=>$C19_Vacant,
                
                'non_c19_total_bed'=>$non_c19_total_bed,
                'NonC19_Occupied'=>$NonC19_Occupied,
                'NonC19_Vacant'=>$NonC19_Vacant,
                    
            ); 

        }
        $data['district_bed'] = $district_bed;
        $data['clg_group'] = $clg_group;
       $this->output->add_to_position($this->load->view('frontend/bed/nhm_bed_district_dashboard_view', $data, TRUE), 'district_data', TRUE);
        $this->output->template = "calls_nhm";
    }
    function nhm_district_bed_hospital(){
        $district_id = $this->input->post('district_id');
        $clg_group =  $this->clg->clg_group;
        //var_dump($district_id);
        

            $args_bed = array('district_id'=>$district_id);
            $district_bed2 = array('dst_code'=>$district_id);

            $district_data = $this->inc_model->get_district_name($district_bed2);
            $district_name =  $district_data[0]->dst_name;
           //
            $district_total_bed =$this->bed_model->get_total_bed_district($args_bed);
            //var_dump($district_total_bed);die();
            $district_total_beds=0;
            $district_c19_total_bed =0;
            $district_C19_Occupied = 0;
            $district_Vacant =0;


            $district_non_c19_total_bed =0;
            $district_NonC19_Occupied = 0;
            $district_NonC19_Vacant =0;


            foreach($district_total_bed as $bed){
                $total_beds =0;
                $c19_total_bed =0;
                $C19_Occupied=0;
                $C19_Vacant=0;
                $non_c19_total_bed =0;
                $NonC19_Occupied=0;
                $NonC19_Vacant=0;

                $total_beds =$total_beds + $bed->C19_Total_Beds + $bed->NonC19_Total_Beds;
                $c19_total_bed =$c19_total_bed + $bed->C19_Total_Beds;
                $C19_Occupied =$C19_Occupied + $bed->C19_Occupied;
                $C19_Vacant =$C19_Vacant + $bed->C19_Vacant;

                $non_c19_total_bed =$non_c19_total_bed + $bed->NonC19_Total_Beds;
                $NonC19_Occupied =$NonC19_Occupied + $bed->NonC19_Occupied;
                $NonC19_Vacant =$NonC19_Vacant + $bed->NonC19_Vacant;

                $district_total_beds =$district_total_beds + $bed->C19_Total_Beds + $bed->NonC19_Total_Beds;
                $district_c19_total_bed =$district_c19_total_bed + $bed->C19_Total_Beds;
                $district_C19_Occupied = $district_C19_Occupied + $bed->C19_Occupied;
                $district_C19_Vacant = $district_C19_Vacant + $bed->C19_Vacant;

                $district_non_c19_total_bed =$district_non_c19_total_bed + $bed->NonC19_Total_Beds;
                $district_NonC19_Occupied =$district_NonC19_Occupied + $bed->NonC19_Occupied;
                $district_NonC19_Vacant =$district_NonC19_Vacant + $bed->NonC19_Vacant;
                
                $dst_name=$bed->dst_name;
                $district_bed[] = array('hp_name'=>$bed->hp_name,
                    'hp_id'=>$bed->hp_id,
                    'total_beds'=>$total_beds,
                    'c19_total_bed'=>$c19_total_bed,
                    'C19_Occupied'=>$C19_Occupied,
                    'C19_Vacant'=>$C19_Vacant,
                    'non_c19_total_bed'=>$non_c19_total_bed,
                    'NonC19_Occupied'=>$NonC19_Occupied,
                    'NonC19_Vacant'=>$NonC19_Vacant,
                ); 
            }
            $data['district_id']=$district_id;
            $data['district_name']=$district_name;
            $data['district_total_beds']=$district_total_beds;
            $data['district_c19_total_bed']=$district_c19_total_bed;
            $data['district_C19_Occupied']=$district_C19_Occupied;
            $data['district_C19_Vacant']=$district_C19_Vacant;
            $data['district_non_c19_total_bed']=$district_non_c19_total_bed;
            $data['district_NonC19_Occupied']=$district_NonC19_Occupied;
            $data['district_NonC19_Vacant']=$district_NonC19_Vacant;
            
        $data['district_bed'] = $district_bed;
        $data['clg_group'] = $clg_group;
        $this->output->add_to_position('', 'district_data', TRUE);
        $this->output->add_to_position($this->load->view('frontend/bed/nhm_bed_hospital_dashboard_view', $data, TRUE), 'hos_data', TRUE);
        $this->output->template = "calls_nhm";
    }
    function district_bed_hospital(){
        
        $district_id = $this->input->post('district_id');
       // var_dump($district_id);

            $args_bed = array('district_id'=>$district_id);
            $district_total_bed =$this->bed_model->get_total_bed_district($args_bed);
            
            
            foreach($district_total_bed as $bed){
                $total_beds =0;
            $c19_total_bed =0;
            $non_c19_total_bed =0;
                
                $total_beds =$total_beds + $bed->C19_Total_Beds + $bed->NonC19_Total_Beds;
                $c19_total_bed =$c19_total_bed + $bed->C19_Total_Beds;
                $non_c19_total_bed =$non_c19_total_bed + $bed->NonC19_Total_Beds;
                
                $district_bed[] = array('hp_name'=>$bed->hp_name,
                    'hp_id'=>$bed->hp_id,
                    'total_beds'=>$total_beds,
                    'c19_total_bed'=>$c19_total_bed,
                    'non_c19_total_bed'=>$non_c19_total_bed,

                ); 
            }

        $data['district_bed'] = $district_bed;
        $this->output->add_to_position($this->load->view('frontend/bed/bed_hospital_dashboard_view', $data, TRUE), 'content', TRUE);
    }
    function nhm_bed_hospital_wise(){
        $hp_id = $this->input->post('hp_id');
        $district_id = $this->input->post('district_id');
        $clg_group =  $this->clg->clg_group;
        // var_dump($district_id);
 
             $args_bed = array('hp_id'=>$hp_id);
             $district_bed2 = array('dst_code'=>$district_id);
             $district_id_new = array('district_id'=>$district_id);
             $district_total_bed =$this->bed_model->get_total_bed_district($args_bed);
             $district_data = $this->inc_model->get_district_name($district_bed2);
            $district_name =  $district_data[0]->dst_name;
             

            $district_total_bed_new =$this->bed_model->get_total_bed_district($district_id_new);
           
            $district_total_beds=0;
            $district_c19_total_bed =0;
            $district_C19_Occupied = 0;
            $district_Vacant =0;

            $district_non_c19_total_bed =0;
            $district_NonC19_Occupied = 0;
            $district_NonC19_Vacant =0;
            
            foreach($district_total_bed_new as $district_data){

                $district_total_beds =$district_total_beds + $district_data->C19_Total_Beds + $district_data->NonC19_Total_Beds;
                $district_c19_total_bed =$district_c19_total_bed + $district_data->C19_Total_Beds;
                $district_C19_Occupied = $district_C19_Occupied + $district_data->C19_Occupied;
                $district_C19_Vacant = $district_C19_Vacant + $district_data->C19_Vacant;

                $district_non_c19_total_bed =$district_non_c19_total_bed + $district_data->NonC19_Total_Beds;
                $district_NonC19_Occupied =$district_NonC19_Occupied + $district_data->NonC19_Occupied;
                $district_NonC19_Vacant =$district_NonC19_Vacant + $district_data->NonC19_Vacant;
               
            }
            
             
             foreach($district_total_bed as $bed){
                $total_beds =0;
                $c19_total_bed =0;
                $C19_Occupied=0;
                $C19_Vacant=0;
                $non_c19_total_bed =0;
                $NonC19_Occupied=0;
                $NonC19_Vacant=0;
                 
                $total_beds =$total_beds + $bed->C19_Total_Beds + $bed->NonC19_Total_Beds;
                $c19_total_bed =$c19_total_bed + $bed->C19_Total_Beds;
                $C19_Occupied =$C19_Occupied + $bed->C19_Occupied;
                $C19_Vacant =$C19_Vacant + $bed->C19_Vacant;

                $non_c19_total_bed =$non_c19_total_bed + $bed->NonC19_Total_Beds;
                $NonC19_Occupied =$NonC19_Occupied + $bed->NonC19_Occupied;
                $NonC19_Vacant =$NonC19_Vacant + $bed->NonC19_Vacant;
                 
                 $district_bed[] = array('hp_name'=>$bed->hp_name,
                 'hp_id'=>$bed->hp_id,
                 

                 'C19_Total_Beds' =>$bed->C19_Total_Beds,
            'C19_Occupied' =>$bed->C19_Occupied,
            'C19_Vacant' =>$bed->C19_Vacant,
            'C19_Remarks' =>$bed->C19_Remarks,
            'NonC19_Total_Beds' =>$bed->NonC19_Total_Beds,
            'NonC19_Occupied' =>$bed->NonC19_Occupied,
            'NonC19_Vacant' =>$bed->NonC19_Vacant,
            'NonC19_Remarks' =>$bed->NonC19_Remarks,
            'ICUWoVenti_Total_Beds' =>$bed->ICUWoVenti_Total_Beds,
            'ICUWoVenti_Occupied' =>$bed->ICUWoVenti_Occupied,
            'ICUWoVenti_Vacant' =>$bed->ICUWoVenti_Vacant,
            'ICUWoVenti_Remarks' =>$bed->ICUWoVenti_Remarks,
            'ICUwithVenti_Total_Beds' =>$bed->ICUwithVenti_Total_Beds,
            'ICUwithVenti_Occupied' =>$bed->ICUwithVenti_Occupied,
            'ICUwithVenti_Vacant' =>$bed->ICUwithVenti_Vacant,
            'ICUwithVenti_Remarks' =>$bed->ICUwithVenti_Remarks,
            'ICUwithdialysisBed_Total_Beds' =>$bed->ICUwithdialysisBed_Total_Beds,
            'ICUwithdialysisBed_Occupied' =>$bed->ICUwithdialysisBed_Occupied,
            'ICUwithdialysisBed_Vacant' =>$bed->ICUwithdialysisBed_Vacant,
            'ICUwithdialysisBed_Remarks' =>$bed->hpICUwithdialysisBed_Remarks_id,
            'C19Ward_Total_Beds' =>$bed->C19Ward_Total_Beds,
            'C19Ward_Occupied' =>$bed->C19Ward_Occupied,
            'C19Ward_Vacant' =>$bed->C19Ward_Vacant,
            'C19Ward_Remarks' =>$bed->C19Ward_Remarks,
            'C19Positive_Total_Beds' =>$bed->C19Positive_Total_Beds,
            'C19Positive_Occupied' =>$bed->C19Positive_Occupied,
            'C19Positive_Vacant' =>$bed->C19Positive_Vacant,
            'C19Positive_Remarks' =>$bed->C19Positive_Remarks,

            'central_oxygen_Total_Beds' =>$bed->central_oxygen_Total_Beds,
            'central_oxygen_Occupied' =>$bed->	central_oxygen_Occupied,
            'central_oxygen_Vacant' =>$bed->central_oxygen_Vacant,
            'central_oxygen_Remarks' =>$bed->central_oxygen_Remarks,


            'SspectC19_Total_Beds' =>$bed->SspectC19_Total_Beds,
            'SspectC19_Occupied' =>$bed->SspectC19_Occupied,
            'SspectC19_Vacant' =>$bed->SspectC19_Vacant,
            'SspectC19_Remarks' =>$bed->SspectC19_Remarks,
            'SspectSymptWoComorbid_Total_Beds' =>$bed->SspectSymptWoComorbid_Total_Beds,
            'SspectSymptWoComorbid_Occupied' =>$bed->SspectSymptWoComorbid_Occupied,
            'SspectSymptWoComorbid_Vacant' =>$bed->SspectSymptWoComorbid_Vacant,
            'SspectSymptWoComorbid_Remarks' =>$bed->SspectSymptWoComorbid_Remarks,
            'SspectASymptWoComorbid_Total_Beds' =>$bed->SspectASymptWoComorbid_Total_Beds,
            'SspectASymptWoComorbid_Occupied' =>$bed->SspectASymptWoComorbid_Occupied,
            'SspectASymptWoComorbid_Vacant' =>$bed->SspectASymptWoComorbid_Vacant,
            'SspectASymptWoComorbid_Remarks' =>$bed->SspectASymptWoComorbid_Remarks,
            'PositiveSymptWoComorbid_Total_Beds' =>$bed->PositiveSymptWoComorbid_Total_Beds,
            'PositiveSymptWoComorbid_Occupied' =>$bed->PositiveSymptWoComorbid_Occupied,
            'PositiveSymptWoComorbid_Vacant' =>$bed->PositiveSymptWoComorbid_Vacant,
            'PositiveSymptWoComorbid_Remarks' =>$bed->PositiveSymptWoComorbid_Remarks,
            'PositiveASymptWoComorbid_Total_Beds' =>$bed->PositiveASymptWoComorbid_Total_Beds,
            'PositiveASymptWoComorbid_Occupied' =>$bed->PositiveASymptWoComorbid_Occupied,
            'PositiveASymptWoComorbid_Vacant' =>$bed->PositiveASymptWoComorbid_Vacant,
            'PositiveASymptWoComorbid_Remarks' =>$bed->PositiveASymptWoComorbid_Remarks,
            'ASymptC19SspectwithComorbidStable_Total_Beds' =>$bed->ASymptC19SspectwithComorbidStable_Total_Beds,
            'ASymptC19SspectwithComorbidStable_Occupied' =>$bed->ASymptC19SspectwithComorbidStable_Occupied,
            'ASymptC19SspectwithComorbidStable_Vacant' =>$bed->ASymptC19SspectwithComorbidStable_Vacant,
            'ASymptC19SspectwithComorbidStable_Remarks' =>$bed->ASymptC19SspectwithComorbidStable_Remarks,
            'SymptC19SspectwithComorbidStable_Total_Beds' =>$bed->SymptC19SspectwithComorbidStable_Total_Beds,
            'SymptC19SspectwithComorbidStable_Occupied' =>$bed->SymptC19SspectwithComorbidStable_Occupied,
            'SymptC19SspectwithComorbidStable_Vacant' =>$bed->SymptC19SspectwithComorbidStable_Vacant,
            'SymptC19SspectwithComorbidStable_Remarks' =>$bed->SymptC19SspectwithComorbidStable_Remarks,
            'ASymptPositivewithComorbidStable_Total_Beds' =>$bed->ASymptPositivewithComorbidStable_Total_Beds,
            'ASymptPositivewithComorbidStable_Occupied' =>$bed->ASymptPositivewithComorbidStable_Occupied,
            'ASymptPositivewithComorbidStable_Vacant' =>$bed->ASymptPositivewithComorbidStable_Vacant,
            'ASymptPositivewithComorbidStable_Remarks' =>$bed->ASymptPositivewithComorbidStable_Remarks,
            'SymptPositivewithComorbidStable_Total_Beds' =>$bed->SymptPositivewithComorbidStable_Total_Beds,
            'SymptPositivewithComorbidStable_Occupied' =>$bed->hSymptPositivewithComorbidStable_Occupiedp_id,
            'SymptPositivewithComorbidStable_Vacant' =>$bed->SymptPositivewithComorbidStable_Vacant,
            'SymptPositivewithComorbidStable_Remarks' =>$bed->SymptPositivewithComorbidStable_Remarks,
            'ASymptC19SspectwithComorbidCritical_Total_Beds' =>$bed->ASymptC19SspectwithComorbidCritical_Total_Beds,
            'ASymptC19SspectwithComorbidCritical_Occupied' =>$bed->ASymptC19SspectwithComorbidCritical_Occupied,
            'ASymptC19SspectwithComorbidCritical_Vacant' =>$bed->ASymptC19SspectwithComorbidCritical_Vacant,
            'ASymptC19SspectwithComorbidCritical_Remarks' =>$bed->ASymptC19SspectwithComorbidCritical_Remarks,
            'SymptC19SspectwithComorbidCritical_Total_Beds' =>$bed->SymptC19SspectwithComorbidCritical_Total_Beds,
            'SymptC19SspectwithComorbidCritical_Occupied' =>$bed->SymptC19SspectwithComorbidCritical_Occupied,
            'SymptC19SspectwithComorbidCritical_Vacant' =>$bed->SymptC19SspectwithComorbidCritical_Vacant,
            'SymptC19SspectwithComorbidCritical_Remarks' =>$bed->SymptC19SspectwithComorbidCritical_Remarks,
            'ASymptC19PositivewithComorbidCritical_Total_Beds' =>$bed->ASymptC19PositivewithComorbidCritical_Total_Beds,
            'ASymptC19PositivewithComorbidCritical_Occupied' =>$bed->ASymptC19PositivewithComorbidCritical_Occupied,
            'ASymptC19PositivewithComorbidCritical_Vacant' =>$bed->ASymptC19PositivewithComorbidCritical_Vacant,
            'ASymptC19PositivewithComorbidCritical_Remarks' =>$bed->ASymptC19PositivewithComorbidCritical_Remarks,
            'SymptC19PositivewithComorbidCritical_Total_Beds' =>$bed->SymptC19PositivewithComorbidCritical_Total_Beds,
            'SymptC19PositivewithComorbidCritical_Occupied' =>$bed->SymptC19PositivewithComorbidCritical_Occupied,
            'SymptC19PositivewithComorbidCritical_Vacant' =>$bed->SymptC19PositivewithComorbidCritical_Vacant,
            'SymptC19PositivewithComorbidCritical_Remarks' =>$bed->SymptC19PositivewithComorbidCritical_Remarks,
            'MorturyBeds_Total_Beds' =>$bed->MorturyBeds_Total_Beds,
            'MorturyBeds_Occupied' =>$bed->MorturyBeds_Occupied,
            'MorturyBeds_Vacant' =>$bed->MorturyBeds_Vacant,
            'MorturyBeds_Remarks' =>$bed->MorturyBeds_Remarks,
            'Others_Total_Beds' =>$bed->Others_Total_Beds,
            'Others_Occupied' =>$bed->Others_Occupied,
            'Others_Vacant' =>$bed->Others_Vacant,
            'Others_Remarks' =>$bed->Others_Remarks,
            'NonC19ICUWoVenti_Total_Beds' =>$bed->NonC19ICUWoVenti_Total_Beds,
            'NonC19ICUWoVenti_Occupied' =>$bed->NonC19ICUWoVenti_Occupied,
            'NonC19ICUWoVenti_Vacant' =>$bed->NonC19ICUWoVenti_Vacant,
            'NonC19ICUWoVenti_Remarks' =>$bed->NonC19ICUWoVenti_Remarks,
            'NonC19ICUwithVenti_Total_Beds' =>$bed->NonC19ICUwithVenti_Total_Beds,
            'NonC19ICUwithVenti_Occupied' =>$bed->NonC19ICUwithVenti_Occupied,
            'NonC19ICUwithVenti_Vacant' =>$bed->NonC19ICUwithVenti_Vacant,
            'NonC19ICUwithVenti_Remarks' =>$bed->NonC19ICUwithVenti_Remarks,
            'NonC19ICUwithdialysisBed_Total_Beds' =>$bed->NonC19ICUwithdialysisBed_Total_Beds,
            'NonC19ICUwithdialysisBed_Occupied' =>$bed->NonC19ICUwithdialysisBed_Occupied,
            'NonC19ICUwithdialysisBed_Vacant' =>$bed->NonC19ICUwithdialysisBed_Vacant,
            'NonC19ICUwithdialysisBed_Remarks' =>$bed->NonC19ICUwithdialysisBed_Remarks,
            'NonC19Ward_Total_Beds' =>$bed->NonC19Ward_Total_Beds,
            'NonC19Ward_Occupied' =>$bed->NonC19Ward_Occupied,
            'NonC19Ward_Vacant' =>$bed->NonC19Ward_Vacant,
            'NonC19Ward_Remarks' =>$bed->NonC19Ward_Remarks,


 
                 ); 
             }
             $data['district_name']=$district_name;
             $data['district_total_beds']=$district_total_beds;
             $data['district_c19_total_bed']=$district_c19_total_bed;
             $data['district_C19_Occupied']=$district_C19_Occupied;
             $data['district_C19_Vacant']=$district_C19_Vacant;
             $data['district_non_c19_total_bed']=$district_non_c19_total_bed;
             $data['district_NonC19_Occupied']=$district_NonC19_Occupied;
             $data['district_NonC19_Vacant']=$district_NonC19_Vacant;
             //die();
         $data['district_bed'] = $district_bed;
     //hos_data
        $data['clg_group'] = $clg_group;
         $this->output->add_to_position('', 'hos_data', TRUE);
         $this->output->add_to_position($this->load->view('frontend/bed/nhm_bed_hospital_wise_dashboard_view', $data, TRUE), 'hos_bed_data', TRUE);
     }
    
    function bed_hospital_wise(){
        
        $hp_id = $this->input->post('hp_id');
       // var_dump($district_id);

            $args_bed = array('hp_id'=>$hp_id);
            $district_total_bed =$this->bed_model->get_total_bed_district($args_bed);
            
            
            foreach($district_total_bed as $bed){
                $total_beds =0;
                $c19_total_bed =0;
                $non_c19_total_bed =0;
                
                $total_beds =$total_beds + $bed->C19_Total_Beds + $bed->NonC19_Total_Beds;
                $c19_total_bed =$c19_total_bed + $bed->C19_Total_Beds;
                $non_c19_total_bed =$non_c19_total_bed + $bed->NonC19_Total_Beds;
                
                $district_bed[] = array('hp_name'=>$bed->hp_name,
                    'hp_id'=>$bed->hp_id,
                    'total_beds'=>$total_beds,
                    'c19_total_bed'=>$c19_total_bed,
                    'C19_Occupied'=>$bed->C19_Occupied,
                    'C19_Vacant'=>$bed->C19_Vacant,
                    'non_c19_total_bed'=>$non_c19_total_bed,
                    'NonC19_Occupied'=>$bed->NonC19_Occupied,
                    'NonC19_Vacant'=>$bed->NonC19_Vacant,

                ); 
            }

        $data['district_bed'] = $district_bed;
        $this->output->add_to_position($this->load->view('frontend/bed/bed_hospital_wise_dashboard_view', $data, TRUE), 'content', TRUE);
    }
    function nhm_dash_report(){
        $thirdparty = $this->clg->thirdparty;
        $district_id = $this->clg->clg_district_id;
       // var_dump($district_id);die();
        //Total Call data
        $args = array('thirdparty'=>$thirdparty,'type'=>'total_call','district_id'=>$district_id);
        $data['total_call_today'] = $this->bed_model->get_total_call_today($args);
        $data['total_call_week'] = $this->bed_model->get_total_call_week($args);
        $data['total_call_month'] = $this->bed_model->get_total_call_month($args);
        $data['total_call_launch']= $this->bed_model->get_total_call_launch($args);
        //Dispatch data
        $args_dis = array('thirdparty'=>$thirdparty,'type'=>'total_dispatch','district_id'=>$district_id);
        $data['total_call_dispatch_today'] = $this->bed_model->get_total_call_today($args_dis);
        $data['total_call_dispatch_week'] = $this->bed_model->get_total_call_week($args_dis);
        $data['total_call_dispatch_month'] = $this->bed_model->get_total_call_month($args_dis);
        $data['total_call_dispatch_launch']= $this->bed_model->get_total_call_launch($args_dis);
        //K/M data
        $args_km = array('thirdparty'=>$thirdparty,'district_id'=>$district_id);
      //  $data['total_travel_today'] = $this->bed_model->get_travel_today($args_km);
        $total_travel_today = $this->bed_model->get_travel_today($args_km);
        $total_travel_today_KM=0;
        foreach ($total_travel_today as $row1) {
            $sum1=$row1->max_odo - $row1->min_odo ;
            $total_travel_today_KM =  $total_travel_today_KM + $sum1 ;
        }
        $data['total_travel_today_KM'] = $total_travel_today_KM;

        //$data['total_travel_week'] = $this->bed_model->get_travel_week($args_km);
        $total_travel_week = $this->bed_model->get_travel_week($args_km);
        $total_travel_week_KM=0;
        foreach ($total_travel_week as $row2) {
            $sum2=$row2->max_odo - $row2->min_odo ;
            $total_travel_week_KM =  $total_travel_week_KM + $sum2 ;
        }
        $data['total_travel_week_KM'] = $total_travel_week_KM;

        //$data['total_travel_month'] = $this->bed_model->get_travel_month($args_km);
        $total_travel_month = $this->bed_model->get_travel_month($args_km);
        $total_travel_month_km=0;
        foreach ($total_travel_month as $row) {
            $sum=$row->max_odo - $row->min_odo ;
            $total_travel_month_km =  (int)$total_travel_month_km + (int)$sum ;
        }
        $data['total_travel_month_km'] = $total_travel_month_km;
        
        //$data['total_travel_launch']= $this->bed_model->get_travel_launch($args_km);
        $total_travel_launch = $this->bed_model->get_travel_launch($args_km);
        $total_travel_launch_KM=0;
        foreach ($total_travel_launch as $row4) {
            $sum4 = $row4->max_odo - $row4->min_odo ;
            $total_travel_launch_KM =  (int)$total_travel_launch_KM + (int)$sum4 ;
        }
        $data['total_travel_launch_KM'] = $total_travel_launch_KM;


        //C19 patient
        $args_c19 = array('thirdparty'=>$thirdparty,'type'=>'c19','district_id'=>$district_id);
        $data['total_c19_today'] = $this->bed_model->get_c19_today($args_c19);
        $data['total_c19_week'] = $this->bed_model->get_c19_week($args_c19);
        $data['total_c19_month'] = $this->bed_model->get_c19_month($args_c19);
        $data['total_c19_launch']= $this->bed_model->get_c19_launch($args_c19);

        

       /* //Ambulance
        $args_amb = array('thirdparty'=>$thirdparty);
        $data['total_amb_today'] = $this->bed_model->get_amb_today($args_amb); */
       

        $this->output->add_to_position($this->load->view('frontend/bed/nhm_report_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "nhm_blank";
    }
        function vehical_tracking(){
            $thirdparty = $this->clg->thirdparty;
            $amb_type = $this->input->post('amb_type');
            $amb_reg = $this->input->post('amb_reg');

            $district = $this->clg->clg_district_id;
            $clg_district_id = json_decode($district);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
           // $district_id = ""
            if($amb_reg != ''){
                $amb_arg['amb_rto_register']=$amb_reg;
            }
            $amb_arg = array('thirdparty' => $thirdparty,'district_id'=>$district_id);
            $data['amb_data'] = $this->amb_model->get_tracking_amb_data($amb_arg);
            
            //$amb_arg = array('thirdparty' => $thirdparty,'district_id'=>$district_id,'status'=>1,'get_count'=>TRUE);
             $amb_arg_login = array('thirdparty' => $thirdparty,'status'=>1,'get_count'=>TRUE);
              $amb_arg_login = array('thirdparty' => $thirdparty,'status'=>1,'get_count'=>TRUE);
              if($amb_type != ''){
                $amb_arg_login['amb_type']=$amb_type;
            }
            if($amb_reg != ''){
                $amb_arg_login['amb_rto_register']=$amb_reg;
            }
            $data['login_count'] = $this->amb_model->get_amb_login_status_dist_wise($amb_arg_login);
            
            
             // $amb_arg = array('thirdparty' => $thirdparty,'district_id'=>$district_id,'status'=>2,'get_count'=>TRUE);
             $amb_arg = array('thirdparty' => $thirdparty,'get_count'=>TRUE);
            if($amb_type != ''){
                $amb_arg['amb_type']=$amb_type;
            }
            if($amb_reg != ''){
                $amb_arg['amb_rto_register']=$amb_reg;
            }
            $data['logout_count'] = $this->amb_model->get_amb_login_status_dist_wise($amb_arg);
            
            $thirdparty=$this->clg->thirdparty;
  

            $data['amb_list'] = $this->common_model->get_ambulance(array('thirdparty'=> $thirdparty));
          
            //var_dump($data['amb_data'] );die();
            $header = array('Ambulance No','Ambulance Type','Ambulance Status','Login Details','Incident ID','Time'); 
           // $amb->amb_rto_register_no
            $data['header'] = $header;
           
            $this->output->add_to_position($this->load->view('frontend/bed/nhm_remote_vehical_status', $data, TRUE), $output_position , TRUE);
            $this->output->template = "nhm_blank";
    }
    function vehical_tracking_search(){
        $thirdparty = $this->clg->thirdparty;
        
        
            $amb_type = $this->input->post('amb_type');
            $amb_reg = $this->input->post('amb_reg');
            $amb_status = $this->input->post('amb_status');
       

            $district = $this->clg->clg_district_id;
            $clg_district_id = json_decode($district);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
            $amb_arg = array('thirdparty' => $thirdparty,'district_id'=>$district_id);
            if($amb_type != ''){
                $amb_arg['amb_type']=$amb_type;
            }
            if($amb_reg != ''){
                $amb_arg['amb_rto_register']=$amb_reg;
            }
            if($amb_status != ''){
                $amb_arg['amb_status']=$amb_status;
            }
            
            $data['amb_data'] = $this->amb_model->get_tracking_amb_data($amb_arg);
            //$amb_arg = array('thirdparty' => $thirdparty,'district_id'=>$district_id,'status'=>1,'get_count'=>TRUE);
             $amb_arg = array('thirdparty' => $thirdparty,'status'=>1,'get_count'=>TRUE);
              if($amb_type != ''){
                $amb_arg['amb_type']=$amb_type;
            }
            if($amb_reg != ''){
                $amb_arg['amb_rto_register']=$amb_reg;
            }
            $data['login_count'] = $this->amb_model->get_amb_login_status_dist_wise($amb_arg);
             // $amb_arg = array('thirdparty' => $thirdparty,'district_id'=>$district_id,'status'=>2,'get_count'=>TRUE);
             $amb_arg_lg = array('thirdparty' => $thirdparty,'get_count'=>TRUE);
              if($amb_type != ''){
                $amb_arg['amb_type']=$amb_type;
            }
            if($amb_reg != ''){
                $amb_arg['amb_rto_register']=$amb_reg;
            }
            $data['logout_count'] = $this->amb_model->get_amb_login_status_dist_wise($amb_arg_lg);
           
          
            
            

            $data['amb_list'] = $this->common_model->get_ambulance(array('thirdparty'=> $thirdparty));
            if($amb_type != ''){
                $data['amb_type']=$this->input->post('amb_type');
            }
            if($amb_reg != ''){
                $data['amb_rto_register']=$amb_reg;
            }
            if($amb_status != ''){
                $data['amb_status']=$amb_status;
            }
            //var_dump($data['logout_count'] );die();
            $header = array('Ambulance No','Ambulance Type','Ambulance Status','Login Details','Incident ID','Time'); 
           // $amb->amb_rto_register_no
            $data['header'] = $header;
           
            $this->output->add_to_position($this->load->view('frontend/bed/nhm_remote_vehical_status', $data, TRUE), 'remote_vehical_status' , TRUE);
          
    }
   function amb_user_view(){
            $amb_id =  $this->input->post('amb_rto_register_no');
           
             
          
            $data['usr_login_data'] = $this->amb_model->get_app_login_user_reg($amb_id);
           
           
            $this->output->add_to_position($this->load->view('frontend/bed/app_login_user_view', $data, TRUE), $position, TRUE);
        }
    function record_view()
    {
        //var_dump($this->input->post('inc_ref_id'));die;
        $data['Incident_Details'] = "Incident Details";
        $args = array();
        $args = array('inc_ref_id' => $this->input->post('inc_ref_id'));
        $data['inc_details'] = $this->bed_model->get_inc_ref_id_data($args);
        $this->output->add_to_position($this->load->view('frontend/bed/driver_parameter_view', $data, TRUE), $position, TRUE);
        //var_dump($data['inc_details']);
    }
}