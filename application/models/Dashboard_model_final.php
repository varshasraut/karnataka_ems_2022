<?php
class Dashboard_model_final extends CI_Model {

    public function get_total_calls_frm_dashboard_tbl(){
        $data=$this->db->query('select * from ems_dashboard');
      
        if($data->num_rows()){
            return $data->result_array();
        }else{
            return 0;
        }
    }
    
    function update_amb_nhm_data($amb_rto_register_no, $data){
   // $this->db->where('amb_no', $amb_rto_register_no);
    //->db->update('ems_nhm_amb_data', $data);
    //echo $this->db->last_query(); die;
    
        $this->db->select('*');
        $this->db->from("ems_nhm_amb_data");
        $this->db->where("ems_nhm_amb_data.amb_no", $amb_rto_register_no);
        $fetched = $this->db->get();
        $present = $fetched->result();
        if (count($present) == 0) {
            $data['amb_no'] = $amb_rto_register_no;
            $result = $this->db->insert('ems_nhm_amb_data', $data);
            
         
            if ($result) {
                return $this->db->insert_id();
            } else {
                return false;
            }
        } else {

            $this->db->where('amb_no', $amb_rto_register_no);
            $data = $this->db->update("ems_nhm_amb_data", $data);
            return $data;
        }
    
    }
function update_nhm_data($dst_code, $data){
    //var_dump($data); die;
    $this->db->where('dst_code', $dst_code);
    $this->db->update('ems_nhm_data', $data);
    //echo $this->db->last_query(); die;
}
    public function date_reports_eme_calls($from, $to)
        {

            $data=$this->db->query('select * from ems_incidence where incis_deleted IN ("0","2") AND inc_datetime between "'.$from.'" and "'.$to.'"');
            //echo $this->db->last_query()."<br>";
            if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
            
        }
        
         public function get_call_count($args = array())
        {
            $from = $args['current_date'];
            $from_date_live = $args['from_date_live'];
           // $data=$this->db->query("select * from ems_incidence where incis_deleted IN ('0','2') AND inc_datetime  <= '$from 23:59:59'");
           $data=$this->db->query("select * from ems_incidence where incis_deleted IN ('0','2') AND inc_datetime between '$from_date_live' and '$from 23:59:59'");
           //echo $this->db->last_query()."<br>";
            // die();
            if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
            
        }
        public function get_closure_last_date(){
            $data=$this->db->query("SELECT * FROM `ems_incidence` WHERE `inc_set_amb` = '1' AND `inc_pcr_status` = '0' AND `inc_datetime` != '0000-00-00 00:00:00' AND `inc_datetime` >= '2021-08-01' and incis_deleted = '0' ORDER BY `ems_incidence`.`inc_datetime` ASC limit 0,1");
             if($data->num_rows()){
                 return $data->result_array();
             }else{
                 return 0;
             }
        }
        
        
        public function total_back_to_base_count()
        {
            $to_date = date('Y-m-d');
            $from_date = date('Y-m-d');
            $condition ='';
            $current_time = date('Y-m-d H:i:s'); 
            $before_six_hur_time = date('Y-m-d H:i:s', strtotime('-6 hour'));
          
            $condition = " inc.inc_datetime BETWEEN '".$to_date." 00:00:00' AND  '".$from_date." 23:59:59'";
        
            $sql = "select driver_para.*, inc.* ,inc_amb.* from ems_incidence_ambulance AS inc_amb
             LEFT JOIN ems_incidence AS inc ON inc.inc_ref_id = inc_amb.inc_ref_id 
             LEFT JOIN ems_driver_parameters as driver_para ON inc.inc_ref_id = driver_para.incident_id where  inc.inc_datetime BETWEEN '".$to_date." 00:00:00' AND  '".$before_six_hur_time." '";
       
            $result = $this->db->query($sql);
           // echo $this->db->last_query();die;
            return $result->result();
            
        }
        function get_total_calls_B12table(){
            /*$sql = "select SUM(b12_value) as b12_key_till_date,SUM(b12_tm_value) as b12_key_till_month  from ems_b12_data ";
            $result = $this->db->query($sql);
            //echo $this->db->last_query();die;
            return $result->result();
            */
            $sql = "select SUM(patient_servedold_td) as patient_servedold_td,SUM(patient_served_today) as patient_served_today,SUM(dispatch_today_108) as dispatch_today_108,SUM(patient_served_tm) as patient_served_tm,SUM(patient_served_td) as patient_served_td,SUM(dispatch_today_102) as dispatch_today_102,SUM(dispatch_tm) as dispatch_tm,SUM(dispatch_td) as dispatch_td from ems_nhm_data ";
            $result = $this->db->query($sql);
           // echo $this->db->last_query();die;
            return $result->result();
        }
        
    public function date_reports_eme_patients($from, $to)
    {

        $data=$this->db->query('select * from ems_epcr where date between "'.$from.'" and "'.$to.'"');
        if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
        
    }
        public function get_preganancy_calls()
    {
        $data=$this->db->query('SELECT * FROM `ems_epcr` WHERE provider_impressions  IN ("24","12") AND epcris_deleted="0"');
         if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
    }    
    public function get_assists_calls()
    {
        $data=$this->db->query('SELECT * FROM `ems_epcr` WHERE provider_impressions  IN ("11","12") AND epcris_deleted="0"');
         if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
    }    
    
      public function get_rta(){
        $data=$this->db->query('SELECT * FROM `ems_epcr` WHERE provider_impressions  IN ("33") AND epcris_deleted="0"');
         if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
    }  
    public function get_non_vahicular(){
        $data=$this->db->query('SELECT * FROM `ems_epcr` WHERE provider_impressions  IN ("15","56") AND epcris_deleted="0"');
         if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
    }  
    public function live_calls_eme_pat_served()
    {
        $data=$this->db->query('SELECT * FROM `ems_epcr` WHERE ct_id IN (33, 34, 35, 36, 37, 38, 39, 40, 41, 42) AND ct_status="1" AND ctis_deleted="0"');
        if($data){
            return $data->result();
        }else{
            return FALSE;
        }
    }    
    
   
    public function get_accident_names()
    {
    	$data=$this->db->query('SELECT * FROM `ems_mas_patient_complaint_types` WHERE ct_id IN (33, 34, 35, 36, 37, 38, 39, 40, 41, 42) AND ct_status="1" AND ctis_deleted="0"');
    	if($data){
            return $data->result();
        }else{
            return FALSE;
        }
    }
    public function burn()
    {
    	$data=$this->db->query('SELECT * FROM `ems_mas_patient_complaint_types` WHERE ct_id="9" AND ct_status="1" AND ctis_deleted="0"');
        if($data){
            return $data->result();
        }else{
            return FALSE;
        }
    }
    public function attack()
    {
        $data=$this->db->query('SELECT * FROM `ems_mas_patient_complaint_types` WHERE ct_id="6" AND ct_status="1" AND ctis_deleted="0"');
        if($data){
                return $data->result();
            }else{
                return FALSE;
            }
    }
     public function cardiac()
    {
        $data=$this->db->query('SELECT * FROM `ems_mas_patient_complaint_types` WHERE ct_id="10" AND ct_status="1" AND ctis_deleted="0"');
        if($data){
            return $data->result();
        }else{
            return FALSE;
        }
    }
    public function fall()
    {
        $data=$this->db->query('SELECT * FROM `ems_mas_patient_complaint_types` WHERE ct_id="18" AND ct_status="1" AND ctis_deleted="0"');
        if($data){
            return $data->result();
        }else{
            return FALSE;
        }
    }
 public function poisoning()
    {
        $data=$this->db->query('SELECT * FROM `ems_mas_patient_complaint_types` WHERE ct_id="26" AND ct_status="1" AND ctis_deleted="0"');
        if($data){
            return $data->result();
        }else{
            return FALSE;
        }
    }
    public function pregnancy()
        {
            $data=$this->db->query('SELECT * FROM `ems_mas_patient_complaint_types`  WHERE ct_id IN (27, 28) AND ct_status="1" AND ctis_deleted="0"');
            if($data){
                return $data->result();
            }else{
                return FALSE;
            }
        }
        public function child_birth()
        {
            $data=$this->db->query('SELECT * FROM `ems_mas_patient_complaint_types`  WHERE ct_id IN (29) AND ct_status="1" AND ctis_deleted="0"');
            if($data){
                return $data->result();
            }else{
                return FALSE;
            }
        }
        public function other()
        {
             $data=$this->db->query('SELECT * FROM `ems_mas_patient_complaint_types`  WHERE ct_id IN ("52","59","60") AND ct_status="1" AND ctis_deleted="0"');
            if($data){
                return $data->result();
            }else{
                return FALSE;
            }
        }
     public function trauma()
        {
            $data=$this->db->query('SELECT * FROM `ems_mas_patient_complaint_types`  WHERE ct_id IN (44, 45, 46, 47, 48) AND ct_status="1" AND ctis_deleted="0"');
            if($data){
                return $data->result();
            }else{
                return FALSE;
            }
        }  
        public function medical()
        {
            $data=$this->db->query('SELECT * FROM `ems_mas_patient_complaint_types`  WHERE ct_id IN (1,2,3,4,5,7,8,11,12,13,14,15,16,17,19,20,21,22,23,24,25,30,31,32,43,49,50,51,53) AND ct_status="1" AND ctis_deleted="0"');
            if($data){
                return $data->result();
            }else{
                return FALSE;
            }
        }  
    public function get_complaint_types()
        {
        	$data=$this->db->query('SELECT * FROM ems_incidence WHERE incis_deleted IN ("0","2") AND DATE(inc_datetime) > "2020-03-23 23:23:59"  AND inc_complaint IN (33, 34, 35, 36, 37, 38, 39, 40, 41, 42)');
            if($data){
                return $data->result();
            }else{
                return true;
            }
        }
    public function mass_casualty()
        {
            $data=$this->db->query('SELECT * FROM ems_mas_micnature WHERE ntris_deleted="0" AND ntr_status="1"');
            
            if($data){
                return $data->result();
            }else{
                return FALSE;
            }
        }
	public function get_total_calls_td($duration)
        {   
            $data=$this->db->query('select * from ems_incidence where incis_deleted IN ("0","2")');
            //echo $this->db->last_query(); die;
            if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
	
        }
        public function get_corona_calls()
        {   
            $data=$this->db->query('select * from ems_incidence where incis_deleted IN ("0","2") AND inc_complaint IN ("59","60") AND DATE(inc_datetime) > "2020-03-23 23:23:59"');
            //echo $this->db->last_query(); die;
            if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
	
        }
        
        public function get_total_calls_tm($duration)
        {  
            $data=$this->db->query('select * from ems_incidence where incis_deleted IN ("0","2") AND (DATE(inc_datetime) BETWEEN DATE_FORMAT(NOW(),"%Y-%m-01") and NOW())');
           // echo $this->db->last_query(); die;
            if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
	
        }

        public function get_total_calls_tm_108($duration)
        {  
            $data=$this->db->query('select * from ems_incidence where incis_deleted IN ("0","2") AND (DATE(inc_datetime) BETWEEN DATE_FORMAT(NOW(),"%Y-%m-01") and NOW()) AND inc_system_type="108"');
           // echo $this->db->last_query(); die;
            if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
	
        }

        public function get_total_calls_tm_102($duration)
        {  
            $data=$this->db->query('select * from ems_incidence where incis_deleted IN ("0","2") AND (DATE(inc_datetime) BETWEEN DATE_FORMAT(NOW(),"%Y-%m-01") and NOW()) AND system_type="102"');
        
            if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
	
        }


        public function get_total_calls_to_108($duration)
        {   
            $data=$this->db->query('select * from ems_incidence where inc_system_type="108" AND incis_deleted IN ("0","2")  AND DATE(inc_datetime) = CURDATE()');
            //echo $this->db->last_query(); die;
            if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
	
        }
        public function get_total_calls_to_102($duration)
        {   
            $data=$this->db->query('select * from ems_incidence where inc_system_type="102" AND incis_deleted IN ("0","2") AND DATE(inc_datetime) = CURDATE()');
            //echo $this->db->last_query(); die;
            if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
	
		}
        public function get_amb_avail_status()
        {
           // $condition="AND amb_status='".$cond."' ";
            $data=$this->db->query('select * from ems_ambulance where ambis_deleted IN ("0") AND amb_status="1"');
            if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
	
        }
        public function get_amb_busy_status()
        {
           // $condition="AND amb_status='".$cond."' ";
            $data=$this->db->query('select * from ems_ambulance where ambis_deleted IN ("0") AND amb_status="2"');
            if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
	
		}
                public function get_total_calls_108(){
        	$data2=$this->db->query('select * from ems_incidence where incis_deleted IN ("0","2") AND inc_system_type="108" AND DATE(inc_datetime) > "2020-03-23 23:23:59"');
            
    		if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
		}
        public function get_total_calls_102(){
        	$data2=$this->db->query('select * from ems_incidence where incis_deleted IN ("0","2") AND inc_system_type="102" ');
    		if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
		}
	public function get_total_calls_curr_month()
        {
        	$data2=$this->db->query('select * from ems_incidence where (inc_datetime between DATE_FORMAT(NOW(),"%Y-%m-01") and NOW()) AND incis_deleted IN ("0","2")');
    		if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
		}
    public function get_total_calls_curr_month_108(){
        	$data2=$this->db->query('select * from ems_incidence where (inc_datetime between DATE_FORMAT(NOW(),"%Y-%m-01") and NOW()) AND incis_deleted IN ("0","2") AND inc_system_type="108"');
    		if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
		}
        public function get_total_calls_curr_month_102(){
        	$data2=$this->db->query('select * from ems_incidence where (inc_datetime between DATE_FORMAT(NOW(),"%Y-%m-01") and NOW()) AND incis_deleted IN ("0","2") AND inc_system_type="102"');
    		if($data2->num_rows()){
                return $data2->num_rows();
            }else{
                return 0;
            }
		}
	public function get_total_calls_today()
    {
      $to_date = date('Y-m-d').' 23:59:59';
            $from_date = date('Y-m-d').' 00:00:00';
    	$data2=$this->db->query('select * from ems_incidence where inc_datetime between "'.$from_date.'" AND "'.$to_date.'" and incis_deleted IN ("0","2")');
        
        
		if($data2->num_rows()){
            return $data2->num_rows();
        }else{
            return 0;
        }
    }

    public function get_total_calls_today_108()
    {
    	$data2=$this->db->query('select * from ems_incidence where DATE(inc_datetime) = CURDATE() AND incis_deleted IN ("0","2") AND system_type="108"');
		if($data2->num_rows()){
            return $data2->num_rows();
        }else{
            return 0;
        }
    }

    public function get_total_calls_today_102()
    {
    	$data2=$this->db->query('select * from ems_incidence where DATE(inc_datetime) = CURDATE() AND incis_deleted IN ("0","2")AND system_type="102"');
		if($data2->num_rows()){
            return $data2->num_rows();
        }else{
            return 0;
        }
    }
        public function get_rta_inc($args=array())
    {   

         if($args['from_date'] != ''){
            $from = $args['from_date'];
            $to_date = $args['to_date'];
            $search= ' AND (inc_datetime between "'.$from.'" and "'.$to_date.'" )';
        }



        $sql='select * from ems_incidence where incis_deleted IN ("0") AND inc_set_amb = "1" AND inc_complaint IN ("33","34","35", "36", "37", "38", "39", "40", "41", "42") '.$search.'';
        $data=$this->db->query($sql);
        //echo $this->db->last_query($sql);
       // die;
        if($data->num_rows()){
            return $data->num_rows();
        }else{
            return 0;
        }
    }
    public function get_total_type_calls_today($cond, $duration,$system='')
    {   
        if($cond=='eme'){
        $where="AND inc_set_amb = '1'";
        }elseif($cond=='non-eme'){
        $where="AND inc_set_amb = '0'";
        }else{
            $where=""; 
        }
                
        if($system == '108'){
             $where.=" AND inc_system_type = '108'";
        }else if($system == '102'){
            $where.=" AND inc_system_type = '102'";
        }
        if($duration=='tm'){
            $search='AND (inc_datetime between DATE_FORMAT(NOW(),"%Y-%m-01") and NOW())';
        }
        if($duration=='to'){
            $search="AND DATE(inc_datetime) = CURDATE()";
        }
        if($duration=='td'){
            //$search='AND DATE(inc_datetime) > "2020-03-23 23:23:59"';
        }


        $sql='select * from ems_incidence where incis_deleted IN ("0","2") '.$where.' '.$search.'';
        $data2=$this->db->query($sql);
    //echo $this->db->last_query($sql);die;
        if($data2->num_rows()){
            return $data2->num_rows();
        }else{
            return 0;
        }
    }
      public function get_total_call_type($args = array())
    {   
        if($args['type']=='eme'){
        $where=" AND inc_set_amb = '1'";
        }elseif($args['type']=='non-eme'){
        $where=" AND inc_set_amb = '0'";
        }else{
            $where=""; 
        }
                
        if($args['date_type']=='tm'){
            $from = $args['from_date'];
            $to= $args['to_date'];
            $search=" AND (inc_datetime between '$from' and '$to')";
        }
        if($args['date_type']=='td'){ 
            $to= $args['to_date'].' 23:59:59';
            $from_date_live = $args['from_date_live'];
            //$search=" AND inc_datetime < '$to'";
            $search=" AND (inc_datetime between '$from_date_live' and '$to')";

        }
        if($args['date_type']=='to'){ 
            $to_date = date('Y-m-d').' 23:59:59';
            $from_date = date('Y-m-d').' 00:00:00';
            $search=" AND (inc_datetime between '$from_date' and '$to_date')";

        }
       


        $sql="select * from ems_incidence where incis_deleted IN ('0','2') $where $search";
        $data2=$this->db->query($sql);
       // echo $this->db->last_query($sql)."<br>";
      //  die;
        if($data2->num_rows()){
            return $data2->num_rows();
        }else{
            return 0;
        }
    }
    public function get_total_closed_calls_today($cond = '')
    {   
        if($cond=='108'){
        $where="AND i.inc_system_type='108'";
        }elseif($cond=='102'){
        $where="AND i.inc_system_type='102'";
        }
        $sql='select * from ems_epcr ep LEFT JOIN ems_incidence i ON ep.inc_ref_id = i.inc_ref_id where STR_TO_DATE(`date`,"%m/%d/%Y") = CURRENT_DATE() AND epcris_deleted = "0" '.$where.'';
      
        $data2=$this->db->query($sql);
        if($data2->num_rows()){
            return $data2->num_rows();
        }else{
            return 0;
        }
    }
    public function get_total_dispatch_patient_dist($args){
        if($args['dst_code'] != ''){
            $condition = "AND inc_district_id='".$args['dst_code']."' ";
            $to_date = date('Y-m-d');
            $where = "inc_datetime BETWEEN '$to_date 00:00:00' AND '$to_date 23:59:59'";
            $sql="SELECT SUM(inc_patient_cnt) as pt_count  FROM `ems_incidence` WHERE $where AND `inc_system_type` LIKE '108' AND `inc_set_amb` = '1' $condition ORDER BY `inc_ref_id`  DESC";
            $data2=$this->db->query($sql);
            //echo $this->db->last_query($sql)."<br>";
            //die;
            
            if($data2->num_rows()){
                return $data2->result_array();
            }else{
                return 0;
            }
        }
    }
    public function get_total_dispatch_patient($cond = ''){
       
        $to_date = date('Y-m-d');
        $where = "inc_datetime BETWEEN '$to_date 00:00:00' AND '$to_date 23:59:59'";
        $sql="SELECT SUM(inc_patient_cnt) as pt_count  FROM `ems_incidence` WHERE $where AND `inc_system_type` LIKE '108' AND `inc_set_amb` = '1' ORDER BY `inc_ref_id`  DESC";
        $data2=$this->db->query($sql);
        //echo $this->db->last_query($sql)."<br>";
        //die;
        
        if($data2->num_rows()){
            return $data2->result_array();
        }else{
            return 0;
        }
    }
    public function get_total_validated_closed_calls_today($cond = '')
    {   
        if($cond=='108'){
        $where="AND i.inc_system_type='108'";
        }elseif($cond=='102'){
        $where="AND i.inc_system_type='102'";
        }
         $to_date = date('Y-m-d');
        $where = "AND ep.validate_date BETWEEN '$to_date 00:00:00' AND '$to_date 23:59:59'";
        $sql='select * from ems_epcr ep LEFT JOIN ems_incidence i ON ep.inc_ref_id = i.inc_ref_id where is_validate ="1" AND epcris_deleted = "0"  '.$where.'';
    
        $data2=$this->db->query($sql);
        if($data2->num_rows()){
            return $data2->num_rows();
        }else{
            return 0;
        }
    }

    public function get_agent_status($cond)
    {   
        if($cond=='avail'){
            $sql="SELECT * FROM ems_ero_users_status WHERE status='free' AND user_group='UG-ERO'";
        }elseif($cond=='oncall'){
        $sql="SELECT * FROM ems_ero_users_status WHERE status='atnd' AND user_group='UG-ERO'";
        }elseif($cond=='break'){
            $sql="SELECT * FROM ems_ero_users_status WHERE status='break' AND user_group='UG-ERO'";
        }
        //$sql='select * from ems_colleague where clg_is_deleted="0"'.$where.'';
        $data2=$this->db->query($sql);
        if($data2->num_rows()){
            return $data2->num_rows();
        }else{
            return 0;
        }
    }
    public function total_calls_system($cond)
    {   
        if($cond=='108'){
        $where="AND inc_system_type='108'";
        }elseif($cond=='102'){
        $where="AND inc_system_type='102'";
        }
        $sql='select * from ems_incidence where DATE(inc_datetime) = CURDATE() AND incis_deleted IN ("0","2") '.$where.'';
        $data2=$this->db->query($sql);
        if($data2->num_rows()){
            return $data2->num_rows();
        }else{
            return 0;
        }
    }
    
    public function get_amb_all_status($cond)
    {   
        if($cond=='all'){
        $where="";
        }elseif($cond=='avail'){
        $where="AND amb_status='1'";
        }elseif($cond=='busy'){
            $where="AND amb_status='2'";
            }
        $sql="SELECT *  FROM `ems_ambulance` WHERE  `amb_user_type` = '108' AND `amb_status` NOT IN('5') AND `ambis_deleted` = '0'".$where.'';
        $data2=$this->db->query($sql);
        if($data2->num_rows()){
            return $data2->num_rows();
        }else{
            return 0;
        }
        // select * from ems_ambulance where ambis_deleted IN ("0")
	}
    public function get_total_calls_emps_td()
    {
        $data2=$this->db->query('select * from ems_epcr where  epcris_deleted="0"');
        //echo $this->db->last_query(); die;
        if($data2->num_rows()){
            return $data2->num_rows();
        }else{
            return 0;
        }
    }

    public function get_total_calls_emps_td_108()
    {
        $data2=$this->db->query('select * from ems_epcr where  epcris_deleted="0"');
        //echo $this->db->last_query(); die;
        if($data2->num_rows()){
            return $data2->num_rows();
        }else{
            return 0;
        }
    }

    public function get_total_calls_emps_td_102()
    {
        $data2=$this->db->query('select * from ems_epcr where STR_TO_DATE(`date`,"%Y/%m/%d") > "03/23/2020 23:23:59" AND system_type="102"');
        //echo $this->db->last_query(); die;
        if($data2->num_rows()){
            return $data2->num_rows();
        }else{
            return 0;
        }
    }

    public function get_total_calls_emps_tm()
    {
        $data2=$this->db->query('SELECT * FROM `ems_epcr` WHERE epcris_deleted="0" AND MONTH(STR_TO_DATE(`ems_epcr`.`date`,"%m/%d/%Y")) = MONTH(CURRENT_DATE()) AND YEAR(STR_TO_DATE(`ems_epcr`.`date`,"%m/%d/%Y")) = YEAR(CURRENT_DATE())');
        //$data2=$this->db->query('SELECT * FROM `ems_epcr` WHERE epcris_deleted="0" AND STR_TO_DATE(`date`,"%m/%d/%Y") >= "2020-03-23"');
		if($data2->num_rows()){
            return $data2->num_rows();
        }else{
            return 0;
        }
    }

    public function get_total_calls_emps_tm_108()
    {
        $data2=$this->db->query('SELECT * FROM `ems_epcr` WHERE system_type="108" AND epcris_deleted="0" AND MONTH(STR_TO_DATE(`ems_epcr`.`date`,"%m/%d/%Y")) = MONTH(CURRENT_DATE()) AND YEAR(STR_TO_DATE(`ems_epcr`.`date`,"%m/%d/%Y")) = YEAR(CURRENT_DATE()) ');
        //$data2=$this->db->query('SELECT * FROM `ems_epcr` WHERE epcris_deleted="0" AND STR_TO_DATE(`date`,"%m/%d/%Y") >= "2020-03-23"');
		if($data2->num_rows()){
            return $data2->num_rows();
        }else{
            return 0;
        }
    }

    public function get_total_calls_emps_tm_102()
    {
        $data2=$this->db->query('SELECT * FROM `ems_epcr` WHERE system_type="102" AND epcris_deleted="0" AND MONTH(STR_TO_DATE(`ems_epcr`.`date`,"%m/%d/%Y")) = MONTH(CURRENT_DATE()) AND YEAR(STR_TO_DATE(`ems_epcr`.`date`,"%m/%d/%Y")) = YEAR(CURRENT_DATE())');
        //$data2=$this->db->query('SELECT * FROM `ems_epcr` WHERE epcris_deleted="0" AND STR_TO_DATE(`date`,"%m/%d/%Y") >= "2020-03-23"');
		if($data2->num_rows()){
            return $data2->num_rows();
        }else{
            return 0;
        }
    }
    public function get_total_calls_emps_to()
    {
        $data2=$this->db->query('SELECT * FROM `ems_epcr` WHERE epcris_deleted="0" AND STR_TO_DATE(`ems_epcr`.`date`,"%m/%d/%Y") = CURDATE() AND epcris_deleted = "0"');
        //echo $this->db->last_query(); die;
        if($data2->num_rows()){
            return $data2->num_rows();
        }else{
            return 0;
        }
    }

    public function get_total_calls_emps_to_108()
    {
        $data2=$this->db->query('SELECT * FROM `ems_epcr` WHERE system_type="108" AND epcris_deleted="0" AND STR_TO_DATE(`ems_epcr`.`date`,"%m/%d/%Y") = CURDATE() AND epcris_deleted = "0"');
        //echo $this->db->last_query(); die;
        if($data2->num_rows()){
            return $data2->num_rows();
        }else{
            return 0;
        }
    }

    public function get_total_calls_emps_to_102()
    {
        $data2=$this->db->query('SELECT * FROM `ems_epcr` WHERE system_type="102" AND epcris_deleted="0" AND STR_TO_DATE(`ems_epcr`.`date`,"%m/%d/%Y") = CURDATE() AND epcris_deleted = "0"');
        //echo $this->db->last_query(); die;
        if($data2->num_rows()){
            return $data2->num_rows();
        }else{
            return 0;
        }
    }

	public function get_total_calls_handled()
		{
			$data=$this->db->query('select * from ems_incidence where incis_deleted IN ("0","2") AND DATE(inc_datetime) > "2020-03-23 23:23:59" ');
            if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
		}

	public function get_total_dispatch_all($args_all = '')
		{   
            $condition = "";
            if($args_all == "all"){
                //$condition .= 'AND DATE(inc_datetime) > "2020-03-23 23:23:59" '; 
            }

            if($args_all == "tm"){
                $condition .= "AND DATE(inc_datetime)=CURDATE()"; 
            }

			$data=$this->db->query("SELECT * FROM `ems_incidence` WHERE inc_set_amb = '1' AND incis_deleted IN ('0') ".$condition."  ");
           // echo $this->db->last_query();die;
            if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
        }

        public function get_total_dispatch_all_tm($system = '')
		{   
            $condition = " AND inc_datetime BETWEEN DATE_FORMAT(NOW(),'%Y-%m-01') AND NOW()";
            if($system != ""){
                $condition .= " AND inc_system_type = $system"; 
            }
			$data=$this->db->query("SELECT * FROM `ems_incidence` WHERE inc_set_amb = '1' AND incis_deleted IN ('0','2') ".$condition." ");
            //echo $this->db->last_query();die;
            if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
        }

        public function get_total_dispatch_108($args_108)
		{   
            $condition = "";
      
            if($args_108 == "108"){
                $condition .= "AND inc_system_type = '108'"; 
            }
            $sql='SELECT * FROM ems_incidence WHERE DATE(inc_datetime)=CURDATE() AND inc_set_amb = "1" AND incis_deleted IN ("0","2") '.$condition.' ';
			$data=$this->db->query($sql);
            //echo $this->db->last_query();die;
            if($data->result()){
                return $data->num_rows();
            }else{
                return 0;
            }
        }
        public function get_total_dispatch_102($args_102)
		{   
            $condition = "";
            if($args_102 == "102"){
                $condition .= "AND inc_system_type = '102'"; 
            }

			$data=$this->db->query("SELECT * FROM `ems_incidence` WHERE DATE(inc_datetime)=CURDATE() AND inc_set_amb = '1' AND incis_deleted IN ('0','2') $condition  ");
            //echo $this->db->last_query();die;
            if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
        }
        

	public function get_agents_available()
		{
			$data=$this->db->query("select * from ems_colleague where clg_group IN ('UG-ERO','UG-FLEETDESK','UG-DCO','UG-ERCHead','UG-ERCManager','UG-QualityManager','UG-Quality','UG-ERCPSupervisor','UG-ERCP','UG-PDA','UG-FDA','UG-Feedback','UG-Grievance','UG-BIKE-ERO','UG-FleetManagement','UG-BioMedicalManager') and clg_is_deleted = '0'  AND clg_is_active =1 and clg_is_login = 'yes'");
            if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
        }

    public function get_agents_available_108($cond)
    {
        $data=$this->db->query("select * from ems_ero_users_status where user_group IN ('UG-ERO')");
        if($data->num_rows()){
            return $data->num_rows();
        }else{
            return 0;
        }
    }

    public function get_agents_available_102($cond)
    {
        $data=$this->db->query("select * from ems_ero_users_status where user_group IN ('UG-ERO-102')");
        if($data->num_rows()){
            return $data->num_rows();
        }else{
            return 0;
        }
    }
        
    public function get_agents_available_list($grp)
    {   
        if($grp != ""){
        //if($grp="ero"){
        //    $condition = 'AND clg_group IN ("UG-ERO","UG-ERO-102")';
       // }else if($grp="dco"){
       //     $condition = 'AND clg_group IN ("UG-DCO","UG-DCO-102")';
       // }else 
        //if($grp="UG-ERCP"){
            $condition = 'AND clg_group = "'.$grp.'" ';
        //}else if($grp="UG-ERCP"){
        //    $condition = 'AND clg_group = "'.$grp.'" ';
       // }
        
        }else{
            $condition = "";
        }  
        $sql = 'select * from ems_colleague where clg_is_login="yes" '.$condition.' ';
        $data=$this->db->query($sql);
        
        if($data->result()){
            //print_r($data->result()); die;
            return $data->num_rows();
        }else{
            return 0;
        }
    }

	public function get_onRoad_available()
		{
			$data=$this->db->query('select * from ems_ambulance where amb_status IN (1,2,3,4,5,6,8,9,10) AND ambis_deleted="0"');
            if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
		}

	public function get_offRoad_available()
		{
			$data=$this->db->query('select * from ems_ambulance where amb_status IN (7) AND ambis_deleted="0"');
            if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
		}

	public function avg_resp_time()
		{
			$data=$this->db->query("select AVG ( inc_dispatch_time ) FROM ems_incidence where DATE(inc_datetime)=DATE(now())");
			if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
		}

	public function total_incoming_calls()
		{
			$data=$this->db->query("select * from ems_calls");
            if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
		}

	public function total_active_calls()
		{
			$data=$this->db->query("select * from ems_ambulance where amb_status = 2 OR amb_status = 4 OR amb_status = 5 OR amb_status = 6 OR amb_status = 7 OR amb_status = 8 OR amb_status = 9 OR amb_status = 10 ");
            if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
		}

	public function total_closed_calls()
		{
			$data=$this->db->query("select * from ems_ambulance where amb_status = 2 OR amb_status = 4 OR amb_status = 5 OR amb_status = 6 OR amb_status = 7 OR amb_status = 8 OR amb_status = 9 OR amb_status = 10 ");
            if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
			
		}

	public function queue_calls()
		{
			$data=$this->db->query("select * from ems_ambulance where amb_status = 2 OR amb_status = 4 OR amb_status = 5 OR amb_status = 6 OR amb_status = 7 OR amb_status = 8 OR amb_status = 9 OR amb_status = 10 ");
            if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
			
		}

	public function total_dispatch_queue()
		{
			$data=$this->db->query("select * from ems_ambulance where amb_status = 2 OR amb_status = 4 OR amb_status = 5 OR amb_status = 6 OR amb_status = 7 OR amb_status = 8 OR amb_status = 9 OR amb_status = 10 ");
            if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
			
		}

	public function get_data(){

        $data=$this->db->query("SELECT EXTRACT(YEAR FROM inc_datetime) as year,(SELECT COUNT(*) FROM ems_incidence WHERE incis_deleted IN ('0','2') AND inc_set_amb = '1') as emergency_calls, (SELECT COUNT(*) FROM ems_incidence WHERE inc_type='MCI') as mas_cas_calls, (SELECT COUNT(*) FROM ems_incidence WHERE inc_type ='EMT_MED_AD') as medical_advice, (SELECT COUNT(*) FROM ems_incidence WHERE inc_type ='IN_HO_P_TR') as hosp_to_hosp, (SELECT COUNT(*) FROM ems_incidence WHERE inc_set_amb = '0') as non_emergency_calls FROM ems_incidence GROUP BY inc_datetime LIMIT 1") ;
        //echo $this->db->last_query();
       // die();
        if($data->result()){
            return $data->result();
        }else{
            return 0;
        }
  		}
    public function get_districts_names($div = ''){
        if($div != ""){
            $where = 'AND div_code = '.$div.'';
        }else{
            $where = "";
        }
        $data=$this->db->query('SELECT * FROM `ems_mas_districts` where dst_state="MH" '.$where.' ');
        //echo $this->db->last_query(); die;
        if($data->result()){
            return $data->result();
        }else{
            return 0;
        }
    }
    public function get_amb_data(){
        
        $data=$this->db->query('SELECT * FROM `ems_ambulance` where amb_user="108" ');
        //echo $this->db->last_query(); die;
        if($data->result()){
            return $data->result();
        }else{
            return 0;
        }
    }
    public function get_dist_travel_data(){
        $data=$this->db->query('SELECT * FROM `ems_districtwise_total_km` where is_deleted="1" ');
        if($data->result()){
            return $data->result();
        }else{
            return 0;
        }
    }
    public function get_districts_names1(){
        
       // $data=$this->db->query('SELECT * FROM `ems_mas_districts` where dst_state="MH" '.$where.' ');
        $data=$this->db->query('SELECT * FROM `ems_mas_districts` where dst_state="MH" order by dst_name ASC');
        //echo $this->db->last_query(); die;
        if($data->result()){
            return $data->result();
        }else{
            return 0;
        }
    }
    public function get_districts_names_jammu_div_wise(){
        $data=$this->db->query('SELECT * FROM `ems_mas_districts` where dst_state="MH" and div_code=1');
        if($data->result()){
            return $data->result();
        }else{
            return 0;
        }
    }
    
    public function get_state_names(){
        $data=$this->db->query('SELECT * FROM `ems_mas_states` where st_code="MH"');
        if($data->result()){
            return $data->result();
        }else{
            return 0;
        }
    }
    public function get_division_names(){
        $data=$this->db->query('SELECT * FROM `ems_mas_division`');
        if($data->result()){
            return $data->result();
        }else{
            return 0;
        }
    }

    function accident_motorcycle($inc_complaint, $param)
    {
        // $ci =& get_instance();
        // $ci->load->database();

        if (!empty($param)) {
        	$where = '';
        	if ($param == 'thismonth') {
        		$where='AND MONTH(STR_TO_DATE(`date`,"%m/%d/%Y")) = MONTH(CURRENT_DATE()) AND YEAR(STR_TO_DATE(`date`,"%m/%d/%Y")) = YEAR(CURRENT_DATE())';
        	} else if ($param == 'today') {
        		$where='AND STR_TO_DATE(`date`,"%m/%d/%Y") = CURRENT_DATE()';
        	} else if ($param == 'tillDate') {
                $where='AND STR_TO_DATE(`date`,"%Y/%m/%d") > "03/23/2020 23:23:59"';
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

    
//function count_till_date($args = array()){
//     $sql="select COUNT(*) from ems incidence where incis_deleted IN ('0','2') AND inc_datetime BETWEEN ".$args['from_date']." AND ".$args['to_date']." "; 
//    $query = $this->db->get($sql);
//    if ( $query->num_rows() > 0 )
//    {
//        $row = $query->result();
//        return $row;
//    }
//}
function count_till_date($args){
        $this->db->select('*');
        $this->db->from('ems_incidence');
        $where = array('0', '2');
        $this->db->where_in('incis_deleted', $where);
        $this->db->where('inc_datetime >=', $args['live_from_date']);
        $this->db->where('inc_datetime <=', $args['to_date']);
        
        if($args['system_type'] == '108'){
            $this->db->where('inc_system_type', $args['system_type']);
        }else if($args['system_type'] == '102'){
            $this->db->where('inc_system_type', $args['system_type']);
        }
        $query = $this->db->get();
        if($query->num_rows()){
            $row = $query->result();
            return $query->num_rows();
        }else{
            return 0;
        }
 }   
function update_data($rec_id, $result){
    $this->db->where('rec_id', $rec_id);
    $this->db->update('ems_dashboard', $result);
   // echo $this->db->last_query();die;
    return true;

}
function dash_insert_data($result){

    $result = $this->db->insert('ems_dash_data', $result);
    // echo $this->db->last_query(); die;
    if ($result) {
         return $result;
    } else {
         return false;
    }


}
function eme_count_till_date($args){
        $this->db->select('*');
        $this->db->from('ems_incidence');
        $where = array('0', '2');
        $this->db->where_in('incis_deleted', $where);
        $this->db->where('inc_set_amb', '1');
        $this->db->where('inc_datetime >=', $args['live_from_date']);
        $this->db->where('inc_datetime <=', $args['to_date']);
        if($args['system_type'] == '108'){
            $this->db->where('inc_system_type', $args['system_type']);
        }else if($args['system_type'] == '102'){
            $this->db->where('inc_system_type', $args['system_type']);
        }
        $query = $this->db->get();
    // $sql="SELECT * FROM `ems_incidence` WHERE inc_set_amb = '1' AND incis_deleted IN ('0','2') AND inc_datetime BETWEEN ".$args['from_date']." AND ".$args['to_date']." "; 
    // $query = $this->db->get($sql);
        if ($query->num_rows())
            {
                $row = $query->result();
                return $query->num_rows();
            }else{
                return 0;
            }
}

function noneme_count_till_date($args){
        $this->db->select('*');
        $this->db->from('ems_incidence');
        $where = array('0');
        $this->db->where_in('incis_deleted', $where);
        $this->db->where('inc_set_amb', '0');
        $this->db->where('inc_datetime >=', $args['live_from_date']);
        $this->db->where('inc_datetime <=', $args['to_date']);
        $query = $this->db->get();
    // $sql="SELECT * FROM `ems_incidence` WHERE inc_set_amb = '0' AND incis_deleted IN ('0','2') AND inc_datetime BETWEEN ".$args['from_date']." AND ".$args['to_date']." "; 
    // $query = $this->db->get($sql);
        if ($query->num_rows())
        {
            $row = $query->result();
            return $query->num_rows();
        }else{
            return 0;
        }
}

function dispatch_till_date($args){
        $this->db->select('*');
        $this->db->from('ems_incidence');
        $where = array('0');
        $this->db->where_in('incis_deleted', $where);
        $this->db->where('inc_set_amb', '1');
        $this->db->where('inc_datetime >=', $args['live_from_date']);
        $this->db->where('inc_datetime <=', $args['to_date']);
        if($args['system_type'] == '108'){
            $this->db->where('inc_system_type', $args['system_type']);
        }else if($args['system_type'] == '102'){
            $this->db->where('inc_system_type', $args['system_type']);
        }
        $query = $this->db->get();
    // $sql="SELECT * FROM `ems_incidence` WHERE inc_set_amb = '1' AND incis_deleted IN ('0') AND inc_datetime BETWEEN ".$args['live_from_date']." AND ".$args['to_date']." ";   
    // $query = $this->db->get($sql);
        if ($query->num_rows())
        {
            $row = $query->result();
            return $query->num_rows();
        }else{
            return 0;
        }
}
function total_km_today($args){
    if($args['from_date'] = '' && $args['to_date'] = ''){
        $condition='AND timestamp BETWEEN  DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY),"%m/01/%Y") AND DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY),"%m/15/%Y")';
    }
    if($args['dst_code']!='')
    {
        $condition=' AND amb_district = '.$args['dst_code'].' ';
    }
    $sql='SELECT min(start_odmeter*1) as start_odmeter,max(end_odmeter*1) as end_odmeter,sum(total_km) as total,ems_ambulance.amb_rto_register_no  FROM ems_ambulance left join ems_ambulance_timestamp_record on (ems_ambulance_timestamp_record.amb_rto_register_no=ems_ambulance.amb_rto_register_no) where  ems_ambulance_timestamp_record.flag =1 '.$condition.' group by ems_ambulance.amb_rto_register_no';
    $result = $this->db->query($sql);
    if($args['get_count']) {
        return $result->num_rows();
    } else {
        return $result->result();
    }
}
function total_km_tillmonth($args = array()){
    if($args['from_date'] != '' && $args['to_date'] != ''){
        $from_date = $args['from_date'];
        $to_date = $args['to_date'];
        $condition .= "AND timestamp BETWEEN '$from_date' AND  '$to_date'";
    }
    if($args['dst_code']!='')
    {
        $condition .=' AND amb_district = '.$args['dst_code'].' ';
    }
    $sql='SELECT min(start_odmeter*1) as start_odmeter,max(end_odmeter*1) as end_odmeter,sum(total_km) as total,ems_ambulance.amb_rto_register_no  FROM ems_ambulance left join ems_ambulance_timestamp_record on (ems_ambulance_timestamp_record.amb_rto_register_no=ems_ambulance.amb_rto_register_no) where  ems_ambulance_timestamp_record.flag =1 '.$condition.' group by ems_ambulance.amb_rto_register_no';
//    echo $sql;
//    die();
    $result = $this->db->query($sql);
    if($args['get_count']) {
        return $result->num_rows();
    } else {
        return $result->result();
    }
}
function total_km_tilldate(){
    if($args['from_date'] = '' && $args['to_date'] = ''){
        $condition='AND timestamp BETWEEN  DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY),"%m/01/%Y") AND DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY),"%m/15/%Y")';
    }
    if($args['dst_code']!='')
    {
        $condition=' AND amb_district = '.$args['dst_code'].' ';
    }
    $sql='SELECT min(start_odmeter*1) as start_odmeter,max(end_odmeter*1) as end_odmeter,sum(total_km) as total,ems_ambulance.amb_rto_register_no  FROM ems_ambulance left join ems_ambulance_timestamp_record on (ems_ambulance_timestamp_record.amb_rto_register_no=ems_ambulance.amb_rto_register_no) where  ems_ambulance_timestamp_record.flag =1 '.$condition.' group by ems_ambulance.amb_rto_register_no';
    $result = $this->db->query($sql);
    if($args['get_count']) {
        return $result->num_rows();
    } else {
        return $result->result();
    }
}
function insert_total_km_data($args){
    $result = $this->db->insert('ems_districtwise_total_km', $args);
    //echo $this->db->last_query(); die;
    if ($result) {
         return $result;
    } else {
         return false;
    }
}
function update_total_km_data($args){
    $this->db->where("dst_code", $args['dst_code']);
    $res = $this->db->update('ems_districtwise_total_km', $args);
    //echo $this->db->last_query(); die;
    if ($res) {
        return $res;
    } else {
         return false;
    }
}
function closure_till_date($args){
    $pro_id = 'provider_impressions  NOT IN ("21","41","42","43","44")';
        $this->db->select('*');
        $this->db->from('ems_epcr');
        $this->db->where('epcris_deleted', '0');
        $this->db->where($pro_id);
        if($args['live_from_date'] != ''){
            $this->db->where('STR_TO_DATE(`date`,"%m/%d/%Y") >=', $args['live_from_date']);
        }
        $this->db->where('STR_TO_DATE(`date`,"%m/%d/%Y") <=', $args['to_date']);
        
       
        $query = $this->db->get();
    //$sql = 'SELECT * FROM `ems_epcr` WHERE epcris_deleted="0" AND STR_TO_DATE(`ems_epcr`.`date`,"%m/%d/%Y") BETWEEN ='.$args['live_from_date'].' AND '.$args['to_date'].'';
    // $sql='SELECT * FROM `ems_epcr` WHERE epcris_deleted="0" AND STR_TO_DATE(`date`,"%m/%d/%Y") >= "2020-03-23"'; 
    // $query = $this->db->get($sql);

        if ($query->num_rows())
        {
            $row = $query->result();
            return $query->num_rows();
        }else{
            return 0;
        }

}
function closure_till_date_all($args){
        $this->db->select('*');
        $this->db->from('ems_epcr');
        $this->db->where('epcris_deleted', '0');
        $this->db->where('STR_TO_DATE(`date`,"%m/%d/%Y") <=', $args['to_date']);
        $query = $this->db->get();
    //$sql = 'SELECT * FROM `ems_epcr` WHERE epcris_deleted="0" AND STR_TO_DATE(`ems_epcr`.`date`,"%m/%d/%Y") BETWEEN ='.$args['live_from_date'].' AND '.$args['to_date'].'';
    // $sql='SELECT * FROM `ems_epcr` WHERE epcris_deleted="0" AND STR_TO_DATE(`date`,"%m/%d/%Y") >= "2020-03-23"'; 
    // $query = $this->db->get($sql);
//echo $this->db->last_query(); die;
        if ($query->num_rows())
        {
            $row = $query->result();
            return $query->num_rows();
        }else{
            return 0;
        }

}

function get_total_data(){
    $sql = "select SUM(patient_servedold1_td) as patient_servedold1_td,SUM(patient_servedold_td) as patient_servedold_td,SUM(patient_served_today) as patient_served_today,SUM(dispatch_today_108) as dispatch_today_108,SUM(patient_served_tm) as patient_served_tm,SUM(patient_served_td) as patient_served_td,SUM(dispatch_today_102) as dispatch_today_102,SUM(dispatch_tm) as dispatch_tm,SUM(dispatch_td) as dispatch_td from ems_nhm_data ";
    $result = $this->db->query($sql);
    //echo $this->db->last_query();die;
    return $result->result();

}
function get_div_data(){
    $sql = "SELECT *"
        . " FROM ems_mas_division"
        . " Where div_deleted = '0'";
        $result = $this->db->query($sql);
       // echo $this->db->last_query();die;
    if ($result) {
        return $result->result();
    } else {
        return false;
    }
}
function get_total_division_data($args = array()){
    $sql = "select  SUM(patient_servedold_td) as patient_servedold_td,SUM(patient_served_today) as patient_served_today,SUM(dispatch_today_108) as dispatch_today_108,SUM(patient_served_tm) as patient_served_tm,SUM(patient_served_td) as patient_served_td,SUM(dispatch_today_102) as dispatch_today_102,SUM(dispatch_tm) as dispatch_tm,SUM(dispatch_td) as dispatch_td from ems_nhm_data where div_code='".$args['division_code']."'";
    
    $result = $this->db->query($sql);
    //echo $this->db->last_query();die;
    return $result->result();
}
function update_division_calls($args=array()){
      $this->db->select('*');
        $this->db->from("ems_division_dashboard");
// $this->db->where("$this->tbl_incidence.inc_cl_id" , $args['inc_cl_id']);
        $this->db->where("ems_division_dashboard.division_code", $args['division_code']);
        $fetched = $this->db->get();
        $present = $fetched->result();
        if (count($present) == 0) {

            $result = $this->db->insert('ems_division_dashboard', $args);
          // echo $this->db->last_query();
          // die();
            if ($result) {
                return $this->db->insert_id();
            } else {
                return false;
            }
        } else {

            $this->db->where_in('division_code', $args['division_code']);
            $data = $this->db->update("ems_division_dashboard", $args);
            return $data;
        }
            

}
function get_dis_data($args = array()){
    $sql = "select * from ems_mas_districts where div_id='".$args['division_code']."' AND dstis_deleted='0'";
    $result = $this->db->query($sql);
   // echo $this->db->last_query();die;
    return $result->result();
}
function get_dis_data_new($args = array()){
    $sql = "select * from ems_mas_districts where dst_state='".$args['dst_state']."' AND dstis_deleted='0'";
    $result = $this->db->query($sql);
   // echo $this->db->last_query();die;
    return $result->result();
}
function get_ambulance_data($args = array()){
    if($args['amb_user'] == '108'){
        $condition = "AND amb.amb_user='108'";
    }
    if($args['amb_user'] == '102'){
        $condition = "AND amb.amb_user='102'";
    }
    $sql = "select hp.hp_name,amb.amb_id,amb.amb_rto_register_no,amb.amb_district from ems_ambulance as amb
    LEFT JOIN ems_hospital as hp ON hp.hp_id = amb.amb_base_location
    where  amb.amb_district='".$args['dst_code']."' $condition";
    $result = $this->db->query($sql);
   // echo $this->db->last_query();die;
    return $result->result();
}
function get_ambulance_distance($args = array()){
    $condition ='';
    if($args['to'] != '' && $args['from'] != ''){
        $condition = "AND timestamp BETWEEN '".$args['to']." 00:00:00' AND  '".$args['from']." 23:59:59'";
    }
    
    $sql = "select min(start_odmeter*1) as start_odometer,max(end_odmeter*1) as end_odometer from ems_ambulance_timestamp_record where amb_rto_register_no='".$args['amb_rto_register_no']."' AND start_odmeter != '' AND end_odmeter != ''  $condition";
    $result = $this->db->query($sql);
    //echo $this->db->last_query();die;
    return $result->result();
}
function get_total_district_data($args = array()){
    //var_dump($args['dst_code']);
    if($args['dst_code'] != ''){
        $condition = "AND dst_code='".$args['dst_code']."' ";
    }
    $sql = "select  SUM(patient_servedold1_td) as patient_servedold1_td,SUM(patient_served_today) as patient_served_today, SUM(dispatch_today_108) as dispatch_today_108,SUM(patient_served_tm) as patient_served_tm,SUM(patient_served_td) as patient_served_td,SUM(patient_servedold_td) as patient_servedold_td,SUM(dispatch_today_102) as dispatch_today_102,SUM(dispatch_tm) as dispatch_tm,SUM(dispatch_td) as dispatch_td from ems_nhm_data where 1=1 $condition  ";
    $result = $this->db->query($sql);
    //echo $this->db->last_query();die;
    return $result->result();
}
function get_total_amb_data($args = array()){
    
    $sql = "select  SUM(patient_served_today) as patient_served_today, SUM(patient_served_tm) as patient_served_tm,SUM(patient_served_td) as patient_served_td from ems_nhm_amb_data where 	amb_no='".$args['amb_rto_register_no']."' ";
    $result = $this->db->query($sql);
    echo $this->db->last_query();die;
    return $result->result();
}
function get_nhm_data(){
        $this->db->select('n.* , d.dst_name');
        $this->db->from('ems_nhm_data n');
        $this->db->join('ems_mas_districts d', 'n.dst_code = d.dst_code', 'left');
        $query = $this->db->get();
        //echo $this->db->last_query();die;

        if ($query->num_rows())
        {
            return $query->result_array();
            
             
        }else{
            return 0;
        }
}

function get_division($args = array(),$limit = '', $offset = ''){
        
    if (isset($args['st_id']) && $args['st_id'] != "") {

        $condition .= " AND div_state='" . $args['st_id'] . "'";
    }
     if (isset($args['st_id']) && $args['st_id'] != "") {

        $condition .= " AND div_state='" . $args['st_id'] . "'";
    }
    if (isset($args['div_code']) && $args['div_code'] != "") {

        $condition .= " AND div_code='" . $args['div_code'] . "'";
    }
    if (trim($args['term']) != '') {

        $condition .= " AND div_name LIKE'" . trim($args['term']) . "%' ";
    }   
    
    
    $sql = "SELECT *"
    . " FROM ems_mas_division "
    . "Where div_deleted = '0' $condition";


$result = $this->db->query($sql);

//echo $this->db->last_query();die;

if ($result) {
    return $result->result();
} else {
    return false;
}

}

function get_ambulance($args = array(), $limit = '', $offset = '') {

    if ($offset >= 0 && $limit > 0) {

        $lim_off = " limit $limit offset $offset ";
    }

    if (isset($args['amb_id']) && $args['amb_id'] != "") {

        $condition .= "AND amb.amb_id='" . $args['amb_id'] . "'";
    }

    if (isset($args['amb_district']) && $args['amb_district'] != "") {

        $condition .= "AND amb.amb_district='" . $args['amb_district'] . "'";
    }
     if (isset($args['amb_user']) && $args['amb_user'] != "") {

        $condition .= "AND amb.amb_user='" . $args['amb_user'] . "'";
    }

    if (isset($args['amb_state']) && $args['amb_state'] != "") {

        $condition .= "AND amb.amb_state='" . $args['amb_state'] . "'";
    }
    if (isset($args['amb_rto_register_no']) && $args['amb_rto_register_no'] != "") {

        $condition .= "AND amb.amb_rto_register_no='" . $args['amb_rto_register_no'] . "'";
    }



    if (trim($args['term']) != '') {

        $condition .= " AND amb.amb_rto_register_no LIKE '%" . trim($args['term']) . "%' ";
    }

     $sql = "SELECT amb.amb_rto_register_no, amb.amb_district, amb.amb_id "
        . " FROM ems_ambulance as amb "
        . "Where ambis_deleted = '0' $condition $oby $lim_off";



    $result = $this->db->query($sql);


    if ($result) {
        return $result->result();
    } else {
        return false;
    }
}
	function insert_b12_report($key,$value){


        
		     $result = $this->db->query("INSERT INTO ems_b12_data(`b12_key`,`b12_value`) VALUES('".$key."','".$value."') ON DUPLICATE KEY UPDATE `b12_value`='".$value."'");           

             
	    	 if($result){
		    	return true;
		     }else{
			    return false;
		     }
	}   
    function insert_b12_report_tm($key,$value){
        $result = $this->db->query("INSERT INTO ems_b12_data(`b12_key`,`b12_tm_value`) VALUES('".$key."','".$value."') ON DUPLICATE KEY UPDATE `b12_tm_value`='".$value."'");           
      // echo $this->db->last_query();
     //  die();
        if($result){
		    	return true;
		     }else{
			    return false;
		     }
    }
    function insert_b12_report_pre2day($key,$value){
        $result = $this->db->query("INSERT INTO ems_b12_data(`b12_key`,`b12_pre_two_day`) VALUES('".$key."','".$value."') ON DUPLICATE KEY UPDATE `b12_pre_two_day`='".$value."'");           
       //echo $this->db->last_query();
     //  die();
        if($result){
		    	return true;
		     }else{
			    return false;
		     }
    }
    function insert_b12_report_new($key,$value){


        
        $result = $this->db->query("INSERT INTO ems_b12_data_new(`b12_key`,`b12_value`) VALUES('".$key."','".$value."') ON DUPLICATE KEY UPDATE `b12_value`='".$value."'");           

        
        if($result){
           return true;
        }else{
           return false;
        }
}
    function insert_b12_report_tm_new($key,$value){
        $result = $this->db->query("INSERT INTO ems_b12_data_new(`b12_key`,`b12_tm_value`) VALUES('".$key."','".$value."') ON DUPLICATE KEY UPDATE `b12_tm_value`='".$value."'");           
      //echo $this->db->last_query();
     //  die();
        if($result){
		    	return true;
		     }else{
			    return false;
		     }
    }
    function get_b12_report_pre2day($b12_key){
        $query_obl = $this->db->query('SELECT opt.* FROM ems_b12_data as opt WHERE opt.`b12_key`="'.$b12_key.'"');
      // echo $this->db->last_query();
        //die();
        $result = $query_obl->result();
        
        if($result){
           return $result[0]->b12_pre_two_day;
        }else{
           return false;
        }
    }
    function get_b12_report_tm($b12_key){
        $query_obl = $this->db->query('SELECT opt.* FROM ems_b12_data as opt WHERE opt.`b12_key`="'.$b12_key.'"');
      // echo $this->db->last_query();
        //die();
        $result = $query_obl->result();
        
        if($result){
           return $result[0]->b12_tm_value;
        }else{
           return false;
        }
    }
    function get_b12_report($b12_key){
		   
		     $query_obl = $this->db->query('SELECT opt.* FROM ems_b12_data as opt WHERE opt.`b12_key`="'.$b12_key.'"');
             //echo $this->db->last_query();
             //die();
		     $result = $query_obl->result();
             
	    	 if($result){
		    	return $result[0]->b12_value;
		     }else{
			    return false;
		     }
			 
	}


    public function total_dispatch_status()
    {
        $to_date = date('Y-m-d');
        $from_date = date('Y-m-d');
        $condition ='';
        $condition = " inc.inc_datetime BETWEEN '".$to_date." 00:00:00' AND  '".$from_date." 23:59:59'";
        
        $sql = "select driver_para.*, inc.* ,inc_amb.* from ems_incidence_ambulance AS inc_amb
        LEFT JOIN ems_incidence AS inc ON inc.inc_ref_id = inc_amb.inc_ref_id 
         LEFT JOIN ems_driver_parameters as driver_para ON inc.inc_ref_id = driver_para.incident_id where $condition";

        $result = $this->db->query($sql);
        //  echo $this->db->last_query();die;
        return $result->result();
        
    }
    
    

    


    // public function total_dispatch_till_date_count()
    // {
    //     $to_date = "2021-05-31";
    //     $from_date = date('Y-m-d');
    //     $condition ='';
    //     $condition = " inc.inc_datetime BETWEEN '".$to_date." 00:00:00' AND  '".$from_date." 23:59:59'";
        
    //     $sql = "select driver_para.*, inc.* ,inc_amb.* from ems_incidence_ambulance AS inc_amb
    //     LEFT JOIN ems_incidence AS inc ON inc.inc_ref_id = inc_amb.inc_ref_id 
    //      LEFT JOIN ems_driver_parameters as driver_para ON inc.inc_ref_id = driver_para.incident_id where $condition";

    //     $result = $this->db->query($sql);
    //     //  echo $this->db->last_query();die;
    //     return $result->result();
        
    // }

    public function total_amb_status($args = array())
    {
        $current_date = $args['from_date'];
        $select_time = $args['select_time'];
        //$select_time = '4';
        $sql = "select SUM(amb_count) as total_amb_count,SUM(off_road_doctor) as total_off_road_doctor,SUM(total_offroad) as total_total_offroad from ems_district_wise_offroad where district_name !='Total' AND (added_date BETWEEN '$current_date 00:00:00' AND '$current_date 23:59:59') AND select_time = '$select_time'";
        
        //echo $sql;
        //die();

        $result = $this->db->query($sql);
        
        return $result->result();
    
    }
    public function get_visitors_data()
        {   
            $data=$this->db->query("SELECT * FROM `ems_clg_logins` WHERE `clg_ref_id` LIKE '%MEMS%'");
            //echo $this->db->last_query(); die;
            if($data->num_rows()){
                return $data->num_rows();
            }else{
                return 0;
            }
	
        }
        function insert_b12data_dash_report($key,$value){
            $result = $this->db->query("INSERT INTO ems_b12_data_dash_report(`b12_key`,`b12_value`) VALUES('".$key."','".$value."') ON DUPLICATE KEY UPDATE `b12_value`='".$value."'");           
            if($result){
                return true;
            }else{
                return false;
            }
        }   
        function insert_b12data_dash_report_tm($key,$value){
            $result = $this->db->query("INSERT INTO ems_b12_data_dash_report(`b12_key`,`b12_tm_value`) VALUES('".$key."','".$value."') ON DUPLICATE KEY UPDATE `b12_tm_value`='".$value."'");    
             
            if($result){
               return true;
            }else{
               return false;
            }
        }
        function insert_b12data_dash_report_pre2day($key,$value){
            $result = $this->db->query("INSERT INTO ems_b12_data_dash_report(`b12_key`,`b12_pre_two_day`) VALUES('".$key."','".$value."') ON DUPLICATE KEY UPDATE `b12_pre_two_day`='".$value."'");           
            if($result){
                return true;
            }else{
                return false;
            }
        }
        function get_b12_report_pre2day_new($b12_key){
            $query_obl = $this->db->query('SELECT opt.* FROM ems_b12_data_dash_report as opt WHERE opt.`b12_key`="'.$b12_key.'"');
            $result = $query_obl->result();
            if($result){
               return $result[0]->b12_pre_two_day;
            }else{
               return false;
            }
        }
        function get_b12_report_tm_new($b12_key){
            $query_obl = $this->db->query('SELECT opt.* FROM ems_b12_data_dash_report as opt WHERE opt.`b12_key`="'.$b12_key.'"');
            $result = $query_obl->result();
            if($result){
               return $result[0]->b12_tm_value;
            }else{
               return false;
            }
        }
        function get_b12_report_new($b12_key){
                $query_obl = $this->db->query('SELECT opt.*,(b12_value + b12_value1) as total FROM ems_b12_data_dash_report as opt WHERE opt.`b12_key`="'.$b12_key.'"');
                $result = $query_obl->result();
                 
                 if($result){
                    return $result[0]->total;
                 }else{
                    return false;
                 }
                 
        }

}