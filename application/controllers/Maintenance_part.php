<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance_part extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->active_module = "M-MAINTENANCE-PART";

        $this->pg_limit = $this->config->item('pagination_limit_clg');

        $this->pg_limit = 50;
        $this->load->model(array('maintenance_part_model','amb_model'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date'));
        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules', 'simple_excel/Simple_excel'));

        $this->post['base_month'] = get_base_month();
        $this->site_name = $this->config->item('site_name');
        $this->site = $this->config->item('site');
        $this->post = $this->input->get_post(NULL);

        $this->clg = $this->session->userdata('current_user');
           $this->today = date('Y-m-d H:i:s');
           $this->default_state = $this->config->item('default_state');
           $this->post['base_month'] = get_base_month();
    }
    
    function request_maintenance_part(){
        ///////////////  Filters //////////////////

        $data['search'] = ($this->post['search']) ? $this->post['search'] : $this->fdata['search'];

        if ($this->post['from_date'] != '') {
            $data['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date']));
        }

        if ($this->post['to_date'] != '') {
            $data['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->post['to_date']));
        }

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];


        $page_no = 1;

        if ($this->uri->segment(3)) {
            $page_no = $this->uri->segment(3);
        } else if ($this->fdata['page_no'] && !$this->post['flt']) {
            $page_no = $this->fdata['page_no'];
        }

        ///////////limit & offset////////

        $data['get_count'] = TRUE;

        if ($this->post['from_date'] != '') {

            $data['from_date'] = date('Y-m-d', strtotime($this->post['from_date']));
        } else {

//            $data['from_date'] = date('Y-m-d');
        }


        if ($this->post['to_date'] != '') {
            $data['to_date'] = date('Y-m-d', strtotime($this->post['to_date']));
        } else {
//            $data['to_date'] = date('Y-m-d');
        }



        $data['total_count'] = $this->maintenance_part_model->get_all_maintenance_part($data);


        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        unset($data['get_count']);


        $data['indent_data'] = $this->maintenance_part_model->get_all_maintenance_part($data,$offset,$limit);
 
       // die();

        $data['clg_group'] = trim($this->clg->clg_group);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("maintenance_part/request_maintenance_part"),
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

        $data['page_records'] = count($data['indent_data']);


        $this->output->add_to_position($this->load->view('frontend/maintenance_part/maintenance_part_request_list_view', $data, true), 'content', true);
       $this->output->add_to_position($this->load->view('frontend/maintenance_part/maintenance_part_request_list_view', $data, true), 'content', true);

        //$this->output->add_to_position($this->load->view('frontend/maintenance_part/date_filter_view', $data, true), 'date_filter', true);
    }
    function maintenance_part_request_registrartion(){
         

        if ($this->post['action'] == 'Update') {


            $data['action_type'] = "Update Material Requirement Request";
            $data['type'] = "Update";
            $data['update'] = 'True';
            
            if ($this->post['req_id'] != '') {
                $data['req_id'] = $ref_id = $this->post['req_id'];
                $data['indent_data'] = $this->maintenance_part_model->get_all_maintenance_part($data);
            }

            $data1['req_id'] = $this->post['req_id'];

            $data['result'] = $this->maintenance_part_model->get_item_maintenance_part_data($data1);

            $this->output->add_to_position($this->load->view('frontend/maintenance_part/maintenance_part_request_register_view', $data, TRUE), $output_position, TRUE);
        } else {

            $data['action_type'] = "Add Material Requirement Request";

            $this->output->add_to_popup($this->load->view('frontend/maintenance_part/maintenance_part_request_register_view', $data, TRUE), '1000', '500');
           $this->output->add_to_position('<script>reset_mi_cookie();</script>', 'custom_script', TRUE);

        }
    }
        function maintenance_part_request_save() {

        $item_key = array('Force_BSIII', 'Force_BSIV','Ashok_Leyland_BSIV');

        ////////////////////////////////////////////////

        $eflag = "Yes";

        foreach ($item_key as $key) {

            if (is_array($this->post['req'][$key])) {

                foreach ($this->post['req'][$key] as $item) {

                    if ($item['id'] != '') {
                        $eflag = "No";
                    }
                }
            }
        }

        if ($eflag == "Yes") {
            $this->output->message = "<div class='error'>Please request for atleast one item.</div>";

            return false;
        }

        ////////////////////////////////////////////////


       //if ($this->clg->clg_group == 'UG-FleetManagement' || $this->clg->clg_group == 'UG-HEALTH-SUP') {

           // $emt_id = $this->clg->clg_ref_id;
        //}

        $ind_data = $this->post['ind'];

        $args = array(
            //'req_emt_id' => $emt_id,
            'req_date' => $this->today,
            'req_base_month' => $this->post['base_month'],
            'req_by' => $this->clg->clg_ref_id,
            'req_state_code' => $this->input->post('incient_state'),
            'req_amb_reg_no' => $this->input->post('incient_ambulance'),
            'req_district_code' => $this->input->post('incient_district'),
            'req_base_location'=>$this->input->post('base_location'),
            'previous_odometer'=>$this->input->post('previous_odometer'),
            'current_odometer'=>$this->input->post('in_odometer'),
           // 'req_shift_type' => $ind_data['req_shift_type'],
            'req_expected_date_time' => date('Y-m-d H:i:s', strtotime($ind_data['req_expected_date_time'])),
            //'req_district_manager' => $ind_data['req_district_manager'],
            'req_standard_remark' => 'Maintenance Part Request send sucessfully',
          //  'req_supervisor' => $ind_data['req_supervisor'],
            'req_isdeleted' => '0',
        );

        if ($ind_data['req_other_remark'] != '') {
            $args['req_other_remark'] = $ind_data['req_other_remark'];
        }

        $req = $this->maintenance_part_model->insert_maintenance_part($args);
        $total_km = (int)$this->input->post('in_odometer') - (int)$this->input->post('previous_odometer');
        $amb_record_data = array(
            'amb_rto_register_no' => $this->input->post('incient_ambulance'),
            'start_odmeter' => $this->input->post('previous_odometer'),
            'end_odmeter' => $this->input->post('in_odometer'),
            'total_km' => $total_km,
            'odometer_type'   => 'Maintenance Part Request send',
            'timestamp' => date('Y-m-d H:i:s'));

        if (!empty($maintaince_data['mt_off_remark'])) {
            $amb_record_data['other_remark'] = $maintaince_data['mt_off_remark'];
        }
        $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);

        foreach ($item_key as $key) {
            if (is_array($this->post['req'][$key])) {

                foreach ($this->post['req'][$key] as $dt) {



                    if (!empty($dt['id'])) {

                          $ind_data = array(
                            'ind_item_id' => $dt['id'],
                            'ind_quantity' => $dt['qty'],
                            'ind_item_type' => $key,
                            'ind_req_id' => $req,
                        );


                        $result = $this->maintenance_part_model->maintenance_part_item($ind_data);
                    }
                }
            }
        }

        if ($result) {

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Maintenance Part request submit successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->request_maintenance_part();
        }
    }
    //////////////MI44//// Purpose:View Indent Details/////////

    function view_maintenance_part_details() {


        if ($this->post['req_id'] != '') {
            $data['req_id'] = $ref_id = base64_decode($this->post['req_id']);
            $data['indent_data'] = $this->maintenance_part_model->get_all_maintenance_part($data);
        }

        $data1['req_id'] = base64_decode($this->post['req_id']);
         $data1['amb_no'] = base64_decode($this->post['amb_no']);
       // var_dump($data1['req_id']);
        $data['result'] = $this->maintenance_part_model->get_item_maintenance_part_data($data1);
//        var_dump($data['result']);
//        die();
        $data['clg_group'] = $this->clg->clg_group;
        $data['action'] = $this->post['action'];
      

        $data['amb_no'] = $this->post['amb_no'];
        $data['radmin'] = ($data['action'] == 'rec' && $data['clg_group'] == 'UG-ADMIN') ? 'radmin' : '';
//        var_dump($this->post['action']);
//        die();

        if ($this->post['action'] == 'rec') {
            $data['action_type'] = 'Receive Maintenance Part';
        } elseif ($this->post['action'] == 'view') {
            $data['action_type'] = 'View Maintenance Part';
        } elseif ($this->post['action'] == 'apr') {
            $data['action_type'] = 'Approve Maintenance Part';
        }  elseif ($this->post['action'] == 'Update') {
            $data['action_type'] = 'Update Maintenance Part';
        } else {
            $data['action_type'] = 'Dispatch Maintenance Part';
        }

        $this->output->add_to_position($this->load->view('frontend/maintenance_part/view_maintenance_part_details', $data, TRUE), '', TRUE);
    }
        function approve_maintenance_part() {



            $req_type = $this->post['req_type'];
            

            foreach ($this->post['apr_qty'] as $ind_id => $qty) {

                $args = array(
                    'ind_id' => $ind_id,
                );


                $data = array(
                    'ind_apr_qty' => $qty,
                    'ind_req_id' => $this->post['ind_req_id']
                );

                $this->maintenance_part_model->update_maintenance_part_item($args, $data);


            }


            /////////////////////////////////////////////////////////

            $ind_data = $this->post['eqiup'];

            $args = array(
            'req_id' => $this->post['req_id'],
            'req_is_approve' => '1',
            'req_apr_date_time' => date('Y-m-d H:i:s', strtotime($req_type['req_apr_date_time'])),
            'req_approve_remark' => $req_type['req_approve_remark']
        );


        $req = $this->maintenance_part_model->update_maintenance_part_req($args);


            /////////////////////////////////////////////////////

            $this->output->status = 1;

            $this->output->closepopup = "yes";

            $this->output->message = "<h3>Approve Maintenance Part Items</h3><br><p>Items Approve Successfully</p>";

            $this->request_maintenance_part();
        }
        function dispatch_maintenance_part() {

        if ($this->post['ind_opt']) {


            $req_type = $this->post['req_type'];

            foreach ($this->post['dis_qty'] as $ind_id => $qty) {

                $args = array(
                    'ind_id' => $ind_id,
                );


                $data = array(
                    'ind_dis_qty' => $qty,
                    'ind_req_id' => $this->post['ind_req_id']
                );

                $this->maintenance_part_model->update_maintenance_part_item($args, $data);


                /////////////////////////////////////////////////////////

                $ind_data = $this->maintenance_part_model->get_maintenance_part_item($args);
              


                $args = array(
                    'stk_inv_id' => $ind_data[0]->ind_item_id,
                    'stk_inv_type' => $ind_data[0]->ind_item_type,
                    'stk_handled_by' => $this->clg->clg_ref_id,
                    'stk_in_out' => 'out',
                    'stk_qty' => $qty,
                    'stk_date' => $this->today,
                    'stk_base_month' => $this->post['base_month']
                );


                $this->maintenance_part_model->insert_maintenance_part_warehouse_stock($args);
            }


            /////////////////////////////////////////////////////////

            $ind_data = $this->post['eqiup'];

            $args = array(
                'req_id' => $this->post['ind_req_id'],
                'req_dis_by' => $this->clg->clg_ref_id,
                'req_dis_date' => $this->today,
                'req_dispatch_date_time' => date('Y-m-d H:i:s', strtotime($ind_data['req_dispatch_date_time'])),
                'req_dispatch_remark' => $ind_data['req_dispatch_remark']
            );


            $req = $this->maintenance_part_model->update_maintenance_part_req($args);


            /////////////////////////////////////////////////////

            $this->output->status = 1;

            $this->output->closepopup = "yes";

            $this->output->message = "<h3>Dispatch Maintenance Part Items</h3><br><p>Items dispatched successfully</p>";

            $this->request_maintenance_part();
        }
    }
    function receive_maintenance_part() {

        if ($this->post['ind_opt']) {

            $req_type = $this->post['eqiup'];

            $args = array(
                'req_id' => $this->post['ind_req_id'],
                'req_rec_by' => $this->clg->clg_ref_id,
                'req_rec_date' => $this->today,
                'req_receive_date_time' => date('Y-m-d H:i:s', strtotime($req_type['req_receive_date_time'])),
                'req_receive_remark' => $req_type['req_receive_remark']
            );

            $req = $this->maintenance_part_model->update_maintenance_part_req($args);



            ////////////////////////////////////////////////////

            foreach ($this->post['rec_qty'] as $ind_id => $qty) {

                $args = array(
                    'ind_id' => $ind_id,
                );

                $data = array(
                    'ind_rec_qty' => $qty,
                    'ind_req_id' => $this->post['ind_req_id']
                );



                $this->maintenance_part_model->update_maintenance_part_item($args, $data);
                
                //die();

                /////////////////////////////////////////////////////

                //$ind = $this->ind_model->get_ind_data(array('ind_id' => $ind_id));
                $ind = $this->maintenance_part_model->get_maintenance_part_item(array('ind_id'=>$ind_id));
             



                /////////////////////////////////////////////////////

                $args = array(
                    'as_item_id' => $ind[0]->ind_item_id,
                    'as_item_type' => $ind[0]->ind_item_type,
                    'as_stk_in_out' => 'in',
                    'as_item_qty' => $qty,
                    'as_sub_id' => $this->post['ind_req_id'],
                    'as_sub_type' => 'maintenance',
                    'as_date' => $this->today,
                    'as_amb_reg_no' => $this->post['amb_reg_no'],             
                    'as_district_id' => $this->post['dst_code'],
                    'as_base_month' => $this->post['base_month'],
                );

                $this->maintenance_part_model->insert_maintenance_part_stock($args);
            }
          

            /////////////////////////////////////////////////////

            $this->output->status = 1;

            $this->output->closepopup = "yes";

            $this->output->message = "<h3>Receive Items</h3><br><p>Items received successfully</p>";

            $this->request_maintenance_part();
        }
    }
    function list_maintenance_part(){
              //////////////////////// Filters operations ///////////////////////////


        $data['inv_type'] = ($this->post['inv_type']) ? trim($this->post['inv_type']) : $this->fdata['inv_type'];

        $data['inv_man'] = (isset($this->post['inv_man'])) ? trim($this->post['inv_man']) : $this->fdata['inv_man'];

        $data['inv_amb'] = (isset($this->post['inv_amb'])) ? trim($this->post['inv_amb']) : $this->fdata['inv_amb'];

        $data['inv_item'] = (isset($this->post['inv_item'])) ? trim($this->post['inv_item']) : $this->fdata['inv_item'];

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        
        $data['filters'] = ($this->post['filters']) ? $this->post['filters'] : 'yes';

        
        ////////////////////////////////////
        

       

        ////////////////////////////// Set page number /////////////////////////

        $pg_no = 1;

        if ($this->uri->segment(3)) {
            $pg_no = $this->uri->segment(3);
        } else if ($this->fdata['pg_no'] && !$this->post['flt']) {
            $pg_no = $this->fdata['pg_no'];
        }

        /////////////////////////// Set limit & offset /////////////////////////


        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


        $data['get_count'] = TRUE;
        
        
      
       // $data['item_total'] = $this->inv_model->get_inv($data);
        $data['item_total'] = $this->maintenance_part_model->get_maintenance_part_list($data);


        $pg_no = get_pgno($data['item_total'], $limit, $pg_no);


        $offset = ($pg_no == 1) ? 0 : ($pg_no * $limit) - $limit;

        //////////////////////////////////////////////////////////////////

        $data['pg_no'] = $pg_no;

        $invflt['INV'] = $data;

        $this->session->set_userdata('filters', $invflt);

        ///////////////////////////////////////////////////////////////////

        unset($data['get_count']);

      
        
        //$data['item_list'] = $this->inv_model->get_inv($data, $offset, $limit);
        $data['item_list'] = $this->maintenance_part_model->get_maintenance_part_list($data, $offset, $limit);




        $data['cur_page'] = $pg_no;

        $pgconf = array(
            'url' => base_url("maintenance_part/list_maintenance_part"),
            'total_rows' => $data['item_total'],
            'per_page' => $limit,
            'cur_page' => $pg_no,
            'attributes' => array('class' => 'click-xhttp-request',
            'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        $data['pagination'] = get_pagination($pgconf);


$this->output->add_to_position($this->load->view('frontend/maintenance_part/maintenance_part_list_view', $data, TRUE), $this->post['output_position'], TRUE);
        

        if($data['filters'] != 'no'){
            //$this->output->add_to_position($this->load->view('frontend/maintenance_part/inv_filters_view', $data, TRUE), 'inv_filters', TRUE);    
        }
    }
    
    function add_maintenance_part(){
              $data['inv_type'] = $this->fdata['inv_type'];


        if ($this->post['submit_inv']) {

            $inv_info = array('mt_part_title' => addslashes($this->post['mt_part_title']),
                'mt_part_base_quantity' => $this->post['mt_part_base_quantity'],
                'Item_Code' => $this->post['Item_Code'],
                'mt_part_type' => $this->post['mt_part_type'],
                'make' => $this->post['make'],
                'mt_part_added_date' => date('Y-m-d H:i:s'),
                'mt_part_status' => '1',
                'mt_part_deleted' => '0');


            $ins = $this->maintenance_part_model->insert_maintenance_part_data($inv_info);

            if ($ins) {

                $this->output->status = 1;
                $this->output->closepopup = "yes";
                $this->output->message = "<div class='success'>Item added successfully</div>";

                $this->invlist();
            } else {

                $this->output->message = "<div class='error'>Something going wring</div>";
            }
        } else {

            $data['action'] = "add";

            $this->output->add_to_position($this->load->view('frontend/maintenance_part/add_maintenance_part_view', $data, TRUE), $this->post['output_position'], TRUE);
        }
    }
        function manage_maintenance_part() {

        $data['inv_type'] = $this->post['inv_type'];

        if ($this->post['submit_inv']) {

            $this->post['inv_stock']['stk_inv_type'] = $data['inv_type'];

            $this->post['inv_stock']['stk_handled_by'] = $this->clg->clg_ref_id;

            $this->post['inv_stock']['stk_base_month'] = $this->post['base_month'];

            $this->post['inv_stock']['stk_in_out'] = 'in';

            $this->post['inv_stock']['stk_date'] = ($this->post['inv_stock']['stk_date']) ? date('Y-m-d', strtotime($this->post['inv_stock']['stk_date'])) : $this->today;

            $ins = $this->maintenance_part_model->insert_stock($this->post['inv_stock']);
          //  var_dump($data['inv_type']);
         //  die();
            

            if ($ins) {

                $this->output->status = 1;
                $this->output->closepopup = "yes";
                $this->output->message = "<div class='success'>Stock added successfully</div><script>$('.rst_flt').click();</script>";
            } else {

                $this->output->message = "<div class='error'>Something going wrong</div>";
            }
        } else {


             $item_field = "<input type='text' name='inv_stock[stk_inv_id]'  value='' class='mi_autocomplete filter_required' data-href='" . base_url() . "auto/get_maintance_part_items/'  data-errors=\"{filter_required:'Please select item name from dropdown list'}\"  tabindex='1'>";
            

            /////////////////////////////////////////////////////////////////////////

            $this->output->add_to_position($this->load->view('frontend/maintenance_part/add_stock_view', $data, TRUE), $this->post['output_position'], TRUE);

            $this->output->add_to_position($item_field, 'item_type', TRUE);
        }
    }
    function maintance_type_change_item_list(){
        $data['maintance_type'] = $this->post['id'];
     
        $this->output->add_to_position($this->load->view('frontend/maintenance_part/maintance_type_change_item_view', $data, TRUE), $this->post['output_position'], TRUE);
      //  $this->output->add_to_position($this->load->view('frontend/maintenance_part/maintance_type_change_item_hidden_view', $data, TRUE), $this->post['output_position'], TRUE);
    }


}