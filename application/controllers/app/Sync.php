<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sync extends EMS_Controller {

    function __construct() {
        

        parent::__construct();

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
        
     

        if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'io.cordova.emt') {
            header('Content-Type: application/json');
            header('HTTP/1.0 403 Forbidden');
            echo json_encode('{"error": "Access Forbidden"}');
            die();
        }

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

    // For >= v1.4.0
    function download_sync_main() {
      
    
        if (!empty($_POST)) {
            $post_data = $_POST;
        } else {
            $post_raw_data = file_get_contents('php://input');
            $post_data = json_decode($post_raw_data, true);
        }
       

        if (empty($post_data)) {
            echo json_encode(array());
            die();
        }

        $miaction = $post_data['miaction'];
      

        if ($miaction == 'prepare_download') {
            $this->prepare_download_file();
        }
//        echo 2;


        if ($miaction == 'download_sync_file') {
            $this->download_sync_file();
        }
//echo 3;
        if ($miaction == 'unlink_sync_file') {

            $user_key = trim($post_data['user_key'], './');
            if (empty($user_key)) {
                return false;
            }
            $file_path = FCPATH . 'temp/sync/' . $user_key . '/*';
            $temp_files = glob($file_path);
            foreach ($temp_files as $t_file) {
                if (is_file($t_file)) {
                    unlink($t_file);
                }
            }
            echo json_encode(array('status' => 'done'));
        }
//        echo 4;

        die();
    }

    function prepare_download_file() {
        
      
        set_time_limit(0);

        if (!empty($_POST)) {
            $post_data = $_POST;
        } else {
            $post_raw_data = file_get_contents('php://input');
            $post_data = json_decode($post_raw_data, true);
        }


        if (empty($post_data)) {
            echo json_encode(array());
            die();
        }
        


        $clg_ref_id = $post_data['clg_ref_id'];
//        $cluster_ids = $post_data['cluster_id'];
        $sync_tables = $post_data['sync_tables'];
        $user_key = trim($post_data['user_key']);

        if ($user_key == '') {
            echo json_encode(array());
            die();
        }

        $conditions_data = array(
//            'cluster_id' => $cluster_ids,
//            'schedule_clusterid' => $cluster_ids,
//            'schd_school_id' => '',
//            'school_id' => '',
//            'schedule_id' => '',
            'operator_id' => array($clg_ref_id),
            'inc_ref_id' => '',
            'inc_id' => '',
            'amb_rto_register_no' => '',
            'ptn_id' => ''
        );

        

        // Get Incedence Ids
        $incedence_result_data = $this->sync_model->get_incedences($clg_ref_id);
      
              
        $incedence_ids = array();
        foreach ($incedence_result_data as $item) {
            $incedence_ids[] = $item->sub_id;
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
            if (empty($result_data)) {
                continue;
            }

            $resp_data['sync_time'][$sync_table] = time();

            $result_data_temp = array();
            foreach ($result_data as $result_item) {

                $result_item_temp = array();
                foreach ($result_item as $col_name => $col_val1) {
                    if ($col_name == 'modify_date_sync') {
                        continue;
                    }
                    $col_val2 = json_decode($col_val1);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $result_item_temp[$col_name] = $col_val2;
                    } else {
                        $result_item_temp[$col_name] = $col_val1;
                    }
                }
                $resp_data['table_data'][$sync_table][] = $result_item_temp;

                $records_count++;

                if ($records_count % 501 == 0) {
                    $json_data = json_encode($resp_data);
                    $file_name = 'sync_' . $user_key . '_' . time() . '_' . rand(11111, 99999) . '.json';
                    $file_path = FCPATH . 'temp/sync/' . $user_key . '/';
                    if (!file_exists(rtrim($file_path, '/'))) {
                        mkdir($file_path, 0775);
                    }
                    $rs = file_put_contents($file_path . $file_name, $json_data);
                    if ($rs != false) {
                        $sync_files[] = array(
                            'file_name' => $file_name,
                            'process_status' => 0,
                            'download_status' => 0
                        );
                        unset($resp_data['table_data']);
                    }
                }
            }
        }


        if (!empty($resp_data)) {

            $json_data = json_encode($resp_data);

            $file_name = 'sync_' . $user_key . '_' . time() . '_' . rand(11111, 99999) . '.json';
            $file_path = FCPATH . 'temp/sync/' . $user_key . '/';
            if (!file_exists(rtrim($file_path, '/'))) {
                mkdir($file_path, 0775);
            }
            $rs = file_put_contents($file_path . $file_name, $json_data);
            if ($rs != false) {
                $sync_files[] = array(
                    'file_name' => $file_name,
                    'process_status' => 0,
                    'download_status' => 0
                );
            }
        }
      

        echo json_encode($sync_files);

        die();
    }

   

    // For <= than v1.3.9
    function upload_sync() {

        if (!empty($_POST)) {
            $post_data = $_POST;
        } else {
            $post_raw_data = file_get_contents('php://input');
            $post_data = json_decode($post_raw_data, true);
        }


        if (empty($post_data)) {
            echo json_encode(array());
        }

        $table_name = $post_data['table_name'];
        $table_data = $post_data['table_data'];
        $table_pk = $post_data['table_pk'];
        $table_uk = $post_data['table_uk'];


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

            $table_row_new[$table_pk] = $table_row[$table_pk];
            $table_row_new[$table_uk] = $table_row[$table_uk];

            $table_data_temp[] = $table_row_new;
        }
        $table_data = $table_data_temp;

        $args = array(
            'table_name' => $table_name,
            'table_data' => $table_data,
            'table_pk' => $table_pk,
            'table_uk' => $table_uk,
        );

        $updated_ids = $this->sync_model->update_sync_data($args);

        echo json_encode(array('table_name' => $table_name, 'updated_items' => $updated_ids));
        die();
    }

    // For >= v1.4.0
    function upload_sync_main() {

        if (!empty($_POST)) {
            $post_data = $_POST;
        } else {
            $post_raw_data = file_get_contents('php://input');
            $post_data = json_decode($post_raw_data, true);
        }


        if (empty($post_data)) {
            echo json_encode(array('status' => 'fail'));
            die();
        }


        foreach ($post_data as $table_name => $table_data) {

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


            $rs = $this->sync_model->update_sync_data_main($args);
        }

        //echo json_encode(array('table_name' => $table_name, 'updated_items' => $updated_ids));
        echo json_encode(array('status' => 'success'));
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

   

}
