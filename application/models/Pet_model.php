<?php

class Pet_model extends CI_Model {

    function __construct() {

        parent::__construct();

        $this->load->database();

        $this->tbl_cls = $this->db->dbprefix('calls');

        $this->tbl_inc = $this->db->dbprefix('incidence');

        $this->tbl_clrs = $this->db->dbprefix('callers');

        $this->tbl_clg = $this->db->dbprefix('colleague');

        $this->tbl_pt = $this->db->dbprefix('patient');

        $this->tbl_hp = $this->db->dbprefix('hospital');

        $this->tbl_amb = $this->db->dbprefix('ambulance');

        $this->tbl_inc_amb = $this->db->dbprefix('incidence_ambulance');

        $this->tbl_amb_emt = $this->db->dbprefix('amb_emt');

        $this->tbl_inc_pt = $this->db->dbprefix('incidence_patient');

        $this->tbl_pt_ctype = $this->db->dbprefix('mas_patient_complaint_types');

        $this->tbl_ptn_occ = $this->db->dbprefix('mas_ptn_occupation');

        $this->tbl_ptn_his = $this->db->dbprefix('patient_history');

        $this->tbl_ptn_cur_med = $this->db->dbprefix('pet_cur_med');

        $this->tbl_ptn_hc = $this->db->dbprefix('pet_his_case');

        $this->tbl_ptn_mh = $this->db->dbprefix('pet_med_his');

        $this->tbl_ptn_cc = $this->db->dbprefix('pet_chief_com');

        $this->tbl_diseases = $this->db->dbprefix('mas_ex_diseases');

        $this->tbl_ptn_med = $this->db->dbprefix('mas_ptn_med');

        $this->tbl_brth_rate = $this->db->dbprefix('mas_breathing_rate');

        $this->tbl_brth_effort = $this->db->dbprefix('mas_breating_effort');

        $this->tbl_pulse_cap = $this->db->dbprefix('mas_pulse_cap');

        $this->tbl_pulse_skin = $this->db->dbprefix('mas_pulse_skin');

        $this->tbl_lung_aus = $this->db->dbprefix('mas_lung_aus');

        $this->tbl_ptn_addasst = $this->db->dbprefix('ptn_add_assessment');

        $this->tbl_ptn_asst = $this->db->dbprefix('ptn_assessment');

        $this->tbl_loc_level = $this->db->dbprefix('mas_loc_level');

        $this->tbl_cgs_score = $this->db->dbprefix('mas_cgs_score');

        $this->tbl_pptype = $this->db->dbprefix('mas_pupils_type');

        $this->tbl_mas_micnature = $this->db->dbprefix('mas_micnature');
        $this->tbl_dist = $this->db->dbprefix('mas_districts');
    }

//// Created by MI42 ///////////////////////
// 
// Purpose : To get patient incident list.
// 
////////////////////////////////////////////

    function get_pt_inc($args = array()) {

        if ($args['tah_id']) {
            $condition .= " AND inc.inc_tahshil='" . $args['tah_id'] . "' ";
        }

        if ($args['clr_mobile']) {
            $condition .= " AND clr.clr_mobile='" . trim($args['clr_mobile']) . "' ";
        }

        if ($args['inc_cty']) {
            $condition .= " AND inc.inc_city='" . trim($args['inc_cty']) . "' ";
        }

        if ($args['inc_district']) {
            $condition .= " AND inc.inc_district_id IN ('" . trim($args['inc_district']) . "') ";
        }

        if ($args['inc_datef']) {

            $condition .= " AND  inc.inc_datetime > '" . trim($args['inc_datef']) . " 00:00:00' AND inc.inc_datetime < '" . trim($args['inc_datet']) . " 23:59:59' ";
        }

        if ($args['inc_date_time']) {
            $condition .= " AND inc.inc_datetime BETWEEN '" . trim($args['inc_date_time']) . "' AND  '" . trim($args['inc_date_time']) . "' ";
        }

        if ($args['inc_id']) {
            $condition = " AND inc.inc_ref_id='" . trim($args['inc_id']) . "' ";
        }

        $result = $this->db->query("
            

                      SELECT  inc.inc_id,inc.inc_ref_id,inc.inc_address,inc.inc_ero_summary,inc.inc_address,inc.inc_datetime,ptn.ptn_fname,ptn.ptn_lname
                
                FROM ($this->tbl_inc AS inc,$this->tbl_cls AS cl,$this->tbl_clrs AS clr) 
                    
                LEFT JOIN $this->tbl_inc_pt AS incptn ON (incptn.inc_id=inc.inc_ref_id)
                    
                LEFT JOIN $this->tbl_pt AS ptn ON(incptn.ptn_id = ptn.ptn_id)
             
               WHERE inc.inc_base_month IN (" . ($args['base_month'] - 3) . "," . ($args['base_month'] - 2) . "," . ($args['base_month'] - 1) . "," . $args['base_month'] . ") 
                    AND inc.inc_base_month = cl.cl_base_month
                    AND inc.inc_cl_id = cl.cl_id AND cl.cl_clr_id = clr.clr_id 
                    AND incis_deleted='0'  $condition GROUP BY incptn.inc_id");
        


        return $result->result();
    }
    
    function get_pt_inc_search($args = array()) {
//var_dump($args);die;
        $c_date = date('Y-m-d');
        if ($args['tah_id']) {
            $condition .= " AND inc.inc_tahshil='" . $args['tah_id'] . "' ";
        }

        if ($args['clr_mobile']) {
            $condition .= " AND clr.clr_mobile='" . trim($args['clr_mobile']) . "' AND DATE(inc.inc_datetime) = CURDATE() ";
            
        }

        if ($args['inc_cty']) {
            $condition .= " AND inc.inc_city='" . trim($args['inc_cty']) . "' ";
        }

        if ($args['inc_district']) {
            $condition .= " AND inc.inc_district_id='" . trim($args['inc_district']) . "' AND DATE(inc.inc_datetime) = CURDATE()  ";
            
        }

        if ($args['inc_datef']) {

            $condition .= " AND  inc.inc_datetime > '" . trim($args['inc_datef']) . "' AND inc.inc_datetime < '" . trim($args['inc_datet']) . "' ";
        }

        if ($args['inc_date_time']) {
            $condition .= " OR inc.inc_datetime BETWEEN '" . trim($args['inc_date_time']) . "' AND  '" . trim($args['inc_date_time']) . "' ";
        }

        if ($args['inc_time']) {
            if($args['inc_date']){
                $FromTime = trim($args['inc_date']) . " " . trim($args['inc_timef']);
                $ToTime = trim($args['inc_date']) . " " . trim($args['inc_timet']);
            }else{
                $FromTime = $c_date . " " . trim($args['inc_timef']);
                $ToTime = $c_date . " " . trim($args['inc_timet']);
            }
            $condition .= "AND inc.inc_datetime BETWEEN  '" . $FromTime . "' AND '". $ToTime ."'";
           //$condition .= " AND  inc.inc_datetime > '" . trim($args['inc_datef']) . "' AND inc.inc_datetime < '" . trim($args['inc_datet']) . "' ";
        }

        if ($args['inc_id']) {
            $condition = " AND inc.inc_ref_id='" . trim($args['inc_id']) . "' ";
        }
         if ($args['amb_reg_no']) {
            $condition = " AND incamb.amb_rto_register_no='" . trim($args['amb_reg_no']) . "' AND DATE(inc.inc_datetime) = CURDATE()  ";
        }
        
         if ($args['inc_pcr_status']) {
            $condition = " AND inc.inc_pcr_status='" .($args['inc_pcr_status']). "' ";
        }
        
        

        $result = $this->db->query("
            

                      SELECT  inc.inc_id,inc.inc_ref_id,inc.inc_address,inc.inc_ero_summary,inc.inc_address,inc.inc_datetime,ptn.ptn_fname,ptn.ptn_lname
                
                FROM ($this->tbl_inc AS inc,$this->tbl_cls AS cl,$this->tbl_clrs AS clr) 
                    
                LEFT JOIN $this->tbl_inc_pt AS incptn ON (incptn.inc_id=inc.inc_ref_id)
                LEFT JOIN $this->tbl_inc_amb AS incamb ON (incamb.inc_ref_id=inc.inc_ref_id)
                    
                LEFT JOIN $this->tbl_pt AS ptn ON(incptn.ptn_id = ptn.ptn_id)
             
               WHERE inc.inc_base_month IN (" . ($args['base_month'] - 3) . "," . ($args['base_month'] - 2) . "," . ($args['base_month'] - 1) . "," . $args['base_month'] . ") 
                    AND inc.inc_base_month = cl.cl_base_month
                    AND inc.inc_cl_id = cl.cl_id AND cl.cl_clr_id = clr.clr_id 
                    AND incis_deleted='0'  $condition GROUP BY incptn.inc_id ORDER BY inc.inc_datetime DESC");
        //echo $this->db->last_query(); die;

        return $result->result();
    }
    
    function get_pt_inc_search_list($args = array()) {
//var_dump($args);die;
        $c_date = date('Y-m-d');
        if ($args['tah_id']) {
            $condition .= " AND inc.inc_tahshil='" . $args['tah_id'] . "' ";
        }

        if ($args['clr_mobile']) {
            $condition .= " AND clr.clr_mobile LIKE '%" . trim($args['clr_mobile']) . "%' ";
            
        }

        if ($args['inc_cty']) {
            $condition .= " AND inc.inc_city='" . trim($args['inc_cty']) . "' ";
        }

        if ($args['inc_district']) {
            $condition .= " AND inc.inc_district_id='" . trim($args['inc_district']) . "' ";
            
        }

        if ($args['inc_datef']) {

            $condition .= " AND  inc.inc_datetime > '" . trim($args['inc_datef']) . "' AND inc.inc_datetime < '" . trim($args['inc_datet']) . "' ";
        }

        if ($args['inc_date_time']) {
            $condition .= " OR inc.inc_datetime BETWEEN '" . trim($args['inc_date_time']) . "' AND  '" . trim($args['inc_date_time']) . "' ";
        }

        if ($args['inc_time']) {
            if($args['inc_date']){
                $FromTime = trim($args['inc_date']) . " " . trim($args['inc_timef']);
                $ToTime = trim($args['inc_date']) . " " . trim($args['inc_timet']);
            }else{
                $FromTime = $c_date . " " . trim($args['inc_timef']);
                $ToTime = $c_date . " " . trim($args['inc_timet']);
            }
            $condition .= "AND inc.inc_datetime BETWEEN  '" . $FromTime . "' AND '". $ToTime ."'";
           //$condition .= " AND  inc.inc_datetime > '" . trim($args['inc_datef']) . "' AND inc.inc_datetime < '" . trim($args['inc_datet']) . "' ";
        }
        
        if($args['to_date'] != '' && $args['from_data'] != ''){
            $FromTime = $args['from_data'];
            $ToTime = $args['to_date'] ; 
            $condition .= "AND inc.inc_datetime BETWEEN  '" . $ToTime . "' AND '". $FromTime ."'";
        }

        if ($args['inc_id']) {
            $condition .= " AND inc.inc_ref_id='" . trim($args['inc_id']) . "' ";
        }
        
         if ($args['amb_reg_no']) {
            $condition .= " AND incamb.amb_rto_register_no='" . trim($args['amb_reg_no']) . "' ";
        }
        
         if ($args['inc_pcr_status']) {
            $condition .= " AND inc.inc_pcr_status='" .($args['inc_pcr_status']). "' ";
        }
        
        

        $result = $this->db->query("
            

                      SELECT  inc.inc_id,inc.inc_ref_id,inc.inc_address,inc.inc_ero_summary,inc.inc_address,inc.inc_datetime,ptn.ptn_fname,ptn.ptn_lname,incamb.amb_rto_register_no
                
                FROM ($this->tbl_inc AS inc) 
                LEFT JOIN $this->tbl_cls AS cl ON (inc.inc_cl_id = cl.cl_id) 
                LEFT JOIN $this->tbl_clrs AS clr ON (cl.cl_clr_id = clr.clr_id)   
                LEFT JOIN $this->tbl_inc_pt AS incptn ON (incptn.inc_id=inc.inc_ref_id)
                LEFT JOIN $this->tbl_inc_amb AS incamb ON (incamb.inc_ref_id=inc.inc_ref_id)
                    
                LEFT JOIN $this->tbl_pt AS ptn ON(incptn.ptn_id = ptn.ptn_id)
             
               WHERE inc.inc_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ") 
                    AND inc.inc_base_month = cl.cl_base_month
                       
                    AND incis_deleted='0'  $condition GROUP BY incptn.inc_id ORDER BY inc.inc_datetime DESC");
        //echo $this->db->last_query(); die;

        return $result->result();
    }

//// Created by MI42 ///////////////////////
// 
// Purpose : To get patient incident info.
// 
////////////////////////////////////////////
    function get_ptinc_info_non_em($args = array()){
        $condition = " ";

        if ($args['inc_ref_id']) {
            $condition .= " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }
        if ($args['base_month']) {
            $condition .= " AND inc.inc_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")";
        }

        


         $result = $this->db->query("
                 SELECT inc.inc_ref_id,inc.inc_ero_summary,inc.inc_ero_standard_summary,inc.inc_type,inc.inc_datetime,inc.inc_address,inc.inc_area,inc.inc_landmark,inc.inc_patient_cnt,clr.clr_fname,clr.clr_lname,clr.clr_mobile,cl.clr_ralation,cl.cl_purpose,clr.clr_id,cl.cl_id,inc.inc_state_id,inc.inc_district_id,dist.dst_name
           
                FROM ($this->tbl_inc as inc) 
                LEFT JOIN  $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )
                LEFT JOIN $this->tbl_cls as cl on (inc.inc_cl_id = cl.cl_id )
                 LEFT JOIN $this->tbl_clrs as clr on (cl.cl_clr_id = clr.clr_id )
                  WHERE 1=1 AND inc.incis_deleted = '0'  $condition  ORDER BY inc.inc_id ASC");
        
       // echo $this->db->last_query(); die;

        return $result->result();
    }
    function get_ptinc_info($args = array()) {
        
        $condition = " ";

        if ($args['inc_ref_id']) {
            $condition .= " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }
        if ($args['base_month']) {
            $condition .= " AND inc.inc_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")";
        }

        if ($args['ptn_id']) {
            $condition .= " AND incptn.ptn_id='" . $args['ptn_id'] . "' ";
        }


         $result = $this->db->query("SELECT inc.inc_mci_nature,inc.inc_complaint,hp.hp_name,inc.inc_ref_id,inc.inc_ero_summary,inc.inc_ero_standard_summary,inc.help_standard_summary,inc.inc_type,inc.inc_datetime,inc.inc_address,inc.inc_area,inc.inc_landmark,inc.inc_patient_cnt,inc_amb.amb_rto_register_no,amb.amb_default_mobile,clr.clr_fname,clr.clr_lname,clr.clr_mobile,cl.clr_ralation,ptn.ptn_id,ptn.ptn_fname,ptn.ptn_lname,ptn.ptn_mname,ptn.ptn_age,ptn.ptn_age_type,ptn.ptn_gender,ptn.ayushman_id,ptn.ptn_condition,bgrp.bldgrp_name,hp.hp_name,ct.ct_type,clg.clg_first_name,clg.clg_last_name,mn.ntr_nature,cl.cl_purpose,clr.clr_id,cl.cl_id,inc.inc_state_id,inc.inc_district_id,dist.dst_name,inc.inc_complaint_other,inc.inc_added_by,clg_ero.clg_first_name,clg_ero.clg_mid_name,clg_ero.clg_last_name,inc.help_desk_chief_complaint
           
                FROM $this->tbl_inc as inc 
                 LEFT JOIN $this->tbl_inc_amb as inc_amb on (inc_amb.inc_ref_id=inc.inc_ref_id)
                 LEFT JOIN $this->tbl_amb as amb on (amb.amb_rto_register_no=inc_amb.amb_rto_register_no)
                 LEFT JOIN $this->tbl_inc_pt as incptn on (incptn.inc_id=inc.inc_ref_id)
                 LEFT JOIN  $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )
                 LEFT JOIN $this->tbl_pt as ptn on(incptn.ptn_id = ptn.ptn_id AND ptn.ptnis_deleted = '0' ) 
                 LEFT JOIN ems_mas_bloodgrp_type as bgrp on(ptn.ptn_bgroup = bgrp.bldgrp_id) 
                 LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id
                 LEFT JOIN $this->tbl_pt_ctype as ct ON inc.inc_complaint = ct.ct_id  
                 LEFT JOIN $this->tbl_clg as clg ON inc_amb.amb_emt_id = clg.clg_ref_id
                 LEFT JOIN $this->tbl_mas_micnature as mn on(mn.ntr_id=inc.inc_mci_nature) 
                 LEFT JOIN $this->tbl_cls as cl on (inc.inc_cl_id = cl.cl_id )
                 LEFT JOIN $this->tbl_clrs as clr on (cl.cl_clr_id = clr.clr_id )
                 LEFT JOIN ems_colleague as clg_ero on (clg_ero.clg_ref_id = inc.inc_added_by )

                  WHERE 1=1 AND inc.incis_deleted = '0' $condition GROUP BY ptn_id ORDER BY inc.inc_id ASC");
        
//        $result = $this->db->query("
//                    SELECT hp.hp_name,inc.inc_ref_id,inc.inc_ero_summary,inc.inc_ero_standard_summary,inc.inc_type,inc.inc_datetime,inc.inc_address,inc.inc_patient_cnt,amb.amb_rto_register_no,amb.amb_default_mobile,clr.clr_fname,clr.clr_lname,clr.clr_mobile,cl.clr_ralation,ptn.ptn_id,ptn.ptn_fname,ptn.ptn_lname,ptn.ptn_mname,ptn.ptn_age,ptn.ptn_gender,ptn.ptn_condition,hp.hp_name,ct.ct_type,clg.clg_first_name,clg.clg_last_name,mn.ntr_nature,cl.cl_purpose,clr.clr_id,cl.cl_id,inc.inc_state_id,inc.inc_district_id,dist.dst_name
//                
//                    FROM ($this->tbl_inc as inc,$this->tbl_cls as cl,$this->tbl_clrs as clr,$this->tbl_inc_amb as inc_amb,$this->tbl_amb as amb) 
//                       
//                    LEFT JOIN $this->tbl_inc_pt as incptn on (incptn.inc_id=inc.inc_ref_id)
//                    LEFT JOIN  $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )
//                    LEFT JOIN $this->tbl_pt as ptn on(incptn.ptn_id = ptn.ptn_id) 
//                    LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id
//                    LEFT JOIN $this->tbl_pt_ctype as ct ON inc.inc_complaint = ct.ct_id  
//                    LEFT JOIN $this->tbl_clg as clg ON inc_amb.amb_emt_id = clg.clg_ref_id
//                    LEFT JOIN $this->tbl_mas_micnature as mn on(mn.ntr_id=inc.inc_mci_nature)   
//                     WHERE inc.inc_base_month = cl.cl_base_month 
//                    AND inc.inc_cl_id = cl.cl_id AND cl.cl_clr_id = clr.clr_id   
//                AND inc.inc_ref_id = inc_amb.inc_ref_id
//                AND TRIM(inc_amb.amb_rto_register_no) = TRIM(amb.amb_rto_register_no)
//                        AND 1=1 AND inc.incis_deleted = '0' $condition GROUP BY ptn_id ORDER BY inc.inc_id ASC");  


        return $result->result();
    }
    function get_ptinc_info_followup($args = array()) {
        
        $condition = " ";

        if ($args['inc_ref_id']) {
            $condition .= " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }
        if ($args['base_month']) {
            $condition .= " AND inc.inc_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")";
        }

        if ($args['ptn_id']) {
            $condition .= " AND incptn.ptn_id='" . $args['ptn_id'] . "' ";
        }


         $result = $this->db->query("
                 SELECT hp.hp_name,inc.inc_ref_id,inc.inc_ero_summary,inc.inc_ero_standard_summary,inc.inc_type,inc.inc_datetime,inc.inc_address,inc.inc_area,inc.inc_landmark,inc.inc_patient_cnt,inc_amb.amb_rto_register_no,amb.amb_default_mobile,clr.clr_fname,clr.clr_lname,clr.clr_mobile,cl.clr_ralation,ptn.ptn_id,ptn.ptn_fname,ptn.ptn_lname,ptn.ptn_mname,ptn.ptn_age,ptn.ptn_gender,ptn.ptn_condition,hp.hp_name,ct.ct_type,clg.clg_first_name,clg.clg_last_name,mn.ntr_nature,cl.cl_purpose,clr.clr_id,cl.cl_id,inc.inc_state_id,inc.inc_district_id,dist.dst_name
           
                FROM ($this->tbl_inc as inc) 
                 LEFT JOIN $this->tbl_inc_amb as inc_amb on (inc_amb.inc_ref_id=inc.inc_ref_id)
                 LEFT JOIN $this->tbl_amb as amb on (amb.amb_rto_register_no=inc_amb.amb_rto_register_no)
                 LEFT JOIN $this->tbl_inc_pt as incptn on (incptn.inc_id=inc.inc_ref_id)
                 LEFT JOIN  $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )
                 LEFT JOIN $this->tbl_pt as ptn on(incptn.ptn_id = ptn.ptn_id) 
                 LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id
                 LEFT JOIN $this->tbl_pt_ctype as ct ON inc.inc_complaint = ct.ct_id  
                 LEFT JOIN $this->tbl_clg as clg ON inc_amb.amb_emt_id = clg.clg_ref_id
                 LEFT JOIN $this->tbl_mas_micnature as mn on(mn.ntr_id=inc.inc_mci_nature) 
                 LEFT JOIN $this->tbl_cls as cl on (inc.inc_cl_id = cl.cl_id )
                 LEFT JOIN $this->tbl_clrs as clr on (cl.cl_clr_id = clr.clr_id )
                  WHERE 1=1 AND inc.incis_deleted = '4' $condition GROUP BY ptn_id ORDER BY inc.inc_id ASC");
        
//        $result = $this->db->query("
//                    SELECT hp.hp_name,inc.inc_ref_id,inc.inc_ero_summary,inc.inc_ero_standard_summary,inc.inc_type,inc.inc_datetime,inc.inc_address,inc.inc_patient_cnt,amb.amb_rto_register_no,amb.amb_default_mobile,clr.clr_fname,clr.clr_lname,clr.clr_mobile,cl.clr_ralation,ptn.ptn_id,ptn.ptn_fname,ptn.ptn_lname,ptn.ptn_mname,ptn.ptn_age,ptn.ptn_gender,ptn.ptn_condition,hp.hp_name,ct.ct_type,clg.clg_first_name,clg.clg_last_name,mn.ntr_nature,cl.cl_purpose,clr.clr_id,cl.cl_id,inc.inc_state_id,inc.inc_district_id,dist.dst_name
//                
//                    FROM ($this->tbl_inc as inc,$this->tbl_cls as cl,$this->tbl_clrs as clr,$this->tbl_inc_amb as inc_amb,$this->tbl_amb as amb) 
//                       
//                    LEFT JOIN $this->tbl_inc_pt as incptn on (incptn.inc_id=inc.inc_ref_id)
//                    LEFT JOIN  $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )
//                    LEFT JOIN $this->tbl_pt as ptn on(incptn.ptn_id = ptn.ptn_id) 
//                    LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id
//                    LEFT JOIN $this->tbl_pt_ctype as ct ON inc.inc_complaint = ct.ct_id  
//                    LEFT JOIN $this->tbl_clg as clg ON inc_amb.amb_emt_id = clg.clg_ref_id
//                    LEFT JOIN $this->tbl_mas_micnature as mn on(mn.ntr_id=inc.inc_mci_nature)   
//                     WHERE inc.inc_base_month = cl.cl_base_month 
//                    AND inc.inc_cl_id = cl.cl_id AND cl.cl_clr_id = clr.clr_id   
//                AND inc.inc_ref_id = inc_amb.inc_ref_id
//                AND TRIM(inc_amb.amb_rto_register_no) = TRIM(amb.amb_rto_register_no)
//                        AND 1=1 AND inc.incis_deleted = '0' $condition GROUP BY ptn_id ORDER BY inc.inc_id ASC");  
   // echo $this->db->last_query(); die;
        return $result->result();
    }

    function get_ptinc_info_quality($args = array()) {
        
        $condition = " ";

        if ($args['inc_ref_id']) {
            $condition .= " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }
        if ($args['base_month']) {
            $condition .= " AND inc.inc_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")";
        }

        if ($args['ptn_id']) {
            $condition .= " AND incptn.ptn_id='" . $args['ptn_id'] . "' ";
        }

        $result = $this->db->query("
                    SELECT hp.hp_name,inc.inc_ref_id,inc.inc_ero_summary,inc.inc_ero_standard_summary,inc.inc_type,inc.inc_datetime,inc.inc_address,inc.inc_patient_cnt,amb.amb_rto_register_no,amb.amb_default_mobile,clr.clr_fname,clr.clr_lname,clr.clr_mobile,cl.clr_ralation,ptn.ptn_id,ptn.ptn_fname,ptn.ptn_lname,ptn.ptn_mname,ptn.ptn_age,ptn.ptn_gender,ptn.ptn_condition,hp.hp_name,ct.ct_type,clg.clg_first_name,clg.clg_last_name,mn.ntr_nature,cl.cl_purpose,clr.clr_id,cl.cl_id,inc.inc_state_id,inc.inc_district_id,dist.dst_name
                
                    FROM ($this->tbl_inc as inc,$this->tbl_cls as cl,$this->tbl_clrs as clr,$this->tbl_inc_amb as inc_amb,$this->tbl_amb as amb) 
                       
                    LEFT JOIN $this->tbl_inc_pt as incptn on (incptn.inc_id=inc.inc_ref_id)
                    LEFT JOIN  $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )
                    LEFT JOIN $this->tbl_pt as ptn on(incptn.ptn_id = ptn.ptn_id) 
                    LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id
                    LEFT JOIN $this->tbl_pt_ctype as ct ON inc.inc_complaint = ct.ct_id  
                    LEFT JOIN $this->tbl_clg as clg ON inc_amb.amb_emt_id = clg.clg_ref_id
                    LEFT JOIN $this->tbl_mas_micnature as mn on(mn.ntr_id=inc.inc_mci_nature)   
                     WHERE inc.inc_base_month = cl.cl_base_month 
                     AND inc.inc_cl_id = cl.cl_id AND cl.cl_clr_id = clr.clr_id
                AND inc.inc_ref_id = inc_amb.inc_ref_id
                AND TRIM(inc_amb.amb_rto_register_no) = TRIM(amb.amb_rto_register_no)
                        AND 1=1 AND inc.incis_deleted = '0' $condition GROUP BY ptn_id ORDER BY inc.inc_id ASC");  
       
     // echo $this->db->last_query(); die;
        return $result->result();
    }

//// Created by MI42 ///////////////////////
// 
// Purpose : To get patient info.
// 
////////////////////////////////////////////

    function get_petinfo($args = array()) {
        

        $result = $this->db->query("SELECT ptn.*,ptn_occ.occ_type FROM $this->tbl_pt as ptn
                
            LEFT JOIN $this->tbl_ptn_occ AS ptn_occ ON(ptn.ptn_occupation=ptn_occ.occ_id)
            
            WHERE ptn.ptn_id='" . $args['ptn_id'] . "' AND ptn.ptnis_deleted='0'");

        return $result->result();
    }

//// Created by MI42 ///////////////////////
// 
// Purpose : To get patient occupation.
// 
////////////////////////////////////////////

    function get_occup($args = array()) {

        if (trim($args['occ_type']) != '') {
            $condition = " AND occ_type LIKE '" . $args['occ_type'] . "%' ";
        }

        $result = $this->db->query("
            SELECT * FROM $this->tbl_ptn_occ 
            WHERE occis_deleted='0' $condition
            ");



        return $result->result();
    }

//// Created by MI42 ///////////////////////
// 
// Purpose : To update patient info.
// 
////////////////////////////////////////////

    function updte_patient_details($args = array(), $data = array()) {

        if($args['ptn_id'] != ''){
            $this->db->where('ptn_id', $args['ptn_id']);

            $res = $this->db->update($this->tbl_pt, $data);

            return $res;
        }
    }

//// Created by MI42 ///////////////////////
// 
// Purpose : To insert patient info.
// 
////////////////////////////////////////////

    function insert_patient_details($args = array()) {

        if($args['ptn_birth_date'] == ''){
            unset($args['ptn_birth_date']);
        }
        $result = $this->db->insert($this->tbl_pt, $args);

//        if($_SERVER["REMOTE_ADDR"] == '36.255.108.253'){
           //echo $this->db->last_query(); die;
//        }
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    function insert_ems_patient_details($args = array()) {

        
        $result = $this->db->insert($this->tbl_pt, $args);
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    function insert_updated_patient_details($args =array()){
        
        $result =  $this->db->insert($this->tbl_pt, $args);
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    function insert_inc_pat($args = array()) {
        
         $unique_id = get_uniqid( $this->session->userdata('user_default_key'));
        $args['id'] = $unique_id;

        $result = $this->db->insert($this->tbl_inc_pt, $args);
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

//// Created by MI42 ///////////////////////
// 
// Purpose : To save patient history.
// 
////////////////////////////////////////////

    function save_pet_hc($args = array()) {


        $res = $this->db->query(" INSERT INTO $this->tbl_ptn_hc(pcr_id,case_id,case_other,hc_date,hc_base_month) 

             VALUES('" . $args['pcr_id'] . "','" . $args['case_id'] . "','" . $args['case_other'] . "','" . $args['hc_date'] . "'," . $args['hc_base_month'] . ") 
            
             ON DUPLICATE KEY UPDATE pcr_id = '" . $args['pcr_id'] . "',case_id='" . $args['case_id'] . "',case_other='" . $args['case_other'] . "'"
        );



        return $res;
    }

//// Created by MI42 ///////////////////////
// 
// Purpose : To insert patient history.
// 
////////////////////////////////////////////

    function get_pet_hc($args = array()) {

        $condition = "";

        if ($args['pcr_id']) {
            $condition .= " AND ptn_hc.pcr_id='" . $args['pcr_id'] . "'";
        }


        $result = $this->db->query("
            SELECT * FROM $this->tbl_ptn_hc  as ptn_hc
            WHERE hc_isdeleted='0' $condition
            ");



        return $result->result();
    }
  //// Created by MI13 ///////////////////////
// 
// Purpose : To get patient  history.
// 
////////////////////////////////////////////  
      function get_patient_details($args = array(),$inc_id) {

        $result = $this->db->query("
           SELECT * FROM $this->tbl_pt  as ptn
             LEFT JOIN $this->tbl_inc_pt AS incptn on(incptn.ptn_id = ptn.ptn_id) 
           WHERE ptn.ptnis_deleted='0' AND 
           ptn.ptn_fname='" . $args['ptn_fname'] . "' AND
           ptn.ptn_lname='" . $args['ptn_lname'] . "'  AND ptn.ptn_age = '" . $args['ptn_age'] . "' AND ptn.ptn_gender = '" . $args['ptn_gender'] . "'  AND incptn.inc_id = '" . $inc_id. "' ");

       
        return $result->result();

        return $res;
    }

//// Created by MI42 ///////////////////////
// 
// Purpose : To insert patient medical history.
// 
////////////////////////////////////////////

    function save_pet_mh($args = array()) {



        $res = $this->db->query(" INSERT INTO $this->tbl_ptn_mh(pcr_id,dis_id,mh_date,mh_base_month) 

            VALUES('" . $args['pcr_id'] . "','" . $args['dis_id'] . "','" . $args['mh_date'] . "'," . $args['mh_base_month'] . ") 

            ON DUPLICATE KEY UPDATE pcr_id = '" . $args['pcr_id'] . "',dis_id='" . $args['dis_id'] . "'"
        );


        return $res;
    }

//// Created by MI42 ///////////////////////
// 
// Purpose : To get patient medical history.
// 
////////////////////////////////////////////

    function get_pet_mh($args = array()) {

        $condition = "";

        if ($args['pcr_id']) {
            $condition .= " AND ptn_mh.pcr_id='" . $args['pcr_id'] . "'";
        }


        $result = $this->db->query("
            SELECT * FROM $this->tbl_ptn_mh  as ptn_mh
            WHERE mh_isdeleted='0' $condition
            ");



        return $result->result();

        return $res;
    }

//// Created by MI42 ///////////////////////
// 
// Purpose : To insert patient history.
// 
////////////////////////////////////////////

    function save_pet_cc($args = array()) {



        $res = $this->db->query(" INSERT INTO $this->tbl_ptn_cc(pcr_id,ct_id,cc_other,cc_date,cc_base_month) 

            VALUES('" . $args['pcr_id'] . "','" . $args['ct_id'] . "','" . $args['cc_other'] . "','" . $args['cc_date'] . "'," . $args['cc_base_month'] . ") 

            ON DUPLICATE KEY UPDATE pcr_id = '" . $args['pcr_id'] . "',ct_id='" . $args['ct_id'] . "',cc_other='" . $args['cc_other'] . "'"
        );




        return $res;
    }

//// Created by MI42 ///////////////////////
// 
// Purpose : To get patient medical history.
// 
////////////////////////////////////////////

    function get_pet_cc($args = array()) {

        $condition = "";

        if ($args['pcr_id']) {
            $condition .= " AND ptn_cc.pcr_id='" . $args['pcr_id'] . "'";
        }

        $result = $this->db->query("
            SELECT * FROM $this->tbl_ptn_cc  as ptn_cc
            WHERE cc_isdeleted='0' $condition
            ");



        return $result->result();

        return $res;
    }

//// Created by MI42 ///////////////////////
// 
// Purpose : To save patient medicines history.
// 
////////////////////////////////////////////

    function insert_pet_med($args = array()) {

        $res = $this->db->query(" INSERT INTO $this->tbl_ptn_cur_med(pcr_id,med_title,med_date,med_base_month) 

            VALUES('" . $args['pcr_id'] . "','" . $args['med_title'] . "','" . $args['med_date'] . "'," . $args['med_base_month'] . ") 

            ON DUPLICATE KEY UPDATE pcr_id = '" . $args['pcr_id'] . "',med_title='" . $args['med_title'] . "'"
        );



        return $res;
    }

//// Created by MI42 ///////////////////////
// 
// Purpose : To get patient medical history.
// 
////////////////////////////////////////////

    function get_pet_med($args = array()) {

        $condition = "";

        if ($args['pcr_id']) {
            $condition .= " AND ptn_cur_med.pcr_id='" . $args['pcr_id'] . "'";
        }


        $result = $this->db->query("
            SELECT * FROM $this->tbl_ptn_cur_med  as ptn_cur_med
            WHERE med_isdeleted='0' $condition
            ");


        return $result->result();

        return $res;
    }

//// Created by MI42 ///////////////////////
// 
// Purpose : To insert petients other diseses.
// 
////////////////////////////////////////////

    function save_pet_dis($args = array()) {

        $result = $this->db->query("
           SELECT * FROM $this->tbl_diseases  as ptn_dis
           WHERE ptn_dis.dis_isdeleted='0' AND 
           ptn_dis.dis_title='" . $args['dis_title'] . "' AND
           ptn_dis.dis_type='" . $args['dis_type'] . "'    
           ");

        $rs = $result->result();

        if (empty($rs)) {

            $res = $this->db->insert($this->tbl_diseases, $args);

            return $this->db->insert_id();
        } else {

            return $rs[0]->dis_id;
        }
    }

    //// Created by MI42 ///////////////////////
    // 
    // Purpose : To get breating rate.
    // 
    ////////////////////////////////////////////

    function get_breathing_rate($args = array()) {

        $condition = "";

        if (trim($args['br_rate']) != '') {

            $condition .= " AND br.rate_type LIKE '" . $args['br_rate'] . "%' ";
        }

        $result = $this->db->query("SELECT br.* FROM $this->tbl_brth_rate as br WHERE  br.rate_isdeleted='0' 
            $condition");

        return $result->result();
    }

    //// Created by MI42 ///////////////////////
    // 
    // Purpose : To get breating effort.
    // 
    ////////////////////////////////////////////

    function get_breathing_effort($args = array()) {

        $condition = "";

        if (trim($args['eff_type']) != '') {

            $condition .= " AND be.effort_type LIKE '" . $args['eff_type'] . "%' ";
        }

        $result = $this->db->query("SELECT be.* FROM $this->tbl_brth_effort as be WHERE  be.effort_isdeleted='0' 
            $condition");

        return $result->result();
    }

    //// Created by MI42 ///////////////////////
    // 
    // Purpose : To get pulse cap.
    // 
    ////////////////////////////////////////////

    function get_pulse_cap($args = array()) {

        $condition = "";

        if (trim($args['pc_type']) != '') {

            $condition .= " AND pc.pc_type LIKE '" . $args['pc_type'] . "%' ";
        }

        $result = $this->db->query("SELECT pc.* FROM $this->tbl_pulse_cap as pc WHERE  pc.pc_isdeleted='0' 
            $condition");

        return $result->result();
    }

    //// Created by MI42 ///////////////////////
    // 
    // Purpose : To get pulse skin.
    // 
    ////////////////////////////////////////////

    function get_pulse_skin($args = array()) {

        $condition = "";

        if (trim($args['ps_type']) != '') {

            $condition .= " AND ps.ps_type LIKE '" . $args['ps_type'] . "%' ";
        }
        if (trim($args['ps_id']) != '') {

            $condition .= " AND ps.ps_id = '" . $args['ps_id'] . "' ";
        }

        $result = $this->db->query("SELECT ps.* FROM $this->tbl_pulse_skin as ps WHERE  ps.ps_isdeleted='0' 
            $condition");

        return $result->result();
    }

    //// Created by MI42 ///////////////////////
    // 
    // Purpose : To get lung asculatation.
    // 
    ////////////////////////////////////////////

    function get_lung_aus($args = array()) {

        $condition = "";

        if (trim($args['la_type']) != '') {

            $condition .= " AND la.la_type LIKE '" . $args['la_type'] . "%' ";
        }

        $result = $this->db->query("SELECT la.* FROM $this->tbl_lung_aus as la WHERE  la.la_isdeleted='0' 
            $condition");

        return $result->result();
    }

    //// Created by MI42 ///////////////////////
    // 
    // Purpose : To insert patient assessment.
    // 
    ////////////////////////////////////////////

    function save_patient_asst($args = array()) {

        $res = $this->db->query(" INSERT INTO $this->tbl_ptn_asst(pcr_id,asst_loc,asst_pulse,asst_rr,asst_bp_syt,asst_bp_dia,asst_o2sat,asst_temp,asst_pt_status,asst_date,asst_base_month,asst_min) 

            VALUES('" . $args['pcr_id'] . "','" . $args['asst_loc'] . "','" . $args['asst_pulse'] . "','" . $args['asst_rr'] . "','" . $args['asst_bp_syt'] . "','" . $args['asst_bp_dia'] . "','" . $args['asst_o2sat'] . "','" . $args['asst_temp'] . "','" . $args['asst_pt_status'] . "','" . $args['asst_date'] . "','" . $args['asst_base_month'] . "','" . $args['asst_min'] . "')

            ON DUPLICATE KEY UPDATE pcr_id = '" . $args['pcr_id'] . "',asst_loc='" . $args['asst_loc'] . "',asst_pulse='" . $args['asst_pulse'] . "',asst_rr='" . $args['asst_rr'] . "',asst_bp_syt='" . $args['asst_bp_syt'] . "',asst_bp_dia='" . $args['asst_bp_dia'] . "',asst_o2sat='" . $args['asst_o2sat'] . "',asst_temp='" . $args['asst_temp'] . "',asst_pt_status='" . $args['asst_pt_status'] . "',asst_date='" . $args['asst_date'] . "',asst_base_month='" . $args['asst_base_month'] . "',asst_min='" . $args['asst_min'] . "'"
        );




        return $res;
    }

    //// Created by MI42 ///////////////////////
    // 
    // Purpose : To get patient assessment.
    // 
    ////////////////////////////////////////////

    function get_patient_asst($args = array()) {

        $condition = "";

        if ($args['pcr_id']) {
            $condition .= " AND ptn_asst.pcr_id='" . $args['pcr_id'] . "'";
        }

        if ($args['asst_min']) {
            $condition .= " AND ptn_asst.asst_min='" . $args['asst_min'] . "'";
        } else {
            $condition .= " AND ptn_asst.asst_min='0'";
        }

        $result = $this->db->query("
            SELECT ptn_asst.*,loc_level.level_type 
            FROM   $this->tbl_ptn_asst as ptn_asst 
            LEFT JOIN $this->tbl_loc_level as loc_level ON(ptn_asst.asst_loc=loc_level.level_id) 
            WHERE  ptn_asst.asst_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ") AND ptn_asst.asst_isdeleted='0'  
            $condition");



        return $result->result();
    }

    //// Created by MI42 ///////////////////////
    // 
    // Purpose : To insert patient assessment.
    // 
    ////////////////////////////////////////////

    function save_patient_addasst($args = array()) {


        if ($args['asst1']) {

            $res = $this->db->query(" INSERT INTO $this->tbl_ptn_addasst(pcr_id,asst_breath_satus,asst_breath_rate,asst_breath_effort,asst_pulse_radial,asst_pulse_carotid,asst_pulse_cap,asst_pulse_skin,asst_gcs,asst_bsl,asst_pupils_right,asst_pupils_left,asst_la_right_air,asst_la_right_adds,asst_la_left_air,asst_la_left_adds,asst_ptn_his,asst_date,asst_base_month) 

            VALUES('" . $args['pcr_id'] . "','" . $args['asst_breath_satus'] . "','" . $args['asst_breath_rate'] . "','" . $args['asst_breath_effort'] . "','" . $args['asst_pulse_radial'] . "','" . $args['asst_pulse_carotid'] . "','" . $args['asst_pulse_cap'] . "','" . $args['asst_pulse_skin'] . "','" . $args['asst_gcs'] . "','" . $args['asst_bsl'] . "','" . $args['asst_pupils_right'] . "','" . $args['asst_pupils_left'] . "','" . $args['asst_la_right_air'] . "','" . $args['asst_la_right_adds'] . "','" . $args['asst_la_left_air'] . "','" . $args['asst_la_left_adds'] . "','" . $args['asst_ptn_his'] . "','" . $args['asst_date'] . "','" . $args['asst_base_month'] . "')

            ON DUPLICATE KEY UPDATE pcr_id = '" . $args['pcr_id'] . "',asst_breath_satus='" . $args['asst_breath_satus'] . "',asst_breath_rate='" . $args['asst_breath_rate'] . "',asst_breath_effort='" . $args['asst_breath_effort'] . "',asst_pulse_radial='" . $args['asst_pulse_radial'] . "',asst_pulse_carotid='" . $args['asst_pulse_carotid'] . "',asst_pulse_cap='" . $args['asst_pulse_cap'] . "',asst_pulse_skin='" . $args['asst_pulse_skin'] . "',asst_gcs='" . $args['asst_gcs'] . "',asst_bsl='" . $args['asst_bsl'] . "',asst_pupils_right='" . $args['asst_pupils_right'] . "',asst_pupils_left='" . $args['asst_pupils_left'] . "',asst_la_right_air='" . $args['asst_la_right_air'] . "',asst_la_right_adds='" . $args['asst_la_right_adds'] . "',asst_la_left_air='" . $args['asst_la_left_air'] . "',asst_la_left_adds='" . $args['asst_la_left_adds'] . "',asst_ptn_his='" . $args['asst_ptn_his'] . "',asst_date='" . $args['asst_date'] . "',asst_base_month='" . $args['asst_base_month'] . "'"
            );
        } else {

            /////////////////////////////////////////////////////////////////


            $res = $this->db->query(" INSERT INTO $this->tbl_ptn_addasst(pcr_id,asst_pdignosis,asst_other_pdignosis,asst_phy_notes) 

            VALUES('" . $args['pcr_id'] . "','" . $args['asst_pdignosis'] . "','" . $args['asst_other_pdignosis'] . "','" . $args['asst_phy_notes'] . "')

            ON DUPLICATE KEY UPDATE pcr_id = '" . $args['pcr_id'] . "',asst_pdignosis='" . $args['asst_pdignosis'] . "',asst_other_pdignosis='" . $args['asst_other_pdignosis'] . "',asst_phy_notes='" . $args['asst_phy_notes'] . "'"
            );
        }


        return $res;
    }

    //// Created by MI42 ///////////////////////////
    // 
    // Purpose : To get patient addition assessment.
    // 
    ///////////////////////////////////////////////

    function get_patient_addasst($args = array()) {

        $condition = "";

        if ($args['pcr_id']) {
            $condition = " AND ptn_addasst.pcr_id='" . $args['pcr_id'] . "'";
        }
        if ($args['asst_type']) {
            $condition .= " AND ptn_addasst.asst_type='" . $args['asst_type'] . "'";
        }



        $result = $this->db->query("
            
            SELECT ptn_addasst.*,br.rate_type,be.effort_type,pc.pc_type,ps.ps_type,cgs.score,pp1.pp_type as pp_type_right,pp2.pp_type as pp_type_left,la1.la_type as right_la,la2.la_type left_la
            

            FROM   $this->tbl_ptn_addasst as ptn_addasst 


            LEFT JOIN $this->tbl_brth_rate as br ON(ptn_addasst.asst_breath_rate=br.rate_id)
                
            LEFT JOIN $this->tbl_brth_effort as be ON(ptn_addasst.asst_breath_effort=be.effort_id)
                
            LEFT JOIN $this->tbl_pulse_cap as pc ON(ptn_addasst.asst_pulse_cap=pc.pc_id)
                
            LEFT JOIN $this->tbl_pulse_skin as ps ON(ptn_addasst.asst_pulse_skin=ps.ps_id)
                
            LEFT JOIN $this->tbl_cgs_score as cgs ON(ptn_addasst.asst_gcs=cgs.score_id)
            
            LEFT JOIN $this->tbl_pptype as pp1 ON(ptn_addasst.asst_pupils_right=pp1.pp_id)
                
            LEFT JOIN $this->tbl_pptype as pp2 ON(ptn_addasst.asst_pupils_left=pp2.pp_id)
                
            LEFT JOIN $this->tbl_lung_aus as la1 ON(ptn_addasst.asst_la_right_adds=la1.la_id)
                
            LEFT JOIN $this->tbl_lung_aus as la2 ON(ptn_addasst.asst_la_left_adds=la2.la_id)


            WHERE  ptn_addasst.asst_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ") AND ptn_addasst.asst_isdeleted='0'  
            $condition");



        return $result->result();
    }

    //// Created by MI42 ///////////////////////
    // 
    // Purpose : To update patient info.
    // 
    //////////////////////////////////////////// 

    function update_petinfo($args = array(), $data = array()) {

        if($args['ptn_id'] != ''){
            $this->db->where('ptn_id', $args['ptn_id']);

            $res = $this->db->update($this->tbl_pt, $data);

            return $res;
        }
    }

    ////////////////////////////////////////

    function update_validate_patinfo($args1,$pat_id){
        if($pat_id != ''){
            // echo "hii";
            $this->db->where('ptn_id', $pat_id);

            $res = $this->db->update('ems_epcr', $args1);

            return $res;
        }
    }

    function last_insert_pat_id() {
        $result = $this->db->query("SELECT MAX(p_id) as  p_id FROM $this->tbl_pt");

        return $result->result();
    }

}
