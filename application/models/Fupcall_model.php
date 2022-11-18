<?php

class Fupcall_model extends CI_Model {

    function __construct() {

        parent::__construct();

        $this->tbl_fucall = $this->db->dbprefix('followup_call');
    }

    //// Created by MI42 //////////////////////
    // 
    // Purpose : To add follow up call details.
    // 
    ///////////////////////////////////////////

    function add($args = array()) {

        $this->db->insert($this->tbl_fucall, $args);

        return $this->db->insert_id();
    }

}
