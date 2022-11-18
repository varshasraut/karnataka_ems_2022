<?php

//// Created by MI42 ///////////////////////////
// 
// Purpose : To close db connection.
// 
///////////////////////////////////////////////// 

function close_db_con() {

    $CI = get_instance();

    $CI->load->model('common_model');

    $CI->common_model->close_db_connection();
}

function get_sanitized_url($url) {
    $string = str_replace(' ', '-', strtolower($url));
    return $string;
}
function get_clg_data_by_ref_id_response($ref_id) {
    $args = array();
    $CI = get_instance();
    $args['clg_reff_id'] = $ref_id;

    $CI->load->model('colleagues_model');

    $clg_data = $CI->colleagues_model->get_clg_data($args);
    
    return $clg_data;
}
function redirect_to_url($url, $permanent = false) {
    if ($permanent) {
        header('HTTP/1.1 301 Moved Permanently');
    }

    header('Location: ' . $url, FALSE);

    exit();
}

function ordinal_sufix($number) {

    $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');

    if ((($number % 100) >= 11) && (($number % 100) <= 13))
        return $number . 'th';
    else
        return $number . $ends[$number % 10];
}

function mi_random_string($length = 12, $type = '') {


    if ($type == 'numbers') {

        $randomnr = substr(str_shuffle("0123456789"), 0, $length);
    } else {

        $randomnr = substr(str_shuffle("0123456789abcdefghiMHlmnopqrstuvwxyzABCDEFGHIMHLMNOPQRSTUVWXYZ"), 0, $length);
    }

    return $randomnr;
}

function time_date($time = "", $showtime = true, $showday = false) {

    $timepat = "";

    $daypat = "";

    if ($showtime) {
        $timepat = ", [g:i A]";
    }

    if ($showday) {
        $daypat = "l ";
    }



    if ($time != "") {



        $time_date = str_replace(array("``", "`^`"), array("<sup>", "</sup>"), date($daypat . "j``S`^` M  Y" . $timepat, $time));
    } else {



        $time_date = str_replace(array("``", "`^`"), array("<sup>", "</sup>"), date($daypat . "j``S`^` M  Y" . $timepat));
    }



    return $time_date;
}

function format_json($str) {

    return $str = '[{"' . trim(str_replace("{,", "{", $str), '},{"') . '"}]';
}

function format_seconds($sec) {



    $s = $sec % 60;

    $m = floor(($sec % 3600) / 60);

    $h = floor(($sec % 86400) / 3600);

    $d = floor(($sec % 2592000) / 86400);

    $M = floor($sec / 2592000);

    $output = array();

    $output[$M] = "$M months";

    $output[$d] = "$d days";

    $output[$h] = "$h hours";

    $output[$m] = "$m minutes";

    $output[$s] = "$s seconds";

    unset($output[""]);

    unset($output[0]);

    return join(", ", $output);
}

function format_minutes($min) {

    if ($min) {

        $hours = floor($min / 60);

        $minutes = ($min % 60);

        return $hours . " hrs $minutes min";
    }

    return "0 hrs";
}

function format_byte($bytes, $unit = "", $decimals = 2) {


    $units = array('B' => 0, 'KB' => 1, 'MB' => 2, 'GB' => 3, 'TB' => 4, 'PB' => 5, 'EB' => 6, 'ZB' => 7, 'YB' => 8);
    $value = 0;

    if ($bytes > 0) {

        if (!array_key_exists($unit, $units)) {

            $pow = floor(log($bytes) / log(1024));

            $unit = array_search($pow, $units);
        }


        $value = ($bytes / pow(1024, floor($units[$unit])));
    }


    if (!is_numeric($decimals) || $decimals < 0) {

        $decimals = 2;
    }

    return sprintf('%.' . $decimals . 'f ' . $unit, $value);
}

//// Created by MI42 ///////////////////////////
// 
// Purpose : Get manufactures list.
// 
///////////////////////////////////////////////
function get_man_tyre($type,$option = '') {
   
    if ($option) {
        $select[$option] = "selected='selected'";
    }

    $para['type'] = $type;

    $CI = get_instance();

    $CI->load->model('Manufacture_model');

    $man = $CI->manufacture_model->get_manufacture_tyre($para);

    if (!empty($man)) {

        foreach ($man as $mn) {

            $opt .= "<option  value='" . $mn->man_id . "' " . $select[$mn->man_id] . ">" . $mn->man_name . "</option>";
        }
    }

    return $opt;
}
function get_man($option = '') {

    if ($option) {
        $select[$option] = "selected='selected'";
    }

    $CI = get_instance();

    $CI->load->model('Manufacture_model');

    $man = $CI->manufacture_model->get_manufacture();

    if (!empty($man)) {

        foreach ($man as $mn) {

            $opt .= "<option  value='" . $mn->man_id . "' " . $select[$mn->man_id] . ">" . $mn->man_name . "</option>";
        }
    }

    return $opt;
}
    function get_offroad_reason($cluster_id = '') {

    if ($option) {
        $select[$option] = "selected='selected'";
    }

    $CI = get_instance();
            $CI->load->model('common_model');
        $cluster_name = $CI->common_model->get_offroad_reason();


        if (!empty($cluster_name)) {

            foreach ($cluster_name as $opt) {

                $options .= "<option value='" . $opt->offroad_reason . "' " . $select[$opt->offroad_reason] . " >" . $opt->offroad_reason . "</option>";
            }
        }

        return $options;
    }
function get_equpp_type($option = '') {

    if ($option) {
        $select[$option] = "selected='selected'";
    }

    $CI = get_instance();

    $CI->load->model('Eqp_model');

    $eupp = $CI->Eqp_model->get_inv_type();

    if (!empty($eupp)) {

        foreach ($eupp as $eq_type) {

            $opt .= "<option  value='" . $eq_type->id . "' " . $select[$eq_type->id] . ">" . $eq_type->type_name . "</option>";
        }
    }

    return $opt;
}

//// Created by MI42 ///////////////////////////
// 
// Purpose : Get pagination configuration.
// 
///////////////////////////////////////////////


function get_pagination($conf = array()) {

    $CI = get_instance();

    $config = array(
        'base_url' => $conf['url'],
        'total_rows' => $conf['total_rows'],
        'per_page' => $conf['per_page'],
        'cur_page' => $conf['cur_page'],
        'first_url' => $conf['url'] . "/1",
        'use_page_numbers' => TRUE,
        'uri_segment' => 3,
        'attributes' => $conf['attributes'],
        'data_qr' => $conf['data_qr']
    );


    $CI->pagination->initialize($config);

    $pg = $CI->pagination->create_links();

    return $pg;
}

//// Created by MI42 ///////////////////////////
// 
// Purpose : Get status.
// 
///////////////////////////////////////////////

function get_toggle_sts() {

    $sts = array('1' => '0', '0' => '1');

    return $sts;
}

//// Created by MI42 ///////////////////////////
// 
// Purpose : Get status.
// 
///////////////////////////////////////////////

function get_status() {

    $sts = array('1' => 'Active', '0' => 'Inactive');
    ;

    return $sts;
}

//// Created by MI42 ///////////////////////////
// 
// Purpose : Get status.
// 
///////////////////////////////////////////////

function get_rev_status() {

    $sts = array('0' => 'Active', '1' => 'Inactive');
    ;

    return $sts;
}

//// Created by MI42 ///////////////////////////
// 
// Purpose : Get mas units for inventory items.
// 
///////////////////////////////////////////////// 


function get_unit($inv_type = '', $option = '') {

    $select = array();

    $CI = get_instance();

    $CI->load->model('inv_model');

    if ($inv_type) {
        $para['inv_type'] = $inv_type;
    }

    if ($option != '') {
        $select[$option] = "selected='selected'";
    }



    $units = $CI->inv_model->get_units($para);

    if (!empty($units)) {

        foreach ($units as $un) {

            $opt .= "<option value='" . $un->unt_id . "' " . $select[$un->unt_id] . ">" . $un->unt_title . "</option>";
        }
    }



    return $opt;
}

//// Created by MI42 ///////////////////////////
// 
// Purpose : Get formatted time.
// 
///////////////////////////////////////////////// 

function get_formated_time($tm = '') {

    $tm = explode("-", $tm);

    $ftm[] = (date("H:i:s", strtotime($tm[0])));

    $ftm[] = (date("H:i:s", strtotime($tm[1])));


    return $ftm;
}

////////////////////MI42//////////////////

function get_pgno($tot_rec = '', $lim = '', $pgno = '') {

    if ($tot_rec <= 0) {

        return 1;
    } else if (ceil($tot_rec / $lim) < $pgno) {

        $pgno = $pgno - 1;
    }

    return $pgno;
}

////////////////////MI42//////////////////

function get_state($args = array()) {


    $CI = get_instance();

    $CI->load->model('common_model');



    $state = $CI->common_model->get_state(array('st_code' => $args['st_code']));

    if ($args['st_code']) {

        $sts_code = $state[0]->st_code;

        $sts_name = $state[0]->st_name;
    }


    $opt = '<input name="' . $args['rel'] . '_state" value="' . $sts_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_state" placeholder="State" data-errors="{filter_required:\'Please select state from dropdown list\'}" data-base=""  data-value="' . $sts_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_dist" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}

////////////////////MI17//////////////////

function get_state_tahsil($args = array()) {


    $CI = get_instance();

    $CI->load->model('common_model');



    $state = $CI->common_model->get_state(array('st_code' => $args['st_code']));

    if ($args['st_code']) {

        $sts_code = $state[0]->st_code;

        $sts_name = $state[0]->st_name;
    }


    $opt = '<input name="' . $args['rel'] . '_state" value="' . $sts_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_state" placeholder="State" data-errors="{filter_required:\'Please select state from dropdown list\'}" data-base=""  data-value="' . $sts_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_dist_tahsil" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}

function get_state_tahsil_vendor($args = array()) {


    $CI = get_instance();

    $CI->load->model('common_model');



    $state = $CI->common_model->get_state_vendor(array('st_code' => $args['st_code']));

    if ($args['st_code']) {

        $sts_code = $state[0]->st_code;

        $sts_name = $state[0]->st_name;
    }


    $opt = '<input name="' . $args['rel'] . '_state" value="' . $sts_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_state_vendor" placeholder="State" data-errors="{filter_required:\'Please select state from dropdown list\'}" data-base=""  data-value="' . $sts_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_dist_tahsil" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}

function get_state_tahsil_104($args = array()) {


    $CI = get_instance();

    $CI->load->model('common_model');



    $state = $CI->common_model->get_state_104(array('st_code' => $args['st_code']));

    if ($args['st_code']) {

        $sts_code = $state[0]->st_code;

        $sts_name = $state[0]->st_name;
    }


    $opt = '<input name="' . $args['rel'] . '_state" value="' . $sts_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_state_104" placeholder="State" data-errors="{filter_required:\'Please select state from dropdown list\'}" data-base=""  data-value="' . $sts_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="check_state" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}

function get_state_ambulance($args = array()) {


    $CI = get_instance();

    $CI->load->model('common_model');


    $state = $CI->common_model->get_state(array('st_code' => $args['st_code']));

    if ($args['st_code']) {

        $sts_code = $state[0]->st_code;

        $sts_name = $state[0]->st_name;
    }


    $opt = '<input name="' . $args['rel'] . '_state" value="' . $sts_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_state" placeholder="State" data-errors="{filter_required:\'Please select state from dropdown list\'}" data-base=""  data-value="' . $sts_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_amb_district" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}
function get_state_onraod_offraod_ambulance($args = array()) {


    $CI = get_instance();

    $CI->load->model('common_model');


    $state = $CI->common_model->get_state(array('st_code' => $args['st_code']));

    if ($args['st_code']) {

        $sts_code = $state[0]->st_code;

        $sts_name = $state[0]->st_name;
    }


    //$opt = '<input name="' . $args['rel'] . '_state" value="' . $sts_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_state" placeholder="State" data-errors="{filter_required:\'Please select state from dropdown list\'}" data-base=""  data-value="' . $sts_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_onroad_offroad_maint" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';
    $opt = '<input name="' . $args['rel'] . '_state" value="' . $sts_code . '" class="mi_autocomplete width97 filter_required"  placeholder="State" data-errors="{filter_required:\'Please select state from dropdown list\'}" data-base=""  data-value="' . $sts_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_onroad_offroad_maint" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';
    return $opt;
}

function get_state_clo_comp_ambulance($args = array()) {


    $CI = get_instance();

    $CI->load->model('common_model');


    $state = $CI->common_model->get_state(array('st_code' => $args['st_code']));

    if ($args['st_code']) {

        $sts_code = $state[0]->st_code;

        $sts_name = $state[0]->st_name;
    }


    $opt = '<input name="' . $args['rel'] . '_state" value="' . $sts_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_state" placeholder="State" data-errors="{filter_required:\'Please select state from dropdown list\'}" data-base=""  data-value="' . $sts_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_clo_comp_amb_district" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}
function get_state_break_ambulance($args = array()) {


    $CI = get_instance();

    $CI->load->model('common_model');

    $st_state = 'MP';
    $state = $CI->common_model->get_state(array('st_code' => $st_state));

    if ($args['st_code']) {

        $sts_code = $state[0]->st_code;

        $sts_name = $state[0]->st_name;
    }


    //$opt = '<input name="' . $args['rel'] . '_state" value="' . $sts_code . '" class="mi_autocomplete width97 filter_required"  placeholder="State" data-errors="{filter_required:\'Please select state from dropdown list\'}" data-base=""  data-value="' . $sts_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_break_amb_district" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';
    $opt = '<input name="' . $args['rel'] . '_state" value="' . $sts_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_state" placeholder="State" data-errors="{filter_required:\'Please select state from dropdown list\'}" data-base=""  data-value="' . $sts_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_break_amb_district" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';
    return $opt;
}
function get_state_preventive_ambulance($args = array()) {


    $CI = get_instance();

    $CI->load->model('common_model');


    $state = $CI->common_model->get_state(array('st_code' => $args['st_code']));

    if ($args['st_code']) {

        $sts_code = $state[0]->st_code;

        $sts_name = $state[0]->st_name;
    }


    $opt = '<input name="' . $args['rel'] . '_state" value="' . $sts_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_state" placeholder="State" data-errors="{filter_required:\'Please select state from dropdown list\'}" data-base=""  data-value="' . $sts_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_preventive_amb_district" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';
    //$opt = '<input name="' . $args['rel'] . '_state" value="' . $sts_code . '" class="mi_autocomplete width97 filter_required"  placeholder="State" data-errors="{filter_required:\'Please select state from dropdown list\'}" data-base=""  data-value="' . $sts_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_preventive_amb_district" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';
    return $opt;
}

function get_state_fuel_ambulance($args = array()) {


    $CI = get_instance();

    $CI->load->model('common_model');


    $state = $CI->common_model->get_state(array('st_code' => $args['st_code']));

    if ($args['st_code']) {

        $sts_code = $state[0]->st_code;

        $sts_name = $state[0]->st_name;
    }


    $opt = '<input name="' . $args['rel'] . '_state" value="' . $sts_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_fuel_state" placeholder="State" data-errors="{filter_required:\'Please select state from dropdown list\'}" data-base=""  data-value="' . $sts_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_fuel_amb_district" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}
function get_state_vahicle_change_ambulance($args = array()) {


    $CI = get_instance();

    $CI->load->model('common_model');


    $state = $CI->common_model->get_state(array('st_code' => $args['st_code']));

    if ($args['st_code']) {

        $sts_code = $state[0]->st_code;

        $sts_name = $state[0]->st_name;
    }


    $opt = '<input name="' . $args['rel'] . '_state" value="' . $sts_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_fuel_state" placeholder="State" data-errors="{filter_required:\'Please select state from dropdown list\'}" data-base=""  data-value="' . $sts_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_vahicle_amb_district" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}
function get_state_demo_training_ambulance($args = array()) {


    $CI = get_instance();

    $CI->load->model('common_model');


    $state = $CI->common_model->get_state(array('st_code' => $args['st_code']));

    if ($args['st_code']) {

        $sts_code = $state[0]->st_code;

        $sts_name = $state[0]->st_name;
    }


    $opt = '<input name="' . $args['rel'] . '_state" value="' . $sts_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_fuel_state" placeholder="State" data-errors="{filter_required:\'Please select state from dropdown list\'}" data-base=""  data-value="' . $sts_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_demo_amb_district" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}
function get_state_acc_ambulance($args = array()) {


    $CI = get_instance();

    $CI->load->model('common_model');


    $state = $CI->common_model->get_state(array('st_code' => $args['st_code']));

    if ($args['st_code']) {

        $sts_code = $state[0]->st_code;

        $sts_name = $state[0]->st_name;
    }


    $opt = '<input name="' . $args['rel'] . '_state" value="' . $sts_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_acc_state" placeholder="State" data-errors="{filter_required:\'Please select state from dropdown list\'}" data-base=""  data-value="' . $sts_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_acc_amb_district" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}
function get_inspection_ambulance($args = array()){
    $CI = get_instance();

    $CI->load->model('common_model');


    $state = $CI->common_model->get_state(array('st_code' => $args['st_code']));

    if ($args['st_code']) {

        $sts_code = $state[0]->st_code;

        $sts_name = $state[0]->st_name;
    }


    $opt = '<input name="' . $args['rel'] . '_state" value="' . $sts_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_acc_state" placeholder="State" data-errors="{filter_required:\'Please select state from dropdown list\'}" data-base=""  data-value="' . $sts_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_inspection_amb_district" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';
    //$opt = '<input name="' . $args['rel'] . '_state" value="' . $sts_code . '" class="mi_autocomplete width97 filter_required"  placeholder="State" data-errors="{filter_required:\'Please select state from dropdown list\'}" data-base=""  data-value="' . $sts_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_accident_amb_district" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';
    return $opt;
}
function get_state_accident_ambulance($args = array()) {


    $CI = get_instance();

    $CI->load->model('common_model');


    $state = $CI->common_model->get_state(array('st_code' => $args['st_code']));

    if ($args['st_code']) {

        $sts_code = $state[0]->st_code;

        $sts_name = $state[0]->st_name;
    }


    $opt = '<input name="' . $args['rel'] . '_state" value="' . $sts_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_acc_state" placeholder="State" data-errors="{filter_required:\'Please select state from dropdown list\'}" data-base=""  data-value="' . $sts_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_accident_amb_district" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';
    //$opt = '<input name="' . $args['rel'] . '_state" value="' . $sts_code . '" class="mi_autocomplete width97 filter_required"  placeholder="State" data-errors="{filter_required:\'Please select state from dropdown list\'}" data-base=""  data-value="' . $sts_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_accident_amb_district" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';
    return $opt;
}
function get_state_tyre_ambulance($args = array()) {


    $CI = get_instance();

    $CI->load->model('common_model');


    $state = $CI->common_model->get_state(array('st_code' => $args['st_code']));

    if ($args['st_code']) {

        $sts_code = $state[0]->st_code;

        $sts_name = $state[0]->st_name;
    }


    $opt = '<input name="' . $args['rel'] . '_state" value="' . $sts_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_acc_state" placeholder="State" data-errors="{filter_required:\'Please select state from dropdown list\'}" data-base=""  data-value="' . $sts_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_tyre_amb_district" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';
  // $opt = '<input name="' . $args['rel'] . '_state" value="' . $sts_code . '" class="mi_autocomplete width97 filter_required"  placeholder="State" data-errors="{filter_required:\'Please select state from dropdown list\'}" data-base=""  data-value="' . $sts_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_tyre_amb_district" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';
    return $opt;
}
function get_police_state($args = array()) {


    $CI = get_instance();

    $CI->load->model('common_model');


    $state = $CI->common_model->get_state(array('st_code' => $args['st_code']));

    if ($args['st_code']) {

        $sts_code = $state[0]->st_code;

        $sts_name = $state[0]->st_name;
    }


    $opt = '<input name="' . $args['rel'] . '_state" value="' . $sts_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_state" placeholder="State" data-errors="{filter_required:\'Please select state from dropdown list\'}" data-base=""  data-value="' . $sts_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_police_district" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}
function get_state_oxygen_ambulance($args = array()) {


    $CI = get_instance();

    $CI->load->model('common_model');


    $state = $CI->common_model->get_state(array('st_code' => $args['st_code']));

    if ($args['st_code']) {

        $sts_code = $state[0]->st_code;

        $sts_name = $state[0]->st_name;
    }


    $opt = '<input name="' . $args['rel'] . '_state" value="' . $sts_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_fuel_state" placeholder="State" data-errors="{filter_required:\'Please select state from dropdown list\'}" data-base=""  data-value="' . $sts_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_oxygen_amb_district" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}
function get_fire_state($args = array()) {


    $CI = get_instance();

    $CI->load->model('common_model');


    $state = $CI->common_model->get_state(array('st_code' => $args['st_code']));

    if ($args['st_code']) {

        $sts_code = $state[0]->st_code;

        $sts_name = $state[0]->st_name;
    }


    $opt = '<input name="' . $args['rel'] . '_state" value="' . $sts_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_state" placeholder="State" data-errors="{filter_required:\'Please select state from dropdown list\'}" data-base=""  data-value="' . $sts_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_fire_district" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}

//////////////////////hp and amb////////////////////////

function get_st_to_dst($st_id = '', $select_dst = '') {

    $CI = get_instance();

    $CI->load->model('common_model');

    if ($st_id) {
        $select[$st_id] = "selected='selected'";
    }

    $args = array('st_id' => $st_id);

    if (isset($args['st_id'])) {
        $get_dis = $CI->common_model->get_district($args);
    }

    if (!empty($get_dis)) {
        foreach ($get_dis as $opt) {
            $options .= "<option value='" . $opt->dst_code . "' " . $select[$opt->dst_code] . " >" . $opt->dst_name . "</option>";
        }
    }

    return $options;
}

////////////Ambulance/Hosital/Interhospital/Patient Details/////////////////////////////


function get_district($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');



    $district = $CI->common_model->get_district(array('dst_code' => $args['dst_code'], 'st_id' => $args['st_code']));



    if (!empty($district) && $args['dst_code'] != '') {

        $dist_code = $district[0]->dst_code;

        $dst_name = $district[0]->dst_name;
    }
    //var_dump($dist_code);die();

    $opt = '<input name="' . $args['rel'] . '_districts" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_district/' . $args['st_code'] . '" placeholder="District" data-errors="{filter_required:\'Please select district from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_city" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';


    return $opt;
}


function get_tahsil($args = array()) {
    $tahsil_id = $tahsil_name = '';

    $CI = get_instance();
    $CI->load->model('common_model');

    if (isset($args['dst_id'])) {
        $result = $CI->common_model->get_tahshil(array('thl_id' => $args['thl_id'], 'thl_district_code' => $args['dst_code'], 'st_id' => $args['st_code']));
    }
    if (isset($args['thl_id'])) {
        $result = $CI->common_model->get_tahshil(array('thl_id' => $args['thl_id'], 'thl_district_code' => $args['dst_code'], 'st_id' => $args['st_code']));
    }
    if (!empty($result) && $args['thl_id'] != '') {
        $tahsil_id = $result[0]->thl_id;
        $tahsil_name = $result[0]->thl_name;
    }

    $opt = '<input name="' . $args['rel'] . '_tahsil" value="' . $tahsil_id . '" class="mi_autocomplete map_canvas controls width97" placeholder="Tehsil" data-href="' . base_url() . 'auto/get_tal/' . $args['dst_code'] . '" data-errors="{filter_required:\'Please select tahsil from dropdown list\'}" data-base="" data-value="' . $tahsil_name . '" data-autocom="yes" data-auto="' . $args['auto'] . '" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . ' data-callback-funct="load_auto_inc_tahsil">';

    return $opt;
}
//////////////////////////////////////////

function get_district_tahsil($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');



    $district = $CI->common_model->get_district(array('dst_code' => $args['dst_code'], 'st_id' => $args['st_code']));



    if (!empty($district) && $args['dst_code'] != '') {

        $dist_code = $district[0]->dst_code;

        $dst_name = $district[0]->dst_name;
    }

    $opt = '<input name="' . $args['rel'] . '_district" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_district_tahsil/' . $args['st_code'] . '" placeholder="District" data-errors="{filter_required:\'Please select district from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_tahsil" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';


    return $opt;
}
//////////////////////////////////////////
function get_division_tahsil($args = array()){

      
    $div_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');



    $division = $CI->common_model->get_division();


    if (!empty($args['div_code'])) {

        $div_code = $division[0]->div_code;

        $div_name = $division[0]->div_name;
    }

    $opt = '<input name="' . $args['rel'] . '_division" value="' . $div_code . '" class="mi_autocomplete width97" data-href="' . base_url() . 'auto/get_division_district/MP" placeholder="Division" data-errors="{filter_required:\'Please select district from dropdown list\'}" data-base=""  data-value="' . $div_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_div_district" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';


    return $opt;

    }
function get_stat_dis($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');



    $district = $CI->common_model->get_district(array('dst_code' => $args['dst_code'], 'st_id' => $args['st_code']));



    if (!empty($district) && $args['dst_code'] != '') {

        $dist_code = $district[0]->dst_code;

        $dst_name = $district[0]->dst_name;
    }

    $opt = '<input name="' . $args['rel'] . '_district" value="' . $dist_code . '" class="mi_autocomplete width97" data-href="' . base_url() . 'auto/get_district/' . $args['st_code'] . '" placeholder="District" data-errors="{filter_required:\'Please select district from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_dist_amb" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';


    return $opt;
}

function get_district_amb($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');



    $district = $CI->common_model->get_district(array('dst_code' => $args['dst_code'], 'st_id' => $args['st_code']));



    if (!empty($district) && $args['dst_code'] != '') {

        $dist_code = $district[0]->dst_code;

        $dst_name = $district[0]->dst_name;
    }


    $opt = '<input name="' . $args['rel'] . '_district" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_district_amb/' . $args['st_code'] . '" placeholder="District" data-errors="{filter_required:\'Please select district from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_ambulance" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';


    return $opt;
}
function get_district_preventive_amb($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');

    $district = $CI->common_model->get_district(array('dst_code' => $args['dst_code'], 'st_id' => $args['st_code']));

    if (!empty($district) && $args['dst_code'] != '') {

        $dist_code = $district[0]->dst_code;

        $dst_name = $district[0]->dst_name;
    }


    $opt = '<input name="' . $args['rel'] . '_district" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_district_closer_amb/' . $args['st_code'] . '" placeholder="District" data-errors="{filter_required:\'Please select district from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_preventive_ambulance" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';


    return $opt;
}
function get_preventive_ambulance($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');

    $district = $CI->common_model->get_closure_comp_amb(array('amb_rto_register_no' => $args['amb_ref_no'], 'amb_district' => $args['dst_code'], 'amb_state' => $args['st_code'],'amb_user'=>'108'));



    if (!empty($district) && $args['amb_ref_no'] != '') {

        $dist_code = $district[0]->amb_rto_register_no;

        $dst_name = $district[0]->amb_rto_register_no;
    }else{
        $dist_code = $args['amb_ref_no'];

        $dst_name = $args['amb_ref_no'];
    }

    $opt = '<input id="visitor_amb_id" name="' . $args['rel'] . '_ambulance" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_clo_comp_ambulance/' . $args['dst_code'] . '" placeholder="Ambulance Number" data-errors="{filter_required:\'Please select ambulance from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="update_preventive_location" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}
function get_district_break_amb($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');



    $district = $CI->common_model->get_district(array('dst_code' => $args['dst_code'], 'st_id' => $args['st_code']));



    if (!empty($district) && $args['dst_code'] != '') {

        $dist_code = $district[0]->dst_code;

        $dst_name = $district[0]->dst_name;
    }


    $opt = '<input name="' . $args['rel'] . '_district" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_district_oxygen_amb/' . $args['st_code'] . '" placeholder="District" data-errors="{filter_required:\'Please select district from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_break_ambulance" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';


    return $opt;
}
function get_clo_break_ambulance($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');

    $district = $CI->common_model->get_closure_comp_amb(array('amb_rto_register_no' => $args['amb_ref_no'], 'amb_district' => $args['dst_code'], 'amb_state' => $args['st_code']));



    if (!empty($district) && $args['amb_ref_no'] != '') {

        $dist_code = $district[0]->amb_rto_register_no;

        $dst_name = $district[0]->amb_rto_register_no;
    }else{
        $dist_code = $args['amb_ref_no'];

        $dst_name = $args['amb_ref_no'];
    }

    $opt = '<input id="demo_amb_id" name="' . $args['rel'] . '_ambulance" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_clo_acc_ambulance/' . $args['dst_code'] . '" placeholder="Ambulance Number" data-errors="{filter_required:\'Please select ambulance from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="update_base_location_break" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}
function get_district_onroad_offroad_amb($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');

    $district = $CI->common_model->get_district(array('dst_code' => $args['dst_code'], 'st_id' => $args['st_code']));

    if (!empty($district) && $args['dst_code'] != '') {

        $dist_code = $district[0]->dst_code;

        $dst_name = $district[0]->dst_name;
    }


    $opt = '<input name="' . $args['rel'] . '_district" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_district_closer_amb/' . $args['st_code'] . '" placeholder="District" data-errors="{filter_required:\'Please select district from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_onroad_offroad_ambulance" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';


    return $opt;
}
function get_district_tyre_amb($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');



    $district = $CI->common_model->get_district(array('dst_code' => $args['dst_code'], 'st_id' => $args['st_code']));



    if (!empty($district) && $args['dst_code'] != '') {

        $dist_code = $district[0]->dst_code;

        $dst_name = $district[0]->dst_name;
    }


    $opt = '<input name="' . $args['rel'] . '_district" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_district_acc_amb/' . $args['st_code'] . '" placeholder="District" data-errors="{filter_required:\'Please select district from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_tyre_comp_ambulance" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';


    return $opt;
}
function get_district_demo_amb($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');



    $district = $CI->common_model->get_district(array('dst_code' => $args['dst_code'], 'st_id' => $args['st_code']));



    if (!empty($district) && $args['dst_code'] != '') {

        $dist_code = $district[0]->dst_code;

        $dst_name = $district[0]->dst_name;
    }


    $opt = '<input name="' . $args['rel'] . '_district" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_district_oxygen_amb/' . $args['st_code'] . '" placeholder="District" data-errors="{filter_required:\'Please select district from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_demo_ambulance" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';


    return $opt;
}
function get_district_closer_amb_gri($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');



    $district = $CI->common_model->get_district(array('dst_code' => $args['dst_code'], 'st_id' => $args['st_code']));



    if (!empty($district) && $args['dst_code'] != '') {

        $dist_code = $district[0]->dst_code;

        $dst_name = $district[0]->dst_name;
    }


    $opt = '<input name="' . $args['rel'] . '_district" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_district_closer_amb/' . $args['st_code'] . '" placeholder="District" data-errors="{filter_required:\'Please select district from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_closer_comp_ambulance_gri" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';


    return $opt;
}
function get_district_closer_amb($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');



    $district = $CI->common_model->get_district(array('dst_code' => $args['dst_code'], 'st_id' => $args['st_code']));



    if (!empty($district) && $args['dst_code'] != '' && $args['dst_code'] != 'Backup') {

        $dist_code = $district[0]->dst_code;

        $dst_name = $district[0]->dst_name;
    }else if($args['dst_code'] == 'Backup'){
        $dist_code = 'Backup';

        $dst_name = 'Backup';
    }


    $opt = '<input name="' . $args['rel'] . '_district" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_district_closer_amb/' . $args['st_code'] . '" placeholder="District" data-errors="{filter_required:\'Please select district from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_closer_comp_ambulance" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';


    return $opt;
}
function get_district_fuel_amb($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');



    $district = $CI->common_model->get_district(array('dst_code' => $args['dst_code'], 'st_id' => $args['st_code']));



    if (!empty($district) && $args['dst_code'] != '') {

        $dist_code = $district[0]->dst_code;

        $dst_name = $district[0]->dst_name;
    }


    $opt = '<input name="' . $args['rel'] . '_district" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_district_fuel_amb/' . $args['st_code'] . '" placeholder="District" data-errors="{filter_required:\'Please select district from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_closer_fuel_ambulance" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';


    return $opt;
}
function get_district_acc_amb($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');



    $district = $CI->common_model->get_district(array('dst_code' => $args['dst_code'], 'st_id' => $args['st_code']));



    if (!empty($district) && $args['dst_code'] != '') {

        $dist_code = $district[0]->dst_code;

        $dst_name = $district[0]->dst_name;
    }


    $opt = '<input name="' . $args['rel'] . '_district" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_district_acc_amb/' . $args['st_code'] . '" placeholder="District" data-errors="{filter_required:\'Please select district from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_acc_comp_ambulance" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';


    return $opt;
}

function get_district_police($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');



    $district = $CI->common_model->get_district(array('dst_code' => $args['dst_code'], 'st_id' => $args['st_code']));



    if (!empty($district) && $args['dst_code'] != '') {

        $dist_code = $district[0]->dst_code;

        $dst_name = $district[0]->dst_name;
    }


    $opt = '<input name="' . $args['rel'] . '_district" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_district_police/' . $args['st_code'] . '" placeholder="District" data-errors="{filter_required:\'Please select district from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_tahsil_police_station" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';


    return $opt;
}
function get_div_district_tahsil($args = array()) {
    
    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');



    $district = $CI->common_model->get_district(array('div_code' =>  $args['div_code'],'dst_code' => $args['dst_code'], 'st_id' => $args['st_code']));



    if (!empty($district) && $args['dst_code'] != '') {

        $dist_code = $district[0]->dst_code;

        $dst_name = $district[0]->dst_name;
    }

    $opt = '<input name="' . $args['rel'] . '_districts" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_district_for_div/' . $args['div_code'] . '" placeholder="District" data-errors="{filter_required:\'Please select district from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_tahsil" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';
    



    return $opt;
}
function get_tahsil_police($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');
    //var_dump($args);



    $district = $CI->common_model->get_district(array('dst_code' => $args['dst_code'], 'st_id' => $args['st_code']));


    
    if ($select_thl) {
        $select[$select_thl] = "selected=selected";
    }

    $args = $dst_id;

    if (isset($args['dst_id'])) {
        $result = $CI->common_model->get_tahshil(array('thl_id' => $args['thl_id'], 'thl_district_code' => $args['dst_code'], 'st_id' => $args['st_code']));
    }
    if (isset($args['thl_id'])) {
        $result = $CI->common_model->get_tahshil(array('thl_id' => $args['thl_id'], 'thl_district_code' => $args['dst_code'], 'st_id' => $args['st_code']));
    }
    if (!empty($result) && $args['thl_id'] != '') {
        $tahsil_id = $result[0]->thl_id;
        $tahsil_name = $result[0]->thl_name;
    }

    $opt = '<input name="' . $args['rel'] . '_tahsil" value="' . $tahsil_id . '" class="mi_autocomplete map_canvas controls width97" placeholder="Tehsil" data-href="' . base_url() . 'auto/get_tal' . $args['dst_code'] . '" data-errors="{filter_required:\'Please select tahsil from dropdown list\'}" data-base="" data-value="' . $tahsil_name . '" data-autocom="yes" data-auto="' . $args['auto'] . '" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . ' data-callback-funct="load_auto_police_station">';


    return $opt;
}

function get_district_fire($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');



    $district = $CI->common_model->get_district(array('dst_code' => $args['dst_code'], 'st_id' => $args['st_code']));



    if (!empty($district) && $args['dst_code'] != '') {

        $dist_code = $district[0]->dst_code;

        $dst_name = $district[0]->dst_name;
    }


    $opt = '<input name="' . $args['rel'] . '_district" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_district_fire/' . $args['st_code'] . '" placeholder="District" data-errors="{filter_required:\'Please select district from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_fire_tahsil" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';


    return $opt;
}

function get_dis_police_station($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');



    $district = $CI->common_model->get_police_station(array('dst_code' => $args['dst_code'], 'st_id' => $args['st_code'],'p_id'=> $args['ps_id']));



    if (!empty($district) && $args['ps_id'] != '') {

        $dist_code = $district[0]->p_id;
        $dst_name = $district[0]->police_station_name;
        
    }


    $opt = '<input name="' . $args['rel'] . '_police" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_dis_police_station/' . $args['dst_code'] . '" placeholder="Police Station" data-errors="{filter_required:\'Please select Police station from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_police_info" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';


    return $opt;
}


function get_district_vahicle_amb($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');



    $district = $CI->common_model->get_district(array('dst_code' => $args['dst_code'], 'st_id' => $args['st_code']));



    if (!empty($district) && $args['dst_code'] != '') {

        $dist_code = $district[0]->dst_code;

        $dst_name = $district[0]->dst_name;
    }


    $opt = '<input name="' . $args['rel'] . '_district" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_district_oxygen_amb/' . $args['st_code'] . '" placeholder="District" data-errors="{filter_required:\'Please select district from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_vahicle_ambulance" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';


    return $opt;
}
function get_district_oxygen_amb($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');



    $district = $CI->common_model->get_district(array('dst_code' => $args['dst_code'], 'st_id' => $args['st_code']));



    if (!empty($district) && $args['dst_code'] != '') {

        $dist_code = $district[0]->dst_code;

        $dst_name = $district[0]->dst_name;
    }


    $opt = '<input name="' . $args['rel'] . '_district" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_district_oxygen_amb/' . $args['st_code'] . '" placeholder="District" data-errors="{filter_required:\'Please select district from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_closer_oxygen_ambulance" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';


    return $opt;
}
function get_dis_fire_station($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');



    $district = $CI->common_model->get_fire_station(array('f_tahsil' => $args['f_tahsil'], 'st_id' => $args['st_code']));



    if (!empty($district) && $args['dst_code'] != '') {

        $dist_code = $district[0]->dst_code;

        $dst_name = $district[0]->dst_name;
    }


    $opt = '<input name="' . $args['rel'] . '_fire" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_dis_fire_station/' . $args['dst_code'] . '" placeholder="Fire Station" data-errors="{filter_required:\'Please select Fire station from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_fire_info" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';


    return $opt;
}
function get_ambulance_cq($args = array()){
    
    

    $CI = get_instance();

    $CI->load->model('common_model');



    $district = $CI->common_model->get_ambulance(array('amb_rto_register_no' => $args['amb_ref_no'],  'amb_state' => $args['st_code']));



    if (!empty($district) && $args['amb_ref_no'] != '') {

        $dist_code = $district[0]->amb_rto_register_no;

        $dst_name = $district[0]->amb_rto_register_no;
    }else{
        $dist_code =  $args['amb_ref_no'];

        $dst_name =  $args['amb_ref_no'];
    }


    $opt = '<input id="cq_amb_id" name="' . $args['rel'] . '_ambulance" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_ambulance_cq/' . $args['dst_code'] . '" placeholder="Ambulance Number" data-errors="{filter_required:\'Please select Ambulance from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}
function get_district_ambulance($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');



    $district = $CI->common_model->get_ambulance(array('amb_rto_register_no' => $args['amb_ref_no'], 'amb_district' => $args['dst_code'], 'amb_state' => $args['st_code']));



    if (!empty($district) && $args['amb_ref_no'] != '') {

        $dist_code = $district[0]->amb_rto_register_no;

        $dst_name = $district[0]->amb_rto_register_no;
    }else{
        $dist_code =  $args['amb_ref_no'];

        $dst_name =  $args['amb_ref_no'];
    }


    $opt = '<input id="visitor_amb_id" name="' . $args['rel'] . '_ambulance" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_district_ambulance/' . $args['dst_code'] . '" placeholder="Ambulance Number" data-errors="{filter_required:\'Please select Ambulance from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="update_base_location" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}
function get_district_inspection_amb($args = array()){
    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');



    $district = $CI->common_model->get_district(array('dst_code' => $args['dst_code'], 'st_id' => $args['st_code']));



    if (!empty($district) && $args['dst_code'] != '') {

        $dist_code = $district[0]->dst_code;

        $dst_name = $district[0]->dst_name;
    }


    $opt = '<input name="' . $args['rel'] . '_district" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_district_acc_amb/' . $args['st_code'] . '" placeholder="District" data-errors="{filter_required:\'Please select district from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_inspection_comp_ambulance" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';


    return $opt;
}
function get_district_accidental_amb($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');



    $district = $CI->common_model->get_district(array('dst_code' => $args['dst_code'], 'st_id' => $args['st_code']));



    if (!empty($district) && $args['dst_code'] != '') {

        $dist_code = $district[0]->dst_code;

        $dst_name = $district[0]->dst_name;
    }


    $opt = '<input name="' . $args['rel'] . '_district" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_district_acc_amb/' . $args['st_code'] . '" placeholder="District" data-errors="{filter_required:\'Please select district from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_accidental_comp_ambulance" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';


    return $opt;
}
function get_onroad_offroad_ambulance($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');

    $district = $CI->common_model->get_closure_comp_amb(array('amb_rto_register_no' => $args['amb_ref_no'], 'amb_district' => $args['dst_code'], 'amb_state' => $args['st_code'],'amb_user'=>'108'));



    if (!empty($district) && $args['amb_ref_no'] != '') {

        $dist_code = $district[0]->amb_rto_register_no;

        $dst_name = $district[0]->amb_rto_register_no;
    }else{
        $dist_code = $args['amb_ref_no'];

        $dst_name = $args['amb_ref_no'];
    }

    $opt = '<input id="visitor_amb_id" name="' . $args['rel'] . '_ambulance" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_clo_comp_ambulance/' . $args['dst_code'] . '" placeholder="Ambulance Number" data-errors="{filter_required:\'Please select ambulance from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="update_onroad_offroad_base_location" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}
function get_clo_comp_ambulance_gri($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');

    $district = $CI->common_model->get_closure_comp_amb(array('amb_rto_register_no' => $args['amb_ref_no'], 'amb_district' => $args['dst_code'], 'amb_state' => $args['st_code'],'amb_user'=>'108'));



    if (!empty($district) && $args['amb_ref_no'] != '') {

        $dist_code = $district[0]->amb_rto_register_no;

        $dst_name = $district[0]->amb_rto_register_no;
    }else{
        $dist_code = $args['amb_ref_no'];

        $dst_name = $args['amb_ref_no'];
    }

    $opt = '<input id="visitor_amb_id" name="' . $args['rel'] . '_ambulance" value="' . $dist_code . '" class="mi_autocomplete width97" data-href="' . base_url() . 'auto/get_clo_comp_ambulance/' . $args['dst_code'] . '" placeholder="Enter Ambulance Number" data-errors="{filter_required:\'Please select ambulance from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="update_base_location" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}
function get_clo_comp_ambulance($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');

    $district = $CI->common_model->get_closure_comp_amb(array('amb_rto_register_no' => $args['amb_ref_no'], 'amb_district' => $args['dst_code'], 'amb_state' => $args['st_code'],'amb_user'=>'108'));



    if (!empty($district) && $args['amb_ref_no'] != '') {

        $dist_code = $district[0]->amb_rto_register_no;

        $dst_name = $district[0]->amb_rto_register_no;
    }else{
        $dist_code = $args['amb_ref_no'];

        $dst_name = $args['amb_ref_no'];
    }

    $opt = '<input id="visitor_amb_id" name="' . $args['rel'] . '_ambulance" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_clo_comp_ambulance/' . $args['dst_code'] . '" placeholder="Ambulance Number" data-errors="{filter_required:\'Please select ambulance from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="update_base_location" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}

function get_clo_fuel_fill_ambulance($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');

    $district = $CI->common_model->get_closure_comp_amb(array('amb_rto_register_no' => $args['amb_ref_no'], 'amb_district' => $args['dst_code'], 'amb_state' => $args['st_code']));



    if (!empty($district) && $args['amb_ref_no'] != '') {

        $dist_code = $district[0]->amb_rto_register_no;

        $dst_name = $district[0]->amb_rto_register_no;
    }else{
        $dist_code = $args['amb_ref_no'];

        $dst_name = $args['amb_ref_no'];
    }

    $opt = '<input id="visitor_amb_id" name="' . $args['rel'] . '_ambulance" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_clo_fuel_fill_ambulance/' . $args['dst_code'] . '" placeholder="Ambulance Number" data-errors="{filter_required:\'Please select ambulance from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="update_base_location_fuel" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}

function get_clo_acc_ambulance($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');

    $district = $CI->common_model->get_closure_comp_amb(array('amb_rto_register_no' => $args['amb_ref_no'], 'amb_district' => $args['dst_code'], 'amb_state' => $args['st_code']));



    if (!empty($district) && $args['amb_ref_no'] != '') {

        $dist_code = $district[0]->amb_rto_register_no;

        $dst_name = $district[0]->amb_rto_register_no;
    }else{
        $dist_code = $args['amb_ref_no'];

        $dst_name = $args['amb_ref_no'];
    }

    $opt = '<input id="visitor_amb_id" name="' . $args['rel'] . '_ambulance" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_clo_acc_ambulance/' . $args['dst_code'] . '" placeholder="Ambulance Number" data-errors="{filter_required:\'Please select ambulance from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="update_base_location_acc" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}
function get_update_clo_comp_ambulance($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');



    $district = $CI->common_model->get_update_closure_comp_amb(array('amb_rto_register_no' => $args['amb_ref_no'], 'amb_district' => $args['dst_code'], 'amb_state' => $args['st_code']));



    if (!empty($district) && $args['amb_ref_no'] != '') {

        $dist_code = $district[0]->amb_rto_register_no;

        $dst_name = $district[0]->amb_rto_register_no;
    }


    $opt = '<input id="visitor_amb_id" name="' . $args['rel'] . '_ambulance" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_update_clo_comp_ambulance/' . $args['dst_code'] . '" placeholder="Ambulance Number" data-errors="{filter_required:\'Please select ambulance from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="update_base_location" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}
function get_clo_tyre_ambulance($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');

    $district = $CI->common_model->get_closure_comp_amb(array('amb_rto_register_no' => $args['amb_ref_no'], 'amb_district' => $args['dst_code'], 'amb_state' => $args['st_code']));



    if (!empty($district) && $args['amb_ref_no'] != '') {

        $dist_code = $district[0]->amb_rto_register_no;

        $dst_name = $district[0]->amb_rto_register_no;
    }else{
        $dist_code = $args['amb_ref_no'];

        $dst_name = $args['amb_ref_no'];
    }

    $opt = '<input id="visitor_amb_id" name="' . $args['rel'] . '_ambulance" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_clo_acc_ambulance/' . $args['dst_code'] . '" placeholder="Ambulance Number" data-errors="{filter_required:\'Please select ambulance from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="update_base_location_tyre" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}
function get_clo_vahicle_ambulance($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');

    $district = $CI->common_model->get_closure_comp_amb(array('amb_rto_register_no' => $args['amb_ref_no'], 'amb_district' => $args['dst_code'], 'amb_state' => $args['st_code']));



    if (!empty($district) && $args['amb_ref_no'] != '') {

        $dist_code = $district[0]->amb_rto_register_no;

        $dst_name = $district[0]->amb_rto_register_no;
    }else{
        $dist_code = $args['amb_ref_no'];

        $dst_name = $args['amb_ref_no'];
    }

    $opt = '<input id="visitor_amb_id" name="' . $args['rel'] . '_ambulance" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_clo_fuel_fill_ambulance/' . $args['dst_code'] . '" placeholder="Ambulance Number" data-errors="{filter_required:\'Please select ambulance from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="update_base_location_vahicle" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}
function get_clo_oxygen_ambulance($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');

    $district = $CI->common_model->get_closure_comp_amb(array('amb_rto_register_no' => $args['amb_ref_no'], 'amb_district' => $args['dst_code'], 'amb_state' => $args['st_code']));



    if (!empty($district) && $args['amb_ref_no'] != '') {

        $dist_code = $district[0]->amb_rto_register_no;

        $dst_name = $district[0]->amb_rto_register_no;
    }else{
        $dist_code = $args['amb_ref_no'];

        $dst_name = $args['amb_ref_no'];
    }

    $opt = '<input id="visitor_amb_id" name="' . $args['rel'] . '_ambulance" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_clo_fuel_fill_ambulance/' . $args['dst_code'] . '" placeholder="Ambulance Number" data-errors="{filter_required:\'Please select ambulance from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="update_base_location_oxygen" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}
function get_clo_demo_ambulance($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');

    $district = $CI->common_model->get_closure_comp_amb(array('amb_rto_register_no' => $args['amb_ref_no'], 'amb_district' => $args['dst_code'], 'amb_state' => $args['st_code']));



    if (!empty($district) && $args['amb_ref_no'] != '') {

        $dist_code = $district[0]->amb_rto_register_no;

        $dst_name = $district[0]->amb_rto_register_no;
    }else{
        $dist_code = $args['amb_ref_no'];

        $dst_name = $args['amb_ref_no'];
    }

    $opt = '<input id="demo_amb_id" name="' . $args['rel'] . '_ambulance" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_clo_fuel_fill_ambulance/' . $args['dst_code'] . '" placeholder="Ambulance Number" data-errors="{filter_required:\'Please select ambulance from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="update_base_location_demo" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}
function get_clo_inspection_ambulance($args = array()){
    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');

    $district = $CI->common_model->get_closure_comp_amb(array('amb_rto_register_no' => $args['amb_ref_no'], 'amb_district' => $args['dst_code'], 'amb_state' => $args['st_code']));



    if (!empty($district) && $args['amb_ref_no'] != '') {

        $dist_code = $district[0]->amb_rto_register_no;

        $dst_name = $district[0]->amb_rto_register_no;
    }else{
        $dist_code = $args['amb_ref_no'];

        $dst_name = $args['amb_ref_no'];
    }

    $opt = '<input id="visitor_amb_id" name="' . $args['rel'] . '_ambulance" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_clo_acc_ambulance/' . $args['dst_code'] . '" placeholder="Ambulance Number" data-errors="{filter_required:\'Please select ambulance from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="update_base_location_inspection" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}
function get_clo_accidental_ambulance($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');

    $district = $CI->common_model->get_closure_comp_amb(array('amb_rto_register_no' => $args['amb_ref_no'], 'amb_district' => $args['dst_code'], 'amb_state' => $args['st_code']));



    if (!empty($district) && $args['amb_ref_no'] != '') {

        $dist_code = $district[0]->amb_rto_register_no;

        $dst_name = $district[0]->amb_rto_register_no;
    }else{
        $dist_code = $args['amb_ref_no'];

        $dst_name = $args['amb_ref_no'];
    }

    $opt = '<input id="visitor_amb_id" name="' . $args['rel'] . '_ambulance" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_clo_acc_ambulance/' . $args['dst_code'] . '" placeholder="Ambulance Number" data-errors="{filter_required:\'Please select ambulance from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="update_base_location_accidental" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}
function get_update_oxy_feel_ambulance($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');



    $district = $CI->common_model->get_update_oxy_feel_ambulance(array('amb_rto_register_no' => $args['amb_ref_no'], 'amb_district' => $args['dst_code'], 'amb_state' => $args['st_code']));



    if (!empty($district) && $args['amb_ref_no'] != '') {

        $dist_code = $district[0]->amb_rto_register_no;

        $dst_name = $district[0]->amb_rto_register_no;
    }

    if ($args['amb_ref_no'] != '') {
        $dist_code = $args['amb_ref_no'];
        $dst_name = $args['amb_ref_no'];
    }


    $opt = '<input id="visitor_amb_id" name="' . $args['rel'] . '_ambulance" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_update_oxy_feel_ambulance/' . $args['dst_code'] . '" placeholder="Ambulance Number" data-errors="{filter_required:\'Please select ambulance from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="update_base_location" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}

function get_break_maintaince_ambulance($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');



    $district = $CI->common_model->get_break_maintaince_ambulance(array('amb_rto_register_no' => $args['amb_ref_no'], 'amb_district' => $args['dst_code'], 'amb_state' => $args['st_code']));



    if (!empty($district) && $args['amb_ref_no'] != '') {

        $dist_code = $district[0]->amb_rto_register_no;

        $dst_name = $district[0]->amb_rto_register_no;
    }else{
        $dist_code = $args['amb_ref_no'];

        $dst_name = $args['amb_ref_no'];
    }


    $opt = '<input id="visitor_amb_id" name="' . $args['rel'] . '_ambulance" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_break_maintaince_ambulance/' . $args['dst_code'] . '" placeholder="Ambulance Number" data-errors="{filter_required:\'Please select ambulance from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="update_base_location" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}

function get_tyre_life_ambulance($args = array()) {

    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');



    $district = $CI->common_model->get_tyre_life_amb(array('amb_rto_register_no' => $args['amb_ref_no'], 'amb_district' => $args['dst_code'], 'amb_state' => $args['st_code']));



    if (!empty($district) && $args['amb_ref_no'] != '') {

        $dist_code = $district[0]->amb_rto_register_no;

        $dst_name = $district[0]->amb_rto_register_no;
    }


    $opt = '<input  name="' . $args['rel'] . '_ambulance" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_tyre_life_ambulance/' . $args['dst_code'] . '" placeholder="Ambulance Number" data-errors="{filter_required:\'Please select ambulance from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="update_base_location" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}

function get_police_tahshil($dst_id = '', $select_thl = '') {
    $dist_code = $dst_name = '';

    $CI = get_instance();
    $CI->load->model('common_model');


    if ($select_thl) {
        $select[$select_thl] = "selected=selected";
    }

    $args = $dst_id;

    if (isset($args['dst_id'])) {
        $result = $CI->common_model->get_tahshil(array('thl_id' => $args['thl_id'], 'thl_district_code' => $args['dst_code'], 'st_id' => $args['st_code']));
    }
    if (isset($args['thl_id'])) {
        $result = $CI->common_model->get_tahshil(array('thl_id' => $args['thl_id'], 'thl_district_code' => $args['dst_code'], 'st_id' => $args['st_code']));
    }
    if (!empty($result) && $args['thl_id'] != '') {
        $tahsil_id = $result[0]->thl_id;
        $tahsil_name = $result[0]->thl_name;
    }

    $opt = '<input name="' . $args['rel'] . '_tahsil" value="' . $tahsil_id . '" class="mi_autocomplete map_canvas controls width97" placeholder="Tehsil" data-href="' . base_url() . 'auto/get_tal/' . $args['dst_code'] . '" data-errors="{filter_required:\'Please select tahsil from dropdown list\'}" data-base="" data-value="' . $tahsil_name . '" data-autocom="yes" data-auto="' . $args['auto'] . '" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . ' data-callback-funct="load_auto_police_station">';

    return $opt;
}


function get_fire_tahshil($dst_id = '', $select_thl = '') {
    $dist_code = $dst_name = '';
    

    $CI = get_instance();
    $CI->load->model('common_model');


    if ($select_thl) {
        $select[$select_thl] = "selected=selected";
    }

    $args = $dst_id;

    if (isset($args['dst_id'])) {
        $result = $CI->common_model->get_tahshil(array('thl_id' => $args['thl_id'], 'thl_district_code' => $args['dst_code'], 'st_id' => $args['st_code']));
    }
    if (isset($args['thl_id'])) {
        $result = $CI->common_model->get_tahshil(array('thl_id' => $args['thl_id'], 'thl_district_code' => $args['dst_code'], 'st_id' => $args['st_code']));
    }
    if (!empty($result) && $args['thl_id'] != '') {
        $tahsil_id = $result[0]->thl_id;
        $tahsil_name = $result[0]->thl_name;
    }


    $opt = '<input name="' . $args['rel'] . '_tahsil" value="' . $tahsil_id . '" class="mi_autocomplete map_canvas controls width97" placeholder="Tehsil" data-href="' . base_url() . 'auto/get_tal/' . $args['dst_code'] . '" data-errors="{filter_required:\'Please select tahsil from dropdown list\'}" data-base="" data-value="' . $tahsil_name . '" data-autocom="yes" data-auto="' . $args['auto'] . '" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . ' data-callback-funct="load_auto_fire_station">';

    return $opt;
}
function get_tahshil($dst_id = '', $select_thl = '') {
    $dist_code = $dst_name = '';

    $CI = get_instance();
    $CI->load->model('common_model');


    if ($select_thl) {
        $select[$select_thl] = "selected=selected";
    }

    $args = $dst_id;

    if (isset($args['dst_id'])) {
        $result = $CI->common_model->get_tahshil(array('thl_id' => $args['thl_id'], 'thl_district_code' => $args['dst_code'], 'st_id' => $args['st_code']));
    }
    if (isset($args['thl_id'])) {
        $result = $CI->common_model->get_tahshil(array('thl_id' => $args['thl_id'], 'thl_district_code' => $args['dst_code'], 'st_id' => $args['st_code']));
    }
    if (!empty($result) && $args['thl_id'] != '') {
        $tahsil_id = $result[0]->thl_id;
        $tahsil_name = $result[0]->thl_name;
    }

    $opt = '<input name="' . $args['rel'] . '_tahsil" value="' . $tahsil_id . '" class="mi_autocomplete map_canvas controls width97 filter_required" placeholder="Tehsil" data-href="' . base_url() . 'auto/get_tal/' . $args['dst_code'] . '" data-errors="{filter_required:\'Please select tahsil from dropdown list\'}" data-base="" data-value="' . $tahsil_name . '" data-autocom="yes" data-auto="' . $args['auto'] . '" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . ' data-callback-funct="load_auto_inc_tahsil">';

    return $opt;
}

function get_ambulance($dst_id = '', $select_thl = '') {
    $dist_code = $dst_name = '';

    $CI = get_instance();
    $CI->load->model('common_model');


    if ($select_thl) {
        $select[$select_thl] = "selected=selected";
    }

    $args = $dst_id;

    if (isset($args['dst_id'])) {
        $result = $CI->common_model->get_ambulance(array('amb_district' => $args['dst_code'], 'st_id' => $args['st_code']));
    }



    if (!empty($result) && $args['amb_id'] != '') {
        $amb_id = $result[0]->amb_rto_register_no;
        $amb_rto_register_no = $result[0]->amb_rto_register_no;
    }

    $opt = '<input name="' . $args['rel'] . '_tahsil" value="' . $amb_id . '" class="mi_autocomplete map_canvas controls width97" placeholder="Tahsil" data-href="' . base_url() . 'auto/get_amb/' . $args['dst_code'] . '" data-errors="{filter_required:\'Please select tahsil from dropdown list\'}" data-base="" data-value="' . $amb_rto_register_no . '" data-autocom="yes" data-auto="' . $args['auto'] . '" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . ' data-callback-funct="load_auto_inc_tahsil">';

    return $opt;
}

function get_city($args = array()) {

    $city_id = $cty_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');

    $city = $CI->common_model->get_city(array('cty_id' => $args['cty_id'], 'dist_code' => $$args['dst_code']));

    if (!empty($city) && $args['cty_id'] != '') {
        $city_id = $city[0]->cty_id;
        $cty_name = $city[0]->cty_name;
    }

    $opt = '<input name="' . $args['rel'] . '_ms_city" value="' . $city_id . '" class="mi_autocomplete map_canvas controls width97" placeholder="City/Village" data-href="' . base_url() . 'auto/get_dis_city/' . $args['dst_code'] . '" data-errors="{filter_required:\'Please select city from dropdown list\'}" data-base="" data-value="' . $cty_name . '" data-auto="' . $args['auto'] . '" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}
function get_base_city($args = array()) {

    $city_id = $cty_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');

    $city = $CI->common_model->get_city(array('cty_id' => $args['cty_id'],'thl_code' => $args['thl_id'],'dist_code' => $args['dst_code']));

    if (!empty($city) && $args['cty_id'] != '') {
        $city_id = $city[0]->cty_id;
        $cty_name = $city[0]->cty_name;
    }

    $opt = '<input name="' . $args['rel'] . '_ms_city" value="' . $city_id . '" class="mi_autocomplete map_canvas controls width97 " placeholder="City/Village" data-href="' . base_url() . 'auto/get_dis_city/' . $args['dst_code'] . '" data-errors="{filter_required:\'Please select city from dropdown list\'}" data-base="" data-value="' . $cty_name . '" data-auto="' . $args['auto'] . '" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}
function get_city_tahsil($args = array()) {

    $city_id = $cty_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');

    $city = $CI->common_model->get_city(array('cty_id' => $args['cty_id'], 'thl_code' => $args['thshil_code']));

    if (!empty($city) && $args['cty_id'] != '') {
        $city_id = $city[0]->cty_id;
        $cty_name = $city[0]->cty_name;
    }
    $opt = '<input name="' . $args['rel'] . '_ms_city" value="' . $city_id . '" class="mi_autocomplete map_canvas controls width97" placeholder="City/Village" data-href="' . base_url() . 'auto/get_tahsil_city/' . $args['thshil_code'] . '" data-errors="{filter_required:\'Please select city from dropdown list\'}" data-base="" data-value="' . $cty_name . '" data-auto="' . $args['auto'] . '" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . ' data-callback-funct="load_auto_inc_city">';

    return $opt;
}

function get_city_tahsil_vendor($args = array()) {

    $city_id = $cty_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');

    $city = $CI->common_model->get_city(array('cty_id' => $args['cty_id'], 'thl_code' => $args['thshil_code']));

    if (!empty($city) && $args['cty_id'] != '') {
        $city_id = $city[0]->cty_id;
        $cty_name = $city[0]->cty_name;
    }
    $opt = '<input name="' . $args['rel'] . '_ms_city" value="' . $city_id . '" class="mi_autocomplete filter_required map_canvas controls width97" placeholder="City/Village" data-href="' . base_url() . 'auto/get_tahsil_city/' . $args['thshil_code'] . '" data-errors="{filter_required:\'Please select city from dropdown list\'}" data-base="" data-value="' . $cty_name . '" data-auto="' . $args['auto'] . '" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . ' data-callback-funct="load_auto_inc_city">';

    return $opt;
}

///////////////MI44////////////////////////
//
//Purpose : To get ambulance status
//
/////////////////////////////////////////////

function get_amb_status($ambs_id = '') {

    $CI = get_instance();
    $CI->load->model('amb_model');

    if ($ambs_id) {
        $select[$ambs_id] = "selected='selected'";
    }

    $amb_status = $CI->amb_model->get_amb_status();

    if (!empty($amb_status)) {

        foreach ($amb_status as $opt) {

            $options .= "<option value='" . $opt->ambs_id . "' " . $select[$opt->ambs_id] . " >" . $opt->ambs_name . "</option>";
        }
    }

    return $options;
}

function get_amb_hp($ambs_id = '') {

    $CI = get_instance();
    $CI->load->model('amb_model');

    $args = array(
        'amb_rto_register_no' => $ambs_id
    );

    $amb = $CI->amb_model->get_amb_data($args);

    return $amb[0]->hp_name;
}

function get_amb_mob($ambs_id = '') {

    $CI = get_instance();
    $CI->load->model('amb_model');

    $args = array(
        'amb_rto_register_no' => $ambs_id
    );

    $amb = $CI->amb_model->get_amb_data($args);

    return $amb[0]->amb_default_mobile;
}

function get_amb_mob_pilot($ambs_id = '') {

    $CI = get_instance();
    $CI->load->model('amb_model');

    $args = array(
        'amb_rto_register_no' => $ambs_id
    );

    $amb = $CI->amb_model->get_amb_data($args);

    return $amb[0]->amb_pilot_mobile;
}
///////////////MI44////////////////////////
//
//Purpose : To get ambulance Type
//
/////////////////////////////////////////////

function get_amb_type($ambt_id = '') {

    $CI = get_instance();

    $CI->load->model('amb_model');

    if ($ambt_id) {
        $select[$ambt_id] = "selected='selected'";
    }

    $amb_type = $CI->amb_model->get_amb_type();


    if (!empty($amb_type)) {

        foreach ($amb_type as $opt) {

            $options .= "<option value='" . $opt->ambt_id . "' " . $select[$opt->ambt_name] . " >" . $opt->ambt_name . "</option>";
        }
    }

    return $options;
}

function get_third_party($thirdparty_id='') {
 
    $CI = get_instance();

    $CI->load->model('amb_model');
    if ($thirdparty_id) {
        $select[$thirdparty_id] = "selected='selected'";
    }

    $thirdparty_list = $CI->amb_model->get_amb_thirdparty();

// var_dump($thirdparty_list);

    if (!empty($thirdparty_list)) {

        foreach ($thirdparty_list as $opt) {

            $options .= "<option value='" . $opt->thirdparty_id . "' " . $select[$opt->thirdparty_id] . " >" . $opt->thirdparty_name . "</option>";
        }
    }

    return $options;
}

function get_amb_vendor($vendor_id='') {
 
    $CI = get_instance();

    $CI->load->model('amb_model');
    $select = [];
    if ($vendor_id) {
        $select[$vendor_id] = "selected='selected'";
    }

    $vendor_list = $CI->amb_model->get_amb_vendor($select);

// var_dump($thirdparty_list);

    if (!empty($vendor_list)) {

        foreach ($vendor_list as $opt) {

            $options .= "<option value='" . $opt->vendor_id . "' " . $select[$opt->vendor_id] . " >" . $opt->vendor_name . "</option>";
        }
    }

    return $options;
}

function get_third_party_name($thirdparty_id='') {
 
    $CI = get_instance();

    $CI->load->model('amb_model');
    if ($thirdparty_id) {
        $select[$thirdparty_id] = "selected='selected'";
    }

    $thirdparty_list = $CI->amb_model->get_amb_thirdparty(array('thirdparty_id'=>$thirdparty_id));

    return $thirdparty_list[0]->thirdparty_name;
    
}
function follow_up_count_corona($corona_id,$from_date) {

    $CI = get_instance();
    $CI->load->model('corona_model');
    $args = array('corona_id' => $corona_id,'from_date'=>$from_date ,'get_count'=>TRUE);
    $amb_status = $CI->corona_model->corona_out_calls($args);
    return $amb_status;
}
function get_amb_type_by_id($ambt_id = '') {

    $CI = get_instance();

    $CI->load->model('amb_model');

    if ($ambt_id) {
        $select[$ambt_id] = "selected='selected'";
    }

    $amb_type = $CI->amb_model->get_amb_type();


    if (!empty($amb_type)) {

        foreach ($amb_type as $opt) {

            $options .= "<option value='" . $opt->ambt_id . "' " . $select[$opt->ambt_id] . " >" . $opt->ambt_name . "</option>";
        }
    }

    return $options;
}
function get_battery_make($ambt_id = '') {

    $CI = get_instance();

    $CI->load->model('battery_model');

    if ($ambt_id) {
        $select[$ambt_id] = "selected='selected'";
    }

    $amb_type = $CI->battery_model->get_battery_make();


    if (!empty($amb_type)) {

        foreach ($amb_type as $opt) {

            $options .= "<option value='" . $opt->id . "' " . $select[$opt->id] . " >" . $opt->battery_make . "</option>";
        }
    }

    return $options;
}
////////////MI44//////////////////////
//
//Purpose :  Get area type
//           Ambulance and hospital section
//
//////////////////////////////////////

function get_area_type($ar_id = '') {

    $CI = get_instance();

    $CI->load->model('common_model');

    if ($ar_id != '') {
        $select[$ar_id] = "selected='selected'";
    }

    $area_type = $CI->common_model->get_area_type();

    if (!empty($area_type)) {
        foreach ($area_type as $opt) {
            $options .= "<option value='" . $opt->ar_id . "' " . $select[$opt->ar_id] . " >" . $opt->ar_name . "</option>";
        }
    }

    return $options;
}

////////////MI44//////////////////////
//
//Purpose :  Get hospital type
//           hospital section
//
//////////////////////////////////////


function get_hosp_type($hosp_type = '') {

    $CI = get_instance();

    $CI->load->model('common_model');

    if ($hosp_type != '') {
        $select[$hosp_type] = "selected='selected'";
    }


    $hp_type = $CI->common_model->get_hp_type();

    if (!empty($hp_type)) {
        foreach ($hp_type as $opt) {
            $options .= "<option value='" . $opt->hosp_id . "' " . $select[$opt->hosp_id] . " >" . $opt->hosp_type .  " - " . $opt->full_name . "</option>";
        }
    }

    return $options;
}
function get_hosp_type_by_id_full_name($hosp_type_id = '') {

    $CI = get_instance();

    $CI->load->model('common_model');



    $hp_type = $CI->common_model->get_hp_type($hosp_type_id);

    return $hp_type[0]->full_name;
}
function get_hosp_type_by_id($hosp_type_id = '') {

    $CI = get_instance();

    $CI->load->model('common_model');



    $hp_type = $CI->common_model->get_hp_type($hosp_type_id);

    return $hp_type[0]->hosp_type;
}

function rec_perpg($option = '') {

    if ($option) {
        $select[$option] = "selected='selected'";
    }

    $lim_arr = array(10,50, 100,);

    foreach ($lim_arr as $lm) {

        $opt .= "<option  value='" . $lm . "'  " . $select[$lm] . ">" . $lm . "</option>";
    }

    return $opt;
}


function rec_perpg_sup($option = '') {

    if ($option) {
        $select[$option] = "selected='selected'";
    }

    $lim_arr = array(10, 25, 50);

    foreach ($lim_arr as $lm) {

        $opt .= "<option  value='" . $lm . "'  " . $select[$lm] . ">" . $lm . "</option>";
    }

    return $opt;
}


///////////////MI44////////////////////////
//
//Purpose : clg filter action
//
/////////////////////////////////////////////
function get_clg_status($option = '') {

    if ($option != null) {
        $select[$option] = "selected='selected'";
    }

    $CI = get_instance();

    $CI->load->model('colleagues_model');

    $clg_data = $CI->colleagues_model->get_all_colleagues();

    $sts = array('0' => 'Inactive', '1' => 'Active',);

    if (is_array($sts)) {

        foreach ($sts as $key => $value) {

            $opt .= "<option  value='" . $key . "'  " . $select[$key] . ">" . $value . "</option>";
        }
    }

    return $opt;
}

function get_clg_data_by_ref_id($ref_id = '') {
    $args = array();
    $CI = get_instance();
    $args['clg_reff_id'] = $ref_id;

    $CI->load->model('colleagues_model');

    $clg_data = $CI->colleagues_model->get_clg_data($args);

    return $clg_data;
}
    function get_call_type_name($call_id,$call_type){
        
        $CI = get_instance();
        $CI->load->model('colleagues_model');

        $call_type = $CI->pcr_model->get_calltype_epcr(array('id' => $call_id,'call_type_data'=> $call_type));
        $call_type_name = $call_type[0]->call_type;

        return $call_type_name;
    }
    function get_validate_clg_name_by_ref_id($ref_id = ''){
        $args = array();
        $CI = get_instance();
        $args['clg_reff_id'] = $ref_id;

        $CI->load->model('colleagues_model');

        $clg_data = $CI->colleagues_model->get_clg_data($args);
        $clg_name = $clg_data[0]->clg_first_name.' '.$clg_data[0]->clg_mid_name.' '.$clg_data[0]->clg_last_name;

        return $clg_name;
    }
function get_clg_name_by_ref_id($ref_id = '') {
    $args = array();
    $CI = get_instance();
    $args['clg_reff_id'] = $ref_id;

    $CI->load->model('colleagues_model');

    $clg_data = $CI->colleagues_model->get_clg_data($args);
    $clg_name = $clg_data[0]->clg_first_name.' '.$clg_data[0]->clg_mid_name.' '.$clg_data[0]->clg_last_name;

    return $clg_name;
}
function get_ques_ans_data_by_ref_id($ref_id = '') {
    $args = array();
    $CI = get_instance();
    $args['inc_ref_id'] = $ref_id;

    $CI->load->model('inc_model');

    $clg_data = $CI->inc_model->get_inc_summary($args);

    return $clg_data;
}

function get_hospital_by_id($hp_id = '') {
    $args = array();
    $CI = get_instance();
    $args['hp_id'] = $hp_id;

    $CI->load->model('hp_model');
   // var_dump($args);die;

    $clg_data = $CI->hp_model->get_hp_data_hospital($args);

    return $clg_data;
}

function get_base_location_by_id($hp_id = '') {
    $args = array();
    $CI = get_instance();
    $args['hp_id'] = $hp_id;

    $CI->load->model('hp_model');
    //var_dump($args);die;
    $clg_data = $CI->hp_model->get_hp_data($args);

    return $clg_data;
}
///////////////MI44////////////////////////
//
//Purpose : To get question in questionaire table
//
/////////////////////////////////////////////

function get_question($que_id = '') {

    if ($que_id != null) {
        $select[$que_id] = "selected='selected'";
    }

    $CI = get_instance();

    $CI->load->model('common_model');

    $question = $CI->common_model->get_question(array('que_type' => 'enq'));

    if (!empty($question)) {
        foreach ($question as $que) {
            $opt .= "<option  value='" . $que->que_id . "'  " . $select[$que->que_id] . ">" . $que->que_question . "</option>";
        }
    }
    return $opt;
}

function get_type_of_call($cl_id = '') {

    if ($cl_id != null) {
        $select[$cl_id] = "selected='selected'";
    }

    $CI = get_instance();

    $CI->load->model('common_model');

    $call_type = $CI->common_model->get_call_type();

    if (!empty($call_type)) {

        foreach ($call_type as $type) {

            $opt .= "<option  value='" . $type->cl_id . "'  " . $select[$type->cl_id] . ">" . $type->cl_type . "</option>";
        }
    }
    return $opt;
}

//// Created by MI42 ///////////////////////////
// 
// Purpose : Get formatted time.
// 
///////////////////////////////////////////////// 

function get_base_month() {


    $CI = get_instance();

    $bs_month = $CI->session->userdata('base_month');


    $today = date('Y-m-d');


    if (empty($bs_month) || ($bs_month['set_date'] != $today)) {

        $base_month = $CI->common_model->get_base_month($today);

        $bs = array('base_month' => $base_month[0]->months, 'set_date' => $today);

        $CI->session->set_userdata('base_month', $bs);

        $base_month = $base_month[0]->months;
    } else {

        $base_month = $bs_month['base_month'];
    }



    return $base_month;
}

//// Created by MI42 ///////////////////////////
// 
// Purpose : Get gender.
// 
///////////////////////////////////////////////// 

function get_gen($gtype = '') {

    $gen = array('M' => 'Male', 'F' => 'Female', 'O' => 'Transgender');

    return $gen[$gtype];
}

//// Created by MI42 ///////////////////////////
// 
// Purpose : Get gender.
// 
///////////////////////////////////////////////// 

function get_gen_type($gtype = '') {

    $gen = array('M' => 'male', 'F' => 'female', 'O' => 'transgender');

    if ($gtype != '') {
        $select[$gtype] = "selected='selected'";
    }

    foreach ($gen as $key => $val) {

        $opt .= "<option  value='" . $key . "'  " . $select[$key] . ">" . $val . "</option>";
    }


    return $opt;
}

function show_shift_type($gtype = '') {


    $shift = array('1' => 'Morning', '2' => 'Afternoon', '3' => 'Night', '4' => 'General');

    return $shift[$gtype];
}

function show_shift_type_by_id($shift_id = '') {

    $CI = get_instance();

    $CI->load->model('common_model');
    
    $args = array('shift_id'=>$shift_id);
    $shift_info = $CI->common_model->get_shift($args);

    return $shift_info[0]->shift_name;
}

function show_work_shop_by_id($ws_id = '') {

    $CI = get_instance();

    $CI->load->model('fleet_model');
    
    $args = array('ws_id'=>$ws_id);
    $work_station_info = $CI->fleet_model->get_work_station($args);
    //var_dump($work_station_info);
    //die();

    return $work_station_info[0]->ws_station_name;
}

//// Created by MI13 ///////////////////////////
// 
// Purpose : Get Shift.
// 
///////////////////////////////////////////////// 

function get_shift_type($gtype = '') {

    //$gen = array('1' => 'Morning', '2' => 'Afternoon', '3' => 'Night', '4' => 'General');
    $CI = get_instance();

    $CI->load->model('common_model');
    $gen = $CI->common_model->get_shift($args);

    if ($gtype != '') {
        $select[$gtype] = "selected='selected'";
    }

    foreach ($gen as $key => $val) {
        $key1 = $val->shift_id;
        $val1 = $val->shift_name;
        $opt .= "<option  value='" . $key1 . "'  " . $select[$key1] . ">" . $val1 . "</option>";
    }


    return $opt;
}

//// Created by MI42 ///////////////////////////
// 
// Purpose : Get gender.
// 
///////////////////////////////////////////////// 

function get_bgroup($bg = '') {

    $bgroup = array('A' => 'A', 'B' => 'B', 'O' => 'O', 'AB' => 'AB');

    if ($bg != '') {
        $select[$bg] = "selected='selected'";
    }

    foreach ($bgroup as $bgp) {

        $opt .= "<option  value='" . $bgp . "'  " . $select[$bgp] . ">" . $bgp . "</option>";
    }


    return $opt;
}

//// Created by MI42 ///////////////////////////
// 
// Purpose : Get incidence of last 3 days.
// 
/////////////////////////////////////////////////

function get_defalut_inc($base_month = '', $dtmf = '', $dtmt = '') {

    $CI = get_instance();

    $CI->load->model('Pet_model');

    $args = array(
        'base_month' => $base_month,
        'inc_datef' => date('Y-m-d', strtotime("-3 day")) . " " . $dtmf,
        'inc_datet' => date('Y-m-d') . " " . $dtmt
    );



    $pt_details = $CI->Pet_model->get_pt_inc($args);

    return $pt_details;
}

//// Created by MI42 ///////////////////////////
// 
// Purpose : To update operator status.
// 
/////////////////////////////////////////////////

function update_opt_status($args = array()) {

    $CI = get_instance();

    $CI->load->model('common_model');

    $args = array(
        'operator_id' => $args['opt_id'],
        'sub_id' => $args['sub_id'],
        'sub_type' => $args['sub_type']
    );
    
    //var_dump($args);
    $update = array('sub_status' => 'ATND');


    $res = $CI->common_model->update_operator($args, $update);
   // var_dump($res);

    return $res;
}

//////////////////////MI44////////////////////////
//
//Purpose : consents details
//
////////////////////////////////////////////////

function consents_info($cons_id = '') {

    $CI = get_instance();

    $CI->load->model('common_model');

    $con_info = $CI->common_model->consents_info();

    $select[$cons_id] = "selected='selected'";

    foreach ($con_info as $value) {

        $opt .= "<option  value='" . $value->cons_id . "'  " . $select[$value->cons_name] . ">" . $value->cons_name . "</option>";
    }
    return $opt;
}

/////////////////MI44////////////////////////////////
//
//Purpose : get relation on master table
//
//////////////////////////////////////////////////////

function get_relation($cons_relation = '') {

    $CI = get_instance();

    $CI->load->model('common_model');

    $select[$cons_relation] = "selected='selected'";

    $rel = $CI->common_model->get_relation();

    foreach ($rel as $rel_info) {

        $opt .= "<option  value='" . $rel_info->rel_id . "'  " . $select[$rel_info->rel_id] . ">" . $rel_info->rel_name . "</option>";
    }
    return $opt;
}

function get_relation_by_id($cons_relation = '') {

    $CI = get_instance();

    $CI->load->model('common_model');

    $select[$cons_relation] = "selected='selected'";

    //$rel = $CI->common_model->get_relation();
    $rel = $CI->common_model->get_relation_by_id($cons_relation);
    
  // $ss =  $rel[$cons_relation]->rel_id;
   //if($ss == $cons_relation){
    $opt = $rel[0]->rel_name ;
   // var_dump( $rel[0]->rel_name  );die;
    return $opt;
     
}

//// Created by MI42 ///////////////////////////
// 
// Purpose : To get ( yes/ No ) option.
// 
///////////////////////////////////////////////// 
function get_breathing_list(){
    $opt = array('Present' => 'Present', 'Compromised' => 'Compromised', 'Absent' => 'Absent');

    return $opt;
}
function get_yn_opt() {

    //$opt = array('y' => 'Yes', 'n' => 'No');
    $opt = array('I' => 'Improve', 'S' => 'Statusquo', 'W' => 'Worsened');

    return $opt;
}
function get_airway_list(){
    $opt = array('Open' => 'Open', 'Compromised' => 'Compromised', 'Absent' => 'Absent');

    return $opt;
}
//// Created by MI42 ///////////////////////////
// 
// Purpose : To get ( Present / Absent ) option.
// 
///////////////////////////////////////////////// 
function get_ongoing_past_med_his_list($args = array()){
   // $opt = array('Diabetes' => 'Diabetes', 'Hipertension' => 'Hipertension','conoary_Artery_Disease' => 'conoary Artery Disease [IHD]', 'stroke' => 'stroke','other'=>'Other');
    $CI = get_instance();

    $CI->load->model('pcr_model');
    $opt = $CI->pcr_model->get_past_medical_history();
    
    return $opt;
}
function get_yesno_opt(){
    $opt = array('yes' => 'Yes', 'no' => 'No');

    return $opt;
}
function get_pa_opt($args = array()) {

    $opt = array('yes' => 'Present', 'no' => 'Absent');

    return $opt;
}
function get_ongoing_list($args = array()) {

    $opt = array('yes' => 'Yes', 'no' => 'No');

    return $opt;
}
/* MI13
 *  Truama assessment 
 */
function get_cardiac_list($args = array()){
    $opt = array('yes' => 'Yes', 'no' => 'No');

    return $opt;
}
function get_injury() {

    $CI = get_instance();

    $CI->load->model('pcr_model');
    $injuries = $CI->pcr_model->get_injury();

    foreach ($injuries as $inj) {

        $opt .= "<option  value='" . $inj->inj_id . "'  " . $select[$inj->inj_id] . ">" . $inj->inj_name . "</option>";
    }
    return $opt;
}

function get_front($id) {
    $CI = get_instance();

    $CI->load->model('pcr_model');
    $fronts = $CI->pcr_model->get_front();

    foreach ($fronts as $front) {
        $selected = "";
        if ($id == $front->id) {
            $selected = "selected";
        }
        $opt .= "<option  value='" . $front->id . "'  " . $selected . ">" . $front->front_name . "</option>";
    }
    return $opt;
}

function get_back($id) {
    $CI = get_instance();

    $CI->load->model('pcr_model');
    $backs = $CI->pcr_model->get_back();

    foreach ($backs as $back) {
        $selected = "";
        if ($id == $back->id) {
            $selected = "selected";
        }
        $opt .= "<option  value='" . $back->id . "'  " . $selected . ">" . $back->back_name . "</option>";
    }
    return $opt;
}

function get_side($id) {
    $CI = get_instance();

    $CI->load->model('pcr_model');
    $sides = $CI->pcr_model->get_side();

    foreach ($sides as $side) {
        $selected = "";
        if ($id == $side->id) {
            $selected = "selected";
        }
        $opt .= "<option  value='" . $side->id . "'  " . $selected . ">" . $side->side_name . "</option>";
    }
    return $opt;
}

////////////////////MI44//////////////////////
//
//Purpose : Get langauge
//
/////////////////////////////////////////////

function get_lang($lng_type = '') {

    $lng = array("en" => "english", "hn" => "hindi", "mh" => "Marathi");

    if ($lng_type) {
        return $lng[$lng_type];
    } else {
        return $lng;
    }
}

////////////////////MI44/////////////////////////
//
//Purpose : patient mng 1 disaply 0 to 10 number
//
/////////////////////////////////////////////////

function get_number($id = '') {

    $select[$id] = "selected='selected'";

    for ($iCounter = 0; $iCounter <= 10; $iCounter++) {
        $opt .= "<option  value='" . $iCounter . "'  " . $select[$iCounter] . ">" . $iCounter . "</option>";
    }
    return $opt;
}

////////////////////MI42/////////////////////////
//
//Purpose : Get pcr current steps.
//
/////////////////////////////////////////////////

function pcr_steps($pcr_id = '', $step = '') {


    $CI = get_instance();

    $CI->load->model('pcr_model');

    $epcr_steps = $CI->pcr_model->get_pcr_details(array('pcr_id' => $pcr_id));

    $step_com = $epcr_steps[0]->pcr_steps;

    if ($step_com != '') {

        $steps = explode(",", $step_com);

        if (!in_array($step, $steps)) {

            $step_com = $step_com . "," . $step;
        }
    } else {

        $step_com = $step;
    }

    ////////////////////////////////////////////////////////////////////////


    $args = array(
        'pcr_id' => $pcr_id,
        'pcr_steps' => $step_com
    );


    $CI->pcr_model->insert_pcr($args);

    ////////////////////////////////////////////////////////////////////////
}

function get_cur_shift() {

    $curtm = date('H');

    if ($curtm >= 0 && $curtm <= 8) {
        $shift = 1;
    } else if ($curtm > 8 && $curtm <= 16) {
        $shift = 2;
    } else if ($curtm > 16 && $curtm < 24) {
        $shift = 3;
    }
    return $shift;
}

function get_all_amb($amb_no = '') {

    $CI = get_instance();

    $CI->load->model('amb_model');

    if ($amb_no != '') {
        $select[$amb_no] = "selected='selected'";
    }
   // $args_amb = array('amb_user_type' => 'tdd');

    $ambu = $CI->amb_model->get_amb_data();




    return $ambu;
}

function is_avaya_active() {
    $CI = get_instance();

    $CI->load->model('options_model');
    $avaya_data = $CI->options_model->get_option('ems_avaya_setting');
    if ($avaya_data == 'Yes') {
        return true;
    } else {
        return false;
    }
}

function get_EMS_title($usr_type = '') {
    $CI = get_instance();
    // $title = array('UG-ADMIN' => 'EMS Admin Panel','UG-ERO-108' => 'ERO-108');
    //$title = array('UG-ADMIN' => 'EMS Admin Panel', 'UG-ERO-108' => 'ERO-108', 'UG-EMT' => 'EMT System', 'UG-SHPM' => 'SHPM System', 'UG-SHAM' => 'SHAM System', 'UG-HEALTH-SUP' => 'Health Supervisor System', 'UG-HEAD-MASTER' => 'Head Master System', 'UG-TRI-MIN' => 'Tribal Minister System', 'Student' => 'Student System', 'UG-PRO-OFF' => 'Project Officer', 'UG-TRI-SEC' => 'Tribal Secretary', 'UG-ASS-PRO-OFF' => 'Assistant Project Officer', 'UG-ASS-TRI-COM' => 'Assistant Tribal Commissioner', 'UG-TRI-COM' => 'Tribal Commissioner', 'UG-DCO' => 'EMT System');

    $CI->load->model('colleagues_model');
    $groups_type = $CI->colleagues_model->get_groups($usr_type);
    $group_name = $groups_type[0]->ugname;

    if ($group_name != '') {
        return $group_name;
    } else {

        return false;
    }
}

function sanitize($string) {
    $string = strtolower(preg_replace('/[^A-Za-z0-9_]+/', '_', trim($string)));
    return trim($string, '_');
}
function generate_maintaince_id($maintaince_id) {
    if($maintaince_id != ''){
    $CI = get_instance();

    $CI->load->model('options_model');
    $ems_inc_ref_id = $CI->options_model->get_option($maintaince_id);

    if (empty($ems_inc_ref_id)) {


        $date = str_replace('-', '', date('Y-m-d'));

        $data = array($date => 1);
        $inc = 1;
        $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);

        $ref_id = json_encode($data, true);

        
        $inc_id_ref = $date . $inc;
        //$inc_id_ref = $inc;
        $data = array($date => $inc_id_ref);
        $ref_id = json_encode($data, true);
        $inc_id = $CI->options_model->add_option($maintaince_id,$ref_id);
    } else {

        $inc_id_data = json_decode($ems_inc_ref_id, true);
        $date = str_replace('-', '', date('Y-m-d'));

        if (array_key_exists($date, $inc_id_data)) {

            $inc = $inc_id_data[$date] + 1;
            $data = array($date => $inc);
            $ref_id = json_encode($data, true);

            //$inc_id = $CI->options_model->add_option('ems_inc_ref_id',$ref_id);

            $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);
            //$inc_id_ref = $date.$inc;
            $inc_id_ref = $inc;
            $data = array($date => $inc_id_ref);
            $ref_id = json_encode($data, true);
            $inc_id = $CI->options_model->add_option($maintaince_id,$ref_id);
        } else {
            $inc = 1;
            $data = array($date => $inc);
            $ref_id = json_encode($data, true);

            //$inc_id = $CI->options_model->add_option('ems_inc_ref_id',$ref_id);

            $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);
            $inc_id_ref = $date . $inc;

            $data = array($date => $inc_id_ref);
            $ref_id = json_encode($data, true);
            $inc_id = $CI->options_model->add_option($maintaince_id,$ref_id);
            // var_dump($inc_id_ref);
            // $inc_id_ref = $inc;
        }
    }

    return $inc_id_ref;
    }
}
function generate_inc_ref_id() {
    
    $CI = get_instance();
    $CI->load->model('options_model');
    $CI->load->model('inc_model');
    
    $date = date('Ymd');
    
    $clg = $CI->session->userdata('current_user');
    $clg_id = $clg->clg_id;
    
    $ems_inc_ref_id = $CI->options_model->get_option('ems_inc_ref_id');
    $inc_id_data = json_decode($ems_inc_ref_id, true);
    if(!isset($inc_id_data[$date])){
        $CI->inc_model->reset_inc_ref_index();
    }
    
    $inc_index = $CI->inc_model->get_inc_ref_index($clg_id);
    $inc_index = str_pad($inc_index, 5, "0", STR_PAD_LEFT);
    $inc_id_ref = $date . $inc_index;
 
    $data = array($date => $inc_id_ref);
    $ref_id = json_encode($data, true);
    $inc_id = $CI->options_model->add_option('ems_inc_ref_id',$ref_id);

    return $inc_id_ref;
    
}
function generate_ptn_id() {
    
    $CI = get_instance();
    $CI->load->model('options_model');
    $CI->load->model('inc_model');
    
    $date = date('Ymd');
    
    $clg = $CI->session->userdata('current_user');
    $clg_id = $clg->clg_id;
    
    $ems_ptn_id = $CI->options_model->get_option('ems_ptn_id');
    $inc_id_data = json_decode($ems_ptn_id, true);
    if(!isset($inc_id_data[$date])){
       // $CI->inc_model->reset_ptn_index();
    }
    
    $inc_index = $CI->inc_model->get_ptn_index($clg_id);
    $inc_id_ref =  $inc_index;
 
    $data = array($date => $inc_id_ref);
    $ref_id = json_encode($data, true);
    $inc_id = $CI->options_model->add_option('ems_ptn_id',$ref_id);

    return $inc_id_ref;
    
}


function generate_bk_inc_ref_id() {
    $CI = get_instance();

    $CI->load->model('options_model');
    $ems_inc_ref_id = $CI->options_model->get_option('ems_bk_inc_ref_id');

    if (empty($ems_inc_ref_id)) {


        $date = str_replace('-', '', date('Y-m-d'));

        $data = array($date => 1);
        $inc = 1;
        $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);

        $ref_id = json_encode($data, true);

        
        $inc_id_ref = $date . $inc;
        //$inc_id_ref = $inc;
        $data = array($date => $inc_id_ref);
        $ref_id = json_encode($data, true);
        $inc_id = $CI->options_model->add_option('ems_bk_inc_ref_id',$ref_id);
    } else {

        $inc_id_data = json_decode($ems_inc_ref_id, true);
        $date = str_replace('-', '', date('Y-m-d'));

        if (array_key_exists($date, $inc_id_data)) {

            $inc = $inc_id_data[$date] + 1;
            $data = array($date => $inc);
            $ref_id = json_encode($data, true);

            //$inc_id = $CI->options_model->add_option('ems_inc_ref_id',$ref_id);

            $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);
            //$inc_id_ref = $date.$inc;
            $inc_id_ref = $inc;
            $data = array($date => $inc_id_ref);
            $ref_id = json_encode($data, true);
            $inc_id = $CI->options_model->add_option('ems_bk_inc_ref_id',$ref_id);
        } else {
            $inc = 1;
            $data = array($date => $inc);
            $ref_id = json_encode($data, true);

            //$inc_id = $CI->options_model->add_option('ems_inc_ref_id',$ref_id);

            $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);
            $inc_id_ref = $date . $inc;

            $data = array($date => $inc_id_ref);
            $ref_id = json_encode($data, true);
            $inc_id = $CI->options_model->add_option('ems_bk_inc_ref_id',$ref_id);
            // var_dump($inc_id_ref);
            // $inc_id_ref = $inc;
        }
    }

    return $inc_id_ref;
}
function update_inc_ref_id($inc) {

    $CI = get_instance();
    $date = str_replace('-', '', date('Y-m-d'));
    $CI->load->model('options_model');
    $data = array($date => $inc);
    $ref_id = json_encode($data, true);
    // var_dump($ref_id);
    // die();
    //$inc_id = $CI->options_model->add_option('ems_inc_ref_id', $ref_id);
}

function generate_102_inc_ref_id() {
    $CI = get_instance();

    $CI->load->model('options_model');
    $ems_inc_ref_id = $CI->options_model->get_option('ems_inc_102_ref_id');

    if (empty($ems_inc_ref_id)) {


        $date = str_replace('-', '', date('Y-m-d'));

        $data = array($date => 1);
        $inc = 1;
        $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);

        $ref_id = json_encode($data, true);

        //$inc_id = $CI->options_model->add_option('ems_inc_ref_id',$ref_id);
        $inc_id_ref = $date . $inc;
        //$inc_id_ref = $inc;
    } else {

        $inc_id_data = json_decode($ems_inc_ref_id, true);
        $date = str_replace('-', '', date('Y-m-d'));

        if (array_key_exists($date, $inc_id_data)) {

            $inc = $inc_id_data[$date] + 1;
            $data = array($date => $inc);
            $ref_id = json_encode($data, true);

            //$inc_id = $CI->options_model->add_option('ems_inc_ref_id',$ref_id);

            $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);
            //$inc_id_ref = $date.$inc;
            $inc_id_ref = $inc;
        } else {
            $inc = 1;
            $data = array($date => $inc);
            $ref_id = json_encode($data, true);

            //$inc_id = $CI->options_model->add_option('ems_inc_ref_id',$ref_id);

            $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);
            $inc_id_ref = $date . $inc;
            // var_dump($inc_id_ref);
            // $inc_id_ref = $inc;
        }
    }

    return $inc_id_ref;
}

function update_102_inc_ref_id($inc) {

    $CI = get_instance();
    $date = str_replace('-', '', date('Y-m-d'));
    $CI->load->model('options_model');
    $data = array($date => $inc);
    $ref_id = json_encode($data, true);
    // var_dump($ref_id);
    // die();
    $inc_id = $CI->options_model->add_option('ems_inc_102_ref_id', $ref_id);
}

function generate_police_inc_ref_id() {
    $CI = get_instance();

    $CI->load->model('options_model');
    $ems_police_inc_ref_id = $CI->options_model->get_option('ems_police_inc_ref_id');

    if (empty($ems_police_inc_ref_id)) {

        $date = str_replace('-', '', date('Y-m-d'));

        $data = array($date => 1);
        $inc = 1;
        $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);

        $ref_id = json_encode($data, true);


        $inc_id_ref = $date . $inc;
    } else {

        $inc_id_data = json_decode($ems_police_inc_ref_id, true);
        $date = str_replace('-', '', date('Y-m-d'));

        if (array_key_exists($date, $inc_id_data)) {

            $inc = $inc_id_data[$date] + 1;
            $data = array($date => $inc);
            $ref_id = json_encode($data, true);

            $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);

            $inc_id_ref = $inc;
        } else {
            $inc = 1;
            $data = array($date => $inc);
            $ref_id = json_encode($data, true);

            $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);
            $inc_id_ref = $date . $inc;
        }
    }

    return $inc_id_ref;
}

function generate_fire_inc_ref_id() {
    $CI = get_instance();

    $CI->load->model('options_model');
    $ems_fire_inc_ref_id = $CI->options_model->get_option('ems_fire_inc_ref_id');

    if (empty($ems_fire_inc_ref_id)) {

        $date = str_replace('-', '', date('Y-m-d'));

        $data = array($date => 1);
        $inc = 1;
        $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);

        $ref_id = json_encode($data, true);


        $inc_id_ref = $date . $inc;
    } else {

        $inc_id_data = json_decode($ems_fire_inc_ref_id, true);
        $date = str_replace('-', '', date('Y-m-d'));

        if (array_key_exists($date, $inc_id_data)) {

            $inc = $inc_id_data[$date] + 1;
            $data = array($date => $inc);
            $ref_id = json_encode($data, true);

            $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);

            $inc_id_ref = $inc;
        } else {
            $inc = 1;
            $data = array($date => $inc);
            $ref_id = json_encode($data, true);

            $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);
            $inc_id_ref = $date . $inc;
        }
    }

    return $inc_id_ref;
}

function generate_grievance_inc_ref_id() {
    $CI = get_instance();

    $CI->load->model('options_model');
    $ems_grievance_inc_ref_id = $CI->options_model->get_option('ems_grievance_inc_ref_id');

    if (empty($ems_grievance_inc_ref_id)) {

        $date = str_replace('-', '', date('Y-m-d'));

        $data = array($date => 1);
        $inc = 1;
        $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);

        $ref_id = json_encode($data, true);


        $inc_id_ref = $date . $inc;
    } else {

        $inc_id_data = json_decode($ems_grievance_inc_ref_id, true);
        $date = str_replace('-', '', date('Y-m-d'));

        if (array_key_exists($date, $inc_id_data)) {

            $inc = $inc_id_data[$date] + 1;
            $data = array($date => $inc);
            $ref_id = json_encode($data, true);

            $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);

            $inc_id_ref = $inc;
        } else {
            $inc = 1;
            $data = array($date => $inc);
            $ref_id = json_encode($data, true);

            $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);
            $inc_id_ref = $date . $inc;
        }
    }

    return $inc_id_ref;
}

function update_police_inc_ref_id($inc) {

    $CI = get_instance();
    $date = str_replace('-', '', date('Y-m-d'));
    $CI->load->model('options_model');
    $data = array($date => $inc);
    $ref_id = json_encode($data, true);

    $inc_id = $CI->options_model->add_option('ems_police_inc_ref_id', $ref_id);
}

function update_grievance_inc_ref_id($inc) {

    $CI = get_instance();
    $date = str_replace('-', '', date('Y-m-d'));
    $CI->load->model('options_model');
    $data = array($date => $inc);
    $ref_id = json_encode($data, true);

    $inc_id = $CI->options_model->add_option('ems_grievance_inc_ref_id', $ref_id);
}

function update_fire_inc_ref_id($inc) {

    $CI = get_instance();
    $date = str_replace('-', '', date('Y-m-d'));
    $CI->load->model('options_model');
    $data = array($date => $inc);
    $ref_id = json_encode($data, true);

    $inc_id = $CI->options_model->add_option('ems_fire_inc_ref_id', $ref_id);
}

function generate_shiftmanager_inc_ref_id() {
    $CI = get_instance();

    $CI->load->model('options_model');
    $ems_shiftmanager_inc_ref_id = $CI->options_model->get_option('ems_shiftmanager_inc_ref_id');

    if (empty($ems_shiftmanager_inc_ref_id)) {

        $date = str_replace('-', '', date('Y-m-d'));

        $data = array($date => 1);
        $inc = 1;
        $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);

        $ref_id = json_encode($data, true);


        $inc_id_ref = $date . $inc;
    } else {

        $inc_id_data = json_decode($ems_shiftmanager_inc_ref_id, true);
        $date = str_replace('-', '', date('Y-m-d'));

        if (array_key_exists($date, $inc_id_data)) {

            $inc = $inc_id_data[$date] + 1;
            $data = array($date => $inc);
            $ref_id = json_encode($data, true);

            $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);

            $inc_id_ref = $inc;
        } else {
            $inc = 1;
            $data = array($date => $inc);
            $ref_id = json_encode($data, true);

            $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);
            $inc_id_ref = $date . $inc;
        }
    }

    return $inc_id_ref;
}

function update_shiftmanager_inc_ref_id($inc) {

    $CI = get_instance();
    $date = str_replace('-', '', date('Y-m-d'));
    $CI->load->model('options_model');
    $data = array($date => $inc);
    $ref_id = json_encode($data, true);

    $inc_id = $CI->options_model->add_option('ems_shiftmanager_inc_ref_id', $ref_id);
}
function generate_situational_inc_ref_id(){
    $CI = get_instance();

    $CI->load->model('options_model');
    $ems_erosupervisor_inc_ref_id = $CI->options_model->get_option('ems_situational_inc_ref_id');

    if (empty($ems_erosupervisor_inc_ref_id)) {

        $date = str_replace('-', '', date('Y-m-d'));

        $data = array($date => 1);
        $inc = 1;
        $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);

        $ref_id = json_encode($data, true);


        $inc_id_ref = $date . $inc;
    } else {

        $inc_id_data = json_decode($ems_erosupervisor_inc_ref_id, true);
        $date = str_replace('-', '', date('Y-m-d'));

        if (array_key_exists($date, $inc_id_data)) {

            $inc = $inc_id_data[$date] + 1;
            $data = array($date => $inc);
            $ref_id = json_encode($data, true);

            $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);

            $inc_id_ref = $inc;
        } else {
            $inc = 1;
            $data = array($date => $inc);
            $ref_id = json_encode($data, true);

            $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);
            $inc_id_ref = $date . $inc;
        }
    }

    return $inc_id_ref;
}
function generate_erosupervisor_inc_ref_id() {
    $CI = get_instance();

    $CI->load->model('options_model');
    $ems_erosupervisor_inc_ref_id = $CI->options_model->get_option('ems_erosupervisor_inc_ref_id');

    if (empty($ems_erosupervisor_inc_ref_id)) {

        $date = str_replace('-', '', date('Y-m-d'));

        $data = array($date => 1);
        $inc = 1;
        $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);

        $ref_id = json_encode($data, true);


        $inc_id_ref = $date . $inc;
    } else {

        $inc_id_data = json_decode($ems_erosupervisor_inc_ref_id, true);
        $date = str_replace('-', '', date('Y-m-d'));

        if (array_key_exists($date, $inc_id_data)) {

            $inc = $inc_id_data[$date] + 1;
            $data = array($date => $inc);
            $ref_id = json_encode($data, true);

            $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);

            $inc_id_ref = $inc;
        } else {
            $inc = 1;
            $data = array($date => $inc);
            $ref_id = json_encode($data, true);

            $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);
            $inc_id_ref = $date . $inc;
        }
    }

    return $inc_id_ref;
}
function update_situational_inc_ref_id($inc) {

    $CI = get_instance();
    $date = str_replace('-', '', date('Y-m-d'));
    $CI->load->model('options_model');
    $data = array($date => $inc);
    $ref_id = json_encode($data, true);

    $inc_id = $CI->options_model->add_option('ems_situational_inc_ref_id', $ref_id);
}
function update_erosupervisor_inc_ref_id($inc) {

    $CI = get_instance();
    $date = str_replace('-', '', date('Y-m-d'));
    $CI->load->model('options_model');
    $data = array($date => $inc);
    $ref_id = json_encode($data, true);

    $inc_id = $CI->options_model->add_option('ems_erosupervisor_inc_ref_id', $ref_id);
}
function _is_in_dispatch_process($call_id) {
    $CI = get_instance();
    $CI->load->model('options_model');

    $check_call_in_process = $CI->options_model->get_option('calls_in_dispatch_process');
    $in_process_data = json_decode($check_call_in_process, true);
    if ($in_process_data) {
        if (array_key_exists($call_id, $in_process_data)) {
            return true;
        } else {
            return false;
        }
    }
}

function _expire_in_dispatch_process() {
    $CI = get_instance();
    $CI->load->model('options_model');

    $in_process_data = $CI->options_model->get_option('calls_in_dispatch_process');

    if ($in_process_data != '') {
        $in_process_data = json_decode($in_process_data, true);
        foreach ($in_process_data as $key => $in_process) {

            $curent_time = now();
            $time_diff = $curent_time - $in_process;
            $comp_time = 3 * 60;
            if ($time_diff >= $comp_time) {
                unset($in_process_data[$key]);
            }
        }

        $in_process_data = json_encode($in_process_data, true);
        $CI->options_model->add_option('calls_in_dispatch_process', $in_process_data);
    }
}

function _add_in_dispatch_process($call_id) {
    $CI = get_instance();
    $CI->load->model('options_model');

    $in_process_data = $CI->options_model->get_option('calls_in_dispatch_process');
    if ($in_process_data != '') {
        $in_process_data = json_decode($in_process_data, true);
        $in_process_data[$call_id] = now();
    } else {
        $in_process_data[$call_id] = now();
    }
    $in_process_data = json_encode($in_process_data, true);
    $CI->options_model->add_option('calls_in_dispatch_process', $in_process_data);
}

function _remove_in_dispatch_process($call_id) {
    $CI = get_instance();
    $CI->load->model('options_model');

    $in_process_data = $CI->options_model->get_option('calls_in_dispatch_process');
    if ($in_process_data != '') {
        $in_process_data = json_decode($in_process_data, true);
        unset($in_process_data[$call_id]);
        //$in_process_data[$call_id] = now();
    }
    $in_process_data = json_encode($in_process_data, true);
    $CI->options_model->add_option('calls_in_dispatch_process', $in_process_data);
}

/* " End Check call in dispatch proccess" */

/* uniform call distribution */

function _ucd_assign_call($inc_id) {

    $CI = get_instance();
    $CI->load->model('call_model');


    $in_process_data = $CI->call_model->get_ero_108_free_user_exists();
   
    if (!empty($in_process_data)) {

        $user_ref_id = $in_process_data[0]->user_ref_id;
        $user_id = get_clg_data_by_ref_id($user_ref_id);

        $trans_avaya_id = $user_id[0]->clg_avaya_agentid;
        $user_avaya_id = $CI->clg->clg_avaya_agentid;
        $user_ext_id = get_cookie("avaya_extension_no");
        

        $trans_avaya_id = $user_id[0]->clg_avaya_agentid;
               
        $avaya_server_url = 'http://192.168.10.204:90/TeleWebAPI.svc/TransferCall';

        $unique_id = time();
        $avaya_args = array('ActionID'=>$unique_id,
                            'AgentID'=>$user_avaya_id,
                            'AgentExtension'=>$user_ext_id,
                            'Destination' =>$trans_avaya_id );

        $avaya_data = json_encode($avaya_args);
        $avaya_resp =  cct_agent_tranfercall($avaya_server_url,$avaya_data);
        file_put_contents('./logs/transfer/avaya_call_transfer_status_'.date("Y-m-d").'.log', $avaya_data."\r\n", FILE_APPEND);
    } else {
        $user_ref_id = 0;
    }

    $call_args = array(
        'user_ref_id' => $user_ref_id,
        'inc_ref_id' => $inc_id,
        'call_status' => 'assign',
        'datetime' => time());
    //$call_res = $CI->call_model->assign_call_to_user($call_args);



    $update_call_args = array(
        'call_status' => 'assign',
        'datetime' => microtime(true));
    $update_call_res = $CI->call_model->update_free_ero_user($update_call_args, $user_ref_id);
}

function _ucd_atnd_call($inc_id, $user_ref_id, $id = '') {

    $CI = get_instance();
    $CI->load->model('call_model');

    $call_res = $CI->call_model->update_call_status($id, 'atnd');
    $update_call_args = array(
        'call_status' => 'atnd',
        'datetime' => microtime(true));

    $update_call_res = $CI->call_model->update_free_ero_user($update_call_args, $user_ref_id, $id);
}

function _ucd_dispatch_call($inc_id, $user_ref_id, $id) {

    $CI = get_instance();
    $CI->load->model('call_model');



    $call_res = $CI->call_model->update_call_status($id, 'completed');

    $update_call_args = array(
        'call_status' => 'free',
        'datetime' => microtime(true));
    $update_call_res = $CI->call_model->update_free_ero_user($update_call_args, $user_ref_id);
}

function _ucd_terminate_call($inc_id, $user_ref_id, $id) {

    $CI = get_instance();
    $CI->load->model('call_model');


    $call_res = $CI->call_model->update_call_status($id, 'terminate');

    $update_call_args = array(
        'call_status' => 'free',
        'datetime' => microtime(true));
    $update_call_res = $CI->call_model->update_free_ero_user($update_call_args, $user_ref_id);
}

/* uniform call distribution to 102 user*/

function _ucd_102_assign_call($inc_id,$user_group) {

    $CI = get_instance();
    $CI->load->model('call_model');
    if($user_group == 'UG-ERO'){
        $user_group = 'UG-ERO-102';
    }


    //$in_process_data = $CI->call_model->get_free_ero_user_by_status($user_group);
    $in_process_data = $CI->call_model->get_ero_102_free_user_exists();
    $avaya_server_url = 'http://192.168.10.204:90/TeleWebAPI.svc/TransferCall';
 
    
    if (!empty($in_process_data)) {
        
        $user_ref_id = $in_process_data[0]->user_ref_id;
        $CI->clg = $CI->session->userdata('current_user');

        $user_id = get_clg_data_by_ref_id($user_ref_id);
        $trans_avaya_id = $user_id[0]->clg_avaya_agentid;
         $user_avaya_id = $CI->clg->clg_avaya_agentid;
        $user_ext_id = get_cookie("avaya_extension_no");
        

        $unique_id = time();
        $avaya_args = array('ActionID'=>$unique_id,
                            'AgentID'=>$user_avaya_id,
                            'AgentExtension'=>$user_ext_id,
                            'Destination' =>$trans_avaya_id );
        
 
        $avaya_data = json_encode($avaya_args);
        file_put_contents('./logs/transfer/avaya_call_transfer_102_status_'.date("Y-m-d").'.log', $avaya_data."\r\n", FILE_APPEND);
        $avaya_resp =  cct_agent_tranfercall($avaya_server_url,$avaya_data);

         file_put_contents('./logs/transfer/avaya_call_transfer_102_status_responce_'.date("Y-m-d").'.log', $avaya_resp."\r\n", FILE_APPEND);
    } else {
        $user_ref_id = 0;
    }

    $call_args = array(
        'user_ref_id' => $user_ref_id,
        'inc_ref_id' => $inc_id,
        'call_status' => 'assign',
        'datetime' => time());
   // $call_res = $CI->call_model->assign_call_to_user($call_args);



    $update_call_args = array(
        'call_status' => 'assign',
        'datetime' => microtime(true));
    $update_call_res = $CI->call_model->update_free_ero_user($update_call_args, $user_ref_id);
}



function _ucd_hd_assign_call($inc_id,$user_group) {

    $CI = get_instance();
    $CI->load->model('call_model');
    
    
    if($user_group == 'UG-ERO' || $user_group = 'UG-ERO-102'){
        $user_group = 'UG-ERO-HD';       
    }


    //$in_process_data = $CI->call_model->get_free_ero_user_by_status($user_group);
    $in_process_data = $CI->call_model->get_ero_hd_free_user_exists();
    $avaya_server_url = 'http://192.168.10.204:90/TeleWebAPI.svc/TransferCall';
 
    
    if (!empty($in_process_data)) {
        
        $user_ref_id = $in_process_data[0]->user_ref_id;
        $CI->clg = $CI->session->userdata('current_user');

        $user_id = get_clg_data_by_ref_id($user_ref_id);
        $trans_avaya_id = $user_id[0]->clg_avaya_agentid;
        $user_avaya_id = $CI->clg->clg_avaya_agentid;
        $user_ext_id = get_cookie("avaya_extension_no");
        

        $unique_id = time();
        $avaya_args = array('ActionID'=>$unique_id,
                            'AgentID'=>$user_avaya_id,
                            'AgentExtension'=>$user_ext_id,
                            'Destination' =>$trans_avaya_id );
        
 
        $avaya_data = json_encode($avaya_args);
        file_put_contents('./logs/transfer/avaya_call_transfer_hd_status_'.date("Y-m-d").'.log', $avaya_data."\r\n", FILE_APPEND);
        $avaya_resp =  cct_agent_tranfercall($avaya_server_url,$avaya_data);
        
       // $avaya_resp = json_encode($avaya_resp);

        //file_put_contents('./logs/transfer/avaya_call_transfer_hd_status_responce_'.date("Y-m-d").'.log', $avaya_resp."\r\n", FILE_APPEND);
         
    } else {
        $user_ref_id = 0;
    }

    $call_args = array(
        'user_ref_id' => $user_ref_id,
        'inc_ref_id' => $inc_id,
        'call_status' => 'assign',
        'datetime' => time());
   // $call_res = $CI->call_model->assign_call_to_user($call_args);



    $update_call_args = array(
        'call_status' => 'assign',
        'datetime' => microtime(true));
    $update_call_res = $CI->call_model->update_free_ero_user($update_call_args, $user_ref_id);
}

function ero_free_user_call($user_ref_id) {

    $CI = get_instance();
    $CI->load->model('call_model');
    $update_call_args = array(
        'status' => 'free',
        'brk_time'=>date('Y-m-d H:i:s')
    );
    $update_call_res = $CI->call_model->update_ero_user_status($update_call_args, $user_ref_id);
}

// Ponam
function get_school_type($school_id = '') {

    $CI = get_instance();

    $CI->load->model('school_model');

    if ($school_id) {
        $select[$school_id] = "selected='selected'";
    }

    $school_type = $CI->school_model->get_school_type();


    if (!empty($school_type)) {

        foreach ($school_type as $opt) {

            $options .= "<option value='" . $opt->school_id . "' " . $select[$opt->school_name] . " >" . $opt->school_name . "</option>";
        }
    }

    return $options;
}

///////////////Ponam////////////////////////
//
//Purpose : To get cluster
//
/////////////////////////////////////////////

function get_cluster($cluster_id = '', $po_id = '') {

    if ($po_id != '') {
        $args = array('po_id' => $po_id);
    }

    $CI = get_instance();

    $CI->load->model('schedule_model');

//    if ($cluster_id) {
//        $select[$cluster_id] = "selected='selected'";
//    }

    $cluster_name = $CI->schedule_model->get_cluster($args);


    if (!empty($cluster_name)) {

        foreach ($cluster_name as $opt) {

            $options .= "<option value='" . $opt->cluster_id . "' " . $select[$opt->cluster_name] . " >" . $opt->cluster_name . "</option>";
        }
    }

    return $options;
}

function get_po($po_id = '', $atc_id = '') {

    if ($po_id != '') {
        $args = array('po_id' => $po_id);
    }

    $CI = get_instance();

    $CI->load->model('schedule_model');

//    if ($cluster_id) {
//        $select[$cluster_id] = "selected='selected'";
//    }

    $cluster_name = $CI->schedule_model->get_cluster($args);


    if (!empty($cluster_name)) {

        foreach ($cluster_name as $opt) {

            $options .= "<option value='" . $opt->cluster_id . "' " . $select[$opt->cluster_name] . " >" . $opt->cluster_name . "</option>";
        }
    }

    return $options;
}

function screening_steps($student_id = '', $schedule_id, $step = '') {

    $CI = get_instance();

    $CI->load->model('emt_model');

    $screening_steps = $CI->emt_model->get_sreening_steps(array('student_id' => $student_id, 'schedule_id' => $schedule_id));

    $step_com = $screening_steps[0]->screening_steps;

    if ($step_com != '') {

        $steps = explode(",", $step_com);

        if (!in_array($step, $steps)) {

            $step_com = $step_com . "," . $step;
        }
    } else {

        $step_com = $step;
    }

    ////////////////////////////////////////////////////////////////////////


    $args = array(
        'student_id' => $student_id,
        'schedule_id' => $schedule_id,
        'screening_steps' => $step_com
    );


    $CI->emt_model->insert_screening_steps($args);

    ////////////////////////////////////////////////////////////////////////
}

function get_amb_status_list($ambs_id = '') {

    $CI = get_instance();
    $CI->load->model('amb_model');

    if ($ambs_id) {
        $select[$ambs_id] = "selected='selected'";
    }

    if ($ambs_id == 'In maintenance-OFF Road') {
        $args['ambs_id'] = array('8');
    } else if ($ambs_id == 'EMSO Not Available') {
        $args['ambs_id'] = array('1');
    } else {
        $args['ambs_id_not'] = '8';
    }


    $amb_status = $CI->amb_model->get_amb_status_list($args);

    if (!empty($amb_status)) {

        foreach ($amb_status as $opt) {

            $options .= "<option value='" . $opt->ambs_id . "' " . $select[$opt->ambs_name] . " >" . $opt->ambs_name . "</option>";
        }
    }

    return $options;
}

function get_clg_data($clg_group, $clg_id = '') {

    $CI = get_instance();

    $CI->load->model('colleagues_model');


    if ($clg_id) {
        $select[$clg_id] = "selected='selected'";
    }

    $args['clg_group'] = $clg_group;

    $clg_list = $CI->colleagues_model->get_school_clg_data($args, $clg_id);



    if (!empty($clg_list)) {

        foreach ($clg_list as $opt) {

            $options .= "<option value='" . $opt->clg_ref_id . "' " . $select[$opt->clg_ref_id] . " >" . $opt->clg_first_name . ' ' . $opt->clg_last_name . "</option>";
        }
    }

    return $options;
}

function get_auto_po($args = array()) {

    $atc_id = $atc_id = '';

    $CI = get_instance();

    $CI->load->model('dashboard_model');



    $po = $CI->dashboard_model->get_auto_po_by_atc_id(array('po_name' => $args['po_name'], 'atc_id' => $args['atc_id']));

    $po_id = "";
    if ($po['po_id'] != '') {

        $po_id = $po[0]->po_id;

        $dst_name = $po[0]->po_name;
    }
    //var_dump($args['atc_id']);die();
    // $args['atc_id'] = 2;
    $opt = '<input name="cluster[po]" value="' . $po_id . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_auto_po_by_atc/' . $args['atc_id'] . '" placeholder="District" data-errors="{filter_required:\'Please select PO from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" ' . $args['disabled'] . '>';
    return $opt;
}

function get_cluster_by_atc($atc_id) {

    $CI = get_instance();

    $CI->load->model('cluster_model');


    $atc_args = array('atc' => $atc_id);

    $cluster_data = $CI->cluster_model->get_cluster_data($atc_args);


    foreach ($cluster_data as $cluster) {

        if (!in_array($cluster->cluster_id, (array) $cluster_atc[$cluster->atc])) {
            $cluster_atc[$cluster->atc][] = $cluster->cluster_id;
        }
    }
    //var_dump($cluster_atc);
    return $cluster_atc;
}

function mi_uniqid($len = 5) {

    if (function_exists("random_bytes")) {
        $bytes = random_bytes(ceil($len / 2));
    } elseif (function_exists("openssl_random_pseudo_bytes")) {
        $bytes = openssl_random_pseudo_bytes(ceil($len / 2));
    } else {
        return "s" . substr(str_shuffle("0123456789abcdefghiMHlmnopqrstuvwxyz"), 0, $len);
    }
    return "s" . substr(bin2hex($bytes), 0, $len);
}

function get_uniqid($user_default_key = "") {

    $CI = get_instance();
    if (trim($user_default_key) == "") {
        $user_default_key = $CI->session->userdata('user_default_key');
    }

    if (trim($user_default_key) == "") {
        $user_default_key = "NEWMAN";
    }

    return $primary_key = $user_default_key . date("Y") . str_pad(date("z"), 3, "0", STR_PAD_LEFT) . time() . mi_uniqid(6);
}

function get_cluster_by_po($po_id) {

    $CI = get_instance();

    $CI->load->model('cluster_model');


    $po_args = array('po' => $po_id);

    $cluster_data = $CI->cluster_model->get_cluster_data($po_args);


    foreach ($cluster_data as $cluster) {

        if (!in_array($cluster->cluster_id, (array) $cluster_atc[$cluster->po])) {
            $cluster_po[$cluster->po][] = $cluster->cluster_id;
        }
    }
    //var_dump($cluster_atc);
    return $cluster_po;
}

function rand_color() {
    $part1 = str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    $part2 = str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    $part3 = str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);

    return '#' . $part1 . $part2 . $part3;
}

function epcr_dco_count($inc_ref_id) {
    $CI = get_instance();

    $CI->load->model('pcr_model');


    $po_args = array('inc_ref_id' => $inc_ref_id);
    $pcr_data = $CI->pcr_model->get_epcr_dco_count_by_inc($po_args);

    return $pcr_data;
}

function epcr_count($inc_ref_id) {
    $CI = get_instance();

    $CI->load->model('pcr_model');


    $po_args = array('inc_ref_id' => $inc_ref_id);
    $pcr_data = $CI->pcr_model->get_epcr_count_by_inc($po_args);

    return $pcr_data;
}
function ptn_count_gender($inc_ref_id,$gender)
{
    $CI = get_instance();

    $CI->load->model('pcr_model');


    $args_pt = array('get_count' => TRUE,
        'inc_ref_id' => $inc_ref_id,
    'gender' => $gender);

    $ptn_count = $CI->pcr_model->get_pat_by_inc($args_pt);

    return $ptn_count;
}

function ptn_count($inc_ref_id) {
    $CI = get_instance();

    $CI->load->model('pcr_model');


    $args_pt = array('get_count' => TRUE,
        'inc_ref_id' => $inc_ref_id);

    $ptn_count = $CI->pcr_model->get_pat_by_inc($args_pt);

    return $ptn_count;
}

function notification_count() {
    $CI = get_instance();

    $CI->load->model('colleagues_model');

    $CI->clg = $CI->session->userdata('current_user');

    $args_pt = array('get_count' => TRUE,
        'nr_user_group' => $CI->clg->clg_group,
        'clg_ref_id' => $CI->clg->clg_ref_id,
        'today' => date('Y-m-d H:i:s'));

    $ptn_count = $CI->colleagues_model->get_clg_notice_cnt($args_pt);

    return $ptn_count;
}

function ero_notification_count() {
    $CI = get_instance();

    $CI->load->model('quality_model');

    $CI->clg = $CI->session->userdata('current_user');

    $args_pt = array('get_count' => TRUE,
        'nr_user_group' => $CI->clg->clg_group,
        'usr_id' => $CI->clg->clg_ref_id,
        'today' => date('Y-m-d')
    );

    $ptn_count = $CI->quality_model->get_ero_notice_cnt($args_pt);

    return $ptn_count;
}

function get_clg_notice() {

    $CI = get_instance();

    $CI->load->model('colleagues_model');

    $CI->clg = $CI->session->userdata('current_user');

    $clg_group = array(
        'nr_user_group' => $CI->clg->clg_group,
        'clg_ref_id' => $CI->clg->clg_ref_id,
    );


    $call_res = $CI->colleagues_model->get_clg_notice($clg_group);

    return $call_res;
}

function get_ero_notice() {

    $CI = get_instance();

    $CI->load->model('quality_model');

    $CI->clg = $CI->session->userdata('current_user');

    $clg_group = array(
        'usr_id' => $CI->clg->clg_ref_id,
    );


    $call_res = $CI->quality_model->get_ero_notice($clg_group);

    return $call_res;
}

function get_cheif_complaint($cheif_id) {

    $CI = get_instance();
    $CI->load->model('inc_model');
    $chief_complete = $CI->inc_model->get_chief_comp_service($cheif_id);

    return $chief_complete[0]->ct_type;
}

function get_mci_nature_service($cheif_id) {

    $CI = get_instance();
    $CI->load->model('inc_model');
    $chief_complete = $CI->inc_model->get_mci_nature_service($cheif_id);
    return $chief_complete[0]->ntr_nature;
}

function get_purpose_of_call($pcode) {

    $CI = get_instance();
    $CI->load->model('common_model');
    $args = array('pcode' => $pcode);
    $chief_complete = $CI->common_model->get_purpose_of_calls($args);
    return $chief_complete[0]->pname;
}

function get_provider_impression($pro_imp_id) {

    $CI = get_instance();
    $CI->load->model('pcr_model');
    $pro_imp = $CI->pcr_model->get_provider_imp_by_id($pro_imp_id);
    return $pro_imp[0]->pro_name;
}
function get_provider_case_type($pro_imp_id) {

    $CI = get_instance();
    $CI->load->model('pcr_model');
    $pro_imp = $CI->pcr_model->get_provider_casetype(array('case_id' => $pro_imp_id));
    return $pro_imp[0]->case_name;
}
function get_loc_level($loc_id) {

    $CI = get_instance();
    $CI->load->model('common_model');
    $args = array('level_id'=>$loc_id);
    $pro_imp = $CI->common_model->get_loc_level($args);
    return $pro_imp[0]->level_type;
}
function get_parent_purpose_of_call($pcode) {

    $CI = get_instance();
    $CI->load->model('common_model');
    $args = array('pcode' => $pcode);
    $chief_complete = $CI->common_model->get_purpose_of_calls($args);
    
    $p_parent = explode(',', $chief_complete[0]->p_parent);

    if(count($p_parent) > 1){
        $args1 = array('pcode' => $p_parent[1]);
    }else{
        $args1 = array('pcode' => $p_parent[0]);
    }

    $chief_complete_parent = $CI->common_model->get_purpose_of_calls($args1);

    
    return $chief_complete_parent[0]->pname;
}
function get_division_district_by_id($dist_code) {

    $CI = get_instance();
    $CI->load->model('inc_model');
    $chief_complete = $CI->inc_model->get_division_district_by_id($dist_code);
    return $chief_complete->div_name;
}

function get_district_by_id($dist_code) {

    $CI = get_instance();
    $CI->load->model('inc_model');
    if($dist_code != ''){
        $chief_complete = $CI->inc_model->get_district_by_id($dist_code);
        return $chief_complete->dst_name;
    }
}
function get_tehsil_by_id($tahsil_id) {

    $CI = get_instance();
    $CI->load->model('inc_model');
    $args = array('thl_id'=>$tahsil_id);
    $chief_complete = $CI->inc_model->get_tahshil($args);
    return $chief_complete[0]->thl_name;
}

function show_amb_status_name($ambs_id) {

    $CI = get_instance();
    $CI->load->model('amb_model');
    $args = array('ambs_id' => $ambs_id);
    $amb_status = $CI->amb_model->get_amb_status_list($args);
    return $amb_status[0]->ambs_name;
}
function show_amb_offroad_reason($amb_id) {

    $CI = get_instance();
    $CI->load->model('ambmain_model');
    $args = array('id' => $amb_id);
    $amb_status = $CI->ambmain_model->get_offroad_reason_list($args);
    return $amb_status[0]->offroad_reason;
}
function show_critical_data_para($eq_id,$ins_id){
    $CI = get_instance();
    $CI->load->model('Inspection_model');
    $args = array('eq_id' => $eq_id,'ins_id'=>$ins_id);
    $status = $CI->inspection_model->get_ins_equip_records_new($args);
    return $status[0]->status;

}
function show_oprational_data_para($eq_id,$ins_id){
    $CI = get_instance();
    $CI->load->model('Inspection_model');
    $args = array('eq_id' => $eq_id,'ins_id'=>$ins_id);
    $oprational = $CI->inspection_model->get_ins_equip_records_new($args);
    return $oprational[0]->oprational;

}
function show_date_data_para($eq_id,$ins_id){
    $CI = get_instance();
    $CI->load->model('Inspection_model');
    $args = array('eq_id' => $eq_id,'ins_id'=>$ins_id);
    $date_from = $CI->inspection_model->get_ins_equip_records_new($args);
    return $date_from[0]->date_from;

}
function show_amb_type_name($ambs_id) {

    $CI = get_instance();
    $CI->load->model('amb_model');
    $args = array('ambt_id' => $ambs_id);
    
    $amb_status = $CI->amb_model->get_amb_type($args);

    return $amb_status[0]->ambt_name;
}
function show_amb_staus($amb_no){
    $CI = get_instance();
    $CI->load->model('amb_model');
    $args = array('amb_no' => $amb_no);
    
    $amb_model = $CI->amb_model->get_amb_status_detail($args);

    return $amb_model[0]->ambs_name;
}
function show_amb_model_name($amb_no) {

    $CI = get_instance();
    $CI->load->model('amb_model');
    $args = array('amb_no' => $amb_no);
    
    $amb_model = $CI->amb_model->get_amb_detail($args);

    return $amb_model[0]->vehical_make;
    
}

function show_area_type_name($ar_id) {

    $CI = get_instance();
    $CI->load->model('amb_model');
    $args = array('ar_id' => $ar_id);
    
    $amb_status = $CI->amb_model->get_area_type($args);

    return $amb_status[0]->ar_name;
}

function get_feedback_complaint($feeback_id) {

    $CI = get_instance();
    $CI->load->model('inc_model');
    $args = array('fdsr_id' => $feeback_id);
   // var_dump($args);die();
    $chief_complete = $CI->call_model->get_feedback_stand_remark($args);

    return $chief_complete[0]->fdsr_type;
}
function get_ero_remark($remark_id) {

    $CI = get_instance();
    $CI->load->model('call_model');
    $args=array('re_id'=>$remark_id);
    $remark = $CI->call_model->get_ero_summary_remark($args);

    return $remark[0]->re_name;
}
function help_complaints_types($remark_id) {

    //  var_dump($remark_id);die();
    $CI = get_instance();
    $CI->load->model('call_model');
    $args=array('cmp_id'=>$remark_id);
    $remark = $CI->call_model->get_help_complaints_name($args);

    return $remark[0]->cmp_name;
}

function help_chief_comp_types($cm_id) {

    //  var_dump($remark_id);die();
    $CI = get_instance();
    $CI->load->model('inc_model');
    $remark = $CI->inc_model->get_chief_comp_service_help($cm_id);

    return $remark[0]->ct_type;
}

function get_eqp_breakdown_standard_remark($remark_id) {

    $CI = get_instance();
    $CI->load->model('pcr_model');
    $args=array('remark_id'=>$remark_id);
    $remark = $CI->pcr_model->get_eqp_standard_remark($args);
    //$remark = $CI->call_model->get_ero_summary_remark($args);

    return $remark[0]->remark;
}
function get_end_odo_remark($remark_id) {

    $CI = get_instance();
    $CI->load->model('pcr_model');
    $args=array('remark_id'=>$remark_id);
    $remark = $CI->pcr_model->get_odometer($args);

    return $remark[0]->remark;
}
function get_responce_time_remark($remark_id) {

    $CI = get_instance();
    $CI->load->model('pcr_model');
    $args=array('id'=>$remark_id);
    $remark = $CI->pcr_model->get_res_time_remark($args);

    return $remark[0]->remark_title;
}
function get_skin_name($remark_id) {

    $CI = get_instance();
    $CI->load->model('pet_model');
    $args=array('ps_id'=>$remark_id);
    $remark = $CI->pet_model->get_pulse_skin($args);

    return $remark[0]->ps_type;
}
function get_pupil_name($remark_id) {

    $CI = get_instance();
    $CI->load->model('common_model');
    $args=array('ps_id'=>$remark_id);
    $remark = $CI->common_model->get_pupils_type($args);

    return $remark[0]->pp_type;
}


function get_unable_to_dispatch_amb($inc_ref_id) {

    $CI = get_instance();
    $CI->load->model('inc_model');
    $unable_to_dispatch = $CI->inc_model->get_unable_to_dispatch_ambulace($inc_ref_id);

    return $unable_to_dispatch;
}
function mi_empty($val) {

    if (isset($val) || !$val || trim($val) != '' || count($val) == 0) {
        return true;
    }
    return false;
}
function get_break_time($args){
     $current_date = date('Y-m-d');
        $current_time = date('Y-m-d');
        $args_break = array('to_date'=>$current_date,
                            'from_date'=>$current_time,
                            'clg_ref_id'=>$ref_id,
                            'break_type'=>$break_type);
        
        $break_summary = $this->shiftmanager_model->get_break_total_time_user($args_break);
        $break_total_time = $break_summary[0]->break_total_time;
    
}
function get_inc_recording($calluniqueid,$inc_datetime='') {

    $CI = get_instance();

//    $CI->load->model('call_model');
//
//    $clg_group = array(
//        'CallUniqueID' => $calluniqueid,
//    );
//    if($inc_datetime != ''){
//     $clg_group['inc_datetime'] = $inc_datetime;
//    }
//
//    $call_res = $CI->call_model->get_avaya_audio($clg_group);
//    return $call_res->call_audio;
     $CI->load->model('inc_model');

    if($calluniqueid != 'direct_atnd_call'){
        $clg_group = array(
            'inc_avaya_uniqueid' => $calluniqueid,
        );

        $call_res = $CI->inc_model->get_incident_audio_by_avayaid($clg_group);
        return $call_res->inc_audio_file;
    }else{
        return false;
    }
}
function get_corona_recording($calluniqueid,$inc_datetime='') {

    $CI = get_instance();

    $CI->load->model('corona_model');

    $clg_group = array(
        'CallUniqueID' => $calluniqueid,
    );
    if($inc_datetime != ''){
     $clg_group['inc_datetime'] = $inc_datetime;
    }

    $call_res = $CI->corona_model->get_avaya_audio($clg_group);
    return $call_res->call_audio;
}

function get_avaya_action($ActionID) {

    $CI = get_instance();

    $CI->load->model('call_model');

    $clg_group = array(
        'ActionID' => $ActionID,
    );

    $call_res = $CI->call_model->get_avaya_action_summary($clg_group);

    
    if($call_res){
       return json_decode($call_res[0]->response,true);
    }else{
        return false;
    }

}
function get_total_by_call_type_closure($inc_added_by,$inc_type="",$dur,$fr,$to,$system){
 //var_dump($system);
 $CI = get_instance();

 $CI->load->model('inc_model');

 $bs_month = $CI->session->userdata('base_month');
if($dur=="to"){
 $args = array(
     'from_date' => date('m/d/Y'),
     'base_month'=>$bs_month["base_month"],
     'to_date' => date('m/d/Y'),
     'inc_added_by' => $inc_added_by,
     'inc_type' => $inc_type,
     'get_count'=>TRUE,
     'inc_system_type'=>$system
     );
 }
 if($dur=="tm"){
     $args = array(
         'from_date' => 'DATE_FORMAT(NOW(),"%m-01-%Y")',
         'base_month'=>$bs_month["base_month"],
         'to_date' => date('m/d/Y'),
         'inc_added_by' => $inc_added_by,
         'inc_type' => $inc_type,
         'get_count'=>TRUE,
         'inc_system_type'=>$inc_system_type
         );
     }
     if($dur=="ft"){
         $args = array(
             'from_date' => $fr,
             'inc_base_month'=>$bs_month["base_month"],
             'to_date' => $to,
             'inc_added_by' => $inc_added_by,
             'inc_type' => $inc_type,
             'get_count'=>TRUE,
             'system'=>$system
             );
         }
 $call_res = $CI->inc_model->get_total_by_call_type_closure($args);
  //var_dump($bas_month);die;
 
 if($call_res){
     //print_r('11');die;
    return $call_res;
 }else{
     //print_r('22');die;
     return false;
 }   
}
function get_total_by_call_type($inc_added_by,$inc_type="",$dur,$fr,$to,$system) {
//var_dump($system);
    $CI = get_instance();

    $CI->load->model('inc_model');

    $bs_month = $CI->session->userdata('base_month');
  if($dur=="to"){
    $args = array(
        'from_date' => date('Y-m-d'),
        'base_month'=>$bs_month["base_month"],
        'to_date' => date('Y-m-d'),
        'inc_added_by' => $inc_added_by,
        'inc_type' => $inc_type,
        'get_count'=>TRUE,
        'inc_system_type'=>$system
        );
    }
    if($dur=="tm"){
        $args = array(
            'from_date' => 'DATE_FORMAT(NOW(),"%Y-%m-01")',
            'base_month'=>$bs_month["base_month"],
            'to_date' => date('Y-m-d'),
            'inc_added_by' => $inc_added_by,
            'inc_type' => $inc_type,
            'get_count'=>TRUE,
            'inc_system_type'=>$inc_system_type
            );
        }
        if($dur=="ft"){
            $args = array(
                'from_date' => $fr,
                'inc_base_month'=>$bs_month["base_month"],
                'to_date' => $to,
                'inc_added_by' => $inc_added_by,
                'inc_type' => $inc_type,
                'get_count'=>TRUE,
                'system'=>$system
                );
            }
    $call_res = $CI->inc_model->get_total_by_call_type($args);
     //var_dump($bas_month);die;
    
    if($call_res){
        //print_r('11');die;
       return $call_res;
    }else{
        //print_r('22');die;
        return false;
    }

}

function get_inc_total_by_call_type($inc_added_by="",$inc_type="") {
//var_dump($fr);die;
    $CI = get_instance();

    $CI->load->model('inc_model');

    $bs_month = $CI->session->userdata('base_month');

    $args = array(
        'from_date' => date('Y-m-d'),
        'base_month'=>$bs_month["base_month"],
        'to_date' => date('Y-m-d'),
        'inc_added_by' => $inc_added_by,
        'inc_type' => $inc_type,
        'get_count'=>TRUE
        );
    $call_res = $CI->inc_model->get_total_by_call_type_inc($args);
    
    if($call_res){
       return $call_res;
    }else{
        return false;
    }

}
function get_inc_total_by_user($inc_added_by = array()) {
//var_dump($fr);die;
    $CI = get_instance();

    $CI->load->model('inc_model');

    $bs_month = $CI->session->userdata('base_month');

    $args = array(
        'from_date' => $inc_added_by['from_date'],
        'base_month'=>$bs_month["base_month"],
        'to_date' => $inc_added_by['to_date'],
        'inc_added_by' => $inc_added_by['inc_added_by'],
        'inc_type'=> $inc_added_by['inc_type'],
        'system'=> $inc_added_by['system'],
        'get_count'=>TRUE
        );
    $call_res = $CI->inc_model->get_total_by_call_type_inc($args);
    
    if($call_res){
       return $call_res;
    }else{
        return false;
    }

}
function get_nonems_total_by_user($inc_added_by = array()) {
//var_dump($fr);die;
    $CI = get_instance();

    $CI->load->model('inc_model');

    $bs_month = $CI->session->userdata('base_month');

    $args = array(
        'from_date' => $inc_added_by['from_date'],
        'base_month'=>$bs_month["base_month"],
        'to_date' => $inc_added_by['to_date'],
        'inc_added_by' => $inc_added_by['inc_added_by'],
        'get_count'=>TRUE
        );
    $call_res = $CI->inc_model->get_total_noneme_calls($args);
    
    if($call_res){
       return $call_res;
    }else{
        return false;
    }

}



function weekOfMonth($date) {
    // estract date parts
    list($y, $m, $d) = explode('-', date('Y-m-d', strtotime($date)));

    // current week, min 1
    $w = 1;

    // for each day since the start of the month
    for ($i = 1; $i <= $d; ++$i) {
        // if that day was a sunday and is not the first day of month
        if ($i > 1 && date('w', strtotime("$y-$m-$i")) == 0) {
            // increment current week
            ++$w;
        }
    }

    // now return
    return $w;
}
 function amb_status_data($status)
{
    $CI = get_instance();

    $CI->load->model('pcr_model');

    $args_pt = array('get_count' => TRUE,
        'status' => $status
        );

    $ptn_count = $CI->pcr_model->get_amb_status_avaibility($args_pt);

    return $ptn_count;
}   
function show_vehical_Login_details($amb){
    $CI = get_instance();

    $CI->load->model('amb_model');

    $args_pt = array(
        'amb_rto_register_no' => $amb
        );

    $ptn_count = $CI->amb_model->get_amb_login_status($args_pt);

    if($ptn_count[0]->status=='1')
    {
        $status='Available';
    }else{
        $status='Not-Available';
    }

    return $status;
}
function get_emso_name($amb_id,$type){
        
    $CI = get_instance();

    $CI->load->model('amb_model');
    $args_pt = array(
        'amb_rto_register_no' => $amb_id,
        'type' => $type
        );

    $ptn_count = $CI->amb_model->get_amb_emso_name($args_pt);
       
    //$clg_name = $ptn_count[0]->clg_first_name.' '.$ptn_count[0]->clg_last_name; 
    

    return $ptn_count;
} 
function send_API_manual($args){
    // return true;
    //var_dump($args);die();
    $CI = get_instance();
    $CI->load->model('dashboard_model');
    //$CI->load->model('Job_closer');
    $LastActivityTime = $args['LastActivityTime'];
    $JobStatus = $args['JobStatus'];
    $onRoadStatus = $args['onRoadStatus'];
    $Caller_Location = $args['Caller_Location'];
    $Hospital_Location = $args['Hospital_Location'];
    $JobNo = $args['JobNo'];
    $HospitalLatlong = $args['HospitalLatlong'];   
    $stateCode = $args['stateCode'];
    $AmbulanceNo = $args['AmbulanceNo'];  
    $CallerLatlong = $args['CallerLatlong'];
    $id = $args['id'];   
    
    $form_url = "http://13.235.213.74:5573";
    $data_to_post = array();
    $data_to_post['LastActivityTime'] = $LastActivityTime;
    $data_to_post['JobStatus'] = $JobStatus;
    $data_to_post['onRoadStatus'] = $onRoadStatus;
    $data_to_post['Caller_Location'] = $Caller_Location;
    $data_to_post['Hospital_Location'] = $Hospital_Location;
    $data_to_post['JobNo'] = $JobNo;
    $data_to_post['HospitalLatlong'] = $HospitalLatlong;
    $data_to_post['stateCode'] = $stateCode;
    $data_to_post['AmbulanceNo'] = $AmbulanceNo;
    $data_to_post['CallerLatlong'] = $CallerLatlong;
   
    $data_to_post1 = json_encode($data_to_post);
   // print_r($data_to_post1);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $form_url);
    curl_setopt($curl, CURLOPT_POST, sizeof($data_to_post));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_to_post1);
    curl_setopt( $curl, CURLOPT_TIMEOUT, 2 );
    curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, 2 );
    $result = curl_exec($curl);
     //   var_dump($result);
    $decodedText = html_entity_decode($result);
    $myArray = json_decode($decodedText, true);
    $output = $myArray['status'];
    $data_to_post['addedDateTime'] = date('Y-m-d H:i:s');
    $data_to_post['message'] = $myArray['message'];
    $data_to_post['apiWholeRes'] = $result;
    $data_to_post['status'] = $myArray['status'];

        $data_update['id'] = $id;
        $data_update['closure_data_pass_to_gps'] = '2';
        
    $res_update = $CI->dashboard_model->update_status_dispatch_gps_data($data_update);
    $res = $CI->dashboard_model->insert_dispatch_gps_data($data_to_post);
    curl_close($curl);
}
function send_API($args){
    // return true;
    //var_dump($args);die();
    $CI = get_instance();
    $CI->load->model('dashboard_model');
    //$CI->load->model('Job_closer');
    $LastActivityTime = $args['LastActivityTime'];
    $JobStatus = $args['JobStatus'];
    $onRoadStatus = $args['onRoadStatus'];
    $Caller_Location = $args['Caller_Location'];
    $Hospital_Location = $args['Hospital_Location'];
    $JobNo = $args['JobNo'];
    $HospitalLatlong = $args['HospitalLatlong'];   
    $stateCode = $args['stateCode'];
    $AmbulanceNo = $args['AmbulanceNo'];  
    $CallerLatlong = $args['CallerLatlong'];   
    
    $form_url = "http://13.235.213.74:5573";
    $data_to_post = array();
    $data_to_post['LastActivityTime'] = $LastActivityTime;
    $data_to_post['JobStatus'] = $JobStatus;
    $data_to_post['onRoadStatus'] = $onRoadStatus;
    $data_to_post['Caller_Location'] = $Caller_Location;
    $data_to_post['Hospital_Location'] = $Hospital_Location;
    $data_to_post['JobNo'] = $JobNo;
    $data_to_post['HospitalLatlong'] = $HospitalLatlong;
    $data_to_post['stateCode'] = $stateCode;
    $data_to_post['AmbulanceNo'] = $AmbulanceNo;
    $data_to_post['CallerLatlong'] = $CallerLatlong;
   
    $data_to_post1 = json_encode($data_to_post);
   // print_r($data_to_post1);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $form_url);
    curl_setopt($curl, CURLOPT_POST, sizeof($data_to_post));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_to_post1);
    curl_setopt( $curl, CURLOPT_TIMEOUT, 2 );
    curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, 2 );
    $result = curl_exec($curl);
     //   var_dump($result);
    $decodedText = html_entity_decode($result);
    $myArray = json_decode($decodedText, true);
    $output = $myArray['status'];
    $data_to_post['addedDateTime'] = date('Y-m-d H:i:s');
    $data_to_post['message'] = $myArray['message'];
    $data_to_post['apiWholeRes'] = $result;
    $data_to_post['status'] = $myArray['status'];

    $res = $CI->dashboard_model->insert_dispatch_gps_data($data_to_post);
    curl_close($curl);
      
}
function send_API_close($args)
{
  //var_dump($args);die();
   // return false;
    $CI = get_instance();
    $CI->load->model('dashboard_model');
    $form_url = "http://13.235.213.74:5577";
    $data_to_post = array();
    $data_to_post['ProjectType'] = $args['ProjectType'];
    $data_to_post['EmType'] = $args['EmType'];
    $data_to_post['CallDateTime'] = $args['CallDateTime'];
    $data_to_post['JobNo'] = $args['JobNo'];
    $data_to_post['AmbulanceNo'] = $args['AmbulanceNo'];
    $data_to_post['DispatchedDateTime'] = $args['DispatchedDateTime'];
    $data_to_post['ReachedtosceneDateTime'] = $args['ReachedtosceneDateTime'];
    $data_to_post['DropHospital'] = $args['DropHospital'];
    $data_to_post['HospitalType'] = $args['HospitalType'];
    $data_to_post['BacktobaseDatetime'] = $args['BacktobaseDatetime'];
    $data_to_post['stateCode'] = $args['stateCode'];
    $data_to_post['ClosingStatus'] = $args['ClosingStatus'];
    $data_to_post['DropDateTime'] = $args['DropDateTime'];
    $data_to_post['EmergencyChiefComplaint'] = $args['EmergencyChiefComplaint'];
    $data_to_post['AyushmanCard'] = $args['AyushmanCard'];
    $data_to_post['Exemption'] = $args['Exemption'];
   // var_dump($data_to_post);die();
    $data_to_post1 = array();
    $data_to_post1['AmbulanceTripStatus'] = array($data_to_post);
    $data_to_post1 = json_encode($data_to_post1);
    //var_dump($data_to_post1);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $form_url);
    curl_setopt($curl, CURLOPT_POST, sizeof($data_to_post));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_to_post1);
    curl_setopt( $curl, CURLOPT_TIMEOUT, 2 );
    curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, 2 );
    $result = curl_exec($curl);
    $decodedText = html_entity_decode($result);
    $myArray = json_decode($decodedText, true);
    $output = $myArray['status'];
    $data_to_post['addedDateTime'] = date('Y-m-d H:i:s');
    $data_to_post['apiRes'] = $output;
    $data_to_post['apiWholeRes'] = $result;
    $data_to_post['remark'] = 'Web';
    $res = $CI->dashboard_model->insert_gps_data($data_to_post);
   // die();
    if(!empty($args['JobNo'])){
    
        if($output == "SUCCESS"){
            $res = $CI->dashboard_model->update_inc_pcr_status($args['JobNo']);
        }else{
            $res = $CI->dashboard_model->update_inc_pcr_status_fail($args['JobNo']);
        }
    }
    //array_push($gpspass,$data_to_post);
    curl_close($curl);
}
function get_consumable_name($args){
    $CI = get_instance();

    $CI->load->model('inv_model');
    //$CI->load->model('ind_model');
    $args_ca = array(
        'inv_type' => $args['inv_type'],
        'as_item_id' => $args['as_item_id']
    );
   // var_dump($args_ca);die();
    if($args['inv_type'] == 'MED'){
        $inv_stock = $CI->inv_model->get_medicine_name($args_ca);
    }else if($args['inv_type'] == 'CA'){
        $inv_stock = $CI->inv_model->get_consumable_name1($args_ca);
    }else if($args['inv_type'] == 'NCA'){
        $inv_stock = $CI->inv_model->get_non_consumable_name($args_ca);
    }
    if($inv_stock){
        return $inv_stock;
    }else{
        return false;
    }

}
function get_inv_stock_by_id($args){
    
    $CI = get_instance();

    $CI->load->model('inv_model');
    $CI->load->model('ind_model');


    $args_ca = array(
        'inv_type' => $args['inv_type'],
        'inv_id'=>$args["inv_id"],
        'inv_amb'=>$args['inv_amb']
    );
    if($args['from_date'] != ''){
        $args_ca['from_date'] = $args['from_date'];
    }
    if($args['to_date'] != ''){
        $args_ca['to_date'] = $args['to_date'];
    }
    if($args['inv_to_date'] != ''){
        $args_ca['inv_to_date'] = $args['inv_to_date'];
    }

    if($args['inv_type'] == 'MED'){
  
    $inv_stock = $CI->inv_model->get_med_details_stock($args_ca);
      
    }else if($args['inv_type'] == 'EQP'){
      
    $inv_stock = $CI->ind_model->get_eqp_data_stock($args_ca);
    }else{
     $inv_stock = $CI->inv_model->get_inv_details_stock($args_ca);
    }
    if($inv_stock){
       return $inv_stock;
    }else{
        return false;
    }
}
function get_inv_name_by_id($args){
    
    $CI = get_instance();

    $CI->load->model(array('inv_model','ind_model','pcr_model','med_model'));


    $args_ca = array(
        'inv_type' => $args['inv_type'],
        'inv_id'=>$args["inv_id"],
        'inv_amb'=>$args['inv_amb']
    );

    if($args['inv_type'] == 'MED'){
        $inv_stock = $CI->med_model->get_med_list($args_ca);
        $inv_title = $inv_stock[0]->med_title;
    }else if($args['inv_type'] == 'EQP'){
        $inv_stock = $CI->ind_model->get_eqp_data_stock($args_ca);
        $inv_title = $inv_stock[0]->eqp_name;
    }else if($args['inv_type'] == 'INJ'){
        $inv_stock = $CI->pcr_model->get_injury($args_ca);
        $inv_title = $inv_stock[0]->inj_name;
    }else if($args['inv_type'] == 'INT'){
        $inv_stock = $CI->med_model->get_intervention_list($args_ca);
        $inv_title = $inv_stock[0]->int_name;
    }else{
        $inv_stock = $CI->inv_model->get_inv_list($args_ca);
        $inv_title = $inv_stock[0]->inv_title;
    }
    if($inv_stock){
       return $inv_title;
    }else{
        return false;
    }
}
function get_maintance_part_stock_by_id($args){
    
    $CI = get_instance();

    $CI->load->model('maintenance_part_model');


    $args_ca = array(
        'inv_type' => $args['inv_type'],
        'inv_id'=>$args["inv_id"],
        'inv_amb'=>$args["inv_amb"],
        'inv_district_id'=>$args['inv_district_id']
    );
    if($args['from_date'] != ''){
        $args_ca['from_date'] = $args['from_date'];
    }
    if($args['to_date'] != ''){
        $args_ca['to_date'] = $args['to_date'];
    }
    if($args['inv_to_date'] != ''){
        $args_ca['inv_to_date'] = $args['inv_to_date'];
    }

    
     $inv_stock = $CI->maintenance_part_model->get_maintenance_part_details_stock($args_ca);
    
    if($inv_stock){
       return $inv_stock;
    }else{
        return false;
    }
}
function sms_send($args){
    //return;
     $CI = get_instance();
     $CI->load->model('inc_model');
    //var_dump($args);die();
        $datetime = date('Y-m-d H:i:s');
        $inc_id = $args['inc_id'];
        $text_msg = urlencode($args['msg']);
        $mobile_no=$args['mob_no'];
       $mobile_no=8551995260;
       // $mobile_no=9960998794;
        //$mobile_no=9975063761;
        //$mobile_no=9730015484;
        $sms_user=$args['sms_user'];
       $sms_template_id = array('feedback_patient'=>'1707166269929875787','pvt_patient_msg'=>'1707166814764957971','patient'=>'1707166295923956871','Pilot'=>'1707166296900560759','EMT'=>'1707166296900560759','W3W_patient'=>'1707165812261265730','EMT_PVT_HOS_DM'=>'1707166209545118622','EMT_PVT_HOS_PILOT'=>'1707166209545118622');
        $tmp_id = $sms_template_id[$sms_user];
        $form_url = "http://hindit.biz/api/pushsms?user=jaes&authkey=92zRsmUQr4uUs&sender=JAESPL&mobile=$mobile_no&text=$text_msg&entityid=1701164198802150041&templateid=$tmp_id&rpt=1&summary=1&output=json";
        
        $data_to_post = array();
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $form_url);
        curl_setopt($curl, CURLOPT_POST, sizeof($data_to_post));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_to_post);
        curl_setopt( $curl, CURLOPT_TIMEOUT, 2 );
        curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, 2 );
        $result = curl_exec($curl);
       ///var_dump($result);die();
       curl_close($curl);
       //$asSMSReponse = explode("-", $result);
  
       
       $res_sms = array('inc_ref_id' => $inc_id,
           'sms_usertype' => $sms_user,
           'sms_res' => $result,
           'sms_res_text' => $text_msg,
           'mobile_no' => $mobile_no,
           'sms_datetime' => $datetime);
        $call_res = $CI->inc_model->insert_sms_response($res_sms);
        return $result;
}
function get_wrd_district($args = array()){
    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('common_model');



    $district = $CI->common_model->get_district(array('dst_code' => $args['dst_code'], 'st_id' => $args['st_code']));



    if (!empty($district) && $args['dst_code'] != '') {

        $dist_code = $district[0]->dst_code;

        $dst_name = $district[0]->dst_name;
    }

    $opt = '<input id="wrd_district" name="' . $args['rel'] . '_district" value="' . $dist_code . '" class="mi_autocomplete width97 filter_required" data-href="' . base_url() . 'auto/get_district/' . $args['st_code'] . '" placeholder="District" data-errors="{filter_required:\'Please select district from dropdown list\'}" data-base=""  data-value="' . $dst_name . '" data-auto="' . $args['auto'] . '" data-callback-funct="load_auto_ward" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';


    return $opt;
}
function get_ward_name_com($ward_id = '') {
    // var_dump('hi');
     $CI = get_instance();
 
     $CI->load->model('amb_model');
 
     if ($ward_id) {
         $select[$ward_id] = "selected='selected'";
     }
 
     $ward = $CI->amb_model->get_ward_name();
 
 
     if (!empty($ward)) {
 
         foreach ($ward as $opt) {
 
             $options .= "<option value='" . $opt->ward_id . "' " . $select[$opt->ward_name] . " >" . $opt->ward_name . "</option>";
         }
     }
 
     return $options;
 }
function get_ward($args = array()) {

    $city_id = $cty_name = '';
  //  var_dump($args['rel']);die();
    $CI = get_instance();

    $CI->load->model('common_model');

    $city = $CI->common_model->get_ward(array('dist_code' => $$args['dst_code']));

    if (!empty($city) && $args['cty_id'] != '') {
        $city_id = $city[0]->ward_id;
        $cty_name = $city[0]->ward_name;
    }

    $opt = '<input name="ward_name" data-callback-funct="load_wardlocation_address" value="' . $ward_id . '" class="mi_autocomplete filter_required controls width97 " placeholder="Ward" data-href="' . base_url() . 'auto/get_ward/' . $args['dst_code'] . '" data-errors="{filter_required:\'Please select ward from dropdown list\'}" data-base="" data-value="' . $ward_name . '" data-auto="' . $args['auto'] . '" data-rel="' . $args['rel'] . '" ' . $args['disabled'] . '>';

    return $opt;
}
function get_bed_count_details($bed_type){
    $dist_code = $dst_name = '';

    $CI = get_instance();

    $CI->load->model('hp_model');



    $bed = $CI->hp_model->get_bed_count_details(array('bed_type' => $bed_type));
return $bed[0]->bed_count;
    
}

function get_amb_login_status($reg_rto){
    $CI = get_instance();
    $CI->load->model('amb_model');
    $bed = $CI->amb_model->get_app_login_user_remote($reg_rto);
    return $bed;
}

function track_report_download($args = array()){
    $CI = get_instance();
    $CI->load->model('common_model');
    $args['trk_date_time'] = date('Y-m-d H:i:s');
            
    $bed = $CI->common_model->insert_report_tracking($args);
    return $bed;
}
function get_current_select_time($time){
   // $time ='09';
    $time = (int)$time;
    //var_dump($time);
    $time_slot=4;
    if($time >= 9 && $time < 12){
        $time_slot = '1';
        
    }else if($time >= 12 && $time < 15){
         $time_slot = '2';
    }else if($time >= 15 && $time < 18){
         $time_slot = '3';
    }else if($time >= 18 ){
         $time_slot = '4';
    }
    return $time_slot;
}
function get_current_select_name($time){

    if($time == '1'){
        $time_slot = '9 AM';
        
    }else if($time == '2'){
         $time_slot = '12 PM';
    }else if($time == '3'){
         $time_slot = '3 PM';
    }else if($time == '4'){
         $time_slot = '6PM';
    }
    return $time_slot;
    
}
function dashboard_redirect($user_group,$base_url){
 // var_dump($user_group);
   
     if ($user_group == 'UG-EMT') {

            $url = $base_url . "emt/emt_home";
        } else if ($user_group == 'UG-ERO-102' || $user_group == 'UG-ERO' || $user_group == 'UG-EROSupervisor' || $user_group == 'UG-REMOTE' || $user_group == 'UG-BIKE-ERO' || $user_group == 'UG-ERCTRAINING') {

            $url = $base_url . "calls";
           //$url = $base_url . "calls/calls_blank";
        }else if ($user_group == 'UG-Dashboard') {
          
            $url = $base_url . "dashboard";
        } else if ($user_group == 'UG-ERCP' || $user_group == 'UG-ERCPSupervisor') {

            $url = $base_url . "ercp";
        } else if ($user_group == 'UG-DCO' || $user_group == 'UG-DCOSupervisor' || $user_group == 'UG-DCO-102' || $user_group == 'UG-BIKE-DCO') {

            $url = $base_url . "job_closer/index";
            //redirect($base_url . "pcr", 'location');
        }
//        else if ($user_group == 'UG-DCO-102') {
//
//            $url = $base_url . "job_102_closer";
//            //redirect($base_url . "pcr", 'location');
//        } 
        else if ($user_group == 'UG-SHAM') {

            $url = $base_url . "schedule/schedule_listing";
        } else if ($user_group == 'UG-Supervisor' || $user_group == 'UG-SuperAdmin' || $user_group == 'UG-ShiftManager' || $user_group == 'UG-BIKE-SUPERVISOR') {

            $url = $base_url . "supervisor";
        } else if ($user_group == 'UG-FleetManagement' || $user_group == 'UG-FLEET-SUGARFCTORY') {

            $url = $base_url . "ambulance_maintaince/fleetdesk";
        } else if ($user_group == 'UG-PDA' || $user_group == 'UG-PDASupervisors' || $user_group == 'UG-PDASupervisor') {

            $url = $base_url . "police_calls/index";
        } else if ($user_group == 'UG-FDA' || $user_group == 'UG-FDASupervisor') {

            $url = $base_url . "fire_calls/index";
        }else if ($user_group == 'UG-Grievance' || $user_group == 'UG-GrievianceManager' ) {

            $url = $base_url . "grievance/grievance_call_list";
            
        }else if ($user_group == 'UG-Feedback' ) {

            $url = $base_url . "feedback/feedback_list";
        }else if ( $user_group == 'UG-FeedbackManager') {

            $url = $base_url . "feedback/feedback_manager";
        }else if ( $user_group == 'UG-ERO-HD') {

            $url = $base_url . "corona/corona_list";
        }else if ( $user_group == 'UG-FOLLOWUPERO') {

            $url = $base_url . "calls/erorfollowup_list";
        }
        else if ( $user_group ==  'UG-DM' || $user_group ==  'UG-ZM') {

            $url = $base_url . "dash/dashboard";
            
        }else if ($user_group == 'UG-DIS-FILD-MANAGER') {

            $url = $base_url . "supervisor/index";
            
        }else if ( $user_group == 'UG-DASHBOARD-NHM') {

            //$url = $base_url . "dashboard/nhm";
           $url = $base_url . "dashboard/nhm_dashboard";
        }else if ( $user_group == 'UG-NHM-DASH' ) {

            $url = $base_url . "dashboard/nhm_dashboard";
        
        }else if ( $user_group == 'UG-Dashboard-view') {

           // $url = $base_url . "dashboard/dash";
           $url = $base_url . "dashboard/nhm_dashboard_view";
        }else if ( $user_group == 'UG-NHM-DASHBOARD' || $user_group == 'UG-DIVISIONAL-OPERATION-HEAD' || $user_group == 'UG-DISTRICT-OPERATIONAL-HEAD') {

            $url = $base_url . "bed/nhm_dashboard";
        }
        else if ($user_group == 'UG-NHM-AMB-TRACKING-DASHBOARD') {
          
            $url = $base_url . "dashboard/nhm_amb_tracking";
        }
        else if($user_group == 'UG-HOSP'){
            $url = $base_url . "hospital_terminal";
        }
        else if ($user_group == 'UG-MemsDashboard') {
            //var_dump($user_group ,"under");die();
            $url = $base_url . "dashboard/memsdashboard";
        }else if ($user_group == 'UG-COMPLIANCE') {
            
            $url = $base_url . "grievance/grievance_call_list";
            
        }else if ($user_group == 'UG-NHM-REPORT') {
            
            $url = $base_url . "file_nhm/table_file_nhm_report";
            
        }
//        else if($user_group == 'UG-FLEETDESK'){
//            $url = $base_url . "ambulance_maintaince/fleetdesk";
//        }
            else if ($user_group == 'UG-EMSCOORDINATOR') {
                        
                $url = $base_url . "dashboard/nhm_dashboard_view_new";
                
            }
            else if ($user_group == 'UG-SITUATIONAL-DESK') {
                        
               // $url = $base_url . "corona/corona_list";
               $url = $base_url . "calls/situational_call_list";
                
            }
        else{
              $url = $base_url . "dash/dashboard";
        }
         redirect($url, 'location');
}
function get_ins_med_records($ins_id =array()){
    $CI = get_instance();

    $CI->load->model('inspection_model');
    $arr = array('ins_id' => $ins_id['ins_id'],'med_id'=>$ins_id['med_id']);
    $result_med = $CI->inspection_model->get_ins_med_records($arr);
    return $result_med[0];
}
    function follow_up_status($inc_ref_id =''){
        $CI = get_instance();

        $CI->load->model('inc_model');
        $total_cnt = $CI->inc_model->get_followupinc(array('inc_ref_id'=>$inc_ref_id));
   
        $followup_status = $total_cnt[0]->inc_ero_followup_status;
        echo $followup_status;
    }
    function get_inv_name($args = array()){
        $CI = get_instance();

    $CI->load->model('inv_model');
    $CI->load->model('ind_model');
    $CI->load->model('med_model');


    $args_ca = array(
        'inv_type' => $args['inv_type'],
        'inv_id'=>$args["inv_id"]
    );


    if($args['inv_type'] == 'MED'){
  
    $inv_stock = $CI->med_model->get_med_list($args_ca);
    $inv_name = $inv_stock[0]->med_title;
      
    }else if($args['inv_type'] == 'EQP'){
      
    $inv_stock = $CI->ind_model->get_eqp_data_stock($args_ca);
    $inv_name = $inv_stock[0]->eqp_name;
    }else{
     $inv_stock = $CI->inv_model->get_inv_list($args_ca);
     $inv_name = $inv_stock[0]->inv_title;
    }
   
    if($inv_stock){
       return $inv_name;
    }else{
        return false;
    }

}
function get_work_station_vendor($inc_ref_id =''){
        $CI = get_instance();

        $CI->load->model('fleet_model');
        $total_cnt = $CI->fleet_model->get_work_station(array('ws_id'=>$inc_ref_id));
       
   
        $followup_status = $total_cnt[0]->vendor_id;
        return $followup_status;
        
    }
    function pda_update_api($data = ''){
        $api_url='https://mahat.trinityiot.in:9191/NGCADIntService/externalIntegration/updateStatusForExternalIncident';
        $api_url='https://mahat.trinityiot.in:9191/NGCADIntService/externalIntegration/updateStatusForExternalIncident';
       $CI = get_instance();
       
       file_put_contents('./logs/'.date("Y-m-d").'pda_log.log', $data.",\r\n", FILE_APPEND);


       $http_header = array('Content-Type: application/json');

       $args = array(
                   'data'        => $data,
                   'method'      => 'POST',
                  // 'referer_url' => '',
                   'http_header' => $http_header,
                   //'header'      => false,
                  // 'timeout'     => 0
               );

       $avaya_resp =  pda_mi_curl_request($api_url,$args);
           file_put_contents('./logs/'.date("Y-m-d").'responce_pda_log.log', json_encode($avaya_resp).",\r\n", FILE_APPEND);

       return $avaya_resp;

   }
   
    function pda_case_close_api($data = ''){
        $api_url='https://mahat.trinityiot.in:9191/NGCADIntService/externalIntegration/updateStatusToCloseForExternalIncident';
        $CI = get_instance();


        $http_header = array('Content-Type: application/json');

        $args = array(
                    'data'        => $data,
                    'method'      => 'POST',
                   // 'referer_url' => '',
                    'http_header' => $http_header,
                    //'header'      => false,
                   // 'timeout'     => 0
                );

        $avaya_resp =  pda_mi_curl_request($api_url,$args);

        return $avaya_resp;

    }
     function pda_mi_curl_request( $url, $atts = array() ){

        $args = array(
            'data'        => array(),
            'method'      => 'GET',
            'referer_url' => '',
            'http_header' => array(),
            'header'      => false,
            'timeout'     => 0
        );
        $args = array_merge( $args, $atts );

        set_time_limit( $args['timeout']*2 );

        if (function_exists("curl_init") && $url) {

            $user_agent = $_SERVER['HTTP_USER_AGENT'];

            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_USERAGENT, $user_agent );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch, CURLOPT_HEADER, $args['header'] );
            curl_setopt( $ch, CURLOPT_TIMEOUT, $args['timeout'] );
            curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $args['timeout'] );

            if ( strtolower( $args['method'] ) == "post" ) {
                curl_setopt( $ch, CURLOPT_POST, true );
                curl_setopt( $ch, CURLOPT_POSTFIELDS, $args['data'] );
            } else {
                curl_setopt( $ch, CURLOPT_HTTPGET, 1);
                $query_string = http_build_query( $args['data'] );
                if ( $query_string != '' ) {
                    $url = trim( $url, "?" ) . "?" . $query_string;
                }
            }

            if ( $args['referer_url'] != '' ) { 
                curl_setopt( $ch, CURLOPT_REFERER, $args['referer_url'] );
            }

            if ( !empty( $args['http_header'] ) ) {
                curl_setopt( $ch, CURLOPT_HTTPHEADER, $args['http_header'] );
            }

            curl_setopt( $ch, CURLOPT_URL, $url );

            $resp = curl_exec($ch);
            $info = curl_getinfo($ch);

            curl_close($ch);
            session_start();

            return array( 
                'resp' => $resp,
                'info' => $info
            );

        }

    }
    function generate_pda_api_ref_id() {
    $CI = get_instance();

    $CI->load->model('options_model');
    $ems_inc_ref_id = $CI->options_model->get_option('pda_api_ref_id');
   
    if (empty($ems_inc_ref_id)) {


        $date = str_replace('-', '', date('Y-m-d'));

        $data = array($date => 1);
        $inc = 1;
        $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);

        $ref_id = json_encode($data, true);

        
        $inc_id_ref = $date . $inc;
        //$inc_id_ref = $inc;
        $data = array($date => $inc_id_ref);
        $ref_id = json_encode($data, true);
        $inc_id = $CI->options_model->add_option('pda_api_ref_id',$ref_id);
    } else {

        $inc_id_data = json_decode($ems_inc_ref_id, true);
        $date = str_replace('-', '', date('Y-m-d'));

        if (array_key_exists($date, $inc_id_data)) {

            $inc = $inc_id_data[$date] + 1;
            $data = array($date => $inc);
            $ref_id = json_encode($data, true);

            //$inc_id = $CI->options_model->add_option('ems_inc_ref_id',$ref_id);

            $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);
            //$inc_id_ref = $date.$inc;
            $inc_id_ref = $inc;
            $data = array($date => $inc_id_ref);
            $ref_id = json_encode($data, true);
            $inc_id = $CI->options_model->add_option('pda_api_ref_id',$ref_id);
        } else {
            $inc = 1;
            $data = array($date => $inc);
            $ref_id = json_encode($data, true);

            //$inc_id = $CI->options_model->add_option('ems_inc_ref_id',$ref_id);

            $inc = str_pad($inc, 4, "0", STR_PAD_LEFT);
            $inc_id_ref = $date . $inc;

            $data = array($date => $inc_id_ref);
            $ref_id = json_encode($data, true);
            $inc_id = $CI->options_model->add_option('pda_api_ref_id',$ref_id);
            // var_dump($inc_id_ref);
            // $inc_id_ref = $inc;
        }
    }

    return $inc_id_ref;
}

function get_base_month_by_date($today) {
    $CI = get_instance();
    if ($today != '') {
        $base_month = $CI->common_model->get_base_month($today);
        $bs = array('base_month' => $base_month[0]->months, 'set_date' => $today);
        $base_month = $base_month[0]->months;
        return $base_month;
    }
}
function get_blood_group_name($ref_id = '') {
    $args = array();
    $CI = get_instance();
    $args['bldgrp_id'] = $ref_id;

    $CI->load->model('call_model');

    $bloodgp = $CI->call_model->get_bloodgp($args);
    $bldgrp_name = $bloodgp[0]->bldgrp_name;

    return $bldgrp_name;
}
function get_past_his_details($past_his_id){
    $args = array();
    $CI = get_instance();
    $args['past_his_id'] = $past_his_id;
    $CI->load->model('hp_model');
    $inc_details = $CI->hp_model->get_epcr_past_his($args);
    return $inc_details;
}
function get_intervention_details($id){
    $args = array();
    $CI = get_instance();
    $args['id'] = $id;
    $CI->load->model('hp_model');
    $inc_details = $CI->hp_model->get_epcr_intervention($args);
    return $inc_details;
}
function get_inc_details_handover($inc_ref_id){
    $args = array();
    $CI = get_instance();
    $args['inc_ref_id'] = $inc_ref_id;
    $CI->load->model('hp_model');
    $inc_details = $CI->hp_model->get_epcr_inc_details_handover($args);
    return $inc_details;
}
 function get_inc_details($inc_ref_id){
    $args = array();
    $CI = get_instance();
    $args['inc_ref_id'] = $inc_ref_id;
    $CI->load->model('hp_model');
    $inc_details = $CI->hp_model->get_epcr_inc_details($args);
    return $inc_details;
}
function get_lbs_data($mobile_no,$timestamp_lbs){
    //return false;
    $CI = get_instance();
    $CI->load->model('call_model');
    $lbs_url = 'http://172.16.60.246:9095/getlocation';
    
    $data = '<?xml version="1.0"?>
            <iLocator>
                <request>
                    <username>ilocatespero</username>
                    <password>ilocatepert108!</password>
                    <msisdn>'.$mobile_no.'</msisdn>
                    <timestamp>'.$timestamp_lbs.'</timestamp>
                    <provide_meta>false</provide_meta>
                    <frequency>20</frequency>
                </request>
            </iLocator>';
    
    
    $clg_data = $CI->session->userdata('current_user');
    $clg_ref_id = $clg_data->clg_ref_id;
   
    $lbs_args = array('lbs_mobile'=>$mobile_no,'lbs_timestamp'=>$timestamp_lbs,'lbs_datetime'=>date('Y-m-d H:i:s'),'lbs_send_data'=> addslashes($data),'lbs_user_id'=>$clg_ref_id);
    $CI->call_model->insert_lbs_data($lbs_args);  
    
    $http_header = array('Content-type: text/xml');
            $args = array(
            'data'        => $data,
            'method'      => 'post',
            'referer_url' => '',
            'http_header' => $http_header,
            'header'      => false,
            'timeout'     => 35
        );

          
    $location_resp =  pda_mi_curl_request($lbs_url,$args);
    return $location_resp;
  

  
}