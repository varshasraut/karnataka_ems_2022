<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sync extends EMS_Controller {

    function __construct() {

        parent::__construct();

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
        

        $this->steps_cnt = $this->config->item('pcr_steps');

        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));
        $this->load->model(array('pet_model', 'add_res_model', 'colleagues_model', 'inc_model', 'amb_model', 'pcr_model', 'call_model', 'medadv_model', 'student_model', 'school_model', 'schedule_model', 'emt_model', 'sync_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper', 'language_helper'));


//        $this->post = $this->input->get_post(NULL);
        $this->post['base_month'] = get_base_month();

        $this->clg = $this->session->userdata('current_user');

        $this->pg_limit = $this->config->item('pagination_limit_clg');
        $this->pg_limits = $this->config->item('report_clg');

        $this->steps_cnt = $this->config->item('pcr_steps');

        $this->today = date('Y-m-d H:i:s');
    }

    // Disabled
    public function sync_clusters() {

        echo json_encode(array());
        die(); //Disabled


        $cluster_id = $this->input->post('cluster_id', TRUE);

        $args = array();

        $result['data']['ems_cluster'] = $this->schedule_model->get_cluster($args);
        $result['time']['ems_cluster'] = time();

        $result['data']['ems_hospital'] = $this->emt_model->get_hospital($args);
        $result['time']['ems_hospital'] = time();

        $data['schedule_isaprove'] = '1';
        $data['schedule_clusterid'] = $cluster_id;

        $arg_array = array();
        $result['data']['ems_schedule'] = $this->schedule_model->get_sch_data($data, $offset, $limit);
        $result['time']['ems_schedule'] = time();

        $school_data = array();
        foreach ($result['data']['ems_schedule'] as $result_data) {
            $school_arg = array('school_id' => $result_data->schedule_schoolid);
            $response_data = $this->school_model->get_school_data($school_arg);
            $school_data = array_merge($school_data, $response_data);
        }
        $result['data']['ems_school'] = $school_data;
        $result['time']['ems_school'] = time();

        $student_data = array();
        foreach ($result['data']['ems_schedule'] as $result_data) {
            $schedule_id = array('schedule_id' => $result_data->schedule_id);
            $response_data = $this->student_model->get_search_stud_by_shedule_id($schedule_id);
            $student_data = array_merge($student_data, $response_data);
        }
        $result['data']['ems_student'] = $student_data;
        $result['time']['ems_student'] = time();

        $result['data']['ems_stud_schedule'] = $this->student_model->get_stud_schedule();
        $result['time']['ems_stud_schedule'] = time();

        echo json_encode($result);
        exit();
    }

    
    function download_sync() {
        
        if (!empty($_POST)) {
            $post_data = $_POST;
        } else {
            $post_raw_data = file_get_contents('php://input');
            $post_data = json_decode($post_raw_data, true);
        }


        if (empty($post_data)) {
            echo json_encode( array() );
            die();
        }        
        
        $miaction  = $post_data['miaction'];
        
        if( $miaction == 'prepare_download' ){
            $this->prepare_download_file();
        }
        
        if( $miaction == 'download_sync_file' ){
            $this->download_sync_file();
        }
        
        if( $miaction == 'unlink_sync_file' ){
            $user_key = trim($post_data['user_key'],'./');
            if(empty($user_key)){ return false; }
            $file_path = FCPATH.'temp/sync/'.$user_key.'/*';
            $temp_files = glob($file_path);
            foreach($temp_files as $t_file){
                if(is_file($t_file)){ unlink($t_file); }
            }
            echo json_encode(array('status'=>'done'));
        }
        
        die();
        
    }
    
    
    function prepare_download_file(){
        
        set_time_limit(0);
        
        if (!empty($_POST)) {
            $post_data = $_POST;
        } else {
            $post_raw_data = file_get_contents('php://input');
            $post_data = json_decode($post_raw_data, true);
        }


        if (empty($post_data)) {
            echo json_encode( array() );
            die();
        }
        
        $clg_ref_id  = $post_data['clg_ref_id'];
        $cluster_ids = $post_data['cluster_id'];
        $sync_tables = $post_data['sync_tables'];
        $user_key    = $post_data['user_key'];

        $conditions_data = array(
            'cluster_id' => $cluster_ids,
            'schedule_clusterid' => $cluster_ids,
            'schd_school_id' => '',
            'school_id' => '',
            'schedule_id' => '',
            'operator_id' => array($clg_ref_id),
            'inc_ref_id' => ''
        );

        // Get Schools Ids
        $school_result_data = $this->sync_model->get_cluster_schools($cluster_ids);
        $school_ids = array();
        foreach ($school_result_data as $item) {
            $school_ids[] = $item->school_id;
        }
        $conditions_data['schd_school_id'] = $school_ids;
        $conditions_data['school_id'] = $school_ids;

        // Get Schedule Ids
        $schedule_result_data = $this->sync_model->get_cluster_schedules($cluster_ids);
        $schedule_ids = array();
        foreach ($schedule_result_data as $item) {
            $schedule_ids[] = $item->schedule_id;
        }
        $conditions_data['schedule_id'] = $schedule_ids;

        // Get Incedence Ids
        $incedence_result_data = $this->sync_model->get_incedences($cluster_ids);
        $incedence_ids = array();
        foreach ($incedence_result_data as $item) {
            $incedence_ids[] = $item->inc_ref_id;
        }
        
        $conditions_data['inc_ref_id'] = $incedence_ids;
        $conditions_data['inc_id'] = $incedence_ids;
        
        // Get tdd ambulance
        $amb_result_data = $this->sync_model->get_ambulance();
        $amb_ids = array();
        foreach ($amb_result_data as $item) {
            $amb_ids[] = $item->amb_rto_register_no;
        }

        $conditions_data['amb_rto_register_no'] = $amb_ids;
      
        //$conditions_data['amb_user_type'] = 'tdd';

        // Get Incedence patient Ids
        $patient_result_data = $this->sync_model->get_incedences_patients($incedence_ids);
        $ptn_ids = array();
        foreach ($patient_result_data as $item) {
            $ptn_ids[] = $item->ptn_id;
        }

        $conditions_data['ptn_id'] = $ptn_ids;


        $table_conditions = array(
            "ems_hospital" => array(),
            "ems_incidence_ambulance" => array('inc_ref_id'),
            "ems_cluster" => array('cluster_id'),
            "ems_schedule" => array('schedule_clusterid'),
            "ems_school" => array('cluster_id'),
            "ems_student" => array('schd_school_id'),
            "ems_stud_schedule" => array('schedule_id'),
            "ems_stud_basic_info" => array('schedule_id'),
            "ems_stud_screening" => array('schedule_id'),
            "ems_student_dental" => array('schedule_id'),
            "ems_student_vision" => array('schedule_id'),
            "ems_student_ent" => array('schedule_id'),
            "ems_stud_medicle_exam" => array('schedule_id'),
            "ems_stud_prescription" => array('schedule_id'),
            "ems_stud_investigation" => array('schedule_id'),
            "ems_stud_sick_room" => array('schedule_id'),
            "ems_stud_hospitalizaion" => array('schedule_id'),
            "ems_epcr" => array('inc_ref_id'),
            "ems_mas_states" => array(),
            "ems_mas_districts" => array(),
            "ems_mas_city" => array(),
            "ems_operateby" => array('operator_id'),
            "ems_incidence" => array('inc_ref_id'),
            "ems_incidence_patient" => array('inc_id'),
            "ems_colleague" => array(),
            "ems_ambulance" => array('amb_rto_register_no'),
            "ems_patient" => array('ptn_id'),
            "ems_mas_area_types" => array(),
            "ems_driver_pcr" => array('inc_ref_id'),
            "ems_ambulance_timestamp_record" => array(),
            "ems_ambulance_stock" => array(),
            "ems_inventory" => array(),
            "ems_manufacture" => array(),
            "ems_mas_quantity_units" => array(),
            "ems_inventory_stock" => array(),
            "ems_pcr" => array(),
            "ems_obvious_death_questions" => array(),
            "ems_obvious_death_ques_summary" => array(),
            "ems_mas_odometer_remark" => array(),
            "ems_amb_default_team" => array(),
            "ems_inventory_medicine" => array(),
            "ems_inventory_equipment" => array(),
            "ems_indent_request" => array(),
            "ems_indent_item" => array(),
            "ems_options" => array(),
            "ems_mas_responce_remark" => array(),
            "ems_media" => array('cluster_id'),
            "ems_mas_groups" => array()
        );

        
        $sync_files = array();
        $records_count = 0;
        $resp_data = array();
        
        foreach ($sync_tables as $sync_table => $sync_time) {

            $args['table_name'] = $sync_table;
            $args['sync_time'] = $sync_time;
            $args['conditions'] = $table_conditions[$sync_table];
            $args['conditions_data'] = $conditions_data;

            $conditions = $table_conditions[$sync_table];
            if (!empty($conditions)) {
                $condition_flag = 0;
                foreach ($conditions as $condition) {
                    if (!empty($conditions_data[$condition])) {
                        $condition_flag = 1;
                    }
                }
                if ($condition_flag == 0) {
                    continue;
                }
            }
            
            $result_data = $this->sync_model->get_sync_data($args);
            if( empty($result_data) ){ continue; }
            
            $resp_data['sync_time'][$sync_table]  = time();

            $result_data_temp = array();
            foreach ($result_data as $result_item) {
                
                $result_item_temp = array();
                foreach ($result_item as $col_name => $col_val1) {
                    if( $col_name == 'modify_date_sync' ){ continue; }
                    $col_val2 = json_decode($col_val1);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $result_item_temp[$col_name] = $col_val2;
                    } else {
                        $result_item_temp[$col_name] = $col_val1;
                    }
                }
                $resp_data['table_data'][$sync_table][] = $result_item_temp;
                
                $records_count++;
                
                if( $records_count % 501 == 0 ){
                    $json_data = json_encode($resp_data);
                    $file_name = 'sync_'.time().'_'.rand(11111,99999).'.json';
                    $file_path = FCPATH.'temp/sync/'.$user_key.'/';
                    if( !file_exists( rtrim($file_path,'/')) ){
                        mkdir($file_path, 0775);
                    }
                    $rs = file_put_contents( $file_path.$file_name, $json_data );
                    if( $rs != false ){
                        $sync_files[] = array(
                            'file_name'       => $file_name,
                            'process_status'  => 0,
                            'download_status' => 0
                        );
                        unset($resp_data['table_data']);
                    }
                }
                
            }
            
        }
        
        
        if( !empty($resp_data) ){

            $json_data = json_encode($resp_data);
            
            $file_name = 'sync_'.time().'_'.rand(11111,99999).'.json';
            $file_path = FCPATH.'temp/sync/'.$user_key.'/';
            if(!file_exists( rtrim($file_path,'/') )){
                mkdir($file_path, 0775);
            }
            $rs = file_put_contents( $file_path.$file_name, $json_data );
            if( $rs != false ){
                $sync_files[] = array(
                    'file_name'       => $file_name,
                    'process_status'  => 0,
                    'download_status' => 0
                );
            }
            
        }
        
        
        //$file_details = array(
        //  'data_files'  => $sync_files,
        //  'data_length' => $files_data_length
        //);
        
        echo json_encode($sync_files);
        
        die();
        
        
    }
    
    
    function download_sync_file(){
        
        return false; // Disabled
        
        if (!empty($_POST)) {
            $post_data = $_POST;
        } else {
            $post_raw_data = file_get_contents('php://input');
            $post_data = json_decode($post_raw_data, true);
        }


        if (empty($post_data)) {
            echo json_encode( array() );
            die();
        }
        
        
        $file_name   = $post_data['file_name'];
        $file_offset = $post_data['file_offset'];
        $file_path   = FCPATH.'temp/sync/';
        
        if(!isset($file_offset)){ $file_offset = 0; }
        
        if( file_exists($file_path.$file_name) ){
        
            $handle = @fopen($file_path.$file_name, "r");
            fseek($handle, $file_offset);

            if ($handle) {
                $buffer = fgets( $handle, 262144 );  //524288
                if( $buffer === false ){
                    $buffer = "[END_OF_FILE]";
                    unlink($file_path.$file_name);
                }
                fclose($handle);
            }
        
        }else{
            $buffer = '[NO_FILE_FOUND]';
        }
        
        header('Content-type: text/plain');
        header('Content-Length: '.strlen($buffer));
        echo $buffer;
        
        die();
        
    }    

    
    function upload_sync() {

//        if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'io.cordova.shp') {
//            header('Content-Type: application/json');
//            header('HTTP/1.0 403 Forbidden');
//            echo json_encode('{"error": "Access Forbidden"}');
//            die();
//        }


        if (!empty($_POST)) {
            $post_data = $_POST;
        } else {
            $post_raw_data = file_get_contents('php://input');
            $post_data = json_decode($post_raw_data, true);
        }


        if (empty($post_data)) {
            echo json_encode(array('status'=>'fail'));
            die();
        }
        
        
        foreach( $post_data as $table_name => $table_data ){
        
        //$table_name = $post_data['table_name'];
        //$table_data = $post_data['table_data'];
        //$table_pk = $post_data['table_pk'];
        //$table_uk = $post_data['table_uk'];


        $table_columns = $this->sync_model->get_columns($table_name, true);
 

        $table_data_temp = array();
        foreach ($table_data as $table_row) {

            if (isset($table_row['data'])) {
                $json_data = json_decode($table_row['data']);
                unset($table_row['data']);
                $table_row = array_merge($table_row, $json_data);
            }

            $table_row_new = array();
            foreach ($table_columns as $column => $col_value) {
                if (isset($table_row[$column])) {
                    if (is_array($table_row[$column])) {
                        $table_row_new[$column] = json_encode($table_row[$column]);
                    } else {
                        $table_row_new[$column] = $table_row[$column];
                    }
                }
            }

            //$table_row_new[$table_pk] = $table_row[$table_pk];
            //$table_row_new[$table_uk] = $table_row[$table_uk];

            $table_data_temp[] = $table_row_new;
        }
        $table_data = $table_data_temp;

        $args = array(
            'table_name' => $table_name,
            'table_data' => $table_data,
            //'table_pk' => $table_pk,
            //'table_uk' => $table_uk,
        );
       
        
        $rs = $this->sync_model->update_sync_data($args);
        
        }
        
        //echo json_encode(array('table_name' => $table_name, 'updated_items' => $updated_ids));
        echo json_encode(array('status'=>'success'));
        die();
        
    }
    

    function upload_media_file() {

        $upload_dir = FCPATH . 'upload/student/';
        $file_key = 'photo';
        if ($_FILES[$file_key]["error"] == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES[$file_key]["tmp_name"];
            $name = basename($_FILES[$file_key]["name"]);
            move_uploaded_file($tmp_name, "$upload_dir/$name");
            $resp = array('message' => 'Successfully Upload!', 'status' => 'success');
        } else {
            $resp = array('message' => 'Error code: ' . $_FILES[$file_key]["error"], 'status' => 'error');
        }

        echo json_encode($resp);
        die();
    }

    function get_version() {

        $version = file_get_contents(base_url() . 'shp_apk/updated_app_version.json');
        echo json_encode($version);
        die();
    }

}
