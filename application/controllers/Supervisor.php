<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Supervisor extends EMS_Controller {

    var $dtmf, $dtmt; // default time from/to

    function __construct() {

        parent::__construct();

        $this->active_module = "M-SUP-DASH";

        $this->pg_limit = $this->config->item('pagination_limit');

        $this->load->library(array('session', 'modules'));

        $this->load->model(array('module_model','Dashboard_model_final', 'Medadv_model', 'call_model', 'amb_model', 'inc_model', 'police_model', 'fire_model','reports_model'));

        $this->load->helper(array('comman_helper'));

        $this->post = $this->input->get_post(NULL);

        $this->post['base_month'] = get_base_month();

        $this->clg = $this->session->userdata('current_user');

        $this->today = date('Y-m-d H:i:s');
        if ($this->post['filters'] == 'reset') {
            $this->session->unset_userdata('filters')['AMB'];
        }

        if ($this->session->userdata('filters')['AMB']) {
            $this->fdata = $this->session->userdata('filters')['AMB'];
        }
    }

    public function index($generated = false) {
        $user_group = $this->clg->clg_group;  
        $this->post = $this->input->post();
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');

        $this->post['base_month'] = get_base_month();

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];


        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }


        //$limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : 10;

        $args_dash = array(
            'base_month' => $this->post['base_month']
        );

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        
        $district_id = "";
        if($this->clg->clg_group ==  'UG-DM' || $this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER' || $this->clg->clg_group == 'UG-BIKE-SUPERVISOR'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
        }
        $args_dash['amb_district'] = $district_id;

        $inc_info = $this->call_model->get_inc_by_ero_dispatch($args_dash, $offset, $limit);


        $inc_data = (object) array();

        $data['per_page'] = $limit;

        $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->call_model->get_inc_by_ero_dispatch($args_dash);


        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("supervisor/ero_dash"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
            )
        );


        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);


        //////////// Filter////////////

        $data['pg_rec_amb'] = ($this->post['pg_rec_amb']) ? $this->post['pg_rec_amb'] : $this->fdata['pg_rec_amb'];

        $ambflt['AMB'] = $data;

        //////////////////////////limit & offset//////

        $data['get_count'] = TRUE;
        $data['amb_status'] = '2';
        $data['amb_district'] = $district_id;
        // $data['amb_user_type']= 'tdd';
        $current_date =date('Y-m-d H:i:s');
        $newdate = date('Y-m-d H:i:s',strtotime ( '-24 hour' , strtotime($current_date))) ;
        $data['from_date'] =$newdate ;
        $data['to_date'] =$current_date;
       
        $data['amb_total_count']= $data['total_count1'] = $this->amb_model->get_busy_amb_data($data);
        //$limit = ($data['pg_rec_amb']) ? $data['pg_rec_amb'] : $this->pg_limit;
        $limit = ($data['pg_rec_amb']) ? $data['pg_rec_amb'] : 10;

        $page_no1 = get_pgno($data['total_count1'], $limit, $page_no);

        $offset = ($page_no1 == 1) ? 0 : ($page_no * $limit) - $limit;


        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['AMB'] = $data;

        //$this->session->set_userdata('filters', $ambflt);
        /////////////////////////////////////////////////////


        unset($data['get_count']);

//        $data['result'] = $this->amb_model->get_amb_data($data, $offset, $limit);

//        $data['get_data'] = $this->amb_model->get_working_area();

        $data['cur_page'] = $page_no;
        $pgconf_amb = array(
            'url' => base_url("supervisor/assign_ambulance_list"),
            'total_rows' => $data['amb_total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no1,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=amb"
            )
        );

        $config = get_pagination($pgconf_amb);
        $data['amb_pagination'] = get_pagination($pgconf_amb);
        $type = $this->post['type'];
       // $type = $this->post['type'];
        // var_dump($type);die();
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

       // $data['total_count'] = $this->amb_model->get_amb_data($data);

        //$limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : 10;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['AMB'] = $data;

        $this->session->set_userdata('filters', $ambflt);

        /////////////////////////////////////////////////////

        unset($data['get_count']);

//        $args = array(
//            'amb_status'=>'1'
//        );

        $data['amb_status'] = '2';

        $data['result'] = $this->amb_model->get_busy_amb_data($data, $offset, $limit);
        $data['count']  = count( $data['result'] );

        //$data['get_data'] = $this->amb_model->get_working_area();
        $current_time = date('Y-m-d H:i:s');
        
        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("supervisor/assign_ambulance_list"),
            'total_rows' => $data['amb_total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        // district_data
        $data['amb_pagination'] = get_pagination($pgconf);
        $data['district_data'] = $this->common_model->get_district(array('st_id' => 'MP'));
        $district_code= $this->clg->clg_district_id;
        $dist = json_decode($district_code);
        if(is_array($dist)){
            $dist = implode("','",$dist);
        }
        $args_pending = array(
            'base_month' => $this->post['base_month'],
            'get_count' => TRUE,
            'district' => $dist,
        );
//        $data['closure_pending_count'] =  count($this->amb_model->get_closure_pending($args_pending));
//        $data['zero_to_two'] =  count($this->amb_model->get_closure_pending_0_2($args_pending));
//        $data['two_to_six'] =  count($this->amb_model->get_closure_pending_2_6($args_pending));
//        $data['six_to_twelve'] =  count($this->amb_model->get_closure_pending_6_12($args_pending));
//        $data['twelve_to_eighteen'] =  count($this->amb_model->get_closure_pending_12_18($args_pending));
//        $data['eighteen_to_twenty_four'] =  count($this->amb_model->get_closure_pending_18_24($args_pending));
//        $data['more_than_twenty_four'] =  count($this->amb_model->get_closure_pending_24_more($args_pending));
        
        // print_r($dist);die;

        $data['closure_pending_count'] =  $this->amb_model->get_closure_pending($args_pending);
        $data['zero_to_two'] =  $this->amb_model->get_closure_pending_0_2($args_pending);
        $data['two_to_six'] =  $this->amb_model->get_closure_pending_2_6($args_pending);
        $data['six_to_twelve'] = $this->amb_model->get_closure_pending_6_12($args_pending);
        $data['twelve_to_eighteen'] =  $this->amb_model->get_closure_pending_12_18($args_pending);
        $data['eighteen_to_twenty_four'] =  $this->amb_model->get_closure_pending_18_24($args_pending);
        $data['more_than_twenty_four'] = $this->amb_model->get_closure_pending_24_more($args_pending);
        
        $data['validation_pending_count'] =  $this->amb_model->get_validation_pending($args_pending);
        $data['validation_zero_to_two'] =  $this->amb_model->get_validation_pending_0_2($args_pending);
        $data['validation_two_to_six'] =  $this->amb_model->get_validation_pending_2_6($args_pending);
        $data['validation_six_to_twelve'] = $this->amb_model->get_validation_pending_6_12($args_pending);
        $data['validation_twelve_to_eighteen'] =  $this->amb_model->get_validation_pending_12_18($args_pending);
        $data['validation_eighteen_to_twenty_four'] =  $this->amb_model->get_validation_pending_18_24($args_pending);
        $data['validation_more_than_twenty_four'] = $this->amb_model->get_validation_pending_24_more($args_pending);
        
        $data['clg_group'] = $this->clg->clg_group;
       
        $this->output->add_to_position($this->load->view('frontend/supervisor/supervisor_dashboard_inc', $data, TRUE), 'content', TRUE);
        if ($this->clg->clg_group == 'UG-DCO' || $this->clg->clg_group == 'UG-DCO-102' || $this->clg->clg_group == 'UG-BIKE-DCO'){
            $this->output->template = "pcr";
        }
//        }else{
//             dashboard_redirect($user_group,$this->base_url );
//        }
    }

    public function closure_pending_popup($generated = false) {

        $this->post = $this->input->post();
     
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');
        $this->post['base_month'] = get_base_month();
        $data['filter_time'] = $this->post['filter_time'];
       
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        if($this->post['search_empty']=="empty"){
            $data['call_search_0_2'] = ($this->post['call_search_0_2']) ? $this->post['call_search_0_2'] : $this->fdata['call_search_0_2'];
            $data['dist_search_0_2'] = ($this->post['dist_search_0_2']) ? $this->post['dist_search_0_2'] : $this->fdata['dist_search_0_2'];
            $data['amb_no_search_0_2'] = ($this->post['amb_no_search_0_2']) ? $this->post['amb_no_search_0_2'] : $this->fdata['amb_no_search_0_2'];
        }
        
        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }

        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $args_dash = array(
            'base_month' => $this->post['base_month']
        );

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        
        $district_id = "";
        if($this->clg->clg_group ==  'UG-DM' ||$this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER' || $this->clg->clg_group == 'UG-BIKE-SUPERVISOR'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
        }
        // inc_total_count
        $args_dash['amb_district'] = $district_id;

      //  $inc_info = $this->call_model->get_inc_by_ero_dispatch($args_dash, $offset, $limit);

        $inc_data = (object) array();

        $data['per_page'] = $limit;

        // $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;
    //   $total_cnt = $this->call_model->get_inc_by_ero_dispatch($args_dash);

    //   $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;

        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);

        //////////// Filter////////////

        $data['pg_rec_amb'] = ($this->post['pg_rec_amb']) ? $this->post['pg_rec_amb'] : $this->fdata['pg_rec_amb'];

        $ambflt['AMB'] = $data;

        //////////////////////////limit & offset//////

        $data['get_count'] = TRUE;
        $data['amb_status'] = '2';
        $data['amb_district'] = $district_id;
      // $data['amb_user_type']= 'tdd';
     
        $data['amb_total_count']= $data['total_count1'] = $this->amb_model->get_busy_amb_data_popup($data);
       

        $limit = ($data['pg_rec_amb']) ? $data['pg_rec_amb'] : $this->pg_limit;

        $page_no1 = get_pgno($data['total_count1'], $limit, $page_no);

        $offset = ($page_no1 == 1) ? 0 : ($page_no * $limit) - $limit;


        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['AMB'] = $data;

        //$this->session->set_userdata('filters', $ambflt);
        /////////////////////////////////////////////////////


        unset($data['get_count']);

//        $data['result'] = $this->amb_model->get_amb_data($data, $offset, $limit);

//        $data['get_data'] = $this->amb_model->get_working_area();

        $data['cur_page'] = $page_no;
        $pgconf_amb = array(
            'url' => base_url("supervisor/ero_dash_popup"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no1,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=amb"
            )
        );

        $config = get_pagination($pgconf_amb);
        $data['amb_pagination'] = get_pagination($pgconf_amb);
        $type = $this->post['type'];
       // $type = $this->post['type'];
        
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

       // $data['total_count'] = $this->amb_model->get_amb_data($data);

        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['AMB'] = $data;

        $this->session->set_userdata('filters', $ambflt);

        /////////////////////////////////////////////////////
        // inc_info
        unset($data['get_count']);

//        $args = array(
//            'amb_status'=>'1'
//        );

        $data['amb_status'] = '2';
       
       
        $data['result'] = $this->amb_model->get_busy_amb_data_popup($data, $offset, $limit);
       
        $data['count']  = count( $data['result'] );

        //$data['get_data'] = $this->amb_model->get_working_area();
        $current_time = date('Y-m-d H:i:s');
        
        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("supervisor/ero_dash_popup"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );
      
   
        $data['amb_pagination'] = get_pagination($pgconf);
      
        if($data['filter_time']=="0_2")
        {
            $data['title'] = "Validation Pending from Last 2 Hours" ;
            $data['value'] = "1";
            $data['filter_time'] = "0_2";
        }
        else if($data['filter_time']=="2_6")
        {
            $data['title'] = "Validation Pending List 2 to 6 Hours" ; 
            $data['value'] = "2";
            $data['filter_time'] = "2_6";
        }
        else if($data['filter_time']=="6_12")
        {
            $data['title'] = "Validation Pending List 6 to 12 Hours" ;
            $data['value'] = "3";
            $data['filter_time'] = "6_12";

        } else if($data['filter_time']=="12_18")
        {
            $data['title'] = "Validation Pending List 12 to 18 Hours" ;
            $data['value'] = "4";
            $data['filter_time'] = "12_18";

        }else if($data['filter_time']=="18_24")
        {
            $data['title'] = "Validation Pending List 18 24 Hours" ;
            $data['value'] = "5";
            $data['filter_time'] = "18_24";

        }else if($data['filter_time']=="24_more")
        {
            $data['title'] = "Validation Pending List more than 24 Hours" ;
            $data['value'] = "6";
            $data['filter_time'] = "24_more";

        }else{

            $data['title'] = "Validation Pending List" ;
            $data['value'] = "7";
            $data['filter_time'] = "no_filter";

        }
        $data['clg_group'] = $this->clg->clg_group;
        $data['district_data'] = $this->common_model->get_district(array('st_id' => 'MP'));

        $this->output->add_to_position($this->load->view('frontend/supervisor/supervisor_dashboard_popup_inc', $data, TRUE), 'content', TRUE);
        
    }

    public function validation_pending_popup($generated = false) {

        $this->post = $this->input->post();
     
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');
        $this->post['base_month'] = get_base_month();
        $data['filter_time'] = $this->post['filter_time'];
       
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        if($this->post['search_empty']=="empty"){
            $data['call_search_0_2'] = ($this->post['call_search_0_2']) ? $this->post['call_search_0_2'] : $this->fdata['call_search_0_2'];
            $data['dist_search_0_2'] = ($this->post['dist_search_0_2']) ? $this->post['dist_search_0_2'] : $this->fdata['dist_search_0_2'];
            $data['amb_no_search_0_2'] = ($this->post['amb_no_search_0_2']) ? $this->post['amb_no_search_0_2'] : $this->fdata['amb_no_search_0_2'];
        }
        
        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }

        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $args_dash = array(
            'base_month' => $this->post['base_month']
        );

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        
        $district_id = "";
        if($this->clg->clg_group ==  'UG-DM' ||$this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER' || $this->clg->clg_group == 'UG-BIKE-SUPERVISOR'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
        }
        // inc_total_count
        $args_dash['amb_district'] = $district_id;

      //  $inc_info = $this->call_model->get_inc_by_ero_dispatch($args_dash, $offset, $limit);

        $inc_data = (object) array();

        $data['per_page'] = $limit;

        // $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;
    //   $total_cnt = $this->call_model->get_inc_by_ero_dispatch($args_dash);

    //   $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;

        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);

        //////////// Filter////////////

        $data['pg_rec_amb'] = ($this->post['pg_rec_amb']) ? $this->post['pg_rec_amb'] : $this->fdata['pg_rec_amb'];

        $ambflt['AMB'] = $data;

        //////////////////////////limit & offset//////

        $data['get_count'] = TRUE;
        $data['amb_status'] = '2';
        $data['amb_district'] = $district_id;
      // $data['amb_user_type']= 'tdd';
     
        $data['amb_total_count']= $data['total_count1'] = $this->amb_model->get_validation_busy_amb_data_popup($data);
       

        $limit = ($data['pg_rec_amb']) ? $data['pg_rec_amb'] : $this->pg_limit;

        $page_no1 = get_pgno($data['total_count1'], $limit, $page_no);

        $offset = ($page_no1 == 1) ? 0 : ($page_no * $limit) - $limit;


        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['AMB'] = $data;

        //$this->session->set_userdata('filters', $ambflt);
        /////////////////////////////////////////////////////


        unset($data['get_count']);

//        $data['result'] = $this->amb_model->get_amb_data($data, $offset, $limit);

//        $data['get_data'] = $this->amb_model->get_working_area();

        $data['cur_page'] = $page_no;
        $pgconf_amb = array(
            'url' => base_url("supervisor/ero_dash_popup"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no1,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=amb"
            )
        );

        $config = get_pagination($pgconf_amb);
        $data['amb_pagination'] = get_pagination($pgconf_amb);
        $type = $this->post['type'];
       // $type = $this->post['type'];
        
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

       // $data['total_count'] = $this->amb_model->get_amb_data($data);

        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['AMB'] = $data;

        $this->session->set_userdata('filters', $ambflt);

        /////////////////////////////////////////////////////
        // inc_info
        unset($data['get_count']);

//        $args = array(
//            'amb_status'=>'1'
//        );

        $data['amb_status'] = '2';
       
       
        $data['result'] = $this->amb_model->get_validation_busy_amb_data_popup($data, $offset, $limit);
       
        $data['count']  = count( $data['result'] );

        //$data['get_data'] = $this->amb_model->get_working_area();
        $current_time = date('Y-m-d H:i:s');
        
        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("supervisor/ero_dash_popup"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );
      
   
        $data['amb_pagination'] = get_pagination($pgconf);
      
        if($data['filter_time']=="0_2")
        {
            $data['title'] = "Validation Pending from Last 2 Hours" ;
            $data['value'] = "1";
            $data['filter_time'] = "0_2";
        }
        else if($data['filter_time']=="2_6")
        {
            $data['title'] = "Validation Pending List 2 to 6 Hours" ; 
            $data['value'] = "2";
            $data['filter_time'] = "2_6";
        }
        else if($data['filter_time']=="6_12")
        {
            $data['title'] = "Validation Pending List 6 to 12 Hours" ;
            $data['value'] = "3";
            $data['filter_time'] = "6_12";

        } else if($data['filter_time']=="12_18")
        {
            $data['title'] = "Validation Pending List 12 to 18 Hours" ;
            $data['value'] = "4";
            $data['filter_time'] = "12_18";

        }else if($data['filter_time']=="18_24")
        {
            $data['title'] = "Validation Pending List 18 24 Hours" ;
            $data['value'] = "5";
            $data['filter_time'] = "18_24";

        }else if($data['filter_time']=="24_more")
        {
            $data['title'] = "Validation Pending List more than 24 Hours" ;
            $data['value'] = "6";
            $data['filter_time'] = "24_more";

        }else{

            $data['title'] = "Validation Pending List" ;
            $data['value'] = "7";
            $data['filter_time'] = "no_filter";

        }
        $data['clg_group'] = $this->clg->clg_group;
        $data['district_data'] = $this->common_model->get_district(array('st_id' => 'MP'));

        $this->output->add_to_position($this->load->view('frontend/supervisor/supervisor_dashboard_validation_popup_inc', $data, TRUE), 'content', TRUE);
        
    }


    public function ero_dash_popup($generated = false) {
        $this->post = $this->input->post();
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');
       // var_dump($this->post);die();
        $this->post['base_month'] = get_base_month();

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $data['call_search'] = ($this->post['call_search']) ? $this->post['call_search'] : $this->fdata['call_search'];
        $data['dist_search'] = ($this->post['dist_search']) ? $this->post['dist_search'] : $this->fdata['dist_search'];
        $data['amb_no_search'] = ($this->post['amb_no_search']) ? $this->post['amb_no_search'] : $this->fdata['amb_no_search'];
       
        //$this->pg_limit = 10;
        ///////////set page number////////////////////

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }


        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $args_dash = array(
            'base_month' => $this->post['base_month']
        );
        if ($data['call_search'] != '') {
            $args_dash['call_search'] = $data['call_search'];
        }

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        $data['get_count'] = TRUE;

       
        $inc_info = $this->call_model->get_inc_by_ero_dispatch($args_dash, $offset, $limit);
// var_dump($inc_info  ,"hi");die();
        $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->call_model->get_inc_by_ero_dispatch($args_dash);

        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;

        $pgconf = array(
            'url' => base_url("supervisor/ero_dash_popup"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
            )
        );


        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);

        //////////// Filter////////////
        $data['rg_no'] = ($this->post['rg_no']) ? $this->post['rg_no'] : $this->fdata['rg_no'];
        $data['mob_no'] = ($this->post['mob_no']) ? $this->post['mob_no'] : $this->fdata['mob_no'];
        $data['pg_rec1'] = ($this->post['pg_rec1']) ? $this->post['pg_rec1'] : $this->fdata['pg_rec1'];

        $data['amb_search'] = ($this->post['call_']) ? $this->post['call_'] : $this->fdata['call_'];
        $data['pg_rec_amb'] = ($this->post['pg_rec_amb']) ? $this->post['pg_rec_amb'] : $this->fdata['pg_rec_amb'];

        $ambflt['AMB'] = $data;
        $data['get_count'] = TRUE;
        $data['amb_status'] = '2';
        $data['total_count2'] = $this->amb_model->get_busy_amb_data($data);
        $data['amb_total_count'] = $this->amb_model->get_busy_amb_data($data);



        $limit = ($data['pg_rec_amb']) ? $data['pg_rec_amb'] : $this->pg_limit;

        $page_no2 = get_pgno($data['total_count2'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no2 * $limit) - $limit;


        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['AMB'] = $data;

        $this->session->set_userdata('filters', $ambflt);


        /////////////////////////////////////////////////////


        unset($data['get_count']);

        $data['cur_page'] = $page_no2;
        $pgconf_amb = array(
            'url' => base_url("supervisor/ero_dash_popup"),
            'total_rows' => $data['total_count2'],
            'per_page' => $limit,
            'cur_page' => $page_no2,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=amb"
            )
        );

        $config = get_pagination($pgconf_amb);
        $data['amb_pagination'] = get_pagination($pgconf_amb);
        $type = $this->post['type'];
// var_dump($type);die();
        //////////// Filter////////////

        unset($data['get_count']);

        $data['amb_status'] = '2';
       
        $data['result'] = $this->amb_model->get_busy_amb_data($data, $offset, $limit);
        // var_dump($data['result']);die();
        $data['district_data'] = $this->common_model->get_district(array('st_id' => 'MP'));

        // if ($type == 'inc') {
            $this->output->add_to_position($this->load->view('frontend/supervisor/supervisor_dashboard_popup_inc', $data, TRUE), 'content', TRUE);
        // }
    }

    function medical_dispatch() {

        $this->post = $this->input->post();
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');

        $this->post['base_month'] = get_base_month();

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];


        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }

        //$limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : 10;

        $args_dash = array(
            'base_month' => $this->post['base_month']
        );

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        $data['inc_info'] = $this->call_model->get_inc_by_ero_dispatch($args_dash, $offset, $limit);


        $inc_data = (object) array();

        $data['per_page'] = $limit;

        //$data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->call_model->get_inc_by_ero_dispatch($args_dash);


        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;

        $pgconf = array(
            'url' => base_url("supervisor/ero_dash"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
            )
        );


        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);

        //////////// Filter////////////

        $data['pg_rec_amb'] = ($this->post['pg_rec_amb']) ? $this->post['pg_rec_amb'] : $this->fdata['pg_rec_amb'];

        $ambflt['AMB'] = $data;

        //////////////////////////limit & offset//////

        $data['get_count'] = TRUE;

        // $data['amb_user_type']= 'tdd';
        $data['total_count'] = $this->amb_model->get_amb_data($data);

        $limit = ($data['pg_rec_amb']) ? $data['pg_rec_amb'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;


        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['AMB'] = $data;

        //$this->session->set_userdata('filters', $ambflt);
        /////////////////////////////////////////////////////


        unset($data['get_count']);

        $data['result'] = $this->amb_model->get_amb_data($data, $offset, $limit);


        $data['get_data'] = $this->amb_model->get_working_area();

        $data['cur_page'] = $page_no;
        $pgconf_amb = array(
            'url' => base_url("supervisor/ero_dash"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=amb"
            )
        );

        $config = get_pagination($pgconf_amb);
        $data['amb_pagination'] = get_pagination($pgconf_amb);
        $type = $this->post['type'];
        $this->output->add_to_position($this->load->view('frontend/supervisor/medical_dispatch_view', $data, TRUE), 'supervisor_container', TRUE);
    }


    public function ero_dash($generated = false) {
       // var_dump($this->post);die();
        $this->post = $this->input->post();
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');
        $data['filter_time'] = $this->post['filter_time'];
       // var_dump( $data['filter_time'] );die();
        $this->post['base_month'] = get_base_month();

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $data['call_search'] = ($this->post['call_search']) ? $this->post['call_search'] : $this->fdata['call_search'];
        $data['dist_search'] = ($this->post['dist_search']) ? $this->post['dist_search'] : $this->fdata['dist_search'];
        $data['amb_no_search'] = ($this->post['amb_no_search']) ? $this->post['amb_no_search'] : $this->fdata['amb_no_search'];
       
        //$this->pg_limit = 10;
        ///////////set page number////////////////////

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }


        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $args_dash = array(
            'base_month' => $this->post['base_month']
        );
        if ($data['call_search'] != '') {
            $args_dash['call_search'] = $data['call_search'];
        }

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        $data['get_count'] = TRUE;

       
        $inc_info = $this->call_model->get_inc_by_ero_dispatch($args_dash, $offset, $limit);

        $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->call_model->get_inc_by_ero_dispatch($args_dash);

        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;

        $pgconf = array(
            'url' => base_url("supervisor/ero_dash"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
            )
        );


        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);

        //////////// Filter////////////
        $data['rg_no'] = ($this->post['rg_no']) ? $this->post['rg_no'] : $this->fdata['rg_no'];
        $data['mob_no'] = ($this->post['mob_no']) ? $this->post['mob_no'] : $this->fdata['mob_no'];
        $data['pg_rec1'] = ($this->post['pg_rec1']) ? $this->post['pg_rec1'] : $this->fdata['pg_rec1'];

        $data['amb_search'] = ($this->post['call_']) ? $this->post['call_'] : $this->fdata['call_'];
        $data['pg_rec_amb'] = ($this->post['pg_rec_amb']) ? $this->post['pg_rec_amb'] : $this->fdata['pg_rec_amb'];

        $ambflt['AMB'] = $data;
        $data['get_count'] = TRUE;
        $data['amb_status'] = '2';
        $data['total_count2'] = $this->amb_model->get_busy_amb_data($data);
        $data['amb_total_count'] = $this->amb_model->get_busy_amb_data($data);



        $limit = ($data['pg_rec_amb']) ? $data['pg_rec_amb'] : $this->pg_limit;

        $page_no2 = get_pgno($data['total_count2'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no2 * $limit) - $limit;


        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['AMB'] = $data;

        $this->session->set_userdata('filters', $ambflt);


        /////////////////////////////////////////////////////


        unset($data['get_count']);

        $data['cur_page'] = $page_no2;
        $pgconf_amb = array(
            'url' => base_url("supervisor/ero_dash"),
            'total_rows' => $data['total_count2'],
            'per_page' => $limit,
            'cur_page' => $page_no2,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=amb"
            )
        );

        $config = get_pagination($pgconf_amb);
        $data['amb_pagination'] = get_pagination($pgconf_amb);
        $type = $this->post['type'];

        //////////// Filter////////////

        unset($data['get_count']);

        $data['amb_status'] = '2';
       
        $data['result'] = $this->amb_model->get_busy_amb_data($data, $offset, $limit);


        $data['district_data'] = $this->common_model->get_district(array('st_id' => 'MP'));




        //////////////// trial code ////////////////


        
        //////////// Filter////////////
        // $data['rg_no'] = ($this->post['rg_no']) ? $this->post['rg_no'] : $this->fdata['rg_no'];
        // $data['mob_no'] = ($this->post['mob_no']) ? $this->post['mob_no'] : $this->fdata['mob_no'];
        // $data['pg_rec1'] = ($this->post['pg_rec1']) ? $this->post['pg_rec1'] : $this->fdata['pg_rec1'];

        // $data['amb_search'] = ($this->post['call_']) ? $this->post['call_'] : $this->fdata['call_'];
        // $data['pg_rec_amb'] = ($this->post['pg_rec_amb']) ? $this->post['pg_rec_amb'] : $this->fdata['pg_rec_amb'];

        // $ambflt['AMB'] = $data;
        // $data['get_count'] = TRUE;
        // $data['amb_status'] = '2';
        // $data['total_count2'] = $this->amb_model->get_busy_amb_data($data);
        // $data['amb_total_count'] = $this->amb_model->get_busy_amb_data($data);



        // $limit = ($data['pg_rec_amb']) ? $data['pg_rec_amb'] : $this->pg_limit;

        // $page_no2 = get_pgno($data['total_count2'], $limit, $page_no);

        // $offset = ($page_no == 1) ? 0 : ($page_no2 * $limit) - $limit;


        // /////////////////////////////////////////////////////////

        // $data['page_no'] = $page_no;

        // $ambflt['AMB'] = $data;

        // $this->session->set_userdata('filters', $ambflt);


        /////////////////////////////////////////////////////


        // unset($data['get_count']);

        // $data['cur_page'] = $page_no2;
        // $pgconf_amb = array(
        //     'url' => base_url("supervisor/ero_dash"),
        //     'total_rows' => $data['total_count2'],
        //     'per_page' => $limit,
        //     'cur_page' => $page_no2,
        //     'attributes' => array('class' => 'click-xhttp-request',
        //         'data-qr' => "output_position=content&amp;pglnk=true&amp;type=amb"
        //     )
        // );

        // $config = get_pagination($pgconf_amb);
        // $data['amb_pagination'] = get_pagination($pgconf_amb);
        // $type = $this->post['type'];

        //////////// Filter////////////

        // unset($data['get_count']);

        // $data['amb_status'] = '2';
       
        // $data['result1'] = $this->amb_model->get_busy_amb_data_popup($data, $offset, $limit);

        // var_dump( $data['result1'] );die();
        // $data['district_data'] = $this->common_model->get_district(array('st_id' => 'MP'));


        //////////////////////////////////////  end trial code //////////

        if ($type == 'inc') {
            $this->output->add_to_position($this->load->view('frontend/supervisor/supervisor_dashboard_inc', $data, TRUE), 'content', TRUE);
        }
    }

    function police_dispatch() {

        $this->post = $this->input->post();
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');

        $this->post['base_month'] = get_base_month();

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        //$this->pg_limit = 10;
        ///////////set page number////////////////////

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }


       // $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
       $limit = ($data['pg_rec']) ? $data['pg_rec'] : 10;

        $args_dash = array(
            'base_month' => $this->post['base_month']
        );

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        
        $district_id = "";
        if($this->clg->clg_group ==  'UG-DM' ||$this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER' || $this->clg->clg_group == 'UG-BIKE-SUPERVISOR'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
            $args_dash['amb_district'] = $district_id;
            
        }

        $data['inc_info'] = $this->police_model->get_inc_by_police($args_dash, $offset, $limit);

        $inc_data = (object) array();

        $data['per_page'] = $limit;

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->police_model->get_inc_by_police($args_dash);


        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("police_calls/police_dash"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
            )
        );


        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);



        $this->output->add_to_position($this->load->view('frontend/supervisor/police_dispatch_view', $data, TRUE), 'supervisor_container', TRUE);

//        $this->output->add_to_position($this->load->view('frontend/supervisor/police_dispatch_view', $data, TRUE), 'supervisor_container', TRUE);
    }

    function fire_dispatch() {

        $this->post = $this->input->post();
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');
        $this->post['base_month'] = get_base_month();

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        ///////////set page number////////////////////

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }

        //$limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : 10;
        $args_dash = array(
            'base_month' => $this->post['base_month']
        );

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        
        $district_id = "";
        if($this->clg->clg_group ==  'UG-DM' ||$this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER' || $this->clg->clg_group == 'UG-BIKE-SUPERVISOR'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
        }

        $args_dash['amb_district'] = $district_id;

        $data['inc_info'] = $this->fire_model->get_inc_by_fire($args_dash, $offset, $limit);
        $inc_data = (object) array();
        $data['per_page'] = $limit;
        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->fire_model->get_inc_by_fire($args_dash);
        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("fire_calls/fire_dash"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
            )
        );

        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);
        $this->output->add_to_position($this->load->view('frontend/supervisor/fire_dispatch_view', $data, TRUE), 'supervisor_container', TRUE);
    }

    function other_calls() {

        $this->post = $this->input->post();
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');

        $this->post['base_month'] = get_base_month();

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $data['call_search'] = ($this->post['call_search']) ? $this->post['call_search'] : $this->fdata['call_search'];

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }


       // $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : 10;
        $args_dash = array(
            'base_month' => $this->post['base_month'],
            'inc_sup_remark_status'=> '0'
        );


        if ($data['call_search'] != '') {
            $args_dash['call_search'] = $data['call_search'];
        }
//        $args_dash['to_date'] = date('Y-m-d');
//        $args_dash['from_date'] = date('Y-m-d');
         
        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        $district_id = "";
        if($this->clg->clg_group ==  'UG-DM' ||$this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER' || $this->clg->clg_group == 'UG-BIKE-SUPERVISOR'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
        }
        $args_dash['amb_district'] = $district_id;

        $inc_info = $this->call_model->get_terminate_inc_by_ero($args_dash, $offset, $limit);

        $inc_data = (object) array();
        $data['per_page'] = $limit;
        $data['inc_info'] = $inc_info;

        $args_dash['get_count'] = TRUE;
        $total_cnt = $this->call_model->get_terminate_inc_by_ero($args_dash);


        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("supervisor/other_calls"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
            )
        );

        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);
        $this->output->add_to_position($this->load->view('frontend/supervisor/other_calls_view', $data, TRUE), 'supervisor_container', TRUE);
    }

    function assign_ambulance_list() {

        //////////// Filter////////////

        $data['rg_no'] = ($this->post['rg_no']) ? $this->post['rg_no'] : $this->fdata['rg_no'];
        $data['mob_no'] = ($this->post['mob_no']) ? $this->post['mob_no'] : $this->fdata['mob_no'];
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $data['amb_search'] = ($this->post['call_search']) ? $this->post['call_search'] : $this->fdata['call_search'];
        $data['dist_search'] = ($this->post['dist_search_assign']) ? $this->post['dist_search_assign'] : $this->fdata['dist_search_assign'];
        $data['amb_no_search'] = ($this->post['amb_no_search_assign']) ? $this->post['amb_no_search_assign'] : $this->fdata['amb_no_search_assign'];
        $ambflt['AMB'] = $data;
        // amb_no_search_assign
        ///////////set page number////////////////////
        $page_no = 1;
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        //////////////////////////limit & offset//////
        $district_id = "";
        if($this->clg->clg_group ==  'UG-DM' ||$this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER' || $this->clg->clg_group == 'UG-BIKE-SUPERVISOR'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
        }
        
        $data['assign_amb_district'] = $district_id;
        $data['get_count'] = TRUE;
        $data['amb_status'] = '2';
        $current_date =date('Y-m-d H:i:s');
        $newdate = date('Y-m-d H:i:s',strtotime ( '-24 hour' , strtotime($current_date))) ;
        $data['from_date'] =$newdate ;
        $data['to_date'] =$current_date;
        $data['total_count'] = $this->amb_model->get_busy_amb_data($data);
        //$limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : 10;
        $page_no = get_pgno($data['total_count'], $limit, $page_no);
        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['AMB'] = $data;

        $this->session->set_userdata('filters', $ambflt);

        /////////////////////////////////////////////////////

        unset($data['get_count']);

        $data['amb_status'] = '2';
        $data['result'] = $this->amb_model->get_busy_amb_data($data, $offset, $limit);
        $data['get_data'] = $this->amb_model->get_working_area();
        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("supervisor/assign_ambulance_list"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );
        // total_count
        $data['clg_group'] = $this->clg->clg_group;
        $data['amb_pagination'] = get_pagination($pgconf);
        $data['district_data'] = $this->common_model->get_district(array('st_id' => 'MP'));
        $data['closure_pending_count'] =  count($this->amb_model->get_closure_pending());
        $data['zero_to_two'] =  count($this->amb_model->get_closure_pending_0_2());
        $data['two_to_six'] =  count($this->amb_model->get_closure_pending_2_6());
        $data['six_to_twelve'] =  count($this->amb_model->get_closure_pending_6_12());
        $data['twelve_to_eighteen'] =  count($this->amb_model->get_closure_pending_12_18());
        $data['eighteen_to_twenty_four'] =  count($this->amb_model->get_closure_pending_18_24());
        $data['more_than_twenty_four'] =  count($this->amb_model->get_closure_pending_24_more());
        $this->output->add_to_position($this->load->view('frontend/supervisor/assign_ambulance_list_view', $data, TRUE), 'supervisor_container_amb', TRUE);
    }
    function download_assign_ambulance_list() {

        //////////// Filter////////////

        $data['rg_no'] = ($this->post['rg_no']) ? $this->post['rg_no'] : $this->fdata['rg_no'];
        $data['mob_no'] = ($this->post['mob_no']) ? $this->post['mob_no'] : $this->fdata['mob_no'];
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $data['amb_search'] = ($this->post['call_search']) ? $this->post['call_search'] : $this->fdata['call_search'];
        $data['dist_search'] = ($this->post['dist_search_assign']) ? $this->post['dist_search_assign'] : $this->fdata['dist_search_assign'];
        $data['amb_no_search'] = ($this->post['amb_no_search_assign']) ? $this->post['amb_no_search_assign'] : $this->fdata['amb_no_search_assign'];
        $ambflt['AMB'] = $data;
        // amb_no_search_assign
        ///////////set page number////////////////////
        $page_no = 1;
        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }
        //////////////////////////limit & offset//////

        $data['get_count'] = TRUE;
        $data['amb_status'] = '2';
        $report_data = $this->amb_model->get_busy_amb_data($data);
        
        $header = array('Sr.No','Ambulance No','Last assign time','Base Location','District','Ambulance Type','Incident ID','Incident Address','Caller Number-Name','Chief Complaint','Closure Pending From');
        
         $filename = "assign_ambulance_list.csv";
            $fp = fopen('php://output', 'w');

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);
            $data = array();


            foreach ($report_data as $key=>$inc) {
                 $inc_data = array(
                    'inc_ref_id' => $row['inc_ref_id'],
                    'clr_mobile' => $row['clr_mobile'],
                    'call_dis_time' => $call_recived_time,
                    'amb_reach_time' => date('H:i:s', strtotime($driver_data[0]->dp_on_scene)),
                    'responce_time' =>  date('H:i:s', strtotime($resonse_time)),
                    'respond_amb_no' => $transport_respond_amb_no,
                    'respond_amb_base' => $transport_respond_base,
                    'inc_address' => $row['inc_address'],
                    'hospital' => $hp_name,
                    //'code_no_hos'        => $hp_data[0]->hp_register_no,
                    'amb_type' => $amb_type,
                );
               // var_dump($inc_data);
                fputcsv($fp,$inc_data);
                
            }
            fclose($fp);
            exit;
  
    }

    function available_ambulance_list() {
        //////////// Filter////////////

        $data['rg_no'] = ($this->post['rg_no']) ? $this->post['rg_no'] : $this->fdata['rg_no'];
        $data['mob_no'] = ($this->post['mob_no']) ? $this->post['mob_no'] : $this->fdata['mob_no'];
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $data['amb_search'] = ($this->post['call_search']) ? $this->post['call_search'] : $this->fdata['call_search'];
        $data['dist_search'] = ($this->post['dist_search_assign']) ? $this->post['dist_search_assign'] : $this->fdata['dist_search_assign'];
        $data['amb_no_search'] = ($this->post['amb_no_search_assign']) ? $this->post['amb_no_search_assign'] : $this->fdata['amb_no_search_assign'];
    
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

        $data['amb_status'] = '1';
        
        $district_id = "";
        if($this->clg->clg_group ==  'UG-DM' ||$this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER' || $this->clg->clg_group == 'UG-BIKE-SUPERVISOR'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
        }
        $data['amb_district'] = $district_id;
        $current_date =date('Y-m-d H:i:s');
        $newdate = date('Y-m-d H:i:s',strtotime ( '-24 hour' , strtotime($current_date))) ;
        $data['from_date'] =$newdate ;
        $data['to_date'] =$current_date;
        $data['total_count'] = $this->amb_model->get_avialable_amb_data($data);

        //$limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : 10;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['AMB'] = $data;

        $this->session->set_userdata('filters', $ambflt);

        /////////////////////////////////////////////////////

        unset($data['get_count']);
        $data['amb_status'] = '1';
        $data['result'] = $this->amb_model->get_avialable_amb_data($data, $offset, $limit);

       // $data['get_data'] = $this->amb_model->get_working_area();

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("supervisor/available_ambulance_list"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        $data['pagination'] = get_pagination($pgconf);
        $data['district_data'] = $this->common_model->get_district(array('st_id' => 'MP'));
        $this->output->add_to_position($this->load->view('frontend/supervisor/available_ambulance_list_view', $data, TRUE), 'supervisor_container_amb', TRUE);
    }

    function other_ambulance_list() {
        //////////// Filter////////////

        $data['rg_no'] = ($this->post['rg_no']) ? $this->post['rg_no'] : $this->fdata['rg_no'];
        $data['mob_no'] = ($this->post['mob_no']) ? $this->post['mob_no'] : $this->fdata['mob_no'];
        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $data['amb_search'] = ($this->post['call_search']) ? $this->post['call_search'] : $this->fdata['call_search'];
        $data['dist_search'] = ($this->post['dist_search_other']) ? $this->post['dist_search_other'] : $this->fdata['dist_search_other'];
        $data['amb_no_search'] = ($this->post['amb_no_search_other']) ? $this->post['amb_no_search_other'] : $this->fdata['amb_no_search_other'];
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
        $data['amb_status'] = "'3','4','6','7','8','9','10','11','12','13'";
        
        $district_id = "";
        if($this->clg->clg_group ==  'UG-DM' ||$this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER' || $this->clg->clg_group == 'UG-BIKE-SUPERVISOR'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
        }
        $data['amb_district'] = $district_id;
        $current_date =date('Y-m-d H:i:s');
        $newdate = date('Y-m-d H:i:s',strtotime ( '-24 hour' , strtotime($current_date))) ;
        $data['from_date'] =$newdate ;
        $data['to_date'] =$current_date;
        $data['total_count'] = $this->amb_model->get_avialable_amb_data($data);

        //$limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : 10;
        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $ambflt['AMB'] = $data;

        $this->session->set_userdata('filters', $ambflt);

        /////////////////////////////////////////////////////

        unset($data['get_count']);
        $data['amb_status'] = "'3','4','6','7','8','9','10','11','12','13'";
        $data['result'] = $this->amb_model->get_avialable_amb_data($data, $offset, $limit);

        //$data['get_data'] = $this->amb_model->get_working_area();

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("supervisor/other_ambulance_list"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );
      //  $data['result'] 
        $data['pagination'] = get_pagination($pgconf);
        $data['district_data'] = $this->common_model->get_district(array('st_id' => 'MP'));
        $this->output->add_to_position($this->load->view('frontend/supervisor/other_ambulance_list_view', $data, TRUE), 'supervisor_container_amb', TRUE);
    }

    function remark() {


        $data['amb_rto_register_no'] = $this->input->get('amb_rto_register_no');
        $data['inc_ref_id'] = $this->input->get('inc_ref_id');

        $this->output->add_to_position($this->load->view('frontend/supervisor/supervisor_remark_view', $data, TRUE), $output_position, TRUE);
    }

    function release() {

        $data['amb_rto_register_no'] = $this->input->get('amb_rto_register_no');
        $data['inc_ref_id'] = $this->input->get('inc_ref_id');
        $this->output->add_to_position($this->load->view('frontend/supervisor/supervisor_release_view', $data, TRUE), $output_position, TRUE);
    }

    function terminate_calls() {


        $data['amb_rto_register_no'] = $this->input->get('amb_rto_register_no');
        $data['inc_ref_id'] = $this->input->get('inc_ref_id');

        $this->output->add_to_position($this->load->view('frontend/supervisor/supervisor_ter_remark_view', $data, TRUE), $output_position, TRUE);
    }

    function other_call_action() {

        $data['inc_ref_id'] = $this->input->get('inc_ref_id');

        $this->output->add_to_position($this->load->view('frontend/supervisor/supervisor_complete_action_view', $data, TRUE), $output_position, TRUE);
    }

    function save_terminate_call_remark() {

        $data = array(
            'inc_remark' => $this->input->post('inc_remark'),
            'inc_ref_id' => $this->input->post('inc_ref_id'),
            'inc_is_closed' => '1'
        );

  
        $tcl_id = $this->inc_model->update_incident($data);


        if ($tcl_id) {
            

            $this->output->status = 1;

            $this->output->closepopup = "yes";

            $this->output->message = "<h3>Remark </h3><br><p>added successfully.</p>";

            $this->output->moveto = 'top';
            $this->terminate_list();

            //$this->output->add_to_position('', 'content', TRUE);
        }
    }

    function save_remark() {

        $data = array(
            's_base_month' => $this->post['base_month'],
            'supervisor_remark' => $this->input->post('supervisor_remark'),
            's_date' => date('Y-m-d H:i:s'),
            's_isdeleted' => '0',
            's_added_by' => $this->clg->clg_ref_id,
            's_inc_ref_id' => $this->input->post('inc_ref_id'),
            'amb_rto_register_no' => $this->input->post('amb_rto_register_no')
        );

        $tcl_id = $this->amb_model->insert_amb_supervisor_remark($data);

//        $data = array(
//            'inc_remark' => $this->input->post('supervisor_remark'),
//            'inc_ref_id' => $this->input->post('inc_ref_id'),
//            'inc_is_closed' => '1'
//        );
//
//        $res = $this->inc_model->update_incident($data);


        if ($tcl_id) {

            $this->output->status = 1;

            $this->output->closepopup = "yes";

            $this->output->message = "<h3>Remark </h3><br><p>added successfully.</p>";

          // $this->output->moveto = 'top';

           // $this->output->add_to_position('', 'content', TRUE);
        }
    }

    function save_release() {

        $data = array(
            'r_amb_rto_register_no' => $this->input->post('amb_rto_register_no'),
            'r_inc_ref_id' => $this->input->post('inc_ref_id'),
            'r_release_remark' => $this->input->post('supervisor_release'),
            'r_date' => date('Y-m-d H:i:s'),
            'r_isdeleted' => '0',
            'r_base_month' => $this->post['base_month'],
            'r_added_by' => $this->clg->clg_ref_id
           
        );


        $tcl_id = $this->amb_model->insert_amb_release_data($data);

        $amb_data = array(
            'r_amb_rto_register_no' => $this->input->post('amb_rto_register_no'),
            // 'r_inc_ref_id' => $this->input->post('inc_ref_id'),
            // 'r_release_remark' => $this->input->post('supervisor_release'),
           // 'r_date' => date('Y-m-d H:i:s'),
            'amb_status' => '1',
            // 'r_base_month' => $this->post['base_month'],
            // 'r_added_by' => $this->clg->clg_ref_id
           
        );
        $tcl_id = $this->amb_model->update_amb_release_data($amb_data);

//        $data = array(
//            'inc_remark' => $this->input->post('supervisor_remark'),
//            'inc_ref_id' => $this->input->post('inc_ref_id'),
//            'inc_is_closed' => '1'
//        );
//
//        $res = $this->inc_model->update_incident($data);


        if ($tcl_id) {

            $this->output->status = 1;

            $this->output->closepopup = "yes";

            $this->output->message = "<h3>Ambulance </h3><br><p>Release successfully.</p>";

          // $this->output->moveto = 'top';

           // $this->output->add_to_position('', 'content', TRUE);
        }
    }

    function delete_record() {

        $data = array(
            'inc_sup_remark_status' => '1',
            'inc_ref_id' => $this->input->post('inc_ref_id'),
        );

        $args = array(
            's_base_month' => $this->post['base_month'],
            'supervisor_remark' => $this->input->post('supervisor_remark'),
            's_date' => date('Y-m-d H:i:s'),
            's_isdeleted' => '0',
            's_added_by' => $this->clg->clg_ref_id,
            's_inc_ref_id' => $this->input->post('inc_ref_id'),
        );
        $tcl_id1 = $this->amb_model->insert_amb_supervisor_remark($args);



        $tcl_id = $this->inc_model->update_incident($data);


        if ($tcl_id) {

            $this->output->status = 1;

            $this->output->closepopup = "yes";

            $this->output->message = "<p>Remark Save Successfully .</p><script>$('#supervisor_other_call').click();</script>";
        }
    }

    function police_incident_calls() {

        $this->post = $this->input->post();
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');

        $this->post['base_month'] = get_base_month();

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];



        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }


        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


        $data = array(
            'base_month' => $this->post['base_month']
        );

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;
        $data['call_search'] = ($this->post['call_search']) ? $this->post['call_search'] : $this->fdata['call_search'];


        $data['page_no'] = $page_no;

        $data['inc_info'] = $this->police_model->get_inc_by_police($data, $offset, $limit);

        $inc_data = (object) array();

        $data['per_page'] = $limit;

        $data['get_count'] = TRUE;
        $total_cnt = $this->police_model->get_inc_by_police($data);


        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("police_calls/police_dash"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
            )
        );


        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);

        $this->output->add_to_position($this->load->view('frontend/supervisor/inc_police_dispatch_view', $data, TRUE), 'calls_inc_list', TRUE);

//        $this->output->template = "calls";
    }

    function police_manual_calls() {

        $this->post = $this->input->post();
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');

        $this->post['base_month'] = get_base_month();

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        //$this->pg_limit = 10;
        ///////////set page number////////////////////

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }


        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


        $data = array(
            'base_month' => $this->post['base_month']
        );

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        $data['call_search'] = ($this->post['call_search']) ? $this->post['call_search'] : $this->fdata['call_search'];
        
        $district_id = "";
        if($this->clg->clg_group ==  'UG-DM' ||$this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER' || $this->clg->clg_group == 'UG-BIKE-SUPERVISOR'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
        }
        $data['amb_district'] = $district_id;

        $data['inc_info'] = $this->police_model->get_inc_by_manual_police_call($data, $offset, $limit);

        $inc_data = (object) array();

        $data['per_page'] = $limit;

        $data['get_count'] = TRUE;
        $total_cnt = $this->police_model->get_inc_by_manual_police_call($data);


        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("police_calls/police_dash"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
            )
        );


        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);


        $this->output->add_to_position($this->load->view('frontend/supervisor/manual_police_dispatch_view', $data, TRUE), 'calls_inc_list', TRUE);
    }

    function fire_incident_calls() {

        $this->post = $this->input->post();
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');

        $this->post['base_month'] = get_base_month();

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        ///////////set page number////////////////////

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }


        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


        $data = array(
            'base_month' => $this->post['base_month']
        );

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        
           $data['call_search'] = ($this->post['call_search']) ? $this->post['call_search'] : $this->fdata['call_search'];

        $data['inc_info'] = $this->fire_model->get_inc_by_fire($data, $offset, $limit);


        $inc_data = (object) array();

        $data['per_page'] = $limit;

        $data['get_count'] = TRUE;
        $total_cnt = $this->fire_model->get_inc_by_fire($data);


        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("fire_calls/fire_dash"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
            )
        );

        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);



        $this->output->add_to_position($this->load->view('frontend/supervisor/inc_fire_dispatch_view', $data, TRUE), 'calls_inc_list', TRUE);
    }

    function fire_manual_calls() {

        $this->post = $this->input->post();
        $get_data = $this->input->get();
        $get_data = $this->input->get('type');

        $this->post['base_month'] = get_base_month();

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        //$this->pg_limit = 10;
        ///////////set page number////////////////////

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }


        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


        $data = array(
            // 'operator_id' => $this->clg->clg_ref_id,
            'base_month' => $this->post['base_month']
        );

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        
        $data['call_search'] = ($this->post['call_search']) ? $this->post['call_search'] : $this->fdata['call_search'];
        
        $district_id = "";
        if($this->clg->clg_group ==  'UG-DM' ||$this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER' || $this->clg->clg_group == 'UG-BIKE-SUPERVISOR'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
        }
        $data['amb_district'] = $district_id;

        $data['inc_info'] = $this->fire_model->get_inc_by_fire_manual_calls($data, $offset, $limit);



        $inc_data = (object) array();

        $data['per_page'] = $limit;


        $data['get_count'] = TRUE;
        $total_cnt = $this->fire_model->get_inc_by_fire_manual_calls($data);


        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


           $pgconf = array(
            'url' => base_url("supervisor/fire_manual_calls"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
            )
        );


        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);

        
        $this->output->add_to_position($this->load->view('frontend/supervisor/manual_fire_dispatch_view', $data, TRUE), 'calls_inc_list', TRUE);
    }

    function terminate_list() {

        $this->post = $this->input->post();
        $data = array();


        $get_data = $this->input->get();
        $get_data = $this->input->get('type');

        $this->post['base_month'] = get_base_month();

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        //$data['call_search'] = ($this->post['call_search']) ? $this->post['call_search'] : $this->fdata['call_search'];
        $data['call_search'] = ($this->post['call_search']);

        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }


        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


        $data['base_month'] = $this->post['base_month'];
        

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        $inc_info = $this->call_model->get_terminate_inc($data, $offset, $limit);


        $inc_data = (object) array();

        $data['per_page'] = $limit;

        $data['inc_info'] = $inc_info;

        $data['get_count'] = TRUE;
        $total_cnt = $this->call_model->get_terminate_inc($data);


        $data['inc_total_count'] = $total_cnt;
        $data['inc_offset'] = $offset;
        $data['per_page'] = $limit;


        $pgconf = array(
            'url' => base_url("supervisor/terminate_list"),
            'total_rows' => $total_cnt,
            'per_page' => $limit,
            'cur_page' => $page_no,
            'uri_segment' => 3,
            'use_page_numbers' => TRUE,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true&amp;type=inc"
            )
        );


        $config = get_pagination($pgconf);
        $data['pagination'] = get_pagination($pgconf);



        $this->output->add_to_position($this->load->view('frontend/supervisor/terminate_call_dashboard_view', $data, TRUE), 'content', TRUE);
    }

        function get_closure_validate(){
            $data['dist'] = $this->common_model->get_district(array('st_id' => 'MP','district_id' =>$data['district_id']));

            $this->output->add_to_position($this->load->view('frontend/supervisor/validate_closure_view', $data, TRUE), 'content', TRUE);

        }
        function get_validate_count(){
            $data['dist'] = $this->common_model->get_district(array('st_id' => 'MP','district_id' =>$data['district_id']));
            
            $amb_district =  $this->input->post('amb_district');

            $args = array('district_id' => $amb_district);
            $data['dis_data'] = $this->reports_model->get_dipatch_count($args);

            $args = array('district_id' => $amb_district);
            $data['clo_data'] = $this->reports_model->get_closure_data_count($args);

            $args = array('district_id' => $amb_district);
            $data['mdt_data'] = $this->reports_model->get_mdt_clo_count($args);

            $args = array('district_id' => $amb_district);
            $data['dco_data'] = $this->reports_model->get_dco_clo_count($args);

            $args = array('district_id' => $amb_district);
            $data['val_data'] = $this->reports_model->get_val_clo_count($args);

            $this->output->add_to_position($this->load->view('frontend/supervisor/validate_closure_view', $data, TRUE), 'report_data_view_details', TRUE);

        }



}
