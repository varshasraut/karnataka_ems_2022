<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule_crud extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->active_module = "M-SCH-CRUD";
        $this->pg_limit = $this->config->item('pagination_limit');
        $this->load->library(array('session', 'modules'));
        $this->load->model(array('colleagues_model','common_model','schedule_crud_model', 'schedule_model'));

        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper', 'language_helper'));

        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));

        $this->post = $this->input->get_post(NULL);
        $this->post['base_month'] = get_base_month();
        $this->clg = $this->session->userdata('current_user');
    }

    public function index($generated = false) {
                ///////////////  Filters //////////////////

        $data['search'] = ($this->post['search']) ? $this->post['search'] : $this->fdata['search'];
        $data['search_status'] = ($this->post['search_status']) ? $this->post['search_status'] : $this->fdata['search_status'];
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        if ($this->post['from_date'] != '') {
            $data['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date']));
        }

        if ($this->post['to_date'] != '') {
            $data['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->post['to_date']));
        }

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }

        ///////////limit & offset////////

        $data['get_count'] = TRUE;
        if($this->clg->clg_group == "UG-ShiftManager"){
            $data['curr_user']="all";
        }else{
            $data['curr_user'] = $this->clg->clg_ref_id;
        }
        
        $data['total_count'] = $this->schedule_crud_model->get_crud_data($data);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        unset($data['get_count']);

        $data['crud_data'] = $this->schedule_crud_model->get_crud_data($data, $offset, $limit);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("schedule_crud/index"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
            'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        $data['pgconf'] = $pgconf;
        $data['pagination'] = get_pagination($pgconf);

        /////////////////////////////////

        $data['page_records'] = $data['total_count'];


       $this->output->add_to_position($this->load->view('frontend/schedule_crud/list_schedule_crud_views', $data, TRUE), 'content', TRUE);
    }

    public function schedule_crud_filter() {
        ///////////////  Filters //////////////////
        $data['call_search'] = ($this->post['call_search']) ? $this->post['call_search'] : $this->fdata['call_search'];

        $data['search'] = ($this->post['search']) ? $this->post['search'] : $this->fdata['search'];
        $data['search_status'] = ($this->post['search_status']) ? $this->post['search_status'] : $this->fdata['search_status'];
        $data['pg_rec']= $pg_rec = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];


        if ($this->post['team_type'] != '') {
            $team_type = $args_dash['team_type'] = $data['team_type'] = $this->post['team_type'];
        }
        if ($this->post['user_id'] != '') {
            $data['ero_clg'] =$user_id = $data['user_id'] = $this->post['user_id'];
        }
        if ($this->post['call_search'] != '') {
            $data['call_search'] = $this->post['call_search'];

            $call_search = $data['call_search'] = $this->post['call_search'];
        }

        if ($this->post['from_date'] != '') {
            $data['from_date']=$from_date = $this->input->post('from_date');
            $data['month'] = date('n', strtotime($this->input->post('from_date')));
            $data['year'] = date('Y', strtotime($this->input->post('from_date')));
            
             
        }
        $data['base_month']=$this->post['base_month'];
       // var_dump($data);
       // die();

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }

///////////limit & offset////////

        $data['get_count'] = TRUE;
        if ($this->clg->clg_group == "UG-ShiftManager") {
           // $data['curr_user'] = "all";
        } else {
           // $data['curr_user'] = $this->clg->clg_ref_id;
        }

        $data['total_count'] = $this->schedule_crud_model->get_crud_data($data);
//var_dump($data['total_count']);die;
        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        unset($data['get_count']);

        $data['crud_data'] = $this->schedule_crud_model->get_crud_data($data, $offset, $limit);

/////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("schedule_crud/schedule_crud_filter"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&from_date=$from_date&call_search=$call_search&team_type=$team_type&user_id=$user_id&pg_rec=$pg_rec"
            )
        );

        $data['pgconf'] = $pgconf;
        $data['pagination'] = get_pagination($pgconf);

/////////////////////////////////

        $data['page_records'] = $data['total_count'];


        $this->output->add_to_position($this->load->view('frontend/schedule_crud/list_schedule_crud_views', $data, TRUE), 'content', TRUE);
    }

    public function add_crud(){
        
        $data['amb_action'] = $this->input->post('amb_action');
        
        if ($this->post['schedule_id'] != '') {
            $schedule_id =  $this->post['schedule_id'];
            $args_sc = array('sc_cr_id'=>$schedule_id);
            $data['inc_emp_info'] = $this->schedule_crud_model->get_crud_data($args_sc);
            $data['shift_schedule'] = $this->schedule_crud_model->get_schedule($args_sc);
            //print_r($data['shift_schedule']);die;
        }
        $data['shift_info'] = $this->common_model->get_shift($args);
        $data['shiftmanager']=$this->clg->clg_ref_id;
        $data['group_info'] = $this->colleagues_model->get_groups();
        $data['clg_group'] = $this->clg->clg_group;
       
        $this->output->add_to_position($this->load->view('frontend/schedule_crud/add_schedule_crud_views', $data, TRUE), 'popup_div', TRUE);
    }
    
    public function import_crud(){
        $this->output->add_to_position($this->load->view('frontend/schedule_crud/import_crud_view', $data, TRUE), 'popup_div', TRUE);
    }

    public function load_user_by_group(){
        $data['clg_group'] = $this->post['clg_group'];
        $this->output->add_to_position($this->load->view('frontend/schedule_crud/load_user_by_group', $data, TRUE), 'load_user_by_group', TRUE);
    }
    
    function save_import_crud(){
        
        $post_data = $this->input->post();
        
        $filename=$_FILES["file"]["tmp_name"];   
      
        if($_FILES["file"]["size"] > 0) {
        $file = fopen($filename, "r");
        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE){
            $column_count = count($getData);
          //  var_dump($column_count); die;
                if($column_count >= 33){

                    $args = array(
                        'schedule_month'=>$post_data['schedule_month'],
                        'schedule_year'=>$post_data['schedule_year'],
                        'user_id'=>$getData[0],
                        'user_name'=>$getData[1],
                        'user_group'=>$getData[2],
                        'schedule_type'=>$getData[3],
                        'ero_supervisor'=>$getData[4],
                        'shift_supervisor'=>$getData[5],
                        '1'=>$getData[6],
                        '2'=>$getData[7],
                        '3'=>$getData[8],
                        '4'=>$getData[9],
                        '5'=>$getData[10],
                        '6'=>$getData[11],
                        '7'=>$getData[12],
                        '8'=>$getData[13],
                        '9'=>$getData[14],
                        '10'=>$getData[15],
                        '11'=>$getData[16],
                        '12'=>$getData[17],
                        '13'=>$getData[18],
                        '14'=>$getData[19],
                        '15'=>$getData[20],
                        '16'=>$getData[21],
                        '17'=>$getData[22],
                        '18'=>$getData[23],
                        '19'=>$getData[24],
                        '20'=>$getData[25],
                        '21'=>$getData[26],
                        '22'=>$getData[27],
                        '23'=>$getData[28],
                        '24'=>$getData[29],
                        '25'=>$getData[30],
                        '26'=>$getData[31],
                        '27'=>$getData[32],
                        '28'=>$getData[33],
                        'added_date'=> date('Y-m-d H:i:s'),
                        //'added_by'=>$getData[36],
                        //'modify_by'=>$getData[13],
                      
                    );
                    if($getData[34] != ''){
                         $args['29']=$getData[34];
                    }
                    if($getData[35] != ''){
                         $args['30']=$getData[35];
                    }
                    if($getData[36] != ''){
                         $args['31']=$getData[36];
                    } 
                    $args['modify_date']= date('Y-m-d H:i:s');
                    $args['crud_base_month'] = $this->post['base_month'];

                    $insert = $this->schedule_crud_model->import_crud($args);
                    //var_dump($insert);
                    //die();
                 
                }else {
                    $this->output->message = "<div class='error'>" . "Schedule curd column count not match" . "</div>";
                }

            }
            if ($insert) {

                    $this->output->closepopup = 'yes';
                    $this->output->status = 1;
                    $this->output->message = "<div class='success'>" . "File imported successfully" . "</div>";
                    //$this->amb_listing();
                    $this->index();
                } else {
                    $this->output->closepopup = 'no';
                    $this->output->message = "<div class='error'>" . "Import file is not added" . "</div>";
                }
            
        }
        
     
    }
    public function view_crud_dash(){
        
        $args['clg_ref_id']=$this->input->post('clg_ref_id');
        $schedule_id = $this->schedule_crud_model->get_crud_last_id($args);
        //var_dump($schedule_id); die;
        $args_sc = $schedule_id[0];
        //print_r($args_sc);die;
        
        $data['inc_emp_info'] = $this->schedule_crud_model->get_crud_data($args_sc);  
        $year = $data['inc_emp_info'][0]->schedule_year;
        $month = $data['inc_emp_info'][0]->schedule_month;  
    
        
        $prefs['template'] = '

        {table_open}<table border="0" cellpadding="0" cellspacing="0">{/table_open}

        {heading_row_start}<tr>{/heading_row_start}

        {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
        {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
        {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

        {heading_row_end}</tr>{/heading_row_end}

        {week_row_start}<tr>{/week_row_start}
        {week_day_cell}<td>{week_day}</td>{/week_day_cell}
        {week_row_end}</tr>{/week_row_end}

        {cal_row_start}<tr>{/cal_row_start}
        {cal_cell_start}<td>{/cal_cell_start}
        {cal_cell_start_today}<td>{/cal_cell_start_today}
        {cal_cell_start_other}<td class="other-month">{/cal_cell_start_other}

        {cal_cell_content}{day}<br><span class="caldata">{content}</span>{/cal_cell_content}
        {cal_cell_content_today}<div class="highlight">{day}<br>{content}</div>{/cal_cell_content_today}

        {cal_cell_no_content}{day}{/cal_cell_no_content}
        {cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}

        {cal_cell_blank}&nbsp;{/cal_cell_blank}

        {cal_cell_other}{day}{/cal_cel_other}

        {cal_cell_end}</td>{/cal_cell_end}
        {cal_cell_end_today}</td>{/cal_cell_end_today}
        {cal_cell_end_other}</td>{/cal_cell_end_other}
        {cal_row_end}</tr>{/cal_row_end}

        {table_close}</table>{/table_close}
';
 
      $this->load->library('calendar',$prefs);
      if (!empty($args_sc)) {
      $arr = $this->schedule_crud_model->get_crud_cal_data_ero_wise($args_sc); 
      //print_r($arr);die;
      $a = array();
      $b = array();
      
      foreach($arr as $arr1){
        $a1 = $arr1['day'];
        array_push($a,$a1);
        $b1 = $arr1['shift'];
        array_push($b,$b1);
      }
      $c = array_combine($a,$b);
      //echo '<pre>';
      //print_r($c);die;
      
      $data['cal']= $this->calendar->generate($year, $month, $c);
      }else{    
    $data['cal']="";
      }
        $this->output->add_to_position($this->load->view('frontend/schedule_crud/schedule_crud_dash', $data, TRUE), 'popup_div', TRUE);
    }
    public function view_crud(){
        $schedule_id = $this->post['schedule_id'];
        $args_sc = array('sc_cr_id'=>$schedule_id);
        $data['inc_emp_info'] = $this->schedule_crud_model->get_crud_data($args_sc);  
        $year = $data['inc_emp_info'][0]->schedule_year;
        $month = $data['inc_emp_info'][0]->schedule_month;  
        
        $prefs['template'] = '

        {table_open}<table border="0" cellpadding="0" cellspacing="0">{/table_open}

        {heading_row_start}<tr>{/heading_row_start}

        {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
        {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
        {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

        {heading_row_end}</tr>{/heading_row_end}

        {week_row_start}<tr>{/week_row_start}
        {week_day_cell}<td>{week_day}</td>{/week_day_cell}
        {week_row_end}</tr>{/week_row_end}

        {cal_row_start}<tr>{/cal_row_start}
        {cal_cell_start}<td>{/cal_cell_start}
        {cal_cell_start_today}<td>{/cal_cell_start_today}
        {cal_cell_start_other}<td class="other-month">{/cal_cell_start_other}

        {cal_cell_content}{day}<br>{content}{/cal_cell_content}
        {cal_cell_content_today}<div class="highlight">{day}<br>{content}</div>{/cal_cell_content_today}

        {cal_cell_no_content}{day}{/cal_cell_no_content}
        {cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}

        {cal_cell_blank}&nbsp;{/cal_cell_blank}

        {cal_cell_other}{day}{/cal_cel_other}

        {cal_cell_end}</td>{/cal_cell_end}
        {cal_cell_end_today}</td>{/cal_cell_end_today}
        {cal_cell_end_other}</td>{/cal_cell_end_other}
        {cal_row_end}</tr>{/cal_row_end}

        {table_close}</table>{/table_close}
';
 
      $this->load->library('calendar',$prefs);
      $arr = $this->schedule_crud_model->get_crud_cal_data_ero_wise($args_sc); 
      $a = array();
      $b = array();
      //if (!empty($arr)) {
      foreach($arr as $arr1){
        $a1 = $arr1['day'];
        array_push($a,$a1);
        $b1 = $arr1['shift'];
        array_push($b,$b1);
      }
      $c = array_combine($a,$b);
      $data['cal']= $this->calendar->generate($year, $month, $c);
   // }
        $this->output->add_to_position($this->load->view('frontend/schedule_crud/schedule_crud_views', $data, TRUE), 'popup_div', TRUE);
    }
    
    
    public function save_crud(){
        
        $crud = $this->input->post('crud');
        $shift_value = $this->input->post('shift_value');
        $manage_date = $this->input->post('manage_date');
        //var_dump($this->input->post());
        //manage_date[]
        //die();
        
        $crud_data = array( 
                            'from_date' => date('Y-m-d H:i:s', strtotime($crud['from_date'])),
                            'to_date' => date('Y-m-d H:i:s', strtotime($crud['to_date'])),
                            'added_by' => $this->clg->clg_ref_id,
                            'added_date' => date('Y-m-d H:i:s'),
                            'modify_by' => $this->clg->clg_ref_id,
                            'modify_date' => date('Y-m-d H:i:s'),
                            'is_deleted' => '0',
                            'base_month' => $this->post['base_month']);
                
       //$args = array_merge($crud, $crud_data);
        //$audit_data = $this->schedule_crud_model->insert_crud($args);
                        $month_date = explode("/",$this->input->post('schedule_date'));
                        $month_date_start = $month_date[1].'-'.$month_date[0].'-01';
                        $data['end_date'] = date('Y-m-t', strtotime( $month_date_start));
                        $data['start_date'] = date('Y-m-d', strtotime( $month_date_start));
                         $args = array(
                        'schedule_month'=>$month_date[0],
                        'schedule_year'=>$month_date[1],
                        //'from_date' => date('Y-m-d H:i:s', strtotime($crud['from_date'])),
                       // 'to_date' => date('Y-m-d H:i:s', strtotime($crud['to_date'])),
                        'user_id'=>$crud['user_id'],
                        'user_name'=>$crud['user_name'],
                        'user_group'=>$crud['user_group'],
                        'schedule_type'=>$crud['schedule_type'],
                        'ero_supervisor'=>$crud['ero_supervisor'],
                        'shift_supervisor'=>$crud['shift_supervisor'],
                        'added_date'=> date('Y-m-d H:i:s'),
                        'added_by'=>$this->clg->clg_ref_id,
                        'modify_by'=>$this->clg->clg_ref_id,
                        'modify_date'=> date('Y-m-d H:i:s'),
                        'crud_base_month' => $this->post['base_month']);
                      
                         
                         $recordId = $this->schedule_crud_model->insert_crud($args);
                        
                         
                         $count_shift = count($shift_value);
                         for($shift = 0;$shift <= $count_shift-1;$shift++){
                             $shift_c = $shift_c+1;
                             //$shift_args = array($shift_c => $shift_value[$shift]);
                             
                            $arr1 = array();
                            $arr1['sc_cr_id']    = $recordId;
                            $arr1['shift_value'] = $shift_value[$shift];
                            

                            $arr1['schedule_date'] =  date('Y-m-d', strtotime($manage_date[$shift]));                    
                             $record_mapping = $this->schedule_crud_model->insert_schedule_mapping($arr1);
                         }
                         
                        
                   //$args = array_merge($args, $shift_args);

          
       
          $quality_user_name = $this->clg->clg_first_name . ' ' . $this->clg->clg_last_name;

        $audit = $this->input->post('audit');
        $date_time = date('Y-m-d H:i:s', strtotime($audit['ero_invite_time']));
        //var_dump($this->input->post('qa_ad_inc_ref_id'));die;
        $from = date('Y-m-d', strtotime($crud['from_date']));
        $to_date = date('Y-m-d', strtotime($crud['to_date']));
        
        $args_shift= array('shift_id'=>$crud['shift']);
        $shift_data = $this->schedule_crud_model->get_shift_data($args_shift);
        $shift_name = $shift_data[0]->shift_name;
        $shift_from_time = $shift_data[0]->shift_from_time;
        $shift_to_time = $shift_data[0]->shift_to_time;

        $user_group = array($crud['user_group']);
        
        $data = array(
            'nr_base_month' => $this->post['base_month'],
            'nr_notice' =>  "Your scheduled has been updates",
            'nr_date' => date('Y-m-d H:i:s'),
            'is_deleted' => '0',
            'notice_added_by' => $this->clg->clg_ref_id,
            'nr_user_group' => json_encode($user_group),
            'notice_exprity_date' => $to_date." 23:59:59",
            'crud_base_month' => $this->post['base_month'],);

        $nr_id = $this->colleagues_model->insert_notice($data);
        
        $clg_data = array(
                'clg_ref_id' =>  $crud['user_id'],
                'nr_notice_id' => $nr_id,
                'n_added_by' => $this->clg->clg_ref_id,
                'n_added_date' => date('Y-m-d H:i:s'),
                'base_month' => $this->post['base_month'],
            );

        $this->colleagues_model->insert_clg_notice($clg_data);
        
        
        if ($recordId) {
            $this->output->status = 1;
            $this->output->message = "<div class='success'>Shift assigned successfully!</div>";
            $this->output->closepopup = 'yes';
            $this->index();
        }
        
    }
    public function edit_crud(){
        
        $schedule_id = $this->post['schedule_id'];
        $sc_cr_id = $schedule_id;
        $crud = $this->input->post('crud');
        $crud1 = $this->input->post('shift_value');
        $crud2 = $this->input->post('map_id');
        $count = count($crud1); 
        
        for ($i = 0; $i < $count; $i++) { 
            $i_update = array('shift_value' => $crud1[$i]);
            $audit_data = $this->schedule_crud_model->update_crud($crud2[$i],$i_update);
        }

        if ($audit_data) {
            $this->output->status = 1;
            $this->output->message = "<div class='success'>Shift assigned successfully!</div>";
            $this->output->closepopup = 'yes';
            $this->index();
        }
        
    }
    function show_all_user_data(){
        $user_data = $this->input->post('user_id');
        
        $args = array('clg_reff_id'=>$user_data);

         $data['emp_info'] =  $clg = $this->colleagues_model->get_clg_data($args);
        
        $this->output->add_to_position($this->load->view('frontend/schedule_crud/show_all_user_data', $data, TRUE), 'show_all_user_data', TRUE);
    }
    
    ////////////////////////////////////////
    function delete_crud() {

        if ($this->post['schedule_id'] != '') {
            $amb_id = $this->post['schedule_id'];
        }
        if (empty($amb_id)) {
            $this->output->message = "<div class='error'>Please select at least one item to delete</div>";
            return;
        }
        $args['is_deleted'] = '1';

        $status = $this->schedule_crud_model->delete_crud($amb_id, $args);

        if ($status) {
            $this->output->message = "<div class='success'>Employee Schedule details is deleted successfully.</div>";
            $this->index();
        } else {
            $this->output->message = "<div class='error'>Employee Schedule details is not deleted</div>";
        }
    }
    function load_calender_block() {

        $data['schedule'] = $this->post['schedule'];
       
        if ($data['schedule'] == 'daily') {
            $this->output->add_to_position($this->load->view('frontend/schedule_crud/daily_calender_view', $data, TRUE), 'canlender_div_outer', TRUE);
        }
        if ($data['schedule'] == 'weekly') {
            $this->output->add_to_position($this->load->view('frontend/schedule_crud/weekly_calender_view', $data, TRUE), 'canlender_div_outer', TRUE);
        }
        if ($data['schedule'] == 'monthly') {
            $this->output->add_to_position($this->load->view('frontend/schedule_crud/monthly_calender_view', $data, TRUE), 'canlender_div_outer', TRUE);
        }
    }
    
    function load_team_list() {

        $data['schedule_date'] = $this->post['schedule_date'];
        $data['schedule_week'] = $this->post['schedule_week'];
        $data['schedule_end_week'] = $this->post['schedule_end_week'];
        $data['schedule_start_week'] = $this->post['schedule_start_week'];



        $data['schedule_month'] = $this->post['schedule_month'];
        $data['district_id'] = $this->post['district_id'];

        $data['shift_info'] = $this->common_model->get_shift($args);
      
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


        //$this->output->add_to_position($this->load->view('frontend/schedule_crud/shift_districts_view', $data, TRUE), 'shift_districts_id', TRUE );
        
        $this->output->add_to_position($this->load->view('frontend/schedule_crud/load_team_list_view', $data, TRUE), 'team_listing_block', TRUE );
    }
}

    