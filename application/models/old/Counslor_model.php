<?php
class Counslor_model extends CI_Model {

    function __construct() {

        parent::__construct();

        $this->tbl_inc = $this->db->dbprefix('incidence');

        $this->tbl_cls = $this->db->dbprefix('calls');

        $this->tbl_clrs = $this->db->dbprefix('callers');

        $this->tbl_pt = $this->db->dbprefix('patient');

        $this->tbl_hp = $this->db->dbprefix('hospital');

        $this->tbl_amb = $this->db->dbprefix('ambulance');

        $this->tbl_inc_amb = $this->db->dbprefix('incidence_ambulance');

        $this->tbl_inc_pt = $this->db->dbprefix('incidence_patient');

        $this->tbl_opby = $this->db->dbprefix('operateby');

        $this->tbl_inc_adv = $this->db->dbprefix('incidence_advice');

        $this->tbl_inc_add_adv = $this->db->dbprefix('inc_add_advice');

        $this->tbl_amb_type = $this->db->dbprefix('mas_ambulance_type');

        $this->tbl_dist = $this->db->dbprefix('mas_districts');

        $this->tbl_clg = $this->db->dbprefix('colleague');

        $this->tbl_mas_default_ans = $this->db->dbprefix('mas_default_ans');

        $this->tbl_que = $this->db->dbprefix('mas_questionnaire');

        $this->tbl_pptype = $this->db->dbprefix('mas_pupils_type');

        $this->tbl_loc_level = $this->db->dbprefix('mas_loc_level');

        $this->tbl_cgs_score = $this->db->dbprefix('mas_cgs_score');

        $this->tbl_ambulance = $this->db->dbprefix('ambulance');
        $this->tbl_incidence_ambulance = $this->db->dbprefix('incidence_ambulance');
        $this->tbl_colleague = $this->db->dbprefix('colleague');
        $this->tbl_patient_complaint_types = $this->db->dbprefix('mas_patient_complaint_types');

    }
    
    function get_inc_by_counslor($args = array(), $offset = '', $limit = '') {

        $condition = $offlim = '';

        if ($args['opt_id']) {
            $condition .= " AND inc_cons.cons_emt='" . $args['opt_id'] . "'  ";
        }

        if ($args['child_ercp']) {
            $condition .= " AND inc_cons.cons_emt IN ('" . $args['child_ercp'] . "')  ";
        }
        if ($args['inc_ref_id']) {
            $condition .= " AND inc.inc_ref_id='" . trim($args['inc_ref_id']) . "'  ";
        }
        $filter_cond = '';
        if($args['filter']){
            $filter = $args['filter'];
            if ($filter['from_date'] && $filter['to_date']) {
            $to_date = date('Y-m-d', strtotime($filter['to_date']));
            $from_date = date('Y-m-d', strtotime($filter['from_date']));
            $filter_cond .= " AND  inc_datetime BETWEEN '$from_date 00:00:01' AND '$to_date 23:59:59'    ";
            }
            if ($args['ercp_id']) {
                $filter_cond .= " OR  inc_cons.cons_emt='" . $filter['ercp_id'] . "'";
            }
        }
        if ($offset >= 0 && $limit > 0) {
            $offlim = " limit $limit offset $offset ";
        }
        $sql = "SELECT inc_cons.*,inc.inc_datetime,inc.inc_ref_id,clr.*,std_re.counslor_remark FROM ems_counslor_desk_inc_advice as inc_cons"
            . " LEFT JOIN $this->tbl_inc as inc ON(inc.inc_ref_id=inc_cons.cons_inc_ref_id)"
            . " LEFT JOIN ems_calls as cl ON(cl.cl_id=inc_cons.cons_cl_id) "
            . " LEFT JOIN ems_mas_counslor_standard_remark as std_re ON(std_re.id=inc_cons.cons_remark) "
            . " LEFT JOIN ems_callers as clr ON(cl.cl_clr_id=clr.clr_id) 
            WHERE ( inc.inc_pcr_status = '0' AND inc.inc_base_month IN ('176')  $condition) $filter_cond GROUP BY inc_cons.cons_inc_ref_id ORDER BY inc_cons.cons_id DESC $offlim";
        $result = $this->db->query($sql);
         //echo $this->db->last_query();die();
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    
    function prev_call_cons_list($args = array()) {

        $condition = "";
        //var_dump($args);die();cons_cl_adv_id
        if ($args['adv_cl_inc_id']) {

            $condition .= "AND cons_adv.cons_cl_inc_id='" . $args['adv_cl_inc_id'] . "'  ";
        }
        if ($args['cons_cl_inc_id']) {

            $condition .= "AND cons_adv.cons_cl_inc_id='" . $args['cons_cl_inc_id'] . "'  ";
        }

        if ($args['adv_cl_adv_id']) {

            $condition .= "  AND cons_adv.cons_cl_adv_id IN (" . $args['adv_cl_adv_id'] . ")";
        }
        if($args['cons_cl_adv_id']){
            $condition .= "  AND cons_adv.cons_cl_adv_id IN (" . $args['cons_cl_adv_id'] . ")";
        }
        if($args['cons_cl_id']){
            
            $condition .= "  AND cons_adv.cons_cl_id ='" . $args['cons_cl_id'] . "'  ";
        }
        if ($args['is_deleted'] != 'false') {
            $condition .= " AND cons_clis_deleted='0'";
        }
        $sql = "SELECT std_re.counslor_remark,cons_adv.cons_cl_id,cons_adv.cons_cl_adv_id,cons_adv.cons_cl_date,cons_adv.cons_counslor_note 
        FROM ems_counslor_desk_advice as cons_adv
        LEFT JOIN ems_mas_counslor_standard_remark as std_re ON cons_adv.cons_std_remark=std_re.id
        WHERE  1=1 $condition";
        $result = $this->db->query($sql);
        //echo $this->db->last_query();die();
        return $result->result();
    }
}
