<?php
class Dashboard_model extends CI_Model {
	
    function __construct() {
        parent::__construct();
         $this->tbl_goods = $this->db->dbprefix('goods');
        $this->tbl_advertise = $this->db->dbprefix('advertise');
        $this->tbl_services = $this->db->dbprefix('services');
        $this->tbl_stores = $this->db->dbprefix('stores');
        $this->tbl_city = $this->db->dbprefix('city');
        $this->tbl_category = $this->db->dbprefix('category');
        $this->tbl_stores_subscription = $this->db->dbprefix('stores_subscription');
        $this->tbl_subscription_type = $this->db->dbprefix('subscription_type');
        $this->tbl_subscription_plan = $this->db->dbprefix('subscription_plan');
        $this->tbl_atc = $this->db->dbprefix('mas_atc');
        $this->tbl_po = $this->db->dbprefix('mas_po');
        $this->tbl_cluster = $this->db->dbprefix('cluster');
         $this->tbl_school = $this->db->dbprefix('school');
    }
    
        function get_atc_list_id($atc_id){
            if (is_array($atc_id)) {
            $atc_id = implode(',', $atc_id);
        }

        $sql_where = " WHERE 1=1 ";

        $sql_where .= " AND `" . atc_id . "` IN (" . $atc_id . ") ";

        $sql_str = "SELECT * FROM $this->tbl_atc " . $sql_where;

        $result = $this->db->query($sql_str);

        if ($result) {
            return $result->result();
        } else {
            return array();
        }
        }
    
    function get_atc_list($args = array()){
        $this->db->select('*');
        $this->db->from($this->tbl_atc);
        $this->db->where(array("is_deleted" => "0"));  
        
        if (trim($args['atc_name']) != '') {
           $atc_name = $args['atc_name'];
           //$this->db->or_like('atc_name', $atc_name, 'both'); 
        }
        if (trim($args['atc_id']) != '') {
           $atc_id = $args['atc_id'];
           $this->db->where(array("atc_id" => $atc_id)); 
        }
        
        
        $this->db->order_by('atc_id', 'ASC');
        $data = $this->db->get();
    
        $result = $data->result();
        return $result;
    }
    function get_po_by_atc_id($atc_id){
        $this->db->select('*');
        $this->db->from($this->tbl_po);
        $this->db->where(array("atc_id" => $atc_id));  
         $this->db->where(array("is_deleted" => "0"));
        $this->db->order_by('po_id', 'ASC');
        $data = $this->db->get();
        $result = $data->result();
        return $result;
    }
    
    function get_auto_po_by_atc_id($args = array()) {

      
        if (trim($args['po_name']) != '') {

            $condition.=" AND po_name LIKE '" . $args['po_name'] . "%'";
        }
        if ($args['atc_id'] != '') {

            $condition.=" AND atc_id = '" . $args['atc_id'] . "'";
        }
         if ($args['po_id'] != '') {

            $condition.=" AND po_id = '" . $args['po_id'] . "'";
        }

        $sql = "SELECT * FROM $this->tbl_po WHERE is_deleted='0' $condition ORDER BY po_name ASC"; 

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
     function get_cluter_by_po_id($po_id){
        $this->db->select('*');
        $this->db->from($this->tbl_cluster);
        $this->db->where(array("po" => $po_id));  
         $this->db->where(array("isdeleted" => "0"));
        $this->db->order_by('cluster_id', 'ASC');
        $data = $this->db->get();
    
        $result = $data->result();
        return $result;
    }
    
     function get_school_by_cluster_id($cluster_id){
        $this->db->select('*');
        $this->db->from($this->tbl_school);
        $this->db->where(array("cluster_id" => $cluster_id));  
        $this->db->where(array("school_isdeleted" => "0"));
        $this->db->where(array("school_type " => "school"));
        $this->db->order_by('school_id', 'ASC');
        $data = $this->db->get();
    
        $result = $data->result();
        return $result;
    }
    
        function get_category_list(){
        $this->db->select('*');
        $this->db->from($this->tbl_category);
        $this->db->where(array("is_deleted" => "0"));  
        $this->db->order_by('id', 'ASC');
        $data = $this->db->get();
        $result = $data->result();
        return $result;
    }

    
    function get_user_details(){
        $result = $this->db->query("SELECT CONCAT(usr.usr_first_name,' ',usr.usr_last_name) seller_name, usr.usr_ref_id, ct.city_name FROM $this->tbl_stores as usr LEFT JOIN $this->tbl_city as ct ON usr.usr_zip_code=ct.city_zip");
        return $result->result();
    }

    
    function get_users_list($args=array()){

        $query.="SELECT users.usr_id,users.usr_ref_id , users.usr_first_name , users.usr_middle_name, users.usr_last_name , users.usr_password ,users.usr_gender,users.usr_registration_date, users.usr_profile_photo, users.usr_birth_date,users.usr_registration_date,users.usr_last_login ,users.usr_email,users.usr_mobile,users.usr_status ,user_sub.usr_date, users.usr_is_blocked ,users.usr_zip_code,user_sub.usr_sub_type_id,city.city_name ,sub_type.st_name,sub_plan.sp_name "

                       . "FROM $this->tbl_stores as users "

                       . "LEFT JOIN $this->tbl_stores_subscription as user_sub "

                       . "ON(users.usr_id=user_sub.usr_id) "

                       . "LEFT JOIN (SELECT city_zip,city_id,city_name from $this->tbl_city group by city_zip) as city "

                       . "ON(users.usr_zip_code=city.city_zip) "

                       . "LEFT JOIN $this->tbl_subscription_type as sub_type "

                       . "ON(user_sub.usr_sub_type_id=sub_type.st_id) "

                       . "LEFT JOIN $this->tbl_subscription_plan as sub_plan "

                       . "ON(user_sub.usr_plan_id=sub_plan.sp_id) "

                       . "WHERE users.usr_is_deleted = 0 ";


            if($args['user_type']){

                $query.=" AND sub_type.st_name LIKE '%".$args['user_type']."%' ";

            }
            
            if($args['reg_date']){

                $query.=" AND users.usr_registration_date='".$args['reg_date']."'";

            }

            
            $query.=" ORDER BY users.usr_id DESC";
            
            if($args['limit']){

                $query.=" LIMIT ".$args['limit'];

            }

        $result=$this->db->query($query);

        return $args["total_count"] == "yes"?$result->num_rows():$result->result();

    }
    public function get_amb_tracking_data($args = array()){
        $this->db->select('login.vehicle_no,amb.amb_default_mobile');
        $this->db->from('ems_app_login_session login');
        $this->db->join('ems_ambulance amb', 'login.vehicle_no = amb.amb_rto_register_no');
        $this->db->where('login.status', '1');
        $this->db->where('amb.ambis_deleted', '0');
         if ($args['district_id'] != '') {
               $this->db->where(' amb.amb_district', $args['district_id']);
             //$condition .= " AND amb.amb_district IN ('" . $args['district_id'] . "')  ";
        }
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    function saveremarks($data)
	{
        // print_r($data);die;
	$this->db->insert('ems_operationhr_remarks',$data);
    return 1;
	// $this->db->query($query);
    //echo $this->db->last_query();
	}
        
    function save_denial_remarks($data){
        // print_r($data);die;
        
        $result = $this->db->insert('ems_denial_ambulance_remarks',$data);
             
        if($result){
            return $result;
        }else{
            return false;
        } 

	}
     function get_denial_remarks($denial_id){
    
        $this->db->select('rem.amb_id,rem.remark,rem.added_date,rem.added_by,clg.clg_first_name,clg.clg_mid_name,clg.clg_last_name');
        $this->db->from('ems_denial_ambulance_remarks as rem');
        $this->db->join('ems_colleague clg', 'rem.added_by = clg.clg_ref_id');
        $this->db->where("rem.denial_id", $denial_id);  
        // $this->db->order_by('added_date', 'DESC');
        // $this->db->limit(1);
        $data = $this->db->get();
    
        $result = $data->result();
//         echo $this->db->last_query();
//         die();
        return $result;

    }
    function showremarks($amb_id){
    
        $this->db->select('rem.amb_id,rem.remark,rem.added_date,rem.added_by,clg.clg_first_name,clg.clg_mid_name,clg.clg_last_name');
        $this->db->from('ems_operationhr_remarks rem');
        $this->db->join('ems_colleague clg', 'rem.added_by = clg.clg_ref_id');
        $this->db->where("rem.amb_id", $amb_id);  
        $this->db->where('DATE(rem.added_date)=CURDATE()');
        // $this->db->order_by('added_date', 'DESC');
        // $this->db->limit(1);
        $data = $this->db->get();
    
        $result = $data->result();
        // echo $this->db->last_query();
        return $result;

    }
    function show_other_remarks($clg_id){
    
        $this->db->select('rem.amb_id,rem.remark,rem.added_date,rem.added_by,clg.clg_first_name,clg.clg_mid_name,clg.clg_last_name');
        $this->db->from('ems_operationhr_remarks rem');
        $this->db->join('ems_colleague clg', 'rem.added_by = clg.clg_ref_id');
        $this->db->where("rem.clg_id", $clg_id);  
        $this->db->where('DATE(rem.added_date)=CURDATE()');
        // $this->db->order_by('added_date', 'DESC');
        // $this->db->limit(1);
        $data = $this->db->get();
    
        $result = $data->result();
        return $result;

    }
    function emso_challenge(){
        $this->db->select('*');
        $this->db->from('ems_denial_reason');
        $this->db->where("challenge", "EMT");  
        $this->db->where("is_deleted", "0");  
        $this->db->order_by('id', 'ASC');
        $data = $this->db->get();
       // echo $this->db->last_query();die;
        $result = $data->result();
       
        return $result;

    }
    function pilot_challenge(){
        $this->db->select('*');
        $this->db->from('ems_denial_reason');
        $this->db->where(array("challenge" => "Pilot"));  
        $this->db->where("is_deleted", "0");  
        $this->db->order_by('id', 'ASC');
        $data = $this->db->get();
        $result = $data->result();
        return $result;

    }
    function equipment_challenge(){
        $this->db->select('*');
        $this->db->from('ems_denial_reason');
        $this->db->where(array("challenge" => "Equipment"));  
        $this->db->where("is_deleted", "0");  
        $this->db->order_by('id', 'ASC');
        $data = $this->db->get();
        $result = $data->result();
        return $result;
    }
    function tech_challenge(){
        $this->db->select('*');
        $this->db->from('ems_denial_reason');
        $this->db->where(array("challenge" => "Technical"));  
        $this->db->where("is_deleted", "0");  
        $this->db->order_by('id', 'ASC');
        $data = $this->db->get();
        $result = $data->result();
        return $result;
    }
    function save_denial($data)
	{
    // print_r($data);die;
	$this->db->insert('ems_denial_complaints',$data);


    return  $this->db->insert_id();;

	}
    
   function update_denial($data){

       
        if($data['id'] != ''){
            
            $this->db->where('id', $data['id']);
            unset($data['id']);
            $data = $this->db->update("ems_denial_complaints", $data);
    //        echo $this->db->last_query();
    // die();
            return $data;
            
        }
        
	}
    function get_push_closure_validate_date(){
        $data = "SELECT incamb.amb_rto_register_no,inc.inc_ref_id,inc.inc_system_type,epcr.id,epcr.epcr_call_type,epcr.rec_hospital_name,epcr.other_receiving_host,inc.inc_recive_time,inc.inc_datetime,inc.inc_state_id,chief_com.ct_type,mci.ntr_nature,GROUP_CONCAT(NULLIF(ptn.ayushman_id,'')) as ayushman_id,purcall.pname,pcr.dp_on_scene,pcr.dp_hosp_time,pcr.dp_back_to_loc,pcr.start_odometer,pcr.end_odometer,pro.pro_name
        FROM `ems_incidence_ambulance` as incamb
        LEFT JOIN ems_incidence as inc ON (incamb.inc_ref_id = inc.inc_ref_id)
        LEFT JOIN ems_epcr as epcr ON (inc.inc_ref_id = epcr.inc_ref_id AND inc.inc_set_amb = '1')
        LEFT JOIN ems_mas_provider_imp as pro ON (epcr.provider_impressions = pro.pro_id)
        LEFT JOIN ems_driver_pcr as pcr ON (epcr.id = pcr.dp_pcr_id)
        -- LEFT JOIN ems_hospital As hosp On (epcr.rec_hospital_name = hosp.hp_id)
        -- LEFT JOIN `ems_mas_hospital_type` As hospType On (hosp.hp_type = hospType.hosp_id)
        LEFT JOIN ems_incidence_patient as incptn ON (inc.inc_ref_id = incptn.inc_id)
        LEFT JOIN ems_patient as ptn ON (incptn.ptn_id = ptn.ptn_id)
        LEFT JOIN ems_mas_call_purpose as purcall ON (inc.inc_type = purcall.pcode)
        LEFT JOIN ems_mas_patient_complaint_types as chief_com ON (chief_com.ct_id = inc.inc_complaint)
        LEFT JOIN ems_mas_micnature as mci ON (mci.ntr_id = inc.inc_mci_nature)
        WHERE  epcr.is_validate = '1' AND epcr.epcris_deleted = '0' AND inc.inc_pcr_status = '1' AND inc.inc_duplicate = 'No' AND inc.incis_deleted = '0' AND inc.closure_data_pass_to_gps = '3' AND inc.inc_datetime BETWEEN '2022-10-01 00:00:00' AND '2022-10-30 23:59:59'
        GROUP BY inc.inc_ref_id
        LIMIT 50";
        return $this->db->query($data)->result_array();
    }
    function insert_dispatch_gps_data($data_to_post){
       // var_dump($data_to_post);die();
        $this->db->insert('ems_dispatch_data_pass_to_gps',$data_to_post);
        //die();
    }
    function insert_gps_data($gps){
        // print_r($gps);
        $this->db->insert('ems_closure_data_pass_to_gps',$gps);
    }
    function update_inc_pcr_status_fail($inc){
        $rec['closure_data_pass_to_gps'] = '0';
        $this->db->where('inc_ref_id',$inc)->update('ems_incidence',$rec);
    }
    function update_inc_pcr_status($inc){
        $rec['closure_data_pass_to_gps'] = '1';
        $this->db->where('inc_ref_id',$inc)->update('ems_incidence',$rec);
    }
    function get_inc_table_update_gps_rec(){
        $data = "SELECT gps.*,inc.closure_data_pass_to_gps FROM ems_closure_data_pass_to_gps as gps"
            ." LEFT JOIN ems_incidence as inc ON (gps.JobNo = inc.inc_ref_id)" 
            ." WHERE inc.closure_data_pass_to_gps = '0' AND inc.closure_data_pass_to_gps = '0' GROUP BY gps.JobNo limit 100";
        return $this->db->query($data)->result_array();
        // return $this->db->where('closure_data_pass_to_gps','0')->limit(1)->get('ems_closure_data_pass_to_gps')->result();
    }
    function get_inc_table_update_gps_rec1(){
        $data = "SELECT ems_dispatch_data_pass_to_gps.*,ems_incidence_ambulance.amb_rto_register_no AS amb_no  from ems_dispatch_data_pass_to_gps"
        ."LEFT JOIN ems_incidence_ambulance ON ems_incidence_ambulance.inc_ref_id = ems_dispatch_data_pass_to_gps.JobNo"
            ." WHERE ems_dispatch_data_pass_to_gps.closure_data_pass_to_gps = '1' ";
            // echo $data; die;
        return $this->db->query($data)->result_array();
        // return $this->db->where('closure_data_pass_to_gps','0')->limit(1)->get('ems_closure_data_pass_to_gps')->result();
    }
    function update_gps_rec_in_inc_table($inc,$gpsRec){
        $this->db->where('inc_ref_id',$inc)->update('ems_incidence',$gpsRec);
        return 1;
    }
    function update_status_dispatch_gps_data($gpsRec){
        $inc = $gpsRec['id'];
        $this->db->where('id',$inc)->update('ems_dispatch_data_pass_to_gps',$gpsRec);
        return 1;
    }
}