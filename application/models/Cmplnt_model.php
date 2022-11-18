<?php

class Cmplnt_model extends CI_Model {

    function __construct() {

        parent::__construct();

        $this->cmp = $this->db->dbprefix('complaints');

        $this->tbl_cct = $this->db->dbprefix('mas_call_complaint_type');

        $this->tbl_optby = $this->db->dbprefix('operateby');
        $this->tbl_dept = $this->db->dbprefix('mas_department');
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To get call complaint type.
    // 
    /////////////////////////////////////////

    function get_cct_type($args = array()) {

        if (trim($args['cct_type']) != '') {
            $condition = " AND cct_type like '" . $args['cct_type'] . "%' ";
        }
        if (trim($args['cct_id']) != '') {
            $condition = " AND cct_id='" . $args['cct_id'] . "' ";
        }

        $result = $this->db->query("select * from $this->tbl_cct where cct_status='1' AND cctis_deleted='0' $condition");

        return $result->result();
    }
    function get_department_type($args = array()) {

        if (trim($args['dept_name']) != '') {
            $condition = " AND dept_name like '" . $args['dept_name'] . "%' ";
        }
        if (trim($args['dept_id']) != '') {
            $condition = " AND dept_id='" . $args['dept_id'] . "' ";
        }

        $result = $this->db->query("select * from $this->tbl_dept where dept_isdeleted='0' $condition");

        return $result->result();
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To add complaint details.
    // 
    /////////////////////////////////////////

    function add($args = array()) {

        $this->db->insert($this->cmp, $args);

        return $this->db->insert_id();
    }

}
