<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Supervisory_patient_served_model extends CI_Model {
    public function __construct(){
		parent::__construct();	
	}
    //*****Dispatch API Data function*****

    // function get_total_dispatch_list($args = array()){
    //     $date=$args['date'];
    //     $to_date = $date;
    //     $from_date = $date;
    //     $condition="Where (start_from_base_loc  LIKE '%$from_date%')";
    //     $sql="select incident_id from ems_driver_parameters  $condition";
    //     $data2=$this->db->query($sql);
    //     // echo $this->db->last_query($sql)."<br>";
    //     // die;
    //     if($data2->num_rows()){
    //             return $data2->num_rows();
    //         }else{
    //             return 0;
    //         }
    // }

    function get_total_Assault($args = array()){
        // $date=$args['to_date'];
        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        $condition="";
        if($report_type=="total"){
            $condition .= "Where epcr.provider_impressions IN ('6') AND epcr.is_validate='1'";
        }else{
        $condition .= "Where epcr.inc_datetime BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'  AND epcr.provider_impressions IN ('6') AND epcr.is_validate='1'";
        }
        $condition .="AND (epcr.epcris_deleted IN ('0'))";
        // $condition="Where (inc.inc_datetime LIKE '%$from_date%')";
        $sql="select epcr.inc_ref_id FROM `ems_epcr` as epcr  $condition";
        
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
    
    function get_total_AnimalAttack($args = array()){
        // $date=$args['to_date'];
        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        $condition="";
        if($report_type=="total"){
            $condition .= "Where epcr.provider_impressions IN ('30','37','50') AND epcr.is_validate='1'";
        }else{
        $condition .= "Where epcr.inc_datetime BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'  AND epcr.provider_impressions IN ('30','37','50') AND epcr.is_validate='1'";
        }
        $condition .="AND (epcr.epcris_deleted IN ('0'))";
        // $condition="Where (inc.inc_datetime LIKE '%$from_date%')";
        $sql="select epcr.inc_ref_id FROM `ems_epcr` as epcr  $condition";
        
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }


    function get_total_Burn($args = array()){
        // $date=$args['to_date'];
        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        $condition="";
        if($report_type=="total"){
            $condition .= "Where epcr.provider_impressions IN ('66') AND epcr.is_validate='1'";
        }else{
        $condition .= "Where epcr.inc_datetime BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'  AND epcr.provider_impressions IN ('66') AND epcr.is_validate='1'";
        }
        $condition .="AND (epcr.epcris_deleted IN ('0'))";
        // $condition="Where (inc.inc_datetime LIKE '%$from_date%')";
        $sql="select epcr.inc_ref_id FROM `ems_epcr` as epcr  $condition";
        
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }

    function get_total_Poisoning($args = array()){
        // $date=$args['to_date'];
        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        $condition="";
        if($report_type=="total"){
            $condition .= "Where epcr.provider_impressions IN ('13','23') AND epcr.is_validate='1'";
        }else{
        $condition .= "Where epcr.inc_datetime BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'  AND epcr.provider_impressions IN ('13','23') AND epcr.is_validate='1'";
        }
        $condition .="AND (epcr.epcris_deleted IN ('0'))";
        // $condition="Where (inc.inc_datetime LIKE '%$from_date%')";
        $sql="select epcr.inc_ref_id FROM `ems_epcr` as epcr  $condition";
        
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
    function get_total_Labour($args = array()){
        // $date=$args['to_date'];
        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        $condition="";
        if($report_type=="total"){
            $condition .= "Where epcr.provider_impressions IN ('24','34','11','12','65','75') AND epcr.is_validate='1'";
        }else{
        $condition .= "Where epcr.inc_datetime BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'  AND epcr.provider_impressions IN ('24','34','11','12','65','75') AND epcr.is_validate='1'";
        }
        $condition .="AND (epcr.epcris_deleted IN ('0'))";
        // $condition="Where (inc.inc_datetime LIKE '%$from_date%')";
        $sql="select epcr.inc_ref_id FROM `ems_epcr` as epcr  $condition";
        
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
    function get_total_Lighting($args = array()){
        // $date=$args['to_date'];
        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        $condition="";
        if($report_type=="total"){
            $condition .= "Where epcr.provider_impressions IN ('14') AND epcr.is_validate='1'";
        }else{
        $condition .= "Where epcr.inc_datetime BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'  AND epcr.provider_impressions IN ('14') AND epcr.is_validate='1'";
        }
        $condition .="AND (epcr.epcris_deleted IN ('0'))";
        // $condition="Where (inc.inc_datetime LIKE '%$from_date%')";
        $sql="select epcr.inc_ref_id FROM `ems_epcr` as epcr  $condition";
        
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
 
    function get_total_Mass_Casualty($args = array()){
        // $date=$args['to_date'];
        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        $condition="";
        if($report_type=="total"){
            $condition .= "Where epcr.provider_impressions IN ('70','71') AND epcr.is_validate='1'";
        }else{
        $condition .= "Where epcr.inc_datetime BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'  AND epcr.provider_impressions IN ('70','71') AND epcr.is_validate='1'";
        }
        $condition .="AND (epcr.epcris_deleted IN ('0'))";
        // $condition="Where (inc.inc_datetime LIKE '%$from_date%')";
        $sql="select epcr.inc_ref_id FROM `ems_epcr` as epcr  $condition";
        
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }

    function get_total_Medical($args = array()){
        // $date=$args['to_date'];
        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        $condition="";
        if($report_type=="total"){
            $condition .= "Where epcr.provider_impressions IN ('1','3','4','5','8','9','10','15','16','17','18','19','20','25','26','27','28','29','31','32','38','39','46','47','48','49','51','54','55','57','58','59','60','61','62','63','64','67','68','69','77') AND epcr.is_validate='1'";
        }else{
        $condition .= "Where epcr.inc_datetime BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'  AND epcr.provider_impressions IN ('1','3','4','5','8','9','10','15','16','17','18','19','20','25','26','27','28','29','31','32','38','39','46','47','48','49','51','54','55','57','58','59','60','61','62','63','64','67','68','69','77') AND epcr.is_validate='1'";
        }
        $condition .="AND (epcr.epcris_deleted IN ('0'))";
        // $condition="Where (inc.inc_datetime LIKE '%$from_date%')";
        $sql="select epcr.inc_ref_id FROM `ems_epcr` as epcr  $condition";
        
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }

    
    function get_total_Others($args = array()){
        // $date=$args['to_date'];
        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        $condition="";
        if($report_type=="total"){
            $condition .= "Where epcr.provider_impressions IN ('2','7','22','35','36','43','45','76') AND epcr.is_validate='1'";
        }else{
        $condition .= "Where epcr.inc_datetime BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'  AND epcr.provider_impressions IN ('2','7','22','35','36','43','45','76') AND epcr.is_validate='1'";
        }
        $condition .="AND (epcr.epcris_deleted IN ('0'))";
        // $condition="Where (inc.inc_datetime LIKE '%$from_date%')";
        $sql="select epcr.inc_ref_id FROM `ems_epcr` as epcr  $condition";
        
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
    
    
    function get_total_Suicide($args = array()){
        // $date=$args['to_date'];
        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        $condition="";
        if($report_type=="total"){
            $condition .= "Where epcr.provider_impressions IN ('40') AND epcr.is_validate='1'";
        }else{
        $condition .= "Where epcr.inc_datetime BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'  AND epcr.provider_impressions IN ('40') AND epcr.is_validate='1'";
        }
        $condition .="AND (epcr.epcris_deleted IN ('0'))";
        // $condition="Where (inc.inc_datetime LIKE '%$from_date%')";
        $sql="select epcr.inc_ref_id FROM `ems_epcr` as epcr  $condition";
        
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
    
    
    function get_total_Trauma_nonvehicle($args = array()){
        // $date=$args['to_date'];
        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        $condition="";
        if($report_type=="total"){
            $condition .= "Where epcr.provider_impressions IN ('56') AND epcr.is_validate='1'";
        }else{
        $condition .= "Where epcr.inc_datetime BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'  AND epcr.provider_impressions IN ('56') AND epcr.is_validate='1'";
        }
        $condition .="AND (epcr.epcris_deleted IN ('0'))";
        // $condition="Where (inc.inc_datetime LIKE '%$from_date%')";
        $sql="select epcr.inc_ref_id FROM `ems_epcr` as epcr  $condition";
        
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
    
    
    function get_total_Trauma_vehicle($args = array()){
        // $date=$args['to_date'];
        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        $condition="";
        if($report_type=="total"){
            $condition .= "Where epcr.provider_impressions IN ('33') AND epcr.is_validate='1'";
        }else{
        $condition .= "Where epcr.inc_datetime BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'  AND epcr.provider_impressions IN ('33') AND epcr.is_validate='1'";
        }
        $condition .="AND (epcr.epcris_deleted IN ('0'))";
        // $condition="Where (inc.inc_datetime LIKE '%$from_date%')";
        $sql="select epcr.inc_ref_id FROM `ems_epcr` as epcr  $condition";
        
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }

    function get_total_pick_up($args = array()){
        // $date=$args['to_date'];
        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        $condition="";
        if($report_type=="total"){
            $condition .= "Where inc.inc_type IN ('PICK_UP')";
        }else{
        $condition .= "Where inc_amb.assigned_time BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'  AND inc.inc_type IN ('PICK_UP')";
        }
        $condition .="AND inc.inc_set_amb = '1' AND inc.inc_duplicate = 'No'";
        $condition .="AND (inc.incis_deleted IN ('0'))";
        $sql="select inc.inc_ref_id FROM `ems_incidence` as inc  LEFT JOIN ems_incidence_ambulance as inc_amb ON inc_amb.inc_ref_id = inc.inc_ref_id $condition";
        
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
    function get_total_drop($args = array()){
        // $date=$args['to_date'];
        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        $condition="";
        if($report_type=="total"){
            $condition .= "Where inc.inc_type IN ('DROP_BACK')";
        }else{
        $condition .= "Where inc_amb.assigned_time BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'  AND inc.inc_type IN ('DROP_BACK')";
        }
        $condition .="AND inc.inc_set_amb = '1' AND inc.inc_duplicate = 'No'";
        $condition .="AND (inc.incis_deleted IN ('0'))";
        $sql="select inc.inc_ref_id FROM `ems_incidence` as inc  LEFT JOIN ems_incidence_ambulance as inc_amb ON inc_amb.inc_ref_id = inc.inc_ref_id $condition";
        
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
    function get_total_ift($args = array()){
        // $date=$args['to_date'];
        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        $condition="";
        if($report_type=="total"){
            $condition .= "Where inc.inc_type IN ('IN_HO_P_TR')";
        }else{
        $condition .= "Where inc_amb.assigned_time BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'  AND inc.inc_type IN ('IN_HO_P_TR')";
        }
        $condition .="AND inc.inc_set_amb = '1' AND inc.inc_duplicate = 'No'";
        $condition .="AND (inc.incis_deleted IN ('0'))";
        $sql="select inc.inc_ref_id FROM `ems_incidence` as inc  LEFT JOIN ems_incidence_ambulance as inc_amb ON inc_amb.inc_ref_id = inc.inc_ref_id $condition";
        
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }


    function get_b12_supv_data($args,$pro=array()){
        $condition = '';
        $report_type=$args['report_type'];
      
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
           
        }
        if($report_type=="total"){
            $condition .= "";
        }else{
            $condition .= "  AND epcr.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if(!empty($pro)){
            $provider = implode("','",$pro);
            $condition .= " AND pro_imm.b12_type IN ('$provider')";
        }
        if (isset($args['district']) && $args['district'] != '') {
            
            $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
            
        }
        
        $sql =  "SELECT epcr.inc_ref_id"
                . " FROM ems_epcr as epcr "
                . " LEFT JOIN ems_mas_provider_imp as pro_imm ON pro_imm.pro_id =  epcr.provider_impressions"
                ." where  epcr.epcris_deleted = '0'  AND is_validate ='1' $condition ";
        $data2 = $this->db->query($sql);



        if($data2->num_rows()){
            return $data2->num_rows();
        }else{
            return 0;
        }
     
      }

      
      function supv_b12_data_report_108($args){
        $condition = '';
        $report_type=$args['report_type'];
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            
        }
        if($report_type=="total"){
            $condition .= "";
        }else{
            $condition .= "  AND epcr.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['sys_type'] != '') {
            $condition .= " AND amb.amb_user_type  = '" . $args['sys_type'] . "'";
        }
        $condition .= " AND inc.inc_type NOT IN ('DROP_BACK','PICK_UP','IN_HO_P_TR')";
        $condition .= " AND epcr.provider_impressions NOT IN ('21','41','42','44','52','53')";

        $sql =  "SELECT epcr.provider_impressions,pro_imm.pro_name,count(epcr.inc_ref_id) as total_count"
            . " FROM ems_epcr as epcr "
            . " LEFT JOIN ems_incidence as inc ON  epcr.inc_ref_id = inc.inc_ref_id"
            . " LEFT JOIN ems_ambulance as amb ON  epcr.amb_reg_id = amb.amb_rto_register_no"
            . " LEFT JOIN ems_mas_provider_imp as pro_imm ON pro_imm.pro_id =  epcr.provider_impressions"
            ." where  epcr.epcris_deleted = '0'  AND is_validate ='1' $condition GROUP By pro_name  order By total_count DESC";
        // echo $sql;die(); 
        $result = $this->db->query($sql);
        if ($result->num_rows()) {

            return $result->result_array();
        } else {
            return $result->result();
        }
        
  }
  function supv_pickup108_data_report($args){
    $condition = '';
    $report_type=$args['report_type'];
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
           
        }
        if($report_type=="total"){
            $condition .= "";
        }else{
            $condition .= "  AND epcr.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['sys_type'] != '') {
            $condition .= " AND amb.amb_user_type  = '" . $args['sys_type'] . "'";
        }
        $condition .= " AND inc.inc_type IN ('PICK_UP')"; 
        $condition .= " AND epcr.provider_impressions NOT IN ('21','41','42','44','52','53')";

        $sql =  "SELECT count(epcr.inc_ref_id) as total_count"
            . " FROM ems_epcr as epcr "
            . " LEFT JOIN ems_incidence as inc ON  epcr.inc_ref_id = inc.inc_ref_id"
            . " LEFT JOIN ems_ambulance as amb ON  epcr.amb_reg_id = amb.amb_rto_register_no"
            . " LEFT JOIN ems_mas_provider_imp as pro_imm ON pro_imm.pro_id =  epcr.provider_impressions"
            . " where  epcr.epcris_deleted = '0'  AND is_validate ='1' $condition ";
        // echo $sql;die();
        $result = $this->db->query($sql);
        if ($result->num_rows()) {
            return $result->result_array();
        } else {
            return $result->result();
        }
  }
  function supv_janani_other_data_report($args){
    $condition = '';
    $report_type=$args['report_type'];
    if ($args['from_date'] != '' && $args['to_date'] != '') {
        $from = $args['from_date'];
        $to = $args['to_date'];
      
    }
    if($report_type=="total"){
        $condition .= "";
    }else{
        $condition .= "  AND epcr.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
    }
    if ($args['sys_type'] != '') {
        $condition .= " AND amb.amb_user_type  = '" . $args['sys_type'] . "'";
    }
    $condition .= " AND inc.inc_type NOT IN ('DROP_BACK','IN_HO_P_TR','PICK_UP')"; 
    $condition .= " AND epcr.provider_impressions NOT IN ('21','41','42','44','52','53')";

    $sql =  "SELECT count(epcr.inc_ref_id) as total_count"
        . " FROM ems_epcr as epcr "
        . " LEFT JOIN ems_incidence as inc ON  epcr.inc_ref_id = inc.inc_ref_id"
        . " LEFT JOIN ems_ambulance as amb ON  epcr.amb_reg_id = amb.amb_rto_register_no"
        . " LEFT JOIN ems_mas_provider_imp as pro_imm ON pro_imm.pro_id =  epcr.provider_impressions"
        . " where  epcr.epcris_deleted = '0'  AND is_validate ='1' $condition ";
    // echo $sql;die();
    $result = $this->db->query($sql);
    if ($result->num_rows()) {
        return $result->result_array();
    } else {
        return $result->result();
    }
  }
  function supv_drop108_data_report($args){
    $condition = '';
    $report_type=$args['report_type'];
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            
        }
        if($report_type=="total"){
            $condition .= "";
        }else{
            $condition .= "  AND epcr.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['sys_type'] != '') {
            $condition .= " AND amb.amb_user_type  = '" . $args['sys_type'] . "'";
        }
        $condition .= " AND inc.inc_type IN ('DROP_BACK')"; 
        $condition .= " AND epcr.provider_impressions NOT IN ('21','41','42','44','52','53')";

        $sql =  "SELECT count(epcr.inc_ref_id) as total_count"
            . " FROM ems_epcr as epcr "
            . " LEFT JOIN ems_incidence as inc ON  epcr.inc_ref_id = inc.inc_ref_id"
            . " LEFT JOIN ems_ambulance as amb ON  epcr.amb_reg_id = amb.amb_rto_register_no"
            . " LEFT JOIN ems_mas_provider_imp as pro_imm ON pro_imm.pro_id =  epcr.provider_impressions"
            . " where  epcr.epcris_deleted = '0'  AND is_validate ='1' $condition ";
        // echo $sql;die();
        $result = $this->db->query($sql);
        if ($result->num_rows()) {
            return $result->result_array();
        } else {
            return $result->result();
        }
  }
  function supv_IFT_data_report($args){
    $condition = '';
    $report_type=$args['report_type'];
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            
        }
        if($report_type=="total"){
            $condition .= "";
        }else{
            $condition .= "  AND epcr.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['sys_type'] != '') {
            $condition .= " AND amb.amb_user_type  = '" . $args['sys_type'] . "'";
        }
        $condition .= " AND inc.inc_type IN ('IN_HO_P_TR')"; 
        $condition .= " AND epcr.provider_impressions NOT IN ('21','41','42','44','52','53')";

        $sql =  "SELECT count(epcr.inc_ref_id) as total_count"
            . " FROM ems_epcr as epcr "
            . " LEFT JOIN ems_incidence as inc ON  epcr.inc_ref_id = inc.inc_ref_id"
            . " LEFT JOIN ems_ambulance as amb ON  epcr.amb_reg_id = amb.amb_rto_register_no"
            . " LEFT JOIN ems_mas_provider_imp as pro_imm ON pro_imm.pro_id =  epcr.provider_impressions"
            . " where  epcr.epcris_deleted = '0'  AND is_validate ='1' $condition ";
        // echo $sql;die();
        $result = $this->db->query($sql);
        if ($result->num_rows()) {
            return $result->result_array();
        } else {
            return $result->result();
        }
  }
  function supv_Janani_data_report_pickup($args){
    $condition = '';
    $report_type=$args['report_type'];
    if ($args['from_date'] != '' && $args['to_date'] != '') {
        $from = $args['from_date'];
        $to = $args['to_date'];
        
    }
    if($report_type=="total"){
        $condition .= "";
    }else{
        $condition .= "  AND epcr.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
    }
    if ($args['sys_type'] != '') {
        $condition .= " AND amb.amb_user_type  = '" . $args['sys_type'] . "'";
    }
    $condition .= " AND inc.inc_type IN ('PICK_UP')"; 
    $condition .= " AND epcr.provider_impressions NOT IN ('21','41','42','44','52','53')";

    $sql =  "SELECT epcr.provider_impressions,pro_imm.pro_name,count(epcr.inc_ref_id) as total_count"
        . " FROM ems_epcr as epcr "
        . " LEFT JOIN ems_incidence as inc ON  epcr.inc_ref_id = inc.inc_ref_id"
        . " LEFT JOIN ems_ambulance as amb ON  epcr.amb_reg_id = amb.amb_rto_register_no"
        . " LEFT JOIN ems_mas_provider_imp as pro_imm ON pro_imm.pro_id =  epcr.provider_impressions"
        . " where  epcr.epcris_deleted = '0'  AND is_validate ='1' $condition GROUP By epcr.provider_impressions ";
    //echo $sql;die();
    $result = $this->db->query($sql);
    if ($result->num_rows()) {
        return $result->result_array();
    } else {
        return $result->result();
    }
}
  function supv_Janani_data_report_drop($args){
        $condition = '';
        $report_type=$args['report_type'];
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
           
        }
        if($report_type=="total"){
            $condition .= "";
        }else{
            $condition .= "  AND epcr.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['sys_type'] != '') {
            $condition .= " AND amb.amb_user_type  = '" . $args['sys_type'] . "'";
        }
        $condition .= " AND inc.inc_type IN ('DROP_BACK')"; 
        $condition .= " AND epcr.provider_impressions NOT IN ('21','41','42','44','52','53')";

        $sql =  "SELECT epcr.provider_impressions,pro_imm.pro_name,count(epcr.inc_ref_id) as total_count"
            . " FROM ems_epcr as epcr "
            . " LEFT JOIN ems_incidence as inc ON  epcr.inc_ref_id = inc.inc_ref_id"
            . " LEFT JOIN ems_ambulance as amb ON  epcr.amb_reg_id = amb.amb_rto_register_no"
            . " LEFT JOIN ems_mas_provider_imp as pro_imm ON pro_imm.pro_id =  epcr.provider_impressions"
            . " where  epcr.epcris_deleted = '0'  AND is_validate ='1' $condition GROUP By epcr.provider_impressions";
        // echo $sql;die();
        $result = $this->db->query($sql);
        if ($result->num_rows()) {
            return $result->result_array();
            //return $result->num_rows();
        } else {
            return $result->result();
        }
  }
}