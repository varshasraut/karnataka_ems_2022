
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Supervisory_Display_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
public function getdisplaydata(){
		$this->db->select('amb.amb_rto_register_no,amb.amb_id,amb.amb_owner,amb.amb_type');
        $this->db->from('ems_ambulance as amb');
		
        $this->db->where('amb.ambis_deleted', '0');
		$this->db->where('amb.amb_type', '2');
		// $this->db->where('insp.id', $inspUnqId);
        $query = $this->db->get();
		// echo $this->db->last_query();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
}