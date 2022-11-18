<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shiftmanager extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->active_module = "M-LOGIN";
        $this->pg_limit = $this->config->item('pagination_limit');
        $this->load->library(array('session', 'modules'));
        $this->load->model(array('module_model', 'colleagues_model', 'quality_model', 'call_model', 'feedback_model', 'inc_model', 'shiftmanager_model','problem_reporting_model'));
        $this->load->helper(array('comman_helper'));
        $this->post = $this->input->get_post(NULL);
        $this->post['base_month'] = get_base_month();
        $this->clg = $this->session->userdata('current_user');
        $this->post['base_month'] = get_base_month();
        $this->today = date('Y-m-d H:i:s');
        if ($this->session->userdata('filters')) {

            $this->fdata = $this->session->userdata('filters');
        }
    }

    public function index($generated = false) {
        echo "You are in the Shiftmanager Controllers";
    }

    function login() {
       $data['gr'] = $this->clg->clg_group;
        $this->output->add_to_position($this->load->view('frontend/shiftmanager/login_dashborad_views', $data, TRUE), 'content', TRUE);
    }

    function show_user_list() {

        $user_group = $this->post['team_type'];

        ///////////limit & offset////////

        $data['get_count'] = TRUE;

        //$data['clg_group'] = $user_group;
        $data['clg_group'] =str_replace(",","','",$user_group);

        $data['total_count'] = $this->colleagues_model->get_all_colleagues($data);
        if( $data['clg_group'] != ""){
            $this->session->set_userdata('clg_group',$data['clg_group']);
        }


        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        $clg_group_session =$this->session->userdata('clg_group');

        //$config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $data['clg_group'] = ( $data['clg_group']) ?  $data['clg_group'] : $clg_group_session;

        
        
        $this->session->set_userdata('clg_group', $data['clg_group']);

        //$page_no = get_pgno($data['total_count'], $limit, $page_no);
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        unset($data['get_count']);

        $data['result_data'] = $this->colleagues_model->get_all_colleagues($data, $offset, $limit);

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("shiftmanager/show_user_list"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        $data['pgconf'] = $pgconf;
        $data['pagination'] = get_pagination($pgconf);


        $data['page_records'] = $data['total_count'];

        $this->output->add_to_position($this->load->view('frontend/shiftmanager/show_user_list_view', $data, TRUE), 'list_user_table', TRUE);
    }

    function show_user_data(){
        $login_logout_load= $this->post['login_logout_load'];
        if($login_logout_load == 'view_login_details'){
            $this->output->add_to_position($this->load->view('frontend/shiftmanager/login_details_button_view', $data, TRUE), 'login_logout_search_btn', TRUE);
        }else if($login_logout_load == 'view_break_details'){
            $this->output->add_to_position($this->load->view('frontend/shiftmanager/break_details_button_view', $data, TRUE), 'login_logout_search_btn', TRUE);
        }
    }
    function view_login_details() {

        $ref_id = $this->post['ref_id'];

        $data['ref_id'] = $this->post['ref_id'];
        $this->session->set_userdata('ref_id', $ref_id);


        //$this->output->add_to_position($this->load->view('frontend/shiftmanager/view_login_details', $data, TRUE), $output_position, TRUE);
        $this->output->add_to_position($this->load->view('frontend/shiftmanager/view_login_details', $data, TRUE), 'list_user_table', TRUE);
    }

    function view_break_form() {

        $ref_id = $this->post['ref_id'];


        $data['ref_id'] = $this->post['ref_id'];

        $this->session->set_userdata('clg_id', $ref_id);


       // $this->output->add_to_position($this->load->view('frontend/shiftmanager/view_break_details', $data, TRUE), $output_position, TRUE);
        $this->output->add_to_position($this->load->view('frontend/shiftmanager/view_break_details', $data, TRUE), 'list_user_table', TRUE);
    }

    function search_login_details() {


        $ref_id = $this->session->userdata('ref_id');
        $ref_id = $this->post['user_id'];

        $form_date = $this->post['from_date'];
        $to_date = $this->post['to_date'];
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->post['pg_rec'];
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        
         ///////////set page number////////////////////

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
         //var_dump($form_date); die; 

        $this->session->set_userdata('form_date', $form_date);

        $data['search_date'] = $this->post['from_date'];
        
        $team_type =$data['team_type'] = $this->post['team_type'];
      
        $data['ref_id'] = $ref_id;
//var_dump($data);die;
        $this->post = $this->input->post();
        
        $this->post['base_month'] = get_base_month();
        $data['action_type'] = $this->post['action_type'];
        if ($form_date != '') {
            $data['from_date'] = date('Y-m-d', strtotime($form_date));
            $data['to_date'] = date('Y-m-d', strtotime($to_date));
        }

        if($this->clg->clg_group == 'UG-QualityManager'){
            $clg_args = array('clg_group'=>'UG-Quality');
            $data['ero_clg'] = $this->colleagues_model->get_clg_data($clg_args);
            
            foreach($data['ero_clg'] as $ero){
                $child_ero[] = $ero->clg_ref_id;
            }
            if(is_array($child_ero)){
                $child_ero = implode("','", $child_ero);
            }
            
            
            if ( $ref_id != '' && $ref_id != 'all') {
                $args_dash['clg_ref_id'] = $ref_id;
            }else{
                $args_dash['clg_ref_id'] = $child_ero;
            }
        }
        
        $args_dash = array(
            'clg_ref_id' => $ref_id,
            'base_month' => $this->post['base_month'],
            'team_type' => $data['team_type'],
            'from_date' => $data['from_date'],
            'to_date' => $data['to_date']
        );
        


       //var_dump($args_dash); die; 
        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        $inc_info = $this->shiftmanager_model->get_login_details($args_dash, $offset, $limit);
        $inc_info_dw = $this->shiftmanager_model->get_login_details($args_dash);
        $header = array('Login User name','Login Time', 'Logout Time', 'Total Hours');

        if ($data['action_type'] == 'View') {
            $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

            $page_no = 1;

            if ($this->uri->segment(3)) {
                $page_no = $this->uri->segment(3);
            } else if ($this->fdata['page_no'] && !$this->post['flt']) {
                $page_no = $this->fdata['page_no'];
            }
            $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;



            $inc_data = (object) array();

            $data['per_page'] = $limit;

            $data['inc_info'] = $inc_info;

            $qa_name = get_clg_data_by_ref_id($ref_id);

            $data['clg_name'] = ucwords($qa_name[0]->clg_first_name . ' ' . $qa_name[0]->clg_mid_name . ' ' . $qa_name[0]->clg_last_name);

            $args_dash['get_count'] = TRUE;

            $total_cnt = $this->shiftmanager_model->get_login_details($args_dash);

            $data['inc_total_count'] = $total_cnt;
            $data['inc_offset'] = $offset;
            $data['per_page'] = $limit;


            $pgconf = array(
                'url' => base_url("shiftmanager/pagination_login_details"),
                'total_rows' => $total_cnt,
                'per_page' => $limit,
                'cur_page' => $page_no,
                'uri_segment' => 3,
                'use_page_numbers' => TRUE,
                'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc&from_date=$form_date&to_date=$to_date&pg_rec=$pg_rec&team_type=$team_type"
                )
            );


            $config = get_pagination($pgconf);
            $data['pagination'] = get_pagination($pgconf);

            $this->output->add_to_position($this->load->view('frontend/shiftmanager/view_search_details', $data, TRUE), 'list_user_table', TRUE);
            
        } else {
                  

            $filename = "user_wise_login_deatails_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);

            fputcsv($fp, $header);

            $row1 = array();
            foreach ($inc_info_dw as $row) {


                $d_start = new DateTime($row->clg_login_time);
                $d_end = new DateTime($row->clg_logout_time);
                $resonse_time = $d_start->diff($d_end);                
                $resonse_time = $resonse_time->h . ':' . $resonse_time->i . ':' . $resonse_time->s;
                $login_time = date("d-m-Y h:i:s", strtotime($row->clg_login_time));
                $logout_time = date("d-m-Y h:i:s", strtotime($row->clg_logout_time));
               $caller_name = ucwords($row->clg_first_name . "  " . $row->clg_last_name);
               
                if($row->clg_logout_time != "0000-00-00 00:00:00"){ 

                    $d_start = strtotime($row->clg_login_time);
                    $d_end   = strtotime($row->clg_logout_time);
                    $time_diff = $d_end - $d_start;
                    $total_time = $total_time + $time_diff;

                    $hours   = floor( $time_diff / 3600);
                    $minutes = $time_diff / 60 % 60;
                    $seconds = $time_diff % 60;

                    $hours   = str_pad( $hours,   2, '0', STR_PAD_LEFT);
                    $minutes = str_pad( $minutes, 2, '0', STR_PAD_LEFT);
                    $seconds = str_pad( $seconds, 2, '0', STR_PAD_LEFT);

                    $resonse_time = $hours.':'.$minutes.':'.$seconds;

                }
               if($row->clg_logout_time == "0000-00-00 00:00:00"){ $logout_time1 =  "Currently Login"; }else{ $logout_time1 = date("d-m-Y h:i:s", strtotime($row->clg_logout_time)); }
               
               if($logout_time == "0000-00-00 00:00:00"){ $resonse_time = "Currently Login"; }else{$resonse_time = $resonse_time;}
               
               $row1['Login user'] = $caller_name;
               $row1['Login Time'] = $login_time;
               $row1['Logout Time'] = $logout_time1;
               $row1['Total Hours'] = $resonse_time;
               fputcsv($fp, $row1);
            }
            
            $hours   = floor( $total_time / 3600);
            $minutes = $total_time / 60 % 60;
            $seconds = $total_time % 60;
            $tatal_hours =  $hours.':'.$minutes.':'.$seconds;
            
            $footer = array('','', 'Total Time', $tatal_hours);
            fputcsv($fp, $footer);

            fclose($fp);
            exit;

               


/*

//            $filename = "user_wise_login_logout_deatails_report.csv";
//            $fp = fopen('php://output', 'w');
//            header('Content-type: application/csv');
//            header('Content-Disposition: attachment; filename=' . $filename);
            $today_date = date("Y-m-d");
            $date_time = explode(" ", $today_date);
            $exploded_date = $date_time[0];
            $date = date('d-m-Y', strtotime($exploded_date));
            $time = date("h:i:s A");
            $datas .= '<div align="Right">
					<span>Print on ' . $date . ' ' . $time . '</span><br>
//					</div>';
//            $datas .= '<div align="center">
//					<span><b>Spero Healthcare Innovations Pvt. Ltd - ' . $financial_year . '</b></span><br>
//					<span><b>Cash - Service -' . $branch . ' Book</span></b><br>
//					<span>Cash - In - hand</span><br>
//					</div>';
            $datas .= '<table cellpadding="1" cellspacing="1" align="left" border="1" id="mainTableBg">
                        <tr height="30">
					<th width="5%">Date</th>
					<th width="5%">Particulars</th>
                    <th width="5%">Vch Type</th>
					<th width="5%">Vch No./Excise Inv.No.</th>
					<th width="5%">Type</th>
                    <th width="5%">Debit</th>
                        </tr>';
            $filepath = base_url() . "uploads/" . time() . "DayPrintList.csv";
           // var_dump($datas);
            //die();
            $file = fopen($filepath, "w");
            fwrite($file, $datas);
            fclose($file);
            header("Content-Disposition: attachment; filename=DayPrintList" . date("Y-m-d") . ".csv");
            header("Content-Type: application/vnd.ms-excel");
            readfile($filepath);
            unlink($filepath);
//    fputcsv($fp, $datas);
//
//            $row1 = array();
//            foreach ($data['inc_info'] as $row) {
//                $d_start = new DateTime($row->clg_login_time);
//                $d_end = new DateTime($row->clg_logout_time);
//                $resonse_time = $d_start->diff($d_end);
//                $resonse_time = $resonse_time->h . ':' . $resonse_time->i . ':' . $resonse_time->s;
//                $login_time = date("d-m-Y h:i:s", strtotime($row->clg_login_time));
//                $logout_time = date("d-m-Y h:i:s", strtotime($row->clg_logout_time));
//                $row1['Login Time'] = $login_time;
//                $row1['Logout Time'] = $logout_time;
//                $row1['Total Hours'] = $resonse_time;
//                fputcsv($fp, $row1);
//            }
//
//            fclose($fp);
//            exit;
*/
        }
        
    }

    function search_break_details() {

        $ref_id = $this->session->userdata('clg_id');
        $ref_id = $this->post['user_id'];
       
        $pg_rec = $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;



        $form_date = $this->post['from_date'];
        $to_date = $this->post['to_date'];
        $team_type =$data['team_type'] =$args_dash['team_type'] = $this->post['team_type'];

        $this->session->set_userdata('brk_form_date', $form_date);
        $this->session->set_userdata('brk_to_date', $to_date);
        $this->session->set_userdata('team_type', $team_type);
        $this->session->set_userdata('user_id', $ref_id);
        
        $data['search_date'] = $this->post['from_date'];
        $data['search_date2'] = $this->post['to_date'];

        $data['ref_id'] = $ref_id;

        $this->post = $this->input->post();
        $this->post['base_month'] = get_base_month();
        $data['action_type'] = $this->post['action_type'];

        $args_dash = array(
            'clg_ref_id' => $ref_id,
            'base_month' => $this->post['base_month'],
        );
        if ($form_date != '') {
            $args_dash['from_date'] = date('Y-m-d', strtotime($form_date));
        }


        if ($to_date != '') {
            $args_dash['to_date'] = date('Y-m-d', strtotime($to_date));
        }
        if ($team_type != '') {
            $args_dash['team_type'] = $team_type;
        }
        $page_no = 1;
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        
       $inc_info = $this->shiftmanager_model->get_break_details_by_user($args_dash, $offset, $limit);
        
       $inc_info_dw = $this->shiftmanager_model->get_break_details_by_user($args_dash);
        $header = array('User Name','User ID','Break  Time', 'Break To Back Time', 'Break Duration', 'Break Reason');

        if ($data['action_type'] == 'View') {

            $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];


            $page_no = 1;

            if ($this->uri->segment(3)) {
                $page_no = $this->uri->segment(3);
            } else if ($this->fdata['page_no'] && !$this->post['flt']) {
                $page_no = $this->fdata['page_no'];
            }
            $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


//            $args_dash = array(
//                'clg_ref_id' => $ref_id,
//                'base_month' => $this->post['base_month']
//            );

            $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

            $data['page_no'] = $page_no;
            $qa_name = get_clg_data_by_ref_id($ref_id);

            $data['clg_name'] = ucwords($qa_name[0]->clg_first_name . ' ' . $qa_name[0]->clg_mid_name . ' ' . $qa_name[0]->clg_last_name);

            $inc_data = (object) array();

            $data['per_page'] = $limit;

            $data['inc_info'] = $inc_info;

            $args_dash['get_count'] = TRUE;

            $total_cnt = $this->shiftmanager_model->get_break_details_by_user($args_dash);

            $data['inc_total_count'] = $total_cnt;
            $data['inc_offset'] = $offset;
            $data['per_page'] = $limit;


            $pgconf = array(
                'url' => base_url("shiftmanager/pg_brk_details"),
                'total_rows' => $total_cnt,
                'per_page' => $limit,
                'cur_page' => $page_no,
                'uri_segment' => 3,
                'use_page_numbers' => TRUE,
                'attributes' => array('class' => 'click-xhttp-request',
                    'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc&from_date=$form_date&to_date=$to_date&pg_rec=$pg_rec&team_type=$team_type"
                )
            );


            $config = get_pagination($pgconf);
            $data['pagination'] = get_pagination($pgconf);

            $this->output->add_to_position($this->load->view('frontend/shiftmanager/view_brk_details', $data, TRUE), 'list_user_table', TRUE);
        } else {

            $filename = "user_wise_break_deatails_report.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);

            fputcsv($fp, $header);

            $row1 = array();
            foreach ($inc_info_dw as $row) {
                
            
                date_default_timezone_set("Asia/Calcutta"); 
                
                if($row->clg_back_to_break_time != "0000-00-00 00:00:00"){ 

                    $d_start = strtotime($row->clg_break_time);
                    $d_end   = strtotime($row->clg_back_to_break_time);
                    $time_diff = $d_end - $d_start;
                    $total_time = $total_time + $time_diff;

                    $hours   = floor( $time_diff / 3600);
                    $minutes = $time_diff / 60 % 60;
                    $seconds = $time_diff % 60;

                    $hours   = str_pad( $hours,   2, '0', STR_PAD_LEFT);
                    $minutes = str_pad( $minutes, 2, '0', STR_PAD_LEFT);
                    $seconds = str_pad( $seconds, 2, '0', STR_PAD_LEFT);

                    $resonse_time = $hours.':'.$minutes.':'.$seconds;

                }
            
                $row1['User name'] = ucwords($row->clg_first_name.' '.$row->clg_middle_name.' '.$row->clg_last_name);
                $row1['User ID'] = $row->clg_ref_id;
                $row1['Break  Time'] = date("d-m-Y H:i:s", strtotime($row->clg_break_time));
                $row1['Break To Back Time'] = date("d-m-Y H:i:s", strtotime($row->clg_back_to_break_time));
                $row1['Break Duration'] = $resonse_time;
                $row1['Break Reason'] = $row->break_name;
                fputcsv($fp, $row1);
            }
            
            $hours   = floor( $total_time / 3600);
            $minutes = $total_time / 60 % 60;
            $seconds = $total_time % 60;
            $Total_time =  $hours.':'.$minutes.':'.$seconds;
            
            $footer = array('','','', 'Total Time', $Total_time, '');
            fputcsv($fp, $footer);



            fclose($fp);
            exit;
        }
    }

    function pagination_login_details() {



        $ref_id = $this->session->userdata('ref_id');


       // $form_date = $this->session->userdata('form_date');
        $form_date = $data['from_date'] = $this->post['from_date'];
        $to_date= $data['to_date'] = $this->post['to_date'];

        $data['ref_id'] = $ref_id;

        $this->post = $this->input->post();
        $this->post['base_month'] = get_base_month();


        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];


        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


        $args_dash = array(
            'clg_ref_id' => $ref_id,
            'base_month' => $this->post['base_month']
        );

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        if ($form_date != '') {
            $args_dash['from_date'] = date('Y-m-d', strtotime($form_date));
        }


        if ($to_date != '') {
            $args_dash['to_date'] = date('Y-m-d', strtotime($to_date));
        }
        $team_type =$data['team_type'] =$args_dash['team_type'] = $this->post['team_type'];

        $inc_info = $this->shiftmanager_model->get_login_details($args_dash, $offset, $limit);


        $inc_data = (object) array();

        $data['per_page'] = $limit;

        $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;

        $total_cnt = $this->shiftmanager_model->get_login_details($args_dash);

        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("shiftmanager/pagination_login_details"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
            'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc&from_date=$form_date&to_date=$to_date&pg_rec=$pg_rec&team_type=$team_type"
            )
        );


        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);

        $this->output->add_to_position($this->load->view('frontend/shiftmanager/view_search_details', $data, TRUE), 'list_user_table', TRUE);
    }

    function pg_brk_details() {

        $clg_ref_id = $this->session->userdata('clg_id');


        $brk_form_date = $this->session->userdata('brk_form_date');
        $brk_to_date = $this->session->userdata('brk_to_date');
        $team_type = $this->session->userdata('team_type');
        $user_id= $this->session->userdata('user_id');
        

        $data['ref_id'] = $clg_ref_id;

        $this->post = $this->input->post();
        $this->post['base_month'] = get_base_month();


        $pg_rec = $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];


        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


        $args_dash = array(
            'clg_ref_id' => $clg_ref_id,
            'base_month' => $this->post['base_month']
        );

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        if ($brk_form_date != '') {
            $args_dash['from_date'] = date('Y-m-d', strtotime($brk_form_date));
        }
        if ($brk_to_date != '') {
            $args_dash['to_date'] = date('Y-m-d', strtotime($brk_to_date));
        }
        if ($team_type != '') {
            $args_dash['team_type'] = $team_type;
        }
        if ($user_id != '') {
            $args_dash['clg_ref_id'] = $user_id;
        }
        
        $inc_info = $this->shiftmanager_model->get_break_details_by_user($args_dash, $offset, $limit);


        $inc_data = (object) array();

        $data['per_page'] = $limit;

        $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;

        $total_cnt = $this->shiftmanager_model->get_break_details_by_user($args_dash);

        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("shiftmanager/pg_brk_details"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc&from_date=$form_date&to_date=$to_date&pg_rec=$pg_rec&team_type=$team_type"
            )
        );


        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);

        $this->output->add_to_position($this->load->view('frontend/shiftmanager/view_brk_details', $data, TRUE), 'list_user_table', TRUE);
    }
    
    function shiftmanager_call_details(){
        
        if (!isset($this->post['inc_ref_id'])) {

            $data['opt_id'] = $this->post['opt_id'];

            $data['sub_id'] = $this->post['sub_id'];

            $args = array('opt_id' => $data['opt_id'],
                'sub_id' => $data['sub_id'],
                'sub_type' => 'ADV');

            update_opt_status($args);

            $args = array(
                'sub_id' => $data['sub_id'],
                'operator_id' => $this->clg->clg_ref_id,
                'operator_type' => $this->clg->clg_group,
                'base_month' => $this->post['base_month'],
                'sub_type' => 'ADV',
                'sub_status' => 'ATNG'
            );



            $this->common_model->assign_operator($args);


            $args = array(
                'opt_id' => $data['opt_id'],
                'sub_id' => $data['sub_id'],
                'base_month' => $this->post['base_month']
            );

            $data['cl_dtl'] = $this->Medadv_model->call_detials($args);
        } else {

            $args = array(
                'inc_ref_id' => trim($this->post['inc_ref_id']),
            );

            $data['inc_ref_id'] = trim($this->post['inc_ref_id']);

            $this->session->set_userdata('es_inc_ref_id', $this->post['inc_ref_id']);

            $data['cl_dtl'] = $this->problem_reporting_model->get_grivance_call_detials($args);

            $this->session->set_userdata('caller_information', $data['cl_dtl']);
            $this->session->set_userdata('inc_ref_id', $data['inc_ref_id']);

            $args_remark = array('re_id' => $data['cl_dtl'][0]->inc_ero_standard_summary);
            $standard_remark = $this->call_model->get_ero_summary_remark($args_remark);
            $data['re_name'] = $standard_remark[0]->re_name;
        }

        if (empty($data['cl_dtl'])) {
            $this->output->message = "<p>No Record Found</p>";

            return;
        }

        $this->output->add_to_position($this->load->view('frontend/shiftmanager/shiftmanager_inc_details_view', $data, TRUE), 'content', TRUE);
    }
    function save_shift_call() {

        $inc_id = $this->post['sf']['sf_inc_ref_id'];


        if ($inc_id == '') {
            $inc_id = generate_shiftmanager_inc_ref_id();
            update_shiftmanager_inc_ref_id($inc_id);
        }
        $sf = $this->post['sf'];


        $args = array(
            'sf_pre_inc_ref_id'=>$this->post['inc_ref_id'],
            'sf_base_month' => $this->post['base_month'],
            'added_date' => $this->today,
            'added_by' => $this->clg->clg_ref_id,
            'modify_date' => $this->today,
            'modify_by' => $this->clg->clg_ref_id,
        );


        if ($this->post['sf']['sf_inc_ref_id'] == '') {
            $args['sf_inc_ref_id'] = 'SF-' . $inc_id;
        }


        $args = array_merge($this->post['sf'], $args);


        $shiftmanager = $this->shiftmanager_model->add_shiftmanager_call($args);

        $shiftmanager_operator = array(
            'sub_id' => $this->post['inc_ref_id'],
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'sub_status' => 'ATND',
        );

        $shiftmanager_args = array(
            'sub_id' => $this->post['inc_ref_id'],
            'operator_type' => $this->clg->clg_group,
        );

        $shiftmanager = $this->common_model->update_operator($shiftmanager_args, $shiftmanager_operator);

        if ($shiftmanager) {

            $this->output->message = "<div class='success'>Details saved successfully</div><script>window.location.reload(true);</script>";
        }
    }
     
}
