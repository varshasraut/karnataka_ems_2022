<?php
class Users_model extends CI_Model {
    public $tbl_mas_store_groups, $tbl_colleagues, $tbl_country, $tbl_state, $tbl_city;

    function __construct() {



        parent::__construct();
        $this->load->helper('date');
        $this->load->database();
        $this->tbl_mas_store_groups = $this->db->dbprefix('mas_store_groups');
        $this->tbl_colleague = $this->db->dbprefix('colleague');
        $this->tbl_country = $this->db->dbprefix('country');
        $this->tbl_state = $this->db->dbprefix('state');
        $this->tbl_subscription_facilities = $this->db->dbprefix('subscription_facilities');
        $this->tbl_subscription=$this->db->dbprefix('subscription');
        $this->tbl_city = $this->db->dbprefix('city');
        $this->tbl_sessions = $this->db->dbprefix('sessions');  
        $this->tbl_clg_sales_commission = $this->db->dbprefix('clg_sales_commission');
        $this->tbl_stores = $this->db->dbprefix('stores');      
        $this->tbl_stores_sms=$this->db->dbprefix('stores_sms');
        $this->tbl_stores_sub_history = $this->db->dbprefix('stores_subscription_history');
        $this->tbl_stores_sub = $this->db->dbprefix('stores_subscription');
        $this->tbl_end_user = $this->db->dbprefix('end_user');
        $this->tbl_stock_request = $this->db->dbprefix('stock_request');
        $this->tbl_bookmarks = $this->db->dbprefix('bookmarks');
        $this->store_discount = $this->db->dbprefix('store_discount');
        $this->store_dis_cpcd=$this->db->dbprefix('store_dis_cpcd');
        $this->tbl_store_edit_history=$this->db->dbprefix('store_edit_history');
        $this->options = $this->db->dbprefix('options');
        $this->tbl_city_his = $this->db->dbprefix('city_history');

    }



	function register_user($args=array()) {

        $user = array_filter($args);
        if (!empty($user)) {

            $this->db->insert($this->tbl_stores,$args);
            return 1;	

        }

	}

	

	function get_subscription_data() {

		

		$query = $this->db->get($this->tbl_subscription);

		

		if($query->num_rows() > 0)

		{

			foreach($query->result() as $row)

			{

				$data [] = $row;

			}

			return $data;

		}

		else{

			return 0;

		}

	}

    

    function get_sub_info($sub_id=''){

        

        $condition="";

        

        if($sub_id!=''){

            

            $condition.=" and sub_id=".$sub_id;

            

        }

  

        $query =$this->db->query("SELECT * FROM $this->tbl_subscription where sub_is_deleted=0 $condition");

		

        return $query->result();

        

    }

	

    

    function update_default_value($plan_id=''){

        if($plan_id)

        {

           $query =$this->db->query("update $this->tbl_subscription set sub_default=0 where sub_id!=$plan_id");

        }

        else{

            $query =$this->db->query("update $this->tbl_subscription set sub_default=0");

        }

    }

    

  

    

    function get_subscription_facilities($sub_fc_id=array()) {

        

        $condition="";

        

        if($sub_fc_id){

            

            $condition=" where sf_id in(".$sub_fc_id.")";

            

        }

      

        

        

        $result =$this->db->query("SELECT * FROM $this->tbl_subscription_facilities $condition");

        

        

        

        return $result->result();



    }

    

     function add_subscription_plan($plan_name,$duration,$default,$plan_status,$plan_price,$facilities) {



        $result = $this->db->query("INSERT INTO $this->tbl_subscription(`sub_id`,`sub_name`,`sub_price`,`sub_status`,`sub_default`,`sub_facility_id`) VALUES('"."','". $plan_name . "'," . $plan_price . ",'" . $plan_status . "'," . $default . ",'" . $facilities ."');");

        



        if ($result) {



            return TRUE;



        } else {



            return FALSE;



        }



    }

    

    

    function delete_subscription_plans($sub_id,$is_delete) {

        

        

      

        $this->db->where_in('sub_id',$sub_id);

        

        $data = $this->db->update("$this->tbl_subscription",$is_delete);



        return $data;



    }

    

    function get_facilities($sub_id) {



            

        $this->db->select('sub_facility_id');



        $this->db->where('sub_id', $sub_id);



        $result = $this->db->get("$this->tbl_subscription");



        return $result->result();



    }

    

    function get_edit_plan_list($plan_id) {



        $this->db->select('*');



        $this->db->where('sub_id', $plan_id);



        $result = $this->db->get("$this->tbl_subscription");



        return $result->result();



    }

    

    function edit_subscription_plan($subscription_plan, $plan_id) {



        $this->db->where_in('sub_id', $plan_id);



        $data = $this->db->update("$this->tbl_subscription", $subscription_plan);



        return $data;



    }

    

    

    function update_subscription_plan_status($sp_id='', $status) {



        

        if($sp_id!=''){

        

            $this->db->where_in('sub_id', $sp_id);

            

        }

        



        $data = $this->db->update("$this->tbl_subscription ", $status);



        return $data;



    }



	function subscription_user($user = array()) {

		

		if(!empty($user)){

            $this->db->insert($this->tbl_stores_sub,$user);

            $insert_id = $this->db->insert_id();

            return $insert_id;	

        }

			

        

	}

 

    function update_subscription($user_sub_id,$data){

		

        

        

		if($user_sub_id!=''){

            $this->db->where('usr_sub_id', $user_sub_id);

			

			$data = $this->db->update("$this->tbl_stores_sub", $data);



			return $data;

        }

         

	}

   

	function get_sub_months($sub_id) {

		

		$query = $this->db->select('sub_duration')

                ->where('sub_id', $sub_id)

                ->get($this->tbl_subscription);

		

		if($query->num_rows() > 0)

		{

			foreach($query->result() as $row)

			{

				$data = $row;

			}

			return $data;

		}

	}

	

   

    

    

    

	function get_sub_price($sub_id) {

		

		$query = $this->db->select('sub_price')

                ->where('sub_id', $sub_id)

                ->get($this->tbl_subscription);

		

		

		if($query->num_rows() > 0)

		{

			return $query->result();

		}

	}

	

    function get_sub_name($sub_id='')

    {

        $query =$this->db->query("SELECT * FROM $this->tbl_subscription where sub_id=$sub_id");

        return $query->result();

    }

        

	function get_last_user_id()

	{

		$query = $this->db->select('usr_id')->order_by('usr_id',"desc")->limit(1)->get($this->tbl_stores);

		if($query->num_rows() > 0)

		{

			foreach($query->result() as $row)

			{

				$data = $row;

			}

			return $data;

		}

	}

	function get_subscription_by_user($args=array()){

		

		if($args['usr_ref_id']!=''){

			$usr_ref_id = $args['usr_ref_id'];

			

			$condition.=" usr_ref_id='".$args['usr_ref_id']."'";

		}

        if($args['active_sub']!=''){

            

            $condition.=" and usr_sub.usr_sub_status='active'";

            

        }

        if($args['inact_expr_sub']!=''){



             $query =$this->db->query("SELECT usr_sub_status FROM ms_users_subscription where $condition and usr_sub_start_date=(select MAX(usr_sub_start_date) from ms_users_subscription where $condition) order by usr_sub_id desc");

            

        }

        else{

            

            	$query =$this->db->query("SELECT $select usr_sub.usr_sub_id,usr_sub.usr_sub_start_date,usr_sub.usr_sub_end_date,usr_sub.usr_sub_transaction_id,usr_sub.usr_sub_transaction_date,usr_sub.usr_sub_pay_status,usr_sub.usr_sub_status,usr_sub.usr_sub_price,usr_sub.usr_sub_serv_tax,usr_sub.usr_sub_serv_tax_amt,usr_sub.usr_sub_months,sub.sub_name,sub.sub_id  FROM $this->tbl_stores_sub as usr_sub left join $this->tbl_subscription as sub on(usr_sub.sub_id=sub.sub_id) where $condition order by usr_sub.usr_sub_id desc");

            

        }

	

        

		return $query->result();

		

	}

	

	

	function check_login($args = array())

	{

        

		$condition ="";

		($args['username'] && $args['password']) ? $condition .=" AND usr.usr_ms_owner_email='".$args['username']."' AND usr.usr_password='".$args['password']."'" : "";

		

		($args['email']) ? $condition .=" AND usr.usr_ms_owner_email='".$args['email']."'" : "";

		

        ($args['ms_phone_no']) ? $condition .=" AND usr.usr_ms_phone_no='".$args['ms_phone_no']."'" : "";

        

        ($args['usr_ms_owner_phone']) ? $condition .=" AND usr.usr_ms_owner_phone='".$args['usr_ms_owner_phone']."'" : "";

		

		($args['usr_remember_me']) ? $condition .=" AND usr.usr_cookie='".$args['usr_remember_me']."'" : "";

		

		($args['user_email']) ? $condition .=" AND usr.usr_ms_owner_email='".$args['user_email']."'" : "";

		

		($args['usr_ref_id']) ? $condition .=" AND usr.usr_ref_id='".$args['usr_ref_id']."'" : "";

        

        ($args['usr_pharm_reg_no']) ? $condition .=" AND usr.usr_pharm_reg_no='".$args['usr_pharm_reg_no']."'" : "";

        

		

//        $res=$this->db->query("select us.usr_sub_status from  $this->tbl_stores as usr left join $this->tbl_stores_sub as us on(us.usr_sub_start_date=(select MAX(us.usr_sub_start_date)) AND us.usr_sub_status='active' AND us.usr_ref_id=usr.usr_ref_id) left join $this->tbl_subscription as sub on(sub.sub_id=us.sub_id AND sub.sub_is_deleted=0) where usr.usr_delete_status=0 $condition");

//        

//        

//       

//        

//        $res=$res->result();

//        

//        $active_status=$res[0]->usr_sub_status;

//        

//        if($res[0]->usr_sub_status=='active'){

//            

//            $condition.=" AND us.usr_sub_status='active' ";

//            

//        }



        

        

        $result=$this->db->query("select GROUP_CONCAT(stock_req.stock_req_id) as active_stock_req,usr.usr_show_contact_to_customer,usr.usr_store_publish_status,usr.usr_ref_id,usr.usr_ms_name,usr.usr_ms_phone_no,usr.usr_ms_addr_line1,usr.usr_ms_stock_req_src,usr.usr_ms_city,usr.usr_ms_board_photo,usr.usr_ms_owner_name,usr.usr_ms_owner_phone,usr.usr_ms_owner_email,usr.usr_ms_owner_photo,usr.usr_shop_act_no,usr.usr_pharm_qualification,usr.usr_pharm_reg_no,usr.usr_pharm_date,usr.usr_pharm_reg_validation,usr.usr_reg_local_address,usr.usr_lattitude,usr.usr_longitude,usr.usr_last_login,usr.usr_reg_date,usr.usr_edit_date,usr.usr_ms_status,usr.usr_ms_store_timings,(usr.usr_total_sms_cnt-usr.usr_sent_sms_cnt) as avail_sms,usr.usr_total_sms_cnt,usr.usr_sent_sms_cnt,usr.usr_total_med_upload,us.sub_id,us.usr_sub_status,us.usr_sub_start_date,us.usr_sub_end_date,us.usr_sub_id,sub.sub_name,sub.sub_facility_id,sub.sub_token from  $this->tbl_stores as usr left join $this->tbl_stores_sub as us on(us.usr_sub_status='active' AND  us.usr_ref_id=usr.usr_ref_id) left join $this->tbl_subscription as sub on(sub.sub_id=us.sub_id AND sub.sub_is_deleted=0) left join $this->tbl_stock_request as stock_req on(stock_req.usr_ref_id=usr.usr_ref_id and stock_req.stock_req_status='active')  where usr.usr_delete_status=0 $condition order by us.usr_sub_start_date desc limit 1");

        

            

		if($result){

			

			$status = $result->result();

			

			if($args['username'] && $args['password'] && $status[0]->usr_ms_status==1){

				

				$login_time = date("j\<\s\u\p\>S\<\/\s\u\p\> M Y H:i A");

				

				

				$data = array(

								'usr_last_login'=>$login_time

							);

                

				$cur_usr_ref_id = $result->result();

				

				$this->db->where('usr_ref_id',$cur_usr_ref_id[0]->usr_ref_id);

				$update = $this->db->update($this->tbl_stores,$data);

			}	

            

		

			return $result->result();

			

		}else{

		    return false;

		}

    }

	

	function set_user_cookie($cookie_value,$usr_ref_id){

		

		$data = array(

							'usr_cookie'=>$cookie_value

						);

		

		$this->db->where('usr_ref_id',$usr_ref_id);

		$this->db->update($this->tbl_stores,$data);

	}

	function reset_user_password($password,$usr_ref_id){

		

		$data = array(

							'usr_password'=>$password

						);

		

		$this->db->where('usr_ref_id',$usr_ref_id);

		$update = $this->db->update($this->tbl_stores,$data);

		if($update){

			return TRUE;

		}

		else{

			return FALSE;

		}

	}

	

    function store_edit_history($current_user_ref_id=''){

        

        $this->db->select('*');

        

        $this->db->where('usr_ref_id', $current_user_ref_id);

		

		$result = $this->db->get("$this->tbl_store_edit_history");

        

        return $result->result();

        

    }

    

    function insert_store_history($edit_usr=array()){

        

        $result = $this->db->insert($this->tbl_store_edit_history, $edit_usr);  

   

        if($result){               

          return $result;

        }else{

          return false;

        } 

  

    }

    

     function update_store_history($current_user_ref_id='',$user=array()){

        

        $this->db->where('usr_ref_id',$current_user_ref_id);

            

        $update = $this->db->update($this->tbl_store_edit_history,$user);

     

		if($update){

			return TRUE;

		}

		else{

			return FALSE;

		}

    }

    

    

	function update_pharmacist($user=array(),$current_user_ref_id=''){

 

            $this->db->where('usr_ref_id',$current_user_ref_id);

            

            $update = $this->db->update($this->tbl_stores,$user);

     

		if($update){

			return TRUE;

		}

		else{

			return FALSE;

		}

        

	}

	

	function update_medistore_details($medistore_details,$current_user_ref_id){

	

		$this->db->where('usr_ref_id',$current_user_ref_id);

		$update = $this->db->update($this->tbl_stores,$medistore_details);

		

		if($update){

			return TRUE;

		}

		else{

			return FALSE;

		}

	}

	

    public function get_store_count($data=array())

    {

        $condition="";

        

        if($data['usr_ms_verify_status']=="unapprove")

        {

             

            $condition.=" and usr.usr_ms_verify_status=0 ";

             

        }

        else 

        {

            

             $condition.=" and  usr.usr_ms_verify_status=1 ";

             

        }

        

        if($data['recent_stores']=="yes")

        {

            $condition.=" and DATEDIFF(NOW(),usr_reg_date) between 0 and 10 ";

        }

        

        if($data['district']!='')

        {

            

            $condition.=" and  usr.usr_ms_district='".$data['district']."' ";

            

        }

       

        if($data['city']!='')

        {

            

            $condition.=" and usr.usr_ms_city='".$data['city']."' ";

            

        }

        

        if($data['search']!='')

        {

            $condition.=" and ( usr.usr_ms_owner_name like'%".$data['search']."%' or usr.usr_ms_name like'%".$data['search']."%') ";

        }

        

        if($data['subscription']!='')

        {

            

            if($data['subscription']=="completed" || $data['subscription']=="pending" || $data['subscription']=="on hold" || $data['subscription']=="rejected")

            {

                

                 $condition.="and us.usr_sub_pay_status='".$data['subscription']."'";

                 

            }

            

            

            else if($data['subscription']=="active_sub")

            {

                

                $condition.="and  DATEDIFF(us.usr_sub_end_date,NOW())  between 1 and 7 ";

        

            }

            

            else if($data['subscription']=="expired_sub")

            {

                 

                $condition.="and  DATEDIFF(us.usr_sub_end_date,NOW()) < 1";



            }

           

          

            else if($data['subscription']=="inactive")

            {

                 

                $condition.=" and  usr.usr_ms_status='0'";



            }

            else if($data['subscription']=="active")

            {

                 

                $condition.=" and  usr.usr_ms_status='1'";



            }

              else if($data['subscription']=="block")

            {

                 

                $condition.=" and  usr.usr_ms_status='2'";



            }

            

        

      

            

            else

            {

                

                $query=$this->db->query("select sub_id from $this->tbl_subscription where sub_name='".$data['subscription']."'");

                $data=$query->result();

                $sub_id=$data[0]->sub_id;

                $condition.=" and us.sub_id=".$sub_id;

                

            }

            

        }

        

        

    

        

$result=$this->db->query("SELECT DISTINCT usr.usr_ref_id FROM $this->tbl_stores as usr left join $this->tbl_stores_sub as us on(usr.usr_ref_id=us.usr_ref_id and us.usr_sub_status='active') left join $this->tbl_subscription as sub on(us.sub_id=sub.sub_id) where usr.usr_is_deleted=0  $condition");

        

        

        return $result->num_rows();

        

    }

    

 

	public function get_store_list($data=array(),$offset='',$limit='')

    {

         

        

        $condition="";

        

        ($limit>0 && $offset>=0)? $lim_off=" limit $limit offset $offset":$lim_off="";

        

       

        

        ($data['usr_ms_status']=='unaprv')? $condition.=" and  usr.usr_ms_status='0'":"";

        

        ($data['usr_ms_status']=='aprv')? $condition.=" and  usr.usr_ms_status='1'":"";

        

        ($data['usr_ms_status']=='block')? $condition.=" and  usr.usr_ms_status='2'":"";

       

        ($data['recent_stores']=="yes")? $condition.=" and DATEDIFF(NOW(),usr_reg_date) between 0 and 10 ":"";

        

        ($data['city']!='')? $condition.=" and usr.usr_ms_city='".$data['city']."'":"";

        

        ($data['search']!='')? $condition.=" and ( usr.usr_ms_owner_name like'%".$data['search']."%' or usr.usr_ms_name  like'%".$data['search']."%')":"";

            

        if($data['subscription']!='')

        {

            

            

            

            if($data['subscription']=="success" || $data['subscription']=="failure" || $data['subscription']=="pending" || $data['subscription']=="cancelled")

            {

                

                 $condition.=" and us.usr_sub_pay_status='".$data['subscription']."' ";

                 

            }

            

            else if($data['subscription']=="active_sub"){

                 

                $condition.=" and  DATEDIFF(us.usr_sub_end_date,NOW()) between 1 and 7 ";



            }

            

            else if($data['subscription']=="expired_sub"){

                 

                $condition.="and  DATEDIFF(us.usr_sub_end_date,NOW()) < 1 ";



            }

          

           

            else {

                $query=$this->db->query("select sub_id from $this->tbl_subscription where sub_name='".$data['subscription']."'");

                $sub_data=$query->result();

                $sub_id=$sub_data[0]->sub_id;

                $condition.=" and us.sub_id=".$sub_id." and us.usr_sub_status='active'";

            }

            

        }

        



        

        $result=$this->db->query("SELECT DISTINCT usr.usr_ms_owner_email,usr.usr_ms_status,usr.usr_ref_id,usr.usr_reg_date,usr.usr_ms_phone_no,usr.usr_ms_verify_status,usr.usr_is_blocked,usr.usr_ms_city,usr.usr_ms_name,usr.usr_ms_owner_name,sub.sub_name,us.usr_sub_start_date,us.usr_sub_end_date,us.usr_sub_pay_status FROM $this->tbl_stores as usr left join $this->tbl_stores_sub as us on(usr.usr_ref_id=us.usr_ref_id and us.usr_sub_status='active') left join $this->tbl_subscription as sub on(us.sub_id=sub.sub_id) where  usr.usr_is_deleted=0 $condition  order by usr_ref_id ASC $lim_off");

        

        

        if($data['get_count']){            

            return $result->num_rows();            

        }else{            

            return $result->result();            

        }

          

         

    }

    

    public function delete_usr_store($usr_ref_id,$delete_status)

    {

        

        $this->db->where_in('usr_ref_id',$usr_ref_id);



        $data = $this->db->update("$this->tbl_stores",$delete_status);

        

        return $data;

    }

    

    public function usr_sub_details($user=array())

    {

      

        $condition="";

        

        if($user['usr_ref_id']!=''){

            

            $condition.=" and usr.usr_ref_id='".$user['usr_ref_id']."' ";

            

        }

        

        

        if($user['sub_status']!=''){

             

            

            

            if(is_array($user['sub_status'])){

                

                $sub_status=implode("','",$user['sub_status']);  

                

                $sub_status="'".$sub_status."'";

                

                $condition.=" and  us.usr_sub_status in(".$sub_status.")";

                

                

            }else{ 

                

                $condition.=" and  us.usr_sub_status='".$user['sub_status']."' ";

                

            }

            

           

            

        }

        

         if($user['usr_ms_status']!=''){

             

            $condition.=" and usr.usr_ms_status='".$user['usr_ms_status']."' ";

            

         }

         if($user['usr_sub_pay_status']!=''){

             

             if(is_array($user['usr_sub_pay_status'])){

                 

               

                 $pay_status=implode("','",$user['usr_sub_pay_status']); 

                 

                 $pay_status="'".$pay_status."'";

                 

                 $condition.=" and us.usr_sub_pay_status in(".$pay_status.") ";

                 

             }else{

              

                 $condition.=" and us.usr_sub_pay_status='".$user['usr_sub_pay_status']."' ";

                 

             }

             

             

             

         }

         if($user['usr_sub_id']!=''){

             

             $condition.=" and us.usr_sub_id=".$user['usr_sub_id'];

             

         }

         

        $data=$this->db->query("SELECT us.usr_sub_id,sub.sub_id,us.usr_sub_status,us.usr_ref_id,usr.usr_ms_name,usr.usr_ms_owner_name,sub.sub_name,us.usr_sub_start_date,us.usr_sub_end_date,us.usr_sub_pay_status,us.usr_sub_serv_tax,us.usr_sub_price,us.usr_sub_transaction_id,us.usr_sub_transaction_date,us.usr_sub_serv_tax_amt,us.usr_sub_months FROM $this->tbl_stores as usr,$this->tbl_subscription as sub,$this->tbl_stores_sub as us where us.usr_ref_id=usr.usr_ref_id and us.sub_id=sub.sub_id $condition order by us.usr_sub_start_date DESC");

      

         

        return $data->result();

        

    }

    

    public function usr_sub_history_details($user=array())

    {

        if($user['usr_ref_id']!='')

        {

            

            $result=$this->db->query("SELECT us.his_usr_sub_id,sub.sub_id,us.his_usr_ref_id,usr.usr_ms_name,usr.usr_ms_owner_name,sub.sub_name,us.his_usr_sub_start_date,us.his_usr_sub_end_date,us.his_usr_sub_pay_status FROM $this->tbl_stores as usr,$this->tbl_subscription as sub,$this->tbl_store_sub_history as us where us.his_usr_ref_id=usr.usr_ref_id and us.his_sub_id=sub.sub_id and usr.usr_ref_id='".$user['usr_ref_id']."'");

         

            return $result->result();

            

        }

    }

    

    

    function add_usr_sub_history($user=array())

    {

     

        

        if(!empty($user))

        {

            $insert = $this->db->insert($this->tbl_stores_sub_history,$user);

            return 1;	

        }

        else

        {

            return 0;

        }

        

    }

    

    function get_usr_sub_history($usr_ref_id='')

    {

     

        $query =$this->db->query("SELECT * FROM $this->tbl_stores_sub_history where his_usr_ref_id='".$usr_ref_id."'");

        

     

        

    }

    

    public function update_usr_sub($usr_sub_id,$data=array())

    {

     

        $this->db->where('usr_sub_id',$usr_sub_id);

		

        $update = $this->db->update($this->tbl_stores_sub,$data);

		

		if($update){

			return TRUE;

		}

		else{

			return FALSE;

		}

        

    }

    

    function update_usr_status($data=array()){

        

          $update = $this->db->query("update `$this->tbl_stores` set usr_ms_status ='".$data['usr_ms_status']."' where usr_ref_id='".$data['usr_ref_id']."'");

          

		if($update){

			return TRUE;

		}

		else{

			return FALSE;

		}

        

    }

    

    function total_usr_sub_count()

    {

        

        

        $query = $this->db->query("SELECT * FROM $this->tbl_stores_sub where usr_sub_status='active'");

        

        return $query->num_rows();

        

    }

    

    function total_medicals()

    {

        

        $result=$this->db->query("SELECT * FROM $this->tbl_stores as usr where usr.usr_is_deleted=0");

        

        

        return $result->num_rows();

        

    }

  

    

    

    

    function get_end_user($args=array()){

	   

		$condition ="end_user_is_deleted =0";		       

        

		if($args['username'] && $args['password'])

		{

		    $condition .=" AND end_user_mob='".$args['username']."' AND end_user_pwd='".$args['password']."'";

	

		}

		

		if($args['end_user_remember_me']){

		      $condition .=" AND end_user_cookie='".$args['end_user_remember_me']."'";

		}

		

		if($args['email']){

		      $condition .=" AND end_user_email='".$args['email']."'";

		}

		

		if($args['mob_no']){

		      $condition .=" AND end_user_mob='".$args['mob_no']."'";

		}

        

        if($args['mob_no'] && $args['password']){

		      $condition .=" AND end_user_mob='".$args['mob_no']."' AND end_user_pwd='".$args['password']."' ";

		}

        

		$result = $this->db->select('end_user_id,end_user_name,end_user_email,end_user_mob,end_user_cookie,end_user_last_login,end_user_is_deleted,mob_no_status,email_status')

							

							->where($condition)

							->get($this->tbl_end_user);

        

       

		if($result){

			

			$status = $result->result();

      

			if($args['username'] && $args['password'] && $status[0]->end_user_is_deleted==0){

				

				$login_time = date("j\<\s\u\p\>S\<\/\s\u\p\> M Y H:i A");

				

				$data = array(

								'end_user_last_login'=>$login_time

							);

              

				$cur_end_usr_ref_id = $result->result();

			

				$this->db->where('end_user_id',$cur_end_usr_ref_id[0]->end_user_id);

				$update = $this->db->update($this->tbl_end_user,$data);

			}	

            

      

			return $result->result();

			

		}else{

		    return false;

		}

		

	}

    function set_end_user_cookie($cookie_value,$end_user_mob){

		

		$data = array(

							'end_user_cookie'=>$cookie_value

						);

		

		$this->db->where('end_user_mob',$end_user_mob);

		

		$this->db->update($this->tbl_end_user,$data);

	}

	

	

	function reset_end_user_password($password,$end_user_mob){

		

		$data = array(

							'end_user_pwd'=>$password

						);

		

		$this->db->where('end_user_mob',$end_user_mob);

		$update = $this->db->update($this->tbl_end_user,$data);

		if($update){

			return TRUE;

		}

		else{

			return FALSE;

		}

	}

    

    function save_bookmark($args=array()){

        

        if(!empty($args))

        {

            $this->db->insert($this->tbl_bookmarks,$args);

            return 1;	

        }

        else

        {

            return 0;

        }

    }

    function usr_sub_data($sub_id)

    {

        

        $query = $this->db->query("SELECT usr_sub.*,sub.sub_name,sub.sub_price,sub.sub_id FROM $this->tbl_stores_sub as usr_sub left join $this->tbl_subscription as sub on(usr_sub.sub_id=sub.sub_id) where usr_sub.usr_sub_id=$sub_id");

        

        return $query->result();

        

    }

    

    function get_user_info($usr_ref_id=''){

        

        $query = $this->db->query("SELECT usr_password from $this->tbl_stores where usr_ref_id='".$usr_ref_id."' ");

        

        return $query->result();

    }

    

    function user_sms($data=array()){

     

        if(!empty($data)){

            $this->db->insert($this->tbl_stores_sms,$data);

            $insert_id = $this->db->insert_id();

            return $insert_id;	

        }

        

    }

    function update_sms_payment($user_sms_id='',$data=array()){

        if($user_sms_id!=''){

            $this->db->where('usr_sms_id', $user_sms_id);

			

			$data = $this->db->update("$this->tbl_stores_sms", $data);



			return $data;

        }

    }

    function get_user_sms($data=array()){

        

        if($data['usr_sms_id']!=''){

            

            $condition=" usr_sms_id=".$data['usr_sms_id'];

            

        }

        

        

        $result = $this->db->select('no_of_sms,usr_ref_id')

							

							->where($condition)

							->get($this->tbl_stores_sms);

            

       

		if($result){

			

			return $result->result();

			

		}else{

		    return false;

		}

        

    }

    

    function discount_opt($args=array(),$action='',$limit='',$offset=''){

        

            switch($action){

                

                case'add': 

                                $result=$this->db->insert($this->store_discount,$args);

                                

                                return $result;

                                

                                break;

                                

                                

                case'edit':     

                

                                $this->db->where('dis_id',$args['dis_id']);

                    

                                $result=$this->db->update($this->store_discount,$args);

                                

                                return $result;

                                

                                break;

                case 'delete':

                    

                    

                                $this->db->where_in('dis_id',$args['dis_id']);



                                $arg=array('dis_delete_status'=>1);

                    

                                $result = $this->db->update($this->store_discount,$arg);



                                return $result;

                                

                                break;

                         

                                

                case 'dis_list':

                    

                    

                                ($limit>0 && $offset>=0)? $lim_off=" limit ".$limit." offset ".$offset:$lim_off="";

        



                                

                                $result=$this->db->query("SELECT * FROM $this->store_discount where dis_delete_status='0' $lim_off");

                                

                                

                                if(isset($args['get_count'])){

                                    

                                    return $result->num_rows();

                                    

                                }else{

                                    

                                    return $result->result();

                                    

                                }

                                

                                

                                          

                                break;

                            

                case 'get_dis_info':

                        

                                $this->db->select('*');

                                

                                $this->db->where('dis_id',$args['dis_id']);

                                        



                                $result = $this->db->get($this->store_discount);    



                                

                                return $result->result();

                                

                                break;

                case 'update':

                    

                                $this->db->where_in('dis_id',$args['dis_id']);



                                $arg=array('dis_publish_status'=>$args['dis_publish_status']);

                    

                                $result = $this->db->update($this->store_discount,$arg);



                                return $result;

                                

                                break;

                    

                case 'add_cpn_code':

                                

                                $result=$this->db->insert($this->store_dis_cpcd,$args);

                                

                                return $result;

                                

                                break;

                            

                case 'get_cpn_code':

                    

                                ($limit>0 && $offset>=0)? $lim_off=" limit ".$limit." offset ".$offset:$lim_off="";

                    

                                ($args['dis_id'])? $condition.=" AND cpncd.dis_id=".$args['dis_id'] : "";

                                

                                ($args['cpn_code'])? $condition.=" AND cpncd.cpn_code='".$args['cpn_code']."'" : "";

                               

                                ($args['cpn_id'])? $condition.=" AND cpncd.cpn_id='".$args['cpn_id']."'" : "";

                    

                                

                                $query = $this->db->query("SELECT cpncd.*,dis.* FROM $this->store_dis_cpcd as cpncd left join $this->store_discount as dis on (cpncd.dis_id=dis.dis_id) where cpncd.cpn_expire=0 AND dis.dis_delete_status=0 $condition $lim_off");

                            

                                

                                if($args['get_count']){

                                    

                                    return $query->num_rows();

                                    

                                }

                                else{

                                    

                                    return $query->result();

                                    

                                }

                                

                                break;

                                

                case 'update_cpncd':

                                

                    

                                $cpn_data=$args;

                    

                                $cpn_id=$cpn_data['cpn_id'];

                    

                                unset($cpn_data['cpn_id']);

            

                   

                                

                                $this->db->where('cpn_id',$cpn_id);

            

                                $result = $this->db->update($this->store_dis_cpcd,$cpn_data);

                    

                                

                                

                                return $result;

                                

                    

                                break;

                            

                case 'expire_cpn_code':

                                

                                 $this->db->query("update ms_store_dis_cpcd set cpn_expire=1 where DATEDIFF(cpn_validity_date,NOW())<0");

                                

                                break;

                            

                            

            }

            

    }

    

    

    

    function get_cpn_cd($args=array()){

        

        

        if($args['cpcd']!=''){

          

            

            $result=$this->db->query("SELECT cpcd.*,dis.* FROM $this->store_dis_cpcd as cpcd left join $this->store_discount as dis on (cpcd.dis_id=dis.dis_id) where dis.dis_publish_status=1 and dis_delete_status=0 and cpcd.cpn_expire=0 and DATEDIFF(cpcd.cpn_validity_date,NOW())>=0 and DATEDIFF(dis.discount_date_to,NOW())>=0 and cpcd.cpn_code='".$args['cpcd']."'");

            

            return $result->result();

            

        }

        

    }

    

    function update_cpn_cd($args=array(),$cpn_id=''){

     

            $this->db->where_in('cpn_id',$cpn_id);



            $result = $this->db->update($this->store_dis_cpcd,$args);



            return $result;

        

    }

    

    

    

    

    function get_inactive_transc(){

        

        $this->db->select('*');



        $this->db->where('usr_sub_status','inactive');



        $result = $this->db->get($this->tbl_stores_sub);    



        return $result->result();

        

    }

    

    function expire_sub_status(){

        

        $query =$this->db->query("update $this->tbl_stores_sub set usr_sub_status='expire' where usr_sub_end_date<=CURDATE() and usr_sub_status='active'");

        

    }

    

    

    

     function reset_store_password($password,$usr_ref_id){       

		

        if($password!='' && $usr_ref_id!=''){

            

            $data = array('usr_password'=>$password);       

		

            $this->db->where('usr_ref_id',$usr_ref_id);

            $update = $this->db->update($this->tbl_stores,$data);   

                       

            if($update){

                return TRUE;

            }else{

                return FALSE;

            }

           

        }

		

	}

    

    function get_store($args=array()){

    

        

		$this->db->select('usr_id,usr_ref_id,usr_ms_status,usr_ms_name,usr_ms_owner_email,usr_ms_owner_phone,usr_cookie,usr_reg_date,usr_last_login');

		

        if($args['usr_ref_id']!=''){

            $this->db->where('usr_ref_id', $args['usr_ref_id']);

        }

        

		if($args['usr_ms_owner_email']!=''){

			$this->db->where('usr_ms_owner_email', $args['usr_ms_owner_email']);

		}

		if($args['password']!='' && $args['username']!=''){

			$this->db->where('usr_ms_owner_email', $args['username']);

			$this->db->where('usr_password', $args['password']);

		}

		if($args['store_remember_me']!=''){

            

			$this->db->where('usr_cookie', $args['store_remember_me']);

		}

        if($args['usr_ms_owner_phone']!=''){

         

            $this->db->where('usr_ms_owner_phone', $args['usr_ms_owner_phone']);

            

        }

		

	

         $result = $this->db->get($this->tbl_stores);

		

         

		if($result){

			

			

			if($args['password']!='' && $args['username']!=''){

				

				

				

				$login_time = date("j\<\s\u\p\>S\<\/\s\u\p\> M Y H:i A");

				

				

				$data = array(

								'usr_last_login'=>$login_time

							);

				$cur_usr_ref_id = $result->result();

				

				$this->db->where('usr_ref_id',$cur_usr_ref_id[0]->usr_ref_id);

				$update = $this->db->update($this->tbl_stores,$data);

			}	

            

            

         //   echo $this->db->last_query();die;

           

		

			return $result->result();

			

		}else{

		    return false;

		}

		

	}

    

    

    function get_store_details($args=array()){

        

       $condition="";

        

        if(isset($args['usr_ref_id'])){                     

             $condition .= "AND usr_ref_id='".$args['usr_ref_id']."'" ;      

        }

  

        $query =$this->db->query("SELECT * FROM $this->tbl_stores where usr_is_deleted=0 $condition");

       		

        return $query->result();

        

    }

    

    function add_city_his($args=array()){

           

        $this->db->insert($this->tbl_city_his,$args);

          

	}

    

   function get_city_his($args=array(),$offset='',$limit='') {



        $condition=" 1";

        

        ($offset>=0 && $limit>0)? $offlim=" limit $limit offset $offset" : $offlim="";

        

        ($args['city']!='')?  $condition="  ch_name like '%".$args['city']."%' ":"" ;

        

        ($args['his_from_date']!='' && $args['his_to_date']!='')?  $condition.=" and  ch_date between '".$args['his_from_date']."%' and  '".$args['his_to_date']."%'" :"" ;

        

//        var_dump("SELECT * FROM $this->tbl_city_his where $condition $offlim");die;

        

        $result=$this->db->query("SELECT * FROM $this->tbl_city_his where $condition $offlim");

        

        if($args['get_count']){

            

            return $result->num_rows();

            

        }else{

            

            return $result->result();

            

        }

        



    }

    

}