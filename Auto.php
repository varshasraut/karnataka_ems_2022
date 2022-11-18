<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auto extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->load->model(array('options_model', 'manufacture_model', 'med_model', 'eqp_model', 'inv_model', 'hp_model', 'cmplnt_model', 'colleagues_model', 'call_model', 'amb_model', 'feedback_model', 'pet_model', 'medadv_model', 'pcr_model', 'school_model', 'schedule_model', 'dashboard_model', 'student_model', 'fleet_model'));

        $this->load->helper(array('url', 'comman_helper'));

        $this->post = $this->input->get_post(NULL);
    }

    public function index($generated = false) {

        echo "This is Auto controller";
    }

    //// Created by MI42 ////////////////////////////////////////////////
    // 
    // Purpose : To get time interval autocomplete( AS : 12AM-12PM ).
    // 
    /////////////////////////////////////////////////////////////////////

    function get_tinterval() {


        $start = "00:00";
        $end = "24:00";

        $tStart = strtotime($start);
        $tEnd = strtotime($end);
        $from = $tNow = $tStart;

        while ($tNow < $tEnd) {

            $tNow = $to = strtotime('+60 minutes', $from);

            $tm = date("hA", $from) . '-' . date("hA", $to);

            $lbl = date("h A", $from) . '-' . date("h A", $to);

            $from = $to;

            $data[] = array("id" => $tm, "label" => $lbl, "value" => $lbl);
        }

        echo json_encode($data);

        close_db_con();

        die;
    }
    

    //// Created by MI42 ////////////////////////////////////////////////
    // 
    // Purpose : To get consumable/nonconsumable item list autocomplete.
    // 
    /////////////////////////////////////////////////////////////////////

    function get_inv_items() {



        $item_term = $this->input->get_post('term');

        $inv_type = $this->uri->segment(3);

        ////////////////////////////////////////////////////

        if ($this->uri->segment(4) == 'dq') {

            $str = $inv_type . "items";

            $inv_ids = $_COOKIE[$str];
        }

        ///////////////////////////////////////////////////////

        if ($item_term != "") {


            $invitem = $this->inv_model->get_inv_active_item(array('inv_ids' => $inv_ids, 'inv_type' => $inv_type, 'inv_item' => $item_term));

            if ($invitem) {

                foreach ($invitem as $item) {


                    $data[] = array("id" => $item->inv_id, "label" => stripslashes($item->inv_title), "value" => stripslashes($item->inv_title));
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    //// Created by MI42 ////////////////////////////////////////////////
    // 
    // Purpose : To get inventory medicines list autocomplete.
    // 
    /////////////////////////////////////////////////////////////////////

    function get_inv_med() {

        $term = $this->input->get_post('term');

        ////////////////////////////////////////////////////

        if ($this->uri->segment(3) == 'dq') {

            $med_ids = $_COOKIE['MEDitems'];
        }


        ////////////////////////////////////////////////////////////

        if ($term != "") {

            $med = $this->med_model->get_med(array('med_ids' => $med_ids, 'med_name' => $term));

            if ($med) {

                foreach ($med as $md) {

                    $data[] = array("id" => $md->med_id, "label" => stripslashes($md->med_title), "value" => stripslashes($md->med_title));
                }
            }



            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    //// Created by MI42 ////////////////////////////////////////////////
    // 
    // Purpose : To get inventory equipments list autocomplete.
    // 
    /////////////////////////////////////////////////////////////////////

    function get_inv_eqp() {

        //var_dump($this->uri->segment(3));die;
        if ($this->uri->segment(3) == 'dq') {

            $eqp_ids = $_COOKIE['EQPitems'];
            
        }
        if ($this->uri->segment(4) != '') {

            $eqp_type = $this->uri->segment(4);
        }
        // $eqp_ids = 'EQP';
        ////////////////////////////////////////////////////////////

        $term = $this->input->get_post('term', TRUE);



        if ($term != "") {

            $eqp = $this->eqp_model->get_eqp(array('eqp_ids' => $eqp_ids, 'eqp_name' => $term, 'eqp_type' => $eqp_type));


            if ($eqp) {

                foreach ($eqp as $eq) {

                    $data[] = array("id" => $eq->eqp_id, "label" => stripslashes($eq->eqp_name), "value" => stripslashes($eq->eqp_name));
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    //// Created by MI42 ////////////////////////////////////////////////
    // 
    // Purpose : To get call complaint type list autocomplete.
    // 
    /////////////////////////////////////////////////////////////////////

    function get_cct_type() {

        $term = $this->input->get_post('term', TRUE);



        if ($term != "") {

            $res = $this->cmplnt_model->get_cct_type(array('cct_type' => $term));

            if ($res) {

                foreach ($res as $cc) {

                    $data[] = array("id" => $cc->cct_id, "label" => $cc->cct_type, "value" => $cc->cct_type);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_department() {

        $term = $this->input->get_post('term', TRUE);



        if ($term != "") {

            $res = $this->cmplnt_model->get_department_type(array('dept_name' => $term));

            if ($res) {

                foreach ($res as $cc) {

                    $data[] = array("id" => $cc->dept_id, "label" => $cc->dept_name, "value" => $cc->dept_name);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    //// Created by MI42 ////////////////////////////////////////////////
    // 
    // Purpose : To get city list autocomplete.
    // 
    /////////////////////////////////////////////////////////////////////

    function city() {

        $term = $this->input->get_post('term', TRUE);

        if ($term != "") {

            if (trim($term) == "") {
                $term = "A";
            }

            $res = $this->common_model->get_city(array('term' => $term), 50, 0);


            if ($res) {

                foreach ($res as $cty) {

                    $data[] = array("id" => $cty->cty_id, "label" => $cty->cty_name, "value" => $cty->cty_name);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    //// Created by MI42 ////////////////////////////////////////////////
    // 
    // Purpose : To get feedback autocomplete.
    // 
    /////////////////////////////////////////////////////////////////////

    function feedback_type() {

        $term = $this->input->get_post('term', TRUE);

        if ($term != "") {



            $res = $this->feedback_model->get_fdbk_type(array('fdbk_type' => $term));


            if ($res) {

                foreach ($res as $ftype) {

                    $data[] = array("id" => $ftype->fdt_id, "label" => $ftype->fdt_type, "value" => $ftype->fdt_type);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    ////////////////MI44/////////////

    function get_dst_view($st_code = '', $dst_code = '') {


        if ($this->input->post('state') != '' && $st_code == '') {
            $st_code = $this->input->post('state');
        } else {
            return false;
        }

        $option = get_st_to_dst($st_code, $dst_code);


        $data['option'] = $option;


        $this->output->add_to_position($this->load->view('frontend/common/get_district_view', $data, TRUE), 'get_dst', TRUE);
    }

    function get_thl_view($dst_code = '', $thl_code = '') {


        if ($this->input->post('district') != '' && $dst_code == '') {
            $dst_code = $this->input->post('district');
        } else {
            return false;
        }


        $option = get_tahshil($dst_code, $thl_code);



        $data['option'] = $option;

        $this->output->add_to_position($this->load->view('frontend/common/get_tashil_view', $data, TRUE), 'get_tahshil', TRUE);
    }

//    function get_cty_view($thl_code = '', $cty_code = '') {
//        
//        if ($this->input->post('tahshil') != '' && $thl_code == '') {
//            $thl_code = $this->input->post('tahshil');
//        } else {
//            return false;
//        }
//
//        $option = get_city($thl_code);
//
//        $data['option'] = $option;
//
//
//        $this->output->add_to_position($this->load->view('frontend/common/get_cities_view', $data, TRUE), 'get_cities', TRUE);
//    }


    function get_dis_city($thl_code = '', $cty_code = '') {


        $dc = $this->uri->segment(3);

        if (trim($dc) != '') {


            $term = $this->input->get_post('term', TRUE);

            $res = $this->common_model->get_city(array('dist_code' => $dc, 'term' => $term));

            if ($res) {

                foreach ($res as $cty) {

                    $cty_data[] = array("id" => $cty->cty_id, "label" => $cty->cty_name, "value" => $cty->cty_name);
                }
            }


            echo json_encode($cty_data);
        }

        close_db_con();

        die;
    }

    function get_tahsil_city($thl_code = '', $cty_code = '') {


        $dc = $this->uri->segment(3);

        if (trim($dc) != '') {


            $term = $this->input->get_post('term', TRUE);

            $res = $this->common_model->get_city(array('thl_code' => $dc, 'term' => $term));

            if ($res) {

                foreach ($res as $cty) {

                    $cty_data[] = array("id" => $cty->cty_id, "label" => $cty->cty_name, "value" => $cty->cty_name);
                }
            }


            echo json_encode($cty_data);
        }

        close_db_con();

        die;
    }

    //// Created by MI44 ////////////////////////////////////////////////
    // 
    // Purpose : To get hospital list autocomplete.
    // 
    /////////////////////////////////////////////////////////////////////



    function get_hospital() {

        $term = $this->input->get_post('term', TRUE);

        if ($term != "") {

            $hosp = $this->hp_model->get_hp_data(array('hp_name' => $term));

            if ($hosp) {

                foreach ($hosp as $hpname) {

                    $data[] = array("id" => $hpname->hp_id, "label" => $hpname->hp_name, "value" => $hpname->hp_name);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_hospital_with_ambu() {

        $term = $this->input->get_post('term', TRUE);

        $dist = $this->input->get('dist', TRUE);

        if ($term != "") {

            $hosp = $this->hp_model->get_hp_data_with_amb(array('hp_name' => $term, 'dist' => $dist));

            //var_dump($hosp);

            if ($hosp) {

                foreach ($hosp as $hpname) {

                    $data[] = array("id" => $hpname->hp_id, "label" => $hpname->hp_name . ', ' . $hpname->amb_rto_register_no, "value" => $hpname->hp_name);
                }
            }
            $data[] = array("id" => 'on_scene_care', "label" => 'On scene care', "value" => "On scene care");
            $data[] = array("id" => 'at_scene_care', "label" => 'At Scene Care', "value" => "At Scene Care");
//            $data[] = array("id" => 'sickroom', "label" => 'Sick Room', "value" => "Sick Room");
            $data[] = array("id" => 'Other', "label" => 'Other', "value" => "Other");
            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_ptn_hospital() {

        $term = $this->input->get_post('term', TRUE);

        $dist = $this->input->get('dist', TRUE);

        if ($term != "") {

            $hosp = $this->hp_model->get_hp_data_with_amb(array('hp_name' => $term, 'dist' => $dist));

            //var_dump($hosp);

            if ($hosp) {

                foreach ($hosp as $hpname) {

                    $data[] = array("id" => $hpname->hp_id, "label" => $hpname->hp_name, "value" => $hpname->hp_name);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_district() {

        $sc = $this->uri->segment(3);
        

        if ($sc) {


            $term = trim($this->input->get_post('term', TRUE));


            $dist = $this->common_model->get_district(array('st_id' => $sc, 'term' => $term));

            if ($dist) {

                foreach ($dist as $district) {

                    $data[] = array("id" => $district->dst_code, "label" => $district->dst_name, "value" => $district->dst_name);
                }
            }

            echo json_encode($data);
        }

        close_db_con();

        die;
    }
    
    function get_zone() {

        $sc = $this->uri->segment(3);


      //  if ($sc) {


            $term = trim($this->input->get_post('term', TRUE));


            $dist = $this->common_model->get_zone(array('term' => $term));
            

            if ($dist) {

                foreach ($dist as $district) {

                    $data[] = array("id" => $district->zn_id, "label" => $district->zone_name, "value" => $district->zone_name);
                }
            }

            echo json_encode($data);
       // }

        close_db_con();

        die;
    }

    function get_hospital_location() {

        $sc = $this->uri->segment(3);


        if ($sc) {


            $term = trim($this->input->get_post('term', TRUE));


            $dist = $this->pcr_model->get_hospital_location(array('hp_district' => $sc, 'term' => $term));

            if ($dist) {

                foreach ($dist as $district) {

                    $data[] = array("id" => $district->hp_id, "label" => $district->hp_name, "value" => $district->hp_name);
                }
            }

            echo json_encode($data);
        }

        close_db_con();

        die;
    }

    function get_district_tahsil() {

        $sc = $this->uri->segment(3);


        if ($sc) {


            $term = trim($this->input->get_post('term', TRUE));


            $dist = $this->common_model->get_district(array('st_id' => $sc, 'term' => $term));

            if ($dist) {

                foreach ($dist as $district) {

                    $data[] = array("id" => $district->dst_code, "label" => $district->dst_name, "value" => $district->dst_name);
                }
            }

            echo json_encode($data);
        }

        close_db_con();

        die;
    }

    function get_district_amb() {

        $sc = $this->uri->segment(3);


        if ($sc) {


            $term = trim($this->input->get_post('term', TRUE));


            $dist = $this->common_model->get_district(array('st_id' => $sc, 'term' => $term));

            if ($dist) {

                foreach ($dist as $district) {

                    $data[] = array("id" => $district->dst_code, "label" => $district->dst_name, "value" => $district->dst_name);
                }
            }

            echo json_encode($data);
        }

        close_db_con();

        die;
    }

    function get_district_closer_amb() {

        $sc = $this->uri->segment(3);


        if ($sc) {


            $term = trim($this->input->get_post('term', TRUE));


            $dist = $this->common_model->get_district(array('st_id' => $sc, 'term' => $term));

            if ($dist) {

                foreach ($dist as $district) {

                    $data[] = array("id" => $district->dst_code, "label" => $district->dst_name, "value" => $district->dst_name);
                }
            }

            echo json_encode($data);
        }

        close_db_con();

        die;
    }

    function get_district_police() {

        $sc = $this->uri->segment(3);


        if ($sc) {


            $term = trim($this->input->get_post('term', TRUE));


            $dist = $this->common_model->get_district(array('st_id' => $sc, 'term' => $term));

            if ($dist) {

                foreach ($dist as $district) {

                    $data[] = array("id" => $district->dst_code, "label" => $district->dst_name, "value" => $district->dst_name);
                }
            }

            echo json_encode($data);
        }

        close_db_con();

        die;
    }

    function get_district_fire() {

        $sc = $this->uri->segment(3);


        if ($sc) {


            $term = trim($this->input->get_post('term', TRUE));


            $dist = $this->common_model->get_district(array('st_id' => $sc, 'term' => $term));

            if ($dist) {

                foreach ($dist as $district) {

                    $data[] = array("id" => $district->dst_code, "label" => $district->dst_name, "value" => $district->dst_name);
                }
            }

            echo json_encode($data);
        }

        close_db_con();

        die;
    }

    function get_dis_police_station() {

        $sc = $this->uri->segment(3);


        if ($sc) {


            $term = trim($this->input->get_post('term', TRUE));


            $dist = $this->common_model->get_police_station(array('dst_code' => $sc, 'term' => $term));

            if ($dist) {

                foreach ($dist as $district) {

                    $data[] = array("id" => $district->p_id, "label" => $district->police_station_name, "value" => $district->police_station_name);
                }
            }

            echo json_encode($data);
        }

        close_db_con();

        die;
    }

    function get_dis_fire_station() {

        $sc = $this->uri->segment(3);


        if ($sc) {


            $term = trim($this->input->get_post('term', TRUE));


            $dist = $this->common_model->get_fire_station(array('dst_code' => $sc, 'term' => $term));

            if ($dist) {

                foreach ($dist as $district) {

                    $data[] = array("id" => $district->f_id, "label" => $district->fire_station_name, "value" => $district->fire_station_name);
                }
            }

            echo json_encode($data);
        }

        close_db_con();

        die;
    }

    function get_district_ambulance() {

        $sc = $this->uri->segment(3);


        if ($sc) {


            $term = trim($this->input->get_post('term', TRUE));


            $dist = $this->common_model->get_ambulance(array('amb_district' => $sc, 'term' => $term));
            $data[] = array("id" => "", "label" => "", "value" => "");
            if ($dist) {

                foreach ($dist as $district) {

                    $data[] = array("id" => $district->amb_rto_register_no, "label" => $district->amb_rto_register_no, "value" => $district->amb_rto_register_no);
                }
            }


            echo json_encode($data);
        }

        close_db_con();

        die;
    }

    function get_clo_comp_ambulance() {

        $sc = $this->uri->segment(3);


        if ($sc) {


            $term = trim($this->input->get_post('term', TRUE));


            $dist = $this->common_model->get_closure_comp_amb(array('amb_district' => $sc, 'term' => $term));
            $data[] = array("id" => "", "label" => "", "value" => "");
            if ($dist) {

                foreach ($dist as $district) {

                    $data[] = array("id" => $district->amb_rto_register_no, "label" => $district->amb_rto_register_no, "value" => $district->amb_rto_register_no);
                }
            }


            echo json_encode($data);
        }

        close_db_con();

        die;
    }

    function get_update_clo_comp_ambulance() {

        $sc = $this->uri->segment(3);


        if ($sc) {


            $term = trim($this->input->get_post('term', TRUE));


            $dist = $this->common_model->get_update_closure_comp_amb(array('amb_district' => $sc, 'term' => $term));
            $data[] = array("id" => "", "label" => "", "value" => "");
            if ($dist) {

                foreach ($dist as $district) {

                    $data[] = array("id" => $district->amb_rto_register_no, "label" => $district->amb_rto_register_no, "value" => $district->amb_rto_register_no);
                }
            }


            echo json_encode($data);
        }

        close_db_con();

        die;
    }

    function get_update_oxy_feel_ambulance() {

        $sc = $this->uri->segment(3);


        if ($sc) {


            $term = trim($this->input->get_post('term', TRUE));


            $dist = $this->common_model->get_update_oxy_feel_ambulance(array('amb_district' => $sc, 'term' => $term));
            $data[] = array("id" => "", "label" => "", "value" => "");
            if ($dist) {

                foreach ($dist as $district) {

                    $data[] = array("id" => $district->amb_rto_register_no, "label" => $district->amb_rto_register_no, "value" => $district->amb_rto_register_no);
                }
            }


            echo json_encode($data);
        }

        close_db_con();

        die;
    }

    function get_break_maintaince_ambulance() {

        $sc = $this->uri->segment(3);


        if ($sc) {


            $term = trim($this->input->get_post('term', TRUE));


            $dist = $this->common_model->get_break_maintaince_ambulance(array('amb_district' => $sc, 'term' => $term));
            $data[] = array("id" => "", "label" => "", "value" => "");
            if ($dist) {

                foreach ($dist as $district) {

                    $data[] = array("id" => $district->amb_rto_register_no, "label" => $district->amb_rto_register_no, "value" => $district->amb_rto_register_no);
                }
            }


            echo json_encode($data);
        }

        close_db_con();

        die;
    }

    function get_tyre_life_ambulance() {

        $sc = $this->uri->segment(3);


        if ($sc) {


            $term = trim($this->input->get_post('term', TRUE));


            $dist = $this->common_model->get_tyre_life_amb(array('amb_district' => $sc, 'term' => $term));

            $data[] = array("id" => "", "label" => "", "value" => "");
            if ($dist) {

                foreach ($dist as $district) {

                    $data[] = array("id" => $district->amb_rto_register_no, "label" => $district->amb_rto_register_no, "value" => $district->amb_rto_register_no);
                }
            }


            echo json_encode($data);
        }

        close_db_con();

        die;
    }

    function get_ambulance() {

        $sc = $this->uri->segment(3);


        if ($sc) {


            $term = trim($this->input->get_post('term', TRUE));


            $dist = $this->common_model->get_ambulance(array('amb_state' => $sc, 'term' => $term));

            if ($dist) {

                foreach ($dist as $district) {

                    $data[] = array("id" => $district->amb_rto_register_no, "label" => $district->amb_rto_register_no, "value" => $district->amb_rto_register_no);
                }
            }

            echo json_encode($data);
        }else{
            
              $term = trim($this->input->get_post('term', TRUE));


            $dist = $this->common_model->get_ambulance(array('term' => $term));

            if ($dist) {

                foreach ($dist as $district) {

                    $data[] = array("id" => $district->amb_rto_register_no, "label" => $district->amb_rto_register_no, "value" => $district->amb_rto_register_no);
                }
            }

            echo json_encode($data);
            
        }

        close_db_con();

        die;
    }
    function get_eros_data() {

        $sc = $this->uri->segment(3);
        $args= array();
       // var_dump($sc);
     
        if ($sc) {



            $args['term'] = trim($this->input->get_post('term', TRUE));
         
            
           // echo "hi";
            //$args = 'UG-ERO,UG-ERO-102';
            $ero = $this->colleagues_model->get_all_eros($args);
            

            if ($ero) {

                 foreach ($ero as $ero) {

                    $data[] = array("id" => $ero->clg_ref_id, "label" => $ero->clg_ref_id, "value" => $ero->clg_ref_id);
                }
         }

             echo json_encode($data);
         }else{
            
              $term = trim($this->input->get_post('term', TRUE));
             // var_dump($term);
             // echo "1";


            $ero = $this->colleagues_model->get_all_eros(array('term' => $term));

            if ($ero) {

                foreach ($ero as $ero) {

                    $data[] = array("id" => $ero->clg_ref_id, "label" => $ero->clg_ref_id, "value" => $ero->clg_ref_id);
                }
            }

            echo json_encode($data);
            
    }

        close_db_con();

        die;
    }

    function get_state() {

        $term = $this->input->get_post('term', TRUE);

        $state = $this->common_model->get_state(array('term' => $term));

        if ($state) {

            foreach ($state as $st) {

                $data[] = array("id" => $st->st_code, "label" => $st->st_name, "value" => $st->st_name);
            }
        }

        echo json_encode($data);

        close_db_con();

        die;
    }

    //// Created by MI44 ////////////////////////////////////////////////
    // 
    // Purpose : To get employee id on clg_table.
    // 
    /////////////////////////////////////////////////////////////////////


    function get_emp() {

        $term = $this->input->get_post('term', TRUE);

        if ($term != "") {

            $args = array('clg_group' => 'UG-EMT', 'clg_ref_id' => $term);

            $clg = $this->colleagues_model->get_clg_data($args);

            if ($clg) {

                foreach ($clg as $clg_id) {

                    $data[] = array("id" => $clg_id->clg_ref_id, "label" => $clg_id->clg_ref_id, "value" => $clg_id->clg_ref_id);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    //// Created by MI44 ////////////////////////////////////////////////
    // 
    // Purpose : Autocomplete ambulance pilot.
    // 
    /////////////////////////////////////////////////////////////////////

    function get_clg() {
        $sc = $this->uri->segment(3);



        if ($sc) {

            $term = $this->input->get_post('term', TRUE);

            $args['clg_group'] = ($this->input->get_post('emt', TRUE)) ? 'UG-EMT' : 'UG-Pilot';
            $args['term'] = $term;
            $args['district_id'] = $sc;
            if ($term != "") {

                $clg = $this->colleagues_model->get_clg_data($args);

                if ($clg) {

                    foreach ($clg as $clg_data) {

                        $data[] = array("id" => $clg_data->clg_ref_id, "label" => $clg_data->clg_first_name . " " . $clg_data->clg_last_name . "-" . $clg_data->clg_ref_id, "value" => $clg_data->clg_ref_id);
                    }
                }

                echo json_encode($data);

                close_db_con();

                die;
            }
        }
    }

    /* MI13 */

    public function get_tal() {

        $sc = $this->uri->segment(3);



        if ($sc) {

            $term = trim($this->input->get_post('term', TRUE));

            //$dist = $this->common_model->get_district(array('thl_district_code' => $sc, 'term' => $term));
            $tals = $this->common_model->get_tahshil(array('dst_id' => $sc, 'tah_name' => $term));

            if ($tals) {
                foreach ($tals as $tal) {
                    $data[] = array("id" => $tal->thl_code, "label" => $tal->thl_name, "value" => $tal->thl_name);
                }
            }

            echo json_encode($data);
        }
        close_db_con();

        die;
    }

    public function get_amb() {

        $sc = $this->uri->segment(3);



        if ($sc) {

            $term = trim($this->input->get_post('term', TRUE));

            //$dist = $this->common_model->get_district(array('thl_district_code' => $sc, 'term' => $term));
            $tals = $this->common_model->get_ambulance(array('amb_district' => $sc, 'amb_rto_register_no' => $term));

            if ($tals) {
                foreach ($tals as $tal) {
                    $data[] = array("id" => $tal->amb_rto_register_no, "label" => $tal->amb_rto_register_no, "value" => $tal->amb_rto_register_no);
                }
            }

            echo json_encode($data);
        }
        close_db_con();

        die;
    }

    function get_mci_nature() {
        $term = $this->input->get_post('term', TRUE);
        if ($term != "") {
            $mci_natures = $this->call_model->get_mic_nat(array('ntr_nature' => $term));
            if ($mci_natures) {

                foreach ($mci_natures as $mci_nature) {
                    $data[] = array("id" => $mci_nature->ntr_id, "label" => $mci_nature->ntr_nature, "value" => $mci_nature->ntr_nature);
                }
            }
            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_chief_complete() {
        
        $term = $this->input->get_post('term', TRUE);
        $call_type = $this->input->get_post('call_type', TRUE);
        
        if ($term != "") {
            
            $chief_comps = $this->call_model->get_chief_comp(array('cc_name' => $term,'ct_call_type' => $call_type));
            if ($chief_comps) {

                foreach ($chief_comps as $chief_comp) {
                    $data[] = array("id" => $chief_comp->ct_id, "label" => $chief_comp->ct_type, "value" => $chief_comp->ct_type);
                }
            }
            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_police_chief_complete() {
        $term = $this->input->get_post('term', TRUE);
        if ($term != "") {
            $chief_comps = $this->call_model->get_police_chief_comp(array('cc_name' => $term));
            if ($chief_comps) {

                foreach ($chief_comps as $chief_comp) {
                    $data[] = array("id" => $chief_comp->po_ct_id, "label" => $chief_comp->po_ct_name, "value" => $chief_comp->po_ct_name);
                }
            }
            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_fire_chief_complete() {
        $term = $this->input->get_post('term', TRUE);
        if ($term != "") {
            $chief_comps = $this->call_model->get_fire_chief_comp(array('cc_name' => $term));
            if ($chief_comps) {

                foreach ($chief_comps as $chief_comp) {
                    $data[] = array("id" => $chief_comp->fi_ct_id, "label" => $chief_comp->fi_ct_name, "value" => $chief_comp->fi_ct_name);
                }
            }
            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_ero_standard_summary() {
        $term = $this->input->get_post('term', TRUE);
        $system= $this->input->get_post('system_type');
        $call_type = $this->input->get_post('call_type', TRUE);
        $term_args = array();
        
        if($call_type != ""){
            $term_args['call_type'] = $call_type;
            
        }
        if($system != ""){
            $term_args['system_type'] = $system;
            
        }
        if ($term != "") {
            $term_args['cc_name'] = $term;
            
            $chief_comps = $this->call_model->get_ero_summary_remark($term_args);
            if ($chief_comps) {

                foreach ($chief_comps as $chief_comp) {
                    $data[] = array("id" => $chief_comp->re_id, "label" => $chief_comp->re_name, "value" => $chief_comp->re_name);
                }
            }
            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_auto_hospital() {

        $term = $this->input->get_post('term', TRUE);

        if ($term != "") {

            $hosp = $this->hp_model->get_hp_data(array('hp_name' => $term));

            if ($hosp) {

                foreach ($hosp as $hpname) {

                    $data[] = array("id" => $hpname->hp_id, "label" => $hpname->hp_name, "value" => $hpname->hp_name);
                }
            }
            $data[] = array("id" => 0, "label" => 'Other', "value" => 'Other');
            echo json_encode($data);

            close_db_con();

            die;
        }
    }
    
        function get_auto_hospital_new() {

        $term = $this->input->get_post('term', TRUE);
        $district_id = $this->input->get_post('district_id', TRUE);

        

        $agrs = array();
            
        if ($term != "") {
            $agrs['hp_name'] = $term;
        }
        if ($district_id != "") {
            $agrs['district_id'] = $district_id;
        }

            $hosp = $this->hp_model->get_hp_data1($agrs);

            if ($hosp) {

                foreach ($hosp as $hpname) {

                    $data[] = array("id" => $hpname->hp_id, "label" => $hpname->hp_name, "value" => $hpname->hp_name);
                }
            }
            $data[] = array("id" => 'on_scene_care', "label" => 'On scene care', "value" => "On scene care");
            $data[] = array("id" => 'at_scene_care', "label" => 'At Scene Care', "value" => "At Scene Care");
//            $data[] = array("id" => 'sickroom', "label" => 'Sick Room', "value" => "Sick Room");
            $data[] = array("id" => 'Other', "label" => 'Other', "value" => "Other");
            echo json_encode($data);

            close_db_con();

            die;
        
    }

    //// Created by MI42 ////////////////////////////////////////////////
    // 
    // Purpose : To get LOC level list autocomplete.
    // 
    /////////////////////////////////////////////////////////////////////

    function loc_level() {

        $term = $this->input->get_post('term', TRUE);

        if ($term != "") {

            $res = $this->common_model->get_loc_level(array('loc_level' => $term));


            if ($res) {

                foreach ($res as $level) {

                    $data[] = array("id" => $level->level_id, "label" => $level->level_type, "value" => $level->level_type);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    //// Created by MI42 ////////////////////////////////////////////////
    // 
    // Purpose : To get CGS score list autocomplete.
    // 
    /////////////////////////////////////////////////////////////////////

    function gcs_score() {

        $term = $this->input->get_post('term', TRUE);

        if ($term != "") {

            $res = $this->common_model->get_gcs_score(array('cgs_score' => $term));


            if ($res) {

                foreach ($res as $score) {

                    $data[] = array("id" => $score->score_id, "label" => $score->score, "value" => $score->score);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    //// Created by MI42 ////////////////////////////////////////////////
    // 
    // Purpose : To get pupils type list autocomplete.
    // 
    /////////////////////////////////////////////////////////////////////

    function pupils_type() {

        $term = $this->input->get_post('term', TRUE);

        if ($term != "") {

            $res = $this->common_model->get_pupils_type(array('pupils_type' => $term));


            if ($res) {

                foreach ($res as $pp) {

                    $data[] = array("id" => $pp->pp_id, "label" => $pp->pp_type, "value" => $pp->pp_type);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    //// Created by MI42 ////////////////////////////////////////////////
    // 
    // Purpose : To get ERCP advice questions list autocomplete.
    // 
    /////////////////////////////////////////////////////////////////////

    function madv_que() {

        $term = $this->input->get_post('term', TRUE);

        if ($term != "") {

            $res = $this->common_model->get_question(array('que_type' => 'madv', 'que_question' => $term));


            if ($res) {

                foreach ($res as $que) {

                    $data[] = array("id" => $que->que_id, "label" => $que->que_question, "value" => $que->que_question);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    //// Created by MI42 //////////////////////////
    // 
    // Purpose : To get patient occupation.
    // 
    //////////////////////////////////////////////

    function pet_occup() {

        $term = $this->input->get_post('term', TRUE);

        if ($term != "") {

            $res = $this->pet_model->get_occup(array('occ_type' => $term));


            if ($res) {

                foreach ($res as $occ) {

                    $data[] = array("id" => $occ->occ_id, "label" => $occ->occ_type, "value" => $occ->occ_type);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    //// Created by MI42 //////////////////////////
    // 
    // Purpose : To get patient breating rate.
    // 
    //////////////////////////////////////////////

    function get_br_rate() {

        $term = $this->input->get_post('term', TRUE);

        if ($term != "") {

            $res = $this->pet_model->get_breathing_rate(array('br_rate' => $term));


            if ($res) {

                foreach ($res as $ret) {

                    $data[] = array("id" => $ret->rate_id, "label" => $ret->rate_type, "value" => $ret->rate_type);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    //// Created by MI42 //////////////////////////
    // 
    // Purpose : To get patient breating type.
    // 
    //////////////////////////////////////////////

    function get_br_effort() {

        $term = $this->input->get_post('term', TRUE);

        if ($term != "") {

            $res = $this->pet_model->get_breathing_effort(array('eff_type' => $term));


            if ($res) {

                foreach ($res as $eff) {

                    $data[] = array("id" => $eff->effort_id, "label" => $eff->effort_type, "value" => $eff->effort_type);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    //// Created by MI42 //////////////////////////
    // 
    // Purpose : To get patient breating type.
    // 
    //////////////////////////////////////////////

    function get_pulse_cap() {

        $term = $this->input->get_post('term', TRUE);

        if ($term != "") {

            $res = $this->pet_model->get_pulse_cap(array('pc_type' => $term));


            if ($res) {

                foreach ($res as $pc) {

                    $data[] = array("id" => $pc->pc_id, "label" => $pc->pc_type, "value" => $pc->pc_type);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    //// Created by MI42 //////////////////////////
    // 
    // Purpose : To get patient breating type.
    // 
    //////////////////////////////////////////////

    function get_pulse_skin() {

        $term = $this->input->get_post('term', TRUE);

        if ($term != "") {

            $res = $this->pet_model->get_pulse_skin(array('ps_type' => $term));


            if ($res) {

                foreach ($res as $ps) {

                    $data[] = array("id" => $ps->ps_id, "label" => $ps->ps_type, "value" => $ps->ps_type);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    //// Created by MI42 //////////////////////////
    // 
    // Purpose : To get patient Lung asculatation type.
    // 
    //////////////////////////////////////////////

    function get_lung_aus() {

        $term = $this->input->get_post('term', TRUE);

        if ($term != "") {

            $res = $this->pet_model->get_lung_aus(array('la_type' => $term));


            if ($res) {

                foreach ($res as $la) {

                    $data[] = array("id" => $la->la_id, "label" => $la->la_type, "value" => $la->la_type);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    //// Created by MI42 //////////////////////////
    // 
    // Purpose : To get yn(yes/no) options.
    // 
    //////////////////////////////////////////////

    function get_yn_opt() {

        $term = $this->input->get_post('term', TRUE);

        if ($term != "") {

            $res = get_yn_opt();


            if ($res) {

                foreach ($res as $st) {

                    $data[] = array("id" => $st, "label" => $st, "value" => $st);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    //// Created by MI42 //////////////////////////
    // 
    // Purpose : To get yn(yes/no) options.
    // 
    //////////////////////////////////////////////

    function get_pa_opt() {

        $term = $this->input->get_post('term', TRUE);

        if ($term != "") {

            $res = get_pa_opt();



            if ($res) {

                foreach ($res as $st) {

                    $data[] = array("id" => $st, "label" => $st, "value" => $st);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_ercp_name() {


        $term = $this->input->get_post('term', TRUE);
        //////////////////////////////////////////////////////

        $pcr_data['inc_ref_id'] = array('inc_id' => 'INC1235');

        $this->session->set_userdata('pcr_details', $pcr_data);

        $pcr = $this->session->userdata('pcr_details');

        $inc_id = key($pcr);


        ////////////////////////////

        $adv_id = $this->medadv_model->check_inc_ref_id(array('adv_inc_ref_id' => $pcr[$inc_id]['inc_id']));




        if ($adv_id) {

            foreach ($adv_id as $name) {

                $data[] = array("id" => $name->clg_ref_id, "label" => $name->clg_first_name . " " . $name->clg_last_name, "value" => $name->clg_first_name . " " . $name->clg_last_name);
            }
        }

        echo json_encode($data);

        close_db_con();

        die;
    }

//    function get_ercp_name() {
//
//
//        $term = $this->input->get_post('term', TRUE);
//        //////////////////////////////////////////////////////
////        $pcr_data['inc_ref_id'] = array('inc_id' => 'INC1235');
////        
////        $this->session->set_userdata('pcr_details', $pcr_data);
//
//        $pcr = $this->session->userdata('pcr_details');
//
//        $inc_id = key($pcr);
//
//
//        ////////////////////////////
//
//        $adv_id = $this->medadv_model->check_inc_ref_id(array('adv_inc_ref_id' => $inc_id));
//
//
//
//
//        if ($adv_id) {
//
//            foreach ($adv_id as $name) {
//
//                $data[] = array("id" => $name->clg_ref_id, "label" => $name->clg_first_name . " " . $name->clg_last_name, "value" => $name->clg_first_name . " " . $name->clg_last_name);
//            }
//        }
//
//        echo json_encode($data);
//
//        close_db_con();
//
//        die;
//    }
    ////MI13 
    // 
    // Purpose : To get Provider impression list autocomplete.

    function get_provider_imp() {



        $term = $this->input->get_post('term', TRUE);

        if ($term != "") {

            $provider_imp = $this->pcr_model->get_provider_imp(array('pro_id' => $med_ids, 'pro_name' => $term));

            if ($provider_imp) {

                foreach ($provider_imp as $imp) {

                    $data[] = array("id" => $imp->pro_id, "label" => stripslashes($imp->pro_name), "value" => stripslashes($imp->pro_name));
                }
            }



            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_odometer_remark() {



        $term = $this->input->get_post('term', TRUE);

        if ($term != "") {

            $remarks = $this->pcr_model->get_odometer(array('remark' => $term));

            if ($remarks) {

                foreach ($remarks as $remark) {

                    $data[] = array("id" => $remark->remark_id, "label" => stripslashes($remark->remark), "value" => stripslashes($remark->remark));
                }
            }



            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_cty_view_given_location($thl_code = '', $cty_code = '') {

        if ($this->input->post('epcr_district') != '' && $dst_code == '') {
            $thl_code = $this->input->post('epcr_district');
        } else {
            return false;
        }

        $option = get_city($thl_code);


        $data['option'] = $option;


        $this->output->add_to_position($this->load->view('frontend/common/get_cities_view', $data, TRUE), $this->post['output_position'], TRUE);
    }

    function get_dst_view_epcr($st_code = '', $dst_code = '') {


        if ($this->input->post('epcr_state') != '' && $st_code == '') {
            $st_code = $this->input->post('epcr_state');
        } else {
            return false;
        }

        $option = get_st_to_dst($st_code, $dst_code);


        $data['option'] = $option;


        $this->output->add_to_position($this->load->view('frontend/common/get_district_view', $data, TRUE), $this->post['output_position'], TRUE);
    }

    function get_distance() {

        $term = $this->input->get_post('term', TRUE);


        if ($term != "") {

            $res = $this->common_model->get_distance(array('distance' => $term));


            if ($res) {

                foreach ($res as $score) {

                    $data[] = array("id" => $score->distance, "label" => $score->distance, "value" => $score->distance);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_emso_id() {

        $term = $this->input->get_post('term', TRUE);



        if ($term != "") {
            $args = array('clg_group' => 'UG-EMT', 'clg_ref_id' => $term);

//            var_dump($args);
//            die();

            $clg = $this->colleagues_model->get_clg_data($args);


//            var_dump($clg);

            if ($clg) {

                foreach ($clg as $clg_id) {

                    $data[] = array("id" => $clg_id->clg_ref_id, "label" => $clg_id->clg_ref_id, "value" => $clg_id->clg_ref_id);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_pilot_id() {

        $term = $this->input->get_post('term', TRUE);



        if ($term != "") {
            $args = array('clg_group' => 'UG-Pilot', 'clg_ref_id' => $term);

//            var_dump($args);
//            die();

            $clg = $this->colleagues_model->get_clg_data($args);


//            var_dump($clg);

            if ($clg) {

                foreach ($clg as $clg_id) {

                    $data[] = array("id" => $clg_id->clg_ref_id, "label" => $clg_id->clg_ref_id, "value" => $clg_id->clg_ref_id);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_all_emso_id() {

        $term = $this->input->get_post('term', TRUE);

        if ($term != "") {

            $args = array('clg_group' => 'UG-EMT', 'clg_ref_id' => $term);

            $clg = $this->colleagues_model->get_clg_data($args);

            if ($clg) {

                foreach ($clg as $clg_id) {

                    $data[] = array("id" => $clg_id->clg_emso_id, "label" => $clg_id->clg_emso_id, "value" => $clg_id->clg_emso_id);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }
    
       function get_all_user() {

        $term = $this->input->get_post('term', TRUE);

        
             //var_dump($term);die;
            $args = array('clg_ref_id' => $term);
            $args['clg_group'] = $this->input->get_post('clg_group', TRUE);
          
            $clg = $this->colleagues_model->get_clg_data($args);

            if ($clg) {

                foreach ($clg as $clg_id) {
                    
                    $label =$clg_id->clg_first_name." ".$clg_id->clg_last_name."-".$clg_id->clg_ref_id;

                    $data[] = array("id" => $clg_id->clg_ref_id, "label" => $label, "value" => $clg_id->clg_ref_id);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        
    }
    function get_all_users() {
        $term = $this->input->get_post('term', TRUE);
        
             //var_dump($term);die;
            $args = array('clg_ref_id' => $term);
          
            $clg = $this->colleagues_model->get_data();
            if ($clg) {
                foreach ($clg as $clg_id) {
                    
                    $label =$clg_id->clg_ref_id."-".$clg_id->clg_first_name." ".$clg_id->clg_last_name;
                    $data[] = array("id" => $clg_id->clg_ref_id, "label" => $label, "value" => $clg_id->clg_ref_id);
                }
            }
            echo json_encode($data);
            close_db_con();
            die;
        
    }

    function get_all_fuel_station() {

        $term = $this->input->get_post('term', TRUE);

        if ($term != "") {

            $fuel = $this->fleet_model->get_all_fuel_station($args);


            if ($fuel) {

                foreach ($fuel as $fuel) {

                    $data[] = array("id" => $fuel->f_id, "label" => $fuel->f_station_name, "value" => $fuel->f_station_name);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_all_oxygen_station() {

        $term = $this->input->get_post('term', TRUE);

        if ($term != "") {

            $fuel = $this->fleet_model->get_all_oxygen_center_data($args);


            if ($fuel) {

                foreach ($fuel as $fuel) {

                    $data[] = array("id" => $fuel->os_id, "label" => $fuel->os_oxygen_name, "value" => $fuel->os_oxygen_name);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_clg_pilot() {

        $term = $this->input->get_post('term', TRUE);

        $args['clg_group'] = 'UG-PILOT';

        if ($term != "") {

            $clg = $this->colleagues_model->get_clg_data($args);

            if ($clg) {

                foreach ($clg as $clg_data) {

                    $data[] = array("id" => $clg_data->clg_ref_id, "label" => $clg_data->clg_first_name . " " . $clg_data->clg_last_name, "value" => $clg_data->clg_first_name . " " . $clg_data->clg_last_name);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_pilot_data() {

        $term = $this->input->get_post('term', TRUE);

        $args['clg_group'] = 'UG-PILOT';

        if ($term != "") {

            $clg = $this->colleagues_model->get_clg_data($args);

            if ($clg) {

                foreach ($clg as $clg_data) {

                    $data[] = array("id" => $clg_data->clg_ref_id, "label" => $clg_data->clg_ref_id, "value" => $clg_data->clg_ref_id);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_responce_time_remark() {

        $term = $this->input->get_post('term', TRUE);

        if ($term != "") {
            $res_remark = $this->pcr_model->get_res_time_remark(array('remark_title' => $term));
            if ($res_remark) {

                foreach ($res_remark as $remark) {
                    $data[] = array("id" => $remark->id, "label" => $remark->remark_title, "value" => $remark->remark_title);
                }
            }
            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function test_list() {

        $term = $this->input->get_post('term', TRUE);

        if ($term != "") {

            $res = $this->common_model->get_tests(array('test_title' => $term));


            if ($res) {

                foreach ($res as $level) {

                    $data[] = array("id" => $level->level_id, "label" => $level->level_type, "value" => $level->level_type);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_auto_cluster() {

        $term = $this->input->get_post('term', TRUE);

        $po_id = $this->uri->segment(3);



        if ($term != "") {

            $res = $this->schedule_model->get_cluster(array('cluster_name' => $term, 'po_id' => $po_id));

            if ($res) {

                foreach ($res as $clu) {
                    $data[] = array("id" => $clu->cluster_id, "label" => $clu->cluster_name, "value" => $clu->cluster_name);
                }
            }

            echo json_encode($data);


            close_db_con();

            die;
        }
    }

    function get_auto_cluster_by_user() {

        $term = $this->input->get_post('term', TRUE);
        $this->clg = $this->session->userdata('current_user');
        $cluster_id = $this->clg->cluster_id;



        if ($term != "") {

            $res = $this->schedule_model->get_cluster(array('cluster_name' => $term, 'cluster_id' => $cluster_id));

            if ($res) {

                foreach ($res as $clu) {
                    $data[] = array("id" => $clu->cluster_id, "label" => $clu->cluster_name, "value" => $clu->cluster_name);
                }
            }

            echo json_encode($data);
            close_db_con();
            die;
        }
    }

    function get_auto_school() {

        $term = $this->input->get_post('term', TRUE);

        if ($term != "") {


            $res = $this->school_model->get_school_type(array('school_name' => $term));


            if ($res) {

                foreach ($res as $occ) {

                    $data[] = array("id" => $occ->school_id, "label" => $occ->school_name, "value" => $occ->school_name);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_school_by_clusterid() {

        $term = $this->input->get_post('cluster_id', TRUE);

        $args = array();
        if ($term != "") {
            $args = array('cluster_id' => $term);
        }


        $res = $this->school_model->get_school_type($args);


        if ($res) {

            foreach ($res as $occ) {

                $data[] = array("id" => $occ->school_id, "label" => $occ->school_name, "value" => $occ->school_name);
            }
        }

        echo json_encode($data);

        close_db_con();

        die;
    }

    function get_school_by_healthsupervisor() {

        $term = $this->input->get_post('health_sup', TRUE);
        $args = array();

        if ($term != "") {
            $args = array('health_sup' => $term);
        }

        $res = $this->school_model->get_sickroom_type($args);


        if ($res) {

            foreach ($res as $occ) {

                $data[] = array("id" => $occ->school_id, "label" => $occ->school_name, "value" => $occ->school_name);
            }
        }

        echo json_encode($data);
        close_db_con();
        die;
    }

    function get_auto_diagosis_code() {

        $term = $this->input->get_post('term', TRUE);

        if ($term != "") {

            $res = $this->common_model->get_mas_diagonosis(array('diagnosis_title' => $term));

            if ($res) {

                foreach ($res as $clu) {

                    $data[] = array("id" => $clu->id, "label" => $clu->diagnosis_title, "value" => $clu->diagnosis_title);
                }
            }
            //$data[] =  array("id" => 'Other', "label" => 'Other', "value" => "Other");

            echo json_encode($data);
            close_db_con();
            die;
        }
    }

    function get_cluster($cluster_id = '') {

        $cluster_name = $this->schedule_model->get_cluster();


        if (!empty($cluster_name)) {

            foreach ($cluster_name as $opt) {

                $options .= "<option value='" . $opt->cluster_id . "' " . $select[$opt->cluster_name] . " >" . $opt->cluster_name . "</option>";
            }
        }

        return $options;
    }

    function get_auto_clg() {

        $term = $this->input->get_post('term', TRUE);
       //var_dump(  $all);
        $args['clg_group'] = $this->input->get_post('clg_group', TRUE);
        $args['clg_is_login'] = $this->input->get_post('is_login', TRUE);
       $all = "all";
        if ($term != "") {

            $clg = $this->colleagues_model->get_clg_data($args);
            $data[] = array("id" =>'all', "label" => "All", "value" => "all" );
            if ($clg) {
                
                foreach ($clg as $clg_data) {

                    $data[] = array("id" => $clg_data->clg_ref_id, "label" => $clg_data->clg_first_name . " " . $clg_data->clg_last_name." ".$clg_data->clg_ref_id, "value" => $clg_data->clg_first_name . " " . $clg_data->clg_last_name);
                }
                

            }
           // var_dump($data); die;
            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_auto_school_clg() {

        $term = $this->input->get_post('term', TRUE);

        $args['clg_group'] = $this->input->get_post('clg_group', TRUE);

        $clg_ref_id = $this->input->get_post('clg_ref_id', TRUE);
        if ($term != "") {


            $clg = $this->colleagues_model->get_school_clg_data($args, $clg_ref_id);


            if ($clg) {

                foreach ($clg as $clg_data) {

                    $data[] = array("id" => $clg_data->clg_ref_id, "label" => $clg_data->clg_first_name . " " . $clg_data->clg_last_name, "value" => $clg_data->clg_first_name . " " . $clg_data->clg_last_name);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_auto_atc() {

        $term = $this->input->get_post('term', TRUE);

        if ($term != "") {


            $res = $this->dashboard_model->get_atc_list(array('atc_name' => $term));


            if ($res) {

                foreach ($res as $occ) {

                    $data[] = array("id" => $occ->atc_id, "label" => $occ->atc_name, "value" => $occ->atc_name);
                }
            }

            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_auto_po_by_atc() {

        $term = $this->input->get_post('term', TRUE);
        $atc_id = $this->uri->segment(3);



        if ($term != "") {


            $res = $this->dashboard_model->get_auto_po_by_atc_id(array('po_name' => $term, 'atc_id' => $atc_id));


            if ($res) {

                foreach ($res as $occ) {

                    $data[] = array("id" => $occ->po_id, "label" => $occ->po_name, "value" => $occ->po_name);
                }
            }


            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_auto_student() {

        $term = $this->input->get_post('school_id', TRUE);
        $args = array();


        if ($term != "") {
            $args = array('school_id' => $term);
        }

        $res = $this->student_model->get_students_by_school($args);

        if ($res) {

            foreach ($res as $occ) {

                $data[] = array("id" => $occ->stud_id, "label" => $occ->stud_first_name . ' ' . $occ->stud_middle_name . ' ' . $occ->stud_last_name, "value" => $occ->stud_first_name . ' ' . $occ->stud_middle_name . ' ' . $occ->stud_last_name);
            }
        }

        echo json_encode($data);
        close_db_con();
        die;
    }

    function get_work_shop() {
        $term = $this->input->get_post('term', TRUE);
        if ($term != "") {
            $work_shops = $this->fleet_model->get_all_active_work_station(array('ws_station_name' => $term));
            if ($work_shops) {

                foreach ($work_shops as $work_shop) {
                    $data[] = array("id" => $work_shop->ws_id, "label" => $work_shop->ws_station_name, "value" => $work_shop->ws_station_name);
                }
            }
            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_server_station() {
        $term = $this->input->get_post('term', TRUE);
        if ($term != "") {
            $work_shops = $this->fleet_model->get_all_equipment_center_data(array('es_service_center_name' => $term));
            if ($work_shops) {

                foreach ($work_shops as $work_shop) {
                    $data[] = array("id" => $work_shop->es_id, "label" => $work_shop->es_service_center_name, "value" => $work_shop->es_service_center_name);
                }
            }
            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_grievance_type() {
        $term = $this->input->get_post('term', TRUE);
        if ($term != "") {
            $grievance_types = $this->call_model->get_grievance_type(array('grievance_type' => $term));

            if ($grievance_types) {

                foreach ($grievance_types as $grievance_type) {
                    $data[] = array("id" => $grievance_type->grievance_id, "label" => $grievance_type->grievance_type, "value" => $grievance_type->grievance_type);
                }
            }
            echo json_encode($data);

            close_db_con();

            die;
        }
    }

    function get_grievance_sub_type() {
        $term = $this->input->get_post('term', TRUE);
        if ($term != "") {
            $grievance_types = $this->call_model->get_grievance_sub_type(array('grievance_sub_type' => $term));

            if ($grievance_types) {

                foreach ($grievance_types as $grievance_type) {
                    $data[] = array("id" => $grievance_type->g_id, "label" => $grievance_type->grievance_sub_type, "value" => $grievance_type->grievance_sub_type);
                }
            }
            echo json_encode($data);

            close_db_con();

            die;
        }
    }
    

    function get_feedback_standard_remark() {
        $term = $this->input->get_post('term', TRUE);
        if ($term != "") {
            $feed_type = $this->input->get_post('feed_type', TRUE);
            
            $feed_stand_remark = $this->call_model->get_feedback_stand_remark(array('fdsr_type' => $term,'feed_type'=>$feed_type));

            if ($feed_stand_remark) {

                foreach ($feed_stand_remark as $feed_stand_remark) {
                    $data[] = array("id" => $feed_stand_remark->fdsr_id, "label" => $feed_stand_remark->fdsr_type, "value" => $feed_stand_remark->fdsr_type);
                }
            }
            echo json_encode($data);

            close_db_con();

            die;
        }
    }
    function get_shiftmanager_data() {

        $sc = $this->uri->segment(3);
        $args= array();
       // var_dump($sc);
     
        if ($sc) {



            $args['term'] = trim($this->input->get_post('term', TRUE));
         
            
           // echo "hi";
            //$args = 'UG-ERO,UG-ERO-102';
            $ero = $this->colleagues_model->get_all_shiftmanager($args);
            

            if ($ero) {

                 foreach ($ero as $ero) {

                    $data[] = array("id" => $ero->clg_ref_id, "label" => $ero->clg_ref_id, "value" => $ero->clg_ref_id);
                }
         }

             echo json_encode($data);
         }else{
            
              $term = trim($this->input->get_post('term', TRUE));
             // var_dump($term);
             // echo "1";


            $ero = $this->colleagues_model->get_all_shiftmanager(array('term' => $term));

            if ($ero) {

                foreach ($ero as $ero) {

                    $data[] = array("id" => $ero->clg_ref_id, "label" => $ero->clg_ref_id, "value" => $ero->clg_ref_id);
                }
            }

            echo json_encode($data);
            
    }

        close_db_con();

        die;
    }

    function get_tl_data() {
        $clg_ref_id = $this->input->post('clg_ref_id');
        //var_dump($clg_ref_id);die;
        if($clg_ref_id)
            {
            $tl_data = $this->colleagues_model->get_all_tlname($clg_ref_id);
           
            
            if ($tl_data) {

                foreach ($tl_data as $tl) {

                    $data[] = array("id" => $tl->clg_ref_id, "label" => $tl->clg_ref_id, "value" => $tl->clg_ref_id);
                }
            }
             echo json_encode($data);
            die;
            }

    }

    function get_ero_data() {
        $tl_id = $this->input->post(['tl_id'][0]);
        //var_dump($clg_ref_id);die;
        if($tl_id)
            {
            $data = $this->colleagues_model->get_all_eros($tl_id);
            echo json_encode($data);
            die;
            }
    }
    
    function get_erosuprervisor_data() {

       // $sc = $this->uri->segment(3);
        $args= array();
       // var_dump($sc);
     
       // if ($sc) {



            $args['term'] = trim($this->input->get_post('term', TRUE));
         
            
           // echo "hi";
            //$args = 'UG-ERO,UG-ERO-102';
            $ero = $this->colleagues_model->get_all_erosupervisor($args);
            

        //     if ($ero) {

        //          foreach ($ero as $ero) {

        //             $data[] = array("id" => $ero->clg_ref_id, "label" => $ero->clg_ref_id, "value" => $ero->clg_ref_id);
        //         }
        //  }

             echo json_encode($data);
    //      }else{
            
    //           $term = trim($this->input->get_post('term', TRUE));
    //          // var_dump($term);
    //          // echo "1";


    //         $ero = $this->colleagues_model->get_all_erosupervisor(array('term' => $term));

    //         if ($ero) {

    //             foreach ($ero as $ero) {

    //                 $data[] = array("id" => $ero->clg_ref_id, "label" => $ero->clg_ref_id, "value" => $ero->clg_ref_id);
    //             }
    //         }

    //         echo json_encode($data);
            
    // }

        close_db_con();

        die;
    }
    

}
