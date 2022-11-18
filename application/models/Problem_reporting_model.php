<?php

class Problem_reporting_model extends CI_Model {

    function __construct() {

        parent::__construct();

        $this->tbl_problem_reporting_calls = $this->db->dbprefix('problem_reporting_calls');

        $this->tbl_cls = $this->db->dbprefix('calls');

        $this->tbl_inc = $this->db->dbprefix('incidence');

        $this->tbl_clrs = $this->db->dbprefix('callers');
    }

    function insert_prob_report($args = array()) {

        $this->db->insert($this->tbl_problem_reporting_calls, $args);

        return $this->db->insert_id();
    }

    function get_grivance_call_detials($args = array()) {

        $condition = "";

        if ($args['base_month'] != '') {
            $condition .= " AND inc.inc_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")";
        }

        if ($args['inc_ref_id']) {

            $condition .= " AND inc.inc_ref_id='" . trim($args['inc_ref_id']) . "' ";
        }


        $sql = "SELECT *,clg.clg_first_name,clg.clg_last_name "
            . "FROM  $this->tbl_cls as cl, $this->tbl_clrs as clr ,$this->tbl_inc as inc "
            . " LEFT JOIN $this->tbl_problem_reporting_calls as prcl on (prcl.rcl_inc_ref_id=inc.inc_ref_id) "
            . " LEFT JOIN ems_colleague as clg on (clg.clg_ref_id=inc.inc_added_by) "
            . "WHERE    inc.inc_cl_id = cl.cl_id AND cl.cl_clr_id = clr.clr_id  AND inc.incis_deleted='0' $condition ORDER BY inc.inc_id DESC ";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

}
