<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Supervisory_Dispatch_model extends CI_Model {
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

    function get_total_dispatch($args = array()){
        // $date=$args['to_date'];
        $system_type=$args['system_type'];
        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        $condition="";
        $where =" AND inc.inc_set_amb = '1'";
        if($report_type=="total"){
          
        }else{
        $condition .= "AND inc.inc_datetime BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'";
        // $condition .= "Where inc.inc_datetime BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'";
        }
        // $condition="Where (inc.inc_datetime LIKE '%$from_date%')";
        if($args['system_type'] != ''){
            $system = implode("','",$args['system_type']);
            $condition .= " AND inc.inc_system_type IN ('".$system."')";
            
        } 
        $sql="select inc.inc_id FROM `ems_incidence` as inc  where inc.incis_deleted IN  ('0') $where $condition";
        // $sql="select incamb.inc_ref_id FROM `ems_incidence_ambulance` as incamb LEFT JOIN ems_incidence as inc ON incamb.inc_ref_id = inc.inc_ref_id LEFT JOIN ems_ambulance as amb ON incamb.amb_rto_register_no = amb.amb_rto_register_no $condition";
        
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
    
        function get_total_start_frm_base($args = array()){
            $report_type=$args['report_type'];
            $to_date = $args['to_date'];
            $from_date =$args['from_date'];
            $condition="";
            if($report_type=="total"){

            }else{
            $condition .= "AND start_from_base_loc BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'";
            }
            // $condition="AND (start_from_base_loc LIKE '%$from_date%')";
        $sql="select incident_id from ems_driver_parameters where parameter_count = '3' $condition ";
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
    function get_total_at_scene($args = array()){
        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        $condition="";
        if($report_type=="total"){

        }else{
        $condition .= "AND at_scene BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'";
        }
        // $condition="AND (at_scene  LIKE '%$from_date%')";
        $sql="select incident_id from ems_driver_parameters where parameter_count = '4' $condition";
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
    function get_total_at_destination($args = array()){
        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        $condition="";
        if($report_type=="total"){

        }else{
        $condition .= "AND at_hospital BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'";
        }
        // $condition="AND (at_hospital  LIKE '%$from_date%')";
        $sql="select incident_id from ems_driver_parameters where parameter_count = '6'  $condition";
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
    function get_total_back_to_base($args = array()){
        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        $condition="";
        if($report_type=="total"){

        }else{
        $condition .= "AND back_to_base_loc BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'";
        }
        // $condition="AND (back_to_base_loc  LIKE '%$from_date%')";
        $sql="select incident_id from ems_driver_parameters where parameter_count = '8'  $condition";
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }

    function get_total_pending_closure($args = array()){
        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        $condition="";
        if($report_type=="total"){

        }else{
        $condition .= "AND inc_datetime BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'";
        }
        // $condition="AND (back_to_base_loc  LIKE '%$from_date%')"; 
        $sql="select inc_ref_id from ems_incidence  where (inc_pcr_status = '0' OR inc_pcr_status IS null) AND incis_deleted = '0' AND inc_set_amb = '1'$condition" ;
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
    
    function get_total_pending_validation($args = array()){
        $report_type=$args['report_type'];
        $to_date = $args['to_date'];
        $from_date =$args['from_date'];
        $condition="";
        if($report_type=="total"){

        }else{
        $condition .= "AND inc.inc_datetime BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'";
        }
        // $condition="AND (back_to_base_loc  LIKE '%$from_date%')";
        $sql="select epcr.inc_ref_id from ems_epcr as epcr LEFT JOIN ems_incidence as inc ON (epcr.inc_ref_id=inc.inc_ref_id) WHERE inc.inc_pcr_status='1' AND epcr.epcris_deleted='0' AND inc_duplicate='no' AND incis_deleted='0' AND epcr.is_validate='0' AND operate_by NOT LIKE '%DCO%' $condition";
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
 
   
}