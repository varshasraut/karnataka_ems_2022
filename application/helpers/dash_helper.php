<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('accident_motorcycle'))
{
    function accident_motorcycle($inc_complaint, $param)
    {
        $ci =& get_instance();
        $ci->load->database();

        if (!empty($param)) {
        	$where = '';
        	if ($param == 'thismonth') {
        		$where='AND MONTH(STR_TO_DATE(`date`,"%m/%d/%Y")) = MONTH(CURRENT_DATE()) AND YEAR(STR_TO_DATE(`date`,"%m/%d/%Y")) = YEAR(CURRENT_DATE())';
        	} else if ($param == 'today') {
        		$where='AND STR_TO_DATE(`date`,"%m/%d/%Y") = CURRENT_DATE()';
        	}
        }
        $sql='SELECT i.inc_ref_id, d.inc_ref_id FROM ems_incidence AS i RIGHT JOIN ems_epcr AS d on i.inc_ref_id =d.inc_ref_id where d.epcris_deleted = "0" AND i.inc_complaint IN ('.$inc_complaint.') '.$where.' ';
        $query = $ci->db->query($sql);
        //echo $ci->db->last_query();
        //exit();
         if($query->num_rows() > 0){
           $result = $query->num_rows();
       //print_r($result);
       //die();
           	return $result;
           
       }else{
           return 0;
       }

    }   
}

if ( ! function_exists('current_login_agents_call_count'))
{
    function current_login_agents_call_count($clg_group, $clg_ref_id, $param)
    {
        $ci =& get_instance();
        $ci->load->database();
       // var_dump($clg_group);
      if($clg_group == "UG-ERO" || $clg_group == "UG-ERO-102")
      {
        if (!empty($param)) {
        	$where = '';
        	if ($param == 'eme') {
        		$where="AND inc_type IN ('NON_MCI','AD_SUP_REQ','DROP_BACK','IN_HO_P_TR','MCI','EMT_MED_AD','PREGANCY_CALL','VIP_CALL','Child_CARE_CALL','on_scene_care','PICK_UP')";
        	} else if ($param == 'non') {
        		$where="AND inc_type IN ('ABUSED_CALL','APP_CALL','AMB_NOT_AVA','CHILD_CALL','DEMO_CALL','DISS_CON_CALL','DUP_CALL','AMB_TO_ERC','ENQ_CALL','ESCALATION_CALL','FOLL_CALL','GEN_ENQ','MISS_CALL','NO_RES_CALL','NUS_CALL','SERVICE_NOT_REQUIRED','SLI_CALL','SUGG_CALL','TEST_CALL','UNATT_CALL','WRONG_CALL','CALL_TRANS_102','TRANS_FDA','TRANS_PDA','PRO_REP_SER','CORONA','CORONA_GENERAL_ENQUIRY_AD','CORONA_GENERAL_ENQUIRY')";
        	} else if ($param == 'all') {
        		$where="";
        	}
        }
        $sql='SELECT * FROM ems_incidence where incis_deleted IN ("0","2") AND inc_added_by ="'.$clg_ref_id.'" '.$where.' AND DATE(inc_datetime)=current_date ';
      }else if($clg_group == "UG-Feedback"){
      if (!empty($param)) {
        $where = '';
        if ($param == 'eme') {
          $where="";
        } else if ($param == 'non') {
          $where="";
        } else if ($param == 'all') {
          $where="";
        }
      }
      $sql='SELECT * FROM ems_feedback_call_details where fc_is_deleted = "1" AND fc_added_by ="'.$clg_ref_id.'" '.$where.' AND DATE(fc_added_date)=current_date ';
    }else if($clg_group == "UG-PDA"){
      if (!empty($param)) {
        $where = '';
        if ($param == 'eme') {
          $where="";
        } else if ($param == 'non') {
          $where="";
        } else if ($param == 'all') {
          $where="";
        }
      }
      $sql='SELECT * FROM ems_police_station_calls_details where pc_is_deleted = "1" AND pc_added_by ="'.$clg_ref_id.'" '.$where.' AND DATE(pc_added_date)=current_date ';
    }else if($clg_group == "UG-FDA"){
      if (!empty($param)) {
        $where = '';
        if ($param == 'eme') {
          $where="";
        } else if ($param == 'non') {
          $where="";
        } else if ($param == 'all') {
          $where="";
        }
      }
      $sql='SELECT * FROM ems_fire_station_calls_details where fc_is_deleted = "1" AND fc_added_by ="'.$clg_ref_id.'" '.$where.' AND DATE(fc_added_date)=current_date ';
    }else if($clg_group == "UG-ERCP"){
      if (!empty($param)) {
        $where = '';
        if ($param == 'eme') {
          $where="";
        } else if ($param == 'non') {
          $where="";
        } else if ($param == 'all') {
          $where="";
        }
      }
      $sql='SELECT * FROM ems_inc_add_advice where adv_clis_deleted = "0" AND adv_cl_added_by ="'.$clg_ref_id.'" '.$where.' AND DATE(adv_cl_date)=current_date ';
    }else if($clg_group == "UG-Grievance"){
      if (!empty($param)) {
        $where = '';
        if ($param == 'eme') {
          $where="";
        } else if ($param == 'non') {
          $where="";
        } else if ($param == 'all') {
          $where="";
        }
      }
      $sql='SELECT * FROM ems_grievance_call_details where gc_is_deleted = "0" AND gc_added_by ="'.$clg_ref_id.'" '.$where.' AND DATE(gc_added_date)=current_date ';
    }else if($clg_group == "UG-DCO" || $clg_group == "UG-DCO-102"){
      if (!empty($param)) {
        $where = '';
        if($param == 'JC_ON_SCENE_CARE'){
          $where="AND operate_by ='$clg_ref_id' AND epcr_call_type IN ('3')";
        }else if ($param == 'JC') {
          $where="AND operate_by ='$clg_ref_id' AND epcr_call_type NOT IN ('3')";
        } 
        else if ($param == 'validation_count') {
          $where="AND is_validate ='1' AND validate_by ='$clg_ref_id'";
          //echo $where;
        }else if ($param == 'Total_closure_inc') {
          $where="AND operate_by ='$clg_ref_id'";
          $group ="GROUP BY inc_ref_id";
        }else if ($param == 'total_validation_inc') {
          $where="AND is_validate ='1' AND validate_by ='$clg_ref_id'";
          $group ="GROUP BY inc_ref_id";
          //echo $where;
        } 
      }
      $sql='SELECT * FROM ems_epcr where epcris_deleted = "0"  '.$where.' AND DATE(STR_TO_DATE(`date`,"%m/%d/%Y")) = CURRENT_DATE '.$group.' ';
      //echo $sql;
     // die();
    }

  
    if($sql != ''){
        $query = $ci->db->query($sql);

         if($query->num_rows() > 0){
           $result = $query->num_rows();
           	return $result;           
       }else{
           return 0;
       }
      }

    }  
    
  }


if ( ! function_exists('mci_incidence'))
{
    function mci_incidence($inc_mci_nature, $param)
    {
        $ci =& get_instance();
        $ci->load->database();

        if (!empty($param)) {
        	$where = '';
        	if ($param == 'thismonth') {
        		$where=' AND MONTH(inc_datetime) = MONTH(CURRENT_DATE()) AND YEAR(inc_datetime) = YEAR(CURRENT_DATE())  ';
        	} else if ($param == 'today') {
        		$where=' AND DATE(inc_datetime) = CURDATE()';
        	}
        }
        $sql='SELECT * FROM ems_incidence WHERE incis_deleted = "0" AND `inc_mci_nature` ='.$inc_mci_nature.' '.$where.' ';
        $query = $ci->db->query($sql);
        //echo $ci->db->last_query();
        //exit();
         if($query->num_rows() > 0){
           $result = $query->num_rows();
       //print_r($result);
       //die();
           	return $result;
           
       }else{
           return 0;
       }

    }   
}

if( ! function_exists('live_calls')){
	function live_calls($param){
		$ci =& get_instance();
        $ci->load->database();
        if (!empty($param)) {
        	$where = '';
        	if ($param == 'thismonth') {
        		$where=' AND MONTH(inc_datetime) = MONTH(CURRENT_DATE()) AND YEAR(inc_datetime) = YEAR(CURRENT_DATE())  ';
        	} else if ($param == 'today') {
        		$where=' AND DATE(inc_datetime) = CURDATE()';
        	}
        }
        $sql='SELECT * FROM ems_incidence WHERE incis_deleted = "0" AND inc_type IN ("MCI","NON_MCI","IN_HO_P_TR","AD_SUP_REQ","VIP_CALL")'.$where.' ';
        $query = $ci->db->query($sql);
        //echo $ci->db->last_query();
        //exit();
    	if($query->num_rows() > 0){
           $result = $query->num_rows();
    		return $result;
           
       }else{
           return 0;
       }
    }
}

if ( ! function_exists('districtwise_emergency_patients'))
{
    function districtwise_emergency_patients($dst_code, $param, $system)
    {
        $ci =& get_instance();
        $ci->load->database();
        if ($system == "both") {
          $sys = "";
        }elseif($system == "108"){
          $sys = "AND d.system_type  IN ('108')";
        }elseif($system == "102"){
          $sys = "AND d.system_type IN ('102')";
        }else{
          $sys = "";
        }
        if (!empty($param)) {
          $where = '';
          if ($param == 'thismonth') {
            $where='AND MONTH(STR_TO_DATE(`date`,"%m/%d/%Y")) = MONTH(CURRENT_DATE()) AND YEAR(STR_TO_DATE(`date`,"%m/%d/%Y")) = YEAR(CURRENT_DATE())';
          } else if ($param == 'today') {
            $where='AND STR_TO_DATE(`date`,"%m/%d/%Y") = CURRENT_DATE()';
          } else if ($param == 'tillDate') {
            $where='';
          }
        }
        $sql='SELECT  d.inc_ref_id FROM  ems_epcr AS d  where 1=1 '.$sys.' AND d.epcris_deleted = "0" AND d.district_id ='.$dst_code.' '.$where.' ';
        $query = $ci->db->query($sql);
     //  echo $ci->db->last_query(); die;
         if($query->num_rows() == 0){
          return 0; 
          }else{
            $result = $query->num_rows();
            return $result;
          }

    }   
}
if ( ! function_exists('ambwise_emergency_patients'))
{
    function ambwise_emergency_patients($amb, $param, $system)
    {
        $ci =& get_instance();
        $ci->load->database();
        if ($system == "both") {
          $sys = "";
        }elseif($system == "108"){
          $sys = "AND i.inc_system_type IN ('108')";
        }elseif($system == "102"){
          $sys = "AND i.inc_system_type IN ('102')";
        }else{
          $sys = "";
        }
        if (!empty($param)) {
          $where = '';
          if ($param == 'thismonth') {
            $closure_complete = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") - 1, date("Y")));
            $start_date_month =  date('Y-m-01');
            $where = "  AND d.inc_datetime BETWEEN '$start_date_month 00:00:00' AND '$closure_complete 23:59:59'";
            $cond = ' AND d.is_validate ="1" ';
            //$where='AND MONTH(STR_TO_DATE(`date`,"%m/%d/%Y")) = MONTH(CURRENT_DATE()) AND YEAR(STR_TO_DATE(`date`,"%m/%d/%Y")) = YEAR(CURRENT_DATE())';
          } else if ($param == 'today') {
            $current_date = date('Y-m-d');
            $from = date('Y-m-d', strtotime($current_date));
            $to = date('Y-m-d', strtotime($current_date));
            $where = "  AND d.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
            $cond = ' AND d.is_validate ="1" ';
            //$where='AND STR_TO_DATE(`date`,"%m/%d/%Y") = CURRENT_DATE()';
          } else if ($param == 'tillDate') {
            $closure_complete = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") - 1, date("Y")));
            $start_date_month =  date('2022-03-01');
            $where = "  AND d.inc_datetime BETWEEN '$start_date_month 00:00:00' AND '$closure_complete 23:59:59'";
            $cond = ' AND d.is_validate ="1" ';
            //$where='';
          }else if ($param == 'tillDate_old1') {
            $closure_complete = date('2022-02-28');
            $start_date_month =  date('2021-07-01');
            $where = "  AND d.inc_datetime BETWEEN '$start_date_month 00:00:00' AND '$closure_complete 23:59:59'";
            //$where='';
          }
        }
        $pro_id=" AND provider_impressions IN ('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','45','46','47','48','49','50','51','52','53','54','55','56','57','58')";
        $sql='SELECT i.inc_ref_id, d.inc_ref_id FROM ems_incidence AS i RIGHT JOIN ems_epcr AS d on i.inc_ref_id =d.inc_ref_id where 1=1 '.$sys.' AND d.epcris_deleted = "0" '.$pro_id.' '.$cond.' AND d.amb_reg_id ="' .$amb.'" '.$where.' ';
        $query = $ci->db->query($sql);
     //echo $ci->db->last_query(); die;
         if($query->num_rows() == 0){
          return 0; 
          }else{
            $result = $query->num_rows();
            return $result;
          }

    }   
}

if ( ! function_exists('emergency_patients'))
{
    function emergency_patients( $param, $system)
    {
        $ci =& get_instance();
        $ci->load->database();
        if ($system == "both") {
          $sys = "";
        }elseif($system == "108"){
          $sys = "AND i.inc_system_type IN ('108')";
        }elseif($system == "102"){
          $sys = "AND i.inc_system_type IN ('102')";
        }else{
          $sys = "";
        }
        if (!empty($param)) {
          $where = '';
          if ($param == 'thismonth') {
            $where='AND MONTH(STR_TO_DATE(`date`,"%m/%d/%Y")) = MONTH(CURRENT_DATE()) AND YEAR(STR_TO_DATE(`date`,"%m/%d/%Y")) = YEAR(CURRENT_DATE())';
          } else if ($param == 'today') {
            $where='AND STR_TO_DATE(`date`,"%m/%d/%Y") = CURRENT_DATE()';
          } else if ($param == 'tillDate') {
            $where='';
          }
        }
        $sql='SELECT i.inc_ref_id, d.inc_ref_id FROM ems_incidence AS i RIGHT JOIN ems_epcr AS d on i.inc_ref_id =d.inc_ref_id where 1=1 '.$sys.' AND d.epcris_deleted = "0" '.$where.' ';
        $query = $ci->db->query($sql);
      // echo $ci->db->last_query(); die;
         if($query->num_rows() == 0){
          return 0; 
          }else{
            $result = $query->num_rows();
            return $result;
          }

    }   
}
//if ( ! function_exists('districtwise_emergency_patients_served'))
//{
//    function districtwise_emergency_patients_served($dst_code, $param, $system,$closure_date)
//    {
//        $ci =& get_instance();
//        $ci->load->database();
//        if ($system == "both") {
//          $sys = "";
//        }elseif($system == "108"){
//          $sys = "AND d.system_type  IN ('108')";
//        }elseif($system == "102"){
//          $sys = "AND d.system_type IN ('102')";
//        }else{
//          $sys = "";
//        }
//        if (!empty($param)) {
//          $where = '';
//          if ($param == 'thismonth') {
//            //$where='AND MONTH(STR_TO_DATE(`date`,"%m/%d/%Y")) = MONTH(CURRENT_DATE()) AND YEAR(STR_TO_DATE(`date`,"%m/%d/%Y")) = YEAR(CURRENT_DATE())';
//            $from   = date('01/m/Y');
//            $to = date('d/m/Y', strtotime($closure_date));
//            //$to = date('Y-m-t', strtotime($from));
//            $where = "  AND d.date BETWEEN '$from' AND '$to'";
//          } else if ($param == 'today') {
//            //$where='AND STR_TO_DATE(`date`,"%m/%d/%Y") = CURRENT_DATE()';
//            $to   =   date('d/m/Y');
//            $from = date('d/m/Y');
//            $where = "  AND d.date BETWEEN '$from' AND '$to'";
//            
//          } else if ($param == 'tillDate') {
//            //$to   =   date('Y-m-d');
//            $to = date('d/m/Y', strtotime($closure_date));
//            $where = "  AND d.date BETWEEN '01/07/2021' AND '$to'";
//          }
//        }
//        if($dst_code != ''){
//            $dst = " AND d.district_id ='$dst_code'";
//        }
//        $sql='SELECT d.inc_ref_id FROM  ems_epcr AS d  where 1=1 '.$sys.' AND d.epcris_deleted = "0" AND provider_impressions  NOT IN ("21","41","42","43","44") '.$dst.' '.$where.' ';
//        
//       // $sql='SELECT d.inc_ref_id FROM  ems_epcr AS d  where 1=1 '.$sys.' '.$dst.' '.$where.' ';
//        $query = $ci->db->query($sql);
//      // echo $ci->db->last_query();
//      // die;
//         if($query->num_rows() == 0){
//          return 0; 
//          }else{
//            $result = $query->num_rows();
//            return $result;
//          }
//
//    }   
//}
if ( ! function_exists('districtwise_emergency_patients_served'))
{
    function districtwise_emergency_patients_served($dst_code, $param, $system,$closure_date)
    {
     
        $ci =& get_instance();
        $ci->load->database();
        if ($system == "both") {
          $sys = "";
        }elseif($system == "108"){
          $sys = "AND d.system_type  IN ('108')";
        }elseif($system == "102"){
          $sys = "AND d.system_type IN ('102')";
        }else{
          $sys = "";
        }
        if (!empty($param)) {
          $where = '';
          if ($param == 'thismonth') {
            $closure_complete = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") - 1, date("Y")));
            $start_date_month =  date('Y-m-01');
            $where = "  AND d.inc_datetime BETWEEN '$start_date_month 00:00:00' AND '$closure_complete 23:59:59'";
            $cond = ' AND d.is_validate ="1" ';
            //$where='AND MONTH(STR_TO_DATE(`date`,"%m/%d/%Y")) = MONTH(CURRENT_DATE()) AND YEAR(STR_TO_DATE(`date`,"%m/%d/%Y")) = YEAR(CURRENT_DATE())';
          } else if ($param == 'today') {
            $current_date = date('Y-m-d');
            $from = date('Y-m-d', strtotime($current_date));
            $to = date('Y-m-d', strtotime($current_date));
            $where = "  AND d.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
            $cond = ' AND d.is_validate ="1" ';
            //$where='AND STR_TO_DATE(`date`,"%m/%d/%Y") = CURRENT_DATE()';
          } else if ($param == 'tillDate') {
            $closure_complete = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") - 1, date("Y")));
            $start_date_month =  date('2022-03-01');
            $where = "  AND d.inc_datetime BETWEEN '$start_date_month 00:00:00' AND '$closure_complete 23:59:59'";
            //$where='';
            $cond = ' AND d.is_validate ="1" ';
          }
          else if ($param == 'tillDate_old1') {
            $closure_complete = date('2022-02-28');
            $start_date_month =  date('2021-07-01');
            $where = "  AND d.inc_datetime BETWEEN '$start_date_month 00:00:00' AND '$closure_complete 23:59:59'";
            //$where='';
            //$cond = ' AND d.is_validate ="1" ';
          }
        }
        if($dst_code != ''){
            $dst = " AND d.district_id ='$dst_code'";
        }
        //$sql='SELECT d.inc_ref_id FROM  ems_epcr AS d  where 1=1 AND d.epcris_deleted = "0" AND provider_impressions  NOT IN ("21","41","42","43","44") '.$cond.' '.$sys.' '.$dst.' '.$where.' ';
        $sql='SELECT d.inc_ref_id FROM  ems_epcr AS d  where 1=1 AND d.epcris_deleted = "0" AND provider_impressions IN ("1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","45","46","47","48","49","50","51","52","53","54","55","56","57","58") '.$cond.' '.$sys.' '.$dst.' '.$where.' ';
        $query = $ci->db->query($sql);
        if($query->num_rows() == 0){
          return 0; 
        }else{
            $result = $query->num_rows();
            return $result;
        }
    }   
}
if ( ! function_exists('emergency_patients_divisionwise_jammu'))
{
    function emergency_patients_divisionwise_jammu( $param, $system)
    {
        $ci =& get_instance();
        $ci->load->database();
        if ($system == "both") {
          $sys = "";
        }elseif($system == "108"){
          $sys = "AND i.inc_system_type IN ('108')";
        }elseif($system == "102"){
          $sys = "AND i.inc_system_type IN ('102')";
        }else{
          $sys = "";
        }
        if (!empty($param)) {
          $where = '';
          if ($param == 'thismonth') {
            $where='AND MONTH(STR_TO_DATE(`date`,"%m/%d/%Y")) = MONTH(CURRENT_DATE()) AND YEAR(STR_TO_DATE(`date`,"%m/%d/%Y")) = YEAR(CURRENT_DATE())';
          } else if ($param == 'today') {
            $where='AND STR_TO_DATE(`date`,"%m/%d/%Y") = CURRENT_DATE()';
          } else if ($param == 'tillDate') {
            $where='';
          }
        }
        $sql='SELECT i.inc_ref_id, d.inc_ref_id FROM ems_incidence AS i RIGHT JOIN ems_epcr AS d on i.inc_ref_id =d.inc_ref_id RIGHT JOIN ems_mas_districts AS dist on d.district_id =dist.dst_code where 1=1 '.$sys.' AND d.epcris_deleted = "0" AND dist.div_code = "1"'.$where.' ';
        $query = $ci->db->query($sql);
      //echo $ci->db->last_query(); die;
         if($query->num_rows() == 0){
          return 0; 
          }else{
            $result = $query->num_rows();
            return $result;
          }

    }   
}

if ( ! function_exists('emergency_patients_divisionwise_kashmir'))
{
    function emergency_patients_divisionwise_kashmir( $param, $system)
    {
        $ci =& get_instance();
        $ci->load->database();
        if ($system == "both") {
          $sys = "";
        }elseif($system == "108"){
          $sys = "AND i.inc_system_type IN ('108')";
        }elseif($system == "102"){
          $sys = "AND i.inc_system_type IN ('102')";
        }else{
          $sys = "";
        }
        if (!empty($param)) {
          $where = '';
          if ($param == 'thismonth') {
            $where='AND MONTH(STR_TO_DATE(`date`,"%m/%d/%Y")) = MONTH(CURRENT_DATE()) AND YEAR(STR_TO_DATE(`date`,"%m/%d/%Y")) = YEAR(CURRENT_DATE())';
          } else if ($param == 'today') {
            $where='AND STR_TO_DATE(`date`,"%m/%d/%Y") = CURRENT_DATE()';
          } else if ($param == 'tillDate') {
            $where='';
          }
        }
        $sql='SELECT i.inc_ref_id, d.inc_ref_id FROM ems_incidence AS i RIGHT JOIN ems_epcr AS d on i.inc_ref_id =d.inc_ref_id RIGHT JOIN ems_mas_districts AS dist on d.district_id =dist.dst_code where 1=1 '.$sys.' AND d.epcris_deleted = "0" AND dist.div_code = "2"'.$where.' ';
        $query = $ci->db->query($sql);
      //echo $ci->db->last_query(); die;
         if($query->num_rows() == 0){
          return 0; 
          }else{
            $result = $query->num_rows();
            return $result;
          }

    }   
}

if ( ! function_exists('emergency_patients_divisionwise_leh'))
{
    function emergency_patients_divisionwise_leh( $param, $system)
    {
        $ci =& get_instance();
        $ci->load->database();
        if ($system == "both") {
          $sys = "";
        }elseif($system == "108"){
          $sys = "AND i.inc_system_type IN ('108')";
        }elseif($system == "102"){
          $sys = "AND i.inc_system_type IN ('102')";
        }else{
          $sys = "";
        }
        if (!empty($param)) {
          $where = '';
          if ($param == 'thismonth') {
            $where='AND MONTH(STR_TO_DATE(`date`,"%m/%d/%Y")) = MONTH(CURRENT_DATE()) AND YEAR(STR_TO_DATE(`date`,"%m/%d/%Y")) = YEAR(CURRENT_DATE())';
          } else if ($param == 'today') {
            $where='AND STR_TO_DATE(`date`,"%m/%d/%Y") = CURRENT_DATE()';
          } else if ($param == 'tillDate') {
            $where='';
          }
        }
        $sql='SELECT i.inc_ref_id, d.inc_ref_id FROM ems_incidence AS i RIGHT JOIN ems_epcr AS d on i.inc_ref_id =d.inc_ref_id RIGHT JOIN ems_mas_districts AS dist on d.district_id =dist.dst_code where 1=1 '.$sys.' AND d.epcris_deleted = "0" AND dist.div_code = "3"'.$where.' ';
        $query = $ci->db->query($sql);
      //echo $ci->db->last_query(); die;
         if($query->num_rows() == 0){
          return 0; 
          }else{
            $result = $query->num_rows();
            return $result;
          }

    }   
}

if ( ! function_exists('districtwise_dispatches'))
{
    function districtwise_dispatches($dst_code, $param, $system)
    {
        $ci =& get_instance();
        $ci->load->database();

        if ($system == "both") {
          $system = "('108','102')";
        }else{
          $system = "(".$system.")";
        }
        if (!empty($param)) {
          $where = '';
          if ($param == 'thismonth') {
            $where='AND MONTH(inc_datetime) = MONTH(CURRENT_DATE()) AND YEAR(inc_datetime) = YEAR(CURRENT_DATE())';
          } else if ($param == 'today') {
            $where='AND DATE(inc_datetime) = CURRENT_DATE()';
          } else if ($param == 'tillDate') {
            $where='AND DATE(inc_datetime) > "2020-03-23 23:23:59"';
          }
        }
        $sql='SELECT i.inc_ref_id FROM ems_incidence AS i where i.inc_system_type IN '.$system.' AND i.incis_deleted = "0" AND i.inc_district_id ='.$dst_code.' '.$where.' ';
        $query = $ci->db->query($sql);
        ///echo $ci->db->last_query(); die;
         if($query->num_rows() > 0){
           $result = $query->num_rows();
            return $result;
           
       }else{
           return 0;
       }

    }   
}

if ( ! function_exists('districtwise_ambulance_count'))
{
    function districtwise_ambulance_count($dst_code, $param)
    {
        $ci =& get_instance();
        $ci->load->database();

        if (!empty($param)) {
          $where = '';
          if ($param == 'ALS') {
            $where='AND amb_type=4';
          } else if ($param == 'BLS') {
            $where='AND amb_type=3';
          }else if($param == 'PTA'){
            $where='AND amb_type=2';
          }
        }
        $sql='SELECT * FROM `ems_ambulance` WHERE ambis_deleted="0" AND amb_district='.$dst_code.' '.$where.' ';
        $query = $ci->db->query($sql);
         if($query->num_rows() > 0){
           $result = $query->num_rows();
            return $result;
       }else{
           return 0;
       }
    }   
}

if ( ! function_exists('districtwise_ambulance_onoff_road'))
{
    function districtwise_ambulance_onoff_road($dst_code, $param)
    {
        $ci =& get_instance();
        $ci->load->database();

        if (!empty($param)) {
          $where = '';
          if ($param == 'onroad') {
            $where='AND amb_status IN (1,2,3,6)';
          } else if ($param == 'offroad') {
            $where='AND amb_status IN (4,5,7,8,9,10)';
          }
        }
        $sql='SELECT * FROM `ems_ambulance` WHERE ambis_deleted="0" AND amb_district='.$dst_code.' '.$where.' ';
        $query = $ci->db->query($sql);
         if($query->num_rows() > 0){
           $result = $query->num_rows();
            return $result;
       }else{
           return 0;
       }
    }   
}

if ( ! function_exists('districtwise_ambulance_km'))
{
    function districtwise_ambulance_km($dst_code, $param)
    {
        $ci =& get_instance();
        $ci->load->database();

        if (!empty($param)) {
          $where = '';
          if ($param == '15days') {
            $where='AND ambis_deleted="0" AND b.date BETWEEN  DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY),"%m/01/%Y") AND DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY),"%m/15/%Y")';
           // $where='AND date BETWEEN "08/01/2019" AND "08/15/2019"';//

          } else if ($param == 'thismonth') {
          $where='AND ambis_deleted="0" AND b.date BETWEEN  DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY),"%m/01/%Y") AND DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY),"%m/31/%Y")';
            // $where='AND date BETWEEN "08/01/2019" AND "08/30/2019"';//
          }else if ($param == 'tilldate') {
            $where='';
          }
        }
        $sql='SELECT SUM(total_km) as km FROM `ems_ambulance` a inner JOIN ems_epcr b ON a.amb_rto_register_no=b.amb_reg_id WHERE a.amb_district='.$dst_code.' '.$where.' ';
       
        $query = $ci->db->query($sql);
         if($query->num_rows() > 0){
           $result = $query->result_array();
           if($result[0]['km']>0){
            return $result[0]['km'];
          }else{return 0;}
       }else{
           return 0;
       }
    }   
}

if ( ! function_exists('districtwise_ambulance_108_km'))
{
    function districtwise_ambulance_108_km($dst_code, $param)
    {
        $ci =& get_instance();
        $ci->load->database();

        if (!empty($param)) {
          $where = '';
          if ($param == '15days') {
            $where='AND ambis_deleted="0" AND b.timestamp BETWEEN  DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY),"%m/01/%Y") AND DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY),"%m/15/%Y")';
           // $where='AND date BETWEEN "08/01/2019" AND "08/15/2019"';//

          } else if ($param == 'thismonth') {
         // $where='AND ambis_deleted="0" AND b.timestamp BETWEEN  DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY),"%m/01/%Y") AND DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY),"%m/31/%Y")';
            // $where='AND date BETWEEN "08/01/2019" AND "08/30/2019"';//
            $where='AND ambis_deleted="0" AND b.date BETWEEN  DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY),"%m/01/%Y") AND DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY),"%m/31/%Y")';

          }else if ($param == 'tilldate') {
            $where='AND b.date >"2020-03-23 23:59:59"';
          }
        }
        $sql='SELECT SUM(total_km) as km FROM `ems_ambulance` a  inner JOIN ems_epcr b ON a.amb_rto_register_no=b.amb_reg_id  WHERE b.system_type = "108" AND a.amb_district='.$dst_code.' '.$where.' ';
       
        $query = $ci->db->query($sql);
    // echo $ci->db->last_query();die;
         if($query->num_rows() > 0){
           $result = $query->result_array();
           if($result[0]['km']>0){
            return $result[0]['km'];
          }else{return 0;}
       }else{
           return 0;
       }
    }   
}

if ( ! function_exists('districtwise_ambulance_102_km'))
{
    function districtwise_ambulance_102_km($dst_code, $param)
    {
        $ci =& get_instance();
        $ci->load->database();

        if (!empty($param)) {
          $where = '';
          if ($param == '15days') {
            $where='AND ambis_deleted="0" AND b.timestamp BETWEEN  DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY),"%m/01/%Y") AND DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY),"%m/15/%Y")';
           // $where='AND date BETWEEN "08/01/2019" AND "08/15/2019"';//

          } else if ($param == 'thismonth') {
          // $where='AND ambis_deleted="0" AND b.timestamp BETWEEN  DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY),"%Y-%m-01 00:00:00") AND DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY),"%Y-%m-31 23:59:59")';
            // $where='AND date BETWEEN "08/01/2019" AND "08/30/2019"';//
            $where='AND ambis_deleted="0" AND b.date BETWEEN  DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY),"%m/01/%Y") AND DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY),"%m/31/%Y")';
           // $where=' AND ambis_deleted="0" AND MONTH(STR_TO_DATE(timestamp,"%Y-%m-%d")) = MONTH(CURRENT_DATE()) AND YEAR(STR_TO_DATE(timestamp,"%Y-%m-%d")) = YEAR(CURRENT_DATE())';

            
            

          }else if ($param == 'tillDate') {
            $where='AND b.date >="2020-03-23 23:59:59"';
          }
        }
        $sql='SELECT SUM(total_km) as km FROM `ems_ambulance` a inner JOIN ems_epcr b ON a.amb_rto_register_no=b.amb_reg_id WHERE b.system_type = "102" AND a.amb_district='.$dst_code.' '.$where.' ';
       
        $query = $ci->db->query($sql);
  //  echo $ci->db->last_query();die;
         if($query->num_rows() > 0){
           $result = $query->result_array();
           if($result[0]['km']>0){
            return $result[0]['km'];
          }else{return 0;}
       }else{
           return 0;
       }
    }   
}

if( ! function_exists('total_calls_eme_pat_served')){
  function total_calls_eme_pat_served($inc_complaint, $param){
    $ci =& get_instance();
        $ci->load->database();
        if (!empty($param)) {
          $where = '';
          if ($param == 'thismonth') {
            $where=' AND MONTH(inc_datetime) = MONTH(CURRENT_DATE()) AND YEAR(inc_datetime) = YEAR(CURRENT_DATE())  ';
          } else if ($param == 'today') {
            $where=' AND DATE(inc_datetime) = CURDATE()';
          }
        }
        $sql='SELECT p.ptn_id FROM `ems_incidence` i JOIN ems_incidence_patient p on i.inc_ref_id=p.inc_id WHERE i.inc_pcr_status="1" AND i.incis_deleted="0" AND i.inc_complaint IN ('.$inc_complaint.') '.$where.' ';
        $query = $ci->db->query($sql);
        //echo $ci->db->last_query();
        //exit();
      if($query->num_rows() > 0){
           $result = $query->num_rows();
        return $result;
           
       }else{
           return 0;
       }
    }
}

if ( ! function_exists('amb_resp_time_onroad'))
{
    function amb_resp_time_onroad($type)
    {
        $ci =& get_instance();
        $ci->load->database();

        // if (!empty($param)) {
        //   $where = '';
        //   if ($param == 'onroad') {
        //     $where='AND amb_status IN (1,2,3,6)';
        //   } else if ($param == 'offroad') {
        //     $where='AND amb_status IN (4,5,7,8,9,10)';
        //   }
        // }
        $sql='SELECT * FROM `ems_ambulance` WHERE ambis_deleted="0" AND amb_type='.$type.' ';
        $query = $ci->db->query($sql);
         if($query->num_rows() > 0){
           $result = $query->num_rows();
            return $result;
       }else{
           return 0;
       }
    }   
}

if ( ! function_exists('call_to_scene_time'))
{
    function call_to_scene_time($type,$working_area)
    {
        $ci =& get_instance();
        $ci->load->database();

         if (!empty($type)) {
           $where = '';
           if ($type == 3 && $working_area == 2) {
             $where='a.amb_type=3 AND a.amb_working_area=2';
           } else if ($type == 3 && $working_area == 1) {
             $where='a.amb_type=3 AND a.amb_working_area=1';
           }else if ($type == 4 && $working_area == 2) {
             $where='a.amb_type=3 AND a.amb_working_area=1';
           }else if ($type == 4 && $working_area == 1) {
             $where='a.amb_type=3 AND a.amb_working_area=1';
           }
         }

        $sql='SELECT dr.`dp_reach_on_scene`, dr.`dp_started_base_loc`, TRUNCATE(AVG(TIMESTAMPDIFF(MINUTE, dr.`dp_started_base_loc`,dr.`dp_reach_on_scene`)),2) AS avg from ems_ambulance a RIGHT JOIN ems_epcr ep ON a.amb_rto_register_no=ep.amb_reg_id RIGHT JOIN ems_driver_pcr dr ON dr.inc_ref_id=ep.inc_ref_id WHERE a.amb_type="'.$type.'" AND a.amb_working_area="'.$working_area.'"';
        

        $query = $ci->db->query($sql);
         if($query->num_rows() > 0){
           $result = $query->result_array();
            return ($result[0]['avg'] ? $result[0]['avg'] : 0);
       }else{
           return 0;
       }
    }   
}

if ( ! function_exists('call_to_hosp_time'))
{
    function call_to_hosp_time($type,$working_area)
    {
        $ci =& get_instance();
        $ci->load->database();

         if (!empty($type)) {
           $where = '';
        
            if ($type == 4 && $working_area == 2) {
             $where='a.amb_type=4 AND a.amb_working_area=2';
           } else if ($type == 4 && $working_area == 1) {
             $where='a.amb_type=4 AND a.amb_working_area=1';
           }else if ($type == 3 && $working_area == 2) {
             $where='a.amb_type=4 AND a.amb_working_area=1';
           }else if ($type == 3 && $working_area == 1) {
             $where='a.amb_type=4 AND a.amb_working_area=1';
           }
         }  
        $sql='SELECT dr.`dp_hosp_time`, dr.`dp_on_scene`, TRUNCATE(AVG(TIMESTAMPDIFF(MINUTE, dr.`dp_on_scene`,dr.`dp_hosp_time`)),2) AS avg from ems_ambulance a RIGHT JOIN ems_epcr ep ON a.amb_rto_register_no=ep.amb_reg_id RIGHT JOIN ems_driver_pcr dr ON dr.inc_ref_id=ep.inc_ref_id WHERE a.amb_type="'.$type.'" AND a.amb_working_area="'.$working_area.'"';
        $query = $ci->db->query($sql);
         if($query->num_rows() > 0){
           $result = $query->result_array();
            return ($result[0]['avg'] ? $result[0]['avg'] : 0);
       }else{
           return 0;
       }
    }   
}

if ( ! function_exists('amb_unavailability_percentage'))
{
    function amb_unavailability_percentage($type)
    {
        $ci =& get_instance();
        $ci->load->database();

        $sql='SELECT TRUNCATE(((COUNT( * ) / ( SELECT COUNT( * ) FROM ems_incidence)) * 100 ),2) AS percentage from ems_incidence i JOIN ems_epcr ep on i.inc_ref_id=ep.inc_ref_id JOIN ems_ambulance a ON ep.amb_reg_id=a.amb_rto_register_no WHERE termination_reason="Ambulance Unavability" AND amb_type='.$type.' ';
        $query = $ci->db->query($sql);
         if($query->num_rows()){
           $result = $query->result_array();
            return $result[0]['percentage'];
            //return 22;
       }else{
           return 0;
       }
    }   
}
    function districtwise_emergency_patients($dst_code, $param, $system){
        $ci =& get_instance();
        $ci->load->database();
        if ($system == "both") {
          $sys = "";
        }elseif($system == "108"){
          $sys = "AND d.system_type  IN ('108')";
        }elseif($system == "102"){
          $sys = "AND d.system_type IN ('102')";
        }else{
          $sys = "";
        }
        if (!empty($param)) {
          $where = '';
          if ($param == 'thismonth') {
            //$where='AND MONTH(STR_TO_DATE(`date`,"%m/%d/%Y")) = MONTH(CURRENT_DATE()) AND YEAR(STR_TO_DATE(`date`,"%m/%d/%Y")) = YEAR(CURRENT_DATE())';
            $from   = date('Y-m-01');
            $to = date('Y-m-t', strtotime($from));
            $where = "  AND d.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
          } else if ($param == 'today') {
            //$where='AND STR_TO_DATE(`date`,"%m/%d/%Y") = CURRENT_DATE()';
            $to   =   date('Y-m-d');
            $from = date('Y-m-d');
            $where = "  AND d.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
            
          } else if ($param == 'tillDate') {
            $to   =   date('Y-m-d');
            $where = "  AND d.inc_datetime BETWEEN '2020-03-23 23:59:59' AND '$to 23:59:59'";
          }
        }
        if($dst_code != ''){
            $dst = " AND d.district_id ='$dst_code'";
        }
        $sql='SELECT d.inc_ref_id FROM  ems_epcr AS d  where 1=1 '.$sys.' AND d.epcris_deleted = "0" AND provider_impressions  NOT IN ("21","42","43","44","52","53") '.$dst.' '.$where.' ';
        
        $sql='SELECT d.inc_ref_id FROM  ems_epcr AS d  where 1=1 '.$sys.' '.$dst.' '.$where.' ';
        $query = $ci->db->query($sql);
       //echo $ci->db->last_query();
       //die;
         if($query->num_rows() == 0){
          return 0; 
          }else{
            $result = $query->num_rows();
            return $result;
          }

    }   