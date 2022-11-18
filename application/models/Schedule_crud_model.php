<?php
class Schedule_crud_model extends CI_Model {

    public $tbl_mas_user_groups, $tbl_colleagues, $tbl_country, $tbl_state, $tbl_city;

    function __construct() {

        parent::__construct();

        $this->load->helper('date');

        $this->load->database();

        $this->tbl_schedule_crud = $this->db->dbprefix('schedule_crud');
        $this->tbl_schedule_crud_mapping = $this->db->dbprefix('schedule_crud_mapping');
        $this->tbl_shift = $this->db->dbprefix('mas_shift');
        $this->tbl_colleague = $this->db->dbprefix('colleague');
    }
    
     function get_crud_data($args =array(), $offset = '', $limit = ''){
        
        $condition = $offlim = '';
     //var_dump($args);die;
        if ($args['sc_cr_id'] != '') {
            $condition .= "AND am_mt.sc_cr_id = '" . $args['sc_cr_id'] . "' ";
        }
        
        // if ($args['from_date'] != '' ) {
        //    // $from = $args['from_date'];
        //      $to = $args['to_date'];
        //     $condition .= " AND am_mt.added_date BETWEEN '$from' AND '$from 23:59:59'";
        // }
        if (trim($args['call_search'])) {
            
            $condition .= " AND (clg_ero.clg_last_name LIKE '%" .trim($args['call_search']). "%' OR clg_ero.clg_first_name LIKE '%" . trim($args['call_search']). "%' OR clg_ero.clg_ref_id LIKE '%" . trim($args['call_search']). "%' OR clg_ero.clg_group LIKE '%" . trim($args['call_search']). "%' OR am_mt.user_name LIKE '%" . trim($args['call_search']). "%' ) ";
            
        }

        if ($args['curr_user'] != '') {
            if($args['curr_user'] != 'all'){
            $condition .= "AND am_mt.added_by = '" . $args['curr_user'] . "' ";
            }
        }

        if ($args['team_type'] != '') {
            if($args['team_type'] != 'all'){
            $condition .= " AND am_mt.user_group ='" . $args['team_type'] . "' ";
            }
        }
        if($args['ero'] != ''){
            $condition .= "AND  am_mt.user_id = '" . $args['ero'] . "' ";
        }
        if($args['month'] != ''){
            $condition .= "AND  am_mt.schedule_month = '" . $args['month'] . "' ";
        }
        if($args['year'] != ''){
            $condition .= "AND  am_mt.schedule_year = '" . $args['year'] . "' ";
        }

        if($args['user_id'] != ''){
            if($args['user_id'] != 'all'){
                
            $condition .= "AND  am_mt.user_id LIKE '%" . $args['user_id'] . "%'";
         //   $condition .= " AND (clg_ero.clg_last_name LIKE '%" .trim($args['user_id']). "%' OR clg_ero.clg_first_name LIKE '%" . trim($args['user_id']). "%' OR clg_ero.clg_ref_id LIKE '%" . trim($args['user_id']). "%' ) ";

        }}

        if($args['base_month'] != ''){
           
                 
           // $condition .= "AND am_mt.crud_base_month IN ( " . $args['base_month'] . ")";
            //$condition .= "AND  am_mt.crud_base_month = '" . $args['from_date'] . "'";
        }
        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT am_mt.*, am_mt.added_date as mt_added_date ,clg_ero.*,sht.shift_name"
            . " FROM $this->tbl_schedule_crud as am_mt LEFT JOIN $this->tbl_shift as sht ON am_mt.shift = sht.shift_id"
            . " LEFT JOIN ems_schedule_crud_mapping as sht_mapp ON sht_mapp.shift_value = sht.shift_code"
            . " LEFT JOIN $this->tbl_colleague as clg_ero ON (clg_ero.clg_ref_id = am_mt.user_id )"
            . " where am_mt.is_deleted='0' $condition ORDER BY sc_cr_id DESC  $offlim ";
        
        $result = $this->db->query($sql);

       // echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_crud_cal_data_ero_wise($args =array(), $offset = '', $limit = ''){
        //var_dump($args['sc_cr_id']); die;
        $condition = $offlim = '';
        
        if ($args['sc_cr_id'] != '') {
            $condition .= "crud_mapp.sc_cr_id = '" . $args['sc_cr_id'] . "' ";
        }
        
        // if ($args['from_date'] != '' && $args['to_date'] != '') {
        //     $from = $args['from_date'];
        //     $to = $args['to_date'];
        //     $condition .= " AND crud_mapp.added_date BETWEEN '$from' AND '$to 23:59:59'";
        // }
        

        $sql = "SELECT DAY(crud_mapp.schedule_date) as day,crud_mapp.shift_value as shift "
            . " FROM $this->tbl_schedule_crud_mapping as crud_mapp "
            //. " LEFT JOIN $this->tbl_shift as sht ON am_mt.shift = sht.shift_id"
            //. " LEFT JOIN ems_schedule_crud_mapping as sht_mapp ON sht_mapp.shift_value = sht.shift_code"
            . " where $condition $offlim ";
        
        $result = $this->db->query($sql);

        //echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }

        function get_crud_last_id($args){
            //var_dump($args['clg_ref_id'][]);die;
            $condition =  '';
        
        if ($args['clg_ref_id'] != '') {
            $condition .= "AND sht.user_id = '" . $args['clg_ref_id'] . "' ";
        }
        
        $sql = "SELECT sht.sc_cr_id"
            . " FROM $this->tbl_schedule_crud as sht"
            . " where sht.is_deleted='0' $condition ORDER BY sht.sc_cr_id DESC LIMIT 1 ";
        
        $result = $this->db->query($sql);

       // echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
        }
    
        function get_shift_data($args =array()){
        
        $condition = $offlim = '';
        
        if (trim($args['shift_id']) != '') {
            $condition .= "AND sht.shift_id = '" . $args['shift_id'] . "' ";
        }
        
        $sql = "SELECT sht.*"
            . " FROM $this->tbl_shift as sht"
            . " where sht.shift_is_deleted='0' $condition  ";
        
        $result = $this->db->query($sql);

        //echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function import_crud($args) {
        //var_dump($args['user_name']);die;
        if (!empty($args)) {

            $arr = array();
            $arr['user_id']     = $args['user_id'];
            $arr['user_name']     = $args['user_name'];
            $arr['user_group']    = $args['user_group'];
            $arr['schedule_type'] = $args['schedule_type'];
            $arr['shift']         = $args['file_name'];
            $arr['schedule_month']= $args['schedule_month'];
            $arr['schedule_year'] = $args['schedule_year'];
            $arr['ero_supervisor'] = $args['ero_supervisor'];
            $arr['shift_supervisor'] = $args['shift_supervisor'];
            $arr['added_date'] = $args['added_date'];
            $arr['modify_date'] = $args['modify_date'];
            $arr['crud_base_month'] = $args['crud_base_month'];
         //var_dump($args);die;
             $arr1 =$this->db->insert($this->tbl_schedule_crud, $arr);
             $recordId=$this->db->insert_id();
            // var_dump($arr1);die;
            if (!empty($recordId)) {
                for ($i = 01; $i <= 31; $i++) {
                    if($args[$i] != NULL || $args[$i] != null || $args[$i] != ''){
                        $arr1 = array();
                        $arr1['sc_cr_id']    = $recordId;
                        $arr1['shift_value'] = $args[$i];

                        if ($i <= 9) {
                            $i = sprintf("%02d",$i);
                        }

                        $arr1['schedule_date'] =  $args['schedule_year'] .'-'. $args['schedule_month'] .'-'. $i;

                       $result = $this->db->insert($this->tbl_schedule_crud_mapping, $arr1);
                        //echo $this->db->last_query();
                    }
                    
                    unset($arr1);
                }
            }
            unset($recordId, $arr);
           // var_dump($result);
            return $result;
        }
    
        
    }
    function save_crud($args) {
        if (!empty($args)) {
            $arr = array();
            $arr['user_id']     = $args['user_id'];
            $arr['user_name']     = $args['user_name'];
            $arr['user_group']    = $args['user_group'];
            $arr['schedule_type'] = $args['schedule_type'];
            $arr['shift']         = $args['file_name'];
            $arr['schedule_month']= $args['schedule_month'];
            $arr['schedule_year'] = $args['schedule_year'];
            $arr['ero_supervisor'] = $args['ero_supervisor'];
            $arr['shift_supervisor'] = $args['shift_supervisor'];
            $arr['added_date'] = $args['added_date'];
            $arr['modify_date'] = $args['modify_date'];

            $this->db->insert($this->tbl_schedule_crud, $arr);
            return $this->db->insert_id();
        }

            
    }
    
    function insert_schedule_mapping($arrgs){
        //var_dump($arrgs);
        $this->db->insert($this->tbl_schedule_crud_mapping, $arrgs);
        return $this->db->insert_id();
    }
    
    
    function insert_crud($args){
        $this->db->insert($this->tbl_schedule_crud, $args);
        return $this->db->insert_id();
    }
    
    function delete_crud($sc_cr_id= array(), $status = '') {
        $this->db->where_in('sc_cr_id', $sc_cr_id);
        $status = $this->db->update($this->tbl_schedule_crud, $status);
        return $status;
    }
    
    function update_crud($map_id, $args) {
        //var_dump($args);die;
        $this->db->where_in('map_id', $map_id);
        $data = $this->db->update("$this->tbl_schedule_crud_mapping", $args);
        //echo $this->db->last_query(); die;
        return $data;
    }

    function get_schedule($args_sc){
        //var_dump($args_sc['sc_cr_id']);die;
        $condition = $offlim = '';
        
        if ($args_sc['sc_cr_id'] != '') {
            $condition .= "sht_mapp.sc_cr_id = '" . $args_sc['sc_cr_id'] . "' ";
        }
        
        // if ($args['from_date'] != '' && $args['to_date'] != '') {
        //     $from = $args['from_date'];
        //     $to = $args['to_date'];
        //     $condition .= " AND am_mt.added_date BETWEEN '$from' AND '$to 23:59:59'";
        // }
        

        $sql = "SELECT sht_mapp.*"
            . " FROM ems_schedule_crud_mapping as sht_mapp"
            . " where  $condition $offlim ";
        
        $result = $this->db->query($sql);

        //echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }

    }
}