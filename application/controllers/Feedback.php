<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->load->model(array('feedback_model', 'Feedback_model', 'Pet_model', 'call_model', 'inc_model','pcr_model'));

        $this->load->helper(array('url', 'comman_helper'));

        $this->clg = $this->session->userdata('current_user');

        $this->post = $this->input->get_post(NULL);

        $this->post['base_month'] = get_base_month();

        $this->today = date('Y-m-d H:i:s');
        $this->pg_limit = $this->config->item('pagination_limit');

        $this->pg_limits = $this->config->item('report_clg');

        if ($this->post['filters'] == 'reset') {
            $this->session->unset_userdata('feedback_filter');
        }

        if ($this->session->userdata('feedback_filter')) {
            $this->fdata = $this->session->userdata('feedback_filter');
        }
    }

    public function index($generated = false) {

        echo "This is Feedback controller";
    }

    //// Created by MI42 //////////////////////////
    // 
    // Purpose : To confirm feedback call details.
    // 
    ///////////////////////////////////////////////

    function confirm_save() {

        $this->session->unset_userdata('feed_details');

        $data = array(
            'fed_type' => $this->post['fed_type'],
            'fed_cl_id' => $this->post['call_id'],
            'fed_inc_id' => $this->post['increfid'],
            'fed_details' => $this->post['fed_details'],
            'fed_date' => $this->today,
            'fed_base_month' => $this->post['base_month'],
            'fq' => $this->post['fq']
        );

        $this->session->set_userdata('feed_details', $data);

        /////////////////////////////////////////////////////////////////////

        $data['ftype'] = $this->feedback_model->get_fdbk_type(array('fdt_id' => $this->post['fed_type']));

        /////////////////////////////////////////////////////////////////////

        $args = array(
            'inc_ref_id' => $this->post['increfid'],
            'base_month' => $this->post['base_month']
        );

        $data['pt_info'] = $this->Pet_model->get_ptinc_info($args);


        /////////////////////////////////////////////////////////////////////

        $this->output->add_to_popup($this->load->view('frontend/feedback/confirm_feed_view', $data, TRUE), '600', '560');
        $this->output->add_to_position($this->load->view('frontend/patient/pt_inc_summary_view', $data, TRUE), 'summary_div', TRUE);
    }

    //// Created by MI42 /////////////////////////
    // 
    // Purpose : To get feedback questions answers.
    // 
    //////////////////////////////////////////////

    function qa_list() {

        $data['qa_list'] = $this->feedback_model->get_fdbk_qa(array('ft_id' => $this->post['ft_id']));

        $this->output->add_to_position($this->load->view('frontend/feedback/qa_table_view', $data, TRUE), 'fdqa_table', TRUE);
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To save feedback details.
    // 
    /////////////////////////////////////////

    function save() {




        if ($this->post['fwd_fed_call']) {


            $args = $this->session->userdata('feed_details');

            $fq = $args['fq'];

            unset($args['fq']);


            $fed_id = $this->feedback_model->add($args);


            $this->session->unset_userdata('feed_details');


            ////////////////////////////////////////////////////////////


            $args = array(
                'sub_id' => $fed_id,
                'operator_id' => $this->clg->clg_ref_id,
                'operator_type' => $this->clg->clg_group,
                'base_month' => $this->post['base_month'],
                'sub_type' => 'FEED'
            );



            $res = $this->common_model->assign_operator($args);


            if (is_array($fq)) {

                foreach ($fq as $que => $ans) {

                    $args = array(
                        'sum_base_month' => $this->post['base_month'],
                        'sum_sub_id' => $fed_id,
                        'sum_sub_type' => 'FEED',
                        'sum_que_id' => $que,
                        'sum_que_ans' => $ans
                    );




                    $this->common_model->add_summary($args);
                }
            }

            if ($res) {

                $this->output->status = 1;
                $this->output->closepopup = "yes";

                $this->output->message = "<h3>Feedback Call</h3><br><p>Feedback details forwarded successfully.</p><script>start_incoming_call();</script>";

                $this->output->moveto = 'top';

                $this->output->add_to_position('', 'content', TRUE);
            }
        }
    }

    function feedback_list() {


//        ///////////////  Filters //////////////////

        $data['search'] = ($this->post['search']) ? $this->post['search'] : $this->fdata['search'];


        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];




        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }

        $data['call_type'] = "";
        $data['filter'] = $filter = "";
        $data['filter'] = $_POST['filter'] ? $this->post['filter'] : $this->fdata['filter'];

        $data['call_type'] = $_POST['call_type'] ? $this->post['call_type'] : $this->fdata['call_type'];
        $data['system_filter'] = $_POST['system_filter'] ? $this->post['system_filter'] : $this->fdata['system_filter'];
        $data['Reopen_id'] = $_POST['Reopen_id'] ? $this->post['Reopen_id'] : $this->fdata['Reopen_id'];
        $data['date'] = $_POST['date'] ? $this->post['date'] : $this->fdata['date'];
        $data['inc_id'] = $_POST['inc_id'] ? $this->post['inc_id'] : $this->fdata['inc_id'];
        $data['district_id'] = $_POST['district_id'] ? $this->post['district_id'] : $this->fdata['district_id'];
        $data['amb_rto_register_no'] = $_POST['amb_rto_register_no'] ? $this->post['amb_rto_register_no'] : $this->fdata['amb_rto_register_no'];
        $data['base_location_name1'] = $_POST['base_location_name1'] ? $this->post['base_location_name1'] : $this->fdata['base_location_name1'];
        $data['patient_status_search'] = $_POST['patient_status_search'] ? $this->post['patient_status_search'] : $this->fdata['patient_status_search'];
        if($data['date'] == ""){
            $data['48hours'] = "48hours";
        }



        if (isset($data['filter'])) {

            if ($data['filter'] == 'call_type') {
                $filter = '';
                $sortby['call_type'] = $data['call_type'];
                $data['call_type'] = $sortby['call_type'];
            } else if ($data['filter'] == 'date') {
              
                $filter = '';
                $sortby['date'] = $data['date'];
                $data['date'] = $sortby['date'];
                $data['f_date'] = date('Y-m-d',strtotime($data['date']));
                $data['t_date'] = date('Y-m-d H:i:s',strtotime($data['date']));
                $data['from_date'] = $data['t_date'];
                $data['to_date'] = $data['f_date']." 23:59:59";
                
            } else if ($data['filter'] == 'inc_id') {
                $filter = '';
                $sortby['inc_id'] = $data['inc_id'];
                $data['inc_id'] = $data['inc_id'];
                $data['48hours'] = "";
            }
            else if ($data['filter'] == 'Reopen_id') {
                $filter = '';
                $sortby['date'] = $data['date'];
                $data['date'] = $sortby['date'];
                $data['f_date'] = date('Y-m-d',strtotime($data['date']));
                $data['t_date'] = date('Y-m-d H:i:s',strtotime($data['date']));
                $data['from_date'] = $data['t_date'];
                $data['to_date'] = $data['f_date']." 23:59:59";
            }
            else if ($data['filter'] == 'dst_name') {
                $filter = '';
                $sortby['district_id'] = $data['district_id'];
                $data['district_id'] = $sortby['district_id'];
            }

            else if ($data['filter'] == 'amb_id') {
                $filter = '';
                $sortby['amb_rto_register_no'] = $data['amb_rto_register_no'];
                $data['amb_rto_register_no'] = $sortby['amb_rto_register_no'];
            }
            else if ($data['filter'] == 'hp_name') {
                $filter = '';
                $sortby['base_location_name'] = $data['base_location_name'];
                $data['base_location_name'] = $sortby['base_location_name'];
            }
            else if ($data['filter'] == 'pt_status') {
                $filter = '';
                $sortby['patient_status_search'] = $data['patient_status_search'];
                $data['patient_status_search'] = $sortby['patient_status_search'];
            }
        }
        
    
        //var_dump($data['patient_status_search']); die();
        $this->session->set_userdata('feedback_filter', $data);


        ///////////limit & offset////////

        $data['get_count'] = TRUE;

        $data['base_month'] = $this->post['base_month'];
        $data['now'] = time();
        
        $data['total_count'] = $this->call_model->get_inc_feedback_calls($data, '', '', $filter, $sortby);
        //die();

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);
        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;
        $data['page_no'] = $page_no;
        unset($data['get_count']);
        
        $data['inc_info'] = $this->call_model->get_inc_feedback_calls($data, $offset, $limit, $filter, $sortby);

        $data['purpose_calls'] = $this->call_model->get_all_child_purpose_of_calls($data);
//
//        /////////////////////////
//
        $data['cur_page'] = $page_no;
//
        $pgconf = array(
            'url' => base_url("feedback/feedback_list"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        // Total Closure 
       $month = date('m');
       $year = date('Y');
       $day = date('d');
       $query_date = $year.'-'.$month.'-'.$day;

       //echo $query_date;
       $first_day_this_month = date('Y-m-01', strtotime($query_date));

       // Last day of the month.
       $last_day_this_month = date('Y-m-t', strtotime($query_date));
       $month_report_args =  array('from_date' => date('Y-m-d',strtotime($first_day_this_month)),
                      'to_date' => date('Y-m-d', strtotime($last_day_this_month)));

       $month_report_args['get_count'] = 'true';
       $month_report_args['operator_id'] = $this->clg->clg_ref_id;
       
       $data['get_all_calls'] = $this->feedback_model->get_all_calls($month_report_args);
      // $data['excellent'] = $this->feedback_model->get_excellent_calls($month_report_args);
      // $data['get_good_calls'] = $this->feedback_model->get_good_calls($month_report_args);
      // $data['get_avarage_calls'] = $this->feedback_model->get_avarage_calls($month_report_args);
      // $data['get_poor_calls'] = $this->feedback_model->get_poor_calls($month_report_args);

       //Today call
       $today_report_args =  array('from_date' => date('Y-m-d',strtotime($query_date)),
                      'to_date' => date('Y-m-d', strtotime($query_date)));
       $today_report_args['get_count'] = 'true';
       $today_report_args['operator_id'] = $this->clg->clg_ref_id;

      $data['get_all_today_calls'] = $this->feedback_model->get_all_calls($today_report_args);
      
        $data['pgconf'] = $pgconf;
        $data['pagination'] = get_pagination($pgconf);

//      
//
        $data['page_records'] = count($data['inc_info']);


       
        $this->output->add_to_position($this->load->view('frontend/feedback/feedback_dashboard_view', $data, TRUE), 'content', TRUE);
        
        if($this->clg->clg_group ==  'UG-Feedback' ){
            $this->output->template = "calls";
        }

        $this->session->unset_userdata('feedback_filter');
    }

    public function feedback_dash($generated = false) {

//        ///////////////  Filters //////////////////

        $data['search'] = ($this->post['search']) ? $this->post['search'] : $this->fdata['search'];


        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];




        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }

        ///////////limit & offset////////

        $data['get_count'] = TRUE;

        $data['base_month'] = $this->post['base_month'];


        $data['total_count'] = $this->call_model->get_inc_by_ero_calls($data);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);
        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;
        $data['page_no'] = $page_no;
        unset($data['get_count']);
        $data['inc_info'] = $this->call_model->get_inc_by_ero_calls($data, $offset, $limit);
//
//        /////////////////////////
//
        $data['cur_page'] = $page_no;
//
        $pgconf = array(
            'url' => base_url("feedback/feedback_dash"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        
        // Total Closure 
       $month = date('m');
       $year = date('Y');
       $day = date('d');
       $query_date = $year.'-'.$month.'-'.$day;

       //echo $query_date;
       $first_day_this_month = date('Y-m-01', strtotime($query_date));

       // Last day of the month.
       $last_day_this_month = date('Y-m-t', strtotime($query_date));
       $month_report_args =  array('from_date' => date('Y-m-d',strtotime($first_day_this_month)),
                      'to_date' => date('Y-m-d', strtotime($last_day_this_month)));

       $month_report_args['get_count'] = 'true';
       $month_report_args['operator_id'] = $this->clg->clg_ref_id;
       
       $data['get_all_calls'] = $this->feedback_model->get_all_calls($month_report_args);
      // $data['excellent'] = $this->feedback_model->get_excellent_calls($month_report_args);
      // $data['get_good_calls'] = $this->feedback_model->get_good_calls($month_report_args);
      // $data['get_avarage_calls'] = $this->feedback_model->get_avarage_calls($month_report_args);
      // $data['get_poor_calls'] = $this->feedback_model->get_poor_calls($month_report_args);

       //Today call
       $today_report_args =  array('from_date' => date('Y-m-d',strtotime($query_date)),
                      'to_date' => date('Y-m-d', strtotime($query_date)));
       $today_report_args['get_count'] = 'true';
       $today_report_args['operator_id'] = $this->clg->clg_ref_id;

      $data['get_all_today_calls'] = $this->feedback_model->get_all_calls($today_report_args);
     
        $data['pgconf'] = $pgconf;
        $data['pagination'] = get_pagination($pgconf);


        $data['page_records'] = count($data['inc_info']);



        $this->output->add_to_position($this->load->view('frontend/feedback/feedback_dashboard_view', $data, TRUE), 'content', TRUE);

        $this->output->template = "calls";
    }
    
    public function feedback_manager($generated = false) {

//        ///////////////  Filters //////////////////

        $data['search'] = ($this->post['search']) ? $this->post['search'] : $this->fdata['search'];


        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $data['feedback_id'] = $args['feedback_id']  = ($this->post['feedback_id']) ? $this->post['feedback_id'] : $this->fdata['feedback_id'];

        $clg_args = array('clg_senior'=>$this->clg->clg_ref_id,'clg_group'=>'UG-Feedback');
        $data['feedback_clg'] = $this->colleagues_model->get_clg_data($clg_args);
        
      
        
            foreach($data['feedback_clg'] as $ercp){
                $feedback_clg[] = $ercp->clg_ref_id;
            }

            if(is_array($feedback_clg)){
                $child_feedback = implode("','", $feedback_clg);
            }

        
            $data['child_feedback'] = $child_feedback;

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }

        ///////////limit & offset////////

        $data['get_count'] = TRUE;

        $data['base_month'] = $this->post['base_month'];
        $data['clg_user_group'] = $this->clg->clg_group;

        $data['total_count'] = $this->feedback_model->get_feedback_details_by_user($data);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);
        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;
        $data['page_no'] = $page_no;
        unset($data['get_count']);
        $data['inc_info'] = $this->feedback_model->get_feedback_details_by_user($data, $offset, $limit);
//
//        /////////////////////////
//
        $data['cur_page'] = $page_no;
//
        $pgconf = array(
            'url' => base_url("feedback/feedback_manager"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        $data['pgconf'] = $pgconf;
        $data['pagination'] = get_pagination($pgconf);


        $data['page_records'] = count($data['inc_info']);



        $this->output->add_to_position($this->load->view('frontend/feedback/feedback_manager_dashboard_view', $data, TRUE), 'content', TRUE);

        //$this->output->template = "calls";
    }
    function reopen_report_view(){
        $data = array();
        $data['base_month'] = $this->post['base_month'];
     
        $data['inc_ref_id'] = base64_decode($this->post['inc_ref_id']);



        $data['inc_info'] = $this->call_model->get_inc_by_ero_calls_reopen($data, $offset, $limit);

        //for single record data
      //  var_dump($data['inc_info']);die;
        $inc_ref_id =  $data['inc_ref_id'];
        $ero_name = get_clg_data_by_ref_id($inc_call_type[0]->inc_added_by);
        $data['type'] = $this->post['type'];
        $this->post['base_month'] = get_base_month();
        $data['inc_ref_id'] = $inc_ref_id;
      // $reff_id = $this->post['inc_added_by'];
       $data['inc_added_by'] = $reff_id;
        $usr_id = $this->post['ref_id'];
        //$data['user_type'] = $this->post['user_type'];
        //$ref_id = 'UG-' . $data['user_type'];
        //$data['ref_id'] = $this->post['ref_id'];
        //$data['user_type'] = $this->post['user_type'];
        $data['inc_ref_no'] = $data['inc_ref_id'];
        $args_dash = array('inc_id' => $inc_ref_id,
            'base_month' => $this->post['base_month']);
        //$data['inc_data'] = $this->call_model->get_inc_by_ero_calls($args_dash);
        //$data['feedback_details'] = $this->feedback_model->get_feedback_details(array('inc_ref_id' => trim($data['inc_ref_no'])));
        $args = array('inc_ref_id' => $inc_ref_id,
            'base_month' => $this->post['base_month'],
            'user_type' => $data['user_type']);
          
        $data['inc_call_type'] = $this->inc_model->get_inc_ref_id($args);
        $data['inc_details'] = $this->inc_model->get_inc_call_details_ref_id($args);
        
        //$data['audit_details'] = $this->quality_model->get_quality_audit($args);
        $args_st = array('st_code' => $data['inc_details'][0]->inc_state_id);
        $state = $this->inc_model->get_state_name($args_st);
        $data['state_name'] = $state[0]->st_name;
        $args_dst = array('st_code' => $data['inc_details'][0]->inc_state_id, 'dst_code' => $data['inc_details'][0]->inc_district_id);
        $district = $this->inc_model->get_district_name($args_dst);
        $data['district_name'] = $district[0]->dst_name;
        $args_th = array('thl_id' => $data['inc_details'][0]->inc_tahshil_id);
        $tahshil = $this->inc_model->get_tahshil($args_th);
        $data['tahshil_name'] = $tahshil[0]->thl_name;
        $args_ct = array('cty_id' => $data['inc_details'][0]->inc_city_id, 'dst_code' => $data['inc_details'][0]->inc_district_id);
        $city = $this->inc_model->get_city_name($args_ct);
        $data['city_name'] = $city[0]->cty_name;
        $data['cl_relation'] = $inc_data[0]->cl_relation;
        $cm_id = $data['inc_details'][0]->inc_complaint;
        $chief_comp = $this->inc_model->get_chief_comp_service($cm_id);
        $data['chief_complete_name'] = $chief_comp[0]->ct_type;
        $args_pt = array('get_count' => TRUE,
            'inc_ref_id' => $data['inc_ref_no']);
       // $data['ptn_count'] = $this->pcr_model->get_pat_by_inc($args_pt);
       
        $gri_args = array(
            'gc_inc_ref_id' => trim($this->input->post('inc_ref_id'))
        );
       // $data['grievance_info'] = $this->grievance_model->get_inc_by_grievance($data, $offset, $limit);
        $args = array('gc_inc_ref_id' => $inc_info[0]->inc_ref_id);
        //$data['cl_dtl'] = $this->grievance_model->get_inc_by_grievance($args);
        $sup_remark_args = array(
            's_inc_ref_id' => trim($this->input->post('inc_ref_id'))
        );
        $data['supervisor_remark'] = $this->call_model->get_inc_supervisor_remark($sup_remark_args);
        $cm_id = $data['inc_details'][0]->inc_complaint;
        $chief_comp = $this->inc_model->get_chief_comp_service($cm_id);
        $data['chief_complete_name'] = $chief_comp[0]->ct_type;
        $args_pur = array('pcode' => $data['inc_details'][0]->cl_purpose);
        $data['pname'] = $this->inc_model->get_purpose_call($args_pur);
        //$data['pt_info'] = $this->Pet_model->get_ptinc_info($arg);
        $args_pur = array('pcode' => $data['pt_info'][0]->inc_type);
        //$data['pname'] = $call_pur[0]->pname;
        $ptn_args = array('inc_ref_id' => $data['inc_ref_no'],
                            'base_month' => $this->post['base_month'],
//                'ptn_id' => $data['inc_details'][0]->ptn_id,
        );
        $data['pt_info'] =$data['ptn_details'] = $this->Pet_model->get_ptinc_info($ptn_args);
        $data['facility_details'] = $this->inc_model->get_hospital_facility(array('inc_ref_id' => trim($data['inc_ref_no'])));
        //$data['feedback_details'] = $this->feedback_model->get_feedback_details(array('inc_ref_id' => trim($data['inc_ref_no'])));
         $inc_args = array(
                'inc_ref_id' => $data['inc_ref_no'],
                'inc_type' => $data['inc_call_type'][0]->inc_type
            );
        $data['questions'] = $this->inc_model->get_inc_summary($inc_args);
        $ques_args = array(
            'inc_ref_id' => $data['inc_ref_no'],
            'inc_type' => 'FEED_' . $data['inc_call_type'][0]->inc_type
        );
        $data['feed_questions'] = $this->inc_model->get_inc_summary($ques_args);
        $amb_args = array('inc_ref_id' => $data['inc_ref_no']);
        //$data['enquiry_data'] = $this->enquiry_model->get_enquiry($amb_args);
        $myArray = explode(',', $data['enquiry_data'][0]->enq_que);
        $data['enq_que'] = array();
        $q = 0;
        if (is_array($myArray)) {
            foreach ($myArray as $que) {
                $enq_que = $this->common_model->get_question(array('que_id' => $que));
                $serialize_que = $enq_que[0]->que_question;
                //$data['enq_que'][$q]['que'] = get_lang_data($serialize_que, $data['enquiry_data'][0]->enq_lang);
                $ans = $this->common_model->get_answer(array('ans_que_id' => $que));
                $serialize_ans = $ans[0]->ans_answer;
                //$data['enq_que'][$q]['ans'] = get_lang_data($serialize_ans, $data['enquiry_data'][0]->enq_lang);
                $data['enq_que'][$q]['que_id'] = $que;
                $q++;
            }
        }
        $data['epcr_inc_details'] = $this->pcr_model->get_epcr_inc_details_by_inc_id($inc_args);
        //var_dump($data['epcr_inc_details']);
        //$data['er_inc_details'] = $this->medadv_model->get_epcr_by_inc_id($inc_args);
        $data['driver_data'] = $this->pcr_model->get_driver(array('inc_ref_id' => trim($data['inc_ref_no'])));
        //for single record data
        $args = array(
            'que_type' => 'feedback'
        );
        $amb_args = array('inc_ref_id' => $data['inc_ref_no']);
        $data['amb_data'] = $this->inc_model->get_inc_details($amb_args);

        $data['feed_stand_remark']= $this->call_model->get_feedback_stand_remark();

        $data['ques'] = $this->common_model->get_question_by_id_asc($args);

        $data['action_type'] = 'Report view';

        $this->output->add_to_position($this->load->view('frontend/feedback/feedback_reopen_view', $data, TRUE), $output_position, TRUE);
   
    }
    function report_view() {

        $data = array();
        $data['base_month'] = $this->post['base_month'];
     
        $data['inc_ref_id'] = base64_decode($this->post['inc_ref_id']);
        $data['clg_user_group'] = $this->clg->clg_group;
        

        $data['inc_info'] = $this->call_model->get_inc_by_ero_calls($data, $offset, $limit);

        //for single record data
        //var_dump($data['inc_ref_id']);die;
        $inc_ref_id =  $data['inc_ref_id'];
        $ero_name = get_clg_data_by_ref_id($inc_call_type[0]->inc_added_by);
        $data['type'] = $this->post['type'];
        $this->post['base_month'] = get_base_month();
        $data['inc_ref_id'] = $inc_ref_id;
      // $reff_id = $this->post['inc_added_by'];
       $data['inc_added_by'] = $reff_id;
        $usr_id = $this->post['ref_id'];
        //$data['user_type'] = $this->post['user_type'];
        //$ref_id = 'UG-' . $data['user_type'];
        //$data['ref_id'] = $this->post['ref_id'];
        //$data['user_type'] = $this->post['user_type'];
        $data['inc_ref_no'] = $data['inc_ref_id'];
        $args_dash = array('inc_id' => $inc_ref_id,
            'base_month' => $this->post['base_month']);
        //$data['inc_data'] = $this->call_model->get_inc_by_ero_calls($args_dash);
        //$data['feedback_details'] = $this->feedback_model->get_feedback_details(array('inc_ref_id' => trim($data['inc_ref_no'])));
        $args = array('inc_ref_id' => $inc_ref_id,
            'base_month' => $this->post['base_month'],
            'user_type' => $data['user_type']);
          
        $data['inc_call_type'] = $this->inc_model->get_inc_ref_id($args);
        $data['inc_details'] = $this->inc_model->get_inc_call_details_ref_id($args);
        
        //$data['audit_details'] = $this->quality_model->get_quality_audit($args);
        $args_st = array('st_code' => $data['inc_details'][0]->inc_state_id);
        $state = $this->inc_model->get_state_name($args_st);
        $data['state_name'] = $state[0]->st_name;
        $args_dst = array('st_code' => $data['inc_details'][0]->inc_state_id, 'dst_code' => $data['inc_details'][0]->inc_district_id);
        $district = $this->inc_model->get_district_name($args_dst);
        $data['district_name'] = $district[0]->dst_name;
        $args_th = array('thl_id' => $data['inc_details'][0]->inc_tahshil_id);
        $tahshil = $this->inc_model->get_tahshil($args_th);
        $data['tahshil_name'] = $tahshil[0]->thl_name;
        $args_ct = array('cty_id' => $data['inc_details'][0]->inc_city_id, 'dst_code' => $data['inc_details'][0]->inc_district_id);
        $city = $this->inc_model->get_city_name($args_ct);
        $data['city_name'] = $city[0]->cty_name;
        $data['cl_relation'] = $inc_data[0]->cl_relation;
        $cm_id = $data['inc_details'][0]->inc_complaint;
        $chief_comp = $this->inc_model->get_chief_comp_service($cm_id);
        $data['chief_complete_name'] = $chief_comp[0]->ct_type;
        $args_pt = array('get_count' => TRUE,
            'inc_ref_id' => $data['inc_ref_no']);
       // $data['ptn_count'] = $this->pcr_model->get_pat_by_inc($args_pt);
       
        $gri_args = array(
            'gc_inc_ref_id' => trim($this->input->post('inc_ref_id'))
        );
       // $data['grievance_info'] = $this->grievance_model->get_inc_by_grievance($data, $offset, $limit);
        $args = array('gc_inc_ref_id' => $inc_info[0]->inc_ref_id);
        //$data['cl_dtl'] = $this->grievance_model->get_inc_by_grievance($args);
        $sup_remark_args = array(
            's_inc_ref_id' => trim($this->input->post('inc_ref_id'))
        );
        $data['supervisor_remark'] = $this->call_model->get_inc_supervisor_remark($sup_remark_args);
        $cm_id = $data['inc_details'][0]->inc_complaint;
        $chief_comp = $this->inc_model->get_chief_comp_service($cm_id);
        $data['chief_complete_name'] = $chief_comp[0]->ct_type;
        $args_pur = array('pcode' => $data['inc_details'][0]->cl_purpose);
        $data['pname'] = $this->inc_model->get_purpose_call($args_pur);
        //$data['pt_info'] = $this->Pet_model->get_ptinc_info($arg);
        $args_pur = array('pcode' => $data['pt_info'][0]->inc_type);
        //$data['pname'] = $call_pur[0]->pname;
        $ptn_args = array('inc_ref_id' => $data['inc_ref_no'],
                            'base_month' => $this->post['base_month'],
//                'ptn_id' => $data['inc_details'][0]->ptn_id,
        );
        $data['pt_info'] =$data['ptn_details'] = $this->Pet_model->get_ptinc_info($ptn_args);
        $data['facility_details'] = $this->inc_model->get_hospital_facility(array('inc_ref_id' => trim($data['inc_ref_no'])));
        //$data['feedback_details'] = $this->feedback_model->get_feedback_details(array('inc_ref_id' => trim($data['inc_ref_no'])));
         $inc_args = array(
                'inc_ref_id' => $data['inc_ref_no'],
                'inc_type' => $data['inc_call_type'][0]->inc_type
            );
        $data['questions'] = $this->inc_model->get_inc_summary($inc_args);
        $ques_args = array(
            'inc_ref_id' => $data['inc_ref_no'],
            'inc_type' => 'FEED_' . $data['inc_call_type'][0]->inc_type
        );
        $data['feed_questions'] = $this->inc_model->get_inc_summary($ques_args);
        $amb_args = array('inc_ref_id' => $data['inc_ref_no']);
        //$data['enquiry_data'] = $this->enquiry_model->get_enquiry($amb_args);
        $myArray = explode(',', $data['enquiry_data'][0]->enq_que);
        $data['enq_que'] = array();
        $q = 0;
        if (is_array($myArray)) {
            foreach ($myArray as $que) {
                $enq_que = $this->common_model->get_question(array('que_id' => $que));
                $serialize_que = $enq_que[0]->que_question;
                //$data['enq_que'][$q]['que'] = get_lang_data($serialize_que, $data['enquiry_data'][0]->enq_lang);
                $ans = $this->common_model->get_answer(array('ans_que_id' => $que));
                $serialize_ans = $ans[0]->ans_answer;
                //$data['enq_que'][$q]['ans'] = get_lang_data($serialize_ans, $data['enquiry_data'][0]->enq_lang);
                $data['enq_que'][$q]['que_id'] = $que;
                $q++;
            }
        }
        $data['epcr_inc_details'] = $this->pcr_model->get_epcr_inc_details_by_inc_id($inc_args);
        //var_dump($data['epcr_inc_details']);
        //$data['er_inc_details'] = $this->medadv_model->get_epcr_by_inc_id($inc_args);
        $data['driver_data'] = $this->pcr_model->get_driver(array('inc_ref_id' => trim($data['inc_ref_no'])));
        //for single record data
        $args = array(
            'que_type' => 'feedback'
        );
        $amb_args = array('inc_ref_id' => $data['inc_ref_no']);
        $data['amb_data'] = $this->inc_model->get_inc_details($amb_args);

        $data['feed_stand_remark']= $this->call_model->get_feedback_stand_remark();

        $data['ques'] = $this->common_model->get_question_by_id_asc($args);

        $data['action_type'] = 'Report view';

        $this->output->add_to_position($this->load->view('frontend/feedback/feedback_report_view', $data, TRUE), $output_position, TRUE);
    }
    function remark_type_feedback() {
        $feedback = $this->input->post();
        $feed_type= $feedback['filter_value'];
        if($feed_type == 'negative_feedback'){
            $data['feed_type'] ="NEGATIVE";
        }else{
           $data['feed_type'] = "POSITIVE";
        }
        $data['feed_stand_remark']= $this->call_model->get_feedback_stand_remark(array('feed_type'=>$data['feed_type']));
        $this->output->add_to_position($this->load->view('frontend/feedback/feedback_standard_remark', $data, TRUE), 'feedback_standard_remark', TRUE);
        
    }
    function save_reopen_feedback(){
        $inc_details = $this->input->get_post('feedback');

        $incidence_details = array(
            'inc_ref_id' => $inc_details['fc_inc_ref_id'],
            'inc_feedback_status' => '1'
        );

        $inc_data = $this->inc_model->update_incident($incidence_details);

        $incidence_details_feedback = array(
            'fc_inc_ref_id' => $inc_details['fc_inc_ref_id'],
            'flag' => '2'
        );

        $inc_data = $this->feedback_model->update_incident($incidence_details_feedback);

        $ques_ans = $inc_details['ques'];
        if (isset($ques_ans)) {
            foreach ($ques_ans as $key => $ques) {

                $ems_summary = array('sum_base_month' => $this->post['base_month'],
                    'sum_sub_id' => $inc_details['fc_inc_ref_id'],
                    'sum_sub_type' => 'FEED_'.$inc_details['fc_inc_type'],
                    'sum_que_id' => $key,
                    'sum_que_ans' => $ques
                );

                $this->inc_model->insert_ems_summary($ems_summary);
            }
        }

        $args = array(
            'fc_inc_ref_id' => $inc_details['fc_inc_ref_id'],
            'fc_inc_type' => $inc_details['fc_inc_type'],
            'fc_caller_number' => $inc_details['fc_caller_number'],
            'fc_caller_name' => $inc_details['fc_caller_name'],
            'fc_call_type' => $inc_details['fc_call_type'],
            'fc_dispatch_date_time' => $inc_details['fc_dispatch_date_time'],
            'fc_feedback_type' => $inc_details['fc_feedback_type'],
            'fc_standard_type' => json_encode($inc_details['fc_standard_type']),
            'fc_employee_remark' => $inc_details['fc_employee_remark'],
            'fc_base_month' => $this->post['base_month'],
            'fc_added_date' => $this->today,
            'fc_added_by' => $this->clg->clg_ref_id,
            'fc_modify_date' => $this->today,
            'fc_modify_by' => $this->clg->clg_ref_id,
        );

        if ($args['fc_caller_relation'] != '') {
            $args['fc_caller_relation'] = $inc_details['fc_caller_relation'];
        }

        if ($args['fc_ptn_name'] != '') {
            $args['fc_ptn_name'] = $inc_details['fc_ptn_name'];
        }

        if ($args['fc_ptn_age'] != '') {
            $args['fc_ptn_age'] = $inc_details['fc_ptn_age'];
        }

        if ($args['fc_inc_address'] != '') {
            $args['fc_inc_address'] = $inc_details['fc_inc_address'];
        }

        if ($args['fc_ptn_gender'] != '') {
            $args['fc_ptn_gender'] = $inc_details['fc_ptn_gender'];
        }


        $feedback = $this->feedback_model->add_feedback($args);



        if ($this->post['forword'] != '') {

            $arg = array(
                'sub_id' => $inc_details['fc_inc_ref_id'],
                'operator_id' => $this->clg->clg_ref_id,
                'operator_type' => $this->clg->clg_group,
                'base_month' => $this->post['base_month'],
                'sub_type' => $inc_details['fc_inc_type']
            );

            $res = $this->common_model->assign_operator($arg);


            $police_user = $this->inc_model->get_fire_user($sr_user, 'UG-Grievance');
       
            if($police_user){
                $police_operator2 = array(
                    'sub_id' => $inc_details['fc_inc_ref_id'],
                    'operator_id' => $police_user->clg_ref_id,
                    'operator_type' => 'UG-Grievance',
                    'sub_status' => 'ASG',
                    'sub_type' => $inc_details['fc_inc_type'],
                    'base_month' => $this->post['base_month']
                );


                $police_operator = $this->common_model->assign_operator($police_operator2);
            }
        }


        if ($feedback) {

            $this->output->message = "<div class='success'>Details saved successfully</div><script>window.location.reload(true);</script>";
        }
    }
    function save_feedback() {

        $inc_details = $this->input->get_post('feedback');

        $incidence_details = array(
            'inc_ref_id' => $inc_details['fc_inc_ref_id'],
            'inc_feedback_status' => '1'
        );

        $inc_data = $this->inc_model->update_incident($incidence_details);

        $ques_ans = $inc_details['ques'];
        if (isset($ques_ans)) {
            foreach ($ques_ans as $key => $ques) {

                $ems_summary = array('sum_base_month' => $this->post['base_month'],
                    'sum_sub_id' => $inc_details['fc_inc_ref_id'],
                    'sum_sub_type' => 'FEED_'.$inc_details['fc_inc_type'],
                    'sum_que_id' => $key,
                    'sum_que_ans' => $ques
                );

                $this->inc_model->insert_ems_summary($ems_summary);
            }
        }

        $args = array(
            'fc_inc_ref_id' => $inc_details['fc_inc_ref_id'],
            'fc_inc_type' => $inc_details['fc_inc_type'],
            'fc_caller_number' => $inc_details['fc_caller_number'],
            'fc_caller_name' => $inc_details['fc_caller_name'],
            'fc_call_type' => $inc_details['fc_call_type'],
            'fc_dispatch_date_time' => $inc_details['fc_dispatch_date_time'],
            'fc_feedback_type' => $inc_details['fc_feedback_type'],
            'fc_standard_type' => json_encode($inc_details['fc_standard_type']),
            'fc_employee_remark' => $inc_details['fc_employee_remark'],
            'fc_base_month' => $this->post['base_month'],
            'fc_added_date' => $this->today,
            'fc_added_by' => $this->clg->clg_ref_id,
            'fc_modify_date' => $this->today,
            'fc_modify_by' => $this->clg->clg_ref_id,
        );

        if ($args['fc_caller_relation'] != '') {
            $args['fc_caller_relation'] = $inc_details['fc_caller_relation'];
        }

        if ($args['fc_ptn_name'] != '') {
            $args['fc_ptn_name'] = $inc_details['fc_ptn_name'];
        }

        if ($args['fc_ptn_age'] != '') {
            $args['fc_ptn_age'] = $inc_details['fc_ptn_age'];
        }

        if ($args['fc_inc_address'] != '') {
            $args['fc_inc_address'] = $inc_details['fc_inc_address'];
        }

        if ($args['fc_ptn_gender'] != '') {
            $args['fc_ptn_gender'] = $inc_details['fc_ptn_gender'];
        }


        $feedback = $this->feedback_model->add_feedback($args);



        if ($this->post['forword'] != '') {

            $arg = array(
                'sub_id' => $inc_details['fc_inc_ref_id'],
                'operator_id' => $this->clg->clg_ref_id,
                'operator_type' => $this->clg->clg_group,
                'base_month' => $this->post['base_month'],
                'sub_type' => $inc_details['fc_inc_type']
            );

            $res = $this->common_model->assign_operator($arg);

            if($inc_details['fc_feedback_type'] == 'negative_feedback'){
            $police_user = $this->inc_model->get_fire_user($sr_user, 'UG-Grievance');
       
            if($police_user){
                $police_operator2 = array(
                    'sub_id' => $inc_details['fc_inc_ref_id'],
                    'operator_id' => $police_user->clg_ref_id,
                    'operator_type' => 'UG-Grievance',
                    'sub_status' => 'ASG',
                    'sub_type' => $inc_details['fc_inc_type'],
                    'base_month' => $this->post['base_month']
                );


                $police_operator = $this->common_model->assign_operator($police_operator2);
            }
        }
    }


        if ($feedback) {

            $this->output->message = "<div class='success'>Details saved successfully</div><script>window.location.reload(true);</script>";
        }
    }
    function pt_feedback($inc_id,$inc_type) {

    $inc_args = array(
    'inc_ref_id' => $inc_id,
    'inc_type' =>$inc_type
    );
    $inc_args1 = array(
        'inc_ref_id' => $inc_id,
        'inc_type' =>$inc_type
        );
    $data['questions'] = $this->inc_model->get_inc_summary($inc_args);
    $ques_args = array(
    'inc_ref_id' =>$inc_id,
    'inc_type' => 'FEED_'.$inc_type
    );
    $data['inc_ids']=$inc_args1;
    //  print_r($data);die;
    $data['feed_questions'] = $this->inc_model->get_inc_summary($ques_args);
    $amb_args = array('inc_ref_id' => $inc_id);
    $myArray = explode(',', $data['enquiry_data'][0]->enq_que);
    $data['enq_que'] = array();
    $q = 0;
    if (is_array($myArray)) {
        foreach ($myArray as $que) {
            $enq_que = $this->common_model->get_question(array('que_id' => $que));
            $serialize_que = $enq_que[0]->que_question;
            
            //$data['enq_que'][$q]['que'] = get_lang_data($serialize_que, $data['enquiry_data'][0]->enq_lang);
            $ans = $this->common_model->get_answer(array('ans_que_id' => $que));
            $serialize_ans = $ans[0]->ans_answer;
            //$data['enq_que'][$q]['ans'] = get_lang_data($serialize_ans, $data['enquiry_data'][0]->enq_lang);
            $data['enq_que'][$q]['que_id'] = $que;
            $q++;
        }
    }
    $data['epcr_inc_details'] = $this->pcr_model->get_epcr_inc_details_by_inc_id($inc_args);
    //var_dump($data['epcr_inc_details']);
    //$data['er_inc_details'] = $this->medadv_model->get_epcr_by_inc_id($inc_args);
    $data['driver_data'] = $this->pcr_model->get_driver(array('inc_ref_id' => trim($data['inc_ref_no'])));
    //for single record data
    $args = array(
        'que_type' => 'feedback'
    );
    $amb_args = array('inc_ref_id' => $data['inc_ref_no']);
    $data['amb_data'] = $this->inc_model->get_inc_details($amb_args);

    $data['feed_stand_remark']= $this->call_model->get_feedback_stand_remark();

    $data['ques'] = $this->common_model->get_question_by_id_asc($args);

    $this->output->add_to_position($this->load->view('frontend/feedback/feedback_form_new_view', $data, TRUE), $output_position, TRUE);
        $this->output->template = ('blank');
      
    }
    function save_pt_feedback() {
   
        $inc_details = $this->input->get_post('feedback');
        // print_r($inc_details);die;
       
        $incidence_details = array(
            'inc_ref_id' => $inc_details['fc_inc_ref_id'],
            'inc_type' => $inc_details['fc_inc_type'],
            'inc_feedback_status' => '1'
        );
        
        $inc_data = $this->inc_model->update_incident($incidence_details);
      
        $ques_ans = $inc_details['ques'];
        // var_dump($ques_ans);die(); 
      
        if (isset($ques_ans)) {
            foreach ($ques_ans as $key => $ques) {

                $ems_summary = array('sum_base_month' => $this->post['base_month'],
                    'sum_sub_id' => $inc_details['fc_inc_ref_id'],
                    'sum_sub_type' => 'FEED_'.$inc_details['fc_inc_type'],
                    'sum_que_id' => $key,
                    'sum_que_ans' => $ques
                );
                // var_dump($ems_summary);die();
                $this->inc_model->insert_ems_summary($ems_summary);
            }
        }
        echo "<body style='background-color:#e6e6e6;'><div style='color:#2F7BBF;text-align:center;margin:50px;'><h2>Thank You! Feedback Submitted Successfully...!</h2></div></body>";die;
    
       
    //     $args = array(
    //         'fc_inc_ref_id' => $inc_details['fc_inc_ref_id'],
    //         'fc_inc_type' => $inc_details['fc_inc_type'],
    //         'fc_caller_number' => $inc_details['fc_caller_number'],
    //         'fc_caller_name' => $inc_details['fc_caller_name'],
    //         'fc_call_type' => $inc_details['fc_call_type'],
    //         'fc_dispatch_date_time' => $inc_details['fc_dispatch_date_time'],
    //         'fc_feedback_type' => $inc_details['fc_feedback_type'],
    //         'fc_standard_type' => json_encode($inc_details['fc_standard_type']),
    //         'fc_employee_remark' => $inc_details['fc_employee_remark'],
    //         'fc_base_month' => $this->post['base_month'],
    //         'fc_added_date' => $this->today,
    //         'fc_added_by' => $this->clg->clg_ref_id,
    //         'fc_modify_date' => $this->today,
    //         'fc_modify_by' => $this->clg->clg_ref_id,
    //     );

    //     if ($args['fc_caller_relation'] != '') {
    //         $args['fc_caller_relation'] = $inc_details['fc_caller_relation'];
    //     }

    //     if ($args['fc_ptn_name'] != '') {
    //         $args['fc_ptn_name'] = $inc_details['fc_ptn_name'];
    //     }

    //     if ($args['fc_ptn_age'] != '') {
    //         $args['fc_ptn_age'] = $inc_details['fc_ptn_age'];
    //     }

    //     if ($args['fc_inc_address'] != '') {
    //         $args['fc_inc_address'] = $inc_details['fc_inc_address'];
    //     }

    //     if ($args['fc_ptn_gender'] != '') {
    //         $args['fc_ptn_gender'] = $inc_details['fc_ptn_gender'];
    //     }


    //     $feedback = $this->feedback_model->add_feedback($args);



    //     if ($this->post['forword'] != '') {

    //         $arg = array(
    //             'sub_id' => $inc_details['fc_inc_ref_id'],
    //             'operator_id' => $this->clg->clg_ref_id,
    //             'operator_type' => $this->clg->clg_group,
    //             'base_month' => $this->post['base_month'],
    //             'sub_type' => $inc_details['fc_inc_type']
    //         );

    //         $res = $this->common_model->assign_operator($arg);

    //         if($inc_details['fc_feedback_type'] == 'negative_feedback'){
    //         $police_user = $this->inc_model->get_fire_user($sr_user, 'UG-Grievance');
       
    //         if($police_user){
    //             $police_operator2 = array(
    //                 'sub_id' => $inc_details['fc_inc_ref_id'],
    //                 'operator_id' => $police_user->clg_ref_id,
    //                 'operator_type' => 'UG-Grievance',
    //                 'sub_status' => 'ASG',
    //                 'sub_type' => $inc_details['fc_inc_type'],
    //                 'base_month' => $this->post['base_month']
    //             );


    //             $police_operator = $this->common_model->assign_operator($police_operator2);
    //         }
    //     }
    // }


        // if ($feedback_list) {
           
        //     $this->output->message = "<div class='success'>Details saved successfully</div><script>window.location.reload(true);</script>";
        // }
    }
}
