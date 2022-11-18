<?php

class Cluster_model extends CI_Model {

    public $tbl_mas_user_groups, $tbl_colleagues, $tbl_country, $tbl_state, $tbl_city;

    function __construct() {

        parent::__construct();

        $this->load->helper('date');

        $this->load->database();

        $this->tbl_cluster = $this->db->dbprefix('cluster');
        $this->tbl_mas_districts = $this->db->dbprefix('mas_districts');
        $this->tbl_mas_tahshil = $this->db->dbprefix('mas_tahshil');
    }

    function get_cluster_data_by_id($cluster_id) {
          $condition = $offlim = '';
        
          if (is_array($cluster_id)) {
            $cluster_id = implode(',', $cluster_id);
        }

       

        $condition = " AND `" . cluster_id . "` IN (" . $cluster_id . ") ";

        if ($offset >= 0 && $limit > 0) {

            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT clu.*,dist.dst_name,tah.thl_name FROM $this->tbl_cluster as clu LEFT JOIN $this->tbl_mas_districts as dist ON clu.district = dist.dst_code LEFT JOIN $this->tbl_mas_tahshil as tah ON clu.taluka =tah.thl_code where clu.isdeleted='0' $condition ORDER BY clu.cluster_id DESC $offlim ";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return array();
        }
    }

    function get_cluster_data($args = array(), $offset = '', $limit = '') {

        $condition = $offlim = '';

        if (isset($args['cluster_id'])) {
            $condition .= "AND clu.cluster_id='" . $args['cluster_id'] . "'";
        }
        if (isset($args['atc'])) {
            $condition .= "AND clu.atc='" . $args['atc'] . "'";
        }
        if (isset($args['po'])) {
            $condition .= "AND clu.po='" . $args['po'] . "'";
        }

        if (isset($args['cluster_search'])) {
            $condition .= "AND clu.cluster_name LIKE '%" . trim($args['cluster_search']) . "%'";
        }


        if ($offset >= 0 && $limit > 0) {

            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT clu.*,dist.dst_name,tah.thl_name FROM $this->tbl_cluster as clu LEFT JOIN $this->tbl_mas_districts as dist ON clu.district = dist.dst_code LEFT JOIN $this->tbl_mas_tahshil as tah ON clu.taluka =tah.thl_code where clu.isdeleted='0' $condition ORDER BY clu.cluster_id DESC $offlim ";
        $result = $this->db->query($sql);



        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function insert_cluster($args) {
        $result = $this->db->insert($this->tbl_cluster, $args);
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function delete_cluster($cluster_id = array(), $status = '') {

        $this->db->where_in('cluster_id', $cluster_id);

        $status = $this->db->update($this->tbl_cluster, $status);

        return $status;
    }

    function update_cluster($args = array(), $cluster_id) {



        if ($cluster_id != '') {

            $this->db->where('cluster_id', $cluster_id[0]);
        }


        $update = $this->db->update($this->tbl_cluster, $args);



        if ($update) {

            return true;
        } else {

            return false;
        }
    }

}
