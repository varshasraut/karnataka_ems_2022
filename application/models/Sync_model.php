<?php

class Sync_model extends CI_Model {

    function __construct() {

        parent::__construct();
        $this->load->database();
    }

    function get_sync_data($args) {

        $sync_table = $args['table_name'];
        $sync_time = $args['sync_time'];
        $conditions = $args['conditions'];
        $conditions_data = $args['conditions_data'];

        $sql_where = " WHERE 1=1 ";
        $conditions_str = '';
        foreach ($conditions as $condition) {

            if (empty($conditions_data[$condition])) {
                continue;
            }

            $conditions_str = $conditions_data[$condition];
            if (is_array($conditions_data[$condition])) {
                $conditions_str = implode("','", $conditions_data[$condition]);
                $conditions_str = "'" . $conditions_str . "'";
            }

            $sql_where .= " AND `" . $condition . "` IN (" . $conditions_str . ") ";
        }
        
       
        $sql_where .= " AND `modify_date_sync` > FROM_UNIXTIME('$sync_time') ";
//  
        $sql_str = "SELECT * FROM `$sync_table` " . $sql_where;
//              var_dump($sql_str);
        

        $result = $this->db->query($sql_str);

        if ($result) {
            return $result->result();
        } else {
            return array();
        }
    }

    function update_sync_data($args) {

        $updated_rows = array();

        $table_name = $args['table_name'];
        $table_data = $args['table_data'];
        $table_pk = $args['table_pk'];
        $table_uk = $args['table_uk'];

        foreach ($table_data as $table_row) {

            $updated_row = array();

            $updated_row['table_pk'] = $table_pk;
            $updated_row['table_pk_val'] = $table_row[$table_pk];

            $row_uk_val = get_uniqid();
            if (trim($table_row[$table_uk]) == '') {
                $table_row[$table_uk] = $row_uk_val;
            }

            unset($table_row[$table_pk]);

            $this->db->replace($table_name, $table_row);
            //$insert_id = $this->db->insert_id();

            $updated_row['table_uk'] = $table_uk;
            $updated_row['table_uk_val'] = $row_uk_val;   //$insert_id

            $updated_rows[] = $updated_row;
        }

        return $updated_rows;
    }

    function update_sync_data_main($args) {

        $updated_rows = array();

        $table_name = $args['table_name'];
        $table_data = $args['table_data'];
        //$table_pk = $args['table_pk'];
        //$table_uk = $args['table_uk'];

        foreach ($table_data as $table_row) {

            //$updated_row = array();
            //$updated_row['table_pk'] = $table_pk;
            //$updated_row['table_pk_val'] = $table_row[$table_pk];
            //unset($table_row[$table_pk]);

            $this->db->replace($table_name, $table_row);
            //$insert_id = $this->db->insert_id();
            //$updated_row['table_uk'] = $table_uk;
            //$updated_row['table_uk_val'] = $insert_id;
            //$updated_rows[] = $updated_row;
        }

        //return $updated_rows;
        return true;
    }

    function get_columns($table_name, $ignore_primary = false) {

        $sql_str = "SHOW COLUMNS FROM `$table_name` ";
        $result = $this->db->query($sql_str);

        if ($result) {
            $columns = array();
            $result_data = $result->result();
            foreach ($result_data as $column) {
                if ($ignore_primary && $column->Key == 'PRI') {
                    continue;
                }
                $columns[$column->Field] = $column->Default;
            }
            return $columns;
        } else {
            return array();
        }
    }

    function get_cluster_schools($cluster_id) {

        if (is_array($cluster_id)) {
            $cluster_id = implode(',', $cluster_id);
        }

        $sql_where = " WHERE 1=1 ";

        $sql_where .= " AND `" . cluster_id . "` IN (" . $cluster_id . ") ";

        $sql_str = "SELECT `school_id` FROM `ems_school` " . $sql_where;

        $result = $this->db->query($sql_str);

        if ($result) {
            return $result->result();
        } else {
            return array();
        }
    }

    function get_cluster_schedules($cluster_id) {

        if (is_array($cluster_id)) {
            $cluster_id = implode(',', $cluster_id);
        }

        $sql_where = " WHERE 1=1 ";

        $sql_where .= " AND `" . schedule_clusterid . "` IN (" . $cluster_id . ") ";

        $sql_str = "SELECT `schedule_id` FROM `ems_schedule` " . $sql_where;

        $result = $this->db->query($sql_str);

        if ($result) {
            return $result->result();
        } else {
            return array();
        }
    }

    function get_incedences($clg_id) {
   

        if ($clg_id != '') {
            $sql_where .= "  AND `operator_id` = '" . $clg_id . "'";
        }

        $sql_where = " WHERE 1=1 ";


        $sql_str = "SELECT * FROM ems_operateby AS op   " . $sql_where;


        $result = $this->db->query($sql_str);

        if ($result) {
            return $result->result();
        } else {
            return array();
        }
    }

    function get_incedences_patients($incedence_ids) {
        

        if (is_array($incedence_ids)) {
            $incedence_ids = implode(',', $incedence_ids);
        }

        $sql_where = " WHERE 1=1 ";
        $sql_where .= " AND `" . inc_id . "` IN (" . $incedence_ids . ") ";

        $sql_str = "SELECT inc_ptn.ptn_id FROM ems_incidence_patient AS inc_ptn  LEFT JOIN ems_patient as ptn ON ( ptn.ptn_id = inc_ptn.ptn_id )  " . $sql_where;

        $result = $this->db->query($sql_str);

        if ($result) {
            return $result->result();
        } else {
            return array();
        }
    }

    function get_ambulance() {

        $sql_where = " WHERE 1=1 ";
//        $sql_where .= " AND amb_user_type = 'tdd' ";

        $sql_str = "SELECT * FROM ems_ambulance AS amb" . $sql_where;

        $result = $this->db->query($sql_str);

        if ($result) {
            return $result->result();
        } else {
            return array();
        }
    }

    function get_cluser_po($cluster_id) {

        $sql_where = " WHERE 1=1 ";

        $sql_where .= "  AND `cluster_id` = '" . $cluster_id . "'";

        $sql_str = "SELECT `po` FROM `ems_cluster` " . $sql_where;

        $result = $this->db->query($sql_str);

        if ($result) {
            return $result->result();
        } else {
            return array();
        }
    }

    function get_po_clusers($po_id) {

        $sql_where = " WHERE 1=1 ";
        $sql_where .= "  AND `po` = '" . $po_id . "'";
        $sql_str = "SELECT `cluster_id` FROM `ems_cluster` " . $sql_where;

        $result = $this->db->query($sql_str);

        if ($result) {
            return $result->result();
        } else {
            return array();
        }
    }

}
