<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Supervisory_Distance_travelled_model extends CI_Model {
    public function __construct(){
		parent::__construct();	
	}
    //*****Distance API Data function*****

    function get_total_distance_travelled($args = array(),$dist_code){
        // print_r($dist_code);die;
        // $date=$args['to_date'];
        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        $condition="";
        if($report_type=="total"){
          
            $condition .= "Where amb.amb_district IN('$dist_code')";
        }else{
        $condition .= "Where timestmp.odometer_date BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59' AND amb.amb_district IN('$dist_code')";
        }
        $condition .="AND (timestmp.amb_rto_register_no NOT IN ('TT-00-MP-0000','DM-00-DM-0006','DM-00-DM-0004'))";
        // $sql="select incamb.inc_ref_id FROM `ems_incidence_ambulance` as incamb LEFT JOIN ems_incidence as inc ON incamb.inc_ref_id = inc.inc_ref_id LEFT JOIN ems_ambulance as amb ON incamb.amb_rto_register_no = amb.amb_rto_register_no $condition";
        $sql="select sum(timestmp.total_km)as sum,district.dst_name,type.ambt_name,amb.amb_type FROM `ems_ambulance_timestamp_record` as timestmp LEFT JOIN ems_ambulance as amb ON timestmp.amb_rto_register_no = amb.amb_rto_register_no LEFT JOIN ems_mas_districts as district ON  district.dst_code = amb.amb_district LEFT JOIN ems_mas_ambulance_type as type ON  type.ambt_id = amb.amb_type  $condition GROUP BY amb.amb_type";
        
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->result_array();
            }else{
                return [];
            }
    }
    function get_district_list(){
        $condition="";
        $condition .= "Where district.dstis_deleted IN ('0')'";
        $sql="select district.dst_name as disti_name,district.dst_code as disti_code FROM ems_mas_districts as district";
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->result_array();
            }else{
                return [];
            }
    }
}