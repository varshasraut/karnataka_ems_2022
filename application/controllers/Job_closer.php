<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Job_Closer extends EMS_Controller
{

    function __construct()
    {

        parent::__construct();

        $this->steps_cnt = $this->config->item('pcr_steps');
        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));
        $this->load->model(array('pet_model', 'add_res_model', 'colleagues_model', 'inc_model', 'amb_model', 'pcr_model', 'call_model', 'medadv_model', 'inv_stock_model', 'ind_model', 'hp_model', 'med_model', 'hp_model', 'shiftmanager_model', 'quality_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper', 'language_helper', 'coral_helper'));


        $this->post = $this->input->get_post(NULL);
        $this->post['base_month'] = get_base_month();
        $this->clg = $this->session->userdata('current_user');

        $this->pg_limit = $this->config->item('pagination_limit_clg');
        $this->pg_limits = $this->config->item('report_clg');
        $this->default_state = $this->config->item('default_state');

        if ($this->post['filters'] == 'reset') {
            $this->session->unset_userdata('epcr_filter');
        }

        if ($this->session->userdata('epcr_filter')) {
            $this->fdata = $this->session->userdata('epcr_filter');
        }

        $this->today = date('Y-m-d H:i:s');
    }

    public function index($generated = false)
    {
        //dashboard_redirect($this->clg->clg_group);
        $user_group = $this->clg->clg_group;

        if ($user_group == 'UG-DCO' || $user_group == 'UG-DCOSupervisor' || $user_group == 'UG-DCO-102' || $user_group == 'UG-BIKE-DCO') {
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
            //        var_dump($this->fdata);
            //        die();
            //        


            $data['amb_reg_id'] = "";
            $data['filter'] = $filter = "";
            $data['filter'] = $_POST['filter'] ? $this->post['filter'] : $this->fdata['filter'];
            $data['inc_id_re'] = $_POST['inc_id_re'] ? $this->post['inc_id_re'] : $this->fdata['inc_id_re'];

            $data['amb_reg_id_re'] = $_POST['amb_reg_id_re'] ? $this->post['amb_reg_id_re'] : $this->fdata['amb_reg_id_re'];
            $data['amb_reg_id_new'] = $_POST['amb_reg_id_new'] ? $this->post['amb_reg_id_new'] : $this->fdata['amb_reg_id_new'];
            $data['amb_reg_id'] = $_POST['amb_reg_id'] ? $this->post['amb_reg_id'] : $this->fdata['amb_reg_id'];
            $data['district_id'] = $_POST['district_id'] ? $this->post['district_id'] : $this->fdata['district_id'];
            $data['inc_date'] = $_POST['inc_date'] ? $this->post['inc_date'] : $this->fdata['inc_date'];
            $data['hp_id'] = $_POST['hp_id'] ? $this->post['hp_id'] : $this->fdata['hp_id'];
            $data['inc_id'] = $data['inc_ref_id'] = $_POST['inc_id'] ? $this->post['inc_id'] : $this->fdata['inc_id'];
            $data['dco_id'] = $_POST['dco_id'] ? $this->post['dco_id'] : $this->fdata['dco_id'];
            $data['provider_impressions'] = $_POST['provider_impressions'] ? $this->post['provider_impressions'] : $this->fdata['provider_impressions'];
            $data['provider_casetype'] = $_POST['provider_casetype'] ? $this->post['provider_casetype'] : $this->fdata['provider_casetype'];

            $data['epcr_call_types'] = $_POST['epcr_call_type'] ? $this->post['epcr_call_type'] : $this->fdata['epcr_call_type'];



            $sortby['close_by_emt'] = '0';

            if (isset($data['filter'])) {
                // print_r($data['filter']);die;

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
                } else if ($data['filter'] == 'close_by_emt') {
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
                } else if ($data['filter'] == 'reopen_id') {
                    $filter = '';
                    $sortby['reopen_id'] = '1';
                    $data['reopen_id'] = $data['reopen_id'];
                    $data['reopen_case'] = 'y';
                } else if ($data['filter'] == 're_close_by_emt') {
                    $filter = '';
                    // $sortby['amb_reg_id_re'] = $data['amb_reg_id_re'];
                    // $data['amb_reg_id_re'] = $sortby['amb_reg_id_re'];inc_id_re
                    $sortby['inc_id_re'] = $data['inc_id_re'];
                    $data['inc_id_re'] = $sortby['inc_id_re'];
                    $data['revalidate_by_emt'] = '1';
                    
                }
            }

            $this->session->set_userdata('epcr_filter', $data);

            $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
            if ($this->clg->clg_group == 'UG-REMOTE' || $this->clg->clg_group == 'UG-DCO' || $this->clg->clg_group == 'UG-ADMIN' || $this->clg->clg_group == 'UG-DCO-102' || $this->clg->clg_group == 'UG-BIKE-DCO') {
                $args_dash = array(
                    'base_month' => $this->post['base_month']

                );
            } else if ($this->clg->clg_group == 'UG-DCOSupervisor') {

                $args['clg_senior'] = $this->clg->clg_ref_id;
                $data['clg_senior'] = $this->clg->clg_ref_id;


                $clg_args = array('clg_senior' => $this->clg->clg_ref_id, 'clg_group' => 'UG-DCO');

                $data['dco_clg'] = $this->colleagues_model->get_clg_data($clg_args);



                foreach ($data['dco_clg'] as $dco) {
                    $child_dco[] = $dco->clg_ref_id;
                }

                if (is_array($child_dco)) {
                    $child_dco = implode("','", $child_dco);
                }


                if ($data['dco_id']  != '') {
                    $args_dash['operator_id'] = $this->post['dco_id'];
                } else {
                    // $args_dash['child_dco'] = $this->fdata['dco_id'];
                }
            } else {
                $args_dash = array(
                    'operator_id' => $this->clg->clg_ref_id,
                    'base_month' => $this->post['base_month']
                );
            }

            if ($this->clg->clg_group == 'UG-DCO' || $this->clg->clg_group == 'UG-REMOTE') {
                $args_dash['system_type'] = '108';
            } else if ($this->clg->clg_group == 'UG-DCO-104') {
                $args_dash['system_type'] = '104';
            }


            $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

            $data['page_no'] = $page_no;

            $data['get_count'] = TRUE;

            $first_amb_args = array(
                'system_type' => $args_dash['system_type'],
                'amb_reg_id' => $data['amb_reg_id'],
                'thirdparty' => $this->clg->thirdparty,
                'base_month' => $this->post['base_month']
            );
            //$inc_amb_details = array();

            //$inc_amb_details = $this->pcr_model->get_first_inc_by_amb($first_amb_args);

            //        if($_SERVER['REMOTE_ADDR']=='45.116.46.94'){
            //            var_dump($inc_amb_details);
            //        }

            $data['closer_data'] = $inc_amb_details;
            $data['default_state'] = $this->default_state;


            if ($this->clg->clg_group == 'UG-REMOTE') {
                //$regex = "([\[|\]|^\"|\"$])"; 
                //            $replaceWith = ""; 
                //            $district_id = preg_replace($regex, $replaceWith, $district_id);
                $district_id = json_decode($district_id);

                if (is_array($district_id)) {
                    $district_id = implode("','", $district_id);
                }
                $args_dash['district_id'] = $district_id;
            }
            $args_dash['thirdparty'] = $this->clg->thirdparty;
            $args_dash['get_count'] = TRUE;
            //var_dump($sortby);die();

            // $total_cnt = $this->pcr_model->get_inc_by_emt($args_dash, $offset, $limit, $filter, $sortby, $incomplete_inc_amb);

            // unset($args_dash['get_count']);

            // $inc_info = $this->pcr_model->get_inc_by_emt($args_dash, $offset, $limit, $filter, $sortby, $incomplete_inc_amb);
            if (isset($data['filter'])) {
            if ($data['filter'] == 're_close_by_emt') {
                
                $total_cnt = $this->pcr_model->get_inc_by_emt_re($args_dash, $offset, $limit, $filter, $sortby, $incomplete_inc_amb);
                unset($args_dash['get_count']);
            $inc_info = $this->pcr_model->get_inc_by_emt_re($args_dash, $offset, $limit, $filter, $sortby, $incomplete_inc_amb);

            // print_r($data['get_count']);die;
            }
            else{
                $total_cnt = $this->pcr_model->get_inc_by_emt($args_dash, $offset, $limit, $filter, $sortby, $incomplete_inc_amb);
                unset($args_dash['get_count']);
                $inc_info = $this->pcr_model->get_inc_by_emt($args_dash, $offset, $limit, $filter, $sortby, $incomplete_inc_amb);
            }
        }
        else{
            $total_cnt = $this->pcr_model->get_inc_by_emt($args_dash, $offset, $limit, $filter, $sortby, $incomplete_inc_amb);
            unset($args_dash['get_count']);
                $inc_info = $this->pcr_model->get_inc_by_emt($args_dash, $offset, $limit, $filter, $sortby, $incomplete_inc_amb);
        }

            // $arg_amb = array('amb_user_type' => 'tdd');
            // $data['amb_list'] = $this->amb_model->get_amb_data($arg_amb);
            // $data['amb_list'] = $this->amb_model->get_amb_data();

            $data['per_page'] = $limit;
            $data['inc_offset'] = $offset;

            $data['inc_info'] = $inc_info;

            $data['total_count'] = $total_cnt;

            $data['per_page'] = $limit;

            $pgconf = array(
                'url' => base_url("job_closer/index"),
                'total_rows' => $total_cnt,
                'per_page' => $limit,
                'cur_page' => $page_no,
                'uri_segment' => 3,
                'use_page_numbers' => TRUE,
                'attributes' => array(
                    'class' => 'click-xhttp-request',
                    'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
                )
            );

            $report_args = array(
                'clg_ref_id' => $this->clg->clg_ref_id,
                'single_date' => date('Y-m-d'),
                'base_month' => $this->post['base_month']
            );
            $data['login_details'] = $this->shiftmanager_model->get_login_details_ero($report_args);


            $ero_bref = array(
                'to_date' => date('Y-m-d'),
                'from_date' => date('Y-m-d'),
                'clg_ref_id' => $this->clg->clg_ref_id,
                'break_type' => '2'
            );
            $ero_bref_break_summary = $this->shiftmanager_model->get_break_total_time_user($ero_bref);
            $ero_bref_total_time = gmdate("H:i:s", $ero_bref_break_summary[0]->break_total_time);

            $ero_feed = array(
                'to_date' => date('Y-m-d'),
                'from_date' => date('Y-m-d'),
                'clg_ref_id' => $this->clg->clg_ref_id,
                'break_type' => '3'
            );
            $ero_feed_break_summary = $this->shiftmanager_model->get_break_total_time_user($ero_feed);
            $ero_feed_total_time = gmdate("H:i:s", $ero_feed_break_summary[0]->break_total_time);

            $man_meet = array(
                'to_date' => date('Y-m-d'),
                'from_date' => date('Y-m-d'),
                'clg_ref_id' => $this->clg->clg_ref_id,
                'break_type' => '8'
            );
            $man_meet_break_summary = $this->shiftmanager_model->get_break_total_time_user($man_meet);
            $man_meet_total_time = gmdate("H:i:s", $man_meet_break_summary[0]->break_total_time);

            $qa_feed = array(
                'to_date' => date('Y-m-d'),
                'from_date' => date('Y-m-d'),
                'clg_ref_id' => $this->clg->clg_ref_id,
                'break_type' => '9'
            );
            $qa_feed_break_summary = $this->shiftmanager_model->get_break_total_time_user($qa_feed);
            $qa_feed_total_time = gmdate("H:i:s", $qa_feed_break_summary[0]->break_total_time);

            $tl_feed = array(
                'to_date' => date('Y-m-d'),
                'from_date' => date('Y-m-d'),
                'clg_ref_id' => $this->clg->clg_ref_id,
                'break_type' => '12'
            );
            $tl_feed_break_summary = $this->shiftmanager_model->get_break_total_time_user($tl_feed);
            $tl_feed_total_time = gmdate("H:i:s", $tl_feed_break_summary[0]->break_total_time);

            $tl_meet = array(
                'to_date' => date('Y-m-d'),
                'from_date' => date('Y-m-d'),
                'clg_ref_id' => $this->clg->clg_ref_id,
                'break_type' => '13'
            );
            $tl_meet_break_summary = $this->shiftmanager_model->get_break_total_time_user($tl_meet);
            $tl_meet_total_time = gmdate("H:i:s", $tl_meet_break_summary[0]->break_total_time);

            $arr = [
                $ero_bref_total_time, $ero_feed_total_time, $man_meet_total_time,
                $qa_feed_total_time, $tl_feed_total_time, $tl_meet_total_time
            ];

            $total = 0;

            foreach ($arr as $element) :
                $temp = explode(":", $element);
                $total += (int) $temp[0] * 3600;
                $total += (int) $temp[1] * 60;
                $total += (int) $temp[2];
            endforeach;
            $formatted = sprintf(
                '%02d:%02d:%02d',
                ($total / 3600),
                ($total / 60 % 60),
                $total % 60
            );

            // echo $formatted;

            $data['tea_break'] = $formatted;


            // $args_tea_break = array(
            //     'to_date' => date('Y-m-d'),
            //     'from_date' => date('Y-m-d'),
            //     'clg_ref_id' => $this->clg->clg_ref_id,
            //     'break_type' => '2'
            // );
            // $break_summary = $this->shiftmanager_model->get_break_total_time_user($args_tea_break);
            // $break_total_time = gmdate("H:i:s", $break_summary[0]->break_total_time);
            // $data['tea_break'] = $break_total_time;
            //var_dump($break_summary );


            $args_meal_break = array(
                'to_date' => date('Y-m-d'),
                'from_date' => date('Y-m-d'),
                'clg_ref_id' => $this->clg->clg_ref_id,
                'break_type' => '7'
            );
            $meal_break_summary = $this->shiftmanager_model->get_break_total_time_user($args_meal_break);
            $meal_total_time = gmdate("H:i:s", $meal_break_summary[0]->break_total_time);
            $data['meal_break'] = $meal_total_time;


            $args_boi_break = array(
                'to_date' => date('Y-m-d'),
                'from_date' => date('Y-m-d'),
                'clg_ref_id' => $this->clg->clg_ref_id,
                'break_type' => '1'
            );
            $boi_break_summary = $this->shiftmanager_model->get_break_total_time_user($args_boi_break);
            $boi_total_time = gmdate("H:i:s", $boi_break_summary[0]->break_total_time);
            $data['boi_break'] = $boi_total_time;

            // Total Closure 
            $month = date('m');
            $year = date('Y');
            $day = date('d');
            $query_date = $year . '-' . $month . '-' . $day;

            //echo $query_date;
            $first_day_this_month = date('Y-m-01', strtotime($query_date));

            // Last day of the month.
            $last_day_this_month = date('Y-m-t', strtotime($query_date));
            $month_report_args =  array(
                'from_date' => date('m/d/Y', strtotime($first_day_this_month)),
                'to_date' => date('m/d/Y', strtotime($last_day_this_month))
            );

            $month_report_args['get_count'] = 'true';
            $month_report_args['operator_id'] = $this->clg->clg_ref_id;

            $data['total_month_closure'] = $this->pcr_model->get_all_closure($month_report_args);
            $data['total_month_Victim'] = $this->pcr_model->get_all_closure_victim($month_report_args);
            //Today call
            $today_report_args =  array(
                'from_date' => date('Y-m-d', strtotime($query_date)),
                'to_date' => date('Y-m-d', strtotime($query_date))
            );
            $today_report_args['get_count'] = 'true';
            $today_report_args['operator_id'] = $this->clg->clg_ref_id;

            $data['total_today_closure'] = $this->pcr_model->get_all_closure($today_report_args);
            $data['total_today_Victim'] = $this->pcr_model->get_all_closure_victim($today_report_args);

            $current_date = date('Y-m-d');
            $current_year = date('Y');
            $current_month = date('m');
            $current_month_date =  $current_year . '-' . $current_month . '-01';
            $END_day = date("Y-m-t", strtotime($current_month_date));

            $start_date_amb = date('Y-m-d', strtotime($post_reports['from_date']));
            $end_date_amb = date('Y-m-t', strtotime($post_reports['from_date']));


            $quality_args = array(
                'base_month' => $this->post['base_month'],
                'user_type' => 'ERO',
                'from_date' => $current_month_date,
                'to_date' => $END_day,
                'qa_ad_user_ref_id' => $this->clg->clg_ref_id
            );

            $data['audit_details'] = $this->quality_model->get_quality_audit($quality_args);

            $today_validate = array(
                'from_date_validate' => $current_date,
                'to_date_validate' => $current_date,
                'clg_ref_id' => $this->clg->clg_ref_id,
                'get_count' => TRUE
            );

            $data['today_validation'] = $this->pcr_model->dco_validation_report($today_validate);



            $month_validate = array(
                'from_date_validate' => $current_month_date,
                'to_date_validate' => $END_day,
                'clg_ref_id' => $this->clg->clg_ref_id,
                'get_count' => TRUE
            );

            $data['mdt_validation'] = $this->pcr_model->dco_validation_report($month_validate);



            $config = get_pagination($pgconf);
            $data['pagination'] = get_pagination($pgconf);
            $data['default_state'] = $this->default_state;
            $this->output->add_to_position('', 'caller_details', TRUE);
            $this->output->add_to_position($this->load->view('frontend/pcr/dashboard_view', $data, TRUE), 'content', TRUE);

            
            if ($this->clg->clg_group == 'UG-DCO' || $this->clg->clg_group == 'UG-DCO-102' || $this->clg->clg_group == 'UG-BIKE-DCO') {
                $this->output->template = "pcr";
            }
        } else {
            dashboard_redirect($user_group, $this->base_url);
        }
    }

    function pcr_listing()
    {

        $this->pg_limit = 10;
        $data['page_no'] = ($this->post['page_no'] || $this->post['pglnk']) ? $this->post['page_no'] : $this->fdata['page_no'];
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        $page_no = 1;
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }


        $data['default_state'] = $this->default_state;
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        $args_dash = array();


        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        $data['get_count'] = TRUE;

        $data['amb_reg_id'] = "";
        $data['filter'] = $filter = "";

        $data['amb_reg_id'] = $_POST['amb_reg_id'] ? $this->post['amb_reg_id'] : $this->fdata['amb_reg_id'];
        $data['district_id'] = $_POST['district_id'] ? $this->post['district_id'] : $this->fdata['district_id'];
        $data['inc_date'] = $_POST['inc_date'] ? $this->post['inc_date'] : $this->fdata['inc_date'];
        $data['hp_id'] = $_POST['hp_id'] ? $this->post['hp_id'] : $this->fdata['hp_id'];
        $data['inc_id'] = $_POST['inc_id'] ? $this->post['inc_id'] : $this->fdata['inc_id'];
        $data['dco_id'] = $_POST['dco_id'] ? $this->post['dco_id'] : $this->fdata['dco_id'];


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
        }

        $this->session->set_userdata('epcr_filter', $data);

        if ($this->clg->clg_group == 'UG-DCO' || $this->clg->clg_group == 'UG-ADMIN' || $this->clg->clg_group == 'UG-DCO-102' || $this->clg->clg_group == 'UG-BIKE-DCO') {
            $args_dash = array(
                'base_month' => $this->post['base_month']

            );
        } else if ($this->clg->clg_group == 'UG-DCOSupervisor') {

            $args['clg_senior'] = $this->clg->clg_ref_id;
            $data['clg_senior'] = $this->clg->clg_ref_id;


            $clg_args = array('clg_senior' => $this->clg->clg_ref_id, 'clg_group' => 'UG-DCO');

            $data['dco_clg'] = $this->colleagues_model->get_clg_data($clg_args);

            foreach ($data['dco_clg'] as $dco) {
                $child_dco[] = $dco->clg_ref_id;
            }

            if (is_array($child_dco)) {
                $child_dco = implode("','", $child_dco);
            }


            if ($data['dco_id']  != '') {
                $args_dash['operator_id'] = $this->post['dco_id'];
            } else {
                //$args_dash['child_dco'] = $this->fdata['dco_id'];
            }
        } else {
            $args_dash = array(
                'operator_id' => $this->clg->clg_ref_id,
                'base_month' => $this->post['base_month']
            );
        }


        if ($this->clg->clg_group == 'UG-DCO') {
            $args_dash['system_type'] = '108';
        } else if ($this->clg->clg_group == 'UG-BIKE-DCO') {
            $args_dash['system_type'] = 'BIKE';
        } else if ($this->clg->clg_group == 'UG-DCO-102') {
            $args_dash['system_type'] = '102';
        }
        $inc_amb_details = $this->pcr_model->get_first_inc_by_amb();
        $data['closer_data'] = $inc_amb_details;
        $args_dash['thirdparty'] = $this->clg->thirdparty;

        // $incomplete_inc_amb = $this->pcr_model->get_incomplete_inc_amb($args_dash);

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->pcr_model->get_inc_by_emt($args_dash, $offset, $limit, $filter, $sortby, $incomplete_inc_amb);

        unset($args_dash['get_count']);
        $inc_info = $this->pcr_model->get_inc_by_emt($args_dash, $offset, $limit, $filter, $sortby, $incomplete_inc_amb);

        //$arg_amb = array('amb_user_type' => 'tdd');
        $data['amb_list'] = $this->amb_model->get_amb_data();

        $data['per_page'] = $limit;
        $data['inc_offset'] = $offset;

        $inc_data = array();

        //		foreach ($inc_info as $key=>$inc) {
        //
        //            $args = array(
        //                'inc_ref_id' => $inc->inc_ref_id,
        //            );
        //			$inc_data_details = $this->pcr_model->get_inc_by_inc_id($args);
        //			
        //			$inc->amb_rto_register_no = $inc_data_details[0]->amb_rto_register_no;
        //			$inc->hp_name = $inc_data_details[0]->hp_name;
        //			$inc->clg_first_name = $inc_data_details[0]->clg_first_name;
        //			$inc->clg_last_name = $inc_data_details[0]->clg_last_name;
        //			$inc->amb_default_mobile = $inc_data_details[0]->amb_default_mobile;
        //			$inc->dst_name = $inc_data_details[0]->dst_name;
        //			$inc->amb_default_mobile = $inc_data_details[0]->amb_default_mobile;
        //			$inc->amb_pilot_mobile = $inc_data_details[0]->amb_pilot_mobile;
        //			$inc->inc_bvg_ref_number = $inc_data_details[0]->inc_bvg_ref_number;
        //		   
        //            
        //             if(!isset($incomplete_inc_amb[$inc->inc_ref_id]['epcr_count'])){
        //                $incomplete_inc_amb[$inc->inc_ref_id]['epcr_count'] = 0;
        //            }
        //		   
        //            
        //            $pending = $incomplete_inc_amb[$inc->inc_ref_id]['ptn_count'] - $incomplete_inc_amb[$inc->inc_ref_id]['epcr_count'] ;
        //            
        //            $closer = $incomplete_inc_amb[$inc->inc_ref_id]['epcr_count'];
        //
        //            $inc->total_pnt = $incomplete_inc_amb[$inc->inc_ref_id]['ptn_count'];
        //            $inc->inc_patient_cnt = $incomplete_inc_amb[$inc->inc_ref_id]['ptn_count'];
        //            $inc->pending = $pending;
        //            $inc->closer = $closer;
        //            
        //            $inc_data[] = $inc;
        //      
        //        }
        //       $data['incomplete_inc_amb'] = $incomplete_inc_amb;
        $data['inc_info'] = $inc_info;

        $data['total_count'] = $total_cnt;

        $data['per_page'] = $limit;

        $pgconf = array(
            'url' => base_url("job_closer/pcr_listing"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 2,
            'use_page_numbers' => TRUE,
            'attributes' => array(
                'class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
            )
        );
        // Total Closure 
        $month = date('m');
        $year = date('Y');
        $day = date('d');
        $query_date = $year . '-' . $month . '-' . $day;

        //echo $query_date;
        $first_day_this_month = date('Y-m-01', strtotime($query_date));

        // Last day of the month.
        $last_day_this_month = date('Y-m-t', strtotime($query_date));
        $month_report_args =  array(
            'from_date' => date('m/d/Y', strtotime($first_day_this_month)),
            'to_date' => date('m/d/Y', strtotime($last_day_this_month))
        );

        $month_report_args['get_count'] = 'true';
        $month_report_args['operator_id'] = $this->clg->clg_ref_id;

        $data['total_month_closure'] = $this->pcr_model->get_all_closure($month_report_args);
        $data['total_month_Victim'] = $this->pcr_model->get_all_closure_victim($month_report_args);
        //Today call
        $today_report_args =  array(
            'from_date' => date('m/d/Y', strtotime($query_date)),
            'to_date' => date('m/d/Y', strtotime($query_date))
        );
        $today_report_args['get_count'] = 'true';
        $today_report_args['operator_id'] = $this->clg->clg_ref_id;

        $data['total_today_closure'] = $this->pcr_model->get_all_closure($today_report_args);
        $data['total_today_Victim'] = $this->pcr_model->get_all_closure_victim($today_report_args);


        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);

        $this->output->add_to_position($this->load->view('frontend/pcr/dashboard_view', $data, TRUE), 'content', TRUE);
        //$this->output->template = "pcr";
        if ($this->clg->clg_group == 'UG-DCO' || $this->clg->clg_group == 'UG-DCO-102') {
            $this->output->template = "pcr";
        }
    }

    function call_info()
    {

        $this->session->unset_userdata('front_injury_data');
        $this->session->unset_userdata('back_injury_data');
        $this->session->unset_userdata('side_injury_data');
        $this->session->unset_userdata('pcr_details');
        $this->session->unset_userdata('inc_ref_id');

        $data['user_group'] = $this->clg->clg_group;
        $data['init_step'] = 'yes';

        // $this->output->add_to_position($this->load->view('frontend/pcr/pcr_top_steps_view', $data, TRUE), 'pcr_top_steps', TRUE);

        $this->output->add_to_position('', 'pcr_progressbar', TRUE);

        $this->output->add_to_position($this->load->view('frontend/pcr/call_details_view', $data, TRUE), 'content', TRUE);
        // $this->output->template = "pcr";
    }
    function epcr_revalidate()
    {
        //$this->session->unset_userdata('inc_ref_id');

        $data['user_group'] = $this->clg->clg_group;

        if ($this->post['inc_ref_id'] == '') {
            $this->post['inc_ref_id'] = base64_decode($this->input->get('inc_id'));
        }
        $reopen = $data['reopen'] = $this->post['reopen'];
        // var_dump(   $this->post['inc_ref_id'] );die();
        if (($this->post['inc_ref_id'] == "") && ($this->post['inc_ref_id'] == NULL)) {

            $this->call_info();
            return;
        }

        $data['inc_ref_id'] = trim($this->post['inc_ref_id']);


        $this->session->set_userdata('inc_ref_id', $this->post['inc_ref_id']);

        $inc_args = array(
            'inc_ref_id' => trim($this->post['inc_ref_id']),
            //  'operator_id' => $this->clg->clg_ref_id,
            'base_month' => $this->post['base_month'],
        );

        $args = array(
            'inc_ref_id' => trim($this->post['inc_ref_id']),
            'base_month' => $this->post['base_month'],
        );
        $data['vahicle_info'] = $this->pcr_model->get_inc_amb_by_inc($args);
        

        $data['total_closure_count']= $this->pcr_model->get_closure_count_by_ambulance_no($data['vahicle_info'][0]->amb_rto_register_no);
       
        
        if ($reopen == 'y') {
             $data['total_closure_count']= $this->pcr_model->get_closure_count_by_ambulance_no_validate($data['vahicle_info'][0]->amb_rto_register_no);
            $args['pcr_status'] = '1';
            
        }
        //$data['patient_info'] = $this->pcr_model->get_pat_by_inc($args);
        
        $data['patient_info'] = $this->pcr_model->get_pending_pat_by_inc_reval($args);
        


        $data['inc_details'] = $this->pcr_model->get_epcr_inc_details($inc_args);




        if (empty($data['inc_details'])) {

            $this->session->unset_userdata('pcr_details');
            $data['inc_details'] = $this->inc_model->get_inc_details($inc_args);
        }
        $data['inc_type'] = $this->inc_model->get_inc_details($inc_args);

        $data['inc_details_data'] = $this->inc_model->get_inc_details($inc_args);

        if ($data['inc_details_data'][0]->inc_complaint != 0 && $data['inc_details_data'][0]->inc_complaint != '') {
            $data['ct_type'] = get_cheif_complaint($data['inc_details_data'][0]->inc_complaint);
        }
        if ($data['inc_details_data'][0]->inc_mci_nature != 0 && $data['inc_details_data'][0]->inc_mci_nature != '') {
            $data['ct_type'] = get_mci_nature_service($data['inc_details_data'][0]->inc_mci_nature);
        }
        $data['cl_type'] = $data['inc_details_data'][0]->pname;
        
        if($data['inc_details_data'][0]->inc_type == 'IN_HO_P_TR'){
            $data['inter_facility_details'] = $this->inc_model->get_hospital_facility($inc_args);
        }
        if($data['inc_details_data'][0]->inc_type == 'DROP_BACK'){
            $data['dropback_details'] = $this->inc_model->get_dropback_call_details($inc_args);
        }
        if (!empty($data['inc_details'])) {

            $amb_args = array(
                'inc_ref_id' => trim($this->post['inc_ref_id']),
                'amb_ref_id' => $data['inc_details'][0]->amb_ref_id,
                'base_month' => $this->post['base_month']
            );


            $data['inc_emp_info'] = $this->pcr_model->get_inc_amb($amb_args);

            $data['patient_id'] = $data['inc_details'][0]->ptn_id;
            // $data['ct_type'] = $data['inc_details'][0]->ct_type;
            $data['inc_added_by'] = $data['inc_details'][0]->inc_added_by;
            $data['inc_purpose'] = $data['inc_details'][0]->pname;
            $ptn_args = array(
                'ptn_id' => $data['inc_details'][0]->ptn_id,
                'base_month' => $this->post['base_month']
            );



            $data['pt_info'] = $this->pet_model->get_petinfo($ptn_args);

            $kids_args = array(
                'ptn_id' => $data['inc_details'][0]->ptn_id,
                'inc_ref_id' => trim($this->post['inc_ref_id'])
            );
            $data['kid_details'] = $this->pcr_model->get_kid_details($kids_args);


            $args = array(
                'pcr_id' => $data['inc_details'][0]->id,
                'patient_id' => $data['inc_details'][0]->ptn_id,
                'base_month' => $this->post['base_month']
            );

            $data['driver_data'] = array();

            if ($data['inc_details'][0]->id != '') {

                $data['driver_data'] = $this->pcr_model->get_driver(array('dp_pcr_id' => $data['inc_details'][0]->id));
                $odo_args = array('inc_ref_id' => trim($data['inc_details'][0]->inc_ref_id));

                $data['get_odometer'] = $this->amb_model->get_amb_odometer_by_inc($odo_args);
                if (empty($data['get_odometer'])) {
                    $args_odometer = array('rto_no' => $data['inc_emp_info'][0]->amb_rto_register_no);
                    $amb_odometer = $this->amb_model->get_amb_odometer_closure($args_odometer);

                    if (empty($data['previous_odometer'])) {
                        $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;
                    }

                    if (empty($data['previous_odometer'])) {
                        $data['previous_odometer'] = 0;
                    }
                }
            } else {

                $args_odometer = array('rto_no' => $data['inc_emp_info'][0]->amb_rto_register_no);
                $amb_odometer = $this->amb_model->get_amb_odometer_closure($args_odometer);


                if (empty($data['previous_odometer'])) {
                    $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;
                }

                if (empty($data['previous_odometer'])) {
                    $data['previous_odometer'] = 0;
                }
            }


            $get_amb_stock = array(
                'pcr_id' => $data['inc_details'][0]->id,
                'sub_type' => 'pcr',
                'as_item_type' => 'NCA'
            );

            $data['pcr_na_med_inv_data'] = $this->ind_model->get_amb_stock($get_amb_stock);


            $get_amb_stock = array(
                'pcr_id' => $data['inc_details'][0]->id,
                'sub_type' => 'pcr',
                'as_item_type' => 'CA'
            );

            $data['pcr_med_inv_data'] = $this->ind_model->get_amb_stock($get_amb_stock);

            $get_med_amb_stock = array(
                'pcr_id' => $data['inc_details'][0]->id,
                'sub_type' => 'pcr',
                'as_item_type' => 'MED'
            );

            $data['pcr_med_data'] = $this->ind_model->get_amb_stock($get_med_amb_stock);


            $non_unit_args = array(
                'inv_id' => $data['inc_details'][0]->drugs,
            );

            $args = array('inv_type' => 'CA');
            $data['invitem'] = $this->inv_model->get_inv_list($args);
            $data['med_list'] = $this->med_model->get_med_list();
            $data['intervention_list'] = $this->med_model->get_intervention_list();
            $data['injury_list'] = $this->pcr_model->get_injury();

            $non_args = array('inv_type' => 'NCA');
            $data['noninvitem'] = $this->inv_model->get_inv_list($non_args);


            //////////////////// Update progressbar ///////////////////////////

            $this->increase_step($data['inc_details'][0]->id);

            if ($data['inc_details_data'][0]->patient_ava_or_not == 'yes') {
                $data['inc_details'][0]->epcr_call_type = '2';
            } else if ($data['inc_details_data'][0]->patient_ava_or_not == 'no') {
                $data['inc_details'][0]->epcr_call_type = '1';
            } else if ($data['inc_details_data'][0]->patient_ava_or_not == '' && $data['inc_details_data'][0]->patient_ava_or_not == NULL) {
                $data['inc_details'][0]->epcr_call_type = '2';
            }
            $arg_media = array('inc_ref_id' => $this->post['inc_ref_id']);
            $data['media'] = $this->pcr_model->get_epcr_media($arg_media);

            $data['inc_type'] = $data['inc_type'][0]->inc_type;
            
            
            $data['inc_details'][0]->inc_type = $data['inc_type'] ;

            $arg_media = array('inc_ref_id' => $this->post['inc_ref_id']);
            $data['media'] = $this->pcr_model->get_epcr_media($arg_media);

           
            //$this->output->add_to_position($this->load->view('frontend/pcr/epcr_view1', $data, TRUE), 'content', TRUE);
            $this->output->add_to_position($this->load->view('frontend/pcr/job_closure_view', $data, TRUE), 'content', TRUE);
            $epcr_call_type = $data['inc_details'][0]->epcr_call_type;
            if($data['inc_type'] == 'DROP_BACK' || $data['inc_type'] == 'PICK_UP')
            {
                $epcr_call_type = '2';
            }
            $data['amb_type'] = $data['inc_emp_info'][0]->ambt_id;
            $data['revalidate'] = '1';
            if ($epcr_call_type == '1') {
  
                $this->output->add_to_position($this->load->view('frontend/pcr/patient_notavailable_epcr_view', $data, TRUE), 'call_type_view', TRUE);
            } elseif ($epcr_call_type == '2') {
              
                $this->output->add_to_position($this->load->view('frontend/pcr/patient_available_epcr_view', $data, TRUE), 'call_type_view', TRUE);
            } elseif ($epcr_call_type == '3') {
                $this->output->add_to_position($this->load->view('frontend/pcr/on_scene_care_epcr_view', $data, TRUE), 'call_type_view', TRUE);
            }
            // $this->output->add_to_position($this->load->view('frontend/pcr/footer_steps', $data, TRUE), 'footer_steps', TRUE);
            //  $this->output->template = "pcr";
        } else {
            $this->output->message = "<div class='error'>Please Enter valid Incident Id</div>";
        }
    }
    function epcr()
    {
        //$this->session->unset_userdata('inc_ref_id');

        $data['user_group'] = $this->clg->clg_group;

        if ($this->post['inc_ref_id'] == '') {
            $this->post['inc_ref_id'] = base64_decode($this->input->get('inc_id'));
        }
        $reopen = $data['reopen'] = $this->post['reopen'];
        // var_dump(   $this->post['inc_ref_id'] );die();
        if (($this->post['inc_ref_id'] == "") && ($this->post['inc_ref_id'] == NULL)) {

            $this->call_info();
            return;
        }

        $data['inc_ref_id'] = trim($this->post['inc_ref_id']);


        $this->session->set_userdata('inc_ref_id', $this->post['inc_ref_id']);

        $inc_args = array(
            'inc_ref_id' => trim($this->post['inc_ref_id']),
            //  'operator_id' => $this->clg->clg_ref_id,
            'base_month' => $this->post['base_month'],
        );

        $args = array(
            'inc_ref_id' => trim($this->post['inc_ref_id']),
            'base_month' => $this->post['base_month'],
        );
        $data['vahicle_info'] = $this->pcr_model->get_inc_amb_by_inc($args);
        

        $data['total_closure_count']= $this->pcr_model->get_closure_count_by_ambulance_no($data['vahicle_info'][0]->amb_rto_register_no);
       
        
        if ($reopen == 'y') {
             $data['total_closure_count']= $this->pcr_model->get_closure_count_by_ambulance_no_validate($data['vahicle_info'][0]->amb_rto_register_no);
            $args['pcr_status'] = '1';
            $args['pcr_validation_status'] = '0';
        }
        //$data['patient_info'] = $this->pcr_model->get_pat_by_inc($args);
        
        $data['patient_info'] = $this->pcr_model->get_pending_pat_by_inc($args);
        


        $data['inc_details'] = $this->pcr_model->get_epcr_inc_details($inc_args);




        if (empty($data['inc_details'])) {

            $this->session->unset_userdata('pcr_details');
            $data['inc_details'] = $this->inc_model->get_inc_details($inc_args);
        }
        $data['inc_type'] = $this->inc_model->get_inc_details($inc_args);

        $data['inc_details_data'] = $this->inc_model->get_inc_details($inc_args);

        if ($data['inc_details_data'][0]->inc_complaint != 0 && $data['inc_details_data'][0]->inc_complaint != '') {
            $data['ct_type'] = get_cheif_complaint($data['inc_details_data'][0]->inc_complaint);
        }
        if ($data['inc_details_data'][0]->inc_mci_nature != 0 && $data['inc_details_data'][0]->inc_mci_nature != '') {
            $data['ct_type'] = get_mci_nature_service($data['inc_details_data'][0]->inc_mci_nature);
        }
        $data['cl_type'] = $data['inc_details_data'][0]->pname;
        
        if($data['inc_details_data'][0]->inc_type == 'IN_HO_P_TR'){
            $data['inter_facility_details'] = $this->inc_model->get_hospital_facility($inc_args);
        }
        if($data['inc_details_data'][0]->inc_type == 'DROP_BACK'){
            $data['dropback_details'] = $this->inc_model->get_dropback_call_details($inc_args);
        }
        if (!empty($data['inc_details'])) {

            $amb_args = array(
                'inc_ref_id' => trim($this->post['inc_ref_id']),
                'amb_ref_id' => $data['inc_details'][0]->amb_ref_id,
                'base_month' => $this->post['base_month']
            );


            $data['inc_emp_info'] = $this->pcr_model->get_inc_amb($amb_args);

            $data['patient_id'] = $data['inc_details'][0]->ptn_id;
            // $data['ct_type'] = $data['inc_details'][0]->ct_type;
            $data['inc_added_by'] = $data['inc_details'][0]->inc_added_by;
            $data['inc_purpose'] = $data['inc_details'][0]->pname;
            $ptn_args = array(
                'ptn_id' => $data['inc_details'][0]->ptn_id,
                'base_month' => $this->post['base_month']
            );



            $data['pt_info'] = $this->pet_model->get_petinfo($ptn_args);

            $kids_args = array(
                'ptn_id' => $data['inc_details'][0]->ptn_id,
                'inc_ref_id' => trim($this->post['inc_ref_id'])
            );
            $data['kid_details'] = $this->pcr_model->get_kid_details($kids_args);


            $args = array(
                'pcr_id' => $data['inc_details'][0]->id,
                'patient_id' => $data['inc_details'][0]->ptn_id,
                'base_month' => $this->post['base_month']
            );

            $data['driver_data'] = array();

            if ($data['inc_details'][0]->id != '') {

                $data['driver_data'] = $this->pcr_model->get_driver(array('dp_pcr_id' => $data['inc_details'][0]->id));
                $odo_args = array('inc_ref_id' => trim($data['inc_details'][0]->inc_ref_id));

                $data['get_odometer'] = $this->amb_model->get_amb_odometer_by_inc($odo_args);
                if (empty($data['get_odometer'])) {
                    $args_odometer = array('rto_no' => $data['inc_emp_info'][0]->amb_rto_register_no);
                    $amb_odometer = $this->amb_model->get_amb_odometer_closure($args_odometer);

                    if (empty($data['previous_odometer'])) {
                        $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;
                    }

                    if (empty($data['previous_odometer'])) {
                        $data['previous_odometer'] = 0;
                    }
                }
            } else {

                $args_odometer = array('rto_no' => $data['inc_emp_info'][0]->amb_rto_register_no);
                $amb_odometer = $this->amb_model->get_amb_odometer_closure($args_odometer);


                if (empty($data['previous_odometer'])) {
                    $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;
                }

                if (empty($data['previous_odometer'])) {
                    $data['previous_odometer'] = 0;
                }
            }


            $get_amb_stock = array(
                'pcr_id' => $data['inc_details'][0]->id,
                'sub_type' => 'pcr',
                'as_item_type' => 'NCA'
            );

            $data['pcr_na_med_inv_data'] = $this->ind_model->get_amb_stock($get_amb_stock);


            $get_amb_stock = array(
                'pcr_id' => $data['inc_details'][0]->id,
                'sub_type' => 'pcr',
                'as_item_type' => 'CA'
            );

            $data['pcr_med_inv_data'] = $this->ind_model->get_amb_stock($get_amb_stock);

            $get_med_amb_stock = array(
                'pcr_id' => $data['inc_details'][0]->id,
                'sub_type' => 'pcr',
                'as_item_type' => 'MED'
            );

            $data['pcr_med_data'] = $this->ind_model->get_amb_stock($get_med_amb_stock);


            $non_unit_args = array(
                'inv_id' => $data['inc_details'][0]->drugs,
            );

            $args = array('inv_type' => 'CA');
            $data['invitem'] = $this->inv_model->get_inv_list($args);
            $data['med_list'] = $this->med_model->get_med_list();
            $data['intervention_list'] = $this->med_model->get_intervention_list();
            $data['injury_list'] = $this->pcr_model->get_injury();

            $non_args = array('inv_type' => 'NCA');
            $data['noninvitem'] = $this->inv_model->get_inv_list($non_args);


            //////////////////// Update progressbar ///////////////////////////

            $this->increase_step($data['inc_details'][0]->id);

            if ($data['inc_details_data'][0]->patient_ava_or_not == 'yes') {
                $data['inc_details'][0]->epcr_call_type = '2';
            } else if ($data['inc_details_data'][0]->patient_ava_or_not == 'no') {
                $data['inc_details'][0]->epcr_call_type = '1';
            } else if ($data['inc_details_data'][0]->patient_ava_or_not == '' && $data['inc_details_data'][0]->patient_ava_or_not == NULL) {
                $data['inc_details'][0]->epcr_call_type = '2';
            }
            $arg_media = array('inc_ref_id' => $this->post['inc_ref_id']);
            $data['media'] = $this->pcr_model->get_epcr_media($arg_media);

            $data['inc_type'] = $data['inc_type'][0]->inc_type;
            
            
            $data['inc_details'][0]->inc_type = $data['inc_type'] ;

            $arg_media = array('inc_ref_id' => $this->post['inc_ref_id']);
            $data['media'] = $this->pcr_model->get_epcr_media($arg_media);

           
            //$this->output->add_to_position($this->load->view('frontend/pcr/epcr_view1', $data, TRUE), 'content', TRUE);
            $this->output->add_to_position($this->load->view('frontend/pcr/job_closure_view', $data, TRUE), 'content', TRUE);
            $epcr_call_type = $data['inc_details'][0]->epcr_call_type;
            if($data['inc_type'] == 'DROP_BACK' || $data['inc_type'] == 'PICK_UP')
            {
                $epcr_call_type = '2';
            }
            $data['amb_type'] = $data['inc_emp_info'][0]->ambt_id;
            $data['revalidate'] = '0';
            if ($epcr_call_type == '1') {
                $this->output->add_to_position($this->load->view('frontend/pcr/patient_notavailable_epcr_view', $data, TRUE), 'call_type_view', TRUE);
            } elseif ($epcr_call_type == '2') {
                $this->output->add_to_position($this->load->view('frontend/pcr/patient_available_epcr_view', $data, TRUE), 'call_type_view', TRUE);
            } elseif ($epcr_call_type == '3') {
                $this->output->add_to_position($this->load->view('frontend/pcr/on_scene_care_epcr_view', $data, TRUE), 'call_type_view', TRUE);
            }
            // $this->output->add_to_position($this->load->view('frontend/pcr/footer_steps', $data, TRUE), 'footer_steps', TRUE);
            //  $this->output->template = "pcr";
        } else {
            $this->output->message = "<div class='error'>Please Enter valid Incident Id</div>";
        }
    }
    function epcr_view_change()
    {
        $data = $this->input->post();
        $epcr_call_type = $data['epcr_call_type'];
        $amb_type = $data['ambt_id'];
        $reopen = $data['reopen'] = $this->post['reopen'];

        $data['user_group'] = $this->clg->clg_group;
        if ($this->post['inc_ref_id'] == '') {
            $this->post['inc_ref_id'] = base64_decode($this->input->get('inc_id'));
        }
        if (($this->post['inc_ref_id'] == "") && ($this->post['inc_ref_id'] == NULL)) {

            $this->call_info();
            return;
        }
        $data['inc_ref_id'] = trim($this->post['inc_ref_id']);
        $this->session->set_userdata('inc_ref_id', $this->post['inc_ref_id']);
        $inc_args = array(
            'inc_ref_id' => trim($this->post['inc_ref_id']),
            'base_month' => $this->post['base_month'],
        );
        $args = array(
            'inc_ref_id' => trim($this->post['inc_ref_id']),
            'base_month' => $this->post['base_month'],
        );
        $data['vahicle_info'] = $this->pcr_model->get_inc_amb_by_inc($args);
        
        $data['total_closure_count']= $this->pcr_model->get_closure_count_by_ambulance_no($data['vahicle_info'][0]->amb_rto_register_no);

        if ($reopen == 'y') {
            $args['pcr_status'] = '1';
            
            $data['total_closure_count']= $this->pcr_model->get_closure_count_by_ambulance_no_validate($data['vahicle_info'][0]->amb_rto_register_no);
        }

        $data['patient_info'] = $this->pcr_model->get_pending_pat_by_inc($args);
        $arrLength = count($data['patient_info']);
        //var_dump($arrLength);
        $data['pt_count'] = $arrLength;
        $data['inc_details'] = $this->pcr_model->get_epcr_inc_details($inc_args);
        if (empty($data['inc_details'])) {

            $this->session->unset_userdata('pcr_details');
            $data['inc_details'] = $this->inc_model->get_inc_details($inc_args);
        }
        $data['inc_details_data'] = $this->inc_model->get_inc_details($inc_args);
        if ($data['inc_details_data'][0]->inc_complaint != 0 && $data['inc_details_data'][0]->inc_complaint != '') {
            $data['ct_type'] = get_cheif_complaint($data['inc_details_data'][0]->inc_complaint);
        }
        if ($data['inc_details_data'][0]->inc_mci_nature != 0 && $data['inc_details_data'][0]->inc_mci_nature != '') {
            $data['ct_type'] = get_mci_nature_service($data['inc_details_data'][0]->inc_mci_nature);
        }
        if (!empty($data['inc_details'])) {
            $amb_args = array(
                'inc_ref_id' => trim($this->post['inc_ref_id']),
                'amb_ref_id' => $data['inc_details'][0]->amb_ref_id,
                'base_month' => $this->post['base_month']
            );
            $data['inc_emp_info'] = $this->pcr_model->get_inc_amb($amb_args);
            $data['patient_id'] = $data['inc_details'][0]->ptn_id;
            $data['inc_added_by'] = $data['inc_details'][0]->inc_added_by;
            $data['inc_purpose'] = $data['inc_details'][0]->pname;
            $ptn_args = array(
                'ptn_id' => $data['inc_details'][0]->ptn_id,
                'base_month' => $this->post['base_month']
            );
            $data['pt_info'] = $this->pet_model->get_petinfo($ptn_args);


            $args = array(
                'pcr_id' => $data['inc_details'][0]->id,
                'patient_id' => $data['inc_details'][0]->ptn_id,
                'base_month' => $this->post['base_month']
            );

            $data['driver_data'] = array();
            if ($data['inc_details'][0]->id != '') {
                

                $data['driver_data'] = $this->pcr_model->get_driver(array('dp_pcr_id' => $data['inc_details'][0]->id));
                $odo_args = array('inc_ref_id' => trim($data['inc_details'][0]->inc_ref_id));

                $data['get_odometer'] = $this->amb_model->get_amb_odometer_by_inc($odo_args);
                
                if (empty($data['get_odometer'])) {
                    $args_odometer = array('rto_no' => $data['inc_emp_info'][0]->amb_rto_register_no);
                    $amb_odometer = $this->amb_model->get_amb_odometer_closure($args_odometer);
                  

                    if (empty($data['previous_odometer'])) {
                        $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;
                    }

                    if (empty($data['previous_odometer'])) {
                        $data['previous_odometer'] = 0;
                    }
                    
                }
                $kids_args = array(
                    'ptn_id' => $data['inc_details'][0]->ptn_id,
                    'inc_ref_id' => $data['inc_details'][0]->inc_ref_id
                );
                $data['kid_details'] = $this->pcr_model->get_kid_details($kids_args);
            } else {

                $args_odometer = array('rto_no' => $data['inc_emp_info'][0]->amb_rto_register_no);
                $amb_odometer = $this->amb_model->get_amb_odometer_closure($args_odometer);


                if (empty($data['previous_odometer'])) {
                    $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;
                }

                if (empty($data['previous_odometer'])) {
                    $data['previous_odometer'] = 0;
                }
            }
            $get_amb_stock = array(
                'pcr_id' => $data['inc_details'][0]->id,
                'sub_type' => 'pcr',
                'as_item_type' => 'NCA'
            );

            $data['pcr_na_med_inv_data'] = $this->ind_model->get_amb_stock($get_amb_stock);


            $get_amb_stock = array(
                'pcr_id' => $data['inc_details'][0]->id,
                'sub_type' => 'pcr',
                'as_item_type' => 'CA'
            );

            $data['pcr_med_inv_data'] = $this->ind_model->get_amb_stock($get_amb_stock);

            $get_med_amb_stock = array(
                'pcr_id' => $data['inc_details'][0]->id,
                'sub_type' => 'pcr',
                'as_item_type' => 'MED'
            );
            $data['pcr_med_data'] = $this->ind_model->get_amb_stock($get_med_amb_stock);


            $non_unit_args = array(
                'inv_id' => $data['inc_details'][0]->drugs,
            );

            $args = array('inv_type' => 'CA');
            $data['invitem'] = $this->inv_model->get_inv_list($args);
            $data['med_list'] = $this->med_model->get_med_list();
            $data['intervention_list'] = $this->med_model->get_intervention_list();
            $data['injury_list'] = $this->pcr_model->get_injury();


            $non_args = array('inv_type' => 'NCA');
            $data['noninvitem'] = $this->inv_model->get_inv_list($non_args);
            $this->increase_step($data['inc_details'][0]->id);
            $data['epcr_call_type'] = $epcr_call_type;
            $data['amb_type'] = $amb_type;
            if ($epcr_call_type == '1') {
                $this->output->add_to_position($this->load->view('frontend/pcr/patient_notavailable_epcr_view', $data, TRUE), 'call_type_view', TRUE);
            } elseif ($epcr_call_type == '2') {
                $this->output->add_to_position($this->load->view('frontend/pcr/patient_available_epcr_view', $data, TRUE), 'call_type_view', TRUE);
            } elseif ($epcr_call_type == '3') {
                $this->output->add_to_position($this->load->view('frontend/pcr/on_scene_care_epcr_view', $data, TRUE), 'call_type_view', TRUE);
            }
        } else {
            $this->output->message = "<div class='error'>Please Enter valid Incident Id</div>";
        }
    }
    function hospital_odometer()
    {
        //var_dump('hii');die();
        $data['start_odometer_pcr'] = $this->post['start_odometer_pcr'];
        $data['hospital_odometer'] = $this->post['hospital_odometer'];
        $data['scene_odometer'] = $this->post['scene_odometer'];
        $data['from_scene_odometer'] = $this->post['from_scene_odometer'];
        $this->output->add_to_position($this->load->view('frontend/pcr/load_hospital_odo_view', $data, TRUE), 'hos_view', TRUE);
    }
    function handover_odometer()
    {
        //var_dump('hii');die();
        $data['start_odometer_pcr'] = $this->post['start_odometer_pcr'];
        $data['hospital_odometer'] = $this->post['hospital_odometer'];
        $data['scene_odometer'] = $this->post['scene_odometer'];
        $data['from_scene_odometer'] = $this->post['from_scene_odometer'];
        $data['handover_odometer'] = $this->post['handover_odometer'];
        $this->output->add_to_position($this->load->view('frontend/pcr/load_handover_odo_view', $data, TRUE), 'handover_view', TRUE);
    }
    function end_odometer()
    {
        //var_dump('hii');die();
        $data['hospital_odometer'] = $this->post['hospital_odometer'];
        $data['end_odometer_input'] = $this->post['end_odometer_input'];
        $data['start_odometer_pcr'] = $this->post['start_odometer_pcr'];
        $data['scene_odometer'] = $this->post['scene_odometer'];
        $data['from_scene_odometer'] = $this->post['from_scene_odometer'];
        $data['handover_odometer'] = $this->post['handover_odometer'];
        $this->output->add_to_position($this->load->view('frontend/pcr/load_end_odometer_odo_view', $data, TRUE), 'end_odometer_textbox', TRUE);
    }
    function scene_odometer()
    {
        $data['scene_odometer_pcr'] = $this->post['scene_odometer_pcr'];
        $data['start_odometer_pcr'] = $this->post['start_odometer_pcr'];
        $this->output->add_to_position($this->load->view('frontend/pcr/load_scene_odo_view', $data, TRUE), 'scene_view', TRUE);
    }
    function from_scene_odometer()
    {
        $data['from_scene_odometer_pcr'] = $this->post['from_scene_odometer_pcr'];
        $data['scene_odometer_pcr'] = $this->post['scene_odometer_pcr'];
        $data['start_odometer_pcr'] = $this->post['start_odometer_pcr'];
        $this->output->add_to_position($this->load->view('frontend/pcr/load_from_scene_odo_view', $data, TRUE), 'from_scene_view', TRUE);
    }
    function save_job_closure()
    {
        $epcr_info = $this->input->post();


        $inter_info = $this->input->post('inter');
        $pt_con_handover = $this->input->post('pt_con_handover');
        $pt_con_ongoing = $this->input->post('pt_con_ongoing');
        $baseline_con = $this->input->post('baseline_con');

        $kid_details = $this->input->post('kid');

        $obious_death_ques = "";
        if (isset($epcr_info['obious_death']['ques'])) {
            $obious_death_ques = serialize($epcr_info['obious_death']['ques']);
        }

        $odo_args = array('inc_ref_id' => $epcr_info['inc_ref_id']);
        $get_odometer = $this->amb_model->get_amb_odometer_by_inc($odo_args);
        $total_km = (int)$epcr_info['end_odmeter'] - (int)$epcr_info['start_odmeter'];


        if ($this->clg->clg_group == 'UG-DCO-102') {
            $system_type = '102';
        }
        if ($this->clg->clg_group == 'UG-BIKE-DCO') {
            $system_type = 'BIKE';
        } else {
            $system_type = '108';
        }

        $amb_details = $this->inc_model->get_ambulance_details_API($epcr_info['amb_reg_id']);
        $amb_lat = $amb_details[0]->amb_lat;
        $amb_log = $amb_details[0]->amb_log;
        $amb_status = $amb_details[0]->amb_status;
        $thirdparty = $amb_details[0]->thirdparty;
        if ($epcr_info['receiving_host'] == '') {
            $res_hos = $inter_info['new_facility'];
        } else {
            $res_hos = $epcr_info['receiving_host'];
        }

        if ($pt_con_ongoing['Past_medical_history']) {
            $past_medical = array();
            foreach ($pt_con_ongoing['Past_medical_history'] as $past_med_his) {

                $past_medical[] = array('id' => $past_med_his);
            }


            $past_medical = json_encode($past_medical);
        }
        if ($baseline_con['osat'] != '') {
            $ini_oxy_sat_get_nf = 'yes';
        } else {
            $ini_oxy_sat_get_nf = 'no';
        }
        if ($pt_con_handover['osat'] != '') {
            $hc_oxy_sat_get_nf = 'yes';
        } else {
            $hc_oxy_sat_get_nf = 'no';
        }
        if ($baseline_con['pulse'] != '') {
            $ini_cir_pulse_p = 'yes';
        } else {
            $ini_cir_pulse_p = 'no';
        }
        if ($pt_con_handover['pulse'] != '') {
            $hc_cir_pulse_p = 'yes';
        } else {
            $hc_cir_pulse_p = 'no';
        }
        $epcr_insert_info = array(
            'date' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'amb_reg_id' => $epcr_info['amb_reg_id'],
            'inc_ref_id' => $epcr_info['inc_ref_id'],
            'ptn_id' => $epcr_info['pat_id'],
            'ercp_advice' => $epcr_info['ercp_advice'],
            // 'loc' => $epcr_info['loc'],
            'provider_casetype' => $epcr_info['provider_casetype'],
            'provider_impressions' => $epcr_info['provider_impressions'],
            //'rec_hospital_name' => $inter_info['new_facility'],
            'rec_hospital_name' => $res_hos,
            'drop_home_address' => $epcr_info['drop_home_address'],
            'drop_district' => $epcr_info['drop_district'],
            'base_month' => $this->post['base_month'],
            'state_id' => $epcr_info['tc_dtl_state'],
            'district_id' => $epcr_info['tc_dtl_districts'],
            'city_id' => $epcr_info['tc_dtl_ms_city'],
            'start_odometer' => $epcr_info['start_odmeter'],
            'scene_odometer' => $epcr_info['scene_odometer'],
            'from_scene_odometer' => $epcr_info['from_scene_odometer'],
            'hospital_odometer' => $epcr_info['hospiatl_odometer'],
            'handover_odometer' => $epcr_info['handover_odometer'],
            'end_odometer' => $epcr_info['end_odmeter'],
            'inc_area_type' => $epcr_info['inc_area_type'],
            'total_km' => $total_km,
            'locality' => $epcr_info['locality'],
            'base_location_name' => $epcr_info['base_location'],
            'base_location_id' => $epcr_info['base_location_id'],
            'amb_type_id' => $epcr_info['amb_type_id'],
            'category_id' => $epcr_info['category_id'],
            'wrd_location' => $epcr_info['wrd_location'],
            'wrd_location_id' => $epcr_info['wrd_location_id'],
            'emt_name' => $epcr_info['emt_name'],
            'emso_id' => $epcr_info['emt_id'],
            'pilot_name' => $epcr_info['pilot_name'],
            'emt_id_other' => $epcr_info['emt_id_other'],
            'pilot_name' => $epcr_info['pilot_name'],
            'pilot_id_other' => $epcr_info['pilot_id_other'],
            'pilot_id' => $epcr_info['pilot_id'],
            'remark' => $epcr_info['epcr_remark'],
            'gps_odometer' => $epcr_info['gps_odmeter'],
            'valid_remark' => $epcr_info['valid_remark'],
            'inc_datetime' => $epcr_info['inc_datetime'],
            'obious_death_ques' => $obious_death_ques,
            'operate_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'system_type' => $system_type,
            'third_party' => $thirdparty,
            'epcris_deleted' => '0',

            'loc' => $baseline_con['loc'],
            'ini_airway' => $baseline_con['airway'],
            'ini_breathing' => $baseline_con['breathing'],
            'ini_con_circulation_radial' => $baseline_con['circulation_radial'],
            'ini_con_circulation_carotid' => $baseline_con['circulation_carotid'],
            'ini_con_temp' => $baseline_con['temp'],
            'ini_con_bsl' => $baseline_con['bsl'],
            'ini_cir_pulse_p' => $ini_cir_pulse_p,
            'ini_cir_pulse_p_txt' => $baseline_con['pulse'],
            'ini_oxy_sat_get_nf' => $ini_oxy_sat_get_nf,
            'ini_oxy_sat_get_nf_txt' => $baseline_con['osat'],
            'ini_con_rr' => $baseline_con['rr'],
            'ini_con_gcs' => $baseline_con['gcs'],
            'ini_bp_sysbp_txt' => $baseline_con['bp_syt'],
            'ini_bp_dysbp_txt' => $baseline_con['bp_dia'],
            'ini_con_skin' => $baseline_con['skin'],
            'ini_con_pupils' => $baseline_con['pupils_left'],
            'ini_con_pupils_right' => $baseline_con['pupils_right'],
            'ini_cir_cap_refill_tsec' => $baseline_con['caprefil'],
            'ini_respiression' => $baseline_con['ini_respiression'],

            'hc_loc' => $pt_con_handover['loc'],
            'hc_airway' => $pt_con_handover['airway'],
            'hc_breathing' => $pt_con_handover['breathing'],
            'hc_con_circulation_radial' => $pt_con_handover['circulation_radial'],
            'hc_con_circulation_carotid' => $pt_con_handover['circulation_carotid'],
            'hc_con_temp' => $pt_con_handover['temp'],
            'hc_con__bsl' => $pt_con_handover['bsl'],
            'hc_cir_pulse_p' => $hc_cir_pulse_p,
            'hc_cir_pulse_p_txt' => $pt_con_handover['pulse'],
            'hc_oxy_sat_get_nf' => $hc_oxy_sat_get_nf,
            'hc_oxy_sat_get_nf_txt' => $pt_con_handover['osat'],
            'hc_con_rr' => $pt_con_handover['rr'],
            'hc_con_gcs' => $pt_con_handover['gcs'],
            'hc_bp_sysbp_txt' => $pt_con_handover['bp_syt'],
            'hc_bp_dibp_txt' => $pt_con_handover['bp_dia'],
            'hc_con_skin' => $pt_con_handover['skin'],
            'hc_con_pupils' => $pt_con_handover['pupils_left'],
            'hc_con_pupils_right' => $pt_con_handover['pupils_right'],
            'hc_cir_cap_refill_great_t' => $pt_con_handover['caprefil'],
            'hc_con_respiression' => $pt_con_handover['hc_con_respiression'],
            'hc_status_during_status' => $pt_con_handover['pt_status_during_status'],
            'hc_cardiac' => $pt_con_handover['cardiac'],
            'hc_cardiac_time' => $pt_con_handover['cardiac_time'],

            'hi_pat_handover' => $pt_con_handover['pt_hndover_issue'],
            'opd_no_txt' => $pt_con_handover['issue_opd_no'],
            'pat_handover_issue' => $pt_con_handover['issue_reson'],
            'hosp_person_name' => $pt_con_handover['handover_issue_hos_nm'],
            'corr_action_dt' => $pt_con_handover['handover_issue_datetime'],
            'com_with_hosp' => $pt_con_handover['handover_issue_comm_withhos'],
            'hi_remark' => $pt_con_handover['handover_issue_remark'],

            'ong_past_med_hist' => $past_medical,
            'ong_ph_allergy' => $pt_con_ongoing['allergy'],
            'ong_ph_sign_symptoms' => $pt_con_ongoing['chief_comp'],
            'ong_chief_comp' => $pt_con_ongoing['chief_comp'],
            'ong_ven_supp_bvm' => $pt_con_ongoing['vent_sup_bvm'],
            'ong_ph_last_oral_intake' => $pt_con_ongoing['oral_intake'],
            'ong_suction' => $pt_con_ongoing['pt_con_ongoing_suction'],
            'ong_pos_airway' => $pt_con_ongoing['airway'],
            'ong_scoop_stretcher' => $pt_con_ongoing['scoop_stretcher'],
            'ong_stretcher' => $pt_con_ongoing['stretcher'],
            'ong_wheelchair' => $pt_con_ongoing['wheelchair'],
            'ong_spine_board' => $pt_con_ongoing['spine_board'],
            'ong_ph_event_led_inc' => $pt_con_ongoing['event_leading_to_inc'],
            'ong_medication' => $pt_con_ongoing['on_medication'],
            'ong_supp_oxy_thp' => $pt_con_ongoing['supplemental_oxy_thrpy'],
        );
       
        if (!empty($epcr_info['epcr_call_type'])) {
            $epcr_insert_info['epcr_call_type'] = $epcr_info['epcr_call_type'];
        }
        if (!empty($pt_con_ongoing['other_chief_comp'])) {
            $epcr_insert_info['other_chief_comp'] = $pt_con_ongoing['other_chief_comp'];
        }


       
        if (!empty($epcr_info['pcr_district'])) {
            $epcr_insert_info['hospital_district'] = $epcr_info['pcr_district'];
        }


        if (!empty($epcr_info['other_provider'])) {
            $epcr_insert_info['other_provider_img'] = $epcr_info['other_provider'];
        }
        if (!empty($epcr_info['provider_casetype_other'])) {
            $epcr_insert_info['provider_casetype_other'] = $epcr_info['provider_casetype_other'];
        }


        if (!empty($epcr_info['other_receiving_host'])) {
            $epcr_insert_info['other_receiving_host'] = $epcr_info['other_receiving_host'];
        }
        if (!empty($epcr_info['other_units'])) {
            $epcr_insert_info['other_units'] = $epcr_info['other_units'];
        }

        if (!empty($epcr_info['other_non_units'])) {
            $epcr_insert_info['other_non_units'] = $epcr_info['other_non_units'];
        }

        if ($epcr_info['ercp_advice_Taken'] != '') {
            $epcr_insert_info['ercp_advice_Taken'] = $epcr_info['ercp_advice_Taken'];
        }
        if (!empty($epcr_info['end_odometer_remark'])) {
            $epcr_insert_info['end_odometer_remark'] = $epcr_info['end_odometer_remark'];
        }

        if (!empty($epcr_info['endodometer_remark_other'])) {
            $epcr_insert_info['endodometer_remark_other'] = $epcr_info['endodometer_remark_other'];
        }
        if (!empty($epcr_info['forwording_feedback'])) {
            $epcr_insert_info['forwording_feedback'] = $epcr_info['forwording_feedback'];
        }





        if ($epcr_info['reopen'] == 'y') {

            $args_old = array('inc_ref_id' => $epcr_info['inc_ref_id'], 'ptn_id' => $epcr_info['pat_id']);
            
            $epcr_old_info = $this->pcr_model->get_epcr($args_old);
            $epcr_old_id = $epcr_old_info[0]->id;
            $this->pcr_model->update_epcr_details(array('epcris_deleted' => '1'), $args_old);
            $this->pcr_model->deleted_epcr_details( $args_old);
            //
            // $epcr_insert_info['added_date']=$epcr_old_info[0]->added_date;

            if ($epcr_old_info[0]->added_date == '') {
                $epcr_insert_info['added_date'] = date('Y-m-d H:i:s');
            } else {
                $epcr_insert_info['added_date'] = $epcr_old_info[0]->added_date;
            }
            $epcr_insert_info['operate_by'] = $epcr_old_info[0]->operate_by;
            $epcr_insert_info['is_validate'] = '1';
            $epcr_insert_info['validate_by'] = $this->clg->clg_ref_id;
            $epcr_insert_info['system_type'] = $epcr_old_info[0]->system_type;
            $epcr_insert_info['validate_date'] = date('Y-m-d H:i:s');

            $update_pat_args = array('ptn_id' => $epcr_info['pat_id']);
            $pat_data = array('ptn_pcr_validate_status' => '1');
            $update_pat = $this->pet_model->update_petinfo($update_pat_args, $pat_data);


            $epcr_insert_info = $this->pcr_model->insert_epcr($epcr_insert_info);
        } else {
            $epcr_insert_info['added_date'] = date('Y-m-d H:i:s');
            $epcr_insert_info['operate_by'] = $this->clg->clg_ref_id;
            $epcr_insert_info['is_validate'] = '1';
            $epcr_insert_info['validate_by'] = $this->clg->clg_ref_id;
            $epcr_insert_info['validate_date'] = date('Y-m-d H:i:s');
            $epcr_insert_info = $this->pcr_model->insert_epcr($epcr_insert_info);
            // var_dump($epcr_insert_info);
            // die();
        }
        if ($epcr_insert_info) {
            $inc_amb = array(
                'inc_ref_id' => $epcr_info['inc_ref_id'],
                'amb_pilot_id' => $epcr_info['pilot_id'],
                'amb_emt_id' => $epcr_info['emt_id']
            );
            //var_dump('hi');die();
            $this->inc_model->update_inc_amb($inc_amb);
            if (!empty($kid_details)) {
                $kid_insert_info = array(
                    'added_date' => date('Y-m-d H:i:s'),
                    'inc_ref_id' => $epcr_info['inc_ref_id'],
                    'ptn_id' => $epcr_info['pat_id'],
                    'gender' => $kid_details['gender'],
                    'birth_datetime' => $kid_details['birth_datetime'],
                    'birth_remark' => $kid_details['birth_remark'],
                    'apgar_score' => $kid_details['apgar_score'],
                    'status' => '1'
                );
                $kid_insert_info = $this->pcr_model->insert_kid_details($kid_insert_info);
            }
            // die();
            $closer_operator = array(
                'sub_id' => $epcr_info['inc_ref_id'],
                'operator_id' => $this->clg->clg_ref_id,
                'operator_type' => $this->clg->clg_group,
                'sub_status' => 'ATD',
                'sub_type' => 'CLOSER',
                'base_month' => $this->post['base_month']
            );



            $closer_operator = $this->common_model->assign_operator($closer_operator);

            $inc_date = explode(' ', $epcr_info['inc_datetime']);

            $resonse_time = "";
            if ($epcr_info['at_scene'] != '') {
                $d_start = new DateTime($epcr_info['inc_datetime']);
                $d_end = new DateTime($epcr_info['at_scene']);
                $resonse_time = $d_start->diff($d_end);
            }
            //die();
            //  $resonse_time = date_diff( $epcr_info['at_scene'] , $epcr_info['inc_datetime']);

            $resonse_time = $resonse_time->h . ':' . $resonse_time->i . ':' . $resonse_time->s;
            $resonse_time1 = date('H:i:s', strtotime($resonse_time));


            $data = array(
                'dp_cl_from_desk' => $epcr_info['call_rec_time'],
                'dp_started_base_loc' => $epcr_info['start_from_base'],
                'dp_reach_on_scene' => $epcr_info['from_scene'],
                'dp_on_scene' => $epcr_info['at_scene'],
                'dp_hosp_time' => $epcr_info['at_hospital'],
                'dp_hand_time' => $epcr_info['hand_over'],
                'dp_back_to_loc' => $epcr_info['back_to_base'],
                'dp_pcr_id' => $epcr_insert_info,
                'dp_base_month' => $this->post['base_month'],
                'start_odometer' => $epcr_info['start_odmeter'],
                'scene_odometer' => $epcr_info['scene_odometer'],
                'from_scene_odometer' => $epcr_info['from_scene_odometer'],
                'handover_odometer' => $epcr_info['handover_odometer'],
                'hospital_odometer' => $epcr_info['hospiatl_odometer'],
                'end_odometer' => $epcr_info['end_odmeter'],
                'start_from_base' => $epcr_info['start_from_base'],
                'dp_date' => date('Y-m-d H:i:s'),
                'inc_ref_id' => $epcr_info['inc_ref_id'],
                'responce_time' => $resonse_time1,
                'responce_time_remark' => $epcr_info['responce_time_remark'],
                'responce_time_remark_other' => $epcr_info['responce_time_remark_other'],
                'inc_dispatch_time' => $inc_date[1],
                'dp_operated_by' => $this->clg->clg_ref_id,
                'inc_date' => $inc_date[0]
            );


            if ($epcr_info['reopen'] == 'y') {
                //$epcr_old_id
                $this->pcr_model->update_epcr_details(array('epcris_deleted' => '1'), array('dp_pcr_id' => $epcr_old_id));
                $this->pcr_model->delete_driver_details( array('dp_pcr_id' => $epcr_old_id));
                $insert = $this->pcr_model->insert_deriver_pcr($data);
            } else {
                $insert = $this->pcr_model->insert_deriver_pcr($data);
            }


            $epc_args = array('inc_ref_id' => $epcr_info['inc_ref_id']);
            $pcr_count = $this->pcr_model->get_epcr_count_by_inc($epc_args);

            $args_pt = array(
                'get_count' => TRUE,
                'inc_ref_id' => $epcr_info['inc_ref_id']
            );

            $ptn_count = $this->pcr_model->get_pat_by_inc($args_pt);
            $amb_details = $this->inc_model->get_ambulance_details_API($epcr_info['amb_reg_id']);
            $amb_lat = $amb_details[0]->amb_lat;
            $amb_log = $amb_details[0]->amb_log;
            $amb_status = $amb_details[0]->amb_status;
            $thirdparty = $amb_details[0]->thirdparty;

            if ($amb_status == '2') {
                $upadate_amb_data = array('amb_rto_register_no' => $epcr_info['amb_reg_id'], 'amb_status' => 1);
                $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
            }

            $inc_details = $this->inc_model->get_inc_details_API($epcr_info['inc_ref_id']);
            $inc_lat = $inc_details[0]->inc_lat;
            $inc_long = $inc_details[0]->inc_long;
            $inc_address = $inc_details[0]->inc_address;
            if ($pcr_count == $ptn_count || $pcr_count >= $ptn_count) {

                $update_inc_args = array('inc_ref_id' => $epcr_info['inc_ref_id'], 'inc_pcr_status' => '1');
                $update_inc = $this->inc_model->update_incident($update_inc_args);

                /*
            $inc_args = array( 'inc_ref_id' => trim($this->post['inc_ref_id']),'is_pda_inc'=>'yes');
            $pda_inc_details = $this->inc_model->get_total_by_call_type_inc($inc_args)[0];

            if(!empty($pda_inc_details)){
                $json_data = array('incidentID'=>$pda_inc_details->inc_ref_id,
                                    'CADIncidentID '=>$pda_inc_details->CADIncidentID,
                                    'eventstatus'=> 'closed');
                
                $json_data =  '{
                "data": {
                "incidentID": "'.$pda_inc_details->inc_ref_id.'",
                "CADIncidentID ": "'.$pda_inc_details->CADIncidentID.'",
                "eventstatus": "closed"
                }
                }';

               // $json_data= json_encode($json_data);

                //$api_pda = pda_case_close_api($json_data);

           } */
           $inc_details_api = $this->inc_model->get_gps_closing_parameters($epcr_info['inc_ref_id']);
           $pname = $inc_details_api[0]->pname;
           $inc_recive_time=$inc_details_api[0]->inc_recive_time;
           $inc_datetime=$inc_details_api[0]->inc_datetime;
           $ayushman_id = $inc_details_api[0]->ayushman_id;
           $inc_type = $inc_details_api[0]->inc_type;
           if($ayushman_id == '' || $ayushman_id == 'NA' || $ayushman_id == null){
                $Exemption = "no";
                $ayushman_id = "no";
            }else{
                $Exemption = "yes";
            }
            if($inc_details_api[0]->ct_type != ''){
                $chief_complaint = $inc_details_api[0]->ct_type;
            }else{
                $chief_complaint = $inc_details_api[0]->ntr_nature;
            }
           $pro_impression_name = get_provider_impression($epcr_info['provider_impressions']);

           $hos_details = get_hospital_by_id($res_hos);
           
           $hos_name = $hos_details[0]->hp_name;
           $hp_type = $hos_details[0]->hp_type;
           $hos_type_nm = get_hosp_type_by_id($hp_type);
           $inc_details_api = $this->inc_model->get_gps_closing_parameters($epcr_info['inc_ref_id']);
           $pname = $inc_details_api[0]->pname;
           $pname = $inc_details_api[0]->pname;
            //if($epcr_info['amb_reg_id'] == "TT-00-MP-0000"){
                     $veh = implode('',explode('-',$epcr_info['amb_reg_id']));
           // }
            if($epcr_info['epcr_call_type']=='2' || $epcr_info['epcr_call_type']=='3')
            {
                if($epcr_info['at_hospital'] == '' || $epcr_info['at_hospital'] == '0000-00-00 00:00:00' ){
                    $DropDateTime = date('Y-m-d H:i', strtotime($epcr_info['at_hospital']));
                }else{
                    $DropDateTime = 'NA';
                }
            }
            if($epcr_info['epcr_call_type']=='1' || $inc_type=='DROP_BACK')
            {
                if($epcr_info['back_to_base'] == '' || $epcr_info['back_to_base'] == '0000-00-00 00:00:00' ){
                    $DropDateTime = date('Y-m-d H:i', strtotime($epcr_info['back_to_base']));
                }else{
                    $DropDateTime = 'NA';
                }
                $hos_name ='NA';
                $hos_type_nm='NA';
            }if($epcr_info['epcr_call_type']=='3')
            {
                $hos_name ='NA';
                $hos_type_nm='NA';
            }
            if($hos_name == 'Other' || $hos_name == '')
            {
                $hos_name =$epcr_info['other_receiving_host'];
                $hos_type_nm ='NA';
            }
           
                $args = array(
                    'ProjectType'=> '108',
                    'EmType'=>$pname, // ERO CAll type
                    'CallDateTime'=>date('Y-m-d H:i', strtotime($inc_recive_time)),
                    'JobNo' => $epcr_info['inc_ref_id'],
                    'AmbulanceNo' => $veh,
                    'DispatchedDateTime' => date('Y-m-d H:i', strtotime($inc_datetime)),
                    'ReachedtosceneDateTime' => date('Y-m-d H:i', strtotime($epcr_info['at_scene'])),
                    'DropHospital' => $hos_name,
                    'HospitalType' => $hos_type_nm,
                    'BacktobaseDatetime' => date('Y-m-d H:i', strtotime($epcr_info['back_to_base'])),
                    'TripDistance' => $total_km,
                    'stateCode'=>'MP',
                    'ClosingStatus'=>'Closed',
                    'DropDateTime'=>$DropDateTime,
                    'EmergencyChiefComplaint'=>$chief_complaint, // chief complaint
                    'AyushmanCard'=>$ayushman_id,
                    'Exemption' => $Exemption
                );
                //var_dump($args);die();
                $send_API = send_API_close($args);
            } else {
                if ($epcr_info['inc_ref_id'] != '' || $epcr_info['inc_ref_id'] != NULL) {
                    $update_inc_args = array('inc_ref_id' => $epcr_info['inc_ref_id'], 'inc_pcr_status' => '0');
                    $update_inc = $this->inc_model->update_incident($update_inc_args);
                }
            }

            $update_pat_args = array('ptn_id' => $epcr_info['pat_id']);
            $pat_data = array('ptn_pcr_status' => '1');
            $update_pat = $this->pet_model->update_petinfo($update_pat_args, $pat_data);

            $unique_id = get_uniqid($this->session->userdata('user_default_key'));
            $amb_record_data = array(
                'id' => $unique_id,
                'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                'inc_ref_id'          => $epcr_info['inc_ref_id'],
                'start_odmeter'       => $epcr_info['start_odmeter'],
                'scene_odometer'      => $epcr_info['scene_odometer'],
                'from_scene_odometer' => $epcr_info['from_scene_odometer'],
                'handover_odometer' => $epcr_info['handover_odometer'],
                'hospital_odometer'   => $epcr_info['hospiatl_odometer'],
                'end_odmeter'         => $epcr_info['end_odmeter'],
                'total_km'            => $total_km,
                'timestamp'           => date('Y-m-d H:i:s'),
                'odometer_type'       => 'closure'
            );

            if (!empty($epcr_info['odometer_remark'])) {
                $amb_record_data['remark'] = $epcr_info['odometer_remark'];
            }

            if (!empty($epcr_info['remark_other'])) {
                $amb_record_data['other_remark'] = $epcr_info['remark_other'];
            }
            if (!empty($epcr_info['end_odometer_remark'])) {
                $amb_record_data['end_odometer_remark'] = $epcr_info['end_odometer_remark'];
            }

            if (!empty($epcr_info['endodometer_remark_other'])) {
                $amb_record_data['endodometer_remark_other'] = $epcr_info['endodometer_remark_other'];
            }

            $odo_args = array('inc_ref_id' => $epcr_info['inc_ref_id']);
            $get_odometer = $this->amb_model->get_amb_odometer_by_inc($odo_args);

            if (empty($get_odometer)) {

                $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
            } else {
                if ($epcr_info['reopen'] == 'y' || $epcr_info['reopen_case'] == 'y') {
                    //$epcr_old_id
                    if ($epcr_info['inc_ref_id'] != '') {
                        $this->amb_model->update_timestamp_odometer_amb(array('flag' => '2', 'odometer_type' => 'old_closure'), array('insident_no' => $epcr_info['inc_ref_id']));
                    }
                    $amb_record_data['flag'] = $get_odometer[0]->flag;
                    $insert_time = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
                } else {
                    $insert = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
                }
            }
            // inc_pcr
            // inc_pcr_status
            $args = array(
                //'ptn_id' => $epcr_info['pat_id'],
                'ptn_state' => $epcr_info['tc_dtl_state'],
                'ptn_district' => $epcr_info['tc_dtl_district'],
                'ptn_city' => $epcr_info['tc_dtl_ms_city'],
                'ptn_address' => $epcr_info['locality'],
            );


            $this->pet_model->update_petinfo(array('ptn_id' => $epcr_info['pat_id']), $args);


            $pcr_data[$epcr_info['inc_ref_id']] = array(
                'patient_id' => $epcr_info['pat_id'],
                'inc_ref_id' => $epcr_info['inc_ref_id'],
                'rto_no' => $epcr_info['amb_reg_id'],
                'pcr_id' => $epcr_insert_info
            );

            $this->session->set_userdata('pcr_details', $pcr_data);

            $data_pcr = array(
                'inc_ref_id' => $epcr_info['inc_ref_id'],
                'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                'patient_id' => $epcr_info['pat_id'],
                'base_month' => $this->post['base_month'],
                'pcr_id' => $epcr_insert_info,
                'date' => date('Y-m-d H:i:s')
            );
            //
            //         if($epcr_info['reopen'] == 'y'){
            //            //$epcr_old_id
            //             $this->pcr_model->update_pcr_details(array('pcr_isdeleted ' => '1'), array('pcr_id'=>$epcr_old_id));
            //            $insert = $this->pcr_model->insert_deriver_pcr($data);
            //           
            //        }else{
            $pcr_id = $this->pcr_model->insert_pcr($data_pcr);
            // }


            if ($epcr_info['reopen'] == 'y') {
                $deletet_amb_stock =  array(
                    'pcr_id' => $epcr_old_id,
                    'sub_type' => 'pcr',
                    'as_isdeleted' => '1'
                );
                $this->ind_model->deletet_amb_stock($deletet_amb_stock);
            } else {

                $deletet_amb_stock = array(
                    'pcr_id' => $epcr_insert_info,
                    'sub_type' => 'pcr'
                );
                $this->ind_model->deletet_amb_stock($deletet_amb_stock);
            }

            if (isset($epcr_info['obious_death']['ques'])) {
                foreach ($epcr_info['obious_death']['ques'] as $key => $ques) {

                    $ems_summary = array(
                        'sum_base_month' => $this->post['base_month'],
                        'sum_epcr_id' => $epcr_insert_info,
                        'inc_ref_id' => $epcr_info['inc_ref_id'],
                        'ptn_id' => $epcr_info['pat_id'],
                        'sum_que_id' => $key,
                        'sum_que_ans' => $ques
                    );

                    $this->pcr_model->insert_obvious_death_ques_summary($ems_summary);
                }
            }


            if (isset($epcr_info['injury'])) {
                foreach ($epcr_info['injury'] as $injury) {

                    if ($injury['id'] != '' && $injury['type'] != '') {

                        $injury_args = array(
                            'as_item_id' => $injury['id'],
                            'incidentId' => $epcr_info['inc_ref_id'],
                            'as_item_type' => $injury['type'],
                            'as_stk_in_out' => 'out',
                            'as_item_qty' => 1,
                            'as_sub_id' => $epcr_insert_info,
                            'as_sub_type' => 'pcr',
                            'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                            'as_date' => $this->today,
                            'as_base_month' => $this->post['base_month'],
                        );


                        $this->ind_model->insert_amb_stock($injury_args);
                    }
                }
            }
            if (isset($epcr_info['intervention'])) {
                foreach ($epcr_info['intervention'] as $inter) {

                    if ($inter['id'] != '' && $inter['type'] != '') {

                        $inter_args = array(
                            'as_item_id' => $inter['id'],
                            'incidentId' => $epcr_info['inc_ref_id'],
                            'as_item_type' => $inter['type'],
                            'as_stk_in_out' => 'out',
                            'as_item_qty' => 1,
                            'as_sub_id' => $epcr_insert_info,
                            'as_sub_type' => 'pcr',
                            'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                            'as_date' => $this->today,
                            'as_base_month' => $this->post['base_month'],
                        );


                        $this->ind_model->insert_amb_stock($inter_args);
                    }
                }
            }

            if (isset($epcr_info['med'])) {
                foreach ($epcr_info['med'] as $med) {

                    if ($med['value'] != '' && $med['type'] != '') {

                        $unit_args = array(
                            'as_item_id' => $med['id'],
                            'incidentId' => $epcr_info['inc_ref_id'],
                            'as_item_type' => $med['type'],
                            'as_stk_in_out' => 'out',
                            'as_item_qty' => $med['value'],
                            'as_sub_id' => $epcr_insert_info,
                            'as_sub_type' => 'pcr',
                            'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                            'as_date' => $this->today,
                            'as_base_month' => $this->post['base_month'],
                        );


                        $this->ind_model->insert_amb_stock($unit_args);
                    }
                }
            }
            if (isset($epcr_info['unit'])) {
                foreach ($epcr_info['unit'] as $unit) {

                    if ($unit['value'] != '' && $unit['type'] != '') {

                        $unit_args = array(
                            'as_item_id' => $unit['id'],
                            'incidentId' => $epcr_info['inc_ref_id'],
                            'as_item_type' => $unit['type'],
                            'as_stk_in_out' => 'out',
                            'as_item_qty' => $unit['value'],
                            'as_sub_id' => $epcr_insert_info,
                            'as_sub_type' => 'pcr',
                            'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                            'as_date' => $this->today,
                            'as_base_month' => $this->post['base_month'],
                        );


                        $this->ind_model->insert_amb_stock($unit_args);
                    }
                }
            }
            if (isset($epcr_info['non_unit'])) {
                foreach ($epcr_info['non_unit'] as $unit) {
                    if ($unit['id'] != '' && $unit['type'] != '') {
                        $unit_args = array(
                            'as_item_id' => $unit['id'],
                            'incidentId' => $epcr_info['inc_ref_id'],
                            'as_item_type' => $unit['type'],
                            'as_stk_in_out' => 'out',
                            'as_item_qty' => 1,
                            'as_sub_id' => $epcr_insert_info,
                            'as_sub_type' => 'pcr',
                            'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                            'as_date' => $this->today,
                            'as_base_month' => $this->post['base_month'],
                        );

                        $this->ind_model->insert_amb_stock($unit_args);
                    }
                }
            }
            // var_dump($epcr_info['provider_impressions']);die();
            $provide_imp = array('21', '41', '42', '43', '45');
            if (in_array($epcr_info['provider_impressions'], $provide_imp)) {
                // $is_deleted='1';
                // var_dump(  "hi" );die();
                $epcr_insert_info1 = array(
                    'inc_ref_id' => $epcr_info['inc_ref_id']
                );

                // $epcr_insert_info = $this->pcr_model->update_is_deleted($epcr_insert_info1);
                $update_inc_args = array('inc_ref_id' => $epcr_info['inc_ref_id'], 'inc_pcr_status' => '1', 'inc_feedback_status' => '2');
                // $update_inc = $this->inc_model->update_incident($update_inc_args);

            }
            // else{
            //     $is_deleted='0';
            // }
            // var_dump( $update_inc_args );die();


            $this->session->set_userdata('pcr_steps', '1');

            //////////////////////////////////////////////////////////

            $flforms = pcr_steps($epcr_insert_info, "PCR");

            //////////////////////////////////////////////////////////
        }
        $caller_mob = $this->pcr_model->get_caller_details($epc_args);
        // print_r($caller_mob[0]->clr_mobile);die;
        //sms
        if($epcr_info['epcr_call_type']!='1')
        {
        $txtMsg1 = '';
        $txtMsg1.= "Dear ".$epcr_info['ptn_fname']." ".$epcr_info['ptn_lname'].", \n";
        $txtMsg1.= "For feedback click on \n";
        $txtMsg1.= "http://irts.jaesmp.com/JAEms/feedback/pt_feedback/".$epcr_info['inc_ref_id'] ."/".$inc_details_api[0]->inc_type.",\n" ;
        $txtMsg1.= "Link: ".$amb_dir_url."\n" ;
        $txtMsg1 .= "Please click on the following link for downloading the 108 Sanjeevani app on your mobile
        Android User - https://tinyurl.com/2p87kfu6 and iOS User-
        https://tinyurl.com/3pup8pp4";
        $txtMsg1.= "JAES" ;
        // var_dump($txtMsg1);die();
        $sms_to = $caller_mob[0]->clr_mobile;
        // var_dump($sms_to);die;
        $args = array(
            'inc_id' => $epcr_info['inc_ref_id'],
            'msg' => $txtMsg1,
            'mob_no' => $sms_to,
            'sms_user'=>'feedback_patient',
        );
        // var_dump($args);die;
       $sms_data = sms_send($args);
    }
        if ($epcr_insert_info) {

            if ($this->session->userdata['current_user']->clg_group == "UG-ShiftManager") {

                $this->output->message = "<div class='success'> Added successfully <a href='" . $this->base_url . "supervisor' class='dark_blue'>Back to Dashboard</a></div>";
            } else {

                $this->output->message = "<div class='success'> Added successfully <a href='" . $this->base_url . "job_closer' class='dark_blue'>Back to Dashboard</a></div>";
            }
        } else {

            $this->output->message = "<div class='error' style='color: red;font-weight: bold;font-size: 150%;'> ERROR : Please Fill All Details..Try Again </div>";
        }
    }

    function save_job_closure_revalidate()
    {
        $epcr_info = $this->input->post();

// var_dump($epcr_info);die();
        $inter_info = $this->input->post('inter');
        $pt_con_handover = $this->input->post('pt_con_handover');
        $pt_con_ongoing = $this->input->post('pt_con_ongoing');
        $baseline_con = $this->input->post('baseline_con');

        $kid_details = $this->input->post('kid');

        $obious_death_ques = "";
        if (isset($epcr_info['obious_death']['ques'])) {
            $obious_death_ques = serialize($epcr_info['obious_death']['ques']);
        }

        $odo_args = array('inc_ref_id' => $epcr_info['inc_ref_id']);
        $get_odometer = $this->amb_model->get_amb_odometer_by_inc($odo_args);
        $total_km = (int)$epcr_info['end_odmeter'] - (int)$epcr_info['start_odmeter'];


        if ($this->clg->clg_group == 'UG-DCO-102') {
            $system_type = '102';
        }
        if ($this->clg->clg_group == 'UG-BIKE-DCO') {
            $system_type = 'BIKE';
        } else {
            $system_type = '108';
        }

        $amb_details = $this->inc_model->get_ambulance_details_API($epcr_info['amb_reg_id']);
        $amb_lat = $amb_details[0]->amb_lat;
        $amb_log = $amb_details[0]->amb_log;
        $amb_status = $amb_details[0]->amb_status;
        $thirdparty = $amb_details[0]->thirdparty;
        if ($epcr_info['receiving_host'] == '') {
            $res_hos = $inter_info['new_facility'];
        } else {
            $res_hos = $epcr_info['receiving_host'];
        }

        if ($pt_con_ongoing['Past_medical_history']) {
            $past_medical = array();
            foreach ($pt_con_ongoing['Past_medical_history'] as $past_med_his) {

                $past_medical[] = array('id' => $past_med_his);
            }


            $past_medical = json_encode($past_medical);
        }
        if ($baseline_con['osat'] != '') {
            $ini_oxy_sat_get_nf = 'yes';
        } else {
            $ini_oxy_sat_get_nf = 'no';
        }
        if ($pt_con_handover['osat'] != '') {
            $hc_oxy_sat_get_nf = 'yes';
        } else {
            $hc_oxy_sat_get_nf = 'no';
        }
        if ($baseline_con['pulse'] != '') {
            $ini_cir_pulse_p = 'yes';
        } else {
            $ini_cir_pulse_p = 'no';
        }
        if ($pt_con_handover['pulse'] != '') {
            $hc_cir_pulse_p = 'yes';
        } else {
            $hc_cir_pulse_p = 'no';
        }
        $epcr_insert_info = array(
            'date' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'amb_reg_id' => $epcr_info['amb_reg_id'],
            'inc_ref_id' => $epcr_info['inc_ref_id'],
            'ptn_id' => $epcr_info['pat_id'],
            'ercp_advice' => $epcr_info['ercp_advice'],
            // 'loc' => $epcr_info['loc'],
            'provider_casetype' => $epcr_info['provider_casetype'],
            'provider_impressions' => $epcr_info['provider_impressions'],
            //'rec_hospital_name' => $inter_info['new_facility'],
            'rec_hospital_name' => $res_hos,
            'drop_home_address' => $epcr_info['drop_home_address'],
            'drop_district' => $epcr_info['drop_district'],
            'base_month' => $this->post['base_month'],
            'state_id' => $epcr_info['tc_dtl_state'],
            'district_id' => $epcr_info['tc_dtl_districts'],
            'city_id' => $epcr_info['tc_dtl_ms_city'],
            'start_odometer' => $epcr_info['start_odmeter'],
            'scene_odometer' => $epcr_info['scene_odometer'],
            'from_scene_odometer' => $epcr_info['from_scene_odometer'],
            'hospital_odometer' => $epcr_info['hospiatl_odometer'],
            'handover_odometer' => $epcr_info['handover_odometer'],
            'end_odometer' => $epcr_info['end_odmeter'],
            'inc_area_type' => $epcr_info['inc_area_type'],
            'total_km' => $total_km,
            'locality' => $epcr_info['locality'],
            'base_location_name' => $epcr_info['base_location'],
            'base_location_id' => $epcr_info['base_location_id'],
            'amb_type_id' => $epcr_info['amb_type_id'],
            'category_id' => $epcr_info['category_id'],
            'wrd_location' => $epcr_info['wrd_location'],
            'wrd_location_id' => $epcr_info['wrd_location_id'],
            'emt_name' => $epcr_info['emt_name'],
            'emso_id' => $epcr_info['emt_id'],
            'pilot_name' => $epcr_info['pilot_name'],
            'emt_id_other' => $epcr_info['emt_id_other'],
            'pilot_name' => $epcr_info['pilot_name'],
            'pilot_id_other' => $epcr_info['pilot_id_other'],
            'pilot_id' => $epcr_info['pilot_id'],
            'remark' => $epcr_info['epcr_remark'],
            'gps_odometer' => $epcr_info['gps_odmeter'],
            'valid_remark' => $epcr_info['valid_remark'],
            'inc_datetime' => $epcr_info['inc_datetime'],
            'obious_death_ques' => $obious_death_ques,
            'operate_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'system_type' => $system_type,
            'third_party' => $thirdparty,
            'epcris_deleted' => '0',

            'loc' => $baseline_con['loc'],
            'ini_airway' => $baseline_con['airway'],
            'ini_breathing' => $baseline_con['breathing'],
            'ini_con_circulation_radial' => $baseline_con['circulation_radial'],
            'ini_con_circulation_carotid' => $baseline_con['circulation_carotid'],
            'ini_con_temp' => $baseline_con['temp'],
            'ini_con_bsl' => $baseline_con['bsl'],
            'ini_cir_pulse_p' => $ini_cir_pulse_p,
            'ini_cir_pulse_p_txt' => $baseline_con['pulse'],
            'ini_oxy_sat_get_nf' => $ini_oxy_sat_get_nf,
            'ini_oxy_sat_get_nf_txt' => $baseline_con['osat'],
            'ini_con_rr' => $baseline_con['rr'],
            'ini_con_gcs' => $baseline_con['gcs'],
            'ini_bp_sysbp_txt' => $baseline_con['bp_syt'],
            'ini_bp_dysbp_txt' => $baseline_con['bp_dia'],
            'ini_con_skin' => $baseline_con['skin'],
            'ini_con_pupils' => $baseline_con['pupils_left'],
            'ini_con_pupils_right' => $baseline_con['pupils_right'],
            'ini_cir_cap_refill_tsec' => $baseline_con['caprefil'],
            'ini_respiression' => $baseline_con['ini_respiression'],

            'hc_loc' => $pt_con_handover['loc'],
            'hc_airway' => $pt_con_handover['airway'],
            'hc_breathing' => $pt_con_handover['breathing'],
            'hc_con_circulation_radial' => $pt_con_handover['circulation_radial'],
            'hc_con_circulation_carotid' => $pt_con_handover['circulation_carotid'],
            'hc_con_temp' => $pt_con_handover['temp'],
            'hc_con__bsl' => $pt_con_handover['bsl'],
            'hc_cir_pulse_p' => $hc_cir_pulse_p,
            'hc_cir_pulse_p_txt' => $pt_con_handover['pulse'],
            'hc_oxy_sat_get_nf' => $hc_oxy_sat_get_nf,
            'hc_oxy_sat_get_nf_txt' => $pt_con_handover['osat'],
            'hc_con_rr' => $pt_con_handover['rr'],
            'hc_con_gcs' => $pt_con_handover['gcs'],
            'hc_bp_sysbp_txt' => $pt_con_handover['bp_syt'],
            'hc_bp_dibp_txt' => $pt_con_handover['bp_dia'],
            'hc_con_skin' => $pt_con_handover['skin'],
            'hc_con_pupils' => $pt_con_handover['pupils_left'],
            'hc_con_pupils_right' => $pt_con_handover['pupils_right'],
            'hc_cir_cap_refill_great_t' => $pt_con_handover['caprefil'],
            'hc_con_respiression' => $pt_con_handover['hc_con_respiression'],
            'hc_status_during_status' => $pt_con_handover['pt_status_during_status'],
            'hc_cardiac' => $pt_con_handover['cardiac'],
            'hc_cardiac_time' => $pt_con_handover['cardiac_time'],

            'hi_pat_handover' => $pt_con_handover['pt_hndover_issue'],
            'opd_no_txt' => $pt_con_handover['issue_opd_no'],
            'pat_handover_issue' => $pt_con_handover['issue_reson'],
            'hosp_person_name' => $pt_con_handover['handover_issue_hos_nm'],
            'corr_action_dt' => $pt_con_handover['handover_issue_datetime'],
            'com_with_hosp' => $pt_con_handover['handover_issue_comm_withhos'],
            'hi_remark' => $pt_con_handover['handover_issue_remark'],

            'ong_past_med_hist' => $past_medical,
            'ong_ph_allergy' => $pt_con_ongoing['allergy'],
            'ong_ph_sign_symptoms' => $pt_con_ongoing['chief_comp'],
            'ong_chief_comp' => $pt_con_ongoing['chief_comp'],
            'ong_ven_supp_bvm' => $pt_con_ongoing['vent_sup_bvm'],
            'ong_ph_last_oral_intake' => $pt_con_ongoing['oral_intake'],
            'ong_suction' => $pt_con_ongoing['pt_con_ongoing_suction'],
            'ong_pos_airway' => $pt_con_ongoing['airway'],
            'ong_scoop_stretcher' => $pt_con_ongoing['scoop_stretcher'],
            'ong_stretcher' => $pt_con_ongoing['stretcher'],
            'ong_wheelchair' => $pt_con_ongoing['wheelchair'],
            'ong_spine_board' => $pt_con_ongoing['spine_board'],
            'ong_ph_event_led_inc' => $pt_con_ongoing['event_leading_to_inc'],
            'ong_medication' => $pt_con_ongoing['on_medication'],
            'ong_supp_oxy_thp' => $pt_con_ongoing['supplemental_oxy_thrpy'],
            
            're_validate_by' => $this->clg->clg_ref_id,
            're_validate_date' => date('Y-m-d H:i:s'),
            'revalidate_staus'=> '1',
            
            
        );
       
        if (!empty($epcr_info['epcr_call_type'])) {
            $epcr_insert_info['epcr_call_type'] = $epcr_info['epcr_call_type'];
        }
        if (!empty($pt_con_ongoing['other_chief_comp'])) {
            $epcr_insert_info['other_chief_comp'] = $pt_con_ongoing['other_chief_comp'];
        }


       
        if (!empty($epcr_info['pcr_district'])) {
            $epcr_insert_info['hospital_district'] = $epcr_info['pcr_district'];
        }


        if (!empty($epcr_info['other_provider'])) {
            $epcr_insert_info['other_provider_img'] = $epcr_info['other_provider'];
        }
        if (!empty($epcr_info['provider_casetype_other'])) {
            $epcr_insert_info['provider_casetype_other'] = $epcr_info['provider_casetype_other'];
        }


        if (!empty($epcr_info['other_receiving_host'])) {
            $epcr_insert_info['other_receiving_host'] = $epcr_info['other_receiving_host'];
        }
        if (!empty($epcr_info['other_units'])) {
            $epcr_insert_info['other_units'] = $epcr_info['other_units'];
        }

        if (!empty($epcr_info['other_non_units'])) {
            $epcr_insert_info['other_non_units'] = $epcr_info['other_non_units'];
        }

        if ($epcr_info['ercp_advice_Taken'] != '') {
            $epcr_insert_info['ercp_advice_Taken'] = $epcr_info['ercp_advice_Taken'];
        }
        if (!empty($epcr_info['end_odometer_remark'])) {
            $epcr_insert_info['end_odometer_remark'] = $epcr_info['end_odometer_remark'];
        }

        if (!empty($epcr_info['endodometer_remark_other'])) {
            $epcr_insert_info['endodometer_remark_other'] = $epcr_info['endodometer_remark_other'];
        }
        if (!empty($epcr_info['forwording_feedback'])) {
            $epcr_insert_info['forwording_feedback'] = $epcr_info['forwording_feedback'];
        }





        if ($epcr_info['reopen'] == 'y') {

            $args_old = array('inc_ref_id' => $epcr_info['inc_ref_id'], 'ptn_id' => $epcr_info['pat_id']);
            
            $epcr_old_info = $this->pcr_model->get_epcr($args_old);
            $epcr_old_id = $epcr_old_info[0]->id;
            $this->pcr_model->update_epcr_details(array('epcris_deleted' => '1'), $args_old);
            $this->pcr_model->deleted_epcr_details( $args_old);
            //
            // $epcr_insert_info['added_date']=$epcr_old_info[0]->added_date;

            if ($epcr_old_info[0]->added_date == '') {
                $epcr_insert_info['added_date'] = date('Y-m-d H:i:s');
            } else {
                $epcr_insert_info['added_date'] = $epcr_old_info[0]->added_date;
            }
            $epcr_insert_info['operate_by'] = $epcr_old_info[0]->operate_by;
            $epcr_insert_info['is_validate'] = '1';
            $epcr_insert_info['validate_by'] = $this->clg->clg_ref_id;
            $epcr_insert_info['system_type'] = $epcr_old_info[0]->system_type;
            $epcr_insert_info['validate_date'] = date('Y-m-d H:i:s');


            $update_pat_args = array('ptn_id' => $epcr_info['pat_id']);
            $pat_data = array('ptn_pcr_validate_status' => '1');
            $update_pat = $this->pet_model->update_petinfo($update_pat_args, $pat_data);


            $epcr_insert_info = $this->pcr_model->insert_epcr($epcr_insert_info);
        } else {
            $epcr_insert_info['added_date'] = date('Y-m-d H:i:s');
            $epcr_insert_info['operate_by'] = $this->clg->clg_ref_id;
            $epcr_insert_info['is_validate'] = '1';
            $epcr_insert_info['validate_by'] = $this->clg->clg_ref_id;
            $epcr_insert_info['validate_date'] = date('Y-m-d H:i:s');
            $epcr_insert_info = $this->pcr_model->insert_epcr($epcr_insert_info);
            // var_dump($epcr_insert_info);
            // die();
        }
        if ($epcr_insert_info) {
            $inc_amb = array(
                'inc_ref_id' => $epcr_info['inc_ref_id'],
                'amb_pilot_id' => $epcr_info['pilot_id'],
                'amb_emt_id' => $epcr_info['emt_id']
            );
            //var_dump('hi');die();
            $this->inc_model->update_inc_amb($inc_amb);
            if (!empty($kid_details)) {
                $kid_insert_info = array(
                    'added_date' => date('Y-m-d H:i:s'),
                    'inc_ref_id' => $epcr_info['inc_ref_id'],
                    'ptn_id' => $epcr_info['pat_id'],
                    'gender' => $kid_details['gender'],
                    'birth_datetime' => $kid_details['birth_datetime'],
                    'birth_remark' => $kid_details['birth_remark'],
                    'apgar_score' => $kid_details['apgar_score'],
                    'status' => '1'
                );
                $kid_insert_info = $this->pcr_model->insert_kid_details($kid_insert_info);
            }
            // die();
            $closer_operator = array(
                'sub_id' => $epcr_info['inc_ref_id'],
                'operator_id' => $this->clg->clg_ref_id,
                'operator_type' => $this->clg->clg_group,
                'sub_status' => 'ATD',
                'sub_type' => 'CLOSER',
                'base_month' => $this->post['base_month']
            );



            $closer_operator = $this->common_model->assign_operator($closer_operator);

            $inc_date = explode(' ', $epcr_info['inc_datetime']);

            $resonse_time = "";
            if ($epcr_info['at_scene'] != '') {
                $d_start = new DateTime($epcr_info['inc_datetime']);
                $d_end = new DateTime($epcr_info['at_scene']);
                $resonse_time = $d_start->diff($d_end);
            }
            $resonse_time = $resonse_time->h . ':' . $resonse_time->i . ':' . $resonse_time->s;
            $resonse_time1 = date('H:i:s', strtotime($resonse_time));


            $data = array(
                'dp_cl_from_desk' => $epcr_info['call_rec_time'],
                'dp_started_base_loc' => $epcr_info['start_from_base'],
                'dp_reach_on_scene' => $epcr_info['from_scene'],
                'dp_on_scene' => $epcr_info['at_scene'],
                'dp_hosp_time' => $epcr_info['at_hospital'],
                'dp_hand_time' => $epcr_info['hand_over'],
                'dp_back_to_loc' => $epcr_info['back_to_base'],
                'dp_pcr_id' => $epcr_insert_info,
                'dp_base_month' => $this->post['base_month'],
                'start_odometer' => $epcr_info['start_odmeter'],
                'scene_odometer' => $epcr_info['scene_odometer'],
                'from_scene_odometer' => $epcr_info['from_scene_odometer'],
                'handover_odometer' => $epcr_info['handover_odometer'],
                'hospital_odometer' => $epcr_info['hospiatl_odometer'],
                'end_odometer' => $epcr_info['end_odmeter'],
                'start_from_base' => $epcr_info['start_from_base'],
                'dp_date' => date('Y-m-d H:i:s'),
                'inc_ref_id' => $epcr_info['inc_ref_id'],
                'responce_time' => $resonse_time1,
                'responce_time_remark' => $epcr_info['responce_time_remark'],
                'responce_time_remark_other' => $epcr_info['responce_time_remark_other'],
                'inc_dispatch_time' => $inc_date[1],
                'dp_operated_by' => $this->clg->clg_ref_id,
                'inc_date' => $inc_date[0]
            );


            if ($epcr_info['reopen'] == 'y') {
                $this->pcr_model->update_epcr_details(array('epcris_deleted' => '1'), array('dp_pcr_id' => $epcr_old_id));
                $this->pcr_model->delete_driver_details( array('dp_pcr_id' => $epcr_old_id));
                $insert = $this->pcr_model->insert_deriver_pcr($data);
            } else {
                $insert = $this->pcr_model->insert_deriver_pcr($data);
            }


            $epc_args = array('inc_ref_id' => $epcr_info['inc_ref_id']);
            $pcr_count = $this->pcr_model->get_epcr_count_by_inc($epc_args);

            $args_pt = array(
                'get_count' => TRUE,
                'inc_ref_id' => $epcr_info['inc_ref_id']
            );

            $ptn_count = $this->pcr_model->get_pat_by_inc($args_pt);
            $amb_details = $this->inc_model->get_ambulance_details_API($epcr_info['amb_reg_id']);
            $amb_lat = $amb_details[0]->amb_lat;
            $amb_log = $amb_details[0]->amb_log;
            $amb_status = $amb_details[0]->amb_status;
            $thirdparty = $amb_details[0]->thirdparty;

            if ($amb_status == '2') {
                $upadate_amb_data = array('amb_rto_register_no' => $epcr_info['amb_reg_id'], 'amb_status' => 1);
                $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
            }

            $inc_details = $this->inc_model->get_inc_details_API($epcr_info['inc_ref_id']);
            $inc_lat = $inc_details[0]->inc_lat;
            $inc_long = $inc_details[0]->inc_long;
            $inc_address = $inc_details[0]->inc_address;
            if ($pcr_count == $ptn_count || $pcr_count >= $ptn_count) {

                $update_inc_args = array('inc_ref_id' => $epcr_info['inc_ref_id'], 'inc_pcr_status' => '1');
                $update_inc = $this->inc_model->update_incident($update_inc_args);

           $inc_details_api = $this->inc_model->get_gps_closing_parameters($epcr_info['inc_ref_id']);
           $pname = $inc_details_api[0]->pname;
           $inc_recive_time=$inc_details_api[0]->inc_recive_time;
           $inc_datetime=$inc_details_api[0]->inc_datetime;
           $ayushman_id = $inc_details_api[0]->ayushman_id;
           $inc_type = $inc_details_api[0]->inc_type;
           if($ayushman_id == '' || $ayushman_id == 'NA' || $ayushman_id == null){
                $Exemption = "no";
                $ayushman_id = "no";
            }else{
                $Exemption = "yes";
            }
            if($inc_details_api[0]->ct_type != ''){
                $chief_complaint = $inc_details_api[0]->ct_type;
            }else{
                $chief_complaint = $inc_details_api[0]->ntr_nature;
            }
           $pro_impression_name = get_provider_impression($epcr_info['provider_impressions']);

           $hos_details = get_hospital_by_id($res_hos);
           
           $hos_name = $hos_details[0]->hp_name;
           $hp_type = $hos_details[0]->hp_type;
           $hos_type_nm = get_hosp_type_by_id($hp_type);
           $inc_details_api = $this->inc_model->get_gps_closing_parameters($epcr_info['inc_ref_id']);
           $pname = $inc_details_api[0]->pname;
           $pname = $inc_details_api[0]->pname;
            //if($epcr_info['amb_reg_id'] == "TT-00-MP-0000"){
                     $veh = implode('',explode('-',$epcr_info['amb_reg_id']));
           // }
            if($epcr_info['epcr_call_type']=='2' || $epcr_info['epcr_call_type']=='3')
            {
                if($epcr_info['at_hospital'] == '' || $epcr_info['at_hospital'] == '0000-00-00 00:00:00' ){
                    $DropDateTime = date('Y-m-d H:i', strtotime($epcr_info['at_hospital']));
                }else{
                    $DropDateTime = 'NA';
                }
            }
            if($epcr_info['epcr_call_type']=='1' || $inc_type=='DROP_BACK')
            {
                if($epcr_info['back_to_base'] == '' || $epcr_info['back_to_base'] == '0000-00-00 00:00:00' ){
                    $DropDateTime = date('Y-m-d H:i', strtotime($epcr_info['back_to_base']));
                }else{
                    $DropDateTime = 'NA';
                }
                $hos_name ='NA';
                $hos_type_nm='NA';
            }if($epcr_info['epcr_call_type']=='3')
            {
                $hos_name ='NA';
                $hos_type_nm='NA';
            }
            if($hos_name == 'Other' || $hos_name == '')
            {
                $hos_name =$epcr_info['other_receiving_host'];
                $hos_type_nm ='NA';
            }
           
                $args = array(
                    'ProjectType'=> '108',
                    'EmType'=>$pname, // ERO CAll type
                    'CallDateTime'=>date('Y-m-d H:i', strtotime($inc_recive_time)),
                    'JobNo' => $epcr_info['inc_ref_id'],
                    'AmbulanceNo' => $veh,
                    'DispatchedDateTime' => date('Y-m-d H:i', strtotime($inc_datetime)),
                    'ReachedtosceneDateTime' => date('Y-m-d H:i', strtotime($epcr_info['at_scene'])),
                    'DropHospital' => $hos_name,
                    'HospitalType' => $hos_type_nm,
                    'BacktobaseDatetime' => date('Y-m-d H:i', strtotime($epcr_info['back_to_base'])),
                    'TripDistance' => $total_km,
                    'stateCode'=>'MP',
                    'ClosingStatus'=>'Closed',
                    'DropDateTime'=>$DropDateTime,
                    'EmergencyChiefComplaint'=>$chief_complaint, // chief complaint
                    'AyushmanCard'=>$ayushman_id,
                    'Exemption' => $Exemption
                );
                //var_dump($args);die();
                $send_API = send_API_close($args);
            } else {
                if ($epcr_info['inc_ref_id'] != '' || $epcr_info['inc_ref_id'] != NULL) {
                    $update_inc_args = array('inc_ref_id' => $epcr_info['inc_ref_id'], 'inc_pcr_status' => '0');
                    $update_inc = $this->inc_model->update_incident($update_inc_args);
                }
            }

            $update_pat_args = array('ptn_id' => $epcr_info['pat_id']);
            $pat_data = array('ptn_pcr_status' => '1');
            $update_pat = $this->pet_model->update_petinfo($update_pat_args, $pat_data);

            $unique_id = get_uniqid($this->session->userdata('user_default_key'));
            $amb_record_data = array(
                'id' => $unique_id,
                'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                'inc_ref_id'          => $epcr_info['inc_ref_id'],
                'start_odmeter'       => $epcr_info['start_odmeter'],
                'scene_odometer'      => $epcr_info['scene_odometer'],
                'from_scene_odometer' => $epcr_info['from_scene_odometer'],
                'handover_odometer' => $epcr_info['handover_odometer'],
                'hospital_odometer'   => $epcr_info['hospiatl_odometer'],
                'end_odmeter'         => $epcr_info['end_odmeter'],
                'total_km'            => $total_km,
                'timestamp'           => date('Y-m-d H:i:s'),
                'odometer_type'       => 'closure'
            );

            if (!empty($epcr_info['odometer_remark'])) {
                $amb_record_data['remark'] = $epcr_info['odometer_remark'];
            }

            if (!empty($epcr_info['remark_other'])) {
                $amb_record_data['other_remark'] = $epcr_info['remark_other'];
            }
            if (!empty($epcr_info['end_odometer_remark'])) {
                $amb_record_data['end_odometer_remark'] = $epcr_info['end_odometer_remark'];
            }

            if (!empty($epcr_info['endodometer_remark_other'])) {
                $amb_record_data['endodometer_remark_other'] = $epcr_info['endodometer_remark_other'];
            }

            $odo_args = array('inc_ref_id' => $epcr_info['inc_ref_id']);
            $get_odometer = $this->amb_model->get_amb_odometer_by_inc($odo_args);

            if (empty($get_odometer)) {

                $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
            } else {
                if ($epcr_info['reopen'] == 'y' || $epcr_info['reopen_case'] == 'y') {
                    //$epcr_old_id
                    if ($epcr_info['inc_ref_id'] != '') {
                        $this->amb_model->update_timestamp_odometer_amb(array('flag' => '2', 'odometer_type' => 'old_closure'), array('insident_no' => $epcr_info['inc_ref_id']));
                    }
                    $amb_record_data['flag'] = $get_odometer[0]->flag;
                    $insert_time = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
                } else {
                    $insert = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
                }
            }
            // inc_pcr
            // inc_pcr_status
            $args = array(
                //'ptn_id' => $epcr_info['pat_id'],
                'ptn_state' => $epcr_info['tc_dtl_state'],
                'ptn_district' => $epcr_info['tc_dtl_district'],
                'ptn_city' => $epcr_info['tc_dtl_ms_city'],
                'ptn_address' => $epcr_info['locality'],
            );


            $this->pet_model->update_petinfo(array('ptn_id' => $epcr_info['pat_id']), $args);


            $pcr_data[$epcr_info['inc_ref_id']] = array(
                'patient_id' => $epcr_info['pat_id'],
                'inc_ref_id' => $epcr_info['inc_ref_id'],
                'rto_no' => $epcr_info['amb_reg_id'],
                'pcr_id' => $epcr_insert_info
            );

            $this->session->set_userdata('pcr_details', $pcr_data);

            $data_pcr = array(
                'inc_ref_id' => $epcr_info['inc_ref_id'],
                'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                'patient_id' => $epcr_info['pat_id'],
                'base_month' => $this->post['base_month'],
                'pcr_id' => $epcr_insert_info,
                'date' => date('Y-m-d H:i:s')
            );
            //
            //         if($epcr_info['reopen'] == 'y'){
            //            //$epcr_old_id
            //             $this->pcr_model->update_pcr_details(array('pcr_isdeleted ' => '1'), array('pcr_id'=>$epcr_old_id));
            //            $insert = $this->pcr_model->insert_deriver_pcr($data);
            //           
            //        }else{
            $pcr_id = $this->pcr_model->insert_pcr($data_pcr);
            // }


            if ($epcr_info['reopen'] == 'y') {
                $deletet_amb_stock =  array(
                    'pcr_id' => $epcr_old_id,
                    'sub_type' => 'pcr',
                    'as_isdeleted' => '1'
                );
                $this->ind_model->deletet_amb_stock($deletet_amb_stock);
            } else {

                $deletet_amb_stock = array(
                    'pcr_id' => $epcr_insert_info,
                    'sub_type' => 'pcr'
                );
                $this->ind_model->deletet_amb_stock($deletet_amb_stock);
            }

            if (isset($epcr_info['obious_death']['ques'])) {
                foreach ($epcr_info['obious_death']['ques'] as $key => $ques) {

                    $ems_summary = array(
                        'sum_base_month' => $this->post['base_month'],
                        'sum_epcr_id' => $epcr_insert_info,
                        'inc_ref_id' => $epcr_info['inc_ref_id'],
                        'ptn_id' => $epcr_info['pat_id'],
                        'sum_que_id' => $key,
                        'sum_que_ans' => $ques
                    );

                    $this->pcr_model->insert_obvious_death_ques_summary($ems_summary);
                }
            }


            if (isset($epcr_info['injury'])) {
                foreach ($epcr_info['injury'] as $injury) {

                    if ($injury['id'] != '' && $injury['type'] != '') {

                        $injury_args = array(
                            'as_item_id' => $injury['id'],
                            'incidentId' => $epcr_info['inc_ref_id'],
                            'as_item_type' => $injury['type'],
                            'as_stk_in_out' => 'out',
                            'as_item_qty' => 1,
                            'as_sub_id' => $epcr_insert_info,
                            'as_sub_type' => 'pcr',
                            'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                            'as_date' => $this->today,
                            'as_base_month' => $this->post['base_month'],
                        );


                        $this->ind_model->insert_amb_stock($injury_args);
                    }
                }
            }
            if (isset($epcr_info['intervention'])) {
                foreach ($epcr_info['intervention'] as $inter) {

                    if ($inter['id'] != '' && $inter['type'] != '') {

                        $inter_args = array(
                            'as_item_id' => $inter['id'],
                            'incidentId' => $epcr_info['inc_ref_id'],
                            'as_item_type' => $inter['type'],
                            'as_stk_in_out' => 'out',
                            'as_item_qty' => 1,
                            'as_sub_id' => $epcr_insert_info,
                            'as_sub_type' => 'pcr',
                            'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                            'as_date' => $this->today,
                            'as_base_month' => $this->post['base_month'],
                        );


                        $this->ind_model->insert_amb_stock($inter_args);
                    }
                }
            }

            if (isset($epcr_info['med'])) {
                foreach ($epcr_info['med'] as $med) {

                    if ($med['value'] != '' && $med['type'] != '') {

                        $unit_args = array(
                            'as_item_id' => $med['id'],
                            'incidentId' => $epcr_info['inc_ref_id'],
                            'as_item_type' => $med['type'],
                            'as_stk_in_out' => 'out',
                            'as_item_qty' => $med['value'],
                            'as_sub_id' => $epcr_insert_info,
                            'as_sub_type' => 'pcr',
                            'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                            'as_date' => $this->today,
                            'as_base_month' => $this->post['base_month'],
                        );


                        $this->ind_model->insert_amb_stock($unit_args);
                    }
                }
            }
            if (isset($epcr_info['unit'])) {
                foreach ($epcr_info['unit'] as $unit) {

                    if ($unit['value'] != '' && $unit['type'] != '') {

                        $unit_args = array(
                            'as_item_id' => $unit['id'],
                            'incidentId' => $epcr_info['inc_ref_id'],
                            'as_item_type' => $unit['type'],
                            'as_stk_in_out' => 'out',
                            'as_item_qty' => $unit['value'],
                            'as_sub_id' => $epcr_insert_info,
                            'as_sub_type' => 'pcr',
                            'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                            'as_date' => $this->today,
                            'as_base_month' => $this->post['base_month'],
                        );


                        $this->ind_model->insert_amb_stock($unit_args);
                    }
                }
            }
            if (isset($epcr_info['non_unit'])) {
                foreach ($epcr_info['non_unit'] as $unit) {
                    if ($unit['id'] != '' && $unit['type'] != '') {
                        $unit_args = array(
                            'as_item_id' => $unit['id'],
                            'incidentId' => $epcr_info['inc_ref_id'],
                            'as_item_type' => $unit['type'],
                            'as_stk_in_out' => 'out',
                            'as_item_qty' => 1,
                            'as_sub_id' => $epcr_insert_info,
                            'as_sub_type' => 'pcr',
                            'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                            'as_date' => $this->today,
                            'as_base_month' => $this->post['base_month'],
                        );

                        $this->ind_model->insert_amb_stock($unit_args);
                    }
                }
            }
            // var_dump($epcr_info['provider_impressions']);die();
            $provide_imp = array('21', '41', '42', '43', '45');
            if (in_array($epcr_info['provider_impressions'], $provide_imp)) {
                // $is_deleted='1';
                // var_dump(  "hi" );die();
                $epcr_insert_info1 = array(
                    'inc_ref_id' => $epcr_info['inc_ref_id']
                );

                // $epcr_insert_info = $this->pcr_model->update_is_deleted($epcr_insert_info1);
                $update_inc_args = array('inc_ref_id' => $epcr_info['inc_ref_id'], 'inc_pcr_status' => '1', 'inc_feedback_status' => '2');
                // $update_inc = $this->inc_model->update_incident($update_inc_args);

            }
            // else{
            //     $is_deleted='0';
            // }
            // var_dump( $update_inc_args );die();


            $this->session->set_userdata('pcr_steps', '1');

            //////////////////////////////////////////////////////////

            $flforms = pcr_steps($epcr_insert_info, "PCR");

            //////////////////////////////////////////////////////////
        }
    //     $caller_mob = $this->pcr_model->get_caller_details($epc_args);
    //     // print_r($caller_mob[0]->clr_mobile);die;
    //     //sms
    //     if($epcr_info['epcr_call_type']!='1')
    //     {
    //     $txtMsg1 = '';
    //     $txtMsg1.= "Dear ".$epcr_info['ptn_fname']." ".$epcr_info['ptn_lname'].", \n";
    //     $txtMsg1.= "For feedback click on \n";
    //     $txtMsg1.= "http://irts.jaesmp.com/JAEms/feedback/pt_feedback/".$epcr_info['inc_ref_id'] ."/".$inc_details_api[0]->inc_type.",\n" ;
    //     $txtMsg1.= "Link: ".$amb_dir_url."\n" ;
    //     $txtMsg1 .= "Please click on the following link for downloading the 108 Sanjeevani app on your mobile
    //     Android User - https://tinyurl.com/2p87kfu6 and iOS User-
    //     https://tinyurl.com/3pup8pp4";
    //     $txtMsg1.= "JAES" ;
    //     // var_dump($txtMsg1);die();
    //     $sms_to = $caller_mob[0]->clr_mobile;
    //     // var_dump($sms_to);die;
    //     $args = array(
    //         'inc_id' => $epcr_info['inc_ref_id'],
    //         'msg' => $txtMsg1,
    //         'mob_no' => $sms_to,
    //         'sms_user'=>'feedback_patient',
    //     );
    //     // var_dump($args);die;
    //    $sms_data = sms_send($args);
    // }
        if ($epcr_insert_info) {

            if ($this->session->userdata['current_user']->clg_group == "UG-ShiftManager") {

                $this->output->message = "<div class='success'> Added successfully <a href='" . $this->base_url . "supervisor' class='dark_blue'>Back to Dashboard</a></div>";
            } else {

                $this->output->message = "<div class='success'> Added successfully <a href='" . $this->base_url . "job_closer' class='dark_blue'>Back to Dashboard</a></div>";
            }
        } else {

            $this->output->message = "<div class='error' style='color: red;font-weight: bold;font-size: 150%;'> ERROR : Please Fill All Details..Try Again </div>";
        }
    }
    function save_job_closure_onscene()
    {
        $epcr_info = $this->input->post();
        $odo_args = array('inc_ref_id' => $epcr_info['inc_ref_id']);
        $get_odometer = $this->amb_model->get_amb_odometer_by_inc($odo_args);




        $inter_info = $this->input->post('inter');
        $pt_con_handover = $this->input->post('pt_con_handover');
        $pt_con_ongoing = $this->input->post('pt_con_ongoing');
        $baseline_con = $this->input->post('baseline_con');

        $kid_details = $this->input->post('kid');

        $obious_death_ques = "";
        if (isset($epcr_info['obious_death']['ques'])) {
            $obious_death_ques = serialize($epcr_info['obious_death']['ques']);
        }

        $odo_args = array('inc_ref_id' => $epcr_info['inc_ref_id']);
        $get_odometer = $this->amb_model->get_amb_odometer_by_inc($odo_args);
        $total_km = (int)$epcr_info['end_odmeter'] - (int)$epcr_info['start_odmeter'];


        if ($this->clg->clg_group == 'UG-DCO-102') {
            $system_type = '102';
        }
        if ($this->clg->clg_group == 'UG-BIKE-DCO') {
            $system_type = 'BIKE';
        } else {
            $system_type = '108';
        }

        $epc_args = array('inc_ref_id' => $epcr_info['inc_ref_id']);
        $pcr_count = $this->pcr_model->get_epcr_count_by_inc($epc_args);

        $args_pt = array(
            'get_count' => TRUE,
            'inc_ref_id' => $epcr_info['inc_ref_id']
        );

        $ptn_count = $this->pcr_model->get_pat_by_inc($args_pt);
        if ($ptn_count > $pcr_count) {
            $this->output->message = "<div class='error'><span style='color:#f00'>Please Save all Patient Details</span></div>";
            return false;
        }

        $amb_details = $this->inc_model->get_ambulance_details_API($epcr_info['amb_reg_id']);
        $amb_lat = $amb_details[0]->amb_lat;
        $amb_log = $amb_details[0]->amb_log;
        $amb_status = $amb_details[0]->amb_status;
        $thirdparty = $amb_details[0]->thirdparty;
        if ($epcr_info['receiving_host'] == '') {
            $res_hos = $inter_info['new_facility'];
        } else {
            $res_hos = $epcr_info['receiving_host'];
        }

        if ($pt_con_ongoing['Past_medical_history']) {
            $past_medical = array();
            foreach ($pt_con_ongoing['Past_medical_history'] as $past_med_his) {

                $past_medical[] = array('id' => $past_med_his);
            }


            $past_medical = json_encode($past_medical);
        }
        if ($baseline_con['osat'] != '') {
            $ini_oxy_sat_get_nf = 'yes';
        } else {
            $ini_oxy_sat_get_nf = 'no';
        }
        if ($pt_con_handover['osat'] != '') {
            $hc_oxy_sat_get_nf = 'yes';
        } else {
            $hc_oxy_sat_get_nf = 'no';
        }
        if ($baseline_con['pulse'] != '') {
            $ini_cir_pulse_p = 'yes';
        } else {
            $ini_cir_pulse_p = 'no';
        }
        if ($pt_con_handover['pulse'] != '') {
            $hc_cir_pulse_p = 'yes';
        } else {
            $hc_cir_pulse_p = 'no';
        }
        $epcr_insert_info = array(
            'date' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'amb_reg_id' => $epcr_info['amb_reg_id'],
            'inc_ref_id' => $epcr_info['inc_ref_id'],
            'ercp_advice' => $epcr_info['ercp_advice'],
            'rec_hospital_name' => $res_hos,
            'base_month' => $this->post['base_month'],
            'state_id' => $epcr_info['tc_dtl_state'],
            'district_id' => $epcr_info['tc_dtl_districts'],
            'city_id' => $epcr_info['tc_dtl_ms_city'],
            'start_odometer' => $epcr_info['start_odmeter'],
            'scene_odometer' => $epcr_info['scene_odometer'],
            'from_scene_odometer' => $epcr_info['from_scene_odometer'],
            'hospital_odometer' => $epcr_info['hospiatl_odometer'],
            'handover_odometer' => $epcr_info['handover_odometer'],
            'end_odometer' => $epcr_info['end_odmeter'],
            'inc_area_type' => $epcr_info['inc_area_type'],
            'total_km' => $total_km,
            'locality' => $epcr_info['locality'],
            'base_location_name' => $epcr_info['base_location'],
            'base_location_id' => $epcr_info['base_location_id'],
            'wrd_location' => $epcr_info['wrd_location'],
            'wrd_location_id' => $epcr_info['wrd_location_id'],
            'emt_name' => $epcr_info['emt_name'],
            'emso_id' => $epcr_info['emt_id'],
            'pilot_name' => $epcr_info['pilot_name'],
            'emt_id_other' => $epcr_info['emt_id_other'],
            'pilot_name' => $epcr_info['pilot_name'],
            'pilot_id_other' => $epcr_info['pilot_id_other'],
            'pilot_id' => $epcr_info['pilot_id'],
            'remark' => $epcr_info['epcr_remark'],
            'valid_remark' => $epcr_info['valid_remark'],
            'inc_datetime' => $epcr_info['inc_datetime'],
            'obious_death_ques' => $obious_death_ques,
            'operate_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'system_type' => $system_type,
            'third_party' => $thirdparty,
            'epcris_deleted' => '0',

            'loc' => $baseline_con['loc'],


        );

        if (!empty($epcr_info['epcr_call_type'])) {
            $epcr_insert_info['epcr_call_type'] = $epcr_info['epcr_call_type'];
        }
        if (!empty($pt_con_ongoing['other_chief_comp'])) {
            $epcr_insert_info['other_chief_comp'] = $pt_con_ongoing['other_chief_comp'];
        }


        if (!empty($epcr_info['pcr_district'])) {
            $epcr_insert_info['hospital_district'] = $epcr_info['pcr_district'];
        }


        if (!empty($epcr_info['other_provider'])) {
            $epcr_insert_info['other_provider_img'] = $epcr_info['other_provider'];
        }
        if (!empty($epcr_info['provider_casetype_other'])) {
            $epcr_insert_info['provider_casetype_other'] = $epcr_info['provider_casetype_other'];
        }


        if (!empty($epcr_info['other_receiving_host'])) {
            $epcr_insert_info['other_receiving_host'] = $epcr_info['other_receiving_host'];
        }
        if (!empty($epcr_info['other_units'])) {
            $epcr_insert_info['other_units'] = $epcr_info['other_units'];
        }

        if (!empty($epcr_info['other_non_units'])) {
            $epcr_insert_info['other_non_units'] = $epcr_info['other_non_units'];
        }

        if ($epcr_info['ercp_advice_Taken'] != '') {
            $epcr_insert_info['ercp_advice_Taken'] = $epcr_info['ercp_advice_Taken'];
        }
        if (!empty($epcr_info['end_odometer_remark'])) {
            $epcr_insert_info['end_odometer_remark'] = $epcr_info['end_odometer_remark'];
        }

        if (!empty($epcr_info['endodometer_remark_other'])) {
            $epcr_insert_info['endodometer_remark_other'] = $epcr_info['endodometer_remark_other'];
        }
        if (!empty($epcr_info['forwording_feedback'])) {
            $epcr_insert_info['forwording_feedback'] = $epcr_info['forwording_feedback'];
        }





        if ($epcr_info['reopen'] == 'y') {

            $args_old = array('inc_ref_id' => $epcr_info['inc_ref_id'], 'ptn_id' => $epcr_info['pat_id']);
            $epcr_old_info = $this->pcr_model->get_epcr($args_old);
            $epcr_old_id = $epcr_old_info[0]->id;
            $this->pcr_model->update_epcr_details(array('epcris_deleted' => '1'), $args_old);
            $this->pcr_model->deleted_epcr_details($args_old);
            //$this->pcr_model->update_epcr_details(array('epcris_deleted' => '1'), $args_old);
            // $epcr_insert_info['added_date']=$epcr_old_info[0]->added_date;

            if ($epcr_old_info[0]->added_date == '') {
                $epcr_insert_info['added_date'] = date('Y-m-d H:i:s');
            } else {
                $epcr_insert_info['added_date'] = $epcr_old_info[0]->added_date;
            }
            $epcr_insert_info['operate_by'] = $epcr_old_info[0]->operate_by;
            $epcr_insert_info['is_validate'] = '1';
            $epcr_insert_info['validate_by'] = $this->clg->clg_ref_id;
            $epcr_insert_info['validate_date'] = date('Y-m-d H:i:s');

            $update_pat_args = array('ptn_id' => $epcr_info['pat_id']);
            $pat_data = array('ptn_pcr_validate_status' => '1');
            $update_pat = $this->pet_model->update_petinfo($update_pat_args, $pat_data);


            $epcr_insert_info = $this->pcr_model->insert_epcr($epcr_insert_info);
            
        } else {
            //$epcr_insert_info['added_date']=date('Y-m-d H:i:s');
            //$epcr_insert_info['operate_by']=$this->clg->clg_ref_id;
            $epcr_insert_info = $this->pcr_model->update_epcr($epcr_insert_info, array('inc_ref_id' => $epcr_info['inc_ref_id']));
            // var_dump($epcr_insert_info);
            // die();
        }
        if ($epcr_insert_info) {
            $inc_amb = array(
                'inc_ref_id' => $epcr_info['inc_ref_id'],
                'amb_pilot_id' => $epcr_info['pilot_id'],
                'amb_emt_id' => $epcr_info['emt_id']
            );

            $this->inc_model->update_inc_amb($inc_amb);
            //        if(!empty($kid_details))
            //        {
            //            $kid_insert_info = array(
            //                'added_date' => date('Y-m-d H:i:s'),
            //                'inc_ref_id' => $epcr_info['inc_ref_id'],
            //                'ptn_id' => $epcr_info['pat_id'],
            //                'gender' => $kid_details['gender'],
            //                'birth_datetime' => $kid_details['birth_datetime'],
            //                'birth_remark' => $kid_details['birth_remark'],
            //                'apgar_score' => $kid_details['apgar_score'],
            //                'status' => '1'
            //            );
            //            $kid_insert_info = $this->pcr_model->insert_kid_details($kid_insert_info);
            //        }
            // die();
            $closer_operator = array(
                'sub_id' => $epcr_info['inc_ref_id'],
                'operator_id' => $this->clg->clg_ref_id,
                'operator_type' => $this->clg->clg_group,
                'sub_status' => 'ATD',
                'sub_type' => 'CLOSER',
                'base_month' => $this->post['base_month']
            );



            $closer_operator = $this->common_model->assign_operator($closer_operator);

            $inc_date = explode(' ', $epcr_info['inc_datetime']);

            $resonse_time = "";
            if ($epcr_info['at_scene'] != '') {
                $d_start = new DateTime($epcr_info['inc_datetime']);
                $d_end = new DateTime($epcr_info['at_scene']);
                $resonse_time = $d_start->diff($d_end);
            }
            //die();
            //  $resonse_time = date_diff( $epcr_info['at_scene'] , $epcr_info['inc_datetime']);

            $resonse_time = $resonse_time->h . ':' . $resonse_time->i . ':' . $resonse_time->s;
            $resonse_time1 = date('H:i:s', strtotime($resonse_time));


            $data = array(
                'dp_cl_from_desk' => $epcr_info['call_rec_time'],
                'dp_started_base_loc' => $epcr_info['start_from_base'],
                'dp_reach_on_scene' => $epcr_info['from_scene'],
                'dp_on_scene' => $epcr_info['at_scene'],
                'dp_hosp_time' => $epcr_info['at_hospital'],
                'dp_hand_time' => $epcr_info['hand_over'],
                'dp_back_to_loc' => $epcr_info['back_to_base'],
                'dp_pcr_id' => $epcr_insert_info,
                'dp_base_month' => $this->post['base_month'],
                'start_odometer' => $epcr_info['start_odmeter'],
                'scene_odometer' => $epcr_info['scene_odometer'], 
                'from_scene_odometer' => $epcr_info['from_scene_odometer'],
                'handover_odometer' => $epcr_info['handover_odometer'],
                'hospital_odometer' => $epcr_info['hospiatl_odometer'],
                'end_odometer' => $epcr_info['end_odmeter'],
                'start_from_base' => $epcr_info['start_from_base'],
                'dp_date' => date('Y-m-d H:i:s'),
                'inc_ref_id' => $epcr_info['inc_ref_id'],
                'responce_time' => $resonse_time1,
                'responce_time_remark' => $epcr_info['responce_time_remark'],
                'responce_time_remark_other' => $epcr_info['responce_time_remark_other'],
                'inc_dispatch_time' => $inc_date[1],
                'dp_operated_by' => $this->clg->clg_ref_id,
                'inc_date' => $inc_date[0]
            );

            $inc_argss = array(
                'inc_ref_id' => $epcr_info['inc_ref_id'],
            );
            $epcr_inc_details = $this->pcr_model->get_epcr_inc_details($inc_argss);

            if ($epcr_info['reopen'] == 'y') {
                //$epcr_old_id
                $this->pcr_model->update_driver_details(array('epcris_deleted' => '1'), array('dp_pcr_id' => $epcr_old_id));
                $this->pcr_model->delete_driver_details(array('dp_pcr_id' => $epcr_old_id));
                $insert = $this->pcr_model->insert_deriver_pcr($data);
            } else {

                foreach ($epcr_inc_details as $epcr_inc) {
                    $data['dp_pcr_id'] = $epcr_inc->id;
                    $insert = $this->pcr_model->insert_deriver_pcr($data);
                }
            }



            $epc_args = array('inc_ref_id' => $epcr_info['inc_ref_id']);
            $pcr_count = $this->pcr_model->get_epcr_count_by_inc($epc_args);

            $args_pt = array(
                'get_count' => TRUE,
                'inc_ref_id' => $epcr_info['inc_ref_id']
            );

            $ptn_count = $this->pcr_model->get_pat_by_inc($args_pt);
            $amb_details = $this->inc_model->get_ambulance_details_API($epcr_info['amb_reg_id']);
            $amb_lat = $amb_details[0]->amb_lat;
            $amb_log = $amb_details[0]->amb_log;
            $amb_status = $amb_details[0]->amb_status;
            $thirdparty = $amb_details[0]->thirdparty;

            if ($amb_status == '2') {
                $upadate_amb_data = array('amb_rto_register_no' => $epcr_info['amb_reg_id'], 'amb_status' => 1);
                $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
            }

            $inc_details = $this->inc_model->get_inc_details_API($epcr_info['inc_ref_id']);
            $inc_lat = $inc_details[0]->inc_lat;
            $inc_long = $inc_details[0]->inc_long;
            $inc_address = $inc_details[0]->inc_address;
            if ($pcr_count == $ptn_count || $pcr_count >= $ptn_count) {

                $update_inc_args = array('inc_ref_id' => $epcr_info['inc_ref_id'], 'inc_pcr_status' => '1');
                $update_inc = $this->inc_model->update_incident($update_inc_args);

                /*
            $inc_args = array( 'inc_ref_id' => trim($this->post['inc_ref_id']),'is_pda_inc'=>'yes');
            $pda_inc_details = $this->inc_model->get_total_by_call_type_inc($inc_args)[0];

            if(!empty($pda_inc_details)){
                $json_data = array('incidentID'=>$pda_inc_details->inc_ref_id,
                                    'CADIncidentID '=>$pda_inc_details->CADIncidentID,
                                    'eventstatus'=> 'closed');
                
                $json_data =  '{
                "data": {
                "incidentID": "'.$pda_inc_details->inc_ref_id.'",
                "CADIncidentID ": "'.$pda_inc_details->CADIncidentID.'",
                "eventstatus": "closed"
                }
                }';

               // $json_data= json_encode($json_data);

                //$api_pda = pda_case_close_api($json_data);

           } */
                $args = array(
                    'inc_id' => $epcr_info['inc_ref_id'],
                    'caseStatus' => 'false',
                    'vehicleName' => $epcr_info['amb_reg_id'],
                    'caseOn' => $epcr_info['inc_datetime'],
                    'vLat' => $amb_lat,
                    'vLong' => $amb_log,
                    'pLat' => $inc_lat,
                    'pLong' => $inc_long,
                    'pationAddress' => $inc_address,
                );
                //var_dump($args);die();
                $send_API = send_API_close($args);
            } else {
                if ($epcr_info['inc_ref_id'] != '' || $epcr_info['inc_ref_id'] != NULL) {
                    $update_inc_args = array('inc_ref_id' => $epcr_info['inc_ref_id'], 'inc_pcr_status' => '0');
                    $update_inc = $this->inc_model->update_incident($update_inc_args);
                }
            }

            foreach ($epcr_inc_details as $epcr_inc) {
                $ptn_id = $epcr_inc->ptn_id;
                $update_pat_args = array('ptn_id' => $ptn_id);
                $pat_data = array('ptn_pcr_status' => '1');
                $update_pat = $this->pet_model->update_petinfo($update_pat_args, $pat_data);
            }

            $unique_id = get_uniqid($this->session->userdata('user_default_key'));
            $amb_record_data = array(
                'id' => $unique_id,
                'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                'inc_ref_id'          => $epcr_info['inc_ref_id'],
                'start_odmeter'       => $epcr_info['start_odmeter'],
                'scene_odometer'      => $epcr_info['scene_odometer'],
                
                'from_scene_odometer' => $epcr_info['from_scene_odometer'],
               
                'handover_odometer' => $epcr_info['handover_odometer'],
                'hospital_odometer'   => $epcr_info['hospiatl_odometer'],
                'end_odmeter'         => $epcr_info['end_odmeter'],
                'total_km'            => $total_km,
                'timestamp'           => date('Y-m-d H:i:s'),
                'odometer_type'       => 'closure'
            );

            if (!empty($epcr_info['odometer_remark'])) {
                $amb_record_data['remark'] = $epcr_info['odometer_remark'];
            }

            if (!empty($epcr_info['remark_other'])) {
                $amb_record_data['other_remark'] = $epcr_info['remark_other'];
            }
            if (!empty($epcr_info['end_odometer_remark'])) {
                $amb_record_data['end_odometer_remark'] = $epcr_info['end_odometer_remark'];
            }

            if (!empty($epcr_info['endodometer_remark_other'])) {
                $amb_record_data['endodometer_remark_other'] = $epcr_info['endodometer_remark_other'];
            }

            $odo_args = array('inc_ref_id' => $epcr_info['inc_ref_id']);
            $get_odometer = $this->amb_model->get_amb_odometer_by_inc($odo_args);



            if (empty($get_odometer)) {

                $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
            } else {
                if ($epcr_info['reopen'] == 'y' || $epcr_info['reopen_case'] == 'y') {
                    //$epcr_old_id

                    $this->amb_model->update_timestamp_odometer_amb(array('flag ' => '2', 'odometer_type' => 'old_closure'), array('insident_no' => $epcr_info['inc_ref_id']));

                    $amb_record_data['flag'] = $get_odometer[0]->flag;
                    $insert_time = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
                } else {
                    $insert = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
                }
            }
            // inc_pcr
            // inc_pcr_status
            $args = array(
                //'ptn_id' => $epcr_info['pat_id'],
                'ptn_state' => $epcr_info['tc_dtl_state'],
                'ptn_district' => $epcr_info['tc_dtl_district'],
                'ptn_city' => $epcr_info['tc_dtl_ms_city'],
                'ptn_address' => $epcr_info['locality'],
            );


            $this->pet_model->update_petinfo(array('ptn_id' => $epcr_info['pat_id']), $args);


            $pcr_data[$epcr_info['inc_ref_id']] = array(
                'patient_id' => $epcr_info['pat_id'],
                'inc_ref_id' => $epcr_info['inc_ref_id'],
                'rto_no' => $epcr_info['amb_reg_id'],
                'pcr_id' => $epcr_insert_info
            );

            $this->session->set_userdata('pcr_details', $pcr_data);

            $data_pcr = array(
                'inc_ref_id' => $epcr_info['inc_ref_id'],
                'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                'patient_id' => $epcr_info['pat_id'],
                'base_month' => $this->post['base_month'],
                'pcr_id' => $epcr_insert_info,
                'date' => date('Y-m-d H:i:s')
            );
            //
            //         if($epcr_info['reopen'] == 'y'){
            //            //$epcr_old_id
            //             $this->pcr_model->update_pcr_details(array('pcr_isdeleted ' => '1'), array('pcr_id'=>$epcr_old_id));
            //            $insert = $this->pcr_model->insert_deriver_pcr($data);
            //           
            //        }else{
            $pcr_id = $this->pcr_model->insert_pcr($data_pcr);
            // }


            if ($epcr_info['reopen'] == 'y') {
                $deletet_amb_stock = array(
                    'pcr_id' => $epcr_old_id,
                    'sub_type' => 'pcr',
                    'as_isdeleted' => '1'
                );
                $this->ind_model->deletet_amb_stock($deletet_amb_stock);
            } else {

                $deletet_amb_stock = array(
                    'pcr_id' => $epcr_insert_info,
                    'sub_type' => 'pcr'
                );
                $this->ind_model->deletet_amb_stock($deletet_amb_stock);
            }

            if (isset($epcr_info['obious_death']['ques'])) {
                foreach ($epcr_info['obious_death']['ques'] as $key => $ques) {

                    $ems_summary = array(
                        'sum_base_month' => $this->post['base_month'],
                        'sum_epcr_id' => $epcr_insert_info,
                        'inc_ref_id' => $epcr_info['inc_ref_id'],
                        'ptn_id' => $epcr_info['pat_id'],
                        'sum_que_id' => $key,
                        'sum_que_ans' => $ques
                    );

                    $this->pcr_model->insert_obvious_death_ques_summary($ems_summary);
                }
            }


            if (isset($epcr_info['injury'])) {
                foreach ($epcr_info['injury'] as $injury) {

                    if ($injury['id'] != '' && $injury['type'] != '') {

                        $injury_args = array(
                            'as_item_id' => $injury['id'],
                            'incidentId' => $epcr_info['inc_ref_id'],
                            'as_item_type' => $injury['type'],
                            'as_stk_in_out' => 'out',
                            'as_item_qty' => 1,
                            'as_sub_id' => $epcr_insert_info,
                            'as_sub_type' => 'pcr',
                            'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                            'as_date' => $this->today,
                            'as_base_month' => $this->post['base_month'],
                        );


                        $this->ind_model->insert_amb_stock($injury_args);
                    }
                }
            }
            if (isset($epcr_info['intervention'])) {
                foreach ($epcr_info['intervention'] as $inter) {

                    if ($inter['id'] != '' && $inter['type'] != '') {

                        $inter_args = array(
                            'as_item_id' => $inter['id'],
                            'incidentId' => $epcr_info['inc_ref_id'],
                            'as_item_type' => $inter['type'],
                            'as_stk_in_out' => 'out',
                            'as_item_qty' => 1,
                            'as_sub_id' => $epcr_insert_info,
                            'as_sub_type' => 'pcr',
                            'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                            'as_date' => $this->today,
                            'as_base_month' => $this->post['base_month'],
                        );


                        $this->ind_model->insert_amb_stock($inter_args);
                    }
                }
            }

            if (isset($epcr_info['med'])) {
                foreach ($epcr_info['med'] as $med) {

                    if ($med['value'] != '' && $med['type'] != '') {

                        $unit_args = array(
                            'as_item_id' => $med['id'],
                            'incidentId' => $epcr_info['inc_ref_id'],
                            'as_item_type' => $med['type'],
                            'as_stk_in_out' => 'out',
                            'as_item_qty' => $med['value'],
                            'as_sub_id' => $epcr_insert_info,
                            'as_sub_type' => 'pcr',
                            'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                            'as_date' => $this->today,
                            'as_base_month' => $this->post['base_month'],
                        );


                        $this->ind_model->insert_amb_stock($unit_args);
                    }
                }
            }
            if (isset($epcr_info['unit'])) {
                foreach ($epcr_info['unit'] as $unit) {

                    if ($unit['value'] != '' && $unit['type'] != '') {

                        $unit_args = array(
                            'as_item_id' => $unit['id'],
                            'incidentId' => $epcr_info['inc_ref_id'],
                            'as_item_type' => $unit['type'],
                            'as_stk_in_out' => 'out',
                            'as_item_qty' => $unit['value'],
                            'as_sub_id' => $epcr_insert_info,
                            'as_sub_type' => 'pcr',
                            'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                            'as_date' => $this->today,
                            'as_base_month' => $this->post['base_month'],
                        );


                        $this->ind_model->insert_amb_stock($unit_args);
                    }
                }
            }
            if (isset($epcr_info['non_unit'])) {
                foreach ($epcr_info['non_unit'] as $unit) {
                    if ($unit['id'] != '' && $unit['type'] != '') {
                        $unit_args = array(
                            'as_item_id' => $unit['id'],
                            'incidentId' => $epcr_info['inc_ref_id'],
                            'as_item_type' => $unit['type'],
                            'as_stk_in_out' => 'out',
                            'as_item_qty' => 1,
                            'as_sub_id' => $epcr_insert_info,
                            'as_sub_type' => 'pcr',
                            'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                            'as_date' => $this->today,
                            'as_base_month' => $this->post['base_month'],
                        );

                        $this->ind_model->insert_amb_stock($unit_args);
                    }
                }
            }
            // var_dump($epcr_info['provider_impressions']);die();
            $provide_imp = array('21', '41', '42', '43', '45');
            if (in_array($epcr_info['provider_impressions'], $provide_imp)) {
                // $is_deleted='1';
                // var_dump(  "hi" );die();
                $epcr_insert_info1 = array(
                    'inc_ref_id' => $epcr_info['inc_ref_id']
                );

                // $epcr_insert_info = $this->pcr_model->update_is_deleted($epcr_insert_info1);
                $update_inc_args = array('inc_ref_id' => $epcr_info['inc_ref_id'], 'inc_pcr_status' => '1', 'inc_feedback_status' => '2');
                // $update_inc = $this->inc_model->update_incident($update_inc_args);

            }
            // else{
            //     $is_deleted='0';
            // }
            // var_dump( $update_inc_args );die();


            $this->session->set_userdata('pcr_steps', '1');

            //////////////////////////////////////////////////////////

            $flforms = pcr_steps($epcr_insert_info, "PCR");

            //////////////////////////////////////////////////////////
        }
        if ($epcr_insert_info) {

            if ($this->session->userdata['current_user']->clg_group == "UG-ShiftManager") {

                $this->output->message = "<div class='success'> Added successfully <a href='" . $this->base_url . "supervisor' class='dark_blue'>Back to Dashboard</a></div>";
            } else {

                $this->output->message = "<div class='success'> Added successfully <a href='" . $this->base_url . "job_closer' class='dark_blue'>Back to Dashboard</a></div>";
            }
        } else {

            $this->output->message = "<div class='error' style='color: red;font-weight: bold;font-size: 150%;'> ERROR : Please Fill All Details..Try Again </div>";
        }
    }
    function save_epcr()
    {

        $epcr_info = $this->input->post();

        $inter_info = $this->input->post('inter');
        $pt_con_handover = $this->input->post('pt_con_handover');
        $baseline_con = $this->input->post('baseline_con');

        $obious_death_ques = "";
        if (isset($epcr_info['obious_death']['ques'])) {
            $obious_death_ques = serialize($epcr_info['obious_death']['ques']);
        }

        $odo_args = array('inc_ref_id' => $epcr_info['inc_ref_id']);
        $get_odometer = $this->amb_model->get_amb_odometer_by_inc($odo_args);
        $total_km = (int)$epcr_info['end_odmeter'] - (int)$epcr_info['start_odmeter'];


        if ($this->clg->clg_group == 'UG-DCO-102') {
            $system_type = '102';
        }
        if ($this->clg->clg_group == 'UG-BIKE-DCO') {
            $system_type = 'BIKE';
        } else {
            $system_type = '108';
        }

        $amb_details = $this->inc_model->get_ambulance_details_API($epcr_info['amb_reg_id']);
        $amb_lat = $amb_details[0]->amb_lat;
        $amb_log = $amb_details[0]->amb_log;
        $amb_status = $amb_details[0]->amb_status;
        $thirdparty = $amb_details[0]->thirdparty;


        $epcr_insert_info = array(
            'date' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'amb_reg_id' => $epcr_info['amb_reg_id'],
            'inc_ref_id' => $epcr_info['inc_ref_id'],
            'ptn_id' => $epcr_info['pat_id'],
            'ercp_advice' => $epcr_info['ercp_advice'],
            // 'loc' => $epcr_info['loc'],
            'provider_casetype' => $epcr_info['provider_casetype'],
            'provider_impressions' => $epcr_info['provider_impressions'],
            'rec_hospital_name' => $inter_info['new_facility'],
            'base_month' => $this->post['base_month'],
            'state_id' => $epcr_info['tc_dtl_state'],
            'district_id' => $epcr_info['tc_dtl_districts'],
            'city_id' => $epcr_info['tc_dtl_ms_city'],
            'start_odometer' => $epcr_info['start_odmeter'],
            'scene_odometer' => $epcr_info['scene_odometer'],
            'hospital_odometer' => $epcr_info['hospiatl_odometer'],
            'end_odometer' => $epcr_info['end_odmeter'],
            'inc_area_type' => $epcr_info['inc_area_type'],
            'total_km' => $total_km,
            'locality' => $epcr_info['locality'],
            'base_location_name' => $epcr_info['base_location'],
            'base_location_id' => $epcr_info['base_location_id'],
            'wrd_location' => $epcr_info['wrd_location'],
            'wrd_location_id' => $epcr_info['wrd_location_id'],
            'emt_name' => $epcr_info['emt_name'],
            'emso_id' => $epcr_info['emt_id'],
            'pilot_name' => $epcr_info['pilot_name'],
            'emt_id_other' => $epcr_info['emt_id_other'],
            'pilot_name' => $epcr_info['pilot_name'],
            'pilot_id_other' => $epcr_info['pilot_id_other'],
            'pilot_id' => $epcr_info['pilot_id'],
            'remark' => $epcr_info['epcr_remark'],
            'gps_odometer' => $epcr_info['gps_odmeter'],
            'inc_datetime' => $epcr_info['inc_datetime'],
            'obious_death_ques' => $obious_death_ques,
            'operate_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'system_type' => $system_type,
            'third_party' => $thirdparty,
            'epcris_deleted' => '0',

            'loc' => $baseline_con['loc'],
            'ini_airway' => $baseline_con['airway'],
            'ini_breathing' => $baseline_con['breathing'],
            'ini_con_circulation_radial' => $baseline_con['circulation_radial'],
            'ini_con_circulation_carotid' => $baseline_con['circulation_carotid'],
            'ini_con_temp' => $baseline_con['temp'],
            'ini_con_bsl' => $baseline_con['bsl'],
            'ini_cir_pulse_p' => $baseline_con['pulse'],
            'ini_oxy_sat_get_nf_txt' => $baseline_con['osat'],
            'ini_con_rr' => $baseline_con['rr'],
            'ini_con_gcs' => $baseline_con['gcs'],
            'ini_bp_sysbp_txt' => $baseline_con['bp_syt'],
            'ini_bp_dysbp_txt' => $baseline_con['bp_dia'],
            'ini_con_skin' => $baseline_con['skin'],
            'ini_con_pupils' => $baseline_con['pupils'],

            'hc_loc' => $pt_con_handover['loc'],
            'hc_airway' => $pt_con_handover['airway'],
            'hc_breathing' => $pt_con_handover['breathing'],
            'hc_con_circulation_radial' => $pt_con_handover['circulation_radial'],
            'hc_con_circulation_carotid' => $pt_con_handover['circulation_carotid'],
            'hc_con_temp' => $pt_con_handover['temp'],
            'hc_con__bsl' => $pt_con_handover['bsl'],
            'hc_cir_pulse_p' => $pt_con_handover['pulse'],
            'hc_oxy_sat_get_nf' => $pt_con_handover['osat'],
            'hc_con_rr' => $pt_con_handover['rr'],
            'hc_con_gcs' => $pt_con_handover['gcs'],
            'hc_bp_sysbp_txt' => $pt_con_handover['bp_syt'],
            'hc_bp_dibp_txt' => $pt_con_handover['bp_dia'],
            'hc_con_skin' => $pt_con_handover['skin'],
            'hc_con_pupils' => $pt_con_handover['pupils'],
            'hc_status_during_status' => $pt_con_handover['pt_status_during_status'],
            'hc_cardiac' => $pt_con_handover['cardiac'],
            'is_validate' => '1'
        );

        if (!empty($epcr_info['pcr_district'])) {
            $epcr_insert_info['hospital_district'] = $epcr_info['pcr_district'];
        }
        if (!empty($epcr_info['other_provider'])) {
            $epcr_insert_info['other_provider_img'] = $epcr_info['other_provider'];
        }

        if (!empty($epcr_info['other_receiving_host'])) {
            $epcr_insert_info['other_receiving_host'] = $epcr_info['other_receiving_host'];
        }
        if (!empty($epcr_info['other_units'])) {
            $epcr_insert_info['other_units'] = $epcr_info['other_units'];
        }

        if (!empty($epcr_info['other_non_units'])) {
            $epcr_insert_info['other_non_units'] = $epcr_info['other_non_units'];
        }

        if ($epcr_info['ercp_advice_Taken'] != '') {
            $epcr_insert_info['ercp_advice_Taken'] = $epcr_info['ercp_advice_Taken'];
        }
        if (!empty($epcr_info['end_odometer_remark'])) {
            $epcr_insert_info['end_odometer_remark'] = $epcr_info['end_odometer_remark'];
        }

        if (!empty($epcr_info['endodometer_remark_other'])) {
            $epcr_insert_info['endodometer_remark_other'] = $epcr_info['endodometer_remark_other'];
        }
        if (!empty($epcr_info['forwording_feedback'])) {
            $epcr_insert_info['forwording_feedback'] = $epcr_info['forwording_feedback'];
        }



        $inc_amb = array(
            'inc_ref_id' => $epcr_info['inc_ref_id'],
            'amb_pilot_id' => $epcr_info['pilot_id'],
            'amb_emt_id' => $epcr_info['emt_id']
        );

        $this->inc_model->update_inc_amb($inc_amb);

        $epcr_insert_info = $this->pcr_model->insert_epcr($epcr_insert_info);




        // die();
        $closer_operator = array(
            'sub_id' => $epcr_info['inc_ref_id'],
            'operator_id' => $this->clg->clg_ref_id,
            'operator_type' => $this->clg->clg_group,
            'sub_status' => 'ATD',
            'sub_type' => 'CLOSER',
            'base_month' => $this->post['base_month']
        );



        $closer_operator = $this->common_model->assign_operator($closer_operator);

        $inc_date = explode(' ', $epcr_info['inc_datetime']);

        $resonse_time = "";
        if ($epcr_info['at_scene'] != '') {
            $d_start = new DateTime($epcr_info['inc_datetime']);
            $d_end = new DateTime($epcr_info['at_scene']);
            $resonse_time = $d_start->diff($d_end);
        }
        //die();
        //  $resonse_time = date_diff( $epcr_info['at_scene'] , $epcr_info['inc_datetime']);

        $resonse_time = $resonse_time->h . ':' . $resonse_time->i . ':' . $resonse_time->s;
        $resonse_time1 = date('H:i:s', strtotime($resonse_time));


        $data = array(
            'dp_cl_from_desk' => $epcr_info['call_rec_time'],
            'dp_started_base_loc' => $epcr_info['start_from_base'],
            'dp_reach_on_scene' => $epcr_info['from_scene'],
            'dp_on_scene' => $epcr_info['at_scene'],
            'dp_hosp_time' => $epcr_info['at_hospital'],
            'dp_hand_time' => $epcr_info['hand_over'],
            'dp_back_to_loc' => $epcr_info['back_to_base'],
            'dp_pcr_id' => $epcr_insert_info,
            'dp_base_month' => $this->post['base_month'],
            'start_odometer' => $epcr_info['start_odmeter'],
            'scene_odometer' => $epcr_info['scene_odometer'],
            'hospital_odometer' => $epcr_info['hospiatl_odometer'],
            'end_odometer' => $epcr_info['end_odmeter'],
            'start_from_base' => $epcr_info['start_from_base'],
            'dp_date' => date('Y-m-d H:i:s'),
            'inc_ref_id' => $epcr_info['inc_ref_id'],
            'responce_time' => $resonse_time1,
            'responce_time_remark' => $epcr_info['responce_time_remark'],
            'responce_time_remark_other' => $epcr_info['responce_time_remark_other'],
            'inc_dispatch_time' => $inc_date[1],
            'dp_operated_by' => $this->clg->clg_ref_id,
            'inc_date' => $inc_date[0]
        );
        //var_dump($data);
        //die();


        $insert = $this->pcr_model->insert_deriver_pcr($data);

        $epc_args = array('inc_ref_id' => $epcr_info['inc_ref_id']);
        $pcr_count = $this->pcr_model->get_epcr_count_by_inc($epc_args);

        $args_pt = array(
            'get_count' => TRUE,
            'inc_ref_id' => $epcr_info['inc_ref_id']
        );

        $ptn_count = $this->pcr_model->get_pat_by_inc($args_pt);
        $amb_details = $this->inc_model->get_ambulance_details_API($epcr_info['amb_reg_id']);
        $amb_lat = $amb_details[0]->amb_lat;
        $amb_log = $amb_details[0]->amb_log;
        $amb_status = $amb_details[0]->amb_status;
        $thirdparty = $amb_details[0]->thirdparty;



        $inc_details = $this->inc_model->get_inc_details_API($epcr_info['inc_ref_id']);
        $inc_lat = $inc_details[0]->inc_lat;
        $inc_long = $inc_details[0]->inc_long;
        $inc_address = $inc_details[0]->inc_address;
        if ($pcr_count == $ptn_count || $pcr_count >= $ptn_count) {

            $update_inc_args = array('inc_ref_id' => $epcr_info['inc_ref_id'], 'inc_pcr_status' => '1');
            $update_inc = $this->inc_model->update_incident($update_inc_args);
            if ($amb_status == '2') {
                $upadate_amb_data = array('amb_rto_register_no' => $epcr_info['amb_reg_id'], 'amb_status' => 1);
                $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
            }
            $args = array(
                'inc_id' => $epcr_info['inc_ref_id'],
                'caseStatus' => 'false',
                'vehicleName' => $epcr_info['amb_reg_id'],
                'caseOn' => $epcr_info['inc_datetime'],
                'vLat' => $amb_lat,
                'vLong' => $amb_log,
                'pLat' => $inc_lat,
                'pLong' => $inc_long,
                'pationAddress' => $inc_address,
            );
            //var_dump($args);die();
            $send_API = send_API_close($args);
        } else {
            if ($epcr_info['inc_ref_id'] != '' || $epcr_info['inc_ref_id'] != NULL) {
                $update_inc_args = array('inc_ref_id' => $epcr_info['inc_ref_id'], 'inc_pcr_status' => '0');
                $update_inc = $this->inc_model->update_incident($update_inc_args);
            }
        }

        $update_pat_args = array('ptn_id' => $epcr_info['pat_id']);
        $pat_data = array('ptn_pcr_status' => '1');
        $update_pat = $this->pet_model->update_petinfo($update_pat_args, $pat_data);

        $unique_id = get_uniqid($this->session->userdata('user_default_key'));
        $amb_record_data = array(
            'id' => $unique_id,
            'amb_rto_register_no' => $epcr_info['amb_reg_id'],
            'inc_ref_id'          => $epcr_info['inc_ref_id'],
            'start_odmeter'       => $epcr_info['start_odmeter'],
            'scene_odometer'      => $epcr_info['scene_odometer'],
            'hospital_odometer'   => $epcr_info['hospiatl_odometer'],
            'end_odmeter'         => $epcr_info['end_odmeter'],
            'total_km'            => $total_km,
            'timestamp'           => date('Y-m-d H:i:s'),
            'odometer_type'       => 'closure'
        );

        if (!empty($epcr_info['odometer_remark'])) {
            $amb_record_data['remark'] = $epcr_info['odometer_remark'];
        }

        if (!empty($epcr_info['remark_other'])) {
            $amb_record_data['other_remark'] = $epcr_info['remark_other'];
        }
        if (!empty($epcr_info['end_odometer_remark'])) {
            $amb_record_data['end_odometer_remark'] = $epcr_info['end_odometer_remark'];
        }

        if (!empty($epcr_info['endodometer_remark_other'])) {
            $amb_record_data['endodometer_remark_other'] = $epcr_info['endodometer_remark_other'];
        }

        $odo_args = array('inc_ref_id' => $epcr_info['inc_ref_id']);
        $get_odometer = $this->amb_model->get_amb_odometer_by_inc($odo_args);

        if (empty($get_odometer)) {
            $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
        }
        // inc_pcr
        // inc_pcr_status
        $args = array(
            'ptn_id' => $epcr_info['pat_id'],
            'ptn_state' => $epcr_info['tc_dtl_state'],
            'ptn_district' => $epcr_info['tc_dtl_district'],
            'ptn_city' => $epcr_info['tc_dtl_ms_city'],
            'ptn_address' => $epcr_info['locality'],
        );


        $this->pet_model->update_petinfo(array('ptn_id' => $epcr_info['pat_id']), $args);


        $pcr_data[$epcr_info['inc_ref_id']] = array(
            'patient_id' => $epcr_info['pat_id'],
            'inc_ref_id' => $epcr_info['inc_ref_id'],
            'rto_no' => $epcr_info['amb_reg_id'],
            'pcr_id' => $epcr_insert_info
        );

        $this->session->set_userdata('pcr_details', $pcr_data);

        $data_pcr = array(
            'inc_ref_id' => $epcr_info['inc_ref_id'],
            'amb_rto_register_no' => $epcr_info['amb_reg_id'],
            'patient_id' => $epcr_info['pat_id'],
            'base_month' => $this->post['base_month'],
            'pcr_id' => $epcr_insert_info,
            'date' => date('Y-m-d H:i:s')
        );

        $pcr_id = $this->pcr_model->insert_pcr($data_pcr);



        $deletet_amb_stock = array(
            'pcr_id' => $epcr_insert_info,
            'sub_type' => 'pcr'
        );
        $this->ind_model->deletet_amb_stock($deletet_amb_stock);

        if (isset($epcr_info['obious_death']['ques'])) {
            foreach ($epcr_info['obious_death']['ques'] as $key => $ques) {

                $ems_summary = array(
                    'sum_base_month' => $this->post['base_month'],
                    'sum_epcr_id' => $epcr_insert_info,
                    'inc_ref_id' => $epcr_info['inc_ref_id'],
                    'ptn_id' => $epcr_info['pat_id'],
                    'sum_que_id' => $key,
                    'sum_que_ans' => $ques
                );

                $this->pcr_model->insert_obvious_death_ques_summary($ems_summary);
            }
        }


        if (isset($epcr_info['injury'])) {
            foreach ($epcr_info['injury'] as $injury) {

                if ($injury['id'] != '' && $injury['type'] != '') {

                    $injury_args = array(
                        'as_item_id' => $injury['id'],
                        'incidentId' => $epcr_info['inc_ref_id'],
                        'as_item_type' => $injury['type'],
                        'as_stk_in_out' => 'out',
                        'as_item_qty' => 1,
                        'as_sub_id' => $epcr_insert_info,
                        'as_sub_type' => 'pcr',
                        'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                        'as_date' => $this->today,
                        'as_base_month' => $this->post['base_month'],
                    );


                    $this->ind_model->insert_amb_stock($injury_args);
                }
            }
        }
        if (isset($epcr_info['intervention'])) {
            foreach ($epcr_info['intervention'] as $inter) {

                if ($inter['id'] != '' && $inter['type'] != '') {

                    $inter_args = array(
                        'as_item_id' => $inter['id'],
                        'incidentId' => $epcr_info['inc_ref_id'],
                        'as_item_type' => $inter['type'],
                        'as_stk_in_out' => 'out',
                        'as_item_qty' => 1,
                        'as_sub_id' => $epcr_insert_info,
                        'as_sub_type' => 'pcr',
                        'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                        'as_date' => $this->today,
                        'as_base_month' => $this->post['base_month'],
                    );


                    $this->ind_model->insert_amb_stock($inter_args);
                }
            }
        }

        if (isset($epcr_info['med'])) {
            foreach ($epcr_info['med'] as $med) {

                if ($med['value'] != '' && $med['type'] != '') {

                    $unit_args = array(
                        'as_item_id' => $med['id'],
                        'incidentId' => $epcr_info['inc_ref_id'],
                        'as_item_type' => $med['type'],
                        'as_stk_in_out' => 'out',
                        'as_item_qty' => $med['value'],
                        'as_sub_id' => $epcr_insert_info,
                        'as_sub_type' => 'pcr',
                        'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                        'as_date' => $this->today,
                        'as_base_month' => $this->post['base_month'],
                    );


                    $this->ind_model->insert_amb_stock($unit_args);
                }
            }
        }
        if (isset($epcr_info['unit'])) {
            foreach ($epcr_info['unit'] as $unit) {

                if ($unit['value'] != '' && $unit['type'] != '') {

                    $unit_args = array(
                        'as_item_id' => $unit['id'],
                        'incidentId' => $epcr_info['inc_ref_id'],
                        'as_item_type' => $unit['type'],
                        'as_stk_in_out' => 'out',
                        'as_item_qty' => $unit['value'],
                        'as_sub_id' => $epcr_insert_info,
                        'as_sub_type' => 'pcr',
                        'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                        'as_date' => $this->today,
                        'as_base_month' => $this->post['base_month'],
                    );


                    $this->ind_model->insert_amb_stock($unit_args);
                }
            }
        }
        if (isset($epcr_info['non_unit'])) {
            foreach ($epcr_info['non_unit'] as $unit) {
                if ($unit['id'] != '' && $unit['type'] != '') {
                    $unit_args = array(
                        'as_item_id' => $unit['id'],
                        'incidentId' => $epcr_info['inc_ref_id'],
                        'as_item_type' => $unit['type'],
                        'as_stk_in_out' => 'out',
                        'as_item_qty' => 1,
                        'as_sub_id' => $epcr_insert_info,
                        'as_sub_type' => 'pcr',
                        'amb_rto_register_no' => $epcr_info['amb_reg_id'],
                        'as_date' => $this->today,
                        'as_base_month' => $this->post['base_month'],
                    );

                    $this->ind_model->insert_amb_stock($unit_args);
                }
            }
        }
        // var_dump($epcr_info['provider_impressions']);die();
        $provide_imp = array('21', '41', '42', '43', '45');
        if (in_array($epcr_info['provider_impressions'], $provide_imp)) {
            // $is_deleted='1';
            // var_dump(  "hi" );die();
            $epcr_insert_info1 = array(
                'inc_ref_id' => $epcr_info['inc_ref_id']
            );

            // $epcr_insert_info = $this->pcr_model->update_is_deleted($epcr_insert_info1);
            $update_inc_args = array('inc_ref_id' => $epcr_info['inc_ref_id'], 'inc_pcr_status' => '1', 'inc_feedback_status' => '2');
            // $update_inc = $this->inc_model->update_incident($update_inc_args);

        }
        // else{
        //     $is_deleted='0';
        // }
        // var_dump( $update_inc_args );die();


        $this->session->set_userdata('pcr_steps', '1');

        //////////////////////////////////////////////////////////

        $flforms = pcr_steps($epcr_insert_info, "PCR");

        //////////////////////////////////////////////////////////
        if ($epcr_insert_info) {



            if ($this->session->userdata['current_user']->clg_group == "UG-ShiftManager") {
                //   var_dump( "shift");die();
                $this->output->message = "<div class='success'> Added successfully <a href='" . $this->base_url . "supervisor' class='dark_blue'>Back to Dashboard</a></div>";
            } else {
                $this->output->message = "<div class='success'> Added successfully <a href='" . $this->base_url . "job_closer' class='dark_blue'>Back to Dashboard</a></div>";
            }
            //$this->output->message = "<div class='success'> Added successfully<script>window.location.reload(true);</script></div>";

        } else {

            $this->output->message = "<div class='success'> ERR0R  <a href='" . $this->base_url . "job_closer' class='dark_blue'>Back to Dashboard</a></div>";
        }
        //////////////////// Update progressbar ///////////////////////////


        ///////////////////////////////////////////////////////////////////
    }

    ////////////MI44//////////////////////
    //
    // Purpose : Update steps progressbar. 
    //
    //////////////////////////////////////

    function increase_step($pcr_id = '')
    {

        if ($pcr_id) {

            $epcr_steps = $this->pcr_model->get_pcr_details(array('pcr_id' => $pcr_id));

            $data['steps_cnt'] = $this->steps_cnt;

            if ($epcr_steps[0]->pcr_steps != '') {

                $data['step_com'] = explode(",", $epcr_steps[0]->pcr_steps);

                $data['step_com_cnt'] = count($data['step_com']);
            }


            //$this->output->add_to_position($this->load->view('frontend/pcr/progressbar_view', $data, TRUE), "pcr_progressbar", TRUE);
        }



        // $this->output->add_to_position($this->load->view('frontend/pcr/pcr_top_steps_view', $data, TRUE), "pcr_top_steps", TRUE);
    }

    function show_remark_odometer()
    {

        $this->output->add_to_position($this->load->view('frontend/amb/odometer_standard_remark', $data, TRUE), 'remark_textbox', TRUE);
    }

    function show_remark_end_odometer()
    {

        $this->output->add_to_position($this->load->view('frontend/amb/end_odometer_standard_remark', $data, TRUE), 'show_remark_end_odometer', TRUE);
    }

    function show_remark_other_odometer()
    {
        $this->output->add_to_position($this->load->view('frontend/amb/other_end_odometer_view', $data, TRUE), 'end_odometer_remark_other_textbox', TRUE);
    }

    function other_provider_impression()
    {

        $this->output->add_to_position($this->load->view('frontend/pcr/other_provider_impression_view', $data, TRUE), 'other_provider_impression', TRUE);
    }

    function show_end_odometer()
    {

        $odometer = $this->input->post();

        $data['start'] = $odometer['start_odo'];

        $this->output->add_to_position($this->load->view('frontend/amb/end_odometer_view', $data, TRUE), 'end_odometer_textbox', TRUE);
    }

    function other_hospital_textbox()
    {
        $this->output->add_to_position($this->load->view('frontend/pcr/other_hospital_textbox_view', $data, TRUE), 'other_hospital_textbox', TRUE);
    }

    function show_unit_other()
    {
        $this->output->add_to_position($this->load->view('frontend/pcr/show_unit_other', $data, TRUE), 'show_other_unit', TRUE);
    }

    function show_non_unit_other()
    {
        $this->output->add_to_position($this->load->view('frontend/pcr/show_non_unit_other', $data, TRUE), 'show_non_unit_other', TRUE);
    }

    function obious_death_popup()
    {

        $data['questions'] = $this->pcr_model->get_obious_death_questions();


        $this->output->add_to_position($this->load->view('frontend/pcr/obious_death_questions_view', $data, TRUE), 'other_provider_impression', TRUE);
        //$this->output->add_to_popup($this->load->view('frontend/pcr/obious_death_questions_view', $data, TRUE), '600', '600');


        $this->output->template = "pcr";
    }

    function show_emso_id()
    {

        $emt_id = $this->input->post('emt_id');
        $args = array('clg_group' => 'UG-EMT', 'clg_emso_id' => $emt_id);

        $clg = $this->colleagues_model->get_clg_data($args);
        $data['emso_name'] = $clg[0]->clg_first_name . ' ' . $clg[0]->clg_mid_name . ' ' . $clg[0]->clg_last_name;
        $data['clg_ref_id'] = $clg[0]->clg_ref_id;
        $this->output->add_to_position($this->load->view('frontend/pcr/emso_id_view', $data, TRUE), 'show_emso_name', TRUE);
    }

    function show_pilot_id()
    {
        $ref_id = $this->input->post('ref_id');

        //$args = array('clg_group' => 'UG-PILOT', 'clg_ref_id' => $emt_id);
        //$clg = $this->colleagues_model->get_clg_data($args);
        $data['ref_id'] = $ref_id;
        $this->output->add_to_position($this->load->view('frontend/pcr/pilot_id_view', $data, TRUE), 'show_pilot_id', TRUE);
    }
    function show_pilot()
    {
        $ref_id = $this->input->post('ref_id');

        //$args = array('clg_group' => 'UG-PILOT', 'clg_ref_id' => $emt_id);
        //$clg = $this->colleagues_model->get_clg_data($args);
        $data['ref_id'] = $ref_id;
        $this->output->add_to_position($this->load->view('frontend/pcr/pilot_id_view', $data, TRUE), 'show_pilot_id', TRUE);
    }


    function update_epcr_status()
    {
        $inc = $this->inc_model->get_closure_pending_inc();

        foreach ($inc as $epcr_info) {

            // $epcr_info['inc_ref_id'] = 'BK-202101010002';

            $epc_args = array('inc_ref_id' => $epcr_info['inc_ref_id']);
            $pcr_count = $this->pcr_model->get_epcr_count_by_inc($epc_args);




            $args_pt = array(
                'get_count' => TRUE,
                'inc_ref_id' => $epcr_info['inc_ref_id']
            );

            $ptn_count = $this->pcr_model->get_pat_by_inc($args_pt);



            if ($pcr_count == $ptn_count || $pcr_count >= $ptn_count) {

                //  echo $epcr_info['inc_ref_id'];
                $update_inc_args = array('inc_ref_id' => $epcr_info['inc_ref_id'], 'inc_pcr_status' => '1');
                $update_inc = $this->inc_model->update_incident($update_inc_args);
                // echo $update_inc;
            } else {

                // echo 'in';
                $update_inc_args = array('inc_ref_id' => $epcr_info['inc_ref_id'], 'inc_pcr_status' => '0');
                $update_inc = $this->inc_model->update_incident($update_inc_args);
            }
        }
        echo "done";
        die();
    }

    function update_epcr_patient_status()
    {

        $inc = $this->inc_model->get_closure_pending_inc();

        $x = 1;

        //while($x <= 4) {
        foreach ($inc as $epcr_info) {

            $epc_args = array('inc_ref_id' => $epcr_info['inc_ref_id']);

            $patient_info = $this->pcr_model->get_pat_by_inc($epc_args);
            foreach ($patient_info as $ptn) {
                $args_pt = array(
                    'inc_ref_id' => $epcr_info['inc_ref_id'],
                    'ptn_id' => $ptn->ptn_id
                );

                $ptn_data = $this->pcr_model->get_epcr_inc_details_by_inc_id($args_pt);


                if (empty($ptn_data)) {
                    $update_pat_args = array('ptn_id' => $ptn->ptn_id);
                    $pat_data = array('ptn_pcr_status' => '0');
                    $update_pat = $this->pet_model->update_petinfo($update_pat_args, $pat_data);
                } else {
                    if ($ptn_data[0]->start_odometer != '' && $ptn_data[0]->start_odometer != '') {
                        $update_pat_args = array('ptn_id' => $ptn->ptn_id);
                        $pat_data = array('ptn_pcr_status' => '1');
                        $update_pat = $this->pet_model->update_petinfo($update_pat_args, $pat_data);
                    }
                }
            }

            //}
            $x++;
            //sleep(60);
        }

        echo "Done";
        die();
    }
    function show_ambulance_closer_details()
    {

        $first_amb = array('amb_reg_id' => $this->input->post('amb_rto_register_no'), 'base_month' => $this->post['base_month']);


        $inc_amb_details = $this->pcr_model->get_first_inc_by_amb($first_amb);
        $data['closer_data'] = $inc_amb_details;
        $data['amb_rto_register_no'] = $this->input->post('amb_rto_register_no');
        $this->output->add_to_popup($this->load->view('frontend/pcr/show_ambulance_closer_details_view', $data, TRUE), '600', '200');
    }

    //Daily SMS 
    function send_daily_sms_template(){
        //$useragent = $_SERVER ['HTTP_USER_AGENT'];
        //$file_data = file_get_contents('send_daily_sms_ten.txt');
        // file_put_contents('send_daily_sms_ten.txt', $useragent."\r\n".$file_data);

        $sms_rec = '9730015484';
        $today = date('d-m-Y');
        $today = date('Y-m-d', strtotime("yesterday"));


        $report_args['today'] = $today;
        //$report_args =  array('from_date' => date('Y-m-d',strtotime($current_date)),
        // 'to_date' => date('Y-m-d',strtotime($current_date)));

        $report_args['get_count'] = 'true';
        $today_calls = $this->pcr_model->get_today_calls($report_args);
        $total_call_calls = $this->pcr_model->get_all_calls($report_args);

        $inc_info_today = $this->pcr_model->inc_info_today($report_args);
        $inc_info_all = $this->pcr_model->inc_info_all($report_args);
        //var_dump($inc_info_today);die();
        $type = array();
        $type['medical_today'] = 0;
        $type['poly_truama_today'] = 0;
        $type['cardiac_today'] = 0;
        $type['delivery_in_amb_today'] = 0;
        $type['other_today'] = 0;

        $type['medical_all'] = 0;
        $type['poly_truama_all'] = 0;
        $type['cardiac_all'] = 0;
        $type['delivery_in_amb_all'] = 0;
        $type['other_all'] = 0;

        $medical = array(1, 3, 4, 5, 7, 11, 13, 14, 15, 16, 17, 18, 19, 20, 22, 23, 25, 26.27, 28, 29, 30, 31, 32, 34, 37, 38, 39, 40, 46, 47, 48, 49, 50, 51);
        $poly_truama = array(2, 6, 33);
        $cardiac = array(8, 9, 10);
        $delivery_in_amb = array(12.24);
        $other_all = array(21, 35, 36, 41, 42, 43, 44, 45);

        foreach ($inc_info_today as $inc_data_today) {
            $provider_impressions = $inc_data_today->provider_impressions;
            if (in_array($provider_impressions, $medical)) {
                $type['medical_today'] = $type['medical_today'] + 1;
            } else if (in_array($provider_impressions, $poly_truama)) {
                $type['poly_truama_today'] = $type['poly_truama_today'] + 1;
            } else if (in_array($provider_impressions, $poly_truama)) {
                $type['cardiac_today'] = $type['cardiac_today'] + 1;
            } else if (in_array($provider_impressions, $poly_truama)) {
                $type['delivery_in_amb_today'] = $type['delivery_in_amb_today'] + 1;
            } else if (in_array($provider_impressions, $poly_truama)) {
                $type['other_today'] = $type['other_today'] + 1;
            }
        }

        foreach ($inc_info_all as $inc_data_all) {
            $provider_impressions = $inc_data_all->provider_impressions;
            if (in_array($provider_impressions, $medical)) {
                $type['medical_all'] = $type['medical_all'] + 1;
            } else if (in_array($provider_impressions, $poly_truama)) {
                $type['poly_truama_all'] = $type['poly_truama_all'] + 1;
            } else if (in_array($provider_impressions, $poly_truama)) {
                $type['cardiac_all'] = $type['cardiac_all'] + 1;
            } else if (in_array($provider_impressions, $poly_truama)) {
                $type['delivery_in_amb_all'] = $type['delivery_in_amb_all'] + 1;
            } else if (in_array($provider_impressions, $poly_truama)) {
                $type['other_all'] = $type['other_all'] + 1;
            }
        }
        $total_today = $type['medical_today'] + $type['poly_truama_today'] + $type['cardiac_today'] + $type['delivery_in_amb_today'] + $type['other_today'];
        $total_till_date = $type['medical_all'] + $type['poly_truama_all'] + $type['cardiac_all'] + $type['delivery_in_amb_all'] + $type['other_all'];

        $msg_text = "";
        // $msg_text .= "\nTotal Calls: ".$today_calls." | ".$total_call_calls.",";
        //        $msg_text .= "\nTruma: ".$type['poly_truama_today']." | ".$type['poly_truama_all']."";
        //        $msg_text .= "\nMedical: ".$type['medical_today']." | ".$type['medical_all']."";
        //        $msg_text .= "\nDelivery In Amby: ".$type['delivery_in_amb_today']." | ".$type['delivery_in_amb_all'].""; 
        //        $msg_text .= "\nCardiac: ".$type['cardiac_today']." | ".$type['cardiac_all']."";
        //        $msg_text .= "\nOther: ".$type['other_today']." | ".$type['other_all']."";
        //        $msg_text .= "\nTotal: ".$total_today." | ".$total_till_date;

        $msg_text .= "BVG
Emergency Type | Patient Serve on $sms_today |  Patients Served till Date Trauma | " . $type['poly_truama_today'] . " | " . $type['poly_truama_all'] . " Medical | " . $type['medical_today'] . " | " . $type['medical_all'] . " Delivery in Amby | " . $type['delivery_in_amb_today'] . " | " . $type['delivery_in_amb_all'] . " Others | " . $type['other_today'] . "| " . $type['other_all'] . " Total  | " . $total_today . "| " . $total_till_date . " MEMS";


        $datetime = date('Y-m-d H:i:s');
        $sms_to = '9730015484';
        $sms_today = date('d/m/Y', strtotime("yesterday"));
        // $msg = "Emergency Type | Patient Serve on $sms_today | Patient Served till date $msg_text \nMHEMS"; 
        $sms_rec = $this->pcr_model->get_sms_recipients();

        foreach ($sms_rec as $rec) {

            $sms_to = $rec->contact_number;


            $args = array(
                'msg' => $msg_text,
                'mob_no' => $sms_to,
                'sms_user' => 'daily_patient_served_sms',
                'inc_id' => '',
            );

            $sms_data = sms_send($args);
        }


        echo "Done";
        die();
    }
    function get_odometer_by_gps(){

        $vehicle_no =  $this->input->post('vehicle_no');
        $start_time = $this->input->post('start_time');
        $end_time = $this->input->post('end_time');

        $start_time = date('d-m-Y H:i:s', strtotime($start_time));
        $end_time = date('d-m-Y H:i:s', strtotime($end_time));

        $vehicle_no = urlencode($vehicle_no);
        $start_time = urlencode($start_time);
        $end_time = urlencode($end_time);
        
        //$form_url = "http://hindit.biz/api/pushsms?user=jaes&authkey=92zRsmUQr4uUs&sender=JAESPL&mobile=$mobile_no&text=$text_msg&entityid=1701164198802150041&templateid=$tmp_id&rpt=1&summary=1&output=json";
        $form_url= "https://3.6.6.255/webservice?token=getHistoryDataTracknovate&vehicle_no=$vehicle_no&start_time=$start_time&end_time=$end_time";
        //$form_url= "https://3.6.6.255/webservice?token=getHistoryDataTracknovate&vehicle_no=$vehicle_no";
    //    var_dump($form_url);
       //$form_url = urlencode($form_url);
            $arrContextOptions=array(
        "ssl"=>array("verify_peer"=>false,"verify_peer_name"=>false,),);
        $data = file_get_contents($form_url, false, stream_context_create($arrContextOptions));
        // var_dump($data);
        $data = json_decode($data);
        

        $data = (array)$data;

        $dst = (array)$data['data'][0];
        $distance = $dst['distance'];
        $distance = $distance/1000;
       
    //     die();
        echo json_encode($distance);
        die();
}
function nhm_closure_data_rtm($generated = false){
    $user_group = $this->clg->clg_group;

    if ( $user_group == 'UG-NHM') {
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
        //        var_dump($this->fdata);
        //        die();
        //        


        $data['amb_reg_id'] = "";
        $data['filter'] = $filter = "";
        $data['filter'] = $_POST['filter'] ? $this->post['filter'] : $this->fdata['filter'];

        $data['amb_reg_id_new'] = $_POST['amb_reg_id_new'] ? $this->post['amb_reg_id_new'] : $this->fdata['amb_reg_id_new'];
        $data['amb_reg_id'] = $_POST['amb_reg_id'] ? $this->post['amb_reg_id'] : $this->fdata['amb_reg_id'];
        $data['district_id'] = $_POST['district_id'] ? $this->post['district_id'] : $this->fdata['district_id'];
        $data['inc_date'] = $_POST['inc_date'] ? $this->post['inc_date'] : $this->fdata['inc_date'];
        $data['hp_id'] = $_POST['hp_id'] ? $this->post['hp_id'] : $this->fdata['hp_id'];
        $data['inc_id'] = $data['inc_ref_id'] = $_POST['inc_id'] ? $this->post['inc_id'] : $this->fdata['inc_id'];
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
            } else if ($data['filter'] == 'close_by_emt') {
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
            } else if ($data['filter'] == 'reopen_id') {
                $filter = '';
                $sortby['reopen_id'] = '1';
                $data['reopen_id'] = $data['reopen_id'];
                $data['reopen_case'] = 'y';
            }
        }

       
        $this->session->set_userdata('epcr_filter', $data);

        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        if ($this->clg->clg_group == 'UG-NHM') {
            $args_dash = array(
                'base_month' => $this->post['base_month']
                
            );
        } else {
            $args_dash = array(
                'operator_id' => $this->clg->clg_ref_id,
                'base_month' => $this->post['base_month']
            );
        }

     

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        $data['get_count'] = TRUE;

        $first_amb_args = array(
            'system_type' => $args_dash['system_type'],
            'amb_reg_id' => $data['amb_reg_id'],
            'thirdparty' => $this->clg->thirdparty,
            'base_month' => $this->post['base_month']
        );

      
        $data['default_state'] = $this->default_state;


        if ($this->clg->clg_group == 'UG-REMOTE') {
            $district_id = preg_replace($regex, $replaceWith, $district_id);
            $district_id = json_decode($district_id);

            if (is_array($district_id)) {
                $district_id = implode("','", $district_id);
            }
            $args_dash['district_id'] = $district_id;
        }

        $args_dash['thirdparty'] = $this->clg->thirdparty;
        $args_dash['get_count'] = TRUE;
        //var_dump($sortby);die();

        $total_cnt = $this->pcr_model->get_nhm_inc_by_rtm($args_dash, $offset, $limit, $filter, $sortby, $incomplete_inc_amb);

        unset($args_dash['get_count']);

        $inc_info = $this->pcr_model->get_nhm_inc_by_rtm($args_dash, $offset, $limit, $filter, $sortby, $incomplete_inc_amb);
        // print_r( $inc_info);die;

        // $arg_amb = array('amb_user_type' => 'tdd');
        // $data['amb_list'] = $this->amb_model->get_amb_data($arg_amb);
        // $data['amb_list'] = $this->amb_model->get_amb_data();

        $data['per_page'] = $limit;
        $data['inc_offset'] = $offset;

        $data['inc_info'] = $inc_info;

        $data['total_count'] = $total_cnt;

        $data['per_page'] = $limit;

        $pgconf = array(
            'url' => base_url("job_closer/rtm"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array(
                'class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
            )
        );
        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);
        $data['default_state'] = $this->default_state;
        $this->output->add_to_position('', 'caller_details', TRUE);
        $this->output->add_to_position($this->load->view('frontend/pcr/nhm_rtm_dashboard_view', $data, TRUE), 'content', TRUE);

        
    } else {
        dashboard_redirect($user_group, $this->base_url);
    }
    
}
function rtm($generated = false){
    $user_group = $this->clg->clg_group;

    if ( $user_group == 'UG-RTM') {
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
        //        var_dump($this->fdata);
        //        die();
        //        


        $data['amb_reg_id'] = "";
        $data['filter'] = $filter = "";
        $data['filter'] = $_POST['filter'] ? $this->post['filter'] : $this->fdata['filter'];

        $data['amb_reg_id_new'] = $_POST['amb_reg_id_new'] ? $this->post['amb_reg_id_new'] : $this->fdata['amb_reg_id_new'];
        $data['amb_reg_id'] = $_POST['amb_reg_id'] ? $this->post['amb_reg_id'] : $this->fdata['amb_reg_id'];
        $data['district_id'] = $_POST['district_id'] ? $this->post['district_id'] : $this->fdata['district_id'];
        $data['inc_date'] = $_POST['inc_date'] ? $this->post['inc_date'] : $this->fdata['inc_date'];
        $data['hp_id'] = $_POST['hp_id'] ? $this->post['hp_id'] : $this->fdata['hp_id'];
        $data['inc_id'] = $data['inc_ref_id'] = $_POST['inc_id'] ? $this->post['inc_id'] : $this->fdata['inc_id'];
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
            } else if ($data['filter'] == 'close_by_emt') {
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
            } else if ($data['filter'] == 'reopen_id') {
                $filter = '';
                $sortby['reopen_id'] = '1';
                $data['reopen_id'] = $data['reopen_id'];
                $data['reopen_case'] = 'y';
            }
        }

       
        $this->session->set_userdata('epcr_filter', $data);

        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        if ($this->clg->clg_group == 'UG-RTM') {
            $args_dash = array(
                'base_month' => $this->post['base_month']
                
            );
        } else {
            $args_dash = array(
                'operator_id' => $this->clg->clg_ref_id,
                'base_month' => $this->post['base_month']
            );
        }

        if ($this->clg->clg_group == 'UG-DCO' || $this->clg->clg_group == 'UG-REMOTE') {
            $args_dash['system_type'] = '108';
        } else if ($this->clg->clg_group == 'UG-DCO-104') {
            $args_dash['system_type'] = '104';
        }


        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        $data['get_count'] = TRUE;

        $first_amb_args = array(
            'system_type' => $args_dash['system_type'],
            'amb_reg_id' => $data['amb_reg_id'],
            'thirdparty' => $this->clg->thirdparty,
            'base_month' => $this->post['base_month']
        );

        $data['closer_data'] = $inc_amb_details;
        $data['default_state'] = $this->default_state;


        if ($this->clg->clg_group == 'UG-REMOTE') {
            $district_id = preg_replace($regex, $replaceWith, $district_id);
            $district_id = json_decode($district_id);

            if (is_array($district_id)) {
                $district_id = implode("','", $district_id);
            }
            $args_dash['district_id'] = $district_id;
        }

        $args_dash['thirdparty'] = $this->clg->thirdparty;
        $args_dash['get_count'] = TRUE;
        //var_dump($sortby);die();

        $total_cnt = $this->pcr_model->get_inc_by_rtm($args_dash, $offset, $limit, $filter, $sortby, $incomplete_inc_amb);

        unset($args_dash['get_count']);

        $inc_info = $this->pcr_model->get_inc_by_rtm($args_dash, $offset, $limit, $filter, $sortby, $incomplete_inc_amb);
        // print_r( $inc_info);die;

        // $arg_amb = array('amb_user_type' => 'tdd');
        // $data['amb_list'] = $this->amb_model->get_amb_data($arg_amb);
        // $data['amb_list'] = $this->amb_model->get_amb_data();

        $data['per_page'] = $limit;
        $data['inc_offset'] = $offset;

        $data['inc_info'] = $inc_info;

        $data['total_count'] = $total_cnt;

        $data['per_page'] = $limit;

        $pgconf = array(
            'url' => base_url("job_closer/rtm"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array(
                'class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
            )
        );
        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);
        $data['default_state'] = $this->default_state;
        $this->output->add_to_position('', 'caller_details', TRUE);
        $this->output->add_to_position($this->load->view('frontend/pcr/rtm_dashboard_view', $data, TRUE), 'content', TRUE);

        
        if ($this->clg->clg_group == 'UG-RTM') {
            $this->output->template = "pcr";
        }
    } else {
        dashboard_redirect($user_group, $this->base_url);
    }
    
}
function save_remark_data()
	{
         $dst_name = $this->input->post('dst_name');
        if($dst_name != ''){
            $incient_district = $this->pcr_model->get_dist_by_name($dst_name);
            $dst_code = $incient_district[0]->dst_code;
            // var_dump($dst_code);die();
        }
        $hp_name = $this->input->post('base_loc');
        if($hp_name != ''){
            $base_location = $this->pcr_model->get_base_by_name($hp_name);
            $hp_id = $base_location[0]->hp_id;
            // var_dump($dst_code);die();
        }

        $data['inc_ref_id'] = $this->input->post('inc_id');
        $data['amb_base_location'] = $hp_id;
        $data['amb_rto_register_no'] = $this->input->post('amb_no');
        $data['amb_default_mobile'] = $this->input->post('amb_aug');
        $data['inc_dispatch_time'] = $this->input->post('dis_time');
        $data['inc_district_id'] = $dst_code;
		$data['remark']=$this->input->post('remark');
		
		// $data['clg_id']=$this->input->post('clg_id');
		$data['added_date']=date('Y-m-d H:i:s');
		$data['added_by']=$this->clg->clg_ref_id;
        // print_r($data);die;
		$rem = $this->pcr_model->saveremarks($data);
        if($rem == 1){
            echo json_encode("Remark Saved Successfully");
        }		
	
	}
    function show_remark_data()
	{
        $inc_id=$this->input->post("inc_id");
        $data = $this->pcr_model->showremarks( $inc_id);
        $ramark_data = array('remark' => $data[0]->remark,
             'added_date'=>$data[0]->added_date,
             'clg_first_name'=>$data[0]->clg_first_name,
             'clg_mid_name'=>$data[0]->clg_mid_name,
             'clg_last_name'=>$data[0]->clg_last_name,);
          // $data = array('remark'=>);
        //  print_r($data);die;
        echo json_encode($ramark_data);
        die();
	}
}
