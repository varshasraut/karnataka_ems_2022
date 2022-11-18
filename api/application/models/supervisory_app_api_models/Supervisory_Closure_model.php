<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Supervisory_Closure_model extends CI_Model {
    public function __construct(){
		parent::__construct();	
	}
    //*****Dispatch API Data function*****

   

    function get_total_pending_closure($args = array()){
        $report_type=$args['report_type'];
        // $zone=$args['zone'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        $division_type=$args['division_type'];
        $argument=$args['argument'];
        //$argument is district id or zone id or empty
        //$division_type is "district" or "zone" or empty
        // print_r($args);die;
        $condition="";
        $GROUP = "";
        // $GROUP .= "GROUP BY inc.inc_ref_id";
       
        $SEL = "";
       
        if($division_type=="zonewise"){
            $SEL .= "divi.div_code,divi.div_name,amb.amb_district,dist.dst_name,count(inc.inc_ref_id) as count";
            $GROUP .= "GROUP BY inc.inc_ref_id,divi.div_code";
        }else if($division_type=="zone"){
            $SEL .= "divi.div_code,divi.div_name,amb.amb_district,dist.dst_name,count(inc.inc_ref_id) as count";
            $condition .= "AND dist.div_id IN ('$argument')";
            $GROUP .= "GROUP BY inc.inc_ref_id,amb.amb_district";
        }else if($division_type=="district"){
            $SEL .= "divi.div_code,divi.div_name,amb.amb_district,dist.dst_name,count(inc.inc_ref_id) as count";
            $condition .= "AND amb.amb_district IN ('$argument')";
            $GROUP .= "GROUP BY inc.inc_ref_id";
        }elseif($division_type=="all"){
            $SEL .= "divi.div_code,divi.div_name,amb.amb_district,dist.dst_name,count(inc.inc_ref_id) as count";
            $GROUP .= "GROUP BY inc.inc_ref_id";
        }else{ 
            $SEL .= "inc.inc_ref_id";
            $GROUP .= "GROUP BY inc.inc_ref_id";
        }

        if($report_type=="total"){

        }else{
        $condition .= "AND inc.inc_datetime BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'";
        }
        // $condition="AND (back_to_base_loc  LIKE '%$from_date%')";
       
        $sql="select $SEL 
        from ems_incidence_ambulance AS inc_amb
        LEFT JOIN ems_incidence AS inc ON inc.inc_ref_id = inc_amb.inc_ref_id 
        LEFT JOIN ems_ambulance AS amb ON amb.amb_rto_register_no = inc_amb.amb_rto_register_no 
        LEFT JOIN ems_mas_districts as dist ON (amb.amb_district=dist.dst_code) 
        LEFT JOIN ems_mas_division as divi ON (dist.div_id=divi.div_code)
        where (inc.inc_pcr_status = '0')  $condition $GROUP";
        // $sql="select inc_ref_id from ems_incidence  
        // where (inc_pcr_status = '0' OR inc_pcr_status IS null)  $condition";
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->result_array();
            }else{
                return 0;
            }
    }
    
    function get_total_pending_validation($args = array()){
        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        $division_type=$args['division_type'];
        $argument=$args['argument'];
// print_r($args);die;
        $condition="";
        $GROUP = "";
        // $GROUP .= "GROUP BY inc.inc_ref_id";
       
        $SEL = "";
       
        if($division_type=="zonewise"){
            $SEL .= "divi.div_code,divi.div_name,amb.amb_district,dist.dst_name,count(inc.inc_ref_id) as count";
            $GROUP .= "GROUP BY inc.inc_ref_id,divi.div_code";
        }else if($division_type=="zone"){
            $SEL .= "divi.div_code,divi.div_name,amb.amb_district,dist.dst_name,count(inc.inc_ref_id) as count";
            $condition .= "AND dist.div_id IN ('$argument')";
            $GROUP .= "GROUP BY inc.inc_ref_id,amb.amb_district";
        }else if($division_type=="district"){
            $SEL .= "divi.div_code,divi.div_name,amb.amb_district,dist.dst_name,count(inc.inc_ref_id) as count";
            $condition .= "AND amb.amb_district IN ('$argument')";
            $GROUP .= "GROUP BY inc.inc_ref_id";
        }else if($division_type=="all"){ 
            $SEL .= "divi.div_code,divi.div_name,amb.amb_district,dist.dst_name,count(inc.inc_ref_id) as count";
            $GROUP .= "GROUP BY inc.inc_ref_id";
        }else{ 
            $SEL .= "inc.inc_ref_id";
            $GROUP .= "GROUP BY inc.inc_ref_id";
        }

        if($report_type=="total"){

        }else{
        $condition .= "AND inc.inc_datetime BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'";
        }
        // print_r($condition);die;
        // $condition="AND (back_to_base_loc  LIKE '%$from_date%')";
      
        $sql="select $SEL
        from ems_incidence_ambulance AS inc_amb 
        LEFT JOIN ems_incidence AS inc ON inc.inc_ref_id = inc_amb.inc_ref_id 
        LEFT JOIN ems_epcr AS epcr ON epcr.inc_ref_id = inc_amb.inc_ref_id 
        LEFT JOIN ems_ambulance AS amb ON amb.amb_rto_register_no = inc_amb.amb_rto_register_no 
        LEFT JOIN ems_mas_districts as dist ON (amb.amb_district=dist.dst_code) 
        LEFT JOIN ems_mas_division as divi ON (dist.div_id=divi.div_code) 
        WHERE  epcr.epcris_deleted='0' AND incis_deleted='0' 
        AND epcr.is_validate='0' AND operate_by NOT LIKE '%DCO%' 
        $condition $GROUP" ;
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->result_array();
            }else{
                return 0;
            }
    }
 

    function get_district_list($zone){
        $condition="";
        
        $condition .= "Where dstis_deleted IN ('0') AND div_id IN ('$zone')";
        // $condition .= "Where dstis_deleted IN ('0')";
        $sql="select dst_name ,dst_code  
        FROM ems_mas_districts  $condition";
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->result_array();
            }else{
                return 0;
            }
    }
   
    function get_zone_list(){
        $condition="";
        $condition .= "Where div_deleted IN ('0')";
        $sql="select div_name,div_code  FROM ems_mas_division $condition";
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->result_array();
            }else{
                return 0;
            }
    }
}