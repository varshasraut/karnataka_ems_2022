<?php


class Stock_model extends CI_Model {

	     

    function __construct() {

        parent::__construct();

        

        $this->load->helper('date');

        $this->load->database();

        $this->tbl_stores = $this->db->dbprefix('stores');
        
        $this->tbl_end_user = $this->db->dbprefix('end_user');
        
        $this->tbl_stock_request = $this->db->dbprefix('stock_request');
		
		$this->tbl_med_search_history = $this->db->dbprefix('med_search_history');
        
        $this->tbl_dis_cpn=$this->db->dbprefix('discount_coupon');
        
        $this->tbl_discount = $this->db->dbprefix('discount');
		
    }
	
	
	function check_in_stock_user_insert($args=array()){
        
     
        if(!empty($args))
        {
            
            
            $end_user_name = $args["end_user_name"];
            $end_user_email = $args["end_user_email"];
            $end_user_mob = $args["end_user_mob"];
            $end_user_pwd = $args["end_user_pwd"]; 
            $mob_no_status=$args['mob_no_status'];
            
            
            
            
            $query1=$this->db->query("SELECT * FROM $this->tbl_end_user WHERE end_user_mob='$end_user_mob'");              
            
            if($query1->num_rows()==0){
                
                
            $query2 = $this->db->query("INSERT INTO $this->tbl_end_user (end_user_name,end_user_email,end_user_mob,end_user_pwd,mob_no_status) values ('$end_user_name','$end_user_email','$end_user_mob','$end_user_pwd','$mob_no_status')
                                
                            ");
            
                            
            }
            
            if($query2){
                return $this->db->insert_id();
            }
            else {
                return FALSE;
            }
            
        }
        
        
    }
    
    function update_end_user($end_user=array(),$end_user1=array()){
        
      
            ($end_user1['end_user_id'])? $this->db->where_in('end_user_id',$end_user1['end_user_id']):$this->db->where_in('end_user_id',$end_user['end_user_id']); 
            $update=array();
            
            if(@$end_user['end_user_name']){                
               $update['end_user_name'] = $end_user['end_user_name'];             
            }
            
             if(@$end_user['end_user_pwd']){                
               $update['end_user_pwd'] = $end_user['end_user_pwd'];             
            }
             
            if(@$end_user['end_user_email']){                
               $update['end_user_email'] = $end_user['end_user_email'];             
            }           
            
            if($end_user['email_status']){                
                $update['email_status']=$end_user['email_status'];                
            }  
            
        if($end_user['end_user_mob']){
           
            if(@$end_user['end_user_mob']){                
               $update['end_user_mob'] =$end_user['end_user_mob'];             
            }
           
             if($end_user['mob_no_status']){                
                $update['mob_no_status']=$end_user['mob_no_status'];               
            }            
           
            
        }else if($end_user['end_user_email']){    
            
            if(@$end_user['end_user_email']){                
               $update['end_user_email'] =$end_user['end_user_email'];             
            }           
            
            if($end_user['email_status']){                
                $update['email_status']=$end_user['email_status'];                
            }            

        }         
            $result = $this->db->update($this->tbl_end_user,$update);  
                        
            if($result){
                return true;
            }else{
                return false;
            }
    }
    
       
        
    function check_end_user($end_user=array()){
  
            $this->db->select('*');

            if($end_user['mob_no']!=''){
                
                $this->db->where('end_user_mob', $end_user['mob_no']);
                
            }
            
            if($end_user['vrf_code']!='' && $end_user['end_user_id']){
                
                $this->db->where('sms_vrf_code', $end_user['vrf_code'],'end_user_id',$end_user['end_user_id']);
                
            }
                        
            $result = $this->db->get("$this->tbl_end_user");
         
            if($result->result()){
                return TRUE;
            }
            else {
                return FALSE;
            }
    }
        
    function insert_into_stock_req($args=array()){
        
        if(!empty($args))
        {
              
            
            $insert = $this->db->insert($this->tbl_stock_request,$args);
                
        //    echo $this->db->last_query();
                if($insert){
                    return $this->db->insert_id();
                }
                else{
                    return FALSE;
                }
                 
           
        }
    }
	
	
	
	function get_stock_request_list($args=array(),$offset='',$limit=''){
	

		$condition ='';
      
        ($args['stock_req_id']) ? $condition.=" and stock.stock_req_id=".$args['stock_req_id']." " : "";
            
		
		($args['usr_ref_id']) ? ($usr_ref_id=$args['usr_ref_id']) && ($condition.=" and stock.usr_ref_id='$usr_ref_id' ") : "";
            
		
		($args['mobile_number']!='') ?  ($mobile_number=trim($args['mobile_number'])) && ($condition.=" and stock.end_user_mob='$mobile_number' ")  :  "";
           
		if($args['search_from']!='' && $args['search_to']!='')
		{
			$search_from=$args['search_from'];
            
			$search_to=$args['search_to'];
			
            $condition.=" and stock.stock_req_date between '$search_from' and  '$search_to' ";
			
		}
        
		
        ($args['stock_req_store']) ? $condition.=" and user.usr_ms_name='".$args['stock_req_store']."' " : "";
            
        
		
        ($args['stock_req_city']) ? $condition.=" and  med_his.med_search_city like '%".$args['stock_req_city']."%' " : "";
            
        
        ($limit>0 && $offset>=0) ? $lim_off="limit $limit offset $offset" : $lim_off="";
        
     
       
        
        
        $query=$this->db->query("SELECT DISTINCT stock.*,euser.end_user_name,user.usr_ms_name,user.usr_ms_city FROM $this->tbl_stock_request as stock left join $this->tbl_end_user as euser on(euser.end_user_mob=stock.end_user_mob) left join $this->tbl_stores as user on(stock.usr_ref_id=user.usr_ref_id) left join $this->tbl_med_search_history as med_his on (stock.med_search_token=med_his.med_search_token) where stock.stock_req_delete_status=0 $condition order by stock.stock_req_status ASC $lim_off");
		
		$result = $query->result();
		
		if($result){
            
			if($args['return_count'])
			{ 
				return $query->num_rows(); 
			}
			else {
				return $result; 
			}
			
		}
		
	}
    
    
    function update_stkreq_cnt($req_id=array()){
        
        $update_status = array('is_read'=>'1');
        
        $this->db->where_in('stock_req_id',$req_id);
        
        $this->db->update($this->tbl_stock_request,$update_status);
        
    }
    
    
    function stock_req_data_autocomplete($args=array()){
        
        $condition="";
        
         if($args['mob_no_search']){
            
            $select="select distinct stock.end_user_mob ";
             
            $condition.=" and stock.end_user_mob like '%".$args['mob_no_search']."%'";
            
        }
        
         if($args['store_name']){
            
            $select="select distinct user.usr_ms_name ";
             
            $condition.=" and user.usr_ms_name like '%".$args['store_name']."%'";
            
        }
		
        if($args['city']){
            
            $select="select distinct user.usr_ms_city "; 
             
            $condition.=" and user.usr_ms_city like '%".$args['city']."%'";
            
        }
      
        if($args['usr_ref_id']){
            
            $condition.=" and stock.usr_ref_id='".$args['usr_ref_id']."' ";
            
        }
       
        
         $result=$this->db->query("$select FROM $this->tbl_stock_request as stock left join $this->tbl_end_user as euser on(euser.end_user_mob=stock.end_user_mob) left join $this->tbl_stores as user on(stock.usr_ref_id=user.usr_ref_id)  where stock.stock_req_delete_status=0 $condition ");
        
         return $result->result();
         
    }
	
	function delete_stock_request($args=array()){
	
        
        
		if($args['stock_req_id']!=''){
			
			
            
            $this->db->where_in('stock_req_id',$args['stock_req_id']);
            
			$update = array('stock_req_delete_status'=>1);
			
			$result = $this->db->update($this->tbl_stock_request,$update);
            
            
            
			return $result;
		}
        
       
        
        
	}
	
	function get_prescription_data($args=array(),$limit='',$offset=''){
	
     
		$select_data=$qr= $condition = "";    
        
        if($args['stock_req_id']!=''){
			
            $stock_req_id = $args['stock_req_id'];
            $condition.=" and stock.stock_req_id='$stock_req_id' ";
            
		}
        
        if($limit>0 && $offset>=0 && $args['end_user_prsc']!=''){
           $limit_offset="limit $limit offset $offset";
        }

        
        if($args['end_user_mob']!=''){
            $condition.=" and stock.end_user_mob=".$args['end_user_mob'];   
        }
        
        if($args['end_user_prsc']=='true' && $args['end_user_mob']!=''){
            $qr = "left join $this->tbl_discount as dis on(dis.dis_usr_ref_id=us.usr_ref_id and dis.dis_status='active')";
            $select_data=",dis.dis_id,dis.dis_title";
        }      
        
        
		$query=$this->db->query("SELECT us.usr_ref_id,us.usr_total_sms_cnt,us.usr_ms_board_photo,us.usr_ms_name,us.usr_ms_store_timings,us.usr_sent_sms_cnt,(us.usr_total_sms_cnt-us.usr_sent_sms_cnt) as avail_sms,stock.stock_req_id,stock.med_search_token,ms_hist.med_search_found_status,ms_hist.med_search_name,ms_hist.med_id,ms_hist.med_searched_medicals,stock.stock_req_med_id,euser.end_user_mob,euser.end_user_email,euser.end_user_name,stock.stock_req_replied_method,stock.stock_req_status,euser.mob_no_status,euser.email_status,stock.stock_req_date,stock.stock_req_reply_sms_cnt,stock.stock_req_reply_email_cnt$select_data FROM $this->tbl_stock_request as stock left join $this->tbl_stores as us on(us.usr_ref_id=stock.usr_ref_id) left join $this->tbl_med_search_history as ms_hist on(ms_hist.med_search_token=stock.med_search_token) left join $this->tbl_end_user as euser on(euser.end_user_mob=stock.end_user_mob) $qr where stock.stock_req_delete_status=0  $condition $limit_offset ");
		
        
    // echo $this->db->last_query();exit;  
   
        if($args['get_count']!=''){        
          return $query->num_rows();  
        }else{            
         return $query->result();
        }
	}
	
    function update_stock_request($args,$stock_req_id){
        
        if(!empty($args) && $stock_req_id!=''){
            
            $this->db->where('stock_req_id',$stock_req_id);
            
			$result = $this->db->update($this->tbl_stock_request,$args);
            
			return $result;
        }
    }
    
    
    
    function euser_get_stock_request_list($args=array(),$limit,$offset){
        
        $condition = '';
        
        if($args['end_user_mob']!=''){
            $end_user_mob = $args['end_user_mob'];
            $condition.=" and stock.end_user_mob='$end_user_mob' ";
        }
        
        if($args['mobile_number']!='')
        {
            $mobile_number=$args['mobile_number'];
            $condition.=" and stock.end_user_mob='$mobile_number' ";
        }
		if($args['search_from']!='' && $args['search_to']!='')
		{
			$search_from=$args['search_from'];
            
			$search_to=$args['search_to'];
			
            $condition.=" and stock.stock_req_date between '$search_from' and  '$search_to' ";
			
		}
		
		
        if($limit>0 && $offset>=0)
        {
            $limit_offset.="limit $limit offset $offset";
        }
        
        
        $query=$this->db->query("SELECT stock.stock_req_id,stock.stock_req_status,stock.stock_req_date,stock.stock_req_replied_method,user.usr_ms_name FROM $this->tbl_stock_request as stock left join $this->tbl_stores as user on(user.usr_ref_id=stock.usr_ref_id) where user.usr_ref_id=stock.usr_ref_id and stock.stock_req_delete_status=0 $condition ORDER BY stock_req_id  DESC $limit_offset ");
		
        
        
		$result = $query->result();
        
        if($result){
            
			if($args['return_count'])
			{ 
				return $query->num_rows(); 
			}
			else {
				return $result; 
			}
			
		}
        
    }
    
    function get_end_user($args=array()){
        
        $end_user_id = $args['end_user_id'];
       
        $query = "SELECT * FROM $this->tbl_end_user WHERE end_user_id = $end_user_id";  
        
        $result=$this->db->query($query);        
        return $result->result();
       
    }
    function check_end_user_email($end_user=array()){       
        
            $this->db->select('*');

            if($end_user['email']!=''){
                
                $this->db->where('end_user_email', $end_user['email']);
                
            }
            
            if($end_user['vrf_code']!='' && $end_user['end_user_id']){
                
                $this->db->where('sms_vrf_code', $end_user['vrf_code'],'end_user_id',$end_user['end_user_id']);
                
            }
                        
            $result = $this->db->get("$this->tbl_end_user");
           
            if($result->result()){
                return TRUE;
            }
            else {
                return FALSE;
            }
    }
    
    function get_discount_coupon($args=array(),$offset='',$limit=''){        
      
        $condition = '';

        $end_user_mob = $args['end_user_mob'];

        if($limit>0 && $offset>=0){
            $limit_offset="limit $limit offset $offset";
        }

        if(@$args['cpn_code']){
            $condition .= " AND cpn_code like '%".$args['cpn_code']."%'";
        }

        if(@$args['search_discount_title']){
          $condition .= " AND dis_title like '%".$args['search_discount_title']."%'";
        }

        $query = "SELECT stock_req.*,dis_cpn.*,dis.*,user.*"
                  . "FROM $this->tbl_stock_request as stock_req "
                  . "LEFT JOIN  $this->tbl_dis_cpn as dis_cpn ON (stock_req.stock_req_id = dis_cpn.stock_req_id)"
                  . "LEFT JOIN  $this->tbl_discount as dis ON (dis_cpn.dis_id = dis.dis_id) "
                  . "LEFT JOIN  $this->tbl_stores as user ON (stock_req.usr_ref_id = user.usr_ref_id) "
                  . "Where cpn_action=1 and stock_req.end_user_mob = $end_user_mob and stock_req.stock_req_id = dis_cpn.stock_req_id $condition ORDER BY dis_cpn.cpn_apply_date desc $limit_offset";

        
        $result=$this->db->query($query);
        
       // echo $this->db->last_query();die;

        if($args['get_count']){           
           return $result->num_rows();            
        }else{            
          return $result->result();
        }
    }
    
    
    function get_stock_data($args=array(),$limit,$offset){
        
	
  		$condition = "";
        
        if($limit>0 && $offset>=0 && $args['end_user_prsc']!=''){
           $limit_offset="limit $limit offset $offset";
        }
        
        if($args['end_user_mob']!=''){            
            $condition.="hist.end_usr_mob=".$args['end_user_mob'];       
        }    
 
      $query = "SELECT GROUP_CONCAT(hist.med_searched_medicals) as hist_searched_medical,GROUP_CONCAT(DISTINCT hist.med_searched_is_deleted) as med_searched_is_deleted,GROUP_CONCAT(hist.med_search_token) as med_search_token,GROUP_CONCAT(hist.med_search_id) as hist_med_search_id,GROUP_CONCAT(DISTINCT hist.med_search_name) as his_med_search_name,GROUP_CONCAT(hist.med_search_date) as hist_med_search_date FROM $this->tbl_med_search_history as hist WHERE $condition and hist.med_searched_is_deleted = 0 GROUP BY hist.med_search_token  ORDER BY hist_med_search_date DESC $limit_offset";
     
      
        $result=$this->db->query($query);
     
       if($args['get_count']){           
           return $result->num_rows(); 
        }else{            
          return $result->result();
        }
       
       
	}
    
    function delete_search_hist($med_search_id,$args=array()){
        
        if($med_search_id){
           $this->db->where_in('med_search_id',$med_search_id);
           $update = $this->db->update($this->tbl_med_search_history,$args);
           
           if($update)
           {
              return true;
           }else{
              return false;
           }
        }else{
          return false;
        } 
           
           
    }
	
    
}




