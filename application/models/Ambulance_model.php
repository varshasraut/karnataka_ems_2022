<?php


class Ambulance_model extends CI_Model {

	

    public $tbl_mas_user_groups, $tbl_colleagues, $tbl_country, $tbl_state, $tbl_city;

            

    function __construct() {

        parent::__construct();

        

        $this->load->helper('date');

        $this->load->database();

        

        $this->tbl_mas_store_groups = $this->db->dbprefix('mas_groups');
    }
}