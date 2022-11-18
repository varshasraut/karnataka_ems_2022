<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Supv_amb_maintenance_model extends CI_Model {
    public function __construct(){
		parent::__construct();	
	}
    //*****Dashboard Data Update function*****
    
    public function get_amb_maintenance_list($args = array()){
        $condition='';
        // print_r($args);die;

        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        $condition="";
        if($report_type=="total"){

        }else{
        // $condition .= "AND date BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'";
        }


        if($args['system_type'] != '' && $args['system_type'] != 'all' ){
            $system = implode("','",$args['system_type']);
            $condition .= " AND amb_user_type IN ('".$system."')";
         }
        if($args['status'] != '' && $args['status'] != 'all'){
      
            $condition .= " AND amb_status IN (".$args['status']." )";
            
        }
        
        $data=$this->db->query("select amb_added_date,amb_status,amb_rto_register_no  from ems_ambulance where ambis_deleted='0' $condition ");
        //echo $this->db->last_query()."<br>";
        //die();
        if($data->num_rows()){
            return $data->result_array();
        }else{
            return 0;
        }
    }

    public function get_offroad_preventive_list($args = array()){
        // print_r($args);die;
        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        //here to change datewise monthwise
        $condition='';
        $nowtime=date("Y-m-d h:i:s");
        // print_r($args);die;
        // $date = implode("','",$args['date']);
        if($report_type=="total"){

        }else{
        $condition .= "AND prev.added_date BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'";
        }
        if($args['system_type'] != '' && $args['system_type'] != 'all' ){
            $system = implode("','",$args['system_type']);
            $condition .= " AND amb.amb_user_type IN ('".$system."')";
         }
        if($args['status'] != '' && $args['status'] != 'all'){
            $status = implode("','",$args['status']);
            // print_r($status);die;
            $condition .= " AND amb.amb_status IN (".$status." )";
            
        }
        $condition .= " AND amb.amb_status IN (".$status." )";
        $condition .= " AND prev.mt_ambulance_status IN('Approved')";
        $condition .= " AND prev.mt_isdeleted='0'";
        $sel1=''; 
        $sel1=',prev.mt_offroad_datetime,prev.mt_ex_onroad_datetime,prev.mt_remark,prev.mt_Estimatecost';
        $data= array();
        $data=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type $sel1,
        CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, prev.mt_offroad_datetime, '$nowtime') / 3600 / 24),'days ', 
        FLOOR(MOD(TIMESTAMPDIFF(SECOND, prev.mt_offroad_datetime, '$nowtime'), 3600 * 24) / 3600),'hours ', 
        FLOOR( MOD(TIMESTAMPDIFF(SECOND, prev.mt_offroad_datetime, '$nowtime'), 3600) / 60),'minutes') AS duration 
        from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where amb.ambis_deleted='0' $condition ");
      
        // echo $this->db->last_query()."<br>";
        // die();
        if($data->num_rows()){
            return $data->result_array();
        }else{
            return [];
        }
    }


    public function get_offroad_tyre_list($args = array()){
        $condition='';
        $nowtime=date("Y-m-d h:i:s");
        // print_r($args);die;
        // $date = implode("','",$args['date']);
        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        if($report_type=="total"){

        }else{
        $condition .= "AND tyre.added_date BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'";
        }
        if($args['system_type'] != '' && $args['system_type'] != 'all' ){
            $system = implode("','",$args['system_type']);
            $condition .= " AND amb.amb_user_type IN ('".$system."')";
         }
        if($args['status'] != '' && $args['status'] != 'all'){
            $status = implode("','",$args['status']);
            // print_r($status);die;
            $condition .= " AND amb.amb_status IN (".$status." )";
            
        }
        $condition .= " AND amb.amb_status IN (".$status." )";
        $condition .= " AND tyre.mt_ambulance_status IN('Approved')";
        $condition .= " AND tyre.mt_isdeleted='0'";
        $sel1='';
        $sel1=',tyre.mt_offroad_datetime,tyre.mt_ex_onroad_datetime,tyre.mt_remark,tyre.mt_Estimatecost';
        $data= array();
        // $data['preventive']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        $data=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type $sel1,
        CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, tyre.mt_offroad_datetime, '$nowtime') / 3600 / 24),'days ', 
        FLOOR(MOD(TIMESTAMPDIFF(SECOND, tyre.mt_offroad_datetime, '$nowtime'), 3600 * 24) / 3600),'hours ', 
        FLOOR( MOD(TIMESTAMPDIFF(SECOND, tyre.mt_offroad_datetime, '$nowtime'), 3600) / 60),'minutes') AS duration 
         from ems_amb_tyre_maintaince as tyre LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = tyre.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where amb.ambis_deleted='0' $condition ");
        // $data['accidental']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        // $data['manpower']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        // $data['scrape']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        // $data['breakdown']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        // $data['onroad_offroad']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        // echo $this->db->last_query()."<br>";
        // die();
        if($data->num_rows()){
            return $data->result_array();
        }else{
            return [];
        }
    }


    public function get_offroad_accidental_list($args = array()){
        $condition='';
        $nowtime=date("Y-m-d h:i:s");
        // print_r($args);die;
        // $date = implode("','",$args['date']);
        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        if($report_type=="total"){

        }else{
        $condition .= "AND acc.added_date BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'";
        }
        if($args['system_type'] != '' && $args['system_type'] != 'all' ){
            $system = implode("','",$args['system_type']);
            $condition .= " AND amb.amb_user_type IN ('".$system."')";
         }
        if($args['status'] != '' && $args['status'] != 'all'){
            $status = implode("','",$args['status']);
            // print_r($status);die;
            $condition .= " AND amb.amb_status IN (".$status." )";
            
        }
        $condition .= " AND amb.amb_status IN (".$status." )";
        $condition .= " AND acc.mt_ambulance_status IN('Approved')";
        $condition .= " AND acc.mt_isdeleted='0'";
        $sel1='';
        $sel1=',acc.mt_offroad_datetime,acc.mt_ex_onroad_datetime,acc.mt_remark,acc.mt_Estimatecost';
        
        $data= array();
        // $data['preventive']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        // $data['tyre']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        $data=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type $sel1,
        CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, acc.mt_offroad_datetime, '$nowtime') / 3600 / 24),'days ', 
        FLOOR(MOD(TIMESTAMPDIFF(SECOND, acc.mt_offroad_datetime, '$nowtime'), 3600 * 24) / 3600),'hours ', 
        FLOOR( MOD(TIMESTAMPDIFF(SECOND, acc.mt_offroad_datetime, '$nowtime'), 3600) / 60),'minutes') AS duration 
         from ems_amb_accidental_maintaince as acc LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = acc.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where amb.ambis_deleted='0' $condition ");
        // $data['manpower']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        // $data['scrape']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        // $data['breakdown']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        // $data['onroad_offroad']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        // echo $this->db->last_query()."<br>";
        // die();
        if($data->num_rows()){
            return $data->result_array();
        }else{
            return [];
        }
    }

//not for maintenance
    public function get_offroad_manpower_list($args = array()){
        $condition='';
        // print_r($args);die;
        // $date = implode("','",$args['date']);
        if($args['system_type'] != '' && $args['system_type'] != 'all' ){
            $system = implode("','",$args['system_type']);
            $condition .= " AND amb.amb_user_type IN ('".$system."')";
         }
        if($args['status'] != '' && $args['status'] != 'all'){
            $status = implode("','",$args['status']);
            // print_r($status);die;
            $condition .= " AND amb.amb_status IN (".$status." )";
            
        }
        $condition .= " AND amb_status IN (".$status." )";
        $condition .= " AND manp.mt_ambulance_status IN('Approved')";
        $condition .= " AND manp.mt_isdeleted='0'";
       
        $data= array();
        // $data['preventive']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        // $data['tyre']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        // $data['accidental']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        $data=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_manpower_offroad as manp LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = manp.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where amb.ambis_deleted='0' $condition ");
        // $data['scrape']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        // $data['breakdown']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        // $data['onroad_offroad']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        // echo $this->db->last_query()."<br>";
        // die();
        if($data->num_rows()){
            return $data->result_array();
        }else{
            return [];
        }
    }

//not for maintenance
    public function get_offroad_scrape_list($args = array()){
        $condition='';
        // print_r($args);die;
        // $date = implode("','",$args['date']);
        if($args['system_type'] != '' && $args['system_type'] != 'all' ){
            $system = implode("','",$args['system_type']);
            $condition .= " AND amb.amb_user_type IN ('".$system."')";
         }
        if($args['status'] != '' && $args['status'] != 'all'){
            $status = implode("','",$args['status']);
            // print_r($status);die;
            $condition .= " AND amb.amb_status IN (".$status." )";
            
        }
        $condition .= " AND amb.amb_status IN (".$status." )";
        $condition .= " AND scr.mt_ambulance_status IN('Approved')";
        $condition .= " AND scr.mt_isdeleted='0'";
        $data= array();
        // $data['preventive']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        // $data['tyre']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        // $data['accidental']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        // $data['manpower']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        $data=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_scrape_vahicle as scr LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = scr.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where amb.ambis_deleted='0' $condition ");
        // $data['breakdown']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        // $data['onroad_offroad']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        // echo $this->db->last_query()."<br>";
        // die();
        if($data->num_rows()){
            return $data->result_array();
        }else{
            return 0;
        }
    }


    public function get_offroad_breakdown_list($args = array()){
        $condition='';
        $nowtime=date("Y-m-d h:i:s");
        // print_r($args);die;
        // $date = implode("','",$args['date']);
        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        if($report_type=="total"){

        }else{
        $condition .= "AND brk.added_date BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'";
        }
        if($args['system_type'] != '' && $args['system_type'] != 'all' ){
            $system = implode("','",$args['system_type']);
            $condition .= " AND amb.amb_user_type IN ('".$system."')";
         }
        if($args['status'] != '' && $args['status'] != 'all'){
            $status = implode("','",$args['status']);
            // print_r($status);die;
            $condition .= " AND amb.amb_status IN (".$status." )";
            
        }
        $condition .= " AND amb.amb_status IN (".$status." )";
        $condition .= " AND brk.mt_ambulance_status IN('Approved')";
        $condition .= " AND brk.mt_isdeleted='0'";
        $sel1='';
        $sel1=',brk.mt_offroad_datetime,brk.mt_ex_onroad_datetime,brk.mt_remark,brk.mt_Estimatecost';
        $data= array();
        $data=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type $sel1,
        CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, brk.mt_offroad_datetime, '$nowtime') / 3600 / 24),'days ', 
        FLOOR(MOD(TIMESTAMPDIFF(SECOND, brk.mt_offroad_datetime, '$nowtime'), 3600 * 24) / 3600),'hours ', 
        FLOOR( MOD(TIMESTAMPDIFF(SECOND, brk.mt_offroad_datetime, '$nowtime'), 3600) / 60),'minutes') AS duration
         from ems_amb_breakdown_maintaince as brk LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = brk.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where amb.ambis_deleted='0' $condition ");
        // echo $this->db->last_query()."<br>";
        // die();
        if($data->num_rows()){
            return $data->result_array();
        }else{
            return [];
        }
    }

//not for maintenance
    public function get_onroad_offroad_list($args = array()){
        $condition='';
        // print_r($args);die;
        // $date = implode("','",$args['date']);
        if($args['system_type'] != '' && $args['system_type'] != 'all' ){
            $system = implode("','",$args['system_type']);
            $condition .= " AND amb.amb_user_type IN ('".$system."')";
         }
        if($args['status'] != '' && $args['status'] != 'all'){
            $status = implode("','",$args['status']);
            // print_r($status);die;
            $condition .= " AND amb.amb_status IN (".$status." )";
            
        }
        $condition .= " AND amb.amb_status IN (".$status." )";
        $condition .= " AND onoff.mt_ambulance_status IN('Approved')";
        $condition .= " AND onoff.mt_isdeleted='0'";
        $data= array();
        // $data['preventive']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        // $data['tyre']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        // $data['accidental']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        // $data['manpower']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        // $data['scrape']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        // $data['breakdown']=$this->db->query("select  amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_ambulance_preventive_maintaince as prev LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where ambis_deleted='0' $condition ");
        $data=$this->db->query("select amb.amb_rto_register_no as amb_number,amb.gps_amb_lat,amb.gps_amb_log,location.hp_name,district.dst_name as district,ambl_type.ambt_name as vehicle_type from ems_amb_onroad_offroad as onoff LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = onoff.mt_amb_no )  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = amb.amb_district )  LEFT JOIN ems_mas_ambulance_type as ambl_type ON ( ambl_type.ambt_id = amb.amb_type ) LEFT JOIN ems_base_location as location ON ( location.hp_id = amb.amb_base_location ) where amb.ambis_deleted='0' $condition ");
        // echo $this->db->last_query()."<br>";
        // die();
        if($data->num_rows()){
            return $data->result_array();
        }else{
            return 0;
        }
    }
}