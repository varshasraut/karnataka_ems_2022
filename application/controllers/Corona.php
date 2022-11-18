<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Corona extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->load->model(array('corona_model','call_model','inc_model'));

         $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper','cct_helper'));

        $this->clg = $this->session->userdata('current_user');

        $this->post = $this->input->get_post(NULL);

        $this->post['base_month'] = get_base_month();

        $this->today = date('Y-m-d H:i:s');
        $this->pg_limit = $this->config->item('pagination_limit');
        

        $this->pg_limits = $this->config->item('report_clg');

        if ($this->post['hd_filter'] == 'reset') {
            $this->session->unset_userdata('hd_filter');
        }

        if ($this->session->userdata('hd_filter')) {
            $this->fdata = $this->session->userdata('hd_filter');
        }
    }

    public function index($generated = false) {

        echo "This is Corona dashaboard";
    }

    //// Created by MI42 //////////////////////////
    // 
    // Purpose : To confirm feedback call details.
    // 
    ///////////////////////////////////////////////

    function corona_list() {
        
        $this->pg_limit = 1000;
        //////////// Filter////////////
        //var_dump($this->post['pg_rec']);
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        ///////////set page number////////////////////
        $page_no = 1;
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        
                //////////////////////////limit & offset//////

        $data['get_count'] = TRUE;
        
        //$data['added_by'] = $this->clg->clg_ref_id;
        $data['extension_no'] = get_cookie("avaya_extension_no");

        //$data['total_count'] = $total_cnt = $this->corona_model->get_corona_list($data);
        $data['total_count'] = $total_cnt = $this->corona_model->get_updated_corona_list($data);

        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['ERO_HD'] = $data;

        $this->session->set_userdata('hd_filter', $ambflt);

        /////////////////////////////////////////////////////

        unset($data['get_count']);
        
//        var_dump($data);

        //$data['corona_list'] = $this->corona_model->get_corona_list($data,$offset, $limit);
        $data['corona_list'] = $this->corona_model->get_updated_corona_list($data,$offset, $limit);
        
        /////////////////////////////// Prev Calls /////////////////////////////

        $data['prev_cl_dtl']=array();
        
        foreach ($data['corona_list'] as $key=>$inc) {
            
            $args = array('follow_up_patient_id'=>$inc->corona_id);
            $output = $this->input->post('output');
          
           // $data['prev_cl_dtl'][$inc->corona_id] = $this->corona_model->get_followup_by_patient_id($args);
            $data['prev_cl_dtl'][$inc->corona_id] = $this->corona_model->get_updated_followup_by_patient_id($args);
            $data['corona_list'][$key]->call_count = count($data['prev_cl_dtl'][$inc->corona_id] );
        }
       // var_dump($data['corona_list']);
        
        $call_count = array_column($data['corona_list'], 'call_count');

        array_multisort($call_count, SORT_ASC, $data['corona_list']);
        

        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("corona/corona_list"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc&pg_rec=".$limit
            )
        );


        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);

        
        //var_dump($data['corona_list']);die();
        $this->output->add_to_position($this->load->view('frontend/corona/corona_list_view', $data, TRUE), 'content', TRUE);
        
         $this->output->template = "calls";
        
    }
    function add_follow_up(){
        
        $id = $this->input->post('id');
        $args = array('corona_id'=>$id);
       //var_dump($args);
        $data['corona_patient'] = $this->corona_model->get_corona_list($args);
        //var_dump( $data['corona_patient']);
        
        $this->output->add_to_position($this->load->view('frontend/corona/follow_up_view', $data, TRUE), 'content', TRUE);
    }
//    function save_follow_up(){
//        
//         $main_data = array('follow_up_patient_id' => $this->input->post('corona_id'),
//            'added_by' => $this->clg->clg_ref_id,
//            'added_date' => date('Y-m-d H:i:s'),
//            'follow_up_date' => date('Y-m-d'),
//            'follow_up_isdeleted' => '0');
//        $followup_id = $this->corona_model->insert_follow_up($main_data);
//
//             $corona_data = array('corona_id' => $this->input->post('corona_id'),
//                            'is_case_close' =>  $this->input->post('is_case_close'));
//        $corona_update_id = $this->corona_model->update_corona_call($corona_data);
//                foreach ($this->post['follow'] as $dt) {
//                    
//   
//                        $dt['follow_up_id'] = $followup_id;
//                        $dt['corona_id'] = $this->input->post('corona_id');
//                        //$dt['full_name '] = $dt['patient_name'];
//                        $dt['added_by '] = $this->clg->clg_ref_id;
//                        $dt['added_date '] = date('Y-m-d H:i:s');
//                        $dt['follow_up_date'] = date('Y-m-d');
//
//                        $result = $this->corona_model->insert_corona_followup_details($dt);
//                       // die();
//                    
//                }
//               // die();
//
//
//        if ($result) {
//
//            $this->output->status = 1;
//
//             $this->output->message = "<div class='success'>Follow up Added successfully! <script>window.location.reload(true);</script></div>";
//
//            $this->output->closepopup = 'yes';
//
//            //$this->corona_list();
//        }
//    }
            function save_follow_up(){
        
           
         $main_data = array('follow_up_patient_id' => $this->input->post('corona_id'),           
                            'added_by' => $this->clg->clg_ref_id,
                            'added_date' => date('Y-m-d H:i:s'),
                            'follow_up_date' => date('Y-m-d H:i:s'));
      
         
        $followup_id = $this->corona_model->insert_updated_follow_up($main_data);
      



        
                foreach ($this->post['follow'] as $dt) {
                    
   
                        $dt['follow_up_id'] = $followup_id;
                         $dt['corona_id'] = $this->input->post('corona_id');
                        //$dt['full_name '] = $dt['patient_name'];
                        $dt['added_by '] = $this->clg->clg_ref_id;
                        $dt['added_date '] = date('Y-m-d H:i:s');
                        $dt['follow_up_date'] = date('Y-m-d H:i:s');
                       // $call_status = $dt['is_phone_connected'];

                        $result = $this->corona_model->insert_updated_corona_followup_details($dt);
                      // var_dump($result);
       // die();
  
                    
                }
              
        $corona_data = array('corona_id' => $this->input->post('corona_id'),
                             'patient_age' => $this->post['follow'][0]['patient_age'],
                            'is_case_close' =>  $this->input->post('is_case_close'),
                            'is_phone_connected' =>  $this->post['follow'][0]['is_phone_connected']);
        $corona_update_id = $this->corona_model->update_new_corona_call($corona_data);

        if ($result) {

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Follow up Added successfully! <script>window.location.reload(true);</script></div>";
            $this->output->closepopup = 'yes';
        }
    }
    function view_case(){
        
        $id = $this->input->post('id');
        $args = array('follow_up_patient_id'=>$id);
        $output = $this->input->post('output');
        $data['patient_calls'] = $this->corona_model->get_followup_by_patient_id($args);
        

        $this->output->add_to_position($this->load->view('frontend/corona/view_case_view', $data, TRUE), $output, TRUE);
    }
    function view_call_details(){
        $id = $this->input->post('id');
        $args = array('follow_up_id'=>$id);
        //$data['call_details'] = $this->corona_model->get_followup_details($args);
        $data['call_details'] = $this->corona_model->get_updated_followup_details($args);
        //var_dump($data['call_details']);
        
        // var_dump($data['call_details']);
       // die();

        $this->output->add_to_position($this->load->view('frontend/corona/follow_up_details_view', $data, TRUE), 'content', TRUE);
    }
    function confirm_corona_save(){
        //var_dump($this->input->post);die();
        $this->session->unset_userdata('call_type');
        
        $Question_answer = $this->input->get_post('incient');
        //var_dump($Question_answer);die();
        $call_type = $this->input->get();
        $inc_post_details = $this->input->post();
        
         $this->session->unset_userdata('inc_ref_id');
        $inc_id = $this->session->userdata('inc_ref_id');
        //$ques_ans = $this->input->get_post('ques');
        // var_dump($ques_ans);
        if ($inc_id == '') {
            $inc_id = generate_inc_ref_id();
            $this->session->set_userdata('inc_ref_id', $inc_id);
        }

        $data['inc_ref_id'] = 'H-'.$inc_id;
       
        $incient = $this->input->get_post('incient');
        $patient = $this->input->get_post('patient');
        $caller_details = $this->input->get_post('caller');
        $call_type = $this->input->get_post('call_type');
       // var_dump($incient);die();


        $dup_inc = $inc_details['dup_inc'];

        $call_id = $this->input->get_post('call_id');
        $this->session->set_userdata('call_type', $patient['inc_type']);
        $this->session->set_userdata('call_id', $call_id);
        $this->session->set_userdata('patient', $patient);
        $this->session->set_userdata('incient', $incient);



        $session_caller_details = $this->session->userdata('caller_details');


        $this->session->set_userdata('inc_post_details', $inc_post_details);
         $corona_patient_call = array(
            'inc_ref_id' => $data['inc_ref_id'],
            'base_month' => $this->post['base_month'],
            'added_by' => $this->clg->clg_ref_id,
            'added_date ' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date ' => date('Y-m-d H:i:s'),
            'mobile_no'=>$patient['patient_mobile_no'],
           'city_id' => $inc_post_details['incient_ms_city'],
           'state' => $inc_post_details['incient_state'],
           'full_name' => $patient['full_name'],
           'patient_age' => $patient['age'],
           'patient_gender' => $patient['gender'],
           'patient_dob' => $patient['dob'],
           'address' => $patient['address'],
           'carona_test_date' => date('Y-m-d H:i:s',strtotime($patient['covid_test_date'])), 
           'designation' => $patient['designation'],
           'emp_code' => $patient['emp_code'],
           'Shatplus_status' => $patient['Shatplus_status'],
           'Arsenicum_status' => $patient['Arsenicum_status'],
           'covid_status' => $patient['covid_status'],

           'covid_test' => $patient['covid_test'],
           'covid_test_date' => $patient['covid_test_date'],
           'covid_tst_result_date' => $patient['covid_tst_result_date'],
           
           'Shatplus_by' => $patient['Shatplus_Name'],
           'Shatplus_date' => $patient['Shatplus_date'],
           'Shatplus_Quantity' => $patient['Shatplus_Quantity'],

           'Arsenicum_date' => $patient['Arsenicum_date'],
           'Arsenicum_by' => $patient['Arsenicum_Name'],
           'Arsenicum_Quantity' => $patient['Arsenicum_Quantity'],


            'ques_other_ans' => json_encode($incient['other']),
           'tahsil_id' => $inc_post_details['incient_tahsil'],
           'district_id' => $inc_post_details['incient_district'],
           'avaya_unique_id'=> $this->session->userdata('CallUniqueID')
        );
        $this->session->set_userdata('corona_call_details', $corona_patient_call);
       
        $corona_call = array(
            'inc_ref_id' => $data['inc_ref_id'],
            'inc_ero_standard_summary' => $patient['inc_ero_standard_summary'],
            'inc_ero_summary' => $patient['inc_ero_summary'],
            'inc_base_month' => $this->post['base_month'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_datetime' => date('Y-m-d H:i:s'),
            'inc_dispatch_time' => $patient['caller_dis_timer'],
            'inc_recive_time' => $patient['inc_recive_time'],
            'inc_type' => $patient['inc_type'],
            'inc_cl_id' => $this->input->post('call_id'),
           'inc_city_id' => $inc_post_details['incient_ms_city'],
           'inc_state_id' => $inc_post_details['incient_state'],
           'inc_address' => $patient['address'],
           'inc_tahshil_id' => $inc_post_details['incient_tahsil'],
           'inc_district_id' => $inc_post_details['incient_district'],
           'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
        );


        $this->session->set_userdata('corona_call_inc_details', $corona_call);


        $data['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $patient['inc_ero_standard_summary']));

        $data['patient'] = $patient;
        
        $data['caller_details'] = $session_caller_details;
        $data['standard_remark'] = $data['standard_remark'][0]->re_name;

        $data['cl_type'] = $call_type;
        
        $data['Question_answer'] = $Question_answer;
        $this->output->add_to_popup($this->load->view('frontend/corona/confirm_corona_view', $data, TRUE), '600', '560');
    }
    function save_corona(){   

        $args = $this->session->userdata('patient');
        $patient_args = $this->session->userdata('patient');
        $incient = $this->session->userdata('incient');
        $call_type = $this->session->userdata('call_type');
        $cl_type = $this->input->get_post('cl_type');
        $ques_ans = $incient['ques'];
       
        $pur_args=array('pcode'=>$call_type);
        $child_purpose_of_calls = $this->call_model->get_purpose_of_calls($pur_args);
        $call_name = $child_purpose_of_calls[0]->pname;
        
        $corona_call_details =$inc_args = $this->session->userdata('corona_call_details');
       // var_dump($corona_call_details);die();
       // $cl_id = $this->corona_model->insert_corona_call($corona_call_details);
        $cl_id = $this->corona_model->insert_updated_corona_call($corona_call_details);
      

        $inc_args = $this->session->userdata('corona_call_inc_details');
        
        $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_args['inc_ref_id']));
        if(!empty($is_exits)){
            $this->output->message = "<div class='error'>Incident Id alredy exists</div>";
            return;
        }

        $inc_data = $this->inc_model->insert_inc($inc_args);
        $inc_id = $inc_args['inc_ref_id'];

        $this->session->unset_userdata('ambuse_call_details');


        $args = array(
            'sub_id' => $inc_id,
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'base_month' => $this->post['base_month'],
            'sub_type' => $call_type
        );

        $res = $this->common_model->assign_operator($args);
        
        if ($cl_type == 'transfer_hd') {

            $super_user = $this->inc_model->get_user_by_group('UG-ERO-HD');


            $args = array(
                'sub_id' => $inc_id,
                'operator_id' => $super_user->clg_ref_id,
                'operator_type' => $super_user->clg_group,
                'base_month' => $this->post['base_month'],
                'sub_type' => $call_type
            );


            $forword_res = $this->common_model->assign_operator($args);        
             _ucd_hd_assign_call($inc_id,$this->clg->clg_group);
        }
        if (isset($ques_ans)) {
            foreach ($ques_ans as $key => $ques) {

                $ems_summary = array('sum_base_month' => $this->post['base_month'],
                    'sum_sub_id' => $inc_id,
                    'sum_sub_type' => $patient_args['inc_type'],
                    'sum_que_id' => $key,
                    'sum_que_ans' => $ques
                );

                $this->inc_model->insert_ems_summary($ems_summary);
            }
        }

        //////////////////////////////////////////////////////            

        if ($res) {

            $this->output->status = 1;

            $this->output->closepopup = "yes";

            $this->output->message = "<h3>".$call_name."</h3><br><p>$call_name call details save successfully.</p><script>window.location.reload(true);</script>";

            $this->output->moveto = 'top';

            //$this->output->add_to_position('', 'content', TRUE);
        }
    
    }
        function confirm_corona_enquiry() {

        $this->session->unset_userdata('corona_enquiry');
        $this->session->unset_userdata('call_id');


        $inc_details = $this->input->get_post('incient');
        
        $perv_inc_ref_id = $this->input->get_post('inc_id');
      
        $patient = $this->input->get_post('patient');
        $inc_post_details = $this->input->post();


        $inc_id = $this->session->userdata('inc_ref_id');
        if ($inc_id == '') {
            $inc_id = generate_inc_ref_id();
            update_inc_ref_id($inc_id);
            $this->session->set_userdata('inc_ref_id', $inc_id);
        }

        $data['inc_ref_id'] = $inc_id;

        $corona_enquiry_call = array(
            'inc_ref_id' => $inc_id,
            'inc_ero_summary' => $patient['inc_ero_summary'],
            'inc_base_month' => $this->post['base_month'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'inc_datetime' => date('Y-m-d H:i:s'),
            'inc_dispatch_time' => $patient['caller_dis_timer'],
            'inc_recive_time' => $patient['inc_recive_time'],
            'inc_type' => $patient['inc_type'],
            'inc_cl_id' => $this->input->post('call_id'),
            //'inc_city_id' => $inc_post_details['incient_ms_city'],
           //'inc_state_id' => $inc_post_details['incient_state'],
           //'inc_address' => $patient['address'],
           //'inc_tahshil_id' => $inc_post_details['incient_tahsil'],
           //'inc_district_id' => $inc_post_details['incient_district'],
           // 'pre_inc_ref_id'=> $perv_inc_ref_id,
            'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
            
        );

       
        $this->session->set_userdata('corona_enquiry', $corona_enquiry_call);


        $data['inc_ero_summary'] = $patient['inc_ero_summary'];

        $data['inc_ref_id'] = $inc_id;
        $data['inc_ero_summary'] = $patient['inc_ero_summary'];

    
        if ($patient['inc_type'] == 'CORONA_GENERAL_ENQUIRY_AD') {
               $this->output->add_to_popup($this->load->view('frontend/corona/confirm_corona_enquiry_ad', $data, TRUE), '600', '250');
        }else if ($patient['inc_type'] == 'CORONA_GENERAL_ENQUIRY') {
               $this->output->add_to_popup($this->load->view('frontend/corona/confirm_corona_enquiry', $data, TRUE), '600', '250');
        }
    }

    function save(){
        

        $args = $this->session->userdata('corona_enquiry');
        
        $call_type = $args['inc_type'];
       
        $pur_args=array('pcode'=>$call_type);
        $child_purpose_of_calls = $this->call_model->get_purpose_of_calls($pur_args);
        $call_name = $child_purpose_of_calls[0]->pname;
       

        $inc_args = $this->session->userdata('corona_enquiry');
        
        $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_args['inc_ref_id']));
        if(!empty($is_exits)){
            $this->output->message = "<div class='error'>Incident Id alredy exists</div>";
            return;
        }

        $inc_data = $this->inc_model->insert_inc($inc_args);
        //var_dump($inc_data);
        //die();

          $inc_id = $inc_args['inc_ref_id'];
            //update_inc_ref_id($inc_id);

        $this->session->unset_userdata('corona_enquiry');


        $args = array(
            'sub_id' => $inc_id,
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'base_month' => $this->post['base_month'],
            'sub_type' => $call_type
        );

        $res = $this->common_model->assign_operator($args);


        //////////////////////////////////////////////////////            

        if ($res) {

            $this->output->status = 1;

            $this->output->closepopup = "yes";

            $this->output->message = "<h3>".$call_name."</h3><br><p>$call_name call details save successfully.</p><script>window.location.reload(true);</script>";

            $this->output->moveto = 'top';

            //$this->output->add_to_position('', 'content', TRUE);
        }
    }
        
    function corona_call_type_report(){
        
        $this->output->add_to_position($this->load->view('frontend/corona/corona_call_type_report_view', $data, TRUE), 'content', TRUE);
    }
    
    function save_upload_corona_calls(){
          $post_data = $this->input->post();
          
          //$corona_id = $this->corona_model->get_max_corona_id();
          $corona_id = $this->corona_model->get_updated_max_corona_id();
          $max_corona_id =$corona_id[0]->corona_id;

      
        $filename = $_FILES["file"]["tmp_name"];
//        var_dump($_FILES["file"]["size"]);
//        die();

        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($filename, "r");
            while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
                $column_count = count($getData);
                if ($column_count == 34) {

                    //$emp_inc_data = $this->inc_model->get_amb_default_emp($getData[0], $getData[1], date('Y-m-d', strtotime($getData[2])));
                 //   if ($emp_inc_data) {
                    
                $max_corona_id++;
                        $team_data = array(
                    'corona_id'=>$max_corona_id,
                    'inc_ref_id'=>$getData[0],
                    'full_name'=>$getData[1],
                    'patient_age'	=>$getData[2],
                    'patient_dob'=>$getData[3],
                    'patient_gender'=>$getData[4],
                    'mobile_no'=>$getData[5],
                    'designation'=>$getData[6],
                    'emp_code'=>$getData[7],
                    'Shatplus_status'=>$getData[8],
                     'Arsenicum_status'=>$getData[9],
                     'covid_status'=>$getData[10],
                     'covid_test'=>$getData[11],
                     'covid_test_date'=>$getData[12],
                     'covid_tst_result_date'=>$getData[13],
                     'Shatplus_by'=>$getData[14],
                     'Shatplus_date'=>$getData[15],
                     'Shatplus_Quantity'=>$getData[16],
                     'Arsenicum_by'=>$getData[17],
                     'Arsenicum_date'=>$getData[18],
                     'Arsenicum_Quantity'=>$getData[19],
                     'state'=>$getData[20],
                     'district_id'=>$getData[21],
                     'tahsil_id'=>$getData[22],
                     'city_id'=>$getData[23], 
                     'address'=>$getData[24],
                     'avaya_unique_id'=>$getData[25],
                     'is_deleted'=>$getData[26],
                      'is_case_close'=>$getData[27],
                      'carona_test_date'=>$getData[28],
                      'base_month'=>$getData[29],
                      'added_by'=>$getData[30],
                      'added_date'=>$getData[31],
                       'modify_by'=>$getData[32],
                       'modify_date'=>$getData[33],
                        'ques_other_ans'=>'');

                        //$insert = $this->corona_model->insert_corona_call($team_data);
                         $insert = $this->corona_model->insert_updated_corona_call($team_data);
                       
                        $message = "Error in file";
                        
                   
                } else {
                    $message = "column count not match";
                    //$this->output->message = "<div class='error'>" . "Manage team column count not match" . "</div>";
                }
            }
              
            if ($insert) {

                $this->output->closepopup = 'yes';
                $this->output->status = 1;
                $this->output->message = "<div class='success'>" . "added successfully" . "<script>$('.module_uploadcorona .uploadcorona_ico').click();</script></div>";
                $this->corona_call_type_report();
            } else {
                $this->output->message = "<div class='error'>" . $message . "</div>";
            }
        }
    }
}
