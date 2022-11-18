<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Clinical extends EMS_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->active_module = "M-CLINICAL_GOV";
        $this->pg_limit = $this->config->item('pagination_limit');
        $this->load->model(array('pet_model', 'call_model', 'clinical_model', 'get_city_state_model', 'options_model', 'module_model', 'common_model', 'Pet_model', 'Ercp_model', 'amb_model', 'inc_model', 'colleagues_model', 'pcr_model', 'cluster_model', 'medadv_model', 'enquiry_model', 'module_model', 'feedback_model', 'quality_model', 'grievance_model', 'police_model', 'fire_model', 'problem_reporting_model', 'hp_model', 'shiftmanager_model', 'biomedical_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper', 'language_helper', 'cct_helper', 'dash_helper', 'coral_helper'));
        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));
        $this->site_name = $this->config->item('site_name');
        $this->post = $this->input->get_post(NULL);
        $this->post['base_month'] = get_base_month();
        $this->site = $this->config->item('site');
        $this->sess_expiration = $this->config->item('sess_expiration');
        $this->clg = $this->session->userdata('current_user');
        $this->default_state = $this->config->item('default_state');
        $this->clg = $this->session->userdata('current_user');
        $this->today = date('Y-m-d H:i:s');
        $this->avaya_server_url = $this->config->item('avaya_server_url');

        if ($this->post['filters'] == 'reset') {
            $this->session->unset_userdata('filters')['AMB'];
        }
        if ($this->session->userdata('filters')['AMB']) {

            $this->fdata = $this->session->userdata('filters')['AMB'];
        }
        $this->post['base_month'] = get_base_month();
        $this->clg = $this->session->userdata('current_user');
    }

    public function index($generated = false)
    {
        echo "This Is Clinical Controller";
    }

    function ptn_record_view()
    {


        $search_data = $this->input->post();
        if (empty($search_data)) {
            $search_data = $this->input->get();
        }


        $position = $this->input->post('output_position');

        if ($position == "") {
            $position =   "single_record_details";
        }

        $current_user = $this->clg->clg_ref_id;

        $args = array();
        $get['inc_ref_id'] = trim($this->input->get('inc_ref_id'));

        if ($get['inc_ref_id'] == '') {
            $args = array('inc_ref_id' => trim($this->input->post('inc_ref_id')), 'from_date' => $incident_date, 'to_date' => $incident_date);
            $get['inc_ref_id'] = trim($this->input->post('inc_ref_id'));
        } else {
            $args = array('inc_ref_id' => trim($this->input->get('inc_ref_id')), 'from_date' => $incident_date, 'to_date' => $incident_date);
            $get['inc_ref_id'] = trim($this->input->get('inc_ref_id'));
        }


        $get_inc_date = str_replace('A-', '', trim($get['inc_ref_id']));
        $get_inc_date = str_replace('BK-', '', $get_inc_date);
        $year = substr($get_inc_date, 0, 4);
        $month = substr($get_inc_date, 4, 2);
        $date = substr($get_inc_date, 6, 2);
        $incident_date = $year . '-' . $month . '-' . $date;

        $data['inc_call_type'] = $this->inc_model->get_inc_ref_id($args);



        if (!empty($data['inc_call_type'])) {


            $data['inc_ref_no'] = $get['inc_ref_id'];


            if ($data['inc_call_type'][0]->inc_type != 'AD_SUP_REQ') {

                $data['inc_details'] = $this->inc_model->get_inc_details_ref_id($args);
            } else {

                $data['inc_details'] = $this->inc_model->get_inc_call_details_ref_id($args);
            }

            $data['inc_list'] = $this->medadv_model->get_inc_by_ercp($args, $offset, $limit);


            if ($data['inc_details'][0]->police_chief_complete != '') {
                $args_police = array('po_ct_id' => $data['inc_details'][0]->police_chief_complete);
                $police_comp = $this->call_model->get_police_chief_comp($args_police);
                $data['po_ct_name'] = $police_comp[0]->po_ct_name;
            }

            if ($data['inc_details'][0]->fire_chief_complete != '') {
                $args_fire = array('fi_ct_id' => $data['inc_details'][0]->fire_chief_complete);
                $fire_comp = $this->call_model->get_fire_chief_comp($args_fire);
                $data['fi_ct_name'] = $fire_comp[0]->fi_ct_name;
            }

            if ($data['inc_details'][0]->inc_ero_standard_summary != '') {
                $args_remark = array('re_id' => $data['inc_details'][0]->inc_ero_standard_summary);
                $standard_remark = $this->call_model->get_ero_summary_remark($args_remark);

                $data['re_name'] = $standard_remark[0]->re_name;
            }

            $standard_remark = $data['inc_details'][0]->inc_ero_standard_summary;
            $data['re_name'] = $standard_remark;
            $args_pur = array('pcode' => $data['inc_details'][0]->cl_purpose);

            $call_pur = $this->inc_model->get_purpose_call($args_pur);
            $data['pname'] = $call_pur[0]->pname;


            if ($data['inc_details'][0]->inc_suggested_amb != '' && $data['inc_details'][0]->inc_type != 'on_scene_care') {
                $args_amb_type = array('inc_suggested_amb' => $data['inc_details'][0]->inc_suggested_amb);
                $amb_type = $this->inc_model->get_sugg_amb_type($args_amb_type);
                $data['ambt_name'] = $amb_type[0]->ambt_name;
            }

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
            $args_pt = array(
                'get_count' => TRUE,
                'inc_ref_id' => $data['inc_ref_no']
            );

            $data['ptn_count'] = $this->pcr_model->get_pat_by_inc($args_pt);

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

            $inc_audit_args = array(
                'inc_ref_id' => $data['inc_ref_no']
            );
            $data['audit_questions'] = $this->inc_model->get_inc_audit_summary($inc_audit_args);

            $amb_args = array('inc_ref_id' => $data['inc_ref_no'], 'from_date' => $incident_date, 'to_date' => $incident_date);

            $data['enquiry_data'] = $this->enquiry_model->get_enquiry($amb_args);

            $myArray = explode(',', $data['enquiry_data'][0]->enq_que);


            $data['enq_que'] = array();
            $q = 0;

            if (is_array($myArray)) {
                foreach ($myArray as $que) {

                    $enq_que = $this->common_model->get_question(array('que_id' => $que));

                    $serialize_que = $enq_que[0]->que_question;

                    $data['enq_que'][$q]['que'] = get_lang_data($serialize_que, $data['enquiry_data'][0]->enq_lang);

                    $ans = $this->common_model->get_answer(array('ans_que_id' => $que));

                    $serialize_ans = $ans[0]->ans_answer;

                    $data['enq_que'][$q]['ans'] = get_lang_data($serialize_ans, $data['enquiry_data'][0]->enq_lang);

                    $data['enq_que'][$q]['que_id'] = $que;

                    $q++;
                }
            }

            $data['amb_data'] = $this->inc_model->get_inc_details($amb_args);


            $data['sms_data'] = $this->inc_model->get_inc_sms_response($data['inc_ref_no']);

            $ptn_args = array(
                'inc_ref_id' => $data['inc_ref_no'],
                //                'ptn_id' => $data['inc_details'][0]->ptn_id,
                'from_date' => $incident_date,
                'to_date' => $incident_date
            );

            $data['ptn_details'] = $this->Pet_model->get_ptinc_info($ptn_args);



            $inc_args = array(
                'inc_ref_id' => trim($data['inc_ref_no']),
                'from_date' => $incident_date,
                'to_date' => $incident_date
            );


            $data['facility_details'] = $this->inc_model->get_hospital_facility(array('inc_ref_id' => trim($data['inc_ref_no'])));


            $data['folloup_details'] = $this->inc_model->get_followupinc(array('inc_ref_id' => trim($data['inc_ref_no'])));


            $data['feedback_details'] = $this->feedback_model->get_feedback_details(array('inc_ref_id' => trim($data['inc_ref_no'])));



            $data['epcr_inc_details'] = $this->pcr_model->get_epcr_inc_details_by_inc_id_cli($inc_args);
            // var_dump($data['epcr_inc_details']);die;
            $data['er_inc_details'] = $this->medadv_model->get_epcr_by_inc_id($inc_args);

            $data['driver_data'] = $this->pcr_model->get_driver(array('inc_ref_id' => trim($data['inc_ref_no']), 'from_date' => $incident_date, 'to_date' => $incident_date));
            $data['tdo_id'] = $this->call_model->get_tdo_inc($data['inc_ref_no']);
        }

        $gri_args = array(
            'gc_inc_ref_id' => trim($data['inc_ref_no'])
        );


        $data['grievance_info'] = $this->grievance_model->get_inc_by_grievance($gri_args, '', '', $filter, $sortby);

        $args = array('gc_inc_ref_id' => $data['inc_ref_no']);

        $data['cl_dtl'] = $this->grievance_model->get_inc_by_grievance($args);

        $sup_remark_args = array(
            's_inc_ref_id' => trim($data['inc_ref_no'])
        );
        $data['supervisor_remark'] = $this->call_model->get_inc_supervisor_remark($sup_remark_args);


        $this->output->add_to_position($this->load->view('frontend/clinical/record_view', $data, TRUE), $position, TRUE);


        $this->output->set_focus_to = "inc_ref_id";
    }


    public function clinical_list($generated = false) {
        $data['message'] = $this->session->flashdata('message');

        $user_group=$this->clg->clg_group;
    
        $district_id = $this->clg->clg_district_id;
        $this->pg_limit = 10;

        $data['page_no'] = ($this->post['page_no'] || $this->post['pglnk']) ? $this->post['page_no'] : $this->fdata['page_no'];
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        $page_no = 1;
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        if ($this->post['filters'] == 'reset') {
            $this->session->unset_userdata('epcr_filter');
   
        }
        
       
        $data['amb_reg_id'] = "";
        $data['filter'] = $filter = "";
        $data['filter'] = $_POST['filter'] ? $this->post['filter'] : $this->fdata['filter'];

        $data['amb_reg_id_new'] = $_POST['amb_reg_id_new'] ? $this->post['amb_reg_id_new'] : $this->fdata['amb_reg_id_new'];
        $data['amb_reg_id'] = $_POST['amb_reg_id'] ? $this->post['amb_reg_id'] : $this->fdata['amb_reg_id'];
        $data['district_id'] = $_POST['district_id'] ? $this->post['district_id'] : $this->fdata['district_id'];
        $data['inc_date'] = $_POST['inc_date'] ? $this->post['inc_date'] : $this->fdata['inc_date'];
        $data['hp_id'] = $_POST['hp_id'] ? $this->post['hp_id'] : $this->fdata['hp_id'];
        $data['inc_id'] = $_POST['inc_id'] ? $this->post['inc_id'] : $this->fdata['inc_id'];
        $data['dco_id'] = $_POST['dco_id'] ? $this->post['dco_id'] : $this->fdata['dco_id'];
        $data['provider_impressions'] = $_POST['provider_impressions'] ? $this->post['provider_impressions'] : $this->fdata['provider_impressions'];
        $data['provider_casetype'] = $_POST['provider_casetype'] ? $this->post['provider_casetype'] : $this->fdata['provider_casetype'];
        
        $data['epcr_call_types'] = $_POST['epcr_call_type'] ? $this->post['epcr_call_type'] : $this->fdata['epcr_call_type'];
        
        
        
        $sortby['close_by_emt'] = '0';

        if (isset($data['filter'])) {


            if ($data['filter'] == 'amb_reg_no') {
                $filter = '';
                $sortby['amb_reg_id'] = $data['amb_reg_id'];
                $data['amb_reg_id'] = $sortby['amb_reg_id'];
            } else if ($data['filter'] == 'dst_name') {
                $filter = '';
                $sortby['district_id'] = $data['district_id'];
                $data['district_id'] = $sortby['district_id'];
                 
            } else if ($data['filter'] == 'hp_name') {
               
                $filter = '';
                $sortby['hp_id'] = $data['hp_id'];
                $data['hp_id'] = $data['hp_id'];
                $hp_args = array('hp_id' => $data['hp_id']);
                $hp_data = $this->hp_model->get_hp_data($hp_args);
                $data['hp_name'] = $hp_data[0]->hp_name;
            } else if ($data['filter'] == 'inc_datetime') {
                $filter = '';
                $sortby['inc_date'] = date('Y-m-d', strtotime($_POST['inc_date']));
                $data['inc_date'] = $data['inc_date'];
            } else if ($data['filter'] == 'inc_ref_id') {
                $filter = '';
                $sortby['inc_id'] = $data['inc_id'];
                $data['inc_id'] = $data['inc_id'];
            }
            else if ($data['filter'] == 'close_by_emt') {
                $filter = '';
                $sortby['close_by_emt'] = '1';
                $data['close_by_emt'] = $sortby['close_by_emt'];
                $sortby['district_id'] = $data['district_id'];
                $data['district_id'] = $sortby['district_id'];
                $sortby['amb_reg_id_new'] = $data['amb_reg_id_new'];
                $sortby['provider_impressions'] = $data['provider_impressions'];
                $sortby['provider_casetype'] = $data['provider_casetype'];
                $sortby['epcr_call_types'] = $data['epcr_call_types'];
                $data['amb_reg_id_new'] = $sortby['amb_reg_id_new'];
                $sortby['inc_id'] = $data['inc_id'];
                $data['inc_id'] = $data['inc_id'];
                
            }
            else if ($data['filter'] == 'reopen_id') {
                $filter = ''; 
                $sortby['reopen_id'] = '1';
                $data['reopen_id'] = $data['reopen_id'];
                 $data['reopen_case'] = 'y';
                
            }
        }

        $this->session->set_userdata('epcr_filter', $data);

        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        // if ($this->clg->clg_group == 'UG-REMOTE' || $this->clg->clg_group == 'UG-DCO' || $this->clg->clg_group == 'UG-ADMIN' || $this->clg->clg_group == 'UG-DCO-102' || $this->clg->clg_group == 'UG-BIKE-DCO') {
        //     $args_dash = array(
        //         'base_month' => $this->post['base_month']
                
        //     );
        // }else if($this->clg->clg_group == 'UG-DCOSupervisor'){           
            
        //     $args['clg_senior'] = $this->clg->clg_ref_id;
        //     $data['clg_senior'] = $this->clg->clg_ref_id;
            
            
        //     $clg_args = array('clg_senior'=>$this->clg->clg_ref_id,'clg_group'=>'UG-DCO');
           
        //     $data['dco_clg'] = $this->colleagues_model->get_clg_data($clg_args);
            
          
            
        //     foreach($data['dco_clg'] as $dco){
        //         $child_dco[] = $dco->clg_ref_id;
        //     }

        //     if(is_array($child_dco)){
        //         $child_dco = implode("','", $child_dco);
        //     }
            
            
        //     if ( $data['dco_id']  != '') {
        //         $args_dash['operator_id'] = $this->post['dco_id'];
        //     }else{
        //        // $args_dash['child_dco'] = $this->fdata['dco_id'];
        //     }
            
        // } else {
        //     $args_dash = array(
        //         'operator_id' => $this->clg->clg_ref_id,
        //         'base_month' => $this->post['base_month']
        //     );
        // }
        
        
        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        $data['get_count'] = TRUE;
        
        $first_amb_args = array('system_type' => $args_dash['system_type'],
                                'amb_reg_id'=>$data['amb_reg_id'],
                                'thirdparty' => $this->clg->thirdparty,
                                'base_month' => $this->post['base_month']);
        

        $data['default_state']=$this->default_state;

        $args_dash['thirdparty']=$this->clg->thirdparty;
        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->clinical_model->get_list_data($args_dash, $offset, $limit, $filter, $sortby);

        unset($args_dash['get_count']);

        $inc_info = $this->clinical_model->get_list_data($args_dash, $offset, $limit, $filter, $sortby);
    
        $data['per_page'] = $limit;
        $data['inc_offset'] = $offset;

        $data['inc_info'] = $inc_info;

        $data['total_count'] = $total_cnt;

        $data['per_page'] = $limit;

        $pgconf = array(
            'url' => base_url("clinical/clinical_list"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
            )
        );
        
        $report_args = array(
            'clg_ref_id'=>$this->clg->clg_ref_id,
            'single_date' => date('Y-m-d'),
            'base_month' => $this->post['base_month']
        );
        $data['login_details'] = $this->shiftmanager_model->get_login_details_ero($report_args);

    

        // $start_date_amb = date('Y-m-d', strtotime($post_reports['from_date']));
        // $end_date_amb = date('Y-m-t', strtotime($post_reports['from_date']));


        // $quality_args = array(
        //     'base_month' => $this->post['base_month'],
        //     'user_type' => 'ERO',
        //     'from_date' => $current_month_date,
        //     'to_date' => $END_day,
        //     'qa_ad_user_ref_id' => $this->clg->clg_ref_id);

        // $data['audit_details'] = $this->quality_model->get_quality_audit($quality_args);
        
        // $today_validate = array(
        //     'from_date' => $current_date,
        //     'to_date' => $current_date,
        //     'clg_ref_id' => $this->clg->clg_ref_id,
        //     'get_count' => TRUE);

        // $data['today_validation'] = $this->pcr_model->dco_validation_report($today_validate);
       
       
        
        // $month_validate = array(
        //     'from_date' => $current_month_date,
        //     'to_date' => $END_day,
        //     'clg_ref_id' => $this->clg->clg_ref_id,
        //     'get_count' => TRUE);

        // $data['mdt_validation'] = $this->pcr_model->dco_validation_report($month_validate);
        $id = array(
            'inc_ref_id' => $this->post['inc_ref_id']
         );
        //  var_dump($id);die();
        $data['clinical_view'] = $this->clinical_model->get_clinical_data($id);   
         

        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);
        $data['default_state'] = $this->default_state;
        // $this->output->add_to_position('', 'caller_details', TRUE);
        $this->output->add_to_position($this->load->view('frontend/clinical/clinical_view', $data, TRUE), $this->post['output_position'], TRUE);
        
        
    }

    public function clinical_save(){
        $user =$this->clg->clg_ref_id;
        if($this->input->post('save'))
		{
		    $data['inc_ref_id']=$this->input->post('inc_ref_no');
			$data['pro_rec']=$this->input->post('pro_btn');
			$data['pregnancy_rec']=$this->input->post('pre_btn');

            $data['consent_rec']=$this->input->post('consent');
            $data['consent_remark']=$this->input->post('consent_remark');
            $data['inter_rec']=$this->input->post('inter');
            $data['inter_remark']=$this->input->post('inter_remark');
            $data['police_rec']=$this->input->post('police');
            $data['police_remark']=$this->input->post('police_remark');



			$data['initial_rec']=$this->input->post('ini_btn');
			$data['Baseline_rec']=$this->input->post('bas_btn');
			$data['ongoing_rec']=$this->input->post('ong_btn');
			$data['handover_rec']=$this->input->post('han_btn');
            $data['pro_remark']=$this->input->post('ptn_remark');
			$data['ercp_rec']=$this->input->post('adv_btn');
			$data['ercp_remark']=$this->input->post('ercp_adv_remark');
			$data['consumable_rec']=$this->input->post('dc_btn');
			$data['consumable_remark']=$this->input->post('dc_remark');
			$data['destination_rec']=$this->input->post('dh_btn');
			$data['destination_remark']=$this->input->post('dh_remark');
			$data['documentation_rec']=$this->input->post('doc_btn');
			$data['documentation_remark']=$this->input->post('doc_remark');
			$data['protocols_rec']=$this->input->post('pg_btn');
			$data['protocols_remark']=$this->input->post('pg_remark');
			$data['training_rec']=$this->input->post('tra_btn');
			$data['training_remark']=$this->input->post('tra_remark');
			$data['status']='1';
			$data['added_by'] =  $user;
			
            // var_dump($data);die();
			$response=$this->clinical_model->saverecords($data);
			
		}
    }

    public function get_clinical(){
    


         $search_data = $this->input->post();
         if (empty($search_data)) {
             $search_data = $this->input->get();
         }
 
 
         $position = $this->input->post('output_position');
 
         if ($position == "") {
             $position =   "single_record_details";
         }
 
         $current_user = $this->clg->clg_ref_id;
 
         $args = array();
         $get['inc_ref_id'] = trim($this->input->get('inc_ref_id'));
 
         if ($get['inc_ref_id'] == '') {
             $args = array('inc_ref_id' => trim($this->input->post('inc_ref_id')), 'from_date' => $incident_date, 'to_date' => $incident_date);
             $get['inc_ref_id'] = trim($this->input->post('inc_ref_id'));
         } else {
             $args = array('inc_ref_id' => trim($this->input->get('inc_ref_id')), 'from_date' => $incident_date, 'to_date' => $incident_date);
             $get['inc_ref_id'] = trim($this->input->get('inc_ref_id'));
         }
 
 
         $get_inc_date = str_replace('A-', '', trim($get['inc_ref_id']));
         $get_inc_date = str_replace('BK-', '', $get_inc_date);
         $year = substr($get_inc_date, 0, 4);
         $month = substr($get_inc_date, 4, 2);
         $date = substr($get_inc_date, 6, 2);
         $incident_date = $year . '-' . $month . '-' . $date;
 
         $data['inc_call_type'] = $this->inc_model->get_inc_ref_id($args);
 
 
 
         if (!empty($data['inc_call_type'])) {
 
 
             $data['inc_ref_no'] = $get['inc_ref_id'];
 
 
             if ($data['inc_call_type'][0]->inc_type != 'AD_SUP_REQ') {
 
                 $data['inc_details'] = $this->inc_model->get_inc_details_ref_id($args);
             } else {
 
                 $data['inc_details'] = $this->inc_model->get_inc_call_details_ref_id($args);
             }
 
             $data['inc_list'] = $this->medadv_model->get_inc_by_ercp($args, $offset, $limit);
 
 
             if ($data['inc_details'][0]->police_chief_complete != '') {
                 $args_police = array('po_ct_id' => $data['inc_details'][0]->police_chief_complete);
                 $police_comp = $this->call_model->get_police_chief_comp($args_police);
                 $data['po_ct_name'] = $police_comp[0]->po_ct_name;
             }
 
             if ($data['inc_details'][0]->fire_chief_complete != '') {
                 $args_fire = array('fi_ct_id' => $data['inc_details'][0]->fire_chief_complete);
                 $fire_comp = $this->call_model->get_fire_chief_comp($args_fire);
                 $data['fi_ct_name'] = $fire_comp[0]->fi_ct_name;
             }
 
             if ($data['inc_details'][0]->inc_ero_standard_summary != '') {
                 $args_remark = array('re_id' => $data['inc_details'][0]->inc_ero_standard_summary);
                 $standard_remark = $this->call_model->get_ero_summary_remark($args_remark);
 
                 $data['re_name'] = $standard_remark[0]->re_name;
             }
 
             $standard_remark = $data['inc_details'][0]->inc_ero_standard_summary;
             $data['re_name'] = $standard_remark;
             $args_pur = array('pcode' => $data['inc_details'][0]->cl_purpose);
 
             $call_pur = $this->inc_model->get_purpose_call($args_pur);
             $data['pname'] = $call_pur[0]->pname;
 
 
             if ($data['inc_details'][0]->inc_suggested_amb != '' && $data['inc_details'][0]->inc_type != 'on_scene_care') {
                 $args_amb_type = array('inc_suggested_amb' => $data['inc_details'][0]->inc_suggested_amb);
                 $amb_type = $this->inc_model->get_sugg_amb_type($args_amb_type);
                 $data['ambt_name'] = $amb_type[0]->ambt_name;
             }
 
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
             $args_pt = array(
                 'get_count' => TRUE,
                 'inc_ref_id' => $data['inc_ref_no']
             );
 
             $data['ptn_count'] = $this->pcr_model->get_pat_by_inc($args_pt);
 
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
 
             $inc_audit_args = array(
                 'inc_ref_id' => $data['inc_ref_no']
             );
             $data['audit_questions'] = $this->inc_model->get_inc_audit_summary($inc_audit_args);
 
             $amb_args = array('inc_ref_id' => $data['inc_ref_no'], 'from_date' => $incident_date, 'to_date' => $incident_date);
 
             $data['enquiry_data'] = $this->enquiry_model->get_enquiry($amb_args);
 
             $myArray = explode(',', $data['enquiry_data'][0]->enq_que);
 
 
             $data['enq_que'] = array();
             $q = 0;
 
             if (is_array($myArray)) {
                 foreach ($myArray as $que) {
 
                     $enq_que = $this->common_model->get_question(array('que_id' => $que));
 
                     $serialize_que = $enq_que[0]->que_question;
 
                     $data['enq_que'][$q]['que'] = get_lang_data($serialize_que, $data['enquiry_data'][0]->enq_lang);
 
                     $ans = $this->common_model->get_answer(array('ans_que_id' => $que));
 
                     $serialize_ans = $ans[0]->ans_answer;
 
                     $data['enq_que'][$q]['ans'] = get_lang_data($serialize_ans, $data['enquiry_data'][0]->enq_lang);
 
                     $data['enq_que'][$q]['que_id'] = $que;
 
                     $q++;
                 }
             }
 
             $data['amb_data'] = $this->inc_model->get_inc_details($amb_args);
 
 
             $data['sms_data'] = $this->inc_model->get_inc_sms_response($data['inc_ref_no']);
 
             $ptn_args = array(
                 'inc_ref_id' => $data['inc_ref_no'],
                 //                'ptn_id' => $data['inc_details'][0]->ptn_id,
                 'from_date' => $incident_date,
                 'to_date' => $incident_date
             );
 
             $data['ptn_details'] = $this->Pet_model->get_ptinc_info($ptn_args);
 
 
 
             $inc_args = array(
                 'inc_ref_id' => trim($data['inc_ref_no']),
                 'from_date' => $incident_date,
                 'to_date' => $incident_date
             );
 
 
             $data['facility_details'] = $this->inc_model->get_hospital_facility(array('inc_ref_id' => trim($data['inc_ref_no'])));
 
 
             $data['folloup_details'] = $this->inc_model->get_followupinc(array('inc_ref_id' => trim($data['inc_ref_no'])));
 
 
             $data['feedback_details'] = $this->feedback_model->get_feedback_details(array('inc_ref_id' => trim($data['inc_ref_no'])));
 
 
 
             $data['epcr_inc_details'] = $this->pcr_model->get_epcr_inc_details_by_inc_id_cli($inc_args);
            //  var_dump($data['epcr_inc_details']);die;
             $data['er_inc_details'] = $this->medadv_model->get_epcr_by_inc_id($inc_args);
 
             $data['driver_data'] = $this->pcr_model->get_driver(array('inc_ref_id' => trim($data['inc_ref_no']), 'from_date' => $incident_date, 'to_date' => $incident_date));
             $data['tdo_id'] = $this->call_model->get_tdo_inc($data['inc_ref_no']);
         }
 
         $gri_args = array(
             'gc_inc_ref_id' => trim($data['inc_ref_no'])
         );
 
 
         $data['grievance_info'] = $this->grievance_model->get_inc_by_grievance($gri_args, '', '', $filter, $sortby);
 
         $args = array('gc_inc_ref_id' => $data['inc_ref_no']);
 
         $data['cl_dtl'] = $this->grievance_model->get_inc_by_grievance($args);
 
         $sup_remark_args = array(
             's_inc_ref_id' => trim($data['inc_ref_no'])
         );
         $data['supervisor_remark'] = $this->call_model->get_inc_supervisor_remark($sup_remark_args);
 
         $id = array(
            'inc_ref_id' => $this->post['inc_ref_id']
         );
        //  var_dump($id);die();
        $data['clinical_view'] = $this->clinical_model->get_clinical_data($id);
         $this->output->add_to_position($this->load->view('frontend/clinical/clinical_added_view', $data, TRUE), $position, TRUE);
 
 
     }
    
}
