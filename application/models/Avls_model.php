<?php

class Avls_model extends CI_Model {

    public $tbl_mas_user_groups, $tbl_colleagues, $tbl_country, $tbl_state, $tbl_city;

    function __construct() {
        parent::__construct();
        $this->load->helper('date');
        $this->load->database();
        $this->tbl_hp = $this->db->dbprefix('hospital1');
        $this->tbl_hp_bed = $this->db->dbprefix('hos_bed_avaibility ');
    }
    function getIncidentWiseLatLng($args){
        $condition =  '';
        if($args['incidentId'] != ""){
            $condition .= " latlng.incidenceId='" . $args['incidentId'] . "' ";
        }
        $condition .= " AND latlng.lat > 0";
        $condition .= " AND latlng.long > 0";
        $condition .= " AND latlng.speed >= 10";
		$this->db->select('lat,long,speed,packetdatetime,vehicleNumber');
		$this->db->from('ems_mas_amb_latlong as latlng');
        $this->db->where($condition);
        //$this->db->where('latlng.speed > 0');
        //$this->db->where('ignition','Ignition On');
        $data = $this->db->get()->result_array();
        return $data;
    }
    // function getIncidentdata($args){
    //     $condition =  '';
    //     if($args['incidentId'] != ""){
    //         $condition .= " latlng.incidenceId='" . $args['incidentId'] . "' ";
    //     }
    //     // $condition .= " AND latlng.lat > 0";
    //     // $condition .= " AND latlng.long > 0";
    //     $condition .= " AND latlng.speed > 10";
	// 	$this->db->select('speed,packetdatetime,vehicleNumber');
	// 	$this->db->from('ems_mas_amb_latlong as latlng');
    //     $this->db->where($condition);
    //     //$this->db->where('latlng.speed > 0');
    //     //$this->db->where('ignition','Ignition On');
    //     $data = $this->db->get()->result_array();
    //     return $data;
    // }
    function get_ambulance($args = array()) {
        if (trim($args['term']) != '') {

            $condition .= " AND amb.amb_rto_register_no LIKE '%" . trim($args['term']) . "%' ";
        }
        $sql = "SELECT amb.*"
            . " FROM ems_ambulance as amb "
            . "Where ambis_deleted = '0' AND thirdparty != 1 $condition ";
            $result = $this->db->query($sql);
        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function getAmbWiseLatLng($args){
        $condition =  '';
        if($args['ambNo'] != ""){
            $condition .= " latlng.vehicleNumber='" . $args['ambNo'] . "' ";
        }

        if($args['frm_date'] != ""){
            $start_date= $args['frm_date']." 00:00:00";
            $end_date=$args['frm_date']." 23:59:59";
            $condition .= " AND latlng.packetdatetime BETWEEN '".$start_date."' AND '".$end_date."'";
        }
        $condition .= " AND latlng.lat > 0";
        $condition .= " AND latlng.long > 0";
        $condition .= " AND latlng.speed >= 10";
		$this->db->select('lat,long,speed,packetdatetime,vehicleNumber');
		$this->db->from('ems_mas_amb_latlong as latlng');
		$this->db->where($condition);
        //$this->db->where('ignition','Ignition On');
        // $this->db->where('latlng.speed > 0');
        $data = $this->db->get()->result_array();
        return $data;
    }
    public function get_live_tracking_data($args){
        $this->db->select('*');
		$this->db->from('ems_mas_amb_latlong as latlng');
        $this->db->where('latlng.vehicleNumber',$args['vehicleNo']);
        $this->db->order_by("latlng.id", "DESC");
        $this->db->limit(1);
        $data = $this->db->get()->result();
        return $data;
    }
    public function get_live_tracking_data1($args){
        $time = date('Y-m-d H:i:s', strtotime('-30 minute'));
        // echo $time;
        if($args['user'] == 'pilot'){
            $this->db->select('*');
            $this->db->from('ems_mas_amb_latlong as latlng');
            $this->db->where('latlng.vehicleNumber',$args['vehicleNo']);
            $this->db->where('latlng.pilot_id !=' , NULL);
           $this->db->where('latlng.packetdatetime >=' , $time);
            $this->db->order_by("latlng.id", "DESC");
            $this->db->limit(1);
            $data = $this->db->get()->result();
            return $data;
        }else if($args['user'] == 'emt'){
            $this->db->select('*');
            $this->db->from('ems_mas_amb_latlong as latlng');
            $this->db->where('latlng.vehicleNumber',$args['vehicleNo']);
            $this->db->where('latlng.emt_id !=' , NULL);
           $this->db->where('latlng.packetdatetime >=' , $time);
            $this->db->order_by("latlng.id", "DESC");
            $this->db->limit(1);
            $data = $this->db->get()->result();
            return $data;
        }
    }
    public function get_all_pilot_live_tracking_data($args){
        $time = date('Y-m-d H:i:s', strtotime('-30 minute'));
        $this->db->select('*');
        $this->db->from('ems_mas_amb_latlong as latlng');
        $this->db->where('latlng.vehicleNumber',$args['vehicleNo']);
        $this->db->where('latlng.pilot_id !=' , NULL);
        $this->db->where('latlng.packetdatetime >=' , $time);
        $this->db->order_by("latlng.id", "DESC");
        $this->db->limit(1);
        
        $data = $this->db->get()->result();
        // echo $this->db->last_query();die;
        return $data;
    }
    public function get_all_emt_live_tracking_data($args){
        $time = date('Y-m-d H:i:s', strtotime('-30 minute'));
        $this->db->select('*');
        $this->db->from('ems_mas_amb_latlong as latlng');
        $this->db->where('latlng.vehicleNumber',$args['vehicleNo']);
        $this->db->where('latlng.emt_id !=' , NULL);
       $this->db->where('latlng.packetdatetime >=' , $time);
        $this->db->order_by("latlng.id", "DESC");
        $this->db->limit(1);
        $data = $this->db->get()->result();
        return $data;
    }
    public function get_all_amb_live_tracking_data($args){
        $time = date('Y-m-d H:i:s', strtotime('-30 minute'));
        $this->db->select('amb.amb_rto_register_no,amb.amb_lat,amb.amb_log');
        $this->db->from('ems_ambulance as amb');
        $this->db->where('amb.amb_rto_register_no',$args['vehicleNo']);
        $this->db->where('amb.amb_lat !=' , NULL);
        $this->db->where('amb.amb_log !=' , NULL);
        // $this->db->where('amb.packetdatetime >=' , $time);
        // $this->db->order_by("amb.id", "DESC");
        $this->db->limit(1);
        $data = $this->db->get()->result();
        return $data;
    }
}