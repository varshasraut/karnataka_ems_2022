<?php

class Inspection_model extends CI_Model {

    public $tbl_mas_user_groups, $tbl_colleagues, $tbl_country, $tbl_state, $tbl_city;

    function __construct() {
        parent::__construct();
        $this->load->helper('date');
        $this->load->database();
        $this->tbl_mas_store_groups = $this->db->dbprefix('mas_groups');
        $this->tbl_mas_amb_type = $this->db->dbprefix('mas_ambulance_type');
        $this->tbl_mas_amb_status = $this->db->dbprefix('mas_ambulance_status');
        $this->tbl_amb = $this->db->dbprefix('ambulance');
        $this->tbl_inc_amb = $this->db->dbprefix('incidence_ambulance');
        $this->tbl_mas_states = $this->db->dbprefix('mas_states');
        $this->tbl_mas_districts = $this->db->dbprefix('mas_districts');
        $this->tbl_mas_tahshil = $this->db->dbprefix('mas_tahshil');
        $this->tbl_mas_city = $this->db->dbprefix('mas_city');
        $this->tbl_driver_pcr = $this->db->dbprefix('driver_pcr');
        $this->tbl_replace = $this->db->dbprefix('amb_replacement_details');
        $this->tbl_odometer_detail = $this->db->dbprefix('amb_odometer_change_detail');
        $this->tbl_mas_area_types = $this->db->dbprefix('mas_area_types');
        $this->tbl_hp = $this->db->dbprefix('hospital');
        $this->tbl_ambulance_base = $this->db->dbprefix('ambulance_base');
        $this->tbl_default_team = $this->db->dbprefix('amb_default_team');
        $this->tbl_colleague = $this->db->dbprefix('colleague');
        $this->tbl_ambulance_timestamp_record = $this->db->dbprefix('ambulance_timestamp_record');
        $this->tbl_ambulance_status_summary = $this->db->dbprefix('ambulance_status_summary');
        $this->tbl_mas_odometer_remark = $this->db->dbprefix('mas_odometer_remark');
        $this->tbl_ambulance_stock = $this->db->dbprefix('ambulance_stock');
        $this->tbl_epcr = $this->db->dbprefix('epcr');
        $this->tbl_incidence = $this->db->dbprefix('incidence');
        $this->tbl_mas_patient_complaint_types = $this->db->dbprefix('mas_patient_complaint_types');
        $this->tbl_supervisor_remark = $this->db->dbprefix('supervisor_remark');
        $this->tbl_supervisor_release = $this->db->dbprefix('supervisor_release');
        $this->tbl_hos_bed_avaibility = $this->db->dbprefix('hos_bed_avaibility');
        $this->tbl_amb_replacement_details = $this->db->dbprefix('amb_replacement_details');
        $this->tbl_inv = $this->db->dbprefix('inventory');
        $this->tbl_invmd = $this->db->dbprefix('inventory_medicine');
        $this->tbl_mas_ward = $this->db->dbprefix('mas_ward');
        $this->tbl_ambid_reopen_details = $this->db->dbprefix('ambid_repen_details');
        $this->tbl_inspection_audit_details = $this->db->dbprefix('inspection_audit_details');
        $this->tbl_inspection_audit_med_details = $this->db->dbprefix('inspection_audit_med_details');
        $this->tbl_inspection_audit_equp_details = $this->db->dbprefix('inspection_audit_equp_details');
        $this->tbl_ins_gri_audit_details = $this->db->dbprefix('ins_gri_audit_details');
    }
    function get_ins_med_records($args = array(), $offset = '', $limit = ''){
        $condition = $offlim = '';
   
        if($args['ins_id']!=''){
            $condition .= "AND ins_med.ins_id ='" . $args['ins_id'] . "' "; 
        }
        if($args['med_id']!=''){
            $condition .= "AND ins_med.med_id ='" . $args['med_id'] . "' "; 
        }
        $sql = "SELECT * FROM ems_inspection_audit_med_details as ins_med "
        . " where  1=1  $condition $order_by  $offlim ";
        $result = $this->db->query($sql);
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    function get_ins_equip_records_new($args = array(), $offset = '', $limit = ''){
        $condition = $offlim = $order_by = '';
        //var_dump($args['ins_id']);die();
        if($args['ins_id']!=''){
            $condition .= "AND ins_eqp.ins_id ='" . $args['ins_id'] . "' "; 
        }
        if($args['eq_id'] !=''){
            $condition .= "AND ins_eqp.eqp_id ='" . $args['eq_id'] . "' "; 
        }
        $sql = "SELECT * FROM ems_inspection_audit_equp_details as ins_eqp "
        . " where  1=1  $condition $order_by  $offlim ";
        $result = $this->db->query($sql);
      // echo $this->db->last_query();
    //    return $result->result();

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function get_ins_equip_records($args = array(), $offset = '', $limit = ''){
        $condition = $offlim = $order_by = '';
        //var_dump($args['ins_id']);die();
        if($args['ins_id']!=''){
            $condition .= "AND ins_eqp.ins_id ='" . $args['ins_id'] . "' "; 
        }
        $sql = "SELECT * FROM ems_inspection_audit_equp_details as ins_eqp "
        . " where  1=1  $condition $order_by  $offlim ";
        $result = $this->db->query($sql);
    //   echo $this->db->last_query();die;
    //    return $result->result();

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    function get_ins_records_count($args = array(), $offset = '', $limit = ''){
        if($args['get_dist']!=''){
            $condition .= "AND ins.ins_dist ='" . $args['get_dist'] . "' "; 
        }
        if($args['clg_group'] == 'UG-INSPECTION_MOD'){
            if($args['clg_ref_id']!=''){
                $condition .= "AND ins.added_by ='" . $args['clg_ref_id'] . "' "; 
            }
        }
        $sql = "SELECT count(*) as total_count_ins FROM $this->tbl_inspection_audit_details as ins "
        . "where 1=1  $condition  $order_by  $offlim ";
        $result = $this->db->query($sql);
        return $result->result();
    }
    function get_gri_records_count($args = array(), $offset = '', $limit = ''){
        if($args['get_dist']!=''){
            $condition .= "AND ins.ins_dist ='" . $args['get_dist'] . "' "; 
        }
        if($args['clg_group'] == 'UG-INSPECTION_MOD'){
            if($args['clg_ref_id']!=''){
                $condition .= "AND ins.added_by ='" . $args['clg_ref_id'] . "' "; 
            }
        }
        $sql = "SELECT count(*) as total_count_gri FROM $this->tbl_inspection_audit_details as ins "
        . "where 1=1  $condition  $order_by  $offlim ";
        $result = $this->db->query($sql);
        return $result->result();
    }

    function get_ins_records_count_month($args = array(), $offset = '', $limit = ''){
        if($args['get_dist']!=''){
            $condition .= "AND ins.ins_dist ='" . $args['get_dist'] . "' "; 
        }
        if($args['clg_group'] == 'UG-INSPECTION_MOD'){
            if($args['clg_ref_id']!=''){
                $condition .= "AND ins.added_by ='" . $args['clg_ref_id'] . "' "; 
            }
        }
        $sql = "SELECT count(*) as total_count_ins_month FROM $this->tbl_inspection_audit_details as ins "
        . "where ins.ins_app_status = '2'  $condition  $order_by  $offlim ";
        $result = $this->db->query($sql);
        return $result->result();
    }
    function get_gri_records_count_month($args = array(), $offset = '', $limit = ''){
        if($args['get_dist']!=''){
            $condition .= "AND ins.ins_dist ='" . $args['get_dist'] . "' "; 
        }
        if($args['clg_group'] == 'UG-INSPECTION_MOD'){
            if($args['clg_ref_id']!=''){
                $condition .= "AND ins.added_by ='" . $args['clg_ref_id'] . "' "; 
            }
        }
        $sql = "SELECT count(*) as total_count_gri_month FROM $this->tbl_inspection_audit_details as ins "
        . "where ins.gri_status = '1'  $condition  $order_by  $offlim ";
        $result = $this->db->query($sql);
        return $result->result();
    }

    function get_ins_records_inprogress($args = array(), $offset = '', $limit = ''){
        if($args['get_dist']!=''){
            $condition .= "AND ins.ins_dist ='" . $args['get_dist'] . "' "; 
        }
        if($args['clg_group'] == 'UG-INSPECTION_MOD'){
            if($args['clg_ref_id']!=''){
                $condition .= "AND ins.added_by ='" . $args['clg_ref_id'] . "' "; 
            }
        }
        $sql = "SELECT count(*) as total_count_ins_progress FROM $this->tbl_inspection_audit_details as ins "
        . " where ins.ins_app_status = '1'  $condition  $order_by  $offlim ";
        $result = $this->db->query($sql);
        return $result->result();
    }
    function get_gri_records_inprogress($args = array(), $offset = '', $limit = ''){
        if($args['get_dist']!=''){
            $condition .= "AND ins.ins_dist ='" . $args['get_dist'] . "' "; 
        }
        if($args['clg_group'] == 'UG-INSPECTION_MOD'){
            if($args['clg_ref_id']!=''){
                $condition .= "AND ins.added_by ='" . $args['clg_ref_id'] . "' "; 
            }
        }
        $sql = "SELECT count(*) as total_count_gri_progress FROM $this->tbl_inspection_audit_details as ins "
        . " where ins.gri_status = '0'  $condition  $order_by  $offlim ";
        $result = $this->db->query($sql);
        return $result->result();
    }
    function get_ins_media_records($args = array(), $offset = '', $limit = ''){
        $condition = $offlim = '';
        // var_dump($args);die();
       /* if($args['ins_id']!=''){
            $condition .= "AND ins.insp_id ='" . $args['ins_id'] . "' "; 
        }
        if($args['get_dist']!=''){
            $condition .= "AND ins.ins_dist ='" . $args['get_dist'] . "' "; 
        }
        if($args['clg_ref_id']!=''){
            $condition .= "AND ins.added_by ='" . $args['clg_ref_id'] . "' "; 
        }*/
        $sql = "SELECT * from ems_insp_upload_file"
        . " where  1=1  $condition   $offlim ";
       $result = $this->db->query($sql);
        //echo $this->db->last_query();die;
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    function get_ins_records($args = array(), $offset = '', $limit = ''){
        $condition = $offlim = '';
        // var_dump($args);die();
        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit 50 offset $offset ";
        }
        if($args['ins_id']!=''){
            $condition .= "AND ins.id ='" . $args['ins_id'] . "' "; 
        }
        if($args['get_dist']!=''){
            $condition .= "AND ins.ins_dist ='" . $args['get_dist'] . "' "; 
        }
        if($args['clg_ref_id']!=''){
            $condition .= "AND ins.added_by ='" . $args['clg_ref_id'] . "' "; 
        }
        $sql = "SELECT ins.added_date as ins_added_date,ins.*,district.dst_name,get_clg.clg_first_name,get_clg.clg_mid_name,get_clg.clg_last_name FROM $this->tbl_inspection_audit_details as ins "
        . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = ins.ins_dist ) "
        . " LEFT JOIN ems_colleague as get_clg ON ( get_clg.clg_ref_id = ins.added_by ) "
        . " where  1=1 AND ins.is_deleted='1' AND ins.ins_app_status = '2' $condition ORDER BY ins.id DESC $offlim";
       $result = $this->db->query($sql);
    //echo $this->db->last_query();die;
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    function get_ins_gri_records($args = array()){
        $sql = "SELECT ins.*,gri_type.grievance_type,gri_sub_type.grievance_sub_type FROM $this->tbl_ins_gri_audit_details as ins "
        . " LEFT JOIN ems_mas_grievance_type as gri_type ON ( gri_type.grievance_id = ins.grievance_type ) "
        . " LEFT JOIN ems_mas_grievance_sub_type as gri_sub_type ON ( gri_sub_type.g_id = ins.grievance_sub_type ) "
        . " where ins.status='0' order by ins.added_date DESC ";
       $result = $this->db->query($sql);
       //echo $this->db->last_query();die;
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    function get_gri_comp_records_count($args = array())
    {
        $condition = $offlim = '';
        if($args['get_dist']!=''){
            $condition .= "AND gri.ins_dist ='" . $args['get_dist'] . "' "; 
        }
        if($args['clg_group'] == 'UG-INSPECTION_MOD'){
            if($args['clg_ref_id']!=''){
                $condition .= "AND ins.added_by ='" . $args['clg_ref_id'] . "' "; 
            }
        }
        
        $sql = "SELECT count(*) as total_count_comp_gri FROM ems_ins_gri_audit_details as gri "
        . " where  1=1 $condition $order_by  $offlim ";
       $result = $this->db->query($sql);
    //    echo($result);die;
    //    echo $this->db->last_query();die;
        return $result->result();
    }
    function update_ins($args){
        // $updateArray['is_deleted']='2';
        $updateArray['gri_status']='1';
        $this->db->where('id', $args['ins_id']);
        $update = $this->db->update($this->tbl_inspection_audit_details, $updateArray);
        // echo $this->db->last_query();die;
        if ($update) {
        return true;
        } else {
    
            return false;
        }
    }
    // function get_gri_records_count($args = array(), $offset = '', $limit = ''){
    //     $condition = $offlim = '';
    //     if($args['get_dist']!=''){
    //         $condition .= "AND ins.ins_dist ='" . $args['get_dist'] . "' "; 
    //     }
    //     if($args['clg_group'] == 'UG-INSPECTION_MOD'){
    //         if($args['clg_ref_id']!=''){
    //             $condition .= "AND ins.added_by ='" . $args['clg_ref_id'] . "' "; 
    //         }
    //     }
    //     $sql = "SELECT count(*) as total_count_gri FROM $this->tbl_inspection_audit_details as ins "
    //     . " where 1=1 AND forword_grievance='2' $condition $order_by  $offlim ";
    //    $result = $this->db->query($sql);
    // //    echo $this->db->last_query();die;
    //     if ($args['get_count']) {

    //         return $result->num_rows();
    //     } else {

    //         return $result->result();
    //     }
    // }
   
    // function get_gri_records_count_month($args = array(), $offset = '', $limit = ''){
    //     $condition = $offlim = '';
    //     if($args['get_dist']!=''){
    //         $condition .= "AND ins.ins_dist ='" . $args['get_dist'] . "' "; 
    //     }
    //     if($args['clg_group'] == 'UG-INSPECTION_MOD'){
    //         if($args['clg_ref_id']!=''){
    //             $condition .= "AND ins.added_by ='" . $args['clg_ref_id'] . "' "; 
    //         }
    //     }
        
    //     $sql = "SELECT count(*) as total_count_gri_month FROM $this->tbl_inspection_audit_details as ins "
    //     . " where  (added_date between DATE_FORMAT(NOW(),'%Y-%m-01') and NOW()) AND ins.gri_status = '1'  AND forword_grievance='2' $condition $order_by  $offlim ";
    //    $result = $this->db->query($sql);
    // //    echo $this->db->last_query();die;
    //     if ($args['get_count']) {

    //         return $result->num_rows();
    //     } else {

    //         return $result->result();
    //     }
    // }
    function get_gri_records_count_progress($args = array(), $offset = '', $limit = ''){
        $condition = $offlim = '';
        if($args['get_dist']!=''){
            $condition .= "AND ins.ins_dist ='" . $args['get_dist'] . "' "; 
        }
        if($args['clg_group'] == 'UG-INSPECTION_MOD'){
            if($args['clg_ref_id']!=''){
                $condition .= "AND ins.added_by ='" . $args['clg_ref_id'] . "' "; 
            }
        }
        
        $sql = "SELECT count(*) as total_count_gri_month FROM $this->tbl_inspection_audit_details as ins "
        . " where ins.gri_status = '0'  AND forword_grievance='2' $condition $order_by  $offlim ";
       $result = $this->db->query($sql);
    //    echo $this->db->last_query();die;
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    function get_gri_records($args = array(), $offset = '', $limit = ''){
        $condition = $offlim = '';
        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit 50 offset $offset ";
        }
        if($args['get_dist']!=''){
            $condition .= "AND ins.ins_dist ='" . $args['get_dist'] . "' "; 
        }
        if($args['clg_ref_id']!=''){
            $condition .= "AND ins.added_by ='" . $args['clg_ref_id'] . "' "; 
        }
        
        $sql = "SELECT *,district.dst_name,get_clg.clg_first_name,get_clg.clg_mid_name,get_clg.clg_last_name FROM $this->tbl_inspection_audit_details as ins "
        . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = ins.ins_dist ) "
        . " LEFT JOIN ems_colleague as get_clg ON ( get_clg.clg_ref_id = ins.added_by ) "

        . " where  1=1  AND forword_grievance='2' AND is_deleted !='2' $condition  ORDER BY ins.id DESC  $offlim ";
       $result = $this->db->query($sql);
       //echo $this->db->last_query();die;
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    function get_medicine_list() {
        ///var_dump($args);die;
        $condition = $offlim = '';

     

        $sql = "SELECT * FROM ems_inventory_medicine AS med WHERE  1=1 $condition";
        $result = $this->db->query($sql);

           //echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_ins_medicine_list($args = array()) {
        ///var_dump($args);die;
        $condition = $offlim = '';
        if ($args['ambu_type'] != '') {
            $condition .= "AND med_usedby_amb_type  LIKE ('%" . $args['ambu_type'] . "%') ";
        }
        $sql = "SELECT * FROM ems_inspection_medicine AS med WHERE med.medis_deleted='0' $condition order by med.med_id ASC";
        $result = $this->db->query($sql);

        //    echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_equipment_list($args = array()) {
        $condition='';
        if ($args['cat_type'] != '') {

            $condition .= "AND eqp_cat ='" . $args['cat_type'] . "' ";
        }
        if ($args['ambu_type'] != '') {
            $condition .= "AND eqp_usedby_amb_type  LIKE ('%" . $args['ambu_type'] . "%') ";
        }
        $sql = "SELECT * FROM ems_inventory_equipment AS med WHERE  1=1 AND med.eqpis_deleted = '0' $condition order by eqp_id";
        $result = $this->db->query($sql);
         //echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function insert_gri($args = array()){
        $result = $this->db->insert($this->tbl_ins_gri_audit_details, $args);
        // echo $this->db->last_query();die;
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    function insert_ins_media_insp($args = array()){
        $result = $this->db->insert('ems_insp_upload_file', $args);
        // echo $this->db->last_query();die;
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    function insert_insp($args = array()) {

        $result = $this->db->insert($this->tbl_inspection_audit_details, $args);
        // echo $this->db->last_query();die;
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    function insert_insp_med($args = array())
    {
        $result = $this->db->insert($this->tbl_inspection_audit_med_details, $args);
        // echo $this->db->last_query();die;
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    function get_all_equipment_item($args = array(), $offset = '', $limit = '') {


        $condition = '';

        

        $sql = "SELECT ind_req.*,hp.hp_name,district.dst_name "
            . "FROM $this->tbl_ind_req as ind_req "
            //. "LEFT JOIN $this->tbl_amb_stock AS amb_stk  ON (amb_stk.amb_rto_register_no = ind_req.req_amb_reg_no) "
            . " LEFT JOIN $this->tbl_ambulance as amb ON (  amb.amb_rto_register_no = ind_req.req_amb_reg_no ) "
             . "LEFT JOIN $this->tbl_hp as hp ON (amb.amb_base_location = hp.hp_id) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = ind_req.req_district_code ) "
            //. " LEFT JOIN $this->tbl_colleague as clg ON (clg.clg_ref_id = ind_req.req_emt_id) "
            . " where ind_req.req_isdeleted ='0'  $condition Group By ind_req.req_id ORDER BY ind_req.req_date DESC $offlim ";
        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function insert_insp_equp($args = array())
    {
        $result = $this->db->insert($this->tbl_inspection_audit_equp_details, $args);
        // echo $this->db->last_query();die;
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    function get_maintainance_data($args = array(), $offset = '', $limit = ''){
        $condition = $offlim = '';
        if (trim($args['main_name']) != '') {

            $condition .= "AND ins_type_name like '%" . $args['main_name'] . "%' ";
        }
        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }
        $sql = "SELECT * FROM ems_mas_inspection_main_type where is_deleted='0' $condition order by id ASC $offlim ";
        //echo $sql;
        $result = $this->db->query($sql);
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
function get_amb_list(){
    $sql ="select amb_rto_register_no
    FROM ems_ambulance
    where ambis_deleted = '0'";
    $result = $this->db->query($sql);
    // print_r($result->num_rows());die;
    echo $this->db->last_query();die();

    return $result->result();
}

function get_critical_type($args =array()){
    $condition = '';
    if ($args['from_date'] != '' && $args['to_date'] != '') {
        $from = $args['from_date'];
        $to = $args['to_date'];
        $condition .= " AND on_main.added_date BETWEEN '$from' AND '$to 23:59:59'";
 }

       if (trim($args['dist']) != '' ) {
        // $condition .= "AND on_main.mt_district_id = '" . $args['dist'] . "' ";
        $condition .= "AND on_main.ins_dist = '" . $args['dist'] . "' ";
    }
        if (trim($args['zone']) != '') {
            // $condition .= "AND am_mt.mt_district_id = '" . $args['zone'] . "' ";
            $condition .= "AND div1.div_id = '" . $args['zone'] . "' ";
        }
    $sql ="select type,status,oprational,date_from,inv_eqp.eqp_name
    FROM ems_inspection_audit_equp_details as equipment
    LEFT JOIN ems_inspection_audit_details AS on_main ON (equipment.ins_id = on_main.id)
    LEFT JOIN ems_inventory_equipment AS inv_eqp ON (inv_eqp.eqp_id = equipment.eqp_id)
    LEFT JOIN ems_mas_districts as district ON ( district.dst_code = on_main.ins_dist )
    LEFT JOIN ems_mas_division AS div1 ON (div1.div_code = district.div_id) 
    where type = '1' $condition";
    $result = $this->db->query($sql);
    // print_r($result->num_rows());die;
    // echo $this->db->last_query();die();

    return $result->result();
}

function get_major_type($args =array()){
    $condition = '';
    if ($args['from_date'] != '' && $args['to_date'] != '') {
        $from = $args['from_date'];
        $to = $args['to_date'];
        $condition .= " AND on_main.added_date BETWEEN '$from' AND '$to 23:59:59'";
 }

       if (trim($args['dist']) != '' ) {
        // $condition .= "AND on_main.mt_district_id = '" . $args['dist'] . "' ";
        $condition .= "AND on_main.ins_dist = '" . $args['dist'] . "' ";
    }
        if (trim($args['zone']) != '') {
            // $condition .= "AND am_mt.mt_district_id = '" . $args['zone'] . "' ";
            $condition .= "AND div1.div_id = '" . $args['zone'] . "' ";
        }
    $sql ="select type,status,oprational,date_from,inv_eqp.eqp_name
    FROM ems_inspection_audit_equp_details as equipment
    LEFT JOIN ems_inspection_audit_details AS on_main ON (equipment.ins_id = on_main.id)
    LEFT JOIN ems_inventory_equipment AS inv_eqp ON (inv_eqp.eqp_id = equipment.eqp_id)
    LEFT JOIN ems_mas_districts as district ON ( district.dst_code = on_main.ins_dist )
    LEFT JOIN ems_mas_division AS div1 ON (div1.div_code = district.div_id) 
    where type = '2' $condition";
    $result = $this->db->query($sql);
    // print_r($result->num_rows());die;
    // echo $this->db->last_query();die();

    return $result->result();
}

function get_minor_type($args =array()){
    $condition = '';
    if ($args['from_date'] != '' && $args['to_date'] != '') {
        $from = $args['from_date'];
        $to = $args['to_date'];
        $condition .= " AND on_main.added_date BETWEEN '$from' AND '$to 23:59:59'";
 }

       if (trim($args['dist']) != '' ) {
        // $condition .= "AND on_main.mt_district_id = '" . $args['dist'] . "' ";
        $condition .= "AND on_main.ins_dist = '" . $args['dist'] . "' ";
    }
        if (trim($args['zone']) != '') {
            // $condition .= "AND am_mt.mt_district_id = '" . $args['zone'] . "' ";
            $condition .= "AND div1.div_id = '" . $args['zone'] . "' ";
        }
    $sql ="select type,status,oprational,date_from,inv_eqp.eqp_name
    FROM ems_inspection_audit_equp_details as equipment
    LEFT JOIN ems_inspection_audit_details AS on_main ON (equipment.ins_id = on_main.id)
    LEFT JOIN ems_inventory_equipment AS inv_eqp ON (inv_eqp.eqp_id = equipment.eqp_id)
    LEFT JOIN ems_mas_districts as district ON ( district.dst_code = on_main.ins_dist )
    LEFT JOIN ems_mas_division AS div1 ON (div1.div_code = district.div_id) 
    where type = '3' $condition";
    $result = $this->db->query($sql);
    // print_r($result->num_rows());die;
    // echo $this->db->last_query();die();

    return $result->result();
}


    function get_inspection_data($args =array()){
        $condition = '';
    
 if ($args['from_date'] != '' && $args['to_date'] != '') {
        $from = $args['from_date'];
        $to = $args['to_date'];
        $condition .= " AND on_main.added_date BETWEEN '$from' AND '$to 23:59:59'";
 }

       if (trim($args['dist']) != '' ) {
        // $condition .= "AND on_main.mt_district_id = '" . $args['dist'] . "' ";
        $condition .= "AND on_main.ins_dist = '" . $args['dist'] . "' ";
    }
        if (trim($args['zone']) != '') {
            // $condition .= "AND am_mt.mt_district_id = '" . $args['zone'] . "' ";
            $condition .= "AND div1.div_id = '" . $args['zone'] . "' ";
        }
      
       
       $sql ="select ins_amb_no,ins_baselocation,ins_amb_model,ins_amb_current_status,ins_gps_status,
       ins_pilot,ins_emso,ins_odometer,ins_main_date,ins_main_due_status,ins_main_status,ins_main_remark,
       ins_clean_date,ins_clean_status,ins_clean_remark,ac_status,ac_working_date,ac_remark,tyre_status,
       tyre_working_date,tyre_remark,siren_status,siren_working_date,siren_remark,inv_status,inv_working_date,
       inv_remark,batt_status,batt_working_date,batt_remark,gps_status,gps_working_date,gps_remark,
       ins_pcs_stock_date,ins_pcs_stock_status,ins_pcs_stock_remark,ins_sign_attnd_date,ins_sign_attnd_due_status,
       ins_sign_attnd_status,ins_sign_attnd_remark,eqp_critical_remark,eqp_major_remark,eqp_minor_remark,
       gri_audit.prilimnari_inform, griv.grievance_type As griv_name,gri_audit.remark As griv_remark, 
       gri_type.grievance_sub_type As gri_sub_type,ambu_type.ambt_name as amb_type_on,district.dst_name,
       div1.div_name,medicine.med_qty,med_Remark,clg.clg_first_name as ins_first_name,clg.clg_mid_name as ins_mid_name,
       clg.clg_last_name as ins_last_name,clg_gri.clg_first_name as gri_first_name,clg_gri.clg_mid_name as gri_mid_name,
       clg_gri.clg_last_name as gri_last_name,inv_eqp.eqp_type,inv_eqp.eqp_cat,on_main.added_date,on_main.added_by,gri_audit.added_date As griv_date,

       GROUP_CONCAT(DISTINCT(ins_med.med_title))  as med_title, GROUP_CONCAT((medicine.med_qty))  as med_qty,
       GROUP_CONCAT((medicine.med_status))  as med_status, GROUP_CONCAT((ins_med.exp_stock))  as exp_stock,

       GROUP_CONCAT(DISTINCT(inv_eqp.eqp_name))  as cri_eqp_name,GROUP_CONCAT(DISTINCT(equipment.status))  as cri_status,
       GROUP_CONCAT(DISTINCT(equipment.oprational))  as cri_oprational,GROUP_CONCAT(DISTINCT(equipment.date_from))  as cri_date_from,

       GROUP_CONCAT(DISTINCT(inv_eqp.eqp_name))  as maj_eqp_name,GROUP_CONCAT(DISTINCT(equipment.status))  as maj_status,
       GROUP_CONCAT(DISTINCT(equipment.oprational))  as maj_oprational,GROUP_CONCAT(DISTINCT(equipment.date_from))  as maj_date_from,
      
       GROUP_CONCAT(DISTINCT(inv_eqp.eqp_name)) as min_eqp_name,GROUP_CONCAT(DISTINCT(equipment.status))  as min_status,
       GROUP_CONCAT(DISTINCT(equipment.oprational))  as min_oprational,GROUP_CONCAT(DISTINCT(equipment.date_from))  as min_date_from,
        
       GROUP_CONCAT(DISTINCT(inv_eqp.eqp_name))  as eqp_name,
       GROUP_CONCAT(DISTINCT(equipment.status))  as status,
       GROUP_CONCAT(DISTINCT(equipment.oprational))  as oprational,
       GROUP_CONCAT(DISTINCT(equipment.date_from))  as date_from
        
       FROM ems_inspection_audit_details as on_main 

       LEFT JOIN ems_ambulance as amb ON ( amb.amb_id = on_main.ins_amb_type )
       LEFT JOIN ems_mas_ambulance_type as ambu_type ON ( ambu_type.ambt_id = on_main.ins_amb_type )
       LEFT JOIN ems_mas_districts as district ON ( district.dst_code = on_main.ins_dist )
       LEFT JOIN ems_mas_division AS div1 ON (div1.div_code = district.div_id) 

       LEFT JOIN ems_inspection_audit_med_details AS medicine ON (medicine.ins_id = on_main.id) 
       LEFT JOIN ems_inspection_medicine AS ins_med ON  FIND_IN_SET(ins_med.med_id , medicine.med_id) 

       LEFT JOIN ems_inspection_audit_equp_details AS equipment ON (equipment.ins_id = on_main.id)
       LEFT JOIN ems_inventory_equipment AS inv_eqp ON (inv_eqp.eqp_id = equipment.eqp_id)
       
       LEFT JOIN ems_ins_gri_audit_details AS gri_audit ON (gri_audit.ins_id = on_main.id)
       LEFT JOIN ems_mas_grievance_type AS griv ON (griv.grievance_id = gri_audit.grievance_type)
       LEFT JOIN ems_mas_grievance_sub_type AS gri_type ON (gri_type.g_id = gri_audit.grievance_sub_type)

       LEFT JOIN ems_colleague AS clg ON (clg.clg_ref_id = on_main.added_by)
       LEFT JOIN ems_colleague AS clg_gri ON (clg_gri.clg_ref_id = gri_audit.added_by)
       where 1=1 $condition GROUP BY on_main.id" ;
    //    LEFT JOIN ems_inspection_medicine AS ins_med ON (ins_med.med_id = medicine.id) 
        $result = $this->db->query($sql);
        // print_r($result->num_rows());die;
        // echo $this->db->last_query();die();
    if ($args['get_count']) {
        return $result->num_rows();
    } else {
        return $result->result();
    }

    }
    function get_ins_medicine($args = array()) {
        ///var_dump($args);die;
       
        $sql = "SELECT med.* FROM ems_inspection_medicine AS med WHERE med.medis_deleted='0' order by med.med_id";
        $result = $this->db->query($sql);

        //    echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
   
}