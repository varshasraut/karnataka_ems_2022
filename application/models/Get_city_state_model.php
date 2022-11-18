<?php
class Get_city_state_model extends CI_Model {
	
    public $tbl_mas_store_groups, $tbl_colleagues, $tbl_country, $tbl_state, $tbl_city;
            
    function __construct() {
        parent::__construct();
        
        $this->load->helper('date');
        $this->load->database();
        
        $this->tbl_mas_store_groups = $this->db->dbprefix('mas_store_groups');
        $this->tbl_colleague = $this->db->dbprefix('colleague');
        $this->tbl_country = $this->db->dbprefix('country');
        $this->tbl_state = $this->db->dbprefix('state');
        $this->tbl_city = $this->db->dbprefix('city');
     //   $this->tbl_city_details = $this->db->dbprefix('city_details');
    }
    
    function get_states($country_code=''){

//        $query = $this->db->query("SELECT state.state_id, state.state_name, state.state_code, state.state_country, "
//                . "country.country_name "
//                . "FROM $this->tbl_state as state "
//                . "join $this->tbl_country as country ON(state.state_country=country.country_code) "
//                . "WHERE state.state_country='".$country_code."'");

        $result = $this->db->query("SELECT * FROM $this->tbl_state") ;
        $result=$result->result();
        return $result;
    }
     
    function get_cities($state_code){

        if(!is_numeric($state_code)){

           $this->db->select('*');
           $this->db->from("$this->tbl_city as city");
           $this->db->where("city.city_state ='".$state_code."'");
           $data = $this->db->get();
           $result = $data->result();

            return $result;

        }  else {

               $result1 = $this->db->query("SELECT city.city_id, city.city_name, city.city_tehsil, city.city_district,city.city_zip "
                       . "city.city_state, state.state_name "
                       . "FROM $this->tbl_city as city "
                       . "join $this->tbl_state as state ON(city.city_state = state.state_code) "
                       . "WHERE state.state_id='".$state_code."' and city.city_is_deleted=0");

               $result = $result1->result();
               return $result;
        }
    }
    
    function get_city_count($args=array()) {
        
        $condition="";    
       
        if($args['district'])
        {
        
           $condition.=" and ci.city_district='".$args['district']."'";
            
        }
        
       if($args['tehsil'])
        {
        
            $condition.=" and ci.city_tehsil='".$args['tehsil']."'";
            
        }
        
       if($args['search'])
        {
             
            $condition.="and ci.city_name like '%".$args['search']."%'";
            
        }
      
         $result = $this->db->query("SELECT * FROM $this->tbl_city as ci where ci.city_is_deleted=0 $condition");        
         $count=$result->num_rows();
         return $count;   
         
    }
    
    
    function get_city_list($args,$offset,$limit){
    
        $offset_limit=$condition="";    
       
      
        
        if($args['district'])
        {
        
           $condition.=" and ci.city_district='".$args['district']."'";
            
        }
        
       if($args['tehsil'])
        {
        
            $condition.=" and ci.city_tehsil='".$args['tehsil']."'";
            
        }
        
        
        if($args['city'])
        {
             
            $condition.="and ci.city_name='".$args['city']."'";
            
        }
        
       if($args['search'])
        {
             
            $condition.="and ci.city_name like '%".$args['search']."%'";
            
        }
        if($limit>0 && $offset>=0){
            $offset_limit="limit $limit offset $offset";
        }
      
         $result = $this->db->query("SELECT * FROM $this->tbl_city as ci where ci.city_is_deleted=0 $condition $offset_limit");        
        
        
        return $result->result();
    }
    


    function get_district($state_code){ 
        
        $result1 = $this->db->query("SELECT Distinct city.city_district FROM $this->tbl_city as city inner join $this->tbl_state as state ON(city.city_state = state.state_code) WHERE state.state_code='".$state_code."' ORDER BY city.city_district ASC");
        
        $result = $result1->result();
        
        return $result; 
    }
    
    
    function get_tehsil($district_name=''){
         
        if($district_name)
        {
        
            $result1 = $this->db->query("SELECT Distinct city.city_tehsil FROM $this->tbl_city as city  WHERE city.city_district='".$district_name."'");
            
            $result = $result1->result();   
            
        }
        
        else
        {
            $result1 = $this->db->query("SELECT Distinct city_tehsil FROM $this->tbl_city limit 10 offset 0");
            $result = $result1->result();   
        }
        
        return $result;           
    }
    
    function get_city_name($tehsil_name){  
        
        $result1 = $this->db->query("SELECT city.city_id, city.city_name FROM $this->tbl_city as city WHERE city.city_tehsil='".$tehsil_name."' AND city.city_id NOT IN (SELECT ci.city_id from $this->tbl_city_details as ci )");
        
        $result = $result1->result();
        
        return $result;
        
    }
    
    function get_city($args=array()){  
        
    
        $query =  "SELECT DISTINCT city.city_id, city.city_name, city.city_tehsil, city.city_district"
                . " ,state.state_name FROM $this->tbl_city as city LEFT JOIN $this->tbl_state as state"
                . " ON(city.city_state = state.state_code) where city.city_is_deleted=0 ";
        
        if(@$args['keyword']){ 
            $query.= "AND city.city_id LIKE '%".$args['keyword']."%' "
                       . "OR city.city_name LIKE '%".$args['keyword']."%' "  ;                    
                      
        }
        
        $result=$this->db->query($query);       
        
        return $result->result();        
       
    }
    
	
	function get_city_on_district($args=array()){  
        
    
        $query =  "SELECT DISTINCT city.city_id, city.city_name, city.city_tehsil, city.city_district"
                . "  FROM $this->tbl_city as city  where city.city_id!='' ";
        
     	if($args['district_name']){ 
            
            $query.= "AND city.city_district ='".$args['district_name']."'" ;                    
                      
        }
        if($args['blocked_cities']){
            
            $query.=" AND city.city_id not in(".$args['blocked_cities'].")";
            
        }
        
        
        
		$query.= "ORDER BY city.city_name ASC";
        $result=$this->db->query($query);  

		
        return $result->result();        
       
    }
    
    function get_city_on_tehsil($tehsil,$block_cities=''){  
        
    
        $query =  "SELECT *"
                . "  FROM $this->tbl_city as city  where city.city_id!='' ";
        
     	if($tehsil){ 
            
            $query.= "AND city.city_tehsil ='".$tehsil."'" ;                    
                      
        }
        if($block_cities!=''){
            
            $query.=" AND city.city_id not in(".$block_cities.")";
            
        }
		
        $result=$this->db->query($query);  		
        return $result->result();        
       
    }
	
    function get_city_info($city_id){
        
       
        
        $result=$this->db->query("SELECT ci.* FROM $this->tbl_city as ci where ci.city_id = $city_id");

        return $result->result();
        
    }
    
	function get_city_code($city_name){
		$query =  "SELECT city.city_code"
                . "  FROM $this->tbl_city as city  where city.city_id!='' ";
        $query.= "AND city.city_name ='".$city_name."'";                    
        $result=$this->db->query($query);  
		return $result->result(); 
	}
	
	function get_city_location($args=array()){
        
    
		$query =  "SELECT city.city_longitude,city.city_latitude,city.city_name"
                . "  FROM $this->tbl_city as city  where city.city_id!='' ";
        
     	
        if($args['city_name']!='')
        {
            $query.= " AND city.city_name ='".$args['city_name']."' ";
        }
        
        if($args['district_name']!='')
        {
            $query.= " AND city.city_district ='".$args['district_name']."' ";     
        }

         
        $result=$this->db->query($query);  

		return $result->result(); 
	}
}