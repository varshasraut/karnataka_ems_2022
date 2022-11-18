<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Supervisory_calls_model extends CI_Model {
    public function __construct(){
		parent::__construct();	
	}
    //*****Dashboard Data Update function*****
    
    public function get_total_call_count($args = array())
    {
        $condition='';
        if($args['from_date'] != '' && $args['To_date'] != '') {
            $from = $args['from_date'];
            $to = $args['To_date'];
            $condition .= "  AND inc.inc_datetime LIKE '%$from%'";
        }
        if($args['system_type'] != ''){
            $system = implode("','",$args['system_type']);
            $condition .= " AND inc.inc_system_type IN ('".$system."')";
        }
        $data=$this->db->query("select inc.inc_id from ems_incidence As inc where incis_deleted IN ('0') $condition");
        //echo $this->db->last_query()."<br>";die();
        if($data->num_rows()){
            return $data->num_rows();
        }else{
            return 0;
        }
    }

    public function get_total_104_call_count($args = array())
    {
        $condition='';
        if($args['from_date'] != '' && $args['To_date'] != '') {
            $from = $args['from_date'];
            $to = $args['To_date'];
            $condition .= "  AND inc.inc_datetime LIKE '%$from%'";
        }
        if($args['system_type'] != ''){
            $system = implode("','",$args['system_type']);
            $condition .= " AND inc.inc_system_type IN ('".$system."')";
            
        }
        $data=$this->db->query("select inc.inc_id from ems_incidence As inc where incis_deleted IN ('0') $condition");
        // echo $this->db->last_query()."<br>";die();
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
        
        $data=$this->db->query("select  amb_rto_register_no  from ems_ambulance where ambis_deleted='0' $condition ");
        //echo $this->db->last_query()."<br>";
        //die();
        if($data->num_rows()){
            return $data->num_rows();
        }else{
            return 0;
        }
    }

    public function get_amb_off_road_count(){
        $condition='';
 
            $condition .= " AND amb_status ='7' or amb_status ='11'";
      
        
        $data=$this->db->query("select  amb_rto_register_no  from ems_ambulance where ambis_deleted='0' $condition ");
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
      /*  if($args['amb_status'] != ''){
            $amb_status = implode("','",$args['amb_status']);
            $condition .= " AND amb_status IN ('".$amb_status."')";
         }*/
        
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
        //echo $this->db->last_query()."<br>";
        //die();
        if($data->num_rows()){
            return $data->num_rows();
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
        if($args['date_type']=='to'){
            $from = $args['date'];
            $to= $args['date'];
            $search=" AND (inc_datetime LIKE '%$from%')";
        }
      
        $sql="select inc_id from ems_incidence where incis_deleted IN ('0') $where $search $condition";
        $data2=$this->db->query($sql);
        //echo $this->db->last_query($sql)."<br>";
        // die;
        if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
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
        //echo $this->db->last_query(); die;
        if($data->num_rows()){
            return $data->result_array();
        }else{
            return 0;
        }
    }

    function get_fuel_filling_data()
    {
        
        $sql = "SELECT SUM(ff.ff_fuel_quantity) as fueltotal,district.dst_name"
            . " FROM ems_fleet_fuel_filling as ff"
            . " LEFT JOIN ems_mas_districts as district ON ( district.dst_code = ff.ff_district_code )"
            . " LEFT JOIN ems_fuel_station as fs ON ( fs.f_id = ff.ff_fuel_station )" 

            . " where 1=1";
        
        $result = $this->db->query($sql);

        //echo $this->db->last_query();die;

        if ($result->num_rows()) {
            return $result->result_array();
        } else {
            return $result->result();
        }
    }
}