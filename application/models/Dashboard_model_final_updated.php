<?php
class Dashboard_model_final_updated extends CI_Model {
    //*****Dashboard Data Update function*****
    public function get_total_call_count($args = array())
    {
        $condition='';
        if($args['from_date'] != '' && $args['To_date'] != '') {
            $from = $args['from_date'];
            $to = $args['To_date'];
            $condition .= "  AND inc.inc_datetime BETWEEN '$from' AND '$to'";
        }
        if($args['system_type'] != ''){
            $system = implode("','",$args['system_type']);
            $condition .= " AND inc.inc_system_type IN ('".$system."')";
            
        }
        $data=$this->db->query("select * from ems_incidence As inc where incis_deleted IN ('0') $condition");
        //echo $this->db->last_query()."<br>";die();
        if($data->num_rows()){
            return $data->num_rows();
        }else{
            return 0;
        }
    }
    public function get_total_resourse_count(){
        $condition='';
        
        $condition .= " AND clg.clg_user_type IN ('102','108')";
        $condition .= " AND clg.clg_group  NOT IN ('UG-EMT','UG-PILOT','UG-JAES-NHM-DASHBOARD','UG-JAES-DASHBOARD')";
        
        $data=$this->db->query("select * from ems_colleague As clg where clg.clg_is_deleted ='0' $condition");
       // echo $this->db->last_query()."<br>";die();
        if($data->num_rows()){
            return $data->num_rows();
        }else{
            return 0;
        }
    }
    public function get_amb_count($args = array()){
        $condition='';
        if($args['system_type'] != '' && $args['system_type'] != 'all' ){
            $system = implode("','",$args['system_type']);
            $condition .= " AND amb_user_type IN ('".$system."')";
         }
        if($args['status'] != '' && $args['status'] != 'all'){
      
            $condition .= " AND amb_status IN (".$args['status']." )";
            
        }
        
        $data=$this->db->query("select  amb_rto_register_no  from ems_ambulance where ambis_deleted='0' AND amb_status != '11' $condition ");
        //echo $this->db->last_query()."<br>";
        //die();
        if($data->num_rows()){
            return $data->num_rows();
        }else{
            return 0;
        }
    }
    public function get_amb_count_typewise($args = array()){
        $condition='';
        if($args['system_type'] != '' && $args['system_type'] != 'all' ){
            $system = implode("','",$args['system_type']);
            $condition .= " AND amb_user_type IN ('".$system."')";
         }
        if($args['type'] != '' ){
      
            $condition .= " AND amb_type = ".$args['type']." ";
        }
       if($args['amb_status'] != ''){
            $amb_status = implode("','",$args['amb_status']);
            $condition .= " AND amb_status IN ('".$amb_status."')";
         }
        
        $data=$this->db->query("select  amb_rto_register_no  from ems_ambulance where ambis_deleted='0' $condition ");
        //echo $this->db->last_query()."<br>";
        //die();
        if($data->num_rows()){
            return $data->num_rows();
        }else{
            return 0;
        }
    }
    public function get_ero_login_count($args = array()){
        $condition='';
        if($args['from_date'] != '' && $args['To_date'] != '') {
            $from = $args['from_date'];
            $to = $args['To_date'];
            $condition .= "  AND clg_log_ero.added_date BETWEEN '$from' AND '$to'";
        }
        if($args['system_type'] != ''){
            $system = implode("','",$args['system_type']);
            $condition .= " AND clg.clg_user_type IN ('".$system."')";
        }
        if($args['call_status'] != ''){
            $condition .= " AND clg_log_ero.status = '".$args['call_status']."' ";
        }
        $data=$this->db->query("select  * from ems_ero_users_status As clg_log_ero LEFT JOIN ems_colleague as clg on (clg_log_ero.user_ref_id=clg.clg_ref_id) where user_group='UG-ERO' $condition ");
        ///echo $this->db->last_query()."<br>";
        //die();
        if($data->num_rows()){
            return $data->num_rows();
        }else{
            return 0;
        }
    }
    public function get_total_login_count($args = array()){
        // var_dump($args);die();
        
        $condition='';
        if($args['from_date'] != '' && $args['To_date'] != '') {
            $from = $args['from_date'];
            $to = $args['To_date'];
            $condition .= "  AND clg_log.clg_login_time BETWEEN '$from' AND '$to'";
        }
        if($args['system_type'] != ''){
            $system = implode("','",$args['system_type']);
            $condition .= " AND clg.clg_user_type IN ('".$system."')";
        }      
       

        $data=$this->db->query("select clg.clg_ref_id from ems_clg_logins As clg_log LEFT JOIN ems_colleague as clg on (clg_log.clg_ref_id=clg.clg_ref_id) where clg_login_type='login' $condition Group by clg_log.clg_ref_id");
        // echo $this->db->last_query()."<br>";
        // die();
        if($data->num_rows()){
            return $data->num_rows();
        }else{
            return 0;
        }
    }

    public function get_total_call_count6($args = array())
    { 
    if($args['group'] !='')
    {

        $condition .= $args['group'];
    }
        $data=$this->db->query("SELECT clg_ref_id FROM `ems_colleague` WHERE `clg_group` LIKE '$condition' AND clg_is_login ='yes' AND clg_is_deleted = '0' GROUP BY clg_ref_id;");
        //echo $this->db->last_query()."<br>";
        // die();
        if($data->num_rows()){
            return $data->num_rows();
        }else{
            return 0;
        }
    }
    public function get_dispatch_closure_summary_data($args = array()){
        if($args['date']!=''){ 
            $date = $args['date'];
             $condition=" AND (inc_datetime between '$date 00:00:00' and '$date 23:59:59')";
        }
        if($args['dist_array'] != ''){
            $system = implode("','",$args['dist_array']);
            $condition .= " AND inc_district_id IN ('".$system."')";
        }  
        if($args['dist'] != ''){
            $condition .= " AND inc_district_id = '".$args['dist']."' ";
        }  
        
        $sql="select * from ems_incidence where incis_deleted IN ('0') AND inc_set_amb = '1' $condition";
        $data2=$this->db->query($sql);
       // var_dump($sql);die();
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
    function get_pending_closure_summary_data($args = array()){
        if($args['date']!=''){ 
            $date = $args['date'];
             $condition=" AND (inc_datetime between '$date 00:00:00' and '$date 23:59:59')";
        }
        if($args['dist_array'] != ''){
            $system = implode("','",$args['dist_array']);
            $condition .= " AND inc_district_id IN ('".$system."')";
        }  
        if($args['dist'] != ''){
            $condition .= " AND inc_district_id = '".$args['dist']."' ";
        } 
        $sql="select * from ems_incidence where incis_deleted IN ('0') AND inc_pcr_status = '0' $condition";
        $data2=$this->db->query($sql);
        //echo $this->db->last_query($sql)."<br>";
        //die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
    public function get_closed_by_mdt_summary_data($args = array()){
        if($args['date']!=''){ 
            $date = $args['date'];
             $condition=" AND (inc_datetime between '$date 00:00:00' and '$date 23:59:59')";
        }
        if($args['dist_array'] != ''){
            $system = implode("','",$args['dist_array']);
            $condition .= " AND epcr.district_id IN ('".$system."')";
        }  
        if($args['dist'] != ''){
            $condition .= " AND epcr.district_id = '".$args['dist']."' ";
        } 
        $sql="SELECT epcr.inc_ref_id FROM `ems_epcr` as epcr WHERE epcr.epcris_deleted = '0' AND epcr.is_validate = '0' AND epcr.operate_by NOT LIKE '%DCO%'  $condition";
        $data2=$this->db->query($sql);
        //echo $this->db->last_query($sql)."<br>";
        //die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
    public function get_closed_by_dco_summary_data($args = array()){
        if($args['date']!=''){ 
            $date = $args['date'];
             $condition=" AND (inc_datetime between '$date 00:00:00' and '$date 23:59:59')";
        }
        if($args['dist_array'] != ''){
            $system = implode("','",$args['dist_array']);
            $condition .= " AND epcr.district_id IN ('".$system."')";
        }  
        if($args['dist'] != ''){
            $condition .= " AND epcr.district_id = '".$args['dist']."' ";
        } 
        $sql="SELECT epcr.inc_ref_id FROM `ems_epcr` as epcr WHERE epcr.epcris_deleted = '0' AND epcr.is_validate = '0' AND epcr.operate_by LIKE '%DCO%'  $condition";
        $data2=$this->db->query($sql);
        //echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
    public function get_validate_by_dco_summary_data($args = array()){
        if($args['date']!=''){ 
            $date = $args['date'];
             $condition=" AND (inc_datetime between '$date 00:00:00' and '$date 23:59:59')";
        }
        if($args['dist_array'] != ''){
            $system = implode("','",$args['dist_array']);
            $condition .= " AND epcr.district_id IN ('".$system."')";
        }  
        if($args['dist'] != ''){
            $condition .= " AND epcr.district_id = '".$args['dist']."' ";
        } 
        $sql="SELECT epcr.inc_ref_id FROM `ems_epcr` as epcr WHERE epcr.epcris_deleted = '1' AND epcr.is_validate = '1' AND epcr.validate_by LIKE '%DCO%'  $condition";
        $data2=$this->db->query($sql);
        //echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
    
    public function get_total_call_type($args = array())
    {   
        $where="";
        $condition='';
        if($args['type'] == 'eme')
        {
            $where =" AND inc_set_amb = '1'";
        }elseif($args['type'] == 'non-eme')
        {
            $where =" AND inc_set_amb = '0'";
        }else
        {
            $where=""; 
        }
        if($args['system_type'] != ''){
            $system = implode("','",$args['system_type']);
            $condition .= " AND inc_system_type IN ('".$system."')";
            
        }            
        if($args['date_type']=='tm'){
            $from = $args['from_date'];
            $to= $args['to_date'];
            $search=" AND (inc_datetime between '$from' and '$to')";
        }
        if($args['date_type']=='td'){ 
            $to= $args['to_date'];
            $from_date_live = $args['from_date_live'];
            $search=" AND (inc_datetime between '$from_date_live' and '$to')";
        }
        if($args['date_type']=='to'){ 
            $to_date = date('Y-m-d').' 23:59:59';
            $from_date = date('Y-m-d').' 00:00:00';
            $search=" AND (inc_datetime between '$from_date' and '$to_date')";
        }
        if($args['date_type']=='lm'){ 
            $to= $args['to_date'];
            $to_date = $args['from_date'];
            $search=" AND (inc_datetime between '$to_date' and '$to')";
        }
        
        $sql="select * from ems_incidence where incis_deleted IN ('0') $where $search $condition";
        $data2=$this->db->query($sql);
        //echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
    public function get_grievance_count($args = array()){
        $where="";
        $condition='';
        
        /*if($args['system_type'] != ''){
            $system = implode("','",$args['system_type']);
            $condition .= " AND system_type IN ('".$system."')";
            
        } */    
        if($args['date_type']=='tm'){
            $from = $args['from_date'];
            $to= $args['to_date'];
            $search=" AND (gc_added_date between '$from' and '$to')";
        }
        if($args['date_type']=='td'){ 
            $to= $args['to_date'];
            $from_date_live = $args['from_date'];
            $search=" AND (gc_added_date between '$from_date_live' and '$to')";
        }
        if($args['date_type']=='to'){ 
            $to_date = date('Y-m-d').' 23:59:59';
            $from_date = date('Y-m-d').' 00:00:00';
            $search=" AND (gc_added_date between '$from_date' and '$to_date')";
        }
        if($args['date_type']=='lm'){ 
            $to= $args['to_date'];
            $to_date = $args['from_date'];
            $search=" AND (gc_added_date between '$to_date' and '$to')";
        }
        
       
        $sql="SELECT gri.gc_inc_ref_id FROM ems_grievance_call_details as gri WHERE 1=1 $condition $where $search $condition";
        $data2=$this->db->query($sql);
        //echo $this->db->last_query($sql)."<br>";
        //die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
    public function get_feedback_count($args = array()){
        $where="";
        $condition='';
        
        /*if($args['system_type'] != ''){
            $system = implode("','",$args['system_type']);
            $condition .= " AND system_type IN ('".$system."')";
            
        } */    
        if($args['date_type']=='tm'){
            $from = $args['from_date'];
            $to= $args['to_date'];
            $search=" AND (fc_added_date between '$from' and '$to')";
        }
        if($args['date_type']=='td'){ 
            $to= $args['to_date'];
            $from_date_live = $args['from_date'];
            $search=" AND (fc_added_date between '$from_date_live' and '$to')";
        }
        if($args['date_type']=='to'){ 
            $to_date = date('Y-m-d').' 23:59:59';
            $from_date = date('Y-m-d').' 00:00:00';
            $search=" AND (fc_added_date between '$from_date' and '$to_date')";
        }
        if($args['date_type']=='lm'){ 
            $to= $args['to_date'];
            $to_date = $args['from_date'];
            $search=" AND (fc_added_date between '$to_date' and '$to')";
        }
        
       
        $sql="SELECT feed.fc_inc_ref_id FROM ems_feedback_call_details as feed WHERE 1=1 $condition $where $search $condition";
        $data2=$this->db->query($sql);
    //    echo $this->db->last_query($sql)."<br>";
    //     die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
    public function get_ercp_advice_taken_count($args = array()){
        $where="";
        $condition='';
        
        /*if($args['system_type'] != ''){
            $system = implode("','",$args['system_type']);
            $condition .= " AND system_type IN ('".$system."')";
            
        } */    
        if($args['date_type']=='tm'){
            $from = $args['from_date'];
            $to= $args['to_date'];
            $search=" AND (atnd_date between '$from' and '$to')";
        }
        if($args['date_type']=='td'){ 
            $to= $args['to_date'];
            $from_date_live = $args['from_date'];
            $search=" AND (atnd_date between '$from_date_live' and '$to')";
        }
        if($args['date_type']=='to'){ 
            $to_date = date('Y-m-d').' 23:59:59';
            $from_date = date('Y-m-d').' 00:00:00';
            $search=" AND (atnd_date between '$from_date' and '$to_date')";
        }
        if($args['date_type']=='lm'){ 
            $to= $args['to_date'];
            $to_date = $args['from_date'];
            $search=" AND (atnd_date between '$to_date' and '$to')";
        }
        
       
        $sql="SELECT add_adv.adv_cl_inc_id FROM ems_inc_add_advice as add_adv WHERE 1=1 $condition $where $search $condition";
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
    public function get_dcovalidated_closed_count($args = array()){
        $where="";
        $condition='';
        
        if($args['system_type'] != ''){
            $system = implode("','",$args['system_type']);
            $condition .= " AND system_type IN ('".$system."')";
            
        }            
        if($args['date_type']=='tm'){
            $from = $args['from_date'];
            $to= $args['to_date'];
            $search=" AND (inc_datetime between '$from' and '$to')";
        }
        if($args['date_type']=='td'){ 
            $to= $args['to_date'];
            $from_date_live = $args['from_date'];
            $search=" AND (inc_datetime between '$from_date_live' and '$to')";
        }
        if($args['date_type']=='to'){ 
            $to_date = date('Y-m-d').' 23:59:59';
            $from_date = date('Y-m-d').' 00:00:00';
            $search=" AND (inc_datetime between '$from_date' and '$to_date')";
        }
        if($args['date_type']=='lm'){ 
            $to= $args['to_date'];
            $to_date = $args['from_date'];
            $search=" AND (inc_datetime between '$to_date' and '$to')";
        }
        
        $sql="SELECT epcr.inc_ref_id FROM `ems_epcr` as epcr WHERE epcr.epcris_deleted = '0' AND epcr.is_validate = '1' AND epcr.operate_by NOT LIKE '%DCO%' $where $search $condition";
        $data2=$this->db->query($sql);
        //echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
    public function get_dco_closed_count($args = array()){
        $where="";
        $condition='';
        
        if($args['system_type'] != ''){
            $system = implode("','",$args['system_type']);
            $condition .= " AND system_type IN ('".$system."')";
            
        }            
        if($args['date_type']=='tm'){
            $from = $args['from_date'];
            $to= $args['to_date'];
            $search=" AND (inc_datetime between '$from' and '$to')";
        }
        if($args['date_type']=='td'){ 
            $to= $args['to_date'];
            $from_date_live = $args['from_date'];
            $search=" AND (inc_datetime between '$from_date_live' and '$to')";
        }
        if($args['date_type']=='to'){ 
            $to_date = date('Y-m-d').' 23:59:59';
            $from_date = date('Y-m-d').' 00:00:00';
            $search=" AND (inc_datetime between '$from_date' and '$to_date')";
        }
        if($args['date_type']=='lm'){ 
            $to= $args['to_date'];
            $to_date = $args['from_date'];
            $search=" AND (inc_datetime between '$to_date' and '$to')";
        }
        
        $sql="SELECT epcr.inc_ref_id FROM `ems_epcr` as epcr WHERE epcr.epcris_deleted = '0' AND epcr.is_validate = '1' AND epcr.operate_by LIKE '%DCO%' $where $search $condition";
        $data2=$this->db->query($sql);
        //echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
    public function get_mdt_closed_count($args = array()){
        $where="";
        $condition='';
        
        if($args['system_type'] != ''){
            $system = implode("','",$args['system_type']);
            $condition .= " AND epcr.system_type IN ('".$system."')";            
        }            
        if($args['date_type']=='tm'){
            $from = $args['from_date'];
            $to= $args['to_date'];
            $search=" AND (epcr.inc_datetime between '$from' and '$to')";
        }
        if($args['date_type']=='td'){ 
            $to= $args['to_date'];
            $from_date_live = $args['from_date'];
            $search=" AND (epcr.inc_datetime between '$from_date_live' and '$to')";
        }
        if($args['date_type']=='to'){ 
            $to_date = date('Y-m-d').' 23:59:59';
            $from_date = date('Y-m-d').' 00:00:00';
            $search=" AND (epcr.inc_datetime between '$from_date' and '$to_date')";
        }
        if($args['date_type']=='lm'){ 
            $to= $args['to_date'];
            $to_date = $args['from_date'];
            $search=" AND (epcr.inc_datetime between '$to_date' and '$to')";
        }
        
        $sql="SELECT epcr.inc_ref_id FROM `ems_epcr` as epcr WHERE epcr.epcris_deleted = '0' AND epcr.is_validate = '0' AND epcr.operate_by NOT LIKE '%DCO%' $where $search $condition";
        $data2=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
    public function get_total_104ALLcall_type($args = array()){
        $where="";
        $condition='';
        
        if ($args['district_id'] != '') {
            
            $condition .= " AND dst_code IN ('" . $args['district_id'] . "')  ";

        }
        if($args['system_type'] != ''){
            $system = implode("','",$args['system_type']);
            $condition .= " AND inc_system_type IN ('".$system."')";
            
        }            
        if($args['date_type']=='tm'){
            $from = $args['from_date'];
            $to= $args['to_date'];
            $search=" AND (inc_datetime between '$from' and '$to')";
        }
        if($args['date_type']=='td'){ 
            $to= $args['to_date'];
            $from_date_live = $args['from_date'];
            $search=" AND (inc_datetime between '$from_date_live' and '$to')";
        }
        if($args['date_type']=='to'){ 
            $to_date = date('Y-m-d').' 23:59:59';
            $from_date = date('Y-m-d').' 00:00:00';
            $search=" AND (inc_datetime between '$from_date' and '$to_date')";
        }
        if($args['date_type']=='lm'){ 
            $to= $args['to_date'];
            $to_date = $args['from_date'];
            $search=" AND (inc_datetime between '$to_date' and '$to')";
        }
        
        $sql="select inc_ref_id from ems_incidence where incis_deleted IN ('0') AND inc_type != 'COMPLAT_HELP_CALL' $where $search $condition";
        $data=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if ($data) {

            return $data->num_rows();

        } else {

            return false;

        }
    }
    public function get_total_104Comp_call_type($args = array()){
        $where="";
        $condition='';
        
        if ($args['district_id'] != '') {
            
            $condition .= " AND dst_code IN ('" . $args['district_id'] . "')  ";

        }
        if($args['system_type'] != ''){
            $system = implode("','",$args['system_type']);
            $condition .= " AND inc_system_type IN ('".$system."')";
            
        }            
        if($args['date_type']=='tm'){
            $from = $args['from_date'];
            $to= $args['to_date'];
            $search=" AND (inc_datetime between '$from' and '$to')";
        }
        if($args['date_type']=='td'){ 
            $to= $args['to_date'];
            $from_date_live = $args['from_date'];
            $search=" AND (inc_datetime between '$from_date_live' and '$to')";
        }
        if($args['date_type']=='to'){ 
            $to_date = date('Y-m-d').' 23:59:59';
            $from_date = date('Y-m-d').' 00:00:00';
            $search=" AND (inc_datetime between '$from_date' and '$to_date')";
        }
        if($args['date_type']=='lm'){ 
            $to= $args['to_date'];
            $to_date = $args['from_date'];
            $search=" AND (inc_datetime between '$to_date' and '$to')";
        }
        
        $sql="select inc_ref_id from ems_incidence where incis_deleted IN ('0') AND inc_type = 'COMPLAT_HELP_CALL' $where $search $condition";
        $data=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if ($data) {

            return $data->num_rows();

        } else {

            return false;

        }
    }
    public function get_total_call_type1($args = array())
    {   
        $where="";
        $condition='';
        if($args['type'] == 'eme')
        {
            $where =" AND inc_set_amb = '1'";
        }else
        {
            $where=""; 
        }
        if ($args['district_id'] != '') {
            
            $condition .= " AND dst_code IN ('" . $args['district_id'] . "')  ";

        }
        if($args['system_type'] != ''){
            $system = implode("','",$args['system_type']);
            $condition .= " AND inc_system_type IN ('".$system."')";
            
        }            
        if($args['date_type']=='tm'){
            $from = $args['from_date'];
            $to= $args['to_date'];
            $search=" AND (inc_datetime between '$from' and '$to')";
        }
        if($args['date_type']=='td'){ 
            $to= $args['to_date'];
            $from_date_live = $args['from_date_live'];
            $search=" AND (inc_datetime between '$from_date_live' and '$to')";
        }
        if($args['date_type']=='to'){ 
            $to_date = date('Y-m-d').' 23:59:59';
            $from_date = date('Y-m-d').' 00:00:00';
            $search=" AND (inc_datetime between '$from_date' and '$to_date')";
        }
        
        $sql="select * from ems_incidence where incis_deleted IN ('0') $where $search $condition";
        $data=$this->db->query($sql);
        // echo $this->db->last_query($sql)."<br>";
        // die;
        if ($data) {

            return $data;

        } else {

            return false;

        }
    } 
  
        function get_total_start_frm_base(){
        $to_date = date('Y-m-d').' 23:59:59';
        $from_date = date('Y-m-d').' 00:00:00';
        $condition="AND (start_from_base_loc between '$from_date' and '$to_date')";
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
    function get_total_at_scene(){
        $to_date = date('Y-m-d').' 23:59:59';
        $from_date = date('Y-m-d').' 00:00:00';
        $condition="AND (at_scene between '$from_date' and '$to_date')";
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
    function get_total_at_destination(){
        $to_date = date('Y-m-d').' 23:59:59';
        $from_date = date('Y-m-d').' 00:00:00';
        $condition="AND (at_hospital between '$from_date' and '$to_date')";
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
    function get_total_back_to_base(){
        $to_date = date('Y-m-d').' 23:59:59';
        $from_date = date('Y-m-d').' 00:00:00';
        $condition="AND (back_to_base_loc between '$from_date' and '$to_date')";
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
    function get_total_emt_present(){
        $to_date = date('Y-m-d').' 23:59:59';
        $from_date = date('Y-m-d').' 00:00:00';
        $condition=" AND (login_time between '$from_date' and '$to_date')";
        $sql="select clg_id from ems_app_login_session where login_type='D' AND status='1' $condition";
        $data2=$this->db->query($sql);
        //echo $this->db->last_query($sql)."<br>";
        //die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
    function get_total_pilot_present(){
        $to_date = date('Y-m-d').' 23:59:59';
        $from_date = date('Y-m-d').' 00:00:00';
        $condition=" AND  (login_time between '$from_date' and '$to_date')";
        $sql="select clg_id from ems_app_login_session where login_type='P' AND status='1' $condition";
        $data2=$this->db->query($sql);
        //echo $this->db->last_query($sql)."<br>";
        //die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
    }
    function Total_closure_data($args = array(),$pro) {
        $condition='';
        if($args['from_date'] != '' && $args['to_date'] != '') 
        {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "  AND epcr.inc_datetime BETWEEN '$from' AND '$to'";
        }
        if($args['system_type'] != ''){
            $system = implode("','",$args['system_type']);
            $condition .= " AND epcr.system_type IN ('".$system."')";
            
        }
        if(!empty($pro)){
            $provider = implode("','",$pro);
            $condition .= " AND epcr.provider_impressions NOT IN ('$provider')";
        }
        $data =  $this->db->query("SELECT epcr.inc_ref_id"
                . " FROM ems_epcr as epcr "
                ." where  epcr.epcris_deleted = '0' $condition ");
        //echo $this->db->last_query()."<br>";
        if($data->num_rows()){
            return $data->num_rows();
        } else {
            return 0;
        }
    }  

    function Total_closure_data_today($args = array(),$pro) {
        $condition='';
        if($args['from_date'] != '' && $args['to_date'] != '') 
        {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "  AND inc.inc_datetime BETWEEN '$from' AND '$to'";
        }
        if($args['system_type'] != ''){
            $system = implode("','",$args['system_type']);
            $condition .= " AND epcr.system_type IN ('".$system."')";
            
        }
        if(!empty($pro)){
            $provider = implode("','",$pro);
            $condition .= " AND epcr.provider_impressions NOT IN ('$provider')";
        }
        $data =  $this->db->query("SELECT epcr.inc_ref_id"
                . " FROM ems_epcr as epcr "
                . " LEFT JOIN ems_incidence as inc ON (inc.inc_ref_id = epcr.inc_ref_id) "
                ." where  epcr.epcris_deleted = '0' $condition ");
        // echo $this->db->last_query()."<br>";
        if($data->num_rows()){
            return $data->num_rows();
        } else {
            return 0;
        }
    } 

    function insert_data($result){
      $result = $this->db->insert('ems_dashboard', $result);
     //echo $this->db->last_query(); die;
      if ($result) {
           return $result;
      } else {
           return false;
      }

    }
    //*******dashboard Data update function end */
    public function get_total_calls_frm_dashboard_tbl(){
        $data=$this->db->query('select * from ems_dashboard order by Added_date  DESC');
        // echo $this->db->last_query(); die;
        if($data->num_rows()){
            return $data->result_array();
        }else{
            return 0;
        }
    }
//     function get_distance_report_by_date($args = array()) {
//         //var_dump($args);die;
//            if ($args['from_date'] != '' && $args['to_date'] != '') {
//                $from = $args['from_date'];
//                $to = $args['to_date'];
   
//                $condition .= " AND inc.inc_datetime  BETWEEN '$from' AND '$to 23:59:59'";
//            }
//            if ($args['amb_reg_no'] != '') {
//                $condition .= " AND amb.amb_rto_register_no = '" . $args['amb_reg_no'] . "'";
//            }
   
//            if ($args['system'] != '' && $args['system'] != 'all') {
//                $condition .= " AND amb.amb_user_type  = '" . $args['system'] . "'";
//            }        
           
//            $sql = "SELECT epcr.*, amb.amb_user FROM $this->tbl_epcr AS epcr"
//                . " LEFT JOIN $this->tbl_incidence AS inc ON (inc.inc_ref_id = epcr.inc_ref_id )"
//                . " LEFT JOIN $this->tbl_amb AS amb ON (epcr.amb_reg_id = amb.amb_rto_register_no )"
//                . " Where inc.incis_deleted = '0' $condition ORDER BY amb.amb_rto_register_no ";
           
//    //           $sql = "SELECT amb_tms.*,amb.amb_rto_register_no as amb_reg_id, amb.amb_user FROM $this->tbl_amb AS amb"
//    //            . " LEFT JOIN $this->tbl_ambulance_timestamp AS amb_tms ON (amb.amb_rto_register_no = amb_tms.amb_rto_register_no )"
//    //            . " Where amb.ambis_deleted  = '0' AND amb_tms.flag='1'  $condition ORDER BY amb.amb_rto_register_no ";
         
        
//            $result = $this->db->query($sql);
//            //echo $this->db->last_query();die;
//            if ($result) {
//                return $result->result_array();
//            } else {
//                return false;
//            }
//        }
   
    public function get_total_ambulance_distance_type($args = array())
    {   
        $condition='';
       
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];

            $condition .= " AND inc.inc_datetime  BETWEEN '$from' AND '$to 23:59:59'";
        }
        if($args['amb_category'] != ''){
            $condition .= " AND amb.amb_category IN ('" . $args['amb_category'] . "')  ";
        }            
        $sql = "SELECT epcr.*, amb.amb_user,amb.amb_category FROM ems_epcr AS epcr"
        . " LEFT JOIN ems_incidence AS inc ON (inc.inc_ref_id = epcr.inc_ref_id )"
        . " LEFT JOIN ems_ambulance AS amb ON (epcr.amb_reg_id = amb.amb_rto_register_no )"
        . " Where inc.incis_deleted = '0' AND amb.amb_category = 'A' $condition ORDER BY amb.amb_rto_register_no ";

        $result=$this->db->query($sql);
        // echo $this->db->last_query($sql);
        // die;
        if ($result) {
                     return $result->result_array();
                } else {
                    return false;
            }
    }   
    public function get_total_ambulance_distance_type_b($args = array())
    {   
        $condition='';
       
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];

            $condition .= " AND inc.inc_datetime  BETWEEN '$from' AND '$to 23:59:59'";
        }
        if($args['amb_category'] != ''){
            $condition .= " AND amb.amb_category IN ('" . $args['amb_category'] . "')  ";
        }            
        $sql = "SELECT epcr.*, amb.amb_user,amb.amb_category FROM ems_epcr AS epcr"
        . " LEFT JOIN ems_incidence AS inc ON (inc.inc_ref_id = epcr.inc_ref_id )"
        . " LEFT JOIN ems_ambulance AS amb ON (epcr.amb_reg_id = amb.amb_rto_register_no )"
        . " Where inc.incis_deleted = '0' AND amb.amb_category = 'B' $condition ORDER BY amb.amb_rto_register_no ";

        $result=$this->db->query($sql);
        // echo $this->db->last_query($sql);
        // die;
        if ($result) {
                     return $result->result_array();
                } else {
                    return false;
            }
    }   
    public function get_total_ambulance_distance_type_c($args = array())
    {   
        $condition='';
       
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];

            $condition .= " AND inc.inc_datetime  BETWEEN '$from' AND '$to 23:59:59'";
        }
        if($args['amb_category'] != ''){
            $condition .= " AND amb.amb_category IN ('" . $args['amb_category'] . "')  ";
        }            
        $sql = "SELECT epcr.*, amb.amb_user,amb.amb_category FROM ems_epcr AS epcr"
        . " LEFT JOIN ems_incidence AS inc ON (inc.inc_ref_id = epcr.inc_ref_id )"
        . " LEFT JOIN ems_ambulance AS amb ON (epcr.amb_reg_id = amb.amb_rto_register_no )"
        . " Where inc.incis_deleted = '0' AND amb.amb_category = 'C' $condition ORDER BY amb.amb_rto_register_no ";

        $result=$this->db->query($sql);
        // echo $this->db->last_query($sql);
        // die;
        if ($result) {
                     return $result->result_array();
                } else {
                    return false;
            }
    }   
    public function get_total_ambulance_distance_type_d($args = array())
    {   
        $condition='';
       
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];

            $condition .= " AND inc.inc_datetime  BETWEEN '$from' AND '$to 23:59:59'";
        }
        if($args['amb_category'] != ''){
            $condition .= " AND amb.amb_category IN ('" . $args['amb_category'] . "')  ";
        }            
        $sql = "SELECT epcr.*, amb.amb_user,amb.amb_category FROM ems_epcr AS epcr"
        . " LEFT JOIN ems_incidence AS inc ON (inc.inc_ref_id = epcr.inc_ref_id )"
        . " LEFT JOIN ems_ambulance AS amb ON (epcr.amb_reg_id = amb.amb_rto_register_no )"
        . " Where inc.incis_deleted = '0' AND amb.amb_category = 'D' $condition ORDER BY amb.amb_rto_register_no ";

        $result=$this->db->query($sql);
        // echo $this->db->last_query($sql);
        // die;
        if ($result) {
                     return $result->result_array();
                } else {
                    return false;
            }
    }   
    function get_total_amb_cat_a($args) {

        $condition = "AND amb.amb_type='$args' AND amb.amb_owner='GOVT'";

        $sql = "SELECT amb.* FROM ems_ambulance as amb where amb.ambis_deleted='0' AND amb.amb_category = 'A' $condition GROUP BY amb.amb_rto_register_no ";

        $result = $this->db->query($sql);
        // echo $this->db->last_query($sql);
        // die;
        return $result->num_rows();
    }

    function get_total_amb_cat_b($args) {

        $condition = "AND amb.amb_type='$args' AND amb.amb_owner='JAES'";

        $sql = "SELECT amb.* FROM ems_ambulance as amb where amb.ambis_deleted='0' AND amb.amb_category = 'A' $condition GROUP BY amb.amb_rto_register_no ";

        $result = $this->db->query($sql);
        // echo $this->db->last_query($sql);
        // die;
        return $result->num_rows();
    }

    function get_total_amb_cat_c($args) {

        $condition = "AND amb.amb_type='$args' AND amb.amb_owner='GOVT'";

        $sql = "SELECT amb.* FROM ems_ambulance as amb where amb.ambis_deleted='0' AND amb.amb_category = 'C' $condition GROUP BY amb.amb_rto_register_no ";

        $result = $this->db->query($sql);
        // echo $this->db->last_query($sql);
        // die;
        return $result->num_rows();
    }

    function get_total_amb_cat_d($args) {

        $condition = "AND amb.amb_type='$args' AND amb.amb_owner='JAES'";

        $sql = "SELECT amb.* FROM ems_ambulance as amb where amb.ambis_deleted='0' AND amb.amb_category = 'D' $condition GROUP BY amb.amb_rto_register_no ";

        $result = $this->db->query($sql);
        // echo $this->db->last_query($sql);
        // die;
        return $result->num_rows();
    }

    function get_total_amb_cat_a_NHM_km($args) {

        $condition = "AND ems_ambulance.amb_type='$args' AND ems_ambulance.amb_owner='GOVT'";

        $sql = "SELECT IFNULL(SUM(ems_epcr.total_km),0) AS tosum FROM `ems_epcr` LEFT JOIN ems_ambulance on ems_epcr.amb_reg_id = ems_ambulance.amb_rto_register_no WHERE ems_ambulance.amb_category = 'A' $condition ;";

        $result = $this->db->query($sql);
        // echo $this->db->last_query($sql);
        // die;
        if($result){            
            
            return  $result->result_array();    
        }else{
            return 0;
        }

    }

    function get_total_amb_cat_a_JAES_km($args) {

        $condition = "AND ems_ambulance.amb_type='$args' AND ems_ambulance.amb_owner='JAES'";

        $sql = "SELECT IFNULL(SUM(ems_epcr.total_km),0) AS tosum FROM `ems_epcr` LEFT JOIN ems_ambulance on ems_epcr.amb_reg_id = ems_ambulance.amb_rto_register_no WHERE ems_ambulance.amb_category = 'B' $condition ;";

        $result = $this->db->query($sql);
        // echo $this->db->last_query($sql);
        // die;
        if($result){            
            
            return  $result->result_array();    
        }else{
            return 0;
        }

    }
    function get_total_amb_cat_a_JAES_C_km($args) {

        $condition = "AND ems_ambulance.amb_type='$args' AND ems_ambulance.amb_owner='GOVT'";

        $sql = "SELECT IFNULL(SUM(ems_epcr.total_km),0) AS tosum FROM `ems_epcr` LEFT JOIN ems_ambulance on ems_epcr.amb_reg_id = ems_ambulance.amb_rto_register_no WHERE ems_ambulance.amb_category = 'C' $condition ;";

        $result = $this->db->query($sql);
        // echo $this->db->last_query($sql);
        // die;
        if($result){            
            
            return  $result->result_array();    
        }else{
            return 0;
        }

    }
    function get_total_amb_cat_a_JAES_D_km($args) {

        $condition = "AND ems_ambulance.amb_type='$args' AND ems_ambulance.amb_owner='JAES'";

        $sql = "SELECT IFNULL(SUM(ems_epcr.total_km),0) AS tosum FROM `ems_epcr` LEFT JOIN ems_ambulance on ems_epcr.amb_reg_id = ems_ambulance.amb_rto_register_no WHERE ems_ambulance.amb_category = 'D' $condition ;";

        $result = $this->db->query($sql);
        // echo $this->db->last_query($sql);
        // die;
        if($result){            
            
            return  $result->result_array();    
        }else{
            return 0;
        }

    }

    function get_rate_A_ALS3() {

        $sql = "SELECT price.prc_price FROM ems_mas_amb_price as price where price.prc_categoy='A' AND price.prc_amb_type_id = '3' ";

        $result = $this->db->query($sql);
        // echo $this->db->last_query($sql);
        // die;
        return $result->result_array();
    }

    function get_rate_A_BLS2() {

        $sql = "SELECT price.prc_price FROM ems_mas_amb_price as price where price.prc_categoy='A' AND price.prc_amb_type_id = '2' ";

        $result = $this->db->query($sql);
        // echo $this->db->last_query($sql);
        // die;
        return $result->result_array();
    }

    function get_rate_B_ALS3() {

        $sql = "SELECT price.prc_price FROM ems_mas_amb_price as price where price.prc_categoy='B' AND price.prc_amb_type_id = '3' ";

        $result = $this->db->query($sql);
        // echo $this->db->last_query($sql);
        // die;
        return $result->result_array();
    }

    function get_rate_B_BLS3() {

        $sql = "SELECT price.prc_price FROM ems_mas_amb_price as price where price.prc_categoy='B' AND price.prc_amb_type_id = '2' ";

        $result = $this->db->query($sql);
        // echo $this->db->last_query($sql);
        // die;
        return $result->result_array();
    }

    function get_rate_C_JE1() {

        $sql = "SELECT price.prc_price FROM ems_mas_amb_price as price where price.prc_categoy='C' AND price.prc_amb_type_id = '1' ";

        $result = $this->db->query($sql);
        // echo $this->db->last_query($sql);
        // die;
        return $result->result_array();
    }

    function get_rate_D_JE1() {

        $sql = "SELECT price.prc_price FROM ems_mas_amb_price as price where price.prc_categoy='D' AND price.prc_amb_type_id = '1' ";

        $result = $this->db->query($sql);
        // echo $this->db->last_query($sql);
        // die;
        return $result->result_array();
    }

    function total_call_ans_by_agent() {

        $sql = "SELECT price.prc_price FROM ems_mas_amb_price as price where price.prc_categoy='D' AND price.prc_amb_type_id = '1' ";

        $result = $this->db->query($sql);
        // echo $this->db->last_query($sql);
        // die;
        return $result->result_array();
    }


}