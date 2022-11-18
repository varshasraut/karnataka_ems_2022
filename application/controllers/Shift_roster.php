<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shift_roster extends EMS_Controller {

    function __construct() {



        parent::__construct();
        $this->active_module = "M-SHIFT-ROSTER";
        $this->pg_limit = $this->config->item('pagination_limit');
        $this->load->model(array('amb_model', 'student_model', 'inc_model', 'pcr_model', 'quality_model', 'common_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper'));
        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));
        $this->post = $this->input->get_post(NULL);
        $this->clg = $this->session->userdata('current_user');
        $this->post['base_month'] = get_base_month();
    }

    function shift_amb_list() {

        //////////// Filter////////////

        $data['rg_no'] = ($this->post['rg_no']) ? $this->post['rg_no'] : $this->fdata['rg_no'];
        $data['mob_no'] = ($this->post['mob_no']) ? $this->post['mob_no'] : $this->fdata['mob_no'];
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $ambflt['AMB'] = $data;

        ///////////set page number////////////////////
        $page_no = 1;
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        //////////////////////////limit & offset//////

        $data['get_count'] = TRUE;
         $data['thirdparty'] = "1','2";
       // var_dump($this->clg->clg_group);
        
        if($this->clg->clg_group == 'UG-REMOTE'){
                $data['thirdparty']=$this->clg->thirdparty;
        }
        $data['total_count'] = $this->amb_model->get_amb_data($data);

        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['AMB'] = $data;

        $this->session->set_userdata('filters', $ambflt);

        /////////////////////////////////////////////////////

        unset($data['get_count']);

        $data['result'] = $this->amb_model->get_amb_data($data, $offset, $limit);

        $data['get_data'] = $this->amb_model->get_working_area();

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("shift_roster/shift_amb_list"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        $data['pagination'] = get_pagination($pgconf);
         $this->output->add_to_position('', 'caller_details', TRUE);
        $this->output->add_to_position($this->load->view('frontend/shift_roster/amb_list_view', $data, TRUE), $this->post['output_position'], TRUE);

        $this->output->add_to_position($this->load->view('frontend/shift_roster/amb_filters_view', $data, TRUE), 'amb_filters', TRUE);
    }

    function amb_shift_details() {


        if ($this->post['amb_rto_register_no']) {

            $amb_id = $this->session->userdata('amb_rto_register_no');
        }

        $data['amb_rto_register_no'] = $amb_id;



        $this->output->add_to_popup($this->load->view('frontend/shift_roster/shift_details_view', $data, TRUE), '700', '500');
    }

    function add_shift_type() {



        $audit_data = array(
            'shift_name' => $this->post['shift_name'],
            'shift_to_time' => $this->post['to_shift'],
            'shift_from_time' => $this->post['form_shift'],
            'shift_total_hours' => $this->post['total_hours'],
            'shift_is_deleted' => '0',
        );
        $audit_data = $this->quality_model->insert_shift($audit_data);

        if ($audit_data) {
            $this->output->status = 1;
            $this->output->message = "<div class='success'>Shift Added Successfully!</div>";
            $this->output->closepopup = 'yes';
            $this->manage_team();
        }
    }

    function manage_team() {

        $data = array(
            'amb_id' => base64_decode($this->post['amb_id']),
            'amb_sts' => $this->post['amb_sts'],
            'amb_type' => $this->post['amb_type'],
            'cty_name' => $this->post['cty_name'],
            'rto_no' => $this->post['rto_no']
        );

        $data['get_amb_details'] = $this->amb_model->get_amb_data($data);

        $reg_attr = array('rto_no' => $this->post['rto_no']);

        $get_amb_team_data = $this->amb_model->get_manage_team($reg_attr);

        $data['shift_info'] = $this->common_model->get_shift($args);

//        $this->output->add_to_popup($this->load->view('frontend/shift_roster/add_manage_team', $data, TRUE), '800', '800');
        $this->output->add_to_position($this->load->view('frontend/shift_roster/add_manage_team', $data, TRUE), 'content', 'TRUE');
        
    }

    function district_base_location() {

//        $args = array(
//            'hp_district' => $this->post['district_id'],
//        );

        $data['hp_district'] = $this->post['district_id'];

//        $data['inc_emp_info'] = $this->pcr_model->get_hospital_location($args);
//
//        var_dump($data['inc_emp_info']);
//        
//
//        $args_odometer = array('rto_no' => $this->post['amb_id']);
//        $amb_odometer = $this->amb_model->get_amb_odometer($args_odometer);
//
//        if (empty($data['previous_odometer'])) {
//            $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;
//        }
//
//        if (empty($data['previous_odometer'])) {
//            $data['previous_odometer'] = 0;
//        }

        $this->output->add_to_position($this->load->view('frontend/shift_roster/hosp_base_location_view', $data, TRUE), 'amb_base_location', TRUE);

//        $this->output->add_to_position($this->load->view('frontend/maintaince/previous_odometer', $data, TRUE), 'maintance_previous_odometer', TRUE);
    }

    function load_calender_block() {

        $data['schedule'] = $this->post['schedule'];

       
        if ($data['schedule'] == 'daily') {
            $this->output->add_to_position($this->load->view('frontend/shift_roster/daily_calender_view', $data, TRUE), 'canlender_div_outer', TRUE);
        }
        if ($data['schedule'] == 'weekly') {
            $this->output->add_to_position($this->load->view('frontend/shift_roster/weekly_calender_view', $data, TRUE), 'canlender_div_outer', TRUE);
        }
        if ($data['schedule'] == 'monthly') {
            $this->output->add_to_position($this->load->view('frontend/shift_roster/monthly_calender_view', $data, TRUE), 'canlender_div_outer', TRUE);
        }
    }
    
    function shift_timing_show(){
        $data['shift_id'] = $this->post['shift_id'];
        
        $data['shift_info'] = $this->common_model->get_shift($data);
        
        $this->output->add_to_position($this->load->view('frontend/shift_roster/shift_timing_view', $data, TRUE), 'shift_time', TRUE);
    }

    function load_team_list() {

        $data['schedule_date'] = $this->post['schedule_date'];
        $data['schedule_week'] = $this->post['schedule_week'];
        $data['schedule_end_week'] = $this->post['schedule_end_week'];
        $data['schedule_start_week'] = $this->post['schedule_start_week'];



        $data['schedule_month'] = $this->post['schedule_month'];
        $data['district_id'] = $this->post['district_id'];
         $district_code= $this->clg->clg_district_id;
        $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
        $data['district_id'] = $district_id;
       

        if ($data['schedule_date'] != '') {

            $data['end_date'] = date('Y-m-d', strtotime($data['schedule_date']));
            $data['start_date'] = date('Y-m-d', strtotime($data['schedule_date']));
        }

        if ($data['schedule_end_week'] != '' && $data['schedule_start_week'] != '') {

            $data['end_date'] = date('Y-m-d', strtotime($data['schedule_end_week']));
            $data['start_date'] = date('Y-m-d', strtotime($data['schedule_start_week']));
        }


        if ($data['schedule_month']) {
             //var_dump($data['schedule_month']);
             $month_date = explode("/",$data['schedule_month']);
             $month_date_start = $month_date[1].'-'.$month_date[0].'-01';
            
            $data['end_date'] = date('Y-m-t', strtotime( $month_date_start));
            $data['start_date'] = date('Y-m-d', strtotime( $month_date_start));
        }

        $earlier = new DateTime($data['start_date']);
        $later = new DateTime($data['end_date']);
        $diff = $later->diff($earlier)->format("%a");
        $data['schedule_count'] = $diff + 1;


        $this->output->add_to_position($this->load->view('frontend/shift_roster/shift_districts_view', $data, TRUE), 'shift_districts_id', TRUE );
        
        $this->output->add_to_position($this->load->view('frontend/shift_roster/load_team_list_view', $data, TRUE), 'team_listing_block', TRUE );
    }
    
    function load_district_wise_team_list(){
        
        
        $data['schedule_date'] = $this->post['schedule_date'];
        $data['schedule_week'] = $this->post['schedule_week'];
        $data['schedule_end_week'] = $this->post['schedule_end_week'];
        $data['schedule_start_week'] = $this->post['schedule_start_week'];



        $data['schedule_month'] = $this->post['schedule_month'];
        $data['district_id'] = $this->post['district_id'];

       

        if ($data['schedule_date'] != '') {

            $data['end_date'] = date('Y-m-d', strtotime($data['schedule_date']));
            $data['start_date'] = date('Y-m-d', strtotime($data['schedule_date']));
        }

        if ($data['schedule_end_week'] != '' && $data['schedule_start_week'] != '') {

            $data['end_date'] = date('Y-m-d', strtotime($data['schedule_end_week']));
            $data['start_date'] = date('Y-m-d', strtotime($data['schedule_start_week']));
        }


       if ($data['schedule_month']) {
             //var_dump($data['schedule_month']);
             $month_date = explode("/",$data['schedule_month']);
             $month_date_start = $month_date[1].'-'.$month_date[0].'-01';
            
            $data['end_date'] = date('Y-m-t', strtotime( $month_date_start));
            $data['start_date'] = date('Y-m-d', strtotime( $month_date_start));
        }

        $earlier = new DateTime($data['start_date']);
        $later = new DateTime($data['end_date']);
        $diff = $later->diff($earlier)->format("%a");
        $data['schedule_count'] = $diff + 1;


     
        
        $this->output->add_to_position($this->load->view('frontend/shift_roster/load_team_list_view', $data, TRUE), 'team_listing_block', TRUE );
        
    }
    function add_manage_team() {

        if ($this->post['submit_amb_team']) {

            $pilot = $this->post['pilot'];
            $emt = $this->post['emt'];
            $manage_date = $this->post['manage_date'];
            $shift = $this->post['manage_team_shift'];

            $rto_no = $this->post['rto_no'];


            if (array_filter($pilot) && array_filter($emt) && array_filter($manage_date)) {
                
                 for ($i = 0; $i < count($pilot); $i++) {

                    $emp_inc_data = $this->inc_model->get_amb_default_emp_shift($rto_no, $shift, $manage_date[$i]);
                    
                  
                    if (!($emp_inc_data)){
                        
                        $insert = $this->amb_model->insert_manage_team($pilot[$i], $emt[$i], $manage_date[$i], $rto_no, $shift);

                        if ($insert) {

                            $this->output->closepopup = 'yes';
                            $this->output->status = 1;
                            $this->output->message = "<div class='success'>" . "Manage team is added successfully" . "</div>";
                            $this->shift_amb_list();
                        } else {
                            $this->output->message = "<div class='error'>" . "Manage team is not added" . "</div>";
                        }

                    } else {
                            $this->output->message = "<div class='error'>" . "Dublicate entry for shift $shift st at date $manage_date[$i]" . "</div>";
                    }
                }
                
            } else {
                $this->output->message = "<div class='error'>Please select at least one EMT and PILOT....</div>";
            }
        }
    }

    function import_excel_team() {

        $data = array(
            'amb_id' => base64_decode($this->post['amb_id']),
            'amb_sts' => $this->post['amb_sts'],
            'amb_type' => $this->post['amb_type'],
            'cty_name' => $this->post['cty_name'],
            'rto_no' => $this->post['rto_no']
        );

        $data['get_amb_details'] = $this->amb_model->get_amb_data($data);

        $this->output->add_to_popup($this->load->view('frontend/shift_roster/import_excel_team_view', $data, TRUE), '800', '800');
    }

    function save_imported_excel_team() {
        $post_data = $this->input->post();
        $filename = $_FILES["file"]["tmp_name"];

        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($filename, "r");
            while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
                $column_count = count($getData);
                if ($column_count == 7) {

                    $emp_inc_data = $this->inc_model->get_amb_default_emp($getData[0], $getData[1], date('Y-m-d', strtotime($getData[2])));
                    if ($emp_inc_data) {
                        $team_data = array('tm_amb_rto_reg_id' => $getData[0],
                            'tm_shift' => $getData[1],
                            'tm_team_date' => date('Y-m-d', strtotime($getData[2])),
                            'tm_pilot_id' => $getData[3],
                            'tm_emt_id' => $getData[4],
                            'tmis_deleted' => $getData[5],
                            'tmis_absent' => $getData[6],
                            'modify_date_sync' => date('Y-m-d H:i:s'));

                        $insert = $this->amb_model->insert_excel_manage_team($team_data);
                    } else {
                        $message = "Dublicate entry";
                        //$this->output->message = "<div class='error'>" . "Dublicate entry" . "</div>";
                    }
                } else {
                    $message = "Manage team column count not match";
                    //$this->output->message = "<div class='error'>" . "Manage team column count not match" . "</div>";
                }
            }
            if ($insert) {

                $this->output->closepopup = 'yes';
                $this->output->status = 1;
                $this->output->message = "<div class='success'>" . "Manage team is added successfully" . "</div>";
                $this->shift_amb_list();
            } else {
                $this->output->message = "<div class='error'>" . $message . "</div>";
            }
        }
    }

}